<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="row justify-content-end">
                    @can('Ver_Generar_Ingreso_Egreso_Boton')
                        <a wire:click.prevent="viewDetails()" class="btn btn-warning">
                            Generar Ingreso/Egreso en cartera
                        </a>
                        <a wire:click.prevent="viewTotales()" class="btn btn-warning">
                            Ver Resumen
                        </a>
                 
                    @endcan
                </ul>
                {{-- <ul class="tabs tab-pills">
                    <a wire:click.prevent="EliminarTigoMoney()" class="btn btn-dark">
                        Eliminar tigo money
                    </a>
                </ul> --}}
                {{-- <ul class="tabs tab-pills">
                    <a wire:click.prevent="EliminarStreaming()" class="btn btn-dark">
                        Eliminar streaming
                    </a>
                </ul> --}}
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12">

                    <div class="form-group">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-gp">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                        </div>
                    </div>

                    


                </div>

                <div class="col-sm-12 col-md-2 col-lg-2">
                    <div class="form-group">
                        <select wire:model="opciones" class="form-control">
                            <option value="TODAS">TODAS</option>
                            <option value="EGRESO/INGRESO">INGRESOS Y EGRESOS</option>
                            <option value="CORTE">CORTES</option>
                            <option value="TIGOMONEY">TIGO MONEY</option>
                            <option value="STREAMING">STREAMING</option>
                            <option value="SERVICIOS">SERVICIOS</option>
                            <option value="VENTA">VENTAS</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                                            

                                    <label>Fecha inicial</label>
                                    <input type="date" wire:model="fromDate" class="form-control">
                                    @error('fromDate')
                                    <span class="text-danger">{{ $message}}</span>
                                    @enderror
                   </div>
                </div>
                <div class="col-sm-12 col-md-2">
                   <div class="form-group">

                   

                                    <label>Fecha final</label>
                                    <input type="date" wire:model="toDate" class="form-control">
                                    @error('toDate')
                                    <span class="text-danger">{{ $message}}</span>
                                    @enderror
                                
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <h6 class="card-title">
                        <b>CARTERAS EN TU SUCURSAL:</b>
                    </h6>
                    @foreach ($carterasSucursal as $item)
                        <b>{{ $item->cajaNombre }},</b>
                        <b>{{ $item->carteraNombre }}: </b>
                        <b>${{ $item->monto }}.</b>
                        <br>
                    @endforeach
                </div>
            </div>

            @if ($opciones != 'CORTE' and $vertotales==0)
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                            <thead class="text-white" style="background: #ee761c">
                                <tr>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">IMPORTE</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">TIPO DE
                                        MOVIMIENTO
                                    </th>
                                    @if ($opciones != 'EGRESO/INGRESO')
                                        <th class="table-th text-withe text-center" style="font-size: 100%">TIPO</th>
                                    @endif
                                    <th class="table-th text-withe text-center" style="font-size: 100%">NOMBRE CARTERA
                                    </th>
                                    @if ($opciones != 'EGRESO/INGRESO')
                                        <th class="table-th text-withe text-center" style="font-size: 100%">DESCRIPCION
                                            CARTERA
                                        </th>
                                        {{-- <th class="table-th text-withe text-center" style="font-size: 100%">TIPO CARTERA
                                        </th> --}}
                                        <th class="table-th text-withe text-center" style="font-size: 100%">TELEFONO
                                        </th>
                                    @endif
                                    <th class="table-th text-withe text-center" style="font-size: 100%">CAJA</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">USUARIO</th>
                                    <th class="table-th text-withe text-center" style="font-size: 100%">FECHA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $p)
                                    <tr>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">{{ $p->import }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">
                                                {{ $p->carteramovtype }}</h6>
                                        </td>
                                        @if ($opciones != 'EGRESO/INGRESO')
                                            <td>
                                                <h6 class=" text-center" style="font-size: 100%">
                                                    {{ $p->tipoDeMovimiento }}</h6>
                                            </td>
                                        @endif
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">{{ $p->nombre }}
                                            </h6>
                                        </td>
                                        @if ($opciones != 'EGRESO/INGRESO')
                                            <td>
                                                <h6 class="text-center" style="font-size: 100%">
                                                    {{ $p->descripcion }}
                                                </h6>
                                            </td>
                                            {{-- <td>
                                                <h6 class="text-center" style="font-size: 100%">{{ $p->tipo }}
                                                </h6>
                                            </td> --}}
                                            <td>
                                                <h6 class="text-center" style="font-size: 100%">
                                                    {{ $p->telefonoNum }}
                                                </h6>
                                            </td>
                                        @endif
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">
                                                {{ $p->cajaNombre }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">
                                                {{ $p->usuarioNombre }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center" style="font-size: 100%">
                                                {{\Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                                            </h6>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif($vertotales==0)
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-unbordered table-hover mt-4">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe text-center">TIPO DE MOVIMIENTO</th>
                                    <th class="table-th text-withe text-center">TIPO</th>
                                    <th class="table-th text-withe text-center">CAJA</th>
                                    <th class="table-th text-withe text-center">USUARIO</th>
                                    <th class="table-th text-withe text-center">FECHA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $p)
                                    <tr
                                        @if ($p->movimientotype == 'APERTURA' && $p->status == 'ACTIVO') style="background-color: #09ed3d !important" @endif>
                                        <td>
                                            <h6 class="text-center">{{ $p->movimientotype }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">
                                                {{ $p->tipoDeMovimiento }}</h6>
                                        </td>
                                        <td>
                                            <h6 class=" text-center">
                                                {{ $p->cajaNombre }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">
                                                {{ $p->usuarioNombre }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">
                                                {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                                            </h6>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @if($vertotales==1)
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="table-th text-withe text-center" style="font-size: 100%">#</th>
                                <th class="table-th text-withe text-center" style="font-size: 100%">FECHA</th>
                             
                                <th class="table-th text-withe text-center" style="font-size: 100%">DETALLE</th>
                                
                                <th class="table-th text-withe text-center" style="font-size: 100%">INGRESO</th>
                                <th class="table-th text-withe text-center" style="font-size: 100%">EGRESO</th>
                                <th class="table-th text-withe text-center" style="font-size: 100%">UTILIDAD</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($totalesIngresos as $p)
                                <tr>
                                    <td>
                                        <h6 class="text-center" style="font-size: 100%">{{ $loop->iteration }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 100%">
                                            {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                                        </h6>
                                    </td>
                                  
                                    <td>
                                        <h6 class="text-center" style="font-size: 100%">
                                            {{ $p->carteramovtype }}-{{ $p->tipoDeMovimiento }}-   {{ $p->cajaNombre }}-{{ $p->usuarioNombre }}</h6>
                              
                                  
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 100%">{{ $p->mimpor }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 100%">
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center" style="font-size: 100%">
                                            @if($p->tipoDeMovimiento == 'VENTA')
                                             {{ number_format($this->buscarutilidad($this->buscarventa($p->movid)->first()->idventa), 2) }}
                                             @elseif($p->tipoDeMovimiento == 'SERVICIOS')
                                             {{ $this->buscarservicio($p->movid)}}
                                            @endif
                                        </h6>
                                    </td>
                                    
                                </tr>
                            @endforeach
                            @foreach ($totalesEgresos as $p)
                            <tr>
                                <td>
                                    <h6 class="text-center" style="font-size: 100%">{{ $loop->iteration }}
                                    </h6>
                                </td>
                                <td>
                                    <h6 class="text-center" style="font-size: 100%">
                                        {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                                    </h6>
                                </td>
                              
                                <td>
                                    <h6 class="text-center" style="font-size: 100%">
                                        {{ $p->carteramovtype }}-{{ $p->tipoDeMovimiento }}-{{ $p->cajaNombre }}-{{ $p->usuarioNombre }}</h6>
                          
                              
                                </td>
                               
                                <td>
                                    <h6 class="text-center" style="font-size: 100%">
                                    </h6>
                                </td>
                                <td>
                                    <h6 class="text-center" style="font-size: 100%">{{ $p->mimpor }}
                                    </h6>
                                </td>
                                <td>
                                    <h6 class="text-center" style="font-size: 100%">
                                    </h6>
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
    @include('livewire.reporte_movimientos.modalDetails')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', Msg => {
            $('#modal-details').modal('show')
        })
        window.livewire.on('hide-modal', Msg => {
            $('#modal-details').modal('hide')
            noty(Msg)
        })
        window.livewire.on('tigo-delete', Msg => {
            noty(Msg)
        })
    });
</script>
