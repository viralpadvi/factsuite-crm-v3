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


	$("#addresses").change(function(){
		// alert($(this).prop('checked'))
		if ($(this).prop('checked')) { 
			var i = 0;
				var address =candidate_info['candidate_flat_no']+', '+candidate_info['candidate_street']+', '+candidate_info['candidate_area'];
				$("#address").val(address);  
		 
		}else{
			var i = 0;
			$("#address").val(''); 
		} 
	});


$("#company_url").on('keyup blur change',valid_client_website);

$("#reporting-manager-email-id").on('keyup blur',function() {
	valid_reporting_manager_email_id();
});

$("#hr-email-id").on('keyup blur',function() {
	valid_hr_email_id();
});

function valid_client_website() {
	var client_website = $('#company_url').val();
	if (client_website != '') {
		if (!url_regex.test(client_website)) {
			$('#company_url-error').html('<span class="text-danger error-msg-small">Please enter the correct URL.("http/https://www.example.com")</span>');
			input_is_invalid('#company_url');
			return 0;
		} else {
			$('#company_url-error').html('');
			input_is_valid('#company_url');
			return 1;
		}
	} else {
		input_is_invalid('#company_url');
		$('#company_url-error').html('<span class="text-danger error-msg-small">Please enter the website URL</span>');
		return 0;
	}
}

$("#file1").on("change", handleFileSelect_candidate_aadhar);
$("#file2").on("change", handleFileSelect_candidate_pan);
$("#file3").on("change", handleFileSelect_candidate_proof);
$("#file4").on("change", handleFileSelect_candidate_bank);


function handleFileSelect_candidate_aadhar(e){ 
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#file1-error").html('');
        $(".file-name1").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_aadhar_'+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+i+'" onclick="removeFile_candidate_aadhar('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_aadhar\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                candidate_aadhar.push(files[i]);
	                $(".file-name1").append(html);
	        	} 
	        }
	    } else {
	    	$("#file1-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#file1').val('');
	    }
    } else {
        $("#file1-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
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
    	$("#file1").val('');
    }
    $('#file_candidate_aadhar_'+id).remove(); 
}


function handleFileSelect_candidate_pan(e){
	    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#file2-error").html('');
        $(".file-name2").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name  
	             	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_pan_'+i+'"><span>'+fileName+' <a id="file_candidate_pan'+i+'" onclick="removeFile_candidate_pan('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image_pan('+i+',\'candidate_pan\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]);
	                candidate_pan.push(files[i]);
	                $(".file-name2").append(html);
	        	} 
	        }
	    } else {
	    	$("#file2-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#file2').val('');
	    }
    } else {
        $("#file2-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}


function removeFile_candidate_pan(id) {

    var file = $('#file_candidate_pan'+id).data("file");
    for(var i = 0; i < candidate_pan.length; i++) {
        if(candidate_pan[i].name === file) {
            candidate_pan.splice(i,1); 
        }
    }
    if (candidate_pan.length == 0) {
    	$("#file2").val('');
    }
    $('#file_candidate_pan_'+id).remove(); 
}

function handleFileSelect_candidate_proof(e){
	    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#file3-error").html('');
        $(".file-name3").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	        		 var fileName = files[i].name; // get file name  
	        	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	  html = '<div id="file_candidate_proof_'+i+'"><span>'+fileName+' <a id="file_candidate_proof'+i+'" onclick="removeFile_candidate_proof('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image_proof('+i+',\'candidate_proof\')" ><i class="fa fa-eye"></i></a></span></div>';
	                candidate_proof.push(files[i]);
	                $(".file-name3").append(html); 
	        	} 
	        }
	    } else {
	    	$("#file3-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#file3').val('');
	    }
    } else {
        $("#file3-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_candidate_proof(id) {

    var file = $('#file_candidate_proof'+id).data("file");
    for(var i = 0; i < candidate_proof.length; i++) {
        if(candidate_proof[i].name === file) {
            candidate_proof.splice(i,1); 
        }
    }
    if (candidate_proof.length == 0) {
    	$("#file3").val('');
    }
    $('#file_candidate_proof_'+id).remove(); 
}
 // $('#frame').attr('src',URL.createObjectURL(event.target.files[0]));
function handleFileSelect_candidate_bank(e){
	    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#file4-error").html('');
        $(".file-name4").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	        		 var fileName = files[i].name; // get file name  
	        	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_bank_'+i+'"><span>'+fileName+' <a id="file_candidate_bank'+i+'" onclick="removeFile_candidate_bank('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image_bank('+i+',\'candidate_bank\')" ><i class="fa fa-eye"></i></a></span></div>';
	                candidate_bank.push(files[i]);
	                $(".file-name4").append(html);
	        	}
	           
	        }
	    } else {
	    	$("#file4-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#file4').val('');
	    }
    } else {
        $("#file4-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_candidate_bank(id) {

    var file = $('#file_candidate_bank'+id).data("file");
    for(var i = 0; i < candidate_bank.length; i++) {
        if(candidate_bank[i].name === file) {
            candidate_bank.splice(i,1); 
        }
    }
    if (candidate_bank.length == 0) {
    	$("#file4").val('');
    }
    $('#file_candidate_bank_'+id).remove(); 

}

function view_image(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_aadhar[id]);
}

function view_image_pan(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_pan[id]);
}

