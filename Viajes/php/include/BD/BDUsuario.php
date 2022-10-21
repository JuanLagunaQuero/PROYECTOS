<?php

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require "BD.php";
require $inicio . "include/Entidades/Usuario.php";

class BDUsuario
{
    public static function leeProfesores()
    {
        $sql = ("SELECT `id_usuario`,`nombre`,`apellidos` FROM usuario");
        $resultado = BD::conecta()->query($sql);
        $fila = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $fila;
    }

    public static function existeUsuario($id_usuario, $contrasena)
    {
        if ($resultado = BD::conecta()->query("SELECT * FROM usuario WHERE id_usuario='$id_usuario' AND contrasena='$contrasena'")) {
            $fila = $resultado->fetch();
            return ($fila != null);
        }
    }

    public static function leeUsuario($id_usuario, $contrasena): Usuario
    {
        $sql = ("SELECT * FROM usuario WHERE id_usuario='" . $id_usuario . "'" . " AND contrasena='" . $contrasena . "'");
        $resultado = BD::conecta()->query($sql);
        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $u = new Usuario($registro['id_usuario'], $registro['nombre'], $registro['apellidos'], $registro['contrasena'], $registro['rol'], $registro['ultimoAcceso'],);
        }
        return $u;
    }

    public static function leeUsuarioVisita($id_visita)
    {
        $sql = "SELECT a.id_usuario FROM visita v
                LEFT JOIN alumno_detalle_convenio a
                ON v.id_alumno_detalle_convenio = a.id_alumno_detalle_convenio
                WHERE v.id_visita = $id_visita ";
        $resul = BD::conecta()->query($sql);
        $user = $resul->fetch();
        return $user[0];
    }

    public static function leeUsuarioAlumno($id_alumno_detalle_convenio)
    {
        $sql = "SELECT `id_usuario`
                FROM `alumno_detalle_convenio`
                WHERE `id_alumno_detalle_convenio` = $id_alumno_detalle_convenio";
        $resul = BD::conecta()->query($sql);
        $user = $resul->fetch();
        return $user[0];
    }

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
                    adc.nombre_alumno,
                    adc.revisado                  
                   
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

    public static function reseteaContraseña($id_usuario)
    {
        $contrasena = $id_usuario.$id_usuario;

        $sql = "UPDATE `usuario` SET `contrasena`= '$contrasena' WHERE `id_usuario` = '$id_usuario'";
        BD::conecta()->exec($sql);
    }

    public static function cambioContraseña($id_usuario, $contrasena, $contrasenaNueva)
    {
        $sql = "UPDATE `usuario` SET `contrasena`= '$contrasenaNueva' WHERE `id_usuario` = '$id_usuario' AND `contrasena` = '$contrasena'";
        BD::conecta()->exec($sql);

    }

}
