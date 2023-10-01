<?php

function mostrarVentana($ventana) {
  switch ($ventana) {
    case 'inicio':
      require("component/main.php");
      break;
    case 'usuarios':
      require("usuarios.php");
      break;
    case 'roles':
      require("roles.php");
      break;
    case 'cargos':
      require("cargos.php");
      break;
    case 'areas':
      require("areas.php");
      break;
    case 'empresa':
      require("empresa.php");
      break;
    default:
      require("component/404.php");
      break;
  }
}

