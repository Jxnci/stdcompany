<?php
class Conectar {
  public static function Conexion() {
    if (!($link = mysqli_connect("localhost", "root", "1234Janci"))) {
      echo "Error al conectar con el servidor de base de datos.<br/>";
      exit();
    }
    if (!mysqli_select_db($link, "bdstd")) {
      echo "Error al conectar al servidor de BD, no existe la base de datos.<br/>";
      exit();
    } else {
      if (!mysqli_set_charset($link, "utf8")) {
        printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($link));
        exit();
      }
    }
    return $link;
  }
}