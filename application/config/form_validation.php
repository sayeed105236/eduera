<?php

$config = array(
	'registration_form' => array(
		array(
			'field' => 'signup_first_name',
			'label' => 'First name',
			'rules' => 'required',
		),
		array(
			'field' => 'signup_last_name',
			'label' => 'Last name',
			'rules' => 'required',
		),
		array(
			'field' => 'signup_email',
			'label' => 'Email',
			'rules' => 'required|valid_email',
		),
		array(
			'field' => 'signup_phone',
			'label' => 'Phone',
			'rules' => 'required',
		),
		array(
			'field' => 'signup_password',
			'label' => 'Password',
			'rules' => 'required|min_length[6]',
		),
	),
	'login_form' => array(
		array(
			'field' => 'login_email',
			'label' => 'Email',
			'rules' => 'required',
		),
		array(
			'field' => 'login_password',
			'label' => 'Password',
			'rules' => 'required',
		),
	),

	'update_profile_info_form' => array(
		array(
			'field' => 'first_name',
			'label' => 'First name',
			'rules' => 'required',
		),
		array(
			'field' => 'last_name',
			'label' => 'Last name',
			'rules' => 'required',
		),
	),

	'change_credential_form' => array(
		array(
			'field' => 'current_password',
			'label' => 'Current password',
			'rules' => 'required',
		),
		array(
			'field' => 'new_password',
			'label' => 'New password',
			'rules' => 'required|min_length[6]',
		),
		array(
			'field' => 'confirm_password',
			'label' => 'Confirm password',
			'rules' => 'required|min_length[6]|matches[new_password]',
		),
	),

	'forgot_password_form' => array(
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required',
		),

	),
	'corporate_create_form' => array(
		array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required',
		),
		array(
			'field' => 'phone',
			'label' => 'Phone',
			'rules' => 'required',
		),

		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email',
		),

	),
	'designation_create_form' => array(
		array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required',
		),

	),
	'department_create_form' => array(
		array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required',
		),

	),

	'user_create_form' => array(
		// array(
		//     'field' => 'user_id',
		//     'label' => 'User',
		//     'rules' => 'required'
		// ),
		array(
			'field' => 'corporate_role',
			'label' => 'Role',
			'rules' => 'required',
		),

	),
	'contact_form' => array(

		array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required',
		),
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email',
		),
		array(
			'field' => 'phone',
			'label' => 'Phone',
			'rules' => 'required',
		),

		array(
			'field' => 'message',
			'label' => 'Message',
			'rules' => 'required',
		),

	),
	'check_certificate' => array(
		array(
			'field' => 'certificate_no',
			'label' => 'Certificate No',
			'rules' => 'required',
		),

	),

	'membership_form' => array(
		array(
			'field' => 'name',
			'label' => 'Full Name',
			'rules' => 'required',
		),
		array(
			'field' => 'phone',
			'label' => 'Phone Number',
			'rules' => 'required|min_length[11]|max_length[13]|integer',
		),
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email',
		),

		array(
			'field' => 'membership',
			'label' => 'Membership',
			'rules' => 'required',
		),

		// array(
		// 	'field' => 'courses',
		// 	'label' => 'Course',
		// 	'rules' => 'required',
		// 	'errors' => array(
  //                  'required' => 'You must select two course.',
  //          ),
		// ),
	),
	'course_quiz_set_form' => array(
		array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required',
		),

	),
);

?>