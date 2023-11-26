<?php
require_once( dirname( dirname( __FILE__ ) ) . '../wp-load.php' );

//$url= "https://traininghub-uat.vus.edu.vn/wp-json/tutor/v1/enroll_course";
echo $url= "http://vus.test/wp-json/tutor/v1/enroll_course";
$body = array(
		'course_id'    => 2106,
		'tqm_course_code' => '',
		'students'   => [	['hue21@gmail.com','hue','tp Hue','Male','2005-01-29'],
							['hue22@gmail.com','hue','tp Hue','Male','2006-01-29']
						],
	);//echo json_encode($body);die();
$response = wp_remote_post( $url, array(
	'method'      => 'POST',	
	'headers'     => array(
		'Content-Type' => 'application/json; charset=utf-8',
		'username' => 'webmaster',
		'password' => 'cuibap',//'traininghub@vus.edu.vn',
	),
	'body'        => json_encode($body),
	'cookies'     => array()
    )
);

var_dump($response);die();


?>