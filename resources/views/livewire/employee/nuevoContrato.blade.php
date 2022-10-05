<div wire:ignore.self class="modal fade" id="theModal-contrato" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
              <h5 class="modal-title text-white">
                  <b>{{$componentNuevoContrato}}</b> | {{$selected_id > 0 ? 'EDITAR':'CREAR'}}
              </h5>
              <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
              <button wire:click.prevent="resetUI()" data-dismiss="modal" class="btn-warning">X</button>
            </div>
            <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Fecha de Final</label>
                                <input type="date" wire:model.lazy="fechaFin" class="form-control">
                                @error('fechaFin') <span class="text-danger er">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" wire:model.lazy="descripcion" class="form-control">
                                @error('descripcion') <span class="text-danger er">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Nota</label>
                                <textarea type="text" class="form-control" wire:model.lazy="nota"></textarea>
                                @error('nota') <span class="text-danger er">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Salario</label>
                                <input type="number" wire:model.lazy="salario" class="form-control">
                            </div>
                            @error('salario') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Estado de Contrato</label>
                                <select wire:model.lazy="estado" class="form-control">
                                    <option value="Elegir" disabled>Elegir</option>
                                    <option value="Activo" selected>Activo</option>
                                    <option value="Finalizado" selected>Finalizado</option>
                                </select>
                                @error('estado') <span class="text-danger er">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
  

            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancelar()" class="btn btn-warning close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CANCELAR
                </button>
                
                    <button type="button" wire:click.prevent="RegNuevoContrato()"
                        class="btn btn-warning close-btn text-info">GUARDAR</button>
                
            </div>
        </div>
    </div>
</div>