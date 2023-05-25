<?php

/**
 * Created 1-2-2021
 */
class Mandate extends CI_Controller {
    function __construct()  
    {
      parent::__construct();
      $this->load->database();
      $this->load->helper('url'); 
      $this->load->model('mandateModel');
      $this->load->model('clientModel');      
    }

    function index(){
        $data['client'] = $this->clientModel->get_client_details();
        if ($this->session->userdata('logged-in-csm')) {
        $this->load->view('csm/csm-common/header');
        $this->load->view('csm/csm-common/sidebar');
        }else{
        $this->load->view('admin/admin-common/header');
        $this->load->view('admin/admin-common/sidebar');
        }
        // $this->load->view('admin/component/add-component');
        $this->load->view('admin/client-mandate/mandate',$data);
        $this->load->view('admin/admin-common/footer');
    }
 
    function client_mandate(){
        $data['client'] = $this->clientModel->get_client_details(); 
        if ($this->session->userdata('logged-in-inputqc')) {
            $this->load->view('inputqc/inputqc-common/header');
            $this->load->view('inputqc/inputqc-common/sidebar');  
        }else if ($this->session->userdata('logged-in-analyst')) {
          $this->load->view('analyst/analyst-common/header');
          $this->load->view('analyst/analyst-common/sidebar');
        }else if ($this->session->userdata('logged-in-outputqc')) {
            $this->load->view('outputqc/outputqc-common/header');
            $this->load->view('outputqc/outputqc-common/sidebar');
        }else if ($this->session->userdata('logged-in-specialist')) {
            $this->load->view('specialist/specialist-common/header');
            $this->load->view('specialist/specialist-common/sidebar');
        }else if($this->session->userdata('logged-in-insuffanalyst')){
          $this->load->view('analyst/analyst-common/header');
          $this->load->view('analyst/analyst-common/sidebar');  
        }else if($this->session->userdata('logged-in-am')){
          $this->load->view('am/am-common/header');
          $this->load->view('am/am-common/sidebar');  
        }
        
        $this->load->view('admin/client-mandate/mandate-view',$data);
        $this->load->view('admin/admin-common/footer');
    }

    function get_all_client_mandate(){
        echo json_encode($this->mandateModel->get_all_client_mandate());
    }

    function get_mandate_details($id){
        echo json_encode($this->mandateModel->get_mandate_details($id));
    }

    function insert_mandate(){
        echo json_encode($this->mandateModel->insert_mandate());
    }

    function update_mandate(){
        echo json_encode($this->mandateModel->update_mandate());
    }



}