@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-xl-4 col-lg-4">
        <div class="card pull-up shadow bg-secondary">
            <div class="card-content">
                <div class="card-body">
                    <img src="{{ asset('ansta/img/circle.svg')}}" class="card-img-absolute" alt="circle-image">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h4 class="text-white">Registered staff</h4>
                            <h2 class="text-white mb-0">{{$academic_staff + $admin_staff}}</h2>
                        </div>
                        <div class="align-self-center">
                            <!-- <i class="fe fe-shopping-cart text-white font-large-2 float-right"></i> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4">
        <div class="card pull-up shadow bg-primary">
            <div class="card-content">
                <div class="card-body">
                    <img src="{{ asset('ansta/img/circle.svg')}}" class="card-img-absolute" alt="circle-image">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h4 class="text-white">Academic Staff</h4>
                            <h2 class="text-white mb-0">{{$academic_staff}}</h2>
                        </div>
                        <div class="align-self-center">
                            <!-- <i class="fe fe-bar-chart text-white font-large-2 float-right"></i> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4">
        <div class="card pull-up shadow bg-success">
            <div class="card-content">
                <div class="card-body">
                    <img src="{{ asset('ansta/img/circle.svg')}}" class="card-img-absolute" alt="circle-image">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h4 class="text-white">Administration Staff</h4>
                            <h2 class="text-white mb-0">{{$admin_staff}}</h2>
                        </div>
                        <div class="align-self-center">
                            <!-- <i class="fe fe-mail success font-large-2 text-white float-right"></i> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
        <div class="col-xl-3 col-lg-3">
            <div class="card shadow bg-success">
                <div class="card-body">
                    <div class="widget text-center text-white">
                        <small class="text-white-50">Departments</small>
                        <h2 class="text-xxl text-white">{{$departments}}</h2>
                        <!-- <p class="mb-0"><span class="text-white"><i class="fas fa-caret-up text-white ml-1"></i> 4%</span>  last month</p> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3">
            <div class="card shadow mb-xl-0 bg-secondary text-white">
                <div class="card-body">
                    <div class="widget text-center">
                        <small class="text-white-50">Committees</small>
                        <h2 class="text-xxl text-white">{{$committees}}</h2>
                        <!-- <p class="mb-0"><span class="text-white"><i class="fas fa-caret-down text-white ml-1"></i> 5%</span> last month</p> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3">
            <div class="card shadow bg-warning text-white">
                <div class="card-body">
                    <div class="widget text-center">
                        <small class="text-white-50">Schools</small>
                        <h2 class="text-xxl text-white">{{$schools}}</h2>
                        <!-- <p class="mb-0"><span class="text-white"><i class="fas fa-caret-up text-white ml-1"></i> 6%</span> last month</p> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3">
            <div class="card shadow mb-0 bg-danger text-white">
                <div class="card-body">
                    <div class="widget text-center">
                        <small class="text-white-50">Directorates</small>
                        <h2 class="text-xxl text-white">{{$directorates}}</h2>
                        <!-- <p class="mb-0"><span class="text-white"><i class="fas fa-caret-down text-white ml-1"></i> 8%</span> last month</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
