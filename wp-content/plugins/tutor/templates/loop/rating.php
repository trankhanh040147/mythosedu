<?php
/**
 * A single course loop rating
 *
 * @since v.1.0.0
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="list-item-rating tutor-d-flex">
    <div class="tutor-ratings">
        <div class="tutor-rating-stars">
			<?php
				$course_rating = tutor_utils()->get_course_rating();
				tutor_utils()->star_rating_generator_course($course_rating->rating_avg);
			?>
        </div>
        <div class="tutor-rating-text tutor-color-black-60 tutor-fs-8 tutor-fw-medium">
			<?php
				if ($course_rating->rating_avg > 0) {
					echo apply_filters('tutor_course_rating_average', $course_rating->rating_avg);
					echo $course_rating->rating_count>0 ? '<span class="tutor-ml-4 tutor-d-inline">('.$course_rating->rating_count.')</span>' : 0;
				}
			?>
		</div>
    </div>
	<?php
		$children_ids = get_post_meta( get_the_ID(), '_tutor_course_children', true );
		$children_ids_arr = array();
		if($children_ids)
			$children_ids_arr = explode(" ",trim($children_ids));
		if (count($children_ids_arr)) {
	?>
		<div class="parent_course_icon" style="width:90%;text-align:right">
			<span class="">
				<i class="tutor-icon-layer-filled"></i>
			</span>
		</div>
	<?php
		}
	?>
</div>
