@section('css')
<style>
    .servicioscss {
    border: 1px solid #000000;
    border-radius: 10px;
    background-color: #ffffff;
    border-top: 4px;
    padding: 5px;
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
                        <h2><b>Órden de Servicio</b></h2>
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
                        <b>Buscar por Codigo</b>
                        <div class="form-group">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-gp">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                @if($this->type == "PENDIENTE")
                                    <input type="text" wire:model="search" placeholder="Buscar en Pendientes" class="form-control">
                                @else
                                    @if($this->type == "PROCESO")
                                        <input type="text" wire:model="search" placeholder="Buscar en Procesos" class="form-control">
                                    @else
                                        <input type="text" wire:model="search" placeholder="Buscar en Terminados" class="form-control">
                                    @endif
                                @endif
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
                    <table class="table table-head-bg-primary table-hover" style="min-width: 1100px;">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">CODIGO</th>
                                <th class="text-center">FECHA RECEPCION</th>
                                <th class="text-center">FECHA ENTREGA</th>
                                <th class="text-center">CLIENTE</th>
                                <th class="text-center">SERVICIOS</th>
                                <th class="text-center">ESTADO</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center">A CUENTA</th>
                                <th class="text-center">SALDO</th>
                                <th class="text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orden_de_servicio as $os)
                            <tr>
                                <td class="text-center">
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
                                    
                                </td>
                                <td>

                                </td>
                                <td>
                                    @foreach ($os->servicios as $d)

                                    <div  class="servicioscss">
                                        {{ucwords(strtolower($d->nombrecategoria))}} {{ucwords(strtolower($d->marca))}} {{strtolower($d->detalle)}}
                                        <br>
                                        <b>Falla Según Cliente:</b> {{ucwords(strtolower($d->falla_segun_cliente))}}
                                    </div>
                                    @endforeach
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
</div>
