<?php 
  $dashboard = '';
  $case = '';
  $assignedCase = '';
  $case_id = '';
  $ticket_class = '';
  $process ='';
  $mandate ='';
  $chat ='';
  $mis ='';
  $approval ='';
  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
  }
  $mandate ='';
  // 
  $employee = '';
  $education = '';
  if (strtolower(uri_string()) == 'factsuite-admin/home-page') {
    $dashboard = "active";
  } else if (strtolower(uri_string()) == 'factsuite-inputqc/add-new-case' || strtolower(uri_string()) == 'factsuite-inputqc/view-all-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/view-case-detail'.$case_id) {
    $case = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-analyst/assigned-insuff-component-list' || strtolower(uri_string()) == 'factsuite-analyst/assigned-case-list' || strtolower(uri_string()) == 'factsuite-analyst/assigned-case-list' || strtolower(uri_string()) == 'factsuite-analyst/assigned-case-list'.$case_id) {
    $assignedCase = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-analyst/analyst-mandate') {
    $mandate = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-analyst/employee-fields') {
    $employee = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-analyst/dynamic-fields') {
    $education = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-analyst/internal-chat') {
    $chat = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-analyst/client-approval-mechanism') {
    $approval = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-analyst/raise-ticket' || strtolower(uri_string()) == 'factsuite-analyst/tickets-assigned-to-me') {
    $ticket_class = 'active';
  }  else if (strtolower(uri_string()) == 'analyst/export_excel') {
    $mis = 'active';
  } else {
    $home = 'active';
  }

  $url = '';
  $name  = '';


    $userID ='';
    $userRole ='';
    if($this->session->userdata('logged-in-analyst')){

      $analystUser = $this->session->userdata('logged-in-analyst');
        $userID =$analystUser['team_id'];
        $userRole =$analystUser['role'];
    } else if (strtolower(uri_string()) == 'factsuite-analyst/view-process-guidline') {
     $process = 'active';
  }
    else if($this->session->userdata('logged-in-insuffanalyst')){ 
         
        $analystUser = $this->session->userdata('logged-in-insuffanalyst');
        $userID =$analystUser['team_id'];
        $userRole =$analystUser['role'];
        // $courtRecordStatus = $componentData['analyst_status'];
      }



      $an_url = 'factsuite-analyst';
  if($userRole == 'analyst'){
    $url = 'factsuite-analyst/assigned-case-list';
    $name  = 'Assigned Component List';
  }else if($userRole == 'insuff analyst'){
    $url = 'factsuite-analyst/assigned-insuff-component-list';
    $name  = 'All Cases';
     $an_url = 'factsuite-insuff-analyst';
  }else{

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
            <a href="<?php echo $this->config->item('my_base_url').$url?>" class="mn-fnce">&nbsp;</a>
            
        </li>
        <span class="side-mn-txt"><?php echo $name;?></span>

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

      <a class="<?php echo $assignedCase; ?>" href="<?php echo $this->config->item('my_base_url').$url ?>"><i class="fa fa-user-o" aria-hidden="true"></i><?php echo $name;?></a>

      <a class="<?php echo $mis; ?> " href="<?php echo $this->config->item('my_base_url')?>analyst/export_excel"><i class="fa fa-globe" aria-hidden="true"></i>MIS Report</a>
      
      <a class="<?php echo $mandate; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/analyst-mandate"><i class="fa fa-users" aria-hidden="true"></i>Client Mandate</a>
      <?php if($userRole != 'insuff analyst'){ ?>
        <a class="<?php echo $education; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/dynamic-fields"><i class="fa fa-users" aria-hidden="true"></i>Education Database</a>
        <a class="<?php echo $employee; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/employee-fields"><i class="fa fa-users" aria-hidden="true"></i>Employee Database</a>
      <?php } ?>
       <a class="<?php echo $process; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/view-process-guidline"><i class="fa fa-ticket" aria-hidden="true"></i>Process Guidelines</a>

        <a class="<?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/raise-ticket"><i class="fa fa-ticket" aria-hidden="true"></i>Raise a Ticket</a>

        <a class="<?php echo $chat; ?>" href="<?php echo $this->config->item('my_base_url').$an_url;?>/internal-chat"><i class="fa fa-comments-o" aria-hidden="true"></i>Internal Chat</a>

        <!-- <a class="<?php echo $approval; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/client-approval-mechanism"><i class="fa fa-check" aria-hidden="true"></i>Approval Mechanism</a> -->

        <a target="_blank" href="<?php echo base_url()?>uploads/documentation/troubleshooting_document.pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Documen-<br>tation</a>
   </div>
</aside>
<!--Sidebar-->