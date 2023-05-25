
        <h3>Escalatory Notifications Settings</h3>
        <div class="sbt-btns">
          <a href="javascript:void(0)" id="add-new-rule-modal-btn" class="btn bg-blu btn-submit-cancel">Add Rule</a>
        </div>
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Rule&nbsp;Criteria</th>  
                <th>Created&nbsp;Date</th>  
                <th>Status</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-rules-list"></tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>

  <!-- Add New Rule Modal Starts -->
  <div class="modal fade" id="add-new-rule-modal">
    <div class="modal-dialog modal-xs modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Add New Rule</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row">
              <div class="col-sm-12">
                <label class="product-details-span-light">Select Client</label>
                <select class="form-control" id="client-name" multiple></select>
                <div id="client-name-error-msg-div"></div>
              </div>
              <div class="col-md-12">
                <label class="product-details-span-light">Select Rule Criteria</label>
                <select class="form-control" id="rule-cirteria"></select>
                <div id="rule-cirteria-error-msg-div"></div>
              </div>
              <div class="col-md-12" id="add-new-rule-details-div"></div>
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
          <h4 class="modal-title-edit-coupon-1">Edit Rule</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row">
              <div class="col-sm-12">
                <label class="product-details-span-light">Select Client</label>
                <select class="form-control" id="edit-client-name" multiple></select>
                <div id="edit-client-name-error-msg-div"></div>
              </div>
              <div class="col-md-12">
                <label class="product-details-span-light">Select Rule Criteria</label>
                <select class="form-control" id="edit-rule-cirteria"></select>
                <div id="edit-rule-cirteria-error-msg-div"></div>
              </div>
              <div class="col-md-12" id="edit-rule-details-div"></div>
              <div class="col-md-12" id="edit-rule-error-msg-div"></div>
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

</section>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/priority-rule/add.js"></script> 
<script src="<?php echo base_url(); ?>assets/custom-js/admin/priority-rule/all.js"></script>