// loadAllAssignedCases();

// function loadAllAssignedCases(){
// 	$.ajax({
// 		type: "POST",
// 	  	url: base_url+"analyst/getQcErrorComponentAna", 
//         data:{
//             notifcation:'1'
//         },
// 	  	dataType: "json",
// 	  	success: function(data){ 
//           // console.log(JSON.stringify(data))
//           // console.log(data.length)
// 		  let html='';
//         if (data.length > 0) {
//             $('#QC-error-number').html(data.length)
//         var j = 1;
//         for (var i = 0; i < data.length; i++) { 
//         	var status = '';
//             var classStatus = '';
//             var fontAwsom='';

//             var defaultSelected = '';
//             var insuffSelected = '';
//             var approveSelected = '';
//             var stopCheckSelected = '';
//             var actionDisabled = '';
//             var select = '';
         
//             // analyst status 
//             var argWithName = data[i].candidate_id+','+data[i].component_id+',\''+data[i].component_name+'\',\''+data[i].first_name+'\',\''+data[i].email_id+'\'';
//             if (data[i].analyst_status == '0') {
                 
//                 status = '<span class="text-warning">Pending<span>';
//                 fontAwsom = '<i class="fa fa-exclamation">'
                
                
//                 // insuffDisable = 'disabled'
//                 // approvDisable = 'disabled'
//                 // stopDisable = 'disabled'
//                 defaultSelected = 'selected'
                 
//             }else if (data[i].analyst_status == '1') {
                 
//                 status = '<span class="text-info">Form Filled<span>';
//                 fontAwsom = '<i class="fa fa-check">'
                
//                 defaultSelected = 'selected'
                
//             }else if (data[i].analyst_status == '2') {
                 
//                 status = '<span class="text-success">Completed<span>';
//                 fontAwsom = '<i class="fa fa-check">'
//                 approveSelected = 'selected';
//                 actionDisabled ='disabled readonly'
                 
//             }else if (data[i].analyst_status == '3') {
                 
//                 status = '<span class="text-danger">Insufficiency<span>';
//                 fontAwsom = '<i class="fa fa-check">'
//                 insuffSelected = 'selected';
                 
//             }else if (data[i].analyst_status == '4') {
               
//                 status = '<span class="text-success">Verified Clear<span>';
//                 fontAwsom = '<i class="fa fa-check">'
//                 approveSelected = 'selected';
//                 actionDisabled ='disabled readonly'

                 
//             }else if (data[i].analyst_status == '5'){
//                 status = '<span class="text-danger">Stop Check<span>';
//                 fontAwsom = '<i class="fa fa-check">'
//                 stopCheckSelected = 'selected';
//                 actionDisabled ='disabled readonly'
                 
//             }else if (data[i].analyst_status == '6'){
//                 status = '<span class="text-danger">Unable to verify<span>';
//                 fontAwsom = '<i class="fa fa-check">'
//                 stopCheckSelected = 'selected';
//                 actionDisabled ='disabled readonly'
                 
//             }else if (data[i].analyst_status == '7'){
//                 status = '<span class="text-danger">Verified discrepancy<span>';
//                 fontAwsom = '<i class="fa fa-check">'
//                 stopCheckSelected = 'selected';
//                 actionDisabled ='disabled readonly'
                 
//             }else if (data[i].analyst_status == '8'){
//                 status = '<span class="text-danger">Client clarification<span>';
//                 fontAwsom = '<i class="fa fa-check">'
//                 stopCheckSelected = 'selected';
//                 actionDisabled ='disabled readonly'
                 
//             }else if (data[i].analyst_status == '9'){
//                 status = '<span class="text-danger">Closed insufficiency<span>';
//                 fontAwsom = '<i class="fa fa-check">'
//                 stopCheckSelected = 'selected';
//                 actionDisabled ='disabled readonly'
                 
//             }else if (data[i].analyst_status == '10'){
//                 status = '<span class="text-danger">QC Error<span>';
//                 fontAwsom = '<i class="fa fa-check">'
//                 stopCheckSelected = 'selected';
//                 actionDisabled ='disabled readonly'
                 
//             }else{

//                 status = '<span class="text-success">Wrong<span>';
//                 fontAwsom = '<i class="fa fa-check">'
//                 stopCheckSelected = 'selected';
//                 actionDisabled ='disabled readonly'

//             }

//             // Inputqc Status
//             inputQcStatus = '';
//             if (data[i].status == '0' || data[i].status == '1') {
                 
//                 inputQcStatus = '<span class="text-warning">Pending<span>'; 
                
//             }
             
//             else if (data[i].status == '2') {
                 
//                 inputQcStatus = '<span class="text-success">Completed<span>';
                
//             }else if (data[i].status == '3') {
                 
