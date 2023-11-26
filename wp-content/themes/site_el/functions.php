<?php
/**
 * Created by PhpStorm.
 * Date: 11/6/19
 * Time: 3:15 PM
 */
if (!defined('SITE_URL'))
    define('SITE_URL', site_url());
if (!defined('__MY_ACCOUNT'))
    define('__MY_ACCOUNT',  '/my-account');
if (!defined('THEME_DIR'))
    define('THEME_DIR', dirname(__FILE__));
if (!defined('THEME_URL'))
    define('THEME_URL', get_template_directory_uri());
define('DIR_INC', THEME_DIR .'/inc');
if (!defined('TPL_DOMAIN_LANG'))
    define('TPL_DOMAIN_LANG', 'dashboard');
/**
 * Template Site only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
    #require get_template_directory() . '/inc/back-compat.php';
    return;
}

add_filter( 'wp_title', 'wpdocs_hack_wp_title_for_home' );
 
/**
 * Customize the title for the home page, if one is not set.
 *
 * @param string $title The original title.
 * @return string The title to use.
 */
function wpdocs_hack_wp_title_for_home( $title )
{
  if ( empty( $title ) && ( is_home() || is_front_page() ) ) {
    $title = __( 'Home', 'textdomain' ) . ' - ' . get_bloginfo( 'description' );
  }
  return $title;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function site_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/site
     * If you're building a theme based on Template Site, use a find and replace
     * to change 'site' to the name of your theme in all the template files.
     */
    load_theme_textdomain( TPL_DOMAIN_LANG );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );

    add_image_size( 'site-featured-image', 2000, 1200, true );

    add_image_size( 'site-thumbnail-avatar', 100, 100, true );

    // Set the default content width.
    $GLOBALS['content_width'] = 525;

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus( array(
        'header_top_menu' => __( 'Header Top Menu', 'site' ),
        'primary' => __( 'Top Menu Main', 'site' ),
        'primary_mobile' => __( 'Menu Mobile', 'site' ),
        'primary_menu_footer' => __( 'Footer Menu', 'site' ),
        'social'  => __( 'Social Links Menu', 'site' ),
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    /*
     * Enable support for Post Formats.
     *
     * See: https://codex.wordpress.org/Post_Formats
     */
    add_theme_support( 'post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
    ) );

    // Add theme support for Custom Logo.
    add_theme_support( 'custom-logo', array(
        'width'       => 250,
        'height'      => 250,
        'flex-width'  => true,
        'flex-height'  => true,
    ) );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, and column width.
      */

    // Define and register starter content to showcase the theme on new sites.
    $starter_content = array(
        'widgets' => array(
            // Place three core-defined widgets in the sidebar area.
            'sidebar-1' => array(
                'text_business_info',
                'search',
                'text_about',
            ),

            // Add the core-defined business info widget to the footer 1 area.
            'sidebar-2' => array(
                'text_business_info',
            ),

            // Put two core-defined widgets in the footer 2 area.
            'sidebar-3' => array(
                'text_about',
                'search',
            ),
        ),

        // Specify the core-defined pages to create and add custom thumbnails to some of them.
        'posts' => array(
            'home',
            'about' => array(
                'thumbnail' => '{{image-sandwich}}',
            ),
            'contact' => array(
                'thumbnail' => '{{image-espresso}}',
            ),
            'blog' => array(
                'thumbnail' => '{{image-coffee}}',
            ),
            'homepage-section' => array(
                'thumbnail' => '{{image-espresso}}',
            ),
        ),

        // Create the custom image attachments used as post thumbnails for pages.
        'attachments' => array(
            'image-espresso' => array(
                'post_title' => _x( 'Espresso', 'Theme starter content', 'site' ),
                'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
            ),
            'image-sandwich' => array(
                'post_title' => _x( 'Sandwich', 'Theme starter content', 'site' ),
                'file' => 'assets/images/sandwich.jpg',
            ),
            'image-coffee' => array(
                'post_title' => _x( 'Coffee', 'Theme starter content', 'site' ),
                'file' => 'assets/images/coffee.jpg',
            ),
        ),

        // Default to a static front page and assign the front and posts pages.
        'options' => array(
            'show_on_front' => 'page',
            'page_on_front' => '{{home}}',
            'page_for_posts' => '{{blog}}',
        ),

        // Set the front page section theme mods to the IDs of the core-registered pages.
        'theme_mods' => array(
            'panel_1' => '{{homepage-section}}',
            'panel_2' => '{{about}}',
            'panel_3' => '{{blog}}',
            'panel_4' => '{{contact}}',
        ),

        // Set up nav menus for each of the two areas registered in the theme.
        'nav_menus' => array(
            // Assign a menu to the "top" location.
            'top' => array(
                'name' => __( 'Top Menu', 'site' ),
                'items' => array(
                    'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
                    'page_about',
                    'page_blog',
                    'page_contact',
                ),
            ),

            // Assign a menu to the "social" location.
            'social' => array(
                'name' => __( 'Social Links Menu', 'site' ),
                'items' => array(
                    'link_yelp',
                    'link_facebook',
                    'link_twitter',
                    'link_instagram',
                    'link_email',
                ),
            ),
        ),
    );

    /**
     * Filters Template Site array of starter content.
     *
     * @since Template Site 1.1
     *
     * @param array $starter_content Array of starter content.
     */
    $starter_content = apply_filters( 'site_starter_content', $starter_content );

    add_theme_support( 'starter-content', $starter_content );
    $domain = TPL_DOMAIN_LANG;
    $locale = apply_filters( 'theme_locale', is_admin() ? get_user_locale() : get_locale(), $domain );
    $path = THEME_DIR . '/languages';
    load_theme_textdomain( TPL_DOMAIN_LANG, $path );
    return load_textdomain( $domain, $path . '/' . $locale . '.mo' );
}
add_action( 'after_setup_theme', 'site_setup' );

