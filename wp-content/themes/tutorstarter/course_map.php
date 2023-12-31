<?php 
/* 
** Template Name: course_map
*/ 
get_header();
?>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 <?php 

    wp_enqueue_style('game_plus_css', get_template_directory_uri() . '/assets/dist/css/course_map.css', array(), '1.3', false);

 ?>
</head>

<!-- https://mythosedu.com/course-map/?course_id=15837 -->
<?php
$course_id = $_GET['course_id'];
?>
<div class="__loading"></div>
  <img src="/wp-content/uploads/2023/12/cloud1.svg" alt="" class="__cloud1 position-fixed">
  <img src="/wp-content/uploads/2023/12/cloud2.svg" alt="" class="__cloud2 position-fixed">
  <!-- <img src="/wp-content/uploads/2023/12/cloud3.svg" alt="" class="__cloud3 position-fixed"> -->
  <img src="/wp-content/uploads/2023/12/cloud4.svg" alt="" class="__cloud4 position-fixed">
 
  <section class="__level">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-12 col-md-10  line-level __mt-5">
          <img src="/wp-content/uploads/2023/12/line.png" alt="" class="__line">
          <?php echo do_shortcode('[load_all_course_hierarchy course_id = ' . $course_id . ']'); ?>
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

get_footer();
