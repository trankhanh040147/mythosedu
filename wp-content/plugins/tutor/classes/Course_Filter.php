<?php
namespace TUTOR;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Course_Filter {
	private $category        = 'course-category';
	private $tag             = 'course-tag';
	private $current_term_id = null;

	function __construct() {
		add_action( 'wp_ajax_tutor_course_filter_ajax', array( $this, 'load_listing' ) );
		add_action( 'wp_ajax_nopriv_tutor_course_filter_ajax', array( $this, 'load_listing' ) );
	}

	public function load_listing() {
		tutils()->checking_nonce();
		$_post = tutor_sanitize_data( $_POST );

		$default_per_page = tutils()->get_option( 'courses_per_page', 12 );
		$courses_per_page = (int) tutils()->array_get( 'course_per_page', $_post, $default_per_page );

		$page             = ( isset( $_post['page'] ) && is_numeric( $_post['page'] ) && $_post['page'] > 0 ) ? sanitize_text_field( $_post['page'] ) : 1;
		$args = array(
			'post_status'    => array('publish'),
			'post_type'      => 'courses',
			/* 'meta_query' =>  [
									'relation' => 'OR',
									[
									  'key' => '_tutor_course_parent',
									  'compare' => 'NOT EXISTS',
									],
									[
									  'key' => '_tutor_course_parent',
									  'compare' => '=',
									  'value' => ''
									]
								 ], *///NhatHuy: explore course - display only parent course
			//'post_parent' 	 => 0,			
			'posts_per_page' => $courses_per_page,
			'paged'          => $page,
			'tax_query'      => array(
				'relation' => 'OR',
			),
		);

		// Prepare taxonomy
		foreach ( array( 'category', 'tag' ) as $taxonomy ) {

			$term_array                             = tutils()->array_get( 'tutor-course-filter-' . $taxonomy, $_post, array() );
			! is_array( $term_array ) ? $term_array = array( $term_array ) : 0;

			$term_array = array_filter(
				$term_array,
				function( $term_id ) {
					return is_numeric( $term_id );
				}
			);

			if ( count( $term_array ) > 0 ) {
				$tax_query = array(
					'taxonomy' => $this->$taxonomy,
					'field'    => 'term_id',
					'terms'    => $term_array,
					'operator' => 'IN',
				);
				array_push( $args['tax_query'], $tax_query );
			}
		}

		// Prepare level and price type
		$is_membership = get_tutor_option( 'monetize_by' ) == 'pmpro' && tutils()->has_pmpro();
		$level_price   = array();
		foreach ( array( 'level', 'price' ) as $type ) {

			if ( $is_membership && 'price' === $type ) {
				continue;
			}

			$type_array = tutils()->array_get( 'tutor-course-filter-' . $type, $_post, array() );
			$type_array = array_map( 'sanitize_text_field', ( is_array( $type_array ) ? $type_array : array( $type_array ) ) );

			if ( count( $type_array ) > 0 ) {
				$level_price[] = array(
					'key'     => 'level' === $type ? '_tutor_course_level' : '_tutor_course_price_type',
					'value'   => $type_array,
					'compare' => 'IN',
				);
			}
		}
		//NhatHuy: explore courses: get parent courses only
		
		$level_price[] = array(
								'relation' => 'OR',
								array(
									'key' => '_tutor_course_parent',
									'compare' => 'NOT EXISTS',
								),
								array(
									'key' => '_tutor_course_parent',
									'compare' => '=',
									'value' => '',
								),
							);
							
		$user_id = get_current_user_id();
		$vus_member = nl2br( strip_tags( get_user_meta( $user_id, '_tutor_vus_member', true ) ) );
		$vus_member	= $vus_member ? $vus_member : 'Internal';
		/* if($vus_member=='Internal'){
			$level_price[] = array(
								'relation' => 'OR',
								array(
									'key'     => '_tutor_course_type',
									'value'   =>  '"forinternal"',
									'compare' => 'LIKE',
								),
								array(
									'key'     => '_tutor_course_type',
									'value'   =>  '"forexternal";s:19:"internal_pay_ot_not";s:2:"on"',
									'compare' => 'LIKE',
								),
							);
		} */
		
		//for external member, just get external courses
		if($vus_member=='External'){
			$level_price[] = array(
								'key'     => '_tutor_course_type',
								'value'   =>  '"forexternal"',
								'compare' => 'LIKE',
							);
		}
		//		
		count( $level_price ) ? $args['meta_query'] = $level_price : 0;
		
		
		$search_key              = sanitize_text_field( tutils()->array_get( 'keyword', $_post, null ) );
		$search_key ? $args['search_filter'] = $search_key : 0;
		$args['not_draft_search'] = 'Auto Draft';
		if ( isset( $_post['tutor_course_filter'] ) ) {
			switch ( $_post['tutor_course_filter'] ) {
				case 'newest_first':
					$args['orderby'] = 'ID';
					$args['order']   = 'desc';
					break;
				case 'oldest_first':
					$args['orderby'] = 'ID';
					$args['order']   = 'asc';
					break;
				case 'course_title_az':
					$args['orderby'] = 'post_title';
					$args['order']   = 'asc';
					break;
				case 'course_title_za':
					$args['orderby'] = 'post_title';
					$args['order']   = 'desc';
					break;
			}
		}

		query_posts( apply_filters( 'tutor_course_filter_args', $args ) );
		$col_per_row                    = (int) tutils()->array_get( 'column_per_row', $_post, 3 );
		$GLOBALS['tutor_shortcode_arg'] = array(
			'column_per_row'  => $col_per_row <= 0 ? 3 : $col_per_row,
			'course_per_page' => $courses_per_page,
			'shortcode_enabled' => isset($_post['page_shortcode'])?true:false,
		);

		tutor_load_template( 'archive-course-init' );
		exit;
	}

