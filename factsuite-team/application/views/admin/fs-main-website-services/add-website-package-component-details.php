<?php extract($_GET); ?>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt pt-3">
        <div class="add-client-bx">
           <h3>Package Details</h3>
           <div class="card">
           	<div class="row m-2">
                <div class="col-md-6">
                    <label>Service Name : </label>
                    <label><?php echo $package_details['service_name']['name'];?></label>
                </div>
                <div class="col-md-6">
                    <label>Package Name : </label>
                    <label><?php echo $package_details['package_details']['name'];?></label>
                </div>
                <div class="col-md-6 mt-3">
                    <label>Package Type : </label>
                    <label><?php echo $package_details['package_details']['package_type'];?></label>
                </div>
           		<div class="col-md-6 mt-3">
           		    <label>Select Component : </label>
                    <select class="form-control fld auto-width" id="component-selected" >
                        <option value="">Select Component</option>
                        <?php foreach ($package_details['selected_package_component_list'] as $key => $value) { ?>
                            <option value="<?php echo $value['component_id']?>"><?php echo $value['component_name']?></option>
                        <?php } ?>
                    </select>
           		</div>
           	</div> 
           </div>
           <div id="display-component-details"></div>

      
         <div class="text-center" id="package-component-error"></div>  
        <div class="sbt-btns">
           <a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">CANCEL</a>
           <button id="client-save-packages-component-btn" class="btn bg-blu btn-submit-cancel">
            SAVE 
            <?php if ($package_details['package_selected_component_and_alacarte_list']['package_alacarte_components'] != '') { ?>
                &amp; NEXT
            <?php } ?>
            </button>
        </div>
        <!--Add Client Content-->
     </div>
  </div>
</section>
<!--Content-->

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

 
  <!--  -->
   <div class="modal fade" id="view-component-data" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Package Components</h4>
        </div>
        <div class="modal-body">
         <div class="row" id="view-all-component">
         
         </div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
              
           	<button id="add-all-package-data" class="btn bg-blu btn-submit-cancel text-white">submit</button>
           		 
           </div>
        </div>
      </div>
    </div>
  </div>
 
<script>
  var package_id = '<?php echo $package_details['package_details']['package_id']; ?>';
  var selected_component_list = '<?php echo $package_details['package_selected_component_and_alacarte_list']['package_components'];?>';
  var selected_alacarte_component_list = '<?php echo $package_details['package_selected_component_and_alacarte_list']['package_alacarte_components'];?>';
  var get_package_type = '<?php echo $package_type; ?>';
  var get_package_name = '<?php echo $package_name; ?>';
  var get_enc_package_id = '<?php echo $package_id; ?>';
</script>
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/common-validations.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/admin/factsuite-website/service-package/add-new-package-component-details.js"></script>