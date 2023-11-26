<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 2/3/20
 * Time: 9:53 AM
 */

namespace CoreSystem\Admin\Sites;


use CoreSystem\Admin\Core_System_Admin;
use CoreSystem\Helpers\BFDB;

class New_Site{

    private $modules = [];

    private $query = [];

    public function __construct()
    {

        add_action('network_site_new_form', [$this, 'network_site_new_form']);
        add_filter('wpmu_welcome_notification', [$this, 'wpmu_welcome_notification'], 100, 5);
        add_filter('wpmu_drop_tables', [$this, 'wpmu_drop_tables'], 100, 2);
        remove_all_actions('network_site_new_created_user');
        $this->new_site();
    }

    function new_site(){
        global $wp_version;
        if( version_compare($wp_version, '5.0.0', '>=') ){
            add_action('wp_initialize_site', [$this, 'wp_initialize_site'], 100, 2);

        }else {
            add_action('wpmu_new_blog', [$this, 'wpmu_new_blog'], 100, 6);
        }
    }

    function wpmu_welcome_notification($blog_id, $user_id, $password, $title, $meta){
        return false;
    }

    function get_module(){
        return $this->modules;
    }

    function add_module($module){
        if( is_array($module) && !empty($module) ) {
            $this->modules = array_merge($module, $this->modules);
        }
    }

    function wpmu_drop_tables($tables, $blog_id) {
        if ($blog_id > 1) {
            global $wpdb;
            $prefix = $wpdb->get_blog_prefix($blog_id);

            $sql = "SHOW TABLES LIKE '{$prefix}%'";
            $results = $wpdb->get_results($sql, ARRAY_N);

            foreach ($results as $result) {
                $sql = "DROP TABLE IF EXISTS `{$result[0]}`";
                $wpdb->query($sql);
            }
        }
    }

    function wp_initialize_site(\WP_Site $site, array $args = []){
        wp_cache_delete( $_POST['blog']['email'], 'useremail' );
        $modules = isset($_POST['module']) ? wp_slash($_POST['module']) : [];
        $blog_id = $site->blog_id;

        $this->add_more_table($blog_id);
        $this->add_fields_table_users($blog_id);
        $this->add_fields_table_posts($blog_id);

        switch_to_blog($blog_id);
        $this->add_role();
        $this->add_pages($modules);
        $dbManager = new BFDB($blog_id);
        $dbManager->db->users = $dbManager->get_table_name("users");
        $dbManager->db->usermeta = $dbManager->get_table_name("usermeta");
        $user_id = $this->create_admin_site($_POST['blog']);
        $dbManager->db->users = "users";
        $dbManager->db->usermeta = "usermeta";
        restore_current_blog();
        $this->insert_after_create_table($blog_id, $user_id);
        Core_System_Admin::update_database($blog_id);

        do_action('app/new_site/initialize_site', $blog_id);
    }

    function create_admin_site($data) {
        $email = isset($data['email']) ? $data['email'] : '';
        $password = isset($data['user_pass']) ? $data['user_pass'] : $email;
        $display_name = isset($data['display_name']) ? $data['display_name'] : '';
        $last_name = $first_name = '';
        $user = get_user_by( 'email', $email);
        if( $user ){
            $user_login = $user->user_login;
        }else{
            $position = strpos( $email, '@' );
            $user_login = mb_substr($email, 0, $position);
        }
        if( !empty($display_name) ) {
            $explode_name = explode(" ", $display_name);
            $count_name = count($explode_name);
            if ($count_name > 0) {
                $last_name = end($explode_name);
                unset($explode_name[$count_name - 1]);
                $first_name = implode(" ", $explode_name);
            } else {
                $first_name = "";
                $last_name = $display_name;
            }
        }

        $user_id = wp_insert_user([
            "user_pass" => $password,
            "user_login" => $user_login,
            "user_email" => $email,
            "display_name" => $display_name,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "role" => CORES_ROLE_ROOT,
        ]);
        return $user_id;
    }

    function wpmu_new_blog($blog_id, $user_id, $domain, $path, $site_id, $meta)
    {
        $modules = isset($_POST['module']) ? wp_slash($_POST['module']) : [];
        $this->add_more_table($blog_id);
        $this->add_fields_table_users($blog_id);
        $this->add_fields_table_posts($blog_id);
        Core_System_Admin::update_database($blog_id);
        switch_to_blog($blog_id);
        $this->add_role();
        $this->add_pages($modules);
        restore_current_blog();
        $this->insert_after_create_table($blog_id, $user_id);

        do_action('app/new_site/initialize_site', $blog_id);
    }

