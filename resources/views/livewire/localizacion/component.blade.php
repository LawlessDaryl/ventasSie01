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
           
                    <a href="javascript:void(0)" class="btn btn-dark m-1" data-toggle="modal"
                        data-target="#asignar_mobiliario">Asignar Mobiliario</a>
                </ul>


            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">TIPO</th>
                                <th class="table-th text-withe text-center">CODIGO</th>
                                <th class="table-th text-withe text-center">DESCRIPCION</th>
                                <th class="table-th text-withe text-center">UBICACION</th>
                                <th class="table-th text-withe text-center">SUCURSAL</th>
                                
                                <th class="table-th text-withe text-center">ACCIONES</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_locations as $location)
                            <tr>
                                    <td>
                                        <h6>{{ ($data_locations->currentpage()-1) * $data_locations->perpage() + $loop->index + 1 }}</h6>
                                    </td>
                                    <td>
                                        <h6 class=" text-center">{{ $location->tipo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $location->codigo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $location->descripcion }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $location->destino }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $location->sucursal}}</h6>
                                    </td>
                                    
            

                                
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $location->id }})"
                                            class="btn btn-dark p-1 m-0" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="Confirm('{{ $location->id }}','{{ $location->descripcion }}')"
                                            class="btn btn-dark p-1 m-0" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="javascript:void(0)" wire:click="ver({{$location->id}})" 
                                            class="btn btn-dark p-1 m-0" title="Ver">
                                            <i class="fas fa-list"></i>
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
