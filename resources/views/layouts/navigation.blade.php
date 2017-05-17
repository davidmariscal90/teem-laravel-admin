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
                        <li> <a href="#"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form></li>
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
            <li class="{{ isActiveRoute('sport') }}">
                <a href="{{ url('/sport') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Sport</span> </a>
            </li>
            <li class="{{ isActiveRoute('subsport') }}">
                <a href="{{ url('/subsport') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Subsport</span> </a>
            </li>
             <li class="{{ isActiveRoute('invitation') }}">
                <a href="{{ url('/invitation') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Invitation</span> </a>
            </li>
             <li class="{{ isActiveRoute('team') }}">
                <a href="{{ url('/team') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Teams</span> </a>
            </li>
            <li class="{{ isActiveRoute('field') }}">
                <a href="{{ url('/field') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Pitch & Sportcenter</span> </a>
            </li>
			 <li class="{{ isActiveRoute('match') }}">
                <a href="{{ url('/match') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Match</span> </a>
            </li>
        </ul>

    </div>
</nav>
