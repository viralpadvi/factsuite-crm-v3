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
var candidate_voter =[];
var candidate_ssn =[];


$("#file1").on("change", handleFileSelect_candidate_aadhar);
$("#file2").on("change", handleFileSelect_candidate_pan);
$("#file3").on("change", handleFileSelect_candidate_proof); 
$("#file4").on("change", handleFileSelect_candidate_voter); 
$("#file5").on("change", handleFileSelect_candidate_ssn); 


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


function handleFileSelect_candidate_voter(e){
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
	            	  html = '<div id="file_candidate_voter_'+i+'"><span>'+fileName+' <a id="file_candidate_voter'+i+'" onclick="removeFile_candidate_voter('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image_voter('+i+',\'candidate_voter\')" ><i class="fa fa-eye"></i></a></span></div>';
	                candidate_voter.push(files[i]);
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

function removeFile_candidate_voter(id) {

    var file = $('#file_candidate_voter'+id).data("file");
    for(var i = 0; i < candidate_voter.length; i++) {
        if(candidate_voter[i].name === file) {
            candidate_voter.splice(i,1); 
        }
    }
    if (candidate_voter.length == 0) {
    	$("#file4").val('');
    }
    $('#file_candidate_voter_'+id).remove(); 
} 




function handleFileSelect_candidate_ssn(e){
	    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#file5-error").html('');
        $(".file-name5").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	        		 var fileName = files[i].name; // get file name  
	        	if ((/\.(gif|jpg|jpeg|tiff|png|pdf|doc|docx)$/i).test(fileName)) {
	            	  html = '<div id="file_candidate_ssn_'+i+'"><span>'+fileName+' <a id="file_candidate_ssn'+i+'" onclick="removeFile_candidate_ssn('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image_ssn('+i+',\'candidate_ssn\')" ><i class="fa fa-eye"></i></a></span></div>';
	                candidate_ssn.push(files[i]);
	                $(".file-name5").append(html); 
	        	} 
	        }
	    } else {
	    	$("#file5-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#file5').val('');
	    }
    } else {
        $("#file5-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_candidate_ssn(id) {

    var file = $('#file_candidate_ssn'+id).data("file");
    for(var i = 0; i < candidate_ssn.length; i++) {
        if(candidate_ssn[i].name === file) {
            candidate_ssn.splice(i,1); 
        }
    }
    if (candidate_ssn.length == 0) {
    	$("#file5").val('');
    }
    $('#file_candidate_ssn_'+id).remove(); 
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


function view_image_pan(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_pan[id]);
}

function view_image_proof(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader(); 
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_proof[id]);
}


function view_image_voter(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader(); 
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_voter[id]);
}

function view_image_ssn(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader(); 
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_ssn[id]);
}

function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}
 

