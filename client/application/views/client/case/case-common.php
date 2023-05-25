<?php 

  $dashboard = '';
  $case_list = '';
  $add_case = '';
  $completed_case = ''; 
  $check_candidate_id ='';
  if (isset($candidate_id)) {
    $check_candidate_id = '/'.$candidate_id;
  }
  $bulk = '';
  $client_name = '';
  if ($this->session->userdata('logged-in-client')) {

    $client_name = strtolower($this->session->userdata('logged-in-client')['client_name']);
  }
  $client_name = trim(str_replace(' ','-',$client_name));
  if (strtolower(uri_string()) == 'factsuite-client/home-page') {
    $dashboard = "active";
  } else if (strtolower(uri_string()) == 'factsuite-client/all-cases' || strtolower(uri_string()) == $client_name.'/all-cases'  || strtolower(uri_string()) == 'factsuite-client/view-single-case'.$check_candidate_id || strtolower(uri_string()) == 'factsuite-client/edit-case'.$check_candidate_id || strtolower(uri_string()) == $client_name.'/view-single-case' || strtolower(uri_string()) == $client_name.'/edit-case') {
    $case_list = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-client/add-case' || strtolower(uri_string()) == $client_name.'/add-case') {
    $add_case = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-client/bulk-upload' || strtolower(uri_string()) == $client_name.'/bulk-upload' || strtolower(uri_string()) == 'factsuite-client/view-bulk-upload' || strtolower(uri_string()) == $client_name.'/view-bulk-upload') {
    $bulk = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-client/completed-case') {
    $completed_case = 'active';
  }
  ?>
<!--Content-->
<section id="pg-hdr">
  <div class="container-fluid">
    <div id="FS-candidate-mn" class="add-team">
      <div id="FS-candidate-mn" class="all-cases">
        <ul class="nav nav-tabs nav-justified">
          <li class="nav-item">
            <a class="nav-link <?php echo $case_list ?>" href="<?php echo $this->config->item('my_base_url').$client_name; ?>/all-cases">All Cases</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $add_case ?>"  href="<?php echo $this->config->item('my_base_url').$client_name; ?>/add-case">Add Cases</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $bulk ?>"  href="<?php echo $this->config->item('my_base_url').$client_name; ?>/bulk-upload">Bulk Upload</a>
          </li>
        </ul>
      </div>
    </div>
     <!--Nav Tabs-->
  </div> 
</section>
   
 