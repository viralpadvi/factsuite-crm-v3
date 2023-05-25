<div class="pg-cnt">
   <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
      <h3>URL Branding</h3>
      <div class="row">
         <div class="col-md-4">
            <label>Select URL Type</label>
            <select class="fld form-control" id="templates" onchange="getTatData(this.value)">
               <option value="">Select URL Type</option>
               <option value="Initiate Case">Initiate Case</option> 
            </select>             
            <div id="select-templates-error">&nbsp;</div>                          
         </div>  

         <div class="col-md-4">
            <label>Select Your Client</label>
            <select class="fld form-control" id="client_id" onchange="getTatData(this.value)">
               <option value="">Select Your Client</option>
               <?php 

                  foreach ($clientInfo as $key => $value) {
                     $select = '';
                     if (isset($_GET['client_id'])) {
                        if ($_GET['client_id'] == $value['client_id']) { 
                       $select = 'selected';
                        }
                     }
                     echo '<option '.$select.' value="'.$value['client_id'].'">'.$value['client_name'].'</option>';
                  }
               ?>
               
            </select>             
            <div id="select-client-error">&nbsp;</div>                          
         </div> 
         <div class="col-md-8">
               <label class="product-details-span-light">URL</label>
                 
                <input type="text" class="fld form-control" name="url" id="url" placeholder="Add Url">
           </div>
      </div>
      <div class="row"> 
         
           
           
      </div>
      <div class="row">
         <div class="col-md-8 text-right">
            <div class="sbt-btns" id="form-button-area">
               <input type="hidden" min="0" max="365"class="form-control fld clietn_id" id="clietn-id" name="clietn-id">
               <a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">CANCEL</a> 
               <button onclick="confirmationDailg()" id="client-submit-btn" class="btn bg-blu btn-submit-cancel">SAVE</button>
            </div>
         </div>
      </div>
   </div>
</div>
</section>

 <div class="modal fade" id="myModal-show" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
        <div class="modal-header border-0">
          <h3 class="text-white" id="">View Document</h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2"> 
            <div class="col-md-3"></div>
            <div class="col-sm-6">
              <!-- <span>Sector Thumbnail Image: </span> -->
              <!-- <img class="w-100" id="view-image"> -->
              <div class="w-100" id="view-img"></div>
            </div> 
          </div>
          <div class="row p-5 mt-2">
               
              <div id="view-edit-cancel-btn-div" class="col-md-12  text-right float-right">
                <button class="btn bg-blu text-white float-right" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
        <!-- <div class="modal-footer border-0"></div> -->
      </div>
    </div>
</div>

 
<script src="<?php echo base_url(); ?>assets/custom-js/admin/templates/add-url-branding.js"></script>