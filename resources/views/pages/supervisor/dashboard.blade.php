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
                <div class="col-12 col-sm-4">
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
                <div class="col-12 col-sm-4">
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

                <div class="col-12 col-sm-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Servicemen</span>
                            <span class="info-box-number">{{ $count['users'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

        </section>
        <!-- /.content -->
    </div>
@endsection

@push('script')
    <script>
        window.addEventListener('load', function () {

        });
    </script>
@endpush
