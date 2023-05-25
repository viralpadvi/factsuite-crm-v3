var client_docs =[];
var client_zip_lenght = 6;
var client_document_size = 20000000;
var max_client_document_select = 20;
var vendor_name_length = 100, 
	city_name_length = 100,
	vendor_zip_code_length = 6,
	vendor_monthly_quota_length = 5, 
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

get_form_fields();
function get_form_fields() {
	$.ajax({
	    type:'POST',
	    url: base_url+'factsuite-admin/get-all-form-fields',
	    dataType: 'JSON',
	    data: {
	    	verify_admin_request : 1
	    },
	    success:function(data) {
	    	var form_fields_list_html = '';
	  		if (data.length > 0) {
	  			for (var i = 0; i < data.length; i++) {
	  				form_fields_list_html += '<div class="col-md-4 custom-col-1">';
	  				form_fields_list_html += '<span class="form-field-span" onclick="get_form_field('+data[i].id+')">'+data[i].show_field_name+'</span>';
	  				form_fields_list_html += '</div>';
	  			}
	  		}
	      	$('#form-field-details').html(form_fields_list_html);
	    }
  	});
}

function get_form_field(id) {
	var consent = CKEDITOR.instances['client-consent'].getData().replace(/(<([^>]+)>)/ig,"");
	$.ajax({
	    type:'POST',
	    url: base_url+'factsuite-admin/get-all-form-fields',
	    dataType: 'JSON',
	    data: {
	    	verify_admin_request : 1
	    },
	    success:function(data) {
	  		if (data.length > 0) {
	  			for (var i = 0; i < data.length; i++) {
	  				if (data[i].id == id) {
	  					consent += data[i].show_field_name+'&nbsp;';
	  					break;
	  				}
	  			}
	  		}
	  		CKEDITOR.instances['client-consent'].setData(consent);
	  		$('#client-consent').focus();
	    }
  	});
}

$("#client-documents").on("change", handleFileSelect_client_documents);

