<?function remarkForDocuemtCheck($aadhar,$pan,$client_docs){
		// echo json_encode($_POST);
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}

		$address = array();
		$city = array();
		$state = array();
		$pincode = array();
		$in_progress_remark = array();
		$verification_remarks = array();
		$insuff_remarks = array();
		$insuff_closer_remark = array();
		
		if ($this->input->post('aadhar_address')) {
			$address['aadhar_address'] = $this->input->post('aadhar_address');
			$city['aadhar_city'] = $this->input->post('aadhar_city');
			$state['aadhar_state'] = $this->input->post('aadhar_state');
			$pincode['aadhar_pincode'] = $this->input->post('aadhar_pincode');
			$in_progress_remark['aadhar_in_progress_remark'] = $this->input->post('aadhar_in_progress_remark');
			$verification_remarks['aadhar_verification_remarks'] = $this->input->post('aadhar_verification_remarks');
			$insuff_remarks['aadhar_insuff_remarks'] = $this->input->post('aadhar_insuff_remarks');
			$insuff_closer_remark['aadhar_insuff_closer_remark'] = $this->input->post('aadhar_insuff_closer_remark');
		}

		if ($this->input->post('pan_address')) {
			$address['pan_address'] = $this->input->post('pan_address');
			$city['pan_city'] = $this->input->post('pan_city');
			$state['pan_state'] = $this->input->post('pan_state');
			$pincode['pan_pincode'] = $this->input->post('pan_pincode');
			$in_progress_remark['pan_in_progress_remark'] = $this->input->post('pan_in_progress_remark');
			$verification_remarks['pan_verification_remarks'] = $this->input->post('pan_verification_remarks');
			$insuff_remarks['pan_insuff_remarks'] = $this->input->post('pan_insuff_remarks');
			$insuff_closer_remark['pan_insuff_closer_remark'] = $this->input->post('pan_insuff_closer_remark');
		}

		if ($this->input->post('address')){
			$address['address'] = $this->input->post('address');
			$city['city'] = $this->input->post('city');
			$state['state'] = $this->input->post('state');
			$pincode['pincode'] = $this->input->post('pincode');
			$in_progress_remark['in_progress_remark'] = $this->input->post('in_progress_remark');
			$verification_remarks['verification_remarks'] = $this->input->post('verification_remarks');
			$insuff_remarks['insuff_remarks'] = $this->input->post('insuff_remarks');
			$insuff_closer_remark['insuff_closer_remark'] = $this->input->post('insuff_closer_remark');
		}

		 
		$doc_data = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>json_encode($address),
			'remark_city'=>json_encode($city),
			'remark_state'=>json_encode($state),
			'remark_pin_code'=>json_encode($pincode),
			'in_progress_remarks'=>json_encode($in_progress_remark),
			'verification_remarks'=>json_encode($verification_remarks),
			'insuff_remarks'=>json_encode($insuff_remarks),
			'insuff_closure_remarks'=>json_encode($insuff_closer_remark),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status')
		);

		$doc = array();
		if (count($aadhar) > 0 && !in_array('no-file', $aadhar)) {
			$doc['aadhar'] = implode(',',$aadhar);
		}  

		if (count($pan) > 0 && !in_array('no-file', $pan)) {
			$doc['pan'] = implode(',',$pan);
		}  

		if (count($client_docs) > 0 && !in_array('no-file', $client_docs)) {
			$doc['passport'] = implode(',',$client_docs);
		}  
		if (count($doc) > 0) { 
		$doc_data['approved_doc'] = json_encode($doc);
		}


		// return $doc_data;
		// print_r($doc_data);
		// echo json_encode($doc_data);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('document_check',$doc_data)) {


			if($analyst_status == '3'){
				$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			}

			$isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			$outpuQcUpdateStatus = '0';
			if($isOutputQcExists == '0'){
				$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
				if($outpuQcUpdateStatus != '1'){
					$outpuQcUpdateStatus = '0';
				}else{
					$outpuQcUpdateStatus = '1';
				}
			} 

			$doc_data['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('document_check_log',$doc_data);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}
	}