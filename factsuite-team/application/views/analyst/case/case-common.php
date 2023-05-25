<?php 
 
  $client = '';
  $view_client = '';
  $case_id = '';

  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
  }
  
 if (strtolower(uri_string()) == 'factsuite-inputqc/add-new-case') {
    $client = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-inputqc/view-all-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/view-case-detail'.$case_id) {
     $view_client = 'active';
  } else {
    $client = 'active';
  }
?>

<!--Content-->
<section id="pg-cntr">
  <div class="pg-hdr">
     <!--Nav Tabs-->
     <div id="FS-candidate-mn" class="add-team">
        <ul class="nav nav-tabs nav-justified">
           <li class="nav-item">
              <a class="nav-link <?php echo $client; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/add-new-case">Add Case</a>
           </li>
           <li class="nav-item">
              <a class="nav-link <?php echo $view_client; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/view-all-case-list">View Case</a>
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
