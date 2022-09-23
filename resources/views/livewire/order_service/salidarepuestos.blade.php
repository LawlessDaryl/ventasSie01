
<div wire:ignore.self class="modal fade" id="salidarepuestos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                  <center>Registro de Repuestos</center> 
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
        <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
              
                   
                    @if ($result)
                    <div class="col-lg-5">
                        <label for="recipient-name">
                            <h6>Repuesto:</h6>
                        </label>
                        <div class="input-group mb-4">
                        
                                <a class="input-group-text input-gp btn btn-sm btn-warning" wire:click="deleteItem()">
                                    <i class="fas fa-times"></i>
                                </a>
                          
                            <input type="text" wire:model="result"  disabled placeholder="Buscar" class="form-control" id="recipient-name">
                            @error('result')
                            <span class="text-danger er">{{ $message }}</span>
                            @enderror   
                        </div>
                    </div>
                    <div class="col-lg-2 pl-2 pr-0 mr-1">
                        <label>
                            <h6>Cantidad</h6>
                        </label>
                        <input wire:model="cantidad" class="form-control" id="recipient-name">
                        @error('cantidad')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror   
                    </div>

                    <div class="col-lg-2 pl-0 pr-2">
                        <label>
                            <h6>P/Venta</h6>
                        </label>
                        <input wire:model="precio_venta" class="form-control">
                        @error('precio_venta')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror   
                    </div>
                    <div class="col-lg-2" style="margin-top: 1.8rem">
                     
                        <button type="button" wire:click="addProduct({{$selected}})"
                        class="btn btn-warning  fas fa-arrow-down"><span>Agregar</span></button>
                    </div>



                    @else
   
                    <div class="col-lg-9">
                        <label for="recipient-name">
                            <h6>Buscar Repuesto(Nombre o codigo del repuesto):</h6>
                        </label>
                        <input wire:model="searchproduct" class="form-control">

                    @if ($buscarproducto != 0)
                    <div class="col-sm-12 col-md-12">
                        <div class="vertical-scrollable">
                            <div class="row layout-spacing">
                                <div class="col-md-12 ">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-content widget-content-area row">
                                            <div
                                                class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                                <table class="table table-hover table-sm" style="width:100%">
                                                    
                                                    <tbody>
                                                        @forelse ($sm as $d)
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h6 class="text-center">{{ $d->prod_name }}- <b>{{$d->dest_name}}</b> 
                                                                    </h6>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0)"
                                                                        wire:click="Seleccionar('{{ $d->pid }}')"
                                                                        class="btn btn-warning mtmobile"
                                                                        title="Seleccionar">
                                                                        <i class="fas fa-check"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            
                                                        <p>No existen productos con el criterio de busqueda</p>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>




                    @error('result')
                    <span class="text-danger er">{{ $message }}</span>
                    @enderror  
                    @endif

                </div>
               
            
              <div class="row p-3">
                <div class="col-lg-12 mt-2">
                    @if (count($col)>0)
                <center><label for="tablarep" class="mb-2"> <b>LISTA DE REPUESTOS</b> </label></center>
                  <center> <table class="salidarepuestos" id="tablarep">
                        <thead class="table-light">
                            <tr>
                                <th style="width:20px">#</th>
                                <th>Producto</th>         
                                <th style="width: 40px">Cant.</th>
                                <th style="width: 40px">p/v</th>
                                <th>Destino</th>

                                <th style="width: 3rem">Acc.</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($col as $key=>$value)
                            <tr>
                                <td>
                                    <b style="font-size: 1rem" >{{$loop->iteration}}</b> 
                                </td>
                                <td>
                                    <h6>{{$value['product-name']}}</h6>
                                </td>


                                <td>
                                    <h6>{{$value['cantidad']}}</h6>
                                </td>
                                <td>
                                    <h6>{{$value['precio_venta']}}</h6>
                                </td>
                                <td>
                                    <h6>{{$value['destino']}}</h6>
                                </td>
                                <td>
                                   

                                    {{-- <a href="javascript:void(0)" wire:key="{{ $loop->index }}" wire:click="eliminaritem({{$value['product_id']}} )"
                                        class="btn btn-danger p-0" title="Quitar producto de la lista">
                                        <i class=" btn btn-sm fas fa-trash"></i>
                                    </a> --}}

                                    <button class="btn btn-sm btn-danger fas fa-times pl-1 pr-1 pt-0 pb-0 m-0" title="Quitar producto de la lista" wire:key="{{ $loop->index }}" wire:click="eliminaritem({{$value['product_id']}} )"></button>
                                </td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                </center> 
            @endif


                </div>
                
              </div>
              <div class="row">
                @if (count($col)>0)
                <div class="col-md-6 ms-auto">

                    <strong style="color: rgb(74, 74, 74)">Agregue una observacion:</strong>
                    <input type="text" class="form-control" wire:model='observacion'>
                   
                    @error('observacion')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror  
                </div>
                @endif
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-12 mt-3">
                    <div class="row d-flex justify-content-end">
                        <a href="javascript:void(0)" class="btn btn-warning mr-1" wire:click="GuardarOperacion()" >Guardar</a>
                        <a class="btn btn-warning ml-1 text-white" wire:click="exitModalRepuestos()">Cancelar</a>
                    </div>
                </div>
              </div>
             
            </div>
        </div>
    </div>
</div>



</div>
    {{-- <div class="modal-overlay" id="modal-overlay">
    </div> --}}
