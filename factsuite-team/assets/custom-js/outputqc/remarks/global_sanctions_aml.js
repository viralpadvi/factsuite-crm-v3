var candidate_aadhar = [];
var max_client_document_select = 20;
var client_document_size = 200000000;

// console.log(JSON.stringify(candidateInfo))

$("#client-documents").on("change", handleFileSelect_candidate_aadhar);   


function handleFileSelect_candidate_aadhar(e){ 
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
function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}



$('#cancle-data-btn').on('click',function(){
	$("#warning-msg").html("");
})

var candidateInfo
function phpData(phpData){ 
	candidateInfo = phpData;
}

$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#conformtion").hasClass('show')){  
		var key = e.which;
	    if (key == 13) {
	      	global_sactions_aml()
	      	return false;
	    }
	}
});


$("#add-court-record").on('click',function(){
	global_sactions_aml()
});

function global_sactions_aml(){

	var index = $('#componentIndex').val()
	var priority = $('#priority').val()

	if(candidateInfo['remark_country'] != null){
		var country = candidateInfo['remark_country'].split(',');
		country = JSON.parse(country)
	}else{
		var country = []
	}
	$(".country").each(function(){
		 
		if ($(this).val() !='' && $(this).val() !=null) {
		  
			var obj = {}
			obj['country'] = $(this).val()
			country[index] = obj
			// alert(JSON.stringify(address))
			 
		}
	});
	 

	if(candidateInfo['insuff_remarks'] != null){
		var insuff_remarks = candidateInfo['insuff_remarks'].split(',');
		insuff_remarks = JSON.parse(insuff_remarks)
	}else{
		var insuff_remarks = []
	}
	$(".insuff_remarks").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
			// insuff_remarks.push({insuff_remarks : $(this).val()});
			var obj = {}
			obj['insuff_remarks'] = $(this).val()
			insuff_remarks[index] = obj
			// alert(JSON.stringify(insuff_remarks))
		}
	}); 
	// var progress_remarks = [];
	if(candidateInfo['in_progress_remarks'] != null){
		var progress_remarks = candidateInfo['in_progress_remarks'].split(',');
		progress_remarks = JSON.parse(progress_remarks)
	}else{
		var progress_remarks = []
	}
	$(".progress_remarks").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
			// progress_remarks.push({progress_remarks : $(this).val()});
			var obj = {}
			obj['progress_remarks'] = $(this).val()
			progress_remarks[index] = obj
			// alert(JSON.stringify(progress_remarks))
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
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
			// verification_remarks.push({verification_remarks : $(this).val()});
			var obj = {}
			obj['verification_remarks'] = $(this).val()
			verification_remarks[index] = obj
			// alert(JSON.stringify(verification_remarks))
		}
	}); 
	// var closure_remarks = [];
	if(candidateInfo['Insuff_closure_remarks'] != null){
		var closure_remarks = candidateInfo['Insuff_closure_remarks'].split(',');
		closure_remarks = JSON.parse(closure_remarks)
	}else{
		var closure_remarks = []
	}
	$(".closure_remarks").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
			// closure_remarks.push({closure_remarks : $(this).val()});
			var obj = {}
			obj['closure_remarks'] = $(this).val()
			closure_remarks[index] = obj
			// alert(JSON.stringify(closure_remarks))
		}
	}); 

 
	var analyst_status = [];
	$(".analyst_status").each(function(){
			analyst_status.push($(this).val());
	}); 

	var output_status = [];
	$(".output_status").each(function(){
			output_status.push($(this).val());
	}); 

 	var ouputQcComment = [];
	$(".ouputQcComment").each(function(){ 
		ouputQcComment.push({ouputQcComment : $(this).val()}); 
	});
	
	var global_sanctions_aml_id = $("#global_sanctions_aml_id").val();
	 
	var userID = $("#userID").val();
	
	var userRole = $("#userRole").val();

	var formdata = new FormData();
	// formdata.append('url',1);
	formdata.append('country',JSON.stringify(country));
	formdata.append('insuff_remarks',JSON.stringify(insuff_remarks));
	formdata.append('progress_remarks',JSON.stringify(progress_remarks));
	formdata.append('verification_remarks',JSON.stringify(verification_remarks));
	formdata.append('closure_remarks',JSON.stringify(closure_remarks));
	formdata.append('global_sanctions_aml_id',global_sanctions_aml_id);
	formdata.append('action_status',analyst_status);
	formdata.append('output_status',output_status);
	formdata.append('ouputQcComment',JSON.stringify(ouputQcComment));
	formdata.append('count',candidate_aadhar.length);
	formdata.append('userID',userID);
	formdata.append('userRole',userRole);
	formdata.append('index',index);
	formdata.append('priority',priority);
	 
	var candidate_id_hidden = $('#candidate_id_hidden').val()
	formdata.append('candidate_id',candidate_id_hidden);
	
	if (candidate_aadhar.length > 0) {
		for (var i = 0; i < candidate_aadhar.length; i++) { 
			formdata.append('remark_docs[]',candidate_aadhar[i]);
		}
	}else{
		formdata.append('remark_docs[]','');
	} 


$("#add-court-record").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
	 

	// if (verification_remarks.length > 0 ) {
	$("#wait-message").html("<span class='text-warning'>Please wait while we are updating the data.</span>");
		$.ajax({
            type: "POST",
              url: base_url+"outPutQc/update_remarks_global_sanctions_aml_check",
              data:formdata,
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(data) {
				if (data.status == '1') {
					toastr.success('successfully saved data.');   
					// $('.is-valid').removeClass('is-valid');
					window.location.href = base_url+"factsuite-outputqc/assigned-view-case-detail/"+candidate_id_hidden;
              	}else{
              		toastr.error('Something went wrong while save this data. Please try again.'); 	
              	}
              	$("#wait-message").html("");
              	$('#conformtion').modal('hide');
              	$("#add-court-record").html("Confirm")
              }
            });
	// }else{

	// 	$("#wait-message").html("<span class='text-danger'>Please enter required data.</span>");
	// 	$(".address").each(function(){
	// 		var MyID = $(this).attr("id"); 
	// 	   var number = MyID.match(/\d+/); 
	// 	   valid_verification_remarks(number)
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


function remove_form(id){
	$("#form"+id).remove();
}

function valid_verification_remarks(id){
	var verification_remarks = $("#verification_remarks"+id).val();
	if (verification_remarks !='') {
		$("#verification_remarks"+id).html("&nbsp;");
		input_is_valid("#verification_remarks"+id)
	}else{
		input_is_invalid("#verification_remarks"+id)
		$("#verification_remarks"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid address</span>");
	}
}
 