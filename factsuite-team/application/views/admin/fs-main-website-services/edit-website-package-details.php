
   <div class="pg-cnt">
      <div id="FS-candidate-cnt">
         <!--Add Client Content-->
         <div class="add-client-bx pt-3">
            <h3>Package Details</h3>
            <ul>
               <li class="w-100">
                  <div class="row">
                     <div class="col-md-4">
                        <label>Service Name</label>
                        <label class="d-block" id="edit-package-service-name"></label>
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
              <div class="col-md-12 text-center" id="update-package-details-error-msg-div"></div>
           </div>
        <div class="sbt-btns" id="form-button-area">
           <a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">CANCEL</a> 
           <button id="edit-package-details-btn" class="btn bg-blu btn-submit-cancel">SAVE &amp; NEXT</button>
        </div>
        <!--Add Client Content--> 
     </div>
  </div>
</section>
<!--Content-->



<!-- custom-js -->
<?php 
   extract($_GET);
?>

<script src="<?php echo base_url(); ?>assets/custom-js/admin/common-validations.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/admin/factsuite-website/service-package/all-packages.js"></script>
<script>
   var package_id = '<?php echo $package_id; ?>';
   view_package_details(package_id);
</script>