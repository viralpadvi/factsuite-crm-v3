var candidate_aadhar = [];
var max_client_document_select = 20;
var client_document_size = 200000000;

 

$(".client-documents").on("change", handleFileSelect_candidate_aadhar); 


function handleFileSelect_candidate_aadhar(e){ 
		var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#selected-criminal-docs-li"+number).html('');
        $("#criminal-upoad-docs-error-msg-div"+number).html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
        	var obj = [];
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            // alert(number)
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf|doc|docx|xlsx|xls)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_aadhar_'+number+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+number+i+'" onclick="removeFile_candidate_aadhar('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+number+','+i+',\'candidate_aadhar'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                obj.push(files[i]);
	                $("#criminal-upoad-docs-error-msg-div"+number).append(html);
	        	}

	        }
	        candidate_aadhar.push({[number]:obj}); 
	    } else {
	    	$("#selected-criminal-docs-li"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#client-documents'+number).val('');
	    }
    } else {
        $("#selected-criminal-docs-li"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_candidate_aadhar(num,id) {
var tmp_array = [];
    var file = $('#file_candidate_aadhar'+num+id).data("file");
    for(var i = 0; i < candidate_aadhar.length; i++) {
    	if (typeof candidate_aadhar[i][num] !='undefined') {
    		var count = candidate_aadhar[i][num].length;
    		var obj = [];
		for (var b = 0; b < count; b++) { 
			if (candidate_aadhar[i][num][b].name !== file) { 
				obj.push(candidate_aadhar[i][num][b])
			} 
		} 
		tmp_array.push({[num]:obj})
	}else{
		tmp_array.push(candidate_aadhar[i])
	}

    }

    candidate_aadhar = tmp_array; 

    if (candidate_aadhar.length == 0) {
    	$("#client-documents"+num).val('');
    }
    $('#file_candidate_aadhar_'+num+id).remove(); 
}

function view_image(num,id,text){ 
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	 for (var i = 0; i < candidate_aadhar.length; i++) {
	 	 if (typeof candidate_aadhar[i][num] !='undefined') {
	 	 	var reader = new FileReader();
	        reader.onload = function(event) {
	           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
	        };
	        reader.readAsDataURL(candidate_aadhar[i][num][id]);
	 	 }
	 }
	    
}

function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}
$('#cancle-data-btn').on('click',function(){
	$("#wait-message").html("");
})

$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#conformtion").hasClass('show')){  
		var key = e.which;
	    if (key == 13) {
	      	previous_address()
	      	return false;
	    }
	}
});

$('#submit-previous-address').on('click',function(){
 	previous_address()
 	
});

