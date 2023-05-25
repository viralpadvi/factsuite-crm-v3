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


$('#conformtion_dialog').click(function(){
	// $('#conformtion').modal('show');
	$("#previous-emp-conformtion").modal({
	   	backdrop: 'static',
	    keyboard: false
	});

});

$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#previous-emp-conformtion").hasClass('show')){ 

		var key = e.which;
	    if (key == 13) {
	      	remarks_prev_emp();
	      	return false;
	    }
	}
});

$('#cancle-previous-emp').on('click',function(){
	$('#previous-emp-warning-message').html('')
	$('#previous-emp-warning-message').removeClass('text-danger')
})

var candidateInfo
function phpData(phpData){ 
	candidateInfo = phpData;
}


$('#submit-previous-emp').on('click',function(){
	remarks_prev_emp()
});


function remarks_prev_emp(){
	var index = $('#componentIndex').val()
	var countOfCompanyName = $('#countOfCompanyName').val();
	
	var previous_emp_id = $('#previous_emp_id').val()
 	var priority = $('#priority').val()
		// var remarks_emp_id = [];
	if(candidateInfo['remarks_emp_id'] != null){
		var remarks_emp_id = candidateInfo['remarks_emp_id'].split(',');
		remarks_emp_id = JSON.parse(remarks_emp_id)
	}else{
		var remarks_emp_id = []
	}
	$(".remarks_emp_id").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remarks_emp_id.push({remarks_emp_id : $(this).val()});
		 	var obj = {}
			obj['remarks_emp_id'] = $(this).val()
			remarks_emp_id[index] = obj
		}
	});
		// var remarks_designation = [];
	if(candidateInfo['remarks_designation'] != null){
		var remarks_designation = candidateInfo['remarks_designation'].split(',');
		remarks_designation = JSON.parse(remarks_designation)
	}else{
		var remarks_designation = []
	}
	$(".remarks_designation").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remarks_designation.push({remarks_designation : $(this).val()});
		 	var obj = {}
			obj['remarks_designation'] = $(this).val()
			remarks_designation[index] = obj
		}
	});
		// var remark_department = [];
	if(candidateInfo['remark_department'] != null){
		var remark_department = candidateInfo['remark_department'].split(',');
		remark_department = JSON.parse(remark_department)
	}else{
		var remark_department = []
	}
	$(".remark_department").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_department.push({remark_department : $(this).val()});
		 	var obj = {}
			obj['remark_department'] = $(this).val()
			remark_department[index] = obj
		}
	});
		// var remark_date_of_joining = [];
	if(candidateInfo['remark_date_of_joining'] != null){
		var remark_date_of_joining = candidateInfo['remark_date_of_joining'].split(',');
		remark_date_of_joining = JSON.parse(remark_date_of_joining)
	}else{
		var remark_date_of_joining = []
	}
	$(".remark_date_of_joining").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_date_of_joining.push({remark_date_of_joining : $(this).val()});
		 	var obj = {}
			obj['remark_date_of_joining'] = $(this).val()
			remark_date_of_joining[index] = obj
		}
	});
		// var remark_date_of_relieving = [];
	if(candidateInfo['remark_date_of_relieving'] != null){
		var remark_date_of_relieving = candidateInfo['remark_date_of_relieving'].split(',');
		remark_date_of_relieving = JSON.parse(remark_date_of_relieving)
	}else{
		var remark_date_of_relieving = []
	}
	$(".remark_date_of_relieving").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_date_of_relieving.push({remark_date_of_relieving : $(this).val()});
		 	var obj = {}
			obj['remark_date_of_relieving'] = $(this).val()
			remark_date_of_relieving[index] = obj
		}
	});
		// var remark_salary_lakhs = [];
	if(candidateInfo['remark_salary_lakhs'] != null){
		var remark_salary_lakhs = candidateInfo['remark_salary_lakhs'].split(',');
		remark_salary_lakhs = JSON.parse(remark_salary_lakhs)
	}else{
		var remark_salary_lakhs = []
	}
	$(".remark_salary_lakhs").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_salary_lakhs.push({remark_salary_lakhs : $(this).val()});
		 	var obj = {}
			obj['remark_salary_lakhs'] = $(this).val()
			remark_salary_lakhs[index] = obj
		}
	});
		// var currency = [];
	if(candidateInfo['remark_currency'] != null){
		var currency = candidateInfo['remark_currency'].split(',');
		currency = JSON.parse(currency)
	}else{
		var currency = []
	}
	$(".Currency").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // currency.push({currency : $(this).val()});
		 	var obj = {}
			obj['currency'] = $(this).val()
			currency[index] = obj
		}
	});

		// var remark_salary_type = [];
	if(candidateInfo['remark_salary_type'] != null){
		var remark_salary_type = candidateInfo['remark_salary_type'].split(',');
		remark_salary_type = JSON.parse(remark_salary_type)
	}else{
		var remark_salary_type = []
	}
	$(".remark_salary_type").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() != null) {
		 // remark_salary_type.push({remark_salary_type : $(this).val()});
		 	var obj = {}
			obj['remark_salary_type'] = $(this).val()
			remark_salary_type[index] = obj
		}
	});

		// var remark_managers_designation = [];
	if(candidateInfo['remark_managers_designation'] != null){
		var remark_managers_designation = candidateInfo['remark_managers_designation'].split(',');
		remark_managers_designation = JSON.parse(remark_managers_designation)
	}else{
		var remark_managers_designation = []
	}
	$(".remark_managers_designation").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_managers_designation.push({remark_managers_designation : $(this).val()});
		 	var obj = {}
			obj['remark_managers_designation'] = $(this).val()
			remark_managers_designation[index] = obj
		}
	});
		// var remark_managers_contact = [];
	if(candidateInfo['remark_managers_contact'] != null){
		var remark_managers_contact = candidateInfo['remark_managers_contact'].split(',');
		remark_managers_contact = JSON.parse(remark_managers_contact)
	}else{
		var remark_managers_contact = []
	}
	$(".remark_managers_contact").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_managers_contact.push({remark_managers_contact : $(this).val()});
		 	var obj = {}
			obj['remark_managers_contact'] = $(this).val()
			remark_managers_contact[index] = obj
		}
	});
	
		// var remark_physical_visit = [];
	if(candidateInfo['remark_physical_visit'] != null){
		var remark_physical_visit = candidateInfo['remark_physical_visit'].split(',');
		remark_physical_visit = JSON.parse(remark_physical_visit)
	}else{
		var remark_physical_visit = []
	}
	$(".remark_physical_visit").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_physical_visit.push({remark_physical_visit : $(this).val()});
		 	var obj = {}
			obj['remark_physical_visit'] = $(this).val()
			remark_physical_visit[index] = obj
		}
	});
		// var remark_hr_name = [];
	if(candidateInfo['remark_hr_name'] != null){
		var remark_hr_name = candidateInfo['remark_hr_name'].split(',');
		remark_hr_name = JSON.parse(remark_hr_name)
	}else{
		var remark_hr_name = []
	}
	$(".remark_hr_name").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_hr_name.push({remark_hr_name : $(this).val()});
		 	var obj = {}
			obj['remark_hr_name'] = $(this).val()
			remark_hr_name[index] = obj
		}
	});
		// var remark_hr_email = [];
	if(candidateInfo['remark_hr_email'] != null){
		var remark_hr_email = candidateInfo['remark_hr_email'].split(',');
		remark_hr_email = JSON.parse(remark_hr_email)
	}else{
		var remark_hr_email = []
	}
	$(".remark_hr_email").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_hr_email.push({remark_hr_email : $(this).val()});
		 	var obj = {}
			obj['remark_hr_email'] = $(this).val()
			remark_hr_email[index] = obj
		}
	});
		// var remark_hr_phone_no = [];
	if(candidateInfo['remark_hr_phone_no'] != null){
		var remark_hr_phone_no = candidateInfo['remark_hr_phone_no'].split(',');
		remark_hr_phone_no = JSON.parse(remark_hr_phone_no)
	}else{
		var remark_hr_phone_no = []
	}
	$(".remark_hr_phone_no").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_hr_phone_no.push({remark_hr_phone_no : $(this).val()});
		 	var obj = {}
			obj['remark_hr_phone_no'] = $(this).val()
			remark_hr_phone_no[index] = obj
		}
	});
		// var remark_reason_for_leaving = [];
	if(candidateInfo['remark_reason_for_leaving'] != null){
		var remark_reason_for_leaving = candidateInfo['remark_reason_for_leaving'].split(',');
		remark_reason_for_leaving = JSON.parse(remark_reason_for_leaving)
	}else{
		var remark_reason_for_leaving = []
	}
	$(".remark_reason_for_leaving").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_reason_for_leaving.push({remark_reason_for_leaving : $(this).val()});
		 	var obj = {}
			obj['remark_reason_for_leaving'] = $(this).val()
			remark_reason_for_leaving[index] = obj
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
 


		// var remark_eligible_for_re_hire = [];
	if(candidateInfo['remark_eligible_for_re_hire'] != null){
		var remark_eligible_for_re_hire = candidateInfo['remark_eligible_for_re_hire'].split(',');
		remark_eligible_for_re_hire = JSON.parse(remark_eligible_for_re_hire)
	}else{
		var remark_eligible_for_re_hire = []
	}
	$(".remark_eligible_for_re_hire").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_eligible_for_re_hire.push({remark_eligible_for_re_hire : $(this).val()});
		 	var obj = {}
			obj['remark_eligible_for_re_hire'] = $(this).val()
			remark_eligible_for_re_hire[index] = obj
		}
	});
	
		// var remark_attendance_punctuality = [];
	if(candidateInfo['remark_attendance_punctuality'] != null){
		var remark_attendance_punctuality = candidateInfo['remark_attendance_punctuality'].split(',');
		remark_attendance_punctuality = JSON.parse(remark_attendance_punctuality)
	}else{
		var remark_attendance_punctuality = []
	}
	$(".remark_attendance_punctuality").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_attendance_punctuality.push({remark_attendance_punctuality : $(this).val()});
		 	var obj = {}
			obj['remark_attendance_punctuality'] = $(this).val()
			remark_attendance_punctuality[index] = obj
		}
	});
		// var remark_job_performance = [];
	if(candidateInfo['remark_job_performance'] != null){
		var remark_job_performance = candidateInfo['remark_job_performance'].split(',');
		remark_job_performance = JSON.parse(remark_job_performance)
	}else{
		var remark_job_performance = []
	}
	$(".remark_job_performance").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_job_performance.push({remark_job_performance : $(this).val()});
		 	var obj = {}
			obj['remark_job_performance'] = $(this).val()
			remark_job_performance[index] = obj
		}
	});

		// var remark_exit_status = [];
	if(candidateInfo['remark_exit_status'] != null){
		var remark_exit_status = candidateInfo['remark_exit_status'].split(',');
		remark_exit_status = JSON.parse(remark_exit_status)
	}else{
		var remark_exit_status = []
	}
	$(".remark_exit_status").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_exit_status.push({remark_exit_status : $(this).val()});
		 	var obj = {}
			obj['remark_exit_status'] = $(this).val()
			remark_exit_status[index] = obj
		}
	});

		// var remark_disciplinary_issues = [];
	if(candidateInfo['remark_disciplinary_issues'] != null){
		var remark_disciplinary_issues = candidateInfo['remark_disciplinary_issues'].split(',');
		remark_disciplinary_issues = JSON.parse(remark_disciplinary_issues)
	}else{
		var remark_disciplinary_issues = []
	}
	$(".remark_disciplinary_issues").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_disciplinary_issues.push({remark_disciplinary_issues : $(this).val()});
		 	var obj = {}
			obj['remark_disciplinary_issues'] = $(this).val()
			remark_disciplinary_issues[index] = obj
		}
	});
	
		// var insuff_remarks = [];
	if(candidateInfo['insuff_remarks'] != null){
		var insuff_remarks = candidateInfo['insuff_remarks'].split(',');
		insuff_remarks = JSON.parse(insuff_remarks)
	}else{
		var insuff_remarks = []
	}
	$(".Insuff_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // insuff_remarks.push({insuff_remarks : $(this).val()});
		 	var obj = {}
			obj['insuff_remarks'] = $(this).val()
			insuff_remarks[index] = obj
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

		// var insuff_closure_remarks = [];
	if(candidateInfo['insuff_closure_remarks'] != null){
		var insuff_closure_remarks = candidateInfo['insuff_closure_remarks'].split(',');
		insuff_closure_remarks = JSON.parse(insuff_closure_remarks)
	}else{
		var insuff_closure_remarks = []
	}
	$(".Insuff_closure_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // insuff_closure_remarks.push({insuff_closure_remarks : $(this).val()});
		 	var obj = {}
			obj['insuff_closure_remarks'] = $(this).val()
			insuff_closure_remarks[index] = obj
		}
	});

	// var verification_fee = []
	if(candidateInfo['verification_fee'] != null){
		var verification_fee = candidateInfo['verification_fee'].split(',');
		verification_fee = JSON.parse(verification_fee)
	}else{
		var verification_fee = []
	}
	$('.verification_fee').each(function(){
		if($(this).val() != '' && $(this).val() != null){
			// verification_fee.push({verification_fee : $(this).val()});
			var obj = {}
			obj['verification_fee'] = $(this).val()
			verification_fee[index] = obj
		}
	})

	 
	if(candidateInfo['in_progress_remarks'] != null){
		var in_progress_remarks = candidateInfo['in_progress_remarks'].split(',');
		in_progress_remarks = JSON.parse(in_progress_remarks)
	}else{
		var in_progress_remarks = []
	}
	$('.in_progress_remarks').each(function(){
		if($(this).val() != '' && $(this).val() != null){
			// verification_fee.push({verification_fee : $(this).val()});
			var obj = {}
			obj['in_progress_remarks'] = $(this).val()
			in_progress_remarks[index] = obj
		}
	})


	// 	var closure_remarks = [];
	// $(".closure_remarks").each(function(){
	// 	// address['address']=$(this).val();
	// 	if ($(this).val() !='' && $(this).val() !=null) {
	// 	 closure_remarks.push({closure_remarks : $(this).val()});
	// 	}
	// });


	var candidate_id_hidden = $("#candidate_id_hidden").val(); 
	// var action_status = $("#action_status").val(); 
	var action_status = $("#action_status").val();
	if(candidateInfo['analyst_status'] != null){
		var analyst_status = candidateInfo['analyst_status'].split(',');
		// analyst_status = JSON.parse(analyst_status)
	}else{
		var analyst_status = []
	}
	analyst_status[index] = action_status;

	var userID = $("#userID").val();
	var userRole = $("#userRole").val();
	// if(remarks_designation.length == countOfCompanyName && remark_date_of_joining.length == countOfCompanyName && remark_date_of_relieving.length == countOfCompanyName &&
	// 	remark_hr_name.length == countOfCompanyName && remark_hr_email.length == countOfCompanyName && remark_salary_lakhs.length == countOfCompanyName &&
	// 	remarks_designation.length == countOfCompanyName && remarks_designation.length == countOfCompanyName && remarks_designation.length == countOfCompanyName &&
	// 	remarks_designation.length == countOfCompanyName && action_status > 0){
		var formdata = new FormData();

		var vendor_id = $("#vendor_name").val();
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
		formdata.append('verified_date',JSON.stringify(verified_date));
		formdata.append('Insuff_remarks',JSON.stringify(insuff_remarks));
		formdata.append('Insuff_closure_remarks',JSON.stringify(insuff_closure_remarks)); 
		formdata.append('verification_fee',JSON.stringify(verification_fee)); 
		formdata.append('in_progress_remarks',JSON.stringify(in_progress_remarks)); 
		// alert(JSON.stringify(verification_fee))
		formdata.append('candidate_id',candidate_id_hidden); 
		formdata.append('analyst_status',analyst_status); 
		formdata.append('count',candidate_aadhar.length);

		formdata.append('previous_emp_id',previous_emp_id);
		var component_id = $("#component_id").val();
		formdata.append('component_id',component_id);
		formdata.append('vendor_id',vendor_id);
		formdata.append('component_name','Previous Employment');
		formdata.append('priority',priority);
		formdata.append('index',index);

		
		var op_action_status = $('#op_action_status').val();
		
		if(op_action_status == null || op_action_status == ''){
			formdata.append('op_action_status','0')	
		}else{
			formdata.append('op_action_status',op_action_status)
		}
		
	if (candidate_aadhar.length > 0) {
		for (var i = 0; i < candidate_aadhar.length; i++) { 
			formdata.append('remark_docs[]',candidate_aadhar[i]);
		}
	}else{
		formdata.append('remark_docs[]','');
	} 

		$.ajax({
	        type: "POST",
	        url: base_url+"analyst/update_remarks_previous_employment",
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
	          	}else{
	          		toastr.error('Something went wrong while save this data. Please try again.'); 	
	          	}
	          	get_latest_selected_vendor();
	          	$("#warning-msg").html("");
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

function valid_department(id){
	var designation = $("#department_"+id).val();
	if (designation !='') {
		$("#department_err"+id).html("&nbsp;");
		input_is_valid("#department_"+id)
		return 1
	}else{
		input_is_invalid("#department_"+id)
		$("#department_err"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Department</span>");
		return 0
	}
}

function valid_employee_id(id){
	var designation = $("#employee_id_"+id).val();
	if (designation !='') {
		$("#employee_id_err"+id).html("&nbsp;");
		input_is_valid("#employee_id_"+id)
		return 1
	}else{
		input_is_invalid("#employee_id_"+id)
		$("#employee_id_err"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Employee ID</span>");
		return 0
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


function managers_designation(id){
	var designation = $("#managers_designation_"+id).val();
	if (designation !='') {
		// $("#designation-error_"+id).html("&nbsp;");
		input_is_valid("#managers_designation_"+id)
		return 1
	}else{
		input_is_invalid("#managers_designation_"+id)
		// $("#designation-error_"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid designation</span>");
		return 0
	}
}


function managers_designation(id){
	var designation = $("#managers_designation_"+id).val();
	if (designation !='') {
		// $("#designation-error_"+id).html("&nbsp;");
		input_is_valid("#managers_designation_"+id)
		return 1
	}else{
		input_is_invalid("#managers_designation_"+id)
		// $("#designation-error_"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid designation</span>");
		return 0
	}
}

function valid_remark_hr_email(id){
	var designation = $("#remark_hr_email_"+id).val();
	if (designation !='') {
		$("#designation-error_"+id).html("&nbsp;");
		input_is_valid("#remark_hr_email_"+id)
		return 1
	}else{
		input_is_invalid("#remark_hr_email_"+id)
		$("#remark_hr_email_-error_"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Email</span>");
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
	var input_id = $('#remark_hr_phone_'+id).val(),
	error_msg_div_id = '#remark_hr_phone-error_'+id,
	empty_input_error_msg = '',
	not_a_number_input_error_msg = 'Phone number should be a number.',
	exceeding_max_length_input_error_msg = 'Phone number only allow 10 digit.',
	max_length = 10;

	if (input_id !='') {
		$(error_msg_div_id).html("&nbsp;");
		input_is_valid('#remark_hr_phone_'+id)
		return 1
	}else{
		input_is_invalid('#remark_hr_phone_'+id)
		$(error_msg_div_id).html("<span class='text-danger error-msg-small'>Please enter valid number.</span>");
		return 0
	}
	// return only_number_with_max_length_limitation(input_id,error_msg_div_id,empty_input_error_msg,not_a_number_input_error_msg,exceeding_max_length_input_error_msg,max_length)
}

function mangerContectNuber(id){

	var input_id = $('#managers_contact_'+id).val(),
	error_msg_div_id = '#managers_contact_-error_'+id,
	empty_input_error_msg = '',
	not_a_number_input_error_msg = 'Phone number should be a number.',
	exceeding_max_length_input_error_msg = 'Phone number only allow 10 digit.',
	max_length = 10;
	if (input_id !='') {
		$(error_msg_div_id).html("&nbsp;");
		input_is_valid('#managers_contact_'+id)
		return 1
	}else{
		input_is_invalid('#managers_contact_'+id)
		$(error_msg_div_id).html("<span class='text-danger error-msg-small'>Please enter valid number.</span>");
		return 0
	}
	// return only_number_with_max_length_limitation(input_id,error_msg_div_id,empty_input_error_msg,not_a_number_input_error_msg,exceeding_max_length_input_error_msg,max_length)

}


function resion_leave(id){

	var input_id = $('#remarks_reason_for_leaving_'+id).val(),
	error_msg_div_id = '#managers_contact_-error_'+id,
	empty_input_error_msg = '',
	not_a_number_input_error_msg = 'Phone number should be a number.',
	exceeding_max_length_input_error_msg = 'Phone number only allow 10 digit.',
	max_length = 10;
	if (input_id !='') {
		// $(error_msg_div_id).html("&nbsp;");
		input_is_valid('#remarks_reason_for_leaving_'+id)
		return 1
	}else{
		input_is_invalid('#remarks_reason_for_leaving_'+id)
		// $(error_msg_div_id).html("<span class='text-danger error-msg-small'>Please enter valid number.</span>");
		return 0
	}
	// return only_number_with_max_length_limitation(input_id,error_msg_div_id,empty_input_error_msg,not_a_number_input_error_msg,exceeding_max_length_input_error_msg,max_length)

}


function verification_remarks_(id){
	var input_id = $('#verification_remarks_'+id).val(),
	error_msg_div_id = '#managers_contact_-error_'+id,
	empty_input_error_msg = '',
	not_a_number_input_error_msg = 'Phone number should be a number.',
	exceeding_max_length_input_error_msg = 'Phone number only allow 10 digit.',
	max_length = 10;
	if (input_id !='') {
		// $(error_msg_div_id).html("&nbsp;");
		input_is_valid('#verification_remarks_'+id)
		return 1
	}else{
		input_is_invalid('#verification_remarks_'+id)
		// $(error_msg_div_id).html("<span class='text-danger error-msg-small'>Please enter valid number.</span>");
		return 0
	}
}

function in_progress_remarks_(id){
	var input_id = $('#in_progress_remarks_'+id).val(),
	error_msg_div_id = '#managers_contact_-error_'+id,
	empty_input_error_msg = '',
	not_a_number_input_error_msg = 'Phone number should be a number.',
	exceeding_max_length_input_error_msg = 'Phone number only allow 10 digit.',
	max_length = 10;
	if (input_id !='') {
		// $(error_msg_div_id).html("&nbsp;");
		input_is_valid('#in_progress_remarks_'+id)
		return 1
	}else{
		input_is_invalid('#in_progress_remarks_'+id)
		// $(error_msg_div_id).html("<span class='text-danger error-msg-small'>Please enter valid number.</span>");
		return 0
	}
}
function insuff_remarks_(id){
	var input_id = $('#insuff_remarks_'+id).val(),
	error_msg_div_id = '#managers_contact_-error_'+id,
	empty_input_error_msg = '',
	not_a_number_input_error_msg = 'Phone number should be a number.',
	exceeding_max_length_input_error_msg = 'Phone number only allow 10 digit.',
	max_length = 10;
	if (input_id !='') {
		// $(error_msg_div_id).html("&nbsp;");
		input_is_valid('#insuff_remarks_'+id)
		return 1
	}else{
		input_is_invalid('#insuff_remarks_'+id)
		// $(error_msg_div_id).html("<span class='text-danger error-msg-small'>Please enter valid number.</span>");
		return 0
	}
}
function insuff_closure_remarks_(id){
	var input_id = $('#insuff_closure_remarks_'+id).val(),
	error_msg_div_id = '#managers_contact_-error_'+id,
	empty_input_error_msg = '',
	not_a_number_input_error_msg = 'Phone number should be a number.',
	exceeding_max_length_input_error_msg = 'Phone number only allow 10 digit.',
	max_length = 10;
	if (input_id !='') {
		// $(error_msg_div_id).html("&nbsp;");
		input_is_valid('#insuff_closure_remarks_'+id)
		return 1
	}else{
		input_is_invalid('#insuff_closure_remarks_'+id)
		// $(error_msg_div_id).html("<span class='text-danger error-msg-small'>Please enter valid number.</span>");
		return 0
	}
}
function verification_fee_(id){
	var input_id = $('#verification_fee_'+id).val(),
	error_msg_div_id = '#managers_contact_-error_'+id,
	empty_input_error_msg = '',
	not_a_number_input_error_msg = 'Phone number should be a number.',
	exceeding_max_length_input_error_msg = 'Phone number only allow 10 digit.',
	max_length = 10;
	if (input_id !='') {
		// $(error_msg_div_id).html("&nbsp;");
		input_is_valid('#verification_fee_'+id)
		return 1
	}else{
		input_is_invalid('#verification_fee_'+id)
		// $(error_msg_div_id).html("<span class='text-danger error-msg-small'>Please enter valid number.</span>");
		return 0
	}
}

 