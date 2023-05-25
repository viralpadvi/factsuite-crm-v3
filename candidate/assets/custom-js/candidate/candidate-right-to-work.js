// 

var client_zip_lenght = 6;
var client_document_size = 20000000;
var max_client_document_select = 20;
var url_regex = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/,
	email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
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
	var candidate_aadhar = [];


$(".right_to_work_docs").on("change", handleFileSelect_candidate_aadhar);

function handleFileSelect_candidate_aadhar(e){
			var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1;  
	if (files.length <= max_client_document_select) {

		// alert(files.length)
	    	$("#right_to_work_docs-error"+number).html('');
	        $("#right_to_work_docs-error"+number).html('');
	        if (files[0].size <= client_document_size) {
	        	var html ='';
	        	var obj = [];
		        for (var i = 0; i < files.length; i++) {
		            var fileName = files[i].name; // get file name  
		            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
		            	 html = '<div id="file_candidate_aadhar_'+number+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+number+i+'" onclick="removeFile_candidate_aadhar('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+number+','+i+',\'candidate_aadhar'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
		                // candidate_proof.push(files[i]); 
		                obj.push(files[i]); 
		                $("#right_to_work_docs-error"+number).append(html);
		        	}

		        }
		        candidate_aadhar.push({[number]:obj}); 
		    } else {
		    	$("#right_to_work_docs-error"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
				$('#right_to_work_docs'+number).val('');
		    }
	    } else {
	    	$('#right_to_work_docs'+number).val('');
	        // $("#appointment_letter-img"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
	        $("#right_to_work_docs-error"+number).html('');
	    }
} 


