<?php

/**
 * Created by PhpStorm.
 * User: Bessfu
 * Date: 11/6/19
 * Time: 3:15 PM
 */
$tutor_frontend_background_image_custom = tutor_utils()->get_option( 'tutor_frontend_background_image_custom' );
if($tutor_frontend_background_image_custom)	$style_bg = " background-image: url(".wp_get_attachment_url($tutor_frontend_background_image_custom).")!important; ";
$_VERSION_SKIN="1.0.1";
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title();
            echo ' - ';
            bloginfo('name'); ?></title>
    <?php wp_head(); ?>
    <!-- Custom styles for this template -->

    <link href="<?php echo THEME_URL; ?>/dist/css/slick.css?ver=<?php echo $_VERSION_SKIN;?>" rel="stylesheet" />
    <link href="<?php echo THEME_URL; ?>/assets/css/animate.css?ver=<?php echo $_VERSION_SKIN;?>" rel="stylesheet" />
    <link href="<?php echo THEME_URL; ?>/component/css/common.css?ver=<?php echo $_VERSION_SKIN;?>" rel="stylesheet" />
    <link href="<?php echo THEME_URL; ?>/component/css/custome_style.css?ver=<?php echo $_VERSION_SKIN;?>" rel="stylesheet" />
    <link href="<?php echo THEME_URL; ?>/component/css/custome_style_ky.css?ver=<?php echo $_VERSION_SKIN;?>" rel="stylesheet" />
</head>

<body <?php body_class(); ?>   style = " <?php echo $style_bg;?> " >
    <?php /*
<!-- Loading -->
<div id="loading">
    <div class="spinner-border text-danger" role="status">
    <span class="visually-hidden">Loading...</span>
    </div>
</div>
<!-- ./ Loading -->
*/
    global $___IS_LOGGED;
    $___IS_LOGGED = is_user_logged_in();
    ?>

    <!-- Header -->
    <header class="et-l et-l--header">
        <div class="et_builder_inner_content et_pb_gutters3">
            <div class="et_pb_section et_pb_section_0_tb_header et_pb_sticky_module et_section_regular">

                <div class="et_pb_row et_pb_row_0_tb_header et_pb_equal_columns et_pb_row_1-4_3-4">
                    <div
                        class="et_pb_column et_pb_column_1_4 et_pb_column_0_tb_header  et_pb_css_mix_blend_mode_passthrough">

                        <div class="et_pb_module et_pb_image et_pb_image_0_tb_header">

                            <a href="<?php echo site_url();?>"><span
                                    class="navbar-brand et_pb_image_wrap __logo">
                                    <img loading="lazy" width="284" height="57"
                                        src="<?php echo THEME_URL; ?>/component/img/logo.svg" alt=""
                                        title="vus-logo-sticky" class="wp-image-10"></span>
                            </a>
                        </div>
                    </div>
                    <div
                        class="et_pb_column et_pb_column_3_4 et_pb_column_1_tb_header  et_pb_css_mix_blend_mode_passthrough et-last-child">

                        <div
                            class="et_pb_module et_pb_search et_pb_search_0_tb_header ___header_search  et_pb_text_align_left et_pb_bg_layout_light">

                            <form role="search" method="get" class="et_pb_searchform" action="<?php echo SITE_URL; ?>">
                                <div>
                                    <label class="screen-reader-text" for="s">Search for:</label>
                                    <input type="text" name="s" placeholder="Search for anything" class="et_pb_s">
                                    <input type="hidden" name="et_pb_searchform_submit" value="et_search_proccess">

                                    <input type="hidden" name="et_pb_include_posts" value="yes">
                                    <input type="hidden" name="et_pb_include_pages" value="yes">
                                    <input type="submit" value="Search" class="et_pb_searchsubmit" style="">
                                </div>
                            </form>
                        </div>
                        <div class="et_pb_module et_pb_code et_pb_code_0_tb_header ___header_right">

                            <nav class="navbar navbar-expand-lg">
                                <div class="container-fluid p-0 ___header_container">

                                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <div class="collapse navbar-collapse et_pb_code_inner" id="navbarSupportedContent">

                                        <ul class="___right_menu_lst">
											<?php if (!current_user_can( 'administrator' )&&!current_user_can( 'shop_manager' )) { ?>
                                            <li class="___right_menu_item"><a href="/courses"><?php  _e('Courses', TPL_DOMAIN_LANG);?></a></li>
											<?php }?>

                                            <?php
                                            // '/dashboard/enrolled-courses'   -> Your learning
                                            if ($___IS_LOGGED) { ?>
											<?php if (current_user_can( 'subscriber' )) { ?>
                                            
                                            <?php }} else { ?>
                                            <li class="___right_menu_item __btn _bg_red _btn_radius"><a
                                                    href="<?php echo __MY_ACCOUNT; ?>"> <?php _e('Log in', TPL_DOMAIN_LANG);?></a></li>
                                            <?php } ?>

                                            <li class="___right_menu_item __max_icons"><a href="/cart"><img
                                                        src="<?php echo THEME_URL; ?>/component/img/cart.svg"></a></li>

                                            <?php
                                            $__USER_LINK_LOGIN = "";
                                            if ($___IS_LOGGED) {
                                                $__USER_LINK_LOGIN = "/dashboard";
                                            ?>
                                            <li class="___right_menu_item __max_icons"><a
                                                    href="<?php echo $__USER_LINK_LOGIN; ?>"><img
                                                        src="<?php echo THEME_URL; ?>/component/img/user.svg"></a></li>
                                            <?php } ?>
											<?php
											//if (current_user_can( 'administrator' )||current_user_can( 'shop_manager' )) {
                                            if (current_user_can( 'administrator' )) {
                                                $__USER_LINK_ADMIN = "/wp-admin";
                                            ?>
                                            <li class="___right_menu_item __max_icons"><a
                                                    href="<?php echo $__USER_LINK_ADMIN; ?>"><img
                                                        src="<?php echo THEME_URL; ?>/component/img/admin.png"></a></li>
                                            <?php } ?>

                                            <li class="___right_menu_item __max_icons"><a href="#"><img
                                                        src="<?php echo THEME_URL; ?>/component/img/en-flag.svg"></a>
                                            </li>
                                        </ul>

                                        <?php
                                        /*
                    wp_nav_menu(array(
                        'menu'  => 'Header Menu',
                        'container' => '', // Leaving it empty removes the <div> container.
                        'menu_class'=> 'navbar-nav  mr-auto ___right_menu_lst',
                        'add_li_class'  => 'nav-item'
                    ));
                */
                                        ?>

                                    </div>
                            </nav>
                        </div>
                    </div>




                </div>


            </div>
        </div>
    </header>





    <!-- ./ Header -->