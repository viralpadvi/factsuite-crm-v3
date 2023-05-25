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
    	$("#selected-criminal-docs-li").html('');
        $("#criminal-upoad-docs-error-msg-div").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf|doc|docx|xlsx|xls)$/i).test(fileName)) {
	            	 html = '<div id="aadhar-file_candidate_aadhar_'+i+'"><span>'+fileName+' <a id="aadhar-file_candidate_aadhar'+i+'" onclick="removeFile_candidate_aadhar('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_aadhar\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                candidate_aadhar.push(files[i]);
	                $("#criminal-upoad-docs-error-msg-div").append(html);
	        	} 
	        }
	    } else {
	    	$("#selected-criminal-docs-li").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#client-documents').val('');
	    }
    } else {
        $("#selected-criminal-docs-li").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
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

         if(text =='candidate_aadhar'){ 
        reader.readAsDataURL(candidate_aadhar[id]);
        } 
}
// function exist_view_image(image,path){
// 	$("#myModal-show").modal('show'); 
//    $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
// }

var candidateInfo
function phpData(phpData){ 
	candidateInfo = phpData;
	// alert(JSON.stringify(candidateInfo))
	// console.log(JSON.stringify(candidateInfo))
}


$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#conformtion").hasClass('show')){  
		var key = e.which;
	    if (key == 13) {
	      	previous_address();
	      	return false;
	    }
	}
});

