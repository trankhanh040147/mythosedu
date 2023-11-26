
<div class="wrap">
	<h1 class="wp-heading-inline"><?php _e('Enroll Student', 'tutor-pro'); ?></h1>
    <hr class="wp-header-end">

    <form action="" id="new-enroll_student-form" method="post">
        <input type="hidden" name="tutor_action" value="enrol_student">

        <?php echo apply_filters('student_enrolled_to_course_msg', ''); ?>

        <?php  ?>
        
		<?php do_action('tutor_add_new_enroll_student_form_fields_before'); ?>

        <div class="tutor-enroll-field-row">
            <div class="tutor-enroll-field-label">
                <label for="">
					<?php _e('Existed Student', 'tutor-pro'); ?>

                    <span class="tutor-required-fields">*</span>
                </label>
            </div>
            <div class="tutor-option-field">
                <select name="student_id" id="select2_search_user_ajax"></select>
            </div>
        </div>

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