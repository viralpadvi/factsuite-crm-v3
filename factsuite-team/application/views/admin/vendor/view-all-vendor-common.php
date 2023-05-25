<?php 
  $active_vendor = '';
  $inactive_vendor = '';

  if (strtolower(uri_string()) == 'factsuite-admin/view-all-active-vendor') {
    $active_vendor = "active";
  } else if (strtolower(uri_string()) == 'factsuite-admin/view-all-inactive-vendor') {
    $inactive_vendor = 'active';
  } else {
    $active_vendor = 'active';
  }
?>

<div class="pg-cnt">
  <div id="FS-candidate-cnt">
    <div class="cases-rgt">
      <div id="custom-search-input">
        <div class="input-group d-none">
          <span class="export"><a href="../api/v1/vendor/download/all-vendor"><input type="image" src="../images/export.png" width="30" height="30"></a></span>
          <input type="search" id="search" class="search-query form-control" placeholder="Search by name/email/phone no"> <span class="input-group-btn">
          <button type="button">
            <span class="fa fa-search"></span>
          </button>
        </span>
      </div>
    </div>
  </div>
  <div id="FS-allcandidates">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link <?php echo $active_vendor; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/view-all-active-vendor">Active</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo $inactive_vendor; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/view-all-inactive-vendor">In-Active</a>
      </li>
    </ul>