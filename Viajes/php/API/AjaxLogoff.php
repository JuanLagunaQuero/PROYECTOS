<?php
$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require_once $inicio . "include/Entidades/Sesion.php";
require_once $inicio . "include/Entidades/Login.php";

Sesion::iniciar();
Sesion::eliminar('usuario');
Sesion::destruir();

$obj = new stdClass();
$obj->sucess = true;
echo json_encode($obj);