    function add_table_by_kpi($blog_id){
        $dbManager = new BFDB($blog_id);
        $prefix = $dbManager->get_prefix();

        $this->query[] = "
          CREATE TABLE IF NOT EXISTS `{$prefix}years` ( 
          `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key: {years}.id for years.' , 
          `year` INT UNSIGNED NOT NULL COMMENT 'The parent of id column this table' , 
          `status` ENUM('draft','publish') NOT NULL DEFAULT 'draft' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'Years of task kpi';
          ";

        $this->query[] = "
          CREATE TABLE `{$prefix}date_expired_kpi` ( 
          `id` INT NOT NULL AUTO_INCREMENT , 
          `year_id` INT UNSIGNED NOT NULL , 
          `month` INT UNSIGNED NOT NULL , 
          `date` DATE NOT NULL DEFAULT '0000-00-00' , 
          PRIMARY KEY (`id`)) ENGINE = InnoDB;
          ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}units` ( 
          `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key: {unit}.id.' , 
          `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'The parent of id column this table' , 
          `alias` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
          `menu_order` INT UNSIGNED NOT NULL DEFAULT '0' , 
          `unit_modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'Unit';
          ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}formulas` ( 
          `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key: {formulas}.id for formulas.' , 
          `formula_title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
          `formulas` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
          `note` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
          `formula_type` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
          `menu_order` INT UNSIGNED NOT NULL DEFAULT '0' , 
          `formula_modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
          ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}years_kpi` ( 
          `id` INT NOT NULL AUTO_INCREMENT , 
          `year_id` INT UNSIGNED NOT NULL ,  
          `finance` INT UNSIGNED NOT NULL , 
          `customer` INT UNSIGNED NOT NULL , 
          `operate` INT UNSIGNED NOT NULL , 
          `development` INT UNSIGNED NOT NULL , 
          `parent` INT UNSIGNED NOT NULL , 
          `diagram_id` INT UNSIGNED NOT NULL , 
          `structure_id` INT UNSIGNED NOT NULL ,  
          `year_modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
          ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}kpi_assign` ( 
          `id` BIGINT NOT NULL AUTO_INCREMENT , 
          `year_kpi_id` INT UNSIGNED NOT NULL ,  
          `pid` INT UNSIGNED NOT NULL COMMENT 'ID in posts table' ,
          `plan` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, 
          `unit_id` INT UNSIGNED NOT NULL , 
          `structure_id` INT UNSIGNED NOT NULL , 
          `uid` INT(10) NOT NULL DEFAULT '0',
          `parent` INT(11) UNSIGNED NOT NULL DEFAULT '0',
          `diagram_id` INT(10) NOT NULL DEFAULT '0', 
          `priority` INT UNSIGNED NOT NULL , 
          `receive` DATE NOT NULL DEFAULT '0000-00-00',
          `kpi_type` ENUM('','finance','customer','operate','development') NOT NULL COMMENT 'enum(\'finance\', \'customer\', \'operate\', \'development\', \'\')' , 
          `status` ENUM('draft','pending-draft','publish') NOT NULL DEFAULT 'draft' , 
          `required` ENUM('yes','no') NOT NULL DEFAULT 'yes' , 
          `owner` ENUM('yes','no') NOT NULL DEFAULT 'no' COMMENT 'mục tiêu cho bản thân enum(\'yes\', \'no\')' , 
          `influence` ENUM('yes','no') NOT NULL DEFAULT 'no' COMMENT 'Mục tiêu ảnh hưởng enum(\'yes\', \'no\')' , 
          `create_by` ENUM('node_start','node_middle','node_end') NOT NULL DEFAULT 'node_start' COMMENT 'Được tạo từ cấp enum(\'node_start\', \'node_middle\', \'node_end\')' ,
          `is_kpi_year` ENUM('yes','no') NOT NULL DEFAULT 'no' ,
          `file_id` VARCHAR(255) NULL COMMENT 'id in post_id with post_type attchment table' ,
          `comment` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
          `menu_order` INT UNSIGNED NOT NULL DEFAULT '0' , 
          `modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'kpi_assign';
          ";


        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}kpi_assign_for_user` ( 
          `id` BIGINT NOT NULL AUTO_INCREMENT , 
          `precious` TINYINT UNSIGNED NOT NULL DEFAULT '0' , 
          `month` TINYINT UNSIGNED NOT NULL DEFAULT '0' ,
          `kpi_assign_id` BIGINT UNSIGNED NOT NULL , 
          `plan` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
          `priority` INT UNSIGNED NOT NULL ,
          `uid` INT UNSIGNED NOT NULL COMMENT 'ID in users table' , 
          `result` VARCHAR(255) NULL DEFAULT NULL , 
          `receive` DATE NOT NULL DEFAULT '0000-00-00',
          `file_id` VARCHAR(255) NULL COMMENT 'id in post_id with post_type attchment table' , 
          `status` VARCHAR(20) NOT NULL DEFAULT 'draft' ,
          `preview` BOOLEAN NULL DEFAULT FALSE,
          `comment` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
          `modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
        ";

        $this->query[] = "
          CREATE TABLE IF NOT EXISTS `{$prefix}kpi_competency` ( 
          `id` BIGINT NOT NULL AUTO_INCREMENT , 
          `year_id` INT UNSIGNED NOT NULL , 
          `pid` INT UNSIGNED NOT NULL , 
          `apply_for` ENUM('manage','employee') NOT NULL DEFAULT 'manage' , 
          `plan` VARCHAR(255) NULL COMMENT 'Kế hoạch đặt ra' , 
          `priority` INT UNSIGNED NOT NULL DEFAULT '0' , 
          `structure_id` INT UNSIGNED NOT NULL , 
          `competency_type` ENUM('year','criteria','process-result') NOT NULL DEFAULT 'year' , 
          `competency_type_kpi` ENUM('', 'company','department') NOT NULL DEFAULT '' ,
          `note` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL , 
          `status` ENUM('draft','publish') NOT NULL DEFAULT 'draft' , 
          `menu_order` INT UNSIGNED NOT NULL DEFAULT '0' , 
          `modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
          ";


        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}kpi_competency_for_user` ( 
          `id` BIGINT NOT NULL AUTO_INCREMENT , 
          `kpi_competency_id` BIGINT UNSIGNED NOT NULL , 
          `uid` INT UNSIGNED NOT NULL , 
          `result` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
          `status` VARCHAR(20) NOT NULL DEFAULT 'draft' ,
          `note` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
          `modified` INT NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
          ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}kpi_competency_assessment` ( 
          `id` BIGINT NOT NULL AUTO_INCREMENT , 
          `year_id` INT UNSIGNED NOT NULL , 
          `uid` INT UNSIGNED NOT NULL COMMENT 'ID in users table' , 
          `trend` ENUM('reduced','stable','increased') NOT NULL DEFAULT 'stable' , 
          `comment` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
          `modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
          ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}years_behavior` ( 
          `id` INT NOT NULL AUTO_INCREMENT , 
          `year_id` INT NOT NULL , 
          `parent` INT NOT NULL DEFAULT '0' , 
          `priority` INT NOT NULL DEFAULT '0' COMMENT 'Trọng số của thái độ hành vi',
          `year_modified` INT NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
          ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}behavior_assign` ( 
          `id` INT NOT NULL AUTO_INCREMENT , 
          `year_behavior_id` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'id of year_behavior table' , 
          `pid` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'ID in posts table' , 
          `structure_id` INT UNSIGNED NOT NULL DEFAULT '0' , 
          `menu_order` INT UNSIGNED NOT NULL DEFAULT '0' , 
          `modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' ,
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
          ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}behavior_assign_for_user` ( 
          `id` INT NOT NULL AUTO_INCREMENT , 
          `behavior_assign_id` INT UNSIGNED NOT NULL ,
          `precious` TINYINT UNSIGNED NOT NULL DEFAULT '0' , 
          `month` TINYINT UNSIGNED NOT NULL DEFAULT '0' ,  
          `uid` INT UNSIGNED NOT NULL COMMENT 'ID in users table' , 
          `violations` INT NOT NULL COMMENT 'Số lần vi phạm' , 
          `status` VARCHAR(20) NOT NULL DEFAULT 'draft' , 
          `comment` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
          `modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
          ";
    }

    function add_table_by_hrm($blog_id){
        $dbManager = new BFDB($blog_id);
        $prefix = $dbManager->get_prefix();
        /**
         * Add table leave
         */

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}leave` (
          `id` BIGINT NOT NULL AUTO_INCREMENT , 
          `author` INT UNSIGNED NOT NULL COMMENT ' ID in table users ' ,
          `uid` INT UNSIGNED NOT NULL COMMENT 'ID in table users' , 
          `start_date` DATE NOT NULL , 
          `end_date` DATE NOT NULL , 
          `half_day` TEXT NULL DEFAULT NULL , 
          `option_half_day` TEXT NULL DEFAULT NULL , 
          `number_of_dates` REAL UNSIGNED NOT NULL , 
          `content` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
          `uid_receive` INT UNSIGNED NOT NULL COMMENT 'ID in table users' ,
          `send_cc` LONGTEXT  CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
          `type_of_leave` INT UNSIGNED NOT NULL COMMENT 'id in table timekeeping_type' , 
          `status` VARCHAR(20) NOT NULL DEFAULT 'draft' , 
          `approval_uid` INT NOT NULL DEFAULT '0',
          `approval_date` INT UNSIGNED NULL , 
          `leave_modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
        ";

        /**
         * Add table business
         */

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}business` (
          `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          `author` INT UNSIGNED NOT NULL COMMENT ' ID in table users ' , 
          `uid` INT UNSIGNED NOT NULL COMMENT ' ID in table users ' , 
          `start_date` DATE NOT NULL , 
          `end_date` DATE NOT NULL , 
          `number_of_dates` DOUBLE UNSIGNED NOT NULL , 
          `content` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
          `uid_receive` INT UNSIGNED NOT NULL COMMENT 'ID in table users' , 
          `send_cc` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
          `status` VARCHAR(20) NOT NULL DEFAULT 'draft' , 
          `approval_uid` INT NOT NULL DEFAULT '0' COMMENT 'ID in table users' , 
          `approval_date` INT UNSIGNED NOT NULL , 
          `advance_payment` DOUBLE UNSIGNED NOT NULL , 
          `detail_fields` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
          `cost_fields` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
          `business_modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
        ";

        /**
         * Add table timekeeping
         */
        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}timekeeping` (
            `uid` INT UNSIGNED NOT NULL COMMENT 'ID in table users ' , 
            `year` INT(11) NOT NULL DEFAULT 0, 
            `month` INT(11) NOT NULL DEFAULT 0, 
            `number_of_working_day` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
            `data` TEXT NOT NULL DEFAULT '', 
            `created` INT(11) NOT NULL DEFAULT '1517725800', 
            `updated` INT NOT NULL DEFAULT '1517725800' , 
            PRIMARY KEY (`uid`, `month`, `year`))
            ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'Chấm công';
        ";

        $this->query[] = "
            CREATE TABLE IF NOT EXISTS `{$prefix}salary` (
                `uid` INT UNSIGNED NOT NULL COMMENT 'ID in table users ' , 
                `month` INT UNSIGNED NOT NULL,
                `year` INT UNSIGNED NOT NULL, 
                `effective_salary_with_tax` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `effective_salary_without_tax` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `additional_pay_with_tax` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `additional_pay_without_tax` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `substract_pay_with_tax` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `substract_pay_without_tax` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `collect_arrears` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `union_allowance` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `social_insurance` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `medical_insurance` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `accident_insurance` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `union_fee` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `personal_tax` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `paid_date` INT(11) NOT NULL DEFAULT 0, 
                `company_social_insurance` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `company_medical_insurance` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `company_accident_insurance` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `company_union_fee` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `number_of_working_days` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `overtime` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `tax_allowance` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `none_tax_allowance` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `tax_income` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `none_tax_income` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `basic_salary` DOUBLE UNSIGNED NOT NULL DEFAULT 0, 
                `note` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '', 
                `gross_pay` DOUBLE UNSIGNED NOT NULL,
                `net_pay` DOUBLE UNSIGNED NOT NULL,
                `created` INT NOT NULL DEFAULT '1517725800' , 
                `updated` INT NOT NULL DEFAULT '1517725800' , 
                PRIMARY KEY (`uid`, `month`, `year`)) 
            ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'Bảng Lương';
        ";


        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}timekeeping_type` (
            `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
            `title` varchar(255) NOT NULL DEFAULT '',
            `symbol` varchar(255) NOT NULL default '',
            `description` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
            `working_day` FLOAT NOT NULL DEFAULT 1,
            `status` varchar(255) NOT NULL DEFAULT '',
            `created` INT NOT NULL DEFAULT '1517725800' , 
            `updated` INT NOT NULL DEFAULT '1517725800' , 
            PRIMARY KEY (`id`)) 
            ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'Bảng Lương';
        ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}overtime` ( 
            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT, 
            `uid` INT UNSIGNED NOT NULL COMMENT ' ID in table users' , 
            `date` DATE NOT NULL DEFAULT '0000-00-00' , 
            `from` TIME NOT NULL DEFAULT '00:00' , 
            `to` TIME NOT NULL DEFAULT '00:00' , 
            `number_of_hours` DOUBLE NOT NULL , 
            `coefficient_pay` DOUBLE NOT NULL DEFAULT 1, 
            `content` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
            `uid_receive` INT UNSIGNED NOT NULL COMMENT ' ID in table users' , 
            `send_cc` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
            `status` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'draft' ,
            `approval_uid` INT NOT NULL DEFAULT '0' COMMENT ' ID in table users' , 
            `approval_date` INT UNSIGNED NOT NULL , 
            `overtime_modified` INT NOT NULL DEFAULT '1517725800' , 
            PRIMARY KEY (`id`)) 
            ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'Chấm công ngoài giờ';
        ";
    }

    function add_table_by_competency($blog_id){
        $dbManager = new BFDB($blog_id);
        $prefix = $dbManager->get_prefix();

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}assign_structure` ( 
        `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key: {assign_structure}.id for assign structure.' , 
        `post_id` INT UNSIGNED NOT NULL DEFAULT '0', 
        `structure_id` INT UNSIGNED NOT NULL DEFAULT '0', 
        `type` ENUM('group', 'item') NULL DEFAULT 'item' , 
        `percent` DOUBLE NOT NULL DEFAULT '0' ,
        `year` INT UNSIGNED NOT NULL DEFAULT '0', 
        `assign_status` ENUM('publish', 'trash') NULL DEFAULT 'publish', 
        `created` DATE NOT NULL DEFAULT '0000-00-00',
        PRIMARY KEY (`id`)) 
        ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
        ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}assign_standard` ( 
        `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key: {assign_standard}.id for assign standard.' , 
        `assign_structure_id` INT UNSIGNED NOT NULL DEFAULT '0', 
        `important` ENUM('1', '2', '3') NOT NULL DEFAULT '1' , 
        `standard` ENUM('1', '2', '3', '4', '5') NOT NULL DEFAULT '1' , 
        `status` ENUM('publish', 'trash') NULL DEFAULT 'publish', 
        `created` DATE NOT NULL DEFAULT '0000-00-00',
        PRIMARY KEY (`id`)) 
        ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
        ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}estimate_ability` ( 
        `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key: {estimate_ability}.id for estimate ability.' , 
        `user_id` INT UNSIGNED NOT NULL DEFAULT '0', 
        `assign_standard_id` INT UNSIGNED NOT NULL DEFAULT '0', 
        `manager_lv1` ENUM('0', '1', '2', '3', '4', '5') NOT NULL DEFAULT '0', 
        `manager_lv0` ENUM('0', '1', '2', '3', '4', '5') NOT NULL DEFAULT '0', 
        `type` ENUM('normal', 'level_up') NOT NULL DEFAULT 'normal', 
        `lv` INT UNSIGNED NOT NULL DEFAULT '0', 
        PRIMARY KEY (`id`)) 
        ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
        ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}assign_level_up` ( 
        `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key: {assign_level_up}.id for assign level up.', 
        `assign_author` INT UNSIGNED NOT NULL DEFAULT '0',
        `user_id` INT UNSIGNED NOT NULL DEFAULT '0', 
        `structure_id_old` INT UNSIGNED NOT NULL DEFAULT '0', 
        `structure_id_new` INT UNSIGNED NOT NULL DEFAULT '0', 
        `year` INT UNSIGNED NOT NULL DEFAULT '0',
        `status` ENUM('publish','finish-quiz','failed','success','trash') NOT NULL DEFAULT 'publish', 
        `created` DATE NOT NULL DEFAULT '0000-00-00',
        PRIMARY KEY (`id`)) 
        ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
        ";

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}comments_efficiency` ( 
        `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key: {comments_efficiency}.id for comments efficiency.' , 
        `comment_content` VARCHAR(255) NOT NULL DEFAULT '', 
        `comment_author` INT UNSIGNED NOT NULL DEFAULT '0', 
        `user_id` INT UNSIGNED NOT NULL DEFAULT '0', 
        `parent` INT UNSIGNED NOT NULL DEFAULT '0', 
        `comment_status` ENUM('publish', 'trash') NOT NULL DEFAULT 'publish', 
        `comment_type` ENUM('assign_efficiency', 'assign_level_up') NOT NULL DEFAULT 'assign_efficiency', 
        `comment_year` INT UNSIGNED NOT NULL DEFAULT '0', 
        `created` DATE NOT NULL DEFAULT '0000-00-00',
        PRIMARY KEY (`id`)) 
        ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;
        ";
    }

    function add_more_table($blog_id){
        $dbManager = new BFDB($blog_id);
        $prefix = $dbManager->get_prefix();
        $charset_collate = $dbManager->db->get_charset_collate();
        $max_index_length = 191;
        $errors = [];
        $dbManager->start_transaction();

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}login_logs`(
          `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          `user_id` BIGINT(20) UNSIGNED NOT NULL,
          `action` ENUM('loggedin', 'logout', 'expired') CHARACTER SET utf8 NOT NULL,
          `at_time` datetime NOT NULL,
          `browser` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}diagram_company` ( 
          `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key: {diagram_company}.id for diagram_company.' ,  
          `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'The name of diagram company.' , 
          `menu_order` INT NOT NULL DEFAULT '0' , 
          `parent` INT NOT NULL DEFAULT '0' COMMENT 'The parent of id column in diagram_company' ,
          `modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'Diagram of company';";
        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}organizational_structure` ( 
          `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key: {organizational_structure}.id for organizational_structure.' , 
          `diagram_id` INT NOT NULL COMMENT 'It is id column in diagram company' , 
          `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'The name of organizational structure of company.' , 
          `menu_order` INT NOT NULL DEFAULT '0' , 
          `parent` INT NOT NULL DEFAULT '0' COMMENT 'The parent of id column this table' ,
          `kpi_for` ENUM('','precious','month') NOT NULL ,
          `kpi_influence` BOOLEAN NOT NULL ,
          `modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' ,  
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'Organizational Structure of company';";
        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}after_promote` ( 
          `id` INT NOT NULL AUTO_INCREMENT , 
          `author` INT UNSIGNED NOT NULL , 
          `uid` INT UNSIGNED NOT NULL , 
          `year_id` INT(11) NOT NULL DEFAULT '0', 
          `structure_old` INT UNSIGNED NOT NULL , 
          `structure_new` INT UNSIGNED NOT NULL , 
          `status` ENUM('','done') NULL DEFAULT '' , 
          `modified` INT UNSIGNED NOT NULL DEFAULT '1517725800' , 
          PRIMARY KEY (`id`)) 
          ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";

        #$this->add_table_by_hrm($blog_id);
        #$this->add_table_by_kpi($blog_id);
        #$this->add_table_by_competency($blog_id);

        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}users` (
          ID bigint(20) unsigned NOT NULL auto_increment,
          user_login varchar(60) NOT NULL default '',
          user_pass varchar(255) NOT NULL default '',
          user_nicename varchar(50) NOT NULL default '',
          user_email varchar(100) NOT NULL default '',
          user_url varchar(100) NOT NULL default '',
          user_registered datetime NOT NULL default '0000-00-00 00:00:00',
          user_activation_key varchar(255) NOT NULL default '',
          user_status int(11) NOT NULL default '0',
          display_name varchar(250) NOT NULL default '',
          PRIMARY KEY  (ID),
          KEY user_login_key (user_login),
          KEY user_nicename (user_nicename),
          KEY user_email (user_email)
        ) $charset_collate;\n";
        // Usermeta.
        $this->query[] = "CREATE TABLE IF NOT EXISTS `{$prefix}usermeta` (
          umeta_id bigint(20) unsigned NOT NULL auto_increment,
          user_id bigint(20) unsigned NOT NULL default '0',
          meta_key varchar(255) default NULL,
          meta_value longtext,
          PRIMARY KEY  (umeta_id),
          KEY user_id (user_id),
          KEY meta_key (meta_key($max_index_length))
        ) $charset_collate;\n";

        foreach ($this->query as $sql){
            $dbManager->db->query($sql);
            if( !empty($dbManager->db->last_error) ){
                $errors[] = $dbManager->db->last_error;
            }
        }


        if( !empty($errors) ) {
            $dbManager->rollback();
            return $errors;
        }else{
            $dbManager->commit();
        }
    }

    function add_fields_table_users($blog_id){
        $dbManager = new BFDB($blog_id);

        $dbManager->start_transaction();

        $dbManager->add_column('users', ['name' => 'parent', 'query' => 'BIGINT UNSIGNED DEFAULT 0 AFTER `display_name`;']);
        $dbManager->add_column('users', ['name' => 'structure_id', 'query' => 'BIGINT UNSIGNED DEFAULT 0 AFTER `parent`;']);
        $dbManager->add_column('users', ['name' => 'role_id', 'query' => 'BIGINT UNSIGNED DEFAULT NULL AFTER `structure_id`;']);
        $dbManager->add_column('users', ['name' => 'user_code', 'query' => 'TEXT NULL DEFAULT NULL AFTER `structure_id`;']);
        $dbManager->add_column('users', ['name' => 'phone_number', 'query' => 'TEXT NULL DEFAULT NULL AFTER `user_code`;']);
        $dbManager->add_column('users', ['name' => 'spam', 'query' => 'tinyint(2) NOT NULL DEFAULT \'0\';']);
        $dbManager->add_column('users', ['name' => 'deleted', 'query' => ' tinyint(2) NOT NULL DEFAULT \'0\';']);

        $dbManager->commit();

    }

    function add_fields_table_posts($blog_id){
        $dbManager = new BFDB($blog_id);

        $dbManager->start_transaction();

        $dbManager->add_column('posts', ['name' => 'post_code', 'query' => 'TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `comment_count`;']);
        $dbManager->add_column('posts', ['name' => 'structure_id', 'query' => 'INT NULL DEFAULT \'0\' AFTER `comment_count`;']);
        $dbManager->add_column('posts', ['name' => 'formula_id', 'query' => 'TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `post_code`;']);
        $dbManager->add_column('posts', ['name' => 'diagram_id', 'query' => 'INT NULL DEFAULT \'0\' AFTER `post_year`;']);

        $dbManager->commit();

    }

    function insert_after_create_table($blog_id, $user_id){
        $dbManager = new BFDB($blog_id);
        $dbManager->start_transaction();
        $dbManager->db->insert("{$dbManager->get_prefix()}diagram_company", ['name' => 'Tên Công Ty', 'parent' => 0]);
        if($dbManager->db->last_error != '') {
            $dbManager->rollback();
            return $dbManager->db->last_error;
        }
        $dbManager->commit();
        $this->user_insert_after_crete_table($blog_id, $user_id);
    }

    function user_insert_after_crete_table($blog_id, $user_id){
        $dbManager = new BFDB($blog_id);
        $prefix = $dbManager->get_prefix();
        switch_to_blog($blog_id);
        restore_current_blog();
        $errors = [];
        if( $user_id > 0 ) {
            $sql = $dbManager->db->prepare("SELECT * FROM {$dbManager->db->users} WHERE ID = %s", $user_id);
            $user = $dbManager->db->get_row($sql, ARRAY_A);
            ob_start();
            /*$GLOBALS['_create_blog_tables']['get_user_by_id_' . $user_id] = $user;
            $GLOBALS['_create_blog_tables']['get_user_by_id_' . $user_id . '_error'] = $wpdb->last_error;*/
            if (is_array($user)) {
                //Tạo password default
                $user['user_pass'] = wp_hash_password($user['user_email']);
                $sql = $dbManager->db->prepare("UPDATE {$dbManager->db->users} SET `user_pass` = %s, `user_activation_key` = '' WHERE `ID` = %d", $user['user_pass'], $user['ID']);
                $dbManager->db->query( $sql );
                if( !empty($dbManager->db->last_error) ){
                    $errors[] = $dbManager->db->last_error;
                }
                unset($user['ID']);

                $sql = $dbManager->db->prepare("SELECT COUNT(*) FROM `{$prefix}users` WHERE `user_email` LIKE %s", $user['user_email']);
                $exists = $dbManager->db->get_var($sql);
                /*$GLOBALS['_create_blog_tables']["user_email_{$user['user_email']}_exists"] = $exists;
                $GLOBALS['_create_blog_tables']["user_email_{$user['user_email']}_exists_sql"] = $wpdb->last_query;*/
                if (empty($exists)) {
                    $res = $dbManager->db->insert("{$prefix}users", $user);
                    /*$GLOBALS['_create_blog_tables']['insert_user_by_id_' . $user_id] = $res;
                    $GLOBALS['_create_blog_tables']['insert_user_by_id_' . $user_id . '_id'] = $wpdb->insert_id;
                    $GLOBALS['_create_blog_tables']['insert_user_by_id_' . $user_id . '_last_query'] = $wpdb->last_query;
                    $GLOBALS['_create_blog_tables']['insert_user_by_id_' . $user_id . '_error'] = $wpdb->last_error;*/
                    if (!empty($dbManager->db->last_error)) {
                        $errors[] = $dbManager->db->last_error;
                    }
                    if ($res) {
                        $sql = $dbManager->db->prepare("SELECT * FROM {$dbManager->db->usermeta} WHERE `user_id` = %s", $user_id);
                        $metas = $dbManager->db->get_results($sql, ARRAY_A);
                        /*$GLOBALS['_create_blog_tables']['get_user_meta_by_id_' . $user_id] = $metas;
                        $GLOBALS['_create_blog_tables']['get_user_meta_by_id_' . $user_id . '_error'] = $wpdb->last_error;*/
                        $new_user_id = $dbManager->db->insert_id;
                        if (!empty($metas)) {
                            foreach ($metas as $row) {
                                $row['user_id'] = $new_user_id;
                                if( $row['meta_key'] == $prefix . 'capabilities' ){
                                    $row['meta_value'] = maybe_serialize([CORES_ROLE_ROOT => true]);
                                }
                                unset($row['umeta_id']);
                                $res = $dbManager->db->insert("{$prefix}usermeta", $row);
                                /*$GLOBALS['_create_blog_tables']['insert_usermeta_by_id_' . $user_id] = $res;
                                $GLOBALS['_create_blog_tables']['insert_usermeta_by_id_' . $user_id . '_data'] = $row;
                                $GLOBALS['_create_blog_tables']['insert_usermeta_by_id_' . $user_id . '_id'] = $wpdb->insert_id;
                                $GLOBALS['_create_blog_tables']['insert_usermeta_by_id_' . $user_id . '_error'] = $wpdb->last_error;*/
                                if (!empty($dbManager->db->last_error)) {
                                    $errors[] = $dbManager->db->last_error;
                                }
                            }
                        }
                    }
                }
            }
        }

        if( !empty($errors) ){
            $dbManager->rollback();
            return $errors;
        }
        $dbManager->commit();
    }

    function add_role(){
        /***
         * Add role
         */
        add_role(
            CORES_ROLE_ROOT,
            __( 'Admin site', CORES_LANG_DOMAIN ),
            array(
                'read'         => true,  // true allows this capability
                'edit_posts'   => true,
                'list_users'   => true,
                'edit_files'   => true,
                'export'   => true,
                'import'   => true,
                'upload_files'   => true,
                'edit_users'   => true,
                'unfiltered_html'   => true,
                'create_users'   => true,
                'delete_users'  => true,
                'delete_others_pages' => true,
                'delete_others_posts' => true,
                'delete_pages'          => true,
                'delete_posts'         => true,
                'delete_private_pages'         => true,
                'delete_private_posts'         => true,
                'delete_published_pages'         => true,
                'delete_published_posts'         => true,
                'edit_others_pages'         => true,
                'edit_others_posts'         => true,
                'edit_pages'         => true,
                'edit_private_pages'         => true,
                'edit_private_posts'         => true,
                'edit_published_pages'         => true,
                'edit_published_posts'         => true,
                'publish_pages'         => true,
                'publish_posts'         => true,
                'read_private_pages'         => true,
                'read_private_posts'         => true,
                'remove_users'         => true,
                'core_access_profile_page' => true,
            )
        );

        add_role(
            CORES_ROLE_MANAGER,
            __( 'Role Manager', CORES_LANG_DOMAIN ),
            array(
                'read'         => true,  // true allows this capability
                'create_posts'  => true,
                'edit_posts'   => true,
                'upload_files'   => true,
                'unfiltered_html'   => true,
                'core_access_profile_page' => true,
                /*'core_register_leave'           => true,
                'core_register_business'           => true,
                'core_register_overtime'           => true,
                'core_approve_leave'           => true,
                'core_approve_business'           => true,
                'core_approve_overtime'           => true,*/
            )
        );

        add_role(
            CORES_ROLE_EMPLOYER,
            __( 'Role Employer', CORES_LANG_DOMAIN ),
            array(
                'read'         => true,  // true allows this capability
                'create_posts'  => true,
                'edit_posts'   => true,
                'upload_files'   => true,
                'unfiltered_html'   => true,
                'core_access_profile_page' => true,
               /* 'core_register_leave'           => true,
                'core_register_business'           => true,
                'core_register_overtime'           => true,*/
            )
        );
    }

    function add_pages($modules){

        $pages_data = [
            'home' => [
                'post_title' =>         __('Home page', CORES_LANG_DOMAIN),
                'post_name' =>          __('Home page', CORES_LANG_DOMAIN),
                'post_type' =>          'page',
                'post_status' =>        'publish',
                'page_template' =>      "page-home-page.php"
            ],
            /*'settings' => [
                'post_title' =>         __('Settings', CORES_LANG_DOMAIN),
                'post_name' =>          __('page-settings', CORES_LANG_DOMAIN),
                'post_type' =>          'page',
                'post_status' =>        'publish',
                'page_template' =>      "page-settings.php"
            ],*/
        ];
        $has_module = [];
        if( !empty($modules) ){
            foreach ($modules as $module){
                if( isset($this->modules[$module]) ){
                    $post_title = $this->modules[$module];
                    $post_name = sanitize_title($post_title);
                    $pages_data[$module] = [
                        'post_title' =>        $post_title,
                        'post_name' =>          $post_name,
                        'post_content' =>       '',
                        'post_type' =>          'page',
                        'post_status' =>        'publish',
                        'page_template' =>      "module/{$module}/index.php"
                    ];
                    $has_module[$module] = true;
                }else{
                    $has_module[$module] = false;
                }
            }
        }

        if( !empty($pages_data) ) {
            foreach ($pages_data as $type => $attr) {
                $page = get_page_by_path($attr['post_name'], OBJECT, 'page');
                if ($page === null) {
                    $attr['ID'] = wp_insert_post($attr);
                    if (!empty($attr['ID']) && !is_wp_error($attr['ID'])) {
                        update_post_meta($attr['ID'], '_wp_page_template', $attr['page_template']);
                    }

                } else if ($page instanceof \WP_Post) {
                    $attr['ID'] = $page->ID;
                    wp_update_post($attr);
                }
                if ($type == 'home' && is_numeric($attr['ID'])) {
                    update_option('show_on_front', 'page');
                    update_option('page_on_front', $attr['ID']);
                }
            }
            #update_option( 'rewrite_rules', '' );
            update_option('permalink_structure', '/%postname%/');
            update_option('stylesheet', 'app');
            update_option('template', 'app');
            /*$steps = [
                'steps' => [
                    'step_1' => 1,
                    'step_2' => 0,
                    'step_3' => 0,
                ],
                'current_step' => 1,
                'config_status' => 0
            ];

            update_option('bf_config_step', $steps);*/

            if( isset($has_module['hrm']) ){
                $settings_working = [
                    'monday' => [
                        'status-working' => 'all-day',
                        'check-in' => '08:00',
                        'check-out' => '17:30',
                        'coefficients-pay' => 1,
                    ],
                    'tuesday' => [
                        'status-working' => 'all-day',
                        'check-in' => '08:00',
                        'check-out' => '17:30',
                        'coefficients-pay' => 1,
                    ],
                    'wednesday' => [
                        'status-working' => 'all-day',
                        'check-in' => '08:00',
                        'check-out' => '17:30',
                        'coefficients-pay' => 1,
                    ],
                    'thursday' => [
                        'status-working' => 'all-day',
                        'check-in' => '08:00',
                        'check-out' => '17:30',
                        'coefficients-pay' => 1,
                    ],
                    'friday' => [
                        'status-working' => 'all-day',
                        'check-in' => '08:00',
                        'check-out' => '17:30',
                        'coefficients-pay' => 1,
                    ],
                    'saturday' => [
                        'status-working' => 'off',
                        'check-in' => '',
                        'check-out' => '',
                        'coefficients-pay' => 1,
                    ],
                    'sunday' => [
                        'status-working' => 'off',
                        'check-in' => '',
                        'check-out' => '',
                        'coefficients-pay' => 1,
                    ],
                ];
                update_option('settings_software', ['quantity_annual_leave' => 12]);
                update_option('settings_working', $settings_working);
            }
        }

        add_option('_has_module', $has_module);
    }

    function network_site_new_form(){
        echo "<table class=\"form-table\" role=\"presentation\">";
        echo "<tr class=\"form-field\">
            <th scope=\"row\"><label for=\"user_pass\">" . __( 'Mật khẩu', CORES_LANG_DOMAIN ) . "</label></th>
            <td><input name=\"blog[user_pass]\" type=\"password\" value='' class=\"regular-text form-control\" id=\"user_pass\" data-autocomplete-field=\"user_pass\" aria-describedby=\"user_pass\" /></td>
            </tr>";
        echo "<tr class=\"form-field\">
            <th scope=\"row\"><label for=\"display_name\">" . __( 'Họ và tên', CORES_LANG_DOMAIN ) . "</label></th>
            <td><input name=\"blog[display_name]\" type=\"text\" value='' class=\"regular-text form-control\" data-autocomplete-field=\"display_name\" aria-describedby=\"display_name\" /></td>
            </tr>";
        foreach ($this->modules as $key => $module){
            echo "<tr class=\"form-field\">
            <th scope=\"row\"><label for=\"{$key}-module\">" . __( $module, CORES_LANG_DOMAIN ) . "</label></th>
            <td><input name=\"module[]\" type=\"checkbox\" value='{$key}' class=\"regular-text\" id=\"{$key}-module\" data-autocomplete-field=\"{$key}-module\" aria-describedby=\"site-{$key}-module\" /></td>
            </tr>";
        }
        echo "</table>";
    }
}