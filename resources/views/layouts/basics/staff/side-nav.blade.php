<div class="sidebar-img">
    <ul class="side-menu">
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Meeting</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                @if(Auth::User()->hasAnyRoleType(['head','dean','director']))
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