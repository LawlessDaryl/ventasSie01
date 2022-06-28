<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal"
                        data-target="#theModal">Agregar</a>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe">PLATAFORMA</th>
                                <th class="table-th text-withe text-center">CORREO</th>
                                <th class="table-th text-withe text-center">CONTRASEÑA</th>
                                <th class="table-th text-withe text-center">PIN</th>
                                <th class="table-th text-withe text-center">ESTADO</th>
                                <th class="table-th text-withe text-center">EXPIRA</th>
                                <th class="table-th text-withe text-center">FIN PLAN</th>
                                <th class="table-th text-withe text-center">DISPONIB</th>
                                <th class="table-th text-withe text-center">OBSERV</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($profiles as $p)
                                <tr>
                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/plataformas/' . $p->image) }}"
                                                alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                        </span>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $p->correo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $p->pass }}</h6>
                                    </td>
                                    <td>
                                        <h6 class=" text-center">{{ $p->pin }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $p->status }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $p->exp }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $p->expp }}</h6>
                                    </td>                                    
                                    <td>
                                        <h6 class="text-center">{{ $p->av }}</h6>
                                    </td>                                    
                                    <td>
                                        <h6 class="text-center">{{ $p->obs }}</h6>
                                    </td>                                    
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $p->id }})"
                                            class="btn btn-warning mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="Confirm('{{ $p->id }}','{{ $p->correo }}')"
                                            class="btn btn-warning" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $profiles->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.perfiles.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide'),
            noty(msg)
        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('item-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('hidden.bs.modal', function(e) {
            $('.er').css('display', 'none')
        });

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
    });

    function Confirm(id, name) {
        /* if (cuentas > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar la cuenta, ' + name + ' porque tiene ' +
                    cuentas + ' perfiles relacionadas'
            })
            return;
        } */
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el perfil ' + '"' + name + '"',
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
