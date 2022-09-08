<div wire:ignore.self class="modal fade" id="serviciodetalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-center">
          <div class="modal-title text-white">
            <h5>Información del Servicio - Orden de Servicio N°:{{$this->id_orden_de_servicio}}</h5>
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
                <div style="background-color: rgb(161, 0, 224); color:aliceblue">
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
                {{$this->responsabletecnico}}
              </span>
            </div>

            <div class="col-12 col-sm-4 col-md-1 text-center">
            </div>











            <div class="col-12 col-sm-4 col-md-1 text-center">
              
            </div>

            <div class="col-12 col-sm-4 col-md-10 text-center" style="color: #000000">
              <span class="stamp stamp" style="background-color: rgb(0, 158, 97);">
                {{ ucwords(strtolower($this->categoriaservicio)) }} - {{ ucwords(strtolower($this->tipotrabajo))}}
              </span>
            </div>

            <div class="col-12 col-sm-4 col-md-1 text-center">
            </div>







            

            <div class="col-12 col-sm-4 col-md-6 text-center" style="color: #000000">
              <h3><b>Cliente:</b> {{ucwords(strtolower($this->nombrecliente))}}</h3>
            </div>

            <div class="col-12 col-sm-4 col-md-6 text-center">
              <h3>
                <b>Celular:</b> <a style="color: #0080a7" href="https://wa.me/{{$this->celularcliente}}" target="_blank">{{$this->celularcliente}}</a>
                <i style="color: #0080a7" class="fab fa-whatsapp"></i>
              </h3>
            </div>



          </div>


          <div class="form-row">
            <div class="col-md-6">
              <b>
                Fecha Estimada de Entrega:
              </b>
              {{ \Carbon\Carbon::parse($this->fechaestimadaentrega)->format('d/m/Y h:i a') }}
            </div>
            <div class="col-md-6">
              <b>
                Precio Servicio Bs:
              </b>
              {{$this->precioservicio}}
            </div>
            <div class="col-md-6">
              <b>
                Detalle Producto:
              </b>
              {{$this->detalleservicio}}
            </div>
            <div class="col-md-6">
              <b>
                A Cuenta Bs:
              </b>
              {{$this->acuenta}}
            </div>
            <div class="col-md-6">
              <b>
                Costo Servicio Bs:
              </b>
              {{$this->costo}}
            </div>
            <div class="col-md-6">
              <b>
                Saldo Bs:
              </b>
              {{$this->saldo}}
            </div>
            <div class="col-md-6">
              <b>
                Detalle Costo:
              </b>
              {{$this->detallecosto}}
            </div>

            <div class="col-md-6">
              <b>Tipo de Servicio:</b>
              {{$this->tiposervicio}}
            </div>



          </div>


        </div>
        
        <div class="row text-center">
          <div class="col-12 col-sm-4 col-md-12 text-center">
            <b>Falla Según Cliente:</b>
            <br>

            <div class="detallesservicios">
              {{$this->fallaseguncliente}}
            </div>
            
            <br>
          </div>
          <div class="col-12 col-sm-4 col-md-12 text-center">
            <b>Diagnóstico</b>
            <br>
            <div class="detallesservicios">
              {{$this->diagnostico}}
            </div>
            <br>
          </div>
          <div class="col-12 col-sm-4 col-md-12 text-center">
            <b>Solución:</b>
            <br>
            <div class="detallesservicios">
              {{$this->solucion}}
            </div>
            <br>
          </div>
        </div>


        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
          <button wire:click="informetecnico()" type="button" class="btn btn-primary">CREAR INFORME TÉCNICO</button>
        </div>
      </div>
    </div>
</div>