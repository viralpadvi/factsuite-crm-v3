var client_zip_lenght = 6,
	client_document_size = 20000000,
	max_client_document_select = 20,
	candidate_aadhar = [],
	candidate_pan = [],
	candidate_proof = [],
	candidate_bank = [];

$(".all_sem_marksheet").on("change", handleFileSelect_candidate_aadhar);
$(".convocation").on("change", handleFileSelect_candidate_pan);
$(".marksheet_provisional_certificate").on("change", handleFileSelect_candidate_proof);
$(".ten_twelve_mark_card_certificate").on("change", handleFileSelect_candidate_bank);

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
    	$("#all_sem_marksheet-img"+number).html('');
        $("#all_sem_marksheet-error"+number).html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
        	var obj = [];
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_aadhar_'+number+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+number+i+'" onclick="removeFile_candidate_aadhar('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+number+','+i+',\'candidate_aadhar'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
	                obj.push(files[i]);
	                $("#all_sem_marksheet-error"+number).append(html);
	        	}

	        }
	        candidate_aadhar.push({[number]:obj}); 
	    } else {
	    	$("#all_sem_marksheet-img"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#all_sem_marksheet'+number).val('');
	    }
    } else {
        $("#all_sem_marksheet-img"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
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
    	$("#all_sem_marksheet"+num).val('');
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
	           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
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
    	$("#convocation-img"+number).html('');
        $("#convocation-error"+number).html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
        	var obj = [];
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            // alert(number)
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_pan_'+number+i+'"><span>'+fileName+' <a id="file_candidate_pan'+number+i+'" onclick="removeFile_candidate_pan('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_pan_image('+number+','+i+',\'candidate_pan'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                obj.push(files[i]);
	                $("#convocation-error"+number).append(html);
	        	}

	        }
	        candidate_pan.push({[number]:obj}); 
	    } else {
	    	$("#convocation-img"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#convocation'+number).val('');
	    }
    } else {
        $("#convocation-img"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
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
    	$("#convocation"+num).val('');
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
	           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
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
    	$("#marksheet_provisional_certificate-img"+number).html('');
        $("#marksheet_provisional_certificate-error"+number).html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
        	var obj = [];
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            // alert(number)
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_proof_'+number+i+'"><span>'+fileName+' <a id="file_candidate_proof'+number+i+'" onclick="removeFile_candidate_proof('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_proof_image('+number+','+i+',\'candidate_proof'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                obj.push(files[i]);
	                $("#marksheet_provisional_certificate-error"+number).append(html);
	        	}

	        }
	        candidate_proof.push({[number]:obj}); 
	    } else {
	    	$("#marksheet_provisional_certificate-img"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#marksheet_provisional_certificate'+number).val('');
	    }
    } else {
        $("#marksheet_provisional_certificate-img"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
} 

function removeFile_candidate_proof(num,id) {
	var tmp_array = [];
    var file = $('#file_candidate_proof'+num+id).data("file");
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
    	$("#marksheet_provisional_certificate"+num).val('');
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

function handleFileSelect_candidate_bank(e) { 
	var file_id = $(this).attr('id');
	var number = file_id.match(/\d+/);
    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1;  
	if (files.length <= max_client_document_select) {
    	$("#ten_twelve_mark_card_certificate-error"+number).html('');
        $("#ten_twelve_mark_card_certificate-error"+number).html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
        	var obj = [];
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            // alert(number)
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_candidate_bank_'+number+i+'"><span>'+fileName+' <a id="file_candidate_bank'+number+i+'" onclick="removeFile_candidate_bank('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_bank_image('+number+','+i+',\'candidate_bank'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                obj.push(files[i]);
	                $("#ten_twelve_mark_card_certificate-error"+number).append(html);
	        	}

	        }
	        candidate_bank.push({[number]:obj}); 
	    } else {
	    	$("#ten_twelve_mark_card_certificate-error"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#ten_twelve_mark_card_certificate'+number).val('');
	    }
    } else {
        $("#ten_twelve_mark_card_certificate-error"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
} 

function removeFile_candidate_bank(num,id) {
	var tmp_array = [];
    var file = $('#file_candidate_bank'+num+id).data("file");
    for(var i = 0; i < candidate_bank.length; i++) {
    	if (typeof candidate_bank[i][num] !='undefined') {
    		var count = candidate_bank[i][num].length;
    		var obj = [];
			for (var b = 0; b < count; b++) { 
				if (candidate_bank[i][num][b].name !== file) { 
					obj.push(candidate_bank[i][num][b])
				} 
			} 
			tmp_array.push({[num]:obj})
	 	} else {
			tmp_array.push(candidate_bank[i])
		}
    }

    candidate_bank = tmp_array; 

    if (candidate_bank.length == 0) {
    	$("#ten_twelve_mark_card_certificate"+num).val('');
    }
    $('#file_candidate_bank_'+num+id).remove(); 
}

function view_bank_image(num,id,text) { 
	$("#myModal-show").modal('show');
	var file = $('#file_'+text+id).data("file");  
	for (var i = 0; i < candidate_bank.length; i++) {
	 	if (typeof candidate_bank[i][num] !='undefined') {
	 	 	var reader = new FileReader();
	        reader.onload = function(event) {
	           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
	        };
	        reader.readAsDataURL(candidate_bank[i][num][id]);
	 	}
	}    
}

function exist_view_image(image,path) {
	$("#myModal-show").modal('show'); 
   	$("#view-img").html("<img class='w-100' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
}

function save_details() {
	var marksheet = [],
		convocation = [],
		certificate = [],
		ten_twelve = [],
		all_sem_marksheet_avail_count = 0,
		all_sem_marksheet_unuploaded_count = 0,
		convocation_avail_count = 0,
		convocation_unuploaded_count = 0,
		ten_twelve_mark_card_certificate_avail_count = 0,
		ten_twelve_mark_card_certificate_unuploaded_count = 0;

	$(".all_sem_marksheet").each(function() {
		all_sem_marksheet_avail_count++;
		if ($(this).val() != '' && $(this).val() != null) {
			marksheet.push(1);
		} else {
			all_sem_marksheet_unuploaded_count++;
			marksheet.push(0);
		}
	});

	$(".convocation").each(function() {
		convocation_avail_count++;
		if ($(this).val() != '' && $(this).val() != null) {
			convocation.push(1);
		} else {
			convocation_unuploaded_count++;
			convocation.push(0);
		}
	});

	$(".ten_twelve_mark_card_certificate").each(function() {
		ten_twelve_mark_card_certificate_avail_count++;
		if ($(this).val() != '' && $(this).val() != null) {
			ten_twelve.push(1);
		} else {
			ten_twelve_mark_card_certificate_unuploaded_count++;
			ten_twelve.push(0);
		}
	});

	$(".marksheet_provisional_certificate").each(function() {
		if ($(this).val() != '' && $(this).val() != null) {
			certificate.push(1);
		} else {
			certificate.push(0);
		}
	});

	if ((all_sem_marksheet_avail_count > 0 && all_sem_marksheet_unuploaded_count == 0) && (convocation_avail_count > 0 && convocation_unuploaded_count == 0)
		&& (ten_twelve_mark_card_certificate_avail_count > 0 && ten_twelve_mark_card_certificate_unuploaded_count == 0)) {
		
		var formdata = new FormData();

		if (candidate_aadhar.length > 0) {
			var a = 0;
			var count = 1;
			$.each(candidate_aadhar,function(index,value) {
				$.each(value,function(index,val) {
					if (candidate_aadhar[a][index].length > 0) {
						for (var c = 0; c < candidate_aadhar[a][index].length; c++) {
							formdata.append('all_sem_marksheet'+a+'[]',candidate_aadhar[a][index][c]); 
							count++;
						} 	
					}
				});
				a++;
			});
		}

		if (candidate_pan.length > 0) {
			var a = 0;
			$.each(candidate_pan,function(index,value) {
				$.each(value,function(index,val) {
					if (candidate_pan[a][index].length > 0) {
						for (var c = 0; c < candidate_pan[a][index].length; c++) {
							formdata.append('convocation'+a+'[]',candidate_pan[a][index][c]);
						} 	
					}
				});
				a++;
			});
		}

		if (candidate_proof.length > 0) {
			var a = 0;
			$.each(candidate_proof,function(index,value) {
				$.each(value,function(index,val) {
					if (candidate_proof[a][index].length > 0) {
						for (var c = 0; c < candidate_proof[a][index].length; c++) {
							formdata.append('marksheet_provisional_certificate'+a+'[]',candidate_proof[a][index][c]); 
						} 	
					}
				});
				a++;
			});
		}

		if (candidate_bank.length > 0) {
			var a = 0;
			$.each(candidate_bank,function(index,value) {
				$.each(value,function(index,val) {
					if (candidate_bank[a][index].length > 0) {
						for (var c = 0; c < candidate_bank[a][index].length; c++) {
							formdata.append('ten_twelve_mark_card_certificate'+a+'[]',candidate_bank[a][index][c]);
						} 	
					}
				});
				a++;
			});
		}

		formdata.append('verify_candidate_request',1);
		formdata.append('count',candidate_aadhar.length);
		formdata.append('pan_count',candidate_pan.length);
		formdata.append('proof_count',candidate_proof.length);
		formdata.append('bank_count',candidate_bank.length);

		formdata.append('marksheet',marksheet);
		formdata.append('convocation',convocation);
		formdata.append('certificate',certificate);
		formdata.append('ten_twelve',ten_twelve);

		$.ajax({
	    	type: "POST",
	      	url: base_url+"m-factsuite-candidate/update-education-2-details",
	      	data:formdata,
	      	dataType: 'json',
	      	contentType: false,
	      	processData: false,
	      	success: function(data) {
	      		$("#save-data-error-msg").html('');
	            $("#save-details-btn").html("Save & Continue");
				if (data.status == '1') {
					window.location.href = base_url+'m-component-list';
	      		} else {
	      			toastr.error('Something went wrong while saving the data. Please try again.'); 	
	      		}
	      	},
	        error: function(data) {
	        	$("#save-data-error-msg").html('');
	          	$("#save-details-btn").html("Save & Continue");
	        	toastr.error('Something went wrong while save this data. Please try again.');
	        }
	    });
	} else {
		$(".ten_twelve_mark_card_certificate").each(function() {
			if ($(this).val() == '' || $(this).val() == null) {
				var id = $(this).attr('id').match(/\d+/);
				$('#ten_twelve_mark_card_certificate-error'+id).html('<span class="text-danger error-msg-small">Please select atlease one file.</span>');
			}
		});

		$(".all_sem_marksheet").each(function() {
			if ($(this).val() == '' || $(this).val() == null) {
				var id = $(this).attr('id').match(/\d+/);
				$('#all_sem_marksheet-error'+id).html('<span class="text-danger error-msg-small">Please select atlease one file.</span>');
			}
		});

		$(".convocation").each(function() {
			if ($(this).val() == '' || $(this).val() == null) {
				var id = $(this).attr('id').match(/\d+/);
				$('#convocation-error'+id).html('<span class="text-danger error-msg-small">Please select atlease one file.</span>');
			}
		});
	}
}