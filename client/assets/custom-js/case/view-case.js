load_case();

function load_case(){
	$.ajax({
		type: "POST",
	  	url: base_url+"cases/get_all_cases", 
	  	dataType: "json",
	  	success: function(data){ 
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	var status = '';
          var d_none = '';
        	if (data[i].is_submitted == '0') {
        		status = '<span class="text-warning">pending<span>';
        	}else if (data[i].is_submitted == '1') {
                status = '<span class="text-info">InProgress<span>';
                 d_none = 'd-none';
            }else{
                status = '<span class="text-success">Submitted<span>';
                d_none = 'd-none';
            }
        	html += '<tr id="tr_'+data[i].candidate_id+'">'; 
        	html += '<td>'+j+'</td>';
        	html += '<td id="candidate_id'+data[i].candidate_id+'">'+data[i]['candidate_id']+'</td>';
        	html += '<td id="first_name'+data[i].candidate_id+'">'+data[i]['first_name']+'</td>';
        	html += '<td id="package_name'+data[i].candidate_id+'">'+data[i]['pack_name']+'</td>';
        	// html += '<td id="phone_number'+data[i].candidate_id+'">'+data[i]['phone_number']+'</td>';
        	html += '<td id="employee_id'+data[i].candidate_id+'">'+data[i]['employee_id']+'</td>';
        	html += '<td id="status'+data[i].candidate_id+'">'+status+'</td>';
        	html += '<td><a href="'+base_url+'factsuite-client/view-single-case/'+data[i].candidate_id+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;<a class="'+d_none+'" href="'+base_url+'factsuite-client/edit-case/?candidate_id='+data[i].candidate_id+'"><i class="fa fa-pencil"></i></a></td>';
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
