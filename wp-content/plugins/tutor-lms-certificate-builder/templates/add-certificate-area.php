<?php if(is_admin()): ?>
	<div class="tutor-option-single-item create-certificate-steps">
		<div class="item-wrapper" style="background-image:url(<?php echo TUTOR_CB_PLUGIN_URL; ?>assets/images/certificate-illustration.svg);">
			<h4>
				<?php _e('Create Your Certificate', 'tutor-lms-certificate-builder'); ?> <br>
				<?php _e('In 3 Steps', 'tutor-lms-certificate-builder'); ?>
			</h4>
			<ul>
				<li><?php _e('Select your favorite design', 'tutor-lms-certificate-builder'); ?></li>
				<li><?php _e('Type in your text &amp; upload your signature', 'tutor-lms-certificate-builder'); ?></li>
				<li>
					<strong><?php _e('Press Save', 'tutor'); ?>,</strong>&nbsp;
					<?php _e('Your certificate Ready', 'tutor'); ?>
				</li>
			</ul>
			<div class="tutor-mt-32">
				<a class="tutor-btn tutor-btn-primary" href="<?php echo Tutor\Certificate\Builder\Helper::certificate_builder_url(); ?>">
					<span class="tutor-icon-certificate-landscape tutor-btn-icon tutor-mr-8"></span>
					<span>
						<?php _e('Create certificate', 'tutor-lms-certificate-builder'); ?>
					</span>
				</a>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="tutor-option-single-item create-certificate-steps">
		<div class="item-wrapper" style="background-image:url(<?php echo TUTOR_CB_PLUGIN_URL; ?>assets/images/certificate-illustrations-front.svg);">
			<div class="color-text-primary tutor-text-bold-h5">
				<?php _e('Create Your Certificate In 3 Steps', 'tutor-lms-certificate-builder'); ?>
			</div>
			<div class="tutor-certificate-step-description color-text-subused tutor-text-regular-caption">
				<?php _e('Add instructor, Benefits , Requirements/Instructions, Targeted Audience, Materials Included', 'tutor-lms-certificate-builder'); ?>
			</div>
			<div class="tutor-mt-32">
				<a class="tutor-btn tutor-btn-primary" href="<?php echo Tutor\Certificate\Builder\Helper::certificate_builder_url(); ?>">
					<span class="tutor-icon-certificate-landscape tutor-btn-icon tutor-mr-8"></span>
					<span>
						<?php _e('Create certificate', 'tutor-lms-certificate-builder'); ?>
					</span>
				</a>
			</div>
		</div>
	</div>
<?php endif; ?>