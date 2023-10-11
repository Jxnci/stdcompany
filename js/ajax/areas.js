// Read
function cargarAreas() {
  $.ajax({
    type: "POST",
    url: "../model/Marea.php",
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
        <a onclick="obtenerAreaId('${dato.id}')" class="badge bg-warning">
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
  let nombre = $("#area").val();
  $.ajax({
    url: "../model/Marea.php",
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
      cargarAreas();
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
function editarArea() {
  let id = $("#area_id").val();
  let nom = $("#area_edit").val();
  $.ajax({
    url: "../model/Marea.php",
    type: "POST",
    dataType: "html",
    data: {
      edit: 1,
      id: id,
      nom: nom
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarAreas();
      $("#area_id").val("");
      $("#area_edit").val("");
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
function obtenerAreaId(id) {
  $.ajax({
    type: "POST",
    url: "../model/Marea.php",
    data: {
      obtenerId: 1,
      id: id,
    },
    dataType: "json",
    success: function (response) {
      $("#area_id").val(response[0].id);
      $("#area_edit").val(response[0].nom);
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
  cargarAreas();
});
