<?php 
  extract($_GET);
  $dashboard_active = '';
  $case_active = '';
  $history_active = '';
  $finance_active = '';
  $documentation_active = '';
  $mis_report_active = '';
  $ticket_active = '';

  $dashboard_img = 'white-four-square.png';
  $case_img = 'white-bar-chart.png';
  $history_img = 'white-history.png';
  $finance_img = 'white-four-square.png';
  $documentation_img = 'white-documentation.svg';
  $mis_report_img = 'mis-report-white.png';
  $ticket_img = 'white-ticket.png';
  
  if (isset($event_id)) {
    $check_event_id = '/'.$event_id;
  }

  $check_candidate_id ='';
  if (isset($candidate_id)) {
    $check_candidate_id = '/'.$candidate_id;
  }
  $client_name = '';
  if ($this->session->userdata('logged-in-admin')) {
    $client_name = strtolower($this->session->userdata('logged-in-admin')['client_name']);
  }
  $client_name = trim(str_replace(' ','-',$client_name));

  if (strtolower(uri_string()) == 'factsuite-client/home-page' ||
    strtolower(uri_string()) == $client_name.'/home-page') {
    $dashboard_active = ' active';
    $dashboard_img = 'blue-four-square.png';
  }else if (strtolower(uri_string()) == 'factsuite-client/all-cases' ||
    strtolower(uri_string()) == $client_name.'/all-cases' ||
    strtolower(uri_string()) == 'factsuite-client/add-case' ||
    strtolower(uri_string()) == 'factsuite-client/view-single-case'.$check_candidate_id ||
    strtolower(uri_string()) == $client_name.'/view-single-case' ||
    strtolower(uri_string()) == $client_name.'/selected-report-cases' ||
    strtolower(uri_string()) == 'factsuite-client/view-single-case'.$check_candidate_id ||
    strtolower(uri_string()) == $client_name.'/factsuite-client/view-single-case'.$check_candidate_id ||
    strtolower(uri_string()) == $client_name.'/edit-case' ||
    strtolower(uri_string()) == 'factsuite-client/insuff-cases' ||
    strtolower(uri_string()) == $client_name.'/insuff-cases' ||
    strtolower(uri_string()) == 'factsuite-client/client-clarification-cases' ||
    strtolower(uri_string()) == $client_name.'/client-clarification-cases') {
    $case_active = ' active';
    $case_img = 'blue-bar-chart.png';
  } else if(strtolower(uri_string()) == 'factsuite-client/candidate-mis-report' ||
            strtolower(uri_string()) == 'factsuite-client/candidate-mis-insuff-report' ||
            strtolower(uri_string()) == 'factsuite-client/candidate-clear-insuff-report' ||
            strtolower(uri_string()) == $client_name.'/candidate-mis-report' ||
            strtolower(uri_string()) == $client_name.'/candidate-mis-insuff-report' ||
            strtolower(uri_string()) == $client_name.'/candidate-clear-insuff-report') {
    $mis_report_active = ' active';
    $mis_report_img = 'mis-report-colored.png';
  } else if (strtolower(uri_string()) == 'factsuite-client/raise-ticket' || strtolower(uri_string()) == $client_name.'/raise-ticket' || strtolower(uri_string()) == 'factsuite-client/tickets-assigned-to-me' || strtolower(uri_string()) == $client_name.'/tickets-assigned-to-me') {
    $ticket_active = ' active';
    $ticket_img = 'blue-ticket.png';
  } else if(strtolower(uri_string()) == 'factsuite-client/documentation') {
    $documentation_active = ' active';
    $documentation_img = 'blue-documentation.svg';
  } else if(strtolower(uri_string()) == 'factsuite-client/timezone') {
    $finance_active = ' active';
    $finance_img = 'blue-four-square.png';
  } else  {
    $dashboard_active = ' active';
    $dashboard_img = 'blue-four-square.png';
  }

  $raise_ticket_active = '';
  $ticket_assigned_to_me_active = '';

  if (strtolower(uri_string()) == 'factsuite-client/raise-ticket' || strtolower(uri_string()) == $client_name.'/raise-ticket') {
    $raise_ticket_active = ' active';
  } else if(strtolower(uri_string()) == 'factsuite-client/tickets-assigned-to-me' || strtolower(uri_string()) == $client_name.'/tickets-assigned-to-me') {
    $ticket_assigned_to_me_active = ' active';
  } else  {
    $raise_ticket_active = ' active';
  }
?>

