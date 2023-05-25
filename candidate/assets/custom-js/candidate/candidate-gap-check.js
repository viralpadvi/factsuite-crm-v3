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

	var reason_for_gap = [];//$("#reason_for_gap").val(); 

$(".reason_for_gap").each(function(){
	reason_for_gap.push({reason_for_gap:$(this).val()});
});

var date_gap = [];
$(".date-gap").each(function(){
	date_gap.push({date_gap:$(this).val()});
});
	 
	var gap_id = $("#gap_id").val();


	if (reason_for_gap.length > 0) {

	var formdata = new FormData();
	formdata.append('url',22);
	formdata.append('reason_for_gap',JSON.stringify(reason_for_gap)); 
	formdata.append('date_gap',JSON.stringify(date_gap)); 
	formdata.append('link_request_from',link_request_from);
	if (gap_id !='' && gap_id !=null) {
		formdata.append('gap_id',gap_id); 
	}
$("#add-global-database").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
	$.ajax({
    type: "POST",
		url: base_url+"candidate/update_candidate_gap",
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
		  
		   valid_name()
		 
	 
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

 

function valid_name(){
	 
	var reason_for_gap = $('#reason_for_gap').val();
	if (reason_for_gap != '') {
		 
			$('#reason_for_gap-error').html('');
			input_is_valid('#reason_for_gap');
		 
	} else {
		$('#reason_for_gap-error').html('<span class="text-danger error-msg-small">Please enter Reason.</span>');
		input_is_invalid('#reason_for_gap');
	}
}
 