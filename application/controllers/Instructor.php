<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructor extends CI_Controller {
	private $page_data = [];
	
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->pagination_config = array();
		$this->load->model('service/service_course', 'service_course');
		$this->session->set_userdata('previous_url', current_url());
		if ($this->session->userdata('user_type') !== "USER" && $this->session->userdata('user_type') !== "ADMIN" && $this->session->userdata('user_type') !== "SUPER_ADMIN") {
			redirect(site_url('login'), 'refresh');
		}
		$this->page_data['instructor_page_name'] = "";

		$this->pagination_config = array();

		if (!$this->session->userdata('cart_items')) {
			$this->session->set_userdata('cart_items', array());
		}
		$filter_array = array();
		$filter_array['instructor_id'] = $this->session->userdata('user_id');

		$this->page_data['instructor_courses_count'] = $this->instructor_model->get_course_list_with_enrollment(
			'all',
			array(

				'course' => array('id')
			),
			"COUNT",
			$filter_array	
		);

		$total_sell = $this->instructor_model->get_course_list_with_enrollment(
			"all",
			array(
				'course' => array('id')
			),
			"OBJECT",
			$filter_array,
			"total_sell"
			
		);
		$this->page_data['total_revenue'] = 0;

		foreach($total_sell as $sell){
			$this->page_data['total_revenue'] += $sell->total_profit;
			
		}	

		// $this->page_data['total_withdraw_amount'] = $this->instructor_model->get_instructor_total_withdraw_amount(
		// 	"OBJECT",
		// 	array('id'),
		// 	array('instructor_id' => $this->session->userdata('user_id'))
		// );
		$this->page_data['total_withdraw_amount'] = $this->instructor_model->get_sum_of_withdraw_amount(
				$this->session->userdata('user_id')
		);

		$this->page_data['date_range'] = 'all';

		$this->page_data['system_name'] = get_settings('system_name');
		$this->page_data['instructor_page_name'] = 'instructor_panel';
		$this->page_data['system_name'] = get_settings('system_name');
		$this->page_data['category_list'] = $this->category_model->get_category_for_menu();
		$wishlist = $this->user_model->get_user_by_id($this->session->userdata('user_id'), array('id', 'wishlist'))->wishlist;
		$this->page_data['wishlist'] = json_decode($wishlist == null ? '[]' : $wishlist);
		$this->page_data['user_data'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'), array('profile_photo_name', 'first_name', 'last_name', 'email', 'id', 'instructor'));

		if($this->page_data['user_data']->instructor != 1){
			redirect('home/page_not_found', 'refresh');
		}
	}

	// public function index() {
	// 	$this->my_courses();
	// }


	public function index(){

		$this->page_data['page_name'] = "instructor_courses";
		$this->page_data['page_title'] = "Instructor Panel";
		$this->page_data['page_view'] = "instructor/index";
		$filter_array = array();
		$filter_array['instructor_id'] = $this->session->userdata('user_id');
		
			
		

		// if(isset($_GET['search_range'])){
		// 	$date_range = $_GET['search_range'];
		// }else{
		// 	$date_range = '7 DAY';
		// }
		$this->page_data['instructor_courses'] = $this->instructor_model->get_course_list_with_enrollment(
			NULL,
			array('course' => array('id', 'title', 'price', 'discounted_price', 'instructor_share', 'discount_flag')),
			"OBJECT",
			$filter_array
		);

		// $this->page_data['total_withdraw_amount'] = $this->instructor_model->get_instructor_total_withdraw_amount(
		// 	"OBJECT",
		// 	array('id'),
		// 	array('instructor_id' => $this->session->userdata('user_id'))
		// );

		$this->page_data['total_withdraw_amount'] = $this->instructor_model->get_sum_of_withdraw_amount(
				$this->session->userdata('user_id')
		);

		// $this->page_data['date_range'] = $date_range;
		$this->page_data['sub_page_view'] = "total_enrollment";
		$this->load->view('index', $this->page_data);


	}

	public function total_sell($date_range = ''){

		$this->page_data['page_name'] = "total_sell";
		// $this->page_data['instructor_page_name'] = "instructor";
		$this->page_data['page_title'] = "Instructor Panel";
		$this->page_data['page_view'] = "instructor/index";
		$filter_array = array();
		$filter_array['instructor_id'] = $this->session->userdata('user_id');
		
		if(isset($_GET['search_range'])){
			$date_range = $_GET['search_range'];
		}else{
			$date_range = 'all';
		}

		$this->page_data['total_sell'] = $this->instructor_model->get_course_list_with_enrollment(
			$date_range,
			array(
				'course' => array('id', 'title')
			),
			"OBJECT",
			$filter_array,
			"total_sell"
			
		);

		


		
		
		// $this->page_data['total_sell'] = $this->instructor_model->get_enrollment_history_by_instructor_id($this->session->userdata('user_id'), $date_range);
		

		$this->page_data['date_range'] = $date_range;
		$this->page_data['sub_page_view'] = "total_sell";
		$this->load->view('index', $this->page_data);


	}

	public function money_withdraw($date_range = ''){

		$this->page_data['page_name'] = "money_withdraw";
		// $this->page_data['instructor_page_name'] = "instructor";
		$this->page_data['page_title'] = "Money Withdraw";
		$this->page_data['page_view'] = "instructor/index";
		
		
		if(isset($_GET['search_range'])){
			$date_range = $_GET['search_range'];
		}else{
			$date_range = '12 MONTH';
		}

		$total_profit = $this->instructor_model->get_course_list_with_enrollment(
			$date_range,
			array(
				'course' => array('id', 'title')
			),
			"OBJECT",
			array('instructor_id' =>  $this->session->userdata('user_id')),
			"total_sell"
			
		);

		$total_profit_amount = 0;
		foreach ($total_profit as $key => $profit) {
			$total_profit_amount += $profit->total_profit; 
		}

		/* get instructor  withdraw amount details*/

		$this->page_data['withdraw_amount_details'] = $this->instructor_model->get_instructor_payment_withdraw_details(
			"OBJECT",
			array('id', 'instructor_id', 'withdraw_amount', 'payment_left', 'created_at'),
			array('instructor_id' => $this->session->userdata('user_id'))
		);

		/* get instructor total withdraw amount*/
		// $this->page_data['total_withdraw_amount'] = $this->instructor_model->get_instructor_total_withdraw_amount(
		// 	"OBJECT",
		// 	array('id'),
		// 	array('instructor_id' => $this->session->userdata('user_id'))
		// );
		$this->page_data['total_withdraw_amount'] = $this->instructor_model->get_sum_of_withdraw_amount(
				$this->session->userdata('user_id')
		);


		$this->page_data['pending_balance'] = ($total_profit_amount- $this->page_data['total_withdraw_amount'][0]->total_withdraw_amount);

		
		
		// $this->page_data['total_sell'] = $this->instructor_model->get_enrollment_history_by_instructor_id($this->session->userdata('user_id'), $date_range);
		

		$this->page_data['date_range'] = $date_range;
		$this->page_data['sub_page_view'] = "money_withdraw";
		$this->load->view('index', $this->page_data);


	}

	public function course($course_id = '', $question_ans_title = '',  $offset = 0){
	
		if($course_id == '' || $course_id == null){
		    redirect(base_url('page_not_found'));
		}
		$this->page_data['page_name'] = "course_info_page";
		// $this->page_data['instructor_page_name'] = "instructor";
		$this->page_data['page_title'] = "Course Info";
		$this->page_data['page_view'] = "instructor/course_content/course_manage";

		$this->page_data['course_id'] = $course_id;

		$this->page_data['course_detail'] = $this->course_model->get_course_list(
			"OBJECT",
			array('mock_test', 'title'),
			array('id' => $course_id)
		)[0];

		// debug($course_details);



		// if($question_ans_id == ""){
			if($question_ans_title == 'question_and_answer' || $question_ans_title == '' ){
				
				if(is_numeric($course_id) == false){
					redirect(base_url('page_not_found'));
				}
				$this->page_data['question_and_ans_list'] = $this->instructor_model->get_question_and_answer($course_id);

				$this->page_data['sub_page_view'] = 'q&a';
			}else if($question_ans_title == 'announcement'){
				if(is_numeric($course_id) == false){
					redirect(base_url('page_not_found'));
				}
				$this->page_data['announcement_list'] = $this->instructor_model->get_all_announcement(
					'OBJECT',
					 array(
					 	'announcement' => array( 'id', 'title', 'description', 'instructor_id',  'created_at')),
		 			array('course_id' => $course_id)
				);
				$this->page_data['sub_page_view'] = 'announcement';

				
			}else if($question_ans_title == 'users'){

				if(isset($_GET['user_info'])){

					$this->page_data['user_assessment_all'] = [];

					if (isset($_GET['enrollment'])) {
						$this->page_data['user_assessment_all'] = $this->quiz_model->get_quiz_result_by_enroll_id($_GET['enrollment']);
					}

					$this->page_data['course_id'] = $course_id;

					if (isset($_GET['enrollment']) && isset($_GET['quiz'])) {

						$this->page_data['user_assessment'] = $this->quiz_model->get_assessment_by_enroll_id(
							"OBJECT",
							array(
								"user_assessment" => array("id", "set_id", "question_and_answer_list"),
								'quiz_set' => array('quiz_result')
							),
							array(
								"user_assessment.enrollment_id" => $_GET['enrollment'],
								"user_assessment.set_id" => $_GET['quiz'],
							)
							
						);

						 // debug($this->page_data['user_assessment']);
					}

					$this->page_data['sub_page_view'] = 'quiz_result';
				}else{
					$this->page_data['enrolled_user_list'] = $this->instructor_model->get_course_list_with_user_enrollment(
						'all',
						 array(
						 	
						 	'user' => array('id', 'first_name', 'last_name', 'email'),
					 		'enrollment' => array('id as enrollment_id', 'created_at', 'access'),
					 		'enrollment_payment' => array('status', 'amount'),
					 		'course' => array('id as course_id', 'title')
						 ),
						 "OBJECT",
			 			array('course_id' => $course_id)
					);

					// debug($this->page_data['enrolled_user_list']);
					$this->page_data['sub_page_view'] = 'enrollment_users';
				}
				
			}else if($question_ans_title == 'questions'){
				if(is_numeric($course_id) == false){
					redirect(base_url('page_not_found'));
				}
				$this->page_data['sub_page_view'] = 'questions';
				$pagination_config['per_page'] = 0;

					if(isset($_GET['pagination'])){
						$pagination_config['per_page'] = $_GET['pagination'];
					}else{
						$pagination_config['per_page'] = 10;
					}


				$search_question = null;
				if(isset($_GET['search_question'])){
					$search_question = $_GET['search_question'];
				}

				$pagination_config['total_rows'] = $this->quiz_model->get_all_question_by_course_id(
					"COUNT",
					$course_id,
					$search_question
					// $_GET['user_search_type']
				);

				$this->page_data['question_list'] = $this->quiz_model->get_all_question_by_course_id(
					"OBJECT",
					$course_id,
					$search_question,
					($search_question != null) ? null:array('limit' => $pagination_config['per_page'], 'offset' => $offset)
				);


				for ($i = 0; $i < count($this->page_data['question_list']); $i++) {
					$this->page_data['question_list'][$i]->option_list = json_decode($this->page_data['question_list'][$i]->option_list);
				}


				


				$this->page_data['page_limit'] = 3;
				$this->page_data['number_of_total_question'] = $pagination_config['total_rows'];
				$this->page_data['offset'] = $offset;

				$pagination_config['base_url'] = site_url('instructor/course/'.$course_id.'/questions/');
				$pagination_config['num_links'] = 4;
				$pagination_config['reuse_query_string'] = TRUE;

				$pagination_config['full_tag_open'] = '<div class="pagination-bar">';
				$pagination_config['full_tag_close'] = '</div>';
				$pagination_config['attributes'] = array('class' => 'pagination-bar-node');
				$pagination_config['first_link'] = 'First page';
				$pagination_config['last_link'] = 'Last page';
				$pagination_config['cur_tag_open'] = '<span class="pagination-bar-node-active">';
				$pagination_config['cur_tag_close'] = '</span>';

				$this->pagination->initialize($pagination_config);


					
				

				
			}else if($question_ans_title == 'quiz_set'){
				if(is_numeric($course_id) == false){
					redirect(base_url('page_not_found'));
				}
				$this->page_data['sub_page_view'] = 'quiz_set';

				$this->page_data['course_info'] = $this->course_model->get_course_list(
					"OBJECT",
					array('id', 'title'),
					array('id' => $course_id)
				)[0];

				$this->page_data['course_info']->lesson_list = $this->lesson_model->get_lesson_list_by_course_id($this->page_data['course_info']->id, array('id', 'title'));

			
			$this->page_data['question_list'] = $this->quiz_model->get_question_list_by_course($course_id)->result_array();

			if (isset($_GET['option'])) {
				$this->session->set_userdata('option', $_GET['option']);
				if ($_GET['option'] == 'course') {

					$this->session->unset_userdata('lesson_id');

					$this->page_data['quiz_set_list'] = $this->quiz_model->get_quiz_set_list(
						'OBJECT',
						true,
						array('quiz_set' => array('id', 'name', 'type', 'question_id_list', 'duration', 'quiz_result', 'free_access')),
						array(
							'quiz_set.course_id' => $course_id,
							'quiz_set.lesson_id' => null,
						)
					);

				} else if ($_GET['option'] == 'lesson') {

					$this->session->set_userdata('lesson_id', $_GET['lesson_id']);

					if (html_escape($_GET['lesson_id']) != null && html_escape($_GET['lesson_id']) != '') {

						$this->page_data['quiz_set_list'] = $this->quiz_model->get_quiz_set_list(
							'OBJECT',
							true,
							array(
								'quiz_set' => array('id', 'name', 'type', 'question_id_list' , 'duration', 'quiz_result', 'free_access'),
								'lesson' => array('title'),
							),
							array(
								'quiz_set.course_id' => $course_id,
								'quiz_set.lesson_id' => ($_GET['lesson_id']),
							)
						);
						// exit;
					}
				}
			}

			}else if($question_ans_title == 'addQuestionInQuiz'){


				if(is_numeric($course_id) == false){
					redirect(base_url('page_not_found'));
				}

				$this->page_data['quiz_set_id'] = $offset;
				$this->page_data['sub_page_view'] = 'add_question';

				$this->page_data['course_info'] = $this->course_model->get_course_list(
					"OBJECT",
					array('id', 'title'),
					array('id' => $course_id)
				)[0];

				// $this->page_data['course_info']->lesson_list = $this->lesson_model->get_lesson_list_by_course_id($this->page_data['course_info']->id, array('id', 'title'));

				$this->page_data['quiz_set_list'] = $this->quiz_model->get_quiz_set_list(
					'OBJECT',
					true,
					array('quiz_set' => array('id',  'question_id_list')),
					array(
						'quiz_set.course_id' => $course_id,
						'quiz_set.lesson_id' => ($this->session->userdata('lesson_id') ? $this->session->userdata('lesson_id'): null),
					)
				);
				// debug($this->page_data['quiz_set_list']);

				$this->page_data['quiz_question_id'] = array();
				$this->page_data['question_id'] = array();
				foreach($this->page_data['quiz_set_list'] as $quiz_set){
					foreach($quiz_set->question_id_list as $questions){
						array_push($this->page_data['quiz_question_id'], $questions);
					}	
				}
				
				$question = $this->quiz_model->get_all_question_by_course_id(
					"OBJECT",
					$course_id,
					null,
					null,
					array("id")
					
				);
					// debug($question);
				foreach($question as $q){

					array_push($this->page_data['question_id'], $q->id);
				}

			

				$result = array_diff($this->page_data['question_id'], $this->page_data['quiz_question_id']);

				
				$this->page_data['question_list'] = array();
				foreach($result as $r){
				// debug($course_id);
				$question_list = $this->quiz_model->get_all_question_by_course_id(
					"OBJECT",
					$course_id,
					null,
					null,
					// array("id", 'question', 'option_list', 'right_option_value', 'explanation'),
					array("id" => $r)
					
					);
				array_push($this->page_data['question_list'], $question_list);
				}	



				// debug($this->page_data['question_list']);



			}else if($question_ans_title == 'show_questions'){

				if(is_numeric($course_id) == false){
					redirect(base_url('page_not_found'));
				}

				$this->page_data['quiz_set_id'] = $offset;
				$this->page_data['sub_page_view'] = 'show_question';

				$this->page_data['course_info'] = $this->course_model->get_course_list(
					"OBJECT",
					array('id', 'title'),
					array('id' => $course_id)
				)[0];


				$this->page_data['quiz_set_list'] = $this->quiz_model->get_quiz_set_list(
								'OBJECT',
								true,
								array('quiz_set' => array('id','question_id_list')),
								array(
									'quiz_set.course_id' => $course_id,
									'quiz_set.id' => $offset,
									'quiz_set.lesson_id' => ($this->session->userdata('lesson_id') ? $this->session->userdata('lesson_id'): null),
								)
							)[0];


				// debug($this->page_data['quiz_set_list']);

			}else if($question_ans_title == 'reviews'){

				if(is_numeric($course_id) == false){
					redirect(base_url('page_not_found'));
				}
				$this->page_data['sub_page_view'] = 'reviews';

				$this->page_data['course_info'] = $this->course_model->get_course_list(
					"OBJECT",
					array('id', 'title'),
					array('id' => $course_id)
				)[0];


				$this->page_data['course_review_list'] = $this->course_model->get_course_review_list_with_user(
					"OBJECT",
					array(
						'course_review' => array('id', 'status', 'rating', 'review', 'created_at'),
						'user' => array('first_name', 'last_name', 'email'),
						'course' => array('id as course_id')
					),
					array('course_id' => $course_id),
					NULL,
					null
				);
				
			}else{

				$this->page_data['quiz_set_list'] = $this->quiz_model->get_quiz_set_list(
					'OBJECT',
					true,
					array('quiz_set' => array('id', 'name', 'type', 'question_id_list', 'duration', 'quiz_result', 'free_access')),
					array(
						'quiz_set.course_id' => $course_id,
						'quiz_set.lesson_id' => null,
					)
				);

				if (isset($_GET['quiz'])) {
					if(isset($_GET['per_page'])){
						$offset = $_GET['per_page'];
					}else{
						$offset = 0;
					}
					
					if(isset($_GET['start_date'])){
						$start_date = $_GET['start_date'];
					}else{
						$start_date = null;
					}

					if(isset($_GET['end_date'])){
						$end_date = $_GET['end_date'];
					}else{
						$end_date = null;
					}

					$pagination_config['per_page'] = 10;
					$pagination_config['total_rows'] = 100;

					$pagination_config['total_rows'] = $this->quiz_model->get_assessment_by_set_id(
						"COUNT",
						$_GET['quiz'],
						NULL,
						$start_date,
						$end_date
					);

					
					if(isset($_GET['per_page'])){
						$pagination_config['per_page'] = $_GET['per_page'];
					}else{
						$pagination_config['per_page'] = 10;
					}

					$this->page_data['user_assessment'] = $this->quiz_model->get_assessment_by_set_id(
						"OBJECT",
						$_GET['quiz'],
						array('limit' => $pagination_config['per_page'], 'offset' => $offset),
						$start_date,
						$end_date
					);

					
					$this->page_data['page_limit'] = $pagination_config['per_page'];
					$this->page_data['number_of_total_quiz_result_data'] = $pagination_config['total_rows'];
					$this->page_data['offset'] = $offset;
					
					$pagination_config['base_url'] = site_url('instructor/course/'.$course_id.'/exam?quiz='.$_GET['quiz']);
					$pagination_config['num_links'] = 3;
					$pagination_config['page_query_string'] = TRUE;
					$pagination_config['reuse_query_string'] = FALSE;
					$pagination_config['full_tag_open'] = '<div class="pagination-bar">';
					$pagination_config['full_tag_close'] = '</div>';
					$pagination_config['attributes'] = array('class' => 'pagination-bar-node');
					$pagination_config['first_link'] = 'First page';
					$pagination_config['last_link'] = 'Last page';
					$pagination_config['cur_tag_open'] = '<span class="pagination-bar-node-active">';
					$pagination_config['cur_tag_close'] = '</span>';

					$this->pagination->initialize($pagination_config);

					 // debug($this->page_data['user_assessment']);
				}

				$this->page_data['sub_page_view'] = 'exam';
			}
			
		// }else{
			
			 // if($question_ans_title == 'question_and_answer'){
			 // 	$this->page_data['sub_page_view'] = 'question_replay';
			 // 	$this->page_data['question_ans_id'] = $question_ans_id;
			 // }else{
			 // 	$this->page_data['sub_page_view'] = 'question_replay';
			 // 	$this->page_data['question_ans_id'] = $question_ans_id;
			 // }
			
		// }

		
		$this->load->view('index', $this->page_data);
	}


	public function save_quiz_set_form($course_id) {
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>', '</div>');

		if ($this->form_validation->run('course_quiz_set_form') == FALSE) {
			$this->redirect(base_url('course/quiz_set/' . $course_id));
		} else {

			$this->service_course->save_quiz_set($course_id);
		}
	}

	public function save_question_for_course($course_id){
		$quiz_set_id = html_escape($this->input->post('quiz_set_id'));
		$data['course_id'] = $course_id;

		if (html_escape($this->input->post('lesson_id')) != null) {
			$data['lesson_id'] = html_escape($this->input->post('lesson_id'));
		} else {
			$data['lesson_id'] = NULL;
		}


		$quiz_set_list = $this->quiz_model->get_quiz_set_list(
			'OBJECT',
			true,
			array('quiz_set' => array('question_id_list')),
			array(
				'quiz_set.id' => $quiz_set_id,
				'quiz_set.lesson_id' => ($data['lesson_id'] ? $data['lesson_id']: null),
			)
		)[0];
		

		
		$existing_data = implode(',', $quiz_set_list->question_id_list);



		$question_id_list = html_escape($this->input->post('question_id'));
		$current_questions = implode(',', $question_id_list);

		if($existing_data != null && $existing_data != ""){
			$questions = $existing_data.','.$current_questions;
		}else{
			$questions = $current_questions;
		}


		$explode_questions = explode(',', $questions);
		$data['question_id_list'] = '["' . implode('","', $explode_questions) . '"]';


		if ($quiz_set_id != null && $quiz_set_id != '') {
			// if (has_role($this->session->userdata('user_id'), 'QUIZ_UPDATE')) {
				$result = $this->quiz_model->insert_set($data, $quiz_set_id);
			
				if ($result) {
					if ($result['success']) {

					


						$this->session->set_flashdata('quiz_set_save_success', 'Quiz set is updated successfully.');
					} else {
						$this->session->set_flashdata('quiz_set_save_failed', $result['message']);
					}
				} else {
					$this->session->set_flashdata('quiz_set_save_failed', 'Failed to updated!');
				}
			// } else {
			// 	redirect(base_url('page_not_found'));
			// }

		} else {
			// if (has_role($this->session->userdata('user_id'), 'QUIZ_CREATE')) {
				$result = $this->quiz_model->insert_set($data);
				if ($result) {
					if ($result['success']) {

						$this->session->set_flashdata('quiz_set_save_success', 'Quiz set is inserted successfully.');
					} else {
						$this->session->set_flashdata('quiz_set_save_failed', $result['message']);
					}
				} else {
					$this->session->set_flashdata('quiz_set_save_failed', 'Failed to insert!');
				}
			// } else {
			// 	redirect(base_url('page_not_found'));
			// }
		}

		redirect(base_url('instructor/course/' . $course_id .'/quiz_set?option=course'));



	}



	public function remove_quiz_question_from_course($course_id){
		$quiz_set_id = $this->input->post('quiz_set_id');
		$lesson_id = $this->input->post('lesson_id');
		$question_id_list = ($this->input->post('question_id'));


		$quiz_set_list = $this->quiz_model->get_quiz_set_list(
			'OBJECT',
			true,
			array('quiz_set' => array('question_id_list')),
			array(
				'quiz_set.id' => $quiz_set_id,
				'quiz_set.lesson_id' => ($lesson_id ? $lesson_id: null),
			)
		)[0];


		$result = array_diff($quiz_set_list->question_id_list, $question_id_list);

		$questions_implode_list = implode(',', $result);

		$questions_explode_list = explode(',', $questions_implode_list);
		
		$data['question_id_list'] = '["' . implode('","', $questions_explode_list) . '"]';



		if($quiz_set_id != null && $quiz_set_id != ""){

				$result = $this->quiz_model->insert_set($data, $quiz_set_id);

				
				if ($result) {
					if ($result['success']) {

						$this->session->set_flashdata('quiz_set_save_success', 'Question removed successfully.');
					}else{
						$this->session->set_flashdata('quiz_set_save_failed', 'Failed to remove.');

					}
				}else{
					$this->session->set_flashdata('quiz_set_save_failed', 'Failed to remove.');

				}
		}


	redirect(base_url('instructor/course/' . $course_id .'/quiz_set?option=course'));

	}






	/*
		* Service  - for remove quiz set
	*/
	public function remove_quiz_set_from_course($course_id, $quiz_set_id) {
			if ($quiz_set_id != null) {
				$result = $this->quiz_model->delete_quiz_set($quiz_set_id);
				if ($result['success']) {

					$this->session->set_flashdata('quiz_set_save_success', 'Quiz set removed successfully.');
				} else {
					$this->session->set_flashdata('quiz_set_save_failed', 'Quiz set failed to remove.');
				}
			}
			redirect(base_url('instructor/course/' . $course_id. '/quiz_set?option=course'));
	
	}	



/*Service for replay messages*/
	public function replay_message(){

		$data['replay_message'] = html_escape($this->input->post('replay_message'));
		$data['question_id'] = html_escape($this->input->post('question_ans_id'));
		$data['user_id'] = $this->session->userdata('user_id');
		$data['course_id'] = html_escape($this->input->post('course_id'));

		$response = $this->instructor_model->insertReplayMessage($data);

		if($response['success'] == 'true'){
			$this->session->set_flashdata('replay_message_success', "Message send successfully.");

		}else{
			$this->session->set_flashdata('replay_message_failed', "Message send to failed!! Please contact support.");

		}



		redirect($_SERVER['HTTP_REFERER']);


	}

/* Announcement Service for insert*/
	public function insert_announcement(){
		$data['title'] = html_escape($this->input->post('title'));
		$data['description'] = html_escape($this->input->post('description'));
		$data['instructor_id'] = $this->session->userdata('user_id');
		$data['course_id'] = html_escape($this->input->post('course_id'));

		$response = $this->instructor_model->insertAnnouncement($data);

		if($response['success'] == 'true'){
			$this->session->set_flashdata('announcement_success', "Anouncements save successfully.");

		}else{
			$this->session->set_flashdata('announcement_failed', "Anouncements failed to save!! Please contact to our support.");

		}



		redirect($_SERVER['HTTP_REFERER']);
	}

/* Announcement Service for delete*/

	public function remove_announcement($announcement_id){


		$response = $this->instructor_model->remove_announcement($announcement_id);

		if($response['success'] == 'true'){
			$this->session->set_flashdata('announcement_success', "Anouncements removed successfully.");

		}else{
			$this->session->set_flashdata('announcement_failed', "Anouncements failed to remove!! Please contact to our support.");

		}

		redirect($_SERVER['HTTP_REFERER']);
	}

/* Announcement Service for update*/

	public function update_announcement(){
		$id = html_escape($this->input->post('announcement_id'));
		$data['title'] = html_escape($this->input->post('title'));
		$data['description'] = html_escape($this->input->post('description'));
		$data['instructor_id'] = $this->session->userdata('user_id');
		$data['course_id'] = html_escape($this->input->post('course_id'));

		$response = $this->instructor_model->updateAnnouncement($id, $data);

		if($response['success'] == 'true'){
			$this->session->set_flashdata('announcement_success', "Anouncements updated successfully.");

		}else{
			$this->session->set_flashdata('announcement_failed', "Anouncements failed to update!! Please contact to our support.");

		}



		redirect($_SERVER['HTTP_REFERER']);
	}


}