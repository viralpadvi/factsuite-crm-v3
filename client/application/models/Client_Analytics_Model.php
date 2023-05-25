<?php 

/**
 * 
 */
class Client_Analytics_Model extends CI_Model
{
	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url'); 
	  	$this->load->model('caseModel');         
	}	

	function get_all_clients(){
		$user = $this->session->userdata('logged-in-client'); 
		$result = $this->db->where('client_id',$user['client_id'])->get('tbl_client')->row_array(); 
		$sub_result = $this->db->where('is_master',$user['client_id'])->get('tbl_client')->result_array();
	 return array('parent'=>$result, 'child'=>$sub_result);
	}

	function get_all_client_wise_inventory_cases(){
		// $query = "SELECT * FROM ";
		$client_ids = array();
		if ($this->input->post('client') == '0') {
			$data = $this->get_all_clients(); 
			array_push($client_ids,$data['parent']['client_id']);
			if (count($data['child']) > 0) {
				foreach ($data['child'] as $key => $value) {
					array_push($client_ids,$value['client_id']);
				}
			}
		}else{
			array_push($client_ids,$this->input->post('client'));
		}
		$user = $this->session->userdata('logged-in-client');
		$where = '';
		if ($this->input->post('manager') !='all' && $this->input->post('status') =='inactive') {
			$where = array('tbl_client.account_manager_name' =>$user['client_id'],'tbl_client.active_status'=>0);	
			$this->db->where($where);
		} else if ($this->input->post('manager') !='all' && $this->input->post('status') =='active'){
			$where = array('tbl_client.account_manager_name' =>$this->input->post('manager'),'tbl_client.active_status'=>1);	
			$this->db->where($where);
		}else{
			// $where = array('active_status'=>'0,1');	
		}
		$query ='';
		if ($this->input->post('date_pick') !='' && $this->input->post('date_pick') !=null) {
			$date = explode('-',$this->input->post('date_pick'));
			$newDate = date("Y-m-d", strtotime($date[0]));
			$newDate1 = date("Y-m-d", strtotime($date[1]));
			$query = ' AND date(created_date) BETWEEN  "'.$newDate.'" AND "'.$newDate1.'" ';
		}
		 $q = implode(',', $client_ids);
		 if ($user !='' && $user !=null && count($client_ids)==0) {
		 	$q1 = $user['client_id'];
		 }else{ 
		    $q1 = isset($q)?$q:$user['client_id'];
		 }

		if ($q1 == 0 || $q1 ==null || $q1 == '' || $q1 == 'null') {
			$q1 = $user['client_id'];
		}

	

		 $query_main ='client_id IN ( '.$q1.' ) ';

		// $result = $this->db->select('tbl_client.*, team_employee.first_name, team_employee.last_name')->from('tbl_client')->join('team_employee','tbl_client.account_manager_name = team_employee.team_id','left')->where('tbl_client.account_manager_name',$user['client_id'])->get()->result_array();
		// $result = $this->db->query($query);
		// return $result;
		$client_data = array();
		$completed = array();
		$pending = array();
		$init = array();
		$insuff = array();
		$aproved = array();
		 $qa = 'SELECT * FROM candidate WHERE '.$query_main.$query;
		$total = $this->db->query($qa)->num_rows();
		// foreach ($result as $key => $value) {
		// 	$row = $value; 
			$count_completed = $this->db->query('SELECT * FROM candidate WHERE (is_submitted = 2 OR is_submitted = 4) AND '.$query_main.$query)->num_rows();
			$count_progress = $this->db->query('SELECT * FROM candidate WHERE is_submitted = 1 AND '.$query_main.$query)->num_rows();
			$count_not_init = $this->db->query('SELECT * FROM candidate WHERE is_submitted = 0 AND '.$query_main.$query)->num_rows();
			$count_insuff = $this->db->query('SELECT * FROM candidate WHERE is_submitted = 3 AND '.$query_main.$query)->num_rows();
			$count_approved = $this->db->query('SELECT * FROM candidate WHERE (is_submitted = 2 OR is_submitted = 4) AND '.$query_main.$query)->num_rows();
			/*array_push($row,array('completed_case'=>$count_completed,'progress_case'=>$count_progress,'insuff_case'=>$count_progress,'approved_case'=>$count_insuff));*/



			// array_push($row,array('completed_case'=>$count_completed,'progress_case'=>$count_progress));

			if ($this->input->post('status') =='0') {
				array_push($init,$count_not_init);
			}else if ($this->input->post('status') =='1') {
				array_push($pending,$count_progress); 
			}else if ($this->input->post('status') =='2') { 
				array_push($completed,$count_completed);
			}else if ($this->input->post('status') =='3') {
				array_push($insuff,$count_insuff);
			}else{
				array_push($init,$count_not_init);
				array_push($pending,$count_progress); 
				array_push($completed,$count_completed);	
				array_push($insuff,$count_insuff);
			}
			
			array_push($aproved,$count_approved);
			// array_push($client_data,$row);
		// }

			$clarification = $this->get_client_clarification($q1);
			return array('completed'=>array_sum($completed),'pending'=>array_sum($pending),'insuff'=>array_sum($insuff),'aproved'=>array_sum($aproved),'total'=>$total,'init'=>array_sum($init),'clarification'=>count($clarification));

	}

	function get_client_clarification($q1){
		$q = 'SELECT * FROM candidate WHERE  client_id IN ( '.$q1.' ) ';
		$result = $this->db->query($q)->result_array();
		$analyst_array = array();
		foreach ($result as $key => $value) {
			 $analyst = $this->caseModel->getSingleAssignedCaseDetails($value['candidate_id']);
			 foreach ($analyst as $key => $val) {
			 	if ($val['analyst_status'] == '8') {
			 		array_push($analyst_array,$val['analyst_status']);
			 	}
			 }
		}
		return $analyst_array;
	}



		function get_monthly_pending_cases(){
			// $query = "SELECT * FROM ";
			$user = $this->session->userdata('logged-in-client');
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
			// foreach ($result as $key => $value) { 
			$in_progress = $this->db->where('client_id',$user['client_id'])->where('is_submitted =','2')->get('candidate')->num_rows(); 
			$one_month = $this->db->query("SELECT COUNT(candidate_id) as total, monthname(created_date) as month FROM candidate where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() AND is_submitted !=2 AND client_id=".$user['client_id'])->row_array();
				// $where=" where date(created_date) BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() AND purchased_by = ".$warehouseId."";	 
			$two_month = $this->db->query("SELECT COUNT(candidate_id) as total, monthname(created_date) as month FROM candidate where date(created_date) BETWEEN CURDATE() - INTERVAL 2 MONTH AND CURDATE() AND is_submitted !=2 AND client_id=".$user['client_id'])->row_array();
			$current_month = $this->db->query("SELECT COUNT(candidate_id) as total, monthname(created_date) as month FROM candidate where MONTH(created_date) = MONTH(CURDATE()) AND YEAR(created_date) = YEAR(CURDATE()) AND is_submitted !=2 AND client_id=".$user['client_id'])->row_array();
			$today = $this->db->query("SELECT COUNT(candidate_id) as total, monthname(created_date) as month FROM candidate where MONTH(created_date) = MONTH(CURRENT_DATE()) AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND is_submitted !=2 AND client_id=".$user['client_id'])->row_array();
			$today_closure = $this->db->query("SELECT COUNT(candidate_id) as total, monthname(created_date) as month FROM candidate where MONTH(created_date) = MONTH(CURRENT_DATE()) AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND is_submitted =2 AND client_id=".$user['client_id'])->row_array();
			$month_closure = $this->db->query("SELECT COUNT(candidate_id) as total, monthname(created_date) as month FROM candidate where MONTH(created_date) = MONTH(CURRENT_DATE()) AND YEAR(created_date) = YEAR(CURRENT_DATE()) AND is_submitted =2 AND client_id=".$user['client_id'])->row_array();
			$till_closure = $this->db->query("SELECT * FROM candidate where is_submitted =2 AND client_id=".$user['client_id'])->num_rows();
			$total = $this->db->query("SELECT * FROM candidate where  client_id=".$user['client_id'])->num_rows();
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
			 
			// }

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


//
	function get_data_yearly(){

		$client_ids = array();
		if ($this->input->post('client') == '0') {
			$data = $this->get_all_clients(); 
			array_push($client_ids,$data['parent']['client_id']);
			if (count($data['child']) > 0) {
				foreach ($data['child'] as $key => $value) {
					array_push($client_ids,$value['client_id']);
				}
			}
		}else{
			array_push($client_ids,$this->input->post('client'));
		}

		$user = $this->session->userdata('logged-in-client');
		$query ='';
		$is_submitted ='';
		$select_date ='created_date';
		if ($this->input->post('status') =='0') {
			$is_submitted = ' AND is_submitted = 0 ';
			$select_date ='created_date';
		}else if ($this->input->post('status') =='1') {
			$is_submitted = ' AND is_submitted = 1 ';
			$select_date ='case_submitted_date';
		}else if ($this->input->post('status') =='2') { 
			$is_submitted = ' AND is_submitted = 2 ';
			$select_date ='report_generated_date';
		}else if ($this->input->post('status') =='3') {
			$is_submitted = ' AND is_submitted = 3 ';
			$select_date ='updated_date';
		}

		if ($this->input->post('date_pick') !='' && $this->input->post('date_pick') !=null) {
			$date = explode('-',$this->input->post('date_pick')); 
			 $newDate = date("Y-m-d", strtotime(str_replace('/','-',trim($date[0]))));
			 $newDate1 = date("Y-m-d", strtotime(str_replace('/','-',$date[1])));
			 $d = date('Y-m-d');

			 $new = date("Ymd", strtotime($date[0]));
			 $new1 = date("Ymd", strtotime($date[1]));

			 $today = date('d-m-Y'); 
       $exp = date('d-m-Y',strtotime($newDate));
       $expDate =  date_create($exp);
       $todayDate = date_create($today);
       $diff =  date_diff($todayDate, $expDate);  
		if($diff->format("%a") != 88 && $diff->format("%a") != 0){
            $query = ' AND date('.$select_date.') BETWEEN  "'.$newDate.'" AND "'.$newDate1.'" ';
       	}
       
			 
			/*if ($d != $new) { 
			  $query = ' AND date(created_date) BETWEEN  "'.$newDate.'" AND "'.$newDate1.'" ';
			}*/
		}
		
 		

		$q = implode(',', $client_ids);
		 $q1 = $q;
		if ($user !='' && $user !=null && count($client_ids) ==0 ) {
		 	$q1 = $user['client_id'];
		 }else{ 
		    $q1 = isset($q)?$q:$user['client_id'];
		 }

		 $query_main ='client_id IN ( '.$q1.' ) ';

		return $this->db->query('SELECT YEAR(created_date) AS year, MONTH(created_date)  as Month,DATE_FORMAT(date(created_date),"%M %Y") as monthname, COUNT(*) AS total FROM candidate where '.$query_main.$query.$is_submitted.' GROUP BY YEAR(created_date), MONTH(created_date)')->result_array();
	}
 
	function get_status_wise_case_summary_details() {
		$client_ids = array();
		if ($this->input->post('client') == '0') {
			$data = $this->get_all_clients(); 
			array_push($client_ids,$data['parent']['client_id']);
			if (count($data['child']) > 0) {
				foreach ($data['child'] as $key => $value) {
					array_push($client_ids,$value['client_id']);
				}
			}
		} else {
			array_push($client_ids,$this->input->post('client'));
		}

		$user = $this->session->userdata('logged-in-client');
		$query ='';
		$is_submitted ='';
		$select_date ='created_date';
		if ($this->input->post('status') =='0') {
			$is_submitted = ' AND is_submitted = 0 ';
			$select_date ='created_date';
		} else if ($this->input->post('status') =='1') {
			$is_submitted = ' AND is_submitted = 1 ';
			$select_date ='case_submitted_date';
		} else if ($this->input->post('status') =='2') { 
			$is_submitted = ' AND is_submitted = 2 ';
			$select_date ='report_generated_date';
		} else if ($this->input->post('status') =='3') {
			$is_submitted = ' AND is_submitted = 3 ';
			$select_date ='updated_date';
		}

		if ($this->input->post('date_pick') != '' && $this->input->post('date_pick') != null) {
			$date = explode('-',$this->input->post('date_pick')); 
			$newDate = date("Y-m-d", strtotime(str_replace('/','-',trim($date[0]))));
			$newDate1 = date("Y-m-d", strtotime(str_replace('/','-',$date[1])));
			$d = date('Y-m-d');

			$new = date("Ymd", strtotime($date[0]));
			$new1 = date("Ymd", strtotime($date[1]));

			$today = date('d-m-Y'); 
       		$exp = date('d-m-Y',strtotime($newDate));
       		$expDate =  date_create($exp);
       		$todayDate = date_create($today);
       		$diff =  date_diff($todayDate, $expDate);  
			if($diff->format("%a") != 88 && $diff->format("%a") != 0) {
            	$query = ' AND date('.$select_date.') BETWEEN  "'.$newDate.'" AND "'.$newDate1.'" ';
       		}
 
			/*if ($d != $new) { 
			  $query = ' AND date(created_date) BETWEEN  "'.$newDate.'" AND "'.$newDate1.'" ';
			}*/
		}
		
		$q = implode(',', $client_ids);
		$q1 = $q;
		if ($user != '' && $user != null && count($client_ids) == 0) {
		 	$q1 = $user['client_id'];
		} else {
		    $q1 = isset($q) ? $q : $user['client_id'];
		}

		$query_main ='client_id IN ( '.$q1.' ) ';
		$query = $this->db->query('SELECT YEAR(created_date) AS year, MONTH(created_date) as Month,DATE_FORMAT(date(created_date),"%M %Y") as monthname, is_submitted AS case_status, COUNT(*) AS total FROM candidate where '.$query_main.$query.$is_submitted.' AND is_submitted IN (0,1,2,3) GROUP BY YEAR(created_date), MONTH(created_date), case_status')->result_array();
		
		$month_wise_data = [];
		if (count($query) > 0) {
			foreach ($query as $key => $value) {
				if (!array_key_exists($value['monthname'], $month_wise_data)) {
					$month_wise_data[$value['monthname']] = array(
						'monthname' => $value['monthname'],
						'initiate_cases' =>  intval($value['case_status']) == 0 ? $value['total'] : 0,
						'in_progress_cases' =>  $value['case_status'] == 1 ? $value['total'] : 0,
						'insuff_cases' =>  $value['case_status'] == 3 ? $value['total'] : 0,
						'completed_cases' =>  $value['case_status'] == 2 ? $value['total'] : 0
					);
				} else {
					$month_wise_data[$value['monthname']]['initiate_cases'] = intval($month_wise_data[$value['monthname']]['initiate_cases']) + intval((($value['case_status'] == 0) ? $value['total'] : 0));
					$month_wise_data[$value['monthname']]['in_progress_cases'] = intval($month_wise_data[$value['monthname']]['in_progress_cases']) + intval((($value['case_status'] == 1) ? $value['total'] : 0));
					$month_wise_data[$value['monthname']]['insuff_cases'] = intval($month_wise_data[$value['monthname']]['insuff_cases']) + intval((($value['case_status'] == 3) ? $value['total'] : 0));
					$month_wise_data[$value['monthname']]['completed_cases'] = intval($month_wise_data[$value['monthname']]['completed_cases']) + intval((($value['case_status'] == 2) ? $value['total'] : 0));
				}
			}
		}
		$month_name = [];
		$initiated_cases = [];
		$in_progress_cases = [];
		$insuff_cases = [];
		$completed_cases = [];
		if (count($month_wise_data) > 0) {
			foreach ($month_wise_data as $key => $value) {
				array_push($month_name, $key);
				array_push($initiated_cases, $value['initiate_cases']);
				array_push($in_progress_cases, $value['in_progress_cases']);
				array_push($insuff_cases, $value['insuff_cases']);
				array_push($completed_cases, $value['completed_cases']);
			}
		}

		$final_data['month_name'] = $month_name;
		$final_data['initiated_cases'] = $initiated_cases;
		$final_data['in_progress_cases'] = $in_progress_cases;
		$final_data['insuff_cases'] = $insuff_cases;
		$final_data['completed_cases'] = $completed_cases;
		return $final_data;
	}

	function total_report_count(){
		// return is_report_generated

		$user = $this->session->userdata('logged-in-client');
		$client_ids = array();
		if ($this->input->post('client') == '0') {
			$data = $this->get_all_clients(); 
			array_push($client_ids,$data['parent']['client_id']);
			if (count($data['child']) > 0) {
				foreach ($data['child'] as $key => $value) {
					array_push($client_ids,$value['client_id']);
				}
			}
		}else{
			array_push($client_ids,$this->input->post('client'));
		}

		$q = implode(',', $client_ids);
		 $q1 = $q;
		if ($q =='') {
			$q1 = $user['client_id'];
		}

		 $query_main ='client_id IN ( '.$q1.' ) ';

		return $this->db->query('SELECT * FROM candidate where '.$query_main.' AND is_report_generated=1 AND is_submitted=2')->num_rows();
	}

	function  all_report_counts(){
		// return is_report_generated
		$user = $this->session->userdata('logged-in-client');

		$client_ids = array();
		if ($this->input->post('client') == '0') {
			$data = $this->get_all_clients(); 
			array_push($client_ids,$data['parent']['client_id']);
			if (count($data['child']) > 0) {
				foreach ($data['child'] as $key => $value) {
					array_push($client_ids,$value['client_id']);
				}
			}
		}else{
			array_push($client_ids,$this->input->post('client'));
		}

		$q = implode(',', $client_ids);
		 $q1 = $q;
		if ($q =='') {
			$q1 = $user['client_id'];
		}

		 $query_main ='client_id IN ( '.$q1.' ) ';


		$result = $this->db->query('SELECT * FROM candidate where '.$query_main.' AND is_report_generated=1 AND is_submitted=2')->result_array();
		$red = array();
		$orange = array();
		$blue = array();
		$green = array();
		if (count($result) > 0) {
			foreach ($result as $key => $value) {
				$candidate_status = $this->caseModel->getSingleAssignedCaseDetail_s($value['candidate_id']);


			$form_analyst_status = array();
			if (count($candidate_status) > 0) { 
			    foreach ($candidate_status as $kc => $comp) {
			        array_push($form_analyst_status, isset($comp['analyst_status'])?$comp['analyst_status']:0);
			    }
			}

				if (in_array('7', $form_analyst_status)) { 
					array_push($red,1);
				}else if(array_intersect(['6','9'], $form_analyst_status)){ 
					array_push($orange,1);
				}else if(in_array('0', $form_analyst_status)){ 
					array_push($blue,1);
				}else{   
					array_push($green,1);
				}

			}
		}
		return array(
					'red'=>array_sum($red),
					'orange'=>array_sum($orange),
					'blue'=>array_sum($blue),
					'green'=>array_sum($green)
				);
	}

	function identify_reports($param){
 
		$user = $this->session->userdata('logged-in-client');
		$result = $this->db->query('SELECT * FROM candidate where client_id='.$user['client_id'].' AND is_report_generated=1 AND is_submitted=2')->result_array();
		$total = array();
		$green = array();
		$orange = array();
		$blue = array();
		$red = array();
		if (count($result) > 0) {
			foreach ($result as $key => $value) {
				$candidate_status = $this->caseModel->getSingleAssignedCaseDetail_s($value['candidate_id']);


			$form_analyst_status = array();
			if (count($candidate_status) > 0) { 
			    foreach ($candidate_status as $kc => $comp) {
			        array_push($form_analyst_status, isset($comp['analyst_status'])?$comp['analyst_status']:0);
			    }
			}
				array_push($total,$value['candidate_id']);
				if (in_array('7', $form_analyst_status)) { 
					array_push($red,$value['candidate_id']);
				}else if(array_intersect(['6','9'], $form_analyst_status)){ 
					array_push($orange,$value['candidate_id']);
				}else if(in_array('0', $form_analyst_status)){ 
					array_push($blue,$value['candidate_id']);
				}else{   
					array_push($green,$value['candidate_id']);
				}

			}
		}

		if (md5('total') == $param) {
		 return array('ids'=>$total,'color'=>'Total Generated Case Reports');
		}else if (md5('green') == $param) {
			return array('ids'=>$green,'color'=>'Green Color Case Reports'); 
		}else if (md5('orange') == $param) {
			 return array('ids'=>$orange,'color'=>'Orange Color Case Reports');
		}else if (md5('blue') == $param) {
			return array('ids'=>$blue,'color'=>'Blue Color Case Reports'); 
		}else if (md5('red') == $param) {
			return array('ids'=>$red,'color'=>'Red Color Case Reports'); 
		}else{
			return array('ids'=>array(),'color'=>'Invalid Report Request'); 
		}
	}

	function  all_requested_report(){
		// return is_report_generated
		$user = $this->session->userdata('logged-in-client');

		$client_ids = array();
		if ($this->input->post('client') == '0') {
			$data = $this->get_all_clients(); 
			array_push($client_ids,$data['parent']['client_id']);
			if (count($data['child']) > 0) {
				foreach ($data['child'] as $key => $value) {
					array_push($client_ids,$value['client_id']);
				}
			}
		}else{
			array_push($client_ids,$this->input->post('client'));
		}

		$q = implode(',', $client_ids);
		 $q1 = $q;
		if ($q =='') {
			$q1 = $user['client_id'];
		}

		 $query_main ='client_id IN ( '.$q1.' ) ';
		  $where ='';
        if ($this->input->post('duration') == 'day') {
          $where=" AND date(report_generated_date) BETWEEN CURDATE() - INTERVAL 15 DAY AND CURDATE()";
        }else if($this->input->post('duration') == 'month'){
          $where=" AND date(report_generated_date) BETWEEN CURDATE() - INTERVAL ".$this->input->post('day')." MONTH AND CURDATE() ";
        }
 

		$result = $this->db->query('SELECT * FROM candidate where '.$query_main.' AND is_report_generated=1 AND is_submitted=2'.$where)->result_array();
		$red = array();
		$orange = array();
		$blue = array();
		$green = array();
		if (count($result) > 0) {
			foreach ($result as $key => $value) {
				$candidate_status = $this->caseModel->getSingleAssignedCaseDetail_s($value['candidate_id']);


			$form_analyst_status = array();
			if (count($candidate_status) > 0) { 
			    foreach ($candidate_status as $kc => $comp) {
			        array_push($form_analyst_status, isset($comp['analyst_status'])?$comp['analyst_status']:0);
			    }
			}

				if (in_array('7', $form_analyst_status)) { 
					array_push($red,1);
				}else if(array_intersect(['6','9'], $form_analyst_status)){ 
					array_push($orange,1);
				}else if(in_array('0', $form_analyst_status)){ 
					array_push($blue,1);
				}else{   
					array_push($green,1);
				}

			}
		}
		return array(
					'total'=>count($result),
					'red'=>array_sum($red),
					'orange'=>array_sum($orange),
					'blue'=>array_sum($blue),
					'green'=>array_sum($green)
				);
	}
}