function view_image_proof(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader(); 
        reader.onload = function(event) {
           $("#view-img").html("<img src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_proof[id]);
}

function view_image_bank(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_bank[id]);
} 

function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   	$("#view-img").html("<img src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");    
}

function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}

function valid_reporting_manager_email_id() {
	var variable_array = {};
	variable_array['input_id'] = '#reporting-manager-email-id';
	variable_array['error_msg_div_id'] = '#reporting-manager-email-id-error';
	variable_array['empty_input_error_msg'] = 'Please enter your email id.';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	return mandatory_email_id(variable_array);
}

function valid_hr_email_id() {
	var variable_array = {};
	variable_array['input_id'] = '#hr-email-id';
	variable_array['error_msg_div_id'] = '#hr-email-id-error';
	variable_array['empty_input_error_msg'] = 'Please enter your email id.';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	return mandatory_email_id(variable_array);
}

function mandatory_email_id(variable_array) {
	var email = $(variable_array.input_id).val().toLowerCase();
	if (email != '') {
	    if(!email_regex.test(email)) {
	    	$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.not_an_email_input_error_msg+'</span>');
	    	return 0;
	    } else {
	    	$(variable_array.error_msg_div_id).html('');
	    	return 1;
	    }
	} else {
		$(variable_array.error_msg_div_id).html('<span class="text-danger error-msg-small">'+variable_array.empty_input_error_msg+'</span>');
		return 0;
	}
}


