<?php 
 
  $assignedCase = '';
  $assignedclient = '';
  $view_client = '';
  $case_id = '';
  $statusLink = '';
  $assignedCompletedCase = '';
  $assignederrorCase = '';

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

 if (strtolower(uri_string()) == 'factsuite-outputqc/view-all-case-list' || strtolower(uri_string()) == 'factsuite-outputqc/view-case-detail'.$case_id.$statusLink) {
    $assignedclient = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-outputqc/assigned-case-list' || strtolower(uri_string()) == 'factsuite-outputqc/assigned-view-case-detail'.$case_id) {
     $assignedCase = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-outputqc/assigned-completed-case-list') {
     $assignedCompletedCase = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-outputqc/assigned-error-case-list') {
     $assignederrorCase = 'active';
  } 
  // else if (strtolower(uri_string()) == 'factsuite-inputqc/assigned-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/assigned-view-case-detail'.$case_id) {
  //    $view_client = 'active';
  // } 
  else {
    $client = 'active';
  }


  if (isset($_GET['v'])) {
   $v = base64_decode($_GET['v']);
   $assignedCase = '';
    if ($v =='1') {
       $assignedCompletedCase ='active';
    } 
  }

  if (isset($_GET['flag'])) {
        $assignedCase = '';
    if ($_GET['flag'] =='2') {
        $assignederrorCase ='active';
    }
    }
?>

<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
         <div id="FS-candidate-mn" class="add-team w-100">
           <ul class="nav nav-tabs nav-justified">
               <li class="nav-item">
                 <a class="nav-link <?php echo $assignedclient; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/view-all-case-list">All Cases</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link <?php echo $assignedCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/assigned-case-list">New Cases</a>
               </li> 
                <li class="nav-item">
                 <a class="nav-link <?php echo $assignedCompletedCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/assigned-completed-case-list">Completed Cases</a>
               </li>  
               <li class="nav-item">
                 <a class="nav-link <?php echo $assignederrorCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/assigned-error-case-list">Error Bucket</a>
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
