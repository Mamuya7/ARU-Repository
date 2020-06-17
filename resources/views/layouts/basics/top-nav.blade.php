<div class="container-fluid">

    <!-- Brand -->
    <a class="navbar-brand pt-0 d-md-none" href="index-2.html">
        <img src="{{asset('img/logo/aruLogo.png')}}" class="navbar-brand-img" alt="...">
    </a>
    <!-- Form -->
    <form class="navbar-search navbar-search-dark form-inline mr-3  ml-lg-auto">
        <div class="form-group mb-0">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div><input class="form-control" placeholder="Search" type="text">
            </div>
        </div>
    </form>
    <!-- User -->
    <ul class="navbar-nav align-items-center ">
        <li class="nav-item d-none d-md-flex">
            <div class="dropdown d-none d-md-flex mt-2 ">
                <a class="nav-link full-screen-link pl-0 pr-0"><i class="fe fe-maximize-2 floating " id="fullscreen-button"></i></a>
            </div>
        </li>
        <li class="nav-item dropdown d-none d-md-flex">
            <a aria-expanded="false" aria-haspopup="true" class="nav-link pr-0" data-toggle="dropdown" href="#" role="button">
            <div class="media align-items-center">
                <i class="fe fe-user "></i>
            </div></a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-arrow dropdown-menu-right">
                <a class="dropdown-item d-flex" href="#">
                    <span class="avatar brround mr-3 align-self-center"> <img src="assets/img/faces/male/4.jpg" alt="imag" ></span>
                    <div>
                        <strong>Madeleine Scott</strong> sent you friend request
                        <div class=" mt-2 small text-muted">
                            <span class="btn btn-sm btn-primary">Conform</span>
                            <span class="btn btn-sm btn-outline-primary">Delete</span>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item d-flex" href="#">
                    <span class="avatar brround mr-3 align-self-center"><img src="assets/img/faces/female/14.jpg" alt="imag" ></span>
                    <div>
                        <strong>rebica</strong> sent you friend request
                        <div class=" mt-2 small text-muted">
                            <span class="btn btn-sm btn-primary">Conform</span>
                            <span class="btn btn-sm btn-outline-primary">Delete</span>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item d-flex" href="#">
                    <span class="avatar brround mr-3 align-self-center"><img src="assets/img/faces/male/1.jpg" alt="imag"></span>
                    <div>
                        <strong>Devid robott</strong> sent you friend request
                        <div class=" mt-2 small text-muted">
                            <span class="btn btn-sm btn-primary">Conform</span>
                            <span class="btn btn-sm btn-outline-primary">Delete</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div><a class="dropdown-item text-center text-muted-dark" href="#">View all Requestes</a>
            </div>
        </li>

        <li class="nav-item dropdown d-none d-md-flex">
            <a aria-expanded="false" aria-haspopup="true" class="nav-link pr-0" data-toggle="dropdown" href="#" role="button">
            <div class="media align-items-center">
                <i class="fe fe-mail "></i>
            </div></a>
            <div class="dropdown-menu  dropdown-menu-lg dropdown-menu-arrow dropdown-menu-right">
                <a href="#" class="dropdown-item text-center">12 New Messages</a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item d-flex">
                    <span class="avatar brround mr-3 align-self-center"><img src="assets/img/faces/male/41.jpg" alt="img"></span>
                    <div>
                        <strong>Madeleine</strong> Hey! there I' am available....
                        <div class="small text-muted">3 hours ago</div>
                    </div>
                </a>
                <a href="#" class="dropdown-item d-flex">
                    <span class="avatar brround mr-3 align-self-center"><img src="assets/img/faces/female/1.jpg" alt="img" ></span>
                    <div>
                        <strong>Anthony</strong> New product Launching...
                        <div class="small text-muted">5  hour ago</div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item text-center">See all Messages</a>
            </div>
        </li>
        <li class="nav-item dropdown d-none d-md-flex">
            <a aria-expanded="false" aria-haspopup="true" class="nav-link pr-0" data-toggle="dropdown" href="#" role="button">
            <div class="media align-items-center">
                <i class="fe fe-bell f-30 "></i>
            </div></a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-arrow dropdown-menu-right">
                <a href="#" class="dropdown-item d-flex">
                    <div>
                        <strong>Someone likes our posts.</strong>
                        <div class="small text-muted">3 hours ago</div>
                    </div>
                </a>
                <a href="#" class="dropdown-item d-flex">
                    <div>
                        <strong> 3 New Comments</strong>
                        <div class="small text-muted">5  hour ago</div>
                    </div>
                </a>
                <a href="#" class="dropdown-item d-flex">
                    <div>
                        <strong> Server Rebooted.</strong>
                        <div class="small text-muted">45 mintues ago</div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item text-center">View all Notification</a>
            </div>
        </li>
        @auth
        <li class="nav-item dropdown">
            <a aria-expanded="false" aria-haspopup="true" class="nav-link pr-md-0" data-toggle="dropdown" href="#" role="button">
            <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle"><img alt="Image placeholder" src="assets/img/faces/female/32.jpg"></span>
                <div class="media-body ml-2 d-none d-lg-block">
                    <span class="mb-0 ">{{Auth::user()->name}}</span>
                </div>
            </div></a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
                <a class="dropdown-item" href="user-profile.html"><i class="ni ni-single-02"></i> <span>My profile</span></a>
                <a class="dropdown-item" href="#"><i class="ni ni-settings-gear-65"></i> <span>Settings</span></a>
                <a class="dropdown-item" href="#"><i class="ni ni-calendar-grid-58"></i> <span>Activity</span></a>
                <a class="dropdown-item" href="#"><i class="ni ni-support-16"></i> <span>Support</span></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                    <i class="ni ni-user-run"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
        @endauth
    </ul>
</div>