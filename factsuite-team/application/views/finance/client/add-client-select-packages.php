
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt pt-3">
        <!--Add Client Content-->
         <div class=""> 
           <a href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-new-client" class="btn bg-blu btn-submit-cancel text-white"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="add-client-bx">
           <!-- <h3>basic client details</h3> -->
           <h4>Configure Packages</h4>
           <div class="card">
           	<div class="row m-2">
           		<div class="col-md-3">
           			<h4>Packages </h4>
           		</div>
           		<div class="col-md-2">
           		<div class="sbt-btns">
           			<button id="add-packages" class="btn bg-blu btn-submit-cancel">Add </button>
           		</div>
           		</div>
           	</div>
           	<div class="row" id="get-packages">
           		
           	</div>
           </div>

           <div class="card mt-4">
           	<div class="row m-2">
           		<div class="col-md-3">
           			<h4>Alacarte </h4>
           		</div>
           		<div class="col-md-2">
           		<div class="sbt-btns">
           			<button id="add-alacarte" class="btn bg-blu btn-submit-cancel">Add </button>
           		</div>
           		</div>
           	</div>
           	<div class="row" id="get-alacarte">
           		
           	</div>
           </div>

           <div class="row" id="package-alacarte-error-msg"> 
           </div>
          
        <div class="sbt-btns">
           <a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">Cancel</a>
           <button id="client-save-package-component-btn" class="btn bg-blu btn-submit-cancel">Save &amp; Next</button>
        </div>
        <!--Add Client Content-->
     </div>
  </div>
