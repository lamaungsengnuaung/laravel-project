@extends('user.layouts.master')
@section('title', 'Detail Page')
@section('content')
    <div class="col-1 offset-8 px-5">
        <a href="{{ route('user#home') }}"><button class="btn btn-dark px-3 text-white mb-3"><i
                    class="fa-solid fa-house text-warning"></i></button></a>
    </div>
    <div class="row">

        <div class="col-lg-8 offset-2">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-center title-2">User Account</h3>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4 offset-1">
                            <div class="image">
                                @if (Auth::user()->image == null)
                                    @if (Auth::user()->gender == 'female')
                                        <img src="{{ asset('images/default-female.jpg') }} " class="img-thumbnail"
                                            alt="user" />
                                    @else
                                        <img src="{{ asset('images/Default-welcomer.png') }}" class="img-thumbnail"
                                            alt="user" />
                                    @endif
                                @else
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}" class="img-thumbnail"
                                        alt="user image">
                                @endif
                            </div>
                        </div>
                        <div class="col-5 offset-1 mt-3">
                            <h3 class="my-3"> <i class="fa-solid fa-user-pen me-3"></i>{{ Auth::user()->name }} </h3>
                            <h3 class="my-3"><i class="fa-solid fa-envelope-circle-check me-3"></i>
                                {{ Auth::user()->email }}
                            </h3>
                            <h3 class="my-3"><i class="fa-solid fa-square-phone me-3"></i>{{ Auth::user()->phone }}
                            </h3>
                            <h3 class="my-3"><i class="fa-solid fa-venus-mars me-3"></i>{{ Auth::user()->gender }}
                            </h3>
                            <h3 class="my-3"><i class="fa-solid fa-address-card me-3"></i> {{ Auth::user()->address }}
                            </h3>
                            <h3 class="my-3"><i class="fa-solid fa-calendar-days me-3"></i>
                                {{ Auth::user()->created_at->format('j F Y') }} </h3>

                        </div>
                    </div>
                    <div class="col-4 offset-1 my-3">
                        <a href="{{ route('user#editpage') }} " class="text-decoration-none col-12 btn btn-warning">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
