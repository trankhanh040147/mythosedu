<div class="tutor-error-course-end-date-modal tutor-modal tutor-modal-is-close-inside-inner">
    <span class="tutor-modal-overlay"></span>
    <div class="tutor-modal-root">
        <div class="tutor-modal-inner">
            <button data-tutor-modal-close class="tutor-modal-close">
                <span class="tutor-icon-line-cross-line tutor-icon-40"></span>
            </button>
            <?php //do_action("tutor_before_login_form"); ?>

            <div class="tutor-modal-body">
                <div class="tutor-fs-5 tutor-fw-normal tutor-color-danger tutor-mb-32  tutor-flex-center">
                    <?php _e('Warning', 'tutor'); ?>
                </div>
				
                <div class="tutor-text-left tutor-fs-6 tutor-fw-normal tutor-color-black-60 tutor-mt-20  tutor-flex-center">
                    <?php _e('End Date must be after Start Date!', 'tutor'); ?>&nbsp;<br/><br/>	
                </div>
				<div class="tutor-text-left tutor-fs-6 tutor-fw-normal tutor-color-black-60 tutor-mt-20  tutor-flex-center">
                    <button type="submit" class="close-warning-course-end tutor-btn is-primary  tutor-flex-center">
                        <?php _e('OK', 'tutor'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
window.jQuery(document).ready(function ($) {
  $( "#tutor-frontend-course-builder" ).submit(function( event ) {
	  var st_d = $('input[name="_tutor_course_start_date"]').val();
	  var en_d = $('input[name="_tutor_course_end_date"]').val();
	if (en_d == "") return;
	if (		( st_d =="" && en_d != "")
			|| (st_d !="" &&(new Date(en_d) < new Date(st_d)))
		) 
	{
		event.preventDefault();
		$('.tutor-error-course-end-date-modal').addClass('tutor-is-active');
	}        
  });
  $(document).on('click', '.close-warning-course-end', function (event) {
    event.preventDefault();
    $('.tutor-error-course-end-date-modal').removeClass('tutor-is-active');    
  });
});
</script>