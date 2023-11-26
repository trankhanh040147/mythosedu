$(window).on('load', function () {
    $('#loading').hide().fadeOut('600');;
  }) 

  $(document).ready(function () {
    /** ---------------------------- //
     *  @group viewport trigger script
     * for adding or removing classes from elements in view within viewport
     */
    var $animationElements = $(".___add_animate");
    var $window = $(window);
    // ps: Let's FIRST disable triggering on small devices!
    var isMobile = window.matchMedia("only screen and (max-width: 768px)");
    if (isMobile.matches) {
      $animationElements.removeClass(".___add_animate");
    }
    function checkIfInView() {
      var windowHeight = $window.height();
      var windowTopPosition = $window.scrollTop();
      var windowBottomPosition = windowTopPosition + windowHeight;

      $.each($animationElements, function () {
        var $element = $(this);
        var elementHeight = $element.outerHeight();
        var elementTopPosition = $element.offset().top;
        var elementBottomPosition = elementTopPosition + elementHeight;
        //check to see if this current container is within viewport
        if (
          elementBottomPosition >= windowTopPosition &&
          elementTopPosition <= windowBottomPosition
        ) {
          $element.addClass("animate__animated").addClass("animate__fadeInUp");;
        }
        //else {
        //   $element.removeClass("animate__animated").removeClass("animate__fadeInUp");
        //}
      });
    }
    $window.on("scroll resize", checkIfInView);
    $window.trigger("scroll");
  });      