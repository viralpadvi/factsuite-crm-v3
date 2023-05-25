var candidate_aadhar = [];
var max_client_document_select = 20;
var client_document_size = 200000000;
var candidate_pan = [];
var candidate_proof = [];

$("#aadhar-client-documents").on("change", handleFileSelect_candidate_aadhar); 
$("#pan-client-documents").on("change", handleFileSelect_candidate_pan); 
$("#client-documents").on("change", handleFileSelect_candidate_proof); 


function handleFileSelect_candidate_aadhar(e){ 
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#aadhar-selected-vendor-docs-li").html('');
        $("#aadhar-client-upoad-docs-error-msg-div").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="aadhar-file_candidate_aadhar_'+i+'"><span>'+fileName+' <a id="aadhar-file_candidate_aadhar'+i+'" onclick="removeFile_candidate_aadhar('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_aadhar\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                candidate_aadhar.push(files[i]);
	                $("#aadhar-client-upoad-docs-error-msg-div").append(html);
	        	} 
	        }
	    } else {
	    	$("#aadhar-selected-vendor-docs-li").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#aadhar-client-documents').val('');
	    }
    } else {
        $("#aadhar-selected-vendor-docs-li").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_candidate_aadhar(id) {

    var file = $('#aadhar-file_candidate_aadhar'+id).data("file");
    for(var i = 0; i < candidate_aadhar.length; i++) {
        if(candidate_aadhar[i].name === file) {
            candidate_aadhar.splice(i,1); 
        }
    }
    if (candidate_aadhar.length == 0) {
    	$("#aadhar-client-documents").val('');
    }
    $('#aadhar-file_candidate_aadhar_'+id).remove(); 
}



function handleFileSelect_candidate_proof(e){ 
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#selected-vendor-docs-li").html('');
        $("#client-upoad-docs-error-msg-div").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_aadhar_'+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+i+'" onclick="removeFile_candidate_proof('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_proof\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                candidate_proof.push(files[i]);
	                $("#client-upoad-docs-error-msg-div").append(html);
	        	} 
	        }
	    } else {
	    	$("#selected-vendor-docs-li").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#client-documents').val('');
	    }
    } else {
        $("#selected-vendor-docs-li").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_candidate_proof(id) {

    var file = $('#file_candidate_aadhar'+id).data("file");
    for(var i = 0; i < candidate_proof.length; i++) {
        if(candidate_proof[i].name === file) {
            candidate_proof.splice(i,1); 
        }
    }
    if (candidate_proof.length == 0) {
    	$("#client-documents").val('');
    }
    $('#file_candidate_aadhar_'+id).remove(); 
}

   
function handleFileSelect_candidate_pan(e){ 
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#pan-selected-vendor-docs-li").html('');
        $("#pan-client-upoad-docs-error-msg-div").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="pan-file_candidate_aadhar_'+i+'"><span>'+fileName+' <a id="pan-file_candidate_aadhar'+i+'" onclick="removeFile_candidate_pan('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_pan\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                candidate_pan.push(files[i]);
	                $("#pan-client-upoad-docs-error-msg-div").append(html);
	        	} 
	        }
	    } else {
	    	$("#pan-selected-vendor-docs-li").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#pan-client-documents').val('');
	    }
    } else {
        $("#pan-selected-vendor-docs-li").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_candidate_pan(id) {

    var file = $('#pan-file_candidate_aadhar'+id).data("file");
    for(var i = 0; i < candidate_pan.length; i++) {
        if(candidate_pan[i].name === file) {
            candidate_pan.splice(i,1); 
        }
    }
    if (candidate_pan.length == 0) {
    	$("#pan-client-documents").val('');
    }
    $('#pan-file_candidate_aadhar_'+id).remove(); 
}


function view_image(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };

        if (text =='candidate_pan') {
        reader.readAsDataURL(candidate_pan[id]);
        }else if(text =='candidate_aadhar'){ 
        reader.readAsDataURL(candidate_aadhar[id]);
        }else{
        reader.readAsDataURL(candidate_proof[id]);
        }
}
function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}



$('#confirm-update').click(function(){
	$('#conformtionGlobalDb').modal('show');
});

