var candidate_aadhar = [];
var max_client_document_select = 20;
var client_document_size = 200000000;
var candidate_pan = [];
var candidate_proof = [];

$("#client-documents").on("change", handleFileSelect_candidate_aadhar);   


function handleFileSelect_candidate_aadhar(e){ 
	candidate_aadhar = [];
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
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf|doc|docx|xlsx|xls)$/i).test(fileName)) {
	            	 html = '<div id="aadhar-file_candidate_aadhar_'+i+'"><span>'+fileName+' <a id="aadhar-file_candidate_aadhar'+i+'" onclick="removeFile_candidate_aadhar('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_aadhar\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                candidate_aadhar.push(files[i]);
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

function removeFile_candidate_aadhar(id) {

    var file = $('#aadhar-file_candidate_aadhar'+id).data("file");
    for(var i = 0; i < candidate_aadhar.length; i++) {
        if(candidate_aadhar[i].name === file) {
            candidate_aadhar.splice(i,1); 
        }
    }
    if (candidate_aadhar.length == 0) {
    	$("#client-documents").val('');
    }
    $('#aadhar-file_candidate_aadhar_'+id).remove(); 
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
// function exist_view_image(image,path){
// 	$("#myModal-show").modal('show'); 
//    $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
// }



$('#confirm-update').click(function(){
	$('#conformtionGlobalDb').modal('show');
});

var candidateInfo
function phpData(phpData){ 
	candidateInfo = phpData;
	// console.log(JSON.stringify(candidateInfo));
}

$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#conformtionGlobalDb").hasClass('show')){  
		var key = e.which;
	    if (key == 13) {
	      	documentCheck();
	      	return false;
	    }
	}
});


$('#submit-doc-data').on('click',function(){

	documentCheck()

});

