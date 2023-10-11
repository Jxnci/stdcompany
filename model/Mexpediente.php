<?php
session_start();
class Expediente {
  private $db;
  private $consulta;
  public function __construct() {
    require_once("conexion.php");
    $this->db = Conectar::Conexion();
    $this->consulta = array();
  }
  public function listarExpediente() {
    $usuario_id = $_SESSION['id'];
    $role = $_SESSION['id_rol'];
    $datos = array();
    if ($role == 3) {
      $query = "SELECT * FROM v_expedientesMD ORDER BY estado ASC, id DESC;";
    } else {
      $query = "SELECT * FROM v_expedientes WHERE usuario_id=$usuario_id ORDER BY estado ASC, id DESC;";
    }
    $this->consulta = mysqli_query($this->db, $query);
    while ($row = mysqli_fetch_assoc($this->consulta)) {
      $data['id'] = $row['id'];
      $data['num'] = $row['numero_expediente'];
      $data['asu'] = $row['asunto'];
      $data['fec'] = $row['fecha'];
      $data['est'] = $row['estado'];
      $data['usc'] = $row['usuarioCreador'];
      $data['id_rol'] = $role;
      array_push($datos, $data);
    }
    return $datos;
  }

  public function listarExpedienteID($id) {
    $datos = array();
    $this->consulta = mysqli_query($this->db, "CALL p_expedienteID($id);");
    while ($row = mysqli_fetch_assoc($this->consulta)) {
      $data['id'] = $row['id'];
      $data['asunto'] = $row['asunto'];
      $data['cantidad_doc'] = $row['cantidad_doc'];
      $data['num_folios'] = $row['num_folios'];
      $data['tramite'] = $row['tramite'];
      $data['doc_adjunto'] = $row['doc_adjunto'];
      $data['tramitante_id'] = $row['tramitante_id'];
      $data['nombres'] = $row['nombres'];
      $data['apellidos'] = $row['apellidos'];
      $data['dni'] = $row['dni'];
      $data['correo'] = $row['correo'];
      $data['celular'] = $row['celular'];
      array_push($datos, $data);
    }
    return $datos;
  }

  public function listarMovimientoID($id) {
    $datos = array();
    $this->consulta = mysqli_query($this->db, "CALL p_expedienteID($id);");
    while ($row = mysqli_fetch_assoc($this->consulta)) {
      $data['id'] = $row['id'];
      $data['asunto'] = $row['asunto'];
      $data['cantidad_doc'] = $row['cantidad_doc'];
      $data['num_folios'] = $row['num_folios'];
      $data['tramite'] = $row['tramite'];
      $data['doc_adjunto'] = $row['doc_adjunto'];
      $data['tramitante_id'] = $row['tramitante_id'];
      $data['nombres'] = $row['nombres'];
      $data['apellidos'] = $row['apellidos'];
      $data['dni'] = $row['dni'];
      $data['correo'] = $row['correo'];
      $data['celular'] = $row['celular'];
      array_push($datos, $data);
    }
    return $datos;
  }

  public function listarUsuariosArea($id) {
    $datos = array();
    $this->consulta = mysqli_query($this->db, "SELECT * FROM v_usuarios WHERE area_id=$id;");
    while ($row = mysqli_fetch_assoc($this->consulta)) {
      $data['id'] = $row['id'];
      $data['nom'] = $row['nombres'];
      $data['car'] = $row['cargo'];
      $data['rol'] = $row['rol_id'];
      array_push($datos, $data);
    }
    return $datos;
  }
}

require_once("conexion.php");
$db = Conectar::Conexion();
$puente = new Expediente();

// usando AJAX con jQuery
if (isset($_POST['dataexpediente'])) {
  $datos = $puente->listarExpediente();
  echo json_encode($datos);
}

if (isset($_POST['agregar'])) {
  $usuario_id = $_SESSION['id'];
  $asunto = mysqli_real_escape_string($db, $_POST['asunto']);
  $cantidad_doc = mysqli_real_escape_string($db, $_POST['cantidad_doc']);
  $num_folios = mysqli_real_escape_string($db, $_POST['num_folios']);
  $tramite = mysqli_real_escape_string($db, $_POST['tramite']);
  $doc_adjunto = mysqli_real_escape_string($db, $_POST['doc_adjunto']);

  $nombres = mysqli_real_escape_string($db, $_POST['nombres']);
  $apellidos = mysqli_real_escape_string($db, $_POST['apellidos']);
  $dni = mysqli_real_escape_string($db, $_POST['dni']);
  $correo = mysqli_real_escape_string($db, $_POST['correo']);
  $celular = mysqli_real_escape_string($db, $_POST['celular']);

  $query =  "INSERT INTO tramitante(dni,celular,correo,nombres, apellidos) 
  VALUES ('$dni', '$celular', '$correo', '$nombres', '$apellidos')";
  $result = mysqli_query($db, $query);
  if ($result) {
    $query1 =  "SELECT id FROM tramitante order by id desc limit 1;";
    $query12 =  "SELECT id FROM expediente order by id desc limit 1;";
    $result1 = mysqli_query($db, $query1);
    $result12 = mysqli_query($db, $query12);
    if ($result1 && $result12) {
      $tramitante_id = mysqli_fetch_assoc($result1);
      $expediente_id = mysqli_fetch_assoc($result12);
      $id_t = $tramitante_id['id'];
      $id_e = $expediente_id['id'] + 1;
      date_default_timezone_set('America/Lima');
      $fecha = date('Y-m-d H:i:s');
      $query2 =  "INSERT INTO expediente(numero_expediente, tramite, asunto, doc_adjunto, cantidad_doc,num_folios,estado,fecha,tramitante_id,usuario_id) 
        VALUES ('$id_e', '$tramite','$asunto', '$doc_adjunto', '$cantidad_doc','$num_folios', '1', '$fecha','$id_t','$usuario_id')";
      $result2 = mysqli_query($db, $query2);
      if (!$result2) {
        exit(mysqli_error($db));
        echo mysqli_error($db);
      } else {
        $msj = 'Expediente Agregado!';
      }
    } else {
      exit(mysqli_error($db));
      echo mysqli_error($db);
    }
  } else {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }

  echo $msj;
}

