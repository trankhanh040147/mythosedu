jQuery(document).ready(function($){
    // 'use strict';

    var wacUpdateTimeout = null;

    wacChange = function(qtyInput) {


        // ask user if they really want to remove this product
        if ( ( wooajaxcart.confirm_zero_qty == 'yes' ) && !wacZeroQuantityCheck(qtyInput) ) {
            return false;
        }

        // when qty is set to zero, then fires default woocommerce remove link
        if ( qtyInput.val() == 0 ) {
            var removeLink = qtyInput.closest('.cart_item').find('.product-remove a');
            removeLink.trigger('click');

            return false;
        }

        // clear previous timeout, if exists
        if ( wacUpdateTimeout !== null ) {
            clearTimeout(wacUpdateTimeout);
        }

        wacUpdateTimeout = setTimeout(function(){
            wacRefreshCart(qtyInput);
        }, wooajaxcart.ajax_timeout);

        return true;
    };

    wacRefreshCart = function(qtyInput) {
        // deal with update cart button
        var updateButton = $("button[name='update_cart']:not(.dgfw-add-gift-button),input[name='update_cart']:not(.dgfw-add-gift-button)");

        updateButton.removeAttr('disabled')
                    .trigger('click')
                    .val( wooajaxcart.updating_text )
                    .prop('disabled', true);
        
        // change the Update cart button
        /*$("a.checkout-button.wc-forward").addClass('disabled')
                                         .html( wooajaxcart.updating_text );*/
    };

    // overrided by wac-js-calls.php
    var wacZeroQuantityCheck = function(qtyInput) {
        if ( parseInt(qtyInput.val()) == 0 ) {

            if ( !confirm(wooajaxcart.warn_remove_text) ) {
                qtyInput.val(1);
                return false;
            }
        }

        return true;
    };

    var wacListenQtyChange = function() {
        $(document.body).on('change', '.qty', function(e){
            // prevent to set invalid quantity on select
            if ( $(this).is('select') && ( $(this).attr('max') > 0 ) &&
                 ( parseInt($(this).val()) > parseInt($(this).attr('max')) ) ) {
                $(this).val( $(this).attr('max') );

                e.preventDefault();
                return false;
            }

            return wacChange( $(this) );
        });
    };

    var wacListenQtyButtons = function() {
        var fnIncrement = function(e){
            var inputQty = $(this).parent().parent().parent().find('.qty');
            inputQty.val( function(i, oldval) { return ++oldval; });
            inputQty.trigger('change');
            
            return false;
        };

        var fnDecrement = function(e){
            var inputQty = $(this).parent().parent().parent().find('.qty');
            var oldVal = inputQty.val();

            if ( inputQty.attr('min') != 'undefined' && parseInt(inputQty.attr('min')) >= oldVal ) {
                return false;
            }

            inputQty.val( --oldVal );
            inputQty.trigger('change');

            return false;
        };

        if ( $('.wac-btn-inc').length ) {
            $('.wac-btn-inc').off('click.wac2910').on('click.wac2910', fnIncrement);
            $('.wac-btn-sub').off('click.wac2911').on('click.wac2911', fnDecrement);

            if ( $('.grid').length ) {
                setTimeout(wacListenQtyButtons, 500);
            }

            // fix common style problem in single product page
            $("<style type='text/css'>.product .quantity { display: inline; float: none !important; margin-right: 0 !important; }</style>").appendTo('head');
        }
        else {
            $(document.body).off('click.wac3000').on('click.wac3000', '.wac-btn-inc', fnIncrement);
            $(document.body).off('click.wac3001').on('click.wac3001', '.wac-btn-sub', fnDecrement);
        }
    };

    // onload calls
    wacListenQtyChange();
    wacListenQtyButtons();

    $(document).on('wc_fragments_refreshed', function(){
        wacListenQtyButtons();
    });

    $( document.body ).on( 'added_to_cart', function( event, fragments, cart_hash ) {
        // prevent woocommerce to reload the page after Add to cart in certain conditions (outside Cart page)
        // the window.location.reload() was defined in woo cart.js script
		if ( $( '.woocommerce-cart-form' ).length == 0 ) {
            $('body').append('<div class="woocommerce-cart-form" style="display: none;"></div>');
		}
    });
});

