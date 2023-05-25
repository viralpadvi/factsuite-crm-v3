<?php

class Custom_Util_Model extends CI_Model {

	function get_current_date_time($date_time_format = '') {
		if ($date_time_format == '') {
			return date('Y-m-d H:i:s'); 
		} else {
			return date($date_time_format); 
		}
	}
} ?>