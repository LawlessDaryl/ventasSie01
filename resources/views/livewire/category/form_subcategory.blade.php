@include('common.modalHead')
<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">Nombre</span>
                </span>
            </div>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Impresoras">
        </div>
        @error('name')<span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    
</div>
<div class="row">

    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">Descripcion</span>
                </span>
            </div>
            <input type="text" wire:model.lazy="descripcion" class="form-control" placeholder="ej: breve descripcion de la categoria">
        </div>
        @error('descripcion')<span class="text-danger er">{{ $message }}</span> @enderror
    </div>
</div>
@include('common.modalFooter')
