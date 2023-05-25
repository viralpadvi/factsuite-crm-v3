<?php 
  $status_width = '16%';
  $sr_no_width = '4%';
  $candidate_name_width = '9%';
  $package_name_width = '10%';
  $employee_id_width = '7%';
  $tat_start_date_width = '7%';
  $tat_end_date_width = '7%';
  $tat_days_width = '5%';
  $actions_width = '20%';
  $candidate_login_id_width = '10%';
?>
<script>
  var status_width = '<?php echo $status_width;?>',
    sr_no_width = '<?php echo $sr_no_width;?>',
    candidate_name_width = '<?php echo $candidate_name_width;?>',
    package_name_width = '<?php echo $package_name_width;?>',
    employee_id_width = '<?php echo $employee_id_width;?>',
    tat_start_date_width = '<?php echo $tat_start_date_width;?>',
    tat_end_date_width = '<?php echo $tat_end_date_width;?>',
    tat_days_width = '<?php echo $tat_days_width;?>',
    actions_width = '<?php echo $actions_width;?>',
    candidate_login_id_width = '<?php echo $candidate_login_id_width;?>';
</script>

<h1 class="m-0 text-dark">Insuff Cases</h1>
          </div>
        </div>
      </div>
    </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <section class="col-lg-12">
          <div class="card kpi-div">
            <div class="card-body">
              <div class="tab-content p-0">
                <?php $this->load->view('client/pagination/search-bar-and-filter-dropdown-hdr');?>
                <div class="table-responsive" id="view-all-cases"></div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>

<script>
   var component_config_name = "<?php echo $this->config->item('show_component_name'); ?>";
</script>

<script>
  // view_all_cases();
</script>
<script>
  var site_url = 'factsuite-client/get-all-cases';
  var html = '<table class="table custom-table table-striped">';
      html += '<thead>';
      html += '<tr><th>Sr&nbsp;No.</th>';
      html += '<th>Candidate</th>';
      html += '<th>Mobile&nbsp;Number</th>';
      html += '<th>Package</th>';
      html += '<th>Employee&nbsp;ID</th>';
      html += '<th class="text-center">Status</th>';
      html += '<th>Start&nbsp;Date</th>';
      html += '<th>End&nbsp;Date</th>';
      html += '<th>TAT&nbsp;Days</th>';
      html += '<th>Actions</th></tr>';
      html += '</thead>';
      html += '<tbody>';
      html += '<tr><td colspan="10" class="text-center"><div class="spinner-border text-muted custom-spinner"></div></td></tr>';
      html += '</tbody>';
      html += '</table>';
  var display_ui_id = '#view-all-cases',
      request_from = 'insuff';
</script>
<script src="<?php echo base_url() ?>assets/custom-js/pagination/pagination.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo base_url() ?>assets/custom-js/case/add-case.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo base_url() ?>assets/custom-js/case/add-case-v2.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo base_url() ?>assets/custom-js/case/edit-case-v2.js?v=<?php echo time(); ?>"></script>