<?php 
   extract($_GET);
   $ticket_class = '';
   $assigned_ticket_class = '';
   
   if (strtolower(uri_string()) == 'factsuite-admin/admin-approval-mechanism') {
      $ticket_class = 'active';
   } else if (strtolower(uri_string()) == 'factsuite-admin/approval-mechanism-setting') {
      $assigned_ticket_class = 'active';
   } else {
      $ticket_class = 'active';
   }
?>

<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
         <div id="FS-candidate-mn" class="add-team">
           <ul class="nav nav-tabs">
               <li class="nav-item">
                  <a class="nav-link <?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/admin-approval-mechanism">Approval List</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link <?php echo $assigned_ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/approval-mechanism-setting">Approval Setting</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
</section>
<section id="pg-cntr">
