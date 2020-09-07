@extends('layouts.admin')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('name') is-invalid @enderror" name="first_name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="Ardhi{{date('Y')}}" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="Ardhi{{date('Y')}}" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
                <h2 class="mb-0">RAGISTER A NEW STAFF</h2>
            </div>
            <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="name" autofocus>
                        
                           @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Gender</label>
                            <select id="gender" name="gender" class="form-control select2 w-100" >
                                <option value="none" selected="selected" disabled>Select Gender</option>
                                <option value="male" class="text-md">Male</option>
                                <option value="female" class="text-md">Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="Ardhi{{date('Y')}}" required>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror          
                        </div>

                        <div class="form-group">
                            <label class="form-label">Role</label>
                            <select id="role" name="role" class="form-control select2 w-100" >
                                <option value="none" selected="selected" disabled>Select Role</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Department</label>
                            <select id="department" name="department" class="form-control select2 w-100" >
                                <option value="none" selected="selected" disabled>Select Department</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="Ardhi{{date('Y')}}" required>
                        </div>
                    </div>
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $.ajax({
                url: '/fetchroles',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                dataType: 'json',
                success:function(response){
                    attachRoles(response);
                },
                error:function(xhr,status,err){
                    console.log(err);
                }
            });
        $.ajax({
                url: '/fetchdepartments',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                dataType: 'json',
                success:function(response){
                    attachDepartments(response);
                },
                error:function(xhr,status,err){
                    console.log(err);
                }
            });
    });

    const attachDepartments = (departments) =>{
        let list = "";
        departments.forEach(department => {
            let option = '<option value="'+
                department.id+'" class="text-md">'+
                department.department_name+' ('+department.department_code+')'+'</option>';
            list += option;
        });
        $('#department').append(list);
    }

    const attachRoles = (roles) =>{
        let list = "";
        roles.forEach(role => {
            let option = '<option value="'+
                role.id+'" class="text-md">'+
                role.role_name+' ('+role.role_code+')'+'</option>';
            list += option;
        });
        $('#role').append(list);
    }
</script>

@endsection
