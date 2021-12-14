<?php
include("include/bd.php");
include("include/Sesion.php");
include("include/Login.php");

Sesion::iniciar();
if (!Login::UsuarioEstaLogueado()) {
    header("Location: ../login.php");
}
?>