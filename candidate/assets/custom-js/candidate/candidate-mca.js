var regex = /^([a-zA-Z0-15_\.\-\+])+\@(([a-zA-Z0-15\-])+\.)+([a-zA-Z0-15]{2,4})+$/;
var mobile_number_length = 10;
var url_regex = /((([A-Za-z]{3,15}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-15.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-15.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/;
// var url_regex = regex = ((http|https):\/\/)?(www.)[a-zA-Z0-15@:%._\\+~#?&\/\/=]{2,256}\\.[a-z]{2,6}\\b([-a-zA-Z0-15@:%._\\+~#?&\/\/=]*);
var client_zip_lenght = 6;
var client_document_size = 20000000;
var max_client_document_select = 20;
var mca =[]; 


$("#file1").on("change", handleFileSelect_mca);


function handleFileSelect_mca(e){ 
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
	            	 html = '<div id="file_mca_'+i+'"><span>'+fileName+' <a id="file_mca'+i+'" onclick="removeFile_mca('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'mca\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                mca.push(files[i]);
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


function removeFile_mca(id) {

    var file = $('#file_mca'+id).data("file");
    for(var i = 0; i < mca.length; i++) {
        if(mca[i].name === file) {
            mca.splice(i,1); 
        }
    }
    if (mca.length == 0) {
    	$("#file1").val('');
    }
    $('#file_mca_'+id).remove(); 
}


function view_image(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };
        reader.readAsDataURL(mca[id]);
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


$("#organization_name").on('keyup blur',valid_mca_no);
function valid_mca_no(){
    var organization_name = $("#organization_name").val();
    if ( organization_name !='' ) {
        
            $("#organization_name-error").html('');
            input_is_valid("#organization_name");
        
    }else{
        $("#organization_name-error").html("<span class='text-danger error-msg-small'>Please enter valid Organization Name</span>");
        input_is_invalid("#organization_name")
    }
}





$("#add-mca").on('click',function(){ 
    $("#file1-error").html(''); 
var organization_name = $("#organization_name").val(); 
    var formdata = new FormData();
    formdata.append('url',31);
    /*formdata.append('address',address);
    formdata.append('pincode',pincode);
    formdata.append('city',city);
    formdata.append('state',state);*/
    var licence_id = $("#mca_id").val();
    if (licence_id !='' && licence_id !=null) {
            formdata.append('licence_id',licence_id);
        }

        var experiance_doc = $("#experiance_doc").val();

        
        if (mca.length > 0 ) {
            for (var i = 0; i < mca.length; i++) { 
                formdata.append('mca[]',mca[i]);
            }
        }else{
            formdata.append('mca[]','');
        } 

        formdata.append('organization_name',organization_name); 
        formdata.append('link_request_from',link_request_from);

        // var mca_doc = $("#mca_doc").val(); 

        if (  organization_name !='' &&  (mca.length > 0 || experiance_doc !='' ) ) {
$("#warning-msg").html("<span class='text-warning error-msg-small'>Please wait we are submitting the data.</span>");
$("#add-mca").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');
            $.ajax({
                type: "POST",
                  url: base_url+"candidate/update_candidate_mca",
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
                        //     window.location.href=base_url+'m-component-list';
                        // }
                    } else {
                        toastr.error('Something went wrong while save this data. Please try again.');   
                    }
                    $("#warning-msg").html("");
                    $("##add-mca").html("Save & Continue");
                  }
            });
        }else{

            if (mca_number !=null) {
                valid_mca_no();
            }
          

        if (mca.length == 0 && mca_doc =='') { 
             $("#file1-error").html('<span class="text-danger error-msg-small">Please select a min '+1+' file</span>');
        }
       
        }

    


    

});
