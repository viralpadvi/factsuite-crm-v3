<?php
	
	/**
	 * 
	 */
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	class CronJobsModel extends CI_Model
	{

		function date_convert($date){
	        $d = 'NA';
	        if ($date !='' && $date !=null && $date !='-') { 
	            $d = date('d-m-Y', strtotime($date));
	        }
	        return $d;
    	}

		// Insuff Mail to Client
		public function insuff_case_list(){
			 
			// $insuff_candidate_info = $this->db->select('tbl_client.client_name, candidate.*')->from('tbl_client')->join('candidate','tbl_client.client_id = candidate.client_id','left')->where('candidate.is_submitted IN (3)')->get()->result_array();
			$client_info = $this->db->select('client_id,client_name')->where('active_status IN (1)')->get('tbl_client')->result_array();
			$i=1;
			$clinet_id_array = array();
			foreach ($client_info as $key => $value) {

				$where = array(
					'client_id'=>$value['client_id'],
					'candidate.is_submitted' => '3'
				);

				$client_spocdetails_info = $this->db->where('client_id',$value['client_id'])->get('tbl_clientspocdetails')->result_array();
				$insuffCaseList = array();
				
				$insuff_candidate_info = $this->db->where($where)->get('candidate')->result_array();
				if(count($insuff_candidate_info) > 0){
					$component_names = array();
					$case_data =array();
					$boday_message = "";
					$component_name = array();
					foreach ($insuff_candidate_info as $key => $candidate_info_value) {		
					   $component_name = $this->isAnyComponentInsuff($candidate_info_value['candidate_id']);
					   echo "candidate_id: ".$candidate_info_value['candidate_id']."</br>";
					   print_r($component_name);
					   echo "</br></br>";
									
					}
					
				}

			// return $insuffCaseList;
			} 
		}



		// Case upload acknowledgement to Client
		public function today_case_uploaded_acknowledgement_list(){
				 
		}

		//BGV Report uploaded notification to Client
		public function completed_bgv_repot_case_list(){
					 
		}

		function isAnyComponentInsuff($candidate_id){
				 
			$candidateData =  $this->db->where('candidate_id',$candidate_id)->where('is_submitted','3')->get('candidate')->row_array();
			// echo $this->db->last_query();
			// echo "</br>";
			$component_data = array();
			$component_ids = explode(',',$candidateData['component_ids']);
			foreach ($component_ids as $key => $value) {
				$table_name = $this->utilModel->getComponent_or_PageName($value);
				$componentInfo = $this->db->where('candidate_id',$candidate_id)->get($table_name)->row_array();
				// echo "query :".$key.": ".$this->db->last_query()."</br>";
				$oldAnalystStatus = isset($componentInfo['analyst_status'])?$componentInfo['analyst_status']:'0';
				if($oldAnalystStatus != null && $oldAnalystStatus != ''){
					$status = explode(',',$oldAnalystStatus);
					if(in_array('3',$status)){
						$row['component_name'] = $table_name;
						$row['coponent_info']  = $componentInfo;
						array_push($component_data,$row);
					}	
				}
				
			} 
			
			return $component_data; 
		}


		function get_next_reminder_date($start_date, $frequency) {
		    $date = new DateTime($start_date);
		    switch ($frequency) {
		    	case 'daily' :
		            $interval = 'P1D';
		            break;
		        case 'weekly' :
		            $interval = 'P1W';
		            break;
		        case 'monthly' :
		            $interval = 'P1M';
		            break;
		        case 'quarterly' :
		            $interval = 'P3M';
		            break;
		        case 'annually' :
		            $interval = 'P1Y';
		            break;
		    }

		    $date->add(new DateInterval($interval));

		    if ( time() > $date->getTimestamp() ) { 
		        return $date->format('Y-m-d');
		    } else {
		        return $date->format('Y-m-d');
		    }
		}


		function get_daily_client_case_status(){ 
			 $curr_date = date('Y-m-d');
			 $curr_time = date('H:i');
			 $d = date('D');
			 $m =  date('M');
			 
			// $cust_msg = $this->db->where('schedule_id',3)->get('schedule_reporting')->row_array();
			// $cust_msg = $this->db->where('interval_time',$curr_time)->get('schedule_reporting')->result_array();

			$cust_msg = $this->db->query("SELECT * FROM schedule_reporting WHERE 
			 (
			  (interval_type='daily' AND interval_time  REGEXP '".$curr_time."' AND (end_status='never' OR end_interval >= '".$curr_date."') AND selected_dates <= '".$curr_date."' ) 
			  OR  
			  	( interval_type='weekly' AND interval_time REGEXP '".$curr_time."' AND selected_weeks REGEXP '".$d."'  AND (end_status='never' OR end_interval >= '".$curr_date."') AND selected_dates <= '".$curr_date."' )
			  OR  
			  	(interval_type='monthly' AND interval_time REGEXP '".$curr_time."' AND interval_date='".date('Y-m-d')."'  AND selected_months REGEXP '".$m."' AND (end_status='never' OR end_interval >= '".$curr_date."') AND selected_dates <= '".$curr_date."' )
			  OR  
			  	(interval_type='annually' AND interval_time REGEXP '".$curr_time."' AND selected_dates REGEXP '".$curr_date."' )
			  OR  
			  	(interval_type='once' AND interval_time REGEXP '".$curr_time."' AND schedule_date_time = '".$curr_date."' ) 
			)
			")->row_array();

			 // $cust_msg = $this->db->query("SELECT * FROM schedule_reporting WHERE (interval_time = '10:30' AND interval_date='31-05-2022') OR schedule_date_time = '2022-05-26 04:10'")->row_array();

			if ($cust_msg == null) {
				return false;
			}
			// date('Y-m-d', strtotime('+1 day', strtotime($date)))
			// SELECT * FROM schedule_reporting WHERE (interval_time = '10:30' AND interval_date='31-05-2022') OR schedule_date_time = '2022-05-26 04:10'
			if ($cust_msg['schedule_date_time'] != $curr_date) { 
				$update_date = $this->get_next_reminder_date(date('Y-m-d'), $cust_msg['interval_type']);
				$this->db->where('schedule_id',$cust_msg['schedule_id'])->update('schedule_reporting',array('interval_date'=>$update_date));
			}
			$report_fields = json_decode($cust_msg['report_fields'],true);
			$client_info = $this->db->select('client_id,client_name')->where('active_status IN (1)')->get('tbl_client')->result_array();
			$i=1;
			$clinet_id_array = array();
			$alphabet = array('B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
			// foreach ($client_info as $key => $value) {

				$where = array(
					'client_id'=>$cust_msg['client_id'] 
				);

				$client_spocdetails_info = $this->db->where('client_id',$cust_msg['client_id'])->get('tbl_clientspocdetails')->result_array();
				$CaseList = array();
				
				$candidate_info = $this->db->where($where)->get('candidate')->result_array();
				if(count($candidate_info) > 0){
					$component_names = array();
					$case_data =array();
					$boday_message = "";
					$component_name = array();


	 		// create file name
	        $fileName = 'component-report-'.time().'.xlsx';   
	        $objPHPExcel = new Spreadsheet();
	        
	        // set Header
	        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr.no.');

	        if (count($report_fields)) {
	        	foreach ($report_fields as $k => $val) {
	        		$objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$k].'1', $val['name']);
	        	}
	        }
	        /*$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case Id');
	        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Client Name');       
	        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'First Name');       
	        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Last Name');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Father Name');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Phone Number');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Email');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Date Of Birth');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Created Date');      
	        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Case Status');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Employee Id');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Remarks');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Priority');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'InputQc Status');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Component Name');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Forms');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Component Status');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Output Status');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Assigned Role');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Assigned to analyst/Specialist');       
            $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Case Start Date');       
            $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Insuff Remarks');       
            $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Verification Remarks');       
            $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Insuff Closure Remarks');       
            $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Progress Remarks');       
            $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Insuff Date');       
            $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Insuff Close Date');       
            $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Panel');       
            $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Vendor');*/       
	        // set Row
	        $rowCount = 2;
	        $i =1;
	        $n =0;

	         

			foreach ($candidate_info as $key1 => $candidate_info_value) {		
					   $component = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($candidate_info_value['candidate_id']);
					  foreach ($component as $key => $value) { 
								$is_submitted = '';
					  			if ($value['is_submitted'] == '0') {           
					                $is_submitted = 'Not Initiated';
					            }else if ($value['is_submitted'] == '1') {     
					                $is_submitted = 'In Progress';
					            }else if ($value['is_submitted'] == '2') {          
					                $is_submitted = 'Verified Clear';
					            }else if ($value['is_submitted'] == '3') {
					                
					                $is_submitted = 'Insuff';
					            }else{ 
					                $is_submitted = 'Not Initiated';
					            }

			  					$status = '';
			    					if ($value['analyst_status'] == '0') {
			                         
			                        $status = 'Not Initiated'; 
			                    }else if ($value['analyst_status'] == '1') {
			                         
			                        $status = 'In Progress'; 
			                    }else if ($value['analyst_status'] == '2') {
			                         
			                        $status = 'Completed';
			                        
			                    }else if ($value['analyst_status']== '3') {
			                         
			                        $status = 'Insufficiency';
			                        
			                    }else if ($value['analyst_status'] == '4') {
			                       
			                        $status = 'Verified Clear';
			                        
			                    }else if ($value['analyst_status'] == '5') {
			                       
			                        $status = 'Stop Check';
			                        
			                    }else if ($value['analyst_status'] == '6') {
			                       
			                        $status = 'Unable to verify';
			                        
			                    }else if ($value['analyst_status'] == '7') {
			                       
			                        $status = 'Verified discrepancy';
			                       
			                    }else if ($value['analyst_status'] == '8') {
			                       
			                        $status = 'Client clarification';
			                       
			                    }else if ($value['analyst_status'] == '9') {
			                       
			                        $status = 'Closed Insufficiency';
			                        
			                    }else if ($value['analyst_status'] == '10'){
			                        $status = 'QC Error'; 
			                     
			                    }else if ($value['analyst_status'] == '11'){
			                        $status = 'Insuff Clear';  
			                    }
               
			                $inputQcStatus = '';
			                if ($value['status'] == '0') {
			                         
			                    $inputQcStatus = 'Not Initiated';
			                        
			                }else if ($value['status'] == '1') {
			                         
			                    $inputQcStatus = 'In Progress';
			                         
			                }else if ($value['status'] == '2') {
			                         
			                    $inputQcStatus = 'Completed';
			                        
			                }else if ($value['status']== '3') {
			                         
			                    $inputQcStatus = 'Insufficiency';
			                        
			                }else if ($value['status'] == '4') {
			                       
			                    $inputQcStatus = 'Verified Clear';
			                        
			                }else if ($value['status'] == '5') {
			                       
			                    $inputQcStatus = 'Stop Check';
			                        
			                }else if ($value['status'] == '6') {
			                       
			                    $inputQcStatus = 'Unable to verify';
			                        
			                }else if ($value['status'] == '7') {
			                       
			                    $inputQcStatus = 'Verified discrepancy';
			                        
			                }else if ($value['status'] == '8') {
			                       
			                    $inputQcStatus = 'Client clarification';
			                         
			                }else if ($value['status'] == '9') {
			                       
			                    $inputQcStatus = 'Closed Insufficiency';
			                        
			                }
			                 
			                $outPutQCStatus = '';

			                if ( $value['output_status'] == '0'){
			                    $outPutQCStatus = 'Not Initiated';
			                } else if ($value['output_status'] == '1'){
			                    $outPutQCStatus = 'Approved';
			                } else if ($value['output_status'] == '2') {
			                    $outPutQCStatus = 'Rejected';
			                } 

			               


			                $priority ='';
			            if($value['priority'] == '0'){
			                    $priority = 'Low priority' ;
			            }else if($value['priority'] == '1'){  
			                    $priority = 'Medium priority' ;
			            }else if($value['priority'] == '2'){  
			                    $priority = 'High priority' ;
			                  
			            }
	        	 
	            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i++);
	            if (count($report_fields)) {
	        	foreach ($report_fields as $k => $val) {
	        		$objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$k]. $rowCount, $value[$val['field']]);
	        	}
	        }
	           /* $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value['candidate_id']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value['client_name']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value['first_name']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['last_name']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value['father_name']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value['phone_number']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value['email_id']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $this->date_convert($value['date_of_birth'])); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $this->date_convert($value['date_of_joining']));  
	            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $is_submitted);  
	            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $value['employee_id']);  
	            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $value['remark']);  
	            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $priority); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $inputQcStatus); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $value['component_name']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $value['formNumber']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $status); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $outPutQCStatus);  
	            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $value['assigned_role']);  
	            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $value['assigned_team_name']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $this->date_convert($value['case_submitted_date'])); 
                $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $value['insuff_remarks']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $value['verification_remarks']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $value['insuff_closure_remarks']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $value['progress_remarks']); 

                $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $this->date_convert($value['insuff_created_date'])); 
                $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $this->date_convert($value['insuff_close_date'])); 
                $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $value['panel']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $value['vendor']); */

	            $rowCount++;

	        }
	         
	    
	 

			echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
									
	        $objWriter = new Xlsx($objPHPExcel);
	        $objWriter->save('../uploads/report/'.$fileName);
	 		// download file
	        // header("Content-Type: application/vnd.ms-excel");
	        // redirect(base_url().'uploads/report/'.$fileName);  


			$variable_array = array(
				'mail_to' => $cust_msg['client_email'],
				'mail_subject' => $cust_msg['mail_subject'],
				'mail_message' => $cust_msg['mail_message_body'],
				'attachment_available' => 1,
				'attachment_files' => $this->config->item('purchased_package_invoice_file_storage_link'),
				'attach_file_name' => $fileName
			);

			if (file_exists($this->config->item('purchased_package_invoice_file_storage_link').$fileName)) {
				$variable_array['attachment_available'] = 1;
				$variable_array['attachment_files'] = $this->config->item('purchased_package_invoice_file_storage_link');
				$variable_array['attach_file_name'] = $fileName;
			} else {
				$variable_array['attachment_available'] = 0;
				$variable_array['attachment_files'] = '';
				$variable_array['attach_file_name'] = '';
			}
			$this->emailModel->send_mail_v2($variable_array);
					
					}


				}

			// return $CaseList;
			// } 
		}


		function client_auomated_reminders() {
			$where_condition = array(
				'notification_status' => 1
			);
			$query = $this->db->where($where_condition)->get('client_case_automated_email_notification')->result_array();

			if (count($query) > 0) {
				$current_time = date('h:i a');
				$all_case_type = json_decode(file_get_contents(base_url().'assets/custom-js/json/case-type.json'),true);
				$rule_criteras = json_decode(file_get_contents(base_url().'assets/custom-js/json/rule-criteras.json'),true);
				$remaining_days_rules = json_decode(file_get_contents(base_url().'assets/custom-js/json/remaining-days-rules.json'),true);
				$component_list = $this->db->select('component_id,fs_website_component_name')->get('components')->result_array();
				foreach ($query as $key => $value) {
					if(in_array($current_time, json_decode($value['notification_time'],true))) {
						$client_id = explode(',',$value['client_id']);
						$get_active_clients = $this->db->select('client_id, client_name')->where_in('client_id',$client_id)->where('client_status',1)->get('tbl_client')->result_array();
						foreach ($get_active_clients as $key1 => $value1) {
							$where_condition_2 = array(
								'spoc_status' => 1,
								'client_id' => $value1['client_id']
							);
							$client_spoc_email_ids = $this->db->select('spoc_id,spoc_email_id')->where($where_condition_2)->get('tbl_clientspocdetails')->result_array();
							if (count($client_spoc_email_ids) > 0) {
								$variable_array = array(
									'client_details' => $value1,
									'case_type' => $value['case_type'],
									'rule_criteria' => $value['rule_criteria'],
									'rule_criteria_rules' => $value['rule_criteria_rules'],
									'all_case_type' => $all_case_type,
									'rule_criteras' => $rule_criteras,
									'remaining_days_rules' => $remaining_days_rules,
									'component_list' => $component_list
								);

								$reutrn_details = '';
								if ($value['case_type'] == 0) {
									// Client Clarification
									$reutrn_details = $this->excel_Extract_Model->client_clarification_excel_extract_to_client($variable_array);
								} else if ($value['case_type'] == 1) {
									// Insuff
									$reutrn_details = $this->excel_Extract_Model->insuff_excel_extract_to_client($variable_array);
								} else if ($value['case_type'] == 2) {
									// Form Not Filled by Candidate
									$reutrn_details = $this->excel_Extract_Model->form_not_filled_excel_extract_to_client($variable_array);
								}

								if ($reutrn_details != '') {
									if($reutrn_details['result_status'] == 1) {
										$spoc_email_id = [];
										$client_spoc_id = [];
										foreach ($client_spoc_email_ids as $key2 => $value2) {
											array_push($spoc_email_id, $value2['spoc_email_id']);
											array_push($client_spoc_id, $value2['spoc_id']);
										}
										$variable_array_2 = array(
											'mail_to' => $spoc_email_id,
											'mail_message' => $value['notification_email_description'],
											'mail_subject' => $value['notification_email_subject']
										);

										$file_storage_link = $this->config->item('client_reminder_file_storage_link').$reutrn_details['excel_sheet_storage_folder_name'].'/';
										if (file_exists($file_storage_link.$reutrn_details['excel_sheet_name'])) {
											$variable_array_2['attachment_available'] = 1;
											$variable_array_2['attachment_file_link'] = $file_storage_link;
											$variable_array_2['attach_file_name'] = $reutrn_details['excel_sheet_name'];
											$variable_array_2['add_to_cc'] = 0;
											// $variable_array_2['cc_mail_id'] = $this->config->item('accounts_email_id');

											$trigger_mail = $this->emailModel->send_mail_v3($variable_array_2);
											
											$add_data = array(
												'client_automated_email_notification_id' => $value['client_case_automated_email_notification_id'],
												'client_id' => $value1['client_id'],
												'client_spoc_id' => implode(',', $client_spoc_id),
												'file_name' => $reutrn_details['excel_sheet_name'],
												'email_sent_status' => $trigger_mail
											);

											$this->db->insert('client_automated_email_notifications_triggered',$add_data);
										}
									}
								}
							}
						}
					}
				}
			}
		}
		 
	}

 