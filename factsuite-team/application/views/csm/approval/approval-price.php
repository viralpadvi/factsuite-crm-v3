<section id="pg-cntr">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
        <h3>Client rate creation/ change</h3>
        <div class="sbt-btns">
          <a href="javascript:void(0)" id="team-submit-btn" data-toggle="modal" data-target="#add-new-ticket-modal"class="btn bg-blu btn-submit-cancel">creation/ change</a>
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
  <div class="modal fade" id="new-new-ticket-modal">
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
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Close</button> 
        </div>
      </div>
    </div>
  </div>
  <!-- Add New Ticket Modal Ends -->
 
  <!-- Add New Ticket Modal Starts -->
  <div class="modal fade" id="add-new-ticket-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Client rate creation/ change</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
          <div class="tab-content">
             
            <div class="row mt-2"> 
              <div class="col-sm-6">
                <label class="product-details-span-light">Approval Type</label>
                <select class="form-control fld" id="type-of-approval">
                  <option value="0">Creation</option>
                  <option value="1">Change</option>
                </select>
                <div id="type-of-approval-error-msg-div"></div>
              </div> 
                <div class="col-sm-6">
                   <label class="product-details-span-light">Client Name</label>
                   <!-- <input type="text" class="form-control" name="user-name" id="user-name">  -->
                   <select class="form-control" id="user-name" name="user-name">
                     <option value="">Select Client</option>
                     <?php 
                      foreach ($client as $key => $value) {
                        echo "<option data-master='{$value['is_master']}' value='{$value['client_id']}'>{$value['client_name']}</option>";
                      }
                      ?>
                   </select>
                   <div id="user-name-error-msg-div"></div>
                 </div>
                 <div class="col-md-6">
                   <label>Package</label>
                   <select class="form-control" id="package_id"></select>
                    <div id="package_id-error-msg-div"></div>
                 </div>

                 
               <div class="col-md-6 mt-4" id="client-type">
                <input type="radio" class="mt-3 radio-client" name="radio-client" value="master">Master Account 
                <input type="radio" class="mt-3 radio-client" id="radio-client" name="radio-client" value="child">Child Account 
              </div>
              <div class="col-md-12">
                <label class="product-details-span-light">Remarks</label>
                <!-- ckeditor -->
                <!-- <textarea class="fld" name="ticket_description" id="ticket_description" placeholder="Remarks"></textarea> -->
                <select class="fld" name="ticket_description" id="ticket_description"></select>
                <div id="ticket-description-error-msg-div"></div>
              </div>
              <div class="col-md-12" id="additionals" style="display:none;">
                 <label class="product-details-span-light">Additional Remarks</label>
                 <textarea class="fld" name="additional_remarks" id="additional_remarks" placeholder="Additional Remarks"></textarea>
              </div>

              <div class="col-md-12">
                <label>Components / Skills</label>
                <div class="row" id="view-all-packages"> </div>
                 <div id="component-error-msg-div"></div>
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
<script src="<?php echo base_url() ?>assets/custom-js/csm/approval/approval-price.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/custom-js/csm/approval/all-approvals.js"></script> -->