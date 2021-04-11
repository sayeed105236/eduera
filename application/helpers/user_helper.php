<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

error_reporting(0);
ini_set('display_errors', 0);

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

if (!function_exists('has_role')) {
	function has_role($user_id, $role) {
		$CI = &get_instance();
		$CI->load->database();

		//$query = $CI->db->get_where('user' , array('id' => $user_id));
		$CI->db->select('role_list');
		$CI->db->from('user');
		$CI->db->where('id', $user_id);
		$role_list = json_decode($CI->db->get()->result()[0]->role_list);
		if (in_array($role, $role_list)) {
			return true;
		} else {
			return false;
		}

	}
}

if (!function_exists('is_course_in_wishlist')) {
	function is_course_in_wishlist($course_id, $user_id) {
		$CI = &get_instance();
		$CI->load->database();

		//$query = $CI->db->get_where('user' , array('id' => $user_id));

		$CI->db->select('wishlist');
		$CI->db->from('user');
		$CI->db->where('id', $user_id);
		$result = $CI->db->get()->result()[0]->wishlist;
		$wishlist = json_decode($result == null ? '[]' : $result);
		if (in_array($course_id, $wishlist)) {
			return true;
		} else {
			return false;
		}

	}
}

if (!function_exists('is_an_user_already_enrolled_in_a_course')) {
	/*
		    * Return if an user is already enrolled in a course or not
		    * Return true or false
	*/
	function is_an_user_already_enrolled_in_a_course($user_id, $course_id) {

		$CI = &get_instance();
		$CI->load->database();

		$CI->db->select("id");
		$CI->db->from("enrollment");
		$CI->db->where("user_id", $user_id);
		$CI->db->where("course_id", $course_id);
		$result = $CI->db->get()->result();

		if (count($result) > 0) {
			return $result[0]->id;
		} else {
			return false;
		}
	}
}

if (!function_exists('access_in_a_course')) {
	function access_in_a_course($user_id, $course_id) {
		$CI = &get_instance();
		$CI->load->database();

		$CI->db->select('enrollment.id, enrollment.course_id, enrollment.enrolled_price, enrollment.access, SUM(ep.amount) as paid_amount');
		$CI->db->from('enrollment');
		$CI->db->where('enrollment.user_id', $user_id);
		$CI->db->where('enrollment.course_id', $course_id);
		$CI->db->join('enrollment_payment as ep', 'enrollment.id = ep.enrollment_id', 'left');
		$CI->db->group_by('enrollment.id');
		$result = $CI->db->get()->result()[0];

		if ($result->id === null) {
			return array('has_enrolled' => false);
		} else {
			if ($result->enrolled_price == 0) {
				$largest_access_percentage = 100;
			} else {
				$access_percentage_list = array(
					$result->access, // access given by admin
					round(($result->paid_amount * 100) / $result->enrolled_price), // access based on user's payment
					30, // default access
				);

				$largest_access_percentage = 0;
				foreach ($access_percentage_list as $access_amount) {
					if ($access_amount > $largest_access_percentage) {
						$largest_access_percentage = $access_amount > 100 ? 100 : $access_amount;
					}

				}
			}

			$lesson_list = $CI->lesson_model->get_lesson_list_by_course_id($course_id, array('id'));
			$access_lesson_number = round(($largest_access_percentage * count($lesson_list)) / 100);
			$result_to_send = array(
				'has_enrolled' => true,
				'enrollment_id' => $result->id,
				'access_percentage' => $largest_access_percentage,
				'lesson_id_list' => array(),
			);
			

			for ($i = 0; $i < $access_lesson_number; $i++) {
				array_push($result_to_send['lesson_id_list'], $lesson_list[$i]->id);
			}

			return $result_to_send;

		}
	}
}

if (!function_exists('is_an_user_instructor_in_this_course')) {
	/*
		    * Return if an user is instructor in this course or
		    * admin then he/she can see the video
		    * Return true or false
	*/
	function is_an_user_instructor_in_this_course($instructor_id, $course_id) {

		$CI = &get_instance();
		$CI->load->database();

		$CI->db->select("id");
		$CI->db->from("course");
		$CI->db->where("instructor_id", $instructor_id);
		$CI->db->where("id", $course_id);
		$result = $CI->db->get()->result();

		if (count($result) > 0) {
			return true;
		} else {
			return false;
		}
	}
}

