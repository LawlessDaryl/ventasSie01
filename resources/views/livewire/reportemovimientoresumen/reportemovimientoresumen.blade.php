@section('css')


<style>
    .tablep, .thp, .tdp{
      margin: 0;
      width: 100%;
      background-color: rgb(240, 248, 242);
      border: 8px solid;
      border: 1px solid white;
      border-style: hidden;
     padding: 0%;
    }
    
    .thp, .tdp {
    
      text-align: left;
      border: 0px white !important;
    
    }
    .trp:hover {background-color: rgb(209, 137, 110);}





    .estilostable {
        width: 100%;
        font-size: 12px;
        border-spacing: 0px;
        color: black;
        }
        .estilostable .tablehead{
            background-color: #dbd4d4;
            font-size: 10px;
        }
        .estilostable2 {
        width: 100%;
        font-size: 9px;
        border-spacing: 0px;
        color: black;
        padding: 0px;
        }
        .estilostable2 .tablehead{
            background-color: white;
        }
        .fnombre{
            border: 0.5px solid rgb(204, 204, 204);
        }
        .filarow{
            border: 0.5px solid rgb(204, 204, 204);
            width: 10px;
            text-align: center;
        }
        .filarowpp{
            border: 0.5px solid rgb(204, 204, 204);
            width: 20px;
            text-align: center;
            font-size: 8px;
        }
        .filarownombre{
            border: 0.5px solid rgb(204, 204, 204);
            width: 150px;
        }
    
        .filarowx{
            border: 0.5px solid rgb(255, 255, 255);
            width: 100%;
            text-align: center;
        }
</style>
   

