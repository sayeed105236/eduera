<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	private $page_data = [];
    public $previous_url = '';
    
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->page_data['system_name'] = get_settings('system_name');
		$this->page_data['category_list'] = $this->category_model->get_category_for_menu();

		$config = array(
			'protocol' => get_settings('protocol'),
			'smtp_host' => get_settings('smtp_host'),
			'smtp_port' => get_settings('smtp_port'),
			'smtp_user' => get_settings('smtp_user'),
			'smtp_pass' => get_settings('smtp_pass'),
			'mailtype' => 'html',
			'charset' => 'utf-8',
		);
		$this->load->library('email', $config);
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		date_default_timezone_set('Asia/Dhaka');
		// $this->load->library('facebook', array('appId' => '587868382001626', 'secret' => '74395f35f9964db473512025d0eb35d9'));
		// // Get user's login information
		// $this->user = $this->facebook->getUser();
		$this->page_data['instructor_page_name'] = "";

		

	  
		// print_r($current_url);
	}



	public function google_login() {
		require_once 'vendor/autoload.php';
		// init configuration
		// $clientID = '1006132886734-6snldt84ik5msun6mro8m84b0qe7g7fp.apps.googleusercontent.com';
		$clientID = '1061299978547-vva2e6g1g8hpp9i993vqnb2bskghjnl9.apps.googleusercontent.com';
		// $clientSecret = '2K-FQ7Kpp14JgbLOVzqP3LRE';
		$clientSecret = 'OiLfDV_PQo3YT-9KMzofA1Cn';
		$redirectUri = base_url() . 'login/google_login'; //base url mane ki local. hmm

		// create Client Request to access Google API
		$client = new Google_Client();
		$client->setClientId($clientID);
		$client->setClientSecret($clientSecret);
		$client->setRedirectUri($redirectUri);
		//  Set the scopes required for the API you are going to call
		$client->addScope("email");
		$client->addScope("profile");

		// authenticate code from Google OAuth Flow
		if (isset($_GET['code'])) {
			$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
			$client->setAccessToken($token['access_token']);

			// get profile info
			$google_oauth = new Google_Service_Oauth2($client);
			$google_account_info = $google_oauth->userinfo->get();
			$email = $google_account_info->email;
			$first_name = $google_account_info->givenName;
			$last_name = $google_account_info->familyName;
			$picture = $google_account_info->picture;

			$email_check = $this->user_model->get_user_by_email($email, array('email', 'signup_type'));

			if ($this->session->userdata('login_url_params')) {
				foreach ($this->session->userData('login_url_params') as $key => $value) {
					$_GET[$key] = $value;
				}
			}

			if ($email_check) {
				if ($email_check->signup_type == 'SYSTEM' || $email_check->signup_type == null) {
					$this->session->set_flashdata('invalid_credential', "This email has already been used in our system. Try with your email and password");
					redirect(site_url('login'));
				} else if ($email_check->signup_type == 'GOOGLE') {
					$_POST['login_email'] = $email;
					$this->validate_login('GOOGLE');
				}

			} else {
				$_POST['signup_first_name'] = $google_account_info->givenName;
				$_POST['signup_last_name'] = $google_account_info->familyName;
				$_POST['signup_email'] = $google_account_info->email;
				$_POST['user_type'] = 'USER';
				$this->register('GOOGLE');
			}
			// $this->validate_login('google', $email);

			// now you can use this profile info to create account in your website and make user logged in.
		} else {
			return $client->createAuthUrl();
		}
	}

	


	public function facebook_login() {
		require_once 'vendor/autoload.php';

		// Call Facebook API
		$facebook = new \Facebook\Facebook([
			'app_id' => '215076963041913',
			'app_secret' => '9d1888594d14820b0b6f9d29bda21139',
			'default_graph_version' => 'v2.10',
		]);
		$facebook_output = '';

		$facebook_helper = $facebook->getRedirectLoginHelper();

		if (isset($_GET['code'])) {
			
			try{

				$access_token = $facebook_helper->getAccessToken();
				$facebook->setDefaultAccessToken($access_token);

				$graph_response = $facebook->get("/me?fields=first_name,last_name,email", $access_token);

				$facebook_user_info = $graph_response->getGraphUser();
				$facebook_user_info['image'] = 'http://graph.facebook.com/' . $facebook_user_info['id'] . '/picture';
				$email = $facebook_user_info['email'];
				$first_name = $facebook_user_info['first_name'];
				$last_name = $facebook_user_info['last_name'];
				$picture = $facebook_user_info['image'];
	// 			debug($facebook_user_info);
				// 			exit;
				$email_check = $this->user_model->get_user_by_email($email, array('email', 'signup_type'));

				if ($this->session->userdata('login_url_params')) {
					foreach ($this->session->userData('login_url_params') as $key => $value) {
						$_GET[$key] = $value;
					}
				}

				if ($email_check) {
					if ($email_check->signup_type == 'SYSTEM' || $email_check->signup_type == null) {
						$this->session->set_flashdata('invalid_credential', "This email has already been used in our system. Try with your email and password");
						redirect(site_url('login'));
					} else if ($email_check->signup_type == 'FACEBOOK') {
						$_POST['login_email'] = $email;
						$this->validate_login('FACEBOOK');
					}

				} else {
					$_POST['signup_first_name'] = $facebook_user_info['first_name'];
					$_POST['signup_last_name'] = $facebook_user_info['last_name'];
					$_POST['signup_email'] = $facebook_user_info['email'];
					$_POST['user_type'] = 'USER';
					$this->register('FACEBOOK');
				}
			}catch(Facebook\Exceptions\FacebookResponseException $e) {
			  // When Graph returns an error
			  echo 'Graph returned an error: ' . $e->getMessage();
			  exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  // When validation fails or other local issues
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  exit;
			}

			

		} else {
			// Get login url
			$facebook_permissions = ['email']; // Optional permissions

			return $facebook_login_url = $facebook_helper->getLoginUrl('https://www.eduera.com.bd/login/facebook_login', $facebook_permissions);

			// Render Facebook login button

		}
	}

	/*
		    *   Controller for login page
	*/
	public function index() {
			



		if ($this->session->userdata('user_type') === "USER" || $this->session->userdata('user_type') === "ADMIN" || $this->session->userdata('user_type') === "SUPER_ADMIN") {
			redirect(site_url('user'));
		}

		$this->page_data['LoginUrlGamil'] = $this->google_login();
		$this->page_data['url_params'] = '?';

		if (isset($_GET) && count($_GET) > 0) {
			$this->session->set_userdata('login_url_params', $_GET);
		} 
		else {

			// $this->session->unset_userdata('login_url_params');
			// $this->session->set_userdata('previous_url', $previous_url);
		}

		if (isset($_GET['next'])) {
			$this->page_data['url_params'] .= 'next=' . $_GET['next'] . '&';
			if ($_GET['next'] == 'enroll_user_in_a_course') {
				$this->page_data['url_params'] .= 'course=' . $_GET['course'] . '&';
			}
		}

		$this->page_data['facebook_login_url'] = $this->facebook_login();

		if (isset($_GET['from'])) {
			$this->page_data['url_params'] .= 'from=' . $_GET['from'] . '&';
		}

		$this->page_data['url_params_for_register'] = $this->page_data['url_params'] . 'task=register';
		$this->page_data['url_params_for_login'] = $this->page_data['url_params'] . 'task=login';
		$this->page_data['page_name'] = 'login';
		$this->page_data['page_title'] = 'login';
		$this->page_data['page_view'] = 'login/index';
		//$this->page_data['role_list'] = $this->role_model->get_role_list();

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');

		if (isset($_GET['task'])) {
			if ($_GET['task'] == 'login') {
				if ($this->form_validation->run('login_form') == TRUE) {
					$this->validate_login('system');
					return;
				}
			} else if ($_GET['task'] == 'register') {
				if ($this->form_validation->run('registration_form') == TRUE) {
					$this->register();
					return;
				}
			}
		}
		
		$this->load->view('index', $this->page_data);

	}



	/*
		*   Service - to validate login
	*/
	public function validate_login($signup_type = null) {

		$previous_url = $this->session->userdata('previous_url');
		$email = $this->input->post('login_email');

		if ($signup_type == 'GOOGLE') {
			$user = $this->user_model->get_user_by_email($email, array('id', 'user_type', 'first_name', 'last_name', 'email', 'status', 'verification_code', 'phone'));
		} else if ($signup_type == 'FACEBOOK') {
			$user = $this->user_model->get_user_by_email($email, array('id', 'user_type', 'first_name', 'last_name', 'email', 'status', 'verification_code', 'phone'));

		} else {
			$password = sha1($this->input->post('login_password'));
			$user = $this->user_model->get_user_by_email_and_password($email, $password, array('id', 'user_type', 'first_name', 'last_name', 'email', 'status', 'verification_code', 'phone'));
		}

		if ($user == null) {
			$this->session->set_flashdata('invalid_credential', "You have entered invalid credential!!");
			redirect(site_url('login'));
		}

		if ($user->verification_code == null || $user->verification_code == '') {
			if ($user->status == 0) {
				redirect(site_url('login/default_message/1'));
			} else {
				if ($signup_type == 'GOOGLE') {
					$this->create_login_session(array(
						'user_id' => $user->id,
						'user_type' => 'USER',
						'email' => $user->email,
						'name' => $user->first_name . ' ' . $user->last_name,
					));
				} else if ($signup_type == 'FACEBOOK') {
					$this->create_login_session(array(
						'user_id' => $user->id,
						'user_type' => 'USER',
						'email' => $user->email,
						'name' => $user->first_name . ' ' . $user->last_name,
					));
				} else {

					
					$this->create_login_session(array(
						'user_id' => $user->id,
						'user_type' => $user->user_type,
						'email' => $user->email,
						'phone' => $user->phone,
						'name' => $user->first_name . ' ' . $user->last_name,
					));
				}

				if (isset($_GET['next'])) {
					if ($_GET['next'] == 'enroll_user_in_a_course') {
						redirect(site_url('home/enroll_user_in_a_course/' . $_GET['course']));
					} else if ($_GET['next'] == 'checkout') {
						// if ($user->phone == null) {
						// 	redirect(site_url('user/profile'));
						// }
						if($_GET['from'] == 'shopping_cart_paypal'){
							redirect(site_url('home/paypal/' . $_GET['from']), 'refresh');
						}else{
							redirect(site_url('portwallet/checkout/' . $_GET['from']), 'refresh');
						}
						
					}
				}

				if ($user->phone == null) {
					redirect(site_url('user/profile'));
				}
				
				if($previous_url != '' || $previous_url != NULL){
					redirect($previous_url);
				}else{
					redirect(site_url('user/my_courses'));
				}
				
			}
		} else {
			redirect(site_url('login/default_message/2'));
		}
	}

	/*
		    *   Service - to register user from signup/login page
	*/
	public function register($signup_type = null) {

		date_default_timezone_set('Asia/Dhaka');
		/*Pusher notificate start*/
		require_once 'vendor/autoload.php';
		$options = array(
		    'cluster' => 'ap2',
		    'useTLS' => true
		  );
		  $pusher = new Pusher\Pusher(
		    '769aa47391ce06086fa0',
		    '6859062907f390436de0',
		    '1012126',
		    $options
		  );

		  /*pusher notificateion end*/
		if (count($_POST) == 0) {
			redirect(site_url('login'), 'refresh');
		}

		$data['first_name'] = html_escape($this->input->post('signup_first_name'));
		$data['last_name'] = html_escape($this->input->post('signup_last_name'));
		$data['email'] = html_escape($this->input->post('signup_email'));
		$data['phone'] = html_escape($this->input->post('signup_phone'));
		$data['country'] = html_escape($this->input->post('country'));

		if ($signup_type == null) {
			$data['signup_type'] = 'SYSTEM';
		} else {
			$data['signup_type'] = $signup_type;
		}

		if ($data['signup_type'] == 'SYSTEM') {
			$data['password'] = sha1(html_escape($this->input->post('signup_password')));
		}

		if ($this->input->post('user_type')) {
			$data['user_type'] = html_escape($this->input->post('user_type'));
		} else {
			$data['user_type'] = 'USER';
		}

		$data['created_at'] = date("Y-m-d H:i:s");
		if ((isset($_GET['next']) && ($_GET['next'] == 'checkout' || $_GET['next'] == 'enroll_user_in_a_course')) || $signup_type == 'GOOGLE' || $signup_type == 'FACEBOOK') {
			$data['status'] = 1;
		} else {
			$data['status'] = 0;
			$data['verification_code'] = uniqid(md5($data['email']) . "_");
		}

		$this->session->set_userdata('success_page_duration_start', strtotime(date("Y-m-d H:i:s")));
		$this->session->set_userdata('success_page_duration', 5 * 60);

		if (!$this->crud_model->is_duplicate_email($data['email'])) {
			$user_id = $this->user_model->register_user($data);
			/*Greeting email send for new registrer user */

			/*End*/
			
			$data['user_id'] = $user_id;

			if ((isset($_GET['next']) && ($_GET['next'] == 'checkout' || $_GET['next'] == 'enroll_user_in_a_course')) || $signup_type == 'GOOGLE' || $signup_type == 'FACEBOOK') {
				$done = '1';

				$pusher_data['notification_id'] = $user_id;
				$pusher_data['notification_type'] = 'registration';
				$response = $this->user_model->save_notification_data($pusher_data);
				if($response == 1){
					$pusher->trigger('my-channel', 'my-event', $pusher_data);
				}
				

				/* Greeting email send*/
				if ($user_id) {
					
					$this->page_data['courses'] = $this->course_model->get_course_list(
						"OBJECT",
						array('title', 'discounted_price', 'discount_flag', 'price', 'slug'),
						array('send_greeting_mail' => 1)
					);
					$this->page_data['user_data'] = $data;
					$email_msg = $this->load->view('template/greeting_email', $this->page_data, true);
					$this->email_model->send_greeting_mail($data['email'], $email_msg);
				}
			} else {
				$this->page_data['user_data'] = $data;

				$email_msg = $this->load->view('template/verify_email', $this->page_data, true);
				$done = $this->email_model->send_email_verification_mail($this->page_data['user_data']['email'], $email_msg);

				$pusher_data['notification_id'] = $user_id;
				$pusher_data['notification_type'] = 'registration';
				$response = $this->user_model->save_notification_data($pusher_data);
				if($response == 1){
					$pusher->trigger('my-channel', 'my-event', $pusher_data);
				}
				/* Greeting email send*/
				if ($user_id) {
				    	$this->page_data['courses'] = $this->course_model->get_course_list(
						"OBJECT",
						array('title', 'discounted_price', 'discount_flag', 'price', 'slug'),
						array('send_greeting_mail' => 1)
					);
					$this->page_data['user_data'] = $data;
					$email_msg = $this->load->view('template/greeting_email', $this->page_data, true);
					$this->email_model->send_greeting_mail($data['email'], $email_msg);

					
				}
			}



			if ($done == '1') {
				if ((isset($_GET['next']) && ($_GET['next'] == 'checkout' || $_GET['next'] == 'enroll_user_in_a_course')) || $signup_type == 'GOOGLE' || $signup_type == 'FACEBOOK') {
					$this->create_login_session(array(
						'user_id' => $data['user_id'],
						'user_type' => $data['user_type'],
						'email' => $data['email'],
						'name' => $data['first_name'] . ' ' . $data['last_name'],
					));
					if (isset($_GET['next'])) {
						if ($_GET['next'] == 'enroll_user_in_a_course') {
							redirect(site_url('home/enroll_user_in_a_course/' . $_GET['course']));
						} else if ($_GET['next'] == 'checkout') {
							if ($data['phone'] == null || strlen($data['phone']) < 11) {
								redirect(site_url('user/profile'));
							}
							redirect(site_url('portwallet/checkout/' . $_GET['from']));
						}
					} else {
						if ($data['phone'] == null) {
							redirect(site_url('user/profile'));
						}

						redirect(site_url('user/my_courses'));
					}

				} else {
					redirect(site_url('login/registration_successful?mail_sent=1'), 'refresh');
				}

			} else {

				if ($this->user_model->delete_user_by_id($user_id)) {
					$this->session->set_flashdata('registration_error', "Oops! Failed to send activation email. Please enter the email correctly.");
				} else {
					$this->session->set_flashdata('registration_error', "Oops! Something went wrong. Please contact our support.");
				}
				redirect(site_url('login'), 'refresh');
			}
		} else {
			$this->session->set_flashdata('registration_error', "Email already taken!!");
			redirect(site_url('login'), 'refresh');
		}

	}

	/*
		    *   Controller for registration success page.
	*/
	public function registration_successful() {

		$current_time = strtotime(date("Y-m-d H:i:s"));
		$diff = $current_time - $this->session->userdata('success_page_duration_start');

		if ($diff > $this->session->userdata('success_page_duration') || !isset($_GET['mail_sent'])) {
			redirect(site_url('home/page_not_found'), 'refresh');
		}

		$this->page_data['page_name'] = 'registration_successful';
		$this->page_data['page_title'] = 'Your account has been created successfully.';
		$this->page_data['page_view'] = 'login/registration_successful';

		if ($_GET['mail_sent'] == '1') {
			$this->page_data['page_body_text'] = "We have a sent an activation link to your email. Please check your mail inbox and activate your account.";
		} else {
			$this->page_data['page_body_text'] = "But you might have entered a invalid email. Please contact our support to active your account.";
		}

		$this->load->view('index', $this->page_data);
	}

	/*
		    *   Controller for default message page.
	*/
	public function default_message($message_type_id) {
		$this->page_data['page_name'] = 'default_message_page';
		$this->page_data['page_title'] = 'Eduera';
		$this->page_data['page_view'] = 'default_message_page';
		if ($message_type_id == 1) {
			$this->page_data['page_body_title'] = "Your account has been deactivated!";
			$this->page_data['page_body_text'] = "Please contact our support.";
		} else if ($message_type_id == 2) {
			$this->page_data['page_body_title'] = "You have not verified your email yet!";
			$this->page_data['page_body_text'] = "Please verify your email to activate your account.";
		}

		$this->load->view('index', $this->page_data);
	}

	/*
		    *   Service - to verify email address
	*/
	public function verify_email_address($verification_code = "") {

		if ($verification_code == null || $verification_code == "") {
			redirect(site_url('home/page_not_found'), 'refresh');
		} else {
			$user_id = $this->crud_model->is_valid_verification_code($verification_code);
			if (is_numeric($user_id)) {
				$this->user_model->activate_user($user_id);

				$this->page_data['page_name'] = 'registration_successful';
				$this->page_data['page_view'] = 'login/registration_successful';
				$this->page_data['page_title'] = 'Your account has been activated successfully.';
				$this->page_data['page_body_text'] = 'You can <a href="' . base_url("login") . '">login</a> now.';

				$this->load->view('index', $this->page_data);
			} else {
				redirect(site_url('home/page_not_found'), 'refresh');
			}
		}

	}

	/*
		    *   Service to logout user.
	*/
	public function logout($from = "") {
		//destroy sessions of specific userdata. We've done this for not removing the cart session
		$this->destroy_login_session();
		redirect(site_url('home'), 'refresh');
	}

	/*
		    *   Service to create login session
	*/
	public function create_login_session($user) {
		$this->session->set_userdata('user_id', $user['user_id']);
		$this->session->set_userdata('user_type', $user['user_type']);
		// $this->session->set_userdata('role_type', $user->role_type);
		$this->session->set_userdata('email', $user['email']);
		if (isset($user['phone'])) {
			$this->session->set_userdata('phone', $user['phone']);
		}
		$this->session->set_userdata('name', $user['name']);
	}

	/*
		    *   Service to destroy login session
	*/
	public function destroy_login_session() {
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_type');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('phone');
		$this->session->unset_userdata('name');
	}

}
