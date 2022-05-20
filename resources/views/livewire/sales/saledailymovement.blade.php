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
    
                        <div class="col-sm-2">
                            <h6>Elige la Caja</h6>
                            <div class="form-group">
                                <select wire:model="caja" class="form-control">
                                    <option value="Todos">Todos</option>
                                    {{-- @foreach ($cajas as $cajSu)
                                        <option value="{{ $cajSu->id }}">{{ $cajSu->nombre }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <h6>Elige la Sucursal</h6>
                            <div class="form-group">
                                <select wire:model="caja" class="form-control">
                                    <option value="Todos">Todos</option>
                                    {{-- @foreach ($cajas as $cajSu)
                                        <option value="{{ $cajSu->id }}">{{ $cajSu->nombre }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
    
                        <div class="col-sm-2 ">
                            <h6>Fecha Desde</h6>
                            <div class="form-group">
                                <input @if ($reportType == 0) disabled @endif type="datetime-local" wire:model="dateFrom"
                                    class="form-control" placeholder="Click para elegir">
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <h6>Fecha Hasta</h6>
                            <div class="form-group">
                                <input @if ($reportType == 0) disabled @endif type="datetime-local" wire:model="dateTo"
                                    class="form-control" placeholder="Click para elegir">
                            </div>
                        </div>
    
                        <div class="col-sm-2 mt-4">
    
                            {{-- <a class="btn btn-dark"
                                href="{{ url('reporteServicEntreg/pdf' .'/' .$reportType .'/' .$dateFrom .'/' .$dateTo .'/' .$sucursal .'/' .$sumaEfectivo .'/' .$sumaBanco .'/' .$caja) }}"
                                target="_blank" style='font-size:18px'>Generar PDF</a> --}}
    
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
                                <th>SUCURSAL</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr class="seleccionar">
                                        <td class="text-center">
                                            {{$loop->iteration}}
                                        </td>
                                        <td>
                                            {{ $item->fecha }}
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
                                        <td>
                                            {{ ucwords($item->nombresucursal) }}
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                        {{ $data->links() }}
                    </div>
                </div>  


                






            </div>


    </div>

</div>
