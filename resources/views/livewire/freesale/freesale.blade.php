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
                    
            <button wire:click="showmodalnewsale()" type="button" class="btn btn-button" style="background-color: rgb(122, 5, 87); color: white;">Nueva Venta</button>
    
                    
            </div>
    
        </div>
    </div>
    
    <br>
    
    <div>
        <table class="table table-bordered table-hover">
        <thead style="background-color: rgb(122, 5, 87); color: white;">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Telefono/Celular</th>
            <th scope="col">Alias</th>
            <th scope="col">Plan</th>
            <th scope="col">Fecha Venta</th>
            <th scope="col">Precio Real Bs</th>
            <th scope="col">Criptomonedas</th>
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
                <td>{{$item->observation}}</td>
                <td>{{$item->free_plans_id}}</td>
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
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('show-modal-sale', msg => {
            $('#newsale').modal('show')
        });
        window.livewire.on('modal-hide-sale', msg => {
            $('#newsale').modal('hide')
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
