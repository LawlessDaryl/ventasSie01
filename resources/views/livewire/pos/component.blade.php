


@section('css')


<!-- Estilo ventas Switches en Ventas -->
<link href="{{ asset('assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/switches.css') }}">


<style>
    /* Estilo para el boton Descuento con estilo flotante */
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
    top: 220px;
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



    /* Estilos para las tablas */
    .table-wrapper {
    width: 105%;/* Anchura de ejemplo */
    height: 400px; /* Altura de ejemplo */
    overflow: auto;
    }

    .table-wrapper table {
    border-collapse: separate;
    border-spacing: 0;
    }

    .table-wrapper table thead {
    position: -webkit-sticky; /* Safari... */
    position: sticky;
    top: 0;
    left: 0;
    }

    .table-wrapper table thead th {
    border: 1px solid #000;
    background: #ee761c;
    }
    .table-wrapper table tbody td {
    border: 1px solid #000;
    }


    /* Quitar Spinner Input */
    input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>

{{-- Estilos para una tabla en el modal Stock Insuficiente --}}
<style>
    .estilostable {
    width: 100%;
    }
    .seleccionar:hover {
    background-color: skyblue;
    }
</style>

@endsection



@if($this->verificarcajaabierta() > 0)
<div class="row">
    <div class="col-sm-12" >

            <!-- Secciones para las Ventas -->
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <div class="col-12 col-lg-12 col-md-10 mt-3">

                            
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


                <div class="col-12 col-lg-12">
                    <div class="row">
                        <!-- Cuadro de Busqueda de Productos -->
                        <div class="col-md-6 col-lg-4" style="border-left: thick solid #b4b4b1;" >

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
                <div class="row">
                    <!-- Cuadros de Productos Encontrados Manualmente -->
                    @include('livewire.pos.partials.product')
                    <!-- Cuadros de Productos para Vender Shopping Cart -->
                    @include('livewire.pos.partials.detail')
                </div>
                <!-- linea Divisoria -->
                {{-- <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" /> --}}
                <!-- -------- -->
                @include('livewire.pos.partials.coins')


            </div>
            
            <!-- Ventana Modal para Avisar que ya no hay Stock en Tienda -->
            @include('livewire.pos.modal.stock_insuficiente')
            <!-- Ventana Modal para Avisar que ya no hay Stock en toda la sucursal y mostrar stocks
            disponible en otras sucursales -->
            @include('livewire.pos.modal.stock_disponible_sucursales')
            
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
                                                        <div class="col-sm-12 col-md-12 col-lg-4">
                                                            @if ($total > 0)
                                                                <button  data-dismiss="modal" onclick="Confirm('','clearCart','¿Seguro de eliminar el carrito?')"
                                                                    class="btn btn-dark mtmobile">
                                                                    CANCELAR
                                                                </button>
                                                            @endif
                                                        </div>



                                                        {{-- <a class="btn btn-dark btn-block {{count($denominations) < 1 ? 'disabled' : ''}}" 
                                                        href="{{ url('report/pdf' . '/' . $total. '/' . $idventa . '/' . Auth()->user()->id)}}">Generar Comprobante</a> --}}
                                                        @if($efectivo>=$total&&$total>0)
                                                        <div class="col-sm-12 col-md-12 col-lg-4">
                                                                <center>
                                                                    <strong>Generar Recibo</strong>
                                                                    <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                                                        <input id="factura" type="checkbox" wire:model="crearpdf">
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </center>
                                                        </div>


                                                        
                                                        <div class="col-sm-12 col-md-12 col-lg-4">
                                                            
                                                                <button wire:click.prevent="saveSale" data-dismiss="modal" class="btn btn-dark btn-md btn-block">
                                                                    VENDER
                                                                </button>


                                                            
                                                        </div>
                                                        @endif
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

    @if(@Auth::user()->hasPermissionTo('Ventaseditarsincortecaja'))
    <div class="row">
        <div class="col-sm-12" >
    
                <!-- Secciones para las Ventas -->
                <div class="widget widget-chart-one">
                    <div class="widget-heading">
                        <div class="col-12 col-lg-12 col-md-10 mt-3">
    
                                
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
    
    
                    <div class="col-12 col-lg-12">
                        <div class="row">
                            <!-- Cuadro de Busqueda de Productos -->
                            <div class="col-md-6 col-lg-4" style="border-left: thick solid #b4b4b1;" >
    
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
                    <div class="row">
                        <!-- Cuadros de Productos Encontrados Manualmente -->
                        @include('livewire.pos.partials.product')
                        <!-- Cuadros de Productos para Vender Shopping Cart -->
                        @include('livewire.pos.partials.detail')
                    </div>
                    <!-- linea Divisoria -->
                    {{-- <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" /> --}}
                    <!-- -------- -->
                @include('livewire.pos.partials.coins')
    
    
                </div>
                
                <!-- Ventana Modal para Avisar que ya no hay Stock en Tienda -->
                @include('livewire.pos.modal.stock_insuficiente')
                <!-- Ventana Modal para Avisar que ya no hay Stock en toda la sucursal y mostrar stocks
                disponible en otras sucursales -->
                @include('livewire.pos.modal.stock_disponible_sucursales')
                
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
                                                            <div class="col-sm-12 col-md-12 col-lg-4">
                                                                @if ($total > 0)
                                                                    <button  data-dismiss="modal" onclick="Confirm('','clearCart','¿Seguro de eliminar el carrito?')"
                                                                        class="btn btn-dark mtmobile">
                                                                        CANCELAR
                                                                    </button>
                                                                @endif
                                                            </div>
    
    
    
                                                            {{-- <a class="btn btn-dark btn-block {{count($denominations) < 1 ? 'disabled' : ''}}" 
                                                            href="{{ url('report/pdf' . '/' . $total. '/' . $idventa . '/' . Auth()->user()->id)}}">Generar Comprobante</a> --}}
                                                            @if($efectivo>=$total&&$total>0)
                                                            <div class="col-sm-12 col-md-12 col-lg-4">
                                                                    <center>
                                                                        <strong>Generar Recibo</strong>
                                                                        <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                                                            <input id="factura" type="checkbox" wire:model="crearpdf">
                                                                            <span class="slider round"></span>
                                                                        </label>
                                                                    </center>
                                                            </div>
    
    
                                                            
                                                            <div class="col-sm-12 col-md-12 col-lg-4">
                                                                
                                                                    <button wire:click.prevent="saveSale" data-dismiss="modal" class="btn btn-dark btn-md btn-block">
                                                                        VENDER
                                                                    </button>
    
    
                                                                
                                                            </div>
                                                            @endif
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
                    title: 'Venta Realizada con Exito',
                    text: 'Recargando...',
                    timer: 2000,
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
        

        //Llamando a una nueva pestaña donde estará el pdf modal
        window.livewire.on('opentap', Msg => {
            
            // Abrir nuevo tab $idventa . '/' . $totalitems
            var a = @this.totalbs;
            var b = @this.idventa;
            var c = @this.totalitems;


            var win = window.open('report/pdf/' + a + '/' + b + '/' + c);
            // Cambiar el foco al nuevo tab (punto opcional)
            //win.focus();

        });

        //Mostrar Mensaje No puede Editar ni Terminar este Servicio porque no es el Técnico Responsable de este Servicio
        window.livewire.on('seleccionarcartera', event => {
        swal("¡No selecciono ninguna cartera!", "Por favor seleccione un tipo de pago para esta operación", {
						icon : "info",
						buttons: {        			
							confirm: {
								className : 'btn btn-info'
							}
						},
					});
            });


    })


    
</script>



@endsection