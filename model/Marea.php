<?php
class Area {
  private $db;
  private $consulta;
  public function __construct() {
    require_once("conexion.php");
    $this->db = Conectar::Conexion();
    $this->consulta = array();
  }
  public function listarAreas() {
    $datos = array();
    $this->consulta = mysqli_query($this->db, "SELECT * FROM area;");
    while ($row = mysqli_fetch_assoc($this->consulta)) {
      $data['id'] = $row['id'];
      $data['nom'] = $row['nombre'];
      array_push($datos, $data);
    }
    return $datos;
  }
  public function listarAreasID($id) {
    $datos = array();
    $this->consulta = mysqli_query($this->db, "SELECT * FROM area where id=$id;");
    while ($row = mysqli_fetch_assoc($this->consulta)) {
      $data['id'] = $row['id'];
      $data['nom'] = $row['nombre'];
      array_push($datos, $data);
    }
    return $datos;
  }
}

require_once("conexion.php");
$db = Conectar::Conexion();
$puente = new Area();

// usando AJAX con jQuery
if (isset($_POST['data'])) {
  $datos = $puente->listarAreas();
  echo json_encode($datos);
}

if (isset($_POST['agregar'])) {
  $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
  $query =  "INSERT INTO area(nombre) VALUES ('$nombre')";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }
  echo "Area creada";
}

if (isset($_POST['eliminar'])) {
  $id = $_POST['id'];

  $query =  "DELETE FROM area WHERE id = $id;";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }
  echo "Se elimino correctamente";
}

if (isset($_POST['edit'])) {
  $id = mysqli_real_escape_string($db, $_POST['id']);
  $nom = mysqli_real_escape_string($db, $_POST['nom']);
  $query = "UPDATE area SET nombre='$nom' WHERE id = '$id'";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }
  echo 'Se edito correctamente!';
}

if (isset($_POST['obtenerId'])) {
  $id = $_POST['id'];
  $datos = $puente->listarAreasID($id);
  echo json_encode($datos);
}
