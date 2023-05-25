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

// alert(JSON.stringify(states))


	$("#addresses").change(function(){
		// alert($(this).prop('checked'))
		if ($(this).prop('checked')) { 
			var i = 0;
				var address =candidate_info['candidate_flat_no']+', '+candidate_info['candidate_street']+', '+candidate_info['candidate_area'];
			$(".permenent-house-flat").each(function(){
				$(this).val(candidate_info['candidate_flat_no']); 
				// $("#permenent-house-flat").val(candidate_info['candidate_flat_no']);
				$("#permenent-street"+i).val(candidate_info['candidate_street']);
				$("#permenent-area"+i).val(candidate_info['candidate_area']);
				$("#permenent-pincode"+i).val(candidate_info['candidate_pincode']); 
				i++;
			});
		}else{
			var i = 0;
			$(".address").each(function(){
				$(this).val(''); 
				$("#permenent-street"+i).val(''); 
				$("#permenent-area"+i).val(''); 
				$("#permenent-pincode"+i).val('');  
				i++;
			});
		} 
	});



/*start::new script*/


$(".rental_agreement").on("change", handleFileSelect_candidate_aadhar);
$(".ration_card").on("change", handleFileSelect_candidate_pan);
$(".gov_utility_bill").on("change", handleFileSelect_candidate_proof);
// $(".bank_statement_resigngation_acceptance").on("change", handleFileSelect_candidate_bank);

