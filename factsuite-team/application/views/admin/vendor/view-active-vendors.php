        <div class="tab-content">
          <div class="table-responsive mt-4">
            <table class="datatable table table-striped">
              <thead class="thead-bd-color">
                <tr>
                  <th>Sr No.</th>
                  <th>Vendor Name</th>
                  <th>Email Id</th>
                  <th>Mobile No</th>
                  <th>Manager Name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="tbody-datatable" id="get-active-vendor-list"></tbody>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Edit Vendor Modal Starts -->
  <div class="modal fade" id="edit_vendor_details_module">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0">
          <input type="hidden" name="edit_sector_id" id="edit_sector_id">
          <h4 class="modal-title-edit-coupon">Update Vendor Details</h4>
        </div>
        <div class="modal-body">
          <div class="add-vendor-bx">
           <h3>Basic Vendor Details</h3>
           <input type="hidden" class="fld form-control" id="edit-vendor-id" name="edit-vendor-id">
           <ul>
              <li>
                 <label>Name</label>
                 <input type="text" class="fld form-control" id="vendor-name" name="vendor-name">
                 <div id="vendor-name-error-msg-div">&nbsp;</div>
              </li>
              <li>
                 <label>Address Line1</label>
                 <input type="text" class="fld form-control" id="vendor-address-line-1" name="vendor-address-line-1">
                 <div id="vendor-address-line-1-error-msg-div">&nbsp;</div>
              </li>
              <li>
                 <label>Address Line2</label>
                 <input type="text" class="fld form-control" id="vendor-address-line-2" name="vendor-address-line-2">
                 <div id="vendor-address-line-2-error-msg-div">&nbsp;</div>
              </li>
              <li>
                 <label>City</label>
                 <input type="text" class="fld form-control" id="vendor-city" name="vendor-city">
                 <div id="vendor-city-error-msg-div">&nbsp;</div>
              </li>
              <li>
                 <label>Zip</label>
                 <input type="text" class="fld form-control" id="vendor-zip-code" name="vendor-zip-code">
                 <div id="vendor-zip-code-error-msg-div">&nbsp;</div>
              </li>
              <li>
                 <label>State</label>
                 <select class="fld form-control" id="vendor-state" name="vendor-state"></select>
                 <div id="vendor-state-error-msg-div">&nbsp;</div>
              </li>
              <li>
                 <label>Website</label>
                 <input type="text" class="fld form-control" id="vendor-website" name="vendor-website">
                 <div id="vendor-website-error-msg-div">&nbsp;</div>
              </li>
              <li>
                 <label>Monthly Quota</label>
                 <input type="text" class="fld form-control" id="vendor-monthly-quota" name="vendor-monthly-quota">
                 <div id="vendor-monthly-quota-error-msg-div">&nbsp;</div>
              </li>
           </ul>
           </div>
           <div class="row">
              <div class="col-md-4">
                 <div class="add-vendor-bx2">
                    <h3>Agreement Start Date</h3>
                    <ul>
                       <li class="vendor-wdt2 aggrement-start-date-li">
                          <input type="text" class="fld form-control date-for-vendor-aggreement-start-date" id="vendor-aggrement-start-date" name="vendor-aggrement-start-date">
                          <div id="vendor-aggrement-start-date-error-msg-div">&nbsp;</div>
                       </li>
                    </ul>
                 </div>
              </div>
              <div class="col-md-4">
                 <div class="add-vendor-bx2">
                    <h3>Agreement End Date</h3>
                    <ul>
                       <li class="vendor-wdt1 aggrement-end-date-li">
                          <input type="text" class="fld form-control date-for-vendor-aggreement-end-date" id="vendor-aggrement-end-date" name="vendor-aggrement-end-date" disabled>
                          <div id="vendor-aggrement-end-date-error-msg-div">&nbsp;</div>
                       </li>
                    </ul>
                 </div>
              </div>
              <div class="col-md-4">
                 <div class="add-vendor-bx2">
                    <h3 class="m-0">&nbsp;</h3>
                    <ul>
                       <li class="vendor-wdt2">
                          <label>Upload document</label>
                          <div class="form-group mb-0">
                            <input type="file" id="vendor-documents" name="vendor-documents" multiple="multiple">
                            <label class="btn upload-btn" for="vendor-documents">Upload</label>
                          </div>
                          <div id="vendor-upoad-docs-error-msg-div">&nbsp;</div>
                       </li>
                      <!--  <li class="vendor-wdt2">
                          <label>TAT</label>
                          <input type="text" class="fld3 form-control" id="vendor-tat" name="vendor-tat">
                          <div id="vendor-tat-error-msg-div">&nbsp;</div>
                       </li> -->
                    </ul>
                    <ul>
                      <li class="w-100">
                         <div class="row" id="selected-vendor-docs-li"></div>
                       </li>
                    </ul>
                 </div>
              </div>
           </div>
           <div class="add-vendor-bx">
           <h3>Edit manager details</h3>
           <ul>
              <li class="input-li-1">
                 <label>Name</label>
                 <select class="fld" id="vendor-manager-name" name="vendor-manager-name"></select>
                 <div id="vendor-manager-name-error-msg-div">&nbsp;</div>
              </li>
              <li class="input-li-1">
                 <label>Email</label>
                 <input type="email" class="fld form-control" id="vendor-manager-email-id" name="vendor-manager-email-id" disabled>
                 <div id="vendor-manager-email-id-error-msg-div">&nbsp;</div>
              </li>
              <li class="input-li-1">
                 <label>Phone Number</label>
                 <input type="text" class="fld form-control" id="vendor-manager-mobile-number" name="vendor-manager-mobile-number" disabled>
                 <div id="vendor-manager-mobile-number-error-msg-div">&nbsp;</div>
              </li>
           </ul>
           </div>
           <div class="add-vendor-bx">
           <h3>Edit spoc details</h3>
           <ul>
              <li class="input-li-1">
                 <label>Name</label>
                 <input type="text" class="fld form-control" id="vendor-spoc-name" name="vendor-spoc-name">
                 <div id="vendor-spoc-name-error-msg-div">&nbsp;</div>
              </li>
              <li class="input-li-1">
                 <label>Email</label>
                 <input type="email" class="fld form-control" id="vendor-spoc-email-id" name="vendor-spoc-email-id">
                 <div id="vendor-spoc-email-id-error-msg-div">&nbsp;</div>
              </li>
              <li class="input-li-1">
                 <label>Phone Number</label>
                 <input type="text" class="fld form-control" id="vendor-spoc-mobile-number" name="vendor-spoc-mobile-number">
                 <div id="vendor-spoc-mobile-number-error-msg-div">&nbsp;</div>
              </li>
           </ul>
           </div>
            <div class="add-team-bx">
              <h3>Skill</h3>
              <ul id="vendor-skills-list"></ul>
              <div id="vendor-skill-error-msg-div"></div>
            </div>
          <div class="text-center" id="edit-vendor-main-error-msg-div"></div>
          <div class="row mt-3">
            <div class="col-sm-12 text-right sbt-btns">
              <button class="btn bg-gry btn-submit-cancel ml-2" id="cancel-edit-btn" name="cancel-edit-btn" data-dismiss="modal">Cancel</button>
              <button class="btn bg-blu btn-submit-cancel mt-0" id="edit-vendor-btn" name="edit-vendor-btn">Save</button>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0">
        </div>
      </div>
    </div>
  </div>
