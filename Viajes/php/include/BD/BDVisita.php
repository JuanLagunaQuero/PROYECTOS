<?php

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require_once "BD.php";

class BDVisita
{

    public static function leeVisitasAlumno($id_alumno_detalle_convenio)
    {
        $sql = "SELECT * FROM `visita` WHERE `id_alumno_detalle_convenio` = $id_alumno_detalle_convenio";
        $resultado = BD::conecta()->query($sql);
        $fila = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $fila;
    }

    public static function insertaVisita($fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, $id_alumno_detalle_convenio)
    {
        BD::conecta()->beginTransaction();

        $sql = "INSERT INTO `visita`(`id_visita`, `fecha_inicio`, `hora_inicio`, `fecha_fin`, `hora_fin`, `id_alumno_detalle_convenio`, `dieta`)
                VALUES (NULL, '" . $fecha_inicio . "', '" . $hora_inicio . "', '" . $fecha_fin . "', '" . $hora_fin . "', $id_alumno_detalle_convenio, 0)";
        BD::conecta()->exec($sql);

        $resultado = BD::conecta()->query("SELECT max(`id_visita`) FROM `visita`");
        BD::conecta()->commit();
        $fila = $resultado->fetch();
        return $fila[0];
    }

    public static function borraVisita($id_visita)
    {
        $sql = "DELETE FROM `visita` WHERE `id_visita` = $id_visita";
        BD::conecta()->exec($sql);
    }

    public static function editarVisita($fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, $id_visita)
    {
        $sql = "UPDATE `visita` SET `fecha_inicio`='" . $fecha_inicio . "',`hora_inicio`='" . $hora_inicio . "',
                `fecha_fin`='" . $fecha_fin . "',`hora_fin`='" . $hora_fin . "' 
                WHERE id_visita = $id_visita";
        BD::conecta()->exec($sql);
    }

    public static function solapaVisita($fecha_inicio, $hora_inicio, $fecha_fin, $hora_fin, $id_usuario)
    {
        $sql = "SELECT
                    COUNT(*)
                    FROM
                    (
                    SELECT
                        visita.fecha_inicio,
                        visita.hora_inicio,
                        visita.fecha_fin,
                        visita.hora_fin
                    FROM
                        `visita`
                    JOIN alumno_detalle_convenio ON visita.id_alumno_detalle_convenio = alumno_detalle_convenio.id_alumno_detalle_convenio
                    WHERE
                        alumno_detalle_convenio.id_usuario = '$id_usuario'
                    ) AS a

                    WHERE
                        (
                            #comprobamos que fecha inicio queda entre fecha inicio y fecha fin
                            (
                                TO_SECONDS('" . $fecha_inicio . " " . $hora_inicio . "') >= TO_SECONDS(a.fecha_inicio) + TO_SECONDS(a.hora_inicio) - TO_SECONDS(CURDATE())
                                AND TO_SECONDS('" . $fecha_inicio . " " . $hora_inicio . "') <= TO_SECONDS(a.fecha_fin) + TO_SECONDS(a.hora_fin) - TO_SECONDS(CURDATE())
                            ) OR
                            #comprobamos que fecha fin queda entre fecha inicio y fecha fin
                            (
                                TO_SECONDS('" . $fecha_fin . " " . $hora_fin . "') >= TO_SECONDS(a.fecha_inicio) + TO_SECONDS(a.hora_inicio)  - TO_SECONDS(CURDATE())
                                AND TO_SECONDS('" . $fecha_fin . " " . $hora_fin . "') <= TO_SECONDS(a.fecha_fin) + TO_SECONDS(a.hora_fin) - TO_SECONDS(CURDATE())
                            ) OR
                            #comprobamos que las dos quedan entre fecha inicio y fecha fin
                            (
                                TO_SECONDS('" . $fecha_inicio . " " . $hora_inicio . "') <= TO_SECONDS(a.fecha_inicio) + TO_SECONDS(a.hora_inicio)  - TO_SECONDS(CURDATE())
                                AND TO_SECONDS('" . $fecha_fin . " " . $hora_fin . "') >= TO_SECONDS(a.fecha_fin) + TO_SECONDS(a.hora_fin) - TO_SECONDS(CURDATE())
                            )
                        )";
        $resultado = BD::conecta()->query($sql);
        $fila = $resultado->fetch();
        return ($fila [0] == 0);
    }
}
