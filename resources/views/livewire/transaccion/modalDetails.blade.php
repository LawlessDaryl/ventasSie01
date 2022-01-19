<div wire:ignore.self id="modal-detailes" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>GENERAR INGRESO / EGRESO</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">


                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>CARTERA</label>
                            <select wire:model='cartera_id' class="form-control">
                                <option value="Elegir" selected disabled>Elegir</option>
                                @foreach ($carterasCaja as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cartera_id') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>GENERAR</label>
                            <select wire:model='type' class="form-control">
                                <option value="Elegir" selected disabled>Elegir</option>
                                <option value="EGRESO">EGRESO</option>
                                <option value="INGRESO">INGRESO</option>
                            </select>
                            @error('type') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Valor</label>
                            <input type="number" wire:model.lazy="cantidad" class="form-control"
                                placeholder="ej: 1000.0">
                            @error('cantidad') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Comentarios</label>
                            <input type="text" wire:model.lazy="comentario" class="form-control" placeholder="ej: "
                                maxlength="255">
                            @error('comentario') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>

                </div>
                <div>
                    <a href="javascript:void(0)" class="btn btn-dark" wire:click.prevent="Generar()">Generar</a>
                </div>

            </div>

            
        </div>
    </div>
</div>
