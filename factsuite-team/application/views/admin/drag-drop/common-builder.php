<?php 
 
  $view = '';
  $builder = '';
  $view_client = '';
  $fm = '';
  $statusLink = '';

  

  if (isset($details['form_id'])) {
    $fm = '/'.$details['form_id'];
    // $statusLink = '/'.$status;
  }
   // factsuite-outputqc/view-case-detail/1/1
  // factsuite-outputqc/assigned-view-case-detail/1

 if (strtolower(uri_string()) == 'factsuite-admin/form-builder') {
    $builder = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/view-form-builder' || strtolower(uri_string()) == 'factsuite-admin/edit-form-builder'.$fm) {
     $view = 'active';
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
                 <a class="nav-link <?php echo $builder; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/form-builder">Create Form</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link <?php echo $view; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/view-form-builder"> View Forms</a>
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
 