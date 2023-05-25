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

$('#cancle-data-btn').on('click',function(){
	$("#warning-msg").html("");
})

var candidateInfo
function phpData(phpData){ 
	candidateInfo = phpData;
	// console.log(JSON.stringify(candidateInfo));
}

$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#conformtionReferance").hasClass('show')){  
		var key = e.which;
	    if (key == 13) {
	      	reference();
	      	return false;
	    }
	}
});

$('#submit-reference-data').on('click',function(){
	reference();
});

function reference(){
	var index = $('#componentIndex').val()
	var priority = $('#priority').val()
	var reference_id = $('#reference_id').val()


	// var role_responsibility = [];
	if(candidateInfo['roles_responsibilities'] != null){
		var role_responsibility = candidateInfo['roles_responsibilities'].split(',');
		role_responsibility = JSON.parse(role_responsibility)
	}else{
		var role_responsibility = []
	}
	$(".role_responsibility").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // role_responsibility.push({role_responsibility : $(this).val()});
		 	var obj = {}
			obj['role_responsibility'] = $(this).val()
			role_responsibility[index] = obj
		// }
	});
		// var professional_strengths = [];

	if(candidateInfo['professional_strengths'] != null){
		var professional_strengths = candidateInfo['professional_strengths'].split(',');
		professional_strengths = JSON.parse(professional_strengths)
	}else{
		var professional_strengths = []
	}
	$(".professional_strengths").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // professional_strengths.push({professional_strengths : $(this).val()});
		 	var obj = {}
			obj['professional_strengths'] = $(this).val()
			professional_strengths[index] = obj
		// }
	});
		// var attendance = [];
	if(candidateInfo['attendance_punctuality'] != null){
		var attendance = candidateInfo['attendance_punctuality'].split(',');
		attendance = JSON.parse(attendance)
	}else{
		var attendance = []
	}
	$(".attendance").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 	// attendance.push({attendance : $(this).val()});
		 	var obj = {}
			obj['attendance'] = $(this).val()
			attendance[index] = obj
		// }
	});
		// var mode_of_exit = [];
	if(candidateInfo['mode_exit'] != null){
		var mode_of_exit = candidateInfo['mode_exit'].split(',');
		mode_of_exit = JSON.parse(mode_of_exit)
	}else{
		var mode_of_exit = []
	}
	$(".mode_of_exit").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // mode_of_exit.push({mode_of_exit : $(this).val()});
		 	var obj = {}
			obj['mode_of_exit'] = $(this).val()
			mode_of_exit[index] = obj
		// }
	});
		// var communication = [];
	if(candidateInfo['communication'] != null){
		var communication = candidateInfo['communication'].split(',');
		communication = JSON.parse(communication)
	}else{
		var communication = []
	}
	$(".communication").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // communication.push({communication : $(this).val()});
		 	var obj = {}
			obj['communication'] = $(this).val()
			communication[index] = obj
		// }
	});
		// var attitude = [];
	if(candidateInfo['attitude'] != null){
		var attitude = candidateInfo['attitude'].split(',');
		attitude = JSON.parse(attitude)
	}else{
		var attitude = []
	}
	$(".attitude").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // attitude.push({attitude : $(this).val()});
		 	var obj = {}
			obj['attitude'] = $(this).val()
			attitude[index] = obj
		// }
	});
	// var reliability = [];
	if(candidateInfo['reliability'] != null){
		var reliability = candidateInfo['reliability'].split(',');
		reliability = JSON.parse(reliability)
	}else{
		var reliability = []
	}
	$(".reliability").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // reliability.push({reliability : $(this).val()});
		 	var obj = {}
			obj['reliability'] = $(this).val()
			reliability[index] = obj
		// }
	});
		// var orientation = [];
	if(candidateInfo['orientation'] != null){
		var orientation = candidateInfo['orientation'].split(',');
		orientation = JSON.parse(orientation)
	}else{
		var orientation = []
	}
	$(".orientation").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // orientation.push({orientation : $(this).val()});
		 	var obj = {}
			obj['orientation'] = $(this).val()
			orientation[index] = obj
		// }
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
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // remark_managers_contact.push({remark_managers_contact : $(this).val()});
		 	var obj = {}
			obj['remark_managers_contact'] = $(this).val()
			remark_managers_contact[index] = obj
		// }
	});
	
		// var management = [];
	if(candidateInfo['management'] != null){
		var management = candidateInfo['management'].split(',');
		management = JSON.parse(management)
	}else{
		var management = []
	}
	$(".management").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // management.push({management : $(this).val()});
		 	var obj = {}
			obj['management'] = $(this).val()
			management[index] = obj
		// }
	});
		// var progress_remarks = [];
	if(candidateInfo['progress_remarks'] != null){
		var progress_remarks = candidateInfo['progress_remarks'].split(',');
		progress_remarks = JSON.parse(progress_remarks)
	}else{
		var progress_remarks = []
	}
	$(".progress_remarks").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // progress_remarks.push({progress_remarks : $(this).val()});
		 var obj = {}
			obj['progress_remarks'] = $(this).val()
			progress_remarks[index] = obj
		// }
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
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // insuff_remarks.push({insuff_remarks : $(this).val()});
		 	var obj = {}
			obj['insuff_remarks'] = $(this).val()
			insuff_remarks[index] = obj
		// }
	});
		// var project_handled = [];
	if(candidateInfo['projects_handled'] != null){
		var project_handled = candidateInfo['projects_handled'].split(',');
		project_handled = JSON.parse(project_handled)
	}else{
		var project_handled = []
	}
	$(".project_handled").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // project_handled.push({project_handled : $(this).val()});
		 	var obj = {}
			obj['project_handled'] = $(this).val()
			project_handled[index] = obj
		// }
	});
		// var professional_weakness = [];
	if(candidateInfo['professional_weakness'] != null){
		var professional_weakness = candidateInfo['professional_weakness'].split(',');
		professional_weakness = JSON.parse(professional_weakness)
	}else{
		var professional_weakness = []
	}
	$(".professional-weakness").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // professional_weakness.push({professional_weakness : $(this).val()});
		 	var obj = {}
			obj['professional_weakness'] = $(this).val()
			professional_weakness[index] = obj
		// }
	});
		// var accomplishments = [];
	if(candidateInfo['accomplishments'] != null){
		var accomplishments = candidateInfo['accomplishments'].split(',');
		accomplishments = JSON.parse(accomplishments)
	}else{
		var accomplishments = []
	}
	$(".accomplishments").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // accomplishments.push({accomplishments : $(this).val()});
		 	var obj = {}
			obj['accomplishments'] = $(this).val()
			accomplishments[index] = obj
		// }
	});
	// $("#wait-message").html("<span class='text-danger'>Please enter required data.</span>");
		// var job_performance = [];
	if(candidateInfo['job_performance'] != null){
		var job_performance = candidateInfo['job_performance'].split(',');
		job_performance = JSON.parse(job_performance)
	}else{
		var job_performance = []
	}
	$(".job_performance").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // job_performance.push({job_performance : $(this).val()});
		 	var obj = {}
			obj['job_performance'] = $(this).val()
			job_performance[index] = obj
		// }
	});
		// var integrity = [];
	if(candidateInfo['integrity'] != null){
		var integrity = candidateInfo['integrity'].split(',');
		integrity = JSON.parse(integrity)
	}else{
		var integrity = []
	}
	$(".integrity").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // integrity.push({integrity : $(this).val()});
		 	var obj = {}
			obj['integrity'] = $(this).val()
			integrity[index] = obj
		// }
	});

		// var quality = [];
	if(candidateInfo['leadership_quality'] != null){
		var quality = candidateInfo['leadership_quality'].split(',');
		quality = JSON.parse(quality)
	}else{
		var quality = []
	}
	$(".quality").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // quality.push({quality : $(this).val()});
		 	var obj = {}
			obj['quality'] = $(this).val()
			quality[index] = obj
		// }
	});

		// var pressure = [];
	if(candidateInfo['pressure_handling_nature'] != null){
		var pressure = candidateInfo['pressure_handling_nature'].split(',');
		pressure = JSON.parse(pressure)
	}else{
		var pressure = []
	}
	$(".pressure").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // pressure.push({pressure : $(this).val()});
		 	var obj = {}
			obj['pressure'] = $(this).val()
			pressure[index] = obj
		// }
	});
	
		// var player = [];
	if(candidateInfo['team_player'] != null){
		var player = candidateInfo['team_player'].split(',');
		player = JSON.parse(player)
	}else{
		var player = []
	}
	$(".player").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // player.push({player : $(this).val()});
		 	var obj = {}
			obj['player'] = $(this).val()
			player[index] = obj
		// }
	});

		// var additional_comments = [];
	if(candidateInfo['additional_comments'] != null){
		var additional_comments = candidateInfo['additional_comments'].split(',');
		// alert(additional_comments);
		additional_comments = JSON.parse(additional_comments)
	}else{
		var additional_comments = []
	}
	$(".additional_comments").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // additional_comments.push({additional_comments : $(this).val()});
		 	var obj = {}
			obj['additional_comments'] = $(this).val()
			additional_comments[index] = obj
		// }
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
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // verification_remarks.push({verification_remarks : $(this).val()});
		 	var obj = {}
			obj['verification_remarks'] = $(this).val()
			verification_remarks[index] = obj
		// }
	});

		// var closure_remarks = [];
	if(candidateInfo['closure_remarks'] != null){
		var closure_remarks = candidateInfo['closure_remarks'].split(',');
		closure_remarks = JSON.parse(closure_remarks)
	}else{
		var closure_remarks = []
	}
	$(".closure_remarks").each(function(){
		// address['address']=$(this).val();
		// if ($(this).val() !='' && $(this).val() !=null) {
		 // closure_remarks.push({closure_remarks : $(this).val()});
		 	var obj = {}
			obj['closure_remarks'] = $(this).val()
			closure_remarks[index] = obj
		// }
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
 

	// alert(candidateInfo['verified_by'])
	if(candidateInfo['verified_by'] != null){
		var verified_by = candidateInfo['verified_by'].split(',');
		// alert()
		verified_by = JSON.parse(verified_by)
	}else{
		var verified_by = []
	}
	$(".verified_by").each(function(){
		
		var obj = {}
		obj['verified_by'] = $(this).val()
		verified_by[index] = obj
		 
	});

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
	var vendor_id = $('#vendor_name').val();
	
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
	formdata.append('verified_date',JSON.stringify(verified_date));
	formdata.append('closure_remarks',JSON.stringify(closure_remarks)); 
	formdata.append('candidate_id',candidate_id_hidden); 
	formdata.append('analyst_status',analyst_status); 
	formdata.append('count',candidate_aadhar.length);
	formdata.append('index',index);
	formdata.append('priority',priority);
	formdata.append('reference_id',reference_id);
	var component_id = $("#component_id").val();
		formdata.append('component_id',component_id);
	formdata.append('vendor_id',vendor_id);
	formdata.append('component_name','Reference');
	formdata.append('verified_by',JSON.stringify(verified_by));




	var op_action_status = $('#op_action_status').val();
	if(op_action_status == null || op_action_status == '' || op_action_status == 'null'){
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
	 


	countOfCompanyName = $('#countOfCompanyName').val()
	// if( verification_remarks.length == countOfCompanyName){

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
          	get_latest_selected_vendor();
          	$("#warning-msg").html("");
          }
        });
	// }else{
	// 	$("#wait-message").html("<span class='text-danger'>Please enter required data.</span>");
	// 	$('.verification_remarks').each(function(){
	// 		var MyID = $(this).attr("id"); 
	// 	    var number = MyID.match(/\d+/);  
	// 		varificationRemarks(number)
		     
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
 