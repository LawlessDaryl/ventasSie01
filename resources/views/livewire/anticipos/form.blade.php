@Include('common.modalHead')

<div class="row">

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Empledos</label>
            <select wire:model="empleadoid" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($empleados as $a)
                    <option value="{{$a->id}}">{{$a->name}} {{$a->lastname}}</option>
                @endforeach
            </select>
            @error('empleadoid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Adelanto</h6>
            <input type="number" wire:model.lazy="anticipo" class="form-control" placeholder="0.00">
            @error('anticipo')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Motivo</h6>
            <textarea type="text" wire:model.lazy="motivo" class="form-control" placeholder="Ingrese motivo de adelanto"></textarea>
            @error('motivo')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

@include('common.modalFooter')