/**
 * Enqueue scripts and styles.
 */
function site_scripts() {
    // Add custom fonts, used in the main stylesheet.
    #global $site_l10n;
    #$version = "1.0.1";

    // Theme stylesheet.
    wp_enqueue_style( 'site-style', get_stylesheet_uri() );

    // Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
    if ( is_customize_preview() ) {
        wp_enqueue_style( 'site-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'site-style' ), '1.0' );
        wp_style_add_data( 'site-ie9', 'conditional', 'IE 9' );
    }

    // Load the Internet Explorer 8 specific stylesheet.
    wp_enqueue_style( 'site-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'site-style' ), '1.0' );
    wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
    wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/assets/bootstrap/css/bootstrap.css' ), [], '4.1.3' );
    wp_enqueue_style( 'fontawesome-all', get_theme_file_uri( '/assets/font-awesome/css/fontawesome-all.css' ), [], '5.0' );
}
add_action( 'wp_enqueue_scripts', 'site_scripts' );
/*
register_shutdown_function(function() {
    $error = error_get_last();
    if( !empty($error) ) {
        ob_start();
        echo '<div class="error debug-error" style="position: relative;z-index: 9999;"><pre>'; var_dump($error); echo '</pre></div>';
        $output = ob_get_clean();
        @file_put_contents(WP_CONTENT_DIR . '/uploads/' . "error.log", $output);
    }
});*/


session_start(); 

function goto_login_page() {
    $login_page = SITE_URL . __MY_ACCOUNT;
    $page = basename($_SERVER['REQUEST_URI']);
    if( $page == 'wp-login.php' && $_SERVER['REQUEST_METHOD'] =='GET') {
        wp_redirect(home_url('/'));
        exit;
    }


}
add_action('init','goto_login_page');

function login_failed() {
    $login_page = SITE_URL . __MY_ACCOUNT;
    //failed
    $_SESSION["LOGIN_FE_STATUS"]= 'FAILED'; 
    wp_redirect( $login_page );
    exit;
}
add_action('wp_login_failed','login_failed' );

function blank_username_password( $user, $username, $password ) {
    $login_page = SITE_URL . __MY_ACCOUNT;
    if( $username == '' || $password == '' ) {
        //blank
        $_SESSION["LOGIN_FE_STATUS"]= 'BLANK'; 
        wp_redirect( $login_page );
        exit;
    }
}
add_filter('authenticate','blank_username_password', 1, 3);

//echo $login_page = $page_path ;

function logout_page() {
    $login_page = SITE_URL . __MY_ACCOUNT;
    //logout
    $_SESSION["LOGIN_FE_STATUS"]= 'LOGUT'; 
    wp_redirect( home_url('/') );
    exit;
}
add_action('wp_logout','logout_page');



function my_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    //var_dump($user->roles);die();
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if ( in_array( 'administrator', $user->roles ) ) {
            $login_page = SITE_URL . '/wp-admin';
            // redirect them to the default place
            return $login_page;
        } else {
            return home_url('/'); //dashboard
        }
    } else {
        return home_url('/'); //dashboard
    }
    
}

