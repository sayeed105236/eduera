<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	private $page_data = [];
	 var $user_country ;
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if (!$this->session->userdata('cart_items')) {
			$this->session->set_userdata('cart_items', array());
		}

		$this->user_country = $this->user_model->getUserInfoByIpAddress();

		$config = array(
			'protocol' => get_settings('protocol'),
			'smtp_host' => get_settings('smtp_host'),
			'smtp_port' => get_settings('smtp_port'),
			'smtp_user' => get_settings('smtp_user'),
			'smtp_pass' => get_settings('smtp_pass'),
			'mailtype' => 'html',
			'charset' => 'utf-8',
		);
		
		$this->session->set_userdata('previous_url', current_url());
		$this->load->library('email', $config);
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->pagination_config = array();
		$this->page_data['system_name'] = get_settings('system_name');
		$this->page_data['category_list'] = $this->category_model->get_category_for_menu();
		$this->page_data['instructor_page_name'] = "";
		
		$this->page_data['notification_count'] = $this->corporate_model->get_company_list(
			"COUNT",
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

		$this->page_data['frontend_settings'] = $this->crud_model->get_frontend_settings_info(array('about_us', 'terms_and_condition', 'privacy_policy'));
		$this->page_data['system_settings'] = $this->crud_model->get_settings_info(array('phone', 'address', 'contact_email'));
		


		if ($this->session->userdata('user_type') !== null) {
			$this->page_data['user_data'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'), array('id', 'wishlist', 'profile_photo_name', 'instructor'));
			if ($this->page_data['user_data']->wishlist == null) {
				$this->page_data['wishlist'] = array();
			} else {
				$this->page_data['wishlist'] = json_decode($this->page_data['user_data']->wishlist);
			}
		}
		
		/*User message count*/
		if($this->session->userdata('user_id') !== null){
		    $login_user_info = $this->crud_model->get_user_chat_info_list(
		 	 	"OBJECT", 
		 	 	array('user_chat_info' => array('id', 'user_id', 'ip_address')),
		 	 	array(
		 	 		   'user_id' =>  $this->session->userdata('user_id'),
		 	    )
	 	     );

		}

		
		  
	}



/*
 *   Controller for base url.
 */
	public function index() {
		$this->home();
	}

	public function presentation($id = null){
		if($id == 67){
	        $this->load->view('PRINCE.html');
	    }else{
        	$this->load->view('ITIL4.html');
	    }
		
	}

/*
 *   Controller for /home page
 */
	public function home() {
		
		$this->page_data['page_name'] = "home";


		$this->page_data['page_title'] = "Home";
		$this->page_data['page_view'] = "home/index";

		if ($this->page_data['page_name'] == "home") {
			$this->page_data['courses_list'] = $this->course_model->get_courses_list(
				"OBJECT",
				array('id', 'price', 'status',  'discount_flag', 'discounted_price', 'rank'),
				NULL,
				NULL,
				"ORDER"
			);

			$this->page_data['categories']  = $this->category_model->get_category_list(array('id', 'name'));
			
			// foreach($this->page_data['category'] as $cat){
			// 	debug($cat->name);
			// }
			$this->page_data['course_list'] = $this->course_model->get_course_list_with_rank()->result();
			$this->page_data['new_course_list'] = $this->course_model->get_course_list_with_rank('new')->result();
			$this->page_data['free_course_list'] = $this->course_model->get_course_list_with_rank('free')->result();
			$this->page_data['certification_course_list'] = $this->course_model->get_course_list_with_rank('certification')->result();
			$this->page_data['mock_test_course_list'] = $this->course_model->get_course_list_with_rank('mock_test')->result();
			$this->page_data['home_page_setting'] = $this->crud_model->home_page_setting();
			// debug($this->page_data['free_course_list']);
			$this->page_data['currency_data'] = $this->user_model->get_currency_data('USD');
			$this->page_data['user_address'] = $this->user_model->getUserInfoByIpAddress();
			$user_id = 0;
			$user_id = $this->session->userdata('user_id');
			if(isset($user_id)){
				$this->page_data['user_course_list'] = $this->crud_model->get_enrollment_info_by_user_id(
					"OBJECT", 
					$this->session->userdata('user_id'), 
					array(
					"enrollment" => array('id as enroll_id', 'enrolled_price', 'expiry_date'),
					"course" => array('id', 'title', 'short_description', 'language', 'slug', 'last_modified', 'created_at', 'outcomes'),
					), 
					array('limit' => 10, 'offset' => 0), 
					NULL,
					"SUM"
				);
			}

			

			
		}

		$this->load->view('index', $this->page_data);
	}

	public function get_wishlist() {
		$data = $this->user_model->get_user_by_id($this->session->userdata('user_id'), array('wishlist'));
		echo json_encode($data);

	}

/*
 *   Controller for /courses page
 *   This page shows all the courses
 */
	public function courses($offset = 0) {

		$pagination_config['per_page'] = 12;
		$course_list = [];

		if (isset($_GET['category'])) {

			$category_list = [$_GET['category']];
			$param = null;

			if(isset($_GET['category_name'])){
				$param = $_GET['category_name'];
			}

			if($_GET['category'] != ""){

				$subcategory_list = $this->category_model->get_sub_category_list_by_category_id($_GET['category'], array('id'));

				foreach ($subcategory_list as $subcategory){

					array_push($category_list, $subcategory->id);
				}
			}
		
			if(is_numeric($_GET['category'])){

				$course_list = $this->course_model->get_course_list_by_category_id_list("OBJECT", $category_list, array('id', 'title', 'category_id', 'slug', 'short_description', 'price', 'discount_flag', 'discounted_price', 'certification_course', 'mock_test'), array('limit' => $pagination_config['per_page'], 'offset' => $offset), $param);
				$pagination_config['total_rows'] = $this->course_model->get_course_list_by_category_id_list("COUNT", $category_list, array('id'));
			}

			else{

				$course_list = $this->course_model->get_course_list_with_rank($param, 'all', $pagination_config['per_page'], $offset)->result();

				$pagination_config['total_rows'] = $this->course_model->get_course_list_with_rank($param, 'all', null, null)->num_rows();
			}

		} else if (isset($_GET['query'])) {
			$pagination_config['total_rows'] = $this->course_model->get_course_list_by_searching_query_text("COUNT", $_GET['query'], array('id'));
		// Get course list by matching course title with query string
			$course_list = $this->course_model->get_course_list_by_searching_query_text("OBJECT", $_GET['query'], array('id', 'title', 'slug', 'short_description', 'price', 'discount_flag', 'discounted_price'), array('limit' => $pagination_config['per_page'], 'offset' => $offset));


		} else {
			$pagination_config['total_rows'] = $this->course_model->get_course_list(
				"COUNT",
				array('id')
			);
			$course_list = $this->course_model->get_course_list(
				"OBJECT",
				array('id', 'title', 'slug', 'short_description', 'price', 'discount_flag', 'discounted_price'),
				array('status' => 1),
				array('limit' => $pagination_config['per_page'], 'offset' => $offset));
			
		}

		$this->page_data['home_page_setting'] = $this->crud_model->home_page_setting();
		

		$this->page_data['page_name'] = "courses";
		$this->page_data['page_title'] = 'Courses';
		$this->page_data['page_view'] = "home/courses";
		$this->page_data['course_list'] = $course_list;
		$this->page_data['page_limit'] = $pagination_config['per_page'];
		$this->page_data['number_of_total_courses'] = $pagination_config['total_rows'];
		$this->page_data['number_of_courses_for_this_page'] = $pagination_config['per_page'] == count($course_list) ? $pagination_config['per_page'] : count($course_list);

		$pagination_config['base_url'] = site_url('home/courses/');
		$pagination_config['num_links'] = 10;
		$pagination_config['reuse_query_string'] = TRUE;
		$pagination_config['full_tag_open'] = '<div class="pagination-bar">';
		$pagination_config['full_tag_close'] = '</div>';
		$pagination_config['attributes'] = array('class' => 'pagination-bar-node');
		$pagination_config['first_link'] = 'First page';
		$pagination_config['last_link'] = 'Last page';
		$pagination_config['cur_tag_open'] = '<span class="pagination-bar-node-active">';
		$pagination_config['cur_tag_close'] = '</span>';

		$this->pagination->initialize($pagination_config);
		$this->load->view('index', $this->page_data);
	}

/*
 *   Controller for /course page
 *   This page shows the course details
 */
	public function course($course_slug = null) {

		if ($course_slug != null) {

			if (is_numeric($course_slug)) {
				$this->page_data['course'] = $this->course_model->get_course_list(
					"OBJECT",
					array('id', 'title', 'short_description', 'slug', 'level', 'last_modified', 'created_at', 'language', 'outcomes', 'requirements', 'description', 'preview_video_id', 'discount_flag', 'discounted_price', 'price', 'seo_title', 'meta_description', 'meta_tags'),
					array('id' => $course_slug)
				)[0];
			} else {
				$this->page_data['course'] = $this->course_model->get_course_list(
					"OBJECT",
					array('id', 'title', 'short_description', 'slug', 'level', 'last_modified', 'created_at', 'language', 'outcomes', 'requirements', 'description', 'preview_video_id', 'discount_flag', 'discounted_price', 'price', 'seo_title', 'meta_description', 'meta_tags'),
					array('slug' => $course_slug)
				)[0];
			}

			$this->page_data['wishlist'] = '';
			if ($this->session->userdata('user_id')) {
				$wishlist = $this->user_model->get_user_by_id($this->session->userdata('user_id'), array('id', 'wishlist'))->wishlist;
				$this->page_data['wishlist'] = json_decode($wishlist === null ? '[]' : $wishlist);
			}
			if ($this->page_data['course'] == null) {
				$this->page_data['page_name'] = "course_not_found";
			} else {
				$this->page_data['page_name'] = "course_detail";
				$this->page_data['course']->outcomes = json_decode($this->page_data['course']->outcomes);
				$this->page_data['course']->requirements = json_decode($this->page_data['course']->requirements);
				$this->page_data['course']->enrollment = $this->crud_model->get_enroll_count_of_a_course($this->page_data['course']->id);
				$this->page_data['course']->section_list = $this->section_model->get_section_list_by_course_id($this->page_data['course']->id, array('id', 'title'));

				$this->page_data['course']->duration_in_second = 0;
				$this->page_data['course']->lesson_count = 0;

				for ($i = 0; $i < count($this->page_data['course']->section_list); $i++) {
					$this->page_data['course']->section_list[$i]->lesson_list = $this->lesson_model->get_lesson_list_by_section_id($this->page_data['course']->section_list[$i]->id, array('id', 'title', 'vimeo_id', 'duration_in_second', 'preview',  'video_id', 'video_type'));
					$this->page_data['course']->section_list[$i]->duration_in_second = 0;
					foreach ($this->page_data['course']->section_list[$i]->lesson_list as $lesson) {
						$this->page_data['course']->section_list[$i]->duration_in_second += $lesson->duration_in_second;
						$this->page_data['course']->duration_in_second += $lesson->duration_in_second;
						$this->page_data['course']->lesson_count++;
					}
				}

				// $this->page_data['instructor_check_in_this_course'] = is_an_user_instructor_in_this_course($this->session->userdata('user_id'), $course_id);

				if ($this->session->userdata('user_id') == null) {
					$this->page_data['course']->is_current_user_enrolled = false;
				} else {
					$this->page_data['course']->is_current_user_enrolled = is_an_user_already_enrolled_in_a_course($this->session->userdata('user_id'), $this->page_data['course']->id);
				}

			}

			$this->page_data['coupon'] = $this->course_model->get_coupon_list(
				"COUNT",
				array('coupon' => array('coupon_code', 'course_id')),
				NULL,
				array('course_id' => $this->page_data['course']->id)
			);

			$this->page_data['course_review'] = $this->course_model->get_course_review_data($this->page_data['course']->id, "OBJECT");
			

			if($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPER_ADMIN' || is_an_user_instructor_in_this_course($this->session->userdata('user_id'), $this->page_data['course']->id)){
				$this->page_data['lesson_preview'] = $this->lesson_model->get_lesson_list(
					"OBJECT",
					array('id', 'title', 'section_id', 'video_type', 'video_id', 'vimeo_id', 'preview', 'duration_in_second', 'rank'),
					array('course_id' => $this->page_data['course']->id)
					);
			}else{
				$this->page_data['lesson_preview'] = $this->lesson_model->get_lesson_list(
					"OBJECT",
					array('id', 'title', 'section_id', 'video_type', 'video_id', 'vimeo_id', 'preview', 'duration_in_second', 'rank'),
					array('course_id' => $this->page_data['course']->id, 'preview' => 1)
					);
			}

			$this->page_data['coupon_details'] = array();
			if(isset($_GET['CouponCode'])){
				$this->page_data['coupon_details'] = $this->course_model->get_coupon_list(
					"OBJECT",
					array('coupon' => array('coupon_code', 'course_id', 'start_date', 'end_date', 'coupon_limit', 'already_applied', 'discount', 'discount_type', 'status')),
					NULL,
					array('coupon.status' => 1, 'coupon_code' => $_GET['CouponCode'], 'course_id' => $this->page_data['course']->id)
				);

				$this->page_data['course']->price =($this->page_data['course']->price - $this->page_data['coupon_details'][0]->discount);
				// debug($this->page_data['coupon_details'][0]->discount);
			}
			
			

			
			
		} else {
			$this->page_data['page_name'] = "page_not_found";
		}

		$this->page_data['page_title'] = 'Course';
		$this->page_data['page_view'] = "home/course_detail";
		$this->load->view('index', $this->page_data);
	}

/*
 *   Controller for shopping cart page
 */
	public function shopping_cart($coupon_code = null) {
		// if(isset)
		// debug($coupon_code);
		// if($coupon_code == NULL){
		// 	if(isset($_GET['payment_error'])){
		// 		if($_GET['payment_error'] == 'invalid'){
		// 			$this->session->set_flashdata('remove_cart_item_message_alart', "Checkout amount and course amount do not match!");

		// 		}else{
		// 			redirect('home/page_not_found', 'refresh');
		// 		}
		// 	}
		// }
	
	
		if ($coupon_code != null) {
			$coupon_info = $this->course_model->get_coupon_list(
				"OBJECT",
				array(
					'coupon' => array('coupon_code', 'discount_type', 'discount', 'start_date', 'end_date', 'status', 'id', 'course_id'),

				),
				NULL,
				array('coupon_code' => $coupon_code)
			)[0];
		}

		if (!$this->session->userdata('cart_items')) {
			$this->session->set_userdata('cart_items', array());
		}
		$this->page_data['cart_item_list'] = array();
		foreach ($this->session->userdata('cart_items') as $key => $value) {
			$course = $this->course_model->get_course_list(
				"OBJECT",
				array('id', 'title', 'language', 'discount_flag', 'discounted_price', 'price', 'slug'),
				array('id' => $value)
			)[0];

			if ($this->session->userdata('user_type') === "USER" || $this->session->userdata('user_type') === "ADMIN" || $this->session->userdata('user_type') === "SUPER_ADMIN") {
				$course->already_enrolled = is_an_user_already_enrolled_in_a_course($this->session->userdata('user_id'), $course->id);
				if ($course->already_enrolled) {
					$this->crud_model->remove_cart_item($course->id);
					continue;
				}
				$course->in_wishlist = is_course_in_wishlist($course->id, $this->session->userdata('user_id'));
			}

			if ($course->discount_flag) {
				if(get_user_country() == 'bd' || get_user_country() == 'BD'){
					
					  
						$course->amount_to_pay = $course->discounted_price;
					}else{
						$course->amount_to_pay  = substr(get_course_discounted_price($course->id), '1');
						
					}
				// $course->amount_to_pay = $course->discounted_price;

			} else {
				// $course->amount_to_pay = $course->price;

				if(get_user_country() == 'bd' || get_user_country() == 'BD'){
					
					  $course->amount_to_pay = $course->price;

					}else{
						$course->amount_to_pay  = substr(get_course_price($course->id), '1');
						
					}
			}

			/*Coupon Calculation*/
			if ($coupon_code != null) {
				//

				$course->coupon_amount = 0;
				$course->coupon_discount = '';
				$course->discount_type = '';
				if ($course->id == $coupon_info->course_id) {
					$course->coupon_id = $coupon_info->id;
					if ($coupon_info->discount_type == 'percentage') {
						$course->coupon_amount = (intval($coupon_info->discount) / 100 * intval($course->amount_to_pay));
						$course->discount_type = '%';
						$course->coupon_discount = $coupon_info->discount;

					} else {

						if(get_user_country() == 'bd' || get_user_country() == 'BD'){
							$course->coupon_amount = $coupon_info->discount;
							$course->coupon_discount = $coupon_info->discount;
							$course->discount_type = 'TK';
							
							 // $course->discount_type = 'USD';

							}else{
								$course->coupon_amount  = substr(get_usd_price($coupon_info->discount), '1');
								 	// $course->coupon_amount = $coupon_info->discount;
								$course->coupon_discount = '$ '. substr(get_usd_price($coupon_info->discount), '1');
								
							}
						// $course->coupon_amount = $coupon_info->discount;
						

					}
				}
			}

			$course->percentage_to_pay = 100;
			array_push($this->page_data['cart_item_list'], $course);
		}

// debug($this->page_data);

		$this->page_data['page_name'] = "shopping_cart";
		$this->page_data['page_title'] = "Shopping cart";
		$this->page_data['page_view'] = "home/shopping_cart";

		$this->load->view('index', $this->page_data);
	}

/*
 *   Controller for page not found page
 */
	public function page_not_found() {
		$this->page_data['page_name'] = 'page_not_found';
		$this->page_data['page_view'] = 'page_not_found';
		$this->page_data['page_title'] = '404 page not found';
		$this->load->view('index', $this->page_data);
	}

	public function course_expiry() {
		$this->page_data['page_name'] = 'course_expired';
		$this->page_data['page_view'] = 'course_expiry';
		$this->page_data['page_title'] = 'This is course is expired';
		$this->load->view('index', $this->page_data);
	}

	public function remove_cart_item($course_id) {
		$response = $this->crud_model->remove_cart_item($course_id);
		if ($response['success']) {
			$this->session->set_flashdata('remove_cart_item_message_success', "Course has been removed from the cart successfully!");
		} else {
			$this->session->set_flashdata('remove_cart_item_message_alart', $response['message']);
		}

		redirect(base_url('home/shopping_cart'));
	}

/*
 *   Service - to upload profile photo.
 */
	public function enroll_user_in_a_course($course_id) {
		if ($this->session->userdata('user_type') !== "USER" && $this->session->userdata('user_type') !== "ADMIN" && $this->session->userdata('user_type') !== "SUPER_ADMIN") {
			redirect(site_url('login?next=enroll_user_in_a_course&course=' . $course_id), 'refresh');
		} else {
			$response = $this->crud_model->enroll_an_user_in_a_course($this->session->userdata('user_id'), $course_id);
			if ($response['success']) {
				$this->session->set_flashdata('enrollment_successful', "You are successfully enrolled in the course");
				redirect(base_url('user/my_courses'));
			} else {
				$this->session->set_flashdata('enrollment_successful', $response['message']);
				redirect(base_url('user/my_courses'));
			}

		}

	}

	public function about_us() {
		$this->page_data['page_name'] = 'about_us';
		$this->page_data['page_title'] = 'About Us';
		$this->page_data['page_view'] = "home/about_us";

		$this->load->view('index', $this->page_data);
	}

	public function terms_and_condition() {
		$this->page_data['page_name'] = 'terms_and_condition';
		$this->page_data['page_title'] = 'Terms and Condition';
		$this->page_data['page_view'] = "home/terms_and_condition";



		$this->load->view('index', $this->page_data);
	}

	public function privacy_policy() {
		$this->page_data['page_name'] = 'privacy_policy';
		$this->page_data['page_title'] = 'Privacy Policy';
		$this->page_data['page_view'] = "home/privacy_policy";
		$this->load->view('index', $this->page_data);
	}

	public function contact() {

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>', '</div>');
		if ($this->form_validation->run('contact_form') == FALSE) {

			$this->page_data['page_name'] = 'contact';
			$this->page_data['page_title'] = 'Contact us';
			$this->page_data['page_view'] = "home/contact";
			$this->load->view('index', $this->page_data);
		} else {
			$data['name'] = html_escape($this->input->post('name'));
			$data['email'] = html_escape($this->input->post('email'));
			$data['phone'] = html_escape($this->input->post('phone'));

			$data['message'] = html_escape($this->input->post('message'));
			$data['message'] .= '<br> <br> <br> Thanks & Best regards, <br> Name: ' . $data['name'] . '<br> Phone: ' . $data['phone'] . '<br> Email: ' . $data['email'];

			$done = $this->email_model->send_mail_from_user($data['email'], $data['message']);
			if ($done == '1') {

				$this->session->set_flashdata('contact_success_message', 'Email has been sent successfully. We will contact you as soon as possible.');
			} else {
				$this->session->set_flashdata('contact_failed_message', 'Failed to email send');
			}
			redirect(base_url('home/contact'));
		}
	}

/*
 *   Controller - Forgot password interfacce
 */
	public function forgot_password() {
		if(!$this->session->userdata('user_id')){
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
			        <span aria-hidden="true">&times;</span>
			    </button>', '</div>');
				if ($this->form_validation->run('forgot_password_form') == FALSE) {
					$this->page_data['page_name'] = "forgot_password";
					$this->page_data['page_title'] = "Forgot Password";
					$this->page_data['page_view'] = "home/forgot_password";

					return $this->load->view('index', $this->page_data);
				} else {
					$email = html_escape($this->input->post('email'));

					$length = 6;
					$password = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz$'), 1, $length);

					$user_data = $this->user_model->get_user_by_email($email, array('id', 'first_name', 'last_name', 'email', 'phone'));

					if ($user_data == '' || $user_data == NULL) {
						$this->session->set_flashdata('reset_password_failed_message', 'Email not exist in our system.');
					} else {
						$data['password'] = sha1($password);

						$reset_password = $this->user_model->update_user_info($user_data->id, $data);

						if ($reset_password) {
							$this->page_data['user_data'] = $user_data;
							$this->page_data['password'] = $password;
							$email_msg = $this->load->view('template/password_reset_email', $this->page_data, true);
							$done = $this->email_model->send_email_and_password($email, $email_msg);
							if ($done == '1') {
								$this->session->set_flashdata('reset_password_success_message', 'Password reset successfully. New password has been sent to your mail.');
							} else {
								$this->session->set_flashdata('reset_password_failed_message', 'Failed to send email. Please try another time.');
							}

						} else {
							$this->session->set_flashdata('reset_password_failed_message', 'Failed to change password. Please try another time or contact our support team.');
						}
					}

					redirect(base_url('home/forgot_password'));

				}
		}else{
		 redirect('home/page_not_found', 'refresh');
		}
		

	}

/*
 * Conatroller - corporate list page
 */
	public function corporate() {

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('service/service_corporate', 'service_corporate');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>', '</div>');
		if ($this->form_validation->run('corporate_create_form') == FALSE) {
			$this->page_data['page_name'] = "corporate";
			$this->page_data['page_title'] = "Corporate";
			$this->page_data['page_view'] = "corporate/corporate_gateway";
			$this->page_data['corporate_list'] = $this->corporate_model->get_company_list(
				'OBJECT',
				array(
					'company' => array('id', 'name', 'address', 'email', 'phone'),
					'company_user' => array('corporate_role'),
				),
				array(
					'company_user.user_id' => $this->session->userdata('user_id'),
					'company_user.corporate_role' => 'ADMIN',
					'company_user.request_status' => 'ACCEPTED',
				)
			);
			$this->load->view('index', $this->page_data);
		} else {
			$this->service_corporate->save_corporate();
		}
	}

	public function certificate() {
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>', '</div>');
		$this->page_data['page_name'] = "check_certificate";
		$this->page_data['page_title'] = "Check Certificate";
		$this->page_data['page_view'] = "home/check_certificate";
		$this->page_data['certificate_info'] = null;
		if ($this->form_validation->run('check_certificate') == FALSE) {

			$this->page_data['error'] = null;
		} else {
			$user_certificate_no = html_escape($this->input->post('certificate_no'));
			if (strlen($user_certificate_no) == 17) {
				$certificate_info = $this->crud_model->get_user_certificate_serial_no(
					"OBJECT",
					NULL,
					NULL,
					array(
						"certificate" => array("course_name", "certificate_no", "created_at", "course_id", "certificate_key"),
						"user" => array("first_name", "last_name"),
					),
					array("certificate_no" => $user_certificate_no)
				);

				if ($certificate_info == null) {
					$this->page_data['error'] = 'Not found any certificate.';
				} else {
					$this->page_data['certificate_info'] = $certificate_info[0];
					// debug($this->page_data['certificate_info']);
					// exit;
					$this->page_data['get_date'] = date('d', strtotime($this->page_data['certificate_info']->created_at));
					$get_month = date('m', strtotime($this->page_data['certificate_info']->created_at));
					$this->page_data['get_year'] = date('Y', strtotime($this->page_data['certificate_info']->created_at));

					// // Create date object to store the DateTime format
					$dateObj = DateTime::createFromFormat('!m', $get_month);

					// // Store the month name to variable
					$this->page_data['monthName'] = $dateObj->format('F');

					if ($this->page_data['certificate_info']->course_id == 1) {
						$this->page_data['certificate_info']->course_name = 'It Service Management Foundation';
					} elseif ($this->page_data['certificate_info']->course_id == 4) {
						$this->page_data['certificate_info']->course_name = 'Project Management Foundation';
					} elseif ($this->page_data['certificate_info']->course_id == 8) {
						$this->page_data['certificate_info']->course_name = 'Project Management Practitioner';
					} elseif($this->page_data['certificate_info']->course_id == 56){
						$this->page_data['certificate_info']->course_name = 'ITIL4 Foundation Exam Preparation Training';
					} else {
						$this->page_data['certificate_info']->course_name;
					}
				}

			} else {
				$this->page_data['error'] = 'Certificate number not valid.';
			}

		}

		$this->load->view('index', $this->page_data);

	}

	public function faq($faq_cat_id = null, $faq_id = null, $offset = 0) {

		$this->page_data['page_name'] = 'faq';
		$this->page_data['page_title'] = 'Frequently Asked Questions';
		$this->page_data['page_view'] = "home/faq";
		$pagination_config['per_page'] = 10;
		$pagination_config['total_rows'] = 100;

		$this->page_data['faq_category'] = $this->crud_model->get_faq_category_list(
			"OBJECT",
			array("faq_category" => array("id", "name"))

		);
		$pagination_config['total_rows'] = $this->crud_model->get_faq_list(
			"COUNT",
			array(
				'faq' => array('id'),
			)

		);
		if ($faq_cat_id != null && $faq_id != null) {

			$this->page_data['faq_list'] = $this->crud_model->get_faq_list(
				"OBJECT",
				array("faq" => array("id", "question", "answer", "video_id", "faq_category_id")),
				array("id" => $faq_id)

			);

		} else if ($faq_cat_id != null) {
			$this->page_data['faq_list'] = $this->crud_model->get_faq_list(
				"OBJECT",
				array("faq" => array("id", "question", "answer", "video_id", "faq_category_id")),
				array("faq_category_id" => $faq_cat_id),

				array('limit' => $pagination_config['per_page'], 'offset' => $offset)

			);
		} else {

			$this->page_data['faq_list'] = $this->crud_model->get_faq_list(
				"OBJECT",
				array("faq" => array("id", "question", "answer", "video_id", "faq_category_id")),
				NULL,
				array('limit' => $pagination_config['per_page'], 'offset' => $offset)
			);
		}

		$this->page_data['page_limit'] = $pagination_config['per_page'];
		$this->page_data['number_of_total_faq'] = $pagination_config['total_rows'];
		$this->page_data['offset'] = $offset;

		if ($faq_cat_id != null) {
			$pagination_config['base_url'] = site_url('home/faq/' . $faq_cat_id . '/');
		} else {
			$pagination_config['base_url'] = site_url('home/faq');
		}

		$pagination_config['num_links'] = 3;
		$pagination_config['reuse_query_string'] = TRUE;
		$pagination_config['full_tag_open'] = '<div class="pagination-bar">';
		$pagination_config['full_tag_close'] = '</div>';
		$pagination_config['attributes'] = array('class' => 'pagination-bar-node');
		$pagination_config['first_link'] = 'First page';
		$pagination_config['last_link'] = 'Last page';
		$pagination_config['cur_tag_open'] = '<span class="pagination-bar-node-active">';
		$pagination_config['cur_tag_close'] = '</span>';

		$this->pagination->initialize($pagination_config);

		$this->load->view('index', $this->page_data);
	}

	/*Certificate Download view load*/

	public function get_certificate($certificate_key) {


		$this->page_data['page_name'] = "view_certificate";
		$this->page_data['page_title'] = "Get Certificate";
		$this->page_data['page_view'] = "user/view_certificate";
		if ($certificate_key != null) {
			$this->page_data['certificate_info'] = $this->crud_model->get_user_certificate_serial_no(
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
						"id",
						"first_name",
						"last_name",
						"profile_photo_name",
					),
				),
				array("certificate_key" => $certificate_key)
			)[0];
			if ($this->page_data['certificate_info'] != null) {
				$this->page_data['get_date'] = date('d', strtotime($this->page_data['certificate_info']->created_at));
				$get_month = date('m', strtotime($this->page_data['certificate_info']->created_at));
				$this->page_data['get_year'] = date('Y', strtotime($this->page_data['certificate_info']->created_at));

				// Create date object to store the DateTime format
				$dateObj = DateTime::createFromFormat('!m', $get_month);

				// Store the month name to variable
				$this->page_data['monthName'] = $dateObj->format('F');

				if ($this->page_data['certificate_info']->course_id == 1) {
					$this->page_data['certificate_info']->course_name = 'IT Service Management Foundation';
				} elseif ($this->page_data['certificate_info']->course_id == 4) {
					$this->page_data['certificate_info']->course_name = 'Project Management Foundation';
				} elseif ($this->page_data['certificate_info']->course_id == 8) {
					$this->page_data['certificate_info']->course_name = 'Project Management Practitioner';
				}elseif($this->page_data['certificate_info']->course_id == 56){
						$this->page_data['certificate_info']->course_name = 'ITIL4 Foundation Exam Preparation Training';
					} else {
					$this->page_data['certificate_info']->course_name;
				}
				$name = $this->page_data['certificate_info']->first_name . ' ' . $this->page_data['certificate_info']->last_name;

				$this->page_data['course'] = $this->course_model->get_course_list(
					"OBJECT",
					array('id', 'title', 'price', 'slug', 'short_description', 'discount_flag', 'discounted_price'),
					array('id' => $this->page_data['certificate_info']->course_id)
				)[0];

				$this->page_data['course_review'] = array();

				if($this->session->userdata('user_id')){
					$this->page_data['course_review'] = $this->course_model->get_course_review_list(
						"OBJECT",
						array('course_id', 'user_id', 'rating', 'review', 'status'),
						array("course_id" => $this->page_data['certificate_info']->course_id , 'user_id' => $this->session->userdata('user_id'))

					);
				}
				// debug($this->page_data['course_review']);
			}
		}
		$this->load->view('index', $this->page_data);
	}


	/*
	 *   Controller for /home page
	 */
		public function user_message($admin_id = '') {
			

			$this->page_data['page_name'] = "user_message";
			$this->page_data['page_title'] = "User Message";
			$this->page_data['page_view'] = "home/user_message";


			
			 $admin_list =  $this->user_model->get_user_list(
			 	array('id', 'first_name', 'last_name', 'status', 'user_type', 'profile_photo_name', 'last_activity'),
			 	"OBJECT",
			 	array('status' => 1, 'user_type' => 'ADMIN')
			  );
			  
			  
			  $this->page_data['admin_list'] = array();
			  foreach($admin_list as $admin){
			      // if(!has_role($admin->id, 'CHAT_READ')){
			           array_push($this->page_data['admin_list'] , $admin);
			      // }
			  }
			 

			    /* get user address*/
			  
			  	 $user_id = ($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : '';
			  	 
			  	 if($user_id != '' || $user_id != NULL){
			  	     $this->page_data['user_info'] =  $this->user_model->get_user_list(
        			 	array('id', 'first_name', 'last_name', 'status', 'user_type', 'profile_photo_name'),
        			 	"OBJECT",
        			 	array('id' => $user_id )
    			    );
			  	 }
			  	 

			 	 
			 	 $user = $this->crud_model->get_user_chat_info_list(
			 	 	"OBJECT", 
			 	 	array('user_chat_info' => array('id', 'user_id', 'ip_address')),
			 	 	array(
			 	 		// 'ip_address' => $this->getUserIpAddr(),
		                'user_id' =>  $user_id,
			 	 )
			 	 );
			
			 
			 	 	 
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
    			 	
			 
			 		
    			 if($admin_id != '' || $admin_id != null){
    			 	 $this->page_data['selected_admin'] =  $this->user_model->get_user_list(
        			 	array('id', 'first_name', 'last_name', 'status', 'user_type', 'profile_photo_name'),
        			 	"OBJECT",
        			 	array('id' => $admin_id)
    			  )[0];


	 	     	
			 	 
			
			 	 

			 	if(isset($user_check[0])){
			 	    
			 	     /*update the unseen message*/
			 	    $this->crud_model->update_admin_message_seen($user_check[0]->id, $admin_id);
			 	    
			 		$this->page_data['user_messages'] = $this->crud_model->get_user_chat_messages(
			 			'OBJECT',
			 			array('chat_message' => array('sender_id', 'receiver_id', 'chat_messages_text', 'chat_messages_status', 'chat_messages_datetime')),
			 			array('sender_id' => $user_check[0]->id, 'receiver_id' => $admin_id)
			 		);

			 	}
			 }
			 
			 
			  
			 	 
			 	 /*get total unseen message*/
			 	 
			 	 if(isset($user_check[0])){
			 	     $this->page_data['total_unseen_message'] = $this->crud_model->get_user_chat_messages(
			 			'COUNT',
			 			array('chat_message' => array('sender_id', 'receiver_id', 'chat_messages_text', 'chat_messages_status', 'chat_messages_datetime')),
			 			array('chat_messages_status' => 1, 'message_seen' => 0, 'sender_id' => $user_check[0]->id)
			 		);
			 		
			 		 /* admin wise unseen message*/
    			  for($i = 0; $i < count($this->page_data['admin_list']); $i++){
                         $this->page_data['admin_list'][$i]->message_count = $this->crud_model->get_user_chat_messages(
    			 			'COUNT',
    			 			array('chat_message' => array('sender_id', 'receiver_id', 'chat_messages_text', 'chat_messages_status', 'chat_messages_datetime')),
    			 			array('chat_messages_status' => 1, 'message_seen' => 0, 'receiver_id' => $this->page_data['admin_list'][$i]->id, 'sender_id' => $user_check[0]->id)
    			 		);
     
                    }
			 	 }


		
			
			$this->load->view('index', $this->page_data);
		}


		public function membership(){
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
				        <span aria-hidden="true">&times;</span>
				    </button>', '</div>');

			$this->page_data['page_name'] = 'membership';
			$this->page_data['page_title'] = 'Membership Plan';
			$this->page_data['page_view'] = "home/membership";

			if ($this->form_validation->run('membership_form') == FALSE) {
				
				

			}else{
				$data['name'] =  html_escape($this->input->post('name'));
				$data['phone'] =  html_escape($this->input->post('phone'));
				$data['email'] =  html_escape($this->input->post('email'));
				$employeer =  html_escape($this->input->post('employerStatus'));
				$membership =  html_escape($this->input->post('membership'));
				// $courses =  html_escape($this->input->post('courses'));
				// debug($courses);
				// debug($data);
				// exit;

				$response = $this->user_model->insert_membership($data);
				// $this->session->set_userdata('courses', $courses);
				$this->session->set_userdata('employerStatus', $employeer);
				// debug($response);
				// exit;
				if ($response['success']) {

						redirect(base_url('portwallet/membership/'.$membership.'/'.$response['id']));
					
				} else {
					$this->session->set_flashdata('membership', 'Failed to save your information. Please try later .');
				}
				
			}

			$this->load->view('index', $this->page_data);

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


	
	public function paypal($from = null){
		if ($this->session->userdata('user_type') !== "USER" && $this->session->userdata('user_type') !== "ADMIN" && $this->session->userdata('user_type') !== "SUPER_ADMIN") {
			redirect(site_url('login?next=checkout&from=' . $from), 'refresh');
		} else {

				$checkout_info = $this->session->userdata('checkout_info');

				//print_r(  $checkout_info['courses'] );

				$courses = "";
				foreach ($checkout_info['courses']  as $r) {
					if(  $courses == "" ) {
						$courses = $r['title'] . ' ('. ( $r['discount_flag'] == '1' ? get_usd_price_without_sign($r['discounted_price']) : get_usd_price_without_sign($r['price']) ) .')'."\n";
					} else {
						$courses .= ', ';
						$courses .= $r['title'] . ' ('. ( $r['discount_flag'] == '1' ? get_usd_price_without_sign($r['discounted_price']) : get_usd_price_without_sign($r['price']) ) .')'."\n";
					}
				}

		        $data = array(
		        	'courses' => $courses,
		        	'total_amount' => get_usd_price_without_sign($checkout_info['total_amount_to_pay'])
		        );

		        //todo: pls convert the total_amount in USD

		        $this->load->view('paypal/paypal', $data);

		}

		
	}

	public function paypal_cancel($return_data = null){

		$this->page_data['page_name'] = "paypal_cancel";
		$this->page_data['page_title'] = "Paypal Cancel";
		$this->page_data['page_view'] = "home/paypal_cancel";

		if($return_data == 'paypal') {
			$this->session->set_flashdata('paypal_cancel', 'Your PayPal Transaction has been Canceled!');

		}

		$this->load->view('index', $this->page_data);
	}

}
