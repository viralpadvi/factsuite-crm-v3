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



$(".all_sem_marksheet").on("change", handleFileSelect_candidate_aadhar);
$(".convocation").on("change", handleFileSelect_candidate_pan);
$(".marksheet_provisional_certificate").on("change", handleFileSelect_candidate_proof);
$(".ten_twelve_mark_card_certificate").on("change", handleFileSelect_candidate_bank);

function handleFileSelect_candidate_aadhar(e){
			var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1;  
	if (files.length <= max_client_document_select) {

		// alert(files.length)
	    	$("#all_sem_marksheet-img"+number).html('');
	        $("#all_sem_marksheet-error"+number).html('');
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
	}else{
		tmp_array.push(candidate_aadhar[i])
	}

    }

    candidate_aadhar = tmp_array; 

    if (candidate_aadhar.length == 0) {
    	$("#all_sem_marksheet"+num).val('');
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
	}else{
		tmp_array.push(candidate_pan[i])
	}

    }

    candidate_pan = tmp_array; 

    if (candidate_pan.length == 0) {
    	$("#convocation"+num).val('');
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
	}else{
		tmp_array.push(candidate_proof[i])
	}

    }

    candidate_proof = tmp_array; 

    if (candidate_proof.length == 0) {
    	$("#marksheet_provisional_certificate"+num).val('');
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
	           $("#view-img").html("<img class='w-100' src='"+event.target.result+"'>");
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
	}else{
		tmp_array.push(candidate_bank[i])
	}

    }

    candidate_bank = tmp_array; 

    if (candidate_bank.length == 0) {
    	$("#ten_twelve_mark_card_certificate"+num).val('');
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
/*
$("#file1").on("change", handleFileSelect_candidate_aadhar);
$("#file2").on("change", handleFileSelect_candidate_pan);
$("#file3").on("change", handleFileSelect_candidate_proof);
$("#file4").on("change", handleFileSelect_candidate_bank); 

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
} */

function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}


