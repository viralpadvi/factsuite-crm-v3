var candidate_aadhar = [];
var max_client_document_select = 20;
var client_document_size = 200000000;

$("#client-documents").on("change", handleFileSelect_candidate_aadhar); 


function handleFileSelect_candidate_aadhar(e){ 
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
function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}



$('#conformtion_dialog').click(function(){
	$('#conformtion').modal('show');
});

$('#cancle-data-btn').on('click',function(){
	$("#warning-msg").html("");
})

$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#conformtion").hasClass('show')){  
		var key = e.which;
	    if (key == 13) {
	      	current_emp()
	      	return false;
	    }
	}
});

$('#submit-data').on('click',function(){
	current_emp()
});

function current_emp(){
	$("#wait-message").html("<span class='text-danger'>Please wait operation in proccess.</span>");
 	$('submit-data').attr('disabled',true);
  	var employee_id = $('#employee_id').val()
  	var designation = $('#designation').val()
  	var department = $('#department').val()
  	var date_of_joining = $('#date_of_joining').val()
  	var date_of_relieving = $('#date_of_relieving').val()
  	var salary_lakhs = $('#salary_lakhs').val()
  	var currency = $('#currency').val()
  	var managers_designation = $('#managers_designation').val()
  	var managers_contact = $('#managers_contact').val()
  	var physical_visit = $('#physical-visit').val()
  	var remark_hr_name = $('#remark_hr_name').val()
  	var remark_hr_email = $('#remark_hr_email').val()
  	var remark_hr_phone = $('#remark_hr_phone').val()
  	var remarks_reason_for_leaving = $('#remarks_reason_for_leaving').val()
  	var eligible_for_re_hire = $('#eligible_for_re_hire').val()
  	var attendance_punctuality = $('#attendance_punctuality').val()
  	var job_performance = $('#job_performance').val()
  	var exit_status = $('#exit_status').val()
  	var disciplinary_issues = $('#disciplinary_issues').val()
  	var verification_remarks = $('#verification_remarks').val()
  	var insuff_remarks = $('#insuff_remarks').val()
  	var insuff_closure_remarks = $('#insuff_closure_remarks').val()
  	var candidate_id_hidden = $('#candidate_id_hidden').val()
  	var action_status = $("#analyst_status").val();
	var userID = $("#userID").val();
	var userRole = $("#userRole").val();
	var verification_fee = $("#verification_fee").val();
	var op_action_status = $('#op_action_status').val();
	var ouputQcComment = $('#ouputQcComment').val();


	// alert(physical_visit);

	var formdata = new FormData();
	formdata.append('userID',userID);
	formdata.append('userRole',userRole);
	formdata.append('remarks_emp_id',employee_id);
	formdata.append('remarks_designation',designation);
	formdata.append('remark_department',department);
	formdata.append('remark_date_of_joining',date_of_joining);
	formdata.append('remark_date_of_relieving',date_of_relieving);
	formdata.append('remark_salary_lakhs',salary_lakhs);
	formdata.append('remark_currency',currency);
	formdata.append('remark_managers_designation',managers_designation);
	formdata.append('remark_managers_contact',managers_contact);
	formdata.append('remark_physical_visit',physical_visit);
	formdata.append('remark_hr_name',remark_hr_name);
	formdata.append('remark_hr_email',remark_hr_email);
	formdata.append('remark_hr_phone_no',remark_hr_phone);
	formdata.append('remark_reason_for_leaving',remarks_reason_for_leaving);
	formdata.append('remark_eligible_for_re_hire',eligible_for_re_hire);
	formdata.append('remark_attendance_punctuality',attendance_punctuality); 
	formdata.append('remark_job_performance',job_performance);
	formdata.append('remark_exit_status',exit_status);
	formdata.append('remark_disciplinary_issues',disciplinary_issues);
	formdata.append('verification_remarks',verification_remarks);
	formdata.append('Insuff_remarks',insuff_remarks);
	formdata.append('Insuff_closure_remarks',insuff_closure_remarks);
	formdata.append('candidate_id',candidate_id_hidden);
	formdata.append('action_status',action_status);
	formdata.append('verification_fee',verification_fee);
	formdata.append('op_action_status',op_action_status)
	formdata.append('ouputQcComment',ouputQcComment)
	
	
	// if(op_action_status == null || op_action_status == ''){
	// 	formdata.append('op_action_status','0')	
	// }else{
	// 	formdata.append('op_action_status',op_action_status)
	// }

	

	if (candidate_aadhar.length > 0) {
		for (var i = 0; i < candidate_aadhar.length; i++) { 
			formdata.append('approved_doc[]',candidate_aadhar[i]);
		}
	}else{
		formdata.append('approved_doc[]','');
	} 
	// if(valid_designation() == 1 && valid_date_of_joining() == 1 && valid_date_of_relieving() == 1 && valid_currency() == 1 &&
	// 	valid_remark_salary_type() == 1 && valid_salary_lakhs() ==1 && valid_remark_hr_name() ==1 && valid_remark_hr_email() == 1 &&
	// 	valid_remark_eligible_for_re_hire() == 1 && valid_exit_status() == 1){
$("#submit-data").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$.ajax({
        type: "POST",
          url: base_url+"outPutQc/update_remarks_current_employment",
          data:formdata,
          dataType: 'json',
          contentType: false,
          processData: false,
          success: function(data) {
          	$("#wait-message").html("");
          	$('#conformtion').modal('hide');
          	$('submit-data').attr('disabled',false);
          	$("#wait-message").html("");
			if (data.status == '1') {
				toastr.success('successfully saved data.');   
				$('.is-valid').removeClass('is-valid');
				window.location.href = base_url+"factsuite-outputqc/assigned-view-case-detail/"+candidate_id_hidden;
          	}else{
          		toastr.error('Something went wrong while save this data. Please try again.'); 	
          	}
          	$("#wait-message").html("");
          	$("#submit-data").html("Confirm")
          }
        });
	// }else{
	// 	$("#wait-message").html("<span class='text-danger'>Please enter required data.</span>");
	// 	valid_designation()
	// 	valid_date_of_joining()
	// 	valid_date_of_relieving()
	// 	valid_currency()
	// 	valid_remark_salary_type()
	// 	valid_salary_lakhs()
	// 	valid_remark_hr_name()
	// 	valid_remark_hr_email()
	// 	valid_remark_eligible_for_re_hire()
	// 	valid_exit_status()
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


$("#designation").on('keyup blur',valid_designation); 
$("#date_of_joining").on('click keyup blur change',valid_date_of_joining);
$("#date_of_relieving").on('click keyup blur change',valid_date_of_relieving);
$("#valid_currency").on('change',valid_currency);
$("#remark_salary_type").on('keyup blur', valid_remark_salary_type);
$("#salary_lakhs").on('keyup blur', valid_salary_lakhs);
$("#remark_hr_name").on('keyup blur', valid_remark_hr_name);
$("#remark_hr_email").on('keyup blur', valid_remark_hr_email);
$("#remark_eligible_for_re_hire").on('keyup blur', valid_remark_eligible_for_re_hire);
$("#exit_status").on('keyup blur', valid_exit_status); 
$("#remark_hr_phone").on('keyup blur', contactNumeber); 
$("#managers_contact").on('keyup blur', mangerContectNuber);

function valid_designation(){
	var designation = $("#designation").val();
	if (designation !='') {
		$("#designation-error").html("&nbsp;");
		input_is_valid("#designation")
		return 1
	}else{
		input_is_invalid("#designation")
		$("#designation-error").html("<span class='text-danger error-msg-small'>Please Enter Valid designation</span>");
		return 0
	}
}

function valid_date_of_joining(){
	var date_of_joining = $("#date_of_joining").val();
	if (date_of_joining !='') {
		$("#date_of_joining-error").html("&nbsp;");
		input_is_valid("#date_of_joining")
		$("#date_of_relieving").attr('disabled',false);
		return 1
	}else{
		input_is_invalid("#date_of_joining")
		$("#date_of_joining-error").html("<span class='text-danger error-msg-small'>Please Enter Valid date of joining</span>");
		return 0
	}
}
function valid_date_of_relieving(){
	var date_of_relieving = $("#date_of_relieving").val();
	if (date_of_relieving !='') {
		$("#date_of_relieving-error").html("&nbsp;");
		input_is_valid("#date_of_relieving")
		return 1
	}else{
		input_is_invalid("#date_of_relieving")
		$("#date_of_relieving-error").html("<span class='text-danger error-msg-small'>Please Enter Valid date of relieving</span>");
		return 0
	}
}

 
function valid_currency(){
	var currency = $("#currency").val();
	if (currency !='') {
		$("#currency-error").html("&nbsp;");
		input_is_valid("#currency")
		return 1
	}else{
		input_is_invalid("#currency")
		$("#currency-error").html("<span class='text-danger error-msg-small'>Please select currency</span>");
		return 0
	}
}


function valid_remark_salary_type(){
	var remark_salary_type = $("#remark_salary_type").val();
	if (remark_salary_type !='') {
		$("#remark_salary_type-error").html("&nbsp;");
		input_is_valid("#remark_salary_type")
		return 1
	}else{
		input_is_invalid("#remark_salary_type")
		$("#remark_salary_type-error").html("<span class='text-danger error-msg-small'>Please select remark salary type</span>");
		return 0
	}
}

function valid_salary_lakhs(){
	var salary_lakhs = $("#salary_lakhs").val();
	if (isNaN(salary_lakhs)) {
		$("#salary_lakhs-error").html('<span class="text-danger error-msg-small">Salary should be only numbers.</span>');
		$("#salary_lakhs").val(salary_lakhs.slice(0,-1));
		input_is_invalid("#salary_lakhs");
		return 0

	}else if (salary_lakhs !='') {
		$("#salary_lakhs-error").html("&nbsp;");
		input_is_valid("#salary_lakhs")
		return 1
	}else{
		input_is_invalid("#salary_lakhs")
		$("#salary_lakhs-error").html("<span class='text-danger error-msg-small'>Please enter salary lakhs</span>");
		return 0
	}
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 44  && charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
    }else{
		return true;    	
    }
}


