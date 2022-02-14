<div wire:ignore.self class="modal fade" id="theMod" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #b3a8a8">
                <h5 class="modal-title text-white">
                    <b>Procesar Servicio de la Orden Nº {{$service->order_service_id  }} </b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body" style="background: #f0ecec">

                <div class="row">

                    <div class="col-lg-12 col-sm-12 col-md-6">
                        <div class="text-center">
                            <label><h5>{{ $service->categoria->nombre }}&nbsp{{ $service->marca }}&nbsp | {{ $service->detalle }}&nbsp | {{ $service->falla_segun_cliente }}</h5></label><br/><br/>
                            <label><h5><b>CLIENTE: {{ $service->movservices[0]->movs->climov->client->nombre }}</b></h5></label><br/>
                            <label><h6>Teléfono: {{ $service->movservices[0]->movs->climov->client->celular }}</h6></label>
                        
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Responsable:</label>
                            <select wire:model.lazy="users1" class="form-control">
                               
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @if($service->movservices[0]->movs->user_id==$user->id )selected @endif>{{ $user->name }}</option>
                                @endforeach

                            </select>
                            @error('users1') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #f0ecec">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                <button type="button" wire:click.prevent="Cambio({{$service->id}})" 
                    class="btn btn-dark close-btn text-info">REGISTRAR PROCESO</button>


            </div>
        </div>
    </div>
</div>