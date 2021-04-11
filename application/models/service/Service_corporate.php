<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_corporate extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->model('corporate_model', 'corporate_model');
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
		date_default_timezone_set('Asia/Dhaka');
	}

	/*
		    * Service -- Save corporate information
	*/
	public function save_corporate() {

		$data['name'] = html_escape($this->input->post('name'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['created_by'] = $this->session->userdata('user_id');

		if ($this->crud_model->is_duplicate_email_for_company($data['email'])) {
			$this->session->set_flashdata('corporate_save_failed_message', "Email already taken!!");
			redirect(base_url('/home/corporate'));
			return;
		}
		$response = $this->corporate_model->create_company($data);
		$data_user['company_id'] = $response['id'];
		$data_user['corporate_role'] = 'ADMIN';
		$data_user['request_status'] = "ACCEPTED";
		$data_user['user_id'] = $this->session->userdata('user_id');
		$response_user = $this->corporate_model->create_company_user($data_user);

		if ($response['success']) {
			if ($response_user['success']) {
				$this->session->set_flashdata('corporate_save_success_message', 'Corporate Account created has been successfully.');
			} else {
				$this->corporate_model->delete_company($response['id']);
				$this->session->set_flashdata('corporate_save_failed_message', $response_user['message']);
			}

		} else {
			$this->session->set_flashdata('corporate_save_failed_message', 'Failed to create corporate account. Please try later .');
		}

		redirect(base_url('home/corporate'));
	}

	/*
		    * Service -- Save designation information
	*/
	public function save_designation($company_id) {

		$data['name'] = html_escape($this->input->post('name'));
		$data['id'] = html_escape($this->input->post('id'));
		$data['company_id'] = $company_id;

		if ($data['id'] == null) {
			$response = $this->corporate_model->create_designation($data);
			if ($response['success']) {
				$this->session->set_flashdata('designation_save_success_message', 'Designation created has been successfully.');
			} else {
				$this->session->set_flashdata('designation_save_failed_message', 'Failed to create designation. Please try later.');
			}
		} else {
			$response = $this->corporate_model->update_designation($data['id'], $data);
			if ($response['success']) {
				$this->session->set_flashdata('designation_save_success_message', 'Designation updated successfully.');
			} else {
				$this->session->set_flashdata('designation_save_failed_message', 'Failed to update designation. Please try later.');
			}
		}

		redirect(base_url('/corporate/' . $company_id . '/designation'));
	}

	/*
		    * Service -- Save department information
	*/
	public function save_department($company_id) {

		$data['name'] = html_escape($this->input->post('name'));
		$data['id'] = html_escape($this->input->post('id'));
		$data['company_id'] = $company_id;

		if ($data['id'] == null) {
			$response = $this->corporate_model->create_department($data);

			if ($response['success']) {
				$this->session->set_flashdata('department_save_success_message', 'Department created has been successfully.');

			} else {
				$this->session->set_flashdata('department_save_failed_message', 'Failed to create department. Please try later.');
			}
		} else {

			$response = $this->corporate_model->update_department($data['id'], $data);
			if ($response['success']) {
				$this->session->set_flashdata('department_save_success_message', 'Department updated successfully.');
			} else {
				$this->session->set_flashdata('department_save_failed_message', 'Failed to update department. Please try later.');
			}

		}

		redirect(base_url('/corporate/' . $company_id . '/department'));
	}

	/*
		    * Service -- Save user information
	*/
	public function save_user($company_id) {

		$data['user_id'] = html_escape($this->input->post('user_id'));
		$data['department_id'] = html_escape($this->input->post('department_id'));
		$data['designation_id'] = html_escape($this->input->post('designation_id'));
		$data['company_id'] = $company_id;
		$data['corporate_role'] = html_escape($this->input->post('corporate_role'));
		$data['request_status'] = "PENDING";

		if (is_user_already_exist_in_a_company($data['user_id'], $company_id)) {
			$this->session->set_flashdata('user_save_failed_message', 'User already exist. Please try again.');
		} else {
			$response = $this->corporate_model->create_company_user($data);
			if ($response['success']) {
				$this->session->set_flashdata('user_save_success_message', 'User added successfully.');
			} else {
				$this->session->set_flashdata('user_save_failed_message', 'Failed to add user. Please check again.');
			}

		}

		redirect(base_url('/corporate/' . $company_id . '/users'));
	}

	public function save_new_user($company_id) {
		date_default_timezone_set('Asia/Dhaka');

		$data_user['first_name'] = html_escape($this->input->post('first_name'));
		$data_user['last_name'] = html_escape($this->input->post('last_name'));
		$data_user['email'] = html_escape($this->input->post('email'));
		$data_user['phone'] = html_escape($this->input->post('phone'));
		$data_user['biography'] = html_escape($this->input->post('biography'));
		$data_user['user_type'] = 'USER';
		$data_user['status'] = '1';
		$data_user['biography'] = html_escape($this->input->post('biography'));

		$length = 6;
		$password = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz$'), 1, $length);
		$data_user['password'] = sha1($password);
		$data_user['created_at'] = date("Y-m-d H:i:s");

		if ($this->crud_model->is_duplicate_email($data_user['email'])) {
			$this->session->set_flashdata('user_save_failed_message', "Email already taken!!");
			redirect(base_url('/corporate/' . $company_id . '/users'));
			return;
		}

		$user_info = $this->user_model->register_user($data_user);
		$data['user_id'] = $user_info;

		if ($user_info) {
			$done = $this->email_model->send_email_and_password($data_user['email'], $password);

			if ($done == '1') {
				$this->session->set_flashdata('user_save_success_message', "New user created Successfully. Email send in user mail!!");
			} else {
				if ($this->user_model->delete_user_by_id($user_info)) {
					$this->session->set_flashdata('user_save_failed_message', "Failed to send email! Please check it it is an real email");
				} else {
					$this->session->set_flashdata('user_save_failed_message', "Failed to send email! Data was saved in database. Please take a screenshot and contact developers team.");
				}
			}
		} else {
			$this->session->set_flashdata('user_save_failed_message', "Failed to create!!");
		}

		$data['department_id'] = html_escape($this->input->post('department_id'));
		$data['designation_id'] = html_escape($this->input->post('designation_id'));
		$data['company_id'] = $company_id;
		$data['corporate_role'] = html_escape($this->input->post('corporate_role'));
		$data['request_status'] = "PENDING";

		$response = $this->corporate_model->create_company_user($data);
		redirect(base_url('/corporate/' . $company_id . '/users'));
	}

}

?>