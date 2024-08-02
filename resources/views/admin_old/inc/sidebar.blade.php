<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('dashboard') }}" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="mega-menu mega-menu-sm @yield('user_li_1') ">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-globe-alt menu-icon"></i><span class="nav-text">User</span>
                </a>
                <ul aria-expanded="false">
                    <li class="@yield('user_li_child_1')"><a class="@yield('user_li_child_1in')" href="{{ route('user.create') }}">Add
                            User</a></li>
                    <li class="@yield('user_li_child_2')"><a class="@yield('user_li_child_2in')" href="{{ route('user.index') }}">All
                            Users</a></li>
                </ul>
            </li>
            <li class="mega-menu mega-menu-sm @yield('facility_li_1') ">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-grid menu-icon"></i><span class="nav-text">Facility</span>
                </a>
                <ul aria-expanded="false">
                    <li class="@yield('facility_li_child_1')"><a class="@yield('facility_li_child_1in')"
                            href="{{ route('facility.index') }}">Manage</a></li>
                </ul>
            </li>
            <li class="mega-menu mega-menu-sm @yield('floor_li_1') ">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-grid menu-icon"></i><span class="nav-text">Floors</span>
                </a>
                <ul aria-expanded="false">
                    <li class="@yield('floor_li_child_1')"><a class="@yield('floor_li_child_1in')"
                            href="{{ route('floors.index') }}">Manage</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
