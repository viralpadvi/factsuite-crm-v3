function open_case_list_status_wise(id) {
  window.location.href = report_case_base_url+id
}

$('#bg-green-reports, #bg-total-reports, #bg-red-reports, #bg-orange-reports').on('click', function() {
  open_case_list_status_wise($(this).attr("data-id"));
});

$('#bg-total-reports-btn, #bg-green-reports-btn, #bg-red-reports-btn, #bg-orange-reports-btn').on('click', function() {
  remove_all_dropdown();
  $('#bg-'+$(this).attr("data-id")+'-reports-dropdown-toggle').toggleClass("show");
  return false;
});

$('body').on('click', function() {
  remove_all_dropdown();
});

function remove_all_dropdown() {
  $('#bg-total-reports-dropdown-toggle, #bg-green-reports-dropdown-toggle, #bg-red-reports-dropdown-toggle, #bg-orange-reports-dropdown-toggle').removeClass("show");
}

function get_reports_data(day,duration,type) {
  $.ajax({
    type: "POST",
    url:  base_url+"cases/all_requested_report", 
    dataType : 'JSON',
    data: {
      is_admin : 1, 
      duration:duration,
      day:day 
    },
    success: function(data) {
      if (type=='total') {
        $("#home-page-total-report").html(data.total);
      } else if(type=='red') {
        $("#home-page-red-report").html(data.red);
      } else if(type=='orange') {
        $("#home-page-orange-report").html(data.orange);
      } else if(type=='green') {
        $("#home-page-green-report").html(data.green);
      }
      remove_all_dropdown();
    }
  });
}

// show_all_case_list_count()
// function show_all_case_list_count() {
// 	$('#inventory-total').html('10');
//   var pending_case_count_chart = '';
//   var total_cases_inventory_count = $('#total_cases_inventory_count').get(0).getContext('2d');

  
//   var sales_by_item_count_data  = {
//     labels: [
//       'Inprogress',      
//       'Completed',      
//       'Insuff',
//       // 'Total Case: '+sales_by_item.total,
//     ],
//     datasets: [{
//       data: ["1","2","2"],
//       backgroundColor : ['#2DCD7A','#FF9F43','#2DCD7A'],
//     }]
//   }

//   var sales_by_item_count_options = {
//     maintainAspectRatio : false,
//     responsive : true,
//   };

//   if(pending_case_count_chart) {
//     pending_case_count_chart.destroy();
//   }

//   // new Chart(donutChartCanvas, {
//   //   type: 'doughnut',
//   //   data: donutData,
//   //   options: donutOptions
//   // })
 
//   new Chart(total_cases_inventory_count, {
//     // doughnut
//     type: 'doughnut',
//     data: sales_by_item_count_data,
//     options: sales_by_item_count_options      
//   });
// } 

/*
var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Chrome',
          'IE',
          'FireFox',
          'Safari',
          'Opera',
          'Navigator',
      ],
      datasets: [get_all_client_wise_inventory_cases
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#2DCD7A', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    }) 

*/

// all_case_list_count();
// function all_case_list_count() {
//   var date_pick = $('#from-date-recievals').val();
//   var status = $('#recievals_status').val();
//   var client = $('#client').val();
//   var d = new Date();
//   var today = ('0'+(d.getMonth()+1)).slice(-2) + '/' + ('0'+d.getDate()).slice(-2)  + '/' +  d.getFullYear();
//   var comp = today+' - '+today;
  
//   var datetime = date_pick;
//   if (comp == date_pick) {
//     datetime = ''; 
//   }
//   $.ajax({
//     type: "POST",
//     url:  base_url+"client_Analytics/get_all_client_wise_inventory_cases", 
//     dataType : 'JSON',
//     data: {
//       is_admin : 1,
//       date_pick:datetime,
//       client:client,
//       status:status
//     },
//     success: function(total_active_cases_inventory_count) {
//         $('#total_active_cases_inventory_error_div').html('<span class="text-danger">No data Available</span>');
//       $('#total_active_cases_inventory_count').empty('');
//         $('#total_active_cases_inventory_error_div').html('');
//       if (total_active_cases_inventory_count.length == 0) {
//       } else {
//       }
//       show_all_case_list_count(total_active_cases_inventory_count.client_data);
//     }
//   });
// }
//   var pending_case_count_chart = '';
// function show_all_case_list_count(sales_by_item) {
//   $('#inventory-total').html(sales_by_item.total);
//   var sales_by_item_count_canvas = $('#total_active_cases_inventory_count').get(0).getContext('2d');

  
//   var sales_by_item_count_data  = {
//     labels: [
//       // 'New: '+sales_by_item.init,
//       'Not Initiated / New: '+sales_by_item.init,
//       'In Progress: '+sales_by_item.pending,
//       'Completed: '+sales_by_item.completed,
//       'Insuff: '+sales_by_item.insuff,
//       'Total Case: '+sales_by_item.total,
//     ],
//     datasets: [{
//       data: [sales_by_item.init,sales_by_item.init,sales_by_item.pending,sales_by_item.completed,sales_by_item.insuff],
//       backgroundColor : ['#f56954','#00a65a','#f39c12','#00c0ef','#3c8dbc','#d2d6de','#ED5F5F','#FF9F43','#2DCD7A','#ED5F5F'],
//     }
//     {
//       label:'Case Inventory',
//       data: [/*sales_by_item.init,*/sales_by_item.init,sales_by_item.pending,sales_by_item.completed,sales_by_item.insuff,sales_by_item.total],
//       backgroundColor :   ['#f56954','#00a65a','#f39c12','#00c0ef','#3c8dbc','#d2d6de','#FF9F43','#2DCD7A','#ED5F5F'],
//     }
//     ]
//   }

