<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



<div id="navi-style" class="navi-style">
    <header class="navigation">
        <div id="imgLogo">
            <a href="/index.php" class="logo">USER MENU TEST
                <img width="40px" height="40px" src="img/logotype.png" alt="logotype png"></a>
        </div>
        <nav>
            <ul class="nav-link">
                @guest
                    <li><a href='/sign-in'>Sign In</a></li>
                @endguest
                @auth
                    <li><a href='{{route('sign-out')}}'>Sign out</a></li>
                    <li><a href='{{route('work-time', ['userId' => Auth::user()-> userId])}}'>Work time</a></li>
                    @if(Auth::user()->role == 'admin')
                        <li><a href='{{route('users')}}'>Users</a></li>
                    @endif
                        zalogowany jako {{Auth::user() -> name}}
                    @endauth
            </ul>
        </nav>
    </header>
</div>
