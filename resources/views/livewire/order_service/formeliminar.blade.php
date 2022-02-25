<div wire:ignore.self class="modal fade" id="theDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #b3a8a8">
                <h5 class="modal-title text-white">
                    <b>ELIMINAR ORDEN Nº: {{$numeroOrden }} </b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body" style="background: #f0ecec">

                <div class="row">

                    <div class="col-lg-12 col-sm-12 col-md-6">
                        <div class="text-center">
                            <label><h5>{{ $categoria }}&nbsp{{ $marca }}&nbsp | {{ $detalle1 }}&nbsp | {{ $falla_segun_cliente }}</h5></label><br/><br/>
                            <label><h5><b>CLIENTE: {{ $nombreCliente }}</b></h5></label><br/>
                            <label><h6>Teléfono: {{ $celular }}</h6></label>
                        
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Al ELIMINAR este servicio, se perderá toda la información de este servicio</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #f0ecec">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">SI</button>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">NO</button>
            </div>
        </div>
    </div>
</div>