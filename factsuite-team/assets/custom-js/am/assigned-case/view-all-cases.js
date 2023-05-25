
function override_team(candidate_id,component_id,component_name,postion,i,element_id){
    var team_id = $('#'+element_id).val(); 
    // alert('candidate_id:'+candidate_id+'\n component_id:'+component_id+'\n component_name:'+component_name+'\n postion:'+postion+'\n element_id:'+element_id+'\n team_id:'+team_id)

    $('#override_confirm_dailog').modal('show')
    $('#btnOverrideDiv').html('<button onclick="override_team_action('+candidate_id+',\''+component_id+'\',\''+component_name+'\',\''+postion+'\',\''+team_id+'\','+i+')" id="btnInsuffi"class="btn bg-blu btn-submit-cancel text-white float-right">Confirm</button><button class="btn bg-blu btn-submit-cancel text-white float-right mr-4" data-dismiss="modal">Cancel</button>')
    

}
 
function override_team_action(candidate_id,component_id,component_name,postion,team_id,i){

    // alert('candidate_id:'+candidate_id+'\n component_id:'+component_id+'\n component_name:'+component_name+'\n postion:'+postion+'\n team_id:'+team_id)
     $.ajax({
        type: "POST",
        url: base_url+"am/override_team",
        data:{
            candidate_id:candidate_id,
            component_id:component_id,
            component_name:component_name,
            postion:postion,
            team_id:team_id
        },
        dataType: "json",
        success: function(data){ 
            $('#override_confirm_dailog').modal('hide')
            if (data.status == '1' && data.logStatus == '1') {
                $('#analyst_name_'+i).html(data.name)
                toastr.success('priority has been update successfully.'); 
            }else if(data.status == '1' && data.logStatus == '0') {
                toastr.error('assignment has been update successfully. but log data is not inserted.');
            }else{
                toastr.error('assignment status update failed.');
            }
        }
    });
}

