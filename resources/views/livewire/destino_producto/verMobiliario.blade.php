<div wire:ignore.self class="modal fade" id="mobil" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >

            <div class="modal-header" style="background: #ffffff">
            <h5 class="modal-title text-dark">
                <b>Ubicacion Producto</b>
            </h5>
            <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
         <div class="modal-body" style="background: #ffffff">
            <div class="row">
              fasf
                @if ($show === true)
            
                   <div>jk</div>
                      <div> {{$data_loc}} </div>
                    
                @endif
                   
                       
                </div>
                <div class="row">

                    <div class="col-lg-6" >
                        <button type="button" wire:click.prevent="resetProv()" class="btn btn-dark close-btn text-info"
                         data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                       
                    </div>
        
                    <div class="col-lg-6">
                        <button type="button" wire:click.prevent="addProvider()"
                        class="btn btn-dark close-btn text-info">GUARDAR</button>
                    </div>
                </div>
            </div>
            
     
    </div>
        </div>
        
</div>
