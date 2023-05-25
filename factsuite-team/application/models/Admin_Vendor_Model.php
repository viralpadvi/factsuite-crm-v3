<?php

class Admin_Vendor_Model extends CI_Model {
	
	function get_vendor_skills() {
		return $this->db->where('component_status','1')->get('components')->result_array();
	}

	function get_vendor_manager_list() {
		return $this->db->where('is_Active','1')->get('team_employee')->result_array();
	}


	function get_vendor_logs(){
		 if ($this->input->post('case_id')) { 
		$this->db->where('assign_case_to_vendor.case_id',$this->input->post('case_id'));
		 }
		 if ($this->input->post('component_id')) {
		 	$this->db->where('assign_case_to_vendor.component_id',$this->input->post('component_id'));
		 } 
		return $this->db->select('vendor.vendor_name,assign_case_to_vendor.*')->from('assign_case_to_vendor')->join('vendor','assign_case_to_vendor.vendor_id = vendor.vendor_id','left')->order_by('vendor_id','DESC')->get()->result_array();
	}


	function get_all_vendor_logs(){
		return $this->db->select('vendor.vendor_name,assign_case_to_vendor.*')->from('assign_case_to_vendor')->join('vendor','assign_case_to_vendor.vendor_id = vendor.vendor_id','left')->join('candidate','assign_case_to_vendor.case_id = candidate.candidate_id','left')->join('team_employee','assign_case_to_vendor.assignment_team_id = team_employee.team_id','left')->order_by('vendor_id','DESC')->get()->result_array();
	}

	function insert_vendor() {
		if ($this->input->post('vendor_id') != null && $this->input->post('vendor_id') != '' && $this->input->post('vendor_id') != '0') {
			if ($this->input->post('case_id')) { 
				$this->db->where('case_id',$this->input->post('case_id'));
			}
			
			if ($this->input->post('component_id')) {
			 	$this->db->where('component_id',$this->input->post('component_id'));
			}

			if ($this->input->post('index')) {
				$this->db->where('index_no',$this->input->post('index'));
			}

			$assign_case_to_vendor = $this->db->order_by('assign_id','DESC')->get('assign_case_to_vendor')->row_array();

			$add_vendor_log_status = 0;
			if ($assign_case_to_vendor == '') {
				$add_vendor_log_status = 1;
			} else {
				if ($assign_case_to_vendor['vendor_id'] != $this->input->post('vendor_id')) {
					$add_vendor_log_status = 1;
				}
			}

			if ($add_vendor_log_status == 1) {
				$user = $this->session->userdata('logged-in-analyst');
				if($this->session->userdata('logged-in-analyst')) {
					$user = $this->session->userdata('logged-in-analyst');
				} else if($this->session->userdata('logged-in-insuffanalyst')) {
					$user = $this->session->userdata('logged-in-insuffanalyst');
				} else if($this->session->userdata('logged-in-outputqc')) {
					$user = $this->session->userdata('logged-in-outputqc');
				} else if($this->session->userdata('logged-in-specialist')) {
					$user = $this->session->userdata('logged-in-specialist');	
				} else if($this->session->userdata('logged-in-am')) {
					$user = $this->session->userdata('logged-in-am');	
				} 
				$index=0;
				if ($this->input->post('index')) {
					$index=$this->input->post('index');
				}
				$data = array(
					'case_id' => $this->input->post('candidate_id'),
					'component_id' => $this->input->post('component_id'),
					'component_name' => $this->input->post('component_name'),
					'vendor_id' => $this->input->post('vendor_id'),
					'index_no' =>$index ,
					'assignment_team_id' => $user['team_id'],
					'assignment_role' => $user['role'],
					// 'created_date' =>date('Y-m-d'),
				);
				$this->db->insert('assign_case_to_vendor',$data);
			}
		}
	} 

	function get_latest_selected_vendor_for_component_form() {
		if ($this->input->post('case_id')) { 
			$this->db->where('T1.case_id',$this->input->post('case_id'));
		}
		
		if ($this->input->post('component_id')) {
		 	$this->db->where('T1.component_id',$this->input->post('component_id'));
		}

		if ($this->input->post('index')) {
			$this->db->where('T1.index_no',$this->input->post('index'));
		}

		return $this->db->select('T2.vendor_name,T1.*')->join('vendor AS T2','T1.vendor_id = T2.vendor_id','left')->order_by('T1.assign_id','DESC')->get('assign_case_to_vendor AS T1')->row_array();
	}

