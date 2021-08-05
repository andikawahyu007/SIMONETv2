<?php $this->load->view('Templates/headersidebar_view'); ?>
</div>
    </div>
    <div class="static-content-wrapper">
        <div class="static-content">
            <div class="page-content">
                <!-- <ol class="breadcrumb">
                    <li><a href="index.html">Hotspot</a></li>
                    <li class="active"><a href="#">User Hotspot</a></li>
                </ol> -->
                <div class="container-fluid" style="margin-top: 10px">
                    <div data-widget-group="group1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h2>Data User Profile</h2>
                                        <div class="col-md-2 pull-right" style="margin:10px 0 0 0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-search"></i>
                                                </span>
                                                <input class="form-control" placeholder='Search..' type="text" id="searchProfileField">
                                            </div>
                                        </div>
                                        <div class="dt-buttonsbtn-group pull-right" id="button-table" role="group" aria-label="Basic example">
                                            <a type="button" class="btn btn-info" data-aksi="sync" href="javascript:;"><i class="fa fa-refresh"></i> Refresh</a>
                                            <a type="button" class="btn btn-success" data-aksi="add"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <table id="tb_profile" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Session-Timeout</th>
                                                    <th>Idle-Timeout</th>
                                                    <th>Shared User</th>
                                                    <th>Rate Limit</th>
                                                    <th>Action</th>
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
                        <!-- </div>  -->
                    <!-- </div> -->
                <footer role="contentinfo">
                    <div class="clearfix">
                        <ul class="list-unstyled list-inline pull-left">
                            <li><h6 style="margin: 0;">&copy; 2015 Avenxo</h6></li>
                        </ul>
                        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                    </div>
                </footer>

<div class="modal fade" id="modal_form" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-title">Add User Profile</h4>
            </div>
            <div class="modal-body form">
            <form id="form-profile" action="＃" method="post" class="form-horizontal row-border">
                <input type="hidden" value="" name="id"/> 
               
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-8">
                        <input type="input" name="name" class="form-control" placeholder='User Profile Name' required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Session Time-Out</label>
                    <div class="col-sm-8">
                        <select id="session" name="session" class="form-control">
                        <option value="1h">1 Jam</option>
                        <option value="6h">6 Jam</option>
                        <option value="1d">1 Hari</option>
                        <option value="3d">3 Hari</option>
                        <option value="7d">1 Minggu</option>
                        <option value="30d">1 Bulan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Idle Time-Out</label>
                    <div id="IdleTimeout" class="col-sm-8">
                        <select id="idle" name="idle" class="form-control">
                        <option value="10m">10 Menit</option>
                        <option value="30m">30 Menit</option>
                        <option value="1h">1 Jam</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Shared Users</label>
                    <div class="col-sm-8">
                        <input type="number" name="shared" class="form-control" placeholder='Jumlah User' required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Rate Limit (Mb)</label>
                    <div class="col-sm-8">
                        <input type="number" name="limit" class="form-control" placeholder='Limit Bandwidth' required>
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="btnSave" onClick="save()" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form_isp" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-title">Add User Profile</h4>
            </div>
            <div class="modal-body form">
            <form id="form-isp" action="＃" method="post" class="form-horizontal row-border">
                <input type="hidden" value="" name="id"/> 
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-8">
                        <input type="input" name="name" class="form-control" placeholder='User Profile Name' required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">ISP</label>
                    <div id="dataISP" class="col-sm-8">
                        <select id="isp" name="isp" class="form-control" required>
                        <option value="Indosat">Indosat</option>
                        <option value="iForte">iForte</option>
                        <option value="prov3">MNC 1</option>
                        <option value="prov4">MNC 2</option>
                        <option value="prov5">MNC 3</option>
                        </select>
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="btnSave" onClick="save()" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('Templates/footer_view'); ?>


