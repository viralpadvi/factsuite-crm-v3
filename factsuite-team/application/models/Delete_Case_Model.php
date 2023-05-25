<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_Case_Model extends CI_Model {

	function delete_case_details($variable_array = '') {
		if ($variable_array != '') {
			$delete_adverse_media_check = $this->delete_adverse_media_check($variable_array);
			$delete_bankruptcy_check = $this->delete_bankruptcy_check($variable_array);
			$delete_civil_check = $this->delete_civil_check($variable_array);
			$delete_court_record_check = $this->delete_court_record_check($variable_array);
			$delete_covid_19_check = $this->delete_covid_19_check($variable_array);
			$delete_credit_cibil_check = $this->delete_credit_cibil_check($variable_array);
			$delete_criminal_check = $this->delete_criminal_check($variable_array);
			$delete_current_employment_check = $this->delete_current_employment_check($variable_array);
			$delete_cv_check = $this->delete_cv_check($variable_array);
			$delete_directorship_check = $this->delete_directorship_check($variable_array);
			$delete_document_check = $this->delete_document_check($variable_array);
			$delete_driving_licence_check = $this->delete_driving_licence_check($variable_array);
			$delete_drugtest_check = $this->delete_drugtest_check($variable_array);
			$delete_education_details_check = $this->delete_education_details_check($variable_array);
			$delete_employment_gap_check = $this->delete_employment_gap_check($variable_array);
			$delete_globaldatabase_check = $this->delete_globaldatabase_check($variable_array);
			$delete_global_sanctions_aml_check = $this->delete_global_sanctions_aml_check($variable_array);
			$delete_health_checkup_check = $this->delete_health_checkup_check($variable_array);
			$delete_landload_reference_check = $this->delete_landload_reference_check($variable_array);
			$delete_permanent_address_check = $this->delete_permanent_address_check($variable_array);
			$delete_present_address_check = $this->delete_present_address_check($variable_array);
			$delete_previous_address_check = $this->delete_previous_address_check($variable_array);
			$delete_previous_employment_check = $this->delete_previous_employment_check($variable_array);
			$delete_reference_check = $this->delete_reference_check($variable_array);
			$delete_social_media_check = $this->delete_social_media_check($variable_array);

			$delete_signature_details = $this->delete_signature_details($variable_array);

			if ($delete_adverse_media_check == 1 && $delete_bankruptcy_check == 1 && $delete_civil_check == 1 && $delete_civil_check == 1 && $delete_court_record_check == 1 && $delete_covid_19_check == 1 && $delete_credit_cibil_check == 1 && $delete_criminal_check == 1 && $delete_current_employment_check == 1 && $delete_cv_check == 1 && $delete_directorship_check == 1 && $delete_document_check == 1 && $delete_driving_licence_check == 1 && $delete_drugtest_check == 1 && $delete_education_details_check == 1 && $delete_employment_gap_check == 1 && $delete_globaldatabase_check == 1 && $delete_global_sanctions_aml_check == 1 && $delete_health_checkup_check == 1 && $delete_landload_reference_check == 1 && $delete_permanent_address_check == 1 && $delete_previous_address_check == 1 && $delete_previous_employment_check == 1 && $delete_reference_check == 1 && $delete_social_media_check == 1 && $delete_signature_details == 1 ) {
				$delete_main_candidate_details = $this->delete_main_candidate_details($variable_array);
				if ($delete_main_candidate_details == 1) {
					return array('status'=>'1','message'=>'Case Deleted successfully');
				}
				return array('status'=>'2','message'=>'Something went wrong. Plesae try again');
			}
			return array('status'=>'2','message'=>'Something went wrong. Plesae try again');
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_case_details_v2($variable_array = '') {
		if ($variable_array != '') {
			$get_all_components = $this->db->get('components')->result_array();

			$db_deletion_result_array = [];
			foreach ($get_all_components as $key => $value) {
				$variable_array['main_component_table_name'] = $value['main_component_table_name'];
				$variable_array['log_component_table_name'] = $value['log_component_table_name'];
				$return_result = $this->delete_cases_from_all_component_tables($variable_array);
				array_push($db_deletion_result_array, $return_result['status']);
			}
			
			$delete_signature_details = $this->delete_signature_details($variable_array);

			if (!in_array(0, $db_deletion_result_array) && $delete_signature_details['status'] == 1) {
				$delete_main_candidate_details = $this->delete_main_candidate_details($variable_array);
				if ($delete_main_candidate_details['status'] == 1) {
					return array('status'=>'1','message'=>'Case Deleted successfully');
				}
				return array('status'=>'2','message'=>'Something went wrong. Plesae try again');
			}
			return array('status'=>'2','message'=>'Something went wrong. Plesae try again');
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_cases_from_all_component_tables($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get($variable_array['main_component_table_name'])->row_array();
				if ($candidate_details != '') {
					$candidate_details['case_deleted_status'] = 1;
					$candidate_details['case_deleted_by_id'] = $variable_array['logged_in_user_details']['team_id'];
					$candidate_details['case_deleted_by_role_type'] = $variable_array['type'];
					$candidate_details['case_deleted_by_role'] = $variable_array['role'];
					$candidate_details['case_deleted_date'] = $this->config->item('todays_date_time');
					if($this->db->insert($variable_array['log_component_table_name'],$candidate_details)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete($variable_array['main_component_table_name'])) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					}
					return array('status'=>'2','message'=>'Something went wrong while logging the data.');
				}
				return array('status'=>'1','message'=>'No Details available.');
			}
			return array('status'=>'201','message'=>'Bad Request Format');
		}
		return array('status'=>'201','message'=>'Bad Request Format');
	}

	function delete_adverse_media_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('adverse_database_media_check')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'adverse_database_media_check_id' => $candidate_details['adverse_database_media_check_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'approved_doc' => $candidate_details['approved_doc'],
						'check_form' => $candidate_details['check_form'],
						'remark_country' => $candidate_details['remark_country'],
						'assign_to' => $candidate_details['assign_to'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('adverse_database_media_check_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('adverse_database_media_check')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_bankruptcy_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('bankruptcy')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'bankruptcy_id' => $candidate_details['bankruptcy_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'bankruptcy_number' => $candidate_details['bankruptcy_number'],
						'bankruptcy_doc' => $candidate_details['bankruptcy_doc'],
						'document_type' => $candidate_details['document_type'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'approved_doc' => $candidate_details['approved_doc'],
						'check_form' => $candidate_details['check_form'],
						'remark_country' => $candidate_details['remark_country'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'assign_to' => $candidate_details['assign_to'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						'specialist_status' => $candidate_details['specialist_status'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('bankruptcy_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('bankruptcy')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_civil_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('civil_check')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'civil_check_id' => $candidate_details['civil_check_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'address' => $candidate_details['address'],
						'pin_code' => $candidate_details['pin_code'],
						'city' => $candidate_details['city'],
						'state' => $candidate_details['state'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'check_form' => $candidate_details['check_form'],
						'address_type' => $candidate_details['address_type'],
						'remark_address' => $candidate_details['remark_address'],
						'remark_pin_code' => $candidate_details['remark_pin_code'],
						'remark_city' => $candidate_details['remark_city'],
						'remark_state' => $candidate_details['remark_state'],
						'country' => $candidate_details['country'],
						'assign_to' => $candidate_details['assign_to'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('civil_check_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('civil_check')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_court_record_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('court_records')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'court_records_id' => $candidate_details['court_records_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'address' => $candidate_details['address'],
						'pin_code' => $candidate_details['pin_code'],
						'city' => $candidate_details['city'],
						'state' => $candidate_details['state'],
						'country' => $candidate_details['country'],
						'address_proof_doc' => $candidate_details['address_proof_doc'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'check_form' => $candidate_details['check_form'],
						'address_type' => $candidate_details['address_type'],
						'remark_address' => $candidate_details['remark_address'],
						'remark_pin_code' => $candidate_details['remark_pin_code'],
						'remark_city' => $candidate_details['remark_city'],
						'remark_state' => $candidate_details['remark_state'],
						'assign_to' => $candidate_details['assign_to'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						// 'specialist_status' => $candidate_details['specialist_status'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('court_records_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('court_records')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_covid_19_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('covid_19')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'covid_id' => $candidate_details['covid_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'check_form' => $candidate_details['check_form'],
						'remark_country' => $candidate_details['remark_country'],
						'assign_to' => $candidate_details['assign_to'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('covid_19_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('covid_19')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_credit_cibil_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('credit_cibil')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'credit_id' => $candidate_details['credit_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'credit_number' => $candidate_details['credit_number'],
						'credit_cibil_doc' => $candidate_details['credit_cibil_doc'],
						'document_type' => $candidate_details['document_type'],
						'credit_country' => $candidate_details['credit_country'],
						'credit_pincode' => $candidate_details['credit_pincode'],
						'credit_state' => $candidate_details['credit_state'],
						'credit_city' => $candidate_details['credit_city'],
						'credit_address' => $candidate_details['credit_address'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'updated_date' => $candidate_details['updated_date'],
						'specialist_status' => $candidate_details['specialist_status'],
						'approved_doc' => $candidate_details['approved_doc'],
						'check_form' => $candidate_details['check_form'],
						'remark_country' => $candidate_details['remark_country'],
						'assign_to' => $candidate_details['assign_to'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('credit_cibil_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('credit_cibil')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_criminal_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('criminal_checks')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'criminal_check_id' => $candidate_details['criminal_check_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'address' => $candidate_details['address'],
						'pin_code' => $candidate_details['pin_code'],
						'city' => $candidate_details['city'],
						'state' => $candidate_details['state'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'check_form' => $candidate_details['check_form'],
						'address_type' => $candidate_details['address_type'],
						'remark_address' => $candidate_details['remark_address'],
						'remark_pin_code' => $candidate_details['remark_pin_code'],
						'remark_city' => $candidate_details['remark_city'],
						'remark_state' => $candidate_details['remark_state'],
						'remark_period_of_stay' => $candidate_details['remark_period_of_stay'],
						'remark_gender' => $candidate_details['remark_gender'],
						'country' => $candidate_details['country'],
						'assign_to' => $candidate_details['assign_to'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						// 'specialist_status' => $candidate_details['specialist_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('criminal_checks_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('criminal_checks')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_current_employment_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('current_employment')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'current_emp_id' => $candidate_details['current_emp_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'desigination' => $candidate_details['desigination'],
						'department' => $candidate_details['department'],
						'employee_id' => $candidate_details['employee_id'],
						'company_name' => $candidate_details['company_name'],
						'address' => $candidate_details['address'],
						'annual_ctc' => $candidate_details['annual_ctc'],
						'reason_for_leaving' => $candidate_details['reason_for_leaving'],
						'joining_date' => $candidate_details['joining_date'],
						'relieving_date' => $candidate_details['relieving_date'],
						'reporting_manager_name' => $candidate_details['reporting_manager_name'],
						'reporting_manager_desigination' => $candidate_details['reporting_manager_desigination'],
						'reporting_manager_contact_number' => $candidate_details['reporting_manager_contact_number'],
						'reporting_manager_email_id' => $candidate_details['reporting_manager_email_id'],
						'hr_name' => $candidate_details['hr_name'],
						'hr_contact_number' => $candidate_details['hr_contact_number'],
						'hr_code' => $candidate_details['hr_code'],
						'hr_email_id' => $candidate_details['hr_email_id'],
						'code' => $candidate_details['code'],
						'appointment_letter' => $candidate_details['appointment_letter'],
						'experience_relieving_letter' => $candidate_details['experience_relieving_letter'],
						'last_month_pay_slip' => $candidate_details['last_month_pay_slip'],
						'bank_statement_resigngation_acceptance' => $candidate_details['bank_statement_resigngation_acceptance'],
						'approved_doc' => $candidate_details['approved_doc'],
						'remarks_emp_id' => $candidate_details['remarks_emp_id'],
						'remarks_designation' => $candidate_details['remarks_designation'],
						'remark_department' => $candidate_details['remark_department'],
						'remark_date_of_joining' => $candidate_details['remark_date_of_joining'],
						'remark_date_of_relieving' => $candidate_details['remark_date_of_relieving'],
						'remark_salary_type' => $candidate_details['remark_salary_type'],
						'remark_salary_lakhs' => $candidate_details['remark_salary_lakhs'],
						'remark_currency' => $candidate_details['remark_currency'],
						'remark_managers_designation' => $candidate_details['remark_managers_designation'],
						'remark_managers_contact' => $candidate_details['remark_managers_contact'],
						'remark_physical_visit' => $candidate_details['remark_physical_visit'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'remark_hr_name' => $candidate_details['remark_hr_name'],
						'remark_hr_email' => $candidate_details['remark_hr_email'],
						'remark_hr_phone_no' => $candidate_details['remark_hr_phone_no'],
						'remark_reason_for_leaving' => $candidate_details['remark_reason_for_leaving'],
						'remark_eligible_for_re_hire' => $candidate_details['remark_eligible_for_re_hire'],
						'remark_attendance_punctuality' => $candidate_details['remark_attendance_punctuality'],
						'remark_job_performance' => $candidate_details['remark_job_performance'],
						'remark_exit_status' => $candidate_details['remark_exit_status'],
						'remark_disciplinary_issues' => $candidate_details['remark_disciplinary_issues'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'Insuff_remarks' => $candidate_details['Insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'calling_remarks' => $candidate_details['calling_remarks'],
						'verification_fee' => $candidate_details['verification_fee'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'assigned_role' => $candidate_details['assigned_role'],
						'company_url' => $candidate_details['company_url'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('current_employment_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('current_employment')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_cv_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('cv_check')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'cv_id' => $candidate_details['cv_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'full_name' => $candidate_details['full_name'],
						'contect_number' => $candidate_details['contect_number'],
						'address' => $candidate_details['address'],
						'education_detail' => $candidate_details['education_detail'],
						'employment_duration' => $candidate_details['employment_duration'],
						'designation_held' => $candidate_details['designation_held'],
						'complete_employment_info' => $candidate_details['complete_employment_info'],
						'cv_number' => $candidate_details['cv_number'],
						'cv_doc' => $candidate_details['cv_doc'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'updated_date' => $candidate_details['updated_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'check_form' => $candidate_details['check_form'],
						'remark_country' => $candidate_details['remark_country'],
						'assign_to' => $candidate_details['assign_to'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('cv_check_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('cv_check')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_directorship_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('directorship_check')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'directorship_check_id' => $candidate_details['directorship_check_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'approved_doc' => $candidate_details['approved_doc'],
						'check_form' => $candidate_details['check_form'],
						'remark_country' => $candidate_details['remark_country'],
						'assign_to' => $candidate_details['assign_to'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'analyst_status' => $candidate_details['analyst_status'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('directorship_check_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('directorship_check')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_document_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('document_check')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'document_check_id' => $candidate_details['document_check_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'passport_doc' => $candidate_details['passport_doc'],
						'pan_card_doc' => $candidate_details['pan_card_doc'],
						'adhar_doc' => $candidate_details['adhar_doc'],
						'passport_number' => $candidate_details['passport_number'],
						'pan_number' => $candidate_details['pan_number'],
						'aadhar_number' => $candidate_details['aadhar_number'],
						'voter_id' => $candidate_details['voter_id'],
						'voter_doc' => $candidate_details['voter_doc'],
						'ssn_number' => $candidate_details['ssn_number'],
						'ssn_doc' => $candidate_details['ssn_doc'],
						'state' => $candidate_details['state'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'remark_address' => $candidate_details['remark_address'],
						'remark_city' => $candidate_details['remark_city'],
						'remark_state' => $candidate_details['remark_state'],
						'remark_pin_code' => $candidate_details['remark_pin_code'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'insuff_closure_remarks' => $candidate_details['insuff_closure_remarks'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('document_check_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('document_check')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_driving_licence_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('driving_licence')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'licence_id' => $candidate_details['licence_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'licence_number' => $candidate_details['licence_number'],
						'licence_doc' => $candidate_details['licence_doc'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'check_form' => $candidate_details['check_form'],
						'remark_country' => $candidate_details['remark_country'],
						'assign_to' => $candidate_details['assign_to'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('driving_licence_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('driving_licence')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_drugtest_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('drugtest')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'drugtest_id' => $candidate_details['drugtest_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'address' => $candidate_details['address'],
						'candidate_name' => $candidate_details['candidate_name'],
						'father__name' => $candidate_details['father__name'],
						'dob' => $candidate_details['dob'],
						'code' => $candidate_details['code'],
						'mobile_number' => $candidate_details['mobile_number'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'remark_address' => $candidate_details['remark_address'],
						'remark_city' => $candidate_details['remark_city'],
						'remark_state' => $candidate_details['remark_state'],
						'remark_pin_code' => $candidate_details['remark_pin_code'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'insuff_closure_remarks' => $candidate_details['insuff_closure_remarks'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('drugtest_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('drugtest')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_education_details_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('education_details')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'education_details_id' => $candidate_details['education_details_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'type_of_degree' => $candidate_details['type_of_degree'],
						'major' => $candidate_details['major'],
						'university_board' => $candidate_details['university_board'],
						'college_school' => $candidate_details['college_school'],
						'address_of_college_school' => $candidate_details['address_of_college_school'],
						'course_start_date' => $candidate_details['course_start_date'],
						'course_end_date' => $candidate_details['course_end_date'],
						'registration_roll_number' => $candidate_details['registration_roll_number'],
						'year_of_passing' => $candidate_details['year_of_passing'],
						'type_of_course' => $candidate_details['type_of_course'],
						'type_of_coutse' => $candidate_details['type_of_coutse'],
						'all_sem_marksheet' => $candidate_details['all_sem_marksheet'],
						'convocation' => $candidate_details['convocation'],
						'marksheet_provisional_certificate' => $candidate_details['marksheet_provisional_certificate'],
						'ten_twelve_mark_card_certificate' => $candidate_details['ten_twelve_mark_card_certificate'],
						'approved_doc' => $candidate_details['approved_doc'],
						'remark_roll_no' => $candidate_details['remark_roll_no'],
						'remark_type_of_dgree' => $candidate_details['remark_type_of_dgree'],
						'remark_institute_name' => $candidate_details['remark_institute_name'],
						'remark_university_name' => $candidate_details['remark_university_name'],
						'remark_year_of_graduation' => $candidate_details['remark_year_of_graduation'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'remark_result' => $candidate_details['remark_result'],
						'remark_verifier_name' => $candidate_details['remark_verifier_name'],
						'remark_verifier_designation' => $candidate_details['remark_verifier_designation'],
						'remark_verifier_contact' => $candidate_details['remark_verifier_contact'],
						'remark_verifier_email' => $candidate_details['remark_verifier_email'],
						'remark_physical_visit' => $candidate_details['remark_physical_visit'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'verification_fee' => $candidate_details['verification_fee'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'insuff_closure_remarks' => $candidate_details['insuff_closure_remarks'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'calling_remarks' => $candidate_details['calling_remarks'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('education_details_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('education_details')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_employment_gap_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('employment_gap_check')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'gap_id' => $candidate_details['gap_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'company_list' => $candidate_details['company_list'],
						'reason_for_gap' => $candidate_details['reason_for_gap'],
						'duration_of_gap' => $candidate_details['duration_of_gap'],
						'start_date' => $candidate_details['start_date'],
						'end_date' => $candidate_details['end_date'],
						'duration_start_date' => $candidate_details['duration_start_date'],
						'duration_end_date' => $candidate_details['duration_end_date'],
						'tenure_of_gap' => $candidate_details['tenure_of_gap'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'approved_doc' => $candidate_details['approved_doc'],
						'check_form' => $candidate_details['check_form'],
						'remark_country' => $candidate_details['remark_country'],
						'assign_to' => $candidate_details['assign_to'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('employment_gap_check_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('employment_gap_check')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_globaldatabase_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('globaldatabase')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'globaldatabase_id' => $candidate_details['globaldatabase_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'candidate_name' => $candidate_details['candidate_name'],
						'father_name' => $candidate_details['father_name'],
						'dob' => $candidate_details['dob'],
						'state' => $candidate_details['state'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'remark_address' => $candidate_details['remark_address'],
						'remark_city' => $candidate_details['remark_city'],
						'remark_state' => $candidate_details['remark_state'],
						'remark_pin_code' => $candidate_details['remark_pin_code'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'insuff_closure_remarks' => $candidate_details['insuff_closure_remarks'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('globaldatabase_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('globaldatabase')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_global_sanctions_aml_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('global_sanctions_aml')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'global_sanctions_aml_id' => $candidate_details['global_sanctions_aml_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'check_form' => $candidate_details['check_form'],
						'remark_country' => $candidate_details['remark_country'],
						'assign_to' => $candidate_details['assign_to'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('global_sanctions_aml_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('global_sanctions_aml')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_health_checkup_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('health_checkup')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'health_checkup_id' => $candidate_details['health_checkup_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'check_form' => $candidate_details['check_form'],
						'remark_country' => $candidate_details['remark_country'],
						'assign_to' => $candidate_details['assign_to'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('health_checkup_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('health_checkup')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_landload_reference_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('landload_reference')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'landload_id' => $candidate_details['landload_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'tenant_name' => $candidate_details['tenant_name'],
						'case_contact_no' => $candidate_details['case_contact_no'],
						'landlord_name' => $candidate_details['landlord_name'],
						'tenancy_period' => $candidate_details['tenancy_period'],
						'tenancy_period_comment' => $candidate_details['tenancy_period_comment'],
						'monthly_rental_amount' => $candidate_details['monthly_rental_amount'],
						'monthly_rental_amount_comment' => $candidate_details['monthly_rental_amount_comment'],
						'occupants_property' => $candidate_details['occupants_property'],
						'occupants_property_comment' => $candidate_details['occupants_property_comment'],
						'tenant_consistently_pay_rent_on_time' => $candidate_details['tenant_consistently_pay_rent_on_time'],
						'tenant_consistently_pay_rent_on_time_comment' => $candidate_details['tenant_consistently_pay_rent_on_time_comment'],
						'utility_bills_paid_on_time' => $candidate_details['utility_bills_paid_on_time'],
						'utility_bills_paid_on_time_comment' => $candidate_details['utility_bills_paid_on_time_comment'],
						'rental_property' => $candidate_details['rental_property'],
						'rental_property_comment' => $candidate_details['rental_property_comment'],
						'maintenance_issues' => $candidate_details['maintenance_issues'],
						'maintenance_issues_comment' => $candidate_details['maintenance_issues_comment'],
						'tenant_leave' => $candidate_details['tenant_leave'],
						'tenant_leave_comment' => $candidate_details['tenant_leave_comment'],
						'tenant_rent_again' => $candidate_details['tenant_rent_again'],
						'tenant_rent_again_comment' => $candidate_details['tenant_rent_again_comment'],
						'any_pets' => $candidate_details['any_pets'],
						'any_pets_comment' => $candidate_details['any_pets_comment'],
						'complaints_from_neighbors' => $candidate_details['complaints_from_neighbors'],
						'complaints_from_neighbors_comment' => $candidate_details['complaints_from_neighbors_comment'],
						'food_preference' => $candidate_details['food_preference'],
						'food_preference_comment' => $candidate_details['food_preference_comment'],
						'spare_time' => $candidate_details['spare_time'],
						'spare_time_comment' => $candidate_details['spare_time_comment'],
						'overall_character' => $candidate_details['overall_character'],
						'overall_character_comment' => $candidate_details['overall_character_comment'],
						'approved_doc' => $candidate_details['approved_doc'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						'verified_date' => $candidate_details['verified_date'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'verified_by' => $candidate_details['verified_by'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_closure_remarks' => $candidate_details['insuff_closure_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('landload_reference_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('landload_reference')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_permanent_address_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('permanent_address')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'permanent_address_id' => $candidate_details['permanent_address_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'flat_no' => $candidate_details['flat_no'],
						'street' => $candidate_details['street'],
						'area' => $candidate_details['area'],
						'city' => $candidate_details['city'],
						'pin_code' => $candidate_details['pin_code'],
						'state' => $candidate_details['state'],
						'country' => $candidate_details['country'],
						'nearest_landmark' => $candidate_details['nearest_landmark'],
						'duration_of_stay_start' => $candidate_details['duration_of_stay_start'],
						'duration_of_stay_end' => $candidate_details['duration_of_stay_end'],
						'is_present' => $candidate_details['is_present'],
						'contact_person_name' => $candidate_details['contact_person_name'],
						'contact_person_relationship' => $candidate_details['contact_person_relationship'],
						'contact_person_mobile_number' => $candidate_details['contact_person_mobile_number'],
						'code' => $candidate_details['code'],
						'rental_agreement' => $candidate_details['rental_agreement'],
						'ration_card' => $candidate_details['ration_card'],
						'gov_utility_bill' => $candidate_details['gov_utility_bill'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'remarks_address' => $candidate_details['remarks_address'],
						'remarks_city' => $candidate_details['remarks_city'],
						'remarks_pincode' => $candidate_details['remarks_pincode'],
						'remarks_state' => $candidate_details['remarks_state'],
						'staying_with' => $candidate_details['staying_with'],
						'initiated_date' => $candidate_details['initiated_date'],
						'verifier_name' => $candidate_details['verifier_name'],
						'period_of_stay' => $candidate_details['period_of_stay'],
						'progress_remarks' => $candidate_details['progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'assigned_to_vendor' => $candidate_details['assigned_to_vendor'],
						'closure_date' => $candidate_details['closure_date'],
						'relationship' => $candidate_details['relationship'],
						'property_type' => $candidate_details['property_type'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'closure_remarks' => $candidate_details['closure_remarks'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('permanent_address_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('permanent_address')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_present_address_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('present_address')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'present_address_id' => $candidate_details['present_address_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'flat_no' => $candidate_details['flat_no'],
						'street' => $candidate_details['street'],
						'area' => $candidate_details['area'],
						'city' => $candidate_details['city'],
						'pin_code' => $candidate_details['pin_code'],
						'state' => $candidate_details['state'],
						'country' => $candidate_details['country'],
						'nearest_landmark' => $candidate_details['nearest_landmark'],
						'duration_of_stay_start' => $candidate_details['duration_of_stay_start'],
						'duration_of_stay_end' => $candidate_details['duration_of_stay_end'],
						'is_present' => $candidate_details['is_present'],
						'contact_person_name' => $candidate_details['contact_person_name'],
						'contact_person_relationship' => $candidate_details['contact_person_relationship'],
						'contact_person_mobile_number' => $candidate_details['contact_person_mobile_number'],
						'code' => $candidate_details['code'],
						'rental_agreement' => $candidate_details['rental_agreement'],
						'ration_card' => $candidate_details['ration_card'],
						'gov_utility_bill' => $candidate_details['gov_utility_bill'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'remarks_address' => $candidate_details['remarks_address'],
						'remarks_city' => $candidate_details['remarks_city'],
						'remarks_pincode' => $candidate_details['remarks_pincode'],
						'remarks_state' => $candidate_details['remarks_state'],
						'staying_with' => $candidate_details['staying_with'],
						'initiated_date' => $candidate_details['initiated_date'],
						'verifier_name' => $candidate_details['verifier_name'],
						'period_of_stay' => $candidate_details['period_of_stay'],
						'progress_remarks' => $candidate_details['progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'assigned_to_vendor' => $candidate_details['assigned_to_vendor'],
						'closure_date' => $candidate_details['closure_date'],
						'relationship' => $candidate_details['relationship'],
						'property_type' => $candidate_details['property_type'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'closure_remarks' => $candidate_details['closure_remarks'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('present_address_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('present_address')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_previous_address_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('previous_address')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'previos_address_id' => $candidate_details['previos_address_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'flat_no' => $candidate_details['flat_no'],
						'street' => $candidate_details['street'],
						'area' => $candidate_details['area'],
						'city' => $candidate_details['city'],
						'pin_code' => $candidate_details['pin_code'],
						'state' => $candidate_details['state'],
						'country' => $candidate_details['country'],
						'nearest_landmark' => $candidate_details['nearest_landmark'],
						'duration_of_stay_start' => $candidate_details['duration_of_stay_start'],
						'duration_of_stay_end' => $candidate_details['duration_of_stay_end'],
						'is_present' => $candidate_details['is_present'],
						'contact_person_name' => $candidate_details['contact_person_name'],
						'contact_person_relationship' => $candidate_details['contact_person_relationship'],
						'contact_person_mobile_number' => $candidate_details['contact_person_mobile_number'],
						'code' => $candidate_details['code'],
						'rental_agreement' => $candidate_details['rental_agreement'],
						'ration_card' => $candidate_details['ration_card'],
						'gov_utility_bill' => $candidate_details['gov_utility_bill'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'remarks_address' => $candidate_details['remarks_address'],
						'remarks_city' => $candidate_details['remarks_city'],
						'remarks_pincode' => $candidate_details['remarks_pincode'],
						'remarks_state' => $candidate_details['remarks_state'],
						'staying_with' => $candidate_details['staying_with'],
						'initiated_date' => $candidate_details['initiated_date'],
						'verifier_name' => $candidate_details['verifier_name'],
						'period_of_stay' => $candidate_details['period_of_stay'],
						'progress_remarks' => $candidate_details['progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'assigned_to_vendor' => $candidate_details['assigned_to_vendor'],
						'closure_date' => $candidate_details['closure_date'],
						'relationship' => $candidate_details['relationship'],
						'property_type' => $candidate_details['property_type'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'closure_remarks' => $candidate_details['closure_remarks'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('previous_address_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('previous_address')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_previous_employment_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('previous_employment')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'previous_emp_id' => $candidate_details['previous_emp_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'desigination' => $candidate_details['desigination'],
						'department' => $candidate_details['department'],
						'employee_id' => $candidate_details['employee_id'],
						'company_name' => $candidate_details['company_name'],
						'address' => $candidate_details['address'],
						'annual_ctc' => $candidate_details['annual_ctc'],
						'reason_for_leaving' => $candidate_details['reason_for_leaving'],
						'joining_date' => $candidate_details['joining_date'],
						'relieving_date' => $candidate_details['relieving_date'],
						'reporting_manager_name' => $candidate_details['reporting_manager_name'],
						'reporting_manager_desigination' => $candidate_details['reporting_manager_desigination'],
						'reporting_manager_contact_number' => $candidate_details['reporting_manager_contact_number'],
						'reporting_manager_email_id' => $candidate_details['reporting_manager_email_id'],
						'hr_name' => $candidate_details['hr_name'],
						'hr_contact_number' => $candidate_details['hr_contact_number'],
						'hr_code' => $candidate_details['hr_code'],
						'hr_email_id' => $candidate_details['hr_email_id'],
						'code' => $candidate_details['code'],
						'appointment_letter' => $candidate_details['appointment_letter'],
						'experience_relieving_letter' => $candidate_details['experience_relieving_letter'],
						'last_month_pay_slip' => $candidate_details['last_month_pay_slip'],
						'bank_statement_resigngation_acceptance' => $candidate_details['bank_statement_resigngation_acceptance'],
						'approved_doc' => $candidate_details['approved_doc'],
						'remarks_emp_id' => $candidate_details['remarks_emp_id'],
						'remarks_designation' => $candidate_details['remarks_designation'],
						'remark_department' => $candidate_details['remark_department'],
						'remark_date_of_joining' => $candidate_details['remark_date_of_joining'],
						'remark_date_of_relieving' => $candidate_details['remark_date_of_relieving'],
						'remark_salary_type' => $candidate_details['remark_salary_type'],
						'remark_salary_lakhs' => $candidate_details['remark_salary_lakhs'],
						'remark_currency' => $candidate_details['remark_currency'],
						'remark_managers_designation' => $candidate_details['remark_managers_designation'],
						'remark_managers_contact' => $candidate_details['remark_managers_contact'],
						'remark_physical_visit' => $candidate_details['remark_physical_visit'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'remark_hr_name' => $candidate_details['remark_hr_name'],
						'remark_hr_email' => $candidate_details['remark_hr_email'],
						'remark_hr_phone_no' => $candidate_details['remark_hr_phone_no'],
						'remark_reason_for_leaving' => $candidate_details['remark_reason_for_leaving'],
						'remark_eligible_for_re_hire' => $candidate_details['remark_eligible_for_re_hire'],
						'remark_attendance_punctuality' => $candidate_details['remark_attendance_punctuality'],
						'remark_job_performance' => $candidate_details['remark_job_performance'],
						'remark_exit_status' => $candidate_details['remark_exit_status'],
						'remark_disciplinary_issues' => $candidate_details['remark_disciplinary_issues'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'Insuff_remarks' => $candidate_details['Insuff_remarks'],
						'Insuff_closure_remarks' => $candidate_details['Insuff_closure_remarks'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'calling_remarks' => $candidate_details['calling_remarks'],
						'verification_fee' => $candidate_details['verification_fee'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'assigned_role' => $candidate_details['assigned_role'],
						'company_url' => $candidate_details['company_url'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('previous_employment_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('previous_employment')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_reference_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('reference')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'reference_id' => $candidate_details['reference_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'name' => $candidate_details['name'],
						'company_name' => $candidate_details['company_name'],
						'designation' => $candidate_details['designation'],
						'contact_number' => $candidate_details['contact_number'],
						'code' => $candidate_details['code'],
						'email_id' => $candidate_details['email_id'],
						'years_of_association' => $candidate_details['years_of_association'],
						'contact_start_time' => $candidate_details['contact_start_time'],
						'contact_end_time' => $candidate_details['contact_end_time'],
						'approved_doc' => $candidate_details['approved_doc'],
						'roles_responsibilities' => $candidate_details['roles_responsibilities'],
						'professional_strengths' => $candidate_details['professional_strengths'],
						'attendance_punctuality' => $candidate_details['attendance_punctuality'],
						'mode_exit' => $candidate_details['mode_exit'],
						'communication_skills' => $candidate_details['communication_skills'],
						'work_attitude' => $candidate_details['work_attitude'],
						'honesty_reliability' => $candidate_details['honesty_reliability'],
						'target_orientation' => $candidate_details['target_orientation'],
						'people_management' => $candidate_details['people_management'],
						'projects_handled' => $candidate_details['projects_handled'],
						'professional_weakness' => $candidate_details['professional_weakness'],
						'accomplishments' => $candidate_details['accomplishments'],
						'job_performance' => $candidate_details['job_performance'],
						'integrity' => $candidate_details['integrity'],
						'leadership_quality' => $candidate_details['leadership_quality'],
						'pressure_handling_nature' => $candidate_details['pressure_handling_nature'],
						'team_player' => $candidate_details['team_player'],
						'additional_comments' => $candidate_details['additional_comments'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'verified_by' => $candidate_details['verified_by'],
						'insuff_closure_remarks' => $candidate_details['insuff_closure_remarks'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('reference_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('reference')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_social_media_check($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('social_media')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'social_id' => $candidate_details['social_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'candidate_name' => $candidate_details['candidate_name'],
						'father_name' => $candidate_details['father_name'],
						'dob' => $candidate_details['dob'],
						'employee_company_info' => $candidate_details['employee_company_info'],
						'education_info' => $candidate_details['education_info'],
						'university_info' => $candidate_details['university_info'],
						'social_media_info' => $candidate_details['social_media_info'],
						'state' => $candidate_details['state'],
						'approved_doc' => $candidate_details['approved_doc'],
						'assign_to_vendor' => $candidate_details['assign_to_vendor'],
						'remark_address' => $candidate_details['remark_address'],
						'remark_city' => $candidate_details['remark_city'],
						'remark_state' => $candidate_details['remark_state'],
						'remark_pin_code' => $candidate_details['remark_pin_code'],
						'in_progress_remarks' => $candidate_details['in_progress_remarks'],
						'insuff_remarks' => $candidate_details['insuff_remarks'],
						'verification_remarks' => $candidate_details['verification_remarks'],
						'verified_date' => $candidate_details['verified_date'],
						'insuff_closure_remarks' => $candidate_details['insuff_closure_remarks'],
						'ouputqc_comment' => $candidate_details['ouputqc_comment'],
						'status' => $candidate_details['status'],
						'inputqc_status_date' => $candidate_details['inputqc_status_date'],
						'analyst_status' => $candidate_details['analyst_status'],
						'analyst_status_date' => $candidate_details['analyst_status_date'],
						'insuff_created_date' => $candidate_details['insuff_created_date'],
						'insuff_close_date' => $candidate_details['insuff_close_date'],
						'insuff_status' => $candidate_details['insuff_status'],
						'insuff_team_role' => $candidate_details['insuff_team_role'],
						'insuff_team_id' => $candidate_details['insuff_team_id'],
						'insuff_re_assigned_date' => $candidate_details['insuff_re_assigned_date'],
						'output_status' => $candidate_details['output_status'],
						'outputqc_status_date' => $candidate_details['outputqc_status_date'],
						'remarks_updateed_by_role' => $candidate_details['remarks_updateed_by_role'],
						'remarks_updateed_by_id' => $candidate_details['remarks_updateed_by_id'],
						'assigned_role' => $candidate_details['assigned_role'],
						'assigned_team_id' => $candidate_details['assigned_team_id'],
						're_assigned_team_id' => $candidate_details['re_assigned_team_id'],
						're_assigned_date' => $candidate_details['re_assigned_date'],
						're_re_assigned_date' => $candidate_details['re_re_assigned_date'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('social_media_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('social_media')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_signature_details($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('signature')->row_array();
				if ($candidate_details != '') {
					$log_data = array(
						'signature_id' => $candidate_details['signature_id'],
						'candidate_id' => $candidate_details['candidate_id'],
						'signature_img' => $candidate_details['signature_img'],
						'accept_status' => $candidate_details['accept_status'],
						'created_date' => $candidate_details['created_date'],
						'case_deleted_status' => 1,
						'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
						'case_deleted_by_role_type' => $variable_array['type'],
						'case_deleted_by_role' => $variable_array['role'],
						'case_deleted_date' => $this->config->item('todays_date_time'),
					);

					if($this->db->insert('signature_log',$log_data)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('signature')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}

	function delete_main_candidate_details($variable_array) {
		if ($variable_array != '') {
			if ($variable_array['candidate_id'] != '') {
				$candidate_details = $this->db->where('candidate_id',$variable_array['candidate_id'])->get('candidate')->row_array();
				if ($candidate_details != '') {
					// $log_data = array(
					// 	'candidate_id' => $candidate_details['candidate_id'],
					// 	'client_id' => $candidate_details['client_id'],
					// 	'client_spoc_id' => $candidate_details['client_spoc_id'],
					// 	'title' => $candidate_details['title'],
					// 	'first_name' => $candidate_details['first_name'],
					// 	'last_name' => $candidate_details['last_name'],
					// 	'father_name' => $candidate_details['father_name'],
					// 	'country_code' => $candidate_details['country_code'],
					// 	'phone_number' => $candidate_details['phone_number'],
					// 	'loginId' => $candidate_details['loginId'],
					// 	'communications' => $candidate_details['communications'],
					// 	'email_id' => $candidate_details['email_id'],
					// 	'date_of_birth' => $candidate_details['date_of_birth'],
					// 	'date_of_joining' => $candidate_details['date_of_joining'],
					// 	'employee_id' => $candidate_details['employee_id'],
					// 	'package_name' => $candidate_details['package_name'],
					// 	'remark' => $candidate_details['remark'],
					// 	'component_ids' => $candidate_details['component_ids'],
					// 	'form_values' => $candidate_details['form_values'],
					// 	'package_components' => $candidate_details['package_components'],
					// 	'alacarte_components' => $candidate_details['alacarte_components'],
					// 	'document_uploaded_by' => $candidate_details['document_uploaded_by'],
					// 	'document_uploaded_by_email_id' => $candidate_details['document_uploaded_by_email_id'],
					// 	'nationality' => $candidate_details['nationality'],
					// 	'candidate_state' => $candidate_details['candidate_state'],
					// 	'candidate_city' => $candidate_details['candidate_city'],
					// 	'candidate_pincode' => $candidate_details['candidate_pincode'],
					// 	'candidate_address' => $candidate_details['candidate_address'],
					// 	'gender' => $candidate_details['gender'],
					// 	'marital_status' => $candidate_details['marital_status'],
					// 	'contact_start_time' => $candidate_details['contact_start_time'],
					// 	'contact_end_time' => $candidate_details['contact_end_time'],
					// 	'employee_company' => $candidate_details['employee_company'],
					// 	'education' => $candidate_details['education'],
					// 	'university' => $candidate_details['university'],
					// 	'week' => $candidate_details['week'],
					// 	'candidate_flat_no' => $candidate_details['candidate_flat_no'],
					// 	'candidate_street' => $candidate_details['candidate_street'],
					// 	'candidate_area' => $candidate_details['candidate_area'],
					// 	'social_media' => $candidate_details['social_media'],
					// 	'aaddhar_doc' => $candidate_details['aaddhar_doc'],
					// 	'pancard_doc' => $candidate_details['pancard_doc'],
					// 	'idproof_doc' => $candidate_details['idproof_doc'],
					// 	'additional_docs' => $candidate_details['additional_docs'],
					// 	'bankpassbook_doc' => $candidate_details['bankpassbook_doc'],
					// 	'is_submitted' => $candidate_details['is_submitted'],
					// 	'priority' => $candidate_details['priority'],
					// 	'priority_change_by_role' => $candidate_details['priority_change_by_role'],
					// 	'priority_change_by_id' => $candidate_details['priority_change_by_id'],
					// 	'tat_end_date' => $candidate_details['tat_end_date'],
					// 	'tat_insuff_start_date' => $candidate_details['tat_insuff_start_date'],
					// 	'tat_insuff_close_date' => $candidate_details['tat_insuff_close_date'],
					// 	'excel_upload' => $candidate_details['excel_upload'],
					// 	'tat_start_date' => $candidate_details['tat_start_date'],
					// 	'tat_pause_date' => $candidate_details['tat_pause_date'],
					// 	'tat_re_start_date' => $candidate_details['tat_re_start_date'],
					// 	'tat_pause_resume_status' => $candidate_details['tat_pause_resume_status'],
					// 	'case_added_by_role' => $candidate_details['case_added_by_role'],
					// 	'case_added_by_id' => $candidate_details['case_added_by_id'],
					// 	'assigned_inputqc_id' => $candidate_details['assigned_inputqc_id'],
					// 	'assigned_outputqc_id' => $candidate_details['assigned_outputqc_id'],
					// 	'assigned_outputqc_notification' => $candidate_details['assigned_outputqc_notification'],
					// 	're_assigned_inputqc_id' => $candidate_details['re_assigned_inputqc_id'],
					// 	're_assigned_inputqc_date' => $candidate_details['re_assigned_inputqc_date'],
					// 	'assigned_outputqc_date' => $candidate_details['assigned_outputqc_date'],
					// 	're_assigned_outputqc_id' => $candidate_details['re_assigned_outputqc_id'],
					// 	're_assigned_outputqc_date' => $candidate_details['re_assigned_outputqc_date'],
					// 	'is_report_generated' => $candidate_details['is_report_generated'],
					// 	'report_generated_date' => $candidate_details['report_generated_date'],
					// 	'otp_password' => $candidate_details['otp_password'],
					// 	'case_re_initiation' => $candidate_details['case_re_initiation'],
					// 	'case_re_initiation_date' => $candidate_details['case_re_initiation_date'],
					// 	'case_close_date' => $candidate_details['case_close_date'],
					// 	'case_submitted_date' => $candidate_details['case_submitted_date'],
					// 	'new_case_added_notification' => $candidate_details['new_case_added_notification'],
					// 	'form_filld_notification' => $candidate_details['form_filld_notification'],
					// 	'case_complated_notification' => $candidate_details['case_complated_notification'],
					// 	'case_complated_client_notification' => $candidate_details['case_complated_client_notification'],
					// 	'case_insuff_client_notification' => $candidate_details['case_insuff_client_notification'],
					// 	'case_intrim_notification' => $candidate_details['case_intrim_notification'],
					// 	'client_case_intrim_notification' => $candidate_details['client_case_intrim_notification'],
					// 	'candidate_details_added_from' => $candidate_details['candidate_details_added_from'],
					// 	'candidate_status' => $candidate_details['candidate_status'],
					// 	'segment' => $candidate_details['segment'],
					// 	'email_id_validated_by_candidate_status' => $candidate_details['email_id_validated_by_candidate_status'],
					// 	'email_id_validated_by_candidate_datetime' => $candidate_details['email_id_validated_by_candidate_datetime'],
					// 	'case_reinitiate' => $candidate_details['case_reinitiate'],
					// 	'personal_information_form_filled_by_candidate_status' => $candidate_details['personal_information_form_filled_by_candidate_status'],
					// 	'candidate_final_report' => $candidate_details['candidate_final_report'],
					// 	'case_complition_email_sent_status' => $candidate_details['case_complition_email_sent_status'],
					// 	'case_complition_email_sent_date' => $candidate_details['case_complition_email_sent_date'],
					// 	'case_complition_sms_sent_status' => $candidate_details['case_complition_sms_sent_status'],
					// 	'case_complition_sms_sent_date' => $candidate_details['case_complition_sms_sent_date'],
					// 	'case_deleted_status' => 1,
					// 	'case_deleted_by_id' => $variable_array['logged_in_user_details']['team_id'],
					// 	'case_deleted_by_role_type' => $variable_array['type'],
					// 	'case_deleted_by_role' => $variable_array['role'],
					// 	'case_deleted_date' => $this->config->item('todays_date_time'),
					// );

					$candidate_details['case_deleted_status'] = 1;
					$candidate_details['case_deleted_by_id'] = $variable_array['logged_in_user_details']['team_id'];
					$candidate_details['case_deleted_by_role_type'] = $variable_array['type'];
					$candidate_details['case_deleted_by_role'] = $variable_array['role'];
					$candidate_details['case_deleted_date'] = $this->config->item('todays_date_time');
					
					if($this->db->insert('candidate_log',$candidate_details)) {
						if($this->db->where('candidate_id',$variable_array['candidate_id'])->delete('candidate')) {
							return array('status'=>'1','message'=>'Candidate details deleted successfully.');
						}
						return array('status'=>'0','message'=>'something went wrong while deleting the data from main table.');
					} else {
						return array('status'=>'2','message'=>'Something went wrong while logging the data.');
					}
				} else {
					return array('status'=>'1','message'=>'No Details available.');
				}
			} else {
				return array('status'=>'201','message'=>'Bad Request Format');
			}
		} else {
			return array('status'=>'201','message'=>'Bad Request Format');
		}
	}
}