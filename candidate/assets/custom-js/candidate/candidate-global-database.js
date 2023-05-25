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


$("#add-global-database").on('click',function(){ 

	var name = [];
	$(".name").each(function(){
		name.push($(this).val());
	});
	var father_name = [];
	$(".father_name").each(function(){
		father_name.push($(this).val());
	});
	var date_of_birth = [];
	$(".mdate").each(function(){
		date_of_birth.push($(this).val());
	}); 

	var global_id = $("#global_id").val();


	if (name !='' && father_name !='' && date_of_birth !='' ) {

	var formdata = new FormData();
	formdata.append('url',5);
	formdata.append('name',name);
	formdata.append('father_name',father_name);
	formdata.append('date_of_birth',date_of_birth); 
	formdata.append('link_request_from',link_request_from);
	if (global_id !='' && global_id !=null) {
		formdata.append('global_id',global_id); 
	}
$("#add-global-database").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
	$.ajax({
    type: "POST",
		url: base_url+"candidate/update_candidate_global",
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
			$("#add-global-database").html("Save & Continue");
		}
	});

	}else{
		$(".name").each(function(){
		   // var MyID = $(this).attr("id"); 
		   // var number = MyID.match(/\d+/); 
		   valid_name()
		}); 
		$(".mdate").each(function(){
		   // var MyID = $(this).attr("id"); 
		   // var number = MyID.match(/\d+/); 
		   valid_date_of_birth()
		});  
		$(".father_name").each(function(){
			// var MyID = $(this).attr("id"); 
			// var number = MyID.match(/\d+/); 
			valid_father_name()
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
