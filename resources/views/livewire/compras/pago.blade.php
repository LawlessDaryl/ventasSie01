<div wire:ignore.self class="modal fade" id="tipo_p" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tipo de pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-8">
                        <div class="form-group">
                            <strong style="color: rgb(74, 74, 74)">Seleccione un tipo de pago:</strong>
                            <select wire:model='tipo_pago' class="form-control">
                                <option value="Efectivo" selected>Efectivo</option>
                                <option value="Bancaria">Transaccion Bancaria</option>
                                <option value="Tigo">TigoMoney</option>
                                
                            </select>
                            @error('tipo_pago')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror                                          
                        </div>
                    </div>
                   
                </div>
               
            </div>
                   
          
            
        </div>
    </div>
</div>