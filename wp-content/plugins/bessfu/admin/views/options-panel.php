<?php
/*
The settings page
*/

function bessfu_scripts_styles($hook)
{
	global $bessfu_settings_page_hook;
	if ($bessfu_settings_page_hook != $hook)
		return;
    wp_enqueue_style( BESSFU_NAME . 'options_panel_stylesheet' . '-options-panel', BESSFU_MODULE_URL . '/admin/assets/css/options-panel.css', array(), BESSFU_VERSION, 'all' );
    wp_enqueue_script( BESSFU_NAME . '_options_panel_script', BESSFU_MODULE_URL . '/admin/assets/js/options-panel.js', array( 'jquery' ), BESSFU_VERSION, true );
	wp_enqueue_script('common');
	wp_enqueue_script('wp-lists');
	wp_enqueue_script('postbox');
}

add_action('admin_enqueue_scripts', 'bessfu_scripts_styles');

function bessfu_render_settings_page()
{
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<h2><?php _e('Site settings', BESSFU_LANG_DOMAIN); ?></h2>
		<?php settings_errors(); ?>
		<div class="clearfix paddingtop20">
			<div class="first twelvecol">
				<form method="post" action="options.php">
					<?php settings_fields('bessfu_settings'); ?>
					<?php do_meta_boxes('bessfu_metaboxes', 'advanced', null); ?>
					<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false); ?>
					<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false); ?>
				</form>
			</div>
		</div>
	</div>
<?php }

function bessfu_create_options()
{
	add_settings_section('bessfu_configuration_section', null, null, 'bessfu_settings');
	#add_settings_section('bessfu_role_section', null, null, 'bessfu_settings');
	#add_settings_section('bessfu_misc_section', null, null, 'bessfu_settings');

	add_settings_field(
		'site_phone_number_marketing', '', 'bessfu_render_settings_field', 'bessfu_settings', 'bessfu_configuration_section',
		array(
			'title' => __('Phone number marketing', BESSFU_LANG_DOMAIN),
			'id'    => 'site_phone_number_marketing',
			'type'  => 'text',
			'items' => array(
				'site_phone_number_marketing' => __('Phone number marketing', BESSFU_LANG_DOMAIN),
			),
			'group' => 'bessfu_configuration_section'
		)
    );
    add_settings_field(
        'site_phone_number_services', '', 'bessfu_render_settings_field', 'bessfu_settings', 'bessfu_configuration_section',
        array(
            'title' => __('Phone number services', BESSFU_LANG_DOMAIN),
            'id'    => 'site_phone_number_services',
            'type'  => 'text',
            'items' => array(
                'site_phone_number_services' => __('Phone number services', BESSFU_LANG_DOMAIN),
            ),
            'group' => 'bessfu_configuration_section'
        )
    );
    add_settings_field(
        'site_script_in_the_head_tag', '', 'bessfu_render_settings_field', 'bessfu_settings', 'bessfu_configuration_section',
        array(
            'title' => __('Script in the &#60;head&#62; tag', BESSFU_LANG_DOMAIN),
            'id'    => 'site_script_in_the_head_tag',
            'type'  => 'textarea',
            'items' => array(
                'site_script_in_the_head_tag' => __('Script in the &#60;head&#62; tag', BESSFU_LANG_DOMAIN),
            ),
            'group' => 'bessfu_configuration_section'
        )
    );
    add_settings_field(
        'site_script_in_the_body_tag', '', 'bessfu_render_settings_field', 'bessfu_settings', 'bessfu_configuration_section',
        array(
            'title' => __('Script in the &#60;body&#62; tag', BESSFU_LANG_DOMAIN),
            'id'    => 'site_script_in_the_body_tag',
            'type'  => 'textarea',
            'items' => array(
                'site_script_in_the_body_tag' => __('Script in the &#60;body&#62; tag', BESSFU_LANG_DOMAIN),
            ),
            'group' => 'bessfu_configuration_section'
        )
    );
    add_settings_field(
        'site_banner_news', '', 'bessfu_render_settings_field', 'bessfu_settings', 'bessfu_configuration_section',
        array(
            'title' => __('Banner News', BESSFU_LANG_DOMAIN),
            'id'    => 'site_banner_news',
            'type'  => 'text',
            'items' => array(
                'site_banner_news' => __('Banner News', BESSFU_LANG_DOMAIN),
            ),
            'group' => 'bessfu_configuration_section'
        )
    );
    add_settings_field(
        'site_link_test_drive', '', 'bessfu_render_settings_field', 'bessfu_settings', 'bessfu_configuration_section',
        array(
            'title' => __('Link test drive', BESSFU_LANG_DOMAIN),
            'id'    => 'site_link_test_drive',
            'type'  => 'text',
            'items' => array(
                'site_link_test_drive' => __('Link test drive', BESSFU_LANG_DOMAIN),
            ),
            'group' => 'bessfu_configuration_section'
        )
    );
    add_settings_field(
        'site_link_contact', '', 'bessfu_render_settings_field', 'bessfu_settings', 'bessfu_configuration_section',
        array(
            'title' => __('Link contact', BESSFU_LANG_DOMAIN),
            'id'    => 'site_link_contact',
            'type'  => 'text',
            'items' => array(
                'site_link_contact' => __('Link contact', BESSFU_LANG_DOMAIN),
            ),
            'group' => 'bessfu_configuration_section'
        )
    );
	// Finally, we register the fields with WordPress
	register_setting('bessfu_settings', 'bessfu_configuration_section', 'bessfu_settings_validation');
	#register_setting('bessfu_settings', 'bessfu_role_settings', 'bessfu_settings_validation');
	#register_setting('bessfu_settings', 'bessfu_misc', 'bessfu_settings_validation');

} // end sandbox_initialize_theme_options
add_action('admin_init', 'bessfu_create_options');

