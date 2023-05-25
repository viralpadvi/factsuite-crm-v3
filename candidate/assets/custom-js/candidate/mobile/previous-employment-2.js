var max_client_document_select = 20,
	client_zip_lenght = 6,
	client_document_size = 20000000,
	candidate_aadhar = [],
	candidate_pan = [],
	candidate_proof = [],
	candidate_bank = [];

$(".appointment_letter").on("change", handleFileSelect_candidate_aadhar);
$(".experience_relieving_letter").on("change", handleFileSelect_candidate_pan);
$(".last_month_pay_slip").on("change", handleFileSelect_candidate_proof);
$(".bank_statement_resigngation_acceptance").on("change", handleFileSelect_candidate_bank);

$('#save-details-btn').on('click', function() {
	save_details();	
});

function handleFileSelect_candidate_aadhar(e){
	var file_id = $(this).attr('id');
	var number = file_id.match(/\d+/);
	var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1;  
	if (files.length <= max_client_document_select) {
	    $("#appointment_letter-img"+number).html('');
	    $("#appointment_letter-error"+number).html('');
	    if (files[0].size <= client_document_size) {
	       	var html ='';
	       	var obj = [];
		    for (var i = 0; i < files.length; i++) {
		        var fileName = files[i].name; // get file name 
		        if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
		           	html = '<div id="file_candidate_aadhar_'+number+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+number+i+'" onclick="removeFile_candidate_aadhar('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+number+','+i+',\'candidate_aadhar'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
		           	obj.push(files[i]);
		            $("#appointment_letter-error"+number).append(html);
		        }
		    }
		    candidate_aadhar.push({[number]:obj}); 
		} else {
		   	$("#appointment_letter-img"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#appointment_letter'+number).val('');
		}
	} else {
	   	$('#appointment_letter'+number).val('');
	    $("#appointment_letter-img"+number).html('');
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
    	$("#appointment_letter"+num).val('');
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

function handleFileSelect_candidate_pan(e){
	var file_id = $(this).attr('id');
	var number = file_id.match(/\d+/);
	var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files);
    var j = 1;  
	if (files.length <= max_client_document_select) {
	    $("#experience_relieving_letter-img"+number).html('');
	    $("#experience_relieving_letter-error"+number).html('');
	    if (files[0].size <= client_document_size) {
	       	var html ='';
	       	var obj = [];
		    for (var i = 0; i < files.length; i++) {
		       	var fileName = files[i].name; // get file name 
		        if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
		           	html = '<div id="file_candidate_pan_'+number+i+'"><span>'+fileName+' <a id="file_candidate_pan'+number+i+'" onclick="removeFile_candidate_pan('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_pan_image('+number+','+i+',\'candidate_pan'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
		            obj.push(files[i]);
		            $("#experience_relieving_letter-error"+number).append(html);
		        }
		    }
		    candidate_pan.push({[number]:obj}); 
		} else {
		   	$("#experience_relieving_letter-img"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#experience_relieving_letter'+number).val('');
		}
	} else {
	    $("#experience_relieving_letter-img"+number).html('');
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
    	$("#experience_relieving_letter"+num).val('');
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
	   	$("#last_month_pay_slip-img"+number).html('');
	    $("#last_month_pay_slip-error"+number).html('');
	    if (files[0].size <= client_document_size) {
	        var html ='';
	       	var obj = [];
		    for (var i = 0; i < files.length; i++) {
		        var fileName = files[i].name; // get file name
		        if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
		           	html = '<div id="file_candidate_proof_'+number+i+'"><span>'+fileName+' <a id="file_candidate_proof'+number+i+'" onclick="removeFile_candidate_proof('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_proof_image('+number+','+i+',\'candidate_proof'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
		            obj.push(files[i]);
		            $("#last_month_pay_slip-error"+number).append(html);
		       	}
		    }
		    candidate_proof.push({[number]:obj}); 
		} else {
		   	$("#last_month_pay_slip-img"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#last_month_pay_slip'+number).val('');
		}
	} else {
	    $("#last_month_pay_slip-img"+number).html('');
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
    	$("#last_month_pay_slip"+num).val('');
    }
    $('#file_candidate_bank_'+num+id).remove(); 
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
	    $("#bank_statement_resigngation_acceptance-img"+number).html('');
	    $("#bank_statement_resigngation_acceptance-error"+number).html('');
	    if (files[0].size <= client_document_size) {
	       	var html ='';
	       	var obj = [];
		    for (var i = 0; i < files.length; i++) {
		        var fileName = files[i].name; // get file name
		        if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
		           	html = '<div id="file_candidate_bank_'+number+i+'"><span>'+fileName+' <a id="file_candidate_bank'+number+i+'" onclick="removeFile_candidate_bank('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_bank_image('+number+','+i+',\'candidate_bank'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
		            obj.push(files[i]);
		            $("#bank_statement_resigngation_acceptance-img"+number).append(html);
		       	}
		    }
		    candidate_bank.push({[number]:obj}); 
		} else {
		   	$("#bank_statement_resigngation_acceptance-img"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#bank_statement_resigngation_acceptance'+number).val('');
		}
	} else {
	    $("#bank_statement_resigngation_acceptance-img"+number).html('');
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
    	$("#bank_statement_resigngation_acceptance"+num).val('');
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
	           $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
	        };
	        reader.readAsDataURL(candidate_bank[i][num][id]);
	 	}
	}    
}

function save_details() {
	var appointment = [],
		experience = [],
		last_month = [],
		bank_statement = [],
		unuploaded_exp_or_releving_letter_count = 0,
		previously_uploaded_exp_or_releving_letter_count = 0;

	$(".appointment_letter").each(function() {
		if ($(this).val() != '') {
			appointment.push(1);
		} else {
			appointment.push(0);
		}
	});

	$(".experience_relieving_letter").each(function(i) {
		if ($(this).val() != '') {
			experience.push(1);
		} else {
			unuploaded_exp_or_releving_letter_count++;
			experience.push(0);
		}
	});

	$(".last_month_pay_slip").each(function() {
		if ($(this).val() != '') {
			last_month.push(1);
		} else {
			last_month.push(0);
		}
	});

	$(".bank_statement_resigngation_acceptance").each(function() {
		if ($(this).val() != '') {
			bank_statement.push(1);
		} else {
			bank_statement.push(0);
		}
	});

	$('.experience').each(function() {
		if ($(this).val() == '') {
			previously_uploaded_exp_or_releving_letter_count++
		}
	});

	if ((candidate_pan.length > 0 && unuploaded_exp_or_releving_letter_count == 0) || previously_uploaded_exp_or_releving_letter_count == 0) {
		$("#save-data-error-msg").html("<span class='text-warning'>Please wait while we are submitting the data.</span>");
		$("#save-details-btn").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		
		var formdata = new FormData();
		formdata.append('verify_candidate_request',1);
		formdata.append('appointment',appointment);
		formdata.append('experience',experience);
		formdata.append('last_month',last_month);
		formdata.append('bank_statement',bank_statement);

		if (candidate_aadhar.length > 0) {
			var a = 0;
			$.each(candidate_aadhar,function(index,value){ 
				$.each(value,function(index,val){ 
					if (candidate_aadhar[a][index].length > 0) {
						for (var c = 0; c < candidate_aadhar[a][index].length; c++) {
							formdata.append('candidate_aadhar'+a+'[]',candidate_aadhar[a][index][c]);
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
							formdata.append('candidate_pan'+a+'[]',candidate_pan[a][index][c]);
						}
					} else {
						formdata.append('candidate_pan[]','');
					}
				});
				a++;
			});
		} else {
			formdata.append('candidate_pan[]','');
		}

		if (candidate_proof.length > 0) {
			var a = 0;
			$.each(candidate_proof,function(index,value) {
				$.each(value,function(index,val) {
					if (candidate_proof[a][index].length > 0) {
						for (var c = 0; c < candidate_proof[a][index].length; c++) {
							formdata.append('candidate_proof'+a+'[]',candidate_proof[a][index][c]);
						}
					} else {
						formdata.append('candidate_proof[]','');
					}
				});
				a++;
			});
		} else {
			formdata.append('candidate_proof[]','');
		}

		if (candidate_bank.length > 0) {
			var a = 0;
			$.each(candidate_bank,function(index,value) {
				$.each(value,function(index,val) {
					if (candidate_bank[a][index].length > 0) {
						for (var c = 0; c < candidate_bank[a][index].length; c++) {
							formdata.append('candidate_bank'+a+'[]',candidate_bank[a][index][c]);
						}
					} else {
						formdata.append('candidate_bank[]','');
					}
				});
				a++;
			});
		} else {
			formdata.append('candidate_bank[]','');
		}

		formdata.append('count',candidate_aadhar.length);
		formdata.append('count_pan',candidate_pan.length);
		formdata.append('count_proof',candidate_proof.length);
		formdata.append('count_bank',candidate_bank.length);

		$.ajax({
            type : "POST",
            url : base_url+"m-factsuite-candidate/update-previous-employment-2-details",
            data : formdata,
            dataType : 'json',
            contentType : false,
            processData : false,
            success: function(data) {
            	$("#save-data-error-msg").html('');
              	$("#save-details-btn").html("Save & Continue");
				if (data.status == '1') {
					window.location.href = base_url+'m-component-list';
              	} else {
              		toastr.error('Something went wrong while save this data. Please try again.');
              	}
            },
            error: function(data) {
            	$("#save-data-error-msg").html('');
              	$("#save-details-btn").html("Save & Continue");
            	toastr.error('Something went wrong while save this data. Please try again.');
            }
        });
	} else {
		if (unuploaded_exp_or_releving_letter_count != 0) {
			$(".experience_relieving_letter").each(function(i) {
				if ($(this).val() == '') {
					$('#experience_relieving_letter-img'+i).html('<span class="text-danger error-msg-small">Please upload your experience or releving letter.</span>');
				}
			});
		}
	}
}