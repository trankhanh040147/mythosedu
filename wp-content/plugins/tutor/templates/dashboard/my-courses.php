<?php

/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

$user = wp_get_current_user();
$shortcode_arg = isset($GLOBALS['tutor_shortcode_arg']) ? $GLOBALS['tutor_shortcode_arg']['column_per_row'] : null;
$courseCols = $shortcode_arg === null ? tutor_utils()->get_option('courses_col_per_row', 4) : $shortcode_arg;
!isset($active_tab) ? $active_tab = 'my-courses' : 0;
$per_page =tutor_utils()->get_option( 'pagination_per_page', 10 );
$paged    = (isset($_GET['current_page']) && is_numeric($_GET['current_page']) && $_GET['current_page'] >= 1) ? $_GET['current_page'] : 1;
$offset     = $per_page * ($paged-1);
if($active_tab == 'my-courses/pending-courses') $status = array('pending'); 
elseif($active_tab == 'my-courses/draft-courses') $status = array('draft'); 
elseif($active_tab == 'my-courses/private-courses') $status = array('private'); 
else $status = array('publish');


	$filter_prices = array(
		'free' => __( 'Free', 'tutor' ),
		'paid' => __( 'Paid', 'tutor' ),
	);

	$course_levels     = tutor_utils()->get_course_levels();
	$supported_filters = tutor_utils()->get_option( 'supported_course_filters', array() );
	$supported_filters = array_keys( $supported_filters );
?>
<?php if(current_user_can( 'administrator' ) || current_user_can( 'shop_manager' ) || current_user_can( 'st_lt' )):?>
<form method="POST">
<div class="tutor-course-listing-grid tutor-course-listing-grid-2">
<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">
<?php esc_html_e('All Courses', 'tutor'); ?>
</div>
<div class="tutor-input-group tutor-form-control-has-icon tutor-from-control">
					<span class="tutor-icon-search-filled tutor-input-group-icon tutor-color-black-50"></span>
					<input id="keyword" type="Search" value="<?php echo $_POST['keyword']; ?>" class="tutor-form-control" name="keyword" placeholder="<?php _e( 'Search...' ); ?>"/>
				</div>

</div>

