<?php

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require_once "BD.php";

class BDAlumno{
    public static function alumnoRevisado($id_alumno_detalle_convenio)
    {
        $sql = ("UPDATE
        `alumno_detalle_convenio`
    SET
        `revisado` = 1
    WHERE
        id_alumno_detalle_convenio =$id_alumno_detalle_convenio ");
        BD::conecta()->exec($sql);
    }

    public static function alumnoNoRevisado($id_alumno_detalle_convenio)
    {
        $sql = ("UPDATE
        `alumno_detalle_convenio`
    SET
        `revisado` = 0
    WHERE
        id_alumno_detalle_convenio =$id_alumno_detalle_convenio ");
        BD::conecta()->exec($sql);
    }
}