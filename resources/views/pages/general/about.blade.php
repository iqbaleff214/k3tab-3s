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
                        <a href="{{ $guide }}" class="btn btn-outline-dark" download="Guid Book">Guide Book Download</a>
                    </div>
                    <iframe src="{{ $guide }}" width="100%" height="500px">
                    {{-- <object data="{{ $guide }}"
                                width="800"
                                height="500">
                        </object> --}}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
