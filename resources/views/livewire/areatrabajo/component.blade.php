<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal"
                    data-target="#theModal">Agregar</a>
                </ul>
            </div>

            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-bordered-bd-warning striped mt-1" >
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                               <th class="table-th text-white">NOMBRE</th>
                               <th class="table-th text-white text-center">DESCRIPCION</th>
                               <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($areas as $area)
                            <tr>
                                <td><h6>{{$area->name}}</h6></td>
                                <td><h6 class="text-center">{{$area->description}}</h6></td>

                                <td class="text-center">
                                    <a href="javascript:void(0)"
                                        wire:click="Edit({{$area->idarea}})"
                                        class="btn btn-dark" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <a onclick="Confirmar1({{$area->idarea}},'{{$area->verificar}}')" 
                                        class="btn btn-dark" title="Destroy">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$areas->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.areatrabajo.form')
</div>

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('show-modal', msg=>{
            $('#theModal').modal('show')
        });

        window.livewire.on('area-added', msg=>{
            $('#theModal').modal('hide')
        });

        window.livewire.on('area-updated', msg=>{
            $('#theModal').modal('hide')
        });
    });

    function Confirmar1(id, verificar)
    {
        if(verificar == 'no')
        {
            swal('no es posible eliminar porque tiene datos relacionados')
            return;
        }
        else
        {
            swal({
                title: 'CONFIRMAR',
                text: '¿CONFIRMAS ELIMINAR  EL REGISTRO',
                type: 'WARNING',
                showCancelButton: true,
                cancelButtonText: 'cerrar',
                cancelButtonColor: '#fff',
                confirmButtonColor: '#3b3f5c',
                confirmButtonText: 'Aceptar'
            }).then(function(result){
                if(result.value){
                    window.livewire.emit('deleteRow',id)
                    swal.close()
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