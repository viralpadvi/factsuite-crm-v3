load_case();

function load_case(){
	$.ajax({
		type: "POST",
	  	url: base_url+"inputQc/get_all_cases", 
	  	dataType: "json",
	  	success: function(data){ 
            console.log(data)
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
        	var status = '';
            var classStatus = '';
            var fontAwsom='';
        	if (data[i].is_submitted == '0') {
                // status = 'Pending';
                classStatus = 'pending'
                fontAwsom = '<i class="fa fa-check">'
        		status = '<span class="text-warning">Pending</span>';
        	}else if (data[i].is_submitted == '1') {
                // status = 'Pending';
                classStatus = 'pending'
                fontAwsom = '<i class="fa fa-check">'
                status = '<span class="text-info">Form Filled</span>';
            }else if (data[i].is_submitted == '2') {
                // status = 'Pending';
                classStatus = 'pending'
                fontAwsom = '<i class="fa fa-check">'
                status = '<span class="text-success">Completed</span>';
            }else{
                // status = 'Completed';
                 classStatus = 'pending'
                fontAwsom = '<i class="fa fa-check">'
                status = '<span class="text-warning">Pending</span>';
            }

            // if (data[i].vendor_status == '1') {
            //     check = 'checked';
            // } else {
            //     check = '';
            // }

        	html += '<tr id="tr_'+data[i].candidate_id+'">'; 
        	html += '<td>'+j+'</td>';
        	html += '<td id="first_name'+data[i].candidate_id+'">'+data[i]['first_name']+'</td>';
        	html += '<td id="client_name_'+data[i].candidate_id+'">'+data[i]['client_name']+'</td>';
        	html += '<td id="package_name'+data[i].candidate_id+'">'+data[i]['package_name']+'</td>';
        	html += '<td id="phone_number'+data[i].candidate_id+'">'+data[i]['candidate_id']+'</td>';
        	// html += '<td id="email_id'+data[i].candidate_id+'">'+data[i]['email_id']+'</td>';
            html += '<td class"'+classStatus+'" id="status'+data[i].candidate_id+'">'+status+'</td>';
        	html += '<td class"'+classStatus+'" id="status'+data[i].candidate_id+'"><a href="'+base_url+'factsuite-inputqc/edit-case/'+data[i].candidate_id+'" class=""><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;</td>';
             // href="'+base_url+"inputQc/get_single_cases_detail/"+encodeURIComponent(btoa(data[i].candidate_id))+'"
            // html += '<td class="text-center"><a href="#" onclick="view_case_progress('+data[i].candidate_id+')"><i class="fa fa-eye"></i></a></div></td>';
        	// html += '<td class="text-center"><a href="'+base_url+'factsuite-inputqc/view-case-detail/'+data[i].candidate_id+'" ><i class="fa fa-eye"></i></a></div></td>';
            // html += '<td>';
            // html += '<div class="custom-control custom-switch d-inline" id="change_status_check_div_'+data[i].candidate_id +'">'+onclick="get_single_cases_detail('+data[i].candidate_id+')"
            //                         '<input type="checkbox" '+check+' onclick="change_vendor_status('+data[i].candidate_id +','+data[i].vendor_status+')" class="custom-control-input" id="change_candidate_status_'+data[i].candidate_id +'">'+
            //                         '<label class="custom-control-label" for="change_vendor_status_'+data[i].candidate_id +'"></label>'+
            //                     '</div>';
            // html += '<a href="javascript:void(0)" onclick="edit_vendor_details_modal('+data[i].candidate_id+')"><i class="fa fa-pencil fa-pencil-edit ml-2"></i></a>';
            // html += '</td>';
        	html += '</tr>';




          j++; 
        }
      }else{
        html+='<tr><td colspan="9" class="text-center">No Case Found.</td></tr>'; 
    }
    $('#get-case-data').html(html); 
	  	} 
	});
}


function get_single_cases_detail(id){
    $.ajax({
        type: "POST",
        url: base_url+"inputQc/get_single_cases_detail", 
        data:{
            id:id
        },
        dataType: "json",
        success: function(data){  
        let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) { 
            var status = '';
            if (data[i].is_submitted == '0') {
                // status = 'Pending';
                status = '<span class="text-warning">Pending</span>';
            }else{
                // status = 'Completed';
                status = '<span class="text-sucess">Completed</span>';
            }

            // if (data[i].vendor_status == '1') {
            //     check = 'checked';
            // } else {
            //     check = '';
            // }

            html += '<tr id="tr_'+data[i].candidate_id+'">'; 
            html += '<td>'+j+'</td>';
            html += '<td id="first_name'+data[i].candidate_id+'">'+data[i]['first_name']+'</td>';
            html += '<td id="client_name_'+data[i].candidate_id+'">'+data[i]['client_name']+'</td>';
            html += '<td id="package_name'+data[i].candidate_id+'">'+data[i]['package_name']+'</td>';
            html += '<td id="phone_number'+data[i].candidate_id+'">'+data[i]['phone_number']+'</td>';
            html += '<td id="email_id'+data[i].candidate_id+'">'+data[i]['email_id']+'</td>';
            html += '<td id="status'+data[i].candidate_id+'">'+status+'</td>';
            html += '<td class="text-center"><a onclick="view_edit_team('+data[i].candidate_id+')" href="'+base_url+"inputQc/get_single_cases_detail/"+encodeURIComponent(btoa(data[i].candidate_id))+'"><i class="fa fa-eye"></i></a></div></td>';
            // html += '<td>';
            // html += '<div class="custom-control custom-switch d-inline" id="change_status_check_div_'+data[i].candidate_id +'">'+
            //                         '<input type="checkbox" '+check+' onclick="change_vendor_status('+data[i].candidate_id +','+data[i].vendor_status+')" class="custom-control-input" id="change_candidate_status_'+data[i].candidate_id +'">'+
            //                         '<label class="custom-control-label" for="change_vendor_status_'+data[i].candidate_id +'"></label>'+
            //                     '</div>';
            // html += '<a href="javascript:void(0)" onclick="edit_vendor_details_modal('+data[i].candidate_id+')"><i class="fa fa-pencil fa-pencil-edit ml-2"></i></a>';
            // html += '</td>';
            html += '</tr>';




          j++; 
        }
      }else{
        html+='<tr><td colspan="7" class="text-center">No Case Found.</td></tr>'; 
    }
    $('#get-case-data').html(html); 
        } 
    });
}

function confirm_remove_case(candidate_id){
    $("#remove-candidate").modal('show');
     $('#btn-remove-Div').html('<button onclick="sure_remove_this_candidate('+candidate_id+')" id="float-btn-remove-candidate" class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>')
    
}

function sure_remove_this_candidate(id){
        $("#float-btn-remove-candidate").html('<div class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>');
     $.ajax({
        type: "POST",
        url: base_url+"inputQc/remove_single_cases_detail", 
        data:{
            id:id
        },
        dataType: "json",
        success: function(data){  
            if (data.status == 1) {
                $("#remove-candidate").modal('hide');
                $("#tr_"+id).remove();
                toastr.success('Successfully Candidate removed.'); 
            }else{
               toastr.error('Candidate remove request failed.');  
            }
        } 
    });
}