<?php
/** 
 * 01-02-2021	
 */
class specialistModel extends CI_Model
{
 

	function insuffUpdateStatus(){

		$candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		$componentname= $this->input->post('componentname');
		 
		// echo "candidate_id : ".$candidate_id."<br>";
		// echo "componentname : ".$componentname."<br>";
		// echo "component_id : ".$component_id;
		// exit();

		$user = $this->session->userdata('logged-in-specialist'); 
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
		 
		$user = $this->session->userdata('logged-in-specialist'); 
		 
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
		 
		$user = $this->session->userdata('logged-in-specialist'); 
		 
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
		$specialist_info = $this->session->userdata('logged-in-specialist'); 
		$component = array('court_records','criminal_checks','current_employment','document_check','drugtest','education_details','globaldatabase','permanent_address','present_address','previous_address','previous_employment','reference');
 
		$assignedComponent = array();
		foreach ($component as $key => $value) {
			 
			
			$getResult = $this->db->select($value.".*,candidate.first_name,candidate.last_name,candidate.phone_number,candidate.email_id,tbl_client.client_name,tbl_client.client_id")->from($value)->join('candidate',$value.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->where('assigned_role',$specialist_info['role'])->where('assigned_team_id',$specialist_info['team_id'])->where('analyst_status !=','10')->get();

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
		$specialist_info = $this->session->userdata('logged-in-specialist'); 
		$component = array('court_records','criminal_checks','current_employment','document_check','drugtest','education_details','globaldatabase','permanent_address','present_address','previous_address','previous_employment','reference','directorship_check','global_sanctions_aml','driving_licence','credit_cibil','bankruptcy','adverse_database_media_check','cv_check','health_checkup','employment_gap_check');
 
		$assignedComponent = array();
		foreach ($component as $key => $value) {
			 
			
			$getResult = $this->db->select($value.".*,candidate.first_name,candidate.last_name,candidate.phone_number,candidate.email_id,tbl_client.client_name,tbl_client.client_id")->from($value)->join('candidate',$value.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->where('assigned_role',$specialist_info['role'])->where('assigned_team_id',$specialist_info['team_id'])->where('analyst_status','10')->get();

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
			default:
				 
				break;
		}
 
		return $component_id;
	}

	function isAllComponentApproved($candidate_id){
		// echo $candidate_id."<br>"; 
		$candidateData = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();

		$component_ids = explode(',', $candidateData['component_ids']) ;

		$analystStatus = array();

		foreach ($component_ids as $key => $value) {
			// echo $this->getComponentName($value)."<br>";
			$componentStatus = $this->db->select('analyst_status')->where('candidate_id',$candidate_id)->get($this->getComponentName($value))->row_array(); 
			array_push($analystStatus, $componentStatus['analyst_status']); 
		}
		 
		 // print_r($analystStatus);
		$tmp = array_unique($analystStatus);

		// print_r($tmp);
		// if(in_array("4", $tmp) && count($tmp) == 1){	
		if(!array_intersect([0,1,3,5,8], $tmp)){	
			// print_r($tmp); 

			$outputQc_id = $this->getMinimumTaskHandlerOutPutQC();
			// echo "outputQc : ".$outputQc_id;
			// exit();
			$components_data = array( 
				'assigned_outputqc_id'=>$outputQc_id,
				'updated_date'=>date('d-m-Y H:i:s')
				 
			);
			$this->db->where('candidate_id',$candidate_id);
			if ($this->db->update('candidate',$components_data)) {
				$insert_id = $this->db->insert_id();
				$components_log_data = array( 
					'candidate_id'=>$candidate_id,
					'assigned_outputqc_id'=>$outputQc_id,
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
		if($componentId == 4){

			$component_based = $this->db->select($table_name.'.*,candidate.first_name,candidate.last_name,candidate.phone_number,candidate.email_id,candidate.date_of_birth,candidate.date_of_birth,candidate.form_values,tbl_client.client_name,packages.package_name')->from($table_name)->join('candidate',$table_name.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where($table_name.'.candidate_id',$candidateId)->get()->row_array();
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

			$component_based = $this->db->select($table_name.'.*,candidate.first_name,candidate.last_name,candidate.phone_number,candidate.email_id,candidate.date_of_birth,candidate.date_of_birth,candidate.form_values,tbl_client.client_name,packages.package_name')->from($table_name)->join('candidate',$table_name.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where($table_name.'.candidate_id',$candidateId)->get()->row_array();
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
			

			
		}else{
			$component_based = $this->db->select($table_name.'.*,candidate.first_name,candidate.last_name,candidate.phone_number,candidate.email_id,candidate.date_of_birth,candidate.date_of_birth,tbl_client.client_name,packages.package_name')->from($table_name)->join('candidate',$table_name.'.candidate_id = candidate.candidate_id','left')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where($table_name.'.candidate_id',$candidateId)->get()->row_array();
		}
		
 
		return $component_based;

	}


	 

	function update_remarks_candidate_criminal_check($client_docs){
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}
		 
		$criminal_checks = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'Insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
		); 
		

		if (count($client_docs) > 0) {
			$criminal_checks['approved_doc'] = json_encode($client_docs);
		}

			$this->db->where('criminal_check_id',$this->input->post('criminal_check_id'));
		if ($this->db->update('criminal_checks',$criminal_checks)) {
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

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
 
	}
	function update_remarks_candidate_court_record($client_docs){
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}
		$court_record = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'Insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
		);

		if (count($client_docs) > 0) {
			$court_record['approved_doc'] = json_encode($client_docs);
		}

			$this->db->where('court_records_id',$this->input->post('court_records_id'));
		if ($this->db->update('court_records',$court_record)) {

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

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
 
	}

	function update_remarks_candidate_permanent_address($doc){
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}
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
			'closure_remarks'=>$this->input->post('closure_remarks'),
			'remarks_pincode'=>$this->input->post('pincode'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
			);
		if (! in_array('no-file', $doc)) {
			$permanent_address['approved_doc'] = implode(',', $doc);
		}

			$this->db->where('permanent_address_id',$this->input->post('permanent_address_id'));
		if ($this->db->update('permanent_address',$permanent_address)) {

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

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}

		// return $permanent_address;
	
	// formdata.append('permanent_address_id',permanent_address_id);
	}

	function update_remarks_candidate_present_address($doc){
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
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
			'closure_remarks'=>$this->input->post('closure_remarks'),
			'remarks_pincode'=>$this->input->post('pincode'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
		); 
		if (! in_array('no-file', $doc)) {
			$present_address['approved_doc'] = implode(',', $doc);
		}

			$this->db->where('present_address_id',$this->input->post('present_address_id'));
		if ($this->db->update('present_address',$present_address)) {

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

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}

		// return $permanent_address;
	
	// formdata.append('permanent_address_id',permanent_address_id);
	}

	function update_remarks_candidate_previous_address($client_docs){
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
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
			'closure_remarks'=>$this->input->post('closure_remarks'),
			'remarks_pincode'=>$this->input->post('pincode'), 
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
		); 

		
		if (count($client_docs) > 0) {
			$previous_address['approved_doc'] = json_encode($client_docs);
		}

			$this->db->where('previos_address_id',$this->input->post('previos_address_id'));
		if ($this->db->update('previous_address',$previous_address)) {
			 
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

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}

		// return $permanent_address;
	
	
	}

	function update_remarks_current_employment($client_docs){
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}
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
			'Insuff_remarks'=>$this->input->post('Insuff_remarks'), 
			'Insuff_closure_remarks'=>$this->input->post('Insuff_closure_remarks'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
		);
		if (count($client_docs) > 0) {
			$current_employment['approved_doc'] = implode(',',$client_docs);
		} 

		// print_r($current_employment);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('current_employment',$current_employment)) {

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
			$this->db->insert('current_employment_log',$current_employment);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}

	}

	function update_remarks_previous_employment($client_docs){

		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('analyst_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

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
			'Insuff_remarks'=>$this->input->post('Insuff_remarks'), 
			'Insuff_closure_remarks'=>$this->input->post('Insuff_closure_remarks'),
			'verification_fee'=>$this->input->post('verification_fee'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
		); 

		if (count($client_docs) > 0) {
			$previous_employment['approved_doc'] = json_encode($client_docs);
		} 

		// print_r($current_employment);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('previous_employment',$previous_employment)) {

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

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}

	}

	function update_reference($client_docs){
		
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('analyst_status');
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
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
		);
		if (count($client_docs) > 0) {
			$reference_remark_data['approved_doc'] = json_encode($client_docs);
		}  

		// print_r($reference_remark_data);
		// echo json_encode($reference_remark_data);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('reference',$reference_remark_data)) {

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

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}

	}

