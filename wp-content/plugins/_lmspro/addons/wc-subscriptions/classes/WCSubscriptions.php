<?php
/**
 * WooCommerce Subscription class
 *
 * @author: themeum
 * @author_uri: https://themeum.com
 * @package Tutor
 * @since v.1.3.5
 */

namespace TUTOR_WCS;
use \TUTOR_ENROLLMENTS\Enrollments_List;

if ( ! defined( 'ABSPATH' ) )
	exit;

class WCSubscriptions {

	public function __construct() {
		add_filter('tutor_is_enrolled', array($this, 'tutor_is_enrolled'), 10, 3);

		/**
		 * Cancel enrolment if Woocommerce subscription is not active
		 *
		 * @since v2.0.3
		 */
		add_action( 'woocommerce_subscription_status_updated', array( $this, 'update_enrollment_status' ), 10, 3 );
	}

	public function tutor_is_enrolled($getEnrolledInfo, $course_id, $user_id ) {
		$product_id = tutor_utils()->get_course_product_id($course_id);
		if ($product_id) {
			$product = wc_get_product( $product_id );
			$type = is_object( $product ) && isset( $product->get_type ) ? $product->get_type() : null;

			if ($type === 'subscription' || $type === 'variable-subscription' ){
				$subscriptions = $this->get_users_subscription( $user_id );
				$has_active_subscription = false;
				foreach ( $subscriptions as $subscription_id => $subscription ) {
					if ($subscription->has_product($product_id)){
						$has_active_subscription = true;
					}
				}
				if ($has_active_subscription){
					return $getEnrolledInfo;
				}else{
					return false;
				}
			}
		}

		return $getEnrolledInfo;
	}
	public function get_users_subscription( $user_id = 0 ) {
		$user_id = tutor_utils()->get_user_id($user_id);

		$query = new \WP_Query();
		$subscription_ids = $query->query( array(
			'post_type'           => 'shop_subscription',
			'posts_per_page'      => -1,
			'post_status'         => 'wc-active',
			'orderby'             => array(
				'date' => 'DESC',
				'ID'   => 'DESC',
			),
			'fields'              => 'ids',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
			'meta_query'          => array(
				array(
					'key'   => '_customer_user',
					'value' => $user_id,
				),
			),
		) );

		$subscriptions = array();
		foreach ( $subscription_ids as $subscription_id ) {
			$subscription = wcs_get_subscription( $subscription_id );

			if ( $subscription ) {
				$subscriptions[ $subscription_id ] = $subscription;
			}
		}
		return $subscriptions;
	}

	/**
	 * Update enrollment status based on Woocommerce subscription status
	 *
	 * @param WC_Subscription $wc_subscription
	 * @param string $new_status
	 * @param string $old_status
	 *
	 * @return void
	 */
	public function update_enrollment_status( \WC_Subscription $wc_subscription, string $new_status, string $old_status ): void {
		
		$order_id = method_exists( $wc_subscription, 'get_parent_id' ) ? $wc_subscription->get_parent_id() : $wc_subscription->order->id;
		if ( $order_id && tutor_utils()->is_tutor_order( $order_id ) ) {
			$enrollment_status = 'active' === $new_status ? 'completed' : 'cancel' ;
			$enrollments = tutor_utils()->get_course_enrolled_ids_by_order_id( $order_id );
			if ( is_array( $enrollments ) && count( $enrollments ) ) {
				$ids = array();
				foreach ( $enrollments as $enrollment ) {
					array_push( $ids, $enrollment['enrolled_id'] );
				}
				if ( count( $ids ) ) {
					tutor_utils()->update_enrollments( $enrollment_status, $ids );
				}
			}
		}
	}

}