$("#add_employments").on('click',function() { 
 	var designation = $("#designation").val();
 	var department = $("#department").val();
 	var employee_id = $("#employee_id").val();

 	var company_name = $("#company-name").val();
 	var address = $("#address").val();
 	var annual_ctc = $("#annual-ctc").val();

 	var reasion = $("#reasion").val();
 	var joining_date = $("#joining-date").val();
 	var relieving_date = $("#relieving-date").val();

 	var manager_name = $("#reporting-manager-name").val();
 	var manager_designation = $("#reporting-manager-designation").val(); 
 	var manager_contact = $("#reporting-manager-contact").val();
 	var reporting_manager_email_id = $('#reporting-manager-email-id').val();

 	var hr_name = $("#hr-name").val();
 	var hr_contact = $("#hr-contact").val();
 	var hr_code = $("#hr-code").val();
 	var code = $("#code").val();
 	var hr_email_id = $("#hr-email-id").val();

 	var company_url = $("#company_url").val(); 

 	var appointment_letter = $('#appointment_letter').val();
	var experience_relieving_letter = $('#experience_relieving_letter').val();
	var last_month_pay_slip = $('#last_month_pay_slip').val();

 	var valid_client_website_var = valid_client_website(),
 		valid_reporting_manager_email_id_var = valid_reporting_manager_email_id(),
 		valid_hr_email_id_var = valid_hr_email_id();
 	if (designation !='' &&
		department !='' &&
		employee_id !='' &&
		company_name !='' &&
		address !='' &&
		annual_ctc !='' &&
		reasion !='' &&
		joining_date !='' &&
		relieving_date !='' &&
		manager_name !='' &&
		manager_designation !='' &&
		manager_contact !='' &&
		hr_name !='' &&
		hr_contact !='' && 
		valid_client_website_var == 1 &&
		valid_reporting_manager_email_id_var == 1 &&
		valid_hr_email_id_var == 1 && 
		((candidate_aadhar.length != 0 ||(appointment_letter.length != 0 && appointment_letter !=null)) || (candidate_pan.length != 0 || (experience_relieving_letter.length != 0 && experience_relieving_letter !=null)) || (candidate_proof.length != 0  || (last_month_pay_slip.length != 0 && last_month_pay_slip !=null)) ) ) { 
		 $("#add_employments").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

		 	var formdata = new FormData();
		 	formdata.append('url',6);
				formdata.append('designation',designation);
				formdata.append('department',department);
				formdata.append('employee_id',employee_id);
				formdata.append('company_name',company_name);
				formdata.append('address',address);
				formdata.append('annual_ctc',annual_ctc);
				formdata.append('reasion',reasion);
				formdata.append('joining_date',joining_date);
				formdata.append('relieving_date',relieving_date);
				formdata.append('manager_name',manager_name);
				formdata.append('manager_designation',manager_designation);
				formdata.append('manager_contact',manager_contact);
				formdata.append('hr_name',hr_name);
				formdata.append('hr_contact',hr_contact);
				formdata.append('code',code);
				formdata.append('hr_code',hr_code);
				formdata.append('company_url',company_url);
				formdata.append('reporting_manager_email_id',reporting_manager_email_id);
				formdata.append('hr_email_id',hr_email_id);
				formdata.append('link_request_from',link_request_from);
 

				var current_emp_id = $("#current_emp_id").val();
				if (current_emp_id !='' && current_emp_id !=null) {
					formdata.append('current_emp_id',current_emp_id);
				}


				if (candidate_aadhar.length > 0) {
				for (var i = 0; i < candidate_aadhar.length; i++) { 
					formdata.append('candidate_aadhar[]',candidate_aadhar[i]);
				}
				}else{
					formdata.append('candidate_aadhar[]','');
				}
				if (candidate_pan.length > 0) {
					for (var i = 0; i < candidate_pan.length; i++) { 
						formdata.append('candidate_pan[]',candidate_pan[i]);
					}
				}else{
					formdata.append('candidate_pan[]','');
				}
				if (candidate_proof.length > 0) {
					for (var i = 0; i < candidate_proof.length; i++) { 
						formdata.append('candidate_proof[]',candidate_proof[i]);
					}
				}else{
					formdata.append('candidate_proof[]','');
				}
				if (candidate_bank.length > 0) {
					for (var i = 0; i < candidate_bank.length; i++) { 
						formdata.append('candidate_bank[]',candidate_bank[i]);
					}
				}else{
					formdata.append('candidate_bank[]','');
				}


		$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
			$.ajax({
		            type: "POST",
		              url: base_url+"candidate/update_candidate_employment",
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
		              		$("#add_employments").html("Save & Continue")
		              }
		        });
		}else{ 
			$("#add_employments").html("Save & Continue")
			valid_designation()
			valid_department()
			valid_employee_id()
			valid_company_name()
			valid_address()
			valid_annual_ctc()
			valid_reasion()
			valid_joining_date()
			valid_relieving_date()
			valid_reporting_manager_name()
			valid_reporting_manager_designation()
			valid_reporting_manager_contact()
			valid_hr_name()
			valid_hr_contact()


			if (candidate_aadhar.length == 0 && appointment_letter == '') {
				$("#appointment_letter-error").html("<span class='text-danger error-msg-small'>Please Appointment letter</span>");
			}
			if (candidate_pan.length == 0 && experience_relieving_letter == '') {
				$("#experience_relieving_letter-error").html("<span class='text-danger error-msg-small'>Please Upload Experience / Relieving Letter</span>");
			}
			if (candidate_proof.length == 0 && last_month_pay_slip == '' ) {
				$("#last_month_pay_slip-error").html("<span class='text-danger error-msg-small'>Please Upload Last Pay slip</span>");
			}
		}
 });


	$("#designation").on('keyup blur',valid_designation);
	$("#department").on('keyup blur',valid_department);
	$("#employee_id").on('keyup blur',valid_employee_id);
	$("#company-name").on('keyup blur',valid_company_name);
	$("#address").on('keyup blur',valid_address);
	$("#annual-ctc").on('keyup blur',valid_annual_ctc);
	$("#reasion").on('keyup blur',valid_reasion);
	$("#joining-date").on('keyup blur change',valid_joining_date);
	$("#relieving-date").on('keyup blur change',valid_relieving_date);
	$("#reporting-manager-name").on('keyup blur',valid_reporting_manager_name);
	$("#reporting-manager-designation").on('keyup blur',valid_reporting_manager_designation);
	$("#reporting-manager-contact").on('keyup blur',valid_reporting_manager_contact);
	$("#hr-name").on('keyup blur',valid_hr_name);
	$("#hr-contact").on('keyup blur',valid_hr_contact);


