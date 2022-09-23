<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid justify-content-end">
      {{-- <a class="navbar-brand back px-3" id="volver" onclick="volover()" ><i class="fas fa-chevron-left"></i></a> --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse navegacion justify-content-between" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link home px-3" aria-current="page" href="{{route('')}}"><i class="fas fa-home"></i> Inicio</a>
          <a class="nav-link picking px-3" href="{{route('')}}"><i class="fas fa-tasks"></i> Asignación Pedidos </a>
        </div>
        
        <div class="navbar-nav">
          <li class="nav-item dropdown dropstart">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{$_COOKIE['USER']}}
            </a>
            <ul class="dropdown-menu">
              <li><p class="dropdown-item">{{$_COOKIE['USER_ROL']}}</p></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{route('logout')}}"><i class="fas fa-sign-out-alt"></i> Cerrar Sescción</a></li>
            </ul>
          </li>
        </div>
      </div>
    </div>
  </nav>