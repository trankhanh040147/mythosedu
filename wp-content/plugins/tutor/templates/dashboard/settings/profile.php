<?php
/**
 * @package TutorLMS/Templates
 * @version 1.6.2
 */

$user = wp_get_current_user();

// Prepare profile pic
$profile_placeholder = tutor()->url . 'assets/images/profile-photo.png';
$profile_photo_src   = $profile_placeholder;
$profile_photo_id    = get_user_meta( $user->ID, '_tutor_profile_photo', true );


if ( $profile_photo_id ) {
	$url                                 = wp_get_attachment_image_url( $profile_photo_id, 'full' );
	! empty( $url ) ? $profile_photo_src = $url : 0;
}

// Prepare cover photo
$cover_placeholder = tutor()->url . 'assets/images/cover-photo.jpg';
$cover_photo_src   = $cover_placeholder;
$cover_photo_id    = get_user_meta( $user->ID, '_tutor_cover_photo', true );
if ( $cover_photo_id ) {
	$url                               = wp_get_attachment_image_url( $cover_photo_id, 'full' );
	! empty( $url ) ? $cover_photo_src = $url : 0;
}

// Prepare display name
$public_display                     = array();
$public_display['display_nickname'] = $user->nickname;
$public_display['display_username'] = $user->user_login;

if ( ! empty( $user->first_name ) ) {
	$public_display['display_firstname'] = $user->first_name;
}

if ( ! empty( $user->last_name ) ) {
	$public_display['display_lastname'] = $user->last_name;
}

if ( ! empty( $user->first_name ) && ! empty( $user->last_name ) ) {
	$public_display['display_firstlast'] = $user->first_name . ' ' . $user->last_name;
	$public_display['display_lastfirst'] = $user->last_name . ' ' . $user->first_name;
}

if ( ! in_array( $user->display_name, $public_display ) ) { // Only add this if it isn't duplicated elsewhere
	$public_display = array( 'display_displayname' => $user->display_name ) + $public_display;
}

$public_display = array_map( 'trim', $public_display );
$public_display = array_unique( $public_display );
$max_filesize = floatval(ini_get('upload_max_filesize')) * (1024 * 1024);
// $max_filesize = 1009;
?>