$('#submit-doc-data').on('click',function(){

	$('#wait-message').html('Please,Wait we are updateg your data.')
 	$('#submit-doc-data').attr('disabled',true);
 	$('#doc-cancle').attr('disabled',true);
 	$('#submit-doc-data').addClass('buttonload');
 	$('#submit-doc-data').html('<i class="fa fa-circle-o-notch fa-spin"></i> Loading');
 	// $('#submit-doc-data').addClass('buttonload'); bbbbbb

 	// return false;
  	var address = $('#address').val();
  	var city = $('#city').val();
  	var state = $('#state').val();
  	var pincode = $('#pincode').val();   	
  	var in_progress_remark = $('#in_progress_remark').val();   	
  	var verification_remarks = $('#verification_remarks').val();
  	var insuff_remarks = $('#insuff_remarks').val();
  	var insuff_closer_remark = $('#insuff_closer_remark').val();
  	var candidate_id_hidden = $('#candidate_id_hidden').val();
  	var action_status = $('#action_status').val();

  	var pan_address = $('#pan-address').val();
  	var pan_city = $('#pan-city').val();
  	var pan_state = $('#pan-state').val();
  	var pan_pincode = $('#pan-pincode').val();   	
  	var pan_in_progress_remark = $('#pan-in_progress_remark').val();   	
  	var pan_verification_remarks = $('#pan-verification_remarks').val();
  	var pan_insuff_remarks = $('#pan-insuff_remarks').val();
  	var pan_insuff_closer_remark = $('#pan-insuff_closer_remark').val();
  	var pan_candidate_id_hidden = $('#pan-candidate_id_hidden').val(); 

  	var aadhar_address = $('#aadhar-address').val();
  	var aadhar_city = $('#aadhar-city').val();
  	var aadhar_state = $('#aadhar-state').val();
  	var aadhar_pincode = $('#aadhar-pincode').val();   	
  	var aadhar_in_progress_remark = $('#aadhar-in_progress_remark').val();   	
  	var aadhar_verification_remarks = $('#aadhar-verification_remarks').val();
  	var aadhar_insuff_remarks = $('#aadhar-insuff_remarks').val();
  	var aadhar_insuff_closer_remark = $('#aadhar-insuff_closer_remark').val();
  	var aadhar_candidate_id_hidden = $('#aadhar-candidate_id_hidden').val(); 
  	
	var userID = $("#userID").val();
	var userRole = $("#userRole").val();
	var formdata = new FormData();
	formdata.append('userID',userID);
	formdata.append('userRole',userRole);
	formdata.append('address',address);
	formdata.append('city',city);
	formdata.append('state',state);
	formdata.append('pincode',pincode);
	formdata.append('in_progress_remark',in_progress_remark);
	formdata.append('verification_remarks',verification_remarks);
	formdata.append('insuff_remarks',insuff_remarks);
	formdata.append('insuff_closer_remark',insuff_closer_remark);
	formdata.append('candidate_id',candidate_id_hidden);
	formdata.append('action_status',action_status);

	if (pan_address !='' && pan_address !=null) {
	formdata.append('pan_address',pan_address);
	formdata.append('pan_city',pan_city);
	formdata.append('pan_state',pan_state);
	formdata.append('pan_pincode',pan_pincode);
	formdata.append('pan_in_progress_remark',pan_in_progress_remark);
	formdata.append('pan_verification_remarks',pan_verification_remarks);
	formdata.append('pan_insuff_remarks',pan_insuff_remarks);
	formdata.append('pan_insuff_closer_remark',pan_insuff_closer_remark);
	}

	if (aadhar_address !='' && aadhar_address !=null) {
	formdata.append('aadhar_address',aadhar_address);
	formdata.append('aadhar_city',aadhar_city);
	formdata.append('aadhar_state',aadhar_state);
	formdata.append('aadhar_pincode',aadhar_pincode);
	formdata.append('aadhar_in_progress_remark',aadhar_in_progress_remark);
	formdata.append('aadhar_verification_remarks',aadhar_verification_remarks);
	formdata.append('aadhar_insuff_remarks',aadhar_insuff_remarks);
	formdata.append('aadhar_insuff_closer_remark',aadhar_insuff_closer_remark);
	}

	var op_action_status = $('#op_action_status').val();
	if(op_action_status == null || op_action_status == ''){
		formdata.append('op_action_status','0')	
	}else{
		formdata.append('op_action_status',op_action_status)
	}
 
	var candidate_id_hidden = $('#candidate_id_hidden').val()
	formdata.append('candidate_id',candidate_id_hidden);
 	
	if (candidate_proof.length > 0) {
		for (var i = 0; i < candidate_proof.length; i++) { 
			formdata.append('approved_doc[]',candidate_proof[i]);
		}
	}else{
		formdata.append('approved_doc[]','');
	} 

	if (candidate_aadhar.length > 0) {
		for (var i = 0; i < candidate_aadhar.length; i++) { 
			formdata.append('candidate_aadhar[]',candidate_aadhar[i]);
		}
	}else{
		formdata.append('candidate_aadhar[]','');
	} 
	
	if (candidate_pan.length > 0) {
		for (var i = 0; i < candidate_pan.length; i++) { 
			formdata.append('candidate_pan[]',candidate_pan[i]);
		}
	}else{
		formdata.append('candidate_pan[]','');
	} 
	 

	$.ajax({
        type: "POST",
          url: base_url+"analyst/remarkForDocuemtCheck",
          data:formdata,
          dataType: 'json',
          contentType: false,
          processData: false,
          success: function(data) {
          	$('#submit-doc-data').attr('disabled',false);
          	$('#doc-cancle').attr('disabled',false);
          	$('#submit-doc-data').removeClass('buttonload');
 			$('#submit-doc-data').html('Confirm');
          	$('#conformtionGlobalDb').modal('hide');
			if (data.status == '1') {
				toastr.success('successfully saved data.');
				$('.is-valid').removeClass('is-valid');   
          	}else{
          		toastr.error('Something went wrong while save this data. Please try again.'); 	
          	}
          	$("#warning-msg").html("");
          }
        });
});

