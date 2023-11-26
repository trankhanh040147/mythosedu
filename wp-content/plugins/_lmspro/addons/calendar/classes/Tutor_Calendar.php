<?php
/**
 * Tutor_Calendar for handle calendar logics
 *
 * @since 1.9.10
 *
 * @package Tutor Calendar
 */

namespace TUTOR_PRO_C;

/**
 * Handle Tutor Calendar logics
 */
class Tutor_Calendar {
    /**
     * Handle Dependencies Register Hooks
     */
    public function __construct() {
        add_filter('tutor_dashboard/nav_items', array( $this, 'register_calendar_menu' ));
        add_action('load_dashboard_template_part_from_other_location', array( $this, 'load_template' ));
        add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));
        add_action('wp_ajax_get_calendar_materials', array( $this, 'get_calendar_materials' ));
    }

    public function register_calendar_menu( $nav_items ){
        do_action('tutor_pro_before_calendar_menu_add', $nav_items);
        
        $nav_items['calendar']  = array('title' => __('Calendar', 'tutor-pro'), 'icon' => 'tutor-icon-calender-line');
        return apply_filters('tutor_pro_after_calendar_menu', $nav_items);
    }

    public function load_template($template) {
        global $wp_query;
        $query_vars = $wp_query->query_vars;
        if (isset($query_vars['tutor_dashboard_page']) && 'calendar' === $query_vars['tutor_dashboard_page'] ) {
            $calendar_template = tutor_pro_calendar()->path.'templates/calendar.php';
            if (file_exists($calendar_template) ) {
                return apply_filters('tutor_pro_calendar', $calendar_template);
            }
        }
        return $template;
    }

    public function enqueue_scripts() {
        global $wp_query;
        $query_vars = $wp_query->query_vars;
        if ( isset($query_vars[ 'tutor_dashboard_page' ]) && 'calendar' === $query_vars['tutor_dashboard_page'] ) {
            wp_enqueue_script( 
                'tutor-pro-calendar', 
                tutor_pro_calendar()->url . 'assets/js/Calendar.js', 
                array( ), 
                TUTOR_PRO_VERSION,
                true
            );
            wp_enqueue_style( 
                'tutor-pro-calendar-css', 
                tutor_pro_calendar()->url . 'assets/css/calendar.css',
                '',
                TUTOR_PRO_VERSION
            );
        }
    }

    /**
     * Check assignment expired or not
     *
     * @param  $assignment_id int | required
     * @return mixed array | false
     * @since  1.9.10
     */
    public static function assignment_info(int $assignment_id) {
        $assignment_id = sanitize_text_field($assignment_id);
        $time_duration = tutor_utils()->get_assignment_option($assignment_id, 'time_duration', array('time'=>'', 'value'=>0));

        $post = get_post($assignment_id);
        if ( $post && !is_null($post) ) {
            $assignment_created_time = strtotime($post->post_date_gmt);
            $time_duration_in_sec = 0;
            if (isset($time_duration['value']) and isset($time_duration['time'])) {
                switch ($time_duration['time']) {
                case 'hours':
                    $time_duration_in_sec = 3600;
                    break;
                case 'days':
                    $time_duration_in_sec = 86400;
                    break;
                case 'weeks':
                    $time_duration_in_sec = 7 * 86400;
                    break;
                default:
                    $time_duration_in_sec = 0;
                    break;
                }
            }
            $time_duration_in_sec = $time_duration_in_sec * $time_duration['value'];
            $remaining_time = $assignment_created_time + $time_duration_in_sec;
            $now = time();
            $week_values = array(
                'weeks' => __('Weeks', 'tutor-pro'),
                'days'  => __('Days', 'tutor-pro'),
                'hours' => __('Hours', 'tutor-pro'),
            );
            return array(
                'duration'      => $time_duration['value'] == 0 ? __('No Limit', 'tutor-pro') : $time_duration['value'].' '.$week_values[$time_duration['time']],
                'is_expired'    => ($time_duration['value'] == 0 ? false : ($now > $remaining_time ? true : false)),
                'expire_date'   => $time_duration['value'] == 0 ? __('No Limit', 'tutor-pro') : date(get_option('date_format'), $remaining_time),
                'expire_month'   => $time_duration['value'] == 0 ? __('No Limit', 'tutor-pro') : date('n', $remaining_time)
            );
        }
        return false;
    }

    /**
     * Quiz info time_limit|remaining_attempt|is_attempt_available
     *
     * @param  $quiz_id int | required
     * @return array
     * @since  1.9.10
     */
    public static function quiz_info(int $quiz_id): array {
        $quiz_id            = sanitize_text_field($quiz_id);
        $time_limit         = tutor_utils()->get_quiz_option($quiz_id, 'time_limit.time_value');
        $time_type          = tutor_utils()->get_quiz_option($quiz_id, 'time_limit.time_type');
        $previous_attempts  = tutor_utils()->quiz_attempts($quiz_id);
        $attempted_count    = is_array($previous_attempts) ? count($previous_attempts) : 0;

        $attempts_allowed   = tutor_utils()->get_quiz_option(get_the_ID(), 'attempts_allowed', 0);
        $attempt_remaining  = $attempts_allowed - $attempted_count;
        $is_attempt_available = false;

        if ($attempts_allowed == 0 ) {
            $is_attempt_available = true;
        } else {
            if ($attempt_remaining ) {
                $is_attempt_available = true;
            } else {
                $is_attempt_available = false;
            }
        }
        $available_time_types = array(
            'seconds'   => __('Seconds', 'tutor-pro'),
            'minutes'   => __('Minutes', 'tutor-pro'),
            'weeks'     => __('Weeks', 'tutor-pro'),
            'days'      => __('Days', 'tutor-pro'),
            'hours'     => __('Hours', 'tutor-pro'),
        );
        return array(
            'time_limit'            => $time_limit.' '.$available_time_types[$time_type],
            'is_attempt_available'  => $is_attempt_available,
            'attempt_remaining'     => $attempts_allowed == 0 ? __('No Limit', 'tutor-pro') : $attempt_remaining,
        );
    }

    /**
     * Handle ajax post request
     * 
     * merge assignment info with assignment post data
     * 
     * @return string
     * 
     * @since 1.9.10
     */
    public function get_calendar_materials() {
        tutor_utils()->checking_nonce();
        global $wpdb;
        $year     = isset($_POST['year']) ? sanitize_text_field($_POST['year']) : '';
        $month    = isset($_POST['month']) ? sanitize_text_field($_POST['month']) : '';
        $month    = 1 + $month;
        $response = '';
        $user_id = get_current_user_id();
        $enrolled_courses = tutor_utils()->get_enrolled_courses_by_user($user_id);
    
        if (false === $enrolled_courses ) {
            $data = [];
        } else {
            $data = [0];
            foreach ( $enrolled_courses->posts as $key => $course ) {
                $topics = tutor_utils()->get_topics($course->ID);
                foreach ( $topics->posts as $topic ) {
                    $data[] = $topic->ID; 
                }
            }
            
            $data = implode(',', $data);
            $results = $wpdb->get_results(
                $wpdb->prepare(
                    " SELECT ID, DATE (post_date) AS post_date, MONTH(post_date) AS month, DATE(post_date) AS created_at, post_title, post_content, guid, post_type 
                        FROM {$wpdb->posts} 
                        WHERE post_parent IN  ({$data})
                            AND post_type IN ('tutor_assignments')
                            AND post_status = %s
                            
                            AND YEAR(post_date) = {$year}
                        GROUP BY post_date
                        ORDER BY post_date ASC
                    ",
                    'publish'
                )
            );
            $response = [];
            foreach ( $results as $result ) {
                $result->post_date = \tutor_get_formated_date(get_option('date_format'), $result->post_date);
                $result->assignment_info = self::assignment_info($result->ID);
            }
            $overdue    = 0;
            $upcoming   = 0;
            foreach( $results as $r ) {
                $r->assignment_info['is_expired'] ? $overdue++ : $upcoming++;
                if ( $r->month == $month || $r->assignment_info['expire_month'] == $month ) {
                    array_push( $response, $r );
                }
            } 
            $data = array(
                'response'  => $response,
                'overdue'   => $overdue,
                'upcoming'  => $upcoming
            );
        }
        wp_send_json_success($data);
        exit;
    }
}