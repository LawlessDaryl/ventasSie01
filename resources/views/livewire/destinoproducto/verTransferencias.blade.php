<div class="row sales layout-top-spacing">
    <div class="col-lg-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Transferencias</b>
                </h4>
                <ul class="tabs tab-pills">
                    
                        <a href="transferencia" class="btn btn-dark" >Imprimir</a>
                      
                </ul>
            </div>
            <div class="widget-body">
        
                <div class="col-12 col-lg-7 col-md-6">
                    
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-2">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-withe text-center">#</th>
                                        <th class="table-th text-withe text-center">Cod</th>                              
                                        <th class="table-th text-withe text-center">Transferencia</th>
                                        <th class="table-th text-withe text-center">Estado</th>
                                        <th class="table-th text-withe text-center">Usuario</th>
                                        <th class="table-th text-withe text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_t as $data_td)
                                        <tr>
                                            <td>
                                                <h6 class="text-center">{{ $nro++ }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $data_td->t_id }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-left"> <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($data_td->fecha_tr)->format('Y-m-d')}}</h6>
                                                <h6 class="text-left"> <strong>Hora:</strong> {{ \Carbon\Carbon::parse($data_td->fecha_tr)->format('H:i')}}</h6>
                                                <h6 class="text-left"> <strong>Origen:</strong> {{ $data_td->origen}}-{{$data_td->origen_name}}</h6>
                                                <h6 class="text-left"> <strong>Destino:</strong> {{ $data_td->dst }}-{{$data_td->destino_name}}</h6>
    
                                            </td>
    
                                            @if($data_td->estado_tr =="Pendiente")
                                            <td>
                                                <h6 class="text-center btn text-white btn-danger p-1">{{ $data_td->estado_tr }}</h6>
                                            </td>
    
                                            @elseif($data_td->estado_tr =="Aprobado")
                                            <td>
                                                <h6 class="text-center btn text-white btn-success p-1">{{ $data_td->estado_tr }}</h6>
                                            </td>
    
                                            @else
                                            <td>
                                                <h6 class="text-center btn text-white btn-primary p-1">{{ $data_td->estado_tr }}</h6>
                                            </td>
                                
                                            @endif
                                            
                                            <td>
                                                <h6 class="text-center">{{ $data_td->name }}</h6>
                                            </td>
                                            
                                            <td class="text-center">
                                                <a href="javascript:void(0)" wire:click="Edit({{ $data_td->t_id}})"
                                                    class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="Confirm('{{ $data_td->id }}','{{ $data_td->nombre }}')" 
                                                    class="btn btn-dark p-1 m-0" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <a href="javascript:void(0)" wire:click="ver({{$data_td->t_id}})" 
                                                    class="btn btn-dark p-1 m-0" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                         
                        </div>
            
                </div>
                <div class="col-lg-5 align-items-center">
                    <div class="row  justify-content-center ">
                        
                        @if($detalle!=null)
                     
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-2">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-withe text-center">#</th>
                                        <th class="table-th text-withe text-center">Descripcion</th>                              
                                        <th class="table-th text-withe text-center">Cantidad</th>
                                        <th class="table-th text-withe text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detalle as $datas)
                                    <tr>
                                        <td>
                                            <h6 class="text-center">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $datas->producto->nombre }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $datas->cantidad }}</h6>
                                        </td>
                                        
                                        <td class="text-center">
                                            <a href="javascript:void(0)" wire:click="Edit({{ $datas->t_id }})"
                                                class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" onclick="Confirm('{{ $datas->id }}','{{ $datas->nombre }}')" 
                                                class="btn btn-dark p-1 m-0" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                           
                                        </td>
                                       
                                    </tr>
                                @endforeach
                               
                                @else
                                <span>Visualizar Detalles</span>
                                @endif
                                <td>
                                    @if($estado=== 'Pendiente' )
                                    <button class="btn btn-success p-0 col-lg-5">Verificar Stock</button>
                                    <button class="btn btn-info p-0 col-lg-5">Aceptar Solicitud</button>
                                    @endif
                                </td>
    
                               
    
                                </tbody>
                               
                            </table>
                         
                        </div>
    
                    </div>
                </div>
            
            </div>

            <div class="widget-body">
                    <h5>Transferencias por recibir</h5>
                    <div class="col-12 col-lg-7 col-md-6">
                        
                            <div class="table-responsive">
                                <table class="table table-unbordered table-hover mt-2">
                                    <thead class="text-white" style="background: #3B3F5C">
                                        <tr>
                                            <th class="table-th text-withe text-center">#</th>
                                            <th class="table-th text-withe text-center">Cod</th>                              
                                            <th class="table-th text-withe text-center">Transferencia</th>
                                            <th class="table-th text-withe text-center">Estado</th>
                                            <th class="table-th text-withe text-center">Usuario</th>
                                            <th class="table-th text-withe text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_d as $data2)
                                            <tr>
                                                <td>
                                                    <h6 class="text-center">{{ $nro++ }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-center">{{ $data2->t_id }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-left"> <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($data2->fecha_tr)->format('Y-m-d')}}</h6>
                                                    <h6 class="text-left"> <strong>Hora:</strong> {{ \Carbon\Carbon::parse($data2->fecha_tr)->format('H:i')}}</h6>
                                                    <h6 class="text-left"> <strong>Origen:</strong> {{ $data2->origen}}-{{$data2->origen_name}}</h6>
                                                    <h6 class="text-left"> <strong>Destino:</strong> {{ $data2->dst }}-{{$data2->destino_name}}</h6>
        
                                                </td>
        
                                                @if($data2->estado_tr =="Pendiente")
                                                <td>
                                                    <h6 class="text-center btn text-white btn-danger p-1">{{ $data2->estado_transferencia }}</h6>
                                                </td>
        
                                                @elseif($data2->estado_tr =="Aprobado")
                                                <td>
                                                    <h6 class="text-center btn text-white btn-success p-1">{{ $data2->estado_transferencia }}</h6>
                                                </td>
        
                                                @else
                                                <td>
                                                    <h6 class="text-center btn text-white btn-primary p-1">{{ $data2->estado_transferencia }}</h6>
                                                </td>
                                    
                                                @endif
                                                
                                                <td>
                                                    <h6 class="text-center">{{ $data2->name }}</h6>
                                                </td>
                                                
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" wire:click="Edit({{ $data2->t_id }})"
                                                        class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="Confirm('{{ $data2->id }}','{{ $data2->nombre }}')" 
                                                        class="btn btn-dark p-1 m-0" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" wire:click="visualizardestino({{$data2->tr_des_id}})" 
                                                        class="btn btn-dark p-1 m-0" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                             
                            </div>
                    </div>
                    <div class="col-lg-5 align-items-center">
                        <div class="row  justify-content-center ">
                            
                            @if($datalist_destino!=null)
                         
                            <div class="table-responsive">
                                <table class="table table-unbordered table-hover mt-2">
                                    <thead class="text-white" style="background: #3B3F5C">
                                        <tr>
                                            <th class="table-th text-withe text-center">#</th>
                                            <th class="table-th text-withe text-center">Descripcion</th>                              
                                            <th class="table-th text-withe text-center">Cantidad</th>
                                            <th class="table-th text-withe text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datalist_destino as $ob)
                                        <tr>
                                            <td>
                                                <h6 class="text-center">{{ $loop->iteration }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $ob->producto->nombre }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $ob->cantidad }}</h6>
                                            </td>
                                            
                                            <td class="text-center">
                                                <a href="javascript:void(0)" wire:click="Edit({{ $ob->tr_des_id }})"
                                                    class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="Confirm('{{ $ob->id }}','{{ $ob->nombre }}')" 
                                                    class="btn btn-dark p-1 m-0" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                               
                                            </td>
                                           
                                        </tr>
                                    @endforeach
                                   
                                    @else
                                    <span>Visualizar Detalles</span>
                                    @endif
                                    <td>
                                        @if($estado_destino === 'Pendiente' )
                                        <button class="btn btn-success p-0 col-lg-5">Verificar Stock</button>
                                        <button class="btn btn-info p-0 col-lg-5">Aceptar Solicitud</button>
                                        @endif
                                    </td>
        
                                   
        
                                    </tbody>
                                   
                                </table>
                             
                            </div>
        
                        </div>
                    </div>
                
                
            
        
            </div>

            
            
                  
         
         
    </div>
</div>
</div>
  
