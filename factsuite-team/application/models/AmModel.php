<?php
/** 
 * 12-03-2021	
 */
class AmModel extends CI_Model
{

	function caseList($id='1'){
		// "SELECT team_employee.team_id,candidate.* FROM `team_employee` RIGHT JOIN candidate ON team_employee.team_id = candidate.assigned_inputqc_id WHERE reporting_manager = ".$id;
		if ($this->session->userdata('logged-in-csm')) {
			$team_component = $this->session->userdata('logged-in-csm');
			$this->db->where('tbl_client.account_manager_name',$team_component['team_id']);
		}
		$caseListData = $this->db->select('team_employee.team_id,team_employee.first_name as team_first_name,team_employee.last_name as team_last_name ,candidate.*,tbl_client.client_name,packages.package_name')->from('team_employee')->join('candidate','team_employee.team_id = candidate.assigned_inputqc_id','right')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->order_by('priority DESC, candidate_id DESC')->get()->result_array();

		return $caseListData;
	}


	function componentList($component_ids = '4,5,6,7,8,9,10,11,12',$candidate_id = '2'){
		$component_ids = explode(',', $component_ids);
		$rowData = []; 
		foreach ($component_ids as $key => $value) {
			$tablename = $this->analystModel->getComponentName($value);
			$componentData = $this->db->where('candidate_id',$candidate_id)->get($tablename)->row_array();
			$rowData[$tablename] = $componentData ;
		}
			
		return $rowData;
	}

	function getSingleAssignedCaseDetails($candidate_id) {
		// $result=array_intersect($a1,$a2);
 		$result = $this->db->where('candidate_id',$candidate_id)->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->row_array();

 		$component_id = explode(',', $result['component_ids']);

 		$userData = $this->session->userdata('logged-in-am');

 		$common_component_ids = array_intersect(explode(',', $userData['skills']),$component_id);

 		// echo "<br>skills: ";
 		// print_r(explode(',', $userData['skills']));
 		// echo "<br>component_id: ";
 		// print_r($component_id);
 		// echo "<br>common_component_ids: ";
 		// print_r($common_component_ids); 
 		// exit();
 		$component = $this->db->where_in('component_id',$common_component_ids)->get('components')->result_array();

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
 			$row['country_code'] = isset($result['country_code'])?$result['country_code']:'+91';
		 			$row['phone_number'] = $result['phone_number'];
 			$row['email_id'] = $result['email_id']; 
 			$row['date_of_birth'] = $result['date_of_birth']; 
 			$row['date_of_joining'] = $result['date_of_joining']; 
 			$row['employee_id'] = $result['employee_id']; 
 			$row['package_name'] = $result['package_name']; 
 			$row['remark'] = $result['remark']; 
 			$row['document_uploaded_by'] = $result['document_uploaded_by']; 
 			$row['document_uploaded_by_email_id'] = $result['document_uploaded_by_email_id']; 
 			$row['created_date'] = date('d-m-Y', strtotime($result['created_date']) );  
 			$row['is_submitted'] = $result['is_submitted'];  
 			$row['priority'] = $result['priority'];  
 			$row['aaddhar_doc'] = $result['aaddhar_doc'];
 			$row['pancard_doc'] = $result['pancard_doc'];
 			$row['idproof_doc'] = $result['idproof_doc'];
 			$row['bankpassbook_doc'] = $result['bankpassbook_doc'];
 			$row['component_data'] = $this->getStatusFromComponent($result['candidate_id'],$value['component_id']);
 			array_push($case_data, $row);
 		}

