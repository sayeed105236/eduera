<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends CI_Model {

	function __construct() {
		parent::__construct();

		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	// New code

	// public function get_quiz_set_list($return_type, $with_question, $attribute_list, $filter_list = null, $limit = null) {

	// 	if ($limit != null) {
	// 		$this->db->limit($limit['limit'], $limit['offset']);
	// 	}

	// 	foreach ($attribute_list as $table => $attribute) {
	// 		foreach ($attribute as $attribute_name) {
	// 			$this->db->select($table . '.' . $attribute_name);
	// 		}
	// 	}
	// 	$this->db->from("quiz_set");

	// 	if ($filter_list !== null && count($filter_list) > 0) {
	// 		foreach ($filter_list as $filter_key => $filter_value) {
	// 			$this->db->where('' . $filter_key, $filter_value);
	// 		}
	// 	}
	// 	$this->db->join('lesson', 'quiz_set.lesson_id = lesson.id', 'LEFT');
	// 	if ($return_type == "OBJECT") {
	// 		$quiz_set_list = $this->db->get()->result();
	// 		if ($with_question) {

	// 			for ($i = 0; $i < count($quiz_set_list); $i++) {
	// 				$quiz_set_list[$i]->question_id_list = json_decode($quiz_set_list[$i]->question_id_list);
	// 				$quiz_set_list[$i]->question_list = array();
	// 				for ($j = 0; $j < count($quiz_set_list[$i]->question_id_list); $j++) {
	// 					array_push($quiz_set_list[$i]->question_list, $this->get_question_list("OBJECT", array('id', 'question', 'option_list', 'right_option_value', 'explanation'), array('id' => $quiz_set_list[$i]->question_id_list[$j]))[0]);
	// 				}
	// 			}
	// 		}
	// 		return $quiz_set_list;
	// 	} else if ($return_type == "COUNT") {
	// 		return $this->db->get()->num_rows();
	// 	} else {
	// 		return null;
	// 	}
	// }

	public function get_quiz_set_list($return_type, $with_question, $attribute_list, $filter_list = null, $limit = null) {
		
	
		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		foreach ($attribute_list as $table => $attribute) {
			foreach ($attribute as $attribute_name) {
				$this->db->select($table . '.' . $attribute_name);
			}
		}
		$this->db->from("quiz_set");

		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}
		if(isset($filter_list['quiz_set.lesson_id']) && $filter_list['quiz_set.lesson_id'] != null){
			$this->db->join('lesson', 'quiz_set.lesson_id = lesson.id', 'LEFT');
		}
		// $this->db->join('lesson', 'quiz_set.lesson_id = lesson.id', 'LEFT');

		if ($return_type == "OBJECT") {
			$quiz_set_list = $this->db->get()->result();
			if ($with_question) {

				for ($i = 0; $i < count($quiz_set_list); $i++) {
					$quiz_set_list[$i]->question_id_list = json_decode($quiz_set_list[$i]->question_id_list);
					$quiz_set_list[$i]->question_list = array();
					for ($j = 0; $j < count($quiz_set_list[$i]->question_id_list); $j++) {
						array_push(
							$quiz_set_list[$i]->question_list, 
							isset(($this->get_question_list("OBJECT", array('id', 'question', 'question_img', 'option_list', 'right_option_value', 'explanation'), array('id' => $quiz_set_list[$i]->question_id_list[$j]))[0])) ? ($this->get_question_list("OBJECT", array('id', 'question', 'question_img', 'option_list', 'right_option_value', 'explanation'), array('id' => $quiz_set_list[$i]->question_id_list[$j]))[0]) : NULL
						);
					}
				}
			}
			return $quiz_set_list;
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}



	public function get_question_list($return_type, $attribute_list, $filter_list = null) {

		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}
		$this->db->from("question");

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


	


	public function get_all_question_by_course_id($return_type , $course_id, $question=null, $limit=null, $filter_list = null) {
		
		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		// foreach ($attribute_list as $attribute) {
		// 	$this->db->select('' . $attribute);
		// }

		$this->db->where('course_id', $course_id);
		if($question != null){
			$this->db->like('question', $question, 'both');
		}
		$this->db->from('question');

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


		// return $query = $this->db->get('question')->result();
	}

	/*
		    *   Saving user assessment
	*/
	public function insertUserAssessment($data) {
		// date_default_timezone_set('Asia/Dhaka');
		// $data['created_at'] = date("Y-m-d H:i:s");
		if($this->db->insert('user_assessment', $data)){
			return true;
		}else{
			return false;
		}
		// return $this->db->insert_id();
	}

	// Above code are new.
	/////////////////////////////////////////////////////////////
	// Option
	/////////////////////////////////////////////////////////////

	/*
		    * Retrieve option list by question_id with value as a index.
	*/
	public function get_option_list_by_question_id_with_value_as_a_index($question_id) {
		$this->db->where('question_id', $question_id);
		// $this->db->order_by('value', 'ASC');
		$associative_array = [];

		foreach ($this->db->get('question_option')->result_array() as $option) {
			$associative_array[$option["value"]] = $option;
		}

		return $associative_array;
	}

	/*
		    * Retrieve option list by question_id with value as a index.
	*/
	public function get_option_list_by_question_id($question_id) {
		$this->db->where('question_id', $question_id);
		// $this->db->order_by('value', 'ASC');
		return $this->db->get('question_option')->result_array();
	}

	////////////////////////////////////////////////////////////
	// Question
	////////////////////////////////////////////////////////////

	/*
		    * Retrieve question by question_id, option list is not included.
	*/
	// public function get_question_by_id($param1) {
	//     if ($param1 == "") {
	//         return false;
	//     }
	//     $this->db->where('id', $param1);
	// // $this->db->order_by('id', 'ASC');
	//     return $this->db->get('question');
	// }

	/*
		    * Retrieve question by question_id, with option list.
	*/
	public function get_question_with_option_list_by_id($param1) {
		if ($param1 == "") {
			return false;
		}
		$this->db->where('id', $param1);
		// $this->db->order_by('id', 'ASC');
		$result = $this->db->get('question')->result_array()[0];
		$result["option_list"] = $this->get_option_list_by_question_id($result["id"]);
		return $result;
	}

	/*
		    * Get the number of question, by course_id
	*/
	public function get_number_of_question_by_course_id($course_id) {
		return count($this->get_question_list_by_course($course_id)->result_array());
	}

	/*
		    * Retrieve question list by course_id.
	*/
	public function get_question_list_by_course($param1) {
		if ($param1 != "") {
			$this->db->where('course_id', $param1);
		}
		// $this->db->order_by('id', 'ASC');
		return $this->db->get('question');
	}

	/*
		    * Retrieve question list with included option list, by course_id.
	*/
	public function get_question_list_with_options_by_course($param1 = "") {
		$question_list = $this->get_question_list_by_course($param1)->result_array();
		for ($i = 0; $i < count($question_list); $i++) {
			$question_list[$i]['option_list'] = $this->get_option_list_by_question_id_with_value_as_a_index($question_list[$i]["id"]);
		}
		return $question_list;
	}

	/*
		    * Get a set's question id list, by set id
	*/
	public function get_question_id_list_by_set_id($set_id) {
		if ($set_id == null || $set_id == "") {
			return false;
		}
		$this->db->select('question_id');
		$response_array = $this->db->get_where('set_question', array('set_id' => $set_id))->result_array();
		$result_array = [];
		foreach ($response_array as $ob) {
			array_push($result_array, $ob["question_id"]);
		}

		return $result_array;
	}

	/////////////////////////////////////////////////////////////
	// Quiz
	/////////////////////////////////////////////////////////////

	/*
		    * Get quiz set by set id, with questions and options
	*/
	public function get_quiz_set_by_id_with_questions_and_options($set_id) {
		$set = $this->db->get_where('quiz_set', array('id' => $set_id))->result_array()[0];
		$set["question_list"] = [];
		$question_id_list = $this->get_question_id_list_by_set_id($set_id);
		for ($i = 0; $i < count($question_id_list); $i++) {
			array_push($set["question_list"], $this->get_question_with_option_list_by_id($question_id_list[$i]));
		}
		return $set;
	}

	/*
		    * Get a quiz set list, by course id. It only returns the set info, not the question list.
	*/
	public function get_quiz_set_list_by_course_id($course_id, $type = "") {
		if ($course_id == null || $course_id == "") {
			return false;
		}
		if ($type == "START" || $type == "END") {
			$this->db->where("type", $type);
		}
		return $this->db->get_where('quiz_set', array('course_id' => $course_id))->result_array();
	}

	/*
		    * Get a quiz set list, by lesson id. It only returns the set info, not the question list.
	*/
	public function get_quiz_set_list_by_lesson_id($lesson_id, $type = "") {
		if ($lesson_id == null || $lesson_id == "") {
			return false;
		}
		if ($type == "START" || $type == "END") {
			$this->db->where("type", $type);
		}

		return $this->db->get_where('quiz_set', array('lesson_id' => $lesson_id))->result_array();
	}

	public function create_a_quiz_set_with_random_questions($course_id, $set_type, $set_lenght = "") {
		if ($course_id == null) {
			return flase;
		}

		if ($set_lenght == null || $set_lenght == "") {
			$set_lenght = 3;
		}

		$question_list = $this->get_question_list_by_course($course_id)->result_array();

		if ($set_lenght > count($question_list)) {
			$set_lenght = count($question_list);
		}

		$data = array(
			'type' => $set_type,
			'name' => 'Random set',
			'course_id' => $course_id,
		);

		$this->db->insert('quiz_set', $data);
		$set_id = $this->db->insert_id();

		for ($i = 0; $i < $set_lenght; $i++) {
			$question = array_splice($question_list, mt_rand(0, count($question_list) - 1), 1)[0];
			$data = array(
				'set_id' => $set_id,
				'question_id' => $question['id'],
			);
			$this->db->insert('set_question', $data);
		}

		return $set_id;
	}

	//////////////////////////////////////////////////////////////////////////

	/*
		    * Just insert question in question table, not any option.
	*/
	public function insert_question($question) {
		if (count($question) <= 0) {
			return false;
		}
		return $this->db->insert('question', $question);
	}

	/*
		    * Just insert option in option table, not any question.
	*/
	public function insert_question_option($question_option) {
		if (count($question_option) <= 0) {
			return false;
		}
		return $this->db->insert('question_option', $question_option);
	}

	/*
		    * Just insert set in quiz_set table, not anything else.
	*/
	// public function insert_set($set) {
	// 	if (count($set) <= 0) {
	// 		return false;
	// 	}
	// 	return $this->db->insert('quiz_set', $set);
	// }

	public function insert_set($data, $quiz_set_id = null) {
		if ($quiz_set_id == null) {

			if (count($data) <= 0) {
				return false;
			}

			if ($this->db->insert('quiz_set', $data)) {
				return array("success" => true, 'id' => $this->db->insert_id());
			} else {
				return array("success" => false, "message" => "Failed to insert in db");
			}	

		} else {

			$this->db->set($data);
			$this->db->where('id', $quiz_set_id);

			if ($this->db->update('quiz_set', $data)) {
				return array("success" => true);
			} else {
				return array("success" => false, "message" => "Failed to update in db");
			}
		}

	}

	/*
		    * Just insert set id and question id in set_question table, not anyting else.
	*/
	public function insert_in_set_question_table($set_question) {
		if (count($set_question) <= 0) {
			return false;
		}
		return $this->db->insert('set_question', $set_question);
	}

	/*
		    * Test
	*/
	public function test() {
		return "this is test for quiz controller";
	}

	//////////////////////////////////////////////////////////////////

	// public function getAssessmentQuestionWithRightAnswerAndGivenAnswer($assessment_id){

	//     $this->db->select('ua.id, ua.set_id, ua.question_and_answer_list, q.question, q.right_option_value, aa.given_answer');
	//     $this->db->from('user_assessment as ua');
	//     $this->db->where('ua.id', $assessment_id);
	//     $this->db->join('set_question as sq', 'sq.set_id = ua.set_id', 'LEFT');
	//     $this->db->join('question as q', 'q.id = sq.question_id', 'LEFT');
	//     $this->db->join('assessment_answer as aa', 'aa.assessment_id = ua.id AND aa.question_id = q.id', 'LEFT');
	//     return $this->db->get()->result_array();
	// }

	public function get_assessment_by_enroll_id($return_type, $attribute_list, $filter_list = null, $set_id= null) {

		foreach ($attribute_list as $table => $value) {
			foreach ($value as $attribute) {
				$this->db->select($table . '.' . $attribute);
			}
		}

		$this->db->from("user_assessment");

		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}

		$this->db->join('quiz_set', 'quiz_set.id = user_assessment.set_id', 'LEFT');

		if ($return_type == "OBJECT") {
			$result = $this->db->get()->result();
			for ($i = 0; $i < count($result); $i++) {
				$result[$i]->question_and_answer_list = json_decode($result[$i]->question_and_answer_list);
				$result[$i]->quiz = $this->get_quiz_set_list(
					"OBJECT",
					TRUE,
					array('quiz_set' => array('id', 'question_id_list')),
					array('id' => $result[$i]->set_id)
				)[0];


				for ($j = 0; $j < count($result[$i]->quiz->question_list); $j++) {
					$result[$i]->quiz->question_list[$j]->option_list = json_decode($result[$i]->quiz->question_list[$j]->option_list);
					for ($m = 0; $m < count($result[$i]->question_and_answer_list); $m++) {
						if ($result[$i]->question_and_answer_list[$m][0] == $result[$i]->quiz->question_list[$j]->id) {
							if (count($result[$i]->question_and_answer_list[$m]) == 2) {
								$result[$i]->quiz->question_list[$j]->given_answer = $result[$i]->question_and_answer_list[$m][1];
							} else {
								$result[$i]->quiz->question_list[$j]->given_answer = -1;
							}

						}
					}
				}

				$result[$i]->assessment_data = $this->getAssessmentData($result[$i]->quiz->question_list);

			}

			
			return $result;
		
			
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}

	}

	public function get_assessment_by_quiz_set_id($return_type, $attribute_list, $filter_list = null, $set_id= null) {

		foreach ($attribute_list as $table => $value) {
			foreach ($value as $attribute) {
				$this->db->select($table . '.' . $attribute);
			}
		}

		$this->db->from("user_assessment");

		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}

		$this->db->join('quiz_set', 'quiz_set.id = user_assessment.set_id', 'LEFT');
		if ($return_type == "OBJECT") {
			$result = $this->db->get()->result();
			for ($i = 0; $i < count($result); $i++) {
				$result[$i]->question_and_answer_list = json_decode($result[$i]->question_and_answer_list);
				$result[$i]->quiz = $this->get_quiz_set_list(
					"OBJECT",
					TRUE,
					array('quiz_set' => array('id', 'question_id_list')),
					array('id' => $result[$i]->set_id)
				)[0];


				for ($j = 0; $j < count($result[$i]->quiz->question_list); $j++) {
					$result[$i]->quiz->question_list[$j]->option_list = json_decode($result[$i]->quiz->question_list[$j]->option_list);
					for ($m = 0; $m < count($result[$i]->question_and_answer_list); $m++) {
						if ($result[$i]->question_and_answer_list[$m][0] == $result[$i]->quiz->question_list[$j]->id) {
							if (count($result[$i]->question_and_answer_list[$m]) == 2) {
								$result[$i]->quiz->question_list[$j]->given_answer = $result[$i]->question_and_answer_list[$m][1];
							} else {
								$result[$i]->quiz->question_list[$j]->given_answer = -1;
							}

						}
					}
					$result[$i]->assessment_data = $this->getAssessmentData($result[$i]->quiz->question_list);
				}

				

			}

			
			return $result;
		
			
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}

	}

	public function get_assessment_by_set_id($return_type, $set_id= null, $limit = null, $start_date = null, $end_date = null) {

		if ($limit != null) {
			if($start_date != null){
				$query = $this->db->query('SELECT user.first_name, user.last_name, user.email, enrollment.user_id, p.* FROM (SELECT DISTINCT(enrollment_id), max(created_at) AS created_at FROM user_assessment GROUP BY enrollment_id) AS mx JOIN user_assessment p ON mx.enrollment_id = p.enrollment_id AND mx.created_at = p.created_at JOIN enrollment ON p.enrollment_id=enrollment.id JOIN user ON enrollment.user_id=user.id WHERE set_id ='.$set_id.' AND p.created_at BETWEEN "' . $start_date . ' 00:00:00' . '" and "' . $end_date . ' 23:59:59'.'" ORDER BY enrollment_id LIMIT '.$limit['offset'] .','. $limit['limit']);
			}else{
				$query = $this->db->query('SELECT user.first_name, user.last_name, user.email, enrollment.user_id, p.* FROM (SELECT DISTINCT(enrollment_id), max(created_at) AS created_at FROM user_assessment GROUP BY enrollment_id) AS mx JOIN user_assessment p ON mx.enrollment_id = p.enrollment_id AND mx.created_at = p.created_at JOIN enrollment ON p.enrollment_id=enrollment.id JOIN user ON enrollment.user_id=user.id WHERE set_id ='.$set_id.' ORDER BY enrollment_id LIMIT '.$limit['offset'] .','. $limit['limit']);
			}
			
		}else{
			if($start_date != null){
			 	$query = $this->db->query('SELECT user.first_name, user.last_name, user.email, enrollment.user_id, p.* FROM (SELECT DISTINCT(enrollment_id), max(created_at) AS created_at FROM user_assessment GROUP BY enrollment_id) AS mx JOIN user_assessment p ON mx.enrollment_id = p.enrollment_id AND mx.created_at = p.created_at JOIN enrollment ON p.enrollment_id=enrollment.id JOIN user ON enrollment.user_id=user.id WHERE set_id ='.$set_id.' AND p.created_at BETWEEN "' . $start_date . ' 00:00:00' . '" and "' . $end_date . ' 23:59:59'.'" ORDER BY enrollment_id ');
			}else{
				$query = $this->db->query('SELECT user.first_name, user.last_name, user.email, enrollment.user_id, p.* FROM (SELECT DISTINCT(enrollment_id), max(created_at) AS created_at FROM user_assessment GROUP BY enrollment_id) AS mx JOIN user_assessment p ON mx.enrollment_id = p.enrollment_id AND mx.created_at = p.created_at JOIN enrollment ON p.enrollment_id=enrollment.id JOIN user ON enrollment.user_id=user.id WHERE set_id ='.$set_id.' ORDER BY enrollment_id ');
			}
			
		}
		// foreach ($attribute_list as $table => $value) {
		// 	foreach ($value as $attribute) {
		// 		$this->db->select($table . '.' . $attribute);
		// 	}
		// }

		// $this->db->from("user_assessment");

		// if ($filter_list !== null && count($filter_list) > 0) {
		// 	foreach ($filter_list as $filter_key => $filter_value) {
		// 		$this->db->where('' . $filter_key, $filter_value);
		// 	}
		// }

		// $this->db->join('quiz_set', 'quiz_set.id = user_assessment.set_id', 'LEFT');
		

		if ($return_type == "OBJECT") {
			$result = $query->result();
			for ($i = 0; $i < count($result); $i++) {
				$result[$i]->question_and_answer_list = json_decode($result[$i]->question_and_answer_list);
				$result[$i]->quiz = $this->get_quiz_set_list(
					"OBJECT",
					TRUE,
					array('quiz_set' => array('id', 'question_id_list')),
					array('id' => $result[$i]->set_id)
				)[0];


				for ($j = 0; $j < count($result[$i]->quiz->question_list); $j++) {
					$result[$i]->quiz->question_list[$j]->option_list = json_decode($result[$i]->quiz->question_list[$j]->option_list);
					for ($m = 0; $m < count($result[$i]->question_and_answer_list); $m++) {
						if ($result[$i]->question_and_answer_list[$m][0] == $result[$i]->quiz->question_list[$j]->id) {
							if (count($result[$i]->question_and_answer_list[$m]) == 2) {
								$result[$i]->quiz->question_list[$j]->given_answer = $result[$i]->question_and_answer_list[$m][1];
							} else {
								$result[$i]->quiz->question_list[$j]->given_answer = -1;
							}

						}
					}
					$result[$i]->assessment_data = $this->getAssessmentData($result[$i]->quiz->question_list);
				}

				

			}

			
			return $result;
		
			
		} else if ($return_type == "COUNT") {
			return $query->num_rows();
		} else {
			return null;
		}

	}


	public function getAssessmentData($question_list) {
		$attempted = 0;
		$right_answer = 0;
		$success_rate = 0;
		$success_rate_of_attempted = 0;
		if (isset($question_list)) {
			foreach ($question_list as $quesiton) {
				if (isset($quesiton->given_answer)) {
					$attempted++;
					if ($quesiton->right_option_value == $quesiton->given_answer) {
						$right_answer++;
					}
				}

			}
		}

		if($right_answer != 0){
			$success_rate = round(($right_answer / count($question_list)) * 100, 2);

		}

		if($attempted != 0){
			$success_rate_of_attempted = round(($right_answer / $attempted) * 100, 2);

		}

		return array(
			"no_of_total_question" => count($question_list),
			"attempted" => $attempted,
			"no_of_right_answer" => $right_answer,
			"success_rate" => $success_rate,
			"success_rate_of_attempted" => $success_rate_of_attempted,
		);
	}

	public function get_assessment_by_enroll_id_and_set_id($return_type, $attribute_list, $filter_list = null) {

		foreach ($attribute_list as $table => $value) {
			foreach ($value as $attribute) {
				$this->db->select($table . '.' . $attribute);
			}
		}

		$this->db->from("user_assessment");

		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}

		$this->db->join('quiz_set', 'quiz_set.id = user_assessment.set_id', 'LEFT');

		if ($return_type == "OBJECT") {
			$result = $this->db->get()->result();

			return $result;
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}

	}

	public function get_quiz_result_by_enroll_id($enrollment_id) {
	   $quiz_result = $this->db->query('SELECT  COUNT(user_assessment.id) as id_count FROM user_assessment  LEFT JOIN quiz_set
					ON user_assessment.set_id = quiz_set.id WHERE enrollment_id = ' . $enrollment_id );
		        if($quiz_result->result()[0]->id_count == 1){
		            	$query = $this->db->query('SELECT  quiz_set.id, quiz_set.name FROM user_assessment  LEFT JOIN quiz_set
					ON user_assessment.set_id = quiz_set.id WHERE enrollment_id = ' . $enrollment_id);

		        }else{
		            	$query = $this->db->query('SELECT  quiz_set.id, quiz_set.name FROM user_assessment  LEFT JOIN quiz_set
					ON user_assessment.set_id = quiz_set.id WHERE enrollment_id = ' . $enrollment_id . ' and user_assessment.id IN ( SELECT MAX(id) FROM user_assessment GROUP BY set_id) ORDER BY set_id ASC');

		        }

		return $query->result();

	}

	public function getNextLessonId($lesson_id = null, $course_id){
		$next_lesson = 'SELECT * FROM `lesson` WHERE id > '.$lesson_id.'  AND course_id = '.$course_id.' LIMIT 1';

	 return $query->result()[0];
	}

	/*
	 *   Delete quiz set
	 */
		public function delete_quiz_set($id) {
			$this->db->where('id', $id);
			if ($this->db->delete('quiz_set')) {
				return array("success" => true, "message" => "Data deleted successfully.");
			} else {
				return array("success" => false, "message" => "Failed to delete data in db.");
			}
		}

}