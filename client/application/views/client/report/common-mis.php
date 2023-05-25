<?php 
 
$client_name = '';
  if ($this->session->userdata('logged-in-client')) {

    $client_name = strtolower($this->session->userdata('logged-in-client')['client_name']);
  }
  $client_name = trim(str_replace(' ','-',$client_name));
extract($_GET);
  $all_reports_active = '';
  $insuff_report_active = '';
  $clear_insuff_report_active = '';

  if (strtolower(uri_string()) == 'factsuite-client/candidate-mis-report' || strtolower(uri_string()) == $client_name.'/candidate-mis-report') {
    $all_reports_active = ' active';
  } else if(strtolower(uri_string()) == 'factsuite-client/candidate-mis-insuff-report' || strtolower(uri_string()) == $client_name.'/candidate-mis-insuff-report') {
    $insuff_report_active = ' active';
  } else if(strtolower(uri_string()) == 'factsuite-client/candidate-clear-insuff-report' || strtolower(uri_string()) == $client_name.'/candidate-clear-insuff-report') {
    $clear_insuff_report_active = ' active';
  } else  {
    $all_reports_active = ' active';
  }
?>
?>  

<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
          <div id="FS-candidate-mn" class="add-team">
            <ul class="nav nav-tabs nav-justified">
                
               <li class="nav-item">
            <a class="nav-link<?php echo $all_reports_active;?>" href="<?php echo $this->config->item('my_base_url').$client_name; ?>/candidate-mis-report">All Reports</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $insuff_report_active;?>" href="<?php echo $this->config->item('my_base_url').$client_name; ?>/candidate-mis-insuff-report">Insuff Report</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $clear_insuff_report_active;?>" href="<?php echo $this->config->item('my_base_url').$client_name; ?>/candidate-clear-insuff-report">Insuff Clear Report</a>
          </li>

            </ul>
         </div>
      </div>
   </div>
</section>