add_action('wp_login','student_login_redirect', 1, 2 );
function student_login_redirect( $user_login, WP_User $user ) {
    if ( current_user_can( 'subscriber' )) {
        wp_redirect( SITE_URL . '/dashboard' );exit;
    }
}

add_filter( 'posts_where', 'courses_search_filter', 10, 2 );
function courses_search_filter( $where, $wp_query ) {
    global $wpdb;
    if ( $search_filter = $wp_query->get( 'search_filter' ) ) {
       $where .= ' AND ((' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_filter ) ) . '%\')
						OR (' . $wpdb->posts . '.tqm_course_code LIKE \'%' . esc_sql( $wpdb->esc_like( $search_filter ) ) . '%\'))';
    }
    return $where;
}

add_filter( 'posts_where', 'draft_special_search_posts_where', 10, 2 );
function draft_special_search_posts_where( $where, $wp_query ) {
    global $wpdb;
    if ( $not_draft_search = $wp_query->get( 'not_draft_search' ) ) {
       $where .= ' AND ((' . $wpdb->posts . '.post_title NOT LIKE \'%' . esc_sql( $wpdb->esc_like( $not_draft_search ) ) . '%\'))';
    }
    return $where;
}
add_action( 'wp_ajax_tutor_json_searchstudents', 'tutor_json_searchstudents');
function tutor_json_searchstudents() {
	global $wpdb;

	$term = sanitize_text_field( tutor_utils()->array_get( 'term', $_POST ) );
	$term = '%' . $term . '%';

	$student_res = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->users} WHERE display_name LIKE %s OR user_email LIKE %s", $term, $term ) );
	$students    = array();
	if ( tutor_utils()->count( $student_res ) ) {
		foreach ( $student_res as $student ) {
			$students[ $student->ID ] = sprintf(
				esc_html__( '%1$s (#%2$s - %3$s)', 'tutor-pro' ),
				$student->display_name,
				$student->ID,
				$student->user_email
			);
		}
	}

	wp_send_json( $students );
}

add_filter('ure_show_additional_capabilities_section', 'ure_show_additional_capabilities_section');
add_filter('ure_bulk_grant_roles',  'ure_show_additional_capabilities_section');

 
function ure_show_additional_capabilities_section($show) {
    $user = wp_get_current_user(); //var_dump($user->roles);
    if (in_array('administrator', $user->roles)) {
        $show = false;
    }

    return $show;
}

add_filter('ure_users_select_primary_role', 'ure_users_select_primary_role', 10, 1);
function ure_users_select_primary_role($select) {

    $user = wp_get_current_user(); //var_dump($user->roles);
    if (in_array('administrator', $user->roles) || in_array('admins', $user->roles) || in_array('tutor_instructor', $user->roles) || in_array('staff', $user->roles)) {
        $select = false;
    }
    
    return $select;
}

add_filter('show_admin_bar', '__return_false');


add_action( 'init', 'blockusers_init' );
function blockusers_init() {
if ( is_admin() && ! current_user_can( 'administrator' ) &&
! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
wp_redirect( home_url() );
exit;
}
}


