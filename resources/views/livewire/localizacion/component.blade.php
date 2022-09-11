@section('css')
<style>
    .tablainventarios {
        width: 100%;
    
        min-height: 140px;
    }
    .tablainventarios thead {
        background-color: #1572e8;
        color: white;
    }
    .tablainventarios th, td {
        border: 0.5px solid #1571e894;
        padding: 4px;
    }

    .tablainventarios th{
        text-align: center;
    }
    tr:hover {
        background-color: rgba(99, 216, 252, 0.336);
    }
        

</style>
@endsection
    




<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="row justify-content-end">
                    <a href="javascript:void(0)" class="btn btn-warning m-1" data-toggle="modal" wire:click="$set('selected_id', 0)"
                        data-target="#theModal">Agregar</a>
           
                </ul>


            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="tablainventarios">
                        <thead>
                            <tr>
                                
                                <th>#</th>
                                <th>TIPO</th>
                                <th>CODIGO</th>
                                <th>DESCRIPCION</th>
                                <th>UBICACION</th>
                                <th>PRODUCTOS</th>
                                
                                <th>ACCIONES</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_locations as $location)
                            <tr>
                                    <td>
                                        <h6>{{ ($data_locations->currentpage()-1) * $data_locations->perpage() + $loop->index + 1 }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $location->tipo }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $location->codigo }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $location->descripcion }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $location->destino }}
                                        <br>
                                        {{ $location->sucursal}}</h6>
                                    </td>
                                    <td>
                                        <center>
                                            <a href="javascript:void(0)" wire:click="ver({{$location->id}})"
                                            class="btn btn-info m-1 text-dark p-1" title="Ver subcategorias"> <b class="pl-1">{{ $location->product->count()}}</b> 
                                            <i class="fas fa-eye"></i>
                                            </a>
                                        </center>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $location->id }})"
                                            class="btn btn-dark p-1 m-0" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <a href="javascript:void(0)" data-toggle="modal"
                                        data-target="#asignar_mobiliario" wire:click="asignarMobilirio({{$location->id}})" 
                                            class="btn btn-warning p-1 m-0" title="Agregar Productos a este mobiliario">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="Confirm('{{ $location->id }}','{{ $location->descripcion }}')"
                                            class="btn btn-danger p-1 m-0" title="Agregar Mobiliario">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data_locations->links() }}
                </div>
            </div>
        </div>
    </div>
   @include('livewire.localizacion.form')
   </div>
   @include('livewire.localizacion.modal_asignar_mobiliario') 
   @include('livewire.localizacion.verproductos') 
   
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('localizacion-added', msg => {
            $('#theModal').modal('hide'),
            noty(msg)
        });
        window.livewire.on('localizacion-assigned', msg => {
            $('#asignar_mobiliario').modal('hide'),
            noty(msg)
        });
        window.livewire.on('location-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('localizacion-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('modal-locacion', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('verprod', function(e) {
            $('#verproductos').modal('show')
        });
        window.livewire.on('show-modal', msg => {
             $('#asignar_mobiliario').modal('show')
         });
         
    });

    function Confirm(id, descripcion, locations) {
        if (locations > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar el producto, ' + descripcion + ' porque tiene ' +
                    locations + ' ventas relacionadas'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar la locacion ' + '"' + descripcion + '"',
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