	function update_assigned_vendor_case_completion_date() {
		if ($this->input->post('case_id')) { 
			$this->db->where('case_id',$this->input->post('case_id'));
		}
		
		if ($this->input->post('component_id')) {
		 	$this->db->where('component_id',$this->input->post('component_id'));
		}

		if ($this->input->post('index')) {
			$this->db->where('index_no',$this->input->post('index'));
		}

		if ($this->input->post('assign_id')) {
		 	$this->db->where('assign_id',$this->input->post('assign_id'));
		}

		$assign_case_to_vendor = $this->db->get('assign_case_to_vendor')->row_array();
		if ($assign_case_to_vendor != '') {
			$log_data = array(
				'case_completed_by_vendor_date' => $this->input->post('case_completion_date'),
				'case_completed_by_vendor_date_added_date' => date('Y-m-d H:i:s')
			);
			if ($this->db->where('assign_id',$this->input->post('assign_id'))->update('assign_case_to_vendor',$log_data)) {
				return array('status'=>'1','message'=>'Successfully Updated.');
			}
			return array('status'=>'0','message'=>'Something went wrong while updating the data.');
		}
		return array('status'=>'2','message'=>'No Data Found.');
	}

	function get_selected_vendor_manager_details($team_id) {
		return $this->db->select('team_employee_email AS email_id, contact_no AS mobile_number')->from('team_employee')->where('team_id',$team_id)->get()->row_array();
	}

	function check_new_vendor_spoc_email_id_exists() {
		return $this->db->select('count(*) AS count')->from('vendor')->where('vendor_spoc_email_id',$this->input->post('vendor_spoc_email_id'))->get()->row_array();
	}

	function add_new_vendor($vendor_docs) {
		$password = random_string('alnum', 8);

		$userdata = array(
			'vendor_name'=>$this->input->post('vendor_name'),
			'vendor_address_line_1'=>$this->input->post('vendor_address_line_1'),
			'vendor_address_line_2'=>$this->input->post('vendor_address_line_2'),
			'vendor_city'=>$this->input->post('vendor_city'),
			'vendor_zip_code'=>$this->input->post('vendor_zip_code'),
			'vendor_state'=>$this->input->post('vendor_state'),
			'vendor_website_url'=>$this->input->post('vendor_website'),
			'vendor_monthly_quota'=>$this->input->post('vendor_monthly_quota'),
			'vendor_aggrement_start_date'=>$this->input->post('vendor_aggrement_start_date'),
			'vendor_aggrement_end_date'=>$this->input->post('vendor_aggrement_end_date'),
			'vendor_skill_tat'=>$this->input->post('vendor_skill_tat'),
			'vendor_manager_id'=>$this->input->post('vendor_manager_name'),
			'vendor_spoc_name'=>$this->input->post('vendor_spoc_name'),
			'vendor_spoc_email_id'=>strtolower($this->input->post('vendor_spoc_email_id')),
			'vendor_spoc_mobile_number'=>$this->input->post('vendor_spoc_mobile_number'),
			'vendor_skills'=>$this->input->post('vendor_skills'),
			'vendor_password'=>MD5($password),
		);

		if ($vendor_docs != 'no-file') {
			$userdata['vendor_docs'] = implode(',',$vendor_docs);
		}

		if ($this->db->insert('vendor',$userdata)) {
			$vendor_id = $this->db->insert_id();

			// $this->send_credentials_to_vendor($vendor_id,$password);
			$admin_info = $this->session->userdata('logged-in-admin');

			$log_data = array(
				'vendor_id'=>$vendor_id,
				'vendor_name'=>$this->input->post('vendor_name'),
				'vendor_address_line_1'=>$this->input->post('vendor_address_line_1'),
				'vendor_address_line_2'=>$this->input->post('vendor_address_line_2'),
				'vendor_city'=>$this->input->post('vendor_city'),
				'vendor_zip_code'=>$this->input->post('vendor_zip_code'),
				'vendor_state'=>$this->input->post('vendor_state'),
				'vendor_website_url'=>$this->input->post('vendor_website'),
				'vendor_monthly_quota'=>$this->input->post('vendor_monthly_quota'),
				'vendor_aggrement_start_date'=>$this->input->post('vendor_aggrement_start_date'),
				'vendor_aggrement_end_date'=>$this->input->post('vendor_aggrement_end_date'),
				'vendor_skill_tat'=>$this->input->post('vendor_skill_tat'),
				'vendor_manager_id'=>$this->input->post('vendor_manager_id'),
				'vendor_spoc_name'=>$this->input->post('vendor_spoc_name'),
				'vendor_spoc_email_id'=>strtolower($this->input->post('vendor_spoc_email_id')),
				'vendor_spoc_mobile_number'=>$this->input->post('vendor_spoc_mobile_number'),
				'vendor_skills'=>$this->input->post('vendor_skills'),
				'vendor_password'=>MD5($password),
				'vendor_added_updated_by_admin_id'=>$admin_info['team_id']
			);

			if ($vendor_docs != 'no-file') {
				$log_data['vendor_docs'] = implode(',',$vendor_docs);
			} else {
				$log_data['vendor_docs'] = 'no-file';
			}
			$this->db->insert('vendor_log',$log_data);
			return array('status'=>'1','message'=>'Successfully Inserted.');
		} else {
			return array('status'=>'0','message'=>'Insert Failed.');
		}
	}

