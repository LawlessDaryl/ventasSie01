<div wire:ignore.self class="modal fade" id="serviciodetalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <div class="text-center">
            <h5>Información del Servicio</h5>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="col-12 col-sm-4 col-md-1 text-center">
              
            </div>

            <div class="col-12 col-sm-4 col-md-10 text-center">
              @if($this->estado=="PENDIENTE")
                <div style="background-color: rgb(80, 5, 110); color:aliceblue">
                  <h2>SERVICIO {{$this->estado}}</h2>
                </div>
              @else
                  @if($this->estado=="PROCESO")
                    <div style="background-color: rgb(100, 100, 100); color:aliceblue">
                      <h2>SERVICIO EN {{$this->estado}}</h2>
                    </div>
                  @else
                      @if($this->estado=="TERMINADO")
                        <div style="background-color: rgb(224, 146, 0); color:aliceblue">
                          <h2>SERVICIO {{$this->estado}}</h2>
                        </div>
                      @else
                          @if($this->estado=="ENTREGADO")
                            <div style="background-color: rgb(22, 192, 0); color:aliceblue">
                              <h2>SERVICIO {{$this->estado}}</h2>
                            </div>
                          @else
                              @if($this->estado=="ABANDONADO")
                                <div style="background-color: rgb(186, 238, 0); color:aliceblue">
                                  <h2>SERVICIO {{$this->estado}}</h2>
                                </div>
                              @else
                                  @if($this->estado=="ANULADO")
                                    <div style="background-color: rgb(0, 0, 0); color:aliceblue">
                                      <h2>SERVICIO {{$this->estado}}</h2>
                                    </div>
                                  @else
                                      {{$this->estado}}
                                  @endif
                              @endif
                          @endif
                      @endif
                  @endif
              @endif
            </div>

            <div class="col-12 col-sm-4 col-md-1 text-center">
            </div>




            <div class="col-12 col-sm-4 col-md-1 text-center">
              
            </div>

            <div class="col-12 col-sm-4 col-md-10 text-center" style="color: #000000">
              <b>Responsable Técnico:</b>
              <span class="stamp stamp" style="background-color: rgb(0, 55, 175);">
                No Asignado
              </span>
            </div>

            <div class="col-12 col-sm-4 col-md-1 text-center">
            </div>






            <div class="col-12 col-sm-4 col-md-6 text-center">
              <b>Cliente:</b>
            </div>

            <div class="col-12 col-sm-4 col-md-6 text-center" style="color: #000000">
              <b>Celular:</b>
            </div>








          </div>
          <div class="form-row">
            <div class="col-12 col-sm-4 col-md-10" style="color: #000000">
              <i class="fas fa-calendar-alt"></i>
              Fecha Estimada de Entrega:
              <br>
              <span class="stamp stamp text-center" style="background-color: aliceblue; color: black;">
                12/12/1997
              </span>
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Total Bs:</label>
              12/12/1997
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Tipo de Trabajo:</label>
              12/12/1997
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Detalle:</label>
              12/12/1997
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Detalle:</label>
              12/12/1997
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Password</label>
              12/12/1997
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Diagnóstico:</label>
              12/12/1997
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Password</label>
              12/12/1997
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Solución:</label>
              12/12/1997
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Password</label>
              12/12/1997
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail4">Detalle Costo:</label>
              12/12/1997
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Password</label>
              12/12/1997
            </div>
          </div>





          {{-- <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputCity">City</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-4">
              <label for="inputState">State</label>
              <select id="inputState" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="inputZip">Zip</label>
              <input type="text" class="form-control" id="inputZip">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Sign in</button> --}}
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
      </div>
    </div>
  </div>