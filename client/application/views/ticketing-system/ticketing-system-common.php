<?php 
   extract($_GET);
   $ticket_class = '';
   $assigned_ticket_class = '';

 $client_name = '';
  if ($this->session->userdata('logged-in-client')) {

    $client_name = strtolower($this->session->userdata('logged-in-client')['client_name']);
  }
  $client_name = trim(str_replace(' ','-',$client_name));
  
   
   if (strtolower(uri_string()) == 'factsuite-client/raise-ticket' || strtolower(uri_string()) == $client_name.'/raise-ticket') {
      $ticket_class = 'active';
   } else if (strtolower(uri_string()) == 'factsuite-client/tickets-assigned-to-me' || strtolower(uri_string()) == $client_name.'/tickets-assigned-to-me') {
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
                  <a class="nav-link <?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url').$client_name; ?>/raise-ticket">Tickets Raised by Me</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link <?php echo $assigned_ticket_class; ?>" href="<?php echo $this->config->item('my_base_url').$client_name; ?>/tickets-assigned-to-me">Tickets Assigned to Me</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
</section>
<section id="pg-cntr">