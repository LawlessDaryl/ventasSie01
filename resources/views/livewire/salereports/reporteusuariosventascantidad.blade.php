<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-12 col-md-4 text-center">

                    </div>

                    <div class="col-12 col-sm-12 col-md-4 text-center">
                        <h2><b>LISTA DE CANTIDAD DE VENTAS POR USUARIO</b></h2>
                    </div>

                    <div class="col-12 col-sm-12 col-md-4">
                        
                    </div>

                </div>
            </div> 
            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Buscar por Nombre Usuario</b>
                        <div class="form-group">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-gp">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" wire:model="search" placeholder="Buscar en Pendientes" class="form-control">
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
                        <b>Fecha Inicio</b>
                        <input type="date" wire:model="dateFrom"
                                class="form-control">
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Fecha Fin</b>
                        <div class="form-group">
                            <input type="date" wire:model="dateTo"
                                class="form-control">
                        </div>
                    </div>

                </div>
            </div>  

                
         
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-hover" style="min-width: 1000px;">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="text-withe text-center">No</th>
                                <th class="text-withe">Nombre Usuario</th>
                                <th class="text-withe text-center">Ventas Bs</th>
                                <th class="text-withe text-center">Descuento Bs</th>
                                <th class="text-withe text-center">Costo Bs</th>
                                <th class="text-withe text-center">Utilidad Bs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listausuarios as $d)
                                <tr>
                                    <td class="text-center">
                                        {{-- {{ \Carbon\Carbon::parse($d->fecha_estimada_entrega)->format('d/m/Y h:i:s a') }} --}}
                                    </td>
                                    <td>
                                        {{$d->nombreusuario}}
                                    </td>
                                    <td class="text-center">
                                        {{$d->totalbs}}
                                    </td>
                                    <td class="text-center">
                                        {{$d->totaldescuento}}
                                    </td>
                                    <td class="text-center">
                                        
                                    </td>
                                    <td class="text-center">
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
