var candidate_aadhar = [],
	candidate_pan = [],
	candidate_proof = [],
	candidate_bank = [],
	client_document_size = 20000000,
	max_client_document_select = 20;

$("#file1").on("change", handleFileSelect_candidate_aadhar);
$("#file2").on("change", handleFileSelect_candidate_pan);
$("#file3").on("change", handleFileSelect_candidate_proof);
$("#file4").on("change", handleFileSelect_candidate_bank);

$('#save-details-btn').on('click', function() {
	save_details();	
});

function handleFileSelect_candidate_aadhar(e) { 
	var files = e.target.files,
    	filesArr = Array.prototype.slice.call(files),
    	j = 1; 

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
        $("#file1-error").html('');
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

function handleFileSelect_candidate_pan(e) {
	var files = e.target.files,
    	filesArr = Array.prototype.slice.call(files),
    	j = 1; 
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
        $("#file2-error").html('');
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

function handleFileSelect_candidate_proof(e) {
	var files = e.target.files,
    	filesArr = Array.prototype.slice.call(files),
    	j = 1; 
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
        $("#file3-error").html('');
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

function handleFileSelect_candidate_bank(e) {
	var files = e.target.files,
    	filesArr = Array.prototype.slice.call(files),
    	j = 1; 
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

function view_image(id,text) {
	$("#myModal-show").modal('show');
	var file = $('#file_'+text+id).data("file");  
	var reader = new FileReader();
    reader.onload = function(event) {
        $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
    };
    reader.readAsDataURL(candidate_aadhar[id]);
}

function view_image_pan(id,text) {
	$("#myModal-show").modal('show');
	var file = $('#file_'+text+id).data("file");  
	var reader = new FileReader();
    reader.onload = function(event) {
        $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
    };
    reader.readAsDataURL(candidate_pan[id]);
}

function view_image_proof(id,text) {
	$("#myModal-show").modal('show');
	var file = $('#file_'+text+id).data("file");  
	var reader = new FileReader(); 
    reader.onload = function(event) {
        $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
    };
    reader.readAsDataURL(candidate_proof[id]);
}

function view_image_bank(id,text) {
	$("#myModal-show").modal('show');
	var file = $('#file_'+text+id).data("file");  
	var reader = new FileReader();
    reader.onload = function(event) {
        $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
    };
    reader.readAsDataURL(candidate_bank[id]);
} 

function exist_view_image(image,path) {
	$("#myModal-show").modal('show');
   	$("#view-img").html("<img class='w-100' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");   
}

function save_details() {
	var formdata = new FormData();
	formdata.append('verify_candidate_request',1);
	if (candidate_aadhar.length > 0) {
		for (var i = 0; i < candidate_aadhar.length; i++) { 
			formdata.append('candidate_aadhar[]',candidate_aadhar[i]);
		}
	} else {
		formdata.append('candidate_aadhar[]','');
	}

	if (candidate_pan.length > 0) {
		for (var i = 0; i < candidate_pan.length; i++) { 
			formdata.append('candidate_pan[]',candidate_pan[i]);
		}
	} else {
		formdata.append('candidate_pan[]','');
	}

	if (candidate_proof.length > 0) {
		for (var i = 0; i < candidate_proof.length; i++) { 
			formdata.append('candidate_proof[]',candidate_proof[i]);
		}
	} else {
		formdata.append('candidate_proof[]','');
	}

	if (candidate_bank.length > 0) {
		for (var i = 0; i < candidate_bank.length; i++) { 
			formdata.append('candidate_bank[]',candidate_bank[i]);
		}
	} else {
		formdata.append('candidate_bank[]','');
	}

	$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
	$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$.ajax({
        type: "POST",
        url: base_url+"m-factsuite-candidate/update-current-employment-2-details",
        data: formdata,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(data) {
          	$("#save-data-error-msg").html('');
			if (data.status == '1') {
				if(data.candidate_details.status == 1) {
					window.location.href = base_url+'m-component-list';
				} else {
					toastr.error('Something went wrong while saving the data. Please try again.'); 		
				}
          	} else {
          		toastr.error('Something went wrong while saving the data. Please try again.');
          	}
          	$("#save-details-btn").html('Save &amp; Continue');
        },
        error: function(data) {
        	toastr.error('Something went wrong while saving the data. Please try again.');
     		$("#save-data-error-msg").html('');
     		$("#save-details-btn").html('Save &amp; Continue');
  		}
    });
}