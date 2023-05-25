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



// $('#submit-reference').click(function(){
// 	alert('Data')
// 	// $('#conformtionReferance').modal('show');
// });
$('#edu-cancle').on('click',function(){
	$('#submit-edu-data').attr('disabled',false);
	$('#edu-cancle').attr('disabled',false);
	$('#submit-edu-data').removeClass('buttonload');
	$('#submit-edu-data').html('Confirm');
	$('#conformtionEdu').modal('hide');
	$('#wait-message').html('');
	$('#action_status_error').html('')
});

var candidateInfo
function phpData(phpData){ 
	candidateInfo = phpData;
}

$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#conformtionEdu").hasClass('show')){  
		var key = e.which;
	    if (key == 13) {
	      	education();
	      	return false;
	    }
	}
});

$('#submit-edu-data').on('click',function(){
	// alert('Data')
	education()
});


function education(){
	$('#wait-message').html('Please,Wait we are updateg your data.')
	$('#wait-message').addClass('text-warning')
 	$('#submit-edu-data').attr('disabled',true);
 	$('#edu-cancle').attr('disabled',true);
 	$('#submit-edu-data').addClass('buttonload');
 	$('#submit-edu-data').html('<i class="fa fa-circle-o-notch fa-spin"></i> Loading');
 		
 	var index = $("#componentIndex").val();
 	var priority = $("#priority").val();
 	var education_details_id = $("#education_details_id").val();
 	 
 	 
	
	
	// var roll_number = [];
	if(candidateInfo['remark_roll_no'] != null){
		var roll_number = candidateInfo['remark_roll_no'].split(',');
		roll_number = JSON.parse(roll_number)
	}else{
		var roll_number = []
	}
	$(".roll_number").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
			// roll_number.push({roll_number : $(this).val()});
			var obj = {}
			obj['roll_number'] = $(this).val()
			roll_number[index] = obj
			// alert(JSON.stringify(address))
		}
	});
		// var institute_name = [];
	if(candidateInfo['remark_institute_name'] != null){
		var institute_name = candidateInfo['remark_institute_name'].split(',');
		institute_name = JSON.parse(institute_name)
	}else{
		var institute_name = []
	}
	$(".institute_name").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
			// institute_name.push({institute_name : $(this).val()});	
			var obj = {}
			obj['institute_name'] = $(this).val()
			institute_name[index] = obj
		}
	});
		// var year_of_education = [];
	if(candidateInfo['remark_year_of_graduation'] != null){
		var year_of_education = candidateInfo['remark_year_of_graduation'].split(',');
		year_of_education = JSON.parse(year_of_education)
	}else{
		var year_of_education = []
	}
	$(".year_of_education").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 	// year_of_education.push({year_of_education : $(this).val()});
		 	var obj = {}
			obj['year_of_education'] = $(this).val()
			year_of_education[index] = obj
		}
	});
	// var physical_visit = [];
	if(candidateInfo['remark_physical_visit'] != null){
		var physical_visit = candidateInfo['remark_physical_visit'].split(',');
		physical_visit = JSON.parse(physical_visit)
	}else{
		var physical_visit = []
	}
	$(".physical_visit").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 	// physical_visit.push({physical_visit : $(this).val()});
		 	var obj = {}
			obj['physical_visit'] = $(this).val()
			physical_visit[index] = obj
		}
	});
	// 	var assigned_to_vendor = [];
	// $(".assigned_to_vendor").each(function(){
	// 	// address['address']=$(this).val();
	// 	if ($(this).val() !='' && $(this).val() !=null) {
	// 	 assigned_to_vendor.push({assigned_to_vendor : $(this).val()});
	// 	}
	// });
	// var verifier_name = [];
	if(candidateInfo['remark_verifier_name'] != null){
		var verifier_name = candidateInfo['remark_verifier_name'].split(',');
		verifier_name = JSON.parse(verifier_name)
	}else{
		var verifier_name = []
	}
	$(".verifier_name").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 	// verifier_name.push({verifier_name : $(this).val()});
		 	var obj = {}
			obj['verifier_name'] = $(this).val()
			verifier_name[index] = obj
		}
	});
		// var verifier_contact = [];
	if(candidateInfo['remark_verifier_contact'] != null){
		var verifier_contact = candidateInfo['remark_verifier_contact'].split(',');
		verifier_contact = JSON.parse(verifier_contact)
	}else{
		var verifier_contact = []
	}
	$(".verifier_contact").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // verifier_contact.push({verifier_contact : $(this).val()});
		 	var obj = {}
			obj['verifier_contact'] = $(this).val()
			verifier_contact[index] = obj
		}
	});
	// var verifier_fee = [];
	if(candidateInfo['verification_fee'] != null){
		var verifier_fee = candidateInfo['verification_fee'].split(',');
		verifier_fee = JSON.parse(verifier_fee)
	}else{
		var verifier_fee = []
	}
	$(".verifier_fee").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // verifier_fee.push({verifier_fee : $(this).val()});
		 	var obj = {}
			obj['verifier_fee'] = $(this).val()
			verifier_fee[index] = obj
		}
	});
		// var insuff_remarks = [];
	if(candidateInfo['insuff_remarks'] != null){
		var insuff_remarks = candidateInfo['insuff_remarks'].split(',');
		insuff_remarks = JSON.parse(insuff_remarks)
	}else{
		var insuff_remarks = []
	}
	$(".insuff_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // insuff_remarks.push({insuff_remarks : $(this).val()});
		 	var obj = {}
			obj['insuff_remarks'] = $(this).val()
			insuff_remarks[index] = obj
		}
	});
	
		// var type_of_degree = [];
	if(candidateInfo['remark_type_of_dgree'] != null){
		var type_of_degree = candidateInfo['remark_type_of_dgree'].split(',');
		type_of_degree = JSON.parse(type_of_degree)
	}else{
		var type_of_degree = []
	}
	$(".type_of_degree").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // type_of_degree.push({type_of_degree : $(this).val()});
		 	var obj = {}
			obj['type_of_degree'] = $(this).val()
			type_of_degree[index] = obj
		}
	});
		// var university_name = [];
	if(candidateInfo['remark_university_name'] != null){
		var university_name = candidateInfo['remark_university_name'].split(',');
		university_name = JSON.parse(university_name)
	}else{
		var university_name = []
	}
	$(".university_name").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // university_name.push({university_name : $(this).val()});
		 	var obj = {}
			obj['university_name'] = $(this).val()
			university_name[index] = obj
		}
	});
		// var result_grade = [];
	if(candidateInfo['remark_result'] != null){
		var result_grade = candidateInfo['remark_result'].split(',');
		result_grade = JSON.parse(result_grade)
	}else{
		var result_grade = []
	}
	$(".result_grade").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // result_grade.push({result_grade : $(this).val()});
		 	var obj = {}
			obj['result_grade'] = $(this).val()
			result_grade[index] = obj
		}
	});
		// var progress_remark = [];
	if(candidateInfo['in_progress_remarks'] != null){
		var progress_remark = candidateInfo['in_progress_remarks'].split(',');
		progress_remark = JSON.parse(progress_remark)
	}else{
		var progress_remark = []
	}
	$(".progress_remark").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // progress_remark.push({progress_remark : $(this).val()});
		 	var obj = {}
			obj['in_progress_remarks'] = $(this).val()
			progress_remark[index] = obj
		}
	});
		// var verifier_designation = [];
	if(candidateInfo['remark_verifier_designation'] != null){
		var verifier_designation = candidateInfo['remark_verifier_designation'].split(',');
		verifier_designation = JSON.parse(verifier_designation)
	}else{
		var verifier_designation = []
	}
	$(".verifier_designation").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // verifier_designation.push({verifier_designation : $(this).val()});
		 	var obj = {}
			obj['verifier_designation'] = $(this).val()
			verifier_designation[index] = obj
		}
	});
		// var verifier_email = [];
	if(candidateInfo['remark_verifier_email'] != null){
		var verifier_email = candidateInfo['remark_verifier_email'].split(',');
		verifier_email = JSON.parse(verifier_email)
	}else{
		var verifier_email = []
	}
	$(".verifier_email").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // verifier_email.push({verifier_email : $(this).val()});
		 	var obj = {}
			obj['verifier_email'] = $(this).val()
			verifier_email[index] = obj
		}
	});
	
		// var verifier_remark = [];
	if(candidateInfo['verification_remarks'] != null){
		var verifier_remark = candidateInfo['verification_remarks'].split(',');
		verifier_remark = JSON.parse(verifier_remark)
	}else{
		var verifier_remark = []
	}
	$(".verifier_remark").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // verifier_remark.push({verifier_remark : $(this).val()});
		 	var obj = {}
			obj['verification_remarks'] = $(this).val()
			verifier_remark[index] = obj
		}
	});
		// var closure_remarks = [];
	if(candidateInfo['insuff_closure_remarks'] != null){
		var closure_remarks = candidateInfo['insuff_closure_remarks'].split(',');
		closure_remarks = JSON.parse(closure_remarks)
	}else{
		var closure_remarks = []
	}
	$(".closure_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 // closure_remarks.push({closure_remarks : $(this).val()});
		 	var obj = {}
			obj['insuff_closure_remarks'] = $(this).val()
			closure_remarks[index] = obj
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
 


	var candidate_id_hidden = $("#candidate_id_hidden").val(); 
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

	var formdata = new FormData();
	formdata.append('userID',userID);
	formdata.append('userRole',userRole);
	formdata.append('roll_number',JSON.stringify(roll_number));
	formdata.append('institute_name',JSON.stringify(institute_name));
	formdata.append('year_of_education',JSON.stringify(year_of_education));
	formdata.append('physical_visit',JSON.stringify(physical_visit));
	formdata.append('verifier_name',JSON.stringify(verifier_name));
	formdata.append('verifier_contact',JSON.stringify(verifier_contact));
	formdata.append('verifier_fee',JSON.stringify(verifier_fee));
	formdata.append('insuff_remarks',JSON.stringify(insuff_remarks));
	formdata.append('type_of_degree',JSON.stringify(type_of_degree));
	formdata.append('university_name',JSON.stringify(university_name));  
	formdata.append('result_grade',JSON.stringify(result_grade));
	formdata.append('progress_remark',JSON.stringify(progress_remark));
	formdata.append('verifier_designation',JSON.stringify(verifier_designation));
	formdata.append('verifier_email',JSON.stringify(verifier_email));
	formdata.append('verifier_remark',JSON.stringify(verifier_remark));
	formdata.append('verified_date',JSON.stringify(verified_date));
	formdata.append('closure_remarks',JSON.stringify(closure_remarks)); 
	formdata.append('candidate_id',candidate_id_hidden); 
	formdata.append('analyst_status',analyst_status); 
	formdata.append('selected_component_status',action_status);
	formdata.append('index',index); 
	formdata.append('priority',priority); 
	formdata.append('education_details_id',education_details_id); 
	var vendor_id = $("#vendor_name").val();
    var component_id = $("#component_id").val();
		formdata.append('component_id',component_id);
  formdata.append('vendor_id',vendor_id);
  formdata.append('component_name','Highest Education');
 

	var op_action_status = $('#op_action_status').val();
	if(op_action_status == null || op_action_status == ''){
		formdata.append('op_action_status','0')	
	}else{
		formdata.append('op_action_status',op_action_status)
	}

	formdata.append('count',candidate_aadhar.length);

	if (candidate_aadhar.length > 0) {
		for (var i = 0; i < candidate_aadhar.length; i++) { 
			formdata.append('remark_docs[]',candidate_aadhar[i]);
		}
	}else{
		formdata.append('remark_docs[]','');
	} 
	var each_count_of_detail = $('#each_count_of_detail').val();
	// console.log(each_count_of_detail)
	// if(roll_number.length == each_count_of_detail &&  institute_name.length == each_count_of_detail && year_of_education.length == each_count_of_detail &&
		// type_of_degree.length == each_count_of_detail && university_name.length == each_count_of_detail && verifier_remark.length == each_count_of_detail ){
		$.ajax({
	        type: "POST",
	          url: base_url+"analyst/remarkForEduCheck",
	          data:formdata,
	          dataType: 'json',
	          contentType: false,
	          processData: false,
	          success: function(data) {
	          	$('#submit-edu-data').attr('disabled',false);
	          	$('#edu-cancle').attr('disabled',false);
	          	$('#submit-edu-data').removeClass('buttonload');
	 			$('#submit-edu-data').html('Confirm');
	          	$('#conformtionEdu').modal('hide');
	          	$('#wait-message').html('');
	          	$('#action_status_error').html('')
				if (data.status == '1') {
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
 
	// 	$('#edu-cancle').attr('disabled',false);
	// 	$('#wait-message').html('Please enter valid detail OR should not empty mandatory field.')
	// 	$('#wait-message').addClass('text-danger')
	// 	if(action_status == 0){
	// 		$('#action_status_error').html('Please select any valid status')
	// 	}

	// 	$('.institute_name').each(function(){
	// 		var MyID = $(this).attr("id"); 
	// 	    var number = MyID.match(/\d+/); 
	// 	    valid_roll_number(number);
	// 	    valid_institute_name(number);
	// 	    valid_year_of_education(number);
	// 	    valid_type_of_degree(number);
	// 	    valid_verifier_remark(number);
	// 	    valid_university_name(number);
		    
		     
	// 	});
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
	if($('#physical_visit'+id).prop('checked') == true) { 
    	$('#physical-visit-label'+id).html('Yes')
	} else {
		$('#physical-visit-label'+id).html('No')
	}
}


function valid_roll_number(id){

	var roll_number = $("#roll_number"+id).val();
	if (roll_number !='') {
		$("#roll_number-error"+id).html("&nbsp;");
		input_is_valid("#roll_number"+id)
		return 1
	}else{
		input_is_invalid("#roll_number"+id)
		$("#roll_number-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid role or register number</span>");
		return 0
	}
}

function valid_institute_name(id){
	var institute_name = $("#institute_name"+id).val();
	if (institute_name !='') {
		$("#institute_name-error"+id).html("&nbsp;");
		input_is_valid("#institute_name"+id)
		return 1
	}else{
		input_is_invalid("#institute_name"+id)
		$("#institute_name-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Institute Name.</span>");
		return 0
	}
}

function valid_year_of_education(id){
	var year_of_education = $("#year_of_education"+id).val();
	if (year_of_education !='') {

		$("#year_of_education-error"+id).html("&nbsp;");
		input_is_valid("#year_of_education"+id)
		return 1
	}else{
		input_is_invalid("#year_of_education"+id)
		$("#year_of_education-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Institute Name.</span>");
		return 0
	}
}

function valid_type_of_degree(id){
	var year_of_education = $("#year_of_education"+id).val();
	if (year_of_education !='') {
		$("#year_of_education-error"+id).html("&nbsp;");
		input_is_valid("#year_of_education"+id)
		return 1
	}else{
		input_is_invalid("#year_of_education"+id)
		$("#year_of_education-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Institute Name.</span>");
		return 0
	}
}

// getYearList()

function valid_verifier_remark(id){
	
	var verifier_remark = $("#verifier_remark"+id).val();
	if (verifier_remark !='') {
		$("#verifier_remark-error"+id).html("&nbsp;");
		input_is_valid("#verifier_remark"+id)
		return 1
	}else{
		input_is_invalid("#verifier_remark"+id)
		$("#verifier_remark-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Remarks.</span>");
		return 0
	}
}

function valid_university_name(id){
	
	var verifier_remark = $("#university_name"+id).val();
	if (verifier_remark !='') {
		$("#university_name-error"+id).html("&nbsp;");
		input_is_valid("#university_name"+id)
		return 1
	}else{
		input_is_invalid("#university_name"+id)
		$("#university_name-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Institute Name.</span>");
		return 0
	}
}

 