$('#submit-previous-address').on('click',function(){
 	previous_address();
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

function previous_address(){
	var index = $('#componentIndex').val()
 	var previos_address_id = $('#previos_address_id').val()
 	var priority = $('#priority').val()
 	var numberOfCount = $('#each_count_of_detail').val()
 		// alert(numberOfCount)
	if(candidateInfo['remarks_address'] != null){
		var address = candidateInfo['remarks_address'].split(',');
		address = JSON.parse(address)
	}else{
		var address = []
	}
	$(".address").each(function() {
		if ($(this).val() !='' && $(this).val() !=null) {
			var obj = {}
			obj['address'] = $(this).val()
			address[index] = obj
			// alert(JSON.stringify(address))
		}
	});
	if(candidateInfo['remarks_pincode'] != null){
		var pincode = candidateInfo['remarks_pincode'].split(',');
		pincode = JSON.parse(pincode)
	}else{
		var pincode = []
	}

	$(".pincode").each(function(){
		// pincode.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
		 // pincode.push({pincode : $(this).val()});
		 	var obj = {}
			obj['pincode'] = $(this).val()
			pincode[index] = obj
			// alert(JSON.stringify(pincode))
		}
	});

	// var city = [];
	if(candidateInfo['remarks_city'] != null){
		var city = candidateInfo['remarks_city'].split(',');
		city = JSON.parse(city)
	}else{
		var city = []
	}
	$(".city").each(function(){
		// city.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
		// city.push({city : $(this).val()});
			var obj = {}
			obj['city'] = $(this).val()
			city[index] = obj
			// alert(JSON.stringify(city))
		}
	});
	// var state = [];
	if(candidateInfo['remarks_state'] != null){
		var state = candidateInfo['remarks_state'].split(',');
		state = JSON.parse(state)
	}else{
		var state = []
	}
	$(".state").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
			// state.push({state : $(this).val()});
			var obj = {}
			obj['state'] = $(this).val()
			state[index] = obj
			// alert(JSON.stringify(state))
		}
	}); 
	// var staying_with = [];
	if(candidateInfo['remarks_state'] != null){
		var staying_with = candidateInfo['remarks_state'].split(',');
		staying_with = JSON.parse(staying_with)
	}else{
		var staying_with = []
	}
	$(".staying_with").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // staying_with.push({staying_with : $(this).val()});
		 	var obj = {}
			obj['staying_with'] = $(this).val()
			staying_with[index] = obj
		}
	});
		// var initiated_date = [];
	if(candidateInfo['initiated_date'] != null){
		var initiated_date = candidateInfo['initiated_date'].split(',');
		initiated_date = JSON.parse(initiated_date)
	}else{
		var initiated_date = []
	}	
	$(".initiated_date").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // initiated_date.push({initiated_date : $(this).val()});
		 	var obj = {}
			obj['initiated_date'] = $(this).val()
			initiated_date[index] = obj
		}
	});
		// var verifier_name = [];

	if(candidateInfo['verifier_name'] != null){
		var verifier_name = candidateInfo['verifier_name'].split(',');
		verifier_name = JSON.parse(verifier_name)
	}else{
		var verifier_name = []
	}
	$(".verifier_name").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // verifier_name.push({verifier_name : $(this).val()});
		 	var obj = {}
			obj['verifier_name'] = $(this).val()
			verifier_name[index] = obj
		}
	});
		// var period_of_stay = [];
	if(candidateInfo['period_of_stay'] != null){
		var period_of_stay = candidateInfo['period_of_stay'].split(',');
		period_of_stay = JSON.parse(period_of_stay)
	}else{
		var period_of_stay = []
	}	
	$(".period_of_stay").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // period_of_stay.push({period_of_stay : $(this).val()});
		 	var obj = {}
			obj['period_of_stay'] = $(this).val()
			period_of_stay[index] = obj
		}
	});
		// var progress_remarks = [];
	if(candidateInfo['progress_remarks'] != null){
		var progress_remarks = candidateInfo['progress_remarks'].split(',');
		progress_remarks = JSON.parse(progress_remarks)
	}else{
		var progress_remarks = []
	}
	$(".progress_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // progress_remarks.push({progress_remarks : $(this).val()});
		 	var obj = {}
			obj['progress_remarks'] = $(this).val()
			progress_remarks[index] = obj
		}
	});
		// var infuff_remarks = [];
	if(candidateInfo['insuff_remarks'] != null){
		var infuff_remarks = candidateInfo['insuff_remarks'].split(',');
		infuff_remarks = JSON.parse(infuff_remarks)
	}else{
		var infuff_remarks = []
	}
	$(".infuff_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // infuff_remarks.push({infuff_remarks : $(this).val()});
		 	var obj = {}
			obj['insuff_remarks'] = $(this).val()
			infuff_remarks[index] = obj
		}
	});
		// var assigned_to_vendor = [];
	if(candidateInfo['assigned_to_vendor'] != null){
		var assigned_to_vendor = candidateInfo['assigned_to_vendor'].split(',');
		assigned_to_vendor = JSON.parse(assigned_to_vendor)
	}else{
		var assigned_to_vendor = []
	}
	$(".assigned_to_vendor").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // assigned_to_vendor.push({assigned_to_vendor : $(this).val()});
			var obj = {}
			obj['assigned_to_vendor'] = $(this).val()
			assigned_to_vendor[index] = obj
		}
	});
		// var closure_date = [];
	if(candidateInfo['closure_date'] != null){
		var closure_date = candidateInfo['closure_date'].split(',');
		closure_date = JSON.parse(closure_date)
	}else{
		var closure_date = []
	}
	$(".closure_date").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // closure_date.push({closure_date : $(this).val()});
		 	var obj = {}
			obj['closure_date'] = $(this).val()
			closure_date[index] = obj
		}
	});
		// var relationship = [];
	if(candidateInfo['relationship'] != null){
		var relationship = candidateInfo['relationship'].split(',');
		relationship = JSON.parse(relationship)
	}else{
		var relationship = []
	}
	$(".relationship").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // relationship.push({relationship : $(this).val()});
		 	var obj = {}
			obj['relationship'] = $(this).val()
			relationship[index] = obj
		}
	});
	// var property_type = [];
	if(candidateInfo['property_type'] != null){
		var property_type = candidateInfo['property_type'].split(',');
		property_type = JSON.parse(property_type)
	}else{
		var property_type = []
	}
	$(".property_type").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // property_type.push({property_type : $(this).val()});
		 	var obj = {}
			obj['property_type'] = $(this).val()
			property_type[index] = obj
		}
	});
			// var verification_remarks = [];
	if(candidateInfo['verification_remarks'] != null){
		var verification_remarks = candidateInfo['verification_remarks'].split(',');
		verification_remarks = JSON.parse(verification_remarks)
	}else{
		var verification_remarks = []
	}
	$(".verification_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // verification_remarks.push({verification_remarks : $(this).val()});
		 	var obj = {}
			obj['verification_remarks'] = $(this).val()
			verification_remarks[index] = obj
		}
	});
	// var closure_remarks = [];
	if(candidateInfo['closure_remarks'] != null){
		var closure_remarks = candidateInfo['closure_remarks'].split(',');
		closure_remarks = JSON.parse(closure_remarks)
	}else{
		var closure_remarks = []
	}
	$(".closure_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 	// closure_remarks.push({closure_remarks : $(this).val()});
		 	var obj = {}
			obj['closure_remarks'] = $(this).val()
			closure_remarks[index] = obj
		}
	});


  var verified_date = [];
  $(".verified_date").each(function(){
    // state.push($(this).val());
    if ($(this).val() !='' && $(this).val() !=null) {
      // verification_remarks.push({verification_remarks : $(this).val()});
      var obj = {}
      obj['verified_date'] = $(this).val()
      verified_date[index] = obj
      // alert(JSON.stringify(verification_remarks))
    }
  }); 
 	
	var previos_address_id = $("#previos_address_id").val(); 

	var userID = $("#userID").val();
	var userRole = $("#userRole").val();

	// var action_status = $("#action_status").val();
	var action_status = $("#action_status").val();
	if(candidateInfo['analyst_status'] != null){
		var analyst_status = candidateInfo['analyst_status'].split(',');
		// analyst_status = JSON.parse(analyst_status)
	}else{
		var analyst_status = []
	}
	var vendor_id = $("#vendor_name").val();
	analyst_status[index] = action_status;

	var iverify_or_pv_status = [];
	if(candidateInfo['iverify_or_pv_status'] != null) {
		var iverify_or_pv_status = candidateInfo['iverify_or_pv_status'].split(',');
	}
	iverify_or_pv_status[index] = $('input[name="client-iverify-or-pv-type"]:checked').val();

	numberOfCount = index
	// if(address.length == numberOfCount && verifier_name.length == numberOfCount &&  relationship.length == numberOfCount){
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
		formdata.append('verified_date',JSON.stringify(verified_date));
		formdata.append('closure_remarks',JSON.stringify(closure_remarks));
		formdata.append('previos_address_id',previos_address_id);
		var component_id = $("#component_id").val();
		formdata.append('component_id',component_id);
		formdata.append('vendor_id',vendor_id);
		formdata.append('component_name','Previos Address');
		formdata.append('count',candidate_aadhar.length);
		formdata.append('iverify_or_pv_status',iverify_or_pv_status);

		formdata.append('action_status',analyst_status);
		formdata.append('index',index);
		formdata.append('priority',priority);

		var op_action_status = $('#op_action_status').val();
		if(op_action_status == null || op_action_status == ''){
			formdata.append('op_action_status','0')	
		}else{
			formdata.append('op_action_status',op_action_status)
		}
		var candidate_id_hidden = $('#candidate_id_hidden').val()
		formdata.append('candidate_id',candidate_id_hidden);

		
	if (candidate_aadhar.length > 0) {
		for (var i = 0; i < candidate_aadhar.length; i++) { 
			formdata.append('remark_docs[]',candidate_aadhar[i]);
		}
	}else{
		formdata.append('remark_docs[]','');
	}

	if ($('input[name="client-iverify-or-pv-type"]:checked').length > 0) {
		$.ajax({
	        type: "POST",
	        url: base_url+"analyst/update_remarks_candidate_previous_address",
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
	          	} else {
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
	// 	// valid_address('#address')
	// 	$("#wait-message").html("<span class='text-danger'>Please enter required data.</span>");
	// 	$('.address').each(function(){
	// 		var MyID = $(this).attr("id"); 
	// 	    var number = MyID.match(/\d+/); 
	// 	    valid_address(number);
	// 	    valid_pincode(number);
	// 	    valid_city(number);
	// 	    valid_state(number);
	// 	    valid_staying_with(number);
	// 	    valid_verifier_name(number);
	// 	    valid_period_of_stay(number);
	// 	    valid_relationship(number);
	// 	    valid_property_type(number);
	// 		valid_verification_remarks(number)
		     
	// 	});
	// }
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
/*function valid_state(id){
	var state = $("#state"+id).val();
	if (state !='') {
		$("#state-error"+id).html("&nbsp;");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid state</span>");
		input_is_invalid("#state"+id)
	}
}*/


function valid_state(id){
	var state = $("#state"+id).val();
	if (state !='') {
		var c_id = $("#state"+id).children('option:selected').data('id')
		
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
				$("#city"+id).html(html);
              }
            });
		$("#state-error"+id).html("&nbsp;");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please Select Valid state</span>");
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

 