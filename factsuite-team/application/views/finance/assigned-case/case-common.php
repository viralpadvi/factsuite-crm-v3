<?php 
   extract($_GET);
  $assignedCase = '';
  $assignedclient = '';
  $view_client = '';
  $case_id = '';
  $statusLink = '';
  $assignedCompletedCase = '';
  $assignederrorCase = '';
  $saved_summary ='';
  if (isset($candidate_id) && isset($status)) {
    $case_id = '/'.$candidate_id;
    $statusLink = '/'.$status;
  }

  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
    // $statusLink = '/'.$status;
  }
   // factsuite-outputqc/view-case-detail/1/1
  // factsuite-outputqc/assigned-view-case-detail/1

  $request_from = isset($request_from) ? $request_from : '';

  if ($request_from =='pending-cases') {
     $assignedCase ='active';
  }

 if (strtolower(uri_string()) == 'factsuite-finance/view-all-case-list' || strtolower(uri_string()) == 'factsuite-finance/view-case-detail'.$case_id.$statusLink || strtolower($request_from) == 'all-cases') {
    $assignedclient = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-finance/partially-billed-cases' || strtolower(uri_string()) == 'factsuite-finance/assigned-view-case-detail'.$case_id) {
     $assignedCase = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-finance/view-completed-case-list' || strtolower($request_from) == 'ready-for-billing-cases') {
     $assignedCompletedCase = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-finance/assigned-error-case-list') {
     $assignederrorCase = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-finance/requiest-finance-case-summary') {
     $saved_summary = 'active';
  } 
  // else if (strtolower(uri_string()) == 'factsuite-inputqc/assigned-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/assigned-view-case-detail'.$case_id) {
  //    $view_client = 'active';
  // } 
  else {
    $client = 'active';
  }
?>

<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
         <div id="FS-candidate-mn" class="add-team w-100">
           <ul class="nav nav-tabs nav-justified">
            
               <li class="nav-item">
                 <a class="nav-link <?php echo $assignedclient; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/view-all-case-list">All cases</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link <?php echo $assignedCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/partially-billed-cases">Partially Billed Cases</a>
               </li> 
                <li class="nav-item">
                 <a class="nav-link <?php echo $assignedCompletedCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/view-completed-case-list">Ready For Billing</a>
               </li>  
                  <li class="nav-item">
                 <a class="nav-link <?php echo $saved_summary; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/requiest-finance-case-summary">Saved Summary</a>
               </li>  
                                
            </ul>
         </div>
      </div>
   </div>
</section>
<section id="pg-cntr">
  <div class="pg-hdr">
     <!--Nav Tabs-->
     <!-- <div id="FS-candidate-mn" class="add-team">
        <ul class="nav nav-tabs nav-justified">
            <li class="nav-item">
              <a class="nav-link <?php echo $assignedclient; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/view-all-case-list">All cases</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo $assignedCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/assigned-case-list">My Queue Cases</a>
            </li>   -->
           <!-- <li class="nav-item">
              <a class="nav-link <?php //echo $view_client; ?>" href="<?php //echo $this->config->item('my_base_url')?>factsuite-admin/view-all-client">View Case</a>
           </li> -->
           <!-- <li class="nav-item">
              <a class="nav-link" href="#">Analytics</a>
           </li> -->
          <!--  <li class="nav-item">
              <a class="nav-link" href="add-packages.html">Add Packages</a>
           </li>
           <li class="nav-item">
              <a class="nav-link" href="add-component.html">Add Component</a>
           </li>
           <li class="nav-item">
              <a class="nav-link" href="view-component.html">View Component/Packages</a>
           </li> -->
           <!-- <li class="nav-item">
              <a class="nav-link" href="feedback.html">Feedback</a>
           </li> -->
        </ul>
     </div>
     <!--Nav Tabs-->
  </div>
