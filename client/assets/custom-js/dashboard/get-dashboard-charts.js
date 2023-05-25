var myChart ='';

function common_filter_for_client() {
  // all_case_list_count();
  get_yearly_cases();
  all_count_case_list_count();
}

function all_year_get_data_(years) {
  var ctx = document.getElementById('year_case_inventoty_chart').getContext('2d');
  var year = [];
  var total = [];

  if (years.length > 0) {
    for (var i = 0; i < monthname.length; i++) {
      year.push(years[i].monthname);
      total.push(years[i].total);
    }
  }

  if (myChart) {
    myChart.destroy();
  }
 myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: year,
        datasets: [{
            label: '# of Cases',
            data: total,
            backgroundColor: [
                'rgba(60,141,188,0.9)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8))',
                'rgba(60,141,188,0.8)'
            ],
            borderColor: [
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8)',
                'rgba(60,141,188,0.8))',
                'rgba(60,141,188,0.8)'
            ],
            borderWidth: 1
        }]
    },
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

var ticksStyle = {
  fontColor: '#00000',
  fontStyle: 'bold'
}
var mode = 'index'
var intersect = true

var visitorsChart ='';
function all_year_get_data(years) {
  var ctx = document.getElementById('year_case_inventoty_chart').getContext('2d');
  var year = [];
  var total = [];
  if (years.length > 0) {
    for (var i = 0; i < years.length; i++) {
      year.push(years[i].monthname);
      total.push(years[i].total);
    }
  }
  var sum = eval(total.join("+"));
  // var $visitorsChart = $('#year_case_inventoty_chart')
  // eslint-disable-next-line no-unused-vars
   visitorsChart = new Chart(ctx, {
    data: {
      labels: year,
      datasets: [{
        type: 'line',
        data: total,
        backgroundColor: 'transparent',
        borderColor: '#5A3C81',
        pointBorderColor: '#5A3C81',
        pointBackgroundColor: '#5A3C81',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'linear-gradient(180deg, #F9F1FF -4%, #FFFFFF 91.28%);',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: sum
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  }) 
}