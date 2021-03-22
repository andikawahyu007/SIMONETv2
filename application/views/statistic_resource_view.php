<?php $this->load->view('Templates/headersidebar_view'); ?>
<style>
</style>
</div>
    </div>
    <div class="static-content-wrapper">
        <div class="static-content">
            <div class="page-content">
                <div class="container-fluid" style="margin-top: 10px">
                    <!-- <div data-widget-group="group1"> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> 
										<h2>Statistic Resource Usage</h2>
										<div class="col-md-3 pull-right">
											<button class="btn btn-default" id="daterangepicker2">
												<i class="ti ti-calendar"></i> 
												<span></span> <b class="caret"></b>
											</button>
										</div>
										<div class="btn-group pull-right" id="button-table" role="group" aria-label="Basic example">
										<a type="button" class="btn btn-success" data-aksi="refresh" style="margin:10px 0 0 0px"><i class="fa fa-refresh"></i></a>
											<a type="button" class="btn btn-success" data-aksi="print" style="margin:10px 0 0 0px"><i class="fa fa-print"></i></a>  
										</div>
                                    </div>
                                    <div class="panel-body" id="divPrint">
                                        <div class="row">
                                            <div style="margin: 10px">
                                                <h5>CPU</h5>
                                                <div class="mychartResource" id="chartCPU" style="height: 350px;" class="mt-sm mb-sm" data-interface="Resource"></div>
                                            </div>
                                        </div>
										<div class="row">
                                            <div style="margin: 10px">
                                                <h5>Memory</h5>
                                                <div class="mychartResource" id="chartMemory" style="height: 350px;" class="mt-sm mb-sm" data-interface="Resource"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->
                </div> 
                        <!-- </div>  -->
                    <!-- </div> -->
                <!-- <footer role="contentinfo">
                    <div class="clearfix">
                        <ul class="list-unstyled list-inline pull-left">
                            <li><h6 style="margin: 0;">&copy; 2015 Avenxo</h6></li>
                        </ul>
                        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                    </div>
                </footer> -->
<?php $this->load->view('Templates/footer_view'); ?>


