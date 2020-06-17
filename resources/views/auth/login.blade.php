@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-7 col-md-7 col-sm-none">
            <h1 class="">AMIS</h1>
            <h1 class="amis-lcase">Academic Management Information System</h1>
            <p>Ardhi University Academic Management System is a system created to enable management of various academic management information.</p>
            <ul>
                <li>Students Registration Process Automation.</li>
                <li>Students Accommodation Records Management.</li>
                <li>Students Academic Records Management.</li>
                <li>Students Financial Records Management</li>
            </ul>
        </div>
        <div class="col-lg-5 col-md-7 col-sm-5">
            <div>
                <label for="username">Username <span>*</span></label>
                <input type="text" id="username" class="form-control">
            </div>
            <div>
                <label for="password">Password <span>*</span></label>
                <input type="password" id="password" class="form-control">
            </div>
            <div class="pt-20">
                <a href="#" class="btn btn-primary">Login <span class="ion-locked"></span></a>
                <a href="#" class="btn btn-secondary">Student's help <span class="ion-help-circled"></span></a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('not-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="reg_number" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
