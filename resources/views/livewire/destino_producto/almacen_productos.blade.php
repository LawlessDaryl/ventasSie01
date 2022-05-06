<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Almacen Producto</b>
                </h4>
                <ul class="tabs tab-pills">
                    
                        <a href="transferencia" class="btn btn-dark" >Transferir <br/>Productos</a>
                      
                    
                </ul>
                <ul class="tabs tab-pills">
                    
                        <a href="transferencias" class="btn btn-dark">Ver<br/>Transferencias</a>
                      
                </ul>
            </div>
          

            {{--SELECT DE LAS SUCURSALES--}}
            <div class="row">
                <div class="col-12 col-lg-4 col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-gp">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                            </div>
                </div>
                
                <div class="col-12 col-lg-5 col-md-3">

                    <div class="form-group">
                        <select wire:model='selected_id' class="form-control">
                            <option value="General">Almacen Total</option>
                          @foreach ($data_suc as $data)
                          <option value="{{ $data->id }}">{{ $data->sucursal }}-{{$data->destino}}</option>
                          @endforeach
                         
                         
                        </select>
                      </div>
                </div>
            </div>
          
            <div class="row" >

             
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center">ITEM</th>
                                <th class="table-th text-withe text-center">PRODUCTO</th>                              
                                <th class="table-th text-withe text-center">STOCK</th>   
                                @if ($selected_id == 'General' || $selected_id == null)
                                <th class="table-th text-withe text-center">CANT.MIN</th>                                       
                                @endif                           
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($destinos_almacen as $destino)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $loop->iteration}}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $destino->name}}</h6>
                                    </td>
                                    @if ($selected_id == 'General' || $selected_id == null)
                                    <td>
                                      <h6 class="text-center">{{ $destino->stock_s }}</h6>
                                  </td>
                                    <td>
                                      <h6 class="text-center">{{ $destino->cant_min }}</h6>
                                  </td>
                                    @else
                                    <td>
                                      <h6 class="text-center">{{ $destino->stock }}</h6>
                                  </td>
                                    @endif
                                    
                                    
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="verMobiliario({{ $data->id }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$destinos_almacen->links() }}
                
            </div>
                 
                    </div>
                  
            </div>
         
        </div>
      
    </div>
   
  
</div>