<?php
/**
 * Date: 11/6/19
 * Time: 3:15 PM
 */

?>
 <!-- Footer -->
 <footer id="footer">
      <div class="container">
        <!-- footer 1 -->
        <div class="row gx-5 ___footer_1">
          <!-- col 1  -->
          <div class="col-lg-12 col-md-4 ___footer_logo_col">
            <img
              class="mb-2 w-md-25 ___footer_logo ___section_title_mobile"
              src="<?php echo THEME_URL;?>/component/img/logo-footer.png"
              alt=""
            />

            
          </div>
          <!-- col 2  -->
          <div class="col-lg-12 col-md-8">
                <?php
                    wp_nav_menu(array(
                        'menu'  => 'Footer Menu',
                        'container' => '', // Leaving it empty removes the <div> container.
                        'menu_class'=> 'navbar-nav mr-auto fmenu',
                        'add_li_class'  => 'nav-item'
                    ));
                ?>
            
          </div>
        </div>
        
      </div>
    </footer>
    <!-- End Footer -->    
    <script src="<?php echo THEME_URL;?>/dist/js/jquery-3.6.0.min.js"></script>    
    <script src="<?php echo THEME_URL;?>/dist/js/jquery-migrate.js"></script>
    <script src="<?php echo THEME_URL;?>/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo THEME_URL;?>/dist/js/slick.min.js"></script>

    <script>
            $(document).ready(function(){

              $(window).scroll(function(){
                var sticky = $('body'),
                    scroll = $(window).scrollTop();

                if (scroll >= 60) sticky.addClass('__header_fixed');
                else sticky.removeClass('__header_fixed');
              });

              // banner sliders
              $('.___hero_sliders').slick({
                infinite: false,
                centerMode: false,
                //slidesToShow: 8.999999,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                dots: false,    
                // cssEase: 'linear',   
                initialSlide: 1,
                dotsClass: "___yl_slick_dot",
                prevArrow: '<button type="button" class="___yl_slick_prev"></button>',
                nextArrow: '<button type="button" class="___yl_slick_next"></button>',
                responsive: [
                  {
                    breakpoint: 768,
                    settings: {
                      slidesToShow: 1,
                      centerMode: true,
                    }
                  },
                  {
                    breakpoint: 576,
                    settings: {
                      slidesToShow: 1,          
                    }
                  },
                  {
                    breakpoint: 400,
                    settings: {
                      slidesToShow: 1,          
                    }
                  }
                ]    
                
              });

              $('.___certificates_slick_lst').slick({
                infinite: false,
                centerMode: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                dots: false,    
                prevArrow: '<button type="button" class="___yl_slick_prev"></button>',
                nextArrow: '<button type="button" class="___yl_slick_next"></button>',
                responsive: [
                  {
                    breakpoint: 768,
                    settings: {
                      slidesToShow: 1,
                    }
                  },
                  {
                    breakpoint: 576,
                    settings: {
                      slidesToShow: 1,
                      centerMode: false,
                      arrows: false,
                      dots: false,
                      dotsClass: '___yl_slick_dot',    
                    }
                  }
                ]    
              });

              // tabs



              $('.__course_slick').slick({
    infinite: false,
    centerMode: false,
    slidesToShow: 4,
    slidesToScroll: 1,
    arrows: true,
    dots: false,    
    prevArrow: '<button type="button" class="___yl_slick_prev"></button>',
    nextArrow: '<button type="button" class="___yl_slick_next"></button>',
    responsive: [
                  {
                    breakpoint: 768,
                    settings: {
                      slidesToShow: 1,
                    }
                  },
                  {
                    breakpoint: 576,
                    settings: {
                      slidesToShow: 1,
                      centerMode: true,
                      arrows: false,
                      dots: false,
                      dotsClass: '___yl_slick_dot',    
                    }
                  }
                ]    

  });

    window.onload = function()
    {
      console.log('....onload...');
    };

    $("#startdate_datepicker").datepicker(
      {
        dateFormat: "yy-mm-dd",
      }
    ).change(function() {

        var value = $(this).val().toLowerCase().replace(/\s+/g, '');
        console.log(value + "|....");

        var _current_fulllink = $("#current_fulllink").val();
        console.log(_current_fulllink + "|....");
        console.log(`${window.location.href}&startdate_datepicker=${value}`);
        window.location.href = `${window.location.href}&startdate_datepicker=${value}`
    });


});


    </script>
<?php wp_footer(); ?>
</body>
</html>