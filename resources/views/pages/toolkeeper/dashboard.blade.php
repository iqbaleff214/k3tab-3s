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
                    <div class="card card-dark card-outline">
                        <div class="card-header bg-white">
                            <h3 class="card-title mb-0">Tool Request Report</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('toolkeeper.request.tool.export') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-12 col-lg-4">
                                        <label for="tool-request-report-since">Since</label>
                                        <input type="date"
                                                class="form-control @error('tool-request-report-since') is-invalid @enderror"
                                                name="tool-request-report-since" id="tool-request-report-since"
                                                placeholder="Since"
                                                value="{{ old('tool-request-report-since', date('Y-m-d')) }}" required>
                                        <span class="error invalid-feedback">{{ $errors->first('tool-request-report-since') }}</span>
                                    </div>
                                    <div class="form-group col-12 col-lg-4">
                                        <label for="tool-request-report-until">Until</label>
                                        <input type="date"
                                        class="form-control @error('tool-request-report-until') is-invalid @enderror"
                                        name="tool-request-report-until" id="tool-request-report-until"
                                        placeholder="Until"
                                        value="{{ old('tool-request-report-until', date('Y-m-d')) }}" required>
                                        <span class="error invalid-feedback">{{ $errors->first('tool-request-report-until') }}</span>
                                    </div>
                                    <div class="form-group col-12 col-lg-4">
                                        <label for="" class="d-block"></label>
                                        <button type="submit" class="btn bg-navy mt-4 px-5">Export</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card card-dark card-outline">
                        <div class="card-header bg-white">
                            <h3 class="card-title mb-0">Consumable Request Report</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('toolkeeper.request.consumable.export') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-12 col-lg-4">
                                        <label for="consumable-request-report-since">Since</label>
                                        <input type="date"
                                                class="form-control @error('consumable-request-report-since') is-invalid @enderror"
                                                name="consumable-request-report-since" id="consumable-request-report-since"
                                                placeholder="Since"
                                                value="{{ old('consumable-request-report-since', date('Y-m-d')) }}" required>
                                        <span class="error invalid-feedback">{{ $errors->first('consumable-request-report-since') }}</span>
                                    </div>
                                    <div class="form-group col-12 col-lg-4">
                                        <label for="consumable-request-report-until">Until</label>
                                        <input type="date"
                                        class="form-control @error('consumable-request-report-until') is-invalid @enderror"
                                        name="consumable-request-report-until" id="consumable-request-report-until"
                                        placeholder="Until"
                                        value="{{ old('consumable-request-report-until', date('Y-m-d')) }}" required>
                                        <span class="error invalid-feedback">{{ $errors->first('consumable-request-report-until') }}</span>
                                    </div>
                                    <div class="form-group col-12 col-lg-4">
                                        <label for="" class="d-block"></label>
                                        <button type="submit" class="btn bg-navy mt-4 px-5">Export</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
