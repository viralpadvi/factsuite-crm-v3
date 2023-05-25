<?php 
 
  $add_website_services = '';
  $all_website_services = '';
  $add_website_package = '';
  $add_website_package_component_details = '';
  $all_website_packages = '';
  $check_event_id = '';

  if (isset($event_id)) {
    $check_event_id = '/'.$event_id;
  }
  
   if (strtolower(uri_string()) == 'factsuite-admin/add-website-services') {
      $add_website_services = 'active';
   } else if (strtolower(uri_string()) == 'factsuite-admin/all-website-services') {
      $all_website_services = 'active';
   } else if (strtolower(uri_string()) == 'factsuite-admin/add-website-package'
      || strtolower(uri_string()) == 'factsuite-admin/add-website-package-component-details'
      || strtolower(uri_string()) == 'factsuite-admin/add-website-package-alacarte-component-details') {
      $add_website_package = 'active';
   } else if (strtolower(uri_string()) == 'factsuite-admin/all-website-packages'
      || strtolower(uri_string()) == 'factsuite-admin/add-website-package-component-details'
      || strtolower(uri_string()) == 'factsuite-admin/add-website-package-alacarte-component-details'
      || strtolower(uri_string()) =='factsuite-admin/edit-website-package-details'
      || strtolower(uri_string()) =='factsuite-admin/edit-website-package-components'
      || strtolower(uri_string()) =='factsuite-admin/edit-website-package-alacarte-component-details') {
      $all_website_packages = 'active';
   } else {
      $client = 'active';
   }
?>

<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div id="FS-candidate-mn">
         <!-- class="add-team" -->
         <ul class="nav nav-tabs">
            <!-- nav-justified -->
            <li class="nav-item">
               <a class="nav-link <?php echo $add_website_services; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-website-services">Add Website Services</a>
            </li>
            <li class="nav-item">
               <a class="nav-link <?php echo $all_website_services; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/all-website-services">All Website Services</a>
            </li>
            <li class="nav-item">
               <a class="nav-link <?php echo $add_website_package; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-website-package">Add Package</a>
            </li>
            <li class="nav-item">
               <a class="nav-link <?php echo $all_website_packages; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/all-website-packages">All Package</a>
            </li>
         </ul>
      </div>
   </div>
</section>
<section id="pg-cntr">
