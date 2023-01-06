@extends('admin.layouts.master')
@section('title', 'Detail Page')
@section('barContent')
    <h4>ADMIN DASHBOARD</h4>
@endsection
@section('content')
    <div class="col-1 offset-8 px-5">
        <button class="btn btn-dark px-3 text-white mb-3" onclick="history.back()"><i class="fa fa-arrow-left"
                aria-hidden="true"></i></button>
    </div>
    <div class="row">

        <div class="col-lg-8 offset-2">
            <div class="card">
                <div class="card-body ">
                    <div class="card-title">
                        <h3 class="text-center title-2">Admin Account</h3>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4 offset-1">
                            <div class="image">
                                @if ($admin->image == null)
                                    @if ($admin->gender == 'female')
                                        <img src="{{ asset('images/default-female.jpg') }} " alt="admin" />
                                    @else
                                        <img src="{{ asset('images/Default-welcomer.png') }} " alt="admin" />
                                    @endif
                                @else
                                    <img src="{{ asset('storage/' . $admin->image) }} " alt="user image">
                                @endif
                            </div>

                        </div>
                        <div class="col-5 offset-1 ">
                            <h3 class="my-3"> <i class="fa-solid fa-user-pen me-3"></i>{{ $admin->name }} </h3>
                            <h3 class="my-3"><i class="fa-solid fa-envelope-circle-check me-3"></i>
                                {{ $admin->email }}
                            </h3>

                            <h3 class="my-3"><i class="fa-solid fa-square-phone me-3"></i>{{ $admin->phone }}
                            </h3>
                            <h3 class="my-3"><i class="fa-solid fa-venus-mars me-3"></i>{{ $admin->gender }}
                            </h3>
                            <h3 class="my-3"><i class="fa-solid fa-address-card me-3"></i> {{ $admin->address }}
                            </h3>
                            <h3 class="my-3"><i class="fa-solid fa-calendar-days me-3"></i>
                                {{ $admin->created_at->format('j F Y') }} </h3>

                        </div>
                    </div>
                    <form action="{{ route('adminRole#convert') }} " method="post">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="id" value="{{ $admin->id }} ">
                            <div class="col-4 offset-1 ">
                                <div class="my-3">
                                    <button type="button" class="btn btn-primary btn-lg col-12">
                                        <i class="fa-solid fa-user-gear me-3"></i> Account Type
                                    </button>
                                </div>
                                <div>
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

                                        <input type="radio" class="btn-check " name="role" id="role1"
                                            value="admin" autocomplete="off" @checked($admin->role == 'admin')>
                                        <label class="btn btn-outline-danger btn-lg rounded-left px-5 col-6"
                                            for="role1">ADMIN</label>
                                        <input type="radio" class="btn-check" name="role" id="role3" value="user"
                                            autocomplete="off" @checked($admin->role == 'user')>
                                        <label class="btn btn-outline-success btn-lg rounded-right px-5 col-6"
                                            for="role3">USER</label>


                                    </div>

                                </div>

                            </div>
                            <div class="col-5 offset-1 mt-5 p-2">
                                <button type="submit" class="text-decoration-none col-12 btn btn-secondary btn-lg">
                                    <i class="fa-solid fa-rotate"></i> Convert
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
