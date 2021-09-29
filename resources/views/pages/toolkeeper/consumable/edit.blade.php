@extends('layouts.app')

@section('body')
    <div class="content-wrapper p-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <a href="{{ route('toolkeeper.consumable.index') }}" class="mr-2 text-decoration-none text-dark">
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
                    <form action="{{ route('toolkeeper.consumable.update', $consumable) }}" method="POST">
                        @method('PUT')
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
                                                   min="0"
                                                   name="{{ $name }}" id="{{ $name }}"
                                                   placeholder="{{ Str::title(str_replace('_', ' ', $name)) }}"
                                                   value="{{ old($name, $consumable->$name) }}" {{ $loop->first ? 'autofocus' : '' }}>
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
