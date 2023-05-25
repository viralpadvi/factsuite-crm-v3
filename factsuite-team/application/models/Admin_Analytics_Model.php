<?php
/**
 * 28-01-2021	
 */
class Admin_Analytics_Model extends CI_Model
{

	function get_all_client_cases($page=0){
		// $query = "SELECT * FROM ";
		$where = '';

		if ($this->input->post('manager') !='all' && $this->input->post('status') =='inactive') {
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>0);
			$this->db->where($where);	
		$this->db->limit(10);
		} else if ($this->input->post('manager') !='all' && $this->input->post('status') =='active'){
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>1);	
			$this->db->where($where);
		 $this->db->limit(10); 
		}else if($this->input->post('from') !='' && $this->input->post('to') !='' && $page !=0){
			$where="  date(tbl_client.client_created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
			$this->db->where($where);
		}else{
			$start = 0; 
			if ($page !=0) { 
				$total = 10 * $page;
				 $page_count = $total - 1;
				 $start = $page_count;
			}

			// $where = array('active_status'=>'0,1');	
			if (!$this->input->post('all')) {
				 
				$count = $this->db->get('tbl_client')->num_rows();
				if ($count > 0) {
					 $total_lenght = $count / 10; 
					 $t = intval($total_lenght);
					 $s = intval($start); 
					$this->db->limit(10,$start); 
				}
			}
		}

		
		$result = $this->db->select('tbl_client.*, team_employee.first_name, team_employee.last_name')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->get()->result_array();
		// $result = $this->db->query($query);
		// return $result;
		$client_data = array();
		foreach ($result as $key => $value) {
			$row = $value; 
			$count = $this->db->where('client_id',$value['client_id'])->get('candidate')->num_rows();
			array_push($row,array('case_count'=>$count));
			array_push($client_data,$row);
		}
			return $client_data;

	}


	function get_currunt_day_data_counting($page=0){
			// $query = "SELECT * FROM ";
		$where = '';

		if ($this->input->post('manager') !='all' && $this->input->post('status') =='inactive') {
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>0);	
			$this->db->where($where);
		$this->db->limit(10);
		} else if ($this->input->post('manager') !='all' && $this->input->post('status') =='active'){
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>1);
			$this->db->where($where);	
		 $this->db->limit(10); 
		}else{
			$start = 0; 
			if ($page !=0) { 
				$total = 10 * $page;
				 $page_count = $total - 1;
				 $start = $page_count;
			}

			// $where = array('active_status'=>'0,1');	
			$count = $this->db->get('tbl_client')->num_rows();
			if ($count > 0) {
				 $total_lenght = $count / 10; 
				 $t = intval($total_lenght);
				 $s = intval($start); 
				$this->db->limit(10,$start); 
			}
		}

		$result = $this->db->where_in($where)->select('tbl_client.*, team_employee.first_name, team_employee.last_name')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->get()->result_array();
		// $result = $this->db->query($query);
		// return $result;
		$client_data = array();
		foreach ($result as $key => $value) {
			$row = $value; 
			$query = "SELECT * FROM candidate where date(created_date) = CURDATE() AND client_id =".$value['client_id'];
			$count = $this->db->query($query)->num_rows();
			array_push($row,array('case_count'=>$count));
			array_push($client_data,$row);
		}
			return $client_data;
	}


	function get_all_client_closure_cases($page=0){
			// $query = "SELECT * FROM ";
		$where = '';

		if ($this->input->post('manager') !='all' && $this->input->post('status') =='inactive') {
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>0);
			$this->db->where($where);	
		$this->db->limit(10);
		} else if ($this->input->post('manager') !='all' && $this->input->post('status') =='active'){
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>1);	
			$this->db->where($where);
		 $this->db->limit(10); 
		}else if($this->input->post('from') !='' && $this->input->post('to') !='' && $page !=0){
			$where="  date(tbl_client.client_created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
			$this->db->where($where);
		}else{
			$start = 0; 
			if ($page !=0) { 
				$total = 10 * $page;
				 $page_count = $total - 1;
				 $start = $page_count;
			}
			if (!$this->input->post('all')) {
				// $where = array('active_status'=>'0,1');	
				$count = $this->db->get('tbl_client')->num_rows();
				if ($count > 0) {
					 $total_lenght = $count / 10; 
					 $t = intval($total_lenght);
					 $s = intval($start); 
					$this->db->limit(10,$start); 
				}
			}
		}

		$result = $this->db->select('tbl_client.*, team_employee.first_name, team_employee.last_name')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->get()->result_array();
		// $result = $this->db->query($query);
		// return $result;
		$client_data = array();
		foreach ($result as $key => $value) {
			$row = $value; 
			$count = $this->db->where('client_id',$value['client_id'])->where('is_submitted',2)->get('candidate')->num_rows();
			array_push($row,array('case_count'=>$count));
			array_push($client_data,$row);
		}
			return $client_data;

	}


	function get_currunt_day_closure_data_counting($page=0){
		// $query = "SELECT * FROM ";
		$where = '';

		if ($this->input->post('manager') !='all' && $this->input->post('status') =='inactive') {
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>0);	
			$this->db->where($where);
		$this->db->limit(10);
		} else if ($this->input->post('manager') !='all' && $this->input->post('status') =='active'){
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>1);	
			$this->db->where($where);
		 $this->db->limit(10); 
		}else{
			$start = 0; 
			if ($page !=0) { 
				$total = 10 * $page;
				 $page_count = $total - 1;
				 $start = $page_count;
			}

			// $where = array('active_status'=>'0,1');	
			$count = $this->db->get('tbl_client')->num_rows();
			if ($count > 0) {
				 $total_lenght = $count / 10; 
				 $t = intval($total_lenght);
				 $s = intval($start); 
				$this->db->limit(10,$start); 
			}
		}

		$result = $this->db->select('tbl_client.*, team_employee.first_name, team_employee.last_name')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->get()->result_array();
		// $result = $this->db->query($query);
		// return $result;
		$client_data = array();
		foreach ($result as $key => $value) {
			$row = $value; 
			$query = "SELECT * FROM candidate where is_submitted = 2 AND date(created_date) = CURDATE() AND client_id =".$value['client_id'];
			$count = $this->db->query($query)->num_rows();
			array_push($row,array('case_count'=>$count));
			array_push($client_data,$row);
		}
			return $client_data;
	}



	function get_all_client_wise_progress_cases(){
		 $where = '';
		if ($this->input->post('manager') !='all') {
			$where = array('tbl_client.client_id' =>$this->input->post('manager'));	
			$this->db->where($where);
		} else{
			/*$where = array('active_status'=>'0,1');	
			$this->db->where_in($where);*/
		}

		$result = $this->db->select('tbl_client.*, team_employee.first_name, team_employee.last_name')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->get()->result_array();
		// $result = $this->db->query($query);
		// return $result;
		$client_data = array();
		$pending = array();
		$insuff = array();
		$completed = array();
		$total = 0;
		if ($this->input->post('manager') !='all') {
			$total = $this->db->where('client_id',$this->input->post('manager'))->get('candidate')->num_rows();
		}else{

			$total = $this->db->get('candidate')->num_rows();
		}
		foreach ($result as $key => $value) {
			$row = $value; 
			$count_completed = $this->db->where('client_id',$value['client_id'])->where('is_submitted',2)->get('candidate')->num_rows();
			$count_progress = $this->db->where('client_id',$value['client_id'])->where('is_submitted',1)->get('candidate')->num_rows();
			$count_insuff = $this->db->where('client_id',$value['client_id'])->where('is_submitted',3)->get('candidate')->num_rows();

			// array_push($row,array('completed_case'=>$count_completed,'progress_case'=>$count_progress));
			array_push($completed,$count_completed);
			array_push($pending,$count_progress);
			array_push($insuff,$count_insuff);
		}
			return array('completed'=>array_sum($completed),'pending'=>array_sum($pending),'insuff'=>array_sum($insuff),'total'=>$total);

	}


	function get_all_client_wise_inventory_cases(){
		// $query = "SELECT * FROM ";
		$where = '';
		if ($this->input->post('manager') !='all' && $this->input->post('status') =='inactive') {
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>0);	
			$this->db->where($where);
		} else if ($this->input->post('manager') !='all' && $this->input->post('status') =='active'){
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>1);	
			$this->db->where($where);
		}else{
			// $where = array('active_status'=>'0,1');	
		}

		$result = $this->db->select('tbl_client.*, team_employee.first_name, team_employee.last_name')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->get()->result_array();
		// $result = $this->db->query($query);
		// return $result;
		$client_data = array();
		$completed = array();
		$pending = array();
		$init = array();
		$insuff = array();
		$aproved = array();
		$total = $this->db->get('candidate')->num_rows();
		foreach ($result as $key => $value) {
			$row = $value; 
			$count_completed = $this->db->where('client_id',$value['client_id'])->where('is_submitted',2)->get('candidate')->num_rows();
			$count_progress = $this->db->where('client_id',$value['client_id'])->where('is_submitted',1)->get('candidate')->num_rows();
			$count_not_init = $this->db->where('client_id',$value['client_id'])->where('is_submitted',0)->get('candidate')->num_rows();
			$count_insuff = $this->db->where('client_id',$value['client_id'])->where('is_submitted',3)->get('candidate')->num_rows();
			$count_approved = $this->db->where('client_id',$value['client_id'])->where('is_submitted',4)->get('candidate')->num_rows();
			/*array_push($row,array('completed_case'=>$count_completed,'progress_case'=>$count_progress,'insuff_case'=>$count_progress,'approved_case'=>$count_insuff));*/



			// array_push($row,array('completed_case'=>$count_completed,'progress_case'=>$count_progress));
			array_push($completed,$count_completed);
			array_push($pending,$count_progress); 
			array_push($init,$count_not_init);
			array_push($insuff,$count_insuff);
			array_push($aproved,$count_approved);
			// array_push($client_data,$row);
		}
			return array('completed'=>array_sum($completed),'pending'=>array_sum($pending),'insuff'=>array_sum($insuff),'aproved'=>array_sum($aproved),'total'=>$total,'init'=>array_sum($init));

	}




	function get_all_client_tat_cases(){
		// $query = "SELECT * FROM ";
		$where = '';
		if ($this->input->post('manager') !='all' && $this->input->post('status') =='inactive') {
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>0);	
			$this->db->where($where);
		} else if ($this->input->post('manager') !='all' && $this->input->post('status') =='active'){
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>1);	
			$this->db->where($where);
		}else{
			// $where = array('active_status'=>'0,1');	
		}

		$result = $this->db->select('tbl_client.*, team_employee.first_name, team_employee.last_name')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->get()->result_array();
		// $result = $this->db->query($query);
		// return $result;
		$client_data = array();
		foreach ($result as $key => $value) {
			$row = $value; 
			$count_completed = $this->db->where('client_id',$value['client_id'])->where('is_submitted',2)->get('candidate')->num_rows();
			$count_progress = $this->db->where('client_id',$value['client_id'])->where('is_submitted',1)->get('candidate')->num_rows();
			array_push($row,array('completed_case'=>$count_completed,'progress_case'=>$count_progress));
			array_push($client_data,$row);
		}
			return $client_data;

	}



	function get_all_tat_details(){
		// $query = "SELECT * FROM ";
		$where = '';
		if ($this->input->post('manager') !='all' && $this->input->post('status') =='inactive') {
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>0);	
			$this->db->where($where);
		} else if ($this->input->post('manager') !='all' && $this->input->post('status') =='active'){
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>1);	
			$this->db->where($where);
		}else{
			// $where = array('active_status'=>'0,1');	
		}

		$result = $this->db->select('tbl_client.*, team_employee.first_name, team_employee.last_name')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->get()->result_array();
		// $result = $this->db->query($query);
		// return $result;
		$client_data = array();
		$old = array();
		$new = array();
		$init = array();
		foreach ($result as $key => $value) { 
			$candidate = $this->db->where('client_id',$value['client_id'])->get('candidate')->result_array(); 
					foreach ($candidate as $k => $val) {
						/*$val['tat_end_date'];*/
						$start_date = isset($val['tat_start_date'])?$val['tat_start_date']:'-';
						$end_date = isset($val['tat_end_date'])?$val['tat_end_date']:'-';
						if ($start_date !='' && $start_date !=null && $start_date !='-') {
							$date = date('d-m-Y');
						$newDate = date("d-m-Y", strtotime($val['tat_start_date'])); 
							if ($newDate > $date && $val['is_submitted'] !='4') {
								array_push($old, 1);
							}else if($val['is_submitted'] !='4'){
								array_push($new, 1);
							}
						}else{
							array_push($init, 1);
						}
						 
					}
				} 

			return array('init'=>array_sum($init),'new'=>array_sum($new),'old'=>array_sum($old));

	}

	function get_monthly_pending_cases(){
			// $query = "SELECT * FROM ";
		$where = '';
		if ($this->input->post('manager') !='all') {
			$where = array('tbl_client.client_id' =>$this->input->post('manager'));	
			$this->db->where($where);
		} else{
			/*$where = array('active_status'=>'0,1');	
			$this->db->where_in($where);*/
		}

		$result = $this->db->select('tbl_client.*, team_employee.first_name, team_employee.last_name')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->get()->result_array();
		$in_progress_array = array();
		$one_month_array = array();
		$one_month_array_month = array();
		$two_month_array = array();
		$two_month_array_month = array();
		$current_month_array = array();
		$current_month_array_month = array();
		$today_array = array();
		$today_closure_array = array();
		$month_closure_array = array();
		$till_closure_array = array();
		$total_array = array();
			foreach ($result as $key => $value) { 
			$in_progress = $this->db->where('client_id',$value['client_id'])->where('is_submitted =','2')->get('candidate')->num_rows(); 
			$one_month = $this->db->query("SELECT COUNT(candidate_id) as total, monthname(created_date) as month FROM candidate where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() AND is_submitted !=4 AND client_id=".$value['client_id'])->row_array();
				// $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() AND purchased_by = ".$warehouseId."";	 
			$two_month = $this->db->query("SELECT COUNT(candidate_id) as total, monthname(created_date) as month FROM candidate where date(created_date) BETWEEN CURDATE() - INTERVAL 2 MONTH AND CURDATE() AND is_submitted !=4 AND client_id=".$value['client_id'])->row_array();
			$current_month = $this->db->query("SELECT COUNT(candidate_id) as total, monthname(created_date) as month FROM candidate where MONTH(created_date) = MONTH(CURDATE()) AND YEAR(created_date) = YEAR(CURDATE()) AND is_submitted !=4 AND client_id=".$value['client_id'])->row_array();
			$today = $this->db->query("SELECT COUNT(candidate_id) as total, monthname(created_date) as month FROM candidate where MONTH(created_date) = MONTH(CURRENT_DATE()) AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND is_submitted !=4 AND client_id=".$value['client_id'])->row_array();
			$today_closure = $this->db->query("SELECT COUNT(candidate_id) as total, monthname(created_date) as month FROM candidate where MONTH(created_date) = MONTH(CURRENT_DATE()) AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND is_submitted =4 AND client_id=".$value['client_id'])->row_array();
			$month_closure = $this->db->query("SELECT COUNT(candidate_id) as total, monthname(created_date) as month FROM candidate where MONTH(created_date) = MONTH(CURRENT_DATE()) AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND is_submitted =4 AND client_id=".$value['client_id'])->row_array();
			$till_closure = $this->db->query("SELECT * FROM candidate where is_submitted =4 AND client_id=".$value['client_id'])->num_rows();
			$total = $this->db->query("SELECT * FROM candidate where  client_id=".$value['client_id'])->num_rows();
			array_push($total_array, $total);
			array_push($in_progress_array, $in_progress);
			array_push($one_month_array, $one_month['total']);
			array_push($one_month_array_month, $one_month['month']);
			array_push($two_month_array, $two_month['total']);
			array_push($two_month_array_month, $two_month['month']);
			array_push($current_month_array, $current_month['total']);
			array_push($current_month_array_month, $current_month['total']);
			array_push($today_array, $today['total']); 
			array_push($today_closure_array, $month_closure['total']);
			array_push($month_closure_array, $month_closure['total']);
			array_push($till_closure_array, $till_closure);
			 
			}

			return array(
				'in_progress_total'=>array_sum($in_progress_array),
				'one_month_total'=>array_sum($one_month_array),
				'one_month'=>isset($one_month_array_month[0])?$one_month_array_month[0]:'-',
				'two_month_total'=>array_sum($two_month_array),
				'two_month'=>isset($two_month_array_month[0])?$two_month_array_month[0]:'-',
				'current_month_total'=>array_sum($current_month_array),
				'current_month'=>isset($current_month_array_month[0])?$current_month_array_month[0]:'-',
				'today'=>array_sum($today_array),
				'today_closure'=>array_sum($today_closure_array),
				'month_closure'=>array_sum($month_closure_array),
				'till_closure'=>array_sum($till_closure_array),
				'total'=>array_sum($total_array)
			); 


	}



	function all_in_progress_analytics(){
		// number_of_working_days
		// InputQcModel
		$this->load->model('inputQcModel');
		$result = $this->db->where('is_submitted !=','2')->get('candidate')->result_array(); 
		$seven_in_progress = array(); 
		$seven_insuff = array();
		$seven_client_clarification = array();
		$seven_not_init = array();
		$fiftin_in_progress = array(); 
		$fiftin_insuff = array();
		$fiftin_client_clarification = array();
		$fiftin_not_init = array();
		$thirty_in_progress = array(); 
		$thirty_insuff = array();
		$thirty_client_clarification = array();
		$thirty_not_init = array();
		$fortyfive_in_progress = array(); 
		$fortyfive_insuff = array();
		$fortyfive_client_clarification = array();
		$fortyfive_not_init = array();
		$sixty_in_progress = array(); 
		$sixty_insuff = array();
		$sixty_client_clarification = array();
		$sixty_not_init = array();
		foreach ($result as $key => $value) {
			$days = 0; //$this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_end_date']);
			if($value['tat_pause_resume_status'] == 2){

			$days1 = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_pause_date']); 
			$days2 = $this->inputQcModel->number_of_working_days($value['tat_re_start_date'],$value['case_close_date']);
			$days = $days1+$days2;
			}else{
			$days = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['case_close_date']); 
			}
			// is_submitted
			// echo $days."<br>";
			

			if($days >= 0 && $days <= 7){
				if ($value['is_submitted'] == '1') {
					array_push($seven_in_progress,$days); 
				}else if ($value['is_submitted'] == '2') {
					array_push($seven_insuff,$days); 
				}else if($value['is_submitted'] == '0'){
					array_push($seven_not_init,$days); 
				}else{
					array_push($seven_client_clarification,$days);  
				}
			}else if($days >= 8 && $days <= 15){
				if ($value['is_submitted'] == '1') {
					array_push($fiftin_in_progress,$days); 
				}else if ($value['is_submitted'] == '2') {
					array_push($fiftin_insuff,$days); 
				}else if($value['is_submitted'] == '0'){
					array_push($fiftin_not_init,$days); 
				}else{
					array_push($fiftin_client_clarification,$days);  
				}
			}else if($days >= 16 && $days <= 30){
				if ($value['is_submitted'] == '1') {
					array_push($thirty_in_progress,$days); 
				}else if ($value['is_submitted'] == '2') {
					array_push($thirty_insuff,$days); 
				}else if($value['is_submitted'] == '0'){
					array_push($thirty_not_init,$days); 
				}else{
					array_push($thirty_client_clarification,$days);  
				}
			}else if($days >= 31 && $days <= 45){
				if ($value['is_submitted'] == '1') {
					array_push($fortyfive_in_progress,$days); 
				}else if ($value['is_submitted'] == '2') {
					array_push($fortyfive_insuff,$days); 
				}else if($value['is_submitted'] == '0'){
					array_push($fortyfive_not_init,$days); 
				}else{
					array_push($fortyfive_client_clarification,$days);  
				}
			}else if($days >= 60){
				if ($value['is_submitted'] == '1') {
					array_push($sixty_in_progress,$days); 
				}else if ($value['is_submitted'] == '2') {
					array_push($sixty_insuff,$days); 
				}else if($value['is_submitted'] == '0'){
					array_push($sixty_not_init,$days); 
				}else{
					array_push($sixty_client_clarification,$days);  
				}
			} 

		}
		return array(
			'in_progress'=>array(count($seven_in_progress),count($fiftin_in_progress),count($thirty_in_progress),count($fortyfive_in_progress),count($sixty_in_progress)),
			'insuff'=>array(count($seven_insuff),count($fiftin_insuff),count($thirty_insuff),count($fortyfive_insuff),count($sixty_insuff)),
			'client_clarification'=>array(count($seven_client_clarification),count($fiftin_client_clarification),count($thirty_client_clarification),count($fortyfive_client_clarification),count($sixty_client_clarification)),
			'not_init'=>array(count($seven_not_init),count($fiftin_not_init),count($thirty_not_init),count($fortyfive_not_init),count($sixty_not_init))
		);
	}


	function all_in_progress_analytics_inventory(){
		 $result = $this->db->query("SELECT * FROM candidate where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() AND is_submitted IN (0,1)")->result_array();

		$seven_in_progress = array();  
		$seven_not_init = array();
		$fiftin_in_progress = array();  
		$fiftin_not_init = array();
		$thirty_in_progress = array();  
		$thirty_not_init = array();
		$fortyfive_in_progress = array();  
		$fortyfive_not_init = array();
		$sixty_in_progress = array();  
		$sixty_not_init = array();

		foreach ($result as $key => $value) {
			$days = 0; //$this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_end_date']);
			if($value['tat_pause_resume_status'] == 2){

			$days1 = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_pause_date']); 
			$days2 = $this->inputQcModel->number_of_working_days($value['tat_re_start_date'],$value['case_close_date']);
			$days = $days1+$days2;
			}else{
			$days = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['case_close_date']); 
			}
			// is_submitted
			// echo $days."<br>";
			$month = date('m');
			$newDate = date("m", strtotime($value['tat_start_date']));

			if($days >= 0 && $days <= 7){
				if ($month == $newDate) {
					array_push($seven_not_init,$days);  
				}else{
					array_push($seven_in_progress,$days); 
				}
			}else if($days >= 8 && $days <= 15){
				if ($month == $newDate) {
					array_push($fiftin_not_init,$days);  
				}else{
					array_push($fiftin_in_progress,$days); 
				}
			}else if($days >= 16 && $days <= 30){
				if ($month == $newDate) {
					array_push($thirty_not_init,$days);  
				}else{
					array_push($thirty_in_progress,$days); 
				}
			}else if($days >= 31 && $days <= 45){
				if ($month == $newDate) {
					array_push($fortyfive_not_init,$days);  
				}else{
					array_push($fortyfive_in_progress,$days); 
				}
			}else if($days >= 60){
				if ($month == $newDate) {
					array_push($sixty_not_init,$days);  
				}else{
					array_push($sixty_in_progress,$days); 
				}
			} 

		}

		return array(
			'in_progress'=>array(count($seven_in_progress),count($fiftin_in_progress),count($thirty_in_progress),count($fortyfive_in_progress),count($sixty_in_progress)), 
			'not_init'=>array(count($seven_not_init),count($fiftin_not_init),count($thirty_not_init),count($fortyfive_not_init),count($sixty_not_init))
		);
	}


	function all_close_cases_analytics(){
		 $result = $this->db->query("SELECT * FROM candidate where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() AND is_submitted IN (2)")->result_array();

		$seven_in_verified = array();   
		$fiftin_in_verified = array();   
		$thirty_in_verified = array();  
		$fortyfive_verified = array();   
		$sixty_in_verified = array();  

		$seven_in_discrepancy = array();   
		$fiftin_in_discrepancy = array();   
		$thirty_in_discrepancy = array();  
		$fortyfive_discrepancy = array();   
		$sixty_in_discrepancy = array();  

		$seven_in_unable_to_verify = array();   
		$fiftin_in_unable_to_verify = array();   
		$thirty_in_unable_to_verify = array();  
		$fortyfive_unable_to_verify = array();   
		$sixty_in_unable_to_verify = array(); 

		$seven_in_close_insuff = array();   
		$fiftin_in_close_insuff = array();   
		$thirty_in_close_insuff = array();  
		$fortyfive_close_insuff = array();   
		$sixty_in_close_insuff = array(); 

		$seven_in_stop_check = array();   
		$fiftin_in_stop_check = array();   
		$thirty_in_stop_check = array();  
		$fortyfive_stop_check = array();   
		$sixty_in_stop_check = array(); 

		foreach ($result as $key => $value) {
			$status = $this->candidate_closure_status($value['candidate_id']); 
			$days = 0; //$this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_end_date']);
			if($value['tat_pause_resume_status'] == 2){

			$days1 = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_pause_date']); 
			$days2 = $this->inputQcModel->number_of_working_days($value['tat_re_start_date'],$value['case_close_date']);
			$days = $days1+$days2;
			}else{
			$days = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['case_close_date']); 
			}
			// is_submitted
			// echo $days."<br>";
			$month = date('m');
			$newDate = date("m", strtotime($value['tat_start_date']));

			 /*Verified clear - 2,4
			 Verified Discrepancy - 7
			 Unable to Verify - 3,6
			 Closed Insuff - 9
			 Stop check - 5*/

			if($days >= 0 && $days <= 7){
				if(in_array('7', $status)){
					array_push($seven_in_verified,$days);  
				}else if (array_intersect($status, ['3','6'])) {
					array_push($seven_in_discrepancy,$days);  	 
				}else if (in_array('5', $status)) {
					array_push($seven_in_unable_to_verify,$days);  	 
				}else if (in_array('9', $status)) {
					array_push($seven_in_close_insuff,$days);  	 
				}else if (array_intersect($status, ['2','4'])) {
					array_push($seven_in_stop_check,$days);  	 
				}
			}else if($days >= 8 && $days <= 15){
				if(in_array('7', $status)){
					array_push($fiftin_in_verified,$days);  
				}else if (array_intersect($status, ['3','6'])) {
					array_push($fiftin_in_discrepancy,$days);  	 
				}else if (in_array('5', $status)) {
					array_push($fiftin_in_unable_to_verify,$days);  	 
				}else if (in_array('9', $status)) {
					array_push($fiftin_in_close_insuff,$days);  	 
				}else if (array_intersect($status, ['2','4'])) {
					array_push($fiftin_in_stop_check,$days);  	 
				}
			}else if($days >= 16 && $days <= 30){
				if(in_array('7', $status)){
					array_push($thirty_in_verified,$days);  
				}else if (array_intersect($status, ['3','6'])) {
					array_push($thirty_in_discrepancy,$days);  	 
				}else if (in_array('5', $status)) {
					array_push($thirty_in_unable_to_verify,$days);  	 
				}else if (in_array('9', $status)) {
					array_push($thirty_in_close_insuff,$days);  	 
				}else if (array_intersect($status, ['2','4'])) {
					array_push($thirty_in_stop_check,$days);  	 
				}
			}else if($days >= 31 && $days <= 45){
				if(in_array('7', $status)){
					array_push($fortyfive_verified,$days);  
				}else if (array_intersect($status, ['3','6'])) {
					array_push($fortyfive_discrepancy,$days);  	 
				}else if (in_array('5', $status)) {
					array_push($fortyfive_unable_to_verify,$days);  	 
				}else if (in_array('9', $status)) {
					array_push($fortyfive_close_insuff,$days);  	 
				}else if (array_intersect($status, ['2','4'])) {
					array_push($fortyfive_stop_check,$days);  	 
				}
			}else if($days >= 60){
				if(in_array('7', $status)){
					array_push($sixty_in_verified,$days);  
				}else if (array_intersect($status, ['3','6'])) {
					array_push($sixty_in_discrepancy,$days);  	 
				}else if (in_array('5', $status)) {
					array_push($sixty_in_unable_to_verify,$days);  	 
				}else if (in_array('9', $status)) {
					array_push($sixty_in_close_insuff,$days);  	 
				}else if (array_intersect($status, ['2','4'])) {
					array_push($sixty_in_stop_check,$days);  	 
				}
			} 

		} 

		return array(
			'verified'=>array(count($seven_in_verified),count($fiftin_in_verified),count($thirty_in_verified),count($fortyfive_verified),count($sixty_in_verified)), 
			'discrepancy'=>array(count($seven_in_discrepancy),count($fiftin_in_discrepancy),count($thirty_in_discrepancy),count($fortyfive_discrepancy),count($sixty_in_discrepancy)), 
			'unable_to_verify'=>array(count($seven_in_unable_to_verify),count($fiftin_in_unable_to_verify),count($thirty_in_unable_to_verify),count($fortyfive_unable_to_verify),count($sixty_in_unable_to_verify)), 
			'close_insuff'=>array(count($seven_in_close_insuff),count($fiftin_in_close_insuff),count($thirty_in_close_insuff),count($fortyfive_close_insuff),count($sixty_in_close_insuff)), 
			'stop_check'=>array(count($seven_in_stop_check),count($fiftin_in_stop_check),count($thirty_in_stop_check),count($fortyfive_stop_check),count($sixty_in_stop_check))
		);
	}



	function candidate_closure_status($candidate_id){
		$this->load->model('adminViewAllCaseModel');
		 $candidate_status = $this->adminViewAllCaseModel->getSingleAssignedCaseDetails($candidate_id);
		$form_analyst_status = array();
		if (count($candidate_status) > 0) { 
		    foreach ($candidate_status as $kc => $comp) {
		        array_push($form_analyst_status, isset($comp['analyst_status'])?$comp['analyst_status']:0);
		    }
		}
		return $form_analyst_status;
	}



	function all_component_ageing_in_progress_analytics(){
		$this->load->model('outPutQcModel');
		$where = '';
		if ($this->input->post('manager') !='all') {
			$where = 'client_id = '.$this->input->post('manager').' AND ';
		}
		 $result = $this->db->query("SELECT * FROM candidate where ".$where." is_submitted IN (0,1)")->result_array();
		 // $this->outPutQcModel->getSingleAssignedCaseDetails();
		 $groups = array(); 
		 foreach ($result as $key => $value) {
		 	 $status ='';
		 	if ($this->input->post('candidate') == 'all') { 
		 	  $status = $this->outPutQcModel->getSingleAssignedCaseDetails($value['candidate_id']);
		 	}else if($this->input->post('candidate') == $value['candidate_id']){
		 		 $status = $this->outPutQcModel->getSingleAssignedCaseDetails($value['candidate_id']);
		 	}
		 	 
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
 


	function all_component_ageing_completed_analytics(){
		$this->load->model('outPutQcModel');
		$where = '';
		if ($this->input->post('manager') !='all') {
			$where = 'client_id = '.$this->input->post('manager').' AND ';
		}
		 $result = $this->db->query("SELECT * FROM candidate where ".$where." is_submitted NOT IN (0,1)")->result_array();
		 // $this->outPutQcModel->getSingleAssignedCaseDetails();
		 $groups = array(); 
		 foreach ($result as $key => $value) {
		 	   $status ='';
		 	if ($this->input->post('candidate') == 'all') { 
		 	  $status = $this->outPutQcModel->getSingleAssignedCaseDetails($value['candidate_id']);
		 	}else if($this->input->post('candidate') == $value['candidate_id']){
		 		 $status = $this->outPutQcModel->getSingleAssignedCaseDetails($value['candidate_id']);
		 	}
		 	 foreach ($status as $k => $val) {

		 	 $array_key = str_replace(" ", "_", strtolower($val['component_name']));
		        	$analyst = isset($val['component_data']['analyst_status'])?$val['component_data']['analyst_status']:0;
 				$analyst_status = explode(',',$analyst);

 				 /*Verified clear - 2,4
			 Verified Discrepancy - 7
			 Unable to Verify - 3,6
			 Closed Insuff - 9
			 Stop check - 5*/
			 $verified = isset($groups[$array_key]['verified'])?$groups[$array_key]['verified']:0;
			 $discrepancy = isset($groups[$array_key]['discrepancy'])?$groups[$array_key]['discrepancy']:0;
			 $unable_to_verify = isset($groups[$array_key]['unable_to_verify'])?$groups[$array_key]['unable_to_verify']:0;
			 $close_insuff = isset($groups[$array_key]['close_insuff'])?$groups[$array_key]['close_insuff']:0;
			 $stop_check =isset($groups[$array_key]['stop_check'])?$groups[$array_key]['stop_check']:0;

		        	$total_array = 0;
		        if (!array_key_exists($array_key, $groups)) {
				if(in_array('7', $analyst_status)){
				 $discrepancy =1;
				 $total_array = 1;
				}else if (array_intersect($analyst_status, ['3','6'])) {
				  $unable_to_verify =1;
				  $total_array = 1;
				}else if (in_array('5', $analyst_status)) {
					$stop_check = 1;
					$total_array = 1;
				}else if (in_array('8', $analyst_status)) {
					// $client_clarification = 1;
				}else if (in_array('9', $analyst_status)) {
					$close_insuff = 1;
					$total_array = 1;
				}else if (array_intersect($analyst_status, ['2','4'])) {
					  	 $verified = 1;
					  	 $total_array = 1;
				}else if(in_array('1', $analyst_status)){
					// $in_progress = 1;
				}else{
					 // $new = 1;
				}

		 	 	  $groups[$array_key] = array(
		                'component_id' => $val['component_id'], 
		                'component_name' => $val['component_name'], 
		                'verified' => $verified, 
		                'discrepancy' => $discrepancy, 
		                'unable_to_verify' => $unable_to_verify, 
		                'close_insuff' => $close_insuff, 
		                'stop_check' => $stop_check, 
		                'total' => $total_array, 
 
		            ); 
		 	 	}else{

		 	 	if(in_array('7', $analyst_status)){
				 $discrepancy = (int)$groups[$array_key]['discrepancy'] + 1;
				 $total_array = 1;
				}else if (array_intersect($analyst_status, ['3','6'])) {
				  $unable_to_verify = (int)$groups[$array_key]['unable_to_verify'] + 1;
				  $total_array = 1;
				}else if (in_array('5', $analyst_status)) {
					$stop_check = (int)$groups[$array_key]['stop_check'] + 1;
					$total_array = 1;
				}else if (in_array('8', $analyst_status)) {
					// $client_clarification = 1;
				}else if (in_array('9', $analyst_status)) {
					$close_insuff = (int)$groups[$array_key]['close_insuff'] + 1;
					$total_array = 1;
				}else if (array_intersect($analyst_status, ['2','4'])) {
					  	 $verified = (int)$groups[$array_key]['verified'] + 1;
					  	 $total_array = 1;
				}else if(in_array('1', $analyst_status)){
					// $in_progress = 1;
				}else{
					 // $new = 1;
				}
		 	 	 
		 	 	  $groups[$array_key] = array(
		                'component_id' => $val['component_id'], 
		                'component_name' => $val['component_name'], 
		                'verified' => $verified, 
		                'discrepancy' => $discrepancy, 
		                'unable_to_verify' => $unable_to_verify, 
		                'close_insuff' => $close_insuff, 
		                'stop_check' => $stop_check,
		                'total' => (int)$groups[$array_key]['total'] + (int)$total_array,   
		            );
		 	 	}
		 	 	
 				// echo json_encode($groups[$array_key]);
		 	 }
		 }

		  return $groups;

	}

 // pending by ay wise
 	function all_component_ageing_pending_days_analytics(){
		$this->load->model('outPutQcModel');
		$where = '';
		if ($this->input->post('manager') !='all') {
			$where = 'client_id = '.$this->input->post('manager').' AND ';
		}
		 $result = $this->db->query("SELECT * FROM candidate where ".$where." is_submitted IN (0,1)")->result_array();
		 // $this->outPutQcModel->getSingleAssignedCaseDetails();
		 $groups = array(); 
		 foreach ($result as $key => $value) {
		 	  $status ='';
		 	if ($this->input->post('candidate') == 'all') { 
		 	  $status = $this->outPutQcModel->getSingleAssignedCaseDetails($value['candidate_id']);
		 	}else if($this->input->post('candidate') == $value['candidate_id']){
		 		 $status = $this->outPutQcModel->getSingleAssignedCaseDetails($value['candidate_id']);
		 	}
		 	  $days = 0; //$this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_end_date']);
			if($value['tat_pause_resume_status'] == 2){

			$days1 = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_pause_date']); 
			$days2 = $this->inputQcModel->number_of_working_days($value['tat_re_start_date'],$value['case_close_date']);
			$days = $days1+$days2;
			}else{
			$days = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['case_close_date']); 
			}
			// is_submitted
			// echo $days."<br>";
			$month = date('m');
			$newDate = date("m", strtotime($value['tat_start_date']));
			 
			
		 	 
		 	 foreach ($status as $k => $val) {

		 	 $array_key = str_replace(" ", "_", strtolower($val['component_name']));
		        	$analyst = isset($val['component_data']['analyst_status'])?$val['component_data']['analyst_status']:0;
 				$analyst_status = explode(',',$analyst);

 				$seven = isset($groups[$array_key]['seven'])?$groups[$array_key]['seven']:0;
			$fiftin = isset($groups[$array_key]['fiftin'])?$groups[$array_key]['fiftin']:0;
			$thirty = isset($groups[$array_key]['thirty'])?$groups[$array_key]['thirty']:0;
			$fortyfive = isset($groups[$array_key]['fortyfive'])?$groups[$array_key]['fortyfive']:0;
			$fortysix = isset($groups[$array_key]['fortysix'])?$groups[$array_key]['fortysix']:0;
			$sixty = isset($groups[$array_key]['sixty'])?$groups[$array_key]['sixty']:0;

		       $total_array = 0;
		        if (!array_key_exists($array_key, $groups)) {
		        	 
		        	if($days >= 0 && $days <= 7){
						$seven = 1;
						$total_array = 1;
					}else if($days >= 8 && $days <= 15){
						$fiftin = 1;
						$total_array = 1;
					}else if($days >= 16 && $days <= 30){
						$thirty = 1;
						$total_array = 1;
					}else if($days >= 31 && $days <= 45){
						$fortyfive = 1;
						$total_array = 1;
					}else if($days >= 46 && $days <= 60){
						$fortysix =  1;
						$total_array = 1;
					}else{
						$sixty = 1;
						$total_array = 1;
					} 
 
		 	 	  $groups[$array_key] = array(
		                'component_id' => $val['component_id'], 
		                'component_name' => $val['component_name'], 
		                'seven' => $seven, 
		                'fiftin' => $fiftin, 
		                'thirty' => $thirty, 
		                'fortyfive' => $fortyfive, 
		                'fortysix' => $fortysix, 
		                'sixty' => $sixty, 
		                'total' =>$total_array, 
 
		            ); 

		 	 	}else{
		 	 	 
  				if($days >= 0 && $days <= 7){
					$seven = (int)$groups[$array_key]['seven'] + 1;
					$total_array = 1;
				}else if($days >= 8 && $days <= 15){
					$fiftin = (int)$groups[$array_key]['fiftin'] + 1;
					$total_array = 1;
				}else if($days >= 16 && $days <= 30){
					$thirty = (int)$groups[$array_key]['thirty'] + 1;
					$total_array = 1;
				}else if($days >= 31 && $days <= 45){
					$fortyfive = (int)$groups[$array_key]['fortyfive'] + 1;
					$total_array = 1;
				}else if($days >= 46 && $days <= 60){
					$fortysix = (int)$groups[$array_key]['fortysix'] + 1;
					$total_array = 1;
				}else if($days > 60){
					$sixty = (int)$groups[$array_key]['sixty'] + 1;
					$total_array = 1;
				} 

				$total_count = 0;
				$total_count = (int)$groups[$array_key]['total'] + (int)$total_array;
		 	 	  $groups[$array_key] = array(
		                'component_id' => $val['component_id'], 
		                'component_name' => $val['component_name'], 
		                'seven' => $seven, 
		                'fiftin' => $fiftin, 
		                'thirty' => $thirty, 
		                'fortyfive' => $fortyfive, 
		                'fortysix' => $fortysix, 
		                'sixty' => $sixty, 
		                'total' => $total_count,   
		            );
		 	 	}
		 	 	
 				
		 	 }
		 }

		  return $groups;

	}
 

	//completed by day wise 
	function all_component_ageing_completed_days_analytics(){
		$this->load->model('outPutQcModel');
		$where = '';
		if ($this->input->post('manager') !='all') {
			$where = 'client_id = '.$this->input->post('manager').' AND ';
		}
		 $result = $this->db->query("SELECT * FROM candidate where ".$where." is_submitted NOT IN (0,1)")->result_array();
		 // $this->outPutQcModel->getSingleAssignedCaseDetails();
		 $groups = array(); 
		 foreach ($result as $key => $value) {
		 	   $status ='';
			 	if ($this->input->post('candidate') == 'all') { 
			 	  $status = $this->outPutQcModel->getSingleAssignedCaseDetails($value['candidate_id']);
			 	}else if($this->input->post('candidate') == $value['candidate_id']){
			 		 $status = $this->outPutQcModel->getSingleAssignedCaseDetails($value['candidate_id']);
			 	}
		 	  $days = 0; //$this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_end_date']);
			if($value['tat_pause_resume_status'] == 2){

			$days1 = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_pause_date']); 
			$days2 = $this->inputQcModel->number_of_working_days($value['tat_re_start_date'],$value['case_close_date']);
			$days = $days1+$days2;
			}else{
			$days = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['case_close_date']); 
			}
			// is_submitted
			// echo $days."<br>";
			$month = date('m');
			$newDate = date("m", strtotime($value['tat_start_date']));
			
			
		 	 
		 	 foreach ($status as $k => $val) {

		 	 $array_key = str_replace(" ", "_", strtolower($val['component_name']));
		        	$analyst = isset($val['component_data']['analyst_status'])?$val['component_data']['analyst_status']:0;
 				$analyst_status = explode(',',$analyst);

 				$seven = isset($groups[$array_key]['seven'])?$groups[$array_key]['seven']:0;
			$fiftin = isset($groups[$array_key]['fiftin'])?$groups[$array_key]['fiftin']:0;
			$thirty = isset($groups[$array_key]['thirty'])?$groups[$array_key]['thirty']:0;
			$fortyfive = isset($groups[$array_key]['fortyfive'])?$groups[$array_key]['fortyfive']:0;
			$fortysix = isset($groups[$array_key]['fortysix'])?$groups[$array_key]['fortysix']:0;
			$sixty = isset($groups[$array_key]['sixty'])?$groups[$array_key]['sixty']:0;

		       $total_array = 0;
		        if (!array_key_exists($array_key, $groups)) {
		        	 
		        	if($days >= 0 && $days <= 7){
						$seven = 1;
						$total_array = 1;
					}else if($days >= 8 && $days <= 15){
						$fiftin = 1;
						$total_array = 1;
					}else if($days >= 16 && $days <= 30){
						$thirty = 1;
						$total_array = 1;
					}else if($days >= 31 && $days <= 45){
						$fortyfive = 1;
						$total_array = 1;
					}else if($days >= 46 && $days <= 60){
						$fortysix =  1;
						$total_array = 1;
					}else{
						$sixty = 1;
						$total_array = 1;
					} 
 
		 	 	  $groups[$array_key] = array(
		                'component_id' => $val['component_id'], 
		                'component_name' => $val['component_name'], 
		                'seven' => $seven, 
		                'fiftin' => $fiftin, 
		                'thirty' => $thirty, 
		                'fortyfive' => $fortyfive, 
		                'fortysix' => $fortysix, 
		                'sixty' => $sixty, 
		                'total' =>$total_array, 
 
		            ); 

		 	 	}else{
		 	 	 
  				if($days >= 0 && $days <= 7){
					$seven = (int)$groups[$array_key]['seven'] + 1;
					$total_array = 1;
				}else if($days >= 8 && $days <= 15){
					$fiftin = (int)$groups[$array_key]['fiftin'] + 1;
					$total_array = 1;
				}else if($days >= 16 && $days <= 30){
					$thirty = (int)$groups[$array_key]['thirty'] + 1;
					$total_array = 1;
				}else if($days >= 31 && $days <= 45){
					$fortyfive = (int)$groups[$array_key]['fortyfive'] + 1;
					$total_array = 1;
				}else if($days >= 46 && $days <= 60){
					$fortysix = (int)$groups[$array_key]['fortysix'] + 1;
					$total_array = 1;
				}else if($days > 60){
					$sixty = (int)$groups[$array_key]['sixty'] + 1;
					$total_array = 1;
				} 

				$total_count = 0;
				$total_count = (int)$groups[$array_key]['total'] + (int)$total_array;
		 	 	  $groups[$array_key] = array(
		                'component_id' => $val['component_id'], 
		                'component_name' => $val['component_name'], 
		                'seven' => $seven, 
		                'fiftin' => $fiftin, 
		                'thirty' => $thirty, 
		                'fortyfive' => $fortyfive, 
		                'fortysix' => $fortysix, 
		                'sixty' => $sixty, 
		                'total' => $total_count,   
		            );
		 	 	}
		 	 // echo json_encode($groups[$array_key]);	
 				
		 	 }
		 }

		  return $groups;

	}

	function for_the_client_ageing_report(){
		$client = $this->db->query('SELECT * FROM tbl_client where active_status=1  ORDER BY client_id DESC')->result_array();
		$groups = array();

		foreach ($client as $key => $val) {
		        $where ='';
        if ($this->input->post('duration') == 'today') {
          $where=" where date(created_date) = CURDATE() AND client_id=".$val['client_id'];
        }else if($this->input->post('duration') == 'week'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() AND client_id=".$val['client_id'];
        }else if($this->input->post('duration') == 'month'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() AND client_id=".$val['client_id'];
        }else if($this->input->post('duration') == 'year'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE() AND client_id=".$val['client_id'];
        }else if($this->input->post('duration') == 'between'){
          $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."' AND client_id=".$val['client_id'];
        }else{
            $where="where client_id=".$val['client_id'];
        }
			$this->load->model('outPutQcModel');
 			$result = $this->db->query("SELECT * FROM candidate  ".$where." AND is_submitted IN (0,1)")->result_array();
		 // $this->outPutQcModel->getSingleAssignedCaseDetails();
		 // $groups = array(); 
		 foreach ($result as $key => $value) {
		 	  $status ='';
		 	if ($this->input->post('candidate') == 'all') { 
		 	  $status = $this->outPutQcModel->getSingleAssignedCaseDetails($value['candidate_id']);
		 	}else if($this->input->post('candidate') == $value['candidate_id']){
		 		 $status = $this->outPutQcModel->getSingleAssignedCaseDetails($value['candidate_id']);
		 	}
		 	  $days = 0; //$this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_end_date']);
			if($value['tat_pause_resume_status'] == 2){

			$days1 = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['tat_pause_date']); 
			$days2 = $this->inputQcModel->number_of_working_days($value['tat_re_start_date'],$value['case_close_date']);
			$days = $days1+$days2;
			}else{
			$days = $this->inputQcModel->number_of_working_days($value['tat_start_date'],$value['case_close_date']); 
			}
			// is_submitted
			// echo $days."<br>";
			$month = date('m');
			$newDate = date("m", strtotime($value['tat_start_date']));
			 
			 $array_key = $val['client_id']; 

 				$seven = isset($groups[$array_key]['seven'])?$groups[$array_key]['seven']:0;
			$fiftin = isset($groups[$array_key]['fiftin'])?$groups[$array_key]['fiftin']:0;
			$thirty = isset($groups[$array_key]['thirty'])?$groups[$array_key]['thirty']:0;
			$fortyfive = isset($groups[$array_key]['fortyfive'])?$groups[$array_key]['fortyfive']:0;
			$fortysix = isset($groups[$array_key]['fortysix'])?$groups[$array_key]['fortysix']:0;
			$sixty = isset($groups[$array_key]['sixty'])?$groups[$array_key]['sixty']:0;

		       $total_array = 0;
		        if (!array_key_exists($array_key, $groups)) {
		        	 
		        	/*if($days >= 0 && $days <= 7){
						$seven = 1;
						$total_array = 1;
					}else */if($days >= 0 && $days <= 15){
						$fiftin = 1;
						$total_array = 1;
					}else if($days >= 16 && $days <= 30){
						$thirty = 1;
						$total_array = 1;
					}else if($days >= 31 && $days <= 45){
						$fortyfive = 1;
						$total_array = 1;
					}/*else if($days >= 46 && $days <= 60){
						$fortysix =  1;
						$total_array = 1;
					}*/else{
						$sixty = 1;
						$total_array = 1;
					} 
 
		 	 	  $groups[$array_key] = array(
		                'client_id' => $val['client_id'], 
		                'client_name' => $val['client_name'], 
		                'seven' => $seven, 
		                'fiftin' => $fiftin, 
		                'thirty' => $thirty, 
		                'fortyfive' => $fortyfive, 
		                'fortysix' => $fortysix, 
		                'sixty' => $sixty, 
		                'total' =>$total_array, 
 
		            ); 

		 	 	}else{
		 	 	 
  				/*if($days >= 0 && $days <= 7){
					$seven = (int)$groups[$array_key]['seven'] + 1;
					$total_array = 1;
				}else */if($days >= 0 && $days <= 15){
					$fiftin = (int)$groups[$array_key]['fiftin'] + 1;
					$total_array = 1;
				}else if($days >= 16 && $days <= 30){
					$thirty = (int)$groups[$array_key]['thirty'] + 1;
					$total_array = 1;
				}else if($days >= 31 && $days <= 45){
					$fortyfive = (int)$groups[$array_key]['fortyfive'] + 1;
					$total_array = 1;
				}else /*if($days >= 46 && $days <= 60){
					$fortysix = (int)$groups[$array_key]['fortysix'] + 1;
					$total_array = 1;
				}else if($days > 60)*/{
					$sixty = (int)$groups[$array_key]['sixty'] + 1;
					$total_array = 1;
				} 

				$total_count = 0;
				$total_count = (int)$groups[$array_key]['total'] + (int)$total_array;
		 	 	  $groups[$array_key] = array(
		                'client_id' => $val['client_id'], 
		                'client_name' => $val['client_name'], 
		                'seven' => $seven, 
		                'fiftin' => $fiftin, 
		                'thirty' => $thirty, 
		                'fortyfive' => $fortyfive, 
		                'fortysix' => $fortysix, 
		                'sixty' => $sixty, 
		                'total' => $total_count,   
		            );
		 	 	}
		 	 
		}

		}

		return $groups;

	}


	function component_wise_status_check(){
		$this->load->model('adminViewAllCaseModel');
		        $where ='';
        if ($this->input->post('duration') == 'today') {
          $where=" where date(created_date) = CURDATE()";
        }else if($this->input->post('duration') == 'week'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()";
        }else if($this->input->post('duration') == 'month'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE()";
        }else if($this->input->post('duration') == 'year'){
          $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE()";
        }else if($this->input->post('duration') == 'between'){
          $where=" where date(created_date) BETWEEN  '".$_POST['from']."' AND '".$_POST['to']."'";
        }else{
            $where="";
        }

        $data = $this->db->query('SELECT * FROM candidate '.$where.'  ORDER BY candidate_id DESC')->result_array();
 
            $all_cases = array();
            $groups = array();

            foreach ($data as $key => $value) {
                 // print_r($value['client']['client_name']);

                // echo $value['candidate_id']."<br>";
                $cases = $this->adminViewAllCaseModel->getmultiAssignedCaseDetails($value['candidate_id']);
               

                 foreach ($cases as $k => $val) {
                     if ($this->input->post('component_id') !='') {
                        if ($this->input->post('component_id') == $val['component_id']) { 
                         // $all_cases[$k] = $val;
                         // array_push($all_cases, $val);
                        	 $array_key = str_replace(" ", "_", strtolower($val['component_name']));
		        	$analyst = isset($val['component_data']['analyst_status'])?$val['component_data']['analyst_status']:0;
 					$analyst_status = explode(',',$analyst);
 
						 $verified = isset($groups[0]['verified'])?$groups[0]['verified']:0;
						 $discrepancy = isset($groups[0]['discrepancy'])?$groups[0]['discrepancy']:0;
						 $unable_to_verify = isset($groups[0]['unable_to_verify'])?$groups[0]['unable_to_verify']:0;
						 $close_insuff = isset($groups[0]['close_insuff'])?$groups[0]['close_insuff']:0;
						 $stop_check =isset($groups[0]['stop_check'])?$groups[0]['stop_check']:0;

					        	$total_array = 0;
					        if (!array_key_exists(0, $groups)) {
							if(in_array('7', $analyst_status)){
							 $discrepancy =1;
							 $total_array = 1;
							}else if (array_intersect($analyst_status, ['3','6'])) {
							  $unable_to_verify =1;
							  $total_array = 1;
							}else if (in_array('5', $analyst_status)) {
								$stop_check = 1;
								$total_array = 1;
							}else if (in_array('8', $analyst_status)) {
								// $client_clarification = 1;
							}else if (in_array('9', $analyst_status)) {
								$close_insuff = 1;
								$total_array = 1;
							}else if (array_intersect($analyst_status, ['2','4'])) {
								  	 $verified = 1;
								  	 $total_array = 1;
							}else if(in_array('1', $analyst_status)){
								// $in_progress = 1;
							}else{
								 // $new = 1;
							}

					 	 	  $groups[0] = array(
					                'component_id' => $val['component_id'], 
					                'component_name' => $val['component_name'], 
					                'verified' => $verified, 
					                'discrepancy' => $discrepancy, 
					                'unable_to_verify' => $unable_to_verify, 
					                'close_insuff' => $close_insuff, 
					                'stop_check' => $stop_check, 
					                'total' => $total_array, 
			 
					            ); 
					 	 	}else{

					 	 	if(in_array('7', $analyst_status)){
							 $discrepancy = (int)$groups[0]['discrepancy'] + 1;
							 $total_array = 1;
							}else if (array_intersect($analyst_status, ['3','6'])) {
							  $unable_to_verify = (int)$groups[0]['unable_to_verify'] + 1;
							  $total_array = 1;
							}else if (in_array('5', $analyst_status)) {
								$stop_check = (int)$groups[0]['stop_check'] + 1;
								$total_array = 1;
							}else if (in_array('8', $analyst_status)) {
								// $client_clarification = 1;
							}else if (in_array('9', $analyst_status)) {
								$close_insuff = (int)$groups[0]['close_insuff'] + 1;
								$total_array = 1;
							}else if (array_intersect($analyst_status, ['2','4'])) {
								  	 $verified = (int)$groups[0]['verified'] + 1;
								  	 $total_array = 1;
							}else if(in_array('1', $analyst_status)){
								// $in_progress = 1;
							}else{
								 // $new = 1;
							}
					 	 	 
					 	 	  $groups[0] = array(
					                'component_id' => $val['component_id'], 
					                'component_name' => $val['component_name'], 
					                'verified' => $verified, 
					                'discrepancy' => $discrepancy, 
					                'unable_to_verify' => $unable_to_verify, 
					                'close_insuff' => $close_insuff, 
					                'stop_check' => $stop_check,
					                'total' => (int)$groups[0]['total'] + (int)$total_array,   
					            );
					 	 	}

                        }
                     }else{
                       // $all_cases[$k] = $val; 
                       // array_push($all_cases, $val);
                     }
                     

                     // array_push($all_cases, $row);
                 }
            }

            return $groups;
	}
 

}