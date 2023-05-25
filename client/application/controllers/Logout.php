<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	 
	class Logout extends CI_Controller {

		function client_logout() {
			$this->session->unset_userdata('logged-in-client');
 			redirect($this->config->item('my_base_url').'clientLogin');
		}

		 
	}