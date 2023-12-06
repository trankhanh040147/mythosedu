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
  <img src="/wp-content/uploads/2023/12/cloud1.svg" alt="" class="__cloud1 position-fixed">
  <img src="/wp-content/uploads/2023/12/cloud2.svg" alt="" class="__cloud2 position-fixed">
  <!-- <img src="/wp-content/uploads/2023/12/cloud3.svg" alt="" class="__cloud3 position-absolute"> -->
  <img src="/wp-content/uploads/2023/12/cloud4.svg" alt="" class="__cloud4 position-fixed">
  <!-- <img src="/wp-content/uploads/2023/12/cloud5.svg" alt="" class="__cloud5 position-absolute"> -->
  <section class="__header">
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
  </section>
  <section class="__level">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-12 col-md-10  line-level">
      <div class="col-12 __level8">
        <div class="col-4 d-flex flex-column __box-level8">
          <div><a href="#" class="__link8"><img src="/wp-content/uploads/2023/12/level8.svg" alt="" class="__img-level8 __img-level"></a></div>
          <div><img src="/wp-content/uploads/2023/12/icon-address-level.svg" alt="" class="icon-address-level1"></div>
        </div>
      </div>
      <div class="col-12 d-flex justify-content-center __level7">
        <div class="col-4 d-flex flex-column align-items-center">
          <div> <a href="#" class="__link7"><img src="/wp-content/uploads/2023/12/level7.svg" alt="" class="__img-level"></a></div>
          <div><img src="/wp-content/uploads/2023/12/icon-address-level.svg" alt="" class="icon-address-level7"></div>
        </div>
      </div>
      <div class="col-12 d-flex justify-content-end __level6">
        <div class="col-4 d-flex flex-column align-items-end  __box-level6">
          <div><a href="#" class="__link6"><img src="/wp-content/uploads/2023/12/level6.svg" alt="" class="__img-level __img-level6"></a></div>
          <div><img src="/wp-content/uploads/2023/12/icon-address-level.svg" alt="" class="icon-address-level6"></div>
        </div>
      </div>
      <div class="col-12 d-flex justify-content-center __level5">
        <div class="col-4 d-flex align-items-end ms-5">
          <div><img src="/wp-content/uploads/2023/12/icon-address-level.svg" alt="" class="icon-address-level5"></div>
          <div><a href="#" class="__link5"><img src="/wp-content/uploads/2023/12/level5.svg" alt="" class="__img-level __img-level5"></a></div>
        </div>
      </div>
      <div class="col-12 d-flex justify-content-start __level4">
        <div class="col-4 d-flex flex-column justify-content-center  __box-level4">
          <div><a href="#" class="__link4"><img src="/wp-content/uploads/2023/12/level4.svg" alt="" class="__img-level __img-level4"></a></div>
          <div><img src="/wp-content/uploads/2023/12/icon-address-level.svg" alt="" class="icon-address-level4"></div>
        </div>
      </div>
      <div class="col-12 d-flex justify-content-end __level3">
        <div class="col-4 d-flex   align-items-center justify-content-end __box-2">
          <div><img src="/wp-content/uploads/2023/12/icon-address-level.svg" alt=""></div>
          <div><a href="#" class="__link3"><img src="/wp-content/uploads/2023/12/level2.svg" alt="" class="__img-level"></a></div>
        </div>
      </div>
      <div class="col-12 d-flex justify-content-center __level2">
        <div class="col-4 d-flex align-items-end justify-content-center __box-level3">
          <div class="box-img-level3"><img src="/wp-content/uploads/2023/12/icon-address-level.svg" alt="" class="mb-3"></div>
          <div  class="box-img-address3"><a href="#" class="__link2"><img src="/wp-content/uploads/2023/12/level3.svg" alt="" class="__img-level"></a></div>
   
        </div>
      </div>

      <div class="col-12 d-flex justify-content-end __level1">
        <div class="col-4 d-flex flex-column align-items-center j ">
          <div class="box-img-level1"><img src="/wp-content/uploads/2023/12/icon-address-level-active.svg" alt="" class="__level-active"></div>
          <div class="box-img-address1"><a href="#" class="__link1"><img src="/wp-content/uploads/2023/12/level1.svg" alt="" class="__img-level"></a></div>
        </div>
      </div>
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