function previous_address(){
	var numberOfCount = $('#each_count_of_detail').val()
 		// alert(numberOfCount)
		var address = [];
	$(".address").each(function(){
		 address.push({remarks_address : $(this).val()});
	});
		var pincode = [];
	$(".pincode").each(function(){
		 pincode.push({remarks_pincode : $(this).val()});
	});
		var city = [];
	$(".city").each(function(){
		 city.push({remarks_city : $(this).val()});
	});
		var state = [];
	$(".state").each(function(){
		 state.push({remarks_state : $(this).val()});
	});
		var staying_with = [];
	$(".staying_with").each(function(){
		 staying_with.push({staying_with : $(this).val()});
	});
		var initiated_date = [];
	$(".initiated_date").each(function(){
		 initiated_date.push({initiated_date : $(this).val()});
	});
		var verifier_name = [];
	$(".verifier_name").each(function(){
		 verifier_name.push({verifier_name : $(this).val()});
	});
		var period_of_stay = [];
	$(".period_of_stay").each(function(){
		 period_of_stay.push({period_of_stay : $(this).val()});
	});
		var progress_remarks = [];
	$(".progress_remarks").each(function(){
		 progress_remarks.push({progress_remarks : $(this).val()});
	});
		var infuff_remarks = [];
	$(".infuff_remarks").each(function(){
		 infuff_remarks.push({infuff_remarks : $(this).val()});
	});
		var assigned_to_vendor = [];
	$(".assigned_to_vendor").each(function(){
		 assigned_to_vendor.push({assigned_to_vendor : $(this).val()});
	});
		var closure_date = [];
	$(".closure_date").each(function(){
		 closure_date.push({closure_date : $(this).val()});
	});
		var relationship = [];
	$(".relationship").each(function(){
		 relationship.push({relationship : $(this).val()});
	});
			var property_type = [];
	$(".property_type").each(function(){
		 property_type.push({property_type : $(this).val()});
	});
			var verification_remarks = [];
	$(".verification_remarks").each(function(){
		 verification_remarks.push({verification_remarks : $(this).val()});
	});
			var closure_remarks = [];
	$(".closure_remarks").each(function(){
		 closure_remarks.push({closure_remarks : $(this).val()});
	});


	var ouputQcComment = [];
	$(".ouputQcComment").each(function(){ 
		ouputQcComment.push({ouputQcComment : $(this).val()}); 
	});


	var analyst_status = [];
	$(".analyst_status").each(function(){ 
			analyst_status.push($(this).val()); 
	}); 

	var output_status = [];
	$(".op_action_status").each(function(){ 
			output_status.push($(this).val()); 
	});
	
	var previos_address_id = $("#previos_address_id").val(); 

	var userID = $("#userID").val();
	var userRole = $("#userRole").val();

	if(address.length == numberOfCount && verifier_name.length == numberOfCount &&  relationship.length == numberOfCount){
$("#submit-previous-address").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		
		var formdata = new FormData();
		formdata.append('userID',userID);
		formdata.append('userRole',userRole); 
		formdata.append('address',JSON.stringify(address));
		formdata.append('pincode',JSON.stringify(pincode));
		formdata.append('city',JSON.stringify(city));
		formdata.append('state',JSON.stringify(state));
		formdata.append('staying_with',JSON.stringify(staying_with));
		formdata.append('initiated_date',JSON.stringify(initiated_date));
		formdata.append('verifier_name',JSON.stringify(verifier_name));
		formdata.append('period_of_stay',JSON.stringify(period_of_stay));
		formdata.append('progress_remarks',JSON.stringify(progress_remarks));
		formdata.append('infuff_remarks',JSON.stringify(infuff_remarks));
		formdata.append('assigned_to_vendor',JSON.stringify(assigned_to_vendor));
		formdata.append('closure_date',JSON.stringify(closure_date));
		formdata.append('relationship',JSON.stringify(relationship));
		formdata.append('property_type',JSON.stringify(property_type));
		formdata.append('verification_remarks',JSON.stringify(verification_remarks));
		formdata.append('closure_remarks',JSON.stringify(closure_remarks));
		formdata.append('previos_address_id',previos_address_id);
		formdata.append('count',candidate_aadhar.length);
		formdata.append('analyst_status',analyst_status);
		formdata.append('op_action_status',output_status)
		formdata.append('ouputQcComment',JSON.stringify(ouputQcComment)); 

		var candidate_id_hidden = $('#candidate_id_hidden').val()
		formdata.append('candidate_id',candidate_id_hidden);

		
		if (candidate_aadhar.length > 0) {
			var a = 0;
			$.each(candidate_aadhar,function(index,value){ 
				$.each(value,function(index,val){ 
				if (candidate_aadhar[a][index].length > 0) {
				for (var c = 0; c < candidate_aadhar[a][index].length; c++) {
						formdata.append('approved_doc'+a+'[]',candidate_aadhar[a][index][c]); 
						// alert(candidate_aadhar[a][index][c].name)
				} 	
				}else{
					// alert("false 1")
					formdata.append('approved_doc[]','');
				}
			});
				a++;
			});
	 
		}else{
			formdata.append('approved_doc[]','');
			// alert("false 2")
		} 

		$.ajax({
	        type: "POST",
	          url: base_url+"outPutQc/update_remarks_candidate_previous_address",
	          data:formdata,
	          dataType: 'json',
	          contentType: false,
	          processData: false,
	          success: function(data) {
	          	$("#wait-message").html("");
				if (data.status == '1') {
					toastr.success('successfully saved data.');   
					$('.is-valid').removeClass('is-valid');
					$("#wait-message").html("");
					window.location.href = base_url+"factsuite-outputqc/assigned-view-case-detail/"+candidate_id_hidden;
	          	}else{
	          		toastr.error('Something went wrong while save this data. Please try again.'); 	
	          	}
	          	$("#warning-msg").html("");
	          	$('#conformtion').modal('hide');
	          	$("#submit-previous-address").html("Confirm")
	          }
        });
	}else{
		// valid_address('#address')
		$("#wait-message").html("<span class='text-danger'>Please enter required data.</span>");
		$('.address').each(function(){
			var MyID = $(this).attr("id"); 
		    var number = MyID.match(/\d+/); 
		    valid_address(number);
		    valid_pincode(number);
		    valid_city(number);
		    valid_state(number);
		    valid_staying_with(number);
		    valid_verifier_name(number);
		    valid_period_of_stay(number);
		    valid_relationship(number);
		    valid_property_type(number);
			valid_verification_remarks(number)
		     
		});
	}
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

function valid_pincode(id){ 
	var pincode = $("#pincode"+id).val();
	if (pincode !='') {
		if (isNaN(pincode)) {
			$("#pincode-error"+id).html('<span class="text-danger error-msg-small">pin code should be only numbers.</span>');
			$("#pincode"+id).val(pincode.slice(0,-1));
			input_is_invalid("#pincode"+id);
		} else if (pincode.length != 6) {
			$("#pincode-error"+id).html('<span class="text-danger error-msg-small">pin code should be of '+6+' digits.</span>');
			var plenght = $("#pincode"+id).val(pincode.slice(0,6));
			input_is_invalid("#pincode"+id);
			if (plenght.length == 6) {
			$("#pincode-error"+id).html('&nbsp;');
			input_is_valid("#pincode"+id);	
			}
		} else {
			$("#pincode-error"+id).html('&nbsp;');
			input_is_valid("#pincode"+id);
		} 
	}else{
		$("#pincode-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid pincode</span>");
		input_is_invalid("#pincode"+id)
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