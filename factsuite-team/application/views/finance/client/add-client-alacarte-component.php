
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt pt-3">
        <!--Add Client Content-->
         <div class=""> 
           <a href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/add-client-component-packages" class="btn bg-blu btn-submit-cancel text-white"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="add-client-bx">
           <!-- <h3>basic client details</h3> -->
           <h4>Alacarte</h4>
           <div class="card">
           	<div class="row m-2">
           		<!-- <div class="col-md-6">
           			<h4>Alacarte <small>(Add Alacarte)</small></h4>
                  <select class="form-control fld auto-width" id="component-alacarte" >
                    <option value="">Select Alacarte</option>
                    <?php
                    if (count($alacarte) > 0) {
                      foreach ($alacarte as $key => $alac) {
                        echo "<option value='{$alac['alacarte_id']}'>{$alac['alacarte_name']}</option>";
                      }
                    }
                    ?>
                 </select>
                  <div id="component-alacarte-error">&nbsp;</div>
           		</div> -->
           		<div class="col-md-6">
           		 <h4>Alacarte Component <small>(Add Component)</small></h4>
               <select class="form-control fld auto-width" id="alacarte-component-details" >
                    <option value="">Select Component</option>
                    
                 </select>
           		</div>
           	</div> 
           </div>
           <div id="display-alacarte-component-details">
             
           </div>

       <div id="package-component-error"></div>
        </div>
          
        <div class="sbt-btns">
           <a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">CANCEL</a>
           <button  id="client-save-alacarte-component-btn" class="btn bg-blu btn-submit-cancel">SAVE &amp; NEXT</button>
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
          <h4 class="modal-title">alacarte Components</h4>
        </div>
        <div class="modal-body">
         <div class="row" id="view-all-alacarte-component">
         
         </div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
              
           	<button id="add-all-alacarte-data" class="btn bg-blu btn-submit-cancel text-white">submit</button>
           		 
           </div>
        </div>
      </div>
    </div>
  </div>
 

<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/client/add-client.js"></script>