<div class="tutor-course-listing-grid tutor-course-listing-grid-3">
	<div class="my-course-filters">
		<label class="tutor-form-label tutor-font-size-16">
		<?php 
			_e('Filter by Categories', 'tutor'); 
			$categories = tutor_utils()->get_course_categories();
		?>
		</label>
		<div class="tutor-form-field-course-categories">							
			<select name="course-categories[]" multiple='multiple' class="tutor_select2" data-placeholder="">
				<?php 
				foreach ( $categories as $category_id => $category ) {
					if($_POST["course-categories"])
						$has_in_term = in_array( $category->term_id, $_POST["course-categories"] );
					echo '<option value="' . $category->term_id . '" ' . selected( $has_in_term, true, false ) . '>'  . $category->name . '</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="my-course-filters">
		<label class="tutor-form-label tutor-font-size-16">
		<?php 
			_e('Filter by Level', 'tutor'); 			
		?>
		</label>
		<div class="tutor-form-field-course-categories">							
			<select name="course-levels[]" multiple='multiple' class="tutor_select2" data-placeholder="">
				<option value=""><?php  __( 'Select a Level', 'tutor' ) ?></option>;
				<?php
					foreach ( $course_levels as  $value => $title ) {
						if ( $value == 'all_levels' )	continue;
						if($_POST["course-levels"])
							$has_in_term = in_array( $value, $_POST["course-levels"] );
						echo '<option value="' . $value . '" ' . selected( $has_in_term, true, false ) . '>'  . $title . '</option>';
					}
				?>
			</select>
		</div>
	</div>
	<div class="my-course-filters">
		<label class="tutor-form-label tutor-font-size-16">
		<?php 
			_e('Filter by Price', 'tutor'); 			
		?>
		</label>
		<div class="tutor-form-field-course-categories">							
			<select name="course-prices[]" multiple='multiple' class="tutor_select2" data-placeholder="">
				<option value=""><?php  __( 'Select a Price', 'tutor' ) ?></option>;
				<?php
					foreach ( $filter_prices as $value => $title ) {
					
						
						if($_POST["course-prices"])
							$has_in_term = in_array( $value, $_POST["course-prices"] );
						echo '<option value="' . $value . '" ' . selected( $has_in_term, true, false ) . '>'  . $title . '</option>';
					}
				?>
			</select>
		</div>
	</div>
</div>
<div class="tutor-course-listing-grid tutor-course-listing-grid-3 mt-2">
	<div class="my-course-filters">
		<label class="tutor-form-label tutor-font-size-16">
		<?php 
			_e('Sort by', 'tutor'); 
		?>
		</label>
		<div class="tutor-form-field-sort_by">							
			<select name="sort_by" class="tutor-form-field-sort">
				<option value="date" <?php if($_POST['sort_by']!="title") echo "selected";?>><?php esc_html_e('Date', 'tutor'); ?></option>
				<option value="title" <?php if($_POST['sort_by']=="title") echo "selected";?>><?php esc_html_e('Title', 'tutor'); ?></option>
			</select>
		</div>
	</div>
	<div class="my-course-filters">
		<label class="tutor-form-label tutor-font-size-16">
		<?php 
			_e('&nbsp;', 'tutor'); 
		?>
		</label>
		<div class="tutor-form-field-sort_type">							
			<select name="sort_type" class="tutor-form-field-sort">
				<option value="ASC" <?php if($_POST['sort_type']=="ASC") echo "selected";?>><?php esc_html_e('ascending', 'tutor'); ?></option>
				<option value="DESC" <?php if($_POST['sort_type']!="ASC") echo "selected";?>><?php esc_html_e('descending', 'tutor'); ?></option>
			</select>
		</div>
	</div>
</div>	
<div class="tutor-text-center mt-3">
<button class="tutor-btn tutor-btn-primary tutor-btn-sm tutor-ml-16" type="submit" name="course_submit_filter" value="Submit">
	Submit</button>
<button class="tutor-btn tutor-btn-primary tutor-btn-sm tutor-ml-16" type="reset" id="course_reset_filter" value="Reset">
	Reset</button>	
</div>	
</form>	
<?php else:?>
<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">
<?php esc_html_e('All Courses', 'tutor'); ?>
</div>
<?php endif;?>
<div class="tutor-dashboard-content-inner my-courses">
<?php
		$_post = tutor_sanitize_data( $_POST );
		$sort_by                = sanitize_text_field( tutils()->array_get( 'sort_by', $_post, null ) );
		$sort_type              = sanitize_text_field( tutils()->array_get( 'sort_type', $_post, null ) );
		$sort_by		= ($sort_by)?$sort_by : 'post_date';
		$sort_type			= ($sort_type)?$sort_type : 'desc';
		$args = array(
			'post_status'    => $status[0],
			'post_type'      => 'courses',			
			'posts_per_page' => $per_page,
			'paged'          => $paged,
			'tax_query'      => array(
				'relation' => 'OR',
			),
		);

		$term_array                             = tutils()->array_get( 'course-categories', $_post, array() );
		
			! is_array( $term_array ) ? $term_array = array( $term_array ) : 0;

			$term_array = array_filter(
				$term_array,
				function( $term_id ) {
					return is_numeric( $term_id );
				}
			);

			if ( count( $term_array ) > 0 ) {
				$tax_query = array(
					'taxonomy' => 'course-category',
					'field'    => 'term_id',
					'terms'    => $term_array,
					'operator' => 'IN',
				);
				array_push( $args['tax_query'], $tax_query );
			}

		// Prepare level and price type
		$is_membership = get_tutor_option( 'monetize_by' ) == 'pmpro' && tutils()->has_pmpro();
		$level_price   = array();
		foreach ( array( 'level', 'price' ) as $type ) {

			if ( $is_membership && 'price' === $type ) {
				//continue;
			}

			$type_array = tutils()->array_get( 'course-' . $type.'s', $_post, array() );
			$type_array = array_map( 'sanitize_text_field', ( is_array( $type_array ) ? $type_array : array( $type_array ) ) );

			if ( count( $type_array ) > 0 ) {
				$level_price[] = array(
					'key'     => 'level' === $type ? '_tutor_course_level' : '_tutor_course_price_type',
					'value'   => $type_array,
					'compare' => 'IN',
				);
			}
		}
							
		$user_id = get_current_user_id();
		$vus_member = nl2br( strip_tags( get_user_meta( $user_id, '_tutor_vus_member', true ) ) );
		$vus_member	= $vus_member ? $vus_member : 'Internal';
				
		count( $level_price ) ? $args['meta_query'] = $level_price : 0;
		
		global $wp_query;
		$search_key              = sanitize_text_field( tutils()->array_get( 'keyword', $_post, null ) );
		$search_key ? $args['search_filter'] = $search_key : 0;

		if(defined("_DELETE_DRAFT_"))
		$delete_draft = intval(_DELETE_DRAFT_);
		$delete_draft=($delete_draft)?$delete_draft:5;
		$args_del = array(
		'fields'         => 'ids',
		'post_type'   	=> 'courses',
		'post_status'    => array( 'draft') ,
		's' 			 => 'Auto Draft',
		'posts_per_page' => '-1',
		'date_query'     => array(
							'column'  => 'post_date',
							'before'   => "-".$delete_draft." minutes"
							)
		);

		// The Query
		//$query = new WP_Query( $args );
		query_posts( $args_del );
		// The Loop
		if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			//echo get_the_ID();
			wp_delete_post(get_the_ID(),true); 
		}    
		}
		wp_reset_postdata();
		$args['not_draft_search'] = 'Auto Draft';
		
		$args['orderby']		= $sort_by;
		$args['order']			= $sort_type;
					
		query_posts( apply_filters( 'tutor_course_filter_args', $args ) );
		global $wp_query;
		$found_courses = $wp_query->found_posts;

    ?>
	<div class="tutor-dashboard-inline-links">
        <ul>
            <li class="<?php echo $active_tab == 'my-courses' ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(tutor_utils()->get_tutor_dashboard_page_permalink('my-courses')); ?>">
                    <?php esc_html_e('Publish', 'tutor'); ?>
                </a>
            </li>
            <li class="<?php echo $active_tab == 'my-courses/pending-courses' ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(tutor_utils()->get_tutor_dashboard_page_permalink('my-courses/pending-courses')); ?>">
                    <?php esc_html_e('Pending', 'tutor'); ?>
                </a>
            </li>
            <li class="<?php echo $active_tab == 'my-courses/draft-courses' ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(tutor_utils()->get_tutor_dashboard_page_permalink('my-courses/draft-courses')); ?>">
                    <?php esc_html_e('Draft', 'tutor'); ?>
                </a>
            </li>
            <li class="<?php echo $active_tab == 'my-courses/private-courses' ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(tutor_utils()->get_tutor_dashboard_page_permalink('my-courses/private-courses')); ?>">
                    <?php esc_html_e('Private', 'tutor'); ?>
                </a>
            </li>
        </ul>
    </div>
