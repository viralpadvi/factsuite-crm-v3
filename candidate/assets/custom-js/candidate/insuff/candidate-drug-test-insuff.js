
var url_regex = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/,
	email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
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
	html +='<div id="form0">';
	html +='<div class="row">';
	html +='<div class="col-md-4">';
	html +='<div class="pg-frm">';
	html +='<label>Candidate Name</label>';
	html +='<input name="" class="fld form-control name candidate_name" value="" id="name" type="text">';

	html +='</div>';
	html +='</div>';
	html +='<div class="col-md-4">';
	html +='<div class="pg-frm">';
	html +='<label>Father\'s Name</label>';
	html +='<input name="" class="fld form-control father_name" value=""  id="father_name" type="text">';
	html +='</div>';
	html +='</div>';
	html +='<div class="col-md-4">';
	html +='<div class="pg-frm">';
	html +='<label>Date Of Birth</label>';
	html +='<input name="" class="fld form-control mdate dob date_of_birth" value=""  id="date_of_birth" type="text">';
	html +='</div>';
	html +='</div> ';

	html +='</div>';
	html +='<div class="row">';
	html +='<div class="col-md-6">';
	html +='<div class="pg-frm">';
	html +='<label>Address</label>';
	html +='<textarea class="fld form-control address"  rows="4" id="address"></textarea>';
	html +='</div>';
	html +='</div>';

	html +='<div class="col-md-4">';
	html +='<div class="pg-frm">';
	html +='<label>Contact Number</label>';
	html +='<input name="" class="fld form-control contact_number" value="" id="contact_number" type="text">';
	html +='</div>';
	html +='</div>';
	html +='<div class="col-md-2">';
	html +='<button onclick="remove_form('+j+')"><i class="fa fa-trash"></i></button>';
	html +='</div>';
	html +='</div>';
	html +='</div>';

$("#new_address").append(html);
j++;
});

$("#add-drug-test").on('click',function(){ 

	var address = [];
	$(".address").each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		address.push({address:$(this).val()});
		}
	});
	var code = [];
	$(".code").each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		code.push({code:$(this).val()});
		}
	});
	var contact_number = [];
	$(".contact_number").each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		contact_number.push({mobile_number:$(this).val()});
		}
	});
	var name = [];
	$(".name").each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		name.push({candidate_name:$(this).val()});
		}
	});
	var date_of_birth = [];
	$(".mdate").each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		date_of_birth.push({dob:$(this).val()});
		}
	}); 
	var father_name = [];
	$(".father_name").each(function(){
		if ($(this).val() !='' && $(this).val() !=null) {
		father_name.push({father_name:$(this).val()});
		}
	}); 
	var drugtest_id = $('#drugtest_id').val();
	var formdata = new FormData();
	formdata.append('url',4);
	formdata.append('address',JSON.stringify(address));
	formdata.append('name',JSON.stringify(name));
	formdata.append('father_name',JSON.stringify(father_name));
	formdata.append('date_of_birth',JSON.stringify(date_of_birth)); 
	formdata.append('contact_no',JSON.stringify(contact_number)); 
	formdata.append('code',JSON.stringify(code)); 

	if (drugtest_id !='' && drugtest_id !=null) {
		formdata.append('drugtest_id',drugtest_id);
	}

	if (address.length > 0 &&
contact_number.length > 0 &&
name.length > 0 &&
date_of_birth.length > 0 &&
father_name.length > 0 ) {
		$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
$("#add-drug-test").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

		$.ajax({
            type: "POST",
              url: base_url+"candidate/update_candidate_drug_test_insuff",
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
              	$("#add-drug-test").html("Save & Continue")
              }
            });
	}else{

		$(".address").each(function(){
			var MyID = $(this).attr("id"); 
		   var number = MyID.match(/\d+/); 
		   valid_address(number)
		}); 
		$(".contact_number").each(function(){
			var MyID = $(this).attr("id"); 
			var number = MyID.match(/\d+/); 
			valid_contact_number(number)
		}); 
		$(".name").each(function(){
		   var MyID = $(this).attr("id"); 
		   var number = MyID.match(/\d+/); 
		   valid_name(number)
		}); 
		$(".mdate").each(function(){
		   var MyID = $(this).attr("id"); 
		   var number = MyID.match(/\d+/); 
		   valid_date_of_birth(number)
		});  
		$(".father_name").each(function(){
			var MyID = $(this).attr("id"); 
			var number = MyID.match(/\d+/); 
			valid_father_name(number)
		}); 
	}

});


