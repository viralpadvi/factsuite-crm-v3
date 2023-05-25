<?php
/**
 * 01-02-2021	
 */
class AdminViewAllCaseModel extends CI_Model
{

	function getPackgeDetail(){

		 
		$result =  $this->db->where('package_status',1)->where('package_id',$this->input->post('id'))->get('packages')->row_array();
		 
			$component_names = array();  
			$comp_name = array();
			$row['package_name'] = $result['package_name'];
			$row['package_id'] = $result['package_id'];
			$row['package_status'] = $result['package_status'];
			$component_ids = explode(',', $result['component_ids']);
			$component = $this->db->where_in('component_id',$component_ids)->get('components')->result_array();

			foreach ($component as $key1 => $com) {
				array_push($comp_name, $com[$this->config->item('show_component_name')]);
			}
			 
			$row['component_ids'] =  $component_ids;
			$row['component_name'] =  $comp_name;
			array_push($component_names, $row);
		 
		return $component_names;

	}

	function getPackage(){ 
		 
		$resultClient = $this->db->where('active_status',1)->where('client_id',$this->input->post('clinet_id'))->get('tbl_client')->row_array();
		 
		$package_name_array = array();
		$pkg_name_array = array();
		$package_ids = explode(',', $resultClient['packages']); 
		$package_name = $this->db->where('package_status',1)->where_in('package_id',$package_ids)->get('packages')->result_array();
 
		foreach ($package_name as $key => $package) {
			 
			array_push($pkg_name_array, $package['package_name']);
			 
		} 
		$row['package_name'] = $pkg_name_array;
		$row['package_ids'] = $package_ids;
		array_push($package_name_array, $row);
		return $package_name_array; 
	}
 
	function getAllAssignedCases() {
		$filter_limit = $this->input->post('filter_limit');
		$filter_input = $this->input->post('filter_input');
		$candidate_id_list = $this->input->post('candidate_id_list');

		if ($filter_limit == '' || !is_numeric($filter_limit)) {
			$filter_limit = 100;
		}

		$where_condition = '';
		if($filter_input != '') {
			$where_condition .= ' (`candidate_id` = "'.$filter_input.'"';
			if (!is_numeric($this->input->post('filter_input'))) { 
			$filter_input = '%'.$filter_input.'%';
			$where_condition .= ' OR `first_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `last_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `father_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `phone_number` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `email_id` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `tbl_client`.`client_name` LIKE "'.$filter_input.'"';
			}
			$where_condition .= ')';
			$this->db->where($where_condition);
		}

		if (isset($candidate_id_list) && count($candidate_id_list) > 0) {
			$this->db->where_not_in('candidate.candidate_id', $candidate_id_list);
		}

		if ($this->session->userdata('logged-in-csm')) {
			$team_component = $this->session->userdata('logged-in-csm');
			$this->db->where('tbl_client.account_manager_name',$team_component['team_id']);
		}

		$candidateData =  $this->db->select('candidate.*,candidate.communications as social,tbl_client.*')->from('candidate')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->order_by('candidate_id','DESC')->limit($filter_limit)->get('')->result_array();
		$data= array();
		if(count($candidateData) > 0) {
			foreach ($candidateData as $key => $candidateValue) {
				$row['candidate'] = $candidateValue;

				
				if($candidateValue['tat_start_date'] != null && $candidateValue['report_generated_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != '' && $candidateValue['tat_re_start_date'] != null && $candidateValue['tat_re_start_date'] != ''){
					$restart_date = 0;
					$start_date = 0; 
						$start_date = $this->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
				 
					$restart_date = $this->number_of_working_days($candidateValue['tat_re_start_date'],$candidateValue['report_generated_date']);
				 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != '' && $candidateValue['tat_re_start_date'] != null && $candidateValue['tat_re_start_date'] != ''){
					$restart_date = 0;
					$start_date = 0;
					 if ($candidateValue['report_generated_date'] !='') { 
						$restart_date = $this->number_of_working_days($candidateValue['tat_re_start_date'],$candidateValue['report_generated_date']);
					 }else{
					 	$restart_date = $this->number_of_working_days($candidateValue['tat_re_start_date'],date('d-m-Y'));
					 }
					 
					 
						$start_date = $this->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
					 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != ''){
					$restart_date = 0;
					$start_date = 0; 
					 
						$start_date = $this->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
					 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_start_date'] != ''){
						if ($candidateValue['report_generated_date'] !='' && $candidateValue['report_generated_date'] !=null) { 

						$row['left_tat_days'] = $this->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['report_generated_date']).' days';
					}else{
						$row['left_tat_days'] = $this->number_of_working_days($candidateValue['tat_start_date'],date('d-m-Y')).' days';	
					}
					 
				}else{
					$row['left_tat_days'] = '-';
					$row['tat_overdue'] = '-';
				}

				 
				$row['client'] = $this->getClientData($candidateValue['client_id']); 
				$row['inputQc'] = $this->getTeamData(isset($candidateValue['assigned_inputqc_id'])?$candidateValue['assigned_inputqc_id']:0); 
				$row['outputQc'] = $this->getTeamData(isset($candidateValue['assigned_outputqc_id'])?$candidateValue['assigned_outputqc_id']:0);
				$row['outputqc_id'] = isset($candidateValue['assigned_outputqc_id'])?$candidateValue['assigned_outputqc_id']:0;
				$row['package'] = $this->getPackageData($candidateValue['package_name']);
				$row['override_inputqc'] = $this->getTeamData('','inputqc'); 
				$row['override_outputqc'] = $this->getTeamData('','outputqc');
				$row['tat'] =  $this->db->get('tat')->row_array();
				array_push($data,$row);
			}
		} 
		return $data; 
	}


	function get_new_cases_count() {
		$filter_input = $this->input->post('filter_input');

		$where_condition = '';
		if($filter_input != '') {
			$filter_input = '%'.$filter_input.'%';
			$where_condition .= ' (`first_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `candidate_id` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `last_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `father_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `phone_number` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `email_id` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `tbl_client`.`client_name` LIKE "'.$filter_input.'"';
			$where_condition .= ')';
			$this->db->where($where_condition);
		}
		
		return $this->db->select('COUNT(*) AS new_cases_count')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->where_not_in('candidate.candidate_id', $this->input->post('candidate_id_list'))->get('candidate')->row_array();
	}

	function getWorkingDaysnumber_of_working_days($from, $to,$holidayDays='') {
	    $workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)
	     $holidays = $this->db->get('tat_holidays')->result_array();
            $holiday = array();
            if (count($holidays)) {
               foreach ($holidays as $key => $val) {
                  array_push($holiday,$val['holiday_date']);
               }
            }
	    $holidayDays = $holiday;// ['*-12-25', '*-01-01', '2013-12-23']; # variable and fixed holidays

	    $from = new DateTime($from);
	    $to = new DateTime($to);
	    // $to->modify('+1 day');
	    $interval = new DateInterval('P1D');
	    $periods = new DatePeriod($from, $interval, $to);