	function get_vendor_list($vendor_status) {
		return $this->db->select('*')->from('vendor')->join('team_employee','vendor.vendor_manager_id = team_employee.team_id','Left')->where('vendor_status',$vendor_status)->order_by('vendor_id','DESC')->get()->result_array();
	}

	function get_all_vendor_list() {
		return $this->db->select('*')->from('vendor')->join('team_employee','vendor.vendor_manager_id = team_employee.team_id','Left')->order_by('vendor_id','DESC')->get()->result_array();
	}

	function change_vendor_status() {
		$userdata = array(
			'vendor_status'=>$this->input->post('vendor_status'),
		);

		if ($this->db->where('vendor_id',$this->input->post('vendor_id'))->update('vendor',$userdata)) {
			
			$get_vendor_data = $this->db->where('vendor_id',$this->input->post('vendor_id'))->get('vendor')->row_array();
			
			$vendor_status_log = '3';
			if ($this->input->post('main_category_status') == 0) {
				$vendor_status_log = '4';
			}

			$admin_info = $this->session->userdata('logged-in-admin');
			$userdata_logger = array(
				'vendor_id'=>$this->input->post('vendor_id'),
				'vendor_name'=>$get_vendor_data['vendor_name'],
				'vendor_address_line_1'=>$get_vendor_data['vendor_address_line_1'],
				'vendor_address_line_2'=>$get_vendor_data['vendor_address_line_2'],
				'vendor_city'=>$get_vendor_data['vendor_city'],
				'vendor_zip_code'=>$get_vendor_data['vendor_zip_code'],
				'vendor_state'=>$get_vendor_data['vendor_state'],
				'vendor_website_url'=>$get_vendor_data['vendor_website_url'],
				'vendor_monthly_quota'=>$get_vendor_data['vendor_monthly_quota'],
				'vendor_aggrement_start_date'=>$get_vendor_data['vendor_aggrement_start_date'],
				'vendor_aggrement_end_date'=>$get_vendor_data['vendor_aggrement_end_date'],
				'vendor_docs'=>$get_vendor_data['vendor_docs'],
				'vendor_skill_tat'=>$get_vendor_data['vendor_skill_tat'],
				'vendor_manager_id'=>$get_vendor_data['vendor_manager_id'],
				'vendor_spoc_name'=>$get_vendor_data['vendor_spoc_name'],
				'vendor_spoc_email_id'=>$get_vendor_data['vendor_spoc_email_id'],
				'vendor_spoc_mobile_number'=>$get_vendor_data['vendor_spoc_mobile_number'],
				'vendor_skills'=>$get_vendor_data['vendor_skills'],
				'vendor_password'=>$get_vendor_data['vendor_password'],
				'vendor_status'=>$vendor_status_log,
				'vendor_added_updated_by_admin_id'=>$admin_info['team_id'],
			);
			$this->db->insert('vendor_log',$userdata_logger);

			return array('status'=>'1','message'=>'Status successfully updated.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while updating the status.');
		}
	}

	function get_single_vendor_details() {
		$data['vendor_details'] = $this->get_single_vendor_details_by_id($this->input->post('vendor_id'));
		$data['skill_list'] = $this->get_vendor_skills();
		$data['manager_list'] = $this->get_vendor_manager_list();
		$data['single_manager_details'] = $this->get_selected_vendor_manager_details($data['vendor_details']['vendor_manager_id']);
		$data['state_list'] = file_get_contents(base_url().'assets/custom-js/json/states.json');

		return array('status'=>'1','data'=>$data);
	}

