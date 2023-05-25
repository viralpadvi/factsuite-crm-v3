<section id="pg-cntr">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
        <h3>Additional Verification Fee</h3>
        <div class="sbt-btns">
          <a href="javascript:void(0)" id="team-submit-btn" data-toggle="modal" data-target="#add-new-ticket-modal"class="btn bg-blu btn-submit-cancel">Additional Verification Fee</a>
        </div>
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sl No.</th> 
                <th>Approval&nbsp;Id</th>  
                <th>Action Type</th>  
                <th>Created&nbsp;Date</th>  
                <th>Remarks</th>  
                <th>Status</th>  
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
          <h4 class="modal-title-edit-coupon-1">Additional Verification Fee</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
          <div class="tab-content">
             
            <div class="row mt-2">
                <div class="col-sm-6">
                   <label class="product-details-span-light">Case ID</label>
                   <input type="text" class="form-control" name="case-id" id="case-id">
                 </div> 
                 <div class="col-sm-6">
                   <label class="product-details-span-light">Component Name</label>
                   <input type="text" class="form-control" name="component-name" id="component-name">
                 </div>
                 <div class="col-sm-6">
                   <label class="product-details-span-light">Verification Fee Amount</label>
                   <input type="text" class="form-control" name="amount" id="amount">
                 </div> 
                 <div class="col-sm-6">
                   <label class="product-details-span-light">Institution/ Portal Name</label>
                   <input type="text" class="form-control" name="portal-name" id="portal-name">
                 </div>
              <div class="col-sm-6">
                <label class="product-details-span-light">Select Role</label>
                <select class="form-control fld" id="assigned-to-role">
                  <option value="">Select Role</option>
                </select>
                <div id="assigned-to-role-error-msg-div"></div>
              </div>
              
              <div class="col-sm-6" id="client-list">
                <label class="product-details-span-light">Select Person</label>
                <select class="form-control fld" id="assigned-to-person">
                  <option value="">Select Person</option>
                </select>
                <div id="assigned-to-person-error-msg-div"></div>
              </div>

              
              
              <div class="col-md-12">
                <label class="product-details-span-light">Remarks</label>
                <!-- ckeditor -->
                <textarea class="fld" name="ticket_description" id="ticket_description" placeholder="Remarks"></textarea>
                <div id="ticket-description-error-msg-div"></div>
              </div>
               
              <div class="col-sm-12">
                <div id="raise-ticket-error-msg-div"></div>
              </div>
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" id="raise-ticket-btn">Add</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Add New Ticket Modal Ends -->
 
</section>
<!--Content-->

<!-- custom-js -->
<script src="<?php echo base_url() ?>assets/custom-js/analyst/approval/create-approval.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/approval/all-approvals.js"></script>