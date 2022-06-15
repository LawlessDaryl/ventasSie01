<div wire:ignore.self id="Modal_Observaciones" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Observaciones de la transacción</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <h6>Observaciones</h6>
                            <textarea wire:model.lazy="observaciones" class="form-control" name="" rows="5"></textarea>
                            @error('observaciones') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a href="javascript:void(0)" class="btn btn-warning" wire:click.prevent="Modificar()">Modificar</a>
                </div>
            </div>
        </div>
    </div>
</div>
