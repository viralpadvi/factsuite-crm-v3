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

function valid_company_url(i) {
	var client_website = $('#company_url'+i).val();
	if (client_website != '') {
		if (!url_regex.test(client_website)) {
			$('#company_url-error'+i).html('<span class="text-danger error-msg-small">Please enter the correct URL.</span>');
			input_is_invalid('#company_url'+i);
		} else {
			$('#company_url-error'+i).html('');
			input_is_valid('#company_url'+i);
		}
	} else {
		input_is_invalid('#company_url'+i);
		$('#company_url-error'+i).html('<span class="text-danger error-msg-small">Please enter the website URL.</span>');
	}
}
var email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
	alphabets_only = /^[A-Za-z ]+$/,
	vendor_name_length = 100,
	city_name_length = 100,
	vendor_zip_code_length = 6,
	vendor_monthly_quota_length = 5,
	vendor_docs = [],
	vendor_document_size = 1000000,
	max_vendor_document_select = 6,
	vendor_manager_name_length = 200, 
	vendor_spoc_name_length = 200,
	vendor_first_name_length = 100,
	vendor_last_name_length = 100,
	vendor_user_name_length = 70,
	min_vendor_user_name_length = 8,
	password_length = 8,
	vendor_skill_tat_length = 3;


	$("#addresses").change(function(){
		// alert($(this).prop('checked'))
		if ($(this).prop('checked')) { 
			var i = 0;
				var address =candidate_info['candidate_flat_no']+', '+candidate_info['candidate_street']+', '+candidate_info['candidate_area'];
			$(".address").each(function(){
				$(this).val(address);  
				i++;
			});
		}else{
			var i = 0;
			$(".address").each(function(){
				$(this).val('');  
				i++;
			});
		} 
	});


/*start::new script*/


$(".appointment_letter").on("change", handleFileSelect_candidate_aadhar);
$(".experience_relieving_letter").on("change", handleFileSelect_candidate_pan);
$(".last_month_pay_slip").on("change", handleFileSelect_candidate_proof);
$(".bank_statement_resigngation_acceptance").on("change", handleFileSelect_candidate_bank);

function handleFileSelect_candidate_aadhar(e){
			var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1;  
	if (files.length <= max_client_document_select) {

		// alert(files.length)
	    	$("#appointment_letter-img"+number).html('');
	        $("#appointment_letter-error"+number).html('');
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
	        // $("#appointment_letter-img"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
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
	}else{
		tmp_array.push(candidate_aadhar[i])
	}

    }

    candidate_aadhar = tmp_array; 

    if (candidate_aadhar.length == 0) {
    	$("#appointment_letter"+num).val('');
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



/*pan card*/
function handleFileSelect_candidate_pan(e){
			var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1;  
	if (files.length <= max_client_document_select) {

		// alert(files.length)
	    	$("#experience_relieving_letter-img"+number).html('');
	        $("#experience_relieving_letter-error"+number).html('');
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
		                $("#experience_relieving_letter-error"+number).append(html);
		        	}

		        }
		        candidate_pan.push({[number]:obj}); 
		    } else {
		    	$("#experience_relieving_letter-img"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
				$('#experience_relieving_letter'+number).val('');
		    }
	    } else {
	        // $("#experience_relieving_letter-img"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
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
	}else{
		tmp_array.push(candidate_pan[i])
	}

    }

    candidate_pan = tmp_array; 

    if (candidate_pan.length == 0) {
    	$("#experience_relieving_letter"+num).val('');
    }
    $('#file_candidate_pan_'+num+id).remove(); 
}