 		// print_r($case_data);
 		// exit();
 		return $case_data;
	}
 

	function priorityUpdate(){
		$candidate_id = $this->input->post('candidate_id');
		$priority_value = $this->input->post('priority_value');
		$priority_change_by_role = $this->input->post('role'); 
		$team_id =$this->input->post('team_id');

		$priority_data = array(
			
				'priority'=>$priority_value,
				'updated_date'=>date('d-m-Y H:i:s'),
				'priority_change_by_role'=> $priority_change_by_role, 
				'priority_change_by_id'=> $team_id
			);
		// print_r($priority_data);
		// exit();
		$this->db->where('candidate_id',$candidate_id);
		if ($this->db->update('candidate',$priority_data)) {
			// $insert_id = $this->db->insert_id();
			$priority_data_log = array(
					'candidate_id' => $candidate_id,
					'priority'=>$priority_value,
					'updated_date'=>date('d-m-Y H:i:s'),
					'priority_change_by_role'=> $priority_change_by_role, 
					'priority_change_by_id'=> $team_id
			);

			if($this->db->insert('candidate_log',$priority_data_log)){
				return array('status'=>'1','msg'=>'success','logStatus'=>'1');
			}else{
				return array('status'=>'1','msg'=>'success','logStatus'=>'0');
			} 
		}else{
			return array('status'=>'0','msg'=>'failled','logStatus'=>'0');
		}
	}


	function override_team(){
		$candidate_id = $this->input->post('candidate_id');
		$component_id = $this->input->post('component_id');		 
		$postion = $this->input->post('postion');
		$team_id = $this->input->post('team_id');
		$component_name = $this->utilModel->getComponent_or_PageName($component_id);
		// $componentIds = ['5','6','8','9','16','20','21','22'];

		$old_component_data = $this->db->where('candidate_id',$candidate_id)->get($component_name)->row_array();
		$team_data = $this->db->where('team_id',$team_id)->get('team_employee')->row_array();
		if($old_component_data != null){
			$old_assigned_role = explode(',',$old_component_data['assigned_role']);
			$old_assigned_team_id = explode(',',$old_component_data['assigned_team_id']);
			$old_re_assigned_date = explode(',',$old_component_data['re_assigned_date']);

			$new_component_data = array(
				'assigned_role' => $this->analystModel->changeVlaueThroughIndex($old_assigned_role,$postion,$team_data['role']),
				'assigned_team_id' => $this->analystModel->changeVlaueThroughIndex($old_assigned_team_id,$postion,$team_id),
				're_assigned_date' =>$this->analystModel->changeVlaueThroughIndex($old_re_assigned_date,$postion,date('d-m-Y h:i:s'))
			);
			$this->db->where('candidate_id',$candidate_id);
			if ($this->db->update($component_name,$new_component_data)) {
				$component_data = $this->db->where('candidate_id',$candidate_id)->get($component_name)->row_array();
				if($this->db->insert($component_name.'_log',$component_data)){
					$name = $team_data['first_name'].' '.$team_data['last_name'];
					return array('status'=>'1','msg'=>'success','logStatus'=>'1','name'=>$name);
				}else{
					return array('status'=>'1','msg'=>'success','logStatus'=>'0');
				} 
			}else{
				return array('status'=>'0','msg'=>'failled','logStatus'=>'0');
			}
			// if(!in_array($component_id, $componentIds)){				 
				
			// }else{

			// }

		}else{
			return array('status'=>'0','msg'=>'failled','logStatus'=>'0');
		} 
	}

	function insuff_override_team(){
		$candidate_id = $this->input->post('candidate_id');
		$component_id = $this->input->post('component_id');		 
		$postion = $this->input->post('postion');
		$team_id = $this->input->post('team_id');
		$component_name = $this->utilModel->getComponent_or_PageName($component_id);
		// $componentIds = ['5','6','8','9','16','20','21','22'];

		$old_component_data = $this->db->where('candidate_id',$candidate_id)->get($component_name)->row_array();
		$team_data = $this->db->where('team_id',$team_id)->get('team_employee')->row_array();
		if($old_component_data != null){
			$old_insuff_assigned_role = explode(',',$old_component_data['insuff_team_role']);
			$old_insuff_assigned_team_id = explode(',',$old_component_data['insuff_team_id']);
			$old_insuff_re_assigned_date = explode(',',$old_component_data['insuff_re_assigned_date']);

			$new_component_data = array(
				'insuff_team_role' => $this->analystModel->changeVlaueThroughIndex($old_insuff_assigned_role,$postion,$team_data['role']),
				'insuff_team_id' => $this->analystModel->changeVlaueThroughIndex($old_insuff_assigned_team_id,$postion,$team_id),
				'insuff_re_assigned_date' =>$this->analystModel->changeVlaueThroughIndex($old_insuff_re_assigned_date,$postion,date('d-m-Y h:i:s'))
			);
			$this->db->where('candidate_id',$candidate_id);
			if ($this->db->update($component_name,$new_component_data)) {
				$component_data = $this->db->where('candidate_id',$candidate_id)->get($component_name)->row_array();
				if($this->db->insert($component_name.'_log',$component_data)){
					$name = $team_data['first_name'].' '.$team_data['last_name'];
					return array('status'=>'1','msg'=>'success','logStatus'=>'1','name'=>$name);
				}else{
					return array('status'=>'1','msg'=>'success','logStatus'=>'0');
				} 
			}else{
				return array('status'=>'0','msg'=>'failled','logStatus'=>'0');
			}
			// if(!in_array($component_id, $componentIds)){				 
				
			// }else{

			// }

		}else{
			return array('status'=>'0','msg'=>'failled','logStatus'=>'0');
		} 
	}



	function getmultiAssignedCaseDetails($candidate_id) {
		
 		$result_array = $this->db->where_in('candidate_id',$candidate_id)->select("candidate.*,tbl_client.client_name,packages.package_name,tbl_client.account_manager_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->result_array();
 		 $case_data  = array();
 		foreach ($result_array as $key => $result) {
 		 
 		$component_id = explode(',', $result['component_ids']);
 		$component = $this->db->where_in('component_id',$component_id)->get('components')->result_array();
 		$team = $this->db->where('team_id',$result['account_manager_name'])->get('team_employee')->row_array();
 		// $componentIds = ['16','17','18','20'];
 		$form_values = json_decode($result['form_values'],true);
        $form_values = json_decode($form_values,true);
 		foreach ($component as $key => $value) {
 			// if(in_array($value['component_id'],$componentIds) != -1){
 				// echo 'key : '.$key.'<br>';
 				$componetStatus = $this->adminViewAllCaseModel->getStatusFromComponent($result['candidate_id'],$value['component_id']);
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
	 			$hr_name = json_decode(isset($componetStatus['hr_name'])?$componetStatus['hr_name']:'-',true);
	 			$company_name = json_decode(isset($componetStatus['company_name'])?$componetStatus['company_name']:'-',true);
	 			$insuff_remarks = json_decode(isset($componetStatus['insuff_remarks'])?$componetStatus['insuff_remarks']:'-',true);
	 			$verification_remarks = json_decode(isset($componetStatus['verification_remarks'])?$componetStatus['verification_remarks']:'-',true);
	 			$insuff_closure_remarks = json_decode(isset($componetStatus['insuff_closure_remarks'])?$componetStatus['insuff_closure_remarks']:'-',true); 
	 			$in_p = isset($componetStatus['in_progress_remarks'])?$componetStatus['in_progress_remarks']:'-';
	 			$progress_remarks = json_decode(isset($componetStatus['progress_remarks'])?$componetStatus['progress_remarks']:$in_p,true); 
	 			$assigned_to_vendor = json_decode(isset($componetStatus['assigned_to_vendor'])?$componetStatus['assigned_to_vendor']:'-',true); 
	 			$vendor = isset($componetStatus['assigned_to_vendor'])?$componetStatus['assigned_to_vendor']:'-';
	 			 
	 			$remarks_address = json_decode(isset($componetStatus['remarks_address'])?$componetStatus['remarks_address']:'-',true); 
	 			$remark_city = json_decode(isset($componetStatus['remark_city'])?$componetStatus['remark_city']:'-',true); 
	 			$remark_state = json_decode(isset($componetStatus['remark_state'])?$componetStatus['remark_state']:'-',true); 
	 			$remark_pin_code = json_decode(isset($componetStatus['remark_pin_code'])?$componetStatus['remark_pin_code']:'-',true); 
 
	 			
	 			$cpmpaney = isset($componetStatus['company_name'])?$componetStatus['company_name']:'-';
	 			foreach ($inputQcStatus as $inputQcStatuskey => $componentValue) {
	 				// $row['inputQcStatus'] = $inputQcStatus;
	 				// $row['demo'] = $cpmpaney; 
	 				
	 				//doc 
	 				$row['vendor'] = isset($assigned_to_vendor['assigned_to_vendor'])?$assigned_to_vendor['assigned_to_vendor']:$vendor;
	 				$row['remark_city'] = isset($remark_city['remark_city'])?$remark_city['remark_city']:'-';
	 				$row['remarks_address'] = isset($remarks_address['remarks_address'])?$remarks_address['remarks_address']:'-';
	 				$row['remark_state'] = isset($remark_state['remark_state'])?$remark_state['remark_state']:'-';
	 				$row['remark_pin_code'] = isset($remark_pin_code['remark_pin_code'])?$remark_pin_code['remark_pin_code']:'-';
	 				//
	 				$row['passport_number'] = isset($componetStatus['passport_number'])?$componetStatus['passport_number']:'-';
	 				$row['pan_number'] = isset($componetStatus['pan_number'])?$componetStatus['pan_number']:'-';
	 				$row['aadhar_number'] = isset($componetStatus['aadhar_number'])?$componetStatus['aadhar_number']:'-';
	 				$last = isset($team['last_name'])?$team['last_name']:'-';
	 				$row['csm'] = isset($team['first_name'])?$team['first_name']:'-'.' '.$last;
	 				$formNumber =  $inputQcStatuskey+1;
	 				$row['formNumber'] = $formNumber;
	 				$row['position'] = $inputQcStatuskey;
		 			$row['component_id'] = $value['component_id'];
		 			$row['component_id'] = $value['component_id'];
		 			$row['component_name'] = $value[$this->config->item('show_component_name')]; 
		 			$row['client_id'] = $result['client_id']; 
		 			$row['client_name'] = $result['client_name']; 
		 			$row['candidate_id'] = $result['candidate_id']; 
		 			$row['title'] = $result['title']; 
		 			$row['first_name'] = $result['first_name']; 
		 			$row['last_name'] = $result['last_name']; 
		 			$row['father_name'] = $result['father_name']; 
		 			$row['country_code'] = isset($result['country_code'])?$result['country_code']:'+91';
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
		 			$row['created_date'] = date('d-m-Y', strtotime($result['created_date']) );  
		 			$row['updated_date'] = date('d-m-Y', strtotime($result['updated_date']) );  
		 			$row['is_submitted'] = $result['is_submitted'];
		 			$row['form_values'] = $result['form_values'];
		 			// company hr_name hr_contact_number

		 			$hr =  isset($hr_name[$inputQcStatuskey]['hr_name'])?$hr_name[$inputQcStatuskey]['hr_name']:'-';
		 			if ($hr=='-') {
		 				$hr = isset($componetStatus['hr_name'])?$componetStatus['hr_name']:'-';
		 			}
		 			$contact_number = isset($componetStatus['hr_name'])?$componetStatus['hr_name']:'-';
		 			$row['hr_contact_number'] = isset($hr_contact_number[$inputQcStatuskey]['hr_contact_number'])?$hr_contact_number[$inputQcStatuskey]['hr_contact_number']:$contact_number; 
		 			$row['hr_name'] = $hr;
		 			$row['panel'] = isset($form_values['drug_test'][$inputQcStatuskey])?$form_values['drug_test'][$inputQcStatuskey]:'-';
		 			$row['insuff_created_date'] = isset($insuff_created_date[$inputQcStatuskey])?$insuff_created_date[$inputQcStatuskey]:'-';
		 			$row['insuff_close_date'] = isset($insuff_close_date[$inputQcStatuskey])?$insuff_close_date[$inputQcStatuskey]:'-';
		 			$row['company_name'] = isset($company_name[$inputQcStatuskey]['company_name'])?$company_name[$inputQcStatuskey]['company_name']:$cpmpaney;
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
		 			$row['insuff_remarks'] = isset($insuff_remarks[$inputQcStatuskey]['insuff_remarks'])?$insuff_remarks[$inputQcStatuskey]['insuff_remarks']:'-';
		 			$row['insuff_closure_remarks'] = isset($insuff_closure_remarks[$inputQcStatuskey]['insuff_closure_remarks'])?$insuff_closure_remarks[$inputQcStatuskey]['insuff_closure_remarks']:'-';
		 			$row['verification_remarks'] = isset($verification_remarks[$inputQcStatuskey]['verification_remarks'])?$verification_remarks[$inputQcStatuskey]['verification_remarks']:'-';
		 			$in_pro = isset($progress_remarks[$inputQcStatuskey]['in_progress_remarks'])?$progress_remarks[$inputQcStatuskey]['in_progress_remarks']:'-';
		 			$row['progress_remarks'] = isset($progress_remarks[$inputQcStatuskey]['progress_remarks'])?$progress_remarks[$inputQcStatuskey]['progress_remarks']:$in_pro;

		 			//edu
		 			$row['university_board'] = isset($university_board[$inputQcStatuskey]['university_board'])?$university_board[$inputQcStatuskey]['university_board']:'-';
		 			$row['college_school'] = isset($college_school[$inputQcStatuskey]['college_school'])?$college_school[$inputQcStatuskey]['college_school']:'-';
		 			$row['type_of_degree'] = isset($type_of_degree[$inputQcStatuskey]['type_of_degree'])?$type_of_degree[$inputQcStatuskey]['type_of_degree']:$in_pro;
		 			$row['course_start_date'] = isset($course_start_date[$inputQcStatuskey]['course_start_date'])?$course_start_date[$inputQcStatuskey]['course_start_date']:'-';
		 			$row['verifier_fee'] = isset($verifier_fee[$inputQcStatuskey]['verifier_fee'])?$verifier_fee[$inputQcStatuskey]['verifier_fee']:$in_pro;
		 			$row['verification_remarks'] = isset($verification_remarks[$inputQcStatuskey]['verification_remarks'])?$verification_remarks[$inputQcStatuskey]['verification_remarks']:'-';
		 			$row['verifier_designation'] = isset($verifier_designation[$inputQcStatuskey]['verifier_designation'])?$verifier_designation[$inputQcStatuskey]['verifier_designation']:'-';

		 			array_push(	$case_data, $row);  
	 			}
 		}
 	}
 		// echo json_encode($case_data);
 		return $case_data;
	}



	function stringExplode($string){
		return explode(',',isset($string)?$string:'0');
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


	function overrideInputQc(){
		$candidate_id = $this->input->post('candidate_id');
		$postion = $this->input->post('postion');		 
		$team_id = $this->input->post('team_id');

		$inputQcData = array(
			'assigned_inputqc_id' => $team_id ,
			're_assigned_inputqc_date' => date('d-m-Y h:i:s')
		); 

		$this->db->where('candidate_id',$candidate_id);
		if ($this->db->update('candidate',$inputQcData)) {
			$component_data = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
			if($this->db->insert('candidate_log',$component_data)){ 
				return array('status'=>'1','msg'=>'success','logStatus'=>'1');
			}else{
				return array('status'=>'1','msg'=>'success','logStatus'=>'0');
			} 
		}else{
			return array('status'=>'0','msg'=>'failled','logStatus'=>'0');
		}
	}



	function getComponentForms(){
 		 
 		$component = array();
 		$team_component = $this->session->userdata('logged-in-am');
 		foreach (explode(',', $team_component['skills']) as $key => $value) { 
 			array_push($component,$this->utilModel->getComponent_or_PageName($value));
 		}

 		// Total Data for team Id;
 		$row =array();
 		foreach ($component as $key => $component_value) {
 			$query = "SELECT * FROM ".$component_value;
 			$result = $this->db->query($query)->result_array();

 			if($this->db->query($query)->num_rows() > 0){ 
 				// array_push($row,$result); 
 				$row[$component_value] = $result; 
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
 						$analyst_status = explode(",", isset($criminal_checks_value['analyst_status'])?$criminal_checks_value['analyst_status']:'0');
 						if(($analyst_status[$assigned_team_ids_key] != '3' && $analyst_status[$assigned_team_ids_key] != '10')){

 							$criminal_checks['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$criminal_checks['component_name'] = $this->analystModel->get_component_name($criminal_checks['component_id'])[$this->config->item('show_component_name')];
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
 							$criminal_checks['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $criminal_checks);
 						}
 						
 					}
 					
 				}
 			}
 			// 2
 			if($mainKey == 'court_records'){
 				 
 				foreach ($value as $court_records_key => $court_records_value) {
 					$assigned_team_ids = explode(",",$court_records_value['assigned_team_id']); 
 					// $court_address = json_decode($court_records_value['address'],true);
 					foreach ($assigned_team_ids as $assigned_team_ids_key => $assigned_team_ids_value) {
 						$analyst_status = explode(",", isset($court_records_value['analyst_status'])?$court_records_value['analyst_status']:'0');
 						if(($analyst_status[$assigned_team_ids_key] != '3' &&$analyst_status[$assigned_team_ids_key] != '10')){

 							$court_records['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$court_records['component_name'] = $this->analystModel->get_component_name($court_records['component_id'])[$this->config->item('show_component_name')];
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
 							$court_records['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							
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
 							 
 						}
 						
 					}
 					
 				}
 			}

 			// 3
 			if($mainKey == 'document_check'){
 				foreach ($value as $court_records_key => $document_check_value) {
 					$assigned_team_id = explode(",",$document_check_value['assigned_team_id']); 
 					$analyst_status = explode(",",isset($document_check_value['analyst_status'])?$document_check_value['analyst_status']:'0');
 					foreach ($assigned_team_id as $dc_key => $assigned_team_id_value) {
 						$document_analyst_status = isset($analyst_status[$dc_key])?$analyst_status[$dc_key]:'0';
 						if( ($document_analyst_status != "3" && $document_analyst_status != '10')){
		 					$candidateInfo = $this->analystModel->getCandidateInfo($document_check_value['candidate_id']);
		 					$document_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
		 					$document_check['component_name'] = $this->analystModel->get_component_name($document_check['component_id'])[$this->config->item('show_component_name')];
		 					$document_check['candidate_id'] = $document_check_value['candidate_id'];
		 					$document_check['candidate_detail'] = $candidateInfo;
		 					$document_check['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
		 					$candidateinfo = json_decode($candidateInfo['form_values']);
		 					$candidateinfo = json_decode($candidateinfo,true);

		 					 
		 					// $getIndexNumber = array_search($candidateinfo['document_check'][$dc_key],$candidateinfo['document_check']);

		 					$status = explode(",",$document_check_value['status']); 
			 				$document_check['status'] = isset($status[$dc_key])?$status[$dc_key]:'';
			 					 
			 				
			 				$document_check['analyst_status'] = isset($analyst_status[$dc_key])?$analyst_status[$dc_key]:'0';

			 				$insuff_status = explode(",",$document_check_value['insuff_status']);
			 				$document_check['insuff_status'] = isset($insuff_status[$dc_key])?$insuff_status[$dc_key]:'';

			 				$document_check['updated_date'] = $document_check_value['updated_date'];

			 				$document_check['index'] = $dc_key;	
			 				array_push($final_data, $document_check);
			 			}
	 					 
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
 					$analyst_status = explode(",",isset($subValues['analyst_status'])?$subValues['analyst_status']:'0');
 					foreach ($assigned_team_id as $drugtest_key => $drugtest_value) {
 						$drugtest_analyst_status = isset($analyst_status[$drugtest_key])?$analyst_status[$drugtest_key]:'0'; 
 						if( ($drugtest_analyst_status  != '3' && $drugtest_analyst_status  != '10')){
	 						 $drugtest['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
		 					$drugtest['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
		 					$drugtest['component_name'] = $this->analystModel->get_component_name($drugtest['component_id'])[$this->config->item('show_component_name')];
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

		 					
		 					$drugtest['analyst_status'] = isset($analyst_status[$drugtest_key])?$analyst_status[$drugtest_key]:'0';
		 					// array_push($drugtest,isset($analyst_status[$drugtest_key])?$analyst_status[$drugtest_key]:'');

		 					$insuff_status = explode(",",$subValues['insuff_status']);
		 					$drugtest['insuff_status'] = isset($insuff_status[$drugtest_key])?$insuff_status[$drugtest_key]:'0';
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
 						}
 						 
 					}
 				}
 				// $final_data[$mainKey] = $drugtest;
 				
 			}
 			// 5
 			if($mainKey == 'globaldatabase'){
 				foreach ($value as $globaldatabase_key => $globaldatabase_value) {
 					$global_assigned_team_id =isset($globaldatabase_value['assigned_team_id'])?$globaldatabase_value['assigned_team_id']:'0';
 					if( ($globaldatabase_value['analyst_status'] != '3' && $globaldatabase_value['analyst_status'] != '10')){
	 					$globaldatabase_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
	 					$globaldatabase_value['component_name'] = $this->analystModel->get_component_name($globaldatabase_value['component_id'])[$this->config->item('show_component_name')];
	 					$globaldatabase_value['candidate_detail'] = $this->analystModel->getCandidateInfo($globaldatabase_value['candidate_id']);
	 					$globaldatabase_value['index'] = $globaldatabase_key;
	 					$globaldatabase_value['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
	 					array_push($final_data, $globaldatabase_value);
 					}
 				}
 			}
 			//  6
 			if($mainKey == 'current_employment'){
 				foreach ($value as $current_employment_key => $current_employment_value) {
 					$ce_assigned_team_id =isset($current_employment_value['assigned_team_id'])?$current_employment_value['assigned_team_id']:'0';
 					if( ($current_employment_value['analyst_status'] != '3' && $current_employment_value['analyst_status'] != '10')){
	 					$current_employment_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 						$current_employment_value['component_name'] = $this->analystModel->get_component_name($current_employment_value['component_id'])[$this->config->item('show_component_name')];
	 					$current_employment_value['candidate_detail'] = $this->analystModel->getCandidateInfo($current_employment_value['candidate_id']);
	 					$current_employment_value['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
	 					$current_employment_value['index'] = $current_employment_key;
	 					array_push($final_data, $current_employment_value);
 					}
 					
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
 						
 						if( ($analyst_status[$education_details_key] != '3' && $analyst_status[$education_details_key] != '10')){
   
		 					$education_details['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
		 					$education_details['component_name'] = $this->analystModel->get_component_name($education_details['component_id'])[$this->config->item('show_component_name')];
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

		 					// $assigned_role = json_decode($subValues['assigned_role'],true);
		 					// // array_push($education_details,isset($assigned_role[$education_details_key])?$assigned_role[$education_details_key]:'');
		 					// $assigned_role = explode(",",$subValues['assigned_role']);
		 					// $education_details['assigned_role'] = isset($assigned_role[$education_details_key])?$assigned_role[$education_details_key]:'';
		 					// array_push($drugtest,isset($assigned_role[$education_details_key])?$assigned_role[$education_details_key]:'');

		 					// array_push($education_details, $subValues['created_date']);
		 					$education_details['created_date'] = $subValues['created_date'];
		 					// array_push($education_details, $subValues['updated_date']);
		 					$education_details['updated_date'] = $subValues['updated_date'];

		 					$education_details['index'] = $education_details_key;
		 					$education_details['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
		 					array_push($final_data, $education_details);
 						}
 					}
 				}
 				// $final_data[$mainKey] = $education_details;
 				
 			}
 			// 8

 			if($mainKey == 'present_address'){
 				foreach ($value as $present_address_key => $present_address_value) { 
 					$pa_assigned_team_id =isset($present_address_value['assigned_team_id'])?$present_address_value['assigned_team_id']:'0';
 					if( ($present_address_value['analyst_status'] != '3' && $present_address_value['analyst_status'] != '10')){
	 					$present_address_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
	 					$present_address_value['component_name'] = $this->analystModel->get_component_name($present_address_value['component_id'])[$this->config->item('show_component_name')];
	 					$present_address_value['candidate_detail'] = $this->analystModel->getCandidateInfo($present_address_value['candidate_id']);
	 					$present_address_value['index'] = $present_address_key;
	 					$present_address_value['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
	 					array_push($final_data, $present_address_value);
 					}
 				}
 			}

 			// 9
 			if($mainKey == 'permanent_address'){
 				foreach ($value as $permanent_address_key => $permanent_address_value) {
 					$pea_assigned_team_id =isset($permanent_address_value['assigned_team_id'])?$permanent_address_value['assigned_team_id']:'0';
 					if( ($permanent_address_value['analyst_status'] != '3' && $permanent_address_value['analyst_status'] != '10')){
	 					$permanent_address_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
	 					$permanent_address_value['component_name'] = $this->analystModel->get_component_name($permanent_address_value['component_id'])[$this->config->item('show_component_name')];
	 					$permanent_address_value['candidate_detail'] = $this->analystModel->getCandidateInfo($permanent_address_value['candidate_id']); 
	 					$permanent_address_value['index'] = $permanent_address_key;
	 					$permanent_address_value['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
	 					array_push($final_data, $permanent_address_value);
 					}
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

 						if( ($analyst_status[$pe_assigned_team_id_key] != '3' && $analyst_status[$pe_assigned_team_id_key] != '10')){
 							
 							$previous_employment['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_employment['component_name'] = $this->analystModel->get_component_name($previous_employment['component_id'])[$this->config->item('show_component_name')];
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
 							$previous_employment['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $previous_employment);
 						}
 					}
 				} 
 			}
 			

 			// 11
 			if($mainKey == 'reference'){
 				
 				foreach ($value as $reference_key => $reference_value) {
 					$reference_assigned_team_id = explode(",",$reference_value['assigned_team_id']);
 					 
 					foreach ($reference_assigned_team_id as $reference_assigned_team_id_key => $reference_assigned_team_id_value) {
 						$analyst_status = explode(",",$reference_value['analyst_status']);

 						if( ($analyst_status[$reference_assigned_team_id_key] != '3' && $analyst_status[$reference_assigned_team_id_key] != '10')){
 							
 							$reference['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$reference['component_name'] = $this->analystModel->get_component_name($reference['component_id'])[$this->config->item('show_component_name')];
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
 							$reference['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $reference);
 						}
 					}
 				} 

 			}

 			// 12
 			if($mainKey == 'previous_address'){

 			 	foreach ($value as $pa_key => $pa_value) {
 					$pa_assigned_team_id = explode(",",$pa_value['assigned_team_id']);
 					 
 					foreach ($pa_assigned_team_id as $pa_assigned_team_id_key => $pa_assigned_team_id_value) {
 						$analyst_status = explode(",",$pa_value['analyst_status']);
 						$pa_analyst_status = isset($analyst_status[$pa_assigned_team_id_key])?$analyst_status[$pa_assigned_team_id_key]:"0";
 						if( ($pa_analyst_status!= '3' && $pa_analyst_status != '10')){
 							
 							$previous_address['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_address['component_name'] = $this->analystModel->get_component_name($previous_address['component_id'])[$this->config->item('show_component_name')];
 							$previous_address['previos_address_id'] = $pa_value['previos_address_id'];
 							$previous_address['candidate_id'] = $pa_value['candidate_id']; 
 							$previous_address['candidate_detail'] = $this->analystModel->getCandidateInfo($pa_value['candidate_id']);
 							$previous_address['index'] = $pa_assigned_team_id_key; 

 							$status = explode(",",$pa_value['status']);
 							$previous_address['status'] = isset($status[$pa_assigned_team_id_key])?$status[$pa_assigned_team_id_key]:"";

 							
 							$previous_address['analyst_status'] = $pa_analyst_status;

 							$insuff_status = explode(",",$pa_value['insuff_status']);
		 					$previous_address['insuff_status'] = isset($insuff_status[$pa_assigned_team_id_key])?$insuff_status[$pa_assigned_team_id_key]:'';


 							$previous_address['updated_date'] = $pa_value['updated_date'];
 							$previous_address['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));

 							array_push($final_data, $previous_address);
 						}
 					}
 				} 
 			}
 			

 			// 14
 			if($mainKey == 'directorship_check'){
 			 	foreach ($value as $pa_key => $dir_value) {
 					$dir_assigned_team_id = explode(",",$dir_value['assigned_team_id']);
 					 
 					foreach ($dir_assigned_team_id as $dir_assigned_team_id_key => $dir_assigned_team_id_value) {
 						$dir_analyst_status = explode(",",$dir_value['analyst_status']);
 						$dirAnalystStatus = isset($dir_analyst_status[$dir_assigned_team_id_key])?$dir_analyst_status[$dir_assigned_team_id_key]:'0';
 						
 						if( ($dirAnalystStatus != '3' && $dirAnalystStatus != '10')){
 							
 							$previous_address['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_address['component_name'] = $this->analystModel->get_component_name($previous_address['component_id'])[$this->config->item('show_component_name')];
 							$previous_address['directorship_check_id'] = $dir_value['directorship_check_id'];
 							$previous_address['candidate_id'] = $dir_value['candidate_id']; 
 							$previous_address['candidate_detail'] = $this->analystModel->getCandidateInfo($dir_value['candidate_id']);
 							$previous_address['index'] = $dir_assigned_team_id_key; 

 							$status = explode(",",$dir_value['status']);
 							$previous_address['status'] = isset($status[$dir_assigned_team_id_key])?$status[$dir_assigned_team_id_key]:"";

 							
 							$previous_address['analyst_status'] = isset($dir_analyst_status[$dir_assigned_team_id_key])?$dir_analyst_status[$dir_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$dir_value['insuff_status']);
		 					$previous_address['insuff_status'] = isset($insuff_status[$dir_assigned_team_id_key])?$insuff_status[$dir_assigned_team_id_key]:'';


 							$previous_address['updated_date'] = $dir_value['updated_date'];
 							$previous_address['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $previous_address);
 						}
 					}
 				} 
 			}


 			// 15
 			if($mainKey == 'global_sanctions_aml'){
 			 	foreach ($value as $pa_key => $sanctions_value) {
 					$sanctions_assigned_team_id = explode(",",$sanctions_value['assigned_team_id']);
 					 
 					foreach ($sanctions_assigned_team_id as $sanctions_assigned_team_id_key => $sanctions_assigned_team_id_value) {
 						$analyst_status = explode(",",$sanctions_value['analyst_status']);
 						$global_sanctions_analyst_status = isset($analyst_status[$sanctions_assigned_team_id_key])?$analyst_status[$sanctions_assigned_team_id_key]:'0';
 						if( ($global_sanctions_analyst_status != '3' && $global_sanctions_analyst_status != '10')){
 							
 							$global_sanctions_aml['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$global_sanctions_aml['component_name'] = $this->analystModel->get_component_name($global_sanctions_aml['component_id'])[$this->config->item('show_component_name')];
 							$global_sanctions_aml['global_sanctions_aml_id'] = $sanctions_value['global_sanctions_aml_id'];
 							$global_sanctions_aml['candidate_id'] = $sanctions_value['candidate_id']; 
 							$global_sanctions_aml['candidate_detail'] = $this->analystModel->getCandidateInfo($sanctions_value['candidate_id']);
 							$global_sanctions_aml['index'] = $sanctions_assigned_team_id_key; 

 							$status = explode(",",$sanctions_value['status']);
 							$global_sanctions_aml['status'] = isset($status[$sanctions_assigned_team_id_key])?$status[$sanctions_assigned_team_id_key]:"";

 							
 							$global_sanctions_aml['analyst_status'] = $global_sanctions_analyst_status;

 							$insuff_status = explode(",",$sanctions_value['insuff_status']);
		 					$global_sanctions_aml['insuff_status'] = isset($insuff_status[$sanctions_assigned_team_id_key])?$insuff_status[$sanctions_assigned_team_id_key]:'';


 							$global_sanctions_aml['updated_date'] = $sanctions_value['updated_date'];
 							$global_sanctions_aml['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $global_sanctions_aml);
 						}
 					}
 				} 
 			}
 
 			
 			// 16
 			if($mainKey == 'driving_licence'){
 			 	foreach ($value as $pa_key => $dl_value) {
 					$dl_assigned_team_id = explode(",",$dl_value['assigned_team_id']);
 					 
 					foreach ($dl_assigned_team_id as $dl_assigned_team_id_key => $dl_assigned_team_id_value) {
 						$analyst_status = explode(",",$dl_value['analyst_status']);
 						$driving_licence_analyst_status = isset($analyst_status[$dl_assigned_team_id_key])?$analyst_status[$dl_assigned_team_id_key]:"0";
 						if( ($driving_licence_analyst_status != '3' && $driving_licence_analyst_status != '10')){
 							
 							$driving_licence['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$driving_licence['component_name'] = $this->analystModel->get_component_name($driving_licence['component_id'])[$this->config->item('show_component_name')];
 							$driving_licence['licence_id'] = $dl_value['licence_id'];
 							$driving_licence['candidate_id'] = $dl_value['candidate_id']; 
 							$driving_licence['candidate_detail'] = $this->analystModel->getCandidateInfo($dl_value['candidate_id']);
 							$driving_licence['index'] = $dl_assigned_team_id_key; 

 							$status = explode(",",$dl_value['status']);
 							$driving_licence['status'] = isset($status[$dl_assigned_team_id_key])?$status[$dl_assigned_team_id_key]:"";

 							
 							$driving_licence['analyst_status'] = $driving_licence_analyst_status;

 							$insuff_status = explode(",",$dl_value['insuff_status']);
		 					$driving_licence['insuff_status'] = isset($insuff_status[$dl_assigned_team_id_key])?$insuff_status[$dl_assigned_team_id_key]:'';


 							$driving_licence['updated_date'] = $dl_value['updated_date'];
 							$driving_licence['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $driving_licence);
 						}
 					}
 				} 
 			}

 			// 17
 			if($mainKey == 'credit_cibil'){
 				// echo "data:".$mainKey;
 			 	foreach ($value as $pa_key => $cc_value) {
 					$cc_assigned_team_id = explode(",",$cc_value['assigned_team_id']);
 					 
 					foreach ($cc_assigned_team_id as $cc_assigned_team_id_key => $cc_assigned_team_id_value) {
 						$analyst_status = explode(",",$cc_value['analyst_status']);
 						$cc_analyst_status = isset($analyst_status[$cc_assigned_team_id_key])?$analyst_status[$cc_assigned_team_id_key]:"0";
 						if( ($cc_analyst_status != '3' && $cc_analyst_status != '10')){
 							
 							$credit_cibil['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$credit_cibil['component_name'] = $this->analystModel->get_component_name($credit_cibil['component_id'])[$this->config->item('show_component_name')];
 							$credit_cibil['credit_id'] = $cc_value['credit_id'];
 							$credit_cibil['candidate_id'] = $cc_value['candidate_id']; 
 							$credit_cibil['candidate_detail'] = $this->analystModel->getCandidateInfo($cc_value['candidate_id']);
 							$credit_cibil['index'] = $cc_assigned_team_id_key; 

 							$status = explode(",",$cc_value['status']);
 							$credit_cibil['status'] = isset($status[$cc_assigned_team_id_key])?$status[$cc_assigned_team_id_key]:"";

 							
 							$credit_cibil['analyst_status'] = $cc_analyst_status;

 							$insuff_status = explode(",",$cc_value['insuff_status']);
		 					$credit_cibil['insuff_status'] = isset($insuff_status[$cc_assigned_team_id_key])?$insuff_status[$cc_assigned_team_id_key]:'';


 							$credit_cibil['updated_date'] = $cc_value['updated_date'];
 							$credit_cibil['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $credit_cibil);
 						}
 					}
 				} 
 			}
 			 
 			// 18
 			if($mainKey == 'bankruptcy'){
 			 	foreach ($value as $pa_key => $bankruptcy_value) {
 					$bankruptcy_assigned_team_id = explode(",",$bankruptcy_value['assigned_team_id']);
 					 
 					foreach ($bankruptcy_assigned_team_id as $bankruptcy_assigned_team_id_key => $bankruptcy_assigned_team_id_value) {
 						$analyst_status = explode(",",$bankruptcy_value['analyst_status']);
 						$bankruptcy_analyst_status = isset($analyst_status[$bankruptcy_assigned_team_id_key])?$analyst_status[$bankruptcy_assigned_team_id_key]:"0";
 						if( ($analyst_status[$bankruptcy_assigned_team_id_key] != '3' && $analyst_status[$bankruptcy_assigned_team_id_key] != '10')){
 							
 							$bankruptcy['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$bankruptcy['component_name'] = $this->analystModel->get_component_name($bankruptcy['component_id'])[$this->config->item('show_component_name')];
 							$bankruptcy['bankruptcy_id'] = $bankruptcy_value['bankruptcy_id'];
 							$bankruptcy['candidate_id'] = $bankruptcy_value['candidate_id']; 
 							$bankruptcy['candidate_detail'] = $this->analystModel->getCandidateInfo($bankruptcy_value['candidate_id']);
 							$bankruptcy['index'] = $bankruptcy_assigned_team_id_key; 

 							$status = explode(",",$bankruptcy_value['status']);
 							$bankruptcy['status'] = isset($status[$bankruptcy_assigned_team_id_key])?$status[$bankruptcy_assigned_team_id_key]:"";

 							
 							$bankruptcy['analyst_status'] = $bankruptcy_analyst_status;

 							$insuff_status = explode(",",$bankruptcy_value['insuff_status']);
		 					$bankruptcy['insuff_status'] = isset($insuff_status[$bankruptcy_assigned_team_id_key])?$insuff_status[$bankruptcy_assigned_team_id_key]:'';


 							$bankruptcy['updated_date'] = $bankruptcy_value['updated_date'];
 							$bankruptcy['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $bankruptcy);
 						}
 					}
 				} 
 			}

 			// 19
 			if($mainKey == 'adverse_database_media_check'){
 			 	foreach ($value as $pa_key => $adm_value) {
 					$adm_assigned_team_id = explode(",",$adm_value['assigned_team_id']);
 					 
 					foreach ($adm_assigned_team_id as $adm_assigned_team_id_key => $adm_assigned_team_id_value) {
 						$analyst_status = explode(",",$adm_value['analyst_status']);
 						$adm_analyst_status = isset($analyst_status[$adm_assigned_team_id_key])?$analyst_status[$adm_assigned_team_id_key]:"";
 						if( ($adm_analyst_status != '3' && $adm_analyst_status != '10')){
 							
 							$adm_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$adm_check['component_name'] = $this->analystModel->get_component_name($adm_check['component_id'])[$this->config->item('show_component_name')];
 							$adm_check['adverse_database_media_check_id'] = $adm_value['adverse_database_media_check_id'];
 							$adm_check['candidate_id'] = $adm_value['candidate_id']; 
 							$adm_check['candidate_detail'] = $this->analystModel->getCandidateInfo($adm_value['candidate_id']);
 							$adm_check['index'] = $adm_assigned_team_id_key; 

 							$status = explode(",",$adm_value['status']);
 							$adm_check['status'] = isset($status[$adm_assigned_team_id_key])?$status[$adm_assigned_team_id_key]:"";

 							
 							$adm_check['analyst_status'] = $adm_analyst_status;

 							$insuff_status = explode(",",$adm_value['insuff_status']);
		 					$adm_check['insuff_status'] = isset($insuff_status[$adm_assigned_team_id_key])?$insuff_status[$adm_assigned_team_id_key]:'';


 							$adm_check['updated_date'] = $adm_value['updated_date'];
 							$adm_check['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $adm_check);
 						}
 					}
 				} 
 			}

 			// 20
 			if($mainKey == 'cv_check'){
 			 	foreach ($value as $pa_key => $cv_value) {
 					$cv_assigned_team_id = explode(",",$cv_value['assigned_team_id']);
 					 
 					foreach ($cv_assigned_team_id as $cv_assigned_team_id_key => $cv_assigned_team_id_value) {
 						$analyst_status = explode(",",$cv_value['analyst_status']);
 						$cv_analyst_status = isset($analyst_status[$cv_assigned_team_id_key])?$analyst_status[$cv_assigned_team_id_key]:"0";
 						if( ($cv_analyst_status != '3' && $cv_analyst_status != '10')){
 							
 							$cv_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$cv_check['component_name'] = $this->analystModel->get_component_name($cv_check['component_id'])[$this->config->item('show_component_name')];
 							$cv_check['cv_id'] = $cv_value['cv_id'];
 							$cv_check['candidate_id'] = $cv_value['candidate_id']; 
 							$cv_check['candidate_detail'] = $this->analystModel->getCandidateInfo($cv_value['candidate_id']);
 							$cv_check['index'] = $cv_assigned_team_id_key; 

 							$status = explode(",",$cv_value['status']);
 							$cv_check['status'] = isset($status[$cv_assigned_team_id_key])?$status[$cv_assigned_team_id_key]:"";

 							
 							$cv_check['analyst_status'] = $cv_analyst_status;

 							$insuff_status = explode(",",$cv_value['insuff_status']);
		 					$cv_check['insuff_status'] = isset($insuff_status[$cv_assigned_team_id_key])?$insuff_status[$cv_assigned_team_id_key]:'';


 							$cv_check['updated_date'] = $cv_value['updated_date'];
 							$cv_check['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $cv_check);
 						}
 					}
 				} 
 			} 

 			// 21
 			if($mainKey == 'health_checkup'){
 			 	foreach ($value as $pa_key => $health_value) {
 					$health_assigned_team_id = explode(",",$health_value['assigned_team_id']);
 					 
 					foreach ($health_assigned_team_id as $health_assigned_team_id_key => $health_assigned_team_id_value) {
 						$analyst_status = explode(",",$health_value['analyst_status']);
 						$health_analyst_status =  isset($analyst_status[$health_assigned_team_id_key])?$analyst_status[$health_assigned_team_id_key]:"0";
 						if( ($health_analyst_status != '3' && $health_analyst_status != '10')){
 							
 							$health_checkup['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$health_checkup['component_name'] = $this->analystModel->get_component_name($health_checkup['component_id'])[$this->config->item('show_component_name')];
 							$health_checkup['health_checkup_id'] = $health_value['health_checkup_id'];
 							$health_checkup['candidate_id'] = $health_value['candidate_id']; 
 							$health_checkup['candidate_detail'] = $this->analystModel->getCandidateInfo($health_value['candidate_id']);
 							$health_checkup['index'] = $health_assigned_team_id_key; 

 							$status = explode(",",$health_value['status']);
 							$health_checkup['status'] = isset($status[$health_assigned_team_id_key])?$status[$health_assigned_team_id_key]:"";

 							
 							$health_checkup['analyst_status'] = $health_analyst_status;

 							$insuff_status = explode(",",$health_value['insuff_status']);
		 					$health_checkup['insuff_status'] = isset($insuff_status[$health_assigned_team_id_key])?$insuff_status[$health_assigned_team_id_key]:'';


 							$health_checkup['updated_date'] = $health_value['updated_date'];
 							$health_checkup['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $health_checkup);
 						}
 					}
 				} 
 			}

 			// 21
 			if($mainKey == 'covid_19'){
 			 	foreach ($value as $pa_key => $health_value) {
 					$health_assigned_team_id = explode(",",$health_value['assigned_team_id']);
 					 
 					foreach ($health_assigned_team_id as $health_assigned_team_id_key => $health_assigned_team_id_value) {
 						$analyst_status = explode(",",$health_value['analyst_status']);
 						$health_analyst_status =  isset($analyst_status[$health_assigned_team_id_key])?$analyst_status[$health_assigned_team_id_key]:"0";
 						if( ($health_analyst_status != '3' && $health_analyst_status != '10')){
 							
 							$covid['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$covid['component_name'] = $this->analystModel->get_component_name($covid['component_id'])[$this->config->item('show_component_name')];
 							$covid['covid_id'] = $health_value['covid_id'];
 							$covid['candidate_id'] = $health_value['candidate_id']; 
 							$covid['candidate_detail'] = $this->analystModel->getCandidateInfo($health_value['candidate_id']);
 							$covid['index'] = $health_assigned_team_id_key; 

 							$status = explode(",",$health_value['status']);
 							$covid['status'] = isset($status[$health_assigned_team_id_key])?$status[$health_assigned_team_id_key]:"";

 							
 							$covid['analyst_status'] = $health_analyst_status;

 							$insuff_status = explode(",",$health_value['insuff_status']);
		 					$covid['insuff_status'] = isset($insuff_status[$health_assigned_team_id_key])?$insuff_status[$health_assigned_team_id_key]:'';


 							$covid['updated_date'] = $health_value['updated_date'];
 							$covid['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $covid);
 						}
 					}
 				} 
 			}

 			// 22
 			if($mainKey == 'employment_gap_check'){
 			 	foreach ($value as $pa_key => $eg_value) {
 					$eg_assigned_team_id = explode(",",$eg_value['assigned_team_id']);
 					 
 					foreach ($eg_assigned_team_id as $eg_assigned_team_id_key => $eg_assigned_team_id_value) {
 						$analyst_status = explode(",",$eg_value['analyst_status']);
 						$eg_analyst_status = isset($analyst_status[$eg_assigned_team_id_key])?$analyst_status[$eg_assigned_team_id_key]:"0";
 						if( ($eg_analyst_status != '3' && $eg_analyst_status != '10')){
 							
 							$eg_checkup['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$eg_checkup['component_name'] = $this->analystModel->get_component_name($eg_checkup['component_id'])[$this->config->item('show_component_name')];
 							$eg_checkup['gap_id'] = $eg_value['gap_id'];
 							$eg_checkup['candidate_id'] = $eg_value['candidate_id']; 
 							$eg_checkup['candidate_detail'] = $this->analystModel->getCandidateInfo($eg_value['candidate_id']);
 							$eg_checkup['index'] = $eg_assigned_team_id_key; 

 							$status = explode(",",$eg_value['status']);
 							$eg_checkup['status'] = isset($status[$eg_assigned_team_id_key])?$status[$eg_assigned_team_id_key]:"";

 							
 							$eg_checkup['analyst_status'] = $eg_analyst_status;

 							$insuff_status = explode(",",$eg_value['insuff_status']);
		 					$eg_checkup['insuff_status'] = isset($insuff_status[$eg_assigned_team_id_key])?$insuff_status[$eg_assigned_team_id_key]:'';


 							$eg_checkup['updated_date'] = $eg_value['updated_date'];
 							$eg_checkup['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $eg_checkup);
 						}
 					}
 				} 
 			}


 			// echo $mainKey;
 			if($mainKey == 'landload_reference'){
 				 
 				foreach ($value as $reference_key => $reference_value) {
 					$reference_assigned_team_id = explode(",",$reference_value['assigned_team_id']);
 					 
 					foreach ($reference_assigned_team_id as $reference_assigned_team_id_key => $reference_assigned_team_id_value) {
 						$analyst_status = explode(",",$reference_value['analyst_status']);

 						if( ( $analyst_status[$reference_assigned_team_id_key] != '10' && $analyst_status[$reference_assigned_team_id_key] != '3')){
 							
 							$reference['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$reference['component_name'] = $this->analystModel->get_component_name($reference['component_id'])[$this->config->item('show_component_name')];
 							$reference['landload_id'] = $reference_value['landload_id'];
 							$reference['candidate_id'] = $reference_value['candidate_id']; 
 							$reference['candidate_detail'] = $this->analystModel->getCandidateInfo($reference_value['candidate_id']);
 							$reference['index'] = $reference_assigned_team_id_key;

 							 

 							$status = explode(",",$reference_value['status']);
 							$reference['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";

 							
 							$reference['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$reference_value['insuff_status']);
		 					$reference['insuff_status'] = isset($insuff_status[$reference_assigned_team_id_key])?$insuff_status[$reference_assigned_team_id_key]:'';

 							$reference['updated_date'] = $reference_value['updated_date'];
 							$reference['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $reference);
 						}
 					}
 				} 
 			}


 			// echo $mainKey;
 			if($mainKey == 'social_media'){
 				 
 				foreach ($value as $reference_key => $reference_value) {
 					$reference_assigned_team_id = explode(",",$reference_value['assigned_team_id']);
 					 
 					foreach ($reference_assigned_team_id as $reference_assigned_team_id_key => $reference_assigned_team_id_value) {
 						$analyst_status = explode(",",$reference_value['analyst_status']);

 						if( ( $analyst_status[$reference_assigned_team_id_key] != '10' && $analyst_status[$reference_assigned_team_id_key] != '3')){
 							
 							$social['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$social['component_name'] = $this->analystModel->get_component_name($social['component_id'])[$this->config->item('show_component_name')];
 							$social['social_id'] = $reference_value['social_id'];
 							$social['candidate_id'] = $reference_value['candidate_id']; 
 							$social['candidate_detail'] = $this->analystModel->getCandidateInfo($reference_value['candidate_id']);
 							$social['index'] = $reference_assigned_team_id_key;

 							 

 							$status = explode(",",$reference_value['status']);
 							$social['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";

 							
 							$social['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$reference_value['insuff_status']);
		 					$social['insuff_status'] = isset($insuff_status[$reference_assigned_team_id_key])?$insuff_status[$reference_assigned_team_id_key]:'';

 							$social['updated_date'] = $reference_value['updated_date'];
 							$social['emp_data_analyst'] = $this->adminViewAllCaseModel->getAnalystAndSpecialistTeamList($this->analystModel->getStatusFromComponent($mainKey));
 							array_push($final_data, $social);
 						}
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



	function overrideOutputQc(){
		$candidate_id = $this->input->post('candidate_id');
		$postion = $this->input->post('postion');		 
		$team_id = $this->input->post('team_id');

		$inputQcData = array(
			'assigned_outputqc_id' => $team_id ,
			'assigned_outputqc_date' => date('d-m-Y h:i:s')
		); 
		
		$this->db->where('candidate_id',$candidate_id);
		if ($this->db->update('candidate',$inputQcData)) {
			$component_data = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
			if($this->db->insert('candidate_log',$component_data)){ 
				return array('status'=>'1','msg'=>'success','logStatus'=>'1');
			}else{
				return array('status'=>'1','msg'=>'success','logStatus'=>'0');
			} 
		}else{
			return array('status'=>'0','msg'=>'failled','logStatus'=>'0');
		}
	}
}
?>