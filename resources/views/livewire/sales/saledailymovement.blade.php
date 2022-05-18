@section('css')


{{-- Estilos para la tabla Movimiento Diari --}}
<style>
    .estilostable {
    width: 100%;
    }
    .seleccionar:hover {
    background-color: skyblue;
    }
    .tablehead{
        background-color: rgb(19, 128, 200);
        color: aliceblue;
    }
</style>
@endsection


<div class="row sales layout-top-spacing">
    <div class="col-sm-12" >

            <!-- Secciones para las Ventas -->
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <div class="col-12 col-lg-12 col-md-10 mt-3">

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


                <div>
                    <table class="estilostable" style="color: rgb(0, 0, 0)">
                        <thead>
                          <tr class="tablehead">
                            <th>N°</th>
                            <th>Fecha</th>
                            <th>Detalle</th>
                            <th>Ingreso</th>
                            <th>Egreso</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr class="seleccionar">
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    <td>
                                        {{ $item->tipo }}
                                    </td>
                                    <td>
                                        {{ $item->nombrecartera }}
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>






            </div>


    </div>

</div>
