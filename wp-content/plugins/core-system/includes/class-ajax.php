<?php

namespace CoreSystem\Includes;

class Cores_AJAX {

    /**
     * Ajax actions.
     *
     * Holds all the register ajax action.
     *
     * @since 2.0.0
     * @access private
     *
     * @var array
     */
    private $ajax_actions = [];
    private $nopriv_ajax_actions = [];

    /**
     * Ajax response data.
     *
     * Holds all the response data for all the ajax requests.
     *
     * @since 2.0.0
     * @access private
     *
     * @var array
     */
    private $response_data = [];

    protected static $_instances = [];

    function __construct()
    {
        add_action('wp_ajax_cores_handle_ajax', [$this, 'handle_ajax_request']);
        add_action('wp_ajax_nopriv_cores_handle_ajax', [$this, 'handle_ajax_request']);
    }

    /**
     * Class name.
     *
     * Retrieve the name of the class.
     *
     * @since 1.7.0
     * @access public
     * @static
     */
    public static function class_name() {
        return get_called_class();
    }

    public static function instance() {
        $class_name = static::class_name();
        if ( empty( static::$_instances[ $class_name ] ) ) {
            static::$_instances[ $class_name ] = new static();
        }

        return static::$_instances[ $class_name ];
    }

    function process_action($callback, $data){
        try{
            $result = call_user_func($callback, $data, $this);
            if( $result === false ){
                $this->add_response_data('', true);
            }elseif(is_wp_error($result)){
                $message = $result->get_error_messages();
                $message = implode("<br>", $message);
                $code = $result->get_error_code();
                $data = apply_filters('core_system/ajax/insert_data_errors', []);
                $this->add_response_data($message, false, $data, $code)
                    ->send_error($code, $message);
            }else{
                $this->add_response_data(__('Success', TPL_DOMAIN_LANG), true, $result);
            }
        }catch (\Exception $e){
            $this->add_response_data($e->getMessage(), false, [], $e->getCode());
        }

        $this->send_success();
    }

    function handle_ajax_request(){
        $data = wp_slash($_REQUEST);
        $action = $data['func'];
        if( is_user_logged_in() ){
            do_action('core_system/ajax/register_actions', $this);
            $ajax_actions = isset($this->ajax_actions[$action]) ? $this->ajax_actions[$action] : [];
        }else{
            do_action('core_system/ajax/register_nopriv_actions', $this);
            $ajax_actions = isset($this->nopriv_ajax_actions[$action]) ? $this->nopriv_ajax_actions[$action] : [];
        }
        if( empty($ajax_actions) ){
            $this->add_response_data( false, __( 'Action not found.', TPL_DOMAIN_LANG ), [], 400 )
                ->send_error(400);
        }
        $this->process_action($ajax_actions['callback'], $data);
    }

    public function verify_request($id){
        if( !$this->verify_request_nonce($id) ){
            $message = __('Time has expired' ,TPL_DOMAIN_LANG );
            $this->add_response_data($message, false, [], 400)
                ->send_error(400);
        }
    }

    public function handle_ajax_action($tag, $callback){
        if ( ! did_action( 'core_system/ajax/register_actions' ) ) {
            _doing_it_wrong( __METHOD__, esc_html( sprintf( 'Use `%s` hook to register ajax action.', 'core_system/ajax/register_actions' ) ), '1.0.0' );
        }
        $this->ajax_actions[$tag] = compact('tag', 'callback');
    }

    public function handle_nopriv_ajax_action($tag, $callback){
        if ( ! did_action( 'core_system/ajax/register_nopriv_actions' ) ) {
            _doing_it_wrong( __METHOD__, esc_html( sprintf( 'Use `%s` hook to register ajax action.', 'core_system/ajax/register_nopriv_actions' ) ), '1.0.0' );
        }
        $this->nopriv_ajax_actions[$tag] = compact('tag', 'callback');
    }

    public function register_ajax_action($tag, $callback){
        if( is_user_logged_in() ){
            $this->handle_ajax_action($tag, $callback);
        }else{
            $this->handle_nopriv_ajax_action($tag, $callback);
        }
    }

    function verify_request_nonce($action){
        return ! empty( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], $action );
    }

    function send_success(){
        $this->send_response_json(201);
        wp_die( '', '', [ 'response' => null ] );
    }

    function send_error($code = null, $message = ''){
        $this->send_response_json($code, $message);
        wp_die( '', '', [ 'response' => null ] );
    }

    function add_response_data($message, $success, $data = [], $code = 201){
        $this->response_data = [
            'success' => $success,
            'code' => $code,
            'data' => $data,
            'message' => $message
        ];
        return $this;
    }

    function send_response_json( $status_code = null, $description = '' ) {
        @header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
        if ( null !== $status_code ) {
            status_header( $status_code, $description );
            if ( ! $description ) {
                $description = get_status_header_desc( $status_code );
            }
        }
        if( !empty($description) ) {
            $description = json_encode($description);
            @header("Xhr-Message: {$description}");
        }
        echo wp_json_encode( $this->response_data, JSON_PRETTY_PRINT );
    }
}