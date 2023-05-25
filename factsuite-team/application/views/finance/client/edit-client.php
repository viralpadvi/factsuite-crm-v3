<div class="pg-cnt">
     <div id="FS-candidate-cnt" class="pt-3">
        <!--Add Client Content-->
        <div class="add-client-bx">
           <h3>Client details</h3>
          
           <ul>
              <li>
                 <label> Client Name</label>
                 <input type="hidden" class="form-control fld" value="<?php echo $client['client_id']; ?>" id="client-id">
                 <input type="text" class="form-control fld" value="<?php echo $client['client_name']; ?>" id="client-name">
                 <div id="client-name-error">&nbsp;</div>
              </li>
              <li>
                 <label>Address</label>
                 <input type="text" class="form-control fld" value="<?php echo $client['client_address']; ?>" id="client-address">
                 <div id="client-address-error">&nbsp;</div>
              </li>
             
              <li>
                 <label>Zip/Pin Code</label>
                 <input type="text" class="form-control fld" value="<?php echo $client['client_zip']; ?>" id="client-zip">
                 <div id="client-zip-error">&nbsp;</div>
              </li>
              <li> 
               <label>Country</label> 
                   <select class="fld form-control country select2" id="country" >
                      <?php
                      $get_country = ($client['client_country'] !='' && $client['client_country'] !='null')?$client['client_country']:'India';
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
                   <select class="fld form-control state select2"  id="client-state" >
                      <?php 
                      $get_state = ($client['client_state'] !='' && $client['client_state'] !='null')?$client['client_state']:'Karnataka';
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
                 <select name=""  class="form-control fld select2" id="client-city">
                    <?php  
                      $cities = $this->clientModel->get_all_cities($city_id);
                      foreach ($cities as $key2 => $val) {
                        $selected = '';
                         if ($client['client_city'] == $val['name']) {
                           $selected = 'selected';
                         }
                            echo "<option {$selected} data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                        
                      }
                      ?>
                 </select>
                 <div id="client-city-error">&nbsp;</div>
              </li>
              <li>
                 <label>Industry</label>
                <!--  <input type="text" class="form-control fld" value="<?php echo $client['client_industry']; ?>" id="client-industry" > -->
                <select  class="form-control fld select2"  id="client-industry">
                  <option value="">Select Industry</option>
                    <?php 
                   $ind = $this->db->get('industry')->result_array();
                   if (count($ind) > 0) {
                      foreach ($ind as $k => $val) {
                        $select = '';
                          if ($val['industry_id']==$client['client_industry']) {
                            $select = 'selected';
                          }
                       echo "<option {$select} value='{$val['industry_id']}'>{$val['industry_name']}</option>";
                      }
                   }
                    ?>
                 </select>
                  <div id="client-industry-error">&nbsp;</div>
              </li>
               <?php 
                  $class_other_industry = 'd-none';
                  if($client['client_industry'] == '101'){
                     $class_other_industry = '';
                  }

               ?>
              <li id="li-other-industry" class="<?php echo $class_other_industry;?>" >
                  <label>Industry Name</label>
                  <input type="text" class="form-control fld" id="other_industry" value="<?php echo $client['other_industry']; ?>">
                  <div id="other-industry-error">&nbsp;</div>
              </li>

              <li>
                 <label>Website</label>
                 <input type="text" class="form-control fld" value="<?php echo $client['website']; ?>" id="client-website">
                  <div id="client-website-error">&nbsp;</div>
              </li>
               <li>
                 <label> </label>
                 <!-- <input type="text" class="form-control fld" id="client-website"> -->
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input is_master" <?php if($client['is_master'] =='0') echo 'checked'; ?> value="0" name="customCheck" id="is_master">
                    <label class="custom-control-label" for="is_master">Master Account</label> 
                 </div> 
                  <div id="master-error">&nbsp;</div>
              </li>
               <!--  <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" value="1" name="customCheck" id="is_master">
                    <label class="custom-control-label" for="is_master">Is Master</label> 
                 </div> 
              </li> -->
              <li >
                 <label>Master Account</label>
                 <select class="form-control fld" <?php if($client['is_master'] =='1') echo 'disabled'; ?>  id="master-account">
                    <option value="">Select Master Account</option>
                     <?php
                    if (count($clients) > 0) {
                      foreach ($clients as $key => $value) {
                        $select='';
                         if($client['is_master'] ==$value['client_id']){ $select='selected'; }
                         echo "<option {$select} value='{$value['client_id']}'>{$value['client_name']}</option>";
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
                    <input type="checkbox" class="custom-control-input document-download-by-client" value="1" name="document-download-by-client" id="document-download-by-client" <?php if($client['client_access'] == '1') echo 'checked'; ?>>
                    <label class="custom-control-label" for="document-download-by-client">Document Download by Client</label> 
                 </div> 
                  <div id="master-error">&nbsp;</div>
                   <div id="master-account-error">&nbsp;</div>
              </li>
              <li>
                 <label> </label>
                 <!-- <input type="text" class="form-control fld" id="client-website"> -->
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input notification-to-candidate" value="1" name="notification-to-candidate" id="notification-to-candidate" <?php if($client['candiate_notification_status'] == '1') echo 'checked'; ?>>
                    <label class="custom-control-label" for="notification-to-candidate">Notification to Candidate</label> 
                 </div> 
                  <div id="master-error">&nbsp;</div>
                   <div id="master-account-error">&nbsp;</div>
              </li>
                 <li class="vendor-wdt2">
                    <label>Upload document</label>
                    <div class="form-group mb-0">
                      <input type="file" id="client-documents" name="client-documents[]" multiple="multiple">
                      <label class="btn upload-btn" for="client-documents">Upload</label>
                    </div>
                    <div id="client-upoad-docs-error-msg-div">&nbsp;</div>
                 </li> 
              </ul>
               
                     <div class="row" id="selected-vendor-docs">
                      <?php 
                      foreach (explode(',', $client['upload_doc_name']) as $key => $image) {
                         if ($image !='no-file') { 
                      ?>
                      <div class="col-md-4">
                         <div class="image-selected-div">
                          <?php echo $image; ?>
                          <a id="file_client_documents<?php echo $key; ?>" onclick="exist_view_image('<?php echo $image; ?>','client-docs')" data-file="<?php echo $image; ?>" class="image-name-delete-a"><i class="fa fa-eye text-info"></i></a>
                          <a id="remove_file_client_documents<?php echo $key; ?>" onclick="removeFile_documents(<?php echo $key; ?>)" data-file="<?php echo $image; ?>" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>   
                                </div>
                            </div>
                     <!-- </div> -->

                   <?php }} ?>
                   
                 
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
                        $selected = '';
                        if ($client['account_manager_name'] == $value['team_id']) {
                         $selected = 'selected';
                        }
                         echo "<option {$selected} value='{$value['team_id']}'>{$value['first_name']}</option>";
                      }
                    }
                    ?>
                 </select>
                 <div id="account-manager-error">&nbsp;</div>
              </li>
              <li>
                 <label>Email id</label>
                 <input type="email" class="form-control fld" value="<?php echo $client['account_manager_email_id']; ?>" disabled id="manager-email">
                 <div id="manager-email-error">&nbsp;</div>
              </li>
              <li>
                 <label>Phone Number</label>
                 <input type="text" class="form-control fld" value="<?php echo $client['account_contact_no']; ?>" disabled oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="manager-contact">
                 <div id="manager-contact-error">&nbsp;</div>
              </li>
           </ul>
            
           <h3>Client SPOC Details </h3> 
           <div id="spo-details-div-error"></div>
           <div id="spo-details-div">
            <?php 
             foreach ($spoc as $key => $spo): ?> 
             <ul id="<?php echo $key; ?>">
              <li>
                 <label>Name</label>
                 <input type="hidden" class="form-control fld spo_id" value="<?php echo $spo['spoc_id']; ?>" id="spoc-id">
                 <input type="text" class="form-control fld spo_name" onkeyup="valid_spoc_name(<?php echo $key; ?>)"  value="<?php echo $spo['spoc_name']; ?>" id="spoc-name">
                 <div id="spoc-name-error">&nbsp;</div>
              </li>
              <li>
                 <label>Email id</label>
                 <input type="email" class="form-control fld spo_email" readonly onkeyup="valid_spoc_email(<?php echo $key; ?>)" value="<?php echo $spo['spoc_email_id']; ?>"  id="spoc-email">
                 <div id="spoc-email-error">&nbsp;</div>
              </li>
              <li>
                 <label>Phone Number</label>
                 <input type="number" class="form-control fld spo_contact" onkeyup="valid_spoc_contact(<?php echo $key; ?>)" value="<?php echo $spo['spoc_phone_no']; ?>"  id="spoc-contact">
                 <div id="spoc-contact-error">&nbsp;</div>
              </li>
              <li>
               <?php 
               if ($key =='0') {
                echo '<button class="btn btn-success" id="add-new"><i class="fa fa-plus"></i></button>';
                  
               }
               ?>
                <div>&nbsp;</div>
              </li>
           </ul>

            <?php endforeach ?>

           </div>
            
           <h3>Preferred Communication Channel</h3>
           <?php 
            $comm = explode(',', $client['communications']);
           ?>

           <ul>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input communications" name="customCheck" <?php if (in_array('Whatsapp', $comm)) {
                      echo "checked";
                    } ?> value="Whatsapp" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Whatsapp</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input communications" name="customCheck" <?php if (in_array('Email', $comm)) {
                      echo "checked";
                    } ?> value="Email" id="customCheck2">
                    <label class="custom-control-label" for="customCheck2">Email</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input communications" name="customCheck" <?php if (in_array('SMS', $comm)) {
                      echo "checked";
                    } ?> value="SMS" id="customCheck3">
                    <label class="custom-control-label" for="customCheck3">SMS</label>
                 </div>
              </li>
           </ul>
 
           
           <div class="row">
               <div class="col-md-4">
                  <label>Location</label>
                  
                  <div class="input-group mb-3">
                      <input type="text" class="form-control" value="<?php echo $client['location']; ?>" name="location" id="location">
                      <div class="input-group-append" style="display: none;" id="div-location">
                        <!-- <a id="save_location" class="text-white btn btn-small btn-success">Add item</a> -->
                      </div>
               </div> 
               </div> 
               <div class="col-md-4">
                  <label>Segment</label>
                  
                  <div class="input-group mb-3">
                      <input type="text" class="form-control" value="<?php echo $client['client_segment']; ?>" name="segment" id="segment">
                      <div class="input-group-append" style="display: none;" id="div-segment">
                        <!-- <a id="save_segment" class="text-white btn btn-small btn-success">Add item</a> -->
                      </div>
               </div> 
               </div>
            </div>
           
        </div>
        <div id="client-error" class="text-right"></div>
        <div class="sbt-btns">
           <a href="javascript::" id="clear-form" data-toggle="modal" data-target="#cancel-form-modal" class="btn bg-gry btn-submit-cancel">CANCEL</a>
           <button onclick="save_client()" id="client-update-submit-btn" class="btn bg-blu btn-submit-cancel">SUBMIT &amp; SAVE</button>
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
               <a href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/view-all-client" id="add-all-alacarte-data" class="btn bg-blu btn-submit-cancel text-white">submit</a>
           </div>
        </div>
      </div>
    </div>
  </div>


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

  <script src="<?php echo base_url(); ?>assets/custom-js/finance/client/edit-update-client.js"></script>
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