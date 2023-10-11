<?php
require_once("../model/conexion.php");
$db = Conectar::Conexion();

if (isset($_POST['btnActualizar'])) {
  $alert = '';
  if (
    empty($_POST['razon']) ||
    empty($_POST['correo'])  ||
    empty($_POST['telefono']) ||
    empty($_POST['direccion'])
  ) {
    $alert = '<div class="alert alert-danger mx-4" role="alert">
            Todo los campos son obligatorios
        </div>';
    echo $_POST['razon'] . ' ' .
      $_POST['correo'] . ' ' .
      $_POST['telefono'] . ' ' .
      $_POST['direccion'];
  } else {
    $id = mysqli_real_escape_string($db, $_POST['id']);
    $razon = mysqli_real_escape_string($db, $_POST['razon']);
    $correo = mysqli_real_escape_string($db, $_POST['correo']);
    $telefono = mysqli_real_escape_string($db, $_POST['telefono']);
    $direccion = mysqli_real_escape_string($db, $_POST['direccion']);

    $img = $_FILES['logo'];
    $name = $img['name'];
    $tmpname = $img['tmp_name'];
    $logo = $_FILES['logo']['name'];
    $destino = "../images/" . $_FILES['logo']['name'];

    $update = mysqli_query($db, "CALL p_actualizarEmpresa('$id','$razon','$correo','$telefono','$direccion','$logo');");
    if ($update) {
      if (move_uploaded_file($tmpname, $destino)) {
        $alert = '<div class="alert alert-success mx-4" role="alert">
        Datos modificados correctamente
    </div>';
      } else {
        $alert = '<div class="alert alert-success mx-4" role="alert">
        Hubo un error al mover el archivo
    </div>';
      }
    } else {
      $alert = '<div class="alert alert-success mx-4" role="alert">
      Hubo un error al actualizar la informacion
  </div>';
    }

    $query = mysqli_query($db, "SELECT * FROM empresa");
    $data = mysqli_fetch_assoc($query);
  }
  unset($_POST);
} else {
  $query = mysqli_query($db, "SELECT * FROM empresa");
  $data = mysqli_fetch_assoc($query);
}
unset($_POST);
?>


<div class="my-3">
  <div class="card">
    <div class="card-header p-0 position-relative mt-n4 z-index-2">
      <div class="bg-gradient-info shadow-info border-radius-lg pt-3 pb-2">
        <h6 class="text-capitalize ps-3">Datos de la empresa</h6>
      </div>
    </div>
    <div class="card-body px-0 pb-2">
      <?php echo isset($alert) ? $alert : ''; ?>
      <form class="p-4 pt-1" method="POST" action="" enctype="multipart/form-data" autocomplete="off">
        <input type="text" hidden id="id" name="id" value="<?= $data['id']; ?>">
        <div class="mb-3">
          <label for="Razon" class="form-label">Razon</label>
          <input type="text" class="form-control" id="Razon" name="razon" value="<?= $data['razon']; ?>">
        </div>
        <div class="mb-3">
          <label for="correo" class="form-label">Correo</label>
          <input type="text" class="form-control" id="correo" name="correo" value="<?= $data['correo']; ?>">
        </div>
        <div class="mb-3">
          <label for="telefono" class="form-label">Telefono/Celular</label>
          <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $data['telefono']; ?>">
        </div>
        <div class="mb-3">
          <label for="direccion" class="form-label">Direccion</label>
          <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $data['direccion']; ?>">
        </div>
        <div>
          <label for="logo" class="form-label">Logo</label>
          <div class="input-group mb-3 border rounded">
            <input type="file" class="form-control" id="logo" name="logo" accept="image/png, image/jpg, image/jpeg" onchange="updateFileName(event)">
          </div>
          <div class="form-control text-center border">
            <img id="imagen-preview" src="../images/<?= $data['logo']; ?>" alt="Vista previa de la imagen">
            <div id="imagen-direccion"></div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary mt-4" name="btnActualizar">Actualizar Informacion</button>
      </form>
    </div>
  </div>
</div>
<script>
  function updateFileName(event) {
    const input = event.target;
    const preview = document.getElementById('imagen-preview');
    const direccion = document.getElementById('imagen-direccion');
    if (input.files.length > 0) {
      direccion.textContent = input.files[0].name;
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.setAttribute('src', e.target.result);
        preview.style.display = 'block';
      };
      reader.readAsDataURL(input.files[0]);
    } else {
      direccion.textContent = 'Coloque los archivos aqui, o navegue';
      preview.style.display = 'none';
    }
  }
</script>