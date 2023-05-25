<?php
/** 
 * 01-02-2021	
 */
class AnalystModel extends CI_Model
{
 	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
    $this->load->model('utilModel'); 
	}


 function override_analyst_status(){ 
 		$candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		$componentname= $this->input->post('component_name');
		$postion= $this->input->post('postion');
		$status= $this->input->post('status');
	 $table_name = $this->utilModel->getComponent_or_PageName($component_id);

	 $data = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
	$data_analyst = explode(',', $data['analyst_status']);
	 $analyst_status = $this->changeVlaueThroughIndex($data_analyst,$postion,$status); 
	 $table_analyst = array('analyst_status'=>$analyst_status);
 			if ($this->db->where('candidate_id',$candidate_id)->update($table_name,$table_analyst)) { 
 				return array('status'=>'1','msg'=>'success');
			}else{
				return array('status'=>'0','msg'=>'failled');
			}
 }


 function view_process_guidline(){
 	$user = ''; 
 	if ($this->session->userdata('logged-in-specialist')) {
 		$user = $this->session->userdata('logged-in-specialist');
 	}else if ($this->session->userdata('logged-in-analyst')) {
 		$user = $this->session->userdata('logged-in-analyst'); 
 	}

 	$skills = isset($user['skills'])?$user['skills']:0;
 	return $this->db->where_in('process_component',explode(',', $skills))->select('process_guidline.*,components.*')->from('process_guidline')->join('components','process_guidline.process_component = components.component_id','left')->order_by('process_id','DESC')->get('')->result_array();
 }

	function insuffUpdateStatus(){

		$candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		$componentname= $this->input->post('componentname');
		 
		// echo "candidate_id : ".$candidate_id."<br>";
		// echo "componentname : ".$componentname."<br>";
		// echo "component_id : ".$component_id;
		// exit();

		$user = $this->session->userdata('logged-in-analyst'); 
		$inputqc_id = $this->getMinimumTaskHandlerAnalyst($componentname,$component_id);
		if($inputqc_id != 0){

				// 'assigned_role'=>'analyst',
				// 'assigned_team_id'=>$inputqc_id
			$components_data = array(
			
				'analyst_status'=>'3',
				'updated_date'=>date('d-m-Y H:i:s')
			);
			$this->db->where('candidate_id',$candidate_id);
			if ($this->db->update($componentname,$components_data)) { 
				$insert_id = $this->db->insert_id();
				$components_log_data = array( 
					'candidate_id'=>$candidate_id,
					'analyst_status'=>'3',
					'updated_date'=>date('d-m-Y H:i:s') 
					 
				);
				$this->db->insert($componentname."_log",$components_log_data);
				return array('status'=>'1','msg'=>'success');
			}else{
				return array('status'=>'0','msg'=>'failled');
			}
		}else{
			$componentname = str_replace('_',' ',$componentname);
			return array('status'=>'2','msg'=>'we don\'t have skill '.$componentname.' with analyst.' );
		}
		 
	}

	function approveUpdateStatus($candidate_id,$table_name,$component_id){
		 
			 $user = $this->session->userdata('logged-in-analyst');
				if ($this->session->userdata('logged-in-analyst')) {
					$user = $this->session->userdata('logged-in-analyst');
				}else{
					$user = $this->session->userdata('logged-in-specialist');
				} 
		 
		$components_data = array(
			
			'analyst_status'=>'4',
			'updated_date'=>date('d-m-Y H:i:s')
		);
		$this->db->where('candidate_id',$candidate_id);
		if ($this->db->update($table_name,$components_data)) {

			$outpuQcUpdateStatus = $this->isAllComponentApproved($candidate_id);
			if($outpuQcUpdateStatus != '1'){
				$outpuQcUpdateStatus = '0';
			}else{
				$outpuQcUpdateStatus = '1';
			}
			
			$insert_id = $this->db->insert_id();
			$components_log_data = array( 
				'candidate_id'=>$candidate_id,
				'analyst_status'=>'4',
				'updated_date'=>date('d-m-Y H:i:s')
			);
			$this->db->insert($table_name."_log",$components_log_data);
			return array('status'=>'1','msg'=>'success','outpuQcUpdateStatus'=>$outpuQcUpdateStatus);
		}else{
			return array('status'=>'0','msg'=>'failled','outpuQcUpdateStatus'=>$outpuQcUpdateStatus);
		} 
	}

	function stopcheckUpdateStatus($candidate_id,$table_name,$component_id){
		 
			 $user = $this->session->userdata('logged-in-analyst');
				if ($this->session->userdata('logged-in-analyst')) {
					$user = $this->session->userdata('logged-in-analyst');
				}else{
					$user = $this->session->userdata('logged-in-specialist');
				} 
		 
		$components_data = array(
			
			'analyst_status'=>'5',
			'updated_date'=>date('d-m-Y H:i:s')
		);
		$this->db->where('candidate_id',$candidate_id);
		if ($this->db->update($table_name,$components_data)) {

			$outpuQcUpdateStatus = $this->isAllComponentApproved($candidate_id);
			if($outpuQcUpdateStatus != '1'){
				$outpuQcUpdateStatus = '0';
			}else{
				$outpuQcUpdateStatus = '1';
			}
			
			$insert_id = $this->db->insert_id();
			$components_log_data = array( 
				'candidate_id'=>$candidate_id,
				'analyst_status'=>'5',
				'updated_date'=>date('d-m-Y H:i:s')
			);
			$this->db->insert($table_name."_log",$components_log_data);
			return array('status'=>'1','msg'=>'success','outpuQcUpdateStatus'=>$outpuQcUpdateStatus);
		}else{
			return array('status'=>'0','msg'=>'failled','outpuQcUpdateStatus'=>$outpuQcUpdateStatus);
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


	function getCaseAssignedComponent(){
		$analyst_info = $this->session->userdata('logged-in-analyst'); 
		if($analyst_info == ''){
			$analyst_info = $this->session->userdata('logged-in-insuffanalyst'); 
		}
		// print_r($analyst_info);
		// exit();
		$component = array('court_records','criminal_checks','current_employment','document_check','drugtest','education_details','globaldatabase','permanent_address','present_address','previous_address','previous_employment','reference','directorship_check','global_sanctions_aml','driving_licence','credit_cibil','bankruptcy','adverse_database_media_check','cv_check','health_checkup','landload_reference','covid_19','social_media','civil_check','right_to_work','sex_offender','politically_exposed','india_civil_litigation','mca','nric','gsa','oig');
 
		$assignedComponent = array();
		foreach ($component as $key => $value) {
			$role = '';
			$insuff = '';
			if($analyst_info['role'] == 'insuff analyst'){
				// $role = 'insuff analyst';
				$role = 'analyst';
				$analyst_info['team_id'] = '23';
				$insuff= "=";
			}else if($analyst_info['role'] == 'analyst'){
				$role = 'analyst';
				$insuff= "!=";
			}
			$getResult = $this->db->select($value.".*,candidate.first_name,candidate.last_name,candidate.phone_number,candidate.email_id,tbl_client.client_name,tbl_client.client_id")->from($value)->join('candidate',$value.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->where('assigned_role',$role)->where('assigned_team_id',$analyst_info['team_id'])->where('analyst_status'.$insuff,'3')->where('analyst_status !=','10')->get();

			if($getResult->num_rows() > 0 ){	 
				$data = $getResult->result_array();
				foreach ($data as $datakey => $dataValue) {
					$dataValue['component_name'] = $value;
					$dataValue['component_id'] = $this->getStatusFromComponent($value);
					array_push($assignedComponent, $dataValue);
				}

			} 
		}
		// sorting by date 
		$assigned = array_column($assignedComponent, 'created_date');
		array_multisort($assigned, SORT_DESC, $assignedComponent); 
		return $assignedComponent;
	}


	function getQcErrorComponent(){
		// $analyst_info = $this->session->userdata('logged-in-analyst'); 
		$userID ='';
		$userRole ='';
		if($this->session->userdata('logged-in-analyst')){

			$analystUser = $this->session->userdata('logged-in-analyst');
		    $userID =$analystUser['team_id'];
		    $userRole =$analystUser['role'];
		}
		else if($this->session->userdata('logged-in-insuffanalyst')){ 
		     
		    $analystUser = $this->session->userdata('logged-in-insuffanalyst');
		    $userID =$analystUser['team_id'];
		    $userRole =$analystUser['role'];
		    // $courtRecordStatus = $componentData['analyst_status'];
		  }
		$component = array('court_records','criminal_checks','current_employment','document_check','drugtest','education_details','globaldatabase','permanent_address','present_address','previous_address','previous_employment','reference','directorship_check','global_sanctions_aml','driving_licence','credit_cibil','bankruptcy','adverse_database_media_check','cv_check','health_checkup','landload_reference','covid_19','social_media','civil_check','right_to_work','sex_offender','politically_exposed','india_civil_litigation','mca','nric','gsa','oig');
 
		$assignedComponent = array();
		foreach ($component as $key => $value) {
			 
			
			$getResult = $this->db->select($value.".*,candidate.first_name,candidate.last_name,candidate.phone_number,candidate.email_id,tbl_client.client_name,tbl_client.client_id")->from($value)->join('candidate',$value.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->where('assigned_role',$userRole)->where('assigned_team_id',$userID)->where('analyst_status','10')->get();

			if($getResult->num_rows() > 0 ){	 
				$data = $getResult->result_array();
				foreach ($data as $datakey => $dataValue) {
					$dataValue['component_name'] = $value;
					$dataValue['component_id'] = $this->utilModel->getComponentId($value);
					array_push($assignedComponent, $dataValue);
				}

			} 
		}
		// sorting by date 
		$assigned = array_column($assignedComponent, 'created_date');
		array_multisort($assigned, SORT_DESC, $assignedComponent); 
		return $assignedComponent;
	}


	
	function getStatusFromComponent($table_name){
		 
		$component_id = '';
		 
		switch ($table_name) {
			
			case 'criminal_checks':
				$component_id = '1';
				
				break;

			case 'court_records':
				$component_id = '2';
				
				break;
			case 'document_check':
				$component_id = '3';
				break;

			case 'drugtest':
				$component_id = '4';
				break;

			case 'globaldatabase':
				$component_id = '5';
				break;

			case 'current_employment':
				$component_id = '6';
				break; 
			case 'education_details':
				$component_id = '7';
				break; 
			case 'present_address':
				$component_id = '8';
				break; 
			case 'permanent_address':
				$component_id = '9';
				break; 
			case 'previous_employment':
				$component_id = '10';
				break; 
			case 'reference':
				$component_id = '11';
				break; 
			case 'previous_address':
				$component_id = '12';
				break;
			case 'directorship_check';
				$component_id = '14';
				break;
			case 'global_sanctions_aml';
				$component_id = '15';
				break;
			case 'driving_licence';
				$component_id = '16';
				break;
			case 'directorship_check';
				$component_id = '17';
				break;
			case 'directorship_check';
				$component_id = '18';
				break;
			case 'adverse_database_media_check';
				$component_id = '19';
				break;
			case 'cv_check';
				$component_id = '20';
				break;
			case 'health_checkup';
				$component_id = '21';
				break;
			case 'employement_gap_check';
				$component_id = '22';
				break;
			case 'landload_reference';
				$component_id = '23';
				break;
			case 'covid_19';
				$component_id = '24';
				break;
			case 'social_media';
				$component_id = '25';
				break;
			case 'civil_check';
				$component_id = '26';
				break; 
			case 'right_to_work':
				$component_id = '27';
				break;
			case 'sex_offender':
				$component_id = '28';
				break;
			case 'politically_exposed':
				$component_id = '29';
				break;
			case 'india_civil_litigation':
				$component_id = '30';
				break;
			case 'mca':
				$component_id = '31';
				break;
			case 'nric':
				$component_id = '32';
				break;
			case 'gsa':
				$component_id = '33';
				break;
			case 'oig':
				$component_id = '34';
				break;
			default:  
				break;
		}
 
		return $component_id;
	}

	function isAllComponentApproved($candidate_id){
		// echo $candidate_id."<br>"; 
		$candidateData = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
		 
		$component_ids = explode(',', $candidateData['component_ids']) ; 
		// echo "component_ids:";
		// print_r($component_ids);
		// exit();
		$analystStatus = array();
		 
		$analystStatusArray = array();

		foreach ($component_ids as $key => $value) {
			// echo $this->getComponentName($value)."<br>";
			$componentStatus = $this->db->select('analyst_status')->where('candidate_id',$candidate_id)->get($this->utilModel->getComponent_or_PageName($value))->row_array(); 
			// print_r($componentStatus );
			$component_status = isset($componentStatus['analyst_status'])?$componentStatus['analyst_status']:'0';
			array_push($analystStatus, $component_status);  
			$tmp_com_status = explode(',',$component_status);

			$positive_status = array('4','5','6','7','9');

			$tmp_matched_array = array();
			foreach ($tmp_com_status as $statuskey => $statusValue) {
			  	// echo $j++ .": Form Status: ".$statusValue;
			  	
			  	if (in_array($statusValue, $positive_status)){
					array_push($tmp_matched_array, '1');
				}else{
				  	array_push($tmp_matched_array, '0');
				}
			}  

			array_push($analystStatusArray, $tmp_matched_array);
			 
		} 
		$finalAnalystStatusArray = array();

		foreach ($analystStatusArray as $analystStatusArraykey => $analystStatusArrayValue) {
			if(!in_array('0', $analystStatusArrayValue)){
				array_push($finalAnalystStatusArray, '1');
			}
		} 

		if(count($component_ids) == count($finalAnalystStatusArray)){	
			 
			$outputQc_id = $this->getMinimumTaskHandlerOutPutQC();
			 
			$components_data = array( 
				'assigned_outputqc_id'=>$outputQc_id,
				// 'is_submitted'=>'2',
				'assigned_outputqc_notification'=>'1',
				'assigned_outputqc_date' =>date('d-m-Y H:i:s'),
				'updated_date'=>date('d-m-Y H:i:s')
				 
			);
			$this->db->where('candidate_id',$candidate_id);
			if ($this->db->update('candidate',$components_data)) {
				$insert_id = $this->db->insert_id();
				$components_log_data = array( 
					'candidate_id'=>$candidate_id,
					'assigned_outputqc_id'=>$outputQc_id,
					'assigned_outputqc_date' =>date('d-m-Y H:i:s'),
					// 'is_submitted'=>'2',
					'assigned_outputqc_notification'=>'1',
					'updated_date'=>date('d-m-Y H:i:s')  
				);
				$this->db->insert("candidate_log",$components_log_data);
				return $status = '1';
			}else{
				return $status = '0';
			}

		}else{
			return $status = '0';
			
		}	

	}

	function getMinimumTaskHandlerOutPutQC(){
 
		$count = array(); 
		$result = $this->db->select('team_id')->where('role','outputqc')->where('is_Active','1')->get('team_employee')->result_array(); 

		foreach ($result as $key => $value) {
			$candidate_detail = $this->db->where('is_submitted !=','2')->where('assigned_outputqc_id',$value['team_id'])->get('candidate')->num_rows();
			$row['team_id'] = $value['team_id'];
			$row['total'] = $candidate_detail;
			array_push($count, $row); 
		}
		
		$keys = array_column($count, 'total'); 
    	array_multisort($keys, SORT_ASC, $count); 
    	return $count[0]['team_id'];    	 
	}



	function singleComponentDetail($componentId,$candidateId){

		$table_name = $this->utilModel->getComponent_or_PageName($componentId);
		// echo  "table_name: ".$table_name;
		// echo  "||componentId: ".$componentId;
		// exit();
		if($componentId == 4){

			// $component_based = $this->db->select($table_name.'.*,candidate.priority,candidate.first_name,candidate.last_name,candidate.phone_number,candidate.email_id,candidate.date_of_birth,candidate.date_of_birth,candidate.form_values,candidate.father_name,candidate.employee_id,tbl_client.client_name,packages.package_name')->from($table_name)->join('candidate',$table_name.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where($table_name.'.candidate_id',$candidateId)->get()->row_array();
			$component_based = $this->db->select($table_name.'.*,candidate.*,tbl_client.client_name,packages.package_name,tbl_client.signature')->from($table_name)->join('candidate',$table_name.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where($table_name.'.candidate_id',$candidateId)->get()->row_array();

			$form_values = json_decode($component_based['form_values'],true);
			$form_values_final = json_decode($form_values,true);
			// $outpuQcUpdateStatus = $this->isAllComponentApproved($candidate_id);
			// if($outpuQcUpdateStatus != '1'){
			// 	$outpuQcUpdateStatus = '0';
			// }else{
			// 	$outpuQcUpdateStatus = '1';
			// }
			$i = 0;
			$drugtestType = array();
			foreach ($form_values_final['drug_test'] as $key => $value) {
				// echo $i++.": ".$value;
				$form_value_name = $this->db->where('drug_test_type_id',$value)->get('drug_test_type')->row_array(); 
				array_push($drugtestType,$form_value_name['drug_test_type_name']);
				// echo "<br>";
			}
			
			foreach ($component_based as $key => $value) {
					$component_based['drugtestType'] = json_encode($drugtestType);
			}
			

			
		}else if($componentId == 3){ 

			$component_based = $this->db->select($table_name.'.*,candidate.*,tbl_client.client_name,packages.package_name,tbl_client.signature')->from($table_name)->join('candidate',$table_name.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where($table_name.'.candidate_id',$candidateId)->get()->row_array();
			$form_values = json_decode($component_based['form_values'],true);
			$form_values_final = json_decode($form_values,true);

			$i = 0;
			$documentType = array();
			foreach ($form_values_final['document_check'] as $key => $value) {
				// echo $i++.": ".$value;
				$form_value_name = $this->db->where('document_type_id',$value)->get('document_type')->row_array(); 
				array_push($documentType,$form_value_name['document_type_name']);
				// echo "<br>";
			}
			
			foreach ($component_based as $key => $value) {
					$component_based['documentType'] = json_encode($documentType);
			}
			
		}else if($componentId == 6){
			$component_based = $this->db->select($table_name.'.*,candidate.nationality
,candidate.candidate_state
,candidate.candidate_city
,candidate.candidate_pincode
,candidate.remark,candidate.week
,candidate.contact_start_time
,candidate.contact_end_time,candidate.priority,candidate.first_name,candidate.last_name,candidate.phone_number,candidate.email_id,candidate.date_of_birth,candidate.date_of_birth,candidate.employee_id as emp_id,candidate.father_name,tbl_client.client_name,packages.package_name,tbl_client.signature')->from($table_name)->join('candidate',$table_name.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where($table_name.'.candidate_id',$candidateId)->get()->row_array();

		}else if($componentId == 10){
			$component_based = $this->db->select($table_name.'.*,candidate.nationality
,candidate.candidate_state
,candidate.candidate_city
,candidate.candidate_pincode
,candidate.remark,candidate.week
,candidate.contact_start_time
,candidate.contact_end_time,candidate.priority,candidate.first_name,candidate.last_name,candidate.phone_number,candidate.email_id,candidate.date_of_birth,candidate.date_of_birth,candidate.employee_id as emp_id,candidate.father_name,tbl_client.client_name,packages.package_name,tbl_client.signature')->from($table_name)->join('candidate',$table_name.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where($table_name.'.candidate_id',$candidateId)->get()->row_array();

		}else{
			// $component_based = $this->db->select($table_name.'.*,candidate.priority,candidate.first_name,candidate.last_name,candidate.phone_number,candidate.email_id,candidate.date_of_birth,candidate.date_of_birth,tbl_client.client_name,packages.package_name')->from($table_name)->join('candidate',$table_name.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where($table_name.'.candidate_id',$candidateId)->get()->row_array();
			$component_based = $this->db->select($table_name.'.*,candidate.*,tbl_client.client_name,packages.package_name,tbl_client.signature')->from($table_name)->join('candidate',$table_name.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where($table_name.'.candidate_id',$candidateId)->get()->row_array();

			// echo $this->db->last_query();
		}
		
		// echo json_encode($component_based);
 		
		return $component_based;

	}

	function tatDateUpdate($candidate_id,$component_name,$form_number){
 		 
		// echo "component Name :".$component_name;
		// echo "component_id:".$this->utilModel->getComponentId($component_name);
		// exit();
 		$userInfo = $this->session->userdata('logged-in-insuffanalyst');
	 	$userData['team_id'] = $userInfo['team_id'];
		$userData['role'] = $userInfo['role'];
		$userData['team_employee_email'] = $userInfo['team_employee_email'];
		$userData = json_encode($userData);

		$candidateData = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();

		$tat_log_data['candidate_id'] = $candidate_id;
 		$tat_log_data['tat_start_date'] = $candidateData['tat_start_date'];
 		$tat_log_data['tat_end_date'] =  $candidateData['tat_end_date'];
 		$tat_log_data['tat_pause_date'] =  date("d-m-Y H:i:s");
 		$tat_log_data['tat_re_start_date'] =  isset($candidateData['tat_re_start_date'])?$candidateData['tat_re_start_date']:'-';
 		$tat_log_data['component_id'] =  $this->utilModel->getComponentId($component_name);
 		$tat_log_data['component_name'] =  $component_name;
 		$tat_log_data['form_number'] = $form_number;
 		$tat_log_data['user_detail'] = $userData;
 		 
 		if($this->db->insert('tat_date_log',$tat_log_data)){
 			return 1;
 		}else{
 			return 0;
 		}
 		
	} 

	function insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id){
		$component = $this->db->where('component_id',$component_id)->get('components')->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();
		$mail_subject = "Insufficient Data";
		$body_message="
				<html>
					<head>
						<style>
							table {
								font-family: arial, sans-serif;
								border-collapse: collapse;
								width: 100%;
							}

							td, th {
								border: 1px solid #dddddd;
								text-align: left;
								padding: 8px;
							}

							tr:nth-child(even) {
								background-color: #dddddd;
							}
						</style>
					</head>
					<body>
						<p>Dear “".$candidate_info['first_name'].' '.$candidate_info['last_name']."”,</p>
						<p>Greetings from Factsuite!!</p>
						<p>An Insufficiency has been reported for the below mentioned case-</p>
						 
						<table>
							<th>Insuff Raised Date</th>
							<th>Case #</th>
							<th>Candidate Name</th>
							<th>Component Name</th>
							<th>Insuff Remarks</th>
							<th>Candidate LoginID</th>
							<th>OTP</th>
							<tr>
							<td>".date("d-M-Y")."</td>
							<td>".$candidate_info['candidate_id']."</td>
							<td>".$candidate_info['first_name'].' '.$candidate_info['last_name']."</td>
							<td>".$component[$this->config->item('show_component_name')]."</td>
							<td>".$insuff_remarks."</td>
							<td>".$candidate_info['loginId']."</td>
							<td>".$candidate_info['otp_password']."</td>
							<tr>
						</table>
						<p>Kindly click the link ".$this->config->item('candidate_url')." to update/upload the same, to help us complete your Background verification, at the earliest.</p>
						<p><b>Yours sincerely,<br>
						Team FactSuite</b></p>
					</body>
				</html>";
		$this->emailModel->send_mail($client_info['spoc_email_id'],$mail_subject,$body_message);
	}

 

	function update_remarks_candidate_criminal_check($client_docs){
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',',$this->input->post('action_status'));
		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$criminal_check_id = $this->input->post('criminal_check_id');
		$table_name = 'criminal_checks';
		$date =  date('d-m-Y H:i:s');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		} 

		$assigned_info = $this->db->select('*')->from($table_name)->where('criminal_check_id',$criminal_check_id)->get()->row_array();
		// return $assigned_info;
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));
		// print_r($analyst_status);
		// exit();
		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);
		$component_id =0;
		$candidate_info = $this->db->select('candidate.* ,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('criminal_check_id',$criminal_check_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);

		$criminal_checks = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_period_of_stay'=>$this->input->post('remark_period_of_stay'),
			'remark_gender'=>$this->input->post('remark_gender'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'Insuff_closure_remarks'=>$this->input->post('closure_remarks'),			
			'output_status'=>$this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0'),
			'approved_doc' =>$remarks_docs,
		); 

		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$criminal_checks['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}

		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$criminal_checks['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			 
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'1',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);

				$criminal_checks['analyst_status'] = $analyst_status_final;
				$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
				$analyst_status_date[$index] = date('Y-m-d H:i');
				$criminal_checks['analyst_status_date'] =  implode(',', $analyst_status_date); 
				$criminal_checks['assigned_role'] = $assigned_role;
				$criminal_checks['assigned_team_id'] = $assigned_team_id;
				// Analyst/Specialist get notification.
				

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 

			}else{
				$criminal_checks['analyst_status'] = $analyst_status_final;
				$criminal_checks['analyst_status_date'] = $analyst_status_date_final;
				// echo "Analyst will get a notification.";
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$criminal_checks['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			$criminal_checks['analyst_status_date'] = $analyst_status_date_final;
			// send SMS Or Mail to Candidate.
			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$assigned_info = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}
			$candidate = $candidate_info['candidate_id']; 
			if($candidate != '' && $candidate != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}


			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			 $smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']); 
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			// $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$client_info['spoc_email_id']);

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);

		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'1',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$criminal_checks['insuff_team_role'] = $insuff_team_role;
				$criminal_checks['insuff_team_id'] = $insuff_team_id;
				$criminal_checks['analyst_status'] = $analyst_status_final;
				$criminal_checks['analyst_status_date'] = date('d-m-Y H:i:s');
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$criminal_checks['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$criminal_checks['analyst_status'] = $analyst_status_final;
				$criminal_checks['analyst_status_date'] = $analyst_status_date_final;
				
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
			} 
			

		}else{
			$criminal_checks['analyst_status'] = $analyst_status_final;
			$criminal_checks['analyst_status_date'] = $analyst_status_date_final;
		}
		 
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
		/*if (count($client_docs) > 0) {
			$criminal_checks['approved_doc'] = json_encode($client_docs);
		}*/

		// criminal_checks
		// echo json_encode($criminal_checks);
		// exit();

			$this->db->where('criminal_check_id',$criminal_check_id);
		if ($this->db->update($table_name,$criminal_checks)) {
			$exception = '';
			// try{
				// if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] != '3'){
				// 	$positive_status = array('4','5','6','7','9');
				// 	if(in_array($analyst_status[$index],$positive_status)){
				// 		$componentStatus = $this->utilModel->isAnyComponentVerifiedClear($candidate_info['candidate_id']);
				// 		echo $componentStatus."</br>";
				// 		if($componentStatus == '0'){
				// 			$updateInfo = array('case_intrim_notification' => '1','client_case_intrim_notification' => '1','updated_date'=>date('d-m-Y H:i:s'));
				// 			if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$updateInfo)){
								 
				// 				$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate'));
				// 			}
							 
				// 		}	
				// 	}
				// }
			// }catch(Exception $e){
			// 	$exception = $e;
			// }



			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$criminal_checks['criminal_check_id'] = $this->input->post('criminal_check_id');
			$this->db->insert('criminal_checks_log',$criminal_checks);

			return array('status'=>'1','msg'=>'success','exception'=>$exception);
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
 
	}


	function update_remarks_candidate_civil_check($client_docs){

		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',',$this->input->post('action_status'));
		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$civil_check_id = $this->input->post('civil_check_id');
		$table_name = 'civil_check';
		$date =  date('d-m-Y H:i:s');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		} 

		$assigned_info = $this->db->select('*')->from($table_name)->where('civil_check_id',$civil_check_id)->get()->row_array();
		// return $assigned_info;
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));
		// print_r($analyst_status);
		// exit();
		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);
		$component_id =0;
		$candidate_info = $this->db->select('candidate.* ,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('civil_check_id',$civil_check_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);

		 
		
		$civil_check = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'Insuff_closure_remarks'=>$this->input->post('closure_remarks'),			
			'output_status'=>$this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0'),
			'approved_doc' =>$remarks_docs,
		); 



		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$civil_check['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$civil_check['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			 
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'1',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);

				$civil_check['analyst_status'] = $analyst_status_final;
				$civil_check['analyst_status_date'] = date('d-m-Y H:i:s');
				$civil_check['assigned_role'] = $assigned_role;
				$civil_check['assigned_team_id'] = $assigned_team_id;
				// Analyst/Specialist get notification. 
				$insuff_close_date= date('Y-m-d H:i');
				// $civil_check['insuff_close_date'] = $insuff_close_date;

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 

			}else{
				$civil_check['analyst_status'] = $analyst_status_final;
				$civil_check['analyst_status_date'] = $analyst_status_date_final;
				// echo "Analyst will get a notification.";
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$civil_check['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			$civil_check['analyst_status_date'] = $analyst_status_date_final;
			// send SMS Or Mail to Candidate.
			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$assigned_info = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}
			$candidate = $candidate_info['candidate_id']; 
			if($candidate != '' && $candidate != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}


			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			 $smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']); 
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			// $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$client_info['spoc_email_id']);

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);

		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'1',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$civil_check['insuff_team_role'] = $insuff_team_role;
				$civil_check['insuff_team_id'] = $insuff_team_id;
				$civil_check['analyst_status'] = $analyst_status_final;
				$civil_check['analyst_status_date'] = date('d-m-Y H:i:s');
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$civil_check['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$civil_check['analyst_status'] = $analyst_status_final;
				$civil_check['analyst_status_date'] = $analyst_status_date_final;
				
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
			} 
			

		}else{
			$civil_check['analyst_status'] = $analyst_status_final;
			$civil_check['analyst_status_date'] = $analyst_status_date_final;
		}
		 
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
		/*if (count($client_docs) > 0) {
			$criminal_checks['approved_doc'] = json_encode($client_docs);
		}*/

		// criminal_checks
		// echo json_encode($criminal_checks);
		// exit();

			$this->db->where('civil_check_id',$civil_check_id);
		if ($this->db->update($table_name,$civil_check)) {
			$exception = '';
			// try{
				// if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] != '3'){
				// 	$positive_status = array('4','5','6','7','9');
				// 	if(in_array($analyst_status[$index],$positive_status)){
				// 		$componentStatus = $this->utilModel->isAnyComponentVerifiedClear($candidate_info['candidate_id']);
				// 		echo $componentStatus."</br>";
				// 		if($componentStatus == '0'){
				// 			$updateInfo = array('case_intrim_notification' => '1','client_case_intrim_notification' => '1','updated_date'=>date('d-m-Y H:i:s'));
				// 			if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$updateInfo)){
								 
				// 				$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate'));
				// 			}
							 
				// 		}	
				// 	}
				// }
			// }catch(Exception $e){
			// 	$exception = $e;
			// }



			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$civil_check['civil_check_id'] = $this->input->post('civil_check_id');
			$this->db->insert('civil_check_log',$civil_check);

			return array('status'=>'1','msg'=>'success','exception'=>$exception);
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	//pending code chaking

	function update_remarks_candidate_court_record($client_docs){

		$isChanged = '0'; 
		$team_id = '';
		$qc_roles = ''; 
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',',$this->input->post('action_status'));
		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$court_records_id = $this->input->post('court_records_id');
		$table_name = 'court_records';
		$date =  date('d-m-Y H:i:s');

		$assigned_info = $this->db->select('*')->from($table_name)->where('court_records_id',$court_records_id)->get()->row_array();
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);

		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));
		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('court_records_id',$court_records_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}


		$court_record = array(
			'remarks_updateed_by_role' => $remarks_updateed_by_role,
			'remarks_updateed_by_id' => $remarks_updateed_by_id,
			'remark_address'=>$this->input->post('address'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'Insuff_closure_remarks'=>$this->input->post('closure_remarks'), 
			'output_status'=>$this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0'),
			'approved_doc'=> $remarks_docs,
			
		);


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$court_record['status'] = $inputQcStatus_final;
		}
		
		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}

		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$court_records['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst('court_records','2',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				
				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$court_record['analyst_status'] = $analyst_status_final;
				$court_record['analyst_status_date'] = $analyst_status_date_final;
				$court_record['assigned_role'] = $assigned_role;
				$court_record['assigned_team_id'] = $assigned_team_id;


				 

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$court_record['analyst_status'] = $analyst_status_final;
				$court_record['analyst_status_date'] = $analyst_status_date_final;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}	
			} 
			$this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']); 
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			// $assigned_status = explode(',', $assigned_info['status']); 
			// $court_record['status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);

			$assigned_status = explode(',', $assigned_info['analyst_status']); 
			$court_record['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			$court_record['analyst_status_date'] = $analyst_status_date_final;
			// send SMS Or Mail to Candidate.

			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{

			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'2',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);

				$court_record['analyst_status'] = $analyst_status_final;
				$court_record['analyst_status_date'] = $analyst_status_date_final;
				$court_record['insuff_team_role'] = $insuff_team_role;
				$court_record['insuff_team_id'] = $insuff_team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$court_record['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				  
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 

			}else{

				// Insuff Analyst will get a notification.
				 
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 


			}
			
				
		}else{
			$court_record['analyst_status'] = $analyst_status_final;
			$court_record['analyst_status_date'] = $analyst_status_date_final;
		}
		 
			// echo "2.0</br>";
			// $positive_status = array('4','5','6','7','9');
			// echo "2.1".$analyst_status[$index]."</br>";
			// if(in_array($analyst_status[$index],$positive_status)){
			// 	$candidate_info_tmp = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate');
			// 	if($candidate_info_tmp['case_intrim_notification'] != '1' && $candidate_info_tmp['case_intrim_notification'] != '2' && $candidate_info_tmp['client_case_intrim_notification'] != '1' && $candidate_info_tmp['client_case_intrim_notification'] != '2'){
			// 		$componentStatus = $this->utilModel->isAnyComponentVerifiedClear($candidate_info['candidate_id']);
			// 		echo "2.2".$componentStatus."</br>";
			// 		if($componentStatus == '0'){
			// 				$updateInfo = array('case_intrim_notification' => '1','client_case_intrim_notification' => '1','updated_date'=>date('d-m-Y H:i:s'));
			// 				print_r($updateInfo);
			// 				echo "2.3</br>";
			// 			if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$updateInfo)){
									 
			// 				$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate'));
			// 			}
						 
			// 		}
			// 	}	
			// } 
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}

		/*if (count($client_docs) > 0) {
			$court_record['approved_doc'] = json_encode($client_docs);
		}*/
		// print_r($court_record);
		// exit();
		 
			$this->db->where('court_records_id',$court_records_id);
		if ($this->db->update($table_name,$court_record)) {

			$exception = '';
			// try{

			// }catch(Exception $exception){
			// 	$exception = $exception;
			// }
			// if status raised 3(Insuff that time it will go message)
			
			// if($analyst_status == '3'){
			// 	$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			// }


			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$court_record['court_records_id'] = $this->input->post('court_records_id');
			$this->db->insert('court_records_log',$court_record);

			return array('status'=>'1','msg'=>'success','exception'=>$exception,'isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
 
	}
 

	function QcExists($candidate_id,$index,$table_name,$status){
		// status = single / double 
		$candidateData = $this->db->select('analyst_status,assigned_role,assigned_team_id')->from($table_name)->where('candidate_id',$candidate_id)->get()->row_array();
		// echo $candidate_id;
		if(count($candidateData) > 0){

			if($index == '0' && $status == 'single'){
    			// echo "assigned_team_id".$candidateData['assigned_team_id']."\r\n"; 
				if($candidateData['assigned_team_id'] != '0' && $candidateData['assigned_team_id'] != ''){

					return '1';
				
				}else{
				
					return '0';
				
				}
				
			}else{
				 
				$assigned_team_id = explode(',',$candidateData['assigned_team_id']);	
				$ass_team = isset($assigned_team_id[$index])?$assigned_team_id[$index]:'0';
				if(count($assigned_team_id) > 0 && $ass_team != 0 && $ass_team != ''){
					return '1';

				}else{
					return '0';
				}  
			}

		}else{
			
			return '0';

		}
		// echo json_encode($candidateData) ;
		 
	}


	function InsuffAnalystAndSpecialistExists($candidate_id,$index,$table_name,$status){
		// status = single / double 
		$candidateData = $this->db->select('insuff_status,insuff_team_role,insuff_team_id')->from($table_name)->where('candidate_id',$candidate_id)->get()->row_array();
		// echo $candidate_id;
		// echo json_encode($candidateData);
		 

		if(count($candidateData) > 0){

			if($index == '0'  && $status == 'single' ){
    	
				if($candidateData['insuff_team_id'] != '0' && $candidateData['insuff_team_id'] != ''){

					return '1';
				
				}else{
				
					return '0';
				
				}
				
			}else{
				 // echo 
				$insuffTeamId = explode(',',$candidateData['insuff_team_id']);	
		  		// print_r($insuffTeamId);
		  		// exit();
			  	if(count($insuffTeamId) > 0 && $insuffTeamId[$index] != 0 &&  $insuffTeamId[$index] != ''){
			  		
			  		return '1';

			  	}else{
			  		
			  		return '0';
			  	}
			}

		}else{
			
			return '0';

		}

		// echo json_encode($candidateData) ;
		 
	} 

	function update_remarks_candidate_permanent_address($doc){
		$index = 0;
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		$priority = $this->input->post('priority');
		$table_name = 'permanent_address';
		$permanent_address_id = $this->input->post('permanent_address_id');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		} 

		$assigned_info = $this->db->select('*')->from($table_name)->where('permanent_address_id',$permanent_address_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('permanent_address_id',$permanent_address_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();
		
		$permanent_address = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remarks_address'=>$this->input->post('address'),
			'remarks_city'=>$this->input->post('city'),
			'remarks_state'=>$this->input->post('state'),
			'staying_with'=>$this->input->post('staying_with'),
			'initiated_date'=>$this->input->post('initiated_date'),
			'verifier_name'=>$this->input->post('verifier_name'),
			'period_of_stay'=>$this->input->post('period_of_stay'),
			'progress_remarks'=>$this->input->post('progress_remarks'),
			'insuff_remarks'=>$this->input->post('infuff_remarks'),
			'assigned_to_vendor'=>$this->input->post('assigned_to_vendor'),
			'closure_date'=>$this->input->post('closure_date'),
			'relationship'=>$this->input->post('relationship'),
			'property_type'=>$this->input->post('property_type'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'closure_remarks'=>$this->input->post('closure_remarks'),
			'remarks_pincode'=>$this->input->post('pincode'),
			'iverify_or_pv_status' => $this->input->post('iverify_or_pv_type'),
			'output_status'=>'0'
			);

	
		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = $analyst_status;
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$permanent_address['status'] = '4';
		}
		

		$index = '0';

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}


		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status  == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$permanent_address['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'9',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$permanent_address['analyst_status'] = $analyst_status;
				$permanent_address['analyst_status_date'] = date('d-m-Y H:i:s');
				$permanent_address['assigned_role'] = $qc_roles['role'];
				$permanent_address['assigned_team_id'] = $team_id; 
				 

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$permanent_address['analyst_status'] = $analyst_status;
				$permanent_address['analyst_status_date'] = date('d-m-Y H:i:s');
				// Analyst will get a notification.
				 
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			$this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']); 
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			$permanent_address['analyst_status'] = $analyst_status;
			$permanent_address['analyst_status_date'] = date('d-m-Y H:i:s');
			// send SMS Or Mail to Candidate.

			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			$index = '0';  
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'9',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('is_Active','1')->where('team_id',$team_id)->get()->row_array(); 
				$permanent_address['analyst_status'] = $analyst_status;
				$permanent_address['insuff_team_role'] = $qc_roles['role'];
				$permanent_address['insuff_team_id'] = $team_id;
				$permanent_address['analyst_status_date'] = date('d-m-Y H:i:s');
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$permanent_address['insuff_created_date'] =  implode(',', $insuff_created_date);
				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
			}else{
				$permanent_address['analyst_status'] = $analyst_status;
				$permanent_address['analyst_status_date'] = date('d-m-Y H:i:s');
				// Insuff Analyst will get a notification.
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$permanent_address['insuff_created_date'] =  implode(',', $insuff_created_date);
				
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 

			} 

			

		}else{
			$permanent_address['analyst_status'] = $analyst_status;
			$permanent_address['analyst_status_date'] = date('d-m-Y H:i:s');
		}

		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}


		if (! in_array('no-file', $doc)) {
			$permanent_address['approved_doc'] = implode(',', $doc);
		}

		$this->db->where('permanent_address_id',$permanent_address_id);
		if ($this->db->update($table_name,$permanent_address)) {

			

			// if status raised 3(Insuff that time it will go message)
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$permanent_address['permanent_address_id'] = $this->input->post('permanent_address_id');

			$this->db->insert('permanent_address_log',$permanent_address);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged' => $isChanged,'exception'=>$exception);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged' => $isChanged);
		}

		// return $permanent_address;
	
	// formdata.append('permanent_address_id',permanent_address_id);
	}

	function update_remarks_candidate_present_address($doc){
		$index = 0;
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');

		$priority = $this->input->post('priority');
		$table_name = 'present_address';
		$present_address_id = $this->input->post('present_address_id');

		$assigned_info = $this->db->select('*')->from($table_name)->where('present_address_id',$present_address_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('present_address_id',$present_address_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}
		$present_address = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remarks_address'=>$this->input->post('address'),
			'remarks_city'=>$this->input->post('city'),
			'remarks_state'=>$this->input->post('state'),
			'staying_with'=>$this->input->post('staying_with'),
			'initiated_date'=>$this->input->post('initiated_date'),
			'verifier_name'=>$this->input->post('verifier_name'),
			'period_of_stay'=>$this->input->post('period_of_stay'),
			'progress_remarks'=>$this->input->post('progress_remarks'),
			'insuff_remarks'=>$this->input->post('infuff_remarks'),
			'assigned_to_vendor'=>$this->input->post('assigned_to_vendor'),
			'closure_date'=>$this->input->post('closure_date'),
			'relationship'=>$this->input->post('relationship'),
			'property_type'=>$this->input->post('property_type'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'closure_remarks'=>$this->input->post('closure_remarks'),
			'remarks_pincode'=>$this->input->post('pincode'),
			'iverify_or_pv_status' => $this->input->post('iverify_or_pv_type'),
			'output_status'=>'0'
		); 



		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status)?$analyst_status:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$present_address['status'] = '4';
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$index = '0';
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$present_address['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			$index = '0';
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'8',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$present_address['analyst_status'] = $analyst_status;
				$present_address['analyst_status_date'] = date('d-m-Y H:i:s');
				$present_address['assigned_role'] = $qc_roles['role'];
				$present_address['assigned_team_id'] = $team_id; 
				$insuff_close_date  = date('Y-m-d H:i');
				// $present_address['insuff_close_date'] =  $insuff_close_date;

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				 
				$present_address['analyst_status'] = $analyst_status;
				$present_address['analyst_status_date'] = date('d-m-Y H:i:s');
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			$present_address['analyst_status'] = $analyst_status;
			$present_address['analyst_status_date'] = date('d-m-Y H:i:s');
			$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$present_address['insuff_created_date'] =  implode(',', $insuff_created_date);
			// send SMS Or Mail to Candidate.

			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			 $index = '0';
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'8',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$present_address['analyst_status'] = $analyst_status;
				$present_address['analyst_status_date'] = date('d-m-Y H:i:s');
				$present_address['insuff_team_role'] = $qc_roles['role'];
				$present_address['insuff_team_id'] = $team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$present_address['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{
				$present_address['analyst_status'] = $analyst_status;
				$present_address['analyst_status_date'] = date('d-m-Y H:i:s');
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}else{
			$present_address['analyst_status'] = $analyst_status;
			$present_address['analyst_status_date'] = date('d-m-Y H:i:s');
		}

		// echo json_encode($present_address);
		// exit();

		if (! in_array('no-file', $doc)) {
			$present_address['approved_doc'] = implode(',', $doc);
		}
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}

			$this->db->where('present_address_id',$present_address_id);
		if ($this->db->update($table_name,$present_address)) {

			
			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$present_address['present_address_id'] = $this->input->post('present_address_id');
			$this->db->insert('present_address_log',$present_address);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged' => $isChanged,'exception'=>$exception);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged' => $isChanged);
		}

		// return $permanent_address;
	
	// formdata.append('permanent_address_id',permanent_address_id);
	}

	function update_remarks_candidate_previous_address($client_docs){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(",",$this->input->post('action_status'));

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$previos_address_id = $this->input->post('previos_address_id');
		$table_name = 'previous_address';
		$date =  date('d-m-Y H:i:s');

		$assigned_info = $this->db->select('*')->from($table_name)->where('previos_address_id',$previos_address_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('previos_address_id',$previos_address_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('previos_address_id',$previos_address_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();


			$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}
		$previous_address = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remarks_address'=>$this->input->post('address'),
			'remarks_city'=>$this->input->post('city'),
			'remarks_state'=>$this->input->post('state'),
			'staying_with'=>$this->input->post('staying_with'),
			'initiated_date'=>$this->input->post('initiated_date'),
			'verifier_name'=>$this->input->post('verifier_name'),
			'period_of_stay'=>$this->input->post('period_of_stay'),
			'progress_remarks'=>$this->input->post('progress_remarks'),
			'insuff_remarks'=>$this->input->post('infuff_remarks'),
			'assigned_to_vendor'=>$this->input->post('assigned_to_vendor'),
			'closure_date'=>$this->input->post('closure_date'),
			'relationship'=>$this->input->post('relationship'),
			'property_type'=>$this->input->post('property_type'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'closure_remarks'=>$this->input->post('closure_remarks'),
			'remarks_pincode'=>$this->input->post('pincode'),
			'iverify_or_pv_status' => $this->input->post('iverify_or_pv_status'),
			'analyst_status'=>$analyst_status_final,
			'analyst_status_date' => $analyst_status_date_final,
			'output_status'=>$this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0'),
			'approved_doc'=>$remarks_docs,
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$previous_address['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$previous_address['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'12',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,isset($qc_roles['role'])?$qc_roles['role']:'specialist');
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$previous_address['assigned_role'] = $assigned_role;
				$previous_address['assigned_team_id'] = $assigned_team_id;
				 

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			$this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']); 
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$previous_address['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			
			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'12',$priority);
				 $qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,isset($qc_roles['role'])?$qc_roles['role']:'specialist');
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$previous_address['insuff_team_role'] = $insuff_team_role;
				$previous_address['insuff_team_id'] = $insuff_team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$previous_address['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 

			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}
		 
		/*
		if (count($client_docs) > 0) {
			$previous_address['approved_doc'] = json_encode($client_docs);
		}*/
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}

			$this->db->where('previos_address_id',$this->input->post('previos_address_id'));
		if ($this->db->update('previous_address',$previous_address)) {
			
			 
			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 
			$present_address['previos_address_id'] = $this->input->post('previos_address_id');
			$this->db->insert('previous_address_log',$previous_address);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged,'exception'=>$exception);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

		// return $permanent_address;
	
	
	}

	function update_remarks_current_employment($client_docs){
		$index = 0;
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		$current_emp_id = $this->input->post('current_emp_id');
		$priority = $this->input->post('priority');
		$table_name = 'current_employment';
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}


		$assigned_info = $this->db->select('*')->from($table_name)->where('current_emp_id',$current_emp_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('current_emp_id',$current_emp_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();


		$current_employment = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remarks_emp_id'=>$this->input->post('remarks_emp_id'),
			'remarks_designation'=>$this->input->post('remarks_designation'),
			'remark_department'=>$this->input->post('remark_department'),
			'remark_date_of_joining'=>$this->input->post('remark_date_of_joining'),
			'remark_date_of_relieving'=>$this->input->post('remark_date_of_relieving'),
			'remark_salary_lakhs'=>$this->input->post('remark_salary_lakhs'),
			'remark_currency'=>$this->input->post('remark_currency'),
			'remark_managers_designation'=>$this->input->post('remark_managers_designation'),
			'remark_managers_contact'=>$this->input->post('remark_managers_contact'),
			'remark_physical_visit'=>$this->input->post('remark_physical_visit'),
			'remark_hr_name'=>$this->input->post('remark_hr_name'),
			'remark_hr_email'=>$this->input->post('remark_hr_email'),
			'remark_hr_phone_no'=>$this->input->post('remark_hr_phone_no'),
			'remark_reason_for_leaving'=>$this->input->post('remark_reason_for_leaving'),
			'remark_eligible_for_re_hire'=>$this->input->post('remark_eligible_for_re_hire'),
			'remark_attendance_punctuality'=>$this->input->post('remark_attendance_punctuality'), 
			'remark_job_performance'=>$this->input->post('remark_job_performance'), 
			'remark_exit_status'=>$this->input->post('remark_exit_status'), 
			'remark_disciplinary_issues'=>$this->input->post('remark_disciplinary_issues'), 
			'verification_fee'=>$this->input->post('verification_fee'), 
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'), 
			'Insuff_remarks'=>$this->input->post('Insuff_remarks'), 
			'Insuff_closure_remarks'=>$this->input->post('Insuff_closure_remarks'),
			'in_progress_remarks'=>$this->input->post('in_progress_remarks'),
			'analyst_status'=>$analyst_status,
			'analyst_status_date' =>date('d-m-Y H:i:s'),
			'output_status'=>'0'
		);


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status)?$analyst_status:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$current_employment['status'] = 4;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$index = '0';	
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$current_employment['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			$index = '0';
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'6',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				 
				$current_employment['assigned_role'] = isset($qc_roles['role'])?$qc_roles['role']:'0';
				$current_employment['assigned_team_id'] = isset($team_id)?$team_id:'0'; 
				$insuff_close_date  = date('Y-m-d H:i');
				// $current_employment['insuff_close_date'] = $insuff_close_date;

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{ 
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			// $permanent_address['analyst_status'] = $analyst_status;
			
			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			$index = '0';
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'6',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();  

				$current_employment['insuff_team_role'] = isset($qc_roles['role'])?$qc_roles['role']:'0';
				$current_employment['insuff_team_id'] = isset($team_id)?$team_id:'0';
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$current_employment['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$current_employment['analyst_status'] = $analyst_status;
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}else{
			$current_employment['analyst_status'] = $analyst_status;
		}

		if (count($client_docs) > 0 && !in_array('no-file', $client_docs)) {
			$current_employment['approved_doc'] = implode(',',$client_docs);
		} 

		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
		// echo json_encode($current_employment);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('current_employment',$current_employment)) {

			 

			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$current_employment['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('current_employment_log',$current_employment);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged,'exception'=>$exception);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}

	function update_remarks_previous_employment($client_docs){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',', $this->input->post('analyst_status'));

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$previous_emp_id = $this->input->post('previous_emp_id');
		$table_name = 'previous_employment';
		$date =  date('d-m-Y H:i:s');


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}


		$assigned_info = $this->db->select('*')->from($table_name)->where('previous_emp_id',$previous_emp_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('previous_emp_id',$previous_emp_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();
		// print_r($index);
		// exit();
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('previous_emp_id',$previous_emp_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		// echo "Fee : ".$this->input->post('verification_fee');
		$previous_employment = array(
		 
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remarks_emp_id'=>$this->input->post('remarks_emp_id'),
			'remarks_designation'=>$this->input->post('remarks_designation'),
			'remark_department'=>$this->input->post('remark_department'),
			'remark_date_of_joining'=>$this->input->post('remark_date_of_joining'),
			'remark_date_of_relieving'=>$this->input->post('remark_date_of_relieving'),
			'remark_salary_lakhs'=>$this->input->post('remark_salary_lakhs'),
			'remark_currency'=>$this->input->post('currency'),
			'remark_salary_type'=>$this->input->post('remark_salary_type'),
			'remark_managers_designation'=>$this->input->post('remark_managers_designation'),
			'remark_managers_contact'=>$this->input->post('remark_managers_contact'),
			'remark_physical_visit'=>$this->input->post('remark_physical_visit'),
			'remark_hr_name'=>$this->input->post('remark_hr_name'),
			'remark_hr_email'=>$this->input->post('remark_hr_email'),
			'remark_hr_phone_no'=>$this->input->post('remark_hr_phone_no'),
			'remark_reason_for_leaving'=>$this->input->post('remark_reason_for_leaving'),
			'remark_eligible_for_re_hire'=>$this->input->post('remark_eligible_for_re_hire'),
			'remark_attendance_punctuality'=>$this->input->post('remark_attendance_punctuality'), 
			'remark_job_performance'=>$this->input->post('remark_job_performance'), 
			'remark_exit_status'=>$this->input->post('remark_exit_status'), 
			'remark_disciplinary_issues'=>$this->input->post('remark_disciplinary_issues'), 
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'), 
			'Insuff_remarks'=>$this->input->post('Insuff_remarks'), 
			'Insuff_closure_remarks'=>$this->input->post('Insuff_closure_remarks'),
			'verification_fee'=>$this->input->post('verification_fee'), 
			'in_progress_remarks'=>$this->input->post('in_progress_remarks'), 
			'output_status'=>$this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0'),
			'approved_doc'=>$remarks_docs,
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$previous_employment['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$previous_employment['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'10',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$previous_employment['assigned_role'] = $assigned_role;
				$previous_employment['assigned_team_id'] = $assigned_team_id;
				$previous_employment['analyst_status'] =  $analyst_status_final;
				$previous_employment['analyst_status_date'] =  $analyst_status_date_final;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $previous_employment['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 

				$previous_employment['analyst_status'] =  $analyst_status_final;
				$previous_employment['analyst_status_date'] =  $analyst_status_date_final;
			} 
			$this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']); 
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$previous_employment['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			
			$previous_employment['analyst_status_date'] =  $analyst_status_date_final;
			$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$previous_employment['insuff_created_date'] =  implode(',', $insuff_created_date);
			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);

			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'10',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$previous_employment['insuff_team_role'] = $insuff_team_role;
				$previous_employment['insuff_team_id'] = $insuff_team_id;
				$previous_employment['analyst_status'] =  $analyst_status_final;
				$previous_employment['analyst_status_date'] =  $analyst_status_date_final;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$previous_employment['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;

				 $raised_by_team_ids = $this->session->userdata('logged-in-analyst');
				if ($this->session->userdata('logged-in-analyst')) {
					$raised_by_team_ids = $this->session->userdata('logged-in-analyst');
				}else{
					$raised_by_team_ids = $this->session->userdata('logged-in-specialist');
				} 

				 
				$message = "Insuff is genrated from analyst."; 
				if($component_status != '' && $component_status != null && $raised_by_team_ids['team_id'] !=null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_ids['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{

				// Insuff Analyst will get a notification.
				// code is yet to be done.
				// echo '<br>! 3 else Role: '.$role;
				$previous_employment['analyst_status'] =  $analyst_status_final;
				$previous_employment['analyst_status_date'] =  $analyst_status_date_final;

				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 

		}else{
			$previous_employment['analyst_status'] =  $analyst_status_final;
			$previous_employment['analyst_status_date'] =  $analyst_status_date_final;

			$team_id = explode(',',$assigned_info['insuff_team_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $team_id;
			$raised_by_team_id = $fs_emp_data;
			$message = "Insuff is genrated from analyst.";

			if($component_status != '' && $component_status != null){

				$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
			}else{
				return array('status'=>'0','msg'=>'failled');
			}
		}

		// echo json_encode($previous_employment);
		// exit();
		/*if (count($client_docs) > 0) {
			$previous_employment['approved_doc'] = json_encode($client_docs);
		} */
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
		
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('previous_employment',$previous_employment)) {

			 


			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$present_address['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('previous_employment_log',$previous_employment);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}

	function update_landlord_reference($client_docs){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',',$this->input->post('analyst_status'));

		// return $analyst_status

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$landload_id = $this->input->post('landload_id');
		$table_name = 'landload_reference';
		$date =  date('d-m-Y H:i:s');

		$assigned_info = $this->db->select('*')->from($table_name)->where('landload_id',$landload_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('landload_id',$landload_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);

		// return $remarks_docs;

		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);

		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);
		
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('landload_id',$landload_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}


		$reference_remark_data = array(
 
			'tenancy_period'=>$this->input->post('tenancy_period'), 
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
			'complaints_from_neighbors_comment'=>$this->input->post('complaints_from_neighbors_comment'),

			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'), 
			'insuff_remarks'=>$this->input->post('insuff_remarks'), 
			'verification_remarks'=>$this->input->post('verification_remarks'), 
			'verified_date'=>$this->input->post('verified_date'),
			'verified_by'=>$this->input->post('verified_by'), 
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'analyst_status'=>$analyst_status_final,
			'analyst_status_date'=>$analyst_status_date_final,
			'approved_doc' => $remarks_docs,
			'output_status' => $this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0')
		);


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$reference_remark_data['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}

		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$reference_remark_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'11',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$reference_remark_data['assigned_role'] = $assigned_role;
				$reference_remark_data['assigned_team_id'] = $assigned_team_id;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $reference_remark_data['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){

			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}


			}
			// echo '<br>3 Role: '.$role;
			// $assigned_status = explode(',', $assigned_info['status']); 
			// $court_record['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'11',$priority,'double');
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$reference_remark_data['insuff_team_role'] = $insuff_team_role;
				$reference_remark_data['insuff_team_id'] = $insuff_team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$reference_remark_data['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}

		/*if (count($client_docs) > 0) {
			$reference_remark_data['approved_doc'] = json_encode($client_docs);
		}  */

		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
		// print_r($reference_remark_data);
		// echo json_encode($reference_remark_data);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('landload_reference',$reference_remark_data)) {

			 
			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 
			
			$reference_remark_data['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('landload_reference_log',$reference_remark_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}

	function update_reference($client_docs){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',',$this->input->post('analyst_status'));

		// return $analyst_status

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$reference_id = $this->input->post('reference_id');
		$table_name = 'reference';
		$date =  date('d-m-Y H:i:s');

		$assigned_info = $this->db->select('*')->from($table_name)->where('reference_id',$reference_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('reference_id',$reference_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);

		// return $remarks_docs;

		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);

		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);
		
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('reference_id',$reference_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}


		$reference_remark_data = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'roles_responsibilities'=>$this->input->post('role_responsibility'),
			'professional_strengths'=>$this->input->post('professional_strengths'),
			'attendance_punctuality'=>$this->input->post('attendance'),
			'mode_exit'=>$this->input->post('mode_of_exit'),
			'communication_skills'=>$this->input->post('communication'),
			'work_attitude'=>$this->input->post('attitude'),
			'honesty_reliability'=>$this->input->post('reliability'),
			'target_orientation'=>$this->input->post('orientation'),
			'people_management'=>$this->input->post('management'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'projects_handled'=>$this->input->post('project_handled'),
			'professional_weakness'=>$this->input->post('professional_weakness'),
			'accomplishments'=>$this->input->post('accomplishments'),
			'job_performance'=>$this->input->post('job_performance'),
			'integrity'=>$this->input->post('integrity'),
			'leadership_quality'=>$this->input->post('quality'), 
			'pressure_handling_nature'=>$this->input->post('pressure'), 
			'team_player'=>$this->input->post('player'), 
			'additional_comments'=>$this->input->post('additional_comments'), 
			'insuff_remarks'=>$this->input->post('insuff_remarks'), 
			'verification_remarks'=>$this->input->post('verification_remarks'), 
			'verified_date'=>$this->input->post('verified_date'),
			'verified_by'=>$this->input->post('verified_by'), 
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'analyst_status'=>$analyst_status_final,
			'analyst_status_date'=>$analyst_status_date_final,
			'approved_doc' => $remarks_docs,
			'output_status' => $this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0')
		);


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$reference_remark_data['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$reference_remark_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'11',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$reference_remark_data['assigned_role'] = $assigned_role;
				$reference_remark_data['assigned_team_id'] = $assigned_team_id;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $reference_remark_data['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){

			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}


			}
			// echo '<br>3 Role: '.$role;
			// $assigned_status = explode(',', $assigned_info['status']); 
			// $court_record['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'11',$priority,'double');
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$reference_remark_data['insuff_team_role'] = $insuff_team_role;
				$reference_remark_data['insuff_team_id'] = $insuff_team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$reference_remark_data['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}

		/*if (count($client_docs) > 0) {
			$reference_remark_data['approved_doc'] = json_encode($client_docs);
		}  */

		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
		// print_r($reference_remark_data);
		// echo json_encode($reference_remark_data);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('reference',$reference_remark_data)) {

			 
			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 
			
			$reference_remark_data['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('reference_log',$reference_remark_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}

	function update_globalDb($client_docs){
		$index = 0;
		$isChanged = '0';
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		$globaldatabase_id = $this->input->post('globaldatabase_id');
		$priority = $this->input->post('priority');
		$table_name = 'globaldatabase';
		$permanent_address_id = $this->input->post('permanent_address_id');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$assigned_info = $this->db->select('*')->from($table_name)->where('globaldatabase_id',$globaldatabase_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('globaldatabase_id',$globaldatabase_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$global_db = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status_date' => date('d-m-Y H:i:s'),
			'output_status'=>'0'
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status)?$analyst_status:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$global_db['status'] = 4;
		}

		// print_r($assigned_info);
		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$index = '0';
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$global_db['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			$index = '0';
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'5',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$global_db['analyst_status'] = $analyst_status;
				$global_db['assigned_role'] = $qc_roles['role'];
				$global_db['assigned_team_id'] = $team_id;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $global_db['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$global_db['analyst_status'] = $analyst_status;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			$global_db['analyst_status'] = $analyst_status;
				

			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			 $index='0';
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'5',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$global_db['analyst_status'] = $analyst_status;
				$global_db['insuff_team_role'] = $qc_roles['role'];
				$global_db['insuff_team_id'] = $team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$global_db['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{
				$global_db['analyst_status'] = $analyst_status;
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}else{
			$global_db['analyst_status'] = $analyst_status;
		}

		if (count($client_docs) > 0) {
			$global_db['approved_doc'] = implode(',',$client_docs);
		}  

		// print_r($reference_remark_data);
		// echo json_encode($global_db);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('globaldatabase',$global_db)) {
			 
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$global_db['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('globaldatabase_log',$global_db);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}




	function update_social_remarks($client_docs){
		$index = 0;
		$isChanged = '0';
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		$social_id = $this->input->post('social_id');
		$priority = $this->input->post('priority');
		$table_name = 'social_media';
		$permanent_address_id = $this->input->post('social_id');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$assigned_info = $this->db->select('*')->from($table_name)->where('social_id',$social_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('social_id',$social_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$social_media = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status_date' => date('d-m-Y H:i:s'),
			'output_status'=>'0'
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status)?$analyst_status:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$social_media['status'] = 4;
		}

		// print_r($assigned_info);
		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$index = '0';
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$social_mediai['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			$index = '0';
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'5',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$social_media['analyst_status'] = $analyst_status;
				$social_media['assigned_role'] = isset($qc_roles['role'])?$qc_roles['role']:'0';
				$social_media['assigned_team_id'] = isset($team_id)?$team_id:'0';
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $social_media['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$social_media['analyst_status'] = $analyst_status;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			$this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']); 
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			$social_media['analyst_status'] = $analyst_status;
				

			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			 $index='0';
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'5',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$social_media['analyst_status'] = $analyst_status;
				$social_media['insuff_team_role'] = isset($qc_roles['role'])?$qc_roles['role']:'0';
				$social_media['insuff_team_id'] = isset($team_id)?$team_id:'0';
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$social_media['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{
				$social_media['analyst_status'] = $analyst_status;
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}else{
			$social_media['analyst_status'] = $analyst_status;
		}

		if (count($client_docs) > 0) {
			$social_media['approved_doc'] = implode(',',$client_docs);
		}  

		// print_r($reference_remark_data);
		// echo json_encode($social_media);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('social_media',$social_media)) {
			 
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$social_media['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('social_media_log',$social_media);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}

	function remarkForDrugTest($client_docs){

		$isChanged = '0';

		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',',$this->input->post('action_status'));
		
		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$drugtest_id = $this->input->post('drugtest_id');
		$table_name = 'drugtest';
		$date =  date('d-m-Y H:i:s');


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		// print_r($this->input->post('action_status'));
		$assigned_info = $this->db->select('*')->from($table_name)->where('drugtest_id',$drugtest_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('drugtest_id',$drugtest_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();
		$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();

		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		// echo "assigned_info: ";
		// print_r($assigned_info);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);

		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		// print_r($analyst_status);
		// echo "\nindex:"; 
		// print_r($index);
		// echo "\nanalyst_status index:";
		// print_r($analyst_status[$index]);
		// exit;
		// return $analyst_status[$index];


		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,isset($analyst_status[$index])?$analyst_status[$index]:'0');
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);

		// print_r($analyst_status);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('drugtest_id',$drugtest_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$drugTest_db = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status'=>$analyst_status_final,
			'analyst_status_date' => $analyst_status_date_final,
			'output_status'=>$this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0'),
			'approved_doc'=>$remarks_docs,
		);



		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$drugTest_db['status'] = $inputQcStatus_final;
		}
		/*if (count($client_docs) > 0 && !in_array('no-file', $client_docs)) {
			$drugTest_db['approved_doc'] = json_encode($client_docs);
		}  */

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}

		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$drugTest_db['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'4',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$drugTest_db['assigned_role'] = $assigned_role;
				$drugTest_db['assigned_team_id'] = $assigned_team_id;
				


				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			// $assigned_status = explode(',', $assigned_info['status']); 
			// $court_record['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			
			// send SMS Or Mail to Candidate.

			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}
			
			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			/// send SMS Or Mail to Candidate.

			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$assigned_info['first_name'],$table_name,$insuff_remarks,$assigned_info['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

  			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && isset($analyst_status[$index])?$analyst_status[$index]:'0' == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'4',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				$qc_roles = isset($qc_roles['role']) ? $qc_roles['role'] : '';

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$drugTest_db['insuff_team_role'] = $insuff_team_role;
				$drugTest_db['insuff_team_id'] = $insuff_team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$drugTest_db['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}

		/*print_r($drugTest_db); 
		exit();*/
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('drugtest',$drugTest_db)) {

			 

			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$drugTest_db['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('drugtest_log',$drugTest_db);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}


	function get_remarks_docs($index,$analyst_status,$remark_docs,$approved_doc=''){

		// echo "\r\n || index : ".$index."||";
		// echo "\r\n || analyst_status : ".print_r($analyst_status);
		// echo "\r\n || client_docs: ".print_r($client_docs);
		// echo "\r\n || approved_doc: ".print_r($assigned_info['approved_doc']);
		$docs = array();
		$approved_docs = '';
		if ($approved_doc !='') {
			$approved_docs = json_decode($approved_doc,true);
		}
		foreach ($analyst_status as $key => $val) {
			$row = '';
			 if ($key == $index) {
			 	if (! in_array('no-file', $remark_docs)) {
			 		$row = $remark_docs;
			 	}else{
			 		$row = isset($approved_docs[$key])?$approved_docs[$key]:array('no-file');
			 	}
			 }else{
			 	$row = isset($approved_docs[$key])?$approved_docs[$key]:array('no-file');
			 }
			array_push($docs, $row);
		}

		return json_encode($docs);

	}

	function remarkForDocuemtCheck($remark_docs){
		 
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',',$this->input->post('action_status'));

		// return $analyst_status;


		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$document_check_id = $this->input->post('document_check_id');
		$table_name = 'document_check';


		$assigned_info = $this->db->select('*')->from($table_name)->where('document_check_id',$document_check_id)->get()->row_array();
		 

		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$remark_docs,$assigned_info['approved_doc']);

		// return $remarks_docs;

        $remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
        $remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);

        $date =  date('d-m-Y H:i:s');
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);
        $remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
        $remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

        $analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);

        $candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('document_check_id',$document_check_id)->get()->row_array();
        $client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}
 		
 		$address = $this->input->post('address');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$pincode = $this->input->post('pincode');
		$in_progress_remark = $this->input->post('in_progress_remark');
		$verification_remarks = $this->input->post('verification_remarks');
		$insuff_remarks = $this->input->post('insuff_remarks');
		$insuff_closer_remark = $this->input->post('insuff_closer_remark');
	 
		 
		$doc_data = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$address,
			'remark_city'=>$city,
			'remark_state'=>$state,
			'remark_pin_code'=>$pincode,
			'in_progress_remarks'=>$in_progress_remark,
			'verification_remarks'=>$verification_remarks,
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$insuff_remarks,
			'insuff_closure_remarks'=>$insuff_closer_remark,
			'analyst_status'=>$analyst_status_final,
			'analyst_status_date'=> $analyst_status_date_final,
			'output_status'=>$this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0'),
			'approved_doc'=> $remarks_docs,
		);


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$doc_data['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$doc_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
             
            if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

                $team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst('document_check','3',$priority);
                $qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

                $assigned_role = explode(',', $assigned_info['assigned_role']);
                $assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
                
                $assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
                $assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
                
                 
                $doc_data['assigned_role'] = $assigned_role;
                $doc_data['assigned_team_id'] = $assigned_team_id;
                $insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $doc_data['insuff_close_date'] =  implode(',', $insuff_close_date);

                $component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 

            }else{
                // Analyst will get a notification.
                $team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

            } 
             $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
        }else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
            // $assigned_status = explode(',', $assigned_info['analyst_status']); 
            // $doc_data['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
            
            // send SMS Or Mail to Candidate.

        	if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
            // send SMS Or Mail to Candidate.

			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_info['first_name'],$table_name,$insuff_remarks,$candidate_info['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

        }else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
            // echo '<br>! 3 Role: '.$role;
            // echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
             
            if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

                $team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'3',$priority);
                $qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


                $insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
                $insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
                

                $insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
                $insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
 
                $doc_data['insuff_team_role'] = $insuff_team_role;
                $doc_data['insuff_team_id'] = $insuff_team_id;
                $insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$doc_data['insuff_created_date'] =  implode(',', $insuff_created_date);

                // Insuff Analyst will get a notification.
            	 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
					 $raised_by_team_id = $this->session->userdata('logged-in-analyst');
				if ($this->session->userdata('logged-in-analyst')) {
					$raised_by_team_id = $this->session->userdata('logged-in-analyst');
				}else{
					$raised_by_team_id = $this->session->userdata('logged-in-specialist');
				} 
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
            }else{

                // Insuff Analyst will get a notification.
                $team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
					 $raised_by_team_id = $this->session->userdata('logged-in-analyst');
				if ($this->session->userdata('logged-in-analyst')) {
					$raised_by_team_id = $this->session->userdata('logged-in-analyst');
				}else{
					$raised_by_team_id = $this->session->userdata('logged-in-specialist');
				} 
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

            }
 

        } 
		// echo json_encode($doc_data);
		// exit();
		// $doc = array();
		// if (count($aadhar) > 0 && !in_array('no-file', $aadhar)) {
		// 	$doc['aadhar'] = implode(',',$aadhar);
		// }  

		// if (count($pan) > 0 && !in_array('no-file', $pan)) {
		// 	$doc['pan'] = implode(',',$pan);
		// }  

		// if (count($client_docs) > 0 && !in_array('no-file', $client_docs)) {
		// 	$doc['passport'] = implode(',',$client_docs);
		// }  
		// if (count($doc) > 0) { 
		// $doc_data['approved_doc'] = json_encode($doc);
		// }


		// return $doc_data;
		// print_r($doc_data);
		// echo json_encode($doc_data);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('document_check',$doc_data)) {

			 
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$doc_data['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('document_check_log',$doc_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}

	function remarkForEduCheck($client_docs){
		$isChanged='0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',',$this->input->post('analyst_status'));

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$education_details_id = $this->input->post('education_details_id');
		$table_name = 'education_details';

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$assigned_info = $this->db->select('*')->from($table_name)->where('education_details_id',$education_details_id)->get()->row_array();

		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);

		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$date =  date('d-m-Y H:i:s');
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);
		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('education_details_id',$education_details_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$eduData= array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_roll_no'=>$this->input->post('roll_number'),
			'remark_type_of_dgree'=>$this->input->post('type_of_degree'),
			'remark_institute_name'=>$this->input->post('institute_name'),
			'remark_university_name'=>$this->input->post('university_name'),
			'remark_year_of_graduation'=>$this->input->post('year_of_education'),
			'remark_result'=>$this->input->post('result_grade'),
			'remark_verifier_name'=>$this->input->post('verifier_name'),
			'remark_verifier_designation'=>$this->input->post('verifier_designation'),
			'remark_verifier_contact'=>$this->input->post('verifier_contact'),
			'remark_verifier_email'=>$this->input->post('verifier_email'),
			'remark_physical_visit'=>$this->input->post('physical_visit'),
			'verification_remarks'=>$this->input->post('verifier_remark'),
			'verified_date'=>$this->input->post('verified_date'),
			'verification_fee'=>$this->input->post('verifier_fee'),
			'in_progress_remarks'=>$this->input->post('progress_remark'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'analyst_status'=>$analyst_status_final,
			'analyst_status_date'=> $analyst_status_date_final,
			'output_status'=>$this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0'),
			'approved_doc'=>$remarks_docs,
		);


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$eduData['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$eduData['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'7',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$eduData['assigned_role'] = $assigned_role;
				$eduData['assigned_team_id'] = $assigned_team_id;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $eduData['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 

			}else{
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			$this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']); 
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			// $assigned_status = explode(',', $assigned_info['status']); 
			// $eduData['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			
			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			
			// send SMS Or Mail to Candidate.
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			 $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			 if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}


		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'7',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$eduData['insuff_team_role'] = $insuff_team_role;
				$eduData['insuff_team_id'] = $insuff_team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$eduData['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
					 $raised_by_team_id = $this->session->userdata('logged-in-analyst');
				if ($this->session->userdata('logged-in-analyst')) {
					$raised_by_team_id = $this->session->userdata('logged-in-analyst');
				}else{
					$raised_by_team_id = $this->session->userdata('logged-in-specialist');
				} 
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}

		 
		$this->db->where('candidate_id',$this->input->post('candidate_id')); 
		if ($this->db->update('education_details',$eduData)) {

			try{
				$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);
			}catch(Exception $exception){

			}

			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$eduData['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('education_details_log',$eduData);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}


	function update_remarks_directorship_check($client_docs){
		// var_dump($_POST);
		// exit();
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',', $this->input->post('action_status'));

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$directorship_check_id = $this->input->post('directorship_check_id');
		$table_name = 'directorship_check';


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}



		$assigned_info = $this->db->select('*')->from($table_name)->where('directorship_check_id',$directorship_check_id)->get()->row_array();
		// print_r($index);
		// exit();
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$date =  date('d-m-Y H:i:s');
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);
		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('directorship_check_id',$directorship_check_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		// echo "Fee : ".$this->input->post('verification_fee');
		$directorship_check_data = array(
		 
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'approved_doc'=>$remarks_docs,
			'analyst_status_date'=> $analyst_status_date_final,
			'output_status' => $this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0')
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$directorship_check_data['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}

		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			 
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'14',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$directorship_check_data['assigned_role'] = $assigned_role;
				$directorship_check_data['assigned_team_id'] = $assigned_team_id;
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$directorship_check_data['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			

			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}
			// send SMS Or Mail to Candidate.

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

  			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'14',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$directorship_check_data['insuff_team_role'] = $insuff_team_role;
				$directorship_check_data['insuff_team_id'] = $insuff_team_id;
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 

				$directorship_check_data['analyst_status'] =  $analyst_status_final;
			} 

		}else{
			$directorship_check_data['analyst_status'] =  $analyst_status_final;
		}
		// print_r($directorship_check_data);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update($table_name,$directorship_check_data)) {

		 
			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$present_address['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert($table_name.'_log',$directorship_check_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}


	function update_remarks_global_sanctions_aml($client_docs){
		// var_dump($_POST);
		// exit();
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',', $this->input->post('action_status'));

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$global_sanctions_aml_id = $this->input->post('global_sanctions_aml_id');
		$table_name = 'global_sanctions_aml';


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}



		$assigned_info = $this->db->select('*')->from($table_name)->where('global_sanctions_aml_id',$global_sanctions_aml_id)->get()->row_array();
		
		 
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$date =  date('d-m-Y H:i:s');
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);
		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('global_sanctions_aml_id',$global_sanctions_aml_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		// echo "Fee : ".$this->input->post('verification_fee');
		$directorship_check_data = array(
		 
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'approved_doc'=>$remarks_docs,
			'analyst_status_date'=> $analyst_status_date_final,
			'output_status' => $this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0')
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$directorship_check_data['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			 
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'15',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$directorship_check_data['assigned_role'] = $assigned_role;
				$directorship_check_data['assigned_team_id'] = $assigned_team_id;
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$directorship_check_data['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			

			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name); 
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

  			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'15',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$directorship_check_data['insuff_team_role'] = $insuff_team_role;
				$directorship_check_data['insuff_team_id'] = $insuff_team_id;
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
			} 

		}else{
			$directorship_check_data['analyst_status'] =  $analyst_status_final;
		}
		// print_r($directorship_check_data);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update($table_name,$directorship_check_data)) {

			 
			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$present_address['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert($table_name.'_log',$directorship_check_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}

	function update_remarks_adverse_database_media_check($client_docs){
		// var_dump($_POST);
		// exit();
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',', $this->input->post('action_status'));

		$priority = $this->input->post('priority');
		$index = '0';
		$adverse_database_media_check_id = $this->input->post('adverse_database_media_check_id');
		$table_name = 'adverse_database_media_check';


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}



		$assigned_info = $this->db->select('*')->from($table_name)->where('adverse_database_media_check_id',$adverse_database_media_check_id)->get()->row_array();
		
		 
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$date =  date('d-m-Y H:i:s');
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);
		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('adverse_database_media_check_id',$adverse_database_media_check_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		// echo "Fee : ".$this->input->post('verification_fee');
		$directorship_check_data = array(
		 
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'approved_doc'=>$remarks_docs,
			'analyst_status_date'=> $analyst_status_date_final,
			'output_status' => $this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0')
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$directorship_check_data['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			 
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'19',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$directorship_check_data['assigned_role'] = $assigned_role;
				$directorship_check_data['assigned_team_id'] = $assigned_team_id;
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$directorship_check_data['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			

			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}


			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name); 
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

  			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'19',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$directorship_check_data['insuff_team_role'] = $insuff_team_role;
				$directorship_check_data['insuff_team_id'] = $insuff_team_id;
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
			} 

		}else{
			$directorship_check_data['analyst_status'] =  $analyst_status_final;
		}
		// print_r($directorship_check_data);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update($table_name,$directorship_check_data)) {
 
			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$present_address['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert($table_name.'_log',$directorship_check_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}


	function update_remarks_health_checkup($client_docs){
		// var_dump($_POST);
		// exit();
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',', $this->input->post('action_status'));

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$health_checkup_id = $this->input->post('health_checkup_id');
		$table_name = 'health_checkup';


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}



		$assigned_info = $this->db->select('*')->from($table_name)->where('health_checkup_id',$health_checkup_id)->get()->row_array();
		
		 
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);

		$date =  date('d-m-Y H:i:s');
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);

		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('health_checkup_id',$health_checkup_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		// echo "Fee : ".$this->input->post('verification_fee');
		$directorship_check_data = array(
		 
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'approved_doc'=>$remarks_docs,
			'analyst_status_date'=> $analyst_status_date_final,
			'output_status' => $this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0')
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$directorship_check_data['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			 
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'21',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);

				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$directorship_check_data['assigned_role'] = $assigned_role;
				$directorship_check_data['assigned_team_id'] = $assigned_team_id;
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$directorship_check_data['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			
			// return $candidate_info['candidate_id'];
			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name); 
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

  			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'21',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$directorship_check_data['insuff_team_role'] = $insuff_team_role;
				$directorship_check_data['insuff_team_id'] = $insuff_team_id;
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
			} 

		}else{
			$directorship_check_data['analyst_status'] =  $analyst_status_final;
		}
		// print_r($directorship_check_data);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update($table_name,$directorship_check_data)) {

			 

			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$present_address['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert($table_name.'_log',$directorship_check_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}


	function update_remarks_covid_19($client_docs){
		// var_dump($_POST);
		// exit();
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',', $this->input->post('action_status'));

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$covid_id = $this->input->post('covid_id');
		$table_name = 'covid_19';


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}



		$assigned_info = $this->db->select('*')->from($table_name)->where('covid_id',$covid_id)->get()->row_array();
		
		 
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);

		$date =  date('d-m-Y H:i:s');
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);

		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('covid_id',$covid_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		// echo "Fee : ".$this->input->post('verification_fee');
		$directorship_check_data = array(
		 
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'approved_doc'=>$remarks_docs,
			'analyst_status_date'=> $analyst_status_date_final,
			'output_status' => $this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0')
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$directorship_check_data['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			 
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'21',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$directorship_check_data['assigned_role'] = $assigned_role;
				$directorship_check_data['assigned_team_id'] = $assigned_team_id;
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$directorship_check_data['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			
			// return $candidate_info['candidate_id'];
			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name); 
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

  			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'21',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$directorship_check_data['insuff_team_role'] = $insuff_team_role;
				$directorship_check_data['insuff_team_id'] = $insuff_team_id;
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
			} 

		}else{
			$directorship_check_data['analyst_status'] =  $analyst_status_final;
		}
		// print_r($directorship_check_data);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update($table_name,$directorship_check_data)) {

			 

			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$present_address['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert($table_name.'_log',$directorship_check_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}


	function update_employment_gap_check($client_docs){
		// var_dump($_POST);
		// exit();
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',', $this->input->post('action_status'));

		$priority = $this->input->post('priority');
		$index = '0';
		$gap_id = $this->input->post('gap_id');
		$table_name = 'employment_gap_check';


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}



		$assigned_info = $this->db->select('*')->from($table_name)->where('gap_id',$gap_id)->get()->row_array();
		
		 
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);

		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('gap_id',$gap_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		// echo "Fee : ".$this->input->post('verification_fee');
		$directorship_check_data = array(
		 
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'approved_doc'=>$remarks_docs,
			'analyst_status_date'=> date('d-m-Y H:i:s'),
			'output_status' => $this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0')
		); 



		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$directorship_check_data['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			 
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'21',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$directorship_check_data['assigned_role'] = $assigned_role;
				$directorship_check_data['assigned_team_id'] = $assigned_team_id;
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$directorship_check_data['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			

			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name); 
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'21',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$directorship_check_data['insuff_team_role'] = $insuff_team_role;
				$directorship_check_data['insuff_team_id'] = $insuff_team_id;
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
				$directorship_check_data['analyst_status'] =  $analyst_status_final;
			} 

		}else{
			$directorship_check_data['analyst_status'] =  $analyst_status_final;
		}
		// print_r($directorship_check_data);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update($table_name,$directorship_check_data)) {

			 
			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$present_address['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert($table_name.'_log',$directorship_check_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}


	function update_remarks_cv_check($client_docs){
		// var_dump($_POST);
		// exit();
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',', $this->input->post('action_status'));

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');;
		$cv_id = $this->input->post('cv_id');
		$table_name = 'cv_check';


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}



		$assigned_info = $this->db->select('*')->from($table_name)->where('cv_id',$cv_id)->get()->row_array();
		// echo "index:".$index."<br>analyst_status: ".$analyst_status."<br>client_docs: ".$client_docs."<br>approved_doc: ".$assigned_info['approved_doc'];
		 
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);

		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('cv_id',$cv_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();
		$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
 

		$cv_check_data = array(
		 	'full_name'=>$this->input->post('candidate_full_name'),
		 	'contect_number'=>$this->input->post('contact_number'),
		 	'address'=>$this->input->post('candidate_address'),
		 	'education_detail'=>$this->input->post('education_details'),
		 	'employment_duration'=>$this->input->post('employement_duration'),
		 	'designation_held'=>$this->input->post('designation_held'),
		 	'complete_employment_info'=>$this->input->post('complete_emp_info'),
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'approved_doc'=>$remarks_docs,
			'analyst_status_date'=> date('d-m-Y H:i:s'),
			'output_status' => $this->utilModel->setupOutPutStauts($assigned_info['output_status'],0,'0')
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$cv_check_data['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$cv_check_datav['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			 
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'20',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$cv_check_data['assigned_role'] = $assigned_role;
				$cv_check_data['assigned_team_id'] = $assigned_team_id;
				$cv_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $cv_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$cv_check_data['analyst_status'] =  $analyst_status_final;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$cv_check_data['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			

			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}


			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name); 
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'20',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$cv_check_data['insuff_team_role'] = $insuff_team_role;
				$cv_check_data['insuff_team_id'] = $insuff_team_id;
				$cv_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$cv_check_data['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
				$cv_check_data['analyst_status'] =  $analyst_status_final;
			} 

		}else{
			$cv_check_data['analyst_status'] =  $analyst_status_final;
		}
		// print_r($cv_check_data);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update($table_name,$cv_check_data)) {

			 

			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$cv_check_data['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert($table_name.'_log',$cv_check_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}

	function update_remarks_driving_licence_check($client_docs){
		// var_dump($_POST);
		// exit();
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',', $this->input->post('action_status'));

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$licence_id = $this->input->post('licence_id');
		$table_name = 'driving_licence';


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}



		$assigned_info = $this->db->select('*')->from($table_name)->where('licence_id',$licence_id)->get()->row_array();

		$inputQcStatus = explode(',', $assigned_info['status']);
		
		 
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);

		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('licence_id',$licence_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array(); 

		// echo "Fee : ".$this->input->post('verification_fee');
		$dl_check_data = array(
		 
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'approved_doc'=>$remarks_docs,
			'analyst_status_date'=> date('d-m-Y H:i:s'),
			'output_status' => $this->utilModel->setupOutPutStauts($assigned_info['output_status'],0,'0')
		); 

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$dl_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			$is_qc_exists = $this->QcExists($candidate_info['candidate_id'],$index,$table_name,'single');
			 
			if($is_qc_exists == '0'){
 
				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'16',$priority);
				
				if($team_id == '0'){
					return array('status'=>'0','msg'=>'We don\'t have any skill with this'.$role);
				} 

				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();
				 
				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				 
				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$dl_check_data['assigned_role'] = $assigned_role;
				$dl_check_data['assigned_team_id'] = $assigned_team_id;
				$dl_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $dl_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 

			}else{
				$dl_check_data['analyst_status'] =  $analyst_status_final;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$dl_check_data['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			

			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}


			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name); 
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);

			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'16',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$dl_check_data['insuff_team_role'] = $insuff_team_role;
				$dl_check_data['insuff_team_id'] = $insuff_team_id;
				$dl_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$dl_check_data['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
				$dl_check_data['analyst_status'] =  $analyst_status_final;
			} 

		}else{
			$dl_check_data['analyst_status'] =  $analyst_status_final;
		}
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$dl_check_data['status'] = $inputQcStatus_final;
		}
		// print_r($directorship_check_data);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update($table_name,$dl_check_data)) {

 
			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$present_address['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert($table_name.'_log',$dl_check_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}

	function update_remarks_bankruptcy_check($client_docs){
		// var_dump($_POST);
		// exit();
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',', $this->input->post('action_status'));

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$bankruptcy_id = $this->input->post('bankruptcy_id');
		$candidate_id = $this->input->post('candidate_id');
		$table_name = 'bankruptcy';


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}



		$assigned_info = $this->db->select('*')->from($table_name)->where('bankruptcy_id',$bankruptcy_id)->get()->row_array();
		// print_r($assigned_info);
		// echo "|| index : ".$index."||";
		// echo "|| analyst_status : ".print_r($analyst_status);
		// echo "|| client_docs: ".print_r($client_docs);
		// echo "|| approved_doc: ".print_r($assigned_info['approved_doc']);

		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$date =  date('d-m-Y H:i:s');
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);
		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('bankruptcy_id',$bankruptcy_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		// echo "Fee : ".$this->input->post('verification_fee');
		$bankruptcy_check_data = array(
		 
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'approved_doc'=>$remarks_docs,
			'analyst_status_date'=> $analyst_status_date_final,
			'output_status' => $this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0')
		); 

		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$bankruptcy_check_data['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$bankruptcy_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			 
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'18',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$bankruptcy_check_data['assigned_role'] = $assigned_role;
				$bankruptcy_check_data['assigned_team_id'] = $assigned_team_id;
				$bankruptcy_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $bankruptcy_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$bankruptcy_check_data['analyst_status'] =  $analyst_status_final;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$bankruptcy_check_data['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			

			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name); 
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'18',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$bankruptcy_check_data['insuff_team_role'] = $insuff_team_role;
				$bankruptcy_check_data['insuff_team_id'] = $insuff_team_id;
				$bankruptcy_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$bankruptcy_check_data['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
				$bankruptcy_check_data['analyst_status'] =  $analyst_status_final;
			} 

		}else{
			$bankruptcy_check_data['analyst_status'] =  $analyst_status_final;
		}
		// print_r($bankruptcy_check_data);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update($table_name,$bankruptcy_check_data)) {

			 

			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));

			// echo "isOutputQcExists: ".$isOutputQcExists;
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				// echo "outpuQcUpdateStatus: ".$outpuQcUpdateStatus;
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$present_address['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert($table_name.'_log',$bankruptcy_check_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}
	
	function update_remarks_credit_cibil_check($client_docs){
		// var_dump($_POST);
		// exit();
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',', $this->input->post('action_status'));

		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$credit_id = $this->input->post('credit_id');
		$table_name = 'credit_cibil';


		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}



		$assigned_info = $this->db->select('*')->from($table_name)->where('credit_id',$credit_id)->get()->row_array();
		
		// echo "index:".$index."<br>";
		// echo "analyst_status: ".$analyst_status."<br>";
		// echo "client_docs: ".$client_docs."<br>";
		// echo "approved_doc: ".$assigned_info['approved_doc'];
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$date =  date('d-m-Y H:i:s');
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);
		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));

		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);

		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('credit_id',$credit_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		// echo "Fee : ".$this->input->post('verification_fee');
		$credit_cibil_check_data = array(
		 
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_country'=>$this->input->post('country'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'approved_doc'=>$remarks_docs,
			'analyst_status_date'=> $analyst_status_date_final,
			'output_status' => $this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0')
		); 



		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$credit_cibil_check_data['status'] = $inputQcStatus_final;
		}


		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$credit_cibil_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}

		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			 
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'17',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);
				
				$credit_cibil_check_data['assigned_role'] = $assigned_role;
				$credit_cibil_check_data['assigned_team_id'] = $assigned_team_id;
				$credit_cibil_check_data['analyst_status'] =  $analyst_status_final;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $credit_cibil_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$credit_cibil_check_data['analyst_status'] =  $analyst_status_final;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$credit_cibil_check_data['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			

			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_re_start_date'=>'',
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}
			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name); 
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);

			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);

			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'17',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$credit_cibil_check_data['insuff_team_role'] = $insuff_team_role;
				$credit_cibil_check_data['insuff_team_id'] = $insuff_team_id;
				$credit_cibil_check_data['analyst_status'] =  $analyst_status_final; 
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$credit_cibil_check_data['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{

				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
				$credit_cibil_check_data['analyst_status'] =  $analyst_status_final;
			} 

		}else{
			$credit_cibil_check_data['analyst_status'] =  $analyst_status_final;
		}
		// print_r($credit_cibil_check_data);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update($table_name,$credit_cibil_check_data)) {

			 

			// if status raised 3(Insuff that time it will go message)
			
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$present_address['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert($table_name.'_log',$credit_cibil_check_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}


	function outputQcExists($candidate_id){
		$candidateData = $this->db->select('assigned_outputqc_id')->from('candidate')->where('candidate_id',$candidate_id)->get()->row_array();
		
		if($candidateData['assigned_outputqc_id'] == '0'){
			return '0';
		}
		
		return '1';
	}



	function get_all_states($id=''){
		if ($id !='') {
			return $this->db->where('country_id',$id)->get('states')->result_array();
		}else{
			return $this->db->order_by('country_id','ASC')->get('states')->result_array();
		}
	}

	function get_all_countries(){
		return $this->db->get('countries')->result_array();
	}
 	

 	function get_all_cities($id=''){
 		 
		if ($id !='') {
			return $this->db->where('state_id',$id)->get('cities')->result_array();
		}else{
			return $this->db->order_by('state_id','ASC')->get('cities')->result_array();
		}
	}

	function isSubmitedStatusChanged($candidateId){
		$candidate = $this->db->where('candidate_id',$candidateId)->get('candidate')->row_array();
		$candidate_array = array(
			'client_id'=>$candidate['client_id'],
			'status'=>0,
			'notification_type'=>1,
			'candidate_id'=>$candidateId
		);
		$this->notification_action_report($candidate_array);
		$is_submitted_status= array(
			'is_submitted'=>'3',

			'case_insuff_client_notification'=>'1',
			'is_report_generated'=>0,
			'report_generated_date'=>'',
			'tat_end_date'=>'',
		); 
		$this->db->where('candidate_id',$candidateId); 
		if ($this->db->update('candidate',$is_submitted_status)){

			$candidateDatat = $this->db->where('candidate_id',$candidateId)->get('candidate')->row_array();
			if($this->db->insert('candidate_log',$candidateDatat)){
				return '1';
			}else{
				return '3';
			}
			
		}else{
			return '0'; 
		}
	}

	function isSubmitedStatusChange_for_clear_insuff($candidateId){
		$candidate = $this->db->where('candidate_id',$candidateId)->get('candidate')->row_array();
		$candidate_array = array(
			'client_id'=>$candidate['client_id'],
			'status'=>1,
			'notification_type'=>1,
			'candidate_id'=>$candidateId
		);
		// $this->notification_action_report($candidate_array);
		$is_submitted_status= array(
			'is_submitted'=>'1',
			'case_insuff_client_notification'=>'0'
		);
		$this->tat_restart_date_for_not_insuff($candidateId);
		$this->db->where('candidate_id',$candidateId); 
		if ($this->db->update('candidate',$is_submitted_status)){

			$candidateDatat = $this->db->where('candidate_id',$candidateId)->get('candidate')->row_array();
			if($this->db->insert('candidate_log',$candidateDatat)){
				return '1';
			}else{
				return '3';
			}
			
		}else{
			return '0'; 
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

	function tat_restart_date_for_not_insuff($candidateId){
		$candidate_tat = $this->db->where('candidate_id',$candidateId)->get('candidate')->row_array();

		if ($candidate_tat['tat_pause_date'] !='' && $candidate_tat['tat_re_start_date'] =='') {
			$candidate_data = array(
				'tat_re_start_date'=>date("d-m-Y H:i:s"),
			);

			$this->db->where('candidate_id',$candidateId)->update('candidate',$candidate_data);
		}

	} 

/*
	function notification_action_report($candidate_array){ 
		$spoc_id = $this->db->where('client_id',$candidate_array['client_id'])->get('tbl_clientspocdetails')->result_array(); 

		if (count($spoc_id) > 0) { 
			foreach ($spoc_id as $key => $value) {
				$candidate_data = array(
					'candidate_id'=>$candidate_array['candidate_id'],
					'client_id'=>$candidate_array['client_id'],
					'client_spoc_id'=>$value['spoc_id'],
					'notification_status'=>isset($candidate_array['status'])?$candidate_array['status']:0,
					'notification_type_id'=>isset($candidate_array['notification_type'])?$candidate_array['notification_type']:1,
				);
				$this->db->insert('client_in_app_notification',$candidate_data);
			}

		}

	}

*/

	function changeVlaueThroughIndex($oldArray,$pos,$value){
		// print_r($oldArray);
		// echo "</br>";
		$oldArray[$pos] = $value;
		// print_r($oldArray);
		// echo "</br>"; 
		$newString = implode(',',$oldArray);
		// print_r($newString);
		// echo "</br>";
		return $newString;
	}

	function get_component_name($component_id){
		return $this->db->where('component_id',$component_id)->get('components')->row_array();
	}


	function getInsuffComponentForms($team_id = ''){
 		if ($this->input->post('team_id')) { 
 		$team_id = $this->input->post('team_id');
 		} 
 		$component = $this->config->item('components_list');

 		// Total Data for team Id;
 		$row =array();
 		foreach ($component as $key => $component_value) {
 			$query = "SELECT * FROM ".$component_value." where `assigned_team_id` REGEXP ".$team_id;
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
 						if($assigned_team_ids_value == $team_id && ($analyst_status[$assigned_team_ids_key] != '3' && $analyst_status[$assigned_team_ids_key] != '10')){

 							$criminal_checks['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$criminal_checks['component_name'] = $this->get_component_name($criminal_checks['component_id'])[$this->config->item('show_component_name')];
 							$criminal_checks['criminal_check_id'] = $criminal_checks_value['criminal_check_id'];
 							$criminal_checks['candidate_id'] = $criminal_checks_value['candidate_id'];
 							$criminal_checks['candidate_detail'] = $this->getCandidateInfo($criminal_checks_value['candidate_id']);
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
 						}
 						
 					}
 					
 				}
 			}

 			// 25

 			if($mainKey == 'civil_check'){
 				 foreach ($value as $civil_check_key => $criminal_checks_value) {
 					$assigned_team_ids = explode(",",$criminal_checks_value['assigned_team_id']); 
 					// $court_address = json_decode($court_records_value['address'],true);
 					foreach ($assigned_team_ids as $assigned_team_ids_key => $assigned_team_ids_value) {
 						$analyst_status = explode(",", isset($criminal_checks_value['analyst_status'])?$criminal_checks_value['analyst_status']:'0');
 						if($assigned_team_ids_value == $team_id && ($analyst_status[$assigned_team_ids_key] != '3' && $analyst_status[$assigned_team_ids_key] != '10')){

 							$civil_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$civil_check['component_name'] = $this->get_component_name($civil_check['component_id'])[$this->config->item('show_component_name')];
 							$civil_check['civil_check_id'] = $criminal_checks_value['civil_check_id'];
 							$civil_check['candidate_id'] = $criminal_checks_value['candidate_id'];
 							$civil_check['candidate_detail'] = $this->getCandidateInfo($criminal_checks_value['candidate_id']);
 							// $court_records['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							 
 							$court_address = json_decode($criminal_checks_value['address'],true);
 							// print_r($court_address[$assigned_team_ids_key]);
 							// echo "<br>";
 							$civil_check['address'] = isset($court_address[$assigned_team_ids_key]['address'])?$court_address[$assigned_team_ids_key]['address']:'';

 							$pin_code = json_decode($criminal_checks_value['pin_code'],true);
 							$civil_check['pin_code'] = isset($pin_code[$assigned_team_ids_key]['pincode'])?$pin_code[$assigned_team_ids_key]['pincode']:'';
 							
 							$city = json_decode($criminal_checks_value['city'],true);
 							$civil_check['city'] = isset($city[$assigned_team_ids_key]['city'])?$city[$assigned_team_ids_key]['city']:'';
 							 
 							$state = json_decode($criminal_checks_value['state'],true);
 							$civil_check['state'] = isset($state[$assigned_team_ids_key]['state'])?$state[$assigned_team_ids_key]['state']:'';
 							
 							$country = json_decode($criminal_checks_value['country'],true);
 							$civil_check['country'] = isset($country[$assigned_team_ids_key]['country'])?$country[$assigned_team_ids_key]['country']:'';
 							 

 							$status = explode(",", $criminal_checks_value['status']);
 							$civil_check['status'] = isset($status[$assigned_team_ids_key])?$status[$assigned_team_ids_key]:'';
 
 							
 							$civil_check['analyst_status'] = isset($analyst_status[$assigned_team_ids_key])?$analyst_status[$assigned_team_ids_key]:'';

 							$insuff_status = explode(",", $criminal_checks_value['insuff_status']);
 							$civil_check['insuff_status'] = isset($insuff_status[$assigned_team_ids_key])?$insuff_status[$assigned_team_ids_key]:'';

 							$output_status = explode(",", $criminal_checks_value['output_status']);
 							$civil_check['output_status'] = isset($output_status[$assigned_team_ids_key])?$output_status[$assigned_team_ids_key]:'';

 							$assigned_role = explode(",", $criminal_checks_value['assigned_role']);
 							$civil_check['assigned_role'] = isset($assigned_role[$assigned_team_ids_key])?$assigned_role[$assigned_team_ids_key]:'';

 							$assigned_team_id = explode(",", $criminal_checks_value['assigned_team_id']);
 							$civil_check['assigned_team_id'] = isset($assigned_team_id[$assigned_team_ids_key])?$assigned_team_id[$assigned_team_ids_key]:'';
 							
 							$civil_check['created_date'] = $criminal_checks_value['created_date'];
 							$civil_check['updated_date'] = $criminal_checks_value['updated_date'];
 							$civil_check['index'] = $assigned_team_ids_key;
 							array_push($final_data, $civil_check);
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
 						if($assigned_team_ids_value == $team_id && ($analyst_status[$assigned_team_ids_key] != '3' &&$analyst_status[$assigned_team_ids_key] != '10')){

 							$court_records['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$court_records['component_name'] = $this->get_component_name($court_records['component_id'])[$this->config->item('show_component_name')];
 							$court_records['court_records_id'] = $court_records_value['court_records_id'];
 							$court_records['candidate_id'] = $court_records_value['candidate_id'];
 							$court_records['candidate_detail'] = $this->getCandidateInfo($court_records_value['candidate_id']);
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
 						if($assigned_team_id_value == $team_id && ($document_analyst_status != "3" && $document_analyst_status != '10')){
		 					$candidateInfo = $this->getCandidateInfo($document_check_value['candidate_id']);
		 					$document_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
		 					$document_check['component_name'] = $this->get_component_name($document_check['component_id'])[$this->config->item('show_component_name')];
		 					$document_check['candidate_id'] = $document_check_value['candidate_id'];
		 					$document_check['candidate_detail'] = $candidateInfo;

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
 						if($drugtest_value == $team_id && ($drugtest_analyst_status  != '3' && $drugtest_analyst_status  != '10')){
	 						 
		 					$drugtest['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
		 					$drugtest['component_name'] = $this->get_component_name($drugtest['component_id'])[$this->config->item('show_component_name')];
		 					$drugtest['drugtest_id'] = $subValues['drugtest_id']; 
		 					$drugtest['candidate_id'] = $subValues['candidate_id'];
		 					$drugtest['candidate_detail'] = $this->getCandidateInfo($subValues['candidate_id']);
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
 					if($global_assigned_team_id == $team_id && ($globaldatabase_value['analyst_status'] != '3' && $globaldatabase_value['analyst_status'] != '10')){
	 					$globaldatabase_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
	 					$globaldatabase_value['component_name'] = $this->get_component_name($globaldatabase_value['component_id'])[$this->config->item('show_component_name')];
	 					$globaldatabase_value['candidate_detail'] = $this->getCandidateInfo($globaldatabase_value['candidate_id']);
	 					$globaldatabase_value['index'] = 0;
	 					array_push($final_data, $globaldatabase_value);
 					}
 				}
 			}
 			//  6
 			if($mainKey == 'current_employment'){
 				$n =0;
 				foreach ($value as $current_employment_key => $current_employment_value) {
 					$ce_assigned_team_id =isset($current_employment_value['assigned_team_id'])?$current_employment_value['assigned_team_id']:'0';
 					if($ce_assigned_team_id == $team_id && ($current_employment_value['analyst_status'] != '3' && $current_employment_value['analyst_status'] != '10')){
	 					$current_employment_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 						$current_employment_value['component_name'] = $this->get_component_name($current_employment_value['component_id'])[$this->config->item('show_component_name')];
	 					$current_employment_value['candidate_detail'] = $this->getCandidateInfo($current_employment_value['candidate_id']);
	 					$current_employment_value['index'] = $n;
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
 						
 						if($education_details_value == $team_id && ($analyst_status[$education_details_key] != '3' && $analyst_status[$education_details_key] != '10')){
   
		 					$education_details['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
		 					$education_details['component_name'] = $this->get_component_name($education_details['component_id'])[$this->config->item('show_component_name')];
		 					// array_push($education_details, $subValues['education_details_id']);
		 					// array_push($education_details, $subValues['candidate_id']);
		 					$education_details['education_details_id'] = $subValues['education_details_id'];
		 					$education_details['candidate_id'] = $subValues['candidate_id'];
		 					$education_details['candidate_detail'] = $this->getCandidateInfo($subValues['candidate_id']);
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
 					if($pa_assigned_team_id == $team_id && ($present_address_value['analyst_status'] != '3' && $present_address_value['analyst_status'] != '10')){
	 					$present_address_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
	 					$present_address_value['component_name'] = $this->get_component_name($present_address_value['component_id'])[$this->config->item('show_component_name')];
	 					$present_address_value['candidate_detail'] = $this->getCandidateInfo($present_address_value['candidate_id']);
	 					$present_address_value['index'] = 0;
	 					array_push($final_data, $present_address_value);
 					}
 				}
 			}

 			// 9
 			if($mainKey == 'permanent_address'){
 				foreach ($value as $permanent_address_key => $permanent_address_value) {
 					$pea_assigned_team_id =isset($permanent_address_value['assigned_team_id'])?$permanent_address_value['assigned_team_id']:'0';
 					if($pea_assigned_team_id == $team_id && ($permanent_address_value['analyst_status'] != '3' && $permanent_address_value['analyst_status'] != '10')){
	 					$permanent_address_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
	 					$permanent_address_value['component_name'] = $this->get_component_name($permanent_address_value['component_id'])[$this->config->item('show_component_name')];
	 					$permanent_address_value['candidate_detail'] = $this->getCandidateInfo($permanent_address_value['candidate_id']); 
	 					$permanent_address_value['index'] = 0;
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

 						if($pe_assigned_team_id_value == $team_id && ($analyst_status[$pe_assigned_team_id_key] != '3' && $analyst_status[$pe_assigned_team_id_key] != '10')){
 							
 							$previous_employment['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_employment['component_name'] = $this->get_component_name($previous_employment['component_id'])[$this->config->item('show_component_name')];
 							$previous_employment['previous_emp_id'] = $previous_employment_value['previous_emp_id'];
 							$previous_employment['candidate_id'] = $previous_employment_value['candidate_id']; 
 							$previous_employment['candidate_detail'] = $this->getCandidateInfo($previous_employment_value['candidate_id']);
 							$previous_employment['index'] = $pe_assigned_team_id_key;

 							

 							$status = explode(",",$previous_employment_value['status']);
 							$previous_employment['status'] = isset($status[$pe_assigned_team_id_key])?$status[$pe_assigned_team_id_key]:"";

 							
 							$previous_employment['analyst_status'] = isset($analyst_status[$pe_assigned_team_id_key])?$analyst_status[$pe_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$previous_employment_value['insuff_status']);
		 					$previous_employment['insuff_status'] = isset($insuff_status[$pe_assigned_team_id_key])?$insuff_status[$pe_assigned_team_id_key]:'';

 							$previous_employment['updated_date'] = $previous_employment_value['updated_date'];
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

 						if($reference_assigned_team_id_value == $team_id && ($analyst_status[$reference_assigned_team_id_key] != '3' && $analyst_status[$reference_assigned_team_id_key] != '10')){
 							
 							$reference['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$reference['component_name'] = $this->get_component_name($reference['component_id'])[$this->config->item('show_component_name')];
 							$reference['reference_id'] = $reference_value['reference_id'];
 							$reference['candidate_id'] = $reference_value['candidate_id']; 
 							$reference['candidate_detail'] = $this->getCandidateInfo($reference_value['candidate_id']);
 							$reference['index'] = $reference_assigned_team_id_key;

 							 

 							$status = explode(",",$reference_value['status']);
 							$reference['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";

 							
 							$reference['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$reference_value['insuff_status']);
		 					$reference['insuff_status'] = isset($insuff_status[$reference_assigned_team_id_key])?$insuff_status[$reference_assigned_team_id_key]:'';

 							$reference['updated_date'] = $reference_value['updated_date'];
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
 						if($pa_assigned_team_id_value == $team_id && ($pa_analyst_status!= '3' && $pa_analyst_status != '10')){
 							
 							$previous_address['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_address['component_name'] = $this->get_component_name($previous_address['component_id'])[$this->config->item('show_component_name')];
 							$previous_address['previos_address_id'] = $pa_value['previos_address_id'];
 							$previous_address['candidate_id'] = $pa_value['candidate_id']; 
 							$previous_address['candidate_detail'] = $this->getCandidateInfo($pa_value['candidate_id']);
 							$previous_address['index'] = $pa_assigned_team_id_key; 

 							$status = explode(",",$pa_value['status']);
 							$previous_address['status'] = isset($status[$pa_assigned_team_id_key])?$status[$pa_assigned_team_id_key]:"";

 							
 							$previous_address['analyst_status'] = $pa_analyst_status;

 							$insuff_status = explode(",",$pa_value['insuff_status']);
		 					$previous_address['insuff_status'] = isset($insuff_status[$pa_assigned_team_id_key])?$insuff_status[$pa_assigned_team_id_key]:'';


 							$previous_address['updated_date'] = $pa_value['updated_date'];

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
 						
 						if($dir_assigned_team_id_value == $team_id && ($dirAnalystStatus != '3' && $dirAnalystStatus != '10')){
 							
 							$previous_address['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_address['component_name'] = $this->get_component_name($previous_address['component_id'])[$this->config->item('show_component_name')];
 							$previous_address['directorship_check_id'] = $dir_value['directorship_check_id'];
 							$previous_address['candidate_id'] = $dir_value['candidate_id']; 
 							$previous_address['candidate_detail'] = $this->getCandidateInfo($dir_value['candidate_id']);
 							$previous_address['index'] = $dir_assigned_team_id_key; 

 							$status = explode(",",$dir_value['status']);
 							$previous_address['status'] = isset($status[$dir_assigned_team_id_key])?$status[$dir_assigned_team_id_key]:"";

 							
 							$previous_address['analyst_status'] = isset($dir_analyst_status[$dir_assigned_team_id_key])?$dir_analyst_status[$dir_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$dir_value['insuff_status']);
		 					$previous_address['insuff_status'] = isset($insuff_status[$dir_assigned_team_id_key])?$insuff_status[$dir_assigned_team_id_key]:'';


 							$previous_address['updated_date'] = $dir_value['updated_date'];

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
 						if($sanctions_assigned_team_id_value == $team_id && ($global_sanctions_analyst_status != '3' && $global_sanctions_analyst_status != '10')){
 							
 							$global_sanctions_aml['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$global_sanctions_aml['component_name'] = $this->get_component_name($global_sanctions_aml['component_id'])[$this->config->item('show_component_name')];
 							$global_sanctions_aml['global_sanctions_aml_id'] = $sanctions_value['global_sanctions_aml_id'];
 							$global_sanctions_aml['candidate_id'] = $sanctions_value['candidate_id']; 
 							$global_sanctions_aml['candidate_detail'] = $this->getCandidateInfo($sanctions_value['candidate_id']);
 							$global_sanctions_aml['index'] = $sanctions_assigned_team_id_key; 

 							$status = explode(",",$sanctions_value['status']);
 							$global_sanctions_aml['status'] = isset($status[$sanctions_assigned_team_id_key])?$status[$sanctions_assigned_team_id_key]:"";

 							
 							$global_sanctions_aml['analyst_status'] = $global_sanctions_analyst_status;

 							$insuff_status = explode(",",$sanctions_value['insuff_status']);
		 					$global_sanctions_aml['insuff_status'] = isset($insuff_status[$sanctions_assigned_team_id_key])?$insuff_status[$sanctions_assigned_team_id_key]:'';


 							$global_sanctions_aml['updated_date'] = $sanctions_value['updated_date'];

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
 						if($dl_assigned_team_id_value == $team_id && ($driving_licence_analyst_status != '3' && $driving_licence_analyst_status != '10')){
 							
 							$driving_licence['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$driving_licence['component_name'] = $this->get_component_name($driving_licence['component_id'])[$this->config->item('show_component_name')];
 							$driving_licence['licence_id'] = $dl_value['licence_id'];
 							$driving_licence['candidate_id'] = $dl_value['candidate_id']; 
 							$driving_licence['candidate_detail'] = $this->getCandidateInfo($dl_value['candidate_id']);
 							$driving_licence['index'] = 0; 

 							$status = explode(",",$dl_value['status']);
 							$driving_licence['status'] = isset($status[$dl_assigned_team_id_key])?$status[$dl_assigned_team_id_key]:"";

 							
 							$driving_licence['analyst_status'] = $driving_licence_analyst_status;

 							$insuff_status = explode(",",$dl_value['insuff_status']);
		 					$driving_licence['insuff_status'] = isset($insuff_status[$dl_assigned_team_id_key])?$insuff_status[$dl_assigned_team_id_key]:'';


 							$driving_licence['updated_date'] = $dl_value['updated_date'];

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
 						if($cc_assigned_team_id_value == $team_id && ($cc_analyst_status != '3' && $cc_analyst_status != '10')){
 							
 							$credit_cibil['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$credit_cibil['component_name'] = $this->get_component_name($credit_cibil['component_id'])[$this->config->item('show_component_name')];
 							$credit_cibil['credit_id'] = $cc_value['credit_id'];
 							$credit_cibil['candidate_id'] = $cc_value['candidate_id']; 
 							$credit_cibil['candidate_detail'] = $this->getCandidateInfo($cc_value['candidate_id']);
 							$credit_cibil['index'] = $cc_assigned_team_id_key; 

 							$status = explode(",",$cc_value['status']);
 							$credit_cibil['status'] = isset($status[$cc_assigned_team_id_key])?$status[$cc_assigned_team_id_key]:"";

 							
 							$credit_cibil['analyst_status'] = $cc_analyst_status;

 							$insuff_status = explode(",",$cc_value['insuff_status']);
		 					$credit_cibil['insuff_status'] = isset($insuff_status[$cc_assigned_team_id_key])?$insuff_status[$cc_assigned_team_id_key]:'';


 							$credit_cibil['updated_date'] = $cc_value['updated_date'];

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
 						if($bankruptcy_assigned_team_id_value == $team_id && ($analyst_status[$bankruptcy_assigned_team_id_key] != '3' && $analyst_status[$bankruptcy_assigned_team_id_key] != '10')){
 							
 							$bankruptcy['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$bankruptcy['component_name'] = $this->get_component_name($bankruptcy['component_id'])[$this->config->item('show_component_name')];
 							$bankruptcy['bankruptcy_id'] = $bankruptcy_value['bankruptcy_id'];
 							$bankruptcy['candidate_id'] = $bankruptcy_value['candidate_id']; 
 							$bankruptcy['candidate_detail'] = $this->getCandidateInfo($bankruptcy_value['candidate_id']);
 							$bankruptcy['index'] = $bankruptcy_assigned_team_id_key; 

 							$status = explode(",",$bankruptcy_value['status']);
 							$bankruptcy['status'] = isset($status[$bankruptcy_assigned_team_id_key])?$status[$bankruptcy_assigned_team_id_key]:"";

 							
 							$bankruptcy['analyst_status'] = $bankruptcy_analyst_status;

 							$insuff_status = explode(",",$bankruptcy_value['insuff_status']);
		 					$bankruptcy['insuff_status'] = isset($insuff_status[$bankruptcy_assigned_team_id_key])?$insuff_status[$bankruptcy_assigned_team_id_key]:'';


 							$bankruptcy['updated_date'] = $bankruptcy_value['updated_date'];

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
 						if($adm_assigned_team_id_value == $team_id && ($adm_analyst_status != '3' && $adm_analyst_status != '10')){
 							
 							$adm_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$adm_check['component_name'] = $this->get_component_name($adm_check['component_id'])[$this->config->item('show_component_name')];
 							$adm_check['adverse_database_media_check_id'] = $adm_value['adverse_database_media_check_id'];
 							$adm_check['candidate_id'] = $adm_value['candidate_id']; 
 							$adm_check['candidate_detail'] = $this->getCandidateInfo($adm_value['candidate_id']);
 							$adm_check['index'] = $adm_assigned_team_id_key; 

 							$status = explode(",",$adm_value['status']);
 							$adm_check['status'] = isset($status[$adm_assigned_team_id_key])?$status[$adm_assigned_team_id_key]:"";

 							
 							$adm_check['analyst_status'] = $adm_analyst_status;

 							$insuff_status = explode(",",$adm_value['insuff_status']);
		 					$adm_check['insuff_status'] = isset($insuff_status[$adm_assigned_team_id_key])?$insuff_status[$adm_assigned_team_id_key]:'';


 							$adm_check['updated_date'] = $adm_value['updated_date'];

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
 						if($cv_assigned_team_id_value == $team_id && ($cv_analyst_status != '3' && $cv_analyst_status != '10')){
 							
 							$cv_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$cv_check['component_name'] = $this->get_component_name($cv_check['component_id'])[$this->config->item('show_component_name')];
 							$cv_check['cv_id'] = $cv_value['cv_id'];
 							$cv_check['candidate_id'] = $cv_value['candidate_id']; 
 							$cv_check['candidate_detail'] = $this->getCandidateInfo($cv_value['candidate_id']);
 							$cv_check['index'] = $cv_assigned_team_id_key; 

 							$status = explode(",",$cv_value['status']);
 							$cv_check['status'] = isset($status[$cv_assigned_team_id_key])?$status[$cv_assigned_team_id_key]:"";

 							
 							$cv_check['analyst_status'] = $cv_analyst_status;

 							$insuff_status = explode(",",$cv_value['insuff_status']);
		 					$cv_check['insuff_status'] = isset($insuff_status[$cv_assigned_team_id_key])?$insuff_status[$cv_assigned_team_id_key]:'';


 							$cv_check['updated_date'] = $cv_value['updated_date'];

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
 						if($health_assigned_team_id_value == $team_id && ($health_analyst_status != '3' && $health_analyst_status != '10')){
 							
 							$health_checkup['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$health_checkup['component_name'] = $this->get_component_name($health_checkup['component_id'])[$this->config->item('show_component_name')];
 							$health_checkup['health_checkup_id'] = $health_value['health_checkup_id'];
 							$health_checkup['candidate_id'] = $health_value['candidate_id']; 
 							$health_checkup['candidate_detail'] = $this->getCandidateInfo($health_value['candidate_id']);
 							$health_checkup['index'] = $health_assigned_team_id_key; 

 							$status = explode(",",$health_value['status']);
 							$health_checkup['status'] = isset($status[$health_assigned_team_id_key])?$status[$health_assigned_team_id_key]:"";

 							
 							$health_checkup['analyst_status'] = $health_analyst_status;

 							$insuff_status = explode(",",$health_value['insuff_status']);
		 					$health_checkup['insuff_status'] = isset($insuff_status[$health_assigned_team_id_key])?$insuff_status[$health_assigned_team_id_key]:'';


 							$health_checkup['updated_date'] = $health_value['updated_date'];

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
 						if($health_assigned_team_id_value == $team_id && ($health_analyst_status != '3' && $health_analyst_status != '10')){
 							
 							$covid['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$covid['component_name'] = $this->get_component_name($covid['component_id'])[$this->config->item('show_component_name')];
 							$covid['covid_id'] = $health_value['covid_id'];
 							$covid['candidate_id'] = $health_value['candidate_id']; 
 							$covid['candidate_detail'] = $this->getCandidateInfo($health_value['candidate_id']);
 							$covid['index'] = $health_assigned_team_id_key; 

 							$status = explode(",",$health_value['status']);
 							$covid['status'] = isset($status[$health_assigned_team_id_key])?$status[$health_assigned_team_id_key]:"";

 							
 							$covid['analyst_status'] = $health_analyst_status;

 							$insuff_status = explode(",",$health_value['insuff_status']);
		 					$covid['insuff_status'] = isset($insuff_status[$health_assigned_team_id_key])?$insuff_status[$health_assigned_team_id_key]:'';


 							$covid['updated_date'] = $health_value['updated_date'];

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
 						if($eg_assigned_team_id_value == $team_id && ($eg_analyst_status != '3' && $eg_analyst_status != '10')){
 							
 							$eg_checkup['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$eg_checkup['component_name'] = $this->get_component_name($eg_checkup['component_id'])[$this->config->item('show_component_name')];
 							$eg_checkup['gap_id'] = $eg_value['gap_id'];
 							$eg_checkup['candidate_id'] = $eg_value['candidate_id']; 
 							$eg_checkup['candidate_detail'] = $this->getCandidateInfo($eg_value['candidate_id']);
 							$eg_checkup['index'] = $eg_assigned_team_id_key; 

 							$status = explode(",",$eg_value['status']);
 							$eg_checkup['status'] = isset($status[$eg_assigned_team_id_key])?$status[$eg_assigned_team_id_key]:"";

 							
 							$eg_checkup['analyst_status'] = $eg_analyst_status;

 							$insuff_status = explode(",",$eg_value['insuff_status']);
		 					$eg_checkup['insuff_status'] = isset($insuff_status[$eg_assigned_team_id_key])?$insuff_status[$eg_assigned_team_id_key]:'';


 							$eg_checkup['updated_date'] = $eg_value['updated_date'];

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

 						if($reference_assigned_team_id_value == $team_id && ( $analyst_status[$reference_assigned_team_id_key] != '10' && $analyst_status[$reference_assigned_team_id_key] != '3')){
 							
 							$reference['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$reference['component_name'] = $this->get_component_name($reference['component_id'])[$this->config->item('show_component_name')];
 							$reference['landload_id'] = $reference_value['landload_id'];
 							$reference['candidate_id'] = $reference_value['candidate_id']; 
 							$reference['candidate_detail'] = $this->getCandidateInfo($reference_value['candidate_id']);
 							$reference['index'] = $reference_assigned_team_id_key;

 							 

 							$status = explode(",",$reference_value['status']);
 							$reference['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";

 							
 							$reference['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$reference_value['insuff_status']);
		 					$reference['insuff_status'] = isset($insuff_status[$reference_assigned_team_id_key])?$insuff_status[$reference_assigned_team_id_key]:'';

 							$reference['updated_date'] = $reference_value['updated_date'];
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

 						if($reference_assigned_team_id_value == $team_id && ( $analyst_status[$reference_assigned_team_id_key] != '10' && $analyst_status[$reference_assigned_team_id_key] != '3')){
 							
 							$social['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$social['component_name'] = $this->get_component_name($social['component_id'])[$this->config->item('show_component_name')];
 							$social['social_id'] = $reference_value['social_id'];
 							$social['candidate_id'] = $reference_value['candidate_id']; 
 							$social['candidate_detail'] = $this->getCandidateInfo($reference_value['candidate_id']);
 							$social['index'] = $reference_assigned_team_id_key;

 							 

 							$status = explode(",",$reference_value['status']);
 							$social['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";

 							
 							$social['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$reference_value['insuff_status']);
		 					$social['insuff_status'] = isset($insuff_status[$reference_assigned_team_id_key])?$insuff_status[$reference_assigned_team_id_key]:'';

 							$social['updated_date'] = $reference_value['updated_date'];
 							array_push($final_data, $social);
 						}
 					}
 				} 
 			}


 			$components = ['right_to_work','sex_offender','politically_exposed','india_civil_litigation','mca','nric','gsa','oig'];
 			// 22
 			if(in_array($mainKey, $components)){
 				 
 				foreach ($value as $reference_key => $reference_value) {
 					$reference_assigned_team_id = explode(",",$reference_value['assigned_team_id']);
 					 
 					foreach ($reference_assigned_team_id as $reference_assigned_team_id_key => $reference_assigned_team_id_value) {
 						$analyst_status = explode(",",$reference_value['analyst_status']);

 						if($reference_assigned_team_id_value == $team_id && ( $analyst_status[$reference_assigned_team_id_key] != '10' && $analyst_status[$reference_assigned_team_id_key] != '3')){
 							
 							$social['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$social['component_name'] = $this->get_component_name($social['component_id'])[$this->config->item('show_component_name')];
 							// $social['social_id'] = $reference_value['social_id'];
 							$social['candidate_id'] = $reference_value['candidate_id']; 
 							$social['candidate_detail'] = $this->getCandidateInfo($reference_value['candidate_id']);
 							$social['index'] = $reference_assigned_team_id_key;

 							 

 							$status = explode(",",$reference_value['status']);
 							$social['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";

 							
 							$social['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$reference_value['insuff_status']);
		 					$social['insuff_status'] = isset($insuff_status[$reference_assigned_team_id_key])?$insuff_status[$reference_assigned_team_id_key]:'';

 							$social['updated_date'] = $reference_value['updated_date'];
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

 	function get_escalatory_cases($team_id = '') {
 		$filter_limit = $this->input->post('filter_limit');
		$filter_input = $this->input->post('filter_input');
		$candidate_id_list = $this->input->post('candidate_id_list');

 		$show_cases_rule = $this->db->where('show_cases_rule_status','1')->get('show_cases_rule')->result_array();
 		$all_rule_cirteria = json_decode(file_get_contents(base_url().'assets/custom-js/json/rule-criteras.json'),true);
 		$remaining_days_rules = json_decode(file_get_contents(base_url().'assets/custom-js/json/remaining-days-rules.json'),true);
 		$case_priorities = json_decode(file_get_contents(base_url().'assets/custom-js/json/case-priorities.json'),true);

 		$show_case_rules = '';
 		if (count($show_cases_rule) > 0) {
 			foreach ($show_cases_rule as $key => $value) {
 				if ($key == 0) {
 					$show_case_rules .= ' AND (';
 				} else {
 					$show_case_rules .= ' OR ';
 				}
	 			foreach ($all_rule_cirteria as $key2 => $value2) {
	 				if ($value['show_cases_rule_criteria'] == $value2['id']) {
	 					$show_cases_rules = json_decode($value['show_cases_rules'],true);
	 					if ($value['show_cases_rule_criteria'] == '1') {
	 						foreach ($remaining_days_rules as $key3 => $value3) {
	 							if ($show_cases_rules['remaining_days_type'] == $value3['id']) {
									$show_case_rules .= "((DATEDIFF(STR_TO_DATE(T2.tat_end_date,'%Y-%m-%d %H:%i:%s'),CURDATE()) ".$value3['db_symbol']." ".$show_cases_rules['remaining_days_value']." OR DATEDIFF(STR_TO_DATE(T2.tat_end_date,'%d-%m-%Y %H:%i:%s'),CURDATE()) ".$value3['db_symbol']." ".$show_cases_rules['remaining_days_value'].") AND T2.client_id IN (".$value['show_cases_rule_client_id'].") AND T1.analyst_status NOT REGEXP (4))";
	 								break;
	 							}
	 						}
	 					} else if($value['show_cases_rule_criteria'] == '2') {
	 						foreach ($case_priorities as $key3 => $value3) {
	 							if ($show_cases_rules['priority_type'] == $value3['id']) {
	 								$show_case_rules .= "(T2.priority IN (".$value3['id'].") AND T2.client_id IN (".$value['show_cases_rule_client_id'].") AND T1.analyst_status NOT REGEXP (4))";
	 								break;
	 							}
	 						}
	 					}
	 					break;
	 				}
	 			}

	 			if ($key + 1 == count($show_cases_rule)) {
 					$show_case_rules .= ')';
 				}
	 		}
 		} else {
 			return array('status'=>'2','message'=>'No Notifications found');
 		}

 		$component = $this->config->item('components_list');
 		$row = array();
 		foreach ($component as $key => $component_value) {
			$where_condition = '';
			if($filter_input != '') {
				$filter_input = '%'.$filter_input.'%';
				$where_condition .= ' AND ';
				$where_condition .= ' (T2.candidate_id LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T2.first_name LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T2.last_name LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T2.father_name LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T2.phone_number LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T2.email_id LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T3.client_id LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T3.client_name LIKE "'.$filter_input.'"';
				$where_condition .= ')';
			}

			if (isset($candidate_id_list) && count($candidate_id_list) > 0) {
				$where_condition .= ' AND T2.candidate_id NOT IN ('.implode(',',  $candidate_id_list).')';
			}

			$query = "SELECT * FROM `".$component_value."` AS T1 INNER JOIN `candidate` AS T2 ON T1.candidate_id = T2.candidate_id INNER JOIN `tbl_client` AS T3 ON T2.client_id = T3.client_id WHERE `assigned_team_id` REGEXP ".$team_id." ".$where_condition." ".$show_case_rules;
 			$result = $this->db->query($query)->result_array();

 			if(count($result) > 0) {
 				$row[$component_value] = $result;
 			}
 		}
 		$final_data = array();

 		$k = 0;
 		foreach ($row as $mainKey => $value) {
 			// 1
 			if($mainKey == 'criminal_checks') {
 				foreach ($value as $criminal_checks_key => $criminal_checks_value) {
 					$assigned_team_ids = explode(",",$criminal_checks_value['assigned_team_id']); 
 					// $court_address = json_decode($court_records_value['address'],true);
 					foreach ($assigned_team_ids as $assigned_team_ids_key => $assigned_team_ids_value) {
 						$analyst_status = explode(",", isset($criminal_checks_value['analyst_status'])?$criminal_checks_value['analyst_status']:'0');
 						if($assigned_team_ids_value == $team_id && ($analyst_status[$assigned_team_ids_key] != '3' && $analyst_status[$assigned_team_ids_key] != '10')){

 							$criminal_checks['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$criminal_checks['component_name'] = $this->get_component_name($criminal_checks['component_id'])[$this->config->item('show_component_name')];
 							$criminal_checks['criminal_check_id'] = $criminal_checks_value['criminal_check_id'];
 							$criminal_checks['candidate_id'] = $criminal_checks_value['candidate_id'];
 							$criminal_checks['candidate_detail'] = $this->getCandidateInfo($criminal_checks_value['candidate_id']);
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
 						if($assigned_team_ids_value == $team_id && ($analyst_status[$assigned_team_ids_key] != '3' &&$analyst_status[$assigned_team_ids_key] != '10')){

 							$court_records['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$court_records['component_name'] = $this->get_component_name($court_records['component_id'])[$this->config->item('show_component_name')];
 							$court_records['court_records_id'] = $court_records_value['court_records_id'];
 							$court_records['candidate_id'] = $court_records_value['candidate_id'];
 							$court_records['candidate_detail'] = $this->getCandidateInfo($court_records_value['candidate_id']);
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
 						if($assigned_team_id_value == $team_id && ($document_analyst_status != "3" && $document_analyst_status != '10')){
		 					$candidateInfo = $this->getCandidateInfo($document_check_value['candidate_id']);
		 					$document_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
		 					$document_check['component_name'] = $this->get_component_name($document_check['component_id'])[$this->config->item('show_component_name')];
		 					$document_check['candidate_id'] = $document_check_value['candidate_id'];
		 					$document_check['candidate_detail'] = $candidateInfo;

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
 			if($mainKey == 'drugtest') {
 				foreach ($value as $subkey => $subValues) {
 					$assigned_team_id = explode(",",$subValues['assigned_team_id']); 
 					// print_r($assigned_team_id);
 					// echo "<br>";
 					$analyst_status = explode(",",isset($subValues['analyst_status'])?$subValues['analyst_status']:'0');
 					foreach ($assigned_team_id as $drugtest_key => $drugtest_value) {
 						$drugtest_analyst_status = isset($analyst_status[$drugtest_key])?$analyst_status[$drugtest_key]:'0'; 
 						if($drugtest_value == $team_id && ($drugtest_analyst_status  != '3' && $drugtest_analyst_status  != '10')){
	 						 
		 					$drugtest['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
		 					$drugtest['component_name'] = $this->get_component_name($drugtest['component_id'])[$this->config->item('show_component_name')];
		 					$drugtest['drugtest_id'] = $subValues['drugtest_id']; 
		 					$drugtest['candidate_id'] = $subValues['candidate_id'];
		 					$drugtest['candidate_detail'] = $this->getCandidateInfo($subValues['candidate_id']);
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
 					if($global_assigned_team_id == $team_id && ($globaldatabase_value['analyst_status'] != '3' && $globaldatabase_value['analyst_status'] != '10')){
	 					$globaldatabase_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
	 					$globaldatabase_value['component_name'] = $this->get_component_name($globaldatabase_value['component_id'])[$this->config->item('show_component_name')];
	 					$globaldatabase_value['candidate_detail'] = $this->getCandidateInfo($globaldatabase_value['candidate_id']);
	 					$globaldatabase_value['index'] = $globaldatabase_key;
	 					array_push($final_data, $globaldatabase_value);
 					}
 				}
 			}

 			//  6
 			if($mainKey == 'current_employment'){
 				foreach ($value as $current_employment_key => $current_employment_value) {
 					$ce_assigned_team_id =isset($current_employment_value['assigned_team_id'])?$current_employment_value['assigned_team_id']:'0';
 					if($ce_assigned_team_id == $team_id && ($current_employment_value['analyst_status'] != '3' && $current_employment_value['analyst_status'] != '10')){
	 					$current_employment_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 						$current_employment_value['component_name'] = $this->get_component_name($current_employment_value['component_id'])[$this->config->item('show_component_name')];
	 					$current_employment_value['candidate_detail'] = $this->getCandidateInfo($current_employment_value['candidate_id']);
	 					$current_employment_value['index'] = 0;
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
 						
 						if($education_details_value == $team_id && ($analyst_status[$education_details_key] != '3' && $analyst_status[$education_details_key] != '10')){
   
		 					$education_details['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
		 					$education_details['component_name'] = $this->get_component_name($education_details['component_id'])[$this->config->item('show_component_name')];
		 					// array_push($education_details, $subValues['education_details_id']);
		 					// array_push($education_details, $subValues['candidate_id']);
		 					$education_details['education_details_id'] = $subValues['education_details_id'];
		 					$education_details['candidate_id'] = $subValues['candidate_id'];
		 					$education_details['candidate_detail'] = $this->getCandidateInfo($subValues['candidate_id']);
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
 					if($pa_assigned_team_id == $team_id && ($present_address_value['analyst_status'] != '3' && $present_address_value['analyst_status'] != '10')){
	 					$present_address_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
	 					$present_address_value['component_name'] = $this->get_component_name($present_address_value['component_id'])[$this->config->item('show_component_name')];
	 					$present_address_value['candidate_detail'] = $this->getCandidateInfo($present_address_value['candidate_id']);
	 					$present_address_value['index'] = $present_address_key;
	 					array_push($final_data, $present_address_value);
 					}
 				}
 			}

 			// 9
 			if($mainKey == 'permanent_address'){
 				foreach ($value as $permanent_address_key => $permanent_address_value) {
 					$pea_assigned_team_id =isset($permanent_address_value['assigned_team_id'])?$permanent_address_value['assigned_team_id']:'0';
 					if($pea_assigned_team_id == $team_id && ($permanent_address_value['analyst_status'] != '3' && $permanent_address_value['analyst_status'] != '10')){
	 					$permanent_address_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
	 					$permanent_address_value['component_name'] = $this->get_component_name($permanent_address_value['component_id'])[$this->config->item('show_component_name')];
	 					$permanent_address_value['candidate_detail'] = $this->getCandidateInfo($permanent_address_value['candidate_id']); 
	 					$permanent_address_value['index'] = $permanent_address_key;
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

 						if($pe_assigned_team_id_value == $team_id && ($analyst_status[$pe_assigned_team_id_key] != '3' && $analyst_status[$pe_assigned_team_id_key] != '10')){
 							
 							$previous_employment['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_employment['component_name'] = $this->get_component_name($previous_employment['component_id'])[$this->config->item('show_component_name')];
 							$previous_employment['previous_emp_id'] = $previous_employment_value['previous_emp_id'];
 							$previous_employment['candidate_id'] = $previous_employment_value['candidate_id']; 
 							$previous_employment['candidate_detail'] = $this->getCandidateInfo($previous_employment_value['candidate_id']);
 							$previous_employment['index'] = $pe_assigned_team_id_key;

 							

 							$status = explode(",",$previous_employment_value['status']);
 							$previous_employment['status'] = isset($status[$pe_assigned_team_id_key])?$status[$pe_assigned_team_id_key]:"";

 							
 							$previous_employment['analyst_status'] = isset($analyst_status[$pe_assigned_team_id_key])?$analyst_status[$pe_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$previous_employment_value['insuff_status']);
		 					$previous_employment['insuff_status'] = isset($insuff_status[$pe_assigned_team_id_key])?$insuff_status[$pe_assigned_team_id_key]:'';

 							$previous_employment['updated_date'] = $previous_employment_value['updated_date'];
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

 						if($reference_assigned_team_id_value == $team_id && ($analyst_status[$reference_assigned_team_id_key] != '3' && $analyst_status[$reference_assigned_team_id_key] != '10')){
 							
 							$reference['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$reference['component_name'] = $this->get_component_name($reference['component_id'])[$this->config->item('show_component_name')];
 							$reference['reference_id'] = $reference_value['reference_id'];
 							$reference['candidate_id'] = $reference_value['candidate_id']; 
 							$reference['candidate_detail'] = $this->getCandidateInfo($reference_value['candidate_id']);
 							$reference['index'] = $reference_assigned_team_id_key;

 							 

 							$status = explode(",",$reference_value['status']);
 							$reference['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";

 							
 							$reference['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$reference_value['insuff_status']);
		 					$reference['insuff_status'] = isset($insuff_status[$reference_assigned_team_id_key])?$insuff_status[$reference_assigned_team_id_key]:'';

 							$reference['updated_date'] = $reference_value['updated_date'];
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
 						if($pa_assigned_team_id_value == $team_id && ($pa_analyst_status!= '3' && $pa_analyst_status != '10')){
 							
 							$previous_address['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_address['component_name'] = $this->get_component_name($previous_address['component_id'])[$this->config->item('show_component_name')];
 							$previous_address['previos_address_id'] = $pa_value['previos_address_id'];
 							$previous_address['candidate_id'] = $pa_value['candidate_id']; 
 							$previous_address['candidate_detail'] = $this->getCandidateInfo($pa_value['candidate_id']);
 							$previous_address['index'] = $pa_assigned_team_id_key; 

 							$status = explode(",",$pa_value['status']);
 							$previous_address['status'] = isset($status[$pa_assigned_team_id_key])?$status[$pa_assigned_team_id_key]:"";

 							
 							$previous_address['analyst_status'] = $pa_analyst_status;

 							$insuff_status = explode(",",$pa_value['insuff_status']);
		 					$previous_address['insuff_status'] = isset($insuff_status[$pa_assigned_team_id_key])?$insuff_status[$pa_assigned_team_id_key]:'';


 							$previous_address['updated_date'] = $pa_value['updated_date'];

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
 						
 						if($dir_assigned_team_id_value == $team_id && ($dirAnalystStatus != '3' && $dirAnalystStatus != '10')){
 							
 							$previous_address['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_address['component_name'] = $this->get_component_name($previous_address['component_id'])[$this->config->item('show_component_name')];
 							$previous_address['directorship_check_id'] = $dir_value['directorship_check_id'];
 							$previous_address['candidate_id'] = $dir_value['candidate_id']; 
 							$previous_address['candidate_detail'] = $this->getCandidateInfo($dir_value['candidate_id']);
 							$previous_address['index'] = $dir_assigned_team_id_key; 

 							$status = explode(",",$dir_value['status']);
 							$previous_address['status'] = isset($status[$dir_assigned_team_id_key])?$status[$dir_assigned_team_id_key]:"";

 							
 							$previous_address['analyst_status'] = isset($dir_analyst_status[$dir_assigned_team_id_key])?$dir_analyst_status[$dir_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$dir_value['insuff_status']);
		 					$previous_address['insuff_status'] = isset($insuff_status[$dir_assigned_team_id_key])?$insuff_status[$dir_assigned_team_id_key]:'';


 							$previous_address['updated_date'] = $dir_value['updated_date'];

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
 						if($sanctions_assigned_team_id_value == $team_id && ($global_sanctions_analyst_status != '3' && $global_sanctions_analyst_status != '10')){
 							
 							$global_sanctions_aml['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$global_sanctions_aml['component_name'] = $this->get_component_name($global_sanctions_aml['component_id'])[$this->config->item('show_component_name')];
 							$global_sanctions_aml['global_sanctions_aml_id'] = $sanctions_value['global_sanctions_aml_id'];
 							$global_sanctions_aml['candidate_id'] = $sanctions_value['candidate_id']; 
 							$global_sanctions_aml['candidate_detail'] = $this->getCandidateInfo($sanctions_value['candidate_id']);
 							$global_sanctions_aml['index'] = $sanctions_assigned_team_id_key; 

 							$status = explode(",",$sanctions_value['status']);
 							$global_sanctions_aml['status'] = isset($status[$sanctions_assigned_team_id_key])?$status[$sanctions_assigned_team_id_key]:"";

 							
 							$global_sanctions_aml['analyst_status'] = $global_sanctions_analyst_status;

 							$insuff_status = explode(",",$sanctions_value['insuff_status']);
		 					$global_sanctions_aml['insuff_status'] = isset($insuff_status[$sanctions_assigned_team_id_key])?$insuff_status[$sanctions_assigned_team_id_key]:'';


 							$global_sanctions_aml['updated_date'] = $sanctions_value['updated_date'];

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
 						if($dl_assigned_team_id_value == $team_id && ($driving_licence_analyst_status != '3' && $driving_licence_analyst_status != '10')){
 							
 							$driving_licence['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$driving_licence['component_name'] = $this->get_component_name($driving_licence['component_id'])[$this->config->item('show_component_name')];
 							$driving_licence['licence_id'] = $dl_value['licence_id'];
 							$driving_licence['candidate_id'] = $dl_value['candidate_id']; 
 							$driving_licence['candidate_detail'] = $this->getCandidateInfo($dl_value['candidate_id']);
 							$driving_licence['index'] = $dl_assigned_team_id_key; 

 							$status = explode(",",$dl_value['status']);
 							$driving_licence['status'] = isset($status[$dl_assigned_team_id_key])?$status[$dl_assigned_team_id_key]:"";

 							
 							$driving_licence['analyst_status'] = $driving_licence_analyst_status;

 							$insuff_status = explode(",",$dl_value['insuff_status']);
		 					$driving_licence['insuff_status'] = isset($insuff_status[$dl_assigned_team_id_key])?$insuff_status[$dl_assigned_team_id_key]:'';


 							$driving_licence['updated_date'] = $dl_value['updated_date'];

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
 						if($cc_assigned_team_id_value == $team_id && ($cc_analyst_status != '3' && $cc_analyst_status != '10')){
 							
 							$credit_cibil['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$credit_cibil['component_name'] = $this->get_component_name($credit_cibil['component_id'])[$this->config->item('show_component_name')];
 							$credit_cibil['credit_id'] = $cc_value['credit_id'];
 							$credit_cibil['candidate_id'] = $cc_value['candidate_id']; 
 							$credit_cibil['candidate_detail'] = $this->getCandidateInfo($cc_value['candidate_id']);
 							$credit_cibil['index'] = $cc_assigned_team_id_key; 

 							$status = explode(",",$cc_value['status']);
 							$credit_cibil['status'] = isset($status[$cc_assigned_team_id_key])?$status[$cc_assigned_team_id_key]:"";

 							
 							$credit_cibil['analyst_status'] = $cc_analyst_status;

 							$insuff_status = explode(",",$cc_value['insuff_status']);
		 					$credit_cibil['insuff_status'] = isset($insuff_status[$cc_assigned_team_id_key])?$insuff_status[$cc_assigned_team_id_key]:'';


 							$credit_cibil['updated_date'] = $cc_value['updated_date'];

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
 						if($bankruptcy_assigned_team_id_value == $team_id && ($analyst_status[$bankruptcy_assigned_team_id_key] != '3' && $analyst_status[$bankruptcy_assigned_team_id_key] != '10')){
 							
 							$bankruptcy['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$bankruptcy['component_name'] = $this->get_component_name($bankruptcy['component_id'])[$this->config->item('show_component_name')];
 							$bankruptcy['bankruptcy_id'] = $bankruptcy_value['bankruptcy_id'];
 							$bankruptcy['candidate_id'] = $bankruptcy_value['candidate_id']; 
 							$bankruptcy['candidate_detail'] = $this->getCandidateInfo($bankruptcy_value['candidate_id']);
 							$bankruptcy['index'] = $bankruptcy_assigned_team_id_key; 

 							$status = explode(",",$bankruptcy_value['status']);
 							$bankruptcy['status'] = isset($status[$bankruptcy_assigned_team_id_key])?$status[$bankruptcy_assigned_team_id_key]:"";

 							
 							$bankruptcy['analyst_status'] = $bankruptcy_analyst_status;

 							$insuff_status = explode(",",$bankruptcy_value['insuff_status']);
		 					$bankruptcy['insuff_status'] = isset($insuff_status[$bankruptcy_assigned_team_id_key])?$insuff_status[$bankruptcy_assigned_team_id_key]:'';


 							$bankruptcy['updated_date'] = $bankruptcy_value['updated_date'];

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
 						if($adm_assigned_team_id_value == $team_id && ($adm_analyst_status != '3' && $adm_analyst_status != '10')){
 							
 							$adm_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$adm_check['component_name'] = $this->get_component_name($adm_check['component_id'])[$this->config->item('show_component_name')];
 							$adm_check['adverse_database_media_check_id'] = $adm_value['adverse_database_media_check_id'];
 							$adm_check['candidate_id'] = $adm_value['candidate_id']; 
 							$adm_check['candidate_detail'] = $this->getCandidateInfo($adm_value['candidate_id']);
 							$adm_check['index'] = $adm_assigned_team_id_key; 

 							$status = explode(",",$adm_value['status']);
 							$adm_check['status'] = isset($status[$adm_assigned_team_id_key])?$status[$adm_assigned_team_id_key]:"";

 							
 							$adm_check['analyst_status'] = $adm_analyst_status;

 							$insuff_status = explode(",",$adm_value['insuff_status']);
		 					$adm_check['insuff_status'] = isset($insuff_status[$adm_assigned_team_id_key])?$insuff_status[$adm_assigned_team_id_key]:'';


 							$adm_check['updated_date'] = $adm_value['updated_date'];

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
 						if($cv_assigned_team_id_value == $team_id && ($cv_analyst_status != '3' && $cv_analyst_status != '10')){
 							
 							$cv_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$cv_check['component_name'] = $this->get_component_name($cv_check['component_id'])[$this->config->item('show_component_name')];
 							$cv_check['cv_id'] = $cv_value['cv_id'];
 							$cv_check['candidate_id'] = $cv_value['candidate_id']; 
 							$cv_check['candidate_detail'] = $this->getCandidateInfo($cv_value['candidate_id']);
 							$cv_check['index'] = $cv_assigned_team_id_key; 

 							$status = explode(",",$cv_value['status']);
 							$cv_check['status'] = isset($status[$cv_assigned_team_id_key])?$status[$cv_assigned_team_id_key]:"";

 							
 							$cv_check['analyst_status'] = $cv_analyst_status;

 							$insuff_status = explode(",",$cv_value['insuff_status']);
		 					$cv_check['insuff_status'] = isset($insuff_status[$cv_assigned_team_id_key])?$insuff_status[$cv_assigned_team_id_key]:'';


 							$cv_check['updated_date'] = $cv_value['updated_date'];

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
 						if($health_assigned_team_id_value == $team_id && ($health_analyst_status != '3' && $health_analyst_status != '10')){
 							
 							$health_checkup['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$health_checkup['component_name'] = $this->get_component_name($health_checkup['component_id'])[$this->config->item('show_component_name')];
 							$health_checkup['health_checkup_id'] = $health_value['health_checkup_id'];
 							$health_checkup['candidate_id'] = $health_value['candidate_id']; 
 							$health_checkup['candidate_detail'] = $this->getCandidateInfo($health_value['candidate_id']);
 							$health_checkup['index'] = $health_assigned_team_id_key; 

 							$status = explode(",",$health_value['status']);
 							$health_checkup['status'] = isset($status[$health_assigned_team_id_key])?$status[$health_assigned_team_id_key]:"";

 							
 							$health_checkup['analyst_status'] = $health_analyst_status;

 							$insuff_status = explode(",",$health_value['insuff_status']);
		 					$health_checkup['insuff_status'] = isset($insuff_status[$health_assigned_team_id_key])?$insuff_status[$health_assigned_team_id_key]:'';


 							$health_checkup['updated_date'] = $health_value['updated_date'];

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
 						if($health_assigned_team_id_value == $team_id && ($health_analyst_status != '3' && $health_analyst_status != '10')){
 							
 							$covid['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$covid['component_name'] = $this->get_component_name($covid['component_id'])[$this->config->item('show_component_name')];
 							$covid['covid_id'] = $health_value['covid_id'];
 							$covid['candidate_id'] = $health_value['candidate_id']; 
 							$covid['candidate_detail'] = $this->getCandidateInfo($health_value['candidate_id']);
 							$covid['index'] = $health_assigned_team_id_key; 

 							$status = explode(",",$health_value['status']);
 							$covid['status'] = isset($status[$health_assigned_team_id_key])?$status[$health_assigned_team_id_key]:"";

 							
 							$covid['analyst_status'] = $health_analyst_status;

 							$insuff_status = explode(",",$health_value['insuff_status']);
		 					$covid['insuff_status'] = isset($insuff_status[$health_assigned_team_id_key])?$insuff_status[$health_assigned_team_id_key]:'';


 							$covid['updated_date'] = $health_value['updated_date'];

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
 						if($eg_assigned_team_id_value == $team_id && ($eg_analyst_status != '3' && $eg_analyst_status != '10')){
 							
 							$eg_checkup['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$eg_checkup['component_name'] = $this->get_component_name($eg_checkup['component_id'])[$this->config->item('show_component_name')];
 							$eg_checkup['gap_id'] = $eg_value['gap_id'];
 							$eg_checkup['candidate_id'] = $eg_value['candidate_id']; 
 							$eg_checkup['candidate_detail'] = $this->getCandidateInfo($eg_value['candidate_id']);
 							$eg_checkup['index'] = $eg_assigned_team_id_key; 

 							$status = explode(",",$eg_value['status']);
 							$eg_checkup['status'] = isset($status[$eg_assigned_team_id_key])?$status[$eg_assigned_team_id_key]:"";

 							
 							$eg_checkup['analyst_status'] = $eg_analyst_status;

 							$insuff_status = explode(",",$eg_value['insuff_status']);
		 					$eg_checkup['insuff_status'] = isset($insuff_status[$eg_assigned_team_id_key])?$insuff_status[$eg_assigned_team_id_key]:'';


 							$eg_checkup['updated_date'] = $eg_value['updated_date'];

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

 						if($reference_assigned_team_id_value == $team_id && ( $analyst_status[$reference_assigned_team_id_key] != '10' && $analyst_status[$reference_assigned_team_id_key] != '3')){
 							
 							$reference['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$reference['component_name'] = $this->get_component_name($reference['component_id'])[$this->config->item('show_component_name')];
 							$reference['landload_id'] = $reference_value['landload_id'];
 							$reference['candidate_id'] = $reference_value['candidate_id']; 
 							$reference['candidate_detail'] = $this->getCandidateInfo($reference_value['candidate_id']);
 							$reference['index'] = $reference_assigned_team_id_key;

 							 

 							$status = explode(",",$reference_value['status']);
 							$reference['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";

 							
 							$reference['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$reference_value['insuff_status']);
		 					$reference['insuff_status'] = isset($insuff_status[$reference_assigned_team_id_key])?$insuff_status[$reference_assigned_team_id_key]:'';

 							$reference['updated_date'] = $reference_value['updated_date'];
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

 						if($reference_assigned_team_id_value == $team_id && ( $analyst_status[$reference_assigned_team_id_key] != '10' && $analyst_status[$reference_assigned_team_id_key] != '3')){
 							
 							$social['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$social['component_name'] = $this->get_component_name($social['component_id'])[$this->config->item('show_component_name')];
 							$social['social_id'] = $reference_value['social_id'];
 							$social['candidate_id'] = $reference_value['candidate_id']; 
 							$social['candidate_detail'] = $this->getCandidateInfo($reference_value['candidate_id']);
 							$social['index'] = $reference_assigned_team_id_key;

 							 

 							$status = explode(",",$reference_value['status']);
 							$social['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";

 							
 							$social['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$reference_value['insuff_status']);
		 					$social['insuff_status'] = isset($insuff_status[$reference_assigned_team_id_key])?$insuff_status[$reference_assigned_team_id_key]:'';

 							$social['updated_date'] = $reference_value['updated_date'];
 							array_push($final_data, $social);
 						}
 					}
 				} 
 			}
 			$components = ['right_to_work','sex_offender','politically_exposed','india_civil_litigation','mca','nric','gsa','oig'];
 			// 22
 			if(in_array($mainKey, $components)){
 				$eg_checkup = [];
 			 	foreach ($value as $pa_key => $eg_value) {
 					$eg_assigned_team_id = explode(",",$eg_value['assigned_team_id']);
 					 
 					foreach ($eg_assigned_team_id as $eg_assigned_team_id_key => $eg_assigned_team_id_value) {
 						$analyst_status = explode(",",$eg_value['analyst_status']);
 						$eg_analyst_status = isset($analyst_status[$eg_assigned_team_id_key])?$analyst_status[$eg_assigned_team_id_key]:"0";
 						if($eg_assigned_team_id_value == $team_id && $eg_analyst_status == '10'){
 							
 							$eg_checkup['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$eg_checkup['component_name'] = $this->get_component_name($eg_checkup['component_id'])[$this->config->item('show_component_name')];
 							// $eg_checkup['right_to_work_id'] = $eg_value['right_to_work_id'];
 							$eg_checkup['candidate_id'] = $eg_value['candidate_id']; 
 							$eg_checkup['candidate_detail'] = $this->getCandidateInfo($eg_value['candidate_id']);
 							$eg_checkup['index'] = $eg_assigned_team_id_key; 

 							$status = explode(",",$eg_value['status']);
 							$eg_checkup['status'] = isset($status[$eg_assigned_team_id_key])?$status[$eg_assigned_team_id_key]:"";

 							
 							$eg_checkup['analyst_status'] = $eg_analyst_status;

 							$insuff_status = explode(",",$eg_value['insuff_status']);
		 					$eg_checkup['insuff_status'] = isset($insuff_status[$eg_assigned_team_id_key])?$insuff_status[$eg_assigned_team_id_key]:'';


 							$eg_checkup['updated_date'] = $eg_value['updated_date'];

 							array_push($final_data, $eg_checkup);
 						}
 					}
 				} 
 			}

 			$k++;
		}
 		$keys = array_column($final_data, 'updated_date'); 
    	array_multisort($keys, SORT_DESC, $final_data);

    	if ($filter_limit == '' || !is_numeric($filter_limit)) {
			$filter_limit = 100;
		}

		$return_data = [];
		foreach($final_data as $key => $value) {
			if ($key + 1 <= $filter_limit) {
				array_push($return_data, $value);
			} else {
				break;
			}
		}
 		return $return_data;
 	}

 	function get_new_priority_cases_count($team_id = '') {
		$filter_limit = $this->input->post('filter_limit');
		$filter_input = $this->input->post('filter_input');
		$candidate_id_list = $this->input->post('candidate_id_list');
		$cases_count = 0;

		$show_cases_rule = $this->db->where('show_cases_rule_status','1')->get('show_cases_rule')->result_array();
		$all_rule_cirteria = json_decode(file_get_contents(base_url().'assets/custom-js/json/rule-criteras.json'),true);
 		$remaining_days_rules = json_decode(file_get_contents(base_url().'assets/custom-js/json/remaining-days-rules.json'),true);
 		$case_priorities = json_decode(file_get_contents(base_url().'assets/custom-js/json/case-priorities.json'),true);

 		$show_case_rules = '';
 		if (count($show_cases_rule) > 0) {
 			foreach ($show_cases_rule as $key => $value) {
 				if ($key == 0) {
 					$show_case_rules .= ' AND (';
 				} else {
 					$show_case_rules .= ' OR ';
 				}
	 			foreach ($all_rule_cirteria as $key2 => $value2) {
	 				if ($value['show_cases_rule_criteria'] == $value2['id']) {
	 					$show_cases_rules = json_decode($value['show_cases_rules'],true);
	 					if ($value['show_cases_rule_criteria'] == '1') {
	 						foreach ($remaining_days_rules as $key3 => $value3) {
	 							if ($show_cases_rules['remaining_days_type'] == $value3['id']) {
									$show_case_rules .= "((DATEDIFF(STR_TO_DATE(T2.tat_end_date,'%Y-%m-%d %H:%i:%s'),CURDATE()) ".$value3['db_symbol']." ".$show_cases_rules['remaining_days_value']." OR DATEDIFF(STR_TO_DATE(T2.tat_end_date,'%d-%m-%Y %H:%i:%s'),CURDATE()) ".$value3['db_symbol']." ".$show_cases_rules['remaining_days_value'].") AND T2.client_id IN (".$value['show_cases_rule_client_id'].") AND T1.analyst_status NOT REGEXP (4))";
	 								break;
	 							}
	 						}
	 					} else if($value['show_cases_rule_criteria'] == '2') {
	 						foreach ($case_priorities as $key3 => $value3) {
	 							if ($show_cases_rules['priority_type'] == $value3['id']) {
	 								$show_case_rules .= "(T2.priority IN (".$value3['id'].") AND T2.client_id IN (".$value['show_cases_rule_client_id'].") AND T1.analyst_status NOT REGEXP (4))";
	 								break;
	 							}
	 						}
	 					}
	 					break;
	 				}
	 			}

	 			if ($key + 1 == count($show_cases_rule)) {
 					$show_case_rules .= ')';
 				}
	 		}
 		} else {
 			return array('status'=>'2','message'=>'No Notifications found');
 		}

 		$component = $this->config->item('components_list');
 		$row = array();
 		foreach ($component as $key => $component_value) {
			if ($filter_limit == '' || !is_numeric($filter_limit)) {
				$filter_limit = 100;
			}

			$where_condition = '';
			if($filter_input != '') {
				$filter_input = '%'.$filter_input.'%';
				$where_condition .= ' AND ';
				$where_condition .= ' (T2.candidate_id LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T2.first_name LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T2.last_name LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T2.father_name LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T2.phone_number LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T2.email_id LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T3.client_id LIKE "'.$filter_input.'"';
				$where_condition .= ' OR T3.client_name LIKE "'.$filter_input.'"';
				$where_condition .= ')';
			}

			if (isset($candidate_id_list) && count($candidate_id_list) > 0) {
				$where_condition .= ' AND T2.candidate_id NOT IN ('.implode(',',  $candidate_id_list).')';
			}

			$query = "SELECT * FROM `".$component_value."` AS T1 INNER JOIN `candidate` AS T2 ON T1.candidate_id = T2.candidate_id INNER JOIN `tbl_client` AS T3 ON T2.client_id = T3.client_id WHERE `assigned_team_id` REGEXP ".$team_id." ".$where_condition." ".$show_case_rules;
 			$result = $this->db->query($query)->result_array();

 			if(count($result) > 0) {
 				$cases_count += count($result);
 			}
 		}

 		return $cases_count;
	}
 
 	function getQcErrorComponentAna($team_id = ''){
 		if ($this->input->post('team_id')) { 
 			$team_id = $this->input->post('team_id');
 		}
 		$component = array('court_records','criminal_checks','current_employment','document_check','drugtest','education_details','globaldatabase','permanent_address','present_address','previous_address','previous_employment','reference','directorship_check','global_sanctions_aml','driving_licence','credit_cibil','bankruptcy','adverse_database_media_check','cv_check','health_checkup','employment_gap_check','landload_reference','covid_19','social_media','civil_check','right_to_work','sex_offender','politically_exposed','india_civil_litigation','mca','nric','gsa','oig');

 		// Total Data for team Id;
 		$row =array();
 		foreach ($component as $key => $value) {
 			$query = "SELECT * FROM ".$value." where  `analyst_status` REGEXP '10' AND `assigned_team_id` REGEXP ".$team_id;
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
 			 
 			// echo $mainKey;
 			if($mainKey == 'landload_reference'){
 				 
 				foreach ($value as $reference_key => $reference_value) {
 					$reference_assigned_team_id = explode(",",$reference_value['assigned_team_id']);
 					 
 					foreach ($reference_assigned_team_id as $reference_assigned_team_id_key => $reference_assigned_team_id_value) {
 						$analyst_status = explode(",",$reference_value['analyst_status']);

 						// if($reference_assigned_team_id_value == $team_id && $analyst_status[$reference_assigned_team_id_key] == '10'){
 							
 							$reference['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$reference['component_name'] = $this->get_component_name($reference['component_id'])[$this->config->item('show_component_name')];
 							$reference['landload_id'] = $reference_value['landload_id'];
 							$reference['candidate_id'] = $reference_value['candidate_id']; 
 							$reference['candidate_detail'] = $this->getCandidateInfo($reference_value['candidate_id']);
 							$reference['index'] = $reference_assigned_team_id_key;

 							 

 							$status = explode(",",$reference_value['status']);
 							$reference['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";

 							
 							$reference['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$reference_value['insuff_status']);
		 					$reference['insuff_status'] = isset($insuff_status[$reference_assigned_team_id_key])?$insuff_status[$reference_assigned_team_id_key]:'';

 							$reference['updated_date'] = $reference_value['updated_date'];
 							array_push($final_data, $reference);
 						}
 					// }
 				} 
 			}

 			// 1
 			if($mainKey == 'criminal_checks'){
 				 foreach ($value as $criminal_checks_key => $criminal_checks_value) {
 					$assigned_team_ids = explode(",",$criminal_checks_value['assigned_team_id']); 
 					// $court_address = json_decode($court_records_value['address'],true);
 					foreach ($assigned_team_ids as $assigned_team_ids_key => $assigned_team_ids_value) {
 						$analyst_status = explode(",", $criminal_checks_value['analyst_status']);
 						if($assigned_team_ids_value == $team_id && $analyst_status[$assigned_team_ids_key] == '10'){

 							$criminal_checks['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$criminal_checks['component_name'] = $this->get_component_name($criminal_checks['component_id'])[$this->config->item('show_component_name')];
 							$criminal_checks['criminal_check_id'] = $criminal_checks_value['criminal_check_id'];
 							$criminal_checks['candidate_id'] = $criminal_checks_value['candidate_id'];
 							$criminal_checks['candidate_detail'] = $this->getCandidateInfo($criminal_checks_value['candidate_id']);
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
 						}
 						
 					}
 					
 				}
 			}

 			// 1
 			if($mainKey == 'civil_check'){
 				 foreach ($value as $criminal_checks_key => $criminal_checks_value) {
 					$assigned_team_ids = explode(",",$criminal_checks_value['assigned_team_id']); 
 					// $court_address = json_decode($court_records_value['address'],true);
 					foreach ($assigned_team_ids as $assigned_team_ids_key => $assigned_team_ids_value) {
 						$analyst_status = explode(",", $criminal_checks_value['analyst_status']);
 						if($assigned_team_ids_value == $team_id && $analyst_status[$assigned_team_ids_key] == '10'){

 							$civil_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$civil_check['component_name'] = $this->get_component_name($criminal_checks['component_id'])[$this->config->item('show_component_name')];
 							$civil_check['civil_check_id'] = $criminal_checks_value['civil_check_id'];
 							$civil_check['candidate_id'] = $criminal_checks_value['candidate_id'];
 							$civil_check['candidate_detail'] = $this->getCandidateInfo($criminal_checks_value['candidate_id']);
 							// $court_records['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							 
 							$court_address = json_decode($criminal_checks_value['address'],true);
 							// print_r($court_address[$assigned_team_ids_key]);
 							// echo "<br>";
 							$civil_check['address'] = isset($court_address[$assigned_team_ids_key]['address'])?$court_address[$assigned_team_ids_key]['address']:'';

 							$pin_code = json_decode($criminal_checks_value['pin_code'],true);
 							$civil_check['pin_code'] = isset($pin_code[$assigned_team_ids_key]['pincode'])?$pin_code[$assigned_team_ids_key]['pincode']:'';
 							
 							$city = json_decode($criminal_checks_value['city'],true);
 							$civil_check['city'] = isset($city[$assigned_team_ids_key]['city'])?$city[$assigned_team_ids_key]['city']:'';
 							 
 							$state = json_decode($criminal_checks_value['state'],true);
 							$civil_check['state'] = isset($state[$assigned_team_ids_key]['state'])?$state[$assigned_team_ids_key]['state']:'';
 							
 							$country = json_decode($criminal_checks_value['country'],true);
 							$civil_check['country'] = isset($country[$assigned_team_ids_key]['country'])?$country[$assigned_team_ids_key]['country']:'';
 							 

 							$status = explode(",", $criminal_checks_value['status']);
 							$civil_check['status'] = isset($status[$assigned_team_ids_key])?$status[$assigned_team_ids_key]:'';
 
 							
 							$civil_check['analyst_status'] = isset($analyst_status[$assigned_team_ids_key])?$analyst_status[$assigned_team_ids_key]:'';

 							$insuff_status = explode(",", $criminal_checks_value['insuff_status']);
 							$civil_check['insuff_status'] = isset($insuff_status[$assigned_team_ids_key])?$insuff_status[$assigned_team_ids_key]:'';

 							$output_status = explode(",", $criminal_checks_value['output_status']);
 							$civil_check['output_status'] = isset($output_status[$assigned_team_ids_key])?$output_status[$assigned_team_ids_key]:'';

 							$assigned_role = explode(",", $criminal_checks_value['assigned_role']);
 							$civil_check['assigned_role'] = isset($assigned_role[$assigned_team_ids_key])?$assigned_role[$assigned_team_ids_key]:'';

 							$assigned_team_id = explode(",", $criminal_checks_value['assigned_team_id']);
 							$civil_check['assigned_team_id'] = isset($assigned_team_id[$assigned_team_ids_key])?$assigned_team_id[$assigned_team_ids_key]:'';
 							
 							$civil_check['created_date'] = $criminal_checks_value['created_date'];
 							$civil_check['updated_date'] = $criminal_checks_value['updated_date'];
 							$civil_check['index'] = $assigned_team_ids_key;
 							array_push($final_data, $civil_check);
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
 						$analyst_status = explode(",", $court_records_value['analyst_status']);
 						if($assigned_team_ids_value == $team_id && $analyst_status[$assigned_team_ids_key] == '10'){

 							$court_records['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$court_records['component_name'] = $this->get_component_name($court_records['component_id'])[$this->config->item('show_component_name')];
 							$court_records['court_records_id'] = $court_records_value['court_records_id'];
 							$court_records['candidate_id'] = $court_records_value['candidate_id'];
 							$court_records['candidate_detail'] = $this->getCandidateInfo($court_records_value['candidate_id']);
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
 							 
 						}
 						
 					}
 					
 				}
 			}

 			// 3
 			if($mainKey == 'document_check'){
 				foreach ($value as $court_records_key => $document_check_value) {
 					$assigned_team_id = explode(",",$document_check_value['assigned_team_id']); 
 					$analyst_status = explode(",",$document_check_value['analyst_status']);
 					foreach ($assigned_team_id as $dc_key => $education_details_value) {
 						if($education_details_value == $team_id && $analyst_status[$dc_key] == '10'){
		 					$candidateInfo = $this->getCandidateInfo($document_check_value['candidate_id']);
		 					$document_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
		 					$document_check['component_name'] = $this->get_component_name($document_check['component_id'])[$this->config->item('show_component_name')];
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
 					foreach ($assigned_team_id as $drugtest_key => $drugtest_value) {
 						$analyst_status = explode(",",$subValues['analyst_status']);
 						if($drugtest_value == $team_id && $analyst_status[$drugtest_key] == '10'){
	 						 
		 					$drugtest['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
		 					$drugtest['component_name'] = $this->get_component_name($drugtest['component_id'])[$this->config->item('show_component_name')];
		 					$drugtest['drugtest_id'] = $subValues['drugtest_id']; 
		 					$drugtest['candidate_id'] = $subValues['candidate_id'];
		 					$drugtest['candidate_detail'] = $this->getCandidateInfo($subValues['candidate_id']);
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
 						}
 						 
 					}
 				}
 				// $final_data[$mainKey] = $drugtest;
 				
 			}
 			// 5
 			if($mainKey == 'globaldatabase'){
 				foreach ($value as $globaldatabase_key => $globaldatabase_value) {
 					if($globaldatabase_value['assigned_team_id'] == $team_id && $globaldatabase_value['analyst_status'] == '10'){
	 					$globaldatabase_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
	 					$globaldatabase_value['component_name'] = $this->get_component_name($globaldatabase_value['component_id'])[$this->config->item('show_component_name')];
	 					$globaldatabase_value['candidate_detail'] = $this->getCandidateInfo($globaldatabase_value['candidate_id']);
	 					$globaldatabase_value['index'] = $globaldatabase_key;
	 					array_push($final_data, $globaldatabase_value);
 					}
 				}
 			}

 			if($mainKey == 'covid_19'){
 				foreach ($value as $covid => $covid_19) {
 					if($covid_19['assigned_team_id'] == $team_id && $covid_19['analyst_status'] == '10'){
	 					$covid_19['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
	 					$covid_19['component_name'] = $this->get_component_name($covid_19['component_id'])[$this->config->item('show_component_name')];
	 					$covid_19['candidate_detail'] = $this->getCandidateInfo($covid_19['candidate_id']);
	 					$covid_19['index'] = $covid;
	 					array_push($final_data, $covid_19);
 					}
 				}
 			}

 			if($mainKey == 'social_media'){
 				foreach ($value as $social_key => $social_value) {
 					if($social_value['assigned_team_id'] == $team_id && $social_value['analyst_status'] == '10'){
	 					$social_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
	 					$social_value['component_name'] = $this->get_component_name($social_value['component_id'])[$this->config->item('show_component_name')];
	 					$social_value['candidate_detail'] = $this->getCandidateInfo($social_value['candidate_id']);
	 					$social_value['index'] = $social_key;
	 					array_push($final_data, $social_value);
 					}
 				}
 			}

 			//  6
 			if($mainKey == 'current_employment'){
 				foreach ($value as $current_employment_key => $current_employment_value) { 
 					if($current_employment_value['assigned_team_id'] == $team_id && $current_employment_value['analyst_status'] == '10'){
	 					$current_employment_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 						$current_employment_value['component_name'] = $this->get_component_name($current_employment_value['component_id'])[$this->config->item('show_component_name')];
	 					$current_employment_value['candidate_detail'] = $this->getCandidateInfo($current_employment_value['candidate_id']);
	 					$current_employment_value['index'] = 0;
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
 						if($education_details_value == $team_id && $analyst_status[$education_details_key] == '10'){
   
		 					$education_details['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
		 					$education_details['component_name'] = $this->get_component_name($education_details['component_id'])[$this->config->item('show_component_name')];
		 					// array_push($education_details, $subValues['education_details_id']);
		 					// array_push($education_details, $subValues['candidate_id']);
		 					$education_details['education_details_id'] = $subValues['education_details_id'];
		 					$education_details['candidate_id'] = $subValues['candidate_id'];
		 					$education_details['candidate_detail'] = $this->getCandidateInfo($subValues['candidate_id']);
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
 						}
 					}
 				}
 				// $final_data[$mainKey] = $education_details;
 				
 			}
 			// 8

 			if($mainKey == 'present_address'){
 				foreach ($value as $present_address_key => $present_address_value) { 
 					if($present_address_value['assigned_team_id'] == $team_id && $present_address_value['analyst_status'] == '10'){
	 					$present_address_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
	 					$present_address_value['component_name'] = $this->get_component_name($present_address_value['component_id'])[$this->config->item('show_component_name')];
	 					$present_address_value['candidate_detail'] = $this->getCandidateInfo($present_address_value['candidate_id']);
	 					$present_address_value['index'] = $present_address_key;
	 					array_push($final_data, $present_address_value);
 					}
 				}
 			}

 			// 9
 			if($mainKey == 'permanent_address'){
 				foreach ($value as $permanent_address_key => $permanent_address_value) {
 					if($permanent_address_value['assigned_team_id'] == $team_id && $permanent_address_value['analyst_status'] == '10'){
	 					$permanent_address_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
	 					$permanent_address_value['component_name'] = $this->get_component_name($permanent_address_value['component_id'])[$this->config->item('show_component_name')];
	 					$permanent_address_value['candidate_detail'] = $this->getCandidateInfo($permanent_address_value['candidate_id']); 
	 					$permanent_address_value['index'] = $permanent_address_key;
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

 						if($pe_assigned_team_id_value == $team_id && $analyst_status[$pe_assigned_team_id_key] == '10'){
 							
 							$previous_employment['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_employment['component_name'] = $this->get_component_name($previous_employment['component_id'])[$this->config->item('show_component_name')];
 							$previous_employment['previous_emp_id'] = $previous_employment_value['previous_emp_id'];
 							$previous_employment['candidate_id'] = $previous_employment_value['candidate_id']; 
 							$previous_employment['candidate_detail'] = $this->getCandidateInfo($previous_employment_value['candidate_id']);
 							$previous_employment['index'] = $pe_assigned_team_id_key;

 							

 							$status = explode(",",$previous_employment_value['status']);
 							$previous_employment['status'] = isset($status[$pe_assigned_team_id_key])?$status[$pe_assigned_team_id_key]:"";

 							
 							$previous_employment['analyst_status'] = isset($analyst_status[$pe_assigned_team_id_key])?$analyst_status[$pe_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$previous_employment_value['insuff_status']);
		 					$previous_employment['insuff_status'] = isset($insuff_status[$pe_assigned_team_id_key])?$insuff_status[$pe_assigned_team_id_key]:'';

 							$previous_employment['updated_date'] = $previous_employment_value['updated_date'];
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

 						if($reference_assigned_team_id_value == $team_id && $analyst_status[$reference_assigned_team_id_key] == '10'){
 							
 							$reference['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$reference['component_name'] = $this->get_component_name($reference['component_id'])[$this->config->item('show_component_name')];
 							$reference['reference_id'] = $reference_value['reference_id'];
 							$reference['candidate_id'] = $reference_value['candidate_id']; 
 							$reference['candidate_detail'] = $this->getCandidateInfo($reference_value['candidate_id']);
 							$reference['index'] = $reference_assigned_team_id_key;

 							 

 							$status = explode(",",$reference_value['status']);
 							$reference['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";

 							
 							$reference['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	

 							$insuff_status = explode(",",$reference_value['insuff_status']);
		 					$reference['insuff_status'] = isset($insuff_status[$reference_assigned_team_id_key])?$insuff_status[$reference_assigned_team_id_key]:'';

 							$reference['updated_date'] = $reference_value['updated_date'];
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

 						if($pa_assigned_team_id_value == $team_id && $analyst_status[$pa_assigned_team_id_key] == '10'){
 							
 							$previous_address['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_address['component_name'] = $this->get_component_name($previous_address['component_id'])[$this->config->item('show_component_name')];
 							$previous_address['previos_address_id'] = $pa_value['previos_address_id'];
 							$previous_address['candidate_id'] = $pa_value['candidate_id']; 
 							$previous_address['candidate_detail'] = $this->getCandidateInfo($pa_value['candidate_id']);
 							$previous_address['index'] = $pa_assigned_team_id_key; 

 							$status = explode(",",$pa_value['status']);
 							$previous_address['status'] = isset($status[$pa_assigned_team_id_key])?$status[$pa_assigned_team_id_key]:"";

 							
 							$previous_address['analyst_status'] = isset($analyst_status[$pa_assigned_team_id_key])?$analyst_status[$pa_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$pa_value['insuff_status']);
		 					$previous_address['insuff_status'] = isset($insuff_status[$pa_assigned_team_id_key])?$insuff_status[$pa_assigned_team_id_key]:'';


 							$previous_address['updated_date'] = $pa_value['updated_date'];

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
 						$analyst_status = explode(",",$dir_value['analyst_status']);

 						if($dir_assigned_team_id_value == $team_id &&  $analyst_status[$dir_assigned_team_id_key] == '10'){
 							
 							$previous_address['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_address['component_name'] = $this->get_component_name($previous_address['component_id'])[$this->config->item('show_component_name')];
 							$previous_address['directorship_check_id'] = $dir_value['directorship_check_id'];
 							$previous_address['candidate_id'] = $dir_value['candidate_id']; 
 							$previous_address['candidate_detail'] = $this->getCandidateInfo($dir_value['candidate_id']);
 							$previous_address['index'] = $dir_assigned_team_id_key; 

 							$status = explode(",",$dir_value['status']);
 							$previous_address['status'] = isset($status[$dir_assigned_team_id_key])?$status[$dir_assigned_team_id_key]:"";

 							
 							$previous_address['analyst_status'] = isset($analyst_status[$dir_assigned_team_id_key])?$analyst_status[$dir_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$dir_value['insuff_status']);
		 					$previous_address['insuff_status'] = isset($insuff_status[$dir_assigned_team_id_key])?$insuff_status[$dir_assigned_team_id_key]:'';


 							$previous_address['updated_date'] = $dir_value['updated_date'];

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

 						if($sanctions_assigned_team_id_value == $team_id && $analyst_status[$sanctions_assigned_team_id_key] == '10'){
 							
 							$global_sanctions_aml['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$global_sanctions_aml['component_name'] = $this->get_component_name($global_sanctions_aml['component_id'])[$this->config->item('show_component_name')];
 							$global_sanctions_aml['global_sanctions_aml_id'] = $sanctions_value['global_sanctions_aml_id'];
 							$global_sanctions_aml['candidate_id'] = $sanctions_value['candidate_id']; 
 							$global_sanctions_aml['candidate_detail'] = $this->getCandidateInfo($sanctions_value['candidate_id']);
 							$global_sanctions_aml['index'] = $sanctions_assigned_team_id_key; 

 							$status = explode(",",$sanctions_value['status']);
 							$global_sanctions_aml['status'] = isset($status[$sanctions_assigned_team_id_key])?$status[$sanctions_assigned_team_id_key]:"";

 							
 							$global_sanctions_aml['analyst_status'] = isset($analyst_status[$sanctions_assigned_team_id_key])?$analyst_status[$sanctions_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$sanctions_value['insuff_status']);
		 					$global_sanctions_aml['insuff_status'] = isset($insuff_status[$sanctions_assigned_team_id_key])?$insuff_status[$sanctions_assigned_team_id_key]:'';


 							$global_sanctions_aml['updated_date'] = $sanctions_value['updated_date'];

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

 						if($dl_assigned_team_id_value == $team_id &&  $analyst_status[$dl_assigned_team_id_key] == '10'){
 							
 							$driving_licence['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$driving_licence['component_name'] = $this->get_component_name($driving_licence['component_id'])[$this->config->item('show_component_name')];
 							$driving_licence['licence_id'] = $dl_value['licence_id'];
 							$driving_licence['candidate_id'] = $dl_value['candidate_id']; 
 							$driving_licence['candidate_detail'] = $this->getCandidateInfo($dl_value['candidate_id']);
 							$driving_licence['index'] = $dl_assigned_team_id_key; 

 							$status = explode(",",$dl_value['status']);
 							$driving_licence['status'] = isset($status[$dl_assigned_team_id_key])?$status[$dl_assigned_team_id_key]:"";

 							
 							$driving_licence['analyst_status'] = isset($analyst_status[$dl_assigned_team_id_key])?$analyst_status[$dl_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$dl_value['insuff_status']);
		 					$driving_licence['insuff_status'] = isset($insuff_status[$dl_assigned_team_id_key])?$insuff_status[$dl_assigned_team_id_key]:'';


 							$driving_licence['updated_date'] = $dl_value['updated_date'];

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

 						if($cc_assigned_team_id_value == $team_id && $analyst_status[$cc_assigned_team_id_key] == '10'){
 							
 							$credit_cibil['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$credit_cibil['component_name'] = $this->get_component_name($credit_cibil['component_id'])[$this->config->item('show_component_name')];
 							$credit_cibil['credit_id'] = $cc_value['credit_id'];
 							$credit_cibil['candidate_id'] = $cc_value['candidate_id']; 
 							$credit_cibil['candidate_detail'] = $this->getCandidateInfo($cc_value['candidate_id']);
 							$credit_cibil['index'] = $cc_assigned_team_id_key; 

 							$status = explode(",",$cc_value['status']);
 							$credit_cibil['status'] = isset($status[$cc_assigned_team_id_key])?$status[$cc_assigned_team_id_key]:"";

 							
 							$credit_cibil['analyst_status'] = isset($analyst_status[$cc_assigned_team_id_key])?$analyst_status[$cc_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$cc_value['insuff_status']);
		 					$credit_cibil['insuff_status'] = isset($insuff_status[$cc_assigned_team_id_key])?$insuff_status[$cc_assigned_team_id_key]:'';


 							$credit_cibil['updated_date'] = $cc_value['updated_date'];

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

 						if($bankruptcy_assigned_team_id_value == $team_id &&  $analyst_status[$bankruptcy_assigned_team_id_key] == '10'){
 							
 							$bankruptcy['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$bankruptcy['component_name'] = $this->get_component_name($bankruptcy['component_id'])[$this->config->item('show_component_name')];
 							$bankruptcy['bankruptcy_id'] = $bankruptcy_value['bankruptcy_id'];
 							$bankruptcy['candidate_id'] = $bankruptcy_value['candidate_id']; 
 							$bankruptcy['candidate_detail'] = $this->getCandidateInfo($bankruptcy_value['candidate_id']);
 							$bankruptcy['index'] = $bankruptcy_assigned_team_id_key; 

 							$status = explode(",",$bankruptcy_value['status']);
 							$bankruptcy['status'] = isset($status[$bankruptcy_assigned_team_id_key])?$status[$bankruptcy_assigned_team_id_key]:"";

 							
 							$bankruptcy['analyst_status'] = isset($analyst_status[$bankruptcy_assigned_team_id_key])?$analyst_status[$bankruptcy_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$bankruptcy_value['insuff_status']);
		 					$bankruptcy['insuff_status'] = isset($insuff_status[$bankruptcy_assigned_team_id_key])?$insuff_status[$bankruptcy_assigned_team_id_key]:'';


 							$bankruptcy['updated_date'] = $bankruptcy_value['updated_date'];

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

 						if($adm_assigned_team_id_value == $team_id &&  $analyst_status[$adm_assigned_team_id_key] == '10'){
 							
 							$global_sanctions_aml['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$global_sanctions_aml['component_name'] = $this->get_component_name($global_sanctions_aml['component_id'])[$this->config->item('show_component_name')];
 							$global_sanctions_aml['adverse_database_media_check_id'] = $adm_value['adverse_database_media_check_id'];
 							$global_sanctions_aml['candidate_id'] = $adm_value['candidate_id']; 
 							$global_sanctions_aml['candidate_detail'] = $this->getCandidateInfo($adm_value['candidate_id']);
 							$global_sanctions_aml['index'] = $adm_assigned_team_id_key; 

 							$status = explode(",",$adm_value['status']);
 							$global_sanctions_aml['status'] = isset($status[$adm_assigned_team_id_key])?$status[$adm_assigned_team_id_key]:"";

 							
 							$global_sanctions_aml['analyst_status'] = isset($analyst_status[$adm_assigned_team_id_key])?$analyst_status[$adm_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$adm_value['insuff_status']);
		 					$global_sanctions_aml['insuff_status'] = isset($insuff_status[$adm_assigned_team_id_key])?$insuff_status[$adm_assigned_team_id_key]:'';


 							$global_sanctions_aml['updated_date'] = $adm_value['updated_date'];

 							array_push($final_data, $global_sanctions_aml);
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

 						if($cv_assigned_team_id_value == $team_id && $analyst_status[$cv_assigned_team_id_key] == '10'){
 							
 							$cv_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$cv_check['component_name'] =$this->get_component_name($cv_check['component_id'])[$this->config->item('show_component_name')];
 							$cv_check['cv_id'] = $cv_value['cv_id'];
 							$cv_check['candidate_id'] = $cv_value['candidate_id']; 
 							$cv_check['candidate_detail'] = $this->getCandidateInfo($cv_value['candidate_id']);
 							$cv_check['index'] = $cv_assigned_team_id_key; 

 							$status = explode(",",$cv_value['status']);
 							$cv_check['status'] = isset($status[$cv_assigned_team_id_key])?$status[$cv_assigned_team_id_key]:"";

 							
 							$cv_check['analyst_status'] = isset($analyst_status[$cv_assigned_team_id_key])?$analyst_status[$cv_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$cv_value['insuff_status']);
		 					$cv_check['insuff_status'] = isset($insuff_status[$cv_assigned_team_id_key])?$insuff_status[$cv_assigned_team_id_key]:'';


 							$cv_check['updated_date'] = $cv_value['updated_date'];

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

 						if($health_assigned_team_id_value == $team_id &&  $analyst_status[$health_assigned_team_id_key] == '10'){
 							
 							$health_checkup['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$health_checkup['component_name'] = $this->get_component_name($health_checkup['component_id'])[$this->config->item('show_component_name')];
 							$health_checkup['health_checkup_id'] = $health_value['health_checkup_id'];
 							$health_checkup['candidate_id'] = $health_value['candidate_id']; 
 							$health_checkup['candidate_detail'] = $this->getCandidateInfo($health_value['candidate_id']);
 							$health_checkup['index'] = $health_assigned_team_id_key; 

 							$status = explode(",",$health_value['status']);
 							$health_checkup['status'] = isset($status[$health_assigned_team_id_key])?$status[$health_assigned_team_id_key]:"";

 							
 							$health_checkup['analyst_status'] = isset($analyst_status[$health_assigned_team_id_key])?$analyst_status[$health_assigned_team_id_key]:"";

 							$insuff_status = explode(",",$health_value['insuff_status']);
		 					$health_checkup['insuff_status'] = isset($insuff_status[$health_assigned_team_id_key])?$insuff_status[$health_assigned_team_id_key]:'';


 							$health_checkup['updated_date'] = $health_value['updated_date'];

 							array_push($final_data, $health_checkup);
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
 						if($eg_assigned_team_id_value == $team_id && $eg_analyst_status == '10'){
 							
 							$eg_checkup['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$eg_checkup['component_name'] = $this->get_component_name($eg_checkup['component_id'])[$this->config->item('show_component_name')];
 							$eg_checkup['gap_id'] = $eg_value['gap_id'];
 							$eg_checkup['candidate_id'] = $eg_value['candidate_id']; 
 							$eg_checkup['candidate_detail'] = $this->getCandidateInfo($eg_value['candidate_id']);
 							$eg_checkup['index'] = $eg_assigned_team_id_key; 

 							$status = explode(",",$eg_value['status']);
 							$eg_checkup['status'] = isset($status[$eg_assigned_team_id_key])?$status[$eg_assigned_team_id_key]:"";

 							
 							$eg_checkup['analyst_status'] = $eg_analyst_status;

 							$insuff_status = explode(",",$eg_value['insuff_status']);
		 					$eg_checkup['insuff_status'] = isset($insuff_status[$eg_assigned_team_id_key])?$insuff_status[$eg_assigned_team_id_key]:'';


 							$eg_checkup['updated_date'] = $eg_value['updated_date'];

 							array_push($final_data, $eg_checkup);
 						}
 					}
 				} 
 			}
 			$components = ['right_to_work','sex_offender','politically_exposed','india_civil_litigation','mca','nric','gsa','oig'];
 			// 22
 			if(in_array($mainKey, $components)){
 				$eg_checkup = [];
 			 	foreach ($value as $pa_key => $eg_value) {
 					$eg_assigned_team_id = explode(",",$eg_value['assigned_team_id']);
 					 
 					foreach ($eg_assigned_team_id as $eg_assigned_team_id_key => $eg_assigned_team_id_value) {
 						$analyst_status = explode(",",$eg_value['analyst_status']);
 						$eg_analyst_status = isset($analyst_status[$eg_assigned_team_id_key])?$analyst_status[$eg_assigned_team_id_key]:"0";
 						if($eg_assigned_team_id_value == $team_id && $eg_analyst_status == '10'){
 							
 							$eg_checkup['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$eg_checkup['component_name'] = $this->get_component_name($eg_checkup['component_id'])[$this->config->item('show_component_name')];
 							// $eg_checkup['right_to_work_id'] = $eg_value['right_to_work_id'];
 							$eg_checkup['candidate_id'] = $eg_value['candidate_id']; 
 							$eg_checkup['candidate_detail'] = $this->getCandidateInfo($eg_value['candidate_id']);
 							$eg_checkup['index'] = $eg_assigned_team_id_key; 

 							$status = explode(",",$eg_value['status']);
 							$eg_checkup['status'] = isset($status[$eg_assigned_team_id_key])?$status[$eg_assigned_team_id_key]:"";

 							
 							$eg_checkup['analyst_status'] = $eg_analyst_status;

 							$insuff_status = explode(",",$eg_value['insuff_status']);
		 					$eg_checkup['insuff_status'] = isset($insuff_status[$eg_assigned_team_id_key])?$insuff_status[$eg_assigned_team_id_key]:'';


 							$eg_checkup['updated_date'] = $eg_value['updated_date'];

 							array_push($final_data, $eg_checkup);
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
 
 	function getCandidateInfo($candidate_id){
 		 
 		$candidate = "SELECT first_name, last_name, phone_number,client_id,form_values,employee_id FROM candidate where `candidate_id` =".$candidate_id;
 		 
 		$result = $this->db->query($candidate)->row_array();
 		$client_id = isset($result['client_id'])?$result['client_id']:'0';
 		$result['client_name'] = $this->getClientInfo($client_id);
 		return $result;
 	}

 	function getClientInfo($client_id){
 		$tbl_client = "SELECT client_name  FROM tbl_client where `client_id` =".$client_id;
 		$result = $this->db->query($tbl_client)->row_array();
 		return isset($result['client_name'])?$result['client_name']:'-';
 	}


 	function insert_report_component_lists($candidate_id,$component_list){

 		if ($component_list ==null || $component_list =='') {
 			return array('status'=>0,'msg'=>'failled');
 		}
 		$data = array(
 			'component_list'=>implode(',', $component_list),
 			'component_id'=>$candidate_id,
 			'added_role'=>'outputqc',
 		);
 		if ($this->db->insert('bgv_report_nomenclature',$data)) {
 			return array('status'=>1,'msg'=>'success');
 		}else{
 			return array('status'=>0,'msg'=>'failled');
 		}
 	}
 	
 	function send_insuff_email_to_client($variable_array) {
 		$candidate_details = $variable_array['candidate_details'];
 		$client_id = $candidate_details['client_id'];
 		$client_details = $this->db->where('client_id',$client_id)->get('tbl_client')->row_array();
 		if ($client_details['notification_to_client_for_insuff_status'] != '' && $client_details['notification_to_client_for_insuff_status'] != 0) {
 			if (in_array(2, explode(',', $client_details['notification_to_client_for_insuff_types']))) {
 				$where_condition = array(
 					'client_id' => $client_id,
 					'template_satus' => 1
 				);
 				$get_insuff_email_template = $this->db->where($where_condition)->get('insuff_email_to_client_template')->row_array();
 				if ($get_insuff_email_template != '') {
					$where_condition_2 = array(
						'client_id' => $client_id,
						'spoc_status' => 1
					);
					$client_spoc_list = $this->db->where($where_condition_2)->get('tbl_clientspocdetails')->result_array();
					if (count($client_spoc_list) > 0) {
						foreach ($client_spoc_list as $key => $value) {
							$variable_array = array(
		 						'add_html_tags' => 1,
		 						'template' => $get_insuff_email_template['template'],
		 						'candidate_id' => $candidate_details['candidate_id'],
		 						'spoc_email_id' => $value['spoc_email_id']
		 					);
							$insuff_mail_to_client = $this->emailModel->dynamic_email_template_add_values($variable_array);
							$variable_array = array(
								'mail_to' => $value['spoc_email_id'],
								'mail_subject' => 'Insufficiency Raised for '.$candidate_details['first_name'].' '.$candidate_details['last_name'],
								'mail_message' => $insuff_mail_to_client['template'],
								'attachment_available' => 0
							);
							$this->emailModel->send_mail_v2($variable_array);
						}
					}
 				}
 			}
 		}
 	}



 	/*new components */

 	function update_sex_offender($client_docs){
		$index = 0;
		$isChanged = '0';
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		$sex_offender_id = $this->input->post('sex_offender_id');
		$priority = $this->input->post('priority');
		$table_name = 'sex_offender'; 

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$assigned_info = $this->db->select('*')->from($table_name)->where('sex_offender_id',$sex_offender_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('sex_offender_id',$sex_offender_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$sex_offender = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status_date' => date('d-m-Y H:i:s'),
			'output_status'=>'0'
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status)?$analyst_status:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$sex_offender['status'] = 4;
		}

		// print_r($assigned_info);
		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$index = '0';
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$sex_offender['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			$index = '0';
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'28',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$sex_offender['analyst_status'] = $analyst_status;
				$sex_offender['assigned_role'] = $qc_roles['role'];
				$sex_offender['assigned_team_id'] = $team_id;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $sex_offender['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$sex_offender['analyst_status'] = $analyst_status;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			$sex_offender['analyst_status'] = $analyst_status;
				

			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			 $index='0';
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'28',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$sex_offender['analyst_status'] = $analyst_status;
				$sex_offender['insuff_team_role'] = $qc_roles['role'];
				$sex_offender['insuff_team_id'] = $team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$sex_offender['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{
				$sex_offender['analyst_status'] = $analyst_status;
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}else{
			$sex_offender['analyst_status'] = $analyst_status;
		}

		if (count($client_docs) > 0) {
			$sex_offender['approved_doc'] = implode(',',$client_docs);
		}  

		// print_r($reference_remark_data);
		// echo json_encode($global_db);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('sex_offender',$sex_offender)) {
			 
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$sex_offender['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('sex_offender_log',$sex_offender);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}


 	function update_politically_exposed($client_docs){
		$index = 0;
		$isChanged = '0';
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		$politically_exposed_id = $this->input->post('politically_exposed_id');
		$priority = $this->input->post('priority');
		$table_name = 'politically_exposed';
		$permanent_address_id = $this->input->post('permanent_address_id');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$assigned_info = $this->db->select('*')->from($table_name)->where('politically_exposed_id',$politically_exposed_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('politically_exposed_id',$politically_exposed_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$politically_exposed = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status_date' => date('d-m-Y H:i:s'),
			'output_status'=>'0'
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status)?$analyst_status:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$politically_exposed['status'] = 4;
		}

		// print_r($assigned_info);
		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$index = '0';
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$politically_exposed['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			$index = '0';
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'29',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$politically_exposed['analyst_status'] = $analyst_status;
				$politically_exposed['assigned_role'] = $qc_roles['role'];
				$politically_exposed['assigned_team_id'] = $team_id;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $politically_exposed['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$politically_exposed['analyst_status'] = $analyst_status;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			$politically_exposed['analyst_status'] = $analyst_status;
				

			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			 $index='0';
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'29',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$politically_exposed['analyst_status'] = $analyst_status;
				$politically_exposed['insuff_team_role'] = $qc_roles['role'];
				$politically_exposed['insuff_team_id'] = $team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$politically_exposed['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{
				$politically_exposed['analyst_status'] = $analyst_status;
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}else{
			$politically_exposed['analyst_status'] = $analyst_status;
		}

		if (count($client_docs) > 0) {
			$politically_exposed['approved_doc'] = implode(',',$client_docs);
		}  

		// print_r($reference_remark_data);
		// echo json_encode($global_db);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('politically_exposed',$politically_exposed)) {
			 
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$politically_exposed['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('politically_exposed_log',$politically_exposed);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}


 	function update_india_civil_litigation($client_docs){
		$index = 0;
		$isChanged = '0';
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		$india_civil_litigation_id = $this->input->post('india_civil_litigation_id');
		$priority = $this->input->post('priority');
		$table_name = 'india_civil_litigation';
		$permanent_address_id = $this->input->post('permanent_address_id');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$assigned_info = $this->db->select('*')->from($table_name)->where('india_civil_litigation_id',$india_civil_litigation_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('india_civil_litigation_id',$india_civil_litigation_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$india_civil_litigation = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status_date' => date('d-m-Y H:i:s'),
			'output_status'=>'0'
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status)?$analyst_status:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$india_civil_litigation['status'] = 4;
		}

		// print_r($assigned_info);
		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$index = '0';
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$india_civil_litigation['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			$index = '0';
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'30',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$india_civil_litigation['analyst_status'] = $analyst_status;
				$india_civil_litigation['assigned_role'] = $qc_roles['role'];
				$india_civil_litigation['assigned_team_id'] = $team_id;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $india_civil_litigation['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$india_civil_litigation['analyst_status'] = $analyst_status;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			$india_civil_litigation['analyst_status'] = $analyst_status;
				

			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			 $index='0';
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'30',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$india_civil_litigation['analyst_status'] = $analyst_status;
				$india_civil_litigation['insuff_team_role'] = $qc_roles['role'];
				$india_civil_litigation['insuff_team_id'] = $team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$india_civil_litigation['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{
				$india_civil_litigation['analyst_status'] = $analyst_status;
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}else{
			$india_civil_litigation['analyst_status'] = $analyst_status;
		}

		if (count($client_docs) > 0) {
			$india_civil_litigation['approved_doc'] = implode(',',$client_docs);
		}  

		// print_r($reference_remark_data);
		// echo json_encode($global_db);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('india_civil_litigation',$india_civil_litigation)) {
			 
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$india_civil_litigation['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('india_civil_litigation_log',$india_civil_litigation);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}


 	function update_oig($client_docs){
		$index = 0;
		$isChanged = '0';
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		$oig_id = $this->input->post('oig_id');
		$priority = $this->input->post('priority');
		$table_name = 'oig';
		$permanent_address_id = $this->input->post('permanent_address_id');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$assigned_info = $this->db->select('*')->from($table_name)->where('oig_id',$oig_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('oig_id',$oig_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$oig = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status_date' => date('d-m-Y H:i:s'),
			'output_status'=>'0'
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status)?$analyst_status:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$oig['status'] = 4;
		}

		// print_r($assigned_info);
		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$index = '0';
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$directorship_check_data['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			$index = '0';
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'34',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$oig['analyst_status'] = $analyst_status;
				$oig['assigned_role'] = $qc_roles['role'];
				$oig['assigned_team_id'] = $team_id;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $oig['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$oig['analyst_status'] = $analyst_status;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			$oig['analyst_status'] = $analyst_status;
				

			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			 $index='0';
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'34',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$oig['analyst_status'] = $analyst_status;
				$oig['insuff_team_role'] = $qc_roles['role'];
				$oig['insuff_team_id'] = $team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$oig['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{
				$oig['analyst_status'] = $analyst_status;
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}else{
			$oig['analyst_status'] = $analyst_status;
		}

		if (count($client_docs) > 0) {
			$oig['approved_doc'] = implode(',',$client_docs);
		}  

		// print_r($reference_remark_data);
		// echo json_encode($global_db);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('oig',$oig)) {
			 
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$oig['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('oig_log',$oig);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}


 	function update_gsa($client_docs){
		$index = 0;
		$isChanged = '0';
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		$gsa_id = $this->input->post('gsa_id');
		$priority = $this->input->post('priority');
		$table_name = 'gsa';
		$permanent_address_id = $this->input->post('permanent_address_id');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$assigned_info = $this->db->select('*')->from($table_name)->where('gsa_id',$gsa_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('gsa_id',$gsa_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$gsa = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status_date' => date('d-m-Y H:i:s'),
			'output_status'=>'0'
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status)?$analyst_status:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$gsa['status'] = 4;
		}

		// print_r($assigned_info);
		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$index = '0';
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status== '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$gsa['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			$index = '0';
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'33',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$gsa['analyst_status'] = $analyst_status;
				$gsa['assigned_role'] = $qc_roles['role'];
				$gsa['assigned_team_id'] = $team_id;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $gsa['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$gsa['analyst_status'] = $analyst_status;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			$gsa['analyst_status'] = $analyst_status;
				

			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			 $index='0';
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'33',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$gsa['analyst_status'] = $analyst_status;
				$gsa['insuff_team_role'] = $qc_roles['role'];
				$gsa['insuff_team_id'] = $team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$gsa['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{
				$gsa['analyst_status'] = $analyst_status;
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}else{
			$gsa['analyst_status'] = $analyst_status;
		}

		if (count($client_docs) > 0) {
			$gsa['approved_doc'] = implode(',',$client_docs);
		}  

		// print_r($reference_remark_data);
		// echo json_encode($global_db);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('gsa',$gsa)) {
			 
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$gsa['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('gsa_log',$gsa);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}


 	function update_mca($client_docs){
		$index = 0;
		$isChanged = '0';
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		$mca_id = $this->input->post('mca_id');
		$priority = $this->input->post('priority');
		$table_name = 'mca';
		$permanent_address_id = $this->input->post('permanent_address_id');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$assigned_info = $this->db->select('*')->from($table_name)->where('mca_id',$mca_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('mca_id',$mca_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$mca = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status_date' => date('d-m-Y H:i:s'),
			'output_status'=>'0'
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status)?$analyst_status:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$mca['status'] = 4;
		}

		// print_r($assigned_info);
		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$index = '0';
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$mca['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			$index = '0';
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'31',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$mca['analyst_status'] = $analyst_status;
				$mca['assigned_role'] = $qc_roles['role'];
				$mca['assigned_team_id'] = $team_id;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $mca['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$mca['analyst_status'] = $analyst_status;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			$mca['analyst_status'] = $analyst_status;
				

			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			 $index='0';
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'31',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$mca['analyst_status'] = $analyst_status;
				$mca['insuff_team_role'] = $qc_roles['role'];
				$mca['insuff_team_id'] = $team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$mca['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{
				$mca['analyst_status'] = $analyst_status;
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}else{
			$mca['analyst_status'] = $analyst_status;
		}

		if (count($client_docs) > 0) {
			$mca['approved_doc'] = implode(',',$client_docs);
		}  

		// print_r($reference_remark_data);
		// echo json_encode($global_db);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('mca',$mca)) {
			 
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$mca['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('mca_log',$mca);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}


 	function update_nric($client_docs){
		$index = 0;
		$isChanged = '0';
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		$nric_id = $this->input->post('nric_id');
		$priority = $this->input->post('priority');
		$table_name = 'nric';
		$permanent_address_id = $this->input->post('permanent_address_id');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$assigned_info = $this->db->select('*')->from($table_name)->where('nric_id',$nric_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('nric_id',$nric_id)->get()->row_array();

		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$nric = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status_date' => date('d-m-Y H:i:s'),
			'output_status'=>'0'
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status)?$analyst_status:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$nric['status'] = 4;
		}

		// print_r($assigned_info);
		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$index = '0';
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$nric['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			$index = '0';
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'34',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$nric['analyst_status'] = $analyst_status;
				$nric['assigned_role'] = $qc_roles['role'];
				$nric['assigned_team_id'] = $team_id;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				// $nric['insuff_close_date'] =  implode(',', $insuff_close_date);

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$nric['analyst_status'] = $analyst_status;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			$nric['analyst_status'] = $analyst_status;
				

			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			 $index='0';
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'34',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$nric['analyst_status'] = $analyst_status;
				$nric['insuff_team_role'] = $qc_roles['role'];
				$nric['insuff_team_id'] = $team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$nric['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{
				$oig['analyst_status'] = $analyst_status;
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}else{
			$nric['analyst_status'] = $analyst_status;
		}

		if (count($client_docs) > 0) {
			$nric['approved_doc'] = implode(',',$client_docs);
		}  

		// print_r($reference_remark_data);
		// echo json_encode($global_db);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('nric',$nric)) {
			 
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$nric['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('nric_log',$nric);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}


 	function update_right_to_work($client_docs){
		$index = 0;
		$isChanged = '0';
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',', $this->input->post('action_status'));
		$oig_id = $this->input->post('oig_id');
		$priority = $this->input->post('priority');
		$table_name = 'right_to_work';
		$right_to_work_id = $this->input->post('right_to_work_id');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status[$index] = '10';
		}

		$assigned_info = $this->db->select('*')->from($table_name)->where('right_to_work_id',$right_to_work_id)->get()->row_array();
		$candidate_info = $this->db->select('candidate.*,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('right_to_work_id',$right_to_work_id)->get()->row_array();
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();

		$right_to_work = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status_date' => date('d-m-Y H:i:s'),
			'output_status'=>'0'
		); 


		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		// $inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status)?$analyst_status:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$right_to_work['status'] = 4;
		}

		// print_r($assigned_info);
		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$index = '0';
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status;
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if ($analyst_status[$index] == '11') {
			$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$right_to_work['insuff_close_date'] =  implode(',', $insuff_close_date);
		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			// echo '<br>11 Role: '.$role;
			// echo $this->QcExists($candidate_info['candidate_id'],$index,'court_records');
			// exit();
			$index = '0';
			if($this->QcExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'34',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$right_to_work['analyst_status'] = $this->input->post('action_status');
				$right_to_work['assigned_role'] = $qc_roles['role'];
				$right_to_work['assigned_team_id'] = $team_id;
				

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$right_to_work['analyst_status'] = $analyst_status;
				// Analyst will get a notification.
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status == '3'){
			// echo '<br>3 Role: '.$role;
			 
			$right_to_work['analyst_status'] = $analyst_status;
				

			if($analyst_status == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$isChanged = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}

			if($candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,'0');
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}

			// send SMS Or Mail to Candidate.

			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']);
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			/*$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);*/
			if ($candidate_info['document_uploaded_by_email_id'] !=null && $candidate_info['document_uploaded_by_email_id'] !='') { 
			$mailStatus = $this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			}else{
				
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			}

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);
		
			// $smsStatus = $this->smsModel->send_sms($candidate_info['first_name'],$candidate_info['client_name'],$candidate_info['client_name'],'123456','2');

			// if($smsStatus == "200"){
			// 	$txtSmsStatus = '1';
			// }else{
			// 	$txtSmsStatus = '0';

			// }
  
		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status == '3'){
			// echo '<br>! 3 Role: '.$role;
			 $index='0';
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],'0',$table_name,'single') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'34',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array(); 
				$right_to_work['analyst_status'] = $analyst_status;
				$right_to_work['insuff_team_role'] = $qc_roles['role'];
				$right_to_work['insuff_team_id'] = $team_id;
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$right_to_work['insuff_created_date'] =  implode(',', $insuff_created_date);

				// Insuff Analyst will get a notification.
				 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}
			}else{
				$oig['analyst_status'] = $analyst_status;
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status;
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			} 

		}else{
			$right_to_work['analyst_status'] = implode(',', $analyst_status);
		}

		if (count($client_docs) > 0) {
			$right_to_work['approved_doc'] = implode(',',$client_docs);
		}  

		// print_r($reference_remark_data);
		// echo json_encode($global_db);
		// exit();
		$exception = '';
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('right_to_work',$right_to_work)) {
			 
			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$right_to_work['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('right_to_work_log',$right_to_work);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}



	function update_remarks_right_to_work($client_docs){
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = explode(',',$this->input->post('action_status'));
		$priority = $this->input->post('priority');
		$index = $this->input->post('index');
		$criminal_check_id = $this->input->post('criminal_check_id');
		$table_name = 'right_to_work';
		$date =  date('d-m-Y H:i:s');

		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		} 

		$assigned_info = $this->db->select('*')->from($table_name)->where('criminal_check_id',$criminal_check_id)->get()->row_array();
		// return $assigned_info;
		$remarks_updateed_by_role = explode(',', $assigned_info['remarks_updateed_by_role']);
		$remarks_updateed_by_id = explode(',', $assigned_info['remarks_updateed_by_id']);
		$analyst_status_date = explode(',', $assigned_info['analyst_status_date']);
		$remarks_updateed_by_role = $this->changeVlaueThroughIndex($remarks_updateed_by_role,$index,$this->input->post('userRole'));
		$remarks_updateed_by_id = $this->changeVlaueThroughIndex($remarks_updateed_by_id,$index,$this->input->post('userID'));
		// print_r($analyst_status);
		// exit();
		$analyst_status_final = $this->changeVlaueThroughIndex($analyst_status,$index,$analyst_status[$index]);
		$analyst_status_date_final = $this->changeVlaueThroughIndex($analyst_status_date,$index,$date);
		$component_id =0;
		$candidate_info = $this->db->select('candidate.* ,tbl_client.client_name')->from($table_name)->join('candidate','candidate.candidate_id = '.$table_name.'.candidate_id','left')->join('tbl_client','tbl_client.client_id = candidate.client_id','left')->where('criminal_check_id',$criminal_check_id)->get()->row_array(); 
		$client_info = $this->db->where('client_id',$candidate_info['client_id'])->get('tbl_clientspocdetails')->row_array();
		$remarks_docs = $this->get_remarks_docs($index,$analyst_status,$client_docs,$assigned_info['approved_doc']);

		$right_to_work = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_period_of_stay'=>$this->input->post('remark_period_of_stay'),
			'remark_gender'=>$this->input->post('remark_gender'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'verified_date'=>$this->input->post('verified_date'),
			'Insuff_closure_remarks'=>$this->input->post('closure_remarks'),			
			'output_status'=>$this->utilModel->setupOutPutStauts($assigned_info['output_status'],$index,'0'),
			'approved_doc' =>$remarks_docs,
		); 

		// 11-11-21
		$inputQcStatus = explode(',', $assigned_info['status']);
		$inputQcStatus_final = $this->changeVlaueThroughIndex($inputQcStatus,$index,4);
		$valid_analyst = isset($analyst_status[$index])?$analyst_status[$index]:'0';
		if ($valid_analyst == '11' || $valid_analyst == '4') {
			$right_to_work['status'] = $inputQcStatus_final;
		}

		$fs_emp_data = '';
		if($this->session->userdata('logged-in-analyst')){
			$fs_emp_data = $this->session->userdata('logged-in-analyst');
		}else if($this->session->userdata('logged-in-specialist')){
			$fs_emp_data = $this->session->userdata('logged-in-specialist');
		}

		if($assigned_info['output_status'] == "2"){
			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			$team_id = explode(',',$candidate_data['assigned_outputqc_id']);
			$team_id = $team_id[$index]; 
			$component_id = $this->utilModel->getComponentId($table_name);
			$component_status = $analyst_status[$index];
			$assigned_team_id = $candidate_data['assigned_outputqc_id'];
			$raised_by_team_id = $fs_emp_data['team_id'];
			$message = "Clear QcError from ".$role;
			$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id,$message);

		}
		if(in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '11'){
			 
			if($this->QcExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0'){

				$team_id = $this->inputQcModel->getMinimumTaskHandlerAnalyst($table_name,'1',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();

				$assigned_role = explode(',', $assigned_info['assigned_role']);
				$assigned_team_id = explode(',', $assigned_info['assigned_team_id']);
				

				$assigned_role = $this->changeVlaueThroughIndex($assigned_role,$index,$qc_roles['role']);
				$assigned_team_id = $this->changeVlaueThroughIndex($assigned_team_id,$index,$team_id);

				$right_to_work['analyst_status'] = $analyst_status_final;
				$right_to_work['analyst_status_date'] = date('d-m-Y H:i:s');
				$right_to_work['assigned_role'] = $assigned_role;
				$right_to_work['assigned_team_id'] = $assigned_team_id;
				$insuff_close_date = explode(',', $assigned_info['insuff_close_date']);
				$insuff_close_date[$index] = date('Y-m-d H:i');
				$right_to_work['insuff_close_date'] =  implode(',', $insuff_close_date);

				// Analyst/Specialist get notification.

				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 

			}else{
				$right_to_work['analyst_status'] = $analyst_status_final;
				$right_to_work['analyst_status_date'] = $analyst_status_date_final;
				// echo "Analyst will get a notification.";
				$team_id = explode(',',$assigned_info['assigned_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $this->session->userdata('logged-in-insuffanalyst');
				$message = "clear insuff from Insuffanalyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
			} 
			 $this->isSubmitedStatusChange_for_clear_insuff($candidate_info['candidate_id']);
		}else if(in_array($role,array('insuff analyst','insuff specialist')) &&  $analyst_status[$index] == '3'){
			// echo '<br>3 Role: '.$role;
			$assigned_status = explode(',', $assigned_info['status']); 
			$right_to_work['analyst_status'] = $this->changeVlaueThroughIndex($assigned_status,$index,$analyst_status[$index]);
			$right_to_work['analyst_status_date'] = $analyst_status_date_final;
			// send SMS Or Mail to Candidate.
			if($analyst_status[$index] == '3' && $candidate_info['candidate_id'] != '' && $candidate_info['candidate_id'] != null){
				$assigned_info = $this->isSubmitedStatusChanged($candidate_info['candidate_id']);
			}
			$candidate = $candidate_info['candidate_id']; 
			if($candidate != '' && $candidate != null){
				$tat_pause_data = array(
					'tat_pause_date'=>date("d-m-Y H:i:s"),
					'tat_pause_resume_status'=>'1'
				);
				if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$tat_pause_data)){
					$this->tatDateUpdate($candidate_info['candidate_id'],$table_name,$index);
					$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array());
				}
			}


			$candidate_data = $this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate')->row_array();
			 $smsStatus = $this->smsModel->send_insuff_sms($candidate_data['first_name'],$candidate_data['phone_number']); 
			//Mail argument $candidate_id,$candidate_name,$component_name,$insuff_remarks,$candidate_mail_id
			$insuff_remarks = $this->input->post('insuff_remarks');
			$component_id = $this->utilModel->getComponentId($table_name);
			$mailStatus = $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$candidate_data['email_id']);
			$this->insuff_client_mail($candidate_info,$table_name,$insuff_remarks,$component_id);
			// $this->emailModel->insuffMailToCandiate($candidate_info['candidate_id'],$candidate_data['first_name'],$table_name,$insuff_remarks,$client_info['spoc_email_id']);

			$variable_array = array(
				'candidate_details' => $candidate_info
			);
			$this->send_insuff_email_to_client($variable_array);

		}else if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] == '3'){
			// echo '<br>! 3 Role: '.$role;
			// echo $this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,'court_records');
			 
			if($this->InsuffAnalystAndSpecialistExists($candidate_info['candidate_id'],$index,$table_name,'double') == '0' ){

				$team_id = $this->inputQcModel->getMinimumTaskHandler_Insuff_Analyst_Specialist($table_name,'1',$priority);
				$qc_roles = $this->db->select('role')->from('team_employee')->where('team_id',$team_id)->get()->row_array();


				$insuff_team_role = explode(',', $assigned_info['insuff_team_role']);
				$insuff_team_id = explode(',', $assigned_info['insuff_team_id']);
				

				$insuff_team_role = $this->changeVlaueThroughIndex($insuff_team_role,$index,$qc_roles['role']);
				$insuff_team_id = $this->changeVlaueThroughIndex($insuff_team_id,$index,$team_id);
				
				$right_to_work['insuff_team_role'] = $insuff_team_role;
				$right_to_work['insuff_team_id'] = $insuff_team_id;
				$right_to_work['analyst_status'] = $analyst_status_final;
				$right_to_work['analyst_status_date'] = date('d-m-Y H:i:s');
				$insuff_created_date = explode(',', $assigned_info['insuff_created_date']);
				$insuff_created_date[$index] = date('Y-m-d H:i');
				$right_to_work['insuff_created_date'] =  implode(',', $insuff_created_date);
				

				// Insuff Analyst will get a notification.
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				}

			}else{
				$right_to_work['analyst_status'] = $analyst_status_final;
				$right_to_work['analyst_status_date'] = $analyst_status_date_final;
				
				// Insuff Analyst will get a notification.
				$team_id = explode(',',$assigned_info['insuff_team_id']);
				$team_id = $team_id[$index]; 
				$component_id = $this->utilModel->getComponentId($table_name);
				$component_status = $analyst_status[$index];
				$assigned_team_id = $team_id;
				$raised_by_team_id = $fs_emp_data;
				$message = "Insuff is genrated from analyst.";

				if($component_status != '' && $component_status != null){

					$this->notificationModel->create_insuff_analyst_notification($candidate_info['candidate_id'],$index,$component_id,$component_status,$assigned_team_id,$raised_by_team_id['team_id'],$message);
					// exit();
				}else{
					return array('status'=>'0','msg'=>'failled');
				} 
			} 
			

		}else{
			$right_to_work['analyst_status'] = $analyst_status_final;
			$right_to_work['analyst_status_date'] = $analyst_status_date_final;
		}
		 
		try{
			$this->notificationModel->intrimNotify($role,$analyst_status[$index],$candidate_info['candidate_id']);		  
		}catch(Exception $exception){
			$exception = $exception;
		}
		/*if (count($client_docs) > 0) {
			$criminal_checks['approved_doc'] = json_encode($client_docs);
		}*/

		// criminal_checks
		// echo json_encode($criminal_checks);
		// exit();

			$this->db->where('right_to_work_id',$right_to_work_id);
		if ($this->db->update($table_name,$right_to_work)) {
			$exception = '';
			// try{
				// if(!in_array($role,array('insuff analyst','insuff specialist')) && $analyst_status[$index] != '3'){
				// 	$positive_status = array('4','5','6','7','9');
				// 	if(in_array($analyst_status[$index],$positive_status)){
				// 		$componentStatus = $this->utilModel->isAnyComponentVerifiedClear($candidate_info['candidate_id']);
				// 		echo $componentStatus."</br>";
				// 		if($componentStatus == '0'){
				// 			$updateInfo = array('case_intrim_notification' => '1','client_case_intrim_notification' => '1','updated_date'=>date('d-m-Y H:i:s'));
				// 			if($this->db->where('candidate_id',$candidate_info['candidate_id'])->update('candidate',$updateInfo)){
								 
				// 				$this->db->insert('candidate_log',$this->db->where('candidate_id',$candidate_info['candidate_id'])->get('candidate'));
				// 			}
							 
				// 		}	
				// 	}
				// }
			// }catch(Exception $e){
			// 	$exception = $e;
			// }



			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$right_to_work['right_to_work_id'] = $this->input->post('right_to_work_id');
			$this->db->insert('right_to_work_log',$right_to_work);

			return array('status'=>'1','msg'=>'success','exception'=>$exception);
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
 
	}


	/* auto assignment for the outputqc */

	function trigger_outputqc_assignment(){ 
		$where = array(
			'is_submitted'=>1,
			'assigned_outputqc_id'=>0
		);
		$candidate = $this->db->where($where)->get('candidate')->result_array();
		if (count($candidate) > 0) { 
		foreach ($candidate as $key => $value) {
			$isOutputQcExists = $this->outputQcExists($value['candidate_id']);
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($value['candidate_id']);
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			}
		}
		}
			 
	}
}	
?>