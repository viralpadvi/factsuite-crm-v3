
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
         <!-- <h3>Case Detail</h3> -->
           
          <div class="row">
            <div class="col-sm-6 mt-2"> 
                <!-- <input type="text" class="fld timezone" name="timezone" id="timezone" placeholder="Select Date"> -->
                <label>Time Zone</label>
                <select class="fld w-100" id="add-timezone">
                   <option value="">Select Timezone</option>
                   <?php 
                     foreach ($timezone as $key => $val) {
                        echo '<option value="'.$val.'">'.$val.'</option>';
                     }
                   ?>
                </select>
                <div id="timezone-error-msg-div"></div>  
              </div>
               
              <div class="col-sm-6 mt-2 d-none"> 
                <label>Clock Type</label>
                <select class="fld w-100" id="add-clock">
                   <option value="Digital">Digital</option>
                   <option value="Analog">Analog</option>
                </select>
                <div id="clock-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6 mt-2"> 
                <label>Time Format</label>
                <select class="fld w-100" id="add-time-type">
                   <option value="12">12</option>
                   <option value="24">24</option>
                </select>
                <div id="time-type-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6 mt-2"> 
                 <label>Date Format</label>
                <select class="fld w-100" id="add-time-formate">
                   <option value="d/m/Y">[dd/mm/yyyy] (<?php echo date('d/m/Y'); ?>)</option> 
                   <option value="m/d/Y">[mm/dd/yyyy] (<?php echo date('m/d/Y'); ?>)</option> 
                   <option value="d/m/Y H:i">[dd/mm/yyyy hh:ii] (<?php echo date('d/m/Y H:i'); ?>)</option> 
                   <option value="m/d/Y H:i">[mm/dd/yyyy hh:ii] (<?php echo date('m/d/Y H:i'); ?>)</option> 
                   <option value="d-m-Y">[dd-mm-yyyy] (<?php echo date('d-m-Y'); ?>)</option> 
                   <option value="m-dd-Y">[mm-dd-yyyy] (<?php echo date('m-d-Y'); ?>)</option> 
                   <option value="d-m-Y H:i">[dd-mm-yyyy hh:ii] (<?php echo date('d-m-Y H:i'); ?>)</option> 
                   <option value="m-d-Y H:i">[mm-dd-yyyy hh:ii] (<?php echo date('m-d-Y H:i'); ?>)</option>  

                    <option value="Y/d/m">[yyyy/dd/mm] (<?php echo date('Y/d/m'); ?>)</option> 
                   <option value="Y/m/d">[yyyy/mm/dd] (<?php echo date('Y/m/d'); ?>)</option> 
                   <option value="Y/d/m H:i">[yyyy/dd/mm hh:ii] (<?php echo date('Y/d/m H:i'); ?>)</option> 
                   <option value="Y/m/dd H:i">[yyyy/mm/dd hh:ii] (<?php echo date('Y/m/d H:i'); ?>)</option> 
                   <option value="Y-d-m">[yyyy-dd-mm] (<?php echo date('Y-d-m'); ?>)</option> 
                   <option value="Y-m-d">[yyyy-mm-dd] (<?php echo date('Y-m-d'); ?>)</option> 
                   <option value="Y-d-m H:i">[yyyy-dd-mm hh:ii] (<?php echo date('Y-d-m H:i'); ?>)</option> 
                   <option value="Y-m-d H:i">[yyyy-mm-dd hh:ii] (<?php echo date('Y-m-d H:i'); ?>)</option>  
                   <option value="d/m/Y h:i A">[yyyy-MM-dd hh:ii A] (<?php echo date('d/m/Y h:i A'); ?>)</option>  
                   <option value="d/m/Y h:i a">[yyyy-MM-dd hh:ii a] (<?php echo date('d/m/Y h:i a'); ?>)</option>
                   <option value="d/m/Y h:i A">[dd/mm/yyyy hh:ii A] (<?php echo date('d/m/Y h:i A'); ?>)</option>
                   <option value="d/m/Y h:i a">[dd/mm/yyyy hh:ii a] (<?php echo date('d/m/Y h:i a'); ?>)</option>
                   <option value="m/d/Y h:i A">[mm/dd/yyyy hh:ii A] (<?php echo date('m/d/Y h:i A'); ?>)</option>
                   <option value="m/d/Y h:i a">[mm/dd/yyyy hh:ii a] (<?php echo date('m/d/Y h:i a'); ?>)</option>
                   <option value="d-m-Y h:i A">[dd-mm-yyyy hh:ii A] (<?php echo date('d-m-Y h:i A'); ?>)</option>
                   <option value="d-m-Y h:i a">[dd-mm-yyyy hh:ii a] (<?php echo date('d-m-Y h:i a'); ?>)</option>
                   <option value="m-d-Y h:i A">[mm-dd-yyyy hh:ii A] (<?php echo date('m-d-Y h:i A'); ?>)</option>
                   <option value="m-d-Y h:i a">[mm-dd-yyyy hh:ii a] (<?php echo date('m-d-Y h:i a'); ?>)</option>
                </select>
                <div id="time-formate-error-msg-div"></div>  
              </div>
              <div class="col-sm-12 text-right mt-2">
                  <button type="button" class="btn btn-submit" id="add-role-btn" name="edit-role-close-btn" onclick="addtimezone()">Save</button>
              </div>
          </div>
     </div>
  </div>
</section>
<!--Content-->

 <script src="<?php echo base_url() ?>assets/custom-js/client-setting.js"></script>