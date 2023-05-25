let chat_doc = [];
var max_client_document_select = 20;
var client_document_size = 3000000000000;
var last_value = 0; 
$('#get-internal-chat-list .user-chat-list').on('click',function(){
	 $('#get-internal-chat').html(''); 
	 $("#internal-chat-input").val('')
	$('.user-chat-list').removeClass('active');
	$(this).addClass('active');
	$id = $(this).data('id');
	$role = $(this).data('role'); 
	$("#current-active-user-id").val($id);
	$("#current-active-user-role").val($role);
	last_value = 0;
	get_internal_chat_details();

});

function get_chat_details($id,$role){
	// alert("get_chat_details")
	 $('#get-internal-chat').html(''); 
	 $("#internal-chat-input").val('')
	$('.user-chat-list').removeClass('active');
	$("#cur_"+$id+'_'+$role).addClass('active'); 
	$("#current-active-user-id").val($id);
	$("#current-active-user-role").val($role);
	last_value = 0;
	get_internal_chat_details();
}

function get_internal_chat_details() {
	$('#get-internal-chat').html('');
	$('#chat-history-div').removeClass('d-none');
	$id = $("#current-active-user-id").val() ; 
	$role = $("#current-active-user-role").val();  
	if ($id !=0 && $id !=null && $id !='undefined' && $role !=0 && $role !=null && $role !='undefined') {
		$.ajax({
			type: "POST",
			async: false,
	  	url: base_url+"team/interna_chat",
	  	data:{
	  		to_id : $id,
	  		to_role : $role
	  	},
	  	dataType: "json",
	  	success: function(data) { 
				let html='';
      	if (data.length > 0) {
        	var j = 1;
        	var last = 0;
        	for (var i = 0; i < data.length; i++) { 
        		$text = 'text-right';
        		if (data[i]['to_id'] != $id && data[i]['to_role'] != $role) {
        			$text = 'text-left';
        		}
        		if (data[i].message_type !='file') {

        		html += "<div class='chat-msg-div m-2 "+$text+"'><span>"+data[i]['message']+"</span></div>"; 
        	}else{
        		var img = data[i]['message'].split(',');

        		for (var n = 0; n < img.length; n++) { 
	        		if ((/\.(gif|jpg|jpeg|tiff|png)$/i).test(img[n])) {
	        				html += "<div class='chat-msg-div m-2 "+$text+"'><a target='_blank' href='"+img_base_url+'../uploads/internal-chat/'+img[n]+"'><img width='450px' src='"+img_base_url+'../uploads/internal-chat/'+img[n]+"'></a></div>"; 
	        		}else{
	        			html += "<div class='chat-msg-div m-2 "+$text+"'><span><a class='btn btn-success' target='_blank' href='"+img_base_url+'../uploads/internal-chat/'+img[n]+"'>Attachment <i class='fa fa-x2 text-warning fa-download' aria-hidden='true'></i></a></span></div>"; 
	        		}

        		}

        	}

        		last = data[i].chat_id;
        	}
        	last_value = last; 
      	} else {
    	}
    	$('#get-internal-chat').html(html);
	  	} 
		});
	}
}

$("#btn-send-chat").on('click',function() {
	add_new_message();
});

$('#internal-chat-input').on('keypress', function(e) {
  var key = e.which;
  if (key == 13) {
    add_new_message();
    return false;
  }
});

function add_new_message() {
	let message = $("#internal-chat-input").val();
	$id = $("#current-active-user-id").val(); 
	$role = $("#current-active-user-role").val(); 
	if (message !='' && message !=null) {
		$.ajax({
			type: "POST",
			async: false,
	  	url: base_url+"team/insert_interna_chat",
	  	data:{
	  		to_id:$id,
	  		to_role:$role,
	  		message:message
	  	},
	  	dataType: "json",
	  	success: function(data) { 
				let html = '';
      	if (data.status == '1') {
        	html = "<div class='chat-msg-div m-2 text-right'><span>"+message+"</span></div>"; 
        	last_value = data.chat.chat_id; 
      	}
    		$('#get-internal-chat').append(html); 
    		$("#internal-chat-input").val('').focus();
	  	} 
		});
	}
}