function valid_remark_hr_name(){
	var remark_hr_name = $("#remark_hr_name").val();
	if (remark_hr_name !='') {
		$("#remark_hr_name-error").html("&nbsp;");
		input_is_valid("#remark_hr_name")
		return 1
	}else{
		input_is_invalid("#remark_hr_name")
		$("#remark_hr_name-error").html("<span class='text-danger error-msg-small'>Please enter valid hr name.</span>");
		return 0
	}
}

function valid_remark_hr_email(){
	var remark_hr_email = $("#remark_hr_email").val();
	if (remark_hr_email !='') {
		$("#remark_hr_email-error").html("&nbsp;");
		input_is_valid("#remark_hr_email")
		return 1
	}else{
		input_is_invalid("#remark_hr_email")
		$("#remark_hr_email-error").html("<span class='text-danger error-msg-small'>Please enter valid hr email.</span>");
		return 0
	}
}

function valid_remark_eligible_for_re_hire(){
	var remark_eligible_for_re_hire = $("#remark_eligible_for_re_hire").val();
	if (remark_eligible_for_re_hire !='') {
		$("#remark_eligible_for_re_hire-error").html("&nbsp;");
		input_is_valid("#remark_eligible_for_re_hire")
		return 1
	}else{
		input_is_invalid("#remark_eligible_for_re_hire")
		$("#remark_eligible_for_re_hire-error").html("<span class='text-danger error-msg-small'>Please select remark eligible for re-hire.</span>");
		return 0
	}
}

