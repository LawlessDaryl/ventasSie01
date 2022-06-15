<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    
                        <a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal"
                        data-target="#theModal">Agregar Proveedor</a>
                    
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center">PROVEEDOR</th>                                
                                <th class="table-th text-withe text-center">STATUS</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_proveedor as $data)
                                <tr>
                                    <td>
                                        <h5>Nombre</h5>
                                        <label class="text-center">{{ $data->nombre }}</label>
                                        <h5>Apellido</h5>
                                        <label class="text-center">{{ $data->apellido }}</label>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn-center btn btn-primary">{{ $data->status }}</button>
                                    </td>
                                    
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $data->id }})"
                                            class="btn btn-warning mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $data->id }}','{{ $data->nombre }}')" 
                                            class="btn btn-warning" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data_proveedor->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.i_suplier.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('proveedor-added', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('proveedor-updated', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('proveedor-deleted', msg => {
            ///
        });
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });        
        $('theModal').on('hidden.bs.modal',function(e) {
            $('.er').css('display','none')
        })

    });

    function Confirm(id,nombre) {
     
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar la proveedor ' + '"' + nombre + '"',
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