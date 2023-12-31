<?php
/**
 * General class để xử lý hook logic
 *
 */

namespace TUTOR_PRO;

use TUTOR\Input;
use Tutor\Models\CourseModel;

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Class General
 *
 */
class General
{

	/**
	 * Khai báo các hook
	 *
	 * @return void
	 */
	public function __construct()
	{
		add_action('tutor_action_tutor_add_course_builder', array($this, 'tutor_add_course_builder'));
		add_filter('frontend_course_create_url', array($this, 'frontend_course_create_url'));
		add_filter('template_include', array($this, 'fs_course_builder'), 99);

		add_filter('tutor/options/extend/attr', array($this, 'extend_settings_option'));
		add_filter('tutor_course_builder_logo_src', array($this, 'tutor_course_builder_logo_src'));
		add_filter('tutor_email_logo_src', array($this, 'tutor_email_logo_src'));
		add_filter('tutor_pages', array($this, 'add_login_page'), 10, 1);

		add_action('tutor_after_lesson_completion_button', array($this, 'add_course_completion_button'), 10, 4);
		add_action('save_tutor_course', array($this, 'save_course_relative'), 10, 2);
	}

	/**
	 * Hiển thị nút hoàn thành khóa học sau khi hoàn thành tất cả nội dung khóa học.
	 *
	 * @since 2.4.0
	 *
	 * @param int   $course_id course id.
	 * @param int   $user_id user id.
	 * @param bool  $is_course_completed khoá học đã hoàn thành hay chưa.
	 * @param array $course_stats các thống kê khóa học.
	 *
	 * @return void
	 */
	public function add_course_completion_button($course_id, $user_id, $is_course_completed, $course_stats)
	{
		if (
			false === $is_course_completed
			&& $course_stats['completed_count'] === $course_stats['total_count']
			&& CourseModel::can_complete_course($course_id, $user_id)
		) {
			?>
			<div class="tutor-topbar-complete-btn tutor-mr-20">
				<form method="post">
					<?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>
					<input type="hidden" name="course_id" value="<?php echo esc_attr($course_id); ?>" />
					<input type="hidden" name="tutor_action" value="tutor_complete_course" />
					<button type="submit" class="tutor-topbar-mark-btn tutor-btn tutor-btn-primary tutor-ws-nowrap"
						name="complete_course" value="complete_course">
						<span class="tutor-icon-circle-mark-line tutor-mr-8" area-hidden="true"></span>
						<span>
							<?php esc_html_e('Complete Course', 'tutor-pro'); ?>
						</span>
					</button>
				</form>
			</div>
			<?php
		}
	}

	/**
	 * Thêm trang đăng nhập vào danh sách trang
	 *
	 *
	 * @param array $pages danh sách trang.
	 *
	 * @return array
	 */
	public function add_login_page(array $pages)
	{
		return array('tutor_login_page' => __('Tutor Login', 'tutor')) + $pages;
	}

