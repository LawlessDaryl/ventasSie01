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
                        <button wire:click="selected"class="btn btn-dark">Almacen <br/>General</button>
                    
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
                <div class="col-12 col-lg-3 col-md-3">

                    <div class="form-group">
                        <select wire:model='selected_id' class="form-control">
                          <option value="null">Elegir Sucursal</option>
                          @foreach ($data_suc as $data)
                          <option value="{{ $data->nombre }}|{{$data->loc}}">{{ $data->nombre }}-{{$data->loc}}</option>
                          @endforeach
                         
                        </select>
                      </div>
                </div>

            </div>
          

            <div class="widget-content">
                    <div class="col-12 col-lg-12 col-md-4 d-flex flex-wrap">                    
                      @foreach($destinos_almacen as $destino)
                      
                        <div class="card border-success m-2" style="max-width: 18rem;">
                            <div class="card-header"><h3> {{$destino->name}}</h3></div>
                            <div class="card-body text-success">
                             {{--<h5 class="card-title">{{$destino->tipo}}-{{$destino->codigo}}</h5>--}} 
                             @if($selected_id == 'General')
                             <h1>hola</h1>
                            @endif
                              <p class="card-text"> <strong> Stock Disponible:</strong> {{$destino->stock}}</p>
                              <p class="card-text"> <strong></strong> {{$destino->tipo}}-{{$destino->codigo}}</p>
                            </div>
                          </div>
                      @endforeach

                    </div>
                  
                
            </div>
        </div>
    </div>
  
</div>