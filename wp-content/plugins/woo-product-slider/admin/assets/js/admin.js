jQuery(function ($) {

    'use strict';

    /* === Masonry === */
    jQuery( document ).ready(function() {
        jQuery('.sp-wps-pro-features .feature-section').masonry({
            // options
            itemSelector: '.col',
            horizontalOrder: true
        });
    });

    // WQV plugin notice
    jQuery(document).on('click', '.notice-wqv .notice-dismiss', function () {
        jQuery.ajax({
            url: ajaxurl,
            data: {
                action: 'dismiss_wqv_notice'
            }
        })
    })

});