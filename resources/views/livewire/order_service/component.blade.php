<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">

                    {{-- @if (@Auth::user()->hasPermissionTo('Modificar_Detalle_Serv_Entregado'))
                    <a href="javascript:void(0)" class="btn btn-dark" 
                    wire:click="DeleteAllServices()">VACIAR BD SERVICIOS</a>
                    @endif --}}

                    <a href="javascript:void(0)" class="btn btn-dark" wire:click="IrInicio" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">IR A
                        INICIO</a>
                    @if (@Auth::user()->hasPermissionTo('Recepcionar_Servicio'))
                        <a href="javascript:void(0)" class="btn btn-dark" wire:click="GoService"
                            style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">AGREGAR</a>
                    @endif
                </ul>

            </div>

            {{-- SEARCH-> --}}
            <div class="row justify-content-between">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-gp">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0" type="text" wire:model="search" placeholder="Buscar"
                            class="form-control">

                    </div>

                </div>

                <div class="form-group">
                    <div class="n-chk">
                        <label class="new-control new-radio radio-classic-primary">
                            <input type="radio" class="new-control-input" name="custom-radio-4" id="libres"
                                value="MiSucursal" wire:model="condicion">
                            <span class="new-control-indicator"></span>
                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">MI SUCURSAL</h6>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="n-chk">
                        <label class="new-control new-radio radio-classic-primary">
                            <input type="radio" class="new-control-input" name="custom-radio-4" id="ocupados"
                                value="Todos" wire:model="condicion" checked>
                            <span class="new-control-indicator"></span>
                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">TODAS LAS SUCURSALES</h6>
                        </label>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-sm-12">
                    <select wire:model.lazy="opciones" class="form-control" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                        <option value="PENDIENTE">PENDIENTE</option>
                        <option value="PROCESO">PROCESO</option>
                        <option value="TERMINADO">TERMINADO</option>
                        <option value="ENTREGADO">ENTREGADO</option>
                        <option value="ABANDONADO">ABANDONADO</option>
                        @if (@Auth::user()->hasPermissionTo('Anular_Servicio'))
                            <option value="ANULADO">ANULADO</option>
                        @endif
                        <option value="TODOS">TODOS</option>
                        <option value="fechas">POR FECHA</option>
                    </select>
                    @error('opciones')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            @if ($opciones == 'fechas')
                <div class="row">
                    <div class="col-sm-2">
                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Elige el usuario</h6>
                        <div class="form-group">
                            <select wire:model="userId" class="form-control" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                <option value="0">Todos</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Elige el estado</h6>
                        <div class="form-group">
                            <select style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0" wire:model="estado" class="form-control">
                                <option value="Todos">Todos</option>
                                <option value="PENDIENTE">Pendiente</option>
                                <option value="PROCESO">Proceso</option>
                                <option value="TERMINADO">Terminado</option>
                                <option value="ENTREGADO">Entregado</option>
                                <option value="ABANDONADO">Abandonado</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Elige el tipo de reporte</h6>
                        <div class="form-group">
                            <select style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0" wire:model="reportType" class="form-control">
                                <option value="0">Servicios del día</option>
                                <option value="1">Servicios por fecha</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2 ">
                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Fecha desde</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateFrom"
                                min="" max="" class="form-control flatpickr" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                        </div>
                    </div>

                    <div class="col-sm-2 ">
                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">Fecha hasta</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo"
                                min="" max="" class="form-control flatpickr" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                        </div>
                    </div>
                </div>
            @endif

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-striped mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0" class="table-th text-withe text-center" width="2%">#</th>
                                <th style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0" class="table-th text-withe text-center" width="62%">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="row">
                                            <div class="col-sm-2">CLIENTE</div>
                                            <div class="col-sm-2">FECHA</div>
                                            <div class="col-sm-4">SERVICIOS</div>
                                            <div class="col-sm-4">ESTADO</div>
                                        </div>
                                    </div>
                                </th>
                                <th style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0" class="table-th text-withe text-center" width="7%">CÓDIGO
                                </th>
                                <th style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0" class="table-th text-withe text-center" width="7%">TOTAL</th>
                                <th style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0" class="table-th text-withe text-center" width="8%">A CUENTA
                                </th>
                                <th style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0" class="table-th text-withe text-center" width="7%">SALDO</th>
                                <th style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0" class="table-th text-withe text-center" width="7%">ACCIONES
                                </th>
                            </tr>
                        </thead>

                        {{-- Opcion de ANULADOS --}}
                        @if ($opciones == 'ANULADO')
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        {{-- # --}}
                                        <td width="2%">
                                            <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                {{ $loop->iteration }}</h6>
                                        </td>
                                        @php
                                            $mytotal = 0;
                                            $myacuenta = 0;
                                            $mysaldo = 0;
                                        @endphp
                                        <td width="62%">

                                            @foreach ($item->services as $key => $service)
                                                {{-- @php
                                                    $mytotal += $service->movservices[0]->movs->import;
                                                    $myacuenta += $service->movservices[0]->movs->on_account;
                                                    $mysaldo += $service->movservices[0]->movs->saldo;
                                                @endphp --}}
                                                <div class="col-sm-12 col-md-12">
                                                    <div class="row">
                                                        {{-- CLIENTE --}}
                                                        <div class="col-sm-2">
                                                            @if ($key == 0)
                                                                <h6 class="table-th text-withe text-center"
                                                                    style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>
                                                                        {{ $service->movservices[0]->movs->climov->client->nombre }}</b>
                                                                </h6>
                                                            @endif
                                                        </div>
                                                        {{-- FECHA --}}
                                                        @foreach ($service->movservices as $mm)
                                                            @if ($mm->movs->status == 'INACTIVO' && $mm->movs->type == 'ANULADO')
                                                                <div class="col-sm-2">
                                                                    <h6 class="table-th text-withe text-center"
                                                                        style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                        {{ \Carbon\Carbon::parse($mm->movs->created_at)->format('d/m/Y h:i:s') }}
                                                                    </h6><br />
                                                                </div>
                                                            @endif
                                                        @endforeach

                                                        {{-- SERVICIOS --}}
                                                        <div class="col-sm-4">
                                                            <a href="javascript:void(0)"
                                                                wire:click="InfoService({{ $service->id }})"
                                                                title="Ver Servicio">
                                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                    {{ $service->categoria->nombre }}&nbsp{{ $service->marca }}&nbsp
                                                                    | {{ $service->detalle }}&nbsp |
                                                                    {{ $service->falla_segun_cliente }}</h6>
                                                            </a>

                                                            {{-- @foreach ($service->movservices as $mm)
                                                                @if ($mm->movs->status == 'INACTIVO' && $mm->movs->type == 'ANULADO')
                                                                    <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Responsable:</b>
                                                                        {{ $mm->movs->usermov->name }}</h6>
                                                                @endif
                                                            @endforeach --}}

                                                            @php
                                                                $terminado;
                                                                $valorbooleano = false;
                                                            @endphp
                                                            @foreach ($service->movservices as $mm)
                                                                @if ($mm->movs->type == 'TERMINADO')
                                                                    @php
                                                                        $terminado = $mm->movs->usermov->name;
                                                                        $valorbooleano = true;
                                                                    @endphp
                                                                @endif
                                                                @if ($mm->movs->status == 'INACTIVO' && $mm->movs->type == 'ANULADO' && $valorbooleano == true)
                                                                    <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Responsable:</b>
                                                                        {{ $terminado }}</h6>
                                                                    @php
                                                                        $valorbooleano = false;
                                                                    @endphp
                                                                @elseif($mm->movs->status == 'INACTIVO' && $mm->movs->type == 'ANULADO')
                                                                    <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Responsable:</b>
                                                                        {{ $mm->movs->usermov->name }}</h6>
                                                                @endif

                                                                {{-- @if ($mm->movs->status == 'INACTIVO' && $mm->movs->type == 'ANULADO')
                                                                        @foreach ($mm->movs->usermov->sucursalusers as $sucusu)
                                                                            @if ($sucusu->estado == 'ACTIVO')
                                                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Sucursal: </b>
                                                                                {{$sucusu->sucursal->name}}</h6>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif --}}
                                                            @endforeach
                                                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Sucursal: </b>
                                                                {{ $service->sucursalServ->name }}</h6>
                                                        </div>
                                                        {{-- ESTADO --}}
                                                        <div class="col-sm-4">
                                                            @if ($mm->movs->type == 'PENDIENTE' && $mm->movs->status == 'ACTIVO')
                                                                <h6 class="badge bg-danger text-center"
                                                                    style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                    <b>{{ $mm->movs->type }}</b>
                                                                </h6>
                                                            @else
                                                                @if ($mm->movs->type == 'PROCESO' && $mm->movs->status == 'ACTIVO')
                                                                    <h6 class="badge bg-secondary text-center"
                                                                        style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                        <b>{{ $mm->movs->type }}</b>
                                                                    </h6>
                                                                @else
                                                                    @if ($mm->movs->type == 'TERMINADO' && $mm->movs->status == 'ACTIVO')
                                                                        <h6 class="badge bg-warning text-center"
                                                                            style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                            <b>{{ $mm->movs->type }}</b>
                                                                        </h6>
                                                                    @else
                                                                        @if ($mm->movs->type == 'ENTREGADO' && $mm->movs->status == 'ACTIVO')
                                                                            <h6 class="badge bg-success text-center"
                                                                                style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                <b>{{ $mm->movs->type }}</b>
                                                                            </h6>
                                                                        @else
                                                                            @if ($mm->movs->type == 'ANULADO' && $mm->movs->status == 'INACTIVO')
                                                                                <h6 class="badge bg-info text-center"
                                                                                    style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                    <b>{{ $mm->movs->type }}</b>
                                                                                </h6>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endif
                                                            <h6 class="table-th text-withe text-left"
                                                                style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                Serv: {{ $item->type_service }}
                                                            </h6>
                                                            @if (@Auth::user()->hasPermissionTo('Recepcionar_Servicio'))
                                                                @if ($mm->movs->type == 'PENDIENTE')
                                                                    <a style="font-size: 60%" href="javascript:void(0)"
                                                                        class="btn btn-dark mtmobile"
                                                                        wire:click="Edit({{ $service->id }})"
                                                                        title="Cambiar Estado">{{ $mm->movs->type }}</a>
                                                                @endif
                                                            @endif

                                                            @if (!empty(session('sesionCaja')) && @Auth::user()->hasPermissionTo('Boton_Entregar_Servicio'))
                                                                @if ($mm->movs->type == 'TERMINADO')
                                                                    <a style="font-size: 60%" href="javascript:void(0)"
                                                                        class="btn btn-dark mtmobile"
                                                                        wire:click="DetallesTerminado({{ $service->id }})"
                                                                        title="Cambiar Estado">Entregar</a>
                                                                @endif
                                                            @endif

                                                            @if ($mm->movs->type != 'ENTREGADO')
                                                                <a style="font-size: 60%" href="javascript:void(0)"
                                                                    class="btn btn-dark mtmobile"
                                                                    wire:click="Detalles({{ $service->id }})"
                                                                    title="Cambiar Estado">Detalle</a>
                                                            @endif

                                                            @if ($mm->movs->type == 'ENTREGADO')
                                                                <a style="font-size: 60%" href="javascript:void(0)"
                                                                    class="btn btn-dark mtmobile"
                                                                    wire:click="DetalleEntregado({{ $service->id }})"
                                                                    title="Ver Detalle">Detalle</a>
                                                            @endif

                                                            @if (count($item->services) - 1 != $key)
                                                                <br />
                                                            @endif
                                                        </div>
                                                    </div>
                                                    {{-- BORDE ENTRE SERVICIOS --}}
                                                    @if (count($item->services) - 1 != $key)
                                                        <hr
                                                            style="border-color: black; margin-top: 0px; margin-bottom: 3px; margin-left: 5px; margin-right:5px">
                                                        <br />
                                                    @endif
                                                </div>
                                                @php
                                                    $mytotal += $mm->movs->import;
                                                    $myacuenta += $mm->movs->on_account;
                                                    $mysaldo += $mm->movs->saldo;
                                                @endphp
                                            @endforeach
                                        </td>
                                        {{-- CODIGO --}}
                                        <td class="text-center" width="7%">
                                            <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                {{ $item->id }}</h6>
                                        </td>
                                        {{-- @if ($item->id < 10)
                                            <td class="text-center" width="7%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">000{{ $item->id }}</h6>
                                            </td>
                                        @endif
                                        @if ($item->id < 100 && $item->id >= 10)
                                            <td class="text-center" width="7%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">00{{ $item->id }}</h6>
                                            </td>
                                        @endif
                                        @if ($item->id < 1000 && $item->id >= 100)
                                            <td class="text-center" width="7%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">0{{ $item->id }}</h6>
                                            </td>
                                        @endif
                                        @if ($item->id < 10000 && $item->id >= 1000)
                                            <td class="text-center" width="7%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $item->id }}</h6>
                                            </td>
                                        @endif --}}

                                        {{-- TOTAL --}}
                                        <td class="text-center" width="7%">
                                            <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                {{ number_format($mytotal, 2) }}
                                            </h6>
                                        </td>
                                        {{-- A CUENTA --}}
                                        <td class="text-center" width="8%">
                                            <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                {{ number_format($myacuenta, 2) }}
                                            </h6>
                                        </td>
                                        {{-- SALDO --}}
                                        <td class="text-center" width="7%">
                                            <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                {{ number_format($mysaldo, 2) }}
                                            </h6>
                                        </td>
                                        {{-- ACCIONES --}}
                                        <td class="text-center" width="7%">
                                            <a style="font-size: 60%" href="javascript:void(0)"
                                                class="btn btn-dark mtmobile"
                                                wire:click="VerOpciones({{ $item->id }})"
                                                title="Opciones">Opciones</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            {{-- Se muestran TODOS los servicios junto con los ANULADOS --}}
                            <tbody>
                                @foreach ($data as $item)
                                    @if (@Auth::user()->hasPermissionTo('Anular_Servicio'))
                                        <tr>
                                            {{-- # --}}
                                            <td width="2%" {{-- style="background-color: #f7861c !important" --}}>
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                    {{ $loop->iteration }}</h6>
                                            </td>
                                            {{-- @foreach ($item->services as $servicess)
                                                @foreach ($servicess->movservices as $mm)
                                                    @if ($mm->movs->status == 'INACTIVO' && $mm->movs->type == 'ANULADO')
                                                        <td width="2%" style="background-color: #f7861c !important">
                                                            <h6 class="table-th text-withe text-center"
                                                                style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $loop->iteration }}</h6>
                                                        </td>
                                                    @else
                                                        @if ($mm->movs->status == 'ACTIVO' && $mm->movs->type == 'PENDIENTE')
                                                            <td width="2%" style="background-color: #f81b1b !important">
                                                                <h6 class="table-th text-withe text-center"
                                                                    style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $loop->iteration }}
                                                                </h6>
                                                            </td>
                                                        @else
                                                            @if ($mm->movs->status == 'ACTIVO' && $mm->movs->type == 'PROCESO')
                                                                <td width="2%"
                                                                    style="background-color: #c1c1c1 !important">
                                                                    <h6 class="table-th text-withe text-center"
                                                                        style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $loop->iteration }}
                                                                    </h6>
                                                                </td>
                                                            @else
                                                                @if ($mm->movs->status == 'ACTIVO' && $mm->movs->type == 'TERMINADO')
                                                                    <td width="2%"
                                                                        style="background-color: #e2f83c !important">
                                                                        <h6 class="table-th text-withe text-center"
                                                                            style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                            {{ $loop->iteration }}</h6>
                                                                    </td>
                                                                @else
                                                                    @if ($mm->movs->status == 'ACTIVO' && $mm->movs->type == 'ENTREGADO')
                                                                        <td width="2%"
                                                                            style="background-color: #3cf842 !important">
                                                                            <h6 class="table-th text-withe text-center"
                                                                                style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                {{ $loop->iteration }}</h6>
                                                                        </td>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endforeach --}}
                                            @php
                                                $mytotal = 0;
                                                $myacuenta = 0;
                                                $mysaldo = 0;
                                            @endphp
                                            <td width="62%">

                                                @foreach ($item->services as $key => $service)
                                                    {{-- @php
                                                    $mytotal += $service->movservices[0]->movs->import;
                                                    $myacuenta += $service->movservices[0]->movs->on_account;
                                                    $mysaldo += $service->movservices[0]->movs->saldo;
                                                @endphp --}}
                                                    <div class="col-sm-12 col-md-12">
                                                        <div class="row">
                                                            {{-- CLIENTE --}}
                                                            <div class="col-sm-2">
                                                                @if ($key == 0)
                                                                    <h6 class="table-th text-withe text-center"
                                                                        style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>
                                                                            {{ $service->movservices[0]->movs->climov->client->nombre }}</b>
                                                                    </h6>
                                                                @endif
                                                            </div>
                                                            {{-- FECHA --}}
                                                            @foreach ($service->movservices as $mm)
                                                                @if ($mm->movs->status == 'ACTIVO' || ($mm->movs->status == 'INACTIVO' && $mm->movs->type == 'ANULADO'))
                                                                    <div class="col-sm-2">
                                                                        <h6 class="table-th text-withe text-center"
                                                                            style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                            {{ \Carbon\Carbon::parse($mm->movs->created_at)->format('d/m/Y h:i:s') }}
                                                                        </h6><br />
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                            {{-- SERVICIOS --}}
                                                            <div class="col-sm-4">
                                                                <a href="javascript:void(0)"
                                                                    wire:click="InfoService({{ $service->id }})"
                                                                    title="Ver Servicio">
                                                                    <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                        {{ $service->categoria->nombre }}&nbsp{{ $service->marca }}&nbsp
                                                                        | {{ $service->detalle }}&nbsp |
                                                                        {{ $service->falla_segun_cliente }}</h6>
                                                                </a>
                                                                @php
                                                                    $terminado;
                                                                    $valorbooleano = false;
                                                                @endphp
                                                                @foreach ($service->movservices as $mm)
                                                                    @if ($mm->movs->type == 'TERMINADO')
                                                                        @php
                                                                            $terminado = $mm->movs->usermov->name;
                                                                            $valorbooleano = true;
                                                                        @endphp
                                                                    @endif
                                                                    @if (($mm->movs->status == 'ACTIVO' || ($mm->movs->status == 'INACTIVO' && $mm->movs->type == 'ANULADO')) && $valorbooleano == true)
                                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Responsable:</b>
                                                                            {{ $terminado }}</h6>
                                                                        @php
                                                                            $valorbooleano = false;
                                                                        @endphp
                                                                    @elseif($mm->movs->status == 'ACTIVO' || ($mm->movs->status == 'INACTIVO' && $mm->movs->type == 'ANULADO'))
                                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Responsable:</b>
                                                                            {{ $mm->movs->usermov->name }}</h6>
                                                                    @endif

                                                                    {{-- @if ($mm->movs->status == 'ACTIVO' || ($mm->movs->status == 'INACTIVO' && $mm->movs->type == 'ANULADO'))
                                                                        @foreach ($mm->movs->usermov->sucursalusers as $sucusu)
                                                                            @if ($sucusu->estado == 'ACTIVO')
                                                                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Sucursal: </b>
                                                                                {{$sucusu->sucursal->name}}</h6>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif --}}
                                                                @endforeach
                                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Sucursal: </b>
                                                                    {{ $service->sucursalServ->name }}</h6>
                                                            </div>
                                                            {{-- ESTADO --}}
                                                            <div class="col-sm-4">
                                                                @if ($mm->movs->type == 'PENDIENTE' && $mm->movs->status == 'ACTIVO')
                                                                    <h6 class="badge bg-danger text-center"
                                                                        style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                        <b>{{ $mm->movs->type }}</b>
                                                                    </h6>
                                                                @else
                                                                    @if ($mm->movs->type == 'PROCESO' && $mm->movs->status == 'ACTIVO')
                                                                        <h6 class="badge bg-secondary text-center"
                                                                            style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                            <b>{{ $mm->movs->type }}</b>
                                                                        </h6>
                                                                    @else
                                                                        @if ($mm->movs->type == 'TERMINADO' && $mm->movs->status == 'ACTIVO')
                                                                            <h6 class="badge bg-warning text-center"
                                                                                style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                <b>{{ $mm->movs->type }}</b>
                                                                            </h6>
                                                                        @else
                                                                            @if ($mm->movs->type == 'ENTREGADO' && $mm->movs->status == 'ACTIVO')
                                                                                <h6 class="badge bg-success text-center"
                                                                                    style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                    <b>{{ $mm->movs->type }}</b>
                                                                                </h6>
                                                                            @else
                                                                                @if ($mm->movs->type == 'ANULADO' && $mm->movs->status == 'INACTIVO')
                                                                                    <h6 class="badge bg-info text-center"
                                                                                        style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                        <b>{{ $mm->movs->type }}</b>
                                                                                    </h6>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                                <h6 class="table-th text-withe text-left"
                                                                    style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                    Serv: {{ $item->type_service }}
                                                                </h6>
                                                                @if (@Auth::user()->hasPermissionTo('Recepcionar_Servicio'))
                                                                    @if ($mm->movs->type == 'PENDIENTE')
                                                                        <a style="font-size: 60%"
                                                                            href="javascript:void(0)"
                                                                            class="btn btn-dark mtmobile"
                                                                            wire:click="Edit({{ $service->id }})"
                                                                            title="Cambiar Estado">{{ $mm->movs->type }}</a>
                                                                    @endif
                                                                @endif

                                                                @if (!empty(session('sesionCaja')) && @Auth::user()->hasPermissionTo('Boton_Entregar_Servicio'))
                                                                    @if ($mm->movs->type == 'TERMINADO')
                                                                        <a style="font-size: 60%"
                                                                            href="javascript:void(0)"
                                                                            class="btn btn-dark mtmobile"
                                                                            wire:click="DetallesTerminado({{ $service->id }})"
                                                                            title="Cambiar Estado">Entregar</a>
                                                                    @endif
                                                                @endif

                                                                @if ($mm->movs->type != 'ENTREGADO')
                                                                    <a style="font-size: 60%" href="javascript:void(0)"
                                                                        class="btn btn-dark mtmobile"
                                                                        wire:click="Detalles({{ $service->id }})"
                                                                        title="Cambiar Estado">Detalle</a>
                                                                @endif

                                                                @if ($mm->movs->type == 'ENTREGADO')
                                                                    <a style="font-size: 60%" href="javascript:void(0)"
                                                                        class="btn btn-dark mtmobile"
                                                                        wire:click="DetalleEntregado({{ $service->id }})"
                                                                        title="Ver Detalle">Detalle</a>
                                                                @endif

                                                                @if (count($item->services) - 1 != $key)
                                                                    <br />
                                                                @endif
                                                            </div>
                                                        </div>
                                                        {{-- BORDE ENTRE SERVICIOS --}}
                                                        @if (count($item->services) - 1 != $key)
                                                            <hr
                                                                style="border-color: black; margin-top: 0px; margin-bottom: 3px; margin-left: 5px; margin-right:5px">
                                                            <br />
                                                        @endif
                                                    </div>

                                                    @php
                                                        $mytotal += $mm->movs->import;
                                                        $myacuenta += $mm->movs->on_account;
                                                        $mysaldo += $mm->movs->saldo;
                                                    @endphp
                                                @endforeach
                                            </td>
                                            {{-- CODIGO --}}
                                            <td class="text-center" width="7%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                    {{ $item->id }}</h6>
                                            </td>
                                            {{-- @if ($item->id < 10)
                                            <td class="text-center" width="7%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">000{{ $item->id }}</h6>
                                            </td>
                                        @endif
                                        @if ($item->id < 100 && $item->id >= 10)
                                            <td class="text-center" width="7%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">00{{ $item->id }}</h6>
                                            </td>
                                        @endif
                                        @if ($item->id < 1000 && $item->id >= 100)
                                            <td class="text-center" width="7%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">0{{ $item->id }}</h6>
                                            </td>
                                        @endif
                                        @if ($item->id < 10000 && $item->id >= 1000)
                                            <td class="text-center" width="7%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $item->id }}</h6>
                                            </td>
                                        @endif --}}
                                            {{-- TOTAL --}}
                                            <td class="text-center" width="7%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                    {{ number_format($mytotal, 2) }}
                                                </h6>
                                            </td>
                                            {{-- A CUENTA --}}
                                            <td class="text-center" width="8%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                    {{ number_format($myacuenta, 2) }}
                                                </h6>
                                            </td>
                                            {{-- SALDO --}}
                                            <td class="text-center" width="7%">
                                                <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                    {{ number_format($mysaldo, 2) }}
                                                </h6>
                                            </td>
                                            {{-- ACCIONES --}}
                                            <td class="text-center" width="7%">
                                                <a style="font-size: 60%" href="javascript:void(0)"
                                                    class="btn btn-dark mtmobile"
                                                    wire:click="VerOpciones({{ $item->id }})"
                                                    title="Opciones">Opciones</a>
                                            </td>
                                        </tr>
                                    @else
                                        {{-- Desde aqui se muestran TODOS los servicios sin los ANULADOS --}}
                                        {{-- Para los usuarios sin permisos de ANULAR --}}
                                        @if ($item->status == 'ACTIVO')
                                            <tr>
                                                {{-- # --}}
                                                <td width="2%">
                                                    <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                        {{ $loop->iteration }}</h6>
                                                </td>
                                                @php
                                                    $mytotal = 0;
                                                    $myacuenta = 0;
                                                    $mysaldo = 0;
                                                @endphp
                                                <td width="62%">

                                                    @foreach ($item->services as $key => $service)
                                                        {{-- @php
                                                $mytotal += $service->movservices[0]->movs->import;
                                                $myacuenta += $service->movservices[0]->movs->on_account;
                                                $mysaldo += $service->movservices[0]->movs->saldo;
                                            @endphp --}}
                                                        <div class="col-sm-12 col-md-12">
                                                            <div class="row">
                                                                {{-- CLIENTE --}}
                                                                <div class="col-sm-2">
                                                                    @if ($key == 0)
                                                                        <h6 class="table-th text-withe text-center"
                                                                            style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>
                                                                                {{ $service->movservices[0]->movs->climov->client->nombre }}</b>
                                                                        </h6>
                                                                    @endif
                                                                </div>
                                                                {{-- FECHA --}}
                                                                @foreach ($service->movservices as $mm)
                                                                    @if ($mm->movs->status == 'ACTIVO')
                                                                        <div class="col-sm-2">
                                                                            <h6 class="table-th text-withe text-center"
                                                                                style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                {{ \Carbon\Carbon::parse($mm->movs->created_at)->format('d/m/Y h:i:s') }}
                                                                            </h6><br />
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                                {{-- SERVICIOS --}}
                                                                <div class="col-sm-4">
                                                                    <a href="javascript:void(0)"
                                                                        wire:click="InfoService({{ $service->id }})"
                                                                        title="Ver Servicio">
                                                                        <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                            {{ $service->categoria->nombre }}&nbsp{{ $service->marca }}&nbsp
                                                                            | {{ $service->detalle }}&nbsp |
                                                                            {{ $service->falla_segun_cliente }}</h6>
                                                                    </a>

                                                                    {{-- @foreach ($service->movservices as $mm)
                                                            @if ($mm->movs->status == 'ACTIVO')
                                                                <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Responsable:</b>
                                                                    {{ $mm->movs->usermov->name }}</h6>
                                                            @endif
                                                        @endforeach --}}

                                                                    @php
                                                                        $terminado;
                                                                        $valorbooleano = false;
                                                                    @endphp
                                                                    @foreach ($service->movservices as $mm)
                                                                        @if ($mm->movs->type == 'TERMINADO')
                                                                            @php
                                                                                $terminado = $mm->movs->usermov->name;
                                                                                $valorbooleano = true;
                                                                            @endphp
                                                                        @endif
                                                                        @if ($mm->movs->status == 'ACTIVO' && $valorbooleano == true)
                                                                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                <b>Responsable:</b>
                                                                                {{ $terminado }}
                                                                            </h6>
                                                                            @php
                                                                                $valorbooleano = false;
                                                                            @endphp
                                                                        @elseif($mm->movs->status == 'ACTIVO')
                                                                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                <b>Responsable:</b>
                                                                                {{ $mm->movs->usermov->name }}
                                                                            </h6>
                                                                        @endif

                                                                        {{-- @if ($mm->movs->status == 'ACTIVO')
                                                                        @foreach ($mm->movs->usermov->sucursalusers as $sucusu)
                                                                            @if ($sucusu->estado == 'ACTIVO')
                                                                            <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Sucursal: </b>
                                                                                {{$sucusu->sucursal->name}}</h6>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif --}}
                                                                    @endforeach
                                                                    <h6 style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0"><b>Sucursal: </b>
                                                                        {{ $service->sucursalServ->name }}</h6>
                                                                </div>
                                                                {{-- ESTADO --}}
                                                                <div class="col-sm-4">
                                                                    @if ($mm->movs->type == 'PENDIENTE' && $mm->movs->status == 'ACTIVO')
                                                                        <h6 class="badge bg-danger text-center"
                                                                            style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                            <b>{{ $mm->movs->type }}</b>
                                                                        </h6>
                                                                    @else
                                                                        @if ($mm->movs->type == 'PROCESO' && $mm->movs->status == 'ACTIVO')
                                                                            <h6 class="badge bg-secondary text-center"
                                                                                style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                <b>{{ $mm->movs->type }}</b>
                                                                            </h6>
                                                                        @else
                                                                            @if ($mm->movs->type == 'TERMINADO' && $mm->movs->status == 'ACTIVO')
                                                                                <h6 class="badge bg-warning text-center"
                                                                                    style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                    <b>{{ $mm->movs->type }}</b>
                                                                                </h6>
                                                                            @else
                                                                                @if ($mm->movs->type == 'ENTREGADO' && $mm->movs->status == 'ACTIVO')
                                                                                    <h6 class="badge bg-success text-center"
                                                                                        style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                        <b>{{ $mm->movs->type }}</b>
                                                                                    </h6>
                                                                                @else
                                                                                    @if ($mm->movs->type == 'ANULADO' && $mm->movs->status == 'INACTIVO')
                                                                                        <h6 class="badge bg-info text-center"
                                                                                            style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                                            <b>{{ $mm->movs->type }}</b>
                                                                                        </h6>
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                    <h6 class="table-th text-withe text-left"
                                                                        style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                                        Serv: {{ $item->type_service }}
                                                                    </h6>
                                                                    @if (@Auth::user()->hasPermissionTo('Recepcionar_Servicio'))
                                                                        @if ($mm->movs->type == 'PENDIENTE')
                                                                            <a style="font-size: 60%"
                                                                                href="javascript:void(0)"
                                                                                class="btn btn-dark mtmobile"
                                                                                wire:click="Edit({{ $service->id }})"
                                                                                title="Cambiar Estado">{{ $mm->movs->type }}</a>
                                                                        @endif
                                                                    @endif

                                                                    @if (!empty(session('sesionCaja')) && @Auth::user()->hasPermissionTo('Boton_Entregar_Servicio'))
                                                                        @if ($mm->movs->type == 'TERMINADO')
                                                                            <a style="font-size: 60%"
                                                                                href="javascript:void(0)"
                                                                                class="btn btn-dark mtmobile"
                                                                                wire:click="DetallesTerminado({{ $service->id }})"
                                                                                title="Cambiar Estado">Entregar</a>
                                                                        @endif
                                                                    @endif

                                                                    @if ($mm->movs->type != 'ENTREGADO')
                                                                        <a style="font-size: 60%"
                                                                            href="javascript:void(0)"
                                                                            class="btn btn-dark mtmobile"
                                                                            wire:click="Detalles({{ $service->id }})"
                                                                            title="Cambiar Estado">Detalle</a>
                                                                    @endif

                                                                    @if ($mm->movs->type == 'ENTREGADO')
                                                                        <a style="font-size: 60%"
                                                                            href="javascript:void(0)"
                                                                            class="btn btn-dark mtmobile"
                                                                            wire:click="DetalleEntregado({{ $service->id }})"
                                                                            title="Ver Detalle">Detalle</a>
                                                                    @endif

                                                                    @if (count($item->services) - 1 != $key)
                                                                        <br />
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            {{-- BORDE ENTRE SERVICIOS --}}
                                                            @if (count($item->services) - 1 != $key)
                                                                <hr
                                                                    style="border-color: black; margin-top: 0px; margin-bottom: 3px; margin-left: 5px; margin-right:5px">
                                                                <br />
                                                            @endif
                                                        </div>
                                                        @php
                                                            $mytotal += $mm->movs->import;
                                                            $myacuenta += $mm->movs->on_account;
                                                            $mysaldo += $mm->movs->saldo;
                                                        @endphp
                                                    @endforeach
                                                </td>
                                                {{-- CODIGO --}}
                                                <td class="text-center" width="7%">
                                                    <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                        {{ $item->id }}</h6>
                                                </td>
                                                {{-- @if ($item->id < 10)
                                        <td class="text-center" width="7%">
                                            <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">000{{ $item->id }}</h6>
                                        </td>
                                    @endif
                                    @if ($item->id < 100 && $item->id >= 10)
                                        <td class="text-center" width="7%">
                                            <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">00{{ $item->id }}</h6>
                                        </td>
                                    @endif
                                    @if ($item->id < 1000 && $item->id >= 100)
                                        <td class="text-center" width="7%">
                                            <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">0{{ $item->id }}</h6>
                                        </td>
                                    @endif
                                    @if ($item->id < 10000 && $item->id >= 1000)
                                        <td class="text-center" width="7%">
                                            <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">{{ $item->id }}</h6>
                                        </td>
                                    @endif --}}
                                                {{-- TOTAL --}}
                                                <td class="text-center" width="7%">
                                                    <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                        {{ number_format($mytotal, 2) }}
                                                    </h6>
                                                </td>
                                                {{-- A CUENTA --}}
                                                <td class="text-center" width="8%">
                                                    <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                        {{ number_format($myacuenta, 2) }}
                                                    </h6>
                                                </td>
                                                {{-- SALDO --}}
                                                <td class="text-center" width="7%">
                                                    <h6 class="table-th text-withe text-center" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                                        {{ number_format($mysaldo, 2) }}
                                                    </h6>
                                                </td>
                                                {{-- ACCIONES --}}
                                                <td class="text-center" width="7%">
                                                    <a style="font-size: 60%" href="javascript:void(0)"
                                                        class="btn btn-dark mtmobile"
                                                        wire:click="VerOpciones({{ $item->id }})"
                                                        title="Opciones">Opciones</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        @endif
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-left" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                    <span><b>TOTAL</b></span>
                                </td>
                                {{-- <td class="text-right" colspan="4">
                                    <span><strong>
                                            
                                        ${{ number_format($data->sum('costo'), 2) }}

                                        </strong></span>
                                </td> --}}
                                <td class="text-right" colspan="2" style="font-size: 90%; padding-top: 0; padding-bottom: 0; margin-top: 0; margin-bottom: 0">
                                    <span><strong>
                                            @php
                                                $mytotal = 0;
                                            @endphp
                                            @foreach ($data as $item2)
                                                @foreach ($item2->services as $d)
                                                    @foreach ($d->movservices as $mv)
                                                        @if ($mv->movs->status == 'ACTIVO')
                                                            @php
                                                                $mytotal += $mv->movs->import;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                            ${{ number_format($mytotal, 2) }}
                                        </strong>
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.order_service.form')
    @include('livewire.order_service.formdetalle')
    @include('livewire.order_service.formdetalleentrega')
    @include('livewire.order_service.forminfoservicio')
    @include('livewire.order_service.formopciones')
    @include('livewire.order_service.formentregado')
    @include('livewire.order_service.formeliminar')
    @include('livewire.order_service.formanular')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayofweek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado",
                    ],
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic",
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },
            }
        });

        window.livewire.on('product-added', msg => {
            $('#theModal').modal('hide'),
                noty(msg)
        });
        window.livewire.on('product-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('product-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });

        window.livewire.on('show-detail', Msg => {
            $('#theDetail').modal('show')
        });
        window.livewire.on('detail-hide', msg => {
            $('#theDetail').modal('hide')
        });
        window.livewire.on('detail-hide-msg', msg => {
            $('#theDetail').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-detalle-entrega', Msg => {
            $('#theDetalleEntrega').modal('show')
        });
        window.livewire.on('hide-detalle-entrega', msg => {
            $('#theDetalleEntrega').modal('hide')
        });
        window.livewire.on('hide-detalle-entrega-msg', msg => {
            $('#theDetalleEntrega').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-infserv', Msg => {
            $('#theInfoService').modal('show')
        });
        window.livewire.on('hide-infserv', msg => {
            $('#theInfoService').modal('hide')
        });
        window.livewire.on('hide-infserv-msg', msg => {
            $('#theInfoService').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-options', Msg => {
            $('#theOptions').modal('show')
        });
        window.livewire.on('hide-options', msg => {
            $('#theOptions').modal('hide')
        });
        window.livewire.on('hide-options-msg', msg => {
            $('#theOptions').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-enddetail', Msg => {
            $('#theEndDetail').modal('show')
        });
        window.livewire.on('hide-enddetail', msg => {
            $('#theEndDetail').modal('hide')
        });
        window.livewire.on('hide-enddetail-msg', msg => {
            $('#theEndDetail').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-deletemodal', Msg => {
            $('#theDeleteModal').modal('show')
        });
        window.livewire.on('hide-deletemodal', msg => {
            $('#theDeleteModal').modal('hide')
        });
        window.livewire.on('hide-deletemodal-msg', msg => {
            $('#theDeleteModal').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-modalanular', Msg => {
            $('#ModalAnular').modal('show')
        });
        window.livewire.on('hide-modalanular', msg => {
            $('#ModalAnular').modal('hide')
        });
        window.livewire.on('hide-modalanular-msg', msg => {
            $('#ModalAnular').modal('hide')
            noty(msg)
        });

        window.livewire.on('item', msg => {
            noty(msg)
        });


        window.livewire.on('hidden.bs.modal', function(e) {
            $('.er').css('display', 'none')
        });
    });

    function Confirm(id, name, products) {
        if (products > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar el producto, ' + name + ' porque tiene ' +
                    products + ' ventas relacionadas'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el prouducto ' + '"' + name + '"',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }
</script>
