<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid w-75 for-light"
                    src="{{ asset('assets/images/logo/login.png') }}" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="fa fa-cog status_toggle middle sidebar-toggle"> </i>
            </div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid"
                    style="width: 40px; text-align: center;" src="{{ asset('assets/images/logo/login.png') }}"
                    alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-main-title">
                        <h6>Content</h6>
                    </li>
                    <li class="menu-box">
                        <ul>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                    href="#">
                                    <i data-feather="home"></i><span>Dashboard</span></a></li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                    href="#">
                                    <i data-feather="user"></i><span>Pegawai</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
