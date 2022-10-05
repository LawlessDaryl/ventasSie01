<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background: #ee761c">
          <h5 class="modal-title text-white">
              <b>{{$componentName}}</b> 
          </h5>
          <div class="col-sm-12 col-md-6">
        
        
    </div>
          <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
        </div>
        <div class="modal-body">

<div class="row">

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Empleados</label>
            <select wire:model="empleadoid" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                @foreach($employees as $a)
                    <option value="{{$a->id}}">{{$a->name}} {{$a->lastname}}</option>
                @endforeach
            </select>
            @error('empleadoid') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

  

    <div class="col-sm-12 col-md-6">
        
            
            <div class="form-group">
                <label>Fecha de fallo</label>
                <div></div>
                <input type="date" wire:model="fechaf"
                    class="form-control" placeholder="Click para elegir">

                    @error('prueba') <span class="text-danger er"> {{ $message }}</span> @enderror
            </div>
        
    </div>

    <div class="col-sm-12 col-md-6" >
        <div class="form-group">
            <label>Entrada</label>
                <input style="width: 50%" type="time" wire:model.lazy="entradaf" class="form-control">

            @error('entradaf') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>


    <div class="col-sm-12 col-md-6" >
        <div class="form-group">
            <label>Salida</label>
                <input style="width: 50%" type="time" wire:model.lazy="salidaf" class="form-control">

            @error('salidaf') <span class="text-danger er"> {{ $message }}</span> @enderror
        </div>
    </div>

  

</div>

</div>
<div class="modal-footer">
    <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning close-btn text-info"
        data-dismiss="modal" style="background: #ee761c">CANCELAR</button>
        <button type="button" wire:click.prevent="fallo()"
            class="btn btn-warning close-btn text-info">GUARDAR</button>
</div>
</div>

</div>
</div>


