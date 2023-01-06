@extends('admin.layouts.master')
@section('title', 'Create Page')
@section('barContent')
    <h4>ADMIN DASHBOARD</h4>
@endsection
@section('content')
    <div class="row ">
        <div class="col-md-5 offset-3  px-5">
            @if (session('updatedMessage'))
                <div class="alert alert-primary alert-dismissible fade show col-11 mb-3" role="alert">
                    <strong>{{ session('updatedMessage') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('errorMessage'))
                <div class="alert alert-danger alert-dismissible fade show col-11 mb-3" role="alert">
                    <strong>{{ session('errorMessage') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="col-1   px-5">
            <a href="{{ route('category#list') }}"><button class="btn bg-dark px-3 text-white  mb-3">List</button></a>
        </div>

    </div>
    <div class="col-md-6 offset-md-2">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">Change Password</h3>
                </div>
                <hr>
                <form action="{{ route('admin#changePassword') }} " method="post" novalidate="novalidate">
                    @csrf
                    <div class="form-group py-1">
                        <label class="control-label mb-1 h5">Password</label>
                        <input id="cc-pament" name="password" type="password"
                            class="form-control shadow-md @error('password') is-invalid

                        @enderror "
                            aria-required="true" aria-invalid="false" placeholder=" Enter password ...">
                        @error('password')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group py-1">
                        <label class="control-label mb-1 h5">New Passsword</label>
                        <input id="cc-pament" name="newPassword" type="password"
                            class="form-control shadow-md @error('newPassword') is-invalid @enderror " aria-required="true"
                            aria-invalid="false" placeholder=" Enter password ...">
                        @error('newPassword')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group py-1">
                        <label class="control-label mb-1 h5">Confirmed Password</label>
                        <input id="cc-pament" name="confirmPassword" type="password"
                            class="form-control shadow-md @error('confirmPassword') is-invalid @enderror  "
                            aria-required="true" aria-invalid="false" placeholder=" Enter password ...">
                        @error('confirmPassword')
                            <div class="invalid-feedback"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                            <span id="payment-button-amount">Change</span>
                            {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                            {{-- <i class="fa-solid fa-circle-right"></i> --}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
