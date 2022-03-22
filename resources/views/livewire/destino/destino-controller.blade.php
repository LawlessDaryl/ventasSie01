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
                <div class="col-12 col-lg-3 col-md-3">

                    <div class="form-group">
                        <select wire:model='selected_id' class="form-control">
                          <option value="null">Elegir Sucursal</option>
                          @foreach ($data_suc as $data)
                          <option value="{{ $data->name }}">{{ $data->name }}</option>
                          @endforeach
                        </select>
                      </div>
                </div>
                <div class="col-12 col-lg-3 col-md-3">

                    <div class="form-group">
                        <select wire:model='selected_ubicacion' class="form-control">
                          <option value="null">Elegir Ubicacion</option>
                    
                          <option value="TIENDA">TIENDA</option>
                          <option value="ALMACEN">ALMACEN</option>
                      
                        </select>
                      </div>
                </div>

            </div>
          

            <div class="widget-content">
                <div class="d-flex row">

                    <div class="col-12 col-lg-12 col-md-4">
                    
                      @foreach($destinos_almacen as $destino)
                      
                        <div class="card border-success m-2" style="max-width: 18rem;">
                            <div class="card-header"><h3> {{$destino->suc_id}}</h3></div>
                            <div class="card-body text-success">
                              <h5 class="card-title">{{$destino->tipo}}-{{$destino->codigo}}</h5>
                              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                          </div>
                      @endforeach

                    </div>
                  
                </div>
            </div>
        </div>
    </div>
  
</div>