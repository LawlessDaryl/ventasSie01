
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
            <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
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
                        <tr>
                            <td>
                                <h6 class="text-center" style="font-size: 100%">{{ $loop->iteration }}
                                </h6>
                            </td>
                            <td>
                                <h6 class="text-center" style="font-size: 100%">
                                    {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                                </h6>
                            </td>
                          
                            <td>
                                <h6 class="text-center" style="font-size: 100%">
                                    {{ $p->tipoDeMovimiento }},{{ $p->ctipo =='CajaFisica'?'Efectivo':$p->ctipo }},{{ $p->nombrecartera }}</h6>
                      
                          
                            </td>
                            <td>
                                <h6 class="text-center" style="font-size: 100%">{{ $p->importe }}
                                </h6>
                            </td>
                            <td>
                                <?php  echo  "$p->detalle"  ?>
                            </td>

                            {{-- <td>
                                <h6 class="text-center" style="font-size: 100%">
                                    @if($p->tipoDeMovimiento == 'VENTA')

                                     {{ number_format($this->buscarutilidad($this->buscarventa($p->movid)->first()->idventa), 2) }}
                                     @elseif($p->tipoDeMovimiento == 'SERVICIOS')
                                     {{ $this->buscarservicio($p->movid)}}
                                    @endif
                                </h6>
                            </td> --}}
                            
                        </tr>
                    @endforeach
                    @foreach ($totalesIngresosSIE as $p)
                        <tr>
                            <td>
                                <h6 class="text-center" style="font-size: 100%">{{ $loop->iteration }}
                                </h6>
                            </td>
                            <td>
                                <h6 class="text-center" style="font-size: 100%">
                                    {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                                </h6>
                            </td>
                          
                            <td>
                                <h6 class="text-center" style="font-size: 100%">
                                    {{ $p->tipoDeMovimiento }},{{ $p->ctipo =='CajaFisica'?'Efectivo':$p->ctipo }},{{ $p->nombrecartera }}</h6>
                      
                          
                            </td>
                            <td>
                                <h6 class="text-center" style="font-size: 100%">{{ $p->importe }}
                                </h6>
                            </td>
                            <td>
                                <h6 class="text-center" style="font-size: 100%">
                                </h6>
                            </td>
                            {{-- <td>
                                <h6 class="text-center" style="font-size: 100%">
                                    @if($p->tipoDeMovimiento == 'VENTA')
                                     {{ number_format($this->buscarutilidad($this->buscarventa($p->movid)->first()->idventa), 2) }}
                                     @elseif($p->tipoDeMovimiento == 'SERVICIOS')
                                     {{ $this->buscarservicio($p->movid)}}
                                    @endif
                                </h6>
                            </td> --}}
                            
                        </tr>
                    @endforeach
                    {{-- @foreach ($totalesEgresos as $p)
                    <tr>
                        <td>
                            <h6 class="text-center" style="font-size: 100%">{{ $loop->iteration }}
                            </h6>
                        </td>
                        <td>
                            <h6 class="text-center" style="font-size: 100%">
                                {{ \Carbon\Carbon::parse($p->movimientoCreacion)->format('d/m/Y H:i') }}
                            </h6>
                        </td>
                      
                        <td>
                            <h6 class="text-center" style="font-size: 100%">
                                {{ $p->carteramovtype }}-{{ $p->tipoDeMovimiento }}-{{ $p->cajaNombre }}-{{ $p->usuarioNombre }}</h6>
                  
                      
                        </td>
                       
                        <td>
                            <h6 class="text-center" style="font-size: 100%">
                            </h6>
                        </td>
                        <td>
                            <h6 class="text-center" style="font-size: 100%">{{ $p->mimpor }}
                            </h6>
                        </td>
                        <td>
                            <h6 class="text-center" style="font-size: 100%">
                            </h6>
                        </td>
                        
                    </tr>
                    @endforeach --}}
                
                </tbody>
            </table>
            <table>
                <tfoot>
                    <tr>
                        <td colspan="4">
                             <h5 class="text-dark-right" style="border-bottom:2rem">TOTAL INGRESOS Bs</h5>
                          
                             <h5 class="text-dark">OPERACIONES EN EFECTIVO Bs</h5>
                             <h5 class="text-dark">BANCOS/SISTEMA/TELEFONO Bs</h5>
                             <h5 class="text-dark">TOTAL EGRESOS Bs</h5>
                             <h5 class="text-dark">SUB TOTAL EN CAJA Bs </h5>
                             <h5 class="text-dark">TOTAL TRANSACCIONES BANCO/TARJ. CREDITO/DEBITO Bs  </h5>
                             <h5 class="text-dark">TOTAL EFECTIVO EN CAJA Bs </h5>
                             <h5 class="text-dark">UTILIDAD Bs</h5>
                             <h5 class="text-dark">APERTURA Bs</h5>
    
                        </td>
                        {{-- <td>
                            <h5 class="text-dark text-center">{{number_format($importetotalingresos),2}}</h5>
                            <h5 class="text-dark text-center">{{number_format($operacionefectivoing),2}}</h5>
                            <h5 class="text-dark text-center">{{number_format($noefectivoing),2}}</h5>
                            <h5 class="text-dark text-center">{{number_format($importetotalegresos),2}}</h5>
                            <h5 class="text-dark text-center">{{number_format($subtotalcaja),2}}</h5>
                            <h5 class="text-dark text-center">{{number_format($noefectivoing-$noefectivoeg),2}}</h5>
                            <h5 class="text-dark text-center">{{number_format($subtotalcaja-$noefectivoing+$noefectivoeg),2}}</h5>
                            <h5 class="text-dark text-center">{{number_format($utilidadtotal),2}}</h5>
                            <h5 class="text-dark text-center">{{number_format($ops),2}}</h5>
                        </td> --}}
                    </tr>
                    
            </tfoot>
            </table>
        </div>
    </div>

