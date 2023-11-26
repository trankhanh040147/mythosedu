<?php 

namespace Tutor\Certificate\Builder;

class Utils {
	public function get_certificates($author_id=null, $status='publish') {
		global $wpdb;

		$args = array(
			'posts_per_page' => -1,
			'post_type' => Plugin::CERTIFICATE_POST_TYPE,
			'post_status' => $status
		);

		// Assign conditionals
		$author_id ? $args['author']=$author_id : 0;
		
		// Get certificates
		$certificates = get_posts($args);
		$certificates = is_array($certificates) ? $certificates : array();

		// Assign editional data
		$url_base = trailingslashit( wp_upload_dir()['baseurl'] ) . Plugin::CERTIFICATE_TEMPLATE_DIR . '/';
		foreach($certificates as $index=>$certificate) {
			// Assign thumbnail URL
			$_name = get_post_meta( $certificate->ID, Plugin::CERTIFICATE_PREVIEW_META_KEY, true );
			$url = $_name ? $url_base . $_name : '';
			$certificates[$index]->thumbnail_url = $url;

			// Assign edit URL
			$certificates[$index]->edit_url = Helper::certificate_builder_url($certificate->ID);

			// Assign delete url
			$args = array(
				'action' => 'tutor_delete_certificate_template',
				'certificate_id' => $certificate->ID
			);
			$certificates[$index]->delete_url = add_query_arg( $args, admin_url( 'admin-ajax.php' ) );
		}

		return $certificates;
	}
}