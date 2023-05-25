$(document).ready(function() {
  get_yearly_cases('case-summary');
});

$('#case-summary-graph-type').on('change', function() {
  get_yearly_cases('case-summary');
});

$('#recievals_status1').on('change', function() {
  if ($('#recievals_status1').val() == 'status') {
    if ($('#case-summary-graph-type').val() == 'area-chart') {
      $('#case-summary-graph-type').val('bar-chart');
    }
    $("#case-summary-graph-type-area-chart").attr("disabled",true);
  } else {
    $("#case-summary-graph-type-area-chart").attr("disabled",false);
  }
  get_yearly_cases('case-summary');
});

$('.status-wise-case-summary-chart-select-date-range').on('change', function() {
  status_wise_case_summary_details();
});

$('#case-chart-type-for-case-status-wise').on('change', function() {
  status_wise_case_summary_details();
});

$('#case-status-type-2').on('change', function() {
  get_yearly_cases('case-status-wise');
});

function common_filter_for_client() {
  get_yearly_cases('case-summary');
  status_wise_case_summary_details();
}

// get_yearly_cases('case-status-wise');

function all_year_get_data(data) {
  if ($('#case-summary-graph-type').val() == 'bar-chart') {
    $('#case-summary-chart-div').removeClass('chart-center');
    case_summary_vertical_bar_chart(data);
  } else if ($('#case-summary-graph-type').val() == 'line-graph') {
    $('#case-summary-chart-div').removeClass('chart-center');
    case_summary_vertical_line_graph(data);
  } else if ($('#case-summary-graph-type').val() == 'pie-chart') {
    $('#case-summary-chart-div').addClass('chart-center');
    case_summary_vertical_pie_chart(data);
  } else if ($('#case-summary-graph-type').val() == 'donut-chart') {
    $('#case-summary-chart-div').addClass('chart-center');
    case_summary_vertical_donut_chart(data);
  } else if($('#case-summary-graph-type').val() == 'area-chart') {
    if ($('#recievals_status1').val() != 'status') {
      case_status_wise_area_chart(data);
    }
  }
}

function case_summary_vertical_bar_chart(data = '') {
  $('#case-summary-chart-div').html('<div id="case-summary-bar-chart"></div>');
  if (data != '' && data.length > 0) {
    var year = [],
        total = [];
    
    for (var i = 0; i < data.length; i++) {
      year.push(data[i].monthname);
      total.push(data[i].total);
    }

    var options = {
      series: [{
        name: 'Cases',
        data: total
      }],
      chart: {
        type: 'bar',
        height: 300,
      },
      plotOptions: {
        bar: {
          borderRadius: 5,
          columnWidth: '20px',
          distributed: true,
        }
      },
      colors: ['#3aa0f3', '#66d838', '#f7bb43', '#69d2e7', '#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f'],
      dataLabels: {
        enabled: false
      },
      xaxis: {
        categories: year,
        title: {
          text: 'Months',
          position: 'bottom'
        },
        labels: {
          formatter: function (val) {
            return val
          }
        }
      },
      yaxis: {
        title: {
          text: 'Cases'
        }
      },
      fill: {
        opacity: 1
      },
      labels: year
    };
    $('#case-summary-chart-div').html('<div id="case-summary-bar-chart"></div>');
    var chart = new ApexCharts(document.querySelector("#case-summary-bar-chart"), options);
    chart.render();
  } else {
    $('#case-summary-bar-chart').html('<h4 class="text-center mt-5">No Data Found</h4>');
  }
}

function case_summary_vertical_line_graph(data = '') {
  $('#case-summary-chart-div').html('<div id="case-summary-line-graph"></div>');
  if (data != '' && data.length > 0) {
    var year = [],
        total = [];
    for (var i = 0; i < data.length; i++) {
      year.push(data[i].monthname);
      total.push(data[i].total);
    }

    var options = {
      series: [{
        name: "Cases",
        data: total
      }],
      chart: {
        height: 300,
        type: 'line',
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'straight'
      },
      markers: {
        size: 0,
      },
      grid: {
        row: {
          colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
          opacity: 0.5
        },
      },
      xaxis: {
        categories: year,
        title: {
          text: 'Cases',
          position: 'bottom'
        }
      },
      yaxis: {
        title: {
          text: 'Cases'
        }
      },
    };

    var chart = new ApexCharts(document.querySelector("#case-summary-line-graph"), options);
    chart.render();
  } else {
    $('#case-summary-line-graph').html('<h4 class="text-center mt-5">No Data Found</h4>');
  }
}

