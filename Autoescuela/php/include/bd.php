<?php

require_once('examen-hecho.php');
require_once('examen.php');
require_once('pregunta.php');
require_once('respuesta.php');
require_once('tematica.php');
require_once('usuario.php');
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

    public static function insertaUsuario(Usuario $u)
    {
        self::$con->exec("INSERT INTO `usuario` (`id_usuario`, `correo`, `nombre`, `apellidos`, `contrasena`, `fecha_nacimiento`, `rol`, `foto`) 
        VALUES (NULL, '" .$u->getcorreo(). "', '" . $u->getnombre() . "', '" . $u->getapellidos() . "', 'CONTRASEÑA', '" . $u->getfecha_nacimiento() . "', '" . $u->getrol() ."', NULL)");
    }

    public static function insertaUsuarioConfirmar($usuario)
    {
        $id_confirmar = generateRandomString();

        self::$con->exec("INSERT INTO `usuario_confirmar`(`id`, `id_usuario`, `fecha_vencimiento`)
        VALUES('${id_confirmar}', '".$usuario->getid_usuario()."', (NOW(), INTERVAL 30 MINUTE))");

        $url="localhost/PROYECTOS/Autoescuela/php/confirmar.php";
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
        $mail->Subject    = "Cambiar contraseña";
        // cuerpo
        $mail->MsgHTML('<h1>Entre a este enlace e introduzca su nueva contraseña y una imagen de perfil<h1>
                        <p><a href="'.$url.'">Validar cuenta</a></p>');
        // destinatario$usuario->getcorreo()
        $address = "juanlq9@gmail.com";
        $mail->AddAddress($address, "Test");
        // enviar
        $resul = $mail->Send();
        if(!$resul) {
        echo "Error" . $mail->ErrorInfo;
        } else {
        echo "Enviado";
        } 
    }

    public static function leeUsuario($correo)
    {
        $result = self::$con->query("SELECT * FROM `usuario` WHERE `correo` = '".$correo."'");
        while ($registro = $result->fetch(PDO::FETCH_ASSOC)) 
        {
           $u = new Usuario($registro["id_usuario"], $registro["correo"], $registro["nombre"], $registro["apellidos"], $registro["contrasena"], $registro["fecha_nacimiento"], $registro["rol"], $registro["foto"]);
        }
        return $u->getapellidos();
    }

    public static function actualizaUsuario(Usuario $u)
    {
        self::$con->exec("UPDATE `usuario` SET nombre`=" . $u->getid_usuario() . ", `apellidos`=" . $u->getapellidos() . ",
        `contrasena`=" . $u->getcontraseña() . ", `fecha_nacimiento`=" . $u->getfecha_nacimiento() . ", `foto`=" . $u->getfoto() . " WHERE `id_usuario`=" . $u->getid_usuario());
    }

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
