<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div id="FS-candidate-mn" class="add-team">
        <ul class="nav nav-tabs nav-justified">
            
           <li class="nav-item">
              <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').'component'; ?>">Component</a>
           </li>
           <li class="nav-item">
              <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'package'; ?>">Package</a>
           </li>
           <li class="nav-item d-none">
              <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'factsuite-admin/factsuite-alacarte'; ?>">Alacarte</a>
           </li>
            
        </ul>
      </div>
    </div>
  </div>
</section>
<section id="pg-cntr">
  <div class="pg-hdr">
     <!--Nav Tabs-->
     <!--  <div id="FS-candidate-mn" class="add-team">
        <ul class="nav nav-tabs nav-justified">
            
           <li class="nav-item">
              <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').'component'; ?>">Component</a>
           </li>
           <li class="nav-item">
              <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'package'; ?>">Package</a>
           </li>
           <li class="nav-item">
              <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'factsuite-admin/factsuite-alacarte'; ?>">Alacarte</a>
           </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'role'; ?>">Role</a>
           </li>
        </ul>
      </div> -->
     <!--Nav Tabs-->
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt">
         <h3>Component Details</h3>
        <div class="sbt-btns">
          <a href="#" id="team-submit-btn" data-toggle="modal" data-target="#add_component"class="btn bg-blu btn-submit-cancel d-none">ADD&nbsp;COMPONENT</a>
        </div>
        <div class="table-responsive mt-3" id="">
          <table class="table-fixed datatable1 table table-striped">
            <thead class="table-fixed-thead thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Component&nbsp;Name</th> 
                <th>Standard&nbsp;Price</th>  
                <th>Form&nbsp;Threshold</th>  
                <th>Component&nbsp;Status</th>  
                <th class="d-none">Edit</th>  
              </tr>
            </thead>
            <tbody class="table-fixed-tbody tbody-datatable" id="get-team-data"> 
            </tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>

  <!-- Add COMPONENT Modal Starts -->
  <div class="modal fade" id="add_component">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">ADD&nbsp;COMPONENT</h4> 
        </div>
        <input type="hidden" name="edit_component_id" id="edit_component_id">
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2">
               
              <div class="col-sm-4">
                <label class="product-details-span-light">Component Name</label>
                <input type="text" class="fld" name="component_name" id="component_name" placeholder="Enter Component Name">
                <div id="component-name-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-3">
                <label class="product-details-span-light">Component Price</label>
                <input type="number" class="fld" name="component_price" id="component_price" placeholder="Enter Component Price">
                <div id="component-price-error-msg-div"></div>  
              </div>
            </div>
            
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-blu btn-close text-white" id="edit-component-close-btn" name="add-component-close-btn" data-dismiss="modal">Close</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-component-btn" name="edit-component-close-btn" onclick="saveData()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;COMPONENT</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add COMPONENT Modal Ends -->


  <!-- Edit COMPONENT Modal Starts -->
   <div class="modal fade" id="edit_component">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">EDIT&nbsp;COMPONENT</h4> 
        </div>
        <input type="hidden" name="edit_component_id" id="edit_component_id">
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2">
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Component Name</label>
                <input type="text" class="fld" readonly="" name="edit_component_name" id="edit_component_name" placeholder="Enter Component Name">
                <div id="edit-component-name-error-msg-div"></div>  
              </div>

              <div class="col-sm-6">
                <label class="product-details-span-light">FS Website Component Name</label>
                <input type="text" class="fld" name="edit_fs_website_component_name" id="edit_fs_website_component_name" placeholder="Enter Component Name">
                <div id="edit-fs-website-component-name-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-3 mt-3">
                <label class="product-details-span-light">Standard Price</label>
                <input type="number" class="fld" name="edit_component_price" id="edit_component_price" placeholder="Enter Component Price">
                <div id="edit-component-price-error-msg-div"></div>  
              </div>

              <div class="col-sm-4 mt-3">
                <label class="product-details-span-light">Form Threshold</label>
                <input type="number" class="fld" name="edit_component_form_threshold" id="edit_component_form_threshold" placeholder="Enter Component Form Threshold">
                <div id="edit-component-form-threshold-error-msg-div"></div>  
              </div>

              <div class="col-sm-12 mt-3">
                <label class="product-details-span-light">Component Short Description</label>
                <textarea class="fld ckeditor" name="edit_component_short_description" id="edit_component_short_description" placeholder="Short Description"></textarea>
                <div id="edit-component-short-description-error-msg-div"></div>  
              </div>

              <div class="col-md-6 mt-3">
                <div class="add-vendor-bx2">
                  <label>Component Icon</label>
                  <div class="form-group mb-0">
                    <input type="file" id="component-icon" name="component-icon">
                    <label class="btn upload-btn" for="component-icon">Upload</label>
                  </div>
                  <div id="component-icon-error-msg-div"></div>
                </div>
              </div>

            </div>
            
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-blu btn-close text-white" id="edit-component-close-btn" name="add-component-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-component-btn" name="edit-component-close-btn" onclick="updateData()">Update</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;COMPONENT</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Coupon Modal Ends -->

</section>
<!--Content-->

  <div class="modal fade" id="view-component-image-modal" role="dialog">
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
<script type="text/javascript">
  var show_component_name = "<?php echo $this->config->item('show_component_name'); ?>";
</script>
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/component/view-component.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/admin/common-validations.js"></script>