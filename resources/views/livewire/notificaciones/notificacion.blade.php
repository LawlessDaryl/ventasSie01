@section('css')

{{-- Estilos para las Notificaciones - Ventas --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
<link href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/apps/contacts.css') }}" rel="stylesheet" type="text/css" />
@endsection

<div class="page-header">
    <div class="page-title">
        <h3>Notificaciones</h3>
    </div>
</div>

<div class="row layout-spacing layout-top-spacing" id="cancel-row">
    <div class="col-lg-12">
        <div class="widget-content searchable-container list">

            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-5 col-sm-7 filtered-list-search layout-spacing align-self-center">
                    <form class="form-inline my-2 my-lg-0">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" class="form-control product-search" id="input-search" placeholder="Buscar Notificaciones...">
                        </div>
                    </form>
                </div>

                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-5 text-sm-right text-center layout-spacing align-self-center">
                    <div class="d-flex justify-content-sm-end justify-content-center">
                        <div class="switch align-self-center">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                            class="feather feather-list view-list active-view"><line x1="8" y1="6" x2="21" y2="6"></line>
                            <line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line>
                            <line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line>
                            <line x1="3" y1="18" x2="3" y2="18"></line></svg>


                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                            stroke-linejoin="round" class="feather feather-grid view-grid">
                            <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7">
                                </rect><rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect></svg>

                                
                        </div>
                    </div>
                    <br>
                    <br>
                 
                    

                </div>
            </div>

            <div class="searchable-items list">
                <div class="items items-header-section">
                    <div class="item-content">
                        <div class="">
                            <div class="n-chk align-self-center text-center">
                                <label class="new-control new-checkbox checkbox-primary">
                                  <input type="checkbox" class="new-control-input" id="contact-check-all">
                                  <span class="new-control-indicator"></span>
                                </label>
                            </div>
                            <h4> Nombre/Tipo de la Notificación</h4>
                        </div>
                        <div class="user-email">
                            <h4>Usuario</h4>
                        </div>
                        <div class="user-location">
                            <h4 style="margin-left: 0;">Sucursal</h4>
                        </div>
                        <div class="user-phone">
                            <h4 style="margin-left: 3px;">Ver Detalles</h4>
                        </div>
                        <div class="action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2  delete-multiple"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </div>
                    </div>
                </div>



                @foreach ($notificacion as $noti)
                @if($noti->nn == "NOVISTO")
                <div class="items">
                    <div class="item-content">
                        <div class="user-profile">
                            <div class="n-chk align-self-center text-center">
                                <label class="new-control new-checkbox checkbox-primary">
                                  <input type="checkbox" class="new-control-input contact-chkbox">
                                  <span class="new-control-indicator"></span>
                                </label>
                            </div>
                            <img src="assets/img/mv.jpg" alt="avatar">
                            <div class="user-meta-info">
                                <p class="user-name" data-name="Alan Green">{{$noti->m}}</p>
                                <p class="user-work" data-occupation="Web Developer">Web Developer</p>
                            </div>
                        </div>
                        <div class="user-email">
                            <p class="info-title">Email: </p>
                            <p class="usr-email-addr" data-email="alan@mail.com">alan@mail.com</p>
                        </div>
                        <div class="user-location">
                            <p class="info-title">Location: </p>
                            <p class="usr-location" data-location="Boston, USA">Boston, USA</p>
                        </div>
                        <div class="user-phone">
                            <p class="info-title">Phone: </p>
                            <p class="usr-ph-no" data-phone="+1 (070) 123-4567">+1 (070) 123-4567</p>
                        </div>
                        <div class="action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 edit"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-minus delete"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                        </div>
                    </div>
                </div>
                @else


                <!-- Modal Para dar Detalles de la Notificación -->
                <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                                <div class="add-contact-box">
                                    <div class="add-contact-content">
                                        <form id="addContactModalTitle">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="contact-name text-center">
                                                        
                                                        <h4>{{$noti->nn}}</h4>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="contact-name text-center">
                                                        <p>{{$noti->m}}</p>
                                                    </div>
                                                </div>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"> <i class="flaticon-delete-1"></i> Cerrar Ventana</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="items">
                    <div class="item-content">
                        <div class="user-profile">
                            <div class="n-chk align-self-center text-center">
                                <label class="new-control new-checkbox checkbox-primary">
                                  <input type="checkbox" class="new-control-input contact-chkbox">
                                  <span class="new-control-indicator"></span>
                                </label>
                            </div>
                            <img src="assets/img/mv.jpg" alt="avatar">
                            <div class="user-meta-info">
                                <p class="user-name" data-name="Alan Green">{{$noti->nn}}</p>
                                <p class="user-work" data-occupation="Web Developer">Aviso</p>
                            </div>
                        </div>
                        <div class="user-email">
                            <p class="info-title">Usuario: </p>
                            <p class="usr-email-addr" data-email="alan@mail.com">Emanuel</p>
                        </div>
                        <div class="user-location">
                            <p class="info-title">Sucursal: </p>
                            <p class="usr-location" data-location="Boston, USA">{{ $noti->fechanoti}}</p>
                        </div>
                        <div class="user-phone">
                            <p class="info-title">Ver Detalles: </p>
                            <p class="usr-ph-no" data-phone="+1 (070) 123-4567">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                            class="feather feather-edit-2 edit">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                               <circle cx="12" cy="12" r="3"></circle></svg>
                            </p>
                        </div>
                        <div class="action-btn">


                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                            class="feather feather-edit-2 edit">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                </path></svg>

                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-minus delete"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="23" y1="11" x2="17" y2="11"></line></svg> --}}
                        
                        </div>
                    </div>
                </div>
                @endif
                @endforeach




            </div>

        </div>
    </div>
</div>
</div>






@section('javascript')
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/apps/contact.js') }}"></script>
@endsection















