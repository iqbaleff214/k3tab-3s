@extends('layouts.app')

@section('body')
    <div class="content-wrapper p-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="mb-2">{{ $title }}</h1>
                    </div>
                </div>
                <form action="{{ url()->current() }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-3 mb-2">
                            <select name="status" class="form-control select2">
                                <option selected value="">All</option>
                                <option value="0" {{ isset($_GET['status']) ? ($_GET['status'] == 0 ? 'selected' : '') : '' }} >Not Ready</option>
                                <option value="1" {{ isset($_GET['status']) ? ($_GET['status'] == 1 ? 'selected' : '') : '' }} >Ready</option>
                                <option value="2" {{ isset($_GET['status']) ? ($_GET['status'] == 2 ? 'selected' : '') : '' }} >Already Requested</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-9">
                            <div class="input-group">
                                <input type="search" name="q" class="form-control"
                                       placeholder="Find the tool by it name or equipment number"
                                       value="{{ $_GET['q'] ?? '' }}" autofocus>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-dark">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Main content -->
        <div class="content">
            <div class="container mt-3">
                <div class="card-columns">
                </div>

                <!-- Data Loader -->
                <div class="auto-load text-center py-5">
                    <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink"
                         x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0"
                         xml:space="preserve">
                            <path fill="#000"
                                  d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                                                  from="0 50 50" to="360 50 50" repeatCount="indefinite"/>
                            </path>
                        </svg>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection

@push('script')
    <script>
        window.addEventListener('load', function () {
            var ENDPOINT = "{{ route('serviceman.tool.data') }}";
            var SEARCH = "{{ $_GET['q'] ?? '' }}";
            var STATUS = "{{ $_GET['status'] ?? '' }}";
            var page = 1;

            $(document).ready(function () {
                loadMore(page);
                window.addEventListener('scroll', () => {
                    const {scrollHeight, scrollTop, clientHeight} = document.documentElement;
                    if (scrollTop + clientHeight >= scrollHeight) {
                        page++;
                        loadMore(page);
                    }
                });
            });

            function loadMore(page) {
                let URL = ENDPOINT + "?page=" + page;
                if (SEARCH != "") URL += "&q=" + SEARCH;
                if (STATUS != "") URL += "&status=" + STATUS;
                $.ajax({
                    url: URL,
                    datatype: "html",
                    type: "get",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                }).done(function (response) {
                    let card = ``;
                    response.data.forEach(e => {
                        const STATUS = e.equipment_status == 1 ? `<span class="badge badge-success">Ready</span>` : `<span class="badge badge-danger">` + (e.equipment_status == 2 ? `Requested` : `Not Ready`) + `</span>`;
                        const REQUEST = e.equipment_status == 1 ?
                            `<form action="/serviceman/tool/` + e.id + `/order" method="POST" class="d-inline">@csrf<button type="button" class="btn btn-outline-dark btn-sm float-right" onclick="justConfirm(this)"> <i class="fas fa-cart-plus mr-2"></i> Request</button></form>`
                            : `<span class="float-right text-muted text-sm">` + e.equipment_note + `</span>`;
                        card += `
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="font-weight-bold"><a href="/serviceman/tool/` + e.id + `" style="cursor: pointer" class="text-dark text-decoration-none">` + e.description + `</a></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Number: ` + e.part_number + `</h6>
                                    <p class="card-text">` + (e.additional_description ?? '-') + `</p>
                                    ` + STATUS + `
                                    ` + REQUEST + `
                                </div>
                            </div>`;
                    });
                    if (response.data.length == 0) {
                        $('.auto-load').html("We don't have more data to display.");
                        return;
                    }
                    $('.auto-load').hide();
                    $(".card-columns").append(card);
                }).fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
            }
        });
    </script>
@endpush