if (isset($_POST['eliminar'])) {
  $id = $_POST['id'];
  $query =  "DELETE FROM expediente WHERE id = $id;";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }
  echo "Se elimino correctamente";
}

if (isset($_POST['edit'])) {
  $id = mysqli_real_escape_string($db,  $_POST['id']);
  $asunto = mysqli_real_escape_string($db, $_POST['asunto']);
  $cantidad_doc = mysqli_real_escape_string($db, $_POST['cantidad_doc']);
  $num_folios = mysqli_real_escape_string($db, $_POST['num_folios']);
  $tramite = mysqli_real_escape_string($db, $_POST['tramite']);
  $doc_adjunto = mysqli_real_escape_string($db, $_POST['doc_adjunto']);

  $tramitante_id = mysqli_real_escape_string($db, $_POST['tramitante_id']);
  $nombres = mysqli_real_escape_string($db, $_POST['nombres']);
  $apellidos = mysqli_real_escape_string($db, $_POST['apellidos']);
  $dni = mysqli_real_escape_string($db, $_POST['dni']);
  $correo = mysqli_real_escape_string($db, $_POST['correo']);
  $celular = mysqli_real_escape_string($db, $_POST['celular']);

  $query = "UPDATE expediente SET 
    asunto='$asunto',cantidad_doc='$cantidad_doc',num_folios='$num_folios',tramite='$tramite',
    doc_adjunto='$doc_adjunto' WHERE id = '$id'";

  $queryTramitante = "UPDATE tramitante SET 
    nombres='$nombres',apellidos='$apellidos',dni='$dni',correo='$correo',
    celular='$celular' WHERE id = '$tramitante_id'";
  if (!$result = mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }
  if (!$result = mysqli_query($db, $queryTramitante)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  }
  echo 'Se edito correctamente!';
}

if (isset($_POST['obtenerId'])) {
  $id = $_POST['id'];
  $datos = $puente->listarExpedienteID($id);
  echo json_encode($datos);
}

// Mas peticiones
if (isset($_POST['registrarMovimiento'])) {
  $usuario = mysqli_real_escape_string($db, $_POST['usuario']);
  $observacion_movimiento = mysqli_real_escape_string($db, $_POST['observacion_movimiento']);
  $id_expediente = mysqli_real_escape_string($db, $_POST['id_expediente']);
  $fecha = mysqli_real_escape_string($db, $_POST['fecha']);
  $fechaObjeto = DateTime::createFromFormat("d/m/Y, H:i:s", $fecha);
  $fechaFormateada = $fechaObjeto->format("Y-m-d H:i:s");
  $query =  "INSERT INTO movimiento(usuario_id, expediente_id,observacion, fecha, estado) 
    VALUES ('$usuario', '$id_expediente','$observacion_movimiento', '$fechaFormateada', '1')";
  if (!mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  } else {
    $query2 = "UPDATE expediente SET estado='2' WHERE id = '$id_expediente'";
    if (!mysqli_query($db, $query2)) {
      exit(mysqli_error($db));
      echo mysqli_error($db);
    } else {
      echo 'Expediente enviado!';
    }
  }
}

if (isset($_POST['comboArea'])) {
  $datos = array();
  $query = mysqli_query($db, "SELECT * FROM area;");
  while ($row = mysqli_fetch_assoc($query)) {
    $data['id'] = $row['id'];
    $data['nom'] = $row['nombre'];
    array_push($datos, $data);
  }
  echo json_encode($datos);
}

if (isset($_POST['comboUsuario'])) {
  $id = mysqli_real_escape_string($db, $_POST['area_id']);
  $datos = $puente->listarUsuariosArea($id);
  echo json_encode($datos);
}

