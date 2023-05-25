<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
class Dump_Component extends CI_Controller {
	
	function __construct()  
	{
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url');   
	  $this->load->model('adminViewAllCaseModel');
      $this->load->model('utilModel');
      $this->load->model('common_User_Filled_Details_Component_Error_Model');
      $this->load->model('admin_Analytics_Model');
      $this->load->model('inputQcModel');
	  $this->load->model('load_Database_Model');
	}	

	function index() {
		die("something wen't wrong."); 
	}


    function date_convert($date) {
        $d = 'NA';
        if ($date != '' && $date != null && $date != '-') { 
            $d = date('d-m-Y', strtotime($date));
        }
        return $d;
    }
 
	function daily_report() {
        $alphabet = $this->utilModel->return_excel_val(); 
        $where = '';
        if ($this->input->post('duration') == 'today') {
            $where = " where date(created_date) = CURDATE()";
        } else if($this->input->post('duration') == 'week') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('duration') == 'month') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('duration') == 'year') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('duration') == 'between') {
            $where = " where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }
        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
        $CaseList = array();
        $component_names = array();
                    $case_data =array();
                    $boday_message = "";
                    $component_name = array();
                    $data_array = array();
                     $candidate_data = array();
                     $analyst_data = array();
 		foreach ($data as $key => $value) {


            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']);
 			 
             $analyst = array();
                // $case_array = array();
                foreach ($cases as $k => $val) { 
                      
                        $status = '';
                            if ($val['analyst_status'] == '0') {
                             
                            $status = 'Not initiated'; 
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
                           
                            $status = 'Close Insufficient';
                            
                        }else if ($val['analyst_status'] == '10'){
                            $status = 'QC Error'; 
                         
                        }else if ($val['analyst_status'] == '11'){
                            $status = 'Insuff Clear';  
                        }




                    array_push($analyst,$val['analyst_status']);
                    if (!array_key_exists($val['candidate_id'], $candidate_data)) {
                    $candidate_data[$val['candidate_id']] = array( 
                    'candidate_id' => $val['candidate_id'],
                    'candidate_name' => $val['first_name'].' '.$val['last_name'],
                    'father_name' => $val['father_name'],
                    'employee_id' => $val['employee_id'],
                    'date_of_birth' => $val['date_of_birth'],
                    'client_name' => $val['client_name'],
                    'analyst_status' => $status,
                    'created_date' => $this->utilModel->get_actual_date_formate($val['created_date']),
                    'updated_date' => $this->utilModel->get_actual_date_formate($val['updated_date']),
                    'TAT' => $val['left_tat_days'],
                    $val['component_name'].' '.$val['formNumber']=>$status
                    );

                    $client = $val['client_name'];
                    $client_id = $val['client_id'];
                    }else{
                    $candidate_data[$val['candidate_id']][$val['component_name'].' '.$val['formNumber']] = $status; 
                    }
                    if (!array_key_exists($val['component_name'].' '.$val['formNumber'], $data_array)) {
                    $data_array[$val['component_name'].' '.$val['formNumber']] = array($status);
                    }else{
                    $data_array[$val['component_name'].' '.$val['formNumber']] = array_merge($data_array[$val['component_name'].' '.$val['formNumber']],array($status));
                    }


                }



                 $string_status = 'Verified Clear';
                   if (in_array('0', $analyst)) {  
                        $string_status = 'Verified Pending'; 
                    }else if (in_array('1', $analyst)) { 
                        $string_status = 'Verified Pending'; 
                    }else if (in_array('2', $analyst)) { 
                            $string_status = 'Verified Clear'; 
                    }else if (in_array('3', $analyst)) { 
                            $string_status = 'Insufficiency'; 
                    }else if (in_array('4', $analyst)) { 
                        $string_status = 'Verified Clear'; 
                    }else if (in_array('5', $analyst)) { 
                            $string_status = 'Stop Check'; 
                    }else if (in_array('6', $analyst)) { 
                            $string_status = 'Unable to Verify'; 
                    }else if (in_array('7', $analyst)) { 
                            $string_status = 'Verified Discrepancy'; 
                        
                    }else if (in_array('8', $analyst)) { 
                            $string_status = 'Client Clarification'; 
                    }else if (in_array('9', $analyst)) { 
                        $string_status = 'Closed insufficiency'; 
                         

                    }else if (in_array('10', $analyst)) { 
                        $string_status = 'QC-error';  
                          
                    }

                    array_push($analyst_data,$string_status);
 		}



            // create file name
            $fileName = 'candidate-component-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            $al = count($data_array)+9;
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A1:'.$alphabet[$al].'1')
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('D3D3D3');
            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'subdate');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'caseid');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Candidate');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'EmployeeID');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Father Name');
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'DOB');
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Client'); 
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Case Start Date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Case End Date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Total TAT Days'); 
            $num = 10;
                $key_array = array();
            if (count($data_array)) { 
                foreach ($data_array as $key => $value) {
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num].'1', $key);
                   array_push($key_array,$key);
                $num++;
                }
            }
            $objPHPExcel->getActiveSheet()
                ->getStyle('A1:'.$alphabet[$num].'1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
            $objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphabet[$num].'1')->getFont()->setBold(true);


            $rowCount = 2; 
            if (count($candidate_data) > 0) {  
                     $init = 0;
                     foreach ($candidate_data as $k => $val) {
                        $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':'.$alphabet[$num].$rowCount)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000'); 
                       $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $val['created_date']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $val['candidate_id']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $val['candidate_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $val['employee_id']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $val['father_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $val['date_of_birth']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $val['client_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $val['created_date']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $val['updated_date']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $val['TAT']); 
                      
                        $start = 10; 
                        foreach ($key_array as $key => $value) { 

                                $objPHPExcel->getActiveSheet()
                                ->getStyle('A'.$rowCount.':'.$alphabet[$start].$rowCount)
                                ->getBorders()
                                ->getAllBorders()
                                ->setBorderStyle(Border::BORDER_MEDIUM)
                                ->getColor()
                                ->setRGB('000000'); 

                           $fields_id = isset($val[$value])?$val[$value]:' ';
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$start] . $rowCount, $fields_id);
                            $start++;  
                        }
                       /* if (count($count) > 0) { 
                            foreach ($count as $c => $cvalue) {
                              $str = str_replace(' ','_',$cvalue);
                              $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$start] . $rowCount, ' ');
                                $start++;    
                               }   
                         
                        }*/

                       
                        $rowCount++;
                     }
                    
                  }

                  echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
                                    
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);

 
	} 

    /// for the employment
    function daily_report_employment() {
        $where ='';
        if ($this->input->post('duration') == 'today') {
            $where = " where date(created_date) = CURDATE()";
        } else if($this->input->post('duration') == 'week') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('duration') == 'month') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('duration') == 'year') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('duration') == 'between') {
            $where = " where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        } else {
            $where = "";
        }
        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
        $all_cases = array();
        foreach ($data as $key => $value) {
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']);
            foreach ($cases as $k => $val) {
                if (in_array($val['component_id'],array('6','10'))) {
                    array_push($all_cases, $val);
                }
            }
        }
 
        // create file name
        $fileName = 'component-report-'.time().'.xlsx';   
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:AH1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor() 
                    ->setARGB('D3D3D3');
            
        // set Header
        $objPHPExcel->getActiveSheet()
                ->getStyle('A1:AH1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('A1:AH1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr.no.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case Id');
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
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Case Assigned to InputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Case Verified by InputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Days Taken by InputQC');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Case Assigned to Analyst/Specialist Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Case Verified by Analyst/Specialist Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Days Taken by Analyst/Specialist');
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Case Assigned to OutputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Case Verified by OutputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Days Taken by OutputQC');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Component Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Forms');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Component Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Output Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Assigned Role');
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Assigned to Analyst/Specialist');
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Case Start Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Insuff Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Verification Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Insuff Closure Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Progress Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Insuff Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'Insuff Close Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'Panel');
        $objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'Vendor');
        // set Row
        $rowCount = 2;
        $i = 1;

        foreach ($all_cases as $key => $value) {
            $is_submitted = '';
            if ($value['is_submitted'] == '0') {
                $is_submitted = 'Not initiated';
            } else if ($value['is_submitted'] == '1') {
                $is_submitted = 'In Progress';
            } else if ($value['is_submitted'] == '2') {
                $is_submitted = 'Verified Clear';
            } else if ($value['is_submitted'] == '3') {
                $is_submitted = 'Insuff';
            } else {
                $is_submitted = 'Not initiated';
            }

            $status = '';
            if ($value['analyst_status'] == '0') {
                $status = 'Not initiated'; 
            } else if ($value['analyst_status'] == '1') {           
                $status = 'In Progress'; 
            } else if ($value['analyst_status'] == '2') {
                $status = 'Completed';
            } else if ($value['analyst_status']== '3') {
                $status = 'Insufficiency';
            } else if ($value['analyst_status'] == '4') {
                $status = 'Verified Clear';
            } else if ($value['analyst_status'] == '5') {
                $status = 'Stop Check';
            } else if ($value['analyst_status'] == '6') {
                $status = 'Unable to verify';
            } else if ($value['analyst_status'] == '7') {
                $status = 'Verified discrepancy';
            } else if ($value['analyst_status'] == '8') {
                $status = 'Client clarification';
            } else if ($value['analyst_status'] == '9') {
                $status = 'Close Insufficient';
            } else if ($value['analyst_status'] == '10') {
                $status = 'QC Error'; 
            } else if ($value['analyst_status'] == '11') {
                $status = 'Insuff Clear';  
            }
               
            $inputQcStatus = '';
            if ($value['status'] == '0') {
                $inputQcStatus = 'Not initiated';
            } else if ($value['status'] == '1') {
                $inputQcStatus = 'In Progress';
            } else if ($value['status'] == '2') {
                $inputQcStatus = 'Completed';
            } else if ($value['status']== '3') {
                $inputQcStatus = 'Insufficiency';
            } else if ($value['status'] == '4') {
                $inputQcStatus = 'Verified Clear';
            } else if ($value['status'] == '5') {
                $inputQcStatus = 'Stop Check';
            } else if ($value['status'] == '6') {
                $inputQcStatus = 'Unable to verify';
            } else if ($value['status'] == '7') {
                $inputQcStatus = 'Verified discrepancy';
            } else if ($value['status'] == '8') {
                $inputQcStatus = 'Client clarification';
            } else if ($value['status'] == '9') {
                $inputQcStatus = 'Close Insufficient';
            }
                 
            $outPutQCStatus = '';
            if ( $value['output_status'] == '0') {
                $outPutQCStatus = 'Not initiated';
            } else if ($value['output_status'] == '1') {
                $outPutQCStatus = 'Approved';
            } else if ($value['output_status'] == '2') {
                $outPutQCStatus = 'Rejected';
            } 

            $priority ='';
            if($value['priority'] == '0') {
                $priority = 'Low priority' ;
            } else if($value['priority'] == '1') {
                $priority = 'Medium priority';
            } else if($value['priority'] == '2') {
                $priority = 'High priority';
            }

            $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':AH'.$rowCount)
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
            
            $inputqc_status_date = 'NA';
            $inputqc_verification_days_taken = 'NA';
            $inputqc_status_date_time = 'NA';
            $case_submitted_date = 'NA';
            $show_inputqc_date_difference = 'NA';
            if ($value['case_submitted_date'] != '' && $value['case_submitted_date'] != 'NA') {
                $case_submitted_date = $value['case_submitted_date'];
                if ($value['inputqc_status_date'] != '' && $value['inputqc_status_date'] != 'NA') {
                    $inputqc_status_date = $value['inputqc_status_date'];
                    $case_submitted_date_time_splitted = explode(' ',$case_submitted_date)[0];
                    $inputqc_status_date_time_splitted = explode(' ',$inputqc_status_date)[0];
                    if (!$this->utilModel->check_date_format($inputqc_status_date_time_splitted,'Y-m-d')) {
                        $inputqc_status_date_splitted = explode('-',$inputqc_status_date_time_splitted);
                        $inputqc_status_date_time = $inputqc_status_date_splitted[1].'/'.$inputqc_status_date_splitted[0].'/'.$inputqc_status_date_splitted[2];
                    } else {
                        $inputqc_status_date_time = $inputqc_status_date_time_splitted;
                    }
                    $case_submitted_date_splitted = explode('-',$case_submitted_date_time_splitted);
                    $case_submitted_date_time = $case_submitted_date_splitted[1].'/'.$case_submitted_date_splitted[0].'/'.$case_submitted_date_splitted[2];
                    $inputqc_date_difference = date_diff(date_create($case_submitted_date_time),date_create($inputqc_status_date_time));
                    $show_inputqc_date_difference = $inputqc_date_difference->format("%a");
                    if ($inputqc_date_difference->format("%a") > 1) {
                        $show_inputqc_date_difference .= ' days';
                    } else {
                        $show_inputqc_date_difference .= ' day';
                    }
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $this->utilModel->get_actual_date_formate($case_submitted_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $this->utilModel->get_actual_date_formate($inputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $show_inputqc_date_difference);

            $analyst_specialist_status_date = 'NA';
            $show_analyst_specialist_verification_days_taken = 'NA';
            $analyst_status_date_time = 'NA';
            if ($inputqc_status_date_time != '' && $inputqc_status_date_time != 'NA' && $value['analyst_status_date'] != '' && $value['analyst_status_date'] != 'NA') {
                $analyst_specialist_status_date = $value['analyst_status_date'];
                $analyst_specialist_status_date_time_splitted = explode(' ',$analyst_specialist_status_date)[0];
                if (!$this->utilModel->check_date_format($analyst_specialist_status_date_time_splitted,'Y-m-d')) {
                    $analyst_specialist_status_date_splitted = explode('-',$analyst_specialist_status_date_time_splitted);
                    $analyst_status_date_time = $analyst_specialist_status_date_splitted[1].'/'.$analyst_specialist_status_date_splitted[0].'/'.$analyst_specialist_status_date_splitted[2];
                } else {
                    $analyst_status_date_time = $analyst_specialist_status_date_time_splitted;
                }
                $analyst_specialist_date_difference = date_diff(date_create($inputqc_status_date_time),date_create($analyst_status_date_time));
                $show_analyst_specialist_verification_days_taken = $analyst_specialist_date_difference->format("%a");
                if ($analyst_specialist_date_difference->format("%a") > 1) {
                    $show_analyst_specialist_verification_days_taken .= ' days';
                } else {
                    $show_analyst_specialist_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $this->utilModel->get_actual_date_formate($inputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $analyst_specialist_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $show_analyst_specialist_verification_days_taken);

            $outputqc_status_date = 'NA';
            $show_outputqc_verification_days_taken = 'NA';
            $outputqc_status_date_time = 'NA';
            if ($analyst_specialist_status_date != '' && $analyst_specialist_status_date != 'NA' && $value['outputqc_status_date'] != '' && $value['outputqc_status_date'] != 'NA') {
                $outputqc_status_date = $value['outputqc_status_date'];
                $outputqc_status_date_time_splitted = explode(' ',$outputqc_status_date)[0];
                if (!$this->utilModel->check_date_format($outputqc_status_date_time_splitted,'Y-m-d')) {
                    $outputqc_status_date_splitted = explode('-',$outputqc_status_date_time_splitted);
                    $outputqc_status_date_time = $outputqc_status_date_splitted[1].'/'.$outputqc_status_date_splitted[0].'/'.$outputqc_status_date_splitted[2];
                } else {
                    $outputqc_status_date_time = $outputqc_status_date_time_splitted;
                }
                $outputqc_date_difference = date_diff(date_create($analyst_status_date_time),date_create($outputqc_status_date_time));
                $show_outputqc_verification_days_taken = $outputqc_date_difference->format("%a");
                if ($outputqc_date_difference->format("%a") > 1) {
                    $show_outputqc_verification_days_taken .= ' days';
                } else {
                    $show_outputqc_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $analyst_specialist_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $outputqc_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $show_outputqc_verification_days_taken);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $value['component_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $value['formNumber']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $status);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $outPutQCStatus);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $value['assigned_role']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $value['assigned_team_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $this->date_convert($value['case_submitted_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $value['insuff_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $value['verification_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $value['insuff_closure_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $value['progress_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $this->date_convert($value['insuff_created_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $this->date_convert($value['insuff_close_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $value['panel']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $value['vendor']);

            $rowCount++;
        }
             
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save('../uploads/report/'.$fileName);

        echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
    }



      function daily_report_education() {
        $where ='';
        if ($this->input->post('duration') == 'today') {
            $where=" where date(created_date) = CURDATE()";
        } else if($this->input->post('duration') == 'week') {
            $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('duration') == 'month') {
            $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('duration') == 'year') {
            $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('duration') == 'between') {
            $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        } else {
            $where="";
        }
        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();

        $all_cases = array();

        foreach ($data as $key => $value) {
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']);
            foreach ($cases as $k => $val) {
                if (in_array($val['component_id'],array('7'))) {        
                    array_push($all_cases, $val);    
                }
            }
        }
 

            
        // create file name
        $fileName = 'component-report-'.time().'.xlsx';   
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:AM1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor() 
                    ->setARGB('D3D3D3');
        
        // set Header
        $objPHPExcel->getActiveSheet()
                ->getStyle('A1:AM1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('A1:AM1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr.no.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case Id');
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
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Case Assigned to InputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Case Verified by InputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Days Taken by InputQC');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Case Assigned to Analyst/Specialist Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Case Verified by Analyst/Specialist Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Days Taken by Analyst/Specialist');
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Case Assigned to OutputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Case Verified by OutputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Days Taken by OutputQC');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Component Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Forms');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Component Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Output Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Assigned Role');
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Assigned to Analyst/Specialist');
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Case Start Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Insuff Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Verification Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Insuff Closure Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Progress Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Insuff Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'Insuff Close Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'Panel');
        $objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'Vendor');
        // set Row
        $rowCount = 2;
        $i = 1;

        foreach ($all_cases as $key => $value) {
            $is_submitted = '';
            if ($value['is_submitted'] == '0') {
                $is_submitted = 'Not initiated';
            } else if ($value['is_submitted'] == '1') {
                $is_submitted = 'In Progress';
            } else if ($value['is_submitted'] == '2') {
                $is_submitted = 'Verified Clear';
            } else if ($value['is_submitted'] == '3') {
                $is_submitted = 'Insuff';
            } else {
                $is_submitted = 'Not initiated';
            }

            $status = '';
            if ($value['analyst_status'] == '0') {
                $status = 'Not initiated'; 
            } else if ($value['analyst_status'] == '1') {           
                $status = 'In Progress'; 
            } else if ($value['analyst_status'] == '2') {
                $status = 'Completed';
            } else if ($value['analyst_status']== '3') {
                $status = 'Insufficiency';
            } else if ($value['analyst_status'] == '4') {
                $status = 'Verified Clear';
            } else if ($value['analyst_status'] == '5') {
                $status = 'Stop Check';
            } else if ($value['analyst_status'] == '6') {
                $status = 'Unable to verify';
            } else if ($value['analyst_status'] == '7') {
                $status = 'Verified discrepancy';
            } else if ($value['analyst_status'] == '8') {
                $status = 'Client clarification';
            } else if ($value['analyst_status'] == '9') {
                $status = 'Close Insufficient';
            } else if ($value['analyst_status'] == '10') {
                $status = 'QC Error'; 
            } else if ($value['analyst_status'] == '11') {
                $status = 'Insuff Clear';  
            }
               
            $inputQcStatus = '';
            if ($value['status'] == '0') {
                $inputQcStatus = 'Not initiated';
            } else if ($value['status'] == '1') {
                $inputQcStatus = 'In Progress';
            } else if ($value['status'] == '2') {
                $inputQcStatus = 'Completed';
            } else if ($value['status']== '3') {
                $inputQcStatus = 'Insufficiency';
            } else if ($value['status'] == '4') {
                $inputQcStatus = 'Verified Clear';
            } else if ($value['status'] == '5') {
                $inputQcStatus = 'Stop Check';
            } else if ($value['status'] == '6') {
                $inputQcStatus = 'Unable to verify';
            } else if ($value['status'] == '7') {
                $inputQcStatus = 'Verified discrepancy';
            } else if ($value['status'] == '8') {
                $inputQcStatus = 'Client clarification';
            } else if ($value['status'] == '9') {
                $inputQcStatus = 'Close Insufficient';
            }
                 
            $outPutQCStatus = '';
            if ( $value['output_status'] == '0') {
                $outPutQCStatus = 'Not initiated';
            } else if ($value['output_status'] == '1') {
                $outPutQCStatus = 'Approved';
            } else if ($value['output_status'] == '2') {
                $outPutQCStatus = 'Rejected';
            } 

            $priority ='';
            if($value['priority'] == '0') {
                $priority = 'Low priority' ;
            } else if($value['priority'] == '1') {
                $priority = 'Medium priority';
            } else if($value['priority'] == '2') {
                $priority = 'High priority';
            }
            $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':AM'.$rowCount)
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
            
            $inputqc_status_date = 'NA';
            $inputqc_verification_days_taken = 'NA';
            $inputqc_status_date_time = 'NA';
            $case_submitted_date = 'NA';
            $show_inputqc_date_difference = 'NA';
            if ($value['case_submitted_date'] != '' && $value['case_submitted_date'] != 'NA') {
                $case_submitted_date = $value['case_submitted_date'];
                if ($value['inputqc_status_date'] != '' && $value['inputqc_status_date'] != 'NA') {
                    $inputqc_status_date = $value['inputqc_status_date'];
                    $case_submitted_date_time_splitted = explode(' ',$case_submitted_date)[0];
                    $inputqc_status_date_time_splitted = explode(' ',$inputqc_status_date)[0];
                    if (!$this->utilModel->check_date_format($inputqc_status_date_time_splitted,'Y-m-d')) {
                        $inputqc_status_date_splitted = explode('-',$inputqc_status_date_time_splitted);
                        $inputqc_status_date_time = $inputqc_status_date_splitted[1].'/'.$inputqc_status_date_splitted[0].'/'.$inputqc_status_date_splitted[2];
                    } else {
                        $inputqc_status_date_time = $inputqc_status_date_time_splitted;
                    }
                    $case_submitted_date_splitted = explode('-',$case_submitted_date_time_splitted);
                    $case_submitted_date_time = $case_submitted_date_splitted[1].'/'.$case_submitted_date_splitted[0].'/'.$case_submitted_date_splitted[2];
                    $inputqc_date_difference = date_diff(date_create($case_submitted_date_time),date_create($inputqc_status_date_time));
                    $show_inputqc_date_difference = $inputqc_date_difference->format("%a");
                    if ($inputqc_date_difference->format("%a") > 1) {
                        $show_inputqc_date_difference .= ' days';
                    } else {
                        $show_inputqc_date_difference .= ' day';
                    }
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $this->utilModel->get_actual_date_formate($case_submitted_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $this->utilModel->get_actual_date_formate($inputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $show_inputqc_date_difference);

            $analyst_specialist_status_date = 'NA';
            $show_analyst_specialist_verification_days_taken = 'NA';
            $analyst_status_date_time = 'NA';
            if ($inputqc_status_date_time != '' && $inputqc_status_date_time != 'NA' && $value['analyst_status_date'] != '' && $value['analyst_status_date'] != 'NA') {
                $analyst_specialist_status_date = $value['analyst_status_date'];
                $analyst_specialist_status_date_time_splitted = explode(' ',$analyst_specialist_status_date)[0];
                if (!$this->utilModel->check_date_format($analyst_specialist_status_date_time_splitted,'Y-m-d')) {
                    $analyst_specialist_status_date_splitted = explode('-',$analyst_specialist_status_date_time_splitted);
                    $analyst_status_date_time = $analyst_specialist_status_date_splitted[1].'/'.$analyst_specialist_status_date_splitted[0].'/'.$analyst_specialist_status_date_splitted[2];
                } else {
                    $analyst_status_date_time = $analyst_specialist_status_date_time_splitted;
                }
                $analyst_specialist_date_difference = date_diff(date_create($inputqc_status_date_time),date_create($analyst_status_date_time));
                $show_analyst_specialist_verification_days_taken = $analyst_specialist_date_difference->format("%a");
                if ($analyst_specialist_date_difference->format("%a") > 1) {
                    $show_analyst_specialist_verification_days_taken .= ' days';
                } else {
                    $show_analyst_specialist_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $this->utilModel->get_actual_date_formate($inputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $this->utilModel->get_actual_date_formate($analyst_specialist_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $show_analyst_specialist_verification_days_taken);

            $outputqc_status_date = 'NA';
            $show_outputqc_verification_days_taken = 'NA';
            $outputqc_status_date_time = 'NA';
            if ($analyst_specialist_status_date != '' && $analyst_specialist_status_date != 'NA' && $value['outputqc_status_date'] != '' && $value['outputqc_status_date'] != 'NA') {
                $outputqc_status_date = $value['outputqc_status_date'];
                $outputqc_status_date_time_splitted = explode(' ',$outputqc_status_date)[0];
                if (!$this->utilModel->check_date_format($outputqc_status_date_time_splitted,'Y-m-d')) {
                    $outputqc_status_date_splitted = explode('-',$outputqc_status_date_time_splitted);
                    $outputqc_status_date_time = $outputqc_status_date_splitted[1].'/'.$outputqc_status_date_splitted[0].'/'.$outputqc_status_date_splitted[2];
                } else {
                    $outputqc_status_date_time = $outputqc_status_date_time_splitted;
                }
                $outputqc_date_difference = date_diff(date_create($analyst_status_date_time),date_create($outputqc_status_date_time));
                $show_outputqc_verification_days_taken = $outputqc_date_difference->format("%a");
                if ($outputqc_date_difference->format("%a") > 1) {
                    $show_outputqc_verification_days_taken .= ' days';
                } else {
                    $show_outputqc_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $this->utilModel->get_actual_date_formate($analyst_specialist_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $this->utilModel->get_actual_date_formate($outputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $show_outputqc_verification_days_taken);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $value['component_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $value['formNumber']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $status);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $outPutQCStatus);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $value['assigned_role']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $value['assigned_team_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $this->utilModel->get_actual_date_formate($value['case_submitted_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $value['insuff_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $value['verification_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $value['insuff_closure_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $value['progress_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $this->utilModel->get_actual_date_formate($value['insuff_created_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $this->utilModel->get_actual_date_formate($value['insuff_close_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $value['panel']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $value['vendor']);

            $rowCount++;
        }
             
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save('../uploads/report/'.$fileName);

        echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
    }


    // daily report documents
    function daily_report_document() {
        $where ='';
        if ($this->input->post('duration') == 'today') {
            $where = " where date(created_date) = CURDATE()";
        } else if($this->input->post('duration') == 'week') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('duration') == 'month') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('duration') == 'year') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('duration') == 'between') {
            $where = " where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        } else {
            $where = "";
        }
        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
        $all_cases = array();

        foreach ($data as $key => $value) {
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']);
            foreach ($cases as $k => $val) {
                if ($this->input->post('table') !='') {
                    if ($this->input->post('table') == $val['component_id']) { 
                        array_push($all_cases, $val);
                    }
                } else {
                    array_push($all_cases, $val);
                }
            }
        }
 
            
        // create file name
        $fileName = 'component-report-'.time().'.xlsx';   
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:AJ1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor() 
                    ->setARGB('D3D3D3');
        
        // set Header
        $objPHPExcel->getActiveSheet()
                ->getStyle('A1:AJ1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('A1:AJ1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr.no.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Client Name');       
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'First Name');       
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Last Name');     
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Father Name');     
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Phone Number');     
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Email');     
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Date Of Birth');     
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Joining Date');      
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
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'initiate Date');       
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Insuff Remarks');       
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Verification Remarks');       
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Insuff Closure Remarks');       
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Progress Remarks');       
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Insuff Date');       
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Insuff Close Date');       
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Aadhar Number');       
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Pan Number');       
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Passport Number');       
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Address');       
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'City');       
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'State');       
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Pincode');       
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Vendor');       
        // set Row
        $rowCount = 2;
        $i =1;

        foreach ($all_cases as $key => $value) {
  

        $is_submitted = '';
        if ($value['is_submitted'] == '0') {           
            $is_submitted = 'Not initiated';
        }else if ($value['is_submitted'] == '1') {     
            $is_submitted = 'In Progress';
        }else if ($value['is_submitted'] == '2') {          
            $is_submitted = 'Verified Clear';
        }else if ($value['is_submitted'] == '3') {
            
            $is_submitted = 'Insuff';
        }else{ 
            $is_submitted = 'Not initiated';
        }

        $status = '';
        if ($value['analyst_status'] == '0') {
             
            $status = 'Not initiated'; 
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
           
            $status = 'Close Insufficient';
            
        }else if ($value['analyst_status'] == '10'){
            $status = 'QC Error'; 
         
        }else if ($value['analyst_status'] == '11'){
            $status = 'Insuff Clear';  
        }
           
        $inputQcStatus = '';
        if ($value['status'] == '0') {
                 
            $inputQcStatus = 'Not initiated';
                
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
               
            $inputQcStatus = 'Close Insufficient';
                
        }
         
        $outPutQCStatus = '';

        if ( $value['output_status'] == '0'){
            $outPutQCStatus = 'Not initiated';
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
                ->getStyle('A'.$rowCount.':AJ'.$rowCount)
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
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $this->utilModel->get_actual_date_formate($value['created_date'])); 
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $value['insuff_remarks']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $value['verification_remarks']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $value['insuff_closure_remarks']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $value['progress_remarks']); 

            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $this->utilModel->get_actual_date_formate($value['insuff_created_date'])); 
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $this->utilModel->get_actual_date_formate($value['insuff_close_date'])); 
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $value['aadhar_number']);  

            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $value['pan_number']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $value['passport_number']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $value['remarks_address']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $value['remark_city']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $value['remark_state']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $value['remark_pin_code']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $value['vendor']); 

            $rowCount++;

        }
 
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save('../uploads/report/'.$fileName);
        
        echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
    } 


    // address
      function daily_report_address() {
        $where ='';
        if ($this->input->post('duration') == 'today') {
          $where=" where date(created_date) = CURDATE()";
        } else if($this->input->post('duration') == 'week') {
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        }else if($this->input->post('duration') == 'month'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        }else if($this->input->post('duration') == 'year'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        }else if($this->input->post('duration') == 'between'){
          $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }else{
            $where="";
        }

        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
        $all_cases = array();

        foreach ($data as $key => $value) {
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']);
            foreach ($cases as $k => $val) {
                if (in_array($val['component_id'],array('8','9','12'))) {
                    array_push($all_cases, $val);    
                }
            }
        }
 
        // create file name
        $fileName = 'component-report-'.time().'.xlsx';   
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:AM1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor() 
                    ->setARGB('D3D3D3');
        
        // set Header
        $objPHPExcel->getActiveSheet()
                ->getStyle('A1:AM1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('A1:AM1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr.no.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case Id');
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
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Case Assigned to InputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Case Verified by InputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Days Taken by InputQC');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Case Assigned to Analyst/Specialist Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Case Verified by Analyst/Specialist Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Days Taken by Analyst/Specialist');
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Case Assigned to OutputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Case Verified by OutputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Days Taken by OutputQC');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Component Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Forms');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Component Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Output Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Assigned Role');
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Assigned to Analyst/Specialist');
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Case Start Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Insuff Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Verification Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Insuff Closure Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Progress Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Insuff Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'Insuff Close Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'Panel');
        $objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'Vendor');
        // set Row
        $rowCount = 2;
        $i = 1;

        foreach ($all_cases as $key => $value) {
            $is_submitted = '';
            if ($value['is_submitted'] == '0') {
                $is_submitted = 'Not initiated';
            } else if ($value['is_submitted'] == '1') {
                $is_submitted = 'In Progress';
            } else if ($value['is_submitted'] == '2') {
                $is_submitted = 'Verified Clear';
            } else if ($value['is_submitted'] == '3') {
                $is_submitted = 'Insuff';
            } else {
                $is_submitted = 'Not initiated';
            }

            $status = '';
            if ($value['analyst_status'] == '0') {
                $status = 'Not initiated'; 
            } else if ($value['analyst_status'] == '1') {           
                $status = 'In Progress'; 
            } else if ($value['analyst_status'] == '2') {
                $status = 'Completed';
            } else if ($value['analyst_status']== '3') {
                $status = 'Insufficiency';
            } else if ($value['analyst_status'] == '4') {
                $status = 'Verified Clear';
            } else if ($value['analyst_status'] == '5') {
                $status = 'Stop Check';
            } else if ($value['analyst_status'] == '6') {
                $status = 'Unable to verify';
            } else if ($value['analyst_status'] == '7') {
                $status = 'Verified discrepancy';
            } else if ($value['analyst_status'] == '8') {
                $status = 'Client clarification';
            } else if ($value['analyst_status'] == '9') {
                $status = 'Close Insufficient';
            } else if ($value['analyst_status'] == '10') {
                $status = 'QC Error'; 
            } else if ($value['analyst_status'] == '11') {
                $status = 'Insuff Clear';  
            }
               
            $inputQcStatus = '';
            if ($value['status'] == '0') {
                $inputQcStatus = 'Not initiated';
            } else if ($value['status'] == '1') {
                $inputQcStatus = 'In Progress';
            } else if ($value['status'] == '2') {
                $inputQcStatus = 'Completed';
            } else if ($value['status']== '3') {
                $inputQcStatus = 'Insufficiency';
            } else if ($value['status'] == '4') {
                $inputQcStatus = 'Verified Clear';
            } else if ($value['status'] == '5') {
                $inputQcStatus = 'Stop Check';
            } else if ($value['status'] == '6') {
                $inputQcStatus = 'Unable to verify';
            } else if ($value['status'] == '7') {
                $inputQcStatus = 'Verified discrepancy';
            } else if ($value['status'] == '8') {
                $inputQcStatus = 'Client clarification';
            } else if ($value['status'] == '9') {
                $inputQcStatus = 'Close Insufficient';
            }
                 
            $outPutQCStatus = '';
            if ( $value['output_status'] == '0') {
                $outPutQCStatus = 'Not initiated';
            } else if ($value['output_status'] == '1') {
                $outPutQCStatus = 'Approved';
            } else if ($value['output_status'] == '2') {
                $outPutQCStatus = 'Rejected';
            } 

            $priority ='';
            if($value['priority'] == '0') {
                $priority = 'Low priority' ;
            } else if($value['priority'] == '1') {
                $priority = 'Medium priority';
            } else if($value['priority'] == '2') {
                $priority = 'High priority';
            }
            $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':AM'.$rowCount)
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
            
            $inputqc_status_date = 'NA';
            $inputqc_verification_days_taken = 'NA';
            $inputqc_status_date_time = 'NA';
            $case_submitted_date = 'NA';
            $show_inputqc_date_difference = 'NA';
            if ($value['case_submitted_date'] != '' && $value['case_submitted_date'] != 'NA') {
                $case_submitted_date = $value['case_submitted_date'];
                if ($value['inputqc_status_date'] != '' && $value['inputqc_status_date'] != 'NA') {
                    $inputqc_status_date = $value['inputqc_status_date'];
                    $case_submitted_date_time_splitted = explode(' ',$case_submitted_date)[0];
                    $inputqc_status_date_time_splitted = explode(' ',$inputqc_status_date)[0];
                    if (!$this->utilModel->check_date_format($inputqc_status_date_time_splitted,'Y-m-d')) {
                        $inputqc_status_date_splitted = explode('-',$inputqc_status_date_time_splitted);
                        $inputqc_status_date_time = $inputqc_status_date_splitted[1].'/'.$inputqc_status_date_splitted[0].'/'.$inputqc_status_date_splitted[2];
                    } else {
                        $inputqc_status_date_time = $inputqc_status_date_time_splitted;
                    }
                    $case_submitted_date_splitted = explode('-',$case_submitted_date_time_splitted);
                    $case_submitted_date_time = $case_submitted_date_splitted[1].'/'.$case_submitted_date_splitted[0].'/'.$case_submitted_date_splitted[2];
                    $inputqc_date_difference = date_diff(date_create($case_submitted_date_time),date_create($inputqc_status_date_time));
                    $show_inputqc_date_difference = $inputqc_date_difference->format("%a");
                    if ($inputqc_date_difference->format("%a") > 1) {
                        $show_inputqc_date_difference .= ' days';
                    } else {
                        $show_inputqc_date_difference .= ' day';
                    }
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $this->utilModel->get_actual_date_formate($case_submitted_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $this->utilModel->get_actual_date_formate($inputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $show_inputqc_date_difference);

            $analyst_specialist_status_date = 'NA';
            $show_analyst_specialist_verification_days_taken = 'NA';
            $analyst_status_date_time = 'NA';
            if ($inputqc_status_date_time != '' && $inputqc_status_date_time != 'NA' && $value['analyst_status_date'] != '' && $value['analyst_status_date'] != 'NA') {
                $analyst_specialist_status_date = $value['analyst_status_date'];
                $analyst_specialist_status_date_time_splitted = explode(' ',$analyst_specialist_status_date)[0];
                if (!$this->utilModel->check_date_format($analyst_specialist_status_date_time_splitted,'Y-m-d')) {
                    $analyst_specialist_status_date_splitted = explode('-',$analyst_specialist_status_date_time_splitted);
                    $analyst_status_date_time = $analyst_specialist_status_date_splitted[1].'/'.$analyst_specialist_status_date_splitted[0].'/'.$analyst_specialist_status_date_splitted[2];
                } else {
                    $analyst_status_date_time = $analyst_specialist_status_date_time_splitted;
                }
                $analyst_specialist_date_difference = date_diff(date_create($inputqc_status_date_time),date_create($analyst_status_date_time));
                $show_analyst_specialist_verification_days_taken = $analyst_specialist_date_difference->format("%a");
                if ($analyst_specialist_date_difference->format("%a") > 1) {
                    $show_analyst_specialist_verification_days_taken .= ' days';
                } else {
                    $show_analyst_specialist_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $this->utilModel->get_actual_date_formate($inputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $this->utilModel->get_actual_date_formate($analyst_specialist_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $show_analyst_specialist_verification_days_taken);

            $outputqc_status_date = 'NA';
            $show_outputqc_verification_days_taken = 'NA';
            $outputqc_status_date_time = 'NA';
            if ($analyst_specialist_status_date != '' && $analyst_specialist_status_date != 'NA' && $value['outputqc_status_date'] != '' && $value['outputqc_status_date'] != 'NA') {
                $outputqc_status_date = $value['outputqc_status_date'];
                $outputqc_status_date_time_splitted = explode(' ',$outputqc_status_date)[0];
                if (!$this->utilModel->check_date_format($outputqc_status_date_time_splitted,'Y-m-d')) {
                    $outputqc_status_date_splitted = explode('-',$outputqc_status_date_time_splitted);
                    $outputqc_status_date_time = $outputqc_status_date_splitted[1].'/'.$outputqc_status_date_splitted[0].'/'.$outputqc_status_date_splitted[2];
                } else {
                    $outputqc_status_date_time = $outputqc_status_date_time_splitted;
                }
                $outputqc_date_difference = date_diff(date_create($analyst_status_date_time),date_create($outputqc_status_date_time));
                $show_outputqc_verification_days_taken = $outputqc_date_difference->format("%a");
                if ($outputqc_date_difference->format("%a") > 1) {
                    $show_outputqc_verification_days_taken .= ' days';
                } else {
                    $show_outputqc_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $this->utilModel->get_actual_date_formate($analyst_specialist_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $this->utilModel->get_actual_date_formate($outputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $show_outputqc_verification_days_taken);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $value['component_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $value['formNumber']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $status);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $outPutQCStatus);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $value['assigned_role']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $value['assigned_team_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $this->date_convert($value['case_submitted_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $value['insuff_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $value['verification_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $value['insuff_closure_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $value['progress_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $this->utilModel->get_actual_date_formate($value['insuff_created_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $this->utilModel->get_actual_date_formate($value['insuff_close_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $value['panel']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $value['vendor']);

            $rowCount++;
        }
             
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save('../uploads/report/'.$fileName);

        echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
    }


    // outputQc

    function daily_report_outputqc(){

            // $data = $this->adminViewAllCaseModel->getAllAssignedCases();   


              $where ='';
        if ($this->input->post('duration') == 'today') {
          $where=" where date(created_date) = CURDATE()";
        }else if($this->input->post('duration') == 'week'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        }else if($this->input->post('duration') == 'month'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        }else if($this->input->post('duration') == 'year'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        }else if($this->input->post('duration') == 'between'){
          $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }else{
            $where="";
        }

        $data = $this->db->query('SELECT candidate.*,tbl_client.client_name FROM candidate  LEFT JOIN tbl_client ON candidate.client_id = tbl_client.client_id '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
            $all_cases = array();
/*
            foreach ($data as $key => $value) { 
                $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']); 
                 foreach ($cases as $k => $val) {
                     if (in_array($val['component_id'],array('8','9','12'))) {
                        
                         array_push($all_cases, $val);
                        
                     } 
                      
                 }
            }*/
 

            
            // create file name
            $fileName = 'component-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A1:L1')
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor() 
                        ->setARGB('D3D3D3');
            // set Header
            $objPHPExcel->getActiveSheet()
                ->getStyle('A1:L1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
            $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr.no.');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case Id');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Client Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'First Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Last Name');     
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Case Start Date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Case Completed Date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Report Generated Date');  
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Completed By');   

            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Report Status');     
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'QC Assign Date');  
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Remarks');  
            /*    
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Case Status');     
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Employee Id');     
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Remarks');     
            $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Priority');     
            $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'InputQc Status');     
            $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Component Name');     
            $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Forms');     
            $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'analyst/Specialist/insuff analyst Status');     
            $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Output Status');     
            $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Assigned Role');     
            $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Assigned to analyst/Specialist');       
            $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Created Date');       
            $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Insuff Remarks');       
            $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Verification Remarks');       
            $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Insuff Closure Remarks');       
            $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Progress Remarks');         
            $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Course Start Date');       
            $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Verifier Fee'); 

            $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Insuff Date');       
            $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Insuff Close Date');  */     
            // set Row
            $rowCount = 2;
            $i =1;
 
            foreach ($data as $key => $value) { 

    $is_submitted = '';
      if ($value['is_submitted'] == '0') {           
                    $is_submitted = 'Not initiated';
                }else if ($value['is_submitted'] == '1') {     
                    $is_submitted = 'In Progress';
                }else if ($value['is_submitted'] == '2') {          
                    $is_submitted = 'Verified Clear';
                }else if ($value['is_submitted'] == '3') {
                    
                    $is_submitted = 'Insuff';
                }else{ 
                    $is_submitted = 'Not initiated';
                }

     /* $status = '';
        if ($value['analyst_status'] == '0') {
                             
                        $status = 'Not initiated'; 
                    }else if ($value['analyst_status'] == '1') {
                         
                        $status = 'Not initiated'; 
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
                       
                        $status = 'Close Insufficient';
                        
                    }else if ($value['analyst_status'] == '10'){
                        $status = 'QC Error'; 
                     
                    }else if ($value['analyst_status'] == '11'){
                        $status = 'Insuff Clear';  
                    }
               
                $inputQcStatus = '';
                if ($value['status'] == '0') {
                         
                    $inputQcStatus = 'Not initiated';
                        
                }else if ($value['status'] == '1') {
                         
                    $inputQcStatus = 'Not initiated';
                         
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
                       
                    $inputQcStatus = 'Close Insufficient';
                        
                }
                 
                $outPutQCStatus = '';

                if ( $value['output_status'] == '0'){
                    $outPutQCStatus = 'Not initiated';
                } else if ($value['output_status'] == '1'){
                    $outPutQCStatus = 'Approved';
                } else if ($value['output_status'] == '2') {
                    $outPutQCStatus = 'Rejected';
                } 

               */


                $priority ='';
            if($value['priority'] == '0'){
                    $priority = 'Low priority' ;
            }else if($value['priority'] == '1'){  
                    $priority = 'Medium priority' ;
            }else if($value['priority'] == '2'){  
                    $priority = 'High priority' ;
                  
            }

           $output = $this->db->where('team_id',$value['assigned_outputqc_id'])->get('team_employee')->row_array();
           $first_name = isset($output['first_name'])?$output['first_name']:'';
           $last_name = isset($output['last_name'])?$output['last_name']:'';

           $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':L'.$rowCount)
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
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $this->utilModel->get_actual_date_formate($value['case_submitted_date'])); 
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $this->utilModel->get_actual_date_formate($value['report_generated_date'])); 

                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $this->utilModel->get_actual_date_formate($value['report_generated_date'])); 
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $first_name.' '.$last_name); 

                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $is_submitted); 
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $this->utilModel->get_actual_date_formate($value['case_submitted_date'])); 
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $value['remark']);  
               /* $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $is_submitted);  
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
                $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $value['created_date']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $value['insuff_remarks']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $value['verification_remarks']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $value['insuff_closure_remarks']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $value['progress_remarks']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $value['course_start_date']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $value['verifier_fee']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $value['insuff_created_date']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $value['insuff_close_date']); */
                $rowCount++;

            }
                /*$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Case Closer Date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Report Generated On');  
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Completed By');   

            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Report Status');     
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Remarks'); */
 
        

     
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
            // download file
            // header("Content-Type: application/vnd.ms-excel");
            // redirect(base_url().'uploads/report/'.$fileName);  

            echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
    }


     // outputQc

    function daily_report_inputqc(){

            // $data = $this->adminViewAllCaseModel->getAllAssignedCases();   


              $where ='';
        if ($this->input->post('duration') == 'today') {
          $where=" where date(created_date) = CURDATE()";
        }else if($this->input->post('duration') == 'week'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        }else if($this->input->post('duration') == 'month'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        }else if($this->input->post('duration') == 'year'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        }else if($this->input->post('duration') == 'between'){
          $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }else{
            $where="";
        }
        $alphabet = $this->utilModel->return_excel_val(); 
        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
            $all_cases = array();

            foreach ($data as $key => $value) { 
                $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']); 
                 foreach ($cases as $k => $val) {
                     if (in_array($val['component_id'],array('8','9','12')) && $this->input->post('table') == '8,9,12') {
                        
                         array_push($all_cases, $val);
                        
                     } else if (in_array($val['component_id'],array('6','10')) && $this->input->post('table') == '6,10') {
                        
                         array_push($all_cases, $val);
                        
                     } else{
                        if ($this->input->post('table') !='') {
                            if ($this->input->post('table') == $val['component_id']) { 
                             // $all_cases[$k] = $val;
                             array_push($all_cases, $val);
                            }
                         }else{
                           // $all_cases[$k] = $val; 
                           array_push($all_cases, $val);
                         }
                     }
                      
                 }
            }


            $component_names = array();
                    $case_data =array();
                    $boday_message = "";
                    $component_name = array();
                    $data_array = array();
                     $candidate_data = array();
                     $analyst_data = array();


             foreach ($all_cases as $k => $val) { 
                      
                        $status = '';
                            if ($val['analyst_status'] == '0') {
                             
                            $status = 'Not initiated'; 
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
                           
                            $status = 'Close Insufficient';
                            
                        }else if ($val['analyst_status'] == '10'){
                            $status = 'QC Error'; 
                         
                        }else if ($val['analyst_status'] == '11'){
                            $status = 'Insuff Clear';  
                        }
                        
                         $is_submitted = '';
                      if ($val['is_submitted'] == '0') {           
                                    $is_submitted = 'Not initiated';
                                }else if ($val['is_submitted'] == '1') {     
                                    $is_submitted = 'In Progress';
                                }else if ($val['is_submitted'] == '2') {          
                                    $is_submitted = 'Verified Clear';
                                }else if ($val['is_submitted'] == '3') {
                                    
                                    $is_submitted = 'Insuff';
                                }else{ 
                                    $is_submitted = 'Not initiated';
                                }

  
                    if (!array_key_exists($val['candidate_id'], $candidate_data)) {
                    $candidate_data[$val['candidate_id']] = array( 
                    'candidate_id' => $val['candidate_id'],
                    'candidate_name' => $val['first_name'].' '.$val['last_name'],
                    'first_name' => $val['first_name'],
                    'last_name' => $val['last_name'],
                    'father_name' => $val['father_name'],
                    'date_of_birth' => $val['date_of_birth'],
                    'employee_id' => $val['employee_id'],
                    'client_name' => $val['client_name'],
                    'created_date' => $val['created_date'],
                    'updated_date' => $val['updated_date'],
                    'case_submitted_date' => $val['case_submitted_date'],
                    'report_generated_date' => $val['report_generated_date'],
                    'assigned_team_name' => $val['assigned_team_name'],
                    'insuff_remarks' => $val['insuff_remarks'],
                    'csm' => $val['csm'],
                    'analyst_status' => $status,
                    'TAT' => $val['left_tat_days'],
                    'is_submitted' => $val['is_submitted'],
                    $val['component_name'].' '.$val['formNumber']=>$status
                    );

                    $client = $val['client_name'];
                    $client_id = $val['client_id'];
                    }else{
                    $candidate_data[$val['candidate_id']][$val['component_name'].' '.$val['formNumber']] = $status; 
                    }
                    if (!array_key_exists($val['component_name'].' '.$val['formNumber'], $data_array)) {
                    $data_array[$val['component_name'].' '.$val['formNumber']] = array($status);
                    }else{
                    $data_array[$val['component_name'].' '.$val['formNumber']] = array_merge($data_array[$val['component_name'].' '.$val['formNumber']],array($status));
                    }


                } 
 

            
            // create file name
            $fileName = 'component-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            
            
            // set Header
             $al = count($data_array)+12;
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A1:'.$alphabet[$al].'1')
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('D3D3D3');
            $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr.no.');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Submission Date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Input QC Date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Case Id');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'First Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Last Name');     
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Client Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Employe ID');       
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'TAT');  
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Completed By');   
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Insuff Remarks');     
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Source');  
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'CSM');     
            // $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Checks');     
            $num = 12;
                $key_array = array();
            if (count($data_array)) { 
                foreach ($data_array as $key2 => $v) {
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num].'1', $key2);
                   array_push($key_array,$key2);
                $num++;
                }
            }
            $objPHPExcel->getActiveSheet()
                ->getStyle('A1:'.$alphabet[$num].'1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
            $objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphabet[$num].'1')->getFont()->setBold(true);

            $rowCount = 2;
            $i =1;
 
            foreach ($candidate_data as $key => $value) { 

    $is_submitted = '';
      if ($value['is_submitted'] == '0') {           
                    $is_submitted = 'Not initiated';
                }else if ($value['is_submitted'] == '1') {     
                    $is_submitted = 'In Progress';
                }else if ($value['is_submitted'] == '2') {          
                    $is_submitted = 'Verified Clear';
                }else if ($value['is_submitted'] == '3') {
                    
                    $is_submitted = 'Insuff';
                }else{ 
                    $is_submitted = 'Not initiated';
                }
 
            
               $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':'.$alphabet[$num].$rowCount)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000'); 
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i++);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $this->utilModel->get_actual_date_formate($value['case_submitted_date']));
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $this->utilModel->get_actual_date_formate($value['report_generated_date']));
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value['candidate_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['first_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value['last_name']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value['client_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value['employee_id']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value['TAT']); 

                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value['assigned_team_name']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value['insuff_remarks']);  

                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, 'none');  
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $value['csm']);  
                $start = 12; 
                        foreach ($key_array as $k1 => $value1) { 

                                $objPHPExcel->getActiveSheet()
                                ->getStyle('A'.$rowCount.':'.$alphabet[$start].$rowCount)
                                ->getBorders()
                                ->getAllBorders()
                                ->setBorderStyle(Border::BORDER_MEDIUM)
                                ->getColor()
                                ->setRGB('000000'); 

                           $fields_id = isset($value[$value1])?$value[$value1]:' ';
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$start] . $rowCount, $fields_id);
                            $start++;  
                        }
                $rowCount++;

            }
                /*$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Case Closer Date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Report Generated On');  
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Completed By');   

            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Report Status');     
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Remarks'); */
 
        

     
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
            // download file
            // header("Content-Type: application/vnd.ms-excel");
            // redirect(base_url().'uploads/report/'.$fileName);  

            echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
    }



    /// drug test 
    function daily_report_criminal_drug_court_test() {
        $where ='';
        if ($this->input->post('duration') == 'today') {
          $where=" where date(created_date) = CURDATE()";
        }else if($this->input->post('duration') == 'week'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        }else if($this->input->post('duration') == 'month'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        }else if($this->input->post('duration') == 'year'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        }else if($this->input->post('duration') == 'between'){
          $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }else{
            $where="";
        }

        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
        $all_cases = array();

        foreach ($data as $key => $value) {
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']);
            foreach ($cases as $k => $val) {
                if ($this->input->post('table') !='') {
                    if ($this->input->post('table') == $val['component_id']) {
                        array_push($all_cases, $val);
                    }
                } else {
                    array_push($all_cases, $val);
                }
            }
        }
            
        // create file name
        $fileName = 'component-report-'.time().'.xlsx';   
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:AM1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor() 
                    ->setARGB('D3D3D3');
        
        // set Header
        $objPHPExcel->getActiveSheet()
                ->getStyle('A1:AM1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('A1:AM1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr.no.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case Id');
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
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Case Assigned to InputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Case Verified by InputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Days Taken by InputQC');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Case Assigned to Analyst/Specialist Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Case Verified by Analyst/Specialist Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Days Taken by Analyst/Specialist');
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Case Assigned to OutputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Case Verified by OutputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Days Taken by OutputQC');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Component Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Forms');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Component Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Output Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Assigned Role');
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Assigned to Analyst/Specialist');
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Case Start Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Insuff Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Verification Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Insuff Closure Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Progress Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Insuff Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'Insuff Close Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'Panel');
        $objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'Vendor');
        // set Row
        $rowCount = 2;
        $i = 1;

        foreach ($all_cases as $key => $value) {
            $is_submitted = '';
            if ($value['is_submitted'] == '0') {
                $is_submitted = 'Not initiated';
            } else if ($value['is_submitted'] == '1') {
                $is_submitted = 'In Progress';
            } else if ($value['is_submitted'] == '2') {
                $is_submitted = 'Verified Clear';
            } else if ($value['is_submitted'] == '3') {
                $is_submitted = 'Insuff';
            } else {
                $is_submitted = 'Not initiated';
            }

            $status = '';
            if ($value['analyst_status'] == '0') {
                $status = 'Not initiated'; 
            } else if ($value['analyst_status'] == '1') {           
                $status = 'In Progress'; 
            } else if ($value['analyst_status'] == '2') {
                $status = 'Completed';
            } else if ($value['analyst_status']== '3') {
                $status = 'Insufficiency';
            } else if ($value['analyst_status'] == '4') {
                $status = 'Verified Clear';
            } else if ($value['analyst_status'] == '5') {
                $status = 'Stop Check';
            } else if ($value['analyst_status'] == '6') {
                $status = 'Unable to verify';
            } else if ($value['analyst_status'] == '7') {
                $status = 'Verified discrepancy';
            } else if ($value['analyst_status'] == '8') {
                $status = 'Client clarification';
            } else if ($value['analyst_status'] == '9') {
                $status = 'Close Insufficient';
            } else if ($value['analyst_status'] == '10') {
                $status = 'QC Error'; 
            } else if ($value['analyst_status'] == '11') {
                $status = 'Insuff Clear';  
            }
               
            $inputQcStatus = '';
            if ($value['status'] == '0') {
                $inputQcStatus = 'Not initiated';
            } else if ($value['status'] == '1') {
                $inputQcStatus = 'In Progress';
            } else if ($value['status'] == '2') {
                $inputQcStatus = 'Completed';
            } else if ($value['status']== '3') {
                $inputQcStatus = 'Insufficiency';
            } else if ($value['status'] == '4') {
                $inputQcStatus = 'Verified Clear';
            } else if ($value['status'] == '5') {
                $inputQcStatus = 'Stop Check';
            } else if ($value['status'] == '6') {
                $inputQcStatus = 'Unable to verify';
            } else if ($value['status'] == '7') {
                $inputQcStatus = 'Verified discrepancy';
            } else if ($value['status'] == '8') {
                $inputQcStatus = 'Client clarification';
            } else if ($value['status'] == '9') {
                $inputQcStatus = 'Close Insufficient';
            }
                 
            $outPutQCStatus = '';
            if ( $value['output_status'] == '0') {
                $outPutQCStatus = 'Not initiated';
            } else if ($value['output_status'] == '1') {
                $outPutQCStatus = 'Approved';
            } else if ($value['output_status'] == '2') {
                $outPutQCStatus = 'Rejected';
            } 

            $priority ='';
            if($value['priority'] == '0') {
                $priority = 'Low priority' ;
            } else if($value['priority'] == '1') {
                $priority = 'Medium priority';
            } else if($value['priority'] == '2') {
                $priority = 'High priority';
            }
            $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':AM'.$rowCount)
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
            
            $inputqc_status_date = 'NA';
            $inputqc_verification_days_taken = 'NA';
            $inputqc_status_date_time = 'NA';
            $case_submitted_date = 'NA';
            $show_inputqc_date_difference = 'NA';
            if ($value['case_submitted_date'] != '' && $value['case_submitted_date'] != 'NA') {
                $case_submitted_date = $value['case_submitted_date'];
                if ($value['inputqc_status_date'] != '' && $value['inputqc_status_date'] != 'NA') {
                    $inputqc_status_date = $value['inputqc_status_date'];
                    $case_submitted_date_time_splitted = explode(' ',$case_submitted_date)[0];
                    $inputqc_status_date_time_splitted = explode(' ',$inputqc_status_date)[0];
                    if (!$this->utilModel->check_date_format($inputqc_status_date_time_splitted,'Y-m-d')) {
                        $inputqc_status_date_splitted = explode('-',$inputqc_status_date_time_splitted);
                        $inputqc_status_date_time = $inputqc_status_date_splitted[1].'/'.$inputqc_status_date_splitted[0].'/'.$inputqc_status_date_splitted[2];
                    } else {
                        $inputqc_status_date_time = $inputqc_status_date_time_splitted;
                    }
                    $case_submitted_date_splitted = explode('-',$case_submitted_date_time_splitted);
                    $case_submitted_date_time = $case_submitted_date_splitted[1].'/'.$case_submitted_date_splitted[0].'/'.$case_submitted_date_splitted[2];
                    $inputqc_date_difference = date_diff(date_create($case_submitted_date_time),date_create($inputqc_status_date_time));
                    $show_inputqc_date_difference = $inputqc_date_difference->format("%a");
                    if ($inputqc_date_difference->format("%a") > 1) {
                        $show_inputqc_date_difference .= ' days';
                    } else {
                        $show_inputqc_date_difference .= ' day';
                    }
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $this->utilModel->get_actual_date_formate($case_submitted_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $this->utilModel->get_actual_date_formate($inputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $show_inputqc_date_difference);

            $analyst_specialist_status_date = 'NA';
            $show_analyst_specialist_verification_days_taken = 'NA';
            $analyst_status_date_time = 'NA';
            if ($inputqc_status_date_time != '' && $inputqc_status_date_time != 'NA' && $value['analyst_status_date'] != '' && $value['analyst_status_date'] != 'NA') {
                $analyst_specialist_status_date = $value['analyst_status_date'];
                $analyst_specialist_status_date_time_splitted = explode(' ',$analyst_specialist_status_date)[0];
                if (!$this->utilModel->check_date_format($analyst_specialist_status_date_time_splitted,'Y-m-d')) {
                    $analyst_specialist_status_date_splitted = explode('-',$analyst_specialist_status_date_time_splitted);
                    $analyst_status_date_time = $analyst_specialist_status_date_splitted[1].'/'.$analyst_specialist_status_date_splitted[0].'/'.$analyst_specialist_status_date_splitted[2];
                } else {
                    $analyst_status_date_time = $analyst_specialist_status_date_time_splitted;
                }
                $analyst_specialist_date_difference = date_diff(date_create($inputqc_status_date_time),date_create($analyst_status_date_time));
                $show_analyst_specialist_verification_days_taken = $analyst_specialist_date_difference->format("%a");
                if ($analyst_specialist_date_difference->format("%a") > 1) {
                    $show_analyst_specialist_verification_days_taken .= ' days';
                } else {
                    $show_analyst_specialist_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $inputqc_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $analyst_specialist_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $show_analyst_specialist_verification_days_taken);

            $outputqc_status_date = 'NA';
            $show_outputqc_verification_days_taken = 'NA';
            $outputqc_status_date_time = 'NA';
            if ($analyst_specialist_status_date != '' && $analyst_specialist_status_date != 'NA' && $value['outputqc_status_date'] != '' && $value['outputqc_status_date'] != 'NA') {
                $outputqc_status_date = $value['outputqc_status_date'];
                $outputqc_status_date_time_splitted = explode(' ',$outputqc_status_date)[0];
                if (!$this->utilModel->check_date_format($outputqc_status_date_time_splitted,'Y-m-d')) {
                    $outputqc_status_date_splitted = explode('-',$outputqc_status_date_time_splitted);
                    $outputqc_status_date_time = $outputqc_status_date_splitted[1].'/'.$outputqc_status_date_splitted[0].'/'.$outputqc_status_date_splitted[2];
                } else {
                    $outputqc_status_date_time = $outputqc_status_date_time_splitted;
                }
                $outputqc_date_difference = date_diff(date_create($analyst_status_date_time),date_create($outputqc_status_date_time));
                $show_outputqc_verification_days_taken = $outputqc_date_difference->format("%a");
                if ($outputqc_date_difference->format("%a") > 1) {
                    $show_outputqc_verification_days_taken .= ' days';
                } else {
                    $show_outputqc_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $this->utilModel->get_actual_date_formate($analyst_specialist_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $this->utilModel->get_actual_date_formate($outputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $show_outputqc_verification_days_taken);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $value['component_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $value['formNumber']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $status);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $outPutQCStatus);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $value['assigned_role']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $value['assigned_team_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $this->date_convert($value['case_submitted_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $value['insuff_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $value['verification_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $value['insuff_closure_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $value['progress_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $this->utilModel->get_actual_date_formate($value['insuff_created_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $this->utilModel->get_actual_date_formate($value['insuff_close_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $value['panel']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $value['vendor']);

            $rowCount++;
        }
             
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save('../uploads/report/'.$fileName);

        echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
    } 

    // global

    function daily_report_global() {
        $where ='';
        if ($this->input->post('duration') == 'today') {
          $where=" where date(created_date) = CURDATE()";
        }else if($this->input->post('duration') == 'week'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        }else if($this->input->post('duration') == 'month'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        }else if($this->input->post('duration') == 'year'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        }else if($this->input->post('duration') == 'between'){
          $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }else{
            $where="";
        }

        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
        $all_cases = array();

        foreach ($data as $key => $value) {
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']);
            foreach ($cases as $k => $val) {
                if ($this->input->post('table') !='') {
                    if ($this->input->post('table') == $val['component_id']) { 
                        array_push($all_cases, $val);
                    }
                } else {
                    array_push($all_cases, $val);
                }
            }
        }
 
            
        // create file name
        $fileName = 'component-report-'.time().'.xlsx';   
        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:AM1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor() 
                    ->setARGB('D3D3D3');
        
        // set Header
        $objPHPExcel->getActiveSheet()
                ->getStyle('A1:AM1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('A1:AM1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr.no.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case Id');
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
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Case Assigned to InputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Case Verified by InputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Days Taken by InputQC');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Case Assigned to Analyst/Specialist Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Case Verified by Analyst/Specialist Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Days Taken by Analyst/Specialist');
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Case Assigned to OutputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Case Verified by OutputQC Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Days Taken by OutputQC');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Component Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Forms');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Component Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Output Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Assigned Role');
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Assigned to Analyst/Specialist');
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Case Start Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Insuff Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Verification Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Insuff Closure Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Progress Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Insuff Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'Insuff Close Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'Panel');
        $objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'Vendor');
        // set Row
        $rowCount = 2;
        $i = 1;

        foreach ($all_cases as $key => $value) {
            $is_submitted = '';
            if ($value['is_submitted'] == '0') {
                $is_submitted = 'Not initiated';
            } else if ($value['is_submitted'] == '1') {
                $is_submitted = 'In Progress';
            } else if ($value['is_submitted'] == '2') {
                $is_submitted = 'Verified Clear';
            } else if ($value['is_submitted'] == '3') {
                $is_submitted = 'Insuff';
            } else {
                $is_submitted = 'Not initiated';
            }

            $status = '';
            if ($value['analyst_status'] == '0') {
                $status = 'Not initiated'; 
            } else if ($value['analyst_status'] == '1') {           
                $status = 'In Progress'; 
            } else if ($value['analyst_status'] == '2') {
                $status = 'Completed';
            } else if ($value['analyst_status']== '3') {
                $status = 'Insufficiency';
            } else if ($value['analyst_status'] == '4') {
                $status = 'Verified Clear';
            } else if ($value['analyst_status'] == '5') {
                $status = 'Stop Check';
            } else if ($value['analyst_status'] == '6') {
                $status = 'Unable to verify';
            } else if ($value['analyst_status'] == '7') {
                $status = 'Verified discrepancy';
            } else if ($value['analyst_status'] == '8') {
                $status = 'Client clarification';
            } else if ($value['analyst_status'] == '9') {
                $status = 'Close Insufficient';
            } else if ($value['analyst_status'] == '10') {
                $status = 'QC Error'; 
            } else if ($value['analyst_status'] == '11') {
                $status = 'Insuff Clear';  
            }
               
            $inputQcStatus = '';
            if ($value['status'] == '0') {
                $inputQcStatus = 'Not initiated';
            } else if ($value['status'] == '1') {
                $inputQcStatus = 'In Progress';
            } else if ($value['status'] == '2') {
                $inputQcStatus = 'Completed';
            } else if ($value['status']== '3') {
                $inputQcStatus = 'Insufficiency';
            } else if ($value['status'] == '4') {
                $inputQcStatus = 'Verified Clear';
            } else if ($value['status'] == '5') {
                $inputQcStatus = 'Stop Check';
            } else if ($value['status'] == '6') {
                $inputQcStatus = 'Unable to verify';
            } else if ($value['status'] == '7') {
                $inputQcStatus = 'Verified discrepancy';
            } else if ($value['status'] == '8') {
                $inputQcStatus = 'Client clarification';
            } else if ($value['status'] == '9') {
                $inputQcStatus = 'Close Insufficient';
            }
                 
            $outPutQCStatus = '';
            if ( $value['output_status'] == '0') {
                $outPutQCStatus = 'Not initiated';
            } else if ($value['output_status'] == '1') {
                $outPutQCStatus = 'Approved';
            } else if ($value['output_status'] == '2') {
                $outPutQCStatus = 'Rejected';
            } 

            $priority ='';
            if($value['priority'] == '0') {
                $priority = 'Low priority' ;
            } else if($value['priority'] == '1') {
                $priority = 'Medium priority';
            } else if($value['priority'] == '2') {
                $priority = 'High priority';
            }
            $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':AM'.$rowCount)
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
            
            $inputqc_status_date = 'NA';
            $inputqc_verification_days_taken = 'NA';
            $inputqc_status_date_time = 'NA';
            $case_submitted_date = 'NA';
            $show_inputqc_date_difference = 'NA';
            if ($value['case_submitted_date'] != '' && $value['case_submitted_date'] != 'NA') {
                $case_submitted_date = $value['case_submitted_date'];
                if ($value['inputqc_status_date'] != '' && $value['inputqc_status_date'] != 'NA') {
                    $inputqc_status_date = $value['inputqc_status_date'];
                    $case_submitted_date_time_splitted = explode(' ',$case_submitted_date)[0];
                    $inputqc_status_date_time_splitted = explode(' ',$inputqc_status_date)[0];
                    if (!$this->utilModel->check_date_format($inputqc_status_date_time_splitted,'Y-m-d')) {
                        $inputqc_status_date_splitted = explode('-',$inputqc_status_date_time_splitted);
                        $inputqc_status_date_time = $inputqc_status_date_splitted[1].'/'.$inputqc_status_date_splitted[0].'/'.$inputqc_status_date_splitted[2];
                    } else {
                        $inputqc_status_date_time = $inputqc_status_date_time_splitted;
                    }
                    $case_submitted_date_splitted = explode('-',$case_submitted_date_time_splitted);
                    $case_submitted_date_time = $case_submitted_date_splitted[1].'/'.$case_submitted_date_splitted[0].'/'.$case_submitted_date_splitted[2];
                    $inputqc_date_difference = date_diff(date_create($case_submitted_date_time),date_create($inputqc_status_date_time));
                    $show_inputqc_date_difference = $inputqc_date_difference->format("%a");
                    if ($inputqc_date_difference->format("%a") > 1) {
                        $show_inputqc_date_difference .= ' days';
                    } else {
                        $show_inputqc_date_difference .= ' day';
                    }
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $this->utilModel->get_actual_date_formate($case_submitted_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $this->utilModel->get_actual_date_formate($inputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $show_inputqc_date_difference);

            $analyst_specialist_status_date = 'NA';
            $show_analyst_specialist_verification_days_taken = 'NA';
            $analyst_status_date_time = 'NA';
            if ($inputqc_status_date_time != '' && $inputqc_status_date_time != 'NA' && $value['analyst_status_date'] != '' && $value['analyst_status_date'] != 'NA') {
                $analyst_specialist_status_date = $value['analyst_status_date'];
                $analyst_specialist_status_date_time_splitted = explode(' ',$analyst_specialist_status_date)[0];
                if (!$this->utilModel->check_date_format($analyst_specialist_status_date_time_splitted,'Y-m-d')) {
                    $analyst_specialist_status_date_splitted = explode('-',$analyst_specialist_status_date_time_splitted);
                    $analyst_status_date_time = $analyst_specialist_status_date_splitted[1].'/'.$analyst_specialist_status_date_splitted[0].'/'.$analyst_specialist_status_date_splitted[2];
                } else {
                    $analyst_status_date_time = $analyst_specialist_status_date_time_splitted;
                }
                $analyst_specialist_date_difference = date_diff(date_create($inputqc_status_date_time),date_create($analyst_status_date_time));
                $show_analyst_specialist_verification_days_taken = $analyst_specialist_date_difference->format("%a");
                if ($analyst_specialist_date_difference->format("%a") > 1) {
                    $show_analyst_specialist_verification_days_taken .= ' days';
                } else {
                    $show_analyst_specialist_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $this->utilModel->get_actual_date_formate($inputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $this->utilModel->get_actual_date_formate($analyst_specialist_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $show_analyst_specialist_verification_days_taken);

            $outputqc_status_date = 'NA';
            $show_outputqc_verification_days_taken = 'NA';
            $outputqc_status_date_time = 'NA';
            if ($analyst_specialist_status_date != '' && $analyst_specialist_status_date != 'NA' && $value['outputqc_status_date'] != '' && $value['outputqc_status_date'] != 'NA') {
                $outputqc_status_date = $value['outputqc_status_date'];
                $outputqc_status_date_time_splitted = explode(' ',$outputqc_status_date)[0];
                if (!$this->utilModel->check_date_format($outputqc_status_date_time_splitted,'Y-m-d')) {
                    $outputqc_status_date_splitted = explode('-',$outputqc_status_date_time_splitted);
                    $outputqc_status_date_time = $outputqc_status_date_splitted[1].'/'.$outputqc_status_date_splitted[0].'/'.$outputqc_status_date_splitted[2];
                } else {
                    $outputqc_status_date_time = $outputqc_status_date_time_splitted;
                }
                $outputqc_date_difference = date_diff(date_create($analyst_status_date_time),date_create($outputqc_status_date_time));
                $show_outputqc_verification_days_taken = $outputqc_date_difference->format("%a");
                if ($outputqc_date_difference->format("%a") > 1) {
                    $show_outputqc_verification_days_taken .= ' days';
                } else {
                    $show_outputqc_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $this->utilModel->get_actual_date_formate($analyst_specialist_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $this->utilModel->get_actual_date_formate($outputqc_status_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $show_outputqc_verification_days_taken);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $value['component_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $value['formNumber']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $status);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $outPutQCStatus);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $value['assigned_role']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $value['assigned_team_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $this->date_convert($value['case_submitted_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $value['insuff_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $value['verification_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $value['insuff_closure_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $value['progress_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $this->utilModel->get_actual_date_formate($value['insuff_created_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $this->utilModel->get_actual_date_formate($value['insuff_close_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $value['panel']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $value['vendor']);

            $rowCount++;
        }
             
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save('../uploads/report/'.$fileName);

        echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
    } 



    function daily_report_insuff(){
      
 
            // $data = $this->adminViewAllCaseModel->getAllAssignedCases();   


        $where ='';
        if ($this->input->post('duration') == 'today') {
          $where=" where date(created_date) = CURDATE()";
        }else if($this->input->post('duration') == 'week'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        }else if($this->input->post('duration') == 'month'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        }else if($this->input->post('duration') == 'year'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        }else if($this->input->post('duration') == 'between'){
          $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }else{
            $where="";
        }

        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
            $all_cases = array();

            foreach ($data as $key => $value) { 
                $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']); 
                 foreach ($cases as $k => $val) {
                     if (in_array($val['component_id'],array('8','9','12')) && $this->input->post('table') == '8,9,12') {
                        if ($this->input->post('insuff') =='1') { 
                            if ($val['analyst_status']== '3' || $val['is_submitted'] =='3') {
                                array_push($all_cases, $val);
                            }
                            }else{
                                array_push($all_cases, $val);
                            }
                        
                     } else if (in_array($val['component_id'],array('6','10')) && $this->input->post('table') == '6,10') {
                        
                        if ($this->input->post('insuff') =='1') { 
                            if ($val['analyst_status']== '3' || $val['is_submitted'] =='3') {
                                array_push($all_cases, $val);
                            }
                            }else{
                                array_push($all_cases, $val);
                            }
                        
                     } else{
                        if ($this->input->post('table') !='') {
                            if ($this->input->post('table') == $val['component_id']) { 
                             // $all_cases[$k] = $val;
                             if ($this->input->post('insuff') =='1') { 
                                if ($val['analyst_status']== '3' || $val['is_submitted'] =='3') {
                                    array_push($all_cases, $val);
                                }
                                }else{
                                    array_push($all_cases, $val);
                                }
                            }
                         }else{
                           // $all_cases[$k] = $val; 
                           if ($this->input->post('insuff') =='1') { 
                            if ($val['analyst_status']== '3' || $val['is_submitted'] =='3') {
                                    array_push($all_cases, $val);
                            }
                                }else{
                                    array_push($all_cases, $val);
                                }
                         }
                     }
                      
                 }
            }


          
            
            // create file name
            $fileName = 'component-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A1:N1')
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor() 
                        ->setARGB('D3D3D3');
            
            // set Header
            $objPHPExcel->getActiveSheet()
                ->getStyle('A1:N1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
            $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr.no.');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case Id');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Client Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'First Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Last Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Employee Id');     
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Submitted Data');  

            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Check Type');     
            // $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Insuff Property');     
            // $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Component Name');     
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Component Status');  
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Insuff Remarks');       
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Insuff Raised');       
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Insuff Closed');         
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Insuff Status');     
            $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Case Status');     
      


            // set Row
            $rowCount = 2;
            $i =1;
 
            foreach ($all_cases as $key => $value) {
      

$is_submitted = '';
  if ($value['is_submitted'] == '0') {           
                $is_submitted = 'Not initiated';
            }else if ($value['is_submitted'] == '1') {     
                $is_submitted = 'In Progress';
            }else if ($value['is_submitted'] == '2') {          
                $is_submitted = 'Verified Clear';
            }else if ($value['is_submitted'] == '3') {
                
                $is_submitted = 'Insuff';
            }else{ 
                $is_submitted = 'Not initiated';
            }

  $status = '';
    if ($value['analyst_status'] == '0') {
                         
                        $status = 'Not initiated'; 
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
                       
                        $status = 'Close Insufficient';
                        
                    }else if ($value['analyst_status'] == '10'){
                        $status = 'QC Error'; 
                     
                    }else if ($value['analyst_status'] == '11'){
                        $status = 'Insuff Clear';  
                    }
               
                $inputQcStatus = '';
                if ($value['status'] == '0') {
                         
                    $inputQcStatus = 'Not initiated';
                        
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
                       
                    $inputQcStatus = 'Close Insufficient';
                        
                }
                 
                $outPutQCStatus = '';

                if ( $value['output_status'] == '0'){
                    $outPutQCStatus = 'Not initiated';
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
                ->getStyle('A'.$rowCount.':N'.$rowCount)
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
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $this->utilModel->get_actual_date_formate($value['report_generated_date'])); 
                // $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'none'); 
                // $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'none'); 
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value['component_name']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $inputQcStatus); 
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value['insuff_remarks']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $this->utilModel->get_actual_date_formate($value['insuff_created_date'])); 
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $this->utilModel->get_actual_date_formate($value['insuff_close_date'])); 
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $status); 
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $is_submitted); 
 

                $rowCount++;

            }
              
     
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
            // download file
            // header("Content-Type: application/vnd.ms-excel");
            // redirect(base_url().'uploads/report/'.$fileName);  

            echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));

    }



    function component_error_log_details(){

        $error_log = $this->common_User_Filled_Details_Component_Error_Model->component_error_log_details();
     
            // create file name
            $fileName = 'component-error-log-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A1:L1')
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor() 
                        ->setARGB('D3D3D3');
 
            // set Header
            $objPHPExcel->getActiveSheet()
                ->getStyle('A1:L1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
            $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr.no.');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case Id');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Candidate Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Component Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Client Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Component Error Log');     
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Error Commited By Name');   
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Error Commited By Role');      
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Created Date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Error Logged By Name');   
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Error Logged By Role');      
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Error Logged Date');      
      


            // set Row
            $rowCount = 2;
            $i =1;
 
            foreach ($error_log as $key => $value) {
         
                $component_name = $value['component_name'];
                if ($value['value_type'] !='') {
                     $component_name =  $value['value_type'];
                }
                $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':L'.$rowCount)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i++);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value['candidate_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value['candidate_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $component_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['client_name']);    
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, strip_tags($value['error_description']));  
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value['error_added_by_name']);   
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value['error_role']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $this->utilModel->get_actual_date_formate($value['error_created_date']));  
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value['added_by_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value['role']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $this->utilModel->get_actual_date_formate($value['created_date']));  

                $rowCount++;

            }
              
     
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
            // download file
            // header("Content-Type: application/vnd.ms-excel");
            // redirect(base_url().'uploads/report/'.$fileName);  

            echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
    } 


    function export_cases_assigned_to_vendor() {
        $alphabet = $this->utilModel->return_excel_val(); 
        $where = '';
        if ($this->input->post('duration') == 'today') {
            $where = " where date(assign_case_to_vendor.created_date) = CURDATE()";
        } else if($this->input->post('duration') == 'week') {
            $where = " where date(assign_case_to_vendor.created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('duration') == 'month') {
            $where = " where date(assign_case_to_vendor.created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('duration') == 'year') {
            $where = " where date(assign_case_to_vendor.created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('duration') == 'between') {
            $where = " where date(assign_case_to_vendor.created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }
        // $data = $this->db->query('SELECT * FROM candidate AS T1 INNER JOIN assign_case_to_vendor AS T2 ON T1.candidate_id = T2.case_id INNER JOIN vendor AS T3 ON T2.vendor_id = T3.vendor_id  '.$where.'  ORDER BY candidate_id DESC')->result_array();
        if ($where !='') {
           $this->db->where($where);
        }
        $data = $this->db->select('vendor.vendor_name,assign_case_to_vendor.*,candidate.*,team_employee.first_name as team_first_name,team_employee.role')->from('assign_case_to_vendor')->join('vendor','assign_case_to_vendor.vendor_id = vendor.vendor_id','left')->join('candidate','assign_case_to_vendor.case_id = candidate.candidate_id','left')->join('team_employee','assign_case_to_vendor.assignment_team_id = team_employee.team_id','left')->order_by('vendor_id','DESC')->get()->result_array();
        
        $CaseList = array();
        $component_names = array();
        $case_data =array();
        $boday_message = "";
        $component_name = array();
        $data_array = array();
        $candidate_data = array();
        $analyst_data = array();
        foreach ($data as $key => $value) {
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']);
            $analyst = array();

            foreach ($cases as $k => $val) { 
                $status = '';
                if ($val['analyst_status'] == '0') {             
                    $status = 'Not initiated';
                } else if ($val['analyst_status'] == '1') {
                    $status = 'In Progress';
                } else if ($val['analyst_status'] == '2') {
                    $status = 'Completed';
                } else if ($val['analyst_status']== '3') {
                    $status = 'Insufficiency';
                } else if ($val['analyst_status'] == '4') {
                    $status = 'Verified Clear';
                } else if ($val['analyst_status'] == '5') {
                    $status = 'Stop Check';
                } else if ($val['analyst_status'] == '6') {
                    $status = 'Unable to verify';
                } else if ($val['analyst_status'] == '7') {
                    $status = 'Verified discrepancy';
                } else if ($val['analyst_status'] == '8') {
                    $status = 'Client clarification';
                } else if ($val['analyst_status'] == '9') {
                    $status = 'Close Insufficient';
                } else if ($val['analyst_status'] == '10') {
                    $status = 'QC Error';
                } else if ($val['analyst_status'] == '11') {
                    $status = 'Insuff Clear';
                }


                
                    $candidate_data[$val['candidate_id']] = array( 
                        'candidate_id' => $val['candidate_id'],
                        'candidate_name' => $val['first_name'].' '.$val['last_name'],
                        'father_name' => $val['father_name'],
                        'employee_id' => $val['employee_id'],
                        'date_of_birth' => $val['date_of_birth'],
                        'client_name' => $val['client_name'],
                        'assigned_team_name' => $value['team_first_name'],
                        'vendor_name' => $value['vendor_name'],
                        'role' => $value['role'],
                        'analyst_status' => $status,
                        'created_date' => $value['created_date'],
                        'updated_date' => $val['updated_date'],
                        'TAT' => $val['left_tat_days'],
                        'component_name' => $val['component_name'].' '.$val['formNumber']
                    );

                    $client = $val['client_name'];
                    $client_id = $val['client_id'];
                 

            }

            }

            
     

        // create file name
        $fileName = 'cases-allocated-to-vendor-'.time().'.xlsx';   
        $objPHPExcel = new Spreadsheet();
        $al = count($data_array)+9;
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:L1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('D3D3D3');
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'subdate');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'caseid');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Candidate');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'EmployeeID');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Father Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'DOB');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Vendor Name'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Assignment Name'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Assignment Role'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Assigned Date'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Component Name'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Verification Status'); 
        
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:L1')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->getColor()
            ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);


        $rowCount = 2; 
        if (count($candidate_data) > 0) {  
                 $init = 0;
                 foreach ($candidate_data as $k => $val) {
                    $objPHPExcel->getActiveSheet()
                        ->getStyle('A'.$rowCount.':L'.$rowCount)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_MEDIUM)
                        ->getColor()
                        ->setRGB('000000'); 
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $this->utilModel->get_actual_date_formate($val['created_date'])); 
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $val['candidate_id']); 
                    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $val['candidate_name']); 
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $val['employee_id']); 
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $val['father_name']); 
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $val['date_of_birth']); 
                    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $val['vendor_name']); 
                    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $val['assigned_team_name']); 
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $val['role']); 
                    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $this->utilModel->get_actual_date_formate($val['created_date'])); 
                    $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $val['component_name']); 
                    $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $val['analyst_status']); 
          
                     
                    
                    $rowCount++;
            }
        }

        echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
                                    
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save('../uploads/report/'.$fileName);
    }


    function export_finance_report(){

          $alphabet = $this->utilModel->return_excel_val(); 
        $where = '';
        if ($this->input->post('duration') == 'today') {
            $where = " where date(created_date) = CURDATE()";
        } else if($this->input->post('duration') == 'week') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('duration') == 'month') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('duration') == 'year') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('duration') == 'between') {
            $where = " where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }
        $case = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();

             $data_array = array();
             $data_array_price = array();
             $candidate_data = array();
             $analyst_data = array();
             $client = '';
             $client_id = '';
            foreach ($case as $key => $value) { 
               $data['candidate'] = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($value['candidate_id']); 
               $analyst = array();
                  // $case_array = array();
                foreach ($data['candidate'] as $k => $val) {  
                     $price_val = json_decode($val['client_packages_list'],true);
                      $price_value =0;
                     foreach ($price_val as $pk => $pvalue) {
                        if ($val['component_id'] == $pvalue['component_id']) { 
                            $price_value = $pvalue['component_standard_price'];
                        }
                     }


                  array_push($analyst,$val['analyst_status']);


                    $string_status = 'Verified Clear';
               if (in_array('0', $analyst)) {  
                    $string_status = 'Verified Pending'; 
                }else if (in_array('1', $analyst)) { 
                    $string_status = 'Verified Pending'; 
                }else if (in_array('2', $analyst)) { 
                        $string_status = 'Verified Clear'; 
                }else if (in_array('3', $analyst)) { 
                        $string_status = 'Insufficiency'; 
                }else if (in_array('4', $analyst)) { 
                    $string_status = 'Verified Clear'; 
                }else if (in_array('5', $analyst)) { 
                        $string_status = 'Stop Check'; 
                }else if (in_array('6', $analyst)) { 
                        $string_status = 'Unable to Verify'; 
                }else if (in_array('7', $analyst)) { 
                        $string_status = 'Verified Discrepancy'; 
                    
                }else if (in_array('8', $analyst)) { 
                        $string_status = 'Client Clarification'; 
                }else if (in_array('9', $analyst)) { 
                    $string_status = 'Closed insufficiency'; 
                     

                }else if (in_array('10', $analyst)) { 
                    $string_status = 'QC-error';  
                      
                }
                  if (!array_key_exists($val['candidate_id'], $candidate_data)) {
                     $candidate_data[$val['candidate_id']] = array( 
                        'candidate_id' => $val['candidate_id'],
                        'segment' => $val['segment'],
                        'location' => $val['location'],
                        'father_name' => $val['father_name'],
                        'phone_number' => $val['phone_number'],
                        'employee_id' => $val['employee_id'],
                        'candidate_name' => $val['first_name'].' '.$val['last_name'],
                        'client_name' => $val['client_name'],
                        'case_submitted_date' => isset($val['candidate_details']['case_submitted_date'])?$val['candidate_details']['case_submitted_date']:$val['tat_start_date'],
                        'completed_date' =>isset($val['candidate_details']['report_generated_date'])?$val['candidate_details']['report_generated_date']:'',
                        $val['component_name'].' '.$val['formNumber']=>array('status'=>$string_status,'price'=>$price_value)
                     );

                     $client = $val['client_name'];
                     $client_id = $val['client_id'];
                  }else{
                    $candidate_data[$val['candidate_id']][$val['component_name'].' '.$val['formNumber']] = array('status'=>$string_status,'price'=>$price_value); 
                  }
                    if (!array_key_exists($val['component_name'].' '.$val['formNumber'], $data_array)) {
                     $data_array[$val['component_name'].' '.$val['formNumber']] = array($string_status);
                     $data_array_price[$val['component_name'].' '.$val['formNumber']] = array($price_value);
                    }else{
                     $data_array[$val['component_name'].' '.$val['formNumber']] = array_merge($data_array[$val['component_name'].' '.$val['formNumber']],array($string_status));
                     $data_array_price[$val['component_name'].' '.$val['formNumber']] = array_merge($data_array[$val['component_name'].' '.$val['formNumber']],array($price_value));
                    }

                 }

               

                array_push($analyst_data,$string_status);

                 // array_push($data_array,$case_array);
            }

            $objPHPExcel = new Spreadsheet();

              // create file name
            $fileName = 'component-finance-report-'.time().'.xlsx';   
             
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[0] .'1', 'Sr.no.');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[1] .'1', 'Submitted On');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[2] .'1', 'Client Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[3] .'1', 'Candidate Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[4] .'1', 'Case Id');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[5] .'1', 'Case Status');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[6] .'1', 'Completion Date');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[7] .'1', 'Segment');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[8] .'1', 'Employee ID');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[9] .'1', 'Location');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[10] .'1', 'Father Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[11] .'1', 'Mobile Number');  

             $key_array = array();
                        $n = 12;
                        foreach ($data_array as $key => $value) {
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$n++] .'1', str_replace(" "," ",$key).' Status'); 
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$n++] .'1', str_replace(" "," ",$key).' Price');  
                           array_push($key_array,$key);
                        }
                        $count =array();
                        if (isset($finance_row['created_fields'])) {
                           $count = explode(',', $finance_row['created_fields']);
                           foreach ($count as $f => $fvalue) { 
                              $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$n++] .'1', $fvalue);  
                           }
                        }    
      


            // set Row
            $rowCount = 2;
            $i =1;
            if (count($candidate_data) > 0) {  
                     $init = 0;
                     foreach ($candidate_data as $k => $val) {
                     $n=0;
            $alphabet = $this->utilModel->return_excel_val(); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $i++);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['case_submitted_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['client_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['candidate_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['candidate_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $analyst_data[$init]);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['completed_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['segment']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['employee_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['location']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['father_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['phone_number']);
                 $a = 0;
                        foreach ($key_array as $key => $value) { 
                           $fields_id = isset($val[$value]['status'])?$val[$value]['status']:' '; 
                           $fields_id1 = isset($val[$value]['price'])?$val[$value]['price']:' ';
                             $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $fields_id);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $fields_id1);
                           
                        }
                        if (count($count) > 0) {
                        if (isset($finance_row['fields_data'])) {
                            
                        }else{
                            
                            foreach ($count as $c => $cvalue) {
                              $str = str_replace(' ','_',$cvalue); 
                                 $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, '');
                               }   
                           }
                        }

                         
                        $init++;
                $rowCount++;
            }
            }
              
     
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
            // download file
            // header("Content-Type: application/vnd.ms-excel");
            // redirect(base_url().'uploads/report/'.$fileName);  

            echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));


    }



    function for_the_client_ageing_report(){
        
           $alphabet = $this->utilModel->return_excel_val(); 
        $ageing = $this->admin_Analytics_Model->for_the_client_ageing_report();
            $objPHPExcel = new Spreadsheet();

              // create file name
            $fileName = 'client-ageing-finance-report-'.time().'.xlsx';   
             
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[0] .'1', 'Sr.no.');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[1] .'1', 'Client Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[2] .'1', '0-15');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[3] .'1', '16-30');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[4] .'1', '31-45');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[5] .'1', '>45');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[6] .'1', 'Total');    
 

            // set Row
            $rowCount = 2;
            $i =1;
            if (count($ageing) > 0) {  
                     $init = 0;
                     foreach ($ageing as $k => $val) {
                     $n=0;
            $alphabet = $this->utilModel->return_excel_val(); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $i++);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['client_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['fiftin']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['thirty']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['fortyfive']); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['sixty']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['total']); 
                 
                $rowCount++;
            }
            }
              
     
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
            // download file
            // header("Content-Type: application/vnd.ms-excel");
            // redirect(base_url().'uploads/report/'.$fileName);  

            echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));

    }


    function get_order_details(){
        $crm = $this->load_Database_Model->load_database();

        $result = $crm->where('package_cart_status',0)->order_by('cart_id','DESC')->get('package_cart')->result_array();
        $client_array = array();
        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $main_sum = array();
               $client = $this->db->where('client_id',$value['user_id'])->get('tbl_client')->row_array();
            $comp_onent = isset($value['package_cart_details'])?$value['package_cart_details']:'';
                $package_component = json_decode($comp_onent,true);
                
              if ($comp_onent !='' && $comp_onent !=null && $comp_onent !='[]') {
                   if (count($package_component['selected_package_component_details']) > 0) { 
                    foreach ($package_component['selected_package_component_details'] as $key => $val) { 
                         
                        if ($val['type_of_price'] == 0) { 
                            foreach ($val['form_data'] as $key => $price) {
                                array_push($main_sum,$price['form_value']);
                            } 
                        }else{
                            array_push($main_sum,$val['component_standard_price']);
                        }
                    }

                }
            }

            $total_value = array_sum($main_sum)*$package_component['no_of_candidates']; 

            $row['service_name'] = $package_component['service_name'];
            $row['service_id'] = $package_component['service_id'];
            $row['package_name'] = $package_component['package_name'];
            $row['package_id'] = $package_component['package_id'];
            $row['order_value'] = $total_value;
            $row['service_id'] = $package_component['service_id'];
            $row['client_name'] = isset($client['client_name'])?$client['client_name']:'-';
            $row['client_gst'] = isset($client['gst_number'])?$client['gst_number']:'-';
            $row['client_address'] = isset($client['client_address'])?$client['client_address']:'-';
            $row['client_state'] = isset($client['client_address']) ? $client['client_address'] : '-'; 
            $row['client_id'] = $value['user_id'];
            $row['invoice_no'] = $value['cart_id']; 
            $row['date'] = $value['package_purchased_date'];
            $row['qty'] = $package_component['no_of_candidates'];
            $row['service_id'] = $package_component['service_id'];
            array_push($client_array,$row);
            }
        }

            $alphabet = $this->utilModel->return_excel_val();  
            $objPHPExcel = new Spreadsheet();

              // create file name
            $fileName = 'client-finance-mis-report-'.time().'.xlsx';   
             
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[0] .'1', 'Sr.no.');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[1] .'1', 'Invoice Number');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[2] .'1', 'Invoice Date');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[3] .'1', 'Customer Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[4] .'1', 'GST Number');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[5] .'1', 'Place of Supply');     
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[6] .'1', 'Address');     
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[7] .'1', 'Currency');    
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[8] .'1', 'Exchange Rate');    
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[9] .'1', 'Item Name');    
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[10] .'1', 'Item Desc');    
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[11] .'1', 'Item Type');    
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[12] .'1', 'HSN/SAC');    
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[13] .'1', 'Quantity');    
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[14] .'1', 'Usage unit');    
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[15] .'1', 'Item Price');    
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[16] .'1', 'Discount Amount');    
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[17] .'1', 'Shipping Charge');      
 

            // set Row
            $rowCount = 2;
            $i =1;
            if (count($client_array) > 0) {  
                     $init = 0;
                     foreach ($client_array as $k => $val) {
                     $n=0; 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $i++);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['invoice_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['date']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['client_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['client_gst']); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['client_state']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['client_address']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, 'INR'); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, '0'); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['service_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, '-'); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, '-'); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, '0'); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['qty']); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, '-'); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['order_value']); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, '0'); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, '0');   
                 
                $rowCount++;
            }
            }
              
     
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
            // download file
            // header("Content-Type: application/vnd.ms-excel");
            // redirect(base_url().'uploads/report/'.$fileName);  

            echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));

    }




    function export_re_initiate_re_open_cases_finance_report(){

          $alphabet = $this->utilModel->return_excel_val(); 
        $where = '';
        if ($this->input->post('duration') == 'today') {
            $where = " AND date(created_date) = CURDATE()";
        } else if($this->input->post('duration') == 'week') {
            $where = " AND date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('duration') == 'month') {
            $where = " AND date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('duration') == 'year') {
            $where = " AND date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('duration') == 'between') {
            $where = " AND date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }
        $case = $this->db->query('SELECT * FROM candidate where case_reinitiate =1 '.$where.'  ORDER BY candidate_id DESC')->result_array();

             $data_array = array();
             $data_array_price = array();
             $candidate_data = array();
             $analyst_data = array();
             $client = '';
             $client_id = '';
            foreach ($case as $key => $value) { 
               $data['candidate'] = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($value['candidate_id']); 
               $analyst = array();
                  // $case_array = array();
                foreach ($data['candidate'] as $k => $val) {  
                     $price_val = json_decode($val['client_packages_list'],true);
                      $price_value =0;
                     foreach ($price_val as $pk => $pvalue) {
                        if ($val['component_id'] == $pvalue['component_id']) { 
                            $price_value = $pvalue['component_standard_price'];
                        }
                     }


                  array_push($analyst,$val['analyst_status']);


                    $string_status = 'Verified Clear';
               if (in_array('0', $analyst)) {  
                    $string_status = 'Verified Pending'; 
                }else if (in_array('1', $analyst)) { 
                    $string_status = 'Verified Pending'; 
                }else if (in_array('2', $analyst)) { 
                        $string_status = 'Verified Clear'; 
                }else if (in_array('3', $analyst)) { 
                        $string_status = 'Insufficiency'; 
                }else if (in_array('4', $analyst)) { 
                    $string_status = 'Verified Clear'; 
                }else if (in_array('5', $analyst)) { 
                        $string_status = 'Stop Check'; 
                }else if (in_array('6', $analyst)) { 
                        $string_status = 'Unable to Verify'; 
                }else if (in_array('7', $analyst)) { 
                        $string_status = 'Verified Discrepancy'; 
                    
                }else if (in_array('8', $analyst)) { 
                        $string_status = 'Client Clarification'; 
                }else if (in_array('9', $analyst)) { 
                    $string_status = 'Closed insufficiency'; 
                     

                }else if (in_array('10', $analyst)) { 
                    $string_status = 'QC-error';  
                      
                }
                  if (!array_key_exists($val['candidate_id'], $candidate_data)) {
                     $candidate_data[$val['candidate_id']] = array( 
                        'candidate_id' => $val['candidate_id'],
                        'segment' => $val['segment'],
                        'location' => $val['location'],
                        'father_name' => $val['father_name'],
                        'phone_number' => $val['phone_number'],
                        'employee_id' => $val['employee_id'],
                        'candidate_name' => $val['first_name'].' '.$val['last_name'],
                        'client_name' => $val['client_name'],
                        'case_submitted_date' => isset($val['candidate_details']['case_submitted_date'])?$val['candidate_details']['case_submitted_date']:$val['tat_start_date'],
                        'completed_date' =>isset($val['candidate_details']['report_generated_date'])?$val['candidate_details']['report_generated_date']:'',
                        $val['component_name'].' '.$val['formNumber']=>array('status'=>$string_status,'price'=>$price_value)
                     );

                     $client = $val['client_name'];
                     $client_id = $val['client_id'];
                  }else{
                    $candidate_data[$val['candidate_id']][$val['component_name'].' '.$val['formNumber']] = array('status'=>$string_status,'price'=>$price_value); 
                  }
                    if (!array_key_exists($val['component_name'].' '.$val['formNumber'], $data_array)) {
                     $data_array[$val['component_name'].' '.$val['formNumber']] = array($string_status);
                     $data_array_price[$val['component_name'].' '.$val['formNumber']] = array($price_value);
                    }else{
                     $data_array[$val['component_name'].' '.$val['formNumber']] = array_merge($data_array[$val['component_name'].' '.$val['formNumber']],array($string_status));
                     $data_array_price[$val['component_name'].' '.$val['formNumber']] = array_merge($data_array[$val['component_name'].' '.$val['formNumber']],array($price_value));
                    }

                 }

               

                array_push($analyst_data,$string_status);

                 // array_push($data_array,$case_array);
            }

            $objPHPExcel = new Spreadsheet();

              // create file name
            $fileName = 'component-finance-report-'.time().'.xlsx';   
             
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[0] .'1', 'Sr.no.');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[1] .'1', 'Submitted On');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[2] .'1', 'Client Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[3] .'1', 'Candidate Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[4] .'1', 'Case Id');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[5] .'1', 'Case Status');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[6] .'1', 'Completion Date');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[7] .'1', 'Segment');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[8] .'1', 'Employee ID');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[9] .'1', 'Location');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[10] .'1', 'Father Name');      
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[11] .'1', 'Mobile Number');  

             $key_array = array();
                        $n = 12;
                        foreach ($data_array as $key => $value) {
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$n++] .'1', str_replace(" "," ",$key).' Status'); 
                            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$n++] .'1', str_replace(" "," ",$key).' Price');  
                           array_push($key_array,$key);
                        }
                        $count =array();
                        if (isset($finance_row['created_fields'])) {
                           $count = explode(',', $finance_row['created_fields']);
                           foreach ($count as $f => $fvalue) { 
                              $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$n++] .'1', $fvalue);  
                           }
                        }    
      


            // set Row
            $rowCount = 2;
            $i =1;
            if (count($candidate_data) > 0) {  
                     $init = 0;
                     foreach ($candidate_data as $k => $val) {
                     $n=0;
            $alphabet = $this->utilModel->return_excel_val(); 
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $i++);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['case_submitted_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['client_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['candidate_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['candidate_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $analyst_data[$init]);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['completed_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['segment']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['employee_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['location']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['father_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $val['phone_number']);
                 $a = 0;
                        foreach ($key_array as $key => $value) { 
                           $fields_id = isset($val[$value]['status'])?$val[$value]['status']:' '; 
                           $fields_id1 = isset($val[$value]['price'])?$val[$value]['price']:' ';
                             $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $fields_id);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, $fields_id1);
                           
                        }
                        if (count($count) > 0) {
                        if (isset($finance_row['fields_data'])) {
                            
                        }else{
                            
                            foreach ($count as $c => $cvalue) {
                              $str = str_replace(' ','_',$cvalue); 
                                 $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$n++] . $rowCount, '');
                               }   
                           }
                        }

                         
                        $init++;
                $rowCount++;
            }
            }
              
     
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
            // download file
            // header("Content-Type: application/vnd.ms-excel");
            // redirect(base_url().'uploads/report/'.$fileName);  

            echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));


    }


}
