<?php 
/* 
** Template Name: course_map
*/ 
get_header("iframe");
?>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 <?php 

    wp_enqueue_style('game_plus_css', get_template_directory_uri() . '/assets/dist/css/course_map.css', array(), '1.3', false);

 ?>
</head>

<div class="__loading"></div>
  <img src="/wp-content/uploads/2023/12/cloud1.svg" alt="" class="__cloud1 position-absolute">
  <img src="/wp-content/uploads/2023/12/cloud2.svg" alt="" class="__cloud2 position-absolute">
  <!-- <img src="/wp-content/uploads/2023/12/cloud3.svg" alt="" class="__cloud3 position-absolute"> -->
  <img src="/wp-content/uploads/2023/12/cloud4.svg" alt="" class="__cloud4 position-absolute">
  <!-- <img src="/wp-content/uploads/2023/12/cloud5.svg" alt="" class="__cloud5 position-absolute"> -->
  <!-- <section class="__header">
    <div class="container ">
      <div class="row">
        <div class="col-12 d-flex ___header-inner justify-content-between ">
          <div class="col-6 d-flex">
            <div class="__me-40">
              <div class="position-relative __box-star">
                <img src="/wp-content/uploads/2023/12/star.svg" alt="" class="img-star">
                <img src="/wp-content/uploads/2023/12/number-start.svg" alt="" class="__number-star">
              </div>
              <div class="position-relative __box-star __box-bottom-star">
                <img src="/wp-content/uploads/2023/12/bottom-start.svg" alt="" class="img-bottom-star">
                <div class="__process position-absolute "></div>
              </div>
            </div>
            <div class="__me-40 d-flex align-items-start">
              <img src="/wp-content/uploads/2023/12/icon-xu.svg" class="___img-xu" alt="">
              <img src="/wp-content/uploads/2023/12/number-xu.svg" alt="" class="__number-xu ms-1 mt-3">
            </div>
            <div class=" d-flex align-items-start">
              <img src="/wp-content/uploads/2023/12/icon-key.svg" class="___img-xu " alt="">
              <img src="/wp-content/uploads/2023/12/number-xu.svg" alt="" class="__number-xu ms-1 mt-3">
            </div>
          </div>
          <div class="col-6 d-flex justify-content-end">
            <div class="position-relative __box-star __me-40">
              <img src="/wp-content/uploads/2023/12/icon-heart.svg" alt="" class="__bg-heart">
              <img src="/wp-content/uploads/2023/12/heart.svg" class="__icon-heart position-absolute" alt="">
              <div class="process2"></div>
            </div>
            <div class=" d-flex __box-star align-items-center">
              <img src="/wp-content/uploads/2023/12/star2.svg" class="___img-xu2 " alt="">
              <img src="/wp-content/uploads/2023/12/number-xu.svg" alt="" class="__number-xu ms-1 mt-1">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <section class="__level">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-12 col-md-10  line-level __mt-5">
          <img src="/wp-content/uploads/2023/12/line.png" alt="" class="__line">
          <?php echo do_shortcode('[load_all_course_hierarchy]'); ?>
</div>
      </div>
    </div>
  </section>
<!-- <script  src="<?php //echo get_template_directory_uri(); ?>/assets/dist/js/game_plus.js"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<?php
    // wp_enqueue_script('dragAndDrop-js2', get_template_directory_uri() . '/assets/dist/js/dragAndDrop.js', array('jquery', 'jquery-ui-core', 'jquery-ui-droppable'), '1.5', true);
    wp_enqueue_script('game_plus_js2', get_template_directory_uri() . '/assets/dist/js/course_map.js', array(), '1.4', true);


?>

<?php

get_footer("iframe");