function handleFileSelect_candidate_aadhar(e){
			var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1;  
	if (files.length <= max_client_document_select) {

		// alert(files.length)
	    	$("#rental_agreement-img"+number).html('');
	        $("#rental_agreement-error"+number).html('');
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
	}else{
		tmp_array.push(candidate_aadhar[i])
	}

    }

    candidate_aadhar = tmp_array; 

    if (candidate_aadhar.length == 0) {
    	$("#rental_agreement"+num).val('');
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
	    	$("#ration_card-img"+number).html('');
	        $("#ration_card-error"+number).html('');
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
	}else{
		tmp_array.push(candidate_pan[i])
	}

    }

    candidate_pan = tmp_array; 

    if (candidate_pan.length == 0) {
    	$("#ration_card"+num).val('');
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
	    	$("#gov_utility_bill-img"+number).html('');
	        $("#gov_utility_bill-error"+number).html('');
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



var j =5;
$("#add-row").on('click',function(){
 
var html = '';
html +='<div id="form'+j+'">';
html +='<div class="row">';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>House/Flat No.</label>';
html +='<input name="" class="fld form-control permenent-house-flat" id="permenent-house-flat" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Street/Road</label>';
html +='<input name="" class="fld form-control permenent-street" id="permenent-street" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Area</label>';
html +='<input name="" class="fld form-control permenent-area" id="permenent-area" type="text">';
html +='</div>';
html +='</div>';
html +='</div>';
html +='<div class="row">';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>City/Town</label>';
html +='<input name="" class="fld form-control permenent-city" id="permenent-city" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Pin Code</label>';
html +='<input name="" class="fld form-control permenent-pincode" id="permenent-pincode" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>Nearest Landmark</label>';
html +='<input name="" class="fld form-control permenent-land-mark" id="permenent-land-mark" type="text">';
html +='</div>';
html +='</div>';
html +='<div class="col-md-4">';
html +='<div class="pg-frm">';
html +='<label>State</label>';
html +='<select name="" class="fld form-control state" id="state">';
	for (var i = 0; i < states.length; i++) {
		html +='<option value="'+states[i]+'">'+states[i]+'</option>';
	}
html +='</select>';
html +='</div>';
html +='</div>';
html +='</div>';
html +='<div class="pg-frm-hd">Duration of Stay</div>';
html +='<div class="row">';
html +='<div class="col-md-3">';
html +='<div></div>';
html +='<input name="" class="fld form-control end-date permenent-start-date" id="permenent-start-date" type="text">';
html +='</div> ';
html +='<h6 class="To">TO</h6>';
html +='<div class="col-md-3">';
html +='<div></div>';
html +='<input name="" class="fld form-control end-date permenent-end-date" id="permenent-end-date" type="text"> ';
html +='</div>';
html +='<div class="col-md-2 tp">';
html +='<div class="custom-control custom-checkbox custom-control-inline mrg-btm d-none">';
html +='<input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck2">';
html +='<label class="custom-control-label pt-1" for="customCheck2">Present</label>';
html +='</div>';
html +='</div>';
html +='<div class="col-md-2 tp">';

html +='</div>';
html +='</div>';
html +='<div class="pg-frm-hd">Contact Person</div>';
html +='<div class="row">';
html +='<div class="col-md-3">';
html +='<div class="pg-frm">';
html +='<label>Name</label>';
html +='<input name="" class="fld permenent-name" id="permenent-name"   type="text">';
html +='</div>';
html +='</div> ';
html +='<div class="col-md-3">';
html +='<div class="pg-frm">';
html +='<label>Reletionship</label>';

html +='<select name="" class="fld form-control relationship" id="relationship" >';
	html +='<option value="">Select Relationship</option>';
	html +='<option  value="Self">Self</option>';
	html +='<option  value="Parent">Parent</option>';
	html +='<option  value="Spouse">Spouse</option>';
	html +='<option value="Friend">Friend</option>';
	html +='<option value="Relative">Relative</option>';
html +='</select>';
html +='</div>';
html +='</div>';
html +='<div class="col-md-3">';
html +='<div class="pg-frm">';
html +='<label>Mobile Number</label>';
html +='<input name="" class="fld permenent-contact_no"  id="permenent-contact_no"  type="text">';
html +='</div>';
html +='</div>';

html +='<div class="col-md-3">';
html +='<label></label><br>';
html +='<button onclick="remove_form('+j+')" ><i class="fa fa-trash"></i></button>';
html +='</div>';

html +='</div>';
html +='</div>';
$("#new_address").append(html);
j++;
});


function remove_form(id){
	$("#form"+id).remove();
}
/*
$("#file1").on("change", handleFileSelect_candidate_aadhar);
$("#file2").on("change", handleFileSelect_candidate_pan);
$("#file3").on("change", handleFileSelect_candidate_proof); 


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
*/
function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}


 $("#add_address").on('click',function(){ 
 /*	var house = $("#house-flat").val();
 	var street = $("#street").val();
 	var area = $("#area").val();
 	var city = $("#city"+id).val();
 	var pincode = $("#pincode").val();
 	var land_mark = $("#land-mark").val();
 	var start_date = $("#start-date").val();
 	var end_date = $("#end-date").val();
 	var present = $("#customCheck1:checked").val();
 	var name = $("#name").val();
 	var relationship = $("#relationship").val();
 	var contact_no = $("#contact_no").val();
*/
var flat_no = [];
var count = 0;
$(".permenent-house-flat").each(function(){
	count++;
	if ($(this).val() !='' && $(this).val() !=null) {
	flat_no.push({flat_no : $(this).val()});
	}
});
var street = [];
$(".permenent-street").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	street.push({street : $(this).val()});
	}
});
var area = [];
$(".permenent-area").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	area.push({area : $(this).val()});
	}
});
var city = [];
$(".permenent-city").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	city.push({city : $(this).val()});
	}
});
var pin_code = [];
$(".permenent-pincode").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	pin_code.push({pin_code : $(this).val()});
	}
});
var nearest_landmark = [];
$(".permenent-land-mark").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	nearest_landmark.push({nearest_landmark : $(this).val()});
	}
});
var state = [];
$(".state").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	state.push({state : $(this).val()});
	}
});
var country = [];
$(".country").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	country.push({country : $(this).val()});
	}
});

var contact_person_relationship = [];
$(".relationship").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	contact_person_relationship.push({contact_person_relationship : $(this).val()});
	}
});
var duration_of_stay_start = [];
$(".permenent-start-date").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	duration_of_stay_start.push({duration_of_stay_start : $(this).val()});
	}
});
var duration_of_stay_end = [];
$(".permenent-end-date").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	duration_of_stay_end.push({duration_of_stay_end : $(this).val()});
	}
});
var contact_person_name = [];
$(".permenent-name").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	contact_person_name.push({contact_person_name : $(this).val()});
	}
});
var contact_person_mobile_number = [];
$(".permenent-contact_no").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	contact_person_mobile_number.push({contact_person_mobile_number : $(this).val()});
	}
});
var code = [];
$(".code").each(function(){
	if ($(this).val() !='' && $(this).val() !=null) {
	code.push({code : $(this).val()});
	}
});


var start_month = [];
$(".duration-of-stay-from-month").each(function(){ 
	start_month.push($(this).val()); 
});

var start_year = [];
$(".duration-of-stay-from-year").each(function(){ 
	start_year.push($(this).val()); 
});

