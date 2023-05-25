var client_zip_lenght = 6,
	client_document_size = 20000000,
	max_client_document_select = 20,
	address = [];

$("#file1").on("change", handleFileSelect_address);

$('#save-details-btn').on('click', function() {
	save_details();
});

function handleFileSelect_address(e) {
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
	            	 html = '<div id="file_address_'+i+'"><span>'+fileName+' <a id="file_address'+i+'" onclick="removeFile_address('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'address\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                address.push(files[i]);
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

function removeFile_address(id) {
    var file = $('#file_address'+id).data("file");
    for(var i = 0; i < address.length; i++) {
        if(address[i].name === file) {
            address.splice(i,1); 
        }
    }
    if (address.length == 0) {
    	$("#file1").val('');
    }
    $('#file_address_'+id).remove(); 
}

function view_image(id,text) {
	$("#myModal-show").modal('show');
	var file = $('#file_'+text+id).data("file");  
	var reader = new FileReader();
    reader.onload = function(event) {
        $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
    };
    reader.readAsDataURL(address[id]);
}

function exist_view_image(image,path) {
    $("#myModal-show").modal('show');
   	$("#view-img").html("<img class='w-100' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");   
}

function save_details() {
	var formdata = new FormData();
	if (address.length > 0) {
        for (var i = 0; i < address.length; i++) { 
            formdata.append('addresss[]',address[i]);
        }
    } else {
        formdata.append('addresss[]','');
    }

    $("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
	$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	formdata.append('address_proof_count',address.length);
	formdata.append('verify_candidate_request',1);

	$.ajax({
        type: "POST",
        url: base_url+"m-factsuite-candidate/update-court-record-2-details",
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
        	toastr.error('Something went wrong while save the data. Please try again.');
        	$("#save-details-btn").html("Save & Continue");;	
        }
    });
}