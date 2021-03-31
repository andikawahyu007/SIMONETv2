<?php $this->load->view('Templates/headersidebar_view'); ?>
   </div>
	</div>
	<div class="static-content-wrapper">
		<div class="static-content">
			<div class="page-content">
				<div class="container-fluid">

<div class="row" style = "margin-top: 20px">
	<div class="col-sm-3">
		<div class="panel panel-profile" style="padding:0px">
			<div class="panel-body" style="padding:0px">
			<div class="name">Main Router</div>
			<div class="info">CCR - 1036</div>
			<div class="row" style="text-align : left; margin-top: 5px">  
				<div class="info">CPU</div>
				<div class="progress" style="height: 20px">
					<div id="cpu" class="progress-bar"></div>
				</div>
				<div class="info">Memory</div>
				<div class="progress" style="height: 20px">
					<div id="mem" class="progress-bar"></div>
				</div>
				<div class="col-md-6">
					<div class="info">CPU Temp : </div> 
					<p id="volt"></p>
				</div>
				<div class="col-md-6">
					<div class="info">Temperature : </div> 
					<p id="temp"></p>
				</div>
			</div>
			</div>
		</div><!-- panel -->
	</div><!-- col-sm-3 -->
	<div class="col-sm-9">
		<div class="tab-content">
			<div class="tab-pane active" id="tab-about">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="about-area">
							<!-- <h4>Network :</h4> -->
							<div class="col-sm-3">
								<div style="text-align:center">
									<img src="<?php echo base_url('assets/img/rb.png')?>" class="img-circle" style="width : 120px; ">
									<h4 style="color: black;">Routerboard</h4>
									<h3 id="totalRouter">.../...</h3>
									<h4>Units</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div style="text-align:center">
									<img src="<?php echo base_url('assets/img/unifi.png')?>" class="img-circle" style="width : 120px; ">
									<h4 style="color: black;">UniFi</h4>
									<h3 id="totalAP">.../...</h3>
									<h4>Units</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div style="text-align:center">
									<img src="<?php echo base_url('assets/img/clients.png')?>" class="img" style="width : 120px; ">
									<h4 style="color: black;">Users Connect</h4>
									<h3 id="totalConnect">.../...</h3>
									<h4>Devices</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div style="text-align:center">
									<img src="<?php echo base_url('assets/img/users.png')?>" class="img" style="width : 120px; ">
									<h4 style="color: black;">User Login</h4>
									<h3 id="totalLogin">.../...</h3>
									<h4>Users</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- .tab-content -->
	</div><!-- col-sm-8 -->
