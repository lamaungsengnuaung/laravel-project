@extends('user.layouts.master')

@section('content')
    <div class="row ">

        <div class="col-2 offset-9  px-5">
            <a href="{{ route('user#account') }}"><button class="btn bg-dark px-3 text-white  mb-3"><i
                        class="fa-solid fa-chevron-left text-warning"></i></button></a>
        </div>

    </div>
    <div class="col-lg-8 offset-2 pb-5">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">Edit User Account</h3>
                </div>
                <hr>
                <form action=" {{ route('user#update', Auth::user()->id) }} " method="post" novalidate="novalidate"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-4 offset-1">
                            <div class="image">
                                @if (Auth::user()->image == null)
                                    @if (Auth::user()->gender == 'female')
                                        <img src="{{ asset('images/default-female.jpg') }} " class="img-thumbnail"
                                            alt="user" />
                                    @else
                                        <img src="{{ asset('images/Default-welcomer.png') }} "
                                            class="img-thumbnail"alt="user" />
                                    @endif
                                @else
                                    <img src="{{ asset('storage/' . Auth::user()->image) }} "
                                        class=" img-thumbnail shadow-sm" alt="user image">
                                @endif
                            </div>
                            <div class=" py-2 mt-3">
                                <label class="control-label h5">Image File</label>

                                <input type="file" name="image" id=""
                                    class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }} </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6 offset-1">
                            <div class="form-group py-1">
                                <label class="control-label mb-1 h5">Name</label>
                                <input type="text"
                                    class="form-control @error('name')
                                    is-invalid
                                @enderror"
                                    name="name" value="{{ old('name', Auth::user()->name) }} " id="">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }} </div>
                                @enderror
                            </div>
                            <div class="form-group py-1">
                                <label class="control-label mb-1 h5">Email</label>
                                <input type="text"
                                    class="form-control @error('email')
                                    is-invalid
                                @enderror"
                                    name="email" value="{{ old('email', Auth::user()->email) }} " id="">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }} </div>
                                @enderror
                            </div>

                            <div class="form-group py-1">
                                <label class="control-label mb-1 h5">Phone</label>
                                <input type="text"
                                    class="form-control @error('phone')
                                    is-invalid
                                @enderror"
                                    name="phone" value="{{ old('phone', Auth::user()->phone) }} " id="">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }} </div>
                                @enderror
                            </div>
                            <div class="form-group py-1">
                                <label
                                    class="control-label mb-1 me-3 h5 @error('gender')
                                    is-invalid
                                @enderror">Gender</label>
                                <select name="gender" id="" class="form-control">
                                    <option value="">choose your gender ...</option>
                                    <option value="male" @selected(old('gender') == 'male')> Male </option>
                                    <option value="female"@selected(old('gender') != 'male')> Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }} </div>
                                @enderror
                            </div>
                            <div class="form-group py-1">
                                <label class="control-label mb-1 h5">Address</label>
                                <textarea name="address"
                                    class="form-control @error('address')
                                    is-invalid
                                @enderror"
                                    id="" cols="30" rows="10">{{ old('address', Auth::user()->address) }} </textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }} </div>
                                @enderror
                            </div>
                            <div class="form-group py-1">
                                <label class="control-label mb-1 h5">Role</label>
                                <input type="text" class="form-control" name="role" value="{{ Auth::user()->role }} "
                                    disabled>

                            </div>
                        </div>
                    </div>

                    <div class="mt-md-5">
                        <button id="payment-button" type="submit" class="btn btn-lg btn-success btn-block">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> <span class="h4" id="payment-button-amount">
                                Update</span>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
