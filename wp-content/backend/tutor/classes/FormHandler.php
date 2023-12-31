<?php
/**
 * Manage Form
 *
 * @package Tutor
 * @author Themeum <support@themeum.com>
 * @link https://themeum.com
 * @since 1.4.3
 */

namespace TUTOR;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * FormHandler class
 *
 * @since 1.4.3
 */
class FormHandler {

	/**
	 * Constructor
	 *
	 * @since 1.4.3
	 * @return void
	 */
	public function __construct() {
		add_action( 'tutor_action_tutor_retrieve_password', array( $this, 'tutor_retrieve_password' ) );
		add_action( 'tutor_action_tutor_process_reset_password', array( $this, 'tutor_process_reset_password' ) );

		add_action( 'tutor_reset_password_notification', array( $this, 'reset_password_notification' ), 10, 2 );
		add_filter( 'tutor_lostpassword_url', array( $this, 'lostpassword_url' ) );
	}

	/**
	 * Retrieve Password
	 *
	 * @since 1.4.3
	 * @return void|bool
	 */
	public function tutor_retrieve_password() {
		tutils()->checking_nonce();

		/**
		 * To check spam or other logic before form process.
		 *
		 * @since 2.1.10
		 */
		$before_form_process = apply_filters( 'tutor_before_retrieve_password_form_process', null );
		if ( is_wp_error( $before_form_process ) ) {
			tutor_flash_set( 'danger', $before_form_process->get_error_message() );
			return false;
		}

		//phpcs:ignore WordPress.Security.NonceVerification.Missing
		$login = sanitize_user( tutils()->array_get( 'user_login', $_POST ) );

		if ( empty( $login ) ) {
			tutor_flash_set( 'danger', __( 'Enter a username or email address.', 'tutor' ) );
			return false;
		} else {
			// Check on username first, as customers can use emails as usernames.
			$user_data = get_user_by( 'login', $login );
		}

		// If no user found, check if it login is email and lookup user based on email.
		if ( ! $user_data && is_email( $login ) && apply_filters( 'tutor_get_username_from_email', true ) ) {
			$user_data = get_user_by( 'email', $login );
		}

		$errors = new \WP_Error();

		do_action( 'lostpassword_post', $errors );

		if ( $errors->get_error_code() ) {
			tutor_flash_set( 'danger', $errors->get_error_message() );
			return false;
		}

		if ( ! $user_data ) {
			tutor_flash_set( 'danger', __( 'Invalid username or email.', 'tutor' ) );
			return false;
		}

		if ( is_multisite() && ! is_user_member_of_blog( $user_data->ID, get_current_blog_id() ) ) {
			tutor_flash_set( 'danger', __( 'Invalid username or email.', 'tutor' ) );
			return false;
		}

		// Redefining user_login ensures we return the right case in the email.
		$user_login = $user_data->user_login;

		do_action( 'retrieve_password', $user_login );

		$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

		if ( ! $allow ) {
			tutor_flash_set( 'danger', __( 'Password reset is not allowed for this user', 'tutor' ) );
			return false;
		} elseif ( is_wp_error( $allow ) ) {
			tutor_flash_set( 'danger', $allow->get_error_message() );
			return false;
		}

		// Get password reset key (function introduced in WordPress 4.4).
		$key = get_password_reset_key( $user_data );

		// Send email notification.
		do_action( 'tutor_reset_password_notification', $user_login, $key );
	}

	/**
	 * Send notification for rest password
	 *
	 * @since 1.4.3
	 *
	 * @param string $user_login username.
	 * @param string $reset_key reset key.
	 *
	 * @return void
	 */
	public function reset_password_notification( $user_login = '', $reset_key = '' ) {
		$this->send_notification( $user_login, $reset_key );

		$html  = '<h3>' . __( 'Check your E-Mail', 'tutor' ) . '</h3>';
		$html .= '<p> ' . __( "We've sent an email to this account's email address. Click the link in the email to reset your password.", 'tutor' ) . '</p>';
		$html .= '<p>' . __( " If you don't see the email, check other places it might be, like your junk, spam, social, promotion or others folders.", 'tutor' ) . '</p>';
		tutor_flash_set( 'success', $html );
	}

	/**
	 * Get lost password URL
	 *
	 * @since 1.4.3
	 *
	 * @param string $url URL.
	 * @return string
	 */
	public function lostpassword_url( $url ) {
		return tutils()->tutor_dashboard_url( 'retrieve-password' );
	}

	/**
	 * Handle reset password request
	 *
	 * @since 1.4.3
	 * @return void|bool
	 */
	public function tutor_process_reset_password() {
		tutils()->checking_nonce();

		$reset_key        = Input::post( 'reset_key' );
		$user_id          = Input::post( 'user_id', 0, Input::TYPE_INT );
		$password         = Input::post( 'password' );
		$confirm_password = Input::post( 'confirm_password' );

		$user = get_user_by( 'ID', $user_id );
		$user = check_password_reset_key( $reset_key, $user->user_login );

		if ( is_wp_error( $user ) ) {
			tutor_flash_set( 'danger', __( 'This key is invalid or has already been used. Please reset your password again if needed.', 'tutor' ) );
			return false;
		}

		if ( $user instanceof \WP_User ) {
			if ( ! $password ) {
				tutor_flash_set( 'danger', __( 'Please enter your password.', 'tutor' ) );
				return false;
			}

			if ( $password !== $confirm_password ) {
				tutor_flash_set( 'danger', __( 'Passwords do not match.', 'tutor' ) );
				return false;
			}

			tutils()->reset_password( $user, $password );

			do_action( 'tutor_user_reset_password', $user );

			// Perform the login.
			$creds = array(
				'user_login'    => $user->user_login,
				'user_password' => $password,
				'remember'      => true,
			);
			$user  = wp_signon( apply_filters( 'tutor_login_credentials', $creds ), is_ssl() );

			do_action( 'tutor_user_reset_password_login', $user );

			wp_safe_redirect( tutor_utils()->tutor_dashboard_url() );
			exit;
		}
	}

	/**
	 * Send Password Reset E-Mail to user.
	 * We are sending directly right now, later we will introduce centralised E-Mail notification System...
	 *
	 * @since 1.4.3
	 *
	 * @param string $user_login login username.
	 * @param string $reset_key password reset key.
	 *
	 * @return void
	 */
	public function send_notification( $user_login, $reset_key ) {

		$user_data = get_user_by( 'login', $user_login );

		$variable = array(
			'user_login' => $user_login,
			'reset_key'  => $reset_key,
			'user_id'    => $user_data->ID,
		);

		$html = tutor_get_template_html( 'email.send-reset-password', $variable );
		/* translators: %s: site name */
		$subject = sprintf( __( 'Password Reset Request for %s', 'tutor' ), get_option( 'blogname' ) );

		$header = 'Content-Type: text/html' . "\r\n";

		add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );

		wp_mail( $user_data->user_email, $subject, $html, $header );

		remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
	}

	/**
	 * Get e-mail from address
	 *
	 * @since 1.4.3
	 * @return string
	 */
	public function get_from_address() {
		$from_address = get_tutor_option( 'email_from_address' );
		$default      = ! $from_address ? get_option( 'admin_email' ) : $from_address;
		return apply_filters( 'tutor_email_from_address', $default );
	}

	/**
	 * Get e-mail from name
	 *
	 * @since 1.4.3
	 * @return string
	 */
	public function get_from_name() {
		$from_name = get_tutor_option( 'email_from_name' );
		$default   = ! $from_name ? get_option( 'blogname' ) : $from_name;
		return apply_filters( 'tutor_email_from_name', $default );
	}

}
