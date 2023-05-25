<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Load_Database_Model extends CI_Model {

	function __construct() {
	  	parent::__construct();
	  	$this->load->database();
	  	$this->load->helper('url');
	}

	function load_database() {
		return $this->load->database('factsuite_main_website',true);
	}

	function get_crm_database_name() {
		// if (in_array($_SERVER['REMOTE_ADDR'], $this->config->item('ip_localhost_list')) || in_array($_SERVER['SERVER_ADDR'], $this->config->item('ip_localhost_list'))) {
		// 	return 'factsuite-crm-staging';
		// } else if(in_array($_SERVER['REMOTE_ADDR'], $this->config->item('ip_uat_list')) || in_array($_SERVER['SERVER_ADDR'], $this->config->item('ip_uat_list'))) {
		// 	return 'factsuite-crm-staging';
		// } else {
		// 	return 'factsuite-crm-staging';
		// }

		return $this->config->item('factsuite_crm_db');
	}

	function get_fs_website_database_name() {
		// return 'factsuite-main-website-staging';
		return $this->config->item('factsuite_website_db');
	}
}