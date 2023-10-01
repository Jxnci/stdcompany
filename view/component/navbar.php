<div class="container-fluid">
  <a class="navbar-brand text-white <?= $active == 'inicio' ? 'active' : '' ?>" href="panel.php?ventana=inicio">
    <img src="../images/<?= $_SESSION['logo'] ?>" alt="Logo" width="24" height="24" class="d-inline-block align-text-top">
    <?= strtoupper($_SESSION['empresa']) ?>
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link  text-white <?= $active == 'inicio' ? 'active' : '' ?>" href="panel.php?ventana=inicio">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?= $active == 'inicio' ? 'active' : '' ?>" href="panel.php?ventana=inicio">Enviado</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?= $active == 'empresa' ? 'active' : '' ?>" href="panel.php?ventana=empresa">Empresa</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          General
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item  <?= $active == 'areas' ? 'active' : '' ?>" href="panel.php?ventana=areas">Areas</a></li>
          <li><a class="dropdown-item  <?= $active == 'cargos' ? 'active' : '' ?>" href="panel.php?ventana=cargos">Cargos</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item  <?= $active == 'usuarios' ? 'active' : '' ?>" href="panel.php?ventana=usuarios">Usuarios</a></li>
          <li><a class="dropdown-item  <?= $active == 'roles' ? 'active' : '' ?>" href="panel.php?ventana=roles">Roles</a></li>
        </ul>
      </li>
    </ul>
    <div class="d-flex">
      <div>
        hola
      </div>
      <button onclick="salir()" class="btn btn-danger ">
        Cerrar Sesion
      </button>
    </div>
  </div>
</div>
<script>
  function salir() {
    swal({
      title: "¿Desea salir?",
      text: "Se cerrara la sesion",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        window.location = '../model/cerrarSesion.php';
      }
    });
  }
  var dropdownToggle = document.querySelector('.dropdown-toggle');
  var dropdownMenu = document.querySelector('.dropdown-menu');
  dropdownToggle.addEventListener('click', function() {
    dropdownMenu.classList.toggle('show');
  });

  document.addEventListener('click', function(event) {
    if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
      dropdownMenu.classList.remove('show');
    }
  });
  dropdownToggle.addEventListener('click', function() {
    var expanded = dropdownToggle.getAttribute('aria-expanded') === 'true' || false;
    dropdownToggle.setAttribute('aria-expanded', !expanded);
  });
</script>