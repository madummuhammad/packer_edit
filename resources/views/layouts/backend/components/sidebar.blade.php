<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <a href="#main" data-toggle="collapse" aria-expanded="{{ Request::segment(count(Request::segments()) - 1) == 'main' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Main</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::segment(count(Request::segments()) - 1) == 'main' ? 'show' : '' }}" id="main" data-parent="#accordionExample">
                    <li class="{{ Request::segment(count(Request::segments())) == 'dashboard' ? 'active' : '' }}"><a href="{{ url('admin/main/dashboard') }}">Dashboard</a></li>
                    @if (!in_array(Session::get('role_id'), $mitra))
                    <li class="{{ Request::segment(count(Request::segments())) == 'product' ? 'active' : '' }}"><a href="{{ url('admin/main/product') }}">Products</a></li>
                    <li class="{{ Request::segment(count(Request::segments())) == 'book-spaces' ? 'active' : '' }}"><a href="{{ url('admin/main/book-spaces') }}">Warehouse</a></li>
                    @endif
                    <li class="{{ Request::segment(count(Request::segments())) == 'invoice' ? 'active' : '' }}"><a href="{{ url('admin/main/invoice') }}">Invoice</a></li>
                    <li class="{{ Request::segment(count(Request::segments())) == 'storage' ? 'active' : '' }}"><a href="{{ url('admin/main/storage') }}">Storage</a></li>
                    <li class="{{ Request::segment(count(Request::segments())) == 'inbound' ? 'active' : '' }}"><a href="{{ url('admin/main/inbound') }}">Inbounds</a></li>
                    <li class="{{ Request::segment(count(Request::segments())) == 'outbound' ? 'active' : '' }}"><a href="{{ url('admin/main/outbound') }}">Outbounds</a></li>
                    @if (!in_array(Session::get('role_id'), $mitra))
                    <li class="{{ Request::segment(count(Request::segments())) == 'inventory' ? 'active' : '' }}"><a href="{{ url('admin/main/inventory') }}">Inventory</a></li>
                    <li class="{{ Request::segment(count(Request::segments())) == 'integration' ? 'active' : '' }}"><a href="{{ url('admin/main/integration') }}">Integrations</a></li>
                    @endif
                    <li class="{{ Request::segment(count(Request::segments())) == 'report' ? 'active' : '' }}"><a href="{{ url('admin/main/report') }}">Reports</a></li>
                </ul>
            </li>
            @if (in_array(Session::get('role_id'), $admin))
            <li class="menu">
                <a href="#master-data" data-toggle="collapse" aria-expanded="{{ Request::segment(count(Request::segments()) - 1) == 'master-data' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span>Master Data</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::segment(count(Request::segments()) - 1) == 'master-data' ? 'show' : '' }}" id="master-data" data-parent="#accordionExample">
                    <li class="{{ Request::segment(count(Request::segments())) == 'warehouse' ? 'active' : '' }}"><a href="{{ url('admin/master-data/warehouse') }}">Warehouse</a></li>
                    <li class="{{ Request::segment(count(Request::segments())) == 'space' ? 'active' : '' }}"><a href="{{ url('admin/master-data/space') }}">Spaces</a></li>
                    <li class="{{ Request::segment(count(Request::segments())) == 'addon' ? 'active' : '' }}"><a href="{{ url('admin/master-data/addon') }}">Addon</a></li>
                </ul>
            </li>
            @endif
            @if (in_array(Session::get('role_id'), $admin))
            <li class="menu">
                <a href="#settings" data-toggle="collapse" aria-expanded="{{ Request::segment(count(Request::segments()) - 1) == 'settings' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                        <span>Settings</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::segment(count(Request::segments()) - 1) == 'settings' ? 'show' : '' }}" id="settings" data-parent="#accordionExample">
                    <li class="{{ Request::segment(count(Request::segments())) == 'user-management' ? 'active' : '' }}"><a href="{{ url('admin/settings/user-management') }}">User Management</a></li>
                    <li class="{{ Request::segment(count(Request::segments())) == 'user-log' ? 'active' : '' }}"><a href="{{ url('admin/settings/user-log') }}">User Log</a></li>
                    <li class="{{ Request::segment(count(Request::segments())) == 'error-log' ? 'active' : '' }}"><a href="{{ url('admin/settings/error-log') }}">Error Log</a></li>
                </ul>
            </li>
            @endif
        </ul>
    </nav>
</div>
<!--  END SIDEBAR  -->