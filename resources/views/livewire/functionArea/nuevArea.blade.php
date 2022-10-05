<div wire:ignore.self class="modal fade" id="theModal-area" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
              <h5 class="modal-title text-white">
                  <b>{{$componentNuevArea}}</b> | {{$selected_id > 0 ? 'EDITAR':'CREAR'}}
              </h5>
              <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
              <button wire:click.prevent="resetUI()" data-dismiss="modal" class="btn-warning">X</button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" wire:model.lazy="nameArea" class="form-control">
                            @error('nameArea') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Descripcion</label>
                            <textarea type="text" class="form-control" wire:model.lazy="descriptionArea"></textarea>
                            @error('descriptionArea') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancelar()" class="btn btn-warning close-btn text-info"
                    data-dismiss="modal" style="background: #ee761c">CANCELAR
                </button>
                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="RegNuevArea()"
                        class="btn btn-warning close-btn text-info">GUARDAR</button>
                @endif
            </div>
        </div>
    </div>
</div>