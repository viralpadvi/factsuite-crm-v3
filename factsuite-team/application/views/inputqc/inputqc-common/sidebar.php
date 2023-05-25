<?php 
  $dashboard = '';
  $case = '';
  $assignedCase = '';
  $case_id = '';
  $report ='';
  $mandate = '';
  $ticket_class = '';
  $chat = '';
  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
  }
  
  
  if (strtolower(uri_string()) == 'factsuite-admin/home-page') {
    $dashboard = "active";
  } else if (strtolower(uri_string()) == 'factsuite-inputqc/add-new-case' || strtolower(uri_string()) == 'factsuite-inputqc/view-all-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/view-case-detail'.$case_id) {
    $case = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-inputqc/assigned-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/pending-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/assigned-view-case-detail'.$case_id) {
    $assignedCase = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-inputqc/candidate-case-export') {
    $report = 'active';
  }   else if (strtolower(uri_string()) == 'factsuite-inputqc/inputqc-mandate') {
    $mandate = 'active';
  }    else if (strtolower(uri_string()) == 'factsuite-inputqc/internal-chat') {
    $chat = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-inputqc/raise-ticket' || strtolower(uri_string()) == 'factsuite-inputqc/tickets-assigned-to-me') {
    $ticket_class = 'active';
  } else {
    $home = 'active';
  }
?>

<aside>
   <div class="side-mn">
      <a  class="<?php echo $dashboard; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a>

      <a class="<?php echo $assignedCase; ?>" href="<?php echo $this->config->item('my_base_url') ?>factsuite-inputqc/assigned-case-list"><i class="fa fa-user-o" aria-hidden="true"></i>Assigned Case List</a>
      <a class="<?php echo $case; ?>" href="<?php echo $this->config->item('my_base_url') ?>factsuite-inputqc/add-new-case"><i class="fa fa-user-o" aria-hidden="true"></i>Case Management</a>

      <a class="<?php echo $report; ?> " href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/candidate-case-export"><i class="fa fa-globe" aria-hidden="true"></i>MIS Reports</a>

      <a class="<?php echo $mandate; ?> " href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/inputqc-mandate"><i class="fa fa-users" aria-hidden="true"></i>Client Mandate</a>

      <!--   <a class="<?php echo ''; ?> " href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/dynamic-fields"><i class="fa fa-users" aria-hidden="true"></i>Dynamic Fields</a> -->
      
      <a class="<?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/raise-ticket"><i class="fa fa-ticket" aria-hidden="true"></i>Raise a Ticket</a>

      <a class="<?php echo $chat; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/internal-chat"><i class="fa fa-comments-o" aria-hidden="true"></i>Internal Chat</a>
      
      <a target="_blank" href="<?php echo base_url()?>uploads/documentation/troubleshooting_document.pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Documen-<br>tation</a>
   </div>
</aside>
<!--Sidebar--> 