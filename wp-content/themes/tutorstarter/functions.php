<?php
/**
 * Handles loading all the necessary files
 *
 * @package Tutor_Starter
 */

defined('ABSPATH') || exit;

// Content width.
if(!isset($content_width))
	$content_width = apply_filters('tutorstarter_content_width', get_theme_mod('content_width_value', 1140));

// Theme GLOBALS.
$theme = wp_get_theme();
define('TUTOR_STARTER_VERSION', $theme->get('Version'));

// Load autoloader.
if(file_exists(dirname(__FILE__).'/vendor/autoload.php')):
	require_once dirname(__FILE__).'/vendor/autoload.php';
endif;

// Include TGMPA class.
if(file_exists(dirname(__FILE__).'/inc/Custom/class-tgm-plugin-activation.php')):
	require_once dirname(__FILE__).'/inc/Custom/class-tgm-plugin-activation.php';
endif;

// Register services.
if(class_exists('Tutor_Starter\\Init')):
	Tutor_Starter\Init::register_services();
endif;


function enqueue_custom_scripts() {
	// Enqueue jQuery and jQuery UI
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-droppable');

	// Enqueue your custom scripts
	wp_enqueue_script('custom-scripts', get_template_directory_uri().'/assets/dist/js/dragAndDrop.js', array('jquery', 'jquery-ui-core', 'jquery-ui-droppable'), '1.4', true);
	wp_enqueue_script('bootstrap', get_template_directory_uri().'/assets/dist/js/bootstrap.min.js', array('jquery'), '1.4', true);
}


