    
<section id="pg-hdr">
   <div class="container-fluid">
      <div id="FS-candidate-mn" class="add-team main-nav-tabs-div-3">
        
     </div>
     <!--Nav Tabs-->
   </div>
    </div>
  </div>
</section>

<section id="pg-cntr">
  <div class="pg-hdr">
     
   </div>
<div class="pg-cnt">
     <div id="FS-candidate-cnt" class="pt-3">
        <!--Add Client Content-->
        <div class="add-client-bx">

          <div class="row mt-4">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header card-kpi">

                <div class="row">
                  <div class="col-md-4">
                    <h3 class="card-title pt-2"><span class="analytics-title">Total Sales</span></h3>
                  </div>
                  <div class="col-md-8 text-right">
                    <select class="form-control d-inline kip-select" id="total_sales_select_time" onchange="get_total_sales()">
                      <option value="all">All</option>
                      <option value="today">Today</option>
                      <option value="this_week">This Week</option>
                      <option value="this_month">This month</option>
                      <option value="this_year">This year</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="text-center text-success total-sales" id="total_sales_count"></div>
              </div>
            </div>
          </div>

          <!-- second -->
           <div class="col-md-6">
            <div class="card">
              <div class="card-header card-kpi">
                <div class="row">
                  <div class="col-md-4">
                    <h3 class="card-title pt-2"><span class="analytics-title">Average Order Value</span></h3>
                  </div>
                  <div class="col-md-8 text-right">
                    <select class="form-control d-inline kip-select" id="avg_order_value_select_time" onchange="get_average_order_value()">
                      <option value="all">All</option>
                      <option value="today">Today</option>
                      <option value="this_week">This Week</option>
                      <option value="this_month">This month</option>
                      <option value="this_year">This year</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="text-center text-success total-sales" id="avergare-order-sales"></div>
              </div>
            </div>
          </div>


          <!-- third -->
           <div class="col-md-6">
            <div class="card">
              <div class="card-header card-kpi">
                <div class="row">
                  <div class="col-md-4">
                    <h3 class="card-title pt-2"><span class="analytics-title">Number Of Orders</span></h3>
                  </div>
                  <div class="col-md-8 text-right">
                    <select class="form-control d-inline kip-select" id="no_of_orders_select_time" onchange="get_total_no_of_orders()">
                      <option value="all">All</option>
                      <option value="today">Today</option>
                      <option value="this_week">This Week</option>
                      <option value="this_month">This month</option>
                      <option value="this_year">This year</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="text-center text-success total-sales" id="no-of-orders-count"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6 d-none">
            <div class="card d-none">
              <div class="card-header card-kpi">
                <div class="row">
                  <div class="col-md-4">
                    <h3 class="card-title pt-2"><span class="analytics-title">Number of Cancellations</span></h3>
                  </div>
                  <div class="col-md-8 text-right">
                    <select class="form-control d-inline kip-select" id="total_returns_select_time" onchange="get_total_order_returns()">
                      <option value="all">All</option>
                      <option value="today">Today</option>
                      <option value="this_week">This Week</option>
                      <option value="this_month">This month</option>
                      <option value="this_year">This year</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="text-center text-success total-sales" id="total-returns-count"></div>
              </div>
            </div>
          </div>

          <!--  -->


          <div class="col-md-6">
            <div class="card">
              <div class="card-header card-kpi">
                <div class="row">
                  <div class="col-md-4">
                    <h3 class="card-title pt-2"><span class="analytics-title">Sales by Item</span></h3>
                  </div>
                  <div class="col-md-8 text-right">
                    <select class="form-control d-inline kip-select mr-1" id="sales_by_item_select_product" onchange="get_sales_by_item_count()">
                      <option value="all">All Clients</option>
                      <?php 
                      $all_product_names = $this->db->order_by('client_id','DESC')->get('tbl_client')->result_array();
                        foreach ($all_product_names as $key => $value) { ?>
                          <option value="<?php echo $value['client_id']?>"><?php echo $value['client_name']?></option>
                      <?php } ?>
                    </select>
                    
                    <select class="form-control d-inline kip-select mt-2" id="sales_by_item_select_time" onchange="get_sales_by_item_count()">
                      <option value="all">All</option>
                      <option value="today">Today</option>
                      <option value="this_week">This Week</option>
                      <option value="this_month">This month</option>
                      <option value="this_year">This year</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="text-center" id="sales_by_item_error_div"></div>
                <div class="text-center chart-div">
                  <canvas height="300px" id="sales_by_item_count" class="charts-canvas"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12 mt-2">
            <div class="card">
              <div class="card-header card-kpi">
                <div class="row">
                  <div class="col-md-4">
                    <h3 class="card-title pt-2"><span class="analytics-title">Top Selling Packages</span></h3>
                  </div>
                  <div class="col-md-8 text-right d-none">
                    <select class="form-control d-inline kip-select mt-2 d-none" id="top_selling_items_select" onchange="get_top_selling_items()">
                      <option value="5" selected>Top 5</option>
                      <option value="10">Top 10</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="text-center" id="top_selling_items_error_div"></div>
                <div class="text-center chart-div">
                  <canvas height="350px" id="top_selling_items_result" class="charts-canvas"></canvas>
                </div>
              </div>
            </div>
          </div>


           <div class="col-md-12 mt-4">
          <div class="card">
            <div class="card-header card-kpi">
              <div class="row">
                <div class="col-md-6">
                  <h3 class="card-title pt-2"><span class="analytics-title">Top selling Components </span></h3>
                </div>
                <div class="col-md-6 text-right">
                <div class="row">
                   <div class="col-md-8 mt-2">
                      
                   </div>
                   <div class="col-md-4">
                     
                   </div>
                 </div>

                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="text-center" id="component_status_inprogress_status_error_div"></div>
              <div class="text-center chart-div">
                <canvas height="300px" id="component_status_inprogress_status" class="charts-canvas"></canvas>
              </div>
            </div>
          </div>
          </div>



        </div>

          </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- ChartJS -->
<script src="<?php echo base_url()?>assets/plugins/chart.js/Chart.min.js"></script>
  <script>
 

  </script>

  <!-- Custome JS --> 
<script src="<?php echo base_url()?>assets/custom-js/finance/dashboard/admin-dashboard.js"></script>