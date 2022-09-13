
<div wire:ignore.self class="modal fade" id="verproductos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Lista Mobiliario Producto</h5>
               
            </div>
            <div class="modal-body">
               
                @if ($listaproductos and $listaproductos->count()>0)
                <div class="table-responsive">
                    <table class="tablamodal">
                        <thead class="text-white">
                            <tr>
                                <th>ITEM</th>
                                <th>NOMBRE</th>                              
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>

                                
                            @foreach ($listaproductos as $data)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                  
                                    <td>
                                        <h6 class="text-center">{{ $data->producto->nombre}}</h6>
                                    </td>
                                    
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:key="{{ $loop->index }}" wire:click="delete('{{ $data->id }}')" 
                                            class="btn btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <div>
                                Este mobiliario no tiene ningun producto asignado
                            </div>
                            @endif
                        </tbody>
                    </table>
                    
                </div>
            </div>
            <div class="tabs tab-pills text-right m-2">
                        
                <button type="button" class="btn btn-warning"
                data-dismiss="modal">CERRAR</button>

        </div>
        </div>
    </div>
</div>