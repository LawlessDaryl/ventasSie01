@include('common.modalHead')
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
          
             <label> Nombre </label>
            
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Impresoras">
        </div>
        @error('name')<span class="text-danger er">{{ $message }}</span> @enderror
    </div>


    <div class="col-lg-12">
        <div class="form-group">
            
            <label>Descripcion</label>
          
            
            <input type="text" wire:model.lazy="descripcion" class="form-control" placeholder="ej: breve descripcion">
        </div>
        @error('descripcion')<span class="text-danger er">{{ $message }}</span> @enderror
    </div>
</div>

@include('common.modalFooter')
