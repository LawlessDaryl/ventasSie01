@include('common.modalHead')
<div class="row">

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Aparador</label>
            <select wire:model='aparador' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
               
                    <option value="VITRINA">Vitrina</option>
                    <option value="MOSTRADOR">Mostrador</option>
                    <option value="ESTANTE">Estante</option>
                    <option value="OTRO">Otro</option>
                
            </select>
            @error('aparador') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Código</label>
            <input type="text" wire:model.lazy="codigo" class="form-control" placeholder="ej: 012020222">
            @error('barcode') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Descripcion</label>
            <input type="text" wire:model.lazy="descripcion" class="form-control" placeholder="ej: Vitrina nueva de 3 niveles">
            @error('cost') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Ubicacion</label>
            <select  wire:model='ubicacion' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
               
                    <option value=1>TIENDA</option>
                    <option value=2>ALMACEN</option>
                
            </select>
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Sucursal</label>
            <select wire:model='sucursal' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($data_suc as $data)
                
                    <option value="{{$data->id}}">{{ $data->name }}</option>
                @endforeach
              
            </select>
        </div>
    </div>
  
    
   
  



    @include('common.modalFooter')
