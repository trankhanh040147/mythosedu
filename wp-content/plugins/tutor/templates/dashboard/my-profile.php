<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */


$uid  = get_current_user_id();
$user = get_userdata( $uid );

$profile_settings_link = tutor_utils()->get_tutor_dashboard_page_permalink( 'settings' );

$rdate                 = tutor_utils()->convert_date_into_wp_timezone(date_i18n( 'D d M Y, h:i:s a', strtotime( $user->user_registered ) ));
$fname                 = $user->first_name;
$lname                 = $user->last_name;
$uname                 = $user->user_login;
$email                 = $user->user_email;
$phone                 = get_user_meta( $uid, 'phone_number', true );
$job                   = nl2br( strip_tags( get_user_meta( $uid, '_tutor_profile_job_title', true ) ) );
$bio                   = nl2br( strip_tags( get_user_meta( $uid, '_tutor_profile_bio', true ) ) );
$vus_member            = nl2br( strip_tags( get_user_meta( $uid, '_tutor_vus_member', true ) ) );
$vus_gender            = nl2br( strip_tags( get_user_meta( $uid, '_tutor_gender', true ) ) );
$vus_age               = strip_tags( get_user_meta( $uid, '_tutor_age', true ) );
$manage_branchs 	   = tutor_utils()->get_user_manage_branchs($uid);
$manage_branchs_name   = tutor_utils()->get_user_manage_branchs_name($manage_branchs);
$manage_users 	   = tutor_utils()->get_user_manage_users($uid);
$manage_users_name   = tutor_utils()->get_user_manage_users_name($manage_users);
$profile_data = array(
	array( __( 'Registration Date', 'tutor' ), ( $rdate ? $rdate : esc_html( '-' ) ) ),
	array( __( 'First Name', 'tutor' ), ( $fname ? $fname : esc_html( '-' ) ) ),
	array( __( 'Last Name', 'tutor' ), ( $lname ? $lname : __( '-' ) ) ),
	array( __( 'Username', 'tutor' ), $uname ),
	array( __( 'Email', 'tutor' ), $email ),
	array( __( 'Phone Number', 'tutor' ), ( $phone ? $phone : '-' ) ),
	array( __( 'Skill/Occupation', 'tutor' ), ( $job ? $job : '-' ) ),
	array( __( 'Biography', 'tutor' ), $bio ? $bio : '-' ),	
);

if(current_user_can( 'subscriber' )){
	$profile_data[] = array( __( 'VUS Member', 'tutor' ), $vus_member ? $vus_member : 'External' );
	$profile_data[] = array( __( 'Gender', 'tutor' ), $vus_gender ? $vus_gender : '' );
	$profile_data[] = array( __( 'Age', 'tutor' ), $vus_age ? $vus_age : '' );
}
	
if(current_user_can( 'shop_manager' )||current_user_can( 'st_lt' )){
	if($manage_branchs_name)
		$profile_data[] = array( __( 'Manage Campus', 'tutor' ), $manage_branchs_name ? $manage_branchs_name : '' );
	if($manage_users_name)
		$profile_data[] = array( __( 'Manage Users', 'tutor' ), $manage_users_name ? $manage_users_name : '' );
}
?>

<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24 tutor-capitalize-text"><?php _e( 'My Profile', 'tutor' ); ?></div>
<div class="tutor-dashboard-content-inner tutor-dashboard-profile-data">
	<?php

	foreach ( $profile_data as $key => $data ) {		
		$first_name_class = ($data[0] == 'First Name' || $data[0] == 'Last Name') ? 'tutor-capitalize-text' : '';
		?>
			<div class="tutor-row">
				<div class="tutor-col-12 tutor-col-sm-5 tutor-col-lg-3">
					<span class="tutor-fs-6 tutor-fw-normal tutor-color-black-60"><?php echo $data[0]; ?></span>
				</div>
				<div class="tutor-col-12 tutor-col-sm-7 tutor-col-lg-9">
					<?php echo $data[0] == 'Biography' ? '<span class="tutor-fs-6 tutor-fw-normal tutor-color-black-60">'.$data[1].'</span>' : '<span class="tutor-fs-6 tutor-fw-medium tutor-color-black ' . $first_name_class . ' ">' . $data[1] . '</span>'; ?>
				</div>
			</div>
		<?php
	}
	?>
</div>