	    $days = 0;
	    foreach ($periods as $period) {
	        if (!in_array($period->format('N'), $workingDays)) continue;
	        if (in_array($period->format('d-m-Y'), $holidayDays)) continue;
	        if (in_array($period->format('*-m-d'), $holidayDays)) continue;
	        $days++;
	    }
	    return $days;
	}


	function number_of_working_days($startDate,$endDate,$holidays=''){
    // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);

     $holidays = $this->db->get('tat_holidays')->result_array();
            $holiday = array();
            if (count($holidays)) {
               foreach ($holidays as $key => $val) {
                  array_push($holiday,$val['holiday_date']);
               }
            }
	   $holidayDays = $holiday;// ['*-12-25', '*-01-01', '2013-12-23']; # variable and fixed holidays

    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        }
        else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
   $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
      $workingDays += $no_remaining_days;
    }

    //We subtract the holidays
    foreach($holidayDays as $holiday){
        $time_stamp=strtotime($holiday);
        //If the holiday doesn't fall in weekend
        if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
            $workingDays--;
    }

    return round($workingDays);
}

	function getTeamData($teamId = '',$role=''){
		if ($role != null && $role != '') {
			// echo $role."<br>";
			return $this->db->select('team_id,first_name,last_name,contact_no,role')->from('team_employee')->where('role',$role)->where('is_Active','1')->get()->result_array();
		}else{
			return $this->db->select('team_id,first_name,last_name,contact_no')->from('team_employee')->where('team_id',$teamId)->where('is_Active','1')->get()->row_array();
		}
	}

	function getClientData($clientId){
		return $this->db->select('client_id,client_name,high_priority_days,medium_priority_days,low_priority_days')->from('tbl_client')->where('client_id',$clientId)->get()->row_array();
	}
	function getPackageData($packageId){
		return $this->db->select('package_id,package_name')->from('packages')->where('package_id',$packageId)->get()->row_array();
	}
 
	function get_single_cases_detail(){

		return $this->db->select("candidate.*,tbl_client.client_name")->from("candidate")->where('candidate_id',$this->input->post('id'))->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->get()->result_array();
	}


	function get_single_case_details($candidate_id) {
		
 		$result = $this->db->where('candidate_id',$candidate_id)->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->row_array();

 		$component_id = explode(',', $result['component_ids']);
 		$component = $this->db->where_in('component_id',$component_id)->get('components')->result_array();

 		 $case_data  = array();
 		foreach ($component as $key => $value) {
 			 $row['component_id'] = $value['component_id'];
 			 $row['component_name'] = $value[$this->config->item('show_component_name')]; 
 			 $row['client_id'] = $result['client_id']; 
 			 $row['client_name'] = $result['client_name']; 
 			 $row['candidate_id'] = $result['candidate_id']; 
 			 $row['title'] = $result['title']; 
 			 $row['first_name'] = $result['first_name']; 
 			 $row['last_name'] = $result['last_name']; 
 			 $row['father_name'] = $result['father_name']; 
 			 $country_code = isset($result['country_code'])?$result['country_code']:'+91';  
 			 $row['phone_number'] = $country_code.' '.$result['phone_number'];  
 			 $row['email_id'] = $result['email_id']; 
 			 $row['date_of_birth'] = $result['date_of_birth']; 
 			 $row['date_of_joining'] = $result['date_of_joining']; 
 			 $row['employee_id'] = $result['employee_id']; 
 			 $row['package_name'] = $result['package_name']; 
 			 $row['remark'] = $result['remark']; 
 			 $row['document_uploaded_by'] = $result['document_uploaded_by']; 
 			 $row['document_uploaded_by_email_id'] = $result['document_uploaded_by_email_id']; 
 			 $row['is_submitted'] = $result['is_submitted'];  
 			 array_push($case_data, $row);
 		}

 		return $case_data;
	}




	function getComponentBasedData($candidate_id,$table_name){
		 
		// $component_based = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
 		$component_based = $this->db->select($table_name.'.*,candidate.form_values')->from($table_name)->join('candidate',$table_name.'.candidate_id = candidate.candidate_id','left')->where($table_name.'.candidate_id',$candidate_id)->get()->row_array();
 
		return $component_based;

	}

	function getTeamEmpData($team_id){
		 
		$teamDetails = $this->db->where('team_id',$team_id)->where('is_Active','1')->get('team_employee')->row_array();
		 
		$result = [];
 		if($teamDetails != null && $teamDetails != ''){
 			$result['name'] = $teamDetails['first_name'].' '.$teamDetails['last_name']; 
 		}else{
 			$result['name'] = '-';
 		}
		return $result;

	}


	function insuffUpdateStatus($candidate_id,$table_name,$component_id){
		 
		$user = $this->session->userdata('logged-in-inputqc'); 
		$inputqc_id = $this->getMinimumTaskHandlerAnalyst($table_name,$component_id);
		if($inputqc_id != 0){
			$components_data = array(
			
				'status'=>'3',
				'updated_date'=>date('d-m-Y H:i:s'),
				'assigned_role'=>'analyst',
				'assigned_team_id'=>$inputqc_id
			);
			$this->db->where('candidate_id',$candidate_id);
			if ($this->db->update($table_name,$components_data)) {
				$insert_id = $this->db->insert_id();
				$components_log_data = array( 
					'candidate_id'=>$candidate_id,
					'status'=>'3',
					'assigned_role'=>'analyst',
					'assigned_team_id'=>$inputqc_id,
					'updated_date'=>date('d-m-Y H:i:s') 
					 
				);
				$this->db->insert($table_name."_log",$components_log_data);
				return array('status'=>'1','msg'=>'success');
			}else{
				return array('status'=>'0','msg'=>'failled');
			}
		}else{
			$table_name = str_replace('_',' ',$table_name);
			return array('status'=>'2','msg'=>'we don\'t have skill '.$table_name.' with analyst.' );
		}
		

		 
	}

	function approveUpdateStatus($candidate_id,$table_name,$component_id){

		 
		$analyst_id = $this->getMinimumTaskHandlerAnalyst($table_name,$component_id); 
		if($analyst_id != '0'){
			$user = $this->session->userdata('logged-in-inputqc');
			$components_data = array(
				
				'status'=>'4',
				'updated_date'=>date('d-m-Y H:i:s'),
				'assigned_role'=>'analyst',
				'assigned_team_id'=>$analyst_id
				 
			);
			$this->db->where('candidate_id',$candidate_id);
			if ($this->db->update($table_name,$components_data)) {
				$insert_id = $this->db->insert_id();
				$components_log_data = array( 
					'candidate_id'=>$candidate_id,
					'status'=>'4','assigned_role'=>'analyst',
					'assigned_team_id'=>$analyst_id,
					'updated_date'=>date('d-m-Y H:i:s')
					 
				);
				$this->db->insert($table_name."_log",$components_log_data);
				return array('status'=>'1','msg'=>'success');
			}else{
				return array('status'=>'0','msg'=>'failled');
			}

		}else{
			$table_name = str_replace('_',' ',$table_name);
			return array('status'=>'2','msg'=>'we don\'t have skill '.$table_name.' with analyst.' );
		}
		 

	}


	function getMinimumTaskHandlerInputQC(){
 
		$count = array(); 
		$result = $this->db->select('team_id')->where('role','inputqc')->where('is_Active','1')->get('team_employee')->result_array(); 

		foreach ($result as $key => $value) {
			$candidate_detail = $this->db->where('is_submitted !=','2')->where('assigned_inputqc_id',$value['team_id'])->get('candidate')->num_rows();
			$row['team_id'] = $value['team_id'];
			$row['total'] = $candidate_detail;
			array_push($count, $row); 
		}
		
		$keys = array_column($count, 'total'); 
    	array_multisort($keys, SORT_ASC, $count); 
    	return $count[0]['team_id'];    	 
	}

	
	function getMinimumTaskHandlerAnalyst($table_name,$component_id){
 		
		$count = array(); 
		$team_id = '0'; 
		$query = "SELECT * FROM `team_employee` where `role` ='analyst' AND `is_Active`='1' AND `skills` REGEXP ".$component_id;
		$result = $this->db->query($query)->result_array(); 
		// print_r($result);
		// exit();
		if($this->db->query($query)->num_rows($query) > 0){
			foreach ($result as $key => $value) {
				 
				$analyst_data = $this->db->where('assigned_team_id',$value['team_id'])->get($table_name)->num_rows();

				$row['team_id'] = $value['team_id'];
				$row['total'] = $analyst_data;

				array_push($count, $row); 
			}
			$keys = array_column($count, 'total'); 
    		array_multisort($keys, SORT_ASC, $count);
    		$team_id = $count[0]['team_id'];
		} 
    	// print_r($count);/
		// echo $count[0]['team_id'];
    	return $team_id;    	 
	}

	function getSingleAssignedCaseDetails($candidate_id) {
 		$result = $this->db->where_in('candidate.candidate_id',$candidate_id)->select("candidate.*, candidate.package_name AS selected_package_id, tbl_client.*, tbl_client.package_components AS client_packages_list, packages.package_name, , candidate.communications as social")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->row_array();

 		$component_id = explode(',', $result['component_ids']);
 		$component = $this->db->where_in('component_id',$component_id)->get('components')->result_array();
 		// $componentIds = ['16','17','18','20'];
 		$form_values = json_decode($result['form_values'],true);
 		if (!is_array($form_values)) {
 			$form_values = json_decode($form_values,true);
 		}
 		// $form_values2 = isset($form_values1)?$form_values1:'';
        // $form_values = json_decode($form_values2,true);
 		$case_data  = array();
 		foreach ($component as $key => $value) {
 			$componetStatus = $this->getStatusFromComponent($result['candidate_id'],$value['component_id']);
	 		$inputQcStatus = isset($componetStatus['status'])?$componetStatus['status']:'0';
	 		$inputQcStatus = explode(',',$inputQcStatus);
	 		$insuff_remarks = json_decode(isset($componetStatus['insuff_remarks'])?$componetStatus['insuff_remarks']:'-',true);
	 		$verification_remarks = json_decode(isset($componetStatus['verification_remarks'])?$componetStatus['verification_remarks']:'-',true);
	 		$insuff_closure_remarks = json_decode(isset($componetStatus['insuff_closure_remarks'])?$componetStatus['insuff_closure_remarks']:'-',true); 
	 		$in_p = isset($componetStatus['in_progress_remarks'])?$componetStatus['in_progress_remarks']:'-';
	 		$progress_remarks = json_decode(isset($componetStatus['progress_remarks'])?$componetStatus['progress_remarks']:$in_p,true); 

	 		$insuff_rem = '-';
	 		$insuff_closure='-';
	 		$verification = '';
 			$valid_comp = array('Criminal Status','Court Record','Document Check','Drug Test','Highest Education','Previous Employment','Previous Address','Reference','Credit / Cibil Check','Bankruptcy Check','Adverse Media/Media Database Check','Directorship Check','Global Sanctions/ AML','Health Checkup Check','Previous Landlord Reference Check','Covid-19 Check');
 			if (!in_array($value['component_name'],$valid_comp)) {
 				$insuff_rem = isset($componetStatus['insuff_remarks'])?$componetStatus['insuff_remarks']:'-';
 				$insuff_closure = isset($componetStatus['insuff_closure_remarks'])?$componetStatus['insuff_closure_remarks']:'-';
 				$verification = isset($componetStatus['verification_remarks'])?$componetStatus['verification_remarks']:'-';
 			}

	 		$insuff_close_date = explode(',',isset($componetStatus['insuff_close_date']) ? $componetStatus['insuff_close_date'] : '-');
	 		$insuff_created_date = explode(',',isset($componetStatus['insuff_created_date']) ? $componetStatus['insuff_created_date'] : '-');
	 		$results = '';
	 		if ($value['component_id'] =='7') {
	 			$check_highest_education = isset($form_values['highest_education']) ? $form_values['highest_education'] : 100;
	 			if (empty($check_highest_education)) {
	 				$check_highest_education = 100;
	 			}
	 			$results = $this->db->where_in('education_type_id',$check_highest_education)->get('education_type')->result_array();
	 		}else if($value['component_id'] =='3'){
	 			$document_type_id = isset($form_values['document_check']) ? $form_values['document_check'] : 100;
	 			if (empty($document_type_id)) {
	 				$document_type_id = 100;
	 			}
	 			$results = $this->db->where_in('document_type_id',$document_type_id)->get('document_type')->result_array();
	 		}else if ($value['component_id'] =='4') {
	 			$drug_test_type_id = isset($form_values['drug_test']) ? $form_values['drug_test'] : 1;
	 			if (empty($drug_test_type_id)) {
	 				$drug_test_type_id = 100;
	 			}
	 			$results = $this->db->where_in('drug_test_type_id',$drug_test_type_id)->get('drug_test_type')->result_array();
	 		}else if ($value['component_id'] =='27') {
	 			$document_type_id = isset($form_values['right_to_work']) ? $form_values['right_to_work'] : 2;
	 			if (empty($document_type_id)) {
	 				$document_type_id = 100;
	 			}
	 			$results = $this->db->where_in('document_type_id',$document_type_id)->get('document_type')->result_array();
	 		}

 			foreach ($inputQcStatus as $inputQcStatuskey => $componentValue) {
 				$formNumber =  $inputQcStatuskey + 1;
 				$row['formNumber'] = $formNumber;
 				$row['position'] = $inputQcStatuskey;
	 			$row['candidate_details'] = $result;
	 			$row['component_id'] = $value['component_id'];
	 			$row['component_name'] = $value[$this->config->item('show_component_name')]; 
	 			$row['segment'] = isset($result['segment'])?$result['segment']:''; 
	 			$row['location'] = isset($result['location'])?$result['location']:''; 
	 			$row['client_id'] = $result['client_id']; 
	 			$row['client_name'] = $result['client_name']; 
	 			$row['candidate_id'] = $result['candidate_id']; 
	 			$row['is_report_generated'] = $result['is_report_generated']; 
	 			$row['title'] = $result['title']; 
	 			$row['first_name'] = $result['first_name']; 
	 			$row['last_name'] = $result['last_name']; 
	 			$row['father_name'] = $result['father_name']; 
	 			// $row['phone_number'] = $result['phone_number']; 
	 			 $country_code = isset($result['country_code'])?$result['country_code']:'+91';  
 			 $row['phone_number'] = $country_code.' '.$result['phone_number']; 
	 			$row['email_id'] = $result['email_id']; 
	 			$row['date_of_birth'] = $result['date_of_birth']; 
	 			$row['date_of_joining'] = $result['date_of_joining']; 
	 			$row['employee_id'] = $result['employee_id']; 
	 			$row['package_name'] = $result['package_name']; 
	 			$row['remark'] = $result['remark']; 
	 			$row['socials'] = $result['social']; 
	 			$row['priority'] = $result['priority']; 
	 			$row['week'] = $result['week']; 
	 			$row['start_time'] = $result['contact_start_time']; 
	 			$row['end_time'] = $result['contact_end_time']; 
	 			$row['document_uploaded_by'] = $result['document_uploaded_by']; 
	 			$row['document_uploaded_by_email_id'] = $result['document_uploaded_by_email_id']; 
	 			$row['created_date'] = date('d-m-Y', strtotime($result['created_date']) );  
	 			$row['updated_date'] = date('d-m-Y', strtotime($result['updated_date']) );  
	 			$row['is_submitted'] = $result['is_submitted'];
	 			$row['form_values'] = $result['form_values'];
	 			$row['client_packages_list'] = $result['client_packages_list'];
	 			$row['selected_package_id'] = $result['selected_package_id']; 
	 			$type_of_val ='';
	 			if ($results !='' && $value['component_id'] =='7') {
	 				$type_of_val = isset($results[$inputQcStatuskey]['education_type_name'])?$results[$inputQcStatuskey]['education_type_name']:'';
	 			}else if ($results !='' && $value['component_id'] =='3') {
	 				$type_of_val = isset($results[$inputQcStatuskey]['document_type_name'])?$results[$inputQcStatuskey]['document_type_name']:'';
	 			}else if ($results !='' && $value['component_id'] =='4') {
	 				$type_of_val = isset($results[$inputQcStatuskey]['drug_test_type_name'])?$results[$inputQcStatuskey]['drug_test_type_name']:'';
	 			}else if ($results !='' && ($value['component_id'] =='3' || $value['component_id'] =='27')) {
	 				$type_of_val = isset($results[$inputQcStatuskey]['document_type_name'])?$results[$inputQcStatuskey]['document_type_name']:'';
	 			}
	 			$row['value_type'] = $type_of_val;
	 			
	 			// Tat Details
	 			$row['tat_start_date'] = $this->convert_date_order(isset($result['tat_start_date'])?$result['tat_start_date']:'');
	 			$row['tat_pause_date'] = $this->convert_date_order(isset($result['tat_pause_date'])?$result['tat_pause_date']:'');
	 			$row['tat_re_start_date'] = $this->convert_date_order(isset($result['tat_re_start_date'])?$result['tat_re_start_date']:'');
	 			$row['tat_end_date'] = $this->convert_date_order(isset($result['tat_end_date'])?$result['tat_end_date']:'');
	 			$row['report_generated_date'] = $this->convert_date_order(isset($result['report_generated_date'])?$result['report_generated_date']:'');
	 			$row['tat_pause_resume_status'] = isset($result['tat_pause_resume_status'])?$result['tat_pause_resume_status']:'';
	 			if($result['priority'] == '1') {
	 				$row['tat_days'] = isset($result['medium_priority_days'])?$result['medium_priority_days']:''; 	
	 			} else if($result['priority'] == '2') {
	 				$row['tat_days'] = isset($result['high_priority_days'])?$result['high_priority_days']:''; 
	 			} else {
	 				$row['tat_days'] = isset($result['low_priority_days'])?$result['low_priority_days']:''; 
	 			}


	 			
	 			$inputQcComStatus = $this->stringExplode(isset($componetStatus['status'])?$componetStatus['status']:'');
	 			$inputQcComDate = $this->stringExplode(isset($componetStatus['inputqc_status_date'])?$componetStatus['inputqc_status_date']:'');
	 			$row['inputqc_status_date'] = isset($inputQcComDate[$inputQcStatuskey])?$inputQcComDate[$inputQcStatuskey]:'NA';
	 			$analyst_specialist_com_date = $this->stringExplode(isset($componetStatus['analyst_status_date'])?$componetStatus['analyst_status_date']:'');
	 			$row['analyst_status_date'] = isset($analyst_specialist_com_date[$inputQcStatuskey])?$analyst_specialist_com_date[$inputQcStatuskey]:'NA';
	 			$outputqc_com_date = $this->stringExplode(isset($componetStatus['outputqc_status_date'])?$componetStatus['outputqc_status_date']:'');
	 			$row['outputqc_status_date'] = isset($outputqc_com_date[$inputQcStatuskey])?$outputqc_com_date[$inputQcStatuskey]:'NA';
	 			$row['status'] = isset($inputQcComStatus[$inputQcStatuskey])?$inputQcComStatus[$inputQcStatuskey]:'0';
	 			$analystStatus = $this->stringExplode(isset($componetStatus['analyst_status'])?$componetStatus['analyst_status']:'0');
	 			$row['analyst_status'] = isset($analystStatus[$inputQcStatuskey])?$analystStatus[$inputQcStatuskey]:'0';
	 			$outputQCStatus =  $this->stringExplode(isset($componetStatus['output_status'])?$componetStatus['output_status']:'0'); 
	 			$row['output_status'] = isset($outputQCStatus[$inputQcStatuskey])?$outputQCStatus[$inputQcStatuskey]:'0';

	 			$insuff_team_role = $this->stringExplode(isset($componetStatus['insuff_team_role'])?$componetStatus['insuff_team_role']:'Role');
	 			$row['insuff_team_role'] = isset($insuff_team_role[$inputQcStatuskey])?$insuff_team_role[$inputQcStatuskey]:'0';

	 			$insuff_team_id = $this->stringExplode(isset($componetStatus['insuff_team_id'])?$componetStatus['insuff_team_id']:'0');
	 			$row['insuff_team_id'] = isset($insuff_team_id[$inputQcStatuskey])?$insuff_team_id[$inputQcStatuskey]:'0';
	 			$insuff_team = $this->getTeamEmpData(isset($insuff_team_id[$inputQcStatuskey])?$insuff_team_id[$inputQcStatuskey]:'0'); 
	 			$row['insuff_team_name'] = isset($insuff_team['name'])?$insuff_team['name']:'-';


	 			$assigned_role = $this->stringExplode(isset($componetStatus['assigned_role'])?$componetStatus['assigned_role']:'Role');
	 			$row['assigned_role'] = isset($assigned_role[$inputQcStatuskey])?$assigned_role[$inputQcStatuskey]:'0';
	 			$assigned_team_id = $this->stringExplode(isset($componetStatus['assigned_team_id'])?$componetStatus['assigned_team_id']:'0');
	 			$row['assigned_team_id'] = isset($assigned_team_id[$inputQcStatuskey])?$assigned_team_id[$inputQcStatuskey]:'0';

	 			$assigned_team = $this->getTeamEmpData(isset($assigned_team_id[$inputQcStatuskey])?$assigned_team_id[$inputQcStatuskey]:'0'); 
	 			$row['assigned_team_name'] = isset($assigned_team['name'])?$assigned_team['name']:'-'; 
	 			$row['insuff_remarks'] = isset($insuff_remarks[$inputQcStatuskey]['insuff_remarks'])?$insuff_remarks[$inputQcStatuskey]['insuff_remarks']:$insuff_rem;
	 			$row['insuff_closure_remarks'] = isset($insuff_closure_remarks[$inputQcStatuskey]['insuff_closure_remarks'])?$insuff_closure_remarks[$inputQcStatuskey]['insuff_closure_remarks']:$insuff_closure;
	 			$row['verification_remarks'] = isset($verification_remarks[$inputQcStatuskey]['verification_remarks'])?$verification_remarks[$inputQcStatuskey]['verification_remarks']:$verification;
	 			$in_pro = isset($progress_remarks[$inputQcStatuskey]['in_progress_remarks'])?$progress_remarks[$inputQcStatuskey]['in_progress_remarks']:'-';
	 			$row['progress_remarks'] = isset($progress_remarks[$inputQcStatuskey]['progress_remarks'])?$progress_remarks[$inputQcStatuskey]['progress_remarks']:$in_pro;

	 			$row['panel'] = isset($form_values['drug_test'][$inputQcStatuskey])?$form_values['drug_test'][$inputQcStatuskey]:'-';
	 			$row['insuff_created_date'] = isset($insuff_created_date[$inputQcStatuskey])?$insuff_created_date[$inputQcStatuskey]:'-';
	 			$row['insuff_close_date'] = isset($insuff_close_date[$inputQcStatuskey])?$insuff_close_date[$inputQcStatuskey]:'-';
	 			$roles = array('analyst','specialist');
	 			$variable_array = array(
	 				'component_id' => $value['component_id'],
	 				'segment' => $result['segment']
	 			);
	 			$row['emp_data_analyst'] = $this->getAnalystAndSpecialistTeamList($variable_array);
	 			$row['emp_data_insuff_analyst'] = $this->getInsuffAnalystAndSpecialistTeamList();

	 			if($result['tat_start_date'] != null && $result['report_generated_date'] != null && $result['tat_pause_date'] != null && $result['tat_pause_date'] != '' && $result['tat_re_start_date'] != null && $result['tat_re_start_date'] != ''){
					$restart_date = 0;
					$start_date = 0; 
						$start_date = $this->number_of_working_days($result['tat_start_date'],$result['tat_pause_date']);
				 
					$restart_date = $this->number_of_working_days($result['tat_re_start_date'],$result['report_generated_date']);
				 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($result['tat_start_date'] != null && $result['tat_pause_date'] != null && $result['tat_pause_date'] != '' && $result['tat_re_start_date'] != null && $result['tat_re_start_date'] != ''){
					$restart_date = 0;
					$start_date = 0;
					 
						if ($result['report_generated_date'] !='') { 
						$restart_date = $this->number_of_working_days($result['tat_re_start_date'],$result['report_generated_date']);
					 }else{
					 	$restart_date = $this->number_of_working_days($result['tat_re_start_date'],date('d-m-Y'));
					 }
					 
					 
						$start_date = $this->number_of_working_days($result['tat_start_date'],$result['tat_pause_date']);
					 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($result['tat_start_date'] != null && $result['tat_pause_date'] != null && $result['tat_pause_date'] != ''){
					$restart_date = 0;

					$start_date = 0; 
					 
						$start_date = $this->number_of_working_days($result['tat_start_date'],$result['tat_pause_date']);
					 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($result['tat_start_date'] != null && $result['tat_start_date'] != ''){
						if ($result['report_generated_date'] !='' && $result['report_generated_date'] !=null) { 

						$row['left_tat_days'] = $this->number_of_working_days($result['tat_start_date'],$result['report_generated_date']).' days';
					}else{
						$row['left_tat_days'] = $this->number_of_working_days($result['tat_start_date'],date('d-m-Y')).' days';	
					}
					 
				}else{
					$row['left_tat_days'] = '-';
					$row['tat_overdue'] = '-';
				}				

	 			
	 			$row['uploaded_loa'] = $this->db->select('signature_img')->where('candidate_id',$candidate_id)->get('signature')->row_array();
	 			array_push($case_data, $row);

 			}
 		}
 		return $case_data;
	}

	function convert_date_order($date){
		$d = 'NA';
		if ($date !='' && $date !=null  && $date !='-') { 
			$d = date('d-m-Y H:i', strtotime($date));
		}
		return $d;
	}


	function getAnalystAndSpecialistTeamList($variable_array) {
		$component_id = isset($variable_array['component_id'])?$variable_array['component_id']:'0';
		$segment = isset($variable_array['segment'])?$variable_array['segment']:'0';
		
		if ($component_id =='') {
			$component_id = 0;
		}

		$assigned_segment_query = '';
		if ($segment != '' && $segment != 0 ) {
			$assigned_segment_query = ' AND assigned_segments REGEXP '.$segment;
		}
		$query = "SELECT team_id,first_name,last_name,role,skills FROM `team_employee` where (`role` ='analyst' OR `role` ='specialist') AND `is_Active`='1' AND `skills` REGEXP ".$component_id.$assigned_segment_query;
		$result = $this->db->query($query)->result_array();  

		$newTeamIds = array();
		if($this->db->query($query)->num_rows() > 0){
			
			foreach ($result as $key => $value) {
				// echo $value['team_id'].":".$value['skills']."\n";
				$skill = explode(',',$value['skills']);
				if (in_array($component_id,$skill)) {
					// echo $value['team_id'].":".$value['skills']."\n";
					array_push($newTeamIds,$value);
				}
				 
			}
		}
		return $newTeamIds;
	}


	function getInsuffAnalystAndSpecialistTeamList(){

		$query = "SELECT team_id,first_name,last_name,role,skills FROM `team_employee` where `role` ='insuff analyst'  AND `is_Active`='1' ";
		$result = $this->db->query($query)->result_array();  
 
		return $result;
	}


	function stringExplode($string){
		return explode(',',isset($string)?$string:'0');
	}
	
	function getStatusFromComponent($candidate_id,$component_id){
		// echo $component_id."<br>";
		$status = '';
		$table_name = $this->utilModel->getComponent_or_PageName($component_id);
		$component_fill_date  = '';
		 

		// $result = $this->db->select('*')->where('candidate_id',$candidate_id)->join('team_employee','team_employee.team_id = '.$table_name.'.assigned_team_id','left')->get($table_name)->row_array();


		/*$result = $this->db->select($table_name.'.status,'.$table_name.'.assigned_team_id,'.$table_name.'.analyst_status,'.$table_name.'.output_status,'.$table_name.'.analyst_status,'.$table_name.'.insuff_team_role,'.$table_name.'.insuff_team_id,'.$table_name.'.assigned_role,
		 	team_employee.first_name,team_employee.first_name,team_employee.last_name,team_employee.contact_no')->where('candidate_id',$candidate_id)->join('team_employee','team_employee.team_id = '.$table_name.'.assigned_team_id','left')->get($table_name)->row_array();*/

		$result = $this->db->select($table_name.'.*','
		 	team_employee.first_name,team_employee.first_name,team_employee.last_name,team_employee.contact_no')->where($table_name.'.candidate_id',$candidate_id)->join('team_employee','team_employee.team_id = '.$table_name.'.assigned_team_id','left')->get($table_name)->row_array();

		 


		return $result;
	}

	function getComponentForms($candidate_id){
 		// $team_id = '1';
 		 
 		// $component = array('court_records','criminal_checks','current_employment','document_check','drugtest','education_details','globaldatabase','permanent_address','present_address','previous_address','previous_employment','reference');

 		// Total Data for team Id;
 		// echo $candidate_id;
 		// exit();
 		$row =array();
 		foreach ($component as $key => $value) {
 			$query = "SELECT * FROM ".$value;
 			// echo  $query;
 			// exit();
 			// SELECT * FROM `court_records` WHERE insuff_team_id REGEXP '43' AND (status REGEXP '3' OR analyst_status REGEXP '3')
 			$result = $this->db->query($query)->result_array();

 			if($this->db->query($query)->num_rows() > 0){ 
 				// array_push($row,$result); 
 				$row[$value] = $result; 
 			}
 			
 		}
 
 		$final_data = array();

 		$k = 0;
 		foreach ($row as $mainKey => $value) {
 			 
 			
 			// 1
 			if($mainKey == 'criminal_checks'){
 				 foreach ($value as $criminal_checks_key => $criminal_checks_value) {
 					$assigned_team_ids = explode(",",$criminal_checks_value['assigned_team_id']); 
 					// $court_address = json_decode($court_records_value['address'],true);
 					foreach ($assigned_team_ids as $assigned_team_ids_key => $assigned_team_ids_value) {
 						$analyst_status = explode(",", $criminal_checks_value['analyst_status']);
 						// if($assigned_team_ids_value == $team_id && ($analyst_status[$assigned_team_ids_key] != '3' && $analyst_status[$assigned_team_ids_key] != '10')){

 							$criminal_checks['component_name'] = $mainKey;
 							$criminal_checks['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$criminal_checks['criminal_check_id'] = $criminal_checks_value['criminal_check_id'];
 							$criminal_checks['candidate_id'] = $criminal_checks_value['candidate_id'];
 							$criminal_checks['candidate_detail'] = $this->analystModel->getCandidateInfo($criminal_checks_value['candidate_id']);
 							// $court_records['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							 
 							$court_address = json_decode($criminal_checks_value['address'],true);
 							// print_r($court_address[$assigned_team_ids_key]);
 							// echo "<br>";
 							$criminal_checks['address'] = isset($court_address[$assigned_team_ids_key]['address'])?$court_address[$assigned_team_ids_key]['address']:'';

 							$pin_code = json_decode($criminal_checks_value['pin_code'],true);
 							$criminal_checks['pin_code'] = isset($pin_code[$assigned_team_ids_key]['pincode'])?$pin_code[$assigned_team_ids_key]['pincode']:'';
 							
 							$city = json_decode($criminal_checks_value['city'],true);
 							$criminal_checks['city'] = isset($city[$assigned_team_ids_key]['city'])?$city[$assigned_team_ids_key]['city']:'';
 							 
 							$state = json_decode($criminal_checks_value['state'],true);
 							$criminal_checks['state'] = isset($state[$assigned_team_ids_key]['state'])?$state[$assigned_team_ids_key]['state']:'';
 							
 							$country = json_decode($criminal_checks_value['country'],true);
 							$criminal_checks['country'] = isset($country[$assigned_team_ids_key]['country'])?$country[$assigned_team_ids_key]['country']:'';
 							 

 							$status = explode(",", $criminal_checks_value['status']);
 							$criminal_checks['status'] = isset($status[$assigned_team_ids_key])?$status[$assigned_team_ids_key]:'';
 
 							
 							$criminal_checks['analyst_status'] = isset($analyst_status[$assigned_team_ids_key])?$analyst_status[$assigned_team_ids_key]:'';

 							$insuff_status = explode(",", $criminal_checks_value['insuff_status']);
 							$criminal_checks['insuff_status'] = isset($insuff_status[$assigned_team_ids_key])?$insuff_status[$assigned_team_ids_key]:'';

 							$output_status = explode(",", $criminal_checks_value['output_status']);
 							$criminal_checks['output_status'] = isset($output_status[$assigned_team_ids_key])?$output_status[$assigned_team_ids_key]:'';

 							$assigned_role = explode(",", $criminal_checks_value['assigned_role']);
 							$criminal_checks['assigned_role'] = isset($assigned_role[$assigned_team_ids_key])?$assigned_role[$assigned_team_ids_key]:'';

 							$assigned_team_id = explode(",", $criminal_checks_value['assigned_team_id']);
 							$criminal_checks['assigned_team_id'] = isset($assigned_team_id[$assigned_team_ids_key])?$assigned_team_id[$assigned_team_ids_key]:'';
 							
 							$criminal_checks['created_date'] = $criminal_checks_value['created_date'];
 							$criminal_checks['updated_date'] = $criminal_checks_value['updated_date'];
 							$criminal_checks['index'] = $assigned_team_ids_key;
 							array_push($final_data, $criminal_checks);
 						// }
 						
 					}
 					
 				}
 			}
 			// 2
 			if($mainKey == 'court_records'){
 				 
 				foreach ($value as $court_records_key => $court_records_value) {
 					$assigned_team_ids = explode(",",$court_records_value['assigned_team_id']); 
 					// $court_address = json_decode($court_records_value['address'],true);
 					foreach ($assigned_team_ids as $assigned_team_ids_key => $assigned_team_ids_value) {
 						$analyst_status = explode(",", $court_records_value['analyst_status']);
 						// if($assigned_team_ids_value == $team_id && ($analyst_status[$assigned_team_ids_key] != '3' &&$analyst_status[$assigned_team_ids_key] != '10')){

 							$court_records['component_name'] = $mainKey;
 							$court_records['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$court_records['court_records_id'] = $court_records_value['court_records_id'];
 							$court_records['candidate_id'] = $court_records_value['candidate_id'];
 							$court_records['candidate_detail'] = $this->analystModel->getCandidateInfo($court_records_value['candidate_id']);
 							// $court_records['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							 
 							$court_address = json_decode($court_records_value['address'],true);
 							// print_r($court_address[$assigned_team_ids_key]);
 							// echo "<br>";
 							$court_records['address'] = isset($court_address[$assigned_team_ids_key]['address'])?$court_address[$assigned_team_ids_key]['address']:'';

 							$pin_code = json_decode($court_records_value['pin_code'],true);
 							$court_records['pin_code'] = isset($pin_code[$assigned_team_ids_key]['pincode'])?$pin_code[$assigned_team_ids_key]['pincode']:'';
 							
 							$city = json_decode($court_records_value['city'],true);
 							$court_records['city'] = isset($city[$assigned_team_ids_key]['city'])?$city[$assigned_team_ids_key]['city']:'';
 							 
 							$state = json_decode($court_records_value['state'],true);
 							$court_records['state'] = isset($state[$assigned_team_ids_key]['state'])?$state[$assigned_team_ids_key]['state']:'';
 							
 							$country = json_decode($court_records_value['country'],true);
 							$court_records['country'] = isset($country[$assigned_team_ids_key]['country'])?$country[$assigned_team_ids_key]['country']:'';
 							 

 							$status = explode(",", $court_records_value['status']);
 							$court_records['status'] = isset($status[$assigned_team_ids_key])?$status[$assigned_team_ids_key]:'';

 							
 							$court_records['analyst_status'] = isset($analyst_status[$assigned_team_ids_key])?$analyst_status[$assigned_team_ids_key]:'';

 							$insuff_status = explode(",", $court_records_value['insuff_status']);
 							$court_records['insuff_status'] = isset($insuff_status[$assigned_team_ids_key])?$insuff_status[$assigned_team_ids_key]:'';

 							$output_status = explode(",", $court_records_value['output_status']);
 							$court_records['output_status'] = isset($output_status[$assigned_team_ids_key])?$output_status[$assigned_team_ids_key]:'';

 							$assigned_role = explode(",", $court_records_value['assigned_role']);
 							$court_records['assigned_role'] = isset($assigned_role[$assigned_team_ids_key])?$assigned_role[$assigned_team_ids_key]:'';

 							$assigned_team_id = explode(",", $court_records_value['assigned_team_id']);
 							$court_records['assigned_team_id'] = isset($assigned_team_id[$assigned_team_ids_key])?$assigned_team_id[$assigned_team_ids_key]:'';
 							
 							$court_records['created_date'] = $court_records_value['created_date'];
 							$court_records['updated_date'] = $court_records_value['updated_date'];
 							$court_records['index'] = $assigned_team_ids_key;
 							array_push($final_data, $court_records);
 							 
 						// }
 						
 					}
 					
 				}
 			}

 			// 3
 			if($mainKey == 'document_check'){
 				foreach ($value as $court_records_key => $document_check_value) {
 					$assigned_team_id = explode(",",$document_check_value['assigned_team_id']); 
 					$analyst_status = explode(",",$document_check_value['analyst_status']);
 					foreach ($assigned_team_id as $dc_key => $assigned_team_id_value) {
 						// if($assigned_team_id_value == $team_id && ($analyst_status[$dc_key] != "3" && $analyst_status[$dc_key] != '10')){
		 					$candidateInfo = $this->analystModel->getCandidateInfo($document_check_value['candidate_id']);
		 					$document_check['component_name'] = $mainKey;
		 					$document_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
		 					$document_check['candidate_id'] = $document_check_value['candidate_id'];
		 					$document_check['candidate_detail'] = $candidateInfo;

		 					$candidateinfo = json_decode($candidateInfo['form_values']);
		 					$candidateinfo = json_decode($candidateinfo,true);

		 					 
		 					// $getIndexNumber = array_search($candidateinfo['document_check'][$dc_key],$candidateinfo['document_check']);

		 					$status = explode(",",$document_check_value['status']); 
			 				$document_check['status'] = isset($status[$dc_key])?$status[$dc_key]:'';
			 					 
			 				
			 				$document_check['analyst_status'] = isset($analyst_status[$dc_key])?$analyst_status[$dc_key]:'';

			 				$insuff_status = explode(",",$document_check_value['insuff_status']);
			 				$document_check['insuff_status'] = isset($insuff_status[$dc_key])?$insuff_status[$dc_key]:'';

			 				$document_check['updated_date'] = $document_check_value['updated_date'];

			 				$document_check['index'] = $dc_key;	
			 				array_push($final_data, $document_check);
			 			// }
	 					 
	 				}
 					// array_push($final_data, $document_check);
 				}
 			}

 			// 4
 			if($mainKey == 'drugtest'){ 

 				foreach ($value as $subkey => $subValues) {
 					$assigned_team_id = explode(",",$subValues['assigned_team_id']); 
 					// print_r($assigned_team_id);
 					// echo "<br>";
 					foreach ($assigned_team_id as $drugtest_key => $drugtest_value) {
 						$analyst_status = explode(",",$subValues['analyst_status']);
 						// if($drugtest_value == $team_id && ($analyst_status[$drugtest_key] != '3' && $analyst_status[$drugtest_key] != '10')){
	 						 
		 					$drugtest['component_name'] = $mainKey;
		 					$drugtest['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
		 					$drugtest['drugtest_id'] = $subValues['drugtest_id']; 
		 					$drugtest['candidate_id'] = $subValues['candidate_id'];
		 					$drugtest['candidate_detail'] = $this->analystModel->getCandidateInfo($subValues['candidate_id']);
		 					$address = json_decode($subValues['address'],true); 
		 					$drugtest['address'] = isset($address[$drugtest_key]['address'])?$address[$drugtest_key]['address']:'';

		 					$candidate_name = json_decode($subValues['candidate_name'],true);
		 					$drugtest['candidate_name'] = isset($candidate_name[$drugtest_key]['candidate_name'])?$candidate_name[$drugtest_key]['candidate_name']:'';
		 					 

		 					$father_name = json_decode($subValues['father__name'],true);
		 					$drugtest['father_name'] = isset($father_name[$drugtest_key]['father_name'])?$father_name[$drugtest_key]['father_name']:''; 

		 					$dob = json_decode($subValues['dob'],true);
		 					$drugtest['dob'] = isset($dob[$drugtest_key]['dob'])?$dob[$drugtest_key]['dob']:''; 
		 					 
		 					$code = json_decode($subValues['code'],true);
		 					$drugtest['code'] = isset($code[$drugtest_key]['code'])?$code[$drugtest_key]['code']:'';
		 					// array_push($drugtest,$code[$drugtest_key]);

		 					$mobile_number = json_decode($subValues['mobile_number'],true);
		 					$drugtest['mobile_number'] = isset($mobile_number[$drugtest_key]['mobile_number'])?$mobile_number[$drugtest_key]['mobile_number']:'';
		 					 
		 					// $status = json_decode($subValues['status'],true);
		 					$status = explode(",",$subValues['status']); 
		 					$drugtest['status'] = isset($status[$drugtest_key])?$status[$drugtest_key]:'';
		 					// array_push($drugtest,isset($status[$drugtest_key])?$status[$drugtest_key]:'');

		 					
		 					$drugtest['analyst_status'] = isset($analyst_status[$drugtest_key])?$analyst_status[$drugtest_key]:'';
		 					// array_push($drugtest,isset($analyst_status[$drugtest_key])?$analyst_status[$drugtest_key]:'');

		 					$insuff_status = explode(",",$subValues['insuff_status']);
		 					$drugtest['insuff_status'] = isset($insuff_status[$drugtest_key])?$insuff_status[$drugtest_key]:'';
		 					// array_push($drugtest,isset($specialist_status[$drugtest_key])?$specialist_status[$drugtest_key]:'');

		 					$output_status = json_decode($subValues['output_status'],true);
		 					$drugtest['output_status'] = isset($subValues['output_status'])?$subValues['output_status']:'';
		 					// array_push($drugtest,isset($output_status[$drugtest_key])?$output_status[$drugtest_key]:'');

		 					$remarks_updateed_by_id = json_decode($subValues['remarks_updateed_by_id'],true);
		 					$drugtest['remarks_updateed_by_id'] = isset($remarks_updateed_by_id[$drugtest_key]['remarks_updateed_by_id'])?$remarks_updateed_by_id[$drugtest_key]['remarks_updateed_by_id']:'';
		 					// array_push($drugtest,isset($remarks_updateed_by_id[$drugtest_key])?$remarks_updateed_by_id[$drugtest_key]:'');

		 					$assigned_role = explode(",",$subValues['assigned_role']);
		 					$drugtest['assigned_role'] = isset($assigned_role[$drugtest_key])?$assigned_role[$drugtest_key]:'';
		 					// array_push($drugtest,isset($assigned_role[$drugtest_key])?$assigned_role[$drugtest_key]:'');

		 					$assigned_team_id =explode(",",$subValues['assigned_team_id']);
		 					$drugtest['assigned_team_id'] = isset($assigned_team_id[$drugtest_key])?$assigned_team_id[$drugtest_key]:'';
		 					// array_push($drugtest,isset($assigned_team_id[$drugtest_key])?$assigned_team_id[$drugtest_key]:'');

		 					 
		 					$drugtest['created_date'] = $subValues['created_date']; 
		 					$drugtest['updated_date'] = $subValues['updated_date'];
		 					$drugtest['index'] = $drugtest_key;
		 					
		 					// $f++;
		 					array_push($final_data, $drugtest);
 						// }
 						 
 					}
 				}
 				// $final_data[$mainKey] = $drugtest;
 				
 			}
 			// 5
 			if($mainKey == 'globaldatabase'){
 				foreach ($value as $globaldatabase_key => $globaldatabase_value) {
 					$global_assigned_team_id =explode(",",$globaldatabase_value['assigned_team_id']);
 					// if($global_assigned_team_id == $team_id && ($globaldatabase_value['analyst_status'] != '3' && $globaldatabase_value['analyst_status'] != '10')){
	 					$globaldatabase_value['component_name'] = $mainKey;
	 					$globaldatabase_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
	 					$globaldatabase_value['candidate_detail'] = $this->analystModel->getCandidateInfo($globaldatabase_value['candidate_id']);
	 					$globaldatabase_value['index'] = $globaldatabase_key;
	 					array_push($final_data, $globaldatabase_value);
 					// }
 				}
 			}
 			//  6
 			if($mainKey == 'current_employment'){
 				foreach ($value as $current_employment_key => $current_employment_value) {
 					$ec_assigned_team_id =explode(",",$current_employment_value['assigned_team_id']);
 					// if($ec_assigned_team_id == $team_id && ($current_employment_value['analyst_status'] != '3' && $current_employment_value['analyst_status'] != '10')){
 						$current_employment_value['component_name'] = $mainKey;
	 					$current_employment_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
	 					$current_employment_value['candidate_detail'] = $this->analystModel->getCandidateInfo($current_employment_value['candidate_id']);
	 					$current_employment_value['index'] = $current_employment_key;
	 					array_push($final_data, $current_employment_value);
 					// }analystModel
 					
 				}
 			}

 			// 7 
 			if($mainKey == 'education_details'){
 				// $education_details = array();
 				// $g = 0;
 				foreach ($value as $subkey => $subValues) {
 					$assigned_team_id = explode(",",$subValues['assigned_team_id']); 

 					foreach ($assigned_team_id as $education_details_key => $education_details_value) {
 						$analyst_status = explode(",",$subValues['analyst_status']);
 						
 						// if($education_details_value == $team_id && ($analyst_status[$education_details_key] != '3' && $analyst_status[$education_details_key] != '10')){
   
		 					$education_details['component_name'] = 'Education';
		 					$education_details['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
		 					// array_push($education_details, $subValues['education_details_id']);
		 					// array_push($education_details, $subValues['candidate_id']);
		 					$education_details['education_details_id'] = $subValues['education_details_id'];
		 					$education_details['candidate_id'] = $subValues['candidate_id'];
		 					$education_details['candidate_detail'] = $this->analystModel->getCandidateInfo($subValues['candidate_id']);
		 					$type_of_degree = json_decode($subValues['type_of_degree'],true);
		 					$education_details['type_of_degree'] = isset($type_of_degree[$education_details_key]['type_of_degree'])?$type_of_degree[$education_details_key]['type_of_degree']:'';
		 					$major = json_decode($subValues['major'],true);
		 					// array_push($education_details,isset($major[$education_details_key])?$major[$education_details_key]:'');
		 					$education_details['major'] = isset($major[$education_details_key]['major'])?$major[$education_details_key]['major']:'';


		 					$university_board = json_decode($subValues['university_board'],true);
		 					// array_push($education_details,isset($university_board[$education_details_key])?$university_board[$education_details_key]:'');
		 					$education_details['university_board'] = isset($university_board[$education_details_key]['university_board'])?$university_board[$education_details_key]['university_board']:'';

		 					$college_school = json_decode($subValues['college_school'],true);
		 					// array_push($education_details,isset($college_school[$education_details_key])?$college_school[$education_details_key]:'');
		 					$education_details['college_school'] = isset($college_school[$education_details_key]['college_school'])?$college_school[$education_details_key]['college_school']:'';

		 					$address_of_college_school = json_decode($subValues['address_of_college_school'],true);
		 					// array_push($education_details,isset($address_of_college_school[$education_details_key])?$address_of_college_school[$education_details_key]:'');
		 					$education_details['address_of_college_school'] = isset($address_of_college_school[$education_details_key]['address_of_college_school'])?$address_of_college_school[$education_details_key]['address_of_college_school']:'';

		 					$course_start_date = json_decode($subValues['course_start_date'],true);
		 					// array_push($education_details,isset($course_start_date[$education_details_key])?$course_start_date[$education_details_key]:'');
		 					$education_details['course_start_date'] = isset($course_start_date[$education_details_key]['course_start_date'])?$course_start_date[$education_details_key]['course_start_date']:'';

		 					$course_end_date = json_decode($subValues['course_end_date'],true);
		 					// array_push($education_details,isset($course_end_date[$education_details_key])?$course_end_date[$education_details_key]:'');
		 					$education_details['course_end_date'] = isset($course_end_date[$education_details_key]['course_end_date'])?$course_end_date[$education_details_key]['course_end_date']:'';

		 					$registration_roll_number = json_decode($subValues['registration_roll_number'],true);
		 					// array_push($education_details,isset($registration_roll_number[$education_details_key])?$registration_roll_number[$education_details_key]:'');
		 					$education_details['registration_roll_number'] = isset($registration_roll_number[$education_details_key]['registration_roll_number'])?$registration_roll_number[$education_details_key]['registration_roll_number']:'';

		 					$year_of_passing = json_decode($subValues['year_of_passing'],true);
		 					// array_push($education_details,isset($year_of_passing[$education_details_key])?$year_of_passing[$education_details_key]:'');
		 					$education_details['year_of_passing'] = isset($year_of_passing[$education_details_key]['year_of_passing'])?$year_of_passing[$education_details_key]['year_of_passing']:'';

		 					$type_of_course = json_decode($subValues['type_of_course'],true);
		 					// array_push($education_details,isset($type_of_course[$education_details_key])?$type_of_course[$education_details_key]:'');
		 					$education_details['type_of_course'] = isset($type_of_course[$education_details_key]['type_of_course'])?$type_of_course[$education_details_key]['type_of_course']:'';

		 					$type_of_coutse = json_decode($subValues['type_of_coutse'],true);
		 					// array_push($education_details,isset($type_of_coutse[$education_details_key])?$type_of_coutse[$education_details_key]:'');
		 					$education_details['type_of_coutse'] = isset($type_of_coutse[$education_details_key]['type_of_coutse'])?$type_of_coutse[$education_details_key]['type_of_coutse']:'';

		 					$all_sem_marksheet = explode(",",$subValues['all_sem_marksheet']);
		 					// array_push($education_details,isset($all_sem_marksheet[$education_details_key])?$all_sem_marksheet[$education_details_key]:'');
		 					$education_details['all_sem_marksheet'] = isset($all_sem_marksheet[$education_details_key])?$all_sem_marksheet[$education_details_key]:'';

		 					$convocation = explode(",",$subValues['convocation']); 
		 					$education_details['convocation'] = isset($convocation[$education_details_key])?$convocation[$education_details_key]:'';

		 					$marksheet_provisional_certificate = explode(",",$subValues['marksheet_provisional_certificate']); 
		 					$education_details['marksheet_provisional_certificate'] = isset($marksheet_provisional_certificate[$education_details_key])?$marksheet_provisional_certificate[$education_details_key]:'';

		 					$ten_twelve_mark_card_certificate = explode(",",$subValues['ten_twelve_mark_card_certificate']);
		 					 
		 					$education_details['ten_twelve_mark_card_certificate'] = isset($ten_twelve_mark_card_certificate[$education_details_key])?$ten_twelve_mark_card_certificate[$education_details_key]:'';

		 					 

		 					$status = explode(",",$subValues['status']); 
		 					$education_details['status'] = isset($status[$education_details_key])?$status[$education_details_key]:'';
		 					// array_push($drugtest,isset($status[$education_details_key])?$status[$education_details_key]:'');

		 					
		 					$education_details['analyst_status'] = isset($analyst_status[$education_details_key])?$analyst_status[$education_details_key]:'';
		 					// array_push($drugtest,isset($analyst_status[$education_details_key])?$analyst_status[$education_details_key]:'');

		 					$insuff_status = explode(",",$subValues['insuff_status']);
		 					$education_details['insuff_status'] = isset($insuff_status[$education_details_key])?$insuff_status[$education_details_key]:'';
		 					// array_push($drugtest,isset($specialist_status[$education_details_key])?$specialist_status[$education_details_key]:'');

		 					$output_status = json_decode($subValues['output_status'],true);
		 					$education_details['output_status'] = isset($subValues['output_status'])?$subValues['output_status']:'';
		 					// array_push($drugtest,isset($output_status[$education_details_key])?$output_status[$education_details_key]:'');

		 					$remarks_updateed_by_id = json_decode($subValues['remarks_updateed_by_id'],true);
		 					$education_details['remarks_updateed_by_id'] = isset($remarks_updateed_by_id[$education_details_key]['remarks_updateed_by_id'])?$remarks_updateed_by_id[$education_details_key]['remarks_updateed_by_id']:'';
		 					// array_push($drugtest,isset($remarks_updateed_by_id[$education_details_key])?$remarks_updateed_by_id[$education_details_key]:'');

		 					$assigned_role = explode(",",$subValues['assigned_role']);
		 					$education_details['assigned_role'] = isset($assigned_role[$education_details_key])?$assigned_role[$education_details_key]:'';
		 					// array_push($drugtest,isset($assigned_role[$education_details_key])?$assigned_role[$education_details_key]:'');

		 					$assigned_team_id =explode(",",$subValues['assigned_team_id']);
		 					$education_details['assigned_team_id'] = isset($assigned_team_id[$education_details_key])?$assigned_team_id[$education_details_key]:'';

		 					$remarks_updateed_by_role = json_decode($subValues['remarks_updateed_by_role'],true);
		 					// array_push($education_details,isset($remarks_updateed_by_role[$education_details_key])?$remarks_updateed_by_role[$education_details_key]:'');
		 					$education_details['remarks_updateed_by_role'] = isset($remarks_updateed_by_role[$education_details_key]['remarks_updateed_by_role'])?$remarks_updateed_by_role[$education_details_key]['remarks_updateed_by_role']:'';

		 					$remarks_updateed_by_id = json_decode($subValues['remarks_updateed_by_id'],true);
		 					// array_push($education_details,isset($remarks_updateed_by_id[$education_details_key])?$remarks_updateed_by_id[$education_details_key]:'');
		 					$education_details['remarks_updateed_by_id'] = isset($remarks_updateed_by_id[$education_details_key]['remarks_updateed_by_id'])?$remarks_updateed_by_id[$education_details_key]['remarks_updateed_by_id']:'';

		 					$assigned_role = json_decode($subValues['assigned_role'],true);
		 					// array_push($education_details,isset($assigned_role[$education_details_key])?$assigned_role[$education_details_key]:'');
		 					$assigned_role = explode(",",$subValues['assigned_role']);
		 					$education_details['assigned_role'] = isset($assigned_role[$education_details_key])?$assigned_role[$education_details_key]:'';
		 					// array_push($drugtest,isset($assigned_role[$education_details_key])?$assigned_role[$education_details_key]:'');

		 					// array_push($education_details, $subValues['created_date']);
		 					$education_details['created_date'] = $subValues['created_date'];
		 					// array_push($education_details, $subValues['updated_date']);
		 					$education_details['updated_date'] = $subValues['updated_date'];

		 					$education_details['index'] = $education_details_key;
		 					array_push($final_data, $education_details);
 						// }
 					}
 				}
 				// $final_data[$mainKey] = $education_details;
 				
 			}
 			// 8

 			if($mainKey == 'present_address'){
 				foreach ($value as $present_address_key => $present_address_value) { 
 					$pa_assigned_team_id =explode(",",$present_address_value['assigned_team_id']);
 					// if($pa_assigned_team_id == $team_id && ($present_address_value['analyst_status'] != '3' && $present_address_value['analyst_status'] != '10')){
	 					$present_address_value['component_name'] = $mainKey;
	 					$present_address_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
	 					$present_address_value['candidate_detail'] = $this->analystModel->getCandidateInfo($present_address_value['candidate_id']);
	 					$present_address_value['index'] = $present_address_key;
	 					array_push($final_data, $present_address_value);
 					// }
 				}
 			}

 			// 9
 			if($mainKey == 'permanent_address'){
 				foreach ($value as $permanent_address_key => $permanent_address_value) {
 					$pea_assigned_team_id =explode(",",$permanent_address_value['assigned_team_id']);
 					// if($pea_assigned_team_id == $team_id && ($permanent_address_value['analyst_status'] != '3' && $permanent_address_value['analyst_status'] != '10')){
	 					$permanent_address_value['component_name'] = $mainKey;
	 					$permanent_address_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
	 					$permanent_address_value['candidate_detail'] = $this->analystModel->getCandidateInfo($permanent_address_value['candidate_id']); 
	 					$permanent_address_value['index'] = $permanent_address_key;
	 					array_push($final_data, $permanent_address_value);
 					// }
 				}
 			}
 			// 10
 			if($mainKey == 'previous_employment'){

 				foreach ($value as $previous_employment_key => $previous_employment_value) {
 					$pe_assigned_team_id = explode(",",$previous_employment_value['assigned_team_id']);
 					// print_r($pe_assigned_team_id);
 					// echo "<br>";
 					foreach ($pe_assigned_team_id as $pe_assigned_team_id_key => $pe_assigned_team_id_value) {
 						$analyst_status = explode(",",$previous_employment_value['analyst_status']);

 						// if($pe_assigned_team_id_value == $team_id && ($analyst_status[$pe_assigned_team_id_key] != '3' && $analyst_status[$pe_assigned_team_id_key] != '10')){
 							
 							$previous_employment['component_name'] = $mainKey;
 							$previous_employment['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_employment['previous_emp_id'] = $previous_employment_value['previous_emp_id'];
 							$previous_employment['candidate_id'] = $previous_employment_value['candidate_id']; 
 							$previous_employment['candidate_detail'] = $this->analystModel->getCandidateInfo($previous_employment_value['candidate_id']);
 							$previous_employment['index'] = $pe_assigned_team_id_key;

 							

 							$status = explode(",",$previous_employment_value['status']);
 							$previous_employment['status'] = isset($status[$pe_assigned_team_id_key])?$status[$pe_assigned_team_id_key]:"";

 							
 							$previous_employment['analyst_status'] = isset($analyst_status[$pe_assigned_team_id_key])?$analyst_status[$pe_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$previous_employment_value['insuff_status']);
		 					$previous_employment['insuff_status'] = isset($insuff_status[$pe_assigned_team_id_key])?$insuff_status[$pe_assigned_team_id_key]:'';

 							$previous_employment['updated_date'] = $previous_employment_value['updated_date'];
 							array_push($final_data, $previous_employment);
 						// }
 					}
 				} 
 			}
 			

 			// 11
 			if($mainKey == 'reference'){
 				
 				foreach ($value as $reference_key => $reference_value) {
 					$reference_assigned_team_id = explode(",",$reference_value['assigned_team_id']);
 					 
 					foreach ($reference_assigned_team_id as $reference_assigned_team_id_key => $reference_assigned_team_id_value) {
 						$analyst_status = explode(",",$reference_value['analyst_status']);

 						// if($reference_assigned_team_id_value == $team_id && ($analyst_status[$reference_assigned_team_id_key] != '3' && $analyst_status[$reference_assigned_team_id_key] != '10')){
 							
 							$reference['component_name'] = $mainKey;
 							$reference['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$reference['reference_id'] = $reference_value['reference_id'];
 							$reference['candidate_id'] = $reference_value['candidate_id']; 
 							$reference['candidate_detail'] = $this->analystModel->getCandidateInfo($reference_value['candidate_id']);
 							$reference['index'] = $reference_assigned_team_id_key;

 							 

 							$status = explode(",",$reference_value['status']);
 							$reference['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";

 							
 							$reference['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$reference_value['insuff_status']);
		 					$reference['insuff_status'] = isset($insuff_status[$reference_assigned_team_id_key])?$insuff_status[$reference_assigned_team_id_key]:'';

 							$reference['updated_date'] = $reference_value['updated_date'];
 							array_push($final_data, $reference);
 						// }
 					}
 				} 

 			}

 			// 12
 			if($mainKey == 'previous_address'){

 			 	foreach ($value as $pa_key => $pa_value) {
 					$pa_assigned_team_id = explode(",",$pa_value['assigned_team_id']);
 					 
 					foreach ($pa_assigned_team_id as $pa_assigned_team_id_key => $pa_assigned_team_id_value) {
 						$analyst_status = explode(",",$pa_value['analyst_status']);

 						// if($pa_assigned_team_id_value == $team_id && ($analyst_status[$pa_assigned_team_id_key] != '3' || $analyst_status[$pa_assigned_team_id_key] != '10')){
 							
 							$previous_address['component_name'] = $mainKey;
 							$previous_address['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_address['previos_address_id'] = $pa_value['previos_address_id'];
 							$previous_address['candidate_id'] = $pa_value['candidate_id']; 
 							$previous_address['candidate_detail'] = $this->analystModel->getCandidateInfo($pa_value['candidate_id']);
 							$previous_address['index'] = $pa_assigned_team_id_key; 

 							$status = explode(",",$pa_value['status']);
 							$previous_address['status'] = isset($status[$pa_assigned_team_id_key])?$status[$pa_assigned_team_id_key]:"";

 							
 							$previous_address['analyst_status'] = isset($analyst_status[$pa_assigned_team_id_key])?$analyst_status[$pa_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$pa_value['insuff_status']);
		 					$previous_address['insuff_status'] = isset($insuff_status[$pa_assigned_team_id_key])?$insuff_status[$pa_assigned_team_id_key]:'';


 							$previous_address['updated_date'] = $pa_value['updated_date'];

 							array_push($final_data, $previous_address);
 						// }
 					}
 				} 
 			}

 			

 			$k++;
		}        

		// echo "<br>";
 		// print_r($final_data);
	 	// 	// echo "<br>";
	 	// echo "<br>";
	 	// echo "<br>";
 		// print_r($row);

 		$keys = array_column($final_data, 'updated_date'); 
    	array_multisort($keys, SORT_DESC, $final_data); 
 		return $final_data;
 	}

	function completedCaseList(){
		$outputqc_info = $this->session->userdata('logged-in-outputqc'); 
		
		$candidateData =  $this->db->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('assigned_outputqc_id !=','0')->get()->result_array();
		// $finalCandidateData = array();
		// foreach ($candidateData as $key => $value) {
		// 	$com_id = explode(',',$value['component_ids']);
		// 	foreach ($com_id as $com_key => $com_value) {
		// 		$table_name = $this->utilModel->getComponent_or_PageName($com_value);
		// 		$componentData = $this->db->where('candidate_id',$value['candidate_id'])->get($table_name)->row_array();
		// 		if($componentData != null){ 
		// 			$analyst_status = explode(',', $componentData['analyst_status']);
		// 			$positive_status = array('4','5','6','7','9');
		// 			$result=array_intersect($analyst_status,$positive_status);
		// 			if(count($result) == count($analyst_status)){
		// 				array_push($finalCandidateData, $value);
		// 				break;
		// 			}
		// 		}
		// 	}
		// } 		
		return $candidateData;
	}



	/// multiple component ids

	function getmultiAssignedCaseDetails($candidate_id,$component_array='') {
		
 		$result_array = $this->db->where_in('candidate_id',$candidate_id)->select("candidate.*,tbl_client.client_name,packages.package_name,tbl_client.account_manager_name,tbl_client.iverify_or_pv_status")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->result_array();
 		 $case_data  = array();
 		foreach ($result_array as $key => $result) {
 		 
 		 if ($component_array !='') {
        $component_id = $component_array;
        }else{ 
 			$component_id = explode(',', $result['component_ids']);
        }
 		$component = $this->db->where_in('component_id',$component_id)->get('components')->result_array();
 		$team = $this->db->where('team_id',$result['account_manager_name'])->get('team_employee')->row_array();
 		$spoc = $this->db->where('spoc_id',$result['client_spoc_id'])->get('tbl_clientspocdetails')->row_array();
 		// $componentIds = ['16','17','18','20'];
 		$form_values = json_decode($result['form_values'],true);
        $form_values = json_decode($form_values,true);
 		foreach ($component as $key => $value) {
 			// if(in_array($value['component_id'],$componentIds) != -1){
 				// echo 'key : '.$key.'<br>';


 				$componetStatus = $this->getStatusFromComponent($result['candidate_id'],$value['component_id']);
	 			$inputQcStatus = isset($componetStatus['status'])?$componetStatus['status']:'0';
	 			$inputQcStatus = explode(',',$inputQcStatus);
	 			//education 
	 			$university_board = json_decode(isset($componetStatus['university_board'])?$componetStatus['university_board']:'-',true);
	 			$college_school = json_decode(isset($componetStatus['college_school'])?$componetStatus['college_school']:'-',true);
	 			$type_of_degree = json_decode(isset($componetStatus['type_of_degree'])?$componetStatus['type_of_degree']:'-',true);
	 			$course_start_date = json_decode(isset($componetStatus['course_start_date'])?$componetStatus['course_start_date']:'-',true);
	 			$verifier_fee = json_decode(isset($componetStatus['verification_fee'])?$componetStatus['verification_fee']:'-',true);
	 			$verification_remarks = json_decode(isset($componetStatus['verification_remarks'])?$componetStatus['verification_remarks']:'-',true);
	 			$verifier_designation = json_decode(isset($componetStatus['remark_verifier_designation'])?$componetStatus['remark_verifier_designation']:'-',true);

	 			$insuff_close_date = explode(',',isset($componetStatus['insuff_close_date'])?$componetStatus['insuff_close_date']:'-');
	 			$insuff_created_date = explode(',',isset($componetStatus['insuff_created_date'])?$componetStatus['insuff_created_date']:'-');
	 			$hr_contact_number = json_decode(isset($componetStatus['hr_contact_number'])?$componetStatus['hr_contact_number']:'-',true);
	 			$hr_name = json_decode(isset($componetStatus['remark_hr_name'])?$componetStatus['remark_hr_name']:'-',true);
	 			$hr_email = json_decode(isset($componetStatus['remark_hr_email'])?$componetStatus['remark_hr_email']:'-',true);
	 			$company_name = json_decode(isset($componetStatus['company_name'])?$componetStatus['company_name']:'-',true);
	 			
	 			$in_p = isset($componetStatus['in_progress_remarks'])?$componetStatus['in_progress_remarks']:'-';
	 			$progress_remarks = json_decode(isset($componetStatus['progress_remarks'])?$componetStatus['progress_remarks']:$in_p,true); 
	 			$assigned_to_vendor = json_decode(isset($componetStatus['assigned_to_vendor'])?$componetStatus['assigned_to_vendor']:'-',true); 
	 			$remark_verifier_email = json_decode(isset($componetStatus['remark_verifier_email'])?$componetStatus['remark_verifier_email']:'-',true); 
	 			$outputqc_comment = json_decode(isset($componetStatus['outputqc_comment'])?$componetStatus['outputqc_comment']:'-',true); 

	 			$inss = isset($componetStatus['Insuff_remarks'])?$componetStatus['Insuff_remarks']:'-';
				$insuff_remarks = json_decode(isset($componetStatus['insuff_remarks'])?$componetStatus['insuff_remarks']:$inss,true);
	 			// $assigned_to_vendor = json_decode(isset($assigned_to_vendor)?$assigned_to_vendor:'-',true); 
	 			// $assigned_to_vendor = json_decode(isset($assigned_to_vendor1['assigned_to_vendor'])?$assigned_to_vendor1['assigned_to_vendor']:'-',true); 
	 			$vendor ='-';
	 			if ($value['component_name'] !='Previous Address') {
	 				$vendor =  isset($componetStatus['assigned_to_vendor'])?$componetStatus['assigned_to_vendor']:'-';
	 			}

	 			$progress = '-';
	 			$fee = '-';
	 			$insuff_rem = '-';
	 		$insuff_closure='-';
	 		$verification = '-'; 
	 			$valid_comp = array('1','2','3','4','7','10','11','12','17','18','19','21','23','24','16');
	 			$hr_n = '-';
	 			$contact_number = '';
	 			$remark_hr_email= '';
	 			$outputqc_comments = '';
	 			if (!in_array($value['component_id'],$valid_comp)) {
	 				$insuff_rem = isset($componetStatus['insuff_remarks'])?$componetStatus['insuff_remarks']:$inss;
	 				$insuff_closure = isset($componetStatus['Insuff_closure_remarks'])?$componetStatus['Insuff_closure_remarks']:'-';
	 				$verification = isset($componetStatus['verification_remarks'])?$componetStatus['verification_remarks']:'-';
	 				$hr_n = isset($componetStatus['remark_hr_name'])?$componetStatus['remark_hr_name']:'-';
	 				$contact_number = isset($componetStatus['hr_contact_number'])?$componetStatus['hr_contact_number']:'-';
	 				$remark_hr_email= isset($componetStatus['remark_hr_email'])?$componetStatus['remark_hr_email']:'-';
	 				$outputqc_comments = isset($componetStatus['outputqc_comment'])?$componetStatus['outputqc_comment']:'-';

	 				$in_p = isset($componetStatus['in_progress_remarks'])?$componetStatus['in_progress_remarks']:'-';
	 			$progress = isset($componetStatus['progress_remarks'])?$componetStatus['progress_remarks']:$in_p; 

	 			$fee = isset($componetStatus['verification_fee'])?$componetStatus['verification_fee']:'-'; 
	 			if (in_array($value['component_id'],['8','9'])) {
	 					$insuff_closure = isset($componetStatus['closure_remarks'])?$componetStatus['closure_remarks']:'-';
	 				}
	 			}else{
	 				$insuff_remarks = json_decode(isset($componetStatus['insuff_remarks'])?$componetStatus['insuff_remarks']:$inss,true);
	 			$verification_remarks = json_decode(isset($componetStatus['verification_remarks'])?$componetStatus['verification_remarks']:'-',true);
	 			$insuff_closure_remarks = json_decode(isset($componetStatus['Insuff_closure_remarks'])?$componetStatus['Insuff_closure_remarks']:'-',true); 
	 			}
	 			// echo json_encode($inputQcStatus);
	 			// array_push( $case_data, $componetStatus); 
	 			// exit();progress_remarks 
	 			/*SELECT `document_check_id`, `candidate_id`, `passport_doc`, `pan_card_doc`, `adhar_doc`, `passport_number`, `pan_number`, `aadhar_number`, `state`, `approved_doc`, `remark_address`, `remark_city`, `remark_state`, `remark_pin_code`, `in_progress_remarks`, `verification_remarks`, `insuff_remarks`, `insuff_closure_remarks`, `ouputqc_comment`, `status`, `analyst_status`, `analyst_status_date`, `insuff_created_date`, `insuff_close_date`, `insuff_status`, `insuff_team_role`, `insuff_team_id`, `output_status`, `remarks_updateed_by_role`, `remarks_updateed_by_id`, `assigned_role`, `assigned_team_id`, `created_date`, `updated_date` FROM `document_check` WHERE 1*/

	 			if ($value['component_id'] =='6') {
	 				$insuff_rem = isset($componetStatus['Insuff_remarks'])?$componetStatus['Insuff_remarks']:'-';
	 				$insuff_closure = isset($componetStatus['Insuff_closure_remarks'])?$componetStatus['Insuff_closure_remarks']:'-';
	 			}

	 			if ($value['component_id'] == '10') {
	 				$insuff_remarks = json_decode(isset($componetStatus['Insuff_remarks'])?$componetStatus['Insuff_remarks']:'-',true);
	 			$insuff_closure_remarks = json_decode(isset($componetStatus['Insuff_closure_remarks'])?$componetStatus['Insuff_closure_remarks']:'-',true); 
	 			}

	 			if ($value['component_id'] == '12') {
	 					$insuff_closure_remarks = json_decode(isset($componetStatus['closure_remarks'])?$componetStatus['closure_remarks']:'-',true); 
	 				}

	 			$remarks_address = json_decode(isset($componetStatus['remarks_address'])?$componetStatus['remarks_address']:'-',true); 
	 			$remark_city = json_decode(isset($componetStatus['remark_city'])?$componetStatus['remark_city']:'-',true); 
	 			$remark_state = json_decode(isset($componetStatus['remark_state'])?$componetStatus['remark_state']:'-',true); 
	 			$remark_pin_code = json_decode(isset($componetStatus['remark_pin_code'])?$componetStatus['remark_pin_code']:'-',true); 

	 			$address = json_decode(isset($componetStatus['address'])?$componetStatus['address']:'-',true); 
	 			$city = json_decode(isset($componetStatus['city'])?$componetStatus['city']:'-',true); 
	 			$state = json_decode(isset($componetStatus['state'])?$componetStatus['state']:'-',true); 
	 			$pincode = json_decode(isset($componetStatus['pin_code'])?$componetStatus['pin_code']:'-',true);  

	 			 $cpmpaney = isset($componetStatus['company_name'])?$componetStatus['company_name']:'-';
	 			 $case_submitted_date = isset($componetStatus['case_submitted_date'])?$componetStatus['case_submitted_date']:'-';


	 			 $results = '';
		 		if ($value['component_id'] =='7') {
		 			$education = isset($form_values['education']) ? $form_values['education'] : [100];
		 			$check_highest_education = isset($form_values['highest_education']) ? $form_values['highest_education'] : $education;
		 			if ( $check_highest_education == '' ) {
		 				$check_highest_education =100;
		 			}

		 			if (empty($check_highest_education)) {
		 				$check_highest_education =100;
		 			}

		 			$results = $this->db->where_in('education_type_id', $check_highest_education )->get('education_type')->result_array();
		 		}else if($value['component_id'] =='3'){
		 			$document_type_id = isset($form_values['document_check']) ? $form_values['document_check'] : 100;
		 			if (empty($document_type_id)) {
		 				$document_type_id = 100;
		 			}
		 			$results = $this->db->where_in('document_type_id',$document_type_id)->get('document_type')->result_array();
		 		}else if ($value['component_id'] =='4') {
		 			$drug_test_type_id = isset($form_values['drug_test']) ? $form_values['drug_test'] : 1;
		 			$results = $this->db->where_in('drug_test_type_id',$drug_test_type_id)->get('drug_test_type')->result_array();
		 		}
		 		
	 			foreach ($inputQcStatus as $inputQcStatuskey => $componentValue) {
	 				// $row['inputQcStatus'] = $inputQcStatus;
	 				$row['tables'] = $componetStatus; 

	 				$iv_pv = '-';
				if ($result['iverify_or_pv_status'] =='1') {
					$iv_pv = 'IV';
				}else if ($result['iverify_or_pv_status'] =='2') {
					$iv_pv = 'PV';
				}
				
		 			$row['iv_pv'] = $iv_pv;

	 				$hr =  isset($hr_name[$inputQcStatuskey]['remark_hr_name'])?$hr_name[$inputQcStatuskey]['remark_hr_name']:$hr_n; 
		 			$row['hr_contact_number'] = isset($hr_contact_number[$inputQcStatuskey]['hr_contact_number'])?$hr_contact_number[$inputQcStatuskey]['hr_contact_number']:$contact_number; 
		 			$row['hr_email'] = isset($hr_email[$inputQcStatuskey]['remark_hr_email'])?$hr_email[$inputQcStatuskey]['remark_hr_email']:$remark_hr_email; 
		 			$row['hr_name'] = $hr;
	 				
	 				//doc 
	 				$row['verifier_fee'] = isset($verifier_fee[$inputQcStatuskey]['verifier_fee'])?$verifier_fee[$inputQcStatuskey]['verifier_fee']:$fee;
	 				$row['vendor'] = isset($assigned_to_vendor[$inputQcStatuskey]['assigned_to_vendor'])?$assigned_to_vendor[$inputQcStatuskey]['assigned_to_vendor']:$vendor;
	 				$row['remark_city'] = isset($remark_city[$inputQcStatuskey]['remark_city'])?$remark_city[$inputQcStatuskey]['remark_city']:'-';
	 				$row['remarks_address'] = isset($remarks_address[$inputQcStatuskey]['remarks_address'])?$remarks_address[$inputQcStatuskey]['remarks_address']:'-';
	 				$row['remark_state'] = isset($remark_state[$inputQcStatuskey]['remark_state'])?$remark_state[$inputQcStatuskey]['remark_state']:'-';
	 				$row['remark_pin_code'] = isset($remark_pin_code[$inputQcStatuskey]['remark_pin_code'])?$remark_pin_code[$inputQcStatuskey]['remark_pin_code']:'-';

	 				$row['address'] = isset($address[$inputQcStatuskey]['address'])?$address[$inputQcStatuskey]['address']:'-';
	 				$row['city'] = isset($city[$inputQcStatuskey]['city'])?$city[$inputQcStatuskey]['city']:'-';
	 				$row['state'] = isset($state[$inputQcStatuskey]['state'])?$state[$inputQcStatuskey]['state']:'-';
	 				$row['pincode'] = isset($pincode[$inputQcStatuskey]['pincode'])?$pincode[$inputQcStatuskey]['pincode']:'-';
	 				$row['outputqc_comment'] = isset($outputqc_comment[$inputQcStatuskey]['ouputQcComment'])?$outputqc_comment[$inputQcStatuskey]['ouputQcComment']:$outputqc_comments;
// 
	 				//
	 				$row['passport_number'] = isset($componetStatus['passport_number'])?$componetStatus['passport_number']:'-';
	 				$row['pan_number'] = isset($componetStatus['pan_number'])?$componetStatus['pan_number']:'-';
	 				$row['aadhar_number'] = isset($componetStatus['aadhar_number'])?$componetStatus['aadhar_number']:'-';
	 				$last = isset($team['last_name'])?$team['last_name']:'-';
	 				$row['csm'] = isset($team['first_name'])?$team['first_name']:'-'.' '.$last;
	 				$formNumber =  $inputQcStatuskey+1;
	 				$row['formNumber'] = $formNumber;
	 				$row['index'] = $inputQcStatuskey;
	 				$row['position'] = $inputQcStatuskey;
		 			$row['component_id'] = $value['component_id'];
		 			$row['gender'] = $result['gender'];
		 			$row['candidate_name'] = $result['first_name'].' '.$result['last_name']; 
		 			$row['spoc_name'] = isset($spoc['spoc_name'])?$spoc['spoc_name']:'-';
		 			$row['component_id'] = $value['component_id'];
		 			$row['component_name'] = $value['component_name']; 
		 			$row['client_id'] = $result['client_id']; 
		 			$row['segment'] = isset($result['segment'])?$result['segment']:'-'; 
		 			$row['location'] = isset($result['location'])?$result['location']:'-'; 
		 			$row['loginId'] = $result['loginId']; 
		 			$row['otp'] = $result['otp_password']; 
		 			$row['client_name'] = $result['client_name']; 
		 			$row['candidate_id'] = $result['candidate_id']; 
		 			$row['title'] = $result['title']; 
		 			$row['first_name'] = $result['first_name']; 
		 			$row['last_name'] = $result['last_name']; 
		 			$row['father_name'] = $result['father_name']; 
		 			$row['country_code'] = isset($result['country_code'])?$result['country_code']:'+91';
		 			$row['phone_number'] = $result['phone_number'];
		 			$row['case_submitted_date'] = $result['case_submitted_date']; 
		 			$row['report_generated_date'] = $result['report_generated_date']; 
		 			$row['is_report_generated'] = $result['is_report_generated']; 
		 			$row['email_id'] = $result['email_id']; 
		 			$row['date_of_birth'] = $result['date_of_birth']; 
		 			$row['date_of_joining'] = $result['date_of_joining']; 
		 			$row['employee_id'] = $result['employee_id']; 
		 			$row['package_name'] = $result['package_name']; 
		 			$row['remark'] = $result['remark']; 
		 			$row['priority'] = $result['priority']; 
		 			$row['document_uploaded_by'] = $result['document_uploaded_by']; 
		 			$row['document_uploaded_by_email_id'] = $result['document_uploaded_by_email_id']; 
		 			$row['created_date'] = date('d-m-Y', strtotime(isset($componetStatus['created_date'])?$componetStatus['created_date']:'') );  
		 			$row['updated_date'] = date('d-m-Y', strtotime($result['updated_date']) );  
		 			$row['is_submitted'] = $result['is_submitted'];
		 			$row['form_values'] = $result['form_values'];
		 			// company hr_name hr_contact_number

		 			$type_of_val ='';
		 			if ($results !='' && $value['component_id'] =='7') {
		 				$type_of_val = isset($results[$inputQcStatuskey]['education_type_name'])?$results[$inputQcStatuskey]['education_type_name']:'';
		 			}else if ($results !='' && $value['component_id'] =='3') {
		 				$type_of_val = isset($results[$inputQcStatuskey]['document_type_name'])?$results[$inputQcStatuskey]['document_type_name']:'';
		 			}else if ($results !='' && $value['component_id'] =='4') {
		 				$type_of_val = isset($results[$inputQcStatuskey]['drug_test_type_name'])?$results[$inputQcStatuskey]['drug_test_type_name']:'';
		 			}
		 			$row['value_type'] = $type_of_val;
		 			

		 			$inputq = $this->getTeamEmpData($result['assigned_inputqc_id']); 
		 			$row['inputq'] = isset($inputq['name'])?$inputq['name']:'-'; 
		 			$qc_name = $this->getTeamEmpData($result['assigned_outputqc_id']); 
		 			$row['qc_name'] = isset($qc_name['name'])?$qc_name['name']:'-'; 
		 			
		 			$row['panel'] = isset($form_values['drug_test'][$inputQcStatuskey])?$form_values['drug_test'][$inputQcStatuskey]:'-';
		 			$row['insuff_created_date'] = isset($insuff_created_date[$inputQcStatuskey])?$insuff_created_date[$inputQcStatuskey]:'-';
		 			$row['insuff_close_date'] = isset($insuff_close_date[$inputQcStatuskey])?$insuff_close_date[$inputQcStatuskey]:'-';
		 			$row['company_name'] = isset($company_name[$inputQcStatuskey]['company_name'])?$company_name[$inputQcStatuskey]['company_name']:$cpmpaney;
		 			$inputQcComStatus = $this->stringExplode(isset($componetStatus['status'])?$componetStatus['status']:'');
		 			$row['status'] = isset($inputQcComStatus[$inputQcStatuskey])?$inputQcComStatus[$inputQcStatuskey]:'0';
		 			$inputQcComDate = $this->stringExplode(isset($componetStatus['inputqc_status_date'])?$componetStatus['inputqc_status_date']:'');
		 			$row['inputqc_status_date'] = isset($inputQcComDate[$inputQcStatuskey])?$inputQcComDate[$inputQcStatuskey]:'NA';
		 			$analyst_specialist_com_date = $this->stringExplode(isset($componetStatus['analyst_status_date'])?$componetStatus['analyst_status_date']:'');
		 			$row['analyst_status_date'] = isset($analyst_specialist_com_date[$inputQcStatuskey])?$analyst_specialist_com_date[$inputQcStatuskey]:'NA';
		 			$outputqc_com_date = $this->stringExplode(isset($componetStatus['outputqc_status_date'])?$componetStatus['outputqc_status_date']:'');
		 			$row['outputqc_status_date'] = isset($outputqc_com_date[$inputQcStatuskey])?$outputqc_com_date[$inputQcStatuskey]:'NA';
		 			$analystStatus = $this->stringExplode(isset($componetStatus['analyst_status'])?$componetStatus['analyst_status']:'0');
		 			$row['analyst_status'] = isset($analystStatus[$inputQcStatuskey])?$analystStatus[$inputQcStatuskey]:'0';
		 			$outputQCStatus =  $this->stringExplode(isset($componetStatus['output_status'])?$componetStatus['output_status']:'0'); 
		 			$row['output_status'] = isset($outputQCStatus[$inputQcStatuskey])?$outputQCStatus[$inputQcStatuskey]:'0';

		 			$insuff_team_role = $this->stringExplode(isset($componetStatus['insuff_team_role'])?$componetStatus['insuff_team_role']:'Role');
		 			$row['insuff_team_role'] = isset($insuff_team_role[$inputQcStatuskey])?$insuff_team_role[$inputQcStatuskey]:'0';

		 			$insuff_team_id = $this->stringExplode(isset($componetStatus['insuff_team_id'])?$componetStatus['insuff_team_id']:'0');
		 			$row['insuff_team_id'] = isset($insuff_team_id[$inputQcStatuskey])?$insuff_team_id[$inputQcStatuskey]:'0';
		 			$insuff_team = $this->getTeamEmpData(isset($insuff_team_id[$inputQcStatuskey])?$insuff_team_id[$inputQcStatuskey]:'0'); 
		 			$row['insuff_team_name'] = isset($insuff_team['name'])?$insuff_team['name']:'-';


		 			$assigned_role = $this->stringExplode(isset($componetStatus['assigned_role'])?$componetStatus['assigned_role']:'Role');
		 			$row['assigned_role'] = isset($assigned_role[$inputQcStatuskey])?$assigned_role[$inputQcStatuskey]:'0';
		 			$assigned_team_id = $this->stringExplode(isset($componetStatus['assigned_team_id'])?$componetStatus['assigned_team_id']:'0');
		 			$row['assigned_team_id'] = isset($assigned_team_id[$inputQcStatuskey])?$assigned_team_id[$inputQcStatuskey]:'0';

		 			$assigned_team = $this->getTeamEmpData(isset($assigned_team_id[$inputQcStatuskey])?$assigned_team_id[$inputQcStatuskey]:'0'); 
		 			$row['assigned_team_name'] = isset($assigned_team['name'])?$assigned_team['name']:'-'; 
		 			$row['insuff_remarks'] = isset($insuff_remarks[$inputQcStatuskey]['insuff_remarks'])?$insuff_remarks[$inputQcStatuskey]['insuff_remarks']:$insuff_rem;
		 			if ($value['component_id'] ='12') {
		 				$row['insuff_closure_remarks'] = isset($insuff_closure_remarks[$inputQcStatuskey]['closure_remarks'])?$insuff_closure_remarks[$inputQcStatuskey]['closure_remarks']:$insuff_closure;
		 			}else{
		 				$row['insuff_closure_remarks'] = isset($insuff_closure_remarks[$inputQcStatuskey]['insuff_closure_remarks'])?$insuff_closure_remarks[$inputQcStatuskey]['insuff_closure_remarks']:$insuff_closure;
		 			}
		 			$row['verification_remarks'] = isset($verification_remarks[$inputQcStatuskey]['verification_remarks'])?$verification_remarks[$inputQcStatuskey]['verification_remarks']:$verification;
		 			$in_pro = isset($progress_remarks[$inputQcStatuskey]['in_progress_remarks'])?$progress_remarks[$inputQcStatuskey]['in_progress_remarks']:$progress;
	
	 			$row['progress_remarks'] = isset($progress_remarks[$inputQcStatuskey]['progress_remarks'])?$progress_remarks[$inputQcStatuskey]['progress_remarks']:$in_pro;

		 			//edu
		 			$row['university_board'] = isset($university_board[$inputQcStatuskey]['university_board'])?$university_board[$inputQcStatuskey]['university_board']:'-';
		 			$row['college_school'] = isset($college_school[$inputQcStatuskey]['college_school'])?$college_school[$inputQcStatuskey]['college_school']:'-';
		 			$row['type_of_degree'] = isset($type_of_degree[$inputQcStatuskey]['type_of_degree'])?$type_of_degree[$inputQcStatuskey]['type_of_degree']:'';
		 			$row['course_start_date'] = isset($course_start_date[$inputQcStatuskey]['course_start_date'])?$course_start_date[$inputQcStatuskey]['course_start_date']:'-';
		 			$row['verifier_email'] = isset($remark_verifier_email[$inputQcStatuskey]['verifier_email'])?$remark_verifier_email[$inputQcStatuskey]['verifier_email']:'-';
		 			// $row['verification_remarks'] = isset($verification_remarks[$inputQcStatuskey]['verification_remarks'])?$verification_remarks[$inputQcStatuskey]['verification_remarks']:'-'; 
		 			$row['verifier_designation'] = isset($verifier_designation[$inputQcStatuskey]['verifier_designation'])?$verifier_designation[$inputQcStatuskey]['verifier_designation']:'-';

		 				// Tat Details
	 			$row['tat_start_date'] = $this->convert_date_order(isset($result['tat_start_date'])?$result['tat_start_date']:'');
	 			$row['tat_pause_date'] = $this->convert_date_order(isset($result['tat_pause_date'])?$result['tat_pause_date']:'');
	 			$row['tat_re_start_date'] = $this->convert_date_order(isset($result['tat_re_start_date'])?$result['tat_re_start_date']:'');
	 			$row['tat_end_date'] = $this->convert_date_order(isset($result['tat_end_date'])?$result['tat_end_date']:'');
	 			$row['report_generated_date'] = $this->convert_date_order(isset($result['report_generated_date'])?$result['report_generated_date']:'');
	 			$row['tat_pause_resume_status'] = isset($result['tat_pause_resume_status'])?$result['tat_pause_resume_status']:'';
	 			if($result['priority'] == '1') {
	 				$row['tat_days'] = isset($result['medium_priority_days'])?$result['medium_priority_days']:''; 	
	 			} else if($result['priority'] == '2') {
	 				$row['tat_days'] = isset($result['high_priority_days'])?$result['high_priority_days']:''; 
	 			} else {
	 				$row['tat_days'] = isset($result['low_priority_days'])?$result['low_priority_days']:''; 
	 			}

		 			
					if ($row['tat_end_date'] !='' && $result['report_generated_date'] !='' && $result['report_generated_date'] !=null) { 
	 			if ($row['tat_end_date'] > $result['report_generated_date']) {
		 				$row['tat_end_date'] = $this->convert_date_order(isset($result['report_generated_date'])?$result['report_generated_date']:'');
		 			}else{
		 				$row['tat_end_date'] = $this->convert_date_order(isset($result['report_generated_date'])?$result['report_generated_date']:'');
		 			}
	 			}

				if($result['tat_start_date'] != null && $result['report_generated_date'] != null && $result['tat_pause_date'] != null && $result['tat_pause_date'] != '' && $result['tat_re_start_date'] != null && $result['tat_re_start_date'] != ''){
					$restart_date = 0;
					$start_date = 0; 
						$start_date = $this->number_of_working_days($result['tat_start_date'],$result['tat_pause_date']);
				 
					$restart_date = $this->number_of_working_days($result['tat_re_start_date'],$result['report_generated_date']);
				 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($result['tat_start_date'] != null && $result['tat_pause_date'] != null && $result['tat_pause_date'] != '' && $result['tat_re_start_date'] != null && $result['tat_re_start_date'] != ''){
					$restart_date = 0;
					$start_date = 0;
					 
							if ($result['report_generated_date'] !='') { 
						$restart_date = $this->number_of_working_days($result['tat_re_start_date'],$result['report_generated_date']);
					 }else{
					 	$restart_date = $this->number_of_working_days($result['tat_re_start_date'],date('d-m-Y'));
					 }
					 
					 
						$start_date = $this->number_of_working_days($result['tat_start_date'],$result['tat_pause_date']);
					 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($result['tat_start_date'] != null && $result['tat_pause_date'] != null && $result['tat_pause_date'] != ''){
					$restart_date = 0;
					$start_date = 0; 
					 
						$start_date = $this->number_of_working_days($result['tat_start_date'],$result['tat_pause_date']);
					 
					$total = $start_date + $restart_date;
					$row['left_tat_days'] = $total.' days';

				}else if($result['tat_start_date'] != null && $result['tat_start_date'] != ''){
						if ($result['report_generated_date'] !='' && $result['report_generated_date'] !=null) { 

						$row['left_tat_days'] = $this->number_of_working_days($result['tat_start_date'],$result['report_generated_date']).' days';
					}else{
						$row['left_tat_days'] = $this->number_of_working_days($result['tat_start_date'],date('d-m-Y')).' days';	
					}
					 
				}else{
					$row['left_tat_days'] = '-';
					$row['tat_overdue'] = '-';
				}			

		 			array_push(	$case_data, $row);  
	 			}
 			// }$
 		 
 			
 		}
 	}
 		// echo json_encode($case_data);
 		return $case_data;
	}


	function tatDateUpdate(){
		$candidate_id = $this->input->post('candidate_id');
		$type = $this->input->post('type');
		$candidate_info = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		$clientTatInfo = $this->db->select('low_priority_days,medium_priority_days,high_priority_days')->from('tbl_client')->where('client_id',$candidate_info['client_id'])->get()->row_array();
 		$tat_date_type = '';
 		$tat_status = '';
 		$tat_type = '';
 		$form_number = '-';
 		
		if($type == 'pause'){
			$tat_date_type = 'tat_pause_date';
			$tat_status = '1';
			$tat_end_date = $candidate_info['tat_end_date'];
			$tat_type= 'Manually pause';
		}elseif($type == 're_start'){
			$tat_days = '0';
			if($candidate_info['priority'] == '1'){
				$tat_days = $clientTatInfo['medium_priority_days'];
			}elseif ($candidate_info['priority'] == '2') {
				$tat_days = $clientTatInfo['high_priority_days'];
			}elseif($candidate_info['priority'] == '0'){
				$tat_days = $clientTatInfo['low_priority_days'];
			}
			$usedTatDays = $this->inputQcModel->number_of_working_days($candidate_info['tat_start_date'],$candidate_info['tat_pause_date']);
	 		$tat_days = $tat_days - $usedTatDays;
	 		// $tat_end_date = $this->inputQcModel->addBusinessDays($date=date('d-m-Y H:i:s'),$tat_days, $holidays=array()); 
			$tat_status = '2';
			$tat_date_type = 'tat_re_start_date';
			// $tat_end_date = $tat_end_date;
			$tat_type = 'Manually re-start';

		} 
		
 		$tat_date_details[$tat_date_type] = date('d-m-Y H:i:s');
 		$tat_date_details['tat_pause_resume_status'] = $tat_status;
 		// $tat_date_details['tat_end_date'] = $tat_end_date;
 		$userInfo = $this->session->userdata('logged-in-admin');
 		$userData['team_id'] = $userInfo['team_id'];
		$userData['role'] = $userInfo['role'];
		$userData['team_employee_email'] = $userInfo['team_employee_email'];
		$userData = json_encode($userData);
		// $userData = implode(',',$userData); 

 		if($this->db->where('candidate_id',$candidate_id)->update('candidate',$tat_date_details)){
 			$candidateData = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
 			$this->db->insert('candidate_log',$candidateData);
 			$tat_log_data['candidate_id'] = $candidate_id;
 			$tat_log_data['tat_start_date'] = $candidateData['tat_start_date'];
 			// $tat_log_data['tat_end_date'] =  $candidateData['tat_end_date'];
 			$tat_log_data['tat_pause_date'] =  $candidateData['tat_pause_date'];
 			$tat_log_data['tat_re_start_date'] =  $candidateData['tat_re_start_date'];
 			$tat_log_data['component_id'] =  '0';
 			$tat_log_data['component_name'] = $tat_type;
 			$tat_log_data['form_number'] = $form_number;
 			$tat_log_data['user_detail'] = $userData;
 			$this->db->insert('tat_date_log',$tat_log_data); 
 			return array('status'=>'1','msg'=>'Success');
 		}else{
 			return array('status'=>'0','msg'=>'failed');
 		}
	} 

	function allCaseTatDateUpdate(){
		$login_password = $this->input->post('login_password');
		$type = $this->input->post('type');
		$userInfo = $this->session->userdata('logged-in-admin');
		$userData['team_id'] = $userInfo['team_id'];
		$userData['role'] = $userInfo['role'];
		$userData['team_employee_email'] = $userInfo['team_employee_email'];
		$userData = json_encode($userData);
		// $userData = implode(',',$userData); 
		if($login_password != null && $login_password != ''){
			$login_password = md5($login_password);
			$is_login_data = $this->db->where('team_employee_password',$login_password)->where('role','admin')->get('team_employee')->num_rows();
			if($is_login_data > 0){

		 		$tat_date_type = '';
		 		$tat_status = '';
		 		$tat_type = '';
		 		$form_number = '-'; 
	 		
				if($type == 'pause'){
					 
					$tat_status = '1'; 
					$tat_type= 'All case Manually pause';
					$tat_date_details['tat_pause_date'] = date('d-m-Y H:i:s');
			 		$tat_date_details['tat_pause_resume_status'] = $tat_status;
		 		 
			 		if($this->db->update('candidate',$tat_date_details)){
			 			$candidateData = $this->db->where('is_submitted','1')->get('candidate')->result_array();

			 			foreach ($candidateData as $key => $value) {
			 				$this->db->insert('candidate_log',$value);
				 			$tat_log_data['candidate_id'] = $value['candidate_id'];
				 			$tat_log_data['tat_start_date'] = isset($value['tat_start_date'])?$value['tat_start_date']:date('d-m-Y H:i:s');
				 			$tat_log_data['tat_end_date'] =  isset($value['tat_end_date'])?$value['tat_end_date']:'-';
				 			$tat_log_data['tat_pause_date'] =  $value['tat_pause_date'];
				 			$tat_log_data['tat_re_start_date'] =  '-';
				 			$tat_log_data['component_id'] =  '0';
				 			$tat_log_data['component_name'] = $tat_type;
				 			$tat_log_data['form_number'] = '0';
				 			$tat_log_data['user_detail'] = $userData;
				 			$this->db->insert('tat_date_log',$tat_log_data);
			 			}
			 			 
			 			return array('status'=>'1','msg'=>'Success');
			 		}else{
			 			return array('status'=>'0','msg'=>'failed');
			 		}
				}elseif($type == 're_start'){
					$candidateData = $this->db->where('is_submitted','1')->get('candidate')->result_array();

					foreach ($candidateData as $key => $value) {
						 			
						$clientTatInfo = $this->db->select('low_priority_days,medium_priority_days,high_priority_days')->from('tbl_client')->where('client_id',$value['client_id'])->get()->row_array();
						$tat_days = '0';
						if($value['priority'] == '1'){
							$tat_days = $clientTatInfo['medium_priority_days'];
						}elseif ($value['priority'] == '2') {
							$tat_days = $clientTatInfo['high_priority_days'];
						}elseif($value['priority'] == '0'){
							$tat_days = $clientTatInfo['low_priority_days'];
						}

						$usedTatDays = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_pause_date']);
				 		$tat_days = $tat_days - $usedTatDays;
				 		$tat_end_date = $this->inputQcModel->addBusinessDays($date=date('d-m-Y H:i:s'),$tat_days, $holidays=array()); 
						$tat_status = '2';
						$tat_date_type = 'tat_re_start_date';
						$tat_end_date = $tat_end_date;
						$tat_type = 'All case Manually re-start';
						$tat_date_details['tat_re_start_date'] = date('d-m-Y H:i:s');
				 		$tat_date_details['tat_pause_resume_status'] = $tat_status;
				 		// $tat_date_details['tat_end_date'] = $tat_end_date;

						if($this->db->update('candidate',$tat_date_details)){
				 			$candidateInfo = $this->db->where('candidate_id',$value['candidate_id'])->get('candidate')->row_array();
				 			$this->db->insert('candidate_log',$candidateInfo);
					 		$tat_log_data['candidate_id'] = $candidateInfo['candidate_id'];
					 		$tat_log_data['tat_start_date'] = isset($candidateInfo['tat_start_date'])?$candidateInfo['tat_start_date']:'-';
					 		// $tat_log_data['tat_end_date'] =  $candidateInfo['tat_end_date'];
					 		$tat_log_data['tat_pause_date'] = isset($candidateInfo['tat_pause_date'])?$candidateInfo['tat_pause_date']:'-';
					 		$tat_log_data['tat_re_start_date'] =  $candidateInfo['tat_re_start_date'];
					 		$tat_log_data['component_id'] =  '0';
					 		$tat_log_data['component_name'] = $tat_type;
					 		$tat_log_data['form_number'] = '0';
					 		$tat_log_data['user_detail'] = $userData;
					 		$this->db->insert('tat_date_log',$tat_log_data);
				 		
				 			 
				 			return array('status'=>'1','msg'=>'Success');
				 		}else{
				 			return array('status'=>'0','msg'=>'failed');
				 		}
			 		}
				}
		 		
			}else{
				return array('status'=>'0','msg'=>'wrong credential');	
			}			
 		}else{
 			return array('status'=>'0','msg'=>'null');
 		}
	} 


	function get_tat_log_data($candidate_id = ''){

		if($candidate_id != null && $candidate_id != ''){
			return $this->db->where('candidate_id',$candidate_id)->order_by("tat_log_id", "desc")->get('tat_date_log')->result_array();
		}else{
			return $this->db->order_by("tat_log_id", "desc")->get('tat_date_log')->result_array();
		}
	}

	function change_case_payment_stauts(){
        $candidate_id = $this->input->post('candidate_id');
        $p_status = $this->input->post('p_status');
        $p_status_date = date('Y-m-d H:i:m');
		$summery_ids = array();
		$summery_ids = $this->input->post('summery_ids');
		$count = $this->input->post('count');
		$payment_date = $this->input->post('payment_date'); 
		$payment_date = date('Y-m-d', strtotime(str_replace('-', '/', $payment_date)));

		// echo 'candidate_id:'.$candidate_id.'|p_status:'.$p_status.'|payment_date:'.$payment_date;
		// exit;
		if($count > 0 && $candidate_id == '' && count($summery_ids) > 0 ){
			$finance_summary = $this->db->where_in('summary_id',$summery_ids)->get('finance_summary')->result_array(); 
			$candidate_ids = array();
			foreach ($finance_summary as $key => $value) { 
				$candidate_id = explode(",",$value['candidate_ids']);
				foreach ($candidate_id as $id_key => $id_value){
					array_push($candidate_ids,$id_value);	
				}
			}
			if(count($candidate_ids) > 0){ 
				 
				$data_set = array('payment_status'=>$p_status,'payment_status_date'=>$p_status_date,'payment_date'=>$payment_date);
				$this->db->where_in('candidate_id',$candidate_ids)->set($data_set);
				if($this->db->update('candidate')){
					// echo $this->db->last_query();
					return json_encode(array('status'=>'1',"message"=>"Payment status changed",'date'=>$p_status_date));
				}else{
					return json_encode(array('status'=>'0',"message"=>"Payment status failed","date"=>""));
				}
			}else{
				return json_encode(array('status'=>'0',"message"=>"Bad Request..!"));
			}
		}else{
			if($candidate_id != '' && $p_status != ''){ 
				$data_set = array('payment_status'=>$p_status,'payment_status_date'=>$p_status_date,'payment_date'=>$payment_date);
				$this->db->where('candidate_id',$candidate_id)->set($data_set);
				if($this->db->update('candidate')){
					return json_encode(array('status'=>'1',"message"=>"Payment status changed",'date'=>$p_status_date));
				}else{
					return json_encode(array('status'=>'0',"message"=>"Payment status failed","date"=>""));
				}
			}else{
				return json_encode(array('status'=>'0',"message"=>"Bad Request..!"));
			}
		}               
    }
}	
?>