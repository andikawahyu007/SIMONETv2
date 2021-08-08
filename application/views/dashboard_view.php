<?php $this->load->view('Templates/headersidebar_view'); ?>
<style>
</style>
<!-- <meta http-equiv=refresh content=5;url=dashboard> -->
</div>
    </div>
    <div class="static-content-wrapper">
        <div class="static-content">
            <div class="page-content">
                <div class="container-fluid" style="margin-top: 20px">
                    <!-- <div data-widget-group="group1"> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> 
										<h2>Statistic Ping Quality</h2>
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
                                            <div style="margin: -15px 20px 0px 20px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i>  Indosat Ping To google.com</h5>
                                                <div class="mychartQuality" id="quality1" style="height: 250px;" class="mt-sm mb-sm" data-interface="Indosat"></div>
                                            </div>
                                        </div>
										<div class="row">
                                            <div style="margin: -15px 20px 0px 20px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i>  iForte Dedicated Ping To google.com</h5>
                                                <div class="mychartQuality" id="quality2" style="height: 250px;" class="mt-sm mb-sm" data-interface="iForte"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div style="margin: -15px 20px 0px 20px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i>  MNC 1 Ping To google.com</h5>
                                                <div class="mychartQuality" id="quality3" style="height: 250px;" class="mt-sm mb-sm" data-interface="prov3"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div style="margin: -15px 20px 0px 20px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i>  MNC 2 Ping To google.com</h5>
                                                <div class="mychartQuality" id="quality4" style="height: 250px;" class="mt-sm mb-sm" data-interface="prov4"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div style="margin: -15px 20px 0px 20px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i>  MNC 3 Ping To google.com</h5>
                                                <div class="mychartQuality" id="quality5" style="height: 250px;" class="mt-sm mb-sm" data-interface="prov5"></div>
                                            </div>
                                        </div>
                                    </div>                               
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> 
										<h2>Statistic Bandwidth Usage</h2>
										<div class="col-md-3 pull-right">
											<button class="btn btn-default" id="daterangepicker2">
												<i class="ti ti-calendar"></i> 
												<span></span> <b class="caret"></b>
											</button>
										</div>	
										<div class="btn-group pull-right" id="button-table" role="group" aria-label="Basic example">
										<a type="button" class="btn btn-success" data-aksi="refresh" style="margin:10px 0 0 0px"><i class="fa fa-refresh"></i></a>
											<a type="button" class="btn btn-success" onclick='printDiv2();' style="margin:10px 0 0 0px"><i class="fa fa-print"></i></a>  
										</div>
                                    </div>
                                    <div class="panel-body" id="divPrint2">

                                    <div class="row">
                                        <div style="margin: -15px 20px 0px 20px">
                                            <h5><i class="fa fa-circle" style="color: #5cb85c"></i>  Indosat</h5>
                                            <div class="mychartInterface" id="chart1" style="height: 250px;" class="mt-sm mb-sm" data-interface="Indosat"></div>
                                        </div>
                                    </div>
									<div class="row">
                                        <div style="margin: -15px 20px 0px 20px">
                                            <h5><i class="fa fa-circle" style="color: #5cb85c"></i>  iForte</h5>
                                            <div class="mychartInterface" id="chart2" style="height: 250px;" class="mt-sm mb-sm" data-interface="iForte"></div>
                                        </div>
                                    </div>
									<div class="row">
                                        <div style="margin: -15px 20px 0px 20px">
                                            <h5><i class="fa fa-circle" style="color: #5cb85c"></i>  MNC 1</h5>
                                            <div class="mychartInterface" id="chart3" style="height: 250px;" class="mt-sm mb-sm" data-interface="prov3"></div>
                                        </div>
                                    </div>
									<div class="row">
                                        <div style="margin: -15px 20px 0px 20px">
                                            <h5><i class="fa fa-circle" style="color: #5cb85c"></i>  MNC 2</h5>
                                            <div class="mychartInterface" id="chart4" style="height: 250px;" class="mt-sm mb-sm" data-interface="prov4"></div>
                                        </div>
                                    </div>
									<div class="row">
                                        <div style="margin: -15px 20px 0px 20px">
                                            <h5><i class="fa fa-circle" style="color: #5cb85c"></i>  MNC 3</h5>
                                            <div class="mychartInterface" id="chart5" style="height: 250px;" class="mt-sm mb-sm" data-interface="prov5"></div>
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
        $("#divPrint").show();  
		javascript:window.print();
		printDiv()
    });

	function printDiv(){
		var divToPrint=document.getElementById('divPrint');

		var newWin=window.open('','Print-Window');

		newWin.document.open();

		newWin.document.write('<html><body onload="window.print()"><h2 style="text-align:center">Statistic Ping Quality</h2>'+divToPrint.innerHTML+'</body></html>');

		newWin.document.close();

		setTimeout(function(){newWin.close();},10);
	}

	function printDiv2(){
		var divToPrint=document.getElementById('divPrint2');

		var newWin=window.open('','Print-Window');

		newWin.document.open();

		newWin.document.write('	<html><body onload="window.print()"><h2 style="text-align:center">Statistic Bandwidth Usage</h2>'+divToPrint.innerHTML+'</body></html>');

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
			$('.mychartQuality').each(function(){
				qualityChart($(this).attr('id'),date);
				// resourceChart($(this).attr('id'),date);
			})

			$('.mychartInterface').each(function(){
				interfaceChart($(this).attr('id'),date);
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

	function requestDataQuality(iface, id, date) 
	{
		var zones = [];
		$.ajax({
			url: '<?php echo site_url("Statistic/linePingQuality");?>',     						
			type: "POST",
			dataType: "JSON",
			data: {iface:iface,
			start: date.start,
			end: date.end} ,
			success: function(data) {
				chartsQuality[id].maxPing = data.stat['MaxPing'];
				chartsQuality[id].minPing = data.stat['MinPing'];
				chartsQuality[id].avgPing = data.stat['AvgPing'];
				chartsQuality[id].maxJitter = data.stat['MaxJitter'];
				chartsQuality[id].minJitter = data.stat['MinJitter'];
				chartsQuality[id].avgJitter = data.stat['AvgJitter'];
				chartsQuality[id].maxLoss = data.stat['MaxLoss'];
				chartsQuality[id].minLoss = data.stat['MinLoss'];
				chartsQuality[id].avgLoss = data.stat['AvgLoss'];
				chartsQuality[id].series[0].setName(iface);
				chartsQuality[id].series[0].setData(data.ping);
				var chrt = !chartsQuality[id].series[0].xData ? this : chartsQuality[id].series[0].xData; 
				for(var i = 0; i < chrt.length; i++){
					if(chrt[i] == data.quality[i][0]){
						if(data.quality[i][1] == 0){
							zones.push({
								value: chrt[i] + 0.1 ,
								color: "#2ecc71"
							});
						}else if(data.quality[i][1] < 5){
							zones.push({
								value: chrt[i] + 0.1 ,
								color: "#3498db"
							});
						}else if(data.quality[i][1] < 10){
							zones.push({
								value: chrt[i] + 0.1 ,
								color: "#3355FF"
							});
						}else if(data.quality[i][1] < 20){
							zones.push({
								value: chrt[i] + 0.1 ,
								color: "#8333FF"
							});
						}else if(data.quality[i][1] < 80){
							console.log();
							zones.push({
								value: chrt[i] + 0.1 ,
								color: "#8E44AD"
							});
						}else if(data.quality[i][1] < 100){
							console.log();
							zones.push({
								value: chrt[i] + 0.1 ,
								color: "#E74C3C"
							});
						} 
					}
				}
				chartsQuality[id].series[0].update({
					zones: zones
				});
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
			  console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
			}       
		});
	}

	function requestDataInterface(iface, id, date) 
	{
		$.ajax({
			url: '<?php echo site_url("Statistic/lineGraphInterface");?>',     						
			type: "POST",
			dataType: "JSON",
			data: {iface:iface,
			start: date.start,
			end: date.end} ,
			success: function(data) {
				charts[id].maxTx = data.stat['MaxTx'];
				charts[id].minTx = data.stat['MinTx'];
				charts[id].avgTx = data.stat['AvgTx'];
				charts[id].maxRx = data.stat['MaxRx'];
				charts[id].minRx = data.stat['MinRx'];
				charts[id].avgRx = data.stat['AvgRx'];
				// charts[id].hideLoading();
				charts[id].series[0].setData(data.tx);
				charts[id].series[1].setData(data.rx);
				// console.log(charts[id].series[1].points);
				// updateLegendLabelTraffic();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
			  console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
			}       
		});
	}


	function qualityChart(id,date) { 
			var container = $('#'+id);
			if(!container.length) return false;
			var interface = container.data('interface');
			chartsQuality[id] = new Highcharts.Chart({
			chart: {
				renderTo: id,
		  		animation: Highcharts.svg,
				type: 'column',
				zoomType: 'x',
				events: {
					load: function () {
						requestDataQuality(interface, id, date);
						// updateZoneQuality(interface, id, date);
						// var chrt = this.series[0].yData; 
					},	
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
			},
			yAxis: {
				labels: {
					format: '{value} ms'
				},
				title: {
					enabled: false
				},
				events: {
					// afterSetExtremes: updateLegendLabelQuality
					}  
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
			legend: {
				useHTML: true,
				labelFormatter: function() {
					if(typeof chartsQuality[id] != 'undefined' && typeof chartsQuality[id].maxJitter != 'undefined'){ 
						var maxPing = convertMs(chartsQuality[id].maxPing);
						var minPing = convertMs(chartsQuality[id].minPing);
						var avgPing = convertMs(Math.round(chartsQuality[id].avgPing,2));
						var maxJitter = chartsQuality[id].maxJitter;
						var minJitter = chartsQuality[id].minJitter;
						var avgJitter = Math.round(chartsQuality[id].avgJitter,2);
						var maxLoss = chartsQuality[id].maxLoss;
						var minLoss = chartsQuality[id].minLoss; 
						var avgLoss = Math.round(chartsQuality[id].avgLoss,2); 
					}else{ 
						var maxPing = 0;
						var minPing = 0;
						var avgPing = 0;
						var maxJitter = 0;
						var minJitter = 0;
						var avgJitter = 0;
						var maxLoss = 0;
						var minLoss = 0; 
						var avgLoss = 0; 
					}
					
					// return this.name + '<br>Max: ' + maxTx + '<br>Min:  <br>Avg: ' + avgTx;
					return this.name + ' Loss Color : <span style="color: #2ecc71;">&#9724;</span> 0	<span style="color: #3498db;">&#9724;</span> 1/20	<span style="color: #3355FF;">&#9724;</span> 2/20	<span style="color: #8333FF;">&#9724;</span> 4/20	<span style="color: #8E44AD;">&#9724;</span> 10/20	<span style="color: #E74C3C;">&#9724;</span> 19/20 <br>';
					},
			},
			tooltip: {
				shared: true
			},
			credits: {
				enabled: true
			},
			credits: {
				enabled: false
			},
			series: [{
				name: '',
				data: {x: [], y: [], option: []},
				zoneAxis: "x"
			}],
		})
	}

	function interfaceChart(id,date) { 
			var container = $('#'+id);
			if(!container.length) return false;
			var interface = container.data('interface');
			// console.log(container);
			// var title = container.data('title');
			
			
			charts[id] = new Highcharts.Chart({
			chart: {
				renderTo: id,
		  		animation: Highcharts.svg,
				type: 'areaspline',
				zoomType: 'x',
				events: {
					load: function () {
						requestDataInterface(interface, id, date);
					},	
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
				
			},
			yAxis: {
				minPadding: 0.2,
				maxPadding: 0.2,
				title: {text: null},
				labels: {
					formatter: function () {      
						var bytes = this.value;                          
						var sizes = ['b/s', 'kb/s', 'Mb/s', 'Gb/s', 'Tb/s'];
						if (bytes == 0) return '0 b/s';
						var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
						return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];                    
					},
				},
				// events: {
				// 	afterSetExtremes: updateLegendLabelTraffic
				// 	}    
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
			legend: {
				// labelFormatter: function() {
				// 	if(typeof charts[id] != 'undefined' && typeof charts[id].maxTx != 'undefined'){ 
				// 		var maxTx = convertBit(charts[id].maxTx);
				// 		var minTx = convertBit(charts[id].minTx);
				// 		var avgTx = convertBit(Math.round(charts[id].avgTx,2));
				// 		var maxRx = convertBit(charts[id].maxRx);
				// 		var minRx = convertBit(charts[id].minRx); 
				// 		var avgRx = convertBit(Math.round(charts[id].avgRx,2)); 
				// 	}else{ 
				// 		var maxTx = 0;  
				// 		var maxTx = 0;
				// 		var minTx = 0;
				// 		var avgTx = 0;
				// 		var maxRx = 0;
				// 		var minRx = 0; 
				// 		var avgRx = 0; 
				// 	}
					
				// 	// return this.name + '<br>Max: ' + maxTx + '<br>Min:  <br>Avg: ' + avgTx;
				// 	return (this.name == 'Upload') ? this.name + '<br>Max: ' + maxTx + '<br>Min: ' + minTx + ' <br>Avg: ' + avgTx : this.name + '<br>Max: ' + maxRx + '<br>Min: ' + minRx + ' <br>Avg: ' + avgRx;
				// 	},
				enabled :true,
				
			},
			tooltip: {
				formatter: function() {
					var s = [];

					$.each(this.points, function(i, point) {
						var bytes = point.y;                          
						var sizes = ['b/s', 'Kb/s', 'Mb/s', 'Gb/s', 'Tb/s'];
						if (bytes == 0) {s.push('<span style="color:#D31B22;font-weight:bold;">'+ point.series.name +' : '+
							'0 b/s'+'<span>');}
						else{
							var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
							s.push(point.series.name +' : '+'<span style="color:'+point.series.color+';font-weight:bold;">'+ 
								parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i] +'<span>');
						}
					});

					return Highcharts.dateFormat('%A, %b %d, %H:%M', this.x)+ '<br>' +s.join(' <br> ');
				},
				shared: true
			},
			credits: {
				enabled: true
			},
			series: [{
				color: '#3498db',
				name: 'Upload',
				data: [],
				marker: {enabled: false}
			}, {
				color: '#2ecc71',
				name: 'Download',
				data: [],
				marker: {enabled: false}
			}],
		})
	}

// $(document).ready(function(){
// 	var refreshId = setInterval(function(){
// 		$("#daterangepicker2").load("dashboard_view.php");
// 	}, 60000);
// 	$.ajaxSetup({cache: false});
// });

</script>

</body>
</html>
