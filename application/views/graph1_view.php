<?php $this->load->view('templates/headersidebar_view'); ?>
    </div>
</div>
<div class="static-content-wrapper">
    <div class="static-content">
        <div class="page-content">
            <ol class="breadcrumb">
				<li class=""><a href="index.html">Home</a></li>
				<li class="active"><a href="index.html">Dashboard</a></li>
            </ol>
			<div class="container-fluid">
        		<div class="row">
					<div class="col-md-6">
						<div class="panel panel-info" data-widget='{"id" : "wiget9", "draggable": "false"}'>
							<div class="panel-heading">
								<h2>E10-Bisnis 100</h2>
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
								<div class="mychart" id="chart1" data-title="" style="height: 272px;" data-interface="E3-WAN-MyRE2-WAN-MyRepBPro100"></div>

							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="panel panel-info" data-widget='{"id" : "wiget9", "draggable": "false"}'>
							<div class="panel-heading">
								<h2>E11-Bisnis Pro 100</h2>
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
								<div class="mychart" id="chart2" data-title="" style="height: 272px;" data-interface="E11-BPro100"></div>

							</div>
						</div>
					</div>

				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-info" data-widget='{"id" : "wiget9", "draggable": "false"}'>
							<div class="panel-heading">
								<h2>E12-Bisnis 300</h2>
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
								<div class="mychart" id="chart3" data-title="" style="height: 272px;" data-interface="E3-WAN-MyRepB300"></div>

							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="panel panel-info" data-widget='{"id" : "wiget9", "draggable": "false"}'>
							<div class="panel-heading">
								<h2>E13-Radio Indosat</h2>
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
								<!-- <div id="socialstats" style="height: 272px;" class="mt-sm mb-sm"></div> -->
								<div class="mychart" id="chart4" data-title="" style="height: 274px;" data-interface="E1-WAN-Indosat"></div>

							</div>
						</div>
					</div>
				</div>
    		</div>
		</div> <!-- .container-fluid -->
	</div> <!-- #page-content -->
    <!-- </div> -->
<!-- </div> -->
		<footer role="contentinfo">
		    <div class="clearfix">
		        <ul class="list-unstyled list-inline pull-left">
		            <li><h6 style="margin: 0;">&copy; 2015 Avenxo</h6></li>
		        </ul>
		        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
		    </div>
		</footer>

       </div>
    </div>

    
    <!-- Load site level scripts -->
    <?php $this->load->view('templates/footer_view'); ?>
    <!-- Load page level scripts-->
    
<!-- Charts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
 <!-- <script type="text/javascript" src="<?php echo base_url('') ?>assets/demo/demo-index.js"></script> 									<!-- Initialize scripts for this page -->