	function update_globalDb($client_docs){

		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}



		$global_db = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
		); 
		if (count($client_docs) > 0) {
			$global_db['approved_doc'] = implode(',',$client_docs);
		}  

		// print_r($reference_remark_data);
		// echo json_encode($global_db);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('globaldatabase',$global_db)) {

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

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}

	}


	function remarkForDrugTest($client_docs){

		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$drugTest_db = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
		);
		if (count($client_docs) > 0 && !in_array('no-file', $client_docs)) {
			$drugTest_db['approved_doc'] = json_encode($client_docs);
		}  


		// print_r($drugTest_db);
		// echo json_encode($global_db);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('drugtest',$drugTest_db)) {

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

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function remarkForDocuemtCheck($aadhar,$pan,$client_docs){
		// echo json_encode($_POST);

		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$address = array();
		$city = array();
		$state = array();
		$pincode = array();
		$in_progress_remark = array();
		$verification_remarks = array();
		$insuff_remarks = array();
		$insuff_closer_remark = array();
		if ($this->input->post('aadhar_address')) {
			$address['aadhar_address'] = $this->input->post('aadhar_address');
			$city['aadhar_city'] = $this->input->post('aadhar_city');
			$state['aadhar_state'] = $this->input->post('aadhar_state');
			$pincode['aadhar_pincode'] = $this->input->post('aadhar_pincode');
			$in_progress_remark['aadhar_in_progress_remark'] = $this->input->post('aadhar_in_progress_remark');
			$verification_remarks['aadhar_verification_remarks'] = $this->input->post('aadhar_verification_remarks');
			$insuff_remarks['aadhar_insuff_remarks'] = $this->input->post('aadhar_insuff_remarks');
			$insuff_closer_remark['aadhar_insuff_closer_remark'] = $this->input->post('aadhar_insuff_closer_remark');
		}

		if ($this->input->post('pan_address')) {
			$address['pan_address'] = $this->input->post('pan_address');
			$city['pan_city'] = $this->input->post('pan_city');
			$state['pan_state'] = $this->input->post('pan_state');
			$pincode['pan_pincode'] = $this->input->post('pan_pincode');
			$in_progress_remark['pan_in_progress_remark'] = $this->input->post('pan_in_progress_remark');
			$verification_remarks['pan_verification_remarks'] = $this->input->post('pan_verification_remarks');
			$insuff_remarks['pan_insuff_remarks'] = $this->input->post('pan_insuff_remarks');
			$insuff_closer_remark['pan_insuff_closer_remark'] = $this->input->post('pan_insuff_closer_remark');
		}

		if ($this->input->post('address')){
			$address['address'] = $this->input->post('address');
			$city['city'] = $this->input->post('city');
			$state['state'] = $this->input->post('state');
			$pincode['pincode'] = $this->input->post('pincode');
			$in_progress_remark['in_progress_remark'] = $this->input->post('in_progress_remark');
			$verification_remarks['verification_remarks'] = $this->input->post('verification_remarks');
			$insuff_remarks['insuff_remarks'] = $this->input->post('insuff_remarks');
			$insuff_closer_remark['insuff_closer_remark'] = $this->input->post('insuff_closer_remark');
		}

		 
		$doc_data = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>json_encode($address),
			'remark_city'=>json_encode($city),
			'remark_state'=>json_encode($state),
			'remark_pin_code'=>json_encode($pincode),
			'in_progress_remarks'=>json_encode($in_progress_remark),
			'verification_remarks'=>json_encode($verification_remarks),
			'insuff_remarks'=>json_encode($insuff_remarks),
			'insuff_closure_remarks'=>json_encode($insuff_closer_remark),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
		);

		$doc = array();
		if (count($aadhar) > 0 && !in_array('no-file', $aadhar)) {
			$doc['aadhar'] = implode(',',$aadhar);
		}  

		if (count($pan) > 0 && !in_array('no-file', $pan)) {
			$doc['pan'] = implode(',',$pan);
		}  

		if (count($client_docs) > 0 && !in_array('no-file', $client_docs)) {
			$doc['passport'] = implode(',',$client_docs);
		}  
		if (count($doc) > 0) { 
		$doc_data['approved_doc'] = json_encode($doc);
		}


		// return $doc_data;
		// print_r($doc_data);
		// echo json_encode($doc_data);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('document_check',$doc_data)) {

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

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function remarkForEduCheck($client_docs){
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('analyst_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

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
			'verification_fee'=>$this->input->post('verifier_fee'),
			'in_progress_remarks'=>$this->input->post('progress_remark'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
		);
		if (count($client_docs) > 0) {
			$eduData['approved_doc'] = json_encode($client_docs);
		} 
		// print_r($eduData);
		// exit();
		$this->db->where('candidate_id',$this->input->post('candidate_id')); 
		if ($this->db->update('education_details',$eduData)) {

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

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
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
}	
?>