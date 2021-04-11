<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_course extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


    public function save_quiz_set($course_id) {
    	$quiz_set_id = html_escape($this->input->post('quiz_set_id'));
    	$data['course_id'] = $course_id;
    	$data['name'] = html_escape($this->input->post('name'));
    	$data['type'] = html_escape($this->input->post('type'));
    	$data['duration'] = html_escape($this->input->post('duration'));
    	$free_access = html_escape($this->input->post('free_access'));
    	$quiz_result = html_escape($this->input->post('quiz_result'));
    	if($quiz_result != NULL || $quiz_result != ''){
    		$data['quiz_result'] = 1;
    	}else{
    		$data['quiz_result'] = 0;
    	}

    	if($free_access != NULL || $free_access != ''){
    		$data['free_access'] = 1;
    	}else{
    		$data['free_access'] = 0;
    	}
    	
    	
    	if (html_escape($this->input->post('option')) == 'lesson') {
    		$data['lesson_id'] = html_escape($this->input->post('lesson_id'));
    	} else {
    		$data['lesson_id'] = NULL;
    	}
    	$question_id_list = html_escape($this->input->post('question_id_list'));
    	$questions = explode(',', $question_id_list);
    	$data['question_id_list'] = '["' . implode('","', $questions) . '"]';


        // debug($quiz_set_id);

        // exit;
    	
    	if ($quiz_set_id != null && $quiz_set_id != '') {
    		// if (has_role($this->session->userdata('user_id'), 'QUIZ_UPDATE')) {
    			$result = $this->quiz_model->insert_set($data, $quiz_set_id);
    		
    			if ($result) {
    				if ($result['success']) {

    				


    					$this->session->set_flashdata('quiz_set_save_success', 'Quiz set is updated successfully.');
    				} else {
    					$this->session->set_flashdata('quiz_set_save_failed', $result['message']);
    				}
    			} else {
    				$this->session->set_flashdata('quiz_set_save_failed', 'Failed to updated!');
    			}
    		// } else {
    		// 	redirect(base_url('page_not_found'));
    		// }

    	} else {
    		// if (has_role($this->session->userdata('user_id'), 'QUIZ_CREATE')) {
    			$result = $this->quiz_model->insert_set($data);
    			if ($result) {
    				if ($result['success']) {

    					$this->session->set_flashdata('quiz_set_save_success', 'Quiz set is inserted successfully.');
    				} else {
    					$this->session->set_flashdata('quiz_set_save_failed', $result['message']);
    				}
    			} else {
    				$this->session->set_flashdata('quiz_set_save_failed', 'Failed to insert!');
    			}
    		// } else {
    		// 	redirect(base_url('page_not_found'));
    		// }
    	}

    	redirect(base_url('instructor/course/' . $course_id .'/quiz_set?option=course'));
    }

    
}