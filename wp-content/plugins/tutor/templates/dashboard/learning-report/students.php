<?php

/**
 * @package TutorLMS/Templates
 * @version 1.6.4
 */
global $wpdb;

$course_post_type 		= tutor()->course_post_type;
$lesson_type      		= tutor()->lesson_post_type;
$user_id				= get_current_user_id();


global $wp_query, $wp;

$paged    = 1;
$url      = home_url( $wp->request );
$url_path = parse_url( $url, PHP_URL_PATH );
$basename = pathinfo( $url_path, PATHINFO_BASENAME );
$active_cid   	        = isset($_GET['cid']) ? sanitize_text_field($_GET['cid']) : '';
if ( isset( $_GET['current_page'] ) && is_numeric( $_GET['current_page'] ) ) {
	$paged = $_GET['current_page'];
} else {
	is_numeric( $basename ) ? $paged = $basename : '';
}
$per_page    = tutor_utils()->get_option( 'pagination_per_page' );
$offset      = ( $per_page * $paged ) - $per_page;
?>

<div class="analytics-title tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">
    <?php //_e( 'Dashboard', 'tutor' ); ?>
</div>
<div class="tutor-dashboard-content-inner">

	<div class="tutor-dashboard-inline-links">
		<?php
			tutor_load_template( 'dashboard.learning-report.nav-bar', array( 'active_setting_nav' => 'students' ) );
		?>
	</div>

</div>
<?php 
$students_count				= ( current_user_can( 'administrator' ) ) ? count(tutor_utils()->get_students_all($active_cid)):tutor_utils()->get_user_manage_users_total_count($user_id);
$students_all = ( current_user_can( 'administrator' ) ) ? tutor_utils()->get_students_all($active_cid,$offset, $per_page):tutor_utils()->get_user_manage_students_all($user_id, $offset, $per_page);
if (is_array($students_all) && count($students_all) ) {
	?>
		<div class="popular-courses-heading-dashboard tutor-fs-6 tutor-fw-medium tutor-color-black tutor-capitalize-text tutor-mb-24 tutor-mt-md-42 tutor-mt-0">
			<?php esc_html_e( 'Students', 'tutor' ); ?>
		</div>
		<div class="tutor-dashboard-content-inner">
			<table class="tutor-ui-table tutor-ui-table-responsive table-popular-courses1">
				<thead>
					<tr>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Email', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Campus Code', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
						<th class="tutor-table-rows-sorting">
							<div class="inline-flex-center tutor-color-black-60">
								<span class="text-regular-small"><?php esc_html_e( 'Campus Name', 'tutor' ); ?></span>
								<span class="tutor-icon-ordering-a-to-z-filled a-to-z-sort-icon tutor-icon-22"></span>
							</div>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( is_array($students_all) && count($students_all) ) : ?>
						<?php
						foreach ( $students_all as $student ) :
							?>
							<tr>
								<td data-th="<?php esc_html_e( 'Email', 'tutor' ); ?>">
									<a href="<?php echo tutor_utils()->get_tutor_dashboard_page_permalink( 'learning-analytics/student' );?>?sid=<?php echo $student['ID'];?>">
									<span class="tutor-fs-7 tutor-fw-medium tutor-color-primary-main1">
										<?php esc_html_e( $student['user_email'] ); ?>
									</span>
									</a>
								</td>
								<td data-th="<?php esc_html_e( 'Branch Code', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-fw-normal tutor-color-black-60">
										<?php esc_html_e( $student['Branch_ID']); ?>
									</div>
								</td>
								<td data-th="<?php esc_html_e( 'Branch Name', 'tutor' ); ?>">
									<div class="td-tutor-rating tutor-fs-6 tutor-fw-normal tutor-color-black-60">
										<?php esc_html_e( $student['Branch_Name']); ?>
									</div>
								</td>
							</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="100%" class="column-empty-state">
									<?php tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
								</td>
							</tr>
						<?php endif; ?>
				</tbody>
			</table>
		</div>
		
		<div class="tutor-mt-20">
			<?php
			if($students_count > $per_page) {
				$pagination_data = array(
					'total_items' => $students_count,
					'per_page'    => $per_page,
					'paged'       => $paged,
				);
				tutor_load_template_from_custom_path(
					tutor()->path . 'templates/dashboard/elements/pagination.php',
					$pagination_data
				);
			}
			?>
		</div>
	<?php
}
?>