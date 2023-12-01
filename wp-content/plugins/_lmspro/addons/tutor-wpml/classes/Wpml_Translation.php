<?php

namespace TUTOR_WPML;

use TUTOR_PRO\Course_Duplicator;

if (!defined('ABSPATH'))
    exit;

class Wpml_Translation {

    private static $wpml_current_lang;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array($this, 'load_scrips') );
        add_action( 'save_post_' . tutor()->course_post_type, array($this, 'copy_content_from_source'), 999, 1 );
        add_filter( 'tutor_dashboard_page_id_filter', array($this, 'tutor_dashboard_page_id_filter') );
        add_action( 'tutor_utils/get_pages/before', array($this, 'enable_wpml_filter_dashboard_page') );
        add_action( 'tutor_utils/get_pages/after', array($this, 'disable_wpml_filter_dashboard_page') );
    }

    public function load_scrips() {
        wp_enqueue_script('tutor-wpml-js', TUTOR_WPML()->url . 'assets/js/duplicate.js');
    }

    public function copy_content_from_source( $target_course_id ) {

        if(
            !isset( $_POST['icl_trid'] ) ||
            !isset( $_POST['tutor_wpml_copy_source'] ) ||
            $_POST['tutor_wpml_copy_source'] != 1 ||
            get_post_meta( $target_course_id, 'tutor_wpml_source_copied', false )) {
            return;
        }
        update_post_meta( $target_course_id, 'tutor_wpml_source_copied', true );

        global $wpdb;
		$source_course_id = isset( $_POST['icl_translation_of'] ) ?
            $_POST['icl_translation_of'] :
            $wpdb->get_var( $wpdb->prepare(
                "SELECT element_id
                FROM {$wpdb->prefix}icl_translations
                WHERE trid=%d AND source_language_code IS NULL", $_POST['icl_trid'] ) );

        (new Course_Duplicator(false))->duplicate_post($source_course_id, null, 0, $target_course_id);
    }

    public function tutor_dashboard_page_id_filter($student_dashboard_page_id) {

        global $sitepress;
        if(isset($sitepress)){
            $trid = apply_filters('wpml_element_trid', NULL, $student_dashboard_page_id, 'post_page');
            $translations = apply_filters('wpml_get_element_translations', NULL, $trid, 'post_page');
            $current_lang = apply_filters('wpml_current_language', NULL);
            $student_dashboard_page_id = (int) isset( $translations[ $current_lang ] ) ? $translations[ $current_lang ]->element_id : null;
        }

        return $student_dashboard_page_id;
    }

    public function enable_wpml_filter_dashboard_page() {
		global $sitepress;
		if (isset($sitepress)) {
			self::$wpml_current_lang = apply_filters('wpml_current_language', NULL);
			$wpml_default_lang = apply_filters('wpml_default_language', NULL);
			$sitepress->switch_lang($wpml_default_lang);
		}
    }

    public function disable_wpml_filter_dashboard_page() {
		global $sitepress;
        if (isset($sitepress)) {
			$sitepress->switch_lang(self::$wpml_current_lang);
		}
    }
}
