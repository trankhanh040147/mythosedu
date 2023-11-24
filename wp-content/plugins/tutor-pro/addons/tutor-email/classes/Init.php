<?php
/**
 * E-mail addon init.
 *
 * @package TutorPro\Addon
 * @subpackage Email
 *
 * @since 2.0.0
 */

namespace TUTOR_EMAIL;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Init
 *
 * @since 2.0.0
 */
class Init {
	/**
	 * Version of the addon.
	 *
	 * @var string
	 */
	public $version = TUTOR_EMAIL_VERSION;

	/**
	 * Addon path.
	 *
	 * @var string
	 */
	public $path;

	/**
	 * Url
	 *
	 * @var string
	 */
	public $url;

	/**
	 * Basename
	 *
	 * @var string
	 */
	public $basename;

	/**
	 * Email notification
	 *
	 * @var mixed
	 */
	private $email_notification;

	/**
	 * Addon enable check and register hooks.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		if ( ! function_exists( 'tutor' ) ) {
			return;
		}

		$addon_config = tutor_utils()->get_addon_config( TUTOR_EMAIL()->basename );
		$is_enable    = (bool) tutor_utils()->avalue_dot( 'is_enable', $addon_config );
		if ( ! $is_enable ) {
			return;
		}

		$this->path     = plugin_dir_path( TUTOR_EMAIL_FILE );
		$this->url      = plugin_dir_url( TUTOR_EMAIL_FILE );
		$this->basename = plugin_basename( TUTOR_EMAIL_FILE );

		$this->load_tutor_email();
		add_action( 'admin_init', array( $this, 'tutor_image_size_register' ) );
		add_filter( 'tutor_email_bg', array( $this, 'add_email_bg' ) );
	}

	/**
	 * Add email background image.
	 *
	 * @since 2.2.4
	 *
	 * @param string $default_image default image url.
	 *
	 * @return string
	 */
	public function add_email_bg( $default_image ) {
		if ( tutor_utils()->get_option( 'email_disable_banner' ) ) {
			return '';
		}

		$image_id = (int) tutor_utils()->get_option( 'email_template_bg' );
		if ( $image_id ) {
			return wp_get_attachment_image_url( $image_id, 'full' );
		}
		return $default_image;
	}

	/**
	 * Register email logo size
	 *
	 * @return void
	 */
	public function tutor_image_size_register() {
		add_image_size( 'tutor-email-logo-size', 220, 50 );
	}

	/**
	 * Load tutor email
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function load_tutor_email() {
		/**
		 * Loading Autoloader
		 */
		spl_autoload_register( array( $this, 'loader' ) );
		$this->email_notification = new EmailNotification();

		add_filter( 'tutor/options/attr', array( $this, 'add_options' ), 10 ); // Priority index is important. 'Content Drip' add-on uses 11.
	}

	/**
	 * Auto Load class and the files
	 *
	 * @since 2.0.0
	 *
	 * @param string $class_name class name.
	 *
	 * @return void
	 */
	private function loader( $class_name ) {
		if ( ! class_exists( $class_name ) ) {
			$class_name = preg_replace(
				array( '/([a-z])([A-Z])/', '/\\\/' ),
				array( '$1$2', DIRECTORY_SEPARATOR ),
				$class_name
			);

			$class_name = str_replace( 'TUTOR_EMAIL' . DIRECTORY_SEPARATOR, 'classes' . DIRECTORY_SEPARATOR, $class_name );
			$file_name  = $this->path . $class_name . '.php';

			if ( file_exists( $file_name ) && is_readable( $file_name ) ) {
				require_once $file_name;
			}
		}
	}


	/**
	 * Run
	 *
	 * @return void
	 */
	public function run() {
		register_activation_hook( TUTOR_EMAIL_FILE, array( $this, 'tutor_activate' ) );
	}

	/**
	 * Do some task during plugin activation
	 */
	public function tutor_activate() {
		$version = get_option( 'TUTOR_EMAIL_version' );
		// Save Option.
		if ( ! $version ) {
			update_option( 'TUTOR_EMAIL_version', TUTOR_EMAIL_VERSION );
		}
	}

	/**
	 * Get recipients
	 *
	 * @param mixed $key key.
	 *
	 * @return array
	 */
	private function get_recipient_array( $key = null ) {
		$recipients = ( new EmailData() )->get_recipients();

		if ( null === $key ) {
			$new_array = array();
			foreach ( $recipients as $recipient ) {
				$new_array = array_merge( $new_array, $recipient );
			}

			return $new_array;
		}

		$admin_url = admin_url( 'admin.php' );
		$array     = $recipients[ $key ];
		$fields    = array();

		foreach ( $recipients[ $key ] as $event => $mail ) {
			$tooltip        = ( isset( $mail['tooltip'] ) && ! empty( $mail['tooltip'] ) ) ? $mail['tooltip'] : null;
			$email_edit_url = add_query_arg(
				array(
					'page'     => 'tutor_settings',
					'tab_page' => 'email_notification',
					'edit'     => $event,
					'to'       => $key,
				),
				$admin_url
			);

			$fields[] = array(
				'key'      => $key,
				'event'    => $event,
				'type'     => 'toggle_switch_button',
				'label'    => $mail['label'],
				'template' => $mail['template'],
				'tooltip'  => $tooltip,
				'default'  => isset( $mail['default'] ) ? esc_attr( $mail['default'] ) : esc_attr( 'off' ),
				'buttons'  => array(
					'edit' => array(
						'type' => 'anchor',
						'text' => __( 'Edit', 'tutor-pro' ),
						'url'  => $email_edit_url,
					),
				),
			);
		}

		return $fields;
	}

	/**
	 * Email option and types
	 *
	 * @since 2.0.0
	 *
	 * @param  mixed $attr attributes.
	 *
	 * @return array
	 */
	public function add_options( $attr ) {

		$template_path = isset( $_GET['edit'] ) ? TUTOR_EMAIL()->path . '/views/pages/email-edit.php' : null;

		//phpcs:disable
		$template_data = ! isset( $_GET['edit'] ) ? null : array(
			'to'          => sanitize_text_field( $_GET['to'] ),
			'key'         => sanitize_text_field( $_GET['edit'] ),
			'to_readable' => ucwords( str_replace( '_', ' ', $_GET['to'] ) ),
			'mail'        => $this->get_recipient_array()[ sanitize_text_field( $_GET['edit'] ) ],
		);
		//phpcs:enable

		$attr['email_notification'] = array(
			'label'           => __( 'Email', 'tutor-pro' ),
			'slug'            => 'email_notification',
			'desc'            => __( 'Email Settings', 'tutor-pro' ),
			'template'        => 'basic',
			'icon'            => 'tutor-icon-envelope',
			'template_path'   => $template_path,
			'edit_email_data' => $template_data,
			'blocks'          => array(
				array(
					'label'      => __( 'Email Meta', 'tutor-pro' ),
					'slug'       => 'email_meta',
					'block_type' => 'uniform',
					'fields'     => array(
						array(
							'key'   => 'tutor_email_template_logo_id',
							'type'  => 'upload_full',
							'label' => __( 'Email Template Logo', 'tutor-pro' ),
							'desc'  => array(
								'file_size'    => __( '100x36 pixels, Max height: 50px;', 'tutor-pro' ),
								'file_support' => __( 'jpg, .jpeg or .png.', 'tutor-pro' ),
							),
						),
						array(
							'key'     => 'email_logo_height',
							'type'    => 'number',
							'label'   => __( 'Email Logo Height', 'tutor-pro' ),
							'default' => 30,
							'desc'    => __( 'Set the height of your email logo in pixels', 'tutor-pro' ),
						),
						array(
							'key'     => 'email_disable_banner',
							'type'    => 'toggle_switch',
							'label'   => __( 'Disable Email Banner', 'tutor-pro' ),
							'default' => 'off',
							'desc'    => __( 'Enable to hide email banner', 'tutor-pro' ),
						),
						array(
							'key'   => 'email_template_bg',
							'type'  => 'upload_full',
							'label' => __( 'Email Template Background', 'tutor-pro' ),
							'desc'  => array(
								'file_size'    => __( '602x124 pixels', 'tutor-pro' ),
								'file_support' => __( 'jpg, png.', 'tutor-pro' ),
							),
						),
						array(
							'key'         => 'email_from_name',
							'type'        => 'text',
							'label'       => __( 'Name', 'tutor-pro' ),
							'placeholder' => __( 'Sender\'s Name', 'tutor-pro' ),
							'default'     => get_option( 'blogname' ),
							'desc'        => __( 'The name under which all the emails will be sent', 'tutor-pro' ),
						),
						array(
							'key'         => 'email_from_address',
							'type'        => 'email',
							'label'       => __( 'E-Mail Address', 'tutor-pro' ),
							'placeholder' => __( 'Reply to E-Mail', 'tutor-pro' ),
							'default'     => wp_get_current_user()->user_email,
							'desc'        => __( 'The E-Mail address from which all emails will be sent', 'tutor-pro' ),
						),
						array(
							'key'         => 'email_footer_text',
							'type'        => 'editor_full',
							'label'       => __( 'E-Mail Footer Text', 'tutor-pro' ),
							'placeholder' => __( 'Footer text for E-mail', 'tutor-pro' ),
							'default'     => '<p style="text-align:center;color:#757C8E;">{site_name} © ' . __( '2022 All Rights Reserved', 'tutor-pro' ) . '.</p>
							<p style="text-align:center;color:#41454F;padding-bottom:30px;"><a style="text-decoration: none;color: inherit;" href="#">' . __( 'Privacy & Policy', 'tutor-pro' ) . '</a> <span>⋅</span> <a style="text-decoration: none;color: inherit;" href="#">' . __( 'Terms & Conditions', 'tutor-pro' ) . '</a></p>',
							'desc'        => __( 'The text to appear in E-Mail template footer', 'tutor-pro' ),
						),
					),
				),
				array(
					'label'      => __( 'Email to Students', 'tutor-pro' ),
					'slug'       => 'email_to_students',
					'block_type' => 'uniform',
					'fields'     => $this->get_recipient_array( 'email_to_students' ),
				),
				array(
					'label'      => __( 'Email to Teachers', 'tutor-pro' ),
					'slug'       => 'email_to_teachers',
					'block_type' => 'uniform',
					'fields'     => $this->get_recipient_array( 'email_to_teachers' ),
				),
				array(
					'label'      => __( 'Email to Admin', 'tutor-pro' ),
					'slug'       => 'email_to_admin',
					'block_type' => 'uniform',
					'fields'     => $this->get_recipient_array( 'email_to_admin' ),
				),
				array(
					'label'      => __( 'Email Sending', 'tutor-pro' ),
					'slug'       => 'email_sending',
					'block_type' => 'uniform',
					'fields'     => array(
						array(
							'key'     => 'tutor_email_disable_wpcron',
							'label'   => __( 'WP Cron for Bulk Mailing', 'tutor-pro' ),
							'type'    => 'toggle_switch',
							'default' => 'off',
							'desc'    => __( 'Enable this option to let Tutor LMS use WordPress native scheduler for email sending activities', 'tutor-pro' ),
						),
						array(
							'key'     => 'tutor_email_cron_frequency',
							'label'   => __( 'WP Email Cron Frequency', 'tutor-pro' ),
							'type'    => 'number',
							'default' => '300',
							'desc'    => __( 'Add the frequency mode in <strong>Second(s)</strong> which the Cron Setup will run', 'tutor-pro' ),
						),
						array(
							'key'         => 'tutor_bulk_email_limit',
							'label'       => __( 'Email Per Cron Execution', 'tutor-pro' ),
							'type'        => 'number',
							'number_type' => 'integer',
							'default'     => '10',
							'desc'        => __( 'Number of emails you\'d like to send per cron execution', 'tutor-pro' ),
						),
					),
				),
			),
		);

		return $attr;
	}
}
