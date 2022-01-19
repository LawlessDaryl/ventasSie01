<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    
                        <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">Agregar</a>
                    
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe">NOMBRE</th>
                                <th class="table-th text-withe text-center">CÉDULA</th>
                                <th class="table-th text-withe text-center">CELULAR</th>
                                <th class="table-th text-withe text-center">EMAIL</th>
                                <th class="table-th text-withe text-center">FECHA NACIM</th>
                                <th class="table-th text-withe text-center">NIT</th>
                                <th class="table-th text-withe text-center">DIRECCIÓN</th>
                                <th class="table-th text-withe text-center">RAZÓN SOCIAL</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $c)
                                <tr>
                                    <td>
                                        <h6>{{ $c->nombre }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $c->cedula }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $c->celular }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $c->email }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $c->fecha_nacim }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $c->nit }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $c->direccion }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $c->razon_social }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $c->id }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $c->id }}')" 
                                        class="btn btn-dark"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.cliente.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayofweek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado",
                    ],
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic",
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },
            }
        })
        
        window.livewire.on('item-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('item-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('item-deleted', Msg => {
            noty(Msg)
        })
        window.livewire.on('item-error', Msg => {
            noty(Msg)
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })
    });

    function Confirm(id) {
        
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el usuario ' + '"' + id + '"',
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

