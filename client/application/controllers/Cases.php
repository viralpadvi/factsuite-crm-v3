<?php
/**
 * 
 */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Cases extends CI_Controller {
	
	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url'); 
	  	$this->load->model('caseModel');  
	  	$this->load->model('emailModel');       
	  	$this->load->model('smsModel');       
	  	$this->load->model('notificationModel');       
        $this->load->model('utilModel'); 
        $this->load->model('client_Analytics_Model'); 
	  	$this->load->model('pagination_Model');
	  	$this->load->library('zip');
        $this->load->library('pagination');
	}




    function get_report_bulk(){ 
        $client = $this->session->userdata('logged-in-client');
          $candidate = $this->db->where('client_id',$client['client_id'])->where('is_submitted',2)->order_by('candidate_id','DESC')->get('candidate')->result_array();

          foreach ($candidate as $key => $value) { 
            if ($value['candidate_final_report'] !='' && $value['candidate_final_report'] !=null && $value['candidate_final_report'] !='undefined') {
                  $path = $this->config->item('doc_path')."uploads/bgv-report/".$value['candidate_final_report']; 
                $ext = pathinfo($value['candidate_final_report'], PATHINFO_EXTENSION);
                $this->zip->read_file($path,'Reports/'.$value['candidate_final_report']); 
            }
          }
 
        /* $path = $this->config->item('doc_path').'uploads/aadhar-docs/622a1b060d59320220310153638.png';
        $path1 $this->config->item('doc_path').'uploads/aadhar-docs/622a1b060d59320220310153638.png';
        $this->zip->read_file($path,'aadhar/test.png');
        $this->zip->read_file($path1,'aadhar/test1.png'); */
        // $this->zip->download($client['client_id'].'-candidate-reports.zip');
        // echo $client['client_id'].'-candidate-reports.zip';

       $this->zip->archive('../uploads/zip/'.$client['client_id'].'-candidate-reports.zip');
       // $this->zip->download($client['client_id'].'-candidate-reports.zip');
       echo json_encode(array('url'=>base_url().'../uploads/zip/'.$client['client_id'].'-candidate-reports.zip'));
    }
  


    function check_admin_login() {
        if(!$this->session->userdata('logged-in-client')) {
            redirect($this->config->item('my_base_url').'clientLogin');
        }
    }

    function get_single_component($component) {
        return $this->db->where('component_id',$component)->get('components')->row_array();
    }

    function get_date_formate(){
        echo $this->utilModel->get_date_formate($this->input->post('curr_date'));
    }

    function add_timezone(){
        echo json_encode($this->caseModel->add_timezone());
    }

    function get_timezone(){
         echo json_encode($this->caseModel->get_timezone());
    }

    function get_all_cases_with_pagination() {
        $search = array(
            'keyword' => trim($this->input->post('search_key')),
        );
        
        $limit = $this->input->post('filter_cases_number') != '' ? $this->input->post('filter_cases_number') : 100;
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $variable_array = array(
            'limit' => $limit,
            'offset' => $offset,
            'search' => $search,
            'count' => true
        );

        $variable_array_2 = array(
            'base_url' => site_url($this->input->post('site_url')),
            'total_rows' => $this->caseModel->get_all_cases($variable_array),
            'per_page' => $limit
        );

        $get_pagination_links = $this->pagination_Model->get_pagination_links($variable_array_2);
        
        $this->pagination->initialize($get_pagination_links);

        $variable_array = array(
            'limit' => $limit,
            'offset' => $offset,
            'search' => $search,
            'count' => false
        );

        $data['case_list'] = $this->caseModel->get_all_cases($variable_array);
    
        $data['pagelinks'] = $this->pagination->create_links();
        $data['last_number_id'] = $offset;
        $data['request_from_page'] = $this->input->post('case_list_request_type');

        $this->load->view('client/case/case-list-v2', $data);
    }

	function get_zip($candidate_id){

		$table = $this->caseModel->all_components($candidate_id); 

		if (isset($table['document_check']['document_check_id'])) {
           $folder = $this->get_single_component(3)['fs_website_component_name'];
            
			if ($table['document_check']['adhar_doc'] !='' && $table['document_check']['adhar_doc'] !=null) {
				foreach (explode(',', $table['document_check']['adhar_doc']) as $key => $value) { 
				 $path = $this->config->item('doc_path').'uploads/aadhar-docs/'.$value;
					$ext = pathinfo($value, PATHINFO_EXTENSION);
				$this->zip->read_file($path,$candidate_id.'_'.$folder['fs_website_component_name'].'/case_'.$candidate_id.'aadhar.'.$ext);
				}
			}
			if ($table['document_check']['pan_card_doc'] !='' && $table['document_check']['pan_card_doc'] !=null) {
				foreach (explode(',', $table['document_check']['pan_card_doc']) as $key => $value) { 
				 $path = $this->config->item('doc_path').'uploads/pan-docs/'.$value;
					$ext = pathinfo($value, PATHINFO_EXTENSION);
				$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'pan_card_doc.'.$ext);
				}
			}
			if ($table['document_check']['passport_doc'] !='' && $table['document_check']['passport_doc'] !=null) {
				foreach (explode(',', $table['document_check']['passport_doc']) as $key => $value) { 
				 $path = $this->config->item('doc_path').'uploads/proof-docs/'.$value;
					$ext = pathinfo($value, PATHINFO_EXTENSION);
				$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'passport_doc.'.$ext);
				}
			}
			if ($table['document_check']['voter_doc'] !='' && $table['document_check']['voter_doc'] !=null) {
				foreach (explode(',', $table['document_check']['voter_doc']) as $key => $value) { 
				 $path = $this->config->item('doc_path').'uploads/voter-docs/'.$value;
					$ext = pathinfo($value, PATHINFO_EXTENSION);
				$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'voter_doc.'.$ext);
				}
			}
			if ($table['document_check']['ssn_doc'] !='' && $table['document_check']['ssn_doc'] !=null) {
				foreach (explode(',', $table['document_check']['ssn_doc']) as $key => $value) { 
				 $path = $this->config->item('doc_path').'uploads/ssn_doc/'.$value;
					$ext = pathinfo($value, PATHINFO_EXTENSION);
				$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'ssn_doc.'.$ext);
				}
			}

        }
			
			/* Start Education */
			if (isset($table['education_details']['education_details_id'])) {
                $folder = $this->get_single_component(7)['fs_website_component_name'];
				$all_sem_marksheet = json_decode($table['education_details']['all_sem_marksheet'],true);
                $convocation = json_decode($table['education_details']['convocation'],true);
                $marksheet_provisional_certificate = json_decode($table['education_details']['marksheet_provisional_certificate'],true);
                $ten_twelve_mark_card_certificate = json_decode($table['education_details']['ten_twelve_mark_card_certificate'],true); 
                $type_of_degrees = json_decode(isset($table['education_details']['type_of_degree'])?$table['education_details']['type_of_degree']:0,true);

            foreach($type_of_degrees as $key => $value) { 
             if (isset($all_sem_marksheet[$key])) { 
                   foreach ($all_sem_marksheet[$key] as $key1 => $value) {
                      if ($value !='' && $value !='no-file') {
                       
                         $path = $this->config->item('doc_path').'uploads/all-marksheet-docs/'.$value;
                        $ext = pathinfo($value, PATHINFO_EXTENSION);
                        $this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'convocation.'.$ext); 
                      }
                   } 
               } 

                 if (isset($convocation[$key])) { 
                       foreach ($convocation[$key] as $key1 => $value) {
                          if ($value !='' && $value !='no-file') {

                          	 $path = $this->config->item('doc_path').'uploads/convocation-docs/'.$value;
							$ext = pathinfo($value, PATHINFO_EXTENSION);
						$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'convocation.'.$ext); 
                          }
                       }
                      
                   } 

                   if (isset($marksheet_provisional_certificate[$key])) {
                        
                           foreach ($marksheet_provisional_certificate[$key] as $key1 => $value) {
                              if ($value !='' && $value !='no-file') {
                              	 $path = $this->config->item('doc_path').'uploads/marksheet-certi-docs/'.$value;
								$ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'marksheet.'.$ext); 
                                
                              }
                           }  
                	}

                  if (isset($ten_twelve_mark_card_certificate[$key])) {
                         
                           foreach ($ten_twelve_mark_card_certificate[$key] as $key1 => $value) {
                              if ($value !='' && $value !='no-file') {
                              		 $path = $this->config->item('doc_path').'uploads/ten-twelve-docs/'.$value;
								$ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'ten-twelve.'.$ext); 

                              }
                           } 
                       } 
                }

            }

                /* End of Education */ 

                /* Current Employment */

                if (isset($table['current_employment']['current_emp_id'])) {
                     $folder = $this->get_single_component(6)['fs_website_component_name'];
                	  $appointment_letter = explode(",",$table['current_employment']['appointment_letter']); 
                      $experience_relieving_letter = explode(",",$table['current_employment']['experience_relieving_letter']); 
                      $last_month_pay_slip = explode(",",$table['current_employment']['last_month_pay_slip']); 
                      $bank_statement_resigngation_acceptance = explode(",",$table['current_employment']['bank_statement_resigngation_acceptance']);

                       foreach ($appointment_letter as $key => $value) {  
                                       $path = $this->config->item('doc_path').'uploads/appointment_letter/'.$value;
								$ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'appointment_letter.'.$ext); 
                        } 

                        foreach ($experience_relieving_letter as $key => $value) {  
                                       $path = $this->config->item('doc_path').'uploads/experience_relieving_letter/'.$value;
								$ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'experience_relieving_letter.'.$ext); 
                        }

                        foreach ($last_month_pay_slip as $key => $value) {  
                                       $path = $this->config->item('doc_path').'uploads/last_month_pay_slip/'.$value;
								$ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'last_month_pay_slip.'.$ext); 
                        }


                        foreach ($bank_statement_resigngation_acceptance as $key => $value) {  
                                 $path = $this->config->item('doc_path').'uploads/bank_statement_resigngation_acceptance/'.$value;
								$ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'bank_statement_resigngation_acceptance.'.$ext); 
                        }
                }

                /* End of current employment */

                /*DL*/

                if (isset($table['driving_licence']['licence_id'])) {
                     $folder = $this->get_single_component(16)['fs_website_component_name'];
                	$licence_doc = $table['driving_licence']['licence_doc']; 
                    $ext = pathinfo($licence_doc, PATHINFO_EXTENSION);
                    $url = $this->config->item('doc_path')."uploads/licence-docs/".$licence_doc;  
					$this->zip->read_file($url,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'driving_licence.'.$ext); 
                }

                /*previous EMP*/
                if (isset($table['previous_employment']['previous_emp_id'])) {
                     $folder = $this->get_single_component(10)['fs_website_component_name'];
                	$appointment_letter = json_decode($table['previous_employment']['appointment_letter'],true);
                    $experience_relieving_letter = json_decode($table['previous_employment']['experience_relieving_letter'],true);
                    $bank_statement_resigngation_acceptance = json_decode($table['previous_employment']['bank_statement_resigngation_acceptance'],true);
                    $last_month_pay_slip = json_decode($table['previous_employment']['last_month_pay_slip'],true);
                    $company_name = json_decode($table['previous_employment']['company_name'],true);

                    foreach ($company_name as $key => $value) { 
                    if(isset($appointment_letter[$key])){  
                        foreach ($appointment_letter[$key] as $key => $value) {  
                        	if ($value !='' && $value !='no-file') {
                                       $path = $this->config->item('doc_path').'uploads/appointment_letter/'.$value;
								$ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'appointment_letter.'.$ext); 
                        } 
                        } 
                    }
                    if(isset($experience_relieving_letter[$key])){ 
                        foreach ($experience_relieving_letter[$key] as $key => $value) { 
                        if ($value !='' && $value !='no-file') { 
                                       $path = $this->config->item('doc_path').'uploads/experience_relieving_letter/'.$value;
								$ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'experience_relieving_letter.'.$ext); 
                        }
                        }
                    }

                    if(isset($last_month_pay_slip[$key])){  
                        foreach ($last_month_pay_slip[$key] as $key => $value) { 
                        if ($value !='' && $value !='no-file') { 
                                       $path = $this->config->item('doc_path').'uploads/last_month_pay_slip/'.$value;
								$ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'last_month_pay_slip.'.$ext); 
                        }
                        }
                    }

                    if(isset($bank_statement_resigngation_acceptance[$key])){ 
                        foreach ($bank_statement_resigngation_acceptance[$key] as $key => $value) {  
                        	if ($value !='' && $value !='no-file') {
                                 $path = $this->config->item('doc_path').'uploads/bank_statement_resigngation_acceptance/'.$value;
								$ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'bank_statement_resigngation_acceptance.'.$ext); 
                        }
                        }
                    }

              		}

                }

                /*end prev EMP*/

                /*present_address*/
                if (isset($table['present_address']['present_address_id'])) {
                     $folder = $this->get_single_component(8)['fs_website_component_name'];
                	  if (isset($table['present_address']['rental_agreement'])) {
                     if (!in_array('no-file',explode(',', $table['present_address']['rental_agreement']))) {
                       foreach (explode(',', $table['present_address']['rental_agreement']) as $key1 => $value) {
                          if ($value !='') {
                             $path = $this->config->item('doc_path')."uploads/rental-docs/".$value; 
                            $ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'rental.'.$ext); 
                          }
                       }
                     // $rental_agreement = $rental_agreement[$key];
                     }}

                      if (isset($table['present_address']['ration_card'])) {
                         if (!in_array('no-file',explode(',', $table['present_address']['ration_card']))) {
                           foreach (explode(',', $table['present_address']['ration_card']) as $key1 => $value) {
                              if ($value !='') { 
                                  $path = $this->config->item('doc_path')."uploads/ration-docs/".$value; 
                            $ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'ration.'.$ext); 
                              }
                           }
                         // $rental_agreement = $rental_agreement[$key];
                         }} 

                          if (isset($table['present_address']['gov_utility_bill'])) {
                                 if (!in_array('no-file',explode(',',$table['present_address']['gov_utility_bill']))) {
                                   foreach (explode(',',$table['present_address']['gov_utility_bill']) as $key1 => $value) {
                                      if ($value !='') { 
                                          $path = $this->config->item('doc_path')."uploads/gov-docs/".$value; 
			                            $ext = pathinfo($value, PATHINFO_EXTENSION);
										$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'gov.'.$ext); 
                                      }
                                   } 
                                 }} 

                }
                /*END present add*/

                /* permanent_address */
                if (isset($table['permanent_address']['permanent_address_id'])) {
                     $folder = $this->get_single_component(9)['fs_website_component_name'];
                	 if (isset($table['permanent_address']['rental_agreement'])) {
                     if (!in_array('no-file',explode(',', $table['permanent_address']['rental_agreement']))) {
                       foreach (explode(',', $table['permanent_address']['rental_agreement']) as $key1 => $value) {
                          if ($value !='') {
                             $path = $this->config->item('doc_path')."uploads/rental-docs/".$value; 
                            $ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'rental.'.$ext); 
                          }
                       }
                     // $rental_agreement = $rental_agreement[$key];
                     }}

                      if (isset($table['permanent_address']['ration_card'])) {
                         if (!in_array('no-file',explode(',', $table['permanent_address']['ration_card']))) {
                           foreach (explode(',', $table['permanent_address']['ration_card']) as $key1 => $value) {
                              if ($value !='') { 
                                  $path = $this->config->item('doc_path')."uploads/ration-docs/".$value; 
                            $ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'ration.'.$ext); 
                              }
                           }
                         // $rental_agreement = $rental_agreement[$key];
                         }} 

                          if (isset($table['permanent_address']['gov_utility_bill'])) {
                                 if (!in_array('no-file',explode(',',$table['permanent_address']['gov_utility_bill']))) {
                                   foreach (explode(',',$table['permanent_address']['gov_utility_bill']) as $key1 => $value) {
                                      if ($value !='') { 
                                          $path = $this->config->item('doc_path')."uploads/gov-docs/".$value; 
			                            $ext = pathinfo($value, PATHINFO_EXTENSION);
										$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'gov.'.$ext); 
                                      }
                                   } 
                                 }} 
                }

                /*END permanent_address*/

                if (isset($table['previous_address']['previos_address_id'])) {
                    $folder = $this->get_single_component(12)['fs_website_component_name'];
                	 $rental_agreement = json_decode($table['previous_address']['rental_agreement'],true);  
                    $ration_card = json_decode($table['previous_address']['ration_card'],true);  
                    $gov_utility_bill = json_decode($table['previous_address']['gov_utility_bill'],true);
                    $flat_no = json_decode($table['previous_address']['flat_no'],true); 

                    foreach ($flat_no as $key => $value) {
                    	 
                     if (isset($rental_agreement[$key])) {
                                 if (!in_array('no-file',$rental_agreement[$key])) {
                                   foreach ($rental_agreement[$key] as $key1 => $value) {
                                      if ($value !='') {
                                      	  $path = $this->config->item('doc_path')."uploads/rental-docs/".$value; 
                            $ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'rental.'.$ext); 
                                      }
                                    }
                                }
                        }

                     if (isset($ration_card[$key])) {
                                 if (!in_array('no-file',$ration_card[$key])) {
                                   foreach ($ration_card[$key] as $key1 => $value) {
                                      if ($value !='') {
                                      	 $path = $this->config->item('doc_path')."uploads/ration-docs/".$value; 
                            $ext = pathinfo($value, PATHINFO_EXTENSION);
							$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'ration.'.$ext); 
                                      }
                                    }
                                }
                        }
                        

                     if (isset($gov_utility_bill[$key])) {
                                 if (!in_array('no-file',$gov_utility_bill[$key])) {
                                   foreach ($gov_utility_bill[$key] as $key1 => $value) {
                                      if ($value !='') {
                                      	  $path = $this->config->item('doc_path')."uploads/gov-docs/".$value; 
			                            $ext = pathinfo($value, PATHINFO_EXTENSION);
										$this->zip->read_file($path,$candidate_id.'_'.$folder.'/case_'.$candidate_id.'gov.'.$ext); 
                                      }
                                    }
                                }
                        }
                        

                }
            }
            /*END*/

            $sign = $this->db->where('candidate_id',$candidate_id)->order_by('','DESC')->get('signature')->row_array();
            if ($sign !='') {
            	  $path = $this->config->item('doc_path')."uploads/doc_signs/".$sign['signature_img']; 
                $ext = pathinfo($sign['signature_img'], PATHINFO_EXTENSION);
				$this->zip->read_file($path,$candidate_id.'_'.'Consent Form/case_'.$candidate_id.'signature.'.$ext); 
            }

 
		 
		/* $path = $this->config->item('doc_path').'uploads/aadhar-docs/622a1b060d59320220310153638.png';
		$path1 $this->config->item('doc_path').'uploads/aadhar-docs/622a1b060d59320220310153638.png';
		$this->zip->read_file($path,'aadhar/test.png');
		$this->zip->read_file($path1,'aadhar/test1.png'); */
		$this->zip->download('case_id-'.$candidate_id.'-candidate-documents.zip');
	}

	function get_all_cases(){
		$data = $this->caseModel->get_all_cases();
		echo json_encode($data);
	}

	function get_case_skills($package_id =''){
		$data['client'] = $this->caseModel->get_single_client_data();
		$data['components'] = $this->caseModel->get_component_details();
		$data['package_data'] = $this->caseModel->get_single_component_name($package_id);
        if ($this->input->post('candidate_id')) { 
        $data['candidate'] = $this->caseModel->get_single_case($this->input->post('candidate_id'));
        }else{
         $data['candidate'] = array();   
        }
        
		echo json_encode($data); 
	} 

	function get_case_package(){
		$data = $this->caseModel->get_case_package();
		echo json_encode($data);		
	}

	function valid_mail(){
		$data = $this->caseModel->valid_mail();
		echo json_encode($data);
	}

	function insert_case(){
		$data = $this->caseModel->insert_case();
		echo json_encode($data);
	}

	function update_case(){
		$data = $this->caseModel->update_case();
		echo json_encode($data);
	}

	function valid_phone_number(){
		$data = $this->caseModel->valid_phone_number($this->input->post('contact'));
		echo json_encode($data);
	}

	function get_single_case($candidate_id){
		$data = $this->caseModel->get_single_case_details($candidate_id);
		echo json_encode($data);
	}


	function import_excel(){
	 $user = $this->session->userdata('logged-in-client');
		 // If file uploaded
            if(!empty($_FILES['files']['name'])) { 
                // get file extension
                $extension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);
 
                if($extension == 'csv'){
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } elseif($extension == 'xlsx') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }
                // file path
                $spreadsheet = $reader->load($_FILES['files']['tmp_name']);
                $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                 
                // array Count
                $arrayCount = count($allDataInSheet);
              	$flag = true;
                $i=0;
                $date = date('Y-m-d');
                $inserdata = array();
                foreach ($allDataInSheet as $value) {
                  if($flag){
                    $flag =false;
                    continue;
                } 
                if ($value['E'] !='' && $value['B'] !='') { 
		                $number = $this->caseModel->valid_phone_number($value['E']);
		                if ($number['status'] !='0') { 
	 					$team_id = $this->caseModel->getMinimumTaskHandlerInputQC();
				                // $inserdata[$i]['client_id'] = $value['A'];
				                $inserdata[$i]['title'] = $value['A'];
				                $inserdata[$i]['first_name'] = $value['B'];
				                $inserdata[$i]['last_name'] = $value['C'];
				                $inserdata[$i]['father_name'] =$value['D'];
				                $inserdata[$i]['phone_number'] =$value['E'];
				                $inserdata[$i]['email_id'] = $value['F']; 
				                $inserdata[$i]['date_of_birth'] = $value['G'];
				                $inserdata[$i]['date_of_joining'] = $value['H'];
				                $inserdata[$i]['employee_id'] = $value['I']; 
				                // $inserdata[$i]['package_name'] = $value['K'];
				                $inserdata[$i]['remark'] = $value['J']; 
				                $inserdata[$i]['document_uploaded_by'] = $value['K'];
				                $inserdata[$i]['excel_upload'] = 1;
				                $inserdata[$i]['assigned_inputqc_id'] = $team_id;

				                $inserdata[$i]['case_added_by_role'] = 'client';
				                $inserdata[$i]['case_added_by_id'] = $user['client_id'];
				                $inserdata[$i]['client_id'] = $user['client_id'];
				                $inserdata[$i]['package_name'] = $this->input->post('package_id');
				                // $inserdata[$i]['package_name'] = $this->input->post('package_name');
				                $inserdata[$i]['component_ids'] = $this->input->post('component_id');
				                $inserdata[$i]['form_values'] = $this->input->post('form_values');
				                $inserdata[$i]['alacarte_components'] = $this->input->post('alacarte_components');
				                $inserdata[$i]['package_components'] = $this->input->post('package_component');
		                }
		            }
                  $i++;
                }  
                	$tempArr = array_unique(array_column($inserdata, 'phone_number'));
					$inserdata_new = array_intersect_key($inserdata, $tempArr);   

	                if (count($inserdata) > 0) {
	                    $data = $this->caseModel->insert_bulk_case($inserdata_new);	 
	               		// $data = array('status'=>'1','products'=>$inserdata_new);// 
	                }else{
	                	$data = array('status'=>'0');
	                } 
    

                } else {
                    $data = array('status'=>'0');
                }
           echo json_encode($data); 

	}

	function getComponentBasedData(){
		$candidate_id= $this->input->post('candidate_id');
		$component_id= $this->input->post('component_id');
		// echo $component_id;
		$table_name = '';
		switch ($component_id) {
			case '2':
				$table_name = 'court_records';
				
				break;
			case '1':
				$table_name = 'criminal_checks';
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
			case 12:
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
            case '26':
                $table_name = 'civil_check';
                break;
            case '27':
                $table_name = 'right_to_work';
                break;
            case '28':
                $table_name = 'sex_offender';
                break;
            case '29':
                $table_name = 'politically_exposed';
                break;
            case '30':
                $table_name = 'india_civil_litigation';
                break;
            case '31':
                $table_name = 'mca';
                break;
            case '32':
                $table_name = 'nric';
                break;
            case '33':
                $table_name = 'gsa';
                break;
            case '34':
                $table_name = 'oig';
                break; 
			default:
				 
				break;
		} 

		if($table_name != ''){
			$data = $this->caseModel->getComponentBasedData($candidate_id,$table_name);
			if($data == '' && $data == null){
				$data = array('status'=>'0');
			}else{
				$result = array('status'=>'1','component_data'=>$data,'component_id'=>$component_id);
				$data = $result;
			}
		}else{
			$data = array('status'=>'0');
		}
 
		echo json_encode($data);
	}

	function add_request_form(){
		$data = $this->caseModel->add_request_form();
		echo json_encode($data);
	}

	function getNewClarificationNotification() {
		$new_client_clarifications = $this->notificationModel->getNewClarificationNotification();
		$clarification_new_comments = $this->notificationModel->get_new_clarification_comments();
		$data = [];
		// Type: 1 - New client Clarification, 2 - New clarification comment
		foreach ($new_client_clarifications as $key => $value) {
			$row['date'] = $value['client_clarification_created_date'];
			$row['type'] = 1;
			$row['value'] = $value;
			array_push($data, $row);
		}

		foreach ($clarification_new_comments as $key => $value) {
			$row['date'] = $value['client_clarification_comment_created_date'];
			$row['type'] = 2;
			$row['value'] = $value;
			array_push($data, $row);
		}
		$keys = array_column($data, 'date');
		array_multisort($keys, SORT_DESC, $data);
		
		echo json_encode($data);
	}

	function get_new_clarification_comments() {
		echo json_encode($this->notificationModel->get_new_clarification_comments());
	}

	function getNewCaseAssingedNotification(){
		 
		echo json_encode($this->notificationModel->getNewCaseAssingedNotification());

	}
	
	function completedCaseNotify(){
		 
		echo json_encode($this->notificationModel->completedCaseNotify());

	}

	
	function insuffCaseNotify(){
		 
		echo json_encode($this->notificationModel->insuffCaseNotify());

	}



	function intrrimCaseNotify(){
		 
		echo json_encode($this->notificationModel->intrrimCaseNotify());

	}

	function get_finance_notification(){
		echo json_encode($this->notificationModel->get_finance_notification());
	}


	function export_cases_status(){
		$user = $this->session->userdata('logged-in-client');
 
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
          $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."' AND client_id=".$user['client_id'];
        }else{
            $where="where client_id=".$user['client_id'];
        }

        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
 			$all_cases = array();

 			foreach ($data as $key => $value) {
 				 // print_r($value['client']['client_name']);

                // echo $value['candidate_id']."<br>";
                $cases = $this->caseModel->get_single_case_details($value['candidate_id']);
              

 				 // $cases = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($value['candidate_id']);

 				 foreach ($cases as $k => $val) {
                     if ($this->input->post('table') !='') {
                        if ($this->input->post('table') == $val['component_id']) { 
                         // $all_cases[$k] = $val;
                         array_push($all_cases, $val);
                        }
                     }else{
                       // $all_cases[$k] = $val; 
                       array_push($all_cases, $val);
                     }
 				 	 

 				 	 // array_push($all_cases, $row);
 				 }
 			}

 			// echo json_encode($all_cases);
 			// exit();
 
 			
	 		// create file name
	        $fileName = 'component-report-'.time().'.xlsx';   
	        $objPHPExcel = new Spreadsheet();
	        
	        // set Header
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
	        /*$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Priority');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'InputQc Status');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Component Name');          
	        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Component Status');     
	        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Output Status');      */
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
  $main_status = isset($value['component_data']['analyst_status'])?$value['component_data']['analyst_status']:'0';
    if ($main_status == '0') {
                         
                        $status = 'Not Initiated'; 
                    }else if ($main_status == '1') {
                         
                        $status = 'Not Initiated'; 
                    }else if ($main_status == '2') {
                         
                        $status = 'Completed';
                        
                    }else if ($main_status== '3') {
                         
                        $status = 'Insufficiency';
                        
                    }else if ($main_status == '4') {
                       
                        $status = 'Verified Clear';
                        
                    }else if ($main_status == '5') {
                       
                        $status = 'Stop Check';
                        
                    }else if ($main_status == '6') {
                       
                        $status = 'Unable to verify';
                        
                    }else if ($main_status == '7') {
                       
                        $status = 'Verified discrepancy';
                       
                    }else if ($main_status == '8') {
                       
                        $status = 'Client clarification';
                       
                    }else if ($main_status == '9') {
                       
                        $status = 'Closed Insufficiency';
                        
                    }else if ($main_status == '10'){
                        $status = 'QC Error'; 
                     
                    }else if ($main_status == '11'){
                        $status = 'Insuff Clear';  
                    }
               
                $inputQcStatus = '';
                $input = isset($value['component_data']['status'])?$value['component_data']['status']:'0';
                if ($input == '0') {
                         
                    $inputQcStatus = 'Not Initiated';
                        
                }else if ($input == '1') {
                         
                    $inputQcStatus = 'Not Initiated';
                         
                }else if ($input == '2') {
                         
                    $inputQcStatus = 'Completed';
                        
                }else if ($input== '3') {
                         
                    $inputQcStatus = 'Insufficiency';
                        
                }else if ($input == '4') {
                       
                    $inputQcStatus = 'Verified Clear';
                        
                }else if ($input == '5') {
                       
                    $inputQcStatus = 'Stop Check';
                        
                }else if ($input == '6') {
                       
                    $inputQcStatus = 'Unable to verify';
                        
                }else if ($input == '7') {
                       
                    $inputQcStatus = 'Verified discrepancy';
                        
                }else if ($input == '8') {
                       
                    $inputQcStatus = 'Client clarification';
                         
                }else if ($input == '9') {
                       
                    $inputQcStatus = 'Closed Insufficiency';
                        
                }
                 
                $outPutQCStatus = '';
                $output = isset($value['component_data']['output_status'])?$value['component_data']['output_status']:'0';
                if ( $output == '0'){
                    $outPutQCStatus = 'Not Initiated';
                } else if ($output == '1'){
                    $outPutQCStatus = 'Approved';
                } else if ($output == '2') {
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
	            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value['candidate_id']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $value['client_name']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value['first_name']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['last_name']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value['father_name']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value['phone_number']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value['email_id']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value['date_of_birth']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value['date_of_joining']);  
	            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $is_submitted);  
	            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $value['employee_id']);  
	            
	           /* $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $priority); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $inputQcStatus); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $value['component_name']); 
	            
	            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $status); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $outPutQCStatus);  */
	            

	            $rowCount++;

	        }
	         
	    
	 
	        $objWriter = new Xlsx($objPHPExcel);
	        $objWriter->save('../uploads/report/'.$fileName);
	 		// download file
	        // header("Content-Type: application/vnd.ms-excel");
	        // redirect(base_url().'uploads/report/'.$fileName);  

			echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));

	} 

 
	function export_cases_generated_report(){  
		$user = $this->session->userdata('logged-in-client'); 
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
          $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."' AND client_id=".$user['client_id'];
        }else{
            $where="where client_id=".$user['client_id'];
        }

        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();


        // create file name
	        $fileName = 'component-report-'.time().'.xlsx';   
	        $objPHPExcel = new Spreadsheet();
	        
	        // set Header
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
	        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Priority');     
	            
	        // set Row
	        $rowCount = 2;
	        $i =1;
 
	        foreach ($data as $key => $value) {
	  

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

 

                $priority ='';
            if($value['priority'] == '0'){
                    $priority = 'Low priority' ;
            }else if($value['priority'] == '1'){  
                    $priority = 'Medium priority' ;
            }else if($value['priority'] == '2'){  
                    $priority = 'High priority' ;
                  
            }
	        	 
	            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i++);
	            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $value['candidate_id']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $user['client_name']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $value['first_name']);
	            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $value['last_name']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $value['father_name']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $value['phone_number']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $value['email_id']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $value['date_of_birth']); 
	            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $value['date_of_joining']);  
	            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $is_submitted);   
	            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $priority); 
	            

	            $rowCount++;

	        }
 

	 
	        $objWriter = new Xlsx($objPHPExcel);
	        $objWriter->save('../uploads/report/'.$fileName);
	 		// download file
	        // header("Content-Type: application/vnd.ms-excel");
	        // redirect(base_url().'uploads/report/'.$fileName);  

			echo json_encode(array('filename' =>$fileName ,'path' =>base_url().'../uploads/report/'.$fileName));


 }



 function upload_candidate_bulk(){

		$bulk_case = array();
    	$candidate_aadhar_dir = '../uploads/bulk-docs/';

     
    	// chown($candidate_aadhar_dir, "ownername");
		// chgrp($candidate_aadhar_dir, "groupname");
		exec ("find ".$candidate_aadhar_dir." -type d -exec chmod 0777 {} +");
    	if(!empty($_FILES['bulk_case']['name']) && count(array_filter($_FILES['bulk_case']['name'])) > 0){ 
      		$error =$_FILES["bulk_case"]["error"]; 
      		if(!is_array($_FILES["bulk_case"]["name"])) {
        		$file_ext = pathinfo($_FILES["bulk_case"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["bulk_case"]["tmp_name"],$candidate_aadhar_dir.$fileName);
        		$bulk_case[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["bulk_case"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$files_name = $_FILES["bulk_case"]["name"][$i];
          			$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["bulk_case"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
          			$bulk_case[]= $fileName; 
        		} 
      		}
		} else {
      		$bulk_case[] = 'no-file';
    	}
    	echo json_encode($this->caseModel->upload_bulk_cases($bulk_case));
 }

 function all_requested_report(){
    echo json_encode($this->client_Analytics_Model->all_requested_report());
 }



    function resume_pending_case($candidate_id){
        $this->check_admin_login();
        $user = $this->db->where('candidate_id',$candidate_id)->get('candidate')->row_array();
        $this->session->set_userdata('logged-in-candidate',$user); 
            $data['user_name'] = strtolower(trim($user['first_name']).'-'.trim($user['last_name']));
            if ($user['is_submitted'] != '3' && $user['case_reinitiate'] !='1') { 
                $component_ids = array();
                $redirect = '0';
                $table = $this->utilModel->all_components($user['candidate_id']); 
                foreach (explode(',', $user['component_ids']) as $key => $value) {
                    if (!in_array($value,array('14','15','19','21','24'))) { 
                        array_push($component_ids,$value);
                        $tabl = $this->utilModel->getComponent_or_PageName($value);
                        $criminal_checks = explode(',', isset($table[$tabl]['analyst_status'])?$table[$tabl]['analyst_status']:'NA');
                        if ($redirect =='0' && in_array('NA', $criminal_checks)) {
                            $redirect = $value;
                        } 

                    }
                }
                $this->session->set_userdata('component_ids',implode(',', $component_ids));
                $data['is_submitted'] = '1';
                $data['redirect_url'] = $this->config->item('candidate_url').'/'.'factsuite-candidate/candidate-information';
                if ($user['personal_information_form_filled_by_candidate_status'] == 1) {
                    $data['redirect_url'] = $this->config->item('candidate_url').'/'.$this->utilModel->redirect_url($redirect);
                }
                $this->session->set_userdata('is_submitted',1);
            } else {

                $table = $this->utilModel->all_components($user['candidate_id']); 
                 $component = explode(',', $user['component_ids']);
                $status = array(); 
                $criminal_checks = explode(',', isset($table['criminal_checks']['analyst_status'])?$table['criminal_checks']['analyst_status']:'NA');
                if (in_array('1',$component)) {  
                    if (in_array('3', $criminal_checks) || in_array('NA', $criminal_checks)) {
                        array_push($status,1);
                    } 
                }
                $court_records = explode(',', isset($table['court_records']['analyst_status'])?$table['court_records']['analyst_status']:'NA');
                if (in_array('2',$component)) { 
                    if (in_array('3', $court_records) || in_array('NA', $court_records)) {
                        array_push($status,2);
                    }
                }
                $document_check = explode(',', isset($table['document_check']['analyst_status'])?$table['document_check']['analyst_status']:'NA');
                if (in_array('3',$component)) { 
                    if (in_array('3', $document_check) || in_array('NA', $document_check)) {
                        array_push($status,3);
                    }
                }
                $drugtest = explode(',', isset($table['drugtest']['analyst_status'])?$table['drugtest']['analyst_status']:'NA');
                if (in_array('4',$component)) { 
                    if (in_array('3', $drugtest) || in_array('NA', $drugtest)) {
                        array_push($status,4);
                    } 
                } 
                $globaldatabase = explode(',', isset($table['globaldatabase']['analyst_status'])?$table['globaldatabase']['analyst_status']:'NA');
                if (in_array('5',$component)) { 
                    if (in_array('3', $globaldatabase) || in_array('NA', $globaldatabase)) {
                        array_push($status,5);
                    }
                }
                $current_employment = explode(',', isset($table['current_employment']['analyst_status'])?$table['current_employment']['analyst_status']:'NA');
                if (in_array('6',$component)) { 
                    if (in_array('3', $current_employment) || in_array('NA', $current_employment)) {
                        array_push($status,6);
                    }
                }
                $education_details = explode(',', isset($table['education_details']['analyst_status'])?$table['education_details']['analyst_status']:'NA');
                if (in_array('7',$component)) { 
                    if (in_array('3', $education_details) || in_array('NA', $education_details)) {
                        array_push($status,7);
                    } 
                } 
                $present_address = explode(',', isset($table['present_address']['analyst_status'])?$table['present_address']['analyst_status']:'NA');
                if (in_array('8',$component)) { 
                    if (in_array('3', $present_address) || in_array('NA', $present_address)) {
                        array_push($status,8);
                    }
                }
                $permanent_address = explode(',', isset($table['permanent_address']['analyst_status'])?$table['permanent_address']['analyst_status']:'NA');
                if (in_array('9',$component)) { 
                    if (in_array('3', $permanent_address) || in_array('NA', $permanent_address)) {
                        array_push($status,9);
                    }
                }
                $previous_employment = explode(',', isset($table['previous_employment']['analyst_status'])?$table['previous_employment']['analyst_status']:'NA');
                if (in_array('10',$component)) { 
                    if (in_array('3', $previous_employment) || in_array('NA', $previous_employment)) {
                        array_push($status,10);
                    }
                }
                $reference = explode(',', isset($table['reference']['analyst_status'])?$table['reference']['analyst_status']:'NA');
                if (in_array('11',$component)) { 
                    if (in_array('3', $reference) || in_array('NA', $reference)) {
                        array_push($status,11);
                    }
                }
                $previous_address = explode(',', isset($table['previous_address']['analyst_status'])?$table['previous_address']['analyst_status']:'NA');
                if (in_array('12',$component)) { 
                    if (in_array('3', $previous_address) || in_array('NA', $previous_address)) {
                        array_push($status,12);
                    }
                }
                $driving_licence = explode(',', isset($table['driving_licence']['analyst_status'])?$table['driving_licence']['analyst_status']:'NA');
                if (in_array('16',$component)) { 
                    if (in_array('3', $driving_licence) || in_array('NA', $driving_licence)) {
                        array_push($status,16);
                    }
                }

                $cv_check = explode(',', isset($table['cv_check']['analyst_status'])?$table['cv_check']['analyst_status']:'NA');
                if (in_array('20',$component)) { 
                    if (in_array('3', $cv_check) || in_array('NA', $cv_check)) {
                        array_push($status,20);
                    }
                }

                $gap_check = explode(',', isset($table['employment_gap_check']['analyst_status'])?$table['employment_gap_check']['analyst_status']:'NA');
                if (in_array('20',$component)) { 
                    if (in_array('3', $gap_check) || in_array('NA', $gap_check)) {
                        array_push($status,22);
                    }
                }

                $credit_cibil = explode(',', isset($table['credit_cibil']['analyst_status'])?$table['credit_cibil']['analyst_status']:'NA');
                if (in_array('17',$component)) { 
                    if (in_array('3', $credit_cibil) || in_array('NA', $credit_cibil)) {
                        array_push($status,17);
                    }
                }
                $bankruptcy = explode(',', isset($table['bankruptcy']['analyst_status'])?$table['bankruptcy']['analyst_status']:'NA');
                if (in_array('18',$component)) { 
                    if (in_array('3', $bankruptcy) || in_array('NA', $bankruptcy)) {
                        array_push($status,18);
                    } 
                } 

                $bankruptcy = explode(',', isset($table['bankruptcy']['analyst_status'])?$table['bankruptcy']['analyst_status']:'NA');
                if (in_array('18',$component)) { 
                    if (in_array('3', $bankruptcy) || in_array('NA', $bankruptcy)) {
                        array_push($status,18);
                    } 
                } 

                $landload_reference = explode(',', isset($table['landload_reference']['analyst_status'])?$table['bankruptcy']['analyst_status']:'NA');
                if (in_array('18',$component)) { 
                    if (in_array('3', $landload_reference) || in_array('NA', $landload_reference)) {
                        array_push($status,23);
                    } 
                } 

                $social_media = explode(',', isset($table['social_media']['analyst_status'])?$table['social_media']['analyst_status']:'NA');
                if (in_array('18',$component)) { 
                    if (in_array('3', $social_media) || in_array('NA', $social_media)) {
                        array_push($status,25);
                    } 
                } 

                $civil_check = explode(',', isset($table['civil_check']['analyst_status'])?$table['civil_check']['analyst_status']:'NA');
                if (in_array('18',$component)) { 
                    if (in_array('3', $civil_check) || in_array('NA', $civil_check)) {
                        array_push($status,26);
                    } 
                } 
                sort($status);
                $this->session->set_userdata('component_ids',implode(',', $status));
                $this->session->set_userdata('is_submitted',3);
                $data['is_submitted'] = '3';
                 
                $data['redirect_url'] = $this->config->item('candidate_url').'/'.$this->utilModel->redirect_url(isset($status[0])?$status[0]:0);
            }   
            $this->session->set_userdata('candidate_details_submitted_by','client'); 
            redirect($data['redirect_url']);
         
         
    }

}