<script type="text/javascript">
    table = $('#tb_profile').DataTable({
        responsive : true,
        oLanguage: {
        "sLengthMenu": " _MENU_ ",
        "sSearch": "Search..."
        },
        dom: 'BTrt<"bottom"ip><"clear">',
        buttons: [
            {
                className: "btn btn-success",
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 2, 3, 4, 5 ]
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default');
                }
            },
            {
                className: "btn btn-success",
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 2, 3, 4, 5 ]
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default');
                }
            },
            {
                className: "btn btn-success",
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5]
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default');
                }
            },
            {
                className: "btn btn-success",
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 2, 3, 4, 5 ]
                },
                init: function(api, node, config) {
                   $(node).removeClass('btn-default');
                }
            },
        ],
        ajax : {
            "url" : "<?php echo site_url('hotspot/userprofileJSON')?>",
            "type" : "POST"
            // "dataSrc" : ""
        },
        columns : [
            // {"data" : "id"},
            {"data" : "name"},
            {"data" : "session-timeout"},
            {"data" : "idle-timeout"},
            {"data" : "shared-users"},
            {"data" : "rate-limit"},
            {"data" : "aksi"}
        ],
    });
    table.buttons().container().appendTo($('#button-table'));

    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
    console.log(message);
    };
        
    $('#searchProfileField').keyup(function(){
        table.search($(this).val()).draw() ;
    })

    $('body').on('click','a[data-aksi="add"]',function(){
        addProfile();
    })

    $('body').on('click','a[data-aksi="edit"]',function(){
        var char= $(this).attr('data-id');
        var id = char.split('*');
        editProfile(id[1]);
    })

    $('body').on('click','a[data-aksi="pindah"]',function(){
        var char= $(this).attr('data-id');
        var id = char.split('*');
        pindahProfile(id[1]);
    })

    $('body').on('click','a[data-aksi="hapus"]',function(){
        var id= $(this).attr('data-id');
        deleteProfile(id);
    })

    $('body').on('click','a[data-aksi="sync"]',function(){
        syncProfile();
    });

    // $('table#tb_profile').on('click','tbody tr',function(){
    //     var username = $(this).find('td:eq(0)').html();
    //     var res = username.split("@",1);
    //     // location.href='<?php echo site_url('hotspot/userhotspotdetail')?>/'+res;
        
    //     // var id= $(this).attr('data-id');
    //     var url = '<?php echo site_url('hotspot/userhotspotdetail')?>';
    //     var form = $('<form action="' + url + '" method="post">' +
    //     '<input type="hidden" name="name" value="'+username+'" />' +
    //     '</form>');
    //     $('body').append(form);
    //     form.submit();
    // })

    function addProfile(){
        save_method= 'add';
        $('#form-profile')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Add User Profile');
    }

    function editProfile(id){
        save_method = 'update';
        var data = {id : id};
        $('#form-profile')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty(); 

        $.post('<?php echo site_url('hotspot/getUserProfileByID/') ?>',data,function(respon){
            if(respon){
                $('[name="id"]').val(respon.id);
                $('[name="name"]').val(respon.name);
                $('[name="session-timeout"]').val(null);
                $('[name="idle-timeout"]').val(null);
                $('[name="shared-users"]').val(null);
                $('[name="rate-limit"]').val(null);
                $('#modal_form').modal('show');
                $('.modal-title').text('Edit User Profile');
            }
            else{ alert('error delete this data');
            }
        },'json').fail(function(){
            alert('error get data form ajax');
        })
    }

    function pindahProfile(id){
        save_method = 'pindah';
        var data = {id : id};
        $('#form-isp')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty(); 

        $.post('<?php echo site_url('hotspot/getUserProfileByID/') ?>',data,function(respon){
            console.log(respon);
            if(respon){
                $('[name="id"]').val(respon.id);
                $('[name="name"]').val(respon.name);
                $('[name="isp"]').val(null);
                $('#modal_form_isp').modal('show');
                $('.modal-title').text('Edit Route User Profile');
            }
            else{ alert('error delete this data');
            }
        },'json').fail(function(){
            alert('error get data form ajax');
        })
    }

    function save(){
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var url;
    
        if(save_method == 'add') {
            url = "<?php echo site_url('hotspot/addUserProfile')?>";
        } else if (save_method == 'update') {
            url = "<?php echo site_url('hotspot/setUserProfile')?>";
        } else {
            url = "<?php echo site_url('hotspot/changeRoute')?>";
        }
        console.log($('#form-profile').serialize());
        console.log($('#form-isp').serialize());

        $.ajax({
            url : url,
            type: "POST",
            data: $('#form-profile').serialize(),
            data: $('#form-isp').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                if(data.status) 
                {
                    $('#modal_form').modal('hide');
                    $('#modal_form_isp').modal('hide');
                    syncProfile();
                    reload_table();
                    if(save_method == 'add') {
                        new PNotify({
                            title: 'Add Profile',
                            text: 'Menambahkan User Profile Berhasil',
                            type: 'success',
                            icon: 'ti ti-user',
                            styling: 'fontawesome'
                        });
                    } else if (save_method == 'update') {
                        new PNotify({
                            title: 'Edit Profile',
                            text: 'Merubah User Profile Berhasil',
                            type: 'success',
                            icon: 'ti ti-user',
                            styling: 'fontawesome'
                        });    
                    } else {
                        new PNotify({
                            title: 'Edit Route Profile',
                            text: 'Merubah Route Profile Berhasil',
                            type: 'success',
                            icon: 'ti ti-user',
                            styling: 'fontawesome'
                        });                            
                    }
                }
                $('#btnSave').text('save'); 
                $('#btnSave').attr('disabled',false); 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Gagal menyimpan user profile');
                $('#btnSave').text('save'); 
                $('#btnSave').attr('disabled',false); 
            }
        });
    }

    function syncProfile(){
        $.skylo('start');
        $.ajax({
            url: "<?php echo site_url('hotspot/syncUserProfile/') ?>",
            type: "POST",
            dataType: "JSON",
            success: function(data){
                new PNotify({
                    title: 'Sync Data User Profile',
                    text: 'Sync Data User Profile Berhasil',
                    type: 'success',
                    icon: 'ti ti-user',
                    styling: 'fontawesome'
                }); 
                reload_table();
                $.skylo('end');
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error!!');
            }
        })
        // reload_table();
        // $.skylo('end');
    }

    function deleteProfile(id){
        var data = {id : id};
        if(confirm('Anda yakin ingin menghapus data ini ?')){
            $.post('<?php echo site_url('hotspot/delUserProfile/') ?>',data,function(respon){
                if(respon.status){
                    syncProfile();
                    reload_table();
                    new PNotify({
                        title: 'Remove Profile',
                        text: 'Menghapus User Profile Berhasil',
                        type: 'warning',
                        icon: 'ti ti-user',
                        styling: 'fontawesome'
                    });
                }
                else{ alert('error delete this data 1');
                }
            },'json').fail(function(){
                alert('error delete this data 2');
            })
        }
    }

    function reload_table(){
        table.ajax.reload(null,false);
    }
</script>


</body>
</html>