//                 inputQcStatus = '<span class="text-danger">Insufficiency<span>';
               
//             }else if (data[i].status == '4') {
               
//                 inputQcStatus = '<span class="text-success">Verified Clear<span>'; 
                 
//             }else if (data[i].status == '5'){
//                 inputQcStatus = '<span class="text-danger">Stop Check<span>'; 
                 
//             }else{

//                 inputQcStatus = '<span class="text-success">Already approved<span>'; 

//             }


//         	html += '<tr id="tr_'+data[i].candidate_id+'">'; 

//             	html += '<td class="d-none">'+j+'</td>';
//                 html += '<td id="first_name'+data[i].candidate_id+'">'+data[i].candidate_id+'</td>';

//                 var component = data[i]['component_name'];
//                 component = component.replace('_',' ');
            	
//                 html += '<td class="text-capitalize" id="package_name'+data[i].candidate_id+'">'+component+'</td>';
//             	html += '<td id="first_name'+data[i].candidate_id+'">'+data[i]['first_name']+'</td>';
//             	html += '<td id="client_name_'+data[i].candidate_id+'">'+data[i]['client_name']+'</td>';
//             	html += '<td id="phone_number'+data[i].candidate_id+'">'+data[i]['phone_number']+'</td>';
//                 html += '<td id="status'+data[i].candidate_id+'">'+inputQcStatus+'</td>';
//             	html += '<td class"'+classStatus+'" id="status'+data[i].candidate_id+'">'+status+'</td>';
//                 // '+base_url+'factsuite-inputqc/assigned-view-case-detail/'+data[i].candidate_id+'
//                 var arg0 = data[i].candidate_id+','+data[i].component_id;
//                 var arg = data[i].candidate_id+'/'+data[i].component_id;
//                 // html += '<td class="text-center"><button onclick="getComponentBasedData('+arg0+')" class="app-btn">View</button></td>';
//             	html += '<td class="text-center"><a href="'+base_url+'factsuite-specialist/component-detail/'+arg+'" class="app-btn">View <i class="fas fa-angle-right"></i></a></td>';

                
//                 // html += '<td>'
//                 //             // <button onclick="getComponentBasedData('+arg+')" class="app-btn">
//                 //     html += '<select id="action_status" name="carlist" '+actionDisabled+' class="sel-allcase" onchange="action_status('+argWithName+',this.value)">';
//                 //     html += '  <option '+defaultSelected+' value="0">Select your Action</option>';
//                 //     html += '  <option '+insuffSelected+' value="3">Insufficient</option>';
//                 //     html += '  <option '+approveSelected+' value="4">Approve</option>';
//                 //     html += '  <option '+stopCheckSelected+' value="5">stop check</option>'; 
//                 //     html += '</select>';   
//                 // html += '</td>';
//                 // html += '<td id="client_name_'+data[i].candidate_id+'"><button id="insuff_'+data[i].candidate_id+'" '+insuffDisable+' onclick="modalInsuffi('+argWithName+')"  class="insuf-btn">Insufficiency</button></td>';
//                 // html += '<td id="phone_number'+data[i].candidate_id+'"><button id="approvr_'+data[i].candidate_id+'" '+approvDisable+' onclick="modalapprov('+argWithName+')"  class="app-btn"><i class="fa fa-check bac-gr"></i> Approve</button></td>';
             
//         	html += '</tr>';




//           j++; 
//         }
//       }else{
//         html+='<tr><td colspan="7" class="text-center">No Case Found.</td></tr>'; 
//     }
//     $('#get-case-data').html(html); 
// 	  	} 
// 	});
// }

 function loadAllAssignedCases(team_id){
    $.ajax({
        type: "POST",
        url: base_url+"analyst/getQcErrorComponentAna",
        data:{
            team_id:team_id
        },  
        dataType: "json",
        success: function(data){ 
            console.log(JSON.stringify(data))
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
                         
                        analystQcStatus = '<span class="text-warning">Pending<span>'; 
                        
                    }
                     
                    else if (data[i].analyst_status == '2') {
                         
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
                        analystQcStatus = '<span class="text-danger">Closed insufficiency<span>'; 
                         
                    }else if (data[i].analyst_status == '10'){
                        analystQcStatus = '<span class="text-danger">QC Error<span>';
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
                    html +='<td class="text-capitalize" >'+data[i].candidate_detail.client_name+'</td>';
                    html +='<td>'+data[i].candidate_detail.phone_number+'</td>';
                    html +='<td class="text-capitalize" >'+inputQcStatus+'</td>';
                    html +='<td class="text-capitalize" >'+analystQcStatus+'</td>';
                    html +='<td><a href="'+base_url+'factsuite-specialist/component-detail/'+arg+'" class="app-btn">View <i class="fas fa-angle-right"></i></a></td>';
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
