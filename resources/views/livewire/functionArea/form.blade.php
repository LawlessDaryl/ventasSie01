@Include('common.modalHead')

<div class="row">

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Nombre</h6>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ingrese nombre de funcion">
            @error('name')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{--<div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Areas</label>
            <select wire:model="areaid" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach($area_trabajos as $area)
                <option value="{{$area->id}}">{{$area->name}}</option>
                @endforeach
            </select>
            @error('areaid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>--}}

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Areas</label>
            <br>
            <div class="btn-group">
                <select wire:model="areaid" class="form-control col-md-12">
                    <option value="Elegir" disabled>Elegir</option>
                    @foreach($area_trabajos as $area)
                        <option value="{{$area->id}}">{{$area->nameArea}}</option>
                    @endforeach
                </select>
                <a type="button" wire:click="NuevArea()" class="btn btn-warning close-btn text-info">Nuevo</a>
            </div>
        </div>
        @error('areaid') <span class="text-danger er"> {{ $message }}</span> @enderror
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <h6>Descripcion</h6>
            <input type="text" wire:model.lazy="description" class="form-control" placeholder="Ingrese descripcion de funcion">
            @error('description')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

@include('common.modalFooter')
