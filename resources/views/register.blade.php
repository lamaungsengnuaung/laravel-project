@extends('layouts.master')
@section('title', 'Register Page')
@section('content')
    <div class="login-form">
        <form action="{{ route('register') }} " method="post">
            @csrf
            @error('terms')
                <small class="text-danger">{{ $message }} </small>
            @enderror
            <div class="form-group">
                <label>Username</label>
                <input class="au-input au-input--full" type="text" name="name" placeholder="Username">
                @error('name')
                    <small class="text-danger">{{ $message }} </small>
                @enderror
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
                @error('email')
                    <small class="text-danger">{{ $message }} </small>
                @enderror
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input class="au-input au-input--full" type="number" name="phone" placeholder="09xxxx">
                @error('phone')
                    <small class="text-danger">{{ $message }} </small>
                @enderror
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" id="" class="d-block form-control">
                    <option value="">Choose Your Gender . . . .</option>
                    <option value="male">
                        Male
                    </option>
                    <option value="female">Female</option>
                </select>
                @error('gender')
                    <small class="text-danger">{{ $message }} </small>
                @enderror
            </div>
            <div class="form-group">
                <label>Address</label>
                <input class="au-input au-input--full" type="text" name="address" placeholder="address">
                @error('address')
                    <small class="text-danger">{{ $message }} </small>
                @enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full" id="password" type="password" name="password"
                    placeholder="Password">
                @error('password')
                    <small class="text-danger">{{ $message }} </small>
                @enderror
                <div class="passwordStrength">

                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password_confirmation"
                    placeholder="Confirm Password">
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }} </small>
                @enderror
            </div>

            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>

        </form>
        <div class="register-link">
            <p>
                Already have account?
                <a href="{{ route('auth#loginPage') }}">Sign In</a>
            </p>
        </div>
    </div>
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            console.log('working');
            // password length and strength
            $('#password').keyup(function() {
                $password = $(this).val();
                console.log($password.length);
                if ($password.length < 6) {
                    console.log('poor');
                    $('.passwordStrength').html(
                        "<small class='text-primary p-2'>password strength :</small><small id='qty'>poor</small>"
                    )
                } else if ($password.length <= 8) {
                    console.log('good');
                    $('.passwordStrength').html(
                        "<small class='text-primary p-2'>password strength :</small><small id='qty' class='text-success' >good</small>"
                    )
                } else if ($password.length > 8 && $password.length <= 12) {
                    console.log('excellent');
                    $('.passwordStrength').html(
                        "<small class='text-primary p-2'>password strength :</small><small id='qty' class='text-primary' >excellent</small>"
                    )
                } else if ($password.length > 12) {
                    console.log('hard to remember');
                    $('.passwordStrength').html(
                        "<small class='text-primary p-2'>password strength :</small><small id='qty' class='text-danger' >Hard to remember</small>"
                    )
                }
            })

        })
    </script>
@endsection
