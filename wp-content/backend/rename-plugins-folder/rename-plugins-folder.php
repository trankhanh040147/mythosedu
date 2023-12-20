<?php
/*
Plugin Name: Rename Plugins Folder
Description: How to rename the plugins folder? Install Rename Plugins Folder.
Author: Jose Mortellaro
Author URI: https://josemortellaro.com
Domain Path: /languages/
Version: 0.0.1
*/
/*  This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

//Definitions
define( 'EOS_RPF_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'EOS_RPF_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );
define( 'EOS_RPF_PLUGIN_BASE_NAME', untrailingslashit( plugin_basename( __FILE__ ) ) );
define( 'EOS_RPF_PLUGIN_VERSION', '0.0.1' );

if( is_admin() ){
	require_once EOS_RPF_PLUGIN_DIR.'/admin/rpf-admin.php';
}
if( defined( 'DOING_AJAX' ) && DOING_AJAX && false !== strpos( '_'.$_REQUEST['action'],'eos_rpf_' ) ){
	require_once EOS_RPF_PLUGIN_DIR.'/admin/rpf-ajax.php';
}