$("#add-document-check").on('click',function(){ 
	$("#file1-error").html('');
	$("#file2-error").html('');
	$("#file3-error").html('');

 var aadhar=0,
pan=0,
passport=0,
voter =0,
ssn = 0;
var aadhar_number = $("#aadhar_number").val();
var pan_number = $("#pan_number").val();
var passport_number = $("#passport_number").val();
var voter_id = $("#voter_id").val();
var ssn_number = $("#ssn_number").val();
var document_check_count = $("#document_check_count").val();
	var formdata = new FormData();
	formdata.append('url',3);
	formdata.append('count',document_check_count);
	/*formdata.append('address',address);
	formdata.append('pincode',pincode);
	formdata.append('city',city);
	formdata.append('state',state);*/
	var document_check_id = $("#document_check_id").val();
	if (document_check_id !='' && document_check_id !=null) {
			formdata.append('document_check_id',document_check_id);
		}

		if (candidate_aadhar.length > 0) {
			for (var i = 0; i < candidate_aadhar.length; i++) { 
				formdata.append('candidate_proof[]',candidate_aadhar[i]);
			}
		}else{
			formdata.append('candidate_proof[]','');
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
				formdata.append('candidate_aadhar[]',candidate_proof[i]);
			}
		}else{
			formdata.append('candidate_aadhar[]','');
		} 


		if (candidate_voter.length > 0) {
			for (var i = 0; i < candidate_voter.length; i++) { 
				formdata.append('candidate_voter[]',candidate_voter[i]);
			}
		}else{
			formdata.append('candidate_voter[]','');
		}

		if (candidate_ssn.length > 0) {
			for (var i = 0; i < candidate_ssn.length; i++) { 
				formdata.append('candidate_ssn[]',candidate_ssn[i]);
			}
		}else{
			formdata.append('candidate_ssn[]','');
		}

		formdata.append('aadhar_number',aadhar_number);
		formdata.append('pan_number',pan_number);
		formdata.append('passport_number',passport_number);
		formdata.append('voter_id',voter_id);
		formdata.append('ssn_number',ssn_number); 
		formdata.append('link_request_from',link_request_from);
		var passport_doc = $("#passport_doc").val();
		var pan_card_doc = $("#pan_card_doc").val();
		var adhar_doc = $("#adhar_doc").val();
		var voter_doc = $("#voter_doc").val();
		var ssn_doc = $('#ssn_doc').val();
		var in_array = $('#in_array').val();
		in_array = in_array.split(',');

	if (jQuery.inArray('2', in_array) != '-1') {	 
if ( aadhar_number =='' || aadhar_number ==null || (candidate_proof.length == 0 && (adhar_doc ==null || adhar_doc =='') )) {
	aadhar=1; 
	 
} 
}
if (jQuery.inArray('5', in_array) != '-1') {
if (ssn_number =='' || ssn_number ==null || (candidate_ssn.length == 0 && (ssn_doc ==null || ssn_doc =='' || ssn_doc =='[]') )) {
	ssn=1;
	 
} 
}
if (jQuery.inArray('4', in_array) != '-1') {
if (voter_id =='' || voter_id ==null || (candidate_voter.length == 0 && (voter_doc ==null || voter_doc =='' || voter_doc =='[]') )) {
	voter=1;
	 
} 
}
if (jQuery.inArray('1', in_array) != '-1') {

if (pan_number =='' || pan_number ==null || (candidate_pan.length == 0 && (pan_card_doc ==null || pan_card_doc =='' || pan_card_doc =='[]') )) {
	pan=1;
	 
} 
}
if (jQuery.inArray('3', in_array) != '-1') {
	 
if (passport_number =='' || passport_number ==null || (candidate_aadhar.length == 0 && (passport_doc ==null || passport_doc =='' || passport_doc =='[]') )) {
	 
	passport=1;
	 
} 

}



 
		if (aadhar != 1 && pan != 1 && passport != 1 && voter != 1 && ssn != 1) {

			$("#add-document-check").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
			$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
			$.ajax({
	            type: "POST",
	              url: base_url+"candidate/update_candidate_document_check",
	              data:formdata,
	              dataType: 'json',
	              contentType: false,
	              processData: false,
	              success: function(data) {
					if (data.status == '1') {
						// toastr.success('successfully saved data.');
						window.location.href=base_url+data.url;
						// if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
						// } else {
						// 	window.location.href=base_url+'m-component-list';
						// }
	              	}else{
	              		toastr.error('Something went wrong while save this data. Please try again.'); 	
	              	}
	              	$("#warning-msg").html("");
	              	$("#add-document-check").html('Save & Continue');
	              }
            });
		} else {
			if (aadhar_number !=null) {
				valid_aadhar_no();
			}

			if (pan_number !=null) {
				valid_pan_no();
			}

			if (passport_number !=null) {
				valid_passport_no();
			}

			if(voter_id != null) {
				valid_voter_id();
			}

			if(ssn_number != null) {
				valid_ssn_no();
			}

			if (candidate_proof.length == 0 &&  adhar_doc=='') { 
				$("#file3-error").html('<span class="text-danger error-msg-small">Please select a min '+1+' file</span>');
			}
			if (candidate_pan.length == 0 && pan_card_doc =='') { 
				$("#file2-error").html('<span class="text-danger error-msg-small">Please select a min '+1+' file</span>');
			}
			if (candidate_aadhar.length == 0 && passport_doc =='') { 
				$("#file1-error").html('<span class="text-danger error-msg-small">Please select a min '+1+' file</span>');
			}

			if (candidate_voter.length == 0 && voter_doc == '') {
				$('#file4-error').html('<span class="text-danger error-msg-small">Please select a min '+1+' file</span>');
			}

			if (candidate_ssn.length == 0 && ssn_doc == '') {
				$('#file5-error').html('<span class="text-danger error-msg-small">Please select a min '+1+' file</span>');
			}
		}
});


function removeFile_documents(id,param){
	// alert($("#remove_file_"+param+"_documents"+id).data('path'))
	$("#myModal-remove").modal('show');
	$("#remove-caption").html("<h4 class='text-danger'>Are you sure removing this "+param+" image?</h4>")
	$("#button-area").html('<a href="" data-dismiss="modal" class="exit-btn float-center text-center mr-1">Close</a><button class="btn btn-sm btn-danger text-white" onclick="image_remove('+id+',\''+param+'\')">remove</button>')

}


function image_remove(id,param){ 
var	table = 'document_check';
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
				toastr.success('Image removed successfully.');  
				$("#"+param+id).remove(); 
          	}else{
          		toastr.error('Something went wrong while removing this image. Please try again.'); 	
          	} 
          	$("#myModal-remove").modal('hide');
          }
    });
}

