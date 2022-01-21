@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="row">
        <div class="col-md-4">
            <h5>Todo List</h5>
        </div>
        <div class="col-md-8 text-right">
            <div class="pull-right">
                <a href="{{url('/todo/create')}}" class="btn btn-success">New Todo <i class="fa fa-fw fa-plus"></i></a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-body">
                    <table id="data-table" class="table table-bordered table-hover dataTable dtr-inline">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Notification Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            $(document).ready(function () {
                $('#example').DataTable();
                $('.sidebar-toggle').click();
            });
            $("#filter-button").on('click', function () {
                $("#filter-box").slideToggle(300);
            });
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                order: [[0, "desc"]],
                lengthMenu: [[50, 100, 500, -1], [50, 100, 500, "All"]],
                mark: true,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'date', name: 'date'},
                    {data: 'time', name: 'time'},
                    {data: 'sending_status', name: 'sending_status'},

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        'className': 'datatable-action'
                    }
                ],
                ajax: {
                    url: '{{ url($url . "/data") }}',
                    data: function (d) {
                        $(".form-filter").serializeArray().map(function (x) {
                            d[x.name] = x.value;
                        });
                    }
                }
            });

            // delete resource script
            table.on('click', '.button-delete', function (e) {
                e.preventDefault();
                var token = $("meta[name=csrf-token]").attr("content");
                var method = 'DELETE';
                var url = $(this).attr('href');
                // show dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This operation can't be undone",
                    type: 'warning',
                    showCancelButton: true,
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function () {
                    $.ajax(
                        {
                            url: url,
                            type: 'DELETE',
                            dataType: "JSON",
                            data: {
                                "_method": 'DELETE',
                                "_token": token
                            },
                            success: function (data) {
                                if (data.status === 'success') {
                                    toastr.success('Deleted!', 'Success');
                                    table.ajax.reload();
                                } else if (data.status === 'warning') {
                                    toastr.error('Delete Failed!', 'warning');
                                } else {
                                    toastr.error('Something went wrong', 'Error!');
                                }
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                toastr.error('Something went wrong', 'Error!');
                            }
                        });
                });
            });
        });


    </script>
@stop
