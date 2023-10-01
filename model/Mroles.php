<?php
class Rol {
  private $db;
  private $consulta;
  public function __construct() {
    require_once("conexion.php");
    $this->db = Conectar::Conexion();
    $this->consulta = array();
  }
  public function listarRoles() {
    $datos = array();
    $this->consulta = mysqli_query($this->db, "SELECT * FROM rol;");
    while ($row = mysqli_fetch_assoc($this->consulta)) {
      $data['id'] = $row['id'];
      $data['nom'] = $row['nombre'];
      array_push($datos, $data);
    }
    return $datos;
  }
  public function listarRolesID($id) {
    $datos = array();
    $this->consulta = mysqli_query($this->db, "SELECT * FROM rol where id=$id;");
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
$puente = new Rol();

// usando AJAX con jQuery
if (isset($_POST['data'])) {
  $datos = $puente->listarRoles();
  echo json_encode($datos);
}

if (isset($_POST['agregar'])) {
  $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
  $query =  "INSERT INTO rol(nombre) VALUES ('$nombre')";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }
  echo "Area creada";
}

if (isset($_POST['edit'])) {
  $id = mysqli_real_escape_string($db, $_POST['id']);
  $nom = mysqli_real_escape_string($db, $_POST['nom']);
  $query = "UPDATE rol SET nombre='$nom' WHERE id = '$id'";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }
  echo 'Se edito correctamente!';
}

if (isset($_POST['obtenerId'])) {
  $id = $_POST['id'];
  $datos = $puente->listarRolesID($id);
  echo json_encode($datos);
}
