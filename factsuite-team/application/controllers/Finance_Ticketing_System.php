<?php

class Finance_Ticketing_System extends CI_Controller {
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url');
	  $this->load->model('finance_Ticketing_System_Model');
	  $this->load->model('teamModel');
	  $this->load->model('emailModel');
	} 

	function check_finance_login() {
		if(!$this->session->userdata('logged-in-finance')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function raise_ticket() {
		$this->check_finance_login();
		$outputqcData['userData'] = $this->session->userdata('logged-in-finance');
		$this->load->view('finance/finance-common/header',$outputqcData);
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('finance/ticketing-system/ticketing-system-common');
		$this->load->view('finance/ticketing-system/tickets');
		$this->load->view('finance/finance-common/footer');
	}

	function raise_new_ticket() {
		$this->check_finance_login();
		$store_ticket_files = 'no-file';
		$output_ticket_files = 'uploads/ticket-attached-files/';
		
		if(isset($_FILES['ticket_attach_file'])) {
        	$error = $_FILES["ticket_attach_file"]["error"]; 
            if(!is_array($_FILES["ticket_attach_file"]["name"])) {
                $files_name = $_FILES["ticket_attach_file"]["name"];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                // $ticket_attach_file = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
                // $fileName = $ticket_attach_file.'.'.$file_ext;
                $fileName = uniqid().date('YmdHsi').'.'.$file_ext;
                move_uploaded_file($_FILES["ticket_attach_file"]["tmp_name"],$output_ticket_files.$fileName);
                $store_ticket_files = $fileName; 
            } else {
             	$fileCount = count($_FILES["ticket_attach_file"]["name"]);
              	for($i=0; $i < $fileCount; $i++) {
                 	$files_name = $_FILES["ticket_attach_file"]["name"][$i];
                	$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                	// $ticket_attach_file = preg_replace('/[^a-zA-Z]+/', '-', trim(strtolower($this->input->post('short_description'))));
                	// $fileName = $ticket_attach_file.'.'.$file_ext;
                	$fileName = uniqid().date('YmdHsi').'.'.$file_ext;
                	move_uploaded_file($_FILES["ticket_attach_file"]["tmp_name"][$i],$output_ticket_files.$fileName);
                	$store_ticket_files[]= $fileName; 
              	}
            } 
        }

		echo json_encode(array('status'=>'1','raise_ticket_details'=>$this->finance_Ticketing_System_Model->raise_new_ticket($store_ticket_files)));
	}

	function get_all_tickets() {
		$this->check_finance_login();
		echo json_encode(array('status'=>'1','all_tickets'=>$this->finance_Ticketing_System_Model->get_all_tickets(),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
	}

	function get_ticket_details() {
		$this->check_finance_login();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->finance_Ticketing_System_Model->get_ticket_details($this->input->post('ticket_id')),'get_ticket_priority_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-priority-list.json'),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
	}

	function add_new_ticket_comment() {
		$this->check_finance_login();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->finance_Ticketing_System_Model->add_new_ticket_comment()));
	}

	function get_ticket_single_comment() {
		$this->check_finance_login();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->finance_Ticketing_System_Model->get_ticket_single_comment(),'all_team_members'=>$this->teamModel->get_team_list()));
	}

	function get_single_ticket_all_comments() {
		$this->check_finance_login();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->finance_Ticketing_System_Model->get_single_ticket_all_comments(),'all_team_members'=>$this->teamModel->get_team_list()));
	}

	function update_ticket_status() {
		$this->check_finance_login();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->finance_Ticketing_System_Model->update_ticket_status(),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
	}
}