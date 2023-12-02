<?php

/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

$user_id				= get_current_user_id(); 
$active_cid   	        = isset($_GET['cid']) ? sanitize_text_field($_GET['cid']) : '';
?>
<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16"><?php esc_html_e('Enroll Students', 'tutor'); ?></div>

<div class="tutor-dashboard-content-inner enroll-students">
<div class="wrap">
    <hr class="wp-header-end">

    <form action="" id="new-enroll_student-form" method="post">
        <input type="hidden" name="tutor_action" value="enrol_student">

        <?php do_action('tutor_add_new_enroll_student_form_fields_before'); ?>

        <div class="tutor-enroll-field-row">
            <div class="tutor-enroll-field-label">
                <label>
					<?php _e('Course', 'tutor-pro'); ?>
                    <span class="tutor-required-fields">*</span>
                </label>
            </div>

            <div class="tutor-option-field">
                <?php
                $courses = tutor_utils()->get_courses(array(get_the_ID()), array('publish'));
                ?>
                <select class="tutor-form-select tutor-select-redirector">
                    <option value="./"><?php _e( 'Select a Course', 'tutor-pro' ); ?></option>
	                <?php
	                foreach ($courses as $course){
						$parent_ids = get_post_meta( $course->ID, '_tutor_course_parent', true );
						$parent_ids_arr = array();
						if($parent_ids)
							$parent_ids_arr = explode(" ",trim($parent_ids));
						if ( count($parent_ids_arr)) continue;
						echo "<option value='./?cid=" . $course->ID ."' ".($active_cid == $course->ID ? "selected='selected'" : "") . ">{$course->post_title}</option>";
	                }
	                ?>
                </select>
            </div>
        </div>
		<?php
			
						
				//if($vus_member=="Internal"){	//if internal member
					
				//if external coure but free for internal member
					//if(isset($course_type['course_type']) && isset($course_type['internal_pay_ot_not']) &&  $course_type['course_type'] == 'forexternal' && $course_type['internal_pay_ot_not'] == 'on') 
					//$course_price = 0;
				//}
		
			if($active_cid){			
		?>
		<div id="table-enroll-students" class="table_course_to_enroll mb-3">
         <?php	   
				echo '<table>';
                //echo '<tr><th>Course</th><th>Type</th><th>Price</th></tr>';
                
                    //$s_id = $subarray['ID'];
                    $courseName = get_the_title($active_cid);
					$course_type = get_post_meta( $active_cid, '_tutor_course_type', true);
					$course_type = maybe_unserialize($course_type);
					$course_price = tutor_utils()->get_course_price( $active_cid);
                    if(isset($course_type['course_type']) && isset($course_type['internal_pay_ot_not']) &&  $course_type['course_type'] == 'forexternal' && $course_type['internal_pay_ot_not'] == 'on') 
						{$course_type = "For External (Free For Internal)"; $free_internal=true;}
					elseif(isset($course_type['course_type']) &&  $course_type['course_type'] == 'forexternal') {$course_type = "For External"; $for_external=true;}
						else $course_type = "For Internal";
                    echo '<tr>';
                    echo "<td>$courseName</td>";
                    echo "<td>$course_type</td>";
					echo "<td>$course_price</td>";
                    echo '</tr>';
					$child_ids = get_post_meta( $active_cid, '_tutor_course_children', true );
					$child_ids_arr = array();
					if($child_ids)
						$child_ids_arr = explode(" ",trim($child_ids));
					if ( count($child_ids_arr)){
						foreach ($child_ids_arr as $sub_course) {
							$courseName = get_the_title($sub_course);
							$course_type = get_post_meta( $sub_course, '_tutor_course_type', true);
							$course_type = maybe_unserialize($course_type);//var_dump($course_type['course_type']);
							$course_price = tutor_utils()->get_course_price( $sub_course);
							if(isset($course_type['course_type']) && isset($course_type['internal_pay_ot_not']) &&  $course_type['course_type'] == 'forexternal' && $course_type['internal_pay_ot_not'] == 'on') 
							{$course_type = "For External (Free For Internal)";$free_internal=true;}
							elseif(isset($course_type['course_type']) &&  $course_type['course_type'] == 'forexternal') {$course_type = "For External"; $for_external=true;}
								else $course_type = "For Internal";
							echo '<tr>';
							echo "<td>$courseName</td>";
							echo "<td>$course_type</td>";
							echo "<td>$course_price</td>";
							echo '</tr>';
						}
					}
                
                echo '</table>';
            ?>
        </div>
		<?php echo apply_filters('student_enrolled_to_course_msg', ''); ?>	
		<?php
			}
			if($for_external){
		?>
			<div class="tnotice tnotice--danger">
        <div class="tnotice__icon">¡</div>
        <div class="tnotice__content"><p class="tnotice__type">Error</p><p class="tnotice__message"><?php _e('Can not enroll to external course(s)', 'tutor-pro'); ?></p>
        </div>
    	</div>
		<?php	
			}
			elseif($active_cid){
		?>		
        <div class="tutor-enroll-field-row">            
                <label for="" class='tutor-fw-bold'>
					<?php _e('Please select below students and enroll to course', 'tutor-pro'); ?>
                </label> 
        </div>
		<div class="tutor-input-search mb-3">
			<div class="tutor-row __fillter_box">
				<div class="tutor-col-md-5">
					<div class="tutor-input-group tutor-form-control-has-icon tutor-form-control-lg">
						<span class="tutor-icon-search-filled tutor-input-group-icon color-black-50"></span>
						<input id="myInput_student" type="text" class="tutor-form-control"  placeholder="Search Student (Name,Email...)">		
					</div>
				</div>
				<div class="tutor-col-md-7">
					<p class="_lbl">Status</p>
					<select>
						<option>Enrolled</option>
						<option>Not yet enrolled</option>
						<option>Completed</option>
						<option>Cancelled</option>
					</select>
				</div>
			</div>

			
        </div>
		
        <div id="table-enroll-students">			
            <?php				
				$students_all = ( current_user_can( 'administrator' ) ) ? tutor_utils()->get_students_all():tutor_utils()->get_user_manage_students_all($user_id);
                echo '<table>';
                echo '<tbody id="myTable_student"><tr><th><input id="select-all" type="checkbox" value="all"></th><th>Student</th><th>Email</th><th></th><th></th></tr>';
                foreach ($students_all as $subarray) {
                    $s_id = $subarray['ID'];
                    $userName = $subarray['display_name'];
                    $userEmail = $subarray['user_email'];
                    $is_enrolled = tutor_utils()->is_enrolled( $active_cid, $s_id );
                    $vus_member = nl2br( strip_tags( get_user_meta( $s_id, '_tutor_vus_member', true ) ) );				
					$vus_member = ($vus_member=="External")?"External":"Internal";
					if($vus_member=="External") continue;
					$tr_class=($is_enrolled)?" class='tr_student text-success' ":" class='tr_student' ";
                    echo "<tr $tr_class ><td>";
                    if(!$is_enrolled){ echo "<input type='checkbox' name='selected_ids[]' class='user-checkbox' value='$s_id'>";}
                    echo "</td><td>$userName</td>";
                    echo "<td>$userEmail</td>";
					echo "<td></td>";
                    if($is_enrolled){
                        echo '<td><a id="enrolled" class="text-success">Enrolled</a></td>';
                    }
                    echo '</tr>';
                }
                echo '</tbody></table>';
            ?>
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
		<?php } ?>
    </form>
</div>    
</div>
<script>
    // Get the "Select All" checkbox element
    const selectAllCheckbox = document.getElementById('select-all');
  
    // Add a click event listener to the "Select All" checkbox
    selectAllCheckbox.addEventListener('click', function () {
	  // Get all the user checkboxes
      const userCheckboxes = document.querySelectorAll('.tr_student:not([style*="display:none"]):not([style*="display: none"]) .user-checkbox');	
      
	  const isChecked = this.checked;
  
      // Set the checked state of all user checkboxes to match the "Select All" checkbox
      userCheckboxes.forEach(function (checkbox) {
        checkbox.checked = isChecked;
      });
    });
	jQuery(document).ready(function($){
	  $("#myInput_student").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".tr_student").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	  });
	});
</script>
<script src='/wp-content/plugins/tutor/assets/packages/select2/select2.full.min.js?ver=2.0.0' id='tutor-select2-js'></script>

<script src='/wp-content/plugins/lmspro/addons/enrollments/assets/js/enroll2.js?ver=2.0.3' id='enrollment-js-script-js'></script>
<link rel='stylesheet' id='enrollment-css-script-css' href='/wp-content/plugins/lmspro/addons/enrollments/assets/css/enroll.css?ver=2.0.3' media='all' />