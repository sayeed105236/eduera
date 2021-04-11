<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructor_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}


	public function get_enrollment_history_by_instructor_id($instructor_id, $date_range){

		$query = $this->db->query('SELECT enrollment.enrolled_price, enrollment.user_id, enrollment.course_id, enrollment_payment.amount, course.title, course.instructor_id, user.first_name, user.last_name FROM `enrollment` JOIN enrollment_payment ON enrollment.id= enrollment_payment.enrollment_id JOIN course ON enrollment.course_id= course.id JOIN user ON enrollment.user_id = user.id WHERE course.instructor_id = '.$instructor_id.' and enrollment_payment.status="accepted" and enrollment.created_at >= DATE(NOW()) - INTERVAL '.$date_range.' ORDER BY enrollment.id ');
		return  $query->result();
	}


	public function get_sum_of_withdraw_amount($instructor_id){

		$query = $this->db->query('SELECT SUM(withdraw_amount) as total_withdraw_amount FROM `instructor_payment` WHERE instructor_id = '.$instructor_id.'  ');
		return  $query->result();
	}


	/*
		    * Retrieve all courses with student and all details
	*/
	public function get_course_list_with_enrollment( $date_range=null, $attribute_list, $return_type, $filter_list = null,$method_name= null, $search_text = null, $limit = null) {


		$vat_tax=  $this->crud_model->get_settings_info(array('vat', 'tax'));
		$vatTax =  $vat_tax['vat']+$vat_tax['tax'];


		$add_grouping_query = false;

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		// foreach ($attribute_list as $attribute) {
		// 	$this->db->select('course.' . $attribute);
		// }

		foreach ($attribute_list as $table => $attribute) {
			foreach ($attribute as $attribute_name) {
				$this->db->select($table . '.' . $attribute_name);
			}
		}

		$this->db->select('COUNT(course.id) as "enrollment_count"');
		
		// $this->db->select('enroll.id as "enrollment_count"');

		if ($filter_list !== null && count($filter_list) > 0) {
			$add_grouping_query = true;
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}

		$this->db->from('course');

		// if ($search_text !== null) {
		// 	if ($add_grouping_query) {
		// 		$this->db->group_start();
		// 	}

		// 	$this->db->like('title', $search_text, 'both');

		// 	if ($add_grouping_query) {
		// 		$this->db->group_end();
		// 	}

		// }

		$this->db->join('enrollment', 'course.id = enrollment.course_id', 'LEFT');
		$this->db->join('user', 'enrollment.user_id = user.id', 'LEFT');
		if($date_range != NULL){
			if($date_range != 'all' ){
				$this->db->where('enrollment.created_at >= DATE(NOW()) - INTERVAL '.$date_range);

			}
		}
		

		if($method_name == 'total_sell'){
			$this->db->join('enrollment_payment', 'enrollment.id = enrollment_payment.enrollment_id', 'LEFT');
			$this->db->where('enrollment_payment.status="accepted"');
			$this->db->where('enrollment_payment.amount > 0 and enrollment_payment.amount <= 4600');
			// $this->db->select('SUM(round((course.instructor_share*enrollment_payment.amount)/100)) as "total_profit",  COUNT(enrollment_payment.id) as "sell_count"');

			$this->db->select('(round(SUM((enrollment_payment.amount - (enrollment_payment.amount)*("'.$vatTax.'")/100))*course.instructor_share/100)) as "total_profit",  COUNT(enrollment_payment.id) as "sell_count"');
		}

		

		$this->db->group_by("course.id");

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		}

		// $this->db->select('ua.id, ua.set_id, sq.question_id, q.question, q.right_option_value, aa.given_answer');
		// $this->db->from('user_assessment as ua');
		// $this->db->where('ua.id', $assessment_id);
		// $this->db->join('set_question as sq', 'sq.set_id = ua.set_id', 'LEFT');
		// $this->db->join('question as q', 'q.id = sq.question_id', 'LEFT');
		// $this->db->join('assessment_answer as aa', 'aa.assessment_id = ua.id AND aa.question_id = q.id', 'LEFT');
		// return $this->db->get()->result_array();

		// SELECT course.id, course.title, COUNT(course.id) as "Enrollment count" FROM course LEFT JOIN enroll ON course.id = enroll.course_id GROUP BY Course.id

	}

	public function get_instructor_payment_withdraw_details($return_type, $attribute_list, $filter_list = null) {

		// if ($limit != null) {
		// 	$this->db->limit($limit['limit'], $limit['offset']);
		// }

		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}

		$this->db->from("instructor_payment");


		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}


	public function get_instructor_total_withdraw_amount($return_type, $attribute_list, $filter_list = null) {

		// if ($limit != null) {
		// 	$this->db->limit($limit['limit'], $limit['offset']);
		// }

		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}

		$this->db->select('SUM(withdraw_amount) as "total_withdraw_amount"');
		$this->db->from("instructor_payment");


		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}


	public function insertUserQuestionAndAnswer($data){
		if ($this->db->insert('question_and_ans', $data)) {
			return array('success' => true, 'message' => 'Question Insert Successfully');
		} else {
			return array('success' => false, 'message' => 'Failed to insert question for db error');
		}
	}

	/*get question and answer retrieved data*/

	public function get_question_and_answer($course_id){

		$query = $this->db->query('SELECT question_and_ans.id, question_and_ans.title, question_and_ans.description, question_and_ans.created_at,  user.first_name, user.last_name, user.profile_photo_name FROM `question_and_ans` JOIN user ON user.id= question_and_ans.user_id WHERE question_and_ans.course_id = '.$course_id.' ORDER BY question_and_ans.id DESC');
		return  $query->result();
	}


	public function get_specific_question_and_answer($return_type, $attribute_list, $filter_list = null) {

		// if ($limit != null) {
		// 	$this->db->limit($limit['limit'], $limit['offset']);
		// }

		foreach ($attribute_list as $table => $attribute) {
			foreach ($attribute as $attribute_name) {
				$this->db->select($table . '.' . $attribute_name);
			}
		}

		$this->db->from("question_and_ans");
		$this->db->join('user', 'question_and_ans.user_id = user.id', 'LEFT');


		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}

	public function get_all_replay_message_list($return_type, $attribute_list, $filter_list = null){
		

		foreach ($attribute_list as $table => $attribute) {
			foreach ($attribute as $attribute_name) {
				$this->db->select($table . '.' . $attribute_name);
			}
		}

		$this->db->from("question_replay");
		$this->db->join('user', 'question_replay.user_id = user.id', 'LEFT');




		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}


	public function insertReplayMessage($data){
		if ($this->db->insert('question_replay', $data)) {
			return array('success' => true, 'message' => 'Message Insert Successfully');
		} else {
			return array('success' => false, 'message' => 'Failed to insert message for db error');
		}
	}

	public function insertAnnouncement($data){
		if ($this->db->insert('announcement', $data)) {
			return array('success' => true, 'message' => 'Announcement Insert Successfully');
		} else {
			return array('success' => false, 'message' => 'Failed to insert announcement for db error');
		}
	}

	public function get_all_announcement($return_type, $attribute_list, $filter_list = null) {

		// if ($limit != null) {
		// 	$this->db->limit($limit['limit'], $limit['offset']);
		// }

		foreach ($attribute_list as $table => $attribute) {
			foreach ($attribute as $attribute_name) {
				$this->db->select($table . '.' . $attribute_name);
			}
		}

		$this->db->from("announcement");
		$this->db->join('user', 'announcement.instructor_id = user.id', 'LEFT');


		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		}else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		}else {
			return null;
		}
	}

	public function remove_announcement($announcement_id){
		$this->db->where('id', $announcement_id);
        $result = $this->db->delete('announcement');

        if ($result) {
        	return array('success' => true, 'message' => 'Announcement removed Successfully');
        } else {
        	return array('success' => false, 'message' => 'Failed to remove announcement for db error');
        }
	}

	public function updateAnnouncement($id, $data) {
		$this->db->set($data);
		$this->db->where('id', $id);
		$response =  $this->db->update('announcement');

		if ($response) {
        	return array('success' => true, 'message' => 'Announcement updated successfully');
        } else {
        	return array('success' => false, 'message' => 'Failed to update announcement for db error');
        }
	}


	/*
		    * Retrieve all courses with student and all details
	*/
	public function get_course_list_with_user_enrollment( $date_range=null, $attribute_list, $return_type, $filter_list = null,$method_name= null, $search_text = null, $limit = null) {

		$add_grouping_query = false;

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}


		foreach ($attribute_list as $table => $attribute) {
			foreach ($attribute as $attribute_name) {
				$this->db->select($table . '.' . $attribute_name);
			}
		}

	

		if ($filter_list !== null && count($filter_list) > 0) {
			$add_grouping_query = true;
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}

		$this->db->from('course');

		
		$this->db->join('enrollment', 'course.id = enrollment.course_id', 'LEFT');
		$this->db->join('user', 'enrollment.user_id = user.id', 'LEFT');
		$this->db->join('enrollment_payment', 'enrollment.id = enrollment_payment.enrollment_id', 'LEFT');
		if($date_range != NULL){
			if($date_range != 'all' ){
				$this->db->where('enrollment.created_at >= DATE(NOW()) - INTERVAL '.$date_range);

			}
		}
		

		// if($method_name == 'total_sell'){
		// 	$this->db->join('enrollment_payment', 'enrollment.id = enrollment_payment.enrollment_id', 'LEFT');
		// 	$this->db->where('enrollment_payment.status="accepted"');
		// 	$this->db->where('enrollment_payment.amount > 1 and enrollment_payment.amount <= 4600');
		// 	$this->db->select('SUM(round((course.instructor_share*enrollment_payment.amount)/100)) as "total_profit",  COUNT(enrollment_payment.id) as "sell_count"');
		// }

		

		// $this->db->group_by("course.id");
// 
		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		}

		// $this->db->select('ua.id, ua.set_id, sq.question_id, q.question, q.right_option_value, aa.given_answer');
		// $this->db->from('user_assessment as ua');
		// $this->db->where('ua.id', $assessment_id);
		// $this->db->join('set_question as sq', 'sq.set_id = ua.set_id', 'LEFT');
		// $this->db->join('question as q', 'q.id = sq.question_id', 'LEFT');
		// $this->db->join('assessment_answer as aa', 'aa.assessment_id = ua.id AND aa.question_id = q.id', 'LEFT');
		// return $this->db->get()->result_array();

		// SELECT course.id, course.title, COUNT(course.id) as "Enrollment count" FROM course LEFT JOIN enroll ON course.id = enroll.course_id GROUP BY Course.id

	}


}	