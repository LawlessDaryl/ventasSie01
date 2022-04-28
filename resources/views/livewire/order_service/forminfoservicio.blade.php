<div wire:ignore.self class="modal fade" id="theInfoService" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <div class="modal-body bg-dark">

              
                        <div class="col-xl-12 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">

                            <div class="user-profile layout-spacing">
                                <div class="widget-content widget-content-area">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="">Información del Servicio</h3>
                                        <a class="mt-2 edit-profile"> 
                                            <svg wire:click.prevent="resetUI()" data-dismiss="modal" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                            
                                        </a>
                                    </div>
                                    
                                    <div class="text-center user-info">
                                        @if($variable == true)
                                            <h6 class=""><b>Responsable: </b>{{$nomUsuTerm}}</h6>
                                        @elseif($variable == false)
                                            <h6 class=""><b>Responsable: </b>{{$nombreUsuario}}</h6>
                                        @endif
                                        <p class=""><b>Cliente: </b>{{$nombreCliente}}</p>
                                        <h6><b>Celular: </b>{{$celular}}</h6>
                                        {{-- <h6><b>Fecha estimada entrega: </b>{{$fecha_estimada_entrega}} {{$hora_entrega}}</h6> --}}
                                    </div>

                                    <div class="user-info-list row">
                                        <div class="col-xl-8">
                                            <ul class="contacts-block list-unstyled">
                                                <li class="contacts-block__item" style="color:rgb(26, 25, 25)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                    class="feather feather-calendar">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                </svg><b>Fecha estimada entrega: </b>{{ \Carbon\Carbon::parse($fecha_estimada_entrega)->format('d/m/Y') }} {{ \Carbon\Carbon::parse($hora_entrega)->format('h:i:s') }}
                                                </li>
                                                <li class="contacts-block__item" style="color:rgb(26, 25, 25)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-battery-charging"><path d="M5 18H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h3.19M15 6h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-3.19"></path><line x1="23" y1="13" x2="23" y2="11"></line><polyline points="11 6 7 12 13 12 9 18"></polyline></svg><b>Tipo de Trabajo: </b>{{$typeworkid}} 
                                                </li>
                                                <li class="contacts-block__item" style="color:rgb(26, 25, 25)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                    class="feather feather-calendar">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                </svg><b>Detalle: </b>{{$catprodservid}} {{$marca}} {{$detalle}} {{$falla_segun_cliente}}
                                                </li>
                                                <li class="contacts-block__item" style="color:rgb(26, 25, 25)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg><b>Diagnostico: </b>{{$diagnostico}}
                                                </li>
                                                <li class="contacts-block__item" style="color:rgb(26, 25, 25)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg><b>Solución: </b>{{$solucion}}
                                                </li>
                                                <li class="contacts-block__item" style="color:rgb(26, 25, 25)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg><b>Detalle Costo: </b>{{$detalle_costo}}
                                                </li>
                                                {{--
                                                <li class="contacts-block__item">
                                                    <a href="mailto:example@mail.com">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                        class="feather feather-mail">
                                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                        <polyline points="22,6 12,13 2,6"></polyline>
                                                        </svg>Jimmy@gmail.com
                                                    </a>
                                                </li>
                                                
                                                <li class="contacts-block__item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                    class="feather feather-phone">
                                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                                    </svg> +1 (530) 555-12121
                                                </li>
                                                --}}
                                                {{--Íconos de Redes Sociales--}}
                                                {{--
                                                <li class="contacts-block__item">
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <div class="social-icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" 
                                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                                class="feather feather-facebook">
                                                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                                                </svg>
                                                            </div>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <div class="social-icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                                                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
                                                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                                                </svg>
                                                            </div>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <div class="social-icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                                                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-linkedin">
                                                                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                                                <rect x="2" y="9" width="4" height="12"></rect>
                                                                <circle cx="4" cy="4" r="2"></circle>
                                                                </svg>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </li>
                                                --}}
                                            </ul>
                                        </div>
                                        <div class="col-xl-4">
                                            <ul class="contacts-block list-unstyled">
                                                
                                                
                                                <li class="contacts-block__item" style="color:rgb(26, 25, 25)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg><b>Total: </b>{{$import}}
                                                </li>
                                                <li class="contacts-block__item" style="color:rgb(26, 25, 25)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg><b>A Cuenta: </b>{{$on_account}}
                                                </li>
                                                <li class="contacts-block__item" style="color:rgb(26, 25, 25)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg><b>Saldo: </b>{{$saldo}}
                                                </li>
                                                <li class="contacts-block__item" style="color:rgb(26, 25, 25)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg><b>Costo: </b>{{$costo}}
                                                </li>

                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
