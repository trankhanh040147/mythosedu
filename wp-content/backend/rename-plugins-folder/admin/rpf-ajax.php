<?php
defined( 'ABSPATH' ) || exit; //prefent direct access

//File including aLl the scripts for ajax activitiies

add_action( 'wp_ajax_eos_rpf_rename_folder','eos_rpf_rename_folder' );
//Rename plugins Folder
function eos_rpf_rename_folder(){
  if(
    !current_user_can( 'manage_options' )
    || !isset( $_POST['nonce'] )
    || !isset( $_POST['new_name'] )
    || !wp_verify_nonce( esc_attr( $_POST['nonce']  ),'eos_rpf_rename_nonce' )
  ){
    die();
    exit;
  }
  if( !function_exists( 'get_filesystem_method' ) ){
    require_once ( ABSPATH . '/wp-admin/includes/file.php' );
  }
  $writeAccess = false;
	$access_type = get_filesystem_method();
	if( $access_type === 'direct' ){
		/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
		$creds = request_filesystem_credentials( admin_url(),'',false,false,array() );
		/* initialize the API */
		if ( ! WP_Filesystem( $creds ) ) {
      die();
      exit;
		}
		global $wp_filesystem;
		$writeAccess = true;
		if( empty( $wp_filesystem ) ){
			require_once ( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
    }
    $config_file_path = ABSPATH.'/wp-config.php';
    if( !file_exists( $config_file_path ) ){
      echo '_config_file_not_found';
      die();
      exit;
    }
    $config_file = file( $config_file_path );
    $line_url_exists = $line_dir_exists = false;
    $new_folder_name = sanitize_file_name( $_POST['new_name'] );
  	$new_line_dir = "define('WP_PLUGIN_DIR','".WP_CONTENT_DIR."/".$new_folder_name."'); // Added by Rename Plugins Folder\r\n";
  	$new_line_url = "define('WP_PLUGIN_URL','".content_url()."/".$new_folder_name."'); // Added by Rename Plugins Folder\r\n";
  	$new_line_name = "define('PLUGINDIR','wp-content/".$new_folder_name."'); // Added by Rename Plugins Folder\r\n";
    $unsetIdx = array();
    $n = 0;
    foreach ( $config_file as &$line ) {
  		if ( ! preg_match( '/^define\(\s*\'([A-Z_]+)\',(.*)\)/',$line,$match ) ) {
  			continue;
  		}
  		if ( 'WP_PLUGIN_DIR' === $match[1] ) {
  			$line = $new_line_dir;
        $line_dir_exits = true;
        $unsetIdx[] = $n;
  		}
  		if ( 'WP_PLUGIN_URL' === $match[1] ) {
  			$line = $new_line_url;
        $unsetIdx[] = $n;
  		}
  		if ( 'PLUGINDIR' === $match[1] ) {
  			$line = $new_line_name;
        $unsetIdx[] = $n;
  		}
      ++$n;
  	}
    foreach( $unsetIdx as $idx ){
      if( isset( $config_file[$idx] ) ){
        unset( $config_file[$idx] );
      }
    }
    $handle = @fopen( $config_file_path, 'w' );
  	array_shift( $config_file );
  	array_unshift( $config_file, "<?php\r\n",$new_line_url,$new_line_dir,$new_line_name );
  	// Insert the constant in wp-config.php file.
  	foreach ( $config_file as $new_line ) {
  		@fwrite( $handle, $new_line );
  	}
  	@fclose( $handle );
    $plugins_path = dirname( EOS_RPF_PLUGIN_DIR );
    $new_plugins_path = str_replace( basename( $plugins_path ),$new_folder_name,$plugins_path );
    rename( $plugins_path,$new_plugins_path );
    echo 1;
    die();
    exit;
  }
  else{
    echo '_no_file_access';
    die();
    exit;
  }
  die();
  exit;
}
