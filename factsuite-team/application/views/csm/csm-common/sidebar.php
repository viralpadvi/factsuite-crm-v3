<?php 
  $dashboard = '';
  $case = '';
  $assignedCase = '';
  $case_id = '';
  $bulk = '';
  $ticket_class = '';
  $component = '';
  $city = '';
  $mandate = '';
  $bgv_report = '';
  $report = '';
  $client ='';
  $chat ='';
  $approval = '';
  $approver = '';
  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
  }
  
  
  if (strtolower(uri_string()) == 'factsuite-csm/dashboard') {
    $dashboard = "active";
  }else if (strtolower(uri_string()) == 'factsuite-csm/view-all-case-list' || strtolower(uri_string()) == 'factsuite-csm/view-case-detail'.$case_id || strtolower(uri_string()) == 'factsuite-inputqc/assigned-view-case-detail'.$case_id) {
    $assignedCase = 'active';
  } else if(strtolower(uri_string()) == 'factsuite-csm/bulk-cases' ){
    $bulk = 'active';
  } else if(strtolower(uri_string()) == 'factsuite-csm/component' ){
    $component = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/add-new-client' || strtolower(uri_string()) == 'factsuite-admin/view-all-client') {
    $client = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-csm/raise-ticket' || strtolower(uri_string()) == 'factsuite-csm/tickets-assigned-to-me') {
    $ticket_class = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-csm/add-view-cities') {
    $city = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-csm/client-mandate') {
    $mandate = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-csm/internal-chat') {
    $chat = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-csm/client-adding-deletion-approval-mechanism' || strtolower(uri_string()) == 'factsuite-csm/client-adding-approval-mechanism-rate') {
    $approval = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-csm/approval-level-mechanism') {
    $approver = 'active';
  }else if (strtolower(uri_string()) == 'factsuite-admin/factsuite-bgv-interim-cases' 
    || strtolower(uri_string()) == 'factsuite-admin/factsuite-bgv-completed-cases') { 
    $bgv_report = 'active';
  }else if (strtolower(uri_string()) == 'factsuite-admin/inputqc-candidate-case-export' 
    || strtolower(uri_string()) == 'factsuite-admin/outputqc-candidate-case-export' || strtolower(uri_string()) == 'factsuite-admin/candidate-case-export') { 
    $report = 'active';
  } else {
    $home = 'active';
  }
?>
<aside>
   <div class="side-mn">
     <a  class="<?php echo $dashboard; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-csm/dashboard" ><i class="fa fa-address-card-o" aria-hidden="true"></i>Dashboard</a> 

      <a  class="<?php echo $assignedCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-csm/view-all-case-list" ><i class="fa fa-address-card-o" aria-hidden="true"></i>Assigned&nbsp;Case List</a> 

      <a class="<?php echo $client; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-new-client"><i class="fa fa-user-o" aria-hidden="true"></i>Client</a>
      
      <a class="<?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-csm/raise-ticket"><i class="fa fa-ticket" aria-hidden="true"></i>Raise a Ticket</a>

      <a class="<?php echo $bulk; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-csm/bulk-cases"><i class="fa fa-address-card-o" aria-hidden="true"></i>Bulk Cases</a>

      <a class="<?php echo $bgv_report; ?> " href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/factsuite-bgv-interim-cases"><i class="fa fa-file" aria-hidden="true"></i>BGV Reports</a>
      
      <a class="<?php echo $report; ?> " href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/candidate-case-export"><i class="fa fa-globe" aria-hidden="true"></i>MIS Reports</a>
      
      <a class="<?php echo $component; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-csm/component"><i class="fa fa-address-card-o" aria-hidden="true"></i>Components</a>
      
      <a class="<?php echo $mandate; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-csm/client-mandate"><i class="fa fa-address-card-o" aria-hidden="true"></i>Client Mandate</a>
      <a class="<?php echo $city; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-csm/add-view-cities"><i class="fa fa-address-card-o" aria-hidden="true"></i>City</a>
      <a class="<?php echo $chat; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-csm/internal-chat"><i class="fa fa-comments-o" aria-hidden="true"></i>Internal Chat</a>
      <?php 
      if ($this->config->item('approval') == '1') { 
      ?>
      <a class="<?php echo $approver; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-csm/approval-level-mechanism"><i class="fa fa-check" aria-hidden="true"></i>Approver Level Mechanism</a>
      <?php 
        }
      ?>

      <?php 
      if ($this->config->item('approval') == '1') { 
      ?>
      <a class="<?php echo $approval; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-csm/client-adding-deletion-approval-mechanism"><i class="fa fa-check" aria-hidden="true"></i>Approval Mechanism</a>
      <?php 
        }
      ?>
      <a  target="_blank" href="<?php echo base_url()?>uploads/documentation/troubleshooting_document.pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Documen-<br>tation</a> 

      
   </div>
</aside>
 