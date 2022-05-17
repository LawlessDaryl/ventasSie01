{{-- Cuando no se encuentren stocks disponibles de cualquier producto al momento 
de realizar una venta de Tienda, Almacen, Depósito, etc dentro de la misma sucursal
 se listaran todas las sucursales y sus locaciones o destinos donde aun queden
 stocks disponibles de dicho producto en este modal  --}}

 <div wire:ignore.self class="modal fade text-center" id="ModalSucursales" tabindex="-1" role="dialog" aria-labelledby="ModalSucursales" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" style="color: aliceblue" id="exampleModalCenterTitle">Aviso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <h4 style="color: rgb(0, 0, 0)" class="modal-heading mb-4 mt-2">¡Stock Insuficiente en la Sucursal!</h4>

                <p style="color: black">
                    No se encontraron stocks disponibles en la tienda y en las distintas locaciones de esta sucursal
                    del producto "{{$nombrestockproducto}}".
                    Pero se encontraron stocks disponibles en las siguientes sucursales:
                </p>


                
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> No</button>
                <button type="button" class="btn btn-primary" wire:click.prevent="almacenToTienda()" >Si</button>
            </div>
        </div>
    </div>
</div>