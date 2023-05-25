<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	// function addBusinessDays($startDate='', $businessDays='', $holidays=''){
	function addBusinessDays(){
		$startDate=date("Y-m-d H:i:s");
		$businessDays=15;
		// $holidays=array('2021-08-25');
		$holidays=array();
	    $date = strtotime($startDate);
	    $i = 0;
	    
	    while($i < $businessDays)
	    {
	        //get number of week day (1-7)
	        $day = date('N',$date);
	        //get just Y-m-d date
	        $dateYmd = date("Y-m-d",$date);

	        if($day < 6 && !in_array($dateYmd, $holidays)){
	            $i++;
	        }       
	        $date = strtotime($dateYmd . ' +1 day');
	    }       
	    print_r(date("Y-m-d H:i:s"));
	    echo "<br>";
    	print_r(date('Y-m-d H:i:s',$date));

	}
}
