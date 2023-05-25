<?php
	
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	class Excel_Extract_Model extends CI_Model {

		function client_clarification_excel_extract_to_client($variable_array) {
			$return_value = array();

			$client_details = $variable_array['client_details'];
			$rule_criteria_rules = json_decode($variable_array['rule_criteria_rules'],true);
			$where_condition = array(
				'T1.client_clarification_viewed_by_client_status' => 0,
				'T3.client_id' => $client_details['client_id']
			);
			$check_rule = 0;
			$rule_condition = '';
			foreach ($variable_array['remaining_days_rules'] as $key => $value) {
				if ($rule_criteria_rules['remaining_days_type'] == $value['id']) {
					$rule_condition = '(DATEDIFF(CURDATE(), date(T1.client_clarification_created_date)))'.' '.$value['db_symbol'].' '.$rule_criteria_rules['remaining_days_value'];
					$check_rule = 1;
					break;
				}
			}

			if ($check_rule == 1) {
				$db_result = $this->db->query('SELECT T1.*,T2.title,T2.first_name,T2.last_name,T2.father_name,T2.employee_id,T2.country_code,T2.phone_number,T2.email_id,T2.package_name,T2.candidate_details_added_from,T2.created_date FROM user_filled_details_component_client_clarification AS T1 LEFT JOIN candidate AS T2 ON T1.candidate_id = T2.candidate_id LEFT JOIN tbl_client AS T3 ON T2.client_id = T3.client_id WHERE T1.client_clarification_viewed_by_client_status = 0 AND T3.client_id = '.$client_details['client_id'].' AND T1.client_clarification_viewed_by_client_status IN (0) AND '.$rule_condition)->result_array();

				if(count($db_result) > 0) {
					$return_value['result_status'] = 1;
					$excel_sheet_name = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', $client_details['client_name'])).'-client-clarifications-'.date('d-m-Y-H-i-s').'.xlsx';
			        $objPHPExcel = new Spreadsheet();
			        
			        $alphabet = 'A';
			        // set Header
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Sr.no.');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Case Id');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Candidate');
			        // $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Phone Number');
			        // $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Email ID');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Employee ID');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Case Start Date');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Component Name');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Clarification Description');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Clarification Raised Date');

			       	foreach ($db_result as $key => $value) {
			       		$alphabet = 'A';
			       		$objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $key + 1);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $value['candidate_id']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $value['first_name'].' '.$value['last_name']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $value['country_code'].'-'.$value['phone_number']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $value['email_id']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $value['employee_id'] != '' ? $value['employee_id'] : '-' );
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), date("d-m-Y", strtotime($value['created_date'])));
				        $component_name = '-';
				        foreach ($variable_array['component_list'] as $key1 => $value1) {
				        	if ($value1['component_id'] == $value['component_id']) {
				        		$component_name = $value1[$this->config->item('show_component_name')];
				        		break;
				        	}
				        }
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $component_name);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $value['client_clarification_description']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), date("d-m-Y", strtotime($value['client_clarification_created_date'])));
			       	}

			       	// echo json_encode(array('filename' =>$excel_sheet_name ,'path' =>base_url().'../downloads/client-clarification-excel-sheet/'.$excel_sheet_name));
									
			        $objWriter = new Xlsx($objPHPExcel);
			        $objWriter->save('../downloads/client-clarification-excel-sheet/'.$excel_sheet_name);
			        $return_value['excel_sheet_name'] = $excel_sheet_name;
			        $return_value['excel_sheet_path'] = base_url().'../downloads/client-clarification-excel-sheet/';
			        $return_value['excel_sheet_storage_folder_name'] = 'client-clarification-excel-sheet';
			        // download file
			        // header("Content-Type: application/vnd.ms-excel");
			        // redirect(base_url().'../downloads/client-clarification-excel-sheet/'.$excel_sheet_name);
				} else {
					$return_value['result_status'] = 0;
				}
			} else {
				$return_value['result_status'] = 0;
			}
			
			return $return_value;
		}
		
		function form_not_filled_excel_extract_to_client($variable_array) {
			$return_value = array();

			$client_details = $variable_array['client_details'];
			$rule_criteria_rules = json_decode($variable_array['rule_criteria_rules'],true);
			$where_condition = array(
				'T1.is_submitted' => 0,
				'T2.client_id' => $client_details['client_id']
			);
			$check_rule = 0;
			$rule_condition = '';
			foreach ($variable_array['remaining_days_rules'] as $key => $value) {
				if ($rule_criteria_rules['remaining_days_type'] == $value['id']) {
					$rule_condition = '(DATEDIFF(CURDATE(), date(T1.created_date)))'.' '.$value['db_symbol'].' '.$rule_criteria_rules['remaining_days_value'];
					$check_rule = 1;
					break;
				}
			}

			if ($check_rule == 1) {
				$db_result = $this->db->query('SELECT T1.candidate_id,T1.title,T1.title,T1.first_name,T1.last_name,T1.father_name,T1.employee_id,T1.country_code,T1.phone_number,T1.email_id,T1.package_name,T1.candidate_details_added_from,T1.created_date FROM candidate AS T1 LEFT JOIN tbl_client AS T2 ON T1.client_id = T2.client_id WHERE T2.client_id = '.$client_details['client_id'].' AND T1.is_submitted IN (0) AND '.$rule_condition)->result_array();
				
				if(count($db_result) > 0) {
					$return_value['result_status'] = 1;
					$excel_sheet_name = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', $client_details['client_name'])).'-form-not-filled-by-candidates-'.date('d-m-Y-H-i-s').'.xlsx';
			        $objPHPExcel = new Spreadsheet();
			        
			        $alphabet = 'A';
			        // set Header
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Sr.no.');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Case Id');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Candidate');
			        // $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Phone Number');
			        // $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Email ID');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Employee ID');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Case Start Date');

			       	foreach ($db_result as $key => $value) {
			       		$alphabet = 'A';
			       		$objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $key + 1);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $value['candidate_id']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $value['first_name'].' '.$value['last_name']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $value['country_code'].'-'.$value['phone_number']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $value['email_id']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), $value['employee_id'] != '' ? $value['employee_id'] : '-' );
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($key + 2), date("d-m-Y", strtotime($value['created_date'])));
			       	}

			       	// echo json_encode(array('filename' =>$excel_sheet_name ,'path' =>base_url().'../downloads/form-not-filled-by-candidate-excel-sheet/'.$excel_sheet_name));
									
			        $objWriter = new Xlsx($objPHPExcel);
			        $objWriter->save('../downloads/form-not-filled-by-candidate-excel-sheet/'.$excel_sheet_name);
			        $return_value['excel_sheet_name'] = $excel_sheet_name;
			        $return_value['excel_sheet_path'] = base_url().'../downloads/form-not-filled-by-candidate-excel-sheet/';
			        $return_value['excel_sheet_storage_folder_name'] = 'form-not-filled-by-candidate-excel-sheet';
			        // download file
			        // header("Content-Type: application/vnd.ms-excel");
			        // redirect(base_url().'../downloads/form-not-filled-by-candidate-excel-sheet/'.$excel_sheet_name);
				} else {
					$return_value['result_status'] = 0;
				}
			} else {
				$return_value['result_status'] = 0;
			}
			
			return $return_value;
		}

		function insuff_excel_extract_to_client($variable_array) {
			$return_value = array();
			$all_cases = array();

			$client_details = $variable_array['client_details'];
			$rule_criteria_rules = json_decode($variable_array['rule_criteria_rules'],true);
			$where_condition = array(
				'T1.is_submitted' => 3,
				'T2.client_id' => $client_details['client_id']
			);
			$check_rule = 0;
			$rule_condition = '';
			foreach ($variable_array['remaining_days_rules'] as $key => $value) {
				if ($rule_criteria_rules['remaining_days_type'] == $value['id']) {
					$rule_condition = '(DATEDIFF(CURDATE(), date(T1.created_date)))'.' '.$value['db_symbol'].' '.$rule_criteria_rules['remaining_days_value'];
					$check_rule = 1;
					break;
				}
			} 

			if ($check_rule == 1) {
				$db_result = $this->db->query('SELECT T1.candidate_id,T1.title,T1.title,T1.first_name,T1.last_name,T1.father_name,T1.employee_id,T1.country_code,T1.phone_number,T1.email_id,T1.package_name,T1.candidate_details_added_from,T1.created_date FROM candidate AS T1 LEFT JOIN tbl_client AS T2 ON T1.client_id = T2.client_id WHERE T2.client_id = '.$client_details['client_id'].' AND T1.is_submitted IN (3)')->result_array();

				foreach ($db_result as $key => $value) { 
                	$cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']); 
                 	foreach ($cases as $k => $val) {
                     	if (in_array($val['component_id'],array('8','9','12')) && $this->input->post('table') == '8,9,12') {
                        	if ($val['analyst_status']== '3' || $val['is_submitted'] =='3') {
                            	array_push($all_cases, $val);
                        	}
                     	} else if (in_array($val['component_id'],array('6','10')) && $this->input->post('table') == '6,10') {
                        	if ($val['analyst_status']== '3' || $val['is_submitted'] =='3') {
                                array_push($all_cases, $val);
                            }
                     	} else {
                        	if ($val['analyst_status']== '3' || $val['is_submitted'] =='3') {
                           	 	array_push($all_cases, $val);
                        	}
                    	}  
                	}
	            } 
 
	            $candidate_data = array();
	            $data_array = array();
	            foreach ($all_cases as $key => $val) {
                    if (!array_key_exists($val['candidate_id'], $candidate_data)) {
                    	$candidate_data[$val['candidate_id']] = array( 
		                    'candidate_id' => $val['candidate_id'],
		                    'candidate_name' => $val['first_name'].' '.$val['last_name'],
		                    'first_name' => $val['first_name'],
		                    'last_name' => $val['last_name'],
		                    'father_name' => $val['father_name'],
		                    'employee_id' => $val['employee_id'],
		                    'date_of_birth' => $val['date_of_birth'],
		                    'client_name' => $val['client_name'],
		                    'country_code' => $val['country_code'],
		                    'phone_number' => $val['phone_number'],
		                    'email_id' => $val['email_id'],
		                    'created_date' => $val['created_date'],
                    		$val['component_name'].' '.$val['formNumber']=>array('insuff_date'=>$val['insuff_created_date'],'insuff_remarks'=>$val['insuff_remarks'])
                    	);

                    	$client = $val['client_name'];
                    	$client_id = $val['client_id'];
                    } else {
                    	$candidate_data[$val['candidate_id']][$val['component_name'].' '.$val['formNumber']] = array('insuff_date'=>$val['insuff_created_date'],'insuff_remarks'=>$val['insuff_remarks']); 
                    }

                    if (!array_key_exists($val['component_name'].' '.$val['formNumber'], $data_array)) {
                    	$data_array[$val['component_name'].' '.$val['formNumber']] = array('insuff_date'=>$val['insuff_created_date'],'insuff_remarks'=>$val['insuff_remarks']);
                    } else {
                    	$data_array[$val['component_name'].' '.$val['formNumber']] = array_merge($data_array[$val['component_name'].' '.$val['formNumber']],array('insuff_date'=>$val['insuff_created_date'],'insuff_remarks'=>$val['insuff_remarks']));
                    }
                }

				if(count($candidate_data) > 0) {
					$return_value['result_status'] = 1;
					$excel_sheet_name = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', $client_details['client_name'])).'-insuff-candidate-details-'.date('d-m-Y-H-i-s').'.xlsx';
			        $objPHPExcel = new Spreadsheet();
			        
			        $alphabet = 'A';
			        // set Header
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Sr.no.');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Case Id');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Candidate');
			        // $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Phone Number');
			        // $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Email ID');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Employee ID');
			        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Case Start Date');

			        $component_count = 1;
                	$key_array = array();
		            if (count($data_array)) { 
		                foreach ($data_array as $key => $value) {
		                   	$objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Component name '.($component_count++));
		                   	$objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Insuff Remarks');
		                   	$objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).'1', 'Insuff Created Date');
		                   	array_push($key_array,$key);
		                }
		            }

		            $rowCount = 2;
		            $ind = 1;
			       	foreach ($candidate_data as $key => $val) {
			       		$alphabet = 'A';
			       		$objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($rowCount), $ind++ );
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($rowCount), $val['candidate_id']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($rowCount), $val['first_name'].' '.$val['last_name']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($rowCount), $val['country_code'].'-'.$val['phone_number']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($rowCount), $val['email_id']);
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($rowCount), $val['employee_id'] != '' ? $val['employee_id'] : '-' );
				        $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++).($rowCount), date("d-m-Y", strtotime($val['created_date'])));

                        foreach ($key_array as $key1 => $value) {
                           	$insuff_created_date = isset($val[$value]['insuff_date'])?$val[$value]['insuff_date']:' ';
                           	$insuff_remarks = isset($val[$value]['insuff_remarks'])?$val[$value]['insuff_remarks']:' ';
                           	$component_name = isset($val[$value]['insuff_remarks'])?$value:' ';
                            $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++) . $rowCount, $component_name);
                            $objPHPExcel->getActiveSheet()->SetCellValue(($alphabet++) . $rowCount, $insuff_created_date);
                        }
                        $rowCount++;
			       	}

			       	// echo json_encode(array('filename' =>$excel_sheet_name ,'path' =>base_url().'../downloads/insuff-excel-sheet/'.$excel_sheet_name));
									
			        $objWriter = new Xlsx($objPHPExcel);
			        $objWriter->save('../downloads/insuff-excel-sheet/'.$excel_sheet_name);
			        $return_value['excel_sheet_name'] = $excel_sheet_name;
			        $return_value['excel_sheet_path'] = base_url().'../downloads/insuff-excel-sheet/';
			        $return_value['excel_sheet_storage_folder_name'] = 'insuff-excel-sheet';
			        // download file
			        // header("Content-Type: application/vnd.ms-excel");
			        // redirect(base_url().'../downloads/insuff-excel-sheet/'.$excel_sheet_name);
				} else {
					$return_value['result_status'] = 0;
				}
			} else {
				$return_value['result_status'] = 0;
			}
			
			return $return_value;
		}
	}