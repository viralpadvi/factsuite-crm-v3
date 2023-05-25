<?php
/**
 * 
 */
class CaseModel extends CI_Model
{
	

	function new_clear_candidate_notification($candidate_array){
		$where = array(
				'candidate_id'=>$candidate_array['candidate_id'],
				'client_spoc_id'=>$candidate_array['client_spoc_id'],
				'notification_status'=>0,
				'notification_type_id'=>$candidate_array['notification_type_id'],
			);
		 
			$this->db->where($where)->update('client_in_app_notification',$candidate_array);

			$where1 = array(
				'candidate_id'=>$candidate_array['candidate_id'], 
				'notification_status'=>0,
				'notification_type_id'=>$candidate_array['notification_type_id'],
			);
			
			return $this->db->where($where1)->get('client_in_app_notification')->num_rows();
		}
		
  function date_convert($date){
        $d = 'NA';
        if ($date !='' && $date !=null && $date !='-') { 
            $d = date('d-m-Y', strtotime($date));
        }
        return $d;
    }

    function add_timezone() {
    	$user = $this->session->userdata('logged-in-client');
			$client_id = $user['client_id'];
			$data = $this->db->where('client_id',$client_id)->get('client_timezone')->row_array();

			$time_zone = array(
	 			'client_id' =>$client_id,
	 			'timezone' =>$this->input->post('timezone'),
	 			'clock_type' =>$this->input->post('clock'),
	 			'time_formate' =>$this->input->post('time_type'),
	 			'date_formate' =>$this->input->post('time_formate'),
	 			'created_date' =>date('d-m-Y H:i'),
	 			'updated_date' =>date('d-m-Y H:i')
	 		); 
	 		$result = 0;
	 		if ($data != '' && $data != null) {
	 			 $result = $this->db->where('client_id',$client_id)->update('client_timezone',$time_zone);
	 		} else {
	 			$result = $this->db->insert('client_timezone',$time_zone);
	 		}
			if($result) { 
				return array('status'=>'1','msg'=>'success');
			} else {
				return array('status'=>'0','msg'=>'failled');
			}
		}


    function get_timezone() {
    	$user = $this->session->userdata('logged-in-client');
			$client_id = $user['client_id'];
			return $this->db->where('client_id',$client_id)->get('client_timezone')->row_array();
    }

 	function get_case_skills($package_id='') {
 		if ($package_id !='') {
 			$component = $this->db->where('package_id',$package_id)->get('packages')->row_array();/*$this->get_case_package($package_id);*/
 			$component_id = explode(',', $component['component_ids']);
 			return $this->db->where_in('component_id',$component_id)->get('components')->result_array();
 		}else{

		return $this->db->where('component_status','1')->get('components')->result_array();
 		}
	} 

	function all_components($candidate_id){ 
		$table = array('criminal_checks','court_records','document_check','drugtest','globaldatabase','current_employment','education_details','present_address','permanent_address','previous_employment','reference','previous_address','cv_check','driving_licence','credit_cibil','bankruptcy','directorship_check','global_sanctions_aml','adverse_database_media_check','health_checkup','employment_gap_check','landload_reference','covid_19','social_media','civil_check','right_to_work','sex_offender','politically_exposed','india_civil_litigation','mca','nric','gsa','oig');
		$table_data = array(); 
		$candidate = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		$skills = explode(',', $candidate['component_ids']);
		$table_data = array(); 
		foreach ($table as $key => $value) {
			$id = $this->utilModel->getComponentId($value);
			if (in_array($id,$skills)) { 
			$table_data[$value] = $this->db->where('candidate_id',$candidate_id)->get($value)->row_array(); 
			}
		}

		return $table_data; 
	}

	function get_single_client_data($client_id = ''){
		if ($client_id =='') { 
			$user = $this->session->userdata('logged-in-client');
			$client_id = $user['client_id'];
		}
		$this->db->where('tbl_client.client_id',$client_id); 
		$this->db->select("tbl_client.*,tbl_clientspocdetails.spoc_email_id,tbl_clientspocdetails.spoc_name,tbl_clientspocdetails.spoc_phone_no,tbl_clientspocdetails.spoc_id")->from('tbl_clientspocdetails')
			 ->join('tbl_client','tbl_clientspocdetails.client_id = tbl_client.client_id','left');
	    $query = $this->db->get()->row_array();
	    return $query;
	}

	function get_single_client_cost_centers($client_id = '') {
		if ($client_id == '') { 
			$user = $this->session->userdata('logged-in-client');
			$client_id = $user['client_id'];
		}
		$where_condition = array(
			'client_id' => $client_id
		);
		return $this->db->where($where_condition)->get('autocomplete_location')->result_array();
	}


	function get_all_clients(){
		$user = $this->session->userdata('logged-in-client'); 
		$result = $this->db->where('client_id',$user['client_id'])->get('tbl_client')->row_array(); 
		$sub_result = $this->db->where('is_master',$user['client_id'])->get('tbl_client')->result_array();
	 return array('parent'=>$result, 'child'=>$sub_result);
	}



