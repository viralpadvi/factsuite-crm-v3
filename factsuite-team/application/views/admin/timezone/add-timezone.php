<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
          <div id="FS-candidate-mn" class="add-team">
            
        </div>
      </div>
   </div>
</section>
<section id="pg-cntr">
  <div class="pg-hdr">
    
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
         <h3>Timezone Setting</h3>
                  <div class="row">
            <div class="col-sm-6 mt-2"> 
                <!-- <input type="text" class="fld timezone" name="timezone" id="timezone" placeholder="Select Date"> -->
                <select class="fld" id="add-timezone">
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
                <select class="fld" id="add-clock">
                   <option value="0">Digital</option>
                   <option value="1">Analog</option>
                </select>
                <div id="clock-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6 mt-2"> 
                <select class="fld" id="add-time-type">
                   <option value="0">12</option>
                   <option value="1">24</option>
                </select>
                <div id="time-type-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6 mt-2"> 
                <select class="fld" id="add-time-formate">
                  <?php 
                    foreach ($date_time as $key => $value) {
                       echo "<option value='".$value['id']."'>[".$value['name'].'] '.date($value['code'])."</option>";
                    }
                  ?> 
                </select>
                <div id="time-formate-error-msg-div"></div>  
              </div>
              <div class="col-sm-12 text-right mt-2">
                  <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-role-btn" name="edit-role-close-btn" onclick="addtimezone()">Save</button>
              </div>
          </div> 
        <!--View Team Content-->
     </div>
  </div>

  <!-- Add role Modal Starts -->
  <div class="modal fade" id="add_timezone">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Add&nbsp;Timezone</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2">
                 <div class="col-md-6 d-none">
            <label>Select Your Client</label>
            <select class="fld form-control " id="client_id">
               <option value="">Select Your Client</option>
               <option value="0">ALL</option>
               <?php
                  foreach ($clientInfo as $key => $value) {
                     $select = '';
                     if (isset($_GET['client_id'])) {
                        if ($_GET['client_id'] == $value['client_id']) { 
                       $select = 'selected';
                        }
                     }
                     echo '<option '.$select.' value="'.$value['client_id'].'">'.$value['client_name'].'</option>';
                  }
               ?>
            </select>             
            <div id="select-client-error">&nbsp;</div>                          
         </div>  


              <div class="col-sm-6"> 
                <!-- <input type="text" class="fld timezone" name="timezone" id="timezone" placeholder="Select Date"> -->
                <select class="fld" id="add-timezone">
                   <option value="">Select Timezone</option>
                   <?php 
                     foreach ($timezone as $key => $val) {
                        echo '<option value="'.$val.'">'.$val.'</option>';
                     }
                   ?>
                </select>
                <div id="timezone-error-msg-div"></div>  
              </div>
               
              <div class="col-sm-6"> 
                <select class="fld" id="add-clock">
                   <option value="Digital">Digital</option>
                   <option value="Analog">Analog</option>
                </select>
                <div id="clock-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6 mt-2"> 
                <select class="fld" id="add-time-type">
                   <option value="12">12</option>
                   <option value="24">24</option>
                </select>
                <div id="time-type-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6 mt-2"> 
                <select class="fld" id="add-time-formate">
                   <option value="dd/mm/yyyy">[dd/mm/yyyy] (<?php echo date('d/m/Y'); ?>)</option> 
                   <option value="mm/dd/yyyy">[mm/dd/yyyy] (<?php echo date('m/d/Y'); ?>)</option> 
                   <option value="dd/mm/yyyy hh:ii">[dd/mm/yyyy hh:ii] (<?php echo date('d/m/Y H:i'); ?>)</option> 
                   <option value="mm/dd/yyyy hh:ii">[mm/dd/yyyy hh:ii] (<?php echo date('m/d/Y H:i'); ?>)</option> 
                   <option value="dd-mm-yyyy">[dd-mm-yyyy] (<?php echo date('d-m-Y'); ?>)</option> 
                   <option value="mm-dd-yyyy">[mm-dd-yyyy] (<?php echo date('m-d-Y'); ?>)</option> 
                   <option value="dd-mm-yyyy hh:ii">[dd-mm-yyyy hh:ii] (<?php echo date('d-m-Y H:i'); ?>)</option> 
                   <option value="mm-dd-yyyy hh:ii">[mm-dd-yyyy hh:ii] (<?php echo date('m-d-Y H:i'); ?>)</option>  

                    <option value="yyyy/dd/mm">[yyyy/dd/mm] (<?php echo date('Y/d/m'); ?>)</option> 
                   <option value="yyyy/mm/dd">[yyyy/mm/dd] (<?php echo date('Y/m/d'); ?>)</option> 
                   <option value="yyyy/dd/mm hh:ii">[yyyy/dd/mm hh:ii] (<?php echo date('Y/d/m H:i'); ?>)</option> 
                   <option value="yyyy/mm/dd hh:ii">[yyyy/mm/dd hh:ii] (<?php echo date('Y/m/d H:i'); ?>)</option> 
                   <option value="yyyy-dd-mm">[yyyy-dd-mm] (<?php echo date('Y-d-m'); ?>)</option> 
                   <option value="yyyy-mm-dd">[yyyy-mm-dd] (<?php echo date('Y-m-d'); ?>)</option> 
                   <option value="yyyy-dd-mm hh:ii">[yyyy-dd-mm hh:ii] (<?php echo date('Y-d-m H:i'); ?>)</option> 
                   <option value="yyyy-mm-dd hh:ii">[yyyy-mm-dd hh:ii] (<?php echo date('Y-m-d H:i'); ?>)</option>  
                </select>
                <div id="time-formate-error-msg-div"></div>  
              </div>
              
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-role-btn" name="edit-role-close-btn" onclick="addtimezone()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add role Modal Ends -->



  <!-- Edit role Modal Starts -->
   <div class="modal fade" id="edit_timezone">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">Edit timezone</h4> 
        </div>
        <input type="hidden" name="time_id" id="time_id">
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content"> 
            <div class="row mt-2">
                 <div class="col-md-6 d-none">
            <label>Select Your Client</label>
            <select class="fld form-control " id="edit-client_id">
               <option value="">Select Your Client</option>
               <option value="0">ALL</option>
               <?php
                  foreach ($clientInfo as $key => $value) {
                     $select = '';
                     if (isset($_GET['client_id'])) {
                        if ($_GET['client_id'] == $value['client_id']) { 
                       $select = 'selected';
                        }
                     }
                     echo '<option '.$select.' value="'.$value['client_id'].'">'.$value['client_name'].'</option>';
                  }
               ?>
            </select>             
            <div id="select-client-error">&nbsp;</div>                          
         </div>  


              <div class="col-sm-6 mt-2"> 
                <!-- <input type="text" class="fld timezone" name="timezone" id="timezone" placeholder="Select Date"> -->
                <select class="fld" id="edit-timezone">
                   <option value="">Select Timezone</option>
                   <?php 
                     foreach ($timezone as $key => $val) {
                        echo '<option value="'.$val.'">'.$val.'</option>';
                     }
                   ?>
                </select>
                <div id="edit-timezone-error-msg-div"></div>  
              </div>
               
              <div class="col-sm-6 mt-2"> 
                <select class="fld" id="edit-clock">
                   <option value="Digital">Digital</option>
                   <option value="Analog">Analog</option>
                </select>
                <div id="edit-clock-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6 mt-2"> 
                <select class="fld" id="edit-time-type">
                   <option value="12">12</option>
                   <option value="24">24</option>
                </select>
                <div id="edit-time-type-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6 mt-2"> 
                <select class="fld" id="edit-time-formate">
                   <option value="dd/mm/yyyy">[dd/mm/yyyy] (<?php echo date('d/m/Y'); ?>)</option> 
                   <option value="mm/dd/yyyy">[mm/dd/yyyy] (<?php echo date('m/d/Y'); ?>)</option> 
                   <option value="dd/mm/yyyy hh:ii">[dd/mm/yyyy hh:ii] (<?php echo date('d/m/Y H:i'); ?>)</option> 
                   <option value="mm/dd/yyyy hh:ii">[mm/dd/yyyy hh:ii] (<?php echo date('m/d/Y H:i'); ?>)</option> 
                   <option value="dd-mm-yyyy">[dd-mm-yyyy] (<?php echo date('d-m-Y'); ?>)</option> 
                   <option value="mm-dd-yyyy">[mm-dd-yyyy] (<?php echo date('m-d-Y'); ?>)</option> 
                   <option value="dd-mm-yyyy hh:ii">[dd-mm-yyyy hh:ii] (<?php echo date('d-m-Y H:i'); ?>)</option> 
                   <option value="mm-dd-yyyy hh:ii">[mm-dd-yyyy hh:ii] (<?php echo date('m-d-Y H:i'); ?>)</option>  

                    <option value="yyyy/dd/mm">[yyyy/dd/mm] (<?php echo date('Y/d/m'); ?>)</option> 
                   <option value="yyyy/mm/dd">[yyyy/mm/dd] (<?php echo date('Y/m/d'); ?>)</option> 
                   <option value="yyyy/dd/mm hh:ii">[yyyy/dd/mm hh:ii] (<?php echo date('Y/d/m H:i'); ?>)</option> 
                   <option value="yyyy/mm/dd hh:ii">[yyyy/mm/dd hh:ii] (<?php echo date('Y/m/d H:i'); ?>)</option> 
                   <option value="yyyy-dd-mm">[yyyy-dd-mm] (<?php echo date('Y-d-m'); ?>)</option> 
                   <option value="yyyy-mm-dd">[yyyy-mm-dd] (<?php echo date('Y-m-d'); ?>)</option> 
                   <option value="yyyy-dd-mm hh:ii">[yyyy-dd-mm hh:ii] (<?php echo date('Y-d-m H:i'); ?>)</option> 
                   <option value="yyyy-mm-dd hh:ii">[yyyy-mm-dd hh:ii] (<?php echo date('Y-m-d H:i'); ?>)</option>  
                </select>
                <div id="edit-time-formate-error-msg-div"></div>  
              </div>
              
            </div>
          </div> 
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Close</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-role-btn" name="edit-role-close-btn" onclick="updateData()">Update</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Coupon Modal Ends -->

 

</section>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/timezone/add-timezone.js"></script> 
