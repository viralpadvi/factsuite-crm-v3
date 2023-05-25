  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
        <div class="row">
                    <!--  -->
          <div class="col-md-12 mt-4">
            <div class="card">
              <div class="card-header card-kpi">
                <div class="row">
                  <div class="col-md-4">
                    <h3 class="card-title pt-2"><span class="analytics-title">Total Recievals in <!-- <b><?php echo date("F")?></b> --> till date</span></h3>
                  </div>
                  <div class="col-md-8">
                    <label>Select date between</label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" name="from-date-recievals" id="from-date-recievals" placeholder="start date" class="fld date-for-analytics-start-date">
                      </div>
                      <div class="col-md-6">
                        <input type="text" name="to-date-recievals" id="to-date-recievals" placeholder="end date" class="fld date-for-analytics-end-date">
                      </div>
                    </div> 
                  </div>
                  
                  <div class="col-md-6 text-right"> 
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
          <!--  -->
   
 

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
<script src="<?php echo base_url();?>assets/custom-js/admin/dashboard/receivals-analytics.js"></script>