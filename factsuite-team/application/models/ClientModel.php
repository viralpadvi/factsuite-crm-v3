<?php
/**
 * 
 */
class ClientModel extends CI_Model
{
	
	function get_client_details($client_id=''){ 
		$result ='';
		if ($client_id !='') { 
			$result = $this->db->where('client_id',$client_id)->select('tbl_client.*, team_employee.first_name, team_employee.last_name,industry.*')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->join('industry','tbl_client.client_industry = industry.industry_id','left')->get()->row_array();
		}else{ 
			if ($this->session->userdata('logged-in-csm')) {
				$csm = $this->session->userdata('logged-in-csm'); 
				$q =" (tbl_client.account_manager_name =".$csm['team_id']." AND date(tbl_client.client_created_date) <='2022-12-29') OR tbl_client.account_created_by =".$csm['team_id'];

				$this->db->where($q);
			}
			// $result = $this->db->order_by('tbl_client.client_id','DESC')->where('active_status',1)->select('tbl_client.*, team_employee.first_name, team_employee.last_name,industry.*')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->join('industry','tbl_client.client_industry = industry.industry_id','left')->get()->result_array();
			$result = $this->db->order_by('tbl_client.client_id','DESC')->where('active_status',1)->select('tbl_client.*,tbl_clientspocdetails.*, team_employee.first_name, team_employee.last_name,industry.*')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->join('industry','tbl_client.client_industry = industry.industry_id','left')->join('tbl_clientspocdetails','tbl_client.client_id = tbl_clientspocdetails.client_id','left')->group_by('tbl_client.client_id','DESC')->get()->result_array();
		}
		return $result;
	}

	function get_single_client_cost_centers($client_id = '') {
		if ($client_id == '') { 
			$client_id = $this->input->post('client_id');
		}
		$where_condition = array(
			'client_id' => $client_id
		);
		return $this->db->where($where_condition)->get('autocomplete_location')->result_array();
	}

	function get_single_candidate_details($candidate_id){
		$this->db->where('md5(candidate.candidate_id)', $candidate_id);
		$this->db->limit(1);
		$this->db->select("candidate.*,tbl_client.client_name,tbl_client.tv_or_ebgv")->from('candidate');
		$this->db->join('tbl_client','candidate.client_id = tbl_client.client_id');
	    $query = $this->db->get()->row_array();

	    $sign = $this->db->where('md5(candidate_id)',$candidate_id)->order_by('signature_id','DESC')->get('signature')->row_array();

	    return array('candidate'=>$query,'sign'=>$sign);

	}

	function get_all_clients() {
		return $this->db->get('tbl_client')->result_array();	
	}

	function get_client_spoc_list() {
		$where_condition = array(
			'client_id' => $this->input->post('client_id')
		);
		return $this->db->where($where_condition)->get('tbl_clientspocdetails')->result_array();
	}

	function send_credentials_to_client_spoc() {
		$get_client_spoc_details = $this->db->join('tbl_client AS T2', 'T1.client_id = T2.client_id')->where_in('spoc_id',explode(',', $this->input->post('spoc_id')))->get('tbl_clientspocdetails AS T1')->result_array();
		// print_r($get_client_spoc_details);
		// exit();
		// Send To User Starts
		$client_email_subject = 'Login Credentials - Factsuite CRM';

		$client_email_message = '';
		$template = $this->db->where(array('template_type'=>'Client Registration','client_id'=>'0'))->get('email-templates')->row_array();

		foreach ($get_client_spoc_details as $key => $value) {
			$client_email_id = strtolower($value['spoc_email_id']);
			if ($template != '' && $template != null) {
				$client_email_message = str_replace("@client_name",$value['client_name'],$template['template_content']);
				$client_email_message = str_replace("@client_email_id",$client_email_id,$client_email_message);
				$client_email_message = str_replace("@link",$this->config->item('client_url'),$client_email_message);
				$client_email_message = str_replace("@otp_or_password",base64_decode($value['SPOC_Password']),$client_email_message); 
			} else {
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
				$client_email_message .= '<p>Dear '.$value['client_name'].',</p>';
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
				$client_email_message .= '<td>'.base64_decode($value['SPOC_Password']).'</td>';
				$client_email_message .= '<tr>';
				$client_email_message .= '</table>';
				$client_email_message .= '<p><b>Yours sincerely,<br>';
				$client_email_message .= 'Team FactSuite</b></p>';
				$client_email_message .= '</body>';
				$client_email_message .= '</html>';
			}
			$send_email_to_user = $this->emailModel->send_mail($client_email_id,$client_email_subject,$client_email_message);
		}

		if ($send_email_to_user) {
			return array('status'=>'1','msg'=>'success');
		} else {
			return array('status'=>'0','msg'=>'failed');
		}
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
			$document_download_by_client = $this->input->post('document_download_by_client') == 1 ? 1 : 0;
			$notification_to_candidate = $this->input->post('notification_to_candidate') == 1 ? 1 : 0;

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
				/*'location'=>$this->input->post('location'),
				'client_segment'=>$this->input->post('segment'),*/
				'upload_doc_name'=>implode(',', $img), 
				'client_access'=>$document_download_by_client,
				'candiate_notification_status'=>$notification_to_candidate,
				'iverify_or_pv_status' => $this->input->post('iverify_or_pv_type'),
				'tv_or_ebgv' => $this->input->post('tv_or_ebgv'), 
				'signature' => $this->input->post('signature'), 
				
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
			if ($this->session->userdata('logged-in-csm')) {
				$csm = $this->session->userdata('logged-in-csm');  
				$client_data['account_created_by'] = $csm['team_id'];
				$client_data['active_status'] = 0;
			}else{
				$client_data['account_created_by'] = 1;
			}
			if ($this->input->post('is_master')) {
				$client_data['is_master'] = 0;
			} else if ($this->input->post('master_account')) { 
				$client_data['is_master'] =$this->input->post('master_account');
			} else {
				$client_data['is_master'] = 0;
			}

			if ($this->input->post('insuff_client_notification') == 1) {
				$client_data['notification_to_client_for_insuff_status'] = 1;
				if ($this->input->post('insuff_client_notification_to_client_checked_types') != '') {
					$client_data['notification_to_client_for_insuff_types'] = $this->input->post('insuff_client_notification_to_client_checked_types');
				} else {
					$client_data['notification_to_client_for_insuff_status'] = 0;
				}
			}

			if ($this->input->post('client_clarification_client_notification') == 1) {
				$client_data['notification_to_client_for_client_clarification_status'] = 1;
				if ($this->input->post('client_clarification_client_notification_to_client_checked_types') != '') {
					$client_data['notification_to_client_for_client_clarification_types'] = $this->input->post('client_clarification_client_notification_to_client_checked_types');
				} else {
					$client_data['notification_to_client_for_client_clarification_status'] = 0;
				}
			}

			if ($this->db->insert('tbl_client',$client_data)) {
				$spoc = array();
				$insert_id = $this->db->insert_id();
				$name = json_decode($this->input->post('spo_name'),true);
				$spo_contact = explode(',', $this->input->post('spo_contact'));
				$spoc_id = explode(',', $this->input->post('spo_id'));
				$password = '';
				foreach (json_decode($this->input->post('spo_email'),true) as $key => $value) { 
					$password = random_string('alnum', 8);
					$row['client_id'] = $insert_id;
					$row['spoc_name'] = $name[$key]['name'];
					$row['spoc_phone_no'] = $spo_contact[$key];
					$row['spoc_email_id'] = $value['email'];
					$row['SPOC_Password'] = base64_encode($password);
					if ($this->session->userdata('logged-in-csm')) {
						$client_data['spoc_status'] = 0;
					}
					array_push($spoc, $row);
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
				'iverify_or_pv_status' => $this->input->post('iverify_or_pv_type'),
				'tv_or_ebgv' => $this->input->post('tv_or_ebgv'), 
				'signature' => $this->input->post('signature'), 
				'active_status'=>1,
			);
			if ($this->session->userdata('logged-in-csm')) {
				$csm = $this->session->userdata('logged-in-csm');  
				$client_log_data['account_created_by'] = $csm['team_id'];
				$this->create_approval_for_client($insert_id);
 
			}else{
				$client_log_data['account_created_by'] = 1;
			}

			$this->db->insert('tbl_client_log',$client_log_data);
				return array('status'=>'1','msg'=>'success','client_id' => $insert_id );
			}else{
				return array('status'=>'0','msg'=>'failed');
			} 		 
	}


