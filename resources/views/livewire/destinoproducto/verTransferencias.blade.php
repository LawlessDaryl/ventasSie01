

<div class="row pt-2">
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
          
               
           
            <div class="widget-content widget-content-area icon-pill">
                <div class="row mt-3 text-center">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-lg-12">
                        <h2>TRANSFERENCIAS</h2>
                    </div>
                </div>
                <div class="d-flex flex-row-reverse">
           
                    
                        <a href="transferencia" class="btn btn-success m-1" >Transferir Productos</a>
                       
                       
                  
                </div>
                
                <ul  class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
                    
                    <li class="nav-item">
                        <a class="nav-link true" id="listar-transferencias" data-toggle="pill" href="#pills-tr" role="tab" aria-controls="pills-tr" aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>  Listar Transferencias</a>
                        
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="listar-transferencias-pendientes" data-toggle="pill" href="#pills-tr-apr" role="tab" aria-controls="pills-tr-apr" aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>Transferencias pendientes de aprobacion</a>
                    </li>
                    
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane {{$show1}} {{$estado_lista_tr}}" wire:click="$set('show2','')" wire:click="$set('$estado_lista_tr','active')"  id="pills-tr" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-2">
                                <thead class="text-white" style="background: #3849c4">
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
                                                <h6 class="text-center btn text-white btn-danger p-1">{{ $data_td->estado_tr }}</h6>
                                            </td>
                                
                                            @endif
                                            
                                            <td>
                                                <h6 class="text-center">{{ $data_td->name }}</h6>
                                            </td>
                                            
                                            @if ($data_td->estado_tr =='Recibido' or $data_td->estado_tr =='Rechazado' or !(in_array($data_td->orih, $vs)))
                                            <td class="text-center">
                                                <a href="javascript:void(0)" wire:key="foo" wire:click="ver({{$data_td->t_id}})" 
                                                    class="btn btn-dark p-1 m-0" title="Ver">
                                                    <i class="fas fa-list"></i>
                                                </a>
                                                <a href="javascript:void(0)" wire:click="imprimir({{$data_td->t_id}})" 
                                                    class="btn btn-dark p-1 m-0" title="Ver">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                                
                                            
                                            </td>
                                            @else
                                                <td>
                                                <a href="javascript:void(0)" onclick="Confirm({{$data_td->t_id}})"
                                                    class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                               
                                                <a href="javascript:void(0)" onclick="Confirmarborrado('{{ $data_td->id }}')" 
                                                    class="btn btn-dark p-1 m-0" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>

                                                <a href="javascript:void(0)" wire:key="do" wire:click="ver({{$data_td->t_id}})" 
                                                    class="btn btn-dark p-1 m-0" title="Ver">
                                                    <i class="fas fa-list"></i>
                                                </a>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                         
                        </div>
                    </div>
                    <div class="tab-pane  {{$show2}} {{$estado_lista_te}}" id="pills-tr-apr" wire:click="$set('show1', '')" wire:click="$set('$estado_lista_tr','active')"  role="tabpanel">
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
                                                <h6 class="text-left"> <strong>Destino:</strong> {{ $data2->dst2 }}-{{$data2->destino_name}}</h6>
    
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
                                                <h6 class="text-center btn text-white btn-danger p-1">{{ $data2->estado_te }}</h6>
                                            </td>
                                
                                            @endif
                                            
                                            <td>
                                                <h6 class="text-center">{{ $data2->name }}</h6>
                                            </td>
                                            
                                            <td class="text-center">
                                                @if ($data2->estado_te ==='Recibido' or $data2->estado_te === 'Rechazado')
                                                <a href="javascript:void(0)" wire:click="visualizardestino({{$data2->tr_des_id}})" 
                                                    class="btn btn-dark p-1 m-0" title="Ver">
                                                    <i class="fas fa-list"></i>
                                                </a>
                                                <a href="javascript:void(0)" wire:click="imprimir({{$data2->tr_des_id}})" 
                                                    class="btn btn-dark p-1 m-0" title="Ver">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                                @else
                                         
                                                <a href="javascript:void(0)" wire:click="visualizardestino({{$data2->tr_des_id}})" 
                                                    class="btn btn-dark p-1 m-0" title="Ver">
                                                    <i class="fas fa-list"></i>
                                                </a>
                                                
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                         
                        </div>
                    </div>
                </div>
           
    
            </div>
        </div>
        @include('livewire.destinoproducto.modaldetalletr')
        @include('livewire.destinoproducto.modaldetallete')
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
    function Confirm(id) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Esta seguro de editar la transferencia?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('editRow', id)
                Swal.close()
            }
        })
    }
    function Confirmarborrado(id) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Esta seguro de eliminar la transferencia?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }

</script>

@endsection