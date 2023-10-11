<?php
class Cargo {
  private $db;
  private $consulta;
  public function __construct() {
    require_once("conexion.php");
    $this->db = Conectar::Conexion();
    $this->consulta = array();
  }
  public function listarCargos() {
    $datos = array();
    $this->consulta = mysqli_query($this->db, "SELECT * FROM v_cargos;");
    while ($row = mysqli_fetch_assoc($this->consulta)) {
      $data['id'] = $row['id'];
      $data['nom'] = $row['nombre'];
      $data['area'] = $row['area'];
      array_push($datos, $data);
    }
    return $datos;
  }
  public function listarCargosID($id) {
    $datos = array();
    $this->consulta = mysqli_query($this->db, "SELECT * FROM v_cargos WHERE id=$id;");
    while ($row = mysqli_fetch_assoc($this->consulta)) {
      $data['id'] = $row['id'];
      $data['nom'] = $row['nombre'];
      $data['area_id'] = $row['area_id'];
      array_push($datos, $data);
    }
    return $datos;
  }
}

require_once("conexion.php");
$db = Conectar::Conexion();
$puente = new Cargo();

// usando AJAX con jQuery
if (isset($_POST['data'])) {
  $datos = $puente->listarCargos();
  echo json_encode($datos);
}

if (isset($_POST['agregar'])) {
  $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
  $area_id = mysqli_real_escape_string($db, $_POST['area_id']);
  $query =  "INSERT INTO cargo(nombre,area_id) VALUES ('$nombre','$area_id')";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }
  echo "Agregado correctamente";
}

if (isset($_POST['edit'])) {
  $id = mysqli_real_escape_string($db, $_POST['id']);
  $nom = mysqli_real_escape_string($db, $_POST['nom']);
  $area_id = mysqli_real_escape_string($db, $_POST['area_id']);
  $query = "UPDATE cargo SET nombre='$nom', area_id='$area_id' WHERE id = '$id'";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }
  echo 'Se edito correctamente!';
}

if (isset($_POST['obtenerId'])) {
  $id = $_POST['id'];
  $datos = $puente->listarCargosID($id);
  echo json_encode($datos);
}
