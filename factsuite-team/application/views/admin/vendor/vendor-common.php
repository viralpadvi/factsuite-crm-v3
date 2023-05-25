<?php 
  $new_vendor = '';
  $view_all_vendor = '';
  $vendor_analytics = '';

  if (strtolower(uri_string()) == 'factsuite-admin/add-new-vendor') {
    $new_vendor = "active";
  } else if (strtolower(uri_string()) == 'factsuite-admin/view-all-active-vendor' || strtolower(uri_string()) == 'factsuite-admin/view-all-inactive-vendor' || strtolower(uri_string()) == 'factsuite-admin/view-all-vendor') {
    $view_all_vendor = 'active';
  } else if (strtolower(uri_string()) == 'ffactsuite-admin/add-new-vendor' || strtolower(uri_string()) == 'wizcraft-admin/view-all-media') {
    $vendor_analytics = 'active';
  } else {
    $new_vendor = 'active';
  }
?>

<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div id="FS-candidate-mn" class="add-team main-nav-tabs-div-3">
        <ul class="nav nav-tabs nav-justified">
         <li class="nav-item">
              <a class="nav-link <?php echo $new_vendor;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-new-vendor">Add Vendor</a>
           </li>
           <li class="nav-item">
              <a class="nav-link <?php echo $view_all_vendor;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/view-all-vendor">View Vendor</a>
           </li>
           <li class="nav-item d-none">
              <a class="nav-link <?php echo $vendor_analytics;?>" href="team-analytics.html">Analytics</a>
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
 