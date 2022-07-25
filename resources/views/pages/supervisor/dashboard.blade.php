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


            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card card-dark card-outline">
                        <div class="card-header bg-white">
                            <h3 class="card-title mb-0">Tool Request Report</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('supervisor.tool.export') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-12 col-lg-4">
                                        <label for="tool-request-report-since">Since</label>
                                        <input type="date"
                                                class="form-control @error('tool-request-report-since') is-invalid @enderror"
                                                name="tool-request-report-since" id="tool-request-report-since"
                                                placeholder="Since"
                                                value="{{ old('tool-request-report-since', date('Y-m-d')) }}" required>
                                        <span class="error invalid-feedback">{{ $errors->first('tool-request-report-since') }}</span>
                                    </div>
                                    <div class="form-group col-12 col-lg-4">
                                        <label for="tool-request-report-until">Until</label>
                                        <input type="date"
                                        class="form-control @error('tool-request-report-until') is-invalid @enderror"
                                        name="tool-request-report-until" id="tool-request-report-until"
                                        placeholder="Until"
                                        value="{{ old('tool-request-report-until', date('Y-m-d')) }}" required>
                                        <span class="error invalid-feedback">{{ $errors->first('tool-request-report-until') }}</span>
                                    </div>
                                    <div class="form-group col-12 col-lg-4">
                                        <label for="" class="d-block"></label>
                                        <button type="submit" class="btn bg-navy mt-4 px-5">Export</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card card-dark card-outline">
                        <div class="card-header bg-white">
                            <h3 class="card-title mb-0">Consumable Request Report</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('supervisor.consumable.export') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-12 col-lg-4">
                                        <label for="consumable-request-report-since">Since</label>
                                        <input type="date"
                                                class="form-control @error('consumable-request-report-since') is-invalid @enderror"
                                                name="consumable-request-report-since" id="consumable-request-report-since"
                                                placeholder="Since"
                                                value="{{ old('consumable-request-report-since', date('Y-m-d')) }}" required>
                                        <span class="error invalid-feedback">{{ $errors->first('consumable-request-report-since') }}</span>
                                    </div>
                                    <div class="form-group col-12 col-lg-4">
                                        <label for="consumable-request-report-until">Until</label>
                                        <input type="date"
                                        class="form-control @error('consumable-request-report-until') is-invalid @enderror"
                                        name="consumable-request-report-until" id="consumable-request-report-until"
                                        placeholder="Until"
                                        value="{{ old('consumable-request-report-until', date('Y-m-d')) }}" required>
                                        <span class="error invalid-feedback">{{ $errors->first('consumable-request-report-until') }}</span>
                                    </div>
                                    <div class="form-group col-12 col-lg-4">
                                        <label for="" class="d-block"></label>
                                        <button type="submit" class="btn bg-navy mt-4 px-5">Export</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
