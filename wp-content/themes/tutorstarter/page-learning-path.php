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

				// get a specified course
				// PHP Essentials: A Beginner’s Guide to Mastering PHP
				$course_id = 15053;

				// print the course title
				// echo get_the_title( $course_id );

				// print the course link as <a>
				echo '<a href="' . get_the_permalink( $course_id ) . '">' . get_the_title( $course_id ) . '</a><br>';
				
				// get all child courses of this course though wp_postmeta  _tutor_course_children
				$child_courses = get_post_meta( $course_id, '_tutor_course_children', true );
				// convert to array
				$child_courses = explode( ' ', $child_courses );
				// done

				// print all child courses link as href
				foreach ( $child_courses as $child_course ) {
					echo '<a href="' . get_the_permalink( $child_course ) . '">' . get_the_title( $child_course ) . '</a><br>';
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
