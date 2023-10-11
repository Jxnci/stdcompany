// Read
function cargarUsuarios() {
  $.ajax({
    type: "POST",
    url: "../model/Musuarios.php",
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
        <td>${dato.dni}</td>
        <td>${dato.nom}</td>
        <td>${dato.cel}</td>
        <td>${dato.cor}</td>
        <td>${dato.car}</td>
        <td>${dato.rol}</td>
        <td>
        <a onclick="obtenerUsuarioId('${dato.id}')" class="badge bg-warning">
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
  let nombres = $("#nombres").val();
  let apellidop = $("#apellidop").val();
  let apellidom = $("#apellidom").val();
  let correo = $("#correo").val();
  let dni = $("#dni").val();
  let clave = $("#clave").val();
  let celular = $("#celular").val();
  let rol_id = $("#rol_id").val();
  let area_id = $("#area_id").val();
  let cargo_id = $("#cargo_id").val();
  $.ajax({
    url: "../model/Musuarios.php",
    type: "POST",
    dataType: "html",
    data: {
      agregar: 1,
      nombres: nombres,
      apellidop: apellidop,
      apellidom: apellidom,
      dni: dni,
      correo: correo,
      clave: clave,
      celular: celular,
      area_id: area_id,
      rol_id: rol_id,
      cargo_id: cargo_id,
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarUsuarios();
      $("#nombres").val("");
      $("#apellidop").val("");
      $("#apellidom").val("");
      $("#correo").val("");
      $("#dni").val("");
      $("#clave").val("");
      $("#celular").val("");
      $("#rol_id").val("");
      $("#cargo_id").val("");
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
function editarUsuario() {
  let id = $("#usuario_id").val();
  let nom = $("#nombres_edit").val();
  let app = $("#apellidop_edit").val();
  let apm = $("#apellidom_edit").val();
  let cor = $("#correo_edit").val();
  let dni = $("#dni_edit").val();
  let cel = $("#celular_edit").val();
  let rol = $("#rol_id_edit").val();
  let are = $("#area_id_edit").val();
  let car = $("#cargo_id_edit").val();
  let emp = $("#empresa_id_edit").val();
  $.ajax({
    url: "../model/Musuarios.php",
    type: "POST",
    dataType: "html",
    data: {
      edit: 1,
      id: id,
      nom: nom,
      app: app,
      apm: apm,
      cor: cor,
      dni: dni,
      cel: cel,
      rol: rol,
      are: are,
      car: car,
      emp: emp,
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarUsuarios();
      $("#usuario_id").val("");
      $("#empresa_id_edit").val("");
      cargarComboCargos();
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
function obtenerUsuarioId(id) {
  $.ajax({
    type: "POST",
    url: "../model/Musuarios.php",
    data: {
      obtenerId: 1,
      id: id,
    },
    dataType: "json",
    success: function (response) {
      $("#usuario_id").val(response[0].id);
      $("#nombres_edit").val(response[0].nom);
      $("#apellidop_edit").val(response[0].app);
      $("#apellidom_edit").val(response[0].apm);
      $("#correo_edit").val(response[0].cor);
      $("#dni_edit").val(response[0].dni);
      $("#celular_edit").val(response[0].cel);
      $("#rol_id_edit").val(response[0].rol);
      $("#area_id_edit").val(response[0].are);
      $("#cargo_id_edit").val(response[0].car);
      $("#empresa_id_edit").val(response[0].emp);
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
  cargarUsuarios();
});

// Mas metodos

function cargarCargos() {
  var area_id = $("#area_id").val();
  $.ajax({
    type: "POST",
    url: "../model/Musuarios.php",
    data: {
      select: 1,
      area_id: area_id,
    },
    dataType: "json",
    success: function (response) {
      $("#cargo_id").empty();
      response.forEach((dato) => {
        $("#cargo_id").append(
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
function cargarCargosEdit() {
  var area_id = $("#area_id_edit").val();
  $.ajax({
    type: "POST",
    url: "../model/Musuarios.php",
    data: {
      select: 1,
      area_id: area_id,
    },
    dataType: "json",
    success: function (response) {
      $("#cargo_id_edit").empty();
      response.forEach((dato) => {
        $("#cargo_id_edit").append(
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
function cargarComboCargos() {
  $.ajax({
    type: "POST",
    url: "../model/Musuarios.php",
    data: {
      combo: 1,
    },
    dataType: "json",
    success: function (response) {
      $("#cargo_id_edit").empty();
      response.forEach((dato) => {
        $("#cargo_id_edit").append(
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
