<div>
    <div class="row">
        <!-- Datos Cliente -->
        <div class="col-sm-12 col-md-12">
            @include('livewire.pos.partials.client')
        </div>
        <!-- Tabla Productos (Shopping Cart) -->
        <div class="col-sm-12 col-md-8">
            @include('livewire.pos.partials.detail')
        </div>
        <!-- Cuadro Total Bs y Monedas -->
        <div class="col-sm-12 col-md-4">
            @include('livewire.pos.partials.total')
            {{-- denominaciones --}}
            @include('livewire.pos.partials.coins')
        </div>
    </div>

</div>

    @include('livewire.pos.scripts.events')
    @include('livewire.pos.scripts.general')
    @include('livewire.pos.scripts.scan')
    @include('livewire.pos.scripts.shortcuts')