/*	function input_is_valid(input_id) {
		$(input_id).removeClass('is-invalid');
		$(input_id).addClass('is-valid');
	}

	function input_is_invalid(input_id) {
		$(input_id).removeClass('is-valid');
		$(input_id).addClass('is-invalid');
	}
*/
	function valid_designation(){ 
		var designation = $("#designation").val();
		if (designation !='') {
			$("#designation-error").html("");
			input_is_valid("#designation")
		}else{
			input_is_invalid("#designation")
			$("#designation-error").html("<span class='text-danger error-msg-small'>Please enter valid designation</span>");
		}
	}
	function valid_department(){
		var department = $("#department").val();
			if (department !='') {
			$("#department-error").html("");
			input_is_valid("#department")
		}else{
			input_is_invalid("#department")
			$("#department-error").html("<span class='text-danger error-msg-small'>Please enter valid department</span>");
		}
	}
	function valid_employee_id(){
		var employee_id = $("#employee_id").val();
			if (employee_id !='') {
			$("#employee_id-error").html("");
			input_is_valid("#employee_id")
		}else{
			input_is_invalid("#employee_id")
			$("#employee_id-error").html("<span class='text-danger error-msg-small'>Please enter valid employee Id</span>");
		}
	}
	function valid_company_name(){
		var company_name = $("#company-name").val();
			if (company_name !='') {
			$("#company-name-error").html("");
			input_is_valid("#company-name")
		}else{
			input_is_invalid("#company-name")
			$("#company-name-error").html("<span class='text-danger error-msg-small'>Please enter valid company name</span>");
		}
	}
	function valid_address(){
		var address = $("#address").val();
			if (address !='') {
			$("#address-error").html("");
			input_is_valid("#address")
		}else{
			input_is_invalid("#address")
			$("#address-error").html("<span class='text-danger error-msg-small'>Please enter valid address</span>");
		}
	}
	function valid_annual_ctc(){
		var annual_ctc = $("#annual-ctc").val();
			if (annual_ctc !='') {
			$("#annual-ctc-error").html("");
			input_is_valid("#annual-ctc")
		}else{
			input_is_invalid("#annual-ctc")
			$("#annual-ctc-error").html("<span class='text-danger error-msg-small'>Please enter annual CTC</span>");
		}
	}
	function valid_reasion(){
		var reasion = $("#reasion").val();
			if (reasion !='') {
			$("#reasion-error").html("");
			input_is_valid("#reasion")
		}else{
			input_is_invalid("#reasion")
			$("#reasion-error").html("<span class='text-danger error-msg-small'>Please enter valid reason</span>");
		}
	}
	function valid_joining_date(){
		var joining_date = $("#joining-date").val();
			if (joining_date !='') {
				$("#relieving-date").attr('disabled',false);
			$("#joining-date-error").html("");
			input_is_valid("#joining-date")
		}else{
			input_is_invalid("#joining-date")
			$("#joining-date-error").html("<span class='text-danger error-msg-small'>Please enter valid joining date</span>");
		}
	}
	function valid_relieving_date(){
		var relieving_date = $("#relieving-date").val();
		if (relieving_date != '') {
			$("#relieving-date-error").html("");
			input_is_valid("#relieving-date")
		}else{
			input_is_invalid("#relieving-date")
			$("#relieving-date-error").html("<span class='text-danger error-msg-small'>Please enter valid relieving date</span>");
		}
	}
 
function valid_reporting_manager_name(){
	 
	var reporting_manager = $("#reporting-manager-name").val();
	if (reporting_manager != '') {
		if (!alphabets_only.test(reporting_manager)) {
			$("#reporting-manager-name-error").html('<span class="text-danger error-msg-small">Reporting manager name should be only alphabets.</span>');
			$("#reporting-manager-name").val(reporting_manager.slice(0,-1));
			input_is_invalid("#reporting-manager-name");
		} else if (reporting_manager.length > vendor_name_length) {
			$("#reporting-manager-name-error").html('<span class="text-danger error-msg-small">Reporting manager name should be of max '+vendor_name_length+' characters.</span>');
			$("#reporting-manager-name").val(reporting_manager.slice(0,vendor_name_length));
			input_is_invalid("#reporting-manager-name");
		} else {
			$("#reporting-manager-name-error").html('');
			input_is_valid("#reporting-manager-name");
		}
	} else {
		$("#reporting-manager-name-error").html('<span class="text-danger error-msg-small">Please add a reporting manager Name.</span>');
		input_is_invalid("#reporting-manager-name");
	}
}
 
	 
	function valid_reporting_manager_designation(){
		var manager_designation = $("#reporting-manager-designation").val();
		if (manager_designation !='') {
			$("#reporting-manager-designation-error").html("");
			input_is_valid("#reporting-manager-designation")
		}else{
			input_is_invalid("#reporting-manager-designation")
			$("#reporting-manager-designation-error").html("<span class='text-danger error-msg-small'>Please enter valid reporting manager designation</span>");
		}
	}
	function valid_reporting_manager_contact(){
		var manager_contact = $("#reporting-manager-contact").val();
			if (manager_contact !='') {
				if (isNaN(manager_contact)) {
					$("#reporting-manager-contact-error").html('<span class="text-danger error-msg-small">Contact number should be only numbers.</span>');
					$("#reporting-manager-contact").val(manager_contact.slice(0,-1));
					input_is_invalid("#reporting-manager-contact");
				} else if (manager_contact.length != 10) {
					$("#reporting-manager-contact-error").html('<span class="text-danger error-msg-small">Contact number should be of '+10+' digits.</span>');
					var plenght = $("#reporting-manager-contact").val(manager_contact.slice(0,10));
					input_is_invalid("#reporting-manager-contact");
					// alert(plenght.length)
					if (plenght.length == 10) {
					$("#reporting-manager-contact-error").html('');
					input_is_valid("#reporting-manager-contact");	
					} 
				}else{
						$("#reporting-manager-contact-error").html('');
					input_is_valid("#reporting-manager-contact");	
				}
		}else{
			input_is_invalid("#reporting-manager-contact")
			$("#reporting-manager-contact-error").html("<span class='text-danger error-msg-small'>Please enter valid reporting manager contact</span>");
		}
	}
 