var end_month = [];
$(".duration-of-stay-end-month").each(function(){ 
	end_month.push($(this).val()); 
});

var end_year = [];
$(".duration-of-stay-end-year").each(function(){ 
	end_year.push($(this).val()); 
});

 
 	var permenent_present = $("#permenent-customCheck1:checked").val();
	var previos_address_id = $("#previos_address_id").val();
/* 	var permenent_house = $("#permenent-house-flat").val();
 	var permenent_street = $("#permenent-street").val();
 	var permenent_area = $("#permenent-area").val();
 	var permenent_city = $("#permenent-city").val();
 	var permenent_pincode = $("#permenent-pincode").val();

 	var permenent_land_mark = $("#permenent-land-mark").val();
 	var permenent_start_date = $("#permenent-start-date").val();
 	var permenent_end_date = $("#permenent-end-date").val();
 	var permenent_name = $("#permenent-name"+id).val();
 	var permenent_relationship = $("#permenent-relationship").val();
 	var permenent_contact_no = $("#permenent-contact_no").val();
 	var state = $(".state").val();*/
var rental_agreement = [];//$("#rental_agreement").val(); 

$(".rental").each(function(){
	if ($(this).val() !=null) {
rental_agreement.push($(this).val());
	}
});
 	if (flat_no.length > 0 &&
street.length > 0 &&
area.length > 0 &&
city.length > 0 &&
pin_code.length > 0 &&
nearest_landmark.length > 0 &&
state.length > 0 &&
contact_person_relationship.length > 0 && 
contact_person_name.length > 0 &&
contact_person_mobile_number.length > 0 &&
contact_person_mobile_number.length == count &&
flat_no.length == count &&
street.length == count &&
area.length == count &&
city.length == count &&
pin_code.length == count &&
nearest_landmark.length == count &&
state.length == count &&
contact_person_relationship.length == count && 
contact_person_name.length == count ) {
 		// && (candidate_aadhar.length > 0 || (rental_agreement.length != 0 && rental_agreement !=null))
 	var formdata = new FormData(); 
	/*	formdata.append('house',house);
		formdata.append('street',street);
		formdata.append('area',area);
		formdata.append('city',city);
		formdata.append('pincode',pincode);
		formdata.append('land_mark',land_mark);
		formdata.append('start_date',start_date);
		formdata.append('end_date',end_date);
		formdata.append('present',present);
		formdata.append('name',name);
		formdata.append('relationship',relationship);
		formdata.append('contact_no',contact_no);*/
		formdata.append('url',12);
		formdata.append('permenent_house',JSON.stringify(flat_no));
		formdata.append('permenent_street',JSON.stringify(street));
		formdata.append('permenent_area',JSON.stringify(area));
		formdata.append('permenent_city',JSON.stringify(city));
		formdata.append('permenent_pincode',JSON.stringify(pin_code));
		formdata.append('permenent_land_mark',JSON.stringify(nearest_landmark));
		formdata.append('permenent_start_date',JSON.stringify(duration_of_stay_start));
		formdata.append('permenent_end_date',JSON.stringify(duration_of_stay_end));
		formdata.append('permenent_present',JSON.stringify(permenent_present));
		formdata.append('permenent_name',JSON.stringify(contact_person_name));
		formdata.append('permenent_relationship',JSON.stringify(contact_person_relationship));
		formdata.append('permenent_contact_no',JSON.stringify(contact_person_mobile_number));
		formdata.append('state',JSON.stringify(state));
		formdata.append('country',JSON.stringify(country));
		formdata.append('code',JSON.stringify(code));
		formdata.append('previos_address_id',previos_address_id);

		formdata.append('start_month',start_month);
		formdata.append('start_year',start_year);
		formdata.append('end_month',end_month);
		formdata.append('end_year',end_year);
		formdata.append('link_request_from',link_request_from);
		/*if (candidate_aadhar.length > 0) {
			for (var i = 0; i < candidate_aadhar.length; i++) { 
				formdata.append('candidate_rental[]',candidate_aadhar[i]);
			}
		}else{
			formdata.append('candidate_rental[]','');
		}
		if (candidate_pan.length > 0) {
			for (var i = 0; i < candidate_pan.length; i++) { 
				formdata.append('candidate_ration[]',candidate_pan[i]);
			}
		}else{
			formdata.append('candidate_ration[]','');
		}
		if (candidate_proof.length > 0) {
			for (var i = 0; i < candidate_proof.length; i++) { 
				formdata.append('candidate_gov[]',candidate_proof[i]);
			}
		}else{
			formdata.append('candidate_gov[]','');
		} */

		var rental_agreement = [];
		var ration_card = [];
		var gov_utility_bill = []; 
		$(".rental_agreement").each(function(){
			if ($(this).val() !='') {
				rental_agreement.push(1);
			}else{
				rental_agreement.push(0);
			}
		})
		
		$(".ration_card").each(function(){
			if ($(this).val() !='') {
				ration_card.push(1);
			}else{
				ration_card.push(0);
			}
		})
		
		$(".gov_utility_bill").each(function(){
			if ($(this).val() !='') {
				gov_utility_bill.push(1);
			}else{
				gov_utility_bill.push(0);
			}
		})

		formdata.append('rental_agreement',rental_agreement);
		formdata.append('ration_card',ration_card);
		formdata.append('gov_utility_bill',gov_utility_bill);


		if (candidate_aadhar.length > 0) {
		var a = 0;
		$.each(candidate_aadhar,function(index,value){ 
			$.each(value,function(index,val){ 
			if (candidate_aadhar[a][index].length > 0) {
			for (var c = 0; c < candidate_aadhar[a][index].length; c++) {
					formdata.append('candidate_rental'+a+'[]',candidate_aadhar[a][index][c]); 
					// alert(candidate_aadhar[a][index][c].name)
			} 	
			}else{
				// alert("false 1")
				formdata.append('candidate_rental[]','');
			}
		});
			a++;
		});
 
	}else{
		formdata.append('candidate_rental[]','');
		// alert("false 2")
	} 

 
		if (candidate_pan.length > 0) {
				var a = 0;
				$.each(candidate_pan,function(index,value){ 
					$.each(value,function(index,val){ 
					if (candidate_pan[a][index].length > 0) {
					for (var c = 0; c < candidate_pan[a][index].length; c++) {
							formdata.append('candidate_ration'+a+'[]',candidate_pan[a][index][c]); 
							// alert(candidate_aadhar[a][index][c].name)
					} 	
					}else{
						// alert("false 1")
						formdata.append('candidate_ration[]','');
					}
				});
					a++;
				});
		 
			}else{
				formdata.append('candidate_ration[]','');
				// alert("false 2")
			} 
 
		if (candidate_proof.length > 0) {
				var a = 0;
				$.each(candidate_proof,function(index,value){ 
					$.each(value,function(index,val){ 
					if (candidate_proof[a][index].length > 0) {
					for (var c = 0; c < candidate_proof[a][index].length; c++) {
							formdata.append('candidate_gov'+a+'[]',candidate_proof[a][index][c]); 
							// alert(candidate_aadhar[a][index][c].name)
					} 	
					}else{
						// alert("false 1")
						formdata.append('candidate_gov[]','');
					}
				});
					a++;
				});
		 
			}else{
				formdata.append('candidate_gov[]','');
				// alert("false 2")
			} 
 
		formdata.append('count',candidate_aadhar.length);

	$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
	$("#add_address").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$.ajax({
            type: "POST",
              url: base_url+"candidate/update_candidate_previous_address",
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
              	$("#warning-msg").html("");
              	$("#add_address").html("Save & Continue")
              }
            });

	}else{ 
		$(".permenent-house-flat").each(function(){
	 		var MyID = $(this).attr("id"); 
		   var number = MyID.match(/\d+/); 
			valid_street(number)
			valid_area(number) 
			valid_pincode(number)
			valid_city(number)
			// valid_state(number)
			valid_house_flat(number)
			valid_land_mark(number)
			// valid_start_date(number)
			// valid_end_date(number)
			valid_name(number)
			valid_relationship(number)
			// valid_contact_no(number) 
		});


			if (candidate_aadhar.length == 0 && rental_agreement =='') {
				$(".file-name1").html("<span class='text-danger error-msg-small'>Please Select min 1 file</span>");
			}	
	}
 });



