@section('css')

<style>
    /* Estilos para las tablas */
    .table-wrapper {
    width: 100%;/* Anchura de ejemplo */
    height: 400px; /* Altura de ejemplo */
    overflow: auto;
    }

    .table-wrapper table {
        border-collapse: separate;
        border-spacing: 0;
        border-left: 0.3px solid #d301c1;
        border-bottom: 0.3px solid #d301c1;
        width: 100%;
    }

    .table-wrapper table thead {
        position: -webkit-sticky; /* Safari... */
        position: sticky;
        top: 0;
        left: 0;
    }
    .table-wrapper table thead tr {
    background: #b300ca;
    color: white;
    }
    /* .table-wrapper table tbody tr {
        border-top: 0.3px solid rgb(0, 0, 0);
    } */
    .table-wrapper table tbody tr:hover {
        background-color: #f07bffcc;
    }
    .table-wrapper table td {
        border-top: 0.3px solid #b300ca;
        padding-left: 10px;
        border-right: 0.3px solid #b300ca;
    }

</style>

@endsection


<div>
    <div class="form-group">
        <div class="row">
    
            <div class="col-12 col-sm-12 col-md-4 text-center">
    
            </div>
    
            <div class="col-12 col-sm-12 col-md-4 text-center">
                <h2><b>FREE FIRE - SEGIMIENTO DE VENTAS</b></h2>
                Ordenados por Fecha de Venta
            </div>
    
            <div class="col-12 col-sm-12 col-md-4 text-right">
                    
            
                    
            </div>
    
        </div>
















        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3 text-center">
                    <b wire:click="limpiarsearch()" style="cursor: pointer;">Buscar por Cliente...</b>
                    <div class="form-group">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-gp">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" wire:model="search" placeholder="Ingrese Nombre Cliente..." class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 text-center">
                    <b>Tipo de Pago</b>
                    <div class="form-group">
                        <select wire:model="cartera_id" class="form-control">
                            <option value="Elegir" selected>Elija Cartera</option>
                            @foreach ($carteras as $c)
                                <option value="{{ $c->id }}">{{ ucwords(strtolower($c->nombre)) }}</option>
                            @endforeach
                        </select>
                        @error('catprodservid')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2 text-center">
                    <b>Buscar Cliente</b>
                    <div class="form-group">
                        <button wire:click.prevent="modalbuscarcliente()" type="button" class="btn btn-outline-dark">
                            Buscar Cliente
                        </button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2 text-center">
                    <b>Crear Cliente</b>
                    <div class="form-group">
                        <button wire:click.prevent="modalcrearcliente()" type="button" class="btn btn-outline-dark">
                            Crear Cliente
                        </button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2 text-center">
                    <b>|</b>
                    <div class="form-group">
                        <button wire:click="showmodalnewsale()" type="button" class="btn btn-button" style="background-color: #d301c1; color: white;">Nueva Venta</button>
                    </div>
                </div>


            </div>
        </div>













    </div>
    
    <br>
    
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Telefono/Celular</th>
                    <th scope="col">ID</th>
                    <th scope="col">Alias</th>
                    <th scope="col">Plan</th>
                    <th scope="col">Fecha Venta</th>
                    <th scope="col">Precio Real Bs</th>
                    <th scope="col">Criptomonedas</th>
                    <th scope="col">Obervación</th>
                </tr>
            </thead>
        <tbody>
            @foreach($listsales as $item)
            <tr>
                <th scope="row">1</th>
                <td>{{$item->nameclient}}</td>
                <td>{{$item->phone}}</td>
                <td>{{$item->idaccount}}</td>
                <td>{{$item->alias}}</td>
                <td>{{$item->free_plan_id}}</td>
                <td>{{$item->created_at}}</td>
                <td>? Bs</td>
                <td>5</td>
                <td>{{$item->observation}}</td>
            </tr>
            @endforeach
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>Thornton</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td colspan="2">Larry the Bird</td>
                <td colspan="2">Larry the Bird</td>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
            </tr>
        </tbody>
        </table>
    </div>
    @include('livewire.freesale.modalnewsale')
    @include('livewire.freesale.modalbuscarcliente')
    @include('livewire.freesale.modalcrearcliente')
</div>

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('show-modal-sale', msg => {
            $('#newsale').modal('show')
        });
        // Mètodo JavaScript para llamar al modal para buscar un cliente
        window.livewire.on('show-buscarcliente', Msg => {
            $("#modalbuscarcliente").modal("show");
        });
        // Mètodo JavaScript para llamar al modal para crear un cliente
        window.livewire.on('show-crearcliente', Msg => {
            $("#modalcrearcliente").modal("show");
        });


        //Cerrar Ventana Modal y Mostrar Toast Servicio Entregado Exitosamente
        window.livewire.on('modal-hide-sale', msg => {
        $('#newsale').modal('hide')
        const toast = swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500,
        padding: '2em'
        });
        toast({
            type: 'success',
            title: '¡Venta FreeFire realizado exitosamnete!',
            padding: '2em',
        })
        });

        //Cierra la ventana Modal Buscar Cliente y muestra mensaje Toast cuando se selecciona un Cliente
        window.livewire.on('hide-buscarcliente', msg => {
            $("#modalbuscarcliente").modal("hide");
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: @this.mensaje_toast,
                padding: '2em',
            })
        });

        //Mostrar Mensaje a ocurrido un error en la venta
        window.livewire.on('sale-error', event => {
        swal(
            'A ocurrido un error al realizar la venta FreeFire',
            'Detalle del error'+ @this.mensaje_toast,
            'error'
            )
        });

        //Cierra la ventana Modal Crear Cliente y muestra mensaje Toast de ese Cliente
        window.livewire.on('hide-crearcliente', msg => {
            $("#modalcrearcliente").modal("hide");
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: @this.mensaje_toast,
                padding: '2em',
            })
        });


    });







    function Confirm(id,nombre) {
     
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar la unidad ' + '"' + nombre + '"',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }

</script>
<!-- Scripts para el mensaje de confirmacion arriba a la derecha Categoría Creada con Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->
@endsection