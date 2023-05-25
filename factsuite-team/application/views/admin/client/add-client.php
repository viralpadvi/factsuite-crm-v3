
  <div class="pg-cnt">
     <div id="FS-candidate-cnt">
        <!--Add Client Content-->
        <div class="add-client-bx pt-3">
           <h3>client details</h3>
           <ul>
              <li>
                 <label>Client Name</label>
                 <input type="text" class="form-control fld" id="client-name">
                 <div id="client-name-error">&nbsp;</div>
              </li>
              <li>
                 <label>Address</label>
                 <input type="text" class="form-control fld" id="client-address">
                 <div id="client-address-error">&nbsp;</div>
              </li>
             
              <li>
                 <label>Zip/Pin Code</label>
                 <input type="text" class="form-control fld" id="client-zip">
                 <div id="client-zip-error">&nbsp;</div>
              </li>
               
              <li> 
               <label>Country</label> 
                  <select class="fld form-control country select2" id="country" >
                     <option selected value='' >Select Country</option>
                     <?php // $get_country = 'India';
                     $get_country = '';
                     $c_id = '';
                     foreach ($country as $key1 => $val) {
                        if ($get_country == $val['name']) {
                           $c_id = $val['id'];
                           echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                        } else {
                           echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                        }
                     }  ?>
                  </select> 
                  <div id="country-error">&nbsp;</div> 
              </li>
              <li>
                  <label>State</label>
                  <select class="fld form-control state select2"  id="client-state" >
                     <option selected value=''>Select State</option>
                  </select> 
                  <div id="client-state-error">&nbsp;</div>
              </li>
               <li>
                 <label>City</label>
                 <!-- <input type="text" class="form-control fld" id="client-city"> -->
                 <select name=""  class="form-control fld select2" id="client-city">
                  <option selected value=''>Select City</option>
                 </select>
                 <div id="client-city-error">&nbsp;</div>
              </li>
              <li>
                 <label>Industry</label>
                 <!-- <input type="text" class="form-control fld" id="client-industry" > -->
                 <select  class="form-control fld select2"  id="client-industry">
                  <option value="">Select Industry</option>
                    <?php 
                   $ind = $this->db->get('industry')->result_array();
                   if (count($ind) > 0) {
                      foreach ($ind as $k => $val) {
                          
                       echo "<option value='{$val['industry_id']}'>{$val['industry_name']}</option>";
                      }
                   }
                    ?>
                 </select>
                  <div id="client-industry-error">&nbsp;</div>
              </li>
              <li  id="li-other-industry" class="d-none">
                  <label>Industry Name</label>
                  <input type="text" class="form-control fld" id="other_industry">
                  <div id="other-industry-error">&nbsp;</div>
              </li>
              <li>
                 <label>Website</label>
                 <input type="text" class="form-control fld" id="client-website">
                  <div id="client-website-error">&nbsp;</div>
              </li>
               <li>
                 <label> </label>
                 <!-- <input type="text" class="form-control fld" id="client-website"> -->
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input is_master" value="0" name="customCheck" id="is_master">
                    <label class="custom-control-label" for="is_master">Master Account</label> 
                 </div> 
                  <div id="master-error">&nbsp;</div>
                   <div id="master-account-error">&nbsp;</div>
              </li>
               <!--  <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" value="1" name="customCheck" id="is_master">
                    <label class="custom-control-label" for="is_master">Is Master</label> 
                 </div> 
              </li> -->
              <li>
                 <label>Master Account</label>
                 <select class="form-control fld" id="master-account">
                    <option value="">Select Master Account</option>
                     <?php
                    if (count($client) > 0) {
                      foreach ($client as $key => $value) {
                         echo "<option value='{$value['client_id']}'>{$value['client_name']}</option>";
                      }
                    }
                    ?>
                 </select>
                  <div id="master-account-error">&nbsp;</div>
              </li>
           </ul>
          <div class="add-vendor-bx2">
              <h3 class="m-0">&nbsp;</h3>
              <ul>
               <li style="width: 25%;">
                 <label> </label>
                 <!-- <input type="text" class="form-control fld" id="client-website"> -->
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input document-download-by-client" value="1" name="document-download-by-client" id="document-download-by-client">
                    <label class="custom-control-label" for="document-download-by-client">Document Download by Client</label> 
                 </div> 
                  <div id="master-error">&nbsp;</div>
                   <div id="master-account-error">&nbsp;</div>
              </li>
              <li style="width: 25%;">
                 <label> </label>
                 <!-- <input type="text" class="form-control fld" id="client-website"> -->
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input notification-to-candidate" value="1" name="notification-to-candidate" id="notification-to-candidate">
                    <label class="custom-control-label" for="notification-to-candidate">Notification to Candidate</label> 
                 </div> 
                  <div id="master-error">&nbsp;</div>
                   <div id="master-account-error">&nbsp;</div>
              </li>
              <li class="vendor-wdt2" style="width: 30%;">
                 <label>Upload document</label>
                 <div class="form-group mb-0">
                   <input type="file" id="client-documents" name="client-documents[]" multiple="multiple">
                   <label class="btn upload-btn" for="client-documents">Upload</label>
                 </div>
                 <div id="client-upoad-docs-error-msg-div">&nbsp;</div>
                 <div class="row" id="selected-vendor-docs-li"></div>
              </li> 
            </ul>
            <div class="row">
               <div class="col-md-4">
                  <ul>
                     <li class="w-100">
                        <div class="custom-control custom-checkbox custom-control-inline">
                           <input type="checkbox" class="custom-control-input notification-to-candidate" value="1" name="insuff-client-notification" id="insuff-client-notification">
                           <label class="custom-control-label" for="insuff-client-notification">Send Insuff Notification to Client?</label>
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="col-md-8 d-none" id="insuff-client-notification-types-div">
                  <ul>
                     <?php 
                        foreach (json_decode($notification_types,true) as $key => $value) { ?>
                           <li class="li-width-2">
                              <div class="custom-control custom-checkbox custom-control-inline">
                                 <input type="checkbox" class="custom-control-input insuff-client-notification-type" value="<?php echo $value['id'];?>" name="insuff-client-notification-type[]" id="insuff-client-<?php echo strtolower($value['name']);?>-notification">
                                 <label class="custom-control-label" for="insuff-client-<?php echo strtolower($value['name']);?>-notification">Send <?php echo $value['name'];?> Notifications?</label>
                              </div>
                           </li>
                     <?php } ?>
                  </ul>
                  <div id="insuff-client-notification-types-error-msg-div"></div>
               </div>
            </div>

            <div class="row mt-4">
               <div class="col-md-4">
                  <ul>
                     <li class="w-100">
                        <div class="custom-control custom-checkbox custom-control-inline">
                           <input type="checkbox" class="custom-control-input notification-to-candidate" value="1" name="client-clarification-client-notification" id="client-clarification-client-notification">
                           <label class="custom-control-label" for="client-clarification-client-notification">Send Client Clarification Notification to Client?</label>
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="col-md-8 d-none" id="client-clarification-client-notification-types-div">
                  <ul>
                     <?php 
                        foreach (json_decode($notification_types,true) as $key => $value) { ?>
                           <li class="li-width-2">
                              <div class="custom-control custom-checkbox custom-control-inline">
                                 <input type="checkbox" class="custom-control-input client-clarification-client-notification-type" value="<?php echo $value['id'];?>" name="client-clarification-client-notification-type[]" id="client-clarification-client-<?php echo strtolower($value['name']);?>-notification">
                                 <label class="custom-control-label" for="client-clarification-client-<?php echo strtolower($value['name']);?>-notification">Send <?php echo $value['name'];?> Notifications?</label>
                              </div>
                           </li>
                     <?php } ?>
                  </ul>
                  <div id="client-clarification-client-notification-types-error-msg-div"></div>
               </div>
            </div>



            <div class="row mt-4">
               <div class="col-md-2">
                  <label>Is Signature Pad Require?</label>
                  <ul>
                     <li class="w-100">
                        <div class="custom-control custom-checkbox custom-control-inline">
                           <input type="checkbox" class="custom-control-input client-signature" value="1" name="client-signature" id="signature-client">
                           <label class="custom-control-label" for="signature-client">Signature Pad</label>
                        </div>
                     </li>
                  </ul>
               </div>
              
               <div class="col-md-12" id="client-signature-error-msg-div"></div>
            </div>


            <div class="row mt-4">
               <div class="col-md-2">
                  <label>Iverify / PV?</label>
                  <ul>
                     <li class="w-100">
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" class="custom-control-input client-iverify-or-pv-type" value="1" name="client-iverify-or-pv-type" id="iverify-client">
                           <label class="custom-control-label" for="iverify-client">Iverify</label>
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="col-md-2">
                  <label>&nbsp;</label>
                  <ul>
                     <li class="w-100">
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" class="custom-control-input client-iverify-or-pv-type" value="2" name="client-iverify-or-pv-type" id="pv-client">
                           <label class="custom-control-label" for="pv-client">PV</label>
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="col-md-12" id="client-iverify-or-pv-type-error-msg-div"></div>
            </div>


            <div class="row mt-4">
               <div class="col-md-2">
                  <label>TV / EBGV?</label>
                  <ul>
                     <li class="w-100">
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" class="custom-control-input client-tv-ebgv" value="1" name="client-tv-ebgv" id="tv-client">
                           <label class="custom-control-label" for="tv-client">TV</label>
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="col-md-2">
                  <label>&nbsp;</label>
                  <ul>
                     <li class="w-100">
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" class="custom-control-input client-tv-ebgv" value="2" name="client-tv-ebgv" id="ebgv-client">
                           <label class="custom-control-label" for="ebgv-client">EBGV</label>
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="col-md-12" id="client-iverify-or-pv-type-error-msg-div"></div>
            </div>
              
                 
           </div>
           <h3>Account Manager Details</h3>
           <ul>
              <li>
                 <label>Name</label>
                 <select class="form-control fld" id="account-manager">
                    <option value="">Select</option>
                    <?php
                    if (count($team) > 0) {
                      foreach ($team as $key => $value) {
                         echo "<option value='{$value['team_id']}'>{$value['first_name']}</option>";
                      }
                    }
                    ?>
                 </select>
                 <div id="account-manager-error">&nbsp;</div>
              </li>
              <li>
                 <label>Email id</label>
                 <input type="email" class="form-control fld" disabled id="manager-email">
                 <div id="manager-email-error">&nbsp;</div>
              </li>
              <li>
                 <label>Phone Number</label>
                 <input type="text" class="form-control fld" disabled oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="manager-contact">
                 <div id="manager-contact-error">&nbsp;</div>
              </li>
           </ul>
            
           <h3>Client SPOC Details </h3> 
           <div id="spo-details-div-error"></div>
           <div id="spo-details-div">
             <ul>
              <li>
                 <label>Name</label>
                 <input type="text" class="form-control fld spo_name" onkeyup="valid_spoc_name()" id="spoc-name">
                 <div id="spoc-name-error">&nbsp;</div>
              </li>
              <li>
                 <label>Email id</label>
                 <input type="email" class="form-control fld spo_email" onkeyup="valid_spoc_email()" id="spoc-email">
                 <div id="spoc-email-error">&nbsp;</div>
              </li>
              <li>
                 <label>Phone Number</label>
                 <input type="number" class="form-control fld spo_contact" onkeyup="valid_spoc_contact()" id="spoc-contact">
                 <div id="spoc-contact-error">&nbsp;</div>
              </li>
              <li>
                <button class="btn btn-success" id="add-new"><i class="fa fa-plus"></i></button>
                <div>&nbsp;</div>
              </li>
           </ul>

           </div>
           
            <div id="">&nbsp;</div>
           <h3 class="d-none">Login details</h3>
           <ul class="d-none">
              <li>
                 <label>First Name</label>
                 <input type="text" class="form-control fld" id="first-name">
                  <div id="first-name-error">&nbsp;</div>
              </li>
              <li>
                 <label>Last Name</label>
                 <input type="text" class="form-control fld" id="last-name">
                  <div id="last-name-error">&nbsp;</div>
              </li>
              <li>
                 <label>Email Address</label>
                 <input type="email" class="form-control fld" id="user-email">
                  <div id="user-email-error">&nbsp;</div>
              </li>
              <li>
                 <label>Phone Number</label>
                 <input type="text" class="form-control fld" id="user-contact">
                  <div id="user-contact-error">&nbsp;</div>
              </li>
              <li>
                 <label>User Name</label>
                 <input type="text" class="form-control fld" id="user-name">
                  <div id="user-name-error">&nbsp;</div>
              </li>
              <li>
                 <label>Password</label>
                 <input type="password" class="form-control fld" id="user-password">
                  <div id="user-password-error">&nbsp;</div>
              </li>
              <li>
                 <label>Confirm Password</label>
                 <input type="password" class="form-control fld" id="user-confirm-password">
                  <div id="user-confirm-password-error">&nbsp;</div>
              </li>
           </ul>
            <h3>Preferred Communication Channel</h3>
            <ul>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input communications" name="customCheck" value="Whatsapp" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Whatsapp</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input communications" name="customCheck" value="Email" id="customCheck2">
                    <label class="custom-control-label" for="customCheck2">Email</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input communications" name="customCheck" value="SMS" id="customCheck3">
                    <label class="custom-control-label" for="customCheck3">SMS</label>
                 </div>
              </li>
            </ul>
            <div id="communication-error">&nbsp;</div>

             <div class="col-md-6">
                <label class="product-details-span-light">Remarks</label>
                <!-- ckeditor -->
                <!-- <textarea class="fld" name="ticket_description" id="ticket_description" placeholder="Remarks"></textarea> -->
                <select class="fld" name="ticket_description" id="ticket_description"></select>
                <div id="ticket-description-error-msg-div"></div>
              </div>
              <div class="col-md-6" id="additionals" style="display:none;">
                 <label class="product-details-span-light">Additional Remarks</label>
                 <textarea class="fld" name="additional_remarks" id="additional_remarks" placeholder="Additional Remarks"></textarea>
              </div>


            

            

          <!--  <h3>Packages & Alacarte</h3>
           <ul>
              <li>
                 <label>Packages</label>
                 <input type="hidden" id="tmp-packages" value="0" name="tmp-packages">
                 <select class="form-control fld select2 auto-width" id="packages" multiple >
                    <option disabled value="">Select Package</option>
                    <?php
                    if (count($package) > 0) {
                      foreach ($package as $key => $pack) {
                        echo "<option value='{$pack['package_id']}'>{$pack['package_name']}</option>";
                      }
                    }
                    ?>
                 </select>
                  <div id="packages-error">&nbsp;</div>
              </li>

              <li>
                 <label>Alacarte</label>
                 <input type="hidden" id="tmp-alacarte" value="0" name="tmp-alacarte">
                 <select class="form-control fld multi-select auto-width" id="alacarte" multiple >
                    <option disabled value="">Select Alacart</option>
                    <?php
                    if (count($alacarte) > 0) {
                      foreach ($alacarte as $key => $alc) {
                        echo "<option value='{$alc['alacarte_id']}'>{$alc['alacarte_name']}</option>";
                      }
                    }
                    ?>
                 </select>
                  <div id="alacarte-error">&nbsp;</div>
              </li>
           </ul>
          
           
 
           

           <div class="row">
             <div class="col-md-6">
               <h3> Package Component</h3>
                 <div id="component-price-error">&nbsp;</div>
                 <div class="row">
                    <div class="col-md-4">
                       <label class="font-weight-bold">Component</label> 
                    </div>
                    <div class="col-md-4">
                       <label class="font-weight-bold">Standards Price</label> 
                    </div>
                    <div class="col-md-4">
                       <label class="font-weight-bold">Price for this Client</label> 
                    </div>
                 </div>
               <div id="component-details"></div>
           <div id="component-total"></div>
             </div>
             <div class="col-md-6"> 
                   <h3> Ala-Carte Component</h3>
                     <div id="alacarte-component-price-error">&nbsp;</div>
                     <div class="row">
                        <div class="col-md-4">
                           <label class="font-weight-bold">Component</label> 
                        </div>
                        <div class="col-md-4">
                           <label class="font-weight-bold">Standards Price</label> 
                        </div>
                        <div class="col-md-4">
                           <label class="font-weight-bold">Price for this Client</label> 
                        </div> 

                 </div>
                 <div id="alacarte-component-details"></div>
                <div id="alacarte-component-total"></div>
                
              </div>

           </div>
           
        </div>
        <div id="client-error" class="text-right"></div>

         -->
        <div class="sbt-btns" id="form-button-area">
           <a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">Cancel</a> 
           <button onclick="save_client()" id="client-submit-btn" class="btn bg-blu btn-submit-cancel">Save &amp; Next</button>
        </div>
        <!--Add Client Content--> 
     </div>
  </div>
</section>
<!--Content-->


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
<script src="<?php echo base_url(); ?>assets/custom-js/admin/client/add-client.js"></script>
<script > 
  $(document).ready(function(){
      
    $('#location').autocomplete({
      source: base_url+"Custom_Util/get_location?",
      minLength: 0,
      select: function(event, ui)
      { 
        $('#location').val(ui.item.location_name);
        $("#div-location").hide();
        return false;
              }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
      $("#div-location").hide();

      return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.location_name)
        .appendTo(ul);
    };
      
    $('#segment').autocomplete({
      source: base_url+"Custom_Util/get_segment?",
      minLength: 0,
      select: function(event, ui)
      { 
        $('#segment').val(ui.item.segment_name);
        return false;
              }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
      return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete", item)
        .append(item.segment_name)
        .appendTo(ul);
    };

  }); 

  $('#location').on('keyup keydown change',function(){
   if ($(this).val().length > 3) { 
   $("#div-location").show();
   }
  }).on("focus", function () {
        $(this).autocomplete("search", "");
    });


  $('#segment').on('keyup keydown change',function(){ 
   if ($(this).val().length > 3) { 
   $("#div-segment").show();
   }
  }).on("focus", function () {
        $(this).autocomplete("search", "");
    });
</script>