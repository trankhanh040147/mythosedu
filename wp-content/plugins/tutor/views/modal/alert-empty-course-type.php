<div class="tutor-empty-course-type-modal tutor-modal tutor-modal-is-close-inside-inner">
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
                    <?php _e('Please select course type!', 'tutor'); ?>&nbsp;<br/><br/>	
                </div>
				<div class="tutor-text-left tutor-fs-6 tutor-fw-normal tutor-color-black-60 tutor-mt-20  tutor-flex-center">
                    <button type="submit" class="close-warning tutor-btn is-primary  tutor-flex-center">
                        <?php _e('OK', 'tutor'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
window.jQuery(document).ready(function ($) {
  // Add children confirm on purchase click
  $( "#tutor-frontend-course-builder" ).submit(function( event ) {
	if ($('input[name="_tutor_course_type"]:checked').length == 0) {
		event.preventDefault();
		$('.tutor-empty-course-type-modal').addClass('tutor-is-active');
	}        
  });
  $(document).on('click', '.close-warning', function (event) {
    event.preventDefault();
    $('.tutor-empty-course-type-modal').removeClass('tutor-is-active');    
  });
});
</script>