	function get_single_vendor_details_by_id($vendor_id) {
		return $this->db->where('vendor_id',$vendor_id)->get('vendor')->row_array();
	}

	function remove_vendor_doc() {
		$vendor_id = $this->input->post('vendor_id');
		$date = $this->get_vendor_docs($vendor_id);

		$new_vendor_doc = array();
		foreach(explode(',', $date['vendor_docs']) as $key => $img){
			if($img != $this->input->post('vendor_doc_name')) {
				$new_vendor_doc[] = $img;
			}
		}

		$userdata = array(
			'vendor_docs'=>implode(',', $new_vendor_doc)
		);
		if ($this->db->where('vendor_id',$vendor_id)->update('vendor',$userdata)) {
			$admin_info = $this->session->userdata('logged-in-admin');
			
			$get_vendor_data = $this->db->where('vendor_id',$vendor_id)->get('vendor')->row_array();
			
			$userdata_logger = array(
				'vendor_id'=>$this->input->post('vendor_id'),
				'vendor_name'=>$get_vendor_data['vendor_name'],
				'vendor_address_line_1'=>$get_vendor_data['vendor_address_line_1'],
				'vendor_address_line_2'=>$get_vendor_data['vendor_address_line_2'],
				'vendor_city'=>$get_vendor_data['vendor_city'],
				'vendor_zip_code'=>$get_vendor_data['vendor_zip_code'],
				'vendor_state'=>$get_vendor_data['vendor_state'],
				'vendor_website_url'=>$get_vendor_data['vendor_website_url'],
				'vendor_monthly_quota'=>$get_vendor_data['vendor_monthly_quota'],
				'vendor_aggrement_start_date'=>$get_vendor_data['vendor_aggrement_start_date'],
				'vendor_aggrement_end_date'=>$get_vendor_data['vendor_aggrement_end_date'],
				'vendor_docs'=>$get_vendor_data['vendor_docs'],
				'vendor_skill_tat'=>$get_vendor_data['vendor_skill_tat'],
				'vendor_manager_id'=>$get_vendor_data['vendor_manager_id'],
				'vendor_spoc_name'=>$get_vendor_data['vendor_spoc_name'],
				'vendor_spoc_email_id'=>$get_vendor_data['vendor_spoc_email_id'],
				'vendor_spoc_mobile_number'=>$get_vendor_data['vendor_spoc_mobile_number'],
				'vendor_skills'=>$get_vendor_data['vendor_skills'],
				'vendor_password'=>$get_vendor_data['vendor_password'],
				'vendor_status'=>'2',
				'vendor_added_updated_by_admin_id'=>$admin_info['team_id'],
			);
			$this->db->insert('vendor_log',$userdata_logger);
			return array('status'=>'1','message'=>'Successfully Removed.');
		} else {
			return array('status'=>'0','message'=>'Failed Image remove.');
		}
	}

	function get_vendor_docs($vendor_id) {
		return $this->db->select('vendor_docs')->from('vendor')->where('vendor_id',$vendor_id)->get()->row_array();
	}

	function check_update_vendor_spoc_email_id_exists() {
		return $this->db->select('count(*) AS count')->from('vendor')->where('vendor_spoc_email_id',$this->input->post('vendor_spoc_email_id'))->where_not_in('vendor_id',array($this->input->post('vendor_id')))->get()->row_array();
	}

