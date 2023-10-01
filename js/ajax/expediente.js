// Read
function cargarDetalleMesas() {
  let rol = $("#rol").val();
  $.ajax({
    type: "POST",
    url: "../model/Mexpediente.php",
    data: {
      dataexpediente: 1,
      rol: rol,
    },
    dataType: "html",
    success: function (response) {
      let datos = JSON.parse(response);
      let contenido = "";
      let estado = "";
      datos.forEach((dato) => {
        if (dato.est == 1) {
          estado = `<span class="badge text-bg-warning">Registrado</span>`;
        }
        if (dato.est == 2) {
          estado = `<span class="badge text-bg-success">Enviado</span>`;
        }
        if (dato.est == 3) {
          estado = `<span class="badge text-bg-danger">Finalizado</span>`;
        }
        contenido += `<tr>
        <td>${dato.id}</td>
        <td>${dato.num}</td>
        <td>${dato.asu}</td>
        <td>${dato.fec}</td>
        <td>${estado}</td>
        <td>
        <a onclick="eliminarMesa('${dato.id}')" class="badge bg-danger">
          <i class="fas fa-trash-alt p-1"></i></a>
        <a onclick="obtenerMesaId('${dato.id}')" class="badge bg-warning">
          <i class="fas fa-edit p-1"></i></a>
        <a onclick="obtenerMesaId('${dato.id}')" class="badge bg-success">
          <i class="fas fa-share-from-square p-1"></i></a>
        </td>
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
function addMesa() {
  let nomMesa = $("#nomMesa").val();
  let cantidadMesa = $("#cantidadMesa").val();
  let ambienteMesa = $("#ambienteMesa").val();
  $.ajax({
    url: "../model/Mexpediente.php",
    type: "POST",
    dataType: "html",
    data: {
      addmesa: 1,
      nomMesa: nomMesa,
      cantidadMesa: cantidadMesa,
      ambienteMesa: ambienteMesa,
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarDetalleMesas();
      $("#nomMesa").val("");
      $("#cantidadMesa").val("");
      $("#campoActivo").removeClass("is-filled");
      $("#campoActivo1").removeClass("is-filled");
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

//Delete
function eliminarMesa(id) {
  swal({
    title: "Se inhabilitara la mesa",
    text: "No se podra realizar acciones",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $.ajax({
        type: "POST",
        url: "../model/Mexpediente.php",
        data: {
          eliminarmesa: 0,
          ideliminarmesa: id,
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
          cargarDetalleMesas();
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

// habilitar
function habilitarMesa(id) {
  swal({
    title: "Se habilitara la mesa",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $.ajax({
        type: "POST",
        url: "../model/Mexpediente.php",
        data: {
          habilitarmesa: 0,
          idhabilitarmesa: id,
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
          cargarDetalleMesas();
        },
        error: function (X) {
          SnackBar({
            message: "No se puede habilitar",
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

//Edit
function editarMesa() {
  let pe = document.getElementById("adisponible");
  let am = document.getElementById("amante");
  let cambioDis = "n";
  if (pe) {
    if (pe.checked == true) {
      cambioDis = "1";
    }
  }
  if (am) {
    if (am.checked == true) {
      cambioDis = "4";
    }
  }
  let ime = $("#ideditarmesa").val();
  let nome = $("#enomMesa").val();
  let dime = cambioDis;
  let came = $("#ecantidadMesa").val();
  let amme = $("#eambienteMesa").val();

  $.ajax({
    url: "../model/Mexpediente.php",
    type: "POST",
    dataType: "html",
    data: {
      editmesa: 1,
      ime: ime,
      nome: nome,
      dime: dime,
      came: came,
      amme: amme,
    },
    success: function (response) {
      SnackBar({
        message: response,
        position: "tr",
        fixed: true,
        status: "success",
        timeout: 4500,
      });
      cargarDetalleMesas();
      $("#ideditarmesa").val("");
      $("#enomMesa").val("");
      $("#ecantidadMesa").val("");
      $("#editarMesa").modal("hide");
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

//Cargar datos al modal
function obtenerMesaId(id) {
  $.ajax({
    type: "POST",
    url: "../model/Mexpediente.php",
    data: {
      obtmesaid: 1,
      idmesa: id,
    },
    dataType: "json",
    success: function (response) {
      $("#ideditarmesa").val(response.id);
      $("#enomMesa").val(response.num);
      if (response.id != 1) {
        if (response.est == 1) {
          estado = ` <label class="pt-1 pe-2">Estado: </label><span class="badge badge-sm bg-gradient-success">Disponible</span>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="amante">
              <label class="custom-control-label" for="customCheck1">Pasar a mantenimiento</label>
            </div>
            `;
        }
      } else {
        if (response.est == 1) {
          estado =
            '<label class="pt-1 pe-2">Estado: </label><span class="badge badge-sm bg-gradient-success">Disponible</span>';
        }
      }
      if (response.est == 2) {
        estado =
          '<label class="pt-1 pe-2">Estado: </label><span class="badge badge-sm bg-gradient-danger">Ocupado</span>';
      }
      if (response.est == 3) {
        estado =
          '<label class="pt-1 pe-2">Estado: </label><span class="badge badge-sm bg-gradient-warning">Procesando</span>';
      }
      if (response.est == 4) {
        estado = `<label class="pt-1 pe-2">Estado: </label><span class="badge badge-sm bg-gradient-secondary">Mantenimiento</span>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="adisponible">
            <label class="custom-control-label" for="customCheck1">Pasar a disponible</label>
          </div>
          `;
      }
      $("#stdoMesa").html(estado);
      $("#ecantidadMesa").val(response.can);
      $("#eambienteMesa").val(response.amb);
      $("#editarMesa").modal("show");
    },
    error: function () {
      SnackBar({
        message: "No se pudo obtener datos de la mesa",
        position: "tr",
        fixed: true,
        status: "danger",
        timeout: 4500,
      });
    },
  });
}

$(document).ready(function () {
  cargarDetalleMesas();
});
