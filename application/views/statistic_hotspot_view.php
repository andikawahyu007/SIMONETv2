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
										<h2>Statistic Hotspot</h2>
                                    </div>
                                    <div class="panel-body" id="divPrint">
										<div class="row">
                                            <div class="col-md-3" style="margin: 0 auto">
                                                <h4>Wire vs Wireless Client</h4>
                                                <hr>
                                                <div id="userConnect"></div>
                                            </div>
                                            <div class="col-md-1">
                                            </div>
                                            <div class="col-md-4" style="margin: 0 auto">
                                                <h4>Wireless Client (per SSID)</h4>
                                                <hr>
                                                <div id="userConnectSSID"></div>
                                            </div>
                                            <div class="col-md-1">
                                            </div>
                                            <div class="col-md-3" style="margin: 0 auto">
                                                <h4>Wireless Client (per Radio Type)</h4>
                                                <hr>
                                                <div id="userConnectRadio"></div>
                                            </div>
                                        <!-- <div class="col-md-6">
                                                <table id="userCountAP" class="table table">
                                                    <thead>
                                                        <tr>
                                                            <th>Ap Name </th>
                                                            <th>Wireless Client</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div> -->
                                        </div>
										<div class="row">
                                            <div class="col-md-6">
                                                <h4>Top Access Point</h4>
                                                <hr>
                                                <div id="userConnectAP"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>Top Access Point</h4>
                                                <hr>
                                                <table id="userCountAP" class="table table">
                                                    <thead>
                                                        <tr>
                                                            <th>AP Name </th>
                                                            <th>Wireless Client</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Most Active Profile</h4>
                                                <hr>
                                                <table id="mostActiveProfile" class="table table">
                                                    <thead>
                                                        <tr>
                                                            <th>Profile Name </th>
                                                            <th>Upload</th>
                                                            <th>Download</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>Most Active Client</h4>
                                                <hr>
                                                <table id="mostActiveClient" class="table table">
                                                    <thead>
                                                        <tr>
                                                            <th>Name </th>
                                                            <th>Upload</th>
                                                            <th>Download</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
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
    pieClient();
    pieAP();
    pieRadio();
    pieSSID();

    table = $('#userCountAP').DataTable({
        responsive : true,
        pageLength : 100,
        lengthChange: false,
        scrollY: "300px",
        scrollCollapse: true,
        dom: 'Trt<"bottom"><"clear">',
        order: [[ 1, "desc" ]],
        ajax : {
            "url" : "<?php echo site_url('statistic/getUserCountAPJSON')?>",
            "type" : "POST"
            // "dataSrc" : ""
        },
        columns : [
            // {"data" : "id"},
            {"data" : "name"},
            {"data" : "y"}
        ],
    });

    table1 = $('#userCountSSID').DataTable({
        responsive : true,
        pageLength : 100,
        lengthChange: false,
        scrollY: "200px",
        scrollCollapse: true,
        order: [[ 1, "desc" ]],
        dom: 'Trt<"bottom"><"clear">',
        ajax : {
            "url" : "<?php echo site_url('statistic/getUserCountSSIDJSON')?>",
            "type" : "POST"
            // "dataSrc" : ""
        },
        columns : [
            // {"data" : "id"},
            {"data" : "name"},
            {"data" : "y"}
        ],
    });

    table2 = $('#mostActiveProfile').DataTable({
        responsive : true,
        pageLength : 100,
        lengthChange: false,
        scrollY: "200px",
        scrollCollapse: true,
        order: false,
        dom: 'Trt<"bottom"><"clear">',
        ajax : {
            "url" : "<?php echo site_url('statistic/getMostActiveProfile')?>",
            "type" : "POST"
            // "dataSrc" : ""
        },
        columns : [
            // {"data" : "id"},
            {"data" : "profile"},
            {"data" : "upload"},
            {"data" : "download"}
        ],
    });

    table3 = $('#mostActiveClient').DataTable({
        responsive : true,
        pageLength : 100,
        lengthChange: false,
        scrollY: "150px",
        scrollCollapse: true,
        order: false,
        dom: 'Trt<"bottom"><"clear">',
        ajax : {
            "url" : "<?php echo site_url('statistic/getMostActiveClient')?>",
            "type" : "POST"
            // "dataSrc" : ""
        },
        columns : [
            // {"data" : "id"},
            {"data" : "name"},
            {"data" : "bytes_in"},
            {"data" : "bytes_out"}
        ],
    });

    
    function requestUserCount() 
	{
		$.ajax({
			url: '<?php echo site_url("Statistic/getUserCountJSON");?>',     						
			type: "POST",
			dataType: "JSON",
			success: function(data) {
				charts.series[0].setData(data.data);
                // var chart = this,
                    x = charts.plotLeft + (charts.series[0].center[0]),
                    y = charts.plotTop + (charts.series[0].center[1]);
                    charts.pieCenter = charts.renderer.text(data.total+'<br>clients', x, y, true)
                    .css({
                        'text-align': 'center',
                        color: 'black',
                        fontSize: '12px'
                    })
                    .add();
                    box = charts.pieCenter.getBBox();
                    charts.pieCenter.attr({
                        x: x - box.width / 2,
                        y: y - box.height / 4
                    });
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
			  console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
			}       
		});
        setTimeout(function(){ pieClient(); }, 60000);
	}

	function pieClient(){
        Highcharts.setOptions({
            colors: ['#2ecc71', '#3498db', '#3355FF', '#8333FF', '#8E44AD', '#E74C3C', '#FFF263', '#6AF9C4']
        });
        charts = new Highcharts.chart({
            chart: {
                renderTo: 'userConnect',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                events: {
                    load: function () {
                        requestUserCount();
                    },	
                },
            },
            exporting: { 
                enabled: false 
            },
            title: {
                text: '',
        style: {
            display: 'none'
        }
            },
                tooltip: {
                pointFormat: '{point.y} clients</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                    enabled: false
                },
            // legend: {
            //     align: 'right',
            //     verticalAlign: 'top',
            //     layout: 'vertical',
            //     x: 0,
            //     y: 100
            // },
            series: [{
                minPointSize: 10,
                innerSize: '20%',
                zMin: 0,
                name: 'user connect',
                data: []
            }]
        });
    }


    function requestUserCountAP() 
	{
		$.ajax({
			url: '<?php echo site_url("Statistic/getUserCountAPJSON");?>',     						
			type: "POST",
			dataType: "JSON",
			success: function(data) {
				charts1.series[0].setData(data.data);
                // var chart = this,
                    x = charts1.plotLeft + (charts1.series[0].center[0]),
                    y = charts1.plotTop + (charts1.series[0].center[1]);
                    charts1.pieCenter = charts1.renderer.text(data.total+'<br>clients', x, y, true)
                    .css({
                        'text-align': 'center',
                        color: 'black',
                        fontSize: '12px'
                    })
                    .add();
                    box = charts1.pieCenter.getBBox();
                    charts1.pieCenter.attr({
                        x: x - box.width / 2,
                        y: y - box.height / 4
                    });
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
			  console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
			}       
		});
        setTimeout(function(){ pieAP(); }, 60000);
	}

	function pieAP(){
        Highcharts.setOptions({
            colors: ['#2ecc71', '#3498db', '#3355FF', '#8333FF', '#8E44AD', '#E74C3C', '#FFF263', '#6AF9C4']
        });
        charts1 = new Highcharts.chart({
            chart: {
                renderTo: 'userConnectAP',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                events: {
                    load: function () {
                        requestUserCountAP();
                    },	
                },
            },
            exporting: { 
                enabled: false 
            },
            title: {
                text: '',
        style: {
            display: 'none'
        }
            },
                tooltip: {
                pointFormat: '{point.y} clients</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                    enabled: false
                },
            // legend: {
            //     align: 'right',
            //     verticalAlign: 'top',
            //     layout: 'vertical',
            //     x: 0,
            //     y: 100
            // },
            series: [{
                minPointSize: 10,
                innerSize: '20%',
                zMin: 0,
                name: 'user connect',
                data: []
            }]
        });
    }

    function requestUserCountSSID() 
	{
		$.ajax({
			url: '<?php echo site_url("Statistic/getUserCountSSIDJSON");?>',     						
			type: "POST",
			dataType: "JSON",
			success: function(data) {
				charts2.series[0].setData(data.data);
                x = charts2.plotLeft + (charts2.series[0].center[0]),
                    y = charts2.plotTop + (charts2.series[0].center[1]);
                    charts2.pieCenter = charts2.renderer.text(data.total+'<br>clients', x, y, true)
                    .css({
                        'text-align': 'center',
                        color: 'black',
                        fontSize: '12px'
                    })
                    .add();
                    box = charts2.pieCenter.getBBox();
                    charts2.pieCenter.attr({
                        x: x - box.width / 2,
                        y: y - box.height / 4
                    });
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
			  console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
			}       
		});
        setTimeout(function(){ pieSSID(); }, 60000);
	}

	function pieSSID(){
        Highcharts.setOptions({
            colors: ['#2ecc71', '#3498db', '#3355FF', '#8333FF', '#8E44AD', '#E74C3C', '#FFF263', '#6AF9C4']
        });
        
        charts2 = new Highcharts.chart({
            chart: {
                renderTo: 'userConnectSSID',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                events: {
                    load: function () {
                        requestUserCountSSID();
                    },	
                },
            },
            exporting: { 
                enabled: false 
            },
            title: {
                text: '',
                style: {
                    display: 'none'
                }
            },
            tooltip: {
                pointFormat: '{point.y} clients</b>'
            },
            pane: {
                startAngle: 0,
                endAngle: 360,
                background: [{ // Track for Move
                    outerRadius: '112%',
                    innerRadius: '88%',
                    backgroundColor: Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0.3).get(),
                    borderWidth: 10,
                    borderColor: 'white'
                }]
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                    enabled: false
                },
            // legend: {
            //     align: 'right',
            //     verticalAlign: 'top',
            //     layout: 'vertical',
            //     x: 0,
            //     y: 100
            // },
            series: [{
                colorByPoint: true,
                minPointSize: 10,
                innerSize: '20%',
                zMin: 0,
                name: 'user connect',
                data: []
            }]
        });
    }

    function requestUserCountRadio() 
	{
		$.ajax({
			url: '<?php echo site_url("Statistic/getUserCountRadioJSON");?>',     						
			type: "POST",
			dataType: "JSON",
			success: function(data) {
				charts3.series[0].setData(data.data);
                x = charts3.plotLeft + (charts3.series[0].center[0]),
                    y = charts3.plotTop + (charts3.series[0].center[1]);
                    charts3.pieCenter = charts3.renderer.text(data.total+'<br>clients', x, y, true)
                    .css({
                        'text-align': 'center',
                        color: 'black',
                        fontSize: '12px'
                    })
                    .add();
                    box = charts3.pieCenter.getBBox();
                    charts3.pieCenter.attr({
                        x: x - box.width / 2,
                        y: y - box.height / 4
                    });
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
			  console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
			}       
		});
        setTimeout(function(){ pieRadio(); }, 60000);
	}

	function pieRadio(){
        Highcharts.setOptions({
            colors: ['#2ecc71', '#3498db', '#3355FF', '#8333FF', '#8E44AD', '#E74C3C', '#FFF263', '#6AF9C4']
        });
        
        charts3 = new Highcharts.chart({
            chart: {
                renderTo: 'userConnectRadio',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                events: {
                    load: function () {
                        requestUserCountRadio();
                    },	
                },
            },
            exporting: { 
                enabled: false 
            },
            title: {
                text: '',
                style: {
                    display: 'none'
                }
            },
            tooltip: {
                pointFormat: '{point.y} clients</b>'
            },
            pane: {
                startAngle: 0,
                endAngle: 360,
                background: [{ // Track for Move
                    outerRadius: '112%',
                    innerRadius: '88%',
                    backgroundColor: Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0.3).get(),
                    borderWidth: 10,
                    borderColor: 'white'
                }]
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                enabled: false
            },
            // legend: {
            //     align: 'right',
            //     verticalAlign: 'top',
            //     layout: 'vertical',
            //     x: 0,
            //     y: 100
            // },
            series: [{
                colorByPoint: true,
                minPointSize: 10,
                innerSize: '20%',
                zMin: 0,
                name: 'user connect',
                data: []
            }]
        });
    }

</script>

</body>
</html>
