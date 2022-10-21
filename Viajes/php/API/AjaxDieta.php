<?php

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require_once $inicio . "include/Entidades/Sesion.php";
require_once $inicio . "include/BD/BDVisita.php";

$id_visita = $_POST['id_visita'];
$id_alumno_detalle_convenio = $_POST['id_alumno_detalle_convenio'];

if (BDVisita::validaDieta($id_alumno_detalle_convenio)) {

    BDVisita::añadeDieta($id_visita);

    $obj = new stdClass();
    $obj->sucess = true;
    echo json_encode($obj);
}else{
    $obj = new stdClass();
            $obj->sucess = false;
            $obj->error = "No se pueden insertar más visitas";
            echo json_encode($obj);
}
