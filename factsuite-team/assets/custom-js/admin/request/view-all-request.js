//get-case-data
load_component()
function load_component(){
	 sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"inputQc/get_request_details", 
	  	dataType: "json",
	  	success: function(data){ 
	  		console.log(JSON.stringify(data));
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	// var components = JSON.parse(data[i]['component_name']);
        	html += '<tr>'; 
        	html += '<td>'+j+'</td>';
        	html += '<td>'+data[i]['form_up_to']+'</td>';
        	html += '<td>'+data[i]['component_name']+'</td>';
        	html += '<td>'+data[i]['client_name']+'</td>';
        	html += '<td>'+data[i]['package_name']+'</td>';
        	html += '<td>'+data[i]['added_by_name']+'</td>';
        	if(data[i]['package_status'] == 1){
        		html += '<td>Accepted</td>';
        	}else{
        		html += '<td>Pending</td>';
        	}
        	html += '</tr>'; 
			 
          j++; 
        }
      }else{
        html+='<tr><td colspan="7" class="text-center">No Request Found.</td></tr>'; 
    }
    $('#get-case-data').html(html); 
	  	} 
	});
}
