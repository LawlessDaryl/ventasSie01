<div wire:ignore.self class="modal fade" id="ModalAnular" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>ANULAR ORDEN Nº: {{$orderservice }} </b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-lg-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Al ANULAR este servicio, se anularán todos sus detalles (incluidos Total, A Cuenta y Saldo serán CERO)</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="Anular({{$orderservice}})" class="btn btn-warning close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">SI</button>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">NO</button>
            </div>
        </div>
    </div>
</div>