<?php

class Candidate_API extends CI_Controller{

	function get_header_demo(){
		$data = getallheaders();
		// echo $data['Authorization'];

		$test = 'Bearer sdgdgqrgdfxcgngdfgxvsdagsdfasdfdsfgfhfgnfnghfjrthdfgdfgdfgfhgdfgdsfg';
		if ($test == $data['Authorization']) {
			echo "true";
		}else{
			echo 'false';
		}
	}
}