<?php
	if ( have_posts() ) :
?>
<div class="tutor-course-listing-grid tutor-course-listing-grid-3">	
<?php
	/* Start the Loop */

	//tutor_course_loop_start();

	while ( have_posts() ) :
		the_post();
		
		
            //foreach ($courses_per_page as $post) :
                //setup_postdata($post);

                $avg_rating = tutor_utils()->get_course_rating()->rating_avg;
                $tutor_course_img = get_tutor_course_thumbnail_src();
                $id_string_delete = 'tutor_my_courses_delete_' . get_the_ID();
                $row_id = 'tutor-dashboard-my-course-' . get_the_ID();
            ?>

                <div id="<?php echo $row_id; ?>" class="tutor-course-listing-item tutor-course-listing-item-sm tutor-mycourses-card tutor-mycourse-<?php the_ID(); ?>">
                    <div class="tutor-course-listing-item-head tutor-d-flex">
                        <!-- <img src="<?php //echo esc_url($tutor_course_img); ?>" alt="Course Thumbnail"> -->
                        <div class="tutor-course-listing-thumbnail" style="background-image:url(<?php echo empty(esc_url($tutor_course_img)) ? $placeholder_img : esc_url($tutor_course_img) ?>)"></div>
                    </div>
                    <div class="tutor-course-listing-item-body tutor-px-20 tutor-py-20">
                        <div class="tutor-d-flex tutor-mb-7">
                            <span class="tutor-fs-6 tutor-fw-normal tutor-color-black-60">
                                <?php echo esc_html(get_the_date()); ?> <?php echo esc_html(get_the_time()); ?>
                            </span>
                        </div>
                        <div class="list-item-title tutor-fs-6 tutor-fw-bold tutor-color-black tutor-mb-16">
                            <a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a>
                        </div>
                        <div class="list-item-meta tutor-fs-7 tutor-fw-medium tutor-color-black tutor-d-flex tutor-mt-12">
                            <?php
                            $course_duration = get_tutor_course_duration_context($post->ID, true);
                            $course_students = tutor_utils()->count_enrolled_users_by_course();
                            ?>
                            <?php
                            if (!empty($course_duration)) { ?>
                                <div class="tutor-d-flex tutor-align-items-center">
                                    <span class="meta-icon tutor-icon-clock-filled tutor-color-muted tutor-icon-20 tutor-mr-3"></span>
                                    <span class="tutor-fs-7 tutor-fw-medium tutor-color-black"><?php echo $course_duration; ?></span>
                                </div>
                            <?php } ?>
                            <?php if (!empty($course_students)) : ?>
                                <div class="tutor-d-flex tutor-align-items-center">
                                    <span class="meta-icon tutor-icon-user-filled tutor-color-muted"></span>
                                    <span><?php echo $course_students; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Card footer -->
                    <div class="tutor-course-listing-item-footer has-border tutor-py-8 tutor-pl-20 tutor-pr-8">
                        <div class="tutor-d-flex tutor-align-items-center tutor-justify-content-between">
                            <div class="tutor-d-flex tutor-align-items-center">
                                <span class="tutor-fs-7 tutor-fw-medium tutor-color-muted tutor-mr-3">
                                    <?php esc_html_e('Price:', 'tutor') ?>
                                </span>
                                <span class="tutor-fs-7 tutor-fw-medium tutor-color-black">
                                    <?php echo tutor_utils()->tutor_price(tutor_utils()->get_course_price()); ?>
                                </span>
                            </div>
                            
							<?php if(current_user_can( 'administrator' )):?>
                            <div class="tutor-course-listing-item-btns">
                                <a href="<?php echo tutor_utils()->course_edit_link($post->ID); ?>" class="tutor-btn tutor-btn-icon tutor-btn-disable-outline tutor-btn-ghost tutor-no-hover tutor-btn-sm">
                                    <i class="tutor-icon-edit-filled tutor-icon-26 tutor-color-muted"></i>
                                </a>
                                <a href="#" data-tutor-modal-target="<?php echo $id_string_delete; ?>" class="tutor-dashboard-element-delete-btn tutor-btn tutor-btn-icon tutor-btn-disable-outline tutor-btn-ghost tutor-no-hover tutor-btn-sm">
                                    <i class="tutor-icon-delete-stroke-filled tutor-icon-24 tutor-color-muted"></i>
                                </a>
                            </div>
							<?php endif;?>
                        </div>
                    </div>

                    <!-- Delete prompt modal -->
                    <div id="<?php echo $id_string_delete; ?>" class="tutor-modal">
                        <span class="tutor-modal-overlay"></span>
                        <button data-tutor-modal-close class="tutor-modal-close">
                            <span class="tutor-icon-line-cross-line"></span>
                        </button>
                        <div class="tutor-modal-root">
                            <div class="tutor-modal-inner">
                                <div class="tutor-modal-body tutor-text-center">
                                    <div class="tutor-modal-icon">
                                        <img src="<?php echo tutor()->url; ?>assets/images/icon-trash.svg" />
                                    </div>
                                    <div class="tutor-modal-text-wrap">
                                        <h3 class="tutor-modal-title">
                                            <?php esc_html_e('Delete This Course?', 'tutor'); ?>
                                        </h3>
                                        <p>
                                            <?php esc_html_e('Are you sure you want to delete this course permanently from the site? Please confirm your choice.', 'tutor'); ?>
                                        </p>
                                    </div>
                                    <div class="tutor-modal-btns tutor-btn-group">
                                        <button data-tutor-modal-close class="tutor-btn tutor-is-outline tutor-is-default">
                                            <?php esc_html_e('Cancel', 'tutor'); ?>
                                        </button>
                                        <button class="tutor-btn tutor-list-ajax-action" data-request_data='{"course_id":<?php echo get_the_ID(); ?>,"action":"tutor_delete_dashboard_course"}' data-delete_element_id="<?php echo $row_id; ?>">
                                            <?php esc_html_e('Yes, Delete This', 'tutor'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            //wp_reset_postdata();
		endwhile;

	//tutor_course_loop_end();
?> </div>
<?php
	else :

		/**
		 * No course found
		 */
		// tutor_load_template('course-none');
		tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() );

	endif;
	
?>	<div class="tutor-mt-20">
            <?php
            if (($status[0] === 'publish' && $found_courses > $per_page) || ($status[0] === 'pending' && $pending_courses_count > $per_page)) {
                $pagination_data = array(
                    'total_items' => $status[0] === 'publish' ? $found_courses : $pending_courses_count,
                    'per_page'    => $per_page,
                    'paged'       => $paged,
                );
                tutor_load_template_from_custom_path(
                    tutor()->path . 'templates/dashboard/elements/pagination.php',
                    $pagination_data
                );
            }
            ?>

        </div>
</div>
<script type="text/javascript">
jQuery("#course_reset_filter").click(function(){
jQuery(".tutor_select2").val('').change();
jQuery(".tutor_select2  option").removeAttr("selected");
jQuery(".tutor-form-field-sort  option").removeAttr("selected");
});
</script>
	