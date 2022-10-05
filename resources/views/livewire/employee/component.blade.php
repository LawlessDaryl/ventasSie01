<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" wire:click="NuevoEmpleado()">Agregar</a>
                </ul>

               {{-- <h6>{{ date('Y-m-d H:i:s') }}</h6>   muestra hora de sistema--}}
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="table-th text-withe">NOMBRE</th>
                                <th class="table-th text-withe text-center">APELLIDOS</th>
                                <th class="table-th text-withe text-center">CI</th>
                                <th class="table-th text-withe text-center">TELEFONO</th>
                                <th class="table-th text-withe text-center">FECHA DE INGRESO</th>
                                <th class="table-th text-withe text-center">TIEMPO TRANCURRIDO</th>
                                <th class="table-th text-withe text-center">AREA</th>
                                <th class="table-th text-withe text-center">CARGO</th>
                                <th class="table-th text-withe text-center">CONTRATO</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $employee)
                                <tr>
                                    <td><h6 class="text-center">{{ $employee->name }}</h6></td>
                                    <td><h6 class="text-center">{{ $employee->lastname }}</h6></td>
                                    <td><h6 class="text-center">{{ $employee->ci }}</h6></td>
                                    {{--<td class="text-center">
                                        <span class="badge {{$employee->genero == 'Masculino' ? 'badge-success' : 'badge-danger'}}
                                            text-uppercase" style="background-color: #fff; color: black">
                                            {{$employee->genero}}
                                        </span>
                                    </td>--}}
                                    <td><h6 class="text-center">{{ $employee->phone }}</h6></td>
                                    <td><h6 class="text-center">{{ \Carbon\Carbon::parse($employee->fechaInicio)->format('Y-m-d') }}</h6></td>

                                    <td>
                                        <h6 class="text-center">
                                            @if($employee->year != 0)
                                                {{$employee->year}} años
                                            @endif
                                            @if($employee->mouth != 0)
                                                {{$employee->mouth}} meses
                                            @endif
                                            @if($employee->day != 0)
                                                {{$employee->day}} dias
                                            @endif
                                        </h6>
                                    </td>

                                    <td><h6 class="text-center">{{ $employee->area }}</h6></td>
                                    <td><h6 class="text-center">{{ $employee->cargo}}</h6></td>
                                    <td><h6 class="text-center">{{ $employee->contrato}}</h6></td>

                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/employees/' .$employee->image)}}"
                                             alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $employee->idEmpleado }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <a href="javascript:void(0)"
                                            onclick="Confirm({{$employee->idEmpleado}},'{{$employee->verificar}}')"
                                            class="btn btn-dark" title="Destroy">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                        <a href="javascript:void(0)"
                                            wire:click="DetalleEmpleado({{$employee->idEmpleado}})"
                                            class="btn btn-dark" title="DetalleEmpleado">
                                            <i class="fas fa-list"></i>
                                        </a>

                                        {{--<a class="btn btn-dark mtmobile" wire:click="DetalleEmpleado()">
                                            <i class="fas fa-list"></i>
                                        </a>--}}
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
    @include('livewire.employee.form')
    @include('livewire.employee.nuevoContrato')
    @include('livewire.employee.detalleEmpleado')
</div>

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('employee-added', msg => {
            $('#theModal').modal('hide')
        });

        window.livewire.on('employee-updated', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('employee-deleted', msg => {
            ///
        });
        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('show')
        });
        // formulario de Nuevo contrato
        window.livewire.on('show-modal-contrato', Msg => {
            $('#theModal-contrato').modal('show')
        })
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('modal-hide-contrato', Msg => {
            $('#theModal-contrato').modal('hide')
        }) 
        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display','none')
        });
        // ver detalle de empleados
        window.livewire.on('show-modal-detalleE', Msg => {
            $('#modal-details').modal('show')
        })
    });

    function Confirm(id, verificar) {
        if(verificar == 'no')
        {
            swal('no es posible eliminar porque tiene datos relacionados')
            return;
        }else
        {
            Swal.fire({
            title: 'CONFIRMAR',
            text: "Confirmar eliminar el empleado",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.value) {
                    window.livewire.emit('deleteRow', id)
                    Swal.close()
                }
            })
        }
    }
</script>
<!-- Scripts para el mensaje de confirmacion arriba a la derecha Categoría Creada con Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->
@endsection