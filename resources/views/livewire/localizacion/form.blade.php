@include('common.modalHead')
<div class="row">

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Aparador</label>
            <select wire:model='tipo' class="form-control">
                <option value="Elegir">Elegir</option>
                    <option value="VITRINA">Vitrina</option>
                    <option value="MOSTRADOR">Mostrador</option>
                    <option value="ESTANTE">Estante</option>
                    <option value="OTRO">Otro</option>
            </select>
            @error('tipo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Código</label>
            <input type="text" wire:model.lazy="codigo" class="form-control" placeholder="ej: 012020222">
            @error('codigo') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Descripcion</label>
            <input type="text" wire:model.lazy="descripcion" class="form-control" placeholder="ej: Vitrina nueva de 3 niveles">
            @error('descripcion') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
    
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Sucursal</label>
            <select wire:model='destino' class="form-control">
                <option value="Elegir">Elegir</option>
                @foreach ($data_suc as $data)
                
                    <option value="{{$data->id}}">{{ $data->destino}}-{{$data->sucursal}}</option>
                @endforeach
              
            </select>
            @error('destino') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>
  
    
   
  



    @include('common.modalFooter')
