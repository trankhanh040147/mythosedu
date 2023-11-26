<div class="tutor-add-children-modal tutor-modal tutor-modal-is-close-inside-inner">
    <span class="tutor-modal-overlay"></span>
    <div class="tutor-modal-root">
        <div class="tutor-modal-inner">
            <button data-tutor-modal-close class="tutor-modal-close">
                <span class="tutor-icon-line-cross-line tutor-icon-40"></span>
            </button>
            <?php //do_action("tutor_before_login_form"); ?>

            <div class="tutor-modal-body">
                <div class="tutor-text-left tutor-fs-6 tutor-fw-normal tutor-color-black-60 tutor-mt-20">
                    <?php _e('This is a paid course.', 'tutor'); ?>&nbsp;<br/>
					<?php _e('To continue, check the box below to add this course to cart.', 'tutor'); ?>&nbsp;<br/><br/>	
                </div>
                <form class="tutor-add_children-form" method="post">
				<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
                    <input type="hidden" name="tutor_course_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
                    <input type="hidden" name="tutor_course_action" value="_tutor_add_children" />
                    <input type="hidden" name="redirect_to" value="/cart" />

                    <div class="tutor-d-flex tutor-justify-content-between tutor-align-items-center tutor-mb-40">
                        <div class="tutor-form-check">
                            <input id="tutor-add-agmnt-1" type="checkbox" class="tutor-form-check-input tutor-bg-black-40" name="add-children" value="add-children" />
                            <label for="tutor-add-agmnt-1" class="tutor-fs-7 tutor-fw-normal tutor-color-muted">
                                <?php _e('Add to cart', 'tutor'); ?>
                            </label>
                        </div>
                    </div>

                    <?php //do_action("tutor_login_form_end"); ?>
                    <button type="submit" class="tutor-btn is-primary tutor-is-block tutor-is-icon-btn">
                        <?php _e('Save & proceed with the payment', 'tutor'); ?>
                    </button>
                </form>

                <?php //do_action("tutor_after_login_form"); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
window.jQuery(document).ready(function ($) {
  // Add children confirm on purchase click
  $(document).on('click', '.tutor-course-add-children-div button', function (e) {
    e.preventDefault();
    $('.tutor-add-children-modal').addClass('tutor-is-active');    
  });
});
</script>