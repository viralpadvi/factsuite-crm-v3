function loadAllAssignedCases(team_id){
    $.ajax({
        type: "POST",
        url: base_url+"analyst/getComponentForms",
        data:{
            team_id:team_id
        },  
        dataType: "json",
        success: function(data){ 
            // console.log(JSON.stringify(data))
            if(data.length > 0){ 
                html ='';
                var j = 1;
                for (var i = 0; i < data.length; i++) {

                    // Input QC Status
                    var inputQcStatus= '';
                    var analystQcStatus= '';

                    if (data[i].status == '0' || data[i].status == '1') {
                         
                        inputQcStatus = '<span class="text-warning">Pending<span>'; 
                        
                    }
                     
                    else if (data[i].status == '2') {
                         
                        inputQcStatus = '<span class="text-success">Completed<span>';
                        
                    }else if (data[i].status == '3') {
                         
                        inputQcStatus = '<span class="text-danger">Insufficiency<span>';
                       
                    }else if (data[i].status == '4') {
                       
                        inputQcStatus = '<span class="text-success">Verified Clear<span>'; 
                         
                    }else if (data[i].status == '5'){
                        inputQcStatus = '<span class="text-danger">Stop Check<span>'; 
                         
                    }else{

                        inputQcStatus = '<span class="text-success">Already approved<span>'; 

                    }

                    // Analyst Status 

                    if (data[i].analyst_status == '0' || data[i].analyst_status == '1') {
                        analystQcStatus = '<span class="text-warning">Not initiated<span>'; 
                    }else if (data[i].analyst_status == '1') {
                        analystQcStatus = '<span class="text-info">Filled Form<span>';
                    }else if (data[i].analyst_status == '2') {
                        analystQcStatus = '<span class="text-success">Completed<span>';
                    }else if (data[i].analyst_status == '3') {
                        analystQcStatus = '<span class="text-danger">Insufficiency<span>';
                    }else if (data[i].analyst_status == '4') {
                        analystQcStatus = '<span class="text-success">Verified Clear<span>'; 
                    }else if (data[i].analyst_status == '5'){
                        analystQcStatus = '<span class="text-danger">Stop Check<span>'; 
                    }else if (data[i].analyst_status == '6'){
                        analystQcStatus = '<span class="text-danger">Unable to verify<span>'; 
                    }else if (data[i].analyst_status == '7'){
                        analystQcStatus = '<span class="text-danger">Verified discrepancy<span>'; 
                    }else if (data[i].analyst_status == '8'){
                        analystQcStatus = '<span class="text-danger">Client clarification<span>'; 
                    }else if (data[i].analyst_status == '9'){
                        analystQcStatus = '<span class="text-danger">Closed Insufficiency<span>'; 
                    }else if (data[i].analyst_status == '10'){
                        analystQcStatus = '<span class="text-danger">QC Error<span>';
                    }else if (data[i].analyst_status == '11'){
                        analystQcStatus = '<span class="text-warning">No Insuff<span>';
                    }else{
                        analystQcStatus = '<span class="text-warning">Pending<span>'; 
                    }

                    var arg = data[i].candidate_id+'/'+data[i].component_id+'/'+data[i].index;
                    var form_number = data[i].index + 1;
                    html +='<tr>';
                    html +='<td>'+(j++)+'</td>';
                    html +='<td>'+data[i].candidate_id+'</td>';
                    html +='<td class="text-capitalize" >'+data[i].component_name+' (form'+form_number+')</td>';
                    var candidate_name = data[i].candidate_detail.first_name+" "+data[i].candidate_detail.last_name
                    html +='<td class="text-capitalize" >'+candidate_name+'</td>';
                    html +='<td class="text-capitalize" >'+data[i].candidate_detail.employee_id+'</td>';
                    html +='<td>'+data[i].candidate_detail.phone_number+'</td>';
                    // html +='<td class="text-capitalize" >'+inputQcStatus+'</td>';
                    html +='<td class="text-capitalize" >'+analystQcStatus+'</td>';
                    html +='<td><a href="'+base_url+'factsuite-analyst/component-detail/'+arg+'" class="app-btn">View <i class="fas fa-angle-right"></i></a></td>';
                    html +='</tr>';

                }
            }else{
                html+='<tr><td colspan="8" class="text-center">No Case Found.</td></tr>'; 
            }    
               
            $('#get-case-data').html(html); 
        } 
    });
}



function action_status(candidate_id,component_id,componentname,first_name,email_id,status){
    
    switch(status){
        case '3':
            modalInsuffi(candidate_id,component_id,componentname,first_name,email_id,status)
            break;
        case '4':
            modalapprov(candidate_id,component_id,componentname,first_name,email_id,status)
            break;
        case '5': 
            modalStopCheck(candidate_id,component_id,componentname,first_name,email_id,status)
            break;
    }


}   


function roundProgress(data){ 

    $(".progress").each(function() {

        var value = $(this).attr('data-value');
        var left = $(this).find('.progress-left .progress-bar');
        var right = $(this).find('.progress-right .progress-bar');

        if (value > 0) {
          if (value <= 50) {
            right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
          } else {
            right.css('transform', 'rotate(180deg)')
            left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
          }
        }
    })
}
function percentageToDegrees(percentage) {
    return percentage / 100 * 360
}





// function get_single_cases_detail(id){}
 
function status_override_analyst(candidate_id,component_id,component_name,postion,key,i){
 $value = $("#"+i).val(); 
    // alert('candidate_id:'+candidate_id+'\n component_id:'+component_id+'\n component_name:'+component_name+'\n postion:'+postion+'\n element_id:'+element_id+'\n team_id:'+team_id)
    $('#override_confirm_dailog').modal('show')
    $('#btnOverrideDiv').html('<button onclick="status_override_analyst_action('+candidate_id+',\''+component_id+'\',\''+component_name+'\',\''+postion+'\',\''+$value+'\')" id="btnInsuffi"class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>')    
}


function status_override_analyst_action(candidate_id,component_id,component_name,postion,value){
    // alert('candidate_id:'+candidate_id+'\n component_id:'+component_id+'\n component_name:'+component_name+'\n postion:'+postion)
    $.ajax({
        type: "POST",
        url: base_url+"analyst/override_analyst_status",
        data:{
            candidate_id:candidate_id,
            component_id:component_id,
            component_name:component_name,
            postion:postion,
            status:value
        },
        dataType: "json",
        success: function(data){ 
            $('#override_confirm_dailog').modal('hide')
            if (data.status == '1') { 
                toastr.success('Status has been update successfully.'); 
            } else{
                toastr.error('assignment status update failed.');
            }
        }
    });
}

   