<?php

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require_once $inicio . "include/BD/BDUsuario.php";

$id_usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$contrasenaNueva = $_POST['contrasenaNueva'];

BDUsuario::cambioContraseña($id_usuario, $contrasena, $contrasenaNueva);

$obj = new stdClass();
$obj->sucess = true;
echo json_encode($obj);
