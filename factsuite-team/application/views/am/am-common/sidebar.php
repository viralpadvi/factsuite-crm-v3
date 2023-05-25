<?php 
  $dashboard = '';
  $case = '';
  $assignedCase = '';
  $case_id = '';
  $bulk = '';
  $ticket_class = '';
  $mandate = '';
  $report = '';
  $chat = '';
  $approval = '';
  $approver = '';
  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
  }
  
  
  if (strtolower(uri_string()) == 'factsuite-admin/home-page') {
    $dashboard = "active";
  }else if (strtolower(uri_string()) == 'factsuite-am/view-all-case-list' || strtolower(uri_string()) == 'factsuite-am/view-case-detail'.$case_id || strtolower(uri_string()) == 'factsuite-inputqc/assigned-view-case-detail'.$case_id) {
    $assignedCase = 'active';
  } else if(strtolower(uri_string()) == 'factsuite-am/bulk-cases' ){
    $bulk = 'active';
  }   else if (strtolower(uri_string()) == 'factsuite-am/client-mandate') {
    $mandate = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-am/candidate-case-export') {
    $report = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-am/internal-chat') {
    $chat = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-am/raise-ticket' || strtolower(uri_string()) == 'factsuite-am/tickets-assigned-to-me') {
    $ticket_class = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-am/approval-mechanism') {
    $approval = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-csm/approval-level-mechanism') {
    $approver = 'active';
  } else {
    $home = 'active';
  }
?>
<aside>
   <div class="side-mn">
      <a  class="<?php echo $assignedCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-am/view-all-case-list" ><i class="fa fa-address-card-o" aria-hidden="true"></i>All Cases</a> 

      <a class="<?php echo $mandate; ?> " href="<?php echo $this->config->item('my_base_url')?>factsuite-am/client-mandate"><i class="fa fa-users" aria-hidden="true"></i>Client Mandate</a>

      <a class="<?php echo $report; ?> " href="<?php echo $this->config->item('my_base_url')?>factsuite-am/candidate-case-export"><i class="fa fa-file-excel-o" aria-hidden="true"></i>MIS Report</a>
      
      <a class="<?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-am/raise-ticket"><i class="fa fa-ticket" aria-hidden="true"></i>Raise a Ticket</a>

      <a class="<?php echo $bulk; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-am/bulk-cases"><i class="fa fa-address-card-o" aria-hidden="true"></i>Bulk Cases</a>
      
      <a class="<?php echo $chat; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-am/internal-chat"><i class="fa fa-comments-o" aria-hidden="true"></i>Internal Chat</a>
       <?php 
      if ($this->config->item('approval') == '1') { 
      ?>
      
      <a class="<?php echo $approver; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-am/approval-level-mechanism"><i class="fa fa-check" aria-hidden="true"></i>Approver Level Mechanism</a>
      <?php 
        }
      ?>


      <!-- <a class="<?php echo $approval; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-am/approval-mechanism"><i class="fa fa-comments-o" aria-hidden="true"></i>Approval Mechanism</a> -->
      
      <a target="_blank" href="<?php echo base_url()?>uploads/documentation/troubleshooting_document.pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Documen-<br>tation</a> 

      
   </div>
</aside>
 