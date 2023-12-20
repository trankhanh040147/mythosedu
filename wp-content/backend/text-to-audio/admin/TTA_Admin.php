<?php
namespace TTA_Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://azizulhasan.com
 * @since      1.0.0
 *
 * @package    TTA
 * @subpackage TTA/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    TTA
 * @subpackage TTA/admin
 * @author     Azizul Hasan <azizulhasan.cr@gmail.com>
 */
class TTA_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Plugin's localize data.
     *
     * @since    1.3.14
     * @access   private
     * @var      string    $localize_data    Plugin's localize data.
     */
    public $localize_data;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $listening = (array) get_option('tta_listening_settings');
        $listening = json_encode($listening);
        add_filter('script_loader_tag', [ $this, 'load_script_as_tag'] , 10, 3);
            global $is_iphone, $is_iphone, $is_chrome,$is_safari,
        $is_NS4,$is_opera,$is_macIE,$is_winIE, $is_gecko, $is_lynx, $is_IE, $is_edge; 

        if( ! function_exists( 'is_plugin_active' ) ) {
            include ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $this->localize_data  =  [
            'json_url' => esc_url_raw(rest_url()),
            'admin_url' => admin_url('/'),
            'classic_editor_is_active' => is_plugin_active('classic-editor/classic-editor.php'),
            'buttonTextArr' => apply_filters( 'tta__button_text_arr', get_option( 'tta__button_text_arr' ) ),
            'browser' => [
                'is_iphone' =>  $is_iphone, //(boolean): iPhone Safari
                'is_chrome'=> $is_chrome,// (boolean): Google Chrome
                'is_safari' =>  $is_safari,// (boolean): Safari
                'is_NS4' => $is_NS4,//(boolean): Netscape 4
                'is_opera' => $is_opera, //(boolean): Opera
                'is_macIE' => $is_macIE, //(boolean): Mac Internet Explorer
                'is_winIE' => $is_winIE, //(boolean): Windows Internet Explorer
                'is_gecko' => $is_gecko, //(boolean): FireFox
                'is_lynx'=> $is_lynx, //(boolean): Lynx
                'is_IE' => $is_IE, //(boolean): Internet Explorer
                'is_edge' => $is_edge, //(boolean): Microsoft Edge
            ],
            'ajax_url' => admin_url('admin-ajax.php'),
            'api_url' => esc_url_raw(rest_url()),
            'api_namespace' => 'tta',
            'api_version' => 'v1',
            'image_url' => WP_PLUGIN_URL . '/text-to-audio/admin/images',
            'plugin_url' => WP_PLUGIN_URL . '/text-to-audio',
            'nonce' => wp_create_nonce(TEXT_TO_AUDIO_NONCE),
            'plugin_name' => TEXT_TO_AUDIO_PLUGIN_NAME,
            'rest_nonce' => wp_create_nonce('wp_rest'),
            'post_types' => get_post_types(),
            'VERSION' => TEXT_TO_AUDIO_VERSION,
            'is_logged_in' => is_user_logged_in(),
            'is_admin' => current_user_can('administrator'),
            'is_dashboard' => is_admin(),
            'listeningSettings' => $listening,
            'is_pro_active' => is_pro_active(),
            'is_pro_license_active' => is_pro_license_active(),
            'is_admin_page' => \is_admin(),
        ];
    }

    public function load_script_as_tag($tag, $handle, $src) {
        if(!in_array($handle, ['text-to-audio-button', 'TextToSpeech'])) {
            return $tag;
        }

        $tag = '<script  type="module" src="' . esc_url($src) . '"  ></script>';

        return $tag;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        /* Dashicons */
        wp_enqueue_style('dashicons');
        wp_enqueue_style('text-to-audio-dashboard', plugin_dir_url(__FILE__) . 'css/text-to-audio-dashboard.css', [] , $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        /**
         * Looad wp-speeh script
         */

        if( ! function_exists( 'is_plugin_active' ) ) {
            include ABSPATH . 'wp-admin/includes/plugin.php';
        }

        do_action('tta_enqueue_pro_dashboard_scripts');


        if (isset($_REQUEST['page']) && ('text-to-audio' == $_REQUEST['page'])) {
            /* Load react js */
                wp_enqueue_script('tts-font-awesome', plugin_dir_url(__FILE__) . 'js/build/font-awesome.min.js', array(), $this->version, true);
                wp_enqueue_style('tts-bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.css', [] , $this->version, 'all' );
                wp_enqueue_script('TextToSpeech', plugin_dir_url(__FILE__) . 'js/build/TextToSpeech.min.js', array('wp-hooks',), $this->version, true);
                wp_localize_script('TextToSpeech', 'ttsObj', $this->localize_data);
                wp_enqueue_script('text-to-audio-dashboard-ui', plugin_dir_url(__FILE__) . 'js/build/text-to-audio-dashboard-ui.min.js', array('TextToSpeech'), $this->version, true);
                wp_localize_script('text-to-audio-dashboard-ui', 'tta_obj', $this->localize_data);
                wp_enqueue_style('dashicons');
        }
    }

    public function engueue_block_scripts() {
        
        wp_enqueue_script('tta-blocks', plugin_dir_url(dirname(__FILE__)) . 'build/blocks.js', array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), true, true);
        wp_localize_script('tta-blocks', 'ttaBlocks', $this->localize_data);

        register_block_type('tta/customize-button', [
            'render_callback' => [$this, 'render_button'],
        ]);

    }

    /**
     * @param $customize button.
     *
     * @return string
     */
    public function render_button($customize) {

        return tta_get_button_content($customize, true);
    }

    /**
     * Enqueue wp speech file
     *
     */
    public function enqueue_TTA() {
        if(is_pro_license_active()){
            wp_enqueue_script('TextToSpeech', plugin_dir_url(__FILE__) . 'js/build/TextToSpeech.min.js', array('wp-hooks',), $this->version, true);
            wp_localize_script('TextToSpeech', 'ttsObj', $this->localize_data);
        }else{
            wp_enqueue_script('text-to-audio-button', plugin_dir_url(__FILE__) . 'js/build/text-to-audio-button.min.js', array('wp-hooks', 'wp-shortcode'), $this->version, true);
            wp_localize_script('text-to-audio-button', 'ttsObj', $this->localize_data );
            wp_enqueue_style('dashicons');
        }
    }

    /**
     * Add Menu and Submenu page
     */

    public function TTA_menu() {
        add_menu_page(
            __('Text To Speech Ninja', TEXT_TO_AUDIO_TEXT_DOMAIN),
            __('Text To Speech', TEXT_TO_AUDIO_TEXT_DOMAIN),
            'manage_options',
            TEXT_TO_AUDIO_TEXT_DOMAIN,
            array($this, "TTA_settings"),
            'dashicons-controls-volumeon',
            20
        );
    }

    public function TTA_settings() {
        echo "<div class='wpwrap'><div id='tts_dashboard_ui'></div></div>";
    }

}
