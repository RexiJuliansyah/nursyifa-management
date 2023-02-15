<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="mobile-only-brand pull-left">
        <div class="nav-header pull-left">
            <div class="brand-image mt-10">
                <a href="###" style="margin-left:-10px">
                    <img src="{{ asset('admin') }}/dist/img/logonav.png" width="200px" height="55px" alt="brand"  />
                </a>
            </div>
        </div>
        <a id="toggle_nav_btn" class="toggle-left-nav-btn pull-left ml-20 inline-block" href="javascript:void(0);"><i
                class="zmdi zmdi-menu"></i></a>
        <a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
    </div>
    <div id="mobile_only_nav" class="mobile-only-nav pull-right">
        <ul class="nav navbar-right top-nav pull-right">
            <!-- <li class="dropdown alert-drp">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="zmdi zmdi-notifications top-nav-icon"></i>
                    <span class="top-nav-icon-badge">5</span>
                </a>
                <ul class="dropdown-menu alert-dropdown" data-dropdown-in="slideInRight"
                    data-dropdown-out="slideOutRight">
                    <li>
                        <div class="notification-box-head-wrap">
                            <span class="notification-box-head pull-left inline-block">notifications</span>
                            <a class="txt-danger pull-right clear-notifications inline-block" href="javascript:void(0)">
                                clear all </a>
                            <div class="clearfix"></div>
                            <hr class="light-grey-hr ma-0" />
                        </div>
                    </li>
                    <li>
                        <div class="streamline message-nicescroll-bar">
                            <div class="sl-item">
                                <a href="javascript:void(0)">
                                    <div class="icon bg-green">
                                        <i class="zmdi zmdi-flag"></i>
                                    </div>
                                    <div class="sl-content">
                                        <span
                                            class="capitalize-font pull-left head-notifications inline-block truncate">
                                            New subscription created</span>
                                        <span class="font-11 pull-right notifications-time inline-block">2pm</span>
                                        <div class="clearfix"></div>
                                        <p class="truncate">Your customer subscribed for the basic plan. The customer
                                            will pay $25 per month.</p>
                                    </div>
                                </a>
                            </div>
                            <hr class="light-grey-hr ma-0" />

                        </div>
                    </li>
                </ul>
            </li> -->

            <li class="dropdown auth-drp">
                <a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown">
                    <img src="{{ asset('admin') }}/dist/img/user1.png" alt="user_auth"
                        class="user-auth-img img-circle" /><span class="user-online-status"></span>
                </a>

                <ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                    <!-- <li>
                        <a href="profile.html"><i class="zmdi zmdi-account"></i><span>Profile</span></a>
                    </li> -->
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

</nav>