function exist_view_image(image,path){
	$("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}

 

 


$("#add-education-details").on('click',function(){ 

var time = [];
$('.part_time:checked').each(function(){
	time.push({type_of_course:$(this).val()});
});

var type_of_degree = [];
var edu_count = 0;
$('.type_of_degree').each(function(){
	edu_count++;
	if ($(this).val() !='') {
		type_of_degree.push({type_of_degree:$(this).val()});
	}else{
		type_of_degree.push({type_of_degree:'-'});
	}
});

var major = []; 
$('.major').each(function(){
	
	if ($(this).val() !='') {
		major.push({major:$(this).val()});
	}else{
		major.push({major:'-'});
	}
});

var university = []; 
$('.university').each(function(){
	if ($(this).val() !='') {
	university.push({university_board:$(this).val()});
	}
});

var college_name = []; 
$('.college_name').each(function(){
	if ($(this).val() !='') {
	college_name.push({college_school:$(this).val()});
	}
});

var address = []; 
$('.address').each(function(){
	if ($(this).val() !='') {
	address.push({address_of_college_school:$(this).val()});
	}
});

var duration_of_course = [];  
$('.duration_of_course').each(function(){
	if ($(this).val() !='') {
	duration_of_course.push({course_end_date:$(this).val()});
	}
});

var registration_roll_number = []; 
$('.registration_roll_number').each(function(){
	if ($(this).val() !='') {
	registration_roll_number.push({registration_roll_number:$(this).val()});
	}
});

var duration_of_stay = []; 
$('.duration_of_stay').each(function(){
	if ($(this).val() !='') {
	duration_of_stay.push({course_start_date:$(this).val()});
	}
});


var start_month = [];
$(".duration-of-stay-from-month").each(function(){ 
	if ($(this).val() !='') {
	start_month.push($(this).val()); 
	}
});

var start_year = [];
$(".duration-of-stay-from-year").each(function(){ 
	if ($(this).val() !='') {
	start_year.push($(this).val()); 
	}
});

var end_month = [];
$(".duration-of-stay-end-month").each(function(){ 
	if ($(this).val() !='') {
	end_month.push($(this).val()); 
	}
});

var end_year = [];
$(".duration-of-stay-end-year").each(function(){ 
	if ($(this).val() !='') {
	end_year.push($(this).val()); 
	}
});

		var all_sem_marksheet = $(".all_sem_marksheets").val();
		var convocation = $(".convocations").val();
		var marksheet_provisional_certificate = $(".marksheet_provisional_certificates").val();
		var ten = $(".ten").val();

  
	if (
	start_month.length ==edu_count &&
	start_year.length ==edu_count &&
	end_month.length ==edu_count &&
	end_year.length ==edu_count &&
	time.length ==edu_count &&
	type_of_degree.length ==edu_count && 
	university.length ==edu_count &&
	college_name.length ==edu_count &&
	address.length ==edu_count && 
	registration_roll_number.length ==edu_count 
	 &&( (candidate_bank.length > 0 || (ten !='' && ten !=null)) ||
	(candidate_aadhar.length > 0 || (all_sem_marksheet !='' && all_sem_marksheet !=null)) ||
	(candidate_pan.length > 0 ||(convocation !='' && convocation !=null)) ||
	(candidate_proof.length > 0 ||(marksheet_provisional_certificate !='' && marksheet_provisional_certificate !=null)) ) ){

		var formdata = new FormData();
		formdata.append('url',7);
		formdata.append('time',JSON.stringify(time));
		formdata.append('type_of_degree',JSON.stringify(type_of_degree));
		formdata.append('major',JSON.stringify(major));
		formdata.append('university',JSON.stringify(university));
		formdata.append('college_name',JSON.stringify(college_name));
		formdata.append('address',JSON.stringify(address));
		formdata.append('duration_of_course',JSON.stringify(duration_of_course));
		formdata.append('registration_roll_number',JSON.stringify(registration_roll_number));
		formdata.append('duration_of_stay',JSON.stringify(duration_of_stay));

		formdata.append('start_month',start_month);
		formdata.append('start_year',start_year);
		formdata.append('end_month',end_month);
		formdata.append('end_year',end_year);
		formdata.append('link_request_from',link_request_from);
		
		var marksheet =[];
		$(".all_sem_marksheet").each(function(){
			if ($(this).val() !='' && $(this).val() !=null ) {
				marksheet.push(1);
			}else{
				marksheet.push(0);
			}
		})
		var convocation =[];
		$(".convocation").each(function(){
			if ($(this).val() !='' && $(this).val() !=null ) {
				convocation.push(1);
			}else{
				convocation.push(0);
			}
		})
		var certificate = [];
		$(".marksheet_provisional_certificate").each(function(){
			if ($(this).val() !='' && $(this).val() !=null ) {
				certificate.push(1);
			}else{
				certificate.push(0);
			}
		})
		var ten_twelve = [];
		$(".ten_twelve_mark_card_certificate").each(function(){
			if ($(this).val() !='' && $(this).val() !=null ) {
				ten_twelve.push(1);
			}else{
				ten_twelve.push(0);
			}
		})

 
		if (candidate_aadhar.length > 0) {
		var a = 0;
		var count = 1;
		$.each(candidate_aadhar,function(index,value){ 
			$.each(value,function(index,val){ 
			if (candidate_aadhar[a][index].length > 0) {
			for (var c = 0; c < candidate_aadhar[a][index].length; c++) {
					formdata.append('all_sem_marksheet'+a+'[]',candidate_aadhar[a][index][c]); 
					// alert(candidate_aadhar[a][index][c].name)
					count++;
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
							formdata.append('convocation'+a+'[]',candidate_pan[a][index][c]); 
							// alert(candidate_aadhar[a][index][c].name)
					} 	
					}else{
						// alert("false 1")
						// formdata.append('convocation[]','');
					}
				});
					a++;
				});
		 
			}else{
				// formdata.append('convocation[]','');
				// alert("false 2")
			} 
 
		if (candidate_proof.length > 0) {
				var a = 0;
				$.each(candidate_proof,function(index,value){ 
					$.each(value,function(index,val){ 
					if (candidate_proof[a][index].length > 0) {
					for (var c = 0; c < candidate_proof[a][index].length; c++) {
							formdata.append('marksheet_provisional_certificate'+a+'[]',candidate_proof[a][index][c]); 
							// alert(candidate_aadhar[a][index][c].name)
					} 	
					}else{
						// alert("false 1")
						// formdata.append('marksheet_provisional_certificate[]','');
					}
				});
					a++;
				});
		 
			}else{
				// formdata.append('marksheet_provisional_certificate[]','');
				// alert("false 2")
			} 

 
		if (candidate_bank.length > 0) {
				var a = 0;
				$.each(candidate_bank,function(index,value){ 
					$.each(value,function(index,val){ 
					if (candidate_bank[a][index].length > 0) {
					for (var c = 0; c < candidate_bank[a][index].length; c++) {
							formdata.append('ten_twelve_mark_card_certificate'+a+'[]',candidate_bank[a][index][c]); 
							// alert(candidate_aadhar[a][index][c].name)
					} 	
					}else{
						// alert("false 1")
						// formdata.append('ten_twelve_mark_card_certificate[]','');
					}
				});
					a++;
				});
		 
			}else{
				// formdata.append('ten_twelve_mark_card_certificate[]','');
				// alert("false 2")
			} 
		formdata.append('count',candidate_aadhar.length);
		formdata.append('pan_count',candidate_pan.length);
		formdata.append('proof_count',candidate_proof.length);
		formdata.append('bank_count',candidate_bank.length);

		formdata.append('marksheet',marksheet);
		formdata.append('convocation',convocation);
		formdata.append('certificate',certificate);
		formdata.append('ten_twelve',ten_twelve);









		var education_details_id = $("#education_details_id").val();
		if (education_details_id !='' && education_details_id !=null) {
			formdata.append('education_details_id',education_details_id);
		}
		$("#add-education-details").attr('disabled',true);
		$("#add-education-details").css('pointer','none');


$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
$("#add-education-details").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
		
		$.ajax({
	            type: "POST",
	              url: base_url+"candidate/update_candidate_education_details",
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
	              	$("#add-education-details").attr('disabled',false);
					$("#add-education-details").removeCss('pointer');
					$("#add-education-details").html("Save & Continue")
	              }
	            });
	}else{
		 
		$('.type_of_degree').each(function(){
			var MyID = $(this).attr("id"); 
				var number = MyID.match(/\d+/);
				valid_type_of_degree(number)
		}); 
		$('.major').each(function(){
			var MyID = $(this).attr("id"); 
				var number = MyID.match(/\d+/);
				valid_major(number)
		}); 
		$('.university').each(function(){
			var MyID = $(this).attr("id"); 
				var number = MyID.match(/\d+/);
				valid_university(number)
		}); 
		$('.college_name').each(function(){
			var MyID = $(this).attr("id"); 
				var number = MyID.match(/\d+/);
				valid_college_name(number)
		}); 
		$('.address').each(function(){
			var MyID = $(this).attr("id"); 
				var number = MyID.match(/\d+/);
				valid_address(number)
		});  
		$('.duration_of_course').each(function(){
			var MyID = $(this).attr("id"); 
				var number = MyID.match(/\d+/);
				valid_end_date(number)
		}); 

		$('.duration_of_stay').each(function(){
			var MyID = $(this).attr("id"); 
				var number = MyID.match(/\d+/);
				valid_duration_of_stay(number)
		});	

		$('.registration_roll_number').each(function(){
			var MyID = $(this).attr("id"); 
				var number = MyID.match(/\d+/);
				valid_registration_roll_number(number)
		}); 

		if((candidate_aadhar.length ==0 || (all_sem_marksheet =='')) && (candidate_pan.length ==0 ||(convocation =='')) && ( candidate_proof.length==0 || (marksheet_provisional_certificate =='')) && ( candidate_bank.length==0 ||(ten =='')) ){
			$("#warning-msg").html("<span class='text-danger error-msg-small'>Please enter all details and upload required documents.</span>");
		}
	}

});


function valid_type_of_degree(id){
	var type_of_degree = $("#type_of_degree"+id).val();
	if (type_of_degree !='') {
		$("#type_of_degree-error"+id).html("");
		input_is_valid("#type_of_degree"+id)
	}else{
		input_is_invalid("#type_of_degree"+id)
		$("#type_of_degree-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid type of degree</span>");
	}
}

function valid_major(id){
	var major = $("#major"+id).val();
	if (major !='') {
		$("#major-error"+id).html("");
		input_is_valid("#major"+id)
	}else{
		input_is_invalid("#major"+id)
		$("#major-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid major</span>");
	}
}

function valid_university(id){
	var university = $("#university"+id).val();
	if (university !='') {
		$("#university-error"+id).html("");
		input_is_valid("#university"+id)
	}else{
		input_is_invalid("#university"+id)
		$("#university-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid "+$("#university"+id).data('board_or_university')+" name</span>");
	}
}

function valid_college_name(id){
	var college_name = $("#college_name"+id).val();
	if (college_name !='') {
		$("#college_name-error"+id).html("");
		input_is_valid("#college_name"+id);
	}else{
		input_is_invalid("#college_name"+id);
		$("#college_name-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid "+$("#college_name"+id).data('school_or_college')+" name</span>");
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

function valid_duration_of_stay(id){
	var duration_of_stay = $("#duration_of_stay"+id).val();
	if (duration_of_stay !='') {
		$("#duration_of_stay-error"+id).html("");
		input_is_valid("#duration_of_stay"+id)
	}else{
		input_is_invalid("#duration_of_stay"+id)
		$("#duration_of_stay-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid duration of stay</span>");
	}
}

function valid_end_date(id){
	var end_date = $("#end-date"+id).val();
	if (end_date !='') {
		$("#end-date-error"+id).html("");
		input_is_valid("#end-date"+id)
	}else{
		input_is_invalid("#end-date"+id)
		$("#end-date-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid end date</span>");
	}
}

function valid_registration_roll_number(id){
	var registration_roll_number = $("#registration_roll_number"+id).val();
	if (registration_roll_number !='') {
		$("#registration_roll_number-error"+id).html("");
		input_is_valid("#registration_roll_number"+id)
	}else{
		input_is_invalid("#registration_roll_number"+id)
		$("#registration_roll_number-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid registration / roll number</span>");
	}
}



function removeFile_documents(id,param){
	// alert($("#remove_file_"+param+"_documents"+id).data('path'))
	$("#myModal-remove").modal('show');
	$("#remove-caption").html("<h4 class='text-danger'>Are you sure removing this image?</h4>")
	$("#button-area").html('<a href="" data-dismiss="modal" class="exit-btn float-center text-center mr-1">Close</a><button class="btn btn-sm btn-danger text-white" onclick="image_remove('+id+',\''+param+'\')">remove</button>')

}


function image_remove(id,param){ 
var	table = 'education_details';
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
				// toastr.success('successfully removing image.');  
				$("#"+param+id).remove(); 
          	}else{
          		toastr.error('Something went wrong while removing this image. Please try again.'); 	
          	} 
          	$("#myModal-remove").modal('hide');
          }
    });
}