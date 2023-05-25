 
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt">
      <div class="row">
        <div class="col-md-6">
          <h3 class="mt-3">Client Reminders</h3>
        </div>
        <div class="col-md-6">
          <div class="sbt-btns">
            <a href="javascript:void(0)" id="add-new-rule-modal-btn" class="btn bg-blu btn-submit-cancel">Add New Reminder</a>
          </div>
        </div>
      </div>
        <div class="table-responsive mt-3" id="">
          <table class="table-fixed  datatable table table-striped">
            <thead class="table-fixed-thead thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Reminder&nbsp;Name</th>  
                <th>Created&nbsp;Date</th>  
                <th>Status</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody class="table-fixed-tbody tbody-datatable" id="get-rules-list"></tbody>
          </table>
        </div>
        <!--View Client Content-->
     </div>
  </div>
</section>
<!--Content-->

<!-- Add New Rule Modal Starts -->
  <div class="modal fade" id="add-new-rule-modal">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Add New Reminder</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row">
              <div class="col-md-12">
                <span class="product-details-span-light">Reminder Name</span>
                <input type="text" class="form-control" id="notification-name" placeholder="Reminder Name">
                <div id="notification-name-error-msg-div"></div>
              </div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Email Subject</span>
                <textarea class="form-control" id="email-subject" placeholder="Email Subject" rows="2"></textarea>
                <div id="email-subject-error-msg-div"></div>
              </div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Email Description</span>
                <textarea class="form-control" id="email-description" rows="4" placeholder="Email Description"></textarea>
                <div id="email-description-error-msg-div"></div>
              </div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Select Rule</span>
                <select class="form-control" id="case-type"></select>
                <div id="case-type-error-msg-div"></div>
              </div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Select Rule Criteria</span>
                <select class="form-control" id="rule-cirteria"></select>
                <div id="case-type-error-msg-div"></div>
              </div>
              <div class="col-md-12 mt-3" id="add-new-rule-details-div"></div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Select Client Type</span>
                <select class="form-control" id="client-type"></select>
                <div id="client-type-error-msg-div"></div>
              </div>
              <div class="col-sm-12 mt-3">
                <span class="product-details-span-light">Select Client</span>
                <select class="form-control" id="client-name" multiple></select>
                <div id="client-name-error-msg-div"></div>
              </div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Add Time</span>
                <button id="sms-add-time" class="btn btn-success btn-sm ml-4"><i class="fa fa-plus"></i></button>
                <div id="schedule-time-div"></div>
              </div>
              <div class="col-md-12" id="add-new-rule-error-msg-div"></div>
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-new-rule-btn" name="add-new-rule-btn">Save</button>
        </div>
      </div>
    </div>
  </div>
<!-- Add New Rule Modal Ends -->

<!-- Edit Rule Modal Starts -->
  <div class="modal fade" id="edit-rule-modal">
    <div class="modal-dialog modal-xs modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Edit Reminder</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row">
              <div class="col-md-12">
                <span class="product-details-span-light">Reminder Name</span>
                <input type="text" class="form-control" id="edit-notification-name" placeholder="Reminder Name">
                <div id="edit-notification-name-error-msg-div"></div>
              </div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Email Subject</span>
                <textarea class="form-control" id="edit-email-subject" placeholder="Email Subject" rows="2"></textarea>
                <div id="edit-email-subject-error-msg-div"></div>
              </div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Email Description</span>
                <textarea class="form-control" id="edit-email-description" rows="4" placeholder="Email Description"></textarea>
                <div id="edit-email-description-error-msg-div"></div>
              </div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Select Rule</span>
                <select class="form-control" id="edit-case-type"></select>
                <div id="edit-case-type-error-msg-div"></div>
              </div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Select Rule Criteria</span>
                <select class="form-control" id="edit-rule-cirteria"></select>
                <div id="case-type-error-msg-div"></div>
              </div>
              <div class="col-md-12 mt-3" id="edit-rule-details-div"></div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Select Client Type</span>
                <select class="form-control" id="edit-client-type"></select>
                <div id="edit-client-type-error-msg-div"></div>
              </div>
              <div class="col-sm-12 mt-3">
                <span class="product-details-span-light">Select Client</span>
                <select class="form-control" id="edit-client-name" multiple></select>
                <div id="edit-client-name-error-msg-div"></div>
              </div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Add Time</span>
                <button id="edit-sms-add-time" class="btn btn-success btn-sm ml-4"><i class="fa fa-plus"></i></button>
                <div id="edit-schedule-time-div"></div>
              </div>
              <div class="col-md-12" id="add-new-rule-error-msg-div"></div>
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="edit-rule-btn" name="edit-rule-btn">Save</button>
        </div>
      </div>
    </div>
  </div>
<!-- Edit Rule Modal Ends -->

<script>
  var clock_type = '<?php echo $date_time_picker_type['clock_type'];?>',
      time_12_24_hr_format = '<?php echo $date_time_picker_type['12_24_hr_format'];?>';
</script>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/client-notification/add.js"></script> 
<script src="<?php echo base_url(); ?>assets/custom-js/admin/client-notification/all.js"></script>