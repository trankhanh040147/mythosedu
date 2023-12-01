<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<script type="text/template" id="tmpl-co-hotkeys">
	<# var ctrlLabel = environment.mac ? 'Cmd' : 'Ctrl'; #>
	<div id="co-hotkeys__content">
		<div id="co-hotkeys__actions" class="co-hotkeys__col">

			<div class="co-hotkeys__header">
				<h3><?php echo __( 'Actions', 'elementor' ); ?></h3>
			</div>
			<div class="co-hotkeys__list">
				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Undo', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>Z</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Redo', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>Shift</span>
						<span>Z</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Copy', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>C</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Paste', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>V</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Paste Style', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>Shift</span>
						<span>V</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Delete', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>Delete</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Duplicate', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>D</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Save', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>S</span>
					</div>
				</div>

			</div>
		</div>

		<div id="co-hotkeys__navigation" class="co-hotkeys__col">

			<div class="co-hotkeys__header">
				<h3><?php echo __( 'Go To', 'elementor' ); ?></h3>
			</div>
			<div class="co-hotkeys__list">
				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Finder', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>E</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Show / Hide Panel', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>P</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Responsive Mode', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>Shift</span>
						<span>M</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'History', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>Shift</span>
						<span>H</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Navigator', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>Shift</span>
						<span>I</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Template Library', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>Shift</span>
						<span>L</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Keyboard Shortcuts', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>{{{ ctrlLabel }}}</span>
						<span>?</span>
					</div>
				</div>

				<div class="co-hotkeys__item">
					<div class="co-hotkeys__item--label"><?php echo __( 'Quit', 'elementor' ); ?></div>
					<div class="co-hotkeys__item--shortcut">
						<span>Esc</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
