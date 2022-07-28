<li class="nav-item dropdown hidden-caret">
          
    @if (empty(session('sesionCaja')))
          <h5 style="background-color: #f57c13; color:#ffffff">No tienes ninguna caja abierta</h5>
    @else
        <marquee behavior="" direction="">
            <h5 style="background-color: #ff7600; color:#ffffff;font-size:24px">Usted tiene la {{ session('sesionCaja') }} abierta</h5>
        </marquee>
    @endif
  </li>
