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


$('#conformtion_dialog').click(function(){

	$('#conformtion').modal('show');

});



$('#cancle-previous-emp').on('click',function(){
	$('#previous-emp-warning-message').html('')
	$('#previous-emp-warning-message').removeClass('text-danger')
})

$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#previous-emp-conformtion").hasClass('show')){  
		var key = e.which;
	    if (key == 13) {
	      	previous_employee()
	      	return false;
	    }
	}
});


$('#submit-previous-emp').on('click',function(){
	previous_employee()
});
function previous_employee(){
	
	countOfCompanyName = $('#countOfCompanyName').val();
	
	
		var remarks_emp_id = [];
	$(".remarks_emp_id").each(function(){
		remarks_emp_id.push({remarks_emp_id : $(this).val()});
		
	});
		var remarks_designation = [];
	$(".remarks_designation").each(function(){
		remarks_designation.push({remarks_designation : $(this).val()});
		
	});
		var remark_department = [];
	$(".remark_department").each(function(){
		remark_department.push({remark_department : $(this).val()});
		
	});
		var remark_date_of_joining = [];
	$(".remark_date_of_joining").each(function(){
		remark_date_of_joining.push({remark_date_of_joining : $(this).val()});
		
	});
		var remark_date_of_relieving = [];
	$(".remark_date_of_relieving").each(function(){
		remark_date_of_relieving.push({remark_date_of_relieving : $(this).val()});
		
	});
		var remark_salary_lakhs = [];
	$(".remark_salary_lakhs").each(function(){
		remark_salary_lakhs.push({remark_salary_lakhs : $(this).val()});
		
	});
		var currency = [];
	$(".Currency").each(function(){
		currency.push({currency : $(this).val()});
		
	});

		var remark_salary_type = [];
	$(".remark_salary_type").each(function(){
		remark_salary_type.push({remark_salary_type : $(this).val()});
		
	});

		var remark_managers_designation = [];
	$(".remark_managers_designation").each(function(){
		remark_managers_designation.push({remark_managers_designation : $(this).val()});
		
	});
		var remark_managers_contact = [];
	$(".remark_managers_contact").each(function(){
		remark_managers_contact.push({remark_managers_contact : $(this).val()});
		
	});
	
		var remark_physical_visit = [];
	$(".remark_physical_visit").each(function(){
		remark_physical_visit.push({remark_physical_visit : $(this).val()});
		
	});
		var remark_hr_name = [];
	$(".remark_hr_name").each(function(){
		remark_hr_name.push({remark_hr_name : $(this).val()});
		
	});
		var remark_hr_email = [];
	$(".remark_hr_email").each(function(){
		remark_hr_email.push({remark_hr_email : $(this).val()});
		
	});
		var remark_hr_phone_no = [];
	$(".remark_hr_phone_no").each(function(){
		remark_hr_phone_no.push({remark_hr_phone_no : $(this).val()});
		
	});
		var remark_reason_for_leaving = [];
	$(".remark_reason_for_leaving").each(function(){
		remark_reason_for_leaving.push({remark_reason_for_leaving : $(this).val()});
		
	});
		var remark_eligible_for_re_hire = [];
	$(".remark_eligible_for_re_hire").each(function(){
		remark_eligible_for_re_hire.push({remark_eligible_for_re_hire : $(this).val()});
		
	});
	
		var remark_attendance_punctuality = [];
	$(".remark_attendance_punctuality").each(function(){
		remark_attendance_punctuality.push({remark_attendance_punctuality : $(this).val()});
		
	});
		var remark_job_performance = [];
	$(".remark_job_performance").each(function(){
		remark_job_performance.push({remark_job_performance : $(this).val()});
		
	});

		var remark_exit_status = [];
	$(".remark_exit_status").each(function(){
		remark_exit_status.push({remark_exit_status : $(this).val()});
		
	});

		var remark_disciplinary_issues = [];
	$(".remark_disciplinary_issues").each(function(){
		remark_disciplinary_issues.push({remark_disciplinary_issues : $(this).val()});
		
	});
	
		var insuff_remarks = [];
	$(".Insuff_remarks").each(function(){
		insuff_remarks.push({insuff_remarks : $(this).val()});
		
	});

		var verification_remarks = [];
	$(".verification_remarks").each(function(){
		verification_remarks.push({verification_remarks : $(this).val()});
		
	});

		var insuff_closure_remarks = [];
	$(".Insuff_closure_remarks").each(function(){
		insuff_closure_remarks.push({insuff_closure_remarks : $(this).val()});
		
	});

	var verification_fee = []

	$('.verification_fee').each(function(){ 
			verification_fee.push({verification_fee : $(this).val()});
		 
	})
	// 	var closure_remarks = [];
	// $(".closure_remarks").each(function(){
	// 	// address['address']=$(this).val();
	// 	if ($(this).val() !='' && $(this).val() !=null) {
	// 	 closure_remarks.push({closure_remarks : $(this).val()});
	// 	}
	// });
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

	var candidate_id_hidden = $("#candidate_id_hidden").val(); 
	 
	var userID = $("#userID").val();
	var userRole = $("#userRole").val();
	
	// if(remarks_designation.length == countOfCompanyName && remark_date_of_joining.length == countOfCompanyName && remark_date_of_relieving.length == countOfCompanyName &&
	// 	remark_hr_name.length == countOfCompanyName && remark_hr_email.length == countOfCompanyName && remark_salary_lakhs.length == countOfCompanyName &&
	// 	remarks_designation.length == countOfCompanyName && remarks_designation.length == countOfCompanyName && remarks_designation.length == countOfCompanyName &&
	// 	remarks_designation.length == countOfCompanyName && action_status > 0){

		var formdata = new FormData();
		formdata.append('userID',userID);
		formdata.append('userRole',userRole);
		formdata.append('remarks_emp_id',JSON.stringify(remarks_emp_id));
		formdata.append('remarks_designation',JSON.stringify(remarks_designation));
		formdata.append('remark_department',JSON.stringify(remark_department));
		formdata.append('remark_date_of_joining',JSON.stringify(remark_date_of_joining));
		formdata.append('remark_date_of_relieving',JSON.stringify(remark_date_of_relieving));
		formdata.append('remark_salary_lakhs',JSON.stringify(remark_salary_lakhs));
		formdata.append('currency',JSON.stringify(currency));
		formdata.append('remark_salary_type',JSON.stringify(remark_salary_type));
		formdata.append('remark_managers_designation',JSON.stringify(remark_managers_designation));
		formdata.append('remark_managers_contact',JSON.stringify(remark_managers_contact));
		formdata.append('remark_physical_visit',JSON.stringify(remark_physical_visit));
		formdata.append('remark_hr_name',JSON.stringify(remark_hr_name));
		formdata.append('remark_hr_email',JSON.stringify(remark_hr_email));
		formdata.append('remark_hr_phone_no',JSON.stringify(remark_hr_phone_no));
		formdata.append('remark_reason_for_leaving',JSON.stringify(remark_reason_for_leaving));
		formdata.append('remark_eligible_for_re_hire',JSON.stringify(remark_eligible_for_re_hire));
		formdata.append('remark_attendance_punctuality',JSON.stringify(remark_attendance_punctuality));
		formdata.append('remark_job_performance',JSON.stringify(remark_job_performance));
		formdata.append('remark_exit_status',JSON.stringify(remark_exit_status));
		formdata.append('remark_disciplinary_issues',JSON.stringify(remark_disciplinary_issues));
		formdata.append('verification_remarks',JSON.stringify(verification_remarks));
		formdata.append('Insuff_remarks',JSON.stringify(insuff_remarks));
		formdata.append('Insuff_closure_remarks',JSON.stringify(insuff_closure_remarks)); 
		formdata.append('verification_fee',JSON.stringify(verification_fee)); 
		// alert(JSON.stringify(verification_fee))
		formdata.append('candidate_id',candidate_id_hidden); 
		formdata.append('analyst_status',analyst_status);
		formdata.append('op_action_status',output_status)
		formdata.append('count',candidate_aadhar.length);
		formdata.append('ouputQcComment',JSON.stringify(ouputQcComment));
		 
		
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
$("#submit-previous-emp").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

		$.ajax({
	        type: "POST",
	          url: base_url+"outPutQc/update_remarks_previous_employment",
	          data:formdata,
	          dataType: 'json',
	          contentType: false,
	          processData: false,
	          success: function(data) {
	          	$('#previous-emp-conformtion').modal('hide')
				if (data.status == '1') {
					$('#action_status_error').html('')
					toastr.success('successfully update data.');   
					$('.is-valid').removeClass('is-valid');
					window.location.href = base_url+"factsuite-outputqc/assigned-view-case-detail/"+candidate_id_hidden;
	          	}else{
	          		toastr.error('Something went wrong while save this data. Please try again.'); 	
	          	}
	          	$('#conformtion').modal('hide');
	          	$("#warning-msg").html("");
	          	$("#submit-previous-emp").html("Confirm")
	        }
        });
	// }else{
	// 	$('#previous-emp-warning-message').html('Please enter valid detail OR should not empty mandatory field.')
	// 	$('#previous-emp-warning-message').addClass('text-danger')
	// 	if(action_status == 0){
	// 		$('#action_status_error').html('Please select any valid status')
	// 	}
	// 	$('.Currency').each(function(){
	// 		var MyID = $(this).attr("id"); 
	// 	    var number = MyID.match(/\d+/);  
	// 		valid_salary_lakhs(number)
	// 		valid_designation(number)
	// 		valid_date_of_joining(number)
	// 		valid_date_of_relieving(number)
	// 		valid_currency(number)
	// 		valid_remark_hr_name(number)
	// 		valid_remark_salary_type(number)
	// 		valid_remark_hr_email(number)
	// 		valid_remark_eligible_for_re_hire(number)
	// 		valid_exit_status(number)
	// 	})
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


function checkedBox(id){
		// alert("click")
	if($('#physical_visit_'+id).prop('checked') == true) { 
    	$('#physical_visit_label_'+id).html('Yes')
	} else {
		$('#physical_visit_label_'+id).html('No')
	}
}

function valid_salary_lakhs(id){
    var salary_lakhs = $("#salary_lakhs_"+id).val(); 

	if (salary_lakhs !='') {
		$("#remark_salary_lakhs-error_"+id).html("&nbsp;");
		input_is_valid("#salary_lakhs_"+id)
		return 1
	}else{
		input_is_invalid("#salary_lakhs_"+id)
		$("#remark_salary_lakhs-error_"+id).html("<span class='text-danger error-msg-small'>Please enter valid salary</span>");
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

function valid_designation(id){
	var designation = $("#designation_"+id).val();
	if (designation !='') {
		$("#designation-error_"+id).html("&nbsp;");
		input_is_valid("#designation_"+id)
		return 1
	}else{
		input_is_invalid("#designation_"+id)
		$("#designation-error_"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid designation</span>");
		return 0
	}
}

function valid_date_of_joining(id){
	var date_of_joining = $("#date_of_joining_"+id).val();
	if (date_of_joining !='') {
		$("#date_of_joining-error_"+id).html("&nbsp;");
		input_is_valid("#date_of_joining_"+id)
		$("#date_of_relieving_"+id).attr('disabled',false)
		return 1
	}else{
		input_is_invalid("#date_of_joining_"+id)
		$("#date_of_joining-error_"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid date of joining</span>");
		return 0
	}
}
function valid_date_of_relieving(id){
	var date_of_relieving = $("#date_of_relieving_"+id).val();
	if (date_of_relieving !='') {
		$("#date_of_relieving_-error_"+id).html("&nbsp;");
		input_is_valid("#date_of_relieving_"+id)
		return 1
	}else{
		input_is_invalid("#date_of_relieving_"+id)
		$("#date_of_relieving_-error_"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid date of relieving</span>");
		return 0
	}
}

 
function valid_currency(id){
	var currency = $("#currency_"+id).val();
	if (currency !='') {
		$("#currency-error_"+id).html("&nbsp;");
		input_is_valid("#currency_"+id)
		return 1
	}else{
		input_is_invalid("#currency_"+id)
		$("#currency-error_"+id).html("<span class='text-danger error-msg-small'>Please select currency</span>");
		return 0
	}
}


function valid_remark_salary_type(id){
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

function valid_remark_hr_name(id){
	var remark_hr_name = $("#remark_hr_name_"+id).val();
	if (remark_hr_name !='') {
		$("#remark_hr_name_error_"+id).html("&nbsp;");
		input_is_valid("#remark_hr_name_"+id)
		return 1
	}else{
		input_is_invalid("#remark_hr_name_"+id)
		$("#remark_hr_name_error_"+id).html("<span class='text-danger error-msg-small'>Please enter valid hr name.</span>");
		return 0
	}
}

function valid_remark_hr_email(id){
	var remark_hr_email = $("#remark_hr_email_"+id).val();
	if (remark_hr_email !='') {
		$("#remark_hr_email_-error_"+id).html("&nbsp;");
		input_is_valid("#remark_hr_email_"+id)
		return 1
	}else{
		input_is_invalid("#remark_hr_email_"+id)
		$("#remark_hr_email_-error_"+id).html("<span class='text-danger error-msg-small'>Please enter valid hr email.</span>");
		return 0
	}
}

function valid_remark_eligible_for_re_hire(id){
	var remark_eligible_for_re_hire = $("#eligible_for_re_hire_"+id).val();
	if (remark_eligible_for_re_hire !='') {
		$("#eligible_for_re_hire_error_"+id).html("&nbsp;");
		input_is_valid("#eligible_for_re_hire_"+id)
		return 1
	}else{
		input_is_invalid("#eligible_for_re_hire_"+id)
		$("#eligible_for_re_hire_error_"+id).html("<span class='text-danger error-msg-small'>Please select remark eligible for re-hire.</span>");
		return 0
	}
}

function valid_exit_status(id){
	var exit_status = $("#exit_status_"+id).val();
	if (exit_status !='') {
		$("#exit_status_-error_"+id).html("&nbsp;");
		input_is_valid("#exit_status_"+id)
		return 1
	}else{
		input_is_invalid("#exit_status_"+id)
		$("#exit_status_-error_"+id).html("<span class='text-danger error-msg-small'>Please select remark exit status.</span>");
		return 0
	}
}
 

function contactNumeber(id){
	input_id = '#remark_hr_phone_'+id
	error_msg_div_id = '#remark_hr_phone-error_'+id
	empty_input_error_msg = ''
	not_a_number_input_error_msg = 'Phone number should be a number.'
	exceeding_max_length_input_error_msg = 'Phone number only allow 10 digit.'
	max_length = 10
	return only_number_with_max_length_limitation(input_id,error_msg_div_id,empty_input_error_msg,not_a_number_input_error_msg,exceeding_max_length_input_error_msg,max_length)
}

function mangerContectNuber(id){

	input_id = '#managers_contact_'+id
	error_msg_div_id = '#managers_contact_-error_'+id
	empty_input_error_msg = ''
	not_a_number_input_error_msg = 'Phone number should be a number.'
	exceeding_max_length_input_error_msg = 'Phone number only allow 10 digit.'
	max_length = 10
	return only_number_with_max_length_limitation(input_id,error_msg_div_id,empty_input_error_msg,not_a_number_input_error_msg,exceeding_max_length_input_error_msg,max_length)

}