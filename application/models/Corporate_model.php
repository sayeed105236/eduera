<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Corporate_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }



	/*
	* Retrieve all comapny
	*/
	public function get_company_list($return_type, $attribute_list, $filter_list = null, $limit = null){

		if ($limit != null){
			$this->db->limit($limit['limit'], $limit['offset']);
		}
        
		foreach ($attribute_list as $table=> $attribute) {
            foreach ($attribute as $attribute_name) {
                $this->db->select($table.'.'.$attribute_name);
            }
		 	
		}
		$this->db->from("company_user");

		if ($filter_list !== null && count($filter_list) > 0) {
			foreach ($filter_list as $filter_key => $filter_value) {
				$this->db->where('' . $filter_key, $filter_value);
			}
		}

        $this->db->join('company', 'company_user.company_id = company.id', 'LEFT');
        $this->db->join('user', 'company_user.user_id = user.id', 'LEFT');
        $this->db->join('department', 'company_user.department_id = department.id', 'LEFT');
        $this->db->join('designation', 'company_user.designation_id = designation.id', 'LEFT');

		if ($return_type == "OBJECT") {
			return $this->db->get()->result();
		} else if ($return_type == "COUNT"){
			return $this->db->get()->num_rows();
		} else {
			return null;
		}
	}

    /*
    * Retrieve all designation by company id
    */
    public function get_designation_list_by_company_id($return_type, $attribute_list, $filter_list = null, $limit = null){

        if ($limit != null){
            $this->db->limit($limit['limit'], $limit['offset']);
        }

        foreach ($attribute_list as $attribute) {
            $this->db->select(''.$attribute);
        }
        $this->db->from("designation");

        if ($filter_list !== null && count($filter_list) > 0) {
            foreach ($filter_list as $filter_key => $filter_value) {
                $this->db->where('' . $filter_key, $filter_value);
            }
        }

        if ($return_type == "OBJECT") {
            return $this->db->get()->result();
        } else if ($return_type == "COUNT"){
            return $this->db->get()->num_rows();
        } else {
            return null;
        }
    }


    /*
    * Retrieve all department by company id
    */
    public function get_department_list_by_company_id($return_type, $attribute_list, $filter_list = null, $limit = null){

        if ($limit != null){
            $this->db->limit($limit['limit'], $limit['offset']);
        }

        foreach ($attribute_list as $attribute) {
            $this->db->select(''.$attribute);
        }
        $this->db->from("department");

        if ($filter_list !== null && count($filter_list) > 0) {
            foreach ($filter_list as $filter_key => $filter_value) {
                $this->db->where('' . $filter_key, $filter_value);
            }
        }

        if ($return_type == "OBJECT") {
            return $this->db->get()->result();
        } else if ($return_type == "COUNT"){
            return $this->db->get()->num_rows();
        } else {
            return null;
        }
    }





    /*
    *	Create company
    */
    public function create_company($data){
    	if ($this->db->insert('company', $data)) {
    		return array("success" => true, "message" => "Data inserted successfully.", "id"=>$this->db->insert_id());
    	} else {
    		return array("success" => false, "message" => "Failed to insert data in db.");
    	}
    }

    /*
    *   Create company user
    */
    public function create_company_user($data){
        if ($this->db->insert('company_user', $data)) {
            return array("success" => true, "message" => "Data inserted successfully.");
        } else {
            return array("success" => false, "message" => "Failed to insert data in db.");
        }
    }


    /*
    *   Create company department
    */
    public function create_department($data){
        if ($this->db->insert('department', $data)) {
            return array("success" => true, "message" => "Data inserted successfully.");
        } else {
            return array("success" => false, "message" => "Failed to insert data in db.");
        }
    }

    /*
    *   Create company designation
    */
    public function create_designation($data){
        if ($this->db->insert('designation', $data)) {
            return array("success" => true, "message" => "Data inserted successfully.");
        } else {
            return array("success" => false, "message" => "Failed to insert data in db.");
        }
    }


    /*
    *	Update company
    */
    public function update_company($id, $data){
    	$this->db->set($data);
    	$this->db->where('id', $id);

    	if ($this->db->update('company')) {
    		return array("success" => true, "message" => "Data updated successfully.");
    	} else {
    		return array("success" => false, "message" => "Failed to update data in db.");
    	}
    }

    /*
    *   Update company
    */
    public function update_company_user($company_id, $user_id, $status){
        $data = array();
        $data['request_status'] = $status;
        $this->db->set($data);
        $this->db->where('company_id', $company_id);
        $this->db->where('user_id', $user_id);

        if ($this->db->update('company_user')) {
            return array("success" => true, "message" => "Data updated successfully.");
        } else {
            return array("success" => false, "message" => "Failed to update data in db.");
        }
    }


    /*
    *   Update company department
    */
    public function update_department($id, $data){
        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('department')) {
            return array("success" => true, "message" => "Data updated successfully.");
        } else {
            return array("success" => false, "message" => "Failed to update data in db.");
        }
    }

    /*
    *   Update company designation
    */
    public function update_designation($id, $data){
        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('designation')) {
            return array("success" => true, "message" => "Data updated successfully.");
        } else {
            return array("success" => false, "message" => "Failed to update data in db.");
        }
    }


    /*
    *	Delete company
    */
    public function delete_company($id){
    	$this->db->where('id', $id);
    	if ($this->db->delete('company')) {
    		return array("success" => true, "message" => "Data deleted successfully.");
    	} else {
    		return array("success" => false, "message" => "Failed to delete data in db.");
    	}
    }

    /*
    *   Delete company department
    */
    public function delete_department_or_designation_or_company_user($id, $table_name){
        $this->db->where('id', $id);
        if ($this->db->delete($table_name)) {
            return array("success" => true, "message" => "Data deleted successfully.");
        } else {
            return array("success" => false, "message" => "Failed to delete data in db.");
        }
    }




    /*
    * Retrieve all user by company wise
    */
    // public function get_user_list_by_company($return_type, $attribute_list, $filter_list = null, $limit = null){

    //     if ($limit != null){
    //         $this->db->limit($limit['limit'], $limit['offset']);
    //     }
        
    //     foreach ($attribute_list as $table=> $attribute) {
    //         foreach ($attribute as $attribute_name) {
    //             $this->db->select($table.'.'.$attribute_name);
    //         }
            
    //     }
    //     $this->db->from("company_user");

    //     if ($filter_list !== null && count($filter_list) > 0) {
    //         foreach ($filter_list as $filter_key => $filter_value) {
    //             $this->db->where('' . $filter_key, $filter_value);
    //         }
    //     }

    //     $this->db->join('user', 'company_user.user_id = user.id', 'LEFT');
    //     $this->db->join('department', 'company_user.department_id = department.id', 'LEFT');
    //     $this->db->join('designation', 'company_user.designation_id = designation.id', 'LEFT');
    //     if ($return_type == "OBJECT") {
    //         return $this->db->get()->result();
    //     } else if ($return_type == "COUNT"){
    //         return $this->db->get()->num_rows();
    //     } else {
    //         return null;
    //     }
    // }

    



}

?>