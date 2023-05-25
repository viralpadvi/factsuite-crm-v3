<?php

class Main_Mobile_Candidate_Model extends CI_Model {

	function update_candidate_1_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$candidate_data = array(
			'title'=>$this->input->post('title'),
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'father_name'=>$this->input->post('father_name'),
			'email_id'=>$this->input->post('email_id'), 
			'date_of_birth'=>$this->input->post('date_of_birth'),
			'nationality'=>$this->input->post('nationality'),
			'gender'=>$this->input->post('gender'),
			'marital_status'=>$this->input->post('marital'), 
			'contact_start_time'=>$this->input->post('timepicker'), 
			'contact_end_time'=>$this->input->post('timepicker2'), 
			'week'=>$this->input->post('preference_week'),
			'candidate_flat_no'=>$this->input->post('house_flat'),
			'candidate_street'=>$this->input->post('street'),
			'candidate_area'=>$this->input->post('area'),
			'candidate_city'=>$this->input->post('city'),
			'candidate_state'=>$this->input->post('state'),
			'candidate_pincode'=>$this->input->post('pincode'),
			'personal_information_form_filled_by_candidate_status' => 1
		);

		if ($this->db->where('candidate_id',$user['candidate_id'])->update('candidate',$candidate_data)) {
			$this->update_logged_in_user_info($user['candidate_id']);

			$global = $this->db->where('candidate_id',$user['candidate_id'])->get('globaldatabase')->num_rows();
			if ($global > 0) {
				$global_data = array(
				 	'candidate_name'=>$this->input->post('first_name'),
				 	'father_name'=>$this->input->post('father_name'),
				 	'dob'=>$this->input->post('date_of_birth'),
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
					 	$row2['dob'] = $this->input->post('date_of_birth');
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

	function update_logged_in_user_info($candidate_id) {
		$query = $this->db->where('candidate.candidate_id', $candidate_id)->select("candidate.*,tbl_client.client_name")->join('tbl_client','candidate.client_id = tbl_client.client_id')->limit(1)->get('candidate')->row_array();
		$this->session->set_userdata('logged-in-candidate',$query);
	}

	function update_current_employment_1_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$employment_data = array(
			'candidate_id' => $user['candidate_id'],
			'desigination' => $this->input->post('designation'), 
			'department' => $this->input->post('department'), 
			'employee_id' => $this->input->post('employee_id'), 
			'company_name' => $this->input->post('company_name'), 
			'company_url' => $this->input->post('company_url'), 
			'address' => $this->input->post('address'), 
			'annual_ctc' => $this->input->post('annual_ctc'), 
			'reason_for_leaving' => $this->input->post('reason_for_leaving'), 
			'joining_date' => $this->input->post('joining_date'), 
			'relieving_date' => $this->input->post('relieving_date'), 
			'reporting_manager_name' => $this->input->post('reporting_manager_name'), 
			'reporting_manager_desigination' => $this->input->post('reporting_manager_designation'), 
			'reporting_manager_contact_number' => $this->input->post('reporting_manager_contact'), 
			'reporting_manager_email_id' => $this->input->post('reporting_manager_email_id'), 
			'code' => $this->input->post('reporting_manager_contact_code'), 
			'hr_name' => $this->input->post('hr_name'),
			'hr_contact_number' => $this->input->post('hr_contact'),
			'hr_code' => $this->input->post('hr_contact_code'),
			'hr_email_id' => $this->input->post('hr_email_id')
		);

		$result = '';
		$form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('current_employment')->row_array();
		if ($form_filled_or_not['count'] > 0) {
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('current_employment',$employment_data);
		} else {
			$result = $this->db->insert('current_employment',$employment_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_current_employment_2_details($appointment_letter,$experience_relieving_letter,$last_month_pay_slip,$bank_statement_resigngation_acceptance) {
		$user = $this->session->userdata('logged-in-candidate');
		$employment_data = array(
			'status' => 1,
			'analyst_status' => 0
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
		$form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('current_employment')->row_array();
		if ($form_filled_or_not['count'] > 0) {
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('current_employment',$employment_data);
		} else {
			$result = $this->db->insert('current_employment',$employment_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_previous_employment_1_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$employment_data = array(
			'candidate_id' => $user['candidate_id'],
			'desigination' => $this->input->post('designation'), 
			'department' => $this->input->post('department'), 
			'employee_id' => $this->input->post('employee_id'), 
			'company_url' => $this->input->post('company_url'), 
			'address' => $this->input->post('address'), 
			'annual_ctc' => $this->input->post('annual_ctc'), 
			'reason_for_leaving' => $this->input->post('reason_of_leaving'), 
			'joining_date' => $this->input->post('joining_date'), 
			'relieving_date' => $this->input->post('relieving_date'), 
			'reporting_manager_name' => $this->input->post('reporting_manager_name'), 
			'reporting_manager_desigination' => $this->input->post('reporting_manager_designation'), 
			'reporting_manager_contact_number' => $this->input->post('reporting_manager_contact'), 
			'reporting_manager_email_id' => $this->input->post('reporting_manager_email_id'), 
			'code' => $this->input->post('reporting_manager_contact_code'), 
			'hr_name' => $this->input->post('hr_name'),
			'hr_code' => $this->input->post('hr_contact_code'),
			'hr_contact_number' => $this->input->post('hr_contact'),
			'hr_email_id' => $this->input->post('hr_email_id')
		);

		$result = '';
		$form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('previous_employment')->row_array();
		if ($form_filled_or_not['count'] > 0) {
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('previous_employment',$employment_data);
		} else {
			$result = $this->db->insert('previous_employment',$employment_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_previous_employment_2_details($appointment_letter,$experience_relieving_letter,$last_month_pay_slip,$bank_statement_resigngation_acceptance) {
		$user = $this->session->userdata('logged-in-candidate');
		$employment = $this->db->where('candidate_id',$user['candidate_id'])->get('previous_employment')->row_array();

		$designation = json_decode($employment['desigination'],true);
		$status = array();
		$analyst_status = array(); 
		for ($i = 0; $i < count($designation); $i++) {
			array_push($status, 1);
			array_push($analyst_status, 0); 
		}

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
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $analyst_status),
			'output_status'=>implode(',', $analyst_status),
			'insuff_team_role'=>implode(',', $analyst_status),
			'insuff_team_id'=>implode(',', $analyst_status), 
			'assigned_role'=>implode(',', $analyst_status), 
			'assigned_team_id'=>implode(',', $analyst_status), 
		);

		if (!in_array('no-file', $appointment_letter_array)) {
			$employment_data['appointment_letter'] = json_encode($appointment_letter_array);
		}

		if (!in_array('no-file', $experience_relieving_letter_array)) {
			$employment_data['experience_relieving_letter'] = json_encode($experience_relieving_letter_array);
		}

		if (!in_array('no-file', $last_month_pay_slip_array)) {
			$employment_data['last_month_pay_slip'] = json_encode($last_month_pay_slip_array);
		}

		if (!in_array('no-file', $bank_statement_resigngation_acceptance_array)) {
			$employment_data['bank_statement_resigngation_acceptance'] = json_encode($bank_statement_resigngation_acceptance_array);
		}

		$result = '';
		$this->db->where('candidate_id',$user['candidate_id']);
		$result = $this->db->update('previous_employment',$employment_data);

		$insert_id = $employment['previous_emp_id'];

		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_bankruptcy_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$bankruptcy_count = explode(',', $this->input->post('bankruptcy_count'));
		$number = json_decode($this->input->post('bankruptcy_number'),true);

		$bankruptcy_data = $this->db->where('candidate_id',$user['candidate_id'])->get('bankruptcy')->row_array(); 
		$status = array();
		$analyst_status = array(); 
		$credit_status = explode(',', isset($bankruptcy_data['status'])?$bankruptcy_data['status']:1);
		$credit_analyst_status = explode(',', isset($bankruptcy_data['analyst_status'])?$bankruptcy_data['analyst_status']:0);

		for($i = 0; $i < count($number); $i++) {  
		 	$analys_status = isset($credit_analyst_status[$i])?$credit_analyst_status[$i]:0;
			if ($analys_status =='3') {
				array_push($analyst_status, 0);	
				array_push($status, 1);	
			} else {
				array_push($analyst_status, $analys_status);
				array_push($status, isset($credit_status[$i])?$credit_status[$i]:1);
			}
		}

		$bankruptcy = array(
			'bankruptcy_number' => $this->input->post('bankruptcy_number'),
			'document_type' => $this->input->post('document_type'),
			'candidate_id'=>$user['candidate_id'],
			'status'=>implode(',',$status),
			'analyst_status'=>implode(',',$analyst_status),
		);

		$result = '';
		if ($this->input->post('bankruptcy_id') !=null && $this->input->post('bankruptcy_id') !='undefined') {
			$this->db->where('bankruptcy_id',$this->input->post('bankruptcy_id'));
			$result = $this->db->update('bankruptcy',$bankruptcy); 
			$insert_id = $this->input->post('bankruptcy_id');
		} else {
			$result = $this->db->insert('bankruptcy',$bankruptcy);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_present_address_1_details() {
		$user = $this->session->userdata('logged-in-candidate');
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
			'duration_of_stay_start'=>$this->input->post('start_year').'-'.$this->input->post('start_month').'-00',
			'duration_of_stay_end'=>$this->input->post('end_year').'-'.$this->input->post('end_month').'-00',
			'is_present'=>$this->input->post('present'),
			'contact_person_name'=>$this->input->post('name'),
			'contact_person_relationship'=>$this->input->post('relationship'),
			'contact_person_mobile_number'=> $this->input->post('contact_no'),
			'code'=> $this->input->post('code')
		);
 
		$result = '';
		if ($this->input->post('present_address_id')) {
			$this->db->where('present_address_id',$this->input->post('present_address_id'));
			$result = $this->db->update('present_address',$present_data);

			$insert_id = $this->input->post('present_address_id');
		} else {
			$result = $this->db->insert('present_address',$present_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_present_address_2_details($candidate_rental,$candidate_ration,$candidate_gov) {
		$user = $this->session->userdata('logged-in-candidate');
		$present_data = array(
			'status' => 1,
			'analyst_status' => 0
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
		$this->db->where('candidate_id',$user['candidate_id']);
		$result = $this->db->update('present_address',$present_data);
		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_reference_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$name = explode(',',$this->input->post('name'));
		$status = array();
		$analyst_status = array();
		for ($i = 0; $i < count($name); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
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
			'insuff_status'=>implode(',', $analyst_status),
			'output_status'=>implode(',', $analyst_status),
			'insuff_team_role'=>implode(',', $analyst_status),
			'insuff_team_id'=>implode(',', $analyst_status), 
			'assigned_role'=>implode(',', $analyst_status), 
			'assigned_team_id'=>implode(',', $analyst_status), 
		);


		$result = '';
		if ($this->input->post('reference_id')) {
			$this->db->where('reference_id',$this->input->post('reference_id'));
			$result = $this->db->update('reference',$reference_data);

			$insert_id = $this->input->post('reference_id');
		} else {
			$result = $this->db->insert('reference',$reference_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
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
				'insuff_status'=>implode(',', $analyst_status),
				'output_status'=>implode(',', $analyst_status),
				'insuff_team_role'=>implode(',', $analyst_status),
				'insuff_team_id'=>implode(',', $analyst_status), 
				'assigned_role'=>implode(',', $analyst_status), 
				'assigned_team_id'=>implode(',', $analyst_status), 
			);	
			$this->db->insert('reference_log',$reference_log_data);
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_previous_address_1_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$permenent_house = json_decode($this->input->post('permenent_house'),true);
		$address = $this->db->where('candidate_id',$user['candidate_id'])->get('previous_address')->row_array();  

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
			'code'=> $this->input->post('code')
		); 

		if ($address != '') {
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('previous_address',$present_data);
		} else {
			$result = $this->db->insert('previous_address',$present_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_previous_address_2_details($candidate_rental,$candidate_ration,$candidate_gov) {
		$user = $this->session->userdata('logged-in-candidate');
		$address = $this->db->where('candidate_id',$user['candidate_id'])->get('previous_address')->row_array();
		$permenent_house = json_decode($address['flat_no'],true);
		$status = array();
		$analyst_status = array();
		for ($i=0; $i < count($permenent_house); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
		}

		$rental = explode(',', $this->input->post('rental_agreement'));
		$rental_agreement = json_decode( isset($address['rental_agreement'])?$address['rental_agreement']:'no-file' ,true);
		$j = 0;
		$candidate_rental_array = array();
		foreach ($rental as $key => $value) {
			if ($value == '1') {
				array_push($candidate_rental_array, $candidate_rental[$j]);
				$j++;
			} else { 
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
			} else { 
				array_push($candidate_gov_array, isset($gov_utility_bill[$key])?$gov_utility_bill[$key]:array('no-file'));
			}
		}
		$present_data = array(
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $analyst_status),
			'output_status'=>implode(',', $analyst_status),
			'insuff_team_role'=>implode(',', $analyst_status),
			'insuff_team_id'=>implode(',', $analyst_status), 
			'assigned_role'=>implode(',', $analyst_status), 
			'assigned_team_id'=>implode(',', $analyst_status) 
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

		if ($this->db->where('candidate_id',$user['candidate_id'])->update('previous_address',$present_data)) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_court_record_1_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$court_records = $this->db->where('candidate_id',$user['candidate_id'])->get('court_records')->row_array();
		$address = json_decode($this->input->post('address'),true);
		$status = array();
		$analyst_status = array();
		for ($i = 0; $i < count($address); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
		}

		$court_data = array(
			'candidate_id'=>$user['candidate_id'],
			'address'=>$this->input->post('address'),
			'pin_code'=>$this->input->post('pincode'),
			'city'=>$this->input->post('city'),
			'state'=>$this->input->post('state'),
			'country'=>$this->input->post('country')
		);

		$result = '';
		if ($court_records != '') {
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('court_records',$court_data);
		} else {
			$result = $this->db->insert('court_records',$court_data);
		} 

		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_court_record_2_details($candidate_address) {
		$user = $this->session->userdata('logged-in-candidate');
		$court_records = $this->db->where('candidate_id',$user['candidate_id'])->get('court_records')->row_array();
		$address = json_decode($court_records['address'],true);
		$status = array();
		$analyst_status = array();
		for ($i = 0; $i < count($address); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
		}

		$court_data = array(
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $analyst_status),
			'output_status'=>implode(',', $analyst_status),
			'insuff_team_role'=>implode(',', $analyst_status),
			'insuff_team_id'=>implode(',', $analyst_status), 
			'assigned_role'=>implode(',', $analyst_status), 
			'assigned_team_id'=>implode(',', $analyst_status)
		);

		if (!in_array('no-file', $candidate_address)) {
			$court_data['address_proof_doc'] = json_encode($candidate_address);
		}

		if ($this->db->where('candidate_id',$user['candidate_id'])->update('court_records',$court_data)) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_social_media_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$social_media_records = $this->db->where('candidate_id',$user['candidate_id'])->get('social_media')->row_array();
		$social_media = array(
			'candidate_id'=>$user['candidate_id'],
			'candidate_name'=>$user['first_name'], 
			'dob'=>$this->input->post('date_of_birth'),
			'employee_company_info'=>$this->input->post('employee_company'), 
			'education_info'=>$this->input->post('education'), 
			'university_info'=>$this->input->post('university'), 
			'social_media_info'=>$this->input->post('social_media'), 
			'status'=>1,
			'analyst_status'=>0,
		);

		$result = '';
		if ($social_media_records != '') {
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('social_media',$social_media);

			$insert_id = $social_media_records['social_id'];
		} else {
			$result = $this->db->insert('social_media',$social_media);
			$insert_id = $this->db->insert_id();
		}
		$social_media['social_id'] = $insert_id;

		if ($result == true) {
			$this->db->insert('social_media_log',$social_media);
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_credit_cibil_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$number = json_decode($this->input->post('credit_cibil_number'),true);

		$credit = $this->db->where('candidate_id',$user['candidate_id'])->get('credit_cibil')->row_array();
		$status = array();
		$analyst_status = array(); 
		$credit_status = explode(',', isset($credit['status'])?$credit['status']:1);
		$credit_analyst_status = explode(',', isset($credit['analyst_status'])?$credit['analyst_status']:0);

		 for ($i = 0; $i < count($number); $i++) {  
			$analys_status = isset($credit_analyst_status[$i])?$credit_analyst_status[$i]:0;
			if ($analys_status =='3') {
				array_push($analyst_status, 0);	
				array_push($status, 1);	
			} else {
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

		$result = '';
		if ($credit != '') {
			$result = $this->db->where('candidate_id',$user['candidate_id'])->update('credit_cibil',$credit_cibil);
			$insert_id = $credit['credit_id'];
		} else {
			$result = $this->db->insert('credit_cibil',$credit_cibil);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_cv_check($cv) {
		$user = $this->session->userdata('logged-in-candidate');
		$cv_check_details = $this->db->where('candidate_id',$user['candidate_id'])->get('cv_check')->row_array(); 
		$cv_check = array( 
			'candidate_id'=>$user['candidate_id'],
			'status'=>1,
			'analyst_status'=>0
		);
		if (!in_array('no-file', $cv)) {
			$cv_check['cv_doc'] = implode(',', $cv);
		}

		$result = '';
		if ($cv_check_details != '') {
			$result = $this->db->where('candidate_id',$user['candidate_id'])->update('cv_check',$cv_check);
			$insert_id = $cv_check_details['cv_id'];
		} else {
			$result = $this->db->insert('cv_check',$cv_check);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_landlord_reference_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$landload_reference_details = $this->db->where('candidate_id',$user['candidate_id'])->get('landload_reference')->row_array();
		$landlord_name = json_decode($this->input->post('landlord_name'),true);
		$status = array();
		$analyst_status = array();
		for ($i = 0; $i < count($landlord_name); $i++) { 
			array_push($status, 1);
			array_push($analyst_status, 0);
		}
		 
		$reference_data = array(
			'candidate_id'=>$user['candidate_id'],
			'tenant_name'=>'',
			'case_contact_no'=>$this->input->post('case_contact_no'), 
			'landlord_name'=>$this->input->post('landlord_name'),
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $analyst_status),
			'output_status'=>implode(',', $analyst_status),
			'insuff_team_role'=>implode(',', $analyst_status),
			'insuff_team_id'=>implode(',', $analyst_status), 
			'assigned_role'=>implode(',', $analyst_status), 
			'assigned_team_id'=>implode(',', $analyst_status), 
		);

		$result = '';
		if ($landload_reference_details != '') {
			$result = $this->db->where('candidate_id',$user['candidate_id'])->update('landload_reference',$reference_data);
			$insert_id = $landload_reference_details['landload_id'];
		} else {
			$result = $this->db->insert('landload_reference',$reference_data);
			$insert_id = $this->db->insert_id();
		} 

		$reference_data['landload_id'] = $insert_id;

		if ($result == true) {
			$this->db->insert('landload_reference_log',$reference_data);
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_education_1_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$degree = json_decode($this->input->post('type_of_degree'),true);
		$data = '';
		$db_all_sem ='';
		$db_convocations ='';
		$db_marksheet ='';
		$db_ten_twelve ='';
		$data = $this->db->where('candidate_id',$user['candidate_id'])->get('education_details')->row_array();

		if ($data != '') {
			$db_all_sem = json_decode($data['all_sem_marksheet'],true);
			$db_convocations = json_decode($data['convocation'],true);
			$db_marksheet = json_decode($data['marksheet_provisional_certificate'],true);
			$db_ten_twelve = json_decode($data['ten_twelve_mark_card_certificate'],true);
		}

		$marksheet = explode(',',$this->input->post('marksheet'));
		$convocatio_n = explode(',',$this->input->post('convocation'));
		$certificate = explode(',',$this->input->post('certificate'));
		$ten_twelve = explode(',',$this->input->post('ten_twelve'));
		
		$eduction_data = array(
			'candidate_id' => $user['candidate_id'],
			'type_of_degree' => $this->input->post('type_of_degree'),
			'major' => $this->input->post('major'),
			'university_board' => $this->input->post('university'),
			'college_school' => $this->input->post('college_name'),
			'address_of_college_school' => $this->input->post('address'),
			'course_start_date' => $this->input->post('duration_of_stay'),
			'registration_roll_number' => $this->input->post('registration_roll_number'), 
			'course_end_date' => $this->input->post('duration_of_course'),  
			'type_of_course' => $this->input->post('time')
		);

		$result = '';
		if ($data != '') {
			$this->db->where('candidate_id',$user['candidate_id']);
			$result = $this->db->update('education_details',$eduction_data);

			$insert_id = $data['education_details_id'];
		} else {
			$result = $this->db->insert('education_details',$eduction_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_education_2_details($all_sem_marksheet,$convocation,$marksheet_provisional_certificate,$ten_twelve_mark_card_certificate) {

		// echo json_encode(array($all_sem_marksheet,$convocation,$marksheet_provisional_certificate,$ten_twelve_mark_card_certificate));
		  
		$user = $this->session->userdata('logged-in-candidate');
		$data = $this->db->where('candidate_id',$user['candidate_id'])->get('education_details')->row_array();
		$degree = json_decode($data['type_of_degree'],true);
		$db_all_sem = json_decode($data['all_sem_marksheet'],true);
		$db_convocations = json_decode($data['convocation'],true);
		$db_marksheet = json_decode($data['marksheet_provisional_certificate'],true);
		$db_ten_twelve = json_decode($data['ten_twelve_mark_card_certificate'],true);

		$marksheet = explode(',',$this->input->post('marksheet'));

		$convocatio_n = explode(',',$this->input->post('convocation'));
		$certificate = explode(',',$this->input->post('certificate'));
		$ten_twelve = explode(',',$this->input->post('ten_twelve'));
		
		$status = array();
		$analyst_status = array();
		$all_sem_marksheet_array = array();
		$convocation_array = array();
		$marksheet_provisional_certificate_array = array();
		$ten_twelve_mark_card_certificate_array = array();
		$k = 0;
		$m = 0;
		$c = 0;
		$ce = 0;
		$t = 0;
		 
		for($i = 0; $i < count($degree); $i++) {
			$in_10_12_course_completion_certificate = 0;
			$in_all_sem_marksheet = 0;
			$in_professional_degree_or_degree_convocation_certificate = 0;
			$in_transcript_of_records = 0;

			array_push($status, 1);
			array_push($analyst_status, 0);
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

		$eduction_data = array( 
			'status'=>implode(',', $status),
			'analyst_status'=>implode(',', $analyst_status),
			'insuff_status'=>implode(',', $analyst_status),
			'output_status'=>implode(',', $analyst_status),
			'insuff_team_role'=>implode(',', $analyst_status),
			'insuff_team_id'=>implode(',', $analyst_status), 
			'assigned_role'=>implode(',', $analyst_status), 
			'assigned_team_id'=>implode(',', $analyst_status), 
		);

		if (!in_array('no-file', $all_sem_marksheet)) {
			$eduction_data['all_sem_marksheet'] = json_encode($all_sem_marksheet_array);
		}

		if (!in_array('no-file', $convocation)) {
			$eduction_data['convocation'] = json_encode($convocation_array);
		}

		if (!in_array('no-file', $marksheet_provisional_certificate)) {
			$eduction_data['marksheet_provisional_certificate'] = json_encode($marksheet_provisional_certificate_array);
		}

		if (!in_array('no-file', $ten_twelve_mark_card_certificate)) {
			$eduction_data['ten_twelve_mark_card_certificate'] = json_encode($ten_twelve_mark_card_certificate_array);
		}

		if ($this->db->where('candidate_id',$user['candidate_id'])->update('education_details',$eduction_data)) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_permanent_address_1_details() {
		$user = $this->session->userdata('logged-in-candidate');
		$permanent_address_details = $this->db->where('candidate_id',$user['candidate_id'])->get('permanent_address')->row_array();
		$permenent_data = array(
			'candidate_id'=>$user['candidate_id'],
			'flat_no'=>$this->input->post('house'),
			'street'=>$this->input->post('street'),
			'area'=>$this->input->post('area'),
			'city'=>$this->input->post('city'),
			'pin_code'=>$this->input->post('pincode'),
			'state'=>$this->input->post('state'),
			'country'=>$this->input->post('country'),
			'nearest_landmark'=>$this->input->post('land_mark'),
			'duration_of_stay_start'=>$this->input->post('start_year').'-'.$this->input->post('start_month').'-00',
			'duration_of_stay_end'=>$this->input->post('end_year').'-'.$this->input->post('end_month').'-00',
			'is_present'=>$this->input->post('present'),
			'contact_person_name'=>$this->input->post('name'),
			'contact_person_relationship'=>$this->input->post('relationship'),
			'contact_person_mobile_number'=> $this->input->post('contact_no'),
			'code'=> $this->input->post('code')
		);

		$result = '';
		if ($permanent_address_details != '') {
			$result = $this->db->where('candidate_id',$user['candidate_id'])->update('permanent_address',$permenent_data);

			$insert_id = $permanent_address_details['permanent_address_id'];
		} else {
			$result = $this->db->insert('permanent_address',$permenent_data);
			$insert_id = $this->db->insert_id();
		} 

		if ($result == true) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function update_permanent_address_2_details($candidate_rental,$candidate_ration,$candidate_gov) {
		$user = $this->session->userdata('logged-in-candidate'); 
		$permenent_data = array(
			'status' => 1,
			'analyst_status' => 0,
		);

		if (!in_array('no-file', $candidate_rental)) {
			$permenent_data['rental_agreement'] = implode(',', $candidate_rental);
		}

		if (!in_array('no-file', $candidate_ration)) {
			$permenent_data['ration_card'] = implode(',', $candidate_ration);
		}

		if (!in_array('no-file', $candidate_gov)) {
			$permenent_data['gov_utility_bill'] = implode(',', $candidate_gov);
		}

		if ($this->db->where('candidate_id',$user['candidate_id'])->update('permanent_address',$permenent_data)) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
	}
}