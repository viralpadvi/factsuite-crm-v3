  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
        <div class="row">
          

           <div class="col-md-12 mt-4">
            <div class="card">
              <div class="card-header card-kpi">
                <div class="row">
                  <div class="col-md-4">
                    <h3 class="card-title pt-2"><span class="analytics-title">Filters</span></h3>
                  </div>
                  <div class="col-md-8">
                    <label>Select Date Range</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" name="from-date-recievals" id="from-date-recievals" placeholder="Start Date" class="fld date-for-analytics-start-date">
                      </div>
                      <div class="col-md-6">
                        <input type="text" name="to-date-recievals" id="to-date-recievals" placeholder="End Date" class="fld date-for-analytics-end-date">
                      </div>
                    </div> 
                  </div>
                  
                  <div class="col-md-6 text-right"> 
                      <select class="form-control d-inline kip-select mt-2" id="recievals_manager" onchange="common_filter_for_client()">
                      <option value="all" selected>QuinPro Solution</option>
                      <?php 
                      if (count($team)) {
                        foreach ($team as $key => $val) { 
                          echo "<option value='".$val['team_id']."' >{$val['first_name']}</option>";
                        }
                      }
                      ?>
                    </select> 
                  </div>
                   <div class="col-md-6 text-right">
                     <select class="form-control d-inline kip-select  mt-2" id="recievals_status" onchange="common_filter_for_client()">
                      <option value="status">Status</option>
                      <option value="active">Active</option>
                      <option value="inactive">InActive</option> 
                    </select>
                  </div>
                </div>
              </div>
              
            </div>
          </div>

                    <!--  -->
          <div class="col-md-6 mt-4">
            <div class="card">
              <div class="card-header card-kpi">
                <div class="row">
                  <div class="col-md-12">
                    <h3 class="card-title pt-2"><span class="analytics-title">Total Recievals</span></h3>
                  </div>
                  <div class="col-md-8">
                   <!--  <label>Select date between</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" name="from-date-recievals" id="from-date-recievals" placeholder="start date" class="fld date-for-analytics-start-date">
                      </div>
                      <div class="col-md-6">
                        <input type="text" name="to-date-recievals" id="to-date-recievals" placeholder="end date" class="fld date-for-analytics-end-date">
                      </div>
                    </div>  -->
                  </div>
                  <div class="col-md-12  mb-2 mt-2">
                    <div class="row">
                      <div class="col-md-6">
                        <a class="btn btn-info" target="_blank" href="<?php echo $this->config->item('my_base_url');?>factsuite-admin/receival-analytics"><i class="fa fa-window-maximize"></i></a>
                      </div>
                      <div class="col-md-6 text-right">
                         <a href="javascript::void(0)" id="preview-value" class="btn btn-warning" onclick="next_value(0,0)">Previous</a>
                    <a href="javascript::void(0)" id="next-value" class="btn btn-success" onclick="next_value(1,1)">Next</a>
                      </div>
                    </div>
                  </div>
                 <!--  <div class="col-md-6 text-right"> 
                      <select class="form-control d-inline kip-select mt-2" id="recievals_manager" onchange="total_recievals_items()">
                      <option value="all" selected>QuinPro Solution</option>
                      <?php 
                      if (count($team)) {
                        foreach ($team as $key => $val) { 
                          echo "<option value='".$val['team_id']."' >{$val['first_name']}</option>";
                        }
                      }
                      ?>
                    </select> 
                  </div>
                   <div class="col-md-6 text-right">
                     <select class="form-control d-inline kip-select" id="recievals_status" onchange="total_recievals_items()">
                      <option value="status">Status</option>
                      <option value="active">Active</option>
                      <option value="inactive">InActive</option> 
                    </select>
                  </div> -->
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
          <!--  -->

           <div class="col-md-6 mt-4">
            <div class="card">
              <div class="card-header card-kpi">
                <div class="row">
                  <div class="col-md-12">
                    <h3 class="card-title pt-2"><span class="analytics-title">Receivals on <?php echo date('d-m-Y')?></span></h3>
                  </div>
                  <div class="col-md-12 text-right mb-2">
                     <a href="javascript::void(0)" id="today-preview-value" class="btn btn-warning" onclick="today_next_value(0,0)">Previous</a>
                    <a href="javascript::void(0)" id="today-next-value" class="btn btn-success" onclick="today_next_value(1,1)">Next</a>
                  </div>
                  <!-- <div class="col-md-6 text-right"> 
                      <select class="form-control d-inline kip-select mt-2" id="current_day_manager" onchange="get_top_selling_current_items()">
                      <option value="all" selected>QuinPro Solution</option>
                      <?php 
                      if (count($team)) {
                        foreach ($team as $key => $val) { 
                          echo "<option value='".$val['team_id']."' >{$val['first_name']}</option>";
                        }
                      }
                      ?>
                    </select> 
                  </div>
                   <div class="col-md-6 text-right">
                     <select class="form-control d-inline kip-select" id="current_day_status" onchange="get_top_selling_current_items()">
                      <option value="Status">Status</option>
                      <option value="active">Active</option>
                      <option value="inactive">InActive</option> 
                    </select>
                  </div> -->

                </div>
              </div>
              <div class="card-body">
                <div class="text-center" id="_today_top_selling_items_error_div"></div>
                <div class="text-center chart-div">
                  <canvas height="350px" id="_today_top_selling_items_result" class="charts-canvas"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!--  -->




           <div class="col-md-6 mt-4">
            <div class="card">
              <div class="card-header card-kpi">
                <div class="row">
                  <div class="col-md-4">
                    <h3 class="card-title pt-2"><span class="analytics-title">Total Closure</span></h3>
                  </div>
                   <div class="col-md-8">
                    <!-- <label>Select date between</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" name="from-date-closure" id="from-date-closure" placeholder="start date" class="fld date-for-analytics-start-date">
                      </div>
                      <div class="col-md-6">
                        <input type="text" name="to-date-closure" id="to-date-closure" placeholder="end date" class="fld date-for-analytics-end-date">
                      </div>
                    </div>  -->
                  </div>
                     <div class="col-md-12  mb-2 mt-2">
                      <div class="row">
                      <div class="col-md-6">
                        <a class="btn btn-info" target="_blank" href="<?php echo $this->config->item('my_base_url');?>factsuite-admin/total-closure-cases-analytics"><i class="fa fa-window-maximize"></i></a>
                      </div>
                      <div class="col-md-6 text-right">
                          <a href="javascript::void(0)" id="closure-preview-value" class="btn btn-warning" onclick="total_closure_next_value(0,0)">Previous</a>
                    <a href="javascript::void(0)" id="closure-next-value" class="btn btn-success" onclick="total_closure_next_value(1,1)">Next</a>
                      </div>
                    </div>
                    
                  </div>
                   <!-- <div class="col-md-6 text-right"> 
                      <select class="form-control d-inline kip-select mt-2" id="closure_manager" onchange="total_closure_items()">
                      <option value="all" selected>QuinPro Solution</option>
                      <?php 
                      if (count($team)) {
                        foreach ($team as $key => $val) { 
                          echo "<option value='".$val['team_id']."' >{$val['first_name']}</option>";
                        }
                      }
                      ?>
                    </select> 
                  </div>
                   <div class="col-md-6 text-right">
                     <select class="form-control d-inline kip-select" id="closure_status" onchange="total_closure_items()">
                      <option value="Status">Status</option>
                      <option value="active">Active</option>
                      <option value="inactive">InActive</option> 
                    </select>
                  </div> -->

                </div>
              </div>
              <div class="card-body">
                <div class="text-center" id="total_closure_items_error_div"></div>
                <div class="text-center chart-div">
                  <canvas height="350px" id="total_closure_items_result" class="charts-canvas"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!--  -->



           <div class="col-md-6 mt-4">
            <div class="card">
              <div class="card-header card-kpi">
                <div class="row">
                  <div class="col-md-12">
                    <h3 class="card-title pt-2"><span class="analytics-title">Closure on <?php echo date('d-m-Y')?></span></h3>
                  </div>
                   <div class="col-md-12 text-right mb-2">
                     <a href="javascript::void(0)" id="today-closure-preview-value" class="btn btn-warning" onclick="today_closure_next_value(0,0)">Previous</a>
                    <a href="javascript::void(0)" id="today-closure-next-value" class="btn btn-success" onclick="today_closure_next_value(1,1)">Next</a>
                  </div>
                  <!-- <div class="col-md-6 text-right"> 
                      <select class="form-control d-inline kip-select mt-2" id="today_closure_manager" onchange="today_total_closure_items()">
                      <option value="all" selected>QuinPro Solution</option>
                      <?php 
                      if (count($team)) {
                        foreach ($team as $key => $val) { 
                          echo "<option value='".$val['team_id']."' >{$val['first_name']}</option>";
                        }
                      }
                      ?>
                    </select> 
                  </div>
                   <div class="col-md-6 text-right">
                     <select class="form-control d-inline kip-select" id="today_closure_status" onchange="today_total_closure_items()">
                       <option value="Status">Status</option>
                      <option value="active">Active</option>
                      <option value="inactive">InActive</option> 
                    </select>
                  </div> -->

                </div>
              </div>
              <div class="card-body">
                <div class="text-center" id="today_total_closure_items_error_div"></div>
                <div class="text-center chart-div">
                  <canvas height="350px" id="today_total_closure_items_result" class="charts-canvas"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!--  -->

            <!--  -->



          <div class="col-md-6 mt-4">
          <div class="card">
            <div class="card-header card-kpi">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="card-title pt-2"><span class="analytics-title">Total Active Cases In Inventory <label id="inventory-total">0</label></span></h3>
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
              <div class="text-center" id="total_active_cases_inventory_error_div"></div>
              <div class="text-center chart-div">
                <canvas height="300px" id="total_active_cases_inventory_count" class="charts-canvas"></canvas>
              </div>
            </div>
          </div>
          </div>

          <!--  -->


          <div class="col-md-6 mt-4">
          <div class="card">
            <div class="card-header card-kpi">
              <div class="row">
                <div class="col-md-6">
                  <h3 class="card-title pt-2"><span class="analytics-title">TAT Cases</h3>
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
              <div class="text-center" id="total_all_tat_error_div"></div>
              <div class="text-center chart-div">
                <canvas height="300px" id="total_tat" class="charts-canvas"></canvas>
              </div>
            </div>
          </div>
          </div>



 
          <div class="col-md-12 mt-4">
             <div class="card">
            <div class="card-header card-kpi">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="card-title pt-2"><span class="analytics-title">Select Client and Components Filter</span></h3>
                </div>
                <!-- <div class="col-md-12 text-right"> -->
                <!-- <div class="row"> -->
                   <div class="col-md-6 mt-2">
                      <select class="form-control d-inline kip-select mt-2" id="ageing_manager" onchange="component_status_client()">
                <option value="all" selected>All Clients</option>
                <?php 
                if (count($client)) {
                  foreach ($client as $key => $val) { 
                    echo "<option value='".$val['client_id']."' >{$val['client_name']}</option>";
                  }
                }
                ?>
              </select>  
                   </div>
                   <div class="col-md-6  mt-2 d-none">
                      <select class="form-control d-inline kip-select mt-2" id="candidate" onchange="component_status_client()">
                        <option value="all" selected>All Cases</option>
                        <?php 
                        if (count($candidate)) {
                          foreach ($candidate as $key => $val) { 
                            echo "<option value='".$val['candidate_id']."' >{$val['first_name']}</option>";
                          }
                        }
                        ?>
                      </select>  
                   </div>
                 <!-- </div> -->

                <!-- </div> -->
              </div>
            </div>
          </div>

          </div>
 
          <div class="col-md-6 mt-4">
            <div class="card">
              <div class="card-header card-kpi">
                <div class="row">
                  <div class="col-md-12">
                    <h3 class="card-title pt-2"><span class="analytics-title"> Cases Status</span></h3>
                  </div>
                  <div class="col-md-6 text-right d-none"> 
                <select class="form-control d-inline kip-select mt-2" id="status_manager" onchange="progress_status()">
                <option value="all" selected>All Clients</option>
                <?php 
                if (count($client)) {
                  foreach ($client as $key => $val) { 
                    echo "<option value='".$val['client_id']."' >{$val['client_name']}</option>";
                  }
                }
                ?>
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

         



    <div class="col-md-6 mt-4">
      <div class="card">
        <div class="card-header card-kpi">
          <div class="row">
            <div class="col-md-12">
              <h3 class="card-title pt-2"><span class="analytics-title">Client's Case Summary</span></h3>
            </div>
             
            <div class="col-md-6 text-right d-none"> 
                <select class="form-control d-inline kip-select mt-2" id="manager" onchange="get_monthly_pending_cases()">
                <option value="all" selected>All Clients</option>
                <?php 
                if (count($client)) {
                  foreach ($client as $key => $val) { 
                    echo "<option value='".$val['client_id']."' >{$val['client_name']}</option>";
                  }
                }
                ?>
              </select> 
            </div>
             <div class="col-md-6 text-right">
              
            </div>

          </div>
        </div>
        <div class="card-body">
           <div class="row">
             <div class="col-md-6 ml-4">Carry forward from <span id="carry_month"> <?php echo date('F')?> </span> <?php echo date('Y')?></div> <div class="col-md-4" id="two_month"></div>
             <div class="col-md-6 ml-4">Total Receival in<span id="receival_month"> <?php echo date('F')?> </span>till date</div> <div class="col-md-4" id="receival_month_total"></div>
             <div class="col-md-6 ml-4">Receival on<span> <?php echo date('d-m-Y')?> </span></div> <div class="col-md-4" id="receival_data"></div>
             <div class="col-md-6 ml-4">Total Reinitiate case</div> <div class="col-md-4" id="total-re-init"></div>
             <div class="col-md-6 ml-4">Reinitiate case on <?php echo date('d-m-Y')?></div> <div class="col-md-4" id="re-init"></div>
             <div class="col-md-6 ml-4">Total Case in hand</div> <div class="col-md-4" id="total_closure_cases">0</div>
             <div class="col-md-6 ml-4">Total closure in<span > <?php echo date('F')?> </span>till date</div> <div class="col-md-4" id="closure_month_total">0</div>
             <div class="col-md-6 ml-4">Closure case on <?php echo date('d-m-Y')?></div> <div class="col-md-4" id="closure_today">0</div>
             <div class="col-md-6 ml-4">In progress cases today</div> <div class="col-md-4" id="today_progress">0</div> 

           </div>
        </div>
      </div>
    </div>
    <!--  -->


    <!-- total case ageing  -->



             <div class="col-md-6 mt-4">
          <div class="card">
            <div class="card-header card-kpi">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="card-title pt-2"><span class="analytics-title">In Progress Case Ageing</span></h3>
                </div>
                <div class="col-md-8 text-right">
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
              <div class="text-center" id="all_progress_case_ageing_error_div"></div>
              <div class="text-center chart-div">
                <canvas height="300px" id="all_progress_case_ageing" class="charts-canvas"></canvas>
              </div>
            </div>
          </div>
          </div>





             <div class="col-md-6 mt-4">
          <div class="card">
            <div class="card-header card-kpi">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="card-title pt-2"><span class="analytics-title">In Progress Case Ageing Inventory</span></h3>
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
              <div class="text-center" id="all_progress_case_ageing_inventory_error_div"></div>
              <div class="text-center chart-div">
                <canvas height="300px" id="all_progress_case_ageing_inventory" class="charts-canvas"></canvas>
              </div>
            </div>
          </div>
          </div>



             <div class="col-md-6 mt-4">
          <div class="card">
            <div class="card-header card-kpi">
              <div class="row">
                <div class="col-md-12">
                  <h3 class="card-title pt-2"><span class="analytics-title">In Close Case Ageing</span></h3>
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
              <div class="text-center" id="all_close_case_ageing_error_div"></div>
              <div class="text-center chart-div">
                <canvas height="300px" id="all_close_case_ageing" class="charts-canvas"></canvas>
              </div>
            </div>
          </div>
          </div>



             <div class="col-md-6 mt-4">
          <div class="card">
            <div class="card-header card-kpi">
              <div class="row">
                <div class="col-md-6">
                  <h3 class="card-title pt-2"><span class="analytics-title">Component Status</span></h3>
                </div>
                <div class="col-md-6 text-right">
                  <select class="form-control d-inline kip-select mt-2" id="component_id" onchange="component_wise_status_check()"> 
                      <?php 
                      if (count($components)) {
                        foreach ($components as $key => $val) { 
                          echo "<option value='".$val['component_id']."' >{$val['component_name']}</option>";
                        }
                      }
                      ?>
                    </select>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="text-center" id="all_component_status_error_div"></div>
              <div class="text-center chart-div">
                <canvas height="300px" id="all_component_status" class="charts-canvas"></canvas>
              </div>
            </div>
          </div>
          </div>


             <div class="col-md-12 mt-4">
          <div class="card">
            <div class="card-header card-kpi">
              <div class="row">
                <div class="col-md-6">
                  <h3 class="card-title pt-2"><span class="analytics-title">Component Status (Inprogress Cases)</span></h3>
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


             <div class="col-md-12 mt-4">
          <div class="card">
            <div class="card-header card-kpi">
              <div class="row">
                <div class="col-md-6">
                  <h3 class="card-title pt-2"><span class="analytics-title">Component Status (Completed Cases)</span></h3>
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
              <div class="text-center" id="component_status_completed_status_error_div"></div>
              <div class="text-center chart-div">
                <canvas height="300px" id="component_status_completed_status" class="charts-canvas"></canvas>
              </div>
            </div>
          </div>
          </div>

             <div class="col-md-12 mt-4">
          <div class="card">
            <div class="card-header card-kpi">
              <div class="row">
                <div class="col-md-6">
                  <h3 class="card-title pt-2"><span class="analytics-title">Component Ageing (Inprogress Cases)</span></h3>
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
              <div class="text-center" id="component_status_inprogress_days_status_error_div"></div>
              <div class="text-center chart-div">
                <canvas height="300px" id="component_status_inprogress_days_status" class="charts-canvas"></canvas>
              </div>
            </div>
          </div>
          </div>

             <div class="col-md-12 mt-4">
          <div class="card">
            <div class="card-header card-kpi">
              <div class="row">
                <div class="col-md-6">
                  <h3 class="card-title pt-2"><span class="analytics-title">Component Ageing (Completed Cases)</span></h3>
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
              <div class="text-center" id="component_status_completed_days_status_error_div"></div>
              <div class="text-center chart-div">
                <canvas height="300px" id="component_status_completed_days_status" class="charts-canvas"></canvas>
              </div>
            </div>
          </div>
          </div>

           

        </div>
     </div>
  </div>
</section>
<!--Content-->

<!-- custom-js -->
<script src="<?php echo base_url();?>assets/custom-js/admin/dashboard/get-dashboard-charts.js"></script>