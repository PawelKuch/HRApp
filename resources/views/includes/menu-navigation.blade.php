<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<div id="navi-style" class="navi-style">
    <header class="navigation">
        <div id="imgLogo">
            <a href="{{route('main-page')}}" class="logo">HR APP
                <img width="40px" height="40px" src="{{asset('img/logotypelogo.png')}}" alt="logotype png"></a>
        </div>
        <nav>
            <ul class="nav-link">
                @guest
                    <li><a href='/sign-in'>Sign In</a></li>
                @endguest
                @auth
                    @if(Auth::user()->role == 'admin')
                        <li><a href='{{route('users')}}'>Users</a></li>
                        <li>
                            <div class="dropdown">
                                <a href="#" class="dropBtn">Employee manager</a>
                                <div class="dropdown-content">
                                    <a href='{{route('expenses', ['userId' => Auth::user() -> userId])}}'>Expenses</a>
                                    <a href="{{route('usersWorktime')}}">Users worktime</a>
                                </div>
                            </div>
                        </li>
                    @else

                            <li><a href='{{route('worktime', ['userId' => Auth::user()-> userId, 'month' => \Carbon\Carbon::now() -> month, 'year' => \Carbon\Carbon::now() -> year]) }}'>Work time</a></li>
                            <li><a href='{{route('expenses', ['userId' => Auth::user() -> userId])}}'>Expenses</a></li>
                    @endif
                        <li><a href='{{route('user.leaves')}}'>User leaves</a></li>
                     <div class="dropdown">
                         <a href="#" class="dropBtn">{{Auth::user() -> name}}</a>
                         <div class="dropdown-content-user">
                             <a href="#">Your profile</a>
                             <a href="{{route('your.account', ['userId' => Auth::user() -> userId])}}">Your account</a>
                             <a href='{{route('user.settings', ['userId' => Auth::user() -> userId])}}'>Your settings</a>
                             <a href="{{route('sign-out')}}">Sign out</a>
                         </div>
                     </div>
                @endauth
            </ul>
        </nav>
    </header>
</div>
