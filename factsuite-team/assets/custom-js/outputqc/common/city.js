function getCity(id,pos){
	// alert(id)
	var state = $("#"+id).val();
	if (state !='') {
		var c_id = $("#"+id).children('option:selected').data('id')
		
			$.ajax({
            type: "POST",
              url: base_url+"outPutQc/get_all_cities/"+c_id, 
              dataType: 'json', 
              success: function(data) {
				              	var html = '';
								if (data.length > 0) {
									for (var i = 0; i < data.length; i++) {
										html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
									}
								}
								$("#city"+pos).html(html);
				      }
            });
		$("#state-error"+id).html("&nbsp;");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please Select Valid state</span>");
		input_is_invalid("#state"+id)
	}
}




function getCitySingle(id){
	// alert(id)
	var state = $("#"+id).val();
	if (state !='') {
		var c_id = $("#"+id).children('option:selected').data('id')
		
			$.ajax({
            type: "POST",
              url: base_url+"outPutQc/get_all_cities/"+c_id, 
              dataType: 'json', 
              success: function(data) {
				              	var html = '';
								if (data.length > 0) {
									for (var i = 0; i < data.length; i++) {
										html +="<option data-id='"+data[i]['id']+"' value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
									}
								}
								$("#city").html(html);
				      }
            });
		$("#state-error"+id).html("&nbsp;");
		input_is_valid("#state"+id)
	}else{
		$("#state-error"+id).html("<span class='text-danger error-msg-small'>Please Select Valid state</span>");
		input_is_invalid("#state"+id)
	}
}