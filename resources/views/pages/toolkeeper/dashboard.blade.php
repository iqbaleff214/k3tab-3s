@extends('layouts.app')

@section('body')
    <div class="content-wrapper p-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tools"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Tools</span>
                            <span class="info-box-number">{{ $count['tools'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-box-tissue"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Consumables</span>
                            <span class="info-box-number">{{ $count['consumables'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Requested Tools</span>
                            <span class="info-box-number">{{ $count['tool_request'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="far fa-file-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Req. Consumables</span>
                            <span class="info-box-number">{{ $count['consumable_request'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <!-- Default box -->
                    <div class="card card-dark card-outline">
                        <div class="card-header bg-white">
                            <h3 class="card-title mb-0">Today's Tool Request</h3>
                        </div>
                        <div class="card-body">
                            <table id="datatable-tool" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr class="text-center">
                                    <th width="10px">No.</th>
                                    <th>Name</th>
                                    <th>Tool</th>
                                    <th style="width: 55px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12 col-md-6">
                    <!-- Default box -->
                    <div class="card card-dark card-outline">
                        <div class="card-header bg-white">
                            <h3 class="card-title mb-0">Today's Consumable Request</h3>
                        </div>
                        <div class="card-body">
                            <table id="datatable-consumable" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr class="text-center">
                                    <th width="10px">No.</th>
                                    <th>Name</th>
                                    <th>Cons.</th>
                                    <th>Qty</th>
                                    <th style="width: 55px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
@endsection

@push('script')
    <script>
        window.addEventListener('load', function () {
            $('#datatable-tool').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
                ajax: {
                    url: "{!! url()->current() !!}",
                    data: function (data) {
                        data.status = "tool";
                    }
                },
                processing: true,
                serverSide: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'serviceman', name: 'serviceman'},
                    {data: 'tool', name: 'tool'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            $('#datatable-consumable').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
                ajax: {
                    url: "{!! url()->current() !!}",
                    data: function (data) {
                        data.status = "consumable";
                    }
                },
                processing: true,
                serverSide: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'serviceman', name: 'serviceman'},
                    {data: 'consumable', name: 'consumable'},
                    {data: 'requested_quantity', name: 'requested_quantity'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush
