<?php
class Finance_Cases_Model extends CI_Model {

	function getPackgeDetail() {
		$result =  $this->db->where('package_status',1)->where('package_id',$this->input->post('id'))->get('packages')->row_array();
		 
			$component_names = array();  
			$comp_name = array();
			$row['package_name'] = $result['package_name'];
			$row['package_id'] = $result['package_id'];
			$row['package_status'] = $result['package_status'];
			$component_ids = explode(',', $result['component_ids']);
			$component = $this->db->where_in('component_id',$component_ids)->get('components')->result_array();

			foreach ($component as $key1 => $com) {
				array_push($comp_name, $com['component_name']);
			}
			 
			$row['component_ids'] =  $component_ids;
			$row['component_name'] =  $comp_name;
			array_push($component_names, $row);
		 
		return $component_names;
	}

	function get_all_cases() {
		$finance_info = $this->session->userdata('logged-in-finance');
		$filter_limit = $this->input->post('filter_limit');
		$filter_input = $this->input->post('filter_input');
		$candidate_id_list = $this->input->post('candidate_id_list');

		if ($filter_limit == '' || !is_numeric($filter_limit)) {
			$filter_limit = 100;
		}

		 $where = '';
        if ($this->input->post('duration') == 'today') {
            $where = " date(candidate.report_generated_date) = CURDATE()";
        } else if($this->input->post('duration') == 'week') {
            $where = " date(candidate.report_generated_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        } else if($this->input->post('duration') == 'month') {
            $where = " date(candidate.report_generated_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        } else if($this->input->post('duration') == 'year') {
            $where = " date(candidate.report_generated_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        } else if($this->input->post('duration') == 'between') {
            $where = " date(candidate.report_generated_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }else{
        	 $where = " candidate_status = 1";
        }
        $this->db->where($where);
// candidate_details_added_from
        if ($this->input->post('cases_type') !='') {
        	 $this->db->where('candidate_details_added_from',$this->input->post('cases_type'));
        }
		$where_condition = '';
		if($filter_input != '') {
			$filter_input = '%'.$filter_input.'%';
			$where_condition .= ' (`first_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `last_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `father_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `phone_number` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `email_id` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `tbl_client`.`client_name` LIKE "'.$filter_input.'"';
			$where_condition .= ')';
			$this->db->where($where_condition);
		}

		if ($this->input->post('client_list') != '') {
			$this->db->where_in('candidate.client_id',$this->input->post('client_list'));
		}

		if (isset($candidate_id_list) && count($candidate_id_list) > 0) {
			$this->db->where_not_in('candidate.candidate_id', $candidate_id_list);
		}

		return $this->db->select("candidate.*, candidate.package_name AS selected_package_id, tbl_client.client_name, tbl_client.package_components AS all_client_packages, packages.package_name")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->order_by('candidate.candidate_id','DESC')->limit($filter_limit)->get('candidate')->result_array();
		// ->where('case_added_by_role','inputqc')
	}

	function get_all_completed_cases() {
		$finance_info = $this->session->userdata('logged-in-finance');
		$filter_limit = $this->input->post('filter_limit');
		$filter_input = $this->input->post('filter_input');
		$candidate_id_list = $this->input->post('candidate_id_list');
 
		if ($filter_limit == '' || !is_numeric($filter_limit)) {
			$filter_limit = 100;
		}

		$where_condition = '';
		if($filter_input != '') {
			$filter_input = '%'.$filter_input.'%';
			$where_condition .= ' (`first_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `last_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `father_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `phone_number` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `email_id` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `tbl_client`.`client_name` LIKE "'.$filter_input.'"';
			$where_condition .= ')';
			$this->db->where($where_condition);
		}

		if ($this->input->post('client_list') != '') {
			$this->db->where_in('candidate.client_id',$this->input->post('client_list'));
		}
		 if ($this->input->post('cases_type') !='') {
        	 $this->db->where('candidate_details_added_from',$this->input->post('cases_type'));
        }

		if (isset($candidate_id_list) && count($candidate_id_list) > 0) {
			$this->db->where_not_in('candidate.candidate_id', $candidate_id_list);
		} 

		 if($this->input->post('from') != '' && $this->input->post('from') != null  && $this->input->post('to') != ''  && $this->input->post('to') != null) {
            $where = "date(candidate.report_generated_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
            $this->db->where($where);
        }

		return $this->db->select("candidate.*, candidate.package_name AS selected_package_id, tbl_client.client_name, tbl_client.package_components AS all_client_packages, packages.package_name")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where('is_submitted','2')->order_by('candidate.report_generated_date','DESC')->limit($filter_limit)->get('candidate')->result_array();
	}

