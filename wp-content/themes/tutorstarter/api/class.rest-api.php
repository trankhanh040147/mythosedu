<?php

namespace DIVI\API;

class RESTAPI
{

    private $username = '';
    private $password = '';
    private $url = '';
    private $token = '';
    private $id = '';
    protected $auth_cookie_name = 'auth';

    public function __construct()
    {
        $this->url = REST_API_URL;
        $this->username = __USERNAME;
        $this->password = __PASSWORD;
        $this->token = $this->get_token();
    }

    function query_without_body($method, $schemas = [], $token = false)
    {
        $type = $method == 'POST' ? 'POST' : 'GET';
        $end_point = $schemas["end_point"] ?? "";
        $body = $schemas["body"] ?? "";
        $url = $this->url . $end_point;
        $args = [
            'method' => $type,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => $body
        ];
        if ($token) {
            $args['headers']['Authorization'] = $this->token;
        }

        $response = wp_remote_post($url, $args);
        if (is_wp_error($response)) {
            return $response;
        } else {
            return json_decode($response['body']);
        }
    }

    public function query_for_body($method, $func, $schemas = [], $token = false)
    {

        $type = $method == 'POST' ? 'mutation' : 'query';
        $fields = isset($schemas['fields']) ? $this->parseFields($schemas['fields']) : '';
        $params = isset($schemas['params']) ? json_encode($this->parseParams($schemas['params'])) : '';
        $lenght = strlen($params);
        $params = substr($params, 1, $lenght - 2);
        $query = '{"query":"' . $type . "{" . $func . $params . $fields . '}"}';
        $args = [
            'headers' => array(
                'Content-Type' => 'application/json',
            )
        ];
        if ($token) {
            $this->get_token_cookie();
            $args['headers']['Authorization'] = $this->token;
        }
        $args['body'] = $query;
        $response = wp_remote_post($this->url, $args);

        if (is_wp_error($response)) {
            return $response;
        } else {
            return json_decode($response['body']);
        }
    }

    public function re_query($method, $func, $schemas = [], $token = false)
    {
        $response = array();
        $type = $method == 'POST' ? 'mutation' : 'query';

        $fields = isset($schemas['fields']) ? $this->customParseFields($schemas['fields']) : '';
        $params = isset($schemas['params']) ? $this->customParseParams($schemas['params']) : '';

        $args = [
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => ''
        ];
        if ($token) {
            $this->get_token_cookie();
            $args['headers']['Authorization'] = $this->token;
        }
        $args['body'] = "{\"query\":\"{$type}{{$func}{$params}{$fields}}\"}";
        $response = wp_remote_post($this->url, $args);
        if (is_wp_error($response)) {
            $message = $response->get_error_message();
            if (preg_match('/(cURL error)/', $message)) {
                return $this->re_query($method, $func, $schemas, $token);
            }
        }

        if (isset($response['body']) && $response['body'] != "") {
            $response = json_decode($response['body'], true);
        }

        if (isset($response['errors']) && $response['errors'] != "") {
            return $this->process_error($response['errors']);
        }

        return isset($response['data']) ? $response['data'] : $response;
    }

