<?php

/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>
<?php 
$current_campus = wp_get_current_user()->data->Manage_Branchs;
$students_all =tutor_utils()->get_students_by_campus($active_cid,$offset, $per_page,$current_campus);

$learner_id= 121;
$course_id = 2106;
//print_r($students_all);


// Retrieve the list of courses
$courses = tutor_utils()->get_courses();
// Check if there are courses available
if (!empty($courses)) {
    // Loop through the courses and display their details
    foreach ($courses as $course) {
        $course_id = $course->ID;
        $course_title = $course->post_title;
        $course_permalink = get_permalink($course_id);

        // Display course information
       // echo "<a href='$course_permalink'>$course_id ------ $course_title</a><br>";
    }
} else {
    //echo "No courses available.";
}

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
            
                <label for="">
					<?php _e('Or enroll users by list:', 'tutor-pro'); ?>

                    <span class="tutor-required-fields">*</span>
                </label> 
        </div>
        <div id="table-enroll-students">
            <?php
                echo '<table>';
                echo '<tr><th><input id="select-all" type="checkbox" value="all"></th><th>ID</th><th>Email</th><th>Action</th></tr>';
                foreach ($students_all as $subarray) {
                    $id = $subarray['ID'];
                    $userName = $subarray['display_name'];
                    $userEmail = $subarray['user_email'];
                    $showEnroll = tutor_utils()->get_enrolled_courses_ids_by_user($id);
                    //print_r($showEnroll);
                    echo '<tr>';
                    echo "<td><input type='checkbox' name='selected_ids[]' class='user-checkbox' value='$id'></td>";
                    echo "<td>$userName</td>";
                    echo "<td>$userEmail</td>";
                    if(!empty($showEnroll)){
                        echo '<td><a id="enrolled">Enrolled</a> / <a id="cancle">Cancle</a></td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
            ?>
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
</div>
<script>
    // Get the "Select All" checkbox element
    const selectAllCheckbox = document.getElementById('select-all');
  
    // Get all the user checkboxes
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
  
    // Add a click event listener to the "Select All" checkbox
    selectAllCheckbox.addEventListener('click', function () {
      const isChecked = this.checked;
  
      // Set the checked state of all user checkboxes to match the "Select All" checkbox
      userCheckboxes.forEach(function (checkbox) {
        checkbox.checked = isChecked;
      });
    });
</script>
<script src='/wp-content/plugins/tutor/assets/packages/select2/select2.full.min.js?ver=2.0.0' id='tutor-select2-js'></script>

<script src='/wp-content/plugins/lmspro/addons/enrollments/assets/js/enroll2.js?ver=2.0.3' id='enrollment-js-script-js'></script>
<link rel='stylesheet' id='enrollment-css-script-css' href='/wp-content/plugins/lmspro/addons/enrollments/assets/css/enroll.css?ver=2.0.3' media='all' />
