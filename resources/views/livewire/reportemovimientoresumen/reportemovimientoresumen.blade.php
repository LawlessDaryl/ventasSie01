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
                        <th class="table-th text-withe text-center" style="font-size: 100%">UTILIDAD</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($totalesIngresosV as $p)
                        <tr style="background-color: rgb(247, 239, 236)">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                            </td>
                          
                            <td>
                                <b>{{ $p->tipoDeMovimiento }},{{ $p->ctipo =='CajaFisica'?'Efectivo':$p->ctipo }},({{ $p->nombrecartera }})</b>
                            </td>
                            <td>
                                {{ $p->importe }}
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                {{ $p->utilidadventa }}
                            </td>

                            
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>

                            {{-- <td>


                                <table class="tablep p-0 m-0">
                                    <thead class="">
                                        <tr>
                                            <th class="">Nombre</th>
                                            <th class="">Precio Original</th>
                                            <th class="">Descuento o Recargo</th>
                                            <th class="">Precio Venta</th>
                                            <th class="">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>

                                </table>
                            </td> --}}






                            <td class="m-0 pl-0">
                                <table class="tablep p-0 m-0" style="padding: 0">
                                    <th class="thp" >Nombre Producto</th>
                                    <th class="thp">Cantidad</th>
                                    <th class="thp">Precio Venta</th>
                                    
                                        @foreach ($p->detalle as $item)
                                        <tr class="trp">
                                            <td class="tdp" style="border-style: hidden"> <h6 style="font-size: 11px" >{{$item->nombre}}</h6></td>
                                            <td class="tdp"  style="border-style: hidden"> <h6 style="font-size: 11px" >{{$item->cant}}</h6></td>
                                            <td class="tdp"  style="border-style: hidden"> <h6 style="font-size: 11px" >{{$item->pv}}</h6></td>
                                               
                                        </tr>
                                         @endforeach
                                    
                                   
                                    
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
                          
                            <td>
                                {{ $p->tipoDeMovimiento }},{{ $p->ctipo =='CajaFisica'?'Efectivo':$p->ctipo }},({{ $p->nombrecartera }})
                            </td>
                            <td>
                                {{ $p->importe }}
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                {{ $p->utilidadservicios }}
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
                      
                        <td>
                            {{ $m->ctipo =='CajaFisica'?'Efectivo':$m->ctipo }}({{ $m->nombrecartera }})
                        </td>
                        <td>
                            {{ $m->importe }}
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
                  
                    <td>
                        {{ $p->tipoDeMovimiento }},{{ $p->ctipo =='CajaFisica'?'Efectivo':$p->ctipo }},{{ $p->nombrecartera }})
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        {{ $p->importe }}
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
                
                    <td>
                        {{ $st->ctipo =='CajaFisica'?'Efectivo':$st->ctipo }}({{ $st->nombrecartera }})
                    </td>
                    <td>
                    
                    </td>
                    <td>
                        {{ $st->importe }}
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
        @include('livewire.reporte_movimientos.modalDetailsR')
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
        });
    </script>

