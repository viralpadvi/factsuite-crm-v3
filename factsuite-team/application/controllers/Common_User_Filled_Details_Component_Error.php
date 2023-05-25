<?php

class Common_User_Filled_Details_Component_Error extends CI_Controller {
	
	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url');
	  	$this->load->model('common_User_Filled_Details_Component_Error_Model');
	  	$this->load->model('teamModel');
	  	$this->load->model('emailModel');
	}

	function raise_new_error() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_analyst_request) && $verify_analyst_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-analyst');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}

		$store_error_files = 'no-file';
		$output_error_files = 'uploads/user-filled-details-component-error-attached-files/';
		
		if(isset($_FILES['error_attach_file'])) {
        	$error = $_FILES["error_attach_file"]["error"]; 
            if(!is_array($_FILES["error_attach_file"]["name"])) {
                $files_name = $_FILES["error_attach_file"]["name"];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                // $error_attach_file = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
                // $fileName = $error_attach_file.'.'.$file_ext;
                $fileName = uniqid().date('YmdHsi').'.'.$file_ext;
                move_uploaded_file($_FILES["error_attach_file"]["tmp_name"],$output_error_files.$fileName);
                $store_error_files = $fileName; 
            } else {
             	$fileCount = count($_FILES["error_attach_file"]["name"]);
              	for($i=0; $i < $fileCount; $i++) {
                 	$files_name = $_FILES["error_attach_file"]["name"][$i];
                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                	// $error_attach_file = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
                	// $fileName = $error_attach_file.'.'.$file_ext;
                	$fileName = uniqid().date('YmdHsi').'.'.$file_ext;
                	move_uploaded_file($_FILES["error_attach_file"]["tmp_name"][$i],$output_error_files.$fileName);
                	$store_error_files[]= $fileName; 
              	}
            } 
        }

		echo json_encode(array('status'=>'1','raise_error_details'=>$this->common_User_Filled_Details_Component_Error_Model->raise_new_error($logged_in_user_details,$store_error_files)));
	}

	function get_all_error_log() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_analyst_request) && $verify_analyst_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-analyst');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}
		echo json_encode(array('status'=>'1','all_errors'=>$this->common_User_Filled_Details_Component_Error_Model->get_all_error_log($logged_in_user_details),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
	}

	function get_single_error_details() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_analyst_request) && $verify_analyst_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-analyst');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}
		echo json_encode(array('status'=>'1','error_details'=>$this->common_User_Filled_Details_Component_Error_Model->get_single_error_details($logged_in_user_details,$this->input->post('user_filled_details_component_error_id')),'get_ticket_priority_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-priority-list.json'),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
	}

	function add_new_error_comment() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_analyst_request) && $verify_analyst_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-analyst');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}
		echo json_encode(array('status'=>'1','error_details'=>$this->common_User_Filled_Details_Component_Error_Model->add_new_error_comment($logged_in_user_details)));
	}

	function get_error_single_comment() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_analyst_request) && $verify_analyst_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-analyst');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}
		echo json_encode(array('status'=>'1','error_details'=>$this->common_User_Filled_Details_Component_Error_Model->get_error_single_comment(),'all_team_members'=>$this->teamModel->get_team_list()));
	}

	function get_single_error_all_comments() {
		extract($_POST);
		$logged_in_user_details = [];
		if (isset($verify_analyst_request) && $verify_analyst_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-analyst');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else if (isset($verify_admin_request) && $verify_admin_request == 1) {
			$logged_in_user_details = $this->session->userdata('logged-in-admin');
			if ($logged_in_user_details == '') {	
				echo json_encode(array('status'=>'0','message'=>'No User found.'));
				return false;
			}
		} else {
			echo json_encode(array('status'=>'0','message'=>'No User found.'));
			return false;
		}
		echo json_encode(array('status'=>'1','error_details'=>$this->common_User_Filled_Details_Component_Error_Model->get_single_error_all_comments($logged_in_user_details),'all_team_members'=>$this->teamModel->get_team_list()));
	}

	function update_ticket_status() {
		$this->check_finance_login();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->finance_Ticketing_System_Model->update_ticket_status(),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
	}
}