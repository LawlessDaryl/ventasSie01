<div class="connect-sorting">
    <div class="connect-sorting-content">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                <div class="row d-block">
                    <div class="float-md-right">
                        {{-- Este Boton llama a un modal ubicado en Pos/component.blade.php --}}
                        <button wire:click.prevent="FinalizarVenta()" class="btn btn-primary mb-4 mr-2 btn-lg">Finalizar Venta</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
