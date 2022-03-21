<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Procesar Servicio de la Orden Nº {{$numeroOrden }} </b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-lg-12 col-sm-12 col-md-6">
                        <div class="text-center">
                            <label><h5>{{ $categoria }}&nbsp{{ $marca }}&nbsp | {{ $detalle1 }}&nbsp | {{ $falla_segun_cliente }}</h5></label><br/><br/>
                            <label><h5><b>CLIENTE: {{ $nombreCliente }}</b></h5></label><br/>
                            <label><h6>Teléfono: {{ $celular }}</h6></label>
                        
                        </div>
                    </div>
                    @can('Asignar_Tecnico_Servicio')
                    <div class="col-lg-4 col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Responsable:</label>
                            <select wire:model.lazy="users1" class="form-control">
                               
                                @foreach ($users as $usuario)
                                
                                    <option value="{{ $usuario->id }}" >{{ $usuario->name }}</option>
                                @endforeach

                            </select>
                            @error('users1') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                <a type="button" href="{{ url('abrirnuevo' . '/' . 'PROCESO') }}"
                 {{-- target="_blank" --}} 
                    wire:click="Cambio({{$service1}})" 
                    class="btn btn-dark close-btn text-info">REGISTRAR PROCESO</a>


            </div>
        </div>
    </div>
</div>