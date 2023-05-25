<?php

/**
 *  
 */
class Process_Guidline extends CI_Controller {
    function __construct()  
    {
      parent::__construct();
      $this->load->database();
      $this->load->helper('url'); 
      $this->load->model('processGuidlineModel');     
      $this->load->model('componentModel');     
    }

    function process_guidline(){
      $data['component'] = $this->componentModel->get_component_details();
      $this->load->view('admin/admin-common/header');
      $this->load->view('admin/admin-common/sidebar');
      $this->load->view('admin/process/process-view',$data);
      $this->load->view('admin/admin-common/footer');
    }

    function add_process_guidline(){
      $attachment = $this->processGuidlineUpload();
      $data = $this->processGuidlineModel->insert_process_guidline($attachment);
      echo json_encode($data);
    }

    function edit_process_guidline(){
      $attachment = $this->processGuidlineUpload();
      $data = $this->processGuidlineModel->update_process_guidline($attachment);
      echo json_encode($data);
    }

    function remove_process($id){ 
      $data = $this->processGuidlineModel->remove_process($id);
      echo json_encode($data);
    }

    function get_process_details($id){
       $data = $this->processGuidlineModel->get_process_details($id);
      echo json_encode($data);
    }

    function processGuidlineUpload(){
      $client_docs = array();
      $client_doc_dir = '../uploads/process-docs/';
      $count = $this->input->post('count'); 
 
      if(!empty($_FILES['attachment']['name']) && count(array_filter($_FILES['attachment']['name'])) > 0){ 
          $error =$_FILES["attachment"]["error"]; 
          if(!is_array($_FILES["attachment"]["name"])) {
            $file_ext = pathinfo($_FILES["attachment"]["name"], PATHINFO_EXTENSION);
            $fileName = str_replace(" ", "-",$this->input->post('process_name')).'.'.$file_ext;
            move_uploaded_file($_FILES["attachment"]["tmp_name"],$client_doc_dir.$fileName);
            $client_docs[]= $fileName; 
          } else {
            $fileCount = count($_FILES["attachment"]["name"]);
            for($i=0; $i < $fileCount; $i++) {
                $approved_doc_name = $_FILES["attachment"]["name"][$i];
                $file_ext = pathinfo($approved_doc_name, PATHINFO_EXTENSION);
                $fileName = str_replace(" ", "-",$this->input->post('process_name')).'.'.$file_ext;
                move_uploaded_file($_FILES["attachment"]["tmp_name"][$i],$client_doc_dir.$fileName);
                $client_docs[]= $fileName; 
            } 
          }
    } else {
          $client_docs[] = 'no-file';
      } 

      return $client_docs;
    }

    function view_process_guidline(){
      $data = $this->processGuidlineModel->get_guidline_list();
      echo json_encode($data);
    }

}