function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}


function remove_form(id){
	$("#form"+id).remove();
}

function valid_address(id){
	var address = $("#address"+id).val();
	if (address !='') {
		$("#address-error"+id).html("&nbsp;");
		input_is_valid("#address"+id)
	}else{
		input_is_invalid("#address"+id)
		$("#address-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid address</span>");
	}
}
function valid_contact_number(id){ 
	var contact_number = $("#contact_number"+id).val();
	if (contact_number !='') {
		if (isNaN(contact_number)) {
			$("#contact_number-error"+id).html('<span class="text-danger error-msg-small">Contact number should be only numbers.</span>');
			$("#contact_number"+id).val(contact_number.slice(0,-1));
			input_is_invalid("#contact_number"+id);
		} else if (contact_number.length != 10) {
			$("#contact_number-error"+id).html('<span class="text-danger error-msg-small">Contact number should be of '+10+' digits.</span>');
			plenght = $("#contact_number"+id).val(contact_number.slice(0,10));
			input_is_invalid("#contact_number"+id);
			if (plenght.length == 10) {
			$("#contact_number-error"+id).html('&nbsp;');
			input_is_valid("#contact_number"+id);	
			}
		} else {
			$("#contact_number-error"+id).html('&nbsp;');
			input_is_valid("#contact_number"+id);
		} 
	}else{
		$("#contact_number-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid contact number</span>");
		input_is_invalid("#contact_number"+id)
	}
}
 

function valid_name(id){
	 
	var name = $('#name'+id).val();
	if (name != '') {
		if (!alphabets_only.test(name)) {
			$('#name-error'+id).html('<span class="text-danger error-msg-small">Name should be only alphabets.</span>');
			$('#name'+id).val(name.slice(0,-1));
			input_is_invalid('#name'+id);
		} else if (name.length > vendor_name_length) {
			$('#name-error'+id).html('<span class="text-danger error-msg-small">Name should be of max '+vendor_name_length+' characters.</span>');
			$('#name'+id).val(name.slice(0,vendor_name_length));
			input_is_invalid('#name');
		} else {
			$('#name-error'+id).html('&nbsp;');
			input_is_valid('#name'+id);
		}
	} else {
		$('#name-error'+id).html('<span class="text-danger error-msg-small">Please enter name.</span>');
		input_is_invalid('#name'+id);
	}
}

 
function valid_father_name(id){
	 
	var father_name = $('#father_name'+id).val();
	if (father_name != '') {
		if (!alphabets_only.test(father_name)) {
			$('#father_name-error'+id).html('<span class="text-danger error-msg-small">Father name should be only alphabets.</span>');
			$('#father_name'+id).val(father_name.slice(0,-1));
			input_is_invalid('#father_name'+id);
		} else if (father_name.length > vendor_name_length) {
			$('#father_name-error'+id).html('<span class="text-danger error-msg-small">Father name should be of max '+vendor_name_length+' characters.</span>');
			$('#father_name'+id).val(father_name.slice(0,vendor_name_length));
			input_is_invalid('#father_name'+id);
		} else {
			$('#father_name-error'+id).html('&nbsp;');
			input_is_valid('#father_name'+id);
		}
	} else {
		$('#father_name-error'+id).html('<span class="text-danger error-msg-small">Please add a father Name.</span>');
		input_is_invalid('#father_name'+id);
	}
}


function valid_date_of_birth(id){
	var date_of_birth = $("#date_of_birth"+id).val();
	if (date_of_birth !='') {
		$("#date_of_birth-error"+id).html("&nbsp;");
		input_is_valid("#date_of_birth"+id)
	}else{
		input_is_invalid("#date_of_birth"+id)
		$("#date_of_birth-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid date of birth</span>");
	}
}


