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
                <div class="row">
                    <div class="col-12">
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="input-group mt-2">
                                <input type="search" name="q" class="form-control form-control-lg" placeholder="Find the tool by it name or equipment number" value="{{ $_GET['q'] ?? '' }}" autofocus>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-dark">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
            var ENDPOINT = "{{ route('mechanic.tool.data') }}";
            var SEARCH = "{{ $_GET['q'] ?? '' }}";
            var page = 1;
            
            $(document).ready(function() {
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
                if (SEARCH !== "") URL += "&q=" + SEARCH;
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
                        card += `
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">` + e.description + `</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">` + e.equipment_number + `</h6>
                                    <p class="card-text">` + e.additional_description + `</p>
                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
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
