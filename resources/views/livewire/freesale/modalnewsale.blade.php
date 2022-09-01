<div wire:ignore.self class="modal fade" id="newsale" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Nueva Venta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-row">
                  <div class="col">
                    <h5><b>Nombre</b></h5>
                    <h3>{{$nombrecliente}}</h3>
                    {{-- <input wire:model="nameclient" type="text" class="form-control" placeholder="Nombre Cliente"> --}}
                  </div>
                  <div class="col">
                    <h5><b>Telefono</b></h5>
                    <h3>{{$celularcliente}}</h3>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col">
                    <h5><b>ID</b></h5>
                    @error('idgame')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                    <input wire:model="idgame" type="text" class="form-control" placeholder="Id">
                  </div>
                  
                  <div class="col">
                    <h5><b>Alias</b></h5>
                    @error('alias')
                    <span class="text-danger er">{{ $message }}</span>
                    @enderror
                    <input wire:model="alias" type="text" class="form-control" placeholder="Alias">
                  </div>
                  
                </div>
                <br>
                <div class="form-row">
                  <div class="col">
                    <h5><b>Plan</b></h5>
                    @error('freeplan_id')
                    <span class="text-danger er">{{ $message }}</span>
                    @enderror
                    <select wire:model="freeplan_id" class="form-control">
                      <option value="elegir">Elegir Plan</option>
                        @foreach($listplans as $a)
                        <option value="{{$a->id}}">{{$a->nameplan}} - {{$a->cryptocurrencies}} - {{$a->cost}} Bs</option>
                        @endforeach
                    </select>
                  </div>
                  {{-- <div class="col">
                    <h5><b>Criptomonedas</b></h5>
                    <input wire:model="cryptocurrencies" type="text" class="form-control" placeholder="Criptomonedas...">
                  </div> --}}
                </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar todo</button>
          @if($cliente_id)
            <button wire:click.prevent="savesale()" type="button" class="btn btn-primary">Guardar Venta</button>

          @else
          <div style="border: 5px;">
            Debe seleccionar o crear un Cliente
          </div>

          @endif
        </div>
      </div>
    </div>
  </div>