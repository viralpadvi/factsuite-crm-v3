
   <div class="pg-cnt">
      <div id="FS-candidate-cnt">
         <div class="row pt-4 mt-3" id="all-services-list"></div>
         <div class="row mt-3">
           <div class="col-md-12 text-right">
             <button id="update-service-sort-btn" class="btn bg-blu btn-submit-cancel text-white">Update</button>
           </div>
         </div>
      </div>
   </div>
</section>
<!--Content-->

  <div class="modal fade" id="edit-service-modal" role="dialog">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Service</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="modal-edit-service-id" name="modal-edit-service-id">
          <div class="add-client-bx">
            <ul>
             <li class="w-50">
                <label>Service Name</label>
                <input type="text" class="form-control fld" id="service-name" name="service-name">
                <div id="service-name-error-msg-div"></div>
             </li>
             <li>
               <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" class="custom-control-input" name="is-self-check-available" id="is-self-check-available">
                  <label class="custom-control-label" for="is-self-check-available">Self Check Available</label> 
               </div>
             </li>
             <li class="w-100">
                <label>Very Short Description</label>
                <textarea class="form-control fld ckeditor" id="very_short_description" name="very_short_description"></textarea>
                <div id="very-short-description-error-msg-div"></div>
             </li>
             <li class="w-100">
                <label>Short Description</label>
                <textarea class="form-control fld ckeditor" id="short_description" name="short_description"></textarea>
                <div id="short-description-error-msg-div"></div>
             </li>
             <li class="w-100">
                <label>Long Description</label>
                <textarea class="form-control fld ckeditor" id="long_description" name="long_description"></textarea>
                <div id="long-description-error-msg-div"></div>
             </li>
             <li class="w-100">
                <label>Service Included Description</label>
                <textarea class="form-control fld ckeditor" id="service_included_description" name="service_included_description"></textarea>
                <div id="service-included-description-error-msg-div"></div>
             </li>
             <li class="w-100">
               <div class="row">
                  <div class="col-md-12 mb-2">
                    <label>Select Components</label>
                  </div>
                </div>
                <div class="row" id="components-list-div"></div>
                <div class="row">
                  <div class="col-md-12" id="components-check-error-msg-div"></div>
                </div>
             </li>
             <li>
                <label>Maximum Checks</label>
                <input type="text" class="form-control fld" id="maximum-checks" name="maximum-checks">
                <div id="maximum-checks-error-msg-div">&nbsp;</div>
             </li>
             <li class="file-upload-li">
                <div class="add-vendor-bx2">
                  <label>Thumbnail Image</label>
                  <div class="form-group mb-0">
                    <input type="file" id="thumbnail-image" name="thumbnail-image">
                    <label class="btn upload-btn" for="thumbnail-image">Upload</label>
                  </div>
                  <div id="thumbnail-image-error-msg-div">&nbsp;</div>
                </div>
              </li>
              <li class="file-upload-li">
                <div class="add-vendor-bx2">
                  <label>Banner Image</label>
                  <div class="form-group mb-0">
                    <input type="file" id="banner-image" name="banner-image">
                    <label class="btn upload-btn" for="banner-image">Upload</label>
                  </div>
                  <div id="banner-image-error-msg-div">&nbsp;</div>
                </div>
              </li>
              <li class="file-upload-li">
                <div class="add-vendor-bx2">
                  <label>Service Icon</label>
                  <div class="form-group mb-0">
                    <input type="file" id="service-icon" name="service-icon">
                    <label class="btn upload-btn" for="service-icon">Upload</label>
                  </div>
                  <div id="service-icon-error-msg-div">&nbsp;</div>
                </div>
              </li>
              <li></li>
              <li></li>
              <li></li>
              <li>
                <div class="add-vendor-bx2">
                  <label>Service Benefits</label>
                  <div class="form-group mb-0">
                    <input type="file" id="service-benefits" name="service-benefits" accept=".svg" multiple="multiple">
                    <label class="btn upload-btn" for="service-benefits">Upload</label>
                  </div>
                </div>
              </li>
              <li class="w-100">
                <div class="row" id="service-benefits-error-msg-div"></div>
              </li>
              <li class="w-100">
                <div class="row" id="show-service-benefits-images-ui-div"></div>
              </li>
          </ul>
          <div class="row">
            <div class="col-md-12 text-center" id="update-service-error-msg-div"></div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="javascript:void(0)" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
              <button id="edit-service-btn" class="btn bg-blu btn-submit-cancel text-white">Save</button>
           </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="view-service-images-modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
        </div>
        <div class="modal-body">
          <h4 id="show-img-hdr"></h4>
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <img class="w-100" id="show-image-modal-img">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="javascript:void(0)" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
           </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="delete-service-modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
        </div>
        <div class="modal-body">
        <h4> Are you sure want to delete the "<span id="delete-service-name-hdr-span"></span>"?</h4>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="javascript:void(0)" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
               <button id="delete-service-btn" class="btn bg-blu btn-submit-cancel text-white">Delete</button>
           </div>
        </div>
      </div>
    </div>
  </div>

<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/common-validations.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/admin/factsuite-website/services/all-services.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/admin/factsuite-website/services/update-service.js"></script>