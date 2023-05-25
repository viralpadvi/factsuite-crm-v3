<?php 
  $dashboard = '';
  $case = '';
  $assignedCase = '';
  $case_id = '';
  $report = '';
  $mandate = '';
  $ticket_class = '';
  $chat = '';

  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
  }
  if (isset($index) && isset($candidate_id)) {
    $case_id = '/'.$candidate_id.'/'.$index;
  }
  
  
  if (strtolower(uri_string()) == 'factsuite-admin/home-page') {
    $dashboard = "active";
  } else if (strtolower(uri_string()) == 'factsuite-inputqc/add-new-case' || strtolower(uri_string()) == 'factsuite-inputqc/view-all-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/view-case-detail'.$case_id) {
    $case = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-outputqc/assigned-case-list' || strtolower(uri_string()) == 'factsuite-outputqc/view-all-case-list' || strtolower(uri_string()) == 'factsuite-outputqc/assigned-view-case-detail'.$case_id || strtolower(uri_string()) =='factsuite-outputqc/component-detail'.$case_id) {
    $assignedCase = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-outputqc/candidate-case-export') {
    $report = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-outputqc/outputqc-mandate') {
    $mandate = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-outputqc/internal-chat') {
    $chat = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-outputqc/raise-ticket' || strtolower(uri_string()) == 'factsuite-outputqc/tickets-assigned-to-me') {
    $ticket_class = 'active';
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
      </ul>
   </div>
</aside> -->
<aside>
   <div class="side-mn">
      <a  class="<?php echo $dashboard; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a>

      <a class="<?php echo $assignedCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/assigned-case-list"><i class="fa fa-address-card-o" aria-hidden="true"></i>Case List</a>

      <a class="<?php echo $report; ?> " href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/candidate-case-export"><i class="fa fa-globe" aria-hidden="true"></i>MIS Reports</a>

      <a class="<?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/raise-ticket"><i class="fa fa-ticket" aria-hidden="true"></i>Raise a Ticket</a>
      
      <a class="<?php echo $mandate; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/outputqc-mandate"><i class="fa fa-users" aria-hidden="true"></i>Client Mandate</a>

       <a class="<?php echo $chat; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/internal-chat"><i class="fa fa-comments-o" aria-hidden="true"></i>Internal Chat</a>
      
      <!--   <a class="<?php echo ''; ?> " href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/dynamic-fields"><i class="fa fa-users" aria-hidden="true"></i>Dynamic Fields</a> -->
      
      <a target="_blank" href="<?php echo base_url()?>uploads/documentation/troubleshooting_document.pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Documen-<br>tation</a>
   </div>
</aside>
<!--Sidebar-->