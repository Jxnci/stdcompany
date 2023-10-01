<?php
require_once "../model/conexion.php";
$db = Conectar::Conexion();
?>
<div class="mb-5 container-fluid">
  <div class="card">
    <div class="card-header p-0 position-relative mt-n4 z-index-2">
      <div class="row g-0 my-2 me-2">
        <div class="col-sm-6 col-md-8">
          <h6 class="text-capitalize ps-3 form-control-plaintext">Mantenimiento de cargos</h6>
        </div>
        <div class="col-6 col-md-4 text-end">
          <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevo">Nueva Cargo</a>
        </div>
      </div>
    </div>
    <div class="card-body px-0 pb-2">
      <div class="table-responsive py-2 p-0 mx-4 ">
        <table id="tablaCargos" class="table align-items-center mb-0 table-bordered table-striped" style="width:100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Area</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="data_contenido">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modals -->
<div class="modal fade" tabindex="-1" id="modalNuevo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal">Nuevo Cargo</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="cargo" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="cargo" placeholder="Nombre del cargo">
        </div>
        <div class="mb-3">
          <label for="area_id" class="form-label">Area perteneciente</label>
          <select id="area_id" name="area_id" class="form-control" required>
            <option value="">Seleccione</option>
            <?php
            $datos = mysqli_query($db, "SELECT * FROM area");
            foreach ($datos as $dato) { ?>
              <option value="<?= $dato['id']; ?>"><?= $dato['nombre']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary p-2 px-3" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success p-2 px-3" onclick="agregarArea()" data-bs-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modalEditar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Editar Cargo</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body row mt-2">
        <div class="mb-3">
          <label for="area" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="cargo_id" hidden>
          <input type="text" class="form-control" id="cargo_edit" placeholder="Nombre del cargo">
        </div>
        <div class="mb-3">
          <label for="cargo" class="form-label">Area perteneciente</label>
          <select id="area_id_edit" name="area_id_edit" class="form-control" required>
            <option value="">Seleccione</option>
            <?php
            $datos = mysqli_query($db, "SELECT * FROM area");
            foreach ($datos as $dato) { ?>
              <option value="<?= $dato['id']; ?>"><?= $dato['nombre']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary p-2 px-3 shadow-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success p-2 px-3" onclick="editarArea()" data-bs-dismiss="modal">Guardar</button>
      </div>
    </div>
  </div>
</div>


<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="../js/ajax/cargos.js"></script>
<script>
  $(document).ready(function() {
    new DataTable('#tablaCargos');
  });
</script>