<?php
/*
 * Template Name: Course List Page
 */
defined('ABSPATH') || exit;
get_header();

// -- Tutor LMS	Version 2.4.0 by Themeum | Auto-updates disabled
// -- Tutor LMS Elementor Addons	Version 2.1.3 by Themeum | Auto-updates disabled
// -- Tutor LMS Pro	Version 2.4.0 by Themeum | Auto-updates disabled
// -- TutorMate	Version 1.0.5 by Themeum | Auto-updates disabled

// Link bootstrap 
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php

$page_meta = get_post_meta(get_the_ID(), '_tutorstarter_page_metadata', true);
$sidebar = (!empty($page_meta) ? $page_meta['sidebar_select'] : 'no-sidebar');
?>

<?php
	if (!empty($sidebar)) {
		echo ''. $sidebar .'</div>';
	}

	var_dump('course list page');

	// vardump all the courses
	// $courses = tutor_utils()->get_courses();
	// var_dump($courses);
?>

<!-- Here is the HTML Template we will use for Course List -->
<section>
     <div class="row container">
		<div class="col-3 course-filter-container">
			<div class="course-filter">
				<form  class="course-filter-form">
					<div class="course-widget course-widget-search">
						<div class="course-form-wrap">
							<span class="icon-search">
								<i class="fa fa-search"></i>
							</span>
							<input type="text" class="course-search-form-control" name="keyword" placeholder="Search for Courses" value="">
						</div>
					</div>
					<div class="course-widget course-widget-category">
						<!-- title -->
						<h4 class="course-widget-title">Category</h4>
						<!-- content -->
						<div class="course-widget-content">
							<ul class="course-widget-list">
								<li class="course-widget-list-item">
									<label>
										<input type="checkbox" name="category[]" value="1" class="course-widget-list-checkbox">
										<span class="course-widget-list-label">All</span>
									</label>
								</li>
								<li class="course-widget-list-item">
									<label>
										<input type="checkbox" name="category[]" value="2" class="course-widget-list-checkbox">
										<span class="course-widget-list-label">Web</span>
									</label>
								</li>
								<li class="course-widget-list-item">
									<label>
										<input type="checkbox" name="category[]" value="3" class="course-widget-list-checkbox">
										<span class="course-widget-list-label">Mobile</span>
									</label>
								</li>
								<li class="course-widget-list-item">
									<label>
										<input type="checkbox" name="category[]" value="4" class="course-widget-list-checkbox">
										<span class="course-widget-list-label">Design</span>
									</label>
								</li>
							</ul>
						</div>
					</div>
					<div class="course-widget course-widget-level">
						<!-- title -->
						<h4 class="course-widget-title">Level</h4>
						<!-- content -->
						<div class="course-widget-content">
							<ul class="course-widget-list">
								<li>
									<label>
										<input type="checkbox" name="level[]" value="1" class="course-widget-list-checkbox">
										<span class="course-widget-list-label">All</span>
									</label>
								</li>
								<li>
									<label>
										<input type="checkbox" name="level[]" value="2" class="course-widget-list-checkbox">
										<span class="course-widget-list-label">Beginner</span>
									</label>
								</li>
								<li>
									<label>
										<input type="checkbox" name="level[]" value="3" class="course-widget-list-checkbox">
										<span class="course-widget-list-label">Intermediate</span>
									</label>
								</li>
								<li>
									<label>
										<input type="checkbox" name="level[]" value="4" class="course-widget-list-checkbox">
										<span class="course-widget-list-label">Advanced</span>
									</label>
								</li>
							</ul>
						</div>
					</div>
					<div class="course-widget course-widget-price">
						<!-- title -->
						<h4 class="course-widget-title">Price</h4>
						<!-- content -->
						<div class="course-widget-content">
							<ul class="course-widget-list">
								<li>
									<label>
										<input type="checkbox" name="price[]" value="1" class="course-widget-list-checkbox">
										<span class="course-widget-list-label">All</span>
									</label>
								</li>
								<li>
									<label>
										<input type="checkbox" name="price[]" value="2" class="course-widget-list-checkbox">
										<span class="course-widget-list-label">Free</span>
									</label>
								</li>
								<li>
									<label>
										<input type="checkbox" name="price[]" value="3" class="course-widget-list-checkbox">
										<span class="course-widget-list-label">Paid</span>
									</label>
								</li>
							</ul>
						</div>
					</div>
					<!-- Clear all filters -->
					<div class="course-widget course-widget-clear">
						<a href="#" class="course-widget-clear-link">Clear all filters</a>
					</div>
				</form>
			</div>
		</div>

		<!-- Course content -->
		<div class="col-9 course-content-container">
			<!-- Sort -->
			<div>
				<div style="text-align: right;" class="course-filter" course-filter="">
					<form style="display: inline-block;">
						<select class="form-select" name="course_order" style="display: none;">
							<option value="newest_first">
								Release Date (newest first) </option>
							<option value="oldest_first">
								Release Date (oldest first) </option>
							<option value="course_title_az">
								Course Title (a-z) </option>
							<option value="course_title_za">
								Course Title (z-a) </option>
						</select>
						<div class="form-control form-select js-form-select">
							<span class="form-select-label" dropdown-label="">Release Date (newest first)</span>
							<div class="form-select-dropdown">
								<div class="form-select-search pt-8 px-8">
									<div class="form-wrap">
										<span class="form-icon"><i class="icon-search" area-hidden="true"></i></span>
										<input type="search" class="form-control" placeholder="Search ...">
									</div>
								</div>
								<div class="form-select-options">

									<div class="form-select-option">
										<span dropdown-item="" data-key="newest_first" class="nowrap-ellipsis"
											title="Release Date (newest first)">Release Date (newest first)</span>
									</div>

									<div class="form-select-option">
										<span dropdown-item="" data-key="oldest_first" class="nowrap-ellipsis"
											title="Release Date (oldest first)">Release Date (oldest first)</span>
									</div>

									<div class="form-select-option">
										<span dropdown-item="" data-key="course_title_az" class="nowrap-ellipsis"
											title="Course Title (a-z)">Course Title (a-z)</span>
									</div>

									<div class="form-select-option">
										<span dropdown-item="" data-key="course_title_za" class="nowrap-ellipsis"
											title="Course Title (z-a)">Course Title (z-a)</span>
									</div>

								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<!-- Courses -->
			<div class="courses-pagination-wrapper-replaceable">
				<div class="course-list d-grid d-grid-3">
					<div class="course-card _card">
						<!-- thumbnail -->
						<div class="course-thumbnail">
							<a href="https://mythosedu.com/courses/course-moblie-1/" class="course-thumbnail-link">
								<div class="course-thumbnail-image">
									<img src="https://mythosedu.com/wp-content/uploads/2023/11/React-Native-1024x576.jpg" alt="Complete React Native in 2023: Zero to Mastery (with Hooks)" loading="lazy">
								</div>
							</a>
						</div>
						<!-- content -->
						<!-- bookmark -->
						<div class="course-bookmark">
							<a href="javascript:;" class="course-wishlist-btn save-bookmark-btn">
								<i class="fa fa-bookmark-o"></i>
							</a>
						</div>
						<!-- body -->
						<div class="course-card-body">
							<!-- ratings -->
							<div class="course-ratings">
								<div class="ratings">
									<div class="ratings-stars">
										<span class="icon-star-line" data-rating-value="1"></span>
										<span class="icon-star-line" data-rating-value="2"></span>
										<span class="icon-star-line" data-rating-value="3"></span>
										<span class="icon-star-line" data-rating-value="4"></span>
										<span class="icon-star-line" data-rating-value="5"></span>
									</div>
								</div>
							</div>
							<!-- title -->
							<h3 class="course-name" title="Complete React Native in 2023: Zero to Mastery (with Hooks)">
								<a href="https://mythosedu.com/courses/course-moblie-1/">Complete React Native in 2023: Zero to Mastery (with Hooks)</a>
							</h3>
							<!-- meta -->
							<div class="course-meta">
								<div>
									<span class="icon-user-line" area-hidden="true"></span>
									<span class="meta-value">0</span>
								</div>
							</div>
							<!-- instructor -->
							<div class="course-meta">
								<div>
									<a href="https://mythosedu.com/profile/mythosedu-com?view=instructor" class="d-flex">
										<div class="avatar">
											<div class="ratio ratio-1x1">
												<span class="avatar-text">M</span>
											</div>
										</div>
									</a>
								</div>
								<div>
									By <a href="https://mythosedu.com/profile/mythosedu-com?view=instructor">mythosedu.com</a>
									In <a href="https://mythosedu.com/course-category/moblie/?tutor-course-filter-category=105">Mobile</a>
								</div>
							</div>
						</div>
						<!-- footer -->
						<!-- Enroll/Continue Learning -->
						<div class="course-card-footer">
							<div class="course-list-btn">
								<a href="https://mythosedu.com/courses/course-moblie-1/" class="btn btn-outline-primary btn-md btn-block">
									Start Learning
								</a>
							</div>
						</div>
					</div>
					<div class="course-card _card">
						<!-- thumbnail -->
						<div class="course-thumbnail">
							<a href="https://mythosedu.com/courses/course-moblie-1/" class="course-thumbnail-link">
								<div class="course-thumbnail-image">
									<img src="https://mythosedu.com/wp-content/uploads/2023/11/React-Native-1024x576.jpg" alt="Complete React Native in 2023: Zero to Mastery (with Hooks)" loading="lazy">
								</div>
							</a>
						</div>
						<!-- content -->
						<!-- bookmark -->
						<div class="course-bookmark">
							<a href="javascript:;" class="course-wishlist-btn save-bookmark-btn">
								<i class="fa fa-bookmark-o"></i>
							</a>
						</div>
						<!-- body -->
						<div class="course-card-body">
							<!-- ratings -->
							<div class="course-ratings">
								<div class="ratings">
									<div class="ratings-stars">
										<span class="icon-star-line" data-rating-value="1"></span>
										<span class="icon-star-line" data-rating-value="2"></span>
										<span class="icon-star-line" data-rating-value="3"></span>
										<span class="icon-star-line" data-rating-value="4"></span>
										<span class="icon-star-line" data-rating-value="5"></span>
									</div>
								</div>
							</div>
							<!-- title -->
							<h3 class="course-name" title="Complete React Native in 2023: Zero to Mastery (with Hooks)">
								<a href="https://mythosedu.com/courses/course-moblie-1/">Complete React Native in 2023: Zero to Mastery (with Hooks)</a>
							</h3>
							<!-- meta -->
							<div class="course-meta">
								<div>
									<span class="icon-user-line" area-hidden="true"></span>
									<span class="meta-value">0</span>
								</div>
							</div>
							<!-- instructor -->
							<div class="course-meta">
								<div>
									<a href="https://mythosedu.com/profile/mythosedu-com?view=instructor" class="d-flex">
										<div class="avatar">
											<div class="ratio ratio-1x1">
												<span class="avatar-text">M</span>
											</div>
										</div>
									</a>
								</div>
								<div>
									By <a href="https://mythosedu.com/profile/mythosedu-com?view=instructor">mythosedu.com</a>
									In <a href="https://mythosedu.com/course-category/moblie/?tutor-course-filter-category=105">Mobile</a>
								</div>
							</div>
						</div>
						<!-- footer -->
						<!-- Enroll/Continue Learning -->
						<div class="course-card-footer">
							<div class="course-list-btn">
								<a href="https://mythosedu.com/courses/course-moblie-1/" class="btn btn-outline-primary btn-md btn-block">
									Start Learning
								</a>
							</div>
						</div>
					</div>
					<div class="course-card _card">
						<!-- thumbnail -->
						<div class="course-thumbnail">
							<a href="https://mythosedu.com/courses/course-moblie-1/" class="course-thumbnail-link">
								<div class="course-thumbnail-image">
									<img src="https://mythosedu.com/wp-content/uploads/2023/11/React-Native-1024x576.jpg" alt="Complete React Native in 2023: Zero to Mastery (with Hooks)" loading="lazy">
								</div>
							</a>
						</div>
						<!-- content -->
						<!-- bookmark -->
						<div class="course-bookmark">
							<a href="javascript:;" class="course-wishlist-btn save-bookmark-btn">
								<i class="fa fa-bookmark-o"></i>
							</a>
						</div>
						<!-- body -->
						<div class="course-card-body">
							<!-- ratings -->
							<div class="course-ratings">
								<div class="ratings">
									<div class="ratings-stars">
										<span class="icon-star-line" data-rating-value="1"></span>
										<span class="icon-star-line" data-rating-value="2"></span>
										<span class="icon-star-line" data-rating-value="3"></span>
										<span class="icon-star-line" data-rating-value="4"></span>
										<span class="icon-star-line" data-rating-value="5"></span>
									</div>
								</div>
							</div>
							<!-- title -->
							<h3 class="course-name" title="Complete React Native in 2023: Zero to Mastery (with Hooks)">
								<a href="https://mythosedu.com/courses/course-moblie-1/">Complete React Native in 2023: Zero to Mastery (with Hooks)</a>
							</h3>
							<!-- meta -->
							<div class="course-meta">
								<div>
									<span class="icon-user-line" area-hidden="true"></span>
									<span class="meta-value">0</span>
								</div>
							</div>
							<!-- instructor -->
							<div class="course-meta">
								<div>
									<a href="https://mythosedu.com/profile/mythosedu-com?view=instructor" class="d-flex">
										<div class="avatar">
											<div class="ratio ratio-1x1">
												<span class="avatar-text">M</span>
											</div>
										</div>
									</a>
								</div>
								<div>
									By <a href="https://mythosedu.com/profile/mythosedu-com?view=instructor">mythosedu.com</a>
									In <a href="https://mythosedu.com/course-category/moblie/?tutor-course-filter-category=105">Mobile</a>
								</div>
							</div>
						</div>
						<!-- footer -->
						<!-- Enroll/Continue Learning -->
						<div class="course-card-footer">
							<div class="course-list-btn">
								<a href="https://mythosedu.com/courses/course-moblie-1/" class="btn btn-outline-primary btn-md btn-block">
									Start Learning
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	 </div>
</section>
<!-- End HTML Template -->

<?php

if (have_posts()) : while (have_posts()) : the_post();
get_template_part('','');
endwhile; endif;

?>

<?php

// This Course List Page will have:
// 1. Course Filter by Category, Level, Price
// 2. Course List
// 3. Course Pagination
// 4. Course Sort by Newest, Oldest, A-Z, Z-A
// 5. Course Search	by Keyword
// 6. Course content: Course Thumbnail, Course Title, Course Meta, Course Instructor, Course Enroll/Continue Learning Button


	// Get tutorLMS course category list
	// select * from wp_terms where term_id in (select term_id from wp_term_taxonomy where taxonomy = 'course-category');

	$course_categories = get_terms( array(
		'taxonomy' => 'course-category',
		'hide_empty' => false,
	) );

	// var_dump('categories_list: ');
	// if (!empty($course_categories) && !is_wp_error($course_categories)) {
	// 	foreach ($course_categories as $category) {
	// 		echo $category->name . '<br>';
	// 	}
	// }

	// get level list
	$course_levels = get_terms( array(
		'taxonomy' => 'course-level',
		'hide_empty' => false,
	) );
	var_dump($course_levels);


	get_footer();

?>

<?php
get_footer();
