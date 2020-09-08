@extends('layouts.app')

@section('content')

<div class="single-pro-review-area mt-t-30 mg-b-15">
    <div class="container-fluid">
        
        <div class="row">
        @foreach($user as $user)
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="profile-info-inner">
                    <div class="profile-img">
                        <img src="img/profile/1.jpg" alt="" />
                    </div>
                    <div class="profile-details-hr">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                <div class="address-hr">
                                    <p><b>Name</b><br />{{$user->first_name}}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                <div class="address-hr tb-sm-res-d-n dps-tb-ntn">
                                    <p><b>LastName</b><br /> {{$user->last_name}}</p>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                <div class="address-hr">
                                    <p><b>Username</b><br /> {{$user->username}}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                <div class="address-hr tb-sm-res-d-n dps-tb-ntn">
                                    <p><b>Gender</b><br /> {{$user->gender}}</p>
                                </div>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="address-hr">
                                    <p><b>Email</b><br />{{$user->email}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="product-payment-inner-st res-mg-t-30 analysis-progrebar-ctn">
                              
                    <form action="updateProfile" method="post">
                    {{csrf_field()}}
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="review-content-section">
                                        <div class="row">

                                        <input name="id" type="text" class="form-control" value="{{$user->user_id}}" hidden>

                                            <div class="col-lg-12">
                                        
                                                <div class="form-group">
                                                    <input name="full_name" type="text" class="form-control" value="{{$user->first_name}}, {{$user->last_name}}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text"name="username"  class="form-control" value="{{$user->username}}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" name="gender" class="form-control" value="{{$user->gender}}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" value="{{$user->department_name}}" disabled>
                                                </div>
                                            

                                                <div class="form-group">
                                                    <input type="text" name="email" class="form-control" value="{{$user->email}}">
                                                </div>

                                                <div class="form-group">
                                                    <input type="password" name="password" class="form-control" value="{{$user->password}}" placeholder="type password">
                                                </div>
                                                
                                            </div>
                                        
                                        
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-8 col-md-8"></div>                                                
                                                <div class="col-lg-4 col-md-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                                                                      
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>   
                </div>
            </div>
        </div>
    </div>
</div>

@endsection