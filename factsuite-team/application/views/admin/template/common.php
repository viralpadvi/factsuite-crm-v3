<?php 
 
  $templates = '';
  $view_client = '';
  $check_event_id = '';
  $client_tat = '';
  $url = '';
  if (isset($event_id)) {
    $check_event_id = '/'.$event_id;
  }
  
 if (strtolower(uri_string()) == 'factsuite-admin/email-templates') {
    $templates = 'active';
  }   else if (strtolower(uri_string()) == 'factsuite-admin/url-branding') {
     $url = 'active';
  } else {
    $templates = 'active';
  }
?>
 <?php 
       $user = '';
       $role_actions = array(); 
      if ($this->session->userdata('logged-in-admin')) {
        $user = $this->session->userdata('logged-in-admin');
        

        if ($user['role'] !='admin') {
          $roles = $this->db->where('role_name',$user['role'])->get('roles')->row_array();
            
          if ($roles['role_action'] !='' && $roles['role_action'] !=null) {
            $role_action = json_decode($roles['role_action'],true);
            $role_actions = isset($role_action['templates'])?$role_action['templates']:''; 
          }
        }
      } else {
         $user = $this->session->userdata('logged-in-csm');
      }
      ?>
<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div id="FS-candidate-mn" class="add-team">
        <ul class="nav nav-tabs nav-justified">
         <?php 
         if (in_array($user['role'], ['admin','csm']) || in_array(2,$role_actions)) { 
         ?>
           <li class="nav-item">
              <a class="nav-link <?php echo $templates; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/email-templates">Email Templates</a>
           </li>
           <?php 
          }
        
           if (in_array($user['role'], ['admin','csm']) || in_array(2,$role_actions) ) { 
           ?>
           <li class="nav-item d-none">
              <a class="nav-link <?php echo $url; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/url-branding">URL Branding</a>
           </li>
           <?php 
            }
           ?>
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