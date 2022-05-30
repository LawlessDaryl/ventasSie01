@section('css')


{{-- Estilos para la tabla Movimiento Diario --}}
<style>


    .contenedortabla{
        /* overflow:scroll; */
        overflow-x:auto;
        /* max-height: 100%; */
        /* min-height:200px; */
        /* max-width: 100%; */
        /* min-width:100px; */
    }

    .estilostable {
    width: 100%;
    min-width: 1000px;
    }
    .estilostotales {
    width: 100%;
    }
    .seleccionar:hover {
    background-color: skyblue;
    cursor: pointer;
    /* box-shadow: 10px 10px 0px 0px #46A2FD, 20px 20px #83C1FD, 30px 30px 14px #ACD5FD; */
    /* transform: translate(-5px, -5px); */

    background: #f1eaa9d2;
	transform: translate(0px, -4px);;
	transition-duration: 0.3s;
    }
    .tablehead{
        background-color: #383938;
        color: aliceblue;
    }
</style>
@endsection


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
                        </div>
                        <div class="col-sm-2 ">
                            <h6>Fecha Hasta</h6>
                            <div class="form-group">
                                <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo"
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
    
                    <div class="contenedortabla">
                        <table class="estilostable" style="color: rgb(0, 0, 0)">
                            <thead>
                              <tr class="tablehead">
                                <th class="text-center">N°</th>
                                <th>FECHA</th>
                                <th>USUARIO</th>
                                <th>CARTERA</th>
                                <th>CAJA</th>
                                <th>MOVIMIENTO</th>
                                <th class="text-right">IMPORTE</th>
                                <th class="text-center">MOTIVO</th>
                                @if($this->verificarpermiso() == true)
                                <th class="text-right">UTILIDAD</th>
                                <th class="text-center">SUCURSAL</th>
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
                                            {{ ucwords($item->nombreusuario) }}
                                        </td>
                                        <td>
                                            {{ ucwords(strtolower($item->nombrecartera)) }}
                                        </td>
                                        <td>
                                            {{ ucwords($item->nombrecaja) }}
                                        </td>
                                        @if($item->tipo == "INGRESO")
                                        <td style="color: rgb(8, 157, 212)">
                                            <b>{{ $item->tipo }}</b>
                                        </td>
                                        @else
                                        <td style="color: rgb(205, 21, 0)">
                                            <b>{{ $item->tipo}}</b>
                                        </td>
                                        @endif
                                        <td class="text-right">
                                            {{ ucwords($item->importe) }} Bs
                                        </td>
                                        <td class="text-center">
                                            {{ ucwords($item->motivo) }}
                                        </td>
                                        @if($this->verificarpermiso() == true)
                                        <td class="text-right">
                                            @if($this->buscarventa($item->idmovimiento)->count() > 0)
                                             {{ number_format($this->buscarutilidad($this->buscarventa($item->idmovimiento)->first()->idventa), 2) }} Bs
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{ ucwords($item->nombresucursal) }}
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>  

                <br>
                <br>

                <div class="row">
                    <div class="col-lg-4">
                        
                    </div>
                    <div style="color: black" class="col-lg-4 text-center">
                        



                        <table class="estilostotales" style="color: rgb(0, 0, 0)">
                            <thead>
                              <tr class="tablehead">
                                <th>TOTAL INGRESO</th>
                                <th>TOTAL EGRESO</th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr class="seleccionar">
                                    <td class="text-center">
                                        {{number_format($ingreso,2)}} Bs
                                    </td>
                                    <td>
                                        {{number_format($egreso,2)}} Bs
                                    </td>
                                </tr>
                                <tr style="background-color: rgb(0, 0, 0)">
                                    <td class="text-center">
                                        
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>


                                @foreach($listacarteras as $cartera)

                                    @if($cartera->totales != 0)





                                    

                                        <tr class="seleccionar">
                                            <td class="text-center">
                                                Total en {{$cartera->nombre}}
                                            </td>
                                            <td>
                                                {{number_format($cartera->totales,2)}} Bs
                                            </td>
                                        </tr>






                                    @endif
                                @endforeach


                            </tbody>
                        </table>

















                    </div>
                    
                    <div class="col-lg-4">
                        
                    </div>
                </div>






            </div>


    </div>

</div>
