<div class="float-md-right">
    {{-- Este Boton llama a un modal ubicado en Pos/component.blade.php --}}


    @if(session('sesionidventa') > 0)
    <button wire:click.prevent="cancelaractualizarventa()" class="btn btn-lg" style="background-color: rgb(51, 10, 161); color:aliceblue;">Cancelar Editar Venta</button>
    <button wire:click.prevent="actualizarventa()" class="btn btn-lg" style="background-color: chartreuse">Aplicar Cambios</button>
    @else
    <a href="{{ url('salelist') }}" class="btn btn- mb-4 mr-2 btn-lg" style="background-color: rgb(32, 108, 0); color:white;">
        Ir a lista de Ventas </a>
    <button wire:click.prevent="FinalizarVenta()" class="btn btn-primary mb-4 mr-2 btn-lg">Finalizar Venta</button>
    @endif



</div>
<br>
<br>