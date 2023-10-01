<div class="mb-5 container-fluid">
  <div class="card">
    <div class="card-header p-0 position-relative mt-n4 z-index-2">
      <div class="row g-0 my-2 me-2">
        <div class="col-sm-6 col-md-8">
          <h6 class="text-capitalize ps-3 form-control-plaintext">Bandeja de expedientes</h6>
        </div>
        <div class="col-6 col-md-4 text-end">
          <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevo">Nuevo Expediente</a>
          <input type="text" id="rol" value="<?= $_SESSION['rol']; ?>" hidden>
        </div>
      </div>
    </div>
    <div class="card-body px-0 pb-2">
      <div class="table-responsive py-2 p-0 mx-4 ">
        <table id="tablaExpedientes" class="table align-items-center mb-0 table-bordered table-striped" style="width:100%">
          <thead>
            <tr>
              <th>#</th>
              <th>N.Exp.</th>
              <th>Asunto</th>
              <th>Fecha</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="data_expediente_contenido">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modals -->
<div class="modal modal-lg fade" tabindex="-1" id="modalNuevo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal">Nuevo Usuario</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-4">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="nombres" required>
          </div>
          <div class="col-md-4">
            <label for="apellidop" class="form-label">Apellido Paterno</label>
            <input type="text" class="form-control" id="apellidop" required>
          </div>
          <div class="col-md-4">
            <label for="apellidom" class="form-label">Apellido Materno</label>
            <input type="text" class="form-control" id="apellidom" required>
          </div>

          <div class="col-md-6">
            <label for="dni" class="form-label">DNI</label>
            <input type="number" class="form-control" id="dni" required>
          </div>
          <div class="col-md-6">
            <label for="celular" class="form-label">Celular</label>
            <input type="text" class="form-control" id="celular" required>
          </div>

          <div class="col-md-8">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" required>
          </div>
          <div class="col-md-4">
            <label for="clave" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="clave" required>
          </div>

          <div class="col-md-4">
            <label for="rol_id" class="form-label">Rol</label>
            <select id="rol_id" name="rol_id" class="form-control" required>
              <option value="">Seleccione</option>

            </select>
          </div>
          <div class="col-md-4">
            <label for="area_id" class="form-label">Area</label>
            <select id="area_id" name="area_id" class="form-control" required onchange="cargarCargos()">
              <option value="">Seleccione</option>

            </select>
          </div>
          <div class="col-md-4">
            <label for="cargo_id" class="form-label">Cargo</label>
            <select id="cargo_id" name="cargo_id" class="form-control" required>
              <option value="">Seleccione un area</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary p-2 px-3" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success p-2 px-3" onclick="agregarArea()" data-bs-dismiss="modal">Agregar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-lg fade" tabindex="-1" id="modalEditar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Editar Cargo</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body row mt-2">
        <div class="row g-3">
          <input type="text" id="usuario_id" hidden>
          <input type="text" id="empresa_id_edit" hidden>
          <div class="col-md-4">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="nombres_edit" required>
          </div>
          <div class="col-md-4">
            <label for="apellidop" class="form-label">Apellido Paterno</label>
            <input type="text" class="form-control" id="apellidop_edit" required>
          </div>
          <div class="col-md-4">
            <label for="apellidom" class="form-label">Apellido Materno</label>
            <input type="text" class="form-control" id="apellidom_edit" required>
          </div>

          <div class="col-md-6">
            <label for="dni" class="form-label">DNI</label>
            <input type="number" class="form-control" id="dni_edit" required>
          </div>
          <div class="col-md-6">
            <label for="celular" class="form-label">Celular</label>
            <input type="text" class="form-control" id="celular_edit" required>
          </div>

          <div class="col-md-12">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo_edit" required>
          </div>

          <div class="col-md-4">
            <label for="rol_id" class="form-label">Rol</label>
            <select id="rol_id_edit" name="rol_id_edit" class="form-control" required>
              <option value="">Seleccione</option>

            </select>
          </div>
          <div class="col-md-4">
            <label for="area_id" class="form-label">Area</label>
            <select id="area_id_edit" name="area_id_edit" class="form-control" required onchange="cargarCargosEdit()">
              <option value="">Seleccione</option>

            </select>
          </div>
          <div class="col-md-4">
            <label for="cargo_id" class="form-label">Cargo</label>
            <select id="cargo_id_edit" name="cargo_id_edit" class="form-control" required>

            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary p-2 px-3 shadow-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success p-2 px-3" onclick="editarUsuario()" data-bs-dismiss="modal">Guardar</button>
      </div>
    </div>
  </div>
</div>


<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="../js/ajax/expediente.js"></script>
<script>
  $(document).ready(function() {
    new DataTable('#tablaExpedientes');
  });
</script>