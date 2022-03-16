<div>
    <div class="row">
        <!-- Datos Cliente -->
        <div class="col-sm-12 col-md-12">
            @include('livewire.pos.partials.client')
        </div>
        <!-- Tabla Productos (Shopping Cart) -->
        <div class="col-sm-12 col-md-8">
            @include('livewire.pos.partials.detail')
        </div>
        <!-- Cuadro Total Bs y Monedas -->
        <div class="col-sm-12 col-md-4">
            @include('livewire.pos.partials.total')
            {{-- denominaciones --}}
            @include('livewire.pos.partials.coins')
        </div>
    </div>
    
{{-- Ventana Modal para Avisar que ya no hay Stock en Tienda--}}
<div class="text-center">
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

</div>

    @include('livewire.pos.scripts.events')
    @include('livewire.pos.scripts.general')
    @include('livewire.pos.scripts.scan')
    @include('livewire.pos.scripts.shortcuts')
