@section('css')

{{-- Estilos para las Notificaciones - Ventas --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
<link href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/apps/contacts.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- <div class="page-header">
    <div class="page-title">
        <h3>Notificaciones</h3>
    </div>
</div> --}}

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
                            <h4> Notificación</h4>
                        </div>
                        <div class="user-email">
                            <h4>Usuario</h4>
                        </div>
                        <div class="user-location">
                            <h4 style="margin-left: 0;">Sucursal</h4>
                        </div>
                        <div class="user-location">
                            <h4 style="margin-left: 0;">Fecha</h4>
                        </div>
                        <div class="user-phone">
                            <h4 style="margin-left: 3px;">Detalles</h4>
                        </div>
                        {{-- <div class="action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2  delete-multiple"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </div> --}}
                    </div>
                </div>



                @foreach ($notificacion as $noti)
            


                
            <!-- Modal -->
            <div wire:ignore.self class="modal fade" id="exampleModalCenter{{$noti->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Usuario Responsable: {{$this->buscarusuario($noti->idusuario)}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h4 class="modal-heading mb-4 mt-2">{{$noti->nn}}</h4>
                                <p class="modal-text">
                                    {{$noti->m}}
                                    <br>
                                    <br>
                                    Dirección: {{$this->buscarsucursal($noti->sucursal_id)}}
                                </p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>



                @if($noti->estado == "VISTO")
                <div class="items">
                    <div class="item-content">
                        {{-- <div class="item-content" style="background-color: rgb(240, 231, 212)"> --}}
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
                            <p class="usr-email-addr" data-email="alan@mail.com">{{$this->buscarusuario($noti->idusuario)}}</p>
                        </div>
                        <div class="user-location">
                            <p class="info-title">Sucursal: </p>
                            <p class="usr-location" data-location="Boston, USA">{{$this->buscarsucursal($noti->sucursal_id)}}</p>
                        </div>
                        <div class="user-location">
                            <p class="info-title">Fecha: </p>
                            <p class="usr-location" data-location="Boston, USA">{{ $noti->fechanoti}}</p>
                        </div>
                        <div class="user-phone">
                            <p class="info-title">Ver Detalles: </p>

                            <button wire:click="quitarnovisto({{ $noti->id }})" type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#exampleModalCenter{{$noti->id}}">
                                Ver Detalles
                              </button>

                        </div>
                        
                    </div>
                </div>
                @else

                <div class="items">
                    <div style="background-color: rgb(240, 231, 212)"  class="item-content">
                        {{-- <div class="item-content" style="background-color: rgb(240, 231, 212)"> --}}
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
                            <p class="usr-email-addr" data-email="alan@mail.com">{{$this->buscarusuario($noti->idusuario)}}</p>
                        </div>
                        <div class="user-location">
                            <p class="info-title">Sucursal: </p>
                            <p class="usr-location" data-location="Boston, USA">{{$this->buscarsucursal($noti->sucursal_id)}}</p>
                        </div>
                        <div class="user-location">
                            <p class="info-title">Fecha: </p>
                            <p class="usr-location" data-location="Boston, USA">{{ $noti->fechanoti}}</p>
                        </div>
                        <div class="user-phone">
                            <p class="info-title">Ver Detalles: </p>

                            <button wire:click="quitarnovisto({{ $noti->id }})" type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#exampleModalCenter{{$noti->id}}">
                                Ver Detalles
                              </button>

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