</div>


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
										</div>
										
										<div class="btn-group pull-right" id="button-table" role="group" aria-label="Basic example">
										<a type="button" class="btn btn-success" data-aksi="refresh" style="margin:10px 0 0 0px"><i class="fa fa-refresh"></i></a>
											<a type="button" class="btn btn-success" data-aksi="print" style="margin:10px 0 0 0px"><i class="fa fa-print"></i></a>  
										</div>
                                    </div>
                                    <div class="panel-body" id="divPrint">
										<div class="row">
                                            <div style="margin: 10px">
                                                <h5><i class="fa fa-circle" style="color: #5cb85c"></i></h5>
                                                <div class="mychartQuality" id="quality1" style="height: 600px;" class="mt-sm mb-sm" data-interface="Indosat"></div>
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
		
		//drawchart();
		$('#reportrange span').html(moment().subtract('days', 30).format('D MMMM YYYY') + ' - ' + moment().format('D MMMM YYYY'));
    })
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

	var mychart = null;
	var intf_ser = [];
	var def_vis_on = ['CBN2 Ping Time','CBN2 Loss','Indosat Ping Time'];
	var rep_time = [];
	
	function drawchart(){
		$.post('<?php echo site_url("Statistic/getPingInterface");?>',{time:rep_time},function(data){
			intf_ser = data;
			$.each(data,function(i,v){
				data[i].events = {
					legendItemClick : function(e){
						getchartdata(i, true);
					}
				}
			});
			mychart = Highcharts.chart('quality1', {
				chart: {
					zoomType: 'xy'
				},
				title: {
					text: 'Ping & Loss Quality Statictic'
				},
				subtitle: {
					text: 'Processsing... please wait'
				},
				xAxis: [{
					crosshair: true
				}],
				yAxis: [{ // Primary yAxis
					labels: {
						format: '{value} ms',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					title: {
						text: 'Ping Time',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					min : -2,
				}, { // Secondary yAxis
					title: {
						text: 'Loss',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					labels: {
						format: '{value}',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					min : -2,
					max : 100,
					opposite: true,
				}],
				xAxis: {
					type : 'datetime',
				},
				tooltip: {
					shared: true
				},
				legend: {
					layout: 'vertical',
					align: 'left',
					verticalAlign: 'middle',
					backgroundColor:
						Highcharts.defaultOptions.legend.backgroundColor || // theme
						'rgba(255,255,255,0.25)'
				},
				series: data,
				responsive: {
					rules: [{
						condition: {
							
						},
						chartOptions: {
							legend: {
								layout: 'horizontal',
								align: 'center',
								verticalAlign: 'bottom'
							}
						}
					}]
				}
			});
			
			
			$.each(intf_ser,function(j,intf){
				mychart.series[j].hide();
			})
			$.each(def_vis_on,function(i,v){
				$.each(intf_ser,function(j,intf){
					if(intf['name']==v){
						mychart.series[j].show();
					}
				})
			})
			getchartdata();
		},'json');
	}
	var clsTime;
	function getchartdata(intf_i = 0,ignoreVisible = false){
		if(!mychart.series[intf_i].visible && !ignoreVisible){
			if(typeof intf_ser[intf_i+1] != 'undefined') getchartdata(intf_i+1);
			else{
				clearTimeout(clsTime);
				clsTime = setTimeout(function(){ getchartdata(); }, 1000 * 60);
			}
			return false;
		}
		$.post('<?php echo site_url("Statistic/getPingData");?>',{intf:intf_ser[intf_i]['name'],time:rep_time},function(data){
			var isvis = mychart.series[intf_i].visible;
			mychart.series[intf_i].update({data:data.data});
			if(isvis){
				mychart.series[intf_i].show();
			}else {
				mychart.series[intf_i].hide();
			}
			mychart.subtitle.update({text:data.subtitle});
			if(typeof intf_ser[intf_i+1] != 'undefined') getchartdata(intf_i+1);
			else{
				clearTimeout(clsTime);
				clsTime = setTimeout(function(){ getchartdata(); }, 1000 * 60);
			}
		},'json');
	}
	
	var last3hour = [moment().subtract('hours', 3).millisecond(111111),moment().millisecond(111111)];
	var last6hour = [moment().subtract('hours', 6).millisecond(222222),moment().millisecond(222222)];
	$('#daterangepicker2').daterangepicker({
		timePicker: true,
		timePickerIncrement: 5,
		use24hours: true,
		ranges: {
			'Last 3 hours': last3hour,
			'Last 6 hours': last6hour,
			'Today': [moment().startOf('day'), moment()],
			'Yesterday': [moment().subtract('days', 1).startOf('day'), moment().subtract('days', 1).endOf('day')],
			'Last 7 Days': [moment().subtract('days', 6).startOf('day'), moment()],
			'Last 30 Days': [moment().subtract('days', 29).startOf('day'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			// 'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
		},
		opens: 'left',
		startDate: last6hour[0],
		endDate: last6hour[1]
	},

	function(start, end) {
		var date = {start: start.format('YYYY-MM-DD HH:mm:ss SSSSSS'),
			end: end.format('YYYY-MM-D HH:mm:ss SSSSSS'),
		};
		$('#daterangepicker2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		
		startDate = start;
		endDate = end;
		
		rep_time = date;
		drawchart();
	});
</script>


<!-- <div data-widget-group="group1">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-bluegray" data-widget='{"id" : "wiget9", "draggable": "false"}'>
				<div class="panel-heading">
					<h2>Indosat</h2>
					<div class="panel-ctrls button-icon-bg" 
						data-actions-container="" 
						data-action-collapse='{"target": ".panel-body"}'
						data-action-colorpicker=''
						data-action-refresh-demo='{"type": "circular"}'
						>
					</div>
				</div>
				<div class="panel-editbox" data-widget-controls=""></div>
				<div class="panel-body">
					<div class="mychart" id="chart1" style="height: 272px;" class="mt-sm mb-sm" data-interface="Indosat"></div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-bluegray" data-widget='{"draggable": "false"}'>
				<div class="panel-heading">
					<h2>iForte Dedicated</h2>
					<div class="panel-ctrls button-icon-bg" 
						data-actions-container="" 
						data-action-collapse='{"target": ".panel-body"}'
						data-action-colorpicker=''
						data-action-refresh-demo='{"type": "circular"}'
						>
					</div>
				</div>
				<div class="panel-body">
					<div class="mychart" id="chart2" style="height: 272px;" class="mt-sm mb-sm" data-interface="iForte"></div>
				</div>
			</div>
		</div>
	</div>
</div> -->

                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
                    </div>
                    <footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2015 Avenxo</h6></li>
        </ul>
        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
    </div>
</footer>
    </body>
    <?php $this->load->view('Templates/footer_view'); ?>
<script>
	var charts = {};
	var chart;

	Highcharts.setOptions({
		global: {
			timezoneOffset: -7 * 60
		}
	});

	
	$(document).ready(function() {
		$('.mychart').each(function(){
			interfaceChart($(this).attr('id'));
		})
		
		$('.highcharts-credits').hide();
		getResource();
		getTotal();
	});

	function convertBit(value){
		var bits = value;                          
		var sizes = ['b/s', 'kb/s', 'Mb/s', 'Gb/s', 'Tb/s'];
		if (bits == 0) return '0 b/s';
		var i = parseInt(Math.floor(Math.log(bits) / Math.log(1024)));
		return parseFloat((bits / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];                    
	}
	
	function updateLegendLabelTraffic() {
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
					'<span">Min: ' + convertBit(min) + ' </span><br/>' +
					'<span">Max: ' + convertBit(max) + ' </span><br/>' +
					'<span">Average: ' + convertBit(avg.toFixed(2)); + ' </span><br/>';
				}
			}
		});
	}

	function requestData(iface, id) 
	{
		$.ajax({
			url: '<?php echo site_url("Dashboard/interface1");?>',     						
			type: "POST",
			dataType: "JSON",
			data: {iface:iface} ,
			success: function(data) {	
				charts[id].hideLoading();
				// charts[id].xAxis[0].setCategories(data.point);
				charts[id].series[0].setData(data.tx);
				charts[id].series[1].setData(data.rx);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
			  console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
			}       
		});
		setTimeout(function(){ requestData(iface,id); }, 60000);
		
	}

	function interfaceChart(id) { 
			var container = $('#'+id);
			if(!container.length) return false;
			var interface = container.data('interface');
			
			charts[id] = new Highcharts.Chart({
			chart: {
				renderTo: id,
				animation: Highcharts.svg,
				zoomType: 'x',  
				type: 'areaspline',
				events: {
					load: function () {
						requestData(interface, id);
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
			},
			yAxis: {
				minPadding: 0.2,
				maxPadding: 0.2,
				title: {text: null},
				labels: {
					formatter: function () {      
						var bytes = this.value;                          
						var sizes = ['b/s', 'kb/s', 'Mb/s', 'Gb/s', 'Tb/s'];
						if (bytes == 0) return '0 bps';
						var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
						return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];                    
					},
				},    
				events: {
					afterSetExtremes: updateLegendLabelTraffic
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
			tooltip: {
				formatter: function() {
					// console.log(this)
					var s = [];

					$.each(this.points, function(i, point) {
						var bytes = point.y;                          
						var sizes = ['b/s', 'kb/s', 'Mb/s', 'Gb/s', 'Tb/s'];
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
					name: 'Upload',
					data: [],
					color: '#3498db',
					marker: {enabled: false}
				}, {
					name: 'Download',
					data: [],
					color: '#2ecc71',
					marker: {enabled: false}
			}],
		})
	}

	function getResource(){
        var url = "<?php echo site_url('Devices/getResource')?>";

        $.ajax({
            url : url,
            type: "POST",
            data: {ip : '10.10.10.1'},
            dataType: "JSON",
            success: function(data)
            {
                if(data.status) 
                {
                    $('#cpu').css("width", data.data['cpu-load'] + "%").text(data.data['cpu-load'] + " %");
                    $('#mem').css("width", Math.round(((data.data['total-memory'] - data.data['free-memory'])/data.data['total-memory'])*100) + "%").text(Math.round(((data.data['total-memory'] - data.data['free-memory'])/data.data['total-memory'])*100) + " %");
                    $('#volt').text(data.data['voltage']);
                    $('#temp').text(data.data['temperature']);
                }
                $.skylo('end');
                $('#btnSave').text('save'); 
                $('#btnSave').attr('disabled',false); 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log("Error getResource");
            }
		});
		
        setTimeout(function(){ getResource(); }, 5000);
    }
	function getTotal(){
        var url = "<?php echo site_url('Dashboard/total')?>";

        $.ajax({
            url : url,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                if(data.status) 
                {
					if(data.data['router']< data.data['allrouter']){
						$('#totalRouter').css("color", "red").text(data.data['router']+'/'+data.data['allrouter']);
					}else{
						$('#totalRouter').css("color", "#0386d2").text(data.data['allrouter']);	
					}
                    
					if(data.data['ap']< data.data['allap']){
						$('#totalAP').css("color", "red").text(data.data['ap']+'/'+data.data['allap']);
					}else{
						$('#totalAP').css("color", "#0386d2").text(data.data['allap']);	
					}
                    $('#totalConnect').text(data.data['connect']);
                    $('#totalLogin').text(data.data['login']);
                }
                $.skylo('end');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log("Error getResource");
            }
        });

        setTimeout(function(){ getTotal(); }, 5000);
    }
	</script>
</html>
