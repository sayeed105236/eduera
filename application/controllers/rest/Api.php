<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct() {
		parent::__construct();
		header("Access-Control-Allow-Origin: *");
		$this->load->database();
		$this->load->library('session');

	}

	public function get_header_search_result($query_text = "") {
		$response_output = array(
			'success' => true,
		);

		if ($query_text == "") {
			$response_output['object_list'] = [];
		}
		$course_list = $this->course_model->get_course_list_by_searching_query_text("OBJECT", $query_text, array('id', 'slug', 'title'));
		$response_output['object_list'] = $course_list;
		echo json_encode($response_output);
	}

	public function is_duplicate_email() {
		if ($this->crud_model->is_duplicate_email($_POST['email'])) {
			echo 1;
		} else {
			echo 0;
		}
	}

	/*
		    *   Add a couse to cart
		    *   Post request
	*/
	public function add_to_cart() {
		$course_id = $this->input->post('course_id');
		$response = $this->crud_model->add_to_cart($course_id);
		echo json_encode($response);
		return true;
	}

	/*
		    *   Remove a couse from cart
		    *   Post request
	*/
	public function remove_from_cart() {
		$course_id = $this->input->post('course_id');
		$response = $this->crud_model->remove_cart_item($course_id);
		echo json_encode($response);

		return true;
	}

	public function set_checkout_details() {

		/* New Code start*/
		$checkout_courses = $this->input->post('courses');
        $checkout_total_amount = $this->input->post('total_amount_to_pay');

        $total_course_amount = 0;
        $coupon = null;

        foreach($checkout_courses as $course){
            $total_course_amount += $course['amount_to_pay_now'];
            if(isset($course['coupon_id'])){
            	$coupon = $course['coupon_id'];
            }
            
        }
       	
       	if($coupon == NULL){
       		if($total_course_amount > $checkout_total_amount){
       		    echo '0';
       		}else{
       		    $this->session->set_userdata('checkout_info', array(
       		        "courses" => $this->input->post('courses'),
       		        "total_amount_to_pay" => $this->input->post('total_amount_to_pay'),
       		    ));

       		    echo "1";
       		}
       	}else{
       		$this->session->set_userdata('checkout_info', array(
       		    "courses" => $this->input->post('courses'),
       		    "total_amount_to_pay" => $this->input->post('total_amount_to_pay'),
       		));

       		
       		echo "1";
       	}
       
        /* New Code end */
		
	}

	public function save_assessment() {
		if ($this->session->userdata('user_type') !== "USER" && $this->session->userdata('user_type') !== "ADMIN" && $this->session->userdata('user_type') !== "SUPER_ADMIN") {
			redirect(site_url('login'), 'refresh');
		}

		$assessment = array();
		$assessment_data = html_escape($this->input->post());

		
		$assessment['enrollment_id'] = $assessment_data['enrollment_id'];
		$assessment['set_id'] = $assessment_data['set_id'];
		$assessment['question_and_answer_list'] = json_encode($assessment_data['question_and_answer_list']);
		
		if($assessment['question_and_answer_list'] != null){
			if ($this->quiz_model->insertUserAssessment($assessment)) {
				echo json_encode(array("success" => true, "message" => "successfully saved the assessment data"));
			} else {
				echo json_encode(array("success" => false, "message" => "Failed to save assessment data"));
			}
		}else{
			echo json_encode(array("success" => false, "message" => "Failed to save assessment data"));
		}
		

	}

	public function user_lesson_status_update($id = null) {
		if ($id != null) {
			$data['finished_time'] = $this->input->post('lesson_time');
			$data['updated_at'] = date("Y-m-d H:i:s");
			$result = $this->lesson_model->update_user_lesson_status($data, $id);
			echo json_encode($result);
		} else {
			$data['user_id'] = $this->session->userdata('user_id');
			$data['lesson_id'] = $this->input->post('lesson_id');
			$data['finished_time'] = $this->input->post('lesson_time');
			$data['updated_at'] = date("Y-m-d H:i:s");

			$lessonstatusdata = $this->lesson_model->get_lesson_status(
				"COUNT",
				array('id'),
				array('user_id' => $data['user_id'], 'lesson_id' => $data['lesson_id'])

			);
			if($lessonstatusdata == 0){
				$result = $this->lesson_model->update_user_lesson_status($data);
				echo json_encode($result);
			}else{
				$result = $this->lesson_model->update_user_lesson_status($data, $id);
				echo json_encode($result);
			}
			
		}

	}

	public function getLatestPaidUserInfo() {
		$limit = $this->input->get('limit');
		$result = $this->crud_model->getLatestPaidUserInfo($limit);
		echo json_encode($result);
	}

	public function getCourseWiseAssessment($enrollment_id) {
		$result = $this->quiz_model->get_quiz_result_by_enroll_id($enrollment_id);
		echo json_encode($result);
	}

	public function get_coupon_info($coupon_code) {
		echo json_encode($this->course_model->get_coupon_list(
			"OBJECT",
			array(
				'coupon' => array('coupon_code', 'discount_type', 'discount', 'start_date', 'end_date', 'status', 'id', 'course_id', 'coupon_limit', 'already_applied'),

			),
			NULL,
			array('coupon_code' => $coupon_code)
		));
	}

	public function save_enrollment() {
		$data['course_id'] = $this->input->post('course_id');
		$data['price'] = $this->input->post('price');
		$data['discounted_price'] = $this->input->post('discounted_price');
		$data['coupon_id'] = $this->input->post('coupon_id');
		$data['user_id'] = $this->session->userdata('user_id');
		$data['enrolled_price'] = 0;
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['last_modified'] = date("Y-m-d H:i:s");
		$response = $this->user_model->insert_enrollment_info($data);

		if($response['success']){

			$coupon_result = $this->course_model->get_coupon_list(
				"OBJECT",
				array("coupon" => array("already_applied", 'coupon_limit')),
				 $data['coupon_id'],
				 array("id" => $data['coupon_id'])

			);

			if(isset($coupon_result)){
				if($coupon_result[0]->coupon_limit != null ||  $coupon_result[0]->coupon_limit != 0){
					$coupon_data['already_applied'] = $coupon_result[0]->already_applied + 1;
					$this->course_model->update_coupon($data['coupon_id'], $coupon_data);
				}
				
			}
			



			echo json_encode($response);
			return true;
		}else{
			return false;
		}
		
	}

	public function insertUserMessage(){
		date_default_timezone_set('Asia/Dhaka');
		$data['message'] = $this->input->post('message');
		$data['message_time'] = date("Y-m-d H:i:s");
		$data['ip_address'] = $this->getUserIpAddr();
		
		$data['admin_id'] = $this->input->post('admin_id');

		$done = $this->crud_model->insertUserMessage($data);

		echo json_encode($done);
		return true;

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
	
	public function get_user_chat_messages($id, $sender_id){
			    
		$data['messages'] = $this->crud_model->get_user_chat_messages(
 			'OBJECT',
 			array('chat_message' => array('sender_id', 'receiver_id', 'chat_messages_text', 'chat_messages_status', 'chat_messages_datetime')),
 			array('id' => $id, 'sender_id' => $sender_id)
 		);
 		
 		$data['admin'] =  $this->user_model->get_user_list(
			 	array('id', 'first_name', 'last_name', 'profile_photo_name' ),
			 	"OBJECT",
			 	array('id' => $data['messages'][0]->receiver_id)
			  );
 		

 		echo json_encode($data);
	}
	
	public function get_user_unseen_message($sender_id = ''){
	    	 $all_admin_list =  $this->user_model->get_user_list(
			 	array('id', 'first_name', 'last_name', 'profile_photo_name' ),
			 	"OBJECT",
			 	array('status' => 1, 'user_type' => 'ADMIN')
			  );
			  
			  $admin_list = array();
			  foreach($all_admin_list as $admin){
			    
			        array_push($admin_list, $admin);
			     
			  }
			 
			  
			   $user_id = ($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '';
			   if($user_id != '' || $user_id != NULL){
	 	     	    
        			  $user_check = $this->crud_model->get_user_chat_info_list(
        			 	 	"OBJECT", 
        			 	 	array('user_chat_info' => array('id', 'user_id', 'ip_address')),
        			 	 	array(
        			 	 		// 'ip_address' => $this->getUserIpAddr(),
        			 	 		   'user_id' =>  $user_id,
        			 	 )
        			 	 );
	 	     	}else{
	 	     	     $user_check = $this->crud_model->get_user_chat_info_list(
        			 	 	"OBJECT", 
        			 	 	array('user_chat_info' => array('id', 'user_id', 'ip_address')),
        			 	 	array(
        			 	 		 'ip_address' => $this->getUserIpAddr(),
        			 	 		   'user_id' =>  0,
        			 	 )
        			 	 );
	 	     	}
    			 	
			  if($sender_id == $user_check[0]->id){
			      		  
	     /*Unseen message count*/
                    for($i = 0; $i < count($admin_list); $i++){
                         $admin_list[$i]->message_count = $this->crud_model->get_user_chat_messages(
    			 			'COUNT',
    			 			array('chat_message' => array('sender_id', 'receiver_id', 'chat_messages_text', 'chat_messages_status', 'chat_messages_datetime')),
    			 			array('chat_messages_status' => 1, 'message_seen' => 0, 'receiver_id' => $admin_list[$i]->id, 'sender_id' => $sender_id)
    			 		);
    
                    }
                    
                    /*total unseed message*/
                    $total_unseen_message = $this->crud_model->get_user_chat_messages(
    			 			'COUNT',
    			 			array('chat_message' => array('sender_id', 'receiver_id', 'chat_messages_text', 'chat_messages_status', 'chat_messages_datetime')),
    			 			array('chat_messages_status' => 1, 'message_seen' => 0, 'sender_id' => $sender_id)
    			 		);
    			 		
    			 		$data=array();
                        array_push($data, $admin_list);
                        array_push($data, $total_unseen_message);
    
                    echo json_encode($data);
			  }
			  
	       
	}

	public function insertUserQuestion(){
		$data['course_id'] = $this->input->post('courseid');
		 
		$data['title'] = $this->input->post('title');
		$data['description'] = $this->input->post('description');
		$data['user_id'] = $this->session->userdata('user_id');
		
		
		$done = $this->instructor_model->insertUserQuestionAndAnswer($data);
	    echo json_encode($done);
	}

	public function get_specific_question($id){

		$data['question_and_ans'] = $this->instructor_model->get_specific_question_and_answer(
			"OBJECT",
			array(
				'user' => array('first_name', 'last_name', 'profile_photo_name'),
				'question_and_ans' => array('id', 'title', 'description', 'created_at')
			),
			array('question_and_ans.id' => $id)
		);

		$data['replay_list'] = $this->instructor_model->get_all_replay_message_list(
			"OBJECT",
			array(
				'user' => array('first_name', 'last_name', 'profile_photo_name', 'instructor'),
				'question_replay' => array('id', 'replay_message', 'created_at')
			),
			
			array('question_id' => $id)
		);

		echo json_encode($data);
	}

	public function get_replay_list($replay_id){

		$replay_list = $this->instructor_model->get_all_replay_message_list(
			"OBJECT",
			array(
				'user' => array('first_name', 'last_name', 'profile_photo_name', 'instructor'),
				'question_replay' => array('id', 'replay_message', 'created_at')
			),
			
			array('question_id' => $replay_id)
		);

		echo json_encode($replay_list);
	}

	public function get_announcement_data($id){

		$response =  $this->instructor_model->get_all_announcement(
			'OBJECT',
			 array(
			 	'announcement' => array( 'id', 'title', 'description', 'course_id', 'instructor_id',  'created_at')),
 			array('announcement.id' => $id)
		);

		echo json_encode($response);
	}

	public function save_review(){
		require_once 'vendor/autoload.php';
		date_default_timezone_set('Asia/Dhaka');

		$options = array(
		  'cluster' => 'ap1',
		  'useTLS' => true
		);
		$pusher = new Pusher\Pusher(
		  'c203510a7bc26284f91c',
		  'ec23a09f4d77b6904700',
		  '1118283',
		  $options
		);



		$data['course_id'] = $this->input->post('course_id');
		$rating = $this->input->post('rating');
		$data['review'] = $this->input->post('review');
		$data['user_id'] = $this->session->userdata('user_id');
		if($rating == 'first-star'){
			$data['rating'] = 1;
		}else if($rating == 'second-star'){
			$data['rating'] = 2;
		}else if($rating == 'third-star'){
			$data['rating'] = 3;
		}else if($rating == 'fourth-star'){
			$data['rating'] = 4;
		}else if($rating == 'fifth-star'){
			$data['rating'] = 5;
		}
		
		$check_review = $this->course_model->get_course_review_data($data['course_id'], "COUNT");
		
		if($check_review == 0){
			$review = $this->course_model->save_course_review($data);
		}else{
			
			$review = $this->course_model->save_course_review($data, $data['course_id'], $data['user_id']);
		}
		

		if($review['success']){

			$pusher_data['notification_id'] = $data['course_id'];
			$pusher_data['notification_type'] = 'course_review';
			$pusher->trigger('my-channel', 'my-event', $pusher_data);
			$response = $this->user_model->save_notification_data($pusher_data);
			$message['message'] = $review['message'];
			$message['success'] = $review['success'];
			echo json_encode($message);
		}else{
			echo false;
		}

	}

	public function get_review($course_id){

		
		$review_data = $this->course_model->get_course_review_data(($course_id), "OBJECT");
		
		if(isset($review_data)){
			echo json_encode($review_data);
		}else{
			echo false;
		}

	}

	public function save_course_notes(){
		if ($this->session->userdata('user_id')) {
			$data['course_id'] = $this->input->post('course_id');
			$data['lesson_id'] = $this->input->post('lesson_id');
			$data['notes'] = $this->input->post('notes');
			$data['lesson_time'] = $this->input->post('lesson_time');
			$data['user_id'] = $this->session->userdata('user_id');

			$result = $this->course_model->save_course_notes($data);
			if($result['success']){
				echo true;
			}else{
				echo false;
			}
			// echo json_encode($data);
		}else{
			echo "Please login first.";
		}
	}

	public function remove_course_notes(){

		$notes_id = $this->input->post('notes_id');

		$result = $this->course_model->remove_course_notes($notes_id);

		if($result['success']){
			echo true;
		}else{
			echo false;
		}
	}

	public function get_next_preview_video(){

		$lesson_id = $this->input->post('lesson_id'); 
		$course_id = $this->input->post('course_id');

		$result = $this->course_model->getPreviewNextLessonId($course_id, $lesson_id);
		
		if(isset($result)){
			echo json_encode($result);
		}
		
	}

	public function get_quize_set_info_by_id($quiz_set_id) {
		echo json_encode(
			$this->quiz_model->get_quiz_set_list(
				'OBJECT',
				true,
				array('quiz_set' => array('id', 'name', 'lesson_id', 'type', 'question_id_list', 'duration', 'quiz_result', 'free_access')),
				array('quiz_set.id' => $quiz_set_id)
			));
	}

	public function save_capture(){

		
		$image_data = json_decode($_POST["name"]);
		

		$image = explode(";", $image_data->image)[1];
		
		$image = explode(",", $image)[1];
		
		$image = str_replace(" ", "+", $image);
		$image = base64_decode($image);

		$path ='assets/users_certificate';

		
		if(!file_exists($path)) {
		    mkdir($path, 0777, true);
		}

		$name = $path.'/'.$image_data->name.'.jpeg';

		file_put_contents($name, $image);
		
	} 

	
}