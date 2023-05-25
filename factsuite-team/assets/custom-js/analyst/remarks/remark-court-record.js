var candidate_aadhar = [];
var max_client_document_select = 20;
var client_document_size = 200000000;

// console.log(JSON.stringify(candidateInfo))

$("#client-documents").on("change", handleFileSelect_candidate_aadhar);   


function handleFileSelect_candidate_aadhar(e){ 
	candidate_aadhar = [];
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) {
    	$("#selected-criminal-docs-li").html('');
        $("#criminal-upoad-docs-error-msg-div").html('');
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            	if ((/\.(gif|jpg|jpeg|tiff|png|pdf|doc|docx|xlsx|xls)$/i).test(fileName)) {
	            	 html = '<div id="aadhar-file_candidate_aadhar_'+i+'"><span>'+fileName+' <a id="aadhar-file_candidate_aadhar'+i+'" onclick="removeFile_candidate_aadhar('+i+')" data-file="'+fileName+'" ><i class="fa fa-times text-danger"></i></a><a onclick="view_image('+i+',\'candidate_aadhar\')" ><i class="fa fa-eye"></i></a></span></div>';
	                // candidate_proof.push(files[i]); 
	                candidate_aadhar.push(files[i]);
	                $("#criminal-upoad-docs-error-msg-div").append(html);
	        	} 
	        }
	    } else {
	    	$("#selected-criminal-docs-li").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#client-documents').val('');
	    }
    } else {
        $("#selected-criminal-docs-li").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}

function removeFile_candidate_aadhar(id) {

    var file = $('#aadhar-file_candidate_aadhar'+id).data("file");
    for(var i = 0; i < candidate_aadhar.length; i++) {
        if(candidate_aadhar[i].name === file) {
            candidate_aadhar.splice(i,1); 
        }
    }
    if (candidate_aadhar.length == 0) {
    	$("#client-documents").val('');
    }
    $('#aadhar-file_candidate_aadhar_'+id).remove(); 
}

 
function view_image(id,text){
	$("#myModal-show").modal('show');
	 var file = $('#file_'+text+id).data("file");  
	    var reader = new FileReader();
        reader.onload = function(event) {
           $("#view-img").html("<img width='450px' src='"+event.target.result+"'>");
        };

         if(text =='candidate_aadhar'){ 
        reader.readAsDataURL(candidate_aadhar[id]);
        } 
}
// function exist_view_image(image,path){
// 	$("#myModal-show").modal('show'); 
//    $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
// }



$('#cancle-data-btn').on('click',function(){
	$("#warning-msg").html("");
})

var candidateInfo
function phpData(phpData){ 
	candidateInfo = phpData;
}

$('body').keypress(function(e) {
	// $("element").data('bs.modal')?._isShown
	if($("#conformtion").hasClass('show')){  
		var key = e.which;
	    if (key == 13) {
	      	court_record()
	      	return false;
	    }
	}
});

$("#add-court-record").on('click',function(){
	  court_record()
});

