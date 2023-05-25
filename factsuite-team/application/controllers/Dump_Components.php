<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
class Dump_Components extends CI_Controller {
    
    function __construct()  
    {
      parent::__construct();
      $this->load->database();
      $this->load->helper('url');   
      $this->load->model('adminViewAllCaseModel');
      $this->load->model('utilModel');
      $this->load->model('common_User_Filled_Details_Component_Error_Model');
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
        }else if($this->input->post('duration') == 'all') {
            $mis = $this->db->order_by('report_id','DESC')->get('mis-reports')->row_array();
            if ($mis !=null) {
                echo json_encode(array('filename' =>$mis['report_link'] ,'path' =>base_url().'../uploads/report/'.$mis['report_link']));
                exit();
            }else{

             // $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
            }
        }else{
           $where = ""; 
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
                     $analyst_status_data = array();
                     $output_data = array();
        foreach ($data as $key => $value) {

 
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']);
              
             $analyst = array();
             $outputqc = array();
                // $case_array = array();
             $input_status = 0;
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
                           
                            $status = 'Closed Insufficiency';
                            
                        }else if ($val['analyst_status'] == '10'){
                            $status = 'QC Error'; 
                         
                        }else if ($val['analyst_status'] == '11'){
                            $status = 'Insuff Clear';  
                        }
                    array_push($analyst,$val['analyst_status']);
                     array_push($outputqc,$val['output_status']);

                          $inputQcStatus = '';
                        if ($val['status'] == '0') {
                             $input_status = 1;
                            $inputQcStatus = 'Not initiated';
                        } else if ($val['status'] == '1') {
                            $inputQcStatus = 'In Progress';
                        } else if ($val['status'] == '2') {
                            $inputQcStatus = 'Completed';
                        } else if ($val['status']== '3') {
                            $inputQcStatus = 'Insufficiency';
                        } else if ($val['status'] == '4') {
                            $inputQcStatus = 'Verified Clear';
                        } else if ($val['status'] == '5') {
                            $inputQcStatus = 'Stop Check';
                        } else if ($val['status'] == '6') {
                            $inputQcStatus = 'Unable to verify';
                        } else if ($val['status'] == '7') {
                            $inputQcStatus = 'Verified discrepancy';
                        } else if ($val['status'] == '8') {
                            $inputQcStatus = 'Client clarification';
                        } else if ($val['status'] == '9') {
                            $inputQcStatus = 'Closed Insufficiency';
                        }else{
                             $inputQcStatus = 'Not initiated'; 
                        }
                          


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

                            $output ='Pending';
                            if($val['output_status'] == '1') {
                                $output = 'Approved' ;
                            } else if($val['output_status'] == '2') {
                                $output = 'Rejected';
                            } 



                    $component = $val['component_name'].' '.$val['formNumber'];
                    $components = $val['component_name'].' '.$val['formNumber'];
                    if (in_array($val['component_id'], [3,4,7])) {
                        $component = $val['value_type'];
                    }else if ($val['component_id'] == 6) {
                            // $employment = $this->db->where('candidate_id',$val['candidate_id'])->get('current_employment')->row_array();
                            $employment =  $val['tables'];
                             $component =  isset($employment['company_name'])?$employment['company_name']:'-';
                    }else if($val['component_id'] == 10){
                            //  $employment = $this->db->where('candidate_id',$val['candidate_id'])->get('previous_employment')->row_array();
                            $employment =  $val['tables'];
                             $components =  'Previous Employment Organization Name '.$val['formNumber'];
                             if ($employment !=null) {  
                              $company_name = json_decode($employment['company_name'],true);
                              $component = isset($company_name[$val['position']]['company_name'])?$company_name[$val['position']]['company_name']:'-';
                             }
                    }else  if (in_array($val['component_id'], ['8','9','12'])) {

                            if ($val['component_id'] == '8') {
                                $address_tbl =  $val['tables'];
                            //    $address_tbl = $this->db->where('candidate_id',$val['candidate_id'])->get('present_address')->row_array(); 
                            }else if ($val['component_id'] == '9') {
                               $address_tbl =  $val['tables'];
                            //    $address_tbl = $this->db->where('candidate_id',$val['candidate_id'])->get('permanent_address')->row_array();
                            }else{ 
                                $addr =  $val['tables'];
                                // $addr = $this->db->where('candidate_id',$val['candidate_id'])->get('previous_address')->row_array();
     
                                $street_p = json_decode(isset($addr['street'])?$addr['street']:'',true); 
                                $area_p = json_decode(isset($addr['area'])?$addr['area']:'',true); 
                                $city_p = json_decode(isset($addr['city'])?$addr['city']:'',true); 
                                $pin_code_p = json_decode(isset($addr['pin_code'])?$addr['pin_code']:'',true);  
                                $states_p = json_decode(isset($addr['state'])?$addr['state']:'',true);  
                            }

                            if ($val['component_id'] != '12') {
                                $street =  isset($address_tbl['street'])?$address_tbl['street']:'-';
                                $area =  isset($address_tbl['area'])?$address_tbl['area']:'-';
                                $city =  isset($address_tbl['city'])?$address_tbl['city']:'-';
                                $pin_code =  isset($address_tbl['pin_code'])?$address_tbl['pin_code']:'-'; 
                                $state =  isset($address_tbl['state'])?$address_tbl['state']:'-';  

                                $component = $street.' '.$area.' '.$city.' '.$state.' -'.$pin_code;

                               
                            }else{
                                $street =  isset($street_p[$val['position']]['street'])?$street_p[$val['position']]['street']:'-';
                                $area =  isset($area_p[$val['position']]['area'])?$area_p[$val['position']]['area']:'-';
                                $city =  isset($city_p[$val['position']]['city'])?$city_p[$val['position']]['city']:'-';
                                $pin_code =  isset($pin_code_p[$val['position']]['pin_code'])?$pin_code_p[$val['position']]['pin_code']:'-'; 
                                $state =  isset($state_p[$val['position']]['state'])?$state_p[$val['position']]['state']:'-'; 
                                $country =  isset($country_p[$val['position']]['country'])?$country_p[$val['position']]['country']:'-';   
                                $component = $street.' '.$area.' '.$city.' '.$state.' -'.$pin_code;
                            }

                        }

                      
                    $vendor_where = array(
                        'index_no'=>$val['position'],
                        'case_id'=>$val['candidate_id'],
                        'component_id'=>$val['component_id'],
                    );
                    $vendor = $this->db->where($vendor_where)->select('vendor.vendor_name,assign_case_to_vendor.created_date AS assigned_to_vendor_date')->from('assign_case_to_vendor')->join('vendor','assign_case_to_vendor.vendor_id = vendor.vendor_id','left')->order_by('assign_case_to_vendor.assign_id','DESC')->get()->row_array();

                    $report = 'No';
                    if ($value['is_report_generated'] =='1') {
                       $report = 'Yes';
                    }

                    if (!array_key_exists($val['candidate_id'], $candidate_data)) {
                        $candidate_data[$val['candidate_id']] = array( 
                            'candidate_id' => $val['candidate_id'],
                            'segment' => $segment,
                            'report' => $report,
                            'location' => isset($val['location'])?$val['location']:'',
                            'father_name' => $val['father_name'],
                            'date_of_birth' => $val['date_of_birth'],
                            'phone_number' => $val['phone_number'],
                            'employee_id' => $val['employee_id'],
                            'email' => $val['email_id'],
                            'csm' => $val['csm'],
                            'tat' => $val['left_tat_days'],
                            'client_remarks' => $val['remark'],
                            'package_name' => $val['package_name'],
                            'candidate_name' => $val['first_name'].' '.$val['last_name'],
                            'client_name' => $val['client_name'],
                            'candidate_alt_number' => '-',
                            'client_last_name' => '-', 
                            'spoc_name' => $val['spoc_name'],
                            'priority' => $priority,
                            'status' => $inputQcStatus,
                            'output' => $output,
                            'qc_name' => isset($val['qc_name'])?$val['qc_name']:'',
                            'qc_date' => isset($value['assigned_outputqc_date'])?$value['assigned_outputqc_date']:'',
                            'inputqc'=>isset($val['inputq'])?$val['inputq']:'',
                            'open_component' => array(),
                            'insuff_component' => array(),
                            'case_submitted_date' => $this->utilModel->get_actual_date_formate_hifun(isset($val['case_submitted_date'])?$val['case_submitted_date']:''),
                            'completed_date' =>$this->utilModel->get_actual_date_formate_hifun(isset($val['report_generated_date'])?$val['report_generated_date']:''),
                            $components=>array(
                                'status'=>$status,
                                'component_name'=>$component,
                                'created_date'=>$this->utilModel->get_actual_date_formate_hifun(isset($val['tables']['created_date'])?$val['tables']['created_date']:''),
                                'insuff_created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_created_date']),
                                'insuff_close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_close_date']), 
                                'inputqc_status_date'=>$this->utilModel->get_actual_date_formate_hifun($val['inputqc_status_date']), 
                                'insuff_closure_remarks'=>$val['insuff_closure_remarks'], 
                                'verification_remarks'=>$val['verification_remarks'], 
                                'progress_remarks'=>$val['progress_remarks'], 
                                'close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['analyst_status_date']), 
                                'formNumber'=>$val['formNumber'], 
                                'assigned_to'=>$val['assigned_team_name'], 
                                'vendor_name' => isset($vendor['vendor_name'])?$vendor['vendor_name']:'-', 
                                'vendor_date' => isset($vendor['assigned_to_vendor_date'])?$vendor['assigned_to_vendor_date']:'-', 
                            )
                        ); 
                        $client = $val['client_name'];
                        $client_id = $val['client_id'];
                    }else{
                        $candidate_data[$val['candidate_id']][$components] = array(
                            'status'=>$status,
                            'component_name'=>$component,
                            'created_date'=>$this->utilModel->get_actual_date_formate_hifun(isset($val['tables']['created_date'])?$val['tables']['created_date']:''),
                            'insuff_created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_created_date']),
                            'insuff_close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_close_date']), 
                            'inputqc_status_date'=>$this->utilModel->get_actual_date_formate_hifun($val['inputqc_status_date']), 
                            'insuff_closure_remarks'=>$val['insuff_closure_remarks'], 
                            'verification_remarks'=>$val['verification_remarks'], 
                            'progress_remarks'=>$val['progress_remarks'], 
                            'close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['analyst_status_date']), 
                            'formNumber'=>$val['formNumber'], 
                            'assigned_to'=>$val['assigned_team_name'],
                            'vendor_name' => isset($vendor['vendor_name'])?$vendor['vendor_name']:'-', 
                            'vendor_date' => isset($vendor['assigned_to_vendor_date'])?$vendor['assigned_to_vendor_date']:'-', 
                        ); 
                  }


                    $comp ='';
                    if (in_array($val['analyst_status'],[0,1])) {
                        $comp = $val['component_name'];
                    }
                    $compInsuff = '';
                    if (in_array($val['analyst_status'],[3])) {
                        $compInsuff = $val['component_name'];
                    }
                    $candidate_data[$val['candidate_id']]['open_component'] = array_merge($candidate_data[$val['candidate_id']]['open_component'],array($comp));
                    $candidate_data[$val['candidate_id']]['insuff_component'] = array_merge($candidate_data[$val['candidate_id']]['insuff_component'],array($compInsuff));

                    if (!array_key_exists($components, $data_array)) {
                     $data_array[$components] = array($status); 
                    }else{
                     $data_array[$components] = array_merge($data_array[$components],array($status)); 
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
                     }else if($input_status ==1 && $value['is_submitted'] =='1'){
                        $verifiy_img = "Form Filled";  
                        $verifiy_status = "Form Filled";  
                     }else if (in_array('7', $analyst)) {

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
                        $verifiy_status = "Verified Clear"; 
                        if ($value['is_submitted'] =='2') { 
                        $verifiy_img = "Verified Clear"; 
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
                    $analyst_status_data[$value['candidate_id']] = $verifiy_status;
                     $output_status = "Pending";
                    if (in_array('2',$outputqc)) {
                        $output_status = "Rejected";
                    }else if (in_array('0',$outputqc)) {
                         $output_status = "Pending";
                     }else if (in_array('1',$outputqc)) {
                        $output_status = "Approved";
                    }
                    $output_data[$value['candidate_id']] = $output_status;
                    
        }
        // echo '<pre>';
        // print_r($analyst_data);
        // exit;
         $num = 0;

            // create file name
            $fileName = 'general-component-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet(); 
           
            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'SL No');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Start Date');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Id');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Name');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Father Name');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'DOB');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Employee ID');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate E-Mail Id'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Contact Number'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Alt Number'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'CSM Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Package Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'End Client Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Initiation person Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Location'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Priority'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Input Case Status'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Open Components'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff components'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Input Qc Name'); 
            
           
                $key_array = array();
            if (count($data_array)) { 
                foreach ($data_array as $key => $value) {
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', $key);
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Initiated date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Closed date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component Status'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff raised date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff close date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'In Progress remarks'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verification remarks'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Clarification remarks'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff remarks'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'No of Forms'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Assigned To');
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Name');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Initiated Date');  
                   array_push($key_array,$key);
                // $num++;
                }
            }

             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Final Analyst / Specialist Status'); 
             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Final Case Status'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case closure Date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Internal case TAT'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'OutputQc Status'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'OutputQc Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'OutputQc Assigned Date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'OutputQc completed date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Report Generated Status'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Interim report generation date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'No of Interim reports downloaded'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'case reopend date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'case reopend closure date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num].'1', 'Re-open component'); 
          
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
            if (count($candidate_data) > 0) {  
                     $init = 0;
                     $next = 0;
                     foreach ($candidate_data as $k => $val) {
                        
                        $ana_status = isset($analyst_data[$val['candidate_id']])?$analyst_data[$val['candidate_id']]:'';
                        $analyst_s = isset($analyst_status_data[$val['candidate_id']])?$analyst_status_data[$val['candidate_id']]:'';
                        $output_datas = isset($output_data[$val['candidate_id']])?$output_data[$val['candidate_id']]:'';
                        $next++;
                        $objPHPExcel->getActiveSheet()
                            ->getStyle('A'.$rowCount.':'.$alphabet[$num].$rowCount)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(Border::BORDER_MEDIUM)
                            ->getColor()
                            ->setRGB('000000'); 
                            $num = 0;
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, (++$init));
                        if ($val['case_submitted_date'] !='' && $val['case_submitted_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $case_submitted_date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['case_submitted_date']);  
                            
                        }else{
                            $case_submitted_date = '-';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $case_submitted_date); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_id']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['father_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['date_of_birth']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['employee_id']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['email']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['phone_number']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['csm']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_remarks']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['package_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['spoc_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['location']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['priority']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['status']);   
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $this->get_array($val['open_component'])); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $this->get_array($val['insuff_component']));
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount,  $val['inputqc']); 

                         
                        foreach ($key_array as $key1 => $value) { 
                            $fields_id = isset($val[$value]['component_name'])?$val[$value]['component_name']:''; 
                            $fields_id1 = isset($val[$value]['created_date'])?$val[$value]['created_date']:' ';
                            $fields_id2 = isset($val[$value]['close_date'])?$val[$value]['close_date']:' ';
                            $fields_id3 = isset($val[$value]['status'])?$val[$value]['status']:'';
                            $fields_id4 = isset($val[$value]['insuff_created_date'])?$val[$value]['insuff_created_date']:' ';
                            $fields_id5 = isset($val[$value]['insuff_close_date'])?$val[$value]['insuff_close_date']:' ';
                            $fields_id6 = isset($val[$value]['progress_remarks'])?$val[$value]['progress_remarks']:' ';
                            $fields_id7 = isset($val[$value]['verification_remarks'])?$val[$value]['verification_remarks']:' ';
                            $fields_id8 = ' ';
                            $fields_id9 = isset($val[$value]['insuff_closure_remarks'])?$val[$value]['insuff_closure_remarks']:' ';
                            $assign_to = isset($val[$value]['assigned_to'])?$val[$value]['assigned_to']:' ';
                            $fields_id10 = isset($val[$value]['formNumber'])?$val[$value]['formNumber']:' ';
                            $vendor_name = isset($val[$value]['vendor_name'])?$val[$value]['vendor_name']:''; 
                            $vendor_date = isset($val[$value]['vendor_date'])?$val[$value]['vendor_date']:''; 
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id);
                            if (!empty($fields_id) && !empty($fields_id3) && $fields_id1 !='' && $fields_id1 !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $created_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($fields_id1);  
                                
                            }else{
                                $created_date_cell = '-';
                            }
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $created_date_cell);

                            if (!empty($fields_id) && !empty($fields_id3) && $fields_id2 !='' && $fields_id2 !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($fields_id2);  
                                
                            }else{
                                $close_date_cell = '-';
                            }
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $close_date_cell);
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id3);
                            if (!empty($fields_id) && !empty($fields_id3) && $fields_id4 !='' && $fields_id4 !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $insuff_created_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($fields_id4);  
                                
                            }else{
                                $insuff_created_date_cell = '-';
                            }
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $insuff_created_date_cell);
                            if (!empty($fields_id) && !empty($fields_id3) && $fields_id5 !='' && $fields_id5 !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $insuff_close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($fields_id5);  
                                
                            }else{
                                $insuff_close_date_cell = '-';
                            }
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $insuff_close_date_cell);
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id6);
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id7);
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id8);
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id9);
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id10); 
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $assign_to); 
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $vendor_name);
                            if (!empty($vendor_name) && !empty($fields_id3) && $vendor_date !='' && $vendor_date !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $vendor_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($vendor_date);  
                                
                            }else{
                                $vendor_date_cell = '-';
                            } 
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $vendor_date_cell); 
                           
                        }

                        $color_code = '62c4ff';
                        if ($analyst_s == 'In Progress') {
                            // code...
                        }
                        if ($analyst_s == 'Not Initiated') {
                            // code...
                        }
                        if ($analyst_s == 'Verified Discrepancy') {
                          $color_code = 'ec0000';
                        }
                        if ($analyst_s == 'Closed insufficiency') {
                           $color_code = 'FFD4AE';
                        }
                        if ($analyst_s == 'Unable to Verify') {
                          $color_code = 'FFD4AE';
                        }
                        if ($analyst_s == 'Insufficiency') {
                            // code...
                        }
                        if ($analyst_s == 'Verified Clear') {
                           $color_code = 'C5FCB4';
                        }
                        if ($analyst_s == 'Client Clarification') {
                            // code...
                        }
                        if ($analyst_s == 'Qc Error') {
                           $color_code = 'ec0000';
                        }
                        if ($analyst_s == 'Stop Check') {
                           $color_code = '62c4ff';
                        }
                         $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num].$rowCount) 
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB($color_code); 
                       
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $analyst_s);

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
                        if ($val['completed_date'] !='' && $val['completed_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $completed_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['completed_date']);  
                            
                        }else{
                            $completed_date_cell = '-';
                        }

                        if (in_array($ana_status, ['Not initiated','In Progress','Insufficiency','Pending'])) {
                            $completed_date_cell = '-';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $completed_date_cell); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['tat']);
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $output_datas);  
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['qc_name']);  
                         if ($val['qc_date'] !='' && $val['qc_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $qc_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['qc_date']);  
                            
                        }else{
                            $qc_date_cell = '-';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $qc_date_cell);  
                        if ($val['completed_date'] !='' && $val['completed_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $completed_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['completed_date']);  
                            
                        }else{
                            $completed_date_cell = '-';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $completed_date_cell);
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['report']);
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num] . $rowCount, '-');  
                        $rowCount++;
                    }
                    
                  }

                                    
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
                if (!$this->input->post('duration')) {
                   $data_mis = array(
                    'report_name'=>"General Report",
                    'report_link'=>$fileName
                   );
                   $this->db->insert('mis-reports',$data_mis);
                }

                  echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
 
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


    function get_analyst_status($candidate_id){
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
                
            array_push($analystStatusArray, $statusValue);
            }  

             
        } 

        return $analystStatusArray;
    }

    /*component other checks */

    function other_checks_component(){
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
        }else{
             // $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        }
        $data = $this->db->query('SELECT * FROM candidate '.$where.' ')->result_array();
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

            $ana_status = $this->get_analyst_status($value['candidate_id']);


               

                     $verifiy_img = 'In Progress'; 
                     $verifiy_status = 'In Progress'; 

                     if (in_array('0', $ana_status)) {
                         $verifiy_img = 'Not Initiated';
                         $verifiy_status = 'Not Initiated';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('1', $ana_status)){
                         $verifiy_img = 'In Progress';
                         $verifiy_status = 'In Progress';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('8', $ana_status)){
                         $verifiy_img = 'Client Clarification';
                         $verifiy_status = 'Client Clarification';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        } 
                     }else if(in_array('3', $ana_status)){
                        $verifiy_img = "Insufficiency";  
                        $verifiy_status = "Insufficiency";  
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('11', $ana_status)){
                        $verifiy_img = "Insuff Clear";  
                        $verifiy_status = "Insuff Clear";  
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if (in_array('7', $ana_status)) {

                        $verifiy_img = "Verified Discrepancy"; 
                        $verifiy_status = "Verified Discrepancy"; 
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    }else if(array_intersect(['6','9'], $ana_status)){
                         if (in_array('6',$ana_status)) {
                            $verifiy_img = "Unable to Verify"; 
                            $verifiy_status = "Unable to Verify"; 
                        }else if (in_array('9',$ana_status)) { 
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
                    }*/else if(in_array('4', $ana_status)){ 
                        $verifiy_status = "Verified Clear"; 
                        if ($value['is_submitted'] =='2') { 
                        $verifiy_img = "Verified Clear"; 
                        }else if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress"; 
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated"; 
                        }
                    } else if(in_array('5', $ana_status)){
                        $verifiy_img = "Stop Check"; 
                        $verifiy_status = "Stop Check"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    }else if(in_array('10', $ana_status)){
                        $verifiy_img = "Qc Error"; 
                        $verifiy_status = "Qc Error"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    } 

             
             $analyst = array();
                // $case_array = array();
                foreach ($cases as $k => $val) { 
                    if (!in_array($val['analyst_status'], ['6','7','8','9','10','11','12'])) { 
                      
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
                           
                            $status = 'Closed Insufficiency';
                            
                        }else if ($val['analyst_status'] == '10'){
                            $status = 'QC Error'; 
                         
                        }else if ($val['analyst_status'] == '11'){
                            $status = 'Insuff Clear';  
                        }


                          $inputQcStatus = '';
                        if ($val['status'] == '0') {
                            $inputQcStatus = 'Not initiated';
                        } else if ($val['status'] == '1') {
                            $inputQcStatus = 'In Progress';
                        } else if ($val['status'] == '2') {
                            $inputQcStatus = 'Completed';
                        } else if ($val['status']== '3') {
                            $inputQcStatus = 'Insufficiency';
                        } else if ($val['status'] == '4') {
                            $inputQcStatus = 'Verified Clear';
                        } else if ($val['status'] == '5') {
                            $inputQcStatus = 'Stop Check';
                        } else if ($val['status'] == '6') {
                            $inputQcStatus = 'Unable to verify';
                        } else if ($val['status'] == '7') {
                            $inputQcStatus = 'Verified discrepancy';
                        } else if ($val['status'] == '8') {
                            $inputQcStatus = 'Client clarification';
                        } else if ($val['status'] == '9') {
                            $inputQcStatus = 'Closed Insufficiency';
                        }
                          

                         $segment ='';
                            if($val['segment'] == '1'){
                                    $segment = 'Fresher' ;
                            }else if($val['segment'] == '2'){  
                                    $segment = 'Mid Level' ;
                            }else if($val['segment'] == '3'){  
                                    $segment = 'Senior Level' ;
                                  
                            }



                              $component = $val['component_name'].' '.$val['formNumber'];
                    if (in_array($val['component_id'], [3,4,7])) {
                        $component = $val['value_type']; 
                    }

                    array_push($analyst,$val['analyst_status']);
                    if (! in_array($val['component_id'],[6,7,8,9,10,11,12])) {
                     
                        $priority ='';
                            if($val['priority'] == '0') {
                                $priority = 'Low priority' ;
                            } else if($val['priority'] == '1') {
                                $priority = 'Medium priority';
                            } else if($val['priority'] == '2') {
                                $priority = 'High priority';
                            }
                             $where = array(
                                'index_no'=>$val['position'],
                                'case_id'=>$val['candidate_id'],
                                'component_id'=>$val['component_id'],
                        );

                $vendor = $this->db->where($where)->select('vendor.vendor_name,assign_case_to_vendor.created_date AS assigned_to_vendor_date')->from('assign_case_to_vendor')->join('vendor','assign_case_to_vendor.vendor_id = vendor.vendor_id','left')->order_by('assign_case_to_vendor.assign_id','DESC')->get()->row_array();


                 $address = '';
                     $gender = ''; 
                     if ($val['component_id'] =='2') {
                        // print_r($cases['tables']);
                       $addr = json_decode(isset($val['tables']['address'])?$val['tables']['address']:'',true);  
                       // $gend = json_decode(isset($val['tables']['gender'])?$val['tables']['gender']:'',true);  

                       $address = isset($addr[$val['position']]['address'])?$addr[$val['position']]['address']:'';
                       // $gender = isset($gend[$val['position']]['gender'])?$addr[$val['position']]['gender']:'';
                     }else if ($val['component_id'] =='17') {
                         $addr = isset($val['tables']['credit_state'])?$val['tables']['credit_state']:'';  
                          $address = $addr;
                     }
                     // exit();


                      if (!array_key_exists($val['candidate_id'], $candidate_data)) {
                     $candidate_data[$val['candidate_id']] = array( 
                        'candidate_id' => $val['candidate_id'],
                        'segment' => $segment,
                        'location' => isset($val['location'])?$val['location']:'',
                        'father_name' => $val['father_name'],
                        'date_of_birth' => $val['date_of_birth'],
                        'phone_number' => $val['phone_number'],
                        'employee_id' => $val['employee_id'],
                        'gender' => $val['gender'],
                        'email' => $val['email_id'],
                        'csm' => $val['csm'],
                        'tat' => $val['left_tat_days'],
                        'client_remarks' => $val['remark'],
                        'package_name' => $val['package_name'],
                        'candidate_name' => $val['first_name'].' '.$val['last_name'],
                        'client_name' => $val['client_name'],
                        'candidate_alt_number' => '-',
                        'client_last_name' => '-', 
                        'spoc_name' => $val['spoc_name'],
                        'priority' => $priority,
                        'status' => $inputQcStatus,
                        'final_status'=>$verifiy_img,
                         'open_component' => array(),
                        'insuff_component' => array(),
                        'case_submitted_date' => $this->utilModel->get_actual_date_formate_hifun(isset($val['case_submitted_date'])?$val['case_submitted_date']:''),
                        'completed_date' =>$this->utilModel->get_actual_date_formate_hifun(isset($val['report_generated_date'])?$val['report_generated_date']:''),
                        $component=>array(
                            'address'=>$address,
                            'gender'=>$gender,
                            'status'=>$status,
                            'inputQcStatus'=>$inputQcStatus,
                            'created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['created_date']),
                            'insuff_created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_created_date']),
                            'insuff_close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_close_date']), 
                            'inputqc_status_date'=>$this->utilModel->get_actual_date_formate_hifun($val['inputqc_status_date']), 
                             'insuff_remarks'=>$val['insuff_remarks'], 
                            'insuff_closure_remarks'=>$val['insuff_closure_remarks'], 
                            'verification_remarks'=>$val['verification_remarks'], 
                            'progress_remarks'=>$val['progress_remarks'], 
                            'close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['analyst_status_date']), 
                            'formNumber'=>$val['formNumber'],
                             'assigned_team_name' => isset($val['assigned_team_name'])?$val['assigned_team_name']:'-', 
                            'vendor_name' => isset($vendor['vendor_name'])?$vendor['vendor_name']:'-', 
                        'vendor_date' => isset($vendor['assigned_to_vendor_date'])?$vendor['assigned_to_vendor_date']:'-',  
                        )
                     );
                     
                     $client = $val['client_name'];
                     $client_id = $val['client_id'];
                  }else{
                    $candidate_data[$val['candidate_id']][$component] = array(
                            'address'=>$address,
                            'gender'=>$gender,
                            'status'=>$status,
                            'inputQcStatus'=>$inputQcStatus,
                            'created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['created_date']),
                            'insuff_created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_created_date']),
                            'insuff_close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_close_date']), 
                            'inputqc_status_date'=>$this->utilModel->get_actual_date_formate_hifun($val['inputqc_status_date']), 
                            'insuff_closure_remarks'=>$val['insuff_closure_remarks'], 
                            'insuff_remarks'=>$val['insuff_remarks'], 
                            'verification_remarks'=>$val['verification_remarks'], 
                            'progress_remarks'=>$val['progress_remarks'], 
                            'close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['analyst_status_date']), 
                            'formNumber'=>$val['formNumber'], 
                            'assigned_team_name' => isset($val['assigned_team_name'])?$val['assigned_team_name']:'-', 
                            'vendor_name' => isset($vendor['vendor_name'])?$vendor['vendor_name']:'-', 
                            'vendor_date' => isset($vendor['assigned_to_vendor_date'])?$vendor['assigned_to_vendor_date']:'-', 
                        ); 
                  }

                   $comp ='';
                    if (in_array($val['analyst_status'],[0,1])) {
                        $comp = $val['component_name'];
                    }
                    $compInsuff = '';
                    if (in_array($val['analyst_status'],[3])) {
                        $compInsuff = $val['component_name'];
                    }
                    $candidate_data[$val['candidate_id']]['open_component'] = array_merge($candidate_data[$val['candidate_id']]['open_component'],array($comp));
                    $candidate_data[$val['candidate_id']]['insuff_component'] = array_merge($candidate_data[$val['candidate_id']]['insuff_component'],array($compInsuff));

                    if (!array_key_exists($component, $data_array)) {
                     $data_array[$component] = array($status); 
                    }else{
                     $data_array[$component] = array_merge($data_array[$component],array($status)); 
                    }




                }


                }
                }
                /*END IF*/



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

        /*export start */


         $num = 0;

            // create file name
            $fileName = 'other-checks-component-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            $al = count($data_array)+9;
            
            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'SL No');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Start Date');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Id');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Name');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Father Name');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'DOB');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Gender');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Employee ID');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate E-Mail Id'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Contact Number');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Package Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Segment Name');   
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Priority');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Final Status');
             /*
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Input Case Status'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Open Components'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff components'); */
            
           
                $key_array = array();
            if (count($data_array)) { 
                foreach ($data_array as $key => $value) {


                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', $key);

                   if (array_intersect(explode(' ', strtolower($key)),['court','cibil'])) {
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Address'); 
                       // $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Gender'); 
                   }
                    if (array_intersect(explode(' ', strtolower($key)),['cibil','global'])) {
                       // $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Address'); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Gender'); 
                   }
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Initiated date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'InputQc Status');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff raised date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff close date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff Remarks'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'No of Forms'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'In Progress remarks'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verification remarks');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Internal TAT');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component closure date');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Assigned To');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Name');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Initiated Date');  
                   array_push($key_array,$key);
                // $num++;
                }
            }

             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Last Edited By with date & time'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case re-open date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case re-open closed date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num].'1', 'component name re-open'); 
          
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
                $num = 0;
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, (++$init));
                       if ($val['case_submitted_date'] !='' && $val['case_submitted_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $case_submitted_date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['case_submitted_date']);  
                            
                        }else{
                            $case_submitted_date = '-';
                        } 
                        $gender = isset($val['gender'])?$val['gender']:'-';
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $case_submitted_date); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_id']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['father_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['date_of_birth']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $gender); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['employee_id']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['email']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['phone_number']);  
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_remarks']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['package_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['segment']);   
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['priority']); 

                           $color_code = '62c4ff';
                        if ($val['final_status'] == 'In Progress') {
                            // code...
                        }
                        if ($val['final_status'] == 'Not Initiated') {
                            // code...
                        }
                        if ($val['final_status'] == 'Verified Discrepancy') {
                          $color_code = 'ec0000';
                        }
                        if ($val['final_status'] == 'Closed insufficiency') {
                           $color_code = 'FFD4AE';
                        }
                        if ($val['final_status'] == 'Unable to Verify') {
                          $color_code = 'FFD4AE';
                        }
                        if ($val['final_status'] == 'Insufficiency') {
                            // code...
                        }
                        if ($val['final_status'] == 'Verified Clear') {
                           $color_code = 'C5FCB4';
                        }
                        if ($val['final_status'] == 'Client Clarification') {
                            // code...
                        }
                        if ($val['final_status'] == 'Qc Error') {
                           $color_code = 'ec0000';
                        }
                        if ($val['final_status'] == 'Stop Check') {
                           $color_code = '62c4ff';
                        }
                         $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num].$rowCount) 
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB($color_code); 
                            
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['final_status']); 
                      
                        foreach ($key_array as $key1 => $value) { 
                           $fields_id = isset($val[$value]['status'])?$val[$value]['status']:' '; 
                           $inputQcStatus = isset($val[$value]['inputQcStatus'])?$val[$value]['inputQcStatus']:' '; 
                           $fields_id1 = isset($val[$value]['created_date'])?$val[$value]['created_date']:' ';
                           $fields_id2 = isset($val[$value]['close_date'])?$val[$value]['close_date']:' '; 
                           $fields_id4 = isset($val[$value]['insuff_created_date'])?$val[$value]['insuff_created_date']:' ';
                           $fields_id5 = isset($val[$value]['insuff_close_date'])?$val[$value]['insuff_close_date']:' ';
                           $fields_id6 = isset($val[$value]['insuff_remarks'])?$val[$value]['insuff_remarks']:' ';
                           $fields_id7 = isset($val[$value]['formNumber'])?$val[$value]['formNumber']:' ';
                           $fields_id8 = isset($val[$value]['progress_remarks'])?$val[$value]['progress_remarks']:' ';
                           $fields_id9 = isset($val[$value]['verification_remarks'])?$val[$value]['verification_remarks']:' ';
                           $tat = $val['tat'];
                           $assigned_team_name = isset($val[$value]['assigned_team_name'])?$val[$value]['assigned_team_name']:' '; 
                           $vendor_name = isset($val[$value]['vendor_name'])?$val[$value]['vendor_name']:' '; 
                           $vendor_date = isset($val[$value]['vendor_date'])?$val[$value]['vendor_date']:' '; 
                           $fields_id10 = ' ';
                            $fields_id11 = isset($val[$value]['close_date'])?$val[$value]['close_date']:' '; 
                             $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id);

                              if (array_intersect(explode(' ', strtolower($value)),['court','cibil'])) {
                                 $address = isset($val[$value]['address'])?$val[$value]['address']:' '; 
                                  // $gender1 = isset($val[$value]['gender'])?$val[$value]['gender']:' '; 
                                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++]. $rowCount, $address); 
                                   // $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++]. $rowCount, $gender1); 
                               }


                              if (array_intersect(explode(' ', strtolower($value)),['cibil','global'])) {  
                                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++]. $rowCount, $gender); 
                               }
                            if (!empty($fields_id )&& $fields_id1 !='' && $fields_id1 !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $fields_id1 = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($fields_id1);  
                                
                            }else{
                                $fields_id1 = '-';
                            } 
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id1);
                                
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $inputQcStatus);
                              if (!empty($fields_id )&& !empty($fields_id )&& $fields_id4 !='' && $fields_id4 !='-') {
                                    $objPHPExcel->getActiveSheet()
                                    ->getStyle($alphabet[$num] . $rowCount)
                                    ->getNumberFormat()
                                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                    $fields_id4 = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($fields_id4);  
                                    
                                }else{
                                    $fields_id4 = '-';
                                } 
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id4);
                            if (!empty($fields_id )&& $fields_id5 !='' && $fields_id5 !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $fields_id5 = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($fields_id5);  
                                
                            }else{
                                $fields_id5 = '-';
                            }
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id5);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id6);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id7);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id8);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id9);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $tat); 
                             if (!empty($fields_id )&& $fields_id11 !='' && $fields_id11 !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $fields_id11 = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($fields_id11);  
                                
                            }else{
                                $fields_id11 = '-';
                            }

                             if (in_array($fields_id, ['Not initiated','In Progress','Insufficiency','Pending'])) {
                                $fields_id11 = '-';
                            }
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fields_id11); 
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $assigned_team_name); 
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $vendor_name);
                            if ($vendor_date !='' && $vendor_date !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $vendor_date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($vendor_date);  
                                
                            }else{
                                $vendor_date = '-';
                            }
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $vendor_date); 
                           
                        }

  
                      
                      $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num] . $rowCount, '-');  
                        $rowCount++;
                     }
                    
                  }

                  echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
                                    
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);


 
    }


    function new_employment_report(){
        $alphabet = $this->utilModel->return_excel_val(); 
        $where = '';
        if ($this->input->post('duration') == 'today') {
            $where = " where date(created_date) = CURDATE() AND ( component_ids REGEXP 6 OR  component_ids REGEXP 10)";
        } else if($this->input->post('duration') == 'week') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() AND ( component_ids REGEXP 6 OR  component_ids REGEXP 10)";
        } else if($this->input->post('duration') == 'month') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() AND ( component_ids REGEXP 6 OR  component_ids REGEXP 10)";
        } else if($this->input->post('duration') == 'year') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE() AND ( component_ids REGEXP 6 OR  component_ids REGEXP 10)";
        } else if($this->input->post('duration') == 'between') {
            $where = " where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."' AND ( component_ids REGEXP 6 OR  component_ids REGEXP 10)";
        }else{
             $where = " where ( component_ids REGEXP 6 OR  component_ids REGEXP 10)";
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
            $ids = explode(',', $value['component_ids']);
            if (array_intersect([6,10], $ids)) { 
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id'],[6,10]); 

            $ana_status = $this->get_analyst_status($value['candidate_id']);


              
                     $verifiy_img = 'In Progress'; 
                     $verifiy_status = 'In Progress'; 

                     if (in_array('0', $ana_status)) {
                         $verifiy_img = 'Not Initiated';
                         $verifiy_status = 'Not Initiated';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('1', $ana_status)){
                         $verifiy_img = 'In Progress';
                         $verifiy_status = 'In Progress';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('8', $ana_status)){
                         $verifiy_img = 'Client Clarification';
                         $verifiy_status = 'Client Clarification';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        } 
                     }else if(in_array('3', $ana_status)){
                        $verifiy_img = "Insufficiency";  
                        $verifiy_status = "Insufficiency";  
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('11', $ana_status)){
                        $verifiy_img = "Insuff Clear";  
                        $verifiy_status = "Insuff Clear";  
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if (in_array('7', $ana_status)) {

                        $verifiy_img = "Verified Discrepancy"; 
                        $verifiy_status = "Verified Discrepancy"; 
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    }else if(array_intersect(['6','9'], $ana_status)){
                         if (in_array('6',$ana_status)) {
                            $verifiy_img = "Unable to Verify"; 
                            $verifiy_status = "Unable to Verify"; 
                        }else if (in_array('9',$ana_status)) { 
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
                    }*/else if(in_array('4', $ana_status)){ 
                        $verifiy_status = "Verified Clear"; 
                        if ($value['is_submitted'] =='2') { 
                        $verifiy_img = "Verified Clear"; 
                        }else if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress"; 
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated"; 
                        }
                    } else if(in_array('5', $ana_status)){
                        $verifiy_img = "Stop Check"; 
                        $verifiy_status = "Stop Check"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    }else if(in_array('10', $ana_status)){
                        $verifiy_img = "Qc Error"; 
                        $verifiy_status = "Qc Error"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    } 


             $analyst = array();
                // $case_array = array();
                foreach ($cases as $k => $val) {  
                       if (in_array($val['component_id'],$ids) && in_array($val['component_id'],[6,10])) { 
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
                           
                            $status = 'Closed Insufficiency';
                            
                        }else if ($val['analyst_status'] == '10'){
                            $status = 'QC Error'; 
                         
                        }else if ($val['analyst_status'] == '11'){
                            $status = 'Insuff Clear';  
                        }


                          $inputQcStatus = 'Not initiated';
                        if ($val['status'] == '0') {
                            $inputQcStatus = 'Not initiated';
                        } else if ($val['status'] == '1') {
                            $inputQcStatus = 'In Progress';
                        } else if ($val['status'] == '2') {
                            $inputQcStatus = 'Completed';
                        } else if ($val['status']== '3') {
                            $inputQcStatus = 'Insufficiency';
                        } else if ($val['status'] == '4') {
                            $inputQcStatus = 'Verified Clear';
                        } else if ($val['status'] == '5') {
                            $inputQcStatus = 'Stop Check';
                        } else if ($val['status'] == '6') {
                            $inputQcStatus = 'Unable to verify';
                        } else if ($val['status'] == '7') {
                            $inputQcStatus = 'Verified discrepancy';
                        } else if ($val['status'] == '8') {
                            $inputQcStatus = 'Client clarification';
                        } else if ($val['status'] == '9') {
                            $inputQcStatus = 'Closed Insufficiency';
                        }
                           $where = array(
                                'index_no'=>$val['position'],
                                'case_id'=>$val['candidate_id'],
                                'component_id'=>$val['component_id'],
                        );
                         
                         $vendor = $this->db->where($where)->select('vendor.vendor_name,assign_case_to_vendor.created_date AS assigned_to_vendor_date')->from('assign_case_to_vendor')->join('vendor','assign_case_to_vendor.vendor_id = vendor.vendor_id','left')->order_by('assign_case_to_vendor.assign_id','DESC')->get()->row_array();




                    array_push($analyst,$val['analyst_status']);
                    if (in_array($val['component_id'],['6','10'])) { 
                        if ($val['component_id'] == '6') {
                            // $employment = $this->db->where('candidate_id',$val['candidate_id'])->get('current_employment')->row_array();
                            $employment = $val['tables'];
                        }else{
                             // $employment = $this->db->where('candidate_id',$val['candidate_id'])->get('previous_employment')->row_array();
                             $employment = $val['tables'];
                             if ($employment !=null) { 
                               $desigination = json_decode($employment['desigination'],true);
                              $remark_department = json_decode($employment['remark_department'],true);
                              $department = json_decode($employment['department'],true);
                              $department = json_decode($employment['department'],true);
                              $employee_id = json_decode($employment['employee_id'],true);
                              $company_name = json_decode($employment['company_name'],true);
                              $address = json_decode($employment['address'],true);
                              $annual_ctc = json_decode($employment['annual_ctc'],true);
                              $reason_for_leaving = json_decode($employment['reason_for_leaving'],true);
                              $joining_date = json_decode($employment['joining_date'],true);
                              $relieving_date = json_decode($employment['relieving_date'],true);
                              $reporting_manager_name = json_decode($employment['reporting_manager_name'],true);
                              $reporting_manager_desigination = json_decode($employment['reporting_manager_desigination'],true);
                              $reporting_manager_contact_number = json_decode($employment['reporting_manager_contact_number'],true); 
                              $hr_name = json_decode($employment['hr_name'],true);
                              $hr_contact_number = json_decode($employment['hr_contact_number'],true);  
                              $remark_hr_name = json_decode($employment['remark_hr_name'],true); 
                              $company_urls = json_decode($employment['company_url'],true); 
                             }
                        }

                            $current_date = isset($employment['created_date'])?$employment['created_date']:'-';
                        if ($val['component_id'] == '6') {
                            $start = isset($employment['joining_date'])?$employment['joining_date']:'-';
                            $end = isset($employment['relieving_date'])?$employment['relieving_date']:'-';  
                             $desigination = isset($employment['desigination'])?$employment['desigination']:'-';  
                             $department = isset($employment['department'])?$employment['department']:'-';  
                             $employee_id = isset($employment['employee_id'])?$employment['employee_id']:'-'; 
                             $company =  isset($employment['company_name'])?$employment['company_name']:'-';
                             $addr =  isset($employment['address'])?$employment['address']:'-'; 
                             $ctc =  isset($employment['annual_ctc'])?$employment['annual_ctc']:'-';
                             $leave = isset($employment['reason_for_leaving'])?$employment['reason_for_leaving']:'-';
                             $manager = isset($employment['reporting_manager_name'])?$employment['reporting_manager_name']:'-'; 
                             $contact = isset($employment['reporting_manager_contact_number'])?$employment['reporting_manager_contact_number']:'-';  
                             $designation =  isset($employment['reporting_manager_desigination'])?$employment['reporting_manager_desigination']:'-';  
                             $hr_name = isset($employment['hr_name'])?$employment['hr_name']:'-';

                             $hr_contact = isset($employment['hr_contact_number'])?$employment['hr_contact_number']:'-';

                             $remark_date_of_relieving = isset($employment['remark_date_of_relieving'])?$employment['remark_date_of_relieving']:'-'; 
                             $remark_exit_status = isset($employment['remark_exit_status'])?$employment['remark_exit_status']:'-'; 
                             $remarks_designation = isset($employment['remarks_designation'])?$employment['remarks_designation']:'-'; 
                             $remark_department = isset($employment['remark_department'])?$employment['remark_department']:'-'; 
                             $remark_date_of_joining = isset($employment['remark_date_of_joining'])?$employment['remark_date_of_joining']:'-'; 
                             $remark_salary_lakhs = isset($employment['remark_salary_lakhs'])?$employment['remark_salary_lakhs']:'-'; 
                             $remark_salary_type = isset($employment['remark_salary_type'])?$employment['remark_salary_type']:'-'; 
                             $remark_currency = isset($employment['remark_currency'])?$employment['remark_currency']:'-'; 
                             $remark_eligible_for_re_hire = isset($employment['remark_eligible_for_re_hire'])?$employment['remark_eligible_for_re_hire']:'-'; 
                             $remark_hr_nam = isset($employment['remark_hr_name'])?$employment['remark_hr_name']:'-';  
                             $remark_hr_eml = isset($employment['remark_hr_email'])?$employment['remark_hr_email']:'-'; 
                             $verification_remarks = isset($employment['verification_remarks'])?$employment['verification_remarks']:'-'; 

                             $remark_hr_phone_no = isset($employment['remark_hr_phone_no'])?$employment['remark_hr_phone_no']:'-'; 

                             $remark_eligible_for_re_hire = isset($employment['remark_eligible_for_re_hire'])?$employment['remark_eligible_for_re_hire']:''; 
                             $remark_attendance_punctuality = isset($employment['remark_attendance_punctuality'])?$employment['remark_attendance_punctuality']:''; 
                             $remark_job_performance = isset($employment['remark_job_performance'])?$employment['remark_job_performance']:'-'; 
                             $remark_exit_status = isset($employment['remark_exit_status'])?$employment['remark_exit_status']:'-'; 
                             $remark_disciplinary_issues = isset($employment['remark_disciplinary_issues'])?$employment['remark_disciplinary_issues']:'-'; 
                             $company_url = isset($employment['company_url'])?$employment['company_url']:'-'; 
 
                        }else{
                        $remark_hr_nam = isset($remark_hr_name[$val['position']]['remark_hr_name'])?$remark_hr_name[$val['position']]['remark_hr_name']:'-';
                        $remark_hr_eml = isset($remark_hr_email[$val['position']]['remark_hr_email'])?$remark_hr_email[$val['position']]['remark_hr_email']:'-';
                        $verification_remark = isset($verification_remarks[$val['position']]['verification_remarks'])?$verification_remarks[$val['position']]['verification_remarks']:'-';
                                      

                        $start = isset($joining_date[$val['position']]['joining_date'])?$joining_date[$val['position']]['joining_date']:'-';
                        $end = isset($relieving_date[$val['position']]['relieving_date'])?$relieving_date[$val['position']]['relieving_date']:'-'; 
                         $desigination = isset($desigination[$val['position']]['desigination'])?$desigination[$val['position']]['desigination']:'-'; 
                         $department = isset($department[$val['position']]['department'])?$department[$val['position']]['department']:'-';
                         $remark_department = isset($remark_department[$val['position']]['remark_department'])?$remark_department[$val['position']]['remark_department']:'-';
                         $employee_id = isset($employee_id[$val['position']]['employee_id'])?$employee_id[$val['position']]['employee_id']:'-'; 
                         $company =  isset($company_name[$val['position']]['company_name'])?$company_name[$val['position']]['company_name']:'-';

                         $addr =  isset($address[$val['position']]['address'])?$address[$val['position']]['address']:'-';

                         $ctc =  isset($annual_ctc[$val['position']]['annual_ctc'])?$annual_ctc[$val['position']]['annual_ctc']:'-';
                         $leave = isset($reason_for_leaving[$val['position']]['reason_for_leaving'])?$reason_for_leaving[$val['position']]['reason_for_leaving']:'-';
                         $manager = isset($reporting_manager_name[$val['position']]['reporting_manager_name'])?$reporting_manager_name[$val['position']]['reporting_manager_name']:'-';
                         $contact = isset($reporting_manager_contact_number[$val['position']]['reporting_manager_contact_number'])?$reporting_manager_contact_number[$val['position']]['reporting_manager_contact_number']:'-';  
                         $designation =  isset($reporting_manager_desigination[$val['position']]['reporting_manager_desigination'])?$reporting_manager_desigination[$val['position']]['reporting_manager_desigination']:'-'; 
                         $hr_name = isset($hr_name[$val['position']]['hr_name'])?$hr_name[$val['position']]['hr_name']:'-';

                         $hr_contact = isset($hr_contact_number[$val['position']]['hr_contact_number'])?$hr_contact_number[$val['position']]['hr_contact_number']:'-'; 
                         $company_url = isset($company_urls[$val['position']]['company_url'])?$company_urls[$val['position']]['company_url']:'-'; 
                        }


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
                     

                      if (!array_key_exists($val['candidate_id'], $candidate_data)) { 
                     $candidate_data[$val['candidate_id']] = array( 
                        'candidate_id' => $val['candidate_id'],
                        'segment' => $segment,
                        'location' => isset($val['location'])?$val['location']:'',
                        'father_name' => $val['father_name'],
                        'date_of_birth' => $val['date_of_birth'],
                        'phone_number' => $val['phone_number'],
                        'employee_id' => $val['employee_id'],
                        'email' => $val['email_id'],
                        'csm' => $val['csm'],
                        'tat' => $val['left_tat_days'],
                        'client_remarks' => $val['remark'],
                        'package_name' => $val['package_name'],
                        'candidate_name' => $val['first_name'].' '.$val['last_name'],
                        'client_name' => $val['client_name'],
                        'candidate_alt_number' => '-',
                        'client_last_name' => '-', 
                        'spoc_name' => $val['spoc_name'], 
                        'priority' => $priority,
                        'inputqc'=>$val['inputq'],
                        'status' => $inputQcStatus,
                        'analyst_status' => $status,
                        'main_status' => $verifiy_img,
                         'open_component' => array(),
                        'insuff_component' => array(),
                        'case_submitted_date' => $this->utilModel->get_actual_date_formate_hifun(isset($val['case_submitted_date'])?$val['case_submitted_date']:''),
                        'completed_date' =>$this->utilModel->get_actual_date_formate_hifun(isset($val['report_generated_date'])?$val['report_generated_date']:''),
                        $val['component_name'].' '.$val['formNumber']=>array( 
                            'annual_ctc'=>$ctc,
                            'hr_contact'=>$hr_contact,
                            'hr_name'=>$hr_name,
                            'remark_hr_name'=>$remark_hr_nam,
                            'remark_hr_email'=>$remark_hr_eml,
                            'reporting_contact'=>$contact,
                            'reporting_manager'=>$manager, 
                            'dor'=>$end,
                            'doj'=>$start,
                            'employee_id'=>$employee_id,
                            'company'=>$company,
                            'website'=>$company_url,
                            'desigination'=>$desigination, 
                             'vendor_name' => isset($vendor['vendor_name'])?$vendor['vendor_name']:'-', 
                        'vendor_date' => isset($vendor['assigned_to_vendor_date'])?$vendor['assigned_to_vendor_date']:'-', 
                            'assign_to'=>$val['assigned_team_name'],
                            'current_date'=>$this->utilModel->get_actual_date_formate_hifun($current_date),
                            'created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['created_date']),
                            'insuff_created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_created_date']),
                            'insuff_close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_close_date']), 
                            'inputqc_status_date'=>$this->utilModel->get_actual_date_formate_hifun($val['inputqc_status_date']), 
                            'insuff_closure_remarks'=>$val['insuff_closure_remarks'], 
                            'verification_remarks'=>$val['verification_remarks'], 
                            'progress_remarks'=>$val['progress_remarks'], 
                            'close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['analyst_status_date']), 
                            'formNumber'=>$val['formNumber'], 
                            'component_name'=>$val['component_name'], 
                            'status'=>$status, 
                        )
                     );

 
                     $client = $val['client_name'];
                     $client_id = $val['client_id'];
                  }else{
                    $candidate_data[$val['candidate_id']][$val['component_name'].' '.$val['formNumber']] = array( 
                            'annual_ctc'=>$ctc,
                            'hr_contact'=>$hr_contact,
                            'hr_name'=>$hr_name,
                             'remark_hr_name'=>$remark_hr_nam,
                            'remark_hr_email'=>$remark_hr_eml,
                            'reporting_contact'=>$contact,
                            'reporting_manager'=>$manager,
                            'dor'=>$end,
                            'doj'=>$start,
                            'employee_id'=>$employee_id,
                            'company'=>$company,
                            'website'=>$company_url, 
                            'desigination'=>$desigination,
                            'assign_to'=>$val['assigned_team_name'],
                            'current_date'=>$this->utilModel->get_actual_date_formate_hifun($current_date),
                            'created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['created_date']),
                            'insuff_created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_created_date']),
                            'insuff_close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_close_date']), 
                            'inputqc_status_date'=>$this->utilModel->get_actual_date_formate_hifun($val['inputqc_status_date']), 
                            'insuff_closure_remarks'=>$val['insuff_closure_remarks'], 
                            'verification_remarks'=>$val['verification_remarks'], 
                            'progress_remarks'=>$val['progress_remarks'], 
                            'close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['analyst_status_date']), 
                            'formNumber'=>$val['formNumber'], 
                            'component_name'=>$val['component_name'], 
                            'status'=>$status, 
                             'vendor_name' => isset($vendor['vendor_name'])?$vendor['vendor_name']:'-', 
                        'vendor_date' => isset($vendor['assigned_to_vendor_date'])?$vendor['assigned_to_vendor_date']:'-', 
                        ); 
                  }

                   $comp ='';
                    if (in_array($val['analyst_status'],[0,1])) {
                        $comp = $val['component_name'];
                    }
                    $compInsuff = '';
                    if (in_array($val['analyst_status'],[3])) {
                        $compInsuff = $val['component_name'];
                    }
                    $candidate_data[$val['candidate_id']]['open_component'] = array_merge($candidate_data[$val['candidate_id']]['open_component'],array($comp));
                    $candidate_data[$val['candidate_id']]['insuff_component'] = array_merge($candidate_data[$val['candidate_id']]['insuff_component'],array($compInsuff));
                    
                    if (!array_key_exists($val['component_name'].' '.$val['formNumber'], $data_array)) {
                     $data_array[$val['component_name'].' '.$val['formNumber']] = array($status); 
                    }else{
                     $data_array[$val['component_name'].' '.$val['formNumber']] = array_merge($data_array[$val['component_name'].' '.$val['formNumber']],array($status)); 
                    }




                }
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
        }
 

        /*export start */
     
         $num = 0;

            // create file name
            $fileName = 'employment-component-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            $al = count($data_array)+9;
           
            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'SL No');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Start Date');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Id');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Name');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Father Name');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'DOB');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Employee ID');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate E-Mail Id'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Contact Number');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Package Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Segment Name');    
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Priority'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'InputQc Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Input Case Status'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Final Status'); 
            // $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff components'); 
            
           
                $key_array = array();
            if (count($data_array)) { 
                foreach ($data_array as $key => $value) {
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Components');   
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Assigned to');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Company Name');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Company Website');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Designation');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Employee Id');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'DOJ');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'DOR');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Reporting Manager Name');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Reporting Manager Contact Number');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'HR Name / e-mail');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'HR Contact Number');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Annual CTC');   
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component Initiated date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'In Progress remarks'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff raised date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff close date'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff Remarks'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verification Fee');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verifier Name'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verifier E-mail'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verification remarks'); 
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Internal TAT');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component Closure Date');  
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component Status');    
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Name');    
                   $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Initiated Date');    
                   array_push($key_array,$key);
                // $num++;
                }
            }

             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Last Edited By with date & time'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case re-open date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case re-open closed date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num].'1', 'component name re-open'); 
          
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
                        $num = 0;
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, (++$init));
                        if ($val['case_submitted_date'] !='' && $val['case_submitted_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $case_submitted_date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['case_submitted_date']);  
                            
                        }else{
                            $case_submitted_date = '-';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $case_submitted_date); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_id']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['father_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['date_of_birth']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['employee_id']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['email']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['phone_number']);  
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_remarks']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['package_name']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['segment']);   
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['priority']);  
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['inputqc']);  
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['status']);  
                             $color_code = '62c4ff';
                        if ($val['main_status'] == 'In Progress') {
                            // code...
                        }
                        if ($val['main_status'] == 'Not Initiated') {
                            // code...
                        }
                        if ($val['main_status'] == 'Verified Discrepancy') {
                          $color_code = 'ec0000';
                        }
                        if ($val['main_status'] == 'Closed insufficiency') {
                           $color_code = 'FFD4AE';
                        }
                        if ($val['main_status'] == 'Unable to Verify') {
                          $color_code = 'FFD4AE';
                        }
                        if ($val['main_status'] == 'Insufficiency') {
                            // code...
                        }
                        if ($val['main_status'] == 'Verified Clear') {
                           $color_code = 'C5FCB4';
                        }
                        if ($val['main_status'] == 'Client Clarification') {
                            // code...
                        }
                        if ($val['main_status'] == 'Qc Error') {
                           $color_code = 'ec0000';
                        }
                        if ($val['main_status'] == 'Stop Check') {
                           $color_code = '62c4ff';
                        }
                         $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num].$rowCount) 
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB($color_code); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['main_status']);  
                      
                        foreach ($key_array as $key1 => $value) { 
                           $assign_to = isset($val[$value]['assign_to'])?$val[$value]['assign_to']:' '; 
                           $company = isset($val[$value]['company'])?$val[$value]['company']:' '; 
                           $website = isset($val[$value]['website'])?$val[$value]['website']:' '; 
                           $desigination = isset($val[$value]['desigination'])?$val[$value]['desigination']:' '; 
                           $employee_id = isset($val[$value]['employee_id'])?$val[$value]['employee_id']:' '; 
                           $doj = isset($val[$value]['doj'])?$val[$value]['doj']:' '; 
                           $dor = isset($val[$value]['dor'])?$val[$value]['dor']:' '; 
                           $reporting_manager = isset($val[$value]['reporting_manager'])?$val[$value]['reporting_manager']:' '; 
                           $reporting_contact = isset($val[$value]['reporting_contact'])?$val[$value]['reporting_contact']:' '; 
                           $hr_name = isset($val[$value]['hr_name'])?$val[$value]['hr_name']:' '; 
                           $hr_contact = isset($val[$value]['hr_contact'])?$val[$value]['hr_contact']:' '; 
                           $annual_ctc = isset($val[$value]['annual_ctc'])?$val[$value]['annual_ctc']:' ';  
                           $created_date = isset($val[$value]['current_date'])?$val[$value]['current_date']:' ';
                           $progress_remarks = isset($val[$value]['progress_remarks'])?$val[$value]['progress_remarks']:' ';
                           $insuff_created_date = isset($val[$value]['insuff_created_date'])?$val[$value]['insuff_created_date']:' ';
                           $insuff_close_date = isset($val[$value]['insuff_close_date'])?$val[$value]['insuff_close_date']:' ';
                           $insuff_closure_remarks = isset($val[$value]['insuff_closure_remarks'])?$val[$value]['insuff_closure_remarks']:' ';
                           $fee = isset($val[$value]['fee'])?$val[$value]['fee']:' '; 
                           $verifier_name = isset($val[$value]['remark_hr_name'])?$val[$value]['remark_hr_name']:' ';
                           $verifier_email = isset($val[$value]['remark_hr_email'])?$val[$value]['remark_hr_email']:' ';
                           $verification_remarks = isset($val[$value]['verification_remarks'])?$val[$value]['verification_remarks']:' ';
                           $tat = isset($val['tat'])?$val['tat']:'-';                  
                           $close_date = isset($val[$value]['close_date'])?$val[$value]['close_date']:' '; 
                           $status = isset($val[$value]['status'])?$val[$value]['status']:''; 
                           $vendor_name = isset($val[$value]['vendor_name'])?$val[$value]['vendor_name']:' '; 
                           $vendor_date = isset($val[$value]['vendor_date'])?$val[$value]['vendor_date']:' '; 

                             $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $value);
                             $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $assign_to);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $company);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $website);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $desigination);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $employee_id);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $doj);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $dor); 
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $reporting_manager);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $reporting_contact);

                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $hr_name);
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $hr_contact); 
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $annual_ctc); 
                            if (!empty($status) && $created_date !='' && $created_date !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $created_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($created_date);  
                                
                            }else{
                                $created_date_cell = '-';
                            }
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $created_date_cell); 
                              $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $progress_remarks);
                            if (!empty($status) && $insuff_created_date !='' && $insuff_created_date !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $insuff_created_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($insuff_created_date);  
                                
                            }else{
                                $insuff_created_date_cell = '-';
                            }
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $insuff_created_date_cell); 
                            if (!empty($status) && $insuff_close_date !='' && $insuff_close_date !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $insuff_close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($insuff_close_date);  
                                
                            }else{
                                $insuff_close_date_cell = '-';
                            }  
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $insuff_close_date_cell); 
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $insuff_closure_remarks); 
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $fee); 
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $verifier_name); 
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $verifier_email); 
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $verification_remarks); 
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $tat);
                            if (!empty($status) &&  $close_date !='' && $close_date !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($close_date);  
                                
                            }else{
                                $close_date_cell = '-';
                            }

                             if (in_array($status, ['Not initiated','In Progress','Insufficiency','Pending'])) {
                                $close_date_cell = '-';
                            }
                            
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $close_date_cell); 
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $status); 
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $vendor_name);
                            if ($vendor_date !='' && $vendor_date !='-') {
                                $objPHPExcel->getActiveSheet()
                                ->getStyle($alphabet[$num] . $rowCount)
                                ->getNumberFormat()
                                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                                $vendor_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($vendor_date);  
                                
                            }else{
                                $vendor_date_cell = '-';
                            }
                            $objPHPExcel->getActiveSheet()->SetCellValue( $alphabet[$num++] . $rowCount, $vendor_date_cell); 
                           
                        }

                       
                      $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num] . $rowCount, '-');  
                        $rowCount++;
                     }
                    
                  }

                  echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
                                    
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
  
    }

    function new_address_component_report(){
             $alphabet = $this->utilModel->return_excel_val(); 
        $where = '';
        if ($this->input->post('duration') == 'today') {
            $where = " where date(created_date) = CURDATE() AND ( component_ids REGEXP 8 OR  component_ids REGEXP 9 OR  component_ids REGEXP 12)";
        } else if($this->input->post('duration') == 'week') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() AND ( component_ids REGEXP 8 OR  component_ids REGEXP 9 OR  component_ids REGEXP 12)";
        } else if($this->input->post('duration') == 'month') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() AND ( component_ids REGEXP 8 OR  component_ids REGEXP 9 OR  component_ids REGEXP 12)";
        } else if($this->input->post('duration') == 'year') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE() AND ( component_ids REGEXP 8 OR  component_ids REGEXP 9 OR  component_ids REGEXP 12)";
        } else if($this->input->post('duration') == 'between') {
            $where = " where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."' AND ( component_ids REGEXP 8 OR  component_ids REGEXP 9 OR  component_ids REGEXP 12)";
        }else{
             $where = " where ( component_ids REGEXP 8 OR  component_ids REGEXP 9 OR  component_ids REGEXP 12)";
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
            $ids = explode(',', $value['component_ids']);
            if (array_intersect([8,9,12], $ids)) { 
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id'],[8,9,12]);

            $ana_status = $this->get_analyst_status($value['candidate_id']);


             
                     $verifiy_img = 'In Progress'; 
                     $verifiy_status = 'In Progress'; 

                     if (in_array('0', $ana_status)) {
                         $verifiy_img = 'Not Initiated';
                         $verifiy_status = 'Not Initiated';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('1', $ana_status)){
                         $verifiy_img = 'In Progress';
                         $verifiy_status = 'In Progress';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('8', $ana_status)){
                         $verifiy_img = 'Client Clarification';
                         $verifiy_status = 'Client Clarification';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        } 
                     }else if(in_array('3', $ana_status)){
                        $verifiy_img = "Insufficiency";  
                        $verifiy_status = "Insufficiency";  
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('11', $ana_status)){
                        $verifiy_img = "Insuff Clear";  
                        $verifiy_status = "Insuff Clear";  
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if (in_array('7', $ana_status)) {

                        $verifiy_img = "Verified Discrepancy"; 
                        $verifiy_status = "Verified Discrepancy"; 
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    }else if(array_intersect(['6','9'], $ana_status)){
                         if (in_array('6',$ana_status)) {
                            $verifiy_img = "Unable to Verify"; 
                            $verifiy_status = "Unable to Verify"; 
                        }else if (in_array('9',$ana_status)) { 
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
                    }*/else if(in_array('4', $ana_status)){ 
                        $verifiy_status = "Verified Clear"; 
                        if ($value['is_submitted'] =='2') { 
                        $verifiy_img = "Verified Clear"; 
                        }else if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress"; 
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated"; 
                        }
                    } else if(in_array('5', $ana_status)){
                        $verifiy_img = "Stop Check"; 
                        $verifiy_status = "Stop Check"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    }else if(in_array('10', $ana_status)){
                        $verifiy_img = "Qc Error"; 
                        $verifiy_status = "Qc Error"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    } 


             
             $analyst = array();
                // $case_array = array();
                foreach ($cases as $k => $val) { 
                      if (in_array($val['component_id'], $ids)) {

                        if ($val['component_id'] == '8') {
                           // $address_tbl = $this->db->where('candidate_id',$val['candidate_id'])->get('present_address')->row_array();
                           $address_tbl = $val['tables'];
                        }else if ($val['component_id'] == '9') {
                           // $address_tbl = $this->db->where('candidate_id',$val['candidate_id'])->get('permanent_address')->row_array();
                            $address_tbl = $val['tables'];
                        }else{ 
                         // $addr = $this->db->where('candidate_id',$val['candidate_id'])->get('previous_address')->row_array();
                            $addr = $val['tables'];
 
                              $street_p = json_decode(isset($addr['street'])?$addr['street']:'',true); 
                              $area_p = json_decode(isset($addr['area'])?$addr['area']:'',true); 
                              $city_p = json_decode(isset($addr['city'])?$addr['city']:'',true); 
                              $pin_code_p = json_decode(isset($addr['pin_code'])?$addr['pin_code']:'',true);  
                              $states_p = json_decode(isset($addr['state'])?$addr['state']:'',true);  
                              $country_p = json_decode(isset($addr['country'])?$addr['country']:'',true);  
                              $dates = explode(',', isset($address_tbl['analyst_status_date'])?$address_tbl['analyst_status_date']:'');
                        }

                        $analyst_dates = '';

                        if ($val['component_id'] != '12') {
                            $street =  isset($address_tbl['street'])?$address_tbl['street']:'-';
                            $area =  isset($address_tbl['area'])?$address_tbl['area']:'-';
                            $city =  isset($address_tbl['city'])?$address_tbl['city']:'-';
                            $pin_code =  isset($address_tbl['pin_code'])?$address_tbl['pin_code']:'-'; 
                            $state =  isset($address_tbl['state'])?$address_tbl['state']:'-'; 
                            $country =  isset($address_tbl['country'])?$address_tbl['country']:'-'; 
                            $analyst_dates = isset($address_tbl['analyst_status_date'])?$address_tbl['analyst_status_date']:'';
                           
                        }else{
                           $street =  isset($street_p[$val['position']]['street'])?$street_p[$val['position']]['street']:'-';
                            $area =  isset($area_p[$val['position']]['area'])?$area_p[$val['position']]['area']:'-';
                            $city =  isset($city_p[$val['position']]['city'])?$city_p[$val['position']]['city']:'-';
                            $pin_code =  isset($pin_code_p[$val['position']]['pin_code'])?$pin_code_p[$val['position']]['pin_code']:'-'; 
                            $state =  isset($states_p[$val['position']]['state'])?$states_p[$val['position']]['state']:'-'; 
                            $country =  isset($country_p[$val['position']]['country'])?$country_p[$val['position']]['country']:'-'; 
                             $analyst_dates = isset($dates[$val['position']])?$dates[$val['position']]:'';  
                        }

                        $address ='';

                        if ($street !='') { $address .=$street.','; }
                        if ($area !='') { $address .=$area.','; }
                        if ($city !='') { $address .=$city.','; }
                        if ($state !='') { $address .=$state.','; }
                        if ($country !='') { $address .=$country.','; }
                        if ($pin_code !='') { $address .=$pin_code; }

                            $address = str_replace('-,','',$address);
 


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
                           
                            $status = 'Closed Insufficiency';
                            
                        }else if ($val['analyst_status'] == '10'){
                            $status = 'QC Error'; 
                         
                        }else if ($val['analyst_status'] == '11'){
                            $status = 'Insuff Clear';  
                        }


                          $inputQcStatus = '';
                        if ($val['status'] == '0') {
                            $inputQcStatus = 'Not initiated';
                        } else if ($val['status'] == '1') {
                            $inputQcStatus = 'In Progress';
                        } else if ($val['status'] == '2') {
                            $inputQcStatus = 'Completed';
                        } else if ($val['status']== '3') {
                            $inputQcStatus = 'Insufficiency';
                        } else if ($val['status'] == '4') {
                            $inputQcStatus = 'Verified Clear';
                        } else if ($val['status'] == '5') {
                            $inputQcStatus = 'Stop Check';
                        } else if ($val['status'] == '6') {
                            $inputQcStatus = 'Unable to verify';
                        } else if ($val['status'] == '7') {
                            $inputQcStatus = 'Verified discrepancy';
                        } else if ($val['status'] == '8') {
                            $inputQcStatus = 'Client clarification';
                        } else if ($val['status'] == '9') {
                            $inputQcStatus = 'Closed Insufficiency';
                        }

                        $index = $val['index'];


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
                            $where = array(
                                'index_no'=>$val['position'],
                                'case_id'=>$val['candidate_id'],
                                'component_id'=>$val['component_id'],
                        );
        $vendor = $this->db->where($where)->select('vendor.vendor_name,assign_case_to_vendor.created_date AS assigned_to_vendor_date')->from('assign_case_to_vendor')->join('vendor','assign_case_to_vendor.vendor_id = vendor.vendor_id','left')->order_by('assign_case_to_vendor.assign_id','DESC')->get()->row_array();

                    
                     $candidate_data_array = array( 
                    
                        'address' => $address,
                        'street' => $street,
                        'area' => $area,
                        'city' => $city,
                        'pin_code' => $pin_code,
                        'state' => $state,
                        'country' => $country,
                        'iv_pv' => isset($val['iv_pv'])?$val['iv_pv']:'-',
                        'vendor_name' => isset($vendor['vendor_name'])?$vendor['vendor_name']:$val['vendor'], 
                        'vendor_date' => isset($vendor['assigned_to_vendor_date'])?$vendor['assigned_to_vendor_date']:'-',  
                        'candidate_id' => $val['candidate_id'],
                        'segment' => $segment,
                        'location' => isset($val['location'])?$val['location']:'',
                        'father_name' => $val['father_name'],
                        'date_of_birth' => $val['date_of_birth'],
                        'phone_number' => $val['phone_number'],
                        'employee_id' => $val['employee_id'],
                        'email' => $val['email_id'],
                        'csm' => $val['csm'],
                        'tat' => $val['left_tat_days'],
                        'client_remarks' => $val['remark'],
                        'package_name' => $val['package_name'],
                        'candidate_name' => $val['first_name'].' '.$val['last_name'],
                        'client_name' => $val['client_name'],
                        'candidate_alt_number' => '-',
                        'client_last_name' => '-',
                        'open_component' => '-',
                        'insuff_component' => '-',
                        'spoc_name' => $val['spoc_name'], 
                        'priority' => $priority,
                        'status' => $inputQcStatus,
                        'analyst_status' => $status,
                        'final_status' => $verifiy_img,
                        'assigned_team_name'=>$val['assigned_team_name'],
                        'case_submitted_date' => $this->utilModel->get_actual_date_formate_hifun(isset($val['case_submitted_date'])?$val['case_submitted_date']:''),
                        'completed_date' =>$this->utilModel->get_actual_date_formate_hifun(isset($val['report_generated_date'])?$val['report_generated_date']:''),
                        'component_name' =>$val['component_name'], 
                        'created_date'=>isset($val['tables']['created_date'])?$val['tables']['created_date']:'',
                        'insuff_created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_created_date']),
                        'insuff_close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_close_date']), 
                        'inputqc_status_date'=>$this->utilModel->get_actual_date_formate_hifun($val['inputqc_status_date']), 
                        'insuff_remarks'=>$val['insuff_remarks'], 
                        'insuff_closure_remarks'=>$val['insuff_closure_remarks'], 
                        'verification_remarks'=>$val['verification_remarks'], 
                        'progress_remarks'=>$val['progress_remarks'], 
                        'close_date'=>$this->utilModel->get_actual_date_formate_hifun($analyst_dates), 
                        'formNumber'=>$val['formNumber'], 
                       
                     );

                     array_push($candidate_data,$candidate_data_array);
 

                }

                }

  
        }
        }

        // print_r($candidate_data_array);
        // exit();

         $num = 0;

            // create file name
            $fileName = 'address-component-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            $al = count($data_array)+9;
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A1:'.$alphabet[$al].'1')
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('D3D3D3');
            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'SL No');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Start Date');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Id');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Name');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Father Name');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'DOB');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Employee ID');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate E-Mail Id'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Contact Number');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Package Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Segment'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Components');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'InputQc Status');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component Status');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Priority'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Assigned to'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'PV/IV team'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Address'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'City');  
             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'State'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Country'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Pincode');   
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component Initiated date');   
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'In-Progress remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff raised date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff cleared date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff Closure remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Initiated date'); 
            // $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Closure date'); final_status
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Additional fee'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verification remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component closure date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Final Status'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Internal TAT');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Last edited by with date & time'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case re-open date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Re-opened case closed date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component name Re-opened'); 
          
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
                ->getStyle('A'.$rowCount.':'.$alphabet[$num-1].$rowCount)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000'); 
                $num = 0;
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, (++$init));
                        if ($val['case_submitted_date'] !='' && $val['case_submitted_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $case_submitted_date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['case_submitted_date']);  
                            
                        }else{
                            $case_submitted_date = '-';
                        }
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $case_submitted_date); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_id']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['father_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['date_of_birth']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['employee_id']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['email']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['phone_number']); 
                       
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_remarks']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['package_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount,  $val['segment']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount,  $val['component_name']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount,  $val['status']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount,  $val['analyst_status']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['priority']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['assigned_team_name']); 


                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['iv_pv']); 

                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['address']); 

                      $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['city']);
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['state']); 
                      $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['country']);
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['pin_code']);
                        if ($val['created_date'] !='' && $val['created_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $created_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['created_date']);  
                            
                        }else{
                            $created_date_cell = '-';
                        }
                      $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $created_date_cell); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['progress_remarks']);
                        if ($val['insuff_created_date'] !='' && $val['insuff_created_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $insuff_created_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['created_date']);  
                            
                        }else{
                            $insuff_created_date_cell = '-';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $insuff_created_date_cell);
                        if ($val['insuff_close_date'] !='' && $val['insuff_close_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $insuff_close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['insuff_close_date']);  
                            
                        }else{
                            $insuff_close_date_cell = '-';
                        }
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $insuff_close_date_cell); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['insuff_remarks']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['insuff_closure_remarks']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['vendor_name']); 
                        if (!empty($val['vendor_date']) && $val['vendor_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $vendor_date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['vendor_date']);  
                            
                        }else{
                            $vendor_date = '-';
                        }
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $vendor_date);

                       if ($val['close_date'] !='' && $val['close_date'] !='-' && !empty($val['vendor_date']) && $val['vendor_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['close_date']);  
                            
                        }else{
                            $close_date_cell = '-';
                        }
                       // $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $close_date_cell); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['verification_remarks']);
                       if ($val['close_date'] !='' && $val['close_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['close_date']);  
                            
                        }else{
                            $close_date_cell = '-';
                        }

                         if (in_array($val['analyst_status'], ['Not initiated','In Progress','Insufficiency','Pending'])) {
                                $close_date_cell = '-';
                            }
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $close_date_cell); 
                            $color_code = '62c4ff';
                        if ($val['final_status'] == 'In Progress') {
                            // code...
                        }
                        if ($val['final_status'] == 'Not Initiated') {
                            // code...
                        }
                        if ($val['final_status'] == 'Verified Discrepancy') {
                          $color_code = 'ec0000';
                        }
                        if ($val['final_status'] == 'Closed insufficiency') {
                           $color_code = 'FFD4AE';
                        }
                        if ($val['final_status'] == 'Unable to Verify') {
                          $color_code = 'FFD4AE';
                        }
                        if ($val['final_status'] == 'Insufficiency') {
                            // code...
                        }
                        if ($val['final_status'] == 'Verified Clear') {
                           $color_code = 'C5FCB4';
                        }
                        if ($val['final_status'] == 'Client Clarification') {
                            // code...
                        }
                        if ($val['final_status'] == 'Qc Error') {
                           $color_code = 'ec0000';
                        }
                        if ($val['final_status'] == 'Stop Check') {
                           $color_code = '62c4ff';
                        }
                         $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num].$rowCount) 
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB($color_code); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['final_status']);  
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['tat']);  
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');  

                        $rowCount++;
                     }
                    
                  }

                  echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
                                    
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
    }

    function new_education_component_report(){
        $alphabet = $this->utilModel->return_excel_val(); 
        $where = '';
        if ($this->input->post('duration') == 'today') {
            $where = " where date(created_date) = CURDATE() AND component_ids REGEXP 7";
        } else if($this->input->post('duration') == 'week') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() AND component_ids REGEXP 7";
        } else if($this->input->post('duration') == 'month') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() AND component_ids REGEXP 7";
        } else if($this->input->post('duration') == 'year') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE() AND component_ids REGEXP 7";
        } else if($this->input->post('duration') == 'between') {
            $where = " where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."' AND component_ids REGEXP 7";
        }else{
             $where = " where component_ids REGEXP 7";
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

             $ids = explode(',', $value['component_ids']);
            if (in_array(7, $ids)) { 
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id'],[7]);

                  $ana_status = $this->get_analyst_status($value['candidate_id']);


              
                     $verifiy_img = 'In Progress'; 
                     $verifiy_status = 'In Progress'; 

                     if (in_array('0', $ana_status)) {
                         $verifiy_img = 'Not Initiated';
                         $verifiy_status = 'Not Initiated';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('1', $ana_status)){
                         $verifiy_img = 'In Progress';
                         $verifiy_status = 'In Progress';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('8', $ana_status)){
                         $verifiy_img = 'Client Clarification';
                         $verifiy_status = 'Client Clarification';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        } 
                     }else if(in_array('3', $ana_status)){
                        $verifiy_img = "Insufficiency";  
                        $verifiy_status = "Insufficiency";  
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('11', $ana_status)){
                        $verifiy_img = "Insuff Clear";  
                        $verifiy_status = "Insuff Clear";  
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if (in_array('7', $ana_status)) {

                        $verifiy_img = "Verified Discrepancy"; 
                        $verifiy_status = "Verified Discrepancy"; 
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    }else if(array_intersect(['6','9'], $ana_status)){
                         if (in_array('6',$ana_status)) {
                            $verifiy_img = "Unable to Verify"; 
                            $verifiy_status = "Unable to Verify"; 
                        }else if (in_array('9',$ana_status)) { 
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
                    }*/else if(in_array('4', $ana_status)){ 
                        $verifiy_status = "Verified Clear"; 
                        if ($value['is_submitted'] =='2') { 
                        $verifiy_img = "Verified Clear"; 
                        }else if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress"; 
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated"; 
                        }
                    } else if(in_array('5', $ana_status)){
                        $verifiy_img = "Stop Check"; 
                        $verifiy_status = "Stop Check"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    }else if(in_array('10', $ana_status)){
                        $verifiy_img = "Qc Error"; 
                        $verifiy_status = "Qc Error"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    } 

             
             $analyst = array();
                // $case_array = array();
                foreach ($cases as $k => $val) { 
                      if ($val['component_id'] =='7') {
                         // $education_tbl = $this->db->where('candidate_id',$val['candidate_id'])->get('education_details')->row_array();
                         $education_tbl = $val['tables'];
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
                           
                            $status = 'Closed Insufficiency';
                            
                        }else if ($val['analyst_status'] == '10'){
                            $status = 'QC Error'; 
                         
                        }else if ($val['analyst_status'] == '11'){
                            $status = 'Insuff Clear';  
                        }


                          $inputQcStatus = '';
                        if ($val['status'] == '0') {
                            $inputQcStatus = 'Not initiated';
                        } else if ($val['status'] == '1') {
                            $inputQcStatus = 'In Progress';
                        } else if ($val['status'] == '2') {
                            $inputQcStatus = 'Completed';
                        } else if ($val['status']== '3') {
                            $inputQcStatus = 'Insufficiency';
                        } else if ($val['status'] == '4') {
                            $inputQcStatus = 'Verified Clear';
                        } else if ($val['status'] == '5') {
                            $inputQcStatus = 'Stop Check';
                        } else if ($val['status'] == '6') {
                            $inputQcStatus = 'Unable to verify';
                        } else if ($val['status'] == '7') {
                            $inputQcStatus = 'Verified discrepancy';
                        } else if ($val['status'] == '8') {
                            $inputQcStatus = 'Client clarification';
                        } else if ($val['status'] == '9') {
                            $inputQcStatus = 'Closed Insufficiency';
                        }

                        $index = $val['index'];

                        

                if ($education_tbl !=null) {
                     $type_of_degree = json_decode($education_tbl['type_of_degree'],true);
                    $major = json_decode($education_tbl['major'],true);
                    $university_board = json_decode($education_tbl['university_board'],true);
                    $college_school = json_decode($education_tbl['college_school'],true);
                    $address_of_college_school = json_decode($education_tbl['address_of_college_school'],true);
                    $course_start_date = json_decode($education_tbl['course_start_date'],true);
                    $course_end_date = json_decode($education_tbl['course_end_date'],true);
                    $type_of_course = json_decode($education_tbl['type_of_course'],true);
                    $registration_roll_number = json_decode($education_tbl['registration_roll_number'],true);
                    $verifier_name = json_decode($education_tbl['remark_verifier_name'],true);
                    $verification_remark = json_decode($education_tbl['verification_remarks'],true);
                    $remark_roll_no = json_decode($education_tbl['remark_roll_no'],true);
                    $remark_type_of_dgree = json_decode($education_tbl['remark_type_of_dgree'],true);
                    $remark_institute_name = json_decode($education_tbl['remark_institute_name'],true);
                    $remark_university_name = json_decode($education_tbl['remark_university_name'],true);
                    $remark_year_of_graduation = json_decode($education_tbl['remark_year_of_graduation'],true);
                    $approved_doc = json_decode($education_tbl['approved_doc'],true);
                    $remark_verifier_designation = json_decode($education_tbl['remark_verifier_designation'],true);
                    $verified_date = json_decode($education_tbl['verified_date'],true);
                    $remark_physical_visit = json_decode($education_tbl['remark_physical_visit'],true);
                } 

                $physical_visit = isset($remark_physical_visit[$index]['physical_visit'])?$remark_physical_visit[$index]['physical_visit']:'-';
                $vname = isset($verifier_name[$index]['verifier_name'])?$verifier_name[$index]['verifier_name']:'-';
                $verification_remarks = isset($verification_remark[$index]['verification_remarks'])?$verification_remark[$index]['verification_remarks']:'-'; 
                $type_of_degree_edu = isset($type_of_degree[$index]['type_of_degree'])?$type_of_degree[$index]['type_of_degree']:'-'; 
                $edu_major = isset($major[$index]['major'])?$major[$index]['major']:'-'; 
                $university_board_edu = isset($university_board[$index]['university_board'])?$university_board[$index]['university_board']:'-'; 
                $college_school_edu = isset($college_school[$index]['college_school'])?$college_school[$index]['college_school']:'-'; 
                $add = isset($address_of_college_school[$index]['address_of_college_school'])?$address_of_college_school[$index]['address_of_college_school']:'-';
                $start = isset($course_start_date[$index]['course_start_date'])?$course_start_date[$index]['course_start_date']:'-';
                $end = isset($course_end_date[$index]['course_end_date'])?$course_end_date[$index]['course_end_date']:'-';
                $course = isset($type_of_course[$index]['type_of_course'])?$type_of_course[$index]['type_of_course']:'-'; 
                $roll = isset($registration_roll_number[$index]['registration_roll_number'])?$registration_roll_number[$index]['registration_roll_number']:'-';


                $remark_rollno = isset($remark_roll_no[$index]['roll_number'])?$remark_roll_no[$index]['roll_number']:'-';
                $remark_type_dgree = isset($remark_type_of_dgree[$index]['type_of_degree'])?$remark_type_of_dgree[$index]['type_of_degree']:'-';
                $remark_institutename = isset($remark_institute_name[$index]['institute_name'])?$remark_institute_name[$index]['institute_name']:'-';
                $remark_universityname = isset($remark_university_name[$index]['university_name'])?$remark_university_name[$index]['university_name']:'-';
                $remark_year_ofgraduation = isset($remark_year_of_graduation[$index]['year_of_education'])?$remark_year_of_graduation[$index]['year_of_education']:'-';
                $verifier_designation = isset($remark_verifier_designation[$index]['verifier_designation'])?$remark_verifier_designation[$index]['verifier_designation']:'';
                $verified_dates = isset($verified_date[$index]['verified_date'])?$verified_date[$index]['verified_date']:'';

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

                                  $where = array(
                                'index_no'=>$val['position'],
                                'case_id'=>$val['candidate_id'],
                                'component_id'=>$val['component_id'],
                        );
        $vendor = $this->db->where($where)->select('vendor.vendor_name,assign_case_to_vendor.created_date AS assigned_to_vendor_date')->from('assign_case_to_vendor')->join('vendor','assign_case_to_vendor.vendor_id = vendor.vendor_id','left')->order_by('assign_case_to_vendor.assign_id','DESC')->get()->row_array();


                    
                     $candidate_data_array = array( 
                        'type_of_degree' => $type_of_degree_edu,
                        'major' => $edu_major,
                        'college' => $college_school_edu,
                        'university' => $university_board_edu,
                        'college_address' => $add,
                        'type_of_course' => $course,
                        'duration_of_course' => $start.'-'.$end,
                        'roll' => $roll,
                        'year' => $remark_year_ofgraduation,
                        'physical_visit' => $physical_visit,
                        'verifier_designation' => $verifier_designation,
                        'verified_dates' => $verified_dates,
                        'vname' => $vname,
                        'vcontact' => '',
                        'fee' => '',
                        'vendor_name' => isset($vendor['vendor_name'])?$vendor['vendor_name']:'-', 
                        'vendor_date' => isset($vendor['assigned_to_vendor_date'])?$vendor['assigned_to_vendor_date']:'-', 
                        'candidate_id' => $val['candidate_id'],
                        'segment' => $segment,
                        'location' => isset($val['location'])?$val['location']:'',
                        'father_name' => $val['father_name'],
                        'date_of_birth' => $val['date_of_birth'],
                        'phone_number' => $val['phone_number'],
                        'employee_id' => $val['employee_id'],
                        'email' => $val['email_id'],
                        'csm' => $val['csm'],
                        'tat' => $val['left_tat_days'],
                        'client_remarks' => $val['remark'],
                        'package_name' => $val['package_name'],
                        'candidate_name' => $val['first_name'].' '.$val['last_name'],
                        'client_name' => $val['client_name'],
                        'candidate_alt_number' => '-',
                        'client_last_name' => '-',
                        'open_component' => '-',
                        'insuff_component' => '-',
                        'spoc_name' => $val['spoc_name'],
                        'priority' => $priority,
                        'status' => $inputQcStatus,
                        'analyst_status' => $status,
                        'final_status' => $verifiy_img,
                        'assigned_team_name'=>$val['assigned_team_name'],
                        'case_submitted_date' => $this->utilModel->get_actual_date_formate_hifun(isset($val['case_submitted_date'])?$val['case_submitted_date']:''),
                        'completed_date' =>$this->utilModel->get_actual_date_formate_hifun(isset($val['report_generated_date'])?$val['report_generated_date']:''),
                        'component_name' =>$val['component_name'],
                        'created_date'=>isset($val['tables']['created_date'])?$val['tables']['created_date']:'',
                        'insuff_created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_created_date']),
                        'insuff_close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_close_date']), 
                        'inputqc_status_date'=>$this->utilModel->get_actual_date_formate_hifun($val['inputqc_status_date']), 
                        'insuff_closure_remarks'=>$val['insuff_closure_remarks'], 
                        'verification_remarks'=>$val['verification_remarks'], 
                        'progress_remarks'=>$val['progress_remarks'], 
                        'close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['analyst_status_date']), 
                        'formNumber'=>$val['formNumber'], 
                       
                     );

                     array_push($candidate_data,$candidate_data_array);
 

                }

                }
                }

  
        }

         $num = 0;

            // create file name
            $fileName = 'education-component-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            $al = count($data_array)+9;
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A1:'.$alphabet[$al].'1')
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('D3D3D3');
            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'SL No');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Start Date');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Id');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Name');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Father Name');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'DOB');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Employee ID');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate E-Mail Id'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Contact Number');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Package Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Segment'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Components');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component Status');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'InputQc Status');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Final Status');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Priority'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Assigned to'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Type of Qualification'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Major');  
             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'College Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'University Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'University / College Address'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Type of course'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Duration of course'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Reg/Roll No'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Year of Graduation'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Result/Grade'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Physical Visit'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'In-Progress remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff raised date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff cleared date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verification fee'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verification remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component closure date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Internal TAT'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verifier Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verifier contact number'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verifier designation'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verifier e-mail id'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Initiated Date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Last edited by with date & time'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case re-open date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Re-opened case closed date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component name Re-opened'); 
          
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
                        ->getStyle('A'.$rowCount.':'.$alphabet[$num-1].$rowCount)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_MEDIUM)
                        ->getColor()
                        ->setRGB('000000'); 
                        $num = 0;
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, (++$init));
                        if ($val['case_submitted_date'] !='' && $val['case_submitted_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $case_submitted_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['case_submitted_date']);  
                            
                        }else{
                            $case_submitted_date_cell = '-';
                        }
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $case_submitted_date_cell); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_id']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['father_name']);
                        if ($val['date_of_birth'] !='' && $val['date_of_birth'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $date_of_birth_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['date_of_birth']);  
                            
                        }else{
                            $date_of_birth_cell = '-';
                        } 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $date_of_birth_cell); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['employee_id']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['email']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['phone_number']); 
                       
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_remarks']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['package_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount,  $val['segment']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount,  $val['component_name']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount,  $val['analyst_status']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount,  $val['status']); 
                            $color_code = '62c4ff';
                        if ($val['final_status'] == 'In Progress') {
                            // code...
                        }
                        if ($val['final_status'] == 'Not Initiated') {
                            // code...
                        }
                        if ($val['final_status'] == 'Verified Discrepancy') {
                          $color_code = 'ec0000';
                        }
                        if ($val['final_status'] == 'Closed insufficiency') {
                           $color_code = 'FFD4AE';
                        }
                        if ($val['final_status'] == 'Unable to Verify') {
                          $color_code = 'FFD4AE';
                        }
                        if ($val['final_status'] == 'Insufficiency') {
                            // code...
                        }
                        if ($val['final_status'] == 'Verified Clear') {
                           $color_code = 'C5FCB4';
                        }
                        if ($val['final_status'] == 'Client Clarification') {
                            // code...
                        }
                        if ($val['final_status'] == 'Qc Error') {
                           $color_code = 'ec0000';
                        }
                        if ($val['final_status'] == 'Stop Check') {
                           $color_code = '62c4ff';
                        }
                         $objPHPExcel->getActiveSheet()
                             ->getStyle($alphabet[$num].$rowCount) 
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB($color_code);  
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount,  $val['final_status']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['priority']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['assigned_team_name']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['type_of_degree']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['major']); 

                      $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['college']);
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['university']); 
                      $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['college_address']);
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['type_of_course']); 
                      $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['duration_of_course']);
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['roll']); 
                      $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['year']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-'); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['physical_visit']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['progress_remarks']);
                       if ($val['insuff_created_date'] !='' && $val['insuff_created_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $insuff_created_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['insuff_created_date']);  
                            
                        }else{
                            $insuff_created_date_cell = '-';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $insuff_created_date_cell);
                        if ($val['insuff_close_date'] !='' && $val['insuff_close_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $insuff_close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['insuff_close_date']);  
                            
                        }else{
                            $insuff_close_date_cell = '-';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['insuff_close_date']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['insuff_closure_remarks']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['fee']); 
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['verification_remarks']);
                        if ($val['close_date'] !='' && $val['close_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['close_date']);  
                            
                        }else{
                            $close_date_cell = '-';
                        }

                         if (in_array($val['analyst_status'], ['Not initiated','In Progress','Insufficiency','Pending'])) {
                                $close_date_cell = '-';
                            }
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $close_date_cell); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['tat']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['vname']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['vcontact']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['verifier_designation']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['vendor_name']);
                        if ($val['vendor_date'] !='' && $val['vendor_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $vendor_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['vendor_date']);  
                            
                        }else{
                            $vendor_date_cell = '-';
                        }
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $vendor_date_cell);

                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');  

                        $rowCount++;
                     }
                    
                  }

                  echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
                                    
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
    }


    /* reference */

    function new_reference_report(){
        $alphabet = $this->utilModel->return_excel_val(); 
        $where = '';
        if ($this->input->post('duration') == 'today') {
            $where = " where date(created_date) = CURDATE() AND component_ids REGEXP 11";
        } else if($this->input->post('duration') == 'week') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() AND component_ids REGEXP 11";
        } else if($this->input->post('duration') == 'month') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() AND component_ids REGEXP 11";
        } else if($this->input->post('duration') == 'year') {
            $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE() AND component_ids REGEXP 11";
        } else if($this->input->post('duration') == 'between') {
            $where = " where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."' AND component_ids REGEXP 11";
        }else{
             $where = " where component_ids REGEXP 11";
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

            $ids = explode(',', $value['component_ids']);
            if (in_array(11,$ids)) { 
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id'],[11]);

               $ana_status = $this->get_analyst_status($value['candidate_id']);


              
                     $verifiy_img = 'In Progress'; 
                     $verifiy_status = 'In Progress'; 

                     if (in_array('0', $ana_status)) {
                         $verifiy_img = 'Not Initiated';
                         $verifiy_status = 'Not Initiated';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('1', $ana_status)){
                         $verifiy_img = 'In Progress';
                         $verifiy_status = 'In Progress';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('8', $ana_status)){
                         $verifiy_img = 'Client Clarification';
                         $verifiy_status = 'Client Clarification';
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        } 
                     }else if(in_array('3', $ana_status)){
                        $verifiy_img = "Insufficiency";  
                        $verifiy_status = "Insufficiency";  
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if(in_array('11', $ana_status)){
                        $verifiy_img = "Insuff Clear";  
                        $verifiy_status = "Insuff Clear";  
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                     }else if (in_array('7', $ana_status)) {

                        $verifiy_img = "Verified Discrepancy"; 
                        $verifiy_status = "Verified Discrepancy"; 
                        if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    }else if(array_intersect(['6','9'], $ana_status)){
                         if (in_array('6',$ana_status)) {
                            $verifiy_img = "Unable to Verify"; 
                            $verifiy_status = "Unable to Verify"; 
                        }else if (in_array('9',$ana_status)) { 
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
                    }*/else if(in_array('4', $ana_status)){ 
                        $verifiy_status = "Verified Clear"; 
                        if ($value['is_submitted'] =='2') { 
                        $verifiy_img = "Verified Clear"; 
                        }else if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress"; 
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated"; 
                        }
                    } else if(in_array('5', $ana_status)){
                        $verifiy_img = "Stop Check"; 
                        $verifiy_status = "Stop Check"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    }else if(in_array('10', $ana_status)){
                        $verifiy_img = "Qc Error"; 
                        $verifiy_status = "Qc Error"; 
                         if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    } 
 

            $analyst = array();
                // $case_array = array();
                foreach ($cases as $k => $val) { 
                    if ($val['component_id'] =='11') {
                         // $reference_tbl = $this->db->where('candidate_id',$val['candidate_id'])->get('reference')->row_array();
                         $reference_tbl = $val['tables'];
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
                           
                            $status = 'Closed Insufficiency';
                            
                        }else if ($val['analyst_status'] == '10'){
                            $status = 'QC Error'; 
                         
                        }else if ($val['analyst_status'] == '11'){
                            $status = 'Insuff Clear';  
                        }


                          $inputQcStatus = '';
                        if ($val['status'] == '0') {
                            $inputQcStatus = 'Not initiated';
                        } else if ($val['status'] == '1') {
                            $inputQcStatus = 'In Progress';
                        } else if ($val['status'] == '2') {
                            $inputQcStatus = 'Completed';
                        } else if ($val['status']== '3') {
                            $inputQcStatus = 'Insufficiency';
                        } else if ($val['status'] == '4') {
                            $inputQcStatus = 'Verified Clear';
                        } else if ($val['status'] == '5') {
                            $inputQcStatus = 'Stop Check';
                        } else if ($val['status'] == '6') {
                            $inputQcStatus = 'Unable to verify';
                        } else if ($val['status'] == '7') {
                            $inputQcStatus = 'Verified discrepancy';
                        } else if ($val['status'] == '8') {
                            $inputQcStatus = 'Client clarification';
                        } else if ($val['status'] == '9') {
                            $inputQcStatus = 'Closed Insufficiency';
                        }


                        if ($reference_tbl !=null) {
                            $company_name = explode(',', $reference_tbl['company_name']);
                            $designation = explode(',', $reference_tbl['designation']);
                            $contact_number = explode(',', $reference_tbl['contact_number']);
                            $email_id = explode(',', $reference_tbl['email_id']);
                            $years_of_association = explode(',', $reference_tbl['years_of_association']);
                            $contact_start_time = explode(',', $reference_tbl['contact_start_time']);
                            $contact_end_time = explode(',', $reference_tbl['contact_end_time']); 
                            $name = explode(',',$reference_tbl['name']); 
                            $verification_remarks = json_decode($reference_tbl['verification_remarks'],true);
                            $analyst_status = explode(',',$reference_tbl['analyst_status']); 
                            $verified_date = json_decode($reference_tbl['verified_date'],true);
                        }

                        $index = $val['index'];

                        $verification_remark = isset($verification_remarks[$index]['verification_remarks'])?$verification_remarks[$index]['verification_remarks']:'-';
                        $verified_dates = isset($verified_date[$index]['verified_date'])?$verified_date[$index]['verified_date']:'-';
                        $names = isset($name[$index])?$name[$index]:"-";
                        $company_names = isset($company_name[$index])?$company_name[$index]:"-";
                        $designations = isset($designation[$index])?$designation[$index]:"-";
                        $contact_numbers = isset($contact_number[$index])?$contact_number[$index]:"-";
                        $email_ids = isset($email_id[$index])?$email_id[$index]:"-";
                        $years_of_associations = isset($years_of_association[$index])?$years_of_association[$index]:"-"; 
                        $contact_start_times =isset($contact_start_time[$index])?$contact_start_time[$index]:"-";
                        $contact_end_times =isset($contact_end_time[$index])?$contact_end_time[$index]:"-"; 
                        $start_end =  $contact_start_times." - ".$contact_end_times;

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

                             $where = array(
                                'index_no'=>$val['position'],
                                'case_id'=>$val['candidate_id'],
                                'component_id'=>$val['component_id'],
                        );

                         $vendor = $this->db->where($where)->select('vendor.vendor_name,assign_case_to_vendor.created_date AS assigned_to_vendor_date')->from('assign_case_to_vendor')->join('vendor','assign_case_to_vendor.vendor_id = vendor.vendor_id','left')->order_by('assign_case_to_vendor.assign_id','DESC')->get()->row_array();


                     $candidate_data_array = array(  
                        'name' => $names,
                        'contact' => $contact_numbers,
                        'ref_mail' => $email_ids, 
                        'segment' => $segment,
                        'location' => isset($val['location'])?$val['location']:'',
                        'father_name' => $val['father_name'],
                        'date_of_birth' => $val['date_of_birth'],
                        'phone_number' => $val['phone_number'],
                        'employee_id' => $val['employee_id'],
                        'email' => $val['email_id'],
                        'csm' => $val['csm'],
                        'tat' => $val['left_tat_days'],
                        'client_remarks' => $val['remark'],
                        'candidate_id' => $val['candidate_id'],
                        'package_name' => $val['package_name'],
                        'candidate_name' => $val['first_name'].' '.$val['last_name'],
                        'client_name' => $val['client_name'],
                        'candidate_alt_number' => '-',
                        'client_last_name' => '-',
                        'open_component' => '-',
                        'insuff_component' => '-',
                        'spoc_name' => $val['spoc_name'],
                        'priority' => $priority,
                        'status' => $status,
                        'input_status' => $inputQcStatus,
                        'final_status' => $verifiy_img,
                        'vendor_name' => isset($vendor['vendor_name'])?$vendor['vendor_name']:'-', 
                        'vendor_date' => isset($vendor['assigned_to_vendor_date'])?$vendor['assigned_to_vendor_date']:'-',
                        'assigned_team_name'=>$val['assigned_team_name'],
                        'case_submitted_date' => $this->utilModel->get_actual_date_formate_hifun(isset($val['case_submitted_date'])?$val['case_submitted_date']:''),
                        'completed_date' =>$this->utilModel->get_actual_date_formate_hifun(isset($val['report_generated_date'])?$val['report_generated_date']:''),
                        'component_name' =>$val['component_name'], 
                        'created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['created_date']),
                        'insuff_created_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_created_date']),
                        'insuff_close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['insuff_close_date']), 
                        'inputqc_status_date'=>$this->utilModel->get_actual_date_formate_hifun($val['inputqc_status_date']), 
                        'insuff_closure_remarks'=>$val['insuff_remarks'], 
                        'verification_remarks'=>$val['verification_remarks'], 
                        'progress_remarks'=>$val['progress_remarks'], 
                        'close_date'=>$this->utilModel->get_actual_date_formate_hifun($val['analyst_status_date']), 
                        'formNumber'=>$val['formNumber'], 
                       
                     );

                     array_push($candidate_data,$candidate_data_array);
                    }

                }

            }

  
        } 

         $num = 0;

            // create file name
            $fileName = 'reference-component-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            $al = count($data_array)+9;
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A1:'.$alphabet[$al].'1')
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('D3D3D3');
            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'SL No');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Start Date');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case Id');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Name');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Father Name');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'DOB');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Employee ID');
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate E-Mail Id'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Contact Number');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Client Remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Package Name'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Segment'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Refference Name');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Refference Contact'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Refference E-mail'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Initiated Date');  
            // $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Closure date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'No of Forms'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff raised date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff cleared date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Insuff remarks');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'In-Progress remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Verification remarks'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Internal TAT'); 
             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component Closure date');  
             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'InputQc Status');  
             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component Status');  
             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Final Status');  
             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Assigned To');  
             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Name');  
             $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Vendor Initiated Date');  
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Last edited by with date & time'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Case re-open date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Re-opened case closed date'); 
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Component name Re-opened'); 
          
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
                ->getStyle('A'.$rowCount.':'.$alphabet[$num-1].$rowCount)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000'); 
                $num = 0;
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, (++$init));
                        if ($val['case_submitted_date'] !='' && $val['case_submitted_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $case_submitted_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['case_submitted_date']);  
                            
                        }else{
                            $case_submitted_date_cell = '-';
                        }
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $case_submitted_date_cell); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_id']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['candidate_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['father_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['date_of_birth']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['employee_id']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['email']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['phone_number']);  
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['client_remarks']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['package_name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount,  $val['segment']);    
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['name']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['contact']);   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['ref_mail']);
                        if ($val['created_date'] !='' && $val['created_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $created_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['created_date']);  
                            
                        }else{
                            $created_date_cell = '-';
                        }
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $created_date_cell);
                        if ($val['close_date'] !='' && $val['close_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['close_date']);  
                            
                        }else{
                            $close_date_cell = '-';
                        }   
                        // $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $close_date_cell);   
                        $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['formNumber']); 
                        if ($val['insuff_created_date'] !='' && $val['insuff_created_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $insuff_created_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['insuff_created_date']);  
                            
                        }else{
                            $insuff_created_date_cell = '-';
                        } 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $insuff_created_date_cell);
                        if ($val['insuff_close_date'] !='' && $val['insuff_close_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $insuff_close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['insuff_close_date']);  
                            
                        }else{
                            $insuff_close_date_cell = '-';
                        }
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $insuff_close_date_cell); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['insuff_closure_remarks']);  
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['progress_remarks']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['verification_remarks']); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['tat']);
                       if ($val['close_date'] !='' && $val['close_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $close_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['close_date']);  
                            
                        }else{
                            $close_date_cell = '-';
                        }
                         if (in_array($val['status'], ['Not initiated','In Progress','Insufficiency','Pending'])) {
                                $close_date_cell = '-';
                            }
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $close_date_cell); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['input_status']);  
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['status']);  
                            $color_code = '62c4ff';
                        if ($val['final_status'] == 'In Progress') {
                            // code...
                        }
                        if ($val['final_status'] == 'Not Initiated') {
                            // code...
                        }
                        if ($val['final_status'] == 'Verified Discrepancy') {
                          $color_code = 'ec0000';
                        }
                        if ($val['final_status'] == 'Closed insufficiency') {
                           $color_code = 'FFD4AE';
                        }
                        if ($val['final_status'] == 'Unable to Verify') {
                          $color_code = 'FFD4AE';
                        }
                        if ($val['final_status'] == 'Insufficiency') {
                            // code...
                        }
                        if ($val['final_status'] == 'Verified Clear') {
                           $color_code = 'C5FCB4';
                        }
                        if ($val['final_status'] == 'Client Clarification') {
                            // code...
                        }
                        if ($val['final_status'] == 'Qc Error') {
                           $color_code = 'ec0000';
                        }
                        if ($val['final_status'] == 'Stop Check') {
                           $color_code = '62c4ff';
                        }
                         $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num].$rowCount) 
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB($color_code); 
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['final_status']);  
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['assigned_team_name']);  
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $val['vendor_name']);
                       if ($val['vendor_date'] !='' && $val['vendor_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle($alphabet[$num] . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $vendor_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($val['vendor_date']);  
                            
                        }else{
                            $vendor_date_cell = '-';
                        }
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $vendor_date_cell);  
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');   
                       $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, '-');    

                        $rowCount++;
                     }
                    
                  }

                  

                  echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
                                    
            $objWriter = new Xlsx($objPHPExcel);
            $objWriter->save('../uploads/report/'.$fileName);
    }


    function daily_report_s() {
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
                    ->getStyle('A1:AN1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor() 
                    ->setARGB('D3D3D3');

        // set Header
            $objPHPExcel->getActiveSheet()
                ->getStyle('A1:AN1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->getStyle('A1:AN1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr.no.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'initiate Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Client Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'First Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Last Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Father Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Phone Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Date Of Birth');
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
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Case Start Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Case Closure Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Output Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Assigned Role');
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Assigned to Analyst/Specialist');
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Insuff Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Verification Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Insuff Closure Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Progress Remarks');
        $objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'Insuff Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'Insuff Close Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'Panel');
        $objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'Vendor');
        // set Row
        $rowCount = 2;
        $i = 1;

        foreach ($all_cases as $key => $value) {
            $is_submitted = '';
            if ($value['is_submitted'] == '0') {
                $is_submitted = 'Not Initiated';
            } else if ($value['is_submitted'] == '1') {
                $is_submitted = 'In Progress';
            } else if ($value['is_submitted'] == '2') {
                $is_submitted = 'Verified Clear';
            } else if ($value['is_submitted'] == '3') {
                $is_submitted = 'Insuff';
            } else {
                $is_submitted = 'Not Initiated';
            }

            $status = '';
            if ($value['analyst_status'] == '0') {
                $status = 'Not Initiated'; 
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
                $status = 'Closed insufficiency';
            } else if ($value['analyst_status'] == '10') {
                $status = 'QC Error'; 
            } else if ($value['analyst_status'] == '11') {
                $status = 'Insuff Clear';  
            }
               
            $inputQcStatus = '';
            if ($value['status'] == '0') {
                $inputQcStatus = 'Not Initiated';
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
                $inputQcStatus = 'Closed insufficiency';
            }
                 
            $outPutQCStatus = '';
            if ( $value['output_status'] == '0') {
                $outPutQCStatus = 'Not Initiated';
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
                ->getStyle('A'.$rowCount.':AN'.$rowCount)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i++);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value['candidate_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $this->utilModel->get_actual_date_formate_hifun($value['created_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value['client_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['first_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value['last_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value['father_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value['phone_number']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value['email_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $this->utilModel->get_actual_date_formate_hifun($value['date_of_birth']));
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
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $case_submitted_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $inputqc_status_date);
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

            $analyst_status_date = 'NA';
            $show_outputqc_verification_days_taken = 'NA';
            $analyst_status_date_time = 'NA';
            if ($analyst_specialist_status_date != '' && $analyst_specialist_status_date != 'NA' && $value['analyst_status_date'] != '' && $value['analyst_status_date'] != 'NA') {
                $analyst_status_date = $value['analyst_status_date'];
                $analyst_status_date_time_splitted = explode(' ',$analyst_status_date)[0];
                if (!$this->utilModel->check_date_format($analyst_status_date_time_splitted,'Y-m-d')) {
                    $analyst_status_date_splitted = explode('-',$analyst_status_date_time_splitted);
                    $analyst_status_date_time = $analyst_status_date_splitted[1].'/'.$analyst_status_date_splitted[0].'/'.$analyst_status_date_splitted[2];
                } else {
                    $analyst_status_date_time = $analyst_status_date_time_splitted;
                }
                $outputqc_date_difference = date_diff(date_create($analyst_status_date_time),date_create($analyst_status_date_time));
                $show_outputqc_verification_days_taken = $outputqc_date_difference->format("%a");
                if ($outputqc_date_difference->format("%a") > 1) {
                    $show_outputqc_verification_days_taken .= ' days';
                } else {
                    $show_outputqc_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $analyst_specialist_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $analyst_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $show_outputqc_verification_days_taken);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $value['component_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $value['formNumber']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $status);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $this->date_convert($value['case_submitted_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $this->date_convert($value['report_generated_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $outPutQCStatus);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $value['assigned_role']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $value['assigned_team_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $value['insuff_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $value['verification_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $value['insuff_closure_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $value['progress_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $this->date_convert($value['insuff_created_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $this->date_convert($value['insuff_close_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $value['panel']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . $rowCount, $value['vendor']);

            $rowCount++;
        }
             
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save('../uploads/report/'.$fileName);

        echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
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
                $is_submitted = 'Not Initiated';
            } else if ($value['is_submitted'] == '1') {
                $is_submitted = 'In Progress';
            } else if ($value['is_submitted'] == '2') {
                $is_submitted = 'Verified Clear';
            } else if ($value['is_submitted'] == '3') {
                $is_submitted = 'Insuff';
            } else {
                $is_submitted = 'Not Initiated';
            }

            $status = '';
            if ($value['analyst_status'] == '0') {
                $status = 'Not Initiated'; 
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
                $status = 'Closed Insufficiency';
            } else if ($value['analyst_status'] == '10') {
                $status = 'QC Error'; 
            } else if ($value['analyst_status'] == '11') {
                $status = 'Insuff Clear';  
            }
               
            $inputQcStatus = '';
            if ($value['status'] == '0') {
                $inputQcStatus = 'Not Initiated';
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
                $inputQcStatus = 'Closed Insufficiency';
            }
                 
            $outPutQCStatus = '';
            if ( $value['output_status'] == '0') {
                $outPutQCStatus = 'Not Initiated';
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
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $case_submitted_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $inputqc_status_date);
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

            $analyst_status_date = 'NA';
            $show_outputqc_verification_days_taken = 'NA';
            $analyst_status_date_time = 'NA';
            if ($analyst_specialist_status_date != '' && $analyst_specialist_status_date != 'NA' && $value['analyst_status_date'] != '' && $value['analyst_status_date'] != 'NA') {
                $analyst_status_date = $value['analyst_status_date'];
                $analyst_status_date_time_splitted = explode(' ',$analyst_status_date)[0];
                if (!$this->utilModel->check_date_format($analyst_status_date_time_splitted,'Y-m-d')) {
                    $analyst_status_date_splitted = explode('-',$analyst_status_date_time_splitted);
                    $analyst_status_date_time = $analyst_status_date_splitted[1].'/'.$analyst_status_date_splitted[0].'/'.$analyst_status_date_splitted[2];
                } else {
                    $analyst_status_date_time = $analyst_status_date_time_splitted;
                }
                $outputqc_date_difference = date_diff(date_create($analyst_status_date_time),date_create($analyst_status_date_time));
                $show_outputqc_verification_days_taken = $outputqc_date_difference->format("%a");
                if ($outputqc_date_difference->format("%a") > 1) {
                    $show_outputqc_verification_days_taken .= ' days';
                } else {
                    $show_outputqc_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $analyst_specialist_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $analyst_status_date);
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
            // $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
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
                $is_submitted = 'Not Initiated';
            } else if ($value['is_submitted'] == '1') {
                $is_submitted = 'In Progress';
            } else if ($value['is_submitted'] == '2') {
                $is_submitted = 'Verified Clear';
            } else if ($value['is_submitted'] == '3') {
                $is_submitted = 'Insuff';
            } else {
                $is_submitted = 'Not Initiated';
            }

            $status = '';
            if ($value['analyst_status'] == '0') {
                $status = 'Not Initiated'; 
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
                $status = 'Closed Insufficiency';
            } else if ($value['analyst_status'] == '10') {
                $status = 'QC Error'; 
            } else if ($value['analyst_status'] == '11') {
                $status = 'Insuff Clear';  
            }
               
            $inputQcStatus = '';
            if ($value['status'] == '0') {
                $inputQcStatus = 'Not Initiated';
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
                $inputQcStatus = 'Closed Insufficiency';
            }
                 
            $outPutQCStatus = '';
            if ( $value['output_status'] == '0') {
                $outPutQCStatus = 'Not Initiated';
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
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $case_submitted_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $inputqc_status_date);
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

            $analyst_status_date = 'NA';
            $show_outputqc_verification_days_taken = 'NA';
            $analyst_status_date_time = 'NA';
            if ($analyst_specialist_status_date != '' && $analyst_specialist_status_date != 'NA' && $value['analyst_status_date'] != '' && $value['analyst_status_date'] != 'NA') {
                $analyst_status_date = $value['analyst_status_date'];
                $analyst_status_date_time_splitted = explode(' ',$analyst_status_date)[0];
                if (!$this->utilModel->check_date_format($analyst_status_date_time_splitted,'Y-m-d')) {
                    $analyst_status_date_splitted = explode('-',$analyst_status_date_time_splitted);
                    $analyst_status_date_time = $analyst_status_date_splitted[1].'/'.$analyst_status_date_splitted[0].'/'.$analyst_status_date_splitted[2];
                } else {
                    $analyst_status_date_time = $analyst_status_date_time_splitted;
                }
                $outputqc_date_difference = date_diff(date_create($analyst_status_date_time),date_create($analyst_status_date_time));
                $show_outputqc_verification_days_taken = $outputqc_date_difference->format("%a");
                if ($outputqc_date_difference->format("%a") > 1) {
                    $show_outputqc_verification_days_taken .= ' days';
                } else {
                    $show_outputqc_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $analyst_specialist_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $analyst_status_date);
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
             // $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
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
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $this->date_convert($value['created_date'])); 
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $value['insuff_remarks']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $value['verification_remarks']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $value['insuff_closure_remarks']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $value['progress_remarks']); 

            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $this->date_convert($value['insuff_created_date'])); 
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $this->date_convert($value['insuff_close_date'])); 
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
             // $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
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
                $is_submitted = 'Not Initiated';
            } else if ($value['is_submitted'] == '1') {
                $is_submitted = 'In Progress';
            } else if ($value['is_submitted'] == '2') {
                $is_submitted = 'Verified Clear';
            } else if ($value['is_submitted'] == '3') {
                $is_submitted = 'Insuff';
            } else {
                $is_submitted = 'Not Initiated';
            }

            $status = '';
            if ($value['analyst_status'] == '0') {
                $status = 'Not Initiated'; 
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
                $status = 'Closed Insufficiency';
            } else if ($value['analyst_status'] == '10') {
                $status = 'QC Error'; 
            } else if ($value['analyst_status'] == '11') {
                $status = 'Insuff Clear';  
            }
               
            $inputQcStatus = '';
            if ($value['status'] == '0') {
                $inputQcStatus = 'Not Initiated';
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
                $inputQcStatus = 'Closed Insufficiency';
            }
                 
            $outPutQCStatus = '';
            if ( $value['output_status'] == '0') {
                $outPutQCStatus = 'Not Initiated';
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
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $case_submitted_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $inputqc_status_date);
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

            $analyst_status_date = 'NA';
            $show_outputqc_verification_days_taken = 'NA';
            $analyst_status_date_time = 'NA';
            if ($analyst_specialist_status_date != '' && $analyst_specialist_status_date != 'NA' && $value['analyst_status_date'] != '' && $value['analyst_status_date'] != 'NA') {
                $analyst_status_date = $value['analyst_status_date'];
                $analyst_status_date_time_splitted = explode(' ',$analyst_status_date)[0];
                if (!$this->utilModel->check_date_format($analyst_status_date_time_splitted,'Y-m-d')) {
                    $analyst_status_date_splitted = explode('-',$analyst_status_date_time_splitted);
                    $analyst_status_date_time = $analyst_status_date_splitted[1].'/'.$analyst_status_date_splitted[0].'/'.$analyst_status_date_splitted[2];
                } else {
                    $analyst_status_date_time = $analyst_status_date_time_splitted;
                }
                $outputqc_date_difference = date_diff(date_create($analyst_status_date_time),date_create($analyst_status_date_time));
                $show_outputqc_verification_days_taken = $outputqc_date_difference->format("%a");
                if ($outputqc_date_difference->format("%a") > 1) {
                    $show_outputqc_verification_days_taken .= ' days';
                } else {
                    $show_outputqc_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $analyst_specialist_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $analyst_status_date);
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
             // $where = " where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        }

        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
        $candidate_data = array();
        $analyst_data = array();
        foreach ($data as $key => $value) {
            $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']);
            $analyst = array();
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
                           
                            $status = 'Closed Insufficiency';
                            
                        }else if ($val['analyst_status'] == '10'){
                            $status = 'QC Error'; 
                         
                        }else if ($val['analyst_status'] == '11'){
                            $status = 'Insuff Clear';  
                        }
                        array_push($analyst,$val['analyst_status']);
                       

                          $inputQcStatus = '';
                        if ($val['status'] == '0') {
                            $inputQcStatus = 'Not initiated';
                        } else if ($val['status'] == '1') {
                            $inputQcStatus = 'In Progress';
                        } else if ($val['status'] == '2') {
                            $inputQcStatus = 'Completed';
                        } else if ($val['status']== '3') {
                            $inputQcStatus = 'Insufficiency';
                        } else if ($val['status'] == '4') {
                            $inputQcStatus = 'Verified Clear';
                        } else if ($val['status'] == '5') {
                            $inputQcStatus = 'Stop Check';
                        } else if ($val['status'] == '6') {
                            $inputQcStatus = 'Unable to verify';
                        } else if ($val['status'] == '7') {
                            $inputQcStatus = 'Verified discrepancy';
                        } else if ($val['status'] == '8') {
                            $inputQcStatus = 'Client clarification';
                        } else if ($val['status'] == '9') {
                            $inputQcStatus = 'Closed Insufficiency';
                        }
                          $status_date = '';
                          $ouputqc_comment = '';
                         $output ='Pending';
                            if($val['output_status'] == '1') {
                                $output = 'Approved' ;
                            } else if($val['output_status'] == '2') {
                                $output = 'QC Error';
                                $status_date = $val['outputqc_status_date'];
                                $ouputqc_comment = isset($val['ouputqc_comment'])?$val['ouputqc_comment']:'';
                            } 

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

 

                      if (!array_key_exists($val['candidate_id'], $candidate_data)) {
                     $candidate_data[$val['candidate_id']] = array( 
                        'candidate_id' => $val['candidate_id'],
                        'segment' => $segment, 
                        'father_name' => $val['father_name'],
                        'date_of_birth' => $val['date_of_birth'],
                        'phone_number' => $val['phone_number'],
                        'employee_id' => $val['employee_id'],
                        'email' => $val['email_id'],
                        'csm' => $val['csm'],
                        'outputqc_status_date' => $status_date,
                        'ouputqc_comment' => $ouputqc_comment,
                        'client_remarks' => $val['remark'],
                        'package_name' => $val['package_name'],
                        'candidate_name' => $val['first_name'].' '.$val['last_name'],
                        'client_name' => $val['client_name'],
                        'candidate_alt_number' => '-',
                        'client_last_name' => '-',
                        'spoc_name' => $val['spoc_name'],
                        'assigned_team_name' => $val['assigned_team_name'],
                        'loginId' => $val['loginId'],
                        'otp' => $val['otp'],
                        'output' => $output,
                        'priority' => $priority,
                        'tat' => $val['left_tat_days'],
                        'status' => $status,
                        'case_submitted_date' => isset($val['case_submitted_date'])?$val['case_submitted_date']:'',
                        'completed_date' =>isset($val['report_generated_date'])?$val['report_generated_date']:'',
                        'component_name'=>array($val['component_name']),
                     );



                     $client = $val['client_name'];
                     $client_id = $val['client_id'];
                  }else{
                    $candidate_data[$val['candidate_id']]['component_name'] = array_merge($candidate_data[$val['candidate_id']]['component_name'],array($val['component_name'])); 
                  }
                      
                 }




                /* $string_status = 'Verified Clear';
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
                          
                    }*/

                      $verifiy_img = 'In Progress'; 
                    if(in_array('3', $analyst)){
                        $verifiy_img = "Insufficiency"; 
                    }else if (in_array('7', $analyst)) {
                        $verifiy_img = "Verified Discrepancy"; 
                    }else if(array_intersect(['6','9'], $analyst)){
                         if (in_array('6',$analyst)) {
                            $verifiy_img = "Unable to Verify"; 
                        }else if (in_array('9',$analyst)) { 
                         $verifiy_img = "Closed insufficiency"; 
                        }else{
                           $verifiy_img = "Unable to Verify"; 
                        } 
                    }else if(in_array('5', $analyst)){
                        $verifiy_img = "Stop Check"; 
                    }else if(in_array('8', $analyst)){
                         $verifiy_img = 'Client Clarification'; 
                    } else if(in_array('1', $analyst)){
                         $verifiy_img = 'In Progress'; 
                    }else if(in_array('0', $analyst)){
                        $verifiy_img = "Not Initiated"; 
                    }else if(in_array('11', $analyst)){
                        $verifiy_img = "Insuff Clear"; 
                    }else if(in_array('10', $analyst)){
                        $verifiy_img = "Qc Error"; 
                    }else if(in_array('4', $analyst)){
                         if ($value['is_submitted'] =='2') { 
                        $verifiy_img = "Verified Clear"; 
                        }else if ($value['is_submitted'] =='1') {
                           $verifiy_img = "In Progress";
                        }else if ($value['is_submitted'] =='0') {
                           $verifiy_img = "Not Initiated";
                        }
                    } 

                    array_push($analyst_data,$verifiy_img);

                 }
            
  
            // create file name 
            $fileName = 'outputqc-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A1:W1')
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor() 
                        ->setARGB('D3D3D3');
            
            // set Header
            $objPHPExcel->getActiveSheet()
                ->getStyle('A1:W1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
            $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'SL.no.');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case start date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Case Id');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Candidate Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Father Name');     
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'DOB');       
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Employe ID');     
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Candidate E-mail');       
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Candidate Contact');       
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Client Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Client Remarks');     
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Package Name');     
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Segment');  
            $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Case Priority');     
            $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Final Case Status');   
            $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Error / Rectified');     
            $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Error raised date');  
            $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Error closure date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'outPutQc date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Internal TAT');     
            $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Intrerim report generated date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Interim report generated date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'No of times interim report generated');     
            
            $rowCount = 2;
            $i =1;
 
            $n = 0;
            foreach ($candidate_data as $key => $value) { 
                $an_status = isset($analyst_data[$n])?$analyst_data[$n]:'';
                $n++;
                $priority ='';
            if($value['priority'] == '0'){
                    $priority = 'Low priority' ;
            }else if($value['priority'] == '1'){  
                    $priority = 'Medium priority' ;
            }else if($value['priority'] == '2'){  
                    $priority = 'High priority' ;
                  
            }
               $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':O'.$rowCount)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');  
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i++);
                if ($value['case_submitted_date'] !='' && $value['case_submitted_date'] !='-') {
                            $objPHPExcel->getActiveSheet()
                            ->getStyle('B' . $rowCount)
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); 
                            $case_submitted_date = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($value['case_submitted_date']);  
                            
                 }else{
                            $case_submitted_date = '-';
                }
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $case_submitted_date); 
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value['candidate_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value['candidate_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['father_name']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value['date_of_birth']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value['employee_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value['email']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value['phone_number']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value['client_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value['client_remarks']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $value['package_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $value['segment']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $priority);  
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $an_status);  
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $value['output']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $value['outputqc_status_date']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $value['ouputqc_comment']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $value['completed_date']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $value['tat']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, '-');  
                $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, '-');   
               
                $rowCount++;

            }
 
         
     
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
        $input =''; 
        $and =''; 
        if ($this->session->userdata('logged-in-inputqc')) {
           $inputc = $this->session->userdata('logged-in-inputqc');
           $input = ' assigned_inputqc_id = '.$inputc['team_id'];
            $and =' AND '; 
           // $this->db->where('assigned_inputqc_id',$inputc['team_id']);
        }

              $where ='';
        if ($this->input->post('duration') == 'today') {
          $where=" where date(created_date) = CURDATE()" .$and.$input;
        }else if($this->input->post('duration') == 'week'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()" .$and.$input;
        }else if($this->input->post('duration') == 'month'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()" .$and.$input;
        }else if($this->input->post('duration') == 'year'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()" .$and.$input;
        }else if($this->input->post('duration') == 'between'){
          $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'" .$and.$input;
        }else{
            $where="";
            if ($input !='') {
               $where="where ".$input;
            }
        }

        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
            $candidate_data = array();

            foreach ($data as $key => $value) { 
                $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']); 
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
                           
                            $status = 'Closed Insufficiency';
                            
                        }else if ($val['analyst_status'] == '10'){
                            $status = 'QC Error'; 
                         
                        }else if ($val['analyst_status'] == '11'){
                            $status = 'Insuff Clear';  
                        }


                          $inputQcStatus = '';
                        if ($val['status'] == '0') {
                            $inputQcStatus = 'Not initiated';
                        } else if ($val['status'] == '1') {
                            $inputQcStatus = 'In Progress';
                        } else if ($val['status'] == '2') {
                            $inputQcStatus = 'Completed';
                        } else if ($val['status']== '3') {
                            $inputQcStatus = 'Insufficiency';
                        } else if ($val['status'] == '4') {
                            $inputQcStatus = 'Verified Clear';
                        } else if ($val['status'] == '5') {
                            $inputQcStatus = 'Stop Check';
                        } else if ($val['status'] == '6') {
                            $inputQcStatus = 'Unable to verify';
                        } else if ($val['status'] == '7') {
                            $inputQcStatus = 'Verified discrepancy';
                        } else if ($val['status'] == '8') {
                            $inputQcStatus = 'Client clarification';
                        } else if ($val['status'] == '9') {
                            $inputQcStatus = 'Closed Insufficiency';
                        }
                          

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

 
                      if (!array_key_exists($val['candidate_id'], $candidate_data)) {
                     $candidate_data[$val['candidate_id']] = array( 
                        'candidate_id' => $val['candidate_id'],
                        'segment' => $segment, 
                        'father_name' => $val['father_name'],
                        'date_of_birth' => $val['date_of_birth'],
                        'phone_number' => $val['phone_number'],
                        'employee_id' => $val['employee_id'],
                        'email' => $val['email_id'],
                        'csm' => $val['csm'],
                        'client_remarks' => $val['remark'],
                        'package_name' => $val['package_name'],
                        'candidate_name' => $val['first_name'].' '.$val['last_name'],
                        'client_name' => $val['client_name'],
                        'candidate_alt_number' => '-',
                        'client_last_name' => '-',
                        'spoc_name' => $val['spoc_name'],
                        'assigned_team_name' => $val['inputq'],
                        'loginId' => $val['loginId'],
                        'otp' => $val['otp'],
                        'priority' => $priority,
                        'tat' => $val['left_tat_days'],
                        'status' => $inputQcStatus,
                        'case_submitted_date' => isset($val['case_submitted_date'])?$val['case_submitted_date']:'',
                        'completed_date' =>isset($val['report_generated_date'])?$val['report_generated_date']:'',
                        'component_name'=>array($val['component_name']),
                     );



                     $client = $val['client_name'];
                     $client_id = $val['client_id'];
                  }else{
                    $candidate_data[$val['candidate_id']]['component_name'] = array_merge($candidate_data[$val['candidate_id']]['component_name'],array($val['component_name'])); 
                  }
                      
                 }
            }
 

            
            // create file name
            $fileName = 'inputqc-report-'.time().'.xlsx';   
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A1:W1')
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor() 
                        ->setARGB('D3D3D3');
            
            // set Header
            $objPHPExcel->getActiveSheet()
                ->getStyle('A1:W1')
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');
            $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'SL.no.');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Case start date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Case Id');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Candidate Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Father Name');     
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'DOB');       
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Employe ID');     
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Candidate E-mail');       
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Candidate Contact');       
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Client Name');       
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Client Remarks');     
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Package Name');     
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Segment');     
            $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Components');  
            $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Case Priority');     
            $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Case Status');   
            $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Login Id');     
            $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'OTP');  
            $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Case completed date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Case assigned to');     
            $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Actual days');     
            $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Case Reopend date');     
            $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Component re-opened');     
            
            $rowCount = 2;
            $i =1;
 
    
            foreach ($candidate_data as $key => $value) { 

                $priority ='';
            if($value['priority'] == '0'){
                    $priority = 'Low priority' ;
            }else if($value['priority'] == '1'){  
                    $priority = 'Medium priority' ;
            }else if($value['priority'] == '2'){  
                    $priority = 'High priority' ;
                  
            }
               $objPHPExcel->getActiveSheet()
                ->getStyle('A'.$rowCount.':W'.$rowCount)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->getColor()
                ->setRGB('000000');  
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i++);
 

                if ($value['case_submitted_date'] !='' && $value['case_submitted_date'] !='-') {
                    $objPHPExcel->getActiveSheet()
                    ->getStyle('B' . $rowCount)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
                    $case_submitted_date = $this->utilModel->get_actual_date_formate_hifun($value['case_submitted_date']);
                    $case_submitted_date_cell = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($case_submitted_date);  
                    
                }else{
                    $case_submitted_date_cell = '-';
                }
                
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $case_submitted_date_cell); 
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value['candidate_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value['candidate_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['father_name']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value['date_of_birth']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value['employee_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value['email']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value['phone_number']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value['client_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value['client_remarks']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $value['package_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $value['segment']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, implode(',', array_unique($value['component_name'])));  
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $priority);  
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $value['status']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $value['loginId']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $value['otp']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $value['completed_date']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $value['assigned_team_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $value['tat']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, '-');  
                $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, '-');  
               
                $rowCount++;

            }
          
     
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
                $is_submitted = 'Not Initiated';
            } else if ($value['is_submitted'] == '1') {
                $is_submitted = 'In Progress';
            } else if ($value['is_submitted'] == '2') {
                $is_submitted = 'Verified Clear';
            } else if ($value['is_submitted'] == '3') {
                $is_submitted = 'Insuff';
            } else {
                $is_submitted = 'Not Initiated';
            }

            $status = '';
            if ($value['analyst_status'] == '0') {
                $status = 'Not Initiated'; 
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
                $status = 'Closed Insufficiency';
            } else if ($value['analyst_status'] == '10') {
                $status = 'QC Error'; 
            } else if ($value['analyst_status'] == '11') {
                $status = 'Insuff Clear';  
            }
               
            $inputQcStatus = '';
            if ($value['status'] == '0') {
                $inputQcStatus = 'Not Initiated';
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
                $inputQcStatus = 'Closed Insufficiency';
            }
                 
            $outPutQCStatus = '';
            if ( $value['output_status'] == '0') {
                $outPutQCStatus = 'Not Initiated';
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
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $case_submitted_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $inputqc_status_date);
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

            $analyst_status_date = 'NA';
            $show_outputqc_verification_days_taken = 'NA';
            $analyst_status_date_time = 'NA';
            if ($analyst_specialist_status_date != '' && $analyst_specialist_status_date != 'NA' && $value['analyst_status_date'] != '' && $value['analyst_status_date'] != 'NA') {
                $analyst_status_date = $value['analyst_status_date'];
                $analyst_status_date_time_splitted = explode(' ',$analyst_status_date)[0];
                if (!$this->utilModel->check_date_format($analyst_status_date_time_splitted,'Y-m-d')) {
                    $analyst_status_date_splitted = explode('-',$analyst_status_date_time_splitted);
                    $analyst_status_date_time = $analyst_status_date_splitted[1].'/'.$analyst_status_date_splitted[0].'/'.$analyst_status_date_splitted[2];
                } else {
                    $analyst_status_date_time = $analyst_status_date_time_splitted;
                }
                $outputqc_date_difference = date_diff(date_create($analyst_status_date_time),date_create($analyst_status_date_time));
                $show_outputqc_verification_days_taken = $outputqc_date_difference->format("%a");
                if ($outputqc_date_difference->format("%a") > 1) {
                    $show_outputqc_verification_days_taken .= ' days';
                } else {
                    $show_outputqc_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $analyst_specialist_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $analyst_status_date);
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
                $is_submitted = 'Not Initiated';
            } else if ($value['is_submitted'] == '1') {
                $is_submitted = 'In Progress';
            } else if ($value['is_submitted'] == '2') {
                $is_submitted = 'Verified Clear';
            } else if ($value['is_submitted'] == '3') {
                $is_submitted = 'Insuff';
            } else {
                $is_submitted = 'Not Initiated';
            }

            $status = '';
            if ($value['analyst_status'] == '0') {
                $status = 'Not Initiated'; 
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
                $status = 'Closed Insufficiency';
            } else if ($value['analyst_status'] == '10') {
                $status = 'QC Error'; 
            } else if ($value['analyst_status'] == '11') {
                $status = 'Insuff Clear';  
            }
               
            $inputQcStatus = '';
            if ($value['status'] == '0') {
                $inputQcStatus = 'Not Initiated';
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
                $inputQcStatus = 'Closed Insufficiency';
            }
                 
            $outPutQCStatus = '';
            if ( $value['output_status'] == '0') {
                $outPutQCStatus = 'Not Initiated';
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
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $case_submitted_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $inputqc_status_date);
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

            $analyst_status_date = 'NA';
            $show_outputqc_verification_days_taken = 'NA';
            $analyst_status_date_time = 'NA';
            if ($analyst_specialist_status_date != '' && $analyst_specialist_status_date != 'NA' && $value['analyst_status_date'] != '' && $value['analyst_status_date'] != 'NA') {
                $analyst_status_date = $value['analyst_status_date'];
                $analyst_status_date_time_splitted = explode(' ',$analyst_status_date)[0];
                if (!$this->utilModel->check_date_format($analyst_status_date_time_splitted,'Y-m-d')) {
                    $analyst_status_date_splitted = explode('-',$analyst_status_date_time_splitted);
                    $analyst_status_date_time = $analyst_status_date_splitted[1].'/'.$analyst_status_date_splitted[0].'/'.$analyst_status_date_splitted[2];
                } else {
                    $analyst_status_date_time = $analyst_status_date_time_splitted;
                }
                $outputqc_date_difference = date_diff(date_create($analyst_status_date_time),date_create($analyst_status_date_time));
                $show_outputqc_verification_days_taken = $outputqc_date_difference->format("%a");
                if ($outputqc_date_difference->format("%a") > 1) {
                    $show_outputqc_verification_days_taken .= ' days';
                } else {
                    $show_outputqc_verification_days_taken .= ' day';
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $analyst_specialist_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $analyst_status_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $show_outputqc_verification_days_taken);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $value['component_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $value['formNumber']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $status);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $outPutQCStatus);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $value['assigned_role']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $value['assigned_team_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $this->utilModel->get_actual_date_formate_hifun($value['case_submitted_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $value['insuff_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $value['verification_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $value['insuff_closure_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $value['progress_remarks']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $this->utilModel->get_actual_date_formate_hifun($value['insuff_created_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $this->utilModel->get_actual_date_formate_hifun($value['insuff_close_date']));
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $value['panel']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $value['vendor']);

            $rowCount++;
        }
             
        $objWriter = new Xlsx($objPHPExcel);
        $objWriter->save('../uploads/report/'.$fileName);

        echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));
    } 



    function daily_report_insuff(){
      
    $alphabet = $this->utilModel->return_excel_val();
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
                    
                      if ($val['analyst_status']== '3') {
                                    array_push($all_cases, $val);
                    }
                      
                 }
            }


          
            
          
             $num = 0;
            // create file name
            $fileName = 'insuff-component-report-'.time().'.xlsx';   
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
            $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++].'1', 'Candidate Contact Number');     
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
      


            // set Row
            $rowCount = 2;
            $i =1;
 
            foreach ($all_cases as $key => $value) {
      $num =0;

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
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $this->utilModel->get_actual_date_formate_hifun($value['case_submitted_date']));
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['candidate_id']);
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['candidate_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['father_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['date_of_birth']);    
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
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $this->utilModel->get_actual_date_formate_hifun($value['insuff_created_date']));  
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$num++] . $rowCount, $value['insuff_close_date']);  
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
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value['error_created_date']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value['added_by_name']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $value['role']);  
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $value['created_date']);  

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