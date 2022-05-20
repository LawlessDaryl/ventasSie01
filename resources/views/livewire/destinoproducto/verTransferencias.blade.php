
{{--<div class="row sales layout-top-spacing">
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
</div>--}}

<div class="row pt-2">
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header" style="background-color: rgb(255, 255, 255)">
                <div class="row mt-3">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <strong><h3>Transferencias</h3></strong>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area icon-pill">
                
                <ul class="nav nav-pills mb-3 mt-3" id="icon-pills-tab" role="tablist">
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Transferencias <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                        <div class="dropdown-menu" style="will-change: transform;">
                            <a class="dropdown-item" id="icon-pills-transference-tab1" data-toggle="tab" href="#icon-pills-transference" role="tab" aria-controls="icon-pills-transference" aria-selected="false">Transferencias realizadas</a>
                            <a class="dropdown-item" id="icon-pills-transference2-tab2" data-toggle="tab" href="#icon-pills-transference2" role="tab" aria-controls="icon-pills-transference2" aria-selected="false">Transferencias entrantes</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Solicitud de Transferencia <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
                        <div class="dropdown-menu" style="will-change: transform;">
                            <a class="dropdown-item" id="icon-pills-solicitud-tab1" data-toggle="tab" href="#icon-pills-solicitud" role="tab" aria-controls="icon-pills-solicitud" aria-selected="false">Solicitudes realizadas</a>
                            <a class="dropdown-item" id="icon-pills-solicitud2-tab2" data-toggle="tab" href="#icon-pills-solicitud" role="tab" aria-controls="icon-pills-solicitud2" aria-selected="false">Solicitudes pendientes</a>
                        </div>
                    </li> 
                </ul>
                <div class="tab-pane fade show" id="icon-pills-tabContent">
                   
                    <div class={{$class}} id="icon-pills-transference" role="tabpanel" aria-labelledby="icon-pills-transference-tab1">
                        <div class="media">
                            
                            <div class="media-body">
                                <center><h4>Transferencias Realizadas</h4></center>
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
            
                                                    @if($data_td->estado_tr =="En transito")
                                                    <td>
                                                        <h6 class="text-center btn text-white btn-primary p-1">{{ $data_td->estado_tr }}</h6>
                                                    </td>
            
                                                    @elseif($data_td->estado_tr =="Recibido")
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
                                                        @if ($data_td->estado_tr !='Recibido')
                                                        <a href="javascript:void(0)" wire:click="Edit({{ $data_td->t_id}})"
                                                            class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" onclick="Confirm('{{ $data_td->id }}','{{ $data_td->nombre }}')" 
                                                            class="btn btn-dark p-1 m-0" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                        @endif
                                                        
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
                        </div>
                    </div>
    
                    <div class="tab-pane fade show" id="icon-pills-transference2" role="tabpanel" aria-labelledby="icon-pills-transference2-tab2">
                        <div class="media">
                            <div class="media-body">
                                <center><h4>Transferencias entrantes</h4></center>
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
            
                                               
                                                    @if($data2->estado_te =="En transito")
                                                    <td>
                                                        <h6 class="text-center btn text-white btn-primary p-1">{{ $data2->estado_te }}</h6>
                                                    </td>
            
                                                    @elseif($data2->estado_te =="Recibido")
                                                    <td>
                                                        <h6 class="text-center btn text-white btn-success p-1">{{ $data2->estado_te }}</h6>
                                                    </td>
            
                                                    @else
                                                    <td>
                                                        <h6 class="text-center btn text-white btn-primary p-1">{{ $data2->estado_te }}</h6>
                                                    </td>
                                        
                                                    @endif
                                                    
                                                    <td>
                                                        <h6 class="text-center">{{ $data2->name }}</h6>
                                                    </td>
                                                    
                                                    <td class="text-center">
                                                        @if ($data2->estado_te !='Recibido')
                                                        <a href="javascript:void(0)" wire:click="Edit({{ $data_td->t_id}})"
                                                            class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" onclick="Confirm('{{ $data_td->id }}','{{ $data_td->nombre }}')" 
                                                            class="btn btn-dark p-1 m-0" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                        @endif
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
                           
                        </div>
                    </div>

                    <div class="tab-pane fade" id="icon-pills-solicitud" role="tabpanel" aria-labelledby="icon-pills-solicitud-tab1">
                        <div class="media">
                            
                            <div class="media-body">
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
                    </div>
    
                    <div class="tab-pane fade" id="icon-pills-solicitud2" role="tabpanel" aria-labelledby="icon-pills-solicitud2-tab2">
                        <p class="">
                            Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
    
                </div>
    
           
    
            </div>
        </div>
        @include('livewire.destinoproducto.modaldetallete')
        @include('livewire.destinoproducto.modaldetalletr')
    </div>
</div>
@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() 
    {
        window.livewire.on('show1', msg => {
            $('#detailtranference').modal('show')
        });  

        window.livewire.on('show2', msg => {
            $('#detailtranferencete').modal('show')
        });  
        window.livewire.on('close2', msg => {
            $('#detailtranferencete').modal('hide')
        });  
    });
  
       
    

</script>

@endsection