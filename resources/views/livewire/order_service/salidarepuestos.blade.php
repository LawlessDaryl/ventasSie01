
<div wire:ignore.self class="modal fade" id="salidarepuestos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: rgb(60, 53, 53)">
                <h5 class="modal-title" id="exampleModalCenterTitle">Repuestos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="d-flex row ml-2">
                                <h6>Buscar Repuesto(Nombre o codigo del repuesto):</h6>
                            </label>
                            @if ($result)
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <a class="input-group-text input-gp btn btn-warning" wire:click="deleteItem()">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                                <input type="text" wire:model="result" placeholder="Buscar" class="form-control">
                                @error('result')
                                <span class="text-danger er">{{ $message }}</span>
                                @enderror   
                            </div>
                            @else
                            <input wire:model="searchproduct" class="form-control">
                            @error('result')
                            <span class="text-danger er">{{ $message }}</span>
                            @enderror  
                            @endif
                            
                        </div>
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
                                                                        <h6 class="text-center">{{ $d->nombre }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="javascript:void(0)"
                                                                            wire:click="Seleccionar('{{ $d->id }}')"
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

                    <div class="col-lg-2 ml-1 p-0">
                        <div class="form-group">
                            <label>
                                <h6>Cantidad</h6>
                            </label>
                            <input wire:model="cantidad" class="form-control">
                            @error('cantidad')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror   
                        </div>
                   
                    </div>
                    <div class="col-lg-2 ml-1 p-0">
                        <div class="form-group">
                            <label>
                                <h6>Precio de Venta</h6>
                            </label>
                            <input wire:model="precio_venta" class="form-control">
                            @error('precio_venta')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror   
                        </div>
                   
                    </div>
               
                    <div class="col-lg-1 ml-1 p-0">
                        <div class="form-group">
                            <label>
                                <h6>Agregar</h6>
                            </label>
                            <button type="button" wire:click="addProduct({{$selected}})"
                            class="btn btn-warning fas fa-arrow-down"></button>
                        </div>

                        
                    </div>
                </div>
              
               
                <div class="row">
                    <div class="col-lg-12">

                        @if (count($col)>0)
                        <label> <strong>Lista de repuestos del servicio</strong> </label>

                                <table class="salidarepuestos">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>PRODUCTO</th>         
                                            <th>CANTIDAD</th>
                                            <th>P/V</th>
                                            <th>Acc.</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($col as $key=>$value)
                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
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
                                               

                                                <a href="javascript:void(0)" wire:key="{{ $loop->index }}" wire:click="eliminaritem({{$value['product_id']}} )"
                                                    class="btn btn-danger p-0" title="Quitar producto de la lista">
                                                    <i class=" btn btn-sm fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                     
                                      
                                       @endforeach
                                    </tbody>
                                 </table>
                     
                        @endif

                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-12 mt-3">
                    <div class="form-group col-lg-6">
                        <strong style="color: rgb(74, 74, 74)">Agregue una observacion:</strong>
                        <input type="text" class="form-control" wire:model='observacion'>
                       
                        @error('observacion')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror                                        
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-12 mt-3">
                    <div class="row d-flex justify-content-end">
                        <a href="javascript:void(0)" class="btn btn-warning mr-1" wire:click="GuardarOperacion()">Guardar</a>
                        <a class="btn btn-warning ml-1 text-white" wire:click="exitModalRepuestos()">Cancelar</a>
                    </div>
                </div>
            </div>
  
        </div>
    </div>
    {{-- <div class="modal-overlay" id="modal-overlay">
    </div> --}}
</div>