function view_pan_image(num,id,text){ 
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
/*END::PAN*/

/*proof card*/
function handleFileSelect_candidate_proof(e){
			var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1;  
	if (files.length <= max_client_document_select) {

		// alert(files.length)
	    	$("#last_month_pay_slip-img"+number).html('');
	        $("#last_month_pay_slip-error"+number).html('');
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
		                $("#last_month_pay_slip-error"+number).append(html);
		        	}

		        }
		        candidate_proof.push({[number]:obj}); 
		    } else {
		    	$("#last_month_pay_slip-img"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
				$('#last_month_pay_slip'+number).val('');
		    }
	    } else {
	        // $("#last_month_pay_slip-img"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
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
	}else{
		tmp_array.push(candidate_proof[i])
	}

    }

    candidate_proof = tmp_array; 

    if (candidate_proof.length == 0) {
    	$("#last_month_pay_slip"+num).val('');
    }
    $('#file_candidate_bank_'+num+id).remove(); 
}

function view_proof_image(num,id,text){ 
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	 for (var i = 0; i < candidate_proof.length; i++) {
	 	 if (typeof candidate_proof[i][num] !='undefined') {
	 	 	var reader = new FileReader();
	        reader.onload = function(event) {
	           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
	        };
	        reader.readAsDataURL(candidate_proof[i][num][id]);
	 	 }
	 }
	    
}
/*END::PROOF*/



/*bank card*/
function handleFileSelect_candidate_bank(e){ 
		var file_id = $(this).attr('id');
		var number = file_id.match(/\d+/);
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1;  
	if (files.length <= max_client_document_select) {

		// alert(files.length)
	    	$("#bank_statement_resigngation_acceptance-error"+number).html('');
	        $("#bank_statement_resigngation_acceptance-error"+number).html('');
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
		                $("#bank_statement_resigngation_acceptance-error"+number).append(html);
		        	}

		        }
		        candidate_bank.push({[number]:obj}); 
		    } else {
		    	$("#bank_statement_resigngation_acceptance-error"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
				$('#bank_statement_resigngation_acceptance'+number).val('');
		    }
	    } else {
	        // $("#bank_statement_resigngation_acceptance-img"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
	        $("#bank_statement_resigngation_acceptance-error"+number).html('');
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
	}else{
		tmp_array.push(candidate_bank[i])
	}

    }

    candidate_bank = tmp_array; 

    if (candidate_bank.length == 0) {
    	$("#bank_statement_resigngation_acceptance"+num).val('');
    }
    $('#file_candidate_bank_'+num+id).remove(); 
}

function view_bank_image(num,id,text){ 
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
/*END::PROOF*/

function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}
/*end::new script*/


// $("#file1").on("change", handleFileSelect_candidate_aadhar);
// $("#file2").on("change", handleFileSelect_candidate_pan);
// $("#file3").on("change", handleFileSelect_candidate_proof);
// $("#file4").on("change", handleFileSelect_candidate_bank); 

/*
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
*/
/*
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
 // $('#frame').attr('src',URL.createObjectURL(event.target.files[0]));
function handleFileSelect_candidate_bank(e){
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
*/
/*
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

function view_image_bank(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_bank[id]);
} 


function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}
*/

