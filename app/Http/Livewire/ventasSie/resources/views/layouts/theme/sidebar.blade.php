<div class="sidebar-wrapper sidebar-theme">

    <nav id="compactSidebar">
        <ul class="menu-categories">
            <li class="menu {{ request()->routeIs('tigomoney') ? 'active' : '' }}">
                <a href="#tigomoney" data-active="false" class="menu-toggle">
                    <div class="base-menu">
                        <div class="img">
                            <img src="{{ asset('storage/icons/tigoMoney.png') }}" alt="TigoMoney"
                                class="img-responsive" width="50px">
                        </div>
                        <span>TIGO MONEY</span>
                    </div>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-chevron-left">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </li>

            <li class="menu {{ request()->routeIs('streaming') ? 'active' : '' }}">
                <a href="#streaming" data-active="false" class="menu-toggle">
                    <div class="base-menu">
                        <div class="img">
                            <img src="{{ asset('storage/icons/disney.png') }}" alt="Streaming" class="img-responsive"
                                width="90px">
                        </div>
                        <span>STREAMING</span>
                    </div>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-chevron-left">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </li>

            {{-- <li class="menu {{ request()->routeIs('notificaciones') ? 'active' : '' }}">
                <a href="#notificaciones" data-active="false" class="menu-toggle">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="whatsapp" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                class="svg-inline--fa fa-whatsapp fa-w-14 fa-9x">
                                <path fill="currentColor"
                                    d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"
                                    class=""></path>
                            </svg>
                        </div>
                        <span>NOTIFY</span>
                    </div>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-chevron-left">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </li> --}}

            <li class="menu {{ request()->routeIs('servicio') ? 'active' : '' }}">
                <a href="#servicio" data-active="false" class="menu-toggle">
                    <div class="base-menu">
                        <div class="base-icons">
                            <i class="fa-solid fa-user-clock"></i>

                        </div>
                        <span>SERVICIO</span>
                    </div>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-chevron-left">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </li>

            @can('Roles_Index')
                <li class="menu {{ request()->routeIs('inventario') ? 'active' : '' }}">
                    <a href="#inventario" data-active="false" class="menu-toggle">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>

                            </div>
                            <span>INVENTARIO</span>
                        </div>
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-chevron-left">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </li>

                <li class="menu {{ request()->routeIs('parametros') ? 'active' : '' }}">
                    <a href="#parametros" data-active="false" class="menu-toggle">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>

                            </div>
                            <span>PARAMETROS</span>
                        </div>
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-chevron-left">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </li>



                <li class="menu {{ request()->routeIs('registro') ? 'active' : '' }}">
                    <a href="#registro" data-active="false" class="menu-toggle">
                        <div class="base-menu">
                            <div class="base-icons">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <span>ADMINISTRACION</span>
                        </div>
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-chevron-left">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </li>

            <li class="menu {{ request()->routeIs('ventas') ? 'active' : '' }}">
                <a href="#ventas" data-active="false" class="menu-toggle">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-shopping-bag">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        </div>
                        <span>VENTAS</span>
                    </div>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-chevron-left">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </li>

            <li class="menu {{ request()->routeIs('permisos') ? 'active' : '' }}">
                <a href="#permisos" data-active="false" class="menu-toggle">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-check-square">
                                <polyline points="9 11 12 14 22 4"></polyline>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                            </svg>
                        </div>
                        <span>PERMISOS</span>
                    </div>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-chevron-left">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </li>

            <li class="menu {{ request()->routeIs('contabilidad') ? 'active' : '' }}">
                <a href="#contabilidad" data-active="false" class="menu-toggle">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-dollar-sign">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                        <span>CONTABILIDAD</span>
                    </div>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-chevron-left">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </li>

        </ul>
    </nav>

    <div id="compact_submenuSidebar" class="submenu-sidebar">
        @if (empty(session('sesionCaja')))
            <div class="submenu" id="tigomoney">
                <ul class="submenu-list" data-parent-element="#app">
                    <li>
                        <strong>
                            <p> No tiene una caja abierta </p>
                            <p> para hacer transacciones </p>
                        </strong>
                    </li>
                    @can('Origen_Index')
                        <li>
                            <a href="{{ url('origenes') }}">
                                <img src="{{ asset('storage/icons/origen.png') }}" alt="Origen CRUD" width="25px">
                                Origen CRUD </a>
                        </li>
                    @endcan
                    @can('Motivo_Index')
                        <li>
                            <a href="{{ url('motivos') }}">
                                <img src="{{ asset('storage/icons/motivo.png') }}" alt="Motivo CRUD" width="25px">
                                Motivo CRUD </a>
                        </li>
                    @endcan
                    @can('Comision_Index')
                        <li>
                            <a href="{{ url('comisiones') }}">
                                <img src="{{ asset('storage/icons/comision.png') }}" alt="Comision CRUD" width="25px">
                                Comisión CRUD </a>
                        </li>
                    @endcan
                    @can('Origen_Mot_Index')
                        <li>
                            <a href="{{ url('origen-motivo') }}">
                                <img src="{{ asset('storage/icons/comision.png') }}" alt="Comision CRUD" width="25px">
                                Origen motivo </a>
                        </li>
                    @endcan
                    @can('Origen_Mot_Com_Index')
                        <li>
                            <a href="{{ url('origen-motivo-comision') }}">
                                <img src="{{ asset('storage/icons/comision.png') }}" alt="Comision CRUD" width="25px">
                                Origen motivo comisiones</a>
                        </li>
                    @endcan
                    @can('Jornada_Tigo_Index')
                        <li>
                            <a href="{{ url('ReporteJornalTM') }}">
                                <i class="fa-solid fa-baht-sign"></i>
                                Reporte Jornada T.M.</a>
                        </li>
                    @endcan
                    @can('Arqueos_Tigo_Index')
                        <li>
                            <a href="{{ url('arqueostigo') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-dollar-sign">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                Arqueos Tigo</a>
                        </li>
                    @endcan
                    @can('Reportes_Tigo_Index')
                        <li>
                            <a href="{{ url('reportestigo') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-pie-chart">
                                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                    <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                </svg>
                                Reportes Tigo</a>
                        </li>
                    @endcan
                    <li>
                        <a href="{{ url('movimientos') }}">
                            <i class="fa-solid fa-book"></i>
                            Reportes Movimientos</a>
                    </li>
                </ul>
            </div>
        @else
            <div class="submenu" id="tigomoney">
                <ul class="submenu-list" data-parent-element="#app">
                    @can('Tigo_Money_Index')
                        <li>
                            <a href="{{ url('tigomoney') }}">
                                <img src="{{ asset('storage/icons/transfer.png') }}" alt="Transacciones" width="25px">
                                Nueva Transacción </a>
                        </li>
                    @endcan
                    @can('Origen_Index')
                        <li>
                            <a href="{{ url('origenes') }}">
                                <img src="{{ asset('storage/icons/origen.png') }}" alt="Origen CRUD" width="25px">
                                Origen CRUD </a>
                        </li>
                    @endcan
                    @can('Motivo_Index')
                        <li>
                            <a href="{{ url('motivos') }}">
                                <img src="{{ asset('storage/icons/motivo.png') }}" alt="Motivo CRUD" width="25px">
                                Motivo CRUD </a>
                        </li>
                    @endcan
                    @can('Comision_Index')
                        <li>
                            <a href="{{ url('comisiones') }}">
                                <img src="{{ asset('storage/icons/comision.png') }}" alt="Comision CRUD" width="25px">
                                Comisión CRUD </a>
                        </li>
                    @endcan
                    @can('Origen_Mot_Index')
                        <li>
                            <a href="{{ url('origen-motivo') }}">
                                <img src="{{ asset('storage/icons/comision.png') }}" alt="Comision CRUD" width="25px">
                                Origen motivo </a>
                        </li>
                    @endcan
                    @can('Origen_Mot_Com_Index')
                        <li>
                            <a href="{{ url('origen-motivo-comision') }}">
                                <img src="{{ asset('storage/icons/comision.png') }}" alt="Comision CRUD" width="25px">
                                Origen motivo comisiones</a>
                        </li>
                    @endcan
                    @can('Jornada_Tigo_Index')
                        <li>
                            <a href="{{ url('ReporteJornalTM') }}">
                                <i class="fa-solid fa-baht-sign"></i>
                                Reporte Jornada T.M.</a>
                        </li>
                    @endcan
                    @can('Arqueos_Tigo_Index')
                        <li>
                            <a href="{{ url('arqueostigo') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-dollar-sign">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                Arqueos Tigo</a>
                        </li>
                    @endcan

                    @can('Reportes_Tigo_Index')
                        <li>
                            <a href="{{ url('reportestigo') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-pie-chart">
                                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                    <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                </svg>
                                Reportes Tigo</a>
                        </li>
                    @endcan
                    <li>
                        <a href="{{ url('movimientos') }}">
                            <i class="fa-solid fa-book"></i>
                            Reportes Movimientos</a>
                    </li>
                </ul>
            </div>
        @endif

        @if (empty(session('sesionCaja')))
            <div class="submenu" id="streaming">
                <ul class="submenu-list" data-parent-element="#app">
                    <li>
                        <strong>
                            <p> No tiene una caja abierta </p>
                            <p> para vender planes </p>
                        </strong>
                    </li>
                    @can('Cuentas_Index')
                        <li>
                            <a href="{{ url('cuentas') }}">
                                <i class="fa-solid fa-address-book"></i>
                                Cuentas </a>
                        </li>
                    @endcan
                    @can('Perfiles_Index')
                        <li>
                            <a href="{{ url('perfiles') }}">
                                <i class="fa-solid fa-address-book"></i>
                                Perfiles </a>
                        </li>
                    @endcan
                    @can('Plataforma_Index')
                        <li>
                            <a href="{{ url('plataformas') }}">
                                <img src="{{ asset('storage/icons/cuentas.png') }}" alt="Origen CRUD" width="25px">
                                Plataformas </a>
                        </li>
                    @endcan
                    @can('Proveedor_Index')
                        <li>
                            <a href="{{ url('strproveedores') }}">
                                <i class="fa-solid fa-user-pen"></i>
                                Proveedores </a>
                        </li>
                    @endcan
                    @can('Correos_Index')
                        <li>
                            <a href="{{ url('emails') }}">
                                <i class="fa-regular fa-envelope"></i>
                                Correos </a>
                        </li>
                    @endcan
                    @can('Reportes_Streaming_Index')
                        <li>
                            <a href="{{ url('reportStreaming') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-pie-chart">
                                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                    <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                </svg>
                                Reportes Streaming </a>
                        </li>
                    @endcan
                </ul>
            </div>
        @else
            <div class="submenu" id="streaming">
                <ul class="submenu-list" data-parent-element="#app">
                    @can('Planes_Index')
                        <li>
                            <a href="{{ url('planes') }}">
                                <i class="fa-regular fa-calendar-plus"></i>
                                Nuevo Plan </a>
                        </li>
                    @endcan
                    @can('Cuentas_Index')
                        <li>
                            <a href="{{ url('cuentas') }}">
                                <i class="fa-solid fa-address-book"></i>
                                Cuentas </a>
                        </li>
                    @endcan
                    @can('Perfiles_Index')
                        <li>
                            <a href="{{ url('perfiles') }}">
                                <i class="fa-solid fa-address-book"></i>
                                Perfiles </a>
                        </li>
                    @endcan
                    @can('Plataforma_Index')
                        <li>
                            <a href="{{ url('plataformas') }}">
                                <img src="{{ asset('storage/icons/cuentas.png') }}" alt="Origen CRUD" width="25px">
                                Plataformas </a>
                        </li>
                    @endcan
                    @can('Proveedor_Index')
                        <li>
                            <a href="{{ url('strproveedores') }}">
                                <i class="fa-solid fa-user-pen"></i>
                                Proveedores </a>
                        </li>
                    @endcan
                    @can('Correos_Index')
                        <li>
                            <a href="{{ url('emails') }}">
                                <i class="fa-regular fa-envelope"></i>
                                Correos </a>
                        </li>
                    @endcan
                    {{-- @can('Arqueos_Streaming_Index')
                        <li>
                            <a href="{{ url('arqueosStreaming') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-dollar-sign">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                Arqueos Streaming </a>
                        </li>
                    @endcan --}}
                    @can('Reportes_Streaming_Index')
                        <li>
                            <a href="{{ url('reportStreaming') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-pie-chart">
                                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                    <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                </svg>
                                Reportes Streaming </a>
                        </li>
                    @endcan
                    <li>
                        <a href="{{ url('reportGananciaStreaming') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-pie-chart">
                                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                            </svg>
                            Reportes Ganancias Streaming </a>
                    </li>
                </ul>
            </div>
        @endif
        {{-- <div class="submenu" id="notificaciones">
            <ul class="submenu-list" data-parent-element="#uiKit">
                <li>
                    <a href="{{ url('modulos') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-users">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        Modulos </a>
                </li>

                <li>
                    <a href="{{ url('modulos') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-users">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        Modulos </a>
                </li>
            </ul>
        </div> --}}

        <div class="submenu" id="servicio">
            <ul class="submenu-list" data-parent-element="servicio">
                @can('Cat_Prod_Service_Index')
                    <li>
                        <a href="{{ url('catprodservice') }}">
                            <i class="fa-solid fa-laptop"></i>
                            Categoria Equipo </a>
                    </li>
                @endcan
                @can('SubCat_Prod_Service_Index')
                    <li>
                        <a href="{{ url('subcatprodservice') }}">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                            Sub Categ. Equipo </a>
                    </li>
                @endcan
                @can('Type_Work_Index')
                    <li>
                        <a href="{{ url('typework') }}">
                            <i class="fa-regular fa-file-lines"></i>
                            Tipo de Trabajo </a>
                    </li>
                @endcan
                @can('Orden_Servicio_Index')
                    <li>
                        <a href="{{ url('orderservice') }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Orden de Servicio </a>
                    </li>
                @endcan
                @can('Reporte_Servicios_Index')
                    <li>
                        <a href="{{ url('reporteservices') }}">
                            <i class="fa-regular fa-clipboard"></i>
                            Reporte de Servicios </a>
                    </li>
                @endcan
                @can('Boton_Entregar_Servicio')
                    <li>
                        <a href="{{ url('reportentregservices') }}">
                            <i class="fa-regular fa-clipboard"></i>
                            Repor. Servi. Entregados </a>
                    </li>
                @endcan
            </ul>
        </div>
        <div class="submenu" id="inventario">
            <ul class="submenu-list" data-parent-element="inventario">

                <li>
                    <a href="{{ url('categories') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                            <polyline points="2 17 12 22 22 17"></polyline>
                            <polyline points="2 12 12 17 22 12"></polyline>
                        </svg>
                        Categorias </a>
                </li>

                <li>
                    <a href="{{url('products')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        Productos </a>
                </li>

                <li>
                    <a href="{{url('transacciones')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-repeat"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>
                        Devolucion en Compras</a>
                </li>

                <li>
                    <a href="{{url('proveedores')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Proveedores</a>
                </li>
                <li>
                    <a href="{{url('compras')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        Compras</a>
                </li>
                <li>
                    <a href="{{url('destino_prod')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                        Almacen Producto</a>
                </li>
            </ul>
        </div>
        <div class="submenu" id="parametros">
            <ul class="submenu-list" data-parent-element="app">

                <li>
                    <a href="{{ url('unidades') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                            <polyline points="2 17 12 22 22 17"></polyline>
                            <polyline points="2 12 12 17 22 12"></polyline>
                        </svg>
                        Unidades </a>
                </li>
                <li>
                    <a href="{{url('locations')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-watch"><circle cx="12" cy="12" r="7"></circle><polyline points="12 9 12 12 13.5 13.5"></polyline><path d="M16.51 17.35l-.35 3.83a2 2 0 0 1-2 1.82H9.83a2 2 0 0 1-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 0 1 9.83 1h4.35a2 2 0 0 1 2 1.82l.35 3.83"></path></svg>    
                    Mobiliario</a>
                </li>

                <li>
                    <a href="{{ url('marcas') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-watch">
                            <circle cx="12" cy="12" r="7"></circle>
                            <polyline points="12 9 12 12 13.5 13.5"></polyline>
                            <path
                                d="M16.51 17.35l-.35 3.83a2 2 0 0 1-2 1.82H9.83a2 2 0 0 1-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 0 1 9.83 1h4.35a2 2 0 0 1 2 1.82l.35 3.83">
                            </path>
                        </svg>
                        Marcas</a>
                </li>
                <li>
                    <a href="{{url('destino')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-watch"><circle cx="12" cy="12" r="7"></circle><polyline points="12 9 12 12 13.5 13.5"></polyline><path d="M16.51 17.35l-.35 3.83a2 2 0 0 1-2 1.82H9.83a2 2 0 0 1-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 0 1 9.83 1h4.35a2 2 0 0 1 2 1.82l.35 3.83"></path></svg>    
                    Locacion/Estancia</a>
                </li>

            </ul>
        </div>

        <div class="submenu" id="registro">
            <ul class="submenu-list" data-parent-element="#components">
                @can('Roles_Index')
                    <li>
                        <a href="{{ url('roles') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            Roles </a>
                    </li>
                @endcan
                @can('Permission_Index')
                    <li>
                        <a href="{{ url('permisos') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-user-check">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <polyline points="17 11 19 13 23 9"></polyline>
                            </svg>
                            Permisos </a>
                    </li>
                @endcan
                @can('Asignar_Index')
                    <li>
                        <a href="{{ url('asignar') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="user-plus" class="svg-inline--fa fa-user-plus fa-w-20" role="img"
                                viewBox="0 0 640 512">
                                <path fill="currentColor"
                                    d="M624 208h-64v-64c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v64h-64c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h64v64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-64h64c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm-400 48c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" />
                            </svg>
                            Asignar permisos </a>
                    </li>
                @endcan
                @can('Usuarios_Index')
                    <li>
                        <a href="{{ url('users') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="user" class="svg-inline--fa fa-user fa-w-14" role="img" viewBox="0 0 448 512">
                                <path fill="currentColor"
                                    d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" />
                            </svg>
                            Usuarios </a>
                    </li>
                @endcan
                @can('Cliente_Index')
                    <li>
                        <a href="{{ url('clientes') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="user-tag" class="svg-inline--fa fa-user-tag fa-w-20" role="img"
                                viewBox="0 0 640 512">
                                <path fill="currentColor"
                                    d="M630.6 364.9l-90.3-90.2c-12-12-28.3-18.7-45.3-18.7h-79.3c-17.7 0-32 14.3-32 32v79.2c0 17 6.7 33.2 18.7 45.2l90.3 90.2c12.5 12.5 32.8 12.5 45.3 0l92.5-92.5c12.6-12.5 12.6-32.7.1-45.2zm-182.8-21c-13.3 0-24-10.7-24-24s10.7-24 24-24 24 10.7 24 24c0 13.2-10.7 24-24 24zm-223.8-88c70.7 0 128-57.3 128-128C352 57.3 294.7 0 224 0S96 57.3 96 128c0 70.6 57.3 127.9 128 127.9zm127.8 111.2V294c-12.2-3.6-24.9-6.2-38.2-6.2h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 287.9 0 348.1 0 422.3v41.6c0 26.5 21.5 48 48 48h352c15.5 0 29.1-7.5 37.9-18.9l-58-58c-18.1-18.1-28.1-42.2-28.1-67.9z" />
                            </svg>
                            Clientes </a>
                    </li>
                @endcan
                @can('Procedencia_Index')
                    <li>
                        <a href="{{ url('procedenciaCli') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="user-tag" class="svg-inline--fa fa-user-tag fa-w-20" role="img"
                                viewBox="0 0 640 512">
                                <path fill="currentColor"
                                    d="M630.6 364.9l-90.3-90.2c-12-12-28.3-18.7-45.3-18.7h-79.3c-17.7 0-32 14.3-32 32v79.2c0 17 6.7 33.2 18.7 45.2l90.3 90.2c12.5 12.5 32.8 12.5 45.3 0l92.5-92.5c12.6-12.5 12.6-32.7.1-45.2zm-182.8-21c-13.3 0-24-10.7-24-24s10.7-24 24-24 24 10.7 24 24c0 13.2-10.7 24-24 24zm-223.8-88c70.7 0 128-57.3 128-128C352 57.3 294.7 0 224 0S96 57.3 96 128c0 70.6 57.3 127.9 128 127.9zm127.8 111.2V294c-12.2-3.6-24.9-6.2-38.2-6.2h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 287.9 0 348.1 0 422.3v41.6c0 26.5 21.5 48 48 48h352c15.5 0 29.1-7.5 37.9-18.9l-58-58c-18.1-18.1-28.1-42.2-28.1-67.9z" />
                            </svg>
                            Procedencia Clientes </a>
                    </li>
                @endcan
                @can('Empresa_Index')
                    <li>
                        <a href="{{ url('companies') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="user-plus" class="svg-inline--fa fa-user-plus fa-w-20" role="img"
                                viewBox="0 0 640 512">
                                <path fill="currentColor"
                                    d="M624 208h-64v-64c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v64h-64c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h64v64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-64h64c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm-400 48c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" />
                            </svg>
                            Empresas </a>
                    </li>
                @endcan
                @can('Sucursal_Index')
                    <li>
                        <a href="{{ url('sucursales') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="user-plus" class="svg-inline--fa fa-user-plus fa-w-20" role="img"
                                viewBox="0 0 640 512">
                                <path fill="currentColor"
                                    d="M624 208h-64v-64c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v64h-64c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h64v64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-64h64c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm-400 48c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" />
                            </svg>
                            Sucursales </a>
                    </li>
                @endcan
                @can('Caja_Index')
                    <li>
                        <a href="{{ url('cajas') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="user-plus" class="svg-inline--fa fa-user-plus fa-w-20" role="img"
                                viewBox="0 0 640 512">
                                <path fill="currentColor"
                                    d="M624 208h-64v-64c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v64h-64c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h64v64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-64h64c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm-400 48c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" />
                            </svg>
                            Cajas </a>
                    </li>
                @endcan
                @can('Cartera_Index')
                    <li>
                        <a href="{{ url('carteras') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="user-plus" class="svg-inline--fa fa-user-plus fa-w-20" role="img"
                                viewBox="0 0 640 512">
                                <path fill="currentColor"
                                    d="M624 208h-64v-64c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v64h-64c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h64v64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-64h64c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm-400 48c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" />
                            </svg>
                            Cartera </a>
                    </li>
                @endcan
                @can('Corte_Caja_Index')
                    <li>
                        <a href="{{ url('cortecajas') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="user-plus" class="svg-inline--fa fa-user-plus fa-w-20" role="img"
                                viewBox="0 0 640 512">
                                <path fill="currentColor"
                                    d="M624 208h-64v-64c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v64h-64c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h64v64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-64h64c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm-400 48c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" />
                            </svg>
                            Corte caja </a>
                    </li>
                @endcan
            </ul>
        </div>

        <div class="submenu" id="ventas">
            <ul class="submenu-list" data-parent-element="ventas">




                @if (empty(session('sesionCaja')))
                <li>
                    <strong>
                    <p> No tiene una caja abierta </p>
                    </strong>
                </li>
                @else


                <li>
                    <a href="{{ url('pos') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-shopping-cart">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        Nueva Venta </a>
                </li>

                <li>
                    <a href="{{ url('salelist') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                        Lista de Ventas</a>
                </li>

                <li>
                    <a href="{{ url('categories') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                            <polyline points="2 17 12 22 22 17"></polyline>
                            <polyline points="2 12 12 17 22 12"></polyline>
                        </svg>
                        Categorias </a>
                </li>

                <li>
                    <a href="{{ url('products') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-watch">
                            <circle cx="12" cy="12" r="7"></circle>
                            <polyline points="12 9 12 12 13.5 13.5"></polyline>
                            <path
                                d="M16.51 17.35l-.35 3.83a2 2 0 0 1-2 1.82H9.83a2 2 0 0 1-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 0 1 9.83 1h4.35a2 2 0 0 1 2 1.82l.35 3.83">
                            </path>
                        </svg>
                        Productos </a>
                </li>

                <li>
                    <a href="{{ url('coins') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-stop-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <rect x="9" y="9" width="6" height="6"></rect>
                        </svg>
                        Denominaciones </a>
                </li>
                <li>
                    <a href="{{ url('estadisticas') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        Estadísticas </a>
                </li>
                <li>
                    <a href="{{ url('devolucionventa') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
                        Devolución Ventas </a>
                </li>
                <li>
                    <a href="{{ url('salemovimientodiario') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                        Movimiento Diario </a>
                </li>



                <li class="sub-submenu">
                    <a role="menu" class="collapsed" data-toggle="collapse" data-target="#datatables" aria-expanded="false"><div><span class="icon">


                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-crosshair"><circle cx="12" cy="12" r="10"></circle><line x1="22" y1="12" x2="18" y2="12"></line><line x1="6" y1="12" x2="2" y2="12"></line><line x1="12" y1="6" x2="12" y2="2"></line><line x1="12" y1="22" x2="12" y2="18"></line></svg>
                    
                    </span> Reportes</div> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                    <ul id="datatables" class="collapse" data-parent="#compact_submenuSidebar">
                        <li>
                            <a href="table_dt_basic.html"> Ventas por Mes </a>
                        </li>
                        <li>
                            <a href="table_dt_basic-dark.html"> Ventas por Usuario </a>
                        </li>
                    </ul>
                </li>




                {{-- <li class="sub-submenu">
                    <a role="menu" class="collapsed" data-toggle="collapse" data-target="#datatables"
                     aria-expanded="false"><div><span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
                        
                    </span> Devolución Ventas</div> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                    <ul id="datatables" class="collapse" data-parent="#compact_submenuSidebar">
                        <li>
                            <a href="{{ url('#') }}"> Por Venta </a>
                        </li>
                        <li>
                            <a href="{{ url('devolucionventa') }}"> Por Producto </a>
                        </li>
                    </ul>
                </li> --}}
                @endif

            </ul>
        </div>

        <div class="submenu" id="contabilidad">
            <ul class="submenu-list" data-parent-element="contabilidad">
                <li>
                    <a href="{{ url('cashout') }}"><span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-dollar-sign">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </span> Arqueos </a>
                </li>

                <li>
                    <a href="{{ url('reports') }}"><span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-pie-chart">
                                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                            </svg>
                        </span> Reportes </a>
                </li>
            </ul>
        </div>
    </div>

</div>
