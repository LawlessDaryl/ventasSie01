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
    /* Estilos para la Tabla - Ventana Modal Asignar Técnico  Responsable*/
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
                    <input type="checkbox" checked>
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
                    <select wire:model="tipofecha" class="form-control">
                        <option value="Todos" selected>Todas las Fechas</option>
                        <option value="Dia">Hoy</option>
                        <option value="Rango">Rango de Fechas</option>
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
                <div class="input-group mb-12">
                    <div class="form-control">
                        |
                    </div>
                </div>
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
                    <div class="col-4 text-right">
                    </div>
                    <div class="col-4 text-right">
                    </div>
                    <div class="col-4 text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button onclick="ConfirmarLimpiar()" class="btn btn-button" style="background-color: chocolate; color: white;">Vaciar Todo</button>
                            <button class="btn btn-button" style="background-color: rgb(12, 143, 0); color: white;">Lista de Ventas</button>
                            <button wire:click.prevent="modalfinalizarventa()" class="btn btn-button" style="background-color: rgb(0, 114, 180); color: white;">Finalizar Venta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('livewire.pos.modal.modalfinalizarventa')

</div>


@section('javascript')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Mètodo JavaScript para llamar al modal para finalizar una Venta
        window.livewire.on('show-finalizarventa', Msg => {
            $("#modalfinalizarventa").modal("show");
        });

        //Cerrar Ventana Modal y Mostrar Toast Servicio Actualizado Correctamente
        window.livewire.on('scan-ok', msg => {
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



            
    })


       // Código para lanzar la Alerta de Anulación de Servicio
       function ConfirmarLimpiar() {
        swal({
            title: '¿Vaciar todos los Productos del Shopping Cart"?',
            text: "Se limpiaran todos los productos el total venta y el total artículos",
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Vaciar Todo',
            padding: '2em'
            }).then(function(result) {
            if (result.value) {
                window.livewire.emit('clearcart')
                }
            })
        }
</script>


<!-- Scripts para el mensaje de confirmacion arriba a la derecha 'Mensaje Toast' de Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->
@endsection


