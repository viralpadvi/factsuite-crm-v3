 
<section id="pg-cntr">
  <div class="pg-hdr">
    
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
         <h3>Reminder Details</h3>
          
            <div class="row" id="add-schedule-time-date">
            <div class="table-responsive col-md-12">
               <table class="table table-condensed table-set-font-size table-striped table-fixed datatable">
                  <thead >
                      <tr>
                        <th>Sr No.</th> 
                        <th>Schedule Title</th>   
                        <th>Schedule Status</th>   
                        <th>View</th>  
                        <th>Action</th>  
                      </tr>
                    </thead>
                  <tbody class="tbody-datatable" id="all-schedule-list">
                    <tr>
                      <td colspan="5" class="text-center">Loading....</td>
                    </tr>
                  </tbody>
                </table>
            </div> 
          </div>

           </div>
           
      
        <!--View Team Content-->
     </div>
  </div>

 
<div class="modal fade" id="sechedule-time-model">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Schedule Time</h4>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          
            <div class="row" id="add-schedule-time-date">
                <div class="col-md-12" id="schedule-status"></div>
            <div class="table-responsive col-md-12">
               <table class="table">
                   <thead>
                     <tr>
                       <th><span class="thead-th-span">SR.#</span></th>
                       <th><span class="thead-th-span">Days</span></th>
                       <!-- <th><span class="thead-th-span">Date</span></th> -->
                       <th><span class="thead-th-span">Time</span></th>
                       <th><span class="thead-th-span">SMS</span></th>
                       <th><span class="thead-th-span">Email</span></th> 
                     </tr>
                   </thead>
                   <tbody class="table-fixed-tbody" id="single-schedule-list">
                      
                   </tbody>
               </table>
            </div> 
          </div>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn btn-success d-none" id="click-to-schedule-btn">Edit</button>
        <button class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



<div class="modal fade" id="remove-modal">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
 
      <!-- Modal body -->
      <div class="modal-body"> 
        <h6>Are you sure want to remove this data?</h6>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn btn-success" id="click-to-remove-btn">Ok</button>
        <button class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



</section>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/reminder/view-reminder.js"></script> 
