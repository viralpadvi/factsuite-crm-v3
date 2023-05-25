
function generate_report(table=0){

/*
	var to = $('#to').val();
	var from = $('#from').val();
	var customer = $('#customer').val();
*/ 
	var duration = $('#duration').children('option:selected').val()
	var method = 'export_cases_status'

	if(table == '1'){
		method = 'export_cases_generated_report'
	}else{
		method = 'export_cases_status'
	}

	var formdata = new FormData();
	/*formdata.append('duration',duration);
	formdata.append('to',to);
	formdata.append('from',from);
	formdata.append('table',table);*/


	$.ajax({
	    type: "POST",
	    url: base_url+"cases/"+method+"/",
	    data:formdata,
	    dataType: 'json',
	    contentType: false,
	    processData: false,
	    success: function(data) {  

			// alert(data.path)
			var link=document.createElement('a');
			document.body.appendChild(link);
			link.href=data.path;
			link.click();	
			document.body.removeChild(link);

	    }	
	});
}