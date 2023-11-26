<?php

/**
 * Template for displaying courses
 *
 * @since v.1.0.0
 *
 * @package LMS/Templates
 * @version 1.5.8
 */
tutor_utils()->tutor_custom_header();

$course_filter = (bool) tutor_utils()->get_option('course_archive_filter', false); 
$supported_filters = tutor_utils()->get_option('supported_course_filters', array());
?>



<?php
if ($course_filter && count($supported_filters)) {
?>
	<div class="tutor-wrap tutor-courses-wrap tutor-container">
		
		<div id="__id_course_title_in_list">All courses</div>
		<div class="tutor-course-listing-filter tutor-filter-course-grid-2 course-archive-page">

			<div class="tutor-course-filter tutor-course-filter-container">
				<div class="tutor-course-filter-widget">
					<?php tutor_load_template('course-filter.filters'); ?>
				</div>

			</div>
			<div id="tutor-course-filter-loop-container" class="<?php tutor_container_classes(); ?> tutor-course-filter-loop-container" data-column_per_row="<?php echo esc_html(tutor_utils()->get_option( 'courses_col_per_row', 4 )); ?>"><div style="background-color: #fff;" class="loading-spinner"></div>
				
				<?php tutor_load_template('archive-course-init'); ?>
			</div><!-- .wrap -->
		</div>
	</div>
<?php
} else {
	?>
	
	<div class="tutor-wrap tutor-courses-wrap tutor-container course-archive-page">

		<div id="__id_course_title_in_list">All courses</div>

		<div class="<?php tutor_container_classes(); ?>	tutor-course-filter-loop-container"><div style="background-color: #fff;" class="loading-spinner"></div>
			
			<?php tutor_load_template('archive-course-init'); ?>
		</div>
	</div>
	<?php
}
tutor_utils()->tutor_custom_footer(); ?>

<script>
	 $(document).ready(function(){
		
		let $cats = $('input[name="tutor-course-filter-category"]:checked');
		let $str_cates = "";

		$cats.each(function(){
			// Do stuff here with this
			//console.log(this.value);
			//console.log($(this).attr("data_cat_name"));
			if($(this).attr("data_cat_name") != "") {
				$str_cates =  $str_cates + ' <span class="__itemcat">' + $(this).attr("data_cat_name") + '</span>';
			}
		});
		if($str_cates == "") {
			$str_cates = '<span class="__itemcat"><?php _e("All courses", TPL_DOMAIN_LANG)?></span>';
		}
		$('#__id_course_title_in_list').html( $str_cates );

		$('.filter-widget-checkboxes').on('click','.tutor-form-check-input',function(e){
			let $cats = $('input[name="tutor-course-filter-category"]:checked');
			let $str_cates = "";

			$cats.each(function(){
				// Do stuff here with this
				// console.log(this.value);
				//console.log($(this).attr("data_cat_name"));
				//$('#__id_course_title_in_list').html($(this).attr("data_cat_name"));
				if($(this).attr("data_cat_name") != "") {
					$str_cates =  $str_cates + ' <span class="__itemcat">' + $(this).attr("data_cat_name") + '</span>';
				}

			});

			if($str_cates == "") {
				$str_cates = '<span class="__itemcat"><?php _e("All courses", TPL_DOMAIN_LANG)?></span>';
			}
			$('#__id_course_title_in_list').html( $str_cates );
		});


	 });



//alert('Hi....');
</script>
