<?php 
/* 
** Template Name: Course-game
*/ 
get_header();
?>
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/dist/css/style_page_game.css">
</head>

<body class="position-relative">
  <section class="__bg-level">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 mx-auto d-flex justify-content-center" id="khanh">
          <div class="position-relative __box-game ">
            <img src="/wp-content/uploads/2023/10/img-level.png" alt="" class="w-100 __img-level">
            <img src="/wp-content/uploads/2023/10/global.png" class="__global" alt="">
            <div class="__img-fish-small">
              <img src="/wp-content/uploads/2023/10/fish-small.png" alt="" class="fish-small ">
            </div>
            <div class="__boat position-absolute ">
              <img src="/wp-content/uploads/2023/10/boat.png" alt="">
            </div>
            <div class="box-fish-big position-absolute">
              <div class="position-relative __img-fish-big">
                <img src="/wp-content/uploads/2023/10/fish-big.png" alt="" class="fish-big">
                <img src="/wp-content/uploads/2023/10/warter.png" alt="" class="position-absolute __warter">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 position-absolute start-0 bottom-0 z-index6 px-0">
    <img src="/wp-content/uploads/2023/10/clound-footer.png" alt="" class="w-100">
  </div>
  </section>
  <div class="__compass position-absolute ">
    <div class="position-relative">
      <img src="/wp-content/uploads/2023/10/compat.png" alt="" class="__img-compat">
      <img src="/wp-content/uploads/2023/10/kim-compass.png" alt="" class="__kim-compat">
    </div>
  </div>
  <div class="modal-end-course">
    <div class="__box-text-modal w-100 d-flex justify-content-center align-items-center flex-column">
      <p class="text-modal w-100 ">Kết thúc khóa học </p>
      <p class="text-point">Bạn đạt được <span class="point_end"></span> điểm</p>
  <ul class="__detail_modal">
    
  </ul>
    </div>
    <button class="__btn-return-home">Chơi lại</button>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/assets/dist/js/page-game.js?v=1.2"></script>
</body>

<?php

get_footer();

