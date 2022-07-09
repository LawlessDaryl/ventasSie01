<div wire:ignore.self class="modal fade" id="ajustesinv" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Ajuste de Inventarios</h5>
               
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6> <b>Producto</b> </h6>
                            </label>
                           <h6>{{$productoajuste}}</h6>
                        </div>
                       
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>
                                <h6> <b>Existencias:</b> </h6>
                            </label>
                            <input wire:model="cantidad" class="form-control">
                            
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label>
                                <h6> <b>Accion</b> </h6>
                            </label>
                            <button type="button" wire:click="guardarajuste()"
                            class="btn fas fa-save"></button>
                        </div>

                        
                    </div>
                </div>
            </div>
  
        </div>
    </div>
</div>