<!-- Edit Vendor Modal Ends -->

<!-- Delete Vendor Docs Modal Starts -->
  <div class="modal fade" id="delete-vendor-docs-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit-category">
        <div class="modal-header border-0">
          <h4 class="modal-title-edit-coupon text-danger font-weight-bold">Delete Vendor Docs?</h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row">
            <div class="col-md-7">
              <span>Are You sure you want to delete the vendor doc?</span>
              <input type="hidden" name="delete-vendor" id="delete-vendor">
              <input type="hidden" name="delete-vendor-doc-name" id="delete-vendor-doc-name">
              <input type="hidden" name="delete-product-image-name" id="delete-id">
            </div>
            <div class="col-md-12 text-right sbt-btns">
              <button class="btn bg-gry btn-submit-cancel ml-2" data-dismiss="modal">Cancel</button>
              <button class="btn bg-blu btn-submit-cancel text-white mt-0" name="delete-vendor-doc-btn" id="delete-vendor-doc-btn">Delete</button>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0"></div>
      </div>
    </div>
  </div>
<!-- Delete Vendor Docs Modal Modal Ends -->

<script>
  var active_type = 1;
</script>
<script src="<?php echo base_url();?>assets/custom-js/common/valid-invalid-input.js"></script>
<script src="<?php echo base_url();?>assets/custom-js/admin/vendor/get-active-vendor.js"></script>
<script src="<?php echo base_url();?>assets/custom-js/admin/vendor/get-single-vendor-details.js"></script>
<script src="<?php echo base_url();?>assets/custom-js/admin/vendor/edit-vendor.js"></script>