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

				// get a specified course
				$input_course = 15053;
				// course_tree is a string that contains all course that recusive from $input_course
				// ex: course_tree = {15053{15054{15057, 15058}, 15055, 15056}}}
				$course_tree = '{' . $input_course;
				$cur_queue = array();
				$next_queue = array();
				$queue_level = 1;

				echo 'find last parent course:';
				$root_course = find_last_parents_course($input_course);
				echo $root_course;
				echo '<br>';
				
				array_push($cur_queue, $root_course);
				echo 'current queue: '; var_dump( $cur_queue ); echo '<br>';
				insert_queue_children_courses($root_course, $next_queue);

				// if next_queue is not empty
				while(!empty($next_queue)){
					$cur_queue = $next_queue;
					$next_queue = array();

					echo 'current queue: '; var_dump( $cur_queue ); echo '<br>';
					// print course_to_link of each course in current queue
					foreach($cur_queue as $cur_course) {
						$enroll_status = tutor_utils()->is_enrolled($cur_course);
						$complete_status = tutor_utils()->is_course_completed($cur_course);
						course_to_link($cur_course);
						// echo 'enroll status: '; var_dump( $enroll_status ); echo '<br>';
						echo 'complete status: '; var_dump( $complete_status ); echo '<br>';
						// if $enroll_status is not bool(false), print enrolled, else print not enrolled
						if($enroll_status) {
							echo 'enrolled<br>';
						} else {
							echo 'not enrolled<br>';
						}
						// if $complete_status is not NULL, print completed, else print not completed
						// if($complete_status) {
						// 	echo 'completed<br>';
						// } else {
						// 	echo 'not completed<br>';
						// }

					}
					// print enroll status, complete status of current user for each course in current queue
					foreach($cur_queue as $cur_course) {


					}
					echo '<br>';
					
					// loop through cur_queue, insert all child courses of cur_course to next_queue
					foreach($cur_queue as $cur_course) {
						insert_queue_children_courses($cur_course, $next_queue);
					}
				}

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
