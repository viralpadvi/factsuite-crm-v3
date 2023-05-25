  <section class="content">
    <div class="container-fluid">
      <div class="tab-content">
        <div class="row">
          <div class="col-md-8">
            <div class="report-main-div">
              <img class="report-bg-img" src="<?php echo base_url(); ?>assets/client/assets-v2/dist/img/report-bd-img.svg">
              <div class="report-input-main-div">
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <h1 class="report-main-hdr-txt">Generate Report</h1>
                  </div>
                  <div class="col-md-12">
                    <span class="product-details-span-light font-weight-bold">Select Report Type</span>
                    <select class="form-control input-field" name="report-type" id="report-type">
                      <option value="all">Overall Report</option>
                      <option value="insuff-report">Insuff Report</option>
                      <option value="insuff-clear-report">Insuff Clear Report</option>
                    </select>
                  </div>
                  <div class="col-md-12 mt-3">
                    <span class="product-details-span-light font-weight-bold">Report Period</span>
                    <select class="form-control input-field" name="duration" id="duration">
                      <option value="all">ALL</option>
                      <option value="today">Today</option>
                      <option value="week">Weekly</option>
                      <option value="month">Monthly</option>
                      <option value="year">Yearly</option>
                      <option value="between">Between Date</option>
                    </select>
                  </div>
                  <div class="col-md-12 mt-3" id="duration-date" style="display: none;">
                    <span class="product-details-span-light font-weight-bold d-block">Duration</span>
                    <div class="row">
                      <div class="col-md-6">
                        <span class="product-details-span-light font-weight-bold">From</span>
                        <input class="form-control input-field mdate" type="text" name="from" id="from" value="">
                      </div>
                      <div class="col-md-6">
                        <span class="product-details-span-light font-weight-bold">To</span>
                        <input class="form-control input-field mdate" type="text" name="to" id="to" value="">
                      </div>
                    </div>
                  </div>

                   <div class="col-md-12 mt-3"> 
                    <span class="product-details-span-light font-weight-bold d-block">Users</span>
                    <select id="client"   class="form-control input-field">
                  <?php 

                  if ($client['parent']['is_master'] == '0') { 
                  ?>
                  <option value="0">ALL</option>
                  <?php 
                  } 
                  ?>
                  <option value="<?php echo $client['parent']['client_id']; ?>"><?php echo $client['parent']['client_name']; ?></option>
                  <?php 
                  if (count($client['child']) > 0) {
                     foreach ($client['child'] as $key => $val) {
                      ?>
                      <option value="<?php echo $val['client_id']; ?>"><?php echo $val['client_name']; ?></option>
                      <?php 
                     }
                  }
                  ?>
                </select>
                </div>

                  <div class="col-md-12 mt-4">
                    <button class="btn btn-submit" id="generate_report" name="generate_report">Download</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="generate-report-included-data-div">
              <div class="row">
                <div class="col-md-12">
                  <img class="generate-report-included-img" src="<?php echo base_url(); ?>assets/client/assets-v2/dist/img/generate-report-included-img.svg">
                </div>
                <div class="col-md-12">
                  <h1 class="generate-report-included-txt">Reports include the following data</h1>
                  <ul class="generate-report-included-list">
                    <li>Name</li>
                    <li>Candidate Type</li>
                    <li>emails</li>
                    <li>Contact Number</li>
                    <li>Verification status</li>
                    <li>Total application</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="container-fluid d-none">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/mis-report-bg-image.svg" class=w-100>
      </div>
    </div>
  </div>
<script src="<?php echo base_url();?>assets/custom-js/client/report/excel-report.js"></script>
<script src="<?php echo base_url();?>assets/custom-js/client/report/insuff-excel-report.js"></script>
<script src="<?php echo base_url();?>assets/custom-js/client/report/clear-insuff-report.js"></script>
<script>
  $('#duration').change(function() {
    var duration = $('#duration').val();
    if (duration == 'between') {
      $("#duration-date").show();
    } else {
      $("#duration-date").hide();
    }
  });

  $('#from').val('');
  $('#to').val('');

  $('#generate_report').on('click',function() {
    var report_type = $('#report-type').val();
    if (report_type != '') {
      if(report_type == 'all') {
        get_all_reports();
      } else if (report_type == 'insuff-report') {
        get_insuff_reports();
      } else if (report_type == 'insuff-clear-report') {
        get_insuff_clear_reports();
      } else {
        get_all_report_type();
      }
    }
  });

  function get_all_report_type() {
    var html = '<option value="all">General Reports</option>';
        html += '<option value="insuff-report">Insuff Report</option>';
        html += '<option value="insuff-clear-report">Insuff Clear Report</option>';
    $('#report-type').html(html);
  }
</script>