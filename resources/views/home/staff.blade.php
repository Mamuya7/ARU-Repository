@extends('layouts.app')

@section('content')
							{{Auth::User()->roles}}
<div class="row">
    <div class="col-md-6 col-lg-6 col-xl-3">
        <div class="card p-3 px-4 shadow">
            <div>Total revenue</div>
            <div class="py-2 m-0 text-center h1 text-green">$14,320</div>
            <div class="d-flex">
                <small class="text-muted">Income</small>
                <div class="ml-auto"><i class="fa fa-caret-up text-green"></i> 4%</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-xl-3">
        <div class="card p-3 px-4 shadow">
            <div>Order status</div>
            <div class="py-2 m-0 text-center h1 text-red">738</div>
            <div class="d-flex">
                <small class="text-muted">New order</small>
                <div class="ml-auto">
                <i class="fa fa-caret-down text-red"></i> 10%</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-xl-3">
        <div class="card p-3 px-4 shadow">
            <div>Income status</div>
            <div class="py-2 m-0 text-center h1 text-blue">$3,205</div>
            <div class="d-flex">
                <small class="text-muted">New income</small>
                <div class="ml-auto"><i class="fa fa-caret-down text-red"></i> 0%</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-xl-3">
        <div class="card p-3 px-4 shadow">
            <div>Customer status</div>
            <div class="py-2 m-0 text-center h1 text-yellow">118</div>
            <div class="d-flex">
                <small class="text-muted">New users</small>
                <div class="ml-auto">
                <i class="fa fa-caret-up text-green"></i> 3%</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4">
        <div class="card pull-up shadow bg-gradient-primary">
            <div class="card-content">
                <div class="card-body">
                    <img src="assets/img/circle.svg" class="card-img-absolute" alt="circle-image">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h4 class="text-white">Sales</h4>
                            <h2 class="text-white mb-0">88,568</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fe fe-shopping-cart text-white font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4">
        <div class="card pull-up shadow bg-gradient-warning">
            <div class="card-content">
                <div class="card-body">
                    <img src="assets/img/circle.svg" class="card-img-absolute" alt="circle-image">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h4 class="text-white">Profit</h4>
                            <h2 class="text-white mb-0">$25,28,568</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fe fe-bar-chart text-white font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4">
        <div class="card pull-up shadow bg-gradient-danger">
            <div class="card-content">
                <div class="card-body">
                    <img src="assets/img/circle.svg" class="card-img-absolute" alt="circle-image">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h4 class="text-white">Inbox</h4>
                            <h2 class="text-white mb-0">236</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fe fe-mail success font-large-2 text-white float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="widget text-center">
                                    <small class="text-muted">Invoice</small>
                                    <h2 class="text-xxl">$834</h2>
                                    <p class="mb-0"><span class="text-success"><i class="fa fa-chevron-circle-up text-success ml-1"></i> 3%</span>  last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-xl-0">
                            <div class="card-body">
                                <div class="widget text-center">
                                    <small class="text-muted">Profits</small>
                                    <h2 class="text-xxl">$68</h2>
                                    <p class="mb-0"><span class="text-danger"><i class="fa fa-chevron-circle-down text-danger ml-1"></i> 2%</span> last month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="widget text-center">
                                    <small class="text-muted">Sales</small>
                                    <h2 class="text-xxl">295</h2>
                                    <p class="mb-0"><span class="text-success"><i class="fa fa-chevron-circle-up text-success ml-1"></i> 5%</span> last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-0">
                            <div class="card-body">
                                <div class="widget text-center">
                                    <small class="text-muted">Expenses</small>
                                    <h2 class="text-xxl">$851</h2>
                                    <p class="mb-0"><span class="text-danger"><i class="fa fa-chevron-circle-down text-danger ml-1"></i> 4%</span> last month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card shadow bg-primary">
                            <div class="card-body">
                                <div class="widget text-center text-white">
                                    <small class="text-white-50">New Users</small>
                                    <h2 class="text-xxl text-white">8342</h2>
                                    <p class="mb-0"><span class="text-white"><i class="fas fa-caret-up text-white ml-1"></i> 4%</span>  last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-xl-0 bg-yellow text-white">
                            <div class="card-body">
                                <div class="widget text-center">
                                    <small class="text-white-50">Online Visitors</small>
                                    <h2 class="text-xxl text-white">2568</h2>
                                    <p class="mb-0"><span class="text-white"><i class="fas fa-caret-down text-white ml-1"></i> 5%</span> last month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow bg-warning text-white">
                            <div class="card-body">
                                <div class="widget text-center">
                                    <small class="text-white-50">Bounce Rate</small>
                                    <h2 class="text-xxl text-white">29%</h2>
                                    <p class="mb-0"><span class="text-white"><i class="fas fa-caret-up text-white ml-1"></i> 6%</span> last month</p>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-0 bg-success text-white">
                            <div class="card-body">
                                <div class="widget text-center">
                                    <small class="text-white-50">Updates</small>
                                    <h2 class="text-xxl text-white">851</h2>
                                    <p class="mb-0"><span class="text-white"><i class="fas fa-caret-down text-white ml-1"></i> 8%</span> last month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