<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo $this->config->item('my_base_url').$client_name; ?>/home-page" class="brand-link border-0">
      <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/factsuite-sidebar-logo-symbol.png" alt="Factsuite Logo" class="brand-image">
      <span class="brand-text font-weight-light"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/factsuite-sidebar-logo.png" alt="Factsuite Logo" class="brand-image-logo"></span>
    </a>
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        </div>
        <div class="info">
        </div>
      </div>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- <div class="mt-5 pt-3"></div> -->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo $this->config->item('my_base_url').$client_name; ?>/home-page" class="nav-link<?php echo $dashboard_active;?>">
              <img class="nav-sidebar-img" src="<?php echo base_url()?>assets/client/assets-v2/dist/img/<?php echo $dashboard_img;?>">
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo $this->config->item('my_base_url').$client_name; ?>/all-cases" class="nav-link<?php echo $case_active;?>">
              <img class="nav-sidebar-img" src="<?php echo base_url()?>assets/client/assets-v2/dist/img/<?php echo $case_img;?>">
              <p>
                Cases
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo $this->config->item('my_base_url').$client_name; ?>/candidate-mis-report" class="nav-link<?php echo $mis_report_active;?>">
              <img class="nav-sidebar-img" src="<?php echo base_url()?>assets/client/assets-v2/dist/img/<?php echo $mis_report_img;?>">
              <p>
                MIS Report
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo $this->config->item('my_base_url').$client_name; ?>/raise-ticket" class="nav-link<?php echo $ticket_active;?>">
              <img class="nav-sidebar-img" src="<?php echo base_url()?>assets/client/assets-v2/dist/img/<?php echo $ticket_img;?>">
              <p>
                Raise a Ticket
              </p>
            </a>
          </li>
          <li class="nav-item d-none">
            <a href="<?php echo $this->config->item('my_base_url')?>factsuite-client/documentation" class="nav-link<?php echo $documentation_active;?>">
            <!-- <a href="<?php echo base_url()?>assets/client/doc/User_Guide_CRM_Client_Module.pdf" target="_blank" class="nav-link<?php echo $documentation_active;?>"> -->
              <img class="nav-sidebar-img" src="<?php echo base_url()?>assets/client/assets-v2/dist/img/<?php echo $documentation_img;?>">
              <p>
                Documentation
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="<?php echo $this->config->item('my_base_url'); ?>factsuite-client/timezone" class="nav-link<?php echo $finance_active;?>">
              <img class="nav-sidebar-img" src="<?php echo base_url()?>assets/client/assets-v2/dist/img/<?php echo $finance_img;?>">
              <p>
                Timezone
              </p>
            </a>
          </li>
           <li class="nav-item d-none">
            <a href="javascript:void(0)" class="nav-link<?php echo $history_active;?>">
              <img class="nav-sidebar-img" src="<?php echo base_url()?>assets/client/assets-v2/dist/img/<?php echo $history_img;?>">
              <p>
                History
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid main-content-div">
        <div class="row mb-2">
          <?php if (strtolower(uri_string()) == 'factsuite-client/all-cases' ||
                    strtolower(uri_string()) == $client_name.'/all-cases' ||
                    strtolower(uri_string()) == 'factsuite-client/insuff-cases' ||
                    strtolower(uri_string()) == $client_name.'/insuff-cases' ||
                    strtolower(uri_string()) == 'factsuite-client/client-clarification-cases' ||
                    strtolower(uri_string()) == $client_name.'/client-clarification-cases') {
            $all_cases_tab_active = $insuff_cases_tab_active = $client_clarification_cases_tab_active = '';
            if (strtolower(uri_string()) == 'factsuite-client/all-cases' ||
              strtolower(uri_string()) == $client_name.'/all-cases') {
              $all_cases_tab_active = ' active';
            } else if (strtolower(uri_string()) == 'factsuite-client/insuff-cases' ||
              strtolower(uri_string()) == $client_name.'/insuff-cases') {
              $insuff_cases_tab_active = ' active';
            } else if (strtolower(uri_string()) == 'factsuite-client/client-clarification-cases' ||
              strtolower(uri_string()) == $client_name.'/client-clarification-cases') {
              $client_clarification_cases_tab_active = ' active';
            }
          ?>
          <div class="col-sm-12 mb-4">
            <ul class="nav nav-tabs custom-nav-tabs nav-justified" id="custom-tabs-three-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link<?php echo $all_cases_tab_active;?>" href="<?php echo $this->config->item('my_base_url')?><?php echo $client_name?>/all-cases">All Cases</a>
              </li>
              <li class="nav-item">
                <a class="nav-link<?php echo $insuff_cases_tab_active;?>" href="<?php echo $this->config->item('my_base_url')?><?php echo $client_name?>/insuff-cases">Insuff Cases</a>
              </li>
              <li class="nav-item">
                <a class="nav-link<?php echo $client_clarification_cases_tab_active;?>" href="<?php echo $this->config->item('my_base_url')?><?php echo $client_name?>/client-clarification-cases">Client Clarification Cases</a>
              </li>
            </ul>
          </div>
        <?php } ?>
          <?php if (strtolower(uri_string()) == 'factsuite-client/all-cases' || strtolower(uri_string()) == $client_name.'/all-cases') { ?>
            <div class="col-sm-3">
          <?php } else { ?>
            <div class="col-sm-5">
          <?php } ?>
