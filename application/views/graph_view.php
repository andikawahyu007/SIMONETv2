<style>
.highcharts-figure, .highcharts-data-table table {
    min-width: 360px; 
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}



</style>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        Highcharts has extensive support for time series, and will adapt
        intelligently to the input data. Click and drag in the chart to zoom in
        and inspect the data.
    </p>
</figure>

<script>
Highcharts.getJSON(
    '<? echo site_url('statistic/lineGraphResource')?>',
        function (data) {  
            console.log(data);
        Highcharts.chart('container', {
        chart: {
            type: 'area',
            zoomType: 'x'
        },
        title: {
            text: 'Bandwidth'
        },
        // legend: {
        //     layout: 'vertical',
        //     align: 'left',
        //     verticalAlign: 'top',
        //     x: 100,
        //     y: 70,
        //     floating: true,
        //     // borderWidth: 1,
        //     backgroundColor:
        //         Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
        // },
        xAxis: {
            type: 'datetime',
            categories : data.point,
            tickmarkPlacement: 'on',
            title: {
                enabled: false
            }

            // tickInterval: 60
            
            // labels: {
                // data : Date.parse(data.point),
            // format: '{value:%Y-%m-%d}',
            // rotation: 45,
            // align: 'left'
            // }
        },
        yAxis: {
            // title: {
            //     text: 'Y-Axis'
            // }
            // minPadding: 0.2,
			// maxPadding: 0.2,
			// title: {text: null},
            format: '{value}%'
			// labels: {
			//   formatter: function () {      
			// 	var bytes = this.value;                          
			// 	var sizes = ['b/s', 'kb/s', 'Mb/s', 'Gb/s', 'Tb/s'];
			// 	if (bytes == 0) return '0 bps';
			// 	var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
			// 	return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];                    
			//   },
			// },    
        },
        plotOptions: {
            area: {
                fillOpacity: 0.5,
                marker: {
                    enabled: false,
                    symbol: 'circle',
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                }
            }
        },
        tooltip: {
        pointFormat: '{series.name} had stockpiled <b>{point.y:,.0f}</b><br/>warheads in {point.x}'
        },
        credits: {
            enabled: true
        },
        series: [{
            name: 'CPU',
            data: data.cpu
        }, {
            name: 'Memory',
            data: data.memory
        }]
    });
})
</script>
