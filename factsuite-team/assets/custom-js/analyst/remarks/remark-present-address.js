var candidate_aadhar = [];
var max_client_document_select = 20;
var client_document_size = 200000000;

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
	            	 html = '<div id="file_candidate_aadhar_'+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+i+'" onclick="removeFile_candidate_aadhar('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_aadhar\')" ><i class="fa fa-eye"></i></a></span></div>';
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

    var file = $('#file_candidate_aadhar'+id).data("file");
    for(var i = 0; i < candidate_aadhar.length; i++) {
        if(candidate_aadhar[i].name === file) {
            candidate_aadhar.splice(i,1); 
        }
    }
    if (candidate_aadhar.length == 0) {
    	$("#client-documents").val('');
    }
    $('#file_candidate_aadhar_'+id).remove(); 
}

function view_image(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_aadhar[id]);
}
// function exist_view_image(image,path){
// 	$("#myModal-show").modal('show'); 
//    $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
// }

$('#cancle-data-btn').on('click',function(){
	$("#warning-msg").html("");
})

$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#conformtion").hasClass('show')){  
		var key = e.which;
	    if (key == 13) {
	      	present_address();
	      	return false;
	    }
	}
});

$('#submit-present-address').on('click',function(){
	present_address();
});

$('.client-iverify-or-pv-type').on('click', function() {
	check_selected_iverify_or_pv_type_selected();
});

function check_selected_iverify_or_pv_type_selected() {
	var components_checked = $('input[name="client-iverify-or-pv-type"]:checked').length;
	if (components_checked > 0) {
		$('#client-iverify-or-pv-type-error-msg-div').html('');
		return 1;
	} else {
		$('#client-iverify-or-pv-type-error-msg-div').html('<span class="text-danger error-msg-small">Please select a type.</span>');
		return 0;
	}
}

