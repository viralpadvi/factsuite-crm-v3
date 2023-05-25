<?php 
 
  $escalatory_notiications = '';
  $client_notification = '';
  
 if (strtolower(uri_string()) == 'factsuite-admin/priority-rules') {
    $escalatory_notiications = ' active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/client-email-notifications') {
    $client_notification = ' active';
  } else {
    $escalatory_notiications = ' active';
  }
?>
<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
        <div id="FS-candidate-mn" class="add-team">
          <ul class="nav nav-tabs nav-justified">
            <li class="nav-item">
              <a class="nav-link<?php echo $escalatory_notiications;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/priority-rules">Escalatory Notifications</a>
            </li>
          </ul>     
        </div>
      </div>
   </div>
</section>
<section id="pg-cntr">
  <div class="pg-hdr">
    
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >