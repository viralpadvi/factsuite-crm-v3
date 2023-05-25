<?php 
 
  $client = '';
  $view_client = '';
  $case_id = '';
   $completed ='';
   $insuff ='';
  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
  }
  
 if (strtolower(uri_string()) == 'factsuite-inputqc/add-new-case') {
    $client = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-am/view-all-case-list' ) {
     $view_client = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-am/view-all-completed-case-list' ) {
     $completed = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-am/view-all-insuff-case-list' ) {
     $insuff = 'active';
  } else {
    $client = 'active';
  }
?>

 

<!--Content-->
<section id="pg-cntr">
  <!-- <div class="pg-hdr"> -->
     <!--Nav Tabs-->
     <div id="FS-candidate-mn" class="add-team ">
        <ul class="nav nav-tabs nav-justified">
           
           <li class="nav-item">
              <a class="nav-link <?php echo $view_client; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-am/view-all-case-list">Open Cases</a>
           </li>
           <li class="nav-item">
              <a class="nav-link <?php echo $completed; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-am/view-all-completed-case-list">Completed Cases</a>
           </li>
           <li class="nav-item">
              <a class="nav-link <?php echo $insuff; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-am/view-all-insuff-case-list">Insuff Cases</a>
           </li>
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
