<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
class DumpExcel extends CI_Controller {

	function __construct()  
	{
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('utilModel');  
	  $this->load->model('caseModel');  
	  $this->load->model('adminViewAllCaseModel');   
	}	 


	function get_all_clients(){
		$user = $this->session->userdata('logged-in-client'); 
		$result = $this->db->where('client_id',$user['client_id'])->get('tbl_client')->row_array(); 
		$sub_result = $this->db->where('is_master',$user['client_id'])->get('tbl_client')->result_array();
	 return array('parent'=>$result, 'child'=>$sub_result);
	}


   function get_array($linksArray){
        $array_list =array();
        foreach($linksArray as $link)
        {
            if($link != '' && $link !=null)
            {
               array_push($array_list,$link);
            }
        }

        return implode(',', $array_list);
    }
	function candidate_report(){
		$alphabet = $this->utilModel->return_excel_val(); 
		$client = $this->session->userdata('logged-in-client');
		$user = $this->session->userdata('logged-in-client');
		$client_ids = array();
		if ($this->input->post('client') == '0') {
			$data = $this->get_all_clients(); 
			array_push($client_ids,$data['parent']['client_id']);
			if (count($data['child']) > 0) {
				foreach ($data['child'] as $key => $value) {
					array_push($client_ids,$value['client_id']);
				}
			}
		}else{
			array_push($client_ids,$this->input->post('client'));
		}

 		
			$i=1;
			$clinet_id_array = array();

			 $q = implode(',', $client_ids);
		 if ($user !='' && $user !=null && count($client_ids)==0) {
		 	$q1 = $user['client_id'];
		 }else{ 
		    $q1 = isset($q)?$q:$user['client_id'];
		 } 

		if ($q1 == 0 || $q1 ==null || $q1 == '' || $q1 == 'null') {
			$q1 = $user['client_id'];
		}

	

		 $where ='client_id IN ( '.$q1.' ) ';
			  
				/*$where = array(
					'client_id'=>$client['client_id'] 
				);*/

				$client_spocdetails_info = $this->db->where($where)->get('tbl_clientspocdetails')->result_array();
				$CaseList = array();

		$where ='';
		$clients ='client_id IN ( '.$q1.' ) ';
        if ($this->input->post('duration') == 'today') {
          $where="  date(created_date) = CURDATE() AND ".$clients;
        }else if($this->input->post('duration') == 'week'){
          $where="  date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()  AND ".$clients;
        }else if($this->input->post('duration') == 'month'){
          $where="  date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()  AND ".$clients;
        }else if($this->input->post('duration') == 'year'){
          $where="  date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()  AND ".$clients;
        }else if($this->input->post('duration') == 'between'){
          $where="  date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'  AND ".$clients;
        }else{
            $where=$clients;
        }
				
					$component_names = array();
					$case_data =array();
					$boday_message = "";
					$component_name = array();
					$data_array = array();
		             $candidate_data = array();
		             $analyst_data = array();
				$candidate_info = $this->db->where($where)->get('candidate')->result_array();
				if(count($candidate_info) > 0){

			foreach ($candidate_info as $key => $value) {

			$data['candidate'] = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']); 
				$analyst = array();
				// $case_array = array();
				foreach ($data['candidate'] as $k => $val) { 
					 
 					

	  					$status = '';
	    					if ($val['analyst_status'] == '0') {
	                         
	                        $status = 'Not Initiated'; 
	                    }else if ($val['analyst_status'] == '1') {
	                         
	                        $status = 'In Progress'; 
	                    }else if ($val['analyst_status'] == '2') {
	                         
	                        $status = 'Completed';
	                        
	                    }else if ($val['analyst_status']== '3') {
	                         
	                        $status = 'Insufficiency';
	                        
	                    }else if ($val['analyst_status'] == '4') {
	                       
	                        $status = 'Verified Clear';
	                        
	                    }else if ($val['analyst_status'] == '5') {
	                       
	                        $status = 'Stop Check';
	                        
	                    }else if ($val['analyst_status'] == '6') {
	                       
	                        $status = 'Unable to verify';
	                        
	                    }else if ($val['analyst_status'] == '7') {
	                       
	                        $status = 'Verified discrepancy';
	                       
	                    }else if ($val['analyst_status'] == '8') {
	                       
	                        $status = 'Client clarification';
	                       
	                    }else if ($val['analyst_status'] == '9') {
	                       
	                        $status = 'Closed insufficiency';
	                        
	                    }else if ($val['analyst_status'] == '10'){
	                        $status = 'In Progress'; 
	                     
	                    }else if ($val['analyst_status'] == '11'){
	                        $status = 'Insuff Clear';  
	                    }

	                    array_push($analyst,$val['analyst_status']);


                      $segment ='';
                        if($val['segment'] == '1'){
                                $segment = 'Fresher' ;
                        }else if($val['segment'] == '2'){  
                                $segment = 'Mid Level' ;
                        }else if($val['segment'] == '3'){  
                                $segment = 'Senior Level' ;
                              
                        }

                        $priority ='';
                        if($val['priority'] == '0') {
                            $priority = 'Low priority' ;
                        } else if($val['priority'] == '1') {
                            $priority = 'Medium priority';
                        } else if($val['priority'] == '2') {
                            $priority = 'High priority';
                        }

                        $report ='No';
                        if($value['is_report_generated'] == '1') {
                            $report = 'Yes' ;
                        }  


                        $final_status = '';
	    							if ($val['is_submitted'] == '0') {
	                         
	                        $final_status = 'Pending'; 
	                    }else if ($val['is_submitted'] == '1') {
	                         
	                        $final_status = 'In Progress'; 
	                    }else if ($val['is_submitted'] == '2') {
	                         
	                        $final_status = 'Verified Clear';
	                        
	                    }else if ($val['is_submitted']== '3') {
	                         
	                        $final_status = 'Insufficiency';
	                        
	                    }else if ($val['is_submitted'] == '4') {
	                       
	                        $final_status = 'Verified Clear';
	                        
	                    }

					 
					if (!array_key_exists($val['candidate_id'], $candidate_data)) {
					$candidate_data[$val['candidate_id']] = array( 
					'candidate_id' => $val['candidate_id'],
					'candidate_name' => $val['first_name'].' '.$val['last_name'],
					'father_name' => $val['father_name'],
					'employee_id' => $val['employee_id'],
					'phone_number' => $val['phone_number'],
					'component_id' => $val['component_id'],
					'email_id' => $val['email_id'],
					'date_of_birth' => $val['date_of_birth'],
					'client_name' => $val['client_name'],
					'spoc_name' => $val['spoc_name'],
					'location' => $val['location'],
					'segment' => $segment,
					'priority' => $priority,  
					'analyst_status' => $final_status,
					'report_generated' => $report,
					'open_component' => array(),
					'insuff_component' => array(),
					'init_date' => $this->utilModel->get_date_formate($value['created_date']),
					'created_date' => $this->utilModel->get_date_formate($val['case_submitted_date']),
					'updated_date' => $this->utilModel->get_date_formate($val['report_generated_date']),
					'TAT' => $val['left_tat_days'],
					$val['component_name'].' '.$val['formNumber']=>array( 
						'analyst_status' => $status,
						'init_date'=>$this->utilModel->get_date_formate($val['created_date']),
						'close_date'=>$this->utilModel->get_date_formate($val['case_submitted_date']),
						'insuff_created_date'=>$this->utilModel->get_date_formate($val['insuff_created_date']),
						'insuff_close_date'=>$this->utilModel->get_date_formate($val['insuff_close_date']),
						'formNumber'=>$val['formNumber'], 
						'insuff_remarks'=>$val['insuff_remarks'], 
					)
					);

					$client = $val['client_name'];
					$client_id = $val['client_id'];
					}else{
					$candidate_data[$val['candidate_id']][$val['component_name'].' '.$val['formNumber']] = array( 
						'analyst_status' => $status,
						'init_date'=>$this->utilModel->get_date_formate($val['created_date']),
						'close_date'=>$this->utilModel->get_date_formate($val['case_submitted_date']),
						'insuff_created_date'=>$this->utilModel->get_date_formate($val['insuff_created_date']),
						'insuff_close_date'=>$this->utilModel->get_date_formate($val['insuff_close_date']),
						'formNumber'=>$val['formNumber'], 
						'insuff_remarks'=>$val['insuff_remarks'],
					); 
					}
					$comp ='';
					if (in_array($val['analyst_status'],[0,1])) {
						$comp = $val['component_name'];
					$candidate_data[$val['candidate_id']]['open_component'] = array_merge($candidate_data[$val['candidate_id']]['open_component'],array($val['component_name']));
					}
					$compInsuff = '';
					if (in_array($val['analyst_status'],[3])) {
						$compInsuff = $val['component_name'];
					$candidate_data[$val['candidate_id']]['insuff_component'] = array_merge($candidate_data[$val['candidate_id']]['insuff_component'],array($compInsuff));
					}

					if (!array_key_exists($val['component_name'].' '.$val['formNumber'], $data_array)) {
					$data_array[$val['component_name'].' '.$val['formNumber']] = array($status);
					}else{
					$data_array[$val['component_name'].' '.$val['formNumber']] = array_merge($data_array[$val['component_name'].' '.$val['formNumber']],array($status));
					}


				}


				 

                     $verifiy_img = 'In Progress'; 
                     $verifiy_status = 'In Progress'; 

                     if (in_array('0', $analyst)) {
                         $verifiy_img = 'Not Initiated';
                         $verifiy_status = 'Not Initiated';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('1', $analyst)){
                         $verifiy_img = 'In Progress';
                         $verifiy_status = 'In Progress';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('8', $analyst)){
                         $verifiy_img = 'Client Clarification';
                         $verifiy_status = 'Client Clarification';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        } 
                     }else if(in_array('3', $analyst)){
                        $verifiy_img = "Insufficiency";  
                        $verifiy_status = "Insufficiency";  
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('11', $analyst)){
                        $verifiy_img = "Insuff Clear";  
                        $verifiy_status = "Insuff Clear";  
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }/*else if($input_status ==1 && $value['is_submitted'] =='1'){
                        $verifiy_img = "Form Filled";  
                        $verifiy_status = "Form Filled";  
                     }*/else if (in_array('7', $analyst)) {

                        $verifiy_img = "Verified Discrepancy"; 
                        $verifiy_status = "Verified Discrepancy"; 
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    }else if(array_intersect(['6','9'], $analyst)){
                         if (in_array('6',$analyst)) {
                            $verifiy_img = "Unable to Verify"; 
                            $verifiy_status = "Unable to Verify"; 
                        }else if (in_array('9',$analyst)) { 
                         $verifiy_img = "Closed insufficiency"; 
                         $verifiy_status = "Closed insufficiency"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                        }else{
                           $verifiy_img = "Unable to Verify"; 
                           $verifiy_status = "Unable to Verify"; 
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                        } 

                    }/*else if(array_intersect(['1','0','10','5','11'], $analyst)){

                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                           $verifiy_status = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                           $verifiy_status = "Not Initiated";
                        }else if($value['is_submitted'] =='2' && $value['is_report_generated'] =='1'){
                             $verifiy_img = "Verified Clear";
                             $verifiy_status = "Verified Clear";
                        }

                    }else if(in_array('5', $analyst)){
                        $verifiy_img = "Stop Check"; 
                    }else if(in_array('8', $analyst)){
                         $verifiy_img = 'Client Clarification'; 
                    }else if(in_array('11', $analyst)){
                        $verifiy_img = "Insuff Clear"; 
                    }else if(in_array('10', $analyst)){
                        $verifiy_img = "Qc Error"; 
                    }*/else if(in_array('4', $analyst)){ 
                        if ($value['is_submitted'] =='2') { 
                        $verifiy_img = "Verified Clear"; 
                        $verifiy_status = "Verified Clear"; 
                        }else if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress"; 
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated"; 
                        }
                    } else if(in_array('5', $analyst)){
                        $verifiy_img = "Stop Check"; 
                        $verifiy_status = "Stop Check"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    }else if(in_array('10', $analyst)){
                        $verifiy_img = "Qc Error"; 
                        $verifiy_status = "Qc Error"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    } 

                
   

                    // array_push($analyst_data,$verifiy_img);
                    // $analyst =[];
                    // $analyst_data[$value['candidate_id']] = implode(',',$analyst);
                    $analyst_data[$value['candidate_id']] = $verifiy_img; 
 
			} 

			} 





	 		// create file name
	        $fileName = 'candidate-component-report-'.time().'.xlsx';   
	        $objPHPExcel = new Spreadsheet();
	        $al = count($data_array)+9;
	       

			$num = 0;
	        // set Header
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Sr. No'); 
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Case Start Date');
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Case Submit Date');
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Case ID');
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Candidate Name');
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Father Name'); 
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'DOB');
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Employee Id'); 
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Candidate E-mail'); 
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Candidate Contact Number'); 
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Candidate Alt Contact'); 
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Client Name');  
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'End Client Name / Segment');  
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Client SPOC Name');  
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Location');  
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Case priority');  
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Open Component');  
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Insuff Component');  
	        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'TAT');  
	        	$key_array = array();
	        if (count($data_array)) { 
                foreach ($data_array as $key => $value) {
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', $key);
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Initiated date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Closed date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Component status'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Insuff raised date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Insuff closed date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Insuff Remarks'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'No of forms');  
                   array_push($key_array,$key);
    			// $num++;
                }
	        }
	         $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Final Case status');  
	         $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Case closure date');     
	         $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Report Generated or not');  
	         $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Case Reopend date');  
	         $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] .'1', 'Reopend case closed date');  
	         $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num] .'1', 'Re-opened component');  
	        							

			$objPHPExcel->getActiveSheet()
                ->getStyle('A1:'.$alphabet[$num].'1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
            $objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphabet[$num].'1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()
					    ->getStyle('A1:'.$alphabet[$num].'1')
					    ->getFill()
					    ->setFillType(Fill::FILL_SOLID)
					    ->getStartColor()
					    ->setARGB('D3D3D3');

			$rowCount = 2; 
	        // if (false) {  
	        if (count($candidate_data) > 0) {  
                $init = 0;
                    foreach ($candidate_data as $k => $val) {

                    	  $ana_status = isset($analyst_data[$val['candidate_id']])?$analyst_data[$val['candidate_id']]:'';
                        $objPHPExcel->getActiveSheet()
                        ->getStyle('A'.$rowCount.':'.$alphabet[$num].$rowCount)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_MEDIUM)
                        ->getColor()
                        ->setRGB('000000');
                        $created_date ="-";   
                        $updated_date ="-";
                        $init_date ='';   
                         if ($val['init_date'] !='' && $val['init_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle('B'.$rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);    
                            $init_date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['init_date']);  
                            
                        }    

                        if ($val['created_date'] !='' && $val['created_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle('C'.$rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $created_date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['created_date']);  
                            
                        }       
                        // $created_date = $val['created_date'];

                        $num = 0;
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, (++$init));   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $init_date);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $created_date);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_id']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_name']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['father_name']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['date_of_birth']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['employee_id']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['email_id']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['phone_number']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_name']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['segment']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['spoc_name']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['location']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['priority']);   
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $this->get_array($val['open_component'])); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $this->get_array($val['insuff_component']));   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['TAT']);   
                      
						$start = 10; 
                        foreach ($key_array as $key => $value) { 
                            $init_date = isset($val[$value]['init_date'])?$val[$value]['init_date']:'-';
                            $close_date = isset($val[$value]['close_date'])?$val[$value]['close_date']: '-';
                            $insuff_created_date = isset($val[$value]['insuff_created_date'])?$val[$value]['insuff_created_date']:'-';
                            $insuff_close_date = isset($val[$value]['insuff_close_date'])?$val[$value]['insuff_close_date']:'-';
                            $insuff_remarks = isset($val[$value]['insuff_remarks'])?$val[$value]['insuff_remarks']:'-';
                             
                            $fields_id2 = isset($val[$value]['analyst_status'])?$val[$value]['analyst_status']:' ';  

                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $fields_id2);

                            $fields_id4 = isset($insuff_close_date)?$insuff_close_date:' ';
                            $fields_id5 = isset($val[$value]['formNumber'])?$val[$value]['formNumber']:' '; 
 
                             
                            if ($init_date !='' && $init_date !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount) // colunm name b,c,u,v,x,y
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                if ($init_date !='-') {
                                    $init_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($init_date);
                                    $init_date_cell = $this->is_positiv_status($init_date_cell,$fields_id2);   
                                }else{
                                    $init_date_cell = '';
                                }                        
                            }else{
                                $init_date_cell = '';
                            }  

                           
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $init_date_cell);
                            
                            if ($close_date !='' && $close_date !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount) // colunm name b,c,u,v,x,y
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                if ($close_date !='-') {
                                    $close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($close_date);  
                                    $close_date_cell = $this->is_nagative_status($close_date_cell,$fields_id2);
                                }else{
                                    $close_date_cell = '';
                                }                                 
                            }else{
                                $close_date_cell = '';
                            } 
                            // if (! in_array(strtolower($fields_id2),['verified clear','verified discrepancy','insufficiency','stop check'])) {
                            //     $close_date_cell ='';
                            // }
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $close_date_cell);
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $fields_id2);
                            if ($insuff_created_date !='' && $insuff_created_date !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount) // colunm name b,c,u,v,x,y
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                if ($insuff_created_date !='-') {
                                    $insuff_created_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($insuff_created_date);  
                                }else{
                                    $insuff_created_date_cell = '';
                                }                                 
                            }else{
                                $insuff_created_date_cell = '';
                            }
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $insuff_created_date_cell);
                            
                            if ($insuff_close_date !='' && $insuff_close_date !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount) // colunm name b,c,u,v,x,y
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                if ($insuff_close_date !='-') {
                                    $insuff_close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($insuff_close_date);  
                                }else{
                                    $insuff_close_date_cell = '';
                                }                                 
                            }else{
                                $insuff_close_date_cell = '';
                            }
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $insuff_close_date_cell);
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $insuff_remarks); 
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $fields_id5); 
                             
                        }

                         $color_code = '62c4ff';
                        if ($ana_status == 'In Progress') {
                            // code...
                        }
                        if ($ana_status == 'Not Initiated') {
                            // code...
                        }
                        if ($ana_status == 'Verified Discrepancy') {
                          $color_code = 'ec0000';
                        }
                        if ($ana_status == 'Closed insufficiency') {
                           $color_code = 'FFD4AE';
                        }
                        if ($ana_status == 'Unable to Verify') {
                          $color_code = 'FFD4AE';
                        }
                        if ($ana_status == 'Insufficiency') {
                            // code...
                        }
                        if ($ana_status == 'Verified Clear') {
                           $color_code = 'C5FCB4';
                        }
                        if ($ana_status == 'Client Clarification') {
                            // code...
                        }
                        if ($ana_status == 'Qc Error') {
                           $color_code = 'ec0000';
                        }
                        if ($ana_status == 'Stop Check') {
                           $color_code = '62c4ff';
                        }
                         $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num].$rowCount) 
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB($color_code);  
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $ana_status); 

                        if ($val['updated_date'] !='' && $val['updated_date'] !='-' && strtolower($val['updated_date']) !='na') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount) // colunm name b,c,u,v,x,y
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            if ($val['updated_date'] !='-') {
                                $updated_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['updated_date']);  
                            }else{
                                $updated_date_cell = '';
                            }                                 
                        }else{
                            $updated_date_cell = '';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $updated_date_cell); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['report_generated']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num] . $rowCount, '-');  
                     
                        $rowCount++;
                     }
                    
                  }
                //   exit;
                  echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
                						
	        $objWriter = new Xlsx($objPHPExcel);
	        $objWriter->save('../uploads/report/'.$fileName);
 
	   

	} 

    function is_nagative_status($date,$status){
        if (! in_array(strtolower($status),['verified clear','verified discrepancy','insufficiency','stop check'])) {
            $date_new ='';
        }else{
            $date_new = $date;
        }
        return $date_new;
    }

    function is_positiv_status($date,$status){
        if (in_array(strtolower($status),['in progress','verified clear','verified discrepancy','insufficiency','stop check'])) {
           
            $date_new = $date;
        }else{
            $date_new ='';
        }
        return $date_new;
    }



    function daily_report_insuff(){
        $alphabet = $this->utilModel->return_excel_val(); 
 	    $client = $this->session->userdata('logged-in-client');
 	    $user = $this->session->userdata('logged-in-client');
		$client_ids = array();
		if ($this->input->post('client') == '0') {
			$data = $this->get_all_clients(); 
			array_push($client_ids,$data['parent']['client_id']);
			if (count($data['child']) > 0) {
				foreach ($data['child'] as $key => $value) {
					array_push($client_ids,$value['client_id']);
				}
			}
		}else{
			array_push($client_ids,$this->input->post('client'));
		}

 		
        $i=1;
        $clinet_id_array = array();

		$q = implode(',', $client_ids);
		 if ($user !='' && $user !=null && count($client_ids)==0) {
		 	$q1 = $user['client_id'];
		 }else{ 
		    $q1 = isset($q)?$q:$user['client_id'];
		 } 

		if ($q1 == 0 || $q1 ==null || $q1 == '' || $q1 == 'null') {
			$q1 = $user['client_id'];
		}

	

		 // $where ='client_id IN ( '.$q1.' ) '; 
        $where ='';
		$clients ='client_id IN ( '.$q1.' ) ';
        if ($this->input->post('duration') == 'today') {
          $where=" where   date(created_date) = CURDATE() AND ".$clients;
        }else if($this->input->post('duration') == 'week'){
          $where="  where  date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()  AND ".$clients;
        }else if($this->input->post('duration') == 'month'){
          $where=" where   date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()  AND ".$clients;
        }else if($this->input->post('duration') == 'year'){
          $where="  where  date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()  AND ".$clients;
        }else if($this->input->post('duration') == 'between'){
          $where=" where   date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'  AND ".$clients;
        }else{
            $where=' where '.$clients;
        }

        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
            $all_cases = array();

            foreach ($data as $key => $value) { 
                $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']); 
                 foreach ($cases as $k => $val) {
                 	$insuff = 1;  
                           
                                if ($val['analyst_status']== '3') {
                                    array_push($all_cases, $val);
                                }
                               
                      
                 }
            }


          
            $num = 0;
            // create file name
            $fileName = 'component-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            
            // set Header
            $objPHPExcel->getActiveSheet()
                ->getStyle('A1:X1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
            $objPHPExcel->getActiveSheet()->getStyle('A1:X1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'SL No');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Start Date');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case ID');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Father Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'DOB');       
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Employee Id');     
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Email Id');     
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Contact Number');     
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Name');     
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Insuff Status');     
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff Cleared By');     
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'CSM Name');     
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Remarks');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Segment');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client SPOC Name');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Location');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Open Insuff Components');  

            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Check Type');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff Property');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff Raised Date');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff Closed Date');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff Remarks');       
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num].'1', 'Analyst / Specialist');  
            // $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Insuff Raised');       
            /*$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Insuff Closed');         
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Insuff Status');     
            $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Case Status'); */    
      
            
 
            // set Row
            $rowCount = 2;
            $i =1;
            foreach ($all_cases as $key => $value) {
 			    $num = 0;
      

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
                       
                        $status = 'Closed insufficiency';
                        
                    }else if ($value['analyst_status'] == '10'){
                        $status = 'In Progress'; 
                     
                    }else if ($value['analyst_status'] == '11'){
                        $status = 'Insuff Clear';  
                    }
               
                $inputQcStatus = '';
                if ($value['status'] == '0') {
                         
                    $inputQcStatus = 'Not Initiated';
                        
                }else if ($value['status'] == '1') {
                         
                    $inputQcStatus = 'Not Initiated';
                         
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
                       
                    $inputQcStatus = 'Closed insufficiency';
                        
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

            $segment ='';
                            if($value['segment'] == '1'){
                                    $segment = 'Fresher' ;
                            }else if($value['segment'] == '2'){  
                                    $segment = 'Mid Level' ;
                            }else if($value['segment'] == '3'){  
                                    $segment = 'Senior Level' ;
                                  
                            }
         
                $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':X'.$rowCount)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000'); 
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $i++);
                $case_submitted_date ="-"; 
                if ($value['case_submitted_date'] !='' && $value['case_submitted_date'] !='-') {
                    $objPHPExcel->getActiveSheet()
                    ->getStyle($alphabet[$num] . $rowCount)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                    $case_submitted_date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($this->utilModel->get_date_formate($value['case_submitted_date']));  
                    
                }  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $case_submitted_date);
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['candidate_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['candidate_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['father_name']);
                if ($value['date_of_birth'] !='' && $value['date_of_birth'] !='-') {
                    $objPHPExcel->getActiveSheet()
                    ->getStyle($alphabet[$num] . $rowCount)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                    $date_of_birth = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($value['date_of_birth']);  
                    
                }else{
                    $date_of_birth = '-';
                }
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $date_of_birth);    
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['employee_id']);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['email_id']);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['phone_number']);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['client_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $is_submitted);   
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['inputq']);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['csm']);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['remark']);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $segment);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['spoc_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['location']);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['component_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['component_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');  

                if ($value['insuff_created_date'] !='' && $value['insuff_created_date'] !='-') {
                    $objPHPExcel->getActiveSheet()
                    ->getStyle($alphabet[$num] . $rowCount)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                    $insuff_created_date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($value['insuff_created_date']);  
                    
                }else{
                    $insuff_created_date = '-';
                }
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $insuff_created_date);
                if ($value['insuff_close_date'] !='' && $value['insuff_close_date'] !='-') {
                    $objPHPExcel->getActiveSheet()
                    ->getStyle($alphabet[$num] . $rowCount)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                    $insuff_close_date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($value['insuff_close_date']);  
                    
                }else{
                    $insuff_close_date = '-';
                }
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $insuff_close_date);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['insuff_remarks']);  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['assigned_team_name']);   
 

                $rowCount++;

            }
              
     
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
            // download file
            // header("Content-Type: application/vnd.ms-excel");
            // redirect(base_url().'uploads/report/'.$fileName);  

            echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));

    } 


    function daily_report_insuff_clear(){
      
 	$client = $this->session->userdata('logged-in-client');
 	$user = $this->session->userdata('logged-in-client');
		$client_ids = array();
		if ($this->input->post('client') == '0') {
			$data = $this->get_all_clients(); 
			array_push($client_ids,$data['parent']['client_id']);
			if (count($data['child']) > 0) {
				foreach ($data['child'] as $key => $value) {
					array_push($client_ids,$value['client_id']);
				}
			}
		}else{
			array_push($client_ids,$this->input->post('client'));
		}

 		
			$i=1;
			$clinet_id_array = array();

			 $q = implode(',', $client_ids);
		 if ($user !='' && $user !=null && count($client_ids)==0) {
		 	$q1 = $user['client_id'];
		 }else{ 
		    $q1 = isset($q)?$q:$user['client_id'];
		 } 

		if ($q1 == 0 || $q1 ==null || $q1 == '' || $q1 == 'null') {
			$q1 = $user['client_id'];
		}

	

		 // $where ='client_id IN ( '.$q1.' ) '; 
        $where ='';
		$clients ='client_id IN ( '.$q1.' ) ';
        if ($this->input->post('duration') == 'today') {
          $where="where  date(created_date) = CURDATE() AND ".$clients;
        }else if($this->input->post('duration') == 'week'){
          $where="where  date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()  AND ".$clients;
        }else if($this->input->post('duration') == 'month'){
          $where="where  date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()  AND ".$clients;
        }else if($this->input->post('duration') == 'year'){
          $where="where  date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()  AND ".$clients;
        }else if($this->input->post('duration') == 'between'){
          $where="where  date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'  AND ".$clients;
        }else{
            $where='where '.$clients;
        }

        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
            $all_cases = array();

            foreach ($data as $key => $value) { 
                $cases = $this->caseModel->getSingleAssignedCaseDetail_s($value['candidate_id']); 
                 foreach ($cases as $k => $val) { 
                     if ($val['analyst_status']== '9' || $val['analyst_status']== '11') {
                                array_push($all_cases, $val);
                     }
    
                 }
            }


          
            
            // create file name
            $fileName = 'component-clear-insuff-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            
            // set Header
            $objPHPExcel->getActiveSheet()
                ->getStyle('A1:I1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Start Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case ID');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Client Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'First Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Last Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Employee Id');     
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Submitted Data');  

            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Component Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Remark Verification');         
            

            // set Row
            $rowCount = 2;
            $i =1;
 
            foreach ($all_cases as $key => $value) {
      

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
                       
                        $status = 'Closed insufficiency';
                        
                    }else if ($value['analyst_status'] == '10'){
                        $status = 'In Progress'; 
                     
                    }else if ($value['analyst_status'] == '11'){
                        $status = 'Insuff Clear';  
                    }
               
                $inputQcStatus = '';
                if ($value['status'] == '0') {
                         
                    $inputQcStatus = 'Not Initiated';
                        
                }else if ($value['status'] == '1') {
                         
                    $inputQcStatus = 'Not Initiated';
                         
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
                       
                    $inputQcStatus = 'Closed insufficiency';
                        
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

         
                $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':I'.$rowCount)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i++);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value['candidate_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value['client_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value['first_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['last_name']);    
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value['employee_id']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $this->utilModel->get_date_formate($value['report_generated_date'])); 
                // $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'none'); 
                // $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'none'); 
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value['component_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value['verification_remarks']); 
                /*$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $this->date_convert($value['insuff_created_date'])); 
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $this->date_convert($value['insuff_close_date'])); 
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $status); 
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $is_submitted);*/ 
 

                $rowCount++;

            }
              
     
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
            // download file
            // header("Content-Type: application/vnd.ms-excel");
            // redirect(base_url().'uploads/report/'.$fileName);  

            echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));

    } 





    function daily_report_error_logs(){ 
 	$client = $this->session->userdata('logged-in-client'); 
 	$user = $this->session->userdata('logged-in-client');
        $where ='';
        if ($this->input->post('duration') == 'today') {
          $where=" where date(created_date) = CURDATE() AND client_id=".$client['client_id'];
        }else if($this->input->post('duration') == 'week'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()  AND client_id=".$client['client_id'];
        }else if($this->input->post('duration') == 'month'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()  AND client_id=".$client['client_id'];
        }else if($this->input->post('duration') == 'year'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()  AND client_id=".$client['client_id'];
        }else if($this->input->post('duration') == 'between'){
          $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'  AND client_id=".$client['client_id'];
        }else{
            $where=" where client_id=".$client['client_id'];
        }

        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
            $all_cases = array();

            foreach ($data as $key => $value) { 
                $cases = $this->caseModel->getSingleAssignedCaseDetail_s($value['candidate_id']); 
                 foreach ($cases as $k => $val) { 
                     if ($val['analyst_status']== '9') {
                                array_push($all_cases, $val);
                     }
    
                 }
            }


          
            
            // create file name
            $fileName = 'component-clear-insuff-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            
            // set Header
                 $objPHPExcel->getActiveSheet()
                ->getStyle('A1:I1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Start Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case ID');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Client Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'First Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Last Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Employee Id');     
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Submitted Data');  

            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Component Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Remark Verification');         
            

            // set Row
            $rowCount = 2;
            $i =1;
 
            foreach ($all_cases as $key => $value) {
      

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
                       
                        $status = 'Closed insufficiency';
                        
                    }else if ($value['analyst_status'] == '10'){
                        $status = 'In Progress'; 
                     
                    }else if ($value['analyst_status'] == '11'){
                        $status = 'Insuff Clear';  
                    }
               
                $inputQcStatus = '';
                if ($value['status'] == '0') {
                         
                    $inputQcStatus = 'Not Initiated';
                        
                }else if ($value['status'] == '1') {
                         
                    $inputQcStatus = 'Not Initiated';
                         
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
                       
                    $inputQcStatus = 'Closed insufficiency';
                        
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

         
             $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':I'.$rowCount)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');    
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i++);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value['candidate_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value['client_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value['first_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['last_name']);    
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value['employee_id']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $this->utilModel->get_date_formate($value['report_generated_date']));  
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value['component_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value['verification_remarks']); 
               

                $rowCount++;

            }
              
     
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
            // download file
            // header("Content-Type: application/vnd.ms-excel");
            // redirect(base_url().'uploads/report/'.$fileName);  

            echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));

    } 

}