var credit_cibil = [];
var max_client_document_select = 20;
var client_document_size = 200000000;

 

$(".credit_cibil").on("change", handleFileSelect_credit_cibil); 


function handleFileSelect_credit_cibil(e){ 
		var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#credit_cibil-docs-li"+number).html('');
        $("#credit_cibil-error-msg-div"+number).html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
        	var obj = [];
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            // alert(number)
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf)$/i).test(fileName)) {
	            	 html = '<div id="file_credit_cibil_'+number+i+'"><span>'+fileName+' <a id="file_credit_cibil'+number+i+'" onclick="removeFile_credit_cibil('+number+','+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+number+','+i+',\'credit_cibil'+number+'\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                obj.push(files[i]);
	                $("#credit_cibil-error-msg-div"+number).append(html);
	        	}

	        }
	        credit_cibil.push({[number]:obj}); 
	    } else {
	    	$("#credit_cibil-docs-li"+number).html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#credit_cibil'+number).val('');
	    }
    } else {
        $("#credit_cibil-docs-li"+number).html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_credit_cibil(num,id) {
var tmp_array = [];
    var file = $('#file_credit_cibil'+num+id).data("file");
    for(var i = 0; i < credit_cibil.length; i++) {
    	if (typeof credit_cibil[i][num] !='undefined') {
    		var count = credit_cibil[i][num].length;
    		var obj = [];
		for (var b = 0; b < count; b++) { 
			if (credit_cibil[i][num][b].name !== file) { 
				obj.push(credit_cibil[i][num][b])
			} 
		} 
		tmp_array.push({[num]:obj})
	}else{
		tmp_array.push(credit_cibil[i])
	}

    }

    credit_cibil = tmp_array; 

    if (credit_cibil.length == 0) {
    	$("#credit_cibil"+num).val('');
    }
    $('#file_credit_cibil_'+num+id).remove(); 
}

function view_image(num,id,text){ 
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	 for (var i = 0; i < credit_cibil.length; i++) {
	 	 if (typeof credit_cibil[i][num] !='undefined') {
	 	 	var reader = new FileReader();
	        reader.onload = function(event) {
	           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
	        };
	        reader.readAsDataURL(credit_cibil[i][num][id]);
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


$(".credit_cibil_number").on("blur keyup", function(){
	var file_id = $(this).attr('id');
	// alert(file_id)
		 var number = file_id.match(/\d+/);
    var credit_cibil_number = $("#credit_cibil_number"+number).val();
    if (credit_cibil_number !='') {
        if (credit_cibil_number.length > 15) {
            $("#credit_cibil_number-error"+number).html('<span class="text-danger error-msg-small">Credit / Cibil number should be of '+15+' digits.</span>');
             
            $("#credit_cibil_number-error"+number).html('&nbsp;');
            input_is_invalid("#credit_cibil_number"+number); 
            
        } else {
            $("#credit_cibil_number-error"+number).html('&nbsp;');
            input_is_valid("#credit_cibil_number"+number);
        } 
    }else{
        $("#credit_cibil_number-error"+number).html("<span class='text-danger error-msg-small'>Please enter valid Credit / Cibil number</span>");
        input_is_invalid("#credit_cibil_number"+number)
    }
});



$('#add-credit-cibil').on('click',function(){
 	$('add-credit-cibil').attr('disabled',true);
  	
		var credit_cibil_number = [];
		var flag = 0;
	$(".credit_cibil_number").each(function(){ 
		if ($(this).val() !='' && $(this).val() !=null) {
		 credit_cibil_number.push({credit_cibil_number : $(this).val()});
		}else{
			var file_id = $(this).attr('id');
		 var number = file_id.match(/\d+/);
		 var html ='<span class="text-danger error-msg-small">Please enter credit / cibil  number.</span>';
		 $("#credit_cibil_number-error"+number).html(html);
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

	var credit_doc = [];
	$(".credit_cibil").each(function(){
		if ($(this).val() !='') {
			credit_doc.push(1);
		}else{
			credit_doc.push(0);
		}
	});
	  var formdata = new FormData();
	   formdata.append('url',17);
	formdata.append('credit_cibil_number',JSON.stringify(credit_cibil_number)); 
	formdata.append('document_type',JSON.stringify(document_type)); 

	var credit_id = $('#credit_id').val();
	if(credit_id != null && credit_id != ''){
	 
		formdata.append('credit_id',credit_id)
	}
		formdata.append('count',credit_cibil.length);
		formdata.append('credit_count',credit_doc);

	if (credit_cibil.length > 0) {
		var a = 0;
		$.each(credit_cibil,function(index,value){ 
			$.each(value,function(index,val){ 
			if (credit_cibil[a][index].length > 0) {
			for (var c = 0; c < credit_cibil[a][index].length; c++) {
					formdata.append('credit_cibil'+a+'[]',credit_cibil[a][index][c]);  
			} 	
			}else{ 
				formdata.append('credit_cibil[]','');
			}
		});
			a++;
		});
 
	}else{
		formdata.append('credit_cibil[]',''); 
	}
	 
$("#add-credit-cibil").html('<div class="spinner-grow text-success spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>Loading...');

	$.ajax({
        type: "POST",
          url: base_url+"candidate/update_candidate_credit_cibil",
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
          		toastr.error('Something went wrong while save this data. Please try again.'); 	
          	}
          	$("#warning-msg").html("");
          	$("#add-credit-cibil").html("Save & Continue")
          }
        });
});

