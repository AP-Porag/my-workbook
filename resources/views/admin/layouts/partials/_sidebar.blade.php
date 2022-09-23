<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                <li>
                    <a href="#" class="waves-effect">
                        <i class="fa fa-home"></i><span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect ">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{route('admin.admins.index')}}"
                               class="active">
                                Admin
                            </a>
                        </li>
                        <li>
                            <a href="#"
                               class="">
                                Customer
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