<script type="text/javascript">
	$(document).ready(function(){
        $('.select-device').select2({width: '100%'});
        $(".select-device").each(function() {
            $(this).siblings(".select2-container").css('border', '1px solid #e3e3e3;');
        });
    })
	var charts = {};
	// var chart;
	var chartsQuality = {};
	// var chartQuality;
	var chartsResource = {};
	// var chartResource;

	$('body').on('click','a[data-aksi="print"]',function(){
        // $("#divPrint").show();  
		javascript:window.print();
		// printDiv()
    });

	function printDiv(){
		var divToPrint=document.getElementById('divPrint');

		var newWin=window.open('','Print-Window');

		newWin.document.open();

		newWin.document.write('<html><body onload="window.print()"><h2 style="text-align:center">Statistic</h2>'+divToPrint.innerHTML+'</body></html>');

		newWin.document.close();

		setTimeout(function(){newWin.close();},10);
	}

	Highcharts.setOptions({
		global: {
			timezoneOffset: -7 * 60
		}
	});

	$('#daterangepicker2').daterangepicker({
		timePicker: true,
		timePickerIncrement: 5,
		use24hours: true,
		ranges: {
			'Today': [moment().startOf('day'), moment()],
			'Yesterday': [moment().subtract('days', 1).startOf('day'), moment().subtract('days', 1).endOf('day')],
			'Last 7 Days': [moment().subtract('days', 6).startOf('day'), moment()],
			'Last 30 Days': [moment().subtract('days', 29).startOf('day'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			// 'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
		},
		opens: 'left',
		startDate: moment().subtract('hours', 6),
		endDate: moment()
	},

	function(start, end) {
			var date = {start: start.format('YYYY-MM-DD HH:mm:ss'),
				end: end.format('YYYY-MM-D HH:mm:ss'),
			};
			$('#daterangepicker2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			
			$('.mychartResource').each(function(){
				resourceChart($(this).attr('id'),date);
			})
			$('.highcharts-credits').hide();
			
	});

	function convertBit(value){
		var bits = value;                          
		var sizes = ['b/s', 'kb/s', 'Mb/s', 'Gb/s', 'Tb/s'];
		if (bits == 0) return '0 b/s';
		var i = parseInt(Math.floor(Math.log(bits) / Math.log(1024)));
		return parseFloat((bits / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];                    
	}

	function convertByte(value){
		var bytes = value;                          
		var sizes = ['Byte', 'KB', 'MB', 'GB', 'TB'];
		if (bytes == 0) return '0 Byte';
		var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
		return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];                    
	}

	function convertMs(value){
		return value+ ' ms';
	}

	function updateLegendLabelResource() {
		var chrt = !this.chart ? this : this.chart;
		chrt.update({
			legend: {
				labelFormatter: function() {
					var lastVal = this.yData[this.yData.length - 1],
					chart = this.chart,
					xAxis = this.xAxis,
					points = this.points,
					avg = 0,
					counter = 0,
					min, minPoint, max, maxPoint;

					points.forEach(function(point, inx) {
					if (point.isInside) {
						if (!min || min > point.y) {
						min = point.y;
						minPoint = point;
						}

						if (!max || max < point.y) {
						max = point.y;
						maxPoint = point;
						}

						counter++;
						avg += point.y;
					}
					});
					avg /= counter;

					return this.name + '<br>' +
					'<span">Min: ' + min + ' %</span><br/>' +
					'<span">Max: ' + max + ' %</span><br/>' +
					'<span">Average: ' + avg.toFixed(2); + ' %</span><br/>';
				}
			}
		});
	}

	function requestDataResource(id,date) 
	{
		$.ajax({
			url: '<?php echo site_url("Statistic/lineGraphResource");?>',     						
			type: "POST",
			data: {start: date.start,
			end: date.end} ,
			dataType: "JSON",
			success: function(data) {
				if(id == 'chartCPU'){
					chartsResource[id].max = data.stat['MaxCPU'];
					chartsResource[id].min = data.stat['MinCPU'];
					chartsResource[id].avg = data.stat['AvgCPU'];
					chartsResource[id].series[0].setName('CPU');
					chartsResource[id].series[0]['color']='#8E44AD';
					chartsResource[id].series[0].setData(data.cpu);
				}else{
					chartsResource[id].max = data.stat['MaxMemory'];
					chartsResource[id].min = data.stat['MinMemory'];
					chartsResource[id].avg = data.stat['AvgMemory'];
					chartsResource[id].series[0].setName('Memory');
					chartsResource[id].series[0]['color']='#E74C3C';
					chartsResource[id].series[0].setData(data.memory);
				}
				// console.log(chartsResource[id].max)
				updateLegendLabelResource();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
			  console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
			}       
		});
	}

	function resourceChart(id,date) { 
			var container = $('#'+id);
			chartsResource[id] = new Highcharts.Chart({
			chart: {
				renderTo: id,
		  		animation: Highcharts.svg,
				zoomType: 'x', 
				type: 'area',
				events: {
					load: function () {
						requestDataResource(id,date);	
					}				
				},
			},
			title: {
				text: null
			},
			exporting: {
				enabled: false
			},
			xAxis: {
				type: 'datetime',
				dateTimeLabelFormats: {
					day: '%e of %b'
				},
				// events: {
				// 	afterSetExtremes: updateLegendLabelResource
				// }  
			},
			yAxis: {
				labels: {
					format: '{value}%'
				},
				title: {
					enabled: false
				},
				events: {
					afterSetExtremes: updateLegendLabelResource
				}  
			},
			plotOptions: {
				area: {
					fillOpacity: 0.3,
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
			legend: {
				// labelFormatter: function() {					
				// 	if(typeof chartsResource[id] != 'undefined' && typeof chartsResource[id].max != 'undefined'){ 
				// 		var max = Math.round(chartsResource[id].max*100)/100;
				// 		var min = Math.round(chartsResource[id].min*100)/100;
				// 		var avg = Math.round(chartsResource[id].avg*100)/100;
				// 	}else{ 
				// 		var max = 0;  
				// 		var min = 0;
				// 		var avg = 0;
				// 	}
				// 	return this.name + '<br>Max: ' + max + ' %<br>Min: ' + min + ' %<br>Avg: ' + avg + ' %';
				// },
				enabled :true,
				
			},
			tooltip: {
				shared: true,
        		valueSuffix: ' %'                                                    
			},
			series: [{
				name: '',
				data: {},
				marker: {enabled: false},
				color: []
			}],
		})
	}

</script>

</body>
</html>