function exist_view_image(image,path){
    $("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
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
    	$("#right_to_work_docs"+num).val('');
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




$("#candidate-right-to-work").on('click',function(){ 

	var document_number = [];
	$(".document_number").each(function(){
		document_number.push({document_number:$(this).val()});
	});
	var first_name = []; 
	$(".first-name").each(function(){
		first_name.push({first_name:$(this).val()});
	});
	var last_name = [];
	$(".last-name").each(function(){
		last_name.push({last_name:$(this).val()});
	});
	var dob = [];
	$(".date_of_birth").each(function(){
		dob.push({dob:$(this).val()});
	});
	var gender = [];
	$(".gender").each(function(){
		gender.push({gender:$(this).val()});
	});
	var mobile_number = [];
	$(".mobile_number").each(function(){
		mobile_number.push({mobile_number:$(this).val()});
	});
	 

	var right_to_work_id = $("#right_to_work_id").val();


	if ( document_number.length > 0 && first_name.length >0 && last_name.length >0 && dob.length >0 && gender.length > 0) {

	var formdata = new FormData();
	formdata.append('url',27);
	formdata.append('document_number',JSON.stringify(document_number));
	formdata.append('first_name',JSON.stringify(first_name));
	formdata.append('last_name',JSON.stringify(last_name)); 
	formdata.append('dob',JSON.stringify(dob)); 
	formdata.append('gender',JSON.stringify(gender)); 
	formdata.append('mobile_number',JSON.stringify(mobile_number)); 
	formdata.append('count',first_name.length); 
	formdata.append('link_request_from',link_request_from);
	if (right_to_work_id !='' && right_to_work_id !=null) {
		formdata.append('right_to_work_id',right_to_work_id); 
	}

		if (candidate_aadhar.length > 0) {
		var a = 0;
		$.each(candidate_aadhar,function(index,value){ 
			$.each(value,function(index,val){ 
			if (candidate_aadhar[a][index].length > 0) {
			for (var c = 0; c < candidate_aadhar[a][index].length; c++) {
					formdata.append('right_to_work'+a+'[]',candidate_aadhar[a][index][c]); 
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

$("#candidate-right-to-work").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
	$.ajax({
    type: "POST",
		url: base_url+"candidate/update_candidate_right_to_work",
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
      } else {
				toastr.error('Something went wrong while saving the data. Please try again.'); 	
      }
			$("#warning-msg").html("");
			$("#candidate-right-to-work").html("Save & Continue");
		}
	});

	}else{
		$(".name").each(function(){
		   // var MyID = $(this).attr("id"); 
		   // var number = MyID.match(/\d+/); 
		   valid_name()
		}); 
		$(".mdate").each(function(){
		   // var MyID = $(this).attr("id"); 
		   // var number = MyID.match(/\d+/); 
		   valid_date_of_birth()
		});  
		$(".father_name").each(function(){
			// var MyID = $(this).attr("id"); 
			// var number = MyID.match(/\d+/); 
			valid_father_name()
		}); 
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

 

function valid_name(id=''){
	 
	var name = $('#name'+id).val();
	if (name != '') {
		if (!alphabets_only.test(name)) {
			$('#name-error'+id).html('<span class="text-danger error-msg-small">Name should be only alphabets.</span>');
			$('#name'+id).val(name.slice(0,-1));
			input_is_invalid('#name'+id);
		} else if (name.length > vendor_name_length) {
			$('#name-error'+id).html('<span class="text-danger error-msg-small">Name should be of max '+vendor_name_length+' characters.</span>');
			$('#name'+id).val(name.slice(0,vendor_name_length));
			input_is_invalid('#name');
		} else {
			$('#name-error'+id).html('');
			input_is_valid('#name'+id);
		}
	} else {
		$('#name-error'+id).html('<span class="text-danger error-msg-small">Please enter name.</span>');
		input_is_invalid('#name'+id);
	}
}

/*
function valid_father_name(id=''){
	var father_name = $("#father_name"+id).val();
	if (father_name !='') {
		$("#father_name-error"+id).html("");
		input_is_valid("#father_name"+id)
	}else{
		$("#father_name-error"+id).html("<span class='text-danger error-msg-small'>Please Select Valid father's name.</span>");
		input_is_invalid("#father_name"+id)
	}
}
*/



function valid_father_name(){
	 
	var father_name = $('#father_name').val();
	if (father_name != '') {
		if (!alphabets_only.test(father_name)) {
			$('#father_name-error').html('<span class="text-danger error-msg-small">Father name should be only alphabets.</span>');
			$('#father_name').val(father_name.slice(0,-1));
			input_is_invalid('#father_name');
		} else {
			$('#father_name-error').html('');
			input_is_valid('#father_name');
		}
	} else {
		$('#father_name-error').html('<span class="text-danger error-msg-small">Please add a father name.</span>');
		input_is_invalid('#father_name');
	}
}

 

function valid_date_of_birth(id=''){
	var date_of_birth = $("#date_of_birth"+id).val();
	if (date_of_birth !='') {
		$("#date_of_birth-error"+id).html("");
		input_is_valid("#date_of_birth"+id)
	}else{
		input_is_invalid("#date_of_birth"+id)
		$("#date_of_birth-error"+id).html("<span class='text-danger error-msg-small'>Please enter valid date of birth</span>");
	}
}

function valid_document($id){
	var document_no = $("#document_number"+$id).val();
	var no = $("#document_number"+$id).data('id');
	 

		if (no ==2) {
       		valid_aadhar_no($id);
       	}else if (no ==3) {
       		valid_passport_no($id);
       	}else if (no ==4) {
       		valid_document_number($id);
       	}else if (no ==5) {
       		valid_ssn_no($id);
       	} 
	/*valid_aadhar_no();
valid_pan_no();
valid_passport_no();
valid_document_number();
valid_ssn_no();*/
}



function valid_aadhar_no($id){
	var aadhar = $("#document_number"+$id).val();
	if (aadhar !='') {
		if (isNaN(aadhar)) {
			$("#document_number-error"+$id).html('<span class="text-danger error-msg-small">Aadhar number should be only numbers.</span>');
			$("#document_number"+$id).val(aadhar.slice(0,-1));
			input_is_invalid("#document_number"+$id);
		} else if (aadhar.length != 12) {
			$("#document_number-error"+$id).html('<span class="text-danger error-msg-small">Aadhar number should be of '+12+' digits.</span>');
			var plenght = $("#document_number"+$id).val(aadhar.slice(0,12));
			input_is_invalid("#document_number"+$id);
			if (plenght.length == 12) {
			$("#document_number-error"+$id).html('');
			input_is_valid("#document_number"+$id);	
			}
		} else {
			$("#document_number-error"+$id).html('');
			input_is_valid("#document_number"+$id);
		} 
	}else{
		$("#document_number-error"+$id).html("<span class='text-danger error-msg-small'>Please enter valid aadhar number</span>");
		input_is_invalid("#document_number"+$id)
	}
}

function valid_pan_no($id){
	var pan = $("#document_number"+$id).val();
	if (pan !='') {
		if (pan.length != 10) {
			$("#document_number-error"+$id).html('<span class="text-danger error-msg-small">Pan number should be of '+10+' digits.</span>');
			var plenght = $("#document_number"+$id).val(pan.slice(0,10));
			input_is_invalid("#document_number"+$id);
			if (plenght.length == 10) {
			$("#document_number-error"+$id).html('');
			input_is_valid("#document_number"+$id);	
			}
		} else {
			$("#document_number-error"+$id).html('');
			input_is_valid("#document_number"+$id);
		} 
	}else{
		$("#document_number-error"+$id).html("<span class='text-danger error-msg-small'>Please enter valid pan number</span>");
		input_is_invalid("#document_number"+$id)
	}
}

function valid_passport_no(){
	var passport = $("#document_number"+$id).val();
	if (passport !='') {
		if (passport.length > 9) {
			$("#document_number-error"+$id).html('<span class="text-danger error-msg-small">Passport number should be of '+9+' digits.</span>');
			var plenght = $("#document_number"+$id).val(passport.slice(0,9));
			input_is_invalid("#document_number"+$id);
			if (plenght.length == 9) {
			$("#document_number-error"+$id).html('');
			input_is_valid("#document_number"+$id);	
			}
		} else {
			$("#document_number-error"+$id).html('');
			input_is_valid("#document_number"+$id);
		} 
	}else{
		$("#document_number-error"+$id).html("<span class='text-danger error-msg-small'>Please enter valid passport number</span>");
		input_is_invalid("#document_number"+$id)
	}
}

function valid_document_number($id) {
	var document_number = $("#document_number"+$id).val();
	if (document_number !='') {
		if (document_number.length > 10) {
			$("#document_number-error"+$id).html('<span class="text-danger error-msg-small">Voter ID should be of '+10+' digits.</span>');
			var plenght = $("#document_number"+$id).val(document_number.slice(0,10));
				input_is_invalid("#document_number"+$id);
			if (plenght.length == 10) {
				$("#document_number-error"+$id).html('');
				input_is_valid("#document_number"+$id);	
			}
		} else {
			$("#document_number-error"+$id).html('');
			input_is_valid("#document_number"+$id);
		} 
	}else{
		$("#document_number-error"+$id).html("<span class='text-danger error-msg-small'>Please enter valid Voter ID</span>");
		input_is_invalid("#document_number"+$id)
	}
}

function valid_ssn_no($id) {
	var pan = $("#document_number"+$id).val();
	if (pan !='') {
		if (pan.length != 9) {
			$("#document_number-error"+$id).html('<span class="text-danger error-msg-small">SSN number should be of '+9+' digits.</span>');
				var plenght = $("#document_number"+$id).val(pan.slice(0,9));
				input_is_invalid("#document_number"+$id);
			if (plenght.length == 9) {
				$("#document_number-error"+$id).html('');
				input_is_valid("#document_number"+$id);	
			}
		} else {
			$("#document_number-error"+$id+$id).html('');
			input_is_valid("#document_number"+$id+$id);
		} 
	}else{
		$("#document_number-error"+$id).html("<span class='text-danger error-msg-small'>Please enter valid SSN number</span>");
		input_is_invalid("#document_number"+$id)
	}
}

function valid_contact(id){
		var manager_contact = $("#mobile_number"+id).val();
			if (manager_contact !='') {
				if (isNaN(manager_contact)) {
					$("#mobile_number-error"+id).html('<span class="text-danger error-msg-small">contact number should be only numbers.</span>');
					$("#mobile_number"+id).val(manager_contact.slice(0,-1));
					input_is_invalid("#mobile_number"+id);
				} else if (manager_contact.length != 10) {
					$("#mobile_number-error"+id).html('<span class="text-danger error-msg-small">contact number should be of '+10+' digits.</span>');
					plenght = $("#mobile_number"+id).val(manager_contact.slice(0,10));
					input_is_invalid("#mobile_number"+id);
					if (plenght.length == 10) {
					$("#mobile_number-error"+id).html('&nbsp;');
					input_is_valid("#mobile_number"+id);	
					} 
				} else{
					$("#mobile_number-error"+id).html('&nbsp;');
					input_is_valid("#mobile_number"+id);
				}
		}else{
			input_is_invalid("#mobile_number"+id)
			$("#mobile_number-error"+id).html("<span class='text-danger error-msg-small'>Please enter a valid contact number</span>");
		}
	}