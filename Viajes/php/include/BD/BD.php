<?php
class BD
{
    private static $con=null;

    public static function conecta()
    {
        if (self::$con == null) {
            self::$con = new PDO('mysql:host=localhost;dbname=viajes', 'root', '');
            self::$con->query("SET NAMES utf8");
        } 
        return self::$con;

    }
}
?>