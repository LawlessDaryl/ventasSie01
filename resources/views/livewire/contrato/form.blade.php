@Include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Fecha de Final</label>
            <input type="date" wire:model.lazy="fechaFin" class="form-control">
        </div>
        @error('fechaFin') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Descripcion</label>
            <input type="text" wire:model.lazy="descripcion" class="form-control" placeholder="Ingrese descripcion de contrato">
        </div>
        @error('descripcion') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nota</label>
            <textarea type="text" class="form-control" wire:model.lazy="nota" placeholder="Ingrese nota de contrato"></textarea>
        </div>
        @error('nota') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Salario</label>
            <input type="number" class="form-control" wire:model.lazy="salario" placeholder="0.00">
        </div>
        @error('salario') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    
    <div class="col-sm-12 col-md-5">
        <div class="form-group">
            <label>Estado de Contrato</label>
            <select id="seleccion" wire:model="estado" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="Activo" selected>Activo</option>
                <option value="Finalizado" selected>Finalizado</option>
            </select>
            @error('estado') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')


