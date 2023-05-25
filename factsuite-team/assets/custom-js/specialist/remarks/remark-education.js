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
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
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
$('#submit-edu-data').on('click',function(){
	// alert('Data')
	$('#wait-message').html('Please,Wait we are updateg your data.')
	$('#wait-message').addClass('text-warning')
 	$('#submit-edu-data').attr('disabled',true);
 	$('#edu-cancle').attr('disabled',true);
 	$('#submit-edu-data').addClass('buttonload');
 	$('#submit-edu-data').html('<i class="fa fa-circle-o-notch fa-spin"></i> Loading');


		var roll_number = [];
	$(".roll_number").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 roll_number.push({roll_number : $(this).val()});
		}
	});
		var institute_name = [];
	$(".institute_name").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 institute_name.push({institute_name : $(this).val()});
		}
	});
		var year_of_education = [];
	$(".year_of_education").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 year_of_education.push({year_of_education : $(this).val()});
		}
	});
		var physical_visit = [];
	$(".physical_visit").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 physical_visit.push({physical_visit : $(this).val()});
		}
	});
	// 	var assigned_to_vendor = [];
	// $(".assigned_to_vendor").each(function(){
	// 	// address['address']=$(this).val();
	// 	if ($(this).val() !='' && $(this).val() !=null) {
	// 	 assigned_to_vendor.push({assigned_to_vendor : $(this).val()});
	// 	}
	// });
		var verifier_name = [];
	$(".verifier_name").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 verifier_name.push({verifier_name : $(this).val()});
		}
	});
		var verifier_contact = [];
	$(".verifier_contact").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 verifier_contact.push({verifier_contact : $(this).val()});
		}
	});
		var verifier_fee = [];
	$(".verifier_fee").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 verifier_fee.push({verifier_fee : $(this).val()});
		}
	});
		var insuff_remarks = [];
	$(".insuff_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 insuff_remarks.push({insuff_remarks : $(this).val()});
		}
	});
	
		var type_of_degree = [];
	$(".type_of_degree").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 type_of_degree.push({type_of_degree : $(this).val()});
		}
	});
		var university_name = [];
	$(".university_name").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 university_name.push({university_name : $(this).val()});
		}
	});
		var result_grade = [];
	$(".result_grade").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 result_grade.push({result_grade : $(this).val()});
		}
	});
		var progress_remark = [];
	$(".progress_remark").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 progress_remark.push({progress_remark : $(this).val()});
		}
	});
		var verifier_designation = [];
	$(".verifier_designation").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 verifier_designation.push({verifier_designation : $(this).val()});
		}
	});
		var verifier_email = [];
	$(".verifier_email").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 verifier_email.push({verifier_email : $(this).val()});
		}
	});
	
		var verifier_remark = [];
	$(".verifier_remark").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 verifier_remark.push({verifier_remark : $(this).val()});
		}
	});
		var closure_remarks = [];
	$(".closure_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 closure_remarks.push({closure_remarks : $(this).val()});
		}
	});


	var candidate_id_hidden = $("#candidate_id_hidden").val(); 
	var action_status = $("#action_status").val(); 

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
	formdata.append('closure_remarks',JSON.stringify(closure_remarks)); 
	formdata.append('candidate_id',candidate_id_hidden); 
	formdata.append('analyst_status',action_status); 
	var op_action_status = $('#op_action_status').val();
	if(op_action_status == null || op_action_status == ''){
		formdata.append('op_action_status','0')	
	}else{
		formdata.append('op_action_status',op_action_status)
	}

	formdata.append('count',candidate_aadhar.length);

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
	var each_count_of_detail = $('#each_count_of_detail').val();
	// console.log(each_count_of_detail)
	if(roll_number.length == each_count_of_detail &&  institute_name.length == each_count_of_detail && year_of_education.length == each_count_of_detail &&
		type_of_degree.length == each_count_of_detail && university_name.length == each_count_of_detail && verifier_remark.length == each_count_of_detail ){
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
	          	$("#warning-msg").html("");
	          }
        });
	}else{
 
		$('#edu-cancle').attr('disabled',false);
		$('#wait-message').html('Please enter valid detail OR should not empty mandatory field.')
		$('#wait-message').addClass('text-danger')
		if(action_status == 0){
			$('#action_status_error').html('Please select any valid status')
		}

		$('.institute_name').each(function(){
			var MyID = $(this).attr("id"); 
		    var number = MyID.match(/\d+/); 
		    valid_roll_number(number);
		    valid_institute_name(number);
		    valid_year_of_education(number);
		    valid_type_of_degree(number);
		    valid_verifier_remark(number);
		    valid_university_name(number);
		    
		     
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
		$("#verifier_remark-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Institute Name.</span>");
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