</section>
<!--Content-->


  <div class="modal fade" id="view-package-remove-modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content"> 
        <div class="modal-body">
         <h4 class="modal-title">Are you sure remove this package ?</h4>
         <input type="hidden" id="modal-package_id" name="modal-package_id">
        </div>
        <div class="modal-footer border-0">
          <div class="header-mn sbt-btns" id="package-button-area">
            <button class="btn bg-blu btn-submit-cancel" id="package-remove-btn">Confirm</button>
              <a href="" data-dismiss="modal" class="btn bg-gry btn-submit-cancel">Close</a>
           </div>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="view-alacarte-remove-modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content"> 
        <div class="modal-body">
         <h4 class="modal-title">Are you sure remove this alacarte component ?</h4>
         <input type="hidden" id="modal-alacarte_id" name="modal-alacarte_id">
        </div>
        <div class="modal-footer border-0">
          <div class="header-mn sbt-btns" id="alacarte-button-area">
            <button class="btn bg-blu btn-submit-cancel" id="alacarte-remove-btn">Confirm</button>
              <a href="" data-dismiss="modal" class="btn bg-gry btn-submit-cancel">Close</a>
           </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="view-package-data" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Package</h4>
        </div>
          <div class="col-md-4">
          	<label>Enter package name</label>
          	<input type="text" class="form-control" name="package_name" id="add-package_name">
            <div id="package-name-error-msg"></div>
          </div>

        <div class="modal-body">
         <div class="row" id="view-all-packages">
         	<?php
         	if (count($component) > 0) {
              foreach ($component as $key => $comp) {

               $component_name = $comp['component_name'];
                 
 
              if ($comp['component_name'] =='Adverse Media/Media Database Check') {
                   $component_name = 'Adverse Media/Database Check ';
              }
                if ($comp['component_name'] =='Health Checkup Check') {
                   $component_name = 'Health Check ';
              }
                ?>

            <div class="col-md-3 mt-1">
	        <div class="custom-control custom-checkbox custom-control-inline mrg">
			<input type="checkbox" class="custom-control-input package_components" name="package_components" data-component_name="<?php echo $comp['component_name']; ?>" data-form_threshold="<?php echo $comp['form_threshold']; ?>" data-component_standard_price="<?php echo $comp['component_standard_price']; ?>" value="<?php echo $comp['component_id']; ?>" id="customradioeducheckpackage<?php echo $comp['component_id']; ?>">
			<label class="custom-control-label" for="customradioeducheckpackage<?php echo $comp['component_id']; ?>"><?php echo $comp['fs_crm_component_name']; ?> </label>
			</div>
	        </div>

                <?php
              }
            }
         	?>
         </div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
              
           	<button id="add-package-data" class="btn bg-blu btn-submit-cancel text-white">Submit</button>
           		 
           </div>
        </div>
      </div>
    </div>
  </div>




  <div class="modal fade" id="view-alacarte-data" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Alacarte</h4>
        </div> 
        <div class="modal-body">
         <div class="row" id="view-alacarte-components">
         	<?php
         	if (count($component) > 0) {
              foreach ($component as $key => $comp) {
                $component_name = $comp['component_name'];
                 
 
              if ($comp['component_name'] =='Adverse Media/Media Database Check') {
                   $component_name = 'Adverse Media/Database Check ';
              }
                if ($comp['component_name'] =='Health Checkup Check') {
                   $component_name = 'Health Check ';
              }
                ?>

            <div class="col-md-3 mt-1">
	        <div class="custom-control custom-checkbox custom-control-inline mrg">
			<input type="checkbox" class="custom-control-input alacarte_components" name="alacarte_components" data-component_name="<?php echo $comp['component_name']; ?>" data-form_threshold="<?php echo $comp['form_threshold']; ?>" data-component_standard_price="<?php echo $comp['component_standard_price']; ?>" value="<?php echo $comp['component_id']; ?>" id="customradioeduchealacarte<?php echo $comp['component_id']; ?>">
			<label class="custom-control-label" for="customradioeduchealacarte<?php echo $comp['component_id']; ?>"><?php echo $comp['fs_crm_component_name']; ?> </label>
			</div>
	        </div>

                <?php
              }
            }
         	?>
         </div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>

           	<button id="add-alacarte-data" class="btn bg-blu btn-submit-cancel text-white">submit</button>
           		 
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


  <!--  -->
   <div class="modal fade" id="view-component-data" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Package Components</h4>
          <input type="hidden" name="add_package_name" id="added_package_name">
        </div>
         <div class="col-md-4">
            <label>Enter package name</label>
            <input type="text" class="form-control" name="package_name" id="edit_package_name">
            <div id="package-name-error-msg"></div>
          </div>
        <div class="modal-body">
         <div class="row" id="view-all-component">
         <?php
         	if (count($component) > 0) {
              foreach ($component as $key => $comp) {

                $component_name = $comp['component_name'];
                 
 
              if ($comp['component_name'] =='Adverse Media/Media Database Check') {
                   $component_name = 'Adverse Media/Database Check ';
              }
                if ($comp['component_name'] =='Health Checkup Check') {
                   $component_name = 'Health Check ';
              }
                ?>

            <div class="col-md-3 mt-1">
	        <div class="custom-control custom-checkbox custom-control-inline mrg">
			<input type="checkbox" class="custom-control-input package_component_ids" name="package_components" data-component_name="<?php echo $comp['component_name']; ?>" data-form_threshold="<?php echo $comp['form_threshold']; ?>" data-component_standard_price="<?php echo $comp['component_standard_price']; ?>" value="<?php echo $comp['component_id']; ?>" id="package_component_ids<?php echo $comp['component_id']; ?>">
			<label class="custom-control-label" for="package_component_ids<?php echo $comp['component_id']; ?>"><?php echo $component_name; ?> </label>
			</div>
	        </div>

            <?php
              }
            }
         	?>
         </div>
         <div id="package-component-error"></div>
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

 <!--  -->
   <div class="modal fade" id="view-alacarte-component" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Alacarte Components</h4>
        </div>
        <div class="modal-body">
         <div class="row" id="view-all-alacarte">
         
         </div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
              
           	<button id="add-all-alacarte-data" class="btn bg-blu btn-submit-cancel text-white">Submit</button>
           		 
           </div>
        </div>
      </div>
    </div>
  </div>


<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/client/add-client.js"></script>