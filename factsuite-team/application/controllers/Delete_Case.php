<?php
class Delete_Case extends CI_Controller {
	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url');
	  	$this->load->model('delete_Case_Model');
	}

	function index() {
		echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
		return false;
	}

	function get_logged_in_details() {
		if (isset($_POST) && $this->input->post('verify_admin_request') == 1) {
			if($this->session->userdata('logged-in-admin') != '') {
				$variable_array = array(
					'logged_in_user_details' => $this->session->userdata('logged-in-admin'),
					'role' => 'admin',
					'type' => 'fs_team'
				);
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
				return false;
			}
		} else if (isset($_POST) && $this->input->post('verify_csm_request') == 1) {
			if ($this->session->userdata('logged-in-csm') != '') {
				$variable_array = array(
					'logged_in_user_details' => $this->session->userdata('logged-in-csm'),
					'role' => 'csm',
					'type' => 'fs_team'
				);
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
				return false;
			}
		} else {
			// redirect($this->config->item('my_base_url').'login');
			echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			return false;
		}
		return $variable_array;
	}

	function detete_case_permanently() {
		$variable_array = $this->get_logged_in_details();
		if ($variable_array['type'] == 'fs_team') {
			if (in_array(strtolower($variable_array['role']), $this->config->item('delete_case_fs_team_role_authorization'))) {
				if(MD5($this->input->post('password')) == $variable_array['logged_in_user_details']['team_employee_password']) {
					$variable_array['candidate_id'] = $this->input->post('candidate_id');
					echo json_encode($this->delete_Case_Model->delete_case_details_v2($variable_array));
				} else {
					echo json_encode(array('status'=>'2','message'=>'Incorrect Password. Please enter the correct password.'));
				}
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
		} else {
			echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
		}
	}
}