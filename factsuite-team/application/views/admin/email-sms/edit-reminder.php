 
<section id="pg-cntr">
  <div class="pg-hdr">
    
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
         <h3>Reminder Details</h3>
         
         <div class="row">
              <div class="col-md-6">
                  <label>Select Status</label>
                 <select class="fld form-control" id="candidate"> 
                    <option value="0">Pending</option> 
                    <option value="1">Insuff Cases</option> 
                 </select>
                 <div id="candidate-error">&nbsp;</div>
              </div>
              <div class="col-md-6 mt-4">
               <label>&nbsp;</label>
                 <button id="sechedule-time" class="btn btn-success mt-3">Choose Schedule Time</button>
              </div>
           </div>

            <div class="row" id="add-schedule-time-date">
            <div class="table-responsive col-md-10">
               <table class="table">
                   <thead>
                     <tr>
                       <th><span class="thead-th-span">SR.#</span></th>
                       <th><span class="thead-th-span">Days</span></th>
                       <th class="d-none"><span class="thead-th-span">Date</span></th>
                       <th><span class="thead-th-span">Time</span></th>
                       <th><span class="thead-th-span">SMS</span></th>
                       <th><span class="thead-th-span">Email</span></th>
                       <!-- <th><span class="thead-th-span">IVRS</span></th>  -->
                     </tr>
                   </thead>
                   <tbody class="table-fixed-tbody" id="all-schedule-list">
                      
                   </tbody>
               </table>
            </div> 
          </div>

           </div>
           
        <div class="add_team" id="error-team"></div>
        <div class="sbt-btns col-md-10">
           <a href="#" class="bg-gry btn-submit-cancel">CANCEL</a> <button id="schedul-submit-btn" class="bg-blu btn-submit-cancel" >SUBMIT</button>
        </div> 
        <!--View Team Content-->
     </div>
  </div>


<div class="modal fade" id="sechedule-time-model">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Set Schedule Time</h4>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         <div class="row">
            <div class="col-md-4">
               <label>Select Day</label>
               <select class="form-control" id="schedule-days">
                 
                  <?php 
                  for ($i=1; $i < 7; $i++) { 
                    if ($i % 2 !== 0)
                      {
                        echo "<option>{$i}</option>"; 
                      }
                  }
                  ?>
               </select>
            </div>
        </div>
         <div class="row" id="sms-time"> 
          <div class="col-md-2 mt-4">
               <label>SMS</label>
               <input type="checkbox" value="true" name="schedule-sms" class="" id="schedule-sms">
            </div> 
            <!-- <div class="col-md-3">
               <label>Remainder</label>
               <select class="form-control" id="schedule-days">
                  <option>Daily</option> 
                  <option>Once</option> 
                  <?php 
                  for ($i=1; $i < 30; $i++) { 
                    echo "<option>{$i}</option>";
                  }
                  ?>
               </select>
            </div> -->
             <div class="col-md-3 d-none">
               <label>Date</label>
               <input type="date" class="form-control" name="schedule-date" id="schedule-date">
            </div>
             <div class="col-md-2">
                <label>Time</label><button id="sms-add-time" class="btn btn-success btn-sm ml-4"><i class="fa fa-plus"></i></button>
               <input type="time" class="form-control sms_time" name="schedule-time" id="schedule-time">
            </div> 
         <!--  -->
           

          </div>
         
          <div class="row" id="email-time"> 
          <div class="col-md-2 mt-4">
                <label>Email</label>
               <input type="checkbox" value="true" name="schedule-email" class="" id="schedule-email">
            </div> 
           <!--  <div class="col-md-3">
               <label>Remainder</label>
               <select class="form-control" id="email-schedule-days">
                  <option>Daily</option> 
                  <option>Once</option> 
                  <?php 
                  for ($i=1; $i < 30; $i++) { 
                    echo "<option>{$i}</option>";
                  }
                  ?>
               </select>
            </div> -->
             <div class="col-md-3 d-none">
               <label>Date</label>
               <input type="date" class="form-control" name="email-schedule-date" id="email-schedule-date">
            </div>
             <div class="col-md-2">
                <label>Time</label><button id="email-add-time" class="btn btn-success btn-sm ml-4"><i class="fa fa-plus"></i></button>
               <input type="time" class="form-control email_time" name="email-schedule-time" id="email-schedule-time">
            </div> 
         <!--  -->
           
          </div>
         
          <div class="row d-none" id="ivrs-time">  
            <div class="col-md-2 mt-4">
               <label>IVRS</label>
               <input type="checkbox" value="true" name="schedule-ivrs" class="" id="schedule-ivrs">
            </div>  
            <!-- <div class="col-md-3">
               <label>Remainder</label>
               <select class="form-control" id="ivrs-schedule-days">
                  <option>Daily</option> 
                  <option>Once</option> 
                  <?php 
                  for ($i=1; $i < 30; $i++) { 
                    echo "<option>{$i}</option>";
                  }
                  ?>
               </select>
            </div> -->
             <div class="col-md-3 d-none">
               <label>Date</label>
               <input type="date" class="form-control" name="ivrs-schedule-date" id="ivrs-schedule-date">
            </div>
             <div class="col-md-2">
                <label>Time</label><button id="ivrs-add-time" class="btn btn-success btn-sm ml-4"><i class="fa fa-plus"></i></button>
               <input type="time" class="form-control ivrs_time" name="ivrs-schedule-time"  id="ivrs-schedule-time">
            </div> 
         <!--  --> 
            
          </div>
         
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn btn-success" id="click-to-schedule-btn">Add</button>
        <button class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

</section>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/reminder/edit-reminder.js"></script> 
<script>
    view_schedule(<?php echo $_GET['id']; ?>);
</script>
