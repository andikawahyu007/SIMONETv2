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
										<h2>Statistic Ping Quality</h2>
										<div class="col-md-3 pull-right">
											<button class="btn btn-default" id="daterangepicker2">
												<i class="ti ti-calendar"></i> 
												<span></span> <b class="caret"></b>
											</button>
											<button id="coba">coba</button>
										</div>
																				
										<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
											<i class="fa fa-calendar"></i>&nbsp;
											<span></span> <i class="fa fa-caret-down"></i>
										</div>
										
										
										<div class="btn-group pull-right" id="button-table" role="group" aria-label="Basic example">
										<a type="button" class="btn btn-success" data-aksi="refresh" style="margin:10px 0 0 0px"><i class="fa fa-refresh"></i></a>
											<a type="button" class="btn btn-success" data-aksi="print" style="margin:10px 0 0 0px"><i class="fa fa-print"></i></a>  
										</div>
                                    </div>
                                    <div class="panel-body" id="divPrint">
										<div class="row">
                                            <div style="margin: 10px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i> Indosat Ping To google.com</h5>
                                                <div class="mychartQuality" id="quality1" style="height: 350px;" class="mt-sm mb-sm" data-interface="Indosat"></div>
                                            </div>
                                        </div>
										<div class="row">
                                            <div style="margin: 10px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i> CBN Dedicated Ping To google.com</h5>
                                                <div class="mychartQuality" id="quality5" style="height: 350px;" class="mt-sm mb-sm" data-interface="CBNDedicated"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div style="margin: 10px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i> CBN 1 Ping To google.com</h5>
                                                <div class="mychartQuality" id="quality6" style="height: 350px;" class="mt-sm mb-sm" data-interface="CBN1"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div style="margin: 10px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i> CBN 2 Ping To google.com</h5>
                                                <div class="mychartQuality" id="quality7" style="height: 350px;" class="mt-sm mb-sm" data-interface="CBN2"></div>
                                            </div>
                                        </div>
										<div class="row">
                                            <div style="margin: 10px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i> MyRepublic Pro 100 Ping To google.com</h5>
                                                <div class="mychartQuality" id="quality2" style="height: 350px;" class="mt-sm mb-sm" data-interface="BPro100"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div style="margin: 10px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i> MyRepublic 300 Ping To google.com</h5>
                                                <div class="mychartQuality" id="quality3" style="height: 350px;" class="mt-sm mb-sm" data-interface="B300"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div style="margin: 10px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i> MyRepublic 100 Ping To google.com</h5>
                                                <div class="mychartQuality" id="quality4" style="height: 350px;" class="mt-sm mb-sm" data-interface="B100"></div>
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
		
		// setInterval(page_refresh, 10000 ); //NOTE: period is passed in milliseconds 1*60000
		/*setInterval(function() {
			window.location.reload();
		}, 2*60000); 
		*/
		
	   $('#reportrange').daterangepicker(
       {
          startDate: moment().subtract('days', 29),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2014',
          dateLimit: { days: 60 },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
             'Today': [moment(), moment()],
             'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
             'Last 7 Days': [moment().subtract('days', 6), moment()],
             'Last 30 Days': [moment().subtract('days', 29), moment()],
             'This Month': [moment().startOf('month'), moment().endOf('month')],
             'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
          },
          opens: 'left',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'DD/MM/YYYY',
          separator: ' to ',
          locale: {
              applyLabel: 'Submit',
              fromLabel: 'From',
              toLabel: 'To',
              customRangeLabel: 'Custom Range',
              daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
              monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
              firstDay: 1
          }
       },
       function(start, end) {
        console.log("menjalankan callback ...");
        $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
        startDate = start;
         endDate = end;    

       }
    );		
		
	
    $('#reportrange span').html(moment().subtract('days', 30).format('D MMMM YYYY') + ' - ' + moment().format('D MMMM YYYY'));

    $('#cmdcoba').click(function(){
        console.log(startDate.format('D MMMM YYYY') + ' - ' + endDate.format('D MMMM YYYY'));
    });		
		
    })
	var charts = {};
	// var chart;
	var chartsQuality = {};
	// var chartQuality;
	var chartsResource = {};
	// var chartResource;
	
	var startDate;
	var endDate;

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
			$('.mychartQuality').each(function(){
				qualityChart($(this).attr('id'),date);
				// resourceChart($(this).attr('id'),date);
			})

			$('.highcharts-credits').hide();
			
			startDate = start;
			endDate = end;
	});
	
	$('#coba').click(function(){
        console.log(startDate.format('D MMMM YYYY') + ' - ' + endDate.format('D MMMM YYYY'));
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
					return this.name + '<br> Rtt : Avg: ' + avgPing + ', Max: ' + maxPing + ', Min: ' + minPing + ' <br>'+
					'Jitter : Avg: ' + avgJitter + ', Max: ' + maxJitter + ', Min: ' + minJitter + ' <br>'+ 
					'Loss : Avg: ' + avgLoss + ' %, Max: ' + maxLoss + ' %, Min: ' + minLoss + ' %<br>'+
					'Loss Color : <span style="color: #2ecc71;">&#9724;</span> 0	<span style="color: #3498db;">&#9724;</span> 1/20	<span style="color: #3355FF;">&#9724;</span> 2/20	<span style="color: #8333FF;">&#9724;</span> 4/20	<span style="color: #8E44AD;">&#9724;</span> 10/20	<span style="color: #E74C3C;">&#9724;</span> 19/20 <br>' +
					'Probe : 20 Icmp Echo Ping (56 byte) every minutes';
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
</script>

</body>
</html>
