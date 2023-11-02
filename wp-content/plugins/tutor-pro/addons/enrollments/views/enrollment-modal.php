<form action="" id="tutor-manual-enrollment-form" method="POST">
	<div id="enrollment-modal" class="tutor-modal tutor-modal-scrollable<?php echo is_admin() ? ' tutor-admin-design-init' : ''; ?>">
		<div class="tutor-modal-overlay"></div>
		<div class="tutor-modal-window">
			<div class="tutor-modal-content">

				<div class="tutor-modal-header">
					<div class="tutor-modal-title">
						<?php _e( 'Manual Enrollment', 'tutor-pro' ) ?>
					</div>
					
					<button class="tutor-iconic-btn tutor-modal-close" data-tutor-modal-close>
						<span class="tutor-icon-times" area-hidden="true"></span>
					</button>
				</div>

				<div class="tutor-modal-body">
					<div class="tutor-mb-32">
						<label class="tutor-form-label"><?php _e('Course', 'tutor'); ?></label>
						<?php $courses = tutor_utils()->get_courses( array( get_the_ID() ), array( 'publish', 'private' ) ); ?>
						<select name="course_id" class="tutor-form-select tutor-mw-100" required="required">
								<option value=""><?php _e( 'Select a course', 'tutor' ); ?></option>
								<?php
								foreach ( $courses as $course):
									echo "<option value='{$course->ID}'>{$course->post_title}</option>";
								endforeach;
								?>
						</select>  
					</div>

					<div>
						<label class="tutor-form-label"><?php _e('Student', 'tutor'); ?></label>
						
						<div class="tutor-form-wrap tutor-options-search">
							<span class="tutor-search-loader tutor-form-icon tutor-icon-search" area-hidden="true"></span>
							<input disabled="disabled" type="text" class="tutor-form-control tutor-search-input" placeholder="Search student..">
						</div>
						
						<!-- search result wrapper. do not remove -->
						<div class="tutor-search-result tutor-mt-12"></div>
						<!-- selected result wrapper. do not remove -->
						<div class="tutor-search-selected tutor-mt-12"></div>

					</div>

				</div>
				<!-- # modal body -->

				<div class="tutor-modal-footer">
					<button class="tutor-btn tutor-btn-outline-primary" data-tutor-modal-close>
						<?php _e('Cancel', 'tutor-pro'); ?>
					</button>

					<button type="submit" class="tutor-btn tutor-btn-primary tutor-btn-submit">
						<?php _e( 'Enroll Now', 'tutor-pro' ) ?>
					</button>
				</div>
				<!-- # modal footer -->
			</div>
		</div>
	</div>
</form>