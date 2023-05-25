<section id="pg-cntr">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
        <h3>Admin Approval Mechanism</h3>
         
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sl No.</th> 
                <th>Approval&nbsp;Id</th>  
                <th>Action Type</th>  
                <th>Created&nbsp;Date</th>  
                <th>Remarks</th>  
                <th>Created By</th> 
                 <th>Status</th> 
 
                <th>View</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-all-tickets"></tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>

  <!-- Add New Ticket Modal Starts -->
  <div class="modal fade" id="add-new-ticket-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Approval Mechanism</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
          <div class="tab-content">
             
            <div class="row mt-2"> 
               <div class="col-md-6" id="status_level_1" style="display:none;">
                <label>Level 1 Status :</label>
                <span id="level_one"></span>
              </div>
              <div class="col-md-6" id="status_level_2" style="display:none;">
                <label>Level 2 Status : </label>
                <span id="level_two"></span>
              </div>
              <div class="col-md-6" id="status_level_3" style="display:none;">
                <label>Level 3 Status : </label>
                <span id="level_three"></span>
              </div>
              <div class="col-md-6" >
                <label>Final Status : </label>
                <span id="final_status"></span>
              </div>
              <div class="col-sm-12">
                 <div>Created By: <span id="created_by"></span></div>
                 <div>Action Type: <span id="action_type"></span></div>
                 <div>Created Remarks: <span id="created_remarks"></span></div>
                 <div></div>
              </div>
                 
                 <div class="row" id="extra-details"></div>
                <div class="col-md-12" id="rejected_remarks"></div>
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0 d-none">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Reject</button>
          <button type="button" class="btn bg-blu btn-close text-white" id="raise-ticket-btn">Accept</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Add New Ticket Modal Ends -->
 
</section>
<!--Content-->

<!-- custom-js --> 
<script src="<?php echo base_url() ?>assets/custom-js/admin/approval/admin-approvals.js"></script>