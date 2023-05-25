<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	 
	class Logout extends CI_Controller {

		function admin_logout() {
			$this->session->unset_userdata('logged-in-admin');
 			redirect($this->config->item('my_base_url').'login');
		}

		function inoutqc_logout() {
			$this->session->unset_userdata('logged-in-inoutqc');
 			redirect($this->config->item('my_base_url').'login');
		}

		function analyst_logout() {
			$this->session->unset_userdata('logged-in-analyst');
 			redirect($this->config->item('my_base_url').'login');
		}

		function outputqc_logout() {
			$this->session->unset_userdata('logged-in-outputqc');
 			redirect($this->config->item('my_base_url').'login');
		}


		function specialist_logout() {
			$this->session->unset_userdata('logged-in-specialist');
 			redirect($this->config->item('my_base_url').'login');
		}

		function am_logout() {
			$this->session->unset_userdata('logged-in-am');
 			redirect($this->config->item('my_base_url').'login');
		}

		function csm_logout() {
			$this->session->unset_userdata('logged-in-csm');
 			redirect($this->config->item('my_base_url').'login');
		}

		function tech_support_logout() {
			$this->session->unset_userdata('logged-in-tech-support');
 			redirect($this->config->item('my_base_url').'login');
		}
	}