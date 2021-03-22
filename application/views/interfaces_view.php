<?php $this->load->view('Templates/headersidebar_view'); ?>
</div>
    </div>
    <div class="static-content-wrapper">
        <div class="static-content">
            <div class="page-content">
                <!-- <ol class="breadcrumb">
                    <li><a href="#">Hotspot</a></li>
                    <li class="active"><a href="#">User Active</a></li>
                </ol> -->
                <div class="container-fluid" style="margin-top: 10px">
                    <div data-widget-group="group1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h2>Data Interfaces</h2>
                                        <div class="col-md-2 pull-right" style="margin:10px 0 0 0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-search"></i>
                                                </span>
                                                <input class="form-control" placeholder='Search..' type="text" id="searchInterfacesField">
                                            </div>
                                        </div>
                                        <a class="btn btn-info pull-right" data-aksi="reload" href="javascript:;" style="margin : 10px"><i class="fa fa-refresh"></i></a>
                                    </div>
                                    <div class="panel-body ">
                                        <table id="tb_interfaces" class="table table-hover" cellspacing="0" width="100%" style="cursor:pointer">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Actual MTU</th>
                                                    <th>L2MTU</th>
                                                    <th>Mac-Address</th>
                                                    <th>Tx</th>
                                                    <th>Rx</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="panel-footer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
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


<div class="modal fade" id="modal_interface" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-title">Add Device</h4>
            </div>
            <div class="modal-body form">
                <div class="tab-container tab-default">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#Statistic" data-toggle="tab">Interface Statistic</a>
                        </li>
                        <li>
                            <a href="#SetInterface" data-toggle="tab">Set Intreface Name</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="Statistic">
                        <div class="panel panel-bluegray" data-widget='{"id" : "wiget9", "draggable": "false"}'>
                            <div class="panel-body">
                                <div class="mychart" id="chart" style="height: 272px;" class="mt-sm mb-sm"></div>
                            </div>
                        </div>
                        </div>
                        <div class="tab-pane" id="SetInterface">
                            <form id="setInterface" action="＃" method="post" class="form-horizontal row-border">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="name" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Type</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="type" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Actual MTU</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="mtu" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">L2MTU</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="l2mtu" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Mac-Address</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="mac" class="form-control" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <button type="button" class="close" class="btn btn-success pull-right" style="margin: 10px 0px 0px 0px">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('Templates/footer_view'); ?>
<script type="text/javascript">
    table = $('#tb_interfaces').DataTable({
        responsive : true,
        oLanguage: {
        "sLengthMenu": " _MENU_ ",
        "sSearch": "Search..."
        },
        dom: 'Trt<"bottom"ip><"clear">',
        ajax : {
            "url" : "<?php echo site_url('interfaces/interfacesJSON')?>",
            "type" : "POST"
            // "dataSrc" : ""
        },
        columns : [
            {"data" : "icon"},
            {"data" : "name"},
            {"data" : "type"},
            {"data" : "actual-mtu"}, 
            {"data" : "l2mtu"},
            {"data" : "mac-address"},
            {"data" : "tx-byte"},
            {"data" : "rx-byte"}
        ],
    });

    $('#searchInterfacesField').keyup(function(){
        table.search($(this).val()).draw() ;
    })

    $('table#tb_interfaces').on('click','tbody tr',function(){
        var data = {
            name : $(this).find('td:eq(1)').html(),
            type : $(this).find('td:eq(2)').html(),
            mtu : $(this).find('td:eq(3)').html(),
            l2mtu : $(this).find('td:eq(4)').html(),
            mac : $(this).find('td:eq(5)').html(),
        };
        console.log(data.name);
        // chartData.abort();
        clearInterval(interval);
        tx=[], rx=[], point=[];
        editInterface(data);
    })

    $('body').on('click','a[data-aksi="reload"]',function(){
        reload_table();
    });
    
    function reload_table(){
        $.skylo('start');
        table.ajax.reload(null,false);
        $.skylo('end');
    }

    function editInterface(data){
        var data = data;
        $('#setInterface')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty(); 
        //tab-edit
        $('[name="name"]').val(data.name);
        $('[name="type"]').val(data.type);
        $('[name="mtu"]').val(data.mtu);
        $('[name="l2mtu"]').val(data.l2mtu);
        $('[name="mac"]').val(data.mac);
        interfaceChart(data.name);
        $('#modal_interface').modal('show');
        $('.modal-title').text(data.name);
    }

    var charts = {};
	var chart;
    var tx = [], rx = [], point = [];
    var chartData;
    var interval;
    function requestData(iface){
		chartData = $.ajax({
			url: '<?php echo site_url("interfaces/getInterfaceChart");?>',     						
			type: "POST",
			dataType: "JSON",
            data: {iface:iface} ,
			success: function(data) {	
                if (tx.length == 10) {
					tx.shift();
					rx.shift();
					point.shift();
				}
				tx.push(parseInt(data.data['tx']));	
				rx.push(parseInt(data.data['rx']));
				point.push(data.data['point']);

				charts[0].xAxis[0].setCategories(point);
				charts[0].series[0].setData(tx);
				charts[0].series[1].setData(rx);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
			  console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
			}       
		});
		
	}

    function interfaceChart(interface) { 
			charts[0] = new Highcharts.Chart({
			chart: {
				renderTo: 'chart',
		  		animation: Highcharts.svg,
				type: 'areaspline',
				// zoomType: 'x',
				events: {
					load: function () {
					interval = setInterval(function () {
						requestData(interface);
					}, 10000);
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
				// categories : data.point,
				// tickInterval: 60
				
				// labels: {
				//     data : data.point,
				// format: '{value:%Y-%m-%d}',
				// rotation: 45,
				// align: 'left'
				// }
			},
			yAxis: {
				// title: {
				//     text: 'Y-Axis'
				// }
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
				enabled: false
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
</script>


</body>
</html>