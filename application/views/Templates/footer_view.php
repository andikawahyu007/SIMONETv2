<div class="modal fade" id="modal_log" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-title">Log Activity</h4>
            </div>
            <div class="modal-body form">
                <div class="row " style="margin: 5px">
                    <div class="panel-heading" style="margin: 0px 0px 10px 0px">    
                        <div class="col-sm-3 pull-right">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input class="form-control" placeholder='Search..' type="text" id="searchLog">
                            </div>
                        </div>
                        <div class="btn-group pull-right" role="group" aria-label="Basic example">
                            <a class="btn btn-success" data-aksi="refreshLog"><i class="fa fa-refresh"></i></a>    
                        </div>        
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary" data-aksi="allLog">All</button>
                            <button type="button" class="btn btn-primary" data-aksi="main">Main Router</button>
                            <button type="button" class="btn btn-primary" data-aksi="simonet">SIMONET</button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="tb_simonetlog" class="table about-table" cellspacing="0" width="100%" style="font-size:11px">
                            <thead>
                                <tr>
                                    <th style="width: 150px">Date</th>
                                    <th>Event</th>
                                    <th style="width: 80px">Tag</th>
                                    <th>From</th>
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

<div class="modal fade" id="modal_settings" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-title">Settings</h4>
            </div>
            <div class="modal-body form">
                <div class="tab-container tab-left tab-default">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tabAdmin" data-toggle="tab">Admins</a>
                        </li>
                        <!-- <li>
                            <a href="#tabDev" data-toggle="tab">Device Auth</a>
                        </li> -->
                        <!-- <li>
                            <a href="#tabConfig" data-toggle="tab">Template Config</a>
                        </li> -->
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabAdmin">
                            <h4>Admins</h4>
                            <hr>
                            <table id="tb_admins" class="table about-table " cellspacing="0" width="100%" style="font-size:11px">
                                <!-- <thead> -->
                                    <tr>
                                        <th>Username</th>
                                        <th>E-mail</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                <!-- </thead> -->
                                <!-- <tbody>
                                </tbody> -->
                            </table>
                            <a href="#tabAddAdmin" data-aksi="#tabAddAdmin" data-toggle="tab" class="btn btn-default" style="margin: 10px 0px 0px 0px"><i class="fa fa-plus"></i> Add Admin</a>
                        </div>
                        <div class="tab-pane" id="tabAddAdmin">
                            <form id="formAdmin" action="＃" method="post" class="form-horizontal row-border">
                                <input type="hidden" value="" name="idAdmin"/> 
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Username</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="userAdmin" class="form-control" placeholder='Username'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="passwordAdmin" class="form-control" placeholder='Password'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">E-mail</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="emailAdmin" class="form-control" placeholder='Email' required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Role</label>
                                    <div class="col-sm-8">
                                    <select name="roleAdmin" class="form-control">
                                            <option value="">--- Select ---</option>
                                            <option value="adm">Administrator</option>
                                            <option value="read">Read Only</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <a type="submit" data-aksi="saveAdmin" id="btnSaveAdmin" class="btn btn-success pull-right" style="margin: 10px 0px 0px 0px">Save</a>
                        </div>
                        <div class="tab-pane" id="tabDev">
                            <h4>Device Authentication</h4>
                            <a href="#tabAddAuth" data-toggle="tab" class="btn btn-default pull-right" style="margin: 10px 0px 0px 0px"><i class="fa fa-plus"></i> Add Device Auth</a>
                            <hr>
                            <table id="tb_deviceAuth" class="table about-table " cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Port</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tabAddAuth">
                            <form id="formAuth" action="＃" method="post" class="form-horizontal row-border">
                                <input type="hidden" value="" name="id"/> 
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Username</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="userAuth" class="form-control" placeholder='Username'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="passwordAuth" class="form-control" placeholder='Password' required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Port</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="port" class="form-control" placeholder='Port' required>
                                    </div>
                                </div>
                            </form>
                            <a type="submit" id="btnSave" onClick="save()" class="btn btn-success pull-right" style="margin: 10px 0px 0px 0px">Save</a>
                        </div>
                        <div class="tab-pane" id="tabConfig">
                            <h4>Template Router MikroTik Configuration</h4>
                            <hr>
                            <table id="tb_config" class="table about-table " cellspacing="0" width="100%"  style="font-size:11px">
                                <thead>
                                    <tr>
                                        <!-- <th>Id</th> -->
                                        <th>Comment</th>
                                        <th>Script</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <a href="#tabAddConfig" data-toggle="tab" class="btn btn-default" style="margin: 10px 0px 0px 0px"><i class="fa fa-plus"></i> Add Template Config</a>
                        </div>
                        <div class="tab-pane" id="tabAddConfig">
                            <form id="formConfig" action="＃" method="post" class="form-horizontal row-border">
                                <input type="hidden" value="" name="id"/> 
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Comment</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="comment" class="form-control" placeholder='Comment'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Script</label>
                                    <div class="col-sm-8">
                                        <textarea type="input" name="script" class="form-control" placeholder='Input script here..' required></textarea>
                                    </div>
                                </div>
                            </form>
                            <a type="submit" id="btnSave" onClick="save()" class="btn btn-success pull-right" style="margin: 10px 0px 0px 0px">Save</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="demo-options">
        <div class="demo-options-icon"><i class="ti ti-paint-bucket"></i></div>
        <div class="demo-heading">Settings</div>

        <div class="demo-body">
            <div class="tabular">
                <div class="tabular-row">
                    <div class="tabular-cell">Collapse Leftbar</div>
                    <div class="tabular-cell demo-switches"><input class="bootstrap-switch" type="checkbox" data-size="mini" data-on-color="success" data-off-color="default" name="demo-collapseleftbar" data-on-text="&nbsp;" data-off-text="&nbsp;"></div>
                </div>
            </div>
        </div>

        <div class="demo-body">
            <div class="option-title">Topnav</div>
            <ul id="demo-header-color" class="demo-color-list">
                <li><span class="demo-cyan"></span></li>
                <li><span class="demo-light-blue"></span></li>
                <li><span class="demo-blue"></span></li>
                <li><span class="demo-indigo"></span></li>
                <li><span class="demo-deep-purple"></span></li> 
                <li><span class="demo-purple"></span></li> 
                <li><span class="demo-pink"></span></li> 
                <li><span class="demo-red"></span></li>
                <li><span class="demo-teal"></span></li>
                <li><span class="demo-green"></span></li>
                <li><span class="demo-light-green"></span></li>
                <li><span class="demo-lime"></span></li>
                <li><span class="demo-yellow"></span></li>
                <li><span class="demo-amber"></span></li>
                <li><span class="demo-orange"></span></li>               
                <li><span class="demo-deep-orange"></span></li>
                <li><span class="demo-midnightblue"></span></li>
                <li><span class="demo-bluegray"></span></li>
                <li><span class="demo-bluegraylight"></span></li>
                <li><span class="demo-black"></span></li> 
                <li><span class="demo-gray"></span></li> 
                <li><span class="demo-graylight"></span></li> 
                <li><span class="demo-default"></span></li>
                <li><span class="demo-brown"></span></li>
            </ul>
        </div>

        <div class="demo-body">
            <div class="option-title">Sidebar</div>
            <ul id="demo-sidebar-color" class="demo-color-list">
                <li><span class="demo-cyan"></span></li>
                <li><span class="demo-light-blue"></span></li>
                <li><span class="demo-blue"></span></li>
                <li><span class="demo-indigo"></span></li>
                <li><span class="demo-deep-purple"></span></li> 
                <li><span class="demo-purple"></span></li> 
                <li><span class="demo-pink"></span></li> 
                <li><span class="demo-red"></span></li>
                <li><span class="demo-teal"></span></li>
                <li><span class="demo-green"></span></li>
                <li><span class="demo-light-green"></span></li>
                <li><span class="demo-lime"></span></li>
                <li><span class="demo-yellow"></span></li>
                <li><span class="demo-amber"></span></li>
                <li><span class="demo-orange"></span></li>               
                <li><span class="demo-deep-orange"></span></li>
                <li><span class="demo-midnightblue"></span></li>
                <li><span class="demo-bluegray"></span></li>
                <li><span class="demo-bluegraylight"></span></li>
                <li><span class="demo-black"></span></li> 
                <li><span class="demo-gray"></span></li> 
                <li><span class="demo-graylight"></span></li> 
                <li><span class="demo-default"></span></li>
                <li><span class="demo-brown"></span></li>
            </ul>
        </div>
    </div>


