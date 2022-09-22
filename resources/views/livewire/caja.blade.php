<li class="nav-item dropdown hidden-caret">
          
    @if (empty(session('sesionCaja')))
          <h5 style="background-color: #05a4e1; color:#ffffff; border-radius: 7; padding-left: 5px; padding-right: 5px;">No tienes ninguna caja abierta</h5>
    @else
        <marquee behavior="" direction="">
            <h5 style="background-color: #05a4e1; color:#ffffff;font-size:24px; border-radius: 7px; padding-left: 5px; padding-right: 5px;">Usted tiene la {{ session('sesionCaja') }} abierta</h5>
        </marquee>
    @endif
  </li>
