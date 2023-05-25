// load_case();

function load_case(candidate_id){
    // alert(candidate_id)
	$.ajax({
		type: "POST",
	  	url: base_url+"inputQc/get_single_case/"+candidate_id,  
	  	dataType: "json",
	  	success: function(data){ 
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
            var status = '';
            var classStatus = '';
            var fontAwsom='';
            if (data[i].is_submitted == '0') {
                classStatus = 'completed'
                status = '<span class="text-warning">pending<span>';
                fontAwsom = '<i class="fa fa-exclamation">'
            }else if (data[i].is_submitted == '1') {
                classStatus = 'pending'
                status = '<span class="text-success">Completed<span>';
                fontAwsom = '<i class="fa fa-check">'
            }
        	html += '<tr id="tr_'+data[i].candidate_id+'">'; 
        	html += '<td>'+j+'</td>';
        	html += '<td>'+data[i].component_name+'</td>';
        	html += '<td id="first_name'+data[i].candidate_id+'">'+data[i]['first_name']+'</td>';
        	html += '<td id="client_name_'+data[i].candidate_id+'">'+data[i]['client_name']+'</td>';
        	html += '<td id="package_name'+data[i].candidate_id+'">'+data[i]['package_name']+'</td>';
        	html += '<td id="phone_number'+data[i].candidate_id+'">'+data[i]['phone_number']+'</td>';
        	html += '<td id="email_id'+data[i].candidate_id+'">'+data[i]['email_id']+'</td>';
        	html += '<td class"'+classStatus+'" id="status'+data[i].candidate_id+'">'+status+'</td>';
        	html += '</tr>';

          j++; 
        }
      }else{
        html+='<tr><td colspan="8" class="text-center">No Case Found.</td></tr>'; 
    }
    $('#get-case-data').html(html); 
	  	} 
	});
}
 