<?php 
   extract($_GET);
   $ticket_class = '';
   $assigned_ticket_class = '';
   $all_ticket_class = '';

   if (strtolower(uri_string()) == 'factsuite-admin/raise-ticket') {
      $ticket_class = 'active';
   } else if (strtolower(uri_string()) == 'factsuite-admin/tickets-assigned-to-me') {
      $assigned_ticket_class = 'active';
   }  else if (strtolower(uri_string()) == 'factsuite-admin/all-tickets') {
      $all_ticket_class = 'active';
   } else {
      $ticket_class = 'active';
   }
?>

<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
         <!-- add-team-3 -->
         <div id="FS-candidate-mn" class="add-team">
           <ul class="nav nav-tabs">
               <li class="nav-item">
                  <a class="nav-link <?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/raise-ticket">Tickets Raised by Me</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link <?php echo $assigned_ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/tickets-assigned-to-me">Tickets Assigned to Me</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link <?php echo $all_ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/all-tickets">All Tickets</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
</section>
<section id="pg-cntr">