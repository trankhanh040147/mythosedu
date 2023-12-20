<?php
defined( 'ABSPATH' ) || exit; //prefent direct access

//File including aLl the scripts for the Backend


//Add admin menu item under the plugins menu
function eos_rpf_plugin_menu() {
    add_plugins_page(
        esc_html__( 'Rename plugins folder','eos-rpf' ),
        esc_html__( 'Rename plugins folder','eos-rpf' ),
        'manage_options',
        'eos-rpf-settings-page',
        'eos_rpf_settings_do_page'
    );
}
add_action( 'admin_menu','eos_rpf_plugin_menu' );

add_action( 'admin_enqueue_scripts','eos_rpf_enqueue_assets' );
//Enqueue assets for the settings paged
function eos_rpf_enqueue_assets(){
  if( isset( $_GET['page'] ) && 'eos-rpf-settings-page' === $_GET['page'] ){
    wp_enqueue_script( 'eos-rpf',EOS_RPF_PLUGIN_URL.'/admin/assets/js/rpf-admin.js','jquery',EOS_RPF_PLUGIN_VERSION );
    wp_enqueue_style( 'eos-rpf',EOS_RPF_PLUGIN_URL.'/admin/assets/css/rpf-admin.css',null,EOS_RPF_PLUGIN_VERSION );
  }
}


//Callbakk for the settings page
function eos_rpf_settings_do_page(){
  wp_nonce_field( 'eos_rpf_rename_nonce','eos_rpf_rename_nonce' );
  $folder_name = defined( 'WP_PLUGIN_DIR' ) ? basename( WP_PLUGIN_DIR ) : 'plugins';
  ?>
  <section id="rpf-section" style="margin-top:32px">
    <h1><?php esc_html_e( 'Rename Plugins Folder','eos-rpf' ); ?></h1>
    <label for="rpf-folder-name"><?php esc_html_e( 'Type a new name for your plugins folder','eos-rpf' ); ?></label>
    <input type="text" id="rpf-folder-name" value="<?php echo $folder_name; ?>" />
    <input type="submit" id="rpf-rename-submit" class="button" value="<?php esc_attr_e( 'Rename','eos-rpf' ); ?>" />
    <div id="rpf-message-success" class="rpf-hidden notice notice-success"><?php esc_html_e( 'Plugins folder renamed successfully','eos-rpf' ); ?></div>
    <div id="rpf-message-fail" class="rpf-hidden notice notice-error"><?php esc_html_e( 'Something went wrong. Plugins folder not renamed.','eos-rpf' ); ?></div>
    <div id="rpf-message-no-access" class="rpf-hidden notice notice-error"><?php esc_html_e( 'It looks you have no writing rights. Impossible to rename the plugins folder in this case.','eos-rpf' ); ?></div>
  </section>
  <?php
}

add_action( 'admin_head','eos_rpf_admin_notices' );
//Remove all admmin notices on the settings page
function eos_rpf_admin_notices(){
  if( isset( $_GET['page'] ) && 'eos-rpf-settings-page' === $_GET['page'] ){
    remove_all_actions( 'admin_notices' );
    remove_all_actions( 'all_admin_notices' );
    add_action( 'admin_notices','rpf_admin_warning' );
  }
}

//Warn the user about the risks
function rpf_admin_warning(){
  ?>
  <div class="notice notice-warning" style="padding:20px">
    <p style="font-size:25px"><?php esc_html_e( "Be careful! Renaming the plugins folder may cause serious issues if one of your plugin or your theme don't follow the best practices to refer to the plugins folder.","eos-rpf" ); ?></p>
    <p style="font-size:25px"><?php esc_html_e( "If you want to sleep well, before pressing the button, follow these steps:.","eos-rpf" ); ?></p>
    <ul style="margin:32px 20px;list-style:disc">
      <li style="font-size:25px;line-height:3"><?php esc_html_e( 'Make a backup of your wp-config.php, or even better, a full backup.','eos-rpf' ); ?></li>
    </ul>
    <p style="font-size:25px"><?php esc_html_e( "If after renaming the plugins folder something goes wrong and you don't know how to solve it, follow these steps:.","eos-rpf" ); ?></p>
    <ul style="margin:32px 20px;list-style:disc">
      <li style="font-size:25px;line-height:3"><?php esc_html_e( 'Restore the file wp-config.php that you backed up.','eos-rpf' ); ?></li>
      <li style="font-size:25px;line-height:3"><?php esc_html_e( 'Manually rename the plugins folder via FTP restoring the original name "plugins".','eos-rpf' ); ?></li>
    </ul>
  </div>
  <?php
}

$plugin = EOS_RPF_PLUGIN_BASE_NAME;
//It adds a settings link to the action links in the plugins page
add_filter( "plugin_action_links_$plugin", 'eos_rpf_plugin_add_settings_link' );

//It adds a settings link to the action links in the plugins page
function eos_rpf_plugin_add_settings_link( $links ) {
    $settings_link = '<a class="eos-dp-setts" href="'.admin_url( 'admin.php?page=eos-rpf-settings-page' ).'">' . __( 'Settings','eos-rpf' ). '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
