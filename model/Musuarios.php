<?php
class Usuario {
  private $db;
  private $consulta;
  public function __construct() {
    require_once("conexion.php");
    $this->db = Conectar::Conexion();
    $this->consulta = array();
  }
  public function listarUsuarios() {
    $datos = array();
    $this->consulta = mysqli_query($this->db, "SELECT * FROM v_usuarios;");
    while ($row = mysqli_fetch_assoc($this->consulta)) {
      $data['id'] = $row['id'];
      $data['dni'] = $row['dni'];
      $data['nom'] = $row['nombres'];
      $data['cel'] = $row['celular'];
      $data['cor'] = $row['correo'];
      $data['car'] = $row['cargo'];
      $data['rol'] = $row['rol'];
      array_push($datos, $data);
    }
    return $datos;
  }
  public function listarUsuariosID($id) {
    $datos = array();
    $this->consulta = mysqli_query($this->db, "SELECT * FROM usuario WHERE id=$id;");
    while ($row = mysqli_fetch_assoc($this->consulta)) {
      $data['id'] = $row['id'];
      $data['dni'] = $row['dni'];
      $data['nom'] = $row['nombres'];
      $data['app'] = $row['apellidoP'];
      $data['apm'] = $row['apellidoM'];
      $data['cel'] = $row['celular'];
      $data['cor'] = $row['correo'];
      $data['are'] = $row['area_id'];
      $data['car'] = $row['cargo_id'];
      $data['rol'] = $row['rol_id'];
      $data['emp'] = $row['empresa_id'];
      array_push($datos, $data);
    }
    return $datos;
  }
  public function listarUsuariosArea($id) {
    $datos = array();
    $this->consulta = mysqli_query($this->db, "SELECT * FROM cargo WHERE area_id=$id;");
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
$puente = new Usuario();

// usando AJAX con jQuery
if (isset($_POST['data'])) {
  $datos = $puente->listarUsuarios();
  echo json_encode($datos);
}

if (isset($_POST['agregar'])) {
  $nombres = mysqli_real_escape_string($db, $_POST['nombres']);
  $apellidop = mysqli_real_escape_string($db, $_POST['apellidop']);
  $apellidom = mysqli_real_escape_string($db, $_POST['apellidom']);
  $correo = mysqli_real_escape_string($db, $_POST['correo']);
  $dni = mysqli_real_escape_string($db, $_POST['dni']);
  $clave = md5(mysqli_real_escape_string($db, $_POST['clave']));
  $celular = mysqli_real_escape_string($db, $_POST['celular']);
  $rol_id = mysqli_real_escape_string($db, $_POST['rol_id']);
  $area_id = mysqli_real_escape_string($db, $_POST['area_id']);
  $cargo_id = mysqli_real_escape_string($db, $_POST['cargo_id']);
  $query =  "INSERT INTO usuario(dni,nombres,apellidoP,apellidoM,celular,correo,clave,area_id,cargo_id,rol_id,empresa_id)
  VALUES ('$dni','$nombres','$apellidop','$apellidom','$celular','$correo','$clave','$area_id','$cargo_id','$rol_id',1)";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }
  echo "Agregado correctamente";
}

if (isset($_POST['edit'])) {
  $id = mysqli_real_escape_string($db, $_POST['id']);
  $nom = mysqli_real_escape_string($db, $_POST['nom']);
  $app = mysqli_real_escape_string($db, $_POST['app']);
  $apm = mysqli_real_escape_string($db, $_POST['apm']);
  $cor = mysqli_real_escape_string($db, $_POST['cor']);
  $dni = mysqli_real_escape_string($db, $_POST['dni']);
  $cel = mysqli_real_escape_string($db, $_POST['cel']);
  $rol = mysqli_real_escape_string($db, $_POST['rol']);
  $are = mysqli_real_escape_string($db, $_POST['are']);
  $car = mysqli_real_escape_string($db, $_POST['car']);
  $emp = mysqli_real_escape_string($db, $_POST['emp']);
  $query = "UPDATE usuario SET 
    dni='$dni',nombres='$nom',apellidoP='$app',apellidoM='$apm',
    celular='$cel',correo='$cor',area_id='$are',
    cargo_id='$car',rol_id='$rol',empresa_id='$emp' WHERE id = '$id'";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }
  echo 'Se edito correctamente!';
}

if (isset($_POST['obtenerId'])) {
  $id = $_POST['id'];
  $datos = $puente->listarUsuariosID($id);
  echo json_encode($datos);
}

// mas consultas
if (isset($_POST['select'])) {
  $id = mysqli_real_escape_string($db, $_POST['area_id']);
  $datos = $puente->listarUsuariosArea($id);
  echo json_encode($datos);
}
if (isset($_POST['combo'])) {
  $datos = array();
  $query = mysqli_query($db, "SELECT * FROM cargo;");
  while ($row = mysqli_fetch_assoc($query)) {
    $data['id'] = $row['id'];
    $data['nom'] = $row['nombre'];
    array_push($datos, $data);
  }
  echo json_encode($datos);
}
