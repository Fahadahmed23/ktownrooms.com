@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="content d-flex justify-content-center align-items-center">

            <!-- Password recovery form -->
            <form class="login-form" action="/password/reset" method="POST">
            {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img class="img-thumbnail" src="https://www.ktownrooms.com/resources/assets/web/img/logo.png" alt="Ktown Rooms and homes" style="width:50%;">
                            <!-- <i class="icon-spinner11 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3 mt-1"></i> -->
                            <h5 class=" mt-3 mb-0">Reset Your Password</h5>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-5 col-form-label text-md-right">{{ __('Email Address') }}</label>

                            <div class="col-md-7">
                                <input style="background:none" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-5 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-7">
                                <input style="background:none" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-5 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-7">
                                <input style="background:none" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <button type="submit" class="btn bg-blue btn-block"><i class="icon-spinner11 mr-2"></i> Reset password</button>
                    </div>
                </div>
            </form>
            <!-- /password recovery form -->
        </div>
    </div>
</div>

@endsection