function present_address(){
	var address = $("#address").val();
	var pincode = $("#pincode").val();
	var city = $("#city").val();
	var state = $("#state").val();
	var staying_with = $("#staying_with").val();
	var initiated_date = $("#initiated_date").val();
	var verifier_name = $("#verifier_name").val();
	var period_of_stay = $("#period_of_stay").val();
	var progress_remarks = $("#progress_remarks").val();
	var infuff_remarks = $("#infuff_remarks").val();
	var assigned_to_vendor = $("#assigned_to_vendor").val();
	var closure_date = $("#closure_date").val();
	var relationship = $("#relationship").val();
	var property_type = $("#property_type").val();
	var verification_remarks = $("#verification_remarks").val();
	var verified_date = $("#verified_date").val();
	var closure_remarks = $("#closure_remarks").val();
	var present_address_id = $("#present_address_id").val();
	var action_status = $("#action_status").val();
	var op_action_status = $('#op_action_status').val();
	var userID = $("#userID").val();
	var userRole = $("#userRole").val();
	// if(valid_address() == 1 && valid_pincode() ==1 && valid_city() == 1 && valid_state() == 1 && valid_staying_with() == 1
	// 		&& valid_period_of_stay() == 1 && valid_verifier_name() == 1 && valid_relationship() == 1 && 
	// 		valid_verification_remarks()==1 && valid_property_type() == 1){
	var vendor_id = $("#vendor_name").val();
	var formdata = new FormData();
	formdata.append('userID',userID);
	formdata.append('userRole',userRole);
	formdata.append('address',address);
	formdata.append('pincode',pincode);
	formdata.append('city',city);
	formdata.append('state',state);
	formdata.append('staying_with',staying_with);
	formdata.append('initiated_date',initiated_date);
	formdata.append('verifier_name',verifier_name);
	formdata.append('period_of_stay',period_of_stay);
	formdata.append('progress_remarks',progress_remarks);
	formdata.append('infuff_remarks',infuff_remarks);
	formdata.append('assigned_to_vendor',assigned_to_vendor);
	formdata.append('closure_date',closure_date);
	formdata.append('relationship',relationship);
	formdata.append('property_type',property_type);
	formdata.append('verification_remarks',verification_remarks);
	formdata.append('verified_date',verified_date);
	formdata.append('closure_remarks',closure_remarks); 
	formdata.append('present_address_id',present_address_id);
	formdata.append('action_status',action_status);
	/**/
	var component_id = $("#component_id").val();
		formdata.append('component_id',component_id);
	formdata.append('vendor_id',vendor_id);
	formdata.append('component_name','Present Address');
	formdata.append('iverify_or_pv_type', $('input[name="client-iverify-or-pv-type"]:checked').val());
	
	if(op_action_status == null || op_action_status == ''){
		formdata.append('op_action_status','0')	
	}else{
		formdata.append('op_action_status',op_action_status)
	}
	
	if (candidate_aadhar.length > 0) {
		for (var i = 0; i < candidate_aadhar.length; i++) { 
			formdata.append('approved_doc[]',candidate_aadhar[i]);
		}
	}else{
		formdata.append('approved_doc[]','');
	} 
	var candidate_id_hidden = $('#candidate_id_hidden').val()
	formdata.append('candidate_id',candidate_id_hidden);
	
	if ($('input[name="client-iverify-or-pv-type"]:checked').length > 0) {
		$.ajax({
	        type: "POST",
	          url: base_url+"analyst/update_remarks_candidate_present_address",
	          data:formdata,
	          dataType: 'json',
	          contentType: false,
	          processData: false,
	          success: function(data) {
				if (data.status == '1') {
					toastr.success('successfully saved data.');  
					$('.is-valid').removeClass('is-valid'); 
					$("#wait-message").html("");
	          	}else{
	          		toastr.error('Something went wrong while save this data. Please try again.'); 	
	          	}
	          	get_latest_selected_vendor();
	          	$("#warning-msg").html("");
	          	$('#conformtion').modal('hide');
	          }
	        });
	} else {
		check_selected_iverify_or_pv_type_selected();
	}
	// }else{
	// 		$("#wait-message").html("<span class='text-danger'>Please enter required data.</span>");
	// 		valid_address()
	// 		valid_pincode()
	// 		valid_city()
	// 		valid_state()
	// 		valid_staying_with()
	// 		valid_period_of_stay()
	// 		valid_property_type()
	// 		valid_verifier_name()
	// 		valid_relationship()
	// 		valid_verification_remarks()
	// }
}

function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
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


$("#address").on('keyup blur',valid_address); 
$("#pincode").on('keyup blur',valid_pincode);
$("#city").on('keyup blur',valid_city);
$("#state").on('keyup blur',valid_state);

$("#staying_with").on('keyup blur', valid_staying_with);
$("#initiated_date").on('keyup blur change', valid_initiated_date);
$("#verifier_name").on('keyup blur', valid_verifier_name);
$("#period_of_stay").on('keyup blur', valid_period_of_stay);
$("#progress_remarks").on('keyup blur', valid_progress_remarks);
$("#infuff_remarks").on('keyup blur', valid_infuff_remarks);
$("#assigned_to_vendor").on('keyup blur', valid_assigned_to_vendor);
$("#closure_date").on('keyup blur change', valid_closure_date);
$("#relationship").on('keyup blur', valid_relationship);
$("#property_type").on('keyup blur', valid_property_type);
$("#verification_remarks").on('keyup blur', valid_verification_remarks);
$("#closure_remarks").on('keyup blur', valid_closure_remarks);

function valid_address(){
	var address = $("#address").val();
	if (address !='') {
		$("#address-error").html("&nbsp;");
		input_is_valid("#address")
		return 1
	}else{
		input_is_invalid("#address")
		$("#address-error").html("<span class='text-danger error-msg-small'>Please Enter Valid address</span>");
		return 0
	}
}

