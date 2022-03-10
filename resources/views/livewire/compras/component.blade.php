<div>
    <div class="row layout-top-spacing">
        <div class="col-sm-12" >
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <div class="col-9 col-xl-6 col-lg-12 mb-xl-5 mb-5 ">
                        <div>
                            <h5 class="mb-2 mt-2">Detalle Compra COD: {{$nro_compra}}</h5>
                        </div>
                        <div class="d-flex b-skills">
                            <div class="infobox border border-dark rounded pl-2 pr-5">
                                <b class="info-text">Proveedor: </b> 
                       
                            NO DEFINIDO 
                             <br/>
                        
                                <b class="info-text">Fecha: </b><br/>
                              
                                <b class="info-text">Registrado por: </b> <br/>
                               
                              </div>
                        </div>

                    </div>
                    <ul class="tabs tab-pills">
                        <a href="javascript:void(0)" class="btn btn-dark m-2" data-toggle="modal"
                            data-target="#theModal">Agregar Proveedor</a>
                
                        <a href="javascript:void(0)" class="btn btn-dark m-2" data-toggle="modal"
                            data-target="#theModal">Crear Producto
                        </a>
                    </ul>
                </div>

                <div class="widget-content">
                    <div class="row">
                        <div class="col-5">
                                <div class="widget p-2">
                                    <div class="col-lg-12 col-12 col-md-4 col-sm-12">
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text input-gp">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                            <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-12 col-md-4 col-sm-12">
                                        <h6 class="rounded">
                                            <b>Elementos encontrados:</b>
                                        </h6>
                                    </div>
                             
                                       
                                    <div class="table-responsive">
                                        <table class="table table-unbordered table-hover mt-3">
                                            <thead class="text-white" style="background: #3B3F5C">
                                                <tr>
                                                    <th class="table-th text-withe text-center">Producto</th>                              
                                                    <th class="table-th text-withe text-center">Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data_prod as $prod)
                                                    <tr>
                                                        <td>
                                                            <div class="card-body">
                                                                <h4 class="card-title">{{$prod->nombre}}</h4>
                                                                <div>
                                                                    <b>Caracteristicas</b>
                                                                    <b>Stock</b>
                                                                    <b>Marca</b>
                                                                    <b>Garantia</b> <br>
                                                                    <b class="card-text"> {{$prod->caracteristicas}}</b>
                                                                    <b class="card-text">{{$prod->stock}}</b>
                                                                    <b class="card-text">{{$prod->marca}}</b>
                                                                    <b class="card-text">{{$prod->garantia}}</b>
                                                                   
                                                                </div>
                                                        </td>
                                                      
                                                        
                                                        <td class="text-center">
                                                            <a href="#"
                                                                class="btn btn-dark mtmobile" title="Edit">
                                                                <i class="fas fa-plus"></i>
                                                            </a>
                                                           
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            
                            
                        </div>
                   
                        <div class="col-6">
                            <div class="widget">
                                <div class="col-lg-12 col-12 col-md-4 col-sm-12">
                                    <div class="table-responsive p-2">
                                        <table class="table table-unbordered table-hover mt-2">
                                            <thead class="text-white" style="background: #3B3F5C">
                                                <tr>
                                                    <th class="table-th text-withe text-center">Producto</th>                              
                                                    <th class="table-th text-withe text-center">Codigo</th>
                                                    <th class="table-th text-withe text-center">Precio</th>
                                                    <th class="table-th text-withe text-center">Costo</th>
                                                    <th class="table-th text-withe text-center">Cantidad</th>
                                                    <th class="table-th text-withe text-center">Subtotal</th>
                                                    <th class="table-th text-withe text-center">Descuento</th>
                                                    <th class="table-th text-withe text-center">Total</th>
                                                    <th class="table-th text-withe text-center">Acc.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data_prod as $prod)
                                                    <tr>
                                                        <td>
                                                        <h6> {{$prod->nombre}}</h6>
                                                        </td>                                                    
                                                        <td>
                                                        <h6>{{$prod->codigo}}</h6>
                                                        </td>                                                    
                                                        <td>
                                                       <h6>{{$prod->precio}}</h6> 
                                                        </td>                                                    
                                                        <td>
                                                       <h6>{{$prod->costo}}</h6>
                                                        </td> 
                                                        <td>
                                                        <h3>20</h3>
                                                        </td> 
                                                        <td>
                                                       <h6>200</h6>
                                                        </td> 
                                                        <td>
                                                        <h6>5%</h6> 
                                                        </td> 
                                                        <td>
                                                       <h6>500</h6> 
                                                        </td> 
                                                        <td class="text-center">
                                                            <a href="#"
                                                                class="btn btn-dark mtmobile" title="Edit">
                                                                <i class="fas fa-rush"></i>
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

                

                    </div>
                 </div>

    </div>
</div>
</div>
</div>