<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* CodeIgniter
*
* An open source application development framework for PHP 5.1.6 or newer
*
* @package		CodeIgniter
* @author		ExpressionEngine Dev Team
* @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
* @license		http://codeigniter.com/user_guide/license.html
* @link		http://codeigniter.com
* @since		Version 1.0
* @filesource
*/

function debug($str)
{
    echo "<pre>";
    var_dump($str);
    echo "</pre>";
}


if (! function_exists('get_settings')) {
    function get_settings($key = '') {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->where('key', $key);
        $result = $CI->db->get('settings')->row()->value;
        return $result;
    }
}

if (! function_exists('currency')) {
    function currency($price = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        if ($price != "") {
            $CI->db->where('key', 'system_currency');
            $currency_code = $CI->db->get('settings')->row()->value;

            $CI->db->where('code', $currency_code);
            $symbol = $CI->db->get('currency')->row()->symbol;

            $CI->db->where('key', 'currency_position');
            $position = $CI->db->get('settings')->row()->value;

            if ($position == 'right') {
                return $price.$symbol;
            }elseif ($position == 'right-space') {
                return $price.' '.$symbol;
            }elseif ($position == 'left') {
                return $symbol.$price;
            }elseif ($position == 'left-space') {
                return $symbol.' '.$price;
            }
        }
    }
}

if (! function_exists('currency_code_and_symbol')) {
    function currency_code_and_symbol($type = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        $CI->db->where('key', 'system_currency');
        $currency_code = $CI->db->get('settings')->row()->value;

        $CI->db->where('code', $currency_code);
        $symbol = $CI->db->get('currency')->row()->symbol;
        if ($type == "") {
            return $symbol;
        }else {
            return $currency_code;
        }

    }
}

// if (! function_exists('get_frontend_settings')) {
//     function get_frontend_settings($key = '') {
//         $CI	=&	get_instance();
//         $CI->load->database();

//         $CI->db->where('key', $key);
//         $result = $CI->db->get('frontend_settings')->row()->value;
//         return $result;
//     }
// }

if ( ! function_exists('slugify'))
{
    function slugify($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        //$text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        return 'n-a';
        return $text;
    }
}

if ( ! function_exists('get_video_extension'))
{
    // Checks if a video is youtube, vimeo or any other
    function get_video_extension($url) {
        if (strpos($url, '.mp4') > 0) {
            return 'mp4';
        } elseif (strpos($url, '.webm') > 0) {
            return 'webm';
        } else {
            return 'unknown';
        }
    }
}

if ( ! function_exists('ellipsis'))
{
    // Checks if a video is youtube, vimeo or any other
    function ellipsis($long_string, $max_character = 30) {
        $short_string = strlen($long_string) > $max_character ? substr($long_string, 0, $max_character)."..." : $long_string;
        return $short_string;
    }
}

// This function helps us to decode the theme configuration json file and return that array to us
if ( ! function_exists('themeConfiguration'))
{
    function themeConfiguration($theme, $key = "")
    {
        $themeConfigs = [];
        if (file_exists('assets/frontend/'.$theme.'/config/theme-config.json')) {
            $themeConfigs = file_get_contents('assets/frontend/'.$theme.'/config/theme-config.json');
            $themeConfigs = json_decode($themeConfigs, true);
            if ($key != "") {
                if (array_key_exists($key, $themeConfigs)) {
                    return $themeConfigs[$key];
                } else {
                    return false;
                }
            }else {
                return $themeConfigs;
            }
        } else {
            return false;
        }
    }
}

// Human readable time
if ( ! function_exists('readable_time_for_humans')){
    function readable_time_for_humans($duration) {
        if ($duration) {
            $duration_array = explode(':', $duration);
            $hour   = $duration_array[0];
            $minute = $duration_array[1];
            $second = $duration_array[2];
            if ($hour > 0) {
                $duration = $hour.' '.get_phrase('hr').' '.$minute.' '.get_phrase('min');
            }elseif ($minute > 0) {
                if ($second > 0) {
                    $duration = ($minute+1).' '.get_phrase('min');
                }else{
                    $duration = $minute.' '.get_phrase('min');
                }
            }elseif ($second > 0){
                $duration = $second.' '.get_phrase('sec');
            }else {
                $duration = '00:00';
            }
        }else {
            $duration = '00:00';
        }
        return $duration;
    }
}

if ( ! function_exists('trimmer'))
{
    function trimmer($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        return 'n-a';
        return $text;
    }
}

if ( ! function_exists('lesson_progress'))
{
    function lesson_progress($lesson_id = "", $user_id = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        if ($user_id == "") {
            $user_id = $CI->session->userdata('user_id');
        }
        $user_details = $CI->user_model->get_all_user($user_id)->row_array();
        $watch_history_array = json_decode($user_details['watch_history'], true);
        for ($i = 0; $i < count($watch_history_array); $i++) {
          $watch_history_for_each_lesson = $watch_history_array[$i];
          if ($watch_history_for_each_lesson['lesson_id'] == $lesson_id) {
              return $watch_history_for_each_lesson['progress'];
          }
        }
        return 0;
    }
}
if ( ! function_exists('course_progress'))
{
    function course_progress($course_id = "", $user_id = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        if ($user_id == "") {
            $user_id = $CI->session->userdata('user_id');
        }
        $user_details = $CI->user_model->get_all_user($user_id)->row_array();

        // this array will contain all the completed lessons from different different courses by a user
        $completed_lessons_ids = array();

        // this variable will contain number of completed lessons for a certain course. Like for this one the course_id
        $lesson_completed = 0;

        // User's watch history
        $watch_history_array = json_decode($user_details['watch_history'], true);
        // desired course's lessons
        $lessons_for_that_course = $CI->crud_model->get_lessons('course', $course_id);
        // total number of lessons for that course
        $total_number_of_lessons = $lessons_for_that_course->num_rows();
        // arranging completed lesson ids
        for ($i = 0; $i < count($watch_history_array); $i++) {
          $watch_history_for_each_lesson = $watch_history_array[$i];
          if ($watch_history_for_each_lesson['progress'] == 1) {
              array_push($completed_lessons_ids, $watch_history_for_each_lesson['lesson_id']);
          }
        }

        foreach ($lessons_for_that_course->result_array() as $row) {
          if (in_array($row['id'], $completed_lessons_ids)) {
              $lesson_completed++;
          }
        }

        // calculate the percantage of progress
        if($total_number_of_lessons == 0)
        {
            $course_progress = 0;
        }
        else
        {
            $course_progress = ($lesson_completed / $total_number_of_lessons) * 100;
        }
        
        return $course_progress;
    }
}