function bessfu_settings_validation($input)
{
	return $input;
}

function bessfu_add_meta_boxes()
{
	add_meta_box("bessfu_post_restrictions_metabox", __('Site Configuration', BESSFU_LANG_DOMAIN), "bessfu_metaboxes_callback", "bessfu_metaboxes", 'advanced', 'default', array('settings_section' => 'bessfu_configuration_section'));
	#add_meta_box("bessfu_role_settings_metabox", __('Role Settings', bessfu_PRODUCT_LANG_DOMAIN), "bessfu_metaboxes_callback", "bessfu_metaboxes", 'advanced', 'default', array('settings_section' => 'bessfu_role_section'));
	#add_meta_box("bessfu_misc_metabox", __('Misc Settings', bessfu_PRODUCT_LANG_DOMAIN), "bessfu_metaboxes_callback", "bessfu_metaboxes", 'advanced', 'default', array('settings_section' => 'bessfu_misc_section'));
}

function bessfu_minify_metabox(){
    add_filter( "postbox_classes_bessfu_metaboxes_bessfu_post_restrictions_metabox", 'bessfu_minify_metabox_bessfu_post_restrictions_metabox', 10 );
}

function bessfu_closed_metabox($meta_box, $classes){
    $user = wp_get_current_user();
    $bessfu_settings_metaboxes = get_user_meta($user->ID, 'closedpostboxes_bessfu_settings_metaboxes', true);
    if( in_array($meta_box, $bessfu_settings_metaboxes) ){
        $classes[] = 'closed';
    }
    return $classes;
}

function bessfu_minify_metabox_bessfu_post_restrictions_metabox($classes){
    $classes = bessfu_closed_metabox('bessfu_post_restrictions_metabox', $classes);
    return $classes;
}

add_action('admin_init', 'bessfu_add_meta_boxes');

function bessfu_metaboxes_callback($post, $args)
{
	do_settings_fields("bessfu_settings", $args['args']['settings_section']);
	submit_button(__('Save Changes', BESSFU_LANG_DOMAIN), 'secondary');
}

