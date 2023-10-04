<?php

if (isset($_GET['nexpediente']) && isset($_GET['anio']) && !empty($_GET['nexpediente']) && !empty($_GET['anio'])) {
} else {
  header('location: consulta.php?error');
  exit();
}


require_once("model/conexion.php");
$db = Conectar::Conexion();
$nexpediente = mysqli_real_escape_string($db, $_GET['nexpediente']);
$anio = mysqli_real_escape_string($db, $_GET['anio']);
$query = mysqli_query($db, "CALL p_lineaExpediente('$nexpediente','$anio');");
while ($datos = mysqli_fetch_array($query)) {
  $resultados[] = $datos;
}
$resultado = mysqli_num_rows($query);

if ($resultado < 1) {
  mysqli_free_result($query);
  $resultados = [];
  while (mysqli_next_result($db)) {
    if (!mysqli_more_results($db)) {
      break;
    }
  }
  $query =  mysqli_query($db, "CALL p_expedienteCero('$nexpediente','$anio');");
  while ($datos = mysqli_fetch_array($query)) {
    $resultados[] = $datos;
  }
  $nexp = mysqli_num_rows($query);
  if ($nexp < 1) {
    header('location: consulta.php?sindatos');
  }
}
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
  <!-- Estilos Personalizados -->
  <link rel="stylesheet" href="css/styles.css">
</head>

<body class="mx-4 my-4 bg-deep ">
  <div class="bg-title rounded-3 p-3 d-md-flex justify-content-between shadow-sm">
    <div class="items-center">
      <span class="fw-bolder  text-white">Consulta de seguimiento</span>
      <span class="blockquote-footer text-white">STD</span>
    </div>
    <p class="card-text text-center">
      <a href="consulta.php" class=" px-3 py-1 bg-blue font-bold rounded text-white text-decoration-none shadow-sm">Realizar otra consultar</a>
    </p>
  </div>

  <div class="d-flex my-2">
    <div class="bg-green-gradient-icon d-none d-md-flex align-items-center p-4 shadow-sm rounded text-white me-3">
      <i class="fas fa-user"></i>
    </div>
    <div class="bg-white shadow-sm border rounded w-100">
      <div class=" px-3 py-2 d-md-flex justify-content-between align-items-center">
        <div class="w-100">
          <div><span class="fw-semibold">Tramitante:</span> <?= $resultados[0]['consultor'] ?></div>
          <div class="d-md-flex">
            <span class="fw-semibold">Documentos:</span> <?= $resultados[0]['cantidad_doc'] ?> |
            <span class=" ps-2 fw-semibold"> Folios:</span> <?= $resultados[0]['num_folios'] ?>
          </div>
        </div>
        <div class="w-100">
          <div><span class="fw-semibold">Expediente:</span> <?= $resultados[0]['numero_expediente'] ?></div>
          <div><span class="fw-semibold">Fecha Reg.:</span> <?= $resultados[0]['fecha_expediente'] ?></div>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-white shadow-sm border rounded w-100 px-3 py-2 mb-4">
    <span class="fw-semibold">Asunto:</span> <?= $resultados[0]['asunto'] ?>
  </div>

  <h6 class="mb-3">Linea de Movimientos</h6>

  <section class="ms-4">
    <ul class="timeline-with-icons ">

      <li class="timeline-item mb-4 ">
        <span class="timeline-icon">
          <i class="fas fa-flag-checkered text-primary fa-sm fa-fw"></i>
        </span>
        <div class="">
          <div class="d-flex mb-2 ">
            <span class="btn btn-success">Mesa de Partes</span>
            <div class="border ms-2 flex-grow-1 px-2 rounded d-flex justify-content-between align-items-center w-max bg-white shadow-sm">
              <div>
                <?= $resultados[0]['creador'] ?>
                <span class="blockquote-footer">
                  <?= $resultados[0]['cargo_creador'] ?>
                </span>
              </div>
              <span class="text-muted fw-semibold text-end"><?= $resultados[0]['fecha_expediente'] ?></span>
            </div>
          </div>
          <div class="bg-white shadow-sm rounded p-2 border">
            <h6 class="ps-2">Observacion inicial</h6>
            <div class="ps-2"> <span class="px-2">-</span> <?= $resultados[0]['obs_creador'] ?></div>
          </div>
        </div>
      </li>
      <?php
      if ($resultado > 0) {
        $fin = false;
        foreach ($resultados as $fila) {
      ?>
          <li class="timeline-item mb-4 ">
            <span class="timeline-icon">
              <i class="fas fa-rocket text-primary fa-sm fa-fw"></i>
            </span>
            <div class="">
              <div class="d-flex mb-2 ">
                <span class="btn btn-success"><?= $fila['area'] ?></span>
                <div class="border ms-2 flex-grow-1 px-2 rounded d-flex justify-content-between align-items-center w-max bg-white shadow-sm">
                  <div>
                    <?= $fila['encargado'] ?>
                    <span class="blockquote-footer">
                      <?= $fila['cargo'] ?>
                    </span>
                  </div>
                  <span class="text-muted fw-semibold text-end"><?= $fila['fecha'] ?></span>
                </div>
              </div>
              <div class="bg-white shadow-sm rounded p-2 border">
                <h6 class="ps-2">Observacion del area anterior</h6>
                <div class="ps-2"> <span class="px-2">-</span><?= $fila['observacion'] ?></div>
              </div>
            </div>
          </li>
      <?php
          if ($fila['estado_expediente'] == 3) {
            $fin = true;
          }
        }
        if ($fin) {
          echo '<li class="timeline-item mb-4 ">
                <span class="timeline-icon">
                  <i class="fas fa-lock text-primary fa-sm fa-fw"></i>
                </span>
                <div class="">
                  <div class="d-flex mb-2 ">
                    <span class="btn btn-danger">Finalizo</span>
                  </div>
                </div>
              </li>';
        }
      }

      ?>

    </ul>
  </section>

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