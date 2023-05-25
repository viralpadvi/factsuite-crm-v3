<?php 
 
  $client = '';
  $view_client = '';
  $check_event_id = '';
  $client_tat = '';
  $client_setting = '';
  $client_notification = '';
  if (isset($event_id)) {
    $check_event_id = '/'.$event_id;
  }
  
 if (strtolower(uri_string()) == 'factsuite-admin/email-sms-reminders') {
    $client = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/view-email-sms-reminders') {
     $view_client = 'active';
  }else {
    $client = 'active';
  }
?>
  
<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div id="FS-candidate-mn" class="add-team main-nav-tabs-div-3">
        <ul class="nav nav-tabs nav-justified">
         
           <li class="nav-item">
              <a class="nav-link <?php echo $client; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/email-sms-reminders">Add Schedule</a>
           </li>
           
           <li class="nav-item">
              <a class="nav-link <?php echo $view_client; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/view-email-sms-reminders">View Schedule</a>
           </li>
          
        </ul>
     </div>
     <!--Nav Tabs-->
   </div>
    </div>
  </div>
</section>

<section id="pg-cntr">
  <div class="pg-hdr">
     <!--Nav Tabs-->
      <!-- <div id="FS-candidate-mn" class="add-team">
        <ul class="nav nav-tabs nav-justified">
           <li class="nav-item">
              <a class="nav-link <?php echo $client; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-new-client">Add Client</a>
           </li>
           <li class="nav-item">
              <a class="nav-link <?php echo $view_client; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/view-all-client">View Client</a>
           </li>
           <li class="nav-item d-none">
              <a class="nav-link" href="#">Analytics</a>
           </li> -->
          <!--  <li class="nav-item">
              <a class="nav-link" href="add-packages.html">Add Packages</a>
           </li>
           <li class="nav-item">
              <a class="nav-link" href="add-component.html">Add Component</a>
           </li>
           <li class="nav-item">
              <a class="nav-link" href="view-component.html">View Component/Packages</a>
           </li> -->
         <!--   <li class="nav-item d-none">
              <a class="nav-link" href="feedback.html">Feedback</a>
           </li>
        </ul> -->
     <!-- </div> -->
     <!--Nav Tabs-->
   </div>