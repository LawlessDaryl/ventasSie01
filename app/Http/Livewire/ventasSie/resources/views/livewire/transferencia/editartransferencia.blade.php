<div class="row sales layout-top-spacing">
   <div class="col-sm-12">
       <div class="widget widget-chart-one">
           <div class="widget-heading">
               <h4 class="card-title">
                   <b>Editar Transferencia Productos</b>
               </h4>
             <h2>{{$ide}}</h2>
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

                   @if($selected_origen !== null && strlen($search) > 0 )

                       <div class="table-responsive">
                           <table class="table table-unbordered table-hover mt-2">
                               <thead class="text-white" style="background: #3B3F5C">
                                   <tr>
                                       <th class="table-th text-withe text-center">ITEM</th>
                                       <th class="table-th text-withe text-center">PRODUCTO</th>                              
                                       <th class="table-th text-withe text-center">STOCK</th>                         
                                       <th class="table-th text-withe text-center">ACCION</th>                         
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach ($destinos_almacen as $destino)
                                       <tr>
                                           <td>
                                               <h6 class="text-center">{{ $loop->iteration}}</h6>
                                           </td>
                                           <td>
                                               <h6 class="text-center">{{ $destino->name }}</h6>
                                           </td>
                                           
                                           <td>
                                           <h6 class="text-center">{{ $destino->stock }}</h6>
                                           </td>
                                           <td class="text-center">
                                               <a href="javascript:void(0)" wire:click="increaseQty({{ $destino->prod_id }})"
                                                   class="btn btn-dark mtmobile">
                                                   <i class="fas fa-plus"></i>
                                               </a>
                                           </td>
                                       </tr>
                                   @endforeach
                               </tbody>
                           </table>
                           {{$destinos_almacen->links() }}

                       </div>
                   
                   @else
                   <span>No se encontraron resultados</span>
                   @endif
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
                                   <button class="btn btn-lg btn-primary p-2" wire:click="finalizar_tr()" style="color: black">Finalizar</button>
                               </div>
                           </div>
                          
                        
                               <div class="col-4 col-lg-4 col-md-4 justify-content-center">
       
                                   <div class="form-group">
                                       <button wire:click="resetUI()" class="btn btn-lg btn-warning p-2 pr-2 pl-2" style="color: black">Reset</button>
                                   </div>
                               </div>
                               <div class="col-4 col-lg-4 col-md-4">
               
                                   <div class="form-group">
                                       <button wire:click="exit()" class="btn btn-lg btn-danger  p-2" style="color: black">Cancelar</button>
                                   </div>
                               </div>
       
                           
                       </div>
                   </div>
                 
           </div>
        
       </div>
     
   </div>
 
 
</div>

<script>
   document.addEventListener('DOMContentLoaded', function() {
       window.livewire.on('no-stock', msg => {
          noty(msg)
      });
   });


</script>