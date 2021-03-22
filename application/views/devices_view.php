<?php $this->load->view('Templates/headersidebar_view'); ?>
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
                                    <?php echo $this->session->flashdata('devices') ?>
                                    <div class="panel-heading">    
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-primary" data-aksi="all">All</button>
                                            <button type="button" class="btn btn-primary" data-aksi="mikrotik">MikroTik</button>
                                            <button type="button" class="btn btn-primary" data-aksi="unifi">UniFi</button>
                                        </div>
                                        <div class="btn-group pull-right" id="tools">
                                        </div>
                                        <div class="col-md-2 pull-right" style="margin:10px 0 0 0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-search"></i>
                                                </span>
                                                <input class="form-control" placeholder='Search..' type="text" id="myInputTextField">
                                            </div>
                                        </div>
                                        <div class="btn-group pull-right" id="button-table" role="group" aria-label="Basic example" style="margin:10px 0 0 0px">
                                            <?php if($this->session->userdata('role')==='adm'){    ?>
                                                <!-- <a class="btn btn-info" id="upgradeUnifi" data-aksi="upgradeUniFi" style="margin:10px 0 0 0px; visibility: hidden;"><i class="fa fa-arrow-circle-up"></i> Upgrade</a> -->
                                                <a class="btn btn-success" data-aksi="config"><i class="fa fa-wrench"></i></a>    
                                                <a class="btn btn-success" data-aksi="add"><i class="fa fa-plus"></i></a>    
                                                <a class="btn btn-success" data-aksi="refresh"><i class="fa fa-refresh"></i></a>    
                                            <?php } ?>
                                        </div>
                                            
                                    </div>
                                    <div class="panel-body">
                                        <table id="tb_devices" class="table table-hover" cellspacing="0" width="100%" style="cursor:pointer">
                                            <thead>
                                                <tr><th></th>
                                                    <th>Device Name</th>
                                                    <th>Status</th>
                                                    <th>IP Address</th>
                                                    <th>Serial Number</th>
                                                    <th>Version</th>
                                                    <th>Uptime</th>
                                                    <th>Model</th>
                                                    <th>Platform</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
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


<div class="modal fade" id="modal_form" role="dialog" >
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
                            <a href="#AddManualy" data-toggle="tab">Add Device</a>
                        </li>
                        <li>
                            <a href="#DiscoveryDevice" data-toggle="tab">Discover MikroTik</a>
                        </li>
                        <li>
                            <a href="#UniFiDevice" data-toggle="tab">Discover UniFi</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="AddManualy">
                            <form id="form" action="＃" method="post" class="form-horizontal row-border">
                                <input type="hidden" value="" name="id"/> 
                            
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Serial Number</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="serial" class="form-control" placeholder='Serial Number Device'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">IP Address</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="address4" class="form-control" placeholder='IP Address Device' required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Mac-Address</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="mac_address" class="form-control" placeholder='Mac Address' required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Platform</label>
                                    <div class="col-sm-8">
                                        <select name="platform" id="selector_platform" class="form-control">
                                            <option value="">--- Select ---</option>
                                            <option value="MikroTik">MikroTik</option>
                                            <option value="MikroTik Switch">MikroTik Switch</option>
                                            <option value="UniFi">UniFi</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Location</label>
                                    <div class="col-sm-8">
                                        <select name="location" id="selector2" class="form-control">
                                            <option value="">--- Select ---</option>
                                            <?php foreach ($location as $row) : ?>
                                                <option value="<?php print_r($row); ?>"><?php echo $row['nama'];?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <button type="submit" id="btnSave" onClick="save()" class="btn btn-success pull-right" style="margin: 10px 0px 0px 0px">Save</button>
                        </div>
                        <div class="tab-pane" id="DiscoveryDevice">
                            <div class="panel-heading">    
                                <div class="col-md-4 pull-right" style="margin:10px 0 0 0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-search"></i>
                                        </span>
                                        <input class="form-control" placeholder='Search..' type="text" id="searchMikroTik">
                                    </div>
                                </div>
                                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                    <a class="btn btn-success" data-aksi="refreshMikroTik" style="margin:10px 0 0 0px"><i class="fa fa-refresh"></i></a>    
                                </div>        
                            </div>
                            <div class="panel-body">
                                <table id="tb_discovery" class="table about-table " cellspacing="0" width="100%" style="font-size:11px">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Interface</th>
                                            <th>IP Address</th>
                                            <th>Identity</th>
                                            <th>Board</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="UniFiDevice">
                            <div class="panel-heading">    
                                <div class="col-md-4 pull-right" style="margin:10px 0 0 0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-search"></i>
                                        </span>
                                        <input class="form-control" placeholder='Search..' type="text" id="searchUniFi">
                                    </div>
                                </div>
                                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                    <a class="btn btn-success" data-aksi="refreshUniFi" style="margin:10px 0 0 0px"><i class="fa fa-refresh"></i></a>    
                                </div>        
                            </div>
                            <div class="panel-body">
                                <table id="tb_unifi" class="table about-table " cellspacing="0" width="100%" style="font-size:11px">
                                    <thead>
                                        <tr>
                                            <th>IP Address</th>
                                            <th>Identity</th>
                                            <th>Model</th>
                                            <th>Version</th>
                                            <th>Action</th>
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
    </div>
