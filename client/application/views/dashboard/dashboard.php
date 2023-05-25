  <?php
$client_name = '';
  if ($this->session->userdata('logged-in-client')) {

    $client_name = $this->session->userdata('logged-in-client')['client_name'];
  }
  
  ?>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst">
        <div class="row">
        <div class="col-md-6">
          <h1 class="client-analytics-txt border-0 mt-4">Client Analytics</h1>
        </div> 
         <div class="col-md-6 ">
          <select id="client" onchange="common_filter_for_client()" class="form-control mt-3 w-50 float-right">
            <?php 

            if ($client['parent']['is_master'] == '0') { 
            ?>
            <option value="0">Master Account</option>
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
          <!-- <h1 class="client-analytics-txt"></h1> -->
        </div> 
        <div class="col-md-12">
          <div class="client-analytics-txt mt-0"></div>
        </div>  
      <div class="col-md-9">
        <div class="row">
                 <!--  -->
<!-- completed
pending
insuff
total
init -->


           <div class="col-md-3 mt-4">
           <a href="<?php echo $this->config->item('my_base_url').$client_name.'/selected-status-cases/?param='.md5(0); ?>">
            <div class="edit-pages-a card">
              <div class="row">
                <div class="col-md-4 pr-0 mt-2">
                  <div class="analytics-img-bg analytics-img-bg-1">
                    <img src="<?php echo base_url()?>assets/client/images/sidebar-images/colored-pages.svg">
                  </div>
                </div>
                <div class="col-md-8 text-left">
                  <!-- <i class="fa fa-angle-right"></i> -->
                  <span class="card-pages-name">Initiated Cases</span>
              <div> 
                <span class="card-last-edited-date pl-2" id="home-page-total-case"><?php 
                echo isset($inventry['init'])?$inventry['init']:'0';
                 ?></span>
              </div>
                </div>
              </div>
              
            </div>
           </a>
         </div>


           <div class="col-md-3 mt-4">
           <a href="<?php echo $this->config->item('my_base_url').$client_name.'/selected-status-cases/?param='.md5(1); ?>">
            <div class="edit-pages-a card">
              <div class="row">
                <div class="col-md-4 pr-0 mt-2">
                  <div class="analytics-img-bg analytics-img-bg-2">
                    <img src="<?php echo base_url()?>assets/client/images/sidebar-images/colored-pages.svg">
                  </div>
                </div>
                <div class="col-md-8 text-left">
                  <!-- <i class="fa fa-angle-right"></i> -->
                  <span class="card-pages-name">In-progress Cases</span>
                <div>
                
                <span class="card-last-edited-date pl-2" id="home-page-pending-case"><?php 
                echo isset($inventry['pending'])?$inventry['pending']:'0';
                 ?></span>
              </div>
                </div>
              </div>
              
            </div>
           </a>
         </div>
 

           <div class="col-md-3 mt-4">
           <a href="<?php echo $this->config->item('my_base_url').$client_name.'/selected-status-cases/?param='.md5(3); ?>">
            <div class="edit-pages-a card">
              <div class="row">
                <div class="col-md-4 pr-0 mt-2">
                  <div class="analytics-img-bg analytics-img-bg-3">
                    <img src="<?php echo base_url()?>assets/client/images/sidebar-images/colored-pages.svg">
                  </div>
                </div>
                <div class="col-md-8 text-left">
                  <!-- <i class="fa fa-angle-right"></i> -->
                  <span class="card-pages-name">Insuff Cases</span>
              <div>
                 
                <span class="card-last-edited-date pl-2" id="home-page-insuff-case"><?php 
                echo isset($inventry['insuff'])?$inventry['insuff']:'0';
                 ?></span>
              </div>
                </div>
              </div>
              
            </div>
           </a>
         </div>


           <div class="col-md-3 mt-4">
           <a href="<?php echo $this->config->item('my_base_url').$client_name.'/selected-status-cases/?param='.md5(2); ?>">
            <div class="edit-pages-a card">
              <div class="row">
                <div class="col-md-4 pr-0 mt-2">
                  <div class="analytics-img-bg analytics-img-bg-4">
                    <img src="<?php echo base_url()?>assets/client/images/sidebar-images/colored-pages.svg">
                  </div>
                </div>
                <div class="col-md-8 text-left">
                  <!-- <i class="fa fa-angle-right"></i> -->
                  <span class="card-pages-name">Completed Cases</span>
              <div>
                
                <span class="card-last-edited-date pl-2" id="home-page-completed-case"><?php 
                echo isset($inventry['completed'])?$inventry['completed']:'0';
                 ?></span>
              </div>
                </div>
              </div>
              
            </div>
           </a>
         </div>



          <div class="col-md-6 mt-4">
          <div class="card card-kpi">
            <div class="card-header">
              <div class="row">
                <div class="col-md-12 pl-0">
                  <!-- <h3 class="card-title pt-2"><span class="analytics-title">Total Active Cases In Inventory <label id="inventory-total">0</label></span></h3> -->
                  <h3 class="card-title pt-2"><span class="analytics-title">Cases</span></h3>
                </div>
                 
                <div class="col-md-4 pl-0">
                     <label class="d-none">Select Status</label>
                     <select class="form-control d-inline kip-select  mt-2" id="recievals_status" onchange="all_case_list_count()">
                      <option value="status">Status</option>
                      <?php 
                         echo "<option value='0'>Initiate</option>";
                        echo "<option value='1'>In-Progress</option>";
                        echo "<option value='3'>Insuff</option>";
                        echo "<option value='2'>Completed</option>";
                      ?>
                    </select>
                  </div>

                  <div class="col-md-5 pl-0">
                    <label class="d-none">Select date between</label>
                    <input type="text" name="from-date-recievals" id="from-date-recievals" value="" placeholder="start date" class="reservation form-control mt-2"> 
                  </div>

                  <div class="col-md-3 pl-0 pr-0">
                    <label class="d-none">Select date between</label>
                    <button onclick="generate_report()" class="dashboard-export-btn mt-2">Export</button>  
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
            <div class="card card-kpi">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-12 pl-0">
                    <!-- <h3 class="card-title pt-2"><span class="analytics-title">Cases<label id="inventory-total"></label></span></h3> -->
                    <h3 class="card-title pt-2"><span class="analytics-title">Recent Report</span></h3>
                  </div>
                  
                  <div class="col-md-4 pl-0">
                     <label class="d-none">Select Status</label>
                     <select class="form-control d-inline kip-select  mt-2" id="recievals_status1" onchange="get_yearly_cases()">
                      <option value="status">Status</option>
                      <?php 
                         echo "<option value='0'>Initiate</option>";
                        echo "<option value='1'>In-Progress</option>";
                        echo "<option value='3'>Insuff</option>";
                        echo "<option value='2'>Completed</option>";
                      ?>
                    </select>
                  </div>

                  <div class="col-md-5 pl-0">
                    <label class="d-none">Select date between</label>
                    <input type="text" name="from-date-recievals" id="from-date-recievals1" value="" placeholder="start date" class="reservation form-control mt-2">   
                  </div>

                  <div class="col-md-3 pl-0 pr-0">
                    <label class="d-none">Select date between</label>
                    <button onclick="generate_report(1)" class="dashboard-export-btn mt-2">Export</button>  
                  </div> 
                  
                </div>
              </div>
              <div class="card-body">
                <div class="text-center" id="total_active_cases_inventory_error_div"></div>
                <div class="text-center chart-div">
                  <canvas style="height: 350px;!important  width:350px;!important"  id="year_case_inventoty_chart" class="charts-canvas"></canvas>
                </div>
              </div>
            </div>
          </div>

          

    <div class="col-md-6 mt-4 d-none">
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
               /* if (count($client)) {
                  foreach ($client as $key => $val) { 
                    echo "<option value='".$val['client_id']."' >{$val['client_name']}</option>";
                  }
                }*/
                ?>
              </select> 
            </div>

             <div class="col-md-6 text-right">
              
            </div>

          </div>
        </div>
        <div class="card-body">
           <div class="row">
             <div class="col-md-6 ml-4">Carry forword from <span id="carry_month"> <?php echo date('F')?> </span> <?php echo date('Y')?></div> <div class="col-md-4" id="two_month"></div>
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

  </div>
  </div>

      <div class="col-md-3">
        <div class="row card mt-4 py-4 welcome-back-card">
          <div class="col-md-12">
            <div class="edit-pages-a no-box-shadow bg-info">
              <div class="row">
                <div class="col-md-9 text-left"> 
                  <h3 class="text-white">Welcome Back!</h3>
                  <span class="text-white welcome-back-txt-span">For more profile control</span>
                <div> 
              </div>
            </div>
            <div class="col-md-3 mt-2"> 
              <img src="<?php echo base_url()?>assets/client/images/sidebar-images/colored-pages.svg">
            </div>
          </div>
        </div>
      </div> 

        <div class="col-md-12 mt-4 show-total-card total-reports-div">
          <a href="<?php echo $this->config->item('my_base_url').$client_name.'/selected-report-cases/?param='.md5('total'); ?>">
            <div class="edit-pages-a card">
              <div class="row">
                <div class="col-md-9 text-left">
                  <h5 id="home-page-total-report" ><?php echo $total; ?></h5>
                  <span class="card-last-edited-date" >Total Reports</span>
                </div>
                <div class="col-md-3 mt-2">
                  <div class="analytics-arrow-div">
                    <div class="analytics-arrow-inner-div">
                      <i class="fa fa-arrow-right"></i>
                    </div>
                    <!-- <img src="assets/client/images/right-arrow.png"> -->
                  </div>
                </div>
              </div>
            <!-- </div> -->
          </div>
        </a>
      </div>

          <div class="col-md-12 mt-4 show-total-card green-color-reports-div">
           <a href="<?php echo $this->config->item('my_base_url').$client_name.'/selected-report-cases/?param='.md5('green'); ?>">
            <div class="edit-pages-a card">
              <div class="row">
                <div class="col-md-9 text-left">
                  <!-- <i class="fa fa-angle-right"></i> -->
                  <h5 class="card-pages-name"  id="home-page-green-report"><?php echo isset($report['green'])?$report['green']:'0';?></h5>
                  <span class="card-last-edited-date">Green Color Reports</span>
                </div>
                <div class="col-md-3 mt-2"> 
                  <div class="analytics-arrow-div">
                    <div class="analytics-arrow-inner-div">
                      <i class="fa fa-arrow-right"></i>
                    </div>
                    <!-- <img src="assets/client/images/right-arrow.png"> -->
                  </div>
                </div> 
              </div>
            </div>
          <!-- </div>     -->
        <!-- </div> -->
      </a>
    </div> 
    <div class="col-md-12 mt-4 show-total-card orange-color-reports-div">
     <a href="<?php echo $this->config->item('my_base_url').$client_name.'/selected-report-cases/?param='.md5('orange'); ?>">
      <div class="edit-pages-a card">
        <div class="row">
          <div class="col-md-9 text-left">
            <!-- <i class="fa fa-angle-right"></i> -->
            <h5 class="card-pages-name" id="home-page-orange-report"><?php echo isset($report['orange'])?$report['orange']:'0';?></h5>
            <span class="card-last-edited-date" >Orange Color Reports</span>
          </div>
          <div class="col-md-3 mt-2"> 
            <div class="analytics-arrow-div">
              <div class="analytics-arrow-inner-div">
                <i class="fa fa-arrow-right"></i>
              </div>
              <!-- <img src="assets/client/images/right-arrow.png"> -->
            </div>
          </div>
        </div>
        
      </div>
     </a>
   </div> 

    <div class="col-md-12 mt-4 show-total-card blue-color-reports-div">
     <a href="<?php echo $this->config->item('my_base_url').$client_name.'/selected-report-cases/?param='.md5('blue'); ?>">
      <div class="edit-pages-a card">
        <div class="row"> 
          <div class="col-md-9 text-left">
            <!-- <i class="fa fa-angle-right"></i> -->
            <h5 class="card-pages-name" id="home-page-blue-report"><?php echo isset($report['blue'])?$report['blue']:'0';?></h5>
            <span class="card-last-edited-date" >Blue Color Reports</span>
          </div>
          <div class="col-md-3 mt-2"> 
            <div class="analytics-arrow-div">
              <div class="analytics-arrow-inner-div">
                <i class="fa fa-arrow-right"></i>
              </div>
              <!-- <img src="assets/client/images/right-arrow.png"> -->
            </div>
          </div>
        </div>
      </div>
     </a>
   </div> 

    <div class="col-md-12 mt-4 show-total-card red-color-reports-div">
      <a href="<?php echo $this->config->item('my_base_url').$client_name.'/selected-report-cases/?param='.md5('red'); ?>">
        <div class="edit-pages-a card">
          <div class="row"> 
            <div class="col-md-9 text-left">
              <!-- <i class="fa fa-angle-right"></i> -->
              <h5 class="card-pages-name" id="home-page-red-report"><?php echo isset($report['red'])?$report['red']:'0';?></h5>
              <span class="card-last-edited-date" >Red Color Reports</span>
            </div>
            <div class="col-md-3 mt-2"> 
              <div class="analytics-arrow-div">
                <div class="analytics-arrow-inner-div">
                  <i class="fa fa-arrow-right"></i>
                </div>
                <!-- <img src="assets/client/images/right-arrow.png"> -->
              </div>
            </div>
          </div>
        </div>
       </a>
    </div> 


      </div>
      <!-- end row -->
      </div>

  

  </div>
    <!--  -->




 
        <div class="row mt-4 d-none">
                    <div class="table-responsive mt-3" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Case id</th>
                <th>Candidate Name</th> 
                <th>Client Name</th>  
                <th>Package Name</th>   
                <th>Phone Number</th> 
                <th>Email Id</th> 
                <th>Priority</th> 
                <th>Verification Status</th> 
                <th>Assigned InputQc</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-case-data-1"> 
                <?php 
                 $i = 1; 
                    if (count($case) > 0) {
                        foreach ($case as $key => $value) {

                        $status = '';
                        if ($value['is_submitted'] == '0') {
                           $status = '<span class="text-warning">pending<span>';
                        }else if ($value['is_submitted'] == '1') {
                               $status = '<span class="text-info">in-progress<span>';
                           }else{
                               $status = '<span class="text-success">submitted<span>';
                           }


              $priority = '';
            $tat_days_color = '';
            $tat_days = ''; 
            if($value['priority'] == '0'){
                $priority = '<span class="text-info font-weight-bold">Low</span>';
                $tat_days_color = '<span class="text-info font-weight-bold">'.isset($value['low_priority_days'])?$value['low_priority_days']:'0'.'</span>';
                $tat_days = isset($value['low_priority_days'])?$value['low_priority_days']:'0';
            }else if($value['priority'] == '1'){  
                $priority = '<span class="text-warning  font-weight-bold">Medium</span>';
                $tat_days_color = '<span class="text-warning font-weight-bold">'.isset($value['medium_priority_days'])?$value['medium_priority_days']:'0'.'</span>';
                $tat_days = isset($value['medium_priority_days'])?$value['medium_priority_days']:'0';
            }else if($value['priority'] == '2'){  
                $priority = '<span class="text-danger font-weight-bold">High</span>';
                $tat_days_color = '<span class="text-danger font-weight-bold">'.isset($value['high_priority_days'])?$value['high_priority_days']:'0'.'</span>';
                $tat_days = isset($value['high_priority_days'])?$value['high_priority_days']:'0';
            }

            $Input = $this->caseModel->get_team_member_name($value['assigned_inputqc_id']); 
            $inPutQcName = '-';
            // outputQcName = '<span class="text-warning">Pending</span>'
            if(isset($Input['first_name'])){
                $inPutQcName = $Input['first_name'].' '.$Input['last_name'];
            }


 
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $value['candidate_id']; ?></td>
                                <td><?php echo $value['first_name']; ?></td> 
                                <td><?php echo $value['client_name']; ?></td>
                                <td><?php echo $value['pack_name']; ?></td>
                                <td><?php echo $value['phone_number']; ?></td>
                                <td><?php echo $value['email_id']; ?></td>
                                <td><?php echo $priority; ?></td>
                                <td><?php echo $status; ?></td>
                                <td><?php echo $inPutQcName; ?></td>
                                  
                            </tr>

                            <?php 
                        }
                    } 
                ?>
            </tbody>
          </table>
        </div>
          
        </div>

       



     </div>
  </div>
</section>
<!--Content-->

<!-- header custom-js  -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>
<script>
  var mychart = document.getElementById("myPieChart").getContext('2d');
  let round_graph = new Chart(mychart, {
    type: 'doughnut',
    data: {
      labels: ['In-progress:3','Completed:5', 'Insufficancy:2'],
      datasets: [{
        lable: 'Samples',
        data: [3, 5, 2],
        backgroundColor: ['#FF9F43', '#1cc88a', '#dc3545'],
        hoverBackgroundColor: ['#FF9F43', '#1cc88a', '#dc3545'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }]
    }

  })

</script>

<script>
  var today_case = document.getElementById("today_case_inventoty_chart").getContext('2d');
  let graph = new Chart(today_case, {
    type: 'doughnut',
    data: {
      labels: ['In-progress:1','Completed:2', 'Insufficancy:0'],
      datasets: [{
        lable: 'Samples',
        data: [1, 2, 0],
        backgroundColor: ['#FF9F43', '#1cc88a', '#dc3545'],
        hoverBackgroundColor: ['#FF9F43', '#17a673', '#dc3545'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }]
    }

  })

</script>

<script>
// var ctx = document.getElementById('year_case_inventoty_chart').getContext('2d');
// var myChart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Des'],
//         datasets: [{
//             label: '# of Cases',
//             data: [12, 19, 3, 5, 2, 3,12, 19, 3, 5, 2, 3],
//             backgroundColor: [
//                 'rgba(60,141,188,0.9)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8))',
//                 'rgba(60,141,188,0.8)'
//             ],
//             borderColor: [
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8)',
//                 'rgba(60,141,188,0.8))',
//                 'rgba(60,141,188,0.8)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: false
//             }
//         }
//     }
// });
</script>
<script src="<?php echo base_url();?>assets/custom-js/dashboard/get-dashboard-charts.js"></script>
<script src="<?php echo base_url();?>assets/custom-js/case/export.js"></script>
<!-- <script src="http://localhost/factsuite/factsuite-team/assets/custom-js/admin/dashboard/get-dashboard-charts.js"></script> -->