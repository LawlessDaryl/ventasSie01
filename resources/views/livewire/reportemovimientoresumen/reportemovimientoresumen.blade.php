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
                                {{ \Carbon\Carbon::parse($p->movcreacion)->format('d/m/Y H:i') }}
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
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($p->movcreacion)->format('d/m/Y H:i') }}
                            </td>
                          
                            <td class="text-center">
                                <b>{{ $p->idordenservicio }},{{ $p->tipoDeMovimiento }}, {{$p->nombrecategoria}} ,{{ $p->ctipo =='CajaFisica'?'Efectivo':$p->ctipo }},({{ $p->nombrecartera }})</b>
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
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-center">
                                {{ucwords(strtolower($p->solucion))}} 
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach

                    @foreach ($totalesIngresosIE as $m)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($m->movcreacion)->format('d/m/Y H:i') }}
                        </td>
                      
                        <td class="text-center">
                            <b>{{ $m->ctipo =='CajaFisica'?'Efectivo':$m->ctipo }},({{ $m->nombrecartera }})</b>
                            
                        </td>
                        <td class="text-right">
                            {{ number_format($m->importe,2) }}
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            
                        </td>
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-center">
                            {{$m->coment}}
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach


                @foreach ($totalesEgresosV as $p)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($p->movcreacion)->format('d/m/Y H:i') }}
                    </td>
                  
                    <td class="text-center">
                        <b>{{ $p->tipoDeMovimiento }},Devolución,{{ $p->ctipo =='CajaFisica'?'Efectivo':$p->ctipo }},{{ $p->nombrecartera }}</b>
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
                        <b>{{ $st->ctipo =='CajaFisica'?'Efectivo':$st->ctipo }},({{ $st->nombrecartera }})</b>
                    </td>
                    <td>
                    
                    </td>
                    <td class="text-right">
                        {{ number_format($st->importe,2) }}
                    </td>
                    <td>
                        
                    </td>
                    
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-center">
                        {{$st->coment}}
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach

      
            <tfoot>
                <tr>
                    <td colspan="6" style="background-color: rgb(224, 157, 80)">

                    </td>
                </tr>

                      {{-- SUBTOTAL OPERACIONES --}}
                      <tr>
                        <td colspan="3">
                            <h5 class="text-dark text-right" style="font-size: 1rem!important;"><b> TOTAL OPERACIONES </b></h5>
                        </td>
                        <td class="text-right">
                            <b>{{ number_format($subtotalesIngresos,2) }}</b>
                        </td>
                        <td class="text-right">
                            <b>{{ number_format($EgresosTotales,2) }}</b>
                        </td>
                        <td class="text-right">
                            @if(@Auth::user()->hasPermissionTo('VentasMovDiaSucursalUtilidad'))
                                <b>{{ number_format($totalutilidadSV,2) }}</b>
                            @endif
                        </td>
                        </tr>
                    </tfoot>
              </tbody>
        </table>
    </div>

    <div class="row">
            <div class="col-lg-5">
                    <div class="table-responsive">
                        <table>
                            <tbody>
                             
                                <tr>
                                    <td>
                                        <h5 class="text-dark text-center"><b> Ingresos en Efectivo </b></h5>
                                    </td>
                                    <td>
                                        <h5 class="text-dark text-center">{{ number_format($ingresosTotalesCF,2)}}</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="text-dark text-center" ><b> Ingresos por Bancos </b></h5>
                                    </td>
                                    <td>
                                        <h5 class="text-dark text-center" >{{ number_format($this->ingresosTotalesNoCFBancos,2)}}</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="text-dark text-left m-0" ><b> Ingresos Totales </b></h5>
                                    </td>
                                    <td>
                                        <hr class="m-0 p-0" width="100%" style="background-color: black">
                                        <h5 class="text-dark text-center m-0" ><b>{{ number_format($subtotalesIngresos,2)}}</b></h5>
                                    </td>
                                </tr>
                     
               
                                <tr>
                                    <td>
                                        <h5 class="text-dark text-left" ><b> Egresos Totales en Efectivo </b></h5>
                                    </td>
                                    <td>
                                        <h5 class="text-dark text-center m-0" ><b>{{ number_format($EgresosTotalesCF,2)}} </h5></b>
                                      
                                    </td>
                                </tr>
 
                                <tr>
                                    <td>
                                        <h5 class="text-dark text-left" ><b> Saldo Ingresos/Egresos Totales </b></h5>
                                    </td>
                                    <td>
                                        <hr class="m-0 p-0" width="100%" style="background-color: black">
                                        <h5 class="text-dark text-center m-0" > {{ number_format($subtotalcaja,2)}}</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="text-dark text-left" ><b> Saldo en Efectivo </b></h5>
                                    </td>
                                    <td>
                                        <h5 class="text-dark text-center m-0" > <b>{{ number_format($operacionesefectivas,2)}}</b> </h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="text-dark text-center mr-1" ><b> Saldo por Operaciones en TigoMoney </b></h5>
                                    </td>
                               
                                    <td>
                                        <h5 class="text-dark text-center mr-1" >{{ number_format($total,2)}} </h5>
                                    </td>
                                  
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="text-dark text-left" ><b> Apertura Caja Fisica </b></h5>
                                    </td>
                                    <td>
                                        <h5 class="text-dark text-center m-0" >{{ number_format($ops,2)}} </h5>
                                    </td>
                                </tr>
                             

                                <tr>
                                    <td>
                                        <h5 class="text-dark text-left" ><b> Total Efectivo </b></h5>
                                    </td>
                                    <td>
                                        <hr class="m-0 p-0" width="100%" style="background-color: black">
                                        <h5 class="text-dark text-left" > <b> {{ number_format($operacionesW,2)}}</b></h5>
                                    </td>
                                </tr>
                               
                                
                    </div>
            </div>

           <div class="col-lg-5">
                <div class="table-responsive">
                    <table>
                        <tbody>
                            @if ($caja != 'TODAS')
                                <tr style="height: 2rem"></tr>
                        
                                <tr class="p-5">
                                <td>
                                        <h5 class="text-dark text-left"><b> Recaudo </b></h5>
                                </td>
                                <td>
                                    <h5 class="text-dark text-center m-0" > {{ number_format($op_recaudo,2) }}</h5>
                            
                                </td>
                    
                                </tr>
                                <tr class="p-5">


                                    @foreach ($op_sob_falt as $key=>$item)
                                        
                                    <td>
                                        <h5 class="text-dark text-left"><b> {{($key== 'INGRESO' ? 'Sobrante':'Faltante')}} </b></h5>
                                    </td>
                                    <td>
                                    <h5 class="text-dark text-center m-0" > {{ number_format($item,2) }}</h5>
                                
                                    </td>
                                    @endforeach
                    
                                </tr>
                                <tr class="p-5">
                                <td>
                                        <h5 class="text-dark text-left"><b> Nuevo Saldo Caja Fisica </b></h5>
                                </td>
                                <td>
                                    <h5 class="text-dark text-center m-0" > {{ number_format($operacionesW-$op_recaudo,2) }}</h5>
                            
                                </td>
                    
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        
        @include('livewire.reportemovimientoresumen.modalDetailsr')

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

