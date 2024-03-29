@extends('layouts.app')

@section('content')
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
    <!-- Login card -->
    <form class="login-form bg-white border border-grey-200" action="/login" method="POST">
    {{ csrf_field() }}
        <div class="card-body">
            <div class="text-center mb-3">
                <i class="icon-people icon-2x text-warning-400 border-warning-400 border-3 rounded-round p-3 mb-3 mt-1"></i>
                <h5 class="mb-0">Login to your account</h5>
                <span class="d-block text-muted">Your credentials</span>
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left" style="margin-bottom: 1.25rem !important">
                <input type="text" class="form-control" placeholder="Username" name="email">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left" style="margin-bottom: 1.25rem !important">
                <input type="password" class="form-control" placeholder="Password" name="password">
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
            </div>

            <div class="form-group d-flex align-items-center" style="margin-bottom: 1.25rem !important">
                <div class="form-check mb-0">
                    <label class="form-check-label">
                        <div class="uniform-checker"><span class="checked"><input type="checkbox" name="remember" class="form-input-styled" checked="" data-fouc=""></span></div>
                        Remember
                    </label>
                </div>

                <a href="login_password_recover.html" class="ml-auto">Forgot password?</a>
            </div>

            <div class="form-group" style="margin-bottom: 1.25rem !important">
                <button type="submit" class="btn btn-primary btn-block legitRipple" style="padding: 0.5rem 1.0rem !important">Sign in <i class="icon-circle-right2 ml-2"></i></button>
            </div>

            <div class="form-group text-center text-muted content-divider" style="margin-bottom: 1.25rem !important">
                <span class="px-2">Don't have an account?</span>
            </div>

            <div class="form-group" style="margin-bottom: 1.25rem !important">
                <a href="#" class="btn btn-dark btn-block legitRipple" style="padding: 0.5rem 1.0rem !important">Sign up</a>
            </div>

            <span class="form-text text-center text-muted">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>
        </div>
    </form>
    <!-- /login card -->
</div>
@endsection
