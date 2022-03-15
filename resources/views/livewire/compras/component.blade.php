
    <div class="row sales layout-top-spacing">
       <div class="col-sm-12" >

           <div class="widget widget-chart-one">
               <div class="widget-heading">
                   <div class="col-9 col-lg-8 col-md-10 mt-3">
                       <div>
                           <h5 class="mb-2 mt-2">DETALLE DE COMPRA NRO. {{$nro_compra}}</h5>
                       </div>
                       <div class="d-flex-inline-flex">
                           <div>
                               <b>Proveedor:</b>
                                   {{$provider}}<br/>
                               <b>Comprobante nro: </b>
                                   {{$comprobante}}<br/>
                               <b>Fecha: </b>
                               {{$fecha}}<br/>           
                               <b>Registrado por: </b> 
                               {{$usuario}}<br/>
                             <div class="form-check form-check-inline">
                                 <label class="form-check-label">
                                     <input class="form-check-input" type="checkbox" name="" id="" value="checkedValue"> Exento IVA
                                 </label>
                             </div>
                             <b>Pago parcial:</b> 
                             <div class="input-group mb-3">
                                <span class="input-group-text">Bs.</span>
                                <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <span class="input-group-text">.00</span>
                              </div>
                             
                              <b>Tipo de Documento:</b>
                              <select class="form-select" aria-label="Default select example">
                                <option selected>Seleccionar Documento</option>
                                <option value="2">COMPROBANTE</option>
                                <option value="3">NOTA DE VENTA</option>
                              </select><br/>
                              <b>Nro. Documento: </b>
                               {{$nro_documento}}<br/> 
                              <b>Observacion: </b>
                               <br/> 
                               <div class="input-group">
                                <span class="input-group-text">With textarea</span>
                                <textarea class="form-control" aria-label="With textarea"></textarea>
                              </div>
                             </div>
                       </div>

                   </div>
                   <ul class="tabs tab-pills" >
                       <a href="javascript:void(0)" class="tabs btn btn-dark m-2
                       " data-toggle="modal"
                           data-target="#theModal">Asignar Proveedor</a>
               
                       <a href="javascript:void(0)" class="btn btn-dark m-2" data-toggle="modal"
                           data-target="#theModal">Crear Producto
                       </a>
                   </ul>
               </div>

               <div class="widget-content">
                   <div class="row">
                       <div class="col-4">
                               <div class="widget ml-2 mt-2 mb-2 mr-0 p-2">
                                  
                                       <div class="input-group mb-4">
                                           <div class="input-group-prepend">
                                               <span class="input-group-text input-gp">
                                                   <i class="fas fa-search"></i>
                                               </span>
                                           </div>
                                           <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                                       </div>
                                   
                                   <div class="col-lg-12 col-12 col-md-4 col-sm-12">
                                       <h6 class="rounded">
                                           <b>Elementos encontrados:</b>
                                       </h6>
                                   </div>
                            
                                      
                                   <div class="table-responsive">
                                       <table class="table table-unbordered table-hover">
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
                                                               <h5 class="card-title">{{$prod->nombre}}</h5>
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
                  
                       <div class="col-8">
                           <div class="widget mr-2 mb-2 mt-2">
                              
                                   <div class="table-responsive p-1">
                                       <table class="table table-unbordered table-hover mt-2">
                                           <thead class="text-white" style="background: #3B3F5C">
                                               <tr>
                                                   <th class="table-th text-withe text-center">Producto</th>
                                                   <th class="table-th text-withe text-center">Precio <br>Compra</th>
                                                   <th class="table-th text-withe text-center">Cantidad</th>
                                                   <th class="table-th text-withe text-center">Total</th>
                                                   <th class="table-th text-withe text-center">Destino <br>Producto </th>
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
                                                           <h6>{{$prod->precio}}</h6> 
                                                       </td>
                                                       <td>
                                                           <h6>{{$prod->costo}}</h6>
                                                       </td>

                                                       <td>
                                                           <h6>500</h6>
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
                                                           <a href="#"
                                                               class="btn btn-dark mtmobile" title="Edit">
                                                               <i class="fas fa-trash"></i>
                                                           </a>

                                                       </td>
                                                   </tr>
                                               @endforeach
                                               <tfoot class="text-white text-center" style="background: #a5a19e"  >
                                                       <tr>
                                                           <td colspan="5">
                                                                <h5 class="text-white">TOTAL.-</h5>
                                                           </td>
                                                           <td>
                                                               <h5 class="text-white" >500</h5>
                                                           </td>
                                                       </tr>
                                               </tfoot>
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
