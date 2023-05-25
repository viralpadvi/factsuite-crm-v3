<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagination_Model extends CI_Model {
	function get_pagination_links($variable_array_2) {
		$config['base_url'] = $variable_array_2['base_url'];
		$config['total_rows'] = $variable_array_2['total_rows'];
        $config['per_page'] = $variable_array_2['per_page'];
        $config['uri_segment'] = 3;
        $config['num_links'] = 3;
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a href="" class="current_page">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        return $config;
	}
}