function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}

 
function valid_pincode(id=''){ 
	var pincode = $("#permenent-pincode"+id).val();
	if (pincode !='') {
		if (isNaN(pincode)) {
			$("#permenent-pincode-error"+id).html('<span class="text-danger error-msg-small">Pin code should be only numbers.</span>');
			$("#permenent-pincode"+id).val(pincode.slice(0,-1));
			input_is_invalid("#permenent-pincode"+id);
		} else if (pincode.length != 6) {
			$("#permenent-pincode-error"+id).html('<span class="text-danger error-msg-small">Pin code should be of '+6+' digits.</span>');
			plenght = $("#permenent-pincode"+id).val(pincode.slice(0,6));
			input_is_invalid("#permenent-pincode"+id);
			if (plenght.length == 6) {
			$("#permenent-pincode-error"+id).html('');
			input_is_valid("#permenent-pincode"+id);	
			}
		} else {
			$("#permenent-pincode-error"+id).html('');
			input_is_valid("#permenent-pincode"+id);
		} 
	}else{
		$("#permenent-pincode-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid pincode</span>");
		input_is_invalid("#permenent-pincode"+id)
	}
} 
function valid_city(id){
 
	var city = $("#permenent-city"+id).val();
	if (city != '') {
		/*if (!alphabets_only.test(city)) {
			$("#permenent-city-error"+id).html('<span class="text-danger error-msg-small">City should be only alphabets.</span>');
			$("#permenent-city"+id).val(city.slice(0,-1));
			input_is_invalid("#permenent-city"+id);
		} else*/ if (city.length > vendor_name_length) {
			$("#permenent-city-error"+id).html('<span class="text-danger error-msg-small">City should be of max '+vendor_name_length+' characters.</span>');
			$("#permenent-city"+id).val(city.slice(0,vendor_name_length));
			input_is_invalid("#city"+id);
		} else {
			$("#permenent-city-error"+id).html('');
			input_is_valid("#permenent-city"+id);
		}
	} else {
		$("#permenent-city-error"+id).html('<span class="text-danger error-msg-small">Please enter city.</span>');
		input_is_invalid("#permenent-city"+id);
	}	
}
/*function valid_state(id=''){
	var state = $("#state"+id).val();
	if (state !='') {
		$("#state-error"+id).html("");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please select valid state</span>");
		input_is_invalid("#state"+id)
	}
}*/


