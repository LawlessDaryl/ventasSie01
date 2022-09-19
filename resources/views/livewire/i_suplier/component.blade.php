<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }}</b>
                </h4>
                <ul class="row justify-content-end">
                    
                        <a href="javascript:void(0)" class="btn btn-outline-primary" data-toggle="modal"
                        data-target="#theModal"> <i class="fas fa-plus-circle"></i> Agregar Proveedor</a>
                    
                </ul>
            </div>
            <div class="col-12 col-lg-12 col-md-3">
                <div class="row">
                    <div class="form-group col-lg-10">

                        <div class="row justify-content-between">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-gp">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" wire:model="search" placeholder="Buscar Proveedor por nombre, apellido, direccion" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group col-lg-2">
                        <select wire:model='estados' class="form-control">
                          <option value="null" disabled>Estado</option>
                          <option value="ACTIVO">ACTIVO</option>
                          <option value="INACTIVO">INACTIVO</option>
                        </select>
                      </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-12 col-md-4 d-flex flex-lg-wrap flex-wrap flex-md-wrap flex-xl-wrap justify-content-left">
                    @foreach ($data_proveedor as $data)
                               
                            <div class="card component-card_4" style="width: 18rem; margin:2rem;">
                                
                                    <div>
                                        <div class="card-warning p-1" style="height:2rem">

                                            <h5 class="m-0" style="font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; font-size: 1.1rem" > <b>{{$data->nombre_prov." ".$data->apellido}}</b> </h5>
                                        </div>
                                      <div class="card-body" >

                                          <p class="card-text mb-0"> <strong>Telefono:</strong> {{$data->telefono ? $data->telefono : "No definido" }}</p>
                                          <p class="card-text mb-0"> <strong>Direccion:</strong> {{$data->direccion ? $data->direccion : "No definido" }}</p>
                                          <p class="card-text mb-0"> <strong>NIT:</strong> {{$data->nit ? $data->nit  : "No definido" }}</p>
                                          <p class="card-text mb-0"> <strong>Correo:</strong> {{$data->correo ? $data->correo : "No definido" }}</p>
                                          <p class="card-text mb-0"> <strong>Estado:</strong> 
                                            
                                            @if ($data->status == 'ACTIVO')
                                                
                                            <label class="bg-primary text-white rounded m-1 pl-1 pr-1" >{{$data->status}}  </label> 
                                            @else
                                            <label class="bg-danger text-white rounded m-1 pl-1 pr-1" >{{$data->status}}  </label> 
                                            @endif
                                            
                                        
                                        </p>
                                          <a href="javascript:void(0)" wire:click="Edit({{ $data->id }})"
                                            class="btn btn-dark m-1 p-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $data->id }}','{{ $data->nombre }}',{{$data->compras->count()}})" 
                                            class="btn btn-warning m-1 p-1" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                      </div>
                                    </div>
                                
                            
                                </div>
                            @endforeach
                    </div>
                            
                   
                    {{ $data_proveedor->links() }}
                </div>
            </div>
        </div>
        @include('livewire.i_suplier.form')
    </div>
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

    function Confirm(id,nombre,compras) {
     

        if(compras != 0){
            swal.fire({
                title: 'Error',
                icon: 'warning',
                text: 'El proveedor' + nombre + ' tiene relacion con otros registros del sistema, no puede ser eliminado',
              
                cancelButtonText: 'Cerrar',
                cancelButtonColor: '#383838',
           
         
            })
        }
        else{

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

    }
</script>