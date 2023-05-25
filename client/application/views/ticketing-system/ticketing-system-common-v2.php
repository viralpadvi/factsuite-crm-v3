<?php 
  extract($_GET);
  $raise_ticket_active = '';
  $ticket_assigned_to_me_active = '';
  $client_name = '';
  
  if ($this->session->userdata('logged-in-client')) {
    $client_name = strtolower($this->session->userdata('logged-in-client')['client_name']);
  }
  $client_name = trim(str_replace(' ','-',$client_name));
  
  if (strtolower(uri_string()) == 'factsuite-client/raise-ticket' || strtolower(uri_string()) == $client_name.'/raise-ticket') {
    $raise_ticket_active = ' active';
  } else if(strtolower(uri_string()) == 'factsuite-client/tickets-assigned-to-me' || strtolower(uri_string()) == $client_name.'/tickets-assigned-to-me') {
    $ticket_assigned_to_me_active = ' active';
  } else  {
    $raise_ticket_active = ' active';
  }
?>
<!-- <h1 class="m-0 text-dark">Tickets</h1> -->
      </div>
      <div class="col-sm-12">
        <ul class="nav nav-tabs custom-nav-tabs nav-justified" id="custom-tabs-three-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link<?php echo $raise_ticket_active;?>" href="<?php echo $this->config->item('my_base_url').$client_name;?>/raise-ticket">Tickets Raised by Me</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $ticket_assigned_to_me_active;?>" href="<?php echo $this->config->item('my_base_url').$client_name;?>/tickets-assigned-to-me">Clarifications Assigned to Me</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid">
    <?php if (strtolower(uri_string()) == 'factsuite-client/raise-ticket' || strtolower(uri_string()) == $client_name.'/raise-ticket') { ?>
      <div class="row mb-3">
        <div class="col-md-8"></div>
        <div class="col-md-4 text-right">
          <a href="javascript:void(0)" id="team-submit-btn" data-toggle="modal" data-target="#add-new-ticket-modal"class="btn custom-btn-1">Raise a Ticket</a>
        </div>
      </div>
    <?php } ?>
    <div class="card kpi-div">
      <div class="card-body">
        <div class="tab-content">
          <?php $this->load->view('client/pagination/search-bar-and-filter-dropdown-hdr');?>