    function parseParams($params, $is_array = false)
    {
        $data = [];
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (is_array($value)) {
                    $param = $key . ':' . $this->parseParams($value, true);
                } elseif (is_object($value)) {
                    if (isset($value->array)) {
                        $param = $key . ':[' . $value->data . ']';
                    } else {
                        $param = $key . ':' . $this->parseParamsObject($value, true);
                    }
                } else {
                    if (!is_string($value)) {
                        $param = $key . ':' . $value;
                    } else {
                        $param = $key . ':"' . $value . '"';
                    }
                }

                $data[] = $param;
            }
        }
        if (!empty($data)) {
            if (!$is_array) {
                return "(" . implode(',', $data) . ")";
            } else {
                return "{" . implode(',', $data) . "}";
            }
        } else {
            return '';
        }
    }

    function parseParamsObject($params, $is_array = false)
    {
        $data = [];
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $param = $this->parseParamsObject((object)$value);
            } elseif (is_object($value)) {
                if (isset($value->array)) {
                    $param = $key . ':[' . $value->data . ']';
                } else {
                    $param = $key . ':' . $this->parseParamsObject($value, true);
                }
            } else {
                if (!is_string($value)) {
                    $param = $key . ':' . $value;
                } else {
                    $param = $key . ':"' . $value . '"';
                }
            }

            $data[] = $param;
        }
        if (!empty($data)) {
            if (!$is_array) {
                return "{" . implode(',', $data) . "}";
            } else {
                return "[" . implode(',', $data) . "]";
            }
        } else {
            return '';
        }
    }

    function parseParamsWithFields($params)
    {
        $data = [];
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (!is_string($value)) {
                    $param = $key . ':' . $value;
                } else {
                    $param = $key . ':"' . $value . '"';
                }
                $data[] = $param;
            }
        }
        if (!empty($data)) {
            return "{" . implode(',', $data) . "}";
        } else {
            return '';
        }
    }

    function parseFields($fields)
    {
        return "{" . implode(',', $fields) . "}";
    }

    public function customParseParams($params)
    {
        return $this->_customParseParams($params);
    }


    public function customParseFields($params)
    {
        return $this->_customParseFields($params, true);
    }

    private function _customParseParams($params, $is_field = false, $is_array = false)
    {
        $data = [];
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (is_array($value)) {
                    if (!empty($value)) {
                        $deep = array_depth($value);
                        $key = is_string($key) ? "{$key}:" : "";
                        $param = "{$key}{$this->_customParseParams($value, true,$deep >= 1)}";
                    } else {
                        $param = "{$key}:\\\"\\\"";
                    }
                } else {
                    if (!is_string($value)) {
                        $param = is_string($key) ? $key . ':' . $value : $value;
                    } else {
                        $param = is_string($key) ?  $key . ":\\\"$value\\\"" : $value;
                    }
                }
                $data[] = $param;
            }
        }

        if (!empty($data)) {
            if ($is_array) {
                $compare_string = '[' . substr(str_repeat(',\"%s\"', count($data)), 1) . ']';
                return vsprintf($compare_string, $data);
            }
            if (!$is_field) {
                return "(" . implode(',', $data) . ")";
            } else {
                return "{" . implode(',', $data) . "}";
            }
        } else {
            return '';
        }
    }
    private function _customParseFields($params, $is_field = false)
    {
        $data = [];
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (is_array($value) && !empty($value)) {
                    $param = is_string($key) ?  "{$key}{$this->_customParseFields($value, true)}" : $this->_customParseParams($value, true);
                } else {
                    if (!is_string($value)) {
                        $param = is_string($key) ? $key . '' . $value : $value;
                    } else {
                        $param = is_string($key) ?  $key . "\\\"$value\\\"" : $value;
                    }
                }
                $data[] = $param;
            }
        }

        if (!empty($data)) {
            if (!$is_field) {
                return "(" . implode(',', $data) . ")";
            } else {
                return "{" . implode(',', $data) . "}";
            }
        } else {
            return '';
        }
    }

    public function process_error($errors)
    {
        $errors = (array) $errors;
        $err = new \WP_Error();
        foreach ($errors as $error) {
            $err->add($error['statusCode'], $error['message']);
        }
        return $err;
    }

    public function clear_token_cookie()
    {
        $secure = is_ssl();
        setcookie($this->auth_cookie_name, '', time() - YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, $secure, true);
        $_COOKIE[$this->auth_cookie_name] = '';
        do_action('app/logout');
    }

    public function set_token_cookie($data, $remember = false)
    {
        $secure = is_ssl();
        $auth_cookie_name = $this->auth_cookie_name;

        if ($remember) {
            /**
             * Filters the duration of the authentication cookie expiration period.
             *
             * @since 2.8.0
             *
             * @param int  $length   Duration of the expiration period in seconds.
             * @param int  $user_id  User ID.
             * @param bool $remember Whether to remember the user login. Default false.
             */
            $expiration = time() + apply_filters('app/authenticate/auth_cookie_expiration', 7 * DAY_IN_SECONDS, $data, $remember);

            /*
			 * Ensure the browser will continue to send the cookie after the expiration time is reached.
			 * Needed for the login grace period in wp_validate_auth_cookie().
			 */
            $expire = $expiration;
        } else {
            /** This filter is documented in wp-includes/pluggable.php */
            $expiration = time() + apply_filters('app/authenticate/auth_cookie_expiration', 1 * DAY_IN_SECONDS, $data, $remember);
            $expire     = 0;
        }
        $cookie = $data['token'] . ':' . $data['id'] . ':' . $expiration;
        setcookie($auth_cookie_name, $cookie, $expire, COOKIEPATH, COOKIE_DOMAIN, $secure, true);
    }

    public function get_token_cookie()
    {
        if (isset($_COOKIE[$this->auth_cookie_name])) {
            $cookie = $_COOKIE[$this->auth_cookie_name];
            $cookie_elements = explode(':', $cookie);
            if (count($cookie_elements) !== 3) {
                $this->token = NULL;
                return false;
            }
            list($token, $id, $expiration) = $cookie_elements;

            $this->token = $token;
        } else {
            $this->token = NULL;
        }
    }

    public function get_id_cookie()
    {
        $id_user = '';
        if (isset($_COOKIE[$this->auth_cookie_name])) {
            $cookie = $_COOKIE[$this->auth_cookie_name];
            $cookie_elements = explode(':', $cookie);
            if (count($cookie_elements) !== 3) {
                $this->token = NULL;
                return false;
            }
            list($token, $id, $expiration) = $cookie_elements;
            return $id_user = $id;
        }
        return $id_user;
    }

    function get_token($method = "POST")
    {
        $end_point = '/auth/v1/login';
        $body = array(
            "username" => $this->username,
            "password" =>  $this->password,
        );

        $body = wp_json_encode($body);

        $response = $this->query_without_body($method, ['end_point' => $end_point, 'body' => $body], false);

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            return $error_message;
        } else {
            return $response->data->accessToken;
        }
    }
}

$GLOBALS['system_rest_api'] = new RESTAPI();