function custom_get_course() {
    ob_start(); // Start output buffering to capture the shortcode content
    ?>
 <section class="__bg_white pt-4 pb-3 ___cats_tabs_session animate fadeInUp ftco-animated">
            <div class="container">
                <div class="row pt-1 pb-2">
                    <div class="col-md-12 p-0">
                        <h6 class="text-bold" style="color:#B12528 !important;"><?php _e("COURSES",TPL_DOMAIN_LANG); ?></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="cats">
                    <!-- Box 2 -->
                    <div class="___yl_content_box ___yl_certificates_box ___cats_tabs_box">
                        <!-- . -->
                        <div class="___yl_certificates_tab  __course_tabs">
                            <ul class="nav nav-pills mb-3" id="certificates_Tab" role="tablist">
                                <?php
                                $id = 1;
                                $args = array(
                                            'taxonomy' => 'course-category',
                                            'orderby' => 'name',
                                            'order'   => 'ASC'
                                        );

                                $cats = get_categories($args);

                                foreach($cats as $cat) {
                                    //echo get_category_link( $cat->term_id ) 
                                    //echo  $cat->term_id ."--";
                                    $__clsActive_head = "";
                                    if($id == 1) {
                                        $__clsActive_head = " active";
                                    }
                                ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php echo  $__clsActive_head; ?>" id="pills-<?php echo $cat->term_id; ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?php echo  $cat->term_id; ?>"
                                             type="button" role="tab" aria-controls="pills-<?php echo  $cat->term_id; ?>" >
                                             <?php echo $cat->name; ?>
                                        </button>
                                    </li>
                                <?php
                                    $id ++;
                                }
                                ?>
                            </ul>
                            <!------ Tab content -->
                            <div class="tab-content" id="certificates_TabContent">
                        
                                <?php
                                    $idx = 1;
                                    $__clsAct = "";
                                    foreach($cats as $cat) {
                                        //echo get_category_link( $cat->term_id )
                                        if($idx == 1) {
                                            $__clsAct = "show active";
                                        } else {
                                            $__clsAct = "";
                                        }
                                        
                                ?>

                                        <div class="tab-pane fade <?php echo  $__clsAct; ?> " id="pills-<?php echo  $cat->term_id; ?>" role="tabpanel" aria-labelledby="pills-<?php echo  $cat->term_id; ?>-tab">
                                        
                                        <!-- <div class="row pt-1 pb-2">
                                            <div class="col-md-6 ">
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <a href="/courses?course-category=<?php //echo $cat->slug; ?>&course-name=<?php //echo $cat->name; ?>">View all</a>
                                            </div>
                                        </div> -->

                                        <div class="___ranking_table_wrap overflow-auto ___custom_scrollbar">
                                                <div class=" __course_slick __slick_slide ">
                                                        
                                                    
                                                            <?php
                                                            $___postsDat = get_posts(array(
                                                                'post_type' => 'courses',
                                                                'tax_query' => array(
                                                                    array(
                                                                    'taxonomy' => 'course-category',
                                                                    'field' => 'term_id',
                                                                    'terms' =>  $cat->term_id)
                                                                ),
																'meta_query'=>[
																	'relation' => 'OR',
																	[
																	  'key' => '_tutor_course_parent',
																	  'compare' => 'NOT EXISTS',
																	],
																	[
																	  'key' => '_tutor_course_parent',
																	  'compare' => '=',
																	  'value' => ''
																	]
																 ])
                                                            );
                                                            //echo $cat->term_id . "::" . count($___postsDat);
                                                            $cntPosts =  count($___postsDat);
                                                            //var_dump($___postsDat);

                                                            for($i=0; $i < $cntPosts; $i++) {
                                                                $url_img = wp_get_attachment_url( get_post_thumbnail_id($___postsDat[$i]->ID), 'thumbnail' ); 
																$courses_categories = get_the_terms($___postsDat[$i]->ID,'course-category');
																$courses_category_first = ($courses_categories && count($courses_categories))?$courses_categories[0]->name:'Uncategory';
																$_tutor_course_start_date = get_post_meta( $___postsDat[$i]->ID, '_tutor_course_start_date', true);
                                                            ?>
                                                                <!--- render course item -->
                                                               
                                                                <div class="___cert_item __cdetail __border_raiuds_6">
                                                                    
                                                                    <div class="__wishlist"><a href="#"><i class="__ic_heart"></i></a></div>
                                                                    <div class="___cert_item_img"><img src="<?php echo $url_img;?>" alt=""></div>
                                                                    <div class="tutor-d-flex">
																		<span class="__txt_blur"><?php echo $courses_category_first;?></span>
																		<?php
																			$children_ids = get_post_meta( $___postsDat[$i]->ID, '_tutor_course_children', true );
																			$children_ids_arr = array();
																			if($children_ids)
																				$children_ids_arr = explode(" ",trim($children_ids));
																			if (count($children_ids_arr)) {
																		?>
																			<div class="parent_course_icon" style="width:90%;text-align:right">
																				<span class="">
																					<i class="tutor-icon-layer-filled"></i>
																				</span>
																			</div>
																		<?php
																			}
																		?>
																	</div>
                                                                    <div class="___cert_item_title"><a href="/courses/<?php echo $___postsDat[$i]->post_name;?>"><?php echo $___postsDat[$i]->post_title;?></a></div>
                                                                    <div class="___course_date">
                                                                        <?php if($_tutor_course_start_date){?>
																		<i class="_ic_date"></i> <span><?php echo $_tutor_course_start_date;?></span>
																		<?php
																			}
																		?>


                                                                        <?php 
                                                                        $prices = array(
                                                                            'regular_price' => 0,
                                                                            'sale_price'    => 0,
                                                                        );

                                                                        $product_id = $___postsDat[$i]->ID;
                                                                        //echo $product_id;                                                     
                                                                        $price = get_post_meta( $product_id, 'edd_price', true);
                                                                        $price_sale = get_post_meta( $product_id, 'edd_price', true);
                                                                        //echo "--|".$price."--".$price_sale;
                                                                    ?>
                                                                    </div>
                                                                    
                                                                </div>

                                                            <?php
                                                            }

                                                            
                                                            ?>



                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        $idx ++;
                                    }
                                ?>

                                
                        </div>
                        </div>                                        
                        <!-- . -->
                    </div>
                    <!-- ./ Box 2 -->
                    </div>
                </div><!-- ./ row -->
            </div><!-- ./ container -->
        </section>
    <?php
    return ob_get_clean(); // Return the captured content from output buffering
}
add_shortcode('custom_get_course', 'custom_get_course');



