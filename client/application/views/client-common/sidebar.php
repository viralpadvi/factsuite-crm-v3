<?php 
  $dashboard = '';
  $case = '';
  $factsuite_team = '';
  $our_business = '';
  $client = '';
  $enquiries = '';
  $check_event_id = '';
  $component = '';
  $ticket_class = '';

  if (isset($event_id)) {
    $check_event_id = '/'.$event_id;
  }

   $check_candidate_id ='';
  if (isset($candidate_id)) {
    $check_candidate_id = '/'.$candidate_id;
  }
  // session_start();

  $mis = '';
  $client_name = '';
  if ($this->session->userdata('logged-in-client')) {
    $client_name = strtolower($this->session->userdata('logged-in-client')['client_name']);
  }
  $client_name = trim(str_replace(' ','-',$client_name));
  
  if (strtolower(uri_string()) == 'factsuite-client/home-page' || strtolower(uri_string()) == $client_name.'/home-page') {
    $dashboard = "active";
  } else if (strtolower(uri_string()) == 'factsuite-client/all-cases' || strtolower(uri_string()) == $client_name.'/all-cases' || strtolower(uri_string()) == 'factsuite-client/add-case' || strtolower(uri_string()) == 'factsuite-client/view-single-case'.$check_candidate_id  || strtolower(uri_string()) == $client_name.'/view-single-case'   || strtolower(uri_string()) == $client_name.'/edit-case') {
    $case = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/add-team' || strtolower(uri_string()) == 'wizcraft-admin/view-all-media') {
    $factsuite_team = 'active';
  } else if (strtolower(uri_string()) == 'wizcraft-admin/our-businesses' || strtolower(uri_string()) == 'wizcraft-admin/view-all-media') {
    $our_business = 'active'; 
  } else if (strtolower(uri_string()) == 'factsuite-client/raise-ticket' || strtolower(uri_string()) == $client_name.'/raise-ticket' || strtolower(uri_string()) == 'factsuite-client/tickets-assigned-to-me' || strtolower(uri_string()) == $client_name.'/tickets-assigned-to-me') {
    $ticket_class = 'active';
  } else if (strtolower(uri_string()) == 'wizcraft-admin/add-event' || strtolower(uri_string()) == 'wizcraft-admin/view-all-events' || strtolower(uri_string()) == 'wizcraft-admin/view-all-events-case-studies'.$check_event_id) {
    $our_events = 'active';
  } else if (strtolower(uri_string()) == 'component') {
    $component = 'active';
  } 
  else if (strtolower(uri_string()) == 'wizcraft-admin/view-all-enquiries') { 
  $enquiries = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/add-new-client' || strtolower(uri_string()) == 'factsuite-admin/view-all-client') {
    $client = 'active';
  } else if (strtolower(uri_string()) == 'wizcraft-admin/view-all-enquiries') { 
    $enquiries = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-client/candidate-mis-report') { 
    $mis = 'active';
  }
  else {
   $dashboard= 'active';
  }
?>

<!--Sidebar-->
<aside>
   <div class="side-mn">
      <!-- <a href="#" class="mn-note"><span>3</span></a>
      <ul>
         <li class="<?php echo $dashboard; ?>"><a href="<?php echo $this->config->item('my_base_url')?>factsuite-client/home-page" class="mn-dash">&nbsp;</a></li>
         <li class="<?php echo $case; ?>"><a href="<?php echo $this->config->item('my_base_url')?>factsuite-client/all-cases" class="mn-doc">&nbsp;</a></li> -->
         <!-- <li><a href="summary.html" class="mn-summary">&nbsp;</a></li>
         <li><a href="compose.html" class="mn-chat">&nbsp;</a></li> -->
     <!--  </ul> -->
      <a  class="<?php echo $dashboard; ?>" href="<?php echo $this->config->item('my_base_url').$client_name; ?>/home-page"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a>
      
      <a  class="<?php echo $case; ?>" href="<?php echo $this->config->item('my_base_url').$client_name; ?>/all-cases"><i class="fa fa-id-card-o" aria-hidden="true"></i>All-cases</a>

      <a  class="<?php echo $mis; ?>" href="<?php echo $this->config->item('my_base_url').$client_name.'/candidate-mis-report'; ?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i>MIS Report</a>

      <a class="<?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url').$client_name; ?>/raise-ticket"><i class="fa fa-ticket" aria-hidden="true"></i>Raise a Ticket</a>

      
      <a class="d-none"  href="<?php echo $this->config->item('my_base_url')?>factsuite-client/finance-summary"><i class="fas fa-hand-holding-usd" aria-hidden="true"></i>Finance Summary</a>

      <a target="_blank" href="<?php echo base_url()?>assets/client/doc/User_Guide_CRM_Client_Module.pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Documen-<br>tation</a>

   </div>
</aside>
<!--Sidebar-->