load_role();
function load_role(){
	 sessionStorage.clear(); 
	$.ajax({
		type: "POST",
	  	url: base_url+"analyst/view_process_guidline", 
	  	dataType: "json",
	  	success: function(data){ 
	  		// console.log(JSON.stringify(data));
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	// var components = JSON.parse(data[i]['component_name']);
        	html += '<tr>'; 
        	html += '<td>'+j+'</td>';
        	html += '<td>'+data[i]['fs_crm_component_name']+'</td>'; 
        	html += '<td>'+data[i]['process_name']+'</td>'; 
        	html += '<td> <a target="_blank" href="'+img_base_url+'../uploads/process-docs/'+data[i]['process_attachment']+'" ><i class="fa fa-eye"></i></a></td>'; 
        	html += '</tr>'; 
			 
          j++; 
        }
      }else{
        html+='<tr><td colspan="7" class="text-center">No Guidline Found.</td></tr>'; 
    }
    $('#get-team-data').html(html); 
	  	} 
	});
}
