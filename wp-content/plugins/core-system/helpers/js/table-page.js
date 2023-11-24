jQuery(function($) {
    $(".bf-submit-form select").off("change").on("change", function (ev) {
        $(this).closest("form").submit();
    })
});