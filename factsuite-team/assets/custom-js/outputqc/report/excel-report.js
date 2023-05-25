
$('#generate_report').on('click',function(){


	var to = $('#to').val();
	var from = $('#from').val();
	var customer = $('#customer').val();

	var table = $('#table').children('option:selected').val()
	var duration = $('#duration').children('option:selected').val()
	var method = ''

	if(table == '6,10'){
		method = 'daily_report_employment'
	} else{
		method = 'daily_report_outputqc'
	}

	var formdata = new FormData();
	formdata.append('duration',duration);
	formdata.append('to',to);
	formdata.append('from',from);
	formdata.append('table',table);

	$("#generate_report").html("Loading..");
	$.ajax({
	    type: "POST",
	    url: base_url+"dump_Components/"+method+"/",
	    data:formdata,
	    dataType: 'json',
	    contentType: false,
	    processData: false,
	    success: function(data) {  
	    	$("#generate_report").html("Generate");
			// alert(data.path)
			var link=document.createElement('a');
			document.body.appendChild(link);
			link.href=data.path;
			link.click();	
			document.body.removeChild(link);

	    }	
	});
});