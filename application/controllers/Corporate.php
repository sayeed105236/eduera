<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Corporate extends CI_Controller {

	private $pate_data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');  
        $this->page_data['instructor_page_name'] = "";
        $this->session->set_userdata('previous_url', current_url());
        if ($this->session->userdata('user_type') !== "USER" && $this->session->userdata('user_type') !== "ADMIN" && $this->session->userdata('user_type') !== "SUPER_ADMIN") {
            redirect(site_url('login'), 'refresh');
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->page_data['system_name'] = get_settings('system_name');
        $this->load->model('service/service_corporate', 'service_corporate');
        
    }

    


    public function dashboard($company_id = null){
       
        if($company_id == '' || $company_id == null){
            redirect(base_url('page_not_found'));
        }
       
        if(!is_admin_of_a_company($this->session->userdata('user_id'), $company_id)){
            redirect(base_url('page_not_found'));
        }

        $this->page_data['company'] =  $this->corporate_model->get_company_list(
                    'OBJECT', 
                    array(
                        'company'   =>  array('name'),                        
                    ), 
                    array(
                        'company_user.company_id' => $company_id,
                        'company_user.user_id' => $this->session->userdata('user_id')
                    )
                )[0];
        /* company user list*/
        $this->page_data['total_user'] = $this->corporate_model->get_company_list(
            'COUNT', 
            array(
                'user'          =>  array('id'),
            ), 
            array(
                'company_user.company_id' => $company_id,

            )
        );


        $this->page_data['total_department'] = $this->corporate_model->get_department_list_by_company_id('COUNT', array('id', 'name', 'company_id'), array('company_id'=>  $company_id));

     


        $this->page_data['company_id'] = $company_id;
        $this->page_data['page_name'] = "corporate_dashboard";
        $this->page_data['page_title'] = "Corporate dashboard";
        $this->page_data['page_view'] = "corporate/dashboard";
        $this->load->view('corporate/index', $this->page_data);
    }


    public function users($company_id = null){
        $this->page_data['company_id'] = $company_id;
        if($company_id == '' || $company_id == null){
            redirect(base_url('page_not_found'));
        }
        
        if(!is_admin_of_a_company($this->session->userdata('user_id'), $company_id)){
            redirect(base_url('page_not_found'));
        }
        $this->page_data['company'] =  $this->corporate_model->get_company_list(
                    'OBJECT', 
                    array(
                        'company'   =>  array('name'),                        
                    ), 
                    array(
                        'company_user.company_id' => $company_id,
                        'company_user.user_id' => $this->session->userdata('user_id')
                    )
                )[0];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        if($this->form_validation->run('user_create_form') == FALSE){

            $this->page_data['company'] =  $this->corporate_model->get_company_list(
                    'OBJECT', 
                    array(
                        'company'   =>  array('name'),                        
                    ), 
                    array(
                        'company_user.company_id' => $company_id,
                        'company_user.user_id' => $this->session->userdata('user_id')
                    )
                )[0];

            $this->page_data['user_list'] = $this->corporate_model->get_company_list(
                'OBJECT', 
                array(
                    'user'          =>  array('id', 'first_name', 'last_name', 'email', 'phone'),
                    'company_user'  =>  array('corporate_role', 'request_status', 'company_id', 'id as company_user_id'),
                    'department'    =>  array('name  as department'),
                    'designation'   =>  array('name as designation')
                ), 
                array(
                    'company_user.company_id' => $company_id,
                     'company_user.corporate_role' => 'USER'                       
                )
            );

            

            $this->page_data['existing_user_list'] = $this->user_model->get_user_list(
                array('id', 'first_name', 'last_name',  'email'), 
                "OBJECT",
                array('user_type' => 'USER')
                
            );

            $this->page_data['department_list'] = $this->corporate_model->get_department_list_by_company_id( 'OBJECT',
                array('id', 'name', 'company_id'),
                array('company_id' => $company_id)
                
            );

            $this->page_data['designation_list'] = $this->corporate_model->get_designation_list_by_company_id( 'OBJECT',
                array('id', 'name', 'company_id'),
                array('company_id' => $company_id)
            );
          
        }else if(html_escape($this->input->post('user_id')) == null){
            $this->service_corporate->save_new_user($company_id);
        }else{
           
            $this->service_corporate->save_user($company_id);
        }
        $this->page_data['page_name'] = "corporate_users";
        $this->page_data['page_title'] = "Corporate users";
        $this->page_data['page_view'] = "corporate/users";
        $this->load->view('corporate/index', $this->page_data);
    }


    public function courses($company_id = null){
        $this->page_data['company_id'] = $company_id;

        if($company_id == '' || $company_id == null){
            redirect(base_url('page_not_found'));
        }
        if(!is_admin_of_a_company($this->session->userdata('user_id'), $company_id)){
            redirect(base_url('page_not_found'));
        }
        $this->page_data['company'] =  $this->corporate_model->get_company_list(
                    'OBJECT', 
                    array(
                        'company'   =>  array('name'),                        
                    ), 
                    array(
                        'company_user.company_id' => $company_id,
                        'company_user.user_id' => $this->session->userdata('user_id')
                    )
                )[0];
        $this->page_data['page_name'] = "corporate_courses";
        $this->page_data['page_title'] = "Corporate courses";
        $this->page_data['page_view'] = "corporate/courses";
        $this->load->view('corporate/index', $this->page_data);
    }


    public function designation($company_id = null){

        $this->page_data['company_id'] = $company_id; 
        if($company_id == '' || $company_id == null){
            redirect(base_url('page_not_found'));
        }
        
        if(!is_admin_of_a_company($this->session->userdata('user_id'), $company_id)){
            redirect(base_url('page_not_found'));
        }

        $this->page_data['company'] =  $this->corporate_model->get_company_list(
                    'OBJECT', 
                    array(
                        'company'   =>  array('name'),                        
                    ), 
                    array(
                        'company_user.company_id' => $company_id,
                        'company_user.user_id' => $this->session->userdata('user_id')
                    )
                )[0];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        if($this->form_validation->run('designation_create_form') == FALSE){

            $this->page_data['designation_list'] = $this->corporate_model->get_designation_list_by_company_id('OBJECT', array('id', 'name', 'company_id'), array('company_id'=>  $company_id));

            $this->page_data['page_name'] = "corporate_designation";
            $this->page_data['page_title'] = "Corporate designation";
            $this->page_data['page_view'] = "corporate/designation";
            $this->load->view('corporate/index', $this->page_data);
        }else{
           
            $this->service_corporate->save_designation($company_id);
        }
    }


    public function department($company_id = null){
        $this->page_data['company_id'] = $company_id;

        if($company_id == '' || $company_id == null){
            redirect(base_url('page_not_found'));
        }
        
        if(!is_admin_of_a_company($this->session->userdata('user_id'), $company_id)){
            redirect(base_url('page_not_found'));
        }

        $this->page_data['company'] =  $this->corporate_model->get_company_list(
                    'OBJECT', 
                    array(
                        'company'   =>  array('name'),                        
                    ), 
                    array(
                        'company_user.company_id' => $company_id,
                        'company_user.user_id' => $this->session->userdata('user_id')
                    )
                )[0];
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        if($this->form_validation->run('department_create_form') == FALSE){

            $this->page_data['department_list'] = $this->corporate_model->get_department_list_by_company_id('OBJECT', array('id', 'name', 'company_id'), array('company_id'=>  $company_id));
            $this->page_data['page_name'] = "corporate_department";
            $this->page_data['page_title'] = "Corporate department";
            $this->page_data['page_view'] = "corporate/department";
            $this->load->view('corporate/index', $this->page_data);
        }else{
            $this->service_corporate->save_department($company_id);
        }
    }

    /*
    * Designation - Get designation by designation id
    */
    public function get_single_designation_info(){ 

        $designation = $this->corporate_model->get_designation_list_by_company_id('OBJECT', array('id', 'name', 'company_id'), array('id'=> $_GET['id']));
        echo json_encode($designation);
    }

    /*
    * Department - Get Department by department id
    */
    public function get_single_department_info(){ 

        $department = $this->corporate_model->get_department_list_by_company_id('OBJECT', array('id', 'name', 'company_id'), array('id'=> $_GET['id']));
        echo json_encode($department);
    }


    /*
    * Controller - remove particular designation from company
    */
    public function remove_designation($designation_id){
        $table_name = 'designation';
        $designation =  $this->corporate_model->delete_department_or_designation_or_company_user($designation_id, $table_name);

        if($designation){
            $this->session->set_flashdata('designation_save_success_message', 'Designation removed successfully.');
        }else{
            $this->session->set_flashdata('designation_save_failed_message', 'Failed to remove this designation!');
        }

        redirect(base_url('/corporate/'.$_GET['company_id'].'/designation'));
    }


    /*
    * Controller - remove particular department from company
    */
    public function remove_department($department_id){
        $table_name = 'department';
        $department =  $this->corporate_model->delete_department_or_designation_or_company_user($department_id, $table_name);
        if($department){
            $this->session->set_flashdata('department_save_success_message', 'Department removed successfully.');
        }else{
            $this->session->set_flashdata('department_save_failed_message', 'Failed to remove this department!');
        }

        redirect(base_url('/corporate/'.$_GET['company_id'].'/department'));
    }

    /*
    * Controller - remove particular user from company
    */
    public function remove_user($user_id){
        $table_name = 'company_user';
        $user =  $this->corporate_model->delete_department_or_designation_or_company_user($user_id, $table_name);
        if($user){
            $this->session->set_flashdata('user_save_success_message', 'User removed successfully.');
        }else{
            $this->session->set_flashdata('user_save_failed_message', 'Failed to remove this user!');
        }

        redirect(base_url('/corporate/'.$_GET['company_id'].'/users'));
    }
}
