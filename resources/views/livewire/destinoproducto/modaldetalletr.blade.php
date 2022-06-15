<div wire:ignore.self class="modal fade" id="detailtranference" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Detalle de transferencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                @if($detalle!=null)
                     
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-2">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-withe text-center">#</th>
                                        <th class="table-th text-withe text-center">Descripcion</th>                              
                                        <th class="table-th text-withe text-center">Cantidad</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detalle as $datas)
                                    <tr>
                                        <td>
                                            <h6 class="text-center">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $datas->producto->nombre }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{ $datas->cantidad }}</h6>
                                        </td>
                                        
                                       
                                       
                                    </tr>
                                @endforeach
                               
                               
                                @endif
                               
                                </tbody>
                               
                            </table>
                         
                        </div>
            </div>
            <br>
        </div>
    </div>
</div>