<?php

/**
 * 
 */
class Candidate extends CI_Controller
{
	

	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
    $this->load->model('candidateModel');
    $this->load->model('candidate_Util_Model');
	  $this->load->model('emailModel');
	}


  function get_candidate_pincode_validation($pincode){
    $data = $this->candidateModel->get_candidate_pincode_validation($pincode);
    if ($data !=null) {
      echo json_encode(array('status'=>'1','msg'=>'success'));
    }else{
      echo json_encode(array('status'=>'0','msg'=>'failed'));
    }
  }

  function get_selected_states($id){
    $data = $this->candidateModel->get_all_states($id); 
    echo json_encode($data);
  }

  function get_selected_cities($id){
    $data = $this->candidateModel->get_all_cities($id); 
    echo json_encode($data);
  }


  function update_candidate_image(){
    


          $cv_docs = '';
      $cv_docs_dir = '../uploads/doc_signs/';

     
    
      if(!empty($_FILES['cv_docs']['name']) && count(array_filter($_FILES['cv_docs']['name'])) > 0){ 
          $error =$_FILES["cv_docs"]["error"]; 
          if(!is_array($_FILES["cv_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["cv_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["cv_docs"]["tmp_name"],$cv_docs.$fileName);
            $cv_docs = $fileName; 
          } else {
            $fileCount = count($_FILES["cv_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["cv_docs"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["cv_docs"]["tmp_name"][$i],$cv_docs_dir.$fileName);
                $cv_docs = $fileName; 
            } 
          }
    } else {
          $cv_docs  = 'no-file';
      }

      echo json_encode(array('status'=>1,'file_name'=>$cv_docs));

  }

  function send_otp_to_email_id() {
    if ($this->session->userdata('logged-in-candidate')) {
      echo json_encode(array('status'=>'1','validate_email_id_response'=>$this->candidateModel->send_otp_to_email_id()));
    } else {
      echo json_encode(array('status'=>'201','message'=>'Not Authorized'));
    }
  }

  function validate_to_email_id() {
    if ($this->session->userdata('logged-in-candidate')) {
      echo json_encode(array('status'=>'1','validate_email_id_response'=>$this->candidateModel->validate_to_email_id()));
    } else {
      echo json_encode(array('status'=>'201','message'=>'Not Authorized'));
    }
  }


	function update_candidate_info(){

		$candidate_aadhar = array();
    	$candidate_aadhar_dir = '../uploads/aadhar-docs/';

     
    
    	if(!empty($_FILES['candidate_aadhar']['name']) && count(array_filter($_FILES['candidate_aadhar']['name'])) > 0){ 
      		$error =$_FILES["candidate_aadhar"]["error"]; 
      		if(!is_array($_FILES["candidate_aadhar"]["name"])) {
        		$file_ext = pathinfo($_FILES["candidate_aadhar"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"],$candidate_aadhar_dir.$fileName);
        		$candidate_aadhar[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["candidate_aadhar"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$files_name = $_FILES["candidate_aadhar"]["name"][$i];
          			$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
          			$candidate_aadhar[]= $fileName; 
        		} 
      		}
		} else {
      		$candidate_aadhar[] = 'no-file';
    	}


    			$candidate_pan = array();
    	$candidate_pan_dir = '../uploads/pan-docs/';

     
    
    	if(!empty($_FILES['candidate_pan']['name']) && count(array_filter($_FILES['candidate_pan']['name'])) > 0){ 
      		$error =$_FILES["candidate_pan"]["error"]; 
      		if(!is_array($_FILES["candidate_pan"]["name"])) {
        		$file_ext = pathinfo($_FILES["candidate_pan"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["candidate_pan"]["tmp_name"],$candidate_pan_dir.$fileName);
        		$candidate_pan[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["candidate_pan"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$files_name = $_FILES["candidate_pan"]["name"][$i];
          			$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["candidate_pan"]["tmp_name"][$i],$candidate_pan_dir.$fileName);
          			$candidate_pan[]= $fileName; 
        		} 
      		}
		} else {
      		$candidate_pan[] = 'no-file';
    	}


    			$candidate_proof = array();
    	$candidate_proof_dir = '../uploads/proof-docs/';

     
    
    	if(!empty($_FILES['candidate_proof']['name']) && count(array_filter($_FILES['candidate_proof']['name'])) > 0){ 
      		$error =$_FILES["candidate_proof"]["error"]; 
      		if(!is_array($_FILES["candidate_proof"]["name"])) {
        		$file_ext = pathinfo($_FILES["candidate_proof"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["candidate_proof"]["tmp_name"],$candidate_proof_dir.$fileName);
        		$candidate_proof[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["candidate_proof"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$files_name = $_FILES["candidate_proof"]["name"][$i];
          			$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["candidate_proof"]["tmp_name"][$i],$candidate_proof_dir.$fileName);
          			$candidate_proof[]= $fileName; 
        		} 
      		}
		} else {
      		$candidate_proof[] = 'no-file';
    	}


    	$candidate_bank = array();
    	$candidate_bank_dir = '../uploads/bank-docs/';

     
    
    	if(!empty($_FILES['candidate_bank']['name']) && count(array_filter($_FILES['candidate_bank']['name'])) > 0){ 
      		$error =$_FILES["candidate_bank"]["error"]; 
      		if(!is_array($_FILES["candidate_bank"]["name"])) {
        		$file_ext = pathinfo($_FILES["candidate_bank"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["candidate_bank"]["tmp_name"],$candidate_bank_dir.$fileName);
        		$candidate_bank[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["candidate_bank"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$files_name = $_FILES["candidate_bank"]["name"][$i];
          			$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["candidate_bank"]["tmp_name"][$i],$candidate_bank_dir.$fileName);
          			$candidate_bank[]= $fileName; 
        		} 
      		}
		} else {
      		$candidate_bank[] = 'no-file';
    	}

		$data = $this->candidateModel->update_candidate_info(/*$candidate_aadhar,$candidate_pan,$candidate_proof,$candidate_bank*/);
		// echo json_encode($data);
    $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $url = $this->candidateModel->redirect_url($component_id[0],$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }

  /*  $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

	}


  function update_candidate_address(){


    $candidate_rental = array();
      $candidate_aadhar_dir = '../uploads/rental-docs/';

     
    
      if(!empty($_FILES['candidate_rental']['name']) && count(array_filter($_FILES['candidate_rental']['name'])) > 0){ 
          $error =$_FILES["candidate_rental"]["error"]; 
          if(!is_array($_FILES["candidate_rental"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_rental"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_rental"]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $candidate_rental[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_rental"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_rental"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_rental"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
                $candidate_rental[]= $fileName; 
            } 
          }
    } else {
          $candidate_rental[] = 'no-file';
      }


          $candidate_ration = array();
      $candidate_pan_dir = '../uploads/ration-docs/';

     
    
      if(!empty($_FILES['candidate_ration']['name']) && count(array_filter($_FILES['candidate_ration']['name'])) > 0){ 
          $error =$_FILES["candidate_ration"]["error"]; 
          if(!is_array($_FILES["candidate_ration"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_ration"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_ration"]["tmp_name"],$candidate_ration.$fileName);
            $candidate_pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_ration"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_ration"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_ration"]["tmp_name"][$i],$candidate_pan_dir.$fileName);
                $candidate_ration[]= $fileName; 
            } 
          }
    } else {
          $candidate_ration[] = 'no-file';
      }


          $candidate_gov = array();
      $candidate_proof_dir = '../uploads/gov-docs/';

     
    
      if(!empty($_FILES['candidate_gov']['name']) && count(array_filter($_FILES['candidate_gov']['name'])) > 0){ 
          $error =$_FILES["candidate_gov"]["error"]; 
          if(!is_array($_FILES["candidate_gov"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_gov"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_gov"]["tmp_name"],$candidate_proof_dir.$fileName);
            $candidate_gov[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_gov"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_gov"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_gov"]["tmp_name"][$i],$candidate_proof_dir.$fileName);
                $candidate_gov[]= $fileName; 
            } 
          }
    } else {
          $candidate_gov[] = 'no-file';
      }


    $data = $this->candidateModel->update_candidate_address($candidate_rental,$candidate_ration,$candidate_gov);
    // echo json_encode($data);
     // $user = $this->session->userdata('logged-in-candidate');
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }



  function update_candidate_employment(){
      $candidate_aadhar = array();
      $candidate_aadhar_dir = '../uploads/appointment_letter/';

     
    
      if(!empty($_FILES['candidate_aadhar']['name']) && count(array_filter($_FILES['candidate_aadhar']['name'])) > 0){ 
          $error =$_FILES["candidate_aadhar"]["error"]; 
          if(!is_array($_FILES["candidate_aadhar"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_aadhar"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $candidate_aadhar[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_aadhar"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_aadhar"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
                $candidate_aadhar[]= $fileName; 
            } 
          }
    } else {
          $candidate_aadhar[] = 'no-file';
      }


          $candidate_pan = array();
      $candidate_pan_dir = '../uploads/experience_relieving_letter/';

     
    
      if(!empty($_FILES['candidate_pan']['name']) && count(array_filter($_FILES['candidate_pan']['name'])) > 0){ 
          $error =$_FILES["candidate_pan"]["error"]; 
          if(!is_array($_FILES["candidate_pan"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_pan"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_pan"]["tmp_name"],$candidate_pan_dir.$fileName);
            $candidate_pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_pan"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_pan"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_pan"]["tmp_name"][$i],$candidate_pan_dir.$fileName);
                $candidate_pan[]= $fileName; 
            } 
          }
    } else {
          $candidate_pan[] = 'no-file';
    }


      $candidate_proof = array();
      $candidate_proof_dir = '../uploads/last_month_pay_slip/';

     
    
      if(!empty($_FILES['candidate_proof']['name']) && count(array_filter($_FILES['candidate_proof']['name'])) > 0){ 
          $error =$_FILES["candidate_proof"]["error"]; 
          if(!is_array($_FILES["candidate_proof"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_proof"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_proof"]["tmp_name"],$candidate_proof_dir.$fileName);
            $candidate_proof[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_proof"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_proof"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_proof"]["tmp_name"][$i],$candidate_proof_dir.$fileName);
                $candidate_proof[]= $fileName; 
            } 
          }
    } else {
          $candidate_proof[] = 'no-file';
      }


      $candidate_bank = array();
      $candidate_bank_dir = '../uploads/bank_statement_resigngation_acceptance/';

     
    
      if(!empty($_FILES['candidate_bank']['name']) && count(array_filter($_FILES['candidate_bank']['name'])) > 0){ 
          $error =$_FILES["candidate_bank"]["error"]; 
          if(!is_array($_FILES["candidate_bank"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_bank"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_bank"]["tmp_name"],$candidate_bank_dir.$fileName);
            $candidate_bank[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_bank"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_bank"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_bank"]["tmp_name"][$i],$candidate_bank_dir.$fileName);
                $candidate_bank[]= $fileName; 
            } 
          }
    } else {
          $candidate_bank[] = 'no-file';
      }
    $data = $this->candidateModel->update_candidate_employment($candidate_aadhar,$candidate_pan,$candidate_proof,$candidate_bank);
    // $data = $this->candidateModel->update_candidate_employment();
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_reference(){
    $data = $this->candidateModel->update_candidate_reference();
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
      $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
      $comp = isset($component_id[$index])?$component_id[$index]:0;
     $url = $this->candidateModel->redirect_url($comp);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }


  function update_candidate_gap(){
    $data = $this->candidateModel->update_candidate_gap();
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
      $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
      $comp = isset($component_id[$index])?$component_id[$index]:0;
     $url = $this->candidateModel->redirect_url($comp);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_landload_reference(){
    $data = $this->candidateModel->update_candidate_landload_reference();
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
      $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
      $comp = isset($component_id[$index])?$component_id[$index]:0;
     $url = $this->candidateModel->redirect_url($comp);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_social_media(){
    $data = $this->candidateModel->update_candidate_social_media();
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
      $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
      $comp = isset($component_id[$index])?$component_id[$index]:0;
     $url = $this->candidateModel->redirect_url($comp);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

function update_candidate_additional(){

    $candidate_aadhar = array();
      $candidate_aadhar_dir = '../uploads/additional-docs/';

     
    
      if(!empty($_FILES['additional']['name']) && count(array_filter($_FILES['additional']['name'])) > 0){ 
          $error =$_FILES["additional"]["error"]; 
          if(!is_array($_FILES["additional"]["name"])) {
            $file_ext = pathinfo($_FILES["additional"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["additional"]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $candidate_aadhar[]= $fileName; 
          } else {
            $fileCount = count($_FILES["additional"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["additional"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["additional"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
                $candidate_aadhar[]= $fileName; 
            } 
          }
    } else {
          $candidate_aadhar[] = 'no-file';
      }
    $data = $this->candidateModel->update_candidate_additional($candidate_aadhar);
   
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') { 
     $url = $this->candidateModel->redirect_url('100',$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }


  function update_candidate_previous_employment(){

    $candidate_aadhar = array();
      $candidate_aadhar_dir = '../uploads/appointment_letter/';
 
        $count = $this->input->post('count');
        $count_pan = $this->input->post('count_pan');
        $count_proof = $this->input->post('count_proof');
        $count_bank = $this->input->post('count_bank');

      

     for ($i=0; $i < $count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_aadhar'.$i])) {
        if(!empty($_FILES['candidate_aadhar'.$i]['name']) && count(array_filter($_FILES['candidate_aadhar'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_aadhar".$i]["error"]; 
          if(!is_array($_FILES["candidate_aadhar".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_aadhar".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_aadhar".$i]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_aadhar".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_aadhar".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_aadhar".$i]["tmp_name"][$j],$candidate_aadhar_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_aadhar[] = $client_docs_obj;
     }


          $candidate_pan = array();
      $candidate_pan_dir = '../uploads/experience_relieving_letter/';


     for ($i=0; $i < $count_pan; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_pan'.$i])) {
        if(!empty($_FILES['candidate_pan'.$i]['name']) && count(array_filter($_FILES['candidate_pan'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_pan".$i]["error"]; 
          if(!is_array($_FILES["candidate_pan".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_pan".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_pan".$i]["tmp_name"],$candidate_pan_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_pan".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_pan".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_pan".$i]["tmp_name"][$j],$candidate_pan_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_pan[] = $client_docs_obj;
     }



      $candidate_proof = array();
      $candidate_proof_dir = '../uploads/last_month_pay_slip/';

     
    
 
     for ($i=0; $i < $count_proof; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_proof'.$i])) {
        if(!empty($_FILES['candidate_proof'.$i]['name']) && count(array_filter($_FILES['candidate_proof'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_proof".$i]["error"]; 
          if(!is_array($_FILES["candidate_proof".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_proof".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_proof".$i]["tmp_name"],$candidate_proof_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_proof".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_proof".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_proof".$i]["tmp_name"][$j],$candidate_proof_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_proof[] = $client_docs_obj;
     }


      $candidate_bank = array();
      $candidate_bank_dir = '../uploads/bank_statement_resigngation_acceptance/';

     
   for ($i=0; $i < $count_bank; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_bank'.$i])) {
        if(!empty($_FILES['candidate_bank'.$i]['name']) && count(array_filter($_FILES['candidate_bank'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_bank".$i]["error"]; 
          if(!is_array($_FILES["candidate_bank".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_bank".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_bank".$i]["tmp_name"],$candidate_bank_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_bank".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_bank".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_bank".$i]["tmp_name"][$j],$candidate_bank_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_bank[] = $client_docs_obj;
     }


    $data = $this->candidateModel->update_candidate_previous_employment($candidate_aadhar,$candidate_pan,$candidate_proof,$candidate_bank);
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_court_record(){
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/


    $candidate_aadhar = array();
      $candidate_aadhar_dir = '../uploads/address-docs/';

     
    
      if(!empty($_FILES['addresss']['name']) && count(array_filter($_FILES['addresss']['name'])) > 0){ 
          $error =$_FILES["addresss"]["error"]; 
          if(!is_array($_FILES["addresss"]["name"])) {
            $file_ext = pathinfo($_FILES["addresss"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["addresss"]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $candidate_aadhar[]= $fileName; 
          } else {
            $fileCount = count($_FILES["addresss"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["addresss"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["addresss"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
                $candidate_aadhar[]= $fileName; 
            } 
          }
    } else {
          $candidate_aadhar[] = 'no-file';
      }
    $data = $this->candidateModel->update_candidate_court_record($candidate_aadhar);

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_criminal_check(){
    $data = $this->candidateModel->update_candidate_criminal_check();
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_civil_check(){
     $data = $this->candidateModel->update_candidate_civil_check(); 
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_document_check(){
    $candidate_aadhar = array();
      $candidate_aadhar_dir = '../uploads/aadhar-docs/';

     
      if(!empty($_FILES['candidate_aadhar']['name']) && count(array_filter($_FILES['candidate_aadhar']['name'])) > 0){ 
          $error =$_FILES["candidate_aadhar"]["error"]; 
          if(!is_array($_FILES["candidate_aadhar"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_aadhar"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $candidate_aadhar[]= $fileName; 
          } else {

             $fileCount = count($_FILES["candidate_aadhar"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_aadhar"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
                $candidate_aadhar[]= $fileName; 
            } 
          }
    } else {
          $candidate_aadhar[] = 'no-file';
      }
 
          $candidate_pan = array();
      $candidate_pan_dir = '../uploads/pan-docs/';

     
    
      if(!empty($_FILES['candidate_pan']['name']) && count(array_filter($_FILES['candidate_pan']['name'])) > 0){ 
          $error =$_FILES["candidate_pan"]["error"]; 
          if(!is_array($_FILES["candidate_pan"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_pan"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_pan"]["tmp_name"],$candidate_pan_dir.$fileName);
            $candidate_pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_pan"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_pan"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_pan"]["tmp_name"][$i],$candidate_pan_dir.$fileName);
                $candidate_pan[]= $fileName; 
            } 
          }
    } else {
          $candidate_pan[] = 'no-file';
      }


          $candidate_proof = array();
      $candidate_proof_dir = '../uploads/proof-docs/';

     
    
      if(!empty($_FILES['candidate_proof']['name']) && count(array_filter($_FILES['candidate_proof']['name'])) > 0){ 
          $error =$_FILES["candidate_proof"]["error"]; 
          if(!is_array($_FILES["candidate_proof"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_proof"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_proof"]["tmp_name"],$candidate_proof_dir.$fileName);
            $candidate_proof[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_proof"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_proof"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_proof"]["tmp_name"][$i],$candidate_proof_dir.$fileName);
                $candidate_proof[]= $fileName; 
            } 
          }
    } else {
          $candidate_proof[] = 'no-file';
      } 


          $candidate_voter = array();
      $candidate_voter_dir = '../uploads/voter-docs/';

     
    
      if(!empty($_FILES['candidate_voter']['name']) && count(array_filter($_FILES['candidate_voter']['name'])) > 0){ 
          $error =$_FILES["candidate_voter"]["error"]; 
          if(!is_array($_FILES["candidate_voter"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_voter"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_voter"]["tmp_name"],$candidate_voter_dir.$fileName);
            $candidate_voter[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_voter"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_voter"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_voter"]["tmp_name"][$i],$candidate_voter_dir.$fileName);
                $candidate_voter[]= $fileName; 
            } 
          }
    } else {
          $candidate_voter[] = 'no-file';
      } 

          $candidate_ssn = array();
      $candidate_ssn_dir = '../uploads/ssn_doc/';

     
    
      if(!empty($_FILES['candidate_ssn']['name']) && count(array_filter($_FILES['candidate_ssn']['name'])) > 0){ 
          $error =$_FILES["candidate_ssn"]["error"]; 
          if(!is_array($_FILES["candidate_ssn"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_ssn"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_ssn"]["tmp_name"],$candidate_voter_dir.$fileName);
            $candidate_ssn[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_ssn"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_ssn"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_ssn"]["tmp_name"][$i],$candidate_ssn_dir.$fileName);
                $candidate_ssn[]= $fileName; 
            } 
          }
    } else {
          $candidate_ssn[] = 'no-file';
      } 

    // $data = $this->candidateModel->update_candidate_address($candidate_rental,$candidate_ration,$candidate_gov);
    $data = $this->candidateModel->update_candidate_document_check($candidate_aadhar,$candidate_pan,$candidate_proof,$candidate_voter,$candidate_ssn);
   
   /*  $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }

  }

  function update_candidate_drug_test(){
    $data = $this->candidateModel->update_candidate_drug_test();
    // echo json_encode($data);
   /*  $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if (isset($data['status'])?$data['status']:''=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_global(){
    $data = $this->candidateModel->update_candidate_global();
    // echo json_encode($data);
   /*  $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if (isset($data['status'])?$data['status']:''=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }


  function update_candidate_education_details(){


    $all_sem_marksheet = array();
      $all_sem_marksheet_dir = '../uploads/all-marksheet-docs/';

             $count = $this->input->post('count');
             $pan_count = $this->input->post('pan_count'); 
             $proof_count = $this->input->post('proof_count');
             $bank_count = $this->input->post('bank_count');
      

     for ($i=0; $i < $count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['all_sem_marksheet'.$i])) {
        if(!empty($_FILES['all_sem_marksheet'.$i]['name']) && count(array_filter($_FILES['all_sem_marksheet'.$i]['name'])) > 0){ 
          $error =$_FILES["all_sem_marksheet".$i]["error"]; 
          if(!is_array($_FILES["all_sem_marksheet".$i]["name"])) {
            $file_ext = pathinfo($_FILES["all_sem_marksheet".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["all_sem_marksheet".$i]["tmp_name"],$all_sem_marksheet_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["all_sem_marksheet".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["all_sem_marksheet".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["all_sem_marksheet".$i]["tmp_name"][$j],$all_sem_marksheet_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $all_sem_marksheet[] = $client_docs_obj;
     }

  
          $convocation = array();
      $convocation_dir = '../uploads/convocation-docs/';


     for ($i=0; $i < $pan_count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['convocation'.$i])) {
        if(!empty($_FILES['convocation'.$i]['name']) && count(array_filter($_FILES['convocation'.$i]['name'])) > 0){ 
          $error =$_FILES["convocation".$i]["error"]; 
          if(!is_array($_FILES["convocation".$i]["name"])) {
            $file_ext = pathinfo($_FILES["convocation".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["convocation".$i]["tmp_name"],$convocation_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["convocation".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["convocation".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["convocation".$i]["tmp_name"][$j],$convocation_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $convocation[] = $client_docs_obj;
     }

  


          $marksheet_provisional_certificate = array();
      $marksheet_provisional_certificate_dir = '../uploads/marksheet-certi-docs/';

   

     for ($i=0; $i < $proof_count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['marksheet_provisional_certificate'.$i])) {
        if(!empty($_FILES['marksheet_provisional_certificate'.$i]['name']) && count(array_filter($_FILES['marksheet_provisional_certificate'.$i]['name'])) > 0){ 
          $error =$_FILES["marksheet_provisional_certificate".$i]["error"]; 
          if(!is_array($_FILES["marksheet_provisional_certificate".$i]["name"])) {
            $file_ext = pathinfo($_FILES["marksheet_provisional_certificate".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["marksheet_provisional_certificate".$i]["tmp_name"],$marksheet_provisional_certificate_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["marksheet_provisional_certificate".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["marksheet_provisional_certificate".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["marksheet_provisional_certificate".$i]["tmp_name"][$j],$marksheet_provisional_certificate_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $marksheet_provisional_certificate[] = $client_docs_obj;
     }



      $ten_twelve_mark_card_certificate = array();
      $ten_twelve_mark_card_certificate_dir = '../uploads/ten-twelve-docs/';

 
     for ($i=0; $i < $bank_count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['ten_twelve_mark_card_certificate'.$i])) {
        if(!empty($_FILES['ten_twelve_mark_card_certificate'.$i]['name']) && count(array_filter($_FILES['ten_twelve_mark_card_certificate'.$i]['name'])) > 0){ 
          $error =$_FILES["ten_twelve_mark_card_certificate".$i]["error"]; 
          if(!is_array($_FILES["ten_twelve_mark_card_certificate".$i]["name"])) {
            $file_ext = pathinfo($_FILES["ten_twelve_mark_card_certificate".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["ten_twelve_mark_card_certificate".$i]["tmp_name"],$ten_twelve_mark_card_certificate_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["ten_twelve_mark_card_certificate".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["ten_twelve_mark_card_certificate".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["ten_twelve_mark_card_certificate".$i]["tmp_name"][$j],$ten_twelve_mark_card_certificate_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $ten_twelve_mark_card_certificate[] = $client_docs_obj;
     }



    $data = $this->candidateModel->update_candidate_education_details($all_sem_marksheet,$convocation,$marksheet_provisional_certificate,$ten_twelve_mark_card_certificate);
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_present_address(){
    

    $candidate_rental = array();
      $candidate_aadhar_dir = '../uploads/rental-docs/';

     
    
      if(!empty($_FILES['candidate_rental']['name']) && count(array_filter($_FILES['candidate_rental']['name'])) > 0){ 
          $error =$_FILES["candidate_rental"]["error"]; 
          if(!is_array($_FILES["candidate_rental"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_rental"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_rental"]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $candidate_rental[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_rental"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_rental"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_rental"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
                $candidate_rental[]= $fileName; 
            } 
          }
    } else {
          $candidate_rental[] = 'no-file';
      }


          $candidate_ration = array();
      $candidate_pan_dir = '../uploads/ration-docs/';

     
    
      if(!empty($_FILES['candidate_ration']['name']) && count(array_filter($_FILES['candidate_ration']['name'])) > 0){ 
          $error =$_FILES["candidate_ration"]["error"]; 
          if(!is_array($_FILES["candidate_ration"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_ration"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_ration"]["tmp_name"],$candidate_ration.$fileName);
            $candidate_pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_ration"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_ration"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_ration"]["tmp_name"][$i],$candidate_pan_dir.$fileName);
                $candidate_ration[]= $fileName; 
            } 
          }
    } else {
          $candidate_ration[] = 'no-file';
      }


          $candidate_gov = array();
      $candidate_proof_dir = '../uploads/gov-docs/';

     
    
      if(!empty($_FILES['candidate_gov']['name']) && count(array_filter($_FILES['candidate_gov']['name'])) > 0){ 
          $error =$_FILES["candidate_gov"]["error"]; 
          if(!is_array($_FILES["candidate_gov"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_gov"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_gov"]["tmp_name"],$candidate_proof_dir.$fileName);
            $candidate_gov[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_gov"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_gov"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_gov"]["tmp_name"][$i],$candidate_proof_dir.$fileName);
                $candidate_gov[]= $fileName; 
            } 
          }
    } else {
          $candidate_gov[] = 'no-file';
      }


    $data = $this->candidateModel->update_candidate_present_address($candidate_rental,$candidate_ration,$candidate_gov);
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_driving_licence(){

   
          $driving_licence = array();
      $driving_licence_dir = '../uploads/licence-docs/';

     
    
      if(!empty($_FILES['driving_licence']['name']) && count(array_filter($_FILES['driving_licence']['name'])) > 0){ 
          $error =$_FILES["driving_licence"]["error"]; 
          if(!is_array($_FILES["driving_licence"]["name"])) {
            $file_ext = pathinfo($_FILES["driving_licence"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["driving_licence"]["tmp_name"],$driving_licence.$fileName);
            $candidate_pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["driving_licence"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["driving_licence"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["driving_licence"]["tmp_name"][$i],$driving_licence_dir.$fileName);
                $driving_licence[]= $fileName; 
            } 
          }
    } else {
          $driving_licence[] = 'no-file';
      }

      $data = $this->candidateModel->update_candidate_driving_licence($driving_licence);  
    $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }

  }


  function update_candidate_cv_check(){
   
          $cv_docs = array();
      $cv_docs_dir = '../uploads/cv-docs/';

     
    
      if(!empty($_FILES['cv_docs']['name']) && count(array_filter($_FILES['cv_docs']['name'])) > 0){ 
          $error =$_FILES["cv_docs"]["error"]; 
          if(!is_array($_FILES["cv_docs"]["name"])) {
            $file_ext = pathinfo($_FILES["cv_docs"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["cv_docs"]["tmp_name"],$cv_docs.$fileName);
            $candidate_pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["cv_docs"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["cv_docs"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["cv_docs"]["tmp_name"][$i],$cv_docs_dir.$fileName);
                $cv_docs[]= $fileName; 
            } 
          }
    } else {
          $cv_docs[] = 'no-file';
      }

      $data = $this->candidateModel->update_candidate_cv_check($cv_docs); 
      // echo json_encode($data); 
    $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }


  function save_signature(){
      $result = array();
      $imagedata = base64_decode($_POST['img_data']);
      $filename = md5(date("dmYhisA"));
      $file_name = $filename.'.png';
      file_put_contents('../uploads/doc_signs/'.$file_name,$imagedata);
      $result['status'] = 1;
      $result['file_name'] = $file_name;
      echo json_encode($result);
  }

  function submit_final_data(){
    $data = $this->candidateModel->submit_final_data();
    echo json_encode($data);
 
  }

  function update_candidate_previous_address(){
    $candidate_rental = array();
      $candidate_aadhar_dir = '../uploads/rental-docs/';

     $count = $this->input->post('count');
     
     for ($i=0; $i < $count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_rental'.$i])) {
        if(!empty($_FILES['candidate_rental'.$i]['name']) && count(array_filter($_FILES['candidate_rental'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_rental".$i]["error"]; 
          if(!is_array($_FILES["candidate_rental".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_rental".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_rental".$i]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_rental".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_rental".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_rental".$i]["tmp_name"][$j],$candidate_aadhar_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_rental[] = $client_docs_obj;
     }


          $candidate_ration = array();
      $candidate_pan_dir = '../uploads/ration-docs/';

     
   for ($i=0; $i < $count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_ration'.$i])) {
        if(!empty($_FILES['candidate_ration'.$i]['name']) && count(array_filter($_FILES['candidate_ration'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_ration".$i]["error"]; 
          if(!is_array($_FILES["candidate_ration".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_ration".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_ration".$i]["tmp_name"],$candidate_pan_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_ration".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_ration".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_ration".$i]["tmp_name"][$j],$candidate_pan_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_ration[] = $client_docs_obj;
     }



          $candidate_gov = array();
      $candidate_gov_dir = '../uploads/gov-docs/';

     
  
   for ($i=0; $i < $count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_gov'.$i])) {
        if(!empty($_FILES['candidate_gov'.$i]['name']) && count(array_filter($_FILES['candidate_gov'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_gov".$i]["error"]; 
          if(!is_array($_FILES["candidate_gov".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_gov".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_gov".$i]["tmp_name"],$candidate_gov_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_gov".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_gov".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_gov".$i]["tmp_name"][$j],$candidate_gov_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_gov[] = $client_docs_obj;
     }


    $data = $this->candidateModel->update_candidate_previous_address($candidate_rental,$candidate_ration,$candidate_gov);
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search((int)$this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }


  function update_candidate_credit_cibil(){
        $credit_cibil = array();
      $candidate_aadhar_dir = '../uploads/credit-docs/';
      $count = $this->input->post('count');
      

     for ($i=0; $i < $count; $i++) { 
      $credit_cibil_obj = [];
      if (isset($_FILES['credit_cibil'.$i])) {
        if(!empty($_FILES['credit_cibil'.$i]['name']) && count(array_filter($_FILES['credit_cibil'.$i]['name'])) > 0){ 
          $error =$_FILES["credit_cibil".$i]["error"]; 
          if(!is_array($_FILES["credit_cibil".$i]["name"])) {
            $file_ext = pathinfo($_FILES["credit_cibil".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["credit_cibil".$i]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $credit_cibil_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["credit_cibil".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $approved_doc_name = $_FILES["credit_cibil".$i]["name"][$j];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["credit_cibil".$i]["tmp_name"][$j],$candidate_aadhar_dir.$fileName);
                $credit_cibil_obj[]= $fileName; 
            } 
          }
    } else {
          $credit_cibil_obj[] = 'no-file';
      }
      }
      
      $credit_cibil[] = $credit_cibil_obj;
     }
 
 
    $data = $this->candidateModel->update_candidate_credit_cibil($credit_cibil);
    // echo json_encode($data); 
         $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    } 
  }


  function update_candidate_bankruptcy(){
        $bankruptcy = array();
      $candidate_aadhar_dir = '../uploads/bankruptcy/';
      $count = $this->input->post('count');
      

     for ($i=0; $i < $count; $i++) { 
      $credit_cibil_obj = [];
      if (isset($_FILES['bankruptcy'.$i])) {
        if(!empty($_FILES['bankruptcy'.$i]['name']) && count(array_filter($_FILES['bankruptcy'.$i]['name'])) > 0){ 
          $error =$_FILES["bankruptcy".$i]["error"]; 
          if(!is_array($_FILES["bankruptcy".$i]["name"])) {
            $file_ext = pathinfo($_FILES["bankruptcy".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["bankruptcy".$i]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $credit_cibil_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["bankruptcy".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $approved_doc_name = $_FILES["bankruptcy".$i]["name"][$j];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["bankruptcy".$i]["tmp_name"][$j],$candidate_aadhar_dir.$fileName);
                $credit_cibil_obj[]= $fileName; 
            } 
          }
    } else {
          $credit_cibil_obj[] = 'no-file';
      }
      }
      
      $bankruptcy[] = $credit_cibil_obj;
     }
 
 
    $data = $this->candidateModel->update_candidate_bankruptcy($bankruptcy);
    // echo json_encode($data);  
         $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function remove_candidate_image(){
    $data = $this->candidateModel->remove_candidate_images();
    echo json_encode($data);
  }


  /* insuff candidate form data */

  function update_candidate_criminal_check_insuff(){
    $data = $this->candidateModel->update_candidate_criminal_check_insuff();
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }


  function update_candidate_court_record_insuff(){
    $data = $this->candidateModel->update_candidate_court_record_insuff();
    // echo json_encode($data);
   /*  $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }

  }



    function update_candidate_document_check_insuff(){

    
    
    $candidate_aadhar = array();
      $candidate_aadhar_dir = '../uploads/aadhar-docs/';

     
      if(!empty($_FILES['candidate_aadhar']['name']) && count(array_filter($_FILES['candidate_aadhar']['name'])) > 0){ 
          $error =$_FILES["candidate_aadhar"]["error"]; 
          if(!is_array($_FILES["candidate_aadhar"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_aadhar"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $candidate_aadhar[]= $fileName; 
          } else {

             $fileCount = count($_FILES["candidate_aadhar"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_aadhar"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
                $candidate_aadhar[]= $fileName; 
            } 
          }
    } else {
          $candidate_aadhar[] = 'no-file';
      }
 
          $candidate_pan = array();
      $candidate_pan_dir = '../uploads/pan-docs/';

     
    
      if(!empty($_FILES['candidate_pan']['name']) && count(array_filter($_FILES['candidate_pan']['name'])) > 0){ 
          $error =$_FILES["candidate_pan"]["error"]; 
          if(!is_array($_FILES["candidate_pan"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_pan"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_pan"]["tmp_name"],$candidate_pan_dir.$fileName);
            $candidate_pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_pan"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_pan"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_pan"]["tmp_name"][$i],$candidate_pan_dir.$fileName);
                $candidate_pan[]= $fileName; 
            } 
          }
    } else {
          $candidate_pan[] = 'no-file';
      }


          $candidate_proof = array();
      $candidate_proof_dir = '../uploads/proof-docs/';

     
    
      if(!empty($_FILES['candidate_proof']['name']) && count(array_filter($_FILES['candidate_proof']['name'])) > 0){ 
          $error =$_FILES["candidate_proof"]["error"]; 
          if(!is_array($_FILES["candidate_proof"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_proof"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_proof"]["tmp_name"],$candidate_proof_dir.$fileName);
            $candidate_proof[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_proof"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_proof"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_proof"]["tmp_name"][$i],$candidate_proof_dir.$fileName);
                $candidate_proof[]= $fileName; 
            } 
          }
    } else {
          $candidate_proof[] = 'no-file';
      } 


      /**/

          $candidate_voter = array();
      $candidate_voter_dir = '../uploads/voter-docs/';

     
    
      if(!empty($_FILES['candidate_voter']['name']) && count(array_filter($_FILES['candidate_voter']['name'])) > 0){ 
          $error =$_FILES["candidate_voter"]["error"]; 
          if(!is_array($_FILES["candidate_voter"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_voter"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_voter"]["tmp_name"],$candidate_voter_dir.$fileName);
            $candidate_voter[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_voter"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_voter"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_voter"]["tmp_name"][$i],$candidate_voter_dir.$fileName);
                $candidate_voter[]= $fileName; 
            } 
          }
    } else {
          $candidate_voter[] = 'no-file';
      } 

          $candidate_ssn = array();
      $candidate_ssn_dir = '../uploads/ssn_doc/';

     
    
      if(!empty($_FILES['candidate_ssn']['name']) && count(array_filter($_FILES['candidate_ssn']['name'])) > 0){ 
          $error =$_FILES["candidate_ssn"]["error"]; 
          if(!is_array($_FILES["candidate_ssn"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_ssn"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_ssn"]["tmp_name"],$candidate_voter_dir.$fileName);
            $candidate_ssn[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_ssn"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_ssn"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_ssn"]["tmp_name"][$i],$candidate_ssn_dir.$fileName);
                $candidate_ssn[]= $fileName; 
            } 
          }
    } else {
          $candidate_ssn[] = 'no-file';
      } 

    // $data = $this->candidateModel->update_candidate_address($candidate_rental,$candidate_ration,$candidate_gov);
    $data = $this->candidateModel->update_candidate_document_check_insuff($candidate_aadhar,$candidate_pan,$candidate_proof,$candidate_voter,$candidate_ssn);
   
     $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_drug_test_insuff(){
    $data = $this->candidateModel->update_candidate_drug_test_insuff();
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if (isset($data['status'])?$data['status']:''=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_global_insuff(){
    $data = $this->candidateModel->update_candidate_global();
    // echo json_encode($data);
   /*  $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if (isset($data['status'])?$data['status']:''=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }


/*address*/

  function update_candidate_previous_address_insuff(){
    $candidate_rental = array();
      $candidate_aadhar_dir = '../uploads/rental-docs/';

     $count = $this->input->post('count');
     
     for ($i=0; $i < $count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_rental'.$i])) {
        if(!empty($_FILES['candidate_rental'.$i]['name']) && count(array_filter($_FILES['candidate_rental'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_rental".$i]["error"]; 
          if(!is_array($_FILES["candidate_rental".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_rental".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_rental".$i]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_rental".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_rental".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_rental".$i]["tmp_name"][$j],$candidate_aadhar_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_rental[] = $client_docs_obj;
     }


          $candidate_ration = array();
      $candidate_pan_dir = '../uploads/ration-docs/';

     
   for ($i=0; $i < $count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_ration'.$i])) {
        if(!empty($_FILES['candidate_ration'.$i]['name']) && count(array_filter($_FILES['candidate_ration'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_ration".$i]["error"]; 
          if(!is_array($_FILES["candidate_ration".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_ration".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_ration".$i]["tmp_name"],$candidate_pan_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_ration".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_ration".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_ration".$i]["tmp_name"][$j],$candidate_pan_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_ration[] = $client_docs_obj;
     }



          $candidate_gov = array();
      $candidate_gov_dir = '../uploads/gov-docs/';

     
  
   for ($i=0; $i < $count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_gov'.$i])) {
        if(!empty($_FILES['candidate_gov'.$i]['name']) && count(array_filter($_FILES['candidate_gov'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_gov".$i]["error"]; 
          if(!is_array($_FILES["candidate_gov".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_gov".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_gov".$i]["tmp_name"],$candidate_gov_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_gov".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_gov".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_gov".$i]["tmp_name"][$j],$candidate_gov_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_gov[] = $client_docs_obj;
     }


    $data = $this->candidateModel->update_candidate_previous_address_insuff($candidate_rental,$candidate_ration,$candidate_gov);
    // echo json_encode($data);
   /*  $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search((int)$this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }

  }




  function update_candidate_education_details_insuff(){


    $all_sem_marksheet = array();
      $all_sem_marksheet_dir = '../uploads/all-marksheet-docs/';

             $count = $this->input->post('count');
             $pan_count = $this->input->post('pan_count'); 
             $proof_count = $this->input->post('proof_count');
             $bank_count = $this->input->post('bank_count');
      

     for ($i=0; $i < $count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['all_sem_marksheet'.$i])) {
        if(!empty($_FILES['all_sem_marksheet'.$i]['name']) && count(array_filter($_FILES['all_sem_marksheet'.$i]['name'])) > 0){ 
          $error =$_FILES["all_sem_marksheet".$i]["error"]; 
          if(!is_array($_FILES["all_sem_marksheet".$i]["name"])) {
            $file_ext = pathinfo($_FILES["all_sem_marksheet".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["all_sem_marksheet".$i]["tmp_name"],$all_sem_marksheet_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["all_sem_marksheet".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["all_sem_marksheet".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["all_sem_marksheet".$i]["tmp_name"][$j],$all_sem_marksheet_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $all_sem_marksheet[] = $client_docs_obj;
     }

  
          $convocation = array();
      $convocation_dir = '../uploads/convocation-docs/';


     for ($i=0; $i < $pan_count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['convocation'.$i])) {
        if(!empty($_FILES['convocation'.$i]['name']) && count(array_filter($_FILES['convocation'.$i]['name'])) > 0){ 
          $error =$_FILES["convocation".$i]["error"]; 
          if(!is_array($_FILES["convocation".$i]["name"])) {
            $file_ext = pathinfo($_FILES["convocation".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["convocation".$i]["tmp_name"],$convocation_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["convocation".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["convocation".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["convocation".$i]["tmp_name"][$j],$convocation_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $convocation[] = $client_docs_obj;
     }

  


          $marksheet_provisional_certificate = array();
      $marksheet_provisional_certificate_dir = '../uploads/marksheet-certi-docs/';

   

     for ($i=0; $i < $proof_count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['marksheet_provisional_certificate'.$i])) {
        if(!empty($_FILES['marksheet_provisional_certificate'.$i]['name']) && count(array_filter($_FILES['marksheet_provisional_certificate'.$i]['name'])) > 0){ 
          $error =$_FILES["marksheet_provisional_certificate".$i]["error"]; 
          if(!is_array($_FILES["marksheet_provisional_certificate".$i]["name"])) {
            $file_ext = pathinfo($_FILES["marksheet_provisional_certificate".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["marksheet_provisional_certificate".$i]["tmp_name"],$marksheet_provisional_certificate_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["marksheet_provisional_certificate".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["marksheet_provisional_certificate".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["marksheet_provisional_certificate".$i]["tmp_name"][$j],$marksheet_provisional_certificate_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $marksheet_provisional_certificate[] = $client_docs_obj;
     }



      $ten_twelve_mark_card_certificate = array();
      $ten_twelve_mark_card_certificate_dir = '../uploads/ten-twelve-docs/';

 
     for ($i=0; $i < $bank_count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['ten_twelve_mark_card_certificate'.$i])) {
        if(!empty($_FILES['ten_twelve_mark_card_certificate'.$i]['name']) && count(array_filter($_FILES['ten_twelve_mark_card_certificate'.$i]['name'])) > 0){ 
          $error =$_FILES["ten_twelve_mark_card_certificate".$i]["error"]; 
          if(!is_array($_FILES["ten_twelve_mark_card_certificate".$i]["name"])) {
            $file_ext = pathinfo($_FILES["ten_twelve_mark_card_certificate".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["ten_twelve_mark_card_certificate".$i]["tmp_name"],$ten_twelve_mark_card_certificate_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["ten_twelve_mark_card_certificate".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["ten_twelve_mark_card_certificate".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["ten_twelve_mark_card_certificate".$i]["tmp_name"][$j],$ten_twelve_mark_card_certificate_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $ten_twelve_mark_card_certificate[] = $client_docs_obj;
     }



    $data = $this->candidateModel->update_candidate_education_details_insuff($all_sem_marksheet,$convocation,$marksheet_provisional_certificate,$ten_twelve_mark_card_certificate);
    // echo json_encode($data);
   /*  $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_present_address_insuff(){
    

    $candidate_rental = array();
      $candidate_aadhar_dir = '../uploads/rental-docs/';

     
    
      if(!empty($_FILES['candidate_rental']['name']) && count(array_filter($_FILES['candidate_rental']['name'])) > 0){ 
          $error =$_FILES["candidate_rental"]["error"]; 
          if(!is_array($_FILES["candidate_rental"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_rental"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_rental"]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $candidate_rental[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_rental"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_rental"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_rental"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
                $candidate_rental[]= $fileName; 
            } 
          }
    } else {
          $candidate_rental[] = 'no-file';
      }


          $candidate_ration = array();
      $candidate_pan_dir = '../uploads/ration-docs/';

     
    
      if(!empty($_FILES['candidate_ration']['name']) && count(array_filter($_FILES['candidate_ration']['name'])) > 0){ 
          $error =$_FILES["candidate_ration"]["error"]; 
          if(!is_array($_FILES["candidate_ration"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_ration"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_ration"]["tmp_name"],$candidate_ration.$fileName);
            $candidate_pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_ration"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_ration"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_ration"]["tmp_name"][$i],$candidate_pan_dir.$fileName);
                $candidate_ration[]= $fileName; 
            } 
          }
    } else {
          $candidate_ration[] = 'no-file';
      }


          $candidate_gov = array();
      $candidate_proof_dir = '../uploads/gov-docs/';

     
    
      if(!empty($_FILES['candidate_gov']['name']) && count(array_filter($_FILES['candidate_gov']['name'])) > 0){ 
          $error =$_FILES["candidate_gov"]["error"]; 
          if(!is_array($_FILES["candidate_gov"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_gov"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_gov"]["tmp_name"],$candidate_proof_dir.$fileName);
            $candidate_gov[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_gov"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_gov"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_gov"]["tmp_name"][$i],$candidate_proof_dir.$fileName);
                $candidate_gov[]= $fileName; 
            } 
          }
    } else {
          $candidate_gov[] = 'no-file';
      }


    $data = $this->candidateModel->update_candidate_present_address($candidate_rental,$candidate_ration,$candidate_gov);
    // echo json_encode($data);
     /*$user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }




  function update_candidate_address_insuff(){


    $candidate_rental = array();
      $candidate_aadhar_dir = '../uploads/rental-docs/';

     
    
      if(!empty($_FILES['candidate_rental']['name']) && count(array_filter($_FILES['candidate_rental']['name'])) > 0){ 
          $error =$_FILES["candidate_rental"]["error"]; 
          if(!is_array($_FILES["candidate_rental"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_rental"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_rental"]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $candidate_rental[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_rental"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_rental"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_rental"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
                $candidate_rental[]= $fileName; 
            } 
          }
    } else {
          $candidate_rental[] = 'no-file';
      }


          $candidate_ration = array();
      $candidate_pan_dir = '../uploads/ration-docs/';

     
    
      if(!empty($_FILES['candidate_ration']['name']) && count(array_filter($_FILES['candidate_ration']['name'])) > 0){ 
          $error =$_FILES["candidate_ration"]["error"]; 
          if(!is_array($_FILES["candidate_ration"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_ration"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_ration"]["tmp_name"],$candidate_ration.$fileName);
            $candidate_pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_ration"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_ration"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_ration"]["tmp_name"][$i],$candidate_pan_dir.$fileName);
                $candidate_ration[]= $fileName; 
            } 
          }
    } else {
          $candidate_ration[] = 'no-file';
      }


          $candidate_gov = array();
      $candidate_proof_dir = '../uploads/gov-docs/';

     
    
      if(!empty($_FILES['candidate_gov']['name']) && count(array_filter($_FILES['candidate_gov']['name'])) > 0){ 
          $error =$_FILES["candidate_gov"]["error"]; 
          if(!is_array($_FILES["candidate_gov"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_gov"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_gov"]["tmp_name"],$candidate_proof_dir.$fileName);
            $candidate_gov[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_gov"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_gov"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_gov"]["tmp_name"][$i],$candidate_proof_dir.$fileName);
                $candidate_gov[]= $fileName; 
            } 
          }
    } else {
          $candidate_gov[] = 'no-file';
      }


    $data = $this->candidateModel->update_candidate_address($candidate_rental,$candidate_ration,$candidate_gov);
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }

  }



  function update_candidate_employment_insuff(){
      $candidate_aadhar = array();
      $candidate_aadhar_dir = '../uploads/appointment_letter/';

     
    
      if(!empty($_FILES['candidate_aadhar']['name']) && count(array_filter($_FILES['candidate_aadhar']['name'])) > 0){ 
          $error =$_FILES["candidate_aadhar"]["error"]; 
          if(!is_array($_FILES["candidate_aadhar"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_aadhar"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $candidate_aadhar[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_aadhar"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_aadhar"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_aadhar"]["tmp_name"][$i],$candidate_aadhar_dir.$fileName);
                $candidate_aadhar[]= $fileName; 
            } 
          }
    } else {
          $candidate_aadhar[] = 'no-file';
      }


          $candidate_pan = array();
      $candidate_pan_dir = '../uploads/experience_relieving_letter/';

     
    
      if(!empty($_FILES['candidate_pan']['name']) && count(array_filter($_FILES['candidate_pan']['name'])) > 0){ 
          $error =$_FILES["candidate_pan"]["error"]; 
          if(!is_array($_FILES["candidate_pan"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_pan"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_pan"]["tmp_name"],$candidate_pan_dir.$fileName);
            $candidate_pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_pan"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_pan"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_pan"]["tmp_name"][$i],$candidate_pan_dir.$fileName);
                $candidate_pan[]= $fileName; 
            } 
          }
    } else {
          $candidate_pan[] = 'no-file';
    }


      $candidate_proof = array();
      $candidate_proof_dir = '../uploads/last_month_pay_slip/';

     
    
      if(!empty($_FILES['candidate_proof']['name']) && count(array_filter($_FILES['candidate_proof']['name'])) > 0){ 
          $error =$_FILES["candidate_proof"]["error"]; 
          if(!is_array($_FILES["candidate_proof"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_proof"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_proof"]["tmp_name"],$candidate_proof_dir.$fileName);
            $candidate_proof[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_proof"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_proof"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_proof"]["tmp_name"][$i],$candidate_proof_dir.$fileName);
                $candidate_proof[]= $fileName; 
            } 
          }
    } else {
          $candidate_proof[] = 'no-file';
      }


      $candidate_bank = array();
      $candidate_bank_dir = '../uploads/bank_statement_resigngation_acceptance/';

     
    
      if(!empty($_FILES['candidate_bank']['name']) && count(array_filter($_FILES['candidate_bank']['name'])) > 0){ 
          $error =$_FILES["candidate_bank"]["error"]; 
          if(!is_array($_FILES["candidate_bank"]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_bank"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_bank"]["tmp_name"],$candidate_bank_dir.$fileName);
            $candidate_bank[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_bank"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["candidate_bank"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_bank"]["tmp_name"][$i],$candidate_bank_dir.$fileName);
                $candidate_bank[]= $fileName; 
            } 
          }
    } else {
          $candidate_bank[] = 'no-file';
      }
    $data = $this->candidateModel->update_candidate_employment($candidate_aadhar,$candidate_pan,$candidate_proof,$candidate_bank);
    // $data = $this->candidateModel->update_candidate_employment();
    // echo json_encode($data);
   /*  $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }

  }

  function update_candidate_reference_insuff(){
    $data = $this->candidateModel->update_candidate_reference_insuff();
    // echo json_encode($data);
   /*  $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
      $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
      $comp = isset($component_id[$index])?$component_id[$index]:0;
     $url = $this->candidateModel->redirect_url($comp);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }

  }


  function update_candidate_previous_employment_insuff(){

    $candidate_aadhar = array();
      $candidate_aadhar_dir = '../uploads/appointment_letter/';
 
        $count = $this->input->post('count');
        $count_pan = $this->input->post('count_pan');
        $count_proof = $this->input->post('count_proof');
        $count_bank = $this->input->post('count_bank');
      



     for ($i=0; $i < $count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_aadhar'.$i])) {
        if(!empty($_FILES['candidate_aadhar'.$i]['name']) && count(array_filter($_FILES['candidate_aadhar'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_aadhar".$i]["error"]; 
          if(!is_array($_FILES["candidate_aadhar".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_aadhar".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_aadhar".$i]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_aadhar".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_aadhar".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_aadhar".$i]["tmp_name"][$j],$candidate_aadhar_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_aadhar[] = $client_docs_obj;
     }


          $candidate_pan = array();
      $candidate_pan_dir = '../uploads/experience_relieving_letter/';


     for ($i=0; $i < $count_pan; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_pan'.$i])) {
        if(!empty($_FILES['candidate_pan'.$i]['name']) && count(array_filter($_FILES['candidate_pan'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_pan".$i]["error"]; 
          if(!is_array($_FILES["candidate_pan".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_pan".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_pan".$i]["tmp_name"],$candidate_pan_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_pan".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_pan".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_pan".$i]["tmp_name"][$j],$candidate_pan_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_pan[] = $client_docs_obj;
     }



      $candidate_proof = array();
      $candidate_proof_dir = '../uploads/last_month_pay_slip/';

     
    
 
     for ($i=0; $i < $count_proof; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_proof'.$i])) {
        if(!empty($_FILES['candidate_proof'.$i]['name']) && count(array_filter($_FILES['candidate_proof'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_proof".$i]["error"]; 
          if(!is_array($_FILES["candidate_proof".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_proof".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_proof".$i]["tmp_name"],$candidate_proof_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_proof".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_proof".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_proof".$i]["tmp_name"][$j],$candidate_proof_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_proof[] = $client_docs_obj;
     }


      $candidate_bank = array();
      $candidate_bank_dir = '../uploads/bank_statement_resigngation_acceptance/';

     
   for ($i=0; $i < $count_bank; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['candidate_bank'.$i])) {
        if(!empty($_FILES['candidate_bank'.$i]['name']) && count(array_filter($_FILES['candidate_bank'.$i]['name'])) > 0){ 
          $error =$_FILES["candidate_bank".$i]["error"]; 
          if(!is_array($_FILES["candidate_bank".$i]["name"])) {
            $file_ext = pathinfo($_FILES["candidate_bank".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["candidate_bank".$i]["tmp_name"],$candidate_bank_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["candidate_bank".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["candidate_bank".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["candidate_bank".$i]["tmp_name"][$j],$candidate_bank_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_bank[] = $client_docs_obj;
     }


    $data = $this->candidateModel->update_candidate_previous_employment_insuff($candidate_aadhar,$candidate_pan,$candidate_proof,$candidate_bank);
    // echo json_encode($data);
    /* $user = $this->session->userdata('logged-in-candidate');
    $component_id = explode(',', $user['component_ids']);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user['component_ids'])))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }*/

     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }

  }


  /* new components */

   function update_candidate_sex_offender(){
    $data = $this->candidateModel->update_candidate_sex_offender();
    
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_politically_exposed(){
    $data = $this->candidateModel->update_candidate_politically_exposed();
    
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_india_civil_litigation(){
    $data = $this->candidateModel->update_candidate_india_civil_litigation();
    
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }


  function update_candidate_gsa(){
    $data = $this->candidateModel->update_candidate_gsa();
    
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }


  function update_candidate_oig(){
    $data = $this->candidateModel->update_candidate_oig();
    
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }


  function update_candidate_mca(){

      $mca = array();
      $mca_dir = '../uploads/mca-docs/';

     
    
      if(!empty($_FILES['mca']['name']) && count(array_filter($_FILES['mca']['name'])) > 0){ 
          $error =$_FILES["mca"]["error"]; 
          if(!is_array($_FILES["mca"]["name"])) {
            $file_ext = pathinfo($_FILES["mca"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["mca"]["tmp_name"],$mca.$fileName);
            $candidate_pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["mca"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["mca"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["mca"]["tmp_name"][$i],$mca_dir.$fileName);
                $mca[]= $fileName; 
            } 
          }
    } else {
          $mca[] = 'no-file';
      }

    $data = $this->candidateModel->update_candidate_mca($mca); 
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }

  function update_candidate_right_to_work(){
 
      $candidate_aadhar = array();
      $candidate_aadhar_dir = '../uploads/right_to_work-docs/';
 
        $count = $this->input->post('count'); 

     for ($i=0; $i < $count; $i++) { 
      $client_docs_obj = [];
      if (isset($_FILES['right_to_work'.$i])) {
        if(!empty($_FILES['right_to_work'.$i]['name']) && count(array_filter($_FILES['right_to_work'.$i]['name'])) > 0){ 
          $error =$_FILES["right_to_work".$i]["error"]; 
          if(!is_array($_FILES["right_to_work".$i]["name"])) {
            $file_ext = pathinfo($_FILES["right_to_work".$i]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["right_to_work".$i]["tmp_name"],$candidate_aadhar_dir.$fileName);
            $client_docs_obj[]= $fileName; 
          } else {
            $fileCount = count($_FILES["right_to_work".$i]["name"]);
            for($j=0; $j < $fileCount; $j++) {
                $fileName = $_FILES["right_to_work".$i]["name"][$j];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["right_to_work".$i]["tmp_name"][$j],$candidate_aadhar_dir.$fileName);
                $client_docs_obj[]= $fileName; 
            } 
          }
    } else {
          $client_docs_obj[] = 'no-file';
      }
      }
      
      $candidate_aadhar[] = $client_docs_obj;
     }


    $data = $this->candidateModel->update_candidate_right_to_work($candidate_aadhar); 
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }


  function update_candidate_nric(){


    $nric = array();
      $mca_dir = '../uploads/nric-docs/';

     
    
      if(!empty($_FILES['nric']['name']) && count(array_filter($_FILES['nric']['name'])) > 0){ 
          $error =$_FILES["nric"]["error"]; 
          if(!is_array($_FILES["nric"]["name"])) {
            $file_ext = pathinfo($_FILES["nric"]["name"], PATHINFO_EXTENSION);
            $fileName = uniqid().date('YmdHis').'.'.$file_ext;
            move_uploaded_file($_FILES["nric"]["tmp_name"],$nric.$fileName);
            $candidate_pan[]= $fileName; 
          } else {
            $fileCount = count($_FILES["nric"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $files_name = $_FILES["nric"]["name"][$i];
                $file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
                $fileName = uniqid().date('YmdHis').'.'.$file_ext;
                move_uploaded_file($_FILES["nric"]["tmp_name"][$i],$mca_dir.$fileName);
                $nric[]= $fileName; 
            } 
          }
    } else {
          $nric[] = 'no-file';
      }

    $data = $this->candidateModel->update_candidate_nric($nric);
    
     $user = $this->session->userdata('component_ids');
    $component_id = explode(',', $user);
    if ($data['status']=='1') {
     $index = array_search($this->input->post('url'),array_values(explode(',', $user)))+1;
     $url = $this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,$this->input->post('link_request_from'));
     echo json_encode(array('status'=>'1','url'=>$url));
    }else{
      echo json_encode($data);
    }
  }


}
