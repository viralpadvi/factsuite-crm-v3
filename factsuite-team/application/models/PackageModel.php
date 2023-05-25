<?php
/**
 * 28-01-2021	
 */
class PackageModel extends CI_Model
{
	function get_package_details($package_id=''){
		$result ='';
		if ($package_id !='') { 
			$result = $this->db->where('package_id',$package_id)->where('package_status',1)->get('packages')->row_array();
		}else{
			$result = $this->db->where('package_status',1)->get('packages')->result_array();
		}
		return $result;
	}

	function get_alacarte_detail($alacarte_id=''){
		$result ='';
		if ($alacarte_id !='') { 
			$result = $this->db->where('alacarte_id',$alacarte_id)->where('alacarte_status',1)->get('alacarte')->row_array();
		}else{
			$result = $this->db->where('alacarte_status',1)->get('alacarte')->result_array();
		}
		return $result;
	}

	function get_package_list($package_ids){
		return  $this->db->where_in('package_id',$package_ids)->get('packages')->result_array();
	}

	function single_component_details($component_id){
		return $this->db->where('component_id',$component_id)->get('components')->row_array();
	}



	function get_component_name(){
		$result = $this->db->where('package_status',1)->get('packages')->result_array();
		$component_names = array(); 
		foreach ($result as $value) {
			$comp_name = array();
			$row['package_name'] = $value['package_name'];
			$row['package_id'] = $value['package_id'];
			$row['package_status'] = $value['package_status'];
			$component_ids = explode(',', $value['component_ids']);
			$component = $this->db->where_in('component_id',$component_ids)->get('components')->result_array();
			foreach ($component as $key1 => $com) {
				array_push($comp_name, $com['component_name']);
			}
			$row['component_name'] =  implode(',',$comp_name);
			array_push($component_names, $row);
		}
		return $component_names;
	}

	function get_alacarte_details(){
		$result = $this->db->where('alacarte_status',1)->get('alacarte')->result_array();
		$component_names = array(); 
		foreach ($result as $value) {
			$comp_name = array();
			$row['alacarte_name'] = $value['alacarte_name'];
			$row['alacarte_id'] = $value['alacarte_id'];
			$row['alacarte_status'] = $value['alacarte_status'];
			$component_ids = explode(',', $value['component_ids']);
			$component = $this->db->where_in('component_id',$component_ids)->get('components')->result_array();
			foreach ($component as $key1 => $com) {
				array_push($comp_name, $com['component_name']);
			}
			$row['component_name'] =  implode(',',$comp_name);
			array_push($component_names, $row);
		}
		return $component_names;
	}

	function get_single_component_name($package_id = ''){
		$result = $this->db->where('package_status',1)->where('package_id',$package_id)->get('packages')->result_array();
		$component_names = array(); 
		foreach ($result as $value) {
			$comp_name = array();
			$website_comp_name = array();
			$row['package_name'] = $value['package_name'];
			$row['package_id'] = $value['package_id'];
			$row['package_status'] = $value['package_status'];
			$component_ids = explode(',', $value['component_ids']);
			$component = $this->db->where_in('component_id',$component_ids)->order_by('component_id','DESC')->get('components')->result_array();
			foreach ($component as $key1 => $com) {
				array_push($comp_name, $com['component_name']);
				array_push($website_comp_name, $com['fs_website_component_name']);
			}
			$row['component_ids'] = $value['component_ids'];
			$row['component_ids_array'] = $component_ids;
			$row['component_name'] =  implode(',',$comp_name);
			$row['fs_website_component_name'] =  implode(',',$website_comp_name);
			array_push($component_names, $row);
		}
		
		$education_type = $this->db->where('status',1)->get('education_type')->result_array();
		$document_type = $this->db->where('status',1)->get('document_type')->result_array();
		$drug_test_type = $this->db->where('status',1)->get('drug_test_type')->result_array();

		$data['education_type']= $education_type;
		$data['documetn_type']= $document_type;
		$data['drug_test_type']= $drug_test_type;
		array_push($component_names, $data);
		return $component_names;
	}

