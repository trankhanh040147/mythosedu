<?php

namespace TUTOR_PRO;

if (!defined('ABSPATH')) {
	exit;
}

class Assets
{
	public function __construct()
	{
		add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
	}

	public function admin_scripts()
	{
		wp_enqueue_style('tutor-pro-admin', tutor_pro()->url . 'assets/css/admin.css', array(), TUTOR_PRO_VERSION);
		wp_enqueue_script('tutor-pro-admin', tutor_pro()->url . 'assets/js/admin.js', array('jquery'), TUTOR_PRO_VERSION, true);
	}
}
