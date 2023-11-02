<div class="<?php echo is_admin() ? 'tutor-option-single-item' : ''; ?> tutor-cb-templates-table">

	<?php 
		$per_page = 15;
		$current_page = max( 1, tutor_utils()->avalue_dot('current_page', $_GET) );
		$utils_object = new Tutor\Certificate\Builder\Utils;
		$author_id = tutor_utils()->has_user_role('administrator') ? null : get_current_user_id();
		$certificates = $utils_object->get_certificates($current_page, $per_page, $author_id, array('publish', 'pending', 'draft'));
		$certificates_total = $utils_object->get_certificates(0, -1, $author_id, array('publish', 'pending', 'draft'), true);

		// Load head section if frontend
		// Admin side has different layout for it
		if(!is_admin()) {
			require __DIR__ . '/add-certificate-area.php';
		}
	?>

	<?php if(!is_admin()): ?>
		<div class="tutor-fs-6 color-color-muted tutor-mb-16">
			<?php _e('All Certificates', 'tutor-lms-certificate-builder'); ?>
		</div>
	<?php endif; ?>

	<?php if(!empty($certificates)) : ?>
		<div class="tutor-card">
			<div class="tutor-card-list">
				<?php foreach($certificates as $certificate): ?>
					<?php 
						$row_id = 'tutor-cb-row-id-' . $certificate->ID; 
						$delete_id = 'tutor-modal-tutor-cb-row-del-' . $certificate->ID; 
					?>
					<div id="<?php echo $row_id; ?>" class="tutor-card-list-item tutor-p-16">
						<div class="tutor-row tutor-align-items-center">
							<div class="tutor-col tutor-d-flex tutor-align-items-center">
								<?php if($certificate->thumbnail_url) : ?>
									<div class="tutor-mr-16">
										<img style="width:90px; height:auto;" src="<?php echo esc_url($certificate->thumbnail_url); ?>"/>
									</div>
								<?php endif; ?>
								<span class="tutor-fs-6 tutor-fw-medium tutor-color-black">
									<?php esc_html_e( $certificate->post_title ); ?>
								</span>
							</div>

							<div class="tutor-col-auto">
								<div class="tutor-option-field-input d-flex has-btn-after tutor-justify-content-end">
									<div class="tutor-form-select-with-icon <?php echo $certificate->post_status=='draft' ? 'select-default' : 'select-success'; ?>">
										<select class="tutor-cb-status tutor-table-row-status-update" title="<?php _e('Set certificate template status', 'tutor-lms-certificate-builder'); ?>" data-status_key="status" data-template_id="<?php echo $certificate->ID; ?>" data-action="tutor_cb_template_status_update">
											<option data-status_class="select-default" value="draft" <?php selected($certificate->post_status, 'draft'); ?>>
												<?php _e('Draft', 'tutor-lms-certificate-builder'); ?>
											</option>
											<option data-status_class="select-success" value="publish" <?php selected($certificate->post_status, 'publish'); ?>>
												<?php _e('Published', 'tutor-lms-certificate-builder'); ?>
											</option>
										</select>
										<i class="icon1 tutor-icon-eye-bold" area-hidden="true"></i>
										<i class="icon2 tutor-icon-eye-slash-bold" area-hidden="true"></i>
									</div>

									<a href="<?php echo $certificate->edit_url; ?>" class="tutor-iconic-btn tutor-ml-16">
										<i class="tutor-icon-edit" area-hidden="true"></i>
									</a>

									<span data-tutor-modal-target="<?php echo $delete_id; ?>" class="tutor-iconic-btn tutor-ml-12">
										<i class="tutor-icon-trash-can-line" area-hidden="true"></i>
									</span>
								</div>

								<?php
									// Delete modal
									tutor_load_template( 'modal.confirm', array(
										'id' => $delete_id,
										'image' => 'icon-trash.svg',
										'title' => __('Do You Want to Delete This Certificate?', 'tutor-lms-certificate-builder'),
										'content' => __('Are you sure you want to delete this certificate permanently from the site? Please confirm your choice.', 'tutor-lms-certificate-builder'),
										'yes' => array(
											'text' => __('Yes, Delete This', 'tutor-lms-certificate-builder'),
											'class' => 'tutor-list-ajax-action',
											'attr' => array('data-request_data=\'{"action":"tutor_delete_certificate_template", "certificate_id":"' . $certificate->ID . '"}\'', 'data-delete_element_id="' . $row_id . '"')
										),
									));
								?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="tutor-admin-page-pagination-wrapper tutor-mt-32">
			<?php
				/**
				 * Prepare pagination data & load template
				 */
				if($certificates_total > $per_page) {
					$pagination_data     = array(
						'base'		  => '?current_page=%#%',
						'total_items' => $certificates_total,
						'per_page'    => $per_page,
						'paged'       => $current_page,
					);
					$pagination_template = tutor()->path . 'views/elements/pagination.php';
					tutor_load_template_from_custom_path( $pagination_template, $pagination_data );
				}
			?>
		</div>
	<?php else: ?>
		<?php tutor_utils()->tutor_empty_state( __('No certificate!', 'tutor-lms-certificate-builder') ); ?>
	<?php endif; ?>
</div>