<?php

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require_once $inicio . "include/Entidades/Sesion.php";
require_once $inicio . "include/Entidades/Login.php";
require_once $inicio . "include/BD/BDUsuario.php";
require_once $inicio . "include/BD/BDVisita.php";

Sesion::iniciar();

// Si el usuario es identificado se crea la variable de sesion login
if (Login::UsuarioEstaLogueado()) {
    $id_usuario = Sesion::leer('usuario')->getId_usuario();

    $obj = new stdClass();
    $obj->sucess = true;
    $obj->Empresas = BDVisita::leeAlumnosUsuario($id_usuario);
    for ($i = 0; $i < count($obj->Empresas); $i++) {
        $obj->Empresas[$i]["visitas"] = BDVisita::leeVisitasAlumno($obj->Empresas[$i]["id_alumno_detalle_convenio"]);
    }
    echo json_encode($obj);
} else {
    $obj = new stdClass();
    $obj->sucess = false;
    echo json_encode($obj);
}
