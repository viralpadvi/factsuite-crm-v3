
  <div class="pg-cnt">
     <div id="FS-candidate-cnt">
        <!--Add Client Content-->
        <div class="add-client-bx">
           <h3>basic client details</h3>
           <ul>
              <li>
                 <label>Name</label>
                 <input type="text" class="form-control fld" id="client-name">
                 <div id="client-name-error">&nbsp;</div>
              </li>
              <li>
                 <label>Address</label>
                 <input type="text" class="form-control fld" id="client-address">
                 <div id="client-address-error">&nbsp;</div>
              </li>
             
              <li>
                 <label>Zip</label>
                 <input type="text" class="form-control fld" id="client-zip">
                 <div id="client-zip-error">&nbsp;</div>
              </li>
              <li> 
               <label>Country</label> 
                   <select class="fld form-control country" id="country" >
                      <?php
                      $get_country = 'India';
                      $c_id = '';
                      foreach ($country as $key1 => $val) {
                         if ($get_country == $val['name']) {
                          $c_id = $val['id'];
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                   <div id="country-error">&nbsp;</div> 
              </li>
              <li>
                <label>State</label>
                   <?php
                   if ($c_id !='') {
                        $state = $this->clientModel->get_all_states($c_id);  
                      }
                      $city_id = '';
                   ?>
                   <select class="fld form-control state"  id="client-state" >
                      <?php 
                      $get_state = 'Karnataka';
                      foreach ($state as $key1 => $val) {
                         if ($get_state == $val['name']) {
                          $city_id =$val['id'];
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                  <div id="client-state-error">&nbsp;</div>
              </li>
               <li>
                 <label>City</label>
                 <!-- <input type="text" class="form-control fld" id="client-city"> -->
                 <select name=""  class="form-control fld" id="client-city">
                    <?php  
                      $cities = $this->clientModel->get_all_cities($city_id);
                      foreach ($cities as $key2 => $val) {
                         
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                        
                      }
                      ?>
                 </select>
                 <div id="client-city-error">&nbsp;</div>
              </li>
              <li>
                 <label>Industry</label>
                 <input type="text" class="form-control fld" id="client-industry" >
                  <div id="client-industry-error">&nbsp;</div>
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
                    <label class="custom-control-label" for="is_master">Is Master</label> 
                 </div> 
                  <div id="master-error">&nbsp;</div>
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
                 <li class="vendor-wdt2">
                    <label>Upload document</label>
                    <div class="form-group mb-0">
                      <input type="file" id="client-documents" name="client-documents[]" multiple="multiple">
                      <label class="btn upload-btn" for="client-documents">Upload</label>
                    </div>
                    <div id="client-upoad-docs-error-msg-div">&nbsp;</div>
                 </li> 
              </ul>
               
                     <div class="row" id="selected-vendor-docs-li"></div>
                   
                 
           </div>
           <h3>Add Factsuite manager details</h3>
           <ul>
              <li>
                 <label>Name</label>
                 <select class="form-control fld" id="account-manager">
                    <option value="">Select Factsuite Manager</option>
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
                 <label>Email</label>
                 <input type="email" class="form-control fld" disabled id="manager-email">
                 <div id="manager-email-error">&nbsp;</div>
              </li>
              <li>
                 <label>Phone Number</label>
                 <input type="text" class="form-control fld" disabled oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="manager-contact">
                 <div id="manager-contact-error">&nbsp;</div>
              </li>
           </ul>
            
           <h3>add spoc details</h3> 
           <div id="spo-details-div-error"></div>
           <div id="spo-details-div">
             <ul>
              <li>
                 <label>Name</label>
                 <input type="text" class="form-control fld spo_name" onkeyup="valid_spoc_name()" id="spoc-name">
                 <div id="spoc-name-error">&nbsp;</div>
              </li>
              <li>
                 <label>Email</label>
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
           <h3>Communication</h3>
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
           <h3>Packages & Alacarte</h3>
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
           <!-- <ul>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline mrg">
                    <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck5">
                    <label class="custom-control-label" for="customCheck5">Education</label>
                 </div>
              </li>
              <li>
                 <input type="text" class="fld2" placeholder="INR 1000" >
              </li>
              <li>
                 <input type="text" class="fld" >
              </li>
           </ul> -->
        </div>
        <div id="client-error" class="text-right"></div>
        <div class="sbt-btns">
           <a href="javascript::" id="clear-form" class="btn bg-gry btn-submit-cancel">CANCEL</a> 
           <button onclick="save_client()" id="client-submit-btn" class="btn bg-blu btn-submit-cancel">SUBMIT &amp; SAVE</button>
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

<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/client/add-client.js"></script> 