	function get_all_partially_builled_cases() {
		$finance_info = $this->session->userdata('logged-in-finance');
		$filter_limit = $this->input->post('filter_limit');
		$filter_input = $this->input->post('filter_input');
		$candidate_id_list = $this->input->post('candidate_id_list');

		if ($filter_limit == '' || !is_numeric($filter_limit)) {
			$filter_limit = 100;
		}

		$where_condition = '';
		if($filter_input != '') {
			$filter_input = '%'.$filter_input.'%';
			$where_condition .= ' (`first_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `last_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `father_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `phone_number` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `email_id` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `tbl_client`.`client_name` LIKE "'.$filter_input.'"';
			$where_condition .= ')';
			$this->db->where($where_condition);
		}

		if ($this->input->post('client_list') != '') {
			$this->db->where_in('candidate.client_id',$this->input->post('client_list'));
		}

		if (isset($candidate_id_list) && count($candidate_id_list) > 0) {
			$this->db->where_not_in('candidate.candidate_id', $candidate_id_list);
		}

		return $this->db->select("candidate.*, candidate.package_name AS selected_package_id, tbl_client.client_name, tbl_client.package_components AS all_client_packages, packages.package_name")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->where_in('is_submitted',array('0','1'))->limit($filter_limit)->get('candidate')->result_array();
	}

	function get_all_saved_summary() {
		$user = $this->session->userdata('logged-in-finance');
		$filter_limit = $this->input->post('filter_limit');
		$summary_id_list = $this->input->post('summary_id_list');

		$where_condition = array(
			'summary_created_by_id' => $user['team_id']
		);

		if ($this->input->post('client_list') != '') {
			$this->db->where_in('client_id',$this->input->post('client_list'));
		}
		
		if (isset($summary_id_list) && count($summary_id_list) > 0) {
			$this->db->where_not_in('summary_id', $summary_id_list);
		}

		return $this->db->where($where_condition)->limit($filter_limit)->order_by('summary_id','DESC')->get('finance_summary')->result_array();
	}

	function get_new_cases_count() {
		$filter_input = $this->input->post('filter_input');

		$where_condition = '';
		if($filter_input != '') {
			$filter_input = '%'.$filter_input.'%';
			$where_condition .= ' (`first_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `last_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `father_name` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `phone_number` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `email_id` LIKE "'.$filter_input.'"';
			$where_condition .= ' OR `tbl_client`.`client_name` LIKE "'.$filter_input.'"';
			$where_condition .= ')';
			$this->db->where($where_condition);
		}
		
		if ($this->input->post('client_list') != '') {
			$this->db->where_in('candidate.client_id',$this->input->post('client_list'));
		}

		if ($this->input->post('case_required_type') != '' && count($this->input->post('case_required_type')) > 0) {
			$this->db->where_in('is_submitted',$this->input->post('case_required_type'));
		}

		return $this->db->select('COUNT(*) AS new_cases_count')->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->where_not_in('candidate.candidate_id', $this->input->post('candidate_id_list'))->get('candidate')->row_array();
	}

	function get_new_cases_summary_count() {
		$user = $this->session->userdata('logged-in-finance');
		$summary_id_list = $this->input->post('summary_id_list');
		
		$where_condition = array(
			'summary_created_by_id' => $user['team_id']
		);

		if ($this->input->post('client_list') != '') {
			$this->db->where_in('client_id',$this->input->post('client_list'));
		}

		if (isset($summary_id_list) && count($summary_id_list) > 0) {
			$this->db->where_not_in('summary_id', $summary_id_list);
		}

		return $this->db->select('COUNT(*) AS new_summary_count')->where($where_condition)->get('finance_summary')->row_array();
	}

	function get_single_cases_detail() {
		return $this->db->select("candidate.*,tbl_client.client_name")->from("candidate")->where('candidate_id',$this->input->post('id'))->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->get()->result_array();
	}

