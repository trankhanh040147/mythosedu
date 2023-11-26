<?php
  /**
  * Plugin Name: Admin style
  * Plugin URI: BESSFU.com
  * Version: 1.0
  * License: FREE
  */
  // If this file is called directly, abort.
  if ( ! defined( 'WPINC' ) ) { die; }
  function my_admin_theme_style() {
    wp_enqueue_style('my-admin-theme', plugins_url('css/style-admin-page.css', __FILE__));
    wp_enqueue_style('my-admin-theme', plugins_url('css/admin-theme-core.css', __FILE__));
  }
  add_action('admin_enqueue_scripts', 'my_admin_theme_style');
  add_action('login_enqueue_scripts', 'my_admin_theme_style');

  /**
   *  Add logo to admin page
   */
   function dc_admin_logo() {
      echo '<br/><img src="' .plugins_url('img/logo.png', __FILE__). '"/>';
   }
  //add_action( 'admin_notices', 'dc_admin_logo' );

  function wpb_custom_logo() {
  		echo '<style type="text/css">
  		#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
  		background-image: url(' . get_bloginfo('stylesheet_directory') . '/assets/img/logo.png) !important;
  		background-position: 0 0;
  		color:rgba(0, 0, 0, 0);
  		}
  		#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
  		background-position: 0 0;
  		}
  		#wp-admin-bar-wp-logo{display:none!important;}
  		</style>';
  		}

  		//hook into the administrative header output
  		add_action('wp_before_admin_bar_render', 'wpb_custom_logo');

      //hook into the administrative header output
      //add_action('wp_before_admin_bar_render', 'wpb_custom_logo');

  /**
   * Coppyright footer text
   */
   function dc_admin_footer_credits( $text ) {
      $text = '<p>CMS Portal ©2019</p>';
       return $text;
   }
  add_filter( 'admin_footer_text', 'dc_admin_footer_credits' );


  /**
  * Redirect url logo login
  */
  function wpc_url_login(){
  	$home_url= esc_url(home_url('/'));
    return $home_url;
  }
  add_filter('login_headerurl', 'wpc_url_login');

  /**
  * Add logo to page login
  */
  function style_login() {
  	wp_enqueue_style( 'style-login_css', plugins_url() . 'css/style-admin-page.css' );
  ?>
    <style media="screen">
    #login h1 a {
      background-image: url(<?php echo plugins_url('img/logo.png', __FILE__); ?>) !important;
      width: 100%;
      background-size: 130px;
    }

    body.login {background:#5a5c6c}

    #wp-admin-bar-wp-logo{display: none !important;}

    body.login {
      background-image:  url(<?php echo plugins_url('img/login-backgroud.jpg', __FILE__); ?>) !important;
      background-repeat: no-repeat;
      background-size: cover;
    }

    .login form {background: rgba(254, 254, 254, 0.5);}
    #login p a{color: #008EC2 !important;}

    .login form .input,
    .login form input[type="checkbox"],
    .login input[type="text"] {
      background: rgba(254, 254, 254, 0.8) !important;
    }

    #adminmenu li:not(:first-child){display: none !important;}

    .login label {
      color: #333 !important;
      font-size: 15px;
    }

    </style>
  <?php
  }
  add_action('login_head', 'style_login');

   ?>
