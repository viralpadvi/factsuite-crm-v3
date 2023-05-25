
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt pt-3">
        <!--Add Client Content-->
         <div class=""> 
           <a href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-new-client-select-packages" class="btn bg-blu btn-submit-cancel text-white"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="add-client-bx">
           <!-- <h3>basic client details</h3> -->
           <h4>Package</h4>
           <div class="card">
           	<div class="row m-2">
           		<div class="col-md-6">
           			<h4>Packages <small>(Add Packages)</small></h4>
                  <select class="form-control fld auto-width" id="component-package" >
                    <option value="">Select Package</option>
                    <?php
                    if (count($package) > 0) {
                      foreach ($package as $key => $pack) {
                        echo "<option value='{$pack['package_id']}'>{$pack['package_name']}</option>";
                      }
                    }
                    ?>
                 </select>
                  <div id="component-package-error">&nbsp;</div>
           		</div>
           		<div class="col-md-6">
           		 <h4>Package Component <small>(Add Component)</small></h4>
               <select class="form-control fld auto-width" id="component-details" >
                    <option value="">Select Component</option>
                    
                 </select>
           		</div>
           	</div> 
           </div>
           <div id="display-component-details">
             
           </div>

      
           <div id="package-component-error"></div>
        </div>
        <div class="sbt-btns">
           <a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">CANCEL</a>
           <button  id="client-save-packages-component-btn" class="btn bg-blu btn-submit-cancel">SAVE &amp; NEXT</button>
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
 

<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/client/add-client.js"></script> 