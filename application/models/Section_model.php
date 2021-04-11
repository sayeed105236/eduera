<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section_model extends CI_Model {

  	function __construct()
  	{
    	parent::__construct();
    
	    /*cache control*/
	    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	    $this->output->set_header('Pragma: no-cache');
  	}


    /*
    *   Get section list of a course
    */
  	public function get_section_list_by_course_id($course_id, $attribute_list){
  		// foreach ($attribute_list as $attribute) {
    //         $this->db->select(''.$attribute);
    //     }
        
        $sql = "SELECT * FROM section WHERE course_id = ? ORDER BY rank";
        return $this->db->query($sql, array($course_id))->result();
        
        // SELECT * FROM `section` WHERE course_id = 1 ORDER BY rank
        
        // $this->db->from("section");
        // $this->db->where("course_id", $course_id);
        // $this->db->order_by("rank", "ASC");

        // return $this->db->get()->result();
  	}

    /*
    *   Get section by id
    */
    public function get_section_list($return_type, $attribute_list, $filter_list = null){
        foreach ($attribute_list as $attribute) {
            $this->db->select(''.$attribute);
        }

        $this->db->from("section");
        // $this->db->order_by("rank", "ASC");

        if ($filter_list !== null && count($filter_list) > 0) {
            foreach ($filter_list as $filter_key => $filter_value) {
                $this->db->where('' . $filter_key, $filter_value);
            }
        }

        if ($return_type == "OBJECT") {
            return $this->db->get()->result();
        } else if ($returen_type == "COUNT"){
            return $this->db->get()->num_rows();
        } else {
            return null;
        }
    }



}
