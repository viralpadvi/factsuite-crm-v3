// get_overall_case_progress();
function get_overall_case_progress() {
   sessionStorage.clear(); 
  $.ajax({
      url: base_url+"admin_Dashboard/get_overall_case_progress", 
      type: "ajax",
      dataType : 'JSON',
    success: function(overall_case_progress) {
        $('#sales_by_item_count').empty('');
        if (overall_case_progress == 0) {
          $('#sales_by_item_error_div').html('<span class="text-danger">No data Available</span>');
        } else {
          $('#sales_by_item_error_div').html('');
        }
        show_overall_case_progress(overall_case_progress);
    }
  });
}

function common_filter_for_client(){
  total_recievals_items();  
  get_top_selling_current_items();
  total_closure_items();
  today_total_closure_items();
  all_case_list_count();
all_tat_cases(); 
}

function next_value(page,param){
 total_recievals_items(page,param);
}

$("#to-date-recievals").on('change',function(){
total_recievals_items();   
 total_closure_items();
});
total_recievals_items();
function total_recievals_items(page=0,param='') { 
  var recievals_manager = $('#recievals_manager').val();
  var recievals_status = $('#recievals_status').val();
  var from = $('#from-date-recievals').val();
  var to = $('#to-date-recievals').val();
  $.ajax({
    type: "POST",
    url: base_url+"Admin_Analytics/get_all_client_cases/"+page, 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:recievals_manager,
      status:recievals_status,
      from:from,
      to:to,
    },
    success: function(top_selling_items) {

    if (top_selling_items.client_data.length == 10) {
      if (param=='1') {
        var val = page-1;
        if (page !=0) {
        $('next-value').attr('onclick','next_value('+val+',1)'); 
        $('preview-value').attr('onclick','next_value('+page+',0)');
        }
      }else if (param=='0'){
         var val = page-1;
        $('preview-value').attr('onclick','next_value('+val+',1)');
        $('next-value').attr('onclick','next_value('+page+',0)');
      }
    } 
      $('#top_selling_items_result').empty('');
      if (top_selling_items.client_data.length == 0) {
        $('#top_selling_items_error_div').html('<span class="text-danger">No data Available</span>');
        // showtotal_recievals_items(top_selling_items.client_data,10);
      } else {
        $('#top_selling_items_error_div').html('');
        showtotal_recievals_items(top_selling_items.client_data,10);
      }
    }
  });
}
  var top_selling_chart = '';
