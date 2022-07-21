<div wire:ignore.self class="modal fade" id="asignartecnicoresponsable" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <div class="text-center">
            <h5>Asignar Técnico Responsable</h5>
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

            <div class="table-wrapper">
                <table class="table table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nombre Usuario</th>
                            <th class="text-center">Servicios en Proceso</th>
                            <th class="text-center">Servicios Terminados</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->lista_de_usuarios as $lu)
                        <tr>
                            <td class="text-center">
                                
                            </td>
                            <td>
                                {{$lu->nombreusuario}}
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


        </div>
      </div>
    </div>
</div>