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
                                        <h2>Log Activity</h2>
                                        <div class="col-sm-3 pull-right" style="margin:10px 0 0 0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-search"></i>
                                                </span>
                                                <input class="form-control" placeholder='Search..' type="text" id="searchLogApp">
                                            </div>
                                        </div>
                                        <div class="btn-group pull-right" role="group" aria-label="Basic example" style="margin:10px">
                                            <a class="btn btn-success" data-aksi="refreshLogApp"><i class="fa fa-refresh"></i></a>    
                                        </div>        
                                        <div class="btn-group pull-right" role="group" aria-label="Basic example" style="margin:10px 0 0 0">
                                            <button type="button" class="btn btn-primary" data-aksi="allLogApp">All</button>
                                            <button type="button" class="btn btn-primary" data-aksi="mainLogApp">Main Router</button>
                                            <button type="button" class="btn btn-primary" data-aksi="simonetLogApp">SIMONET</button>
                                        </div>
                                    </div>
                                    <div class="panel-body ">
                                        <div class="col-md-3 pull-right">
											<button class="btn btn-default" id="daterangepicker2">
												<i class="ti ti-calendar"></i> 
												<span></span> <b class="caret"></b>
											</button>
										</div>
                                    <table id="tb_log" class="table about-table" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 250px">Date</th>
                                                <th>Event</th>
                                                <th style="width: 100px">Tag</th>
                                                <th>From</th>
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
    tableLogApp = $('#tb_log').DataTable({
        responsive : true,
        pageLength : 100,
        lengthChange: false,
        scrollY: "500px",
        scrollCollapse: true,
        dom: 'Trt<"bottom"ip><"clear">',
        order: [[ 0, "desc" ]],
        ajax : {
            "url" : "<?php echo site_url('log/logEventJSON')?>",
            "type" : "POST"
            // "dataSrc" : ""
        },
        columns : [
            {"data" : "DeviceReportedTime"},
            {"data" : "Message"},
            {"data" : "SysLogTag"},
            {"data" : "FromHost"}
        ],
        "createdRow": function(row, data, dataIndex) {
            if (data["SysLogTag"] == 'devices,device-up,simonet') {
                $(row).css("color", "#2ecc71");
            }else if(data["SysLogTag"] == 'devices,device-down,simonet') {
                $(row).css("color", "red");
            }else{
                $(row).css("color", "#000");
            }
        }
    });

    $('#searchLogApp').keyup(function(){
        tableLogApp.search($(this).val()).draw() ;
    })

    $('body').on('click','button[data-aksi="allLog"]',function(){
        tableLogApp.search('').draw();
    });

    $('body').on('click','button[data-aksi="main"]',function(){
        tableLogApp.search('10.10.10.1').draw();   
    });
    
    $('body').on('click','button[data-aksi="simonet"]',function(){
        tableLogApp.search('SIMONETapp').draw();
    });

    $('body').on('click','a[data-aksi="reload"]',function(){
        reload_table();
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
    },function(start, end) {
			var date = {start: start.format('YYYY-MM-DD HH:mm:ss'),
				end: end.format('YYYY-MM-D HH:mm:ss'),
			};
			$('#daterangepicker2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

			$('.mychartInterface').each(function(){
				interfaceChart($(this).attr('id'),date);
			})

			$('.highcharts-credits').hide();			
	}).keyup(function() {
        minDateFilter = new Date(this.value).getTime();
        tableLogApp.fnDraw();
    });

    // Date range filter
    minDateFilter = "";
    maxDateFilter = "";

    $.fn.dataTableExt.afnFiltering.push(
    function(oSettings, aData, iDataIndex) {
        if (typeof aData._date == 'undefined') {
        aData._date = new Date(aData[0]).getTime();
        }

        if (minDateFilter && !isNaN(minDateFilter)) {
        if (aData._date < minDateFilter) {
            return false;
        }
        }

        if (maxDateFilter && !isNaN(maxDateFilter)) {
        if (aData._date > maxDateFilter) {
            return false;
        }
        }

        return true;
    }
    );
    
    function reload_table(){
        $.skylo('start');
        tableLogApp.ajax.reload(null,false);
        $.skylo('end');
    }
</script>


</body>
</html>