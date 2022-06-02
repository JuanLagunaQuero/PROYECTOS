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

$fecha_inicio = $_POST['fecha_inicio'];
$hora_inicio = $_POST['hora_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$hora_fin = $_POST['hora_fin'];
$id_alumno_detalle_convenio = $_POST['id_alumno_detalle_convenio'];

$rol = $_SESSION['usuario']->getRol();


if ($rol == "administrador")
{
    if(BDVisita::solapaVisita($fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, BDUsuario::leeUsuarioAlumno($id_alumno_detalle_convenio)))
        {
            $obj = new stdClass();
            $obj->sucess = true;
            $obj->id_visita = BDVisita::insertaVisita($fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, $id_alumno_detalle_convenio);;
            echo json_encode($obj);
        }
        else{
            $obj = new stdClass();
            $obj->sucess = false;
            $obj->error="Hay visitas ya creadas en ese rango de tiempo";
            echo json_encode($obj);
        }
}
else{

    if ($_SESSION['usuario']->getId_usuario() == BDUsuario::leeUsuarioAlumno($id_alumno_detalle_convenio))
    {
        if(BDVisita::solapaVisita($fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, BDUsuario::leeUsuarioAlumno($id_alumno_detalle_convenio)))
        {
            $obj = new stdClass();
            $obj->sucess = true;
            $obj->id_visita = BDVisita::insertaVisita($fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, $id_alumno_detalle_convenio);;
            echo json_encode($obj);
        }
        else{
            $obj = new stdClass();
            $obj->sucess = false;
            $obj->error="Hay visitas ya creadas en ese rango de tiempo";
            echo json_encode($obj);
        }
    }
    else
    {
        $obj = new stdClass();
        $obj->sucess = false;
        $obj->error="No puedes insertar visitas de este alumno";
        echo json_encode($obj);
    }
}
