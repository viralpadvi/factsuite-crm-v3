<?php
/** 
 * 03-05-2021	
 */
class InsuffAnalystModel extends CI_Model
{
 	

	function get_component_name($component_id){
		return $this->db->where('component_id',$component_id)->get('components')->row_array();
	}



 	function getInsuffComponentForms($team_id = ''){
 		if ($this->input->post('team_id')) { 
 		$team_id = $this->input->post('team_id');
 		}
 		 
 		$component = array('court_records','criminal_checks','current_employment','document_check','drugtest','education_details','globaldatabase','permanent_address','present_address','previous_address','previous_employment','reference','directorship_check','global_sanctions_aml','driving_licence','credit_cibil','bankruptcy','adverse_database_media_check','cv_check','health_checkup','employment_gap_check','landload_reference','covid_19','social_media','civil_check','right_to_work','sex_offender','politically_exposed','
							india_civil_litigation','
							mca','
							nric','
							gsa','oig'); 

 		// Total Data for team Id;
 		$row =array();
 		foreach ($component as $key => $value) {

 			// if($value == 'employment_gap_check'){
 				$query = "SELECT * FROM ".$value." where  `insuff_team_id` REGEXP ".$team_id." AND (status REGEXP '3' OR analyst_status REGEXP '3')";
 			// }else{
 			// 	$query = "SELECT * FROM ".$value." where  `insuff_team_id` REGEXP ".$team_id." AND (status REGEXP '3' OR analyst_status REGEXP '3')";
 			// }
 			// echo  $query;
 			// exit();
 			// SELECT * FROM `court_records` WHERE insuff_team_id REGEXP '43' AND (status REGEXP '3' OR analyst_status REGEXP '3')
 			$result = $this->db->query($query)->result_array();

 			if($this->db->query($query)->num_rows() > 0){ 
 				// array_push($row,$result); 
 				$row[$value] = $result; 
 			}
 			
 		}
 	
 		// echo json_encode($row);

 		$final_data = array();

 		$k = 0;
 		foreach ($row as $mainKey => $value) {
 			 

 			 // echo $mainKey;
 			if($mainKey == 'landload_reference'){ 
 				foreach ($value as $reference_key => $reference_value) {
 					$reference_assigned_team_id = explode(",",$reference_value['insuff_team_id']);
 						$analyst_status = explode(",",$reference_value['analyst_status']);
 					 $status = explode(",",$reference_value['status']);
 					foreach ($reference_assigned_team_id as $reference_assigned_team_id_key => $reference_assigned_team_id_value) {

 							if($reference_assigned_team_id_value == $team_id && $analyst_status[$reference_assigned_team_id_key] == '3' && $analyst_status[$reference_assigned_team_id_key] != '10' && $analyst_status[$reference_assigned_team_id_key] != '4'){
 							
 							$reference['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$reference['component_name'] = $this->get_component_name($reference['component_id'])[$this->config->item('show_component_name')];
 							$reference['landload_id'] = $reference_value['landload_id'];
 							$reference['candidate_id'] = $reference_value['candidate_id']; 
 							$reference['candidate_detail'] = $this->getCandidateInfo($reference_value['candidate_id']);
 							$reference['index'] = $reference_assigned_team_id_key;
 
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
 			
 			// 1
 			if($mainKey == 'criminal_checks'){
 				 foreach ($value as $criminal_checks_key => $criminal_checks_value) {
 					$assigned_team_ids = explode(",",$criminal_checks_value['insuff_team_id']); 
 					// $court_address = json_decode($court_records_value['address'],true);
 					foreach ($assigned_team_ids as $assigned_team_ids_key => $assigned_team_ids_value) {
 						$status = explode(",", $criminal_checks_value['status']);
						$analyst_status = explode(",", $criminal_checks_value['analyst_status']);
 						if($assigned_team_ids_value == $team_id && ($status[$assigned_team_ids_key] == '3' || $analyst_status[$assigned_team_ids_key] == '3') && $analyst_status[$assigned_team_ids_key] != '10' && $analyst_status[$assigned_team_ids_key] != '4'){

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
 			// 1
 			if($mainKey == 'civil_check'){
 				 foreach ($value as $criminal_checks_key => $criminal_checks_value) {
 					$assigned_team_ids = explode(",",$criminal_checks_value['insuff_team_id']); 
 					// $court_address = json_decode($court_records_value['address'],true);
 					foreach ($assigned_team_ids as $assigned_team_ids_key => $assigned_team_ids_value) {
 						$status = explode(",", $criminal_checks_value['status']);
						$analyst_status = explode(",", $criminal_checks_value['analyst_status']);
 						if($assigned_team_ids_value == $team_id && ($status[$assigned_team_ids_key] == '3' || $analyst_status[$assigned_team_ids_key] == '3') && $analyst_status[$assigned_team_ids_key] != '10' && $analyst_status[$assigned_team_ids_key] != '4'){

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
 					$assigned_team_ids = explode(",",$court_records_value['insuff_team_id']); 
 					// $court_address = json_decode($court_records_value['address'],true);
 					foreach ($assigned_team_ids as $assigned_team_ids_key => $assigned_team_ids_value) {
 						$status = explode(",", $court_records_value['status']);
						$analyst_status = explode(",", $court_records_value['analyst_status']); 
 						if($assigned_team_ids_value == $team_id && ($status[$assigned_team_ids_key] == '3' || $analyst_status[$assigned_team_ids_key] == '3') && $analyst_status[$assigned_team_ids_key] != '10' && $analyst_status[$assigned_team_ids_key] != '4' ){

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
 					$assigned_team_id = explode(",",$document_check_value['insuff_team_id']); 
 					$status = explode(",",$document_check_value['status']); 
					$analyst_status = explode(",",$document_check_value['analyst_status']);

 					foreach ($assigned_team_id as $dc_key => $document_assigned_value) {
 						if($document_assigned_value == $team_id && ($status[$dc_key] == '3' || $analyst_status[$dc_key] == '3') && $analyst_status[$dc_key] != '10'){
		 					$candidateInfo = $this->getCandidateInfo($document_check_value['candidate_id']);
		 					$document_check['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
		 					$document_check['component_name'] = $this->get_component_name($document_check['component_id'])[$this->config->item('show_component_name')];
		 					$document_check['candidate_id'] = $document_check_value['candidate_id'];
		 					$document_check['candidate_detail'] = $candidateInfo;

		 					$candidateinfo = json_decode($candidateInfo['form_values']);
		 					$candidateinfo = json_decode($candidateinfo,true);

		 					 
		 					// $getIndexNumber = array_search($candidateinfo['document_check'][$dc_key],$candidateinfo['document_check']);

		 					
			 				$document_check['status'] = isset($status[$dc_key])?$status[$dc_key]:'';
			 					 
			 				
			 				$document_check['analyst_status'] = isset($analyst_status[$dc_key])?$analyst_status[$dc_key]:'';

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
 					$assigned_team_id = explode(",",$subValues['insuff_team_id']); 
 					// print_r($assigned_team_id);
 					// echo "<br>";
 					foreach ($assigned_team_id as $drugtest_key => $drugtest_value) {
 						$status = explode(",",$subValues['status']); 
						$analyst_status = explode(",",$subValues['analyst_status']);
 						if($drugtest_value == $team_id && ($status[$drugtest_key] == '3' || $analyst_status[$drugtest_key] == '3') && $analyst_status[$drugtest_key] != '10'){
	 						 
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
		 					 
		 					
		 					$drugtest['status'] = isset($status[$drugtest_key])?$status[$drugtest_key]:'';
		 					// array_push($drugtest,isset($status[$drugtest_key])?$status[$drugtest_key]:'');

		 					
		 					$drugtest['analyst_status'] = isset($analyst_status[$drugtest_key])?$analyst_status[$drugtest_key]:'';
		 					// array_push($drugtest,isset($analyst_status[$drugtest_key])?$analyst_status[$drugtest_key]:'');

		 					$insuff_status = explode(",",$subValues['insuff_status']);
		 					$drugtest['insuff_status'] = isset($insuff_status[$drugtest_key])?$insuff_status[$drugtest_key]:'';
		 					// array_push($drugtest,isset($insuff_status[$drugtest_key])?$insuff_status[$drugtest_key]:'');

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
 					if($globaldatabase_value['analyst_status'] != '10' && ($globaldatabase_value['status'] == 3 || $globaldatabase_value['analyst_status'] == 3 ) && $globaldatabase_value['insuff_team_id'] == $team_id){
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
 					// print_r($current_employment_value);
 					// exit;
 					if($current_employment_value['analyst_status'] != '10' && ($current_employment_value['status'] == 3 || $current_employment_value['analyst_status'] == 3 )&& $current_employment_value['insuff_team_id'] == $team_id){
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
 					$assigned_team_id = explode(",",$subValues['insuff_team_id']); 

 					foreach ($assigned_team_id as $education_details_key => $education_details_value) {
 						$status = explode(",",$subValues['status']); 
						$analyst_status = explode(",",$subValues['analyst_status']);

 						if($education_details_value == $team_id  && ($status[$education_details_key] == '3' || $analyst_status[$education_details_key] == '3') && $analyst_status[$education_details_key] != '10'){
  

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
 
		 					$education_details['status'] = isset($status[$education_details_key])?$status[$education_details_key]:'';
		 					// array_push($drugtest,isset($status[$education_details_key])?$status[$education_details_key]:'');

		 					
		 					$education_details['analyst_status'] = isset($analyst_status[$education_details_key])?$analyst_status[$education_details_key]:'';
		 					// array_push($drugtest,isset($analyst_status[$education_details_key])?$analyst_status[$education_details_key]:'');

		 					$insuff_status = explode(",",$subValues['insuff_status']);
		 					$education_details['insuff_status'] = isset($insuff_status[$education_details_key])?$insuff_status[$education_details_key]:'';
		 					// array_push($drugtest,isset($insuff_status[$education_details_key])?$insuff_status[$education_details_key]:'');

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

		 					$assigned_team_id =explode(",",$subValues['assigned_team_id']);
		 					$education_details['assigned_team_id'] = isset($assigned_team_id[$education_details_key])?$assigned_team_id[$education_details_key]:'';

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
 					$present_address_value['component_name'] = $mainKey;
 					$present_address_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey); 
 					$present_address_value['candidate_detail'] = $this->getCandidateInfo($present_address_value['candidate_id']);
 					$present_address_value['index'] = $present_address_key;
 					array_push($final_data, $present_address_value);
 				}
 			}

 			// 9
 			if($mainKey == 'permanent_address'){
 				foreach ($value as $permanent_address_key => $permanent_address_value) { 
 					$permanent_address_value['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 					$permanent_address_value['component_name'] = $this->get_component_name($permanent_address_value['component_id'])[$this->config->item('show_component_name')];
 					$permanent_address_value['candidate_detail'] = $this->getCandidateInfo($permanent_address_value['candidate_id']); 
 					$permanent_address_value['index'] = $permanent_address_key;
 					array_push($final_data, $permanent_address_value);
 				}
 			}
 			// 10
 			if($mainKey == 'previous_employment'){

 				foreach ($value as $previous_employment_key => $previous_employment_value) {
 					$pe_assigned_team_id = explode(",",$previous_employment_value['insuff_team_id']);
 					// print_r($pe_assigned_team_id);
 					// echo "<br>";
 					foreach ($pe_assigned_team_id as $pe_assigned_team_id_key => $pe_assigned_team_id_value) {
 						$status = explode(",",$previous_employment_value['status']);
						$analyst_status = explode(",",$previous_employment_value['analyst_status']);
 						if($pe_assigned_team_id_value == $team_id && ($status[$pe_assigned_team_id_key] == '3' || $analyst_status[$pe_assigned_team_id_key] == '3')&& $analyst_status[$pe_assigned_team_id_key] != '10'){
 							
 							$previous_employment['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$previous_employment['component_name'] = $this->get_component_name($previous_employment['component_id'])[$this->config->item('show_component_name')];
 							$previous_employment['previous_emp_id'] = $previous_employment_value['previous_emp_id'];
 							$previous_employment['candidate_id'] = $previous_employment_value['candidate_id']; 
 							$previous_employment['candidate_detail'] = $this->getCandidateInfo($previous_employment_value['candidate_id']);
 							$previous_employment['index'] = $pe_assigned_team_id_key;
 
 							
 							$previous_employment['status'] = isset($status[$pe_assigned_team_id_key])?$status[$pe_assigned_team_id_key]:"";
 							
 							$previous_employment['analyst_status'] = isset($analyst_status[$pe_assigned_team_id_key])?$analyst_status[$pe_assigned_team_id_key]:"";	
 							$previous_employment['updated_date'] = $previous_employment_value['updated_date'];
 							array_push($final_data, $previous_employment);
 						}
 					}
 				} 
 			}
 			

 			// 11
 			if($mainKey == 'reference'){
 				
 				foreach ($value as $reference_key => $reference_value) {
 					$reference_assigned_team_id = explode(",",$reference_value['insuff_team_id']);
 					 
 					foreach ($reference_assigned_team_id as $reference_assigned_team_id_key => $reference_assigned_team_id_value) {
 						$status = explode(",",$reference_value['status']);
						$analyst_status = explode(",",$reference_value['analyst_status']);
 						if($reference_assigned_team_id_value == $team_id && ($status[$reference_assigned_team_id_key] == '3' || $analyst_status[$reference_assigned_team_id_key] == '3') && $analyst_status[$reference_assigned_team_id_key] != '10'){
 							
 							$reference['component_id'] = $this->analystModel->getStatusFromComponent($mainKey);
 							$reference['component_name'] = $this->get_component_name($reference['component_id'])[$this->config->item('show_component_name')];
 							$reference['reference_id'] = $reference_value['reference_id'];
 							$reference['candidate_id'] = $reference_value['candidate_id']; 
 							$reference['candidate_detail'] = $this->getCandidateInfo($reference_value['candidate_id']);
 							$reference['index'] = $reference_assigned_team_id_key;
 

 							
 							$reference['status'] = isset($status[$reference_assigned_team_id_key])?$status[$reference_assigned_team_id_key]:"";
 
 							$reference['analyst_status'] = isset($analyst_status[$reference_assigned_team_id_key])?$analyst_status[$reference_assigned_team_id_key]:"";	
 							$reference['updated_date'] = $reference_value['updated_date'];
 							array_push($final_data, $reference);
 						}
 					}
 				} 

 			}

 			// 12
 			if($mainKey == 'previous_address'){

 			 	foreach ($value as $pa_key => $pa_value) {
 					$pa_assigned_team_id = explode(",",$pa_value['insuff_team_id']);
 					 
 					foreach ($pa_assigned_team_id as $pa_assigned_team_id_key => $pa_assigned_team_id_value) {
 						$status = explode(",",$pa_value['status']);
						$analyst_status = explode(",",$pa_value['analyst_status']);
 						if($pa_assigned_team_id_value == $team_id && ($status[$pa_assigned_team_id_key] == '3' || $analyst_status[$pa_assigned_team_id_key] == '3')&& $analyst_status[$pa_assigned_team_id_key] != '10'){
 							
 							$previous_address['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$previous_address['component_name'] = $this->get_component_name($previous_address['component_id'])[$this->config->item('show_component_name')];
 							$previous_address['previos_address_id'] = $pa_value['previos_address_id'];
 							$previous_address['candidate_id'] = $pa_value['candidate_id']; 
 							$previous_address['candidate_detail'] = $this->getCandidateInfo($pa_value['candidate_id']);
 							$previous_address['index'] = $pa_assigned_team_id_key; 
 							$previous_address['status'] = isset($status[$pa_assigned_team_id_key])?$status[$pa_assigned_team_id_key]:"";
 							$previous_address['analyst_status'] = isset($analyst_status[$pa_assigned_team_id_key])?$analyst_status[$pa_assigned_team_id_key]:"";	
 							$previous_address['updated_date'] = $pa_value['updated_date'];

 							array_push($final_data, $previous_address);
 						}
 					}
 				} 
 			}

 			// 14
 			if($mainKey == 'directorship_check'){
 			 	foreach ($value as $pa_key => $dir_value) {
 					$dir_assigned_team_id = explode(",",$dir_value['insuff_team_id']);
 					 
 					foreach ($dir_assigned_team_id as $dir_assigned_team_id_key => $dir_assigned_team_id_value) {
 						$analyst_status = explode(",",$dir_value['analyst_status']);
 						$dr_analyst_status =  isset($analyst_status[$dir_assigned_team_id_key])?$analyst_status[$dir_assigned_team_id_key]:"0";
 						$insuff_status = explode(",",$dir_value['status']);
 						$dr_insuff_status = isset($status[$dir_assigned_team_id_key])?$status[$dir_assigned_team_id_key]:"0";
 						if($dir_assigned_team_id_value == $team_id && ($dr_analyst_status == '3' || $dr_insuff_status == '3')&& $dr_analyst_status != '10'){
 							
 							$previous_address['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$previous_address['component_name'] = $this->get_component_name($previous_address['component_id'])[$this->config->item('show_component_name')];
 							$previous_address['directorship_check_id'] = $dir_value['directorship_check_id'];
 							$previous_address['candidate_id'] = $dir_value['candidate_id']; 
 							$previous_address['candidate_detail'] = $this->getCandidateInfo($dir_value['candidate_id']);
 							$previous_address['index'] = $dir_assigned_team_id_key; 

 							$status = explode(",",$dir_value['status']);
 							$previous_address['status'] = isset($status[$dir_assigned_team_id_key])?$status[$dir_assigned_team_id_key]:"";

 							
 							$previous_address['analyst_status'] = isset($analyst_status[$dir_assigned_team_id_key])?$analyst_status[$dir_assigned_team_id_key]:"";

 							// $insuff_status = explode(",",$dir_value['status']);
		 					// $previous_address['insuff_status'] = isset($insuff_status[$dir_assigned_team_id_key])?$insuff_status[$dir_assigned_team_id_key]:'';


 							$previous_address['updated_date'] = $dir_value['updated_date'];

 							array_push($final_data, $previous_address);
 						}
 					}
 				} 
 			}


 			// 15
 			if($mainKey == 'global_sanctions_aml'){
 			 	foreach ($value as $pa_key => $sanctions_value) {
 					$sanctions_assigned_team_id = explode(",",$sanctions_value['insuff_team_id']);
 					 
 					foreach ($sanctions_assigned_team_id as $sanctions_assigned_team_id_key => $sanctions_assigned_team_id_value) {

 						$analyst_status = explode(",",$sanctions_value['analyst_status']);
 						$gsa_analyst_status = isset($analyst_status[$sanctions_assigned_team_id_key])?$analyst_status[$sanctions_assigned_team_id_key]:"0";

 						$insuff_status = explode(",",$sanctions_value['status']);
 						$gsa_insuff_status = isset($insuff_status[$sanctions_assigned_team_id_key])?$insuff_status[$sanctions_assigned_team_id_key]:'0';

 						if($sanctions_assigned_team_id_value == $team_id && ($gsa_analyst_status  == '3' || $gsa_insuff_status == '3') && $gsa_analyst_status != '10'){
 							
 							$global_sanctions_aml['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$global_sanctions_aml['component_name'] = $this->get_component_name($global_sanctions_aml['component_id'])[$this->config->item('show_component_name')];
 							$global_sanctions_aml['global_sanctions_aml_id'] = $sanctions_value['global_sanctions_aml_id'];
 							$global_sanctions_aml['candidate_id'] = $sanctions_value['candidate_id']; 
 							$global_sanctions_aml['candidate_detail'] = $this->getCandidateInfo($sanctions_value['candidate_id']);
 							$global_sanctions_aml['index'] = $sanctions_assigned_team_id_key; 

 							$status = explode(",",$sanctions_value['status']);
 							$global_sanctions_aml['status'] = isset($status[$sanctions_assigned_team_id_key])?$status[$sanctions_assigned_team_id_key]:"";

 							
 							$global_sanctions_aml['analyst_status'] = $gsa_analyst_status;

 							
		 					$global_sanctions_aml['insuff_status'] = $gsa_insuff_status;

 							$global_sanctions_aml['updated_date'] = $sanctions_value['updated_date'];

 							array_push($final_data, $global_sanctions_aml);
 						}
 					}
 				} 
 			}
 
 			
 			// 16
 			if($mainKey == 'driving_licence'){
 			 	foreach ($value as $pa_key => $dl_value) {
 					$dl_assigned_team_id = explode(",",$dl_value['insuff_team_id']);
 					 
 					foreach ($dl_assigned_team_id as $dl_assigned_team_id_key => $dl_assigned_team_id_value) {

 						$analyst_status = explode(",",$dl_value['analyst_status']);
 						$dl_analyst_status = isset($analyst_status[$dl_assigned_team_id_key])?$analyst_status[$dl_assigned_team_id_key]:"0";

 						$insuff_status = explode(",",$dl_value['status']);
 						$dl_insuff_status = isset($insuff_status[$dl_assigned_team_id_key])?$insuff_status[$dl_assigned_team_id_key]:'0'; 

 						if($dl_assigned_team_id_value == $team_id && ($dl_analyst_status == '3' || $dl_insuff_status == '3')&& $dl_analyst_status != '10'){
 							
 							$driving_licence['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$driving_licence['component_name'] = $this->get_component_name($driving_licence['component_id'])[$this->config->item('show_component_name')];
 							$driving_licence['licence_id'] = $dl_value['licence_id'];
 							$driving_licence['candidate_id'] = $dl_value['candidate_id']; 
 							$driving_licence['candidate_detail'] = $this->getCandidateInfo($dl_value['candidate_id']);
 							$driving_licence['index'] = $dl_assigned_team_id_key; 

 							$status = explode(",",$dl_value['status']);
 							$driving_licence['status'] = isset($status[$dl_assigned_team_id_key])?$status[$dl_assigned_team_id_key]:"";

 							
 							$driving_licence['analyst_status'] = $dl_analyst_status ;

 							 
		 					$driving_licence['insuff_status'] = $dl_insuff_status;


 							$driving_licence['updated_date'] = $dl_value['updated_date'];

 							array_push($final_data, $driving_licence);
 						}
 					}
 				} 
 			}

 			// 17
 			if($mainKey == 'credit_cibil'){
 			 	foreach ($value as $pa_key => $cc_value) {
 					$cc_assigned_team_id = explode(",",$cc_value['insuff_team_id']);
 					 
 					foreach ($cc_assigned_team_id as $cc_assigned_team_id_key => $cc_assigned_team_id_value) {
 						$analyst_status = explode(",",$cc_value['analyst_status']);
						$cc_analyst_status = isset($analyst_status[$cc_assigned_team_id_key])?$analyst_status[$cc_assigned_team_id_key]:"0";

 						$insuff_status = explode(",",$cc_value['status']);
 						$cc_insuff_status = isset($insuff_status[$cc_assigned_team_id_key])?$insuff_status[$cc_assigned_team_id_key]:'0';

 						if($cc_assigned_team_id_value == $team_id && ($cc_analyst_status == '3' || $cc_insuff_status == '3')&& $cc_analyst_status != '10'){
 							
 							$credit_cibil['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$credit_cibil['component_name'] = $this->get_component_name($credit_cibil['component_id'])[$this->config->item('show_component_name')];
 							$credit_cibil['credit_id'] = $cc_value['credit_id'];
 							$credit_cibil['candidate_id'] = $cc_value['candidate_id']; 
 							$credit_cibil['candidate_detail'] = $this->getCandidateInfo($cc_value['candidate_id']);
 							$credit_cibil['index'] = $cc_assigned_team_id_key; 

 							$status = explode(",",$cc_value['status']);
 							$credit_cibil['status'] = isset($status[$cc_assigned_team_id_key])?$status[$cc_assigned_team_id_key]:"";

 							
 							$credit_cibil['analyst_status'] = $cc_analyst_status;
		 					$credit_cibil['insuff_status'] = $cc_insuff_status;


 							$credit_cibil['updated_date'] = $cc_value['updated_date'];

 							array_push($final_data, $credit_cibil);
 						}
 					}
 				} 
 			}
 			 
 			// 18
 			if($mainKey == 'bankruptcy'){
 			 	foreach ($value as $pa_key => $bankruptcy_value) {

 			 		// print_r($bankruptcy_value);
 			 		// echo "<br>";


 					$bankruptcy_assigned_team_id = explode(",",$bankruptcy_value['insuff_team_id']);
 					 // print_r($bankruptcy_assigned_team_id);
 			 		// echo "<br>";
 					foreach ($bankruptcy_assigned_team_id as $bankruptcy_assigned_team_id_key => $bankruptcy_assigned_team_id_value) {
 						
 						// echo "Key".$bankruptcy_assigned_team_id_key."||";
 						$analyst_status = explode(",",$bankruptcy_value['analyst_status']);
 						$bankruptcy_analyst_status  =  isset($analyst_status[$bankruptcy_assigned_team_id_key])?$analyst_status[$bankruptcy_assigned_team_id_key]:"0";
 						// echo "bankruptcy_analyst_status: ".$bankruptcy_analyst_status."||";
 						
 						$insuff_status = explode(",",$bankruptcy_value['status']);
 						$bankruptcy_insuff_status = isset($insuff_status[$bankruptcy_assigned_team_id_key])?$insuff_status[$bankruptcy_assigned_team_id_key]:'0';
 						 // echo "bankruptcy_insuff_status:";
 						 // print_r($insuff_status);
 						
 						if($bankruptcy_assigned_team_id_value == $team_id && ($bankruptcy_analyst_status == '3' || $bankruptcy_insuff_status == '3')&& $bankruptcy_analyst_status != '10'){
 							
 							$bankruptcy['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$bankruptcy['component_name'] = $this->get_component_name($bankruptcy['component_id'])[$this->config->item('show_component_name')];
 							$bankruptcy['bankruptcy_id'] = $bankruptcy_value['bankruptcy_id'];
 							$bankruptcy['candidate_id'] = $bankruptcy_value['candidate_id']; 
 							$bankruptcy['candidate_detail'] = $this->getCandidateInfo($bankruptcy_value['candidate_id']);
 							$bankruptcy['index'] = $bankruptcy_assigned_team_id_key; 

 							$status = explode(",",$bankruptcy_value['status']);
 							$bankruptcy['status'] = isset($status[$bankruptcy_assigned_team_id_key])?$status[$bankruptcy_assigned_team_id_key]:"";

 							
 							$bankruptcy['analyst_status'] = $bankruptcy_analyst_status;

 							
		 					$bankruptcy['insuff_status'] = $bankruptcy_insuff_status;


 							$bankruptcy['updated_date'] = $bankruptcy_value['updated_date'];

 							array_push($final_data, $bankruptcy);
 						}
 					}
 				} 
 			}

 			// 19
 			if($mainKey == 'adverse_database_media_check'){
 			 	foreach ($value as $pa_key => $adm_value) {
 					$adm_assigned_team_id = explode(",",$adm_value['insuff_team_id']);
 					 
 					foreach ($adm_assigned_team_id as $adm_assigned_team_id_key => $adm_assigned_team_id_value) {
 						$analyst_status = explode(",",$adm_value['analyst_status']);
 						$adm_analyst_status = isset($analyst_status[$adm_assigned_team_id_key])?$analyst_status[$adm_assigned_team_id_key]:"0";

 						$insuff_status = explode(",",$adm_value['status']);
 						$adm_insuff_status = isset($insuff_status[$adm_assigned_team_id_key])?$insuff_status[$adm_assigned_team_id_key]:'0';


 						if($adm_assigned_team_id_value == $team_id && ($adm_analyst_status == '3' || $adm_insuff_status == '3') && $adm_analyst_status != '10'){
 							
 							$adm_check['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$adm_check['component_name'] = $this->get_component_name($adm_check['component_id'])[$this->config->item('show_component_name')];
 							$adm_check['adverse_database_media_check_id'] = $adm_value['adverse_database_media_check_id'];
 							$adm_check['candidate_id'] = $adm_value['candidate_id']; 
 							$adm_check['candidate_detail'] = $this->getCandidateInfo($adm_value['candidate_id']);
 							$adm_check['index'] = $adm_assigned_team_id_key; 

 							$status = explode(",",$adm_value['status']);
 							$adm_check['status'] = isset($status[$adm_assigned_team_id_key])?$status[$adm_assigned_team_id_key]:"";

 							
 							$adm_check['analyst_status'] = $adm_analyst_status;

 							
		 					$adm_check['insuff_status'] = $adm_insuff_status;


 							$adm_check['updated_date'] = $adm_value['updated_date'];

 							array_push($final_data, $adm_check);
 						}
 					}
 				} 
 			}

 			// 20
 			if($mainKey == 'cv_check'){
 			 	foreach ($value as $pa_key => $cv_value) {
 					$cv_assigned_team_id = explode(",",$cv_value['insuff_team_id']);
 					 
 					foreach ($cv_assigned_team_id as $cv_assigned_team_id_key => $cv_assigned_team_id_value) {
 						$analyst_status = explode(",",$cv_value['analyst_status']);
 						$cv_analyst_status = isset($analyst_status[$cv_assigned_team_id_key])?$analyst_status[$cv_assigned_team_id_key]:"0";

 						$insuff_status = explode(",",$cv_value['status']);
 						$cv_insuff_status =  isset($insuff_status[$cv_assigned_team_id_key])?$insuff_status[$cv_assigned_team_id_key]:'0';

 						if($cv_assigned_team_id_value == $team_id && ($cv_analyst_status== '3' || $cv_insuff_status == '3') && $cv_analyst_status != '10'){
 							
 							$cv_check['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$cv_check['component_name'] = $this->get_component_name($cv_check['component_id'])[$this->config->item('show_component_name')];
 							$cv_check['cv_id'] = $cv_value['cv_id'];
 							$cv_check['candidate_id'] = $cv_value['candidate_id']; 
 							$cv_check['candidate_detail'] = $this->getCandidateInfo($cv_value['candidate_id']);
 							$cv_check['index'] = $cv_assigned_team_id_key; 

 							$status = explode(",",$cv_value['status']);
 							$cv_check['status'] = isset($status[$cv_assigned_team_id_key])?$status[$cv_assigned_team_id_key]:"";

 							
 							$cv_check['analyst_status'] = $cv_analyst_status;

 							
		 					$cv_check['insuff_status'] =  $cv_insuff_status;


 							$cv_check['updated_date'] = $cv_value['updated_date'];

 							array_push($final_data, $cv_check);
 						}
 					}
 				} 
 			} 

 			// 21
 			if($mainKey == 'health_checkup'){
 			 	foreach ($value as $pa_key => $health_value) {
 					$health_assigned_team_id = explode(",",$health_value['insuff_team_id']);
 					 
 					foreach ($health_assigned_team_id as $health_assigned_team_id_key => $health_assigned_team_id_value) {

 						$analyst_status = explode(",",$health_value['analyst_status']);
 						$hc_analyst_status = isset($analyst_status[$health_assigned_team_id_key])?$analyst_status[$health_assigned_team_id_key]:"";

 						$insuff_status = explode(",",$health_value['status']);
 						$hc_insuff_status = isset($insuff_status[$health_assigned_team_id_key])?$insuff_status[$health_assigned_team_id_key]:'';


 						if($health_assigned_team_id_value == $team_id && ($hc_analyst_status == '3' || $hc_insuff_status == '3') && $hc_analyst_status != '10'){
 							
 							$health_checkup['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$health_checkup['component_name'] = $this->get_component_name($health_checkup['component_id'])[$this->config->item('show_component_name')];
 							$health_checkup['health_checkup_id'] = $health_value['health_checkup_id'];
 							$health_checkup['candidate_id'] = $health_value['candidate_id']; 
 							$health_checkup['candidate_detail'] = $this->getCandidateInfo($health_value['candidate_id']);
 							$health_checkup['index'] = $health_assigned_team_id_key; 

 							$status = explode(",",$health_value['status']);
 							$health_checkup['status'] = isset($status[$health_assigned_team_id_key])?$status[$health_assigned_team_id_key]:"";

 							
 							$health_checkup['analyst_status'] = $hc_analyst_status;

 							
		 					$health_checkup['insuff_status'] = $hc_insuff_status;


 							$health_checkup['updated_date'] = $health_value['updated_date'];

 							array_push($final_data, $health_checkup);
 						}
 					}
 				} 
 			} 

 			// 21
 			if($mainKey == 'covid_19'){
 			 	foreach ($value as $pa_key => $health_value) {
 					$health_assigned_team_id = explode(",",$health_value['insuff_team_id']);
 					 
 					foreach ($health_assigned_team_id as $health_assigned_team_id_key => $health_assigned_team_id_value) {

 						$analyst_status = explode(",",$health_value['analyst_status']);
 						$hc_analyst_status = isset($analyst_status[$health_assigned_team_id_key])?$analyst_status[$health_assigned_team_id_key]:"";

 						$insuff_status = explode(",",$health_value['status']);
 						$hc_insuff_status = isset($insuff_status[$health_assigned_team_id_key])?$insuff_status[$health_assigned_team_id_key]:'';


 						if($health_assigned_team_id_value == $team_id && ($hc_analyst_status == '3' || $hc_insuff_status == '3') && $hc_analyst_status != '10'){
 							
 							$covid['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$covid['component_name'] = $this->get_component_name($covid['component_id'])[$this->config->item('show_component_name')];
 							$covid['covid_id'] = $health_value['covid_id'];
 							$covid['candidate_id'] = $health_value['candidate_id']; 
 							$covid['candidate_detail'] = $this->getCandidateInfo($health_value['candidate_id']);
 							$covid['index'] = $health_assigned_team_id_key; 

 							$status = explode(",",$health_value['status']);
 							$covid['status'] = isset($status[$health_assigned_team_id_key])?$status[$health_assigned_team_id_key]:"";

 							
 							$covid['analyst_status'] = $hc_analyst_status;

 							
		 					$covid['insuff_status'] = $hc_insuff_status;


 							$covid['updated_date'] = $health_value['updated_date'];

 							array_push($final_data, $covid);
 						}
 					}
 				} 
 			} 

 			// 22
 			// if($mainKey == 'employment_gap_check'){
 			//  	foreach ($value as $pa_key => $eg_value) {
 			// 		$eg_assigned_team_id = explode(",",$eg_value['insuff_team_id']);
 					 
 			// 		foreach ($eg_assigned_team_id as $eg_assigned_team_id_key => $eg_assigned_team_id_value) {

 			// 			$analyst_status = explode(",",$health_value['analyst_status']);
 			// 			$eg_analyst_status = isset($analyst_status[$health_assigned_team_id_key])?$analyst_status[$health_assigned_team_id_key]:"";

 			// 			$insuff_status = explode(",",$health_value['status']);
 			// 			$eg_insuff_status = isset($insuff_status[$health_assigned_team_id_key])?$insuff_status[$health_assigned_team_id_key]:'';
 

 			// 			if($eg_assigned_team_id_value == $team_id && ($eg_analyst_status == '3' || $eg_insuff_status == '3') && $eg_analyst_status != '10'){
 							
 			// 				$eg_checkup['component_name'] = $mainKey;
 			// 				$eg_checkup['component_id'] = $this->utilModel->getComponentId($mainKey);
 			// 				$eg_checkup['gap_id'] = $eg_value['gap_id'];
 			// 				$eg_checkup['candidate_id'] = $eg_value['candidate_id']; 
 			// 				$eg_checkup['candidate_detail'] = $this->getCandidateInfo($eg_value['candidate_id']);
 			// 				$eg_checkup['index'] = $eg_assigned_team_id_key; 

 			// 				$status = explode(",",$eg_value['status']);
 			// 				$eg_checkup['status'] = isset($status[$eg_assigned_team_id_key])?$status[$eg_assigned_team_id_key]:"";

 							
 			// 				$eg_checkup['analyst_status'] = $eg_analyst_status;
 			// 				$eg_checkup['insuff_status'] = $eg_insuff_status;

 			// 				$insuff_status = explode(",",$eg_value['insuff_status']);
		 	// 				$eg_checkup['insuff_status'] = isset($insuff_status[$eg_assigned_team_id_key])?$insuff_status[$eg_assigned_team_id_key]:'';


 			// 				$eg_checkup['updated_date'] = $eg_value['updated_date'];

 			// 				array_push($final_data, $eg_checkup);
 			// 			}
 			// 		}
 			// 	} 
 			// }

 			if($mainKey == 'employment_gap_check'){
 				foreach ($value as $eg_key => $eg_value) {
 					// print_r(); 
 					if($eg_value['insuff_team_id'] == $team_id && $eg_value['analyst_status'] != '10' && ($eg_value['analyst_status'] == 3 || $eg_value['status'] == 3)){
 						
	 					$eg_value['component_id'] = $this->utilModel->getComponentId($mainKey); 
	 					$eg_value['component_name'] = $this->get_component_name($eg_value['component_id'])[$this->config->item('show_component_name')];
	 					$eg_value['candidate_detail'] = $this->getCandidateInfo($eg_value['candidate_id']);
	 					$eg_value['index'] ='0';
	 					array_push($final_data, $eg_value);
 					}	
 				}
 			}

 			$components = ['right_to_work','sex_offender','politically_exposed','india_civil_litigation','mca','nric','gsa','oig'];
 			// 22
 			if(in_array($mainKey, $components)){foreach ($value as $pa_key => $health_value) {
 					$health_assigned_team_id = explode(",",$health_value['insuff_team_id']);
 					 
 					foreach ($health_assigned_team_id as $health_assigned_team_id_key => $health_assigned_team_id_value) {

 						$analyst_status = explode(",",$health_value['analyst_status']);
 						$hc_analyst_status = isset($analyst_status[$health_assigned_team_id_key])?$analyst_status[$health_assigned_team_id_key]:"";

 						$insuff_status = explode(",",$health_value['status']);
 						$hc_insuff_status = isset($insuff_status[$health_assigned_team_id_key])?$insuff_status[$health_assigned_team_id_key]:'';


 						if($health_assigned_team_id_value == $team_id && ($hc_analyst_status == '3' || $hc_insuff_status == '3') && $hc_analyst_status != '10'){
 							
 							$covid['component_id'] = $this->utilModel->getComponentId($mainKey);
 							$covid['component_name'] = $this->get_component_name($covid['component_id'])[$this->config->item('show_component_name')];
 							// $covid['covid_id'] = $health_value['covid_id'];
 							$covid['candidate_id'] = $health_value['candidate_id']; 
 							$covid['candidate_detail'] = $this->getCandidateInfo($health_value['candidate_id']);
 							$covid['index'] = $health_assigned_team_id_key; 

 							$status = explode(",",$health_value['status']);
 							$covid['status'] = isset($status[$health_assigned_team_id_key])?$status[$health_assigned_team_id_key]:"";

 							
 							$covid['analyst_status'] = $hc_analyst_status;

 							
		 					$covid['insuff_status'] = $hc_insuff_status;


 							$covid['updated_date'] = $health_value['updated_date'];

 							array_push($final_data, $covid);
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
 		 
 		$candidate = "SELECT first_name, last_name, phone_number,client_id,form_values FROM candidate where `candidate_id` =".$candidate_id;
 		 
 		$result = $this->db->query($candidate)->row_array();
 		$client = isset($result['client_id'])?$result['client_id']:0;
 		$result['client_name'] = $this->getClientInfo($client);
 		return $result;
 	}

 	function getClientInfo($client_id){
 		$tbl_client = "SELECT client_name  FROM tbl_client where `client_id` =".$client_id;
 		$result = $this->db->query($tbl_client)->row_array();
 		return isset($result['client_name'])?$result['client_name']:'-';
 	}
 	
 
}