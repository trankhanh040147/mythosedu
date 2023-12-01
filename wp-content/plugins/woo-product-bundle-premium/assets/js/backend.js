'use strict';

jQuery(document).ready(function($) {
  var woosb_timeout = null;

  // options page
  woosb_active_options();

  $('select[name="_woosb_change_price"]').on('change', function() {
    woosb_active_options();
  });

  // product page
  woosb_active_settings();

  $('#product-type').on('change', function() {
    woosb_active_settings();
  });

  // hide search result box by default
  $('#woosb_results').hide();
  $('#woosb_loading').hide();

  // total price
  if ($('#product-type').val() == 'woosb') {
    woosb_change_price();
  }

  // set regular price
  $('#woosb_set_regular_price').on('click', function() {
    if ($('#woosb_disable_auto_price').is(':checked')) {
      $('li.general_tab a').trigger('click');
      $('#_regular_price').focus();
    } else {
      alert('You must disable auto calculate price first!');
    }
  });

  // set optional
  $('#woosb_optional_products').on('click', function() {
    if ($(this).is(':checked')) {
      $('.woosb_tr_show_if_optional_products').show();
    } else {
      $('.woosb_tr_show_if_optional_products').hide();
    }
  });

  // checkbox
  $('#woosb_disable_auto_price').on('change', function() {
    if ($(this).is(':checked')) {
      $('#_regular_price').prop('readonly', false);
      $('#_sale_price').prop('readonly', false);
      $('.woosb_tr_show_if_auto_price').hide();
    } else {
      $('#_regular_price').prop('readonly', true);
      $('#_sale_price').prop('readonly', true);
      $('.woosb_tr_show_if_auto_price').show();
    }
    if ($('#product-type').val() == 'woosb') {
      woosb_change_price();
    }
  });

  // search input
  $('#woosb_keyword').keyup(function() {
    if ($('#woosb_keyword').val() != '') {
      $('#woosb_loading').show();
      if (woosb_timeout != null) {
        clearTimeout(woosb_timeout);
      }
      woosb_timeout = setTimeout(woosb_ajax_get_data, 300);
      return false;
    }
  });

  // actions on search result items
  $('#woosb_results').on('click', 'li', function() {
    $(this).children('span.remove').attr('aria-label', 'Remove').html('×');
    $('#woosb_selected ul').append($(this));
    $('#woosb_results').hide();
    $('#woosb_keyword').val('');
    woosb_get_ids();
    woosb_change_price();
    woosb_arrange();
    return false;
  });

  // change qty of each item
  $('#woosb_selected').on('keyup change', '.qty input', function() {
    woosb_get_ids();
    woosb_change_price();
    return false;
  });

  // actions on selected items
  $('#woosb_selected').on('click', 'span.remove', function() {
    $(this).parent().remove();
    woosb_get_ids();
    woosb_change_price();
    return false;
  });

  // hide search result box if click outside
  $(document).on('click', function(e) {
    if ($(e.target).closest($('#woosb_results')).length == 0) {
      $('#woosb_results').hide();
    }
  });

  // arrange
  woosb_arrange();

  $(document).on('woosb_drag_event', function() {
    woosb_get_ids();
  });

  function woosb_arrange() {
    $('#woosb_selected li').arrangeable({
      dragEndEvent: 'woosb_drag_event',
      dragSelector: '.move',
    });
  }

  function woosb_get_ids() {
    var listId = new Array();
    $('#woosb_selected li').each(function() {
      listId.push($(this).data('id') + '/' + $(this).find('input').val());
    });
    if (listId.length > 0) {
      $('#woosb_ids').val(listId.join(','));
    } else {
      $('#woosb_ids').val('');
    }
  }

  function woosb_active_options() {
    if ($('select[name="_woosb_change_price"]').val() == 'yes_custom') {
      $('input[name="_woosb_change_price_custom"]').show();
    } else {
      $('input[name="_woosb_change_price_custom"]').hide();
    }
  }

  function woosb_active_settings() {
    if ($('#product-type').val() == 'woosb') {
      $('li.general_tab').addClass('show_if_woosb');
      $('#general_product_data .pricing').addClass('show_if_woosb');
      $('._tax_status_field').
          closest('.options_group').
          addClass('show_if_woosb');
      $('#_downloadable').
          closest('label').
          addClass('show_if_woosb').
          removeClass('show_if_simple');
      $('#_virtual').
          closest('label').
          addClass('show_if_woosb').
          removeClass('show_if_simple');

      $('.show_if_external').hide();
      $('.show_if_simple').show();
      $('.show_if_woosb').show();

      $('.product_data_tabs li').removeClass('active');
      $('.product_data_tabs li.woosb_tab').addClass('active');

      $('.panel-wrap .panel').hide();
      $('#woosb_settings').show();

      if ($('#woosb_optional_products').is(':checked')) {
        $('.woosb_tr_show_if_optional_products').show();
      } else {
        $('.woosb_tr_show_if_optional_products').hide();
      }

      if ($('#woosb_disable_auto_price').is(':checked')) {
        $('.woosb_tr_show_if_auto_price').hide();
      } else {
        $('.woosb_tr_show_if_auto_price').show();
      }

      woosb_change_price();
    } else {
      $('li.general_tab').removeClass('show_if_woosb');
      $('#general_product_data .pricing').removeClass('show_if_woosb');
      $('._tax_status_field').
          closest('.options_group').
          removeClass('show_if_woosb');
      $('#_downloadable').
          closest('label').
          removeClass('show_if_woosb').
          addClass('show_if_simple');
      $('#_virtual').
          closest('label').
          removeClass('show_if_woosb').
          addClass('show_if_simple');

      $('#_regular_price').prop('readonly', false);
      $('#_sale_price').prop('readonly', false);

      if ($('#product-type').val() != 'grouped') {
        $('.general_tab').show();
      }

      if ($('#product-type').val() == 'simple') {
        $('#_downloadable').closest('label').show();
        $('#_virtual').closest('label').show();
      }
    }
  }

  function woosb_round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
  }

  function woosb_format_money(number, places, symbol, thousand, decimal) {
    number = number || 0;
    places = !isNaN(places = Math.abs(places)) ? places : 2;
    symbol = symbol !== undefined ? symbol : '$';
    thousand = thousand || ',';
    decimal = decimal || '.';
    var negative = number < 0 ? '-' : '',
        i = parseInt(
            number = woosb_round(Math.abs(+number || 0), places).
                toFixed(places),
            10) + '',
        j = 0;
    if (i.length > 3) {
      j = i.length % 3;
    }
    return symbol + negative + (
        j ? i.substr(0, j) + thousand : ''
    ) + i.substr(j).replace(/(\d{3})(?=\d)/g, '$1' + thousand) + (
        places ?
            decimal +
            woosb_round(Math.abs(number - i), places).toFixed(places).slice(2) :
            ''
    );
  }

  function woosb_change_price() {
    var total = 0;
    var total_max = 0;
    $('#woosb_selected li').each(function() {
      total += $(this).data('price') * $(this).find('input').val();
      total_max += $(this).data('price-max') * $(this).find('input').val();
    });
    total = woosb_format_money(total, woosb_vars.price_decimals, '',
        woosb_vars.price_thousand_separator,
        woosb_vars.price_decimal_separator);
    total_max = woosb_format_money(total_max, woosb_vars.price_decimals, '',
        woosb_vars.price_thousand_separator,
        woosb_vars.price_decimal_separator);
    if (total == total_max) {
      $('#woosb_regular_price').html(total);
    } else {
      $('#woosb_regular_price').html(total + ' - ' + total_max);
    }
    if (!$('#woosb_disable_auto_price').is(':checked')) {
      $('#_regular_price').prop('readonly', true).val(total).trigger('change');
      $('#_sale_price').prop('readonly', true);
    }
  }

  function woosb_ajax_get_data() {
    // ajax search product
    woosb_timeout = null;
    var data = {
      action: 'woosb_get_search_results',
      keyword: $('#woosb_keyword').val(),
      ids: $('#woosb_ids').val(),
    };
    jQuery.post(ajaxurl, data, function(response) {
      $('#woosb_results').show();
      $('#woosb_results').html(response);
      $('#woosb_loading').hide();
    });
  }
});