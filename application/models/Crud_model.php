<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model {

	function __construct() {
		parent::__construct();

		date_default_timezone_set('Asia/Dhaka');
	}

/*************************************************************************************
 **************************************************************************************
 * Enroll
 **************************************************************************************
 **************************************************************************************/

/*
	    *  Retrieve settings table data
*/
public function get_settings_info($attribute_list) {

	$this->db->select('key, value');
	$this->db->from('settings');

	if ($attribute_list !== null && count($attribute_list) > 0) {
		foreach ($attribute_list as $attribute) {
			$this->db->or_where('key', $attribute);
		}
	}
	$result = array();

	foreach ($this->db->get()->result() as $record) {
		$result[$record->key] = $record->value;
	}

	return $result;
}


public function get_frontend_settings_info($attribute_list) {

	$this->db->select('key, value');
	$this->db->from('frontend_settings');

	if ($attribute_list !== null && count($attribute_list) > 0) {
		foreach ($attribute_list as $attribute) {
			$this->db->or_where('key', $attribute);
		}
	}
	$result = array();

	foreach ($this->db->get()->result() as $record) {
		$result[$record->key] = $record->value;
	}

	return $result;
}



/*
 * Return user certificate serial no.
 */
	public function get_user_certificate_serial_no($return_type, $user_id = null, $course_id = null, $attribute_list, $filter_list = null) {

		foreach ($attribute_list as $table => $value) {
			foreach ($value as $attribute) {
				$this->db->select($table . '.' . $attribute);
			}
		}

		$this->db->from('certificate');
		if ($user_id != null) {
			$this->db->where('certificate.user_id', $user_id);
		}
		if ($course_id != null) {
			$this->db->where('certificate.course_id', $course_id);
		}

		$this->db->join('user', 'user.id = certificate.user_id', 'LEFT');
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

	/* Get all country phone*/
	public function get_country_phone($return_type, $attribute_list) {

	

		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}
		$this->db->from("country_phone");

	

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}

/*Get Enrollment list*/

	public function get_enrollment_list($return_type, $attribute_list, $filter_list = null, $limit = null) {

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}
		$this->db->from("enrollment");

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
 * Enroll count of a counse
 * Return a number
 */
	public function get_enroll_count_of_a_course($course_id) {
		$this->db->select('id');
		$this->db->from("enrollment");
		$this->db->where("course_id", $course_id);
		return $this->db->get()->num_rows();
	}

	public function get_user_certificate_info($course_id, $user_id = '') {
		return $user_certificate_serial = $this->get_user_certificate_serial_no(
			"OBJECT",
			// $this->session->userdata('user_id'),
			$user_id ,
			$course_id,
			array("certificate" => array(
				'certificate_no',
				'course_name',
				'user_seen_duration',
				'created_at',
				'certificate_key',
			),
				"user" => array(
					"first_name",
					"last_name",
				),
			)
		);
	}

	public function store_user_certificate_info($course_id, $certificate_serial_no, $user_id = '') {
		date_default_timezone_set('Asia/Dhaka');
		/*get course total duration*/
		$certificate_data['course_duration'] = get_total_course_duration($course_id)->total_course_duration;

		/*get user seen last date*/
		$certificate_data['lesson_seen_last_date'] = $this->getLastLessonDate($user_id, $course_id)->date;

		/*get total user lesson duration*/
		$certificate_data['user_seen_duration'] = 0;
		$finished_time = $this->lesson_model->get_lesson_list_by_users_status(
			$user_id,
			'OBJECT',
			array(
			// 	'user_lesson_status' => array('finished_time'),
			),
			array('course_id' => $course_id)
		);
		foreach ($finished_time as $duration) {
			$certificate_data['user_seen_duration'] += $duration->finished_time;
		}

		/*get course title*/
		$course_title = $this->course_model->get_course_list(
			"OBJECT",
			array('title', 'instructor_id'),
			array('id' => $course_id)
		)[0];

		$certificate_data['course_name'] = $course_title->title;
		$certificate_data['user_id'] = $user_id;
		$certificate_data['created_at'] = date("Y-m-d H:i:s");
		$certificate_data['course_id'] = $course_id;

		$get_date = date('d', strtotime($certificate_data['lesson_seen_last_date']));
		$get_month = date('m', strtotime($certificate_data['lesson_seen_last_date']));
		$get_year = date('Y', strtotime($certificate_data['lesson_seen_last_date']));

		$certificate_data['certificate_no'] = intval($get_year . $get_month . $get_date . '000000000') + intval($course_id . '00000') + intval($certificate_serial_no);

		$generated_key = substr(md5(time()), 0, 8);
		$certificate_data['certificate_key'] = 'EC-' . $generated_key;

		/*Insert certificate info in certificate table*/
		$this->insert_user_certificate_info($certificate_data);

	}

/*
 * Get higheast certificate serial no
 */
	public function getCertificateSerialNo($course_id, $user_id = '') {
		$user_certificate_serial = $this->get_user_certificate_info($course_id, $user_id);
		$get_certificate_no = $this->get_enrollment_list(
			"OBJECT",
			array("certificate_serial_no"),
			array(
				// "user_id" => $this->session->userdata('user_id'),
				"user_id" => $user_id,
				"course_id" => $course_id,
			)
		)[0]->certificate_serial_no;

		if ($get_certificate_no == null || $get_certificate_no == 0) {

			$query = $this->db->query('SELECT certificate_serial_no FROM `enrollment` WHERE course_id =' . $course_id . ' ORDER BY certificate_serial_no DESC LIMIT 1');

			$result = $query->result()[0];

			/*get certificate no from enrollment table*/
			$data['certificate_serial_no'] = $result->certificate_serial_no + 1;
			$this->store_user_certificate_info($course_id, $data['certificate_serial_no'], $user_id);
			/*Insert certificate serial no in enrollment table*/
			$this->crud_model->update_user_certificate_serial_no($course_id, $user_id, $data);

			return $user_certificate_serial = $this->get_user_certificate_info($course_id, $user_id);

		} else {
			if ($this->get_user_certificate_info($course_id, $user_id) == null) {
				$this->store_user_certificate_info($course_id, $get_certificate_no, $user_id);
				$user_certificate_serial = $this->get_user_certificate_info($course_id, $user_id);
			}

			return $user_certificate_serial;
		}

		/* User certificate serial no set end*/
	}

	public function getLastLessonDate($user_id, $course_id) {
		$query = $this->db->query('SELECT MAX(user_lesson_status.updated_at) as date FROM `lesson`LEFT JOIN user_lesson_status ON lesson.id = user_lesson_status.lesson_id WHERE user_lesson_status.user_id =' . $user_id . ' and lesson.course_id =' . $course_id . '');
		return $query->result()[0];
	}

	public function verify_certificate($user_id, $course_id) {

		return $user_certificate_serial = $this->get_user_certificate_serial_no(
			"OBJECT",
			$user_id,
			array("enrollment" => array('certificate_serial_no')),
			array("course_id" => $course_id)
		)[0];
	}

	/*
		 * Insert certificate info
	*/

	public function insert_user_certificate_info($data) {
		if ($this->db->insert('certificate', $data)) {
			return array('success' => true, 'message' => 'Successfully Save data');
		} else {
			return array('success' => false, 'message' => 'Failed to save data for db error');
		}
	}

/*
 * Update serial no a particular user
 */

	public function update_user_certificate_serial_no($course_id, $user_id, $data) {
		$this->db->set($data);
		$this->db->where('course_id', $course_id);
		$this->db->where('user_id', $user_id);
		return $this->db->update('enrollment');
	}

/*
 * Return enrollment information of an user.
 */
	public function get_enrollment_info_by_user_id($return_type, $user_id, $attribute_list, $limit = null, $filter_list = null, $paid_amount_sum = null) {

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		foreach ($attribute_list as $table => $value) {
			foreach ($value as $attribute) {
				$this->db->select($table . '.' . $attribute);
			}
		}

		
		if ($paid_amount_sum != null) {
			$this->db->select('SUM(ep.amount) as paid_amount');
		}

		$this->db->from('enrollment');
		$this->db->where('enrollment.user_id', $user_id);

		if ($filter_list != null) {
			foreach ($filter_list as $key => $value) {
				// debug($value);
				// debug($key);
				if ($key == 'search_text') {
					$this->db->like('course.title', $value, 'both');
				} else if ($key == 'category') {
					$this->db->where_in('course.category_id', $value);
				} else if($key == 'title'){
					$this->db->like('course.title', $value, 'both');
				}
			}

			// exit;
		}

		$this->db->join('course', 'course.id = enrollment.course_id', 'LEFT');
		if ($paid_amount_sum != null) {
			$this->db->join('enrollment_payment as ep', 'enrollment.id = ep.enrollment_id AND ep.status = "ACCEPTED"', 'left');
			$this->db->group_by('enrollment.id');
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
 * Enroll in a course
 * Return the id of the enrolled course.
 */
	public function enroll_an_user_in_a_course($user_id, $course_id, $coupon_id = null, $coupon_amount = 0, $promo_code = null) {

		date_default_timezone_set('Asia/Dhaka');

		$datax['course_id'] = $course_id;
		$datax['user_id'] = $user_id;

		// debug($coupon_id);
		// exit;
		if ($coupon_id > 0) {
			$datax['coupon_id'] = $coupon_id;

			$coupon_result = $this->course_model->get_coupon_list(
				"OBJECT",
				array("coupon" => array("already_applied", 'coupon_limit')),
				 $coupon_id,
				 array("id" => $coupon_id)

			);

			// debug($coupon_result);
			// exit;
			if(isset($coupon_result) ){
				if($coupon_result[0]->coupon_limit != null || $coupon_result[0]->coupon_limit != 0){
					$coupon_data['already_applied'] = $coupon_result[0]->already_applied + 1;
					$this->course_model->update_coupon($coupon_id, $coupon_data);
				}
				
			}
			

		}

		$course_data = $this->course_model->get_course_list("OBJECT", array('id', 'discount_flag', 'discounted_price', 'price', 'expiry_month'), array('id' => $course_id))[0];
		
		$datax['user_id'] = $user_id;
		if ($this->db->get_where('enrollment', $datax)->num_rows() > 0) {
			return array("success" => false, "message" => "This user is already enrolled in this course!");
		} else {

			if ($coupon_id != null) {

				if ($coupon_amount > 0) {
					$datax['enrolled_price'] = $coupon_amount;
					$datax['discounted_price'] = $course_data->discounted_price;
					$datax['price'] = $course_data->price;
				}
			} else {

				if ($course_data->discount_flag == 1) {
					$datax['enrolled_price'] = $course_data->discounted_price;
					$datax['discounted_price'] = $course_data->discounted_price;
					$datax['price'] = $course_data->price;
				} else {
					$datax['enrolled_price'] = $course_data->price;
					$datax['price'] = $course_data->price;
				}

			}

			$datax['created_at'] = date("Y-m-d H:i:s");
			$datax['last_modified'] = date("Y-m-d H:i:s");
			if($course_data->expiry_month == 0 || $course_data->expiry_month == NULL){
				$datax['expiry_date'] = NULL;
			}else{
				$datax['expiry_date'] = $default_expiry_date = date('Y-m-d', strtotime('-'.$course_data->expiry_month. ' month ago'));
			}
			

			if ($this->db->insert('enrollment', $datax)) {
				return array('success' => true, 'message' => 'Successfully enrolled', 'enrolled_id' => $this->db->insert_id());
			} else {
				return array('success' => false, 'message' => 'Failed to enroll for db error');
			}
		}
	}

/*************************************************************************************
 **************************************************************************************
 * Other features
 **************************************************************************************
 **************************************************************************************/

	/*
		    *  Return if an email has been already used of not
	*/
	public function is_duplicate_email($email) {
		$this->db->select('id');
		$this->db->from('user');
		$this->db->where('email', $email);

		if ($this->db->get()->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function is_duplicate_email_for_company($email) {
		$this->db->select('id');
		$this->db->from('company');
		$this->db->where('email', $email);

		if ($this->db->get()->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	/*
		    *   If a verification code is valid or not.
		    *   If the user's status is active, then it is returnning false.
		    *   Because for active user the verification code is useless (means invalid)
	*/
	public function is_valid_verification_code($verification_code) {
		$this->db->select("id");
		$this->db->from("user");
		$this->db->where("verification_code", $verification_code);
		$this->db->where("status", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result()[0]->id;
		} else {
			return false;
		}
	}

/*************************************************************************************
 **************************************************************************************
 * Payment features
 **************************************************************************************
 **************************************************************************************/

	public function get_payment_info_list($return_type, $user_id, $status, $limit = null) {

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		$this->db->select('course.title');
		$this->db->select('enrollment_payment.invoice_id, enrollment_payment.amount as paid_amount, enrollment_payment.created_at, enrollment_payment.status');
		$this->db->select('enrollment.enrolled_price');

		$this->db->from('enrollment');
		$this->db->where('enrollment.user_id', $user_id);

		$this->db->join('course', 'course.id = enrollment.course_id', 'LEFT');
		$this->db->join('enrollment_payment', 'enrollment.id = enrollment_payment.enrollment_id', 'right');
		$this->db->group_by('enrollment_payment.id');

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}

	public function insert_into_transaction($data) {
		if ($this->db->insert('transaction', $data)) {
			return array('success' => true, "message" => "Data inserted successfully");
		} else {
			return array('success' => false, "message" => $this->db->error());
		}
	}

	public function insert_into_enrollment_payment($data) {
		if ($this->db->insert('enrollment_payment', $data)) {
			return array('success' => true, "message" => "Data inserted successfully");
		} else {
			return array('success' => false, "message" => $this->db->error());
		}
	}

	public function add_to_cart($course_id) {
		if (!$this->session->userdata('cart_items')) {
			$this->session->set_userdata('cart_items', array());
		}

		$previous_cart_items = $this->session->userdata('cart_items');
		if (in_array($course_id, $previous_cart_items)) {
			return array('success' => false, 'message' => 'The course is already in the cart!');
		} else {
			array_push($previous_cart_items, $course_id);
			$this->session->set_userdata('cart_items', $previous_cart_items);
			return array('success' => false, 'cart_items_count' => count($previous_cart_items), 'message' => 'Successfully added to the cart!');
		}
	}

	public function remove_cart_item($course_id) {
		if (!$this->session->userdata('cart_items')) {
			return array('success' => false, 'message' => 'Your cart is empty already!');
		} else {

			$previous_cart_items = $this->session->userdata('cart_items');
			if (in_array($course_id, $previous_cart_items)) {
				$key = array_search($course_id, $previous_cart_items);
				unset($previous_cart_items[$key]);
				$this->session->set_userdata('cart_items', $previous_cart_items);

				return array('success' => true, 'cart_items_count' => count($previous_cart_items), 'message' => 'The course has been removed from cart.');

			} else {
				return array('success' => false, 'message' => 'The course is not in cart!');
			}
		}
	}

	public function handleWishList($course_id) {
		$wishlists = array();
		$action = '';
		$user_details = $this->user_model->get_user_by_id($this->session->userdata('user_id'), array('wishlist'));
		if ($user_details->wishlist == "") {
			array_push($wishlists, $course_id);
		} else {
			$wishlists = json_decode($user_details->wishlist);
			if (in_array($course_id, $wishlists)) {
				$container = array();
				foreach ($wishlists as $key) {
					if ($key != $course_id) {
						array_push($container, $key);
					}
				}
				$wishlists = $container;
				$action = "Removed";
// $key = array_search($course_id, $wishlists);
				// unset($wishlists[$key]);
			} else {
				array_push($wishlists, $course_id);
				$action = "Added";

			}
		}

		$updater['wishlist'] = json_encode($wishlists);

		$this->db->where('id', $this->session->userdata('user_id'));

		if ($this->db->update('user', $updater)) {
			return array('success' => true, 'message' => 'updated successfully', 'action' => $action, 'count' => count($wishlists));
		} else {
			return array('success' => false, 'message' => 'Failed to updated');
		}
	}

/*
 *   Store user message
 */
	public function save_user_meassage($data) {
		if ($this->db->insert('inbox', $data)) {
			return array("success" => true, "message" => "Data inserted successfully.");
		} else {
			return array("success" => false, "message" => "Failed to insert data in db.");
		}
	}

	public function getLatestPaidUserInfo($limit) {
		$query = $this->db->query('SELECT * FROM (SELECT DISTINCT(enrollment.course_id), course.title,course.slug, user.first_name,user.last_name,enrollment_payment.created_at, enrollment_payment.id FROM `enrollment_payment` LEFT JOIN enrollment ON enrollment_payment.enrollment_id=enrollment.id LEFT JOIN course ON enrollment.course_id=course.id JOIN user ON enrollment.user_id=user.id WHERE enrollment_payment.status="accepted" ORDER BY enrollment_payment.id DESC LIMIT ' . $limit . ') tbl1 ORDER BY Id LIMIT 1');

		return $query->result();
	}

	/*
		    * Retrieve all faq category
	*/
	public function get_faq_category_list($return_type, $attribute_list, $filter_list = null) {

		foreach ($attribute_list as $table => $attribute) {
			foreach ($attribute as $attribute_name) {
				$this->db->select($table . '.' . $attribute_name);
			}
		}
		$this->db->from("faq_category");
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
		    * Retrieve all faq
	*/

	public function get_faq_list($return_type, $attribute_list, $filter_list = null, $limit = null) {

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		foreach ($attribute_list as $table => $attribute) {
			foreach ($attribute as $attribute_name) {
				$this->db->select($table . '.' . $attribute_name);
			}
		}

		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}
		$this->db->from("faq");

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}


	/*
		    * Get User Chat information
	*/

	public function get_user_chat_info_list($return_type, $attribute_list, $filter_list = null, $limit = null) {

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		foreach ($attribute_list as $table => $attribute) {
			foreach ($attribute as $attribute_name) {
				$this->db->select($table . '.' . $attribute_name);
			}
		}

		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}
		$this->db->from("user_chat_info");

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}
	
	
	public function insertChatUserInfo($data){
	    $user_info['user_id'] = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : '';
		$user_info['ip_address'] = $data['ip_address'];
		$user_info['message_time'] =  date("Y-m-d H:i:s");;
// 		$user_info['receiver_id'] = $data['admin_id'];
		
		if($this->db->insert('user_chat_info', $user_info)){
				// $chat_message['sender_id'] = $this->db->insert_id();

				// if($this->db->insert('chat_message', $chat_message)){
				// // 	$pusher_data['sender_id'] = $this->db->insert_id();
				// // 	$pusher->trigger('my-channel', 'my-event', $pusher_data);

				// 	return array('success' => true, "message" => "Message sent successfully");
				// }else{
				// 	return array('success' => false, "message" => $this->db->error());
				// }
			}else{
				return array('success' => false, "message" => "Message not sent successfully");
			}
		
	}
	
		public function getUserIpAddr(){
		    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		        //ip from share internet
		        $ip = $_SERVER['HTTP_CLIENT_IP'];
		    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		        //ip pass from proxy
		        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    }else{
		        $ip = $_SERVER['REMOTE_ADDR'];
		    }
		    return $ip;
		}
		
		public function insertUserMessage($data) {
		require_once 'vendor/autoload.php';
		


        /* chat user info*/
		$user_info['user_id'] = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : '';
		$user_info['ip_address'] = $data['ip_address'];
		$user_info['message_time'] = $data['message_time'];

        /* user messaging infor*/
		$chat_message['receiver_id'] = $data['admin_id'];
		$chat_message['chat_messages_text'] = $data['message'];
		$chat_message['chat_messages_status'] = 0;
		$chat_message['chat_messages_datetime'] = date("Y-m-d H:i:s");

		
		

		 $user = $this->crud_model->get_user_chat_info_list(
		 	"OBJECT", 
		 	array('user_chat_info' => array('id', 'user_id', 'ip_address')),
		 	array(
		 		'ip_address' => $data['ip_address'],
		 	 	  'user_id' =>  $user_info['user_id'],
		 )
		 );
		

		/*pusher trigger */
		$options = array(
		  'cluster' => 'ap2',
		  'useTLS' => true
		);
		$pusher = new Pusher\Pusher(
		  'ef8c05dc5dc1f393d019',
		  '3cd3f6f35098f47f2110',
		  '1015837',
		  $options
		);

		/*pusher trigger end*/
        if($user_info['user_id'] != '' || $user_info['user_id'] != NULL){
                if(isset($user[0])){
    		    
    		     $user_info_response =  $this->user_model->get_user_list(
            			 	array('id', 'first_name', 'last_name', 'status', 'user_type', 'profile_photo_name'),
            			 	"OBJECT",
            			 	array('id' => $this->session->userdata('user_id'))
        			    );
        			    
    	    
        	        $chat_message['sender_id'] = $user[0]->id;
    			    if($this->db->insert('chat_message', $chat_message)){
    			        
    					$pusher_data['sender_id'] = $user[0]->id;
    					$pusher_data['receiver_id'] = $data['admin_id'];
    					$pusher_data['last_chat_message_id'] = $this->db->insert_id();
    					$pusher->trigger('my-channel', 'my-event', $pusher_data);
    					
    					$user_chat['message_time'] = date("Y-m-d H:i:s");
    					$this->update_user_chat_info($user[0]->id, $user_chat);
            
    
    					return array('success' => true, "message" => "Message sent successfully", 'data' => $user_info_response);
    				}else{
    					return array('success' => false, "message" => $this->db->error());
    				}
    		    
    		  
    		
    		}else{
            /* new user entry*/
    			if($this->db->insert('user_chat_info', $user_info)){
    				$chat_message['sender_id'] = $this->db->insert_id();
    
    				if($this->db->insert('chat_message', $chat_message)){
    					$pusher_data['sender_id'] = $this->db->insert_id();
    					$pusher_data['receiver_id'] = $data['admin_id'];
    					$pusher_data['last_chat_message_id'] = $this->db->insert_id();
    					$pusher->trigger('my-channel', 'my-event', $pusher_data);
    
    					return array('success' => true, "message" => "Message sent successfully");
    				}else{
    					return array('success' => false, "message" => $this->db->error());
    				}
    			}else{
    				return array('success' => false, "message" => "Message not sent successfully");
    			}
    		}
        }else{
            /*logout user insert with ip*/ 
            
            /*get user with ip*/
            $user_with_ip = $this->crud_model->get_user_chat_info_list(
    		 	"OBJECT", 
    		 	array('user_chat_info' => array('id', 'user_id', 'ip_address')),
    		 	array(
    		 		'ip_address' => $data['ip_address'],
    		 	 	  'user_id' =>  0,
        		 )
		    );
		    if(isset($user_with_ip) && $user_with_ip != NULL){
		         
            				$chat_message['sender_id'] =  $user_with_ip[0]->id;
            
            				if($this->db->insert('chat_message', $chat_message)){
            					$pusher_data['sender_id'] = $user_with_ip[0]->id;
            				    $pusher_data['last_chat_message_id'] = $this->db->insert_id();
            					$pusher->trigger('my-channel', 'my-event', $pusher_data);
            					
            					/*chat user info update*/
            					$user_chat['message_time'] = date("Y-m-d H:i:s");
            					$this->update_user_chat_info($user_with_ip[0]->id, $user_chat);
            
            					return array('success' => true, "message" => "Message sent successfully");
            				}else{
            					return array('success' => false, "message" => $this->db->error());
            				}
       
		    }else{
		      //   return array('data' => 'no data');
		        if($this->db->insert('user_chat_info', $user_info)){
            				$chat_message['sender_id'] = $this->db->insert_id();
            
            				if($this->db->insert('chat_message', $chat_message)){
            					$pusher_data['sender_id'] = $this->db->insert_id();
            					$pusher_data['last_chat_message_id'] = $this->db->insert_id();
            					$pusher->trigger('my-channel', 'my-event', $pusher_data);
            
            					return array('success' => true, "message" => "Message sent successfully");
            				}else{
            					return array('success' => false, "message" => $this->db->error());
            				}
            			}else{
            				return array('success' => false, "message" => "Message not sent successfully");
            			}
		    }
	
        }
	
	}


	public function get_user_chat_messages($return_type, $attribute_list, $filter_list = null, $limit = null) {

		if ($limit != null) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		foreach ($attribute_list as $table => $attribute) {
			foreach ($attribute as $attribute_name) {
				$this->db->select($table . '.' . $attribute_name);
			}
		}

		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}
		$this->db->from("chat_message");

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT") {
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}
	
	
	public function update_admin_message_seen($sender_id, $receiver_id) {
	    $data['message_seen'] = 1;
		$this->db->set($data);
		$this->db->where('sender_id', $sender_id);
		$this->db->where('receiver_id', $receiver_id);
		$this->db->where('chat_messages_status', 1);
		$this->db->where('message_seen', 0);
		return $this->db->update('chat_message');
	}
	
	public function update_user_chat_info($id, $data) {
	    
		$this->db->set($data);
		$this->db->where('id', $id);
		
		return $this->db->update('user_chat_info');
	}
	
	public function get_percentage_of_specific_rating($rating = "",  $ratable_id = "")
	{
	    $number_of_user_rated = $this->db->get_where('course_review', array(
	        // 'ratable_type' => $ratable_type,
	        'course_id'   => $ratable_id
	    ))->num_rows();

	    $number_of_user_rated_the_specific_rating = $this->db->get_where('course_review', array(
	        // 'ratable_type' => $ratable_type,
	        'course_id'   => $ratable_id,
	        'rating'       => $rating,
	        'status' => 1
	    ))->num_rows();

	    //return $number_of_user_rated.' '.$number_of_user_rated_the_specific_rating;
	    if ($number_of_user_rated_the_specific_rating > 0) {
	        $percentage = ($number_of_user_rated_the_specific_rating / $number_of_user_rated) * 100;
	    } else {
	        $percentage = 0;
	    }
	    return floor($percentage);
	}


	public function get_ratings($ratable_id = "", $is_sum = false)
	{
	    if ($is_sum) {
	        $this->db->select_sum('rating');
	        return $this->db->get_where('course_review', array('course_id' => $ratable_id, 'status' => 1));
	    } else {
	        return $this->db->get_where('course_review', array( 'course_id' => $ratable_id, 'status' => 1));
	    }
	}

	public function home_page_setting($id = null){
		if($id){
			$query = $this->db->query('SELECT * FROM `home_page_setting` WHERE id='.$id);
		}else{
			$query = $this->db->query('SELECT * FROM `home_page_setting` ORDER BY rank');
		}
		

		return $query->result();
	}

}
