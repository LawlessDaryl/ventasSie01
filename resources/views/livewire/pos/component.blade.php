<div class="row sales layout-top-spacing">
    <div class="col-sm-12" >

            <!-- Secciones para las Ventas -->
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <div class="col-12 col-lg-12 col-md-10 mt-3">

                        <!-- Titulo Detalle Venta -->
                            <div class="row mb-4" >
                                <div class="col-sm-12" >

                                    <h5 class="mb-2 mt-2">DETALLE DE VENTA</h5>
                                    <b>Fecha: </b>
                                    <?php
                                    $DateAndTime = date('d-m-Y', time());  
                                    echo " $DateAndTime.";
                                    ?><br/>  
                                    {{-- <b>Registrado por: </b> 
                                    EMANUEL<br/> --}}

                                    
                                    {{-- <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" /> --}}

                                </div>
                            </div>
                        <!-- Datos de las Ventas -->
                        @include('livewire.pos.partials.total')


                    </div>
                </div>


                <!-- linea Divisoria -->
                {{-- <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" /> --}}
                <!-- ------------ -->




                {{-- <blockquote class="blockquote media-object">
                    <div class="media">
                        <h5>Hola</h5>
                    </div>
                </blockquote> --}}


                <div class="col-12 col-lg-12 col-md-10 mt-3">
                    <div class="row">
                        <!-- Cuadro de Busqueda de Productos -->
                        <div class="col-12 col-md-3 col-lg-6" style="border-left: thick solid #b4b4b1;" >

                            <div class="input-group mb-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-gp">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" wire:model="nombreproducto" placeholder="Buscar Producto..." class="form-control">
                            </div>

                        </div>
                        <!-- Sección de Busqueda y Seleccion del Cliente -->
                        @include('livewire.pos.partials.client')
                    </div>
                </div>

                 
                <br>
                <div class="widget-content">
                    <div class="row">
                        <!-- Cuadros de Productos Encontrados Manualmente -->
                        @include('livewire.pos.partials.product')
                        <!-- Cuadros de Productos para Vender Shopping Cart -->
                        @include('livewire.pos.partials.detail')
                    </div>
                </div> 
                <!-- linea Divisoria -->
                {{-- <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" /> --}}
                <!-- -------- -->
            @include('livewire.pos.partials.coins')


            </div>
            
            <!-- Ventana Modal para Avisar que ya no hay Stock en Tienda -->
            <div wire:ignore.self class="text-center">
                <div id="modalVerticallyCentered" class="col-lg-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark">
                                            <h5 class="modal-title" style="color: aliceblue" id="exampleModalCenterTitle">Aviso</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h4 style="color: rgb(0, 0, 0)" class="modal-heading mb-4 mt-2">Stock Insuficiente en Tienda</h4>




                                            
                                                <h6 class="modal-text" style="color: rgb(0, 0, 0)">
                                                    No se encontraron mas Productos en la TIENDA. Pero en ALMACEN se encontraron {{$stockalmacen}} Unidad(s) del Producto:
                                                    <br>
                                                    <br>
                                                    "{{$nombrestockproducto}}"
                                                    <br>
                                                    <br>
                                                    ¿Desea Agregarlos al Carrito?
                                                </h6>
                                                    <center>
                                                        <div class="col-lg-5">
                                                            <input type="text" min="1" max="{{$stockalmacen}}" wire:model.lazy="cantidadToTienda" class="form-control">
                                                            {{-- @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror --}}
                                                        </div>
                                                    </center>
                                                    
                                                    

                                                    <br>


                                                    <strong style="color: red">¡AVISO!</strong> 
                                                    <p style="color: red">
                                                        Esta acciòn movera productos de la Tabla Almacen a la Tabla Tienda
                                                    </p>


                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> No</button>
                                            <button type="button" data-dismiss="modal" class="btn btn-primary" wire:click.prevent="almacenToTienda()" >Si</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ventana Modal para Finalizar la Venta -->
            <div wire:ignore.self class="modal fade" id="ModalCenterFinalizarVenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-dark">
                            <h5 class="modal-title" style="color: aliceblue" id="exampleModalCenterTitle">Finalizar Venta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <div class="connect-sorting">
                                        <h5 class="text-center mb-2">Monedas</h5>
                                        <div class="container">
                                            <div class="row">
                                                @foreach ($denominations as $d)
                                                    <div class="col-sm mt-2">
                                                        <button wire:click.prevent="ACash({{ $d->value }})" class="btn btn-dark btn-block den">
                                                            {{ $d->value > 0 ? 'Bs'. number_format($d->value, 2, '.', '') : 'Exacto'}}
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="connect-sorting-content mt-4">
                                            <div class="card simple-title-task ui-sortable-handle">
                                                <div class="card-body">
                                                    <div class="input-group input-group-md mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text input-gp hideonsm" 
                                                            style="background:#3B3F5C; color:white">Efectivo F8
                                                            </span>
                                                        </div>
                                                        <input type="number" id="cash" wire:model="efectivo" wire:keydown.enter="saveSale"
                                                            class="form-control text-center" value="{{ $efectivo }}">
                                                        <div class="input-group-append">
                                                            <span wire:click="$set('efectivo',0)" class="input-group-text"
                                                                style="background:#3B3F5C; color:white">
                                                                <i class="fas fa-backspace fa-2x"></i>
                                                            </span>

                                                        </div>
                                                    </div>
                                                    <h4 class="text-muted">Cambio: ${{ number_format($change, 2) }}</h4>
                                                    <div class="row justify-content-between mt-5">
                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            @if ($total > 0)
                                                                <button  data-dismiss="modal" onclick="Confirm('','clearCart','¿Seguro de eliminar el carrito?')"
                                                                    class="btn btn-dark mtmobile">
                                                                    CANCELAR F4
                                                                </button>
                                                            @endif
                                                        </div>



                                                        {{-- <a class="btn btn-dark btn-block {{count($denominations) < 1 ? 'disabled' : ''}}" 
                                                        href="{{ url('report/pdf' . '/' . $total. '/' . $idventa . '/' . Auth()->user()->id)}}">Generar Comprobante</a> --}}




                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            @if($efectivo>=$total&&$total>0)
                                                            <button wire:click.prevent="saveSale" data-dismiss="modal" class="btn btn-dark btn-md btn-block" 
                                                            href="{{ url('report/pdf' . '/' . $total. '/' . $idventa . '/' . Auth()->user()->id)}}">
                                                                FINALIZAR VENTA
                                                            </button>
                                                                @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>



    @include('livewire.pos.scripts.events')
    @include('livewire.pos.scripts.general')
    @include('livewire.pos.scripts.scan')
    @include('livewire.pos.scripts.shortcuts')