function showtotal_recievals_items(top_selling_items,top_selling_items_select) {
  var top_selling_canvas = $('#top_selling_items_result').get(0).getContext('2d');
  var label_array = [];
  var product_sales_array = [];
  var background_color_array = [];
  var background_colors = ['#2DCD7A','#FF9F43','#2DCD7A','#ED5F5F','#FF9F43','#2DCD7A','#ED5F5F','#FF9F43','#2DCD7A','#ED5F5F'];
  var lenght_t = top_selling_items.length;
  /*if (top_selling_items.length > 10 && top_selling_items_select == 10) {
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

/*  var areaChartOptions = {
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
  } */

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
   /* type: 'bar',
    data: barChartData,
    options: top_selling_options  */

         type: 'bar',
        data: barChartData,
        beginAtZero: true,
        options: {
            responsive: true,
           /* legend: {
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
                yAxes: [{
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


function today_next_value(page,param){
 get_top_selling_current_items(page,param);
} 


get_top_selling_current_items();
function get_top_selling_current_items(page=0,param='') { 
  var current_day_manager = $('#recievals_manager').val();
  var current_day_status = $('#recievals_status').val(); 
  $.ajax({
    type: "POST",
    url: base_url+"Admin_Analytics/get_currunt_day_data_counting/"+page, 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:current_day_manager,
      status:current_day_status
    },
    success: function(top_selling_items) {

       if (top_selling_items.client_data.length == 10) {
      if (param=='1') {
        var val = page-1;
        if (page !=0) {
        $('today-next-value').attr('onclick','next_value('+val+',1)'); 
        $('today-preview-value').attr('onclick','next_value('+page+',0)');
        }
      }else if (param=='0'){
         var val = page-1;
        $('today-preview-value').attr('onclick','next_value('+val+',1)');
        $('today-next-value').attr('onclick','next_value('+page+',0)');
      }
    }
 
      $('#_today_top_selling_items_result').empty('');
      if (top_selling_items.client_data.length == 0) {
        $('#_today_top_selling_items_error_div').html('<span class="text-danger">No data Available</span>');
        // show_top_selling_current_items(top_selling_items.client_data,10);
      } else {
        $('#_today_top_selling_items_error_div').html('');
        show_top_selling_current_items(top_selling_items.client_data,10);
      }
    }
  });
}
  var top_selling_chart_data = '';
function show_top_selling_current_items(top_selling_items,top_selling_items_select) {
  var top_selling_canvas = $('#_today_top_selling_items_result').get(0).getContext('2d');
  var label_array = [];
  var product_sales_array = [];
  var background_color_array = [];
  var background_colors = ['#2DCD7A','#FF9F43','#2DCD7A','#ED5F5F','#FF9F43','#2DCD7A','#ED5F5F','#FF9F43','#2DCD7A','#ED5F5F'];
  var lenght_t = top_selling_items.length;
 /* if (top_selling_items.length > 10 && top_selling_items_select == 10) {
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

  if(top_selling_chart_data) {
    top_selling_chart_data.destroy();
  }

  top_selling_chart_data = new Chart(top_selling_canvas, {
    // type: 'bar',
    // data: barChartData,
    // options: top_selling_options  
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
          /*  title: {
                display: false,
                text: 'Chart.js bar Chart'
            },*/
            animation: {
                animateScale: true
            },
            scales: {
                yAxes: [{
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




function total_closure_next_value(page,param){
 total_closure_items(page,param);
} 

$("#to-date-closure").on('change',function(){
  // from-date-closure
total_closure_items();
});
total_closure_items();
function total_closure_items(page=0,param='') { 
 var closure_manager = $('#recievals_manager').val();
  var closure_status = $('#recievals_status').val();
  var from = $('#from-date-recievals').val();
  var to = $('#to-date-recievals').val();
  $.ajax({
    type: "POST",
    url: base_url+"Admin_Analytics/get_all_client_closure_cases/"+page, 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:closure_manager,
      status:closure_status,
      from:from,
      to:to,
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
    /*type: 'bar',
    data: barChartData,
    options: top_selling_options*/
        type: 'bar',
        data: barChartData,
        beginAtZero: true,
        options: {
            responsive: true,
           /* legend: {
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
                yAxes: [{
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






function today_closure_next_value(page,param){
 today_total_closure_items(page,param);
} 

today_total_closure_items();
function today_total_closure_items(page=0,param='') { 
  var today_closure_manager = $('#recievals_manager').val();
  var today_closure_status = $('#recievals_status').val(); 
  $.ajax({
    type: "POST",
    url: base_url+"Admin_Analytics/get_currunt_day_closure_data_counting/"+page, 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:today_closure_manager,
      status:today_closure_status
    },
    success: function(top_selling_items) {
  if (top_selling_items.client_data.length == 10) {
      if (param=='1') {
        var val = page-1;
        if (page !=0) {
        $('today-closure-next-value').attr('onclick','next_value('+val+',1)'); 
        $('today-closure-preview-value').attr('onclick','next_value('+page+',0)');
        }
      }else if (param=='0'){
         var val = page-1;
        $('today-closure-preview-value').attr('onclick','next_value('+val+',1)');
        $('today-closure-next-value').attr('onclick','next_value('+page+',0)');
      }
    }
      $('#today_total_closure_items_result').empty('');
      if (top_selling_items.client_data.length == 0) {
        $('#today_total_closure_items_error_div').html('<span class="text-danger">No data Available</span>');
        show_today_total_closure_items(top_selling_items.client_data,10);
      } else {
        $('#today_total_closure_items_error_div').html('');
        show_today_total_closure_items(top_selling_items.client_data,10);
      }
    }
  });
}



  var today_total_closure_data = '';
function show_today_total_closure_items(top_selling_items,top_selling_items_select) {
  var top_selling_canvas = $('#today_total_closure_items_result').get(0).getContext('2d');
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

  if(today_total_closure_data) {
    today_total_closure_data.destroy();
  }

  today_total_closure_data = new Chart(top_selling_canvas, {
    /*type: 'bar',
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
            /*title: {
                display: false,
                text: 'Chart.js bar Chart'
            },*/
            animation: {
                animateScale: true
            },
            scales: {
                yAxes: [{
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


function progress_status(){
progress_completed_case_count();
// progress_pending_case_count();

}

progress_completed_case_count();
function progress_completed_case_count() { 
   var status_manager = $('#recievals_manager').val(); 
  $.ajax({
    type: "POST",
    url:  base_url+"Admin_Analytics/get_all_client_wise_progress_cases", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:status_manager
    },
    success: function(sales_by_item_count) { 
      if (sales_by_item_count.client_data.completed == 0 && sales_by_item_count.client_data.pending == 0 && sales_by_item_count.client_data.total == 0) {
        $('#sales_by_item_error_div').html('<span class="text-danger">No data Available</span>');
      
        $('#sales_by_item_count').empty();
       
      } else {
        $('#sales_by_item_error_div').html('');
      show_all_completed_cases_count(sales_by_item_count.client_data);
      }
    }
  });
}
function show_all_completed_cases_count(sales_by_item) {
  var all_progress_case = '';
  var all_progress_case_canvas = $('#sales_by_item_count').get(0).getContext('2d');
  var all_progress_case_data  = {
    labels: [
      'Total Insuff Case: '+sales_by_item.insuff,
      'Total In Progress Case: '+sales_by_item.pending,
      'Total Completed Case: '+sales_by_item.completed,
      'Total Case: '+sales_by_item.total,
    ],
    datasets: [{
      label:"Case Progress",
      data: [sales_by_item.insuff,sales_by_item.completed,sales_by_item.pending,sales_by_item.total],
      backgroundColor : ['#f56954','#00a65a','#f39c12','#00c0ef','#3c8dbc','#d2d6de','#2DCD7A'],
    }]
  }

  var all_progress_case_options = {
    maintainAspectRatio : false,
    responsive : true,
  };

  if(all_progress_case) {
    all_progress_case.destroy();
  }
 
  all_progress_case = new Chart(all_progress_case_canvas, {
    // doughnut
   /* type: 'bar',
    data: all_progress_case_data,
    options: all_progress_case_options */  
      type: 'bar',
        data: all_progress_case_data,
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
                yAxes: [{
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

 


all_case_list_count();
function all_case_list_count() {
  var manager = $('#recievals_manager').val();
  var sales_by_item_select_time = $('#sales_by_item_select_time').val();
  var sales_by_item_coupons = $('#sales_by_item_coupons_select').val();
  $.ajax({
    type: "POST",
    url:  base_url+"Admin_Analytics/get_all_client_wise_inventory_cases", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:manager
    },
    success: function(total_active_cases_inventory_count) {
      $('#total_active_cases_inventory_count').empty('');
      if (total_active_cases_inventory_count.length == 0) {
        $('#total_active_cases_inventory_error_div').html('<span class="text-danger">No data Available</span>');
      } else {
        $('#total_active_cases_inventory_error_div').html('');
      }
      show_all_case_list_count(total_active_cases_inventory_count.client_data);
    }
  });
}
function show_all_case_list_count(sales_by_item) {
  $('#inventory-total').html(sales_by_item.total);
  var pending_case_count_chart = '';
  var sales_by_item_count_canvas = $('#total_active_cases_inventory_count').get(0).getContext('2d');

  
  var sales_by_item_count_data  = {
    labels: [
      // 'New: '+sales_by_item.init,
      'Not Initiated / New: '+sales_by_item.init,
      'In Progress: '+sales_by_item.pending,
      'Client Clarification: '+sales_by_item.completed,
      'Insuff: '+sales_by_item.insuff,
      'Total Case: '+sales_by_item.total,
    ],
    datasets: [/*{
      data: [sales_by_item.init,sales_by_item.init,sales_by_item.pending,sales_by_item.completed,sales_by_item.insuff],
      backgroundColor : ['#f56954','#00a65a','#f39c12','#00c0ef','#3c8dbc','#d2d6de','#ED5F5F','#FF9F43','#2DCD7A','#ED5F5F'],
    }*/
    {
      label:'Case Inventory',
      data: [/*sales_by_item.init,*/sales_by_item.init,sales_by_item.pending,sales_by_item.completed,sales_by_item.insuff,sales_by_item.total],
      backgroundColor :   ['#f56954','#00a65a','#f39c12','#00c0ef','#3c8dbc','#d2d6de','#FF9F43','#2DCD7A','#ED5F5F'],
    }
    ]
  }

  var sales_by_item_count_options = {
    maintainAspectRatio : false,
    responsive : true,
  };

  if(pending_case_count_chart) {
    pending_case_count_chart.destroy();
  }
 
  pending_case_count_chart = new Chart(sales_by_item_count_canvas, {
    // doughnut
    /*type: 'bar',
    data: sales_by_item_count_data,
    options: sales_by_item_count_options  */    

     type: 'bar',
        data: sales_by_item_count_data,
        beginAtZero: true,
        options: {
            responsive: true,
           /* legend: {
                display: false
            },*/
             maintainAspectRatio     : false,
    // datasetFill             : false,
           /* title: {
                display: false,
                text: 'Chart.js bar Chart'
            },*/
            animation: {
                animateScale: true
            },
            scales: {
                yAxes: [{
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



all_tat_cases();
function all_tat_cases() {
  var status_manager = $('#recievals_manager').val();
  var today_closure_status = $('#recievals_status').val(); 
  $.ajax({
    type: "POST",
    url:  base_url+"Admin_Analytics/get_all_tat_details", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:status_manager,
      status:today_closure_status
    },
    success: function(total_active_cases_inventory_count) {
      $('#total_tat').empty('');
      if (total_active_cases_inventory_count.length == 0) {
        $('#total_all_tat_error_div').html('<span class="text-danger">No data Available</span>');
      } else {
        $('#total_all_tat_error_div').html('');
      }
      show_all_tat_cases(total_active_cases_inventory_count.client_data);
    }
  });
}
function show_all_tat_cases(sales_by_item) {
  // $('#inventory-total').html(sales_by_item.total);
  var total_tat_cases = '';
  var sales_by_item_count_canvas = $('#total_tat').get(0).getContext('2d');

  
  var sales_by_item_count_data  = {
    labels: [ 
      'Not Initiated: '+sales_by_item.init, 
      'In-TAT Cases: '+sales_by_item.new, 
      'Over-TAT Cases: '+sales_by_item.old
    ],
    datasets: [{
      label:"TAT Cases",
      data: [sales_by_item.init,sales_by_item.new,sales_by_item.old],
      backgroundColor : ['#00a65a','#f56954','#f39c12','#00c0ef','#3c8dbc','#d2d6de','#FF9F43','#2DCD7A','#ED5F5F'],
    }]
  }

  var sales_by_item_count_options = {
    maintainAspectRatio : false,
    responsive : true,
  };

  if(total_tat_cases) {
    total_tat_cases.destroy();
  }
 
  total_tat_cases = new Chart(sales_by_item_count_canvas, {
    // doughnut
   /* type: 'bar',
    data: sales_by_item_count_data,
    options: sales_by_item_count_options */
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
            /*title: {
                display: false,
                text: 'Chart.js bar Chart'
            },*/
            animation: {
                animateScale: true
            },
            scales: {
                yAxes: [{
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


/*all_pending_case_count_error_div
case_ageing.length*/
// get_all_tat_details


get_monthly_pending_cases();
function get_monthly_pending_cases() { 

  var manager = $('#ageing_manager').val();
  $.ajax({
    type: "POST",
    url:  base_url+"Admin_Analytics/get_monthly_pending_cases", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager : manager,
    },
    success: function(data) {
      // alert(JSON.stringify(data))
      $("#today_progress").html(data.client_data.in_progress_total); 
      $("#closure_today").html(data.client_data.today_closure); 
      $("#closure_month").html(data.client_data.current_month); 
      $("#closure_month_total").html(data.client_data.month_closure); 
      $("#carry_month").html(data.client_data.two_month); 
      $("#two_month").html(data.client_data.two_month_total); 
      $("#receival_month").html(data.client_data.one_month); 
      $("#receival_month_total").html(data.client_data.one_month_total); 
      $("#total_closure_cases").html(data.client_data.total);
      $("#receival_data").html(data.client_data.in_progress_total);
      $("#total-re-init").html(data.client_data.current_month_total);
      $("#re-init").html(data.client_data.today);

 
    /*  return array(
        'in_progress_total'=>array_sum($in_progress_array),
        'one_month_total'=>array_sum($one_month_array),
        'one_month'=>isset($one_month_array_month[0])?$one_month_array_month[0]:'-',
        'two_month_total'=>array_sum($two_month_array),
        'two_month'=>isset($two_month_array_month[0])?$two_month_array_month[0]:'-',
        'current_month_total'=>array_sum($current_month_array),
        'current_month'=>isset($current_month_array_month[0])?$current_month_array_month[0]:'-',
        'today'=>array_sum($today_array),
        'today_closure'=>array_sum($today_closure_array),
        'month_closure'=>array_sum($month_closure_array),
        'till_closure'=>array_sum($till_closure_array)
      ); */
    }
  });
}


///




all_ageing_profress_cases();
function all_ageing_profress_cases() {
  /*var sales_by_item_select_product = $('#sales_by_item_select_product').val();
  var sales_by_item_select_time = $('#sales_by_item_select_time').val();
  var sales_by_item_coupons = $('#sales_by_item_coupons_select').val();*/
  $.ajax({
    type: "POST",
    url:  base_url+"Admin_Analytics/all_in_progress_analytics", 
    dataType : 'JSON',
    data: {
      is_admin : 1
    },
    success: function(case_ageing) {
      $('#all_progress_case_ageing').empty('');
      if (case_ageing.length == 0) {
        $('#all_progress_case_ageing_error_div').html('<span class="text-danger">No data Available</span>');
      } else {
        $('#all_progress_case_ageing_error_div').html('');
      }
      show_all_progress_ageing_case(case_ageing.client_data);
    }
  });
}

function show_all_progress_ageing_case(sales_by_item) { 
 
  var total_progress_ageing_case = '';
  var sales_by_item_count_canvas = $('#all_progress_case_ageing').get(0).getContext('2d');

  
  var sales_by_item_count_data  = {
    labels: [ 
      '1 - 7', 
      '8 - 15', 
      '16 - 30',
      '31 - 45',
      '46 - 60',
      ' > 60',
    ],
    datasets: [{
      label:'In Progress',
      data: sales_by_item.in_progress,
      backgroundColor :  ['#f56954','#f56954','#f56954','#f56954','#f56954','#f56954'],
    },{
      label:'Insuff',
      data: sales_by_item.insuff,
      backgroundColor :  [ '#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
    },{
      label:'client clarification',
      data: sales_by_item.client_clarification,
      backgroundColor :  [ '#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12'],
    },{
      label:'New',
      data: sales_by_item.not_init,
      backgroundColor : [ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
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

  if(total_progress_ageing_case) {
    total_progress_ageing_case.destroy();
  }
 
  total_progress_ageing_case = new Chart(sales_by_item_count_canvas, {
    // doughnut
    /*type: 'bar',
    data: sales_by_item_count_data,
    options: stackedBarChartOptions */  
     type: 'bar',
        data: sales_by_item_count_data,
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
 



all_ageing_progress_cases_inventory();
function all_ageing_progress_cases_inventory() {
  /*var sales_by_item_select_product = $('#sales_by_item_select_product').val();
  var sales_by_item_select_time = $('#sales_by_item_select_time').val();
  var sales_by_item_coupons = $('#sales_by_item_coupons_select').val();*/
 var manager =  $("#ageing_manager").val();
  $.ajax({
    type: "POST",
    url:  base_url+"Admin_Analytics/all_in_progress_analytics_inventory", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:manager
    },
    success: function(case_ageing) {
      $('#all_progress_case_ageing_inventory').empty('');
      if (case_ageing.length == 0) {
        $('#all_progress_case_ageing_inventory_error_div').html('<span class="text-danger">No data Available</span>');
      } else {
        $('#all_progress_case_ageing_inventory_error_div').html('');
      }
      show_all_progress_ageing_case_inventory(case_ageing.client_data);
    }
  });
}

function show_all_progress_ageing_case_inventory(sales_by_item) { 
 
  var total_progress_ageing_case_inventory = '';
  var sales_by_item_count_canvas = $('#all_progress_case_ageing_inventory').get(0).getContext('2d');

  
  var sales_by_item_count_data  = {
    labels: [ 
      '1 - 7', 
      '8 - 15', 
      '16 - 30',
      '31 - 45',
      '46 - 60',
      ' > 60',
    ],
    datasets: [{
      label:'In Progress',
      data: sales_by_item.in_progress,
      backgroundColor :  ['#f56954','#f56954','#f56954','#f56954','#f56954','#f56954'],
    }/*,{
      label:'Insuff',
      data: sales_by_item.insuff,
      backgroundColor :  [ '#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
    },{
      label:'client clarification',
      data: sales_by_item.client_clarification,
      backgroundColor :  [ '#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12'],
    }*/,{
      label:'New',
      data: sales_by_item.not_init,
      backgroundColor : [ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
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

  if(total_progress_ageing_case_inventory) {
    total_progress_ageing_case_inventory.destroy();
  }
 
  total_progress_ageing_case_inventory = new Chart(sales_by_item_count_canvas, {
    // doughnut
    /*type: 'bar',
    data: sales_by_item_count_data,
    options: stackedBarChartOptions  */  
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
            /*title: {
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
 

all_ageing_completed_cases();
function all_ageing_completed_cases() {
  /*var sales_by_item_select_product = $('#sales_by_item_select_product').val();
  var sales_by_item_select_time = $('#sales_by_item_select_time').val();
  var sales_by_item_coupons = $('#sales_by_item_coupons_select').val();*/
  var manager =  $("#ageing_manager").val();
  $.ajax({
    type: "POST",
    url:  base_url+"Admin_Analytics/all_close_cases_analytics", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:manager
    },
    success: function(case_ageing) { 
      $('#all_close_case_ageing').empty('');
      if (case_ageing.length == 0) {
        $('#all_close_case_ageing_error_div').html('<span class="text-danger">No data Available</span>');
      } else {
        $('#all_close_case_ageing_error_div').html('');
      }
      all_show_close_ageing_case(case_ageing.client_data);
    }
  });
}

function all_show_close_ageing_case(param_data) {  
  var total_close_case_ageing = '';
  var sales_by_item_count_canvas = $('#all_close_case_ageing').get(0).getContext('2d');

  
  var sales_by_item_count_data  = {
    labels: [ 
      '1 - 7', 
      '8 - 15', 
      '16 - 30',
      '31 - 45',
      '46 - 60',
      ' > 60',
    ], 
    datasets: [{
      label:'Verified Clear',
      data: param_data.verified,
      backgroundColor :  ['#f56954','#f56954','#f56954','#f56954','#f56954','#f56954'],
    },{
      label:'Verify Discrepancy',
      data: param_data.discrepancy,
      backgroundColor :  [ '#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
    },{
      label:'Unable to verify',
      data: param_data.unable_to_verify,
      backgroundColor :  [ '#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12'],
    },{
      label:'Close Insuff',
      data: param_data.close_insuff,
      backgroundColor : [ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
    },{
      label:'Stop Check',
      data: param_data.stop_check,
      backgroundColor : [ '#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc'],
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

  if(total_close_case_ageing) {
    total_close_case_ageing.destroy();
  }
 
  total_close_case_ageing = new Chart(sales_by_item_count_canvas, {
    // doughnut
    // type: 'bar',
    // data: sales_by_item_count_data,
    // options: stackedBarChartOptions    
    type: 'bar',
        data: sales_by_item_count_data,
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
 

function component_status_client(){
  component_status_in_progress_case();
  component_status_completed_case();
  component_ageing_inprogress_case();
  component_ageing_completed_case();
  all_ageing_completed_cases(); 
  all_ageing_progress_cases_inventory();
  progress_status(); 
get_monthly_pending_cases();
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
    url:  base_url+"Admin_Analytics/all_component_ageing_in_progress_analytics", 
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
  var total =[];
  var total_color =[];
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
    total.push(value['total']);
    total_color.push('#d2d6de');
  });
  var inprogress_case_component = '';
  var sales_by_item_count_canvas = $('#component_status_inprogress_status').get(0).getContext('2d');

  
  var sales_by_item_count_data  = {
    labels: component_name, 
    datasets: [{
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
    },{
      label:'New',
      data: not_init,
      backgroundColor : not_init_color,//[ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
    },{
      label:'Total',
      data: total,
      backgroundColor : total_color,//[ '#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc'],
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
 



component_status_completed_case();
function component_status_completed_case() {
  /*var sales_by_item_select_product = $('#sales_by_item_select_product').val();
  var sales_by_item_select_time = $('#sales_by_item_select_time').val();
  var sales_by_item_coupons = $('#sales_by_item_coupons_select').val();*/
   var manager = $("#ageing_manager").val();
   var candidate = $("#candidate").val();
  $.ajax({
    type: "POST",
    url:  base_url+"Admin_Analytics/all_component_ageing_completed_analytics", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:manager,
      candidate:candidate,
    },
    success: function(case_ageing) {
      $('#component_status_completed_status').empty('');
      if (case_ageing.length == 0) {
        $('#component_status_completed_status_error_div').html('<span class="text-danger">No data Available</span>');
      } else {
        $('#component_status_completed_status_error_div').html('');
      }
      show_component_status_completed_case(case_ageing.client_data);
    }
  });
}

function show_component_status_completed_case(param_data) { 
 
  var component_name = []; 
  var verified =[];
  var verified_color =[];
  var discrepancy =[];
  var discrepancy_color =[];
  var unable_to_verify =[];
  var unable_to_verify_color =[];
  var close_insuff =[];
  var close_insuff_color =[];
  var stop_check =[];
  var stop_check_color =[];
  var total =[];
  var total_color =[];
  $.each(param_data, function(key,value) {
    component_name.push(value['component_name']);
    verified.push(value['verified']);
    verified_color.push('#f56954');
    discrepancy.push(value['discrepancy']);
    discrepancy_color.push('#00a65a');
    unable_to_verify.push(value['unable_to_verify']);
    unable_to_verify_color.push("#f39c12");
    close_insuff.push(value['close_insuff']);
    close_insuff_color.push('#00c0ef');
    stop_check.push(value['stop_check']);
    stop_check_color.push('#3c8dbc');
    total.push(value['total']);
    total_color.push('#d2d6de');
  });
  var total_completed_component = '';
  var sales_by_item_count_canvas = $('#component_status_completed_status').get(0).getContext('2d');

  
  var sales_by_item_count_data  = {
    labels: component_name, 
    datasets: [{
      label:'Verified Clear',
      data: verified,
      backgroundColor : verified_color, // ['#f56954','#f56954','#f56954','#f56954','#f56954','#f56954'],
    },{
      label:'Verify Discrepancy ',
      data: discrepancy,
      backgroundColor :  discrepancy_color,//[ '#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
    },{
      label:'Unable to Verify',
      data: unable_to_verify,
      backgroundColor :  unable_to_verify_color,//[ '#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12'],
    },{
      label:'Close Insuff',
      data: close_insuff,
      backgroundColor : close_insuff_color,//[ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
    },{
      label:'Stop Check',
      data: stop_check,
      backgroundColor : stop_check_color,//[ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
    },{
      label:'Total',
      data: total,
      backgroundColor : total_color,//[ '#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc'],
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

  if(total_completed_component) {
    total_completed_component.destroy();
  }
 
  total_completed_component = new Chart(sales_by_item_count_canvas, {
    // doughnut
   /* type: 'bar',
    data: sales_by_item_count_data,
    options: stackedBarChartOptions  */    
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
            /*title: {
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
 

 ///



component_ageing_inprogress_case();
function component_ageing_inprogress_case() {
  /*var sales_by_item_select_product = $('#sales_by_item_select_product').val();
  var sales_by_item_select_time = $('#sales_by_item_select_time').val();
  var sales_by_item_coupons = $('#sales_by_item_coupons_select').val();*/
   var manager = $("#ageing_manager").val();
   var candidate = $("#candidate").val();
  $.ajax({
    type: "POST",
    url:  base_url+"Admin_Analytics/all_component_ageing_pending_days_analytics", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:manager,
      candidate:candidate,
    },
    success: function(case_ageing) {
      $('#component_status_inprogress_days_status').empty('');
      if (case_ageing.length == 0) {
        $('#component_status_inprogress_days_status_error_div').html('<span class="text-danger">No data Available</span>');
      } else {
        $('#component_status_inprogress_days_status_error_div').html('');
      }
      show_component_inprogress_ageing_case(case_ageing.client_data);
    }
  });
}

function show_component_inprogress_ageing_case(param_data) { 
 




  var component_name = []; 
  var seven =[];
  var seven_color =[];
  var fiftin =[];
  var fiftin_color =[];
  var thirty =[];
  var thirty_color =[];
  /*var close_insuff =[];
  var close_insuff_color =[];*/
  var fortyfive =[];
  var fortyfive_color =[];
   var fortysix =[];
  var fortysix_color =[];
  var sixty =[];
  var sixty_color =[];
  var total =[];
  var total_color =[];
  $.each(param_data, function(key,value) {
    component_name.push(value['component_name']);
    seven.push(value['seven']);
    seven_color.push('#f56954');
    fiftin.push(value['fiftin']);
    fiftin_color.push('#00a65a');
    thirty.push(value['thirty']);
    thirty_color.push("#f39c12");
    fortyfive.push(value['fortyfive']);
    fortyfive_color.push('#00c0ef');
    fortysix.push(value['fortysix']);
    fortysix_color.push('#00c00f');
    sixty.push(value['sixty']);
    sixty_color.push('#3c8dbc');
    total.push(value['total']);
    total_color.push('#d2d6de');
  });
  var total_inprogress_component_days = '';
  var sales_by_item_count_canvas = $('#component_status_inprogress_days_status').get(0).getContext('2d');

  
  var sales_by_item_count_data  = {
    labels: component_name, 
    datasets: [{
      label:'1 - 7',
      data: seven,
      backgroundColor : seven_color, // ['#f56954','#f56954','#f56954','#f56954','#f56954','#f56954'],
    },{
      label:'8 - 15',
      data: fiftin,
      backgroundColor :  fiftin_color,//[ '#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
    },{
      label:'16 - 30',
      data: thirty,
      backgroundColor :  thirty_color,//[ '#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12'],
    },{
      label:'31 - 45',
      data: fortyfive,
      backgroundColor : fortyfive_color,//[ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
    },{
      label:'46 - 60',
      data: fortysix,
      backgroundColor : fortysix_color,//[ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
    },{
      label:'> 60',
      data: sixty,
      backgroundColor : sixty_color,//[ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
    },{
      label:'Total',
      data: total,
      backgroundColor : total_color,//[ '#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc'],
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

  if(total_inprogress_component_days) {
    total_inprogress_component_days.destroy();
  }
 
  total_inprogress_component_days = new Chart(sales_by_item_count_canvas, {
    // doughnut
   /* type: 'bar',
    data: sales_by_item_count_data,
    options: stackedBarChartOptions  */   
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
            /*title: {
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
 
component_ageing_completed_case();
function component_ageing_completed_case() {
  /*var sales_by_item_select_product = $('#sales_by_item_select_product').val();
  var sales_by_item_select_time = $('#sales_by_item_select_time').val();
  var sales_by_item_coupons = $('#sales_by_item_coupons_select').val();*/
   var manager = $("#ageing_manager").val();
   var candidate = $("#candidate").val();
  $.ajax({
    type: "POST",
    url:  base_url+"Admin_Analytics/all_component_ageing_completed_days_analytics", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      manager:manager,
      candidate:candidate
    },
    success: function(case_ageing) {
      $('#component_status_completed_days_status').empty('');
      if (case_ageing.length == 0) {
        $('#component_status_completed_days_status_error_div').html('<span class="text-danger">No data Available</span>');
      } else {
        $('#component_status_completed_days_status_error_div').html('');
      }
      show_component_completed_ageing_case(case_ageing.client_data);
    }
  });
}

function show_component_completed_ageing_case(param_data) { 
 




  var component_name = []; 
  var seven =[];
  var seven_color =[];
  var fiftin =[];
  var fiftin_color =[];
  var thirty =[];
  var thirty_color =[];
  /*var close_insuff =[];
  var close_insuff_color =[];*/
  var fortyfive =[];
  var fortyfive_color =[];
    var fortysix =[];
  var fortysix_color =[];
  var sixty =[];
  var sixty_color =[];
  var total =[];
  var total_color =[];
  $.each(param_data, function(key,value) {
    component_name.push(value['component_name']);
    seven.push(value['seven']);
    seven_color.push('#f56954');
    fiftin.push(value['fiftin']);
    fiftin_color.push('#00a65a');
    thirty.push(value['thirty']);
    thirty_color.push("#f39c12");
    fortyfive.push(value['fortyfive']);
    fortyfive_color.push('#00c0ef');
     fortysix.push(value['fortysix']);
    fortysix_color.push('#00c00f');
    sixty.push(value['sixty']);
    sixty_color.push('#3c8dbc');
    total.push(value['total']);
    total_color.push('#d2d6de');
  });
  var total_completed_ageing_component_days = '';
  var sales_by_item_count_canvas = $('#component_status_completed_days_status').get(0).getContext('2d');

  
  var component_completed_ageing_cases  = {
    labels: component_name, 
    datasets: [{
      label:'1 - 7',
      data: seven,
      backgroundColor : seven_color, // ['#f56954','#f56954','#f56954','#f56954','#f56954','#f56954'],
    },{
      label:'8 - 15',
      data: fiftin,
      backgroundColor :  fiftin_color,//[ '#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
    },{
      label:'16 - 30',
      data: thirty,
      backgroundColor :  thirty_color,//[ '#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12'],
    },{
      label:'31 - 45',
      data: fortyfive,
      backgroundColor : fortyfive_color,//[ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
    },{
      label:'46 - 60',
      data: fortysix,
      backgroundColor : fortysix_color,//[ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
    },{
      label:'> 60',
      data: sixty,
      backgroundColor : sixty_color,//[ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
    },{
      label:'Total',
      data: total,
      backgroundColor : total_color,//[ '#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc'],
    }]
  }


  var stackedBarChartOptions_Completed = {
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

  if(total_completed_ageing_component_days) {
    total_completed_ageing_component_days.destroy();
  }
 
  total_completed_ageing_component_days = new Chart(sales_by_item_count_canvas, {
    // doughnut
   /* type: 'bar',
    data: component_completed_ageing_cases,
    options: stackedBarChartOptions_Completed   */   
    type: 'bar',
        data: component_completed_ageing_cases,
        beginAtZero: true,
        options: {
            responsive: true,
           /* legend: {
                display: false
            },*/
             maintainAspectRatio     : false,
    datasetFill             : false,
            /*title: {
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
 


 //// component wise status 


component_wise_status_check();
function component_wise_status_check() {
  /*var sales_by_item_select_product = $('#sales_by_item_select_product').val();
  var sales_by_item_select_time = $('#sales_by_item_select_time').val();
  var sales_by_item_coupons = $('#sales_by_item_coupons_select').val();*/
  var component_id = $('#component_id').val();
  $.ajax({
    type: "POST",
    url:  base_url+"Admin_Analytics/component_wise_status_check", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      component_id:component_id
    },


    success: function(case_ageing) {
      $('#all_component_status').empty('');
      if (case_ageing.length == 0) {
        $('#all_component_status_error_div').html('<span class="text-danger">No data Available</span>');
      } else {
        $('#all_component_status_error_div').html('');
      }
      show_all_close_ageing_case(case_ageing.client_data);
    }
  });
}

function show_all_close_ageing_case(param_data) { 
 
  var total_component_wise_case = '';
  var sales_by_item_count_canvas = $('#all_component_status').get(0).getContext('2d');

  
  var sales_by_item_count_data  = {
    labels: [ 
      'Verified Clear', 
      'Verify Discrepancy', 
      'Unable to verify',
      'Close Insuff',
      'Stop Check', 
    ], 
    datasets: [{
      label:'Single Component Status',
      data: [param_data.verified,param_data.unable_to_verify,param_data.close_insuff,param_data.stop_check,param_data.total],
      backgroundColor :  ['#f56954','#00a65a','#f39c12','#00c0ef','#3c8dbc','#d2d6de'],
    }/*,{
      label:'Verify Discrepancy',
      data: param_data.discrepancy,
      backgroundColor :  [ '#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
    },{
      label:'Unable to verify',
      data: param_data.unable_to_verify,
      backgroundColor :  [ '#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12'],
    },{
      label:'Close Insuff',
      data: param_data.close_insuff,
      backgroundColor : [ '#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
    },{
      label:'Stop Check',
      data: param_data.stop_check,
      backgroundColor : [ '#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc','#3c8dbc'],
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

  if(total_component_wise_case) {
    total_component_wise_case.destroy();
  }
 
  total_component_wise_case = new Chart(sales_by_item_count_canvas, {
    // doughnut
    // type: 'bar',
    // data: sales_by_item_count_data,
    // options: stackedBarChartOptions    
    type: 'bar',
        data: sales_by_item_count_data,
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
                  // stacked: true,
                }],
                yAxes: [{
                      // stacked: true,
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
 