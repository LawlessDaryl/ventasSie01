<div class="row sales layout-top-spacing">
    <div class="col-sm-12" >

        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <div class="col-12 col-lg-12 col-md-10 mt-3">
                    <div class="row mb-3" >
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

                             <div class="col-12 col-md-4 col-lg-4 card">
                                 <div class="row">

                                     <div class="col-lg-12">
                                         <div class="form-group">
                                             <strong>Proveedor</strong>
                                             <div class="input-group-prepend mb-3">
    
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
                                            <strong>Destino Producto</strong>
                                            <select value="Elegir" wire:model.lazy="destino" class="form-control">
                                              <option value="Elegir Destino">Elegir Destino</option>

                                              @foreach($data_suc as $data)
                                              <option value="{{$data->id}}">{{$data->nombre}}-{{$data->name}}</option>
                                              @endforeach
                                              
                                            </select>
                                          </div>

                                       
                                     </div>

                                 </div>
                             </div>

                             <div class="col-12 col-md-4 col-lg-4 card" style="border: thick #b4b4b1;" >

                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                          <strong>Dscto. en compras:</strong>
                                          <input type="text" wire:model.lazy="descuento" class="form-control">
                                          @error('descuento')
                                              <span class="text-danger er">{{ $message }}</span>
                                          @enderror                                          
                                       </div>
                                    </div>
   
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <strong>Dscto. %</strong>
                                            <h5>10%</h5>
                                          </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <strong>Tipo transaccion:</strong>
                                            <select wire:model='tipo_transaccion' class="form-control">
                                                <option value="CONTADO" selected>Contado</option>
                                                <option value="CREDITO">Credito</option>
                                                
                                            </select>
                                            @error('tipo_documento')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror                                          
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <strong>Pago parcial:</strong>

                                            @if($tipo_transaccion == "CONTADO")

                                           <input  wire:model='pago_parcial' type="text" disabled class="form-control" placeholder="Bs. 0">
                                           @else
                                           <input  wire:model='pago_parcial' type="text" class="form-control" placeholder="Bs. 0">
                                           @endif
                                           @error('pago_parcial')
                                           <span class="text-danger er">{{ $message }}</span>
                                           @enderror
                                       </div>
                                    </div>

                                </div>
                             </div>
                             <div class="col-12 col-md-4 col-lg-4" style="border: thick #b4b4b1;" >

                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                          <strong>Tipo de Documento:</strong>
                                          <select wire:model='tipo_documento' class="form-control">
                                              <option value="FACTURA" selected>Factura</option>
                                              <option value="NOTA DE VENTA">Nota de Venta</option>
                                              <option value="RECIBO">Recibo</option>
                                              <option value="Ninguno">Ninguno</option>
                                          </select>
                                          @error('tipo_documento')
                                              <span class="text-danger er">{{ $message }}</span>
                                          @enderror                                          
                                       </div>
                                    </div>
   
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <strong>Nro. de Documento</strong>
                                            <input type="text" wire:model.lazy="nro_documento" class="form-control">
                                            @error('nro_documento')
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
                    <div class="col-lg-4 col-12 col-md-12">
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
                         
                                   @if(strlen($search) > 0)
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
                                                         <a href="javascript:void(0)" wire:click="increaseQty({{ $prod->id }})"
                                                             class="btn btn-dark mtmobile">
                                                             <i class="fas fa-plus"></i>
                                                         </a>
                                                        
                                                     </td>
                                                 </tr>
                                             @endforeach
                                         </tbody>
                                     </table>
                                 </div>
                             @endif
                                
                            </div>
                        
                        
                    </div>
               
                    <div class="col-lg-8 col-12  col-md-12">
                        <div class="widget mr-2 mb-2 mt-2">
                           
                                <div class="table-responsive p-1">
                                    <table class="table table-unbordered table-hover mt-2">
                                        <thead class="text-white" style="background: #3B3F5C">
                                            <tr>
                                                <th class="table-th text-withe text-center">Producto</th>
                                                <th class="table-th text-withe text-center">Codigo</th>
                                                <th class="table-th text-withe text-center">Precio <br>Compra</th>
                                                <th class="table-th text-withe text-center">Precio <br>Venta</th>
                                                <th class="table-th text-withe text-center">Cantidad</th>
                                                <th class="table-th text-withe text-center">Total</th>
                                             
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
                                                         id="r{{$prod->id}}" 
                                                         wire:change="UpdatePrice({{$prod->id}}, $('#r' + {{$prod->id}}).val() )" 
                                                         style="font-size: 1rem!important;" 
                                                         class="form-control text-center" 
                                                         value="{{$prod->price}}">
                                                    </td>

                                                    <td>
                                                         <input type="number" 
                                                         id="rr{{$prod->id}}" 
                                                         wire:change="UpdateQty({{$prod->id}}, $('#rr' + {{$prod->id}}).val() )" 
                                                         style="font-size: 1rem!important;" 
                                                         class="form-control text-center" 
                                                         value="{{$prod->quantity}}">
                                                    </td>
                                                   
                                                    <td>
                                                        <h6>{{$prod->getPriceSum()}}</h6>
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
                                            <tfoot class="text-white text-center" style="background: #a5a19e"  >
                                                    <tr>
                                                        <td colspan="4">
                                                             <h5 class="text-white">SubTotal.-</h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-white" >{{$subtotal}}</h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">
                                                             <h5 class="text-white">Descuento.-</h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-white" >{{$descuento}}</h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">
                                                             <h5 class="text-white">Total.-</h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-white" >{{$total_compra}}</h5>
                                                        </td>
                                                    </tr>
                                            </tfoot>
                                        </tbody>
                                    </table>
                                </div>
                            
                        </div>
                        <div class="row">

                            <div class="col-lg-6">
        
                                <button class="btn btn-info m-3"> <h4 style="color: aliceblue" >Guardar Compra</h4> </button>
                            </div>
                            <div class="col-lg-6">
        
                                <button class="btn btn-danger m-3"> <h4 style="color: aliceblue" >Cancelar Compra</h4> </button>
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
 