function bessfu_render_settings_field($args)
{
	$option_value = get_option($args['group']);
	?>
	<div class="row clearfix">
		<div class="col options-panel">
			<?php if ($args['type'] == 'text'): ?>
                <div class="col lbl-title"><?php echo $args['title']; ?></div>
				<div class="lbl-content">
                    <input type="text" id="<?php echo $args['id'] ?>"
                           name="<?php echo $args['group'] . '[' . $args['id'] . ']'; ?>"
                           value="<?php echo (isset($option_value[ $args['id'] ])) ? esc_attr($option_value[ $args['id'] ]) : ''; ?>">
                </div>
			<?php elseif ($args['type'] == 'select'): ?>
                <div class="col colone lbl-title"><?php echo $args['title']; ?></div>
                <div class="lbl-content">
                    <select name="<?php echo $args['group'] . '[' . $args['id'] . ']'; ?>" id="<?php echo $args['id']; ?>">
                        <?php foreach ($args['options'] as $key => $option) { ?>
                            <option <?php if (isset($option_value[ $args['id'] ])) selected($option_value[ $args['id'] ], $key);
                            echo 'value="' . $key . '"'; ?>><?php echo $option; ?></option><?php } ?>
                    </select>
                </div>
			<?php elseif ($args['type'] == 'checkbox'): ?>
				<input type="hidden" name="<?php echo $args['group'] . '[' . $args['id'] . ']'; ?>" value="0"/>
				<input type="checkbox" name="<?php echo $args['group'] . '[' . $args['id'] . ']'; ?>"
					   id="<?php echo $args['id']; ?>"
					   value="true" <?php if (isset($option_value[ $args['id'] ])) checked($option_value[ $args['id'] ], 'true'); ?> />
                <label class="col colone"><?php echo $args['title']; ?></label>
			<?php elseif ($args['type'] == 'textarea'): ?>
                <div class="col lbl-title"><?php echo $args['title']; ?></div>
                <div class="lbl-content">
                    <textarea name="<?php echo $args['group'] . '[' . $args['id'] . ']'; ?>"
                              type="<?php echo $args['type']; ?>" cols=""
                              rows=""><?php echo isset($option_value[ $args['id'] ]) ? stripslashes(esc_textarea($option_value[ $args['id'] ])) : ''; ?></textarea>
                </div>
			<?php elseif ($args['type'] == 'multicheckbox'):
				foreach ($args['items'] as $key => $checkboxitem):
					?>
					<input type="hidden" name="<?php echo $args['group'] . '[' . $args['id'] . '][' . $key . ']'; ?>"
						   value="0"/>
					<label
						for="<?php echo $args['group'] . '[' . $args['id'] . '][' . $key . ']'; ?>"><?php echo $checkboxitem; ?></label>
					<input type="checkbox" name="<?php echo $args['group'] . '[' . $args['id'] . '][' . $key . ']'; ?>"
						   id="<?php echo $args['group'] . '[' . $args['id'] . '][' . $key . ']'; ?>" value="1"
						   <?php if ($key == 'reason'){ ?>checked="checked" disabled="disabled"<?php } else {
						checked($option_value[ $args['id'] ][ $key ]);
					} ?> />
				<?php endforeach; ?>
			<?php elseif ($args['type'] == 'multitext'):
				foreach ($args['items'] as $key => $textitem):
					?>
					<div class="lbl-title" for="<?php echo $args['group'] . '[' . $key . ']'; ?>"><?php echo $textitem; ?></div>
                    <div class="lbl-content">
                        <input type="text" id="<?php echo $args['group'] . '[' . $key . ']'; ?>" class="multitext"
                               name="<?php echo $args['group'] . '[' . $key . ']'; ?>"
                               value="<?php echo (isset($option_value[ $key ])) ? esc_attr($option_value[ $key ]) : ''; ?>">
                    </div>
				<?php endforeach; endif; ?>
		</div>
		<div class="col colthree">
			<small><?php echo isset($args['desc']) ? $args['desc'] : ''; ?></small>
		</div>
	</div>
	<?php
}

?>
