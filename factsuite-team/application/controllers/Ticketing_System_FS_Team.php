<?php

class Ticketing_System_FS_Team extends CI_Controller {
	
	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url');
	  	$this->load->model('ticketing_System_FS_Team_Model');
	  	$this->load->model('teamModel');
	  	$this->load->model('clientModel');
	  	$this->load->model('emailModel');
	  	$this->load->model('utilModel');
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

	function check_tech_support_login() {
		if(!$this->session->userdata('logged-in-tech-support')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function raise_ticket_admin() {
		$this->check_admin_login();
		$admin_data['userData'] = $this->session->userdata('logged-in-admin');
		$this->load->view('admin/admin-common/header',$admin_data);
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/ticketing-system/ticketing-system-common');
		$this->load->view('admin/ticketing-system/tickets');
		$this->load->view('admin/admin-common/footer');
	}

	function tickets_assigned_to_me_admin() {
		$this->check_admin_login();
		$admin_data['userData'] = $this->session->userdata('logged-in-admin');
		$this->load->view('admin/admin-common/header',$admin_data);
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/ticketing-system/ticketing-system-common');
		$this->load->view('admin/ticketing-system/tickets-assigned-to-me');
		$this->load->view('admin/admin-common/footer');
	}

	function all_tickets_admin() {
		$this->check_admin_login();
		$admin_data['userData'] = $this->session->userdata('logged-in-admin');
		$this->load->view('admin/admin-common/header',$admin_data);
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/ticketing-system/ticketing-system-common');
		$this->load->view('admin/ticketing-system/all-tickets');
		$this->load->view('admin/admin-common/footer');
	}

	function raise_ticket_input_qc() {
		$this->check_inputqc_login();
		$this->load->view('inputqc/inputqc-common/header');
		$this->load->view('inputqc/inputqc-common/sidebar');
		$this->load->view('inputqc/ticketing-system/ticketing-system-common');
		$this->load->view('inputqc/ticketing-system/tickets');
		$this->load->view('inputqc/inputqc-common/footer');
	}

	function tickets_assigned_to_me_inputqc() {
		$this->check_inputqc_login();
		$this->load->view('inputqc/inputqc-common/header');
		$this->load->view('inputqc/inputqc-common/sidebar');
		$this->load->view('inputqc/ticketing-system/ticketing-system-common');
		$this->load->view('inputqc/ticketing-system/tickets-assigned-to-me');
		$this->load->view('inputqc/inputqc-common/footer');
	}

	function raise_ticket_analyst() {
		$this->check_analyst_login();
		$this->load->view('analyst/analyst-common/header');
		$this->load->view('analyst/analyst-common/sidebar');
		$this->load->view('analyst/ticketing-system/ticketing-system-common');
		$this->load->view('analyst/ticketing-system/tickets');
		$this->load->view('analyst/analyst-common/footer');
	}

	function tickets_assigned_to_me_analyst() {
		$this->check_analyst_login();
		$this->load->view('analyst/analyst-common/header');
		$this->load->view('analyst/analyst-common/sidebar');
		$this->load->view('analyst/ticketing-system/ticketing-system-common');
		$this->load->view('analyst/ticketing-system/tickets-assigned-to-me');
		$this->load->view('analyst/analyst-common/footer');
	}

	function raise_ticket_specialist() {
		$this->check_specialist_login();
		$this->load->view('specialist/specialist-common/header');
		$this->load->view('specialist/specialist-common/sidebar');
		$this->load->view('specialist/ticketing-system/ticketing-system-common');
		$this->load->view('specialist/ticketing-system/tickets');
		$this->load->view('specialist/specialist-common/footer');
	}

	function tickets_assigned_to_me_specialist() {
		$this->check_specialist_login();
		$this->load->view('specialist/specialist-common/header');
		$this->load->view('specialist/specialist-common/sidebar');
		$this->load->view('specialist/ticketing-system/ticketing-system-common');
		$this->load->view('specialist/ticketing-system/tickets-assigned-to-me');
		$this->load->view('specialist/specialist-common/footer');
	}

	function raise_ticket_outputqc() {
		$this->check_outputqc_login();
		$this->load->view('outputqc/outputqc-common/header');
		$this->load->view('outputqc/outputqc-common/sidebar');
		$this->load->view('outputqc/ticketing-system/ticketing-system-common');
		$this->load->view('outputqc/ticketing-system/tickets');
		$this->load->view('outputqc/outputqc-common/footer');
	}

	function tickets_assigned_to_me_outputqc() {
		$this->check_outputqc_login();
		$this->load->view('outputqc/outputqc-common/header');
		$this->load->view('outputqc/outputqc-common/sidebar');
		$this->load->view('outputqc/ticketing-system/ticketing-system-common');
		$this->load->view('outputqc/ticketing-system/tickets-assigned-to-me');
		$this->load->view('outputqc/outputqc-common/footer');
	}

	function raise_ticket_finance() {
		$this->check_finance_login();
		$this->load->view('finance/finance-common/header');
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('finance/ticketing-system/ticketing-system-common');
		$this->load->view('finance/ticketing-system/tickets');
		$this->load->view('finance/finance-common/footer');
	}

	function tickets_assigned_to_me_finance() {
		$this->check_finance_login();
		$this->load->view('finance/finance-common/header');
		$this->load->view('finance/finance-common/sidebar');
		$this->load->view('finance/ticketing-system/ticketing-system-common');
		$this->load->view('finance/ticketing-system/tickets-assigned-to-me');
		$this->load->view('finance/finance-common/footer');
	}

	function raise_ticket_csm() {
		$this->check_csm_login();
		$this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar');
		$this->load->view('csm/ticketing-system/ticketing-system-common');
		$this->load->view('csm/ticketing-system/tickets');
		$this->load->view('csm/csm-common/footer');
	}

	function tickets_assigned_to_me_csm() {
		$this->check_csm_login();
		$this->load->view('csm/csm-common/header');
		$this->load->view('csm/csm-common/sidebar');
		$this->load->view('csm/ticketing-system/ticketing-system-common');
		$this->load->view('csm/ticketing-system/tickets-assigned-to-me');
		$this->load->view('csm/csm-common/footer');
	}

	function raise_ticket_am() {
		$this->check_am_login();
		$this->load->view('am/am-common/header');
		$this->load->view('am/am-common/sidebar');
		$this->load->view('am/ticketing-system/ticketing-system-common');
		$this->load->view('am/ticketing-system/tickets');
		$this->load->view('am/am-common/footer');
	}

	function tickets_assigned_to_me_am() {
		$this->check_am_login();
		$this->load->view('am/am-common/header');
		$this->load->view('am/am-common/sidebar');
		$this->load->view('am/ticketing-system/ticketing-system-common');
		$this->load->view('am/ticketing-system/tickets-assigned-to-me');
		$this->load->view('am/am-common/footer');
	}

	function raise_ticket_tech_support() {
		$this->check_tech_support_login();
		$this->load->view('tech-support-team/common/header');
		$this->load->view('tech-support-team/common/sidebar');
		$this->load->view('tech-support-team/ticketing-system/ticketing-system-common');
		$this->load->view('tech-support-team/ticketing-system/tickets');
		$this->load->view('tech-support-team/common/footer');
	}

	function tickets_assigned_to_me_tech_support() {
		$this->check_tech_support_login();
		$this->load->view('tech-support-team/common/header');
		$this->load->view('tech-support-team/common/sidebar');
		$this->load->view('tech-support-team/ticketing-system/ticketing-system-common');
		$this->load->view('tech-support-team/ticketing-system/tickets-assigned-to-me');
		$this->load->view('tech-support-team/common/footer');
	}

	function get_ticket_notifications() {
		$variable_array = $this->get_logged_in_details();
		echo json_encode(array('status'=>'1','all_ticket_notifications'=>$this->ticketing_System_FS_Team_Model->get_ticket_notifications($variable_array)));
	}

	function get_roles_list() {
		$variable_array = $this->get_logged_in_details();
		echo json_encode(array('status'=>'1','all_roles'=>$this->ticketing_System_FS_Team_Model->get_logged_in_details($variable_array)));
	}

	function get_roles_person_list() {
		$variable_array = $this->get_logged_in_details();
		$variable_array['role_type'] = $this->input->post('role_type');
		echo json_encode(array('status'=>'1','all_persons'=>$this->ticketing_System_FS_Team_Model->get_roles_person_list($variable_array)));
	}

	function raise_new_ticket() {
		$variable_array = $this->get_logged_in_details();
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

		echo json_encode(array('status'=>'1','raise_ticket_details'=>$this->ticketing_System_FS_Team_Model->raise_new_ticket($variable_array,$store_ticket_files)));
	}

	function get_all_tickets() {
		$variable_array = $this->get_logged_in_details();
		$variable_array_1 = array(
  			'clock_for' => 0
	  	);
	  	$time_format_details = $this->utilModel->get_time_format_details($variable_array_1);
	  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
	  	$selected_datetime_format = '';
	  	foreach ($get_all_date_time_format as $key => $value) {
	  		$val = (array)$value;
	  		if($val['id'] == $time_format_details['date_formate']) {
	  			$selected_datetime_format = $val;
	  			break;
	  		}
	  	}
		echo json_encode(array('status'=>'1','all_tickets'=>$this->ticketing_System_FS_Team_Model->get_all_tickets($variable_array),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json'),'all_team_members'=>$this->teamModel->get_team_list(),'selected_datetime_format'=>$selected_datetime_format));
	}
	
	function get_all_raised_tickets() {
		$variable_array = $this->get_logged_in_details();
		$variable_array_1 = array(
  			'clock_for' => 0
	  	);
	  	$time_format_details = $this->utilModel->get_time_format_details($variable_array_1);
	  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
	  	$selected_datetime_format = '';
	  	foreach ($get_all_date_time_format as $key => $value) {
	  		$val = (array)$value;
	  		if($val['id'] == $time_format_details['date_formate']) {
	  			$selected_datetime_format = $val;
	  			break;
	  		}
	  	}
		echo json_encode(array('status'=>'1','all_tickets'=>$this->ticketing_System_FS_Team_Model->get_all_raised_tickets($variable_array),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json'),'all_team_members'=>$this->teamModel->get_team_list(),'selected_datetime_format'=>$selected_datetime_format));
	}

	function get_all_assigned_tickets() {
		$variable_array = $this->get_logged_in_details();
		$variable_array_1 = array(
  			'clock_for' => 0
	  	);
	  	$time_format_details = $this->utilModel->get_time_format_details($variable_array_1);
	  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
	  	$selected_datetime_format = '';
	  	foreach ($get_all_date_time_format as $key => $value) {
	  		$val = (array)$value;
	  		if($val['id'] == $time_format_details['date_formate']) {
	  			$selected_datetime_format = $val;
	  			break;
	  		}
	  	}
		echo json_encode(array('status'=>'1','all_tickets'=>$this->ticketing_System_FS_Team_Model->get_all_assigned_tickets($variable_array),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json'),'all_team_members'=>$this->teamModel->get_team_list(),'selected_datetime_format'=>$selected_datetime_format));
	}

	function get_ticket_details() {
		$variable_array = $this->get_logged_in_details();
		$variable_array['ticket_id'] = $this->input->post('ticket_id');

		echo json_encode(array('status'=>'1','ticket_details'=>$this->ticketing_System_FS_Team_Model->get_ticket_details($variable_array),'get_ticket_priority_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-priority-list.json'),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
	}

	function add_new_ticket_comment() {
		$variable_array = $this->get_logged_in_details();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->ticketing_System_FS_Team_Model->add_new_ticket_comment($variable_array)));
	}

	function get_ticket_single_comment() {
		$variable_array = $this->get_logged_in_details();

		$variable_array_1 = array(
  			'clock_for' => 0
	  	);
	  	$time_format_details = $this->utilModel->get_time_format_details($variable_array_1);
	  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
	  	$selected_datetime_format = '';
	  	foreach ($get_all_date_time_format as $key => $value) {
	  		$val = (array)$value;
	  		if($val['id'] == $time_format_details['date_formate']) {
	  			$selected_datetime_format = $val;
	  			break;
	  		}
	  	}

		echo json_encode(array('status'=>'1','ticket_details'=>$this->ticketing_System_FS_Team_Model->get_ticket_single_comment($variable_array),'all_team_members'=>$this->teamModel->get_team_list(),'selected_datetime_format'=>$selected_datetime_format));
	}

	function get_single_ticket_all_comments() {
		$variable_array = $this->get_logged_in_details();

		$variable_array_1 = array(
  			'clock_for' => 0
	  	);
	  	$time_format_details = $this->utilModel->get_time_format_details($variable_array_1);
	  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
	  	$selected_datetime_format = '';
	  	foreach ($get_all_date_time_format as $key => $value) {
	  		$val = (array)$value;
	  		if($val['id'] == $time_format_details['date_formate']) {
	  			$selected_datetime_format = $val;
	  			break;
	  		}
	  	}
		echo json_encode(array('status'=>'1','ticket_details'=>$this->ticketing_System_FS_Team_Model->get_single_ticket_all_comments($variable_array),'all_team_members'=>$this->teamModel->get_team_list(),'selected_datetime_format'=>$selected_datetime_format));
	}

	function update_ticket_status() {
		$variable_array = $this->get_logged_in_details();
		echo json_encode(array('status'=>'1','ticket_details'=>$this->ticketing_System_FS_Team_Model->update_ticket_status($variable_array),'get_ticket_status_list'=>file_get_contents(base_url().'assets/custom-js/json/ticket-status-list.json')));
	}
}