<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title text-center">
                    <b>LISTA DE SERVICIOS</b>
                </h4>
            </div>
            <div class="form-group">
                <div class="row">

                    <div class="col-sm-2 text-center">
                        <b>Buscador</b>
                        <div class="form-group">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-gp">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" wire:model="search" placeholder="Buscar" 
                                class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2 text-center">
                        <b>Tipo de Trabajo</b>
                        <div class="form-group">
                            <select wire:model.lazy="catprodservid" class="form-control">
                                <option value="Todos" selected>Todos</option>
                                @foreach ($cate as $cat)
                                    <option value="{{ $cat->id }}" selected>{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                            @error('catprodservid')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-2 text-center">
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

                    <div class="col-sm-2 text-center">
                        <b>Tipo de Servicio</b>
                        <div class="form-group">
                            <select wire:model="type" class="form-control">
                                <option value="PENDIENTE">Pendientes</option>
                                <option value="PROCESO">Propios en Proceso</option>
                                <option value="TERMINADO">Propios Terminados</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2 text-center">
                        @if(@Auth::user()->hasPermissionTo('Orden_Servicio_Index'))
                            <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                                <ul class="tabs tab-pills">
                                    <a href="{{ url('orderservice') }}" class="btn btn-warning">Ir a Orden de Servicio</a>
                                </ul>
                            </div>
                        @endif
                    </div>

                </div>
            </div>  

                
         
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-head-bg-primary table-hover">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">FECHA ENTREGA</th>
                                <th class="table-th text-withe text-center">TIEMPO RESTANTE</th>
                                <th class="table-th text-withe text-center">SERVICIO</th>
                                <th class="table-th text-withe text-center">Ir a</th>
                                <th class="table-th text-withe text-center">TECNICO RECEPTOR</th>
                                <th class="table-th text-withe text-center">CÓDIGO ORDEN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($d->fecha_estimada_entrega)->format('d/m/Y h:i:s') }}
                                    </td>
                                    <td class="text-center">
                                        {{$d->horas}}
                                    </td>
                                    <td>
                                        {{ucwords(strtolower($d->nombrecategoria))}} {{ucwords(strtolower($d->marca))}} {{strtolower($d->detalle)}}
                                        <br>
                                        <b>Falla Según Cliente:</b> {{ucwords(strtolower($d->falla_segun_cliente))}}
                                    </td>
                                    <td class="text-center">
                                        <a class="shadow-none badge badge-primary"
                                                href="{{ url('idorderservice' . '/' . $d->id) }}"
                                                style='font-size:18px'>Ver</a>
                                    </td>
                                    <td class="text-center">
                                        {{ $d->receptor }}
                                    </td>
                                    <td class="text-center">
                                        {{ $d->id_orden }}
                                    </td>

                                    {{-- @foreach ($d->movservices as $mv)
                                        <td class="text-center">
                                            {{ $mv->movs->type }}
                                        </td>
                                        <td class="text-center">
                                            <a class="shadow-none badge badge-primary"
                                                href="{{ url('idorderservice' . '/' . $d->OrderServicio->id) }}"
                                                style='font-size:18px'>Seleccionar</a>
                                        </td>
                                        <td class="text-center">
                                            {{ $mv->movs->usermov->name }}
                                        </td>
                                    @endforeach
                                    <td class="text-center">
                                        <h6>{{ $d->OrderServicio->id }}</h6>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
