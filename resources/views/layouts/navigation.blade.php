<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">Teemweb</strong>
                            </span> <span class="text-muted text-xs block">Teemweb <b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="#">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    TW
                </div>
            </li>
            <li class="{{ isActiveRoute('home') }}">
                <a href="{{ url('/home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span></a>
            </li>
             <li class="{{ isActiveRoute('admin') }}">
                <a href="{{ url('/admin') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Admin</span></a>
            </li>
            <li class="{{ isActiveRoute('user') }}">
                <a href="{{ url('/user') }}"><i class="fa fa-th-large"></i> <span class="nav-label">User</span> </a>
            </li>
        </ul>

    </div>
</nav>