function valid_hr_name(){
	 
	var last_name = $("#hr-name").val();
	if (last_name != '') {
		if (!alphabets_only.test(last_name)) {
			$("#hr-name-error").html('<span class="text-danger error-msg-small">HR name should be only alphabets.</span>');
			$("#hr-name").val(last_name.slice(0,-1));
			input_is_invalid("#hr-name");
		} else if (last_name.length > vendor_name_length) {
			$("#hr-name-error").html('<span class="text-danger error-msg-small">HR name should be of max '+vendor_name_length+' characters.</span>');
			$("#hr-name").val(last_name.slice(0,vendor_name_length));
			input_is_invalid("#hr-name");
		} else {
			$("#hr-name-error").html('');
			input_is_valid("#hr-name");
		}
	} else {
		$("#hr-name-error").html('<span class="text-danger error-msg-small">Please add a HR Name.</span>');
		input_is_invalid("#hr-name");
	}
}

	function valid_hr_contact(){
		var hr_contact = $("#hr-contact").val();
			if (hr_contact !='') {
				if (isNaN(hr_contact)) {
					$("#hr-contact-error").html('<span class="text-danger error-msg-small">Contact number should be only numbers.</span>');
					$("#hr-contact").val(hr_contact.slice(0,-1));
					input_is_invalid("#hr-contact");
				} else if (hr_contact.length != 10) {
					$("#hr-contact-error").html('<span class="text-danger error-msg-small">Contact number should be of '+10+' digits.</span>');
				var plenght = $("#hr-contact").val(hr_contact.slice(0,10));
					input_is_invalid("#hr-contact");
					if (plenght.length == 10) {
					$("#hr-contact-error").html('');
					input_is_valid("#hr-contact");	
					} 
				}else{
					$("#hr-contact-error").html('');
					input_is_valid("#hr-contact");	
				}
		}else{
			input_is_invalid("#hr-contact")
			$("#hr-contact-error").html("<span class='text-danger error-msg-small'>Please enter valid HR contact</span>");
		}
	} 




function removeFile_documents(id,param){
	// alert($("#remove_file_"+param+"_documents"+id).data('path'))
	$("#myModal-remove").modal('show');
	$("#remove-caption").html("<h4 class='text-danger'>Are you sure removing this  image?</h4>")
	$("#button-area").html('<a href="" data-dismiss="modal" class="exit-btn float-center text-center mr-1">Close</a><button class="btn btn-sm btn-danger text-white" onclick="image_remove('+id+',\''+param+'\')">remove</button>')

}


function image_remove(id,param){ 
var	table = 'current_employment';
var image_name = $("#remove_file_"+param+"_documents"+id).data('file');
var path = $("#remove_file_"+param+"_documents"+id).data('path');
var image_field = $("#remove_file_"+param+"_documents"+id).data('field');

$.ajax({
        type: "POST",
          url: base_url+"candidate/remove_candidate_image",
          data:{table:table,image_field:image_field,path:path,image_name:image_name},
          dataType: 'json', 
          success: function(data) {
			if (data.status == '1') {
				// toastr.success('successfully removing image.');  
				$("#"+param+id).remove(); 
          	}else{
          		toastr.error('Something went wrong while removing this image. Please try again.'); 	
          	} 
          	$("#myModal-remove").modal('hide');
          }
    });
}