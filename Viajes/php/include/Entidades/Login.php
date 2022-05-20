<?php
require_once "Sesion.php";

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require $inicio . "include/BD/BDUsuario.php";
Class Login
{
    public static function Identifica($id_usuario, $contrasena)
    {
        if (self::Existeusuario($id_usuario, $contrasena)) {
            Sesion::iniciar();
            Sesion::escribir('login', $id_usuario);

            return true;
        } 
        return false;
    }

    private static function ExisteUsuario($id_usuario, $contrasena = null)
    {
        BD::conecta();
        return BDUsuario::existeusuario($id_usuario, $contrasena);
    }

    public static function UsuarioEstaLogueado()
    {
        if (Sesion::leer('login')) {
            return true;
        } 
        return false;
    }
}
