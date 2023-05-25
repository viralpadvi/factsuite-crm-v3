
$('#generate_report').on('click',function(){


	var to = $('#to').val();
	var from = $('#from').val();
	var customer = $('#customer').val();

	var table = $('#table').children('option:selected').val()
	var duration = $('#duration').children('option:selected').val()
	var method = ''

	if(table == '6,10'){
		method = 'new_employment_report'
	}else if(table == '7'){
		method = 'new_education_component_report'
	}else if(table == 'reference'){
		method = 'new_reference_report'
	}else if(table == '8,9,12'){
		method = 'new_address_component_report'
	}else if(table == 'others'){
		method = 'other_checks_component'
	}else if(table == 'insuff'){
		method = 'daily_report_insuff'
	}else{
		method = 'daily_report'
	}
// 
	var formdata = new FormData();
	formdata.append('duration',duration);
	formdata.append('to',to);
	formdata.append('from',from);
	formdata.append('table',table);

	$("#generate_report").html("Loading..");
	$("#generate_report").prop('disabled',true);
	$.ajax({
	    type: "POST",
	    url: base_url+"dump_Components/"+method+"/",
	    data:formdata,
	    dataType: 'json',
	    contentType: false,
	    processData: false,
	    success: function(data) {  
	$("#generate_report").html("Generate");
	$("#generate_report").prop('disabled',false);
			// alert(data.path)
			var link=document.createElement('a');
			document.body.appendChild(link);
			link.href=data.path;
			link.click();	
			document.body.removeChild(link);

	    }	
	});
});