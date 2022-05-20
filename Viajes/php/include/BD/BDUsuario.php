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

    public static function existeUsuario($id_usuario, $contrasena)
    {
        if ($resultado = BD::conecta()->query("SELECT * FROM usuario WHERE id_usuario='$id_usuario' AND contrasena='$contrasena'")) {
            $fila = $resultado->fetch();
            return ($fila != null);
        }
    }

    public static function leeUsuario($id_usuario, $contrasena): Usuario
    {

        $resultado = BD::conecta()->query("SELECT * FROM usuario WHERE id_usuario='" . $id_usuario . "'" . " AND contrasena='" . $contrasena . "'");
        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $u = new Usuario($registro['id_usuario'], $registro['nombre'], $registro['apellidos'], $registro['contrasena'], $registro['rol'], $registro['ultimoAcceso'],);
        }
        return $u;
    }
}
