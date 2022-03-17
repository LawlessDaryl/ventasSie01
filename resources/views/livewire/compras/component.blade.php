
    <div class="row sales layout-top-spacing">
       <div class="col-sm-12" >

           <div class="widget widget-chart-one">
               <div class="widget-heading">
                   <div class="col-12 col-lg-12 col-md-10 mt-3">
                       <div class="row mb-4" >
                           <div class="col-sm-12" >
                               <h5 class="mb-2 mt-2">DETALLE DE COMPRA NRO. {{$nro_compra}}</h5>
                               <b>Fecha: </b>
                               {{$fecha}}<br/>  
                               <b>Registrado por: </b> 
                               {{$usuario}}<br/>
                               <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />

                           </div>
                       </div>
                     
                        
                           <div class="row">

                                <div class="col-12 col-md-3 col-lg-4" style="border-left: thick solid #b4b4b1;" >
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <strong>Proveedor</strong>
                                            <div class="input-group-prepend mb-3" >

                                                <input type="text" wire:model.lazy="provider" class="form-control" placeholder="Introduzca el numero de factura">
                                               
                                                    <span class="input-group-text input-gp">
                                                        <a href="javascript:void(0)" data-toggle="modal"
                                                            data-target="#modal_prov" class="fas fa-plus" ></a>
                                                    </span>
                                                
                                            </div>
                                            @error('provider')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                          </div>
                                          
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                          <strong>Metodo de Pago:</strong>
                                          <select wire:model='tipo_documento' class="form-control">
                                              <option value="Elegir" selected>Elegir</option>
                                              <option value="NOTA DE VENTA">Pago en efectivo</option>
                                              <option value="RECIBO">Transferencia bancaria</option>
                                              <option value="RECIBO">Pago por Movil</option>
                                          </select>
                                          @error('tipo_documento')
                                              <span class="text-danger er">{{ $message }}</span>
                                          @enderror
                                       </div>
                                    </div>

                                </div>


                                <div class="col-12 col-md-3 col-lg-4" style="border-left: thick solid #b4b4b1;" >
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                          <strong>Tipo de Documento:</strong>
                                          <select wire:model='tipo_documento' class="form-control">
                                              <option value="Elegir" selected>Elegir</option>
                                              <option value="FACTURA">FACTURA</option>
                                              <option value="NOTA DE VENTA">NOTA DE VENTA</option>
                                              <option value="RECIBO">RECIBO</option>
                                          </select>
                                          @error('tipo_documento')
                                              <span class="text-danger er">{{ $message }}</span>
                                          @enderror
                                       </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <strong>Número de Documento</strong>
                                            <input type="text" wire:model.lazy="nro_documento" class="form-control" placeholder="Introduzca el numero de factura">
                                            @error('nro_documento')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                          </div>
                                    </div>

                                </div>
                             

                                <div class="col-12 col-md-3 col-lg-4" style="border-left: thick solid #b4b4b1;" >

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <strong>Pago parcial:</strong>
                                           <input  wire:model='pago_parcial' type="text" class="form-control" placeholder="Bs. 0">
                                           @error('pago_parcial')
                                           <span class="text-danger er">{{ $message }}</span>
                                           @enderror
                                       </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                               <strong>Observacion: </strong>
                                            <textarea  wire:model='observacion' class="form-control" aria-label="With textarea"></textarea>
                                            @error('observacion')
                                            <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                             </div>
                       

                   </div>
                 {{--<ul class="tabs tab-pills" >
                       <a href="javascript:void(0)" class="tabs btn btn-dark m-2
                       " data-toggle="modal"
                           data-target="#modal_prov">Asignar Proveedor</a>
               
                       <a href="javascript:void(0)" class="btn btn-dark m-2" data-toggle="modal"
                           data-target="#theModal">Crear Producto
                       </a>
                   </ul>--}}  
               </div>
               <hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(230, 152, 64);" />

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
       @include('livewire.compras.provider_info')
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    
          
            window.livewire.on('show-modal', msg => {
                $('#modal_prov').modal('show')
            });
            window.livewire.on('modal-hide', msg => {
                $('#modal_prov').modal('hide')
            });
        });
    
        function Confirm(id, name, cantRelacionados ) {
            if (cantRelacionados > 0) {
                swal.fire({
                    title: 'PRECAUCION',
                    icon: 'warning',
                    text: 'No se puede eliminar la empresa "' + name + '" porque tiene ' 
                    + cantRelacionados + ' sucursales.'
                })
                return;
            }
            swal.fire({
                title: 'CONFIRMAR',
                icon: 'warning',
                text: '¿Confirmar eliminar la empresa ' + '"' + name + '"?.',
                showCancelButton: true,
                cancelButtonText: 'Cerrar',
                cancelButtonColor: '#383838',
                confirmButtonColor: '#3B3F5C',
                confirmButtonText: 'Aceptar'
            }).then(function(result) {
                if (result.value) {
                    window.livewire.emit('deleteRow', id)
                    Swal.close()
                }
            })
        }
    </script>
    