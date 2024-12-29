<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<div id="navi-style" class="navi-style bg-dark">
    <header class="navigation">
        <div id="imgLogo">
            <a href="{{route('main-page')}}" class="logo text-white" >XAViER
                <img width="40px" height="40px" src="{{asset('img/logotypelogo1.png')}}" alt="logotype png" style="clip-path: circle(40%); width: 60px"></a>
        </div>
        <nav>
            <ul class="nav-link">
                @guest
                    <li><a href='/sign-in' class="text-white">Sign In</a></li>
                @endguest
                @auth
                    @if(Auth::user()->role == 'admin')
                        <li><a href='{{route('users')}}' class="text-white">Users</a></li>
                        <li>
                            <div class="dropdown">
                                <a href="#" class="dropBtn text-white" >Employee manager</a>
                                <div class="dropdown-content">
                                    <a href='{{route('expenses', ['userId' => Auth::user() -> userId])}}'>Expenses</a>
                                    <a href="{{route('usersWorktime')}}">Users worktime</a>
                                    <a href='{{route('leaves')}}'>Leaves</a>
                                </div>
                            </div>
                        </li>
                    @else
                            <li><a href='{{route('user.leaves')}}' class="text-white">Your leaves</a></li>
                            <li><a href='{{route('worktime', ['userId' => Auth::user()-> userId, 'month' => \Carbon\Carbon::now() -> month, 'year' => \Carbon\Carbon::now() -> year]) }}' class="text-white">Work time</a></li>
                            <li><a href='{{route('expenses', ['userId' => Auth::user() -> userId])}}' class="text-white">Expenses</a></li>
                    @endif
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
