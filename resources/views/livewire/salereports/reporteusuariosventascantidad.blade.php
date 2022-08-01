@section('css')
<style>
  
  .procesoestilos {
        background-color: rgb(0, 142, 185);
        margin: 2px;
        cursor: pointer;
        color: white;
        border-color: rgb(0, 142, 185);
        border-radius: 7px;
    }
    .procesoestilos:hover {
        background-color: rgb(255, 255, 255);
        color: rgb(0, 142, 185);
        transition: all 0.4s ease-out;
        border-color: rgb(0, 142, 185);
        transform: translateY(-2px);
        
    }

</style>
@endsection
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-12 col-md-4 text-center">

                    </div>

                    <div class="col-12 col-sm-12 col-md-4 text-center">
                        <h2><b>Reporte de Ventas por Usuario</b></h2>
                        {{-- Ordenados por Cantidad de Descuentos --}}
                    </div>

                    <div class="col-12 col-sm-12 col-md-4">
                        
                    </div>

                </div>
            </div> 
            <div class="form-group">
                <div class="row">

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
                        <div class="form-group">
                            <input type="date" wire:model="dateFrom" class="form-control">
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Fecha Fin</b>
                        <div class="form-group">
                            <input type="date" wire:model="dateTo" class="form-control">
                        </div>
                    </div>

                </div>
            </div>  

            <h2 class="text-center text-warning" wire:loading>POR FAVOR ESPERE, OBTENIENDO INFORMACION</h2>
         
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-hover" style="min-width: 1000px;">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="text-withe text-center">No</th>
                                <th class="text-withe">Nombre Usuario</th>
                                <th class="text-withe text-right">Total Ventas Bs</th>
                                <th class="text-withe text-right">Total Utilidad Bs</th>
                                <th class="text-withe text-right">Total Descuento Bs</th>
                                <th class="text-withe text-right">Total Recargo Bs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listausuarios as $d)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <button type="button" class="procesoestilos" wire:click.prevent="buscar_productos_descuentos({{$d->idusuario}})" title="Mostrar Lista de Productos con Descuentos y Recargos">
                                            {{ucwords(strtolower($d->nombreusuario))}}
                                        </button>
                                    </td>
                                    <td class="text-right">
                                        {{number_format($d->totalbs, 2)}}
                                    </td>
                                    <td class="text-right">
                                        {{number_format($d->totalutilidad, 2)}}
                                    </td>
                                    <td class="text-right">
                                        {{number_format(($d->totaldescuento)* -1, 2)}}
                                    </td>
                                    <td class="text-right">
                                        {{number_format($d->totalrecargo, 2)}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



            <br>
            <br>
            <br>
            


            @if($this->user_id > 0)

                @if($this->lista_productos_con_descuentos > 0)

                <div class="text-center">
                    <h3>Ventas con Descuento y Recargo - Usuario: <b>{{$nombreusuario }}</b> en las Fechas Establecidas</h3>
                </div>
                
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-hover" style="min-width: 1000px;">
                            <thead class="text-white" style="background: #005eb6">
                                <tr>
                                    <th class="text-withe text-center">Código Venta</th>
                                    <th class="text-withe text-center">Fecha Venta</th>
                                    <th class="text-withe">Nombre Producto</th>
                                    <th class="text-withe text-right">Precio Original</th>
                                    <th class="text-withe text-right">Precio Venta</th>
                                    <th class="text-withe text-right">Diferencia</th>
                                    <th class="text-withe text-right">Cantidad</th>
                                    <th class="text-withe text-right">Descuento Total</th>
                                    <th class="text-withe text-right">Recargo Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->lista_productos_con_descuentos as $d)
                                    @if($d != null && ($d->pv - $d->po) != 0)
                                    <tr>
                                        <td class="text-center">
                                            <span class="stamp stamp" style="background-color: #005eb6">
                                                {{$d->idventa}}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($d->fecha)->format('d/m/Y h:i:s a') }}
                                        </td>
                                        <td>
                                        {{ $d->nombreproducto }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($d->po, 2) }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($d->pv, 2) }}
                                        </td>
                                        <td class="text-right">
                                            @if(($d->pv - $d->po) < 0)
                                            {{ number_format((($d->pv - $d->po) * -1), 2)}}
                                            @else
                                            {{ number_format(($d->pv - $d->po), 2)}}
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            {{ $d->cantidad }}
                                        </td>
                                        @if($d->pv - $d->po < 0)
                                        <td class="text-right">
                                            {{ number_format((($d->pv - $d->po) * $d->cantidad) * -1, 2)}}
                                        </td>
                                        @else
                                        <td class="text-right">
                                           
                                        </td>
                                        @endif
                                        @if($d->pv - $d->po > 0)
                                        <td class="text-right">
                                            {{ number_format(($d->pv - $d->po) * $d->cantidad, 2)}}
                                        </td>
                                        @else
                                        <td class="text-right">
                                            
                                        </td>
                                        @endif

                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @endif

            @endif

        </div>
    </div>
</div>
