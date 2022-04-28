<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>SERVICIOS Y PENDIENTES PRÓXIMOS A VENCER</b>
                </h4>
            </div>
            <div class="form-group">
                <div class="row">

                    <div class="col-lg-2 col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Tipo de equipo</label>
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

                    @if (@Auth::user()->hasPermissionTo('Boton_Entregar_Servicio') && @Auth::user()->hasPermissionTo('Recepcionar_Servicio'))
                    <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="libres"
                                        value="Pendientes" wire:model="condicional">
                                    <span class="new-control-indicator"></span><h6>SERVICIOS PENDIENTES</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="ocupados"
                                        value="Propios" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span><h6>SERVICIOS PROPIOS EN PROCESO</h6>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="terminado"
                                        value="Terminados" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span><h6>SERVICIOS PROPIOS TERMINADOS</h6>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2 col-md-3 mt-4">
                            <div class="form-group">
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input type="radio" class="new-control-input" name="sucursales"
                                            value="MiSucursal" wire:model="condicion">
                                        <span class="new-control-indicator"></span><h6>MI SUCURSAL</h6>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-3 mt-4">
                            <div class="form-group">
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input type="radio" class="new-control-input" name="sucursales"
                                            value="Todos" wire:model="condicion" checked>
                                        <span class="new-control-indicator"></span><h6>TODAS LAS SUCURSALES</h6>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    @elseif(@Auth::user()->hasPermissionTo('Boton_Entregar_Servicio'))
                    
                    <div class="col-lg-3 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="opciones_cajero" id="terminado"
                                        value="TerminadosTodos" wire:model="condicional">
                                    <span class="new-control-indicator"></span><h6>SERVICIOS TERMINADOS</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="opciones_cajero" id="terminado"
                                        value="EntregadosPropios" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span><h6>SERVICIOS PROPIOS ENTREGADOS</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    @elseif(@Auth::user()->hasPermissionTo('Recepcionar_Servicio'))

                    <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="libres"
                                        value="Pendientes" wire:model="condicional">
                                    <span class="new-control-indicator"></span><h6>SERVICIOS PENDIENTES</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="ocupados"
                                        value="Propios" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span><h6>SERVICIOS PROPIOS EN PROCESO</h6>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="terminado"
                                        value="Terminados" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span><h6>SERVICIOS PROPIOS TERMINADOS</h6>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2 col-md-3 mt-4">
                            <div class="form-group">
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input type="radio" class="new-control-input" name="sucursales"
                                            value="MiSucursal" wire:model="condicion">
                                        <span class="new-control-indicator"></span><h6>MI SUCURSAL</h6>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-3 mt-4">
                            <div class="form-group">
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input type="radio" class="new-control-input" name="sucursales"
                                            value="Todos" wire:model="condicion" checked>
                                        <span class="new-control-indicator"></span><h6>TODAS LAS SUCURSALES</h6>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if (@Auth::user()->hasPermissionTo('Orden_Servicio_Index'))
                    <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                        <ul class="tabs tab-pills">
                            <a href="{{ url('orderservice') }}" class="btn btn-dark">IR A ORDENES DE SERVICIO</a>
                        </ul>
                    </div>
                    @endif
                </div>

                

            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table id="style-3" class="table style-3 table-hover dataTable no-footer" role="grid"
                        aria-describedby="style-3_info">
                        <thead class="text-white" style="background: #3B3F5C; font-size: 10px">
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">FECHAS</th>
                                <th class="table-th text-withe text-center">TIEMPO</th>
                                {{-- <th class="table-th text-withe text-center">MINUTOS</th> --}}
                                <th class="table-th text-withe text-center">SERVICIO</th>
                                <th class="table-th text-withe text-center">ESTADO</th>
                                <th class="table-th text-withe text-center">OPCIONES</th>
                                <th class="table-th text-withe text-center">TECNICO RECEPTOR</th>
                                <th class="table-th text-withe text-center">CÓDIGO ORDEN</th>
                            </tr>
                        </thead>
                        @if ($condicional == 'Pendientes')
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td class="text-center" style="{{ substr($d->horas, 0, 3)<=24 ? 'background-color: #FF0000 !important' : 'background-color: #ff851b !important' }}">
                                            <h6>{{ $loop->iteration }}</h6>
                                        </td>
                                        @foreach ($d->movservices as $mv)
                                            <td class="text-center">
                                                <h6>{{ \Carbon\Carbon::parse($d->fecha_estimada_entrega)->format('d/m/Y h:i:s') }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->horas }}</h6>
                                            </td>
                                            {{-- <td class="text-center">
                                                <h6>{{ $d->minutos }}</h6>
                                            </td> --}}
                                        @endforeach
                                        <td class="text-center">
                                            <h6>{{ $d->categoria->nombre }} {{ $d->marca }}</h6>
                                        </td>
                                        @foreach ($d->movservices as $mv)
                                            <td class="text-center">
                                                <h6>{{ $mv->movs->type }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <a class="shadow-none badge badge-primary"
                                                    href="{{ url('idorderservice' . '/' . $d->OrderServicio->id) }}"
                                                    style='font-size:18px'>Seleccionar</a>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $mv->movs->usermov->name }}</h6>
                                            </td>
                                            
                                        @endforeach
                                        <td class="text-center">
                                            <h6>{{ $d->OrderServicio->id }}</h6>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @elseif($condicional == 'Propios')
                            <tbody>
                                @foreach ($data as $d2)
                                    <tr>
                                        <td class="text-center" style="{{ substr($d2->horas, 0, 3)<=24 ? 'background-color: #FF0000 !important' : 'background-color: #ff851b !important' }}">
                                            <h6>{{ $loop->iteration }}</h6>
                                        </td>
                                        @foreach ($d2->movservices as $mv2)
                                            @if ($mv2->movs->type == 'PROCESO')
                                                <td class="text-center">
                                                    <h6>{{ \Carbon\Carbon::parse($d2->fecha_estimada_entrega)->format('d/m/Y h:i:s') }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6>{{ $d2->horas }}</h6>
                                                </td>
                                            @endif
                                        @endforeach
                                        <td class="text-center">
                                            <h6>{{ $d2->categoria->nombre }} {{ $d2->marca }}</h6>
                                        </td>
                                        @foreach ($d2->movservices as $mv2)
                                            @if ($mv2->movs->type == 'PROCESO' && $mv2->movs->status == 'ACTIVO')
                                                <td class="text-center">
                                                    <h6>{{ $mv2->movs->type }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <a class="shadow-none badge badge-primary"
                                                        href="{{ url('idorderservice' . '/' . $d2->OrderServicio->id) }}"
                                                        style='font-size:18px'>Seleccionar</a>
                                                </td>
                                                <td class="text-center">
                                                    <h6>{{ $mv2->movs->usermov->name }}</h6>
                                                </td>
                                            @endif
                                        @endforeach
                                        <td class="text-center">
                                            <h6>{{ $d2->OrderServicio->id }}</h6>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @elseif($condicional == 'Terminados')
                        <tbody>
                            @foreach ($data as $d3)
                                <tr>
                                    <td class="text-center" style="{{ substr($d3->horas, 0, 3)<=24 ? 'background-color: #FF0000 !important' : 'background-color: #ff851b !important' }}">
                                        <h6>{{ $loop->iteration }}</h6>
                                    </td>
                                    @foreach ($d3->movservices as $mv3)
                                        @if ($mv3->movs->type == 'TERMINADO')
                                            <td class="text-center">
                                                <h6>{{ \Carbon\Carbon::parse($d3->fecha_estimada_entrega)->format('d/m/Y h:i:s') }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ \Carbon\Carbon::parse($mv3->movs->created_at)->format('d/m/Y h:i:s') }}</h6>
                                            </td>
                                        @endif
                                    @endforeach
                                    <td class="text-center">
                                        <h6>{{ $d3->categoria->nombre }} {{ $d3->marca }}</h6>
                                    </td>
                                    @foreach ($d3->movservices as $mv3)
                                        @if ($mv3->movs->type == 'TERMINADO' && $mv3->movs->status == 'ACTIVO')
                                            <td class="text-center">
                                                <h6>{{ $mv3->movs->type }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <a class="shadow-none badge badge-primary"
                                                    href="{{ url('idorderservice' . '/' . $d3->OrderServicio->id) }}"
                                                    style='font-size:18px'>Seleccionar</a>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $mv3->movs->usermov->name }}</h6>
                                            </td>
                                        @endif
                                    @endforeach
                                    <td class="text-center">
                                        <h6>{{ $d3->OrderServicio->id }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        @elseif($condicional == 'TerminadosTodos')
                        <tbody>
                            @foreach ($data as $d4)
                                <tr>
                                    <td class="text-center" style="{{ substr($d4->horas, 0, 3)<=24 ? 'background-color: #FF0000 !important' : 'background-color: #ff851b !important' }}">
                                        <h6>{{ $loop->iteration }}</h6>
                                    </td>
                                    @foreach ($d4->movservices as $mv4)
                                        @if ($mv4->movs->type == 'TERMINADO')
                                            <td class="text-center">
                                                <h6>{{ \Carbon\Carbon::parse($d4->fecha_estimada_entrega)->format('d/m/Y h:i:s') }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ \Carbon\Carbon::parse($mv4->movs->created_at)->format('d/m/Y h:i:s') }}</h6>
                                            </td>
                                        @endif
                                    @endforeach
                                    <td class="text-center">
                                        <h6>{{ $d4->categoria->nombre }} {{ $d4->marca }}</h6>
                                    </td>
                                    @foreach ($d4->movservices as $mv4)
                                        @if ($mv4->movs->type == 'TERMINADO' && $mv4->movs->status == 'ACTIVO')
                                            <td class="text-center">
                                                <h6>{{ $mv4->movs->type }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <a class="shadow-none badge badge-primary"
                                                    href="{{ url('idorderservice' . '/' . $d4->OrderServicio->id) }}"
                                                    style='font-size:18px'>Seleccionar</a>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $mv4->movs->usermov->name }}</h6>
                                            </td>
                                        @endif
                                    @endforeach
                                    <td class="text-center">
                                        <h6>{{ $d4->OrderServicio->id }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        @elseif($condicional == 'EntregadosPropios')
                        <tbody>
                            @foreach ($data as $d5)
                                <tr>
                                    <td class="text-center" style="{{ substr($d5->horas, 0, 3)<=24 ? 'background-color: #FF0000 !important' : 'background-color: #ff851b !important' }}">
                                        <h6>{{ $loop->iteration }}</h6>
                                    </td>
                                    @foreach ($d5->movservices as $mv5)
                                        @if ($mv5->movs->type == 'ENTREGADO')
                                            <td class="text-center">
                                                <h6>{{ \Carbon\Carbon::parse($d5->fecha_estimada_entrega)->format('d/m/Y h:i:s') }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ \Carbon\Carbon::parse($mv5->movs->created_at)->format('d/m/Y h:i:s') }}</h6>
                                            </td>
                                        @endif
                                    @endforeach
                                    <td class="text-center">
                                        <h6>{{ $d5->categoria->nombre }} {{ $d5->marca }}</h6>
                                    </td>
                                    @foreach ($d5->movservices as $mv5)
                                        @if ($mv5->movs->type == 'ENTREGADO' && $mv5->movs->status == 'ACTIVO')
                                            <td class="text-center">
                                                <h6>{{ $mv5->movs->type }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <a class="shadow-none badge badge-primary"
                                                    href="{{ url('idorderservice' . '/' . $d5->OrderServicio->id) }}"
                                                    style='font-size:18px'>Seleccionar</a>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $mv5->movs->usermov->name }}</h6>
                                            </td>
                                        @endif
                                    @endforeach
                                    <td class="text-center">
                                        <h6>{{ $d5->OrderServicio->id }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                    {{ $data->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