function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}


function remove_form(){
	$("#form").remove();
}


function valid_pincode(id=''){ 
	var pincode = $("#"+id).val();
	if (pincode !='') {
		if (isNaN(pincode)) {
			$("#"+id+"-error").html('<span class="text-danger error-msg-small">pin code should be only numbers.</span>');
			$("#"+id).val(pincode.slice(0,-1));
			// input_is_invalid("#"+id);
		} else if (pincode.length != 6) {
			$("#"+id+"-error").html('<span class="text-danger error-msg-small">pin code should be of '+6+' digits.</span>');
			plenght = $("#"+id).val(pincode.slice(0,6));
			// input_is_invalid("#"+id);
			if (plenght.length == 6) {
			$("#"+id+"-error").html('&nbsp;');
			// input_is_valid("#"+id);	
			}
		} else {
			$("#"+id+"-error").html('&nbsp;');
			// input_is_valid("#"+id);
		} 
	}else{
		$("#"+id+"-error").html("<span class='text-danger error-msg-small'>Please Enter Valid pincode</span>");
		// input_is_invalid("#"+id)
	}
} 

/*
$("#address").on('keyup blur',valid_address); 
$("#pincode").on('keyup blur',valid_pincode);
$("#city").on('keyup blur',valid_city);
$("#state").on('keyup blur',valid_state);

$("#staying_with").on('keyup blur', valid_staying_with);
$("#initiated_date").on('keyup blur', valid_initiated_date);
$("#verifier_name").on('keyup blur', valid_verifier_name);
$("#period_of_stay").on('keyup blur', valid_period_of_stay);
$("#progress_remarks").on('keyup blur', valid_progress_remarks);
$("#infuff_remarks").on('keyup blur', valid_infuff_remarks);
$("#assigned_to_vendor").on('keyup blur', valid_assigned_to_vendor);
$("#closure_date").on('keyup blur', valid_closure_date);
$("#relationship").on('keyup blur', valid_relationship);
$("#property_type").on('keyup blur', valid_property_type);
$("#verification_remarks").on('keyup blur', valid_verification_remarks);
$("#closure_remarks").on('keyup blur', valid_closure_remarks);
*/
function valid_address(id){
	var address = $("#address"+id).val();
	if (address !='') {
		$("#address-error"+id).html("&nbsp;");
		input_is_valid("#address"+id)
	}else{
		input_is_invalid("#address"+id)
		$("#address-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid address</span>");
	}
}
 
function valid_city(id){
	var city = $("#city"+id).val();
	if (city !='') {
		$("#city-error"+id).html("&nbsp;");
		input_is_valid("#city"+id)
	}else{
		$("#city-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid city</span>");
		input_is_invalid("#city"+id)
	}
}
function valid_state(id){
	var state = $("#state"+id).val();
	if (state !='') {
		$("#state-error"+id).html("&nbsp;");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid state</span>");
		input_is_invalid("#state"+id)
	}
}


