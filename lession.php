<?php 
/* 
** Template Name: session-page
*/ 
get_header("iframe");
?>

<head>
  <link rel="stylesheet" type="text/css"
    href="<?php echo get_template_directory_uri(); ?>/component/css/style_lession.css">

</head>

<body>
<div class="___header2 ___container">
        <div class="___col_lg_6 ___left_header2">
          <div class="___back_btn">
            <a href="#">
           
            </a>
          </div>
        </div>
        <div class="___col_lg_6 ___right_header2 d-flex justify-content-end align-items-center">
          <div class="__key d-flex">
            <img src="https://cms.edutekit.com/wp-content/uploads/2023/11/icon-key.svg" alt="">
            <span class="__text-key">1</span>
          </div>
          <div class="___user_score">
            <img class="___score_bage" src="https://cms.edutekit.com/wp-content/uploads/2023/10/score-bage.png" alt="">
            <span class="___score_point">0</span>
          </div>
        </div>
</div>
  <section class="__lession position-relative">
    <div class="container-fluid h-100">
      <div class="row h-100 __lession-box">
        
      </div>
    </div>
    <div class=" col-12 d-flex justify-content-end position-absolute __box-btn">
        <button class=" __btn-prev"> <img src="https://cms.edutekit.com/wp-content/uploads/2023/11/btn-prev.svg" alt="" class="__btn_prev"></button>
        <button class=" __btn-next"> <img src="https://cms.edutekit.com/wp-content/uploads/2023/11/btn-next.svg" alt="" class="__btn_next"></button>
    </div>
  </section>
  <div class="col-12 modal-end">
    <p>Kết thúc trò chơi phần này </p>
    <a href="https://cms.edutekit.com/?page_id=6651?id=" class="__btn-endgame">
      <p>Quay lại map</p>
    </a>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <script src="<?php echo get_template_directory_uri(); ?>/component/js/page_lession.js?v=1.1"></script>

</body>
<?php

get_footer("iframe");