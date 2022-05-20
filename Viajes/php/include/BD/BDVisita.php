<?php

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require_once "BD.php";
require $inicio . "include/Entidades/Visita.php";

class BDVisita
{
    public static function leeAlumnosUsuario($id_usuario)
    {
        $sql = "SELECT
                    e.id_empresa,
                    e.nombre_empresa,
                    s.id_sede,
                    s.descripcion dsede,
                    c.id_convenio,
                    c.fecha_firma,
                    c.descripcion dconvenio,
                    dc.id_detalle_convenio,
                    dc.fecha_inicio,
                    dc.fecha_fin,
                    adc.`id_alumno_detalle_convenio`,
                    adc.nombre_alumno                  
                   
                FROM
                    alumno_detalle_convenio adc
                    JOIN detalle_convenio dc ON
                        adc.id_detalle_convenio = dc.id_detalle_convenio
                    JOIN convenio c ON
                        dc.id_convenio = c.id_convenio
                    JOIN sede s ON
                        s.id_sede = dc.id_sede
                    JOIN empresa e ON
                        e.id_empresa = s.id_empresa
                WHERE 
                    adc.id_usuario = '$id_usuario'
                ORDER BY
                    nombre_empresa,
                    fecha_firma,
                    dsede";
        $resultado = BD::conecta()->query($sql);
        $fila = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $fila;
    }

    public static function leeVisitasAlumno($id_alumno_detalle_convenio)
    {
        $sql = "SELECT * FROM `visita` WHERE `id_alumno_detalle_convenio` = $id_alumno_detalle_convenio";
        $resultado = BD::conecta()->query($sql);
        $fila = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $fila;
    }

    public function insertaVisita($v)
    {
        $sql="";
    }


}