function check_reporting_manager_email_id(id) {
	var variable_array = {};
	variable_array['input_id'] = '#reporting-manager-email-id'+id;
	variable_array['error_msg_div_id'] = '#reporting-manager-email-id-error'+id;
	variable_array['empty_input_error_msg'] = '';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	return not_mandatory_email_id(variable_array);
}
function check_hr_email_id(id) {
	var variable_array = {};
	variable_array['input_id'] = '#hr-email-id'+id;
	variable_array['error_msg_div_id'] = '#hr-email-id-error'+id;
	variable_array['empty_input_error_msg'] = 'Please enter HR manager email id.';
	variable_array['not_an_email_input_error_msg'] = 'Please enter a valid email id.';
	return mandatory_email_id(variable_array);
}


 function add_employments(){

 var designation = [];
 var count = 0;
$(".designation").each(function(){
	count++;
	if ($(this).val() !='' && $(this).val() !=null) {
	designation.push({desigination : $(this).val()});
	}
});
var department = [];
$(".department").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	department.push({department : $(this).val()});
	}
});
var employee_id = [];
$(".employee_id").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	employee_id.push({employee_id : $(this).val()});
	}
});
var company_name = [];
$(".company-name").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	company_name.push({company_name : $(this).val()});
	}
});
var address = [];
$(".address").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	address.push({address : $(this).val()});
	}
});
var annual_ctc = [];
$(".annual-ctc").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	annual_ctc.push({annual_ctc : $(this).val()});
	}
});
var reasion = [];
$(".reasion").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	reasion.push({reason_for_leaving : $(this).val()});
	}
});
var joining_date = [];
$(".joining-date").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	joining_date.push({joining_date : $(this).val()});
	}
});
var relieving_date = []; 
$(".relieving-date").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	relieving_date.push({relieving_date : $(this).val()});
	}
});
var manager_name = [];
$(".reporting-manager-name").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	manager_name.push({reporting_manager_name : $(this).val()});
	}
});
var manager_designation = [];
$(".reporting-manager-designation").each(function(){ 
	if ($(this).val() !='' && $(this).val() !=null) {
	manager_designation.push({reporting_manager_desigination : $(this).val()});
	}
});
var manager_contact = [];
$(".reporting-manager-contact").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	manager_contact.push({reporting_manager_contact_number : $(this).val()});
	}
});
var hr_name = [];
$(".hr-name").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	hr_name.push({hr_name : $(this).val()});
	}
});
var hr_contact = [];
$(".hr-contact").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	hr_contact.push({hr_contact_number : $(this).val()});
	}
}); 

var code = [];
$(".code").each(function(){
	// if ($(this).val() !='' && $(this).val() !=null) {
	code.push({code : $(this).val()});
	// }
});
var company_url = [];
$(".company_url").each(function(){
	// if ($(this).val() !='' && $(this).val() !=null) {
	company_url.push({company_url : $(this).val()});
	// }
});
var hr_code = [];
$(".hr-code").each(function(){
	// if ($(this).val() !='' && $(this).val() !=null) {
	hr_code.push({hr_code : $(this).val()});
	// }
});
var appointment_letter =[];// $("#appointment_letter").val();
		var experience_relieving_letter =[];// $("#experience_relieving_letter").val();
		var last_month_pay_slip =[];// $("#last_month_pay_slip").val();

$(".appointment").each(function(){
	// if ($(this).val() !='' && $(this).val() !=null) {
	appointment_letter.push({appointment_letter : $(this).val()});
	// }
});

$(".experience").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	experience_relieving_letter.push({experience_relieving_letter : $(this).val()});
	}
});

$(".last_month").each(function(){
	// if ($(this).val() !='' && $(this).val() !=null) {
	last_month_pay_slip.push({last_month_pay_slip : $(this).val()});
	// }
});

var reporting_manager_email_id = [],
hr_email_id = [];

	$(".reporting-manager-email-id").each(function(i) {
		var check_reporting_manager_email_id_var = check_reporting_manager_email_id(i);
		if (check_reporting_manager_email_id_var == 1) {
			reporting_manager_email_id.push({reporting_manager_email_id : $(this).val()});
		} else {
			invalid_reporting_manager_email_id_count++;
		}
	});
