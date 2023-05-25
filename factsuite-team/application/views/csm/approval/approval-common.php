<?php 
   extract($_GET);
   $ticket_class = '';
   $assigned_ticket_class = '';
   
   if (strtolower(uri_string()) == 'factsuite-csm/client-adding-deletion-approval-mechanism') {
      $ticket_class = 'active';
   } else if (strtolower(uri_string()) == 'factsuite-csm/client-adding-approval-mechanism-rate') {
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
                  <a class="nav-link <?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-csm/client-adding-deletion-approval-mechanism">Client Create / Delete</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link <?php echo $assigned_ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-csm/client-adding-approval-mechanism-rate">Client rate creation/ change</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
</section>
<section id="pg-cntr">