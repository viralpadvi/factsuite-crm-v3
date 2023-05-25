<?php 
 
  $client = '';
  $view_client = '';
  $case_id = '';
  $bulk = '';

  if (isset($candidate_id)) {
    $case_id = '/'.$candidate_id;
  }
  
 if (strtolower(uri_string()) == 'factsuite-inputqc/add-new-case') {
    $client = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-inputqc/view-all-case-list' || strtolower(uri_string()) == 'factsuite-inputqc/view-case-detail'.$case_id) {
     $view_client = 'active';
  }else if (strtolower(uri_string()) == 'factsuite-inputqc/bulk-cases') {
    $bulk = 'active';
  } else {
    $client = 'active';
  }
?>

<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
         <div id="FS-candidate-mn" class="add-team">
           <ul class="nav nav-tabs nav-justified">
              <li class="nav-item">
                 <a class="nav-link <?php echo $client; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/add-new-case">Add Case</a>
              </li>
              <li class="nav-item">
                 <a class="nav-link <?php echo $view_client; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/view-all-case-list">View Case</a>
              </li>  
              <li class="nav-item">
                 <a class="nav-link <?php echo $bulk; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-inputqc/bulk-cases">Bulk Cases</a>
              </li>                
            </ul>
         </div>
      </div>
   </div>
</section>
<!--Content-->
<section id="pg-cntr">
  <div class="pg-hdr">
      
     </div>
     <!--Nav Tabs-->
  </div>
