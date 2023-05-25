<?php 
 
  $assignedCase = '';
  $assignedclient = '';
  $view_client = '';
  $case_id = '';

  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
  }
  
 if (strtolower(uri_string()) == 'factsuite-inputqc/add-new-case') {
    $assignedclient = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-inputqc/assigned-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/assigned-view-case-detail'.$case_id) {
     $assignedCase = 'active';
  } 
  // else if (strtolower(uri_string()) == 'factsuite-inputqc/assigned-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/assigned-view-case-detail'.$case_id) {
  //    $view_client = 'active';
  // } 
  else {
    $client = 'active';
  }
?>

<!--Content-->
<!-- <section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
         <div id="FS-candidate-mn" class="add-team">
            <ul class="nav nav-tabs nav-justified">
               <li class="nav-item d-none">
                 <a class="nav-link <?php echo $assignedCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/assigned-case-list">Input Queue Case</a>
               </li>
               <li class="nav-item d-none">
                 <a class="nav-link <?php echo $assignedclient; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/assigned-case-list">Closer Case</a>
               </li>                 
            </ul>
         </div>
      </div>
   </div>
</section> -->
<section id="pg-cntr">
  <div class="pg-hdr">
     <!--Nav Tabs-->
      <!-- <div id="FS-candidate-mn" class="add-team">
        <ul class="nav nav-tabs nav-justified">
            <li class="nav-item d-none">
              <a class="nav-link <?php echo $assignedCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/assigned-case-list">Input Queue Case</a>
            </li>
            <li class="nav-item d-none">
              <a class="nav-link <?php echo $assignedclient; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/assigned-case-list">Closer Case</a>
            </li>            
        </ul>
     </div> -->
     <!--Nav Tabs-->
  </div>
