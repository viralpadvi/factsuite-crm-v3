load_city(17)
function load_city(id){
	 sessionStorage.clear();  
	$.ajax({
		type: "POST",
	  	url: base_url+"component/get_city_list/"+id, 
	  	dataType: "json",
	  	success: function(data){ 
	  		// console.log(JSON.stringify(data));
		let html='';
      if (data.length > 0) {
        var j = 1;
        for (var i = 0; i < data.length; i++) {  
        	html += '<tr>'; 
        	html += '<td>'+j+'</td>';
        	html += '<td>'+data[i]['name']+'</td>'; 
         
        	// html += '<td><a  onclick="edit_role('+data[i]['role_id']+')"  href="#"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;</div><a onclick="removeData('+data[i]['role_id']+')" href="#"><img src="assets/admin/images/delete.png" /></a></td>';
        	html += '</tr>'; 
			 
          j++; 
        }
      }else{
        html+='<tr><td colspan="2" class="text-center">No City Found.</td></tr>'; 
    }
    $('#get-city-data').html(html); 
	  	} 
	});
}

$("#city-state").on('change',function(){ 
if ($(this).val() !='') {
	load_city($(this).val());
}
});


function addcity(){
	 
	var state = $("#state").val();
	var name = $("#city_name").val();

	if(name != ''){
		$.ajax({
		type: "POST",
	  	url: base_url+"component/insert_city",
	  	data:{
	  		name:name,
	  		state:state,
	  	},
	  	dataType: "json",
	     
	  	success: function(data){
	   		$('#add_city').modal('hide'); 	
	        if (data.status == '1') {
	        	// load_role();
	        	$("#city_name").val('')
	        	 
		        // $('#change_store_status'+id).attr("onclick","store_status("+id+","+store_status+")");
		        toastr.success('New city has been added successfully.');
			} else {
		         
		        toastr.error('Something went wrong with adding the data. Please try again.');
			} 
	    },
	    error: function(data){
	       	$('#add_city').modal('hide'); 	
	    	toastr.error('Something went wrong with adding the data. Please try again.');
	    } 
	  });
	}else{
		if(role_name != ''){
			$('#city-name-error-msg-div').html('<span class="text-danger error-msg-small">Please fill the city name.</span>');
		}
		 
	}
	
}
 