<div class="pg-cnt">
   <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
      <h3>Email Templates</h3>
      <div class="row">
         <div class="col-md-4">
            <label>Select Your Template</label>
            <select class="fld form-control" id="templates">
               <option value="">Select Your Template</option>
            </select>             
            <div id="select-templates-error">&nbsp;</div>                          
         </div>  

         <div class="col-md-4" id="client-template-div">
            <label>Select Your Client</label>
            <select class="fld form-control" id="client_id">
               <option value="">Select Your Client</option>
               <option value="0">ALL</option>
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

      </div>
      <div class="row"> 
         <div class="col-md-10">
            <label class="product-details-span-light">Email Form</label>
            <textarea class="fld" name="email-form" id="email-form" placeholder="Email Template"></textarea>
            <span class="d-block mt-3">Note: Below displayed list is just for the reference of different kind of fields available that can be added in the email template. please use "@" symbol in the input field above that will popup the list of below fields and select the required one.</span>
            <div id="form-field-details" class="row my-3"></div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-10 text-right">
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
 
<script src="<?php echo base_url(); ?>assets/custom-js/admin/templates/add-templates.js"></script>