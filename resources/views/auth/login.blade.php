@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="row">
        <div class="col-lg-8 col-md-7 col-sm-0 col-xs-0">
            <div class="login-r">
                <h1 class="text-primary">IMMRS</h1>
                <h1 class="amis-lcase">Institutional Meeting Minutes Repository System</h1>
                <p>Ardhi University Meeting Minutes Repository System is a system created to enable storing and retrieving meeting minutes and other attachments.</p>
                <ul>
                    <li>Meeting Creation Process.</li>
                    <li>Minutes, Matter Arising, Attendence and Attachments storage.</li>
                    <li>Search and Retrieval of past Meetings with associated Attachments.</li>
                    <li>History and Backtracking of Meeting with associated Attachments</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
            <div class="login-form">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="username">Username <span class="text-red">*</span></label>
                        <input type="text" id="username" class="form-control @error('username') is-invalid @enderror" value="{{old('username')}}"  name="username" required autocomplete="on" autofocus>
                    
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="password">{{ __('Password') }} <span class="text-red">*</span></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"  name="password" required autocomplete="current-password">
                    
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Login <span class="ion-locked"></span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
