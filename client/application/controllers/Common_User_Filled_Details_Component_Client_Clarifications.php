<?php

class Common_User_Filled_Details_Component_Client_Clarifications extends CI_Controller {
	
	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url');
	  	$this->load->model('common_User_Filled_Details_Component_Client_Clarifications_Model');
	  	$this->load->model('teamModel');
	  	$this->load->model('custom_Util_Model');
	}

	function raise_new_client_clarification() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_client_request) && $verify_client_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}

		$store_client_clarification_files = 'no-file';
		$output_client_clarification_files = '../uploads/user-filled-details-component-client-clarification-attached-files/';
		
		if(isset($_FILES['client_clarification_attach_file'])) {
        	$error = $_FILES["client_clarification_attach_file"]["error"]; 
            if(!is_array($_FILES["client_clarification_attach_file"]["name"])) {
                $files_name = $_FILES["client_clarification_attach_file"]["name"];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                // $client_clarification_attach_file = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
                // $fileName = $client_clarification_attach_file.'.'.$file_ext;
                $fileName = uniqid().date('YmdHsi').'.'.$file_ext;
                move_uploaded_file($_FILES["client_clarification_attach_file"]["tmp_name"],$output_client_clarification_files.$fileName);
                $store_client_clarification_files = $fileName; 
            } else {
             	$fileCount = count($_FILES["client_clarification_attach_file"]["name"]);
              	for($i=0; $i < $fileCount; $i++) {
                 	$files_name = $_FILES["client_clarification_attach_file"]["name"][$i];
                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                	// $client_clarification_attach_file = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
                	// $fileName = $client_clarification_attach_file.'.'.$file_ext;
                	$fileName = uniqid().date('YmdHsi').'.'.$file_ext;
                	move_uploaded_file($_FILES["client_clarification_attach_file"]["tmp_name"][$i],$output_client_clarification_files.$fileName);
                	$store_client_clarification_files[]= $fileName; 
              	}
            } 
        }

		echo json_encode(array('status'=>'1','raise_client_clarification_details'=>$this->common_User_Filled_Details_Component_Client_Clarifications_Model->raise_new_client_clarification($logged_in_user_details,$store_client_clarification_files)));
	}

	function get_all_client_clarifications() {
		extract($_POST);
		$logged_in_user_details = [];
		$variable_array = [];
		if (isset($verify_client_request) && $verify_client_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			$variable_array['logged_in_user_details'] = $logged_in_user_details;
			$variable_array['candidate_id'] = $this->input->post('candidate_id');

			if ($logged_in_user_details == '') {
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}

		$check_candidate_id_request = $this->common_User_Filled_Details_Component_Client_Clarifications_Model->check_candidate_id_request($variable_array);
		if($check_candidate_id_request['count'] == 1) {
			echo json_encode(array('status'=>'1','all_clarifications'=>$this->common_User_Filled_Details_Component_Client_Clarifications_Model->get_all_client_clarifications($variable_array),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
		} else {
			echo json_encode(array('status'=>'0','all_clarifications'=>''));
		}
	}

	function get_single_client_clarification_details() {
		extract($_POST);
		$logged_in_user_details = [];
		$variable_array = [];
		if (isset($verify_client_request) && $verify_client_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			$variable_array['logged_in_user_details'] = $logged_in_user_details;
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}

		echo json_encode(array('status'=>'1','clarification_details'=>$this->common_User_Filled_Details_Component_Client_Clarifications_Model->get_single_client_clarification_details($variable_array,$this->input->post('user_filled_details_component_client_clarification_id')),'get_ticket_priority_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-priority-list.json'),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
	}

	function add_new_client_clarification_comment() {
		extract($_POST);
		$logged_in_user_details = [];
		$variable_array = [];
		if (isset($verify_client_request) && $verify_client_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			$variable_array['logged_in_user_details'] = $logged_in_user_details;
			if ($logged_in_user_details == '') {
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}
		echo json_encode(array('status'=>'1','clarification_details'=>$this->common_User_Filled_Details_Component_Client_Clarifications_Model->add_new_client_clarification_comment($variable_array)));
	}

	function get_client_clarification_single_comment() {
		extract($_POST);
		$logged_in_user_details = [];
		$variable_array = [];
		if (isset($verify_client_request) && $verify_client_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			$variable_array['logged_in_user_details'] = $logged_in_user_details;
			if ($logged_in_user_details == '') {
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}
		echo json_encode(array('status'=>'1','clarification_details'=>$this->common_User_Filled_Details_Component_Client_Clarifications_Model->get_client_clarification_single_comment($variable_array)));
	}

	function get_single_client_clarifications_all_comments() {
		extract($_POST);
		$logged_in_user_details = [];
		$variable_array = [];
		if (isset($verify_client_request) && $verify_client_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			$variable_array['logged_in_user_details'] = $logged_in_user_details;
			$variable_array['candidate_id'] = $this->input->post('candidate_id');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}
		echo json_encode(array('status'=>'1','clarification_details'=>$this->common_User_Filled_Details_Component_Client_Clarifications_Model->get_single_client_clarifications_all_comments($variable_array),'all_team_members'=>$this->teamModel->get_team_list()));
	}

	function update_client_clarification_status() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_client_request) && $verify_client_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-client');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}
		echo json_encode(array('status'=>'1','clarification_details'=>$this->common_User_Filled_Details_Component_Client_Clarifications_Model->update_client_clarification_status($logged_in_user_details),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
	}
}