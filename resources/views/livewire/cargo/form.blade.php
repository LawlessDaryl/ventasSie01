@Include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ingrese nombre de Cargo">
        </div>
        @error('name') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>

    {{--<div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nro de Vacantes</label>
            <input type="text" class="form-control" wire:model.lazy="nrovacantes" placeholder="Ingrese nro de vacante requerido">
        </div>
        @error('nrovacantes') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>--}}

    <div class="col-sm-12 col-md-5">
        <div class="form-group">
            <label>Estado de Cargo</label>
            <select id="seleccion" wire:model="estado" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="Disponible" selected>Disponible</option>
                <option value="No Disponible" selected>No Disponible</option>
            </select>
            @error('estado') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')