<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white">
                    <b style="color:black">Observaciones del Plan # {{ $planId }}</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                @if (!empty($details))
                                    <h6>{{ $details->observations }}</h6>
                                @endif
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark close-btn text-info" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
