<li class="nav-item dropdown notification-dropdown">
    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <svg style="color: #ff6700;" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="feather feather-bell">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg>
        


        @if($NotificacionIco>0)
        <span class="badge badge-success"></span>
        @endif
    </a>


    <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="notificationDropdown">
        <div class="notification-scroll">

            @if ($NotificacionIco>0)
                @foreach ($notif as $p)
                <a href="{{ url('notificaciones') }}">


                            @if($p->estado == "NOVISTO")
                            <div class="dropdown-item" style="background-color: #f6f5e1">
                            @else
                            <div class="dropdown-item">
                            @endif

                                <div class="media server-log">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                    class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                    <div class="media-body">





                                        
                                        <div class="data-info">
                                            <h6 class="">{{$p->nn}}</h6>
                                                @if($year <= 0)
                                                    @if($meses <= 0)
                                                        @if($dias <= 0)
                                                            @if ($hora <= 0)
                                                                @if($minutos<1)
                                                                    <p class="">En este Instante</p>
                                                                @else
                                                                    <p class="">Hace {{$minutos}} Minutos</p>
                                                                @endif
                                                            @else
                                                                <p class="">Hace {{$hora}} horas</p>
                                                            @endif
                                                        @else
                                                            <p class="">Hace {{$dias}} dias</p>
                                                        @endif
                                                    @else
                                                        @if($meses == 1)
                                                        <p class="">Hace {{$meses}} Mes</p>
                                                        @else
                                                        <p class="">Hace {{$meses}} Meses</p>
                                                        @endif
                                                    @endif
                                                @else
                                                    <p class="">Hace {{$year}} Años</p>
                                                @endif
                                                {{substr($p->m, 3, 17).'...'}}
                                        </div>









                                    </div>
                                </div>
                        </div>
                </a>
                <hr style="margin:0px; height:2px;border:none;color:rgb(212, 44, 44);background-color:rgb(221, 189, 157);" />
                @endforeach
            @else
            <div class="dropdown-item">
                <div class="media server-log">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        <div class="media-body">
                            <div class="data-info">
                                <h6 class="">Sin Notificaciones</h6>
                                Nada que Notificar
                            </div>

                            <div class="icon-status">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </div>
                        </div>
                </div>
            </div>
            @endif


            {{-- <div class="dropdown-item">
                <div class="media ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-heart">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                        </path>
                    </svg>
                    <div class="media-body">
                        <div class="data-info">
                            <h6 class="">Licence Expiring Soon</h6>
                            <p class="">8 hrs ago</p>
                        </div>

                        <div class="icon-status">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown-item">
                <div class="media file-upload">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-file-text">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <div class="media-body">
                        <div class="data-info">
                            <h6 class="">Kelly Portfolio.pdf</h6>
                            <p class="">670 kb</p>
                        </div>

                        <div class="icon-status">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-check">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
            </div> --}}


        </div>
    </div>
</li>
