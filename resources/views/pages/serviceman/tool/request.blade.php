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
                        <a href={{ route('serviceman.request.tool.index') }} type="button"
                           class="btn {{ !in_array(($_GET['status'] ?? 99), [0,1,2,3]) ? 'bg-navy' : 'btn-outline-dark' }}">All</a>
                        <a href="?status=0" type="button"
                           class="btn {{ ($_GET['status'] ?? 99) == 0 ? 'bg-navy' : 'btn-outline-dark' }}">
                            Requested
                        </a>
                        <a href="?status=1" type="button"
                           class="btn {{ ($_GET['status'] ?? 99) == 1 ? 'bg-navy' : 'btn-outline-dark' }}">Borrowed</a>
                        <a href="?status=2" type="button"
                           class="btn {{ ($_GET['status'] ?? 99) == 2 ? 'bg-navy' : 'btn-outline-dark' }}">Returned</a>
                        <a href="?status=3" type="button"
                           class="btn {{ ($_GET['status'] ?? 99) == 3 ? 'bg-navy' : 'btn-outline-dark' }}">Rejected</a>
                    </div>
                    <table id="datatable" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="text-center">
                            <th width="10px">No.</th>
                            <th>Request Date</th>
                            <th>Return Date</th>
                            <th>Tool</th>
                            <th>Status</th>
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
                ajax: {
                    url: "{!! url()->current() !!}",
                    data: function (data) {
                        data.status = "{{ $_GET['status'] ?? '-' }}";
                    }
                },
                processing: true,
                serverSide: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'requested_at', name: 'requested_at'},
                    {data: 'returned_at', name: 'returned_at'},
                    {data: 'tool', name: 'tool'},
                    {data: 'request_status', name: 'request_status', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush
