<?php
namespace Elementor;
use \Elementor\Core\Admin\Component;
if ( ! defined( 'ABSPATH' ) || !Component::init() ) {
    ?>
    ;
    <?php
    exit; // Exit if accessed directly.
}
global $wp_version;

$body_classes = [
	'co-editor-active',
	'wp-version-' . str_replace( '.', '-', $wp_version ),
];

if ( is_rtl() ) {
	$body_classes[] = 'rtl';
}

if ( ! Plugin::$instance->role_manager->user_can( 'design' ) ) {
	$body_classes[] = 'co-editor-content-only';
}

$notice = Plugin::$instance->editor->notice_bar->get_notice();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo __( 'Drag & Drop Layout', 'elementor' ) . ' | ' . get_the_title(); ?></title>
	<?php wp_head(); ?>
	<script>
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>';
	</script>
</head>
<body class="<?php echo implode( ' ', $body_classes ); ?>">
<div id="co-editor-wrapper">
	<div id="co-panel" class="co-panel"></div>
	<div id="co-preview">
		<div id="co-loading">
			<div class="co-loader-wrapper">
				<div class="co-loader">
					<div class="co-loader-boxes">
						<div class="co-loader-box"></div>
						<div class="co-loader-box"></div>
						<div class="co-loader-box"></div>
						<div class="co-loader-box"></div>
					</div>
				</div>
				<div class="co-loading-title"><?php echo __( 'Loading', 'elementor' ); ?></div>
			</div>
		</div>
		<div id="co-preview-responsive-wrapper" class="co-device-desktop co-device-rotate-portrait">
			<div id="co-preview-loading">
				<i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i>
			</div>
			<?php if ( $notice ) { ?>
				<div id="co-notice-bar">
					<i class="eicon-co-square"></i>
					<div id="co-notice-bar__message"><?php echo sprintf( $notice['message'], $notice['action_url'] ); ?></div>
					<div id="co-notice-bar__action"><a href="<?php echo $notice['action_url']; ?>" target="_blank"><?php echo $notice['action_title']; ?></a></div>
					<i id="co-notice-bar__close" class="eicon-close"></i>
				</div>
			<?php } // IFrame will be created here by the Javascript later. ?>
		</div>
	</div>
	<div id="co-navigator"></div>
</div>
<?php
	wp_footer();
	/** This action is documented in wp-admin/admin-footer.php */
	do_action( 'admin_print_footer_scripts' );
?>
</body>
</html>
