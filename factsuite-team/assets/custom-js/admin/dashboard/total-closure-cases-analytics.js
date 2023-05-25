
total_closure_items();
function total_closure_items(page=0,param='') { 
  var closure_manager = $('#closure_manager').val();
  var closure_status = $('#closure_status').val();
  var from = $('#from-date-closure').val();
  var to = $('#to-date-closure').val();
  $.ajax({
    type: "POST",
    url: base_url+"Admin_Analytics/get_all_client_closure_cases/"+0, 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:closure_manager,
      status:closure_status,
      from:from,
      to:to,
      all:1,
    },
    success: function(top_selling_items) {
    if (top_selling_items.client_data.length == 10) {
      if (param=='1') {
        var val = page-1;
        if (page !=0) {
        $('closure-next-value').attr('onclick','next_value('+val+',1)'); 
        $('closure-preview-value').attr('onclick','next_value('+page+',0)');
        }
      }else if (param=='0'){
         var val = page-1;
        $('closure-preview-value').attr('onclick','next_value('+val+',1)');
        $('closure-next-value').attr('onclick','next_value('+page+',0)');
      }
    }
      $('#total_closure_items_result').empty('');
      if (top_selling_items.client_data.length == 0) {
        $('#total_closure_items_error_div').html('<span class="text-danger">No data Available</span>');
        show_total_closure_items(top_selling_items.client_data,10);
      } else {
        $('#total_closure_items_error_div').html('');
        show_total_closure_items(top_selling_items.client_data,10);
      }
    }
  });
}



  var total_closure_data = '';
function show_total_closure_items(top_selling_items,top_selling_items_select) {
  var top_selling_canvas = $('#total_closure_items_result').get(0).getContext('2d');
  var label_array = [];
  var product_sales_array = [];
  var background_color_array = [];
  var background_colors = ['#2DCD7A','#FF9F43','#2DCD7A','#ED5F5F','#FF9F43','#2DCD7A','#ED5F5F','#FF9F43','#2DCD7A','#ED5F5F'];
  var lenght_t = top_selling_items.length;
/*  if (top_selling_items.length > 10 && top_selling_items_select == 10) {
    lenght_t = 10;
  }else if(top_selling_items.length <= 0){
    lenght_t = 0;
  }else if(top_selling_items.length > 15 && top_selling_items_select == 15){
    lenght_t = 15;
  }*/
  for (var i = 0; i < lenght_t; i++) {
    label_array.push(top_selling_items[i].client_name);
    // background_color_array.push(background_colors[i]);
    
    product_sales_array.push(top_selling_items[i][0].case_count);

  }
  var top_selling_data  = {
    labels: label_array,
    datasets: [{
      label               : 'Top Case',
      backgroundColor     : 'rgba(60,141,188,0.9)',
      borderColor         : 'rgba(60,141,188,0.8)',
      pointRadius         : false,
      pointColor          : '#3b8bba',
      pointStrokeColor    : 'rgba(60,141,188,1)',
      pointHighlightFill  : '#fff',
      pointHighlightStroke: 'rgba(60,141,188,1)',
      data                : product_sales_array
    }]
  }

  var areaChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines : {
          display : false,
        }
      }], 
    }
  } 

  var barChartData = jQuery.extend(true, {}, top_selling_data);
  var temp0 = top_selling_data.datasets[0];
  barChartData.datasets[0] = temp0;

  var top_selling_options = {
    responsive              : true,
    maintainAspectRatio     : false,
    datasetFill             : false
  }

  if(total_closure_data) {
    total_closure_data.destroy();
  }

  total_closure_data = new Chart(top_selling_canvas, {
   /* type: 'bar',
    data: barChartData,
    options: top_selling_options  */   
     type: 'bar',
        data: barChartData,
        beginAtZero: true,
        options: {
            responsive: true,
            /*legend: {
                display: false
            },*/
             maintainAspectRatio     : false,
    datasetFill             : false,
           /* title: {
                display: false,
                text: 'Chart.js bar Chart'
            },*/
            animation: {
                animateScale: true
            },
            scales: {
              xAxes: [{
                  stacked: true,
                }],
                yAxes: [{
                      stacked: true,
                    ticks: {
                        beginAtZero: true,
                        callback: function (value) { if (Number.isInteger(value)) { return value; } },
                        stepSize: 1
                    }
                }]
            }
        }  
  });
}


