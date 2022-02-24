<div wire:ignore.self class="modal fade" id="theOptions" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #b3a8a8">
                <h5 class="modal-title text-white">
                    <b>Información del Servicio</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body" style="background: #f0ecec">

                <div class="row">
                    <div class="col-lg-4 col-sm-12 col-md-6">
                        <div class="form-group">
                            <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                            data-dismiss="modal" style="background: #3b3f5c">Imprimir</button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-md-6">
                        <div class="form-group">
                            <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                            data-dismiss="modal" style="background: #3b3f5c">Anular</button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-md-6">
                        <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                        data-dismiss="modal" style="background: #3b3f5c">ATRÁS</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #f0ecec">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">ATRÁS</button>
            </div>
        </div>
    </div>
</div>