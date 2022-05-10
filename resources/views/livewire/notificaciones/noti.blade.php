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

                {{-- href="{{ url('report/pdf' . '/' . $total. '/' . $idventa . '/' . Auth()->user()->id)}}" --}}

                <a href="{{ url('notificaciones') }}">
                            @if($p->estado == "NOVISTO")
                            <div class="dropdown-item" style="background-color: rgb(240, 231, 212)">
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
                                                @if($this->diferenciarfecha($p->fechanoti)->y <= 0)
                                                    @if($this->diferenciarfecha($p->fechanoti)->m <= 0)
                                                        @if($this->diferenciarfecha($p->fechanoti)->d <= 0)
                                                            @if ($this->diferenciarfecha($p->fechanoti)->h <= 0)
                                                                @if($this->diferenciarfecha($p->fechanoti)->i <= 0)
                                                                    <p class="">En este Instante</p>
                                                                @else
                                                                    <p class="">Hace {{$this->diferenciarfecha($p->fechanoti)->i}} Minutos</p>
                                                                @endif
                                                            @else
                                                                <p class="">Hace {{$this->diferenciarfecha($p->fechanoti)->h}} horas</p>
                                                            @endif
                                                        @else
                                                            @if($this->diferenciarfecha($p->fechanoti)->d == 1)
                                                            <p class="">Hace {{$this->diferenciarfecha($p->fechanoti)->d}} dia</p>
                                                            @else
                                                            <p class="">Hace {{$this->diferenciarfecha($p->fechanoti)->d}} dias</p>
                                                            @endif

                                                            
                                                        @endif
                                                    @else
                                                        @if($this->diferenciarfecha($p->fechanoti)->m == 1)
                                                        <p class="">Hace {{$this->diferenciarfecha($p->fechanoti)->m}} Mes</p>
                                                        @else
                                                        <p class="">Hace {{$this->diferenciarfecha($p->fechanoti)->m}} Meses</p>
                                                        @endif
                                                    @endif
                                                @else
                                                    <p class="">Hace {{$this->diferenciarfecha($p->fechanoti)->y}} Años</p>
                                                @endif
                                                {{substr($p->m, 3, 17).'...'}}
                                        </div>
                                    </div>
                                </div>
                        </div>
                </a>
                <hr style="margin:0px; height:2px;border:none;color:rgb(212, 44, 44);background-color:rgb(221, 189, 157);" />
                @if($loop->iteration > 4)
                    <a href="{{ url('notificaciones') }}">
                        <div class="text-center">
                            <div class="text-center">
                                    <div class="text-center">
                                        <p style="color: rgb(185, 110, 25); cursor: pointer;">Ver Mas...</p>
                                    </div>
                                </div>
                        </div>
                    </a>
                    @break
                @endif
                @endforeach
            @else

            <a href="{{ url('notificaciones') }}">
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
            </a>
            @endif

        </div>
    </div>
</li>
