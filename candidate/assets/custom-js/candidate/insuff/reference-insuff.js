var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var mobile_number_length = 10;
var url_regex = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
// var url_regex = regex = ((http|https):\/\/)?(www.)[a-zA-Z0-9@:%._\\+~#?&\/\/=]{2,256}\\.[a-z]{2,6}\\b([-a-zA-Z0-9@:%._\\+~#?&\/\/=]*);
var client_zip_lenght = 6;
var client_document_size = 20000000;
var max_client_document_select = 20;
var candidate_aadhar =[];
var candidate_pan =[];
var candidate_proof =[];
var candidate_bank =[];


var email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
	alphabets_only = /^[A-Za-z ]+$/,
	vendor_name_length = 100,
	city_name_length = 100,
	vendor_zip_code_length = 6,
	vendor_monthly_quota_length = 5,
	vendor_docs = [],
	vendor_document_size = 1000000,
	max_vendor_document_select = 6,
	vendor_manager_name_length = 200, 
	vendor_spoc_name_length = 200,
	vendor_first_name_length = 100,
	vendor_last_name_length = 100,
	vendor_user_name_length = 70,
	min_vendor_user_name_length = 8,
	password_length = 8,
	vendor_skill_tat_length = 3;

var j =5;
$("#add-row").on('click',function(){
 
var html = '';
html +='<div id="form'+j+'">';
html +='<h6 class="full-nam2">REFERENCE </h6>';
html +='<div class="row">';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Name</label>';
html +='<input name="" class="fld form-control name" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Company Name</label>';
html +='<input name="" class="fld form-control company-name" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Designation</label>';
html +='<input name="" class="fld form-control designation" type="text">';
html +='</div>';
html +='</div>';
html +='</div>';
html +='<div class="row">';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Contact Number</label>';
html +='<input name="" class="fld form-control contact" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Email ID</label>';
html +='<input name="" class="fld form-control email" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-3">';
html +='<div class="pg-frm">';
html +='<label>Years of Association</label>';
html +='<input name="" class="fld form-control association" type="text">';
html +='</div>';
html +='</div>';
html +='</div>';
html +='<div class="row">';
html +='<div class="col-md-6">';
html +='<div class="pg-frm-hd">Preferred contact time</div>';
html +='<div class="row">';
html +='<div class="col-md-5">';
html +='<div class="pg-frm">';
html +='<input type="text" class="form-control fld start-time" id="timepicker'+j+'" placeholder="Start time" name="pwd" >';
html +='</div>';
html +='</div>';
html +='<div class="col-md-5">';
html +='<div class="pg-frm">';
html +='<input type="text" class="form-control fld end-time" id="timepicker1'+j+'" placeholder="End time" name="pwd" >';
html +='</div>';
html +='</div>';
html +='<div class="col-md-2"><button onclick="remove_form('+j+')"><i class="fa fa-trash"></i></button></';
html +='</div>';
html +='</div>';
html +='</div>';
html +='</div>';
html +='</div>';
html +='<hr>';

$("#new_address").append(html);
j++;
});



 $("#add_reference").on('click',function(){
	 
	 var name = [];
	$('.name').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		name.push($(this).val());
		}
	});
	 var company_name = [];
	$('.company-name').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		company_name.push($(this).val());
		}
	});
	 var designation = [];
	$('.designation').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		designation.push($(this).val());
		}
	});
	 var contact = [];
	$('.contact').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		contact.push($(this).val());
		}
	});
	 var code = [];
	$('.code').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		code.push($(this).val());
		}
	});
	 var email = [];
	$('.email').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		email.push($(this).val());
		}
	});
	 var association = [];
	$('.association').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		association.push($(this).val());
		}
	});
	 var start_date = [];
	 var hour =[], minute=[], type=[];
	 var endhour =[], endminute=[], endtype=[];
	$('.start-hour').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		hour.push($(this).val());
		}
	});	$('.start-minute').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		minute.push($(this).val());
		}
	});	$('.start-type').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		type.push($(this).val());
		}
	});	
	$('.end-hour').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		endhour.push($(this).val());
		}
	});	$('.end-minute').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		endminute.push($(this).val());
		}
	});	$('.end-minute').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		endtype.push($(this).val());
		}
	}); 

	 var end_date = [];

	 for (var i = 0; i < hour.length; i++) {
	 	start_date.push(hour[i]+':'+minute[i]+':'+type[i]);
	 	 end_date.push(endhour[i]+':'+endminute[i]+':'+endtype[i]);
	 }
	/*$('.end-time').each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		end_date.push($(this).val());
		}
	});*/


 	// alert("Hello")
 	var formdata = new FormData();
 		formdata.append('url',11);
		formdata.append('name',name);
		formdata.append('company_name',company_name);
		formdata.append('designation',designation);
		formdata.append('contact',contact);
		formdata.append('email',email);
		formdata.append('association',association);
		formdata.append('start_date',start_date);
		formdata.append('end_date',end_date); 
		formdata.append('code',code); 
	var reference_id = $("#reference_id").val();
	if (reference_id !='' && reference_id !=null) {
		formdata.append('reference_id',reference_id);
	}


	if (name.length > 0 &&
company_name.length > 0 &&
designation.length > 0 &&
contact.length > 0 &&
email.length > 0 &&
association.length > 0 &&
start_date.length > 0 &&
end_date.length > 0 ) {

$("#warning-msg").html("<span class='text-warning'>Please wait we are submitting the data.</span>");
$("#add_reference").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$.ajax({
        type: "POST",
          url: base_url+"candidate/update_candidate_reference_insuff",
          data:formdata,
          dataType: 'json',
          contentType: false,
          processData: false,
          success: function(data) {
			if (data.status == '1') {
				// toastr.success('successfully saved data.');  
				window.location.href=base_url+data.url;
          	}else{
          		toastr.error('Something went wrong while save this data. Please try again.'); 	
          	}
          	$("#warning-msg").html("");
          	$("#add_reference").html("Save & Continue")
          }
        });

	}else{
	$('.name').each(function(){
		 	var MyID = $(this).attr("id"); 
		    var number = MyID.match(/\d+/); 
		    valid_name(number)
			valid_company_name(number)
			valid_designation(number)
			valid_contact(number)
			valid_email(number)
			valid_association(number)
			valid_timepicker(number)
			// valid_timepicker1(number)
	});
	}

 });

 function remove_form(id){
	$("#form"+id).remove();
}


	function input_is_valid(input_id) {
		$(input_id).removeClass('is-invalid');
		$(input_id).addClass('is-valid');
	}

	function input_is_invalid(input_id) {
		$(input_id).removeClass('is-valid');
		$(input_id).addClass('is-invalid');
	}


	
