// 


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

var client_zip_lenght = 6;
var client_document_size = 20000000;
var max_client_document_select = 20;
var nric =[]; 


$("#file1").on("change", handleFileSelect_nric);


function handleFileSelect_nric(e){ 
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
	            	 html = '<div id="file_nric_'+i+'"><span>'+fileName+' <a id="file_nric'+i+'" onclick="removeFile_nric('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'nric\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                nric.push(files[i]);
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


function removeFile_nric(id) {

    var file = $('#file_nric'+id).data("file");
    for(var i = 0; i < nric.length; i++) {
        if(nric[i].name === file) {
            nric.splice(i,1); 
        }
    }
    if (nric.length == 0) {
    	$("#file1").val('');
    }
    $('#file_nric_'+id).remove(); 
}


function view_image(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(nric[id]);
}



function exist_view_image(image,path){
    $("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}


$("#nric_number").on('keyup blur change',valid_nric);
$("#joining-date").on('keyup blur change',valid_joining_date);
	$("#relieving-date").on('keyup blur change',valid_relieving_date);
		function valid_joining_date(){
		var joining_date = $("#joining-date").val();
			if (joining_date !='') {
				$("#relieving-date").attr('disabled',false);
			$("#joining-date-error").html("");
			input_is_valid("#joining-date")
		}else{
			input_is_invalid("#joining-date")
			$("#joining-date-error").html("<span class='text-danger error-msg-small'>Please enter valid Issue date</span>");
		}
	}
	function valid_relieving_date(){
		var relieving_date = $("#relieving-date").val();
		if (relieving_date != '') {
			$("#relieving-date-error").html("");
			input_is_valid("#relieving-date")
		}else{
			input_is_invalid("#relieving-date")
			$("#relieving-date-error").html("<span class='text-danger error-msg-small'>Please enter valid Expiry date</span>");
		}
	}


	function valid_nric(){
		var manager_contact = $("#nric_number").val();
			if (manager_contact !='') {
				if (isNaN(manager_contact)) {
					$("#nric_number-error").html('<span class="text-danger error-msg-small">NRIC number should be only numbers.</span>');
					$("#nric_number").val(manager_contact.slice(0,-1));
					input_is_invalid("#nric_number");
				} else if (manager_contact.length != 9) {
					$("#nric_number-error").html('<span class="text-danger error-msg-small">NRIC number should be of '+9+' digits.</span>');
					var plenght = $("#nric_number").val(manager_contact.slice(0,9));
					input_is_invalid("#nric_number");
					// alert(plenght.length)
					if (plenght.length == 9) {
					$("#nric_number-error").html('');
					input_is_valid("#nric_number");	
					} 
				}else{
						$("#nric_number-error").html('');
					input_is_valid("#nric_number");	
				}
		}else{
			input_is_invalid("#nric_number")
			$("#nric_number-error").html("<span class='text-danger error-msg-small'>Please enter valid NRIC Number</span>");
		}
	}

$("#candidate-nric").on('click',function(){ 

	var nric_id = $("#nric_id").val();  
	var nric_number = $("#nric_number").val();  
	var gender = $("#gender").val();
	var joining_date = $("#joining-date").val();
 	var relieving_date = $("#relieving-date").val();


	if (nric_number !='' && joining_date !='' && relieving_date !='' ) {

		   var nric_doc = $("#nric-docs").val();

	var formdata = new FormData();
        
        if (nric.length > 0 ) {
            for (var i = 0; i < nric.length; i++) { 
                formdata.append('nric[]',nric[i]);
            }
        }else{
            formdata.append('nric[]','');
        } 

	formdata.append('url',32);
	formdata.append('nric_number',nric_number);
	formdata.append('joining_date',joining_date);
	formdata.append('relieving_date',relieving_date); 
	formdata.append('gender',gender); 
	formdata.append('link_request_from',link_request_from);
	if (nric_id !='' && nric_id !=null) {
		formdata.append('nric_id',nric_id); 
	}
$("#candidate-nric").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
	$.ajax({
    type: "POST",
		url: base_url+"candidate/update_candidate_nric",
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
			$("#candidate-nric").html("Save & Continue");
		}
	});

	}else{
	 
		  valid_joining_date();
valid_relieving_date();
		valid_nric(); 
		 
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
