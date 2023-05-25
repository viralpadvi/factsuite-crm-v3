<?php 
  $dashboard = '';
  $case = '';
  $assignedCase = '';
  $case_id = '';
  $mandate = '';
  $ticket_class = '';
  $process = '';
  $chat = '';
  $approval = '';
  $mis = '';
  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
  }
  $employee ='';
  $education ='';
  
  if (strtolower(uri_string()) == 'factsuite-admin/home-page') {
    $dashboard = "active";
  } else if (strtolower(uri_string()) == 'factsuite-inputqc/add-new-case' || strtolower(uri_string()) == 'factsuite-inputqc/view-all-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/view-case-detail'.$case_id) {
    $case = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-specialist/view-all-component-list' || strtolower(uri_string()) == 'factsuite-specialist/assigned-case-list' || strtolower(uri_string()) == 'factsuite-specialist/assigned-case-list'.$case_id || strtolower(uri_string()) == 'factsuite-specialist/qcerror-case-list') {
    $assignedCase = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-specialist/specialist-mandate') {
    $mandate = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-specialist/employee-fields') {
    $employee = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-specialist/dynamic-fields') {
    $education = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-specialist/internal-chat') {
    $chat = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-specialist/internal-chat') {
    $approval = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-specialist/raise-ticket' || strtolower(uri_string()) == 'factsuite-specialist/tickets-assigned-to-me') {
    $ticket_class = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-specialist/view-process-guidline') {
    $process = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-specialist/client-approval-mechanism') {
    $approval = 'active';
  }else if (strtolower(uri_string()) == 'specialist/export_excel') {
    $mis = 'active';
  } else {
    $home = 'active';
  }
?>

<!--Sidebar-->
<!-- <aside>
   <div class="side-mn">
      <a href="#" class="mn-note"><span>3</span></a>
      <ul>
        <li class="mb-0 <?php echo $dashboard; ?>">
            <a href="#" class="mn-dash">&nbsp;</a>
        </li>
        <li class="mb-0 <?php echo $assignedCase; ?>">
            <a href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/assigned-case-list" class="mn-fnce">&nbsp;</a>
            
        </li>
        <span class="side-mn-txt">Assigned&nbsp;Case&nbsp;List</span>

        <li class="mb-0 <?php echo $case; ?> d-none">
          <a href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/add-new-case" class="mn-clnt">&nbsp;</a>
          
        </li>
        <span class="side-mn-txt d-none">Case&nbsp;Management</span>
          
      </ul>
   </div>
</aside> -->
<aside>
   <div class="side-mn">
      <a  class="<?php echo $dashboard; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a>

      <a class="<?php echo $assignedCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/view-all-component-list"><i class="fa fa-user-o" aria-hidden="true"></i>Assigned Case List</a>

      <a class="<?php echo $mis; ?> " href="<?php echo $this->config->item('my_base_url')?>specialist/export_excel"><i class="fa fa-globe" aria-hidden="true"></i>MIS Report</a>
      
      <a class="<?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/raise-ticket"><i class="fa fa-ticket" aria-hidden="true"></i>Raise a Ticket</a>
      
      <a class="<?php echo $mandate; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/specialist-mandate"><i class="fa fa-users" aria-hidden="true"></i>Client Mandate</a>

      <a class="<?php echo $education; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/dynamic-fields"><i class="fa fa-users" aria-hidden="true"></i>Education Database</a>

      <a class="<?php echo $employee; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/employee-fields"><i class="fa fa-users" aria-hidden="true"></i>Employee Database</a>

      <a class="<?php echo $process; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/view-process-guidline"><i class="fa fa-ticket" aria-hidden="true"></i>Process Guidelines</a>

      <a class="<?php echo $chat; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/internal-chat"><i class="fa fa-comments-o" aria-hidden="true"></i>Internal Chat</a>

      <a class="<?php echo $approval; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/client-approval-mechanism"><i class="fa fa-check" aria-hidden="true"></i>Approval Mechanism</a>

      <a target="_blank" href="<?php echo base_url()?>uploads/documentation/troubleshooting_document.pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Documen-<br>tation</a> 
   </div>
</aside>
<!--Sidebar-->