	private function get_current_term_id() {

		if ( $this->current_term_id === null ) {
			$queried               = get_queried_object();
			$this->current_term_id = ( is_object( $queried ) && property_exists( $queried, 'term_id' ) ) ? $queried->term_id : false;
		}

		return $this->current_term_id;
	}

	private function sort_terms_hierarchically( $terms, $parent_id = 0 ) {
		$term_array = array();

		foreach ( $terms as $term ) {
			if ( $term->parent == $parent_id ) {
				$term->children = $this->sort_terms_hierarchically( $terms, $term->term_id );
				$term_array[]   = $term;
			}
		}

		return $term_array;
	}

	private function render_terms_hierarchically( $terms, $taxonomy ) {

		$term_id = $this->get_current_term_id();

		foreach($terms as $term){
            ?>
                <div class="tutor-form-check tutor-mb-20">

                <input type="checkbox" class="tutor-form-check-input" data_cat_name="<?php _e($term->name, TPL_DOMAIN_LANG); ?>" id="<?php echo $term->term_id; ?>"  name="tutor-course-filter-<?php echo $taxonomy; ?>" value="<?php echo $term->term_id; ?>" <?php echo $term->term_id==$term_id ? 'checked="checked"' : ''; ?>/>&nbsp;

                    <label for="<?php echo $term->term_id; ?>">
                        <?php _e($term->name, TPL_DOMAIN_LANG); ?>
                    </label>
                </div>
                <?php isset($term->children) ? $this->render_terms_hierarchically($term->children, $taxonomy) : 0; ?>
            <?php
        }
	}

	public function render_terms( $taxonomy ) {
		$terms = get_terms(
			array(
				'taxonomy'   => $this->$taxonomy,
				'hide_empty' => true,
			)
		);
		$this->render_terms_hierarchically( $this->sort_terms_hierarchically( $terms ), $taxonomy );
	}
}
