<?php 

class DynamicFields extends CI_Controller {
	
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('dynamicModel');   
	}

	function insert_field(){  
		echo json_encode($this->dynamicModel->manage_and_insert_update_fields());
	}
	function insert_employee_field(){  
		echo json_encode($this->dynamicModel->manage_and_insert_update_employee_fields());
	}
	function check_admin_login() {
		if(!$this->session->userdata('logged-in-admin')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function index(){ 
		$this->check_admin_login(); 
		$data['fields'] = $this->dynamicModel->get_fields();
		$data['session'] = $this->session->userdata('logged-in-admin');
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/field/dynamic-fields',$data);
		$this->load->view('admin/admin-common/footer');  
	}

	function dynamic_fields(){
       $data['fields'] = $this->dynamicModel->get_fields();
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
        }
        
        $this->load->view('admin/field/dynamic-view-fields',$data);
        $this->load->view('admin/admin-common/footer');
    }
    // employee
	function employee_fields(){ 
		$this->check_admin_login(); 
		$data['fields'] = $this->dynamicModel->get_fields();
		$data['session'] = $this->session->userdata('logged-in-admin');
		$this->load->view('admin/admin-common/header');
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/field/employee-dynamic-fields',$data);
		$this->load->view('admin/admin-common/footer');  
	}

	function employee_dynamic_fields(){
       $data['fields'] = $this->dynamicModel->get_fields();
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
        }
        
        $this->load->view('admin/field/employee-view-fields',$data);
        $this->load->view('admin/admin-common/footer');
    }

	function insert_field_values(){
		echo json_encode($this->dynamicModel->insert_field_values());
	}

	function update_field_values(){
		echo json_encode($this->dynamicModel->update_field_values());
	}

	function get_field_values(){
		$data['field_values'] = $this->dynamicModel->get_field_values();
		$variable_array_1 = array(
  			'clock_for' => 0
	  	);
	  	$time_format_details = $this->utilModel->get_time_format_details($variable_array_1);
	  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
	  	$selected_datetime_format = '';
	  	foreach ($get_all_date_time_format as $key => $value) {
	  		$val = (array)$value;
	  		if($val['id'] == $time_format_details['date_formate']) {
	  			$selected_datetime_format = $val;
	  			break;
	  		}
	  	}
	  	$data['selected_datetime_format'] = $selected_datetime_format;
		echo json_encode($data);
	}

	function get_field_details($id){
		echo json_encode($this->dynamicModel->get_field_details($id));
	}

	//employee

	function insert_employee_field_values(){
		echo json_encode($this->dynamicModel->insert_employee_field_values());
	}

	function update_employee_field_values(){
		echo json_encode($this->dynamicModel->update_employee_field_values());
	}

	function get_employee_field_values(){
		$data['field_values'] = $this->dynamicModel->get_employee_field_values();
		$variable_array_1 = array(
  			'clock_for' => 0
	  	);
	  	$time_format_details = $this->utilModel->get_time_format_details($variable_array_1);
	  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
	  	$selected_datetime_format = '';
	  	foreach ($get_all_date_time_format as $key => $value) {
	  		$val = (array)$value;
	  		if($val['id'] == $time_format_details['date_formate']) {
	  			$selected_datetime_format = $val;
	  			break;
	  		}
	  	}
	  	$data['selected_datetime_format'] = $selected_datetime_format;
		echo json_encode($data);
	}

	function get_employee_field_details($id){
		echo json_encode($this->dynamicModel->get_employee_field_details($id));
	}



 	function import_excel(){
		 // If file uploaded
 		$user = $this->session->userdata('logged-in-inputqc');
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
                // $lastRow = $spreadsheet->getHighestRow();
                 
                // array Count
                $arrayCount = count($allDataInSheet);
              	$flag = true;
                $i=0;
                $date = date('Y-m-d');
                $inserdata = array();
                $alphabet = array('B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                foreach ($allDataInSheet as $value) {
                  if($flag){
                  	$first_row =[];
                  	foreach ($alphabet as $key => $val) {
                  		$null_val = isset($value[$val])?$value[$val]:'';
                  		if ($null_val !='') { 
                  		 array_push($first_row,$value[$val]);
                  		} 
                  	}
                  	if ($this->input->post('type') =='education') {
	                   		$this->dynamicModel->field_name(implode(',',$first_row)); 
                    }else{
                    	$this->dynamicModel->employment_fields(implode(',',$first_row)); 
                    } 
                    $flag =false;
                    continue;
                } 
 				$second_row = [];
                foreach ($alphabet as $key => $val) {
                  		$null_val = isset($value[$val])?$value[$val]:'';
                  		if ($null_val !='') { 
                  		 array_push($second_row,$value[$val]);
                  		}
                  	}
                  	$row['field_values'] = json_encode($second_row);
                  	$row['created_date'] = $date;
                  	$row['updated_date'] = $date;

                  	array_push($inserdata,$row);
                  $i++;
                }   

                
	                if (count($inserdata) > 0) {
	                    if ($this->input->post('type') =='education') {
	                   	 $data = $this->dynamicModel->insert_batch_field_education($inserdata); 
	                    }else{
	                    	$data = $this->dynamicModel->insert_batch_field_employer($inserdata); 
	                    }
	                }else{
	                	$data = array('status'=>'0');
	                } 
    

                } else {
                    $data = array('status'=>'0');
                }
           echo json_encode($data); 

	}

	} 