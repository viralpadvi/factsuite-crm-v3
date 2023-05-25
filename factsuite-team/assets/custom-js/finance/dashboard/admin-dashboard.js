var sales_by_item = 0,
  failed_cases = 0,
  completed_cases = 0,
  pending_cases = 0,
  sales_by_item_count_chart,
  top_selling_chart;

var percentage_to_fixed = 2;

get_sales_by_item_count();
function get_sales_by_item_count() {
  var client_id = $('#sales_by_item_select_product').val();
  var sales_by_item_select_time = $('#sales_by_item_select_time').val(); 
  $.ajax({
    url: base_url+"client/get_sales_by_item_count", 
    type: "POST",
    dataType : 'JSON',
    data: {
      client_id : client_id, 
      sales_by_item_select_time : sales_by_item_select_time, 
    },
    success: function(sales_by_item_count) {
      $('#sales_by_item_count').empty('');
      if (sales_by_item_count == 0) {
        $('#sales_by_item_error_div').html('<span class="text-danger">No data Available</span>');
      } else {
        $('#sales_by_item_error_div').html('');
      }
      show_sales_by_item_count(sales_by_item_count);
    }
  });
}
 
function show_sales_by_item_count(sales_by_item) {
  var sales_by_item_count_chart = '';
  var sales_by_item_count_canvas = $('#sales_by_item_count').get(0).getContext('2d');
  var sales_by_item_count_data  = {
    labels: [
      'Total Sales: '+sales_by_item,
    ],
    datasets: [{
      data: [sales_by_item],
      backgroundColor : ['#2DCD7A'],
    }]
  }

  var sales_by_item_count_options = {
    maintainAspectRatio : false,
    responsive : true,
  };

  if(sales_by_item_count_chart) {
    sales_by_item_count_chart.destroy();
  }

  sales_by_item_count_chart = new Chart(sales_by_item_count_canvas, {
    // doughnut
    type: 'pie',
    data: sales_by_item_count_data,
    options: sales_by_item_count_options      
  });
}


