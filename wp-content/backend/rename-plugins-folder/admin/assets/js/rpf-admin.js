jQuery(document).ready(function($){
  $('#rpf-rename-submit').on('click',function(){
    var section = $('#rpf-section'),
      succ_el = $('#rpf-message-success'),
      no_access_el = $('#rpf-message-no-access'),
      error_el = $('#rpf-message-fail');
    section.addClass('rpf-progress');
    succ_el.addClass('rpf-hidden');
    error_el.addClass('rpf-hidden');
    $.ajax({
      type : "POST",
      url : ajaxurl,
      data : {
        "nonce" : $("#eos_rpf_rename_nonce").val(),
        "new_name" : $('#rpf-folder-name').val(),
        "action" : 'eos_rpf_rename_folder'
      },
      success : function(response){
        if('_no_file_access' === response){
          no_access_el.removeClass('rpf-hidden');
        }
        else if (parseInt(response) == 1) {
          succ_el.removeClass('rpf-hidden');
        }
        else{
          error_el.removeClass('rpf-hidden');
        }
        section.removeClass('rpf-progress');
      }
    });
  });
});
