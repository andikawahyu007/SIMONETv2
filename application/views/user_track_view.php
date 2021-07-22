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
                                        <h2>Data User Active</h2>
                                        <div class="col-md-2 pull-right" style="margin:10px 0 0 0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-search"></i>
                                                </span>
                                                <input class="form-control" placeholder='Search..' type="text" id="searchUserActiveField">
                                            </div>
                                        </div>
                                        <a class="btn btn-info pull-right" data-aksi="reload" href="javascript:;" style="margin : 10px"><i class="fa fa-refresh"></i></a>
                                    </div>
                                    <div class="panel-body ">
                                        <table id="tb_aktif" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>ID</th> -->
                                                    <th>Mac Address</th>
                                                    <th>IP Address</th>
                                                    <th>Hostname</th>
                                                    <th>SSID</th>
                                                    <th>Location</th>
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

<?php $this->load->view('Templates/footer_view'); ?>
<script type="text/javascript">
    // setTimeout(function() {

        table = $('#tb_aktif').DataTable({
        responsive : true,
        oLanguage: {
        "sLengthMenu": " _MENU_ ",
        "sSearch": "Search..."
        },
        dom: 'Trt<"bottom"ip><"clear">',
        ajax : {
            "url" : "<?php echo site_url('hotspot/usertrackJSON')?>",
            "type" : "POST",
            "fields": [ {
                "label": "Mac Address:",
                "name": "mac"
            }, {
                "label": "IP Address:",
                "name": "ip"
            }, {
                "label": "Hostname:",
                "name": "hostname"
            }, {
                "label": "SSID:",
                "name": "essid"
            }, {
                "label": "Location:",
                "name": "ap_mac"
            }
            ],
            "dataSrc" : ""
        },
        columns : [
            // {"data" : "id"},
            {
                "data" : "mac",
                render: function ( data, type, row ) {
                    
                    field = (data===undefined || data==="")? " ":data;
                    return field;
                },
        },
            {"data" : "ip",
                render: function ( data, type, row ) {
                    
                    field = (data===undefined || data==="")? " ":data;
                    return field;
                }
        },
            {"data" : "hostname",
                render: function ( data, type, row ) {
                    
                    field = (data===undefined || data==="")? " ":data;
                    return field;
                }
        },
            {"data" : "essid",
                render: function ( data, type, row ) {
                    
                    field = (data===undefined || data==="")? " ":data;
                    return field;
                },
        },
            {"data" : "ap_mac",
                render: function ( data, type, row ) {
                    
                    field = (data===undefined || data==="")? " ":data;
                    return field;
                }
        }
        ],
    });

    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
    console.log(message);
};

    // }, 1000 * 10);

    

    $('#searchUserActiveField').keyup(function(){
        table.search($(this).val()).draw() ;
    })

    $('body').on('click','a[data-aksi="reload"]',function(){
        reload_table();
    });   

    function reload_table(){
        $.skylo('start');
        table.ajax.reload(null,false);
        $.skylo('end');
    }
</script>


</body>
</html>