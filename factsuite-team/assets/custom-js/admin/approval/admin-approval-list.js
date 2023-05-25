
    function change_value_of_the_level(id,level){ 
        // alert(level.value)
     $("#accept-new-model").modal('show');
        if (level !='') { 
         // assign_to(3,assign)
             $("#accept-new-btn").attr('onclick','change_list_of_approval('+level.value+','+id+')');
       }
    }


function change_list_of_approval(level,approve_id){


    $.ajax({
        type : "POST",
        url : base_url+"Approval_Mechanisms/update_approval_list_level",
        data : { 
            approve_id :approve_id,
            level : level, 
            verify_admin_request : 1
        },
        dataType: "json",
        success: function(data) {
             $("#accept-new-model").modal('hide'); 
                $("#accept-new-btn").attr('onclick','');
             toastr.success('Approval Level Change has been updated successfully.');
            
           } 
    });  
}