function case_summary_vertical_pie_chart(data = '') {
  $('#case-summary-chart-div').html('<div id="case-summary-pie-chart"></div>');
  if (data != '' && data.length > 0) {
    var year = [],
        total = [];
    for (var i = 0; i < data.length; i++) {
      year.push(data[i].monthname);
      total.push(parseInt(data[i].total));
    }

    var options = {
        series: total,
        chart: {
        width: 400,
        type: 'pie',
      },
      labels: year,
      // legend: {
      //   position: 'bottom'
      // },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var chart = new ApexCharts(document.querySelector("#case-summary-pie-chart"), options);
    chart.render();
  } else {
    $('#case-summary-pie-chart').html('<h4 class="text-center mt-5">No Data Found</h4>');
  }
}

function case_summary_vertical_donut_chart(data = '') {
  $('#case-summary-chart-div').html('<div id="case-summary-donut-chart"></div>');
  if (data != '' && data.length > 0) {
    var year = [],
        total = [];
    for (var i = 0; i < data.length; i++) {
      year.push(data[i].monthname);
      total.push(parseInt(data[i].total));
    }

    var options = {
        series: total,
        chart: {
        width: 400,
        type: 'donut',
      },
      labels: year,
      // legend: {
      //   position: 'bottom'
      // },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          }
        }
      }]
    };

    var chart = new ApexCharts(document.querySelector("#case-summary-donut-chart"), options);
    chart.render();
  } else {
    $('#case-summary-donut-chart').html('<h4 class="text-center mt-5">No Data Found</h4>');
  }
}

status_wise_case_summary_details();
function status_wise_case_summary_details() {
  var date_pick = $('.status-wise-case-summary-chart-select-date-range').val(),
    client = $('#client').val(),
    d = new Date(),
    today = ('0'+(d.getMonth()+1)).slice(-2) + '/' + ('0'+d.getDate()).slice(-2)  + '/' +  d.getFullYear(),
    comp = today+' - '+today,
    datetime = date_pick;

  if (comp == date_pick) {
    datetime = ''; 
  }

  $.ajax({
    type: "POST",
    url:  base_url+"factsuite-client-analytics/get-status-wise-case-summary-details", 
    dataType : 'JSON',
    data: {
      is_admin : 1,
      date_pick:datetime,
      client:client,
    },
    success: function(data) {
      if ($('#case-chart-type-for-case-status-wise').val() == 'column-chart') {
        status_wise_case_summary_details_column_chart(data);
      } else if ($('#case-chart-type-for-case-status-wise').val() == 'stacked-column-chart') {
        status_wise_case_summary_details_stacked_column_chart(data);
      } else if ($('#case-chart-type-for-case-status-wise').val() == 'spline-chart') {
        status_wise_case_summary_details_area_spline_chart(data);
      }
    }
  });
}

