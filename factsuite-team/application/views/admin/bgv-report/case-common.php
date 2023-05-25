<?php 
 
  $completedCases = '';
  $allCase = '';
  $view_client = '';
  $case_id = '';
  $statusLink = '';

  

  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
    // $statusLink = '/'.$status;
  }
   // factsuite-outputqc/view-case-detail/1/1
  // factsuite-outputqc/assigned-view-case-detail/1

 if (strtolower(uri_string()) == 'factsuite-admin/factsuite-bgv-interim-cases' || strtolower(uri_string()) == 'factsuite-outputqc/view-case-detail'.$case_id.$statusLink) {
    $allCase = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/factsuite-bgv-completed-cases' || strtolower(uri_string()) == 'factsuite-admin/factsuite-bgv-completed-cases'.$case_id) {
     $completedCases = 'active';
  }   
  else {
    $client = 'active';
  }
?>

<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
         <div id="FS-candidate-mn" class="add-team">
           <ul class="nav nav-tabs nav-justified">
               <li class="nav-item">
                 <a class="nav-link <?php echo $allCase; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/factsuite-bgv-interim-cases">All cases</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link <?php echo $completedCases; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/factsuite-bgv-completed-cases"> Completed Cases</a>
               </li>                  
            </ul>
         </div>
      </div>
   </div>
</section>
<section id="pg-cntr">
  <div class="pg-hdr">
  </div>
</section>
 