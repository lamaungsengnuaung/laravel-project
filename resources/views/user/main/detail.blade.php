@extends('user.layouts.master')

@section('content')
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">

        <div class="row px-xl-5">
            <i class="fa fa-arrow-circle-left h1 text-dark" aria-hidden="true" onclick="history.back()"></i>
            <div class="col-lg-5 mb-30">

                <div class="carousel-item active">
                    <img class="w-100 h-100" src="{{ asset('storage/' . $pizza->image) }}" alt="Image">
                </div>
            </div>

            {{-- {{ dd($pizza->id, Auth::user()->role) }} --}}
            <input type="hidden" id="userId" value="{{ Auth::user()->id }} ">
            <input type="hidden" id="pizzaId" value="{{ $pizza->id }} ">
            <div class="col-lg-6 h-auto mb-30 offset-1">
                <div class="h-100 bg-light p-30">
                    <h3 class="text-capitalize name">{{ $pizza->name }} </h3>
                    <div class="d-flex mb-3">
                        <div class="text-warning mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1 viewer">
                            {{ $pizza->view_count }}<i class="fa fa-eye ml-1" aria-hidden="true"></i>

                        </small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{ $pizza->price }} Ks</h3>
                    <p class="mb-4">{{ $pizza->description }}</p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-warning btn-minus" type="button" id="btnMinus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" id="orderCount" class="form-control bg-light border-0 text-center"
                                value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-warning btn-plus" type="button" id="btnPlus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-warning px-3" type="button" id="btnAddtoCart"><i
                                class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">


                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->
    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-white pr-3">You May
                Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ($product as $p)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" style="height: 25em" src="{{ asset('storage/' . $p->image) }}"
                                    alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square"
                                        href="{{ route('pizza#detail', $p->id) }} "><i class="fa fa-info"
                                            aria-hidden="true"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes
                                    Here</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $p->price }} Ks</h5>
                                    <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-warning mr-1"></small>
                                    <small class="fa fa-star text-warning mr-1"></small>
                                    <small class="fa fa-star text-warning mr-1"></small>
                                    <small class="fa fa-star text-warning mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {

            $.ajax({
                type: 'get',
                url: '/user/ajax/increase/viewCount',
                data: {
                    'id': $('#pizzaId').val(),
                    'status': 'true'
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    $('div .viewer').text(response.view_count);

                }
            });

            $('#btnMinus').click(function() {
                if ($('#orderCount').val() == 0) {
                    $('#btnAddtoCart').hide();
                }

            })
            $('#btnPlus').click(function() {
                $('#btnAddtoCart').show();
            })

            $('#btnAddtoCart').click(function() {
                $source = {
                    'userId': $('#userId').val(),
                    'pizzaId': $('#pizzaId').val(),
                    'count': $('#orderCount').val(),
                }
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/Cart',
                    data: $source,
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = "http://127.0.0.1:8000/user/homePage";
                    }

                })
            })
        })
    </script>
@endsection
