<?php

/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>

<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16"><?php esc_html_e('Enroll Students', 'tutor'); ?></div>

<div class="tutor-dashboard-content-inner enroll-students">
<div class="wrap">
    <hr class="wp-header-end">

    <form action="" id="new-enroll_student-form" method="post">
        <input type="hidden" name="tutor_action" value="enrol_student">

        <?php echo apply_filters('student_enrolled_to_course_msg', ''); ?>

        <?php  ?>
        
		<?php do_action('tutor_add_new_enroll_student_form_fields_before'); ?>

        <div class="tutor-enroll-field-row">
            <div class="tutor-enroll-field-label">
                <label for="">
					<?php _e('Add Students', 'tutor-pro'); ?>

                    <span class="tutor-required-fields">*</span>
                </label>
            </div>
            <div class="tutor-option-field">
				<textarea name="add_students" id="add_students" rows="5" cols="60"  class="tutor-form-control tutor-mb-12" placeholder="Email, Branch_ID, Branch_Name, Gender, Age"></textarea>
            </div>
			<div class="tutor-enroll-field-label"></div>
			<div class="tutor-option-field">
                <?php _e('Students list: Email, Branch_ID, Branch_Name, Gender, Age (one per line)', 'tutor-pro'); ?>
            </div>
			
        </div>
		
        <div class="tutor-enroll-field-row">
            <div class="tutor-enroll-field-label">
                <label>
					<?php _e('Course', 'tutor-pro'); ?>
                    <span class="tutor-required-fields">*</span>
                </label>
            </div>

            <div class="tutor-option-field">
                <?php
                $courses = tutor_utils()->get_courses(array(get_the_ID()), array('publish', 'private'));
                ?>
                <select name="course_id" class="tutor_select2" required="required">
                    <option value=""><?php _e( 'Select a Course', 'tutor-pro' ); ?></option>
	                <?php
	                foreach ($courses as $course){
						$parent_ids = get_post_meta( $course->ID, '_tutor_course_parent', true );
						$parent_ids_arr = array();
						if($parent_ids)
							$parent_ids_arr = explode(" ",trim($parent_ids));
						if ( count($parent_ids_arr)) continue;
						echo "<option value='{$course->ID}'>{$course->post_title}</option>";
						
	                }
	                ?>
                </select>
            </div>
        </div>

		<?php do_action('tutor_add_new_enroll_student_form_fields_after'); ?>

        <div class="tutor-enroll-field-row">
            <div class="tutor-enroll-field-label"></div>

            <div class="tutor-option-field">
                <div class="tutor-form-group tutor-reg-form-btn-wrap">
                    <button type="submit" name="tutor_enroll_student_btn" value="enroll" class="tutor-btn tutor-btn-primary tutor-btn-md">
                        <i class="tutor-icon-plus-square tutor-mr-12"></i>
						<?php _e('Enroll Student', 'tutor-pro'); ?>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>    
</div>
<script src='/wp-content/plugins/tutor/assets/packages/select2/select2.full.min.js?ver=2.0.0' id='tutor-select2-js'></script>

<script src='/wp-content/plugins/lmspro/addons/enrollments/assets/js/enroll2.js?ver=2.0.3' id='enrollment-js-script-js'></script>
<link rel='stylesheet' id='enrollment-css-script-css' href='/wp-content/plugins/lmspro/addons/enrollments/assets/css/enroll.css?ver=2.0.3' media='all' />