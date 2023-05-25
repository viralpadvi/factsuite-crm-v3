  <section class="content">
    <div class="container-fluid">
      <div class="tab-content">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-12">
                <span class="product-details-span-light">Report Period</span>
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
                <span class="product-details-span-light d-block">Duration</span>
                <div class="row">
                  <div class="col-md-6">
                    <span class="product-details-span-light">From</span>
                    <input class="form-control input-field mdate" type="text" name="from" id="from" value="">
                  </div>
                  <div class="col-md-6">
                    <span class="product-details-span-light">To</span>
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

              <div class="col-md-12 mt-3 text-right">
                <button class="btn btn-submit" id="generate_report" name="generate_report">Generate</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<script src="<?php echo base_url();?>assets/custom-js/client/report/insuff-excel-report.js"></script>
<script>
  $('#duration').change(function(){
    var duration = $('#duration').val();
    if (duration == 'between') {
      $("#duration-date").show();
    } else {
      $("#duration-date").hide();
    }
  });

  $('#from').val('');
  $('#to').val('');
</script>