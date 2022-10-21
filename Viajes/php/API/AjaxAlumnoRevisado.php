<?php

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require_once $inicio . "include/Entidades/Sesion.php";
require_once $inicio . "include/BD/BDAlumno.php";

$id_alumno_detalle_convenio = $_POST['id_alumno_detalle_convenio'];


BDAlumno::alumnoRevisado($id_alumno_detalle_convenio);

$obj = new stdClass();
$obj->sucess = true;
echo json_encode($obj);
