var client_zip_lenght = 6,
	client_document_size = 20000000,
	max_client_document_select = 20,
	candidate_cv = [];

$("#file1").on("change", handleFileSelect_candidate_cv);

$('#save-details-btn').on('click', function() {
	save_details();
});

function handleFileSelect_candidate_cv(e) { 
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
	            	 html = '<div id="file_candidate_cv_'+i+'"><span>'+fileName+' <a id="file_candidate_cv'+i+'" onclick="removeFile_candidate_cv('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_cv\')" ><i class="fa fa-eye"></i></a></span></div>'; 
	                candidate_cv.push(files[i]);
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

function removeFile_candidate_cv(id) {
    var file = $('#file_candidate_cv'+id).data("file");
    for(var i = 0; i < candidate_cv.length; i++) {
        if(candidate_cv[i].name === file) {
            candidate_cv.splice(i,1); 
        }
    }
    if (candidate_cv.length == 0) {
    	$("#file1").val('');
    }
    $('#file_candidate_cv_'+id).remove(); 
}

function view_image(id,text) {
	$("#myModal-show").modal('show');
	var file = $('#file_'+text+id).data("file");  
	var reader = new FileReader();
    reader.onload = function(event) {
        $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
    };
    reader.readAsDataURL(candidate_cv[id]);
}

function exist_view_image(image,path) {
    $("#myModal-show").modal('show');
   	$("#view-img").html("<img class='w-100' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
}

function save_details() {
	if (candidate_cv.length > 0 || $('#uploaded-cv-docs').val() != '') {
		var formdata = new FormData();
	    formdata.append('url',20);
	    if (candidate_cv.length > 0) {
	        for (var i = 0; i < candidate_cv.length; i++) { 
	            formdata.append('cv_docs[]',candidate_cv[i]);
	        }
	    } else {
	        formdata.append('cv_docs[]','');
	    }
	    formdata.append('verify_candidate_request',1);

	    $("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	    $.ajax({
	        type: "POST",
	        url: base_url+"m-factsuite-candidate/update-cv-check",
	        data:formdata,
	        dataType: 'json',
	        contentType: false,
	        processData: false,
	        success: function(data) {
				if (data.status == '1') {
					window.location.href = base_url+'m-component-list';
	          	} else {
	          		toastr.error('Something went wrong while saving the data. Please try again.');
	          	}
	          	$("#save-details-btn").html("Save & Continue");
	        },
	        error: function(data) {
	        	toastr.error('Something went wrong while saving the data. Please try again.');
	        	$("#save-details-btn").html("Save & Continue");;	
	        }
	    });
	} else {
		$('#save-data-error-msg').html("<span class='text-danger error-msg-small'>Please select atlease a file.</span>")
	}
}