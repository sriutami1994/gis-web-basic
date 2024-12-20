@extends('layout.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3 class="my-3">GIS Interactive - Add and View Data</h3>
        </div>
    </div>

    <!-- Map Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Marker</h3>
                </div>
                <div class="card-body">
                    <!-- Add Marker -->
                    <form id="add-marker-form" action="{{ route('handson3.storeMarker') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Marker Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Latitude:</label>
                            <input type="text" name="latitude" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Longitude:</label>
                            <input type="text" name="longitude" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-default">Add Marker</button>
                    </form>
                    <hr>
                    <table class="table table-bordered table-striped" id="tb_marker">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Lat</th>
                                 <th>Long</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="data-table-body">
                            <!-- Dynamic rows will be added here via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Polygon</h3>
                </div>
                <div class="card-body">
                    <!-- Add Polygon -->
                    <form id="add-polygon-form" action="{{ route('handson3.storePolygon') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Polygon Coordinates (JSON):</label>
                            <textarea name="coordinates" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Add Polygon</button>
                    </form>
                    <hr>
                    <table class="table table-bordered table-striped" id="tb_polygon">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Coordinates</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="data-table-body">
                            <!-- Dynamic rows will be added here via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@section('script')
<script type="text/javascript">
    var token = '{{csrf_token()}}';
    var tb_marker = $('#tb_marker').dataTable( {
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax:{
                    url: '{{url("/listDataMarker")}}',
                    data:function(d){
                         }
                 },
            columns: [
                {data: 'no', name: 'no',width:"2%"},
                {data: 'name', name: 'name'},
                {data: 'latitude', name: 'latitude'},
                {data: 'longitude', name: 'longitude'},
                {data: 'action', name: 'id',orderable: true, searchable: true}
            ],
            rowCallback: function( row, data, iDisplayIndex ) {
                var api = this.api();
                var info = api.page.info();
                var page = info.page;
                var length = info.length;
                var index = (page * length + (iDisplayIndex +1));
                $('td:eq(0)', row).html(index);
            },
            stateSaveCallback: function(settings,data) {
                localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
            },
            stateLoadCallback: function(settings) {
                return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            },
            drawCallback: function( settings ) {
                var api = this.api();
            }
        });


    var tb_polygon = $('#tb_polygon').dataTable( {
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax:{
                    url: '{{url("/listDataPolygon")}}',
                    data:function(d){
                         }
                 },
            columns: [
                {data: 'no', name: 'no',width:"2%"},
                {data: 'coordinates', name: 'coordinates'},
                {data: 'action', name: 'id',orderable: true, searchable: true}
            ],
            rowCallback: function( row, data, iDisplayIndex ) {
                var api = this.api();
                var info = api.page.info();
                var page = info.page;
                var length = info.length;
                var index = (page * length + (iDisplayIndex +1));
                $('td:eq(0)', row).html(index);
            },
            stateSaveCallback: function(settings,data) {
                localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
            },
            stateLoadCallback: function(settings) {
                return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            },
            drawCallback: function( settings ) {
                var api = this.api();
            }
        });


    $(document).ready(function(){
    })

    function delete_satuan(id){
        swal({
            title: "Apakah anda yakin menghapus data ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                type: "DELETE",
                url: '{{url("satuan")}}/'+id,
                async:true,
                data: {
                    _token:token,
                    id:id
                },
                beforeSend: function(data){
                    // replace dengan fungsi loading
                },
                success:  function(data){
                    if(data==1){
                        swal("Deleted!", "Data satuan berhasil dihapus.", "success");
                    }else{
                        
                        swal("Failed!", "Gagal menghapus data satuan.", "error");
                    }
                },
                complete: function(data){
                    tb_satuan.fnDraw(false);
                },
                error: function(data) {
                    swal("Error!", "Ajax occured.", "error");
                }
            });
        });
    }

    function submit_valid(id){
        if($(".validated_form").valid()) {
            data = {};
            $("#form-edit").find("input[name], select").each(function (index, node) {
                data[node.name] = node.value;
                
            });

            $.ajax({
                type:"PUT",
                url : '{{url("satuan/")}}/'+id,
                dataType : "json",
                data : data,
                beforeSend: function(data){
                    // replace dengan fungsi loading
                },
                success:  function(data){
                    if(data.status ==1){
                        show_info("Data satuan berhasil disimpan!");
                        $('#modal-large').modal('toggle');
                    }else{
                        show_error("Gagal menyimpan data ini!");
                        return false;
                    }
                },
                complete: function(data){
                    // replace dengan fungsi mematikan loading
                    tb_satuan.fnDraw(false);
                },
                error: function(data) {
                    show_error("error ajax occured!");
                }

            })
        } else {
            return false;
        }
    }

    function edit_data(id){
        $.ajax({
            type: "GET",
            url: '{{url("satuan")}}/'+id+'/edit',
            async:true,
            data: {
                _token      : "{{csrf_token()}}",
            },
            beforeSend: function(data){
                // on_load();
                $('#modal-xl').find('.modal-xl').find(".modal-content").find(".modal-header").attr("class","modal-header bg-light-blue");
                $("#modal-xl .modal-title").html("Edit Data - Satuan");
                $('#modal-xl').modal("show");
                $('#modal-xl').find('.modal-body-content').html('');
                $("#modal-xl").find(".overlay").fadeIn("200");
            },
                success:  function(data){
                $('#modal-xl').find('.modal-body-content').html(data);
            },
                complete: function(data){
                $("#modal-xl").find(".overlay").fadeOut("200");
            },
                error: function(data) {
                alert("error ajax occured!");
            }

        });
    }
</script>
@endsection
