
$('#generate_report').on('click',function(){


	var to = $('#to').val();
	var from = $('#from').val();
	var customer = $('#customer').val();

	var table = $('#table').children('option:selected').val()
	var duration = $('#duration').children('option:selected').val()
	var method = ''

/*	if(table == '6,10'){
		method = 'daily_report_employment'
	}else if(table == '7'){
		method = 'daily_report_education'
	}else if(table == '3'){
		method = 'daily_report_document'
	}else if(table == '5'){
		method = 'daily_report_global'
	}else if(table == '8,9,12'){
		method = 'daily_report_address'
	}else if(table == '1' || table == '2' || table == '4'){
		method = 'daily_report_criminal_drug_court_test'
	}else{*/
		method = 'daily_report_insuff'
	// }
// 
	var formdata = new FormData();
	formdata.append('duration',duration);
	formdata.append('to',to);
	formdata.append('from',from);
	formdata.append('table',table);
	formdata.append('insuff',1);
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