	/**
	 * Xử lí khi người dùng submit khóa học từ frontend (course builder)
	 *
	 *
	 * @return void
	 */
	public function tutor_add_course_builder()
	{
		tutor_utils()->checking_nonce();

		$user_id = get_current_user_id();
		$course_post_type = tutor()->course_post_type;

		//phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
		$course_ID = Input::post('course_ID', 0, Input::TYPE_INT);
		$post_ID = Input::post('post_ID', 0, Input::TYPE_INT);

		if (!tutor_utils()->can_user_edit_course($user_id, $post_ID)) {
			wp_send_json_error(array('message' => __('Access Denied', 'tutor-pro')));
		}

		$post = get_post($post_ID);
		$update = true;

		/**
		 * Update the post
		 */

		$content = Input::post('content', '', Input::TYPE_KSES_POST);
		$title = Input::post('title', '');
		$tax_input = tutor_utils()->array_get('tax_input', $_POST); //phpcs:ignore
		$slug = Input::post('post_name', '');

		$post_data = array(
			'ID' => $post_ID,
			'post_title' => $title,
			'post_content' => $content,
			'post_name' => $slug,
		);

		// Publish hoặc Pending
		$message = null;
		$show_modal = true;
		$submit_action = Input::post('course_submit_btn', '');

		if ('save_course_as_draft' === $submit_action) {
			$post_data['post_status'] = 'draft';
			$message = __('Course has been saved as a draft.', 'tutor-pro');
			$show_modal = false;
		} elseif ('submit_for_review' === $submit_action) {
			$post_data['post_status'] = 'pending';
			$message = __('Course has been submitted for review.', 'tutor-pro');
		} elseif ('publish_course' === $submit_action) {
			$can_publish_course = (bool) tutor_utils()->get_option('instructor_can_publish_course');
			if ($can_publish_course || current_user_can('administrator')) {
				$post_data['post_status'] = 'publish';
				$message = __('Course has been published.', 'tutor-pro');
			} else {
				$post_data['post_status'] = 'pending';
				$message = __('Course has been submitted for review.', 'tutor-pro');
			}
		}

		if ($message) {
			update_user_meta($user_id, 'tutor_frontend_course_message_expires', time() + 5);
			update_user_meta(
				$user_id,
				'tutor_frontend_course_action_message',
				array(
					'message' => $message,
					'show_modal' => $show_modal,
				)
			);
		}
		wp_update_post($post_data);

		/**
		 * Cài đặt Thumbnail
		 */
		$_thumbnail_id = Input::post('tutor_course_thumbnail_id', 0, Input::TYPE_INT);
		self::update_post_thumbnail($post_ID, $_thumbnail_id);

		/**
		 * Thêm Taxonomy
		 */
		if (tutor_utils()->count($tax_input)) {
			foreach ($tax_input as $taxonomy => $tags) {
				$taxonomy_obj = get_taxonomy($taxonomy);
				if (!$taxonomy_obj) {
					/* translators: %s: taxonomy name */
					_doing_it_wrong(__FUNCTION__, sprintf(__('Invalid taxonomy: %s.'), $taxonomy), '4.4.0'); //phpcs:ignore
					continue;
				}

				// array = hierarchical, string = non-hierarchical.
				if (is_array($tags)) {
					$tags = array_filter($tags);
				}
				wp_set_post_terms($post_ID, $tags, $taxonomy);
			}
		}
		// Vardump for testing

		// $course_children_arr = explode(" ", $course_chilren);
		// // Convert each element in the array to an integer
		// $course_children_arr = array_map('intval', $course_children_arr);

		// $prerequisites_course_ids = Input::post('_tutor_course_prerequisites_ids', array(), Input::TYPE_ARRAY);
		// var_dump( $course_children_arr );
		// var_dump( $prerequisites_course_ids );

		
		global $wpdb;

		// Khởi tạo giá trị cho các field của khoá học
		$course_duration = "";
		$tutor_course_children = "";
		$tutor_course_parent = "";
		$tutor_is_public_course = "";
		$tutor_enable_qa = "";
		$tutor_course_level = "";
		$thumbnail_id = "";

		
		// lấy data của các bảng về
		$tbl_posts = $wpdb->prepare("SELECT * FROM tbl_posts WHERE ID = $post_ID");
		$tbl_posts = $wpdb->get_results($tbl_posts);

		// lấy id của các bảng wp_pm.post_id = wp_p.ID đã đúng
		$result = $wpdb->prepare("SELECT * FROM tbl_postmeta wp_pm
		JOIN tbl_posts wp_p ON wp_pm.post_id = wp_p.ID
		WHERE wp_pm.post_id = '$post_ID'");

			$results = $wpdb->get_results($result);
			foreach ($results as $value) {
				if($value->meta_key == '_course_duration') {
					$course_duration = $value->meta_value;
				 }
				if($value->meta_key == '_tutor_course_level') {
					$tutor_course_level = $value->meta_value;
				 }
				if($value->meta_key == '_tutor_enable_qa') {
					$tutor_enable_qa = $value->meta_value;
				 }
				if($value->meta_key == '_tutor_is_public_course') {
					$tutor_is_public_course = $value->meta_value;
				 }
				if($value->meta_key == '_thumbnail_id') {
					$thumbnail_id = $value->meta_value;
				 }
				if($value->meta_key == '_tutor_course_children') {
					$tutor_course_children = $value->meta_value;
				 }
				if($value->meta_key == '_tutor_course_parent') {
					$tutor_course_parent = $value->meta_value;
				 }
			}

				$tbl_course = array(
					'ID' => $tbl_posts[0]->ID,
					'course_title' => $tbl_posts[0]->post_title,
					'course_slug' => $tbl_posts[0]->post_name,
					'course_children' => $tutor_course_children,
					'course_parent' => $tutor_course_parent,
					'course_thumbnail_link' => $thumbnail_id,
					'course_is_public_course' => $tutor_is_public_course,
					// 'course_is_delete' => '0', mặc định là 0
					'course_duration' => $course_duration,
					'course_enable_qa' => $tutor_enable_qa,
					'course_level' => $tutor_course_level,
				);

		// topic 

		// vardump 
		// print_r_pre($results, '$results');
		print_r_pre($post_ID, '$post_ID');
		print_r_pre($course_ID, '$course_ID');
		print_r_pre($tbl_posts, '$tbl_posts');
		print_r_pre($tbl_course, '$tbl_course');
		
		// die();

		// Insert hoặc Update tbl_course dựa vào cột ID. Nếu trong table tbl_course chưa có ID thì insert, ngược lại update
		$wpdb->insert('tbl_course', $tbl_course);
		$wpdb->update('tbl_course', $tbl_course, array('ID' => $post_ID));
				
		// die();	
		do_action('save_tutor_course', $post_ID, $post_data);

		if (wp_doing_ajax()) {
			wp_send_json_success();
		} else {

			/**
			* Nếu REQUEST cập nhật không gọi từ trang chỉnh sửa, chuyển hướng nó đến trang chỉnh sửa
			 */
			$edit_mode = (int) sanitize_text_field(tutor_utils()->array_get('course_ID', $_GET));
			if (!$edit_mode) {
				$edit_page_url = add_query_arg(array('course_ID' => $post_ID));
				wp_redirect($edit_page_url);
				die();
			}

			/**
			 * Sau khi cập nhật thành công, chuyển hướng nó đến trang trước đó để tránh nhiều POST request
			 */
			$redirect_option_enabled = (bool) tutor_utils()->get_option('enable_redirect_on_course_publish_from_frontend');
			if ('publish_course' === $submit_action && true === $redirect_option_enabled) {
				$target_url = tutor_utils()->tutor_dashboard_url('my-courses');
				wp_safe_redirect($target_url);
			} else {
				wp_safe_redirect(tutor_utils()->referer());
			}

			die();
		}
		die();
	}


	/**
	 * Frontend Course builder url
	 *
	 * @return string
	 */
	public function frontend_course_create_url()
	{
		return tutor_utils()->get_tutor_dashboard_page_permalink('create-course');
	}


	/**
	 * Include Dashboard
	 *
	 * @param string $template template.
	 *
	 * @return bool|string
	 */
	public function fs_course_builder($template)
	{
		global $wp_query;

		if ($wp_query->is_page) {
			$student_dashboard_page_id = (int) tutor_utils()->get_option('tutor_dashboard_page_id');
			if (get_the_ID() === $student_dashboard_page_id) {
				if (tutor_utils()->array_get('tutor_dashboard_page', $wp_query->query_vars) === 'create-course') {
					if (is_user_logged_in()) {
						$template = tutor_get_template('dashboard.create-course');
					} else {
						$template = tutor_get_template('login');
					}
				}
			}
		}

		return $template;
	}


	/**
	 * Thêm các setting options
	 *
	 * @param array $attr settings options.
	 *
	 * @return array
	 */
	public function extend_settings_option($attr)
	{

		$pages = tutor_utils()->get_pages();

		array_unshift(
			$attr['design']['blocks']['block_course']['fields'],
			array(
				'key' => 'tutor_frontend_course_page_logo_id',
				'type' => 'upload_full',
				'label' => __('Course Builder Page Logo', 'tutor'),
				'desc' => __(
					'<p>Size: <strong>700x430 pixels;</strong> File Support:<strong>jpg, .jpeg or .png.</strong></p>',
					'tutor'
				),
			)
		);

		$attr['advanced']['blocks'][1]['fields'][] = array(
			'key' => 'hide_admin_bar_for_users',
			'type' => 'toggle_switch',
			'label' => __('Hide Admin Bar and Restrict Access to WP Admin for Instructors', 'tutor'),
			'label_title' => '',
			'default' => 'off',
			'desc' => __('Enable this to hide the WordPress Admin Bar from Frontend site, and restrict access to the WP Admin panel.', 'tutor'),
		);

		/**
		 * Thêm các setting options trong phần Course > Course
		 *

		 */
		$attr['course']['blocks']['block_course']['fields'][] = array(
			'key' => 'enable_redirect_on_course_publish_from_frontend',
			'type' => 'toggle_switch',
			'label' => __('Redirect Instructor to "My Courses" once Publish button is Clicked', 'tutor'),
			'default' => 'off',
			'label_title' => '',
			'desc' => __('Enable to Redirect an Instructor to the "My Courses" Page once he clicks on the "Publish" button', 'tutor'),
		);

		/**
		 * Ẩn các chi tiết của quiz từ phía frontend

		 */
		$attr['course']['blocks']['block_quiz']['fields'][] = array(
			'key' => 'hide_quiz_details',
			'type' => 'toggle_switch',
			'label' => __('Hide Quiz Details from the Students', 'tutor'),
			'default' => 'off',
			'desc' => __('If enabled, the students will not be able to see their quiz attempts details', 'tutor'),
		);

		/**
		 * Show enrollment box on top of page when mobile view
		 * Hiển thị enrollment box ở trên cùng của trang khi xem trên mobile
		 *

		 */
		$attr['design']['blocks']['course-details']['fields'][] = array(
			'key' => 'enrollment_box_position_in_mobile',
			'type' => 'select',
			'label' => __('Position of the Enrollment Box in Mobile View', 'tutor-pro'),
			'default' => 'bottom',
			'options' => array(
				'top' => __('On Page Top', 'tutor-pro'),
				'bottom' => __('On Page Bottom', 'tutor-pro'),
			),
			'desc' => __('You can decide where you want to show Enrollment Box on your Course Details page by selecting an option from here', 'tutor-pro'),
		);

		/**
		 * Option trang đăng nhập
		 *

		 */
		$login_option = array(
			'key' => 'tutor_login_page',
			'type' => 'select',
			'label' => __('Login Page', 'tutor'),
			'default' => '0',
			'options' => $pages,
			'desc' => __('This page will be used as the login page for both the students and the instructors.', 'tutor'),
		);
		/**
		 * Hoá đơn tạo cài đặt cho đăng ký thủ công
		 *

		 */
		$invoice_options = array(
			'key' => 'tutor_woocommerce_invoice',
			'type' => 'toggle_switch',
			'label' => __('Generate WooCommerce Order', 'tutor-pro'),
			'label_title' => '',
			'default' => 'off',
			'desc' => __('If you want to create an WooCommerce Order to keep Track of your Sales Report for Manual Enrolment', 'tutor'),
		);

		tutor_utils()->add_option_after(
			'enable_tutor_native_login',
			$attr['advanced']['blocks'][1]['fields'],
			$login_option
		);
		tutor_utils()->add_option_after(
			'tutor_woocommerce_order_auto_complete',
			$attr['monetization']['blocks']['block_options']['fields'],
			$invoice_options
		);

		$attr['design']['blocks']['course-details']['fields'][0]['group_options'][] = array(
			'key' => 'enable_sticky_sidebar',
			'type' => 'toggle_single',
			'label' => __('Sticky Sidebar', 'tutor-pro'),
			'label_title' => __('Disable', 'tutor-pro'),
			'default' => 'off',
			'desc' => __('Enable sticky sidebar on course details on scroll', 'tutor-pro'),
		);

		// TODO implement later.
		/**
		 * $attr['design']['blocks']['course-details']['fields'][0]['group_options'][] = array(
		 * 'key'         => 'enable_sticky_topbar',
		 * 'type'        => 'toggle_single',
		 * 'label'       => __( 'Sticky Topbar', 'tutor-pro' ),
		 * 'label_title' => __( 'Disable', 'tutor-pro' ),
		 * 'default'     => 'off',
		 * 'desc'        => __( 'Enable sticky topbar on course details on scroll', 'tutor-pro' ),
		 * );
		 */

		/**
		 * Lesson video hoàn tất.
		 *
		 */
		tutor_utils()->add_option_after(
			'enable_lesson_classic_editor',
			$attr['course']['blocks']['block_lesson']['fields'],
			array(
				'key' => 'control_video_lesson_completion',
				'type' => 'toggle_switch',
				'label' => __('Video Lesson Completion Control', 'tutor-pro'),
				'default' => 'off',
				'desc' => __('Enable to set the minimum video watch % for lesson completion, only works with Tutor Player.', 'tutor-pro'),
				'toggle_fields' => 'required_percentage_to_complete_video_lesson',
			)
		);

		tutor_utils()->add_option_after(
			'control_video_lesson_completion',
			$attr['course']['blocks']['block_lesson']['fields'],
			array(
				'key' => 'required_percentage_to_complete_video_lesson',
				'type' => 'number',
				'number_type' => 'integer',
				'label' => __('Set Required Percentage', 'tutor-pro'),
				'default' => 80,
				'max' => 100,
				'desc' => __('Specify the minimum video watch % learners must watch to mark the lesson as complete.', 'tutor-pro'),
			)
		);

		return $attr;
	}

	/**
	 * Course builder logo src
	 *
	 * @param string $url url.
	 *
	 * @return string
	 */
	public function tutor_course_builder_logo_src($url)
	{
		$media_id = (int) get_tutor_option('tutor_frontend_course_page_logo_id');
		if ($media_id) {
			return wp_get_attachment_url($media_id);
		}
		return $url;
	}

	/**
	 * Email logo src
	 *
	 * @param string $url url.
	 * @param mixed  $size size.
	 *
	 * @return string
	 */
	public function tutor_email_logo_src($url = null, $size = null)
	{

		$media_id = (int) get_tutor_option('tutor_email_template_logo_id');
		if ($media_id) {
			return wp_get_attachment_image_url($media_id, 'tutor-email-logo-size');
		}
		return $url;
	}

	/**
	 * Cập nhật thumbnail post
	 *
	 * Cập nhật meta thumbnail nếu thumbnail_id được set, ngược lại sẽ xóa meta hiện tại
	 *
	 * Used from frontend course & bundle builder
	 *
	 *
	 * @param int $post_id required post id.
	 * @param int $thumbnail_id thumbnail id.
	 *
	 * @return void
	 */
	public static function update_post_thumbnail(int $post_id, int $thumbnail_id = 0)
	{
		$thumbnail_id = (int) sanitize_text_field($thumbnail_id);
		$product_id = tutor_utils()->get_course_product_id($post_id);

		if ($thumbnail_id) {
			update_post_meta($post_id, '_thumbnail_id', $thumbnail_id);

			// Update product thumbnail.
			set_post_thumbnail($product_id, $thumbnail_id);
		} else {
			delete_post_meta($post_id, '_thumbnail_id');
		}
	}

	public function save_course_relative($post_ID, $postData)
	{
		/** PKhanh - Save Course relative */

		// Edited 6/12
		$course_parent_old = intval($_POST['_tutor_course_parent_old']);
		$course_parent_old_arr = explode(" ", $course_parent_old);
		$course_parent = "";
		$course_parent_arr = $_POST['_tutor_course_parent'];
		if (!isset($course_parent_arr))
			$course_parent_arr = array();
		$course_parent = implode(" ", $course_parent_arr);
		update_post_meta($post_ID, '_tutor_course_parent', $course_parent);
		$remove_parent = array_diff($course_parent_old_arr, $course_parent_arr);
		$add_parent = array_diff($course_parent_arr, $course_parent_old_arr);
		foreach ((array) $remove_parent as $r_p) {
			//remove this course as child from remove parent
			$remove_children_ids = get_post_meta($r_p, '_tutor_course_children', true);
			$remove_children_ids_arr = explode(" ", $remove_children_ids);
			$pos = array_search($post_ID, $remove_children_ids_arr);
			if ($pos !== false) {
				unset($remove_children_ids_arr[$pos]);
				$_tutor_course_children = implode(" ", $remove_children_ids_arr);
				update_post_meta($r_p, '_tutor_course_children', $_tutor_course_children);
			}
		}
		foreach ((array) $add_parent as $a_p) {
			//add this coure as child to add parent
			$add_children_ids = get_post_meta($a_p, '_tutor_course_children', true);
			$add_children_ids_arr = explode(" ", $add_children_ids);
			if (!in_array($post_ID, $add_children_ids_arr)) {
				$add_children_ids_arr[] = $post_ID;
				$_tutor_course_children = implode(" ", $add_children_ids_arr);
				update_post_meta($a_p, '_tutor_course_children', $_tutor_course_children);
			}
		}

		//courses children
		$course_children_old = trim($_POST['_tutor_course_children_old']);
		$course_children = trim($_POST['_tutor_course_children']);
		update_post_meta($post_ID, '_tutor_course_children', $course_children);
		$course_children_old_arr = explode(" ", $course_children_old);
		$course_children_arr = explode(" ", $course_children);
		$remove_children = array_diff($course_children_old_arr, $course_children_arr);
		$add_children = array_diff($course_children_arr, $course_children_old_arr);
		//var_dump($remove_children);die();
		foreach ((array) $remove_children as $r_c) {
			//remove this course as parent from remove child
			$remove_parent_ids = get_post_meta($r_c, '_tutor_course_parent', true);
			$remove_parent_ids_arr = explode(" ", $remove_parent_ids);
			$pos = array_search($post_ID, $remove_parent_ids_arr);
			if ($pos !== false) {
				unset($remove_parent_ids_arr[$pos]);
				$_tutor_course_parent = implode(" ", $remove_parent_ids_arr);
				update_post_meta($r_c, '_tutor_course_parent', $_tutor_course_parent);
			}
		}
		foreach ((array) $add_children as $a_c) {
			//add this coure as parent to add child
			$add_parent_ids = get_post_meta($a_c, '_tutor_course_parent', true);
			$add_parent_ids_arr = explode(" ", $add_parent_ids);
			if (!in_array($post_ID, $add_parent_ids_arr)) {
				$add_parent_ids_arr[] = $post_ID;
				$_tutor_course_parent = implode(" ", $add_parent_ids_arr);
				update_post_meta($a_c, '_tutor_course_parent', $_tutor_course_parent);
			}
		}
		// End Save Course relative

		/// BEGIN Update/Remove prerequisites course

		$course_chilren_prere = $_POST['_tutor_course_children'];

		$course_chilren_prere_arr = explode(" ", $course_chilren_prere);
		// Convert each element in the array to an integer
		$course_chilren_prere_arr = array_map('intval', $course_chilren_prere_arr);

		$prerequisites_course_ids = $course_chilren_prere_arr;

		// Remove prerequisites course
		$removed_children_courses = array_diff($course_children_old_arr, $course_children_arr);

		foreach ((array) $removed_children_courses as $rc) {
			//remove removed chilrends course from prerequisites courses of this course

			// if $rc contains in $prerequisites_course_ids, remove it
			$pos = array_search($rc, $prerequisites_course_ids);
			if ($pos !== false) {
				unset($prerequisites_course_ids[$pos]);
			}
		}


		update_post_meta($post_ID, '_tutor_course_prerequisites_ids', $prerequisites_course_ids);
		// update_prerequisites_ids_for_parents($post_ID, $prerequisites_course_ids);
		update_prerequisites_ids_for_parents($post_ID, $course_parent);

		// if $prerequisites_course_ids is empty, remove _tutor_course_prerequisites_ids meta
		// if $prerequisites_course_ids is equal: a:1:{i:0;i:0;}, remove _tutor_course_prerequisites_ids meta
		if (empty($prerequisites_course_ids) || (count($prerequisites_course_ids) == 1 && $prerequisites_course_ids[0] == 0)) {
			delete_post_meta($post_ID, '_tutor_course_prerequisites_ids');
		}
		if (empty($prerequisites_course_ids)) {
			delete_post_meta($post_ID, '_tutor_course_prerequisites_ids');
		}

		/// END Update/Remove prerequisites course



		// var_dump( $course_children_arr );
		// var_dump( $prerequisites_course_ids );
		// die();
	}

}
