// Read
function cargarCargos() {
  $.ajax({
    type: "POST",
    url: "../model/Mcargo.php",
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
        <td>${dato.area}</td>
        <td>
        <a onclick="obtenerCargoId('${dato.id}')" class="badge bg-warning">
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
function agregarArea() {
  let nombre = $("#cargo").val();
  let area_id = $("#area_id").val();
  $.ajax({
    url: "../model/Mcargo.php",
    type: "POST",
    dataType: "html",
    data: {
      agregar: 1,
      nombre: nombre,
      area_id: area_id,
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarCargos();
      $("#cargo").val("");
      $("#area_id").val("");
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
function editarArea() {
  let id = $("#cargo_id").val();
  let nom = $("#cargo_edit").val();
  let area_id = $("#area_id_edit").val();
  $.ajax({
    url: "../model/Mcargo.php",
    type: "POST",
    dataType: "html",
    data: {
      edit: 1,
      id: id,
      nom: nom,
      area_id: area_id
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarCargos();
      $("#cargo_id").val("");
      $("#cargo_edit").val("");
      $("#area_id_edit").val();
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
function obtenerCargoId(id) {
  $.ajax({
    type: "POST",
    url: "../model/Mcargo.php",
    data: {
      obtenerId: 1,
      id: id,
    },
    dataType: "json",
    success: function (response) {
      $("#cargo_id").val(response[0].id);
      $("#cargo_edit").val(response[0].nom);
      $("#area_id_edit").val(response[0].area_id);
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
  cargarCargos();
});
