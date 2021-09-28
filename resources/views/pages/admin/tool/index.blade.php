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

            <!-- Default box -->
            <div class="card card-dark card-outline">
                <div class="card-body">
                    <div class="mb-4">
                        <a href="{{ route('admin.tool.create') }}" class="btn btn-outline-dark">Add Tool</a>
                    </div>
                    <table id="datatable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="text-center">
                                <th width="10px">No.</th>
                                <th>Equipment Number</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th style="width: 155px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection

@push('script')
    <script>
        window.addEventListener('load', function () {
            $('#datatable').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
                ajax: "{!! url()->current() !!}",
                processing: true,
                serverSide: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'equipment_number', name: 'equipment_number'},
                    {data: 'description', name: 'description'},
                    {data: 'equipment_status', name: 'equipment_status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush
