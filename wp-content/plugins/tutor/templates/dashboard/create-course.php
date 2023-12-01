<?php

/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */


if (!defined('ABSPATH')) {
	exit;
}

global $post;

get_tutor_header(true);
do_action('tutor_load_template_before', 'dashboard.create-course', null);

$course_id          = get_the_ID();
$can_publish_course = (bool) tutor_utils()->get_option('instructor_can_publish_course') || current_user_can('administrator');
?>

<?php
if (!tutor_utils()->can_user_edit_course(get_current_user_id(), $course_id)) {
	$args = array(
		'headline'    => __('Permission Denied', 'tutor'),
		'message'     => __('You don\'t have the right to edit this course', 'tutor'),
		'description' => __('Please make sure you are logged in to correct account', 'tutor'),
		'button'      => array(
			'url'  => get_permalink($course_id),
			'text' => __('View Course', 'tutor'),
		),
	);

	tutor_load_template('permission-denied', $args);
	return;
}
?>

<?php do_action('tutor/dashboard_course_builder_before'); ?>
<form action="" id="tutor-frontend-course-builder" method="post" enctype="multipart/form-data">
	<?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>

	<!-- Sticky header with course action buttons -->
	<header class="tutor-dashboard-builder-header tutor-mb-32">
		<div class="tutor-container-fluid">
			<div class="tutor-row tutor-align-items-center">
				<div class="tutor-col-auto">
					<div class="tutor-dashboard-builder-header-left">
						<div class="tutor-dashboard-builder-logo">
							<?php //$tutor_course_builder_logo_src = apply_filters('tutor_course_builder_logo_src', tutor()->url . 'assets/images/tutor-logo.png'); ?>
							<img loading="lazy" width="284" height="57" src="<?php echo THEME_URL;?>/component/img/logo.svg" alt="" title="vus-logo-sticky" class="wp-image-10"></span>
						</div>
						<button type="submit" class="tutor-dashboard-builder-draft-btn" name="course_submit_btn" value="save_course_as_draft">
							<!-- @TODO: Icon must be chenged -->
							<i class="tutor-icon-save-line tutor-icon-28"></i>
							<span class="tutor-color-black-60"><?php _e('Save', 'tutor'); ?></span>
						</button>
					</div>
				</div>
				<div class="tutor-col tutor-mt-12 tutor-mb-12">
					<div class="tutor-dashboard-builder-header-right tutor-d-flex tutor-align-items-center tutor-justify-content-end">
						<a class="tutor-btn tutor-btn-tertiary tutor-is-outline tutor-btn-sm" href="<?php echo esc_url( get_the_permalink($course_id) ); ?>" target="_blank">
							<?php _e('Preview', 'tutor'); ?>
						</a>
						<?php if ($can_publish_course): ?>
							<button class="tutor-btn tutor-btn-primary tutor-btn-sm tutor-ml-16" type="submit" name="course_submit_btn" value="publish_course">
								<?php _e('Publish', 'tutor'); ?>
							</button>
						<?php else: ?>
							<button class="tutor-btn tutor-btn-primary tutor-btn-sm tutor-ml-16" type="submit" name="course_submit_btn" value="submit_for_review" title="<?php _e('Submit for Review', 'tutor'); ?>">
								<?php _e('Submit', 'tutor'); ?>
							</button>
						<?php endif; ?>
						<a href="<?php echo tutor_utils()->tutor_dashboard_url(); ?>" class="tutor-icon-line-cross-line tutor-ml-16" title="<?php _e('Exit', 'tutor'); ?>" style="font-size: 32px;color: #9CA0AC;"></a>
					</div>
				</div>
			</div>
		</div>
	</header>

	<!-- Course builder body -->
	<div class="tutor-container">
		<div class="tutor-row">
			<div class="tutor-col-12 tutor-col-lg-9 tutor-mb-32 tutor-pr-32">
				<input type="hidden" value="tutor_add_course_builder" name="tutor_action" />
				<input type="hidden" name="course_ID" id="course_ID" value="<?php echo get_the_ID(); ?>">
				<input type="hidden" name="post_ID" id="post_ID" value="<?php echo get_the_ID(); ?>">

				<!--since 1.8.0 alert message -->
				<?php
				$user_id = get_current_user_id();
				$expires = get_user_meta($user_id, 'tutor_frontend_course_message_expires', true);
				$message = get_user_meta($user_id, 'tutor_frontend_course_action_message', true);

				if ($message && $expires && $expires > time()) {
					$show_modal = $message['show_modal'];
					$message    = $message['message'];

					if (!$show_modal) {
					?>
						<div class="tutor-alert tutor-alert-info">
							<?php echo $message; ?>
						</div>
					<?php } else { ?>
						<div id="modal-course-save-feedback" class="tutor-modal tutor-is-active tutor-modal-is-close-inside-header">
							<span class="tutor-modal-overlay"></span>
							<div class="tutor-modal-root">
								<div class="tutor-modal-inner tutor-modal-close-inner">
									<button data-tutor-modal-close class="tutor-modal-close">
										<span class="tutor-icon-line-cross-line tutor-icon-30 tutor-color-black-40"></span>
									</button>
									<div class="tutor-text-center tutor-mt-80 tutor-px-48 tutor-pb-md-80 tutor-pb-48">
										<div class="tutor-modal-icon tutor-flex-center">
											<img src="<?php echo tutor()->url; ?>/assets/images/icon-cup.svg" alt="" />
										</div>
										<div class="tutor-modal-text-wrap tutor-mt-24">
											<div class="tutor-modal-title tutor-fs-4 tutor-fw-normal tutor-color-black"><?php _e('Thank You!', 'tutor'); ?></div>
											<div class="tutor-fs-6 tutor-fw-normal tutor-text-subsued tutor-mt-20"><?php echo $message; ?></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<script>
							const alertBox = document.getElementById('modal-course-save-feedback');
							setTimeout(() => {
								if (alertBox) alertBox.classList.remove('tutor-is-active');
							}, 5000)
						</script>
				<?php
					}
				}

				if ($message || $expires) {
					delete_user_meta($user_id, 'tutor_frontend_course_message_expires');
					delete_user_meta($user_id, 'tutor_frontend_course_action_message');
				}
				?>
				<!--alert message end -->
				<?php do_action('tutor/dashboard_course_builder_form_field_before'); ?>

				<div class="tutor-course-builder-section tutor-course-builder-info">
					<div class="tutor-course-builder-section-title">
						<h3>
							<i class="color-text-brand tutor-icon-angle-up-filled tutor-icon-26"></i>
							<span><?php esc_html_e('Course Info', 'tutor'); ?></span>
						</h3>
					</div>

					<div class="__c_group">
						<label class="tutor-form-label tutor-font-size-16">
							<span class="_lbl" style="font-weight: bold;"><?php _e('Course type', 'tutor'); ?></span><br/>
						</label>

						<div class="row mb-3">
							<?php
							/** NhatHuy - NoteBegin */
							/** NhatHuy - Course type */
								$course_types = tutor_utils()->course_types();
								$course_type = get_post_meta($course_id, '_tutor_course_type', true);
								$course_type = maybe_unserialize($course_type);
								foreach ($course_types as $coursetype_key => $coursetype){
							?>
									<div class="col-md-6 pb-1">
										<span for="<?php echo $coursetype_key; ?>">
										<input  <?php if(isset($course_type['course_type'])&& $course_type['course_type'] == $coursetype_key) echo 'checked="checked"'; ?> type="radio" id="<?php echo $coursetype_key; ?>" name="_tutor_course_type" value="<?php echo $coursetype_key; ?>"> <?php echo $coursetype; ?></span>
										<?php if($coursetype_key == "forexternal") { ?>
											( <input type="checkbox" <?php if(isset($course_type['course_type']) && isset($course_type['internal_pay_ot_not']) &&  $course_type['course_type'] == 'forexternal' && $course_type['internal_pay_ot_not'] == 'on') echo 'checked="checked"';?> name="internal_pay_ot_not" id="internal_pay_ot_not"> Free for internal )
										<?php
										}
										?>
									</div>
							<?php
								}
							/** NhatHuy - NoteEnd */	
							?>
							
						</div>
					</div>
					
					<?php 
					/** NhatHuy - Course Code */ 
						$course_code = get_post_meta($course_id, '_tutor_course_code', true);
						if($course_code){
							$coursecode_start = substr($course_code,0, -5);
							$coursecode_end = substr($course_code, -5);
						}
						else{
							$coursecode_start = "";
							$coursecode_end = str_pad(substr($course_id, -5), 5, '0', STR_PAD_LEFT);
						}
							
					?>
					<div class="__c_group tutor_course_code">
						<label class="tutor-form-label tutor-font-size-16">
							<span class="_lbl_" style="font-weight: bold;"><?php _e('Course Code', 'tutor'); ?></span><br/>
						</label>

						<div class="row mb-3">
							<div class="col-md-4 pb-2">
								<input id="tutor-course-code-start" type="text" name="_tutor_course_code_start" class="tutor-form-control" value="<?php echo $coursecode_start; ?>" placeholder="<?php _e('CO-', 'tutor'); ?>" maxlength="10">
								<?php echo $coursecode_end; ?>
								<input type="hidden" name="_tutor_course_code_end" value="<?php echo $coursecode_end; ?>" >
							</div>							
						</div>
					</div>
					<!--end NhatHuy-->
					
					<!--.tutor-course-builder-section-title-->
					<div class="tutor-course-builder-section-content">
						<div class="tutor-mb-32">
							<label class="tutor-course-field-label tutor-font-size-16 color-text-primary" style="font-weight: bold;"><?php _e('Course Title', 'tutor'); ?></label>
							<div id="tutor-course-create-title-tooltip-wrapper" class="tooltip-wrap tutor-d-block">
								<span class="tooltip-txt tooltip-right tutor-mt-12">
									<?php _e('255', 'tutor'); ?>
								</span>
								<input id="tutor-course-create-title" type="text" name="title" class="tutor-form-control" value="<?php echo get_the_title(); ?>" placeholder="<?php _e('ex. Learn photoshop CS6 from scratch', 'tutor'); ?>" maxlength="255">
							</div>
						</div>

						<div class="tutor-mb-32">
							<label class="tutor-course-field-label tutor-font-size-16 color-text-primary"><?php _e('About Course', 'tutor'); ?></label>
							<div class="tutor-input-group tutor-mb-16">
								<?php
								$editor_settings = array(
									'media_buttons' => false,
									'quicktags'     => false,
									'editor_height' => 150,
									'textarea_name' => 'content',
									'statusbar'     => false,
								);
								wp_editor($post->post_content, 'course_description', $editor_settings);
								?>
							</div>
						</div>

						<?php //do_action('tutor/frontend_course_edit/after/description', $post); ?>

						
						<div class="tutor-frontend-builder-item-scope">

							

							<div class="tutor-form-group">
								<label class="tutor-form-label tutor-font-size-16">
									<?php _e('Choose a category', 'tutor'); ?>
								</label>
								<div class="tutor-form-field-course-categories">
									<?php
									//echo tutor_course_categories_checkbox($course_id);
									echo tutor_course_categories_dropdown($course_id, array('classes' => 'tutor_select2'));
									?>
								</div>
							</div>
						</div>

						<?php do_action('tutor/frontend_course_edit/after/category', $post); ?>

						<!--- COURSE PARENT --->
						<div class="tutor-frontend-builder-item-scope">
							<div class="tutor-form-group">
								<label class="tutor-form-label tutor-font-size-16">
									<span class="_lbl" style="font-weight: bold;"><?php _e('Course relative', 'tutor'); ?></span><br/>


								</label>

								
								<?php
									// echo tutor_course_categories_checkbox($course_id);
									// echo tutor_course_list_dropdown($course_id, array('classes' => 'tutor_select2')); //NhatHuy edited removed this 
									$courses_list = tutor_utils()->get_courses_list();
									$parent_ids = get_post_meta( $course_id, '_tutor_course_parent', true );
									$parent_ids_arr = explode(" ",$parent_ids);
									$children_ids = get_post_meta( $course_id, '_tutor_course_children', true );
									$children_ids_arr = explode(" ",$children_ids);
									//$parent_id = wp_get_post_parent_id($course_id);
								?>
								
								<div class="tutor-default-tab tutor-course-details-tab">
                    
									<div class="tab-header tutor-d-flex">
										<div class="tab-header-item is-active" data-tutor-tab-target="tutor-course-parent-tab">
											<span><?php _e('Parent Course', 'tutor'); ?></span>
										</div>
										<div class="tab-header-item" data-tutor-tab-target="tutor-course-children-tab">
											<span><?php _e('Children Courses', 'tutor'); ?></span>
										</div>
															
									</div>
									<div class="tab-body">
										<div class="tab-body-item is-active" id="tutor-course-parent-tab">
											<div class="tab-item-content ">
												<div class="tutor-form-field-course-list">
													<select name="_tutor_course_parent[]" multiple='multiple' class="tutor_select2" class="tutor-form-select" data-placeholder="Type to search Parent Course">
														
												<?php
												foreach($courses_list as $citem) {
													if($citem->ID==$course_id) continue;	// HuyNote: do not get current course
													echo '<option ';
													if (in_array($citem->ID, $parent_ids_arr)) echo ' selected="true" ';
													//if($parent_id == $citem->ID)  echo ' selected="true" ';
													echo ' value="'. $citem->ID.'">' . $citem->post_title . '</option>';
												}
												?>
												</select></div>												
											</div>

										</div>
										<div class="tab-body-item" id="tutor-course-children-tab">
																		
											<div class="row justify-content-center">
												<div class="col-6">
												  <?php _e('Available Courses', 'tutor'); ?>
													<ul id="list1" class="sortable">
														<?php
														foreach($courses_list as $citem) {
															if($citem->ID==$course_id) continue;	// HuyNote: do not get current course
															if (in_array($citem->ID, $children_ids_arr)) continue;
															echo '<li id="'. $citem->ID.'">' . $citem->post_title . '</li>';
														}
														?>
													</ul>
												</div>
												<div class="col-6">
												  <?php _e('Selected Courses', 'tutor'); ?>												  
													<ul id="list2" class="sortable">
														<?php

														foreach($children_ids_arr as $cia) {
															if($cia) echo '<li id="'. $cia.'">' . get_the_title($cia) . '</li>';
														}
														?>
													</ul>
												</div>
											</div>
											<div class="row justify-content-center">
											<p><i>(<?php _e('Double click to add or remove. Drag and drop to sort.', 'tutor'); ?>)</i></p>
											</div>
											<input id="_tutor_course_parent_old" type="hidden" name="_tutor_course_parent_old" value="<?php echo $parent_ids; ?>" >
											<input id="_tutor_course_children_old" type="hidden" name="_tutor_course_children_old" value="<?php echo $children_ids; ?>" >
											<input id="_tutor_course_children" type="hidden" name="_tutor_course_children" value="<?php echo $children_ids; ?>" >
											<?php wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/js/jquery.multisortable.js', array ( 'jquery' ), 1.1, true);?>
											<script type="text/javascript">//<![CDATA[


											jQuery(function($){
												$('ul.sortable').multisortable({
													stop: function(e){
														var phrase = '';
														$('ul#list2').find('li').each(function(){
															var current = $(this);
															phrase += current.attr('id')+" ";
														});
														$('#_tutor_course_children').val(phrase);
													}
												});
												$('ul#list1').sortable('option', 'connectWith', 'ul#list2');
												$('ul#list2').sortable('option', 'connectWith', 'ul#list1');
												$(document).on("dblclick", "ul.sortable li", function(e) {
													$(this).removeClass( "selected" );
													if($(this).parent().attr('id')=='list1')
														$('ul#list2').append($(this).prop('outerHTML'));
													else $('ul#list1').append($(this).prop('outerHTML'));
													$(this).remove();
													
													var phrase = '';
													$('ul#list2').find('li').each(function(){
														var current = $(this);
														phrase += current.attr('id')+" ";
													});
													$('#_tutor_course_children').val(phrase);
														
												});	
											});


											  //]]>
											  </script>

										</div>
									</div>
								</div>
							</div>
						</div>
						<!--- ./COURSE PARENT --->


						<?php
						$monetize_by = tutils()->get_option('monetize_by');
						if ($monetize_by === 'wc' || $monetize_by === 'edd') {
							$course_price    = tutor_utils()->get_raw_course_price(get_the_ID());
							$currency_symbol = tutor_utils()->currency_symbol();

							$_tutor_course_price_type = tutils()->price_type();
						?>
							<div class="tutor-row tutor-align-items-center tutor-mb-32">
								<div class="tutor-col-12">
									<label class="tutor-form-label tutor-font-size-16"><?php _e('Course Price', 'tutor'); ?></label>
								</div>
								<div class="tutor-col-6 tutor-col-sm-5 tutor-col-lg-4">
									<div class="tutor-form-check tutor-align-items-center">
										<input type="radio" id="tutor_price_paid" class="tutor-form-check-input tutor-flex-shrink-0" name="tutor_course_price_type" value="paid" <?php checked($_tutor_course_price_type, 'paid'); ?> />
										<label for="tutor_price_paid" class="tutor-amount-field">
											<span class="tutor-input-prepand">
												<?php echo $currency_symbol; ?>
											</span>
											<input type="number" class="tutor-form-number-verify tutor-pl-12" name="course_price" value="<?php echo $course_price->regular_price; ?>" placeholder="<?php _e('Set course price', 'tutor'); ?>" min="0">
										</label>
									</div>
								</div>
								<div class="tutor-col-6 tutor-col-sm-5 tutor-col-lg-4">
									<div class="tutor-form-check tutor-align-items-center">
										<input type="radio" id="tutor_price_free" class="tutor-form-check-input tutor-flex-shrink-0" name="tutor_course_price_type" value="free" <?php $_tutor_course_price_type ? checked($_tutor_course_price_type, 'free') : checked('true', 'true'); ?> />
										<label for="tutor_price_free" class="tutor-font-size-15">
											<?php _e('Free', 'tutor'); ?>
										</label>
									</div>
								</div>
							</div>
						<?php
						}
						?>

						<div class="tutor-mb-32">
							<label class="tutor-course-field-label tutor-font-size-16"><?php _e('Course Thumbnail', 'tutor'); ?></label>
							<div class="tutor-input-group tutor-mb-16">
								<?php
								tutor_load_template_from_custom_path(
									tutor()->path . '/views/fragments/thumbnail-uploader.php',
									array(
										'media_id'    => get_post_thumbnail_id($course_id),
										'input_name'  => 'tutor_course_thumbnail_id',
										'placeholder' => tutor()->url . '/assets/images/thumbnail-placeholder.svg',
										'borderless'  => true,
										'background'  => '#E3E6EB',
										'border'      => '#E3E6EB',
									),
									false
								);
								?>
							</div>
						</div>

						<div class="tutor-mb-32">
							<label class="tutor-course-field-label tutor-font-size-16"><?php _e('Course Banner', 'tutor'); ?></label>
							<div class="tutor-input-group tutor-mb-16">
								<?php
								tutor_load_template_from_custom_path(
									tutor()->path . '/views/fragments/banner-uploader.php',
									array(
										'media_id'    => get_field('course_banner_image', $course_id),
										'input_name'  => 'tutor_course_banner_id',
										'placeholder' => tutor()->url . '/assets/images/thumbnail-placeholder.svg',
										'borderless'  => true,
										'background'  => '#E3E6EB',
										'border'      => '#E3E6EB',
									),
									false
								);
								?>
							</div>
						</div>

						<?php do_action('tutor/frontend_course_edit/after/thumbnail', $post); ?>
					</div>
				</div>
				<div class="tutor-course-builder-section tutor-course-builder-info tutor-course-builder-section-attachments ">
					<div class="tutor-course-builder-section-title">
						<h3>
							<i class="color-text-brand tutor-icon-angle-up-filled tutor-icon-26"></i>
							<span><?php esc_html_e('Attachments', 'tutor'); ?></span>
						</h3>
					</div>
				<?php 
					include tutor()->path.'views/metabox/lesson-attachments-metabox.php';
					do_action( 'tutor_lesson_edit_modal_after_attachment' );
				?>
				</div>	
				

				<?php do_action('tutor/dashboard_course_builder_form_field_after', $post); ?>
				
				<?php do_action('tutor/frontend_course_edit/after/description', $post); ?>
				

				<div class="tutor-form-row">
					<div class="tutor-form-col-12">
						<div class="tutor-form-group">
							<div class="tutor-form-field tutor-course-builder-btn-group">
								<button type="submit" class="tutor-btn tutor-btn-tertiary tutor-is-outline tutor-btn-sm" name="course_submit_btn" value="save_course_as_draft"><?php _e('Save as Draft', 'tutor'); ?></button>
								<?php if ($can_publish_course) { ?>
									<button class="tutor-btn tutor-btn-primary" type="submit" name="course_submit_btn" value="publish_course"><?php _e('Publish Course', 'tutor'); ?></button>
								<?php } else { ?>
									<button class="tutor-btn" type="submit" name="course_submit_btn" value="submit_for_review"><?php _e('Submit for Review', 'tutor'); ?></button>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>

			</div>

			<!-- Course builder tips right sidebar -->
			<div class="tutor-col-12 tutor-col-lg-3 tutor-mb-32 tutor-pl-30">
				<div class="tutor-course-builder-upload-tips">
					<h3 class="text-regular-body tutor-mb-20">
						<strong>
							<?php _e('Course Upload Tips', 'tutor'); ?>
						</strong>
					</h3>
					<ul>
						<li class="tutor-mb-20"><?php _e('Set the Course Price option or make it free.', 'tutor'); ?></li>
						<li class="tutor-mb-20"><?php _e('Standard size for the course thumbnail is 700x430.', 'tutor'); ?></li>
						<li class="tutor-mb-20"><?php _e('Video section controls the course overview video.', 'tutor'); ?></li>
						<li class="tutor-mb-20"><?php _e('Course Builder is where you create & organize a course.', 'tutor'); ?></li>
						<li class="tutor-mb-20"><?php _e('Add Sections in the Course Builder section to create lessons, quizzes, and assignments.', 'tutor'); ?></li>
						<li class="tutor-mb-20"><?php _e('Prerequisites refers to the fundamental courses to complete before taking this particular course.', 'tutor'); ?></li>
						<li class="tutor-mb-20"><?php _e('Information from the Additional Data section shows up on the course single page.', 'tutor'); ?></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</form>
<?php do_action('tutor/dashboard_course_builder_after'); ?>


<?php
do_action('tutor_load_template_after', 'dashboard.create-course', null);
get_tutor_footer(true); ?>