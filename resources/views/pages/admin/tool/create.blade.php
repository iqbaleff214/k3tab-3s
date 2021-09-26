@extends('layouts.app')

@section('body')
    <div class="content-wrapper p-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <a href="{{ route('admin.tool.index') }}" class="mr-2 text-decoration-none text-dark">
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
                    <div class="card card-navy collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Have an excel file?
                                <b data-card-widget="collapse" style="cursor: pointer">Import</b> it!
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none;">
                            <form action="{{ route('admin.tool.import') }}" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <ul>
                                            <li>Please download the template first.</li>
                                            <li>You can't delete the first row (heading) but you can delete the example row.</li>
                                            <li>Please fill in the fields in the file that you have downloaded.</li>
                                            <li>The green column means that it cannot be left blank.</li>
                                            <li>Save the file then upload it to the Upload File form below.</li>
                                        </ul>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <a href="{{ asset('templates/tools-template.xlsx') }}" class="btn btn-outline-dark btn-block" download>Download Template</a>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-12 col-md-8 col-lg-10">
                                        @csrf
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file"
                                                           class="custom-file-input @error('file') is-invalid @enderror"
                                                           name="file" id="file">
                                                    <label class="custom-file-label" for="file">Upload File</label>
                                                </div>
                                            </div>
                                            @error('file')
                                            <span class="text-danger text-sm">{{ $errors->first('file') }}</span>
                                            @enderror
                                            <div class="form-text text-gray font-weight-lighter text-xs">
                                                [Accept: Excel, Spreadsheet, XLS, XLSX, CSV, ODS] [Max size: 2048KB]
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-2">
                                        <button type="submit" class="btn bg-navy btn-block">Import</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-12 col-md-12 px-2">
                    <!-- Default box -->
                    <form action="{{ route('admin.tool.store') }}" method="POST">
                        @csrf
                        <div class="card card-dark card-outline">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($forms as $name => $type)
                                        <div class="form-group col-12 col-lg-6">
                                            <label
                                                for="{{ $name }}">{{ Str::title(str_replace('_', ' ', $name)) }}</label>
                                            <input type="{{ $type }}"
                                                   class="form-control @error($name) is-invalid @enderror"
                                                   name="{{ $name }}" id="{{ $name }}"
                                                   placeholder="{{ Str::title(str_replace('_', ' ', $name)) }}"
                                                   value="{{ old($name) }}" {{ $loop->first ? 'autofocus' : '' }}>
                                            <span class="error invalid-feedback">{{ $errors->first($name) }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="submit" class="btn bg-navy my-4 px-5">Save</button>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </form>
                    <!-- /.card -->
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
@endsection