var invalid_hr_email_id_count = 0;
	$(".hr-email-id").each(function(i) {
		var check_hr_email_id_var = check_hr_email_id(i);
		if (check_hr_email_id_var == 1) {
			hr_email_id.push({hr_email_id : $(this).val()});
		} else {
			invalid_hr_email_id_count++;
		}
	});

 
	if (designation.length > 0 &&
	department.length > 0 &&
	employee_id.length > 0 &&
	company_name.length > 0 &&
	address.length > 0 &&
	annual_ctc.length > 0 &&
	reasion.length > 0 &&
	joining_date.length > 0 &&
	relieving_date.length > 0 &&
	manager_name.length > 0 &&
	manager_designation.length > 0 &&
	manager_contact.length > 0 &&
	hr_name.length > 0 &&
	hr_contact.length > 0 && 
	designation.length == count &&
	department.length == count &&
	employee_id.length == count &&
	company_name.length == count &&
	address.length == count &&
	annual_ctc.length == count &&
	reasion.length == count && 
	manager_name.length == count &&
	manager_designation.length == count &&
	manager_contact.length == count &&
	hr_name.length == count &&
	hr_contact.length == count/* &&
	 ( (candidate_aadhar.length != 0 || (appointment_letter.length != 0 && appointment_letter !=null)) || (candidate_pan.length != 0 || (experience_relieving_letter.length != 0 && experience_relieving_letter !=null)) || (candidate_proof.length != 0  || (last_month_pay_slip.length != 0 && last_month_pay_slip !=null)) )*/ ) { 
	 	var formdata = new FormData();
	 	formdata.append('url',10);
			formdata.append('designation',JSON.stringify(designation));
			formdata.append('department',JSON.stringify(department));
			formdata.append('employee_id',JSON.stringify(employee_id));
			formdata.append('company_name',JSON.stringify(company_name));
			formdata.append('address',JSON.stringify(address));
			formdata.append('annual_ctc',JSON.stringify(annual_ctc));
			formdata.append('reasion',JSON.stringify(reasion));
			formdata.append('joining_date',JSON.stringify(joining_date));
			formdata.append('relieving_date',JSON.stringify(relieving_date));
			formdata.append('manager_name',JSON.stringify(manager_name));
			formdata.append('manager_designation',JSON.stringify(manager_designation));
			formdata.append('manager_contact',JSON.stringify(manager_contact));
			formdata.append('hr_name',JSON.stringify(hr_name));
			formdata.append('hr_contact',JSON.stringify(hr_contact));
			formdata.append('hr_code',JSON.stringify(hr_code));
			formdata.append('code',JSON.stringify(code));
			formdata.append('company_url',JSON.stringify(company_url));
			formdata.append('reporting_manager_email_id',JSON.stringify(reporting_manager_email_id));
			formdata.append('hr_email_id',JSON.stringify(hr_email_id));
			formdata.append('link_request_from',link_request_from);
			var previous_emp_id = $("#previous_emp_id").val();
			if (previous_emp_id !='' && previous_emp_id !=null) {
				formdata.append('previous_emp_id',previous_emp_id);
			}
			var appointment = [];
			var experience = [];
			var last_month = [];
			var bank_statement = [];
			$(".appointment_letter").each(function(){
				if ($(this).val() !='') {
					appointment.push(1);
				}else{
					appointment.push(0);
				}
			})
			$(".experience_relieving_letter").each(function(){
				if ($(this).val() !='') {
					experience.push(1);
				}else{
					experience.push(0);
				}
			})
			$(".last_month_pay_slip").each(function(){
				if ($(this).val() !='') {
					last_month.push(1);
				}else{
					last_month.push(0);
				}
			})
			$(".bank_statement_resigngation_acceptance").each(function(){
				if ($(this).val() !='') {
					bank_statement.push(1);
				}else{
					bank_statement.push(0);
				}
			})

			/*if (candidate_aadhar.length > 0) {
			for (var i = 0; i < candidate_aadhar.length; i++) { 
				formdata.append('candidate_aadhar[]',candidate_aadhar[i]);
			}
			}else{
				formdata.append('candidate_aadhar[]','');
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
					formdata.append('candidate_proof[]',candidate_proof[i]);
				}
			}else{
				formdata.append('candidate_proof[]','');
			}
			if (candidate_bank.length > 0) {
				for (var i = 0; i < candidate_bank.length; i++) { 
					formdata.append('candidate_bank[]',candidate_bank[i]);
				}
			}else{
				formdata.append('candidate_bank[]','');
			}*/
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
					// alert(candidate_aadhar[a][index][c].name)
			} 	
			}else{
				// alert("false 1")
				// formdata.append('all_sem_marksheet[]','');
			}
		});
			a++;
		});
 
	}else{
		// formdata.append('all_sem_marksheet[]','');
		// alert("false 2")
	} 

 
		if (candidate_pan.length > 0) {
				var a = 0;
				$.each(candidate_pan,function(index,value){ 
					$.each(value,function(index,val){ 
					if (candidate_pan[a][index].length > 0) {
					for (var c = 0; c < candidate_pan[a][index].length; c++) {
							formdata.append('candidate_pan'+a+'[]',candidate_pan[a][index][c]); 
							// alert(candidate_aadhar[a][index][c].name)
					} 	
					}else{
						// alert("false 1")
						formdata.append('candidate_pan[]','');
					}
				});
					a++;
				});
		 
			}else{
				formdata.append('candidate_pan[]','');
				// alert("false 2")
			} 
 
		if (candidate_proof.length > 0) {
				var a = 0;
				$.each(candidate_proof,function(index,value){ 
					$.each(value,function(index,val){ 
					if (candidate_proof[a][index].length > 0) {
					for (var c = 0; c < candidate_proof[a][index].length; c++) {
							formdata.append('candidate_proof'+a+'[]',candidate_proof[a][index][c]); 
							// alert(candidate_aadhar[a][index][c].name)
					} 	
					}else{
						// alert("false 1")
						formdata.append('candidate_proof[]','');
					}
				});
					a++;
				});
		 
			}else{
				formdata.append('candidate_proof[]','');
				// alert("false 2")
			} 

 
		if (candidate_bank.length > 0) {
				var a = 0;
				$.each(candidate_bank,function(index,value){ 
					$.each(value,function(index,val){ 
					if (candidate_bank[a][index].length > 0) {
					for (var c = 0; c < candidate_bank[a][index].length; c++) {
							formdata.append('candidate_bank'+a+'[]',candidate_bank[a][index][c]); 
							// alert(candidate_aadhar[a][index][c].name)
					} 	
					}else{
						// alert("false 1")
						formdata.append('candidate_bank[]','');
					}
				});
					a++;
				});
		 
			}else{
				formdata.append('candidate_bank[]','');
				// alert("false 2")
			} 
		formdata.append('count',candidate_aadhar.length);
		formdata.append('count_pan',candidate_pan.length);
		formdata.append('count_proof',candidate_proof.length);
		formdata.append('count_bank',candidate_bank.length);