function court_record(){
	var index = $('#componentIndex').val()
	var priority = $('#priority').val()

	if(candidateInfo['remark_address'] != null){
		var address = candidateInfo['remark_address'].split(',');
		address = JSON.parse(address)
	}else{
		var address = []
	}
	$(".address").each(function(){
		 
		if ($(this).val() !='' && $(this).val() !=null) {
		  
			var obj = {}
			obj['address'] = $(this).val()
			address[index] = obj
			// alert(JSON.stringify(address))
			 
		}
	});
	// return false
	// var pincode = [];

	if(candidateInfo['remark_pin_code'] != null){
		var pincode = candidateInfo['remark_pin_code'].split(',');
		pincode = JSON.parse(pincode)
	}else{
		var pincode = []
	}

	$(".pincode").each(function(){
		// pincode.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
		 // pincode.push({pincode : $(this).val()});
		 	var obj = {}
			obj['pincode'] = $(this).val()
			pincode[index] = obj
			// alert(JSON.stringify(pincode))
		}
	});

	// var city = [];
	if(candidateInfo['remark_city'] != null){
		var city = candidateInfo['remark_city'].split(',');
		city = JSON.parse(city)
	}else{
		var city = []
	}
	$(".city").each(function(){
		// city.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
		// city.push({city : $(this).val()});
			var obj = {}
			obj['city'] = $(this).val()
			city[index] = obj
			// alert(JSON.stringify(city))
		}
	});
	// var state = [];
	if(candidateInfo['remark_state'] != null){
		var state = candidateInfo['remark_state'].split(',');
		state = JSON.parse(state)
	}else{
		var state = []
	}
	$(".state").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
			// state.push({state : $(this).val()});
			var obj = {}
			obj['state'] = $(this).val()
			state[index] = obj
			// alert(JSON.stringify(state))
		}
	}); 
	// var insuff_remarks = [];

	if(candidateInfo['insuff_remarks'] != null){
		var insuff_remarks = candidateInfo['insuff_remarks'].split(',');
		insuff_remarks = JSON.parse(insuff_remarks)
	}else{
		var insuff_remarks = []
	}
	$(".insuff_remarks").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
			// insuff_remarks.push({insuff_remarks : $(this).val()});
			var obj = {}
			obj['insuff_remarks'] = $(this).val()
			insuff_remarks[index] = obj
			// alert(JSON.stringify(insuff_remarks))
		}
	}); 
	// var progress_remarks = [];
	if(candidateInfo['in_progress_remarks'] != null){
		var progress_remarks = candidateInfo['in_progress_remarks'].split(',');
		progress_remarks = JSON.parse(progress_remarks)
	}else{
		var progress_remarks = []
	}
	$(".progress_remarks").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
			// progress_remarks.push({progress_remarks : $(this).val()});
			var obj = {}
			obj['progress_remarks'] = $(this).val()
			progress_remarks[index] = obj
			// alert(JSON.stringify(progress_remarks))
		}
	}); 
	// var verification_remarks = [];
	if(candidateInfo['verification_remarks'] != null){
		var verification_remarks = candidateInfo['verification_remarks'].split(',');
		verification_remarks = JSON.parse(verification_remarks)
	}else{
		var verification_remarks = []
	}
	$(".verification_remarks").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
			// verification_remarks.push({verification_remarks : $(this).val()});
			var obj = {}
			obj['verification_remarks'] = $(this).val()
			verification_remarks[index] = obj
			// alert(JSON.stringify(verification_remarks))
		}
	}); 
	// var closure_remarks = [];
	if(candidateInfo['Insuff_closure_remarks'] != null){
		var closure_remarks = candidateInfo['Insuff_closure_remarks'].split(',');
		closure_remarks = JSON.parse(closure_remarks)
	}else{
		var closure_remarks = []
	}
	$(".closure_remarks").each(function(){
		// state.push($(this).val());
		if ($(this).val() !='' && $(this).val() !=null) {
			// closure_remarks.push({closure_remarks : $(this).val()});
			var obj = {}
			obj['closure_remarks'] = $(this).val()
			closure_remarks[index] = obj
			// alert(JSON.stringify(closure_remarks))
		}
	}); 


  var verified_date = [];
  $(".verified_date").each(function(){
    // state.push($(this).val());
    if ($(this).val() !='' && $(this).val() !=null) {
      // verification_remarks.push({verification_remarks : $(this).val()});
      var obj = {}
      obj['verified_date'] = $(this).val()
      verified_date[index] = obj
      // alert(JSON.stringify(verification_remarks))
    }
  }); 
 	
	
	var court_records_id = $("#court_records_id").val();
	// analyst_status
	var action_status = $("#action_status").val();
	if(candidateInfo['analyst_status'] != null){
		var analyst_status = candidateInfo['analyst_status'].split(',');
		// analyst_status = JSON.parse(analyst_status)
	}else{
		var analyst_status = []
	}
	analyst_status[index] = action_status;
	// alert(analyst_status)
	var userID = $("#userID").val();
	
	var userRole = $("#userRole").val();

	var formdata = new FormData();
	// formdata.append('url',1);
	formdata.append('address',JSON.stringify(address));
	formdata.append('pincode',JSON.stringify(pincode));
	formdata.append('city',JSON.stringify(city));
	formdata.append('state',JSON.stringify(state));
	formdata.append('insuff_remarks',JSON.stringify(insuff_remarks));
	formdata.append('progress_remarks',JSON.stringify(progress_remarks));
	formdata.append('verification_remarks',JSON.stringify(verification_remarks));
	formdata.append('verified_date',JSON.stringify(verified_date));
	formdata.append('closure_remarks',JSON.stringify(closure_remarks));
	formdata.append('court_records_id',court_records_id);
	formdata.append('action_status',analyst_status);
	formdata.append('selected_component_status',action_status);
	formdata.append('count',candidate_aadhar.length);
	formdata.append('userID',userID);
	formdata.append('userRole',userRole);
	formdata.append('index',index);
	formdata.append('priority',priority);
	
	var op_action_status = $('#op_action_status').val()
	if(op_action_status == null || op_action_status == ''){
		formdata.append('op_action_status','0')	
	}else{
		formdata.append('op_action_status',op_action_status)
	}
	
	var candidate_id_hidden = $('#candidate_id_hidden').val()
	formdata.append('candidate_id',candidate_id_hidden);

	var vendor_id = $("#vendor_name").val();
  var component_id = $("#component_id").val();
		formdata.append('component_id',component_id);
  formdata.append('vendor_id',vendor_id);
  formdata.append('component_name','Court Record');
	
	
	if (candidate_aadhar.length > 0) {
		for (var i = 0; i < candidate_aadhar.length; i++) { 
			formdata.append('remark_docs[]',candidate_aadhar[i]);
		}
	}else{
		formdata.append('remark_docs[]','');
	} 


	 

	// if (verification_remarks.length > 0 ) {
	$("#wait-message").html("<span class='text-warning'>Please wait while we are updating the data.</span>");
		$.ajax({
            type: "POST",
              url: base_url+"analyst/update_remarks_candidate_court_record",
              data:formdata,
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(data) {
				if (data.status == '1') {
					toastr.success('successfully saved data.');   
					$('.is-valid').removeClass('is-valid');
              	}else{
              		toastr.error('Something went wrong while save this data. Please try again.'); 	
              	}
              	get_latest_selected_vendor();
              	$("#wait-message").html("");
              	$('#conformtion').modal('hide');
              }
            });
	// }else{

	// 	$("#wait-message").html("<span class='text-danger'>Please enter required data.</span>");
	// 	$(".address").each(function(){
	// 		var MyID = $(this).attr("id"); 
	// 	   var number = MyID.match(/\d+/); 
	// 	   valid_verification_remarks(number)
	// 	}); 
		 
	// }
	
}