function documentCheck(){
	$('#wait-message').html('Please,Wait we are updateg your data.')
 	$('#submit-doc-data').attr('disabled',true);
 	$('#doc-cancle').attr('disabled',true);
 	$('#submit-doc-data').addClass('buttonload');
 	$('#submit-doc-data').html('<i class="fa fa-circle-o-notch fa-spin"></i> Loading');
 	// $('#submit-doc-data').addClass('buttonload'); bbbbbb

 	// return false;
 	var index = $('#componentIndex').val()
	var priority = $('#priority').val()
	var document_check_id = $('#document_check_id').val()
	// av = analyst value
	// address_av = address analyst value 
  	var address_av = $('#address').val();
  	if(candidateInfo['remark_address'] != null){
		var address = candidateInfo['remark_address'].split(',');
		address = JSON.parse(address)
	}else{
		var address = []
	}
	if (address_av !='' && address_av !=null) {
		var obj = {}
		obj['remark_address'] = address_av
		address[index] = obj
		// alert(JSON.stringify(address))
			 
	} 

  	var city_av = $('#city').val();
  	if(candidateInfo['remark_city'] != null){
		var city = candidateInfo['remark_city'].split(',');
		city = JSON.parse(city)
	}else{
		var city = []
	}
	if (city_av !='' && city_av !=null) {
		var obj = {}
		obj['remark_city'] = city_av
		city[index] = obj
		// alert(JSON.stringify(city))
			 
	}

  	var state_av = $('#state').val();
  	if(candidateInfo['remark_state'] != null){
		var state = candidateInfo['remark_state'].split(',');
		state = JSON.parse(state)
	}else{
		var state = []
	}
	if (state_av !='' && state_av !=null) {
		var obj = {}
		obj['remark_state'] = state_av
		state[index] = obj
		// alert(JSON.stringify(state))
			 
	}

  	var pincode_av = $('#pincode').val();
  	if(candidateInfo['remark_pin_code'] != null){
		var pincode = candidateInfo['remark_pin_code'].split(',');
		pincode = JSON.parse(pincode)
	}else{
		var pincode = []
	}
	if (pincode_av !='' && pincode_av !=null) {
		var obj = {}
		obj['remark_pin_code'] = pincode_av
		pincode[index] = obj
		// alert(JSON.stringify(pincode))
			 
	}  	

  	var in_progress_remark_av = $('#in_progress_remark').val(); 
  	if(candidateInfo['in_progress_remarks'] != null){
		var in_progress_remark = candidateInfo['in_progress_remarks'].split(',');
		in_progress_remark = JSON.parse(in_progress_remark)
	}else{
		var in_progress_remark = []
	}
	if (in_progress_remark_av !='' && in_progress_remark_av !=null) {
		var obj = {}
		obj['in_progress_remarks'] = in_progress_remark_av
		in_progress_remark[index] = obj
		// alert(JSON.stringify(in_progress_remark))
			 
	}   	

  	var verification_remarks_av = $('#verification_remarks').val();
  	if(candidateInfo['verification_remarks'] != null){
		var verification_remarks = candidateInfo['verification_remarks'].split(',');
		verification_remarks = JSON.parse(verification_remarks)
	}else{
		var verification_remarks = []
	}
	if (verification_remarks_av !='' && verification_remarks_av !=null) {
		var obj = {}
		obj['verification_remarks'] = verification_remarks_av
		verification_remarks[index] = obj
		// alert(JSON.stringify(verification_remarks))
			 
	} 
	// verified_date = [];
  	var verified_date_av = $('#verified_date').val();
  	if(candidateInfo['verified_date'] != null){
		var verified_date = candidateInfo['verified_date'].split(',');
		verified_date = JSON.parse(verified_date)
	}else{
		var verified_date = []
	}
	
	if (verified_date_av !='' && verified_date_av !=null) {
		var obj = {}
		obj['verified_date'] = verified_date_av
		verified_date[index] = obj
		// alert(JSON.stringify(verification_remarks))
			 
	} 

  	var insuff_remarks_av = $('#insuff_remarks').val();
  	if(candidateInfo['insuff_remarks'] != null){
		var insuff_remarks = candidateInfo['insuff_remarks'].split(',');
		insuff_remarks = JSON.parse(insuff_remarks)
	}else{
		var insuff_remarks = []
	}
	if (insuff_remarks_av !='' && insuff_remarks_av !=null) {
		var obj = {}
		obj['insuff_remarks'] = insuff_remarks_av
		insuff_remarks[index] = obj
		// alert(JSON.stringify(insuff_remarks))
			 
	} 

  	var insuff_closer_remark_av = $('#insuff_closer_remark').val();
  	if(candidateInfo['insuff_closure_remarks'] != null){
		var insuff_closer_remark = candidateInfo['insuff_closure_remarks'].split(',');
		insuff_closer_remark = JSON.parse(insuff_closer_remark)
	}else{
		var insuff_closer_remark = []
	}
	if (insuff_closer_remark_av !='' && insuff_closer_remark_av !=null) {
		var obj = {}
		obj['insuff_closure_remarks'] = insuff_closer_remark_av
		insuff_closer_remark[index] = obj
		// alert(JSON.stringify(insuff_closer_remark))
			 
	} 

  	var action_status_av = $('#action_status').val();
  	if(candidateInfo['analyst_status'] != null){
		var action_status = candidateInfo['analyst_status'].split(',');
		// insuff_closer_remark = JSON.parse(insuff_closer_remark)
	}else{
		var action_status = []
	}
	if (action_status_av !='' && action_status_av !=null) {
		action_status[index] = action_status_av
	} 
	var userID = $("#userID").val();
	var userRole = $("#userRole").val();
  	var candidate_id = $('#candidate_id_hidden').val();
	

	var formdata = new FormData();
	formdata.append('userID',userID);
	formdata.append('userRole',userRole);
	formdata.append('candidate_id',candidate_id);
	formdata.append('document_check_id',document_check_id);
	formdata.append('priority',priority);
	formdata.append('index',index);


	formdata.append('action_status',action_status);
	formdata.append('selected_component_status',action_status);
	formdata.append('address',JSON.stringify(address));
	formdata.append('city',JSON.stringify(city));
	formdata.append('state',JSON.stringify(state));
	formdata.append('pincode',JSON.stringify(pincode));
	formdata.append('in_progress_remark',JSON.stringify(in_progress_remark));
	formdata.append('verification_remarks',JSON.stringify(verification_remarks));
	formdata.append('verified_date',JSON.stringify(verified_date));
	formdata.append('insuff_remarks',JSON.stringify(insuff_remarks));
	formdata.append('insuff_closer_remark',JSON.stringify(insuff_closer_remark));
	

	// var op_action_status = $('#op_action_status').val();
	// if(op_action_status == null || op_action_status == ''){
	// 	formdata.append('op_action_status','0')	
	// }else{
	// 	formdata.append('op_action_status',op_action_status)
	// }
 
	var candidate_id_hidden = $('#candidate_id_hidden').val()
	formdata.append('candidate_id',candidate_id_hidden);

	var vendor_id = $("#vendor_name").val();
   var component_id = $("#component_id").val();
		formdata.append('component_id',component_id);
  formdata.append('vendor_id',vendor_id);
  formdata.append('component_name','Document Check');
 	
 
	if (candidate_aadhar.length > 0) {
		for (var i = 0; i < candidate_aadhar.length; i++) { 
			formdata.append('remark_docs[]',candidate_aadhar[i]);
		}
	}else{
		formdata.append('remark_docs[]','');
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
          	get_latest_selected_vendor();
          	$("#warning-msg").html("");
          }
        });
}
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

function getCity(id,pos){
	// alert(id)
	var state = $("#"+id).val();
	if (state !='') {
		var c_id = $("#"+id).children('option:selected').data('id')
		
			$.ajax({
            type: "POST",
              url: base_url+"outPutQc/get_all_cities/"+c_id, 
              dataType: 'json', 
              success: function(data) {
				              	var html = '';
								if (data.length > 0) {
									for (var i = 0; i < data.length; i++) {
										html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
									}
								}
								$("#city"+pos).html(html);
				      }
            });
		$("#state-error"+id).html("&nbsp;");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please Select Valid state</span>");
		input_is_invalid("#state"+id)
	}
}

function getCitySingle(id){
	// alert(id)
	var state = $("#"+id).val();
	if (state !='') {
		var c_id = $("#"+id).children('option:selected').data('id')
		
			$.ajax({
            type: "POST",
              url: base_url+"outPutQc/get_all_cities/"+c_id, 
              dataType: 'json', 
              success: function(data) {
				              	var html = '';
								if (data.length > 0) {
									for (var i = 0; i < data.length; i++) {
										html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
									}
								}
								$("#city").html(html);
				      }
            });
		$("#state-error"+id).html("&nbsp;");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please Select Valid state</span>");
		input_is_invalid("#state"+id)
	}
}

 