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
function enqueue_my_scripts() {
	wp_enqueue_script('my-script-3', get_template_directory_uri() . '/assets/js/swiper.js', array('jquery'), '1.2', false);
}

// Gắn action để chạy chức năng
add_action('wp_enqueue_scripts', 'enqueue_my_scripts');

function enqueue_my_styles() {
  
wp_enqueue_style('my-style', get_template_directory_uri() . '/assets/css/swiper.min.css', array(), '1.1', 'all');
}
// Gắn action để chạy chức năng
add_action('wp_enqueue_scripts', 'enqueue_my_styles');

function tutor_course_categories_shortcode($atts) {
    ob_start();

    // Kiểm tra xem plugin Tutor LMS đã được kích hoạt hay chưa
    if (class_exists('TUTOR')) {
        // Lấy danh sách các danh mục khóa học
        $course_categories = tutor()->course->get_categories();

        if ($course_categories) {
            ?>
            <div class="swiper swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($course_categories as $category) : ?>
                        <div class="swiper-slide">
                            <h2><?php echo esc_html($category->name); ?></h2>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <script>
                var swiper = new Swiper('.swiper-container', {
                    slidesPerView: 3,
      spaceBetween: 30,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
                });
            </script>
            <?php
        }
    }

    return ob_get_clean();
}
add_shortcode('tutor_course_categories', 'tutor_course_categories_shortcode');
