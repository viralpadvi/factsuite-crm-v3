<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-consent-form';
   }
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/digital-signature/css/signature-pad.css">

<div class="row">
            <div class="col-md-12">
               <div class="consent-form-txt">
                  <?php if ($candidate_details['document_uploaded_by'] == 'candidate' || $client_details['signature'] !='1') {
                     $fs_logo = $this->db->where('client_id',$candidate_details['client_id'])->get('custom_logo')->row_array();
                     if (isset($fs_logo['consent']) && !empty($fs_logo['consent'])) {
                        $candidate_concent =  str_replace('@candidate_first_name',$candidate_details['title'].' '.ucfirst($candidate_details['first_name']),$fs_logo['consent']);

                        $candidate_concent = str_replace('@candidate_father_name',ucfirst($candidate_details['father_name']),$candidate_concent);
                        $candidate_concent = str_replace('@candidate_last_name',ucfirst($candidate_details['last_name']),$candidate_concent);
                        echo str_replace('@client_name',ucfirst($client_details['client_name']),$candidate_concent);
                     } else { 

                        if ($client_details['tv_or_ebgv'] !='1') { 
                        ?> 
                        <p>I, <?php echo ucfirst($candidate_details['title']).' '.ucfirst($candidate_details['first_name']).' '.ucfirst($candidate_details['father_name']).' '.ucfirst($candidate_details['last_name']);?>, hereby authorize, <?php echo ucfirst($client_details['client_name']);?> and/or its agents (FactSuite) to make an independent investigation of my background, references, past employment, education, credit history, criminal or police records, and motor vehicle records including those maintained by both public and private organizations and all public records for the purpose of confirming the information contained on my Application and/or obtaining other information which may be material to my qualifications for service now and, if applicable, during the tenure of my employment or service with <?php echo ucfirst($client_details['client_name']);?></p>  

                        <p>I release <?php echo ucfirst($client_details['client_name']);?> and its agents and any person or entity, which provides information pursuant to this authorization, from any and all liabilities, claims or law suits in regard to the information obtained from any and all of the above referenced sources used. The following is my true and complete legal name and all information is true and correct to the best of my knowledge.</p>
                     <?php } else{ ?>

                        <p>I, <?php echo ucfirst($candidate_details['title']).' '.ucfirst($candidate_details['first_name']).' '.ucfirst($candidate_details['father_name']).' '.ucfirst($candidate_details['last_name']);?>,  hereby consent to allow <?php echo ucfirst($client_details['client_name']);?> and/or its 
                           agents (FactSuite) to make an independent investigation of my background as part of my 
                           application to rent (<?php echo $candidate_details['candidate_city']; ?>) and to obtain information from any sources deemed 
                           necessary, including those maintained by both public and private organizations, but not 
                           limited to past landlords, current and former employers, and any other person or organization 
                           that may have information about me. </p> 
                           <p>I understand that the tenant verification process may include, but is not limited to, a review of 
                           my references, identity, address, credit history, criminal background check, employment 
                           verification, and rental history. </p>  
                           <p>I understand that the information obtained will be used solely for the purpose of evaluating 
                           my application for tenancy at the above property and that it will be kept confidential and used 
                           only for legitimate business purposes.</p>  
                           <p>I hereby release <?php echo ucfirst($client_details['client_name']);?> and/or its agents and any person or 
                           entity from any and all liabilities, claims, lawsuits or whatsoever arising out of the tenant 
                           verification process or the use of any information obtained from the process. </p> 

                     <?php } 
                  }  
                  } ?>
               </div>
            </div>
         </div>
         <div class="row mt-4">
            <div class="col-md-4">
               <div class="row">
                  <?php $upload_signature_checked = 'checked';
                  $upload_signature_main_div_class = '';
                  $upload_name_type = ' LOA';
                  if ($candidate_details['document_uploaded_by'] == 'candidate' && $client_details['signature'] =='1') {

                    
                     $upload_signature_main_div_class = $upload_signature_checked = ' mt-3';
                     $upload_name_type = ' Signature';

                  ?>
                     <div class="col-md-12" id="draw-signature-checkbox-btn-div">
                        <div class="select-upload-signature-type-div">
                           <label class="custon-checkbox-container"><span class="custon-checkbox-container-main-txt">Signature Pad</span>
                              <input type="radio" checked="checked" onchange="change_signature(1)" name="radio-select-sign" id="select-signature-pad" value="1">
                              <span class="custom-checkbox-checkmark"></span>
                           </label>
                        </div>
                     </div>

                 

                     <div class="col-md-12<?php echo $upload_signature_main_div_class;?>" id="upload-signature-checkbox-btn-div">
                        <div class="select-upload-signature-type-div" >
                            <!-- custon-checkbox-container-2 -->
                           <label class="custon-checkbox-container"><span class="custon-checkbox-container-main-txt">Upload <?php echo $upload_name_type;?></span>
                           <!-- <br><span class="custon-checkbox-container-small-txt"></span> -->
                              <input type="radio" <?php echo $upload_signature_checked;?> onchange="change_signature(2)" name="radio-select-sign" value="2" id="select-upload-signature">
                              <!-- custom-checkbox-checkmark-2 -->
                              <span class="custom-checkbox-checkmark"></span>
                           </label>
                        </div>
                     </div>
                  <?php } ?>
               </div>
            </div>
            <div class="col-md-8">
               <?php 
               $upload_signature_style = 'display:none;';
               $upload_signature_styles = '';
                if ($client_details['signature'] =='1') { 
                   $upload_signature_style = '';
                   $upload_signature_styles = '';
                }
               // $upload_signature_style = '';
               $sign = '1';
               if ($candidate_details['document_uploaded_by'] == 'candidate' && $client_details['signature'] =='1') {
                  $upload_signature_style = 'display:none;';
                  $sign = '';
               ?>
                  <div id="signature-pad-div">
                     <div id="signature-pad" class="signature-pad">
                        <div class="signature-pad--body">
                           <canvas class="signature-pad-canvas"></canvas>
                        </div>
                        <div class="signature-pad--footer">
                           <div class="signature-pad--actions text-dark">
                              <div id="btn-action">
                                 <button type="button" style="color: #000;" class="btn btn-secondary clear" data-action="clear">Clear</button>
                                 <button type="button" class="btn btn-success" style="display: none;" data-action="change-color">Change color</button>
                                 <button type="button" style="color: #000;" class="btn btn-secondary" data-action="undo">Undo</button>
                              </div>
                           <div>
                           <div id="btn-operation"></div>
                           <div id="btn-save-operation">
                              <button type="button" class="btn btn-success save" data-action="save-png">Save</button> 
                           </div>
                        </div>
                     </div>
                  </div>
                  </div>
                  </div>
               <?php } ?>
               <input type="hidden" id="signature" value="<?php echo $sign; ?>" name="">
               
               <div class="mt-3" style="<?php echo $upload_signature_style;?>" id="signature-upload-div">
                     <div class="row">
                        <div class="col-8">
                           <span class="custom-file-name file-name1" id="uploaded-signature-image-name"></span>
                        </div>
                        <div class="col-4 custom-file-input-btn-div">
                            <div class="custom-file-input">
                              <input type="hidden" name="cv_id" value="<?php echo isset($cv_data['cv_id'])?$cv_data['cv_id']:''; ?>" id="cv_id">
                              <input type="file" id="file1" name="file1" class="input-file w-100" accept="image/*,application/pdf" multiple>
                           <button class="btn btn-file-upload" for="file1">
                              <img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
                              Upload
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
           
            </div>
         </div>
         <div class="row">
            <div class="col-12 mt-3">
               <label class="custom-checkbox-tick-container custom-checkbox-terms-and-conditions-container">I acknowledge that I have read and agree to the <a class="t-nd-c-link" href="javascript:void(0)" id="terms-and-conditions-modal">Terms & conditions</a> of the consent letter/authorization form. 
                  <input type="checkbox" name="customCheck" id="customCheck1" value="1">
                  <span class="custom-checkbox-tick-checkmark"></span>
               </label>
               <div id="t-and-c-checkbox-error-msg-div"></div>
            </div>
            <div class="col-md-12 text-center" id="signature-error-msg-div"></div>
            <div class="col-md-5">
               <button class="save-btn" id="add-signature">Submit</button>
            </div>
         </div>
      </div>

      <!-- Successfull Submission Modal -->
      <div class="modal fade modal-support custom-modal" id="modal-successfull-submission" role="dialog">
         <div class="modal-dialog custom-modal-dialog-centered modal-sm bg-white">
            <div class="modal-content bg-white">
               <div class="modal-body">
                  <div class="row">
                     <div class="col-12 submitted-successfully-div">
                        <img src="<?php echo base_url()?>assets/images/success-submission.gif">
                        <span>Submit Successfully</span>
                     </div>
                     <div class="col-12">
                        <a class="save-btn d-block text-center"
                        <?php if (strtolower($candidate_details['document_uploaded_by']) == 'client') { ?>
                            href="<?php echo $this->config->item('client_url_for_redirecting_to_client_module'); ?>" 
                        <?php } else if (strtolower($candidate_details['document_uploaded_by']) == 'inputqc') { ?>
                           href="<?php echo $this->config->item('inputqc_url_for_redirecting_to_client_module'); ?>" 
                        <?php } else { ?>
                            href="<?php echo base_url(); ?>"
                        <?php } ?>
                        >Okay</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- Terms and Conditions Modal -->
      <div class="modal fade custom-modal" id="modal-terms-and-conditions" role="dialog">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <h2>Terms & Conditions</h2>
                     </div>
                     <div class="col-md-12">
                        <div class="long-description-div">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                         tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                         quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                         consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                         cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                         proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                         tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                         quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                         consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                         cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                         proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                         tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                         quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                         consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                         cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                         proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                         tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                         quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                         consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                         cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                         proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                         tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                         quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                         consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                         cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                         proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                         tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                         quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                         consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                         cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                         proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                     </div>
                     <div class="col-md-4"></div>
                     <div class="col-md-4">
                        <button class="save-btn" id="accept-terms-and-conditions-btn">
                           Accept
                        </button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
