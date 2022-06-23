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

                    @if (@Auth::user()->hasPermissionTo('Boton_Entregar_Servicio') && @Auth::user()->hasPermissionTo('Recepcionar_Servicio'))
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

                    
                        <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                            <div class="form-group">
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input type="radio" class="new-control-input" name="custom-radio-4" id="libres"
                                            value="Pendientes" wire:model="condicional">
                                        <span class="new-control-indicator"></span>
                                        <h6>SERVICIOS PENDIENTES</h6>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                            <div class="form-group">
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input type="radio" class="new-control-input" name="custom-radio-4"
                                            id="ocupados" value="Propios" wire:model="condicional" checked>
                                        <span class="new-control-indicator"></span>
                                        <h6>SERVICIOS PROPIOS EN PROCESO</h6>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                            <div class="form-group">
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input type="radio" class="new-control-input" name="custom-radio-4"
                                            id="terminado" value="Terminados" wire:model="condicional" checked>
                                        <span class="new-control-indicator"></span>
                                        <h6>SERVICIOS PROPIOS TERMINADOS</h6>
                                    </label>
                                </div>
                            </div>
                        </div>

                        @if (@Auth::user()->hasPermissionTo('Orden_Servicio_Index'))
                            <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                                <ul class="tabs tab-pills">
                                    <a href="{{ url('orderservice') }}" class="btn btn-warning">IR A SERVICIOS</a>
                                </ul>
                            </div>
                        @endif

                </div>
                <div class="row">
                    <div class="col-sm-1 col-md-1">
                    </div>
                    <div class="col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="sucursales" value="MiSucursal"
                                        wire:model="condicion">
                                    <span class="new-control-indicator"></span>
                                    <h6>MI SUCURSAL</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="sucursales" value="Todos"
                                        wire:model="condicion" checked>
                                    <span class="new-control-indicator"></span>
                                    <h6>TODAS LAS SUCURSALES</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(@Auth::user()->hasPermissionTo('Boton_Entregar_Servicio'))
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <label>Buscador</label>
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

                    <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="opciones_cajero" id="terminado"
                                        value="TerminadosTodos" wire:model="condicional">
                                    <span class="new-control-indicator"></span>
                                    <h6>SERVICIOS TERMINADOS</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="opciones_cajero" id="terminado"
                                        value="EntregadosPropios" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span>
                                    <h6>SERVICIOS PROPIOS ENTREGADOS</h6>
                                </label>
                            </div>
                        </div>
                    </div>

                    @if (@Auth::user()->hasPermissionTo('Orden_Servicio_Index'))
                        <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                            <ul class="tabs tab-pills">
                                <a href="{{ url('orderservice') }}" class="btn btn-warning">IR A SERVICIOS</a>
                            </ul>
                        </div>
                    @endif

                </div>
            @elseif(@Auth::user()->hasPermissionTo('Recepcionar_Servicio'))
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

                    <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="libres"
                                        value="Pendientes" wire:model="condicional">
                                    <span class="new-control-indicator"></span>
                                    <h6>SERVICIOS PENDIENTES</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="ocupados"
                                        value="Propios" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span>
                                    <h6>SERVICIOS PROPIOS EN PROCESO</h6>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="terminado"
                                        value="Terminados" wire:model="condicional" checked>
                                    <span class="new-control-indicator"></span>
                                    <h6>SERVICIOS PROPIOS TERMINADOS</h6>
                                </label>
                            </div>
                        </div>
                    </div>

                    @if (@Auth::user()->hasPermissionTo('Orden_Servicio_Index'))
                        <div class="col-lg-2 col-sm-2 col-md-3 mt-4">
                            <ul class="tabs tab-pills">
                                <a href="{{ url('orderservice') }}" class="btn btn-warning">IR A SERVICIOS</a>
                            </ul>
                        </div>
                    @endif

                </div>

                <div class="row">
                    <div class="col-sm-1 col-md-3 mt-4">
                    </div>
                    <div class="col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="sucursales" value="MiSucursal"
                                        wire:model="condicion">
                                    <span class="new-control-indicator"></span>
                                    <h6>MI SUCURSAL</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-3 mt-4">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="sucursales" value="Todos"
                                        wire:model="condicion" checked>
                                    <span class="new-control-indicator"></span>
                                    <h6>TODAS LAS SUCURSALES</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
  





            </div>
         
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-head-bg-primary table-hover">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">FECHAS</th>
                                <th class="table-th text-withe text-center">TIEMPO</th>
                                @if($condicional == 'Terminados' || $condicional == 'TerminadosTodos')
                                <th class="table-th text-withe text-center">DIAS</th>
                                @endif
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
                                        <td class="text-center"
                                            @if (substr($d->horas, 0, 3) <= 2)
                                                style="background-color: #FF0000 !important">
                                            @elseif(substr($d->horas, 0, 3) == 3)
                                                style="background-color: #d6ec02 !important">
                                            @elseif(substr($d->horas, 0, 3) >= 4)
                                                style="background-color: #00eb15 !important">
                                            @endif

                                            {{-- style="{{ substr($d->horas, 0, 3) <= 24? 'background-color: #FF0000 !important': 'background-color: #d6ec02 !important' }}"> --}}
                                            <h6 style="color:#ffffff">{{ $loop->iteration }}</h6>
                                        </td>
                                        @foreach ($d->movservices as $mv)
                                            <td class="text-center">
                                                <h6>{{ \Carbon\Carbon::parse($d->fecha_estimada_entrega)->format('d/m/Y h:i:s') }}
                                                </h6>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $x=0;
                                                @endphp
                                                @if ($d->horas >= 24)
                                                @php
                                                    $x= ($d->horas) / 24;
                                                     
                                                @endphp
                                                <h6>{{ intval($x) }} días<h6>
                                                @else
                                                     @if ($d->horas == 'EXPIRADO')
                                                     <h6>{{ $d->horas }}</h6>
                                                     @else
                                                     <h6>{{ $d->horas }} horas</h6>
                                                     {{-- <h6>{{ $diffmin }}</h6> --}}
                                                     @endif
                                                
                                                @endif
                                                
                                            </td>
                                            {{-- <td class="text-center">
                                                <h6>{{ $d->minutos }}</h6>
                                            </td> --}}
                                        @endforeach
                                        <td class="text-center">
                                            <h6>{{ $d->categoria->nombre }} {{ $d->marca }} {{$d->detalle}}</h6>
                                            <h6><b>Falla:</b> {{$d->falla_segun_cliente}}</h6>
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
                                        <td class="text-center"
                                        @if (substr($d2->horas, 0, 3) <= 2)
                                            style="background-color: #FF0000 !important">
                                        @elseif(substr($d2->horas, 0, 3) == 3)
                                            style="background-color: #d6ec02 !important">
                                        @elseif(substr($d2->horas, 0, 3) >= 4)
                                            style="background-color: #00eb15 !important">
                                        @endif
                                        {{-- style="{{ substr($d2->horas, 0, 3) <= 24? 'background-color: #FF0000 !important': 'background-color: #d6ec02 !important' }}"> --}}
                                            <h6>{{ $loop->iteration }}</h6>
                                        </td>
                                        @foreach ($d2->movservices as $mv2)
                                            @if ($mv2->movs->type == 'PROCESO')
                                                <td class="text-center">
                                                    <h6>{{ \Carbon\Carbon::parse($d2->fecha_estimada_entrega)->format('d/m/Y h:i:s') }}
                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                    $x=0;
                                                @endphp
                                                @if ($d2->horas >= 24)
                                                @php
                                                    $x= ($d2->horas) / 24;
                                                @endphp
                                                <h6>{{ intval($x) }} días<h6>
                                                @else
                                                     @if ($d2->horas == 'EXPIRADO')
                                                     <h6>{{ $d2->horas }}</h6>
                                                     @else
                                                     <h6>{{ $d2->horas }} horas</h6>
                                                     @endif
                                                
                                                @endif
                                                </td>
                                            @endif
                                        @endforeach
                                        <td class="text-center">
                                            <h6>{{ $d2->categoria->nombre }} {{ $d2->marca }} {{$d2->detalle}}</h6>
                                            <h6><b>Falla:</b> {{$d2->falla_segun_cliente}}</h6>
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
                                        <td class="text-center"
                                            @if ($d3->dias < 15)
                                                style="background-color: #00eb15 !important">
                                            @elseif($d3->dias >= 15 && $d3->dias <= 30)
                                                style="background-color: #d6ec02 !important">
                                            @elseif($d3->dias > 30)
                                                style="background-color: #FF0000 !important">
                                            @endif    
                                            {{-- style="{{ substr($d3->horas, 0, 3) <= 24? 'background-color: #FF0000 !important': 'background-color: #d6ec02 !important' }}"> --}}
                                            <h6>{{ $loop->iteration }}</h6>
                                        </td>
                                        @foreach ($d3->movservices as $mv3)
                                            @if ($mv3->movs->type == 'TERMINADO')
                                                <td class="text-center">
                                                    <h6>{{ \Carbon\Carbon::parse($d3->fecha_estimada_entrega)->format('d/m/Y h:i:s') }}
                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6>{{ \Carbon\Carbon::parse($mv3->movs->created_at)->format('d/m/Y h:i:s') }}
                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6>{{ $d3->dias }}</h6>
                                                </td>
                                            @endif
                                        @endforeach
                                        <td class="text-center">
                                            <h6>{{ $d3->categoria->nombre }} {{ $d3->marca }} {{$d3->detalle}}</h6>
                                            <h6><b>Falla:</b> {{$d3->falla_segun_cliente}}</h6>
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
                                        <td class="text-center"
                                        {{-- @if (substr($d4->horas, 0, 3) <= 2)
                                            style="background-color: #FF0000 !important">
                                        @elseif(substr($d4->horas, 0, 3) == 3)
                                            style="background-color: #d6ec02 !important">
                                        @elseif(substr($d4->horas, 0, 3) >= 4)
                                            style="background-color: #00eb15 !important">
                                        @endif --}}
                                            @if ($d4->dias < 15)
                                                style="background-color: #00eb15 !important">
                                            @elseif($d4->dias >= 15 && $d4->dias <= 30)
                                                style="background-color: #d6ec02 !important">
                                            @elseif($d4->dias > 30)
                                                style="background-color: #FF0000 !important">
                                            @endif 
                                            {{-- style="{{ substr($d4->horas, 0, 3) <= 24? 'background-color: #FF0000 !important': 'background-color: #d6ec02 !important' }}"> --}}
                                            <h6>{{ $loop->iteration }}</h6>
                                        </td>
                                        @foreach ($d4->movservices as $mv4)
                                            @if ($mv4->movs->type == 'TERMINADO')
                                                <td class="text-center">
                                                    <h6>{{ \Carbon\Carbon::parse($d4->fecha_estimada_entrega)->format('d/m/Y h:i:s') }}
                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6>{{ \Carbon\Carbon::parse($mv4->movs->created_at)->format('d/m/Y h:i:s') }}
                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6>{{ $d4->dias }}</h6>
                                                </td>
                                            @endif
                                        @endforeach
                                        <td class="text-center">
                                            <h6>{{ $d4->categoria->nombre }} {{ $d4->marca }} {{$d4->detalle}}</h6>
                                            <h6><b>Falla:</b> {{$d4->falla_segun_cliente}}</h6>
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
                                        <td class="text-center">
                                        {{-- @if (substr($d5->horas, 0, 3) <= 2)
                                            style="background-color: #FF0000 !important">
                                        @elseif(substr($d5->horas, 0, 3) == 3)
                                            style="background-color: #d6ec02 !important">
                                        @elseif(substr($d5->horas, 0, 3) >= 4)
                                            style="background-color: #00eb15 !important">
                                        @endif --}}
                                            {{-- style="{{ substr($d5->horas, 0, 3) <= 24? 'background-color: #FF0000 !important': 'background-color: #d6ec02 !important' }}"> --}}
                                            <h6>{{ $loop->iteration }}</h6>
                                        </td>
                                        @foreach ($d5->movservices as $mv5)
                                            @if ($mv5->movs->type == 'ENTREGADO')
                                                <td class="text-center">
                                                    <h6>{{ \Carbon\Carbon::parse($d5->fecha_estimada_entrega)->format('d/m/Y h:i:s') }}
                                                    </h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6>{{ \Carbon\Carbon::parse($mv5->movs->created_at)->format('d/m/Y h:i:s') }}
                                                    </h6>
                                                </td>
                                            @endif
                                        @endforeach
                                        <td class="text-center">
                                            <h6>{{ $d5->categoria->nombre }} {{ $d5->marca }} {{$d5->detalle}}</h6>
                                            <h6><b>Falla:</b> {{$d5->falla_segun_cliente}}</h6>
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
                </div>
            </div>

        </div>
    </div>
</div>
