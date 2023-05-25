<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-consent-form';
   }
</script>

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/digital-signature/css/signature-pad.css">
   <!--Page Content-->
   <!-- <form> -->
        <style>
        .pg-txt-cntr {
          margin-top: 300px;
        }
        .modal-sm{width: 36%; margin-top: 14%; }
        .modal-title{text-align: center; margin-top: 20px; color: #3C0A64; font-weight: bold; font-size: 22px; }
        .modal-header{border-bottom: 0px !important; }
        .modal-footer{border-top: 0px !important; }
        .modal-body img{    margin-bottom: 20px;
    width: 21%;
    margin-left: 39%;
}
    </style>
   <div class="pg-cnt pt-3">
      <div class="pg-txt-cntr">
        <!-- <h6 class="employ">Employment Screening Consent</h6>
        <p class="quie">Quiere la boca exhausta vid, kiwi, piña y fugaz jamón. Fabio me exige, sin tapujos, que añada cerveza al whisky. Jovencillo emponzoñado de whisky, ¡qué figurota exhibes! La cigüeña tocaba cada vez mejor el saxofón y el búho pedía kiwi y queso. El jefe buscó el éxtasis en un imprevisto baño de whisky y gozó como un duque. Exhíbanse politiquillos zafios, con orejas kilométricas y uñas de gavilán. El cadáver de Wamba, rey godo de España, fue exhumado y trasladado en una caja de zinc que pesó un kilo. El pingüino Wenceslao hizo kilómetros bajo exhaustiva lluvia y frío, añoraba a su querido cachorro. El veloz murciélago hindú comía feliz cardillo y kiwi. La cigüeña tocaba el saxofón detrás del palenque de paja. Quiere la boca exhausta vid, kiwi, piña y fugaz jamón. Fabio me exige, sin tapujos, que añada cerveza al whisky. Jovencillo emponzoñado de whisky, ¡qué figurota exhibes! La cigüeña tocaba cada vez mejor el saxofón y el búho pedía kiwi y queso. El jefe buscó el éxtasis en un imprevisto baño de whisky y gozó como un duque. Exhíbanse politiquillos zafios, con orejas kilométricas y uñas de gavilán. El cadáver de Wamba, rey godo de España, fue exhumado y trasladado en una caja de zinc que pesó un kilo. El pingüino Wenceslao hizo kilómetros bajo exhaustiva lluvia y frío, añoraba a su querido cachorro. El veloz murciélago hindú comía feliz cardillo y kiwi. La cigüeña tocaba el saxofón detrás del palenque de paja.Quiere la boca exhausta vid, kiwi, piña y fugaz jamón. Fabio me exige, sin tapujos, que añada cerveza al whisky. Jovencillo emponzoñado de whisky, ¡qué figurota exhibes! La cigüeña tocaba cada vez mejor el saxofón y el búho pedía kiwi y queso</p>  -->
        <span class="d-block">
          <?php 
          $fs_logo = $this->db->where('client_id',$candidate_details['client_id'])->get('custom_logo')->row_array();
             if (isset($fs_logo['consent']) && !empty($fs_logo['consent'])) {
               $candidate_concent =  str_replace('@candidate_first_name',$candidate_details['title'].' '.ucfirst($candidate_details['first_name']),$fs_logo['consent']);

               $candidate_concent = str_replace('@candidate_father_name',ucfirst($candidate_details['father_name']),$candidate_concent);
               $candidate_concent = str_replace('@candidate_last_name',ucfirst($candidate_details['last_name']),$candidate_concent);
               echo str_replace('@client_name',ucfirst($client_details['client_name']),$candidate_concent);
             }else{
          ?>
          <p>I, <?php echo $candidate_details['title'].' '.ucfirst($candidate_details['first_name']).' '.ucfirst($candidate_details['father_name']).' '.ucfirst($candidate_details['last_name']);?>, hereby authorize, <?php echo ucfirst($client_details['client_name']);?> and/or its agents (FactSuite) to make an independent investigation of my background, references, past employment, education, credit history, criminal or police records, and motor vehicle records including those maintained by both public and private organizations and all public records for the purpose of confirming the information contained on my Application and/or obtaining other information which may be material to my qualifications for service now and, if applicable, during the tenure of my employment or service with <?php echo ucfirst($client_details['client_name']);?></p>  

          <p>I release <?php echo ucfirst($client_details['client_name']);?> and its agents and any person or entity, which provides information pursuant to this authorization, from any and all liabilities, claims or law suits in regard to the information obtained from any and all of the above referenced sources used. The following is my true and complete legal name and all information is true and correct to the best of my knowledge.</p>
          <?php 
            }
          ?>
        </span>
        <div class="row">
          <div class="col-md-12">
            <?php 
            $upload_signature_checked = 'checked';
              if ($candidate_details['document_uploaded_by'] != 'client') {
                $upload_signature_checked = '';
            ?>
              <input type="radio" checked onchange="change_signature(1)" name="radio-select-sign" id="select-signature-pad" value="1"><label for="select-signature-pad">Signature Pad</label>
            <?php } ?>
            <input type="radio" <?php echo $upload_signature_checked;?> onchange="change_signature(2)" name="radio-select-sign" value="2" id="select-upload-signature">
            <label for="select-upload-signature">Upload Signature</label> 
          </div>
        </div>
            <div class="row mt-2">
              <?php 
              $upload_signature_style = '';
                if ($candidate_details['document_uploaded_by'] != 'client') {
                  $upload_signature_style = 'display:none;';
              ?>
                <div class="col-md-6" id="signature-pad-div">
                  <div id="signature-pad" class="signature-pad">
                    <h5 style="color:#000;">Signature </h5>
                    <div class="signature-pad--body">
                      <canvas></canvas>
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
                          <!--  <button type="button" class="btn btn-success save" data-action="save-jpg">Save as JPG</button>
                           <button type="button" class="btn btn-success save" data-action="save-svg">Save as SVG</button> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
              <input type="hidden" id="signature" name="">
              <div class="col-md-5" style="<?php echo $upload_signature_style;?>" id="signature-upload-div">
                <div id="fls">
                  <div class="form-group files">
                    <input type="hidden" name="cv_id" value="<?php echo isset($cv_data['cv_id'])?$cv_data['cv_id']:''; ?>" id="cv_id">
                    <label class="btn" for="file1"><a class="fl-btn">Browse file</a></label>
                    <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" >
                    <div class="file-name1"></div>  
                    <div id="file1-error"></div>
                  </div>
                </div>
                <div class="text-right">
                  <button id="add-cv-check" class="pg-submit-btn">Save</button>
                </div>
              </div>
         </div>

         <div class="row">
          <div class="col-md-12 text-center" id="signature-error-msg-div"></div>
          <div class="col-md-12 text-right">
             <div class="custom-control custom-checkbox custom-control-inline mrg-btm mb-0">
                <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck1">
                <label class="custom-control-label pt-1" for="customCheck1">I Accept the terms and conditions</label>
             </div>
          </div>
          <div class="col-md-12 text-right" id="warning-msg"></div>
         </div>
        
         <div class="row">
          
            <div class="col-md-12">
               <div class="pg-submit">
                  <!-- <button onclick="add_signature()" class="pg-submit-btn">SUBMIT</button> -->
                  <button id="add-signature" class="pg-submit-btn" >Submit</button>
                   <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal-show">Open Small Modal</button> -->
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- </form> -->
   <!--Page Content-->
   <div class="clr"></div>
</section>

<script src="<?php echo base_url(); ?>assets/digital-signature/js/signature_pad.umd.js"></script>
<script src="<?php echo base_url(); ?>assets/digital-signature/js/app.js"></script> 

<script type="text/javascript">
  var signature_drawn = 0;
  var savePNGButton = wrapper.querySelector("[data-action=save-png]");
  savePNGButton.addEventListener("click", function (event) {
    if (signaturePad.isEmpty()) {
      signature_drawn = 0;
      // alert("Please provide a signature first.");
      $("#warning-msg").html("<span class='text-danger'>Please provide a signature first.</span>");
    } else {
      var dataURL = signaturePad.toDataURL('image/png');
      // download(dataURL, "signature.png");

      var canvas_img_data = canvas.toDataURL();
      var img_data = dataURL.replace(/^data:image\/(png|jpg);base64,/, ""); 
      $.ajax({
        url: base_url+'candidate/save_signature',
        data: { img_data:img_data },
        type: 'post',
        dataType: 'json',
        success: function (response) { 
          $("#signature").val(response.file_name);
          /*$(".save").attr('disabled',true);
          $(".save").css('pointer','none');*/
          $("#customCheck1").attr('disabled',false);
          $("#btn-action").hide();
          // $(".save").html("Locked")
          $("#btn-operation").html('<button type="button" id="unlock" class="btn btn-success" data-action="save-png">Unlock</button>');
          $("#btn-save-operation").hide();
          $('#signature-error-msg-div').html('');
          signature_drawn = 1;
        }
      });
    }
  });

  // $("#btn-operation").on('click','#unlock',function() {
  //   $("#signature").val(''); 
  //   $("#customCheck1").attr('disabled',true);
  //   $("#btn-action").show(); 
  //   $("#btn-operation").html('')
  //   $("#btn-save-operation").show();
  // });

  function change_signature(flag){
    if (flag =='2') {
      $("#signature-pad-div").hide();
      $("#signature-upload-div").show();
    }else{
       $("#signature-pad-div").show();
      $("#signature-upload-div").hide();
    }
  }
</script>

<script>
  $("#add-signature").on('click',function() {
    // alert(signature_drawn);
    var uploaded_signature = $("#file1")[0].files[0];
    // $('#myModal-show').modal('show');
    /* var modal = document.getElementById("myModal-show");
     modal.style.display = "block";*/
    var checked = $("#customCheck1:checked").val();
    if (checked != '' && checked != null && (signature_drawn != 0 || uploaded_signature != undefined)) {
      $('#signature-error-msg-div').html('');
      $("#warning-msg").html('');
      $("#warning-msg").html("<span class='text-warning'>Please wait we are submitting this data.</span>");
      $("#add-signature").attr('disabled',true)
      var signature = $("#signature").val();
      $.ajax({
        url: base_url+'candidate/submit_final_data',
        data: { signature:signature },
        type: 'post',
        dataType: 'json',
        success: function (response) {
          if (response.status == '1') {
            toastr.success('successfully saved data.'); 
            $('#myModal-show').modal({backdrop: 'static', keyboard: false}) 
          } else {
            toastr.error('Something went wrong while save this data. Please try again.');   
          }
          $("#warning-msg").html("&nbsp;");
          $("#add-signature").attr('disabled',false)
        }
      });
    } else {
      if (signature_drawn == 0 && uploaded_signature == undefined) {
        $('#signature-error-msg-div').html('<span class="text-danger error-msg-small d-block mt-3">Please draw your signature or upload your signature</span>');
      } else {
        $('#signature-error-msg-div').html('');
      }

      if (checked != '' || checked != null) {
        $("#warning-msg").html("<span class='text-danger error-msg-small d-block mb-3'>Please check the checkbox.</span>");
      } else {
        $("#warning-msg").html('');
      }
    }
  });
</script>

<!-- Modal -->
<div class="modal fade " id="myModal-show" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Thank you for Submitting the details</h4>
      </div>
      <div class="modal-body">
       <img src="<?php echo base_url(); ?>assets/component.svg" alt="">
      </div>
      <div class="modal-footer">
        <div class="header-mn text-center">
            <button class="saved-btn d-none"><i class="fa fa-check"></i> Done</button>
            <a 
              <?php if ($this->session->userdata('candidate_details_submitted_by') != '') { ?>    
                href="<?php echo $this->config->item('client_url_for_redirecting_to_client_module'); ?>" 
              <?php } else { ?>
                href="<?php echo base_url(); ?>"
              <?php } ?>
            class="exit-btn float-center text-center">Done !</a>
         </div>
      </div>
    </div>
  </div>
</div>

<script>          
  var candidate_cv =[]; 
  var client_document_size = 20000000;
  var max_client_document_select = 1;
  $("#file1").on("change", handleFileSelect_candidate_cv);

  function handleFileSelect_candidate_cv(e) { 
    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files);
    var j = 1; 
    if (files.length <= max_client_document_select) {
      $("#file1-error").html('');
      $(".file-name1").html('');
      if (files[0].size <= client_document_size) {
        $('#signature-error-msg-div').html('');
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
    }
    $('#file_candidate_cv_'+id).remove(); 
  }

  function view_image(id,text) {
    $("#myModal-show1").modal('show');
    var file = $('#file_'+text+id).data("file");  
    var reader = new FileReader();
    reader.onload = function(event) {
      $("#view-img").html("<img src='"+event.target.result+"'>");
    };
    reader.readAsDataURL(candidate_cv[id]);
  }

  function exist_view_image(image,path) {
    $("#myModal-show").modal('show'); 
    $("#view-img").html("<img src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
  }

  $("#add-cv-check").on('click',function() {
    $("#file1-error").html('');
    var formdata = new FormData();
    formdata.append('url',20);
    /*formdata.append('address',address);
    formdata.append('pincode',pincode);
    formdata.append('city',city);
    formdata.append('state',state);*/
    if (candidate_cv.length > 0) {
      for (var i = 0; i < candidate_cv.length; i++) { 
        formdata.append('cv_docs[]',candidate_cv[i]);
      }
    } else {
      formdata.append('cv_docs[]','');
    }  

    // $("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>"); 
    if ( candidate_cv.length > 0) {
      $("#add-cv-check").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
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
            /*$(".save").attr('disabled',true);
            $(".save").css('pointer','none');*/
            $("#customCheck1").attr('disabled',false);
          } else {
            toastr.error('Something went wrong while save this data. Please try again.');   
          }
          $("#warning-msg").html("");
          $("#add-cv-check").html("Save")
        }
      });
    } else {
      if (candidate_cv.length == 0 && cv_doc =='') { 
        $("#file1-error").html('<span class="text-danger error-msg-small">Please select a min '+1+' file</span>');
      } 
    }
  });
</script>

  <div class="modal fade " id="myModal-show1" role="dialog">
 <div class="modal-dialog modal-lg modal-dialog-centered">
      <!-- modal-content-view-collection-category -->
      <div class="modal-content">
        <div class="modal-header border-0">
          <h3 id="">View Document</h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2"> 
         <div class="col-md-12 text-center" id="view-img"></div>
    </div>
          <div class="row p-5 mt-2">
              <div class="col-md-6" id="setupDownloadBtn">
                
              </div>
              <div id="view-edit-cancel-btn-div" class="col-md-6  text-right">
                <button class="btn bg-blu text-white exit-btn" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
        <!-- <div class="modal-footer border-0"></div> -->
      </div>
    </div>
</div>