</div>

<div class="modal fade" id="modal_config" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-title">Config Device Mikrotik</h4>
            </div>
            <div class="modal-body form">
                <form id="form" action="＃" method="post" class="form-horizontal row-border">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Devices</label>
                        <div class="col-sm-8">
                            <select name="configdevice" id="configdevice" class="select-device-ajax" multiple="multiple">
                                <option value="">Select here</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Command</label>
                        <div class="col-sm-8">
                            <textarea name="command" class="form-control" placeholder='' required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnApply" onClick="apply()" class="btn btn-success pull-right" style="margin: 10px 0px 0px 0px">Apply</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('Templates/footer_view'); ?>


<script type="text/javascript">
    $(document).ready(function(){
        $('.select-device-ajax').select2({
            width: '100%',
            dropdownParent: $("#modal_config"),
            minimumSelectionLength: 1,
            allowClear: true,
            ajax: {
                url: '<?php echo site_url('devices/getDevicesByPlatform')?>',
                dataType: 'json',
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                },
            }
        });
        $(".select-device-ajax").each(function() {
            $(this).siblings(".select2-container").css('border', '1px solid #e3e3e3;');
        });
    })

    table = $('#tb_devices').DataTable({
        responsive : true,
        pageLength : 50,
        lengthChange: false,
        dom: 'BTrt<"bottom"ip><"clear">',
        buttons: [
            {
                className: "btn btn-success",
                extend: 'print',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default');
                }
            },
            {
                className: "btn btn-success",
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default');
                }
            },
            {
                className: "btn btn-success",
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 2]
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default');
                }
            },
            {
                className: "btn btn-success",
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 2 ]
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default');
                }
            },
        ],
        oLanguage: {
        "sLengthMenu": " _MENU_ ",
        "sSearch": "<span>Search..</span> _INPUT_"
        },
        ajax : {
            "url" : "<?php echo site_url('devices/devicesJSON')?>",
            "type" : "POST"
            // "dataSrc" : ""
        },
        columns : [
            {"data" : "img"},
            {"data" : "identity"},
            {"data" : "status"},
            {"data" : "address"},
            {"data" : "serial_number"},
            {"data" : "version"},
            {"data" : "uptime"},
            {"data" : "model"},
            {"data" : "platform"}
        ],
        "createdRow": function(row, data, dataIndex) {
            if (data["status"] == '<span class="badge" style="color: #f03a3e; background-color: transparent; border: 1px solid">Disconnected </span>') {
            $(row).css("background-color", "#B9BAB8");
            // $(row).addClass("label label-danger");
            }
        }
    });
    table.buttons().container().appendTo($('#button-table'));


    $('#myInputTextField').keyup(function(){
        table.search($(this).val()).draw() ;
    })

     $('body').on('click','button[data-aksi="all"]',function(){
         table.search('').draw();   
    //     $('#upgradeUnifi').css('visibility', 'hidden');
     });

     $('body').on('click','button[data-aksi="mikrotik"]',function(){
         table.search('MikroTik').draw();   
    //     $('#upgradeUnifi').css('visibility', 'hidden');
     });
    
     $('body').on('click','button[data-aksi="unifi"]',function(){
         table.search('UniFi').draw();
    //     $('#upgradeUnifi').css('visibility', 'visible');   
     });

    // $('body').on('click','a[data-aksi="upgradeUniFi"]',function(){
    //     upgradeUnifis();
    // });

    $('body').on('click','a[data-aksi="refresh"]',function(){
        syncUnifi();
    });

    setInterval(() => {
        reload_table();
    }, 60000);

    $('#tb_devices_filter input').attr('placeholder',"Search..");

    table2 = $('#tb_discovery').DataTable({
        pageLength: 5,
        responsive : true,
        dom: '<"top">rt<"bottom"p><"clear">',
        bLengthChange : false,
        bInfo: false,
        ajax : {
            "url" : "<?php echo site_url('devices/discoverydevices')?>",
            "type" : "POST"
            // "dataSrc" : ""
        },
        columns : [
            {"data" : "id"},
            {"data" : "interface"},
            {"data" : "address"},
            {"data" : "identity"},
            {"data" : "board"},
            {"data" : "aksi"}
        ],
    })

    table3 = $('#tb_unifi').DataTable({
        pageLength: 5,
        responsive : true,
        bLengthChange : false,
        bInfo: false,
        dom: '<"top">rt<"bottom"p><"clear">',
        ajax : {
            "url" : "<?php echo site_url('devices/getUnifiDevices')?>",
            "type" : "POST"
            // "dataSrc" : ""
        },
        columns : [
            {"data" : "address"},
            {"data" : "identity"},
            {"data" : "model"},
            {"data" : "version"},
            {"data" : "aksi"}
        ],
    })

    $('#searchMikroTik').keyup(function(){
        table2.search($(this).val()).draw() ;
    })

    $('#searchUniFi').keyup(function(){
        table3.search($(this).val()).draw() ;
    })

    $('body').on('click','a[data-aksi="config"]',function(){
        configDevice();
    })

    $('body').on('click','a[data-aksi="add"]',function(){
        addDevice();
    })

    $('body').on('click','a[data-aksi="refreshMikroTik"]',function(){
        reload_table2();
    })

    $('body').on('click','a[data-aksi="refreshUniFi"]',function(){
        reload_table3();
    })

    $('body').on('click','a[data-aksi="discovery"]',function(){
        var device = {
            identity : $(this).attr('data-identity'),
            address : $(this).attr('data-address'),
            mac_address : $(this).attr('data-mac_address'),
            version : $(this).attr('data-version'),
            uptime : $(this).attr('data-uptime'),
            platform : $(this).attr('data-platform'),
            board : $(this).attr('data-board'),
            status : $(this).attr('data-status')
        };
        addByDiscovery(device);
    })


    $('body').on('click','a[data-aksi="unifi"]',function(){
        var device = {
            identity : $(this).attr('data-identity'),
            serial : $(this).attr('data-serial'),
            address : $(this).attr('data-address'),
            mac_address : $(this).attr('data-mac'),
            version : $(this).attr('data-version'),
            model : $(this).attr('data-model'),
            uptime : $(this).attr('data-uptime'),
            platform : $(this).attr('data-platform'),
            status : $(this).attr('data-status')
        };
        addByDiscovery(device);
    })

    $('body').on('click','a[data-aksi="sync"]',function(){
        syncIdentity();
    });

    $('table#tb_devices').on('dblclick','tbody tr',function(){
        var serial = $(this).find('td:eq(4)').html();
        var url = '<?php echo site_url('devices/detaildevice')?>';
        // var form = $('<form action="' + url + '" method="post" target="_blank">' +
        var form = $('<form action="' + url + '" method="post" >' +
        '<input type="hidden" name="serial" value="'+serial+'" />' +
        '</form>');
        $('body').append(form);
        form.submit();
    })


    // $('table#tb_devices').on('','tbody tr',function(){
    //     var status = $(this).find('td:eq(2)').html();

    //     console.log(status);
    //     if(status == 'Disconnected'){
    //         $(this).css("background-color", "green");
    //     }
    // })

    // $('table#tb_devices tbody td').map(function(){
    //     if($this.text() === 'Disconnected') {
    //         $(this).css("background-color", "green");
    //     }
    // })

    function configDevice(){
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_config').modal('show');
        $('.modal-title').text('Config Device');
    }

    function addDevice(){
        save_method= 'add';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add Device');
    }

    function addByDiscovery(device){
        var data = device;
        bootbox.confirm('Anda yakin ingin menambahkan device ini ke database ?', function(result){
            if(result){
                if(device.platform=='MikroTik'){
                    bootbox.confirm('Anda ingin menconfigurasi device ini dengan config default ?', function(result){
                        if(result){
                            $.ajax({
                                url: "<?php echo site_url('devices/setdefaultconfigmikrotik/') ?>",
                                type: "POST",
                                data: {
                                    ip: device['address']
                                },
                                dataType: "JSON",
                                success: function(data){
                                    alert('success configurating this router!!')
                                },
                                error: function (jqXHR, textStatus, errorThrown){
                                    alert('Gagal menconfigurasi router!!');
                                }
                            })
                        }
                    })
                }
                $.post('<?php echo site_url('devices/addDeviceByDiscovery/') ?>',data,function(respon){
                if(respon.status){
                    $('#modal_form').modal('hide');
                    reload_table();
                    reload_table2();
                    reload_table3();
                }
                else{ 
                    bootbox.alert('error add this device');
                }
            },'json').fail(function(){
                bootbox.alert('error delete this data');
            })
            }
        });
    }

    function save(){
        bootbox.confirm('Anda yakin ingin menambahkan device ini ke database ?', function(result){
            if(result){
                $('#btnSave').text('saving...'); //change button text
                $('#btnSave').attr('disabled',true); //set button disable 
                var url;
            
                if(save_method == 'add') {
                    url = "<?php echo site_url('devices/adddevice')?>";
                }

                $.ajax({
                    url : url,
                    type: "POST",
                    data: $('#form').serialize(),
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status) 
                        {
                            $('#modal_form').modal('hide');
                            
                        }
                        reload_table();
                        $('#btnSave').text('save'); 
                        $('#btnSave').attr('disabled',false); 
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Gagal menyimpan data device');
                        $('#btnSave').text('save'); 
                        $('#btnSave').attr('disabled',false); 
                    }
                })
            }
        })
    }

    function syncUnifi(){
        $.skylo('start');
            $.ajax({
                url: "<?php echo site_url('devices/syncIPUniFiAll/') ?>",
                type: "POST",
                dataType: "JSON",
                success: function(data){
                    reload_table();
                    $.skylo('end');
                },
                error: function (jqXHR, textStatus, errorThrown){
                    alert('Error!!');
                }
            })
    }

    function upgradeUnifis(){
        if(confirm('Anda yakin ingin mengupgrade semua device UniFi?')){        
            var xhr = $.post('<?php echo site_url('devices/upgradeAllUnifi/') ?>',function(respon){
                    if(respon.status){
                        reload_table();
                    }
                },'json').fail(function(){
                    alert('error delete this data');
                })
                setTimeout(() => {
                    xhr.abort();
                }, 60000);
        }
        
    }

    function reload_table(){
        table.ajax.reload(null,false);
    }

    function reload_table2(){
        table2.ajax.reload(null,false);
    }

    function reload_table3(){
        table3.ajax.reload(null,false);
    }
</script>

</body>
</html>
