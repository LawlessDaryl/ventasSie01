<div wire:ignore.self class="modal fade" id="modal-details" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header" style="background: #ee761c">
        <h5 class="modal-title text-white">
            Informacion de Empleado # {{$idEmpleado }}
        </h5>
        <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
      </div>
      
      <div class="row">
          <div class="col-md-12">
            <div class="card card-profile">
              <div class="card-header" style="background: #d9dadf">
                <div class="profile-picture">
                  <div class="avatar">
                    <img src="{{ asset('storage/employees/' .$image)}}"
                     height="90" width="100" class="rounded">
                  </div>
                </div>
              </div>
              
              <div class="card-body">
                <div class="user-profile" style="text-align: center">
                  <br>
                  <div class="name">{{ $name }} {{ $lastname }}</div>
                  <div class="name">{{ $ci }}</div>
                  <div class="name">{{ $genero }}</div>
                  <div class="social-media">
                    Fecha de Nacimiento: {{ $dateNac }}
                  </div>
                  <div class="view-profile">
                    <a href="#" class="btn btn-secondary btn-block">Tiempo Transcurrido: 
                      @if($yearEmployee != 0)
                        {{$this->yearEmployee}} años
                      @endif
                      @if($mouthEmployee != 0)
                        {{$this->mouthEmployee}} meses
                      @endif
                      @if($dayEmployee != 0)
                        {{$this->dayEmployee}} dias 
                      @endif
                      <br>
                       Tiempo Restante: 
                      @if($anioRestante != 0)
                        {{$this->anioRestante}} años
                      @endif
                      @if($mesesRestante != 0)
                       {{$this->mesesRestante}} meses
                      @endif
                      @if($diasRestante != 0)
                        {{$this->diasRestante}} dias
                      @endif
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="row user-stats">
                  <div class="col">
                    <div class="number">Direccion</div>
                    <div class="number">Telefono</div>
                    <div class="number">Estado Civil</div>
                    <div class="number">Area de Trabajo</div>
                    <div class="number">Cargo</div>
                    <div class="number">Fecha de Inicio</div>
                    <div class="number">Fecha de Final</div>
                    <div class="number">Salario</div>
                    <div class="number">Estado de Contrato</div>
                  </div>
                  <div class="col">
                    <div class="number">{{ $address }}</div>
                    <div class="number">{{ $phone }}</div>
                    <div class="number">{{ $estadoCivil }}</div>
                    <div class="number">{{ $areaid }}</div>
                    <div class="number">{{ $cargoid }}</div>
                    <div class="number">{{ $fechaInicio }}</div>
                    <div class="number">{{ $contratoid }}</div>
                    <div class="number">{{ $salario }} Bs</div>
                    <div class="number">{{ $estado }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
            <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning close-btn text-info"
                data-dismiss="modal" style="background: #ee761c">CANCELAR</button>
        </div>

    </div>
  </div>
</div>
{{--
<div wire:ignore.self class="modal fade" id="modal-details" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-body">

      <div class="row">
        <div class="col-md-3 pl-md-0 pr-md-0"></div>
        <div class="col-md-6 pl-md-0 pr-md-0">
          <div class="card-pricing2 card-warning">
           
            <div class="pricing-header">
              <h3 class="fw-bold">Informacion de Empleado # {{$idEmpleado }}</h3>
              
            </div>
            <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
              
                <div class="price-value">
                  <div class="value">
                    <img src="{{ asset('storage/employees/' .$image)}}"
                    alt="imagen de ejemplo" height="90" width="100" class="img-fluid rounded-start">
                  </div>
                </div>
                <ul class="pricing-content">
                  <li>CI: {{ $ci }}</li>
                  <li>NOMBRE: {{ $name }}</li>
                  <li>APELLIDOS: {{ $lastname }}</li>
                  <li>GENERO: {{ $genero }}</li>
                  <li>FECHA DE NACIMIENTO: {{ $dateNac }}</li>
                  <li>DIRECCION: {{ $address }}</li>
                  <li>TELEFONO: {{ $phone }}</li>
                  <li>ESTADO CIVIL: {{ $estadoCivil }}</li>
                  <li>AREA: {{ $areaid }}</li>
                  <li>CARGO: {{ $cargoid }}</li>
                  <li>FECHA DE INICIO: {{ $fechaInicio }}</li>
                  <li>FECHA FINAL: {{ $contratoid }}</li>
                  <li>SALARIO: {{ $salario }} Bs.</li>
                </ul>
            <a wire:click.prevent="resetUI()" data-dismiss="modal" class="btn btn-warning btn-border btn-lg w-75 fw-bold mb-3">Cerrar</a>
            
          </div>
        </div>
      </div>   
    </div>
  </div>
</div>--}}