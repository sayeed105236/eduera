<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	/*
		    *   Create course
	*/
	public function insert_course($data) {
		$this->db->insert('course', $data);
		return $this->db->insert_id();
	}

	/*
		    * Update course info
	*/
	public function update_course_info($course_id, $data) {
		$this->db->set($data);
		$this->db->where('id', $course_id);
		return $this->db->update('course');
	}

	/*
		    * Retrieve all courses
	*/
	public function get_course_list($return_type, $attribute_list, $filter_list = null, $limit = null, $order_by = null) {

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}
		$this->db->from("course");
		if($order_by != null){
			$this->db->order_by('rank', 'asc');
		}
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
		    * Retrieve course list by category id list, with limit and offset
	*/
	public function get_course_list_by_category_id_list($return_type, $category_id_list, $attribute_list, $limit = null, $param = null) {
		
		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}
		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}

		$this->db->from("course");
	
		if($param === null){
			//Filtering by selected id's

			$this->db->where("category_id", $category_id_list[0]);

			for ($i = 1; $i < count($category_id_list); $i++) {
				$this->db->or_where("category_id", $category_id_list[$i]);
				}

		}else{

			
			$this->db->where('status' , 1);
			$this->db->where("category_id", $category_id_list[0]);
				if($param === 'certification'){
					//Filtering by id's and certification
					$this->db->where("certification_course", "1");
				}
				else if($param === 'mock_test'){
					//Filtering by id's and mock_test
					$this->db->where("mock_test", 1);
					
				}else if($param === 'new'){
					//Filtering by id's and new
					$this->db->order_by('id', 'DESC');
					$this->db->limit(5);

				}else if($param === 'free'){
					//Filtering by id's and free
					$this->db->where("discount_flag", "1");
					$this->db->where("discounted_price", "0");
				}


			for ($i = 1; $i < count($category_id_list); $i++) {
				$this->db->or_where("category_id", $category_id_list[$i]);

				if($param === 'certification'){
					//Filtering by id's and certification
					$this->db->where("certification_course", "1");

				}else if($param === 'mock_test'){
					//Filtering by id's and mock_test
					$this->db->where("mock_test", 1);
				
				}else if($param === 'new'){
					//Filtering by id's and new
					$this->db->order_by('id', 'DESC');
					$this->db->limit(5);
				
				}else if($param === 'free'){
					//Filtering by id's and free
					$this->db->where("discount_flag", "1");
					$this->db->where("discounted_price", "0");
				}
			}
		}

		//print_r($this->db->last_query());    

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();

		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}

	}

	/*
		    * Return course list by searching query text with course title
	*/
	public function get_course_list_by_searching_query_text($return_type, $query_text, $attribute_list, $limit = null) {
		// debug($query_text);
		// exit;
		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}
		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}

		$this->db->from('course');

		$this->db->where('status', 1);

        $this->db->like('title', $query_text, 'both');
		$this->db->or_like('language', $query_text, 'both');
		$this->db->or_like('price', $query_text, 'both');
		$this->db->or_like('level', $query_text, 'both');
		$this->db->or_like('slug', $query_text, 'both');
		$this->db->or_like('short_description', $query_text, 'both');
		$this->db->or_like('description', $query_text, 'both');
		$this->db->or_like('seo_title', $query_text, 'both');
		$this->db->or_like('meta_tags', $query_text, 'both');


		
		

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}

	public function get_course_thumbnail_url($course_id, $type = 'course_thumbnail') {

		$url = 'uploads/thumbnails/course_thumbnails/course_thumbnail_';
		if (file_exists($url . 'default_' . $course_id . '.jpg')) {
			return base_url() . $url . 'default_' . $course_id . '.jpg';
		} else {
			return base_url() . 'assets/frontend/default/img/course_thumbnail_placeholder_small.jpg';
		}

	}

	/*
		    * Retrieve wishlist courses
	*/
	public function get_wishlist_courses_by_user_id($return_type, $user_id, $attribute_list, $limit = null, $filter = null) {

		// Retrieve the courses ids which are in wishlist.
		$this->db->select('wishlist');
		$this->db->from('user');
		$this->db->where('id', $user_id);
		$user_wishlist = $this->db->get()->result()[0]->wishlist;
		$course_id_list = json_decode($user_wishlist == null ? '[]' : $user_wishlist);

		if (count($course_id_list) == 0) {
			$course_list = array();
		} else {

			// Define the limit and offset
			if ($limit != null) {
				$this->db->limit($limit['limit'], $limit['offset']);
			}

			foreach ($attribute_list as $attribute) {
				$this->db->select('' . $attribute);
			}
			$this->db->from("course");
			$this->db->where_in("id", $course_id_list);

			// Filter the courses based on the category and search text
			if ($filter != null) {
				foreach ($filter as $key => $value) {
					if ($key == 'search_text') {
						$this->db->like('course.title', $value, 'both');
					} else if ($key == 'category') {
						$this->db->where_in('course.category_id', $value);
					}
				}
			}

			$course_list = $this->db->get()->result();

			for ($i = 0; $i < count($course_list); $i++) {
				$this->db->select("id");
				$this->db->from('enrollment');
				$this->db->where('user_id', $user_id);
				$this->db->where('course_id', $course_list[$i]->id);

				if ($this->db->get()->num_rows() > 0) {
					$course_list[$i]->already_enrolled = true;
				} else {
					$course_list[$i]->already_enrolled = false;
				}
			}
		}

		// return $course_list;

		if ($return_type == "OBJECT") {
			return $course_list;
		} else if ($return_type == "COUNT") {
			return count($course_list);
		} else {
			return null;
		}
	}

	
	public function update_coupon($coupon_id, $data) {
		$this->db->set($data);
		$this->db->where('id', $coupon_id);

		if ($this->db->update('coupon')) {
			return array('success' => true, 'message' => 'Successfully coupon info updated.');
		} else {
			return array('success' => false, 'message' => 'Failed to updated.');
		}

		// return $this->db->update('coupon');
	}

	

	/*
		    * Retrieve all coupon
	*/
	public function get_coupon_list($return_type, $attribute_list, $coupon_id = null, $filter_list = null, $limit = null) {

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		foreach ($attribute_list as $table => $value) {
			foreach ($value as $attribute) {
				$this->db->select($table . '.' . $attribute);
			}
		}
		$this->db->from("coupon");

		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}
		if ($coupon_id) {
			$this->db->where('id', $coupon_id);
		} else {
			$this->db->join('course', 'course.id = coupon.course_id ', 'LEFT');
		}

		// $this->db->group_by("coupon.id");
		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}

	public function get_course_list_with_rank($parameter = null, $query= null,$limit=null, $offset=null){
			if($parameter == 'new'){
				if(isset($query) || $query == 'all'){
					if(isset($limit) || isset($offset)){
						//debug($parameter);
						$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language FROM `course` WHERE status = 1 ORDER BY id DESC LIMIT '.$limit.' OFFSET '.$offset);
					}else{
						//debug($parameter);
						$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language FROM `course` WHERE status = 1 ORDER BY id DESC');
					}
				}else{
					$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language FROM `course` WHERE mock_test = 0 and certification_course = 0 and  discounted_price !=0 and  status = 1 ORDER BY id DESC LIMIT 10');
				}
				
			}else if($parameter == 'free'){
				if(isset($query) || $query == 'all'){
					if(isset($limit) || isset($offset)){
						$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language FROM `course` WHERE  status = 1 and discount_flag=1 and discounted_price=0 ORDER BY id DESC LIMIT '.$limit.' OFFSET '.$offset);
					}else{
						$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language FROM `course` WHERE  status = 1 and discount_flag=1 and discounted_price=0 ORDER BY id DESC');
					}
					
				}else{
					$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language FROM `course` WHERE status = 1 and discount_flag=1 and discounted_price=0 ORDER BY id DESC LIMIT 10');
				}
				
			}else if($parameter == 'certification'){
				if(isset($query) || $query == 'all'){
					if(isset($limit) || isset($offset)){
						$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language FROM `course` WHERE status = 1 and certification_course=1  ORDER BY rank  LIMIT '.$limit.' OFFSET '.$offset);
					}else{
						$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language FROM `course` WHERE status = 1 and certification_course=1  ORDER BY rank DESC ');
					}
				}else{
					$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language FROM `course` WHERE status = 1 and certification_course=1  ORDER BY rank  LIMIT 10');
				}
				
			}else if($parameter == 'mock_test'){
				
				if(isset($query) || $query == 'all'){

					if(isset($limit) || isset($offset)){
						$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language, mock_test FROM `course` WHERE status = 1 and mock_test=1  ORDER BY rank DESC  LIMIT '.$limit.' OFFSET '.$offset);
					}else{
						$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language FROM `course` WHERE status = 1 and mock_test=1  ORDER BY rank DESC ');
					}
				}else{
					$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language FROM `course` WHERE status = 1 and mock_test=1  ORDER BY rank DESC LIMIT 10');
				}
				
			}
			else{

				$query = $this->db->query('SELECT id, title, price, slug, status, short_description, discount_flag, discounted_price, outcomes, created_at, last_modified, language FROM `course`  where status = 1 ORDER BY rank');
			}
			
			return  $query;
		}



	public function get_courses_list(){
		$query = $this->db->query('SELECT id, title, price,  status,discount_flag, discounted_price, rank FROM `course`  ORDER BY rank ASC');

		return  $query->result();
	}


	public function getNextLessonId($course_id, $section_id, $rank){
		$next_lesson = $this->db->query('SELECT * FROM `lesson` WHERE  course_id = '.$course_id.' AND section_id = '.$section_id.' AND rank  > '.$rank.' ORDER By rank LIMIT 1');

	 return $next_lesson->result();
	}

	public function getPreviewNextLessonId($course_id, $lesson_id){
		$next_lesson = $this->db->query('SELECT * FROM `lesson` WHERE course_id = '.$course_id.' AND preview = 1 AND id > '.$lesson_id.' ORDER By id LIMIT 1 ');

	 return $next_lesson->result();
	}

	public function save_course_review($data, $course_id = null, $user_id = null) {

		// $this->db->insert('course_review', $data);
		// return $this->db->insert_id();
		if($course_id == null && $user_id == null){

			if ($this->db->insert('course_review', $data)) {
				return array('success' => true, 'message' => 'save');
			} else {
				return array('success' => false, 'message' => 'Failed to save review');
			}
		}else{
			$this->db->set($data);
			$this->db->where('course_id', $course_id);
			$this->db->where('user_id', $user_id);
			if ($this->db->update('course_review')) {
				return array('success' => true, 'message' => 'update');
			} else {
				return array('success' => false, 'message' => 'Failed to update review');
			}
		}
		
	}



	/*
		    * Retrieve all coupon
	*/
	public function get_course_review_list($return_type, $attribute_list, $filter_list = null, $limit = null) {

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		// foreach ($attribute_list as $table => $value) {
		// 	foreach ($value as $attribute) {
		// 		$this->db->select($table . '.' . $attribute);
		// 	}
		// }

		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}
		$this->db->from("course_review");

		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}
		// if ($coupon_id) {
		// 	$this->db->where('id', $coupon_id);
		// } else {
		// 	$this->db->join('course', 'course.id = coupon.course_id ', 'LEFT');
		// }

		// $this->db->group_by("coupon.id");
		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}

	public function get_course_review_data($course_id, $type=null){

		$review_data = $this->get_course_review_list(
							$type,
							array('id', 'user_id', 'course_id', 'status', 'review', 'rating'),
							array('course_id' => $course_id, 'status' => 1)
						);

		return $review_data;
	}


	public function save_course_notes($data, $id = null) {

		// $this->db->insert('course_review', $data);
		// return $this->db->insert_id();
		if($id == null ){

			if ($this->db->insert('course_notes', $data)) {
				return array('success' => true, 'message' => 'save course notes');
			} else {
				return array('success' => false, 'message' => 'Failed to save course notes');
			}
		}else{
			$this->db->set($data);
			$this->db->where('id', $id);
			if ($this->db->update('course_notes')) {
				return array('success' => true, 'message' => 'update course notes');
			} else {
				return array('success' => false, 'message' => 'Failed to update course notes');
			}
		}
		
	}


	public function get_course_notes($course_id, $lesson_id, $user_id){

		$query = $this->db->query('SELECT course_notes.id , lesson.title as lesson_title, lesson.rank as lesson_rank, section.title as section_title, section.rank as section_rank, lesson_time, notes FROM `course_notes` JOIN lesson ON course_notes.lesson_id=lesson.id JOIN section ON lesson.section_id=section.id WHERE course_notes.course_id ='.$course_id. ' AND lesson_id ='.$lesson_id.' AND course_notes.user_id ='.$user_id.' ORDER BY course_notes.id DESC');

		return $query->result();
	}

	public function remove_course_notes($notes_id){
		$this->db->where('id', $notes_id);
		if ($this->db->delete('course_notes')) {
			return array('success' => true, 'message' => 'Successfully remove note.');
		} else {
			return array('success' => false, 'message' => 'Failed to remove note.');
		}
	}

	/*
		    * Retrieve all reviews
	*/
	public function get_course_review_list_with_user($return_type, $attribute_list,  $filter_list = null, $limit = null) {

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		foreach ($attribute_list as $table => $value) {
			foreach ($value as $attribute) {
				$this->db->select($table . '.' . $attribute);
			}
		}
		$this->db->from("course_review");

		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}
		// if ($coupon_id) {
		// 	$this->db->where('id', $coupon_id);
		// } else {
			$this->db->join('course', 'course.id = course_review.course_id ', 'LEFT');
			$this->db->join('user', 'user.id = course_review.user_id ', 'LEFT');
		// }

		// $this->db->group_by("coupon.id");
		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}


}