	function get_single_case_details($candidate_id) {
 		$result = $this->db->where('candidate_id',$candidate_id)->select("candidate.*,tbl_client.client_name,packages.package_name")->from("candidate")->join('tbl_client','candidate.client_id = tbl_client.client_id','left')->join('packages','candidate.package_name = packages.package_id','left')->get()->row_array();

 		$component_id = explode(',', $result['component_ids']);
 		$component = $this->db->where_in('component_id',$component_id)->get('components')->result_array();

 		 $case_data  = array();
 		foreach ($component as $key => $value) {
 			 $row['component_id'] = $value['component_id'];
 			 $row['component_name'] = $value['component_name']; 
 			 $row['client_id'] = $result['client_id']; 
 			 $row['client_name'] = $result['client_name']; 
 			 $row['candidate_id'] = $result['candidate_id']; 
 			 $row['title'] = $result['title']; 
 			 $row['first_name'] = $result['first_name']; 
 			 $row['last_name'] = $result['last_name']; 
 			 $row['father_name'] = $result['father_name']; 
 			 $row['phone_number'] = $result['phone_number']; 
 			 $row['email_id'] = $result['email_id']; 
 			 $row['date_of_birth'] = $result['date_of_birth']; 
 			 $row['date_of_joining'] = $result['date_of_joining']; 
 			 $row['employee_id'] = $result['employee_id']; 
 			 $row['package_name'] = $result['package_name']; 
 			 $row['remark'] = $result['remark']; 
 			 $row['document_uploaded_by'] = $result['document_uploaded_by']; 
 			 $row['document_uploaded_by_email_id'] = $result['document_uploaded_by_email_id']; 
 			 $row['is_submitted'] = $result['is_submitted'];  
 			 array_push($case_data, $row);
 		}

 		return $case_data;
	}

	function save_finance_case_summary() { 
		$user = $this->session->userdata('logged-in-finance');
		$finance_data = array(
			'candidate_ids'=>$this->input->post('candidate'),
			'client'=>$this->input->post('client'),
			'client_id'=>$this->input->post('client_id'),
			'summary_created_by_id'=>$user['team_id'],
		);

		if ($this->db->insert('finance_summary',$finance_data)) {
			$insert_id = $this->db->insert_id();
			return array('status'=>'1','msg'=>'success','id'=>$insert_id);
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function selected_request_finance_summary($id) {
		$data = $this->db->where('summary_id',$id)->get('finance_summary')->row_array();
		$finance_data = '';
		if (isset($data['created_fields'])) {
			$array = explode(',', $data['created_fields']);
			array_push($array,$this->input->post('field_name')); 
			$fields = implode(',', $array);
			$finance_data = array(
				'created_fields' =>$fields
			); 
		} else {
			$finance_data = array(
				'created_fields' =>$this->input->post('field_name')
			);
			// $field_result = $this->db->insert('fs_fields',$data_array);
		}

		if ($this->db->where('summary_id',$id)->update('finance_summary',$finance_data)) {
			return array('status'=>'1','msg'=>'success');
		}else{
			return array('status'=>'0','msg'=>'failled');
		}
	}

	function get_all_finance_summary($id) {
		return $this->db->where('summary_id',$id)->get('finance_summary')->row_array();
	}

	function save_selected_finance_case_summary_value($id) {
		$data = $this->db->where('summary_id',$id)->get('finance_summary')->row_array();

		$created_fields = explode(',', $data['created_fields']);
		$field_value = explode(',', $this->input->post('field_value'));
		$db_field_value =array();
		if ($data['field_value'] !=null) { 
		$db_field_value = json_decode($data['field_value'],true);
		}
		$j = 0;
		$values = array();

		if (count($created_fields)>0) {
			foreach ($created_fields as $key => $value) {
				$array_value= array();
				for ($i=0; $i < $this->input->post('count'); $i++) { 
					// code...
				}
				 array_push($values,array($value=>'test'));
			}
		}
	}

	function changeStatusSummary($id,$summary_status) {
		$this->db->where('summary_id',$id);
		$updatedDate = date('d-m-yy');
		$summary_data = array(
			'finance_status' => $summary_status,
			'finance_notify' => $summary_status,
			'summary_updated_date'=>date('d-m-Y H:i:s')
		);

		if ($this->db->update('finance_summary',$summary_data)) {
			return array('status'=>'1','message'=>'Status updated successfully.');
		} else {
			return array('status'=>'0','message'=>'Something went wrong while updating the status.');
		}	 
	}
}	
?>