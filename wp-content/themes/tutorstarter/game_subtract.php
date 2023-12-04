<?php 
/* 
** Template Name: game_subtract
*/ 
get_header("iframe");
?>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 <?php 

    wp_enqueue_style('game_plus_css', get_template_directory_uri() . '/assets/dist/css/game_subtract.css', array(), '1.1', false);

 ?>
</head>
<section class="__demo d-flex  align-items-center">
    <div class="__container mx-auto">
      <div class="row">
        <div class="col-12">
          <div class="col-md-8 col-12">
            <p class="title-plus">Phép trừ</p>
          </div>
        </div>
        <div class="col-12 d-flex align-items-end flex-column flex-md-row __box-plus">
          <div class="col-md-8 col-12 __order2 ps-2 ps-md-4">
            <div class="col-12 d-flex justify-content-center justify-content-md-start align-items-end  __plus">

              <div class="item-select1 position-relative">
                <div class="item-select-after ">

                </div>
                <div class="item bg-disable ">
                </div>
              </div>
              <div>
                <p class="__magic me-3 ">-</p>
              </div>
              <div class="item-select2 position-relative">
                <div class="item-select-after ">

                </div>
                <div class="item bg-disable  ">
                </div>
              </div>
              <div>
                <p class="__magic">=</p>
              </div>
              <div class="position-relative">
                <div class="item-result position-relative">
                  <div class="item-select-after  position-absolute">
                  </div>

                  <div class="item2  position-relative">
                    <p class="__result __text-item"> ?</p>
                  </div>
                  <p class="__alert_true __alert"><img src="/wp-content/uploads/2023/10/btn-true.png" alt=""></p>
                <p class="__alert_false __alert"><img src="/wp-content/uploads/2023/10/btn-false.png" alt=""></p>
                </div>
                
              </div>

            </div>
            <div class="col-12 __option-box d-flex justify-content-center justify-content-md-start"></div>
          </div>
          <div class="col-md-4 col-12 __order1 d-flex justify-content-md-center justify-content-end __box-child"><img
              src="/wp-content/uploads/2023/11/img-child.png" class="__img-child" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="d-flex flex-column">
<video controls="true" id="video-bg" class="d-none" playsinline>
    <source src="/wp-content/uploads/2023/11/video-click.mp4" type="video/mp4">
  </video>
  <video controls="true" id="video-sai" class="d-none" playsinline>
    <source src="/wp-content/uploads/2023/11/sai1.mp4" type="video/mp4">
  </video>
  <video controls="true" id="video-dung" class="d-none" playsinline>
    <source src="/wp-content/uploads/2023/11/dung-update.mp4" type="video/mp4">
  </video>
  <video controls="true" id="video-tingting" class="d-none" playsinline>
    <source src="/wp-content/uploads/2023/11/ting-update.mp4" type="video/mp4">
  </video>
</div>    
<!-- <script  src="<?php //echo get_template_directory_uri(); ?>/assets/dist/js/game_plus.js"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<?php
    // wp_enqueue_script('dragAndDrop-js2', get_template_directory_uri() . '/assets/dist/js/dragAndDrop.js', array('jquery', 'jquery-ui-core', 'jquery-ui-droppable'), '1.5', true);
    wp_enqueue_script('game_plus_js2', get_template_directory_uri() . '/assets/dist/js/game_subtract.js', array(), '1.3', true);
?>

<?php

get_footer("iframe");