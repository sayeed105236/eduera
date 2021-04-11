<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


    public function get_category_for_menu(){
        $category_list = $this->get_category_list(array('id', 'name'));
    
        for( $i = 0; $i < count($category_list); $i++){
            $category_list[$i]->sub_category_list = $this->get_sub_category_list_by_parent_id($category_list[$i]->id, array('id', 'name'));
        }
        return $category_list;
    }


    public function get_sub_category_list_by_category_id($category_id, $attribute_list){
        foreach ($attribute_list as $attribute) {
            $this->db->select(''.$attribute);
        }
        $this->db->from("category");
        $this->db->where("parent", $category_id);        
        return $this->db->get()->result();
    }


    // Get category list
    public function get_category_list($attribute_list = []) {
    
        foreach ($attribute_list as $attrubute) {
            $this->db->select(''.$attrubute);
        }

        $this->db->from('category');
        $this->db->where('parent', 0);
        return $this->db->get()->result();
    }


    // Get category by id
    public function get_category_by_id($id, $attributes = []) {
    
        foreach ($attributes as $attrubute) {
          $this->db->select($attrubute);
        }
        $this->db->from('category');
        $this->db->where('id', $id);
        
        return $this->db->get()->result();
    }


    // Get subCategory list by parent id
    public function get_sub_category_list_by_parent_id($parent_id, $attributes = []){
    
        foreach ($attributes as $attrubute) {
          $this->db->select($attrubute);
        }
        $this->db->from('category');
        $this->db->where('parent', $parent_id);

        return $this->db->get()->result();
    }

}