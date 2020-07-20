@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="row">
        <div class="col-lg-8 col-md-7 col-sm-0 col-xs-0">
            <div class="login-r">
                <h1 class="text-primary">MMIS</h1>
                <h1 class="amis-lcase">Meeting Management Information System</h1>
                <p>Ardhi University Meeting Management System is a system created to enable management of various academic management information.</p>
                <ul>
                    <li>Students Registration Process Automation.</li>
                    <li>Students Accommodation Records Management.</li>
                    <li>Students Academic Records Management.</li>
                    <li>Students Financial Records Management</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
            <div class="login-form">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="username">Username <span class="text-red">*</span></label>
                        <input type="text" id="username" class="form-control @error('email') is-invalid @enderror"  name="username" required autocomplete="on" autofocus>
                    
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="password">{{ __('Password') }} <span class="text-red">*</span></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Login <span class="ion-locked"></span></button>
                        <a href="#" class="btn btn-secondary text-black">Student's help <span class="ion-help-circled"></span></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
