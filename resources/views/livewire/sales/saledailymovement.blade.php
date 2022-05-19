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
            <div class="widget widget-chart-one">

                <div class="widget-heading">
                    <div class="col-12 col-lg-12 col-md-10">
                        <!-- Titulo Detalle Venta -->
                            <div class="row mb-4 text-center" >
                                <div class="col-sm-12" >
                                    <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />

                                    <h5 class="mb-2 mt-2">REPORTE DE MOVIMIENTO DIARIO - VENTAS</h5>
                                    
                                    <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />

                                </div>
                            </div>
                    </div>
                </div>





                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-2 col-sm-9">
                            <h6>Seleccionar Usuario</h6>
                            <select class="form-control">
                                <option selected="selected">Usuario</option>
                                <option>white</option>
                                <option>purple</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-2 col-sm-3">
                            <select class="form-control">
                                <option selected="selected">orange</option>
                                <option>white</option>
                                <option>purple</option>
                            </select>
                        </div>
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