function status_wise_case_summary_details_column_chart(data = '') {
  $('#status-wise-case-summary-chart-div').html('<div id="status-wise-case-summary-column-chart"></div>');
  if (data != '' && data.month_name.length > 0) {
    // var options = {
    //     series: [{
    //     name: 'Initiated',
    //     data: data.initiated_cases
    //   }, {
    //     name: 'Completed',
    //     data: data.completed_cases
    //   }, {
    //     name: 'In-Progress',
    //     data: data.in_progress_cases
    //   }, {
    //     name: 'Insuff',
    //     data: data.insuff_cases
    //   }],
    //     chart: {
    //     type: 'bar',
    //     height: 350,
    //     stacked: false
    //   },
    //   zoom: {
    //     enabled: true
    //   },
    //   plotOptions: {
    //     bar: {
    //       horizontal: false,
    //       columnWidth: '55%',
    //       endingShape: 'rounded'
    //     },
    //   },
    //   dataLabels: {
    //     enabled: false
    //   },
    //   stroke: {
    //     show: true,
    //     width: 2,
    //     colors: ['transparent'],
    //     toolbar: {
    //       show: true
    //     },
    //   },
    //   xaxis: {
    //     categories: data.month_name,
    //   },
    //   responsive: [{
    //     breakpoint: 480,
    //     options: {
    //       legend: {
    //         position: 'bottom',
    //         offsetX: -10,
    //         offsetY: 0
    //       }
    //     }
    //   }],
    //   plotOptions: {
    //     bar: {
    //       horizontal: false,
    //       borderRadius: 0,
    //       dataLabels: {
    //         total: {
    //           enabled: true,
    //           style: {
    //             fontSize: '13px',
    //             fontWeight: 900
    //           }
    //         }
    //       }
    //     },
    //   },
    //   legend: {
    //     position: 'bottom',
    //     // offsetY: 40
    //   },
    //   yaxis: {
    //     title: {
    //       text: 'Cases'
    //     }
    //   },
    //   fill: {
    //     opacity: 1
    //   },
    //   tooltip: {
    //     y: {
    //       formatter: function (val) {
    //         return val + " Cases"
    //       }
    //     }
    //   },
    //   title: {
    //     text: 'Month Wise Case Status',
    //     align: 'center',
    //     style: {
    //       color: '#444'
    //     }
    //   }
    // };

    var options = {
        series: [{
          name: 'Initiated',
          data: data.initiated_cases
        }, {
          name: 'Completed',
          data: data.completed_cases
        }, {
          name: 'In-Progress',
          data: data.in_progress_cases
        }, {
          name: 'Insuff',
          data: data.insuff_cases
        }],
        chart: {
        type: 'bar',
        height: 350,
        stacked: false,
        toolbar: {
          show: true
        },
        zoom: {
          enabled: false
        }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          legend: {
            position: 'bottom',
            offsetX: -10,
            offsetY: 0
          }
        }
      }],
      plotOptions: {
        bar: {
          horizontal: false,
          borderRadius: 0,
          dataLabels: {
            total: {
              enabled: true,
              style: {
                fontSize: '13px',
                fontWeight: 900
              }
            }
          }
        },
      },
      xaxis: {
        // type: 'datetime',
        categories: data.month_name,
        title: {
          text: 'Months',
          position: 'bottom'
        }
      },
      legend: {
        position: 'bottom',
        // offsetY: 40
      },
      yaxis: {
        title: {
          text: 'Cases'
        }
      },
      fill: {
        opacity: 1
      },
      title: {
        text: 'Cases by Status',
        align: 'center',
        style: {
          color: '#444',
          fontSize: '17px',
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#status-wise-case-summary-column-chart"), options);
    chart.render();
  } else {
    $('#status-wise-case-summary-chart-div').html('<h4 class="text-center mt-5">No Data Found</h4>');
  }
}

function status_wise_case_summary_details_stacked_column_chart(data = '') {
  $('#status-wise-case-summary-chart-div').html('<div id="status-wise-case-summary-stacked-column-chart"></div>');
  if (data != '' && data.month_name.length > 0) {
    // var options = {
    //     series: [{
    //     name: 'Initiated',
    //     data: data.initiated_cases
    //   }, {
    //     name: 'Completed',
    //     data: data.completed_cases
    //   }, {
    //     name: 'In-Progress',
    //     data: data.in_progress_cases
    //   }, {
    //     name: 'Insuff',
    //     data: data.insuff_cases
    //   }],
    //     chart: {
    //     type: 'bar',
    //     height: 350,
    //     stacked: true
    //   },
    //   zoom: {
    //     enabled: true
    //   },
    //   plotOptions: {
    //     bar: {
    //       horizontal: false,
    //       columnWidth: '55%',
    //       endingShape: 'rounded'
    //     },
    //   },
    //   dataLabels: {
    //     enabled: false
    //   },
    //   stroke: {
    //     show: true,
    //     width: 2,
    //     colors: ['transparent'],
    //     toolbar: {
    //       show: true
    //     },
    //   },
    //   xaxis: {
    //     categories: data.month_name,
    //   },
    //   responsive: [{
    //     breakpoint: 480,
    //     options: {
    //       legend: {
    //         position: 'bottom',
    //         offsetX: -10,
    //         offsetY: 0
    //       }
    //     }
    //   }],
    //   plotOptions: {
    //     bar: {
    //       horizontal: false,
    //       borderRadius: 0,
    //       dataLabels: {
    //         total: {
    //           enabled: true,
    //           style: {
    //             fontSize: '13px',
    //             fontWeight: 900
    //           }
    //         }
    //       }
    //     },
    //   },
    //   legend: {
    //     position: 'bottom',
    //     // offsetY: 40
    //   },
    //   yaxis: {
    //     title: {
    //       text: 'Cases'
    //     }
    //   },
    //   fill: {
    //     opacity: 1
    //   },
    //   tooltip: {
    //     y: {
    //       formatter: function (val) {
    //         return val + " Cases"
    //       }
    //     }
    //   },
    //   title: {
    //     text: 'Month Wise Case Status',
    //     align: 'center',
    //     style: {
    //       color: '#444'
    //     }
    //   }
    // };

    var options = {
        series: [{
          name: 'Initiated',
          data: data.initiated_cases
        }, {
          name: 'Completed',
          data: data.completed_cases
        }, {
          name: 'In-Progress',
          data: data.in_progress_cases
        }, {
          name: 'Insuff',
          data: data.insuff_cases
        }],
        chart: {
        type: 'bar',
        height: 350,
        stacked: true,
        toolbar: {
          show: true
        },
        zoom: {
          enabled: false
        }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          legend: {
            position: 'bottom',
            offsetX: -10,
            offsetY: 0
          }
        }
      }],
      plotOptions: {
        bar: {
          horizontal: false,
          borderRadius: 0,
          columnWidth: '20px',
          dataLabels: {
            total: {
              enabled: true,
              style: {
                fontSize: '13px',
                fontWeight: 900
              }
            }
          }
        },
      },
      xaxis: {
        // type: 'datetime',
        categories: data.month_name,
        title: {
          text: 'Months',
          position: 'bottom'
        }
      },
      legend: {
        position: 'bottom',
        // offsetY: 40
      },
      yaxis: {
        title: {
          text: 'Cases'
        }
      },
      fill: {
        opacity: 1
      },
      title: {
        text: 'Cases by Status (Stacked)',
        align: 'center',
        style: {
          color: '#444',
          fontSize: '17px',
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#status-wise-case-summary-stacked-column-chart"), options);
    chart.render();
  } else {
    $('#status-wise-case-summary-chart-div').html('<h4 class="text-center mt-5">No Data Found</h4>');
  }
}

function status_wise_case_summary_details_area_spline_chart(data = '') {
  $('#status-wise-case-summary-chart-div').html('<div id="status-wise-case-summary-area-spline-chart"></div>');
  if (data != '' && data.month_name.length > 0) {
    var options = {
        series: [{
        name: 'Initiated',
        data: data.initiated_cases
      }, {
        name: 'Completed',
        data: data.completed_cases
      }, {
        name: 'In-Progress',
        data: data.in_progress_cases
      }, {
        name: 'Insuff',
        data: data.insuff_cases
      }],
        chart: {
        height: 350,
        type: 'area',
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth'
      },
      xaxis: {
        categories: data.month_name,
        title: {
          text: 'Months',
          position: 'bottom'
        }
      },
      yaxis: {
        title: {
          text: 'Cases'
        }
      },
      title: {
        text: 'Cases by Status',
        align: 'center',
        style: {
          color: '#444',
          fontSize: '17px',
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#status-wise-case-summary-area-spline-chart"), options);
    chart.render();
  } else {
    $('#status-wise-case-summary-chart-div').html('<h4 class="text-center mt-5">No Data Found</h4>');
  }
}

function case_status_wise_area_chart(data = '') {
  $('#case-summary-chart-div').html('<div id="case-status-wise-area-chart"></div>');
  if (data != '' && data.length > 0) {
    var status_type = '', color = '';
    if ($('#recievals_status1').val() == '0') {
      status_type = 'Initiated';
      color = '#3AA0F3';
    } else if ($('#recievals_status1').val() == '1') {
      status_type = 'In-Progress';
      color = '#F7DD43';
    } else if ($('#recievals_status1').val() == '2') {
      status_type = 'Completed';
      color = '#66D838';
    } else if ($('#recievals_status1').val() == '3') {
      status_type = 'Insuff';
      color = '#F44336';
    }
    var year = [],
        total = [];
    
    for (var i = 0; i < data.length; i++) {
      year.push(data[i].monthname);
      total.push(data[i].total);
    }
    var options = {
        series: [{
        name: "Cases",
        data: total
      }],
        chart: {
        type: 'area',
        height: 350,
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'straight'
      },
      colors:[color],
      fill: {
        colors: [color]
      },
      title: {
        text: 'Status Wise Cases Count - '+status_type,
        align: 'center'
      },
      labels: year,
      xaxis: {
        title: {
          text: 'Months',
          position: 'bottom'
        }
      },
      yaxis: {
        title: {
          text: 'Cases'
        }
      },
      legend: {
        horizontalAlign: 'left'
      }
    };

    var chart = new ApexCharts(document.querySelector("#case-status-wise-area-chart"), options);
    chart.render();
  } else {
    $('#case-summary-chart-div').html('<h4 class="text-center mt-5">No Data Found</h4>');
  }
}