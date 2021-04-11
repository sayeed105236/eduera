<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->userdata('user_type') !== "USER" && $this->session->userdata('user_type') !== "ADMIN" && $this->session->userdata('user_type') !== "SUPER_ADMIN") {
			redirect(site_url('login'), 'refresh');
		}
		$this->session->set_userdata('previous_url', current_url());
		$this->pagination_config = array();
		$this->page_data['instructor_page_name'] = "";
		
		if (!$this->session->userdata('cart_items')) {
			$this->session->set_userdata('cart_items', array());
		}

		$this->page_data['notification_count'] = $this->corporate_model->get_company_list(
			"COUNT",
			array(
				'company_user' => array('company_id'),
			),
			array(
				'company_user.user_id' => $this->session->userdata('user_id'),
				'company_user.request_status' => 'PENDING',
			)
		);

		$this->page_data['system_name'] = get_settings('system_name');
		$this->page_data['category_list'] = $this->category_model->get_category_for_menu();
		$wishlist = $this->user_model->get_user_by_id($this->session->userdata('user_id'), array('id', 'wishlist'))->wishlist;
		$this->page_data['wishlist'] = json_decode($wishlist == null ? '[]' : $wishlist);
		$this->page_data['user_data'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'), array('profile_photo_name', 'first_name', 'last_name', 'email', 'id', 'instructor'));
	}

	public function index() {
		$this->my_courses();
	}

/*
 * Controller for user/my_courses
 */
	public function my_courses($offset = 0) {

		$this->page_data['page_name'] = "my_courses";
		$this->page_data['page_title'] = 'My courses';
		$this->page_data['page_view'] = 'user/course_list';
		$this->page_data['sub_page_name'] = "course_list_my_courses";



// Filter by category related code
		$filter = $this->getFilterArray();

		$this->pagination_config['per_page'] = 10;
		$this->pagination_config['total_rows'] = $this->crud_model->get_enrollment_info_by_user_id("COUNT", $this->session->userdata('user_id'), array("enrollment" => array('id')), null, $filter);

// Retrieve enrollment history along with few course data
		$this->page_data['course_list'] = $this->crud_model->get_enrollment_info_by_user_id("OBJECT", $this->session->userdata('user_id'), array(
			"enrollment" => array('id as enroll_id', 'enrolled_price', 'expiry_date'),
			"course" => array('id', 'title', 'short_description', 'language', 'slug', 'mock_test'),
		), array('limit' => $this->pagination_config['per_page'], 'offset' => $offset), $filter, "SUM");

// Load the default course view. we are here loadin a default view because
		// there are few common functionality that works for both user/my_courses and user/wishlist
		$this->my_board_course_default_view();
	}

/*
 * Controller for user/wishlist
 */
	public function wishlist($offset = 0) {
		$this->page_data['page_name'] = "wishlist";
		$this->page_data['page_title'] = 'Wishlist';
		$this->page_data['page_view'] = 'user/course_list';
		$this->page_data['sub_page_name'] = "course_list_wishlist";

// Filter by category related code
		$filter = $this->getFilterArray();

		$this->pagination_config['per_page'] = 10;
		$this->pagination_config['total_rows'] = $this->course_model->get_wishlist_courses_by_user_id("COUNT", $this->session->userdata('user_id'), array('id'), null, $filter);
		$this->page_data['course_list'] = $this->course_model->get_wishlist_courses_by_user_id("OBJECT", $this->session->userdata('user_id'), array('id', 'slug', 'title', 'price'), array('limit' => $this->pagination_config['per_page'], 'offset' => $offset), $filter);

		// Load the default course view. we are here loadin a default view because
		// there are few common functionality that works for both user/my_courses and user/wishlist

		$this->my_board_course_default_view();
	}

/*
 * Controller for user/inbox
 */
	public function inbox() {
		$this->page_data['page_name'] = "inbox";
		$this->page_data['page_title'] = 'Inbox';
		$this->page_data['page_view'] = 'user/inbox';
		$this->load->view('index', $this->page_data);

	}

/*
 * Controller for user/notification
 */
	public function notification() {
		$this->page_data['page_name'] = "notification";
		$this->page_data['page_title'] = 'notification';
		$this->page_data['page_view'] = 'user/notification';

		$this->page_data['company_add_request_list'] = $this->corporate_model->get_company_list(
			"OBJECT",
			array(
				'company_user' => array('company_id', 'corporate_role', 'designation_id', 'department_id', 'request_status'),
				'company' => array('name as company_name'),
				'designation' => array('name as designation'),
				'department' => array('name as department'),
			),
			array(
				'company_user.user_id' => $this->session->userdata('user_id'),
				'company_user.request_status' => 'PENDING',
			)
		);

		$this->load->view('index', $this->page_data);

	}

