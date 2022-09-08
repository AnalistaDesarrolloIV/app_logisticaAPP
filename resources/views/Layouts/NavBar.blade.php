<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid justify-content-end">
    {{-- <a class="navbar-brand back px-3" id="volver" onclick="volover()" ><i class="fas fa-chevron-left"></i></a> --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse navegacion" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link home px-3" aria-current="page" href="/"><i class="fas fa-home"></i> Inicio</a>
        <a class="nav-link picking px-3" href="{{route('logPick')}}"><i class="fas fa-people-carry"></i> Recolección</a>
        <a class="nav-link packing px-3" href="{{route('logPack')}}"><i class="fas fa-box-open"></i> Empaque</a>
      </div>
    </div>
  </div>
</nav>