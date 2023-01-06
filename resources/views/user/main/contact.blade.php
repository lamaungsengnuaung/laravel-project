@extends('user.layouts.master')
@section('content')
    <!-- Contact Start -->
    <div class="container-fluid" style=" background:url('{{ asset('images/background.webp') }}') repeat ;">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-white pr-3">Contact Us</span>
        </h2>
        <div class="row px-xl-5">
            <div class="col-lg-6 mb-5 offset-3">
                <div class="contact-form  p-30 mt-5"
                    style="height: 700px; background-image:url(public\images\hand-drawn-fast-food-background_23-2149013389.webp);">
                    <div id="success">
                        @if (session('messageSuccess'))
                            <div class="alert alert-info alert-dismissible fade show col-6" role="alert">
                                <strong>
                                    {{ session('messageSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('errorMessage'))
                            <div class="alert alert-primary alert-dismissible fade show col-6" role="alert">
                                <strong>
                                    {{ session('errorMessage') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                    <form action="{{ route('user#message') }} " method="post" class="bg-white rounded-top">
                        @csrf
                        <label for="name" class=" px-2 pt-3 font-weight-bold ">Your Name</label>
                        <input type="text" name="name" id="name" class="form-control border-info input-group"
                            value="{{ Auth::user()->name }} " placeholder="Your name">
                        @error('name')
                            <small class="text-danger d-block"><i
                                    class="fa-solid fa-triangle-exclamation mx-1"></i>{{ $message }} </small>
                        @enderror

                        <label for="email" class="bg-white p-1 font-weight-bold mt-4"> Your Email </label>
                        <input type="email" name="email" id="email" class="form-control border-info input-group "
                            value="{{ Auth::user()->email }} " placeholder="Your email">
                        @error('email')
                            <small class="text-danger d-block"><i
                                    class="fa-solid fa-triangle-exclamation mx-1"></i>{{ $message }} </small>
                        @enderror
                        <label for="message" class="p-1 font-weight-bold mt-4">Feedback</label>
                        <textarea name="message" id="message" cols="30" rows="10" class="form-control border-info"
                            placeholder="Write Message"></textarea>
                        @error('message')
                            <small class="text-danger"><i class="fa-solid fa-triangle-exclamation mx-1"></i>{{ $message }}
                            </small>
                        @enderror
                        <button type="submit" class="btn btn-lg btn-info form-control mt-4">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- Contact End -->
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('.btn-close').click(function() {
                window.location.href = "/user/homePage";
            })
        })
    </script>
@endsection
