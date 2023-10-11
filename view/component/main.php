<div class="mb-3">
  <div class="card">
    <div class="card-header p-0 position-relative mt-n4 z-index-2">
      <div class="row g-0 my-2 me-2">
        <div class="col-sm-6 col-md-6">
          <h6 class="text-capitalize ps-3 form-control-plaintext">Bandeja de expedientes</h6>
        </div>
        <?php
        if ($_SESSION['id_rol'] == 3) {
          echo '<div class="col-6 col-md-6 text-end">
                  <a class="btn bg-blue-gradient" onclick="mostrarModal()">Nuevo Expediente</a>
                </div>';
        }
        ?>
        <!-- <div class="col-6 col-md-2 text-end">
          <a class="btn bg-blue-gradient" onclick="agregarImagenAPDF()">Agregar Firma</a>
        </div> -->
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
<div class="modal modal-xl fade" tabindex="-1" id="modalNuevo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-deep-gradient text-white">
        <h5 class="modal-title font-weight-normal">Nuevo Expediente</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body bg-deep">
        <div class="row g-3 m-2 p-2 bg-white shadow-sm border rounded">
          <h6>Datos del Expediente</h6>
          <div class="col-md-12">
            <label for="asunto" class="form-label">Asunto</label>
            <textarea type="text" class="form-control" id="asunto" required></textarea>
          </div>
          <div class="col-md-6">
            <label for="cantidad_doc" class="form-label">Cantidad de Documentos</label>
            <input type="number" class="form-control" id="cantidad_doc" required>
          </div>
          <div class="col-md-6">
            <label for="num_folios" class="form-label">Numero de Folios</label>
            <input type="number" class="form-control" id="num_folios" required>
          </div>
          <div class="col-md-12">
            <label for="tramite" class="form-label">Tramite</label>
            <textarea type="text" class="form-control" id="tramite" required></textarea>
          </div>
          <div class="col-md-12">
            <label for="doc_adjunto" class="form-label">Observaciones(doc_adjuntos,etc)</label>
            <textarea type="text" class="form-control" id="doc_adjunto" required></textarea>
          </div>
        </div>

        <div class="row g-3 m-2 mt-4 bg-white p-2 shadow-sm border rounded">
          <h6>Datos del Tramitante</h6>
          <div class="col-md-6">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="email" class="form-control" id="nombres" required>
          </div>
          <div class="col-md-6">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" required>
          </div>
          <div class="col-md-4">
            <label for="dni" class="form-label">DNI</label>
            <input type="number" class="form-control" id="dni" required>
          </div>
          <div class="col-md-4">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" required>
          </div>
          <div class="col-md-4">
            <label for="celular" class="form-label">Celular</label>
            <input type="text" class="form-control" id="celular" required>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary p-2 px-3" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success p-2 px-3" onclick="agregarExpediente()">Registrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-lg fade" tabindex="-1" id="modalEditar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-deep-gradient text-white">
        <h5 class="modal-title font-weight-normal">Editar Expediente</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body bg-deep">
        <div class="row g-3 m-2 p-2 bg-white shadow-sm border rounded">
          <h6>Datos del Expediente</h6>
          <div class="col-md-12">
            <label for="asunto" class="form-label">Asunto</label>
            <textarea type="text" class="form-control" id="asunto_edit" required></textarea>
          </div>
          <div class="col-md-6">
            <label for="cantidad_doc" class="form-label">Cantidad de Documentos</label>
            <input type="number" class="form-control" id="cantidad_doc_edit" required>
          </div>
          <div class="col-md-6">
            <label for="num_folios" class="form-label">Numero de Folios</label>
            <input type="number" class="form-control" id="num_folios_edit" required>
          </div>
          <div class="col-md-12">
            <label for="tramite" class="form-label">Tramite</label>
            <textarea type="text" class="form-control" id="tramite_edit" required></textarea>
          </div>
          <div class="col-md-12">
            <label for="doc_adjunto" class="form-label">Observaciones(doc_adjuntos,etc)</label>
            <textarea type="text" class="form-control" id="doc_adjunto_edit" required></textarea>
          </div>
        </div>

        <div class="row g-3 m-2 mt-4 bg-white p-2 shadow-sm border rounded">
          <h6>Datos del Tramitante</h6>
          <div class="col-md-6">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="email" class="form-control" id="nombres_edit" required>
          </div>
          <div class="col-md-6">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="apellidos_edit" required>
          </div>
          <div class="col-md-4">
            <label for="dni" class="form-label">DNI</label>
            <input type="number" class="form-control" id="dni_edit" required>
          </div>
          <div class="col-md-4">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo_edit" required>
          </div>
          <div class="col-md-4">
            <label for="celular" class="form-label">Celular</label>
            <input type="text" class="form-control" id="celular_edit" required>
          </div>
          <input type="text" id="id" hidden>
          <input type="text" id="tramitante_id" hidden>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary p-2 px-3" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success p-2 px-3" onclick="editarExpediente()">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-lg fade" tabindex="-1" id="modalMovimiento">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-deep-gradient text-white">
        <h5 class="modal-title font-weight-normal">Enviar Expediente</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body bg-deep">

        <div class="d-flex m-2 mb-4 d-none" id="remitente">
          <div class="bg-green-gradient-icon d-none d-md-flex align-items-center p-3 shadow-sm rounded text-white me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="#ffffff">
              <path d="M8 9v-4l8 7-8 7v-4h-8v-6h8zm6-7c-1.787 0-3.46.474-4.911 1.295l.228.2 1.395 1.221c1.004-.456 2.115-.716 3.288-.716 4.411 0 8 3.589 8 8s-3.589 8-8 8c-1.173 0-2.284-.26-3.288-.715l-1.395 1.221-.228.2c1.451.82 3.124 1.294 4.911 1.294 5.522 0 10-4.477 10-10s-4.478-10-10-10z" />
            </svg>
          </div>
          <div class="bg-white shadow-sm border rounded w-100">
            <div class=" px-3 py-2 d-md-flex justify-content-between align-items-center">
              <div class="w-100">
                <div><span class="fw-semibold">Area Remitente:</span> <span id="area_remitente"></span></div>
                <div><span class="fw-semibold">Trabajador:</span> <span id="trabajador"></span> </div>
              </div>
              <div class="w-100">
                <div><span class="fw-semibold">Fecha Enviada:</span> <span id="ultima_fecha"></span></div>
                <div><span class="fw-semibold">Docs./Folios:</span> <span id="docsfolios"></span></div>
              </div>
            </div>
            <div class="px-3 pb-2"><span class="fw-semibold">Observacion:</span> <span id="observacion"></span></div>
          </div>
        </div>

        <div class="row g-3 m-2 p-2 bg-white shadow-sm border rounded">
          <div class="col-md-6">
            <label for="area" class="form-label">Area</label>
            <select class="form-select" name="area" id="area" onchange="cargarUsuarios()">
            </select>
          </div>
          <div class="col-md-6">
            <label for="usuario" class="form-label">Trabajador</label>
            <select class="form-select" name="usuario" id="usuario">
              <option selected>Seleccione un area</option>
            </select>
          </div>
          <div class="col-md-12">
            <label for="observacion_movimiento" class="form-label">Observacion</label>
            <textarea type="text" class="form-control" id="observacion_movimiento" required></textarea>
          </div>
          <input type="text" id="id_usuario" value="<?= $_SESSION['id'] ?>" hidden>
          <input type="text" id="id_rol" value="<?= $_SESSION['id_rol'] ?>" hidden>
          <input type="text" id="id_expediente" hidden>
          <input type="text" id="id_trabajador" hidden>
          <div class="d-flex justify-content-between">
            <button onclick="adjuntardocs()" class="btn btn-primary py-1 px-3">Adjuntar documentos</button>
            <input type="text" class="text-end border-0 style-none" id="fecha" readonly onfocus="false">
          </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <?php
        if ($_SESSION['id_rol'] == 3) {
          echo '<button type="button" class="btn btn-danger p-2 px-3 shadow-secondary" onclick="finalizarTramiteMP()">Finalizar Tramite</button>';
        } else {
          echo '<button type="button" class="btn btn-danger p-2 px-3 shadow-secondary" onclick="finalizarTramite()">Finalizar Tramite</button>';
        }
        ?>

        <div>
          <button type="button" class="btn btn-secondary p-2 px-3 shadow-secondary" data-bs-dismiss="modal">Cancelar</button>

          <?php
          if ($_SESSION['id_rol'] == 3) {
            echo '<button type="button" class="btn btn-success p-2 px-3" onclick="realizarMovimiento()">Enviar</button>';
          } else {
            echo '<button type="button" class="btn btn-success p-2 px-3" onclick="realizarEnvio()">Realizar Envio</button>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-lg fade" tabindex="-1" id="modalDocs">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-deep-gradient text-white">
        <h5 class="modal-title font-weight-normal">Documentos Subidos</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body bg-deep">
        <div class="row g-3 m-2 p-2 bg-white shadow-sm border rounded">
          <div class="col-md-8">
            <label for="usuario" class="form-label">Selecciona un Documento</label>
            <div class="input-group mb-3 border rounded">
              <input type="file" class="form-control" id="pdfFile" name="pdfFile">
            </div>

          </div>
          <div class="col-md-4 d-flex align-items-end mb-3">
            <button onclick="subirPDF()" class="btn btn-primary align-items-end">Subir PDF</button>
          </div>
        </div>

        <div class="row g-3 m-2 mt-4 bg-white p-2 shadow-sm border rounded">
          <h6>Documentos subidos</h6>
          <table class="table align-items-center mb-0 table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th>##</th>
                <th>Documento</th>
                <th>Descargar</th>
              </tr>
            </thead>
            <tbody id="dataDocs">

            </tbody>
          </table>

        </div>

        <input type="text" id="id_exp" hidden>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary p-2 px-3" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- Styles -->
<style>
  .badge {
    text-transform: uppercase;
    color: white !important;
  }
</style>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../js/ajax/expediente.js"></script>

<!-- Manejo de pdf -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="../js/functions/pdf.js"></script> -->