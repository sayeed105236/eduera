<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson_model extends CI_Model {

	function __construct() {
		parent::__construct();

		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	/*
		  	*	Retrieve lession list of a course
	*/
	public function get_lesson_list_by_course_id($course_id, $attribute_list, $filter_list=null) {
		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}
		$this->db->from("lesson");
		$this->db->where("course_id", $course_id);
		$lesson_list = $this->db->get()->result();
		return $lesson_list;
	}

	/*
		  	*	Retrieve lession list of a section
	*/
	public function get_lesson_list_by_section_id($section_id, $attribute_list) {
		$sql = "SELECT ";
		$attribute_array = array();
		foreach ($attribute_list as $attribute) {
			$attribute_array[] = $attribute;
		}
		$sql .= implode(', ', $attribute_array);
		$sql .= " FROM lesson WHERE section_id = ? ORDER BY rank";
		return $this->db->query($sql, array($section_id))->result();

		// foreach ($attribute_list as $attribute) {
		// 	$this->db->select(''.$attribute);
		// }
		// $this->db->from("lesson");
		// $this->db->where("section_id", $section_id);

		// return $this->db->get()->result();
	}

	/*
		  	* Retrieve all lesson
	*/
	public function get_lesson_list($return_type, $attribute_list, $filter_list = null, $limit = null) {

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}
		$this->db->from("lesson");

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

	/*
			    * Retrieve user lession status list by user
	*/
	public function get_lesson_status($return_type, $attribute_list, $filter_list = null, $limit = null) {

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}
		$this->db->from("user_lesson_status");

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

	public function get_lesson_list_by_users_status($user_id, $return_type, $attribute_list, $filter_list = null) {

		$this->db->distinct('DISTINCT user_lesson_status.lesson_id', false);


		foreach ($attribute_list as $table => $attribute) {
			foreach ($attribute as $attribute_name) {
				$this->db->select($table . '.' . $attribute_name);
			}
		}
		
		$this->db->from("lesson");
		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}

		$this->db->join('user_lesson_status', 'user_lesson_status.lesson_id = lesson.id AND user_lesson_status.user_id = ' . $user_id);
		// $this->db->order_by('lesson.rank', "ASC");
		// $this->db->select('user_lesson_status.updated_at');
		$this->db->select_max('user_lesson_status.finished_time', 'finished_time');
		$this->db->group_by('user_lesson_status.lesson_id');
		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}

	/*
		* Insert and update user lesson status
	*/
	public function update_user_lesson_status($data, $id = "") {
		if ($id) {

			$this->db->set($data);
			$this->db->where('id', $id);
			if ($this->db->update('user_lesson_status')) {
				return array("success" => true);
			} else {
				return array("success" => false, "message" => "Failed to updated in db");
			}
		} else {
			if ($this->db->insert('user_lesson_status', $data)) {
				return array("success" => true, "id" => $this->db->insert_id());
			} else {
				return array("success" => false, "message" => "Failed to insert in db");
			}
		}

	}

}
