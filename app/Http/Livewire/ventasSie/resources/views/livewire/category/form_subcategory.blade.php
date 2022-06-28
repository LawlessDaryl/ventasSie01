<div wire:ignore.self class="modal fade" id="theModal_s" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title text-white">
         
              <b>{{$componentSub}}</b> | {{$selected_id > 0 ? 'EDITAR':'CREAR'}}
          </h5>
          <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
        </div>
        <div class="modal-body">

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            
             <label> Nombre </label>
            
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Impresoras">
        </div>
        @error('name')<span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    
</div>
<div class="row">

  


<div class="col-lg-12">
    <div class="form-group">
        <label>Categoría</label>
        <select wire:model='categoria_padre' class="form-control">
            <option value=null>Elegir</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('categoryid') <span class="text-danger er">{{ $message }}</span>@enderror
    </div>
</div>
<div class="col-lg-12">
    <div class="form-group">
      
           
                <label>Descripcion</label>
            
        
        <input type="text" wire:model.lazy="descripcion" class="form-control" placeholder="ej: breve descripcion de la categoria">
    </div>
    @error('descripcion')<span class="text-danger er">{{ $message }}</span> @enderror
</div>
</div>

@include('common.modalFooter')
