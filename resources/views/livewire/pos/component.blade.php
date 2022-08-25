@section('css')

<style>
    /* Estilos para el Switch Cliente Anónimo y Factura*/
    .switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    }
    .switch input {display:none;}
    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgb(133, 133, 133);
    -webkit-transition: .4s;
    transition: .4s;
    }
    .slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 2px;
    bottom: 1px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }
    input:checked + .slider {
    background-color: #f59953;
    }
    input:focus + .slider {
    box-shadow: 0 0 1px #f59953;
    }
    input:checked + .slider:before {
    -webkit-transform: translateX(19px);
    -ms-transform: translateX(19px);
    transform: translateX(19px);
    }
    /* Rounded sliders */
    .slider.round {
    border-radius: 34px;
    }
    .slider.round:before {
    border-radius: 40%;
    }
    /* Estilos para las tablas */
    .table-wrapper {
    width: 100%;/* Anchura de ejemplo */
    height: 350px; /* Altura de ejemplo */
    overflow: auto;
    }

    .table-wrapper table {
        border-collapse: separate;
        border-spacing: 0;
        border-left: 0.3px solid #ee761c;
        border-bottom: 0.3px solid #ee761c;
        width: 100%;
    }

    .table-wrapper table thead {
        position: -webkit-sticky; /* Safari... */
        position: sticky;
        top: 0;
        left: 0;
    }
    .table-wrapper table thead tr {
    background: #ee761c;
    color: white;
    }
    /* .table-wrapper table tbody tr {
        border-top: 0.3px solid rgb(0, 0, 0);
    } */
    .table-wrapper table tbody tr:hover {
        background-color: #ffdf76a4;
    }
    .table-wrapper table td {
        border-top: 0.3px solid #ee761c;
        padding-left: 10px;
        border-right: 0.3px solid #ee761c;
    }
