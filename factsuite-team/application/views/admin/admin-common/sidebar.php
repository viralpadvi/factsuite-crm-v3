<?php
  $ticket_class = ''; 
  $dashboard = '';
  $vendor = '';
  $factsuite_team = '';
  $our_business = '';
  $client = '';
  $enquiries = '';
  $check_event_id = '';
  $component = '';
  $viewAllCases = '';
  $form = '';
  $fs_website_services = '';
  $bgv_report = '';
  $report ='';
  $notification = '';
  $city = '';
  $mandate = '';
  $settings = '';
  $show_website_service_link = 0;
  $show_ticket_link = 1;
  $holiday = '';
  $process = '';
  $schedule = '';
  $education = '';
  $employee = '';
  $log = '';
  $email = '';
  $chat = '';
  $builder = '';
  $timezone = '';
  $nomenclature = '';
  $reminder = '';
  $approval = '';
  $approvals = '';
  if (isset($event_id)) {
    $check_event_id = '/'.$event_id;
  }

  if (isset($event_id)) {
    $check_event_id = '/'.$event_id;
  }
  
  if (strtolower(uri_string()) == 'factsuite-admin/dashboard') {
    $dashboard = "active";
  }else if (strtolower(uri_string()) == 'factsuite-admin/dashboard') {
    $notification = "active";
  } else if (strtolower(uri_string()) == 'factsuite-admin/add-new-vendor' || strtolower(uri_string()) == 'factsuite-admin/view-all-active-vendor' || strtolower(uri_string()) == 'factsuite-admin/view-all-inactive-vendor' || strtolower(uri_string()) == 'factsuite-admin/view-all-vendor') {
    $vendor = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/add-team' || strtolower(uri_string()) == 'factsuite-admin/view-team') {
    $factsuite_team = 'active';
  }else if (strtolower(uri_string()) == 'component') {
    $component = 'active';
  } 
  else if (strtolower(uri_string()) == 'wizcraft-admin/view-all-enquiries') { 
  $enquiries = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/add-new-client' || strtolower(uri_string()) == 'factsuite-admin/view-all-client' || strtolower(uri_string()) == 'factsuite-admin/client-email-notifications') {
    $client = 'active';
  } else if (strtolower(uri_string()) == 'wizcraft-admin/view-all-enquiries') { 
    $enquiries = 'active';
  }else if (strtolower(uri_string()) == 'factsuite-admin/view-all-case-list' 
    || strtolower(uri_string()) == 'factsuite-admin/view-case-detail/'.$check_event_id) { 
    $viewAllCases = 'active';
  }else if(strtolower(uri_string()) =='factsuite-admin/form-request'){
    $form = 'active';
  } else if(strtolower(uri_string()) =='factsuite-admin/add-website-services'
    || strtolower(uri_string()) =='factsuite-admin/all-website-services'
    || strtolower(uri_string()) =='factsuite-admin/add-website-package'
    || strtolower(uri_string()) =='factsuite-admin/add-website-package-component-details'
    || strtolower(uri_string()) =='factsuite-admin/add-website-package-alacarte-component-details'
    || strtolower(uri_string()) =='factsuite-admin/all-website-packages'
    || strtolower(uri_string()) =='factsuite-admin/edit-website-package-details'
    || strtolower(uri_string()) =='factsuite-admin/edit-website-package-components'
    || strtolower(uri_string()) =='factsuite-admin/edit-website-package-alacarte-component-details') {
    $fs_website_services = 'active';
  }else if (strtolower(uri_string()) == 'factsuite-admin/factsuite-bgv-interim-cases' 
    || strtolower(uri_string()) == 'factsuite-admin/factsuite-bgv-completed-cases') { 
    $bgv_report = 'active';
  }else if (strtolower(uri_string()) == 'factsuite-admin/inputqc-candidate-case-export' 
    || strtolower(uri_string()) == 'factsuite-admin/outputqc-candidate-case-export' || strtolower(uri_string()) == 'factsuite-admin/candidate-case-export') { 
    $report = 'active';
  }else if (strtolower(uri_string()) == 'factsuite-admin/factsuite-admin/add-view-cities') { 
    $city = 'active';
  }else if (strtolower(uri_string()) == 'mandate') { 
    $mandate = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/raise-ticket' || strtolower(uri_string()) == 'factsuite-admin/tickets-assigned-to-me') {
    $ticket_class = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/priority-rules') {
    $settings = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/holidays') {
    $holiday = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/process-guidline') {
    $process = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/schedule-reporting-time') {
    $schedule = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/education-dynamic-fields') {
    $education = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/employee-dynamic-fields') {
    $employee = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/login-logs') {
    $log = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/email-templates') {
    $email = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/form-builder') {
    $builder = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-admin/timezone') {
    $timezone = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-admin/nomenclature') {
    $nomenclature = 'active';
  } else if(strtolower(uri_string()) == 'factsuite-admin/email-sms-reminders'){
    $reminder = 'active';
  }  else if(strtolower(uri_string()) == 'factsuite-admin/approval-level-mechanism'){
    $approvals = 'active';
  } else if(strtolower(uri_string()) == 'factsuite-admin/approval-mechanism' || strtolower(uri_string()) ==  'factsuite-admin/admin-approval-mechanism'){
    $approval = 'active';
  } else {
    $home = 'active';
  }
