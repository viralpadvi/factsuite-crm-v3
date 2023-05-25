var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var mobile_number_length = 10;
var url_regex = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
// var url_regex = regex = ((http|https):\/\/)?(www.)[a-zA-Z0-9@:%._\\+~#?&\/\/=]{2,256}\\.[a-z]{2,6}\\b([-a-zA-Z0-9@:%._\\+~#?&\/\/=]*);
var client_zip_lenght = 6;
var client_document_size = 20000000;
var max_client_document_select = 20;
var candidate_cv =[]; 


$("#file1").on("change", handleFileSelect_candidate_cv);


function handleFileSelect_candidate_cv(e){ 
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
	            	 html = '<div id="file_candidate_cv_'+i+'"><span>'+fileName+' <a id="file_candidate_cv'+i+'" onclick="removeFile_candidate_cv('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_cv\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                candidate_cv.push(files[i]);
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


function removeFile_candidate_cv(id) {

    var file = $('#file_candidate_cv'+id).data("file");
    for(var i = 0; i < candidate_cv.length; i++) {
        if(candidate_cv[i].name === file) {
            candidate_cv.splice(i,1); 
        }
    }
    if (candidate_cv.length == 0) {
    	$("#file1").val('');
    }
    $('#file_candidate_cv_'+id).remove(); 
}


function view_image(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(candidate_cv[id]);
}


function exist_view_image(image,path){
    $("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}


function input_is_valid(input_id) {
    $(input_id).removeClass('is-invalid');
    $(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
    $(input_id).removeClass('is-valid');
    $(input_id).addClass('is-invalid');
}

/*
$("#driving_licence_number").on('keyup blur',valid_driving_licence_no);
function valid_driving_licence_no(){
    var driving_licence_number = $("#driving_licence_number").val();
    if (passport !='') {
        if (driving_licence_number.length > 15) {
            $("#driving_licence_number-error").html('<span class="text-danger error-msg-small">riving Licence Number should be of '+15+' digits.</span>');
            var plenght = $("#driving_licence_number").val(driving_licence_number.slice(0,15));
            input_is_invalid("#driving_licence_number");
            if (plenght.length == 15) {
            $("#driving_licence_number-error").html('');
            input_is_valid("#driving_licence_number"); 
            }
        } else {
            $("#driving_licence_number-error").html('');
            input_is_valid("#driving_licence_number");
        } 
    }else{
        $("#driving_licence_number-error").html("<span class='text-danger error-msg-small'>Please Enter Valid riving Licence Number</span>");
        input_is_invalid("#driving_licence_number")
    }
}

*/



$("#add-cv-check").on('click',function(){ 
    $("#file1-error").html('');  
    var formdata = new FormData();
    formdata.append('url',20);
    formdata.append('link_request_from',link_request_from);
    /*formdata.append('address',address);
    formdata.append('pincode',pincode);
    formdata.append('city',city);
    formdata.append('state',state);*/
    var cv_id = $("#cv_id").val();
    if (cv_id !='' && cv_id !=null) {
            formdata.append('cv_id',cv_id);
        }

        
        if (candidate_cv.length > 0) {
            for (var i = 0; i < candidate_cv.length; i++) { 
                formdata.append('cv_docs[]',candidate_cv[i]);
            }
        }else{
            formdata.append('cv_docs[]','');
        }  

$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
        var cv_doc = $("#cv_doc").val(); 

        if ( candidate_cv.length > 0 || cv_doc !=''  ) {
$("#add-cv-check").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

            $.ajax({
                type: "POST",
                  url: base_url+"candidate/update_candidate_cv_check",
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
                    $("#add-cv-check").html("Save & Continue")
                  }
            });
        }else{
 

        if (candidate_cv.length == 0 && cv_doc =='') { 
             $("#file1-error").html('<span class="text-danger error-msg-small">Please select a min '+1+' file</span>');
        }
       
        }

    


    

});


