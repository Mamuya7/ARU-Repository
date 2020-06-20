<div class="container-fluid">
    <div class="top-navbar">
        <div class="nav-head-bar">
            <!-- Brand -->
            <div class="navbar-top-logo">
                <a class="navbar-brand pt-0" href="index-2.html">
                    <img src="{{asset('img/logo/aruLogo.png')}}" class="navbar-brand-img" alt="...">
                </a>
            </div>
            <div class="navbar-top-title">
                <div class="text-center text-xl text-black-70 pb-0 mb-0">ARDHI UNIVERSITY</div>
                <div class="text-center text-md text-pale-orange pt-0 mt-0">ACADEMIC MANAGEMENT INFORMATION SYSTEM</div>
            </div>
        </div>
        <div>
            @auth
            <!-- User -->
            <ul class="navbar-nav align-items-center ">
                <li class="nav-item d-none d-md-flex">
                    <div class="dropdown d-none d-md-flex mt-2 ">
                        <a class="nav-link full-screen-link pl-0 pr-0"><i class="fe fe-maximize-2 floating " id="fullscreen-button"></i></a>
                    </div>
                </li>
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
            </ul>
            @endauth
        </div>
    </div>
</div>