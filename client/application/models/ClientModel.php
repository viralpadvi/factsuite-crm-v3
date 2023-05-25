<?php
/**
 * 
 */
class ClientModel extends CI_Model
{
	
	function get_single_component($component){
		return $this->db->where('component_id',$component)->get('components')->row_array();
	}
	function get_client_details($client_id=''){ 
		$result ='';
		if ($client_id !='') { 
			$result = $this->db->where('client_id',$client_id)->select('tbl_client.*, team_employee.first_name, team_employee.last_name,industry.*')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->join('industry','tbl_client.client_industry = industry.industry_id','left')->get()->row_array();
		}else{ 
			if ($this->session->userdata('logged-in-csm')) {
				$csm = $this->session->userdata('logged-in-csm'); 
				$this->db->where('tbl_client.account_manager_name',$csm['team_id']);
			}
			$result = $this->db->order_by('tbl_client.client_id','DESC')->where('active_status',1)->select('tbl_client.*, team_employee.first_name, team_employee.last_name,industry.*')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->join('industry','tbl_client.client_industry = industry.industry_id','left')->get()->result_array();
		}
		return $result;
	}

	function get_all_clients() {
		return $this->db->get('tbl_client')->result_array();	
	}

	function get_master_client_details($client_id=''){ 
		$result ='';
		if ($client_id !='') { 
			$result = $this->db->where('client_id',$client_id)->where('tbl_client.is_master','0')->select('tbl_client.*, team_employee.first_name, team_employee.last_name,industry.*')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->join('industry','tbl_client.client_industry = industry.industry_id','left')->get()->row_array();
		}else{
			$result = $this->db->where('active_status',1)->where('tbl_client.is_master','0')->select('tbl_client.*, team_employee.first_name, team_employee.last_name,industry.*')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->join('industry','tbl_client.client_industry = industry.industry_id','left')->get()->result_array();
		}
		return $result;
	}



	function get_candidate_details(){
		return $this->db->get('candidate')->result_array();
	}

	function remove_client_attachment(){
		$client_id = $this->get_client_details($this->input->post('client_id'));
		$client_doc = array();
		foreach (explode(',', $client_id['upload_doc_name']) as $key => $doc) {
			if ($doc != $this->input->post('file')) {
				array_push($client_doc,$doc);
			}
		}
		$docs =array(
			'upload_doc_name'=>implode(',', $client_doc)
		);
		 
		$this->db->where('client_id',$this->input->post('client_id'));
		if ($this->db->update('tbl_client',$docs)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failed');
		}
	}

	function state(){
		return $stateList = array('Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya',
                                                         'Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh',
                                                         'Uttarakhand','West Bengal');
	}

	function email_duplication(){
		$result = $this->db->where('spoc_email_id',$this->input->post('email'))->get('tbl_clientspocdetails')->num_rows();
		if ($result > 0) {
			return array('status'=>'0','msg'=>'duplicate');
		}else{
			return array('status'=>'1','msg'=>'valid');
		}
	}
	function manager_valid_mail(){
		$result = $this->db->where('account_manager_email_id',$this->input->post('email'))->get('tbl_client')->num_rows();
		if ($result > 0) {
			return array('status'=>'0','msg'=>'duplicate');
		}else{
			return array('status'=>'1','msg'=>'valid');
		}
	}

	function get_client_spoc_details($client_id){
		$result = $this->db->where('spoc_status',1)->where('client_id',$client_id)->get('tbl_clientspocdetails')->result_array();
		return $result;
	}

