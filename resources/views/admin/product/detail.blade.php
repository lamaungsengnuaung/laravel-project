@extends('admin.layouts.master')
@section('title', 'Product Detail Page')
@section('barContent')
    <h4>ADMIN DASHBOARD</h4>
@endsection
@section('content')
    <div class="col-1 offset-8 px-5">
        <a href="{{ route('products#list') }} "><button class="btn btn-dark px-3 text-white mb-3">List</button></a>
    </div>
    <div class="row">

        <div class="col-lg-10 offset-1">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-center title-2">Product Info</h3>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4 offset-1 d-flex align-items-center">
                            <div class="image img-thumbnail bg-secondary">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="">
                            </div>
                        </div>
                        <div class="col-6 offset-1">
                            <h2 class="my-3 title text-capitalize"><i
                                    class="fa-solid fa-circle-check me-3"></i>{{ $product->name }} </h2>
                            <div class="row">
                                <h3 class="my-3 btn btn-info col-3 px-1"><i
                                        class="fa-solid fa-sack-dollar me-3"></i>{{ $product->price }} Ks
                                </h3>
                                <h3 class="my-3 btn btn-primary col-3 offset-1"><i
                                        class="fa-solid fa-clock-rotate-left me-3"></i>{{ $product->waiting_time }} mins
                                </h3>
                                <h3 class="my-3 btn btn-success col-3 offset-1"><i
                                        class="fa-solid fa-eye me-3"></i>{{ $product->view_count }} </h3>
                            </div>
                            <h3 class="my-3 text-uppercase"><i class="fa-regular fa-clone me-3"></i>{{ $categories->name }}
                            </h3>

                            <h3 class="my-3"><i class="fa-regular fa-rectangle-list me-3"></i>Description</h3>
                            <p class="my-2 h5 me-5">{{ $product->description }} </p>

                            <h3 class="my-3 text-muted"><i
                                    class="fa-solid fa-calendar-days me-3"></i>{{ $product->updated_at }} </h3>

                        </div>
                    </div>
                    <div class="col-4 offset-1 my-3">
                        <a href="{{ route('products#editPage', $product->id) }} "
                            class="text-decoration-none col-12 btn btn-secondary">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Data
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
