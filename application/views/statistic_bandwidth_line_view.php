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
										<h2>Bandwidth Usage Statistics</h2>
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
	var def_vis_on = ['iForte Max.','indosat Min.'];
	var rep_time = [];
	
	function drawchart(){
		$.post('<?php echo site_url("Statistic/getBandwidthInterface");?>',{time:rep_time},function(data){
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
					text: 'Max. and Min. Usage Statictic'
				},
				subtitle: {
					text: 'Processsing... please wait'
				},
				xAxis: [{
					crosshair: true
				}],
				yAxis: [{ // Primary yAxis
					labels: {
						format: '{value} Mb/s',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					title: {
						text: 'Bandwidth Usage',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					min : 0,
				}, { // Secondary yAxis
					title: {
						text: ' ',
						style: {
							color: Highcharts.getOptions().colors[0]
						}
					},
					labels: {
						format: ' ',
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
		$.post('<?php echo site_url("Statistic/getBandwidthData");?>',{intf:intf_ser[intf_i]['name'],time:rep_time},function(data){
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

</body>
</html>
