<div wire:ignore.self class="modal fade" id="theModal_sub" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background: #b3a8a8">
          <h5 class="modal-title text-white">
              <b>{{$componentName}}</b> | {{$selected_id > 0 ? 'EDITAR':'CREAR'}}
          </h5>
          <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
        </div>
        <div class="modal-body" style="background: #f0ecec">

<div class="row">
    <div class="col-lg-8">
        <div class="form-group">
            
             <label> Nombre </label>
            
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Impresoras">
        </div>
        @error('name')<span class="text-danger er">{{ $message }}</span> @enderror
    </div>


    <div class="col-lg-8">
        <div class="form-group">
            
            <label>Descripcion</label>
            
            <input type="text" wire:model.lazy="descripcion" class="form-control" placeholder="ej: breve descripcion">
        </div>
        @error('descripcion')<span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    <div class="col-lg-8">
        <div class="form-group">
            
            <label>Categoria</label>
            
            <select wire:model='subcat1' class="form-control">
                <option value="Elegir">Elegir</option>
                @foreach ($subcat as $data)
                
                    <option value="{{$subcat->id}}">{{ $subcat->name }}</option>
                @endforeach
              
            </select>
    </div>

@include('common.modalFooter')