?>


<!--Sidebar-->
 
<aside>
   <div class="side-mn">
      <!-- <a  class="<?php echo $dashboard; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a> -->
      <?php 
       $user = '';
       $role_actions = array();
       $mis = '';
       $cases = '';
       $component = '';

       $educations =  array();
        $employments =  array();
        $teams =  array();
        $bgv = '';
        $mandates =  array();
        $tickets =  array();
      if ($this->session->userdata('logged-in-admin')) {
        $user = $this->session->userdata('logged-in-admin');

        if ($user['role'] !='admin') {
          $roles = $this->db->where('role_name',$user['role'])->get('roles')->row_array();
            
          if ($roles['role_action'] !='' && $roles['role_action'] !=null) {
            $role_action = json_decode($roles['role_action'],true);
            $role_actions = $role_action['client'];
            $mis = isset($role_action['mis'])?$role_action['mis']:'';
            $cases = isset($role_action['cases'])?$role_action['cases']:'';
            $component = isset($role_action['component'])?$role_action['component']:'';
            $educations = isset($role_action['education'])?$role_action['education']:array();
            $employments = isset($role_action['employment'])?$role_action['employment']:array();
            $teams = isset($role_action['teams'])?$role_action['teams']:array();
            $bgv = isset($role_action['bgv'])?$role_action['bgv']:'';
            $mandates = isset($role_action['mandate'])?$role_action['mandate']:array();
            $tickets = isset($role_action['ticket'])?$role_action['ticket']:array(); 
          }
        }
      }else if ($this->session->userdata('logged-in-csm')) {
        $user = $this->session->userdata('logged-in-csm');
      }


      if (in_array($user['role'], ['admin','csm']) || count($role_actions) > 0) {
        ?>
      <a class="<?php echo $client; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-new-client"><i class="fa fa-user-o" aria-hidden="true"></i>Client</a>
        <?php
      }
      ?>

      <a class="<?php echo $vendor; ?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-new-vendor"><i class="fa fa-tachometer" aria-hidden="true"></i>Vendor</a>
      <?php 
      if (in_array($user['role'], ['admin','csm']) || $cases =='3') {
        ?>
      <a class="<?php echo $viewAllCases; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/view-all-case-list"><i class="fa fa-address-card-o" aria-hidden="true"></i>All Case</a>
<?php } ?>
      <a class="<?php echo $notification;?> d-none" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/dashboard"><i class="fa fa-bell" aria-hidden="true"></i>Notification &nbsp;&nbsp;&nbsp;<span id="notification-count" class="badge badge-notification right">1</span></a>
        <?php 
      if (in_array($user['role'], ['admin','csm']) || count($teams) > 0) {
        ?>
      <a class="<?php echo $factsuite_team; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-team"><i class="fa fa-users" aria-hidden="true"></i>FS Team</a> 
      <?php } ?>
      <?php if ($show_website_service_link == 1) { ?>
        <a class="<?php echo $fs_website_services; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-website-services"><i class="fa fa-globe" aria-hidden="true"></i>FS Website</a>
      <?php } ?>
        <?php 
      if (in_array($user['role'], ['admin','csm']) || $bgv == 3) {
        ?>
      <a class="<?php echo $bgv_report; ?> " href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/factsuite-bgv-interim-cases"><i class="fa fa-file" aria-hidden="true"></i>BGV Reports</a>
       <?php 
     }

      if (in_array($user['role'], ['admin','csm']) || $mis =='3') {
        ?>
      <a class="<?php echo $report; ?> " href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/candidate-case-export"><i class="fa fa-globe" aria-hidden="true"></i>MIS Reports</a>
    <?php } ?>
      <?php 
      if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a class="<?php echo $form; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/form-request"><i class="fa fa-file-text" aria-hidden="true"></i>Form Request</a>
    <?php 
      }
      if (in_array($user['role'], ['admin','csm']) || $component =='3') {
        ?>
      <a class="<?php echo $component; ?>" href="<?php echo $this->config->item('my_base_url')?>component"><i class="fa fa-cog" aria-hidden="true"></i>Component</a>
      <?php } ?>
        <?php 
      if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a target="_blank" href="<?php echo base_url()?>uploads/documentation/troubleshooting_document.pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Documen-<br>tation</a>
        <?php 
      }
      if (in_array($user['role'], ['admin','csm'])  || count($mandates) > 0) {
        ?>
      <a class="<?php echo $mandate; ?>" href="<?php echo $this->config->item('my_base_url')?>mandate"><i class="fa fa-cog" aria-hidden="true"></i>Client Mandate</a>
        <?php 
      }
      if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a class="<?php echo $city; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-view-cities"><i class="fa fa-cog" aria-hidden="true"></i>City</a>
        <?php 
      }
      if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a class="<?php echo $settings; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/priority-rules"><i class="fa fa-cog" aria-hidden="true"></i>Settings</a>
      <?php 
      }
      ?>
        <?php 
      if (in_array($user['role'], ['admin','csm'])  || count($tickets) > 0) {
        ?>
      <?php if ($show_ticket_link == 1) { ?>
        <a class="<?php echo $ticket_class; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/raise-ticket"><i class="fa fa-ticket" aria-hidden="true"></i>Tickets</a>
      <?php }
        }
       ?>
        <?php 
      if (in_array($user['role'], ['admin','csm'])  || count($educations) > 0) {
        ?>
      <a class="<?php echo $education; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/education-dynamic-fields"><i class="fa fa-ticket" aria-hidden="true"></i>Education Database</a>
        <?php 
      }
      if (in_array($user['role'], ['admin','csm'])  || count($employments) > 0) {
        ?>
      <a class="<?php echo $employee; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/employee-dynamic-fields"><i class="fa fa-ticket" aria-hidden="true"></i>Employment Database</a>
        <?php 
      }
      if (in_array($user['role'], ['admin','csm']) ) {
        ?>
      <a class="<?php echo $holiday; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/holidays"><i class="fa fa-ticket" aria-hidden="true"></i>Add Holidays</a>
        <?php 
      }
      if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a class="<?php echo $process; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/process-guidline"><i class="fa fa-ticket" aria-hidden="true"></i>Process Guidelines</a>
        <?php 
      }
      if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a class="<?php echo $process; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/schedule-reporting-time"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Schedule Reporting</a>
    <?php }  
     if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a class="<?php echo $log; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/login-logs"><i class="fa fa-history " aria-hidden="true"></i>Login Logs</a>
    <?php } 
    if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a class="<?php echo $email; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/email-templates"><i class="fa fa-envelope" aria-hidden="true"></i>Email Templates</a>
    <?php } 
     if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a class="<?php echo $chat; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/internal-chat"><i class="fa fa-comments-o" aria-hidden="true"></i>Internal Chat</a>
    <?php } 
    if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a class="<?php echo $builder; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/form-builder"><i class="fa fa-wpforms" aria-hidden="true"></i>Form Builder</a>
    <?php } 

     if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a class="<?php echo $timezone; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/timezone"><i class="fa fa-clock-o" aria-hidden="true"></i>Timezone</a>
    <?php }  

     if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a class="<?php echo $nomenclature; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/nomenclature"><i class="fa fa-check-square" aria-hidden="true"></i>Client Nomenclature</a>
    <?php } 
   
     if (in_array($user['role'], ['admin','csm'])) {
        ?>
      <a class="<?php echo $reminder; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/email-sms-reminders"><i class="fa fa-bell" aria-hidden="true"></i>Reminder</a>
    <?php } 
      if ($this->config->item('approval') == '1') {  
     if (trim(strtolower($user['role']))=='it administrator'){
        ?>
         <a class="<?php echo $approvals; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/approval-level-mechanism"><i class="fa fa-check" aria-hidden="true"></i>Approval Level Mechanism</a>
         
      <a class="<?php echo $approval; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/approval-mechanism"><i class="fa fa-check" aria-hidden="true"></i>Approval Mechanism</a>
    <?php } 
    
     if (in_array($user['role'], ['admin','csm'])) {
        ?>

      <a class="<?php echo $approval; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/admin-approval-mechanism"><i class="fa fa-check" aria-hidden="true"></i>Approval Mechanism</a>
    <?php } 

  }
    ?>
      <!-- <div class="mb-5 pb-5"></div> -->
   </div>
</aside>
<!--Sidebar-->

<!-- factsuite-admin/factsuite-bgv-interim-cases
factsuite-admin/factsuite-bgv-completed-cases -->