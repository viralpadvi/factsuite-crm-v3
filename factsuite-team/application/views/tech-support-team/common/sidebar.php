<?php 
  $ticket_class = '';
  
  if (strtolower(uri_string()) == 'factsuite-tech-support/raise-ticket' || strtolower(uri_string()) == 'factsuite-tech-support/tickets-assigned-to-me') {
    $ticket_class = 'active';
  } else {
    $ticket_class = 'active';
  }
?>
<aside>
   <div class="side-mn">

      <a class="<?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-tech-support/raise-ticket"><i class="fa fa-ticket" aria-hidden="true"></i>Raise a Ticket</a>
      
   </div>
</aside>