if (!function_exists('get_total_course_duration')) {
	/*
		    * Return if an user is instructor in this course or
		    * admin then he/she can see the video
		    * Return true or false
	*/
	function get_total_course_duration($course_id) {

		$CI = &get_instance();
		$CI->load->database();

		$CI->db->select("SUM(duration_in_second) as total_course_duration");
		$CI->db->from("lesson");
		$CI->db->where("course_id", $course_id);
		$result = $CI->db->get()->result();

		if (count($result) > 0) {
			return $result[0];
		} else {
			return false;
		}
	}
}

if (!function_exists('is_admin_of_a_company')) {
	function is_admin_of_a_company($user_id, $company_id) {
		$CI = &get_instance();
		$CI->load->library('session');
		$CI->load->database();
		$company_user_response = $CI->db->get_where('company_user', array('user_id' => $user_id, 'company_id' => $company_id, 'corporate_role' => 'ADMIN'))->num_rows();
		if ($company_user_response > 0) {
			return true;
		} else {
			return false;
		}

	}
}

if (!function_exists('is_user_already_exist_in_a_company')) {
	function is_user_already_exist_in_a_company($user_id, $company_id) {
		$CI = &get_instance();
		$CI->load->library('session');
		$CI->load->database();
		$company_user_response = $CI->db->get_where('company_user', array('user_id' => $user_id, 'company_id' => $company_id))->num_rows();
		if ($company_user_response > 0) {
			return true;
		} else {
			return false;
		}

	}
}


if (!function_exists('is_user_exist_in_system')) {
	function is_user_exist_in_system($ip_address) {
		$CI = &get_instance();
		$CI->load->library('session');
		$CI->load->database();
		$company_user_response = $CI->db->get_where('user_chat_info', array('ip_address' => $ip_address))->num_rows();
		if ($company_user_response > 0) {
			return true;
		} else {
			return false;
		}

	}
}


if (!function_exists('is_user_exist_in_system_with_no_user')) {
	function is_user_exist_in_system_with_no_user($ip_address) {
		$CI = &get_instance();
		$CI->load->library('session');
		$CI->load->database();
		$company_user_response = $CI->db->get_where('user_chat_info', array('ip_address' => $ip_address, 'user_id' => 0))->num_rows();
		if ($company_user_response > 0) {
			return true;
		} else {
			return false;
		}

	}
}


/*
* get time (ago)
*/

if ( ! function_exists('time_elapsed_string'))
{

   function time_elapsed_string($time, $tense='ago') {
        // declaring periods as static function var for future use
        static $periods = array('year', 'month', 'day', 'hour', 'minute', 'second');
    
        // checking time format
        if(!(strtotime($time)>0)) {
            return trigger_error("Wrong time format: '$time'", E_USER_ERROR);
        }
    
        // getting diff between now and time
        $now  = new DateTime('now');
        $time = new DateTime($time);
        $diff = $now->diff($time)->format('%y %m %d %h %i %s');
        // combining diff with periods
        $diff = explode(' ', $diff);
        $diff = array_combine($periods, $diff);
        // filtering zero periods from diff
        $diff = array_filter($diff);
        // getting first period and value
        $period = key($diff);
        $value  = current($diff);
    
        // if input time was equal now, value will be 0, so checking it
        if(!$value) {
            $period = 'seconds';
            $value  = 0;
        } else {
            // converting days to weeks
            if($period=='day' && $value>=7) {
                $period = 'week';
                $value  = floor($value/7);
            }
            // adding 's' to period for human readability
            if($value>1) {
                $period .= 's';
            }
        }
    
        // returning timeago
        return "$value $period $tense";
    }

}

if (!function_exists('get_user_enrolled_course_expiry_date')) {
	/*
		    * Return if an user is already enrolled in a course or not
		    * Return true or false
	*/
	function get_user_enrolled_course_expiry_date($user_id, $course_id) {

		$CI = &get_instance();
		$CI->load->database();

		$CI->db->select("expiry_date");
		$CI->db->from("enrollment");
		$CI->db->where("user_id", $user_id);
		$CI->db->where("course_id", $course_id);
		$result = $CI->db->get()->result();

		if (count($result) > 0) {
			return $result[0]->expiry_date;
		} else {
			return false;
		}
	}
}


// ------------------------------------------------------------------------
/* End of file user_helper.php */
/* Location: ./system/helpers/user_helper.php */
