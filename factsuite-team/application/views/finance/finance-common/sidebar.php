<?php 
  extract($_GET);
  $dashboard = '';
  $case = '';
  $assignedCase = '';
  $case_id = '';
  $report = '';
  $ticket_class = '';
  $chat = '';
  $client = '';
  $finance ='';
  $approval ='';
 
  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
  }
  if (isset($index) && isset($candidate_id)) {
    $case_id = '/'.$candidate_id.'/'.$index;
  }

  $request_from = isset($request_from) ? $request_from : '';
  
  
  if (strtolower(uri_string()) == 'factsuite-finance/dashboard') {
    $dashboard = "active";
  } else if (strtolower(uri_string()) == 'factsuite-inputqc/add-new-case' || strtolower(uri_string()) == 'factsuite-inputqc/view-all-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/view-case-detail'.$case_id) {
    $case = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-finance/assigned-case-list' || strtolower(uri_string()) == 'factsuite-finance/view-all-case-list' || strtolower(uri_string()) == 'factsuite-finance/assigned-view-case-detail'.$case_id || strtolower(uri_string()) =='factsuite-finance/view-completed-case-list' || strtolower($request_from) == 'all-cases' || strtolower($request_from) == 'ready-for-billing-cases') {
    $assignedCase = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-finance/candidate-case-export') {
    $report = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-finance/internal-chat') {
    $chat = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-finance/raise-ticket' || strtolower(uri_string()) == 'factsuite-finance/tickets-assigned-to-me') {
    $ticket_class = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-finance/view-all-client') {
    $client = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-finance/approval-mechanism') {
    $approval = 'active';
 
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
      <a  class="<?php echo $dashboard; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a>

      <a class="<?php echo $assignedCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/view-all-case-list"><i class="fa fa-address-card-o" aria-hidden="true"></i>Case List</a>

      <a class="<?php echo $client; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/view-all-client"><i class="fa fa-users" aria-hidden="true"></i>Client</a>

      <a class="<?php echo $report; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/candidate-case-export"><i class="fa fa-globe" aria-hidden="true"></i>MIS Reports</a>
      
      <a target="_blank" href="<?php echo base_url()?>uploads/documentation/troubleshooting_document.pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Documen-<br>tation</a>
      
      <a class="<?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/raise-ticket"><i class="fa fa-ticket" aria-hidden="true"></i>Raise a Ticket</a>
      <?php 
      if ($this->config->item('approval')=='1') {
        ?>
        <a class="<?php echo $approval; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/approval-mechanism"><i class="fa fa-check" aria-hidden="true"></i>Approval Mechanism</a>
        <?php
      }

      ?>

       <a class="<?php echo $chat; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/internal-chat"><i class="fa fa-comments-o" aria-hidden="true"></i>Internal Chat</a>
   </div>
</aside>
<!--Sidebar-->