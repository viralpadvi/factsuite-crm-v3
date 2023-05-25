<?php
/**
 * 
 */
use Aws\S3\S3Client;
class Client extends CI_Controller
{
	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url'); 
	  $this->load->model('teamModel');  
	  $this->load->model('clientModel');  
	  $this->load->model('packageModel');   
	  $this->load->model('emailModel');
	  $this->load->model('utilModel');
	  $this->load->model('outPutQcModel');
	  $this->load->model('utilModel');
	  $this->load->model('Approval_Mechanisms_Model');
	}


	function replace(){
		$reference = $this->db->get('reference')->result_array();

		foreach ($reference as $key => $value) {
			$name = explode(',', $value['name']);
			if (is_numeric($name[0])) {
				unset($name[0]);
			}

			$this->db->where('reference_id',$value['reference_id'])->update('reference',array('name'=>implode(',', $name)));
		}
	}


function s3_code(){ 
          // Instantiate an Amazon S3 client.
          $s3Client = new S3Client([
              'version' => 'latest',
              'region'  => 'ap-south-1',
              'credentials' => [
                  'key'    => 'AKIATGO2QJUUDP7SO6PR',
                  'secret' => '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'
              ]
          ]);
 
          $bucket = 'assets-factsuite-poc';
          $file_Path = 'http://159.89.174.203/UAT1/factsuite-crm-v2/factsuite-team/assets/admin/images/FactSuite-logo.png';
          $key = basename($file_Path);
 
          try {
              $result = $s3Client->putObject([
                  'Bucket' => $bucket,
                  'Key'    => $key,
                  'Body'   => fopen($file_Path, 'r'),
                  'ACL'    => 'public-read'
              ]);
            $msg = 'File has been uploaded';
          } catch (Aws\S3\Exception\S3Exception $e) {
              //$msg = 'File has been uploaded';
              echo $e->getMessage();
          }
          $msg = 'File has been uploaded';
        // }
}


function s3_v3(){
		if(isset($_FILES['image'])){
		$file_name = $_FILES['image']['name'];   
		$temp_file_location = $_FILES['image']['tmp_name'];  

		$s3 =  new S3Client([
			'region'  => 'ap-south-1',
			'version' => 'latest',
			'credentials' => [
				 'key'    => 'AKIATGO2QJUUDP7SO6PR',
         'secret' => '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'
			]
		]);		

		$result = $s3->putObject([
			'Bucket' =>  'assets-factsuite-poc',
			'Key'    => $file_name,
			'SourceFile' => $temp_file_location			
		]);

		var_dump($result);
	}
}


	function s3_bucket(){

 
$aws_access_key_id = 'AKIATGO2QJUUDP7SO6PR';
$aws_secret_access_key = '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';
 
// Bucket
//https://assets-factsuite-poc.s3.ap-south-1.amazonaws.com/uploads/img1.png
				$bucket_name = 'assets-factsuite-poc';
 
// AWS region and Host Name (Host names are different for each AWS region)
				// As an example these are set to us-east-1 (US Standard)
				$aws_region = 'ap-south-1';
				$host_name = $bucket_name . '.s3.amazonaws.com';
 
// Server path where content is present. This is just an example
				$content_path = 'http://159.89.174.203/UAT1/factsuite-crm-v2/factsuite-team/assets/admin/images/FactSuite-logo.png';
				$content = file_get_contents($content_path);
 
// AWS file permissions
				$content_acl = 'authenticated-read';
 
// MIME type of file. Very important to set if you later plan to load the file from a S3 url in the browser (images, for example)
				$content_type = 'image/png';
// Name of content on S3
				$content_title = 'uploads/FactSuite-logo.png';
 
// Service name for S3
				$aws_service_name = 's3';
 
// UTC timestamp and date
$timestamp = gmdate('Ymd\THis\Z');
$date = gmdate('Ymd');
 
// HTTP request headers as key & value
$request_headers = array();
$request_headers['Content-Type'] = $content_type;
$request_headers['Date'] = $timestamp;
$request_headers['Host'] = $host_name;
$request_headers['x-amz-acl'] = $content_acl;
$request_headers['x-amz-content-sha256'] = hash('sha256', $content);
// Sort it in ascending order
ksort($request_headers);
 
// Canonical headers
$canonical_headers = [];
foreach($request_headers as $key => $value) {
	$canonical_headers[] = strtolower($key) . ":" . $value;
}
$canonical_headers = implode("\n", $canonical_headers);
 
// Signed headers
$signed_headers = [];
foreach($request_headers as $key => $value) {
	$signed_headers[] = strtolower($key);
}
$signed_headers = implode(";", $signed_headers);
 
// Cannonical request
$canonical_request = [];
$canonical_request[] = "PUT";
$canonical_request[] = "/" . $content_title;
$canonical_request[] = "";
$canonical_request[] = $canonical_headers;
$canonical_request[] = "";
$canonical_request[] = $signed_headers;
$canonical_request[] = hash('sha256', $content);
$canonical_request = implode("\n", $canonical_request);
$hashed_canonical_request = hash('sha256', $canonical_request);
 
// AWS Scope
$scope = [];
$scope[] = $date;
$scope[] = $aws_region;
$scope[] = $aws_service_name;
$scope[] = "aws4_request";
 
// String to sign
$string_to_sign = [];
$string_to_sign[] = "AWS4-HMAC-SHA256"; 
$string_to_sign[] = $timestamp; 
$string_to_sign[] = implode('/', $scope);
$string_to_sign[] = $hashed_canonical_request;
$string_to_sign = implode("\n", $string_to_sign);
 
// Signing key
$kSecret = 'AWS4' . $aws_secret_access_key;
$kDate = hash_hmac('sha256', $date, $kSecret, true);
$kRegion = hash_hmac('sha256', $aws_region, $kDate, true);
$kService = hash_hmac('sha256', $aws_service_name, $kRegion, true);
$kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);
 
