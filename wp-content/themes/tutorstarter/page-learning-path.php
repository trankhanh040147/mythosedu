<?php 
/* 
** Template Name: Learning Path
*/ 
defined( 'ABSPATH' ) || exit;

get_header();
$page_meta = get_post_meta( get_the_ID(), '_tutorstarter_page_metadata', true );
$sidebar   = ( ! empty( $page_meta ) ? $page_meta['sidebar_select'] : 'no-sidebar' );
?>

<div class="container">
	<div class="row align-stretch">
	<?php if ( 'left-sidebar' === $sidebar ) : ?>
		<div id="sidebar" class="col-sm-4">
			<?php dynamic_sidebar( 'tutorstarter-page-sidebar' ); ?>
		</div><!-- .col- -->
	<?php endif; ?>
	<div class="<?php echo 'no-sidebar' === $sidebar || '' === $sidebar ? 'col-xl-12 col-lg-12 col-sm-12' : 'col-sm-8'; ?>">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					get_template_part( 'views/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile;

				// write function course_to_link to print the course link as <a>
				function course_to_link( $course_id ) {
					echo '<a href="' . get_the_permalink( $course_id ) . '">' . get_the_title( $course_id ) . '</a><br>';
				}

				// find the first course that has no child course
				function find_first_end_course( $course_id ) {
					$child_courses = get_post_meta( $course_id, '_tutor_course_children', true );
					// convert to array
					$child_courses = explode( ' ', $child_courses );
					if ( empty( $child_courses ) ) {
						return $course_id;
					} else {
						foreach ( $child_courses as $child_course ) {
							return find_first_end_course( $child_course );
						}
					}
				}

				function find_last_parents_course($course_id) {
					$par_courses = get_post_meta( $course_id, '_tutor_course_parent', true );
					$par_courses = explode(' ', $par_courses );
					// echo 'find_last_parent_course' . $course_id . '<br>';
					if ( empty( $par_courses[0] ) ) {
						return $course_id;
					} else {
						foreach ( $par_courses as $par_course ) {
							return find_last_parent_course( $par_course );
						}
					}	
				}


                function insert_queue_children_courses($course_id, &$queue){
				$child_courses = get_post_meta( $course_id, '_tutor_course_children', true );
				$child_courses = explode( ' ', $child_courses );
				echo 'insert_queue_children_courses' . $course_id . '<br>';
				var_dump( $child_courses ); echo '<br>';

				if ( empty( $child_courses ) ) {
					return $queue;
				} else {
					foreach ( $child_courses as $child_course ) {
						array_push($queue, $child_course);
						// return insert_queue_children_courses($child_course, $queue);
					}
				}
				}

				// get a specified course
				$input_course = 15053;
				// course_tree is a string that contains all course that recusive from $input_course
				// ex: course_tree = {15053{15054{15057, 15058}, 15055, 15056}}}
				$course_tree = '{' . $input_course;
				$cur_queue = array();
				$next_queue = array();
				$queue_level = 1;

				// echo 'find last parent course:';
				// echo find_last_parent_course($input_course);
				// echo '<br>';
				
				array_push($cur_queue, $input_course);
				insert_queue_children_courses($input_course, $next_queue);

				//print queue
				var_dump( $cur_queue ); echo '<br>';
				var_dump( $next_queue );

				// // get all child courses of this course though wp_postmeta  _tutor_course_children
				// $child_courses = get_post_meta( $course_id, '_tutor_course_children', true );
				// // convert to array
				// $child_courses = explode( ' ', $child_courses );

				// // if have child_courses
				// if ( ! empty( $child_courses ) ) :
				// 	$course_tree .= '{';
				// 	$temp_str = '';
				// 	foreach ( $child_courses as $child_course ) :
				// 		// add child_course id to course_tree 
				// 		$temp_str .= $child_course . ',';
				// 		echo course_to_link( $child_course );
				// 	endforeach;
				// 	// remove the last comma
				// 	$temp_str = substr( $temp_str, 0, -1 );
				// 	$course_tree .= $temp_str;
				// 	$course_tree .= '}';
				// endif;

				// print all child courses link as href
				// foreach ( $child_courses as $child_course ) {

				// }

				// $course_tree .= '}';
				// echo $course_tree;

				?>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .col- -->
	<?php if ( 'right-sidebar' === $sidebar ) : ?>
		<div id="sidebar" class="col-sm-4">
			<?php dynamic_sidebar( 'tutorstarter-page-sidebar' ); ?>
		</div><!-- .col- -->
	<?php endif; ?>
	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
