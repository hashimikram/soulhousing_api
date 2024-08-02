<div class="header" style="background-color: #14457b">
    <div class="clearfix header-content">

        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="text-white icon-menu"></i></span>
            </div>
        </div>

        <div class="header-left">

        </div>
        <div class="text-white header-right">
            <ul class="clearfix">

                <li class="icons dropdown">
                    <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                        <span class="activity active"></span>
                        <img src="{{ asset('assets/admin/images/soul-housing-logo.png') }}" height="40"
                            width="40" alt="">
                    </div>
                    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li>
                                    <a href="{{ route('admin.index') }}"><i class="icon-user"></i>
                                        <span>Profile</span></a>
                                </li>
                                <hr class="my-2">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <button type="submit" class="p-0 bg-white btn"> <i class="icon-key"></i>
                                            <span>Logout</span>
                                        </button>
                                    </form>

                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
