<?php
if (empty($_POST['nexpediente']) || empty($_POST['anio'])) {
  header('location: consulta.php?error');
}

require_once("model/conexion.php");
$db = Conectar::Conexion();
$nexpediente = mysqli_real_escape_string($db, $_POST['nexpediente']);
$anio = mysqli_real_escape_string($db, $_POST['anio']);
$query = mysqli_query($db, "CALL p_lineaExpediente('$nexpediente','$anio');");
mysqli_close($db);
?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>STD - Linea de tiempo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="container-fluid my-4">
  <div class="border-end border-start rounded bg-light">

    <div class="border bg-dark rounded px-3 py-2 d-flex justify-content-between">
      <div>
        <span class="fw-bolder text-white">Consulta de seguimiento de expediente</span>
        <span class="blockquote-footer text-white">STD</span>
      </div>
      <p class="card-text">
        <a href="consulta.php" class="text-white">Realizar otra consultar</a>
      </p>
    </div>
    <div class="container mt-4">
      <div class="border bg-dark-subtle rounded px-3 py-2 mb-4 d-flex justify-content-between">
        <div>
          <span class="fw-bolder ">nombres tramitante</span>
          <span class="blockquote-footer">cant_doc | num_folios</span>
        </div>
        <p class="card-text">num_exp | tramite</p>
      </div>
    </div>

    <!-- Section: Timeline -->
    <section class=" container ">
      <ul class="timeline-with-icons">

        <li class="timeline-item mb-5">
          <span class="timeline-icon">
            <i class="fas fa-rocket text-primary fa-sm fa-fw"></i>
          </span>

          <span class="btn btn-success">Mesa de partes</span>
          <p class="">Nombre del encargado</p>
          <p class="">Observacion</p>
          <h5 class="fw-bold">Observacion mencionada</h5>
          <p class="text-muted mb-2 fw-bold">Fecha del expediente</p>
          <p class="text-muted">
            Fecha de movimiento
          </p>
        </li>

        <?php
        $resultado = mysqli_num_rows($query);
        if ($resultado > 0) {
          while ($datos = mysqli_fetch_array($query)) {
        ?>
            <li class="timeline-item mb-5">
              <span class="timeline-icon">
                <i class="fas fa-rocket text-primary fa-sm fa-fw"></i>
              </span>

              <span class="btn btn-success"><?= $datos['area'] ?></span>
              <p class=""><?= $datos['encargado'] ?></p>
              <p class="">Observacion</p>
              <h5 class="fw-bold"><?= $datos['observacion'] ?></h5>
              <p class="text-muted mb-2 fw-bold"><?= $datos['fecha_expediente'] ?></p>
              <p class="text-muted">
                <?= $datos['fecha'] ?>
              </p>
            </li>
        <?php
          }
        } else {
          header('location: consulta.php?sindatos');
        }
        ?>
      </ul>
    </section>
    <!-- Section: Timeline -->
  </div>
  <div hidden>
    <i class="fas fa-hand-holding-usd text-primary fa-sm fa-fw"></i>
    <i class="fas fa-users text-primary fa-sm fa-fw"></i>
    <i class="fas fa-money-bill-wave text-primary fa-sm fa-fw"></i>
  </div>
</body>

<style>
  .timeline-with-icons {
    border-left: 1px solid hsl(0, 0%, 90%);
    position: relative;
    list-style: none;
  }

  .timeline-with-icons .timeline-item {
    position: relative;
  }

  .timeline-with-icons .timeline-item:after {
    position: absolute;
    display: block;
    top: 0;
  }

  .timeline-with-icons .timeline-icon {
    position: absolute;
    left: -48px;
    background-color: hsl(217, 88.2%, 90%);
    color: hsl(217, 88.8%, 35.1%);
    border-radius: 50%;
    height: 31px;
    width: 31px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>
<!-- Libreria Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>


</html>