	function edit_vendor_details($vendor_docs) {
		$vendor_id = $this->input->post('vendor_id');
		$userdata = array(
			'vendor_name'=>$this->input->post('vendor_name'),
			'vendor_address_line_1'=>$this->input->post('vendor_address_line_1'),
			'vendor_address_line_2'=>$this->input->post('vendor_address_line_2'),
			'vendor_city'=>$this->input->post('vendor_city'),
			'vendor_zip_code'=>$this->input->post('vendor_zip_code'),
			'vendor_state'=>$this->input->post('vendor_state'),
			'vendor_website_url'=>$this->input->post('vendor_website'),
			'vendor_monthly_quota'=>$this->input->post('vendor_monthly_quota'),
			'vendor_aggrement_start_date'=>$this->input->post('vendor_aggrement_start_date'),
			'vendor_aggrement_end_date'=>$this->input->post('vendor_aggrement_end_date'),
			'vendor_skill_tat'=>$this->input->post('vendor_skill_tat'),
			'vendor_manager_id'=>$this->input->post('vendor_manager_name'),
			'vendor_spoc_name'=>$this->input->post('vendor_spoc_name'),
			'vendor_spoc_email_id'=>strtolower($this->input->post('vendor_spoc_email_id')),
			'vendor_spoc_mobile_number'=>$this->input->post('vendor_spoc_mobile_number'),
			'vendor_skills'=>$this->input->post('vendor_skills'),
		);

		if ($vendor_docs != 'no-file') {
			$vendor_docs = implode(',',$vendor_docs);
			$get_db_vendor_docs = $this->get_vendor_docs($vendor_id);
			if ($get_db_vendor_docs['vendor_docs'] != '') {
				$get_vendor_docs = explode(',',$get_db_vendor_docs['vendor_docs']);
				array_push($get_vendor_docs, $vendor_docs);
				$userdata['vendor_docs'] = implode(',',$get_vendor_docs);
			} else {
				$userdata['vendor_docs'] = $vendor_docs;
			}
		}

		$password = '';
		$vendor_main_change_count = 0;
		$get_vendor_data = $this->get_single_vendor_details_by_id($vendor_id);
		if ($get_vendor_data['vendor_spoc_email_id'] != strtolower($this->input->post('vendor_spoc_email_id'))) {
			$password = random_string('alnum', 8);
			$userdata['vendor_password'] = MD5($password);
			$vendor_main_change_count++;
		}

		if ($this->db->where('vendor_id',$vendor_id)->update('vendor',$userdata)) {
			$admin_info = $this->session->userdata('logged-in-admin');

			if ($vendor_main_change_count != 0) {
				// $this->send_credentials_to_vendor($vendor_id,$password);
			}
			$userdata_logger = array(
				'vendor_id'=>$this->input->post('vendor_id'),
				'vendor_name'=>$get_vendor_data['vendor_name'],
				'vendor_address_line_1'=>$get_vendor_data['vendor_address_line_1'],
				'vendor_address_line_2'=>$get_vendor_data['vendor_address_line_2'],
				'vendor_city'=>$get_vendor_data['vendor_city'],
				'vendor_zip_code'=>$get_vendor_data['vendor_zip_code'],
				'vendor_state'=>$get_vendor_data['vendor_state'],
				'vendor_website_url'=>$get_vendor_data['vendor_website_url'],
				'vendor_monthly_quota'=>$get_vendor_data['vendor_monthly_quota'],
				'vendor_aggrement_start_date'=>$get_vendor_data['vendor_aggrement_start_date'],
				'vendor_aggrement_end_date'=>$get_vendor_data['vendor_aggrement_end_date'],
				'vendor_skill_tat'=>$get_vendor_data['vendor_skill_tat'],
				'vendor_docs'=>$get_vendor_data['vendor_docs'],
				'vendor_manager_id'=>$get_vendor_data['vendor_manager_id'],
				'vendor_spoc_name'=>$get_vendor_data['vendor_spoc_name'],
				'vendor_spoc_email_id'=>$get_vendor_data['vendor_spoc_email_id'],
				'vendor_spoc_mobile_number'=>$get_vendor_data['vendor_spoc_mobile_number'],
				'vendor_skills'=>$get_vendor_data['vendor_skills'],
				'vendor_password'=>$get_vendor_data['vendor_password'],
				'vendor_status'=>'2',
				'vendor_added_updated_by_admin_id'=>$admin_info['team_id'],
			);
			$this->db->insert('vendor_log',$userdata_logger);
			return array('status'=>'1','message'=>'Successfully Inserted.');
		} else {
			return array('status'=>'0','message'=>'Insert Failed.');
		}
	}

	function send_credentials_to_vendor($vendor_id,$password) {
		$get_vendor_data = $this->get_single_vendor_details_by_id($vendor_id);

		$vendor_email_id = $get_vendor_data['vendor_spoc_email_id'];
		$vendor_email_subject = 'Credentials';

		$vendor_email_message = '<html><body>';
		$vendor_email_message .= 'Hello : '.$this->input->post('vendor_spoc_name').'<br>';
		$vendor_email_message .= 'Your account has been created with factsuite team as vendor : <br>';
		$vendor_email_message .= 'Login using below credentials : <br>';
		$vendor_email_message .= 'Email ID : '.$vendor_email_id.'<br>';
		$vendor_email_message .= 'Password : '.$password.'<br>';
		$vendor_email_message .= 'Thank You,<br>';
		$vendor_email_message .= 'Team FactSuite';
		$vendor_email_message .= '</html></body>';

		$send_email_to_user = $this->emailModel->send_mail($vendor_email_id,$vendor_email_subject,$vendor_email_message);
	}
}