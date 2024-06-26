@extends('layouts.plane-layout')
@section('title')
    {{ __('Confirm Password') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="login-box">
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                            <a href="#" class="h1"><b>Admin</b>LTE</a>
                        </div>
                        <div class="card-body">
                            <p class="login-box-msg">You are only one step a way from your new password, recover your
                                password now.</p>
                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" placeholder="Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit"
                                            class="btn btn-primary btn-block">{{ __('Confirm Password') }}</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                            <p class="mt-3 mb-1">
                                <a href="{{ route('login') }}">Login</a>
                            </p>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                        <!-- /.login-card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
