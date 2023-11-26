<?php
/**
 * PaidMembershipsPro class
 *
 * @author: themeum
 * @author_uri: https://themeum.com
 * @package Tutor
 * @since v.1.3.5
 */

namespace TUTOR_PMPRO;

if ( ! defined( 'ABSPATH' ) )
    exit;

class PaidMembershipsPro {

    public function __construct() {
        add_action('pmpro_membership_level_after_other_settings', array($this, 'display_courses_categories'));
        add_action('pmpro_save_membership_level', array($this, 'pmpro_settings'));
        add_filter('tutor_course/single/add-to-cart', array($this, 'tutor_course_add_to_cart'));
        add_filter('tutor_course_price', array($this, 'tutor_course_price'));
        add_filter('tutor-loop-default-price', array($this, 'add_membership_required'));

        add_filter('tutor/course/single/entry-box/free', array($this, 'pmpro_pricing'), 10, 2 );
        add_filter('tutor/course/single/entry-box/is_enrolled', array($this, 'pmpro_pricing'), 10, 2 );
        add_action('tutor/course/single/content/before/all', array($this, 'pmpro_pricing_single_course'), 100, 2 );
		add_filter('tutor/options/attr', array($this, 'add_options'));
        
        if(tutor_utils()->has_pmpro(true)){
            // Remove price column if PM pro used
            add_filter( "manage_" . tutor()->course_post_type . "_posts_columns", array($this, 'remove_price_column'), 11,1 );

            // Add categories column to pm pro level table
            add_action( 'pmpro_membership_levels_table_extra_cols_header', array($this, 'level_category_list') );
            add_action( 'pmpro_membership_levels_table_extra_cols_body', array($this, 'level_category_list_body') );
            add_filter( 'pmpro_membership_levels_table', array($this, 'outstanding_cat_notice'));
            add_action( 'wp_enqueue_scripts', array($this, 'pricing_style') );
        }
    }

    public function remove_price_column($columns = array()) {
        
        if(isset($columns['price'])) {
            unset($columns['price']);
        }

        return $columns;
    }

    public function display_courses_categories(){
        include_once TUTOR_PMPRO()->path."views/pmpro-content-settings.php";
    }

    /**
     * pmpro tutor settings saving
     */
    public function pmpro_settings( $level_id ){

        if(!isset($_POST['tutor_action']) || $_POST['tutor_action']!='pmpro_settings') {
            return;
        }

        $tutor_pmpro_membership_model = sanitize_text_field(tutor_utils()->array_get('tutor_pmpro_membership_model', $_POST));
        $highlight_level = sanitize_text_field(tutor_utils()->array_get('tutor_pmpro_level_highlight', $_POST));

        if ($tutor_pmpro_membership_model){
			update_pmpro_membership_level_meta( $level_id, 'tutor_pmpro_membership_model', $tutor_pmpro_membership_model);
        }

        if($highlight_level && $highlight_level==1) {
            update_pmpro_membership_level_meta( $level_id, 'tutor_pmpro_level_highlight', 1);
        } else {
            delete_pmpro_membership_level_meta( $level_id, 'tutor_pmpro_level_highlight' );
        }
    }

    public function add_options($attr) {
        $attr['tutor_pmpro'] = array(
            'label'    => __( 'PM Pro', 'tutor' ),
            'slug'     => 'pm-pro',
            'desc'     => __('Paid Membership', 'tutor-pro'),
            'template' => 'basic',
            'icon'     => 'tutor-icon-brand-paid-membersip-pro',
            'blocks'   => array(
                array(
                    'label'      => __( '', 'tutor' ),
                    'slug'       => 'pm_pro',
                    'block_type' => 'uniform',
					'fields' => array(
                        array(
                            'key'     => 'pmpro_moneyback_day',
                            'type'    => 'number',
                            'label'   =>  __('Moneyback gurantee in', 'tutor-pro'),
                            'default'   => '0',
							'desc'      => __('Days in you gurantee moneyback. Set 0 for no moneyback.', 'tutor-pro'),
                        ),
                        array(
                            'key'     => 'pmpro_no_commitment_message',
                            'type'    => 'text',
                            'label'   =>  'No commitment message',
                            'default'   => '',
							'desc'      => __('Keep empty to hide', 'tutor-pro'),
                        ),
                    )
                )
            )
        );

        return $attr;
    }

