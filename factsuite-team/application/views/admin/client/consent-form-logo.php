<div class="pg-cnt">
   <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
      <h3>Consent Form and Logo</h3>
      <div class="row">
         <div class="col-md-4">
            <label>Select Your Client</label>
            <select class="fld form-control" id="client_id" onchange="getTatData(this.value)">
               <option value="">Select Your Client</option>
               <?php 

                  foreach ($clientInfo as $key => $value) {
                     $select = '';
                     if (isset($_GET['client_id'])) {
                       $select = 'selected';
                     }
                     print '<option '.$select.' value="'.$value['client_id'].'">'.$value['client_name'].'</option>';
                  }
               ?>
               
            </select>             
            <div id="select-client-error">&nbsp;</div>                          
         </div>              
      </div>
      <div class="row">
         <div class="add-vendor-bx2 d-none" id="client-logo-div">
            <ul>
                <li class="vendor-wdt2">
                    <div class="form-group mb-0 col-md-6">
                        <h3 class="m-0">Upload Client Report Logo</h3>
                      <input type="file" id="client-documents" name="client-documents[]" multiple="multiple">
                      <label class="btn upload-btn" for="client-documents">Upload</label>
                    </div>
                    <div id="client-upoad-docs-error-msg-div">&nbsp;</div>
                </li> 
            </ul>   
            <div class="row col-md-4" id="selected-vendor-docs-li"></div>     
        </div>
           <div class="col-md-10">
               <label class="product-details-span-light">Client Consent Form</label>
                <textarea class="fld ckeditor" name="client-consent" id="client-consent" placeholder="Consent Form"></textarea>
                <div id="form-field-details" class="row my-3"></div>
           </div>
           <div class="col-md-10 mt-2">
               
               <div class="custom-control custom-switch pr-2">
                    <input type="checkbox" value="1" class="custom-control-input change_client_additional" id="change_client_additional">
               <label class="custom-control-label" for="change_client_additional"> Additional Documents  </label>
               </div> 
                <textarea class="fld w-100" name="client-additional" id="client-additional" placeholder="Consent Form"></textarea>
           </div>
      </div>

      <div class="row">
               <div class="col-md-5">
                  <label>Location</label>
                  
                  <div class="input-group mb-3">
                     <select class="location form-control" id="location" multiple> 
                     </select> 
               </div> 
               </div> 
               <div class="col-md-5">
                  <label>Segment</label>
                  
                  <div class="input-group mb-3" id="segments-div">
                     <select class="segments form-control" id="segment" multiple> 
                     </select> 
               </div> 
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

<div class="modal fade" id="consent-form" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
         
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2"> 
          <div class="col-md-3"></div> 
        <div class="text-center col-md-4" id="consent-sign"> 
          <div class="col-md-4"></div> 
        </div>
        <div class="border-top"></div>
        <div class="container-fluid text-center">
            <h3 class="consent-hdng">Letter of Authorization</h3>
        </div>
        <div class="container-fluid consent-para-div">
            <p>
               I,"[Candidate]", hereby authorize,"[Client]" and/or its agents (<span class="text-bold">FactSuite</span>) to make an independent investigation of my background, references, past employment, education, credit history, criminal or police records, and motor vehicle records including those maintained by both public and private organizations and all public records for the purpose of confirming the information contained on my Application and/or obtaining other information which may be material to my qualifications for service now and, if applicable, during the tenure of my employment or service with "[Client]"
            </p>
            <p>
                I release "'.$candidate_client_name.'" and its agents and any person or entity, which provides information pursuant to this authorization, from any and all liabilities, claims or law suits in regard to the information obtained from any and all of the above referenced sources used. The following is my true and complete legal name and all information is true and correct to the best of my knowledge.
            </p>
        </div>

        <div class="container-fluid row date-place-signature">
            <div class="w-50">
                <div>
                    Date: <?php date('d-m-Y'); ?>
                </div>
                <div class="place-class">
                    Place: [address]
                </div>
            </div>
            <div class="w-50">
                <div>Signature of Candidate</div> 
            </div>
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

 
<script src="<?php echo base_url(); ?>assets/custom-js/admin/client/add-client-consent.js"></script>