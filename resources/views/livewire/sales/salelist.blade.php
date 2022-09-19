@section('css')
<style>
    /* Estilos para las tablas */
    .table-wrapper {
    width: 100%;/* Anchura de ejemplo */
    /*height: 750px;  Altura de ejemplo */
    /* overflow: auto; */
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





    /* Estilos para el loading */
    .lds-roller {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
        }
        .lds-roller div {
        animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        transform-origin: 40px 40px;
        }
        .lds-roller div:after {
        content: " ";
        display: block;
        position: absolute;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #ee761c;
        margin: -4px 0 0 -4px;
        }
        .lds-roller div:nth-child(1) {
        animation-delay: -0.036s;
        }
        .lds-roller div:nth-child(1):after {
        top: 63px;
        left: 63px;
        }
        .lds-roller div:nth-child(2) {
        animation-delay: -0.072s;
        }
        .lds-roller div:nth-child(2):after {
        top: 68px;
        left: 56px;
        }
        .lds-roller div:nth-child(3) {
        animation-delay: -0.108s;
        }
        .lds-roller div:nth-child(3):after {
        top: 71px;
        left: 48px;
        }
        .lds-roller div:nth-child(4) {
        animation-delay: -0.144s;
        }
        .lds-roller div:nth-child(4):after {
        top: 72px;
        left: 40px;
        }
        .lds-roller div:nth-child(5) {
        animation-delay: -0.18s;
        }
        .lds-roller div:nth-child(5):after {
        top: 71px;
        left: 32px;
        }
        .lds-roller div:nth-child(6) {
        animation-delay: -0.216s;
        }
        .lds-roller div:nth-child(6):after {
        top: 68px;
        left: 24px;
        }
        .lds-roller div:nth-child(7) {
        animation-delay: -0.252s;
        }
        .lds-roller div:nth-child(7):after {
        top: 63px;
        left: 17px;
        }
        .lds-roller div:nth-child(8) {
        animation-delay: -0.288s;
        }
        .lds-roller div:nth-child(8):after {
        top: 56px;
        left: 12px;
        }
        @keyframes lds-roller {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    /* Estilos para el Switch Mas Filtros*/
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













</style>
@endsection

<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">

            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-12 col-md-4 text-center">

                    </div>

                    <div class="col-12 col-sm-12 col-md-4 text-center">
                        <h2><b>LISTA DE VENTAS</b></h2>
                        Ordenados por Fecha de Venta
                    </div>

                    <div class="col-12 col-sm-12 col-md-4">
                        <ul class="tabs tab-pills text-right">
                            {{-- <a href="javascript:void(0)" wire:click="irservicio()" class="btn btn-outline-primary">Nuevo Servicio</a> --}}
                            <a href="{{ url('pos') }}" class="btn btn-button" style="background-color: rgb(12, 143, 0); color: white;">Nueva Venta</a>
                            {{-- <br>
                            <br>









                            <div class="btn-group" role="group" aria-label="Basic example">
                                <label class="switch">
                                    <input type="checkbox" wire:change="mostrarocultarmasfiltros()" {{ $masfiltros ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                    </label>
                                    <label>+Filtros</label>
                                    
                            </div> --}}
                        </ul>
                    </div>

                </div>
            </div> 


            <center><div id="preloader_3" wire:loading>
                
            
                <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>

            
            </div></center>

            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b wire:click="limpiarsearch()" style="cursor: pointer;">Buscar...</b>
                        <div class="form-group">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-gp">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" wire:model="search" placeholder="Buscar por Código..." class="form-control">
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->hasPermissionTo('VentasListaMasFiltros'))
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Seleccionar Sucursal</b>
                        <div class="form-group">
                            <select wire:model="sucursal_id" class="form-control">
                                @foreach($listasucursales as $sucursal)
                                <option value="{{$sucursal->id}}">{{$sucursal->name}}</option>
                                @endforeach
                                <option value="Todos">Todas las Sucursales</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Seleccionar Usuario</b>
                        <div class="form-group">
                            <select wire:model="user_id" class="form-control">
                                <option value="Todos" selected>Todos</option>
                                @foreach ($listausuarios as $u)
                                    <option value="{{ $u->id }}">{{ ucwords(strtolower($u->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @else

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Ventas del Usuario</b>
                        <div class="form-group">
                            <label class="form-control">
                                {{Auth::user()->name}}
                            </label>
                        </div>
                    </div>

                    @endif
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Tipo de Fecha</b>
                        <div class="form-group">
                            <select wire:model="tipofecha" class="form-control">
                                <option value="hoy" selected>Hoy</option>
                                <option value="rango">Rango de Fechas</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            @if($this->tipofecha != "hoy")

            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Fecha Inicio</b>
                        <div class="form-group">
                            <input @if ($tipofecha == 'hoy') disabled @endif type="date" wire:model="dateFrom" class="form-control flatpickr" >
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Fecha Fin</b>
                        <div class="form-group">
                            <input @if ($tipofecha == 'hoy') disabled @endif type="date" wire:model="dateTo" class="form-control flatpickr" >
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Hora Inicio</b>
                        <div class="form-group">
                            <input @if ($tipofecha == 'hoy') disabled @endif type="time" wire:model="timeFrom" class="form-control flatpickr" >
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Hora Fin</b>
                        <div class="form-group">
                            <input @if ($tipofecha == 'hoy') disabled @endif type="time" wire:model="timeTo" class="form-control flatpickr" >
                        </div>
                    </div>
                </div>
            </div>

            @endif

            <br>

            <div class="table-wrapper table-responsive">
                <table style="min-width: 900px;">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">CODIGO</th>
                            <th class="text-center">FECHA</th>
                            <th class="text-center">TOTALES BS</th>
                            <th class="text-center">USUARIO</th>
                            <th class="text-center">CARTERA</th>
                            <th class="text-center">SUCURSAL</th>
                            <th class="text-center">CLIENTE</th>
                            <th class="text-center">ESTADO</th>
                            <th class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listaventas as $lv)
                            <tr>
                                <td class="text-center">
                                    {{ ($listaventas->currentpage()-1) * $listaventas->perpage() + $loop->index + 1 }}
                                </td>
                                <td class="text-center">
                                    <span class="stamp stamp" style="background-color: #ee761c">
                                        {{$lv->codigo}}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($lv->ventareciente > -1)
                                        @if($lv->ventareciente == 1)
                                        <div style="color: rgb(0, 201, 33);">
                                            <b>Hace {{$lv->ventareciente}} Minuto</b>
                                        </div>
                                        @else
                                        <div style="color: rgb(0, 201, 33);">
                                            <b>Hace {{$lv->ventareciente}} Minutos</b>
                                        </div>
                                        @endif
                                    @endif
                                    {{ \Carbon\Carbon::parse($lv->fechaventa)->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">
                                    @if($lv->totaldescuento == 0)
                                    Descuento Bs {{$lv->totaldescuento}}
                                    <br>
                                    @else
                                        @if($lv->totaldescuento < 0)
                                        <div style="color: rgb(250, 12, 12);"><b>Descuento Bs {{$lv->totaldescuento}}</b></div>
                                        @else
                                        <div style="color: #002df3;"><b>Recargo Bs {{$lv->totaldescuento}}</b></div>
                                        @endif
                                    @endif
                                    <b>Total Bs {{$lv->totalbs}}</b>
                                    <br>
                                    Cambio Bs {{$lv->totalcambio}}
                                </td>
                                <td class="text-center">
                                    {{ ucwords(strtolower($lv->nombreusuario))}}
                                </td>
                                <td class="text-center">
                                    {{ ucwords(strtolower($lv->nombrecartera))}}
                                </td>
                                <td class="text-center">
                                    {{ ucwords(strtolower($lv->nombresucursal))}}
                                </td>
                                <td class="text-center">
                                    @foreach($lv->datoscliente as $c)
                                        @if($c->nombrecliente == "Cliente Anónimo")
                                        {{$c->nombrecliente}}
                                        @else
                                            {{$c->cedulacliente}}
                                            <br>
                                            <b>{{$c->nombrecliente}}</b>
                                            <br>
                                            {{$c->celularcliente}}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    @if($lv->estado == "PAID")
                                        <p style="color: #002df3;"><b>Normal</b></p>
                                    @else
                                        <p style="color: #f30000;"><b>Anulado</b></p>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button wire:click="modaldetalle({{ $lv->codigo }})" class="btn btn-sm" title="Ver detalles de la venta" style="background-color: rgb(10, 137, 235); color:white">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        @if(Auth::user()->hasPermissionTo('VentasListaMasFiltros'))
                                        <a href="#" onclick="ConfirmarAnular({{ $lv->codigo }}, '{{$lv->nombrecartera}}')" class="btn btn-sm" title="Anular Venta" style="background-color: red; color:white">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        {{-- <button wire:click="editsale({{$d->id}})" class="btn btn-sm" title="Editar Venta" style="background-color: rgb(13, 175, 220); color:white">
                                            <i class="fas fa-edit"></i>
                                        </button> --}}
                                        <button wire:click="modalcambiarusuario({{$lv->codigo}})" class="btn btn-sm" title="Cambiar Usuario Vendedor" style="background: #ee761c; color:white">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        @endif
                                        <button wire:click="crearcomprobante({{$lv->codigo}})" class="btn btn-sm" title="Crear Comprobante" style="background-color: rgb(0, 104, 21); color:white">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $listaventas->links() }}



            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Número de Ventas</b>
                        <label class="form-control">
                            {{$listaventas->total()}}
                        </label>
                    </div>

                    {{-- <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b wire:click="limpiarsearch()" style="cursor: pointer;">Cartera: </b>
                        <div class="form-group">
                            <label for="">
                                1000
                            </label>
                        </div>
                    </div> --}}
                </div>
            </div>

        </div>
    </div>
    @include('livewire.sales.modaldetalles')
    @include('livewire.sales.modalcambiarusuario')
</div>
@section('javascript')





<script>
    document.addEventListener('DOMContentLoaded', function() {
        //Mostrar ventana modal detalle venta
        window.livewire.on('modaldetalles-show', msg => {
            $('#detalleventa').modal('show')
        });
        //Mostrar ventana modal cambiar usuario vendedor
        window.livewire.on('modalcambiarusuario-show', msg => {
            $('#modalcambiarusuario').modal('show')
        });
        //Mostrar Mensaje Venta Anulada Exitosamente
        window.livewire.on('sale-cancel-ok', event => {
        swal(
            '¡Venta ' + @this.venta_id + ' anulada exitosamente!',
            'La venta fue anulada correctamente, todos los cambios hechos en la venta fueron revertidos',
            'success'
            )
        });
        //Mostrar Mensaje a ocurrido un error en la venta
        window.livewire.on('sale-error', event => {
        swal(
            'A ocurrido un error al anular la venta',
            'Detalle del error: '+ @this.mensaje,
            'error'
            )
        });

        //Cerrar Ventana Modal Cambiar Usuario Vendedor y Mostrar Toast Cambio Exitosamente
        window.livewire.on('modalcambiarusuario-hide', msg => {
                        $('#modalcambiarusuario').modal('hide')
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: @this.mensaje,
                padding: '2em',
            })
        });

        //Crear pdf de Informe técnico de un servicio
        window.livewire.on('crear-comprobante', Msg => {
            var idventa = @this.venta_id;
            var ventatotal = @this.venta.total;
            var totalitems = @this.totalitems;
            var win = window.open('report/pdf/' + ventatotal + '/' + idventa + '/' + totalitems);
            // Cambiar el foco al nuevo tab (punto opcional)
            // win.focus();
        });
    });












    // Código para lanzar la Alerta de Anulación de Venta
    function ConfirmarAnular(codigo, nombrecartera) {
    swal({
        title: '¿Anular la venta con el código "' + codigo + '"?',
        text: "Tipo de Pago: " + nombrecartera + " - Se deshará todos los cambios hechos en esta transacción",
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Anular Venta',
        padding: '2em'
        }).then(function(result) {
        if (result.value) {
            window.livewire.emit('anularventa', codigo)
            }
        })
    }


</script>

<!-- Scripts para el mensaje de confirmacion arriba a la derecha 'Mensaje Toast' de Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->

@endsection