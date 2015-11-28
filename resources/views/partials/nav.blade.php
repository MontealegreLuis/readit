<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <i class="fa fa-reddit"></i>
                ReadIt
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                @if (!isset($readitor))
                    <li>
                        <a href="/auth/login">
                            <i class="glyphicon glyphicon-log-in"></i>
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="/auth/register">
                            <i class="glyphicon glyphicon-file"></i>
                            Register
                        </a>
                    </li>
                @else
                    <li>
                        <span class="text-muted nav-text">
                            Hi <strong>{{ $readitor->name }}</strong>
                        </span>
                    </li>
                    <li>
                        <a href="/auth/logout">
                            <i class="glyphicon glyphicon-log-out"></i>
                            Logout
                        </a>
                    </li>
                    <li class="active">
                        <a href="/links/create">
                            <i class="glyphicon glyphicon-link"></i>
                            Post a link
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
