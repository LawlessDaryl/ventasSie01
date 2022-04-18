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
      
          
            <div class="row" >
                    <div class="col-12 col-lg-7 col-md-6">
                        <div class="widget-body">
                            <div class="table-responsive">
                                <table class="table table-unbordered table-hover mt-2">
                                    <thead class="text-white" style="background: #3B3F5C">
                                        <tr>
                                            <th class="table-th text-withe text-center">#</th>
                                            <th class="table-th text-withe text-center">Cod</th>                              
                                            <th class="table-th text-withe text-center">Fecha</th>
                                            <th class="table-th text-withe text-center">Estado</th>
                                            <th class="table-th text-withe text-center">Usuario</th>
                                            <th class="table-th text-withe text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_t as $data)
                                            <tr>
                                                <td>
                                                    <h6 class="text-center">{{ $nro++ }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-center">{{ $data->t_id }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-center">{{ $data->fecha_transferencia }}</h6>
                                                </td>

                                                @if($data->st =="Pendiente")
                                                <td>
                                                    <h6 class="text-center card text-white bg-danger p-1">{{ $data->st }}</h6>
                                                </td>

                                                @elseif($data->st =="Aprobado")
                                                <td>
                                                    <h6 class="text-center card text-white bg-success p-1">{{ $data->st }}</h6>
                                                </td>

                                                @else
                                                <td>
                                                    <h6 class="text-center card text-white bg-primary p-1">{{ $data->st }}</h6>
                                                </td>
                                    
                                                @endif
                                                <td>
                                                    <h6 class="text-center">{{ $data->name }}</h6>
                                                </td>
                                                
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" wire:click="Edit({{ $data->t_id }})"
                                                        class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="Confirm('{{ $data->id }}','{{ $data->nombre }}')" 
                                                        class="btn btn-dark p-1 m-0" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" wire:click="visualizar({{$data->t_id}})" 
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
                    <div class="col-lg-5 align-items-center">
                        <div class="row  justify-content-center ">
                            
                            <div class="table-responsive">
                                <table class="table table-unbordered table-hover mt-2">
                                    <thead class="text-white" style="background: #3B3F5C">
                                        <tr>
                                            <th class="table-th text-withe text-center">#</th>
                                            <th class="table-th text-withe text-center">Descripcion</th>                              
                                            <th class="table-th text-withe text-center">Cantidad</th>
                                            <th class="table-th text-withe text-center">Destino</th>
                                            <th class="table-th text-withe text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($ros!=1)
                                        @foreach ($data_m as $datas)
                                        <tr>
                                            <td>
                                                <h6 class="text-center">{{ $nro++ }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $datas->prod_name }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $datas->cantidad }}</h6>
                                            </td>

                                            <td>
                                                <h6 class="text-center">{{ $datas->dest_name }}</h6>
                                            </td>
                                            
                                            <td class="text-center">
                                                <a href="javascript:void(0)" wire:click="Edit({{ $data->t_id }})"
                                                    class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="Confirm('{{ $data->id }}','{{ $data->nombre }}')" 
                                                    class="btn btn-dark p-1 m-0" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                    <span>Visualizar Detalles</span>
                                    @endif
                                       
                                    </tbody>
                                </table>
                             
                            </div>

                        </div>
                    </div>
                    </div>
                  
            </div>
         
        </div>
      
    </div>
  
</div>