$("#add_employments").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');


	$.ajax({
            type: "POST",
              url: base_url+"candidate/update_candidate_previous_employment",
              data:formdata,
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(data) {
				if (data.status == '1') {
					// toastr.success('successfully saved data.');  
					window.location.href=base_url+data.url;
              	}else{
              		toastr.error('Something went wrong while save this data. Please try again.'); 	
              	}
              	$("#add_employments").html("Save & Continue")
              }
            });
	}else{
		$(".designation").each(function(){
			var MyID = $(this).attr("id"); 
		   var number = MyID.match(/\d+/); 
			valid_designation(number)
			valid_department(number)
			valid_employee_id(number)
			valid_company_name(number)
			valid_address(number)
			valid_annual_ctc(number)
			valid_reasion(number)
			valid_joining_date(number)
			valid_relieving_date(number)
			valid_reporting_manager_name(number)
			valid_reporting_manager_designation(number)
			valid_reporting_manager_contact(number)
			valid_hr_name(number)
			valid_hr_contact(number)
			if (candidate_aadhar.length == 0 && appointment_letter=='') {
				$("#aadhar-error").html("<span class='text-danger error-msg-small'>Please upload the appointment letter</span>");
			}
			if (candidate_pan.length == 0 && experience_relieving_letter == '') {
				$("#pan-error").html("<span class='text-danger error-msg-small'>Please upload experience / relieving letter</span>");
			}
			if (candidate_proof.length == 0 && last_month_pay_slip =='' ) {
				$("#proof-error").html("<span class='text-danger error-msg-small'>Please upload last pay slip</span>");
			}
		}); 

		$("#add_employments").html("Save & Continue")
		 
	}
 }


