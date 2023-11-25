<?php
/**
 * Date: 11/6/19
 * Time: 3:15 PM
 */

?>
 <!-- Footer -->
 <footer id="footer">
      
    </footer>
    <!-- End Footer -->    
    <script src="<?php echo THEME_URL;?>/dist/js/jquery-3.6.0.min.js"></script>    
    <script src="<?php echo THEME_URL;?>/dist/js/jquery-migrate.js"></script>
    <script src="<?php echo THEME_URL;?>/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo THEME_URL;?>/dist/js/slick.min.js"></script>
    <!-- <script  src="<?php //echo get_template_directory_uri(); ?>/component/js/dragAndDrop.js"></script> -->

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

  

});
    </script>
<?php wp_footer(); ?>
</body>
</html>