function input_is_valid(input_id) {
	$(input_id).removeClass('is-invalid');
	$(input_id).addClass('is-valid');
}

function input_is_invalid(input_id) {
	$(input_id).removeClass('is-valid');
	$(input_id).addClass('is-invalid');
}


function remove_form(id){
	$("#form"+id).remove();
}

function valid_verification_remarks(id){
	var verification_remarks = $("#verification_remarks"+id).val();
	if (verification_remarks !='') {
		$("#verification_remarks"+id).html("&nbsp;");
		input_is_valid("#verification_remarks"+id)
	}else{
		input_is_invalid("#verification_remarks"+id)
		$("#verification_remarks"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid address</span>");
	}
}

function valid_city(id){
	var city = $("#city"+id).val();
	if (city !='') {
		$("#city-error"+id).html("&nbsp;");
		input_is_valid("#city"+id)
	}else{
		$("#city-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid city</span>");
		input_is_invalid("#city"+id)
	}
}
/*function valid_state(id){
	var state = $("#state"+id).val();
	if (state !='') {
		$("#state-error"+id).html("&nbsp;");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please Enter Valid state</span>");
		input_is_invalid("#state"+id)
	}
}*/


function valid_state(id){
	var state = $("#state"+id).val();
	if (state !='') {
		var c_id = $("#state"+id).children('option:selected').data('id')
		
			$.ajax({
            type: "POST",
              url: base_url+"analyst/get_selected_cities/"+c_id, 
              dataType: 'json', 
              success: function(data) {
              	var html = '';
				if (data.length > 0) {
					for (var i = 0; i < data.length; i++) {
						html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
					}
				}
				$("#city"+id).html(html);
              }
            });
		$("#state-error"+id).html("&nbsp;");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please Select Valid state</span>");
		input_is_invalid("#state"+id)
	}
}

 