	function get_all_cases($variable_array) { 
		$client = $this->session->userdata('logged-in-client');
		$user = $this->session->userdata('logged-in-client');
		$client_ids = array();
	 		if ($user['is_master'] =='0') { 
			$data = $this->get_all_clients(); 
			array_push($client_ids,$data['parent']['client_id']);
			if (count($data['child']) > 0) {
				foreach ($data['child'] as $key => $value) {
					array_push($client_ids,$value['client_id']);
				}
			}

			}else{
				array_push($client_ids,$user['client_id']);
			} 
		 

 		
			$i=1;
			$clinet_id_array = array();
			$q1 ='';
			if($variable_array['search']['keyword']) {
			 $q = implode(',', $client_ids);
		 if ($user !='' && $user !=null && count($client_ids)==0) {
		 	$q1 = $user['client_id'];
		 }else{ 
		    $q1 = isset($q)?$q:$user['client_id'];
		 } 

		}

		if ($q1 == 0 || $q1 ==null || $q1 == '' || $q1 == 'null') {
			$q1 = $user['client_id'];
		}

	

		 // $where ='client_id IN ( '.$q1.' ) ';

		$search = $variable_array['search'];
		if($search) {
			$keyword = $search['keyword'];
			if($keyword) {
				if (is_numeric($keyword)) {
					if (strlen($keyword) == 10) {
						$this->db->where("T1.phone_number LIKE '%$keyword%'");
					}else{ 
					$this->db->where("T1.candidate_id",$keyword);
					}
				}else{
				$search = "(T1.first_name LIKE '%$keyword%' OR T1.last_name LIKE '%$keyword%' OR T1.father_name LIKE '%$keyword%' OR T1.email_id LIKE '%$keyword%')";
				$this->db->where($search);

				}
			 
			}
		}
		if (strtolower($this->input->post('case_list_request_type')) == 'insuff') {
			$this->db->where("T1.is_submitted",3);
		} else if (strtolower($this->input->post('case_list_request_type')) == 'client-clarification') {
			$this->db->where("T1.client_clarification_status",1);
		}
		$this->db->select("T1.*,T2.*,T3.package_name as pack_name")->from("candidate AS T1")->join('tbl_client AS T2','T1.client_id = T2.client_id','left')->join('packages AS T3','T1.package_name = T3.package_id','left')->where_in('T1.client_id',explode(',', $q1));

		if($variable_array['count']) {
			return $this->db->count_all_results();
		} else {
			$this->db->limit($variable_array['limit'], $variable_array['offset']);
			$query = $this->db->get();
			
			if($query->num_rows() > 0) {
				$candidateData = $query->result_array();
				$timezone = $this->db->where('client_id',$user['client_id'])->get('client_timezone')->row_array();

				$date_formate = isset($timezone['date_formate'])?$timezone['date_formate']:'d-m-Y';
				
				$data = array();

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

					/*if($candidateValue['tat_start_date'] != null && $candidateValue['tat_end_date'] != null && $candidateValue['tat_pause_date'] != null && $candidateValue['tat_pause_date'] != ''){
						$restart_date = 0;
						$start_date = 0;
						if($candidateValue['tat_re_start_date'] != null && $candidateValue['tat_re_start_date'] != ''){
							$restart_date = $this->number_of_working_days($candidateValue['tat_re_start_date'],date('d-m-Y'));
						}
						if($candidateValue['tat_pause_date'] !=null && $candidateValue['tat_pause_date'] !=''){
							$start_date = $this->number_of_working_days($candidateValue['tat_start_date'],$candidateValue['tat_pause_date']);
						}
						$total = $start_date + $restart_date;
						$row['left_tat_days'] = $total.' days';

					}else if($candidateValue['tat_start_date'] != null && $candidateValue['tat_end_date'] != null){
						if($candidateValue['tat_re_start_date'] != null && $candidateValue['tat_re_start_date'] != ''){
							$row['left_tat_days'] = $this->number_of_working_days($candidateValue['tat_re_start_date'],date('d-m-Y')).' days';
						}else{
							$row['left_tat_days'] = $this->number_of_working_days($candidateValue['tat_start_date'],date('d-m-Y')).' days';
						}

					}else{
						$row['left_tat_days'] = '-';
						$row['tat_overdue'] = '-';
					}	*/
					 
					if ($candidateValue['case_submitted_date'] !='' && $candidateValue['case_submitted_date'] !=null) {
					 
						// $row['case_submitted_date'] = date($date_formate, strtotime($candidateValue['case_submitted_date'])); 
						$row['case_submitted_date'] = $this->utilModel->get_date_formate($candidateValue['case_submitted_date']); 
					}else{
						$row['case_submitted_date'] = '';
					}
					if ($candidateValue['report_generated_date'] !='' && $candidateValue['report_generated_date'] !=null) {
					 
					$row['report_generated_date'] = $this->utilModel->get_date_formate($candidateValue['report_generated_date']); 
					}else{
						$row['report_generated_date'] = '';
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
				return $data;
			} else {
				return array();
			}
		}
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

	function number_of_working_days_($from, $to,$holidayDays='') {
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

	function getTeamData($teamId = '',$role='') {
		if ($role != null && $role != '') {
			// echo $role."<br>";
			return $this->db->select('team_id,first_name,last_name,contact_no,role')->from('team_employee')->where('role',$role)->where('is_Active','1')->get()->result_array();
		} else {
			return $this->db->select('team_id,first_name,last_name,contact_no')->from('team_employee')->where('team_id',$teamId)->where('is_Active','1')->get()->row_array();
		}
	}

	function getPackageData($packageId) {
		return $this->db->select('package_id,package_name')->from('packages')->where('package_id',$packageId)->get()->row_array();
	}

	function getClientData($clientId){
		return $this->db->select('client_id,client_name,high_priority_days,medium_priority_days,low_priority_days')->from('tbl_client')->where('client_id',$clientId)->get()->row_array();
	}

	function get_selected_status_all_cases($param) {
		$user = $this->session->userdata('logged-in-client');
		$this->db->select("candidate.*,tbl_client.*,packages.package_name as pack_name")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('candidate.client_id',$user['client_id']);
		if (MD5(4) != $param) {
			$this->db->where('md5(candidate.is_submitted)',$param);
		}
		$query = $this->db->get('candidate')->result_array();
		return $query;
	}

	function get_selected_all_cases($param){
		$user = $this->session->userdata('logged-in-client');
		return $this->db->select("candidate.*,tbl_client.*,packages.package_name as pack_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('candidate.client_id',$user['client_id'])->where_in('candidate.candidate_id',$param)->get()->result_array();
	}

	function get_team_member_name($team_id ){
		return $this->db->where('team_id',$team_id)->get('team_employee')->row_array();
	}

	function get_packages(){ 
		$user = $this->session->userdata('logged-in-client');
		// $resultClient = $this->db->where('active_status',1)->where('client_id',$client_id)->get('tbl_client')->row_array();
		$package_ids = explode(',', $user['packages']); 
		return $package_name = $this->db->where('package_status',1)->where_in('package_id',$package_ids)->get('packages')->result_array();

	}

	function get_component_type(){
		$component_names = array();
		$education_type = $this->db->where('status',1)->get('education_type')->result_array();
		$document_type = $this->db->where('status',1)->get('document_type')->result_array();
		$drug_test_type = $this->db->where('status',1)->get('drug_test_type')->result_array();

		$component_names['education_type']= $education_type;
		$component_names['documetn_type']= $document_type;
		$component_names['drug_test_type']= $drug_test_type; 
		return $component_names;
	}

	function get_single_case($candidate_id){
	$client = $this->session->userdata('logged-in-client');
		$user = $this->session->userdata('logged-in-client');
		$client_ids = array();
	 		if ($user['is_master'] =='0') { 
			$data = $this->get_all_clients(); 
			array_push($client_ids,$data['parent']['client_id']);
			if (count($data['child']) > 0) {
				foreach ($data['child'] as $key => $value) {
					array_push($client_ids,$value['client_id']);
				}
			}

			}else{
				array_push($client_ids,$user['client_id']);
			}  
		return $this->db->select("candidate.*,tbl_client.client_name,packages.package_name as pack_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where_in('candidate.client_id',$client_ids)->where('candidate_id',$candidate_id)->get()->result_array();
	}

 	function get_single_case_details($candidate_id) {
 		$result = $this->db->where('candidate_id',$candidate_id)
 						->select("candidate.*,tbl_client.client_name,packages.package_name as pack_name")
 						->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')
 						->join('packages','candidate.package_name = packages.package_id','left')
 						->get()->row_array();
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
 			 $row['country_code'] = isset($result['country_code'])?$result['country_code']:''; 
 			 $row['phone_number'] = $result['phone_number']; 
 			 $row['email_id'] = $result['email_id']; 
 			 $row['additional_docs'] = $result['additional_docs']; 
 			 $row['date_of_birth'] = $this->date_convert($result['date_of_birth']); 
 			 $row['date_of_joining'] = $this->date_convert($result['date_of_joining']); 
 			 $row['employee_id'] = $result['employee_id'];
 			 // if (['candidate_details_added_from'] == 1) {
 			 // 	$get_package_name = $this->db->where('')->get();
 			 // } else {
 			 // 	$row['package_name'] = $result['pack_name']; 
 			 // }
 			 $row['package_name'] = $result['pack_name']; 
 			 $row['remark'] = $result['remark']; 
 			 $row['form_values'] = $result['form_values'];			 
 			 $row['document_uploaded_by'] = $result['document_uploaded_by']; 
 			 $row['document_uploaded_by_email_id'] = $result['document_uploaded_by_email_id']; 
 			 $row['is_submitted'] = $result['is_submitted']; 
 			 $row['priority'] = $result['priority'];
 			 $row['is_report_generated'] = $result['is_report_generated'];
 			 $row['client_case_intrim_notification'] = $result['client_case_intrim_notification'];
 			 $row['component_data'] = $this->getStatusFromComponent($result['candidate_id'],$value['component_id']);
 			 array_push($case_data, $row);
 		}

 		
 		return $case_data;
	}

	function insert_case() {
		$user = $this->session->userdata('logged-in-client');
		// echo $this->isInputQcExits()."||";
		if($this->isInputQcExits() == 1){
			$team_id = $this->getMinimumTaskHandlerInputQC();
		} else {
			return array('status'=>'2','msg'=>'Please, Enter first InputQC Or Team member.','email_status'=>'0','smsStatus'=>'0');
		}
		// $rand = rand();
		$get_candidate_otp_of_came_mobile_number = $this->db->select('otp_password, loginId')->where('phone_number',$this->input->post('user_contact'))->get('candidate')->result_array();
		$otp_list = [];
		$login_id_list = [];
		foreach ($get_candidate_otp_of_came_mobile_number as $key => $value) {
			array_push($otp_list, $value['otp_password']);
			if ($value['loginId'] != '') {
				array_push($login_id_list, $value['loginId']);
			}
		}
		
		$variable_array = array(
			'otp_list' => $otp_list,
			'otp_length' => $this->config->item('otp_to_candidate_length')
		);
		$login_otp = $this->utilModel->random_number_with_duplication_check($variable_array);

		// $variable_array = array(
		// 	'otp_list' => $login_id_list,
		// 	'otp_length' => $this->config->item('login_id_to_candidate_length')
		// );
		// $login_id = $this->utilModel->random_number_with_duplication_check($variable_array);

		$login_id = (substr($this->input->post('user_contact'), 0, 6)).''.$login_otp;

		/*$team_id = $this->db->query("SELECT * FROM `team_employee` LEFT JOIN candidate ON team_employee.team_id = candidate.assigned_inputqc_id WHERE team_employee.role='inputqc' ORDER BY candidate.assigned_inputqc_id ASC")->row_array();*/
		// $login_otp = $this->rendomNumber(4);
		$ids = explode(',', $this->input->post('skills'));
		$component  = array_unique($ids);
		asort($component);
		$sms_flag ='1';

		$name = ucwords($this->input->post('first_name'))." ".ucwords($this->input->post('last_name'));
		$send_email = $this->input->post('email');
		if ($this->input->post('document_uploader') =='client') {
			$send_email = $this->input->post('client_email');
			$name = $user['client_name'];
			$sms_flag ='0';
		}

		$client_email_id = strtolower($send_email);
		// Send To User Starts
		// $client_email_subject = 'Candidate Verification Form';
		// $email_message ='';
		// $email_message .= '<html> ';
		// $email_message .= '<head>';
		// $email_message .= '<style>';
		// $email_message .= 'table {';
		// $email_message .= 'font-family: arial, sans-serif;';
		// $email_message .= 'border-collapse: collapse;';
		// $email_message .= 'width: 100%;';
		// $email_message .= '}';

		// $email_message .= 'td, th {';
		// $email_message .= 'border: 1px solid #dddddd;';
		// $email_message .= 'text-align: left;';
		// $email_message .= 'padding: 8px;';
		// $email_message .= '}';

		// $email_message .= 'tr:nth-child(even) {';
		// $email_message .= 'background-color: #dddddd;';
		// $email_message .= '}';
		// $email_message .= '</style>';
		// $email_message .= '</head>';
		// $email_message .= '<body> ';
		// $email_message .= "<p>Dear ".$this->input->post('first_name')." ".$this->input->post('last_name')."</p>";
		// $email_message .= '<p>Greetings from Factsuite!!</p>';
		// $email_message .= '<p>'.$user['client_name'].' has partnered with Factsuite to conduct Employment Background Screening of prospective employees.</p>';
		// $email_message .= '<p>To proceed with this activity, we request you to provide relevant details of your profile, as requested on the Factsuite CRM application.</p>';
		// $email_message .= '<p>Please find your Login Credentials mentioned below-</p>';
		// $email_message .= '<table>';
		// $email_message .= '<th>CRM Link</th>';
		// $email_message .= '<th>Mobile Number</th>';
		// // $email_message .= '<th>OTP</th>';
		// $email_message .= '<tr>';
		// $email_message .= '<td>'.$this->config->item('candidate_url').'</td>';
		// $email_message .= '<td>'.$this->input->post('user_contact').'</td>';
		// // $email_message .= '<td>-</td>';//http://localhost:8080/factsuitecrm/
		// $email_message .= '<tr>';
		// $email_message .= '</table>';
		// $email_message .= '<p><b>Note:</b> Kindly update the information requested as accurately as possible and upload the supporting documents where necessary, to enable us to conduct a hassle-free screening of your profile.</p>';
		// $email_message .= '<p><b>Yours sincerely,<br>';
		// $email_message .= 'Team FactSuite</b></p>';
		// $email_message .= '</body>';
		// $email_message .= '</html>';

		$client_email_subject = 'Verification Process - FactSuite';

		$templates = $this->db->where_in('client_id',[0,$user['client_id']])->where('template_type','Initiate Case')->get('email-templates')->row_array();
				$email_message ='';
				if (isset($templates['template_content'])) { 
						$need_replace = ["@candidate_name","@client_name", "@link", "@loginid", "@otp_or_password"];
					$replace_strings   = [ucwords($name),ucwords($user['client_name']), $this->config->item('candidate_url'), $login_id,$login_otp ];

					$email_message =  str_replace($need_replace, $replace_strings, $templates['template_content']);
					
			}else{

				

		$email_message ='';
		$email_message .= '<html> ';
		$email_message .= '<head>';
		$email_message .= '<style>';
		$email_message .= 'table {';
		$email_message .= 'font-family: arial, sans-serif;';
		$email_message .= 'border-collapse: collapse;';
		$email_message .= 'width: 100%;';
		$email_message .= '}';

		$email_message .= 'td, th {';
		$email_message .= 'border: 1px solid #dddddd;';
		$email_message .= 'text-align: left;';
		$email_message .= 'padding: 8px;';
		$email_message .= '}';

		$email_message .= 'tr:nth-child(even) {';
		$email_message .= 'background-color: #dddddd;';
		$email_message .= '}';
		$email_message .= '</style>';
		$email_message .= '</head>';
		$email_message .= '<body> ';
		$email_message .= "<p>Dear ".$name."</p>";
		$email_message .= '<p>Greetings from Factsuite!!</p>';
		if ($sms_flag ==1) { 
		$email_message .= '<p>'.ucwords($user['client_name']).' has partnered with Factsuite to conduct your background verification.</p>';
		$email_message .= '<p>To proceed with your verification, we request you to kindly fill the information as requested on the Factsuite CRM application.</p>';
		}else{
			$email_message .= '<p>To proceed with the '.ucwords($this->input->post('first_name'))." ".ucwords($this->input->post('last_name')).' verification, we request you to kindly fill the information as requested on the Factsuite CRM application.</p>';
		}
		$email_message .= '<p>In case of any queries, please reach out to us at help@factsuite.com</p>';
		// $email_message .= '<p>Please find your Login ID :'.$login_id.'</p>';
		$email_message .= '<p>Please find your Login Credentials mentioned below to access the FactSuite CRM:</p>';
		$email_message .= '<table>';
		$email_message .= '<th>CRM Link</th>';
		// $email_message .= '<th>Mobile Number</th>';
		$email_message .= '<th>Login ID</th>';
		// if ($this->input->post('document_uploader') == 'client') {
			$email_message .= '<th>OTP</th>';
		// }
		$email_message .= '<tr>';
		$email_message .= '<td>'.$this->config->item('candidate_url').'</td>';
		// $email_message .= '<td>'.$this->input->post('user_contact').'</td>';
		$email_message .= '<td>'.$login_id.'</td>';
		// if ($this->input->post('document_uploader') == 'client') {
			$email_message .= '<td>'.$login_otp.'</td>';
		// }
		$email_message .= '<tr>';
		$email_message .= '</table>';
		$email_message .= '<p><b>Note:</b> Kindly update the information requested as accurately as possible and upload the supporting documents where necessary, to enable us to conduct a hassle-free verification of your profile.</p>';
		$email_message .= '<p><b>Yours sincerely,<br>';
		$email_message .= 'Team FactSuite</b></p>';
		$email_message .= '<p style="font-style: italic; color: #481777;">*Factsuite is an Authentication, Verification and Evaluation service enterprise providing Employee Background Verification, Tenant Verification & Support Staff Verification services globally. FactSuite is committed to serve its customers with the best of technology & efficient verification processes helping them make informed decisions. Please visit www.factsuite.com to know more about us.</p>';
		$email_message .= '</body>';
		$email_message .= '</html>';

	}

		$notification = array('admin'=>'0','inputQc'=>'0','client'=>'1','outPutQc'=>'0');
		$notification = json_encode($notification);
		$case_data = array(
			'client_id' =>$user['client_id'],
			'client_spoc_id' =>$user['spoc_id'],
			'title' => $this->input->post('title'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'father_name' => $this->input->post('father_name'),
			'country_code' => $this->input->post('country_code'),
			'phone_number' => $this->input->post('user_contact'),
			'loginId' => $login_id,
			'package_name' => $this->input->post('package'),
			'document_uploaded_by' => $this->input->post('document_uploader'),
			'date_of_birth' => $this->input->post('birthdate'),
			'date_of_joining' => $this->input->post('joining_date'),
			'employee_id' => $this->input->post('employee_id'),
			'remark' => $this->input->post('remark'),
			'email_id' => $this->input->post('email'),
			'component_ids' => implode(',', $component),
			'document_uploaded_by_email_id' => $this->input->post('client_email'),
			'case_added_by_id'=>$user['client_id'],
			'case_added_by_role'=>'client',
			'assigned_inputqc_id'=>$team_id,
			'form_values'=>json_encode($this->input->post('form_values')),
			'alacarte_components'=>$this->input->post('alacarte_components'),
			'package_components' => $this->input->post('package_component'),
			'otp_password'=>$login_otp,
			'new_case_added_notification'=> $notification,
			'segment' => $this->input->post('segment'),
			'cost_center' => $this->input->post('cost_center'),
			'priority' => 1
		);
		if($this->isInputQcExits() == 1) {
			if ($this->db->insert('candidate',$case_data)) {
				$insert_id = $this->db->insert_id();
				$txtSmsStatus = '0';
				$smsStatus = '0';
				$email_status = '0';
				if ($this->input->post('document_uploader') != 'client') {
					if ($sms_flag == '1') { 
					$smsStatus = $this->smsModel->send_sms($this->input->post('first_name'),$user['client_name'],$this->input->post('user_contact'),$login_otp,'1');
					}
					if($smsStatus == "200") {
						$txtSmsStatus = '1';
					} else {
						$txtSmsStatus = '0';
					}

					// $send_email_to_user = $this->emailModel->send_mail($client_email_id,$client_email_subject,$email_message);
					if($this->emailModel->send_mail($client_email_id,$client_email_subject,$email_message)){
						$email_status = '1';	 
					} else {
						$email_status = '0'; 
					}
				} else {
					$get_candidate_details = $this->db->where('candidate_id',$insert_id)->get('candidate')->row_array();
					$this->session->set_userdata('logged-in-candidate',$get_candidate_details);

					$component_ids = array();
					foreach (explode(',', $get_candidate_details['component_ids']) as $key => $value) {
						if (!in_array($value,array('14','15','19','21','24'))) { 
							array_push($component_ids,$value);
						}
					}
				 	$this->session->set_userdata('component_ids',implode(',', $component_ids));
				 	$data['is_submitted'] = '1';
				 	$data['redirect_url'] = '';
			 		$this->session->set_userdata('is_submitted',1);
			 		$this->session->set_userdata('candidate_details_submitted_by','client');

					$txtSmsStatus = '1';
					$smsStatus = '1';
					$email_status = '1';
				}

				$case_log_data = array(
					'candidate_id' =>$insert_id,
					'client_id' =>$user['client_id'],
					'title' => $this->input->post('title'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'father_name' => $this->input->post('father_name'),
					'country_code' => $this->input->post('country_code'),
					'phone_number' => $this->input->post('user_contact'),
					'loginId' => $login_id,
					'package_name' => $this->input->post('package'),
					'document_uploaded_by' => $this->input->post('document_uploader'),
					'date_of_birth' => $this->input->post('birthdate'),
					'date_of_joining' => $this->input->post('joining_date'),
					'employee_id' => $this->input->post('employee_id'),
					'remark' => $this->input->post('remark'),
					'email_id' => $this->input->post('email'),
					'component_ids' => implode(',', $component),
					'document_uploaded_by_email_id' => $this->input->post('client_email'),
					'case_added_by_id'=>$user['client_id'],
					'case_added_by_role'=>'client',
					'assigned_inputqc_id'=>$team_id,
					'alacarte_components'=>$this->input->post('alacarte_components'),
					'form_values'=>json_encode($this->input->post('form_values')),
					'package_components' => $this->input->post('package_component'),
					'segment' => $this->input->post('segment'),
					'cost_center' => $this->input->post('cost_center'),
					'otp_password'=>$login_otp,
					'new_case_added_notification'=> $notification
				);
				$this->db->insert('candidate_log',$case_log_data);
				if (strtolower($this->input->post('document_uploader') == 'inputqc')) {
					$this->session->set_userdata('is_submitted',1);
			 		$this->session->set_userdata('candidate_details_submitted_by','client');
				}
				
				return array('status'=>'1','msg'=>'success','email_status'=>$email_status,'smsStatus'=>$txtSmsStatus);
			} else {
				return array('status'=>'0','msg'=>'faliled','email_status'=>$email_status,'smsStatus'=>$txtSmsStatus);
			}
		} else {
			return array('status'=>'2','msg'=>'Please, Enter first InputQC Or Team member.','email_status'=>'0','smsStatus'=>'0');
		}
	}

	function isInputQcExits() {
		$employee_data = $this->db->where('role','inputqc')->get('team_employee')->result_array();
		// echo count($employee_data);
		if(count($employee_data) > 0){
			// return $employee_data;
			return '1';
		} else {
			return '0';
			// return $employee_data;
		}
	}

	function update_case() { 
		$user = $this->session->userdata('logged-in-client');
		if($this->isInputQcExits() == 1){
			$team_id = $this->getMinimumTaskHandlerInputQC();
		} else {
			return array('status'=>'2','msg'=>'Please, Enter first InputQC Or Team member.','email_status'=>'0','smsStatus'=>'0');
		}
		/*$team_id = $this->db->query("SELECT * FROM `team_employee` LEFT JOIN candidate ON team_employee.team_id = candidate.assigned_inputqc_id WHERE team_employee.role='inputqc' ORDER BY candidate.assigned_inputqc_id ASC")->row_array();*/		
		$candidat = $this->db->where('candidate_id',$this->input->post('candidate_id'))->get('candidate')->row_array(); 

		$ids = explode(',', $this->input->post('skills'));
		$component_ids = explode(',', $candidat['component_ids']);

		$component  = array_unique($ids);
		asort($component);
		$case_data = array(
			'client_id' =>$user['client_id'],
			'client_spoc_id' =>$user['spoc_id'],
			'title' => $this->input->post('title'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'father_name' => $this->input->post('father_name'),
			'country_code' => $this->input->post('country_code'),
			'phone_number' => $this->input->post('user_contact'),
			'package_name' => $this->input->post('package'),
			'document_uploaded_by' => $this->input->post('document_uploader'),
			'date_of_birth' => $this->input->post('birthdate'),
			'date_of_joining' => $this->input->post('joining_date'),
			'employee_id' => $this->input->post('employee_id'),
			'remark' => $this->input->post('remark'),
			'email_id' => $this->input->post('email'),
			'component_ids' => implode(',', $component),
			'document_uploaded_by_email_id' => $this->input->post('client_email'),
			'case_added_by_id'=>$user['client_id'],
			'case_added_by_role'=>'client',
			'assigned_inputqc_id'=>$team_id,
			'alacarte_components'=>$this->input->post('alacarte_components'),
			'form_values'=>json_encode($this->input->post('form_values')),
			'package_components' => $this->input->post('package_component'),
			'segment' => $this->input->post('segment'),
			'cost_center' => $this->input->post('cost_center'),
			'case_updated_by'=>$user['spoc_id'],
			'case_updated_by_role'=>'client',
			'case_updated_by_date'=>date('Y-m-d H:i:s'),
		);

		if ($this->input->post('init') =='1') {
			$case_data['case_reinitiate'] = 1;
			$case_data['case_re_initiation_date'] = date('Y-m-d H:i:s');
		}

		// if (count($component) < count($component_ids)) {
			$case_data['is_submitted'] = 0;
		// }

		$client_email_id = strtolower($this->input->post('email'));
		// Send To User Starts
		$client_email_subject = 'Candidate Verification Form';

		/*$client_email_message = '<html><body>';
		$client_email_message .= 'Hello : '.$this->input->post('first_name').'<br>';
		$client_email_message .= "You will be receiving an SMS/Email to complete your address verification as part of the Background Verification process initiated by <b>{$this->input->post('first_name')}</b>. Kindly click on the link to complete the task.";
		$client_email_message .= 'Thank You,<br>';
		$client_email_message .= 'Team Factsuite';
		$client_email_message .= '</html></body>';*/

		$name = $this->input->post('first_name')." ".$this->input->post('last_name');

		$templates = $this->db->where_in('client_id',[0,$user['client_id']])->where('template_type','Initiate Case')->get('email-templates')->row_array();
				$email_message ='';
				$login_otp  =$candidat['otp_password'];
				if (isset($templates['template_content'])) { 
						$need_replace = ["@candidate_name","@client_name", "@link", "@loginid", "@otp_or_password"];
					$replace_strings   = [ucwords($name),ucwords($user['client_name']), $this->config->item('candidate_url'), $candidat['loginId'],$login_otp ];

					$email_message =  str_replace($need_replace, $replace_strings, $templates['template_content']);
					
			}else{

		$email_message ='';
		$email_message .= '<html> ';
		$email_message .= '<head>';
		$email_message .= '<style>';
		$email_message .= 'table {';
		$email_message .= 'font-family: arial, sans-serif;';
		$email_message .= 'border-collapse: collapse;';
		$email_message .= 'width: 100%;';
		$email_message .= '}';

		$email_message .= 'td, th {';
		$email_message .= 'border: 1px solid #dddddd;';
		$email_message .= 'text-align: left;';
		$email_message .= 'padding: 8px;';
		$email_message .= '}';

		$email_message .= 'tr:nth-child(even) {';
		$email_message .= 'background-color: #dddddd;';
		$email_message .= '}';
		$email_message .= '</style>';
		$email_message .= '</head>';
		$email_message .= '<body> ';
		$email_message .= "<p>Dear ".$name."</p>";
		$email_message .= '<p>Greetings from Factsuite!!</p>';
		$email_message .= '<p>'.$user['client_name'].' has partnered with Factsuite to conduct Employment Background Screening of prospective employees.</p>';
		$email_message .= '<p>To proceed with this activity, we request you to provide relevant details of your profile, as requested on the Factsuite CRM application.</p>';
		$email_message .= '<p>Please find your Login Credentials mentioned below-</p>';
		$email_message .= '<table>';
		$email_message .= '<th>CRM Link</th>';
		$email_message .= '<th>Login Id</th>';
		// $email_message .= '<th>OTP</th>';
		$email_message .= '<tr>';
		$email_message .= '<td>'.$this->config->item('candidate_url').'</td>';
		$email_message .= '<td>'.$candidat['loginId'].'</td>';
		// $email_message .= '<td>-</td>';//http://localhost:8080/factsuitecrm/
		$email_message .= '<tr>';
		$email_message .= '</table>';
		$email_message .= '<p><b>Note:</b> Kindly update the information requested as accurately as possible and upload the supporting documents where necessary, to enable us to conduct a hassle-free screening of your profile.</p>';
		$email_message .= '<p><b>Yours sincerely,<br>';
		$email_message .= 'Team FactSuite</b></p>';
		$email_message .= '</body>';
		$email_message .= '</html>';
	}
		$send_email_to_user = $this->emailModel->send_mail($client_email_id,$client_email_subject,$email_message);
		$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('candidate',$case_data)) {
			$insert_id = $this->input->post('candidate_id');
			$case_log_data = array(
				'candidate_id' =>$insert_id,
				'client_id' =>$user['client_id'],
				'title' => $this->input->post('title'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'father_name' => $this->input->post('father_name'),
				'country_code' => $this->input->post('country_code'),
				'phone_number' => $this->input->post('user_contact'),
				'package_name' => $this->input->post('package'),
				'document_uploaded_by' => $this->input->post('document_uploader'),
				'date_of_birth' => $this->input->post('birthdate'),
				'date_of_joining' => $this->input->post('joining_date'),
				'employee_id' => $this->input->post('employee_id'),
				'remark' => $this->input->post('remark'),
				'email_id' => $this->input->post('email'),
				'component_ids' => implode(',', $component),
				'document_uploaded_by_email_id' => $this->input->post('client_email'),
				'case_added_by_id'=>$user['client_id'],
				'case_added_by_role'=>'client',
				'assigned_inputqc_id'=>$team_id,
				'alacarte_components'=>$this->input->post('alacarte_components'),
				'form_values'=>json_encode($this->input->post('form_values')),
				'package_components' => $this->input->post('package_component'),
				'segment' => $this->input->post('segment'),
				'cost_center' => $this->input->post('cost_center')
			);
			$this->db->insert('candidate_log',$case_log_data);
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'faliled');
		}
	}
	
	function valid_mail() {
		if ($this->input->post('candidate_id')) {
			$this->db->where('candidate_id !=',$this->input->post('candidate_id'));
		}
		$result = $this->db->where('email_id',$this->input->post('email'))->get('candidate')->num_rows();
		if ($result > 0) {
			return array('status'=>'0','msg'=>'faliled');			
		} else {
			return array('status'=>'1','msg'=>'success');
		}
	}

	function get_case_package($package='') {
		$user = $this->session->userdata('logged-in-client');
		if($package !=''){
			return $this->db->where('package_id',$package)->or_where('package_name',$package)->get('packages')->row_array();
		}
		$package_ids ='';
		if ($this->session->userdata('logged-in-client')) { 
		$user = $this->session->userdata('logged-in-client');
		$package_ids = array('package_status'=>1,'package_id'=>explode(',', isset($user['packages'])?$user['packages']:''));
		}else{
			$package_ids = array('package_status'=>1);
		}
		return $this->db->where('package_status',1)->where_in('package_id',explode(',', isset($user['packages'])?$user['packages']:''))->get('packages')->result_array();
	}

	function insert_bulk_case($bulk_case){
		if (count($bulk_case) == 0) {
			return array('status'=>'0','msg'=>'faliled');
		}
		if ($this->db->insert_batch('candidate',$bulk_case)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'1','msg'=>'success');
		}
	}

	function valid_phone_number($number){
		if ($this->input->post('candidate_id')) {
			$this->db->where('candidate_id !=',$this->input->post('candidate_id'));
		}
		$result = $this->db->where('phone_number',$number)->get('candidate');
		if ($result->num_rows() > 0) {
			return array('status'=>'0','msg'=>'faliled');
		}else{
			 return array('status'=>'1','msg'=>'success');
		}
	}

	function getStatusFromComponen_t($candidate_id,$component_id){
		$status = '';
		$table_name = '';
		switch ($component_id) {
			
			case '1':
				$table_name = 'criminal_checks';
				
				break;

			case '2':
				$table_name = 'court_records';
				
				break;
			case '3':
				$table_name = 'document_check';
				break;

			case '4':
				$table_name = 'drugtest';
				break;

			case '5':
				$table_name = 'globaldatabase';
				break;

			case '6':
				$table_name = 'current_employment';
				break; 
			case '7':
				$table_name = 'education_details';
				break; 
			case '8':
				$table_name = 'present_address';
				break; 
			case '9':
				$table_name = 'permanent_address';
				break; 
			case '10':
				$table_name = 'previous_employment';
				break; 
			case '11':
				$table_name = 'reference';
				break; 
			case '12':
				$table_name = 'previous_address';
				break; 
			case '14':
				$table_name = 'directorship_check';
				break;
			case '15':
				$table_name = 'global_sanctions_aml';
				break;
			case '16':
				$table_name = 'driving_licence';
				break;
			case '17':
				$table_name = 'credit_cibil';
				break;
			case '18':
				$table_name = 'bankruptcy';
				break;
			case '19':
				$table_name = 'adverse_database_media_check';
				break;
			case '20':
				$table_name = 'cv_check';
				break;
			case '21':
				$table_name = 'health_checkup';
				break;
			case '22':
				$table_name = 'employment_gap_check';
				break;
			case '23':
				$table_name = 'landload_reference';
				break;
			case '24':
				$table_name = 'covid_19';
				break;
			case '25':
				$table_name = 'social_media';
				break;
			default:
				 
				break;
		}


		$result = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
		 
		if(isset($result['status'])){
			$status = $result['status'];
		}else{
			$status = '0';
		}
		return $result;
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

	function getComponentBasedData($candidate_id,$table_name){
		 
		$component_based = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
		
		if($component_based != '' ){
			$candidateInfo = $this->db->select('form_values')->from('candidate')->where('candidate_id',$candidate_id)->get()->row_array();
	 		$component_based['form_values'] = $candidateInfo['form_values'];
 		}

		return $component_based;

	}

	function add_request_form(){ 
		$user = $this->session->userdata('logged-in-client');
		$client_id = $user['client_id'];
		$component_id = $this->input->post('comonent_id');
		$number_of_form = $this->input->post('number_of_form');
		$package_id = $this->input->post('package_id');
		$form_request = array(
		'client_id' => $client_id,
		'component_id' => $component_id,
		'package_id' => $package_id,
		'form_up_to' => $number_of_form,
		'added_by'=>$client_id,
		'added_role' => 'client',
		); 
		// return $form_request;
		if ($this->db->insert('form_request',$form_request)) {
			 return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'faliled');
		}
	}


	// Servtel SMS intigration.
	function send_sms($first_name,$client_name,$ph_number,$login_otp,$messageStatus) {
		$login_link = $this->config->item('candidate_link');

		$pass_data = '';
		if($messageStatus == '1'){
			// OTP message
			// $pass_data = 'Hi '.$first_name.', this verification is initiated by '.$client_name.' as part of your Background Verification Process. Kindly click on the link to complete the task. http://onelink.to/j4yv6q Login by entering your mobile number and password:'.$login_otp.'. Thanks, Team FactSuite';

			$pass_data = 'Hi '.$first_name.', this verification is initiated by '.$client_name.' as part of your employee/tenant/support staff background verification process. Kindly click on the link to complete the task '.$login_link.'. Log in by entering your mobile number and password: '.$login_otp.'. Thanks, Team FactSuite';

		}else if($messageStatus == '2'){
			// Insuff Message
			// $pass_data = 'Hi '.$first_name.', this verification is initiated by '.$client_name.' as part of your Background Verification Process. Kindly click on the link to complete the task. http://onelink.to/j4yv6q Login by entering your mobile number and password:'.$login_otp.'. Thanks, Team FactSuite';

			$pass_data = 'Hi '.$first_name.', this verification is initiated by '.$client_name.' as part of your employee/tenant/support staff background verification process. Kindly click on the link to complete the task '.$login_link.'. Log in by entering your mobile number and password: '.$login_otp.'. Thanks, Team FactSuite';
		}
		
	    $curl = curl_init();
	    curl_setopt_array($curl, array(
	        CURLOPT_URL => 'http://sms-alerts.servetel.in/api/v4/?api_key=A25b53c27773fb73f72a71c651134b73e&method=sms&message='.urlencode($pass_data).'&to=91'.$ph_number.'&sender=FACTSU',
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_ENCODING => "",
	        CURLOPT_MAXREDIRS => 10,
	        CURLOPT_TIMEOUT => 0,
	        CURLOPT_FOLLOWLOCATION => true,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => "POST",
	    ));
	    $response = curl_exec($curl);
	    $curl_response_data = json_decode($response,true);
	    
	    if(strtolower($curl_response_data['status']) == 'ok') {
	        return $status = '200';
	    } else { 
	    	return $status = '201';
	        // $sms_error_insert = "INSERT INTO `sms_email_error_log`(`error_type`, `candidate_id`)
	        //                     VALUES (1,'".$candidate_id."')";
	        // if(mysqli_query($conncetion,$sms_error_insert)){
	        //     echo $status = '201';
	        // } else {
	        //     echo $status = '202';
	        // }
	    }
	}

	function rendomNumber($digits){
		return rand(pow(10, $digits - 1) - 1, pow(10, $digits) - 1);
    	 
	}


	function getSingleAssignedCaseDetails($candidate_id) {
		
 		$result = $this->db->where_in('candidate_id',$candidate_id)->select("candidate.*, candidate.package_name AS selected_package_id, tbl_client.*, tbl_client.package_components AS client_packages_list, packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->row_array();


 		
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
 			$valid_comp = array('Criminal Status','Court Record','Document Check','Drug Test','Highest Education','Previous Employment','Previous Address','Reference','Credit / Cibil Check','Bankruptcy Check','Adverse Media/Media Database Check','Directorship Check','Global Sanctions/ AML','Health Checkup Check','Previous Landlord Reference Check','Covid-19 Check','Social Media Check');
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
	 			// $row['component_id'] = $value['component_id'];
	 			$row['component_id'] = $value['component_id'];
	 			$row['component_name'] = $value['component_name']; 
	 			$row['client_id'] = $result['client_id']; 
	 			$row['client_name'] = $result['client_name']; 
	 			$row['candidate_id'] = $result['candidate_id']; 
	 			$row['title'] = $result['title']; 
	 			$row['first_name'] = $result['first_name']; 
	 			$row['last_name'] = $result['last_name']; 
	 			$row['father_name'] = $result['father_name']; 
	 			$row['phone_number'] = $result['phone_number']; 
	 			$row['email_id'] = $result['email_id']; 
	 			$row['date_of_birth'] = $result['date_of_birth']; 
	 			$row['date_of_joining'] = $result['date_of_joining']; 
	 			$row['employee_id'] = $result['employee_id']; 
	 			$row['package_name'] = $result['package_name']; 
	 			$row['remark'] = $result['remark']; 
	 			$row['priority'] = $result['priority']; 
	 			$row['document_uploaded_by'] = $result['document_uploaded_by']; 
	 			$row['document_uploaded_by_email_id'] = $result['document_uploaded_by_email_id']; 
	 			$row['created_date'] = date('Y-m-d', strtotime($result['created_date']) );  
	 			$row['updated_date'] = date('Y-m-d', strtotime($result['updated_date']) );  
	 			$row['is_submitted'] = $result['is_submitted'];
	 			$row['form_values'] = $result['form_values'];
	 			$row['client_packages_list'] = $result['client_packages_list'];
	 			$row['selected_package_id'] = $result['selected_package_id'];
	 			$type_of_val ='';
	 			if ($results !='') {
	 				$type_of_val = isset($results[$inputQcStatuskey]['education_type_name'])?$results[$inputQcStatuskey]['education_type_name']:'';
	 			}
	 			$row['value_type'] = $type_of_val;
	 			
	 			// Tat Details
	 			$row['tat_start_date'] = $this->date_convert(isset($result['tat_start_date'])?$result['tat_start_date']:'');
	 			$row['tat_pause_date'] = $this->date_convert(isset($result['tat_pause_date'])?$result['tat_pause_date']:'');
	 			$row['tat_re_start_date'] = $this->date_convert(isset($result['tat_re_start_date'])?$result['tat_re_start_date']:'');
	 			$row['tat_end_date'] = $this->date_convert(isset($result['tat_end_date'])?$result['tat_end_date']:'');
	 			$row['tat_pause_resume_status'] = isset($result['tat_pause_resume_status'])?$result['tat_pause_resume_status']:'-';
	 			if($result['priority'] == '1') {
	 				$row['tat_days'] = $result['medium_priority_days']; 	
	 			} else if($result['priority'] == '2') {
	 				$row['tat_days'] = $result['high_priority_days']; 
	 			} else {
	 				$row['tat_days'] = $result['low_priority_days']; 
	 			}
	 			
	 			$inputQcComStatus = $this->stringExplode(isset($componetStatus['status'])?$componetStatus['status']:'');
	 			// echo "inputQcComStatus:".$componetStatus['status']."<br>"; 
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
	 			$row['insuff_created_date'] = $this->date_convert(isset($insuff_created_date[$inputQcStatuskey])?$insuff_created_date[$inputQcStatuskey]:'');
	 			$row['insuff_close_date'] = $this->date_convert(isset($insuff_close_date[$inputQcStatuskey])?$insuff_close_date[$inputQcStatuskey]:'');
	 			$roles = array('analyst','specialist');
	 			$row['emp_data_analyst'] = $this->getAnalystAndSpecialistTeamList($value['component_id']);
	 			// $row['emp_data_insuff_analyst'] = $this->getInsuffAnalystAndSpecialistTeamList();
	 			
	 			array_push($case_data, $row);  
 			}
 		}
 		return $case_data;
	} 


	function getAnalystAndSpecialistTeamList($component_id){

		$query = "SELECT team_id,first_name,last_name,role,skills FROM `team_employee` where (`role` ='analyst' OR `role` ='specialist') AND `is_Active`='1' AND `skills` REGEXP ".$component_id;
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



	function getTeamEmpData($team_id){
		 
		$teamDetails = $this->db->where('team_id',$team_id)->get('team_employee')->row_array();
		 
		$result = [];
 		if($teamDetails != null && $teamDetails != ''){
 			$result['name'] = $teamDetails['first_name'].' '.$teamDetails['last_name']; 
 		}else{
 			$result['name'] = '-';
 		}
		return $result;

	}


		function getSingleAssignedCaseDetail_s($candidate_id) {
		
 		$result = $this->db->where_in('candidate.candidate_id',$candidate_id)->select("candidate.*, candidate.package_name AS selected_package_id, tbl_client.*, tbl_client.package_components AS client_packages_list, packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->row_array();

 		$form_values = json_decode($result['form_values'],true);
        $form_values = json_decode($form_values,true);

 		$component_id = explode(',', $result['component_ids']);
 		$component = $this->db->where_in('component_id',$component_id)->get('components')->result_array();
 		$team = $this->db->where('team_id',$result['account_manager_name'])->get('team_employee')->row_array();
 		// $componentIds = ['16','17','18','20'];

 		 $case_data  = array();
 		 $num = 0;
 		foreach ($component as $key => $value) {
 			// if(in_array($value['component_id'],$componentIds) != -1){
 				// echo 'key : '.$key.'<br>';
 				$componetStatus = $this->getStatusFromComponent($result['candidate_id'],$value['component_id']);
	 			$inputQcStatus = isset($componetStatus['status'])?$componetStatus['status']:'0';
	 			$inputQcStatus = explode(',',$inputQcStatus);
	 			$spoc = $this->db->where('spoc_id',$result['client_spoc_id'])->get('tbl_clientspocdetails')->row_array();
	 			$insuff_rem = '-';
	 		$insuff_closure='-';
	 		$verification = '';
 			$valid_comp = array('Criminal Status','Court Record','Document Check','Drug Test','Highest Education','Previous Employment','Previous Address','Reference','Credit / Cibil Check','Bankruptcy Check','Adverse Media/Media Database Check','Directorship Check','Global Sanctions/ AML','Health Checkup Check','Previous Landlord Reference Check','Covid-19 Check','Civil Check');
 			if (!in_array($value['component_name'],$valid_comp)) {
 				$insuff_rem = isset($componetStatus['insuff_remarks'])?$componetStatus['insuff_remarks']:'-';
 				$insuff_closure = isset($componetStatus['insuff_closure_remarks'])?$componetStatus['insuff_closure_remarks']:'-';
 				$verification = isset($componetStatus['verification_remarks'])?$componetStatus['verification_remarks']:'-';
 				$insuff_created_date = explode(',',isset($componetStatus['insuff_created_date'])?$componetStatus['insuff_created_date']:'-');
 			}else{
 				$insuff_remarks = json_decode(isset($componetStatus['insuff_remarks'])?$componetStatus['insuff_remarks']:'-',true);
 				$insuff_closure_remarks = json_decode(isset($componetStatus['insuff_closure_remarks'])?$componetStatus['insuff_closure_remarks']:'-',true);
 				$verification_remarks = json_decode(isset($componetStatus['verification_remarks'])?$componetStatus['verification_remarks']:'-',true);
 				$insuff_created_date = json_decode(isset($componetStatus['insuff_created_date'])?$componetStatus['insuff_created_date']:'-',true);

 			}

	 			// echo json_encode($inputQcStatus);
	 			// array_push( $case_data, $componetStatus);
	 			// exit();
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
	 				// $row['inputQcStatus'] = $inputQcStatus;
	 				$formNumber =  $inputQcStatuskey+1;

	 				$type_of_val ='';
		 			if ($results !='' && $value['component_id'] =='7') {
		 				$type_of_val = isset($results[$inputQcStatuskey]['education_type_name'])?$results[$inputQcStatuskey]['education_type_name']:'';
		 			}else if ($results !='' && ($value['component_id'] =='3' || $value['component_id'] =='27')) {
	 				$type_of_val = isset($results[$inputQcStatuskey]['document_type_name'])?$results[$inputQcStatuskey]['document_type_name']:'';
	 			}
		 			$row['value_type'] = $type_of_val;
		 			$last = isset($team['last_name'])?$team['last_name']:'-';
	 				$row['csm'] = isset($team['first_name'])?$team['first_name']:'-'.' '.$last;
	 				$row['formNumber'] = $formNumber;
	 				$row['position'] = $inputQcStatuskey;
		 			$row['component_id'] = $value['component_id']; 
		 			$row['component_name'] = $value['component_name']; 
		 			$row['client_id'] = $result['client_id']; 
		 			$row['client_name'] = $result['client_name']; 
		 			$row['candidate_id'] = $result['candidate_id']; 
		 			$row['title'] = $result['title']; 
		 			$row['candidate_name'] = $result['first_name'].' '.$result['last_name']; 
		 			$row['first_name'] = $result['first_name']; 
		 			$row['last_name'] = $result['last_name']; 
		 			$row['father_name'] = $result['father_name']; 
		 			$row['phone_number'] = $result['phone_number']; 
		 			$row['email_id'] = $result['email_id']; 
		 			$row['date_of_birth'] = $result['date_of_birth']; 
		 			$row['date_of_joining'] = $result['date_of_joining']; 
		 			$row['employee_id'] = $result['employee_id']; 
		 			$row['package_name'] = $result['package_name']; 
		 			$row['remark'] = $result['remark']; 
		 			$row['spoc_name'] = isset($spoc['spoc_name'])?$spoc['spoc_name']:'-';
		 			$row['priority'] = $result['priority']; 
		 			$row['document_uploaded_by'] = $result['document_uploaded_by']; 
		 			$row['document_uploaded_by_email_id'] = $result['document_uploaded_by_email_id']; 
		 			$row['case_submitted_date'] = isset($result['case_submitted_date'])?$result['case_submitted_date']:''; 
		 			$row['created_date'] = date('Y-m-d', strtotime($result['created_date']) ); 
		 			if ($result['report_generated_date'] !=null && $result['report_generated_date'] !='') { 
	 				$row['updated_date'] = date('d-m-Y', strtotime($result['report_generated_date']) );  
		 			 } else{
		 			 	$row['updated_date'] ='NA';
		 			 }
		 			 $row['segment'] = isset($result['segment'])?$result['segment']:''; 
	 			$row['location'] = isset($result['location'])?$result['location']:''; 
		 			$row['is_submitted'] = $result['is_submitted'];
		 			$row['form_values'] = $result['form_values'];
		 			$row['client_packages_list'] = $result['client_packages_list'];
	 				$row['selected_package_id'] = $result['selected_package_id'];
	 				$row['is_report_generated'] = $result['is_report_generated'];
	 				$row['report_generated_date'] = $result['report_generated_date'];
		 			$inputQcComStatus = $this->stringExplode(isset($componetStatus['status'])?$componetStatus['status']:'');
		 			// echo "inputQcComStatus:".$componetStatus['status']."<br>"; 
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

		 			$row['insuff_created_date'] = isset($insuff_created_date[$inputQcStatuskey])?$insuff_created_date[$inputQcStatuskey]:'-';
		 			$assigned_role = $this->stringExplode(isset($componetStatus['assigned_role'])?$componetStatus['assigned_role']:'Role');
		 			$row['assigned_role'] = isset($assigned_role[$inputQcStatuskey])?$assigned_role[$inputQcStatuskey]:'0';
		 			$assigned_team_id = $this->stringExplode(isset($componetStatus['assigned_team_id'])?$componetStatus['assigned_team_id']:'0');
		 			$row['assigned_team_id'] = isset($assigned_team_id[$inputQcStatuskey])?$assigned_team_id[$inputQcStatuskey]:'0';

		 			$assigned_team = $this->getTeamEmpData(isset($assigned_team_id[$inputQcStatuskey])?$assigned_team_id[$inputQcStatuskey]:'0'); 
		 			$row['assigned_team_name'] = isset($assigned_team['name'])?$assigned_team['name']:'-'; 
		 			$inputq = $this->getTeamEmpData($result['assigned_inputqc_id']); 
		 			$row['inputq'] = isset($inputq['name'])?$inputq['name']:'-'; 

		 			$row['insuff_remarks'] = isset($insuff_remarks[$inputQcStatuskey]['insuff_remarks'])?$insuff_remarks[$inputQcStatuskey]['insuff_remarks']:$insuff_rem;
	 			$row['insuff_closure_remarks'] = isset($insuff_closure_remarks[$inputQcStatuskey]['insuff_closure_remarks'])?$insuff_closure_remarks[$inputQcStatuskey]['insuff_closure_remarks']:$insuff_closure;
	 			$row['verification_remarks'] = isset($verification_remarks[$inputQcStatuskey]['verification_remarks'])?$verification_remarks[$inputQcStatuskey]['verification_remarks']:$verification;
	 			$in_pro = isset($progress_remarks[$inputQcStatuskey]['in_progress_remarks'])?$progress_remarks[$inputQcStatuskey]['in_progress_remarks']:'-';
	 			$row['progress_remarks'] = isset($progress_remarks[$inputQcStatuskey]['progress_remarks'])?$progress_remarks[$inputQcStatuskey]['progress_remarks']:$in_pro;

		 			array_push(	$case_data, $row);  
	 			}
 			// }
 			
 			
 			
 		}
 		// echo json_encode($case_data);
 		return $case_data;
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


		$result = $this->db->select($table_name.'.status,'.$table_name.'.assigned_team_id,'.$table_name.'.insuff_remarks,'.$table_name.'.verification_remarks,'.$table_name.'.insuff_created_date,'.$table_name.'.analyst_status,'.$table_name.'.output_status,'.$table_name.'.analyst_status,'.$table_name.'.insuff_team_role,'.$table_name.'.insuff_team_id,'.$table_name.'.assigned_role,
		 	team_employee.first_name,team_employee.first_name,team_employee.last_name,team_employee.contact_no')->where('candidate_id',$candidate_id)->join('team_employee','team_employee.team_id = '.$table_name.'.assigned_team_id','left')->get($table_name)->row_array();

		 





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
		 					 

		 					$father_name = json_decode($subValues['father_name'],true);
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





 	function insert_case_api(){ 

 		$duplicate = $this->db->where('phone_number',$this->input->post('user_contact'))->get('candidate')->num_rows();
 		if ($duplicate > 0) {
 			return array('status'=>'102','msg'=>'Duplicate Mobile Number.');
 		}
		 
		$user = $this->get_single_client_data($this->input->post('client_id'));
		// echo $this->isInputQcExits()."||";
		if($this->isInputQcExits() == 1){
			$team_id = $this->getMinimumTaskHandlerInputQC();
		}else{
			return array('status'=>'2','msg'=>'Please, Enter first InputQC Or Team member.','email_status'=>'0','smsStatus'=>'0');
		}

		// exit();
		/*$team_id = $this->db->query("SELECT * FROM `team_employee` LEFT JOIN candidate ON team_employee.team_id = candidate.assigned_inputqc_id WHERE team_employee.role='inputqc' ORDER BY candidate.assigned_inputqc_id ASC")->row_array();
*/			
		$login_otp = $this->rendomNumber(4);
		$ids = explode(',', $this->input->post('skills'));
		$component  = array_unique($ids);
		asort($component);

		$client_email_id = strtolower($this->input->post('email'));
		// Send To User Starts
		$client_email_subject = 'Candidate Verification Form';
		$email_message ='';
		$email_message .= '<html> ';
		$email_message .= '<head>';
		$email_message .= '<style>';
		$email_message .= 'table {';
		$email_message .= 'font-family: arial, sans-serif;';
		$email_message .= 'border-collapse: collapse;';
		$email_message .= 'width: 100%;';
		$email_message .= '}';

		$email_message .= 'td, th {';
		$email_message .= 'border: 1px solid #dddddd;';
		$email_message .= 'text-align: left;';
		$email_message .= 'padding: 8px;';
		$email_message .= '}';

		$email_message .= 'tr:nth-child(even) {';
		$email_message .= 'background-color: #dddddd;';
		$email_message .= '}';
		$email_message .= '</style>';
		$email_message .= '</head>';
		$email_message .= '<body> ';
		$email_message .= "<p>Dear ".$this->input->post('first_name')." ".$this->input->post('last_name')."</p>";
		$email_message .= '<p>Greetings from Factsuite!!</p>';
		$email_message .= '<p>'.$user['client_name'].' has partnered with Factsuite to conduct Employment Background Screening of prospective employees.</p>';
		$email_message .= '<p>To proceed with this activity, we request you to provide relevant details of your profile, as requested on the Factsuite CRM application.</p>';
		$email_message .= '<p>Please find your Login Credentials mentioned below-</p>';
		$email_message .= '<table>';
		$email_message .= '<th>CRM Link</th>';
		$email_message .= '<th>Mobile Number</th>';
		$email_message .= '<th>OTP</th>';
		$email_message .= '<tr>';
		$email_message .= '<td>'.$this->config->item('candidate_url').'</td>';
		$email_message .= '<td>'.$this->input->post('user_contact').'</td>';
		$email_message .= '<td>-</td>';//http://localhost:8080/factsuitecrm/
		$email_message .= '<tr>';
		$email_message .= '</table>';
		$email_message .= '<p><b>Note:</b> Kindly update the information requested as accurately as possible and upload the supporting documents where necessary, to enable us to conduct a hassle-free screening of your profile.</p>';
		$email_message .= '<p><b>Yours sincerely,<br>';
		$email_message .= 'Team FactSuite</b></p>';
		$email_message .= '</body>';
		$email_message .= '</html>';

		$notification = array('admin'=>'0','inputQc'=>'0','client'=>'1','outPutQc'=>'0');
		$notification = json_encode($notification);
		$case_data = array(
			'client_id' =>$user['client_id'],
			'title' => $this->input->post('title'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'father_name' => $this->input->post('father_name'),
			'phone_number' => $this->input->post('user_contact'),
			'package_name' => $this->input->post('package'),
			'document_uploaded_by' => $this->input->post('document_uploader'),
			'date_of_birth' => $this->input->post('birthdate'),
			'date_of_joining' => $this->input->post('joining_date'),
			'employee_id' => $this->input->post('employee_id'),
			'remark' => $this->input->post('remark'),
			'email_id' => $this->input->post('email'),
			'component_ids' => implode(',', $component),
			'document_uploaded_by_email_id' => $this->input->post('client_email'),
			'case_added_by_id'=>$user['client_id'],
			'case_added_by_role'=>'client',
			'assigned_inputqc_id'=>$team_id,
			'form_values'=>json_encode($this->input->post('form_values')),
			'alacarte_components'=>$this->input->post('alacarte_components'),
			'package_components' => $this->input->post('package_component'),
			'otp_password'=>$login_otp,
			'new_case_added_notification'=> $notification
		);
		if($this->isInputQcExits() == 1){
			if ($this->db->insert('candidate',$case_data)) {

				$txtSmsStatus = '0';
				$smsStatus = $this->send_sms($this->input->post('first_name'),$user['client_name'],$this->input->post('user_contact'),$login_otp,'1');
				if($smsStatus == "200"){
					$txtSmsStatus = '1';
				}else{
					$txtSmsStatus = '0';

				}

				// $send_email_to_user = $this->emailModel->send_mail($client_email_id,$client_email_subject,$email_message);
				$email_status = '0'; 
				if($this->emailModel->send_mail($client_email_id,$client_email_subject,$email_message)){
					$email_status = '1';	 
				}else{
					$email_status = '0'; 
				}
				$candidate_insert_id = $this->db->where('phone_number',$this->input->post('user_contact'))->get('candidate')->row_array();
				$insert_id = $candidate_insert_id['candidate_id'];
				$case_log_data = array(
					'candidate_id' =>$insert_id,
					'client_id' =>$user['client_id'],
					'title' => $this->input->post('title'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'father_name' => $this->input->post('father_name'),
					'phone_number' => $this->input->post('user_contact'),
					'package_name' => $this->input->post('package'),
					'document_uploaded_by' => $this->input->post('document_uploader'),
					'date_of_birth' => $this->input->post('birthdate'),
					'date_of_joining' => $this->input->post('joining_date'),
					'employee_id' => $this->input->post('employee_id'),
					'remark' => $this->input->post('remark'),
					'email_id' => $this->input->post('email'),
					'component_ids' => implode(',', $component),
					'document_uploaded_by_email_id' => $this->input->post('client_email'),
					'case_added_by_id'=>$user['client_id'],
					'case_added_by_role'=>'client',
					'assigned_inputqc_id'=>$team_id,
					'alacarte_components'=>$this->input->post('alacarte_components'),
					'form_values'=>json_encode($this->input->post('form_values')),
					'package_components' => $this->input->post('package_component'),
					'otp_password'=>$login_otp,
					'new_case_added_notification'=> $notification
				);
			$this->db->insert('candidate_log',$case_log_data);
				return array('status'=>'1','msg'=>'success','email_status'=>$email_status,'smsStatus'=>$txtSmsStatus,'candidate_id' =>$insert_id);
			}else{
				return array('status'=>'201','msg'=>'faliled','email_status'=>$email_status,'smsStatus'=>$txtSmsStatus);
			}
		}else{
			return array('status'=>'202','msg'=>'Please, Enter first InputQC Or Team member.','email_status'=>'0','smsStatus'=>'0');
		}
	}


	function update_case_api(){ 
		$duplicate = $this->db->where('phone_number',$this->input->post('user_contact'))->where('candidate_id !=',$this->input->post('candidate_id'))->get('candidate')->num_rows();
 		if ($duplicate > 0) {
 			return array('status'=>'102','msg'=>'Duplicate Mobile Number.');
 		}

		$user = $this->get_single_client_data($this->input->post('client_id'));
		if($this->isInputQcExits() == 1){
			$team_id = $this->getMinimumTaskHandlerInputQC();
		}else{
			return array('status'=>'201','msg'=>'Please, Enter first InputQC Or Team member.','email_status'=>'0','smsStatus'=>'0');
		}
		/*$team_id = $this->db->query("SELECT * FROM `team_employee` LEFT JOIN candidate ON team_employee.team_id = candidate.assigned_inputqc_id WHERE team_employee.role='inputqc' ORDER BY candidate.assigned_inputqc_id ASC")->row_array();

*/		
		$candidat = $this->db->where('candidate_id',$this->input->post('candidate_id'))->get('candidate')->row_array(); 

		$ids = explode(',', $this->input->post('skills'));
		$component_ids = explode(',', $candidat['component_ids']);


		$component  = array_unique($ids);
		asort($component);
		$case_data = array(
			'client_id' =>$user['client_id'],
			'title' => $this->input->post('title'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'father_name' => $this->input->post('father_name'),
			'phone_number' => $this->input->post('user_contact'),
			'package_name' => $this->input->post('package'),
			'document_uploaded_by' => $this->input->post('document_uploader'),
			'date_of_birth' => $this->input->post('birthdate'),
			'date_of_joining' => $this->input->post('joining_date'),
			'employee_id' => $this->input->post('employee_id'),
			'remark' => $this->input->post('remark'),
			'email_id' => $this->input->post('email'),
			'component_ids' => implode(',', $component),
			'document_uploaded_by_email_id' => $this->input->post('client_email'),
			'case_added_by_id'=>$user['client_id'],
			'case_added_by_role'=>'client',
			'assigned_inputqc_id'=>$team_id,
			'alacarte_components'=>$this->input->post('alacarte_components'),
			'form_values'=>json_encode($this->input->post('form_values')),
			'package_components' => $this->input->post('package_component'),

		);

		// if (count($component) < count($component_ids)) {
			$case_data['is_submitted'] = 0;
		// }

		$client_email_id = strtolower($this->input->post('email'));
				// Send To User Starts
				$client_email_subject = 'Candidate Verification Form';

				/*$client_email_message = '<html><body>';
				$client_email_message .= 'Hello : '.$this->input->post('first_name').'<br>';
				$client_email_message .= "You will be receiving an SMS/Email to complete your address verification as part of the Background Verification process initiated by <b>{$this->input->post('first_name')}</b>. Kindly click on the link to complete the task.";
				$client_email_message .= 'Thank You,<br>';
				$client_email_message .= 'Team Factsuite';
				$client_email_message .= '</html></body>';*/

				$email_message ='';
				$email_message .= '<html> ';
				$email_message .= '<head>';
				$email_message .= '<style>';
				$email_message .= 'table {';
				$email_message .= 'font-family: arial, sans-serif;';
				$email_message .= 'border-collapse: collapse;';
				$email_message .= 'width: 100%;';
				$email_message .= '}';

				$email_message .= 'td, th {';
				$email_message .= 'border: 1px solid #dddddd;';
				$email_message .= 'text-align: left;';
				$email_message .= 'padding: 8px;';
				$email_message .= '}';

				$email_message .= 'tr:nth-child(even) {';
				$email_message .= 'background-color: #dddddd;';
				$email_message .= '}';
				$email_message .= '</style>';
				$email_message .= '</head>';
				$email_message .= '<body> ';
				$email_message .= "<p>Dear ".$this->input->post('first_name')." ".$this->input->post('last_name')."</p>";
				$email_message .= '<p>Greetings from Factsuite!!</p>';
				$email_message .= '<p>'.ucwords($user['client_name']).' has partnered with Factsuite to conduct Employment Background Screening of prospective employees.</p>';
				$email_message .= '<p>To proceed with this activity, we request you to provide relevant details of your profile, as requested on the Factsuite CRM application.</p>';
				$email_message .= '<p>Please find your Login Credentials mentioned below-</p>';
				$email_message .= '<table>';
				$email_message .= '<th>CRM Link</th>';
				$email_message .= '<th>Mobile Number</th>';
				$email_message .= '<th>OTP</th>';
				$email_message .= '<tr>';
				$email_message .= '<td>'.$this->config->item('candidate_url').'</td>';
				$email_message .= '<td>'.$this->input->post('user_contact').'</td>';
				$email_message .= '<td>-</td>';//http://localhost:8080/factsuitecrm/
				$email_message .= '<tr>';
				$email_message .= '</table>';
				$email_message .= '<p><b>Note:</b> Kindly update the information requested as accurately as possible and upload the supporting documents where necessary, to enable us to conduct a hassle-free screening of your profile.</p>';
				$email_message .= '<p><b>Yours sincerely,<br>';
				$email_message .= 'Team FactSuite</b></p>';
				$email_message .= '</body>';
				$email_message .= '</html>';

				$send_email_to_user = $this->emailModel->send_mail($client_email_id,$client_email_subject,$email_message);
		$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('candidate',$case_data)) {
			$insert_id = $this->input->post('candidate_id');
		$case_log_data = array(
			'candidate_id' =>$insert_id,
			'client_id' =>$user['client_id'],
			'title' => $this->input->post('title'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'father_name' => $this->input->post('father_name'),
			'phone_number' => $this->input->post('user_contact'),
			'package_name' => $this->input->post('package'),
			'document_uploaded_by' => $this->input->post('document_uploader'),
			'date_of_birth' => $this->input->post('birthdate'),
			'date_of_joining' => $this->input->post('joining_date'),
			'employee_id' => $this->input->post('employee_id'),
			'remark' => $this->input->post('remark'),
			'email_id' => $this->input->post('email'),
			'component_ids' => implode(',', $component),
			'document_uploaded_by_email_id' => $this->input->post('client_email'),
			'case_added_by_id'=>$user['client_id'],
			'case_added_by_role'=>'client',
			'assigned_inputqc_id'=>$team_id,
			'alacarte_components'=>$this->input->post('alacarte_components'),
			'form_values'=>json_encode($this->input->post('form_values')),
			'package_components' => $this->input->post('package_component'),
		);
		$this->db->insert('candidate_log',$case_log_data);
			return array('status'=>'200','msg'=>'successfully candidate updated');
		}else{
			return array('status'=>'202','msg'=>'faliled');
		}
	}

	function remove_case_api(){

		$case_data = array(
			'candidate_status'=>0
		);

		$where = array(
			'candidate_id' => $this->input->post('candidate_id'),
			'client_id' => $this->input->post('client_id'),
		); 

		if ($this->db->where($where)->update('candidate',$case_data)) { 
			return array('status'=>'200','msg'=>'successfully candidate removed case');
		}else{
			return array('status'=>'202','msg'=>'faliled to remove candidate case');
		}	
	}

	function verify_valid_candidate(){
		$where = array(
			'candidate_id' => $this->input->post('candidate_id'),
			'client_id' => $this->input->post('client_id'),
		);
		if ($this->db->where($where)->get('candidate')->num_rows()) { 
			return array('status'=>'200','msg'=>'is valid candidate case');
		}else{
			return array('status'=>'202','msg'=>'not valid');
		}
	}

	function update_candidate_case_priority(){ 
		$client = $this->db->where('client_id',$this->input->post('client_id'))->where('candidate_id',$this->input->post('candidate_id'))->get('candidate')->num_rows();
 		if ($client == 0) {
 			return array('status'=>'402','msg'=>'Invalid requested data.');
 		}
 		$priority = 0;
 		$p = strtolower($this->input->post('priority'));
 		if ($p =='medium') {
 			$priority = 1;
 		}else if ($p =='high') {
 			$priority = 2;
 		} 
		 
		$case_data = array( 
			'priority'=>$priority,
			'priority_change_by_role'=>'client',
			'priority_change_by_id'=>$this->input->post('client_id')
		);
 
		$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('candidate',$case_data)) { 
			return array('status'=>'200','msg'=>'successfully candidate change priority');
		}else{
			return array('status'=>'202','msg'=>'faliled');
		}
	}



	function get_all_service_packages() { 
		$where_condition = array(
			'service_id' => $this->input->post('package_for'),
			'status' => 1
		);
		return $this->db->select('package_id AS id, T1.*')->where($where_condition)->order_by('package_order','ASC')->get('main_website_service_package AS T1')->result_array();
	}


	function get_single_client_details($client_id){
		return $this->db->where('client_id',$client_id)->get('tbl_client')->row_array(); 
	}


	function get_single_component_name($package_id){
		$result = $this->db->where('package_status',1)->where('package_id',$package_id)->get('packages')->result_array();
		$component_names = array(); 
		foreach ($result as $value) {
			$comp_name = array();
			$fs_comp_name = array();
			$row['package_name'] = $value['package_name'];
			$row['package_id'] = $value['package_id'];
			$row['package_status'] = $value['package_status'];
			$component_ids = explode(',', $value['component_ids']);
			$component = $this->db->where_in('component_id',$component_ids)->get('components')->result_array();
			foreach ($component as $key1 => $com) {
				array_push($comp_name, $com['component_name']);
				array_push($fs_comp_name, $com['fs_website_component_name']);
			}
			$row['component_ids'] = $value['component_ids'];
			$row['component_ids_array'] = $component_ids;
			$row['component_name'] =  implode(',',$comp_name);
			$row['fs_website_component_name'] =  implode(',',$fs_comp_name);
			array_push($component_names, $row);
		}
		
		$education_type = $this->db->where('status',1)->get('education_type')->result_array();
		$document_type = $this->db->where('status',1)->get('document_type')->result_array();
		$drug_test_type = $this->db->where('status',1)->get('drug_test_type')->result_array();

		$data['education_type']= $education_type;
		$data['documetn_type']= $document_type;
		$data['drug_test_type']= $drug_test_type;
		array_push($component_names, $data);
		return $component_names;
	}

	function get_component_details($component_id=''){
		$result ='';
		if ($component_id !='') { 
			$result = $this->db->where('component_id',$component_id)->where('component_status',1)->get('components')->row_array();
		}else{
			$result = $this->db->where('component_status',1)->get('components')->result_array();
		}
		return $result;
	}


	function add_client_packages(){ 
		$package_data = array(
			'package_name'=>$this->input->post('package_name'),
			'component_ids'=>$this->input->post('component_ids')
			 
		);


		if ($this->db->insert('packages',$package_data)) {
			$insert_id = $this->db->insert_id();
			$components_log_data = array(
				'package_id'=>$insert_id,
				'package_name'=>$this->input->post('package_name'),
				'component_ids'=>$this->input->post('component_ids')
				 
			);
			$this->db->insert('packages_log',$components_log_data);
			return array('status'=>'200','msg'=>'success','package_id'=>$insert_id);
		}else{
			return array('status'=>'201','msg'=>'failled');
		}
	}


	function remove_client_package(){ 
		$package_data = array( 
			'package_status'=>'0'  
		); 
		if ($this->db->where('package_id',$this->input->post('package_id'))->update('packages',$package_data)) { 
			return array('status'=>'200','msg'=>'success');
		}else{
			return array('status'=>'201','msg'=>'failled');
		}
	}


	function get_access_token(){
		$client = $this->get_single_client_details($this->input->post('client_id'));
		if ($client !='' && $client !=null) {
			if (trim(strtolower($client['client_name'])) != trim(strtolower($this->input->post('client_name')))) {
				return array('status'=>'401','msg'=>'Invalid Client Name');	
			}
			if ($client['access_token'] !='' && $client['access_token'] !=null) {
			 	$token = $client['access_token'];
			 }else{
			 	$token = md5($this->input->post('client_name')).openssl_random_pseudo_bytes(50).md5(date('dmYHis'));
				$token = bin2hex($token);
			 	$client_data = array( 
			 		'access_token'=>$token,
			 	);
				$this->db->where('client_id',$this->input->post('client_id'))->update('tbl_client',$client_data);
			 } 
			 return array(
			 		'status'=>'200',
			 		'client_id'=>$client['client_id'],
			 		'client_name'=>$client['client_name'],
			 		'access_token'=>$token,
			 	);
		}else{
			return array('status'=>'402','msg'=>'Invalid client request');	
		}
	}

	function valid_access_token($token){
		$where = array(
			'client_id'=>$this->input->post('client_id'),
			'access_token'=>$token,
		);
		return $this->db->where($where)->get('tbl_client')->num_rows(); 
	}


	/// 

	function init_client_billing_payment(){ 
		$finance = $this->db->where('client_id',$this->input->post('client_id'))->get('finance_tbl')->row_array();
		$price = $this->input->post('pricing');
		if (!is_array($this->input->post('pricing'))) {
			$price = explode(',', $this->input->post('pricing'));
		}
		$open_amount = $this->input->post('open_amount');
		$status = 1;
		if(isset($finance['open_amount'])){
			$open_amount = $finance['open_amount'] - $finance['open_amount'];
			if ($open_amount > 0) {
				$status = 1;
				if ($open_amount == $this->input->post('amount_paid')) {
					$status = 2;
				}
			}else{
				$status = 3;
			}
		} 

		if ($open_amount == $this->input->post('amount_paid')) {
			$status = 2;
		}
		$payment_data = array(
			'open_amount'=>$open_amount,
			'amount_paid'=>$this->input->post('amount_paid'),
			'client_id'=>$this->input->post('client_id'),
			'components'=>$this->input->post('components'),
			'description'=>$this->input->post('description'),  
			'total_amount'=>array_sum($price),  
			'pricing'=>$this->input->post('pricing'),  
			'payment_status'=>$status,  
		);
 
		if ($this->db->insert('finance_tbl',$payment_data)) {
			 
			return array('status'=>'200','msg'=>'success');
		}else{
			return array('status'=>'201','msg'=>'failled');
		}
	}


	function get_client_billing_payment(){

		$where = array(
			'client_id'=>$this->input->post('client_id')
		);
		$result = $this->db->where($where)->get('finance_tbl')->result_array();
		if (count($result) == 0) {
		 	$payment_data = array(
			'open_amount'=>500,
			'amount_paid'=>0,
			'client_id'=>$this->input->post('client_id'),
			'components'=>'1,2',
			'description'=>'testing',  
			'total_amount'=>500,  
			'pricing'=>'200,300',  
			'payment_status'=>1,  
		);
  	$this->db->insert('finance_tbl',$payment_data); 
  }
  	return $this->db->where($where)->get('finance_tbl')->result_array();
	}

	function get_client_billing_payment_transactions(){

		$where = array(
			'client_id'=>$this->input->post('client_id')
		);
		$result = $this->db->where($where)->get('finance_tbl')->result_array();
		$transactions_data = array();

		foreach ($result as $key => $value) {
		 	$row['id'] = $value['id'];
		 	$row['client_id'] = $value['client_id'];
		 	$row['balance'] = $value['due_amount'];
		 	$row['payment'] = $value['total_amount'];
		 	$row['description'] = $value['description'];
		 	$row['date_time'] = $value['created_at']; 
		 	array_push($transactions_data,$row);
		 } 

		 return $transactions_data;
	}


	function clear_notification($id){
		$clear_notify = array(
			'finance_notify'=>2
		);
		$this->db->where('summary_id',$id)->update('finance_summary',$clear_notify);
	}

	function upload_bulk_cases($bulk_case){
		$user = $this->session->userdata('logged-in-client');
			$client_id = $user['client_id'];
		$bulk_case = array(
			'bulk_files'=>implode(',', $bulk_case),
			'number_of_candidate'=>$this->input->post('number_of_candidate'),
			'client_remarks'=>$this->input->post('remarks'),
			'uploaded_by'=>$client_id,
		);
		if ($this->db->insert('client_bulk_uploads',$bulk_case)) { 
			return array('status'=>'200','msg'=>'success');
		}else{
			return array('status'=>'201','msg'=>'failled');
		}
	}



}