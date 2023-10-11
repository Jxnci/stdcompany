<?php
session_start();
if (empty($_SESSION['correo'])) {
  header('location: ../');
}
require("../controller/controller.php");
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>STD - <?= $_SESSION['empresa']; ?></title>
  <link rel="shortcut icon" href="../images/<?= $_SESSION['logo']; ?>" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <!-- Libreria para datatables -->
  <link rel="stylesheet" href="../dist/datatables/datatables.min.css">
  <!-- <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css" rel="stylesheet"> -->
  <!-- Estilos Personalizados -->
  <link rel="stylesheet" href="../css/styles.css">
  <!-- Toast JS -->
  <!-- <link ref="stylesheet" type="text/css" href="../dist/snackbar.min.css"> -->
  <link rel="stylesheet" href="../dist/snackbar.min.css" media="screen" title="no title" charset="utf-8">
</head>

<body class="m-4 mt-3 bg-deep">
  <nav class="navbar navbar-expand-lg bg-title rounded">
    <?php
    include('component/navbar.php');
    ?>
  </nav>
  <div class="border bg-white shadow-sm rounded px-3 py-2 my-2 d-flex justify-content-between">
    <div>
      <span class="fw-bolder "><?= $_SESSION['usuario']; ?></span>
      <span class="blockquote-footer"><?= $_SESSION['correo']; ?></span>
    </div>
    <p class="card-text"><?= $_SESSION['cargo']; ?> | <?= $_SESSION['rol']; ?></p>
  </div>

  <main class="shadow-sm">
    <?php
    if (isset($_GET["ventana"])) {
      mostrarVentana($_GET["ventana"]);
    } else {
      mostrarVentana('inicio');
    }
    ?>
  </main>
  <footer class="footer">
    <?php
    include('component/footer.php');
    ?>
  </footer>
</body>
<!-- Libreria Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<!-- libreria para alertas -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Libreria JQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Libreria para datatable -->
<script src="../dist/datatables/datatables.min.js"></script>
<!-- Libreria notificaciones -->
<script src="../dist/snackbar.min.js"></script>


</html>