<div class="tutor-dashboard-setting-profile tutor-dashboard-content-inner">

	<?php do_action( 'tutor_profile_edit_form_before' ); ?>

	<div id="tutor_profile_cover_photo_editor">

		<input id="tutor_photo_dialogue_box" type="file" accept=".png,.jpg,.jpeg"/>
		<input type="hidden" class="upload_max_filesize" value="<?php echo $max_filesize; ?>">
		<div id="tutor_cover_area" data-fallback="<?php esc_attr_e( $cover_placeholder ); ?>" style="background-image:url(<?php echo esc_url( $cover_photo_src ); ?>)">
			<span class="tutor_cover_deleter">
				<span class="dashboard-profile-delete tutor-icon-delete-fill-filled"></span>
			</span>
			<div class="tutor_overlay">
				<button class="tutor_cover_uploader tutor-d-flex tutor-align-items-center">
					<i class="tutor-icon-camera-filled tutor-icon-24"></i>
					<span><?php echo $profile_photo_id ? esc_html__( 'Update Cover Photo', TPL_DOMAIN_LANG ) : esc_html__( 'Upload Cover Photo', TPL_DOMAIN_LANG ); ?></span>
				</button>
			</div>
		</div>
		<div id="tutor_photo_meta_area">
			<img src="<?php echo esc_url( tutor()->url . '/assets/images/' ); ?>info-icon.svg" />
			<span><?php esc_html_e( 'Profile Photo Size', TPL_DOMAIN_LANG ); ?>: <span><?php esc_html_e( '200x200', TPL_DOMAIN_LANG ); ?></span> <?php esc_html_e( 'pixels', TPL_DOMAIN_LANG ); ?></span>
			<span>&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_html_e( 'Cover Photo Size', TPL_DOMAIN_LANG ); ?>: <span><?php esc_html_e( '700x430', TPL_DOMAIN_LANG ); ?></span> <?php esc_html_e( 'pixels', TPL_DOMAIN_LANG ); ?> </span>
			<span class="loader-area"><?php esc_html_e( 'Saving...', TPL_DOMAIN_LANG ); ?></span>
		</div>
		<div id="tutor_profile_area" data-fallback="<?php esc_attr_e( $profile_placeholder ); ?>" style="background-image:url(<?php echo esc_url( $profile_photo_src ); ?>)">
			<div class="tutor_overlay">
				<i class="tutor-icon-camera-filled tutor-icon-24"></i>
			</div>
		</div>
		<div id="tutor_pp_option">
			<div class="up-arrow">
				<i></i>
			</div>

			<span class="tutor_pp_uploader profile-uploader">
				<i class="profile-upload-icon tutor-icon-image-filled"></i> <?php esc_html_e( 'Upload Photo', TPL_DOMAIN_LANG ); ?>
			</span>
			<span class="tutor_pp_deleter profile-uploader">
				<i class="profile-upload-icon tutor-icon-delete-fill-filled"></i> <?php esc_html_e( 'Delete', TPL_DOMAIN_LANG ); ?>
			</span>

			<div></div>
		</div>
	</div>

	<form action="" method="post" enctype="multipart/form-data">
		<?php
		$errors = apply_filters( 'tutor_profile_edit_validation_errors', array() );
		if ( is_array( $errors ) && count( $errors ) ) {
			echo '<div class="tutor-alert-warning tutor-mb-12"><ul class="tutor-required-fields">';
			foreach ( $errors as $error_key => $error_value ) {
				echo "<li>{$error_value}</li>";
			}
			echo '</ul></div>';
		}
		?>

		<?php do_action( 'tutor_profile_edit_input_before' ); ?>

		<div class="tutor-row">
			<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-12 tutor-col-lg-6 mb-3">
				<label class="tutor-form-label tutor-color-black-60">
					<?php esc_html_e( 'Name', TPL_DOMAIN_LANG ); ?>
				</label>
				<input class="tutor-form-control" type="text" disabled="disabled" name="first_name" value="<?php esc_html_e( get_user_meta( $user->ID, '_fullname', true )); ?>" placeholder="<?php esc_attr_e( 'Full Name', TPL_DOMAIN_LANG ); ?>">
			</div>

			<!-- <div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-12 tutor-col-lg-6 mb-3">
				<label class="tutor-form-label tutor-color-black-60">
					<?php //esc_html_e( 'Last Name', TPL_DOMAIN_LANG ); ?>
				</label>
				<input class="tutor-form-control" type="text" name="last_name" value="<?php //esc_attr_e( $user->last_name ); ?>" placeholder="<?php //esc_attr_e( 'Last Name', TPL_DOMAIN_LANG ); ?>">
			</div> -->
		</div>

		<div class="tutor-row">
			<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-12 tutor-col-lg-6 mb-3">
				<label class="tutor-form-label tutor-color-black-60">
					<?php esc_html_e( 'User Name', TPL_DOMAIN_LANG ); ?>
				</label>
				<input class="tutor-form-control" type="text" disabled="disabled" value="<?php esc_attr_e( $user->user_login ); ?>">
			</div>

			<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-12 tutor-col-lg-6 mb-3">
				<label class="tutor-form-label tutor-color-black-60">
					<?php esc_html_e( 'Phone Number', TPL_DOMAIN_LANG ); ?>
				</label>
				<input class="tutor-form-control" type="tel" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" name="phone_number" value="<?php esc_html_e( filter_var( get_user_meta( $user->ID, 'billing_phone', true ), FILTER_SANITIZE_NUMBER_INT ) ); ?>" placeholder="<?php esc_attr_e( 'Phone Number', TPL_DOMAIN_LANG ); ?>">
			</div>
		</div>
		<div class="tutor-row">
			<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-12 tutor-col-lg-6 mb-3">
				<label class="tutor-form-label tutor-color-black-60">
					<?php esc_html_e( 'Gender', TPL_DOMAIN_LANG ); ?>
				</label>
				<?php 
					$_tutor_gender = esc_attr( get_user_meta( $user->ID, '_tutor_gender', true ) ); 
					if(!$_tutor_gender) $_tutor_gender = 'Others';
				?>
				<select name="_tutor_gender" id="tutor_gender" class="tutor-form-select">
					<option value="Male" <?php if($_tutor_gender=='Male') echo 'selected="selected"';?>>Male</option>
					<option value="Female" <?php if($_tutor_gender=='Female') echo 'selected="selected"';?>>Female</option>
					<option value="Others" <?php if($_tutor_gender=='Others') echo 'selected="selected"';?>>Others</option>
				</select>
			</div>

			<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-12 tutor-col-lg-6 mb-3">
				<label class="tutor-form-label tutor-color-black-60">
					<?php esc_html_e( 'D.O.B', TPL_DOMAIN_LANG ); ?>
				</label>
				<input class="tutor-form-control" type="text" name="_tutor_age" value="<?php esc_html_e( get_user_meta( $user->ID, '_tutor_age', true )); ?>" placeholder="<?php esc_attr_e( 'Age', TPL_DOMAIN_LANG ); ?>">
			</div>
		</div>

		<div class="tutor-row">
			<div class="tutor-col-12 mb-3">
				<label class="tutor-form-label tutor-color-black-60">
					<?php esc_html_e( 'Department', TPL_DOMAIN_LANG ); ?>
				</label>
				<input class="tutor-form-control" type="text" name="tutor_profile_job_title" value="<?php esc_attr_e( get_user_meta( $user->ID, '_tutor_profile_job_title', true ) ); ?>" placeholder="<?php esc_attr_e( 'UX Designer', TPL_DOMAIN_LANG ); ?>">
			</div>
		</div>

		<div class="tutor-row">
			<div class="tutor-col-12 mb-3">
				<label class="tutor-form-label tutor-color-black-60">
					<?php _e( 'Bio', TPL_DOMAIN_LANG ); ?>
				</label>
				<textarea class="tutor-form-control" name="tutor_profile_bio"><?php echo strip_tags( get_user_meta( $user->ID, '_tutor_profile_bio', true ) ); ?></textarea>
			</div>
		</div>

		<div class="tutor-row">
			<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-12 tutor-col-lg-6 mb-3">
				<label class="tutor-form-label tutor-color-black-60">
					<?php _e( 'Display name publicly as', TPL_DOMAIN_LANG ); ?>

				</label>
				<select class="tutor-form-select" name="display_name">
					<?php
					foreach ( $public_display as $id => $item ) {
						?>
								<option <?php selected( $user->display_name, $item ); ?>><?php esc_html_e( $item ); ?></option>
							<?php
					}
					?>
				</select>
				<div class="tutor-fs-7 tutor-fw-normal tutor-color-black-60 tutor-mt-12">
					<?php esc_html_e( 'The display name is shown in all public fields, such as the author name, instructor name, student name, and name that will be printed on the certificate.', TPL_DOMAIN_LANG ); ?>
				</div>
			</div>
		</div>
		<!-- 
		<div class="tutor-row">
			<div class="tutor-col-12 tutor-col-sm-6 tutor-col-md-12 tutor-col-lg-6 mb-3">
				<label class="tutor-form-label tutor-color-black-60">
					<?php _e( 'VUS Member', TPL_DOMAIN_LANG ); ?>

				</label>
				<?php 
				$_tutor_vus_member = esc_attr( get_user_meta( $user->ID, '_tutor_vus_member', true ) ); 
				if(!$_tutor_vus_member) $_tutor_vus_member = 'Internal';
				?>
				<select class="tutor-form-select" name="_tutor_vus_member" id="tutor_vus_member">
					<option value="Internal" <?php if($_tutor_vus_member=='Internal') echo 'selected="selected"';?>>Internal</option>
					<option value="External" <?php if($_tutor_vus_member=='External') echo 'selected="selected"';?>>External</option>
				</select>
			</div>
		</div>
		-->
		<?php do_action( 'tutor_profile_edit_input_after', $user ); ?>

		<div class="tutor-row">
			<div class="tutor-col-12">
				<button type="submit" class="tutor-btn tutor-profile-settings-save">
					<?php esc_html_e( 'Update Profile', TPL_DOMAIN_LANG ); ?>
				</button>
			</div>
		</div>
	</form>

	<?php do_action( 'tutor_profile_edit_form_after' ); ?>
</div>
<style>
	.tutor-form-control.invalid{border-color: red;}
</style>