function valid_state(id){
	var state = $("#state"+id).val();
	if (state !='') {
		var c_id = $("#state"+id).children('option:selected').data('id')
		
			$.ajax({
            type: "POST",
              url: base_url+"candidate/get_selected_cities/"+c_id, 
              dataType: 'json', 
              success: function(data) {
              	var html = '';
              	html +="<option>Select City</option>";
				if (data.length > 0) {
					for (var i = 0; i < data.length; i++) {
						html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
					}
				}
				$("#permenent-city"+id).html(html);
              }
            });
		$("#state-error"+id).html("");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please select valid state</span>");
		input_is_invalid("#state"+id)
	}
}


function valid_house_flat(id=''){
	var house_flat = $("#permenent-house-flat"+id).val();
	if (house_flat !='') {
		$("#permenent-house-flat-error"+id).html("");
		input_is_valid("#permenent-house-flat"+id)
	}else{
		$("#permenent-house-flat-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid house flat</span>");
		input_is_invalid("#permenent-house-flat"+id)
	}
}
function valid_land_mark(id=''){
	var land_mark = $("#permenent-land-mark"+id).val();
	if (land_mark !='') {
		$("#permenent-land-mark-error"+id).html("");
		input_is_valid("#permenent-land-mark"+id)
	}else{
		$("#permenent-land-mark-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid land mark</span>");
		input_is_invalid("#permenent-land-mark"+id)
	}
}

function valid_street(id=''){
		var street = $("#permenent-street"+id).val();
	if (street !='') {
		$("#permenent-street-error"+id).html("");
		input_is_valid("#permenent-street"+id)
	}else{
		$("#permenent-street-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid street</span>");
		input_is_invalid("#permenent-street"+id)
	}
}
function valid_area(id=''){
		var area = $("#permenent-area"+id).val();
	if (area !='') {
		$("#permenent-area-error"+id).html("");
		input_is_valid("#permenent-area"+id)
	}else{
		$("#permenent-area-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid area</span>");
		input_is_invalid("#permenent-area"+id)
	}
}
 

