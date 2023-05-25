var client_zip_lenght = 6,
	client_document_size = 20000000,
	max_client_document_select = 20,
	candidate_aadhar = [],
	candidate_pan = [],
	candidate_proof = [],
	candidate_bank = [];

$(".rental_agreement").on("change", handleFileSelect_candidate_aadhar);
$(".ration_card").on("change", handleFileSelect_candidate_pan);
$(".gov_utility_bill").on("change", handleFileSelect_candidate_proof);

$('#save-details-btn').on('click', function() {
	save_details();
});

function handleFileSelect_candidate_aadhar(e) {
	var file_id = $(this).attr('id');
	var number = file_id.match(/\d+/);
	var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1;  
	if (files.length <= max_client_document_select) {
	    $("#rental_agreement-img"+number).html('');
	    $("#rental_agreement-error"+number).html('');
	    if (files[0].size <= client_document_size) {
	       	var html ='';
	        var obj = [];
		    for (var i = 0; i < files.length; i++) {
		        var fileName = files[i].name; // get file name 
		        if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
		           	html = '<div id="file_candidate_aadhar_'+number+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+number+i+'" onclick="removeFile_candidate_aadhar('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+number+','+i+',\'candidate_aadhar'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
		            obj.push(files[i]);
		            $("#rental_agreement-error"+number).append(html);
		       	}
		    }
		    candidate_aadhar.push({[number]:obj}); 
		} else {
		    $("#rental_agreement-img"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#rental_agreement'+number).val('');
		}
	} else {
	    $("#rental_agreement-img"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
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
		} else {
			tmp_array.push(candidate_aadhar[i])
		}
    }

    candidate_aadhar = tmp_array; 

    if (candidate_aadhar.length == 0) {
    	$("#rental_agreement"+num).val('');
    }
    $('#file_candidate_aadhar_'+num+id).remove(); 
}

function view_image(num,id,text) { 
	$("#myModal-show").modal('show');
	var file = $('#file_'+text+id).data("file");  
	for (var i = 0; i < candidate_aadhar.length; i++) {
	 	if (typeof candidate_aadhar[i][num] !='undefined') {
	 	 	var reader = new FileReader();
	        reader.onload = function(event) {
	           $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
	        };
	        reader.readAsDataURL(candidate_aadhar[i][num][id]);
	 	}
	}    
}