function valid_staying_with(id){
	var staying_with = $("#staying_with"+id).val();
	if (staying_with !='') {
		$("#staying_with-error"+id).html("&nbsp;");
		input_is_valid("#staying_with"+id)
	}else{
		$("#staying_with-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Staying With</span>");
		input_is_invalid("#staying_with"+id)
	}	
}
function valid_initiated_date(id){
	var initiated_date = $("#initiated_date"+id).val();
	if (initiated_date !='') {
		$("#initiated_date-error"+id).html("&nbsp;");
		input_is_valid("#initiated_date"+id)
	}else{
		$("#initiated_date-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Initiated Date</span>");
		input_is_invalid("#initiated_date"+id)
	}	
}
function valid_verifier_name(id){
	var verifier_name = $("#verifier_name"+id).val();
	if (verifier_name !='') {
		$("#verifier_name-error"+id).html("&nbsp;");
		input_is_valid("#verifier_name"+id)
	}else{
		$("#verifier_name-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Verifier Name</span>");
		input_is_invalid("#verifier_name"+id)
	}	
}
function valid_period_of_stay(id){
	var period_of_stay = $("#period_of_stay"+id).val();
	if (period_of_stay !='') {
		$("#period_of_stay-error"+id).html("&nbsp;");
		input_is_valid("#period_of_stay"+id)
	}else{
		$("#period_of_stay-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Period Of Period Of Stay</span>");
		input_is_invalid("#period_of_stay"+id)
	}	
}
function valid_progress_remarks(id){
	var progress_remarks = $("#progress_remarks"+id).val();
	if (progress_remarks !='') {
		$("#progress_remarks-error"+id).html("&nbsp;");
		input_is_valid("#progress_remarks"+id)
	}else{
		$("#progress_remarks-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Progress Remarks</span>");
		input_is_invalid("#progress_remarks"+id)
	}	
}
function valid_infuff_remarks(id){
	var infuff_remarks = $("#infuff_remarks"+id).val();
	if (infuff_remarks !='') {
		$("#infuff_remarks-error"+id).html("&nbsp;");
		input_is_valid("#infuff_remarks"+id)
	}else{
		$("#infuff_remarks-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Insuff Remarks</span>");
		input_is_invalid("#infuff_remarks"+id)
	}	
}
function valid_assigned_to_vendor(id){
	var assigned_to_vendor = $("#assigned_to_vendor"+id).val();
	if (assigned_to_vendor !='') {
		$("#assigned_to_vendor-error"+id).html("&nbsp;");
		input_is_valid("#assigned_to_vendor"+id)
	}else{
		$("#assigned_to_vendor-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Assigned Of Vendor</span>");
		input_is_invalid("#assigned_to_vendor"+id)
	}	
}
function valid_closure_date(id){
	var closure_date = $("#closure_date"+id).val();
	if (closure_date !='') {
		$("#closure_date-error"+id).html("&nbsp;");
		input_is_valid("#closure_date"+id)
	}else{
		$("#closure_date-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Closure Date</span>");
		input_is_invalid("#closure_date"+id)
	}
}
function valid_relationship(id){
		var relationship = $("#relationship"+id).val();
	if (relationship !='') {
		$("#relationship-error"+id).html("&nbsp;");
		input_is_valid("#relationship"+id)
	}else{
		$("#relationship-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Relationship</span>");
		input_is_invalid("#relationship"+id)
	}
}
function valid_property_type(id){
	var property_type = $("#property_type"+id).val();
	if (property_type !='') {
		$("#property_type-error"+id).html("&nbsp;");
		input_is_valid("#property_type"+id)
	}else{
		$("#property_type-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Property Type</span>");
		input_is_invalid("#property_type"+id)
	}	
}
function valid_verification_remarks(id){
	var verification_remarks = $("#verification_remarks"+id).val();
	if (verification_remarks !='') {
		$("#verification_remarks-error"+id).html("&nbsp;");
		input_is_valid("#verification_remarks"+id)
	}else{
		$("#verification_remarks-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Verification Remarks</span>");
		input_is_invalid("#verification_remarks"+id)
	}	
}
function valid_closure_remarks(id){
	var closure_remarks = $("#closure_remarks"+id).val();
	if (closure_remarks !='') {
		$("#closure_remarks-error"+id).html("&nbsp;");
		input_is_valid("#closure_remarks"+id)
	}else{
		$("#closure_remarks-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Closure Remarks</span>");
		input_is_invalid("#closure_remarks"+id)
	}	
}