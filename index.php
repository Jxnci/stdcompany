<?php
session_start();
if (!empty($_SESSION['correo'])) {
  header('location: view/panel.php');
} else {

  if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['correo']) || empty($_POST['clave'])) {
      $alert = '<div class="alert alert-danger py-2" role="alert">
            Ingrese su correo y su clave
            </div>';
    } else {
      require_once("model/conexion.php");
      $db = Conectar::Conexion();
      $correo = mysqli_real_escape_string($db, $_POST['correo']);
      $clave = mysqli_real_escape_string($db, $_POST['clave']);
      $query = mysqli_query($db, "CALL p_iniciarSesion('$correo','$clave');");
      mysqli_close($db);

      $resultado = mysqli_num_rows($query);
      if ($resultado > 0) {
        $dato = mysqli_fetch_array($query);
        $_SESSION['id'] = $dato['id'];
        $_SESSION['correo'] = $dato['correo'];
        $_SESSION['usuario'] = $dato['nombre'];
        $_SESSION['cargo'] = $dato['cargo'];
        $_SESSION['rol'] = $dato['rol'];
        $_SESSION['id_rol'] = $dato['id_rol'];
        $_SESSION['empresa'] = $dato['empresa'];
        $_SESSION['logo'] = $dato['logo'];
        header('location: view/panel.php');
      } else {
        $alert = '<div class="alert alert-danger py-2" role="alert">
                Clave incorrecta
                </div>';
        session_destroy();
      }
    }
  }
}

?>


<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>STD - Inciar Sesion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<style>
  .divider:after,
  .divider:before {
    content: "";
    flex: 1;
    height: 1px;
    background: #eee;
  }

  .h-custom {
    height: calc(100% - 73px);
  }

  @media (max-width: 450px) {
    .h-custom {
      height: 100%;
    }
  }
  
  .bg-title {
    background: linear-gradient(to left, #439CEE, #1F78E9);
  }
  .bg-red-gradient {
    background: linear-gradient(to left, #F44335, #D63B2F);
  }
  .bg-green-gradient {
    background: linear-gradient(to left, #2CB939, #188A1C);
  }
  .bg-deep {
    background: linear-gradient(to left, skyblue, #1F78E9);
  }
</style
</style>

<body>
  <section class="vh-100 bg-deep d-flex flex-column">
    <div class="container-fluid h-100 ">
      <div class="row d-flex justify-content-center align-items-center h-100 mx-4">
        <div class="col-md-9 col-lg-6 col-xl-5 d-lg-flex d-none">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 bg-white border shadow-sm p-4 rounded">
          <form action="" method="POST">
            <h3 class="text-center">Inicior Sesion</h3>
            <?php echo isset($alert) ? $alert : ''; ?>
            <!-- Email input -->
            <div class="mb-3">
              <label for="correo" class="form-label">Correo</label>
              <input type="email" class="form-control" id="correo" name="correo" placeholder="correo@ejemplo.com">
            </div>

            <!-- Password input -->
            <div class="mb-3">
              <label for="clave" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="clave" name="clave" placeholder="contraseña">
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <!-- Checkbox -->
              <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                <label class="form-check-label" for="form2Example3">
                  Recuerdame
                </label>
              </div>
              <a href="#" class="text-body">Olvidates tu clave?</a>
            </div>

            <div class="text-center w text-lg-start mt-4 pt-2">
              <button type="submit" class="btn text-white font-semibold me-2 bg-title w-100">Iniciar Sesion</button>
            </div>
            <div class="text-center w text-lg-start pt-2">
              <a href="consulta.php" class="btn text-white font-semibold bg-green-gradient w-100">Consultar expediente</a>
            </div>

          </form>
        </div>
      </div>
    </div>
    <div class="d-flex m-2 flex-column flex-md-row rounded text-center text-md-start justify-content-between py-3 px-4 px-xl-5 bg-dark">
      <!-- Copyright -->
      <div class="text-white mb-3 mb-md-0">
        Copyright © <?= date('Y') ?>. Reservados todos los derechos.
      </div>
      <!-- Copyright -->

      <!-- Right -->
      <div>
        <a href="#" class="text-white pe-4"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="text-white pe-4"><i class="fab fa-twitter"></i></a>
        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
      </div>
      <!-- Right -->
    </div>
  </section>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</html>