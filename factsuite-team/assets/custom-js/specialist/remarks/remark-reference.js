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

$('#cancle-data-btn').on('click',function(){
	$("#warning-msg").html("");
})


$('#submit-reference-data').on('click',function(){

	var role_responsibility = [];
	$(".role_responsibility").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 role_responsibility.push({role_responsibility : $(this).val()});
		}
	});
		var professional_strengths = [];
	$(".professional_strengths").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 professional_strengths.push({professional_strengths : $(this).val()});
		}
	});
		var attendance = [];
	$(".attendance").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 attendance.push({attendance : $(this).val()});
		}
	});
		var mode_of_exit = [];
	$(".mode_of_exit").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 mode_of_exit.push({mode_of_exit : $(this).val()});
		}
	});
		var communication = [];
	$(".communication").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 communication.push({communication : $(this).val()});
		}
	});
		var attitude = [];
	$(".attitude").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 attitude.push({attitude : $(this).val()});
		}
	});
		var reliability = [];
	$(".reliability").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 reliability.push({reliability : $(this).val()});
		}
	});
		var orientation = [];
	$(".orientation").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 orientation.push({orientation : $(this).val()});
		}
	});
		var remark_managers_contact = [];
	$(".remark_managers_contact").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 remark_managers_contact.push({remark_managers_contact : $(this).val()});
		}
	});
	
		var management = [];
	$(".management").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 management.push({management : $(this).val()});
		}
	});
		var progress_remarks = [];
	$(".progress_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 progress_remarks.push({progress_remarks : $(this).val()});
		}
	});
		var insuff_remarks = [];
	$(".insuff_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 insuff_remarks.push({insuff_remarks : $(this).val()});
		}
	});
		var project_handled = [];
	$(".project_handled").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 project_handled.push({project_handled : $(this).val()});
		}
	});
		var professional_weakness = [];
	$(".professional-weakness").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 professional_weakness.push({professional_weakness : $(this).val()});
		}
	});
		var accomplishments = [];
	$(".accomplishments").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 accomplishments.push({accomplishments : $(this).val()});
		}
	});
	$("#wait-message").html("<span class='text-danger'>Please enter required data.</span>");
		var job_performance = [];
	$(".job_performance").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 job_performance.push({job_performance : $(this).val()});
		}
	});
		var integrity = [];
	$(".integrity").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 integrity.push({integrity : $(this).val()});
		}
	});

		var quality = [];
	$(".quality").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 quality.push({quality : $(this).val()});
		}
	});

		var pressure = [];
	$(".pressure").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 pressure.push({pressure : $(this).val()});
		}
	});
	
		var player = [];
	$(".player").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 player.push({player : $(this).val()});
		}
	});

		var additional_comments = [];
	$(".additional_comments").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 additional_comments.push({additional_comments : $(this).val()});
		}
	});

		var verification_remarks = [];
	$(".verification_remarks").each(function(){
		// address['address']=$(this).val();
		if ($(this).val() !='' && $(this).val() !=null) {
		 verification_remarks.push({verification_remarks : $(this).val()});
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
	formdata.append('role_responsibility',JSON.stringify(role_responsibility));
	formdata.append('professional_strengths',JSON.stringify(professional_strengths));
	formdata.append('attendance',JSON.stringify(attendance));
	formdata.append('mode_of_exit',JSON.stringify(mode_of_exit));
	formdata.append('communication',JSON.stringify(communication));
	formdata.append('attitude',JSON.stringify(attitude));
	formdata.append('reliability',JSON.stringify(reliability));
	formdata.append('orientation',JSON.stringify(orientation));
	formdata.append('management',JSON.stringify(management));
	formdata.append('progress_remarks',JSON.stringify(progress_remarks));
	formdata.append('project_handled',JSON.stringify(project_handled));
	formdata.append('professional_weakness',JSON.stringify(professional_weakness));
	formdata.append('accomplishments',JSON.stringify(accomplishments));
	formdata.append('job_performance',JSON.stringify(job_performance));
	formdata.append('integrity',JSON.stringify(integrity));
	formdata.append('quality',JSON.stringify(quality));
	formdata.append('pressure',JSON.stringify(pressure));
	formdata.append('player',JSON.stringify(player));
	formdata.append('additional_comments',JSON.stringify(additional_comments));
	formdata.append('insuff_remarks',JSON.stringify(insuff_remarks));
	formdata.append('verification_remarks',JSON.stringify(verification_remarks));
	formdata.append('closure_remarks',JSON.stringify(closure_remarks)); 
	formdata.append('candidate_id',candidate_id_hidden); 
	formdata.append('analyst_status',action_status); 
	formdata.append('count',candidate_aadhar.length);
	var op_action_status = $('#op_action_status').val();
	if(op_action_status == null || op_action_status == '' || op_action_status == 'null'){
		formdata.append('op_action_status','0')	
	}else{
		formdata.append('op_action_status',op_action_status)
	}

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

				formdata.append('approved_doc[]','');
			}
		});
			a++;
		});
 
	}else{
		formdata.append('approved_doc[]',''); 
	} 

	countOfCompanyName = $('#countOfCompanyName').val()
	if( verification_remarks.length == countOfCompanyName){

	$.ajax({
        type: "POST",
          url: base_url+"analyst/update_reference",
          data:formdata,
          dataType: 'json',
          contentType: false,
          processData: false,
          success: function(data) {
          	$('#conformtionReferance').modal('hide');
			if (data.status == '1') {
				toastr.success('successfully update data.');  
				$('.is-valid').removeClass('is-valid'); 
				$("#wait-message").html("");
          	}else{
          		toastr.error('Something went wrong while save this data. Please try again.'); 	
          	}
          	$("#warning-msg").html("");
          }
        });
	}else{
		$("#wait-message").html("<span class='text-danger'>Please enter required data.</span>");
		$('.verification_remarks').each(function(){
			var MyID = $(this).attr("id"); 
		    var number = MyID.match(/\d+/);  
			varificationRemarks(number)
		     
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
function varificationRemarks(id){
	verification_remarks
	var verification_remarks = $("#verification_remarks"+id).val();
	if (verification_remarks !='') {
		$("#verification_remarks-error"+id).html("&nbsp;");
		input_is_valid("#verification_remarks"+id)
		return 1
	}else{
		input_is_invalid("#verification_remarks"+id)
		$("#verification_remarks-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid Rremarks</span>");
		return 0
	}
}