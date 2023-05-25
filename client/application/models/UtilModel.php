<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class UtilModel extends CI_Model {
	
	function get_custom_filter_number_list_v2() {
		return file_get_contents(base_url().'assets/custom-js/json/custom-filter-list.json');
	}
	
	function get_country_code_list() {
		return file_get_contents(base_url().'assets/custom-js/json/country-code.json');	
	}

	function random_number($digits) {
		return rand(pow(10, $digits - 1) - 1, pow(10, $digits) - 1);
	}
	
	function random_number_with_duplication_check($variable_array) {
		$random_number = $this->random_number($variable_array['otp_length']);
		if (strlen($random_number) == $variable_array['otp_length']) {
			if (count($variable_array['otp_list']) > 0) {
				if (in_array($random_number, $variable_array['otp_list'])) {
					$this->random_number_with_duplication_check($variable_array);
				} else {
					return $random_number;
				}
			} else {
				return $random_number;
			}
		} else {
			$this->random_number_with_duplication_check($variable_array);
		}
	}

	function get_date_formate($param = ''){
		$user = $this->session->userdata('logged-in-client');
		$timezone = $this->db->where('client_id',$user['client_id'])->get('client_timezone')->row_array();

		$date_formate = isset($timezone['date_formate'])?$timezone['date_formate']:'d-m-Y';

		$times = isset($timezone['timezone'])?$timezone['timezone']:"Asia/Kolkata";
                 // date_default_timezone_set($times);

		if ($param !='' && $param !=null && $param !='-'&& strtolower($param) !='na') {
			// return date($date_formate,strtotime($param));
			$date = new DateTime($param, new DateTimeZone('Asia/Kolkata'));  
			$date->setTimezone(new DateTimeZone($times));
			return $date->format($date_formate);
		}else{
			return '-';
		}
	}

function getComponent_or_PageName($componentId = '') {
		$pageName = '';
		switch ($componentId) {
			
			case '1':
				$pageName = 'criminal_checks';
				
				break;

			case '2':
				$pageName = 'court_records'; 
				
				break;
			case '3':
				$pageName = 'document_check';
				break;

			case '4':
				$pageName = 'drugtest';
				break;

			case '5':
				$pageName = 'globaldatabase';
				break;

			case '6':
				$pageName = 'current_employment';
				break; 
			case '7':
				$pageName = 'education_details';
				break; 
			case '8':
				$pageName = 'present_address';
				break; 
			case '9':
				$pageName = 'permanent_address';
				break; 
			case '10':
				$pageName = 'previous_employment';
				break; 
			case '11':
				$pageName = 'reference';
				break; 
			case '12':
				$pageName = 'previous_address';
				break;
			case '14':
				$pageName = 'directorship_check';
				break;
			case '15':
				$pageName = 'global_sanctions_aml';
				break;
			case '16':
				$pageName = 'driving_licence';
				break;
			case '17':
				$pageName = 'credit_cibil';
				break;
			case '18':
				$pageName = 'bankruptcy';
				break;
			case '19':
				$pageName = 'adverse_database_media_check';
				break;
			case '20':
				$pageName = 'cv_check';
				break;
			case '21':
				$pageName = 'health_checkup';
				break;
			case '22':
				$pageName = 'employment_gap_check';
				break;
			case '23':
				$pageName = 'landload_reference';
				break;
			case '24':
				$pageName = 'covid_19';
				break;
			case '25':
				$pageName = 'social_media';
				break;
			case '26':
				$pageName = 'civil_check';
				break;
			case '27':
				$pageName = 'right_to_work';
				break;
			case '28':
				$pageName = 'sex_offender';
				break;
			case '29':
				$pageName = 'politically_exposed';
				break;
			case '30':
				$pageName = 'india_civil_litigation';
				break;
			case '31':
				$pageName = 'mca';
				break;
			case '32':
				$pageName = 'nric';
				break;
			case '33':
				$pageName = 'gsa';
				break;
			case '34':
				$pageName = 'oig';
				break; 
			default:
				 $pageName = 'criminal_checks';
				break;
		};

		return $pageName;
	}

	function getComponentId($componentName=''){
		$check_id = '';
		switch ($componentName) {
			
			case 'criminal_checks':
				$check_id = '1';
				
				break;

			case 'court_records':
				$check_id = '2'; 
				
				break;
			case 'document_check':
				$check_id = '3';
				break;

			case 'drugtest':
				$check_id = '4';
				break;

			case 'globaldatabase':
				$check_id = '5';
				break;

			case 'current_employment':
				$check_id = '6';
				break; 
			case 'education_details':
				$check_id = '7';
				break; 
			case 'present_address':
				$check_id = '8';
				break; 
			case 'permanent_address':
				$check_id = '9';
				break; 
			case 'previous_employment':
				$check_id = '10';
				break; 
			case 'reference':
				$check_id = '11';
				break; 
			case 'previous_address':
				$check_id = '12';
				break;
			case 'directorship_check':
				$check_id = '14';
				break;
			case 'global_sanctions_aml':
				$check_id = '15';
				break;
			case 'driving_licence':
				$check_id = '16';
				break;
			case 'credit_cibil':
				$check_id = '17';
				break;
			case 'bankruptcy':
				$check_id = '18';
				break;
			case 'adverse_database_media_check':
				$check_id = '19';
				break;
			case 'cv_check':
				$check_id = '20';
				break;
			case 'health_checkup':
				$check_id = '21';
				break;
			case 'employment_gap_check':
				$check_id = '22';
				break;
			case 'landload_reference':
				$check_id = '23';
				break;
			case 'covid_19':
				$check_id = '24';
				break;
			case 'social_media':
				$check_id = '25';
				break;
			case 'civil_check':
				$check_id = '26';
				break;
			case 'right_to_work':
				$check_id = '27';
				break;
			case 'sex_offender':
				$check_id = '28';
				break;
			case 'politically_exposed':
				$check_id = '29';
				break;
			case 'india_civil_litigation':
				$check_id = '30';
				break;
			case 'mca':
				$check_id = '31';
				break;
			case 'nric':
				$check_id = '32';
				break;
			case 'gsa':
				$check_id = '33';
				break;
			case 'oig':
				$check_id = '34';
				break;
			default:
				 
				break;
		}
		// return array('0');
		return $check_id;
	}
	 
	function isInputQcExits(){
		$employee_data = $this->db->where('role','inputqc')->get('team_employee')->result_array();

		if(count($employee_data) > 0){
			// return $employee_data;
			return '1';
		}else{
			return '0';
			// return $employee_data;
		}
	}


	function setupOutPutStauts($outputStatus,$index,$newValue){
		$opStatus ='';
		if($outputStatus != null && $outputStatus != '' && $outputStatus != ' '){
			// echo "if <br>";
			$opStatus = explode(',', $outputStatus);
			if(count($opStatus) < $index){
				for ($i=0; $i < $index ; $i++) { 
					// array_push($opStatus,isset($opStatus[$i])?$opStatus[$i]:'0');
					if($i == ($index - 1)){
						$opStatus[$i] = isset($opStatus[$i])?$opStatus[$i]:$newValue;
					}else{
						$opStatus[$i] = isset($opStatus[$i])?$opStatus[$i]:'0';
					}
					
					
				}
			}else{
				$opStatus[$index] = $newValue;
			}
			
			$opStatus = implode(',', $opStatus);	
		}else{
			// echo "else <br>";
			$opStatus =$outputStatus;
		}

		return $opStatus;
	}


	function isAnyComponentVerifiedClear($candidate_id){
		 
		$candidateData =  $this->db->select("*")->from("candidate")->where('candidate_id',$candidate_id)->where('is_submitted !=','2')->where('assigned_outputqc_id','0')->get()->row_array();
		print_r($candidateData);
		$finalCandidateData = array();
		if($candidateData != null){
			$com_id = explode(',',$candidateData['component_ids']);
			print_r($com_id);
			echo "</br>";
			foreach ($com_id as $com_key => $com_value) {
				$table_name = $this->utilModel->getComponent_or_PageName($com_value);
				$componentData = $this->db->where('candidate_id',$candidateData['candidate_id'])->get($table_name)->row_array();
				if($componentData != null){ 
					$analyst_status = explode(',', $componentData['analyst_status']);
					$positive_status = array('4','5','6','7','9');
					$result=array_intersect($analyst_status,$positive_status);
					if(count($result) == count($analyst_status)){
						array_push($finalCandidateData, $candidateData);
						break;
					}
				}
			} 
		}
		// return $finalCandidateData;
		return count($finalCandidateData);
	}


	function return_excel_val(){
		return array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z","AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX", "BY", "BZ", "CA", "CB", "CC", "CD", "CE", "CF", "CG", "CH", "CI", "CJ", "CK", "CL", "CM", "CN", "CO", "CP", "CQ", "CR", "CS", "CT", "CU", "CV", "CW", "CX", "CY", "CZ", "DA", "DB", "DC", "DD", "DE", "DF", "DG", "DH", "DI", "DJ", "DK", "DL", "DM", "DN", "DO", "DP", "DQ", "DR", "DS", "DT", "DU", "DV", "DW", "DX", "DY", "DZ", "EA", "EB", "EC", "ED", "EE", "EF", "EG", "EH", "EI", "EJ", "EK", "EL", "EM", "EN", "EO", "EP", "EQ", "ER", "ES", "ET", "EU", "EV", "EW", "EX", "EY", "EZ", "FA", "FB", "FC", "FD", "FE", "FF", "FG", "FH", "FI", "FJ", "FK", "FL", "FM", "FN", "FO", "FP", "FQ", "FR", "FS", "FT", "FU", "FV", "FW", "FX", "FY", "FZ", "GA", "GB", "GC", "GD", "GE", "GF", "GG", "GH", "GI", "GJ", "GK", "GL", "GM", "GN", "GO", "GP", "GQ", "GR", "GS", "GT", "GU", "GV", "GW", "GX", "GY", "GZ", "HA", "HB", "HC", "HD", "HE", "HF", "HG", "HH", "HI", "HJ", "HK", "HL", "HM", "HN", "HO", "HP", "HQ", "HR", "HS", "HT", "HU", "HV", "HW", "HX", "HY", "HZ", "IA", "IB", "IC", "ID", "IE", "IF", "IG", "IH", "II", "IJ", "IK", "IL", "IM", "IN", "IO", "IP", "IQ", "IR", "IS", "IT", "IU", "IV", "IW", "IX", "IY", "IZ", "JA", "JB", "JC", "JD", "JE", "JF", "JG", "JH", "JI", "JJ", "JK", "JL", "JM", "JN", "JO", "JP", "JQ", "JR", "JS", "JT", "JU", "JV", "JW", "JX", "JY", "JZ", "KA", "KB", "KC", "KD", "KE", "KF", "KG", "KH", "KI", "KJ", "KK", "KL", "KM", "KN", "KO", "KP", "KQ", "KR", "KS", "KT", "KU", "KV", "KW", "KX", "KY", "KZ", "LA", "LB", "LC", "LD", "LE", "LF", "LG", "LH", "LI", "LJ", "LK", "LL", "LM", "LN", "LO", "LP", "LQ", "LR", "LS", "LT", "LU", "LV", "LW", "LX", "LY", "LZ", "MA", "MB", "MC", "MD", "ME", "MF", "MG", "MH", "MI", "MJ", "MK", "ML", "MM", "MN", "MO", "MP", "MQ", "MR", "MS", "MT", "MU", "MV", "MW", "MX", "MY", "MZ", "NA", "NB", "NC", "ND", "NE", "NF", "NG", "NH", "NI", "NJ", "NK", "NL", "NM", "NN", "NO", "NP", "NQ", "NR", "NS", "NT", "NU", "NV", "NW", "NX", "NY", "NZ", "OA", "OB", "OC", "OD", "OE", "OF", "OG", "OH", "OI", "OJ", "OK", "OL", "OM", "ON", "OO", "OP", "OQ", "OR", "OS", "OT", "OU", "OV", "OW", "OX", "OY", "OZ", "PA", "PB", "PC", "PD", "PE", "PF", "PG", "PH", "PI", "PJ", "PK", "PL", "PM", "PN", "PO", "PP", "PQ", "PR", "PS", "PT", "PU", "PV", "PW", "PX", "PY", "PZ", "QA", "QB", "QC", "QD", "QE", "QF", "QG", "QH", "QI", "QJ", "QK", "QL", "QM", "QN", "QO", "QP", "QQ", "QR", "QS", "QT", "QU", "QV", "QW", "QX", "QY", "QZ", "RA", "RB", "RC", "RD", "RE", "RF", "RG", "RH", "RI", "RJ", "RK", "RL", "RM", "RN", "RO", "RP", "RQ", "RR", "RS", "RT", "RU", "RV", "RW", "RX", "RY", "RZ", "SA", "SB", "SC", "SD", "SE", "SF", "SG", "SH", "SI", "SJ", "SK", "SL", "SM", "SN", "SO", "SP", "SQ", "SR", "SS", "ST", "SU", "SV", "SW", "SX", "SY", "SZ", "TA", "TB", "TC", "TD", "TE", "TF", "TG", "TH", "TI", "TJ", "TK", "TL", "TM", "TN", "TO", "TP", "TQ", "TR", "TS", "TT", "TU", "TV", "TW", "TX", "TY", "TZ", "UA", "UB", "UC", "UD", "UE", "UF", "UG", "UH", "UI", "UJ", "UK", "UL", "UM", "UN", "UO", "UP", "UQ", "UR", "US", "UT", "UU", "UV", "UW", "UX", "UY", "UZ", "VA", "VB", "VC", "VD", "VE", "VF", "VG", "VH", "VI", "VJ", "VK", "VL", "VM", "VN", "VO", "VP", "VQ", "VR", "VS", "VT", "VU", "VV", "VW", "VX", "VY", "VZ", "WA", "WB", "WC", "WD", "WE", "WF", "WG", "WH", "WI", "WJ", "WK", "WL", "WM", "WN", "WO", "WP", "WQ", "WR", "WS", "WT", "WU", "WV", "WW", "WX", "WY", "WZ", "XA", "XB", "XC", "XD", "XE", "XF", "XG", "XH", "XI", "XJ", "XK", "XL", "XM", "XN", "XO", "XP", "XQ", "XR", "XS", "XT", "XU", "XV", "XW", "XX", "XY", "XZ", "YA", "YB", "YC", "YD", "YE", "YF", "YG", "YH", "YI", "YJ", "YK", "YL", "YM", "YN", "YO", "YP", "YQ", "YR", "YS", "YT", "YU", "YV", "YW", "YX", "YY", "YZ", "ZA", "ZB", "ZC", "ZD", "ZE", "ZF", "ZG", "ZH", "ZI", "ZJ", "ZK", "ZL", "ZM", "ZN", "ZO", "ZP", "ZQ", "ZR", "ZS", "ZT", "ZU", "ZV", "ZW", "ZX", "ZY", "ZZ");

	}

	

	function all_components($candidate_id=''){ 
		$table = array('criminal_checks','court_records','document_check','drugtest','globaldatabase','current_employment','education_details','present_address','permanent_address','previous_employment','reference','previous_address','cv_check','driving_licence','credit_cibil','bankruptcy','directorship_check','global_sanctions_aml','adverse_database_media_check','health_checkup','employment_gap_check','landload_reference','covid_19','social_media','civil_check','right_to_work','sex_offender','politically_exposed','india_civil_litigation','mca','nric','gsa','oig');
		$table_data = array();
		if ($candidate_id =='') {
			 
		$user = $this->session->userdata('logged-in-candidate');
		$candidate_id = $user['candidate_id'];
		}
		foreach ($table as $key => $value) {
			$table_data[$value] = $this->db->where('candidate_id',$candidate_id)->get($value)->row_array(); 
		}

		return $table_data; 
	}


	
	function redirect_url($component_id,$request_from = ''){ 
		// return $component_id;
		$table_name = array();
		$mobile_candidate_links = array();
		$user = $this->session->userdata('logged-in-candidate'); 
		$log = $this->db->where('client_id',$user['client_id'])->get('custom_logo')->row_array();
		$client_name = strtolower(trim($user['first_name']).'-'.trim($user['last_name']));
		$client_name = preg_replace('/ /i','-',$client_name);
		$additional = 0;
		if (isset($log['additional'])) {
			if ($log['additional'] == 1) {
				$additional = 1;
			}
		}
 
		switch ((int)$component_id) {
			
			case 1:
				$table_name = $client_name.'/candidate-criminal-check';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-criminal-check';
				}
				break;

			case 2:
				$table_name = $client_name.'/candidate-court-record';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-court-record-1';
				}
				break;
			case 3:
				$table_name = $client_name.'/candidate-document-check';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-document-check';
				}
				break;
 
			case 4:
				$table_name = $client_name.'/candidate-drug-test';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-drug-test';
				}
				break;

			case 5:
				$table_name = $client_name.'/candidate-global-database';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-global-database';
				}
				break;

			case 6:
				$table_name = $client_name.'/candidate-employment';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-current-employment-1';
				}
				break; 
			case 7:
				$table_name = $client_name.'/candidate-education';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-education-1';
				}
				break; 
			case 8:
				$table_name = $client_name.'/candidate-present-address';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-present-address-1';
				}
				break;
			case 9:
				$table_name = $client_name.'/candidate-address';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-permanent-address-1';
				}
				break; 
			case 10:
				$table_name = $client_name.'/candidate-previos-employment';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-previous-employment-1';
				}
				break; 
			case 11:
				$table_name = $client_name.'/candidate-reference';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-reference';
				}
				break; 
			case 12:
				$table_name = $client_name.'/candidate-previous-address';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-previous-address-1';
				}
				break; 

			case 16:
				$table_name = $client_name.'/candidate-driving-licence';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-driving-licence';
				}
				break; 
			case 17:
				$table_name = $client_name.'/candidate-credit-cibil';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-credit-cibil';
				}
				break; 
			case 18:
				$table_name = $client_name.'/candidate-bankruptcy';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-bankruptcy';
				}
				break; 
			case 20:
				$table_name = $client_name.'/candidate-cv-check';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-cv-check';
				}
				break; 
			case 22:
				$table_name = $client_name.'/candidate-employment-gap';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-employment-gap';
				}
				break; 
			case 23:
				$table_name = $client_name.'/candidate-landload-reference';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-landlord-reference';
				}
				break; 
			case 25:
				$table_name = $client_name.'/candidate-social-media';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-social-media';
				}
				break; 
			case 26:
				$table_name = $client_name.'/candidate-civil-check';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-candidate-civil-check';
				}
				break; 
				case 27:
				$table_name = $client_name.'/candidate-right-to-work';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-right-to-work';
				}
				break;
			case 28:
				$table_name = $client_name.'/candidate-sex-offender';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-sex-offender';
				}
				break;
			case 29:
				$table_name = $client_name.'/candidate-politically-exposed';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-politically-exposed';
				}
				break;
			case 30:
				$table_name = $client_name.'/candidate-india-civil-litigation';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-india-civil-litigation';
				}
				break;
			case 31:
				$table_name = $client_name.'/candidate-mca';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-mca';
				}
				break;
			case 32:
				$table_name = $client_name.'/candidate-nric';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-nric';
				}
				break;		
			case 33:
				$table_name = $client_name.'/candidate-gsa';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-gsa';
				}
				break;
			case 34:
				$table_name = $client_name.'/candidate-oig';
				if ($request_from == 'link-for-mobile') {
					$table_name = 'm-oig';
				}
				break;
			default: 
				if ($additional ==1 && $component_id ==0) {
					 $table_name = $client_name.'/candidate-additional';
					 if ($request_from == 'link-for-mobile') {
					$table_name = 'm-additional';
				}
				}else{ 
					$table_name = $client_name.'/candidate-signature';
					if ($request_from == 'link-for-mobile') {
						// $table_name = 'm-consent-form';
						$table_name = 'm-verification-steps';
					}
				}
				break;
		}


		return $table_name;
	}
}