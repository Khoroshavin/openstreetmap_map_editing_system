// creating variable
var chartProgress = document.getElementById("chartProgress");
// condition
if (chartProgress) {
  // initialization chart
  var myChartCircle = new Chart(chartProgress, {
    type: 'doughnut',
    data: {
      labels: ["Obsazeno", 'Zbyva'],
      datasets: [{
        backgroundColor: ["#28a745"],
        data: [68, 48]
      }]
    },
    // adding some plugins
    plugins: [{
      beforeDraw: function(chart) {
        var width = chart.chart.width,
            height = chart.chart.height,
            ctx = chart.chart.ctx;
    
        ctx.restore();
        var fontSize = (height / 150).toFixed(2);
        ctx.font = fontSize + "em sans-serif";
        ctx.fillStyle = "#9b9b9b";
        ctx.textBaseline = "middle";
    
        var text = "69"+ "MB",
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;
    
        ctx.fillText(text, textX, textY);
        ctx.save();
      }
  }],
  // adding some options
    options: {
      legend: {
        display: false,
      },
      responsive: true,
      maintainAspectRatio: false,
      cutoutPercentage: 85
    }

  });

  
}