var j =5;
$("#add-row").on('click',function(){
var html ='';
html +='<div id="form'+j+'">';
html +='<div class="row">';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Desigination</label>';
html +='<input name="" class="fld form-control designation" value="" id="designation" type="text">';

html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Department</label>';
html +='<input name="" class="fld form-control department" value="" id="department" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Employee ID</label>';
html +='<input name="" class="fld form-control employee_id" value="" id="employee_id" type="text">';
html +='</div>';
html +='</div>';
html +='</div>';
html +='<div class="row">';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Company Name</label>';
html +='<input name="" class="fld form-control company-name" value="" id="company-name" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-8">';
html +='<div class="pg-frm">';
html +='<label>Address</label>';
html +='<textarea class="add address" id="address" type="text"></textarea>';
html +='</div>';
html +='</div>';
html +='</div>';
html +='<div class="row">';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Annual CTC</label>';
html +='<input name="" class="fld annual-ctc" id="annual-ctc" value="" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-8">';
html +='<div class="pg-frm">';
html +='<label>Reason For Leaving</label>';
html +='<input name="" class="fld reasion" id="reasion"  value="" type="text">';
html +='</div>';
html +='</div>';
html +='</div>';
html +='<div class="row">';
html +='<div class="col-md-4">';
html +='<div class="pg-frm-hd">Joining Date</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm-hd">relieving date</div>';
html +='</div>';
html +='</div>';
html +='<div class="row">';
html +='<div class="col-md-4"> ';
html +='<input name="" class="fld form-control joining-date mdate" id="joining-date" value="" type="text"> ';
html +='</div> ';
html +='<div class="col-md-4"> ';
html +='<input name="" class="fld form-control relieving-date mdate" id="relieving-date" value="" type="text"> ';
html +='</div>';
html +='</div>';
html +='<div class="row">';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Reporting Manager Name</label>';
html +='<input name="" class="fld form-control reporting-manager-name" id="reporting-manager-name" value="" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Reporting Manager Designation</label>';
html +='<input name="" class="fld form-control reporting-manager-designation" id="reporting-manager-designation" value="" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Reporting Manager Contact Number</label>';
html +='<input name="" class="fld form-control reporting-manager-contact" id="reporting-manager-contact" value="" type="text">';
html +='</div>';
html +='</div>';
html +='</div>';
html +='<div class="row">';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>HR Contact Name</label>';
html +='<input name="" class="fld form-control hr-name" id="hr-name" value="" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>HR Contact Number</label>';
html +='<input name="" class="fld form-control hr-contact" id="hr-contact" value="" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<button onclick="remove_form('+j+')"><i class="fa fa-trash"></i></button>';
html +='</div>';
html +='</div>';
html +='</div>';

$("#new_address").append(html);
j++;
});


