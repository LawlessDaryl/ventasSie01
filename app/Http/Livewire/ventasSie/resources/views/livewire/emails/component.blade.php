<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                   
                    <a href="javascript:void(0)" class="btn btn-dark" wire:click="Agregar()">Agregar</a>
                    
                </ul>
            </div>

            
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="table-th text-withe">CORREO</th>
                                <th class="table-th text-withe">CONTRASEÑA</th>
                                <th class="table-th text-withe text-center">DISPONIBILIDAD</th>
                                <th class="table-th text-withe text-center">ESTADO</th>
                                <th class="table-th text-withe text-center">OBSERVACIONES</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emails as $e)
                                <tr>
                                    <td>
                                        <h6>{{ $e->content }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $e->pass }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <span
                                            class="badge {{ $e->availability == 'LIBRE' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $e->availability }}</span>
                                    </td>

                                    <td class="text-center">
                                        <span
                                            class="badge {{ $e->status == 'ACTIVO' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $e->status }}</span>
                                    </td>

                                    <td class="text-center">
                                        <h6>{{ $e->observations }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $e->id }})"
                                            class="btn btn-warning mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $e->id }}','{{ $e->content }}')" class="btn btn-warning"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $emails->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('livewire.emails.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('item-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        });
        window.livewire.on('item-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        });
        window.livewire.on('item-deleted', Msg => {
            noty(Msg)
        });
        window.livewire.on('email-generated', Msg => {
            noty(Msg)
        });
        window.livewire.on('pass-generated', Msg => {
            noty(Msg)
        });
        window.livewire.on('email-copied', Msg => {
            noty(Msg)
        });
        window.livewire.on('pass-copied', Msg => {
            noty(Msg)
        });

    });

    function Confirm(id, name, cuentas) {
        if (cuentas > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar el correo, ' + name + ' porque tiene ' 
                + cuentas + ' cuentas relacionadas'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el correo ' + '"' + name + '"',
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
     
    function copia() {
        let texto = document.getElementById('c');
        texto.select();
        texto.setSelectionRange(0, 99999);
        document.execCommand('copy');
        window.livewire.emit('email-copied', 'Email copiado en el portapapeles')
    }

    function copiap() {
        let texto = document.getElementById('p');
        texto.select();
        texto.setSelectionRange(0, 99999);
        document.execCommand('copy');
        window.livewire.emit('pass-copied', 'Contraseña copiada en el portapapeles')
    }


</script>

