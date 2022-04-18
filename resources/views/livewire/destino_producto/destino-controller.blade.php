<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Transferencia Productos</b>
                </h4>
              
            </div>
          

            {{--SELECT DE LAS SUCURSALES--}}
            <div class="row widget widget-chart-one" style="background-color: rgb(195, 214, 248)">

                <div class="col-12 col-lg-8 col-md-3 ml-3">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label> <strong style="color: black" >Origen de transferencia:</strong> </label>
                                <select wire:model='selected_origen' class="form-control">
                                    <option value=null>Elegir Origen</option>
                                  @foreach ($data_suc as $data)
                                  <option value="{{ $data->id }}">{{ $data->sucursal }}-{{$data->destino}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div> 

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label> <strong style="color: black">Destino de transferencia:</strong> </label>
                                    <select wire:model='selected_destino' class="form-control">
                                        <option value=null>Elegir Destino</option>
                                      @foreach ($data_suc as $data)
                                      <option value="{{ $data->id }}">{{ $data->sucursal }}-{{$data->destino}}</option>
                                      @endforeach
                                    
                                    </select>
                                  </div>
                                </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" wire:model='selected_3' type="checkbox" id="flexSwitchCheckChecked">
                        <label class="form-check-label" for="flexSwitchCheckChecked">Elegir destino/producto</label>
                      </div>
                </div>

            </div>
          
            <div class="row" >

              <div class="col-lg-5 mt-3">

                <div class="row">
                    <div class="col-12 col-lg-12 col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-gp">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                        </div>

            </div>
                </div>
                <div class="row">

                    <div class="col-12 col-lg-12 col-md-4 d-flex flex-lg-wrap flex-wrap flex-md-wrap flex-xl-wrap justify-content-center">

                       
                      
                            @foreach($destinos_almacen as $destino)
                      
                        <div class="card border-success" style="width: 13rem; margin:2rem">
                        
                            <div class="card-header"><h5> {{$destino->name}}</h5></div>
                            <div class="card-body text-success">

                             {{--<h5 class="card-title">{{$destino->tipo}}-{{$destino->codigo}}</h5>--}} 
                                                         
                               <p class="card-text"> <strong> Stock Disponible:</strong> {{$destino->stock}}</p>
                               <p class="card-text"> <strong>Mobilirio ubicacion</strong> {{$destino->tipo}}-{{$destino->codigo}}</p>
                             
                               <button wire:click="increaseQty({{$destino->id_prod}})" class="btn btn-success" style="padding: 10px">Agregar</button>
                             </div>
                           </div>
                           
                          
                      @endforeach
                        

                      

                    </div>
                </div>

              </div>


       
                   

                    {{--AREA DE TRANSFERENCIAS DE PRODUCTOS--}}


                    <div class="col-12 col-lg-7 col-md-3">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-12 widget mr-2 mb-2 mt-2">
                                  
                                <div class="table-responsive p-1">
                                    <table class="table table-unbordered table-hover mt-2">
                                        <thead class="text-white" style="background: #3B3F5C">
                                            <tr>
                                                <th class="table-th text-withe text-center">Producto</th>
                                              
                                                <th class="table-th text-withe text-center">Cantidad</th>
                                              
                                                @if($selected_3)


                                                <th class="table-th text-withe text-center">Destino <br>Producto </th>

                                                @endif

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
                                                   
                                                   @if($selected_3)

                                                   <td>
                                                       <div class="form-group">
                                                         <select value="Elegir" class="form-control" name="" id="">
                                                           <option value="Elegir Destino">Elegir Destino</option>
                                                           
                                                           <option>Destino 3</option>

                                                         </select>
                                                       </div>
                                                   </td>
                                                   @endif
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
                        </div>
                        <div class="row">

                            <div class="col-4 col-lg-4 col-md-4">
                
                                <div class="form-group">
                                    <button class="btn btn-primary m-1" style="color: black">Finalizar<br/>Transferencia</button>
                                </div>
                            </div>
                           
                         
                                <div class="col-4 col-lg-4 col-md-4 justify-content-center">
        
                                    <div class="form-group">
                                        <button class="btn btn-warning" style="color: black">Reset <br/>Transferencia</button>
                                    </div>
                                </div>
                                <div class="col-4 col-lg-4 col-md-4">
                
                                    <div class="form-group">
                                        <button class="btn btn-danger  p-3" style="color: black">Cancelar</button>
                                    </div>
                                </div>
        
                            
                        </div>
                    </div>
                  
            </div>
         
        </div>
      
    </div>
    @include('livewire.destino_producto.form')
  
</div>