<!-- Load site level scripts -->

<script type="text/javascript" src="<?php echo base_url('') ?>assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
<script type="text/javascript" src="<?php echo base_url('') ?>assets/js/jqueryui-1.10.3.min.js"></script> 							<!-- Load jQueryUI -->
<script type="text/javascript" src="<?php echo base_url('') ?>assets/js/bootstrap.min.js"></script> 								<!-- Load Bootstrap -->
<script type="text/javascript" src="<?php echo base_url('') ?>assets/js/enquire.min.js"></script> 									

<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/velocityjs/velocity.min.js"></script>					
<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/velocityjs/velocity.ui.min.js"></script>

<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/wijets/wijets.js"></script>     						

<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/codeprettifier/prettify.js"></script> 				
<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/bootstrap-switch/bootstrap-switch.js"></script> 		

<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  

<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/iCheck/icheck.min.js"></script>   

<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script>

<script type="text/javascript" src="<?php echo base_url('') ?>assets/js/application.js"></script>
<script type="text/javascript" src="<?php echo base_url('') ?>assets/js/bootbox.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url('') ?>assets/demo/demo.js"></script> -->
<script type="text/javascript" src="<?php echo base_url('') ?>assets/demo/demo-switcher.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/form-daterangepicker/moment.min.js"></script>              			

