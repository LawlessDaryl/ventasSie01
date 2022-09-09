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
                    
                        <a href="javascript:void(0)" class="btn btn-outline-primary" data-toggle="modal"
                        data-target="#theModal"> <i class="fas fa-plus-circle"></i> Agregar Estancia</a>
                    
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="tablainventarios">
                        <thead>
                            <tr>
                                <th class="table-th text-withe text-center">ITEM</th>
                                <th class="table-th text-withe text-center">NOMBRE</th>                                
                                <th class="table-th text-withe text-center">OBSERVACION</th>
                                <th class="table-th text-withe text-center">SUCURSAL</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>
                                        <center><h6>{{$loop->index+1}}</h6></center>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $data->nombre }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $data->observacion }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $data->name }}</h6>
                                    </td>
                                    
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $data->id }})"
                                            class="btn btn-dark p-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $data->id }}','{{ $data->nombre }}')" 
                                            class="btn btn-danger p-1" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $datas->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.destino.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('unidad-added', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('unidad-updated', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('unidad-deleted', msg => {
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