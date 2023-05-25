<?php

class Admin_Ticketing_System extends CI_Controller {
	
	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url');
	  	$this->load->model('admin_Ticketing_System_Model');
	  	$this->load->model('teamModel');
	  	$this->load->model('clientModel');
	  	$this->load->model('emailModel');
	} 

	function check_admin_login() {
		if(!$this->session->userdata('logged-in-admin')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function raise_ticket() {
		$this->check_admin_login();
		$outputqcData['userData'] = $this->session->userdata('logged-in-admin');
		$this->load->view('admin/admin-common/header',$outputqcData);
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/ticketing-system/ticketing-system-common');
		$this->load->view('admin/ticketing-system/tickets');
		$this->load->view('admin/admin-common/footer');
	}

	function get_all_tickets() {
		$this->check_admin_login();
		echo json_encode(array('status'=>'1','all_tickets'=>$this->admin_Ticketing_System_Model->get_all_tickets(),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json'),'all_team_members'=>$this->teamModel->get_team_list(),'all_clients'=>$this->clientModel->get_all_clients()));
	}

	function get_ticket_details() {
		$this->check_admin_login();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->admin_Ticketing_System_Model->get_ticket_details($this->input->post('ticket_id')),'get_ticket_priority_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-priority-list.json'),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
	}

	function update_ticket_status() {
		$this->check_admin_login();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->admin_Ticketing_System_Model->update_ticket_status(),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
	}

	function add_new_ticket_comment() {
		$this->check_admin_login();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->admin_Ticketing_System_Model->add_new_ticket_comment()));
	}

	function get_ticket_single_comment() {
		$this->check_admin_login();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->admin_Ticketing_System_Model->get_ticket_single_comment(),'all_team_members'=>$this->teamModel->get_team_list(),'all_clients'=>$this->clientModel->get_all_clients()));
	}

	function get_single_ticket_all_comments() {
		$this->check_admin_login();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->admin_Ticketing_System_Model->get_single_ticket_all_comments(),'all_team_members'=>$this->teamModel->get_team_list(),'all_clients'=>$this->clientModel->get_all_clients()));
	}
}