<?php
 
class OutPutNewComponents extends CI_Model
{

	function __construct() {
	  parent::__construct();
	  $this->load->database();
	  $this->load->helper('url');    
	  $this->load->model('emailModel');     
	  $this->load->model('smsModel');
	} 



	function update_politically_exposed(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}else{
			
		}

		$ouputQcComment = $this->input->post('ouputQcComment');


		$politically_exposed = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status'),
			'ouputqc_comment' => $ouputQcComment,
			'outputqc_status_date'=>date('Y-m-d H:i:s')
		); 
		// if (count($client_docs) > 0) {
		// 	$politically_exposed['approved_doc'] = implode(',',$client_docs);
		// }  

		// print_r($reference_remark_data);
		// echo json_encode($politically_exposed);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('politically_exposed',$politically_exposed)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('politically_exposed');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('politically_exposed','candidate_id',$candidate_id,$componentId,$userId);


			// if($analyst_status == '3'){
			// 	$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			// }

			// $isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			// $outpuQcUpdateStatus = '0';
			// if($isOutputQcExists == '0'){
			// 	$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
			// 	if($outpuQcUpdateStatus != '1'){
			// 		$outpuQcUpdateStatus = '0';
			// 	}else{
			// 		$outpuQcUpdateStatus = '1';
			// 	}
			// } 

			$politically_exposed['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('politically_exposed_log',$politically_exposed);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}
	function update_india_civil_litigation(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}else{
			
		}

		$ouputQcComment = $this->input->post('ouputQcComment');


		$india_civil_litigation = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status'),
			'ouputqc_comment' => $ouputQcComment,
			'outputqc_status_date'=>date('Y-m-d H:i:s')
		); 
		// if (count($client_docs) > 0) {
		// 	$india_civil_litigation['approved_doc'] = implode(',',$client_docs);
		// }  

		// print_r($reference_remark_data);
		// echo json_encode($india_civil_litigation);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('india_civil_litigation',$india_civil_litigation)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('india_civil_litigation');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('india_civil_litigation','candidate_id',$candidate_id,$componentId,$userId);


			// if($analyst_status == '3'){
			// 	$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			// }

			// $isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			// $outpuQcUpdateStatus = '0';
			// if($isOutputQcExists == '0'){
			// 	$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
			// 	if($outpuQcUpdateStatus != '1'){
			// 		$outpuQcUpdateStatus = '0';
			// 	}else{
			// 		$outpuQcUpdateStatus = '1';
			// 	}
			// } 

			$india_civil_litigation['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('india_civil_litigation_log',$india_civil_litigation);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}

	function update_mca(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}else{
			
		}

		$ouputQcComment = $this->input->post('ouputQcComment');


		$mca = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status'),
			'ouputqc_comment' => $ouputQcComment,
			'outputqc_status_date'=>date('Y-m-d H:i:s')
		); 
		// if (count($client_docs) > 0) {
		// 	$mca['approved_doc'] = implode(',',$client_docs);
		// }  

		// print_r($reference_remark_data);
		// echo json_encode($mca);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('mca',$mca)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('mca');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('mca','candidate_id',$candidate_id,$componentId,$userId);


			// if($analyst_status == '3'){
			// 	$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			// }

			// $isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			// $outpuQcUpdateStatus = '0';
			// if($isOutputQcExists == '0'){
			// 	$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
			// 	if($outpuQcUpdateStatus != '1'){
			// 		$outpuQcUpdateStatus = '0';
			// 	}else{
			// 		$outpuQcUpdateStatus = '1';
			// 	}
			// } 

			$mca['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('mca_log',$mca);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}

	function update_oig(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}else{
			
		}

		$ouputQcComment = $this->input->post('ouputQcComment');


		$oig = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status'),
			'ouputqc_comment' => $ouputQcComment,
			'outputqc_status_date'=>date('Y-m-d H:i:s')
		); 
		// if (count($client_docs) > 0) {
		// 	$oig['approved_doc'] = implode(',',$client_docs);
		// }  

		// print_r($reference_remark_data);
		// echo json_encode($oig);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('oig',$oig)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('oig');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('oig','candidate_id',$candidate_id,$componentId,$userId);


			// if($analyst_status == '3'){
			// 	$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			// }

			// $isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			// $outpuQcUpdateStatus = '0';
			// if($isOutputQcExists == '0'){
			// 	$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
			// 	if($outpuQcUpdateStatus != '1'){
			// 		$outpuQcUpdateStatus = '0';
			// 	}else{
			// 		$outpuQcUpdateStatus = '1';
			// 	}
			// } 

			$oig['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('oig_log',$oig);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}

	function update_gsa(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}else{
			
		}

		$ouputQcComment = $this->input->post('ouputQcComment');


		$gsa = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status'),
			'ouputqc_comment' => $ouputQcComment,
			'outputqc_status_date'=>date('Y-m-d H:i:s')
		); 
		// if (count($client_docs) > 0) {
		// 	$gsa['approved_doc'] = implode(',',$client_docs);
		// }  

		// print_r($reference_remark_data);
		// echo json_encode($gsa);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('gsa',$gsa)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('gsa');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('gsa','candidate_id',$candidate_id,$componentId,$userId);


			// if($analyst_status == '3'){
			// 	$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			// }

			// $isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			// $outpuQcUpdateStatus = '0';
			// if($isOutputQcExists == '0'){
			// 	$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
			// 	if($outpuQcUpdateStatus != '1'){
			// 		$outpuQcUpdateStatus = '0';
			// 	}else{
			// 		$outpuQcUpdateStatus = '1';
			// 	}
			// } 

			$gsa['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('gsa_log',$gsa);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}
	function update_nric(){
		$isChanged = '0';
		$role = $this->input->post('userRole');
		$op_action_status = $this->input->post('op_action_status');
		$analyst_status = $this->input->post('action_status');
		if($role == 'outputqc' && $op_action_status == '2'){
			$analyst_status = '10';
		}else{
			
		}

		$ouputQcComment = $this->input->post('ouputQcComment');


		$nric = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'in_progress_remarks'=>$this->input->post('in_progress_remark'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'insuff_closure_remarks'=>$this->input->post('insuff_closer_remark'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$this->input->post('op_action_status'),
			'ouputqc_comment' => $ouputQcComment,
			'outputqc_status_date'=>date('Y-m-d H:i:s')
		); 
		// if (count($client_docs) > 0) {
		// 	$gsa['approved_doc'] = implode(',',$client_docs);
		// }  

		// print_r($reference_remark_data);
		// echo json_encode($gsa);
		// exit();
			$this->db->where('candidate_id',$this->input->post('candidate_id'));
		if ($this->db->update('nric',$nric)) {

			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('nric');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('nric','candidate_id',$candidate_id,$componentId,$userId);


			// if($analyst_status == '3'){
			// 	$isChanged = $this->isSubmitedStatusChanged($this->input->post('candidate_id'));
			// }

			// $isOutputQcExists = $this->outputQcExists($this->input->post('candidate_id'));
			// $outpuQcUpdateStatus = '0';
			// if($isOutputQcExists == '0'){
			// 	$outpuQcUpdateStatus = $this->isAllComponentApproved($this->input->post('candidate_id'));
			// 	if($outpuQcUpdateStatus != '1'){
			// 		$outpuQcUpdateStatus = '0';
			// 	}else{
			// 		$outpuQcUpdateStatus = '1';
			// 	}
			// } 

			$nric['candidate_id'] = $this->input->post('candidate_id');
			$this->db->insert('nric_log',$nric);

			return array('status'=>'1','msg'=>'success','isSubmitedStatusChanged'=>$isChanged);
		}else{
			return array('status'=>'0','msg'=>'failled','isSubmitedStatusChanged'=>$isChanged);
		}

	}


	function update_right_to_work(){
		$role = $this->input->post('userRole');
		$outputQcStatus =  $this->input->post('op_action_status');

		$op_action_status = explode(',',$outputQcStatus);
		$analyst_status = explode(',',$this->input->post('action_status'));
		$outputQcStatusDate = array();
		$output_date = array();
		foreach ($op_action_status as $key => $value) {
			
			if ($value == '2') {
				$analyst_status[$key] = '10';
			}
			array_push($output_date,date('Y-m-d H:i:s'));
		}

		
		$analyst_status = implode(',', $analyst_status);
		$right_to_work = array(
			'remarks_updateed_by_role' => $this->input->post('userRole'),
			'remarks_updateed_by_id' => $this->input->post('userID'),
			'remark_address'=>$this->input->post('address'),
			'remark_pin_code'=>$this->input->post('pincode'),
			'remark_city'=>$this->input->post('city'),
			'remark_state'=>$this->input->post('state'),
			'insuff_remarks'=>$this->input->post('insuff_remarks'),
			'in_progress_remarks'=>$this->input->post('progress_remarks'),
			'verification_remarks'=>$this->input->post('verification_remarks'),
			'Insuff_closure_remarks'=>$this->input->post('closure_remarks'),
			'analyst_status'=>$analyst_status,
			'output_status'=>$outputQcStatus,
			'ouputqc_comment'=>$this->input->post('ouputQcComment'),
			'outputqc_status_date'=>implode(',', $output_date)
		); 
		 
			$candidate_id = $this->input->post('candidate_id');
			$componentId = $this->utilModel->getComponentId('right_to_work');
			$userId = $this->session->userdata('logged-in-outputqc');
			$userId = $userId['team_id'];
			$this->notificationModel->notificationCreate('right_to_work','candidate_id',$candidate_id,$componentId,$userId);
			// exit();
			$this->db->where('candidate_id',$candidate_id);
		if ($this->db->update('right_to_work',$right_to_work)) { 
			
			$right_to_work['candidate_id'] = $candidate_id;			
			$this->db->insert('right_to_work_log',$right_to_work);

			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
 
	}


}