	function get_single_component($component_id){
		return  $this->db->where('component_id',$component_id)->get('components')->row_array();
	}

	function get_all_components(){
		return  $this->db->get('components')->result_array();
	}

	function get_single_client($client_id){
		return $this->db->where('client_id',$client_id)->get('tbl_client')->row_array();
	}


	function get_single_alacarte_component_name($alacarte_id = ''){
		$result = $this->db->where('alacarte_status',1)->where('alacarte_id',$alacarte_id)->get('alacarte')->result_array();
		$component_names = array(); 
		foreach ($result as $value) {
			$comp_name = array();
			$row['alacarte_name'] = $value['alacarte_name'];
			$row['alacarte_id'] = $value['alacarte_id'];
			$row['alacarte_status'] = $value['alacarte_status'];
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
		
		$education_type = $this->db->where('status',1)->get('education_type')->result_array();
		$document_type = $this->db->where('status',1)->get('document_type')->result_array();
		$drug_test_type = $this->db->where('status',1)->get('drug_test_type')->result_array();

		$data['education_type']= $education_type;
		$data['documetn_type']= $document_type;
		$data['drug_test_type']= $drug_test_type;
		array_push($component_names, $data);
		return $component_names;
	}


	function get_packages($package_id){
		 
			$result = $this->db->where_in('package_id',$package_id)->where('package_status',1)->get('packages')->result_array();
			$comp_id = array();
			foreach ($result as $key => $value) {
				 foreach (explode(',', $value['component_ids']) as $key => $val) {
				 	array_push($comp_id,$val);
				 }
			}
			
		return $comp_id;
		 
	}

	function get_package_components($package_id){ 

		// return $package_id;
		if (!is_array($package_id)) {
			$package_id = explode(',', $package_id);
		}
		$component = $this->db->where_in('package_id',$package_id)->get('packages')->result_array();
		$comp_id = array();
		$comp_result = array();
			foreach ($component as $key => $value) {
				 foreach (explode(',', $value['component_ids']) as $key => $val) { 
				 	if ($val !='' && $val !=null) {
				 		$result = $this->db->where_in('component_id',$val)
						   ->get('components')
						   ->row_array();
						   if ($result !=null && $result !='') { 
				 		$row['package_id'] = $value['package_id'];
				 		$row['component_id'] = $result['component_id'];
						$row['component_name'] = $result['component_name'];
						$row['component_standard_price'] = $result['component_standard_price'];
						$row['form_threshold'] = $result['form_threshold'];
						$row['component_status'] = $result['component_status'];
						$row['created_date'] = $result['created_date'];
						array_push($comp_result, $row);	 
						   }
				 	}
				 	
				 }
			}
 
		return $comp_result;
	}


	function get_package_all_component($package_id){
		$component = $this->db->where('package_id',$package_id)->get('packages')->row_array();

		return  $this->db->where_in('component_id',explode(',', $component['component_ids']))
						   ->get('components')
						   ->result_array();
	}

	function get_alacarte_component($alacarte_id){ 

		// return $package_id;
		if (!is_array($alacarte_id)) {
			$alacarte_id = explode(',', $alacarte_id);
		}
		$component = $this->db->where_in('alacarte_id',$alacarte_id)->get('alacarte')->result_array();
		$comp_id = array();
		$comp_result = array();
			foreach ($component as $key => $value) {
				 foreach (explode(',', $value['component_ids']) as $key => $val) { 
				 	if ($val !='' && $val !=null) {
				 		$result = $this->db->where_in('component_id',$val)
						   ->get('components')
						   ->row_array();
						   if ($result !=null && $result !='') { 
				 		$row['alacarte_id'] = $value['alacarte_id'];
				 		$row['component_id'] = $result['component_id'];
						$row['component_name'] = $result['component_name'];
						$row['component_standard_price'] = $result['component_standard_price'];
						$row['form_threshold'] = $result['form_threshold'];
						$row['component_status'] = $result['component_status'];
						$row['created_date'] = $result['created_date'];
						array_push($comp_result, $row);	 
						   }
				 	}
				 	
				 }
			}
 
		return $comp_result;
	}

	function insert_package(){
		// $user = $this->session->userdata('logged-in-admin');

		$package_data = array(
			'package_name'=>$this->input->post('package_name'),
			'component_ids'=>implode(",",$this->input->post('component_ids'))
			 
		);


		if ($this->db->insert('packages',$package_data)) {
			$insert_id = $this->db->insert_id();
			$components_log_data = array(
				'package_id'=>$insert_id,
				'package_name'=>$this->input->post('package_name'),
				'component_ids'=>implode(",",$this->input->post('component_ids'))
				 
			);
			$this->db->insert('packages_log',$components_log_data);
			return array('status'=>'1','msg'=>'success','package_id'=>$insert_id);
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_package(){
		$user = $this->session->userdata('logged-in-admin');
		$components_data = array(
			 
			'component_ids'=>implode(",",$this->input->post('component_ids')),
			'updated_date'=>date('d-m-Y H:i:s')
			 
		);
		$package_name = '-';
		if ($this->input->post('package_name')) { 
		$components_data['package_name']=$this->input->post('package_name');
		$package_name = $this->input->post('package_name');
		}
		$this->db->where('package_id',$this->input->post('package_id'));
		if ($this->db->update('packages',$components_data)) {
			$insert_id = $this->db->insert_id();

			$components_log_data = array( 
				'package_id'=>$this->input->post('package_id'),
				'package_name'=>$package_name,
				'package_status' => 2,
				'component_ids'=>implode(",",$this->input->post('component_ids'))
				 
			);
			$this->db->insert('packages_log',$components_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


	function remove_package($package_id){
		$user = $this->session->userdata('logged-in-admin');
		$components_data = array(  
			'package_status'=>0,
		);
		$this->db->where('package_id',$package_id);
		if ($this->db->update('packages',$components_data)) {
			$result = $this->db->where('package_id',$package_id)->get('packages')->row_array(); 
			 
			$components_log_data = array(
				'package_id'=>$result['package_id'], 
				'package_name'=>$result['package_name'],
				'component_ids'=>$result['component_ids'],
				'package_status' => 5
				 
			);
			$this->db->insert('packages_log',$components_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


// alacarte 
		function insert_alacarte(){
		// $user = $this->session->userdata('logged-in-admin');

		$alacarte_data = array(
			'alacarte_name'=>$this->input->post('alacarte_name'),
			'component_ids'=>implode(",",$this->input->post('component_ids'))
			 
		);


		if ($this->db->insert('alacarte',$alacarte_data)) {
			$insert_id = $this->db->insert_id();
			$components_log_data = array(
				'alacarte_id'=>$insert_id,
				'alacarte_name'=>$this->input->post('alacarte_name'),
				'component_ids'=>implode(",",$this->input->post('component_ids'))
				 
			);
			$this->db->insert('alacarte_log',$components_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function update_alacarte(){
		$user = $this->session->userdata('logged-in-admin');
		$components_data = array(
			
			'alacarte_name'=>$this->input->post('alacarte_name'),
			'component_ids'=>implode(",",$this->input->post('component_ids')),
			'updated_date'=>date('d-m-Y H:i:s')
			 
		);
		$this->db->where('alacarte_id',$this->input->post('alacarte_id'));
		if ($this->db->update('alacarte',$components_data)) {
			$insert_id = $this->db->insert_id();
			$components_log_data = array( 
				'alacarte_id'=>$this->input->post('alacarte_id'),
				'alacarte_name'=>$this->input->post('alacarte_name'),
				'alacarte_status' => 2,
				'component_ids'=>implode(",",$this->input->post('component_ids'))
				 
			);
			$this->db->insert('alacarte_log',$components_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}


	function remove_alacarte($alacarte_id){
		$user = $this->session->userdata('logged-in-admin');
		$components_data = array(  
			'alacarte_status'=>0,
		);
		$this->db->where('alacarte_id',$alacarte_id);
		if ($this->db->update('alacarte',$components_data)) {
			$result = $this->db->where('alacarte_id',$alacarte_id)->get('alacarte')->row_array(); 
			 
			$components_log_data = array(
				'alacarte_id'=>$result['alacarte_id'], 
				'alacarte_name'=>$result['alacarte_name'],
				'component_ids'=>$result['component_ids'],
				'alacarte_status' => 5
				 
			);
			$this->db->insert('alacarte_log',$components_log_data);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}





	function get_component_details($component){
		$price_package =  json_decode($component['component_price'],true);
		// return $component;
		$component_id = explode(',', $component['component_id']);
		$component_price = explode(',', isset($price_package['component_price'])?$price_package['component_price']:0);
		$package_id = explode(',', isset($price_package['package'])?$price_package['package']:0);
		$component_client_price = explode(',', $component['component_client_price']); 
		$result = $this->db->where_in('component_id',$component_id)->get('components')->result_array();
		$component_data = array();
		foreach ($result as $key => $value) { 
			 $row['package_id'] = isset($package_id[$key])?$package_id[$key]:'';
			 $row['component_id'] = $value['component_id'];
			 $row['component_name'] = $value['component_name'];
			 $row['component_price'] = isset($component_price[$key])?$component_price[$key]:0;
			 $row['component_client_price'] = $component_client_price[$key];
			 array_push($component_data, $row);
		}
		return $component_data;
	}


	function remove_package_data($package_id,$client_id){
		$client = $this->db->where('client_id',$client_id)->get('tbl_client')->row_array(); 
		$package = array();
		$pack = explode(',',$client['packages']);
		$package_component = json_decode($client['package_components'],true);
		if (count($pack) > 0) { 
			foreach($pack as $key => $value){
				if ($package_id !=$value) { 
					array_push($package,$value);
				}
			}
		}
		$package_components = array();
		if (count($package_component) > 0) {
			foreach ($package_component as $key => $value) {
				 if ($value['package_id'] != $package_id) {
				 	$row['component_id'] = $value['component_id'];
				 	$row['component_name'] = $value['component_name'];
				 	$row['package_id'] = $value['package_id'];
				 	$row['component_standard_price'] = $value['component_standard_price'];
				 	$row['component_price'] = $value['component_price'];
				 	$row['form_data'] = $value['form_data']; 
				 	array_push($package_components,$row);
				 }
			}
		}

		$client_data = array(
			'packages'=>implode(',',$package),
			'package_components'=>json_encode($package_components),
		);
	 
		$this->db->where('client_id',$client_id);
		if ($this->db->update('tbl_client',$client_data)) {
			$this->remove_package($package_id);
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}

	}

	function remove_alacarte_data($component_id,$client_id){ 
		$client = $this->db->where('client_id',$client_id)->get('tbl_client')->row_array(); 
		$package = array(); 
		$alacarte_component = json_decode($client['alacarte_components'],true);
		$alacarte_components = array();
		if (count($alacarte_component) > 0) {
			foreach ($alacarte_component as $key => $value) {
				 if ($value['component_id'] != $component_id) {
				 	$row['component_id'] = $value['component_id'];
				 	$row['component_name'] = $value['component_name'];
				 	$row['alacarte_id'] = $value['alacarte_id'];
				 	$row['component_standard_price'] = $value['component_standard_price'];
				 	$row['component_price'] = $value['component_price'];
				 	$row['form_data'] = $value['form_data']; 
				 	array_push($alacarte_components,$row);
				 }
			}
		} 
		$client_data = array( 
			'alacarte_components'=>json_encode($alacarte_components),
		);
		 
		$this->db->where('client_id',$client_id);
		if ($this->db->update('tbl_client',$client_data)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}

	}

}
 