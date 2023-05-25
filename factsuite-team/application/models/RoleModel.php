<?php
/**
 * 28-01-2021	
 */
class roleModel extends CI_Model
{
	function get_role_details($role_id=''){
		$result ='';
		if ($role_id !='') { 
			$result = $this->db->where('role_id',$role_id)->where('role_status',1)->get('roles')->row_array();
		}else{
			$result = $this->db->where('role_status',1)->get('roles')->result_array();
		}
		return $result;
	}



	function get_single_component_name($role_id = ''){
		$result = $this->db->where('role_status',1)->where('role_id',$role_id)->get('roles')->result_array();
		$component_names = array(); 
		foreach ($result as $value) {
			$comp_name = array();
			$row['role_name'] = $value['role_name'];
			$row['role_id'] = $value['role_id'];
			$row['role_status'] = $value['role_status'];
			$component_ids = explode(',', $value['component_ids']);
			$component = $this->db->where_in('component_id',$component_ids)->get('components')->result_array();
			foreach ($component as $key1 => $com) {
				array_push($comp_name, $com['component_name']);
			}
			$row['component_ids'] = $value['component_ids'];
			$row['component_ids_array'] = $component_ids;
			$row['component_name'] =  implode(',',$comp_name);
			array_push($component_names, $row);
		}
		return $component_names;
	}

	function insert_role(){
		// $user = $this->session->userdata('logged-in-admin');

		$role_data = array(
			'role_name'=>$this->input->post('role_name'),
			'role_action'=>$this->input->post('selected_role')
			 
		);


		if ($this->db->insert('roles',$role_data)) {
			$insert_id = $this->db->insert_id();
			$components_log_data = array(
				'role_id'=>$insert_id,
				'role_name'=>$this->input->post('role_name'),
				'role_action'=>$this->input->post('selected_role') 
			);
			$this->db->insert('roles_log',$components_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_role(){
		$user = $this->session->userdata('logged-in-admin');
		$components_data = array(
			
			'role_name'=>$this->input->post('role_name'),
			'role_action'=>$this->input->post('selected_role'),
			'updated_date'=>date('Y-m-d H:i:s')
			 
		);
		$this->db->where('role_id',$this->input->post('role_id'));
		if ($this->db->update('roles',$components_data)) {
			$insert_id = $this->db->insert_id();
			$components_log_data = array( 
				'role_id'=>$this->input->post('role_id'),
				'role_name'=>$this->input->post('role_name'),
				'role_action'=>$this->input->post('selected_role'),
				'role_status' => 2
				 
			);
			$this->db->insert('roles_log',$components_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


	function remove_role($role_id){
		$user = $this->session->userdata('logged-in-admin');
		$components_data = array(  
			'role_status'=>0,
		);
		$this->db->where('role_id',$role_id);
		if ($this->db->update('roles',$components_data)) {
			$result = $this->db->where('role_id',$role_id)->get('roles')->row_array(); 
			 
			$components_log_data = array(
				'role_id'=>$result['role_id'], 
				'role_name'=>$result['role_name'],
				'role_status' => 5
				 
			);
			$this->db->insert('roles_log',$components_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}



	function isAllComponentApproved(){
		 
		$candidateData_val = $this->db->where('is_submitted',0)->where('is_report_generated','1')->get('candidate')->result_array();
		// print_r($candidateData_val);
		  
		 	  if (count($candidateData_val) > 0) {
		 	   
		 foreach ($candidateData_val as $keys => $candidate_data) {
		$analystStatus = array();
		 
		$analystStatusArray = array();
		$outputStatusArray = array();
		  
		$component_ids = explode(',', $candidate_data['component_ids']) ; 
		 

		foreach ($component_ids as $key => $value) {
			// echo $this->getComponentName($value)."<br>";
			$componentStatus = $this->db->select('analyst_status,output_status')->where('candidate_id',$candidate_data['candidate_id'])->get($this->utilModel->getComponent_or_PageName($value))->row_array(); 
			// print_r($componentStatus );
			$component_status = isset($componentStatus['analyst_status'])?$componentStatus['analyst_status']:'0';
			$output_status = isset($componentStatus['output_status'])?$componentStatus['output_status']:'0';
			array_push($analystStatus, $component_status);  
			$tmp_com_status = explode(',',$component_status);
			$tmp_output_status = explode(',',$output_status);

			$positive_status = array('4','5','6','7','9');

			$tmp_matched_array = array();
			$tmp_matched_array_out = array();
			foreach ($tmp_com_status as $statuskey => $statusValue) {
			  	// echo $j++ .": Form Status: ".$statusValue;
				$out = isset($tmp_output_status[$statuskey])?$tmp_output_status[$statuskey]:0;
			  	if ($out == '1') {
			  		array_push($tmp_matched_array_out, '1');
			  	}else{
			  		array_push($tmp_matched_array_out, '0');
			  	}
			  	
			  	if (in_array($statusValue, $positive_status)){
					array_push($tmp_matched_array, '1');
				}else{
				  	array_push($tmp_matched_array, '0');
				}
			}  

			array_push($analystStatusArray, $tmp_matched_array);
			array_push($outputStatusArray, $tmp_matched_array_out);
			 
		} 
		$finalAnalystStatusArray = array();
		$finaloutStatusArray = array();

		foreach ($analystStatusArray as $analystStatusArraykey => $analystStatusArrayValue) {
			if(!in_array('0', $analystStatusArrayValue)){
				array_push($finalAnalystStatusArray, '1');
			} 

		} 


		foreach ($outputStatusArray as $outStatusArraykey => $outStatusArrayValue) {
			if(!in_array('0', $outStatusArrayValue)){
				array_push($finaloutStatusArray, '1');
			} 

		} 


		if(count($component_ids) == count($finalAnalystStatusArray) && count($component_ids)  == count($finaloutStatusArray) ){ 
			echo $candidate_data['candidate_id']."<br>";

		}else{
			// return $status = '0';
			
		}	

	}
	}

	}

}
