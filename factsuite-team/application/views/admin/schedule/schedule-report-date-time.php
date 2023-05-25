<!--Content-->

 
<?php
$weekdays = array('Monday',
                  'Tuesday',
                  'Wednesday',
                  'Thursday',
                  'Friday',
                  'Saturday',
                  'Sunday');
$month_name = array(
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July ',
    'August',
    'September',
    'October',
    'November',
    'December',
);
?>

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
         <h3>Schedule Reporting Details</h3>
        <div class="sbt-btns">
          <a href="javascript:void(0)" id="team-submit-btn" class="btn bg-blu btn-submit-cancel w-auto">Add Schedule Reporting</a>
        </div>
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Schedule Start Date</th>    
                <th>Mail Subject</th>    
                <th>Mail Body Message</th>    
                <th>Action</th>    
              </tr>
            </thead> 
            <tbody class="tbody-datatable" id="get-team-data"> 
            </tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>
  <?php // print_r($date_time_picker_type);?>
  <!-- Add role Modal Starts -->
  <div class="modal fade" id="add_holiday">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Add&nbsp;Schedule Reporting</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2">
               
              <div class="col-sm-3">
                <label class="product-details-span-light">Interval Type</label>
                <select class="fld" id="schedule-trigger">
                  <option value="once">Once</option>
                  <option value="daily">Daily</option>
                  <option value="weekly">Weekly</option>
                  <option value="monthly">Monthly</option>
                  <option value="annually">Manual</option>
                </select>
                <div id="schedule-trigger-error-msg-div"></div>  
              </div>
                
              <div class="col-sm-5" id="once-date-time">
                <label class="product-details-span-light">Reporting Date</label>
                <input type="text" class="fld schedule-time" name="date-time" id="date-time" placeholder="Select Date">
                <div id="date-time-error-msg-div"></div>  
              </div>

               <div class="col-sm-2" style="display:none;" id="div-reminder-status">
                <label>Ends Of</label>
                <select class="fld" id="end-status">
                  <option value="never">Never</option>
                  <option value="date">By Date</option>
                </select>
              </div>
              <div class="col-sm-4" style="display:none;" id="interval-date-div">
                <label>Select End Date</label>
                <input type="text" id="end-interval" class="fld multidate" name="">
              </div>
              <div class="col-sm-2 mt-4">
                
              </div>

              <div class="col-sm-12 mt-3">
                <span class="product-details-span-light">Add Time</span>
                <button id="sms-add-time" class="btn btn-success btn-sm ml-4"><i class="fa fa-plus"></i></button>
                <div class="row" id="schedule-time-div"> 
                  <!-- <div class="col-sm-3">
                    <label class="product-details-span-light d-block">Time</label>
                    <input type="time" class="fld times w-50" name="time" id="time" placeholder="Select Date">
                    <a href="javascript:void(0)" id="add-time-btn" class="btn btn-success btn-sm text-white mt-2"><i class="fa fa-plus"></i></a>
                    <div id="time-error-msg-div"></div>  
                  </div> -->
                </div>
                <div id="max-time-add-error-msg-div"></div>
              </div>

              <div class="row px-3 mb-2 mt-3" id="weeks-div" style="display: none;">
               <div class="col-sm-12">
                  <label>Select Week Days</label>
               </div>
                 <?php 
                foreach ($weekdays as $ky => $we) {
                 ?>
                  <div class="col-sm-3 mt-2">
                   <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input weeks" name="customCheck" id="customCheck_week<?php echo $ky; ?>" value="<?php echo substr($we,1,3); ?>">
                    <label class="custom-control-label" for="customCheck_week<?php echo $ky; ?>"><?php echo $we; ?></label>
                 </div>
                </div>
                 <?php 
                }
              ?> 
              </div>


              <div class="col-sm-12 px-3 mb-2" id="multidates" style="display: none;"> 
                  <label>Select Start Dates </label>
                  <input type="text" id="multi-select-date" class="multidate fld" name=""> 
              </div>

              <div class="row px-3 mb-2" id="div-months" style="display: none;"> 
                   <div class="col-sm-12">
                  <label>On The </label>
               </div>
               <div class="col-sm-6 mb-2">
               <select class="fld" id="week-reminder">
                 <option>First</option>
                 <option>Second</option>
                 <option>Third</option>
                 <option>Fourth</option>
                 <option>Last</option>
               </select>
             </div>
             <div class="col-sm-6 mb-2">
               <select class="fld" id="month-weeks">
                  <?php 
                foreach ($weekdays as $ky => $we) {
                 ?>
                  <option><?php echo $we; ?></option> 
                 <?php 
                }
              ?> 
               </select>
             </div>
                 
              </div>

             


              <div class="col-sm-12 mt-3">
                <label>Select Client</label>
                <select class="fld" id="client-id">
                  <?php 
                    if (count($client)) {
                      foreach ($client as $key => $value) {
                        if ($value['client_id'] !=0 && $value['spoc_email_id'] !='' && $value['spoc_email_id']!=null) { 
                       echo "<option value='".$value['client_id']."' data-spoc='".$value['spoc_email_id']."'>".$value['client_name'].' ('.$value['spoc_email_id']." ) </option>";
                        }
                      }
                    }
                  ?>
                </select>
              </div>
              
              <div class="col-sm-12">
                <label class="product-details-span-light">Additional Email<small> (Optional)</small></label>
                <input type="datetime" class="fld " name="additional-email" id="additional-email" placeholder="Additional Email">  
              </div>
              
              <div class="col-sm-12">
                <label class="product-details-span-light">Report Name</label>
                <input type="datetime" class="fld " name="report-name" id="report-name" placeholder="Report Name">
                <div id="report-name-error-msg-div"></div>  
              </div>
              

              <div class="col-sm-12">
                <label class="product-details-span-light">Mail Subject</label>
                <input type="datetime" class="fld " name="subject" id="subject" placeholder="Subject">
                <div id="subject-error-msg-div"></div>  
              </div>
              

              <div class="col-md-12">
                <label class="product-details-span-light">Mail Body Message</label> 
                <textarea class="fld" id="message" placeholder="Message"></textarea>
                <div id="message-error-msg-div"></div>  
              </div>

            </div>

              <div class="add-team-bx" id="reporting-fields"> 
                <label>Reporting Fields</label><br>
                <div class="custom-control custom-checkbox custom-control-inline mrg">
                  <input type="checkbox" class="custom-control-input" name="customCheck" id="CheckAll">
                  <label class="custom-control-label" for="CheckAll"><strong>Select All</strong></label>
               </div>
               <br>
                <?php 
                  if (isset($fields)) {
                    foreach ($fields as $key => $value) {
                       ?>
                       
                         <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input report-fields" data-field_name="<?php echo $value['name']; ?>" value="<?php echo $value['field']; ?>" name="customCheck" id="customCheck<?php echo $key; ?>">
                            <label class="custom-control-label" for="customCheck<?php echo $key; ?>"><?php echo $value['name']; ?></label>
                         </div>
                       
                       <?php
                    }
                  }
                ?>
              </div>
              
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-role-btn" name="edit-role-close-btn" onclick="addreporting()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add role Modal Ends -->

  <!-- Edit role Modal Starts -->
  <div class="modal fade" id="edit_holiday">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">Edit Schedule Reporting</h4> 
        </div>
        <input type="hidden" name="edit_schedule_id" id="edit_schedule_id">
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content"> 
            <div class="row mt-12"> 
              <div class="col-sm-4">
                <label class="product-details-span-light">Schedule Trigger</label>
                <select class="fld" id="edit-schedule-trigger">
                   <option value="once">Once</option>
                   <option value="daily">Daily</option>
                  <option value="weekly">Weekly</option>
                  <option value="monthly">Monthly</option>
                  <option value="annually">Manual</option>
                </select>
                <div id="edit-schedule-trigger-error-msg-div"></div>  
              </div> 
               
              <div class="col-sm-6" id="edit-once-date-time">
                <label class="product-details-span-light">Reporting Date</label>
                <input type="datetime" class="fld schedule-time" name="edit-date-time" id="edit-date-time" placeholder="Select Date">
                <div id="edit-date-time-error-msg-div"></div>  
              </div>

               <div class="col-sm-2" style="display:none;" id="edit-div-reminder-status">
                <label>Ends Of</label>
                <select class="fld" id="edit-end-status">
                  <option value="never">Never</option>
                  <option value="date">By Date</option>
                </select>
              </div>
              <div class="col-sm-4" style="display:none;" id="edit-interval-date-div">
                <label>Select End Date</label>
                <input type="text" id="edit-end-interval" class="fld multidate" name="">
              </div>

               <div class="col-sm-12 mt-3">
                <span class="product-details-span-light">Add Time</span>
                <button id="edit-sms-add-time" class="btn btn-success btn-sm ml-4"><i class="fa fa-plus"></i></button>
                <div class="row" id="edit-schedule-time-div"></div>
                <div id="edit-max-time-add-error-msg-div"></div>
              </div>


              <div class="row px-3 mb-2" id="edit-weeks-div" style="display: none;">
               <div class="col-sm-12">
                  <label>Select Weeks Days</label>
               </div>
                 <?php 
                foreach ($weekdays as $ky => $we) {
                 ?>
                  <div class="col-sm-3 mt-2">
                   <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-weeks" name="customCheck" id="edit-customCheck_week<?php echo $ky; ?>" value="<?php echo substr($we,1,3); ?>">
                    <label class="custom-control-label" for="edit-customCheck_week<?php echo $ky; ?>"><?php echo $we; ?></label>
                 </div>
                </div>
                 <?php 
                }
              ?> 
              </div>


              <div class="col-sm-12 px-3 mb-2" id="edit-multidates" style="display: none;"> 
                  <label>Select Start Dates </label>
                  <input type="text" id="edit-multi-select-date" class="multidate fld" name=""> 
              </div>

               <div class="row px-3 mb-2" id="edit-div-months" style="display: none;"> 
                   <div class="col-sm-12">
                  <label>On The </label>
               </div>
               <div class="col-sm-6 mb-2">
               <select class="fld" id="edit-week-reminder">
                 <option>First</option>
                 <option>Second</option>
                 <option>Third</option>
                 <option>Fourth</option>
                 <option>Last</option>
               </select>
             </div>
             <div class="col-sm-6 mb-2">
               <select class="fld" id="edit-month-weeks">
                  <?php 
                foreach ($weekdays as $ky => $we) {
                 ?>
                  <option><?php echo $we; ?></option> 
                 <?php 
                }
              ?> 
               </select>
             </div>
                 
              </div>

               <div class="col-sm-12">
                <label>Select Client</label>
                <select class="fld" id="edit-client-id">
                  <?php 
                    if (count($client)) {
                      foreach ($client as $key => $value) {
                        if ($value['client_id'] !=0 && $value['spoc_email_id'] !='' && $value['spoc_email_id']!=null) { 
                       echo "<option value='".$value['client_id']."' data-spoc='".$value['spoc_email_id']."'>".$value['client_name'].' ('.$value['spoc_email_id']." ) </option>";
                        }
                      }
                    }
                  ?>
                </select>
              </div>

              <div class="col-sm-12">
                <label class="product-details-span-light">Additional Email<small> (Optional)</small></label>
                <input type="datetime" class="fld " name="edit-additional-email" id="edit-additional-email" placeholder="Additional Email">  
              </div>

              <div class="col-sm-12">
                <label class="product-details-span-light">Report Name</label>
                <input type="datetime" class="fld " name="report-name" id="report-name" placeholder="Report Name">
                <div id="report-name-error-msg-div"></div>  
              </div>
              
              
              <div class="col-sm-12">
                <label class="product-details-span-light">Mail Subject</label>
                <input type="datetime" class="fld " name="subject" id="edit-subject" placeholder="Subject">
                <div id="edit-subject-error-msg-div"></div>  
              </div>
              

              <div class="col-md-12">
                <label class="product-details-span-light">Mail Body Message</label> 
                <textarea class="fld" id="edit-message" placeholder="Message"></textarea>
                <div id="edit-message-error-msg-div"></div>  
              </div>
              
            </div>
            <label>Report Fields</label>
            <div class="add-team-bx" id="edit-reporting-fields"> 
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

  <!-- Edit role Modal Starts -->
   <div class="modal fade" id="view-weeks">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">Select Weeks</h4> 
        </div>
        <input type="hidden" name="edit_schedule_id" id="edit_schedule_id">
        <div class="modal-body modal-body-edit-coupon">
            <div class="row"> 
               
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Close</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="update-weeks" name="edit-role-close-btn" >Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Coupon Modal Ends -->

</section>
<!--Content-->

<script>
  var clock_type = '<?php echo $date_time_picker_type['clock_type'];?>',
      time_12_24_hr_format = '<?php echo $date_time_picker_type['12_24_hr_format'];?>';
</script>
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/schedule/schedule-report-date-time.js"></script>