function valid_pincode(){ 
	var pincode = $("#pincode").val();
	if (pincode !='') {
		if (isNaN(pincode)) {
			$("#pincode-error").html('<span class="text-danger error-msg-small">pin code should be only numbers.</span>');
			$("#pincode").val(pincode.slice(0,-1));
			input_is_invalid("#pincode");
			return 0
		} else if (pincode.length != 6) {
			$("#pincode-error").html('<span class="text-danger error-msg-small">pin code should be of '+6+' digits.</span>');
			var plenght = $("#pincode").val(pincode.slice(0,6));
			input_is_invalid("#pincode");
			if (plenght.length == 6) {
			$("#pincode-error").html('&nbsp;');
			input_is_valid("#pincode");	
			return 1
			}
		} else {
			$("#pincode-error").html('&nbsp;');
			input_is_valid("#pincode");
			return 1
		} 
	}else{
		$("#pincode-error").html("<span class='text-danger error-msg-small'>Please Enter Valid pincode</span>");
		input_is_invalid("#pincode")
		return 0
	}
}
function valid_city(){
	var city = $("#city").val();
	if (city !='') {
		$("#city-error").html("&nbsp;");
		input_is_valid("#city")
		return 1
	}else{
		$("#city-error").html("<span class='text-danger error-msg-small'>Please Enter Valid city</span>");
		input_is_invalid("#city")
		return 0
	}
}
/*function valid_state(){
	var state = $("#state").val();
	if (state !='') {
		$("#state-error").html("&nbsp;");
		input_is_valid("#state")
		return 1
	}else{
		$("#state-error").html("<span class='text-danger error-msg-small'>Please Enter Valid state</span>");
		input_is_invalid("#state")
		return 0
	}
}*/
 
