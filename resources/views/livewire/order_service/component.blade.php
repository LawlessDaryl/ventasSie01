@section('css')
<style>
    .tablaservicios {
        width: 100%;
        min-width: 1100px;
    }
    .tablaservicios thead {
        background-color: #1572e8;
        color: white;
    }
    .tablaservicios th, td {
        border: 0.5px solid #1571e894;
        padding: 4px;
    }
    .tablaserviciostr:hover {
        background-color: rgba(0, 195, 255, 0.336);
    }
    .detalleservicios{
        border: 1px solid #1572e8;
        border-radius: 10px;
        background-color: #ffffff00;
        /* border-top: 4px; */
        padding: 5px;
    }
    .asignar :hover {
        background-color: rgba(129, 251, 255, 0.486);
    }
    .imprimir :hover {
        background-color: rgba(18, 107, 240, 0.486);
    }
    .modificar :hover {
        background-color: rgba(10, 175, 4, 0.486);
    }
    .anular :hover {
        background-color: rgba(204, 184, 1, 0.486);
    }
    .eliminar :hover {
        background-color: rgba(224, 5, 5, 0.486);
    }

    .detallesservicios {
        border: 1px solid #aaaaaa;
        background-color: rgba(255, 255, 255, 0.589);
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
        padding: 10px;
        margin-left: 15%;
        margin-right: 15%;
    }
    /*Estilos para el Boton pendiente en la Tabla*/
    .pendienteestilos {
        background-color: rgb(139, 5, 192);
        cursor:pointer;
    }
    /*Estilos para los nombres de los usuarios en la tabla de la ventana modal Asignar Técnico Responsable*/
    .nombresestilosmodal {
        background-color: rgb(255, 255, 255);
        color: rgb(0, 0, 0);
        cursor:pointer;
    }
    /*Estilos para el Botón Editar Servicio de la Tabla*/
    .botoneditar {
        background-color: #008a5c;
        color: rgb(255, 255, 255);
        cursor:pointer;
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
    }

    .table-wrapper table thead {
        position: -webkit-sticky; /* Safari... */
        position: sticky;
        top: 0;
        left: 0;
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
                        <h2><b>ORDEN DE SERVICIO</b></h2>
                        Ordenados por Fecha de Recepción
                    </div>

                    <div class="col-12 col-sm-12 col-md-4">
                        @if(@Auth::user()->hasPermissionTo('Recepcionar_Servicio'))
                            <ul class="tabs tab-pills text-right">
                                <a href="{{ url('service') }}" class="btn btn-outline-primary">Nuevo Servicio</a>
                                <a href="{{ url('inicio') }}" class="btn btn-outline-primary">Ir a Lista Servicios</a>
                            </ul>
                        @endif
                    </div>

                </div>
            </div> 

            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Buscar por Código</b>
                        <div class="form-group">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-gp">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" wire:model="search" placeholder="Busqueda General..." class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Seleccionar Sucursal</b>
                        <div class="form-group">
                            <select wire:model="sucursal_id" class="form-control">
                                <option value="Todos">Todas las Sucursales</option>
                                @foreach($listasucursales as $sucursal)
                                <option value="{{$sucursal->id}}">{{$sucursal->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Categoría Trabajo</b>
                        <div class="form-group">
                            <select wire:model.lazy="catprodservid" class="form-control">
                                <option value="Todos" selected>Todos</option>
                                @foreach ($categorias as $cat)
                                    <option value="{{ $cat->id }}" selected>{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                            @error('catprodservid')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Tipo de Servicio</b>
                        <div class="form-group">
                            <select wire:model="type" class="form-control">
                                <option value="PENDIENTE">Pendientes</option>
                                <option value="PROCESO">Proceso</option>
                                <option value="TERMINADO">Terminados</option>
                                <option value="ENTREGADO">Entregado</option>
                                <option value="ABANDONADO">Abandonado</option>
                                <option value="ANULADO">Anulado</option>
                                <option value="TODOS">Todos</option>
                                <option value="FECHA">Por Fecha</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
                
            
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="tablaservicios">
                        <thead>
                            <tr>
                                <th class="text-center" style="min-width: 20px;">#</th>
                                <th class="text-center">CODIGO</th>
                                <th class="text-center">FECHA RECEPCION</th>
                                <th class="text-center">FECHA ENTREGA</th>
                                <th class="text-center">CLIENTE</th>
                                <th class="text-center">SERVICIOS</th>
                                <th class="text-center">PRECIO</th>
                                <th class="text-center">USUARIO RECEPTOR</th>
                                <th class="text-center">ESTADO</th>
                                <th class="text-center">EDITAR</th>
                                <th class="text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orden_de_servicio as $os)
                                <tr class="tablaserviciostr">
                                    <td class="text-center" style="min-width: 20px;">
                                        {{$os->num}}
                                    </td>
                                    <td class="text-center">
                                        <span class="stamp stamp" style="background-color: #1572e8">
                                            {{$os->codigo}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($os->fechacreacion)->format('d/m/Y h:i a') }}
                                    </td>
                                    <td class="text-center">
                                        @foreach ($os->servicios as $d)
                                        {{ \Carbon\Carbon::parse($d->fecha_estimada_entrega)->format('d/m/Y h:i a') }}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        {{ucwords(strtolower($os->nombrecliente))}}
                                    </td>
                                    <td>
                                        @foreach ($os->servicios as $d)

                                            @if($os->servicios->count() == 1)
                                            <div>
                                                <a href="javascript:void(0)" wire:click.prevent="modalserviciodetalles('{{$d->estado}}' , {{ $d->idservicio }})">
                                                    {{ucwords(strtolower($d->nombrecategoria))}} {{ucwords(strtolower($d->marca))}} {{strtolower($d->detalle)}}
                                                    <br>
                                                    <b>Falla Según Cliente:</b> {{ucwords(strtolower($d->falla_segun_cliente))}}
                                                </a>
                                            </div>
                                            @else
                                            <div style="background-color: rgba(255, 230, 210, 0.829);">
                                                <a href="javascript:void(0)" wire:click.prevent="modalserviciodetalles('{{$d->estado}}' , {{ $d->idservicio }})">
                                                    {{ucwords(strtolower($d->nombrecategoria))}} {{ucwords(strtolower($d->marca))}} {{strtolower($d->detalle)}}
                                                    <br>
                                                    <b>Falla Según Cliente:</b> {{ucwords(strtolower($d->falla_segun_cliente))}}
                                                </a>
                                            </div>
                                            @endif

                                        @endforeach
                                    </td>
                                    <td class="text-right">

                                        @foreach ($os->servicios as $d)
                                            {{$d->importe}}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        {{ucwords(strtolower($os->usuarioreceptor))}}
                                    </td>
                                    <td class="text-center">
                                        @foreach ($os->servicios as $d)
                                            @if($d->estado=="PENDIENTE")
                                            <span wire:click.prevente="modalasignartecnico({{$d->idservicio}})" title="Asignar Técnico Responsable" class="stamp stamp pendienteestilos">
                                                {{$d->estado}}
                                            </span>
                                            @else
                                                @if($d->estado=="PROCESO")
                                                    <span class="stamp stamp" style="background-color: rgb(100, 100, 100)">
                                                        {{$d->estado}}
                                                    </span>
                                                @else
                                                    @if($d->estado=="TERMINADO")
                                                        <span class="stamp stamp" style="background-color: rgb(224, 146, 0)">
                                                            {{$d->estado}}
                                                        </span>
                                                    @else
                                                        @if($d->estado=="ENTREGADO")
                                                            <span class="stamp stamp" style="background-color: rgb(22, 192, 0)">
                                                                {{$d->estado}}
                                                            </span>
                                                        @else
                                                            @if($d->estado=="ABANDONADO")
                                                                <span class="stamp stamp" style="background-color: rgb(186, 238, 0)">
                                                                    {{$d->estado}}
                                                                </span>
                                                            @else
                                                                @if($d->estado=="ANULADO")
                                                                    <span class="stamp stamp" style="background-color: rgb(0, 0, 0)">
                                                                        {{$d->estado}}
                                                                    </span>
                                                                @else
                                                                    {{$d->estado}}
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                            <br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @foreach ($os->servicios as $d)
                                        <span wire:click.prevente="editarservicio('{{$d->estado}}',{{$d->idservicio}})" title="Editar Servicio" class="stamp stamp botoneditar">
                                            EDITAR
                                        </span>
                                        <br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Opciones
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <div class="asignar">
                                                        <a class="dropdown-item" href="#">Asignar Técnico</a>
                                                    </div>
                                                    <div class="imprimir">
                                                        <a class="dropdown-item" href="#">Imprimir</a>
                                                    </div>
                                                    <div class="modificar">
                                                        <a class="dropdown-item" href="#">Modificar Servicio</a>
                                                    </div>
                                                    <div class="anular">
                                                        <a class="dropdown-item" href="#">Anular Servicio</a>
                                                    </div>
                                                    <div class="eliminar">
                                                        <a class="dropdown-item" href="#">Eliminar Servicio</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $orden_de_servicio->links() }}
            </div>
        </div>
    </div>
    {{-- @include('livewire.order_service.form')
    @include('livewire.order_service.formdetalle')
    @include('livewire.order_service.formdetalleentrega') --}}
    @include('livewire.order_service.modalserviciodetalles')
    @include('livewire.order_service.modalasignartecnicoresponsable')
    @include('livewire.order_service.modaleditarservicio')
    {{-- @include('livewire.order_service.formopciones')
    @include('livewire.order_service.formentregado')
    @include('livewire.order_service.formeliminar')
    @include('livewire.order_service.formanular') --}}
</div>
    
@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('show-sd', Msg => {
            $('#serviciodetalles').modal('show')
        });

        window.livewire.on('show-asignartecnicoresponsable', Msg => {
            $('#asignartecnicoresponsable').modal('show')
        });
        window.livewire.on('show-editarserviciomostrar', Msg => {
            $('#editarservicio').modal('show')
        });

        //Cerrar Ventana Modal y Mostrar Toast Categoría Creada con Éxito
        window.livewire.on('show-asignartecnicoresponsablecerrar', msg => {
            $('#asignartecnicoresponsable').modal('hide')
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: 'Técnico Responsable Asignado con Éxito',
                padding: '2em',
            })
        });
    });

</script>
<!-- Scripts para el mensaje de confirmacion arriba a la derecha Categoría Creada con Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->
@endsection