    function create_approval_for_client($insert_id){

        $csm = $this->session->userdata('logged-in-csm');
        $master = 'child';
         	if ($this->input->post('master_account') =='0') {
         		 $master = 'master';
         	}
            $client_data = array(
                'number_of_list'=>1,
                'role_of_approval'=>'client',

                'link_account'=>$insert_id,
 
                'remarks'=>$this->input->post('description'),
                'type_of_action'=>0, 
                'account_type'=>$master, 
                'additional_remarks'=>$this->input->post('additional_remarks'),
                'user_name'=>$this->input->post('client_name'),
                'crated_by_request'=>$csm['team_id'],
                'created_by_role'=>$csm['role'],
            );
              $team = $this->Approval_Mechanisms_Model->assign_new_approval(1,1);
            if ($team['status'] !='0') {
                $client_data['level_one_id'] = $team['team_id'];
                $client_data['level_one_role'] = $team['role'];
                $client_data['level_one_notification'] = 1;

            } 
                $team['remarks'] = $this->input->post('description');
                $team['team_name'] = $csm['first_name'];
                $team['client_name'] = $this->input->post('client_name');
                
                $this->Approval_Mechanisms_Model->send_client_add_remove_client($team);
            if ($this->db->insert('approval_mechanism',$client_data)) {
                return array('status'=>'1','msg'=>'success');
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
			$document_download_by_client = $this->input->post('document_download_by_client') == 1 ? 1 : 0;
			$notification_to_candidate = $this->input->post('notification_to_candidate') == 1 ? 1 : 0;
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
				/*'location'=>$this->input->post('location'),
				'client_segment'=>$this->input->post('segment'),*/
				'client_access'=>$document_download_by_client,
				'candiate_notification_status'=>$notification_to_candidate,
				'iverify_or_pv_status' => $this->input->post('iverify_or_pv_type'),
				'tv_or_ebgv' => $this->input->post('tv_or_ebgv'),
				'signature' => $this->input->post('signature'),  
				/*'component_id'=>$this->input->post('component_name'),
				'component_price'=>json_encode($package),
				'component_client_price'=>$this->input->post('component_price'),*/
			);
			if ($this->input->post('is_master')) {
				$client_data['is_master'] = 0;
			} else if ($this->input->post('master_account')) { 
				$client_data['is_master'] =$this->input->post('master_account');
			} else {
				$client_data['is_master'] = 0;
			}

			$client_data['notification_to_client_for_insuff_status'] = 0;
			$client_data['notification_to_client_for_insuff_types'] = null;
			if ($this->input->post('insuff_client_notification') == 1) {
				if ($this->input->post('insuff_client_notification_to_client_checked_types') != '') {
					$client_data['notification_to_client_for_insuff_status'] = 1;
					$client_data['notification_to_client_for_insuff_types'] = $this->input->post('insuff_client_notification_to_client_checked_types');
				}
			}

			$client_data['notification_to_client_for_client_clarification_status'] = 0;
			$client_data['notification_to_client_for_client_clarification_types'] = null;
			if ($this->input->post('client_clarification_client_notification') == 1) {
				if ($this->input->post('client_clarification_client_notification_to_client_checked_types') != '') {
					$client_data['notification_to_client_for_client_clarification_status'] = 1;
					$client_data['notification_to_client_for_client_clarification_types'] = $this->input->post('client_clarification_client_notification_to_client_checked_types');
				}
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
				$name = json_decode($this->input->post('spo_name'),true);
				$spo_contact = explode(',', $this->input->post('spo_contact'));
				foreach (json_decode($this->input->post('spo_email'),true) as $key => $value) { 
					if (isset($spoc_id[$key])) {
					$row['spoc_id'] = $spoc_id[$key];
					$row['client_id'] = $insert_id;
					$row['spoc_name'] = $name[$key]['name'];
					$row['spoc_phone_no'] = $spo_contact[$key];
					$row['spoc_email_id'] = $value['email'];
					// $row['SPOC_Password'] = $password[$key];//base64_encode(random_string('alnum', 8));
					array_push($spoc, $row); 
					}else{
					// $row['spoc_id'] = $spoc_id[$key];
					$row1['client_id'] = $insert_id;
					$row1['spoc_name'] = $name[$key]['name'];
					$row1['spoc_phone_no'] = $spo_contact[$key];
					$row1['spoc_email_id'] = $value['email'];
					$row1['SPOC_Password'] = $password[$key];//base64_encode(random_string('alnum', 8));
					array_push($spoc_insert, $row1);  


					$client_email_id = strtolower($value['email']);
				// Send To User Starts
				$client_email_subject = 'Credentials';
				$templates = $this->db->where('client_id',0)->where('template_type','Client Registration')->get('email-templates')->row_array();
				$client_email_message ='';
				if (isset($templates['template_content'])) { 
					$need_replace = ["@client_name", "@link", "@client_email_id", "@otp_or_password"];
					$replace_strings   = [$this->input->post('client_name'), $this->config->item('client_url'), $client_email_id,$password[$key] ];

					$template_content =  str_replace($need_replace, $replace_strings, $templates['template_content']);
					
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
				$client_email_message .= '<td>'.base64_decode($password[$key]).'</td>';//http://localhost:8080/factsuitecrm/
				$client_email_message .= '<tr>';
				$client_email_message .= '</table>';
				$client_email_message .= '<p><b>Yours sincerely,<br>';
				$client_email_message .= 'Team FactSuite</b></p>';
				$client_email_message .= '</body>';
				$client_email_message .= '</html>';
			}

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
				'iverify_or_pv_status' => $this->input->post('iverify_or_pv_type'),
				'tv_or_ebgv' => $this->input->post('tv_or_ebgv'), 
				'signature' => $this->input->post('signature'), 
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

	function change_client_access_status(){
		$userdata = array(
			'client_access'=>$this->input->post('changed_status')
		);

		if ($this->db->where('client_id',$this->input->post('id'))->update('tbl_client',$userdata)) {
			
			$log_data = $this->db->where('client_id',$this->input->post('id'))->get('tbl_client')->row_array();
			
			$status_log = '3';
			if ($this->input->post('changed_status') == 0) {
				$status_log = '4';
			}

			$admin_info = $this->session->userdata('logged-in-admin');
			 
			return array('status'=>'1','message'=>'Status updated successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while updating the status.');
		}
	}

	function change_candidate_notification_status() {
		// var_dump($_POST);
		$userdata = array(
			'candiate_notification_status' => $this->input->post('changed_status')
		);

		if ($this->db->where('client_id',$this->input->post('id'))->update('tbl_client',$userdata)) {
			$log_data = $this->db->where('client_id',$this->input->post('id'))->get('tbl_client')->row_array();
			$admin_info = $this->session->userdata('logged-in-admin');
			
			$client_data = array( 
				'client_id' => $this->input->post('id'),
				'client_name' => $log_data['client_name'],
				'client_address' => $log_data['client_address'],
				'client_city' => $log_data['client_city'],
				'client_zip' => $log_data['client_zip'],
				'client_state' => $log_data['client_state'],
				'client_country' => $log_data['client_country'],
				'client_industry' => $log_data['client_industry'],
				'other_industry' => $log_data['other_industry'],
				'gst_number' => $log_data['gst_number'],
				'website' => $log_data['website'],
				'is_master' => $log_data['is_master'],
				'account_manager_name' => $log_data['account_manager_name'],
				'account_manager_email_id' => $log_data['account_manager_email_id'],
				'account_contact_no' => $log_data['account_contact_no'],
				'spo_details' => $log_data['spo_details'],
				'first_name_test' => $log_data['first_name_test'],
				'last_name_test' => $log_data['last_name_test'],
				'poc_contact_number' => $log_data['poc_contact_number'],
				'poc_user_email' => $log_data['poc_user_email'],
				'poc_user_name' => $log_data['poc_user_name'],
				'user_password' => $log_data['user_password'],
				'upload_doc_name' => $log_data['upload_doc_name'],
				'communications' => $log_data['communications'],
				'packages' => $log_data['packages'],
				'component_id' => $log_data['component_id'],
				'component_price' => $log_data['component_price'],
				'component_client_price' => $log_data['component_client_price'],
				'package_components' => $log_data['package_components'],
				'alacarte_components' => $log_data['alacarte_components'],
				'active_status' => $log_data['active_status'],
				'high_priority_days' => $log_data['high_priority_days'],
				'high_priority_percentage' => $log_data['high_priority_percentage'],
				'medium_priority_days' => $log_data['medium_priority_days'],
				'medium_priority_percentage' => $log_data['medium_priority_percentage'],
				'low_priority_days' => $log_data['low_priority_days'],
				'low_priority_percentage' => $log_data['low_priority_percentage'],
				'tat_updated_date' => $log_data['tat_updated_date'],
				'client_type' => $log_data['client_type'],
				'access_token' => $log_data['access_token'],
				'is_address_added' => $log_data['is_address_added'],
				'client_status' => $log_data['client_status'],
				'purchase_status' => $log_data['purchase_status'],
				'candiate_notification_status' => $this->input->post('changed_status')
			);
			return array('status'=>'1','message'=>'Status updated successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while updating the status.');
		}
	}

	function insert_update_client($img){
		// SELECT `logo_id`, `client_id`, `fs_logo`, `consent`, `additional`, `aad_on_suggestion`, `created_date` FROM `custom_logo` WHERE 1
		$custom = $this->db->where('client_id',$this->input->post('client_id'))->get('custom_logo')->row_array();
		$additional_status = $this->input->post('additional_status');
		if ($additional_status == '1') {
			$additional_status = 1;
		}else{
			$additional_status = 0;
		}

		$client_data = array(
			'location'=>$this->input->post('location'),
			'client_segment'=>$this->input->post('segment') 
		);
		$this->db->where('client_id',$this->input->post('client_id'))->update('tbl_client',$client_data);
		$user_data = array(
			'client_id'=>$this->input->post('client_id'),
			'consent'=>$this->input->post('consent'),
			'aad_on_suggestion'=>$this->input->post('additional'),
			'additional'=>$additional_status
		);
		if (!in_array('no-file',$img) && $img !=null) {
			$user_data['fs_logo'] = implode(',', $img);
		}


		$result = '';
		if (isset($custom['logo_id'])) {
			$result = $this->db->where('client_id',$this->input->post('client_id'))->update('custom_logo',$user_data);
		}else{
			$result = $this->db->insert('custom_logo',$user_data);
		}

		if ($result) {
			return array('status'=>'1','message'=>'Updated successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while updating.'); 
		}
	}

	function get_consent_logo(){
		return $this->db->where('client_id',$this->input->post('client_id'))->get('custom_logo')->row_array();
	}

	function get_templates(){
		return $this->db->where('client_id',$this->input->post('client_id'))->where('template_type',$this->input->post('templates'))->get('email-templates')->row_array();
	}

	function add_templates() { 
		$custom = $this->db->where('client_id',$this->input->post('client_id'))->where('template_type',$this->input->post('templates'))->get('email-templates')->row_array();
		$additional_status = $this->input->post('additional_status');
		if ($additional_status == '1') {
			$additional_status = 1;
		}else{
			$additional_status = 0;
		}

		$user_data = array(
			'client_id'=>$this->input->post('client_id'),
			'template_type'=>$this->input->post('templates'),
			'template_content'=>$this->input->post('form')
		); 

		$result = '';
		if (isset($custom['template_id'])) {
			$result = $this->db->where('template_id',$custom['template_id'])->update('email-templates',$user_data);
		} else {
			$result = $this->db->insert('email-templates',$user_data);
		}

		if ($result) {
			return array('status'=>'1','message'=>'Updated successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while updating.'); 
		}
	}

	function add_email_template_for_insuff_email_to_client() {
		$where_condition = array(
			'client_status' => 1,
			'notification_to_client_for_insuff_status' => 1,
			'notification_to_client_for_insuff_types REGEXP' => 2
		);
		if ($this->input->post('client_id') != 0 && $this->input->post('client_id') != '') {
			$where_condition['client_id'] = $this->input->post('client_id');
		}

		$client_list = $this->db->where($where_condition)->get('tbl_client')->result_array();
		if (count($client_list) > 0) {
			$success_count = 0;
			$error_count = 0;
			foreach ($client_list as $key => $value) {
				$custom = $this->db->where('client_id',$value['client_id'])->get('insuff_email_to_client_template')->row_array();

				$user_data = $log_data = array(
					'client_id' => $value['client_id'],
					'template' => $this->input->post('form')
				); 

				$result = '';
				if ($custom != '') {
					$log_data['template_satus'] = 2;
					$result = $this->db->where('client_id',$value['client_id'])->update('insuff_email_to_client_template',$user_data);
				} else {
					$log_data['template_satus'] = 1;
					$result = $this->db->insert('insuff_email_to_client_template',$user_data);
				}
				if ($result) {
					$admin = $this->session->userdata('logged-in-admin');
					$log_data['created_or_updated_by_role'] = 'admin';
					$log_data['created_or_updated_by_role_id'] = $admin['team_id'];
					$this->db->insert('insuff_email_to_client_template_log',$log_data);
					$success_count++;
				} else {
					$error_count++;
				}
			}
			return array('status'=>'1','message'=>'Updated successfully.','success_count'=>$success_count,'error_count'=>$error_count);
		} else {
			return array('status'=>'0','message'=>'No Clients available at this moment'); 
		}
	}

	function add_email_template_for_client_clarification_email_to_client() {
		$where_condition = array(
			'client_status' => 1,
			'notification_to_client_for_client_clarification_status' => 1,
			'notification_to_client_for_client_clarification_types REGEXP' => 2
		);
		if ($this->input->post('client_id') != 0 && $this->input->post('client_id') != '') {
			$where_condition['client_id'] = $this->input->post('client_id');
		}

		$client_list = $this->db->where($where_condition)->get('tbl_client')->result_array();
		if (count($client_list) > 0) {
			$success_count = 0;
			$error_count = 0;
			foreach ($client_list as $key => $value) {
				$custom = $this->db->where('client_id',$value['client_id'])->get('client_clarification_email_to_client_template')->row_array();

				$user_data = $log_data = array(
					'client_id' => $value['client_id'],
					'template' => $this->input->post('form')
				); 

				$result = '';
				if ($custom != '') {
					$log_data['template_satus'] = 2;
					$result = $this->db->where('client_id',$value['client_id'])->update('client_clarification_email_to_client_template',$user_data);
				} else {
					$log_data['template_satus'] = 1;
					$result = $this->db->insert('client_clarification_email_to_client_template',$user_data);
				}
				if ($result) {
					$admin = $this->session->userdata('logged-in-admin');
					$log_data['created_or_updated_by_role'] = 'admin';
					$log_data['created_or_updated_by_role_id'] = $admin['team_id'];
					$this->db->insert('client_clarification_email_to_client_template_log',$log_data);
					$success_count++;
				} else {
					$error_count++;
				}
			}
			return array('status'=>'1','message'=>'Updated successfully.','success_count'=>$success_count,'error_count'=>$error_count);
		} else {
			return array('status'=>'0','message'=>'No Clients available at this moment'); 
		}
	}

	function get_selected_insuff_email_template_for_client() {
		$client_template = $this->db->where('client_id',$this->input->post('client_id'))->get('insuff_email_to_client_template')->row_array();
		return array('status'=>'0','client_template'=>$client_template); 
	}

	function get_url_branding(){
		return $this->db->where('client_id',$this->input->post('client_id'))->where('url_type',$this->input->post('templates'))->get('url-branding')->row_array();
	}

	function add_url_branding(){ 
		$custom = $this->db->where('client_id',$this->input->post('client_id'))->where('url_type',$this->input->post('templates'))->get('url-branding')->row_array();
		 
		$user_data = array(
			'client_id'=>$this->input->post('client_id'),
			'url_type'=>$this->input->post('templates'),
			'url'=>$this->input->post('url')
		); 

		$result = '';
		if (isset($custom['url_id'])) {
			$result = $this->db->where('url_id',$custom['url_id'])->update('url-branding',$user_data);
		}else{
			$result = $this->db->insert('url-branding',$user_data);
		}

		if ($result) {
			return array('status'=>'1','message'=>'Updated successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while updating.'); 
		}
	}

	function add_new_client_notification_rule() {
		$add_data = array(
			'client_type' => $this->input->post('client_type'),
			'client_id' => $this->input->post('client_name'),
			'case_type' => $this->input->post('case_type'),
			'notification_time' => $this->input->post('all_time'),
			'notification_name' => $this->input->post('notification_name'),
			'notification_email_subject' => $this->input->post('email_subject'),
			'notification_email_description' => $this->input->post('email_description'),
			'rule_criteria' => $this->input->post('rule_cirteria')
		);

		$criteria_rules = [];
		if ($this->input->post('rule_cirteria') == 1) {
			$criteria_rules = array(
				'remaining_days_type' => $this->input->post('remaining_days_type'),
				'remaining_days_value' => $this->input->post('remaining_days_value')
			);
		} else if($this->input->post('rule_cirteria') == 2) {
			$criteria_rules = array(
				'priority_type' => $this->input->post('priority_type')
			);
		}

		$add_data['rule_criteria_rules'] = json_encode($criteria_rules);

		if ($this->db->insert('client_case_automated_email_notification',$add_data)) {
			$admin_info = $this->session->userdata('logged-in-admin');

			$log_data = array(
				'client_case_automated_email_notification_id' => $this->db->insert_id(),
				'client_type' => $this->input->post('client_type'),
				'client_id' => $this->input->post('client_name'),
				'case_type' => $this->input->post('case_type'),
				'notification_time' => $this->input->post('all_time'),
				'rule_criteria' => $this->input->post('rule_cirteria'),
				'rule_criteria_rules' => json_encode($criteria_rules),
				'notification_name' => $this->input->post('notification_name'),
				'notification_email_subject' => $this->input->post('email_subject'),
				'notification_email_description' => $this->input->post('email_description'),
				'notification_updated_by_admin_id' => $admin_info['team_id']
			);
			$this->db->insert('client_case_automated_email_notifications_log',$log_data);

			return array('status'=>'1','message'=>'Client notification has been added successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while adding the client notification. Please try again');
		}
	}

	function get_all_client_notification_rules() {
		return $this->db->order_by('client_case_automated_email_notification_id','DESC')->get('client_case_automated_email_notification')->result_array();
	}

	function change_client_notification_status() {
		$where_condition = array(
				'client_case_automated_email_notification_id' => $this->input->post('id')
			);

			$userdata = array(
				'notification_status' => $this->input->post('changed_status')
			);

			if ($this->db->where($where_condition)->update('client_case_automated_email_notification',$userdata)) {
				$log_data = $this->db->where($where_condition)->get('client_case_automated_email_notification')->row_array();
				
				$status_log = '3';
				if ($this->input->post('changed_status') == 0) {
					$status_log = '4';
				}

				$admin_info = $this->session->userdata('logged-in-admin');
				$log_data_array = array(
					'client_case_automated_email_notification_id' => $this->input->post('id'),
					'client_type' => $log_data['client_type'],
					'client_id' => $log_data['client_id'],
					'case_type' => $log_data['case_type'],
					'notification_time' => $log_data['notification_time'],
					'rule_criteria' => $log_data['rule_criteria'],
					'rule_criteria_rules' => $log_data['rule_criteria_rules'],
					'notification_name' => $log_data['notification_name'],
					'notification_email_subject' => $log_data['notification_email_subject'],
					'notification_email_description' => $log_data['notification_email_description'],
					'notification_status' => $status_log,
					'notification_updated_by_admin_id' => $admin_info['team_id']
				);
				$this->db->insert('client_case_automated_email_notifications_log',$log_data_array);

				return array('status'=>'1','message'=>'Status updated successfully.');
			} else {
				return array('status'=>'0','message'=>'Something went wrong while updating the status.');
			}
	}

	function get_single_client_notification_rule_details() {
		$where_condition = array(
			'client_case_automated_email_notification_id' => $this->input->post('client_case_automated_email_notification_id')
		);

		return $this->db->where($where_condition)->get('client_case_automated_email_notification')->row_array();
	}

	function update_client_notification_rule() {
		$update_data = array(
			'client_type' => $this->input->post('client_type'),
			'client_id' => $this->input->post('client_name'),
			'case_type' => $this->input->post('case_type'),
			'notification_time' => $this->input->post('all_time'),
			'notification_name' => $this->input->post('notification_name'),
			'notification_email_subject' => $this->input->post('email_subject'),
			'notification_email_description' => $this->input->post('email_description'),
			'rule_criteria' => $this->input->post('rule_cirteria')
		);

		$criteria_rules = [];
		if ($this->input->post('rule_cirteria') == 1) {
			$criteria_rules = array(
				'remaining_days_type' => $this->input->post('remaining_days_type'),
				'remaining_days_value' => $this->input->post('remaining_days_value')
			);
		} else if($this->input->post('rule_cirteria') == 2) {
			$criteria_rules = array(
				'priority_type' => $this->input->post('priority_type')
			);
		}

		$update_data['rule_criteria_rules'] = json_encode($criteria_rules);

		if ($this->db->where('client_case_automated_email_notification_id',$this->input->post('client_case_automated_email_notification_id'))->update('client_case_automated_email_notification',$update_data)) {
			
			$admin_info = $this->session->userdata('logged-in-admin');
			$log_data = array(
				'client_case_automated_email_notification_id' => $this->input->post('client_case_automated_email_notification_id'),
				'client_type' => $this->input->post('client_type'),
				'client_id' => $this->input->post('client_name'),
				'case_type' => $this->input->post('case_type'),
				'notification_time' => $this->input->post('all_time'),
				'notification_name' => $this->input->post('notification_name'),
				'rule_criteria' => $this->input->post('rule_cirteria'),
				'rule_criteria_rules' => json_encode($criteria_rules),
				'notification_email_subject' => $this->input->post('email_subject'),
				'notification_email_description' => $this->input->post('email_description'),
				'notification_status' => 2,
				'notification_updated_by_admin_id' => $admin_info['team_id']
			);
			$this->db->insert('client_case_automated_email_notifications_log',$log_data);

			return array('status'=>'1','message'=>'Notification has been updated successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while updating the notification. Please try again');
		}
	}



	function add_nomanclature(){
		$nomanclature = array(
 			'client_id' =>$this->input->post('client_id'),
 			'all_report' =>$this->input->post('all_report'),
 			'green' =>$this->input->post('green'),
 			'red' =>$this->input->post('red'),
 			'orange' =>$this->input->post('orange'), 
 			'created_date' =>date('d-m-Y H:i'),
 			'updated_date' =>date('d-m-Y H:i')
 		); 
		if ($this->db->insert('client_nomanclature',$nomanclature)) {
			 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_nomanclature(){
		$nomanclature = array(
 			'client_id' =>$this->input->post('client_id'),
 			'all_report' =>$this->input->post('all_report'),
 			'green' =>$this->input->post('green'),
 			'red' =>$this->input->post('red'),
 			'orange' =>$this->input->post('orange'), 
 			'updated_date' =>date('d-m-Y H:i')
 		); 
		if ($this->db->where('nomenclature_id',$this->input->post('nomanclature_id'))->update('client_nomanclature',$nomanclature)) {
			 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function get_nomanclature_details(){
		if ($this->input->post('nomenclature_id')) {
			$this->db->where('client_nomanclature.nomenclature_id',$this->input->post('nomenclature_id'));
		}
		return $this->db->select("client_nomanclature.*,tbl_client.client_name")->join('tbl_client','client_nomanclature.client_id = tbl_client.client_id')->get('client_nomanclature')->result_array();
	}

	function remove_nomanclature($nomenclature_id){
 		$this->db->where('nomenclature_id',$nomenclature_id);
 		
		if ($this->db->delete('client_nomanclature')) {
			 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


	function insert_location(){
		$location = array(
 			'location_name' =>$this->input->post('location'),
 			'client_id' =>$this->input->post('client_id'),
 		); 
		if ($this->db->insert('autocomplete_location',$location)) {
			 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function insert_segment(){
		$segment = array(
 			'segment_name' =>$this->input->post('segment'),
 			'client_id' =>$this->input->post('client_id'),
 		); 
		if ($this->db->insert('autocomplete_segment',$segment)) {
			 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}
// SELECT `schedule_id`, `candidate_id`, `schedule_days`, `schedule_date`, `schedule_time`, `schedule_sms`, `schedule_email`, `schedule_ivrs`, `schedule_status`, `created_date` FROM `schedule-sms-email-ivrs` WHERE 1
	function add_schedule_candidate_sms_email(){
		$schedule = array(
			'candidate_id'=>$this->input->post('candidate_id'),
			'title'=>$this->input->post('title'),
			'schedule_days'=>$this->input->post('schedule_days'),
			'schedule_date'=>$this->input->post('schedule_date'),
			'schedule_time'=>$this->input->post('schedule_time'),
			'schedule_sms'=>$this->input->post('schedule_sms'),
			'schedule_email'=>$this->input->post('schedule_email'),
			'schedule_ivrs'=>$this->input->post('schedule_ivrs'), 
		);
		$result = '';
		if ($this->input->post('schedule_id')) {
			$this->db->where('schedule_id',$this->input->post('schedule_id'))->update('schedule-sms-email-ivrs',$schedule);
		}else{
			$this->db->insert('schedule-sms-email-ivrs',$schedule);
		}

		if ($result) {
				 
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'1','msg'=>'success');
		}
	}

	function get_all_schedule_data(){
		if ($this->input->post('id')) {
			$this->db->where('schedule_id',$this->input->post('id'));
		}
		$q = $this->db->order_by('schedule_id','DESC')->get('schedule-sms-email-ivrs');

		if ($this->input->post('id')) {
			return $q->row_array();
		}
		return $q->result_array();
	}


	function remove_schedule_link(){
		if ($this->input->post('id')) {
			$this->db->where('schedule_id',$this->input->post('id'));
		if ($this->db->delete('schedule-sms-email-ivrs')) {
			return array('status'=>'1','msg'=>'success');
		}
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


	/*New finance dash*/



	function get_all_clients_purchased_service_package_count() {
		$where_condition = array(
			'client_status' => 1
		);

		 $where = '';
        if ($this->input->post('total_sales_time') == 'today') {
            $where = "  date(client_created_date) = CURDATE()";
        } else if($this->input->post('total_sales_time') == 'this_week') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('total_sales_time') == 'this_month') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('total_sales_time') == 'this_year') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('total_sales_time') == 'between') {
            $where = "  date(client_created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }

         if ($where !='' && $where !=null) {
        	$this->db->where($where);
        } 

		$package_id_list = [];
		$this->db->where($where_condition);
 
		$package_details = $this->db->get('tbl_client')->result_array();
			$return_sum = array();
			 
		foreach ($package_details as $key => $value) { 
			$main_sum = array();
			$comp_onent = isset($value['package_components'])?$value['package_components']:'';
                $package_component = json_decode($comp_onent,true);
			  if ($comp_onent !='' && $comp_onent !=null && $comp_onent !='[]') {
			   
			foreach ($package_component as $key => $val) { 
				 
				if ($val['type_of_price'] == 0) { 
					foreach ($val['form_data'] as $key => $price) {
						array_push($main_sum,$price['form_value']);
					} 
				}else{
					array_push($main_sum,$val['component_standard_price']);
				}
			}
			}

			$total_value = array_sum($main_sum);
			array_push($return_sum,$total_value);
			 
		}
		 
 		return array_sum($return_sum);
	}

	function get_all_clients_purchased_service_package_count_avg() {
		$where_condition = array(
			'client_status' => 1
		);

		 $where = '';
        if ($this->input->post('avg_order_value_time') == 'today') {
            $where = "  date(client_created_date) = CURDATE()";
        } else if($this->input->post('avg_order_value_time') == 'this_week') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('avg_order_value_time') == 'this_month') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('avg_order_value_time') == 'this_year') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('avg_order_value_time') == 'between') {
            $where = "  date(client_created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }

         if ($where !='' && $where !=null) {
        	$this->db->where($where);
        } 

		$package_id_list = [];
		$this->db->where($where_condition);
 
		$package_details = $this->db->get('tbl_client')->result_array();
			$return_sum = array();
		foreach ($package_details as $key => $value) { 
			$main_sum = array();
			$comp_onent = isset($value['package_components'])?$value['package_components']:'';
                $package_component = json_decode($comp_onent,true);
			  if ($comp_onent !='' && $comp_onent !=null && $comp_onent !='[]') {
			   
			foreach ($package_component as $key => $val) { 
				 
				if ($val['type_of_price'] == 0) { 
					foreach ($val['form_data'] as $key => $price) {
						array_push($main_sum,$price['form_value']);
					} 
				}else{
					array_push($main_sum,$val['component_standard_price']);
				}
			}
			}

			$total_value = array_sum($main_sum);
			array_push($return_sum,$total_value);
			 
		}
		 
 		return round(array_sum($return_sum)/count($package_details),2);
	}


	function get_total_no_of_orders(){
		 $where = '';
        if ($this->input->post('no_of_orders_time') == 'today') {
            $where = "  date(client_created_date) = CURDATE()";
        } else if($this->input->post('no_of_orders_time') == 'this_week') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('no_of_orders_time') == 'this_month') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('no_of_orders_time') == 'this_year') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('no_of_orders_time') == 'between') {
            $where = "  date(client_created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }

        if ($where !='' && $where !=null) {
        	$this->db->where($where);
        }
		$package_details = $this->db->where('client_status',1)->get('tbl_client')->num_rows();

		return $package_details;
	}

	function get_total_order_returns(){
		 $where = '';
        if ($this->input->post('total_returns_time') == 'today') {
            $where = "  date(client_created_date) = CURDATE()";
        } else if($this->input->post('total_returns_time') == 'this_week') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('total_returns_time') == 'this_month') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('total_returns_time') == 'this_year') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('total_returns_time') == 'between') {
            $where = "  date(client_created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }

        if ($where !='' && $where !=null) {
        	$this->db->where($where);
        }
		$package_details = $this->db->where('client_status',0)->get('tbl_client')->num_rows();

		return $package_details;
	}


	function get_sales_by_item_count(){

		$where = '';
        if ($this->input->post('sales_by_item_select_time') == 'today') {
            $where = "  date(client_created_date) = CURDATE()";
        } else if($this->input->post('sales_by_item_select_time') == 'this_week') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('sales_by_item_select_time') == 'this_month') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('sales_by_item_select_time') == 'this_year') {
            $where = "  date(client_created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('sales_by_item_select_time') == 'between') {
            $where = "  date(client_created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }

        if ($where !='' && $where !=null) {
        	$this->db->where($where);
        }

		if ($this->input->post('client_id') !='all') {
			$this->db->where('client_id',$this->input->post('client_id'));
		}
		$package_details = $this->db->where('client_status',1)->get('tbl_client')->num_rows();

		return $package_details;
	}

	function get_top_selling_items(){
		$this->load->model('load_Database_Model');
		$crm = $this->load_Database_Model->load_database();

		$limit = 5;
		if ($this->input->post('client_id') !='all') {
			// $this->db->where('user_id',$this->input->post('client_id'));
		}
		// $limit = $this->input->post('top_selling_items_select');
		 // $this->db->where('package_cart_status',0);
		 // $this->db->order_by('user_id','DESC')->limit($limit);
		// $package_details = $this->db->query("SELECT T2.client_name as client_name,count(T1.user_id) AS user_id FROM `". $this->config->item('factsuite_website_db')."`.`package_cart` AS `T1` LEFT JOIN `".$this->config->item('factsuite_crm_db')."`.`tbl_client` AS `T2` ON T1.user_id = T2.client_id GROUP BY T1.user_id")->result_array();

		 $package_details = $crm->where('package_cart_status',0)->get('package_cart')->result_array();
		 $candidate_data = array();
		 if (count($package_details) > 0) {
		 	foreach ($package_details as $key => $value) {
		 		$val = json_decode($value['package_cart_details'],true);
		 		if (!array_key_exists($val['package_id'], $candidate_data)) {
                     $candidate_data[$val['package_id']] = array( 
                    'service_id' => $val['service_id'], 
                    'service_name' => $val['service_name'], 
                    'package_name' => $val['package_name'], 
                    'package_id' => $val['package_id'], 
                    'total' => 1, 
                    );
                    }else{
                    $candidate_data[$val['package_id']]['total'] = $candidate_data[$val['package_id']]['total']+ 1; 
                    }
		 	}
		 }
		 $candidate_data1 = array();
		 if (count($candidate_data) > 0) {
		 	foreach ($candidate_data as $key => $val) {
		 		if (!array_key_exists($val['service_id'], $candidate_data1)) {
                     $candidate_data1[$val['service_id']] = array( 
                    'service_id' => $val['service_id'], 
                    'service_name' => $val['service_name'], 
                    'package_name' => array($val['package_name']), 
                    'package_id' => $val['package_id'], 
                    'total' => array($val['total']), 
                    'marge' => array(
                    	'package_name' => $val['package_name'],
                    	'package_id' => $val['package_id'], 
                    	'total' => $val['total']
                		)
                    );
                    }else{
                    $candidate_data1[$val['service_id']]['marge'] = array_merge($candidate_data1[$val['service_id']]['marge'],array(
                    	'package_name' => $val['package_name'],
                    	'package_id' => $val['package_id'], 
                    	'total' => $val['total']
                		)); 
                     $candidate_data1[$val['service_id']]['package_name'] = array_merge($candidate_data1[$val['service_id']]['package_name'],array($val['package_name'])); 
                      $candidate_data1[$val['service_id']]['total'] = array_merge($candidate_data1[$val['service_id']]['total'],array($val['total'])); 
                    }
		 	}
		 	} 
		 
		return $candidate_data1;
		return array();
	}



	function all_component_ageing_in_progress_analytics(){  
		/*$where = '';
		if ($this->input->post('manager') !='all') {
			$where = 'client_id = '.$this->input->post('manager').' AND ';
		}*/
		 $result = $this->db->query("SELECT * FROM candidate where candidate_details_added_from IN (0,1)")->result_array();
		 // $this->outPutQcModel->getSingleAssignedCaseDetails();
		 $groups = array(); 
		 foreach ($result as $key => $value) {
		 	 $status ='';
		 	// if ($this->input->post('candidate') == 'all') { 
		 	  $status = $this->outPutQcModel->getSingleAssignedCaseDetails($value['candidate_id']);
		 	// }else if($this->input->post('candidate') == $value['candidate_id']){
		 	// 	 $status = $this->outPutQcModel->getSingleAssignedCaseDetails($value['candidate_id']);
		 	// }
		 	 
		 	 foreach ($status as $k => $val) {

		 	 $array_key = str_replace(" ", "_", strtolower($val['component_name']));
		        	$analyst = isset($val['component_data']['analyst_status'])?$val['component_data']['analyst_status']:0;
 				$analyst_status = explode(',',$analyst);

 				 /*Verified clear - 2,4
			 Verified Discrepancy - 7
			 Unable to Verify - 3,6
			 Closed Insuff - 9
			 Stop check - 5*/
			  $in_progress = isset($groups[$array_key]['in_progress'])?$groups[$array_key]['in_progress']:0;
			 $insuff = isset($groups[$array_key]['insuff'])?$groups[$array_key]['insuff']:0;
			 $client_clarification = isset($groups[$array_key]['client_clarification'])?$groups[$array_key]['client_clarification']:0;
			 $new = isset($groups[$array_key]['new'])?$groups[$array_key]['new']:0;
			 $total_array = 0;

		        if (!array_key_exists($array_key, $groups)) {

				/*if(in_array('7', $analyst_status)){
				 
				}else if (array_intersect($analyst_status, ['3','6'])) {
				  
				}else if (in_array('5', $analyst_status)) {
					 	 
				}else*/ if (in_array('8', $analyst_status)) {
					$client_clarification = 1;
					$total_array = 1;
				}else if (in_array('9', $analyst_status)) {
					$insuff = 1;
					$total_array = 1;
				}else/* if (array_intersect($analyst_status, ['2','4'])) {
					  	 
				}else*/ if(in_array('1', $analyst_status)){
					$in_progress = 1;
					$total_array = 1;
				}else{
					 $new = 1;
					 $total_array = 1;
				}
		 	 	  $groups[$array_key] = array(
		                'component_id' => $val['component_id'], 
		                'component_name' => $val['component_name'], 
		                'in_progress' => $in_progress, 
		                'insuff' => $insuff, 
		                'client_clarification' => $client_clarification, 
		                'new' => $new, 
		                'total' =>$total_array, 
		                 
		            ); 

		 	 	}else{
 					 
		 	 	if (in_array('8', $analyst_status)) {
					$client_clarification = (int)$groups[$array_key]['client_clarification'] + 1;
					$total_array = 1;
				}else if (in_array('9', $analyst_status)) {
					$insuff = (int)$groups[$array_key]['insuff'] + 1;
					$total_array = 1;
				}else if(in_array('1', $analyst_status)){
					$in_progress = (int)$groups[$array_key]['in_progress'] + 1;
					$total_array = 1;
				}else{
					 $new = (int)$groups[$array_key]['new'] + 1;
					 $total_array = 1;
				}
				 $total_count = 0;
				$total_count =  (int)$groups[$array_key]['total'] + (int)$total_array;
		 	 	  $groups[$array_key] = array(
		                'component_id' => $val['component_id'], 
		                'component_name' => $val['component_name'], 
		                'in_progress' => $in_progress, 
		                'insuff' => $insuff, 
		                'client_clarification' => $client_clarification, 
		                'new' => $new, 
		                'total' => $total_count,   
		            );


 
		 	 	}
		 	 	
 				
		 	 }
		 }

		  return $groups;

	}


	public function get_products($limit, $offset, $search, $count)
	{
		$this->db->select('*');
		$this->db->from('candidate');
		if($search){
			$keyword = $search['keyword'];
			if($keyword){
				$this->db->where("first_name LIKE '%$keyword%'");
			}
		}
		if($count){
			return $this->db->count_all_results();
		}
		else {
			$this->db->limit($limit, $offset);
			$query = $this->db->get();
			
			if($query->num_rows() > 0) {
				return $query->result();
			}
		}
		
		return array();
	}

}





