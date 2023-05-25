<?php 
   extract($_GET);
   $ticket_class = '';
   $assigned_ticket_class = '';
   
   if (strtolower(uri_string()) == 'factsuite-csm/client-adding-deletion-approval-mechanism') {
      $ticket_class = 'active';
   } else if (strtolower(uri_string()) == 'factsuite-csm/tickets-assigned-to-me') {
      $assigned_ticket_class = 'active';
   } else {
      $ticket_class = 'active';
   }
?>

<section id="pg-cntr">