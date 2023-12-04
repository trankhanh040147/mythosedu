<?php
/**
 * Handles loading all the necessary files
 *
 * @package Tutor_Starter
 */

defined( 'ABSPATH' ) || exit;

// Content width.
if ( ! isset( $content_width ) ) 
	$content_width = apply_filters( 'tutorstarter_content_width', get_theme_mod( 'content_width_value', 1140 ) );

// Theme GLOBALS.
$theme = wp_get_theme();
define( 'TUTOR_STARTER_VERSION', $theme->get( 'Version' ) );

// Load autoloader.
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) :
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
endif;

// Include TGMPA class.
if ( file_exists( dirname( __FILE__ ) . '/inc/Custom/class-tgm-plugin-activation.php' ) ) :
	require_once dirname( __FILE__ ) . '/inc/Custom/class-tgm-plugin-activation.php';
endif;

// Register services.
if ( class_exists( 'Tutor_Starter\\Init' ) ) :
	Tutor_Starter\Init::register_services();
endif;


function enqueue_custom_scripts() {
	// Enqueue jQuery and jQuery UI
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-droppable');

	// Enqueue your custom scripts
	wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/assets/dist/js/dragAndDrop.js', array('jquery', 'jquery-ui-core', 'jquery-ui-droppable'), '1.4', true);
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/dist/js/bootstrap.min.js', array('jquery'), '1.4', true);
}


add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
function enqueue_custom_styles() {
	// Enqueue your custom CSS file
	wp_enqueue_style('custom-css', get_template_directory_uri() . '/assets/dist/css/bootstrap.min.css',array(), '1.6', true);
}

// Hook the function to the 'wp_enqueue_scripts' action
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

function getToken() {

	global $system_api;

	$response = $system_api->re_query('POST', 'login', [
			'params' => [
					'username' => __USERNAME,
					'password' => __PASSWORD
			],
			'fields' => [
					'token'
			]
	]);
	if (is_wp_error($response)) {
			return $response;
	}
	
	//var_dump( $response['login']['token'] );
	$__token = "";
	if(isset($response['login']['token'])) {
			$__token = $response['login']['token'];
	}

	return $__token;

}

// call api course
function my_ajax_course_detail()
{
	

	// //     If the custom cookie doesn't exist, set it with a default value
	
	//$key='khanh';  
	$cookie_access_token = $_GET['secureToken'];

	// Lấy tham số id từ request
	$idCourse = sanitize_text_field($_GET['idCourse']);
	// Thực hiện cuộc gọi API bằng wp_remote_get
	$url = REST_API_URL . '/course/v1/course-detail?id=' . $idCourse;
	$response = wp_remote_get($url, array(
			'method' => 'GET',
			'headers' => array(
					"courseId" => $idCourse,
					'Authorization' =>  $cookie_access_token,
			),

	));

	if (!is_wp_error($response)) {
			$data = wp_remote_retrieve_body($response);

			wp_send_json_success($data);
	} else {
			wp_send_json_error('API Error: ' . $response->get_error_message());
	}
}

// Post point user
function my_post_point_function()
{
	// Kiểm tra xem action là my_post_api và có dữ liệu data được truyền vào không

	$data_post  = $_POST['data_post'];
	$data1 = json_encode($data_post);

	//    $data1 =($data_post);
	//   echo $data;

	// print_r(json_encode($data1)) ;
	// die();
	// Thực hiện xử lý dữ liệu và gửi yêu cầu API

	//   $url = 'https://cms.edutekit.com/result/v1/user-create-result';
	$url = REST_API_URL . '/result/v1/user-create-result';

	$cookie_access_token = getToken();

	// Tạo yêu cầu POST
	$args = array(
			"method" => "POST",
			'timeout'     => 10,
			'headers' => array(
					'Content-Type' => 'application/json',
					'Authorization' =>  $cookie_access_token,
			),
			'body' => $data1,
			// 'sslverify' => false,
	);

	// Gửi yêu cầu POST bằng wp_remote_post
	$response = wp_remote_post($url, $args);
	if (!is_wp_error($response)) {
			$body = wp_remote_retrieve_body($response);
			$data = json_decode($body, true);

			// Xử lý dữ liệu trả về từ API

			wp_send_json_success($data);
	} else {
			$error_message = $response->get_error_message();
			wp_send_json_error('API Error: ' . $error_message);
	}
}
function my_post_delete_point_function()
{
	// Kiểm tra xem action là my_post_api và có dữ liệu data được truyền vào không

	$data_post  = $_POST['data_post'];
	$data1 = json_encode($data_post);

	$url = REST_API_URL . '/result/v1/user-delete-mutiple-result';

	$cookie_access_token = getToken();

	// Tạo yêu cầu POST
	$args = array(
			"method" => "POST",
			'timeout'     => 10,
			'headers' => array(
					'Content-Type' => 'application/json',
					'Authorization' =>  $cookie_access_token,
			),
			'body' => $data1,
			// 'sslverify' => false,
	);
	// print_r($args);
	// die;
	// Gửi yêu cầu POST bằng wp_remote_post
	$response = wp_remote_post($url, $args);
	if (!is_wp_error($response)) {
			$body = wp_remote_retrieve_body($response);
			$data = json_decode($body, true);

			// Xử lý dữ liệu trả về từ API

			wp_send_json_success($data);
	} else {
			$error_message = $response->get_error_message();
			wp_send_json_error('API Error: ' . $error_message);
	}
}
add_filter('https_local_ssl_verify', '__return_false');
add_filter('https_ssl_verify', '__return_false');
add_action('wp_ajax_my_post_point_api', 'my_post_point_function');
add_action('wp_ajax_nopriv_my_post_point_api', 'my_post_point_function');
add_action('wp_ajax_my_post_delete_point_api', 'my_post_delete_point_function');
add_action('wp_ajax_nopriv_my_post_delete_point_api', 'my_post_delete_point_function');

// Đăng ký AJAX endpoint
add_action('wp_ajax_my_course_detail', 'my_ajax_course_detail');
add_action('wp_ajax_nopriv_my_course_detail', 'my_ajax_course_detail');
remove_filter('the_content', 'wptexturize');

add_action('wp_ajax_get_template_game', 'get_template_part_content');
add_action('wp_ajax_nopriv_get_template_game', 'get_template_part_content');


add_action('wp_ajax_get_cookies', 'get_cookies_data');
add_action('wp_ajax_nopriv_get_cookies', 'get_cookies_data');

// Hàm xử lý action
function get_cookies_data()
{
	// Kiểm tra quyền truy cập

	// Truy cập và trả về dữ liệu cookie
	$cookies_data = $_COOKIE;
	wp_send_json_success($cookies_data);

	wp_send_json_error('Access denied');
}

function get_template_part_content()
{
	$template = $_POST['template'];

	ob_start();
	get_template_part($template);
	$content = ob_get_clean();
	print_r($content);
	die();
}
?>