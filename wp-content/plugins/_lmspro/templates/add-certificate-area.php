<?php if(is_admin()): ?>
	<div class="tutor-option-single-item create-certificate-steps">
		<div class="item-wrapper" style="background-image:url(<?php echo TUTOR_CB_PLUGIN_URL; ?>assets/images/certificate-illustration.svg); background-size:50%;">
			<h4>
				Create Your Certificate <br>
				In 3 Steps
			</h4>
			<ul>
				<li>Select your favorite design</li>
				<li>Type in your text &amp; upload your signature</li>
				<li><strong>Press Save,</strong>Your certificate Ready</li>
			</ul>
			<div class="create-certificate-btn">
				<button class="tutor-btn" href="<?php echo Tutor\Certificate\Builder\Helper::certificate_builder_url(); ?>">
					<!-- <span class="tutor-btn-icon las la-file-signature"></span> -->
					<span class="ttr tutor-btn-icon tutor-v2-icon-test icon-certificate-filled"></span>
					<span>
						<?php _e('Create certificate', 'tutor-lms-certificate-builder'); ?>
					</span>
				</button>
			</div>
		</div>
	</div>
<?php else: ?>

<?php endif; ?>

