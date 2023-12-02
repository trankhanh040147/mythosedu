<?php
	$overview_url   = tutor_utils()->get_tutor_dashboard_page_permalink( 'learning-report' );
	$branchs_url       = tutor_utils()->get_tutor_dashboard_page_permalink( 'learning-report/branchs' );
	$students_url = tutor_utils()->get_tutor_dashboard_page_permalink( 'learning-report/students' );
	$learning_url         = tutor_utils()->get_tutor_dashboard_page_permalink( 'learning-report/learning' );
	if(current_user_can( 'administrator' )) $role = 'administrator';
	elseif(current_user_can( 'shop_manager' )) $role = 'shop_manager';
	elseif(current_user_can( 'st_lt' )) $role = 'st_lt';
	$learning_report_menus = array(
		'overview'        => array(
			'url'   => esc_url( $overview_url ),
			'title' => __( 'Overview', 'tutor' ),
			'role'  => $role ,
		),
		'branchs' => array(
			'url'   => esc_url( $branchs_url ),
			'title' => __( 'Campus', 'tutor' ),
			'role'  => $role ,
		),
		'students'     => array(
			'url'   => esc_url( $students_url ),
			'title' => __( 'Students', 'tutor' ),
			'role'  => $role ,
		),
		/* 'learning' => array(
			'url'   => esc_url( $learning_url ),
			'title' => __( 'Learning', 'tutor' ),
			'show_ui'  => false,
			'role'  => $role ,
		), */
	);

	$learning_report_menus  = apply_filters( 'tutor_dashboard/nav_items/learning-report/nav_items', $learning_report_menus );
	$GLOBALS['tutor_setting_nav'] = $learning_report_menus;
	?>
<ul>
	<?php
	foreach ( $learning_report_menus as $menu_key => $menu ) {
		//$valid = $menu_key == 'overview' || ! $menu['role'] || ( $menu['role'] == 'shop_manager' && current_user_can( 'shop_manager' )|| ( $menu['role'] == 'st_lt' && current_user_can( 'st_lt' ))|| ( $menu['role'] == 'administrator' && current_user_can( 'administrator' )) );

		//if ( $valid ) {
			?>
				<li class="<?php echo $active_setting_nav == $menu_key ? 'active' : ''; ?>">
					<a href="<?php echo $menu['url']; ?>"><?php echo $menu['title']; ?></a>
				</li>
				<?php
		//}
	}
	?>
</ul>