</style>
@endsection
<div>
    <div class="form-group" style="background-color: rgb(255, 235, 210); border-radius: 14px;">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-2 text-center">
                <h3><b>Cliente Anónimo</b></h3>
                <div class="form-group">
                    <label class="switch">
                    {{-- <input type="checkbox" checked> --}}


                    <input type="checkbox" wire:change="clienteanonimo()" {{ $clienteanonimo ? 'checked' : '' }}>


                    <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-2 text-center">
                <h3><b>Factura</b></h3>
                <div class="form-group">
                    <label class="switch">
                    <input type="checkbox" checked>
                    <span class="slider round"></span>
                    </label>
                </div>
            </div>
    
            <div class="col-12 col-sm-6 col-md-2 text-center">
                <h3><b>Tipo de Pago</b></h3>
                <div class="form-group">
                    <select wire:model="cartera_id" class="form-control">
                        <option value="Elegir">Elegir</option>
                        @foreach($carteras as $c)
                        <option value="{{$c->idcartera}}">{{$c->nombrecartera}} - {{$c->dc}}</option>
                        @endforeach
                        @foreach($carterasg as $g)
                        <option value="{{$g->idcartera}}">{{$g->nombrecartera}} - {{$g->dc}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
    
            <div class="col-12 col-sm-6 col-md-2 text-center">
                <h3><b>Total Artículos</b></h3>
                <div class="form-group">
                    <h4>{{$this->total_items}}</h4>
                </div>
            </div>
    
            <div class="col-12 col-sm-6 col-md-2 text-center">
                <h3><b>Total Venta</b></h3>
                <div class="form-group">
                    <h4>{{$this->total_bs}} Bs</h4>
                </div>
            </div>
    
            <div class="col-12 col-sm-6 col-md-2 text-center">
                <h3><b>Observación</b></h3>
                <div class="form-group">
                    <textarea class="form-control" aria-label="With textarea" wire:model="observacion"></textarea>
                </div>
            </div>
    
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 text-center">
                <h3><b>Lista de Productos</b></h3>
                <div class="input-group mb-12">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-gp">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <input type="text" wire:model="buscarproducto" placeholder="Buscar Producto..." class="form-control">
                </div>
                <br>
                @if(strlen($this->buscarproducto) > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listaproductos as $p)
                            <tr>
                                <td class="text-left">
                                    {{ $p->nombre }}
                                    <b>({{ $p->barcode }})</b>
                                    {{ $p->precio_venta }} Bs
                                </td>
                                <td>
                                    <button  wire:click="increase({{ $p->id }})" class="btn btn-sm" style="background-color: rgb(10, 137, 235); color:aliceblue">
                                        <i class="fas fa-plus"></i>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $listaproductos->links() }}
                @else

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
                <br>



                @endif
    
    
            </div>
            <div class="col-12 col-sm-6 col-md-8 text-center">
                <div class="row">
                    <div class="col-4">
                        
                    </div>
                    <div class="col-4">
                        <h3><b>Shopping Cart</b></h3>
                    </div>
                    <div class="col-4 text-right">
                        
                    </div>
                </div>
                @if($this->clienteanonimo)
                <div style="height: 44.2px;">

                </div>
                @else
                <div class="row">
                    <div class="col-3 text-center">
                        
                    </div>
                    <div class="col-3 text-center">
                        <button wire:click.prevent="modalbuscarcliente()" class="form-control btn btn-button" style="">
                            Buscar Cliente
                        </button>
                    </div>
                    <div class="col-3 text-center">
                        <button class="form-control">
                            Crear Cliente
                        </button>
                    </div>
                    <div class="col-3 text-center">
                        
                    </div>
                </div>
                @endif
                <br>
                @if ($this->total_bs > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Precio Bs</th>
                                <th>Cantidad</th>
                                <th>Importe</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                            <tr>
                                <td class="text-left">
                                    {{ $item->name }}
                                </td>
                                <td>
                                    {{ $item->price }}
                                </td>
                                <td>
                                    {{$item->quantity}}
                                </td>
                                <td>
                                    {{ $item->price * $item->quantity, 2 }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button title="Eliminar Producto" onclick="Confirm('{{ $item->id }}','removeItem','¿Confirmas Eliminar el Registro?')" class="btn btn-sm" style="background-color: red; color:white">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button title="Quitar una unidad" wire:click.prevent="decreaseQty({{ $item->id }})" class="btn btn-sm" style="background-color: rgb(99, 123, 142); color:white">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button title="Incrementar una unidad" wire:click.prevent="increaseQty({{ $item->id }})" class="btn btn-sm" style="background-color: rgb(10, 137, 235); color:white">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else

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
                <br>

                @endif


                <br>
                
                <div class="row">
                    <div class="col-1 text-right">
                    </div>
                    <div class="col-10 text-center">
                        <h5>Nombre Cliente: <b>{{ucwords(strtolower($nombrecliente))}}</b></h5>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            @if($this->total_items > 0)
                            <button onclick="ConfirmarLimpiar()" class="btn btn-button" style="background-color: chocolate; color: white;">Vaciar Todo</button>
                            @endif
                            <a href="{{ url('salelist') }}" class="btn btn-button" style="background-color: rgb(12, 143, 0); color: white;">Lista de Ventas</a>
                            <button wire:click.prevent="modalfinalizarventa()" class="btn btn-button" style="background-color: rgb(0, 114, 180); color: white;">Finalizar Venta</button>
                        </div>
                    </div>
                    <div class="col-1 text-right">
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('livewire.pos.modal.modalfinalizarventa')
    @include('livewire.pos.modal.modalbuscarcliente')

</div>


@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Mètodo JavaScript para llamar al modal para finalizar una Venta
        window.livewire.on('show-finalizarventa', Msg => {
            $("#modalfinalizarventa").modal("show");
        });
        // Mètodo JavaScript para llamar al modal para buscar un cliente
        window.livewire.on('show-buscarcliente', Msg => {
            $("#modalbuscarcliente").modal("show");
        });
        //Mostrar Toast cuando un producto se incrementa en el shopping cart
        window.livewire.on('increase-ok', msg => {
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: @this.mensaje_toast,
                padding: '2em',
            })
        });
        //Mostrar Toast cuando un producto no se encuentra para ponerlo en el shopping cart
        window.livewire.on('increase-notfound', msg => {
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            padding: '2em'
            });
            toast({
                type: 'warning',
                title: @this.mensaje_toast,
                padding: '2em',
            })
        });
        //Mostrar Toast cuando se use un cliente anónimo
        window.livewire.on('clienteanonimo-true', msg => {
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            padding: '2em'
            });
            toast({
                type: 'info',
                title: @this.mensaje_toast,
                padding: '2em',
            })
        });
        //Mostrar Toast cuando no se use un cliente anónimo
        window.livewire.on('clienteanonimo-false', msg => {
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            padding: '2em'
            });
            toast({
                type: 'info',
                title: @this.mensaje_toast,
                padding: '2em',
            })
        });
        //Cierra la ventana Modla Buscar Cliente y muestra mensaje Toast cuando se selecciona un Cliente
        window.livewire.on('hide-buscarcliente', msg => {
            $("#modalbuscarcliente").modal("hide");
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: @this.mensaje_toast,
                padding: '2em',
            })
        });
        //Mostrar Mensaje Shopping Cart Vaciado exitosamente
        window.livewire.on('cart-clear', event => {
                swal(
                    '¡El Shopping Cart fue vaciado exitosamente!',
                    'Se eliminaron todos los productos correctamente',
                    'success'
                    )
            });

        //Cerrar ventana modal finalizar venta y mostrar mensaje toast de venta realizada con éxito
        window.livewire.on('sale-ok', msg => {
            $("#modalfinalizarventa").modal("hide");
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: @this.mensaje_toast,
                padding: '2em',
            })
        });



        //Mostrar Mensaje a ocurrido un error en la venta
        window.livewire.on('sale-error', event => {
                swal(
                    'A ocurrido un error al realizar la venta',
                    'Detalle del error'+ @this.mensaje_toast,
                    'error'
                    )
            });

        //Mostrar Mensaje debe elegir una cartera
        window.livewire.on('show-elegircartera', event => {
            swal(
                '¡Seleccione Tipo de Pago!',
                'Por favor seleccione un tipo de pago distinto a elegir',
                'warning'
                )
        });

            
    });


    // Código para lanzar la Alerta de Hacerse Técnico Responsable de un Servicio
    function ConfirmarLimpiar() {
        swal({
            title: '¿Vaciar todo el contenido del Shopping Cart?',
            text: "Los valores de total articulos y total venta pasarán a ser 0",
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Vaciar Todo',
            padding: '2em'
            }).then(function(result) {
            if (result.value) {
                window.livewire.emit('clear-Cart')
                }
            })
    }
    





</script>


<!-- Scripts para el mensaje de confirmacion arriba a la derecha 'Mensaje Toast' de Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->
@endsection


