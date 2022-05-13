


@section('css')


<!-- Estilo ventas Switches en Ventas -->
<link href="{{ asset('assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/switches.css') }}">



<style>
    .btn-flotante {
    font-size: 16px; /* Cambiar el tamaño de la tipografia */
    text-transform: uppercase; /* Texto en mayusculas */
    font-weight: bold; /* Fuente en negrita o bold */
    color: rgba(0, 0, 0, 0.9); /* Color del texto */
    border-radius: 5px; /* Borde del boton */
    letter-spacing: 2px; /* Espacio entre letras */
    background-color: rgba(255, 255, 255, 0.6); /* Color de fondo */
    padding: 18px 30px; /* Relleno del boton */
    position: fixed;
    top: 170px;
    right: 50px;
    transition: all 300ms ease 0ms;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    z-index: 99;
    }
    .btn-flotante:hover {
    background-color: #ffffff; /* Color de fondo al pasar el cursor */
    box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
    transform: translateY(-7px);
    }
    @media only screen and (max-width: 600px) {
        .btn-flotante {
        font-size: 14px;
        padding: 12px 20px;
        right: 20px;
        }
    }
</style>


@endsection



@if($this->verificarcajaabierta() > 0)
<div class="row sales layout-top-spacing">
    <div class="col-sm-12" >

            <!-- Secciones para las Ventas -->
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <div class="col-12 col-lg-12 col-md-10 mt-3">

                        <!-- Titulo Detalle Venta -->
                            <div class="row mb-4" >
                                <div class="col-sm-12" >

                                    
                                    
                                    
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
            <div wire:ignore.self class="modal fade text-center" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                            @error('cantidadToTienda')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
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
                                                    <h5 class="text-center">Total Venta: Bs {{ number_format($total, 2) }}</h5>
                                                    <div class="input-group input-group-md mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text input-gp hideonsm" 
                                                            style="background:#3B3F5C; color:white">Efectivo
                                                            </span>
                                                        </div>
                                                        <input type="number" id="cash" wire:model="efectivo" wire:keydown.enter="calcularCambio($('#cash').val())"
                                                            class="form-control text-center">

                                                            {{-- wire:change="precioventa({{$item->id}}, $('#pp' + {{$item->id}}).val(), $('#r' + {{$item->id}}).val() )" --}}

                                                        <div class="input-group-append">
                                                            <span wire:click="$set('efectivo',0)" class="input-group-text"
                                                                style="background:#3B3F5C; color:white">
                                                                <i class="fas fa-backspace fa-2x"></i>
                                                            </span>

                                                        </div>
                                                    </div>
                                                    @if ($efectivo>=$total&&$total>0)
                                                        <h5 class="text-center">Cambio: Bs {{ number_format($change, 2) }}</h5>
                                                    @else
                                                    {{$this->calcularCambio($total)}}
                                                    @endif
                                                    <div class="row justify-content-between mt-5">
                                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                                            @if ($total > 0)
                                                                <button  data-dismiss="modal" onclick="Confirm('','clearCart','¿Seguro de eliminar el carrito?')"
                                                                    class="btn btn-dark mtmobile">
                                                                    CANCELAR
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

    @if($descuento == 0)
    <a href="#" class="btn-flotante">Descuento {{$descuento}} Bs</a>
    @else
    
        @if($descuento > 0)
        <a href="#" class="btn-flotante">Descuento {{$descuento}} Bs</a>
        @else
        <a href="#" class="btn-flotante">Recargo {{$descuento*-1}} Bs</a>
        @endif

    @endif

</div>
@else

<div class="row sales layout-top-spacing">
    <div class="col-sm-12" >

            <!-- Secciones para las Ventas -->
            <div class="widget widget-chart-one">

                <div class="text-center">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <h1>No se selecciono ninguna caja</h1>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
     
                </div>
            </div>
    </div>

</div>

@endif








@include('livewire.pos.scripts.events')
@include('livewire.pos.scripts.general')
@include('livewire.pos.scripts.scan')
@include('livewire.pos.scripts.shortcuts')




@section('javascript')
<script src="assets/js/scrollspyNav.js"></script>
<script src="plugins/sweetalerts/sweetalert2.min.js"></script>
<script src="plugins/sweetalerts/custom-sweetalert.js"></script>

<script>




document.addEventListener('DOMContentLoaded', function() {
    
        // Mètodo JavaScript para llamar al modal de Espera
        window.livewire.on('modalespera', Msg => {
            
            swal({
                    title: 'Por Favor Espere a que la Venta Termine',
                    text: 'Generando Comprobante...',
                    timer: 7000,
                    padding: '2em',
                    onOpen: function () {
                    swal.showLoading()
                    }
                }).then(function (result) {
                    if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.timer
                    ) {
                    console.log('I was closed by the timer')
                    }
                })

        });



    })






    
</script>


@endsection