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
                                <th style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->equipment_number }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->system_status }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.tool.show', $item) }}" class="btn btn-sm btn-success">Show</a>
                                        <a href="{{ route('admin.tool.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('admin.tool.destroy', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" class="btn btn-sm btn-danger" onclick="event.preventDefault(); deleteConfirm(this)">Delete</a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
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
                {{--ajax: "{!! url()->current() !!}",--}}
                {{--processing: true,--}}
                {{--serverSide: true,--}}
                {{--columns: [--}}
                {{--]--}}
            });
        });
    </script>
@endpush