function valid_state(){
	var state = $("#state").val();
	if (state !='') {
		var c_id = $("#state").children('option:selected').data('id')
		
			$.ajax({
            type: "POST",
              url: base_url+"analyst/get_selected_cities/"+c_id, 
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
		$("#state-error").html("&nbsp;");
		input_is_valid("#state")
	}else{
		$("#state-error").html("<span class='text-danger error-msg-small'>Please Select Valid state</span>");
		input_is_invalid("#state")
	}
}




function valid_staying_with(){
	var staying_with = $("#staying_with").val();
	if (staying_with !='') {
		$("#staying_with-error").html("&nbsp;");
		input_is_valid("#staying_with")
		return 1
	}else{
		$("#staying_with-error").html("<span class='text-danger error-msg-small'>Please Enter Valid Staying With</span>");
		input_is_invalid("#staying_with")
		return 0
	}	
}
function valid_initiated_date(){
	var initiated_date = $("#initiated_date").val();
	if (initiated_date !='') {
		$("#initiated_date-error").html("&nbsp;");
		input_is_valid("#initiated_date")
		return 1
	}else{
		$("#initiated_date-error").html("<span class='text-danger error-msg-small'>Please Enter Valid Initiated Date</span>");
		input_is_invalid("#initiated_date")
		return 0
	}	
}
function valid_verifier_name(){
	var verifier_name = $("#verifier_name").val();
	if (verifier_name !='') {
		$("#verifier_name-error").html("&nbsp;");
		input_is_valid("#verifier_name")
		return 1
	}else{
		$("#verifier_name-error").html("<span class='text-danger error-msg-small'>Please Enter Valid Verifier Name</span>");
		input_is_invalid("#verifier_name")
		return 0
	}	
}
function valid_period_of_stay(){
	var period_of_stay = $("#period_of_stay").val();
	if (period_of_stay !='') {
		$("#period_of_stay-error").html("&nbsp;");
		input_is_valid("#period_of_stay")
		return 1
	}else{
		$("#period_of_stay-error").html("<span class='text-danger error-msg-small'>Please Enter Valid Period Of Period Of Stay</span>");
		input_is_invalid("#period_of_stay")
		return 0
	}	
}
function valid_progress_remarks(){
	var progress_remarks = $("#progress_remarks").val();
	if (progress_remarks !='') {
		$("#progress_remarks-error").html("&nbsp;");
		input_is_valid("#progress_remarks")
		return 1
	}else{
		$("#progress_remarks-error").html("<span class='text-danger error-msg-small'>Please Enter Valid Progress Remarks</span>");
		input_is_invalid("#progress_remarks")
		return 0
	}	
}
function valid_infuff_remarks(){
	var infuff_remarks = $("#infuff_remarks").val();
	if (infuff_remarks !='') {
		$("#infuff_remarks-error").html("&nbsp;");
		input_is_valid("#infuff_remarks")
		return 1
	}else{
		$("#infuff_remarks-error").html("<span class='text-danger error-msg-small'>Please Enter Valid Insuff Remarks</span>");
		input_is_invalid("#infuff_remarks")
		return 0
	}	
}
function valid_assigned_to_vendor(){
	var assigned_to_vendor = $("#assigned_to_vendor").val();
	if (assigned_to_vendor !='') {
		$("#assigned_to_vendor-error").html("&nbsp;");
		input_is_valid("#assigned_to_vendor")
		return 1
	}else{
		$("#assigned_to_vendor-error").html("<span class='text-danger error-msg-small'>Please Enter Valid Assigned Of Vendor</span>");
		input_is_invalid("#assigned_to_vendor")
		return 0
	}	
}
function valid_closure_date(){
	var closure_date = $("#closure_date").val();
	if (closure_date !='') {
		$("#closure_date-error").html("&nbsp;");
		input_is_valid("#closure_date")
		return 1
	}else{
		$("#closure_date-error").html("<span class='text-danger error-msg-small'>Please Enter Valid Closure Date</span>");
		input_is_invalid("#closure_date")
		return 0
	}
}
function valid_relationship(){
		var relationship = $("#relationship").val();
	if (relationship !='') {
		$("#relationship-error").html("&nbsp;");
		input_is_valid("#relationship")
		return 1
	}else{
		$("#relationship-error").html("<span class='text-danger error-msg-small'>Please Enter Valid Relationship</span>");
		input_is_invalid("#relationship")
		return 0
	}
}
function valid_property_type(){
	var property_type = $("#property_type").val();
	if (property_type !='') {
		$("#property_type-error").html("&nbsp;");
		input_is_valid("#property_type")
		return 1
	}else{
		$("#property_type-error").html("<span class='text-danger error-msg-small'>Please Enter Valid Property Type</span>");
		input_is_invalid("#property_type")
		return 0
	}	
}
function valid_verification_remarks(){
	var verification_remarks = $("#verification_remarks").val();
	if (verification_remarks !='') {
		$("#verification_remarks-error").html("&nbsp;");
		input_is_valid("#verification_remarks")
		return 1
	}else{
		$("#verification_remarks-error").html("<span class='text-danger error-msg-small'>Please Enter Valid Verification Remarks</span>");
		input_is_invalid("#verification_remarks")
		return 0
	}	
}
function valid_closure_remarks(){
	var closure_remarks = $("#closure_remarks").val();
	if (closure_remarks !='') {
		$("#closure_remarks-error").html("&nbsp;");
		input_is_valid("#closure_remarks")
		return 1
	}else{
		$("#closure_remarks-error").html("<span class='text-danger error-msg-small'>Please Enter Valid Closure Remarks</span>");
		input_is_invalid("#closure_remarks")
		return 0
	}	
}


$("#view_vendor_log").on('click',function() {
	$("#view_vendor_log_dailog").modal('show');
	var component_id = $("#present_address_id").val();
	var case_id = $("#candidate_id_hidden").val(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"admin_Vendor/get_all_vendor_logs", 
	  	data:{case_id:case_id,component_id:component_id},
	  	dataType: "json",
	  	success: function(data){ 
	  		// console.log(JSON.stringify(data));
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	// var components = JSON.parse(data[i]['component_name']);
        	html += '<tr>'; 
        	html += '<td>'+j+'</td>';
        	html += '<td>'+data[i]['vendor_name']+'</td>';  
        	html += '<td>'+data[i]['component_name']+'</td>'; 
        	html += '<td>'+data[i]['created_date']+'</td>'; 
        	html += '</tr>'; 
			 
          j++; 
        }
      }else{
        html+='<tr><td colspan="5" class="text-center">Not Found.</td></tr>'; 
    }
    $('#list_vendor_log_data').html(html); 
	  	} 
	});

});