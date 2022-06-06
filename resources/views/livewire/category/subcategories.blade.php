<div wire:ignore.self class="modal fade" id="theModal_subcategory" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg-12" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background: #f8f6f6">
           
            @if ($subcat->count() != 0)
            <div class="table-responsive">
                <table class="table table-unbordered table-hover mt-2">
                    <thead class="text-white" style="background: #3B3F5C">
                        <tr>
                            <th class="table-th text-withe">NOMBRE</th>
                            <th class="table-th text-withe text-center">DESCRIPCION</th>
                            <th class="table-th text-withe text-center">ACCIONES</th>
                         
                        </tr>
                    </thead>
                   
                    <tbody>
                        @foreach ($subcat as $category)
                            <tr>
                                <td>
                                    
                                    <h6>{{ $category->name }}</h6>
                                </td>
                                <td>
                                    <h6>{{ $category->descripcion }}</h6>
                                </td>
                               
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click="Edit({{ $category->id }})"
                                        class="btn btn-dark mtmobile" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="Confirm('{{ $category->id }}','{{ $category->name }}',
                                        '{{ $category->products->count() }}')" class="btn btn-dark"
                                        title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                 
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            @else
            <p class="modal-text">No cuenta con subcategorias. </p>
            @endif
                
            
</div>
</div>        
</div>   
</div> 
            
            
            