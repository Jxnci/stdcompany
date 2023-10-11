// Read
function cargarRoles() {
  $.ajax({
    type: "POST",
    url: "../model/Mroles.php",
    async: false,
    data: {
      data: 1,
    },
    dataType: "html",
    success: function (response) {
      let datos = JSON.parse(response);
      let contenido = "";
      datos.forEach((dato) => {
        contenido += `<tr>
        <td>${dato.id}</td>
        <td>${dato.nom}</td>
        <td>
        <a onclick="obtenerRolId('${dato.id}')" class="badge bg-warning">
          <i class="fas fa-edit p-1"></i></a>
        </td>
      </tr>`;
      });

      $("#data_contenido").html(contenido);
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
function agregarRol() {
  let nombre = $("#rol").val();
  $.ajax({
    url: "../model/Mroles.php",
    type: "POST",
    dataType: "html",
    data: {
      agregar: 1,
      nombre: nombre,
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarRoles();
      $("#area").val("");
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

// Edit
function editarRol() {
  let id = $("#rol_id").val();
  let nom = $("#rol_edit").val();
  $.ajax({
    url: "../model/Mroles.php",
    type: "POST",
    dataType: "html",
    data: {
      edit: 1,
      id: id,
      nom: nom,
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarRoles();
      $("#rol_id").val("");
      $("#rol_edit").val("");
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
function obtenerRolId(id) {
  $.ajax({
    type: "POST",
    url: "../model/Mroles.php",
    data: {
      obtenerId: 1,
      id: id,
    },
    dataType: "json",
    success: function (response) {
      $("#rol_id").val(response[0].id);
      $("#rol_edit").val(response[0].nom);
      $("#modalEditar").modal("show");
    },
    error: function () {
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
  cargarRoles();
});