add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
function enqueue_custom_styles() {
	// Enqueue your custom CSS file
	wp_enqueue_style('custom-css', get_template_directory_uri().'/assets/dist/css/bootstrap.min.css', array(), '1.6', true);
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
	if(is_wp_error($response)) {
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
function my_ajax_course_detail() {


	// //     If the custom cookie doesn't exist, set it with a default value

	//$key='khanh';  
	$cookie_access_token = $_GET['secureToken'];

	// Lấy tham số id từ request
	$idCourse = sanitize_text_field($_GET['idCourse']);
	// Thực hiện cuộc gọi API bằng wp_remote_get
	$url = REST_API_URL.'/course/v1/course-detail?id='.$idCourse;
	$response = wp_remote_get($url, array(
		'method' => 'GET',
		'headers' => array(
				"courseId" => $idCourse,
				'Authorization' => $cookie_access_token,
			),

	));

	if(!is_wp_error($response)) {
		$data = wp_remote_retrieve_body($response);

		wp_send_json_success($data);
	} else {
		wp_send_json_error('API Error: '.$response->get_error_message());
	}
}

// Post point user
function my_post_point_function() {
	// Kiểm tra xem action là my_post_api và có dữ liệu data được truyền vào không

	$data_post = $_POST['data_post'];
	$data1 = json_encode($data_post);

	//    $data1 =($data_post);
	//   echo $data;

	// print_r(json_encode($data1)) ;
	// die();
	// Thực hiện xử lý dữ liệu và gửi yêu cầu API

	//   $url = 'https://cms.edutekit.com/result/v1/user-create-result';
	$url = REST_API_URL.'/result/v1/user-create-result';
	$cookie_access_token = $_GET['secureToken'];


	// Tạo yêu cầu POST
	$args = array(
		"method" => "POST",
		'timeout' => 10,
		'headers' => array(
				'Content-Type' => 'application/json',
				'Authorization' => $cookie_access_token,
			),
		'body' => $data1,
		// 'sslverify' => false,
	);

	// Gửi yêu cầu POST bằng wp_remote_post
	$response = wp_remote_post($url, $args);
	if(!is_wp_error($response)) {
		$body = wp_remote_retrieve_body($response);
		$data = json_decode($body, true);

		// Xử lý dữ liệu trả về từ API

		wp_send_json_success($data);
	} else {
		$error_message = $response->get_error_message();
		wp_send_json_error('API Error: '.$error_message);
	}
}
function my_post_delete_point_function() {
	// Kiểm tra xem action là my_post_api và có dữ liệu data được truyền vào không

	$data_post = $_POST['data_post'];
	$data1 = json_encode($data_post);

	$url = REST_API_URL.'/result/v1/user-delete-mutiple-result';

	$cookie_access_token = getToken();

	// Tạo yêu cầu POST
	$args = array(
		"method" => "POST",
		'timeout' => 10,
		'headers' => array(
			'Content-Type' => 'application/json',
			'Authorization' => $cookie_access_token,
		),
		'body' => $data1,
		// 'sslverify' => false,
	);
	// print_r($args);
	// die;
	// Gửi yêu cầu POST bằng wp_remote_post
	$response = wp_remote_post($url, $args);
	if(!is_wp_error($response)) {
		$body = wp_remote_retrieve_body($response);
		$data = json_decode($body, true);

		// Xử lý dữ liệu trả về từ API

		wp_send_json_success($data);
	} else {
		$error_message = $response->get_error_message();
		wp_send_json_error('API Error: '.$error_message);
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
function get_cookies_data() {
	// Kiểm tra quyền truy cập

	// Truy cập và trả về dữ liệu cookie
	$cookies_data = $_COOKIE;
	wp_send_json_success($cookies_data);

	wp_send_json_error('Access denied');
}

function get_template_part_content() {
	$template = $_POST['template_name'];

	ob_start();
	get_template_part($template);
	$content = ob_get_clean();
	print_r($content);
	die();
}

function theme_assets($name) {
	return get_template_directory_uri()."/assets/{$name}";
}
// Add this code to your theme's functions.php file

function custom_template_shortcode($atts) {
	$atts = shortcode_atts(array(
		'template_name' => '', // Default template name if not specified
	), $atts);

	$template = sanitize_text_field($atts['template_name']);

	ob_start();
	get_template_part($template);
	$content = ob_get_clean();

	return $content;
}
add_shortcode('game_name', 'custom_template_shortcode');

// find the first course that has no child course
function find_first_end_course($course_id) {
	$child_courses = get_post_meta($course_id, '_tutor_course_children', true);
	// convert to array
	$child_courses = explode(' ', $child_courses);
	if(empty($child_courses)) {
		return $course_id;
	} else {
		foreach($child_courses as $child_course) {
			return find_first_end_course($child_course);
		}
	}
}

function find_last_parents_course($course_id) {
	$par_courses = get_post_meta($course_id, '_tutor_course_parent', true);
	$par_courses = explode(' ', $par_courses);
	// echo 'find_last_parent_course' . $course_id . '<br>';
	if(empty($par_courses[0])) {
		return $course_id;
	} else {
		foreach($par_courses as $par_course) {
			return find_last_parents_course($par_course);
		}
	}
}

function insert_queue_children_courses($course_id, &$queue) {
	$child_courses = get_post_meta($course_id, '_tutor_course_children', true);
	$child_courses = explode(' ', $child_courses);
	// echo 'insert_queue_children_courses of '.$course_id.': ';
	// var_dump($child_courses);
	// echo '<br>';

	if(empty($child_courses)) {
		return array_unique($queue);
	} else {
		foreach($child_courses as $child_course) {
			// continue when child_course is null
			if(empty($child_course)) {
				continue;
			}
			array_push($queue, $child_course);
			// return insert_queue_children_courses($child_course, $queue);
		}
		$queue = array_unique($queue);
	}
}

function custom_course_list_shortcode() {
	$output = '';
	 $index=0;
	$courses_list = get_posts( array(
			'post_type' => tutor()->course_post_type,
			'posts_per_page' => 8,
			'post_status' => 'publish',
			'orderby' => 'title',
			'order' => 'ASC',
	) );
	$course_length = count($courses_list);
	$arr=[];
	switch ($course_length) {
    case 1:
        $arr = [1];
        break;
    case 2:
        $arr = [1, 10];
        break;
    case 3:
        $arr = [1, 5, 10];
        break;
    case 4:
        $arr = [1, 4, 7, 10];
        break;
    case 5:
        $arr = [1, 3, 6, 8, 10];
        break;
    case 6:
        $arr = [1, 2, 4, 6, 8, 10];
        break;
    case 7:
        $arr = [1, 2, 3, 5, 7, 9, 10];
        break;
    case 8:
        $arr = [1, 2, 3, 5, 6, 8, 9, 10];
        break;
    case 9:
        $arr = [1, 2, 3, 4, 5, 6, 8, 9, 10];
        break;
    case 10:
        $arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        break;
    default:
        $arr = [];
}

	if ($courses_list) {
			foreach ($courses_list as $course) {
					$thumbnail = get_the_post_thumbnail($course->ID, 'thumbnail', array('class' => 'img-course'));
					$title = get_the_title($course->ID);
					$permalink = get_permalink($course->ID);
          
					$output .=	'<div class=" level'.$arr[$index].  ' d-flex flex-column level_item ">';
					$output .='<div class="position-relative ">';
					$output .=' <div><a href="#" class="__link"><img src="/wp-content/uploads/2023/12/level'.$arr[$index].'.svg" alt="" class="__img-level8 __img-level"></a></div>';
					$output .='<div><img src="/wp-content/uploads/2023/12/icon-address-level.svg" alt="" class="icon-address-level1"></div> ';
					$output .=' <div class="course position-absolute">';
					$output .='<div class=" __box-course complete">';
					$output .='<img src="' . $permalink . '" alt="" class="img-course">';
					$output .='<a href=""><p class="title_course">' . $title . '</p></a>';
					$output .='</div>';
					$output .='<div class="  __box-course active" >';
					$output .='<img src="' . $permalink . '" alt="" class="img-course mt-2">';
					$output .='<a href=""><p class="title_course">' . $title . '</p></a>';
					$output .='</div>';
					$output .='<div class="  __box-course inactive" >';
					$output .='<img src="' . $permalink . '" alt="" class="img-course mt-2">';
					$output .='<a href=""><p class="title_course">' . $title . '</p></a>';
					$output .='</div>';
					$output .='</div>';
					$output .='</div>';

					$output .='</div>';

$index++;
					
			}
	} else {
			$output = '<p>No courses found.</p>';
	}

	return $output;
}
add_shortcode('custom_course_list', 'custom_course_list_shortcode');


function load_all_course_hierarchy() {
	
	
	// get a specified course, or the course that user chose to show the learning_path
	$input_course = 15053;
	// course_tree is a string that contains all course that recusive from $input_course
	// ex: course_tree = {15053{15054{15057, 15058}, 15055, 15056}}}
	$course_tree = '{' . $input_course;
	$cur_queue = array();
	$next_queue = array();
	$queue_level = 0;

	// echo 'find last parent course:';
	$root_course = find_last_parents_course($input_course);
	// echo $root_course;
	// echo '<br>';

	array_push($cur_queue, $root_course);
	// echo 'current queue: '; var_dump( $cur_queue ); echo '<br>';
	insert_queue_children_courses($root_course, $next_queue);

	// if next_queue is not empty
	while(!empty($next_queue)){
		$cur_queue = $next_queue;
		$next_queue = array();
		// echo 'current queue: '; var_dump( $cur_queue ); echo '<br>';

		$queue_level++;
		// echo '<br>';
		
		// loop through cur_queue, insert all child courses of cur_course to next_queue
		foreach($cur_queue as $cur_course) {
			insert_queue_children_courses($cur_course, $next_queue);
		}
	}

	$output = '';
	$index=0;

	$course_length = $queue_level;
	$arr=[];
	switch ($course_length) {
    case 1:
        $arr = [1];
        break;
    case 2:
        $arr = [1, 10];
        break;
    case 3:
        $arr = [1, 5, 10];
        break;
    case 4:
        $arr = [1, 4, 7, 10];
        break;
    case 5:
        $arr = [1, 3, 6, 8, 10];
        break;
    case 6:
        $arr = [1, 2, 4, 6, 8, 10];
        break;
    case 7:
        $arr = [1, 2, 3, 5, 7, 9, 10];
        break;
    case 8:
        $arr = [1, 2, 3, 5, 6, 8, 9, 10];
        break;
    case 9:
        $arr = [1, 2, 3, 4, 5, 6, 8, 9, 10];
        break;
    case 10:
        $arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        break;
    default:
        $arr = [];
}
	// echo data
	// echo 'queue_level: ' . $queue_level . '<br>';

	$queue_level--;
	$cur_queue = array();
	$next_queue = array();
	array_push($cur_queue, $root_course);
	// echo 'current queue: '; var_dump( $cur_queue ); echo '<br>';
	insert_queue_children_courses($root_course, $next_queue);
	
	$output_level = '';

	// if next_queue is not empty
	while(!empty($next_queue)){
		$output_level = '';

		$cur_queue = $next_queue;
		$next_queue = array();

		// echo 'current queue: '; var_dump( $cur_queue ); echo '<br>';
		// print course_to_link of each course in current queue
        
		// Level status: 1: .level_item.active 2:.level_item.inactive 3:.level_item.complete

		$output_level .=	'<div class=" level'.$arr[$queue_level].  ' d-flex flex-column level_item ">';
		$output_level .='<div class="position-relative ">';
		$output_level .=' <div><a href="#" class="__link"><img src="/wp-content/uploads/2023/12/level'.$arr[$queue_level].'.svg" alt="" class="__img-level8 __img-level"></a></div>';
		$output_level .='<div><img src="/wp-content/uploads/2023/12/icon-address-level.svg" alt="" class="icon-address-level1"></div> ';
		$output_level .=' <div class="course position-absolute">';

		$total_in_progress = 0;
		$total_completed = 0;
		$total_unenrolled = 0;

		foreach($cur_queue as $cur_course) {
		// Course detail
		// $thumbnail = get_the_post_thumbnail($cur_course, 'thumbnail', array('class' => 'img-course'));
		$thumbnail = get_the_post_thumbnail($cur_course, 'thumbnail', array('class' => 'img-course'));
		$title = get_the_title( $cur_course );
		$permalink = get_the_permalink( $cur_course );
		$enroll_status = tutor_utils()->is_enrolled($cur_course);
		$complete_status = tutor_utils()->is_course_completed($cur_course);
		// course_to_link($cur_course);

		if(!$enroll_status) {
			$total_unenrolled++;
			$course_status_class = ' inactive';
		} else if($complete_status) {
			$total_completed++;
			$course_status_class = ' complete';
		} else {
			$total_in_progress++;
			$course_status_class = ' active';
		}


		// Course content
		// Course status: 1: .__box-course.complete 2: .__box-course.active 3: .__box-course.inactive
		// set $course_status_class 
		$output_level .='<div class=" __box-course'. $course_status_class .'">';
		// $output_level .='<img src=' . $thumbnail . ' alt="" class="img-course">';
		$output_level .= $thumbnail;
		$output_level .='<a href="'. $permalink . '"><p class="title_course">' . $title . '</p></a>';
		$output_level .='</div>';
		//. Course content
		
		}

		$output_level .='</div>';
		$output_level .='</div>';
		$output_level .='</div>';

		$queue_level--;
		// echo '<br>';

		// loop through cur_queue, insert all child courses of cur_course to next_queue
		foreach($cur_queue as $cur_course) {
			insert_queue_children_courses($cur_course, $next_queue);
		}
		$output = $output_level . $output;
		// $output =  $output . $output_level;
	}

		    // Loop through all levels
// 			foreach ($courses_list as $course) {
// 					// Course detail
// 					$thumbnail = get_the_post_thumbnail($course->ID, 'thumbnail', array('class' => 'img-course'));
// 					$title = get_the_title($course->ID);
// 					$permalink = get_permalink($course->ID);
          
// 					$output .=	'<div class=" level'.$arr[$index].  ' d-flex flex-column level_item ">';
// 					$output .='<div class="position-relative ">';
// 					$output .=' <div><a href="#" class="__link"><img src="/wp-content/uploads/2023/12/level'.$arr[$index].'.svg" alt="" class="__img-level8 __img-level"></a></div>';
// 					$output .='<div><img src="/wp-content/uploads/2023/12/icon-address-level.svg" alt="" class="icon-address-level1"></div> ';
// 					$output .=' <div class="course position-absolute">';
// 					// Course content
// 					$output .='<div class=" __box-course complete">';
// 					$output .='<img src="' . $permalink . '" alt="" class="img-course">';
// 					$output .='<a href=""><p class="title_course">' . $title . '</p></a>';
// 					$output .='</div>';
// 					//. Course content
// 					$output .='</div>';
// 					$output .='</div>';

// 					$output .='</div>';

// $index++;
					
// 			}
// 	} else {
// 			$output = '<p>No courses found.</p>';
// 	}

	return $output;
}
add_shortcode('load_all_course_hierarchy', 'load_all_course_hierarchy');

?>