    private function required_levels($term_ids, $check_full = false) {

        global $wpdb;
        $cat_clause = count($term_ids) ? ($check_full ? ' OR ' : '') . " (meta.meta_value='category_wise_membership' AND cat_table.category_id IN (" . implode(',', $term_ids) . "))" : "";

        $query_last = ($check_full ? " meta.meta_value='full_website_membership' " : '') . $cat_clause;
        $query_last = (!$query_last || ctype_space($query_last)) ? '' : ' AND ('.$query_last.')';

        return $wpdb->get_results(
            "SELECT DISTINCT level_table.*
            FROM {$wpdb->pmpro_membership_levels} level_table 
                LEFT JOIN {$wpdb->pmpro_memberships_categories} cat_table ON level_table.id=cat_table.membership_id
                LEFT JOIN {$wpdb->pmpro_membership_levelmeta} meta ON level_table.id=meta.pmpro_membership_level_id 
            WHERE 
                meta.meta_key='tutor_pmpro_membership_model' ".$query_last);
    }

    private function has_any_full_site_level() {
        global $wpdb;

        $count = $wpdb->get_var(
            "SELECT level_table.id
            FROM {$wpdb->pmpro_membership_levels} level_table 
                INNER JOIN {$wpdb->pmpro_membership_levelmeta} meta ON level_table.id=meta.pmpro_membership_level_id 
            WHERE 
                meta.meta_key='tutor_pmpro_membership_model' AND 
                meta.meta_value='full_website_membership'"
        );

        return (int)$count;
    }

    /**
     * @return bool
     *
     * Just check if has membership access
     *
     * @since v.1.7.5
     */
    private function has_course_access($course_id, $user_id=null){
        global $wpdb;

        if (!tutor_utils()->has_pmpro(true)){
            // Check if monetization is pmpro and the plugin exists
            return true;
        }

        // Prepare data
        $user_id = $user_id===null ? get_current_user_id() : $user_id;
        $has_course_access = false;

        // Get all membership levels of this user
        $levels = $user_id ? pmpro_getMembershipLevelsForUser( $user_id ) : array();
        !is_array( $levels ) ? $levels = array() : 0;

        // Get course categories by id
        $terms = get_the_terms($course_id, 'course-category');
        $term_ids = array_map(function($term) {
            return $term->term_id;
        }, (is_array($terms) ? $terms : array()));

        $required_cats = $this->required_levels( $term_ids );
        if(is_array($required_cats) && !count($required_cats) && !$this->has_any_full_site_level()) {
            // Has access if no full site level and the course has no category
            return true;
        }

        // Check if any level has access to the course
        foreach( $levels as $level ) {
    
            // Remove enrolment of expired levels
            $endtime = (int) $level->enddate;
            if (0 < $endtime && $endtime < tutor_time()){
                // Remove here
                continue;
            }

            if($has_course_access) {
                // No need further check if any level has access to the course
                continue;
            }

            $model = get_pmpro_membership_level_meta( $level->id, 'tutor_pmpro_membership_model', true );

            if($model == 'full_website_membership') {
                // If any model of the user is full site then the user has membership access
                $has_course_access = true;

            } else if($model == 'category_wise_membership') {
                //Check this course if attached to any category that is linked with this membership
                $member_cats = pmpro_getMembershipCategories($level->id);
                $member_cats = array_map(function($member) {
                    return (int)$member;
                }, (is_array($member_cats) ? $member_cats : array()));

                // Check if the course id in the level category
                foreach($term_ids as $term_id) {
                    if(in_array($term_id, $member_cats)) {
                        $has_course_access = true;
                        break;
                    }
                }
            }
        }

        return $has_course_access ? true : $this->required_levels( $term_ids, true );
    }

    /**
     * @param $html
     *
     * @return mixed|void
     *
     * Enrolment main logic for Membership
     *
     * @since v.1.7.5
     */
    public function add_membership_required($price){
        return !($this->has_course_access(get_the_ID())===true) ? '' : __('Free', 'tutor-pro');
    }

    /**
     * @param $html
     *
     * @return mixed|void
     *
     * Enrolment main logic for Membership
     *
     * @since v.1.3.6
     */
    public function tutor_course_add_to_cart($html){

        $access_require = $this->has_course_access(get_the_ID());
        if($access_require===true){
            // If has membership access, then no need membership require message
            return $html;
        }
        
        return apply_filters('tutor_enrol_no_membership_msg', '');
    }

    public function pmpro_pricing_single_course($course_id) {
        $require = $this->pmpro_pricing(null, $course_id);

        if($require!==null) {
            wp_redirect( get_permalink( $course_id ) );
            exit;
        }
    }

    public function pmpro_pricing($html, $course_id) {
        $required_levels = $this->has_course_access($course_id);

        if($required_levels===true || !count($required_levels)){
            // If has membership access, then no need membership pricing
            return $html;
        }
        
        $level_page_id = apply_filters('tutor_pmpro_level_page_id', pmpro_getOption("levels_page_id"));
        $level_page_url = get_the_permalink($level_page_id);

        extract($this->get_pmpro_currency()); // $currency_symbol, $currency_position

        ob_start();
        include dirname(__DIR__) . '/views/pmpro-pricing.php';
        return ob_get_clean();
    }

    /**
     * @param $html
     *
     * @return string
     *
     * Remove the price if Membership Plan activated
     *
     * @since v.1.3.6
     */
    public function tutor_course_price($html){
        return get_tutor_option('monetize_by') == 'pmpro' ? '' : $html;
    }

    public function level_category_list($reordered_levels) {
        echo '<th>' . __('Recommended') . '</th>';
        echo '<th>' . __('Type') . '</th>';
    }

    public function level_category_list_body($level) {
        $model = get_pmpro_membership_level_meta( $level->id, 'tutor_pmpro_membership_model', true );
        $highlight = get_pmpro_membership_level_meta( $level->id, 'tutor_pmpro_level_highlight', true);

        echo '<td>' . ($highlight ? '<img src="' . TUTOR_PMPRO()->url . 'assets/images/star.svg"/>' : '') . '</td>';

        echo '<td>';

            if($model == 'full_website_membership') {
                echo '<b>' . __('Full Site Membership', 'tutor-pro') . '</b>';
            } else if($model == 'category_wise_membership') {
                echo '<b>' . __('Category Wise Membership', 'tutor-pro') . '</b><br/>';

                $cats = pmpro_getMembershipCategories($level->id);

                if(is_array($cats) && count($cats)) {
                    global $wpdb;
                    $terms = $wpdb->get_results("SELECT * FROM {$wpdb->terms} WHERE term_id IN (". implode(',', $cats) .")");
                    $term_links = array_map(function($term) { return '<small>' . $term->name . '</small>'; }, $terms);
                    
                    echo implode(', ', $term_links);
                }
            }

        echo '</td>';
    }

    private function get_pmpro_currency() {

        global $pmpro_currencies, $pmpro_currency;
        $current_currency = $pmpro_currency ? $pmpro_currency : '';
        $currency = $current_currency=='USD' ? 
                                array('symbol' => '$') : 
                                (isset($pmpro_currencies[$current_currency]) ? $pmpro_currencies[$current_currency] : null);

        $currency_symbol = (is_array( $currency ) && isset( $currency['symbol'] )) ? $currency['symbol'] : '';
        $currency_position = (is_array( $currency ) && isset( $currency['position'] )) ? strtolower( $currency['position'] ) : 'left';
             
        return compact('currency_symbol', 'currency_position');
    }

    public function outstanding_cat_notice($html) {
        global $wpdb;

        // Get all categories from all levels
        $level_cats = $wpdb->get_col(
            "SELECT cat.category_id 
            FROM {$wpdb->pmpro_memberships_categories} cat 
                INNER JOIN {$wpdb->pmpro_membership_levels} lvl ON lvl.id=cat.membership_id"
        );
        !is_array($level_cats) ? $level_cats = array() : 0;
        
        // Get all categories and check if exist in any level.
        $outstanding = array();
        $course_cats = get_terms('course-category', array('hide_empty'=>false));
        foreach($course_cats as $cat) {
            !in_array($cat->term_id, $level_cats) ? $outstanding[] = $cat : 0; 
        }

        ob_start();
        
        extract($this->get_pmpro_currency()); // $currency_symbol, $currency_position
        include dirname( __DIR__ ). '/views/outstanding-catagory-notice.php';

        return $html . ob_get_clean();
    }

    public function pricing_style() {
        if(is_single_course()) {
            wp_enqueue_style( 'tutor-pmpro-pricing', TUTOR_PMPRO()->url . 'assets/css/pricing.css' );
        }
    }
}