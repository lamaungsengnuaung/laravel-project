@extends('user.layouts.master')
@section('content')
    <h2 class="text-center" id="title">
        HOME PAGE</h2>
    <!-- Breadcrumb Start -->
    {{-- <div class="container-fluid mb-5">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shop List</span>
                </nav>
            </div>
        </div>
    </div> --}}
    <!-- Breadcrumb End -->
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Category Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-light pr-3">Filter by
                        Category</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>

                        <div class="btn btn-danger d-flex align-items-center justify-content-between mb-3">
                            <label class="mt-2 " for="price-all">Categories</label>
                            <span class="badge-primary  rounded-pill px-2">{{ count($category) }} </span>
                        </div>
                        <div class=" d-flex align-items-center justify-content-between mb-3">
                            <a href="{{ route('user#home') }} ">
                                <label class="mt-2 text-muted" for="price-all">All category</label></a>
                        </div>

                        @foreach ($category as $c)
                            <div class=" d-flex align-items-center justify-content-between mb-3 " id="categoryName">

                                <a href="{{ route('user#filter', $c->id) }} ">
                                    <label class="mt-2 text-muted" for="price-all">{{ Str::title($c->name) }}</label></a>

                            </div>
                        @endforeach

                    </form>
                </div>
                <!-- Category End -->

                <div class="">
                    <button class="btn btn btn-warning w-100">Order</button>
                </div>
            </div>
            <!-- Shop Sidebar End -->
            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="{{ route('user#cart') }} " class=" text-decoration-none mr-3">
                                    <button type="button" class="btn btn-dark btn-lg position-relative">
                                        <i class="fa fa-cart-plus text-warning" aria-hidden="true"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                            {{ count($cartCount) }}
                                        </span>
                                    </button>
                                </a>
                                <a href="{{ route('user#history') }} " class=" text-decoration-none ">
                                    <button type="button" class="btn btn-dark btn-lg position-relative">
                                        <i class="fa-solid fa-clock-rotate-left text-white"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                                            {{ count($orderCount) }}
                                        </span>
                                    </button>
                                </a>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <select name="sorting" id="sortingOption" class="p-1 border-0">
                                        <option value="">Sorting Title </option>
                                        <option value="atoz">A-to-Z</option>
                                        <option value="ztoa">Z-to-A</option>
                                    </select>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row" id="datalist" style="max-height: 850px; overflow:auto; overflow-x:hidden;">
                        @if (count($product))
                            @foreach ($product as $p)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <a href="{{ route('pizza#detail', $p->id) }} " class="text-decoration-none">
                                        <div class="product-item bg--gray mb-4 card shadow position-relative">
                                            <div class="product-img position-relative overflow-hidden">
                                                <img class="img-fluid w-100 " style="height: 25em"
                                                    src="{{ asset('storage/' . $p->image) }} " alt="">
                                            </div>
                                            <div class="text-center py-4 card-body">
                                                <div class="text-capitalize text-decoration-none h3 text-truncate"
                                                    href="">
                                                    {{ Str::title($p->name) }}
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <h5>{{ $p->price }} Ks</h5>
                                                    {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <small class="fa fa-star text-warning mr-1"></small>
                                                    <small class="fa fa-star text-warning mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                </div>
                                                <div class="position-relative me-5 mt-1">
                                                    <div
                                                        class="product-action position-absolute top-100 start-100 translate-middle d-flex me-2">
                                                        <a class="btn btn-outline-dark "
                                                            href="{{ route('user#cart') }} "><i
                                                                class="fa fa-shopping-cart"></i></a>
                                                        <a class="btn btn-outline-dark "
                                                            href="{{ route('pizza#detail', $p->id) }}"><i
                                                                class="fa-solid fa-heart"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <h3 class="text-center shadow p-3"> Product is Sold Out !</h3>
                            {{-- {{ dd('end') }} --}}
                        @endif
                    </div>

                    {{-- @if (count($product) > 2)
                        <div class="bg-danger">
                            {{ $product->links() }}
                        </div>
                    @endif --}}
                </div>
            </div>
            <!-- Shop Product End -->

        </div>
    </div>
    <!-- Shop End -->
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            $("#sortingOption").change(function() {
                $eventOpt = $('#sortingOption').val();
                if ($eventOpt == 'atoz') {
                    $.ajax({
                        type: 'get',
                        url: '/user/ajax/pizzaList',
                        data: {
                            'status': 'A to Z ascending',
                            'message': 'this is testing message',
                        },
                        dataType: 'json',
                        success: function(response) {
                            // logger($response);
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {

                                $list += `  <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg--gray mb-4 card shadow position-relative">
                                            <div class="product-img position-relative overflow-hidden">
                                                <img class="img-fluid w-100 " style="height: 25em"
                                                    src="{{ asset('storage/${response[$i].image}') }} " alt="">
                                            </div>
                                            <div class="text-center py-4 card-body">
                                                <div class="text-capitalize text-decoration-none h3 text-truncate"
                                                    href="">
                                                            ${response[$i].name}
                                                    </div>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <h5>${response[$i].price}Ks ${response[$i].id}</h5>
                                                    {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <small class="fa fa-star text-warning mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                </div>
                                                <div class="position-relative me-5 mt-1">
                                                    <div
                                                        class="product-action position-absolute top-100 start-100 translate-middle d-flex me-2">
                                                        <a class="btn btn-outline-dark "
                                                            href="{{ route('user#cart') }} "><i
                                                                class="fa fa-shopping-cart"></i></a>
                                                        <a class="btn btn-outline-dark " ><i
                                                                class="fa-solid fa-heart"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                              </div>
                              `;
                            }
                            $('#datalist').html($list);
                        }
                    })
                } else {
                    $.ajax({
                        type: 'get',
                        url: '/user/ajax/pizzaList',
                        data: {
                            'status': 'Z to A descending',
                            'message': 'this is testing message',
                        },
                        dataType: 'json',
                        success: function(response) {
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                $list += `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                     <div class="product-item bg--gray mb-4 card shadow position-relative">
                                            <div class="product-img position-relative overflow-hidden">
                                                <img class="img-fluid w-100 " style="height: 25em"
                                                    src="{{ asset('storage/${response[$i].image}') }} " alt="">
                                            </div>
                                            <div class="text-center py-4 card-body">
                                                <div class="text-capitalize text-decoration-none h3 text-truncate"
                                                    href="">
                                                            ${response[$i].name}
                                                    </div>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <h5>${response[$i].price}Ks</h5>
                                                    {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <small class="fa fa-star text-warning mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                </div>
                                                <div class="position-relative me-5 mt-1">
                                                    <div
                                                        class="product-action position-absolute top-100 start-100 translate-middle d-flex me-2">
                                                        <a class="btn btn-outline-dark "
                                                            href="{{ route('user#cart') }} "><i
                                                                class="fa fa-shopping-cart"></i></a>
                                                        <a class="btn btn-outline-dark " ><i
                                                                class="fa-solid fa-heart"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                              </div> `;
                            }
                            $('#datalist').html($list);

                        }
                    })
                }
            })
        })
    </script>
@endsection
