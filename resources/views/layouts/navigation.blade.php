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
            <li {{{ (Request::is('home') ? 'class=active' : '') }}}>
                <a href="{{ url('/home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span></a>
            </li>
             <li {{{ (Request::is('admin') || Request::is('admin/*') ? 'class=active' : '') }}}>
                <a href="{{ url('/admin') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Admin</span></a>
            </li>
            <li {{{ (Request::is('user') || Request::is('user/*') ? 'class=active' : '') }}}>
                <a href="{{ url('/user') }}"><i class="fa fa-th-large"></i> <span class="nav-label">User</span> </a>
            </li>
            <li {{{ (Request::is('sport') || Request::is('sport/*') ? 'class=active' : '') }}}>
                <a href="{{ url('/sport') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Sport</span> </a>
            </li>
            <li {{{ (Request::is('subsport') || Request::is('subsport/*') ? 'class=active' : '') }}}>
                <a href="{{ url('/subsport') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Subsport</span> </a>
            </li>
             <li {{{ (Request::is('invitation') || Request::is('invitation/*') ? 'class=active' : '') }}}>
                <a href="{{ url('/invitation') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Invitation</span> </a>
            </li>
             <li {{{ (Request::is('team') || Request::is('team/*') ? 'class=active' : '') }}}>
                <a href="{{ url('/team') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Teams</span> </a>
            </li>
            <li {{{ (Request::is('field') || Request::is('field/*') ? 'class=active' : '') }}}>
                <a href="{{ url('/field') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Pitch & Sportcentre <span class="badge">{{$totalpending}}</span></span> </a>
            </li>
			<li {{{ (Request::is('pitch') || Request::is('pitch/*') ? 'class=active' : '') }}}>
                <a href="{{ url('/pitch') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Pitch <span class="badge"></span></span> </a>
            </li>
			<li {{{ (Request::is('sportcenter') || Request::is('sportcenter/*') ? 'class=active' : '') }}}>
                <a href="{{ url('/sportcenter') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Sportcentre <span class="badge"></span></span> </a>
            </li>
			 <li {{{ (Request::is('match') || Request::is('match/*') ? 'class=active' : '') }}}>
                <a href="{{ url('/match') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Match</span> </a>
            </li>
			<li {{{ (Request::is('activity') || Request::is('activity/*') ? 'class=active' : '') }}}>
                <a href="{{ url('/activity') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Activity</span> </a>
            </li>
        </ul>

    </div>
</nav>
