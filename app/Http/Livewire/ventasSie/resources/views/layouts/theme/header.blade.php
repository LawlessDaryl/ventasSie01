<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm 3838" style="background: #383838;">
        <ul class="navbar-item flex-row">
            <li class="nav-item theme-logo">
                <a href="{{url('inicio')}}">
                    {{-- Logo --}}
                    <img src="assets/img/fav08.png" class="navbar-logo" alt="logo">
                </a>
            </li>
        </ul>

        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                style="color: #ffffff;" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-list">
                <line x1="8" y1="6" x2="21" y2="6"></line>
                <line x1="8" y1="12" x2="21" y2="12"></line>
                <line x1="8" y1="18" x2="21" y2="18"></line>
                <line x1="3" y1="6" x2="3" y2="6"></line>
                <line x1="3" y1="12" x2="3" y2="12"></line>
                <line x1="3" y1="18" x2="3" y2="18"></line>
            </svg></a>

        <livewire:search-controller>

        </livewire:search-controller>
        @if (@Auth::user()->hasPermissionTo('Corte_Caja_Index'))
        <ul class="tabs tab-pills text-center mt-2">            
            <a href="{{ url('cortecajas') }}" class="btn btn-warning btn-lg active" role="button" aria-pressed="true">CORTE DE CAJA</a>            
        </ul>
        @endif

        <ul class="tabs tab-pills text-center mt-4">
            @if (empty(session('sesionCaja')))
                <h5 style="background-color: #ff7600; color:#ffffff">No tienes ninguna caja abierta</h5>
            @else
                <marquee behavior="" direction="">
                    <h5 style="background-color: #ff7600; color:#ffffff;font-size:24px">Usted tiene la {{ session('sesionCaja') }} abierta</h5>
                </marquee>
            @endif
        </ul>
        <ul class="navbar-item flex-row navbar-dropdown">
            {{-- <li class="nav-item dropdown message-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="messageDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg style="color: #ff6700;" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-message-circle">
                        <path
                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                        </path>
                    </svg><span class="badge badge-primary"></span>
                </a>
                <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="messageDropdown">
                    <div class="">
                        <a class="dropdown-item">
                            <div class="">

                                <div class="media">
                                    <div class="user-img">
                                        <div class="avatar avatar-xl">
                                            <span class="avatar-title rounded-circle">KY</span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="">
                                            <h5 class="usr-name">Kara Young</h5>
                                            <p class="msg-title">ACCOUNT UPDATE</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="">
                                <div class="media">
                                    <div class="user-img">
                                        <div class="avatar avatar-xl">
                                            <span class="avatar-title rounded-circle">DA</span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="">
                                            <h5 class="usr-name">Daisy Anderson</h5>
                                            <p class="msg-title">ACCOUNT UPDATE</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="">

                                <div class="media">
                                    <div class="user-img">
                                        <div class="avatar avatar-xl">
                                            <span class="avatar-title rounded-circle">OG</span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="">
                                            <h5 class="usr-name">Oscar Garner</h5>
                                            <p class="msg-title">ACCOUNT UPDATE</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </li>

            <livewire:noti-controller>

            </livewire:noti-controller>

            <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ asset('storage/usuarios/' . auth()->user()->imagen) }}" alt="admin-profile"
                        class="img-fluid">
                </a>
                <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="userProfileDropdown"">
                    <div class="       user-profile-section" style="background: #ee761c;">
                    <div class="media mx-auto">
                        <img src="{{ asset('storage/usuarios/' . auth()->user()->imagen) }}" class="img-fluid mr-2"
                            alt="avatar">
                        <div class="media-body">
                            <h4>{{ auth()->user()->name }}</h4>
                            <p>{{ auth()->user()->profile }}</p>
                            @foreach(auth()->user()->sucursalusers as $sucu)
                                @if($sucu->estado == 'ACTIVO')
                                    <p>{{$sucu->sucursal->name}}</p>
                                @endif
                            @endforeach
                            <p></p>
                        </div>
                    </div>
                </div>
                {{-- <div class="dropdown-item">
                    <a href="user_profile.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-user">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg> <span>My Profile</span>
                    </a>
                </div>
                <div class="dropdown-item">
                    <a href="auth_lockscreen.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-lock">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg> <span>Lock Screen</span>
                    </a>
                </div> --}}
                <div class="dropdown-item">
                    <a class="" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-log-out">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg> Salir</a>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                    </form>
                </div>
</div>
</li>
</ul>
</header>
</div>