/*
 * Controller for user/payment_history
 */
	public function payment_history() {
		$this->page_data['page_name'] = "payment_history";
		$this->page_data['page_title'] = 'Payment history';
		$this->page_data['page_view'] = 'user/payment_history';

		$this->page_data['payment_info_list'] = $this->crud_model->get_payment_info_list("OBJECT", $this->session->userdata('user_id'), "APPROVED");

// Retrieve enrollment history along with few course data
		$this->page_data['course_list'] = $this->crud_model->get_enrollment_info_by_user_id("OBJECT", $this->session->userdata('user_id'), array(
			"enrollment" => array('id as enroll_id', 'enrolled_price'),
			"course" => array('id', 'title'),
		), null, null, "SUM");

		for ($i = 0; $i < count($this->page_data['course_list']); $i++) {
			$this->page_data['course_list'][$i]->percentage_to_pay = -1;
		}

		$this->load->view('index', $this->page_data);

	}

/*
 *   Controller for profile page (Ex: user/profile/info)
 */
	public function profile($sub_page = "") {

// Validation of profile info form
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>', '</div>');

// Sub page setup
		if ($sub_page == "" || $sub_page == null) {
			$this->page_data['sub_page_name'] = "profile_info";
			$this->page_data['sub_page_title'] = "Profile info";
		} else if ($sub_page == 'info') {
			$this->page_data['sub_page_name'] = "profile_info";
			$this->page_data['sub_page_title'] = "Profile info";
		} else if ($sub_page == 'credential') {
			$this->page_data['sub_page_name'] = "profile_credential";
			$this->page_data['sub_page_title'] = "Credential";
		} else if ($sub_page == 'photo') {
			$this->page_data['sub_page_name'] = "profile_photo";
			$this->page_data['sub_page_title'] = "Photo";
		} else {
			redirect('home/page_not_found', 'refresh');
		}

		$this->page_data['page_name'] = "profile";
		$this->page_data['page_title'] = 'User profile';
		$this->page_data['page_view'] = 'user/profile';

		if ($this->page_data['sub_page_name'] === "profile_info") {

			if ($this->form_validation->run('update_profile_info_form') == FALSE) {

// If the form is not valid. Show the whole page (along with the error page if it after hitting the save button)
				$this->page_data['user_data'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'), array('id', 'first_name', 'last_name', 'phone', 'email', 'biography', 'social_links', 'profile_photo_name', 'instructor'));
				if ($this->page_data['user_data']->social_links == null || $this->page_data['user_data']->social_links == "") {
					$this->page_data['user_data']->social_links = (object) [];
					$this->page_data['user_data']->social_links->facebook = "";
					$this->page_data['user_data']->social_links->twitter = "";
					$this->page_data['user_data']->social_links->linkedin = "";
				} else {
					$this->page_data['user_data']->social_links = json_decode($this->page_data['user_data']->social_links);
				}

				$this->load->view('index', $this->page_data);

			} else {

// If the form is valid, redirect to the service method to update the form
				$this->update_profile_info();
			}

		} else if ($this->page_data['sub_page_name'] === "profile_credential") {

			if ($this->form_validation->run('change_credential_form') == FALSE) {

// If the form is not valid. Show the whole page (along with the error page if it after hitting the save button)
				$this->page_data['user_data'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'), array('id', 'first_name', 'last_name', 'email', 'profile_photo_name', 'instructor'));
				$this->load->view('index', $this->page_data);

			} else {

// If the form is valid, redirect to the service method to update the form
				$this->change_user_credential();
			}
		} else if ($this->page_data['sub_page_name'] === "profile_photo") {

			$this->page_data['user_data'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'), array('id', 'first_name', 'last_name', 'profile_photo_name', 'instructor'));
			$this->load->view('index', $this->page_data);
		}

	}

/*
 *   Controller for user assessment
 */
	public function user_assessment() {

		$this->page_data['page_name'] = "user_assessment";
		$this->page_data['page_title'] = 'User Assessment';
		$this->page_data['page_view'] = 'user/user_assessment';
		$this->page_data['sub_page_name'] = "user_assessment";

		$this->page_data['enrollment_list'] = $this->crud_model->get_enrollment_info_by_user_id("OBJECT", $this->session->userdata('user_id'), array(
			"enrollment" => array('id as enrollment_id'),
			"course" => array('id as course_id', 'title as course_title'),
		));

		for ($i = 0; $i < count($this->page_data['enrollment_list']); $i++) {
			$this->page_data['enrollment_list'][$i]->lesson_list = $this->lesson_model->get_lesson_list_by_course_id($this->page_data['enrollment_list'][$i]->course_id, array("id", "title"));
		}

		if (isset($_GET['enrollment_id'])) {

			$this->page_data['user_assessment'] = $this->quiz_model->get_assessment_by_enroll_id(
				"OBJECT",
				array(
					"user_assessment" => array("id", "set_id", "question_and_answer_list"),
				),
				array(
					"user_assessment.enrollment_id" => $_GET['enrollment_id'],
					"quiz_set.lesson_id" => isset($_GET['lesson_id']) ? $_GET['lesson_id'] : NULL,
				)
			);

		}
		$this->load->view('index', $this->page_data);
	}

	/*
		 *   Controller for user quiz result
	*/
	public function quiz_result() {

		$this->page_data['page_name'] = "quiz_result";
		$this->page_data['page_title'] = 'Quiz Result';
		$this->page_data['page_view'] = 'user/quiz_result';
		$this->page_data['sub_page_name'] = "quiz_result";

		$this->page_data['enrollment_list'] = $this->crud_model->get_enrollment_info_by_user_id("OBJECT", $this->session->userdata('user_id'), array(
			"enrollment" => array('id as enrollment_id'),
			"course" => array('id as course_id', 'title as course_title'),
		));
		$this->page_data['user_assessment_all'] = [];
		if (isset($_GET['enrollment_id'])) {
			$this->page_data['user_assessment_all'] = $this->quiz_model->get_quiz_result_by_enroll_id($_GET['enrollment_id']);
		}

		if (isset($_GET['enrollment_id']) && isset($_GET['set_id'])) {

			$this->page_data['user_assessment'] = $this->quiz_model->get_assessment_by_enroll_id(
				"OBJECT",
				array(
					"user_assessment" => array("id", "set_id", "question_and_answer_list", "question_and_explanation"),
					'quiz_set' => array('quiz_result')
				),
				array(
					"user_assessment.enrollment_id" => $_GET['enrollment_id'],
					"user_assessment.set_id" => $_GET['set_id'],
				)
				
			);

			 // debug($this->page_data['user_assessment']);


		}
		$this->load->view('index', $this->page_data);
	}

/*
 *   Controller for viewing course list in my board.
 */
	public function my_board_course_default_view() {

		$this->pagination_config['base_url'] = site_url('user/' . $this->page_data['page_name']);
		$this->pagination_config['num_links'] = 10;
		$this->pagination_config['reuse_query_string'] = TRUE;
		$this->pagination_config['full_tag_open'] = '<div class="pagination-bar">';
		$this->pagination_config['full_tag_close'] = '</div>';
		$this->pagination_config['attributes'] = array('class' => 'pagination-bar-node');
		$this->pagination_config['first_link'] = 'First page';
		$this->pagination_config['last_link'] = 'Last page';
		$this->pagination_config['cur_tag_open'] = '<span class="pagination-bar-node-active">';
		$this->pagination_config['cur_tag_close'] = '</span>';

		$this->pagination->initialize($this->pagination_config);

		$this->page_data['filter_list'] = array();

		if (isset($_GET['category']) || isset($_GET['sub_category'])) {
			foreach ($this->page_data['category_list'] as $category) {
				if (isset($_GET['category']) && $category->id == $_GET['category']) {

					array_push($this->page_data['filter_list'], array(
						'type' => 'category',
						'parameter' => $category->id,
						'chip_text' => $category->name,
						'tooltip_text' => 'Category',
					));

				}

				if (isset($_GET['sub_category'])) {
					foreach ($category->sub_category_list as $sub_category) {
						if ($sub_category->id == $_GET['sub_category']) {

							array_push($this->page_data['filter_list'], array(
								'type' => 'sub_category',
								'parameter' => $sub_category->id,
								'chip_text' => $sub_category->name,
								'tooltip_text' => 'Sub-category',
							));
							break 2;
						}
					}
				}
			}
		}

		if (isset($_GET['search'])) {

			array_push($this->page_data['filter_list'], array(
				'type' => 'search',
				'parameter' => $_GET['search'],
				'chip_text' => $_GET['search'],
				'tooltip_text' => 'Search',
			));
		}

		$this->load->view('index', $this->page_data);
	}

/*
 * Controller - Per Cousre Lesson view for user
 */
	public function lesson($course_id, $lesson_id = null) {

		$enrolled_expiry_date = get_user_enrolled_course_expiry_date($this->session->userdata('user_id'), $course_id);
		$current_date = date('Y-m-d');
			
		if($enrolled_expiry_date == $current_date){
			redirect(base_url('home/course_expiry'));
		}
	
		$user_course_access_info = access_in_a_course($this->session->userdata('user_id'), $course_id);
		$this->page_data['user_course_access_info'] = $user_course_access_info;
	

		if (!$user_course_access_info['has_enrolled']) {
		
			redirect(base_url('home/page_not_found'));
		} else {

			$this->page_data['page_name'] = "lesson";
			$this->page_data['page_view'] = 'user/lesson';

			$this->page_data['course_details'] = $this->course_model->get_course_list(
				"OBJECT",
				array('id', 'title', 'slug', 'certificate', 'short_description', 'language', 'level', 'description', 'outcomes', 'requirements', 'instructor_id', 'mock_test'),
				array('id' => $course_id)
			)[0];


			if($this->page_data['course_details']->instructor_id != 0){

				$this->page_data['instructor_details'] = $this->user_model->get_user_by_id($this->page_data['course_details']->instructor_id, array('id', 'first_name', 'last_name', 'phone', 'email', 'biography', 'social_links', 'profile_photo_name', 'instructor'));
			}
			
			$this->page_data['next_lesson_id'] = null;

			$this->page_data['course_details']->enrollment = $this->crud_model->get_enroll_count_of_a_course($this->page_data['course_details']->id);
			$this->page_data['course_details']->outcomes = json_decode($this->page_data['course_details']->outcomes);
			$this->page_data['course_details']->requirements = json_decode($this->page_data['course_details']->requirements);

			$this->page_data['page_title'] = $this->page_data['course_details']->title;
			$this->page_data['course_details']->section_list = $this->section_model->get_section_list_by_course_id($this->page_data['course_details']->id, array('id', 'title', 'rank'));

			$this->page_data['course_details']->duration_in_second = 0;
			$this->page_data['course_details']->lesson_count = 0;


			for ($i = 0; $i < count($this->page_data['course_details']->section_list); $i++) {
				$this->page_data['course_details']->section_list[$i]->lesson_list = $this->lesson_model->get_lesson_list_by_section_id($this->page_data['course_details']->section_list[$i]->id, array('id', 'title', 'duration_in_second', 'rank', 'section_id', 'vimeo_id', 'lesson_file as lesson_file_list'));
				for ($j = 0; $j < count($this->page_data['course_details']->section_list[$i]->lesson_list); $j++) {
					if ($this->page_data['course_details']->section_list[$i]->lesson_list[$j]->lesson_file_list != null) {
						$this->page_data['course_details']->section_list[$i]->lesson_list[$j]->lesson_file_list = json_decode($this->page_data['course_details']->section_list[$i]->lesson_list[$j]->lesson_file_list);

						$this->page_data['course_details']->section_list[$i]->lesson_list[$j]->lesson_quiz = $this->quiz_model->get_quiz_set_list(
							"OBJECT",
							true,
							array(
								'quiz_set' => array('id', 'name', 'question_id_list', 'duration', 'free_access'),
							),
							array(
								'lesson_id' => $this->page_data['course_details']->section_list[$i]->lesson_list[$j]->id,
								'course_id' => $course_id,
								'type' => 'END',
							)
						);

						// debug($this->page_data['course_details']->section_list[$i]->lesson_list[$j]->lesson_quiz);

					}
					$this->page_data['course_details']->duration_in_second += $this->page_data['course_details']->section_list[$i]->lesson_list[$j]->duration_in_second;
					$this->page_data['course_details']->lesson_count++;
				}
			}
			$this->page_data['lesson_id'] = $lesson_id;
			$this->page_data['lesson_info'] = null;
			if(!$this->page_data['course_details']->mock_test){
				if ($this->page_data['lesson_id'] == null) {
					$this->page_data['lesson_id'] = $this->page_data['course_details']->section_list[0]->lesson_list[0]->id;
				}

				if (!in_array($this->page_data['lesson_id'], $user_course_access_info['lesson_id_list'])) {
					redirect(base_url('home/page_not_found'));
				}


				$this->page_data['lesson_info'] = $this->lesson_model->get_lesson_list('OBJECT', array('id', 'section_id', 'vimeo_id', 'summary', 'title', 'duration_in_second', 'lesson_file', 'rank', 'video_type', 'video_id'), array('id' => $this->page_data['lesson_id']), null)[0];

				$this->page_data['next_lesson'] = $this->course_model->getNextLessonId($course_id,$this->page_data['lesson_info']->section_id, $this->page_data['lesson_info']->rank);

				$this->page_data['next_lesson_id'] = 0;

				if(isset($this->page_data['next_lesson'][0])){
					$this->page_data['next_lesson_id'] = $this->page_data['next_lesson'][0]->id;

				}
				
				$this->page_data['lesson_info_json'] = $this->lesson_model->get_lesson_list('OBJECT', array('id', 'section_id', 'vimeo_id', 'title', 'duration_in_second', 'rank', 'video_type', 'video_id'), array('id' => $this->page_data['lesson_id']), null)[0];

			}
			
			
			
			
			$quiz_list = $this->quiz_model->get_quiz_set_list(
				"OBJECT",
				true,
				array(
					'quiz_set' => array('id', 'name', 'question_id_list', 'duration', 'free_access'),
				),
				array(
					'lesson_id' => $this->page_data['lesson_id'],
					'type' => 'END',
				)
			);

			$this->page_data['course_quiz_list'] = $this->quiz_model->get_quiz_set_list(
				"OBJECT",
				true,
				array(
					'quiz_set' => array('id', 'name', 'question_id_list', 'duration', 'free_access'),
				),
				array(
					'lesson_id' => null,
					'course_id' => $course_id,
					'type' => 'END'
				)
			);
		

			if (count($quiz_list) > 0) {
				$this->page_data['quiz'] = $quiz_list[rand(0, count($quiz_list) - 1)];
				for ($i = 0; $i < count($this->page_data['quiz']->question_list); $i++) {
					$this->page_data['quiz']->question_list[$i]->option_list = json_decode($this->page_data['quiz']->question_list[$i]->option_list);
				}
			} else {
				$this->page_data['quiz'] = null;
			}

			

			if(!$this->page_data['course_details']->mock_test){

				if (count($this->page_data['course_quiz_list']) > 0) {
	// $this->page_data['course_quiz'] = $course_quiz_list[rand(0, count($course_quiz_list) - 1)];
					for ($j = 0; $j < count($this->page_data['course_quiz_list']); $j++) {
						for ($i = 0; $i < count($this->page_data['course_quiz_list'][$j]->question_list); $i++) {
							$this->page_data['course_quiz_list'][$j]->question_list[$i]->option_list = json_decode($this->page_data['course_quiz_list'][$j]->question_list[$i]->option_list);
						}
					}
				} else {
					$this->page_data['course_quiz_list'] = null;
				}



				if ($this->page_data['lesson_info']->id) {
					$this->page_data['user_lesson_status'] = $this->lesson_model->get_lesson_status(
						"OBJECT",
						array('finished_time', 'lesson_id', 'user_id', 'id'),
						array(
							'user_id' => $this->session->userdata('user_id'),
							'lesson_id' => $this->page_data['lesson_info']->id,
						)
					);

				}

				$this->page_data['lesson_duration'] = $this->lesson_model->get_lesson_list_by_users_status(
					$this->session->userdata('user_id'),
					'OBJECT',
					array(
						
						// 'user_lesson_status' => array('finished_time', 'updated_at'),
						'lesson' => array('id', 'title', 'duration_in_second'),
					),
					array('course_id' => $course_id)
				);


					$this->page_data['total_course_duration'] = 0;
					$this->page_data['total_user_lesson_duration'] = 0;
					$this->page_data['total_percentage'] = 0;
					foreach ($this->page_data['lesson_duration'] as $lesson) {

						$this->page_data['total_course_duration'] = $this->page_data['total_course_duration'] + $lesson->duration_in_second;

						$this->page_data['total_user_lesson_duration'] = $this->page_data['total_user_lesson_duration'] + $lesson->finished_time;

					}
					if($this->page_data['total_user_lesson_duration'])
					{
						$this->page_data['total_percentage'] = round(($this->page_data['total_user_lesson_duration'] * 100) / $this->page_data['total_course_duration']);
					}
					



					          
				    /* Email send when course complete or 90 %*/        
					if ($this->page_data['total_percentage']  > 90) {
						if ($this->page_data['course_details']->certificate) {
						   $image_path = $_SERVER['DOCUMENT_ROOT'] . '/eduera/assets/frontend/certificate/';

						   $verify_certificate_mail = $this->crud_model->get_enrollment_list(
						   	"OBJECT",
						   	array('certificate_mail_send'),
						   	array("user_id" => $this->page_data['user_data']->id, "course_id" => $this->page_data['course_details']->id)
						   	 )[0];
						  
						   if($verify_certificate_mail->certificate_mail_send == 0){
							   	$email_msg = $this->load->view('template/certificate_email', $this->page_data, true);
							   	$subject = 'Your completion certificate is ready for "'.$this->page_data['course_details']->title .'"';
							   	
							   	$mail_send_done = $this->email_model->send_certificate_mail($this->page_data['user_data']->email, $email_msg, $subject);

							   	if($mail_send_done == 1){
							   			$data['certificate_mail_send'] = 1;
							   			$this->crud_model->update_user_certificate_serial_no($this->page_data['course_details']->id, $this->page_data['user_data']->id, $data);
							   	}
						   }
				                 
				           
						}
					}

					$this->page_data['course_notes'] = $this->course_model->get_course_notes($course_id, $this->page_data['lesson_id'], $this->session->userdata('user_id'));
			}
			

			/* Question and Answer*/

			$this->page_data['question_and_ans_list'] = $this->instructor_model->get_question_and_answer($course_id);
			
			for($i = 0; $i < count($this->page_data['question_and_ans_list']); $i++){
				$this->page_data['question_and_ans_list'][$i]->replay = $this->instructor_model->get_all_replay_message_list(
					"OBJECT",
					array(
						'question_replay' => array('id')
					),
			
					array('question_id' => $this->page_data['question_and_ans_list'][$i]->id)
					);

			}

			/* Announcement*/
		
				$this->page_data['announcement_list'] = $this->instructor_model->get_all_announcement(
					'OBJECT',
					 array(
					 	'announcement' => array( 'id', 'title', 'description', 'instructor_id',  'created_at'),
					 	'user' => array('first_name', 'last_name', 'profile_photo_name')
					 ),
		 			array('course_id' => $course_id)
				);

				
				if(!$this->page_data['course_details']->mock_test){
					$this->page_data['section_info'] = $this->section_model->get_section_list(
						'OBJECT',
						array('id', 'title', 'rank'),
						array('id' => $this->page_data['lesson_info']->section_id)
					) ;
				}

			

				$this->page_data['course_review'] = $this->course_model->get_course_review_data($course_id, "OBJECT");
				
				$this->page_data['wishes'] = is_course_in_wishlist($course_id, $this->session->userdata('user_id'));
				// debug($this->page_data['wishes']);

			
			$this->load->view('index', $this->page_data);
		}

	}

	/*
		 *   Controller for user assessment
	*/
	public function course_status() {
		$course_id = $this->input->post('course_id');
		$this->page_data['page_name'] = "course_status";
		$this->page_data['page_title'] = 'Course Status';
		$this->page_data['page_view'] = 'user/course_status';
		$this->page_data['sub_page_name'] = "course_status";

		$this->page_data['course_list'] = $this->crud_model->get_enrollment_info_by_user_id("OBJECT", $this->session->userdata('user_id'), array(
			"course" => array('id', 'title'),
		));
		if ($course_id) {
			$this->page_data['lesson_list'] = $this->lesson_model->get_lesson_list_by_users_status(
				$this->session->userdata('user_id'),
				'OBJECT',
				array(
					
					// 'user_lesson_status' => array('updated_at'),
					'lesson' => array('id', 'title', 'duration_in_second'),
				),
				array('course_id' => $course_id)
			);

			$this->page_data['total_course_duration'] = 0;
			$this->page_data['total_user_lesson_duration'] = 0;
			foreach ($this->page_data['lesson_list'] as $lesson) {
				$this->page_data['total_course_duration'] += $lesson->duration_in_second;
				$this->page_data['total_user_lesson_duration'] += $lesson->finished_time;
			}

		}

		// debug($this->page_data['lesson_list']);

		$this->load->view('index', $this->page_data);
	}

/*
 *   Service - to update profile info.
 */
	public function update_profile_info() {
		$data = array(
			'first_name' => html_escape($this->input->post('first_name')),
			'last_name' => html_escape($this->input->post('last_name')),
			'biography' => html_escape($this->input->post('biography')),
			'phone' => html_escape($this->input->post('phone')),
			'social_links' => '{"twitter":"' . html_escape($this->input->post('twitter')) . '","facebook":"' . html_escape($this->input->post('facebook')) . '","linkedin":"' . html_escape($this->input->post('linkedin')) . '"}',
		);
		$this->session->set_userdata('phone', $this->input->post('phone'));
		$result = $this->user_model->update_user_info($this->session->userdata('user_id'), $data);

		if ($result) {
			$this->session->set_flashdata('profile_info_update_successful', "Information updated successfully.");
		} else {
			$this->session->set_flashdata('failed_to_update_profile_info', "Failed to update profile info!! Please contact support.");
		}

		redirect(site_url('user/profile/info'), 'refresh');
	}

/*
 *   Service - to change password.
 */
	public function change_user_credential() {
		$result = $this->user_model->update_user_password($this->session->userdata('user_id'), $_POST);

		if ($result['success']) {
			$this->session->set_flashdata('credential_change_successful', "Password changed successfully.");
		} else {
			$this->session->set_flashdata('credential_change_failed', $result['message']);
		}

		redirect(site_url('user/profile/credential'), 'refresh');
	}

/*
 *   Service - to upload profile photo.
 */
	public function upload_profile_photo() {
		$config['upload_path'] = './uploads/user_image';
		$config['allowed_types'] = 'jpg|png|JPG|PNG';
		$config['file_name'] = md5($this->session->userdata('email')) . '_' . $this->session->userdata('user_id');
		$config['max_size'] = 512;
		$config['max_width'] = 1075;
		$config['max_height'] = 1024;
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('user_profile_photo')) {
			$this->session->set_flashdata('profile_photo_upload_error', $this->upload->display_errors());
		} else {
			if ($this->user_model->update_user_info($this->session->userdata('user_id'), array("profile_photo_name" => $this->upload->data()['file_name']))) {

				$this->session->set_flashdata('profile_photo_upload_successful', "Profile photo uploaded successfully!");
			} else {
				$this->session->set_flashdata('profile_photo_upload_error', "Failed to save in database!");
			}

		}
		redirect(site_url('user/profile/photo'));
	}

/*
 *   Service - return a filter key word related array (basically for javascript use).
 */
	public function getFilterArray() {
		$filter = null;
		if (isset($_GET['sub_category'])) {
			$filter = array('category' => array($_GET['sub_category']));
		} else if (isset($_GET['category'])) {
			$filter = array('category' => array($_GET['category']));

			$subcategory_list = $this->category_model->get_sub_category_list_by_category_id($_GET['category'], array('id'));
			foreach ($subcategory_list as $subcategory) {
				array_push($filter['category'], $subcategory->id);
			}
		}

		if(isset($_GET['course'])){
				$filter['title'] = $_GET['course'];
		}

		if (isset($_GET['search'])) {
			$filter['search_text'] = $_GET['search'];
		}

		
		return $filter;
	}

	public function add_to_wishlist() {
		$course_id = $_POST['course_id'];
		if (isset($course_id)) {
			echo json_encode($this->crud_model->handleWishList($course_id));
		}

	}

/*
 *	 update company
 */
	public function update_company_request($company_id = null, $status) {
		if ($company_id == null || $company_id == '') {
			redirect(base_url('page_not_found'));
		}

		$this->corporate_model->update_company_user($company_id, $this->session->userdata('user_id'), $status);
		redirect(base_url('user/notification'));
	}

	/*Certificate Load*/

	public function load_certificate($course_id, $user_id) {

		$certificate_info = $this->crud_model->getCertificateSerialNo($course_id, $user_id)[0];
		
		redirect(base_url('home/get_certificate/' . $certificate_info->certificate_key));
	}

/*Certificate download*/
	public function download_certificate($certificate_key) {

		$certificate_info = $this->crud_model->get_user_certificate_serial_no(
			"OBJECT",
			NULL,
			NULL,
			array(
				"certificate" => array(
					'certificate_no',
					'course_name',
					'user_seen_duration',
					'created_at',
					'certificate_key',
					'course_id',
				),
				"user" => array(
					"first_name",
					"last_name",

				),
			),
			array("certificate_key" => $certificate_key)
		)[0];

		$get_date = date('d', strtotime($certificate_info->created_at));
		$get_month = date('m', strtotime($certificate_info->created_at));
		$get_year = date('Y', strtotime($certificate_info->created_at));

// Create date object to store the DateTime format
		$dateObj = DateTime::createFromFormat('!m', $get_month);

// Store the month name to variable
		$monthName = $dateObj->format('F');

		if ($certificate_info->course_id == 1) {
				$certificate_info->course_name = 'IT Service Management Foundation';
			} elseif ($certificate_info->course_id == 4) {
				$certificate_info->course_name = 'Project Management Foundation';
			}elseif ($certificate_info->course_id == 67) {
				$certificate_info->course_name = 'PRINCE2 Foundation';
			} elseif ($certificate_info->course_id == 8) {
				$certificate_info->course_name = 'Project Management Practitioner';
			}else if($certificate_info->course_id == 56){
				$certificate_info->course_name = 'ITIL4 Foundation Exam Preparation Training';
			}else if($certificate_info->course_id == 60){
				$certificate_info->course_name = 'ITIL 4 Foundation';
			}else if($certificate_info->course_id == 78){
				$certificate_info->course_name = 'ITIL 4 Strategist: Direct, Plan and Improve';
			} else {
				$certificate_info->course_name;
			}
		$name = $certificate_info->first_name . ' ' . $certificate_info->last_name;
		$output = '<html>
	<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
	<style type="text/css">
	<!--
	span.cls_003{font-family:"Monotype Corsiva",serif;font-size:46.1px;color:rgb(81,94,101);font-weight:normal;font-style:italic;text-decoration: none}
	div.cls_003{font-family:"Monotype Corsiva",serif;font-size:46.1px;color:rgb(81,94,101);font-weight:normal;font-style:italic;text-decoration: none}
	span.cls_002{font-family:"Monotype Corsiva",serif;font-size:24.7px;color:rgb(81,94,101);font-weight:normal;font-style:italic;text-decoration: none}
	div.cls_002{font-family:"Monotype Corsiva",serif;font-size:24.7px;color:rgb(81,94,101);font-weight:normal;font-style:italic;text-decoration: none}
	span.cls_004{font-family:"Monotype Corsiva",serif;font-size:10.0px;color:rgb(43,42,41);font-weight:normal;font-style:italic;text-decoration: none}
	div.cls_004{font-family:"Monotype Corsiva",serif;font-size:14.0px;color:rgb(43,42,41);font-weight:normal;font-style:italic;text-decoration: none}
	span.cls_005{font-family:"Monotype Corsiva",serif;font-size:6.9px;color:rgb(43,42,41);font-weight:normal;font-style:italic;text-decoration: none}
	div.cls_005{font-family:"Monotype Corsiva",serif;font-size:6.9px;color:rgb(43,42,41);font-weight:normal;font-style:italic;text-decoration: none}
	-->
	</style>
	<script type="text/javascript" src="5fddaf08-7982-11ea-8b25-0cc47a792c0a_id_5fddaf08-7982-11ea-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>
	</head>
	<body id="certificate_view">
	<div style="position:absolute;left:50%;margin-left:-420px;top:0px;width:841px;height:595px;border-style:outset;overflow:hidden">
	<div style="position:absolute;left:0px;top:0px">
	<img src="./assets/frontend/certificate/' . $certificate_info->course_id . '.jpg" width=841 height=595></div>
	<div style="position:absolute;left:191.59px;top:152.23px" class="cls_003"><span class="cls_003">Certification of completion</span></div>

	<div class="row" style=" text-align: center; position:absolute; left:130.62px;top:280.02px; padding-right: 30px;">
	    <div class="col-md-12">
	        <span class="cls_002 cls_003" style="font-weight:italic;">' . $certificate_info->first_name . ' ' . $certificate_info->last_name . '  has successfully completed <br><span style="color:#e33667;">' . $certificate_info->course_name . '</span> online training on ' . $get_date . ' ' . $monthName . ', ' . $get_year . ' </span>
	    </div>
	</div>

	<div style="position:absolute;left:16.06px;top:567.77px;" class="cls_004"><span class="cls_004">Certificate no: ' . $certificate_info->certificate_no . '</span></div>
	<div style="position:absolute;right:16.06px;top:567.77px;font-weight:bold" class="cls_004"><span class="cls_004">Verification URL:  www.eduera.com.bd/home/certificate</span></div>


	</body>
	</html>
	';

		include APPPATH . 'libraries/dompdf/autoload.inc.php';

		$dompdf = new Dompdf\Dompdf();
		$htmlcontent = $output;

		$dompdf->loadHtml($htmlcontent);

		$customPaper = array(2, -15, 665, 470);
		$dompdf->set_paper($customPaper);

		$dompdf->render();

		$dompdf->stream($certificate_info->course_name . ".pdf", array("Attachment" => 0));

	}

	/*
	 * Controller for user/my_messages
	 */
		public function my_messages() {
			$this->page_data['page_name'] = "my_messages";
			$this->page_data['page_title'] = 'My Messages';
			$this->page_data['page_view'] = 'user/my_messages';

			
			$this->page_data['user_message_list'] = $this->user_model->get_user_messages(
			        'OBJECT',
			        array('id', 'user_id', 'admin_id', 'message', 'created_at')
		    );
			
		    $message_user_list = array();
		    
		    for($i = 0; $i < count($this->page_data['user_message_list']); $i++){
		        $this->page_data['user_message_list'][$i]->user_id = json_decode($this->page_data['user_message_list'][$i]->user_id);
		        array_push($message_user_list, $this->page_data['user_message_list'][$i]->user_id);	
				
		    }

		    
		   

			$this->load->view('index', $this->page_data);

		}


		
}