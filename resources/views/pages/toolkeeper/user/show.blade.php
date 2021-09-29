@extends('layouts.app')

@section('body')
    <div class="content-wrapper p-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <a href="{{ url()->previous() }}" class="mr-2 text-decoration-none text-dark">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            {{ $title }}
                        </h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-12 col-md-6 px-2">
                    <!-- Default box -->
                    <div class="card card-dark card-outline">
                        <div class="card-body">
                            <div class="row">
                                @foreach($forms as $name => $type)
                                    <div class="form-group col-12 col-lg-12">
                                        <label
                                            for="{{ $name }}">{{ Str::title(str_replace('_', ' ', $name)) }}</label>
                                        <input type="{{ $type }}"
                                               class="form-control"
                                               name="{{ $name }}" id="{{ $name }}"
                                               placeholder="{{ Str::title(str_replace('_', ' ', $name)) }}"
                                               value="{{ old($name, $user->$name ?? '-') }}"
                                               {{ $loop->first ? 'autofocus' : '' }} disabled>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12 col-md-6">
                    <!-- Default box -->
                    <div class="card card-dark card-outline">
                        <div class="card-header bg-white">
                            <h3 class="card-title mb-0">Requested Tools</h3>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr class="text-center">
                                    <th width="10px">No.</th>
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
                </div>
            </div>

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
                    {data: 'tool', name: 'tool'},
                    {data: 'request_status', name: 'request_status'},
                ]
            });
        });
    </script>
@endpush
