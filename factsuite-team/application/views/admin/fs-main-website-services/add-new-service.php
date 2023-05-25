
   <div class="pg-cnt">
      <div id="FS-candidate-cnt">
         <div class="add-client-bx pt-4 mt-3">
            <ul>
               <li class="w-50">
                  <label>Service Name</label>
                  <input type="text" class="form-control fld" id="service-name" name="service-name">
                  <div id="service-name-error-msg-div"></div>
               </li>
               <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" value="1" name="is-self-check-available" id="is-self-check-available">
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
                  <?php foreach($components as $key => $value) { ?>
                   <div class="col-md-4">
                      <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input checked-components" value="<?php echo $value['component_id'];?>" name="component-name[]" id="component-<?php echo $value['component_id'];?>">
                        <label class="custom-control-label" for="component-<?php echo $value['component_id'];?>"><?php echo $value['component_name'];?></label> 
                      </div>
                    </div>
                  <?php } ?>
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
            </ul>
            <div class="row">
              <div class="col-md-12 text-center" id="new-service-error-msg-div"></div>
            </div>
         <div class="sbt-btns" id="form-button-area">
            <button id="service-submit-btn" class="btn bg-blu btn-submit-cancel">SAVE</button>
         </div>
      </div>
   </div>
</section>
<!--Content-->


  <div class="modal fade" id="myModal-show" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
        </div>
        <div class="modal-body">
         <div id="view-img"></div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
           </div>
        </div>
      </div>
    </div>
  </div>



   <div class="modal fade" id="cancel-form-modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
        </div>
        <div class="modal-body">
        <h4> Are you sure want to cancel this form ?</h4>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
               <a href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/view-all-client" id="add-all-alacarte-data" class="btn bg-blu btn-submit-cancel text-white">submit</a>
           </div>
        </div>
      </div>
    </div>
  </div>

<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/factsuite-website/services/add-new-service.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/admin/common-validations.js"></script>