// Signature
$signature = hash_hmac('sha256', $string_to_sign, $kSigning);
 
// Authorization
$authorization = [
	'Credential=' . $aws_access_key_id . '/' . implode('/', $scope),
	'SignedHeaders=' . $signed_headers,
	'Signature=' . $signature,
];
$authorization = 'AWS4-HMAC-SHA256' . ' ' . implode( ',', $authorization);
 
// Curl headers
$curl_headers = [ 'Authorization: ' . $authorization ];
foreach($request_headers as $key => $value) {
	$curl_headers[] = $key . ": " . $value;
}
 
$url = 'https://' . $host_name . '/' . $content_title;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($http_code != 200) 
	exit('Error : Failed to upload');

	}



		public function page()
	{	
		$data['title'] = "Candidate";
		$data['filter_numbers'] = $this->utilModel->get_custom_filter_number_list_v2();
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data); 
		$this->load->view('page',$data);
		$this->load->view('admin/admin-common/footer',$data);
	}
	
	public function index_ajax($offset=null)
	{
		$search = array(
			'keyword' => trim($this->input->post('search_key')),
		);
		
		$this->load->library('pagination');
		
		$limit = $this->input->post('filter_cases_number') != '' ? $this->input->post('filter_cases_number') : 100;
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		$config['base_url'] = site_url('client/index_ajax/');
		$config['total_rows'] = $this->clientModel->get_products($limit, $offset, $search, $count=true);
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$config['num_links'] = 3;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a href="" class="current_page">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Previous';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);

		$data['products'] = $this->clientModel->get_products($limit, $offset, $search, $count=false);
	
		$data['pagelinks'] = $this->pagination->create_links();
		
		$this->load->view('ajax_page', $data);
	}

	function check_admin_login() {
		if(!$this->session->userdata('logged-in-admin')) {
			redirect($this->config->item('my_base_url').'login');
		}
	}

	function add_schedule_candidate_sms_email(){
		$data = $this->clientModel->add_schedule_candidate_sms_email(); 
    echo json_encode($data);
	}

	function get_all_schedule_data(){
		$data = $this->clientModel->get_all_schedule_data(); 
    echo json_encode($data);
	}

	function remove_schedule_link(){
			$data = $this->clientModel->remove_schedule_link(); 
    echo json_encode($data);
	}

  function get_selected_states($id){
    $data = $this->clientModel->get_all_states($id); 
    echo json_encode($data);
  }

  function get_selected_cities($id){
    $data = $this->clientModel->get_all_cities($id); 
    echo json_encode($data);
  }

  function insert_location(){
    $data = $this->clientModel->insert_location(); 
    echo json_encode($data);
  }

  function insert_segment(){
    $data = $this->clientModel->insert_segment(); 
    echo json_encode($data);
  }

  function client_email_notifications() {
  	$this->check_admin_login();
		$outputqcData['userData'] = $this->session->userdata('logged-in-admin');
		$variable_array = array(
			'clock_for' => 0 
		);
		$outputqcData['date_time_picker_type'] = $this->utilModel->get_time_format_details($variable_array);
		$this->load->view('admin/admin-common/header',$outputqcData);
		$this->load->view('admin/admin-common/sidebar');
		$this->load->view('admin/client/client-common');
		$this->load->view('admin/client/client-email-notifications');
		$this->load->view('admin/admin-common/footer');
  }

  function get_all_case_type() {
  	$this->check_admin_login();
		echo json_encode(array('status'=>'1','all_case_type'=>$this->utilModel->get_all_case_type()));
  }

  function add_new_client_notification_rule() {
  	$this->check_admin_login();
		echo json_encode(array('status'=>'1','rule_details'=>$this->clientModel->add_new_client_notification_rule()));
  }

  function get_all_client_notification_rule() {
  	$this->check_admin_login();
  	$variable_array = array(
  		'clock_for' => 0
  	);
  	$time_format_details = $this->utilModel->get_time_format_details($variable_array);
  	$get_all_date_time_format = json_decode(file_get_contents(base_url().'assets/custom-js/json/date-time-format.json',true));
  	$selected_datetime_format = '';
  	foreach ($get_all_date_time_format as $key => $value) {
  		$val = (array)$value;
  		if($val['id'] == $time_format_details['date_formate']) {
  			$selected_datetime_format = $val;
  			break;
  		}
  	}
		echo json_encode(array('status'=>'1','all_rules'=>$this->clientModel->get_all_client_notification_rules(),'all_case_type'=>file_get_contents(base_url().'assets/custom-js/json/case-type.json'),'selected_datetime_format'=>$selected_datetime_format));
  }

  function change_client_notification_status() {
  	$this->check_admin_login();
		echo json_encode(array('status'=>'1','return_status'=>$this->clientModel->change_client_notification_status()));
  }

  function get_single_client_notification_rule_details() {
  	$this->check_admin_login();
  	$notification_details = $this->clientModel->get_single_client_notification_rule_details();
  	$variable_array = array(
			'client_status' => 1,
			'client_type' =>  $notification_details['client_type']
		);
		
		echo json_encode(array('status'=>'1','notification_details'=>$notification_details,'all_case_type'=>file_get_contents(base_url().'assets/custom-js/json/case-type.json'),'all_clients'=>$this->utilModel->get_all_clients($variable_array),'all_rule_cirteria'=>file_get_contents(base_url().'assets/custom-js/json/rule-criteras.json'),'all_remaining_days_type'=>file_get_contents(base_url().'assets/custom-js/json/priority-remaining-days-type.json'),'all_case_priorities'=>file_get_contents(base_url().'assets/custom-js/json/case-priorities.json'),'all_client_type'=>file_get_contents(base_url().'assets/custom-js/json/client-type.json')));
  }

  function get_client_spoc_list() {
  	// $this->check_admin_login();
		echo json_encode(array('status'=>'1','client_spoc_list'=>$this->clientModel->get_client_spoc_list()));
  }

  function send_credentials_to_client_spoc() {
  	// $this->check_admin_login();
		echo json_encode(array('status'=>'1','send_credentials_to_client_spoc'=>$this->clientModel->send_credentials_to_client_spoc()));
  }

  function send_credentials_to_client_spoc_page() {
  	extract($_GET);
  	
  	$data['client_spoc_list'] = $this->db->join('tbl_client AS T2', 'T1.client_id = T2.client_id')->where_in('T1.client_id',$client_id)->get('tbl_clientspocdetails AS T1')->result_array();  
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
			$this->load->view('csm/csm-common/header',$data);
			$this->load->view('csm/csm-common/sidebar',$data);
		} else {
			$data['sessionData'] = $this->session->userdata('logged-in-admin');  
			$this->load->view('admin/admin-common/header',$data);
			$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common');
		$this->load->view('admin/client/send-credentials-to-client-spoc',$data);
		$this->load->view('admin/admin-common/footer');
  }

  function update_client_notification_rule() {
  	$this->check_admin_login();
		echo json_encode(array('status'=>'1','rule_details'=>$this->clientModel->update_client_notification_rule()));
  }

	function index() {
		$client_email_id = strtolower('viral.ce15@gmail.com');
		// Send To User Starts
		$client_email_message ='';
		$client_email_subject = 'Credentials';

		/*$client_email_message = '<html><body>';
		$client_email_message .= 'Hello : Test<br>';
		$client_email_message .= 'Your account has been created with factsuite team as client : <br>';
		$client_email_message .= 'Login using below credentials : <br>';
		$client_email_message .= 'Email ID : viral.padvi@gmail.com<br>';
		$client_email_message .= 'Password : 1234567<br>';
		$client_email_message .= 'Thank You,<br>';
		$client_email_message .= 'Team Factsuite Test';
		$client_email_message .= '</html></body>';*/

		// $client_email_message .= '<!DOCTYPE html>';
		$client_email_message .= '<html> ';
		$client_email_message .= '<head>';
		$client_email_message .= '<style>';
		$client_email_message .= 'table {';
		$client_email_message .= 'font-family: arial, sans-serif;';
		$client_email_message .= 'border-collapse: collapse;';
		$client_email_message .= 'width: 100%;';
		$client_email_message .= '}';

		$client_email_message .= 'td, th {';
		$client_email_message .= 'border: 1px solid #dddddd;';
		$client_email_message .= 'text-align: left;';
		$client_email_message .= 'padding: 8px;';
		$client_email_message .= '}';

		$client_email_message .= 'tr:nth-child(even) {';
		$client_email_message .= 'background-color: #dddddd;';
		$client_email_message .= '}';
		$client_email_message .= '</style>';
		$client_email_message .= '</head>';
		$client_email_message .= '<body> ';
		$client_email_message .= '<p>Dear "SPOC name",</p>';
		$client_email_message .= '<p>Greetings from Factsuite!!</p>';
		$client_email_message .= '<p>At the outset we thank you for choosing Factsuite as your Employee Background Screening partner.</p>';
		$client_email_message .= '<p>We appreciate your business & hope to delight you with our efficient service offerings during our association.</p>';
		$client_email_message .= '<p>Please find the Login Credentials for your Factsuite CRM access, mentioned below- </p>';
		$client_email_message .= '<table>';
		$client_email_message .= '<th>CRM Link</th>';
		$client_email_message .= '<th>UserName</th>';
		$client_email_message .= '<th>Password</th>';
		$client_email_message .= '<tr>';
		$client_email_message .= '<td>http://localhost:8080/factsuitecrm/client</td>';
		$client_email_message .= '<td>dummy@gmail.com</td>';
		$client_email_message .= '<td>dummy@gmail</td>';
		$client_email_message .= '<tr>';
		$client_email_message .= '</table>';
		$client_email_message .= '<p><b>Yours sincerely,<br>';
		$client_email_message .= 'Team FactSuite</b></p>';
		$client_email_message .= '</body>';
		$client_email_message .= '</html>';

		$send_email_to_user = $this->emailModel->send_mail($client_email_id,$client_email_subject,$client_email_message);
	}


	function add_client_images(){

		$client_docs = array();
    	$client_doc_dir = '../uploads/client-docs/';

     
    
    	if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){ 
      		$error =$_FILES["files"]["error"]; 
      		if(!is_array($_FILES["files"]["name"])) {
        		$file_ext = pathinfo($_FILES["files"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["files"]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["files"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$files_name = $_FILES["files"]["name"][$i];
          			$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["files"]["tmp_name"][$i],$client_doc_dir.$fileName);
          			$client_docs[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs[] = 'no-file';
    	}
    	return $client_docs;
    	// echo json_encode($client_docs);
	}	

	function insert_client(){
 	$img = $this->add_client_images();
		$data = $this->clientModel->insert_client($img);
		echo json_encode($data);
	}

	function remove_client_attachment(){
	$data = $this->clientModel->remove_client_attachment();
		echo json_encode($data);	
	}

	function get_view_client(){
		$data = $this->clientModel->get_client_details();
		echo json_encode($data);		
	}

	function valid_mail(){
		$data = $this->clientModel->email_duplication();
		echo json_encode($data);
	}
	function manager_valid_mail(){
		$data = $this->clientModel->manager_valid_mail();
		echo json_encode($data);
	}

	function remove_client(){
		$data = $this->clientModel->remove_client();
		echo json_encode($data);		
	} 

	function get_view_client_single($client_id){
		$data['client'] = $this->clientModel->get_client_details($client_id);
		$data['master'] = $this->clientModel->get_client_details();
		$data['team'] = $this->teamModel->get_team_details();
		$data['state'] = $this->clientModel->state();
		$data['package'] = $this->packageModel->get_package_details();
		$data['component'] = $this->packageModel->get_component_details($data['client']);
		$data['spoc'] = $this->clientModel->get_client_spoc_details($client_id); 
		$data['country'] = $this->clientModel->get_all_countries();
		$data['state'] = $this->clientModel->get_all_states(101);
		$data['city'] = $this->clientModel->get_all_cities();
		echo json_encode($data);	
	}

	function get_single_manager_details($team_id){
		$data['team'] = $this->teamModel->get_team_details($team_id);
		echo json_encode($data);
	}

	function update_client(){
		$client_docs = array();
    	$client_doc_dir = '../uploads/client-docs/';

     
    
    	if(!empty($_FILES['files']['name']) && count(array_filter($_FILES['files']['name'])) > 0){ 
      		$error =$_FILES["files"]["error"]; 
      		if(!is_array($_FILES["files"]["name"])) {
        		$file_ext = pathinfo($_FILES["files"]["name"], PATHINFO_EXTENSION);
        		$fileName = uniqid().date('YmdHis').'.'.$file_ext;
        		move_uploaded_file($_FILES["files"]["tmp_name"],$client_doc_dir.$fileName);
        		$client_docs[]= $fileName; 
      		} else {
        		$fileCount = count($_FILES["files"]["name"]);
        		for($i=0; $i < $fileCount; $i++) {
          			$files_name = $_FILES["files"]["name"][$i];
          			$file_ext = pathinfo($files_name, PATHINFO_EXTENSION);
          			$fileName = uniqid().date('YmdHis').'.'.$file_ext;
          			move_uploaded_file($_FILES["files"]["tmp_name"][$i],$client_doc_dir.$fileName);
          			$client_docs[]= $fileName; 
        		} 
      		}
		} else {
      		$client_docs[] = 'no-file';
    	}

		$data = $this->clientModel->update_client($client_docs);
		echo json_encode($data);
	}



	function update_client_package_component(){
		$package_components = json_decode($this->input->post('package_components'),true);  
		$package_data = $this->packageModel->get_package_components($this->input->post('package')); 
	/*	if (count($package_data) != count($package_components)) {
			echo json_encode(array('status'=>'0','msg'=>'failled')); 
			die();
		}*/
		$data = $this->clientModel->update_client_package_component();
		echo json_encode($data);
	}

	function update_client_alacarte_components(){
		$data = $this->clientModel->update_client_alacarte_components();
		echo json_encode($data);
	}



	function add_client_tat_view(){ 
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common');
		$this->load->view('admin/client/add-client-tat');
		$this->load->view('admin/admin-common/footer');
	}


	function consent_form_report_logo(){ 
		$data['clientInfo'] = $this->db->get('tbl_client')->result_array();  
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common');
		$this->load->view('admin/client/consent-form-logo');
		$this->load->view('admin/admin-common/footer');
	}


	function edit_client_tat_view(){ 
		$data['clientInfo'] = $this->db->get('tbl_client')->result_array();  
		if ($this->session->userdata('logged-in-csm')) {
			$data['sessionData'] = $this->session->userdata('logged-in-csm'); 
		$this->load->view('csm/csm-common/header',$data);
		$this->load->view('csm/csm-common/sidebar',$data);
		}else{
		$data['sessionData'] = $this->session->userdata('logged-in-admin');  
		$this->load->view('admin/admin-common/header',$data);
		$this->load->view('admin/admin-common/sidebar',$data);
		}
		$this->load->view('admin/client/client-common');
		$this->load->view('admin/client/edit-client-tat',$data);
		$this->load->view('admin/admin-common/footer');
	}
		   

	function updateClientTat(){
		$data = $this->clientModel->updateClientTat();
		echo json_encode($data);
	}
 
	function add_client_tat(){
		$data = $this->clientModel->add_client_tat();
		echo json_encode($data);
	}

	function getClientTatData(){
		$client_id = $this->input->post('client_id');
		$data = $this->clientModel->get_client_details($client_id);
		echo json_encode($data);
	}

	function client_access_status(){
		if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
				echo json_encode(array('status'=>'1','return_status'=>$this->clientModel->change_client_access_status()));
			} else {
				echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
			}
	}

	function change_candidate_notification_status() {
		if (isset($_POST) && $this->input->post('verify_admin_request') == '1' && $this->session->userdata('logged-in-admin')) {
			echo json_encode(array('status'=>'1','return_status'=>$this->clientModel->change_candidate_notification_status()));
		} else {
			echo json_encode(array('status'=>'201','message'=>'Bad Request Format'));
		}
	}

	function add_logo_consent(){
		$img = $this->add_client_images();
		$data = $this->clientModel->insert_update_client($img);
		echo json_encode($data);
	}

	function get_consent_logo(){
		$data = $this->clientModel->get_consent_logo();
		$location = $this->db->where('client_id',$this->input->post('client_id'))->get('autocomplete_location')->result_array();
		$segment = $this->db->where('client_id',$this->input->post('client_id'))->get('autocomplete_segment')->result_array();
		$client = $this->db->where('client_id',$this->input->post('client_id'))->get('tbl_client')->row_array();
		echo json_encode(array('data'=>$data,'location'=>$location,'segment'=>$segment,'client'=>$client));
	}

	function add_templates() {
		if ($this->input->post('templates') == 6) {
			$data = $this->clientModel->add_email_template_for_insuff_email_to_client();
		} else if ($this->input->post('templates') == 7) {
			$data = $this->clientModel->add_email_template_for_client_clarification_email_to_client();
		} else {
			$data = $this->clientModel->add_templates();
		}
		echo json_encode($data);
	}

	function get_selected_insuff_email_template_for_client() {
		echo json_encode($this->clientModel->get_selected_insuff_email_template_for_client());
	}

	function add_email_template_for_client_clarification_email_to_client() {
		echo json_encode($this->clientModel->add_email_template_for_client_clarification_email_to_client());
	}

	function get_templates(){
		$data = $this->clientModel->get_templates();
		echo json_encode($data);
	}

	function add_url_branding(){
		$data = $this->clientModel->add_url_branding();
		echo json_encode($data);
	}

function get_url_branding(){
		$data = $this->clientModel->get_url_branding();
		echo json_encode($data);
	}

		function add_nomanclature(){
		$data = $this->clientModel->add_nomanclature();
		echo json_encode($data);
	}

	function update_nomanclature(){
		$data = $this->clientModel->update_nomanclature();
		echo json_encode($data);
	}

	function get_nomanclature_details(){
		$data = $this->clientModel->get_nomanclature_details();
		echo json_encode($data);
	}


	function remove_nomanclature($nomanclature_id){
		$data = $this->clientModel->remove_nomanclature($nomanclature_id);
		echo json_encode($data);
	}

	/*client*/


		function get_total_sales(){
			echo $this->clientModel->get_all_clients_purchased_service_package_count();
		}

		function get_total_no_of_orders(){
			echo $this->clientModel->get_total_no_of_orders();
		}

		function get_average_order_value(){
			echo $this->clientModel->get_all_clients_purchased_service_package_count_avg();
		}

		function get_total_order_returns(){
			echo $this->clientModel->get_total_order_returns();
		}

		function get_sales_by_item_count(){
			echo $this->clientModel->get_sales_by_item_count();
		}

		function get_top_selling_items(){
			echo json_encode($this->clientModel->get_top_selling_items());
		}

			function all_component_ageing_in_progress_analytics(){
		if (isset($_POST) && $this->input->post('is_admin') == '1') {
			 echo json_encode(array('status'=>'200','client_data' => $this->clientModel->all_component_ageing_in_progress_analytics()));
		}else{
			echo json_encode(array('status'=>'400','msg'=>'Bad Requiest'));
			die();
		}	
	}


}