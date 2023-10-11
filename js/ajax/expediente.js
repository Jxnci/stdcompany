// Read
function cargarExpedientes() {
  $.ajax({
    type: "POST",
    url: "../model/Mexpediente.php",
    async: false,
    data: {
      dataexpediente: 1,
    },
    dataType: "html",
    success: function (response) {
      let datos = JSON.parse(response);
      let contenido = "";
      let estado = "";
      let acciones = "";
      let editar = "";
      let mover = "";
      let ver = "";
      datos.forEach((dato) => {
        var fecha = new Date(dato.fec);
        var anio = fecha.getFullYear();
        if (dato.est == 1) {
          estado = `<span class="badge px-2 py-1  text-bg-success">Registrado</span>`;
          editar = `
          <a onclick="modalMovimiento('${dato.id}')" class="badge bg-success">
            <i class="fas fa-share-from-square p-1"></i></a>
          <a href="../timeline.php?nexpediente=${dato.num}&anio=${anio}" target="_blank" class="badge bg-secondary">
            <i class="fas fa-eye p-1"></i></a>`;
          mover = `<a onclick="obtenerExpedienteId('${dato.id}')" class="badge bg-warning">
          <i class="fas fa-edit p-1"></i></a>`;
          ver = `<a onclick="eliminarExpediente('${dato.id}')" class="badge bg-danger me-1">
          <i class="fas fa-trash-alt p-1"></i>`;
        } else {
          ver = `<a onclick="" class="badge bg-danger opacity-50 me-1">
          <i class="fas fa-trash-alt p-1"></i>`;
          mover = `<a onclick="" class="badge bg-warning opacity-50">
          <i class="fas fa-edit p-1"></i></a>`;
          editar = `
          <a onclick="" class="badge bg-success opacity-50">
            <i class="fas fa-share-from-square p-1"></i></a>
          <a href="../timeline.php?nexpediente=${dato.num}&anio=${anio}" target="_blank" class="badge bg-secondary">
            <i class="fas fa-eye p-1"></i></a>`;
        }
        if (dato.est == 2) {
          estado = `<span class="badge px-2 py-1  text-bg-secondary">Enviado</span>`;
        }
        if (dato.est == 3) {
          estado = `<span class="badge px-2 py-1  text-bg-danger">Finalizado</span>`;
        }

        if (dato.id_rol == 3) {
          acciones = ver + mover + editar;
        }

        if (dato.id_rol == 2) {
          acciones = editar;
        }
        if (dato.id_rol == 1) {
          acciones = mover + editar;
        }

        contenido += `<tr>
                        <td>${dato.id}</td>
                        <td>${dato.num}</td>
                        <td>${dato.asu}</td>
                        <td>${dato.fec}</td>
                        <td>${estado}</td>
                        <td>${acciones}</td>
                      </tr>`;
      });

      $("#data_expediente_contenido").html(contenido);
    },
    error: function (X) {
      SnackBar({
        message: "No se pudo cargar los datos",
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
    },
  });
}
// Add
function agregarExpediente() {
  let camposVacios = [
    $("#asunto"),
    $("#cantidad_doc"),
    $("#num_folios"),
    $("#tramite"),
    $("#doc_adjunto"),
    $("#nombres"),
    $("#apellidos"),
    $("#dni"),
    $("#correo"),
    $("#celular"),
  ];

  for (let i = 0; i < camposVacios.length; i++) {
    if (camposVacios[i].val().length < 1) {
      SnackBar({
        message: "El campo es requerido",
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
      camposVacios[i].focus();
      return false;
    }
  }

  let asunto = $("#asunto").val();
  let cantidad_doc = $("#cantidad_doc").val();
  let num_folios = $("#num_folios").val();
  let tramite = $("#tramite").val();
  let doc_adjunto = $("#doc_adjunto").val();
  let nombres = $("#nombres").val();
  let apellidos = $("#apellidos").val();
  let dni = $("#dni").val();
  let correo = $("#correo").val();
  let celular = $("#celular").val();
  $.ajax({
    url: "../model/Mexpediente.php",
    type: "POST",
    dataType: "html",
    data: {
      agregar: 1,
      asunto: asunto,
      cantidad_doc: cantidad_doc,
      num_folios: num_folios,
      tramite: tramite,
      doc_adjunto: doc_adjunto,
      nombres: nombres,
      apellidos: apellidos,
      dni: dni,
      correo: correo,
      celular: celular,
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarExpedientes();
      $("#modalNuevo").modal("hide");

      $("#asunto").val("");
      $("#cantidad_doc").val("");
      $("#num_folios").val("");
      $("#tramite").val("");
      $("#doc_adjunto").val("");
      $("#nombres").val("");
      $("#apellidos").val("");
      $("#dni").val("");
      $("#correo").val("");
      $("#celular").val("");
    },
    error: function () {
      SnackBar({
        message: "Error al Agregar",
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
    },
  });
}

// Delete
function eliminarExpediente(id) {
  swal({
    title: "Se eliminara el expediente",
    text: "Accion no reversible",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $.ajax({
        type: "POST",
        url: "../model/Mexpediente.php",
        data: {
          eliminar: 1,
          id: id,
        },
        dataType: "html",
        success: function (response) {
          SnackBar({
            message: response,
            position: "tr",
            fixed: true,
            status: "success",
            timeout: 4500,
          });
          cargarExpedientes();
        },
        error: function (X) {
          SnackBar({
            message: "No se puede eliminar",
            position: "tr",
            fixed: true,
            status: "danger",
            timeout: 4500,
          });
        },
      });
    }
  });
}

// Edit
function editarExpediente() {
  let id = $("#id").val();
  let asunto = $("#asunto_edit").val();
  let cantidad_doc = $("#cantidad_doc_edit").val();
  let num_folios = $("#num_folios_edit").val();
  let tramite = $("#tramite_edit").val();
  let doc_adjunto = $("#doc_adjunto_edit").val();
  let tramitante_id = $("#tramitante_id").val();
  let nombres = $("#nombres_edit").val();
  let apellidos = $("#apellidos_edit").val();
  let dni = $("#dni_edit").val();
  let correo = $("#correo_edit").val();
  let celular = $("#celular_edit").val();

  $.ajax({
    url: "../model/Mexpediente.php",
    type: "POST",
    dataType: "html",
    data: {
      edit: 1,
      id: id,
      asunto: asunto,
      cantidad_doc: cantidad_doc,
      num_folios: num_folios,
      tramite: tramite,
      doc_adjunto: doc_adjunto,
      tramitante_id: tramitante_id,
      nombres: nombres,
      apellidos: apellidos,
      dni: dni,
      correo: correo,
      celular: celular,
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarExpedientes();
      $("#id").val("");
      $("#asunto_edit").val("");
      $("#cantidad_doc_edit").val("");
      $("#num_folios_edit").val("");
      $("#tramite_edit").val("");
      $("#doc_adjunto_edit").val("");
      $("#tramitante_id").val("");
      $("#nombres_edit").val("");
      $("#apellidos_edit").val("");
      $("#dni_edit").val("");
      $("#correo_edit").val("");
      $("#celular_edit").val("");
      $("#modalEditar").modal("hide");
    },
    error: function () {
      SnackBar({
        message: "Error al Editar",
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
    },
  });
}

// Read ID
function obtenerExpedienteId(id) {
  $.ajax({
    type: "POST",
    url: "../model/Mexpediente.php",
    data: {
      obtenerId: 1,
      id: id,
    },
    dataType: "json",
    success: function (response) {
      $("#id").val(response[0].id);
      $("#asunto_edit").val(response[0].asunto);
      $("#cantidad_doc_edit").val(response[0].cantidad_doc);
      $("#num_folios_edit").val(response[0].num_folios);
      $("#tramite_edit").val(response[0].tramite);
      $("#doc_adjunto_edit").val(response[0].doc_adjunto);
      $("#tramitante_id").val(response[0].tramitante_id);
      $("#nombres_edit").val(response[0].nombres);
      $("#apellidos_edit").val(response[0].apellidos);
      $("#dni_edit").val(response[0].dni);
      $("#correo_edit").val(response[0].correo);
      $("#celular_edit").val(response[0].celular);
      $("#modalEditar").modal("show");
    },
    error: function (error) {
      console.log(error);
      SnackBar({
        message: "No se pudo obtener los datos",
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
    },
  });
}

$(document).ready(function () {
  cargarExpedientes();
  cargarComboAreas(); 
});

// Metodos manejo de movimientos

function mostrarModal() {
  $("#modalNuevo").modal("show");
}

function modalMovimiento(id) {
  const fechaActual = new Date();
  const opcionesFecha = {
    timeZone: "America/Lima",
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
  };
  const fechaFormateada = fechaActual.toLocaleString("es-PE", opcionesFecha);
  $("#fecha").val(fechaFormateada);
  $("#id_expediente").val(id);
  $.ajax({
    type: "POST",
    url: "../model/Mexpediente.php",
    data: {
      consultaMovimiento: 1,
      id: id,
    },
    dataType: "json",
    success: function (response) {
      let id_rol = $("#id_rol").val();
      if (id_rol != 3) {
        document.getElementById("remitente").classList.remove("d-none");
        $("#area_remitente").text(response[0].area);
        $("#trabajador").text(response[0].trabajador);
        $("#ultima_fecha").text(response[0].fecha);
        $("#docsfolios").text(
          response[0].cantidad_doc + "/" + response[0].num_folios
        );
        $("#observacion").text(response[0].observacion);
        $("#id_trabajador").val(response[0].usuario_id);
      }
      $("#modalMovimiento").modal("show");
    },
    error: function (error) {
      console.log(error);
      SnackBar({
        message: "No se pudo obtener los datos",
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
    },
  });
}

function realizarMovimiento() {
  let camposVacios = [$("#usuario"), $("#observacion_movimiento")];

  for (let i = 0; i < camposVacios.length; i++) {
    if (camposVacios[i].val().length < 1) {
      SnackBar({
        message: "El campo es requerido",
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
      camposVacios[i].focus();
      return false;
    }
  }

  let usuario = $("#usuario").val();
  let observacion_movimiento = $("#observacion_movimiento").val();
  let id_expediente = $("#id_expediente").val();
  let fecha = $("#fecha").val();

  $.ajax({
    url: "../model/Mexpediente.php",
    type: "POST",
    dataType: "html",
    data: {
      registrarMovimiento: 1,
      usuario: usuario,
      observacion_movimiento: observacion_movimiento,
      id_expediente: id_expediente,
      fecha: fecha,
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarExpedientes();
      $("#modalMovimiento").modal("hide");
      $("#usuario").val("");
      $("#observacion_movimiento").val("");
      $("#id_expediente").val("");
    },
    error: function () {
      SnackBar({
        message: "Error al Agregar",
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
    },
  });
}

function mostrarOpcion() {
  let estado = document.getElementById("estado").value;
  let finalizar = document.getElementById("finalizar");
  let enviar = document.getElementById("enviar");
  if (estado == 1) {
    enviar.classList.remove("hidden");
  } else {
    finalizar.classList.remove("hidden");
  }
}

function cargarUsuarios() {
  var area_id = $("#area").val();
  var id_usuario = $("#id_usuario").val();

  $.ajax({
    type: "POST",
    url: "../model/Mexpediente.php",
    data: {
      comboUsuario: 1,
      area_id: area_id,
    },
    dataType: "json",
    success: function (response) {
      $("#usuario").empty();
      response.forEach((dato) => {
        if (dato.id != id_usuario) {
          $("#usuario").append(
            '<option value="' +
              dato.id +
              '">' +
              dato.nom +
              "(" +
              dato.car +
              ")</option>"
          );
        }
      });
    },
    error: function (error) {
      SnackBar({
        message: error,
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
    },
  });
}

function cargarComboAreas() {
  $.ajax({
    type: "POST",
    url: "../model/Mexpediente.php",
    data: {
      comboArea: 1,
    },
    dataType: "json",
    success: function (response) {
      $("#area").empty();
      response.forEach((dato) => {
        $("#area").append(
          '<option value="' + dato.id + '">' + dato.nom + "</option>"
        );
      });
    },
    error: function (error) {
      SnackBar({
        message: error,
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
    },
  });
}

function realizarEnvio() {
  let camposVacios = [$("#usuario"), $("#observacion_movimiento")];

  for (let i = 0; i < camposVacios.length; i++) {
    if (camposVacios[i].val().length < 1) {
      SnackBar({
        message: "El campo es requerido",
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
      camposVacios[i].focus();
      return false;
    }
  }

  let usuario = $("#usuario").val();
  let observacion_movimiento = $("#observacion_movimiento").val();
  let id_expediente = $("#id_expediente").val();
  let id_usuario = $("#id_usuario").val();
  let id_trabajador = $("#id_trabajador").val();
  let fecha = $("#fecha").val();
  console.log("usuario" + usuario);
  console.log("observacion_movimiento" + observacion_movimiento);
  console.log("id_expediente" + id_expediente);
  console.log("id_usuario" + id_usuario);
  console.log("id_trabajador" + id_trabajador);

  $.ajax({
    url: "../model/Mexpediente.php",
    type: "POST",
    dataType: "html",
    data: {
      realizarMovimiento: 1,
      usuario: usuario,
      observacion_movimiento: observacion_movimiento,
      id_expediente: id_expediente,
      id_usuario: id_usuario,
      id_trabajador: id_trabajador,
      fecha: fecha,
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarExpedientes();
      $("#modalMovimiento").modal("hide");
      $("#usuario").val("");
      $("#observacion_movimiento").val("");
      $("#id_expediente").val("");
    },
    error: function () {
      SnackBar({
        message: "Error al Agregar",
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
    },
  });
}

function finalizarTramite() {
  swal({
    title: "Esta seguro de finalizar este tramite",
    text: "Se enviara al creador del tramite como finalizado",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      let observacion_movimiento = $("#observacion_movimiento").val();
      let id_expediente = $("#id_expediente").val();
      let id_trabajador = $("#id_trabajador").val();
      let fecha = $("#fecha").val();
      let id_usuario = $("#id_usuario").val();
      $.ajax({
        url: "../model/Mexpediente.php",
        type: "POST",
        dataType: "html",
        data: {
          finalizarMovimiento: 1,
          observacion_movimiento: observacion_movimiento,
          id_expediente: id_expediente,
          id_trabajador: id_trabajador,
          fecha: fecha,
          id_usuario: id_usuario,
        },
        success: function (response) {
          SnackBar({
            message: response,
            position: "tr",
            fixed: true,
            status: "success",
            timeout: 4500,
          });
          cargarExpedientes();
          $("#modalMovimiento").modal("hide");
          $("#observacion_movimiento").val("");
          $("#id_expediente").val("");
        },
        error: function () {
          SnackBar({
            message: "Error al Agregar",
            position: "tr",
            fixed: true,
            status: "danger",
            timeout: 4500,
          });
        },
      });
    }
  });
}
function finalizarTramiteMP() {
  swal({
    title: "Esta seguro de finalizar este tramite",
    text: "No se enviara a nadie",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      let id_expediente = $("#id_expediente").val();
      $.ajax({
        url: "../model/Mexpediente.php",
        type: "POST",
        dataType: "html",
        data: {
          finalizarTramiteMPP: 1,
          id_expediente: id_expediente,
        },
        success: function (response) {
          SnackBar({
            message: response,
            position: "tr",
            fixed: true,
            status: "success",
            timeout: 4500,
          });
          cargarExpedientes();
          $("#modalMovimiento").modal("hide");
        },
        error: function () {
          SnackBar({
            message: "Error al modificar",
            position: "tr",
            fixed: true,
            status: "danger",
            timeout: 4500,
          });
        },
      });
    }
  });
}

// Subir PDf
function adjuntardocs() {
  $("#modalDocs").modal("show");
  $("#id_exp").val($("#id_expediente").val());
  dataDocs();
}

function dataDocs() {
  let id_expediente = $("#id_exp").val();
  $.ajax({
    type: "POST",
    url: "../model/Mexpediente.php",
    data: {
      dataDocs: 1,
      id_expediente: id_expediente,
    },
    dataType: "text",
    success: function (response) {
      console.log(response);
      let contenido = "";
      let datos = JSON.parse(response);
      datos.forEach((dato) => {
        contenido += `<tr>
          <td>${dato.id}</td>
          <td>${dato.nom}</td>
          <td><a href="../docs/${dato.nom}" class="btn btn-danger" download>Descargar PDF</a>
          <a href="../docs/${dato.nom}" class="btn btn-success" target="_blanck">Ver PDF</a></td>
        </tr>`;
      });

      $("#dataDocs").html(contenido);
    },
    error: function (X) {
      SnackBar({
        message: "No se pudo cargar los datos",
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
    },
  });
}

function subirPDF() {
  var fileData = $("#pdfFile").prop("files")[0];
  let id_expediente = $("#id_exp").val();
  var formData = new FormData();
  formData.append("pdfFile", fileData);
  formData.append("id_expediente", id_expediente);

  $.ajax({
    url: "../model/Mpdf.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      console.log(response);
      alert("PDF subido correctamente.");
      dataDocs();
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
      alert("Error al subir el PDF.");
    },
  });
}
