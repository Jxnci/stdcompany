<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once("conexion.php");
  $db = Conectar::Conexion();
  if (isset($_FILES['pdfFile'])) {
    $file = $_FILES['pdfFile'];
    $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
    if ($fileType !== 'pdf') {
      echo 'Error: El archivo debe ser un PDF.';
      exit();
    }

    $uploadDir = '../docs/';
    $uploadPath = $uploadDir . basename($file['name']);

    $timezone = new DateTimeZone('America/Lima');
    $date = new DateTime('now', $timezone);
    $currentDateTime = $date->format('Ymd_His');
    $ruta = $currentDateTime . '_' . $file['name'];
    $uploadPath = $uploadDir . $ruta;
    $id_expediente = mysqli_real_escape_string($db, $_POST['id_expediente']);
    $consulta = $db->prepare("INSERT INTO docs(ruta, expediente_id) VALUES (?, ?)");
    $consulta->bind_param("si", $ruta, $id_expediente);
    $consulta->execute();

    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
      echo 'PDF subido correctamente.';
    } else {
      echo 'Error al subir el PDF.';
    }
  }

} else {
  echo 'Error: Método de solicitud no válido.';
}