function handleFileSelect_client_documents(e) {
	// alert("hello")
	client_docs =[];
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var i = 1; 
    if (files.length <= max_client_document_select) {
        // $("#selected-client-docs-li").html('');
        if (files[0].size <= client_document_size) {
        	$("#selected-vendor-docs-li").html('')
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name  
	           /* var html = '<div class="col-md-4 mt-1 mt-3" id="file_client_documents_'+i+'">'+
	                    '<div class="image-selected-div">'+
	                        '<ul>'+
	                            '<li>'+fileName+'</li>'+
	                            '<li>'+
	                                '<a id="file_client_documents'+i+'" onclick="removeFile_client_documents('+i+')" data-file="'+fileName+'" class="image-name-delete-a"><i class="fa fa-times text-danger"></i></a>'+
	                            '</li>'+
	                        '</ul>'+
	                    '</div>'+
	                '</div>'; */
	                var fileName = files[i].name; // get file name 
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div  class="image-selected-div mr-2 mb-2" id="file_client_documents_'+i+'"><span>'+fileName+' <a id="file_candidate_aadhar'+i+'" onclick="removeFile_client_documents('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'client_docs\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                // candidate_aadhar.push(files[i]);
	                // $(".file-name1").append(html);
	        	} 
	                $("#selected-vendor-docs-li").append(html);
	                client_docs.push(files[i]);
	        }
	    } else {
	    	$("#client-upoad-docs-error-msg-div").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#client-documents').val('');
	    }
    } else {
        $("#selected-client-docs-li").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function view_image(id,text){ 
	$("#consent-form").modal('show');
	 var file = $('#file_'+text+id).data("file");   
	 	 if (typeof client_docs[id] !='undefined') {
	 	 	var reader = new FileReader();
	        reader.onload = function(event) {
	           $("#consent-sign").html("<img class='mx-auto d-block' height='200' src='"+event.target.result+"'>");
	        };
	        reader.readAsDataURL(client_docs[id]); 
	 }
	    
}
 

 function removeFile_client_documents(id) {
    var file = $('#file_client_documents'+id).data("file");
    for(var i = 0; i < client_docs.length; i++) {
        if(client_docs[i].name === file) {
            client_docs.splice(i,1); 
        }
    }
    $('#file_client_documents_'+id).remove();
    $("#client-documents").val('');
}

// getTatData();
$("#client_id").trigger('change')
function getTatData(client_id){

	// CKEDITOR.instances['client-consent'].setData('');
	$('#client-additional').val(''); 
	$(".change_client_additional").prop("checked", false);
	$("#selected-vendor-docs-li").html('');
	if (client_id =='') {
		client_id = $("#client_id").val();
		$('#client-logo-div').addClass('d-none');
	} else {
		$('#client-logo-div').removeClass('d-none');
	}
	$.ajax({
		type:'POST',
		dataType:'json',
		url:base_url+"client/get_consent_logo",
		data:{
			client_id:client_id
		},
		success:function(data){  

			$html = '';
			if (data.data !=null) {
			if (data.data.consent !=null && data.data.consent !='') {
				CKEDITOR.instances['client-consent'].setData(data.data.consent);
			}
			$('#client-additional').val(data.data.aad_on_suggestion); 
			// CKEDITOR.instances['client-additional'].setData();
			$html += "<img class='w-100' src='"+img_base_url+"../uploads/client-docs/"+data.data.fs_logo+"'>";
			$html += '<div  class="image-selected-div mr-2 mb-2" ><a class="w-100"  height="200" onclick="get_preview(\''+data.data.fs_logo+'\')" >'+data.data.fs_logo+'<i class="fa fa-eye"></i></a></div>';

			if (data.data.additional ==1) { 
				$(".change_client_additional").prop("checked", true);
			}

		}
			$("#selected-vendor-docs-li").html($html);
			var client = data.client;
			var client_location =[];
			if (client.location !='' && client.location !=null) {
				client_location = client.location.split(',');
			}
			var client_segment =[];
			if (client.client_segment !='' && client.client_segment !=null) {
				client_location = client.client_segment.split(',');
			}

			var location = '';
			if (data.location.length > 0) {
				for (var i = 0; i < data.location.length; i++) { 
					var select = '';
					if ($.inArray(data.location[i].location_name, client_location) !== -1) {
						select = 'selected';
					}
					location += '<option '+select+' value="'+data.location[i].location_name+'">'+data.location[i].location_name+'</option>';
				}
			}else{
				$("#location").html("");
			}
				var segment = '';
				if (data.segment.length > 0) {
					for (var i = 0; i < data.segment.length; i++) { 
						var select = '';
						if ($.inArray(data.segment[i].segment_name, client_segment) !== -1) {
							select = 'selected';
						}
					segment += '<option '+select+' value="'+data.segment[i].segment_name+'">'+data.segment[i].segment_name+'</option>';
					}
				}else{
					$("#segment").html("");
				}
				$("#location").html(location);
				$("#segment").html(segment);
		} 


	});
} 
 /*
  $('#location').onChange(function(){  
  	var client_id = $("#client_id").val();
               $.ajax({
            type: "POST",
              url: base_url+"Custom_Util/get_location/",
              data:{client_id:client_id},
              dataType: 'json', 
              success: function(data) {
                  
              }
          });
    }); 
      
    $('#segment').onChange(function(){ 
    	var client_id = $("#client_id").val();
        $.ajax({
            type: "POST",
              url: base_url+"Custom_Util/get_segment/",
              data:{client_id:client_id},
              dataType: 'json', 
              success: function(data) {
                
              }
          });
    }); */


	 function add_location(param){
	 	var client_id = $("#client_id").val();
	 	if (client_id =='' || client_id ==null) {
	 		return false;
	 	}
		 $.ajax({
            type: "POST",
              url: base_url+"client/insert_location/",
              data:{location:param,client_id:client_id},
              dataType: 'json', 
              success: function(data) {
                if (data.status == '1') {  
                	$('.select2-search__field').val(''); 
                	 $(".select2-results__options").hide();
                	$("#location").append('<option selected value="'+param+'">'+param+'</option>')
                	toastr.success('New add location has been successfully.');
                	  $("#div-location").hide()
                	sessionStorage.clear();  
                }else{ 
                	$("#package-component-error").html("");
                	toastr.error('Something went wrong while add location. Please try again.'); 
                }  
              }
          });
	} 

	  function add_segment(param){
	  	var client_id = $("#client_id").val();
	 	if (client_id =='' || client_id ==null) {
	 		return false;
	 	}
		 $.ajax({ 
            type: "POST",
              url: base_url+"client/insert_segment/",
              data:{segment:param,client_id:client_id},
              dataType: 'json', 
              success: function(data) {
                if (data.status == '1') {  
                	$('.select2-search__field').val('');
                	$("#segment").append('<option selected value="'+param+'">'+param+'</option>')
                	$("#select2-segment-results").hide();
                	toastr.success('New add segment has been successfully.');
                	 $("#div-segment").hide()
                	sessionStorage.clear();  
                }else{ 
                	$("#package-component-error").html("");
                	toastr.error('Something went wrong while add segment. Please try again.'); 
                }  
              }
          });
	} 


function confirmationDailg(){
	 
	var client_id = $("#client_id").val();
	var location = $("#location").val();
	var segment = $("#segment").val();
	var consent = CKEDITOR.instances['client-consent'].getData();
	var additional = $('#client-additional').val();//CKEDITOR.instances['client-additional'].getData();
	var attachment = $('#client-documents')[0].files[0];
	var additional_status = $(".change_client_additional:checked").val();
	var formdata = new FormData();
		formdata.append('client_id',client_id);
		formdata.append('consent',consent);
		formdata.append('additional',additional);
		formdata.append('additional_status',additional_status);
		formdata.append('location',location.toString());
		formdata.append('segment',segment.toString());
		formdata.append('files[]',attachment);

	if(client_id != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"Client/add_logo_consent",
	  	data:formdata,
      dataType: 'json',
      contentType: false,
      processData: false, 
	  	success: function(data){ 
	        if (data.status == '1') {
	        	 toastr.success('Consent Data has been successfully Updated.');
	        	$("#client_id").val('')
	        	CKEDITOR.instances['client-consent'].setData('');
	        	$('#client-additional').val('');
				$('#client-documents').val('');
				$("#selected-vendor-docs-li").html('');
				$("#location").val(null).trigger('change');
				$("#segment").val(null).trigger('change'); 
	        	load_role();
	        	 candidate_aadhar = [];
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		       
			} else {
		         
		        toastr.error('Something went wrong with inserting the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#edit_component').modal('hide'); 	
	    	toastr.error('Something went wrong with inserting the data. Please try again.');
	    } 
	  });
	}else{
		if(client_id != ''){
			$('#role-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the details.</span>');
		}
		 
	}
	
}
 

 function get_preview(img){ 
 	$("#consent-form").modal('show');
$("#consent-sign").html("<img class='logo-img' height='200' src='"+img_base_url+"../uploads/client-docs/"+img+"'>");
 }
