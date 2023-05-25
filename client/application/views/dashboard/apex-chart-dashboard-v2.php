<?php
  $client_name = '';
  $client_data = '';
  if ($this->session->userdata('logged-in-client')) {
    $client_name = $this->session->userdata('logged-in-client')['client_name'];
    $client_data = $this->session->userdata('logged-in-client');
  }  
?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<style type="text/css">
  .content-header h1 {
    font-weight: 500;
    padding-top: 5px;
  }
</style>
<?php  ?>
<h1 class="m-0 text-dark">Welcome back, <span class="text-capitalize"><?php echo $client_data['client_name']." (".isset($client_data['spoc_name'])?$client_data['spoc_name']:"Client".")";?></span>!!</h1>
          </div>
          <div class="col-sm-1"></div> 
          <div class="col-sm-6 text-right"> 
              <select id="client" onchange="common_filter_for_client()" class="form-control account-type-dropdown">
            <?php 

            if ($client['parent']['is_master'] == '0') { 
            ?>
            <option value="0">Select Account</option>
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
        </div>
      </div>
    </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-total-reports" id="bg-total-reports" data-id="<?php echo md5('total');?>">
              <div class="inner">
                <div class="row">
                  <div class="col-3">
                    <div class="bg-total-reports-img">
                      <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/file.svg">
                    </div>
                  </div>
                  <div class="col-9">
                    <p><?php echo isset($noman['all_report'])?$noman['all_report']:'Total Reports'; ?></p>
                    <h3 id="home-page-total-report" ><?php echo $total; ?></h3>
                  </div>
                </div>
              </div>
              <div class="icon" id="bg-total-reports-btn" data-id="total">
                <i class="fa fa-ellipsis-v dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"></i>
                <div class="dropdown-menu float-right" id="bg-total-reports-dropdown-toggle" role="menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 7px; left: 97px; transform: translate3d(0px, 29px, 0px);">
                  <a href="javascript:void(0)" onclick="get_reports_data(15,'day','total')" class="dropdown-item">Last 15 Days</a>
                  <a href="javascript:void(0)" onclick="get_reports_data(1,'month','total')" class="dropdown-item">Last 1 Month</a>
                  <a href="javascript:void(0)" onclick="get_reports_data(2,'month','total')" class="dropdown-item">Last 2 Months</a>
                </div>
              </div>
              <div class="row completed-percentage-div">
                <div class="col-6">
                  <span class="total-reports-completed"><?php echo $total; ?> Completed</span>
                </div>
                <?php $show_percentage_inc_dec = 0;
                if ($show_percentage_inc_dec == 1) { ?>
                  <div class="col-6 total-percentage-div">
                    <span class="total-reports-completed text-success"><i class="fa fa-arrow-up"></i>  Increase</span>
                  </div>
                <?php } ?>
              </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-green-reports" id="bg-green-reports" data-id="<?php echo md5('green');?>">
            <div class="inner">
              <div class="row">
                <div class="col-3">
                  <div class="bg-total-reports-img">
                    <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/green-reports.svg">
                  </div>
                </div>
                <div class="col-9">
                  <p><?php echo isset($noman['green'])?$noman['green']:'Green Reports'; ?></p>
                  <h3 id="home-page-green-report"><?php echo isset($report['green'])?$report['green']:'0';?></h3>
                </div>
              </div>
            </div>
            <div class="icon" id="bg-green-reports-btn" data-id="green">
                <i class="fa fa-ellipsis-v dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"></i>
              <div class="dropdown-menu float-right" id="bg-green-reports-dropdown-toggle" role="menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 7px; left: 97px; transform: translate3d(0px, 29px, 0px);">
                <a href="javascript:void(0)" onclick="get_reports_data(15,'day','green')" class="dropdown-item">Last 15 Days</a>
                <a href="javascript:void(0)" onclick="get_reports_data(1,'month','green')" class="dropdown-item">Last 1 Month</a>
                <a href="javascript:void(0)" onclick="get_reports_data(2,'month','green')" class="dropdown-item">Last 2 Months</a>
              </div>
            </div>
            <div class="row completed-percentage-div">
              <div class="col-6">
                <span class="total-reports-completed"><?php echo isset($report['green'])?$report['green']:'0';?> Completed</span>
              </div>
              <?php if ($show_percentage_inc_dec == 1) { ?>
                <div class="col-6 total-percentage-div">
                  <span class="total-reports-completed"><i class="fa fa-arrow-up"></i>  Increase</span>
                </div>
              <?php } ?>
            </div> 
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-red-reports" id="bg-red-reports" data-id="<?php echo md5('red');?>">
            <div class="inner">
              <div class="row">
                <div class="col-3">
                  <div class="bg-total-reports-img">
                    <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/red-reports.svg">
                  </div>
                </div>
                <div class="col-9">
                  <p><?php echo isset($noman['red'])?$noman['red']:'Red Reports'; ?></p>
                  <h3 id="home-page-red-report"><?php echo isset($report['red'])?$report['red']:'0';?></h3>
                </div>
              </div>
            </div>
            <div class="icon" id="bg-red-reports-btn" data-id="red">
              <i class="fa fa-ellipsis-v dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"></i>
              <div class="dropdown-menu float-right" id="bg-red-reports-dropdown-toggle" role="menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 7px; left: 97px; transform: translate3d(0px, 29px, 0px);">
                <a href="javascript:void(0)" onclick="get_reports_data(15,'day','red')" class="dropdown-item">Last 15 Days</a>
                <a href="javascript:void(0)" onclick="get_reports_data(1,'month','red')" class="dropdown-item">Last 1 Month</a>
                <a href="javascript:void(0)" onclick="get_reports_data(2,'month','red')" class="dropdown-item">Last 2 Months</a>
              </div>
            </div>
            <div class="row completed-percentage-div">
              <div class="col-6">
                <span class="total-reports-completed"><?php echo isset($report['red'])?$report['red']:'0';?> Completed</span>
              </div>
              <?php if ($show_percentage_inc_dec == 1) { ?>
                <div class="col-6 total-percentage-div">
                  <span class="total-reports-completed"><i class="fa fa-arrow-up"></i>  Increase</span>
                </div>
              <?php } ?>
            </div> 
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-orange-reports" id="bg-orange-reports" data-id="<?php echo md5('orange');?>">
            <div class="inner">
              <div class="row">
                <div class="col-3">
                  <div class="bg-total-reports-img">
                    <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/blue-reports.svg">
                  </div>
                </div>
                <div class="col-9">
                  <p><?php echo isset($noman['orange'])?$noman['orange']:'Orange Reports'; ?></p>
                  <h3 id="home-page-orange-report"><?php echo isset($report['orange'])?$report['orange']:'0';?></h3>
                </div>
              </div>
            </div>
            <div class="icon" id="bg-orange-reports-btn" data-id="orange">
              <i class="fa fa-ellipsis-v dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"></i>
              <div class="dropdown-menu float-right" id="bg-orange-reports-dropdown-toggle" role="menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 7px; left: 97px; transform: translate3d(0px, 29px, 0px);">
                <a href="javascript:void(0)" onclick="get_reports_data(15,'day','orange')" class="dropdown-item">Last 15 Days</a>
                <a href="javascript:void(0)" onclick="get_reports_data(1,'month','orange')" class="dropdown-item">Last 1 Month</a>
                <a href="javascript:void(0)" onclick="get_reports_data(2,'month','orange')" class="dropdown-item">Last 2 Months</a>
              </div>
            </div>
            <div class="row completed-percentage-div">
              <div class="col-6">
                <span class="total-reports-completed"><?php echo isset($report['orange'])?$report['orange']:'0';?> Completed</span>
              </div>
              <?php if ($show_percentage_inc_dec == 1) { ?>
                <div class="col-6 total-percentage-div">
                  <span class="total-reports-completed"><i class="fa fa-arrow-up"></i>  Increase</span>
                </div>
              <?php } ?>
            </div> 
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-2 col-6">
          <div class="small-box bg-total-reports new-cases-count-kpi-div cursor-default">
            <div class="inner text-center">
              <p>New Cases</p>
              <h3 id="home-page-total-case"><?php echo isset($inventry['init'])?$inventry['init']:'0';?></h3>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-6">
          <div class="small-box bg-green-reports closed-cases-count-kpi-div cursor-default">
            <div class="inner text-center">
              <p>Closed Cases</p>
              <h3 id="home-page-completed-case"><?php echo isset($inventry['completed'])?$inventry['completed']:'0';?></h3>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-6">
          <div class="small-box bg-red-reports other-case-condition-count-kpi-div-bg-color cursor-default">
            <div class="inner text-center">
              <p>Insuff</p>
              <h3 id="home-page-insuff-case"><?php echo isset($inventry['insuff'])?$inventry['insuff']:'0';?></h3>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-6">
          <!-- small box -->
          <div class="small-box bg-orange-reports other-case-condition-count-kpi-div-bg-color cursor-default">
            <div class="inner text-center">
              <p>Inprogress</p>
              <h3 id="home-page-pending-report"><?php echo isset($inventry['pending'])?$inventry['pending']:'0';?></h3>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-6">
          <!-- small box -->
          <div class="small-box bg-orange-reports other-case-condition-count-kpi-div-bg-color cursor-default">
            <div class="inner text-center">
              <p>Reinitiated</p>
              <h3 id="total-re-init">0</h3>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-6">
          <!-- small box -->
          <div class="small-box bg-orange-reports other-case-condition-count-kpi-div-bg-color cursor-default">
            <div class="inner text-center">
              <p>Client Clarification</p>
              <h3 id="closure_month_total_"><?php echo isset($inventry['clarification'])?$inventry['clarification']:'0';?></h3>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <section class="col-lg-12">
          <div class="card kpi-div">
            <div class="card-header">
              <h3 class="card-title">
                Case Analytics
              </h3>
            </div>
            <div class="card-body">
              <div class="tab-content p-0">
                <div class="row">
                  <?php $show_cases_overview = 0;
                  if ($show_cases_overview == 1) { ?>
                    <div class="col-md-6">
                      <div class="kpi-overview-txt">
                        Overview
                      </div>
                      <!-- <hr class="mt-0"> -->
                      <div class="row border-top border-right">
                        <div class="col-md-6 mt-2">
                          <div class="cases-overview-kpi-div new-cases-count-kpi-div">
                            <p>New Cases</p>
                            <h4  id="home-page-total-case" ><?php echo isset($inventry['init'])?$inventry['init']:'0';?></h4>
                          </div>
                        </div>
                        <div class="col-md-6 mt-2">
                          <div class="cases-overview-kpi-div closed-cases-count-kpi-div">
                            <p>Closed Cases</p>
                            <h4  id="home-page-completed-case" ><?php echo isset($inventry['completed'])?$inventry['completed']:'0';?></h4>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="other-case-condition-count-kpi-div">
                            <div class="row">
                              <div class="col-md-2 col-6">
                                <p>Insuff</p>
                                <h4 id="home-page-insuff-case"><?php echo isset($inventry['insuff'])?$inventry['insuff']:'0';?></h4>
                              </div>
                              <div class="col-md-3 col-6">
                                <p>Inprogress</p>
                                <h4 id="home-page-pending-report"><?php echo isset($inventry['pending'])?$inventry['pending']:'0';?></h4>
                              </div>
                              <div class="col-md-3 col-6">
                                <p>Reinitiated</p>
                                <h4 id="total-re-init">0</h4>
                              </div>
                              <div class="col-md-4 col-6">
                                <p>Client Clarification</p>
                                <h4 id="closure_month_total_"><?php echo isset($inventry['clarification'])?$inventry['clarification']:'0';?></h4>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  <div class="col-md-6 border-right"> 
                    <div class="row mb-2">
                      <!-- <div class="col-md-4"></div> -->
                      <div class="col-md-3">
                        <span>Select Status</span>
                        <select class="form-control kip-select" id="recievals_status1">
                          <option value="status">All Status</option>
                          <option value='0'>Initiated</option>
                          <option value='1'>Inprogress</option>
                          <option value='3'>Insuff</option>
                          <option value='2'>Completed</option>
                        </select>
                      </div>
                      <div class="col-md-4 pl-0">
                        <span>Select Chart Type</span>
                        <select class="form-control kip-select" id="case-summary-graph-type">
                          <option value="line-graph">Line</option>
                          <option value="bar-chart">Bar</option>
                          <option value="pie-chart">Pie</option>
                          <option value="donut-chart">Donut</option>
                          <option value="area-chart" disabled id="case-summary-graph-type-area-chart">Area</option>
                        </select>
                      </div>
                      <div class="col-md-5 pl-0">
                        <span>Select Date Range</span>
                        <input type="text" name="from-date-recievals" id="from-date-recievals1" value="" placeholder="Select Date Range" class="form-control status-wise-case-select-date-range">
                      </div>
                    </div>

                    <div class="chart tab-pane active mt-5" id="case-summary-chart-div"></div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-3"></div>
                      <div class="col-md-4">
                        <span>Select Chart Type</span>
                        <select class="form-control d-inline kip-select" id="case-chart-type-for-case-status-wise">
                          <option value='column-chart'>Column</option>
                          <option value='stacked-column-chart'>Stacked Column</option>
                          <option value='spline-chart'>Spline</option>
                        </select>
                      </div>
                      <div class="col-md-5 pl-0">
                        <span>Select Date Range</span>
                        <input type="text" id="from-date-recievals1" placeholder="Select Date Range" class="form-control status-wise-case-summary-chart-select-date-range">   
                      </div>
                    </div>
                    <div class="chart tab-pane active mt-2" id="status-wise-case-summary-chart-div"></div>
                    <!-- <div class="chart tab-pane active mt-2" id="case-status-wise-area-chart-div"></div> -->
                  </div>
                  <div class="col-md-6">
                    <div class="row d-none">
                      <div class="col-md-3">
                        <span>Select Status</span>
                        <select class="form-control d-inline kip-select" id="case-status-type-2">
                          <option value='0'>Initiated</option>
                          <option value='1'>Inprogress</option>
                          <option value='3'>Insuff</option>
                          <option value='2'>Completed</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    
                  </div>
                  <!-- <div class="col-md-6">
                    <div class="chart tab-pane active mt-2" id="status-wise-case-summary-stacked-chart-div"></div>
                  </div> -->
                <!-- </div>
                <div class="row">
                  <div class="col-md-6 mt-5">
                    <div class="chart tab-pane active mt-2" id="status-wise-case-summary-area-spline-chart-div"></div>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>

<script src="<?php echo base_url();?>assets/custom-js/dashboard/get-dashboard-report-numbers.js"></script>
<script src="<?php echo base_url();?>assets/custom-js/dashboard/get-dashboard-apex-charts.js"></script>
<script src="<?php echo base_url();?>assets/custom-js/case/export.js"></script>
<script>
  var report_case_base_url = '<?php echo $this->config->item('my_base_url').$client_name.'/selected-report-cases?param=';?>';
</script>
<script>
  
</script>