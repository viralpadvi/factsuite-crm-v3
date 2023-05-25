<?php
/**
 * 
 */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Team extends CI_Controller
{
	function __construct()  
	{
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('teamModel');  
	  $this->load->model('emailModel');
	  $this->load->model('admin_Vendor_Model');
	  $this->load->model('internal_chat');
	  $this->load->model('form_builder');
	}

	function myntra(){
		$data['details'] = $this->db->order_by('id','DESC')->get('email_details')->result_array();
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		// $this->load->view('admin/enquiries/enquiries-header');
		$this->load->view('admin/add-details',$data);
		$this->load->view('admin/admin-common/footer');
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
               
				                // $inserdata[$i]['client_id'] = $value['A'];
				                $inserdata[$i]['category'] = $value['A'];
				                $inserdata[$i]['company'] = $value['B'];
				                $inserdata[$i]['user_name'] = $value['C'];
				                $inserdata[$i]['email'] =$value['D'];
				                $inserdata[$i]['contact'] =$value['E']; 
		              
		         
                  $i++;
                }  
                	 
	                if (count($inserdata) > 0) {
	                    $data = $this->teamModel->insert_bulk_case($inserdata);	 
	               		// $data = array('status'=>'1','products'=>$inserdata_new);// 
	                }else{
	                	$data = array('status'=>'0');
	                } 
    

                } else {
                    $data = array('status'=>'0');
                }
           echo json_encode($data); 

	}

	function insert_team(){
		$data = $this->teamModel->insert_team();
		echo json_encode($data);
	}
	function get_view_team(){
		if($this->input->post('token') == '3ZGErMDCwxTOZYFp'){
			$data = $this->teamModel->get_team_all_details();
			echo json_encode($data);	
		}else{
			echo json_encode(array("stauts"=>'3',"message"=>'Bad Request'));
		}
		
	}

	function verify_and_reset_password() {
			if (isset($_POST) && $this->input->post('verify_admin_request') == '1') {
				echo json_encode(array('status'=>'1','reset'=>$this->teamModel->verify_and_reset_password()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
	}



	function update_team(){
		$data = $this->teamModel->update_team();
		echo json_encode($data);
	}

	function get_view_team_single($team_id){
		$data['team'] = $this->teamModel->get_csm_list();
		$data['team_list'] = $this->teamModel->get_team_all_details($team_id);
		$data['skill_list'] = $this->admin_Vendor_Model->get_vendor_skills();
		$data['all_segments'] = file_get_contents(base_url().'assets/custom-js/json/segments.json');
		$list = isset($data['team_list'][0]['approval_list'])?$data['team_list'][0]['approval_list']:0;
		$data['approval'] = $this->db->where('approve_id',$list)->get('list_of_approval')->row_array();
		echo json_encode($data);	
	}
	function remove_team(){
		$data = $this->teamModel->remove_team();
		echo json_encode($data);
	}

	function duplicate_contact(){
		$data = $this->teamModel->duplicate_contact();		
		echo json_encode($data);		
	}
	function duplicate_email(){
		$data = $this->teamModel->duplicate_email();		
		echo json_encode($data);
	} 

	function interna_chat(){
		$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}
		$data = $this->internal_chat->get_internal_chat_details($user);		
		echo json_encode($data);
	}

	function insert_interna_chat(){
		$user = $this->session->userdata('logged-in-admin');
			if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}

		$data = $this->internal_chat->insert_interna_chat($user);		
		echo json_encode($data);
	}

	function insert_interna_chat_attachment(){
		$user = $this->session->userdata('logged-in-admin');
			if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}
			$attachment = $this->add_attachments();
		$data = $this->internal_chat->insert_internal_chat_attachment($user,$attachment);		
		echo json_encode($data);
	}


	function add_attachments(){

		$internal_chat = array();
    	$dir = '../uploads/internal-chat/'; 
    
    	if(!empty($_FILES['attached_docs']['name']) && count(array_filter($_FILES['attached_docs']['name'])) > 0){ 
      		$error =$_FILES["attached_docs"]["error"]; 
      		if(!is_array($_FILES["attached_docs"]["name"])) {
        		$file_ext = pathinfo($_FILES["attached_docs"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["attached_docs"]["tmp_name"],$dir.$fileName);
        		$internal_chat[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["attached_docs"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$files_name = $_FILES["attached_docs"]["name"][$i];
          			$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["attached_docs"]["tmp_name"][$i],$dir.$fileName);
          			$internal_chat[]= $fileName; 
        		} 
      		}
		} else {
      		$internal_chat[] = 'no-file';
    	}
    	return $internal_chat;
    	// echo json_encode($client_docs);
	}	

	function get_number_of_chats(){
		$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}
		$data = $this->internal_chat->get_number_of_chats($user);
		echo json_encode($data);
	}

	function get_number_of_chats_selected_user(){
		$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}
		$data = $this->internal_chat->get_number_of_chats_selected_user($user);
		echo json_encode($data);
	}

	function get_internal_team(){
		$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
				$user = $this->session->userdata('logged-in-admin');
			} else if($this->session->userdata('logged-in-inputqc')) {
				$user = $this->session->userdata('logged-in-inputqc');
			} else if($this->session->userdata('logged-in-analyst')) {
				$user = $this->session->userdata('logged-in-analyst');
			} else if($this->session->userdata('logged-in-insuffanalyst')) {
				$user = $this->session->userdata('logged-in-insuffanalyst');
			} else if($this->session->userdata('logged-in-outputqc')) {
				$user = $this->session->userdata('logged-in-outputqc');
			} else if($this->session->userdata('logged-in-specialist')) {
				$user = $this->session->userdata('logged-in-specialist');	
			} else if($this->session->userdata('logged-in-am')) {
				$user = $this->session->userdata('logged-in-am');	
			} else if($this->session->userdata('logged-in-finance')) {
				$user = $this->session->userdata('logged-in-finance');
			} else if($this->session->userdata('logged-in-csm')) {
				$user = $this->session->userdata('logged-in-csm');	
			} else if($this->session->userdata('logged-in-tech-support')) {
				$user = $this->session->userdata('logged-in-tech-support');
			}
		$data = $this->internal_chat->get_internal_team($user);
		echo json_encode($data); 
	}


	function calling_system(){ 
		$user = $this->session->userdata('logged-in-admin');
		if($this->session->userdata('logged-in-admin')) {
			$user = $this->session->userdata('logged-in-admin');
		} else if($this->session->userdata('logged-in-inputqc')) {
			$user = $this->session->userdata('logged-in-inputqc');
		} else if($this->session->userdata('logged-in-analyst')) {
			$user = $this->session->userdata('logged-in-analyst');
		} else if($this->session->userdata('logged-in-insuffanalyst')) {
			$user = $this->session->userdata('logged-in-insuffanalyst');
		} else if($this->session->userdata('logged-in-outputqc')) {
			$user = $this->session->userdata('logged-in-outputqc');
		} else if($this->session->userdata('logged-in-specialist')) {
			$user = $this->session->userdata('logged-in-specialist');	
		} else if($this->session->userdata('logged-in-am')) {
			$user = $this->session->userdata('logged-in-am');	
		} else if($this->session->userdata('logged-in-finance')) {
			$user = $this->session->userdata('logged-in-finance');
		} else if($this->session->userdata('logged-in-csm')) {
			$user = $this->session->userdata('logged-in-csm');	
		} else if($this->session->userdata('logged-in-tech-support')) {
			$user = $this->session->userdata('logged-in-tech-support');
		}
		$candidate_id = $this->input->post('candidate_id');

		$candidate = $this->db->where('candidate_id',$this->input->post('candidate_id'))->get('candidate')->row_array();
		$inputqc = $this->db->where('team_id',$candidate['assigned_inputqc_id'])->get('team_employee')->row_array();

		$employee_country_code = trim($get_candidate_details['country_code'], "+");
		$candidate_country_code = trim($get_candidate_details['country_code'], "+");

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  	CURLOPT_URL => 'https://api-smartflo.tatateleservices.com/v1/click_to_call',
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_ENCODING => '',
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 0,
		  	CURLOPT_FOLLOWLOCATION => true,
		  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => 'POST',
		  	CURLOPT_POSTFIELDS =>'{
		     	"agent_number": "'.$employee_country_code.$inputqc['contact_no'].'",
		     	"destination_number": "'.$candidate_country_code.$candidate['phone_number'].'"
			}',
		  	CURLOPT_HTTPHEADER => array(
		    	'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjExMDU5OCwiaXNzIjoiaHR0cHM6XC9cL2Nsb3VkcGhvbmUudGF0YXRlbGVzZXJ2aWNlcy5jb21cL3Rva2VuXC9nZW5lcmF0ZSIsImlhdCI6MTYzMzYxMjIxNiwiZXhwIjoxOTMzNjEyMjE2LCJuYmYiOjE2MzM2MTIyMTYsImp0aSI6Im5uWGd2dWRNcFBFdVdWWDQifQ.ZKVoEjWAe20aZtIIMNpy7Lbk2H8KYYCHferSlsWzXqk',
		    	'Content-Type: application/json'
		  	),
		));

		$response = curl_exec($curl);

		$curl_response = json_decode($response);

		$calling_status = 0;
		if ($curl_response->success) {
			$calling_status = 1;
		}

		$call_to_candidate = "INSERT INTO `manual_call` (`candidate_id`,`called_by`,`calling_status`,`calling_message`) VALUES('".$candidate_id."','".$user['team_id']."','".$calling_status."','".$curl_response->message."')";

		$this->db->query($call_to_candidate);

		curl_close($curl);
		echo $response;
	}

	function save_json_data(){ 
		$form = 'form_'.time().'.json';
		file_put_contents('../uploads/form-builder/'.$form, $this->input->post('js')); 
		$this->form_builder->insert_form_builder($form);
		echo json_encode(array('status'=>1,'msg'=>'success'));
	}
}