//   var sales_by_item_count_options = {
//     maintainAspectRatio : false,
//     responsive : true,
//   };

//   if(pending_case_count_chart) {
//     pending_case_count_chart.destroy();
//   }
 
//   pending_case_count_chart = new Chart(sales_by_item_count_canvas, {
//     // doughnut
//     /*type: 'bar',
//     data: sales_by_item_count_data,
//     options: sales_by_item_count_options  */    

//      type: 'bar',
//         data: sales_by_item_count_data,
//         beginAtZero: true,
//         options: {
//             responsive: true,
//            /* legend: {
//                 display: false
//             },*/
//              maintainAspectRatio     : false,
//     // datasetFill             : false,
//            /* title: {
//                 display: false,
//                 text: 'Chart.js bar Chart'
//             },*/
//             animation: {
//                 animateScale: true
//             },
//             scales: {
//                 yAxes: [{
//                     ticks: {
//                         beginAtZero: true,
//                         callback: function (value) { if (Number.isInteger(value)) { return value; } },
//                         stepSize: 1
//                     }
//                 }]
//             }
//         } 
//   });
// }

// get_monthly_pending_cases();
// function get_monthly_pending_cases() { 

//   var manager = $('#ageing_manager').val();
//   $.ajax({
//     type: "POST",
//     url:  base_url+"client_Analytics/get_monthly_pending_cases", 
//     dataType : 'JSON',
//     data: {
//       is_admin : 1,
//       manager : manager,
//     },
//     success: function(data) {
//       // alert(JSON.stringify(data))
//       $("#today_progress").html(data.client_data.in_progress_total); 
//       $("#closure_today").html(data.client_data.today_closure); 
//       $("#closure_month").html(data.client_data.current_month); 
//       $("#closure_month_total").html(data.client_data.month_closure); 
//       $("#carry_month").html(data.client_data.two_month); 
//       $("#two_month").html(data.client_data.two_month_total); 
//       $("#receival_month").html(data.client_data.one_month); 
//       $("#receival_month_total").html(data.client_data.one_month_total); 
//       $("#total_closure_cases").html(data.client_data.total);
//       $("#receival_data").html(data.client_data.in_progress_total);
//       $("#total-re-init").html(data.client_data.current_month_total);
//       $("#re-init").html(data.client_data.today);

 
//     /*  return array(
//         'in_progress_total'=>array_sum($in_progress_array),
//         'one_month_total'=>array_sum($one_month_array),
//         'one_month'=>isset($one_month_array_month[0])?$one_month_array_month[0]:'-',
//         'two_month_total'=>array_sum($two_month_array),
//         'two_month'=>isset($two_month_array_month[0])?$two_month_array_month[0]:'-',
//         'current_month_total'=>array_sum($current_month_array),
//         'current_month'=>isset($current_month_array_month[0])?$current_month_array_month[0]:'-',
//         'today'=>array_sum($today_array),
//         'today_closure'=>array_sum($today_closure_array),
//         'month_closure'=>array_sum($month_closure_array),
//         'till_closure'=>array_sum($till_closure_array)
//       ); */
//     }
//   });
// }

$('.status-wise-case-select-date-range').on('change',function() {
  get_yearly_cases();
});

all_count_case_list_count();
function all_count_case_list_count() { 
  var client = $('#client').val();
  
  $.ajax({
    type: "POST",
    url:  base_url+"client_Analytics/all_count_case_list_count", 
    dataType : 'JSON',
    data: {
      is_admin : 1, 
      client:client 
    }, 
    success: function(data) {
      $("#home-page-total-case").html(data.inventry.init);
      $("#home-page-pending-report").html(data.inventry.pending);
      $("#home-page-insuff-case").html(data.inventry.insuff);
      $("#home-page-completed-case").html(data.inventry.aproved); 
      $("#closure_month_total_").html(data.inventry.clarification); 

      $("#home-page-total-report").html(data.total);
      $("#home-page-green-report").html(data.report.green);
      $("#home-page-orange-report").html(data.report.orange);
      $("#home-page-blue-report").html(data.report.blue);
      $("#home-page-red-report").html(data.report.red); 
    }
  });
}

function get_yearly_cases(request_from = '') { 
  var date_pick = $('.status-wise-case-select-date-range').val(),
    status = $('#recievals_status1').val(),
    client = $('#client').val(),
    d = new Date(),
    today = ('0'+(d.getMonth()+1)).slice(-2) + '/' + ('0'+d.getDate()).slice(-2)  + '/' +  d.getFullYear(),
    comp = today+' - '+today,
    datetime = date_pick;

  if(request_from == 'case-status-wise') {
    status = $('#case-status-type-2').val();
  }

  if (comp == date_pick) {
    datetime = ''; 
  }

  $.ajax({
    type: "POST",
    url:  base_url+"client_Analytics/get_data_yearly", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      date_pick:datetime,
      client:client,
      status:status
    },
    success: function(data) {
      if (request_from == 'case-summary') {
        all_year_get_data(data);
      } else if(request_from == 'case-status-wise') {
        case_status_wise_area_chart(data);
      }
    }
  });
}