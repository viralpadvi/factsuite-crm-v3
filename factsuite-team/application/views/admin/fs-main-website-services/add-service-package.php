
   <div class="pg-cnt">
      <div id="FS-candidate-cnt">
         <!--Add Client Content-->
         <div class="add-client-bx pt-3">
            <h3>Package Details</h3>
            <ul>
               <li class="w-100">
                  <div class="row">
                     <div class="col-md-4">
                        <label>Select Service</label>
                        <select class="fld form-control" id="service-name"></select> 
                        <div id="service-name-error"></div>
                     </div>
                     <div class="col-md-4">
                        <label>Select Package type</label>
                        <select class="fld form-control" id="package-type"></select> 
                        <div id="package-type-error"></div>
                     </div>
                     <div class="col-md-4">
                        <label>Package name</label>
                        <input type="text" class="form-control fld" id="package-name" placeholder="Package name">
                        <div id="package-name-error"></div>
                     </div>
                  </div>
               </li>
               <li class="w-100">
                  <label>Description</label>
                  <textarea class="form-control fld" id="package-description" placeholder="Description"></textarea>
                  <div id="package-description-error"></div>
               </li>
               <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input is_master" name="customCheck" id="is-package-most-popular" value="1">
                    <label class="custom-control-label" for="is-package-most-popular">Mark as Most Popular</label>
                 </div> 
                  <div id="master-error"></div>
              </li>
            </ul>
            <div id="spo-details-div">
               <ul>
               <li class="w-100">
                  <div class="row">
                     <div class="col-md-3">
                        <label>TAT Name</label>
                        <input type="text" class="form-control fld tat_name" id="add-new-tat-name-0" placeholder="TAT Name" onkeyup="validate_tat_name(0)" onblur="validate_tat_name(0)">
                        <div id="add-new-tat-name-error-0"></div>
                     </div>
                     <div class="col-md-3">
                        <label>TAT Days</label>
                        <input type="text" class="form-control fld tat_days" id="add-new-tat-days-0" placeholder="TAT Days" onkeyup="validate_tat_days(0)" onblur="validate_tat_days(0)">
                        <div id="add-new-tat-days-error-0"></div>     
                     </div>
                     <div class="col-md-3">
                        <label>TAT Price</label>
                        <input type="text" class="form-control fld tat_price" id="add-new-tat-price-0" placeholder="TAT Price" onkeyup="validate_tat_price(0)" onblur="validate_tat_price(0)">
                        <div id="add-new-tat-price-error-0"></div>
                     </div>
                     <div class="col-md-1">
                        <label>&nbsp;</label>
                        <button class="btn btn-success" id="add-new-package-tat"><i class="fa fa-plus"></i></button>
                     </div>
                  </div>
                  <div id="additional-tat-div"></div>
               </li>
               <li class="w-100">
                  <label>Package Components</label>
                  <div class="row" id="package-components"></div>
                  <div class="row">
                     <div class="col-md-12" id="package-components-error-msg"></div>
                  </div>
               </li>
               <li class="w-100">
                  <label>Package Alacarte Components</label>
                  <div class="row" id="package-alacarte-components"></div>
                  <div class="row">
                     <div class="col-md-12" id="package-alacarte-components-error-msg"></div>
                  </div>
               </li>
            </ul>

           </div>
           <div class="row">
              <div class="col-md-12 text-center" id="new-package-error-msg"></div>
           </div>
        <div class="sbt-btns" id="form-button-area">
           <a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">CANCEL</a> 
           <button id="add-new-package-btn" class="btn bg-blu btn-submit-cancel">SAVE &amp; NEXT</button>
        </div>
        <!--Add Client Content--> 
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
<script src="<?php echo base_url(); ?>assets/custom-js/admin/common-validations.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/admin/factsuite-website/service-package/add-new-package.js"></script>