	function insert_client($img){  

			$this->load->helper('string'); 
			$package = array(
				'package'=>$this->input->post('component_package_id'),
				'component_price'=>$this->input->post('component_standard_price')
			);

			$token = md5($this->input->post('client_name')).openssl_random_pseudo_bytes(50).md5(date('dmYHis'));
			$token = bin2hex($token);

			$client_data = array(
				'client_name'=>$this->input->post('client_name'),
				'client_address'=>$this->input->post('client_address'),
				'client_city'=>$this->input->post('client_city'),
				'client_state'=>$this->input->post('client_state'), 
				'client_country'=>$this->input->post('country'), 
				'account_manager_name'=>$this->input->post('account_manager'),  
				'client_industry'=>$this->input->post('client_industry'),
				'other_industry'=>$this->input->post('other_industry'),
				'website'=>$this->input->post('client_website'),
				'communications'=>$this->input->post('communications'),
				'account_contact_no'=>$this->input->post('manager_contact'),
				'account_manager_email_id'=>$this->input->post('manager_email'), 
				// 'packages'=>$this->input->post('package'),
				'poc_contact_number'=>$this->input->post('spo_contact'),
				'poc_user_email'=>$this->input->post('spo_email'),
				'poc_user_name'=>$this->input->post('spo_name'),
				// 'user_password'=>implode(',', $password),
				'client_zip'=>$this->input->post('zip'),
				'upload_doc_name'=>implode(',', $img), 
				/*'component_id'=>$this->input->post('component_name'),
				'component_price'=>json_encode($package),
				'component_client_price'=>$this->input->post('component_price'),*/
				/*'package_components'=>$this->input->post('package_components'),
				'alacarte_components'=>$this->input->post('alacarte_components'),*/

				//TAT
				/*'low_priority_percentage'=>$this->input->post('low_priority_percentage'), 
				'low_priority_days'=>$this->input->post('low_priority_days'), 
				'medium_priority_percentage'=>$this->input->post('medium_priority_percentage'), 
				'medium_priority_days'=>$this->input->post('medium_priority_days'), 
				'high_priority_percentage'=>$this->input->post('high_priority_percentage'), 
				'high_priority_days'=>$this->input->post('high_priority_days'),
				'tat_updated_date' => date('d-m-Y H:i:s'),*/
				'access_token'=>$token
			);
			if ($this->input->post('is_master')) {
				$client_data['is_master'] = 0;
			}else if ($this->input->post('master_account')) { 
				$client_data['is_master'] =$this->input->post('master_account');
			}else{
				$client_data['is_master'] = 0;
			}
			if ($this->db->insert('tbl_client',$client_data)) {
				$spoc = array();
				$insert_id = $this->db->insert_id();
				$name = explode(',', $this->input->post('spo_name'));
				$spo_contact = explode(',', $this->input->post('spo_contact'));
				$spoc_id = explode(',', $this->input->post('spo_id'));
				$password = '';
				foreach (explode(',',$this->input->post('spo_email')) as $key => $value) { 
					$password = random_string('alnum', 8);
					$row['client_id'] = $insert_id;
					$row['spoc_name'] = $name[$key];
					$row['spoc_phone_no'] = $spo_contact[$key];
					$row['spoc_email_id'] = $value;
					$row['SPOC_Password'] = base64_encode($password);
					array_push($spoc, $row);

				$client_email_id = strtolower($value);
				// Send To User Starts
				$client_email_subject = 'Credentials';

				$templates = $this->db->where('client_id',0)->where('template_type','Initiate Case')->get('email-templates')->row_array();
				$email_message ='';
				$login_otp  ='';
				if (isset($templates['template_content'])) { 
						$need_replace = ["@client_email_id","@client_name", "@link", "@otp_or_password"];
					$replace_strings   = [$client_email_id,ucwords($this->input->post('client_name')), $this->config->item('client_url'), $this->config->item('user_contact'),$password ];

					$email_message =  str_replace($need_replace, $replace_strings, $templates['template_content']);
					
			}else{

				/*$client_email_message = '<html><body>';
				$client_email_message .= 'Hello : '.$name[$key].'<br>';
				$client_email_message .= 'Your account has been created with factsuite team as client : <br>';
				$client_email_message .= 'Login using below credentials : <br>';
				$client_email_message .= 'Email ID : '.$client_email_id.'<br>';
				$client_email_message .= 'Password : '.$password.'<br>';
				$client_email_message .= 'Thank You,<br>';
				$client_email_message .= 'Team FactSuite';
				$client_email_message .= '</html></body>';*/
				$client_email_message ='';
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
				$client_email_message .= '<p>Dear '.$this->input->post('client_name').',</p>';
				$client_email_message .= '<p>Greetings from Factsuite!!</p>';
				$client_email_message .= '<p>At the outset we thank you for choosing Factsuite as your Employee Background Screening partner.</p>';
				$client_email_message .= '<p>We appreciate your business & hope to delight you with our efficient service offerings during our association.</p>';
				$client_email_message .= '<p>Please find the Login Credentials for your Factsuite CRM access, mentioned below- </p>';
				$client_email_message .= '<table>';
				$client_email_message .= '<th>CRM Link</th>';
				$client_email_message .= '<th>UserName</th>';
				$client_email_message .= '<th>Password</th>';
				$client_email_message .= '<tr>';
				$client_email_message .= '<td>'.$this->config->item('client_url').'</td>';
				$client_email_message .= '<td>'.$client_email_id.'</td>';
				$client_email_message .= '<td>'.$password.'</td>';//http://localhost:8080/factsuitecrm/
				$client_email_message .= '<tr>';
				$client_email_message .= '</table>';
				$client_email_message .= '<p><b>Yours sincerely,<br>';
				$client_email_message .= 'Team FactSuite</b></p>';
				$client_email_message .= '</body>';
				$client_email_message .= '</html>';

			}

				$send_email_to_user = $this->emailModel->send_mail($client_email_id,$client_email_subject,$client_email_message);

				}
				$this->db->insert_batch('tbl_clientspocdetails',$spoc);

			$client_log_data = array(
					'client_id'=>$insert_id,
				'client_name'=>$this->input->post('client_name'),
				'client_address'=>$this->input->post('client_address'),
				'client_city'=>$this->input->post('client_city'),
				'client_state'=>$this->input->post('client_state'), 
				'account_manager_name'=>$this->input->post('account_manager'),  
				'client_industry'=>$this->input->post('client_industry'),
				'website'=>$this->input->post('client_website'),
				'communications'=>$this->input->post('communications'),
				'account_contact_no'=>$this->input->post('manager_contact'),
				'account_manager_email_id'=>$this->input->post('manager_email'),
				'is_master'=>$this->input->post('master_account'),
				// 'packages'=>$this->input->post('package'),
				'poc_contact_number'=>$this->input->post('spo_contact'),
				'poc_user_email'=>$this->input->post('spo_email'),
				'poc_user_name'=>$this->input->post('spo_name'),
				// 'user_password'=>implode(',', $password),
				'client_zip'=>$this->input->post('zip'),
				'upload_doc_name'=>$this->input->post('client_docs'), 
				'component_id'=>$this->input->post('component_name'),
				'component_price'=>json_encode($package),
				'component_client_price'=>$this->input->post('component_price'),
				'active_status'=>1,
			);

			$this->db->insert('tbl_client_log',$client_log_data);
				return array('status'=>'1','msg'=>'success','client_id' => $insert_id );
			}else{
				return array('status'=>'0','msg'=>'failed');
			} 		 
	}