function handleFileSelect_candidate_pan(e) {
	var file_id = $(this).attr('id');
	var number = file_id.match(/\d+/);
	var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1;  
	if (files.length <= max_client_document_select) {
	    $("#ration_card-img"+number).html('');
	    $("#ration_card-error"+number).html('');
	    if (files[0].size <= client_document_size) {
	       	var html ='';
	        var obj = [];
		    for (var i = 0; i < files.length; i++) {
		        var fileName = files[i].name; // get file name
		        if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
		           	html = '<div id="file_candidate_pan_'+number+i+'"><span>'+fileName+' <a id="file_candidate_pan'+number+i+'" onclick="removeFile_candidate_pan('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_pan_image('+number+','+i+',\'candidate_pan'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
		            obj.push(files[i]);
		            $("#ration_card-error"+number).append(html);
		        }
		    }
		    candidate_pan.push({[number]:obj}); 
		} else {
		   	$("#ration_card-img"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#ration_card'+number).val('');
		}
	} else {
	    $("#ration_card-img"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
	}
} 

function removeFile_candidate_pan(num,id) {
	var tmp_array = [];
    var file = $('#file_candidate_pan'+num+id).data("file");
    for(var i = 0; i < candidate_pan.length; i++) {
    	if (typeof candidate_pan[i][num] !='undefined') {
    		var count = candidate_pan[i][num].length;
    		var obj = [];
			for (var b = 0; b < count; b++) { 
				if (candidate_pan[i][num][b].name !== file) { 
					obj.push(candidate_pan[i][num][b])
				}
			}
			tmp_array.push({[num]:obj})
		} else {
			tmp_array.push(candidate_pan[i])
		}
    }

    candidate_pan = tmp_array; 

    if (candidate_pan.length == 0) {
    	$("#ration_card"+num).val('');
    }
    $('#file_candidate_pan_'+num+id).remove(); 
}

function view_pan_image(num,id,text) { 
	$("#myModal-show").modal('show');
	var file = $('#file_'+text+id).data("file");  
	for (var i = 0; i < candidate_pan.length; i++) {
	 	if (typeof candidate_pan[i][num] !='undefined') {
	 	 	var reader = new FileReader();
	        reader.onload = function(event) {
	           $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
	        };
	        reader.readAsDataURL(candidate_pan[i][num][id]);
	 	}
	}    
}

function handleFileSelect_candidate_proof(e) {
	var file_id = $(this).attr('id');
	var number = file_id.match(/\d+/);
	var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1;  
	if (files.length <= max_client_document_select) {
	    $("#gov_utility_bill-img"+number).html('');
	    $("#gov_utility_bill-error"+number).html('');
	    if (files[0].size <= client_document_size) {
	       	var html ='';
	       	var obj = [];
		    for (var i = 0; i < files.length; i++) {
		        var fileName = files[i].name; // get file name
	            if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	html = '<div id="file_candidate_proof_'+number+i+'"><span>'+fileName+' <a id="file_candidate_proof'+number+i+'" onclick="removeFile_candidate_proof('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_proof_image('+number+','+i+',\'candidate_proof'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
	                obj.push(files[i]);
	                $("#gov_utility_bill-error"+number).append(html);
	        	}
	        }
	        candidate_proof.push({[number]:obj});
		} else {
		    $("#gov_utility_bill-img"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#gov_utility_bill'+number).val('');
		}
	} else {
	    $("#gov_utility_bill-img"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
	}
} 

function removeFile_candidate_proof(num,id) {
	var tmp_array = [],
    	file = $('#file_candidate_proof'+num+id).data("file");
    for(var i = 0; i < candidate_proof.length; i++) {
    	if (typeof candidate_proof[i][num] !='undefined') {
    		var count = candidate_proof[i][num].length;
    		var obj = [];
			for (var b = 0; b < count; b++) { 
				if (candidate_proof[i][num][b].name !== file) { 
					obj.push(candidate_proof[i][num][b])
				} 
			} 
			tmp_array.push({[num]:obj})
		} else {
			tmp_array.push(candidate_proof[i])
		}
    }

    candidate_proof = tmp_array; 

    if (candidate_proof.length == 0) {
    	$("#gov_utility_bill"+num).val('');
    }
    $('#file_candidate_proof_'+num+id).remove(); 
}

function view_proof_image(num,id,text) { 
	$("#myModal-show").modal('show');
	var file = $('#file_'+text+id).data("file");  
	for (var i = 0; i < candidate_proof.length; i++) {
	 	if (typeof candidate_proof[i][num] !='undefined') {
	 	 	var reader = new FileReader();
	        reader.onload = function(event) {
	           $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
	        };
	        reader.readAsDataURL(candidate_proof[i][num][id]);
	 	}
	}    
}

function exist_view_image(image,path) {
	$("#myModal-show").modal('show'); 
   	$("#view-img").html("<img class='w-100' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
}

function save_details() {
	var rental_agreement = [],
		ration_card = [],
		gov_utility_bill = []; 
		
	$(".rental_agreement").each(function() {
		if ($(this).val() !='') {
			rental_agreement.push(1);
		} else {
			rental_agreement.push(0);
		}
	});
		
	$(".ration_card").each(function() {
		if ($(this).val() !='') {
			ration_card.push(1);
		} else {
			ration_card.push(0);
		}
	});
		
	$(".gov_utility_bill").each(function() {
		if ($(this).val() !='') {
			gov_utility_bill.push(1);
		} else {
			gov_utility_bill.push(0);
		}
	});

	var formdata = new FormData();
		formdata.append('verify_candidate_request',1);
		formdata.append('rental_agreement',rental_agreement);
		formdata.append('ration_card',ration_card);
		formdata.append('gov_utility_bill',gov_utility_bill);

	if (candidate_aadhar.length > 0) {
		var a = 0;
		$.each(candidate_aadhar,function(index,value) {
			$.each(value,function(index,val) {
				if (candidate_aadhar[a][index].length > 0) {
					for (var c = 0; c < candidate_aadhar[a][index].length; c++) {
						formdata.append('candidate_rental'+a+'[]',candidate_aadhar[a][index][c]);
					} 	
				} else {
					formdata.append('candidate_rental[]','');
				}
			});
			a++;
		});
	} else {
		formdata.append('candidate_rental[]','');
	}

	if (candidate_pan.length > 0) {
		var a = 0;
		$.each(candidate_pan,function(index,value) {
			$.each(value,function(index,val) {
				if (candidate_pan[a][index].length > 0) {
					for (var c = 0; c < candidate_pan[a][index].length; c++) {
						formdata.append('candidate_ration'+a+'[]',candidate_pan[a][index][c]); 
					}
				} else {
					formdata.append('candidate_ration[]','');
				}
			});
			a++;
		});
	} else {
		formdata.append('candidate_ration[]','');
	}

	if (candidate_proof.length > 0) {
		var a = 0;
		$.each(candidate_proof,function(index,value) {
			$.each(value,function(index,val) {
				if (candidate_proof[a][index].length > 0) {
					for (var c = 0; c < candidate_proof[a][index].length; c++) {
						formdata.append('candidate_gov'+a+'[]',candidate_proof[a][index][c]);
					} 	
				} else {
					formdata.append('candidate_gov[]','');
				}
			});
			a++;
		}); 
	} else {
		formdata.append('candidate_gov[]','');
	}

	formdata.append('candidate_rental_count',candidate_aadhar.length);
	formdata.append('candidate_ration_count',candidate_pan.length);
	formdata.append('candidate_gov_count',candidate_proof.length);

	$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
	$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$.ajax({
        type: "POST",
        url: base_url+"m-factsuite-candidate/update-previous-address-2-details",
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
            $("#save-data-error-msg").html('');
            $("#save-details-btn").html('Save & Continue');
        }
	});
}