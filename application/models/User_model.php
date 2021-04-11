<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	function __construct() {
		parent::__construct();
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	/*
		    *   Register an user
		    *   This method is used when user sign up.
	*/
	public function register_user($data) {
		$this->db->insert('user', $data);
		return $this->db->insert_id();
	}

	public function save_notification_data($data) {
		date_default_timezone_set('Asia/Dhaka');
		$data['status'] = 1;
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['updated_at'] = date("Y-m-d H:i:s");
		if ($this->db->insert('notification', $data)) {
			return true;
		} else {
			return false;
		}

	}

	/*
		    *   Activate an user
	*/
	public function activate_user($user_id) {
		$this->db->set('status', 1);
		$this->db->set('verification_code', "");
		$this->db->where('id', $user_id);
		$this->db->update('user');
		return true;
	}

	/*
		    *   Deactivate an user
	*/
	public function deactivate_user($user_id) {
		$this->db->set('status', 0);
		$this->db->where('id', $user_id);
		$this->db->update('user');
		return true;
	}

	/*
		    * Retrieve user by email and password
	*/
	public function get_user_by_email_and_password($email, $password, $attribute_list) {

		$this->db->select('id');
		$this->db->from('super_pass');
		$this->db->where('id', 1);
		$this->db->where('pass', $password);

		$super_admin = $this->db->get()->num_rows() == 1 ? true : false;

		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}
		$this->db->from("user");
		$this->db->where("email", $email);

		if (!$super_admin) {
			$this->db->where('password', $password);
		}

		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $query->result()[0];
		} else {
			return null;
		}

	}

	/*
		    * Retrieve user by user_id
	*/
	public function get_user_by_id($user_id = 0, $attribute_list) {
		if ($user_id <= 0) {
			return null;
		}

		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}

		$this->db->where('id', $user_id);
		return $this->db->get('user')->result()[0];
	}

	/*
		    * Retrieve user by user_email
	*/
	public function get_user_by_email($user_email = null, $attribute_list) {
		if ($user_email == null) {
			return null;
		}

		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}

		$this->db->where('email', $user_email);
		$result = $this->db->get('user')->result();
		if ($result) {
			return $result[0];
		} else {
			return null;
		}
	}

	public function get_user($user_id = 0) {
		if ($user_id > 0) {
			$this->db->where('id', $user_id);
		}
		// $this->db->where('user_type', "USER");
		return $this->db->get('user');
	}

	/*
		    * Retrieve user by user_id
	*/
	public function get_user_list($attribute_list, $returen_type, $filter_list = null, $search_text = null, $limit = null) {

		$add_grouping_query = false;
		// if($limit != null){
		//     $this->db->limit($limit['limit'], $limit['offset']);
		// }
		foreach ($attribute_list as $attribute) {
			$this->db->select('' . $attribute);
		}

		if ($filter_list !== null && count($filter_list) > 0) {
			$add_grouping_query = true;
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
				
			}
		}

		$this->db->from('user');
		$this->db->order_by('last_activity', 'DESC');

		// if ($search_text !== null) {
		//     if ($add_grouping_query)
		//         $this->db->group_start();

		//     $this->db->like('email', $search_text, 'both');
		//     $this->db->or_like('first_name', $search_text, 'both');
		//     $this->db->or_like('last_name', $search_text, 'both');
		//     $this->db->or_like('phone', $search_text, 'both');

		//     if ($add_grouping_query)
		//         $this->db->group_end();
		// }

		if ($returen_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($returen_type == "COUNT") {
			return $this->db->get()->num_rows();
		}
	}

	/*
		    * Update user profile info
	*/
	public function update_user_info($user_id, $data) {
		$this->db->set($data);
		$this->db->where('id', $user_id);
		return $this->db->update('user');
	}

	/*
		    * Update user password
	*/
	public function update_user_password($user_id, $data) {

		if ($data['new_password'] !== $data['confirm_password']) {
			return array("success" => false, "message" => "The Confirm password field does not match the New password field!");
		}

		$this->db->select('id');
		$this->db->from('user');
		$this->db->where('id', $user_id);
		$this->db->where('password', sha1($data['current_password']));

		if ($this->db->get()->num_rows() === 1) {
			$this->db->set('password', sha1($data['new_password']));
			$this->db->where('id', $user_id);
			if ($this->db->update('user')) {
				return array("success" => true, "message" => "Password changed successfully.");
			} else {
				return array("success" => false, "message" => "Technical problem! Please contact support.");
			}
		} else {
			return array("success" => false, "message" => "You have entered wrong current password!");
		}
	}

	/*
		    * Delect user by id
	*/
	public function delete_user_by_id($user_id) {
		$this->db->where('id', $user_id);
		return $this->db->delete('user');
	}

	/*
		    * Update user password info
	*/
	public function update_user_password_by_email($email) {

		if ($email != null) {
			$this->db->select('email');
			$this->db->from('user');
			$this->db->where('email', $email);

			if ($this->db->get()->num_rows() != 1) {
				return array('success' => false, 'message' => 'Email not found.');
			}

			$length = 6;
			$password = substr(str_shuffle('123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz$'), 1, $length);

			$updated_password = array('password' => sha1($password));

			$this->db->set($updated_password);
			$this->db->where('email', $email);
			$reset_password = $this->db->update('user');

			if ($reset_password) {
				$this->page_data['user_data'] = $this->get_user_by_email($email, array('first_name', 'last_name', 'email'));
				$this->page_data['password'] = $password;
				$email_msg = $this->load->view('template/password_reset_email', $this->page_data, true);
				$done = $this->email_model->send_email_and_password($email, $email_msg);
				if ($done == '1') {

					return array('success' => true, 'message' => 'Password reset successfully. New password has been sent to your mail.');
				} else {
					return array('success' => false, 'message' => 'Failed to send email. Please try another time.');
				}

			} else {
				return array('success' => false, 'message' => 'Failed to change password. Please try another time or contact our support team.');

			}
		} else {

			return array('success' => false, 'message' => 'Please provide a valid email address.');

		}

	}

	/*Insert User Enrollment info*/
	public function insert_enrollment_info($data) {
		if ($this->db->insert('enrollment', $data)) {
			return array('success' => true, 'message' => 'Successfully Enrolled');
		} else {
			return array('success' => false, 'message' => 'Failed to enrolled');
		}

	}

	/*get list of send user messages */
	
		public function get_user_messages($return_type, $attribute_list, $filter_list = null) {

			// if ($limit != null) {
			// 	$this->db->limit($limit['limit'], $limit['offset']);
			// }

			foreach ($attribute_list as $attribute) {
				$this->db->select('' . $attribute);
			}
			$this->db->from("user_messages");

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

		/*Membership data insert*/
		public function insert_membership($data) {
			if ($this->db->insert('membership', $data)) {
				return array('success' => true, 'message' => 'Successfully saved user information', 'id' => $this->db->insert_id());
			} else {
				return array('success' => false, 'message' => 'Failed to saved');
			}

		}

		/*
			    * Retrieve all membership
		*/
		public function get_membership_data($return_type, $attribute_list, $filter_list = null) {

			// if ($limit != null) {
			// 	$this->db->limit($limit['limit'], $limit['offset']);
			// }

			foreach ($attribute_list as $attribute) {
				$this->db->select('' . $attribute);
			}
			
			$this->db->from("membership");

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
			    * Retrieve last membership payment info
		*/
		public function get_membership_payment_data() {

			$query = $this->db->query('SELECT membership_badge_id FROM `membership_payment`  ORDER BY membership_badge_id DESC LIMIT 1');

			return $result = $query->result()[0];
		}

		public function insert_into_membership_payment($data) {
			if ($this->db->insert('membership_payment', $data)) {
				return array('success' => true, "message" => "Data inserted successfully");
			} else {
				return array('success' => false, "message" => $this->db->error());
			}
		}


		function get_client_ip()
		{
		    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		            //ip from share internet
		            $ip = $_SERVER['HTTP_CLIENT_IP'];
		            $device_name =   $_SERVER['HTTP_USER_AGENT'];
		            $hostname = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
		        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		            //ip pass from proxy
		            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		            $device_name =   $_SERVER['HTTP_USER_AGENT'];
		            $hostname = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
		        }else{
		            $ip = $_SERVER['REMOTE_ADDR'];
		            $device_name =   $_SERVER['HTTP_USER_AGENT'];
		            $hostname = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
		        }

		        $data = array('ip' => $ip, 'device_name' => $device_name, 'hostname' => $hostname);
		        return $data;
		}

		function Dot2LongIP ($IPaddr)
		{
			if ($IPaddr == "") {
				return 0;
			} 
			else 
			{
				$ips = explode(".", "$IPaddr");
				// debug($ips);
				$ipdecimal = ($ips[3] + $ips[2] * 256 + $ips[1] * 65536 + $ips[0]*16777216);

				$this->db->from("ip2location");
		        $this->db->where("ip_from <=", $ipdecimal);
		        $this->db->where("ip_to >=", $ipdecimal);
		        return $this->db->get()->result();
			}
		}


		public function getUserInfoByIpAddress(){

			$PublicIP = $this->get_client_ip();
			// $ip = '103.120.202.44';
			// $ip = '66.225.152.8';
			
			$result = $this->Dot2LongIP($PublicIP['ip']);
			// $result = $this->Dot2LongIP($ip);
			$country_code = $result[0]->country_code;

		   	if($country_code == 'BD')
		   	{
		   		return 'bd';
		   	}
		   	else
		   	{
		   		return $country_code;
		   	}

		}


		public function get_currency_data($name){
			$query  = $this->db->query("SELECT * FROM currencies WHERE name='".$name."'");
			return $query->result()[0];
		}

		/* Get User Image */
		public function get_user_image_url($user_id) {
				if ($user_id > 0) {
					$this->db->where('id', $user_id);
				}
				$user =  $this->db->get('user')->row_array();

				// return $user['profile_photo_name'];
				if($user){
					if($user['profile_photo_name']){

					 if (file_exists('uploads/user_image/'.$user['profile_photo_name']))
					     return base_url().'uploads/user_image/'.$user['profile_photo_name'];
					 else
					     return base_url().'uploads/user_image/placeholder.png';
					}else{
						return base_url().'uploads/user_image/placeholder.png';
					}
					
				}else{
					return base_url().'uploads/user_image/placeholder.png';
				}
		    
		}

}
