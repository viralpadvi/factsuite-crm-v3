<?php
/**
 * 
 */
class CandidateModel extends CI_Model {

	function get_candidate_list($candidate_id) {
		return $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
	}

	function get_candidate_pincode_validation(){
		return $this->db->where('pincode',$pincode)->get('allindiapincode')->num_rows();
	}

	// function update_candidate_info($candidate_aadhar,$candidate_pan,$candidate_proof,$candidate_bank=''){ 
	function update_candidate_info() {
		$timepicker = date("h:i:A", strtotime($this->input->post('timepicker')));
		$timepicker2 = date("h:i:A", strtotime($this->input->post('timepicker2')));

		$user = $this->session->userdata('logged-in-candidate');
		$candidate_data = array(
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'father_name'=>$this->input->post('father_name'),
			'gender'=>$this->input->post('gender'),
			'date_of_birth'=>$this->input->post('birthdate'),
			'nationality'=>$this->input->post('nationality'),
			'title'=>$this->input->post('title'),
			'marital_status'=>$this->input->post('marital'), 
			'contact_start_time'=>$timepicker, 
			'contact_end_time'=>$timepicker2, 
			'candidate_state'=>$this->input->post('state'), 
			'candidate_city'=>$this->input->post('city'), 
			'candidate_pincode'=>$this->input->post('pincode'), 
			'candidate_address'=>$this->input->post('address'), 
			'candidate_flat_no'=>$this->input->post('house'), 
			'candidate_street'=>$this->input->post('street'), 
			'candidate_area'=>$this->input->post('area'), 
			'week'=>$this->input->post('week'),
			'communications'=>$this->input->post('communications'),
			'personal_information_form_filled_by_candidate_status' => 1
			/*'employee_company'=>$this->input->post('employee_company'), 
			'education'=>$this->input->post('education'), 
			'university'=>$this->input->post('university'), 
			'social_media'=>$this->input->post('social_media'),  */
		);

		/*if (!in_array('no-file', $candidate_aadhar)) {
			$candidate_data['aaddhar_doc'] = implode(',', $candidate_aadhar);
		}if (!in_array('no-file', $candidate_pan)) {
			$candidate_data['pancard_doc'] = implode(',', $candidate_pan);
		}if (!in_array('no-file', $candidate_proof)) {
			$candidate_data['idproof_doc'] = implode(',', $candidate_proof);
		}if (!in_array('no-file', $candidate_bank)) {
			$candidate_data['bankpassbook_doc'] = implode(',', $candidate_bank);
		}*/
		$this->db->where('candidate_id',$user['candidate_id']);
		if ($this->db->update('candidate',$candidate_data)) {
			$global = $this->db->where('candidate_id',$user['candidate_id'])->get('globaldatabase')->num_rows();
			if ($global > 0) {
				$global_data = array(
				 	'candidate_name'=>$this->input->post('first_name'),
				 	'father_name'=>$this->input->post('father_name'),
				 	'dob'=>$this->input->post('birthdate'),
				);
				$this->db->where('candidate_id',$user['candidate_id'])->update('globaldatabase',$global_data);
			}
			$drug = $this->db->where('candidate_id',$user['candidate_id'])->get('drugtest');
			if ($drug->num_rows() > 0) {
				$drug_data = $drug->row_array();
				$candidate_name1 = json_decode($drug_data['candidate_name'],true);
				$drug_count = count($candidate_name1);
				if ($drug_count > 0) {
					$candidate_name = array();
					$father_name = array();
					$dob = array();
					for ($i = 0; $i < $drug_count; $i++) { 
					 	$row['candidate_name'] = $this->input->post('first_name');
					 	$row1['father_name'] = $this->input->post('father_name');
					 	$row2['dob'] = $this->input->post('birthdate');
					 	array_push($candidate_name, $row);
					 	array_push($father_name, $row1);
					 	array_push($dob, $row2);
					}
					
					$drug_data_array = array(
					 	'candidate_name'=>json_encode($candidate_name),
					 	'father__name'=>json_encode($father_name),
					 	'dob'=>json_encode($dob),
					);

					$this->db->where('candidate_id',$user['candidate_id'])->update('drugtest',$drug_data_array); 
				}
			}
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}


	function update_candidate_address($candidate_rental,$candidate_ration,$candidate_gov='') {
		$user = $this->session->userdata('logged-in-candidate');
		$get_client_details = $this->db->where('client_id',$user['client_id'])->get('tbl_client')->row_array();
		if ($this->input->post('permanent_address_id')) {
			$this->db->where('permanent_address_id',$this->input->post('permanent_address_id'));
			$data = $this->db->get('permanent_address')->row_array();
			$candidate_status = $data['status'];
			$analyst = $data['analyst_status'];
		}
		$status = isset($candidate_status)?$candidate_status:1;
		$an = isset($analyst)?$analyst:0;
		if ($status =='3' || $an =='3') {
			$status = 1;
			$an = 0;
		}
		$permenent_data = array(
			'candidate_id'=>$user['candidate_id'],
			'flat_no'=>$this->input->post('permenent_house'),
			'street'=>$this->input->post('permenent_street'),
			'area'=>$this->input->post('permenent_area'),
			'city'=>$this->input->post('permenent_city'),
			'pin_code'=>$this->input->post('permenent_pincode'),
			'state'=>$this->input->post('state'),
			'country'=>$this->input->post('country'),
			'nearest_landmark'=>$this->input->post('permenent_land_mark'),
			/*'duration_of_stay_start'=>$this->input->post('permenent_start_date'),
			'duration_of_stay_end'=>$this->input->post('permenent_end_date'),*/
			'duration_of_stay_start'=>$this->input->post('start_year').'-'.$this->input->post('start_month').'-00',
			'duration_of_stay_end'=>$this->input->post('end_year').'-'.$this->input->post('end_month').'-00',
			'is_present'=>$this->input->post('permenent_present'),
			'contact_person_name'=>$this->input->post('permenent_name'),
			'contact_person_relationship'=>$this->input->post('permenent_relationship'),
			'contact_person_mobile_number'=> $this->input->post('permenent_contact_no'),
			'code'=> $this->input->post('code'),
			'iverify_or_pv_status' => $get_client_details['iverify_or_pv_status'],
			'status'=>$status,
			'analyst_status'=>$an,
		);

		if (!in_array('no-file', $candidate_rental)) {
			$permenent_data['rental_agreement'] = implode(',', $candidate_rental);
		} if (!in_array('no-file', $candidate_ration)) {
			$permenent_data['ration_card'] = implode(',', $candidate_ration);
		} if (!in_array('no-file', $candidate_gov)) {
			$permenent_data['gov_utility_bill'] = implode(',', $candidate_gov);
		}
		
		/*return $permenent_data

		if ($this->db->insert('permanent_address',$permenent_data) ) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}*/

		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('permanent_address')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('permanent_address_id')) {
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('permanent_address',$permenent_data);

			$insert_id = $this->input->post('permanent_address_id');
		} else {
			$result = $this->db->insert('permanent_address',$permenent_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
			// if ( $this->db->insert('present_address',$present_data)) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
 
	}


	function update_candidate_employment($appointment_letter,$experience_relieving_letter,$last_month_pay_slip,$bank_statement_resigngation_acceptance) {
		$user = $this->session->userdata('logged-in-candidate');

		$status = array();
		$analyst_status = array(); 
		if ($this->input->post('current_emp_id')) { 
		$data = $this->db->where('current_emp_id',$this->input->post('current_emp_id'))->get('current_employment')->row_array();
		$candidate_status = $data['status'];
		$analyst = $data['analyst_status']; 
		}

		$status = isset($candidate_status)?$candidate_status:1;
		$an = isset($analyst)?$analyst:0;
		if ($status =='3' || $an =='3') {
			$status = 1;
			$an = 0;
		}
 
		$employment_data = array(
			'candidate_id'=>$user['candidate_id'],
			'desigination'=>$this->input->post('designation'), 
			'department'=>$this->input->post('department'), 
			'employee_id'=>$this->input->post('employee_id'), 
			'company_name'=>$this->input->post('company_name'), 
			'address'=>$this->input->post('address'), 
			'annual_ctc'=>$this->input->post('annual_ctc'), 
			'reason_for_leaving'=>$this->input->post('reasion'), 
			'joining_date'=>$this->input->post('joining_date'), 
			'relieving_date'=>$this->input->post('relieving_date'), 
			'reporting_manager_name'=>$this->input->post('manager_name'), 
			'reporting_manager_desigination'=>$this->input->post('manager_designation'), 
			'reporting_manager_contact_number'=>$this->input->post('manager_contact'), 
			'code'=>$this->input->post('code'), 
			'hr_name'=>$this->input->post('hr_name'),
			'hr_contact_number'=>$this->input->post('hr_contact'),
			'hr_code'=>$this->input->post('hr_code'),
			'reporting_manager_email_id'=>$this->input->post('reporting_manager_email_id'),
			'hr_email_id'=>$this->input->post('hr_email_id'),
			'company_url'=>$this->input->post('company_url'),
			'status'=>$status,
			'analyst_status'=>$an,
		);


		if (!in_array('no-file', $appointment_letter)) {
			$employment_data['appointment_letter'] = implode(',', $appointment_letter);
		}

		if (!in_array('no-file', $experience_relieving_letter)) {
			$employment_data['experience_relieving_letter'] = implode(',', $experience_relieving_letter);
		}

		if (!in_array('no-file', $last_month_pay_slip)) {
			$employment_data['last_month_pay_slip'] = implode(',', $last_month_pay_slip);
		}

		if (!in_array('no-file', $bank_statement_resigngation_acceptance)) {
			$employment_data['bank_statement_resigngation_acceptance'] = implode(',', $bank_statement_resigngation_acceptance);
		}

		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('current_employment')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('current_emp_id')) {
			// $this->db->where('current_emp_id',$this->input->post('current_emp_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('current_employment',$employment_data);

			$insert_id = $this->input->post('current_emp_id');
		} else {
			$result = $this->db->insert('current_employment',$employment_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
			// if ($this->db->insert('current_employment',$employment_data)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


	function update_candidate_previous_employment($appointment_letter,$experience_relieving_letter,$last_month_pay_slip,$bank_statement_resigngation_acceptance) {
		$user = $this->session->userdata('logged-in-candidate');
		$designation = json_decode($this->input->post('designation'),true);
		$status = array();
		$analyst_status = array(); 
		if ($this->input->post('previous_emp_id')) { 
		$data = $this->db->where('previous_emp_id',$this->input->post('previous_emp_id'))->get('previous_employment')->row_array();
		$candidate_status = explode(',', $data['status']);
		$analyst = explode(',', $data['analyst_status']);

		$insuff_status = explode(',',$data['insuff_status']);
		$output_status = explode(',',$data['output_status']);
		$insuff_team_role = explode(',',$data['insuff_team_role']);
		$insuff_team_id = explode(',',$data['insuff_team_id']);
		$assigned_role = explode(',',$data['assigned_role']);
		$assigned_team_id = explode(',',$data['assigned_team_id']);
		}

		$insuff_status_array = array();
		$output_status_array = array();
		$insuff_team_role_array = array();
		$insuff_team_id_array = array();
		$assigned_role_array = array();
		$assigned_team_id_array = array();
		foreach ($designation as $key => $value) { 
			$analyst1 = isset($analyst[$key])?$analyst[$key]:array(0);
		$candidate_status1 = isset($candidate_status[$key])?$candidate_status[$key]:array(1);
		$insuff_status1 = isset($insuff_status[$key])?$insuff_status[$key]:array(0);
		$output_status1 = isset($output_status[$key])?$output_status[$key]:array(0);
		$insuff_team_role1 = isset($insuff_team_role[$key])?$insuff_team_role[$key]:array(0);
		$insuff_team_id1 = isset($insuff_team_id[$key])?$insuff_team_id[$key]:array(0);
		$assigned_role1 = isset($assigned_role[$key])?$assigned_role[$key]:array(0);
		$assigned_team_id1 = isset($assigned_team_id[$key])?$assigned_team_id[$key]:array(0);
			$anlyst = $analyst1[0]; 
			if ($analyst1[0] == '3') {
				$anlyst = 0; 
			}
			$can_sts = $candidate_status1[0];
			if ($candidate_status1[0] == '3') {
				$can_sts = 1; 
			}
			$analyst_status[$key] = $anlyst; 
			$status[$key] = $can_sts; 
			$insuff_status_array[$key] = $insuff_status1[0];	 
			$output_status_array[$key] = $output_status1[0];	 
			$insuff_team_role_array[$key] = $insuff_team_role1[0];	 
			$insuff_team_id_array[$key] = $insuff_team_id1[0];	 
			$assigned_role_array[$key] = isset($assigned_role1[0])?$assigned_role1[0]:0;	 
			$assigned_team_id_array[$key] = $assigned_team_id1[0];	 
		} 
		$employment = $this->db->where('previous_emp_id',$this->input->post('previous_emp_id'))->get('previous_employment')->row_array();  

		$appointment = explode(',', $this->input->post('appointment'));
		$db_appointment = json_decode( isset($employment['appointment_letter'])?$employment['appointment_letter']:'no-file' ,true);
		$j = 0;
		$appointment_letter_array = array();
		foreach ($appointment as $key => $value) {
			if ($value == '1') {
				array_push($appointment_letter_array, $appointment_letter[$j]);
				$j++;
			} else { 
				array_push($appointment_letter_array, isset($db_appointment[$key])?$db_appointment[$key]:array('no-file'));
			}
		}
		$last_month = explode(',', $this->input->post('last_month'));
		$db_experience = json_decode( isset($employment['last_month_pay_slip'])?$employment['last_month_pay_slip']:'no-file' ,true);
		$j = 0;
		$last_month_pay_slip_array = array();
		foreach ($last_month as $key => $value) {
			if ($value == '1') {
				array_push($last_month_pay_slip_array, $last_month_pay_slip[$j]);
				$j++;
			} else {
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($last_month_pay_slip_array, isset($db_experience[$key])?$db_experience[$key]:array('no-file'));
			}
		}

		$bank_statement = explode(',', $this->input->post('bank_statement'));
		$db_last_month = json_decode(isset($employment['bank_statement_resigngation_acceptance'])?$employment['bank_statement_resigngation_acceptance']:'-',true);
		$j = 0;
		$bank_statement_resigngation_acceptance_array = array();
		foreach ($bank_statement as $key => $value) {
			if ($value == '1') {
				array_push($bank_statement_resigngation_acceptance_array, isset($bank_statement_resigngation_acceptance[$j])?$bank_statement_resigngation_acceptance[$j]:array('no-file'));
				$j++;
			} else {
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($bank_statement_resigngation_acceptance_array, isset($db_last_month[$key])?$db_last_month[$key]:array('no-file'));
			}
		}

		$experience = explode(',', $this->input->post('experience'));
		$db_bank_statement = json_decode( isset($employment['experience_relieving_letter'])?$employment['experience_relieving_letter']:'no-file' ,true);
		$j = 0;
		$experience_relieving_letter_array = array();
		foreach ($experience as $key => $value) {
			if ($value == '1') {
				array_push($experience_relieving_letter_array, $experience_relieving_letter[$j]);
				$j++;
			} else {
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($experience_relieving_letter_array, isset($db_bank_statement[$key])?$db_bank_statement[$key]:array('no-file'));
			}
		}

		$employment_data = array(
			'candidate_id'=>$user['candidate_id'],
			'desigination'=>$this->input->post('designation'), 
			'department'=>$this->input->post('department'), 
			'employee_id'=>$this->input->post('employee_id'), 
			'company_name'=>$this->input->post('company_name'), 
			'address'=>$this->input->post('address'), 
			'annual_ctc'=>$this->input->post('annual_ctc'), 
			'reason_for_leaving'=>$this->input->post('reasion'), 
			'joining_date'=>$this->input->post('joining_date'), 
			'relieving_date'=>$this->input->post('relieving_date'), 
			'reporting_manager_name'=>$this->input->post('manager_name'), 
			'reporting_manager_desigination'=>$this->input->post('manager_designation'), 
			'reporting_manager_contact_number'=>$this->input->post('manager_contact'), 
			'code'=>$this->input->post('code'), 
			'hr_name'=>$this->input->post('hr_name'),
			'hr_contact_number'=>$this->input->post('hr_contact'),
			'hr_code'=>$this->input->post('hr_code'),
			'reporting_manager_email_id'=>$this->input->post('reporting_manager_email_id'),
			'hr_email_id'=>$this->input->post('hr_email_id'),
			'company_url'=>$this->input->post('company_url'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $insuff_status_array),
			'output_status'=>implode(',', $output_status_array),
			'insuff_team_role'=>implode(',', $insuff_team_role_array),
			'insuff_team_id'=>implode(',', $insuff_team_id_array), 
			'assigned_role'=>implode(',', $assigned_role_array), 
			'assigned_team_id'=>implode(',', $assigned_team_id_array), 
		);





		if (!in_array('no-file', $appointment_letter_array)) {
			$employment_data['appointment_letter'] = json_encode($appointment_letter_array);
		}if (!in_array('no-file', $experience_relieving_letter_array)) {
			$employment_data['experience_relieving_letter'] = json_encode($experience_relieving_letter_array);
		}if (!in_array('no-file', $last_month_pay_slip_array)) {
			$employment_data['last_month_pay_slip'] = json_encode($last_month_pay_slip_array);
		}if (!in_array('no-file', $bank_statement_resigngation_acceptance_array)) {
			$employment_data['bank_statement_resigngation_acceptance'] = json_encode($bank_statement_resigngation_acceptance_array);
		}


		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('previous_employment')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('previous_emp_id')) {
			// $this->db->where('previous_emp_id',$this->input->post('previous_emp_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('previous_employment',$employment_data);

			$insert_id = $this->input->post('previous_emp_id');
		}else{
			$result = $this->db->insert('previous_employment',$employment_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
		// if ($this->db->insert('previous_employment',$employment_data)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}


	}


	function update_candidate_reference(){ 

		$user = $this->session->userdata('logged-in-candidate');

			$name = explode(',',$this->input->post('name'));
		$status = array();
		$analyst_status = array(); 
		if ($this->input->post('reference_id')) { 
		$data = $this->db->where('reference_id',$this->input->post('reference_id'))->get('reference')->row_array();
		$candidate_status = explode(',', $data['status']);
		$analyst = explode(',', $data['analyst_status']);

		$insuff_status = explode(',',$data['insuff_status']);
		$output_status = explode(',',$data['output_status']);
		$insuff_team_role = explode(',',$data['insuff_team_role']);
		$insuff_team_id = explode(',',$data['insuff_team_id']);
		$assigned_role = explode(',',$data['assigned_role']);
		$assigned_team_id = explode(',',$data['assigned_team_id']);
		}

		$insuff_status_array = array();
		$output_status_array = array();
		$insuff_team_role_array = array();
		$insuff_team_id_array = array();
		$assigned_role_array = array();
		$assigned_team_id_array = array();
		foreach ($name as $key => $value) { 
			$analyst1 = isset($analyst[$key])?$analyst[$key]:array(0);
		$candidate_status1 = isset($candidate_status[$key])?$candidate_status[$key]:array(1);
		$insuff_status1 = isset($insuff_status[$key])?$insuff_status[$key]:array(0);
		$output_status1 = isset($output_status[$key])?$output_status[$key]:array(0);
		$insuff_team_role1 = isset($insuff_team_role[$key])?$insuff_team_role[$key]:array(0);
		$insuff_team_id1 = isset($insuff_team_id[$key])?$insuff_team_id[$key]:array(0);
		$assigned_role1 = isset($assigned_role[$key])?$assigned_role[$key]:array(0);
		$assigned_team_id1 = isset($assigned_team_id[$key])?$assigned_team_id[$key]:array(0);
			$anlyst = $analyst1[0]; 
			if ($analyst1[0] == '3') {
				$anlyst = 0; 
			}
			$can_sts = $candidate_status1[0];
			if ($candidate_status1[0] == '3') {
				$can_sts = 1; 
			}
			$analyst_status[$key] = $anlyst; 
			$status[$key] = $can_sts; 
			$insuff_status_array[$key] = $insuff_status1[0];	 
			$output_status_array[$key] = $output_status1[0];	 
			$insuff_team_role_array[$key] = $insuff_team_role1[0];	 
			$insuff_team_id_array[$key] = $insuff_team_id1[0];	 
			$assigned_role_array[$key] = $assigned_role1[0];	 
			$assigned_team_id_array[$key] = $assigned_team_id1[0];	 
		} 

		 
		$reference_data = array(
			'candidate_id'=>$user['candidate_id'],
			'name'=>$this->input->post('name'),
			'company_name'=>$this->input->post('company_name'),
			'designation'=>$this->input->post('designation'),
			'contact_number'=>$this->input->post('contact'),
			'code'=>$this->input->post('code'),
			'email_id'=>$this->input->post('email'),
			'years_of_association'=>$this->input->post('association'),
			'contact_start_time'=>$this->input->post('start_date'),
			'contact_end_time'=>$this->input->post('end_date'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $insuff_status_array),
			'output_status'=>implode(',', $output_status_array),
			'insuff_team_role'=>implode(',', $insuff_team_role_array),
			'insuff_team_id'=>implode(',', $insuff_team_id_array), 
			'assigned_role'=>implode(',', $assigned_role_array), 
			'assigned_team_id'=>implode(',', $assigned_team_id_array), 
		);


	$result = '';
	$table = $this->db->where('candidate_id',$user['candidate_id'])->get('reference')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('reference_id')) {
			// $this->db->where('reference_id',$this->input->post('reference_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('reference',$reference_data);

			$insert_id = $this->input->post('reference_id');
		}else{
			$result = $this->db->insert('reference',$reference_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {

		// if ($this->db->insert('reference',$reference_data)) {
		$reference_log_data = array(
			'reference_id'=>$insert_id,
			'candidate_id'=>$user['candidate_id'],
			'name'=>$this->input->post('name'),
			'company_name'=>$this->input->post('company_name'),
			'designation'=>$this->input->post('designation'),
			'contact_number'=>$this->input->post('contact'),
			'code'=>$this->input->post('code'),
			'email_id'=>$this->input->post('email'),
			'years_of_association'=>$this->input->post('association'),
			'contact_start_time'=>$this->input->post('start_date'),
			'contact_end_time'=>$this->input->post('end_date'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $insuff_status_array),
			'output_status'=>implode(',', $output_status_array),
			'insuff_team_role'=>implode(',', $insuff_team_role_array),
			'insuff_team_id'=>implode(',', $insuff_team_id_array), 
			'assigned_role'=>implode(',', $assigned_role_array), 
			'assigned_team_id'=>implode(',', $assigned_team_id_array), 
		);	
		$this->db->insert('reference_log',$reference_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


	function update_candidate_landload_reference(){

		$user = $this->session->userdata('logged-in-candidate');

		$name = json_decode($this->input->post('tenant_name'),true);
		$status = array();
		$analyst_status = array(); 
		if ($this->input->post('landload_id')) { 
		$data = $this->db->where('landload_id',$this->input->post('landload_id'))->get('landload_reference')->row_array();
		$candidate_status = explode(',', $data['status']);
		$analyst = explode(',', $data['analyst_status']);

		$insuff_status = explode(',',$data['insuff_status']);
		$output_status = explode(',',$data['output_status']);
		$insuff_team_role = explode(',',$data['insuff_team_role']);
		$insuff_team_id = explode(',',$data['insuff_team_id']);
		$assigned_role = explode(',',$data['assigned_role']);
		$assigned_team_id = explode(',',$data['assigned_team_id']);
		}

		$insuff_status_array = array();
		$output_status_array = array();
		$insuff_team_role_array = array();
		$insuff_team_id_array = array();
		$assigned_role_array = array();
		$assigned_team_id_array = array();
		foreach ($name as $key => $value) { 
			 
		$insuff_status1 = isset($insuff_status[$key])?$insuff_status[$key]:array(0);
		$output_status1 = isset($output_status[$key])?$output_status[$key]:array(0);
		$insuff_team_role1 = isset($insuff_team_role[$key])?$insuff_team_role[$key]:array(0);
		$insuff_team_id1 = isset($insuff_team_id[$key])?$insuff_team_id[$key]:array(0);
		$assigned_role1 = isset($assigned_role[$key])?$assigned_role[$key]:array(0);
		$assigned_team_id1 = isset($assigned_team_id[$key])?$assigned_team_id[$key]:array(0);
		$analyst1 = isset($analyst[$key])?$analyst[$key]:array(0)[0];
		$candidate_status1 = isset($candidate_status[$key])?$candidate_status[$key]:array(1)[0];
		if ($analyst1 =='3' || $candidate_status1 == '3') {
			$analyst1 = 0;
			$candidate_status1 = 1;
		}
			$analyst_status[$key] = $analyst1; 
			$status[$key] = $candidate_status1; 
			$insuff_status_array[$key] = $insuff_status1[0];	 
			$output_status_array[$key] = $output_status1[0];	 
			$insuff_team_role_array[$key] = $insuff_team_role1[0];	 
			$insuff_team_id_array[$key] = $insuff_team_id1[0];	 
			$assigned_role_array[$key] = $assigned_role1[0];	 
			$assigned_team_id_array[$key] = $assigned_team_id1[0];	 
		} 

		 
		$reference_data = array(
			'candidate_id'=>$user['candidate_id'],
			'tenant_name'=>$this->input->post('tenant_name'), 
			'case_contact_no'=>$this->input->post('case_contact_no'), 
			'landlord_name'=>$this->input->post('landlord_name'), 
			/*'tenancy_period'=>$this->input->post('tenancy_period'), 
			'tenancy_period_comment'=>$this->input->post('tenancy_period_comment'), 
			'monthly_rental_amount'=>$this->input->post('monthly_rental_amount'), 
			'monthly_rental_amount_comment'=>$this->input->post('monthly_rental_amount_comment'), 
			'occupants_property'=>$this->input->post('occupants_property'), 
			'occupants_property_comment'=>$this->input->post('occupants_property_comment'), 
			'tenant_consistently_pay_rent_on_time'=>$this->input->post('tenant_consistently_pay_rent_on_time'), 
			'tenant_consistently_pay_rent_on_time_comment'=>$this->input->post('tenant_consistently_pay_rent_on_time_comment'), 
			'utility_bills_paid_on_time'=>$this->input->post('utility_bills_paid_on_time'), 
			'utility_bills_paid_on_time_comment'=>$this->input->post('utility_bills_paid_on_time_comment'), 
			'rental_property'=>$this->input->post('rental_property'), 
			'rental_property_comment'=>$this->input->post('rental_property_comment'), 
			'maintenance_issues'=>$this->input->post('maintenance_issues'), 
			'maintenance_issues_comment'=>$this->input->post('maintenance_issues_comment'), 
			'tenant_leave'=>$this->input->post('tenant_leave'), 
			'tenant_leave_comment'=>$this->input->post('tenant_leave_comment'), 
			'tenant_rent_again'=>$this->input->post('tenant_rent_again'), 
			'tenant_rent_again_comment'=>$this->input->post('tenant_rent_again_comment'), 
			'any_pets'=>$this->input->post('any_pets'), 
			'any_pets_comment'=>$this->input->post('any_pets_comment'), 
			'food_preference'=>$this->input->post('food_preference'), 
			'food_preference_comment'=>$this->input->post('food_preference_comment'), 
			'spare_time'=>$this->input->post('spare_time'), 
			'spare_time_comment'=>$this->input->post('spare_time_comment'), 
			'overall_character'=>$this->input->post('overall_character'), 
			'overall_character_comment'=>$this->input->post('overall_character_comment'),  
			'complaints_from_neighbors'=>$this->input->post('complaints_from_neighbors'),  
			'complaints_from_neighbors_comment'=>$this->input->post('complaints_from_neighbors_comment'),*/  


			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $insuff_status_array),
			'output_status'=>implode(',', $output_status_array),
			'insuff_team_role'=>implode(',', $insuff_team_role_array),
			'insuff_team_id'=>implode(',', $insuff_team_id_array), 
			'assigned_role'=>implode(',', $assigned_role_array), 
			'assigned_team_id'=>implode(',', $assigned_team_id_array), 
		);



	$result = '';
	$table = $this->db->where('candidate_id',$user['candidate_id'])->get('landload_reference')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('landload_id')) {
			// $this->db->where('landload_id',$this->input->post('landload_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('landload_reference',$reference_data);

			$insert_id = $this->input->post('landload_id');
		}else{
			$result = $this->db->insert('landload_reference',$reference_data);
			$insert_id = $this->db->insert_id();
		} 

		$reference_data['landload_id'] = $insert_id;

		if ($result == true) {
 
		$this->db->insert('landload_reference_log',$reference_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


	function update_candidate_social_media(){
			$user = $this->session->userdata('logged-in-candidate');
			if ($this->input->post('social_id')) {
			$this->db->where('social_id',$this->input->post('social_id'));
			$data = $this->db->get('social_media')->row_array();
			$status = $data['status'];
			$analyst_status = $data['analyst_status'];
			}

			$status1 = isset($status)?$status:1;
			$analyst_status1 = isset($analyst_status)?$analyst_status:0;
			if ($analyst_status1 =='3' || $status1 == '3') {
				$analyst_status1 = 0;
				$status1 = 1;
			}
		$social_media = array(
			'candidate_id'=>$user['candidate_id'],
			'candidate_name'=>$this->input->post('name'), 
			'dob'=>$this->input->post('date_of_birth'),
			'employee_company_info'=>$this->input->post('employee_company'), 
			'education_info'=>$this->input->post('education'), 
			'university_info'=>$this->input->post('university'), 
			'social_media_info'=>$this->input->post('social_media'), 
			'status'=>$status1,
			'analyst_status'=>$analyst_status1,
		); 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('social_media')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('social_id')) {
			// $this->db->where('social_id',$this->input->post('social_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('social_media',$social_media);

			$insert_id = $this->input->post('social_id');
		}else{
			$result = $this->db->insert('social_media',$social_media);
			$insert_id = $this->db->insert_id();
		}
		$social_media['social_id'] = $insert_id;

		if ($result == true) {
 
		$this->db->insert('social_media_log',$social_media);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


	function update_candidate_court_record($candidate_address){ 
		$user = $this->session->userdata('logged-in-candidate');
			$address = json_decode($this->input->post('address'),true);
		/*$status = array();
		$analyst_status = array();
		for ($i=0; $i < count($address); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
		}*/ 
		$status = array();
		$analyst_status = array(); 
		if ($this->input->post('court_records_id')) { 
		$data = $this->db->where('court_records_id',$this->input->post('court_records_id'))->get('court_records')->row_array();
		$candidate_status = explode(',', $data['status']);
		$analyst = explode(',', $data['analyst_status']);

		$insuff_status = explode(',',$data['insuff_status']);
		$output_status = explode(',',$data['output_status']);
		$insuff_team_role = explode(',',$data['insuff_team_role']);
		$insuff_team_id = explode(',',$data['insuff_team_id']);
		$assigned_role = explode(',',$data['assigned_role']);
		$assigned_team_id = explode(',',$data['assigned_team_id']);
		}

		$insuff_status_array = array();
		$output_status_array = array();
		$insuff_team_role_array = array();
		$insuff_team_id_array = array();
		$assigned_role_array = array();
		$assigned_team_id_array = array();
		foreach ($address as $key => $value) { 
			$analyst1 = isset($analyst[$key])?$analyst[$key]:array(0);
		$candidate_status1 = isset($candidate_status[$key])?$candidate_status[$key]:array(1);
		$insuff_status1 = isset($insuff_status[$key])?$insuff_status[$key]:array(0);
		$output_status1 = isset($output_status[$key])?$output_status[$key]:array(0);
		$insuff_team_role1 = isset($insuff_team_role[$key])?$insuff_team_role[$key]:array(0);
		$insuff_team_id1 = isset($insuff_team_id[$key])?$insuff_team_id[$key]:array(0);
		$assigned_role1 = isset($assigned_role[$key])?$assigned_role[$key]:array(0);
		$assigned_team_id1 = isset($assigned_team_id[$key])?$assigned_team_id[$key]:array(0);
		$anlyst = isset($analyst1[0])?$analyst1[0]:0; 
			if ($anlyst == '3') {
				$anlyst = 0; 
			}
			$can_sts = isset($candidate_status1[0])?$candidate_status1[0]:1;
			if ($can_sts == '3') {
				$can_sts = 1; 
			}
			$analyst_status[$key] = $anlyst; 
			$status[$key] = $can_sts; 

			$insuff_status_array[$key] = isset($insuff_status1[0])?$insuff_status1[0]:0;	 
			$output_status_array[$key] = isset($output_status1[0])?$output_status1[0]:0;	 
			$insuff_team_role_array[$key] = isset($insuff_team_role1[0])?$insuff_team_role1[0]:0;	 
			$insuff_team_id_array[$key] = isset($insuff_team_id1[0])?$insuff_team_id1[0]:0;	 
			$assigned_role_array[$key] = isset($assigned_role1[0])?$assigned_role1[0]:0;	 
			$assigned_team_id_array[$key] = isset($assigned_team_id1[0])?$assigned_team_id1[0]:0;	 
		} 

		$court_data = array(
			'candidate_id'=>$user['candidate_id'],
			'address'=>$this->input->post('address'),
			'pin_code'=>$this->input->post('pincode'),
			'city'=>$this->input->post('city'),
			'state'=>$this->input->post('state'),
			'country'=>$this->input->post('country'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $insuff_status_array),
			'output_status'=>implode(',', $output_status_array),
			'insuff_team_role'=>implode(',', $insuff_team_role_array),
			'insuff_team_id'=>implode(',', $insuff_team_id_array), 
			'assigned_role'=>implode(',', $assigned_role_array), 
			'assigned_team_id'=>implode(',', $assigned_team_id_array), 
		);

		if (!in_array('no-file', $candidate_address)) {
			$court_data['address_proof_doc'] = json_encode($candidate_address);
		}

	$result = '';
	$table = $this->db->where('candidate_id',$user['candidate_id'])->get('court_records')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('court_records_id')) {
			// $this->db->where('court_records_id',$this->input->post('court_records_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('court_records',$court_data);

			$insert_id = $this->input->post('court_records_id');
		}else{
			$result = $this->db->insert('court_records',$court_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


	function update_candidate_criminal_check(){ 
		 
		$user = $this->session->userdata('logged-in-candidate');
		$address = json_decode($this->input->post('address'),true);
		 
		$status = array();
		$analyst_status = array(); 
		if ($this->input->post('criminal_checks_id')) { 
		$data = $this->db->where('criminal_check_id',$this->input->post('criminal_checks_id'))->get('criminal_checks')->row_array();
		$candidate_status = explode(',', $data['status']);
		$analyst = explode(',', $data['analyst_status']);

		$insuff_status = explode(',',$data['insuff_status']);
		$output_status = explode(',',$data['output_status']);
		$insuff_team_role = explode(',',$data['insuff_team_role']);
		$insuff_team_id = explode(',',$data['insuff_team_id']);
		$assigned_role = explode(',',$data['assigned_role']);
		$assigned_team_id = explode(',',$data['assigned_team_id']);
		}

		$start_month = explode(',', $this->input->post('start_month'));
		// $start_year = $this->input->post('start_year');
		$end_month = explode(',', $this->input->post('end_month'));
		$end_year = explode(',', $this->input->post('end_year'));
		$start_year_month = array();
		$end_year_month = array();
		foreach (explode(',', $this->input->post('start_year')) as $key => $val) {
			array_push($start_year_month,array('duration_of_stay_start'=>$val.'-'.$start_month[$key].'-00')); 
			array_push($end_year_month,array('duration_of_stay_end'=>$end_year[$key].'-'.$end_month[$key].'-00')); 
		}

		$insuff_status_array = array();
		$output_status_array = array();
		$insuff_team_role_array = array();
		$insuff_team_id_array = array();
		$assigned_role_array = array();
		$assigned_team_id_array = array();
		foreach ($address as $key => $value) { 
			$analyst1 = isset($analyst[$key])?$analyst[$key]:array(0);
		$candidate_status1 = isset($candidate_status[$key])?$candidate_status[$key]:array(1);
		$insuff_status1 = isset($insuff_status[$key])?$insuff_status[$key]:array(0);
		$output_status1 = isset($output_status[$key])?$output_status[$key]:array(0);
		$insuff_team_role1 = isset($insuff_team_role[$key])?$insuff_team_role[$key]:array(0);
		$insuff_team_id1 = isset($insuff_team_id[$key])?$insuff_team_id[$key]:array(0);
		$assigned_role1 = isset($assigned_role[$key])?$assigned_role[$key]:array(0);
		$assigned_team_id1 = isset($assigned_team_id[$key])?$assigned_team_id[$key]:array(0);

			$anlyst = isset($analyst1[0])?$analyst1[0]:0; 
			if ($anlyst == '3') {
				$anlyst = 0; 
			}
			$can_sts = isset($candidate_status1[0])?$candidate_status1[0]:1;
			if ($can_sts == '3') {
				$can_sts = 1; 
			}
			$analyst_status[$key] = $anlyst; 
			$status[$key] = $can_sts; 

			$insuff_status_array[$key] = isset($insuff_status1[0])?$insuff_status1[0]:0;	 
			$output_status_array[$key] = isset($output_status1[0])?$output_status1[0]:0;	 
			$insuff_team_role_array[$key] = isset($insuff_team_role1[0])?$insuff_team_role1[0]:0;	 
			$insuff_team_id_array[$key] = isset($insuff_team_id1[0])?$insuff_team_id1[0]:0;	 
			$assigned_role_array[$key] = isset($assigned_role1[0])?$assigned_role1[0]:0;	 
			$assigned_team_id_array[$key] = isset($assigned_team_id1[0])?$assigned_team_id1[0]:0;	 
		} 

		 
		$criminal_data = array(
			'candidate_id'=>$user['candidate_id'],
			'address'=>$this->input->post('address'),
			'pin_code'=>$this->input->post('pincode'),
			'city'=>$this->input->post('city'),
			'state'=>$this->input->post('state'),
			'country'=>$this->input->post('country'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $insuff_status_array),
			'output_status'=>implode(',', $output_status_array),
			'insuff_team_role'=>implode(',', $insuff_team_role_array),
			'insuff_team_id'=>implode(',', $insuff_team_id_array), 
			'assigned_role'=>implode(',', $assigned_role_array), 
			'assigned_team_id'=>implode(',', $assigned_team_id_array),
			'duration_of_stay_start'=>json_encode($start_year_month),
			'duration_of_stay_end'=>json_encode($end_year_month)
		);
 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('criminal_checks')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('criminal_checks_id')) {
			// $this->db->where('criminal_check_id',$this->input->post('criminal_checks_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('criminal_checks',$criminal_data);

			$insert_id = $this->input->post('criminal_check_id');
		}else{
			$result = $this->db->insert('criminal_checks',$criminal_data);
			$insert_id = $this->db->insert_id();
		}
 
		if ($result ==true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


	function update_candidate_civil_check(){

		$user = $this->session->userdata('logged-in-candidate');
		$address = json_decode($this->input->post('address'),true);
		 
		$status = array();
		$analyst_status = array(); 
		if ($this->input->post('civil_check_id')) { 
		$data = $this->db->where('civil_check_id',$this->input->post('civil_check_id'))->get('civil_check')->row_array();
		$candidate_status = explode(',', $data['status']);
		$analyst = explode(',', $data['analyst_status']);

		$insuff_status = explode(',',$data['insuff_status']);
		$output_status = explode(',',$data['output_status']);
		$insuff_team_role = explode(',',$data['insuff_team_role']);
		$insuff_team_id = explode(',',$data['insuff_team_id']);
		$assigned_role = explode(',',$data['assigned_role']);
		$assigned_team_id = explode(',',$data['assigned_team_id']);
		}

		$insuff_status_array = array();
		$output_status_array = array();
		$insuff_team_role_array = array();
		$insuff_team_id_array = array();
		$assigned_role_array = array();
		$assigned_team_id_array = array();
		foreach ($address as $key => $value) { 
			$analyst1 = isset($analyst[$key])?$analyst[$key]:array(0);
		$candidate_status1 = isset($candidate_status[$key])?$candidate_status[$key]:array(1);
		$insuff_status1 = isset($insuff_status[$key])?$insuff_status[$key]:array(0);
		$output_status1 = isset($output_status[$key])?$output_status[$key]:array(0);
		$insuff_team_role1 = isset($insuff_team_role[$key])?$insuff_team_role[$key]:array(0);
		$insuff_team_id1 = isset($insuff_team_id[$key])?$insuff_team_id[$key]:array(0);
		$assigned_role1 = isset($assigned_role[$key])?$assigned_role[$key]:array(0);
		$assigned_team_id1 = isset($assigned_team_id[$key])?$assigned_team_id[$key]:array(0);

			$anlyst = isset($analyst1[0])?$analyst1[0]:0; 
			if ($anlyst == '3') {
				$anlyst = 0; 
			}
			$can_sts = isset($candidate_status1[0])?$candidate_status1[0]:1;
			if ($can_sts == '3') {
				$can_sts = 1; 
			}
			$analyst_status[$key] = $anlyst; 
			$status[$key] = $can_sts; 

			$insuff_status_array[$key] = isset($insuff_status1[0])?$insuff_status1[0]:0;	 
			$output_status_array[$key] = isset($output_status1[0])?$output_status1[0]:0;	 
			$insuff_team_role_array[$key] = isset($insuff_team_role1[0])?$insuff_team_role1[0]:0;	 
			$insuff_team_id_array[$key] = isset($insuff_team_id1[0])?$insuff_team_id1[0]:0;	 
			$assigned_role_array[$key] = isset($assigned_role1[0])?$assigned_role1[0]:0;	 
			$assigned_team_id_array[$key] = isset($assigned_team_id1[0])?$assigned_team_id1[0]:0;	 
		} 

		 
		$criminal_data = array(
			'candidate_id'=>$user['candidate_id'],
			'address'=>$this->input->post('address'),
			'pin_code'=>$this->input->post('pincode'),
			'city'=>$this->input->post('city'),
			'state'=>$this->input->post('state'),
			'country'=>$this->input->post('country'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $insuff_status_array),
			'output_status'=>implode(',', $output_status_array),
			'insuff_team_role'=>implode(',', $insuff_team_role_array),
			'insuff_team_id'=>implode(',', $insuff_team_id_array), 
			'assigned_role'=>implode(',', $assigned_role_array), 
			'assigned_team_id'=>implode(',', $assigned_team_id_array), 
		);
 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('civil_check')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('civil_check_id')) {
			// $this->db->where('civil_check_id',$this->input->post('civil_check_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('civil_check',$criminal_data);

			$insert_id = $this->input->post('civil_check_id');
		}else{
			$result = $this->db->insert('civil_check',$criminal_data);
			$insert_id = $this->db->insert_id();
		}
 
		if ($result ==true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_candidate_document_check($candidate_aadhar,$candidate_pan,$candidate_proof,$candidate_voter,$candidate_ssn){ 
		$user = $this->session->userdata('logged-in-candidate');
 

		$status = array();
		$analyst_status = array(); 
		if ($this->input->post('document_check_id')) { 
		$data = $this->db->where('document_check_id',$this->input->post('document_check_id'))->get('document_check')->row_array();
		$candidate_status = explode(',', $data['status']);
		$analyst = explode(',', $data['analyst_status']);

		$insuff_status = explode(',',$data['insuff_status']);
		$output_status = explode(',',$data['output_status']);
		$insuff_team_role = explode(',',$data['insuff_team_role']);
		$insuff_team_id = explode(',',$data['insuff_team_id']);
		$assigned_role = explode(',',$data['assigned_role']);
		$assigned_team_id = explode(',',$data['assigned_team_id']);
		}

		$insuff_status_array = array();
		$output_status_array = array();
		$insuff_team_role_array = array();
		$insuff_team_id_array = array();
		$assigned_role_array = array();
		$assigned_team_id_array = array();
		for ($i=0; $i < $this->input->post('count'); $i++) { 
			$analyst1 = isset($analyst[$i])?$analyst[$i]:array(0);
			$candidate_status1 = isset($candidate_status[$i])?$candidate_status[$i]:array(1);
			$insuff_status1 = isset($insuff_status[$i])?$insuff_status[$i]:array(0);
			$output_status1 = isset($output_status[$i])?$output_status[$i]:array(0);
			$insuff_team_role1 = isset($insuff_team_role[$i])?$insuff_team_role[$i]:array(0);
			$insuff_team_id1 = isset($insuff_team_id[$i])?$insuff_team_id[$i]:array(0);
			$assigned_role1 = isset($assigned_role[$i])?$assigned_role[$i]:array(0);
			$assigned_team_id1 = isset($assigned_team_id[$i])?$assigned_team_id[$i]:array(0);
			$anlyst = $analyst1[0]; 
			if ($analyst1[0] == '3') {
				$anlyst = 0; 
			}
			$can_sts = $candidate_status1[0];
			if ($candidate_status1[0] == '3') {
				$can_sts = 1; 
			}
			$analyst_status[$i] = $anlyst; 
			$status[$i] = $can_sts; 
			$insuff_status_array[$i] = $insuff_status1[0];	 
			$output_status_array[$i] = $output_status1[0];	 
			$insuff_team_role_array[$i] = $insuff_team_role1[0];	 
			$insuff_team_id_array[$i] = $insuff_team_id1[0];	 
			$assigned_role_array[$i] = $assigned_role1[0];	 
			$assigned_team_id_array[$i] = $assigned_team_id1[0];	 
		} 

		$document_data = array(
			'candidate_id'=>$user['candidate_id'],
			'pan_number'=>$this->input->post('pan_number'),
			'passport_number'=>$this->input->post('passport_number'), 
			'aadhar_number'=>$this->input->post('aadhar_number'), 
			'ssn_number'=>$this->input->post('ssn_number'),  
			'voter_id'=>$this->input->post('voter_id'), 
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $insuff_status_array),
			'output_status'=>implode(',', $output_status_array),
			'insuff_team_role'=>implode(',', $insuff_team_role_array),
			'insuff_team_id'=>implode(',', $insuff_team_id_array), 
			'assigned_role'=>implode(',', $assigned_role_array), 
			'assigned_team_id'=>implode(',', $assigned_team_id_array), 
		);
		if (!in_array('no-file', $candidate_proof)) {
			$document_data['passport_doc'] = implode(',', $candidate_proof);
		}
		if (!in_array('no-file', $candidate_pan)) {
			$document_data['pan_card_doc'] = implode(',', $candidate_pan);
		}
		if (!in_array('no-file', $candidate_aadhar)) {
			$document_data['adhar_doc'] = implode(',', $candidate_aadhar);
		} 
		if (!in_array('no-file', $candidate_voter)) {
			$document_data['voter_doc'] = implode(',', $candidate_voter);
		} 
		if (!in_array('no-file', $candidate_ssn)) {
			$document_data['ssn_doc'] = implode(',', $candidate_ssn);
		} 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('document_check')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('document_check_id')) {
			// $this->db->where('document_check_id',$this->input->post('document_check_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('document_check',$document_data);

			$insert_id = $this->input->post('document_check_id');
		}else{
			$result = $this->db->insert('document_check',$document_data);
			$insert_id = $this->db->insert_id();
		}
		if ($result == true) {
		// if ($this->db->insert('document_check',$criminal_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}		
	}

	function update_candidate_drug_test(){ 
		$user = $this->session->userdata('logged-in-candidate');
		$address = json_decode($this->input->post('address'),true);
		$status = array();
		$analyst_status = array(); 
		if ($this->input->post('drugtest_id')) { 
		$data = $this->db->where('drugtest_id',$this->input->post('drugtest_id'))->get('drugtest')->row_array();
		$candidate_status = explode(',', $data['status']);
		$analyst = explode(',', $data['analyst_status']);

		$insuff_status = explode(',',$data['insuff_status']);
		$output_status = explode(',',$data['output_status']);
		$insuff_team_role = explode(',',$data['insuff_team_role']);
		$insuff_team_id = explode(',',$data['insuff_team_id']);
		$assigned_role = explode(',',$data['assigned_role']);
		$assigned_team_id = explode(',',$data['assigned_team_id']);
		}

		$insuff_status_array = array();
		$output_status_array = array();
		$insuff_team_role_array = array();
		$insuff_team_id_array = array();
		$assigned_role_array = array();
		$assigned_team_id_array = array();
		for ($i=0; $i < count($address); $i++) { 
			$analyst1 = isset($analyst[$i])?$analyst[$i]:array(0);
			$candidate_status1 = isset($candidate_status[$i])?$candidate_status[$i]:array(1);
			$insuff_status1 = isset($insuff_status[$i])?$insuff_status[$i]:array(0);
			$output_status1 = isset($output_status[$i])?$output_status[$i]:array(0);
			$insuff_team_role1 = isset($insuff_team_role[$i])?$insuff_team_role[$i]:array(0);
			$insuff_team_id1 = isset($insuff_team_id[$i])?$insuff_team_id[$i]:array(0);
			$assigned_role1 = isset($assigned_role[$i])?$assigned_role[$i]:array(0);
			$assigned_team_id1 = isset($assigned_team_id[$i])?$assigned_team_id[$i]:array(0);
			$anlyst = isset($analyst1[0])?$analyst1[0]:0; 
			if ($anlyst == '3') {
				$anlyst = 0; 
			}
			$can_sts = isset($candidate_status1[0])?$candidate_status1[0]:1;
			if ($can_sts == '3') {
				$can_sts = 1; 
			}
			$analyst_status[$i] = $anlyst; 
			$status[$i] = $can_sts; 

			$insuff_status_array[$i] = isset($insuff_status1[0])?$insuff_status1[0]:0;	 
			$output_status_array[$i] = isset($output_status1[0])?$output_status1[0]:0;	 
			$insuff_team_role_array[$i] = isset($insuff_team_role1[0])?$insuff_team_role1[0]:0;	 
			$insuff_team_id_array[$i] = isset($insuff_team_id1[0])?$insuff_team_id1[0]:0;	 
			$assigned_role_array[$i] = isset($assigned_role1[0])?$assigned_role1[0]:0;	 
			$assigned_team_id_array[$i] = isset($assigned_team_id1[0])?$assigned_team_id1[0]:0;	 
		} 
		$drugtest = array(
			'candidate_id'=>$user['candidate_id'],
			'address'=>$this->input->post('address'),
			'candidate_name'=>$this->input->post('name'),
			'father__name'=>$this->input->post('father_name'),
			'dob'=>$this->input->post('date_of_birth'),
			'mobile_number'=>$this->input->post('contact_no'),
			'code'=>$this->input->post('code'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $insuff_status_array),
			'output_status'=>implode(',', $output_status_array),
			'insuff_team_role'=>implode(',', $insuff_team_role_array),
			'insuff_team_id'=>implode(',', $insuff_team_id_array), 
			'assigned_role'=>implode(',', $assigned_role_array), 
			'assigned_team_id'=>implode(',', $assigned_team_id_array), 
		);
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('drugtest')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('drugtest_id')) {
			// $this->db->where('drugtest_id',$this->input->post('drugtest_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('drugtest',$drugtest);

			$insert_id = $this->input->post('drugtest_id');
		}else{
			$result = $this->db->insert('drugtest',$drugtest);
			$insert_id = $this->db->insert_id();
		}


		if ($result == true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}		
	}

	function update_candidate_global(){ 
		$user = $this->session->userdata('logged-in-candidate');
		if ($this->input->post('globaldatabase_id')) { 
		$data = $this->db->where('globaldatabase_id',$this->input->post('globaldatabase_id'))->get('globaldatabase')->row_array();
		$candidate_status = $data['status'];
		$analyst = $data['analyst_status']; 
		}
		$status = isset($candidate_status)?$candidate_status:1;
		$an = isset($analyst)?$analyst:0;
		if ($status =='3' || $an =='3') {
			$status = 1;
			$an = 0;
		}
		$global_data = array(
			'candidate_id'=>$user['candidate_id'],
			'candidate_name'=>$this->input->post('name'),
			'father_name'=>$this->input->post('father_name'),
			'dob'=>$this->input->post('date_of_birth'),
			'status'=>$status,
			'analyst_status'=>$an,
		); 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('globaldatabase')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('global_id')) {
			// $this->db->where('globaldatabase_id',$this->input->post('global_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('globaldatabase',$global_data);

			$insert_id = $this->input->post('global_id');
		}else{
			$result = $this->db->insert('globaldatabase',$global_data);
			$insert_id = $this->db->insert_id();
		}

		if ($result == true) {

		$criminal_log_data = array(
			'globaldatabase_id'=>$insert_id,
			'candidate_id'=>$user['candidate_id'],
			'candidate_name'=>$this->input->post('name'),
			'father_name'=>$this->input->post('father_name'),
			'dob'=>$this->input->post('date_of_birth'),
			'status'=>1,
			'analyst_status'=>1,
		);
		$this->db->insert('globaldatabase_log',$criminal_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}		
	}

	function update_candidate_gap(){ 
		$user = $this->session->userdata('logged-in-candidate');
		if ($this->input->post('gap_id')) { 
		$data = $this->db->where('gap_id',$this->input->post('gap_id'))->get('employment_gap_check')->row_array();
		$candidate_status = $data['status'];
		$analyst = $data['analyst_status']; 
		}

		$anlyst = isset($analyst)?$analyst:0;
			if ($anlyst == '3') {
				$anlyst = 0; 
			}
			$can_sts = isset($candidate_status)?$candidate_status:1;
			if ($can_sts == '3') {
				$can_sts = 1; 
			} 

		$gap = array(
			'candidate_id'=>$user['candidate_id'],
			'reason_for_gap'=>$this->input->post('reason_for_gap'), 
			'duration_of_gap'=>$this->input->post('date_gap'), 
			'status'=>$can_sts,
			'analyst_status'=>$anlyst,
		); 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('employment_gap_check')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('gap_id')) {
			// $this->db->where('gap_id',$this->input->post('gap_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('employment_gap_check',$gap);

			$insert_id = $this->input->post('gap_id');
		}else{
			$result = $this->db->insert('employment_gap_check',$gap);
			$insert_id = $this->db->insert_id();
		}

		if ($result == true) {

		 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}		
	}

	function update_candidate_education_details($all_sem_marksheet,$convocation,$marksheet_provisional_certificate,$ten_twelve_mark_card_certificate){
 
		 
		$user = $this->session->userdata('logged-in-candidate');
		$degree = json_decode($this->input->post('type_of_degree'),true);
		$data = '';
		$db_all_sem ='';
		$db_convocations ='';
		$db_marksheet ='';
		$db_ten_twelve ='';
		if ($this->input->post('education_details_id')) {
			$data = $this->db->where('education_details_id',$this->input->post('education_details_id'))->get('education_details')->row_array();
			$db_all_sem = json_decode($data['all_sem_marksheet'],true);
			$db_convocations = json_decode($data['convocation'],true);
			$db_marksheet = json_decode($data['marksheet_provisional_certificate'],true);
			$db_ten_twelve = json_decode($data['ten_twelve_mark_card_certificate'],true);

			$candidate_status = explode(',', $data['status']);
		$analyst = explode(',', $data['analyst_status']);

		$insuff_status = explode(',',$data['insuff_status']);
		$output_status = explode(',',$data['output_status']);
		$insuff_team_role = explode(',',$data['insuff_team_role']);
		$insuff_team_id = explode(',',$data['insuff_team_id']);
		$assigned_role = explode(',',$data['assigned_role']);
		$assigned_team_id = explode(',',$data['assigned_team_id']);
		}

		$marksheet = explode(',',$this->input->post('marksheet'));
		$convocatio_n = explode(',',$this->input->post('convocation'));
		$certificate = explode(',',$this->input->post('certificate'));
		$ten_twelve = explode(',',$this->input->post('ten_twelve'));
		$status = array();
		$analyst_status = array(); 
		 

		$insuff_status_array = array();
		$output_status_array = array();
		$insuff_team_role_array = array();
		$insuff_team_id_array = array();
		$assigned_role_array = array();
		$assigned_team_id_array = array();
		  

		$all_sem_marksheet_array =array();
		$convocation_array =array();
		$marksheet_provisional_certificate_array =array();
		$ten_twelve_mark_card_certificate_array = array();
		$k = 0;
		$m=0;
		$c=0;
		$ce=0;
		$t=0;
		for($i=0; $i < count($degree); $i++) {  
			$analyst1 = isset($analyst[$i])?$analyst[$i]:array(0);
			$candidate_status1 = isset($candidate_status[$i])?$candidate_status[$i]:array(1);
			$insuff_status1 = isset($insuff_status[$i])?$insuff_status[$i]:array(0);
			$output_status1 = isset($output_status[$i])?$output_status[$i]:array(0);
			$insuff_team_role1 = isset($insuff_team_role[$i])?$insuff_team_role[$i]:array(0);
			$insuff_team_id1 = isset($insuff_team_id[$i])?$insuff_team_id[$i]:array(0);
			$assigned_role1 = isset($assigned_role[$i])?$assigned_role[$i]:array(0);
			$assigned_team_id1 = isset($assigned_team_id[$i])?$assigned_team_id[$i]:array(0);
			$anlyst = $analyst1[0]; 
			if ($analyst1[0] == '3') {
				$anlyst = 0; 
			}
			$can_sts = $candidate_status1[0];
			if ($candidate_status1[0] == '3') {
				$can_sts = 1; 
			}
			$analyst_status[$i] = $anlyst; 
			$status[$i] = $can_sts; 
			$insuff_status_array[$i] = $insuff_status1[0];	 
			$output_status_array[$i] = $output_status1[0];	 
			$insuff_team_role_array[$i] = $insuff_team_role1[0];	 
			$insuff_team_id_array[$i] = $insuff_team_id1[0];	 
			$assigned_role_array[$i] = $assigned_role1[0];	 
			$assigned_team_id_array[$i] = $assigned_team_id1[0];
		/* 10 / 12 / certy */
		$course_completion_certificate_list = 0;
		if (in_array(strtolower($degree[$i]['type_of_degree']),$this->config->item('10_12_course_completion_certificate_list')) ) {

			if ($ten_twelve[$course_completion_certificate_list]=='1') {
				array_push($ten_twelve_mark_card_certificate_array,isset($ten_twelve_mark_card_certificate[$t])?$ten_twelve_mark_card_certificate[$t]:array('no-file')); 
				$t++; 
			}else{
				array_push($ten_twelve_mark_card_certificate_array,isset($db_ten_twelve[$i])?$db_ten_twelve[$i]:array('no-file')); 
			}
			$course_completion_certificate_list++;
		}else{
			array_push($ten_twelve_mark_card_certificate_array,isset($db_ten_twelve[$i])?$db_ten_twelve[$i]:array('no-file'));	
		}

		/* All Sem marksheet*/
		$all_sem_marksheet_list = 0;
		if (in_array(strtolower($degree[$i]['type_of_degree']),$this->config->item('all_sem_marksheet_list')) ) {
			if ($marksheet[$all_sem_marksheet_list]=='1') { 
				array_push($all_sem_marksheet_array,isset($all_sem_marksheet[$m])?$all_sem_marksheet[$m]:array('no-file')); 
				$m++;
			}else{
				array_push($all_sem_marksheet_array,isset($db_all_sem[$i])?$db_all_sem[$i]:array('no-file'));
			}
			$all_sem_marksheet_list++;
		}else{
			array_push($all_sem_marksheet_array,isset($db_all_sem[$i])?$db_all_sem[$i]:array('no-file'));
		}

		/* profeshional degree */
		$professional_degree_or_degree_convocation_certificate_list = 0;
		if (in_array(strtolower($degree[$i]['type_of_degree']),$this->config->item('professional_degree_or_degree_convocation_certificate_list')) ) {
			if ($convocatio_n[$professional_degree_or_degree_convocation_certificate_list]=='1') {  
				array_push($convocation_array,isset($convocation[$c])?$convocation[$c]:array('no-file')); 
				$c++;
			}else{
				array_push($convocation_array,isset($db_convocations[$i])?$db_convocations[$i]:array('no-file'));
			}

			$professional_degree_or_degree_convocation_certificate_list++;
		}else{
			 array_push($convocation_array,array('no-file'));
		}

		/* transcript */
		$transcript_of_records_list =0;
		if (in_array(strtolower($degree[$i]['type_of_degree']),$this->config->item('transcript_of_records_list')) ) {
			if ($certificate[$transcript_of_records_list]=='1') { 
				array_push($marksheet_provisional_certificate_array,isset($marksheet_provisional_certificate[$ce])?$marksheet_provisional_certificate[$ce]:array('no-file')); 
				$ce++;
			} else {
				array_push($marksheet_provisional_certificate_array,isset($db_marksheet[$i])?$db_marksheet[$i]:array('no-file'));
			}
			$transcript_of_records_list++;
		}else{
			array_push($marksheet_provisional_certificate_array,array('no-file'));
		}
 
	}

		$start_month = explode(',', $this->input->post('start_month'));
		// $start_year = $this->input->post('start_year');
		$end_month = explode(',', $this->input->post('end_month'));
		$end_year = explode(',', $this->input->post('end_year'));
		$start_year_month = array();
		$end_year_month = array();
		foreach (explode(',', $this->input->post('start_year')) as $key => $val) {
			array_push($start_year_month,array('course_start_date'=>$val.'-'.$start_month[$key].'-00')); 
			array_push($end_year_month,array('course_end_date'=>$end_year[$key].'-'.$end_month[$key].'-00')); 
		}

		$eduction_data = array(
			'candidate_id'=>$user['candidate_id'],
			'type_of_degree'=>$this->input->post('type_of_degree'),
			'major'=>$this->input->post('major'),
			'university_board'=>$this->input->post('university'),
			'college_school'=>$this->input->post('college_name'),
			'address_of_college_school'=>$this->input->post('address'),
			'registration_roll_number'=>$this->input->post('registration_roll_number'), 
			/*'course_start_date'=>$this->input->post('duration_of_stay'),
			'course_end_date'=>$this->input->post('duration_of_course'),*/
			'course_start_date'=>json_encode($start_year_month),
			'course_end_date'=>json_encode($end_year_month),  
			'type_of_course'=>$this->input->post('time'),   
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $insuff_status_array),
			'output_status'=>implode(',', $output_status_array),
			'insuff_team_role'=>implode(',', $insuff_team_role_array),
			'insuff_team_id'=>implode(',', $insuff_team_id_array), 
			'assigned_role'=>implode(',', $assigned_role_array), 
			'assigned_team_id'=>implode(',', $assigned_team_id_array), 
		);

		if (!in_array('no-file', $all_sem_marksheet)) {
			$eduction_data['all_sem_marksheet'] = json_encode($all_sem_marksheet_array);
		}if (!in_array('no-file', $convocation)) {
			$eduction_data['convocation'] = json_encode($convocation_array);
		}if (!in_array('no-file', $marksheet_provisional_certificate)) {
			$eduction_data['marksheet_provisional_certificate'] = json_encode($marksheet_provisional_certificate_array);
		}if (!in_array('no-file', $ten_twelve_mark_card_certificate)) {
			$eduction_data['ten_twelve_mark_card_certificate'] = json_encode($ten_twelve_mark_card_certificate_array);
		}

		// return $eduction_data;
		 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('education_details')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('education_details_id')) {
			// $this->db->where('education_details_id',$this->input->post('education_details_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('education_details',$eduction_data);

			$insert_id = $this->input->post('education_details_id');
		}else{
			$result = $this->db->insert('education_details',$eduction_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
		// if ($this->db->insert('education_details',$eduction_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_candidate_present_address($candidate_rental,$candidate_ration,$candidate_gov) {
		$user = $this->session->userdata('logged-in-candidate');
		$get_client_details = $this->db->where('client_id',$user['client_id'])->get('tbl_client')->row_array();
		// print_r($user);
		if ($this->input->post('present_address_id')) {
			$this->db->where('present_address_id',$this->input->post('present_address_id'));
			$data = $this->db->get('present_address')->row_array();
			$candidate_status = $data['status'];
			$analyst = $data['analyst_status'];
		}

		$status = isset($candidate_status)?$candidate_status:1;
		$an = isset($analyst)?$analyst:0;
		if ($status =='3' || $an =='3') {
			$status = 1;
			$an = 0;
		}
		$present_data = array(
			'candidate_id'=>$user['candidate_id'],
			'flat_no'=>$this->input->post('house'),
			'street'=>$this->input->post('street'),
			'area'=>$this->input->post('area'),
			'city'=>$this->input->post('city'),
			'pin_code'=>$this->input->post('pincode'),
			'state'=>$this->input->post('state'),
			'country'=>$this->input->post('country'),
			'nearest_landmark'=>$this->input->post('land_mark'),
			/*'duration_of_stay_start'=>$this->input->post('start_date'),
			'duration_of_stay_end'=>$this->input->post('end_date'),*/
			'duration_of_stay_start'=>$this->input->post('start_year').'-'.$this->input->post('start_month').'-00',
			'duration_of_stay_end'=>$this->input->post('end_year').'-'.$this->input->post('end_month').'-00',
			'is_present'=>$this->input->post('present'),
			'contact_person_name'=>$this->input->post('name'),
			'contact_person_relationship'=>$this->input->post('relationship'),
			'contact_person_mobile_number'=> $this->input->post('contact_no'),
			'code'=> $this->input->post('code'),
			'iverify_or_pv_status' => $get_client_details['iverify_or_pv_status'],
			'status'=>$status,
			'analyst_status'=>$an,
		);

		if (!in_array('no-file', $candidate_rental)) {
			$present_data['rental_agreement'] = implode(',', $candidate_rental);
		}
		if (!in_array('no-file', $candidate_ration)) {
			$present_data['ration_card'] = implode(',', $candidate_ration);
		}
		if (!in_array('no-file', $candidate_gov)) {
			$present_data['gov_utility_bill'] = implode(',', $candidate_gov);
		}
 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('present_address')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('present_address_id')) {
			// $this->db->where('present_address_id',$this->input->post('present_address_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('present_address',$present_data);

			$insert_id = $this->input->post('present_address_id');
		}else{
			$result = $this->db->insert('present_address',$present_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {

		// if ( $this->db->insert('present_address',$present_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}



	function state(){
		return $stateList = array('Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya',
                                                         'Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh',
                                                         'Uttarakhand','West Bengal');
	}


	function all_components($candidate_id=''){ 
		$table = array('criminal_checks','court_records','document_check','drugtest','globaldatabase','current_employment','education_details','present_address','permanent_address','previous_employment','reference','previous_address','cv_check','driving_licence','credit_cibil','bankruptcy','directorship_check','global_sanctions_aml','adverse_database_media_check','health_checkup','employment_gap_check','landload_reference','covid_19','social_media','civil_check','right_to_work','sex_offender','politically_exposed','india_civil_litigation','mca','nric','gsa','oig');
		$table_data = array();
		if ($candidate_id =='') {
			 
		$user = $this->session->userdata('logged-in-candidate');
		$candidate_id = $user['candidate_id'];
		}
		foreach ($table as $key => $value) {
			$table_data[$value] = $this->db->where('candidate_id',$candidate_id)->get($value)->row_array(); 
		}

		return $table_data; 
	}


	function redirect_url($component_id,$request_from = '') {
		// return $component_id;
		$table_name = array();
		$mobile_candidate_links = array();
		$user = $this->session->userdata('logged-in-candidate'); 
		$log = $this->db->where('client_id',$user['client_id'])->get('custom_logo')->row_array();
		$client_name = strtolower(trim($user['first_name']).'-'.trim($user['last_name']));
		$client_name = preg_replace('/ /i','-',$client_name);
		$additional = 0;
		if (isset($log['additional'])) {
			if ($log['additional'] == 1) {
				$additional = 1;
			}
		}
 
		switch ((int)$component_id) {
			
			case 1:
				$table_name = $client_name.'/candidate-criminal-check';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-criminal-check';
				}
				break;

			case 2:
				$table_name = $client_name.'/candidate-court-record';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-court-record-1';
				}
				break;
			case 3:
				$table_name = $client_name.'/candidate-document-check';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-document-check';
				}
				break;
 
			case 4:
				$table_name = $client_name.'/candidate-drug-test';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-drug-test';
				}
				break;

			case 5:
				$table_name = $client_name.'/candidate-global-database';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-global-database';
				}
				break;

			case 6:
				$table_name = $client_name.'/candidate-employment';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-current-employment-1';
				}
				break; 
			case 7:
				$table_name = $client_name.'/candidate-education';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-education-1';
				}
				break; 
			case 8:
				$table_name = $client_name.'/candidate-present-address';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-present-address-1';
				}
				break;
			case 9:
				$table_name = $client_name.'/candidate-address';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-permanent-address-1';
				}
				break; 
			case 10:
				$table_name = $client_name.'/candidate-previos-employment';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-previous-employment-1';
				}
				break; 
			case 11:
				$table_name = $client_name.'/candidate-reference';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-reference';
				}
				break; 
			case 12:
				$table_name = $client_name.'/candidate-previous-address';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-previous-address-1';
				}
				break; 

			case 16:
				$table_name = $client_name.'/candidate-driving-licence';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-driving-licence';
				}
				break; 
			case 17:
				$table_name = $client_name.'/candidate-credit-cibil';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-credit-cibil';
				}
				break; 
			case 18:
				$table_name = $client_name.'/candidate-bankruptcy';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-bankruptcy';
				}
				break; 
			case 20:
				$table_name = $client_name.'/candidate-cv-check';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-cv-check';
				}
				break; 
			case 22:
				$table_name = $client_name.'/candidate-employment-gap';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-employment-gap';
				}
				break; 
			case 23:
				$table_name = $client_name.'/candidate-landload-reference';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-landlord-reference';
				}
				break; 
			case 25:
				$table_name = $client_name.'/candidate-social-media';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-social-media';
				}
				break; 
			case 26:
				$table_name = $client_name.'/candidate-civil-check';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-candidate-civil-check';
				}
				break; 
			case 27:
				$table_name = $client_name.'/candidate-right-to-work';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-right-to-work';
				}
				break;
			case 28:
				$table_name = $client_name.'/candidate-sex-offender';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-sex-offender';
				}
				break;
			case 29:
				$table_name = $client_name.'/candidate-politically-exposed';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-politically-exposed';
				}
				break;
			case 30:
				$table_name = $client_name.'/candidate-india-civil-litigation';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-india-civil-litigation';
				}
				break;
			case 31:
				$table_name = $client_name.'/candidate-mca';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-mca';
				}
				break;
			case 32:
				$table_name = $client_name.'/candidate-nric';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-nric';
				}
				break;		
			case 33:
				$table_name = $client_name.'/candidate-gsa';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-gsa';
				}
				break;
			case 34:
				$table_name = $client_name.'/candidate-oig';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-oig';
				}
				break;

			default: 
				if ($additional ==1 && $component_id ==0) {
					 $table_name = $client_name.'/candidate-additional';
					 if ($request_from == 'link-for-mobile') {
					$table_name = 'm-additional';
				}
				}else{ 
					$table_name = $client_name.'/candidate-signature';
					if ($request_from == 'link-for-mobile') {
						// $table_name = 'm-consent-form';
						$table_name = 'm-verification-steps';
					}
				}
				break;
		}


		return $table_name;
	}

	function update_candidate_additional($image){
		if (in_array('no-file',$image)) {
			return array('status'=>'1','msg'=>'success');
		}
		$user = $this->session->userdata('logged-in-candidate');
		$save_data = array( 
			'additional_docs'=>implode(',', $image)
		);
		$this->db->where('candidate_id',$user['candidate_id']); 
		if ($this->db->update('candidate',$save_data)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function submit_final_data(){
		$user = $this->session->userdata('logged-in-candidate');
		$save_data = array(
			'candidate_id'=>$user['candidate_id'],
			'signature_img'=>$this->input->post('signature'),
			'accept_status'=>1, 
		);
		$result = '';
		$client = $this->db->where('client_id',$user['client_id'])->get('tbl_client')->row_array();
		if ($client['signature'] =='1') {
			$result = $this->db->insert('signature',$save_data);
		}else{
			$result = true;
		}
		if ($result) {
			// Insuff clear notification
			$notificationUpdate = array('form_filld_notification'=>'1');

			$candidate_array = array(
				'client_id'=>$user['client_id'],
				'status'=>1,
				'notification_type'=>3,
				'candidate_id'=>$user['candidate_id']
			);
			
			if($this->db->where('candidate_id',$user['candidate_id'])->update('candidate',$notificationUpdate)){
				$this->db->insert('candidate_log',$this->db->where('candidate_id',$user['candidate_id'])->get('candidate')->row_array());
			}

			$candidate_status = array(
				'is_submitted'=>1,
				'case_reinitiate'=>0,
				'case_submitted_date'=>date('d-m-Y H:i:s'),
				'report_generated'=>0,
				'is_report_generated'=>0,
				'report_generated_date'=>'',
			);
			$this->db->where('candidate_id',$user['candidate_id']);
			$this->db->update('candidate',$candidate_status);
				return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}



	function notification_action_report($candidate_array){

		$spoc_id = $this->db->where('client_id',$candidate_array['client_id'])->get('tbl_clientspocdetails')->result_array(); 
		foreach ($spoc_id as $key => $value) {
			$candidate_data = array(
				'candidate_id'=>$candidate_array['candidate_id'],
				'client_id'=>$candidate_array['client_id'],
				'client_spoc_id'=>$value['spoc_id'],
				'notification_status'=>$candidate_array['status'],
				'notification_type_id'=>$candidate_array['notification_type'],
			);
			$this->db->insert('client_in_app_notification',$candidate_data);
		}

	}

	function drug_test_type($drug_test_type_id){
		return $this->db->where('drug_test_type_id',$drug_test_type_id)->get('drug_test_type')->row_array(); 
	}

	function education_type($education_type_id){
		return $this->db->where('education_type_id',$education_type_id)->get('education_type')->row_array();
	}


	function update_candidate_previous_address($candidate_rental,$candidate_ration,$candidate_gov){
		$user = $this->session->userdata('logged-in-candidate');
		$get_client_details = $this->db->where('client_id',$user['client_id'])->get('tbl_client')->row_array();
		$permenent_house = json_decode($this->input->post('permenent_house'),true);
		$status = array();
		$analyst_status = array(); 
		if ($this->input->post('previos_address_id')) { 
		$data = $this->db->where('previos_address_id',$this->input->post('previos_address_id'))->get('previous_address')->row_array();
		$candidate_status = explode(',', $data['status']);
		$analyst = explode(',', $data['analyst_status']);

		$insuff_status = explode(',',$data['insuff_status']);
		$output_status = explode(',',$data['output_status']);
		$insuff_team_role = explode(',',$data['insuff_team_role']);
		$insuff_team_id = explode(',',$data['insuff_team_id']);
		$assigned_role = explode(',',$data['assigned_role']);
		$assigned_team_id = explode(',',$data['assigned_team_id']);
		}

		$insuff_status_array = array();
		$output_status_array = array();
		$insuff_team_role_array = array();
		$insuff_team_id_array = array();
		$assigned_role_array = array();
		$assigned_team_id_array = array();
		foreach ($permenent_house as $key => $value) { 
			$analyst1 = isset($analyst[$key])?$analyst[$key]:array(0);
			$candidate_status1 = isset($candidate_status[$key])?$candidate_status[$key]:array(1);
			$insuff_status1 = isset($insuff_status[$key])?$insuff_status[$key]:array(0);
			$output_status1 = isset($output_status[$key])?$output_status[$key]:array(0);
			$insuff_team_role1 = isset($insuff_team_role[$key])?$insuff_team_role[$key]:array(0);
			$insuff_team_id1 = isset($insuff_team_id[$key])?$insuff_team_id[$key]:array(0);
			$assigned_role1 = isset($assigned_role[$key])?$assigned_role[$key]:array(0);
			$assigned_team_id1 = isset($assigned_team_id[$key])?$assigned_team_id[$key]:array(0);
			$anlyst = $analyst1[0]; 
			if ($analyst1[0] == '3') {
				$anlyst = 0; 
			}
			$can_sts = $candidate_status1[0];
			if ($candidate_status1[0] == '3') {
				$can_sts = 1; 
			}
			$analyst_status[$key] = $anlyst; 
			$status[$key] = $can_sts;   
			$insuff_status_array[$key] = $insuff_status1[0];	 
			$output_status_array[$key] = $output_status1[0];	 
			$insuff_team_role_array[$key] = $insuff_team_role1[0];	 
			$insuff_team_id_array[$key] = $insuff_team_id1[0];	 
			$assigned_role_array[$key] = $assigned_role1[0];	 
			$assigned_team_id_array[$key] = $assigned_team_id1[0];	 
		} 
		$address ='';
		if ($this->input->post('previos_address_id')) {
			$address = $this->db->where('previos_address_id',$this->input->post('previos_address_id'))->get('previous_address')->row_array();  
		}
		// rental_agreement
		// ration_card
		// gov_utility_bill

		$rental = explode(',', $this->input->post('rental_agreement'));
		$rental_agreement = json_decode( isset($address['rental_agreement'])?$address['rental_agreement']:'no-file' ,true);
		$j = 0;
		$candidate_rental_array = array();
		foreach ($rental as $key => $value) {
			if ($value == '1') {
				array_push($candidate_rental_array, $candidate_rental[$j]);
				$j++;
			}else{ 
				array_push($candidate_rental_array, isset($rental_agreement[$key])?$rental_agreement[$key]:array('no-file'));
			}
		}

		$ration = explode(',', $this->input->post('ration_card'));
		$ration_card = json_decode( isset($address['ration_card'])?$address['ration_card']:'no-file' ,true);
		$j = 0;
		$candidate_ration_array = array();
		foreach ($ration as $key => $value) {
			if ($value == '1') {
				array_push($candidate_ration_array, $candidate_ration[$j]);
				$j++;
			} else { 
				array_push($candidate_ration_array, isset($ration_card[$key])?$ration_card[$key]:array('no-file'));
			}
		}

		$gov_utility = explode(',', $this->input->post('gov_utility_bill'));
		$gov_utility_bill = json_decode( isset($address['gov_utility_bill'])?$address['gov_utility_bill']:'no-file' ,true);
		$j = 0;
		$candidate_gov_array = array();
		foreach ($gov_utility as $key => $value) {
			if ($value == '1') {
				array_push($candidate_gov_array, $candidate_gov[$j]);
				$j++;
			}else{ 
				array_push($candidate_gov_array, isset($gov_utility_bill[$key])?$gov_utility_bill[$key]:array('no-file'));
			}
		}

		$start_month = explode(',', $this->input->post('start_month'));
		// $start_year = $this->input->post('start_year');
		$end_month = explode(',', $this->input->post('end_month'));
		$end_year = explode(',', $this->input->post('end_year'));
		$start_year_month = array();
		$end_year_month = array();
		foreach (explode(',', $this->input->post('start_year')) as $key => $val) {
			array_push($start_year_month,array('duration_of_stay_start'=>$val.'-'.$start_month[$key].'-00')); 
			array_push($end_year_month,array('duration_of_stay_end'=>$end_year[$key].'-'.$end_month[$key].'-00')); 
		}

		$iverify_or_pv_status = [];
		if (count($end_month) > 0) {
			$client_iverify_or_pv_status = $get_client_details['iverify_or_pv_status'];
			for ($i = 0; $i < count($end_month); $i++) { 
				array_push($iverify_or_pv_status, $client_iverify_or_pv_status);
			}
		}

		$present_data = array(
			'candidate_id'=>$user['candidate_id'],
			'flat_no'=>$this->input->post('permenent_house'),
			'street'=>$this->input->post('permenent_street'),
			'area'=>$this->input->post('permenent_area'),
			'city'=>$this->input->post('permenent_city'),
			'pin_code'=>$this->input->post('permenent_pincode'),
			'state'=>$this->input->post('state'),
			'country'=>$this->input->post('country'),
			'nearest_landmark'=>$this->input->post('permenent_land_mark'),
			/*'duration_of_stay_start'=>$this->input->post('permenent_start_date'),
			'duration_of_stay_end'=>$this->input->post('permenent_end_date'),*/
			'duration_of_stay_start'=>json_encode($start_year_month),
			'duration_of_stay_end'=>json_encode($end_year_month),
			'is_present'=>$this->input->post('permenent_present'),
			'contact_person_name'=>$this->input->post('permenent_name'),
			'contact_person_relationship'=>$this->input->post('permenent_relationship'),
			'contact_person_mobile_number'=> $this->input->post('permenent_contact_no'),
			'code'=> $this->input->post('code'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $insuff_status_array),
			'output_status'=>implode(',', $output_status_array),
			'insuff_team_role'=>implode(',', $insuff_team_role_array),
			'insuff_team_id'=>implode(',', $insuff_team_id_array), 
			'assigned_role'=>implode(',', $assigned_role_array), 
			'assigned_team_id'=>implode(',', $assigned_team_id_array),
			'iverify_or_pv_status' => implode(',', $iverify_or_pv_status), 
		);

		if (!in_array('no-file', $candidate_rental_array)) {
			$present_data['rental_agreement'] = json_encode($candidate_rental_array);
		}
		if (!in_array('no-file', $candidate_ration_array)) {
			$present_data['ration_card'] = json_encode($candidate_ration_array);
		}
		if (!in_array('no-file', $candidate_gov_array)) {
			$present_data['gov_utility_bill'] = json_encode($candidate_gov_array);
		} 
 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('previous_address')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('previos_address_id')) {
			// $this->db->where('previos_address_id',$this->input->post('previos_address_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('previous_address',$present_data);

			$insert_id = $this->input->post('previos_address_id');
		}else{
			$result = $this->db->insert('previous_address',$present_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {

		// if ( $this->db->insert('previous_address',$present_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}



	function remove_candidate_images(){
		$user = $this->session->userdata('logged-in-candidate');
		$table = $this->input->post('table');
		$image_name = $this->input->post('image_name');
		$candidate_id = $user['candidate_id'];
		$path = $this->input->post('path');
		$image_field = $this->input->post('image_field');

		$result_field = $this->db->where('candidate_id',$candidate_id)->get($table);

		if($result_field->num_rows() > 0){
			$result = $result_field->row_array();

			$result_image = explode(',', $result[$image_field]);
			$store_img = array();
			if (count($result_image) > 0) {
				foreach ($result_image as $key => $value) {
					if ($value != $image_name) {
						array_push($store_img, $value);
					}
				}
			}
			$store_data = array();
			$store_data[$image_field] = implode(',', $store_img);
			$this->db->where('candidate_id',$candidate_id);

			if ($this->db->update($table,$store_data)) {
				return array('status'=>'1','msg'=>'success');
			}else{
				return array('status'=>'1','msg'=>'success');
			}

		}else{
			return array('status'=>'0','msg'=>'failed');
		}


	}

	function get_all_countries(){
		return $this->db->get('countries')->result_array();
	}

	function get_all_states($id=''){
		if ($id !='') {
			return $this->db->where('country_id',$id)->get('states')->result_array();
		}else{
			return $this->db->order_by('country_id','ASC')->get('states')->result_array();
		}
	}

	function get_all_cities($id=''){
		if ($id !='') {
			return $this->db->where('state_id',$id)->get('cities')->result_array();
		}else{
			return $this->db->order_by('state_id','ASC')->get('cities')->result_array();
		}
	}

	function send_otp_to_email_id() {
		$user = $this->session->userdata('logged-in-candidate');
		if ($user['email_id_validated_by_candidate_status'] == 0) {
			$login_otp = $this->candidate_Util_Model->random_number(4);
			$client_email_subject = 'Validate Email ID - OTP';

			$email_message = '<html> ';
			$email_message .= '<head>';
			$email_message .= '</head>';
			$email_message .= '<body> ';
			$email_message .= "<p>Dear ".$user['first_name']." ".$user['last_name'].",</p>";
			$email_message .= '<p>Greetings from Factsuite!!</p>';
			$email_message .= '<p>Your OTP for Validating Email ID is :'.$login_otp.'</p>';
			$email_message .= '<p><b>Yours sincerely,<br>';
			$email_message .= 'Team FactSuite</b></p>';
			$email_message .= '</body>';
			$email_message .= '</html>';

			$sent_email_to_candidate = $this->emailModel->send_mail($user['email_id'],$client_email_subject,$email_message);
			if($sent_email_to_candidate['status'] == 1) {
				$this->session->set_userdata('validate-email-id-otp',$login_otp);
				return array('status'=>'1','message'=>'OTP sent to registered email id.');
			} else {
				return array('status'=>'0','message'=>'Something went wrong while triggering mail. Please try again.');
			}
		} else {
			return array('status'=>'2','message'=>'Already Validated');
		}
	}

	function validate_to_email_id() {
		$user = $this->session->userdata('logged-in-candidate');
		$otp = $this->session->userdata('validate-email-id-otp');
		if ($user['email_id_validated_by_candidate_status'] == 0) {
			if ($this->input->post('otp') == $otp) {
				$this->session->unset_userdata('validate-email-id-otp');
				$user['email_id_validated_by_candidate_status'] = 1;
				$update_data = array(
					'email_id_validated_by_candidate_status' => 1,
					'email_id_validated_by_candidate_datetime' => date('Y-m-d H:s:i')
				);
				$this->db->where('candidate_id',$user['candidate_id'])->update('candidate',$update_data);
				return array('status'=>'1','message'=>'Email ID validated');
			} else {
				return array('status'=>'3','message'=>'Incorrect OTP entered');
			}
		} else {
			return array('status'=>'2','message'=>'Already Validated');
		}
	}


	function update_candidate_driving_licence($driving_licence){ 
	$user = $this->session->userdata('logged-in-candidate');
	if ($this->input->post('licence_id')) {
			$this->db->where('licence_id',$this->input->post('licence_id'));
			$data = $this->db->get('driving_licence')->row_array();
			$status = $data['status'];
			$analyst_status = $data['analyst_status'];
	}
	$status = isset($candidate_status)?$candidate_status:1;
		$an = isset($analyst)?$analyst:0;
		if ($status =='3' || $an =='3') {
			$status = 1;
			$an = 0;
		}
	$licence_data = array(
		'licence_number' => $this->input->post('driving_licence_number'),
		'candidate_id'=>$user['candidate_id'],
		'status'=>$status,
		'analyst_status'=>$an,
	);
	if (! in_array('no-file', $driving_licence)) {
		$licence_data['licence_doc'] = implode(',', $driving_licence);
	}

	$result = '';
	$table = $this->db->where('candidate_id',$user['candidate_id'])->get('driving_licence')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('licence_id')) {
			// $this->db->where('licence_id',$this->input->post('licence_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('driving_licence',$licence_data);

			$insert_id = $this->input->post('licence_id');
		}else{
			$result = $this->db->insert('driving_licence',$licence_data);
			$insert_id = $this->db->insert_id();
		} 


		if ($result == true) {

		// if ( $this->db->insert('previous_address',$present_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}

	}

	function update_candidate_cv_check($cv){
/*SELECT `licence_id`, `licence_number`, `licence_doc`, `analyst_status`, `status`, `output_status`, `assigned_role`, `assigned_team_id`, `created_date`, `updated_date`, `insuff_status` FROM `driving_licence` WHERE 1*/
$user = $this->session->userdata('logged-in-candidate');
if ($this->input->post('cv_id')) {
			$this->db->where('cv_id',$this->input->post('cv_id'));
			$data = $this->db->get('cv_check')->row_array();
			$status = $data['status'];
			$analyst_status = $data['analyst_status'];
	}

	$status1 = isset($status)?$status:1;
	$analyst_status1 = isset($analyst_status)?$analyst_status:0;
	if ($analyst_status1 =='3' || $status1 == '3') {
		$analyst_status1 = 0;
		$status1 = 1;
	}
	$cv_check = array( 
		'candidate_id'=>$user['candidate_id'],
		'status'=>$status1,
		'analyst_status'=>$analyst_status1
	);
	if (! in_array('no-file', $cv)) {
		$cv_check['cv_doc'] = implode(',', $cv);
	}

	$result = '';
	$table = $this->db->where('candidate_id',$user['candidate_id'])->get('cv_check')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('cv_id')) {
			// $this->db->where('cv_id',$this->input->post('cv_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('cv_check',$cv_check);

			$insert_id = $this->input->post('cv_id');
		}else{
			$result = $this->db->insert('cv_check',$cv_check);
			$insert_id = $this->db->insert_id();
		} 


		if ($result == true) {
 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}

	}


	function update_candidate_credit_cibil($credit_cibils){
		// return $credit_cibil;

		$user = $this->session->userdata('logged-in-candidate');

		$number = json_decode($this->input->post('credit_cibil_number'),true);

		$credit = $this->db->where('candidate_id',$user['candidate_id'])->get('credit_cibil')->row_array(); 
		$status = array();
		$analyst_status = array(); 
		$credit_status = explode(',', isset($credit['status'])?$credit['status']:1);
		$credit_analyst_status = explode(',', isset($credit['analyst_status'])?$credit['analyst_status']:0);

		 for ($i=0; $i < count($number); $i++) {  
			$analys_status = isset($credit_analyst_status[$i])?$credit_analyst_status[$i]:0;
			if ($analys_status =='3' || $credit_status =='3') {
				array_push($analyst_status, 0);	
				array_push($status, 1);	
			}else{
				array_push($analyst_status, $analys_status);
				array_push($status, isset($credit_status[$i])?$credit_status[$i]:1);
			}
		} 

		$credit_count = explode(',', $this->input->post('credit_count'));
		$credit_cibil = array(
		'credit_number' => $this->input->post('credit_cibil_number'),
		'document_type' => $this->input->post('document_type'),
		'credit_country' => $this->input->post('country'),
		'credit_state' => $this->input->post('state'),
		'credit_city' => $this->input->post('city'),
		'credit_pincode' => $this->input->post('pincode'),
		'credit_address' => $this->input->post('address'),
		'status'=>implode(',', $status),
		'candidate_id'=>$user['candidate_id'],
		'analyst_status'=>implode(',', $analyst_status),
	);
 

			$credit_cibil_array = array();
			$j=0;
		if (count($credit_count) > 0) {
		foreach ($credit_count as $key => $value) {
			if ($value == '1') {
				array_push($credit_cibil_array, $credit_cibils[$j]);
				$j++;
			}else{
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($credit_cibil_array,array('no-file'));
			}
		}
		}
	if (! in_array('no-file', $credit_cibil)) {
		$credit_cibil['credit_cibil_doc'] = json_encode($credit_cibil_array);
	}

		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('credit_cibil')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('credit_id') !=null && $this->input->post('credit_id') !='undefined') {
			// $this->db->where('credit_id',$this->input->post('credit_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('credit_cibil',$credit_cibil);

			$insert_id = $this->input->post('credit_id');
		}else{
			$result = $this->db->insert('credit_cibil',$credit_cibil);
			$insert_id = $this->db->insert_id();
		} 


		if ($result == true) {
 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_candidate_bankruptcy($bankruptcy_doc){
		$user = $this->session->userdata('logged-in-candidate');

		$bankruptcy_count = explode(',', $this->input->post('bankruptcy_count'));


		$number = json_decode($this->input->post('bankruptcy_number'),true);

		$bankruptcy_data = $this->db->where('candidate_id',$user['candidate_id'])->get('bankruptcy')->row_array(); 
		$status = array();
		$analyst_status = array(); 
		$credit_status = explode(',', isset($bankruptcy_data['status'])?$bankruptcy_data['status']:1);
		$credit_analyst_status = explode(',', isset($bankruptcy_data['analyst_status'])?$bankruptcy_data['analyst_status']:0);

		 for ($i=0; $i < count($number); $i++) {  
		 	$analys_status = isset($credit_analyst_status[$i])?$credit_analyst_status[$i]:0;
			if ($analys_status =='3' || $credit_status =='3') {
				array_push($analyst_status, 0);	
				array_push($status, 1);	
			}else{
				array_push($analyst_status, $analys_status);
				array_push($status, isset($credit_status[$i])?$credit_status[$i]:1);
			}
		} 

		// $user = $this->session->userdata('logged-in-candidate');
		$bankruptcy = array(
		'bankruptcy_number' => $this->input->post('bankruptcy_number'),
		'document_type' => $this->input->post('document_type'),
		'candidate_id'=>$user['candidate_id'],
		'status'=>implode(',',$status),
		'analyst_status'=>implode(',',$analyst_status),
		);
 

			$bankruptcy_doc_array = array();
			$j=0;
		if (count($bankruptcy_count) > 0) {
		foreach ($bankruptcy_count as $key => $value) {
			if ($value == '1') {
				array_push($bankruptcy_doc_array, $bankruptcy_doc[$j]);
				$j++;
			}else{
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($bankruptcy_doc_array,array('no-file'));
			}
		}
		}
		if (! in_array('no-file', $bankruptcy_doc)) {
			$bankruptcy['bankruptcy_doc'] = json_encode($bankruptcy_doc_array);
		}
 

		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('bankruptcy')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('bankruptcy_id') !=null && $this->input->post('bankruptcy_id') !='undefined') {
			// $this->db->where('bankruptcy_id',$this->input->post('bankruptcy_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('bankruptcy',$bankruptcy); 
			$insert_id = $this->input->post('bankruptcy_id');
		}else{
			$result = $this->db->insert('bankruptcy',$bankruptcy);
			$insert_id = $this->db->insert_id();
		} 


		if ($result == true) {
 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


// for the insuff 


	function update_candidate_criminal_check_insuff(){ 
		// return $_POST;
		$user = $this->session->userdata('logged-in-candidate');
		$address = json_decode($this->input->post('address'),true);
		$data = $this->db->where('criminal_check_id',$this->input->post('criminal_checks_id'))->get('criminal_checks')->row_array();
		$status = array();
		$analyst_status = array();
		/*for ($i=0; $i < count($address); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
		}*/

		$candidate_status = explode(',', isset($data['status'])?$data['status']:'1');

		foreach (explode(',', isset($data['analyst_status'])?$data['analyst_status']:'0') as $key => $value) {
			if ($value =='3') {
				array_push($analyst_status, 0);	
				array_push($status, 1);	
			}else{
				array_push($analyst_status, $value);
				array_push($status, $candidate_status[$key]);
			}
		}

		$criminal_data = array(
			'candidate_id'=>$user['candidate_id'],
			'address'=>$this->input->post('address'),
			'pin_code'=>$this->input->post('pincode'),
			'city'=>$this->input->post('city'),
			'state'=>$this->input->post('state'),
			'country'=>$this->input->post('country'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			/*'insuff_status'=>implode(',', $analyst_status),
			'output_status'=>implode(',', $analyst_status),*/
		);
 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('criminal_checks')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('criminal_checks_id')) {
			// $this->db->where('criminal_check_id',$this->input->post('criminal_checks_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('criminal_checks',$criminal_data);

			$insert_id = $this->input->post('criminal_check_id');
		}else{
			$result = $this->db->insert('criminal_checks',$criminal_data);
			$insert_id = $this->db->insert_id();
		}
 
		if ($result ==true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}

	/* insuff court record */


	function update_candidate_court_record_insuff(){ 
		$user = $this->session->userdata('logged-in-candidate');
		$address = json_decode($this->input->post('address'),true);
		$data = $this->db->where('court_records_id',$this->input->post('court_records_id'))->get('court_records')->row_array();
		$status = array();
		$analyst_status = array();
		/*for ($i=0; $i < count($address); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
		}*/

		$court_status = explode(',', isset($data['status'])?$data['status']:'1');

		foreach (explode(',', isset($data['analyst_status'])?$data['analyst_status']:'0') as $key => $value) {
			if ($value =='3') {
				array_push($analyst_status, 0);	
				array_push($status, 1);	
			}else{
				array_push($analyst_status, $value);
				array_push($status, $court_status[$key]);
			}
		}
		$court_data = array(
			'candidate_id'=>$user['candidate_id'],
			'address'=>$this->input->post('address'),
			'pin_code'=>$this->input->post('pincode'),
			'city'=>$this->input->post('city'),
			'state'=>$this->input->post('state'),
			'country'=>$this->input->post('country'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			// 'insuff_status'=>implode(',', $analyst_status),
			// 'output_status'=>implode(',', $analyst_status),
		);

	$result = '';
	$table = $this->db->where('candidate_id',$user['candidate_id'])->get('court_records')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('court_records_id')) {
			// $this->db->where('court_records_id',$this->input->post('court_records_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('court_records',$court_data);

			$insert_id = $this->input->post('court_records_id');
		}else{
			$result = $this->db->insert('court_records',$court_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


/**/
	
	function update_candidate_drug_test_insuff(){ 
		$user = $this->session->userdata('logged-in-candidate');
		$address = json_decode($this->input->post('address'),true);
		$data = $this->db->where('drugtest_id',$this->input->post('drugtest_id'))->get('drugtest')->row_array();
		$status = array();
		$analyst_status = array();
		/*for ($i=0; $i < count($address); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
		}*/

		$drug_status = explode(',', isset($data['status'])?$data['status']:'1');

		foreach (explode(',', isset($data['analyst_status'])?$data['analyst_status']:'0') as $key => $value) {
			if ($value =='3') {
				array_push($analyst_status, 0);	
				array_push($status, 1);	
			}else{
				array_push($analyst_status, $value);
				array_push($status, $drug_status[$key]);
			}
		}
		$drugtest = array(
			'candidate_id'=>$user['candidate_id'],
			'address'=>$this->input->post('address'),
			'candidate_name'=>$this->input->post('name'),
			'father__name'=>$this->input->post('father_name'),
			'dob'=>$this->input->post('date_of_birth'),
			'mobile_number'=>$this->input->post('contact_no'),
			'code'=>$this->input->post('code'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			// 'insuff_status'=>implode(',', $analyst_status),
			// 'output_status'=>implode(',', $analyst_status),
		);
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('drugtest')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('drugtest_id')) {
			// $this->db->where('drugtest_id',$this->input->post('drugtest_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('drugtest',$drugtest);

			$insert_id = $this->input->post('drugtest_id');
		}else{
			$result = $this->db->insert('drugtest',$drugtest);
			$insert_id = $this->db->insert_id();
		}


		if ($result == true) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}		
	}

		function update_candidate_document_check_insuff($candidate_aadhar,$candidate_pan,$candidate_proof,$candidate_voter,$candidate_ssn){ 
		$user = $this->session->userdata('logged-in-candidate');
		$data = $this->db->where('document_check_id',$this->input->post('document_check_id'))->get('document_check')->row_array();
		$status = array();
		$analyst_status = array();
		/*for ($i=0; $i < count($address); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
		}*/

		$document_status = explode(',', $data['status']);

		foreach (explode(',', $data['analyst_status']) as $key => $value) {
			if ($value =='3') {
				array_push($analyst_status, 0);	
				array_push($status, 1);	
			}else{
				array_push($analyst_status, $value);
				array_push($status, $document_status[$key]);
			}
		}
		$document_data = array(
			'candidate_id'=>$user['candidate_id'],
			'pan_number'=>$this->input->post('pan_number'),
			'passport_number'=>$this->input->post('passport_number'), 
			'aadhar_number'=>$this->input->post('aadhar_number'), 
			'ssn_number'=>$this->input->post('ssn_number'), 
			'voter_id'=>$this->input->post('voter_id'), 
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			// 'insuff_status'=>implode(',', $analyst_status),
			// 'output_status'=>implode(',', $analyst_status),
		);
		if (!in_array('no-file', $candidate_proof)) {
			$document_data['passport_doc'] = implode(',', $candidate_proof);
		}
		if (!in_array('no-file', $candidate_pan)) {
			$document_data['pan_card_doc'] = implode(',', $candidate_pan);
		}
		if (!in_array('no-file', $candidate_aadhar)) {
			$document_data['adhar_doc'] = implode(',', $candidate_aadhar);
		} 
		if (!in_array('no-file', $candidate_voter)) {
			$document_data['voter_doc'] = implode(',', $candidate_voter);
		} 
		if (!in_array('no-file', $candidate_ssn)) {
			$document_data['ssn_doc'] = implode(',', $candidate_ssn);
		} 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('document_check')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('document_check_id')) {
			// $this->db->where('document_check_id',$this->input->post('document_check_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('document_check',$document_data);

			$insert_id = $this->input->post('document_check_id');
		}else{
			$result = $this->db->insert('document_check',$document_data);
			$insert_id = $this->db->insert_id();
		}
		if ($result == true) {
		// if ($this->db->insert('document_check',$criminal_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}		
	}





	/**/


	function update_candidate_previous_address_insuff($candidate_rental,$candidate_ration,$candidate_gov){
		$user = $this->session->userdata('logged-in-candidate');
		$permenent_house = json_decode($this->input->post('permenent_house'),true);
		$data = $this->db->where('previos_address_id',$this->input->post('previos_address_id'))->get('previous_address')->row_array();
		$status = array();
		$analyst_status = array();
		/*for ($i=0; $i < count($address); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
		}*/

		$document_status = explode(',', $data['status']);

		foreach (explode(',', $data['analyst_status']) as $key => $value) {
			if ($value =='3') {
				array_push($analyst_status, 0);	
				array_push($status, 1);	
			}else{
				array_push($analyst_status, $value);
				array_push($status, $document_status[$key]);
			}
		}
 
		$rental_agreement = explode(',', $this->input->post('rental_agreement'));
		$db_appointment = json_decode($data['rental_agreement'],true);
		$j = 0;
		$rental_agreement_array = array();
		foreach ($rental_agreement as $key => $value) {
			if ($value == '1') {
				array_push($rental_agreement_array, $candidate_rental[$j]);
				$j++;
			}else{ 
				array_push($rental_agreement_array, isset($db_appointment[$key])?$db_appointment[$key]:array('no-file'));
			}
		}
		$ration_card = explode(',', $this->input->post('ration_card'));
		$db_experience = json_decode($data['ration_card'],true);
		$j = 0;
		$ration_card_array = array();
		foreach ($ration_card as $key => $value) {
			if ($value == '1') {
				array_push($ration_card_array, $candidate_ration[$j]);
				$j++;
			}else{
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($ration_card_array, isset($db_experience[$key])?$db_experience[$key]:array('no-file'));
			}
		}

		$gov_utility_bill = explode(',', $this->input->post('gov_utility_bill'));
		$db_last_month = json_decode($data['gov_utility_bill'],true);
		$j = 0;
		$gov_utility_bill_array = array();
		foreach ($gov_utility_bill as $key => $value) {
			if ($value == '1') {
				array_push($gov_utility_bill_array, $candidate_gov[$j]);
				$j++;
			}else{
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($gov_utility_bill_array, isset($db_last_month[$key])?$db_last_month[$key]:array('no-file'));
			}
		}
 
		$present_data = array(
			'candidate_id'=>$user['candidate_id'],
			'flat_no'=>$this->input->post('permenent_house'),
			'street'=>$this->input->post('permenent_street'),
			'area'=>$this->input->post('permenent_area'),
			'city'=>$this->input->post('permenent_city'),
			'pin_code'=>$this->input->post('permenent_pincode'),
			'state'=>$this->input->post('state'),
			'country'=>$this->input->post('country'),
			'nearest_landmark'=>$this->input->post('permenent_land_mark'),
			'duration_of_stay_start'=>$this->input->post('permenent_start_date'),
			'duration_of_stay_end'=>$this->input->post('permenent_end_date'),
			'is_present'=>$this->input->post('permenent_present'),
			'contact_person_name'=>$this->input->post('permenent_name'),
			'contact_person_relationship'=>$this->input->post('permenent_relationship'),
			'contact_person_mobile_number'=> $this->input->post('permenent_contact_no'),
			'code'=> $this->input->post('code'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			// 'insuff_status'=>implode(',', $analyst_status),
			// 'output_status'=>implode(',', $analyst_status),
		); 

		if (!in_array('no-file', $rental_agreement_array)) {
			$present_data['rental_agreement'] = json_encode($rental_agreement_array);
		}
		if (!in_array('no-file', $ration_card_array)) {
			$present_data['ration_card'] = json_encode($ration_card_array);
		}
		if (!in_array('no-file', $gov_utility_bill_array)) {
			$present_data['gov_utility_bill'] = json_encode($gov_utility_bill_array);
		} 

		/*candidate_rental
candidate_ration
candidate_gov*/
	$result = '';
	$table = $this->db->where('candidate_id',$user['candidate_id'])->get('previous_address')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('previos_address_id')) {
			// $this->db->where('previos_address_id',$this->input->post('previos_address_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('previous_address',$present_data);

			$insert_id = $this->input->post('previos_address_id');
		}else{
			$result = $this->db->insert('previous_address',$present_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {

		// if ( $this->db->insert('previous_address',$present_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


		function update_candidate_education_details_insuff($all_sem_marksheet,$convocation,$marksheet_provisional_certificate,$ten_twelve_mark_card_certificate){ 
		
		 
		$user = $this->session->userdata('logged-in-candidate');
		$degree = json_decode($this->input->post('type_of_degree'),true);
		$data = $this->db->where('education_details_id',$this->input->post('education_details_id'))->get('education_details')->row_array();
		$status = array();
		$analyst_status = array();
		
		$document_status = explode(',', $data['status']);

		foreach (explode(',', $data['analyst_status']) as $key => $value) {
			if ($value =='3') {
				array_push($analyst_status, 0);	
				array_push($status, 1);	
			}else{
				array_push($analyst_status, $value);
				array_push($status, $document_status[$key]);
			}
		}
 
		$all_sem = explode(',', $this->input->post('all_sem'));
		$db_all_sem = json_decode($data['all_sem_marksheet'],true);
		$j = 0;
		$n = 0;
		$all_sem_marksheet_array = array();
		foreach ($degree as $key => $value) {

			if (in_array($value['type_of_degree'],array('10th','12th','Certification'))) {
				array_push($all_sem_marksheet_array,array('no-file'));
			}else{
				if ($all_sem[$n] == '1') {
				array_push($all_sem_marksheet_array, isset($all_sem_marksheet[$j])?$all_sem_marksheet[$j]:array('no-file'));
				$j++;
			}else{ 
				array_push($all_sem_marksheet_array, isset($db_all_sem[$key])?$db_all_sem[$key]:array('no-file'));
			}
			$n++;
			}
			
		}
		$convocations = explode(',', $this->input->post('convocations'));
		$db_convocations = json_decode($data['convocation'],true);
		$j = 0;
		$n = 0;
		$convocation_array = array();
		foreach ($degree as $key => $value) {

			if (in_array($value['type_of_degree'],array('10th','12th','Certification'))) {
				array_push($convocation_array,array('no-file'));
			}else{

			if ($convocations[$n] == '1') {
				array_push($convocation_array, isset($convocation[$j])?$convocation[$j]:array('no-file'));
				$j++;
			}else{
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($convocation_array, isset($db_convocations[$key])?$db_convocations[$key]:array('no-file'));
			}
			$n++;
			}
		}

		$marksheet = explode(',', $this->input->post('marksheet'));
		$db_marksheet = json_decode($data['marksheet_provisional_certificate'],true);
		$j = 0;
		$n = 0;
		$marksheet_provisional_certificate_array = array();
		foreach ($degree as $key => $value) {
			if (in_array($value['type_of_degree'],array('10th','12th','Certification'))) {
				array_push($marksheet_provisional_certificate_array, array('no-file'));
			}else{

			if ($marksheet[$n] == '1') {
				array_push($marksheet_provisional_certificate_array, isset($marksheet_provisional_certificate[$j])?$marksheet_provisional_certificate[$j]:array('no-file'));
				$j++;
			}else{
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($marksheet_provisional_certificate_array, isset($db_marksheet[$key])?$db_marksheet[$key]:array('no-file'));
			}
			$n++;
			}
		}


		$ten_twelve = explode(',', $this->input->post('ten_twelve'));
		$db_ten_twelve = json_decode($data['ten_twelve_mark_card_certificate'],true);
		$j = 0;
		$ten_twelve_mark_card_certificate_array = array();
		foreach ($ten_twelve as $key => $value) {
			if ($value == '1') {
				array_push($ten_twelve_mark_card_certificate_array, isset($ten_twelve_mark_card_certificate[$j])?$ten_twelve_mark_card_certificate[$j]:array('no-file'));
				$j++;
			}else{
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($ten_twelve_mark_card_certificate_array, isset($db_ten_twelve[$key])?$db_ten_twelve[$key]:array('no-file'));
			}
		}


 

		$eduction_data = array(
			'candidate_id'=>$user['candidate_id'],
			'type_of_degree'=>$this->input->post('type_of_degree'),
			'major'=>$this->input->post('major'),
			'university_board'=>$this->input->post('university'),
			'college_school'=>$this->input->post('college_name'),
			'address_of_college_school'=>$this->input->post('address'),
			'registration_roll_number'=>$this->input->post('registration_roll_number'), 
			'course_start_date'=>$this->input->post('duration_of_stay'),
			'course_end_date'=>$this->input->post('duration_of_course'),
			/*'course_start_date'=>json_encode($start_year_month),
			'course_end_date'=>json_encode($end_year_month), */ 
			'type_of_course'=>$this->input->post('time'),   
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			// 'insuff_status'=>implode(',', $analyst_status),
			// 'output_status'=>implode(',', $analyst_status),
		);

		if (!in_array('no-file', $all_sem_marksheet_array)) {
			$eduction_data['all_sem_marksheet'] = json_encode($all_sem_marksheet_array);
		}if (!in_array('no-file', $convocation_array)) {
			$eduction_data['convocation'] = json_encode($convocation_array);
		}if (!in_array('no-file', $marksheet_provisional_certificate_array)) {
			$eduction_data['marksheet_provisional_certificate'] = json_encode($marksheet_provisional_certificate_array);
		}if (!in_array('no-file', $ten_twelve_mark_card_certificate_array)) {
			$eduction_data['ten_twelve_mark_card_certificate'] = json_encode($ten_twelve_mark_card_certificate_array);
		}
 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('education_details')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('education_details_id')) {
			// $this->db->where('education_details_id',$this->input->post('education_details_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('education_details',$eduction_data);

			$insert_id = $this->input->post('education_details_id');
		}else{
			$result = $this->db->insert('education_details',$eduction_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
		// if ($this->db->insert('education_details',$eduction_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}


	function update_candidate_reference_insuff(){ 

		$user = $this->session->userdata('logged-in-candidate');

			$name = explode(',',$this->input->post('name'));
		$data = $this->db->where('reference_id',$this->input->post('reference_id'))->get('reference')->row_array();
		$status = array();
		$analyst_status = array();
		/*for ($i=0; $i < count($address); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
		}*/

		$education_status = explode(',', $data['status']);

		foreach (explode(',', $data['analyst_status']) as $key => $value) {
			if ($value =='3') {
				array_push($analyst_status, 0);	
				array_push($status, 1);	
			}else{
				array_push($analyst_status, $value);
				array_push($status, $education_status[$key]);
			}
		}
		$reference_data = array(
			'candidate_id'=>$user['candidate_id'],
			'name'=>$this->input->post('name'),
			'company_name'=>$this->input->post('company_name'),
			'designation'=>$this->input->post('designation'),
			'contact_number'=>$this->input->post('contact'),
			'code'=>$this->input->post('code'),
			'email_id'=>$this->input->post('email'),
			'years_of_association'=>$this->input->post('association'),
			'contact_start_time'=>$this->input->post('start_date'),
			'contact_end_time'=>$this->input->post('end_date'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			// 'insuff_status'=>implode(',', $analyst_status),
			// 'output_status'=>implode(',', $analyst_status),
		);


	$result = '';
	$table = $this->db->where('candidate_id',$user['candidate_id'])->get('reference')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('reference_id')) {
			// $this->db->where('reference_id',$this->input->post('reference_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('reference',$reference_data);

			$insert_id = $this->input->post('reference_id');
		}else{
			$result = $this->db->insert('reference',$reference_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {

		// if ($this->db->insert('reference',$reference_data)) {
		$reference_log_data = array(
			'reference_id'=>$insert_id,
			'candidate_id'=>$user['candidate_id'],
			'name'=>$this->input->post('name'),
			'company_name'=>$this->input->post('company_name'),
			'designation'=>$this->input->post('designation'),
			'contact_number'=>$this->input->post('contact'),
			'code'=>$this->input->post('code'),
			'email_id'=>$this->input->post('email'),
			'years_of_association'=>$this->input->post('association'),
			'contact_start_time'=>$this->input->post('start_date'),
			'contact_end_time'=>$this->input->post('end_date'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			// 'insuff_status'=>implode(',', $data['insuff_status']),
			// 'output_status'=>implode(',', $data['output_status']),
		);	
		$this->db->insert('reference_log',$reference_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}




	function update_candidate_previous_employment_insuff($appointment_letter,$experience_relieving_letter,$last_month_pay_slip,$bank_statement_resigngation_acceptance){


/*

*/

	$user = $this->session->userdata('logged-in-candidate');
	$designation = json_decode($this->input->post('designation'),true);
	$employment = $this->db->where('previous_emp_id',$this->input->post('previous_emp_id'))->get('previous_employment')->row_array(); 
		$status = array();
		$analyst_status = array();
		/*for ($i=0; $i < count($address); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
		}*/

		$education_status = explode(',', $employment['status']);

		foreach (explode(',', $employment['analyst_status']) as $key => $value) {
			if ($value =='3') {
				array_push($analyst_status, 0);	
				array_push($status, 1);	
			}else{
				array_push($analyst_status, $value);
				array_push($status, $education_status[$key]);
			}
		} 

		$appointment = explode(',', $this->input->post('appointment'));
		$db_appointment = json_decode($employment['appointment_letter'],true);
		$j = 0;
		$appointment_letter_array = array();
		foreach ($appointment as $key => $value) {
			if ($value == '1') {
				array_push($appointment_letter_array, isset($appointment_letter[$j])?$appointment_letter[$j]:array('no-file'));
				$j++;
			}else{ 
				array_push($appointment_letter_array, isset($db_appointment[$key])?$db_appointment[$key]:array('no-file'));
			}
		}
		$last_month = explode(',', $this->input->post('last_month'));
		$db_experience = json_decode($employment['last_month_pay_slip'],true);
		$j = 0;
		$last_month_pay_slip_array = array();
		foreach ($last_month as $key => $value) {
			if ($value == '1') {
				array_push($last_month_pay_slip_array, isset($last_month_pay_slip[$j])?$last_month_pay_slip[$j]:array('no-file'));
				$j++;
			}else{
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($last_month_pay_slip_array, isset($db_experience[$key])?$db_experience[$key]:array('no-file'));
			}
		}

		$bank_statement = explode(',', $this->input->post('bank_statement'));
		$db_last_month = json_decode($employment['bank_statement_resigngation_acceptance'],true);
		$j = 0;
		$bank_statement_resigngation_acceptance_array = array();
		foreach ($bank_statement as $key => $value) {
			if ($value == '1') {
				array_push($bank_statement_resigngation_acceptance_array, isset($bank_statement_resigngation_acceptance[$j])?$bank_statement_resigngation_acceptance[$j]:array('no-file'));
				$j++;
			}else{
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($bank_statement_resigngation_acceptance_array, isset($db_last_month[$key])?$db_last_month[$key]:array('no-file'));
			}
		}

		$experience = explode(',', $this->input->post('experience'));
		$db_bank_statement = json_decode($employment['experience_relieving_letter'],true);
		$j = 0;
		$experience_relieving_letter_array = array();
		foreach ($experience as $key => $value) {
			if ($value == '1') {
				array_push($experience_relieving_letter_array, isset($experience_relieving_letter[$j])?$experience_relieving_letter[$j]:array('no-file'));
				$j++;
			}else{
				// echo isset($db_appointment[$key])?$db_appointment[$key]:'no-file';
				array_push($experience_relieving_letter_array, isset($db_bank_statement[$key])?$db_bank_statement[$key]:array('no-file'));
			}
		}
		/*echo json_encode($appointment_letter_array);
		die();*/
		$employment_data = array(
			'candidate_id'=>$user['candidate_id'],
			'desigination'=>$this->input->post('designation'), 
			'department'=>$this->input->post('department'), 
			'employee_id'=>$this->input->post('employee_id'), 
			'company_name'=>$this->input->post('company_name'), 
			'address'=>$this->input->post('address'), 
			'annual_ctc'=>$this->input->post('annual_ctc'), 
			'reason_for_leaving'=>$this->input->post('reasion'), 
			'joining_date'=>$this->input->post('joining_date'), 
			'relieving_date'=>$this->input->post('relieving_date'), 
			'reporting_manager_name'=>$this->input->post('manager_name'), 
			'reporting_manager_desigination'=>$this->input->post('manager_designation'), 
			'reporting_manager_contact_number'=>$this->input->post('manager_contact'), 
			'code'=>$this->input->post('code'), 
			'hr_name'=>$this->input->post('hr_name'),
			'hr_contact_number'=>$this->input->post('hr_contact'),
			'hr_code'=>$this->input->post('hr_code'),
			'status'=>implode(',', $status),
			'company_url'=>$this->input->post('company_url'),
			'analyst_status'=>implode(',', $analyst_status),
			// 'insuff_status'=>implode(',', $analyst_status),
			// 'output_status'=>implode(',', $analyst_status),
		);

		if (!in_array('no-file', $appointment_letter_array)) {
			$employment_data['appointment_letter'] = json_encode($appointment_letter_array);
		}if (!in_array('no-file', $experience_relieving_letter_array)) {
			$employment_data['experience_relieving_letter'] = json_encode($experience_relieving_letter_array);
		}if (!in_array('no-file', $last_month_pay_slip_array)) {
			$employment_data['last_month_pay_slip'] = json_encode($last_month_pay_slip_array);
		}if (!in_array('no-file', $bank_statement_resigngation_acceptance_array)) {
			$employment_data['bank_statement_resigngation_acceptance'] = json_encode($bank_statement_resigngation_acceptance_array);
		}


		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('previous_employment')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('previous_emp_id')) {
			// $this->db->where('previous_emp_id',$this->input->post('previous_emp_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('previous_employment',$employment_data);

			$insert_id = $this->input->post('previous_emp_id');
		}else{
			$result = $this->db->insert('previous_employment',$employment_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
		// if ($this->db->insert('previous_employment',$employment_data)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}


	}







 


	function country_code(){
		return '{
	  "countries": [
	   {
	      "code": "+91",
	      "name": "India"
	    },
	    {
	      "code": "+7 840",
	      "name": "Abkhazia"
	    },
	    {
	      "code": "+93",
	      "name": "Afghanistan"
	    },
	    {
	      "code": "+355",
	      "name": "Albania"
	    },
	    {
	      "code": "+213",
	      "name": "Algeria"
	    },
	    {
	      "code": "+1 684",
	      "name": "American Samoa"
	    },
	    {
	      "code": "+376",
	      "name": "Andorra"
	    },
	    {
	      "code": "+244",
	      "name": "Angola"
	    },
	    {
	      "code": "+1 264",
	      "name": "Anguilla"
	    },
	    {
	      "code": "+1 268",
	      "name": "Antigua and Barbuda"
	    },
	    {
	      "code": "+54",
	      "name": "Argentina"
	    },
	    {
	      "code": "+374",
	      "name": "Armenia"
	    },
	    {
	      "code": "+297",
	      "name": "Aruba"
	    },
	    {
	      "code": "+247",
	      "name": "Ascension"
	    },
	    {
	      "code": "+61",
	      "name": "Australia"
	    },
	    {
	      "code": "+672",
	      "name": "Australian External Territories"
	    },
	    {
	      "code": "+43",
	      "name": "Austria"
	    },
	    {
	      "code": "+994",
	      "name": "Azerbaijan"
	    },
	    {
	      "code": "+1 242",
	      "name": "Bahamas"
	    },
	    {
	      "code": "+973",
	      "name": "Bahrain"
	    },
	    {
	      "code": "+880",
	      "name": "Bangladesh"
	    },
	    {
	      "code": "+1 246",
	      "name": "Barbados"
	    },
	    {
	      "code": "+1 268",
	      "name": "Barbuda"
	    },
	    {
	      "code": "+375",
	      "name": "Belarus"
	    },
	    {
	      "code": "+32",
	      "name": "Belgium"
	    },
	    {
	      "code": "+501",
	      "name": "Belize"
	    },
	    {
	      "code": "+229",
	      "name": "Benin"
	    },
	    {
	      "code": "+1 441",
	      "name": "Bermuda"
	    },
	    {
	      "code": "+975",
	      "name": "Bhutan"
	    },
	    {
	      "code": "+591",
	      "name": "Bolivia"
	    },
	    {
	      "code": "+387",
	      "name": "Bosnia and Herzegovina"
	    },
	    {
	      "code": "+267",
	      "name": "Botswana"
	    },
	    {
	      "code": "+55",
	      "name": "Brazil"
	    },
	    {
	      "code": "+246",
	      "name": "British Indian Ocean Territory"
	    },
	    {
	      "code": "+1 284",
	      "name": "British Virgin Islands"
	    },
	    {
	      "code": "+673",
	      "name": "Brunei"
	    },
	    {
	      "code": "+359",
	      "name": "Bulgaria"
	    },
	    {
	      "code": "+226",
	      "name": "Burkina Faso"
	    },
	    {
	      "code": "+257",
	      "name": "Burundi"
	    },
	    {
	      "code": "+855",
	      "name": "Cambodia"
	    },
	    {
	      "code": "+237",
	      "name": "Cameroon"
	    },
	    {
	      "code": "+1",
	      "name": "Canada"
	    },
	    {
	      "code": "+238",
	      "name": "Cape Verde"
	    },
	    {
	      "code": "+ 345",
	      "name": "Cayman Islands"
	    },
	    {
	      "code": "+236",
	      "name": "Central African Republic"
	    },
	    {
	      "code": "+235",
	      "name": "Chad"
	    },
	    {
	      "code": "+56",
	      "name": "Chile"
	    },
	    {
	      "code": "+86",
	      "name": "China"
	    },
	    {
	      "code": "+61",
	      "name": "Christmas Island"
	    },
	    {
	      "code": "+61",
	      "name": "Cocos-Keeling Islands"
	    },
	    {
	      "code": "+57",
	      "name": "Colombia"
	    },
	    {
	      "code": "+269",
	      "name": "Comoros"
	    },
	    {
	      "code": "+242",
	      "name": "Congo"
	    },
	    {
	      "code": "+243",
	      "name": "Congo, Dem. Rep. of (Zaire)"
	    },
	    {
	      "code": "+682",
	      "name": "Cook Islands"
	    },
	    {
	      "code": "+506",
	      "name": "Costa Rica"
	    },
	    {
	      "code": "+385",
	      "name": "Croatia"
	    },
	    {
	      "code": "+53",
	      "name": "Cuba"
	    },
	    {
	      "code": "+599",
	      "name": "Curacao"
	    },
	    {
	      "code": "+537",
	      "name": "Cyprus"
	    },
	    {
	      "code": "+420",
	      "name": "Czech Republic"
	    },
	    {
	      "code": "+45",
	      "name": "Denmark"
	    },
	    {
	      "code": "+246",
	      "name": "Diego Garcia"
	    },
	    {
	      "code": "+253",
	      "name": "Djibouti"
	    },
	    {
	      "code": "+1 767",
	      "name": "Dominica"
	    },
	    {
	      "code": "+1 809",
	      "name": "Dominican Republic"
	    },
	    {
	      "code": "+670",
	      "name": "East Timor"
	    },
	    {
	      "code": "+56",
	      "name": "Easter Island"
	    },
	    {
	      "code": "+593",
	      "name": "Ecuador"
	    },
	    {
	      "code": "+20",
	      "name": "Egypt"
	    },
	    {
	      "code": "+503",
	      "name": "El Salvador"
	    },
	    {
	      "code": "+240",
	      "name": "Equatorial Guinea"
	    },
	    {
	      "code": "+291",
	      "name": "Eritrea"
	    },
	    {
	      "code": "+372",
	      "name": "Estonia"
	    },
	    {
	      "code": "+251",
	      "name": "Ethiopia"
	    },
	    {
	      "code": "+500",
	      "name": "Falkland Islands"
	    },
	    {
	      "code": "+298",
	      "name": "Faroe Islands"
	    },
	    {
	      "code": "+679",
	      "name": "Fiji"
	    },
	    {
	      "code": "+358",
	      "name": "Finland"
	    },
	    {
	      "code": "+33",
	      "name": "France"
	    },
	    {
	      "code": "+596",
	      "name": "French Antilles"
	    },
	    {
	      "code": "+594",
	      "name": "French Guiana"
	    },
	    {
	      "code": "+689",
	      "name": "French Polynesia"
	    },
	    {
	      "code": "+241",
	      "name": "Gabon"
	    },
	    {
	      "code": "+220",
	      "name": "Gambia"
	    },
	    {
	      "code": "+995",
	      "name": "Georgia"
	    },
	    {
	      "code": "+49",
	      "name": "Germany"
	    },
	    {
	      "code": "+233",
	      "name": "Ghana"
	    },
	    {
	      "code": "+350",
	      "name": "Gibraltar"
	    },
	    {
	      "code": "+30",
	      "name": "Greece"
	    },
	    {
	      "code": "+299",
	      "name": "Greenland"
	    },
	    {
	      "code": "+1 473",
	      "name": "Grenada"
	    },
	    {
	      "code": "+590",
	      "name": "Guadeloupe"
	    },
	    {
	      "code": "+1 671",
	      "name": "Guam"
	    },
	    {
	      "code": "+502",
	      "name": "Guatemala"
	    },
	    {
	      "code": "+224",
	      "name": "Guinea"
	    },
	    {
	      "code": "+245",
	      "name": "Guinea-Bissau"
	    },
	    {
	      "code": "+595",
	      "name": "Guyana"
	    },
	    {
	      "code": "+509",
	      "name": "Haiti"
	    },
	    {
	      "code": "+504",
	      "name": "Honduras"
	    },
	    {
	      "code": "+852",
	      "name": "Hong Kong SAR China"
	    },
	    {
	      "code": "+36",
	      "name": "Hungary"
	    },
	    {
	      "code": "+354",
	      "name": "Iceland"
	    }, 
	    {
	      "code": "+62",
	      "name": "Indonesia"
	    },
	    {
	      "code": "+98",
	      "name": "Iran"
	    },
	    {
	      "code": "+964",
	      "name": "Iraq"
	    },
	    {
	      "code": "+353",
	      "name": "Ireland"
	    },
	    {
	      "code": "+972",
	      "name": "Israel"
	    },
	    {
	      "code": "+39",
	      "name": "Italy"
	    },
	    {
	      "code": "+225",
	      "name": "Ivory Coast"
	    },
	    {
	      "code": "+1 876",
	      "name": "Jamaica"
	    },
	    {
	      "code": "+81",
	      "name": "Japan"
	    },
	    {
	      "code": "+962",
	      "name": "Jordan"
	    },
	    {
	      "code": "+7 7",
	      "name": "Kazakhstan"
	    },
	    {
	      "code": "+254",
	      "name": "Kenya"
	    },
	    {
	      "code": "+686",
	      "name": "Kiribati"
	    },
	    {
	      "code": "+965",
	      "name": "Kuwait"
	    },
	    {
	      "code": "+996",
	      "name": "Kyrgyzstan"
	    },
	    {
	      "code": "+856",
	      "name": "Laos"
	    },
	    {
	      "code": "+371",
	      "name": "Latvia"
	    },
	    {
	      "code": "+961",
	      "name": "Lebanon"
	    },
	    {
	      "code": "+266",
	      "name": "Lesotho"
	    },
	    {
	      "code": "+231",
	      "name": "Liberia"
	    },
	    {
	      "code": "+218",
	      "name": "Libya"
	    },
	    {
	      "code": "+423",
	      "name": "Liechtenstein"
	    },
	    {
	      "code": "+370",
	      "name": "Lithuania"
	    },
	    {
	      "code": "+352",
	      "name": "Luxembourg"
	    },
	    {
	      "code": "+853",
	      "name": "Macau SAR China"
	    },
	    {
	      "code": "+389",
	      "name": "Macedonia"
	    },
	    {
	      "code": "+261",
	      "name": "Madagascar"
	    },
	    {
	      "code": "+265",
	      "name": "Malawi"
	    },
	    {
	      "code": "+60",
	      "name": "Malaysia"
	    },
	    {
	      "code": "+960",
	      "name": "Maldives"
	    },
	    {
	      "code": "+223",
	      "name": "Mali"
	    },
	    {
	      "code": "+356",
	      "name": "Malta"
	    },
	    {
	      "code": "+692",
	      "name": "Marshall Islands"
	    },
	    {
	      "code": "+596",
	      "name": "Martinique"
	    },
	    {
	      "code": "+222",
	      "name": "Mauritania"
	    },
	    {
	      "code": "+230",
	      "name": "Mauritius"
	    },
	    {
	      "code": "+262",
	      "name": "Mayotte"
	    },
	    {
	      "code": "+52",
	      "name": "Mexico"
	    },
	    {
	      "code": "+691",
	      "name": "Micronesia"
	    },
	    {
	      "code": "+1 808",
	      "name": "Midway Island"
	    },
	    {
	      "code": "+373",
	      "name": "Moldova"
	    },
	    {
	      "code": "+377",
	      "name": "Monaco"
	    },
	    {
	      "code": "+976",
	      "name": "Mongolia"
	    },
	    {
	      "code": "+382",
	      "name": "Montenegro"
	    },
	    {
	      "code": "+1664",
	      "name": "Montserrat"
	    },
	    {
	      "code": "+212",
	      "name": "Morocco"
	    },
	    {
	      "code": "+95",
	      "name": "Myanmar"
	    },
	    {
	      "code": "+264",
	      "name": "Namibia"
	    },
	    {
	      "code": "+674",
	      "name": "Nauru"
	    },
	    {
	      "code": "+977",
	      "name": "Nepal"
	    },
	    {
	      "code": "+31",
	      "name": "Netherlands"
	    },
	    {
	      "code": "+599",
	      "name": "Netherlands Antilles"
	    },
	    {
	      "code": "+1 869",
	      "name": "Nevis"
	    },
	    {
	      "code": "+687",
	      "name": "New Caledonia"
	    },
	    {
	      "code": "+64",
	      "name": "New Zealand"
	    },
	    {
	      "code": "+505",
	      "name": "Nicaragua"
	    },
	    {
	      "code": "+227",
	      "name": "Niger"
	    },
	    {
	      "code": "+234",
	      "name": "Nigeria"
	    },
	    {
	      "code": "+683",
	      "name": "Niue"
	    },
	    {
	      "code": "+672",
	      "name": "Norfolk Island"
	    },
	    {
	      "code": "+850",
	      "name": "North Korea"
	    },
	    {
	      "code": "+1 670",
	      "name": "Northern Mariana Islands"
	    },
	    {
	      "code": "+47",
	      "name": "Norway"
	    },
	    {
	      "code": "+968",
	      "name": "Oman"
	    },
	    {
	      "code": "+92",
	      "name": "Pakistan"
	    },
	    {
	      "code": "+680",
	      "name": "Palau"
	    },
	    {
	      "code": "+970",
	      "name": "Palestinian Territory"
	    },
	    {
	      "code": "+507",
	      "name": "Panama"
	    },
	    {
	      "code": "+675",
	      "name": "Papua New Guinea"
	    },
	    {
	      "code": "+595",
	      "name": "Paraguay"
	    },
	    {
	      "code": "+51",
	      "name": "Peru"
	    },
	    {
	      "code": "+63",
	      "name": "Philippines"
	    },
	    {
	      "code": "+48",
	      "name": "Poland"
	    },
	    {
	      "code": "+351",
	      "name": "Portugal"
	    },
	    {
	      "code": "+1 787",
	      "name": "Puerto Rico"
	    },
	    {
	      "code": "+974",
	      "name": "Qatar"
	    },
	    {
	      "code": "+262",
	      "name": "Reunion"
	    },
	    {
	      "code": "+40",
	      "name": "Romania"
	    },
	    {
	      "code": "+7",
	      "name": "Russia"
	    },
	    {
	      "code": "+250",
	      "name": "Rwanda"
	    },
	    {
	      "code": "+685",
	      "name": "Samoa"
	    },
	    {
	      "code": "+378",
	      "name": "San Marino"
	    },
	    {
	      "code": "+966",
	      "name": "Saudi Arabia"
	    },
	    {
	      "code": "+221",
	      "name": "Senegal"
	    },
	    {
	      "code": "+381",
	      "name": "Serbia"
	    },
	    {
	      "code": "+248",
	      "name": "Seychelles"
	    },
	    {
	      "code": "+232",
	      "name": "Sierra Leone"
	    },
	    {
	      "code": "+65",
	      "name": "Singapore"
	    },
	    {
	      "code": "+421",
	      "name": "Slovakia"
	    },
	    {
	      "code": "+386",
	      "name": "Slovenia"
	    },
	    {
	      "code": "+677",
	      "name": "Solomon Islands"
	    },
	    {
	      "code": "+27",
	      "name": "South Africa"
	    },
	    {
	      "code": "+500",
	      "name": "South Georgia and the South Sandwich Islands"
	    },
	    {
	      "code": "+82",
	      "name": "South Korea"
	    },
	    {
	      "code": "+34",
	      "name": "Spain"
	    },
	    {
	      "code": "+94",
	      "name": "Sri Lanka"
	    },
	    {
	      "code": "+249",
	      "name": "Sudan"
	    },
	    {
	      "code": "+597",
	      "name": "Suriname"
	    },
	    {
	      "code": "+268",
	      "name": "Swaziland"
	    },
	    {
	      "code": "+46",
	      "name": "Sweden"
	    },
	    {
	      "code": "+41",
	      "name": "Switzerland"
	    },
	    {
	      "code": "+963",
	      "name": "Syria"
	    },
	    {
	      "code": "+886",
	      "name": "Taiwan"
	    },
	    {
	      "code": "+992",
	      "name": "Tajikistan"
	    },
	    {
	      "code": "+255",
	      "name": "Tanzania"
	    },
	    {
	      "code": "+66",
	      "name": "Thailand"
	    },
	    {
	      "code": "+670",
	      "name": "Timor Leste"
	    },
	    {
	      "code": "+228",
	      "name": "Togo"
	    },
	    {
	      "code": "+690",
	      "name": "Tokelau"
	    },
	    {
	      "code": "+676",
	      "name": "Tonga"
	    },
	    {
	      "code": "+1 868",
	      "name": "Trinidad and Tobago"
	    },
	    {
	      "code": "+216",
	      "name": "Tunisia"
	    },
	    {
	      "code": "+90",
	      "name": "Turkey"
	    },
	    {
	      "code": "+993",
	      "name": "Turkmenistan"
	    },
	    {
	      "code": "+1 649",
	      "name": "Turks and Caicos Islands"
	    },
	    {
	      "code": "+688",
	      "name": "Tuvalu"
	    },
	    {
	      "code": "+1 340",
	      "name": "U.S. Virgin Islands"
	    },
	    {
	      "code": "+256",
	      "name": "Uganda"
	    },
	    {
	      "code": "+380",
	      "name": "Ukraine"
	    },
	    {
	      "code": "+971",
	      "name": "United Arab Emirates"
	    },
	    {
	      "code": "+44",
	      "name": "United Kingdom"
	    },
	    {
	      "code": "+1",
	      "name": "United States"
	    },
	    {
	      "code": "+598",
	      "name": "Uruguay"
	    },
	    {
	      "code": "+998",
	      "name": "Uzbekistan"
	    },
	    {
	      "code": "+678",
	      "name": "Vanuatu"
	    },
	    {
	      "code": "+58",
	      "name": "Venezuela"
	    },
	    {
	      "code": "+84",
	      "name": "Vietnam"
	    },
	    {
	      "code": "+1 808",
	      "name": "Wake Island"
	    },
	    {
	      "code": "+681",
	      "name": "Wallis and Futuna"
	    },
	    {
	      "code": "+967",
	      "name": "Yemen"
	    },
	    {
	      "code": "+260",
	      "name": "Zambia"
	    },
	    {
	      "code": "+255",
	      "name": "Zanzibar"
	    },
	    {
	      "code": "+263",
	      "name": "Zimbabwe"
	    }
	  ]
	}';
	}



function getComponent_or_PageName($componentId = '') {
		$pageName = '';
		switch ($componentId) {
			
			case '1':
				$pageName = 'criminal_checks';
				
				break;

			case '2':
				$pageName = 'court_records'; 
				
				break;
			case '3':
				$pageName = 'document_check';
				break;

			case '4':
				$pageName = 'drugtest';
				break;

			case '5':
				$pageName = 'globaldatabase';
				break;

			case '6':
				$pageName = 'current_employment';
				break; 
			case '7':
				$pageName = 'education_details';
				break; 
			case '8':
				$pageName = 'present_address';
				break; 
			case '9':
				$pageName = 'permanent_address';
				break; 
			case '10':
				$pageName = 'previous_employment';
				break; 
			case '11':
				$pageName = 'reference';
				break; 
			case '12':
				$pageName = 'previous_address';
				break;
			case '14':
				$pageName = 'directorship_check';
				break;
			case '15':
				$pageName = 'global_sanctions_aml';
				break;
			case '16':
				$pageName = 'driving_licence';
				break;
			case '17':
				$pageName = 'credit_cibil';
				break;
			case '18':
				$pageName = 'bankruptcy';
				break;
			case '19':
				$pageName = 'adverse_database_media_check';
				break;
			case '20':
				$pageName = 'cv_check';
				break;
			case '21':
				$pageName = 'health_checkup';
				break;
			case '22':
				$pageName = 'employment_gap_check';
				break;
			case '23':
				$pageName = 'landload_reference';
				break;
			case '24':
				$pageName = 'covid_19';
				break;
			case '25':
				$pageName = 'social_media';
				break;
			case '26':
				$pageName = 'civil_check';
				break;
			case '27':
				$pageName = 'right_to_work';
				break;
			case '28':
				$pageName = 'sex_offender';
				break;
			case '29':
				$pageName = 'politically_exposed';
				break;
			case '30':
				$pageName = 'india_civil_litigation';
				break;
			case '31':
				$pageName = 'mca';
				break;
			case '32':
				$pageName = 'nric';
				break;
			case '33':
				$pageName = 'gsa';
				break;
			case '34':
				$pageName = 'oig';
				break; 
			default:
				 $pageName = 'criminal_checks';
				break;
		};

		return $pageName;
	}



	/*new components */

		function update_candidate_sex_offender(){ 
		$user = $this->session->userdata('logged-in-candidate');
		if ($this->input->post('sex_offender_id')) { 
		$data = $this->db->where('sex_offender_id',$this->input->post('sex_offender_id'))->get('sex_offender')->row_array();
		$candidate_status = $data['status'];
		$analyst = $data['analyst_status']; 
		}
		$status = isset($candidate_status)?$candidate_status:1;
		$an = isset($analyst)?$analyst:0;
		if ($status =='3' || $an =='3') {
			$status = 1;
			$an = 0;
		}
		$sex_offender = array(
			'candidate_id'=>$user['candidate_id'],
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'dob'=>$this->input->post('date_of_birth'),
			'gender'=>$this->input->post('gender'),
			'status'=>$status,
			'analyst_status'=>$an,
		); 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('sex_offender')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('sex_offender_id')) {
			// $this->db->where('sex_offender_id',$this->input->post('sex_offender_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('sex_offender',$sex_offender);   
			$insert_id = $this->input->post('sex_offender_id');
		}else{
			$result = $this->db->insert('sex_offender',$sex_offender);
			$insert_id = $this->db->insert_id();
		}

		if ($result == true) {

		$sex_offender['sex_offender_id'] = $insert_id;
		$this->db->insert('sex_offender_log',$sex_offender);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}		
	}


		function update_candidate_politically_exposed(){ 
		$user = $this->session->userdata('logged-in-candidate');
		if ($this->input->post('politically_exposed_id')) { 
		$data = $this->db->where('politically_exposed_id',$this->input->post('politically_exposed_id'))->get('politically_exposed')->row_array();
		$candidate_status = $data['status'];
		$analyst = $data['analyst_status']; 
		}
		$status = isset($candidate_status)?$candidate_status:1;
		$an = isset($analyst)?$analyst:0;
		if ($status =='3' || $an =='3') {
			$status = 1;
			$an = 0;
		}
		$politically_exposed = array(
			'candidate_id'=>$user['candidate_id'],
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'dob'=>$this->input->post('date_of_birth'),
			'address'=>$this->input->post('address'),
			'gender'=>$this->input->post('gender'),
			'status'=>$status,
			'analyst_status'=>$an,
		); 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('politically_exposed')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('politically_exposed_id')) {
			// $this->db->where('politically_exposed_id',$this->input->post('politically_exposed_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('politically_exposed',$politically_exposed);   
			$insert_id = $this->input->post('politically_exposed_id');
		}else{
			$result = $this->db->insert('politically_exposed',$politically_exposed);
			$insert_id = $this->db->insert_id();
		}

		if ($result == true) {

		$politically_exposed['politically_exposed_id'] = $insert_id;
		$this->db->insert('politically_exposed_log',$politically_exposed);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}		
	}


	function update_candidate_india_civil_litigation(){ 
		$user = $this->session->userdata('logged-in-candidate');
		if ($this->input->post('india_civil_litigation_id')) { 
		$data = $this->db->where('india_civil_litigation_id',$this->input->post('india_civil_litigation_id'))->get('india_civil_litigation')->row_array();
		$candidate_status = $data['status'];
		$analyst = $data['analyst_status']; 
		}
		$status = isset($candidate_status)?$candidate_status:1;
		$an = isset($analyst)?$analyst:0;
		if ($status =='3' || $an =='3') {
			$status = 1;
			$an = 0;
		}
		$india_civil_litigation = array(
			'candidate_id'=>$user['candidate_id'],
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'dob'=>$this->input->post('date_of_birth'),
			'address'=>$this->input->post('address'),
			'gender'=>$this->input->post('gender'),
			'status'=>$status,
			'analyst_status'=>$an,
		); 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('india_civil_litigation')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('india_civil_litigation_id')) {
			// $this->db->where('india_civil_litigation_id',$this->input->post('india_civil_litigation_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('india_civil_litigation',$india_civil_litigation);   
			$insert_id = $this->input->post('india_civil_litigation_id');
		}else{
			$result = $this->db->insert('india_civil_litigation',$india_civil_litigation);
			$insert_id = $this->db->insert_id();
		}

		if ($result == true) {

		$india_civil_litigation['india_civil_litigation_id'] = $insert_id;
		$this->db->insert('india_civil_litigation_log',$india_civil_litigation);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}		
	}


	function update_candidate_gsa(){ 
		$user = $this->session->userdata('logged-in-candidate');
		if ($this->input->post('gsa_id')) { 
		$data = $this->db->where('gsa_id',$this->input->post('gsa_id'))->get('gsa')->row_array();
		$candidate_status = $data['status'];
		$analyst = $data['analyst_status']; 
		}
		$status = isset($candidate_status)?$candidate_status:1;
		$an = isset($analyst)?$analyst:0;
		if ($status =='3' || $an =='3') {
			$status = 1;
			$an = 0;
		}
		$gsa = array(
			'candidate_id'=>$user['candidate_id'],
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'), 
			'status'=>$status,
			'analyst_status'=>$an,
		); 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('gsa')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('oig_id')) {
			// $this->db->where('gsa_id',$this->input->post('gsa_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('gsa',$gsa);   
			$insert_id = $this->input->post('gsa_id');
		}else{
			$result = $this->db->insert('gsa',$gsa);
			$insert_id = $this->db->insert_id();
		}

		if ($result == true) {

		$gsa['gsa_id'] = $insert_id;
		$this->db->insert('gsa_log',$gsa);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}		
	}
 
	function update_candidate_oig(){ 
		$user = $this->session->userdata('logged-in-candidate');
		if ($this->input->post('oig_id')) { 
		$data = $this->db->where('oig_id',$this->input->post('oig_id'))->get('oig')->row_array();
		$candidate_status = $data['status'];
		$analyst = $data['analyst_status']; 
		}
		$status = isset($candidate_status)?$candidate_status:1;
		$an = isset($analyst)?$analyst:0;
		if ($status =='3' || $an =='3') {
			$status = 1;
			$an = 0;
		}
		$oig = array(
			'candidate_id'=>$user['candidate_id'],
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'), 
			'status'=>$status,
			'analyst_status'=>$an,
		); 
		$result = '';
		$table = $this->db->where('candidate_id',$user['candidate_id'])->get('oig')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('oig_id')) {
			// $this->db->where('oig_id',$this->input->post('oig_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('oig',$oig);   
			$insert_id = $this->input->post('oig_id');
		}else{
			$result = $this->db->insert('oig',$oig);
			$insert_id = $this->db->insert_id();
		}

		if ($result == true) {

		$oig['oig_id'] = $insert_id;
		$this->db->insert('oig_log',$oig);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}		
	}



	function update_candidate_mca($mca){ 
	$user = $this->session->userdata('logged-in-candidate');
	if ($this->input->post('mca_id')) {
			$this->db->where('mca_id',$this->input->post('mca_id'));
			$data = $this->db->get('mca')->row_array();
			$status = $data['status'];
			$analyst_status = $data['analyst_status'];
	}
	$status = isset($candidate_status)?$candidate_status:1;
		$an = isset($analyst)?$analyst:0;
		if ($status =='3' || $an =='3') {
			$status = 1;
			$an = 0;
		}
	$mca_data = array(
		'organization_name' => $this->input->post('organization_name'),
		'candidate_id'=>$user['candidate_id'],
		'status'=>$status,
		'analyst_status'=>$an,
	);
	if (! in_array('no-file', $mca)) {
		$mca_data['experiance_doc'] = implode(',', $mca);
	}

	$result = '';
	$table = $this->db->where('candidate_id',$user['candidate_id'])->get('mca')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('mca_id')) {
			// $this->db->where('mca_id',$this->input->post('mca_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('mca',$mca_data);

			$insert_id = $this->input->post('mca_id');
		}else{
			$result = $this->db->insert('mca',$mca_data);
			$insert_id = $this->db->insert_id();
		} 


		if ($result == true) {

		// if ( $this->db->insert('previous_address',$present_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}

	}


	function update_candidate_right_to_work($right_to_work){ 
	$user = $this->session->userdata('logged-in-candidate');
	$document_number = json_decode($this->input->post('document_number'),true);
		$status = array();
		$analyst_status = array(); 
		$data = $this->db->where('candidate_id',$user['candidate_id'])->get('right_to_work')->row_array();
		if ($data !='' && $data !=null) { 
		$candidate_status = explode(',', $data['status']);
		$analyst = explode(',', $data['analyst_status']);

		$insuff_status = explode(',',$data['insuff_status']);
		$output_status = explode(',',$data['output_status']);
		$insuff_team_role = explode(',',$data['insuff_team_role']);
		$insuff_team_id = explode(',',$data['insuff_team_id']);
		$assigned_role = explode(',',$data['assigned_role']);
		$assigned_team_id = explode(',',$data['assigned_team_id']);
		}

		$insuff_status_array = array();
		$output_status_array = array();
		$insuff_team_role_array = array();
		$insuff_team_id_array = array();
		$assigned_role_array = array();
		$assigned_team_id_array = array();
		for ($i=0; $i < count($document_number); $i++) {  
			$analyst1 = isset($analyst[$i])?$analyst[$i]:array(0);
		$candidate_status1 = isset($candidate_status[$i])?$candidate_status[$i]:array(1);
		$insuff_status1 = isset($insuff_status[$i])?$insuff_status[$i]:array(0);
		$output_status1 = isset($output_status[$i])?$output_status[$i]:array(0);
		$insuff_team_role1 = isset($insuff_team_role[$i])?$insuff_team_role[$i]:array(0);
		$insuff_team_id1 = isset($insuff_team_id[$i])?$insuff_team_id[$i]:array(0);
		$assigned_role1 = isset($assigned_role[$i])?$assigned_role[$i]:array(0);
		$assigned_team_id1 = isset($assigned_team_id[$i])?$assigned_team_id[$i]:array(0);
			$anlyst = $analyst1[0]; 
			if ($analyst1[0] == '3') {
				$anlyst = 0; 
			}
			$can_sts = $candidate_status1[0];
			if ($candidate_status1[0] == '3') {
				$can_sts = 1; 
			}
			$analyst_status[$i] = $anlyst; 
			$status[$i] = $can_sts; 
			$insuff_status_array[$i] = $insuff_status1[0];	 
			$output_status_array[$i] = $output_status1[0];	 
			$insuff_team_role_array[$i] = $insuff_team_role1[0];	 
			$insuff_team_id_array[$i] = $insuff_team_id1[0];	 
			$assigned_role_array[$i] = $assigned_role1[0];	 
			$assigned_team_id_array[$i] = $assigned_team_id1[0];	 
		} 
	$mca_data = array(
		'document_number' => $this->input->post('document_number'),
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'dob' => $this->input->post('dob'),
		'gender' => $this->input->post('gender'),
		'mobile_number' => $this->input->post('mobile_number'), 
		'candidate_id'=>$user['candidate_id'],
		'status'=>implode(',', $status),
		'analyst_status'=>implode(',', $analyst_status),
		'insuff_status'=>implode(',', $insuff_status_array),
		'output_status'=>implode(',', $output_status_array),
		'insuff_team_role'=>implode(',', $insuff_team_role_array),
		'insuff_team_id'=>implode(',', $insuff_team_id_array), 
		'assigned_role'=>implode(',', $assigned_role_array), 
		'assigned_team_id'=>implode(',', $assigned_team_id_array),
	);


		 
	if (! in_array('no-file', $right_to_work) && count($right_to_work) > 0) {
		$mca_data['right_to_work_docs'] = json_encode($right_to_work);
	}

	$result = '';
	$table = $this->db->where('candidate_id',$user['candidate_id'])->get('right_to_work')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('right_to_work_id')) {
			// $this->db->where('right_to_work_id',$this->input->post('right_to_work_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('right_to_work',$mca_data);

			$insert_id = $this->input->post('right_to_work_id');
		}else{
			$result = $this->db->insert('right_to_work',$mca_data);
			$insert_id = $this->db->insert_id();
		} 


		if ($result == true) {

		// if ( $this->db->insert('previous_address',$present_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}

	}


	function update_candidate_nric($nric){ 
	$user = $this->session->userdata('logged-in-candidate');
	if ($this->input->post('nric_id')) {
			$this->db->where('nric_id',$this->input->post('nric_id'));
			$data = $this->db->get('nric')->row_array();
			$status = $data['status'];
			$analyst_status = $data['analyst_status'];
	}
	$status = isset($candidate_status)?$candidate_status:1;
		$an = isset($analyst)?$analyst:0;
		if ($status =='3' || $an =='3') {
			$status = 1;
			$an = 0;
		}
	$mca_data = array(
		'nric_number' => $this->input->post('nric_number'),
		'joining_date' => $this->input->post('joining_date'),
		'end_date' => $this->input->post('relieving_date'),
		'gender' => $this->input->post('gender'), 
		'candidate_id'=>$user['candidate_id'],
		'status'=>$status,
		'analyst_status'=>$an,
	);

	if (! in_array('no-file', $nric)) {
		$mca_data['nric-docs'] = implode(',', $nric);
	}
	 
	$result = '';
	$table = $this->db->where('candidate_id',$user['candidate_id'])->get('nric')->num_rows();
		if ($table > 0) {
		// if ($this->input->post('nric_id')) {
			// $this->db->where('nric_id',$this->input->post('nric_id'));
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('nric',$mca_data);

			$insert_id = $this->input->post('nric_id');
		}else{
			$result = $this->db->insert('nric',$mca_data);
			$insert_id = $this->db->insert_id();
		} 


		if ($result == true) {

		// if ( $this->db->insert('previous_address',$present_data)) {

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}

	}

	
// 	update_candidate_right_to_work
// update_candidate_right_to_work

}