if (isset($_POST['consultaMovimiento'])) {
  $id = mysqli_real_escape_string($db, $_POST['id']);
  $query = mysqli_query($db, "SELECT * FROM v_movimientoAnterior WHERE expediente_id=$id;");
  $cantidad = mysqli_num_rows($query);
  if ($cantidad < 2) {
    $resultados = [];
    $query1 = mysqli_query($db, "SELECT * FROM v_expedienteAnterior WHERE expediente_id=$id;");
    while ($datos1 = mysqli_fetch_array($query1)) {
      $resultados[] = $datos1;
    }
  }else{
    $query = mysqli_query($db, "SELECT * FROM v_movimientoAnterior WHERE expediente_id=$id ORDER BY fecha ASC LIMIT 1;");
    $queryobs = mysqli_query($db, "SELECT observacion FROM movimiento WHERE expediente_id=$id AND estado=1;");
    $resultado = mysqli_fetch_assoc($queryobs);
    $observacion = $resultado['observacion'];
    while ($datos = mysqli_fetch_array($query)) {
      $datos['observacion'] = $observacion;
      $resultados[] = $datos;
    }
  }
  echo json_encode($resultados);
}

if (isset($_POST['realizarMovimiento'])) {
  $usuario = mysqli_real_escape_string($db, $_POST['usuario']);
  $observacion_movimiento = mysqli_real_escape_string($db, $_POST['observacion_movimiento']);
  $id_expediente = mysqli_real_escape_string($db, $_POST['id_expediente']);
  $id_usuario = mysqli_real_escape_string($db, $_POST['id_usuario']);
  $id_trabajador = mysqli_real_escape_string($db, $_POST['id_trabajador']);
  $fecha = mysqli_real_escape_string($db, $_POST['fecha']);
  $fechaObjeto = DateTime::createFromFormat("d/m/Y, H:i:s", $fecha);
  $fechaFormateada = $fechaObjeto->format("Y-m-d H:i:s");

  $query =  "INSERT INTO movimiento(usuario_id, expediente_id,observacion, fecha, estado) 
    VALUES ('$usuario', '$id_expediente','$observacion_movimiento', '$fechaFormateada', '1')";
  if (!mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  } else {
    $query2 = "UPDATE expediente SET estado='2' WHERE id = '$id_expediente'";
    if (!mysqli_query($db, $query2)) {
      exit(mysqli_error($db));
      echo mysqli_error($db);
    } else {
      $query3 = "UPDATE movimiento SET estado='2' WHERE expediente_id = '$id_expediente' AND usuario_id='$id_usuario';";
      if (!mysqli_query($db, $query3)) {
        exit(mysqli_error($db));
        echo mysqli_error($db);
      } else {
        echo 'Expediente enviado!';
      }
    }
  }
}

if (isset($_POST['finalizarTramiteMPP'])) {
  $id_expediente = mysqli_real_escape_string($db, $_POST['id_expediente']);
  $query = "UPDATE expediente SET estado='3' WHERE id = '$id_expediente'";
  if (!mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  } else {
    echo 'Expediente enviado!';
  }
}

if (isset($_POST['finalizarMovimiento'])) {
  $id_expediente = mysqli_real_escape_string($db, $_POST['id_expediente']);
  $query = "UPDATE expediente SET estado='3' WHERE id = '$id_expediente'";
  if (!mysqli_query($db, $query)) {
    exit(mysqli_error($db));
    echo mysqli_error($db);
  } else {

    $result1 = mysqli_query($db, "SELECT usuario_id FROM expediente WHERE id = '$id_expediente'");
    $tramitante_id = mysqli_fetch_assoc($result1);
    $usuario = $tramitante_id['usuario_id'];
    $observacion_movimiento = mysqli_real_escape_string($db, $_POST['observacion_movimiento']);
    $id_expediente = mysqli_real_escape_string($db, $_POST['id_expediente']);
    $id_trabajador = mysqli_real_escape_string($db, $_POST['id_trabajador']);
    $id_usuario = mysqli_real_escape_string($db, $_POST['id_usuario']);
    $fecha = mysqli_real_escape_string($db, $_POST['fecha']);
    $fechaObjeto = DateTime::createFromFormat("d/m/Y, H:i:s", $fecha);
    $fechaFormateada = $fechaObjeto->format("Y-m-d H:i:s");

    $query =  "INSERT INTO movimiento(usuario_id, expediente_id,observacion, fecha, estado) 
      VALUES ('$usuario', '$id_expediente','$observacion_movimiento', '$fechaFormateada', '2')";
    if (!mysqli_query($db, $query)) {
      exit(mysqli_error($db));
      echo mysqli_error($db);
    } else {
      $query3 = "UPDATE movimiento SET estado='2' WHERE expediente_id = '$id_expediente' AND usuario_id='$id_usuario';";
      if (!mysqli_query($db, $query3)) {
        exit(mysqli_error($db));
        echo mysqli_error($db);
      } else {
        echo 'Expediente Finalizado!';
      }
    }
  }
}


if (isset($_POST['dataDocs'])) {

  $datos = array();
  $id_expediente = mysqli_real_escape_string($db, $_POST['id_expediente']);
  $query = mysqli_query($db, "SELECT * FROM docs WHERE expediente_id='$id_expediente';");
  while ($row = mysqli_fetch_assoc($query)) {
    $data['id'] = $row['id'];
    $data['nom'] = $row['ruta'];
    array_push($datos, $data);
  }
  echo json_encode($datos);

}