@endsection
   
   
   <div class="widget-content">
        <h4 class="card-title">
            <b>RESUMEN MOVIMIENTOS</b>
        </h4>

        <ul class="row justify-content-start">
            <div class="col-sm-12 col-md-2">
                <div class="form-group">
                                 <label>Sucursal</label>
                                 <select wire:model="sucursal" class="form-control">
                                     @foreach ($sucursales as $item)
                                     <option value="{{$item->id}}">{{$item->name}}</option>
                                     @endforeach
                                     <option value="TODAS">TODAS</option>
                                    
                                 </select>
                                        
                 </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <div class="form-group">
                                 <label>Caja</label>
                                 <select wire:model="caja" class="form-control">
                                     @foreach ($cajas as $item)
                                     <option value="{{$item->id}}">{{$item->nombre}}</option>
                                     @endforeach
                                     <option value="TODAS">TODAS</option>
                                    
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
         
       
        </ul>
        <ul class="row justify-content-end">
         
              
                <a wire:click.prevent="viewDetailsR()" class="btn btn-warning">
                    Generar Recaudo
                </a>
               
                <a wire:click.prevent="generarpdf({{$totalesIngresosV}}, {{$totalesIngresosS}}, {{$totalesIngresosIE}}, {{$totalesEgresosV}}, {{$totalesEgresosIE}})" class="btn btn-warning">
                    Generar PDF
                </a>
         
       
        </ul>
        <div class="table-responsive">
            <table class="table table-hover table table-bordered table-bordered-bd-warning">
                <thead class="text-white" style="background: #ee761c">
                    <tr>
                        <th class="table-th text-withe text-center" style="font-size: 100%">#</th>
                        <th class="table-th text-withe text-center" style="font-size: 100%">FECHA</th>
                     
                        <th class="table-th text-withe text-center" style="font-size: 100%">DETALLE</th>
                        
                        <th class="table-th text-withe text-center" style="font-size: 100%">INGRESO</th>
                        <th class="table-th text-withe text-center" style="font-size: 100%">EGRESO</th>
                        <th class="table-th text-withe text-center" style="font-size: 100%">
                            @if(@Auth::user()->hasPermissionTo('VentasMovDiaSucursalUtilidad'))
                            UTILIDAD
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($totalesIngresosV as $p)
                        <tr style="background-color: rgb(247, 239, 236)">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                            </td>
                          
                            <td class="text-center">
                                <b>{{ $p->idventa }},{{ $p->tipoDeMovimiento }},{{ $p->ctipo =='CajaFisica'?'Efectivo':$p->ctipo }},({{ $p->nombrecartera }})</b>
                            </td>
                            <td class="text-right">
                                {{ number_format($p->importe,2) }}
                            </td>
                            <td>
                                
                            </td>
                            <td class="text-right">
                                @if(@Auth::user()->hasPermissionTo('VentasMovDiaSucursalUtilidad'))
                                {{ number_format($p->utilidadventa,2) }}
                                @endif
                            </td>

                            
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <table class="estilostable2">
                                    <thead>
                                        <tr>
                                            <td class="fnombre">
                                                Nombre
                                            </td>
                                            <td class="filarowpp">
                                                Precio Original
                                            </td>
                                            <td class="filarow">
                                                Desc/Rec
                                            </td>
                                            <td class="filarowpp">
                                                Precio Venta
                                            </td>
                                            <td class="filarow">
                                                Cantidad
                                            </td>
                                            <td class="filarow">
                                                Total
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($p->detalle as $item)
                                        <tr class="">
                                            <td class="filarownombre">
                                                {{-- {{rtrim(mb_strimwidth($item['nombre'], 2, 2, '...', 'UTF-8'))}} --}}
                                                {{-- {{$item['nombre']}} --}}
                                                {{substr($item->nombre, 0, 17)}}
                                            </td>
                                            <td class="filarow">
                                                {{number_format($item->po,2)}}
                                            </td>
                                            <td class="filarow">
                                                @if($item->po - $item->pv == 0)
                                                {{$item->po - $item->pv}}
                                                @else
                                                {{($item->po - $item->pv) * -1}}
                                                @endif
                                            </td>
                                            <td class="filarow">
                                                {{number_format($item->pv,2)}}
                                            </td>
                                            <td class="filarow">
                                                {{$item->cant}}
                                            </td>
                                            <td class="filarow">
                                                {{number_format($item->pv * $item->cant,2)}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                    @foreach ($totalesIngresosS as $p)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($p->movcreacion)->format('d/m/Y H:i') }}
                            </td>
                          
                            <td class="text-center">
                                {{ $p->idordenservicio }},{{ $p->tipoDeMovimiento }},{{ $p->ctipo =='CajaFisica'?'Efectivo':$p->ctipo }},({{ $p->nombrecartera }})
                            </td>
                            <td class="text-right">
                                {{ number_format($p->importe,2) }}
                            </td>
                            <td>
                                
                            </td>
                            <td class="text-right">
                                @if(@Auth::user()->hasPermissionTo('VentasMovDiaSucursalUtilidad'))
                                {{ number_format($p->utilidadservicios,2) }}
                                @endif
                            </td>
                            
                        </tr>
                    @endforeach

                    @foreach ($totalesIngresosIE as $m)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($m->movcreacion)->format('d/m/Y H:i') }}
                        </td>
                      
                        <td class="text-center">
                            {{ $m->ctipo =='CajaFisica'?'Efectivo':$m->ctipo }}({{ $m->nombrecartera }})
                        </td>
                        <td class="text-right">
                            {{ number_format($m->importe,2) }}
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            
                        </td>
                        
                    </tr>
                @endforeach


                @foreach ($totalesEgresosV as $p)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($p->movcreacion)->format('d/m/Y H:i') }}
                    </td>
                  
                    <td class="text-center">
                        {{ $p->tipoDeMovimiento }},Devolución,{{ $p->ctipo =='CajaFisica'?'Efectivo':$p->ctipo }},{{ $p->nombrecartera }})
                    </td>
                    <td>
                        
                    </td>
                    <td class="text-right">
                        {{ number_format($p->importe,2) }}
                    </td>
                    <td>
                        
                    </td>
                    
                </tr>
                @endforeach

                @foreach ($totalesEgresosIE as $st)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($st->movcreacion)->format('d/m/Y H:i') }}
                    </td>
                
                    <td class="text-center">
                        {{ $st->ctipo =='CajaFisica'?'Efectivo':$st->ctipo }}({{ $st->nombrecartera }})
                    </td>
                    <td>
                    
                    </td>
                    <td class="text-right">
                        {{ number_format($st->importe,2) }}
                    </td>
                    <td>
                        
                    </td>
                    
                </tr>
                @endforeach

            {{-- pruebasssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss --}}

            {{-- <tr>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    <b>{{$this->ingresosTotales}} ig</b>
                </td>
                <td>
                    <b>{{$this->EgresosTotales}}</b>
                </td>
                <td>
                    <b>{{$this->totalutilidadSV}}</b>
                </td>
            </tr>
            <tr>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td colspan="3">
                     <h5 class="text-dark-right" style="border-bottom:2rem">TOTAL INGRESOS Bs</h5></td>
                </td>
                <td>
                    {{$this->totalutilidadSV}}
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <h5 class="text-dark">OPERACIONES EN EFECTIVO Bs</h5>
                </td>
                <td>
                    {{$this->ingresosTotalesCF}}
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <h5 class="text-dark">BANCOS/SISTEMA/TELEFONO Bs</h5>
                </td>
                <td>
                    {{$this->ingresosTotalesNoCF}}
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <h5 class="text-dark">TOTAL EGRESOS Bs</h5>
                </td>
                <td>
                    {{$this->EgresosTotales}}
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <h5 class="text-dark">SUB TOTAL EN CAJA Bs </h5>
                </td>
                <td>
                    {{$this->subtotalcaja}}
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <h5 class="text-dark">TOTAL EFECTIVO EN CAJA Bs </h5>
                </td>
                <td>
                    
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <h5 class="text-dark">UTILIDAD Bs</h5>
                </td>
                <td>
                    {{$this->ingresosTotales}}
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <h5 class="text-dark">APERTURA Bs</h5>
                </td>
                <td>
                    Apertura de Caja
                    {{number_format($ops),2}}
                </td>
                <td></td>
                <td></td>
            {{-- </tr> --}}

      
            <tfoot>
                <tr>
                    <td colspan="6" style="background-color: rgb(224, 157, 80)">

                    </td>
                </tr>
                {{-- INGRESOS TOTALES --}}
                <tr>
                <td colspan="3">
                    <h5 class="text-dark text-right" style="font-size: 1rem!important;"><b> INGRESOS TOTALES </b></h5>
                </td>
                <td>
                        {{ number_format($ingresosTotales,2) }}
                        
                </td>
                <td colspan="2">
                </td>
                </tr>

                {{-- DESCOMPOSICION DE LOS INGRESOS TOTALES --}}
                {{-- OPERACIONES EN EFECTIVO --}}
                <tr>
                    <td colspan="3">
                        <h5 class="text-dark text-right" style="font-size: 1rem!important;">Operaciones en efectivo</h5>
                    </td>
                    <td>
                            {{ number_format($ingresosTotalesCF,2) }}
                            
                    </td>
                    <td colspan="2">
                    </td>
                </tr>

                {{-- OPERACIONES NO EFECTIVAS TIGO/SISTEMAS/TELEFONO --}}

                <tr>
                    <td colspan="3">
                        <h5 class="text-dark text-right" style="font-size: 1rem!important;"> Operaciones en TIGO/SISTEMA/TELEFONO </h5>
                    </td>
                    <td>
                            {{ number_format($ingresosTotalesNoCFNoBancos,2) }}
                            
                    </td>
                    <td colspan="2">
                    </td>
                </tr>

                {{-- OPERACIONES NO EFECTIVAS BANCOS --}}

                <tr>
                    <td colspan="3">
                        <h5 class="text-dark text-right" style="font-size: 1rem!important;"> Operaciones en Bancos </h5>
                    </td>
                    <td>
                            {{ number_format($ingresosTotalesNoCFBancos,2) }}
                            
                    </td>
                    <td colspan="2">
                    </td>
                </tr>
                {{-- OPERACIONES DEDUCCION TIGOMONEY --}}
                <tr>
                    <td colspan="3">
                        <h5 class="text-dark text-right" style="font-size: 1rem!important;"> Saldo en caja fisica de operaciones en Tigo Money </h5>
                    </td>
                    <td>
                            {{ number_format($total,2) }}
                            
                    </td>
                    <td colspan="2">
                    </td>
                </tr>

                {{-- FIN DESCOMPOSICION DE LOS INGRESOS TOTALES --}}

                {{-- EGRESOS TOTALES --}}
                <tr>
                    <td colspan="3">
                        <h5 class="text-dark text-right" style="font-size: 1rem!important;"><b> EGRESOS TOTALES </b></h5>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        {{ number_format($EgresosTotales,2) }}
                    </td>

                    <td>

                    </td>
                </tr>

                {{-- DESCOMPOSICION DE LOS INGRESOS TOTALES --}}

                {{-- egresos en efectivo --}}
                <tr>
                    <td colspan="3">
                        <h5 class="text-dark text-right" style="font-size: 1rem!important;"><b> Egresos en efectivo </b></h5>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        {{ number_format($EgresosTotalesCF,2) }}
                    </td>

                    <td>

                    </td>
                </tr>

                {{-- egresos por sistema --}}

                <tr>
                    <td colspan="3">
                        <h5 class="text-dark text-right" style="font-size: 1rem!important;"><b> Egresos sistema/telefono </b></h5>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        {{ number_format($EgresosTotalesNoCFNoBancos,2) }}
                    </td>

                    <td>

                    </td>
                </tr>

                {{-- EgresosTotalesNoCFBancos --}}

                <tr>
                    <td colspan="3">
                        <h5 class="text-dark text-right" style="font-size: 1rem!important;"><b> Egresos por bancos </b></h5>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        {{ number_format($EgresosTotalesNoCFBancos,2) }}
                    </td>

                    <td>

                    </td>
                </tr>

                {{-- FIN DESCOMPOSICION DE LOS INGRESOS TOTALES --}}

                {{-- subtotalcaja --}}

                    <tr>
                        <td colspan="3">
                            <h5 class="text-dark text-right" style="font-size: 1rem!important;"><b> SUBTOTAL EN CAJA </b></h5>
                        </td>
                        <td>
                                {{ number_format($subtotalcaja,2) }}
                                
                        </td>
                        <td colspan="2">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <h5 class="text-dark text-right" style="font-size: 1rem!important;"><b> SALDO EFECTIVO </b></h5>
                        </td>
                        <td>
                                {{ number_format($operacionesefectivas,2) }}
                                
                        </td>
                        <td colspan="2">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <h5 class="text-dark text-right" style="font-size: 1rem!important;"><b> APERTURA </b></h5>
                        </td>
                        <td>
                                {{ number_format($ops,2) }}
                                
                        </td>
                        <td colspan="2">
                        </td>
                    </tr>

                    @if ($caja != 'TODAS')
                    <tr>
                        <td colspan="3">
                            <h5 class="text-dark text-right" style="font-size: 1rem!important;"><b> RECAUDO </b></h5>
                        </td>
                        <td>
                                {{ number_format($recaudo,2) }}
                                
                        </td>
                        <td colspan="2">
                        </td>
                    </tr>
                    @endif

                    
                
                    <tr>
                        <td colspan="3">
                            <h5 class="text-dark text-right" style="font-size: 1rem!important;"><b> TOTAL </b></h5>
                        </td>
                        <td>
                            {{ number_format($operacionesW,2) }}
                                
                        </td>
                        <td colspan="2">
                        </td>
                    </tr>
            </tfoot>

        </tbody>


            </table>
        </div>
        @include('livewire.reportemovimientoresumen.modalDetailsR')
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
         
            window.livewire.on('show-modalR', Msg => {
            $('#modal-detailsr').modal('show')
            })
            window.livewire.on('hide-modalR', Msg => {
                $('#modal-detailsr').modal('hide')
                noty(Msg)
            })
            window.livewire.on('tigo-delete', Msg => {
                noty(Msg)
            })
            //Llamando a una nueva pestaña donde estará el pdf modal
            window.livewire.on('opentap', Msg => {
                var win = window.open('report/pdfmovdiaresumen');
                // Cambiar el foco al nuevo tab (punto opcional)
                //win.focus();

            });
        });
    </script>

