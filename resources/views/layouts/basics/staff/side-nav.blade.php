<div class="sidebar-img">
    <ul class="side-menu">
        <li class="slide">
            <a class="side-menu__item active" data-toggle="slide" href="#">
                <i class="side-menu__icon fe fe-home"></i>
                <span class="side-menu__label">Committee</span>
                <i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li>
                    <a class="slide-item" href="{{ route('register') }}">Add User</a>
                </li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Meeting</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                @if(Auth::User()->hasAnyRole(['head','dean']))
                <li>
                    <a href="{{ url('create_meeting')}}" class="slide-item">Create Meeting</a>
                </li>
                @endif
                <li>
                    <a href="{{ url('view_meeting')}}" class="slide-item">View Meeting</a>
                </li>
            </ul>
        </li>
    </ul>
</div>