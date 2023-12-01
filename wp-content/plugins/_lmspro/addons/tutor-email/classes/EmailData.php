<?php

/**
 * Class Email Data
 *
 * @package TUTOR
 *
 * @since v.2.0.0
 */

namespace TUTOR_EMAIL;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EmailData {
	public function get_recipients() {
		$email_array = array(
			'email_to_students' => array(
				'course_enrolled'             => array(
					'label'               => __( 'Course Enrolled', 'tutor-pro' ),
					'default'             => 'on',
					'template'            => 'to_student_course_enrolled', // ==
					'tooltip'             => 'Enable to send course enrolled email notification',
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'subject'             => __( 'You are Enrolled in a New Course', 'tutor-pro' ),
					'heading'             => __( 'You are enrolled in New Course', 'tutor-pro' ),
					'course_name'         => __( 'Mastering WordPress-From Beginner to Advance', 'tutor-pro' ),
					'course_url'          => esc_url( tutor()->url ),
					'message'             => json_encode( 'Welcome to the course, the most popular and modern server at <strong>{site_url}</strong>. Happy learning.' ),
				),
				'quiz_completed'              => array(
					'label'     => __( 'Quiz Completed', 'tutor-pro' ),
					'default'   => 'off',
					'template'  => 'to_student_quiz_completed',
					'tooltip'   => 'Enable to send quiz completed email notification',
					'subject'   => __( 'Your quiz attempt is graded', 'tutor-pro' ),
					'heading'   => __( 'Thank you for attempting the quiz', 'tutor-pro' ),
					'username'  => __( 'Student', 'tutor-pro' ),
					'quiz_name' => __( 'Quiz Name of a course!', 'tutor-pro' ),
					'message'   => json_encode( 'The grade has been submitted for the quiz <strong>{quiz_name}</strong> for the course <strong>{course_name}</strong>.' ),
				),

				'completed_course'            => array(
					'label'               => __( 'Completed a Course', 'tutor-pro' ),
					'default'             => 'off',
					'template'            => 'to_student_course_completed',
					'tooltip'             => 'Enable to send course completion email notification',
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'subject'             => __( 'Congratulations on Finishing {course_name}', 'tutor-pro' ),
					'heading'             => __( 'Congratulations on Finishing the Course', 'tutor-pro' ),
					'message'             => json_encode( 'Congratulations on completing the course <strong>{course_name}</strong>. We hope that you had a great experience.' ),
					'footer_text'         => __( 'If you have additional feedback, you may reply to this email to communicate with the instructor', 'tutor-pro' ),
					'before_button'       => __( 'We would really appreciate it if you can post a review on the course and the instructor. Your valuable feedback would help us improve the content on our site and improve the learning experience.', 'tutor-pro' ),
				),
				'remove_from_course'          => array(
					'label'    => __( 'Removed From Course', 'tutor-pro' ),
					'default'  => 'off',
					'template' => 'to_student_remove_from_course', // ==/
					'tooltip'  => 'Enable to send removed from the course email notification',
					'subject'  => __( 'You have been removed from {course_name}', 'tutor-pro' ),
					'heading'  => __( 'Headline you are enrolled in New Course', 'tutor-pro' ),
					'message'  => json_encode( 'The instructor has removed you from the course - {course_name}.' ),
				),
				'assignment_graded'           => array(
					'label'               => __( 'Assignment Graded', 'tutor-pro' ),
					'default'             => 'off',
					'template'            => 'to_student_assignment_evaluate',
					'tooltip'             => 'Enable to send assignment graded email notification',
					'subject'             => __( 'Assignment Graded - {assignment_name}', 'tutor-pro' ),
					'username'            => __( 'Student', 'tutor-pro' ),
					'assignment_max_mark' => __( '100', 'tutor-pro' ),
					'assignment_score'    => __( '80', 'tutor-pro' ),
					'heading'             => __( 'Assignment has been Graded', 'tutor-pro' ),
					'course_name'         => __( 'Mastering WordPress-From Beginner to Advance', 'tutor-pro' ),
					'assignment_name'     => __( 'Create your first WordPress site', 'tutor-pro' ),
					'assignment_comment'  => __( 'Comment created by instructor of the course {course_name}', 'tutor-pro' ),
					'message'             => json_encode( 'The instructor submitted the grade for the assignment <strong>{assignment_name}</strong> of the course <strong>{course_name}</strong>.' ),
					'block_heading'       => __( 'Instructor Note', 'tutor-pro' ),
					'block_content'       => __( 'What does it take to be successful? Ask around and you will find different answers to the formula of success. The truth is, success leaves clues and you can achieve.', 'tutor-pro' ),
				),
				'new_announcement_posted'     => array(
					'label'               => __( 'New Announcement Posted', 'tutor-pro' ),
					'default'             => 'off',
					'template'            => 'to_student_new_announcement_posted',
					'tooltip'             => 'Enable to send new announcement post email notification',
					'username'            => __( 'Student', 'tutor-pro' ),
					'assignment_max_mark' => __( '100', 'tutor-pro' ),
					'assignment_score'    => __( '80', 'tutor-pro' ),
					'subject'             => __( 'New Announcement on {course_name}', 'tutor-pro' ),
					'heading'             => __( 'Headline you are enrolled in New Course', 'tutor-pro' ),
					'message'             => json_encode( 'The instructor posted a new announcement for {course_name}.' ),
				),
				'announcement_updated'        => array(
					'label'         => __( 'New Announcement Updated', 'tutor-pro' ),
					'default'       => 'off',
					'template'      => 'to_student_announcement_updated',
					'tooltip'       => 'Enable to send email notification of updated announcement post',
					'subject'       => __( 'The announcement at {course_name} is updated', 'tutor-pro' ),
					'heading'       => __( 'The instructor updated the announcement', 'tutor-pro' ),
					'message'       => json_encode( 'The instructor updated the announcement for - {course_name}.' ),
					'footer_text'   => __( 'You may reply to this email to communicate with the instructor', 'tutor-pro' ),
					'block_heading' => __( 'Upcomming Exam Notice & Schedule', 'tutor-pro' ),
					'block_content' => __( '<p>Assertively incentivize prospective users before alternative imperatives. Quickly strategize best-of-breed testing procedures after high-payoff human capital.</p><p>Seamlessly incentivize diverse quality vectors before clicks-and-mortar collaboration and idea-sharing. Dramatically fashion just in time partnerships without distinctive scenarios. Quickly predominate principle-centered results through corporate alignments.</p>', 'tutor-pro' ),
				),
				'after_question_answered'     => array(
					'label'         => __( 'Q&A Message Answered', 'tutor-pro' ),
					'default'       => 'off',
					'template'      => 'to_student_question_answered',
					'tooltip'       => 'Enable to send Q&A reply email notification',
					'subject'       => __( 'The instructor has replied to your question', 'tutor-pro' ),
					'answer_by'     => __( 'Answer Author', 'tutor-pro' ),
					'answer_date'   => __( '1 day ago', 'tutor-pro' ),
					'heading'       => __( 'Q&A Message Answered', 'tutor-pro' ),
					'message'       => json_encode( 'The instructor has answered your question on the course - {course_name}.' ),
					'question'      => __( 'I help ambitious graphic designers and hand letterers level-up their skills and creativity. Grab freebies + tutorials here! >> https://every-tuesday.com', 'tutor-pro' ),
					'before_button' => __( 'Please click on this link to reply to the question.', 'tutor-pro' ),
				),
				'feedback_submitted_for_quiz' => array(
					'label'         => __( 'Feedback submitted for Quiz Attempt', 'tutor-pro' ),
					'default'       => 'off',
					'template'      => 'to_student_feedback_submitted_for_quiz',
					'tooltip'       => 'Enable to send quiz feedback email notification',
					'subject'       => __( 'Feedback Submitted For Quiz Attempt', 'tutor-pro' ),
					'username'      => __( 'Student', 'tutor-pro' ),
					'heading'       => __( 'Quiz Answers Reviewed', 'tutor-pro' ),
					'message'       => json_encode( 'Your quiz for the course {course_name} has been reviewed and graded — {instructor_feedback}. Please go to My Quiz Attempts to see it' ),
					'block_heading' => __( 'Instructor Note', 'tutor-pro' ),
					'block_content' => __( 'What does it take to be successful? Ask around and you will find different answers to the formula of success. The truth is, success leaves clues and you can achieve.', 'tutor-pro' ),
				),
				'enrollment_expired'          => array(
					'label'    => __( 'Course enrolment expired', 'tutor-pro' ),
					'default'  => 'off',
					'template' => 'to_student_enrollment_expired',
					'tooltip'  => 'Enable to send course enrolment expiration email notification',
					'subject'  => __( 'Your enrolment is expired', 'tutor-pro' ),
					'heading'  => __( 'Headline you are enrolled in New Course', 'tutor-pro' ),
					'message'  => json_encode( 'Your enrolment period has expired for the course {course_name}'),
				),
			),
			'email_to_teachers' => array(
				'a_student_enrolled_in_course'    => array(
					'label'               => __( 'A Student Enrolled in Course', 'tutor-pro' ),
					'default'             => 'off',
					'template'            => 'to_instructor_course_enrolled',
					'tooltip'             => 'Enable to send new student enrolment email notification',
					'subject'             => __( 'New Student Enrolled at {course_name}', 'tutor-pro' ),
					'heading'             => __( 'New Student Enrolled', 'tutor-pro' ),
					'course_name'         => __( 'Mastering WordPress-From Beginner to Advance', 'tutor-pro' ),
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'student_username'    => __( 'John Doe', 'tutor-pro' ),
					'student_email'       => __( 'student@testmail.com', 'tutor-pro' ),
					'footer_text'         => __( 'You may reply to this email to communicate with the student', 'tutor-pro' ),
					'message'             => json_encode( 'A new student has joined the course {course_name} You have earned {earned_amount} from this enrolment. Your current balance is {total_amount}.' ),
				),
				'a_student_completed_course'      => array(
					'label'         => __( 'A Student Completed Course', 'tutor-pro' ),
					'default'       => 'off',
					'template'      => 'to_instructor_course_completed',
					'tooltip'       => 'Enable to send student course completion email notification',
					'student_name'  => __( 'James Andy', 'tutor-pro' ),
					'subject'       => __( 'Congratulations! "{student_name}" Completed A Course.', 'tutor-pro' ),
					'heading'       => __( 'Student Just Completed a Course!', 'tutor-pro' ),
					'message'       => json_encode( 'Your student <strong>{student_name}</strong> has just completed the course <strong>{course_name}</strong>. This is a great milestone for you as a teacher and we want you to celebrate this moment.' ),
					'before_button' => __( 'You can view the students progress reports and course details by clicking the button at the bottom of this email.', 'tutor-pro' ),
					'footer_text'   => __( 'You may reply to this email to communicate with the student.', 'tutor-pro' ),
				),
				'a_student_completed_lesson'      => array(
					'label'         => __( 'A Student Completed Lesson', 'tutor-pro' ),
					'default'       => 'off',
					'template'      => 'to_instructor_lesson_completed',
					'tooltip'       => 'Enable to send student lesson completion email notification',
					'subject'       => __( '{student_name} completed the lesson {lesson_name}', 'tutor-pro' ),
					'heading'       => __( 'Headline you are enrolled in New Course', 'tutor-pro' ),
					'message'       => json_encode( '{student_name} has completed the lesson <strong>{lesson_name}</strong> just now. Click the button to see the progress.' ),
					// 'before_button' => __( 'You can view the students progress reports and lesson details by clicking the button at the bottom of this email.', 'tutor-pro' ),
					'footer_text'   => __( 'Please click on this button to reply to the question', 'tutor-pro' ),
				),
				'a_student_placed_question'       => array(
					'label'               => __( 'New Q&amp;A Message', 'tutor-pro' ),
					'default'             => 'off',
					'template'            => 'to_instructor_asked_question_by_student',
					'tooltip'             => 'Enable to send Q&A new question email notification',
					'student_name'        => __( 'James Andy', 'tutor-pro' ),
					'subject'             => __( 'New Question from {student_name} on {course_name}', 'tutor-pro' ),
					'heading'             => __( 'New Q&amp;A Message', 'tutor-pro' ),
					'instructor_username' => __( 'Teacher Name', 'tutor-pro' ),
					'course_name'         => __( 'Mastering WordPress-From Beginner to Advance', 'tutor-pro' ),
					'enroll_time'         => __( '1 days ago', 'tutor-pro' ),
					'message'             => json_encode( 'Student - {student_name} has asked a question on the course {course_name}' ),
					'question'            => __( 'I help ambitious graphic designers and hand letterers level-up their skills and creativity. Grab freebies + tutorials here! >> https://every-tuesday.com.', 'tutor-pro' ),
					'footer_text'         => __( 'Please click on this button to reply to the question', 'tutor-pro' ),
				),
				'student_submitted_quiz'          => array(
					'label'               => __( 'Student Submitted Quiz', 'tutor-pro' ),
					'default'             => 'off',
					'template'            => 'to_instructor_quiz_completed',
					'tooltip'             => 'Enable to send student quiz submission email notification',
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'student_name'        => __( 'James Andy', 'tutor-pro' ),
					'subject'             => __( '{student_name} submitted the quiz- {quiz_name} from the course- {course_name}', 'tutor-pro' ),
					'heading'             => __( 'Student Attempted a Quiz', 'tutor-pro' ),
					'message'             => json_encode( '{student_name} has attempted a quiz.' ),
					'footer_text'         => __( 'You may reply to this email to communicate with the student.', 'tutor-pro' ),
				),
				// @TODO: To be implemented later
				// 'student_submitted_assignment'    => array(
				// 	'label'           => __( 'Student Submitted Assignment', 'tutor-pro' ),
				// 	'default'         => 'off',
				// 	'template'        => 'to_instructor_student_submitted_assignment',
				// 	'tooltip'         => 'Enable to send student assignment submission email notification',
				// 	'student_name'    => __( 'James Andy', 'tutor-pro' ),
				// 	'subject'         => __( '{student_name} submitted the assignment- {assignment_name} from the course- {course_name}', 'tutor-pro' ),
				// 	'instructor_name' => __( 'Instructor', 'tutor-pro' ),
				// 	'course_name'     => __( 'Mastering WordPress-From Beginner to Advance', 'tutor-pro' ),
				// 	'assignment_name' => __( 'Create your first WordPress site', 'tutor-pro' ),
				// 	'before_button'   => __( 'Review the assignment from your instructor dashboard and submit the score at your earliest convenience.', 'tutor-pro' ),
				// 	'heading'         => __( 'New Assignment Submitted', 'tutor-pro' ),
				// 	'message'         => json_encode( 'An assignment has been submitted.' ),
				// 	'footer_text'     => __( 'You may reply to this email to communicate with the student.', 'tutor-pro' ),
				// ),
				'withdrawal_request_approved'     => array(
					'label'           => __( 'Withdrawal Request Approved', 'tutor-pro' ),
					'default'         => 'off',
					'template'        => 'to_instructor_withdrawal_request_approved',
					'tooltip'         => 'Enable to send withdrawal request approved email notification',
					'subject'         => __( 'Congratulations! Withdrawal Request Successful!', 'tutor-pro' ),
					'heading'         => __( 'Withdrawal Request Successful!', 'tutor-pro' ),
					'withdraw_amount' => __( '9XX USD', 'tutor-pro' ),
					'message'         => json_encode( 'Congratulations! We have sent your requested withdrawal amount via <strong>Paypal</strong> on 20 Sep 2020, 9:30 PM (GMT+06).' ),
					'footer_text'     => __( 'You may reply to this email to communicate with the {admin_user}', 'tutor-pro' ),
				),
				'withdrawal_request_rejected'     => array(
					'label'           => __( 'Withdrawal Request Rejected', 'tutor-pro' ),
					'default'         => 'off',
					'template'        => 'to_instructor_withdrawal_request_rejected',
					'tooltip'         => 'Enable to send withdrawal request rejected email notification',
					'subject'         => __( 'Withdrawal Request Rejected!', 'tutor-pro' ),
					'heading'         => __( 'Withdrawal Request Rejected!', 'tutor-pro' ),
					'withdraw_amount' => __( '20 USD', 'tutor-pro' ),
					'message'         => json_encode( 'We are sorry to inform you that we could not process the request for withdrawal via <strong>Paypal</strong> on 20 Sep 2020, 9:30 PM (GMT+06). Please reply to this email for further details.' ),
					'footer_text'     => __( 'You may reply to this email to communicate with the {admin_user}', 'tutor-pro' ),
				),
				'withdrawal_request_received'     => array(
					'label'               => __( 'Withdrawal Request Received', 'tutor-pro' ),
					'default'             => 'off',
					'template'            => 'to_instructor_withdrawal_request_received',
					'tooltip'             => 'Enable to send withdrawal request received email notification',
					'subject'             => __( 'Withdrawal Request Received!', 'tutor-pro' ),
					'withdraw_amount'     => __( '20 USD', 'tutor-pro' ),
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'instructor_email'    => __( 'instructor@tutor.com', 'tutor-pro' ),
					'heading'             => __( 'Withdrawal Request Successful!', 'tutor-pro' ),
					'message'             => json_encode( 'We have received a withdrawal request via Paypal on 20 Sep 2020, 9:30 PM (GMT+06). We will process the request very soon. You will be notified via email as soon as we process it.' ),
					'footer_text'         => __( 'You may reply to this email to communicate with the {admin_user}.', 'tutor-pro' ),
				),
				'instructor_application_accepted' => array(
					'label'       => __( 'Instructor Application Accepted', 'tutor-pro' ),
					'default'     => 'off',
					'template'    => 'to_instructor_become_application_approved',
					'tooltip'     => 'Enable to send instructor application acceptance email notification',
					'subject'     => __( 'Congratulations! Your Application to Become an Instructor at {site_name} is Approved!', 'tutor-pro' ),
					'heading'     => __( 'Welcome you on Board', 'tutor-pro' ),
					'message'     => json_encode( 'Welcome Aboard! Your application to become an instructor at {site_url} is approved! Your dashboard is ready and you can start creating courses right away!'),
					'footer_text' => __( 'You may reply to this email to communicate with the {admin_user}.', 'tutor-pro' ),
				),
				'instructor_application_rejected' => array(
					'label'       => __( 'Instructor Application Rejected', 'tutor-pro' ),
					'default'     => 'off',
					'template'    => 'to_instructor_become_application_rejected',
					'tooltip'     => 'Enable to send instructor application rejected email notification',
					'subject'     => __( 'Feedback on your application to become an instructor on {site_name}', 'tutor-pro' ),
					'heading'     => __( 'Withdrawal Request Rejected!', 'tutor-pro' ),
					'message'     => json_encode( 'We are sorry to inform you that we are unable to process your application to become an instructor on our website. You are always welcome to try again.' ),
					'footer_text' => __( 'You may reply to this email to communicate with the {admin_user}', 'tutor-pro' ),
				),
				'instructor_application_received' => array(
					'label'               => __( 'Instructor Application Received', 'tutor-pro' ),
					'default'             => 'off',
					'template'            => 'to_instructor_become_application_received',
					'tooltip'             => 'Enable to send instructor application received email notification',
					'subject'             => __( 'Application Received - {site_name}', 'tutor-pro' ),
					'heading'             => __( 'Received Application', 'tutor-pro' ),
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'instructor_email'    => __( 'instructor@tutor.com', 'tutor-pro' ),
					'message'             => json_encode( 'Application Received! We are happy that you have considered TutorLMS.com to host your courses. Please allow us some time to review your credentials. If we need any clarification on anything, we will reach out to you. Please expect an email from us in a very short time!.' ),
					'footer_text'         => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				'instructor_course_publish'       => array(
					'label'               => __( 'Instructor Course Published', 'tutor-pro' ),
					'default'             => 'off',
					'template'            => 'to_instructor_course_accepted',
					'tooltip'             => 'Enable to send instructor course published email notification',
					'subject'             => __( 'Congratulations! {course_name} is published at {site_name}', 'tutor-pro' ),
					'heading'             => __( 'Your Course is Published', 'tutor-pro' ),
					'instructor_username' => __( 'Instructor', 'tutor-pro' ),
					'course_name'         => __( 'Course name', 'tutor-pro' ),
					'student_username'    => __( 'John Doe', 'tutor-pro' ),
					'student_email'       => __( 'student@testmail.com', 'tutor-pro' ),
					'message'             => json_encode( 'We are glad to inform you that your course is now live on <strong>{site_url}</strong>.' ),
					'footer_text'         => __( 'Reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				// @TODO: To be implemented later
				// 'a_instructor_course_rejected'    => array(
				// 	'label'               => __( 'An Instructor\'s Course Rejected', 'tutor-pro' ),
				// 	'default'             => 'off',
				// 	'template'            => 'to_instructor_course_rejected',
				// 	'tooltip'             => 'Enable to send instructor’s course rejected email notification',
				// 	'subject'             => __( 'Course Content Review Request - {course_name}', 'tutor-pro' ),
				// 	'heading'             => __( 'Course Content Review Request', 'tutor-pro' ),
				// 	'course_title'        => __( 'Course Content Review Request title.', 'tutor-pro' ),
				// 	'instructor_username' => __( 'Instructor', 'tutor-pro' ),
				// 	'message'             => json_encode( 'We are sorry to inform you that we are unable to publish your course. Please review the course and submit it again.' ),
				// ),
			),
			'email_to_admin'    => array(
				'new_instructor_signup'  => array(
					'label'           => __( 'New Instructor Signup', 'tutor-pro' ),
					'default'         => 'on',
					'template'        => 'to_admin_new_instructor_signup',
					'tooltip'         => 'Enable to get new instructor signup email notification',
					'instructor_name' => __( 'Instructor', 'tutor-pro' ),
					'subject'         => __( 'New Instructor Signed up at {site_url}', 'tutor-pro' ),
					'heading'         => __( 'New Instructor Sign Up', 'tutor-pro' ),
					'message'         => json_encode( 'A new instructor has signed up on <strong>{site_url}</strong>.' ),
					'footer_text'     => __( 'You may reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				'new_student_signup'     => array(
					'label'           => __( 'New Student Signup', 'tutor-pro' ),
					'default'         => 'on',
					'template'        => 'to_admin_new_student_signup',
					'tooltip'         => 'Enable to get new student signup email notification',
					'instructor_name' => __( 'Instructor', 'tutor-pro' ),
					'student_name'    => __( 'Student', 'tutor-pro' ),
					'subject'         => __( 'New Student Signed up at {site_url}', 'tutor-pro' ),
					'heading'         => __( 'New Student Sign Up', 'tutor-pro' ),
					'message'         => json_encode( 'A new student has signed up to your site <strong>{site_url}</strong>'),
					'footer_text'     => __( 'You may reply to this email to communicate with the student.', 'tutor-pro' ),
				),
				'new_course_submitted'   => array(
					'label'           => __( 'New Course Submitted for Review', 'tutor-pro' ),
					'default'         => 'on',
					'template'        => 'to_admin_new_course_submitted_for_review',
					'tooltip'         => 'Enable to get course review email notification',
					'subject'         => __( '{instructor_name} Submitted a New Course For Review', 'tutor-pro' ),
					'heading'         => __( 'New Course Submitted for Review', 'tutor-pro' ),
					'course_name'     => __( 'Mastering WordPress-From Beginner to Advance', 'tutor-pro' ),
					'instructor_name' => __( 'Instructor', 'tutor-pro' ),
					'message'         => json_encode( 'A new course has been created by <strong>{instructor_name}</strong> on your site  <strong>{site_url}</strong> and is waiting for approval.' ),
					'footer_text'     => __( 'You may reply to this email to communicate with the instructor', 'tutor-pro' ),
				),
				'new_course_published'   => array(
					'label'           => __( 'New Course Published', 'tutor-pro' ),
					'default'         => 'on',
					'template'        => 'to_admin_new_course_published',
					'tooltip'         => 'Enable to get new course published email notification',
					'subject'         => __( '{instructor_name} Publishded a new course {course_name}', 'tutor-pro' ),
					'heading'         => __( 'New Course Published', 'tutor-pro' ),
					'course_name'     => __( 'Mastering WordPress-From Beginner to Advance', 'tutor-pro' ),
					'instructor_name' => __( 'Jhon Doe', 'tutor-pro' ),
					'message'         => json_encode( 'The instructor - <strong>{instructor_name}</strong> has published a new course on your site <strong>{site_url}</strong>.' ),
					'footer_text'     => __( 'You may reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
				'course_updated'         => array(
					'label'           => __( 'Course Edited/Updated', 'tutor-pro' ),
					'default'         => 'on',
					'template'        => 'to_admin_course_updated',
					'tooltip'         => 'Enable to get course edit or update email notification',
					'subject'         => __( '{course_name} Updated by {instructor_name}', 'tutor-pro' ),
					'heading'         => __( 'Course Updated', 'tutor-pro' ),
					'course_name'     => __( 'Mastering WordPress-From Beginner to Advance', 'tutor-pro' ),
					'student_name'    => __( 'James Andy', 'tutor-pro' ),
					'instructor_name' => __( 'Jhon Doe', 'tutor-pro' ),
					'student_email'   => __( 'student@testmail.com', 'tutor-pro' ),
					'footer_text'     => __( 'You may reply to this email to communicate with the instructor.', 'tutor-pro' ),
					'message'         => json_encode( 'The Instructor - <strong>{instructor_name}</strong> has updated a course on <strong>{site_url}</strong>.' ),
				),
				'new_withdrawal_request' => array(
					'label'               => __( 'New Withdrawal Request', 'tutor-pro' ),
					'default'             => 'on',
					'template'            => 'to_admin_new_withdrawal_request',
					'tooltip'             => 'Enable to get new withdrawal request email notification',
					'subject'             => __( 'New withdrawal request from {instructor_username} for {withdraw_amount}', 'tutor-pro' ),
					'withdraw_amount'     => __( '20 USD', 'tutor-pro' ),
					'instructor_username' => __( 'Jhon Doe', 'tutor-pro' ),
					'instructor_email'    => __( 'instructor@{site_url}', 'tutor-pro' ),
					'heading'             => __( 'New Withdrawal Request', 'tutor-pro' ),
					'message'             => json_encode( 'Instructor <strong>{instructor_username}</strong>  has sent a withdrawal request  to your site <strong>{site_url}</strong>'),
					'footer_text'         => __( 'You may reply to this email to communicate with the instructor.', 'tutor-pro' ),
				),
			),
		);

		return apply_filters( 'tutor_pro/email/list', $email_array );
	}
}

