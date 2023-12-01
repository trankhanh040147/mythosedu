jQuery(function($) {
    $(document).off('click', '#check-all').on('click', '#check-all', function(e) {
        var checkboxes = $(this).closest('form').find("input[name='site_ids\[\]']");

        if($(this).prop('checked')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });
});