<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js"></script> 			
<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>      			
<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>      			 -->

<!-- <script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/clockface/js/clockface.js"></script>     								Clockface -->
<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/pines-notify/pnotify.min.js"></script> 		<!-- PNotify -->


<!-- <script type="text/javascript" src="<?php echo base_url('') ?>assets/demo/demo-pickers.js"></script> -->
<!-- End loading site level scripts -->
    
<!-- Load page level scripts -->
<!-- <script type="text/javascript" src="<?php echo base_url('') ?>assets/demo/demo-datatables.js"></script> -->
<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/progress-skylo/skylo.js"></script>

<script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.4/js/responsive.bootstrap.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/form-daterangepicker/moment.min.js"></script>              			<!-- Moment.js for Date Range Picker -->
<script type="text/javascript" src="<?php echo base_url('') ?>assets/plugins/form-daterangepicker/daterangepicker.js"></script>     				<!-- Date Range Picker -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://code.highcharts.com/modules/variable-pie.js"></script>
<script>
    getNotification();
    
    tableLog = $('#tb_simonetlog').DataTable({
        responsive : true,
        pageLength : 100,
        lengthChange: false,
        scrollY: "250px",
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

    $('#searchLog').keyup(function(){
        tableLog.search($(this).val()).draw() ;
    })

    $('body').on('click','a[data-aksi="notif"]',function(){
        readNotification();
    })

    $('body').on('click','a[data-aksi="clearNotif"]',function(){
        clearNotification();
    })

    $('body').on('click','button[data-aksi="allLog"]',function(){
        tableLog.search('').draw();
    });

    $('body').on('click','button[data-aksi="main"]',function(){
        tableLog.search('10.10.10.1').draw();   
    });
    
    $('body').on('click','button[data-aksi="simonet"]',function(){
        tableLog.search('SIMONETapp').draw();
    });

    $('body').on('click','a[data-aksi="log"]',function(){
        log();
    })

    $('body').on('click','a[data-aksi="refreshLog"]',function(){
        reload_tableLog();
    })

    $('body').on('click','a[data-aksi="settings"]',function(){
        settings();
    })

    $('body').on('click','a[data-aksi="#tabAddAdmin"]',function(){
        save_methodAdmin = 'add';
        $('[name="userAdmin"]').val('');
        $('[name="passwordAdmin"]').val('');
        $('[name="emailAdmin"]').val('');
        $('[name="roleAdmin"]').val('');
        $('[name="statusAdmin"]').val('');
    })

    $('body').on('click','a[data-aksi="#tabAddAuth"]',function(){
        $('[name="userAuth"]').val('');
        $('[name="passwordAuth"]').val('');
        $('[name="portAuth"]').val('');
    })

    $('body').on('click','a[data-aksi="#tabAddConfig"]',function(){
        $('[name="comment"]').val('');
        $('[name="script"]').val('');
    })

    $('body').on('click','a[data-aksi="editAdmin"]',function(){
        var id= $(this).attr('data-id');
        editAdmin(id);
    })

    $('body').on('click','a[data-aksi="saveAdmin"]',function(){
        saveAdmin();
        $('#tabAdmin').tab('show');
    })

    $('body').on('click','a[data-aksi="hapusAdmin"]',function(){
        var id= $(this).attr('data-id');
        deleteAdmin(id);
    });

    $('body').on('click','a[data-aksi="editAuth"]',function(){
        var id= $(this).attr('data-id');
        // editProfile(id);
    })

    $('body').on('click','a[data-aksi="hapusAuth"]',function(){
        var id= $(this).attr('data-id');
        // deleteUser(id);
    });

    $('body').on('click','a[data-aksi="editConfig"]',function(){
        var id= $(this).attr('data-id');
        // editProfile(id);
    })

    $('body').on('click','a[data-aksi="hapusConfig"]',function(){
        var id= $(this).attr('data-id');
        // deleteUser(id);
    });
    

    function log(){
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_log').modal('show');
        tableLog.search('.').draw();
    }

    function settings(){
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_settings').modal('show');
        getadmins();
        getDeviceAuth();
        getTemplateConfig();
    }

    function getNotification(){
        var url = "<?php echo site_url('dashboard/getNotification')?>";

        $.ajax({
            url : url,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                if(data.status)
                {
                    $('#notif li').remove();
                    $('#btnnotif span').remove();
                    var liHTML = '';
                    var unreadCount = 0;
                    $.each(data.data, function (i, item) {
                        if(item.read == '0'){
                            unreadCount++;
                            if(item.tag == 'devices,device-up,simonet'){
                                liHTML += '<li class="media notification-success" style="background-color:#e3dfc8;"><a href="#"><div class="media-left"><span class="notification-icon"><i class="ti ti-harddrive"></i></span></div><div class="media-body"><h4 class="notification-heading">'+ item.event +'</h4><span class="notification-time">'+ item.time +'</span></div></a></li>';
                                // new PNotify({
                                //     title: 'Device Up',
                                //     text: item.event,
                                //     type: 'success',
                                //     icon: 'ti ti-check',
                                //     styling: 'fontawesome'
                                // });
                            }else if(item.tag == 'devices,device-down,simonet'){
                                liHTML += '<li class="media notification-danger" style="background-color: #e3dfc8;"><a href="#"><div class="media-left"><span class="notification-icon"><i class="ti ti-harddrive"></i></span></div><div class="media-body"><h4 class="notification-heading">'+ item.event +'</h4><span class="notification-time">'+ item.time +'</span></div></a></li>';
                                // new PNotify({
                                //     title: 'Device Down',
                                //     text: item.event,
                                //     type: 'error',
                                //     icon: 'ti ti-check',
                                //     styling: 'fontawesome'
                                // });
                            }else if(item.tag == 'devices,device-reboot,simonet'){
                                liHTML += '<li class="media notification-warning" style="background-color: #e3dfc8;"><a href="#"><div class="media-left"><span class="notification-icon"><i class="ti ti-harddrive"></i></span></div><div class="media-body"><h4 class="notification-heading">'+ item.event +'</h4><span class="notification-time">'+ item.time +'</span></div></a></li>';
                                // new PNotify({
                                //     title: 'Device Rebooted',
                                //     text: item.event,
                                //     type: 'warning',
                                //     icon: 'ti ti-check',
                                //     styling: 'fontawesome'
                                // });
                            }else{
                                liHTML += '<li class="media notification-info" style="background-color: #e3dfc8;"><a href="#"><div class="media-left"><span class="notification-icon"><i class="ti ti-info"></i></span></div><div class="media-body"><h4 class="notification-heading">'+ item.event +'</h4><span class="notification-time">'+ item.time +'</span></div></a></li>';
                                // new PNotify({
                                //     title: 'Info',
                                //     text: item.event,
                                //     type: 'info',
                                //     icon: 'ti ti-check',
                                //     styling: 'fontawesome'
                                // });
                            }
                        }else{
                            if(item.tag == 'devices,device-up,simonet'){
                                liHTML += '<li class="media notification-success"><a href="#"><div class="media-left"><span class="notification-icon"><i class="ti ti-harddrive"></i></span></div><div class="media-body"><h4 class="notification-heading">'+ item.event +'</h4><span class="notification-time">'+ item.time +'</span></div></a></li>';
                            }else if(item.tag == 'devices,device-reboot,simonet'){
                                liHTML += '<li class="media notification-warning"><a href="#"><div class="media-left"><span class="notification-icon"><i class="ti ti-harddrive"></i></span></div><div class="media-body"><h4 class="notification-heading">'+ item.event +'</h4><span class="notification-time">'+ item.time +'</span></div></a></li>';
                            }else if(item.tag == 'devices,device-down,simonet'){
                                liHTML += '<li class="media notification-danger"><a href="#"><div class="media-left"><span class="notification-icon"><i class="ti ti-harddrive"></i></span></div><div class="media-body"><h4 class="notification-heading">'+ item.event +'</h4><span class="notification-time">'+ item.time +'</span></div></a></li>';
                            }else{
                                liHTML += '<li class="media notification-info"><a href="#"><div class="media-left"><span class="notification-icon"><i class="ti ti-info"></i></span></div><div class="media-body"><h4 class="notification-heading">'+ item.event +'</h4><span class="notification-time">'+ item.time +'</span></div></a></li>';
                            }
                        }
                    });
                    if(unreadCount== 0){
                        $('#btnnotif').append('<span class="icon-bg"><i class="ti ti-bell"></i></span>');
                    }else{
                        $('#btnnotif').append('<span class="icon-bg"><i class="ti ti-bell"></i></span><span class="badge badge-deeporange">'+unreadCount+'</span>');
                    }
                    $('#notif').append(liHTML);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log("Error getAdmins");
            }
        });
        setTimeout(function(){ getNotification(); }, 30000);
    }

    function readNotification(){
        $.post('<?php echo site_url('dashboard/readnotification/') ?>',function(respon){
            if(respon.status){
                getNotification();
            }
        },'json').fail(function(){
            alert('error read notif');
        })
    }

    function clearNotification(){
        $.post('<?php echo site_url('dashboard/clearnotification/') ?>',function(respon){
            if(respon.status){
                getNotification();
            }
        },'json').fail(function(){
            alert('error clear notif');
        })
    }

    function getadmins(){
        var url = "<?php echo site_url('dashboard/getAdmins')?>";

        $.ajax({
            url : url,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                if(data.status) 
                {
                    $('#tb_admins tr td').remove();
                    var trHTML = '';
                    $.each(data.data, function (i, item) {
                    trHTML += '<tr><td>' + item.username + '</td><td>' + item.email + '</td><td>' + item.role + '</td><td>' + item.aksi + '</td></tr>';
                    });
                    $('#tb_admins').append(trHTML);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log("Error getAdmins");
            }
        });
    }

    function getDeviceAuth(){
        var url = "<?php echo site_url('dashboard/getDeviceAuth')?>";

        $.ajax({
            url : url,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                if(data.status) 
                {
                    var trHTML = '';
                    $.each(data.data, function (i, item) {
                            trHTML += '<tr><td>' + item.id + '</td><td>' + item.username + '</td><td>' + item.password + '</td><td>' + item.port + '</td><td>' + item.aksi + '</td></tr>';
                    });
                    $('#tb_deviceAuth').append(trHTML);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log("Error getResource");
            }
        });
    }
    function getTemplateConfig(){
        var url = "<?php echo site_url('dashboard/getTemplateConfig')?>";

        $.ajax({
            url : url,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                if(data.status) 
                {
                    $('#tb_config tr td').remove();
                    var trHTML = '';
                    $.each(data.data, function (i, item) {
                            trHTML += '<tr><td>' + item.comment + '</td><td>' + item.script + '</td><td>' + item.aksi + '</td></tr>';
                    });
                    $('#tb_config').append(trHTML);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log("Error getResource");
            }
        });
    }

    
    function editAdmin(id){
        save_methodAdmin = 'update';
        var data = {id : id};

        $.post('<?php echo site_url('dashboard/getAdminByID/') ?>',data,function(respon){
            if(respon.status){
                $('[name="idAdmin"]').val(respon.data.id);
                $('[name="userAdmin"]').val(respon.data.username);
                $('[name="passwordAdmin"]').val('');
                $('[name="emailAdmin"]').val(respon.data.email);
                $('[name="roleAdmin"]').val(respon.data.role);
            }
            else{ alert('error get data'+id);
            }
        },'json').fail(function(){
            alert('error get data form ajax');
        })
    }

    function saveAdmin(){
        $('#btnSaveAdmin').text('saving...'); //change button text
        $('#btnSaveAdmin').attr('disabled',true); //set button disable 
        var url;
    
        if(save_methodAdmin == 'add') {
            url = "<?php echo site_url('dashboard/addAdmin')?>";
        } else {
            url = "<?php echo site_url('dashboard/setAdmin')?>";
        }

        $.ajax({
            url : url,
            type: "POST",
            data: $('#formAdmin').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                if(data.status) 
                {
                    getadmins();
                    $('.tab-container').find('.tab-pane').removeClass('active');
                    $('.tab-container').find('#tabAdmin').addClass('active');
                }
                $('#btnSaveAdmin').text('save'); 
                $('#btnSaveAdmin').attr('disabled',false); 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Gagal menyimpan user profile');
                $('#btnSaveAdmin').text('save'); 
                $('#btnSaveAdmin').attr('disabled',false); 
            }
        });
    }


    function deleteAdmin(id){
        var data = {id : id};
        if(confirm('Anda yakin ingin menghapus data ini ?')){
            $.post('<?php echo site_url('dashboard/delAdmin/') ?>',data,function(respon){
                if(respon.status){
                    getadmins();
                }
                else{ alert('error delete this data '+id);
                }
            },'json').fail(function(){
                alert('error delete this data');
            })
        }
    }

    function reload_tableLog(){
        tableLog.ajax.reload(null,false);
    }

    
// $('#logPopover').on('click').popover('show');
</script>