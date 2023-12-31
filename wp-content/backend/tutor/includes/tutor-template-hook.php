<?php

/**
 * TUTOR hook
 */

add_action('tutor_course/archive/before_loop_course', 'tutor_course_loop_before_content');
add_action('tutor_course/archive/after_loop_course', 'tutor_course_loop_after_content');

add_action('tutor_course/loop/header', 'tutor_course_loop_header');

add_action('tutor_course/loop/start_content_wrap', 'tutor_course_loop_start_content_wrap');
add_action('tutor_course/loop/title', 'tutor_course_loop_title');
add_action('tutor_course/loop/meta', 'tutor_course_loop_meta');

add_action('tutor_course/loop/rating', 'tutor_course_loop_rating');
add_action('tutor_course/loop/end_content_wrap', 'tutor_course_loop_end_content_wrap');

/**
 * Show course progress on only dashboard enrolled page
 *
 * @since v2.0.0
 */
add_action( 'tutor_course/loop/enrolled_course_progress', 'tutor_enrolled_course_progress' );

add_action('tutor_course/loop/footer', 'tutor_course_loop_footer');
