<!--  BEGIN NAVBAR  -->
<div class="header-container fixed-top" style="border-bottom: 1px solid #ffac0c;">
    <header class="header navbar navbar-expand-sm" style="background-color: #ffac0c;">
        <ul class="navbar-item theme-brand flex-row text-center" style="width: 100px; height: 40px;">
            <li class="nav-item theme-logo">
                <a href="{{ url('') }}">
                    <img src="{{ asset('assets/apps/img/logo.png') }}" class="navbar-logo" alt="logo" style="width: 100px; height: 40px;">
                </a>
            </li>
        </ul>
        <ul class="navbar-item flex-row ml-md-auto">
            @if (!in_array(Session::get('role_id'), $admin))
            <li class="nav-item dropdown message-dropdown" id="cartButton">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="cartDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <div class="indicator" id="cartIndicator" style="top: -8px; right: -8px;">
                        <!-- Placeholder: Cart Counter -->
                    </div>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="cartDropdown">
                    <div class="dropdown-header d-flex align-items-center justify-content-between">
                        <p class="mb-0 font-weight-medium" id="cartTotal"></p>
                        <a href="javascript:void(0);" class="text-muted" id="cartClear">Clear all</a>
                    </div>
                    <div class="dropdown-body text-center">
                        <!-- Placeholder: Cart Item -->
                        <span class="spinner-border spinner-border-sm m-5" role="status" aria-hidden="true"></span>
                    </div>
                    <div class="dropdown-footer d-flex align-items-center justify-content-center">
                        <a href="{{ url('admin/user/cart') }}" id="cartView">View all</a>
                    </div>
                </div>
            </li>
            @endif
            <li class="nav-item dropdown notification-dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class="badge badge-success"></span>
                    <div class="indicator" id="notificationIndicator" style="display: none;">
                        <div class="circle"></div>
                    </div>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                    <div class="dropdown-header d-flex align-items-center justify-content-between">
                        <p class="mb-0 font-weight-medium" id="notificationTotal"></p>
                        <a href="javascript:void(0);" class="text-muted" id="notificationClear">Clear all</a>
                    </div>
                    <div class="dropdown-body text-center">
                        <a href="javascript:void(0);" class="dropdown-item disabled">
                            <div class="content">
                                <p>No notifications</p>
                            </div>
                        </a>
                    </div>
                    <div class="dropdown-footer d-flex align-items-center justify-content-center">
                        <a href="javascript:void(0);" id="notificationView">View all</a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown user-profile-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <img src="{{ asset('assets/backend/assets/img/90x90.jpg') }}" alt="avatar">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="">
                        <div class="dropdown-item">
                            <a class="" href="{{ url('admin/user/profile') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Profile</a>
                        </div>
                        <div class="dropdown-item">
                            <a class="" href="{{ url('admin/user/topup-history') }}"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Top Up History</a>
                        </div>
                        <div class="dropdown-item">
                            <a class="" href="{{ url('sign-out') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Sign Out</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </header>
</div>
<!--  END NAVBAR  -->

<!--  BEGIN NAVBAR  -->
<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>
        <ul class="navbar-nav flex-row">
            <li>
                <div class="page-header">
                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">@yield('title')</a></li>
                        </ol>
                    </nav>
                </div>
            </li>
        </ul>
        @if (!in_array(Session::get('role_id'), $admin))
        <ul class="navbar-nav flex-row ml-auto mr-3">
            <li class="nav-item">
                <div class="btn-group" role="group" aria-label="My Balance">
                    <a href="#" class="btn btn-outline-dark btn-sm disabled" id="myBalance" style="min-width: 100px;" disabled>IDR 0</a>
                    <a href="#" class="btn btn-dark btn-sm" onclick="$('#topup-modal').modal('show');">Top Up</a>
                </div>
            </li>
        </ul>
        @endif
    </header>
</div>
<!--  END NAVBAR  -->