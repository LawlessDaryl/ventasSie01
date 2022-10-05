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
            <h6>DESCUENTO</h6>
            <input type="number" wire:model.lazy="descuentoc" class="form-control">
            {{--<label type="number" wire:model.lazy="nuevoSalario" class="form-control">10</label>--}}
            @error('descuento')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>MOTIVO</h6>
            <textarea type="text" wire:model.lazy="motivo" class="form-control"></textarea>
            @error('motivo')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

@include('common.modalFooter')
