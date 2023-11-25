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
  <title>
    <?php wp_title();
            echo ' - ';
            bloginfo('name'); ?>
  </title>
  <?php wp_head(); ?>
  <!-- Custom styles for this template -->

  <link href="<?php echo THEME_URL; ?>/dist/css/slick.css?ver=<?php echo $_VERSION_SKIN;?>" rel="stylesheet" />
  <link href="<?php echo THEME_URL; ?>/assets/css/animate.css?ver=<?php echo $_VERSION_SKIN;?>" rel="stylesheet" />
  <link href="<?php echo THEME_URL; ?>/component/css/common.css?ver=<?php echo $_VERSION_SKIN;?>" rel="stylesheet" />
  <link href="<?php echo THEME_URL; ?>/component/css/custome_style.css?ver=<?php echo $_VERSION_SKIN;?>"
    rel="stylesheet" />
  <link href="<?php echo THEME_URL; ?>/component/css/custome_style_ky.css?ver=<?php echo $_VERSION_SKIN;?>"
    rel="stylesheet" />
  <link href="<?php echo THEME_URL; ?>/component/css/custom-themes.css?ver=<?php echo $_VERSION_SKIN;?>"
    rel="stylesheet" />

</head>

<body <?php body_class(); ?> style = "
  <?php echo $style_bg;?> " >
  <?php /*
<!-- Loading -->
<div id="loading">
    <div class="spinner-border text-danger" role="status">
    <span class="visually-hidden">Loading...</span>
    </div>
</div>
<!-- ./ Loading -->
*/

  
