<div class="row sales layout-top-spacing">
    <div class="col-sm-12" >

            <!-- Secciones para las Ventas -->
            <div class="widget">

                <div class="widget-heading">
                    <div class="col-12 col-lg-12 col-md-10">
                        <!-- Titulo Detalle Venta -->
                        <h4 class="card-title text-center"><b>REPORTE DE MOVIMIENTO DIARIO - VENTAS</b></h4>
                
                    </div>
                </div>



                <div class="widget-content">
                    <div class="row">
                        <div class="col-sm-2">
                            <h6>Elige el Tipo de Reporte</h6>
                            <div class="form-group">
                                <select wire:model="reportType" class="form-control">
                                    <option value="0">Ventas del Día</option>
                                    <option value="1">Ventas por Fecha</option>
                                </select>
                            </div>
                        </div>


                        @if($this->verificarpermiso() == true)
                        <div class="col-sm-2">
                            <h6>Elige la Sucursal</h6>
                            <div class="form-group">
                                <select wire:model="sucursal" class="form-control">
                                    <option value="Todos">Todos</option>
                                    @foreach ($sucursales as $su)
                                        <option value="{{ $su->idsucursal }}">{{ $su->nombresucursal. ' - ' .$su->direccionsucursal }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
    
                        <div class="col-sm-2">
                            <h6>Elige la Caja</h6>
                            <div class="form-group">
                                <select wire:model="caja" class="form-control">
                                    <option value="Todos">Todos</option>
                                    @foreach ($cajas as $c)
                                        <option value="{{ $c->idcaja }}">{{ $c->nombrecaja }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <div class="col-sm-2 ">
                            <h6>Fecha Desde</h6>
                            <div class="form-group">
                                <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateFrom"
                                    class="form-control" placeholder="Click para elegir">
                            </div>
                            <div class="form-group">
                                <input @if ($reportType == 0) disabled @endif type="time" wire:model="timeFrom"
                                    class="form-control" placeholder="Click para elegir">
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <h6>Fecha Hasta</h6>
                            <div class="form-group">
                                <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo"
                                    class="form-control" placeholder="Click para elegir">
                            </div>
                            <div class="form-group">
                                <input @if ($reportType == 0) disabled @endif type="time" wire:model="timeTo"
                                    class="form-control" placeholder="Click para elegir">
                            </div>
                        </div>
    
                        <div class="col-sm-2 mt-4">
    
                            

                                <button wire:click.prevent="generarpdf({{$data}})" class="btn btn-primary">
                                    GENERAR PDF
                                </button>

                        </div>
    
                    </div>
    
                    <br>
    
                    <div class="table-responsive">
                        <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                            <thead class="text-white" style="background: #ee761c">
                              <tr class="tablehead">
                                <th class="text-center">N°</th>
                                <th>FECHA</th>
                                <th>CARTERA</th>
                                <th>CAJA</th>
                                <th class="text-right">INGRESO (Bs)</th>
                                <th class="text-right">EGRESO (Bs)</th>
                                <th class="text-right">MOTIVO</th>
                                @if($this->verificarpermiso() == true)
                                <th class="text-right">UTILIDAD (Bs)</th>
                                @endif
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr class="seleccionar">
                                        <td class="text-center">
                                            {{$loop->iteration}}
                                        </td>
                                        <td>
                                            {{ date("d/m/Y h:i A", strtotime($item->fecha)) }}
                                        </td>
                                        <td>
                                            {{ ucwords(strtolower($item->nombrecartera)) }}
                                        </td>
                                        <td>
                                            {{ ucwords($item->nombrecaja) }}
                                        </td>
                                       
                                        <td  class="text-right">
                                        @if($item->tipo == "INGRESO")
                                       
                                        {{ ucwords($item->importe) }}
                                        </td>
                                        @endif
                                        <td class="text-right">
                                        @if($item->tipo == "EGRESO")
                                       
                                        {{ ucwords($item->importe) }}
                                        
                                        @endif
                                    </td>
                                       
                                        <td class="text-right">
                                            {{ ucwords($item->motivo) }}
                                        </td>
                                        @if($this->verificarpermiso() == true)
                                        <td class="text-right">
                                            @if($this->buscarventa($item->idmovimiento)->count() > 0)
                                             {{ number_format($this->buscarutilidad($this->buscarventa($item->idmovimiento)->first()->idventa), 2) }}
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    

                                    <tr>
                                        <td colspan="8"></td>
                                    </tr>


                                    @if($this->verificarpermiso() == true)  
                                        <tr>
                                            <td colspan="7">
                                                <b>TOTAL UTILIDAD</b>
                                            </td>
                                            <td class="text-right">
                                                <b>{{number_format($utilidad,2)}}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">

                                            </td>
                                        </tr>

                                        @foreach($listacarteras as $cartera)

                                            @if($cartera->totales != 0)
                                            <tr>
                                                <td colspan="7"><b>Total en Cartera: {{ucwords(strtolower($cartera->nombre))}}</b></td>
                                                <td class="text-right"><b>{{number_format($cartera->totales,2)}}</b></td>
                                            </tr>
                                            @endif
                                        @endforeach








                                        <tr>

                                            <td colspan="7"><b>TOTAL INGRESOS</b></td>
                                            <td class="text-right"> <b>{{number_format($ingreso,2)}}</b> </td>
                                        </tr>

                                        <tr>

                                            <td colspan="7"><b>TOTAL EGRESOS</b></td>
                                            <td class="text-right"> <b>{{number_format($egreso,2)}}</b> </td>
                                        </tr>
                                        <tr>

                                            <td colspan="7"><b>TOTAL INGRESOS - EGRESOS</b></td>
                                            <td class="text-right"> <b>{{number_format( $ingreso - $egreso,2)}}</b> </td>
                                        </tr>
                                    @else
                                    
                                    <tr>
                                        <td colspan="7">

                                        </td>
                                    </tr>

                                    @foreach($listacarteras as $cartera)

                                        @if($cartera->totales != 0)
                                        <tr>
                                            <td colspan="6"><b>Total en Cartera: {{ucwords(strtolower($cartera->nombre))}}</b></td>
                                            <td class="text-right"><b>{{number_format($cartera->totales,2)}}</b></td>
                                        </tr>
                                        @endif
                                    @endforeach








                                    <tr>

                                        <td colspan="6"><b>TOTAL INGRESOS</b></td>
                                        <td class="text-right"> <b>{{number_format($ingreso,2)}}</b> </td>
                                    </tr>

                                    <tr>

                                        <td colspan="6"><b>TOTAL EGRESOS</b></td>
                                        <td class="text-right"> <b>{{number_format($egreso,2)}}</b> </td>
                                    </tr>
                                    <tr>

                                        <td colspan="6"><b>TOTAL INGRESOS - EGRESOS</b></td>
                                        <td class="text-right"> <b>{{number_format( $ingreso - $egreso,2)}}</b> </td>
                                    </tr>
                                    @endif
                            </tbody>
                        </table>
                    </div>
                </div>






            </div>


    </div>

</div>
