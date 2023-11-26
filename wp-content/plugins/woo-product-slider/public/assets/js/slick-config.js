jQuery(document).ready(function ($) {

    $('.wps-product-section').each(function (index) {

        var custom_id = $(this).attr('id');

        if (custom_id != '') {
            jQuery('#' + custom_id).slick({
                infinite: true,
                prevArrow: "<div class='slick-prev'><i class='fa fa-angle-left'></i></div>",
                nextArrow: "<div class='slick-next'><i class='fa fa-angle-right'></i></div>",
                slidesToScroll: 1,

            }); // Slick end

        }
    });

});
