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
                    <table id="datatable" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="text-center">
                            <th width="10px">No.</th>
                            <th>Request Date</th>
                            <th>Name</th>
                            <th>Consumable</th>
                            <th>Stock</th>
                            <th>Qty</th>
                            <th>Accepted</th>
                            <th style="width: 115px">Action</th>
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
                    {data: 'created_at', name: 'created_at'},
                    {data: 'mechanic', name: 'mechanic'},
                    {data: 'consumable', name: 'consumable'},
                    {data: 'stock', name: 'stock'},
                    {data: 'requested_quantity', name: 'requested_quantity'},
                    {data: 'accepted_quantity', name: 'accepted_quantity'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush
