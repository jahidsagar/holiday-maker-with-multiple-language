<section id="menu">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">Calendar Holiday Maker</a>
            </div>
            <div class="collapse navbar-collapse navbar-right" id="myNavbar">
                <ul class="nav navbar-nav">
                    @if($roleforview == 1)<li><a href="{{ url('/role') }}">Set Role</a></li>@endif
                    <li><a href="{{ url('/apps') }}">All Apps</a></li>
                    <li><a href="{{ url('/languages') }}">All Languages</a></li>
                    <li> 
                        <a class="btn btn-info" href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); 
                        document.getElementById('logout-form').submit();" 
                        style="color: black;">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</section>