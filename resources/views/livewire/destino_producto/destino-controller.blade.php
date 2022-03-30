<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Destino Producto</b>
                </h4>
                <ul class="tabs tab-pills">
                    
                        <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">Transferir <br/>Productos</a>
                      
                    
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
                <div class="col-12 col-lg-2 col-md-3">

                    <div class="form-group">
                        <select wire:model='selected_id' class="form-control">
                            <option value="General">Almacen Total</option>
                          @foreach ($data_suc as $data)
                          <option value="{{ $data->id }}">{{ $data->sucursal }}-{{$data->destino}}</option>
                          @endforeach
                         
                         
                        </select>
                      </div>
                </div>
                <div class="col-12 col-lg-2 col-md-3">

                    <div class="form-group">
                        <select wire:model='selected_categoria' class="form-control">
                          <option value="null">Elegir Categoria</option>
                          @foreach ($data_cat as $data)
                          <option value="{{ $data->id }}">{{ $data->name}}</option>
                          @endforeach
                       
                         
                        </select>
                      </div>
                </div>
                
                <div class="col-12 col-lg-2 col-md-3">

                    <div class="form-group">
                        <button class="btn btn-warning" style="padding: 10px">Reset Transferencia</button>
                    </div>
                </div>

                

            </div>
          
            <div class="row" >

         

                    <div class="col-12 col-lg-5 col-md-4 d-flex flex-lg-wrap flex-wrap flex-md-wrap flex-xl-wrap flex-sm-wrap">

                      @foreach($destinos_almacen as $destino)
                      
                        <div class="card border-success" style="width: 13rem; margin:0.1rem">
                        
                            <div class="card-header"><h5> {{$destino->name}}</h5></div>
                            <div class="card-body text-success">

                             {{--<h5 class="card-title">{{$destino->tipo}}-{{$destino->codigo}}</h5>--}} 
                             @if($selected_id == 'General' || $selected_id == null)
                             <p class="card-text"> <strong> Stock total Disponible:</strong> {{$destino->stock_s }}</p>
                             <p class="card-text"> <strong>Cantida minima</strong> {{$destino->cant_min}}</p>
                             @else
                               <p class="card-text"> <strong> Stock Disponible:</strong> {{$destino->stock}}</p>
                               <p class="card-text"> <strong>Mobilirio ubicacion</strong> {{$destino->tipo}}-{{$destino->codigo}}</p>
                             @endif
                               <button wire:click="increaseQty({{$destino->id_prod}})" class="btn btn-success" style="padding: 10px">Transferir</button>
                             </div>
                           </div>
                           
                          
                      @endforeach

                    </div>

                    {{--AREA DE TRANSFERENCIAS DE PRODUCTOS--}}


                    <div class="col-12 col-lg-7 col-md-3">
                        <div class="widget mr-2 mb-2 mt-2">
                              
                            <div class="table-responsive p-1">
                                <table class="table table-unbordered table-hover mt-2">
                                    <thead class="text-white" style="background: #3B3F5C">
                                        <tr>
                                            <th class="table-th text-withe text-center">Producto</th>
                                          
                                            <th class="table-th text-withe text-center">Cantidad</th>
                                          
                                            <th class="table-th text-withe text-center">Destino <br>Producto </th>
                                            <th class="table-th text-withe text-center">Acc.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart as $prod)
                                            <tr>
                                                <td>
                                                    <h6> {{$prod->name}}</h6>
                                                </td>
                                                <td>
                                                     <input type="number" 
                                                     id="rr{{$prod->id}}" 
                                                     wire:change="UpdateQty({{$prod->id}}, $('#rr' + {{$prod->id}}).val())" 
                                                     style="font-size: 1rem!important;" 
                                                     class="form-control text-center" 
                                                     value="{{$prod->quantity}}">
                                                </td>
                                               
                                               
                                                <td>
                                                    <div class="form-group">
                                                      <select value="Elegir" class="form-control" name="" id="">
                                                        <option value="Elegir Destino">Elegir Destino</option>
                                                        <option>Destino 1</option>
                                                        <option>Destino 2</option>
                                                        <option>Destino 3</option>
                                                      </select>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)"
                                                    wire:click="removeItem({{ $prod->id }})"
                                                        class="btn btn-dark mtmobile" title="Edit">
                                                        <i class="fas fa-trash"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        
                    </div>
                    <div class="col-12 col-lg-8 col-md-3">
        
                        <div class="form-group">
                            <button class="btn btn-danger" style="padding: 10px">Registrar Transferencia</button>
                        </div>
                    </div>
                    </div>
                  
            </div>
         
        </div>
      
    </div>
    @include('livewire.destino_producto.form')
  
</div>