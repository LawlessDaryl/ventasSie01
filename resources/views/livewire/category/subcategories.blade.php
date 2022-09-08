<div wire:ignore.self class="modal fade" id="theModal_subcategory" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header  bg-primary text-white" style="background: #f8f6f6">
             <b>Lista de Subcategorias</b> 
           </div>
           <div class="modal-body">

          
               <div class="table-responsive">
                   <table class="table table-unbordered table-hover mt-2">
                       <thead class="text-white" style="background: #eb4569">
                           <tr>
                               <th class="table-th text-withe">NOMBRE</th>
                               <th class="table-th text-withe text-center">DESCRIPCION</th>
                               <th class="table-th text-withe text-center">ACCIONES</th>
                            
                           </tr>
                       </thead>
                      
                       <tbody>
                           @forelse ($subcat as $category)
                               <tr>
                                   <td>
                                       
                                       <h6>{{ $category->name }}</h6>
                                   </td>
                                   <td>
                                       <h6>{{ $category->descripcion }}</h6>
                                   </td>
                                  
                                   <td class="text-center">
                                       <a href="javascript:void(0)" wire:click="Edit({{ $category->id }})"
                                           class="btn btn-dark p-1" title="Edit">
                                           <i class="fas fa-edit"></i>
                                       </a>
                                       <a href="javascript:void(0)" onclick="Confirm('{{ $category->id }}','{{ $category->name }}',
                                           '{{ $category->products->count() }}')" class="btn btn-danger p-1"
                                           title="Delete">
                                           <i class="fas fa-trash"></i>
                                       </a>
                                    
                                       
                                   </td>
                               </tr>
                               @empty 
                               <p>No tiene categorias que  mostrar</p>
                           @endforelse
                       </tbody>
                   </table>
                   
               </div>
              
        
                   
                </div>
                <div class="tabs tab-pills text-right">
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning m-2"
                    data-dismiss="modal" style="background: #3b3f5c">Cerrar</button>
                </div>
           </div>
</div>        
</div>   
</div> 
            
            
            