<div class="modal fade view-document-modal" id="myModal-show" role="dialog">
   <div class="modal-dialog modal-md modal-dialog-centered">
      <!-- modal-content-view-collection-category -->
      <div class="modal-content">
         <div class="modal-header border-0">
            <h3 id="">View Document</h4>
         </div>
         <div class="modal-body modal-body-edit-coupon">
            <div class="row"> 
               <div class="col-md-12 text-center view-img" id="view-img"></div>
            </div>
            <div class="row mt-3">
               <div class="col-md-6" id="setupDownloadBtn"></div>
               <div id="view-edit-cancel-btn-div" class="col-md-6 text-right">
                  <button class="btn btn-close-modal" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
   <script src="<?php echo base_url(); ?>assets/digital-signature/js/signature_pad.umd.js"></script>
   <script src="<?php echo base_url(); ?>assets/digital-signature/js/app.js"></script>
   <script>
      $('#terms-and-conditions-modal').on('click', function() {
         $('#modal-terms-and-conditions').modal('show');
      });

      $(document).ready(function() {
         $('#accept-terms-and-conditions-btn').on('click', function() {
            $('#customCheck1').prop('checked',true);
            $('#modal-terms-and-conditions').modal('hide');
         });
      });
   </script>

   <script type="text/javascript">
      var signature_drawn = 0,
         candidate_cv = [],
         client_document_size = 20000000,
         max_client_document_select = 1;

      $("#file1").on("change", handleFileSelect_candidate_cv);

      $("#pick-from-gallery").on("change", handleFileSelect_pick_from_gallery);

      $("#customCheck1").on("click", function() {
         check_t_and_c_checkbox();
      });

      function check_t_and_c_checkbox() {
         var checked = $("#customCheck1:checked").val();
         if (checked == '' || checked == null) {
            $("#t-and-c-checkbox-error-msg-div").html("<span class='text-danger error-msg-small d-block'>Please check the checkbox.</span>");
            return 0;
         } else {
            $("#t-and-c-checkbox-error-msg-div").html('');
            return 1;
         }
      }

      function handleFileSelect_candidate_cv(e) { 
         var files = e.target.files; 
         var filesArr = Array.prototype.slice.call(files);
         var j = 1; 
         if (files.length <= max_client_document_select) {
            $("#file1-error").html('');
            $(".file-name1").html('');
            if (files[0].size <= client_document_size) {
               $('#signature-error-msg-div').html('');
               $('#draw-signature-checkbox-btn-div').addClass('d-none');
               var html ='';
               for (var i = 0; i < files.length; i++) {
                  var fileName = files[i].name; // get file name 
                  if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
                     html = '<div id="file_candidate_cv_'+i+'"><span>'+fileName+' <a id="file_candidate_cv'+i+'" onclick="removeFile_candidate_cv('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_cv\')" ><i class="fa fa-eye"></i></a></span></div>';
                     // candidate_proof.push(files[i]); 
                     candidate_cv.push(files[i]);
                     $(".file-name1").append(html);
                  } 
               }
            } else {
               $('#draw-signature-checkbox-btn-div').removeClass('d-none');
               $("#file1-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
               $('#file1').val('');
            }
         } else {
            $('#draw-signature-checkbox-btn-div').removeClass('d-none');
            $("#file1-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
         }
      }

      function handleFileSelect_pick_from_gallery(e) { 
         var files = e.target.files; 
         var filesArr = Array.prototype.slice.call(files);
         var j = 1; 
         if (files.length <= max_client_document_select) {
            $("#file1-error").html('');
            $(".file-name1").html('');
            if (files[0].size <= client_document_size) {
               $('#draw-signature-checkbox-btn-div').addClass('d-none');
               $('#signature-error-msg-div').html('');
               var html ='';
               for (var i = 0; i < files.length; i++) {
                  var fileName = files[i].name; // get file name 
                  if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
                     html = '<div id="file_candidate_cv_'+i+'"><span>'+fileName+' <a id="file_candidate_pick_from_gallery'+i+'" onclick="removeFile_candidate_pick_from_gallery('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_cv\')" ><i class="fa fa-eye"></i></a></span></div>';
                     // candidate_proof.push(files[i]); 
                     candidate_cv.push(files[i]);
                     $(".file-name1").append(html);
                  } 
               }
            } else {
               $("#file1-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
               $('#file1').val('');
            }
         } else {
            $("#file1-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
         }
      }

      function removeFile_candidate_cv(id) {
         var file = $('#file_candidate_cv'+id).data("file");
         for(var i = 0; i < candidate_cv.length; i++) {
            if(candidate_cv[i].name === file) {
               candidate_cv.splice(i,1); 
            }
         }

         if (candidate_cv.length == 0) {
            $("#file1").val('');
            $('#draw-signature-checkbox-btn-div').removeClass('d-none');
         }
         $('#file_candidate_cv_'+id).remove(); 
      }

      function removeFile_candidate_pick_from_gallery(id) {
         var file = $('#file_candidate_pick_from_gallery'+id).data("file");
         for(var i = 0; i < candidate_cv.length; i++) {
            if(candidate_cv[i].name === file) {
               candidate_cv.splice(i,1); 
            }
         }

         if (candidate_cv.length == 0) {
            $("#pick-from-gallery").val('');
            $('#draw-signature-checkbox-btn-div').removeClass('d-none');
         }
         $('#file_candidate_cv_'+id).remove();
      }

      var savePNGButton = wrapper.querySelector("[data-action=save-png]");
      savePNGButton.addEventListener("click", function (event) {
         if (signaturePad.isEmpty()) {
            signature_drawn = 0;
            $("#warning-msg").html("<span class='text-danger'>Please provide a signature first.</span>");
         } else {
            var dataURL = signaturePad.toDataURL('image/png');
            var canvas_img_data = canvas.toDataURL();
            var img_data = dataURL.replace(/^data:image\/(png|jpg);base64,/, ""); 
            $.ajax({
               url: base_url+'candidate/save_signature',
               data: { img_data:img_data },
               type: 'post',
               dataType: 'json',
               success: function (response) {
                  $("#signature").val(response.file_name);
                  $("#customCheck1").attr('disabled',false);
                  $("#btn-action").hide();
                  $("#btn-operation").html('<button type="button" id="unlock" class="btn btn-success" data-action="save-png" onclick="enable_signature_upload_checkbox_btn()">Change</button>');
                  $("#btn-save-operation").hide();
                  $('#signature-error-msg-div').html('');
                  $('#upload-signature-checkbox-btn-div').addClass('d-none');
                  signature_drawn = 1;
               }
            });
         }
      });
   </script>

   <script>
      function change_signature(flag) {
         if (flag == '2') {
            $("#signature-pad-div").hide();
            $("#signature-upload-div").show();
         } else {
            $("#signature-pad-div").show();
            $("#signature-upload-div").hide();
         }
      }

      function enable_signature_upload_checkbox_btn() {
         location.reload();
         // $('#upload-signature-checkbox-btn-div').removeClass('d-none');
      }

      $("#add-signature").on('click',function() {
         var uploaded_signature = $("#file1")[0].files[0],
            checked = $("#customCheck1:checked").val();
             var signatures = $("#signature").val(); 
         if (checked != '' && checked != null &&
            (signature_drawn != 0 || (uploaded_signature != '' && uploaded_signature != undefined) || signatures !='')) {
            $("#t-and-c-checkbox-error-msg-div").html('');
            $("#signature-error-msg-div").html("<span class='text-warning'>Please wait we are submitting this data.</span>");
            $("#add-signature").attr('disabled',true);
            if (uploaded_signature != '' && uploaded_signature != undefined && candidate_cv.length > 0) {
               var formdata = new FormData();
               formdata.append('url',20);
               for (var i = 0; i < candidate_cv.length; i++) { 
                  formdata.append('cv_docs[]',candidate_cv[i]);
               }

               $.ajax({
                  type: "POST",
                  url: base_url+"candidate/update_candidate_image",
                  data:formdata,
                  dataType: 'json',
                  contentType: false,
                  processData: false,
                  success: function(data) {
                     if (data.status == '1') {
                        $("#signature").val(data.file_name);
                        save_uploaded_or_signed_signature();
                     } else {
                        toastr.error('Something went wrong while save this data. Please try again.');   
                     }
                     $("#warning-msg").html("");
                     $("#add-cv-check").html("Save")
                  }
               });
            } else {
               save_uploaded_or_signed_signature();
            }
         } else {
            if (signature_drawn == 0 && uploaded_signature == undefined) {
               $('#signature-error-msg-div').html('<span class="text-danger error-msg-small d-block mt-3">Please draw your signature or upload your signature</span>');
            } else {
               $('#signature-error-msg-div').html('');
            }

            if (checked == '' || checked == null) {
               $("#t-and-c-checkbox-error-msg-div").html("<span class='text-danger error-msg-small d-block'>Please check the checkbox.</span>");
            } else {
               $("#t-and-c-checkbox-error-msg-div").html('');
            }
         }
      });

      function save_uploaded_or_signed_signature() {
         var signatures = $("#signature").val();
         var uploaded_signature = $("#file1")[0].files[0],
            checked = $("#customCheck1:checked").val(); 
         if (checked != '' && checked != null && (signature_drawn != 0 || (uploaded_signature != '' && uploaded_signature != undefined) || signatures !='')) {
            $("#t-and-c-checkbox-error-msg-div").html('');
            $("#signature-error-msg-div").html("<span class='text-warning'>Please wait we are submitting this data.</span>");
            $("#add-signature").attr('disabled',true);
            var signature = $("#signature").val();
            $.ajax({
               url: base_url+'candidate/submit_final_data',
               data: { signature:signature },
               type: 'post',
               dataType: 'json',
               success: function (response) {
                  if (response.status == '1') {
                     $('#modal-successfull-submission').modal({backdrop: 'static', keyboard: false}) 
                  } else {
                     toastr.error('Something went wrong while save this data. Please try again.');
                  }
                  $("#signature-error-msg-div").html("");
                  $("#add-signature").attr('disabled',false)
               }
            });
         } else {
            if (signature_drawn == 0 && uploaded_signature == undefined) {
               if (signatures =='') {

               $('#signature-error-msg-div').html('<span class="text-danger error-msg-small d-block mt-3">Please draw your signature or upload your signature</span>');
               }
            } else {
               $('#signature-error-msg-div').html('');
            }

            if (checked == '' || checked == null) {
               $("#t-and-c-checkbox-error-msg-div").html("<span class='text-danger error-msg-small d-block'>Please check the checkbox.</span>");
            } else {
               $("#t-and-c-checkbox-error-msg-div").html('');
            }
         }
      }

      
function view_image(id,text){
   $("#myModal-show").modal('show');
    var file = $('#file_'+text+id).data("file");  
       var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_cv[id]);
}

   </script>