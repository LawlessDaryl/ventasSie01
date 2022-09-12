<div wire:ignore.self class="modal fade" id="asignar_mobiliario" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
            <div class="modal-header  bg-primary text-white" style="background: #f8f6f6">
                <b>Asignar Mobiliarios</b> 
            </div>
                        <div class="modal-body">

                            <label>Ingrese el nombre,codigo del producto</label>
                          

                            
                            <div class="table-responsive">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-gp">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" wire:model="search2" placeholder="Buscar" class="form-control">
                                </div>
                                @if(strlen($search2) >0)
                                
                                <div class="col-sm-12 col-md-12">
                                            <div class="vertical-scrollable">
                                                <div class="row layout-spacing">
                                                    <div class="col-md-12 ">
                                                        <div class="statbox widget box box-shadow">
                                                            <div class="widget-content widget-content-area row">
                                                                <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                                                <table class="table table-hover table-sm" style="width:100%">
                                                                    
                                                                    <tbody>
                                                                        
                                                                        @forelse ($data_mob as $data_m)
                                                                        <tr>
                                                                              
                                                                                    <td class="text-center">
                                                                                        <h6>{{$data_m->nombre }}
                                                                                        </h6>
                                                                                    </td>

                                                                                    <td>
                                                                                   
                                                                                        <a href="javascript:void(0)" wire:click="addProd({{ $data_m->id}})"
                                                                                            class="btn btn-danger">
                                                                                            <i class="fas fa-check"></i>
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                      
                                                                                @empty 
                                                                                <p>No existe productos con ese criterio de busqueda</p>
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
                                        
                                    </tbody>
                                </table>
                                
                            </div> 
                            @endif

                            @if ($col->count() != 0)
                                
                            <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
                                <table class="table table-hover table-sm" style="width:100%">
                                            <thead>
                                            <th>Codigo Producto</th>    
                                            <th>Nombre Producto</th>  
                                            <th>Acc.</th>  
                                            </thead>                        
                                    <tbody>
                                        @forelse ($col as $datacol)  
                                        <tr>
                                            
                                            <td class="text-center">
                                                <h6>{{$datacol['product_codigo']}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$datacol['product_name']}}</h6>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" wire:click="quitarProducto({{ $datacol['product_codigo']}})"
                                                    class="btn btn-danger text-white">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </td>
                                            
                                       
                                        </tr>
                                       
                                      
                                                @empty 
                                                <p></p>
                                            @endforelse
                                        </tbody>
                                    </table>
                                
                                    @endif
                            </div>
                        </div>
                    <div class="tabs tab-pills text-right m-2">
                        
                            <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning"
                            data-dismiss="modal">CANCELAR</button>
                        
                            <button type="button" wire:click.prevent="asignarMobiliario()"
                                class="btn btn-warning">GUARDAR</button>
                  
                    </div>
               </div>
        </div>        
    </div>   
</div> 
            
            
            