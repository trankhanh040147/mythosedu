<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>


<?php
$_search  = isset( $_GET['search'] ) ? $_GET['search'] : '';
$_student = isset( $_GET['student_id'] ) ? $_GET['student_id'] : '';
if ( ! $_student ) {
	include $view_page . $page . '/student-table.php';
} else {
	include $view_page . $page . '/student-profile.php';
}
