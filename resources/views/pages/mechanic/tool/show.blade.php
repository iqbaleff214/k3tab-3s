@extends('layouts.app')

@section('body')
    <div class="content-wrapper p-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <a href="{{ route('mechanic.tool.index') }}" class="mr-2 text-decoration-none text-dark">
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
                <div class="col-12 col-md-12 px-2">
                    <!-- Default box -->
                    <div class="card card-dark card-outline">
                        <div class="card-body">
                            <div class="row">
                                @foreach($forms as $name => $type)
                                    <div class="form-group col-12 col-lg-6">
                                        <label
                                            for="{{ $name }}">{{ Str::title(str_replace('_', ' ', $name)) }}</label>
                                        <input type="{{ $type }}"
                                               class="form-control"
                                               name="{{ $name }}" id="{{ $name }}"
                                               placeholder="{{ Str::title(str_replace('_', ' ', $name)) }}"
                                               value="{{ old($name, $type == 'date' ? date('Y-m-d', strtotime($tool->$name)) : $tool->$name) }}"
                                               {{ $loop->first ? 'autofocus' : '' }} disabled>
                                    </div>
                                @endforeach
                            </div>
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