function _convert($content) {

    if(!mb_check_encoding($content, 'UTF-8')

        OR !($content === mb_convert_encoding(mb_convert_encoding($content, 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) {



        $content = mb_convert_encoding($content, 'UTF-8');



        if (mb_check_encoding($content, 'UTF-8')) {

            // log('Converted to UTF-8');

        } else {

            // log('Could not converted to UTF-8');

        }

    }

    return $content;

}

function add_or_update_users($data) {

    global $wpdb;

    $u_email = ""; // is email

    if( isset($data[4]) ) {
        $u_email = trim($data[4]);
        $_user_pass = $u_email;
        $_BirthDate = trim($data[3]); // is BirthDate;
        $_gender = trim($data[2]); // echo $_gender;
        $first_name = trim($data[1]); //first_name
        if($_gender == "Nam" || $_gender == "nam") {
            $_gender = "Male";
        }
        if($_gender == "Nữ" || $_gender == "nữ") {
            $_gender = "Female";
        }
        $_DepartmentName = trim($data[5]); // department
        $_user_registered = trim($data[8]); // start date
        $u_phone = trim($data[7]); // is phone
        

        $_user_registered = date('Y-m-d H:i:s', strtotime($_user_registered));
    
        $db_res = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->users} WHERE user_email LIKE %s", $u_email ) );
        $cntData = count($db_res);
        if( $cntData > 0) {
            //update user
            $result = $wpdb->update(
                $wpdb->prefix .'users', 
                array( 
                    'DepartmentName' => $_DepartmentName,
                    'user_registered' => $_user_registered
                ), 
                array(
                    "user_email" => $u_email
                ) 
            );

            $_db_user_id = $db_res[0]->ID; 
            $result = update_user_meta( $_db_user_id, 'gender', $_gender);
            $result = update_user_meta( $_db_user_id, '_tutor_gender', $_gender);
            $result = update_user_meta($_db_user_id,'billing_phone',$u_phone);

            $result = update_user_meta($_db_user_id,'phone_number',$u_phone);
            $result = update_user_meta($_db_user_id,'_tutor_age',$_BirthDate);
            $result = update_user_meta($_db_user_id,'_tutor_profile_job_title',$_DepartmentName);
            $result = add_user_meta($_db_user_id,'_fullname',$first_name);

        } else {
            //echo $_DepartmentName;die();
            // add users
            $userdata = array(
                'user_login' =>  $u_email,
                'user_pass'  =>  $_user_pass, // kiem tra passwords
                'user_email' =>  $u_email,
                'user_registered' =>  $_user_registered,
                'DepartmentName' =>  $_DepartmentName
            );
            
            $user_id = wp_insert_user( ($userdata) ) ;

            $result = $wpdb->update(
                $wpdb->prefix .'users', 
                array( 
                    'DepartmentName' => $_DepartmentName
                ), 
                array(
                    "ID" => $user_id
                ) 
            );


            $result = add_user_meta( $user_id, 'gender', $_gender);
            $result = add_user_meta( $user_id, '_tutor_gender', $_gender);
            $result = add_user_meta($user_id,'billing_phone',$u_phone);

            $result = add_user_meta($user_id,'phone_number',$u_phone);
            $result = add_user_meta($user_id,'_tutor_age',$_BirthDate);
            $result = add_user_meta($user_id,'_tutor_profile_job_title',$_DepartmentName);
            $result = add_user_meta($user_id,'_fullname',$first_name);
        }
    }
    
}


/**
 * Check rank time with current time.
 */
function check_current_time_bettwen_start_end($timestamp_start_date, $timestamp_end_date) {
    $response_check = false;
    $_UTC_7 = 7;
    $current_date = date('Y-m-d');
    $current_hour = (int) date('H') + $_UTC_7; //echo $current_hour . "<br/>"; // Outputs: 1557964800
    $current_min = date('i');
    $current_sec = date('s');

    //$current_date_time = date('Y-m-d H:i:s'); echo $current_date;
    $current_date = $current_date . " " . $current_hour . ":" . $current_min . ":" . $current_sec;
    $timestamp_current_date = strtotime($current_date); //echo $timestamp_current_date . "<br/>"; // Outputs: 1557964800

    // check course in time
    if($timestamp_start_date <= $timestamp_current_date && $timestamp_current_date <= $timestamp_end_date) {

        $response_check = true;
    }

    return $response_check;

}

/**
 * Register a custom menu page.
 */
function wpdocs_register_my_custom_menu_page(){
	add_menu_page( 
		__( 'V-IMPORT', 'domain' ),
		'V-IMPORT',
		'manage_options',
		'vsync',
		'my_v_sync_content_page',
		plugins_url( 'myplugin/images/icon.png' ),
		60
	); 
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );


/**
 * Display a custom menu page
 */
function my_v_sync_content_page(){
    //ob_start(); // Start output buffering to capture the shortcode content
    ?>
    <h2 style="margin-top:60px;"> Import Data:</h2>
    <p>Template file : <a href="/users_template.csv">Template File</a></p>
    <div class="container">
        <form method='post' action='<?= $_SERVER['REQUEST_URI']; ?>' enctype='multipart/form-data'>
            <div class="input-group">
                <div class="custom-file">
                    <label class="custom-file-label" for="customFileInput">Select File:</label>
                    <input type="file" class="custom-file-input" id="customFileInput" name="import_file">
                </div>
                <div class="input-group-append">
                    <input type="submit" name="butimport" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>

    <?php
    // Import CSV
    if(isset($_POST['butimport'])){

        // File extension
        $extension = pathinfo($_FILES['import_file']['name'], PATHINFO_EXTENSION);
    
        // If file extension is 'csv'
        if(!empty($_FILES['import_file']['name']) && $extension == 'csv'){
    
            $totalInserted = 0;
        
            // Open file in read mode
            $csvFile = fopen($_FILES['import_file']['tmp_name'], 'r');
        
            fgetcsv($csvFile); // Skipping header row
        
            // Read file
            $i = 1;
            echo "<ul class='_list_item'>";
            while(($csvData = fgetcsv($csvFile)) !== FALSE) {
                //$csvData = array_map("utf8_encode", $csvData);
                $csvData = _convert($csvData);
        
                // Row column length
                $dataLen = count($csvData);
        
                // // Skip row if length != 4
                // if( !($dataLen == 4) ) continue;
        
                // Assign value to variables
                $Name = trim($csvData[1]);
                $Department = trim($csvData[5]); 
                $Email = trim($csvData[4]); 
                if($Email != "") {
                    echo "<li>" . $i . ". " . $Name . " - " . $Department . " - " . $Email . "</li>"; 
                    add_or_update_users($csvData);
                }

                $i ++;
            }
            echo "</ul>";
        }
    }

}