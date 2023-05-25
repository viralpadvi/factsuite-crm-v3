<?php
/**
 * 28-01-2021	
 */
class ComponentModel extends CI_Model
{
	function get_component_details($component_id=''){
		$result ='';
		if ($component_id !='') { 
			$result = $this->db->where('component_id',$component_id)->where('component_status',1)->get('components')->row_array();
		}else{
			$result = $this->db->where('component_status',1)->get('components')->result_array();
		}
		return $result;
	}


	function get_component_type(){
		$component_names = array();
		$education_type = $this->db->where('status',1)->get('education_type')->result_array();
		$document_type = $this->db->where('status',1)->get('document_type')->result_array();
		$drug_test_type = $this->db->where('status',1)->get('drug_test_type')->result_array();

		$component_names['education_type']= $education_type;
		$component_names['documetn_type']= $document_type;
		$component_names['drug_test_type']= $drug_test_type; 
		return $component_names;
	}

	function insert_component(){
		// $user = $this->session->userdata('logged-in-admin');
		$components_data = array(
			'component_name'=>$this->input->post('component_name'),
			'component_standard_price'=>$this->input->post('component_price')
			 
		);
		if ($this->db->insert('components',$components_data)) {
			$insert_id = $this->db->insert_id();
			$components_log_data = array(
				'component_id'=>$insert_id,
				'component_name'=>$this->input->post('component_name'),
				'component_standard_price'=>$this->input->post('component_price')
				 
			);
			$this->db->insert('components_log',$components_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_component($component_icon) {
		$user = $this->session->userdata('logged-in-admin');
		$components_data = array(
			'component_name'=>$this->input->post('component_name'),
			'fs_website_component_name'=>$this->input->post('fs_website_component_name'),
			'component_standard_price'=>$this->input->post('component_price'),
			'form_threshold'=>$this->input->post('form_threshold'),
			'component_short_description'=>$this->input->post('component_short_description'),
			'updated_date' => date('d-m-Y H:i:s')
			 
		);
		if ($component_icon != 'no-file') {
			$components_data['component_icon'] = $component_icon;
		}
		$this->db->where('component_id',$this->input->post('edit_component_id'));
		if ($this->db->update('components',$components_data)) {
			$insert_id = $this->db->insert_id();
			$components_log_data = array( 
				'component_id'=>$this->input->post('edit_component_id'),
				'component_name'=>$this->input->post('component_name'),
				'fs_website_component_name'=>$this->input->post('fs_website_component_name'),
				'component_status' => 2,
				'component_standard_price'=>$this->input->post('component_price'),
				'form_threshold'=>$this->input->post('form_threshold'),
				'component_short_description'=>$this->input->post('component_short_description'),
				 
			);
			if ($component_icon != 'no-file') {
				$components_log_data['component_icon'] = $component_icon;
			}
			$this->db->insert('components_log',$components_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


	function remove_component($component_id){
		$user = $this->session->userdata('logged-in-admin');
		$components_data = array(  
			'component_status'=>0,
		);
		$this->db->where('component_id',$component_id);
		if ($this->db->update('components',$components_data)) {
			$result = $this->db->where('component_id',$component_id)->get('components')->row_array(); 
			 
			$components_log_data = array(
				'component_id'=>$result['component_id'], 
				'component_name'=>$result['component_name'],
				'fs_website_component_name'=>$result['fs_website_component_name'],
				'component_standard_price'=>$result['component_standard_price'],
				'component_short_description'=>$result['component_short_description'],
				'component_icon'=>$result['component_icon'],
				'component_status' => 5
			);
			$this->db->insert('components_log',$components_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function get_all_cities($id=''){
		if ($id !='') {
			return $this->db->where('state_id',$id)->get('cities')->result_array();
		}else{
			return $this->db->order_by('state_id','ASC')->get('cities')->result_array();
		}
	}

	function insert_city(){
		$data = array(
			'state_id'=>$this->input->post('state'),
			'name'=>$this->input->post('name'),
		);
		if ($this->db->insert('cities',$data)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

}
