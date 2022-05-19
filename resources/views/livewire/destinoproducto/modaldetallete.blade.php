<div wire:ignore.self class="modal fade" id="detailtranferencete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Detalle de transferencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
        

                        @if($datalist_destino!=null)
                         
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-2">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-withe text-center">#</th>
                                        <th class="table-th text-withe text-center">Descripcion</th>                              
                                        <th class="table-th text-withe text-center">Cantidad</th>
                                        <th class="table-th text-withe text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datalist_destino as $ob)
                                    <tr>
                                        <td>
                                            <h6 class="text-center">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $ob->producto->nombre }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $ob->cantidad }}</h6>
                                        </td>
                                        
                                        <td class="text-center">
                                            <a href="javascript:void(0)" wire:click="Edit({{ $ob->tr_des_id }})"
                                                class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" onclick="Confirm('{{ $ob->id }}','{{ $ob->nombre }}')" 
                                                class="btn btn-dark p-1 m-0" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                           
                                        </td>
                                       
                                    </tr>
                                @endforeach
                               
                            
                                @endif
                               
    
                               
    
                                </tbody>
                               
                            </table>
                         
                        </div>
            </div>
            
            <div class="row align-items-center justify-content-center">

                <button class="btn btn-info m-3 p-2"  wire:click.prevent="ingresarProductos({{$this->selected_id2}})"> <h5 style="color: aliceblue">Transferencia exitosa</h5> </button>
                <button class="btn btn-danger m-3 p-2"  wire:click.prevent="exit()" > <h5 style="color: aliceblue" > Rechazar Transferencia </h5> </button>
            
        </div>
        </div>
    </div>
</div>