<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal extends CI_Controller {
		public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->page_data['instructor_page_name'] = "";
		// $environment = "PROD";
		date_default_timezone_set('Asia/Dhaka');
		$this->user_country = $this->user_model->getUserInfoByIpAddress();

		// if ($environment == "DEV") {
		// 	$this->api_url = 'https://api-sandbox.portwallet.com/payment/v2/invoice';
		// 	$this->app_key = '23b844c80146b36df469b0cf63d5080e';
		// 	$this->secret_key = 'a017c8cadeb13d7a9a72ec902573c287';
		// } else {
		// 	$this->api_url = 'https://api.portwallet.com/payment/v2/invoice';
		// 	$this->app_key = 'fde409259497bab63ce09e133dbdf0d7';
		// 	$this->secret_key = '1bd2edd201a0f61832af2c15e4344724';
		// }

		// $this->authorization = "Authorization: Bearer " . base64_encode($this->app_key . ":" . md5($this->secret_key . time()));

	}

	function paypal_success($from = null){
		
		$current_time = date("Y-m-d H:i:s");
		if(!empty($_POST['txn_type']) && !empty($_POST['txn_id']) ){
			
			if($_POST['payment_status'] == 'Completed' && $_POST['payer_status'] == 'VERIFIED'){
				// if(get_user_country() == 'bd' || get_user_country() == 'BD'){
				// 	$amount_to_pay = $_POST['mc_gross'];
				// }else{
					$amount_to_pay = get_bdt_price($_POST['mc_gross']);
				// }

				
					$transaction_table_data = array(
							'invoice_id' => $_POST['txn_id'],
							'amount' => $amount_to_pay,
							'status' => "ACCEPTED",
							'created_at' => $current_time,
					);

				

					$transaction_insert_response = $this->crud_model->insert_into_transaction($transaction_table_data);

					if ($transaction_insert_response["success"]) {

						if(isset($this->session->userdata('checkout_info')['courses'])){
							foreach ($this->session->userdata('checkout_info')['courses'] as $course) {
								/* Check user already enrolled or not*/
								$enrollment_id = is_an_user_already_enrolled_in_a_course($this->session->userdata('user_id'), $course['id']);

								if (!$enrollment_id) {
									if (isset($course['coupon_id'])) {
										$enrollment_response = $this->crud_model->enroll_an_user_in_a_course($this->session->userdata('user_id'), $course['id'], $course['coupon_id'], $amount_to_pay);

									} else {
										$enrollment_response = $this->crud_model->enroll_an_user_in_a_course($this->session->userdata('user_id'), $course['id']);

									}
									
									if ($enrollment_response['success']) {
										$enrollment_id = $enrollment_response['enrolled_id'];
									} else {
										$this->session->set_flashdata('portwallet_error', 'Oops! something went wrong.');
									}

								}

								// // if(get_user_country() == 'bd' || get_user_country() == 'BD'){
								// 	$amount_to_pay_now = ($course['amount_to_pay_now']);
								// // }else{
								if(get_user_country() == 'bd' || get_user_country() == 'BD'){
									$amount_to_pay_now = $course['amount_to_pay_now'];
								}else{
									$amount_to_pay_now = get_bdt_price($course['amount_to_pay_now']);
								}
									
									
								// }

								$enrollment_payment_data = array(
									'invoice_id' => $_POST['txn_id'],
									'payment_method' => "PAYPAL",
									'enrollment_id' => $enrollment_id,
									'amount' => $amount_to_pay_now,
									'status' => "ACCEPTED",
									'created_at' => $current_time,
								);

								$enrollment_payment_response = $this->crud_model->insert_into_enrollment_payment($enrollment_payment_data);	
								
								if (!$enrollment_payment_response['success']) {
									$this->session->set_flashdata('portwallet_error', 'Oops! something went wrong.');
								}
								$this->session->unset_userdata('checkout_info')['courses'];
							}
						}else{
							$this->session->set_flashdata('portwallet_error', "Transaction successful but courses are not enrolled. please contact our support!");
						}
							
					}else{
						$this->session->set_flashdata('portwallet_error', "Failed to make transaction!");
					}
						}
			}else{
				$this->session->set_flashdata('portwallet_error', 'Payment failed!');
			}

			if (!$this->session->flashdata('portwallet_error')) {
				$this->session->set_flashdata('portwallet_success', 'Payment successful!');
			}

			if ($from == null) {
				redirect(base_url('home/shopping_cart?payment-status="successful"'));
			} else {
				redirect(base_url('home/shopping_cart?payment-status="failed"'));
				// $this->session->set_flashdata('portwallet_error', 'Oops! something went wrong.');
			}
		}

	}


	

}