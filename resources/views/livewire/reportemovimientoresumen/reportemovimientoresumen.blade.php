
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
               
                <a wire:click.prevent="crearpdf()" class="btn btn-warning">
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
                            <td>
                                <?php  echo  "$p->detalle"  ?>
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
                    {{-- Apertura de Caja --}}
                    {{number_format($ops),2}}
                </td>
                <td></td>
                <td></td>
            </tr>

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