function get_internal_chat_last_value(){ 
	$id = $("#current-active-user-id").val(); 
	$role = $("#current-active-user-role").val();  
	if ($id !=0 && $id !=null && $id !='undefined' && $role !=0 && $role !=null && $role !='undefined') {
		$.ajax({
		type: "POST",
		async: false,
	  	url: base_url+"team/interna_chat",
	  	data:{
	  		to_id:$id,
	  		to_role:$role,
	  		last_value:last_value,
	  	},
	  	dataType: "json",
	  	success: function(data){ 
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	$text = 'text-right';
        	if (data[i]['to_id'] != $id && data[i]['to_role'] != $role) {
        		$text = 'text-left';
        	}
        	if (data[i].message_type !='file') {

        		html += "<div class='chat-msg-div m-2 "+$text+"'><span>"+data[i]['message']+"</span></div>"; 
        	}else{
        		var img = data[i]['message'].split(',');

        		for (var n = 0; n < img.length; n++) { 
	        		if ((/\.(gif|jpg|jpeg|tiff|png)$/i).test(img[n])) {
	        				html += "<div class='chat-msg-div m-2 "+$text+"'><a target='_blank' href='"+img_base_url+'../uploads/internal-chat/'+img[n]+"'><img width='450px' src='"+img_base_url+'../uploads/internal-chat/'+img[n]+"'></a></div>"; 
	        		}else{
	        			html += "<div class='chat-msg-div m-2 "+$text+"'><span><a target='_blank' href='"+img_base_url+'../uploads/internal-chat/'+img[n]+"'>Attachment <i class='fa fa-x2 text-warning fa-download' aria-hidden='true'></i></a></span></div>"; 
	        		}

        		}

        	}
        	 last_value = data[i].chat_id; 
    			$('#get-internal-chat').append(html); 
        }
      }else{
         
    }
	  	} 
	});
	}
}


function get_number_of_chats_selected_user(){ 
	$(".chat-count").html(0)
	 $.ajax({
		type: "POST",
		async: false,
	  	url: base_url+"team/get_number_of_chats_selected_user",
	  	 
	  	dataType: "json",
	  	success: function(data){ 
		// let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	  // $("#chat-"+data[i]['from_id']+'_'+data[i]['from_role']).html(data[i]['total']);
        	  $id = $("#current-active-user-id").val(); 
	$role = $("#current-active-user-role").val();  
	if ($id !=0 && $id !=null && $id !='undefined' && $role !=0 && $role !=null && $role !='undefined') {
        	  $("#cur_"+$id+'_'+$role).addClass('active');
		
		}
        	  $('#main_'+data[i]['team_id']+'_'+data[i]['role']).remove();
        	  let html ='';
        	   html +='<div id="main_'+data[i]['team_id']+'_'+data[i]['role']+'" class="col-md-12 mt-3 px-0">';
                html +='<div id="cur_'+data[i]['team_id']+'_'+data[i]['role']+'" onclick=get_chat_details('+data[i]['team_id']+',"'+data[i]['role']+'") class="edit-pages-a card user-chat-list user-chat-list-card" data-id="'+data[i]['team_id']+'" data-role="'+data[i]['role']+'">';
                  html +='<div class="row">';
                    html +='<div class="col-md-2"> ';
                      html +='<div class="candate"><span class="chat-profile-img text-white text-center">'+data[i]['first_name'][0].toUpperCase()+'</span></div>';
                    html +='</div>';
                    html +='<div class="col-md-8 text-left">';
                      html +='<h6 class="card-pages-name mt-2 mb-1 pl-2">'+ucwords(data[i]['first_name']+' '+data[i]['last_name'])+'</h6> ';
                      html +='<span class="card-last-edited-date pl-2" id="home-page-total-case">'+ucwords(data[i]['role'])+'</span>';
                    html +='</div>';
                     html +='<div class="col-md-2 text-center">  ';
                      html +='<span id="chat-'+data[i]['team_id']+'_'+data[i]['role']+'" class="chat-count">'+data[i]['total']+'</span>';
                    html +='</div>';
                  html +='</div>';
                html +='</div>';
              html +='</div>  '; 

              $("#get-internal-chat-list").prepend(html);

        }
      }else{
         
    }
	  	} 
	});
	} 

setInterval(function() {
	$id = $("#current-active-user-id").val(); 
	$role = $("#current-active-user-role").val(); 
	if ($id !=0 && $id !=null && $id !='undefined' && $role !=0 && $role !=null && $role !='undefined' && last_value !=0) { 
   get_internal_chat_last_value();
 }
 get_number_of_chats_selected_user();
},2000);

$("#search-internal-team").on('keypress keyup keydown',function(){
	var input_val = $(this).val(); 
	get_internal_team_member(input_val)
});

