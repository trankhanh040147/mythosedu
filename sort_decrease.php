<?php 
/* 
** Template Name: sort_decrease
*/ 
get_header("iframe");
?>

<head>

    <?php 

wp_enqueue_style('game_sort_css', get_template_directory_uri() . '/component/css/sort_decrease.css', array(), '1.2', false);

?>
</head>
<section id="reOrder" class="___body">
      <!-- *** Header *** -->
      <header class="___header ___container">
        <div class="___col_lg_6 ___left_header">
          <div class="___back_btn">
            <a href="#">
           
            </a>
          </div>
        </div>
        <div class="___col_lg_6 ___right_header">
          <div class="___user_score">
            <img class="___score_bage" src="https://cms.edutekit.com/wp-content/uploads/2023/10/score-bage.png" alt="">
            <span class="___score_count">0</span>
          </div>
        </div>
      </header>
      <!-- *** End Header *** -->
    
      <!-- *** Main Site *** -->
      <main class="___main" id="main">
        <section class="___reorder_main">
          <div class="___container">
            <div class="___col_lg_1_5">
              <div class="___the_boy">
                <img src="https://cms.edutekit.com/wp-content/uploads/2023/10/boy-welcom.png" alt="">
              </div>
  <p class="title-session"> Sắp xếp giảm dần từ trái sang phải</p>
            </div>
            <div class="___col_lg_4_5">
              <div class="___reorder_text_frame">
              </div>
            </div>
          </div>
        </section>
      </main>
</section>
<div class="d-flex flex-column">
<video controls="true" id="video-bg" class="d-none" playsinline>
    <source src="https://cms.edutekit.com/wp-content/uploads/2023/11/video-click.mp4" type="video/mp4">
  </video>
  <video controls="true" id="video-sai" class="d-none" playsinline>
    <source src="https://cms.edutekit.com/wp-content/uploads/2023/11/sai1.mp4" type="video/mp4">
  </video>
  <video controls="true" id="video-dung" class="d-none" playsinline>
    <source src="https://cms.edutekit.com/wp-content/uploads/2023/11/dung-update.mp4" type="video/mp4">
  </video>
</div>
<script src="<?php echo THEME_URL;?>/dist/js/jquery-3.6.0.min.js"></script>    
    
<!-- <script  src="<?php //echo get_template_directory_uri(); ?>/component/js/game_plus.js"></script> -->

<?php
    // wp_enqueue_script('dragAndDrop-js2', get_template_directory_uri() . '/component/js/dragAndDrop.js', array('jquery', 'jquery-ui-core', 'jquery-ui-droppable'), '1.5', true);
    wp_enqueue_script('game_plus_js', get_template_directory_uri() . '/component/js/sort_decrease.js', array(), '1.1', true);
?>

<?php

get_footer("iframe");