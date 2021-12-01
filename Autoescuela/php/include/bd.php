<?php

require_once('examen-hecho.php');
require_once('examen.php');
require_once('pregunta.php');
require_once('respuesta.php');
require_once('tematica.php');
require_once('usuario.php');
require_once('confirmacion.php');
require "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

class BD
{
    private static $con;
    public static function conecta()
    {
        self::$con = new PDO('mysql:host=localhost;dbname=autoescuela', 'root', '');
    }

    //USUARIO
    public static function insertaUsuario(Usuario $u)
    {
        self::$con->exec("INSERT INTO `usuario` (`id_usuario`, `correo`, `nombre`, `apellidos`, `contrasena`, `fecha_nacimiento`, `rol`, `foto`) 
        VALUES (NULL, '" .$u->getcorreo(). "', '" . $u->getnombre() . "', '" . $u->getapellidos() . "', 'CONTRASEÑA', '" . $u->getfecha_nacimiento() . "', '" . $u->getrol() ."', NULL)");
    }

    public static function leeCorreo($id_usuario)
    {
        $result = self::$con->query("SELECT `correo` FROM `usuario` WHERE `id_usuario`=".$id_usuario);
        while ($registro = $result->fetch(PDO::FETCH_ASSOC))
        {
           $id = $registro['correo'];
        }
        return $id;
    }

    public static function leeUsuario($correo)
    {
        $result = self::$con->query("SELECT * FROM `usuario` WHERE `correo` = '".$correo."'");
        while ($registro = $result->fetch(PDO::FETCH_ASSOC)) 
        {
           $u = new Usuario($registro["id_usuario"], $registro["correo"], $registro["nombre"], $registro["apellidos"], $registro["contrasena"], $registro["fecha_nacimiento"], $registro["rol"], $registro["foto"]);
        }
        return $u;
    }

    public static function actualizaUsuario(Usuario $u)
    {
        self::$con->exec("UPDATE `usuario` SET nombre`=" . $u->getnombre() . ", `apellidos`=" . $u->getapellidos() . ",
        `contrasena`=" . $u->getcontraseña() . ", `fecha_nacimiento`=" . $u->getfecha_nacimiento() . ", `foto`=" . $u->getfoto() . " WHERE `id_usuario`=" . $u->getid_usuario());
    }


    //CONFIRMACION
    public static function leeIdConfirmacion($id_usuario)
    {
        $result = self::$con->query("SELECT `id` FROM `usuario_confirmar` WHERE `id_usuario`=".$id_usuario);
        while ($registro = $result->fetch(PDO::FETCH_ASSOC))
        {
           $id = $registro['id'];
        }
        return $id;
    }

    public static function leeConfirmacion($id)
    {
        $result = self::$con->query("SELECT * FROM usuario_confirmar WHERE `id`='".$id."'");
        while ($registro = $result->fetch(PDO::FETCH_ASSOC))
        {
           $c = new Confirmacion($registro['id'],$registro['id_usuario'],$registro['fecha_vencimiento']);
        }
        return $c;
    }

    public static function insertaUsuarioConfirmar($usuario)
    {
        $id_confirmar = generateRandomString();
        self::$con->exec("INSERT INTO `usuario_confirmar`(`id`, `id_usuario`, `fecha_vencimiento`)
        VALUES('${id_confirmar}','".$usuario->getid_usuario()."',DATE_ADD(NOW(), INTERVAL 30 MINUTE))");

        $id = BD::leeIdConfirmacion($usuario->getid_usuario());

        $url="localhost/PROYECTOS/Autoescuela/php/confirmar.php?id=".$id;
        $mail = new PHPMailer();
        $mail->IsSMTP();
        // cambiar a 0 para no ver mensajes de error
        $mail->SMTPDebug  = 2;                          
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";                 
        $mail->Host       = "smtp.gmail.com";    
        $mail->Port       = 587;                 
        // introducir usuario de google
        $mail->Username   = "autoescuelaproyecto@gmail.com"; 
        // introducir clave
        $mail->Password   = "autoescuelaproyecto123";       
        $mail->SetFrom('autoescuelaproyecto@gmail.com', 'Test');
        // asunto
        $mail->Subject    = "Cambiar contrase&ntilde;a";
        // cuerpo
        $mail->MsgHTML('<h1>Entre a este enlace e introduzca su nueva contraseña y una imagen de perfil<h1>
                        <p><a href="'.$url.'">Validar cuenta</a></p>');
        // destinatario
        $address = $usuario->getcorreo();
        $mail->AddAddress($address, "Test");
        // enviar
        $resul = $mail->Send();

    }

    public static function existeConfirmacion($id)
    {
        $sql = "SELECT * FROM usuario_confirmar WHERE id ='".$id."'";

        if($resultado = self::$con->query($sql))
        {
           $fila = $resultado->fetch();
           return ($fila != null);
        }         
    }

    public static function borraConfirmacion($id)
    {
        self::$con->exec("DELETE FROM `usuario_confirmar` WHERE `id` = " .$id);
    }


    //TEMATICA
    public static function insertaTematica(Tematica $t)
    {
        self::$con->exec("INSERT INTO `tematica`(`id_tematica`, `nombre`) VALUES (NULL,'" . $t->getnombre() . "')");
    }

    public static function leeTematicas(): array
    {
        $tematicas = array();
        $resultado = self::$con->query("SELECT * FROM `tematica`");
        while ($registro = $resultado->fetch()) {
            $t = new Tematica($registro['id_tematica'], $registro['nombre']);
            $tematicas[] = $t;
        }
        return $tematicas;
    }



    public static function insertaPregunta(Pregunta $p)
    {
        
    }
}
