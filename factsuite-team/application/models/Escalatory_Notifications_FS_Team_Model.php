<?php

	class Escalatory_Notifications_FS_Team_Model extends CI_Model {

		function get_escalatory_cases_notifications($variable_array) {
	 		$show_cases_rule = $this->db->where('show_cases_rule_status','1')->get('show_cases_rule')->result_array();
	 		$all_rule_cirteria = json_decode(file_get_contents(base_url().'assets/custom-js/json/rule-criteras.json'),true);
	 		$remaining_days_rules = json_decode(file_get_contents(base_url().'assets/custom-js/json/remaining-days-rules.json'),true);
	 		$case_priorities = json_decode(file_get_contents(base_url().'assets/custom-js/json/case-priorities.json'),true);

	 		$show_case_rules = '';
	 		if (count($show_cases_rule) > 0) {
	 			foreach ($show_cases_rule as $key => $value) {
	 				if ($key != 0) {
	 					$show_case_rules .= ' OR ';
	 				}
		 			foreach ($all_rule_cirteria as $key2 => $value2) {
		 				if ($value['show_cases_rule_criteria'] == $value2['id']) {
		 					$show_cases_rules = json_decode($value['show_cases_rules'],true);
		 					if ($value['show_cases_rule_criteria'] == '1') {
		 						foreach ($remaining_days_rules as $key3 => $value3) {
		 							if ($show_cases_rules['remaining_days_type'] == $value3['id']) {
										$show_case_rules .= "((DATEDIFF(STR_TO_DATE(T2.tat_end_date,'%Y-%m-%d %H:%i:%s'),CURDATE()) ".$value3['db_symbol']." ".$show_cases_rules['remaining_days_value']." OR DATEDIFF(STR_TO_DATE(T2.tat_end_date,'%d-%m-%Y %H:%i:%s'),CURDATE()) ".$value3['db_symbol']." ".$show_cases_rules['remaining_days_value'].") AND T2.client_id IN (".$value['show_cases_rule_client_id'].") AND T2.is_submitted NOT IN (2))";
		 								break;
		 							}
		 						}
		 					} else if($value['show_cases_rule_criteria'] == '2') {
		 						foreach ($case_priorities as $key3 => $value3) {
		 							if ($show_cases_rules['priority_type'] == $value3['id']) {
		 								$show_case_rules .= "(T2.priority IN (".$value3['id'].") AND T2.client_id IN (".$value['show_cases_rule_client_id'].") AND T2.is_submitted NOT REGEXP (2))";
		 								break;
		 							}
		 						}
		 					}
		 					break;
		 				}
		 			}
		 		}
	 		} else {
	 			return array('status'=>'2','message'=>'No Notifications found');
	 		}
	 		
	 		if ($this->session->userdata('logged-in-csm')) {
				$team_component = $this->session->userdata('logged-in-csm');
				$this->db->where('T3.account_manager_name',$team_component['team_id']);
				$this->db->where($show_case_rules);
			}

			$caseListData = $this->db->select('T1.team_id,T1.first_name as team_first_name,T1.last_name as team_last_name ,T2.*,T3.client_name,T4.package_name')->join('candidate T2','T1.team_id = T2.assigned_inputqc_id','right')->join('tbl_client T3','T2.client_id = T3.client_id','left')->join('packages T4','T2.package_name = T4.package_id','left')->order_by('priority DESC, candidate_id DESC')->get('team_employee T1')->result_array();

			return $caseListData;
		}
	}	
?>