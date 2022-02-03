<div wire:ignore.self class="modal fade" id="theType" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background: #b3a8a8">
          <h5 class="modal-title text-white">
              <b>Cambiar</b> | Tipo de Servicio
          </h5>
          <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
        </div>
        <div class="modal-body" style="background: #f0ecec">


<div class="row">
    
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Tipo de Servicio</label>
            <select wire:model.lazy="type_service" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="NORMAL">NORMAL</option>
                <option value="DOMICILIO">A DOMICILIO</option>
            </select>
            @error('type_service') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
        
    
</div>
@include('common.modalFooter')
