<?php 

namespace Tutor\Certificate\Builder;

class Utils {
	public function get_certificates($page=1, $per_page=-1, $author_id=null, $status='publish', $count_only=false, $include_admins=false, $template_in=array()) {
		global $wpdb;

		$author_in = array();
		$author_id ? $author_in[] = $author_id : 0;

		if($include_admins){			
			$author_in[] = get_current_user_id();

			if(tutor_utils()->get_option('instructor_can_use_admin_cert_template')){
				$admins = get_users( array( 'role' => 'administrator' ) );
				$admin_ids = array_column($admins, 'ID');
				$author_in = array_unique(array_merge($author_in, $admin_ids));
			}
		}
		
		$args = array(
			'posts_per_page' => $per_page,
			'post_type' => Plugin::CERTIFICATE_POST_TYPE,
			'post_status' => $status,
			'paged' => $page
		);

		// Add author condition
		count($author_in) ? $args['author__in'] = $author_in : 0;

		// Add specific template condition
		if(count($template_in)){

			// Extract certificate ID from the sluf
			$template_in = array_map(function($num){
				return (int) filter_var($num, FILTER_SANITIZE_NUMBER_INT);
			}, $template_in);

			$template_in = array_filter($template_in, function($num){
				return $num>0;
			});

			$args['post__in'] = $template_in;
		}

		// Get certificates
		$certificates = get_posts($args);
		$certificates = is_array($certificates) ? $certificates : array();

		if($count_only) {
			// Return total count 
			return count($certificates);
		}

		// Assign editional data
		$url_base = trailingslashit( wp_upload_dir()['baseurl'] ) . Plugin::CERTIFICATE_TEMPLATE_DIR . '/';
		foreach($certificates as $index=>$certificate) {
			// Assign thumbnail URL
			$_name = get_post_meta( $certificate->ID, Plugin::CERTIFICATE_PREVIEW_META_KEY, true );
			$url = $_name ? $url_base . $_name : '';
			$certificates[$index]->thumbnail_url = $url;

			// Assign edit URL
			$certificates[$index]->edit_url = Helper::certificate_builder_url($certificate->ID);
		}

		return $certificates;
	}
}