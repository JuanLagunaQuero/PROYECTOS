<?php
require_once "Usuario.php";
require_once "Sesion.php";
require_once "bd.php";
class Login
{
    public static function Identifica($correo,  $contrasena, bool $recuerdame)
    {
        if (self::Existeusuario($correo, $contrasena)) {
            Sesion::iniciar();
            Sesion::escribir('login', $correo);
            if ($recuerdame) {
                setcookie('recuerdame', $correo, time() + 30 * 24 * 60 * 60);
            }
            return true;
        }
        else{
            echo "no existe";
        }
        return false;
    }

    private static function ExisteUsuario($correo, $password=null)
    {
        BD::conecta();
        return BD::existeusuario($correo, $password);
    }

    public static function UsuarioEstaLogueado()
    {
        if (Sesion::leer('login')) {
            return true;
        } else
        if (isset($_COOKIE['recuerdame']) && self::ExisteUsuario($_COOKIE['recuerdame'])) {
            Sesion::iniciar();
            Sesion::escribir('login', $_COOKIE['recuerdame']);
            return true;
        }
        return false;
    }
}