if (! function_exists('second_to_time_conversion')) {
    function second_to_time_conversion($seconds = '') {
        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);

        return ($hours < 10 ? '0'. $hours : $hours).":". ($mins < 10 ? '0'. $mins : $mins).":".($secs < 10 ? '0'. $secs : $secs);
    }
}


if (!function_exists('get_course_discounted_price')) {
    /*
            * Return if an user is instructor in this course or
            * admin then he/she can see the video
            * Return true or false
    */
    function get_course_discounted_price($course_id) {

        $CI = &get_instance();
        $CI->load->database();

        
        $CI->db->select("price, discounted_price, discount_flag");
        $CI->db->from("course");
        $CI->db->where("id", $course_id);
        $result = $CI->db->get()->result();

        if (count($result) > 0) {
            if($result[0]->discounted_price > 0){
               return get_usd_price($result[0]->discounted_price);
            }
           
        } else {
            return false;
        }
    }
}


if (!function_exists('get_course_price')) {
    /*
            * Return if an user is instructor in this course or
            * admin then he/she can see the video
            * Return true or false
    */
    function get_course_price($course_id) {

        $CI = &get_instance();
        $CI->load->database();

        
        $CI->db->select("price");
        $CI->db->from("course");
        $CI->db->where("id", $course_id);
        $result = $CI->db->get()->result();

        if (count($result) > 0) {
            if($result[0]->price > 0){
               return get_usd_price($result[0]->price);
            }
           
        } else {
            return false;
        }
    }
}


if (!function_exists('get_usd_price')) {
    /*
            * Return if an user is instructor in this course or
            * admin then he/she can see the video
            * Return true or false
    */
    function get_usd_price($price) {

        $CI = &get_instance();
        $CI->load->database();

        
        $CI->db->from("currencies");
        $CI->db->where("name", 'USD');
        $result = $CI->db->get()->result();

        if (count($result) > 0) {
            if($result[0]->value > 0){
                return  $result[0]->sign. '' . round($price/$result[0]->value);
            }
           
        } else {
            return false;
        }
    }
}


if (!function_exists('get_usd_price_without_sign')) {
    /*
            * Return if an user is instructor in this course or
            * admin then he/she can see the video
            * Return true or false
    */
    function get_usd_price_without_sign($price) {

        $CI = &get_instance();
        $CI->load->database();

        
        $CI->db->from("currencies");
        $CI->db->where("name", 'USD');
        $result = $CI->db->get()->result();

        if (count($result) > 0) {
            if($result[0]->value > 0){
                return   round($price/$result[0]->value);
            }
           
        } else {
            return false;
        }
    }
}


if (!function_exists('get_bdt_price')) {
    /*
            * Return if an user is instructor in this course or
            * admin then he/she can see the video
            * Return true or false
    */
    function get_bdt_price($price) {

        $CI = &get_instance();
        $CI->load->database();

        
        $CI->db->from("currencies");
        $CI->db->where("name", 'USD');
        $result = $CI->db->get()->result();

        if (count($result) > 0) {
            if($result[0]->value > 0){
                return   round($price*$result[0]->value);
            }
           
        } else {
            return false;
        }
    }
}


if (!function_exists('is_our_member_in_eduera')) {
    /*
            * Return if an user is instructor in this course or
            * admin then he/she can see the video
            * Return true or false
    */
    function is_our_member_in_eduera($user_id) {

        $CI = &get_instance();
        $CI->load->database();

        $CI->db->select("membership_type");
        $CI->db->from("membership_payment");
        $CI->db->where("user_id", $user_id);
        $result = $CI->db->get()->result();

        if (isset($result)) {
            return $result;
        } else {
            return false;
        }
    }
}


if (!function_exists('get_user_country')) {
    /*
            * Return if an user is instructor in this course or
            * admin then he/she can see the video
            * Return true or false
    */
    function get_user_country() {
        $CI = &get_instance();

           // You may need to load the model if it hasn't been pre-loaded
           $CI->load->model('user_model');
        $result =  $CI->user_model->getUserInfoByIpAddress();

        if (isset($result)) {
            return $result;
        } else {
            return 'bd';
        }
    }
}


if (!function_exists('get_currency_price')) {
    /*
            * Return if an user is instructor in this course or
            * admin then he/she can see the video
            * Return true or false
    */
    function get_currency_price() {

        $CI = &get_instance();
        $CI->load->database();

        
        $CI->db->from("currencies");
        $CI->db->where("name", 'USD');
        $result = $CI->db->get()->result();

        return $result[0]->value;
        // if (count($result) > 0) {
        //     if($result[0]->value > 0){
        //         return  $result[0]->sign. '' . round($price/$result[0]->value);
        //     }
           
        // } else {
        //     return false;
        // }
    }
}


// ------------------------------------------------------------------------
/* End of file common_helper.php */
/* Location: ./system/helpers/common.php */