function valid_exit_status(){
	var exit_status = $("#exit_status").val();
	if (exit_status !='') {
		$("#exit_status-error").html("&nbsp;");
		input_is_valid("#exit_status")
		return 1
	}else{
		input_is_invalid("#exit_status")
		$("#exit_status-error").html("<span class='text-danger error-msg-small'>Please select remark exit status.</span>");
		return 0
	}
}
 

function contactNumeber(){
	input_id = '#remark_hr_phone'
	error_msg_div_id = '#remark_hr_phone-error'
	empty_input_error_msg = ''
	not_a_number_input_error_msg = 'Phone number should be a number.'
	exceeding_max_length_input_error_msg = 'Phone number only allow 10 digit.'
	max_length = 10
	return only_number_with_max_length_limitation(input_id,error_msg_div_id,empty_input_error_msg,not_a_number_input_error_msg,exceeding_max_length_input_error_msg,max_length)
}

function mangerContectNuber(){

	input_id = '#managers_contact'
	error_msg_div_id = '#managers_contact-error'
	empty_input_error_msg = ''
	not_a_number_input_error_msg = 'Phone number should be a number.'
	exceeding_max_length_input_error_msg = 'Phone number only allow 10 digit.'
	max_length = 10
	return only_number_with_max_length_limitation(input_id,error_msg_div_id,empty_input_error_msg,not_a_number_input_error_msg,exceeding_max_length_input_error_msg,max_length)

}