<div class="sidebar-img">
    <ul class="side-menu">
        <li class="slide">
            <a class="side-menu__item active" data-toggle="slide" href="#">
                <i class="side-menu__icon fe fe-home"></i>
                <span class="side-menu__label">Users</span>
                <i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li>
                    <a class="slide-item" href="{{ route('register') }}">Add User</a>
                </li>
                <li>
                    <a class="slide-item" >View User</a>
                </li>
                <li>
                    <a href="{{ route('assignRole') }}" class="slide-item" >Assign Role</a>
                </li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">schools</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li>
                    <a href="{{ route('AddSchool') }}" class="slide-item">Add school</a>
                </li>
                <li>
                    <a href="{{ route('showschools')}}" class="slide-item">View schools</a>
                </li>
        
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fe fe-edit"></i><span class="side-menu__label">Departments</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li>
                    <a href="{{ route('AddDepartment') }}" class="slide-item">Add Department</a>
                </li>
                <li>
                    <a href="{{ route('showDepartment') }}" class="slide-item">View Departments</a>
                </li>
               

            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Roles</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li>
                    <a href="{{'registerRolesForm'}}" class="slide-item">Register Roles</a>
                </li>
                <li>
                    <a href="{{'displayRoles'}}" class="slide-item">View Roles</a>
                </li>
                <!-- <li>
                    <a href="" class="slide-item">View Roles</a>
                </li> -->
        
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fe fe-map"></i><span class="side-menu__label">Commitee</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li>
                    <a href="{{ route('showsCommittee') }}" class="slide-item">Create Commitee</a>
                </li>
                <li>
                    <a href="{{'displayCommittee'}}" class="slide-item">View Commitee</a>
                </li>
            </ul>
        </li>
    </ul>
</div>