function valid_name(id=''){
	 
	var first_name = $("#permenent-name"+id).val();
	if (first_name != '') {
		if (!alphabets_only.test(first_name)) {
			$("#permenent-name-error"+id).html('<span class="text-danger error-msg-small">Name should be only alphabets.</span>');
			$("#permenent-name"+id).val(first_name.slice(0,-1));
			input_is_invalid("#permenent-name"+id);
		} else if (first_name > vendor_name_length) {
			$("#permenent-name-error"+id).html('<span class="text-danger error-msg-small">Name should be of max '+vendor_name_length+' characters.</span>');
			$("#permenent-name"+id).val(first_name.slice(0,vendor_name_length));
			input_is_invalid("#permenent-name"+id);
		} else {
			$("#permenent-name-error"+id).html('');
			input_is_valid("#permenent-name"+id);
		}
	} else {
		$("#permenent-name-error"+id).html('<span class="text-danger error-msg-small">Please enter name.</span>');
		input_is_invalid("#permenent-name"+id);
	}
}


function valid_relationship(id=''){
		var relationship = $("#relationship"+id).val();
	if (relationship !='') {
		$("#relationship-error"+id).html("");
		input_is_valid("#relationship"+id)
	}else{
		$("#relationship-error"+id).html("<span class='text-danger error-msg-small'>Please select valid relationship</span>");
		input_is_invalid("#relationship"+id)
	}
}
function valid_contact_no(id=''){
	var contact_no = $("#permenent-contact_no"+id).val();
	if (contact_no !='') {
		if (isNaN(contact_no)) {
			$("#permenent-contact_no-error"+id).html('<span class="text-danger error-msg-small">Contact number should be only numbers.</span>');
			$("#permenent-contact_no"+id).val(contact_no.slice(0,-1));
			input_is_invalid("#permenent-contact_no"+id);
		} else if (contact_no.length != 10) {
			$("#permenent-contact_no-error"+id).html('<span class="text-danger error-msg-small">Contact number should be of '+10+' digits.</span>');
			plenght = $("#permenent-contact_no"+id).val(contact_no.slice(0,10));
			input_is_invalid("#permenent-contact_no"+id);
			if (plenght.length == 10) {
			$("#permenent-contact_no-error"+id).html('');
			input_is_valid("#permenent-contact_no"+id);	
			}
		} else {
			$("#permenent-contact_no-error"+id).html('');
			input_is_valid("#permenent-contact_no"+id);
		} 
	}else{
		$("#permenent-contact_no-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid contact number</span>");
		input_is_invalid("#permenent-contact_no"+id)
	}
}

function valid_start_date(id=''){
	var start_date = $("#permenent-start-date"+id).val();
	if (start_date !='') {
		$("#permenent-start-date-error"+id).html("");
		input_is_valid("#permenent-start-date"+id)
	}else{
		$("#permenent-start-date-error"+id).html("<span class='text-danger error-msg-small'>Please select valid start date</span>");
		input_is_invalid("#permenent-start-date"+id)
	}
}
function valid_end_date(id=''){
	var end_date = $("#permenent-end-date"+id).val();
	if (end_date !='') {
		$("#permenent-end-date-error"+id).html("");
		input_is_valid("#permenent-end-date"+id)
	}else{
		$("#permenent-end-date-error"+id).html("<span class='text-danger error-msg-small'>Please select valid end date</span>");
		input_is_invalid("#permenent-end-date"+id)
	}
}




function removeFile_documents(id,param){
	// alert($("#remove_file_"+param+"_documents"+id).data('path'))
	$("#myModal-remove").modal('show');
	$("#remove-caption").html("<h4 class='text-danger'>Are you sure removing this "+param+" image?</h4>")
	$("#button-area").html('<a href="" data-dismiss="modal" class="exit-btn float-center text-center mr-1">Close</a><button class="btn btn-sm btn-danger text-white" onclick="image_remove('+id+',\''+param+'\')">remove</button>')

}


function image_remove(id,param){ 
var	table = 'previous_address';
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


function valid_countries(id){
	var country = $("#country"+id).val();
	if (country !='') {
		var c_id = $("#country"+id).children('option:selected').data('id')
		
			$.ajax({
            type: "POST",
              url: base_url+"candidate/get_selected_states/"+c_id, 
              dataType: 'json', 
              success: function(data) {
              	var html = '';
              	html +="<option>Select State</option>";
				if (data.length > 0) {
					for (var i = 0; i < data.length; i++) {
						html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
					}
				}
				$("#state"+id).html(html);
				 valid_state(id);
              }
            });
		$("#country-error"+id).html("");
		input_is_valid("#country"+id)
	}else{
		$("#country-error"+id).html("<span class='text-danger error-msg-small'>Please select valid country</span>");
		input_is_invalid("#country"+id)
	}
}