get_top_selling_items();
function get_top_selling_items() {
  var top_selling_items_select = $('#top_selling_items_select').val();
  $.ajax({
    url: base_url+"client/get_top_selling_items", 
    type: "POST",
    dataType : 'JSON',
    data: {
      top_selling_items_select : top_selling_items_select
    },
    success: function(top_selling_items) {
      $('#top_selling_items_result').empty('');
      if (top_selling_items.length == 0) {
        $('#top_selling_items_error_div').html('<span class="text-danger">No data Available</span>');
      } else {
        $('#top_selling_items_error_div').html('');
        show_top_selling_items(top_selling_items);
      }
    }
  });
} 
function show_top_selling_items1(top_selling_items) {
  // var top_selling_chart = '';
  var top_selling_canvas = $('#top_selling_items_result').get(0).getContext('2d');
  var label_array = [];
  var product_sales_array = [];
  var background_color_array = [];
  var background_colors = ['#2DCD7A','#FF9F43','#2DCD7A','#ED5F5F','#FF9F43','#2DCD7A','#ED5F5F','#FF9F43','#2DCD7A','#ED5F5F'];
  
  

    jQuery.each(top_selling_items, (index, item) => {
    label_array.push(item.service_name);
    // background_color_array.push(background_colors[i]);
    product_sales_array.push(item.total);
    });
   /* label_array.push(top_selling_items[i].service_name);
    // background_color_array.push(background_colors[i]);
    product_sales_array.push(top_selling_items[i].total);*/
 
  var top_selling_data  = {
    labels: label_array,

    datasets: [/*{
      label               : 'Top Selling Packag',
      backgroundColor     : background_colors,
      borderColor         : 'rgba(60,141,188,0.8)',
      pointRadius         : false,
      pointColor          : '#3b8bba',
      pointStrokeColor    : 'rgba(60,141,188,1)',
      pointHighlightFill  : '#fff',
      pointHighlightStroke: 'rgba(60,141,188,1)',
      data                : product_sales_array
    }*/{
      label:'Inprogress',
      data: [1,2,3],
      backgroundColor : ['#f56954','#f56954','#f56954','#f56954','#f56954','#f56954'],
    },{
      label:'Insuff',
      data: [3,4,5],
      backgroundColor :  [ '#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
    },{
      label:'Insuff',
      data: [6,7,8],
      backgroundColor :  [ '#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
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

  if(top_selling_chart) {
    top_selling_chart.destroy();
  }

  top_selling_chart = new Chart(top_selling_canvas, {
    type: 'bar',
    data: barChartData,
    options: top_selling_options      
  });
}


var inprogress_case_component ='';
var sales_by_item_count_canvas ='';
function show_top_selling_items(top_selling_items) {
  // var top_selling_chart = '';
  var top_selling_canvas = $('#top_selling_items_result').get(0).getContext('2d');
  var label_array = [];
  var product_sales_array = [];
  var background_color_array = [];
  var background_colors = ['#2DCD7A','#FF9F43','#2DCD7A','#ED5F5F','#FF9F43','#2DCD7A','#ED5F5F','#FF9F43','#2DCD7A','#ED5F5F'];
  
  
 var  Basic = [];
 var  All_Checks = [];
 var  Standard = [];
 var  Premium = [];
    jQuery.each(top_selling_items, (index, item) => {
    label_array.push(item.service_name);  
    var marge = item.package_name;
    var total = item.total;  
    var a='',b='',c='',d='';
   a = marge.indexOf("Basic");
   b = marge.indexOf("All Checks");
   c = marge.indexOf("Standard");
   d = marge.indexOf("Premium"); 
    
       if (a != -1) {
        Basic.push(total[a])
       }else{
        Basic.push(0)
       }

       if (b != -1) {
        
        All_Checks.push(total[b])
       }else{
        All_Checks.push(0)
       }

       if (c != -1) {
        Standard.push(total[c])
       }else{
        Standard.push(0)
       }

       if (d != -1) {
        Premium.push(total[d])
       }else{
        Premium.push(0)
       } 

    });
   
  var sales_by_item_count_data  = {
    labels: label_array, 
    datasets: [{
      label:'Basic',
      data: Basic,
      backgroundColor :  ['#f56954','#f56954','#f56954','#f56954','#f56954','#f56954'],
    },{
      label:'All Checks',
      data: All_Checks,
      backgroundColor :  [ '#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
    },{
      label:'Standard',
      data: [4,5,6],
      backgroundColor :  [ '#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12'],
    },{
      label:'Premium',
      data: [0,0,4],
      backgroundColor :  [ '#2DCD7A','#2DCD7A','#2DCD7A','#2DCD7A','#2DCD7A','#2DCD7A'],
    }]
  }


  var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

  if(inprogress_case_component) {
    inprogress_case_component.destroy();
  }
 
  inprogress_case_component = new Chart(top_selling_canvas, {
    // doughnut
    /*type: 'bar',
    data: sales_by_item_count_data,
    options: stackedBarChartOptions */    
     type: 'bar',
        data: sales_by_item_count_data,
        beginAtZero: true,
        options: {
            responsive: true,
           /* legend: {
                display: false
            },*/
             maintainAspectRatio     : false,
    datasetFill             : false,
            
            scales: {
              xAxes: [{
                  stacked: true,
                }],
                yAxes: [{
                      stacked: true,
                    // ticks: {
                        // beginAtZero: true,
                        // callback: function (value) { if (Number.isInteger(value)) { return value; } },
                        // stepSize: 1
                    // }
                }]
            }
        }    
  });

 }


get_total_sales();
function get_total_sales() {
  var total_sales_time = $('#total_sales_select_time').val();
  $.ajax({
    url: base_url+"client/get_total_sales", 
    type: "POST",
    dataType : 'JSON',
    data: {
      total_sales_time : total_sales_time
    },
    success: function(total_sales) {
      $('#total_sales_count').html('<i class="fa fa-inr pr-1"></i>'+total_sales.toLocaleString('en-IN')+' /-');
    }
  });
}



get_total_no_of_orders();
function get_total_no_of_orders() {
  var no_of_orders_time = $('#no_of_orders_select_time').val();
  $.ajax({
    url: base_url+"client/get_total_no_of_orders", 
    type: "POST",
    dataType : 'JSON',
    data: {
      no_of_orders_time : no_of_orders_time
    },
    success: function(total_orders) {
      $('#no-of-orders-count').html(total_orders.toLocaleString('en-IN'));
    }
  }); 
}

get_average_order_value();
function  get_average_order_value() {
  var avg_order_value_time = $('#avg_order_value_select_time').val();
  $.ajax({
    url: base_url+"client/get_average_order_value", 
    type: "POST",
    dataType : 'JSON',
    data: {
      avg_order_value_time : avg_order_value_time
    },
    success: function(average_order_value) {
      $('#avergare-order-sales').html('<i class="fa fa-inr pr-1"></i>'+average_order_value.toLocaleString('en-IN')+' /-');
    }
  });
}

get_total_order_returns();
function get_total_order_returns() {
  var total_returns_time = $('#total_returns_select_time').val();
  $.ajax({
    url: base_url+"client/get_total_order_returns", 
    type: "POST",
    dataType : 'JSON',
    data: {
      total_returns_time : total_returns_time
    },
    success: function(product_returned_count) {
      $('#total-returns-count').html(product_returned_count.toLocaleString('en-IN'));
    }
  }); 
}



component_status_in_progress_case();
function component_status_in_progress_case() {
  /*var sales_by_item_select_product = $('#sales_by_item_select_product').val();
  var sales_by_item_select_time = $('#sales_by_item_select_time').val();
  var sales_by_item_coupons = $('#sales_by_item_coupons_select').val();*/
  var manager = $("#ageing_manager").val();
  var candidate = $("#candidate").val();
  $.ajax({
    type: "POST",
    url:  base_url+"client/all_component_ageing_in_progress_analytics", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:manager,
      candidate:candidate
    },
    success: function(case_ageing) {
      $('#component_status_inprogress_status').empty('');
      if (case_ageing.length == 0) {
        $('#component_status_inprogress_status_error_div').html('<span class="text-danger">No data Available</span>');
      } else {
        $('#component_status_inprogress_status_error_div').html('');
      }
      show_component_status_in_progress_case(case_ageing.client_data);
    }
  });
}

function show_component_status_in_progress_case(param_data) { 
 
  var component_name = []; 
  var in_progress =[];
  var in_progress_color =[];
  var insuff =[];
  var insuff_color =[];
  var client_clarification =[];
  var client_clarification_color =[];
  var not_init =[];
  var not_init_color =[];
  // var total =[];
  // var total_color =[];
  $.each(param_data, function(key,value) {
    component_name.push(value['component_name']);
    in_progress.push(value['in_progress']);
    in_progress_color.push('#00a65a');
    insuff.push(value['insuff']);
    insuff_color.push('#f39c12');
    client_clarification.push(value['client_clarification']);
    client_clarification_color.push("#00c0ef");
    not_init.push(value['new']);
    not_init_color.push('#3c8dbc');
    // total.push(value['total']);
    // total_color.push('#d2d6de');
  });
  var inprogress_case_component = '';
  var sales_by_item_count_canvas = $('#component_status_inprogress_status').get(0).getContext('2d');

  
  var sales_by_item_count_data  = {
    labels: component_name, 
    datasets: [/*{
      label:'Inprogress',
      data: in_progress,
      backgroundColor : in_progress_color, // ['#f56954','#f56954','#f56954','#f56954','#f56954','#f56954'],
    },{
      label:'Insuff',
      data: insuff,
      backgroundColor :  insuff_color,//[ '#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
    },{
      label:'Client Clarification',
      data: client_clarification,
      backgroundColor :  client_clarification_color,//[ '#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12'],
    },*/{
      label:'New',
      data: not_init,
      backgroundColor : not_init_color,//[ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
    }/*,{
      label:'Total',
      data: total,
      backgroundColor : total_color,//[ '#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc'],
    }*/]
  }


  var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

  if(inprogress_case_component) {
    inprogress_case_component.destroy();
  }
 
  inprogress_case_component = new Chart(sales_by_item_count_canvas, {
    // doughnut
    /*type: 'bar',
    data: sales_by_item_count_data,
    options: stackedBarChartOptions */    
     type: 'bar',
        data: sales_by_item_count_data,
        beginAtZero: true,
        options: {
            responsive: true,
           /* legend: {
                display: false
            },*/
             maintainAspectRatio     : false,
    datasetFill             : false,
            
            scales: {
              xAxes: [{
                  stacked: true,
                }],
                yAxes: [{
                      stacked: true,
                    // ticks: {
                        // beginAtZero: true,
                        // callback: function (value) { if (Number.isInteger(value)) { return value; } },
                        // stepSize: 1
                    // }
                }]
            }
        }    
  });
  
}
 