function get_internal_team_member(input_val){ 
	$.ajax({
		type: "POST",
		async: false,
	  	url: base_url+"team/get_internal_team",
	  	data:{input:input_val},
	  	dataType: "json",
	  	success: function(data){  
		let html='';
      if (data.length > 0) { 
        var j = 1; 
        for (var i = 0; i < data.length; i++) { 
        	   html +='<div id="main_'+data[i]['team_id']+'_'+data[i]['role']+'" class="col-md-12 mt-3 px-0">';
                html +='<div id="cur_'+data[i]['team_id']+'_'+data[i]['role']+'" onclick=get_chat_details('+data[i]['team_id']+',"'+data[i]['role']+'") class="edit-pages-a card user-chat-list user-chat-list-card" data-id="'+data[i]['team_id']+'" data-role="'+data[i]['role']+'">';
                  html +='<div class="row">';
                    html +='<div class="col-md-2"> ';
                      html +='<div class="candate"><span class="chat-profile-img text-white text-center">'+data[i]['first_name'][0].toUpperCase()+'</span></div>';
                    html +='</div>';
                    html +='<div class="col-md-8 text-left">';
                      html +='<h6 class="card-pages-name mt-2 mb-1 pl-2">'+ucwords(data[i]['first_name']+' '+data[i]['last_name'])+'</h6> ';
                      html +='<span class="card-last-edited-date pl-2" id="home-page-total-case">'+ucwords(data[i]['role'])+'</span>';
                    html +='</div>';
                     html +='<div class="col-md-2 text-center">  ';
                      html +='<span id="chat-'+data[i]['team_id']+'_'+['role']+'" class="chat-count">0</span>';
                    html +='</div>';
                  html +='</div>';
                html +='</div>';
              html +='</div>  ';
        }
      }else{
         
    }
    $("#get-internal-chat-list").html(html);
	  	} 
	});
}

function ucwords (str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}



$("#upload-file").on("change", handleFileSelect_chat);


function handleFileSelect_chat(e){  
	$("#my-chat-modal").modal('show');
	$("#view-img").html('');
	chat_doc = [];
	    var files = e.target.files; 
    var filesArr = Array.prototype.slice.call(files); 

    var j = 1; 
    if (files.length <= max_client_document_select) { 
        if (files[0].size <= client_document_size) {
        	var html ='';
	        for (var i = 0; i < files.length; i++) {
	            var fileName = files[i].name; // get file name 
	            	if ((/\.(gif|jpg|jpeg|tiff|png)$/i).test(fileName)) {
	            	 
	                var reader = new FileReader();
					        reader.onload = function(event) {
					           $("#view-img").append("<img width='450px' src='"+event.target.result+"'>");
					        };
					        reader.readAsDataURL(files[i]);
	        	}else{
	        		 $("#view-img").append("<span class='text-center'>Attachment</span>");
	        	} 
	               
	                chat_doc.push(files[i]);
	        }
	    } else {
	    	$("#file1-error").html('<div class="col-md-12"><span class="text-danger error-msg-small">Document size should be of max 20 Mb.</span></div>');
			$('#upload-file').val('');
	    }
    } else {
        $("#file1-error").html('<span class="text-danger error-msg-small">Please select a max of '+max_client_document_select+' files</span>');
    }
}



function save_internal_chat_last_value(){ 
	$id = $("#current-active-user-id").val(); 
	$role = $("#current-active-user-role").val();  
	if (chat_doc.length > 0 && $id !=0 && $id !=null && $id !='undefined' && $role !=0 && $role !=null && $role !='undefined') {
		var formdata = new FormData();
    formdata.append('to_id',$id);
    formdata.append('to_role',$role); 
		 if (chat_doc.length > 0) {
            for (var i = 0; i < chat_doc.length; i++) { 
                formdata.append('attached_docs[]',chat_doc[i]);
            }
        }else{
            formdata.append('attached_docs[]','');
        }  
		$.ajax({
		type: "POST",
		async: false,
	  	url: base_url+"team/insert_interna_chat_attachment",
	  	data:formdata,
      dataType: 'json',
      contentType: false,
      processData: false,
	  	success: function(data){ 
			let html = '';
      	if (data.status == '1') {
        	if (data.chat.message_type !='file') {

        		html += "<div class='chat-msg-div m-2 "+$text+"'><span>"+data.chat['message']+"</span></div>"; 
        	}else{
        		var img = data.chat['message'].split(',');

        		for (var n = 0; n < img.length; n++) { 
	        		if ((/\.(gif|jpg|jpeg|tiff|png)$/i).test(img[n])) {
	        				html += "<div class='chat-msg-div m-2 "+$text+"'><a target='_blank' href='"+img_base_url+'../uploads/internal-chat/'+img[n]+"'><img width='450px' src='"+img_base_url+'../uploads/internal-chat/'+img[n]+"'></a></div>"; 
	        		}else{
	        			html += "<div class='chat-msg-div m-2 "+$text+"'><span><a target='_blank' href='"+img_base_url+'../uploads/internal-chat/'+img[n]+"'>Attachment <i class='fa fa-x2 text-warning fa-download' aria-hidden='true'></i></a></span></div>"; 
	        		}

        		}

        	}
        	last_value = data.chat.chat_id; 
      	}
      	chat_doc = [];
      	$("#upload-file").val();
      	$("#my-chat-modal").modal('hide');
    		$('#get-internal-chat').append(html); 
    		$("#internal-chat-input").val('').focus();
	  	} 
	});
	}
}


