<?php 
	$certificates = (new Tutor\Certificate\Builder\Utils)->get_certificates(get_current_user_id(), array('publish', 'pending', 'draft'));
?>

<div class="<?php echo is_admin() ? 'tutor-option-single-item' : ''; ?>">
	<h4><?php _e('All Certificates', 'tutor-lms-certificate-builder'); ?></h4>
	<table class="tutor-ui-table tutor-ui-table-responsive tutor-no-thead tutor-bg-white">
		<tbody>
			<?php foreach($certificates as $certificate): ?>
				<?php $row_id = 'tutor-cb-row-id-' . $certificate->ID; ?>
				<tr id="<?php echo $row_id; ?>">
					<td data-th="Certificate" class="column-fullwidth">
						<div class="td-course text-medium-body color-text-primary">
							<div class="tutor-bs-row tutor-bs-align-items-center">
								<?php 
									if($certificate->thumbnail_url) {
										?>
										<div class="tutor-bs-col-auto">
											<img style="width:90px; height:auto;" src="<?php echo esc_url($certificate->thumbnail_url); ?>"/>
										</div>
										<?php
									}
								?>
								<div class="tutor-bs-col">
									<span class="td-course text-medium-body color-text-primary tutor-bs-d-block">
										<?php esc_html_e( $certificate->post_title ); ?>
									</span>
									<span class="text-regular-small color-text-primary">
										<strong><?php _e('Category', 'tutor-lms-certificate-builder'); ?>:</strong>&nbsp;
										Dummy, Dummy, Dummy
									</span>
								</div>
							</div>
						</div>
					</td>
					<td data-th="Action">
						<div class="tutor-option-field-input d-flex has-btn-after">
							<div class="tutor-form-select-with-icon select-primary">
								<select title="Please select a color">
									<option value="draft" <?php selected($certificate->post_status, 'draft'); ?>><?php _e('Draft', 'tutor-lms-certificate-builder'); ?></option>
									<option value="publish" <?php selected($certificate->post_status, 'publish'); ?>><?php _e('Published', 'tutor-lms-certificate-builder'); ?></option>
								</select>
								<i class="icon1 ttr-eye-fill-filled"></i>
								<i class="icon2 ttr-angle-down-filled"></i>
							</div>
							<a href="<?php echo $certificate->edit_url; ?>">Edit</a>
							<span 	class="tutor-list-ajax-action" 
									data-url="<?php echo $certificate->delete_url; ?>"
									data-prompt="Sure to delete?" 
									data-delete_id="<?php echo $row_id; ?>">
								Delete
							</span>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

