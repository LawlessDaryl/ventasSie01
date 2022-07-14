<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-12 col-md-4 text-center">

                    </div>

                    <div class="col-12 col-sm-12 col-md-4 text-center">
                        <h2><b>LISTA DE SERVICIOS (Pendientes - Procesos - Terminados)</b></h2>
                    </div>

                    <div class="col-12 col-sm-12 col-md-4">
                        @if(@Auth::user()->hasPermissionTo('Orden_Servicio_Index'))
                            <ul class="tabs tab-pills text-right">
                                <a href="{{ url('orderservice') }}" class="btn btn-warning">Ir a Orden de Servicio</a>
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
                                <option value="PROCESO">Propios en Proceso</option>
                                <option value="TERMINADO">Propios Terminados</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>  

                
         
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-head-bg-primary table-hover" style="min-width: 1000px;">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="text-withe text-center">FECHA ENTREGA</th>
                                @if($this->type == "TERMINADO")
                                <th class="text-withe text-center">ACABADO HACE</th>
                                @else
                                <th class="text-withe text-center">TIEMPO RESTANTE</th>
                                @endif
                                <th class="text-withe text-center">SERVICIO</th>
                                <th class="text-withe text-center">IR A</th>
                                <th class="text-withe text-center">TECNICO RECEPTOR</th>
                                <th class="text-withe text-center">CÓDIGO ORDEN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderservices as $d)
                                @if($d->encargado != "")
                                <tr>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($d->fecha_estimada_entrega)->format('d/m/Y h:i:s a') }}
                                    </td>
                                    <td class="text-center">
                                        @if($this->type == "PENDIENTE" || $this->type == "PROCESO")
                                            @if($d->tiempo < 0)
                                            <span class="stamp stamp" style="background-color: black">
                                                EXPIRADO
                                            </span>
                                            @else
                                                @if($d->tiempo == 0)
                                                <span class="stamp stamp" style="background-color: red">
                                                    Menos de 1 Hora
                                                </span>
                                                @else
                                                    @if($d->tiempo == 1)
                                                    <span class="stamp stamp" style="background-color: orange;">
                                                        Más de 1 Hora
                                                    </span>
                                                    @else
                                                    <span class="stamp stamp" style="background-color: rgb(0, 167, 0)">
                                                        Más de {{$d->tiempo}} Horas
                                                    </span>
                                                    @endif
                                                @endif
                                            @endif
                                        @else
                                            {{-- Si es Igual a TERMINADO --}}
                                            @if($d->tiempo == 0)
                                            <span class="stamp stamp" style="background-color: rgb(0, 209, 28)">
                                                Hoy
                                            </span>
                                            @else
                                                @if($d->tiempo > 19)
                                                <span class="stamp stamp" style="background-color: red">
                                                    {{$d->tiempo}} Dias
                                                </span>
                                                @else
                                                <span class="stamp stamp" style="background-color: orange">
                                                    {{$d->tiempo}} Dias
                                                </span>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        {{ucwords(strtolower($d->nombrecategoria))}} {{ucwords(strtolower($d->marca))}} {{strtolower($d->detalle)}}
                                        <br>
                                        <b>Falla Según Cliente:</b> {{ucwords(strtolower($d->falla_segun_cliente))}}
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-border btn-round btn-sm" href="{{ url('idorderservice' . '/' . $d->id_orden) }}">
                                                Ver
                                                <span class="btn-label">
                                                    <i class="fa fa-link"></i>
                                                </span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {{ $d->receptor }}
                                    </td>
                                    <td class="text-center">
                                        {{ $d->id_orden }}
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