function valid_name(id=''){
	 
	var first_name = $("#name"+id).val();
	if (first_name != '') {
		if (!alphabets_only.test(first_name)) {
			$("#name-error"+id).html('<span class="text-danger error-msg-small">Name should be only alphabets.</span>');
			$("#name"+id).val(first_name.slice(0,-1));
			input_is_invalid("#name"+id);
		} else if (first_name.length > vendor_name_length) {
			$("#name-error"+id).html('<span class="text-danger error-msg-small">Name should be of max '+vendor_name_length+' characters.</span>');
			$("#name"+id).val(first_name.slice(0,vendor_name_length));
			input_is_invalid("#name"+id);
		} else {
			$("#name-error"+id).html('&nbsp;');
			input_is_valid("#name"+id);
		}
	} else {
		$("#name-error"+id).html('<span class="text-danger error-msg-small">Please add a name.</span>');
		input_is_invalid("#name"+id);
	}
}

	function valid_company_name(id){
		var company_name = $("#company-name"+id).val();
		if (company_name !='') {
			$("#company-name-error"+id).html("&nbsp;");
			input_is_valid("#company-name"+id)
		}else{
			input_is_invalid("#company-name"+id)
			$("#company-name-error"+id).html("<span class='text-danger'>Please enter valid company name</span>");
		}
	}
	function valid_designation(id){
		var designation = $("#designation"+id).val();
		if (designation !='') {
			$("#designation-error"+id).html("&nbsp;");
			input_is_valid("#designation"+id)
		}else{
			input_is_invalid("#designation"+id)
			$("#designation-error"+id).html("<span class='text-danger'>Please enter valid designation</span>");
		}
	}
	function valid_contact(id){
		var manager_contact = $("#contact"+id).val();
			if (manager_contact !='') {
				if (isNaN(manager_contact)) {
					$("#contact-error"+id).html('<span class="text-danger error-msg-small">Contact number should be only numbers.</span>');
					$("#contact"+id).val(manager_contact.slice(0,-1));
					input_is_invalid("#contact"+id);
				} else if (manager_contact.length != 10) {
					$("#contact-error"+id).html('<span class="text-danger error-msg-small">Contact number should be of '+10+' digits.</span>');
					plenght = $("#contact"+id).val(manager_contact.slice(0,10));
					input_is_invalid("#contact"+id);
					if (plenght.length == 10) {
					$("#contact-error"+id).html('&nbsp;');
					input_is_valid("#contact"+id);	
					} 
				} else{
					$("#contact-error"+id).html('&nbsp;');
					input_is_valid("#contact"+id);
				}
		}else{
			input_is_invalid("#contact"+id)
			$("#contact-error"+id).html("<span class='text-danger'>Please enter valid contact</span>");
		}
	}
	function valid_email(id){
	var email = $("#email"+id).val();
		if (email != '') {
	if(!regex.test(email)) {
			$('#email-error'+id).html("<span class='text-danger error-msg'>Please enter a valid email.</span>");
	    	input_is_invalid('#email'+id);
	    } else { 
	    $('#email-error'+id).html("&nbsp;");
	    	input_is_valid('#email'+id);

	    }
	} else {
		input_is_invalid('#email'+id);
		$('#email-error'+id).html('<span class="text-danger error-msg">Please enter a email.</span>');
	}
	}
	function valid_association(id){
		var association = $("#association"+id).val();
		if (association !='') {
			$("#association-error"+id).html("&nbsp;");
			input_is_valid("#association"+id)
		}else{
			input_is_invalid("#association"+id)
			$("#association-error"+id).html("<span class='text-danger'>Please enter valid association</span>");
		}
	}
	function valid_timepicker(id){
			var timepicker = $("#timepicker"+id).val();
		if (timepicker !='') {
			$("#timepicker-error"+id).html("&nbsp;");
			input_is_valid("#timepicker"+id)
		}else{
			input_is_invalid("#timepicker"+id)
			$("#timepicker-error"+id).html("<span class='text-danger'>Please enter valid timepicker</span>");
		}
	}
	function valid_timepicker1(id){
			var timepicker1 = $("#timepicker1"+id).val();
		if (timepicker1 !='') {
			$("#timepicker1-error"+id).html("&nbsp;");
			input_is_valid("#timepicker1"+id)
		}else{
			input_is_invalid("#timepicker1"+id)
			$("#timepicker1-error"+id).html("<span class='text-danger'>Please enter valid timepicker</span>");
		}
	}