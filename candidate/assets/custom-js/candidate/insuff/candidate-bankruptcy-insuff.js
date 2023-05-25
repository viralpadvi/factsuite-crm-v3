var bankruptcy = [];
var max_client_document_select = 20;
var client_document_size = 200000000;

 

$(".bankruptcy_doc").on("change", handleFileSelect_bankruptcy); 


function handleFileSelect_bankruptcy(e){ 
		var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#bankruptcy_doc-docs-li"+number).html('');
        $("#bankruptcy_doc-error-msg-div"+number).html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
        	var obj = [];
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            // alert(number)
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_bankruptcy_'+number+i+'"><span>'+fileName+' <a id="file_bankruptcy'+number+i+'" onclick="removeFile_bankruptcy('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+number+','+i+',\'bankruptcy'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                obj.push(files[i]);
	                $("#bankruptcy_doc-error-msg-div"+number).append(html);
	        	}

	        }
	        bankruptcy.push({[number]:obj}); 
	    } else {
	    	$("#bankruptcy_doc-docs-li"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#bankruptcy_doc'+number).val('');
	    }
    } else {
        $("#bankruptcy_doc-docs-li"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_bankruptcy(num,id) {
var tmp_array = [];
    var file = $('#file_bankruptcy'+num+id).data("file");
    for(var i = 0; i < bankruptcy.length; i++) {
    	if (typeof bankruptcy[i][num] !='undefined') {
    		var count = bankruptcy[i][num].length;
    		var obj = [];
		for (var b = 0; b < count; b++) { 
			if (bankruptcy[i][num][b].name !== file) { 
				obj.push(bankruptcy[i][num][b])
			} 
		} 
		tmp_array.push({[num]:obj})
	}else{
		tmp_array.push(bankruptcy[i])
	}

    }

    bankruptcy = tmp_array; 

    if (bankruptcy.length == 0) {
    	$("#bankruptcy"+num).val('');
    }
    $('#file_bankruptcy_'+num+id).remove(); 
}

function view_image(num,id,text){ 
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	 for (var i = 0; i < bankruptcy.length; i++) {
	 	 if (typeof bankruptcy[i][num] !='undefined') {
	 	 	var reader = new FileReader();
	        reader.onload = function(event) {
	           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
	        };
	        reader.readAsDataURL(bankruptcy[i][num][id]);
	 	 }
	 }
	    
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


$(".bankruptcy").on("blur keyup", function(){
	var file_id = $(this).attr('id');
	// alert(file_id)
		 var number = file_id.match(/\d+/);
    var bankruptcy = $("#bankruptcy"+number).val();
    if (bankruptcy !='') {
        if (bankruptcy.length > 15) {
            $("#bankruptcy-error"+number).html('<span class="text-danger error-msg-small">Credit / Cibil Number should be of '+15+' digits.</span>');
             
            $("#bankruptcy-error"+number).html('&nbsp;');
            input_is_invalid("#bankruptcy"+number); 
            
        } else {
            $("#bankruptcy-error"+number).html('&nbsp;');
            input_is_valid("#bankruptcy"+number);
        } 
    }else{
        $("#bankruptcy-error"+number).html("<span class='text-danger error-msg-small'>Please enter valid Credit / Cibil number</span>");
        input_is_invalid("#bankruptcy"+number)
    }
});



$('#add-document-check').on('click',function(){
 	$('add-credit-cibil').attr('disabled',true);

 	 var flag = 0;
  	 var formdata = new FormData();
  	  formdata.append('url',18);
		var bankruptcy_number = [];
	$(".bankruptcy").each(function(){ 
		if ($(this).val() !='' && $(this).val() !=null) {
		 bankruptcy_number.push({bankruptcy_number : $(this).val()});
		}else{
				var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
		 var html ='<span class="text-danger error-msg-small">Please select the document type</span>';
		 $("#document_type-error"+number).html(html);
		 flag = 1;
		}
	});

	var document_type = [];
	$(".document_type").each(function(){ 
		if ($(this).val() !='' && $(this).val() !=null) {
		 document_type.push({document_type : $(this).val()});
		}else{
			var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
		 var html ='<span class="text-danger error-msg-small">Please select the document type</span>';
		 $("#document_type-error"+number).html(html);
		 flag = 1;
		}
	});

	if (flag == 1) {
		return false;
	}
	
	formdata.append('bankruptcy_number',JSON.stringify(bankruptcy_number)); 
	formdata.append('document_type',JSON.stringify(document_type)); 
	var bankruptcy_doc =[];
	$(".bankruptcy_doc").each(function(){
		if ($(this).val() !='') {
			bankruptcy_doc.push(1);
		}else{
			bankruptcy_doc.push(0);
		}
	});

	var bankruptcy_id = $('#bankruptcy_id').val();
	if(bankruptcy_id != null || bankruptcy_id != ''){
	 
		formdata.append('bankruptcy_id',bankruptcy_id)
	}
		formdata.append('count',bankruptcy.length);
		formdata.append('bankruptcy_count',bankruptcy_doc);

	if (bankruptcy.length > 0) {
		var a = 0;
		$.each(bankruptcy,function(index,value){ 
			$.each(value,function(index,val){ 
			if (bankruptcy[a][index].length > 0) {
			for (var c = 0; c < bankruptcy[a][index].length; c++) {
					formdata.append('bankruptcy'+a+'[]',bankruptcy[a][index][c]);  
			} 	
			}else{ 
				formdata.append('bankruptcy[]','');
			}
		});
			a++;
		});
 
	}else{
		formdata.append('bankruptcy[]',''); 
	}
	 
$("#add-document-check").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$.ajax({
        type: "POST",
          url: base_url+"candidate/update_candidate_bankruptcy",
          data:formdata,
          dataType: 'json',
          contentType: false,
          processData: false,
          success: function(data) { 
          	$('#add-credit-cibil').attr('disabled',false);
			if (data.status == '1') {
				// toastr.success('successfully saved data.');  
				$('.is-valid').removeClass('is-valid'); 
				window.location.href=base_url+data.url;
          	}else{
          		toastr.error('Something went wrong while saving the data. Please try again.'); 	
          	}
          	$("#warning-msg").html("");
          	$("#add-document-check").html("Save & Continue")
          }
        });
});