function remove_form(id){
	$("#form"+id).remove();
}



	function input_is_valid(input_id) {
		$(input_id).removeClass('is-invalid');
		$(input_id).addClass('is-valid');
	}

	function input_is_invalid(input_id) {
		$(input_id).removeClass('is-valid');
		$(input_id).addClass('is-invalid');
	}

	function valid_designation(id){ 
		var designation = $("#designation"+id).val();
		if (designation !='') {
			$("#designation-error"+id).html("");
			input_is_valid("#designation"+id)
		}else{
			input_is_invalid("#designation"+id)
			$("#designation-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid designation</span>");
		}
	}
	function valid_department(id){
		var department = $("#department"+id).val();
			if (department !='') {
			$("#department-error"+id).html("");
			input_is_valid("#department"+id)
		}else{
			input_is_invalid("#department"+id)
			$("#department-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid department</span>");
		}
	}
	function valid_employee_id(id){
		var employee_id = $("#employee_id"+id).val();
			if (employee_id !='') {
			$("#employee_id-error"+id).html("");
			input_is_valid("#employee_id"+id)
		}else{
			input_is_invalid("#employee_id"+id)
			$("#employee_id-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid employee Id</span>");
		}
	}
	function valid_company_name(id){
		var company_name = $("#company-name"+id).val();
			if (company_name !='') {
			$("#company-name-error"+id).html("");
			input_is_valid("#company-name"+id)
		}else{
			input_is_invalid("#company-name"+id)
			$("#company-name-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid company name</span>");
		}
	}
	function valid_address(id){
		var address = $("#address"+id).val();
			if (address !='') {
			$("#address-error"+id).html("");
			input_is_valid("#address"+id)
		}else{
			input_is_invalid("#address"+id)
			$("#address-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid address</span>");
		}
	}
	function valid_annual_ctc(id){
		var annual_ctc = $("#annual-ctc"+id).val();
			if (annual_ctc !='') {
			$("#annual-ctc-error"+id).html("");
			input_is_valid("#annual-ctc"+id)
		}else{
			input_is_invalid("#annual-ctc"+id)
			$("#annual-ctc-error"+id).html("<span class='text-danger error-msg-small'>Please enter annual CTC</span>");
		}
	}
	function valid_reasion(id){
		var reasion = $("#reasion"+id).val();
			if (reasion !='') {
			$("#reasion-error"+id).html("");
			input_is_valid("#reasion"+id)
		}else{
			input_is_invalid("#reasion"+id)
			$("#reasion-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid reason</span>");
		}
	}
	function valid_joining_date(id){
		var joining_date = $("#joining-date"+id).val();
			if (joining_date !='') {
				$("#relieving-date"+id).attr('disabled',false);
			$("#joining-date-error"+id).html("");
			input_is_valid("#joining-date"+id)
		}else{
			input_is_invalid("#joining-date"+id)
			$("#joining-date-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid joining date</span>");
		}
	}
	function valid_relieving_date(id){
		var relieving_date = $("#relieving-date"+id).val();
			if (relieving_date !='') {
			$("#relieving-date-error"+id).html("");
			input_is_valid("#relieving-date"+id)
		}else{
			input_is_invalid("#relieving-date"+id)
			$("#relieving-date-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid relieving date</span>");
		}
	}
 
