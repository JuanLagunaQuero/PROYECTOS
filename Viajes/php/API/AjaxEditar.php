<?php

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require_once $inicio . "include/Entidades/Sesion.php";
require_once $inicio . "include/BD/BDUsuario.php";
require_once $inicio . "include/BD/BDVisita.php";

Sesion::iniciar();

$id_visita = $_POST['id_visita'];
$fecha_inicio = $_POST['fecha_inicio'];
$hora_inicio = $_POST['hora_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$hora_fin = $_POST['hora_fin'];

//var_dump($_SESSION['usuario']->getRol());

$rol = $_SESSION['usuario']->getRol();

if ($rol == "administrador") {
    if (BDVisita::solapaVisita($fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, BDUsuario::leeUsuarioVisita($id_visita))) {
        BDVisita::editarVisita($fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, $id_visita);

        $obj = new stdClass();
        $obj->sucess = true;
        echo json_encode($obj);
    } else {
        $obj = new stdClass();
        $obj->sucess = false;
        $obj->error = "Hay visitas ya creadas en ese rango de tiempo";
        echo json_encode($obj);
    }
} else {

    if ($_SESSION['usuario']->getId_usuario() == BDUsuario::leeUsuarioVisita($id_visita)) {

        if (BDVisita::solapaVisita($fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, BDUsuario::leeUsuarioVisita($id_visita))) {
            BDVisita::editarVisita($fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, $id_visita);

            $obj = new stdClass();
            $obj->sucess = true;
            echo json_encode($obj);
        } else {
            $obj = new stdClass();
            $obj->sucess = false;
            $obj->error = "Hay visitas ya creadas en ese rango de tiempo";
            echo json_encode($obj);
        }
    } else {
        $obj = new stdClass();
        $obj->sucess = false;
        $obj->error = "No puedes modificar esta visita";
        echo json_encode($obj);
    }
}
