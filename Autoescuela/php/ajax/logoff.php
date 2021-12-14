<?php
include "../include/Sesion.php";
require_once "../include/Login.php";
Sesion::iniciar();
if (!Login::UsuarioEstaLogueado())
{
  header("Location: ../login.php");
}
Sesion::eliminar('login');
Sesion::eliminar('usuario');
Sesion::destruir();
header("Location:../login.php");
?>