	function remove_client(){
		$client_status = array(
			'active_status'=>0
		);
		$this->db->where('client_id',$this->input->post('client_id'));
		if ($this->db->update('tbl_client',$client_status)) {
			$spoc_status = array(
			'spoc_status'=>0
			);
			$this->db->where('client_id',$this->input->post('client_id')); 
			$this->db->update('tbl_clientspocdetails',$spoc_status);
			$result = $this->db->where('client_id',$this->input->post('client_id'))->get('tbl_client')->row_array(); 
			$client_log_data = array(
				'client_id'=>$result['client_id'],
				'client_name'=>$result['client_name'],
				'client_address'=>$result['client_address'],
				'client_city'=>$result['client_city'],
				'client_state'=>$result['client_state'],
				'account_manager_name'=>$result['account_manager_name'], 
				'client_industry'=>$result['client_industry'],
				'website'=>$result['website'],
				'communications'=>$result['communications'],
				'account_contact_no'=>$result['account_contact_no'],
				'account_manager_email_id'=>$result['account_manager_email_id'],
				'is_master'=>$result['is_master'],
				'packages'=>$result['packages'],
				'poc_contact_number'=>$result['poc_contact_number'],
				'poc_user_email'=>$result['poc_user_email'],
				'poc_user_name'=>$result['poc_user_name'],
				'user_password'=>$result['user_password'],
				'client_zip'=>$result['client_zip'],
				'upload_doc_name'=>$result['upload_doc_name'], 
				'component_id'=>$result['component_id'],
				'component_price'=>$result['component_price'],
				'component_client_price'=>$result['component_client_price'],
				'active_status'=>2,
			);
			$this->db->insert('tbl_client_log',$client_log_data); 

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'1','msg'=>'failed');
		}
	}

	function update_client($client_doc){  
			$this->load->helper('string');
			$password = array();
			foreach (explode(',',$this->input->post('spo_email')) as $key => $value) {
				array_push($password, base64_encode(rand()));
			}

			/*$package = array(
				'package'=>$this->input->post('component_package_id'),
				'component_price'=>$this->input->post('component_standard_price')
			);*/

			$client_data = array(
				'client_name'=>$this->input->post('client_name'),
				'client_address'=>$this->input->post('client_address'),
				'client_city'=>$this->input->post('client_city'),
				'client_state'=>$this->input->post('client_state'), 
				'account_manager_name'=>$this->input->post('account_manager'),  
				'client_industry'=>$this->input->post('client_industry'),
				'other_industry'=>$this->input->post('other_industry'),
				'website'=>$this->input->post('client_website'),
				'communications'=>$this->input->post('communications'),
				'account_contact_no'=>$this->input->post('manager_contact'),
				'account_manager_email_id'=>$this->input->post('manager_email'),
				// 'is_master'=>$this->input->post('master_account'),
				// 'packages'=>$this->input->post('package'),
				'poc_contact_number'=>$this->input->post('spo_contact'),
				'poc_user_email'=>$this->input->post('spo_email'),
				'poc_user_name'=>$this->input->post('spo_name'),
				'user_password'=>implode(',', $password),
				'client_zip'=>$this->input->post('zip'),
				/*'component_id'=>$this->input->post('component_name'),
				'component_price'=>json_encode($package),
				'component_client_price'=>$this->input->post('component_price'),*/
			);
			if ($this->input->post('is_master')) {
				$client_data['is_master'] = 0;
			}else if ($this->input->post('master_account')) { 
				$client_data['is_master'] =$this->input->post('master_account');
			}else{
				$client_data['is_master'] = 0;
			}

			if (!in_array('no-file', $client_doc)) {
				$client_docs = $this->db->where('client_id',$this->input->post('client_id'))->select('tbl_client.upload_doc_name')->from('tbl_client')->get()->row_array();
				if ($client_docs['upload_doc_name'] !='' || $client_docs['upload_doc_name'] != 'no-file') { 
					foreach (explode(',', $client_docs['upload_doc_name']) as $key => $value) {
						array_push($client_doc, $value);
					}
				}
				$client_data['upload_doc_name']=implode(',', $client_doc); 
				
			}
			$this->db->where('client_id',$this->input->post('client_id'));
			if ($this->db->update('tbl_client',$client_data)) {
				$spoc = array();
				$spoc_insert = array();
				$insert_id = $this->input->post('client_id');
				$spoc_id = explode(',', $this->input->post('spo_id'));
				$name = explode(',', $this->input->post('spo_name'));
				$spo_contact = explode(',', $this->input->post('spo_contact'));
				foreach (explode(',',$this->input->post('spo_email')) as $key => $value) { 
					if (isset($spoc_id[$key])) {
					$row['spoc_id'] = $spoc_id[$key];
					$row['client_id'] = $insert_id;
					$row['spoc_name'] = $name[$key];
					$row['spoc_phone_no'] = $spo_contact[$key];
					$row['spoc_email_id'] = $value;
					// $row['SPOC_Password'] = $password[$key];//base64_encode(random_string('alnum', 8));
					array_push($spoc, $row); 
					}else{
					$row['spoc_id'] = $spoc_id[$key];
					$row['client_id'] = $insert_id;
					$row['spoc_name'] = $name[$key];
					$row['spoc_phone_no'] = $spo_contact[$key];
					$row['spoc_email_id'] = $value;
					$row['SPOC_Password'] = $password[$key];//base64_encode(random_string('alnum', 8));
					array_push($spoc_insert, $row);  


					$client_email_id = strtolower($value);
				// Send To User Starts
				$client_email_subject = 'Credentials';

				/*$client_email_message = '<html><body>';
				$client_email_message .= 'Hello : '.$name[$key].'<br>';
				$client_email_message .= 'Your account has been created with factsuite team as client : <br>';
				$client_email_message .= 'Login using below credentials : <br>';
				$client_email_message .= 'Email ID : '.$client_email_id.'<br>';
				$client_email_message .= 'Password : '.$password.'<br>';
				$client_email_message .= 'Thank You,<br>';
				$client_email_message .= 'Team FactSuite';
				$client_email_message .= '</html></body>';*/
				$client_email_message ='';
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
				$client_email_message .= '<p>Dear '.$this->input->post('client_name').',</p>';
				$client_email_message .= '<p>Greetings from Factsuite!!</p>';
				$client_email_message .= '<p>At the outset we thank you for choosing Factsuite as your Employee Background Screening partner.</p>';
				$client_email_message .= '<p>We appreciate your business & hope to delight you with our efficient service offerings during our association.</p>';
				$client_email_message .= '<p>Please find the Login Credentials for your Factsuite CRM access, mentioned below- </p>';
				$client_email_message .= '<table>';
				$client_email_message .= '<th>CRM Link</th>';
				$client_email_message .= '<th>UserName</th>';
				$client_email_message .= '<th>Password</th>';
				$client_email_message .= '<tr>';
				$client_email_message .= '<td>'.$this->config->item('client_url').'</td>';
				$client_email_message .= '<td>'.$client_email_id.'</td>';
				$client_email_message .= '<td>'.$password[$key].'</td>';//http://localhost:8080/factsuitecrm/
				$client_email_message .= '<tr>';
				$client_email_message .= '</table>';
				$client_email_message .= '<p><b>Yours sincerely,<br>';
				$client_email_message .= 'Team FactSuite</b></p>';
				$client_email_message .= '</body>';
				$client_email_message .= '</html>';

				$send_email_to_user = $this->emailModel->send_mail($client_email_id,$client_email_subject,$client_email_message);
				}

				}
				$this->db->update_batch('tbl_clientspocdetails',$spoc,'spoc_id');
				if (count($spoc_insert) > 0) {
				$this->db->insert_batch('tbl_clientspocdetails',$spoc_insert);	
				}

			$client_log_data = array(
					'client_id'=>$insert_id,
				'client_name'=>$this->input->post('client_name'),
				'client_address'=>$this->input->post('client_address'),
				'client_city'=>$this->input->post('client_city'),
				'client_state'=>$this->input->post('client_state'), 
				'account_manager_name'=>$this->input->post('account_manager'),  
				'client_industry'=>$this->input->post('client_industry'),
				'website'=>$this->input->post('client_website'),
				'communications'=>$this->input->post('communications'),
				'account_contact_no'=>$this->input->post('manager_contact'),
				'account_manager_email_id'=>$this->input->post('manager_email'),
				'is_master'=>$this->input->post('master_account'),
				// 'packages'=>$this->input->post('package'),
				'poc_contact_number'=>$this->input->post('spo_contact'),
				'poc_user_email'=>$this->input->post('spo_email'),
				'poc_user_name'=>$this->input->post('spo_name'),
				'user_password'=>implode(',', $password),
				'client_zip'=>$this->input->post('zip'),
				'upload_doc_name'=>implode(',', $client_doc), 
				'component_id'=>$this->input->post('component_name'),
				/*'component_price'=>json_encode($package), 
				'component_client_price'=>$this->input->post('component_price'),*/
				'active_status'=>1,
			);
			$this->db->insert('tbl_client_log',$client_log_data);
				return array('status'=>'1','msg'=>'success');
			}else{
				return array('status'=>'0','msg'=>'failed');
			} 		 
	}



	/*update client*/
	function update_client_package_component(){
		$client_data = array(
				'packages'=>$this->input->post('package'), 
				'package_components'=>$this->input->post('package_components'), 
			);
		$this->db->where('client_id',$this->input->post('client_id'));
		if($this->db->update('tbl_client',$client_data)){
				return array('status'=>'1','msg'=>'success');
			}else{
				return array('status'=>'0','msg'=>'failed');
			}
	}

	function update_client_alacarte_components(){
		$client_data = array( 
				'alacarte_components'=>$this->input->post('alacarte_components'), 
			);
		$this->db->where('client_id',$this->input->post('client_id'));
		if($this->db->update('tbl_client',$client_data)){
				return array('status'=>'1','msg'=>'success');
			}else{
				return array('status'=>'0','msg'=>'failed');
			}
	}


	function get_all_countries(){
		return $this->db->get('countries')->result_array();
	}

	function get_all_states($id=''){
		if ($id !='') {
			return $this->db->where('country_id',$id)->get('states')->result_array();
		}else{
			return $this->db->order_by('country_id','ASC')->get('states')->result_array();
		}
	}

	function get_all_cities($id=''){
		if ($id !='') {
			return $this->db->where('state_id',$id)->get('cities')->result_array();
		}else{
			return $this->db->order_by('state_id','ASC')->get('cities')->result_array();
		}
	}


	function updateClientTat(){
		// var_dump($_POST);
		// exit();
		$client_id = $this->input->post('client_id');
		$client_tat_data = array( 
			'low_priority_percentage'=>$this->input->post('low_priority_percentage'), 
			'low_priority_days'=>$this->input->post('low_priority_days'), 
			'medium_priority_percentage'=>$this->input->post('medium_priority_percentage'), 
			'medium_priority_days'=>$this->input->post('medium_priority_days'), 
			'high_priority_percentage'=>$this->input->post('high_priority_percentage'), 
			'high_priority_days'=>$this->input->post('high_priority_days'),
			'tat_updated_date' => date('d-m-Y H:i:s')
		);

		 
		if($this->db->where('client_id',$client_id)->update('tbl_client',$client_tat_data)){
			/*$newUpdateData = $this->db->where('client_id',$client_id)->get('tbl_client')->row_array();
			if($this->db->insert('tbl_client_log',$newUpdateData)){
				return array('status'=>'1','msg'=>'success','log_data'=>'1');
			}else{
				return array('status'=>'1','msg'=>'success','log_data'=>'0');
			}*/
				return array('status'=>'1','msg'=>'success','log_data'=>'1');
		}else{
			return array('status'=>'0','msg'=>'failed','log_data'=>'0');
		}

	}

	 


}