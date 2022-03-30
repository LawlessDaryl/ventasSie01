<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Almacen Producto</b>
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
            </div>
          
            <div class="row" >
                    <div class="col-12 col-lg-12 col-md-4 d-flex flex-lg-wrap flex-wrap flex-md-wrap flex-xl-wrap flex-sm-wrap">

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


                
                    </div>
                  
            </div>
         
        </div>
      
    </div>
    @include('livewire.destino_producto.form')
  
</div>