<div wire:ignore.self class="modal fade" id="modalcambiarusuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <div class="text-center">
                    <h4> <b>CAMBIAR USUARIO VENDEDOR</b></h4>
                </div>


                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="">
                <div class="text-center">
                    ¿Cambiar al Usuario Vendedor: <b>{{$this->nombreusuariovendedor}}</b> ?
                    <br>
                    <b>Seleccione Uno</b>
                </div>

            </div>
            
            <div class="modal-body" style="color: black">
            
                  <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                    <thead class="text-white" style="background: #ee761c">
                      <tr>
                        <th>Nombre Usuario</th>
                        <th class="table-th text-withe text-center">Seleccionar</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($usuarios as $dv)
                      <tr>
                        <td class="text-left">
                            {{ ucwords(strtolower($dv->name)) }}
                        </td>
                        <td class="text-center">
                            <button wire:click="seleccionarusuario({{$dv->id}})" title="Seleccionar Usuario" style="background: #ee761c; color:white; border-color: white; cursor: pointer;">
                                <i class="fas fa-check"></i>
                            </button>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <br>

            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>