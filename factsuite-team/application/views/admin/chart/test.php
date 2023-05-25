<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>


<div>
  <canvas id="chart1"></canvas>
</div>

<script> 
var ctx = document.getElementById("chart1");
 var data = {
        labels: ['John', 'Alex', 'Walter', 'James', 'Andrew', 'July'],
        datasets: [
            {
                label:  "Messages: ",
                data: [1, 2 , 10, 4, 50, 6],
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ]
            }]
    };

var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        beginAtZero: true,
        options: {
            responsive: true,
            legend: {
                display: false
            },
            title: {
                display: false,
                text: 'Chart.js bar Chart'
            },
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
</script>