<?php
if (isset($_GET['error'])) {
  $alert = '<div class="alert alert-danger py-2" role="alert">
              Todos los campos son obligatorios
            </div>';
}
if (isset($_GET['sindatos'])) {
  $alert = '<div class="alert alert-danger py-2" role="alert">
              No se encontraron datos
            </div>';
}

?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>STD - Consultar Expediente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <!-- Estilos Personalizados -->
  <link rel="stylesheet" href="css/styles.css">
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

  .bg-deep {
    background: linear-gradient(to left, skyblue, #1F78E9);
  }
</style>

<body>
  <section class="vh-100 bg-deep d-flex flex-column">
    <div class="container-fluid h-100 ">
      <div class="row d-flex justify-content-center align-items-center h-100 mx-4">
        <div class="col-md-9 col-lg-6 col-xl-5 d-lg-flex d-none">
          <img src="images/consulta.png" class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 bg-white border shadow-sm p-4 rounded">
          <form action="timeline.php" method="GET">
            <h3 class="text-center">Datos de seguimiento</h3>
            <?php echo isset($alert) ? $alert : ''; ?>
            <!-- Email input -->
            <div class="mb-3">
              <label for="nexpediente" class="form-label">Num. Expediente</label>
              <input type="text" class="form-control" name="nexpediente" placeholder="Ingrese num. de expediente">
            </div>

            <!-- Password input -->
            <div class="mb-3">
              <label for="anio" class="form-label">Año</label>
              <input type="number" class="form-control" name="anio" placeholder="Año de seguimiento">
            </div>

            <div class="text-center d-flex text-lg-start mt-4 pt-2">
              <button type="submit" class="btn text-white font-semibold me-2 bg-title w-100">Consultar</button>
              <a href="index.php" class="btn text-white font-semibold bg-red-gradient w-100">Volver</a>
            </div>

          </form>
        </div>
      </div>
    </div>
    <div class="d-flex m-2 flex-column flex-md-row rounded text-center text-md-start justify-content-between py-3 px-4 px-xl-5 bg-black">
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