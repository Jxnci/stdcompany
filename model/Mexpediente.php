<?php

class Expediente {
  private $db;
  private $mesas;
  public function __construct() {
    require_once("conexion.php");
    $this->db = Conectar::Conexion();
    $this->mesas = array();
  }
  public function listarExpediente($role) {
    $datos = array();
    // if ($role=='admin') {
    //   # code...
    // }
    $this->mesas = mysqli_query($this->db, "SELECT * FROM v_expedientes;;");
    while ($row = mysqli_fetch_assoc($this->mesas)) {
      $data['id'] = $row['id'];
      $data['num'] = $row['numero_expediente'];
      $data['asu'] = $row['asunto'];
      $data['fec'] = $row['fecha'];
      $data['est'] = $row['estado'];
      $data['usc'] = $row['usuarioCreador'];
      array_push($datos, $data);
    }
    return $datos;
  }
  public function listarExpedienteID($idM) {
    $datos = array();
    $this->mesas = mysqli_query($this->db, "SELECT * FROM mesa where idMesa=$idM;");
    while ($row = mysqli_fetch_assoc($this->mesas)) {
      $data['id'] = $row['idMesa'];
      $data['num'] = $row['numero'];
      $data['can'] = $row['cantidad'];
      $data['con'] = $row['condicion'];
      $data['est'] = $row['fk_idEstadoMesa'];
      $data['amb'] = $row['fk_idambiente'];
      array_push($datos, $data);
    }
    return $datos;
  }
}

require_once("conexion.php");
$db = Conectar::Conexion();
$pteExpediente = new Expediente();

// usando AJAX con jQuery
if (isset($_POST['dataexpediente'])) {
  $role = $_POST['rol'];
  $datos = $pteExpediente->listarExpediente($role);
  echo json_encode($datos);
}

if (isset($_POST['addmesa'])) {
  $nomMesa = $_POST['nomMesa'];
  $cantidadMesa = $_POST['cantidadMesa'];
  $ambienteMesa = $_POST['ambienteMesa'];

  $query =  "INSERT INTO mesa(numero, cantidad, condicion, fk_idEstadoMesa, fk_idambiente) VALUES ('$nomMesa', '$cantidadMesa', '1', '1', '$ambienteMesa')";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
  }
  echo "1 Mesa Agregada!";
}

if (isset($_POST['eliminarmesa'])) {
  $idMesa = $_POST['ideliminarmesa'];

  $query =  "UPDATE mesa SET condicion = '0' WHERE (idMesa = '$idMesa');";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
  }
  echo "Mesa inhabilitada";
}

if (isset($_POST['editmesa'])) {
  $ime = $_POST['ime'];
  $nome = $_POST['nome'];
  $dime = $_POST['dime'];
  $came = $_POST['came'];
  $amme = $_POST['amme'];

  $stdo = '';
  if ($dime == '1') {
    $stdo = " fk_idEstadoMesa='1', ";
  }
  if ($dime == '4') {
    $stdo = " fk_idEstadoMesa='4', ";
  }

  $query = "UPDATE mesa SET numero='$nome',cantidad='$came',$stdo  fk_idambiente='$amme' WHERE idMesa = '$ime'";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
  }
  echo $nome . ' se actualizó correctamente!';
}

if (isset($_POST['obtmesaid'])) {
  $id = $_POST['idmesa'];
  $datos = $pteExpediente->listarExpedienteID($id);
  echo json_encode($datos[0]);
}

if (isset($_POST['habilitarmesa'])) {
  $idme = $_POST['idhabilitarmesa'];

  $query = "UPDATE mesa SET condicion='1' WHERE idMesa = '$idme'";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
  }
  echo 'Mesa habilitada!';
}
