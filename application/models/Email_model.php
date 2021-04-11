<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Email_model extends CI_Model {

	function __construct() {
		parent::__construct();

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
	}

	function password_reset_email($new_password = '', $email = '') {
		$query = $this->db->get_where('users', array('email' => $email));
		if ($query->num_rows() > 0) {

			$email_msg = "Your password has been changed.";
			$email_msg .= "Your new password is : " . $new_password . "<br />";

			$email_sub = "Password reset request";
			$email_to = $email;
			//$this->do_email($email_msg , $email_sub , $email_to);
			$this->send_smtp_mail($email_msg, $email_sub, $email_to);
			return true;
		} else {
			return false;
		}
	}

	public function send_email_verification_mail($to = "", $email_msg = '') {

		$subject = "[eduera.com.bd] Verify your Eduera account";
		$ress = $this->send_smtp_mail($email_msg, $subject, $to);

		return $ress;
	}

	/* Send greeting email*/
	public function send_greeting_mail($to = "", $email_msg = '') {

		$subject = "[eduera.com.bd] Thank you for joining.";
		$ress = $this->send_smtp_mail($email_msg, $subject, $to);

		return $ress;
	}

	/* Send certificate email*/
	public function send_certificate_mail($to = "", $email_msg = '', $subject = '') {

		// $subject = "[eduera.com.bd] Thank you for joining.";
		$ress = $this->send_smtp_mail($email_msg, $subject, $to);

		return $ress;
	}

	public function send_email_and_password($to = "", $email_msg = "") {

		$subject = "[eduera.com.bd] Password Reset Request";

		$ress = $this->send_smtp_mail($email_msg, $subject, $to);
		return $ress;
	}

	/* Send membership email*/
	public function send_membership_mail($to = "", $email_msg = '') {

		$subject = "[eduera.com.bd] Membership Confirmation.";
		$ress = $this->send_smtp_mail($email_msg, $subject, $to);

		return $ress;
	}

	public function send_mail_on_course_status_changing($course_id = "", $mail_subject = "", $mail_body = "") {
		$instructor_id = 0;
		$course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
		if ($course_details['user_id'] != "") {
			$instructor_id = $course_details['user_id'];
		} else {
			$instructor_id = $this->session->userdata('user_id');
		}
		$instuctor_details = $this->user_model->get_all_user($instructor_id)->row_array();
		$email_from = get_settings('system_email');

		$this->send_smtp_mail($mail_body, $mail_subject, $instuctor_details['email'], $email_from);
	}

	public function send_mail_from_user($from = "", $mail_body = "") {

		$email_from = get_settings('system_email');
		$mail_subject = "User's contact message from website.";
		$this->email->reply_to($from);
		$email_to = "globalskillsbd@gmail.com";
		$ress = $this->send_smtp_mail($mail_body, $mail_subject, $email_to, $email_from);
		return $ress;
	}

	public function send_smtp_mail($msg = NULL, $sub = NULL, $to = NULL, $from = NULL) {
		//Load email library

		$this->load->library('parser');

		if ($from == NULL) {
			$from = $this->db->get_where('settings', array('key' => 'system_email'))->row()->value;
		}

		// $this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		$htmlContent = $msg;

		$this->email->to($to);
		$this->email->from($from, get_settings('system_name'));
		$this->email->subject($sub);
		$this->email->message($htmlContent);

		//Send email
		$res = $this->email->send();
		return $res;
	}
}
