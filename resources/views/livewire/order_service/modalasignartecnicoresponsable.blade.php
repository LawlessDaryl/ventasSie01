<div wire:ignore.self class="modal fade" id="asignartecnicoresponsable" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <div class="modal-title text-white">
            <h5>Asignar Técnico Responsable - Orden de Servicio N°:{{$this->id_orden_de_servicio}}
            </h5>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
            <div class="row">

                <div class="col-12 col-sm-4 col-md-1 text-center">
              
                </div>
    
                <div class="col-12 col-sm-4 col-md-10 text-center" style="color: black;">
                    <h3>Lista de Usuarios - Servicios</h3>
                </div>
    
                <div class="col-12 col-sm-4 col-md-1 text-center">
                </div>



            </div>


            <div class="text-center">
                {{ ucwords(strtolower($this->categoriaservicio)) }} | {{ucwords(strtolower($this->detalleservicio))}} |
                {{ ucwords(strtolower($this->tipotrabajo))}} | {{ucwords(strtolower($this->fallaseguncliente))}}
            </div>

                <br>

            <div class="table-wrapper">
                <table class="tablaservicios" style="min-width: 400px;">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nombre</th>
                            <th class="text-center">Proceso</th>
                            <th class="text-center">Terminados</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->lista_de_usuarios as $lu)
                        <tr class="tablaserviciostr">
                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <span wire:click.prevente="asignartecnico({{$lu->idusuario}})" title="Elegir Técnico Responsable" class="stamp stamp nombresestilosmodal">
                                    {{$lu->nombreusuario}}
                                </span>
                            </td>
                            <td class="text-center">
                                {{$lu->proceso}}
                            </td>
                            <td class="text-center">
                                {{$lu->terminado}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <br>


        </div>
      </div>
    </div>
</div>