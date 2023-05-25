
function import_excel(){
	var files = $('#add-bulk-upload-case')[0].files[0];
	 
	if (files != undefined) {
		$('#error-client').html('');
		// var form_values = JSON.stringify(selected);
		var formdata = new FormData(); 
		formdata.append('files', files); 
		
		$('#error-client').html('<span class="text-warning error-msg-small">Please wait while we are submitting the details</span>');
		 
		$.ajax({
			type: "POST",
		  	url: base_url+"team/import_excel",
		  	data: formdata,
		  	dataType: "json",
		  	contentType: false,
		    processData: false,
		  	success: function(data){
		  		$('#error-client').html('');
		  		$('#import_excel_file').prop('disabled',false);
		  		$('#import_excel_file').css('background','#005799');
			  	if (data.status == '1') {
			  		toastr.success('New Cases Added successfully.');
					$('#add-bulk-upload-case').val('');
					 
			  	} else {
			  		toastr.error('OOPS! Something went wrong while adding the emails. Please try again.');
		  		}
		  	} 
		});
	} else {
		$('#error-client').html('<span class="text-danger error-msg-small">Please select a valid excel sheet.</span>');
	}
}