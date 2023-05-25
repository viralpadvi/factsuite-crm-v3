// 


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

$('#first-name').on('keyup blur',function(){
	valid_first_name();
});

$('#last-name').on('keyup blur',function(){
	valid_last_name();
});

$('#father-name').on('keyup blur',function(){
	valid_father_name();
});

$("#date-of-birth").on('keyup keydown input blur change',function(){
	valid_birth_date();
});



function valid_first_name(){
	 
	var first_name = $('#first-name').val();
	if (first_name != '') {
		if (!alphabets_only.test(first_name)) {
			$('#first-name-error').html('<span class="text-danger error-msg-small">First name should be only alphabets.</span>');
			$('#first-name').val(first_name.slice(0,-1));
			input_is_invalid('#first-name');
		} else if (first_name.length > vendor_name_length) {
			$('#first-name-error').html('<span class="text-danger error-msg-small">First name should be of max '+vendor_name_length+' characters.</span>');
			$('#first-name').val(first_name.slice(0,vendor_name_length));
			input_is_invalid('#first-name');
		} else {
			$('#first-name-error').html('');
			input_is_valid('#first-name');
		}
	} else {
		$('#first-name-error').html('<span class="text-danger error-msg-small">Please enter first name.</span>');
		input_is_invalid('#first-name');
	}
}

 

function valid_last_name(){
	 
	var last_name = $('#last-name').val();
	if (last_name != '') {
		if (!alphabets_only.test(last_name)) {
			$('#last-name-error').html('<span class="text-danger error-msg-small">Last name should be only alphabets.</span>');
			$('#last-name').val(last_name.slice(0,-1));
			input_is_invalid('#last-name');
		} else if (last_name.length > vendor_name_length) {
			$('#last-name-error').html('<span class="text-danger error-msg-small">Last name should be of max '+vendor_name_length+' characters.</span>');
			$('#last-name').val(last_name.slice(0,vendor_name_length));
			input_is_invalid('#last-name');
		} else {
			$('#last-name-error').html('');
			input_is_valid('#last-name');
		}
	} else {
		$('#last-name-error').html('<span class="text-danger error-msg-small">Please add a last name.</span>');
		input_is_invalid('#last-name');
	}
}
 

function valid_father_name(){
	 
	var father_name = $('#father-name').val();
	if (father_name != '') {
		if (!alphabets_only.test(father_name)) {
			$('#father-name-error').html('<span class="text-danger error-msg-small">Father name should be only alphabets.</span>');
			$('#father-name').val(father_name.slice(0,-1));
			input_is_invalid('#father-name');
		} else if (father_name.length > vendor_name_length) {
			$('#father-name-error').html('<span class="text-danger error-msg-small">Father name should be of max '+vendor_name_length+' characters.</span>');
			$('#father-name').val(father_name.slice(0,vendor_name_length));
			input_is_invalid('#father-name');
		} else {
			$('#father-name-error').html('');
			input_is_valid('#father-name');
		}
	} else {
		$('#father-name-error').html('<span class="text-danger error-msg-small">Please add a father name.</span>');
		input_is_invalid('#father-name');
	}
}


function valid_birth_date(){
	var birthdate = $('#date_of_birth').val();
	if (birthdate != '') {
		$('#date-of-birth-error').html('');
		input_is_valid('#date_of_birth');
	} else {
		input_is_invalid('#date_of_birth');
		$('#date_of_birth-error').html('<span class="text-danger error-msg-small">Please enter your birth date.</span>');
	}	
}




$("#candidate-oig").on('click',function(){ 

	var oig_id = $("#oig_id").val();
	var first_name = $("#first-name").val();
	 
	var last_name = $("#last-name").val(); 

	if (first_name !='' && last_name !='') {

	var formdata = new FormData();
	formdata.append('url',34);
	formdata.append('first_name',first_name);
	formdata.append('last_name',last_name); 
	formdata.append('link_request_from',link_request_from);
	if (oig_id !='' && oig_id !=null) {
		formdata.append('oig_id',oig_id); 
	}
$("#candidate-oig").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
	$.ajax({
    type: "POST",
		url: base_url+"candidate/update_candidate_oig",
		data:formdata,
		dataType: 'json',
		contentType: false,
		processData: false,
		success: function(data) {
			if (data.status == '1') {
				// toastr.success('successfully saved data.');  
				window.location.href=base_url+data.url;
				// if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
				// } else {
				// 	window.location.href=base_url+'m-component-list';
				// }
      } else {
				toastr.error('Something went wrong while saving the data. Please try again.'); 	
      }
			$("#warning-msg").html("");
			$("#candidate-oig").html("Save & Continue");
		}
	});

	}else{
	 
		   valid_first_name();
			valid_last_name();
		 
		 
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

 

function valid_name(id=''){
	 
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
			$('#name-error'+id).html('');
			input_is_valid('#name'+id);
		}
	} else {
		$('#name-error'+id).html('<span class="text-danger error-msg-small">Please enter name.</span>');
		input_is_invalid('#name'+id);
	}
}

/*
function valid_father_name(id=''){
	var father_name = $("#father_name"+id).val();
	if (father_name !='') {
		$("#father_name-error"+id).html("");
		input_is_valid("#father_name"+id)
	}else{
		$("#father_name-error"+id).html("<span class='text-danger error-msg-small'>Please Select Valid father's name.</span>");
		input_is_invalid("#father_name"+id)
	}
}
*/

function valid_father_name(){
	 
	var father_name = $('#father_name').val();
	if (father_name != '') {
		if (!alphabets_only.test(father_name)) {
			$('#father_name-error').html('<span class="text-danger error-msg-small">Father name should be only alphabets.</span>');
			$('#father_name').val(father_name.slice(0,-1));
			input_is_invalid('#father_name');
		} else {
			$('#father_name-error').html('');
			input_is_valid('#father_name');
		}
	} else {
		$('#father_name-error').html('<span class="text-danger error-msg-small">Please add a father name.</span>');
		input_is_invalid('#father_name');
	}
}

 

function valid_date_of_birth(id=''){
	var date_of_birth = $("#date_of_birth"+id).val();
	if (date_of_birth !='') {
		$("#date_of_birth-error"+id).html("");
		input_is_valid("#date_of_birth"+id)
	}else{
		input_is_invalid("#date_of_birth"+id)
		$("#date_of_birth-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid date of birth</span>");
	}
}