<script>
	var _site_url = '<?php echo site_url()?>';
	var tx = {'E3-WAN-MyRepB100': [] , 'E2-WAN-MyRepBPro100' : [], 'E4-WAN-MyRepB300': [] , 'E1-WAN-Indosat' : []},
	rx = {'E3-WAN-MyRepB100': [] , 'E2-WAN-MyRepBPro100' : [], 'E4-WAN-MyRepB300': [] , 'E1-WAN-Indosat' : []},
	point = {'E3-WAN-MyRepB100': [] , 'E2-WAN-MyRepBPro100' : [], 'E4-WAN-MyRepB300': [] , 'E1-WAN-Indosat' : []};

    tmpChart();
	function tmpChart(){
			$.get(_site_url+'/bandwidth/lineGraph/',function(respon) {
				// if (tx[iface].length == 10) {
				// 	tx[iface].shift();
				// 	rx[iface].shift();
				// 	point[iface].shift();
				// }
				// tx[iface].push(parseInt(respon.tx));	
				// rx[iface].push(parseInt(respon.rx));
				// point[iface].push(respon.point);	
                console.log(respon);
	        },'json')
        
	}
	// function loadLog(){
	// 	$.get(_site_url+'/dashboard/getLog',function(respon){
	// 		$('div[data-konten="log_router"').html(respon.log);
	// 	},'json')
	// 	setTimeout(function(){ loadLog(); }, 100000);
	// }

	// function loadResource(){
	// 	$.get(_site_url+'/dashboard/getAllResource',function(respon){
	// 		$('div[data-konten="memory_load"]').html(respon.memory);
	// 		$('div[data-konten="cpu_load"]').html(respon.cpu);
	// 	},'json')
	// 	setTimeout(function(){ loadResource(); }, 2000);
	// }
    $('.mychart').each(function(){
			graphArea($(this).attr('id'));
		});
	var charts = {};
	var chart;
	function requestData(iface,id) 
	{

		// $.ajax({
		// 	url: _site_url+'/dashboard/getTrafficInterface/',     						
		// 	type: "POST",
		// 	dataType: "JSON",
		// 	data: {iface:iface} ,
		// 	success: function(data) {	
		// 		var x = data.point[0];
		// 		var y = data.tx[0];
				// console.log(tx,rx,point);
				// console.log(tx);
 				charts[id].xAxis[0].setCategories(point[iface]);
				charts[id].series[0].setData(tx[iface]);
				charts[id].series[1].setData(rx[iface]);
				// charts[id].series[0].addPoint([x,y], true, true);

				// charts[id].series[1].addPoint([data.point[0], data.rx[0]], true, true);
				
				// console.log(tx);
		// 	},
		// 	error: function(XMLHttpRequest, textStatus, errorThrown) { 
		// 	  console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
		// 	}       
		// });
		
	}

	function graphArea(id){
		var container = $('#'+id);
		if(!container.length) return false;
		var interface = container.data('interface');
		var title = container.data('title');
		
		Highcharts.addEvent(Highcharts.Series, 'afterInit', function () {
			this.symbolUnicode = {
			circle: '●',
			diamond: '♦',
			square: '■',
			triangle: '▲',
			'triangle-down': '▼'
			}[this.symbol] || '●';
		});		


		charts[id] = new Highcharts.Chart({
		    chart: {
		    	renderTo: id,
		        type: 'area',
		        animation: Highcharts.svg,
		  		type: 'areaspline',
		        events: {
					load: function () {
					  setInterval(function () {
						requestData(interface, id);
					  }, 5000);
					}				
				  }
		    },
		    title: {text: title
		    },
		    xAxis: {
		        // type: 'datetime',
        		// tickPixelInterval: 150
		    },
		    yAxis: {
		        minPadding: 0.2,
				maxPadding: 0.2,
				title: {text: null},
				labels: {
				  formatter: function () {      
					var bits = this.value;                          
					var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
					if (bits == 0) return '0 bps';
					var i = parseInt(Math.floor(Math.log(bits) / Math.log(1024)));
					return parseFloat((bits / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];                    	
			
				  },
				}, 
		    },
		    tooltip: {
			  formatter: function () { 
				var _0x2f7f=["\x70\x6F\x69\x6E\x74\x73","\x79","\x62\x70\x73","\x6B\x62\x70\x73","\x4D\x62\x70\x73","\x47\x62\x70\x73","\x54\x62\x70\x73","\x3C\x73\x70\x61\x6E\x20\x73\x74\x79\x6C\x65\x3D\x22\x63\x6F\x6C\x6F\x72\x3A","\x63\x6F\x6C\x6F\x72","\x73\x65\x72\x69\x65\x73","\x3B\x20\x66\x6F\x6E\x74\x2D\x73\x69\x7A\x65\x3A\x20\x31\x2E\x35\x65\x6D\x3B\x22\x3E","\x73\x79\x6D\x62\x6F\x6C\x55\x6E\x69\x63\x6F\x64\x65","\x3C\x2F\x73\x70\x61\x6E\x3E\x3C\x62\x3E","\x6E\x61\x6D\x65","\x3A\x3C\x2F\x62\x3E\x20\x30\x20\x62\x70\x73","\x70\x75\x73\x68","\x6C\x6F\x67","\x66\x6C\x6F\x6F\x72","\x3A\x3C\x2F\x62\x3E\x20","\x74\x6F\x46\x69\x78\x65\x64","\x70\x6F\x77","\x20","\x65\x61\x63\x68","\x3C\x62\x3E\x4D\x69\x6B\x68\x6D\x6F\x6E\x20\x54\x72\x61\x66\x66\x69\x63\x20\x4D\x6F\x6E\x69\x74\x6F\x72\x3C\x2F\x62\x3E\x3C\x62\x72\x20\x2F\x3E\x3C\x62\x3E\x54\x69\x6D\x65\x3A\x20\x3C\x2F\x62\x3E","\x25\x48\x3A\x25\x4D\x3A\x25\x53","\x78","\x64\x61\x74\x65\x46\x6F\x72\x6D\x61\x74","\x3C\x62\x72\x20\x2F\x3E","\x20\x3C\x62\x72\x2F\x3E\x20","\x6A\x6F\x69\x6E"];var s=[];$[_0x2f7f[22]](this[_0x2f7f[0]],function(_0x3735x2,_0x3735x3){var _0x3735x4=_0x3735x3[_0x2f7f[1]];var _0x3735x5=[_0x2f7f[2],_0x2f7f[3],_0x2f7f[4],_0x2f7f[5],_0x2f7f[6]];if(_0x3735x4== 0){s[_0x2f7f[15]](_0x2f7f[7]+ this[_0x2f7f[9]][_0x2f7f[8]]+ _0x2f7f[10]+ this[_0x2f7f[9]][_0x2f7f[11]]+ _0x2f7f[12]+ this[_0x2f7f[9]][_0x2f7f[13]]+ _0x2f7f[14])};var _0x3735x2=parseInt(Math[_0x2f7f[17]](Math[_0x2f7f[16]](_0x3735x4)/ Math[_0x2f7f[16]](1024)));s[_0x2f7f[15]](_0x2f7f[7]+ this[_0x2f7f[9]][_0x2f7f[8]]+ _0x2f7f[10]+ this[_0x2f7f[9]][_0x2f7f[11]]+ _0x2f7f[12]+ this[_0x2f7f[9]][_0x2f7f[13]]+ _0x2f7f[18]+ parseFloat((_0x3735x4/ Math[_0x2f7f[20]](1024,_0x3735x2))[_0x2f7f[19]](2))+ _0x2f7f[21]+ _0x3735x5[_0x3735x2])});return _0x2f7f[23]+ Highcharts[_0x2f7f[26]](_0x2f7f[24], new Date(this[_0x2f7f[25]]))+ _0x2f7f[27]+ s[_0x2f7f[29]](_0x2f7f[28])
			  },
			  shared: true                                                      
			},
			series: [
				{name: 'Tx', data: [], marker: {symbol: 'circle'}}, 
				{name: 'Rx', data: [], marker: {symbol: 'circle'}}
			],
		    // plotOptions: {
		    //     area: {
		    //         // pointStart: function,
		    //         marker: {
		    //             enabled: false,
		    //             symbol: 'circle',
		    //             radius: 2,
		    //             states: {
		    //                 hover: {
		    //                     enabled: true
		    //                 }
		    //             }
		    //         }
		    //     }
		    // },
		});
	}


</script>

    <!-- End loading page level scripts-->

    </body>

</html>	