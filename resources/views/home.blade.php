@extends('layouts.app')

@section('content')
<div class="container-fluid mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @auth
                <div class="card-header">Welcome {{ Auth::user()->name }}</div>

                <div class="card-body">
                    {{ __('You are logged in!') }}
                </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
