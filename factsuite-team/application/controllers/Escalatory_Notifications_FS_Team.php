<?php

class Escalatory_Notifications_FS_Team extends CI_Controller {
	
	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url');
	  	$this->load->model('escalatory_Notifications_FS_Team_Model');
	  	$this->load->model('teamModel');
	  	$this->load->model('clientModel');
	  	$this->load->model('emailModel');
	}

	function get_logged_in_details() {
		if (isset($_POST) && $this->input->post('verify_inputqc_request') == 1 && $this->session->userdata('logged-in-inputqc') != '') {
			$variable_array = array(
				'logged_in_user_details' => $this->session->userdata('logged-in-inputqc'),
				'role' => 'inputqc',
				'type' => 'fs_team'
			);
		} else if (isset($_POST) && $this->input->post('verify_analyst_request') == 1 && ($this->session->userdata('logged-in-analyst') != '' || $this->session->userdata('logged-in-insuffanalyst') != '')) {
			$variable_array = array(
				'type' => 'fs_team'
			);
			if($this->session->userdata('logged-in-analyst') != '') {
				$variable_array['logged_in_user_details'] = $this->session->userdata('logged-in-analyst');
				$variable_array['role'] = 'analyst';
			} else if($this->session->userdata('logged-in-insuffanalyst') != '') {
				$variable_array['logged_in_user_details'] = $this->session->userdata('logged-in-insuffanalyst');
				$variable_array['role'] = 'insuff analyst';
			}
		} else if (isset($_POST) && $this->input->post('verify_admin_request') == 1 && $this->session->userdata('logged-in-admin') != '') {
			$variable_array = array(
				'logged_in_user_details' => $this->session->userdata('logged-in-admin'),
				'role' => 'admin',
				'type' => 'fs_team'
			);
		} else if (isset($_POST) && $this->input->post('verify_specialist_request') == 1 && $this->session->userdata('logged-in-specialist') != '') {
			$variable_array = array(
				'logged_in_user_details' => $this->session->userdata('logged-in-specialist'),
				'role' => 'specialist',
				'type' => 'fs_team'
			);
		} else if (isset($_POST) && $this->input->post('verify_outputqc_request') == 1 && $this->session->userdata('logged-in-outputqc') != '') {
			$variable_array = array(
				'logged_in_user_details' => $this->session->userdata('logged-in-outputqc'),
				'role' => 'outputqc',
				'type' => 'fs_team'
			);
		} else if (isset($_POST) && $this->input->post('verify_finance_request') == 1 && $this->session->userdata('logged-in-finance') != '') {
			$variable_array = array(
				'logged_in_user_details' => $this->session->userdata('logged-in-finance'),
				'role' => 'finance',
				'type' => 'fs_team'
			);
		} else if (isset($_POST) && $this->input->post('verify_csm_request') == 1 && $this->session->userdata('logged-in-csm') != '') {
			$variable_array = array(
				'logged_in_user_details' => $this->session->userdata('logged-in-csm'),
				'role' => 'csm',
				'type' => 'fs_team'
			);
		} else if (isset($_POST) && $this->input->post('verify_am_request') == 1 && $this->session->userdata('logged-in-am') != '') {
			$variable_array = array(
				'logged_in_user_details' => $this->session->userdata('logged-in-am'),
				'role' => 'am',
				'type' => 'fs_team'
			);
		} else if (isset($_POST) && $this->input->post('verify_tech_support_request') == 1 && $this->session->userdata('logged-in-tech-support') != '') {
			$variable_array = array(
				'logged_in_user_details' => $this->session->userdata('logged-in-tech-support'),
				'role' => 'tech support team',
				'type' => 'fs_team'
			);
		} else {
			// redirect($this->config->item('my_base_url').'login');
			echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			return false;
		}
		return $variable_array;
	}

	function check_admin_login() {
		if(!$this->session->userdata('logged-in-admin')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function check_inputqc_login() {
		if(!$this->session->userdata('logged-in-inputqc')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function check_analyst_login() {
		if(!$this->session->userdata('logged-in-analyst') && !$this->session->userdata('logged-in-insuffanalyst')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function check_specialist_login() {
		if(!$this->session->userdata('logged-in-specialist')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function check_outputqc_login() {
		if(!$this->session->userdata('logged-in-outputqc')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function check_finance_login() {
		if(!$this->session->userdata('logged-in-finance')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function check_csm_login() {
		if(!$this->session->userdata('logged-in-csm')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function check_am_login() {
		if(!$this->session->userdata('logged-in-am')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function get_escalatory_cases_notifications() {
		$variable_array = $this->get_logged_in_details();
		echo json_encode(array('status'=>'1','all_escalatory_cases'=>$this->escalatory_Notifications_FS_Team_Model->get_escalatory_cases_notifications($variable_array),'verification_status_list'=>json_decode(file_get_contents(base_url().'assets/custom-js/json/analyst-verify-status.json'),true)));
	}
}