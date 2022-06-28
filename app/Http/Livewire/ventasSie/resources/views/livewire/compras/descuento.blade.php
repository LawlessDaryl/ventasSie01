<div wire:ignore.self class="modal fade" id="modal_desc" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >

            <div class="modal-header" style="background: #fcfbfb">
            <h5 class="modal-title text-dark">
                <b>Agregar Descuento</b>
            </h5>
            <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
         <div class="modal-body" style="background: #ffffff">
              <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                          <strong style="color: rgb(74, 74, 74)">Dscto. en compras:</strong>
                                          <input type="text" wire:model="descuento" wire:change="descuento_change" class="form-control">
                                          @error('descuento')
                                              <span class="text-danger er">{{ $message }}</span>
                                          @enderror   
                                          
                                       </div>
                                    </div>
   
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <strong style="color: rgb(74, 74, 74)">Dscto. </strong>
                                            <h5>{{$porcentaje}}%</h5>
                                          </div>
                                    </div>
                                </div>
                <div class="row">

                    <div class="col-lg-6" >
                        <button type="button" wire:click.prevent="resetProv()" class="btn btn-dark close-btn text-info"
                         data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                       
                    </div>
        
                    <div class="col-lg-6">
                        <button type="button" wire:click.prevent="aplicarDescto()"
                        class="btn btn-dark close-btn text-info">Aplicar</button>
                    </div>
                </div>
            </div>
            
     
    </div>
        </div>
        
</div>