function valid_reporting_manager_name(id){
	 
	var reporting_manager = $("#reporting-manager-name"+id).val();
	if (reporting_manager != '') {
		if (!alphabets_only.test(reporting_manager)) {
			$("#reporting-manager-name-error"+id).html('<span class="text-danger error-msg-small">Reporting manager name should be only alphabets.</span>');
			$("#reporting-manager-name"+id).val(reporting_manager.slice(0,-1));
			input_is_invalid("#reporting-manager-name"+id);
		} else if (reporting_manager.length > vendor_name_length) {
			$("#reporting-manager-name-error"+id).html('<span class="text-danger error-msg-small">Reporting manager name should be of max '+vendor_name_length+' characters.</span>');
			$("#reporting-manager-name"+id).val(reporting_manager.slice(0,vendor_name_length));
			input_is_invalid("#reporting-manager-name"+id);
		} else {
			$("#reporting-manager-name-error"+id).html('');
			input_is_valid("#reporting-manager-name"+id);
		}
	} else {
		$("#reporting-manager-name-error"+id).html('<span class="text-danger error-msg-small">Please add a reporting manager name.</span>');
		input_is_invalid("#reporting-manager-name"+id);
	}
}
 

	function valid_reporting_manager_designation(id){
		var manager_designation = $("#reporting-manager-designation"+id).val();
		if (manager_designation !='') {
			$("#reporting-manager-designation-error"+id).html("");
			input_is_valid("#reporting-manager-designation"+id)
		}else{
			input_is_invalid("#reporting-manager-designation"+id)
			$("#reporting-manager-designation-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid reporting manager designation</span>");
		}
	}
	function valid_reporting_manager_contact(id){
		var manager_contact = $("#reporting-manager-contact"+id).val();
			if (manager_contact !='') {
				if (isNaN(manager_contact)) {
					$("#reporting-manager-contact-error"+id).html('<span class="text-danger error-msg-small">Contact number should be only numbers.</span>');
					$("#reporting-manager-contact"+id).val(manager_contact.slice(0,-1));
					input_is_invalid("#reporting-manager-contact"+id);
				} else if (manager_contact.length != 10) {
					$("#reporting-manager-contact-error"+id).html('<span class="text-danger error-msg-small">Contact number should be of '+10+' digits.</span>');
					var plenght = $("#reporting-manager-contact"+id).val(manager_contact.slice(0,10));
					input_is_invalid("#reporting-manager-contact"+id);
					if (plenght.length == 10) {
					$("#reporting-manager-contact-error"+id).html('');
					input_is_valid("#reporting-manager-contact"+id);	
					}
				}else{
						$("#reporting-manager-contact-error"+id).html('');
					input_is_valid("#reporting-manager-contact"+id);	
				}
		}else{
			input_is_invalid("#reporting-manager-contact"+id)
			$("#reporting-manager-contact-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid reporting manager contact</span>");
		}
	}
 
	function valid_hr_name(id){
	 
		var last_name = $("#hr-name"+id).val();
		if (last_name != '') {
			if (!alphabets_only.test(last_name)) {
				$("#hr-name-error"+id).html('<span class="text-danger error-msg-small">HR name should be only alphabets.</span>');
				$("#hr-name"+id).val(last_name.slice(0,-1));
				input_is_invalid("#hr-name"+id);
			} else if (last_name.length > vendor_name_length) {
				$("#hr-name-error"+id).html('<span class="text-danger error-msg-small">HR name should be of max '+vendor_name_length+' characters.</span>');
				$("#hr-name"+id).val(last_name.slice(0,vendor_name_length));
				input_is_invalid("#hr-name"+id);
			} else {
				$("#hr-name-error"+id).html('');
				input_is_valid("#hr-name"+id);
			}
		} else {
			$("#hr-name-error"+id).html('<span class="text-danger error-msg-small">Please add a HR name.</span>');
			input_is_invalid("#hr-name"+id);
		}
	}

	function valid_hr_contact(id){
		var hr_contact = $("#hr-contact"+id).val();
			if (hr_contact !='') {
				if (isNaN(hr_contact)) {
					$("#hr-contact-error"+id).html('<span class="text-danger error-msg-small">Contact number should be only numbers.</span>');
					$("#hr-contact"+id).val(hr_contact.slice(0,-1));
					input_is_invalid("#hr-contact"+id);
				} else if (hr_contact.length != 10) {
					$("#hr-contact-error"+id).html('<span class="text-danger error-msg-small">Contact number should be of '+10+' digits.</span>');
					var plenght = $("#hr-contact"+id).val(hr_contact.slice(0,10));
					input_is_invalid("#hr-contact"+id);
					if (plenght.length == 10) {
					$("#hr-contact-error"+id).html('');
					input_is_valid("#hr-contact"+id);	
					} 
				}else{
				$("#hr-contact-error"+id).html('');
					input_is_valid("#hr-contact"+id);	
				}
		}else{
			input_is_invalid("#hr-contact"+id)
			$("#hr-contact-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid HR contact</span>");
		}
	} 




function removeFile_documents(id,param){
	// alert($("#remove_file_"+param+"_documents"+id).data('path'))
	$("#myModal-remove").modal('show');
	$("#remove-caption").html("<h4 class='text-danger'>Are you sure removing this  image?</h4>")
	$("#button-area").html('<a href="" data-dismiss="modal" class="exit-btn float-center text-center mr-1">Close</a><button class="btn btn-sm btn-danger text-white" onclick="image_remove('+id+',\''+param+'\')">remove</button>')

}


function image_remove(id,param){ 
var	table = 'previous_employment';
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