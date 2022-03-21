<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Destino Producto</b>
                </h4>
                <ul class="tabs tab-pills">
                    
                        <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">Mover Mercancia</a>
                    
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="row">

                    <div class="col-12 col-lg-6 col-md-4 border rounded">
                      <h3>Almacen</h3>
                      @foreach($destinos_almacen as $destino)
                      
                        <div>
                           <h3> {{$destino->name}}</h3>
                           <h5>{{$destino->ubicacion}}</h5>
                           <h5>{{$destino->stock}}</h5>
                           <h5>{{$destino->nombre}}</h5>
                        </div>
                      @endforeach

                    </div>
                    <div class="col-12 col-lg-6 col-md-4 border rounded">
                        <h3>Tienda</h3>
                        @foreach($destinos_tienda as $destino)
                      
                        <div>
                           <h3> {{$destino->name}}</h3>
                           <h5>{{$destino->ubicacion}}</h5>
                           <h5>{{$destino->stock}}</h5>
                        </div>
                      @endforeach

                  </div>
                </div>
            </div>
        </div>
    </div>
  
</div>