function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}

$('#aadhar_number').on('keyup blur', function() {
	valid_aadhar_no();
});

$('#pan_number').on('keyup blur', function() {
	valid_pan_no();
});

$('#passport_number').on('keyup blur', function() {
	valid_passport_no();
});

$('#voter_id').on('keyup blur', function() {
	valid_voter_id();
});

$('#ssn_number').on('keyup blur', function() {
	valid_ssn_no();
});

function valid_aadhar_no(){
	var aadhar = $("#aadhar_number").val();
	if (aadhar !='') {
		if (isNaN(aadhar)) {
			$("#aadhar_number-error").html('<span class="text-danger error-msg-small">Aadhar number should be only numbers.</span>');
			$("#aadhar_number").val(aadhar.slice(0,-1));
			input_is_invalid("#aadhar_number");
		} else if (aadhar.length != 12) {
			$("#aadhar_number-error").html('<span class="text-danger error-msg-small">Aadhar number should be of '+12+' digits.</span>');
			var plenght = $("#aadhar_number").val(aadhar.slice(0,12));
			input_is_invalid("#aadhar_number");
			if (plenght.length == 12) {
			$("#aadhar_number-error").html('');
			input_is_valid("#aadhar_number");	
			}
		} else {
			$("#aadhar_number-error").html('');
			input_is_valid("#aadhar_number");
		} 
	}else{
		$("#aadhar_number-error").html("<span class='text-danger error-msg-small'>Please enter valid aadhar number</span>");
		input_is_invalid("#aadhar_number")
	}
}

function valid_pan_no(){
	var pan = $("#pan_number").val();
	if (pan !='') {
		if (pan.length != 10) {
			$("#pan_number-error").html('<span class="text-danger error-msg-small">Pan number should be of '+10+' digits.</span>');
			var plenght = $("#pan_number").val(pan.slice(0,10));
			input_is_invalid("#pan_number");
			if (plenght.length == 10) {
			$("#pan_number-error").html('');
			input_is_valid("#pan_number");	
			}
		} else {
			$("#pan_number-error").html('');
			input_is_valid("#pan_number");
		} 
	}else{
		$("#pan_number-error").html("<span class='text-danger error-msg-small'>Please enter valid pan number</span>");
		input_is_invalid("#pan_number")
	}
}

function valid_passport_no(){
	var passport = $("#passport_number").val();
	if (passport !='') {
		if (passport.length > 9) {
			$("#passport_number-error").html('<span class="text-danger error-msg-small">Passport number should be of '+9+' digits.</span>');
			var plenght = $("#passport_number").val(passport.slice(0,9));
			input_is_invalid("#passport_number");
			if (plenght.length == 9) {
			$("#passport_number-error").html('');
			input_is_valid("#passport_number");	
			}
		} else {
			$("#passport_number-error").html('');
			input_is_valid("#passport_number");
		} 
	}else{
		$("#passport_number-error").html("<span class='text-danger error-msg-small'>Please enter valid passport number</span>");
		input_is_invalid("#passport_number")
	}
}

function valid_voter_id() {
	var voter_id = $("#voter_id").val();
	if (voter_id !='') {
		if (voter_id.length > 10) {
			$("#voter_id-error").html('<span class="text-danger error-msg-small">Voter ID should be of '+10+' digits.</span>');
			var plenght = $("#voter_id").val(voter_id.slice(0,10));
				input_is_invalid("#voter_id");
			if (plenght.length == 10) {
				$("#voter_id-error").html('');
				input_is_valid("#voter_id");	
			}
		} else {
			$("#voter_id-error").html('');
			input_is_valid("#voter_id");
		} 
	}else{
		$("#voter_id-error").html("<span class='text-danger error-msg-small'>Please enter valid Voter ID</span>");
		input_is_invalid("#voter_id")
	}
}

function valid_ssn_no() {
	var pan = $("#ssn_number").val();
	if (pan !='') {
		if (pan.length != 9) {
			$("#ssn_number-error").html('<span class="text-danger error-msg-small">SSN number should be of '+9+' digits.</span>');
				var plenght = $("#ssn_number").val(pan.slice(0,9));
				input_is_invalid("#ssn_number");
			if (plenght.length == 9) {
				$("#ssn_number-error").html('');
				input_is_valid("#ssn_number");	
			}
		} else {
			$("#ssn_number-error").html('');
			input_is_valid("#ssn_number");
		} 
	}else{
		$("#ssn_number-error").html("<span class='text-danger error-msg-small'>Please enter valid SSN number</span>");
		input_is_invalid("#ssn_number")
	}
}