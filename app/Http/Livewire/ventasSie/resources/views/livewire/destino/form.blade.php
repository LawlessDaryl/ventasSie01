@include('common.modalHead')
<div class="row">
    <div class="col-lg-12 col-md-6">
        <div class="form-group">
            <label>Estancia</label>
            <input type="text" wire:model.lazy="nombre" class="form-control" placeholder="Nombre de la estancia deposito, tienda, almacen, bodega"
            maxlenght="25">
            @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Sucursal</label>
            <select wire:model='sucursal' class="form-control">
                <option value="Elegir">Elegir</option>
                @foreach ($data_suc as $data)
                
                    <option value="{{$data->id}}">{{$data->name}}</option>
                @endforeach
              
            </select>
        </div>
        <div class="form-group">
            <label>Observacion</label>
            <input type="text" wire:model.lazy="observacion" class="form-control" placeholder="Describa alguna observacion"
            maxlenght="25">
            @error('name') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
</div>
@include('common.modalFooter')