<?php

require_once('Examen-Pregunta.php');
require_once('Examen-hecho.php');
require_once('Examen.php');
require_once('Pregunta.php');
require_once('Respuesta.php');
require_once('Tematica.php');
require_once('Usuario.php');
require_once('Confirmacion.php');
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
        $tildes = self::$con->query("SET NAMES utf8");
    }


    //USUARIO
    public static function insertaUsuario(Usuario $u)
    {
        self::$con->exec("INSERT INTO `usuario` (`id_usuario`, `correo`, `nombre`, `apellidos`, `contrasena`, `fecha_nacimiento`, `rol`, `foto`) 
        VALUES (NULL, '" . $u->getcorreo() . "', '" . $u->getnombre() . "', '" . $u->getapellidos() . "', 'CONTRASENA', '" . $u->getfecha_nacimiento() . "', '" . $u->getrol() . "', NULL)");
    }

    public static function leeCorreo($id_usuario)
    {
        $result = self::$con->query("SELECT `correo` FROM `usuario` WHERE `id_usuario`=" . $id_usuario);
        while ($registro = $result->fetch(PDO::FETCH_ASSOC)) {
            $correo = $registro['correo'];
        }
        return $correo;
    }

    public static function rolUsuario($correo)
    {
        $result = self::$con->query("SELECT `rol` FROM `usuario` WHERE correo = '$correo'");
        while ($registro = $result->fetch(PDO::FETCH_ASSOC)) {
            $rol = $registro['rol'];
        }
        return $rol;
    }

    public static function leeUsuarios()
    {
        $usuarios = array();
        $resultado = self::$con->query("SELECT * FROM `usuario`");
        while ($registro = $resultado->fetch()) {
            $u = new Usuario(
                $registro['id_usuario'],
                $registro['correo'],
                $registro['nombre'],
                $registro['apellidos'],
                $registro['contrasena'],
                date($registro['fecha_nacimiento']),
                $registro['rol'],
                $registro['foto'],
            );
            $usuarios[] = $u;
        }
        return $usuarios;
    
    }

    public static function obtieneUsuariosPaginados(int $pagina, int $filas):array
    {
        $registros = array();
        $res = self::$con->query("SELECT * FROM `usuario`");
        $registros =$res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total /$filas);
        $registros = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $res= self::$con->query("SELECT * FROM `usuario` limit $inicio, $filas");
            $registros = $res->fetchAll(PDO::FETCH_ASSOC);
        }
        return $registros;
    }

    public static function cuentaExamenesHechos($id_usuario)
    {
        $result = self::$con->query("SELECT COUNT(*) FROM `examen-hecho` WHERE `id_alumno` = '".$id_usuario."'");
        return $result;
    }

    public static function leeUsuario($correo)
    {
        $result = self::$con->query("SELECT * FROM `usuario` WHERE `correo` = '" . $correo . "'");
        while ($registro = $result->fetch(PDO::FETCH_ASSOC)) {
            $u = new Usuario($registro["id_usuario"], $registro["correo"], $registro["nombre"], $registro["apellidos"], $registro["contrasena"], $registro["fecha_nacimiento"], $registro["rol"], $registro["foto"]);
        }
        return $u;
    }

    public static function existeusuario($correo, $contrasena)
    {

        $sql = "SELECT * FROM `usuario` WHERE `correo` LIKE '$correo' AND `contrasena` LIKE '$contrasena'";

        if ($resultado = self::$con->query($sql)) {
            $fila = $resultado->fetch();
            return ($fila != null);
        }
    }

    public static function actualizaUsuario($id, $nombre, $apellidos, $contrasena, $fecha_nacimiento, $foto)
    {
        self::$con->exec("UPDATE `usuario` SET `nombre`= '$nombre', `apellidos`= '$apellidos',
        `contrasena`='$contrasena', `fecha_nacimiento`= '$fecha_nacimiento', `foto`='$foto' WHERE `id_usuario`=$id");
    }


    //CONFIRMACION
    public static function leeIdConfirmacion($id_usuario)
    {
        $result = self::$con->query("SELECT `id` FROM `usuario_confirmar` WHERE `id_usuario`=" . $id_usuario);
        while ($registro = $result->fetch(PDO::FETCH_ASSOC)) {
            $id = $registro['id'];
        }
        return $id;
    }

    public static function leeConfirmacion($id)
    {
        $result = self::$con->query("SELECT * FROM usuario_confirmar WHERE `id`='" . $id . "'");
        while ($registro = $result->fetch(PDO::FETCH_ASSOC)) {
            $c = new Confirmacion($registro['id'], $registro['id_usuario'], $registro['fecha_vencimiento']);
        }
        return $c;
    }

    public static function insertaUsuarioConfirmar($usuario)
    {
        $id_confirmar = generateRandomString();
        self::$con->exec("INSERT INTO `usuario_confirmar`(`id`, `id_usuario`, `fecha_vencimiento`)
        VALUES('${id_confirmar}','" . $usuario->getid_usuario() . "',DATE_ADD(NOW(), INTERVAL 30 MINUTE))");

        $id = BD::leeIdConfirmacion($usuario->getid_usuario());

        $url = "localhost/PROYECTOS/Autoescuela/php/ajax/confirmarAlta.php?id=" . $id;
        $mail = new PHPMailer();
        $mail->IsSMTP();
        // cambiar a 0 para no ver mensajes de error
        $mail->SMTPDebug  = 2;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 465;
        // introducir usuario de google
        $mail->Username   = "autoescuelaproyecto@gmail.com";
        // introducir clave
        $mail->Password   = "autoescuelaproyecto123";
        $mail->SetFrom('autoescuelaproyecto@gmail.com', 'Test');
        // asunto
        $mail->Subject    = "Cambiar contrasena";
        // cuerpo
        $mail->MsgHTML('<h1>Entre a este enlace e introduzca su nueva contraseña y una imagen de perfil<h1>
                        <p><a href="' . $url . '">Validar cuenta</a></p>');
        // destinatario
        $address = $usuario->getcorreo();
        $mail->AddAddress($address, "Test");
        // enviar
        $resul = $mail->Send();
    }

    public static function existeConfirmacion($id)
    {
        $sql = "SELECT * FROM usuario_confirmar WHERE id ='" . $id . "'";

        if ($resultado = self::$con->query($sql)) {
            $fila = $resultado->fetch();
            return ($fila != null);
        }
    }

    public static function borraConfirmacion($id_usuario)
    {
        self::$con->exec("DELETE FROM `usuario_confirmar` WHERE `id_usuario` = " . $id_usuario);
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

    //PREGUNTAS
    public static function insertaPregunta(Pregunta $p)
    {
        self::$con->exec("INSERT INTO `pregunta` (`id_pregunta`, `enunciado`, `id_tematica`, `id_respuesta_correcta`, `recurso`)
        VALUES (NULL, '".$p->getenunciado()."', '".$p->getid_tematica()."', NULL, NULL)");
    }

    public static function leePreguntas(): array
    {
        $preguntas = array();
        $resultado = self::$con->query("SELECT * FROM `pregunta`;");
        while ($registro = $resultado->fetch()) {
            $respuestas= array();
            $resp = self::$con->query("SELECT * FROM `respuesta` WHERE `id_pregunta` = ".$registro['id_pregunta']);
            while ($control = $resp->fetch())
            {
                $r = new Respuesta($control['id_respuesta'], $control['contenido'], $registro['id_pregunta']);
                $respuestas[]=$r;
            }
            $p = new Pregunta(
                $registro['id_pregunta'],
                $registro['enunciado'],
                $registro['id_tematica'],
                $registro['id_respuesta_correcta'],
                $registro['recurso'],
                null
            );
            $preguntas[] = $p;
        }
        return $preguntas;
    }

    public static function leeIdPregunta($enunciado)
    {
        $result = self::$con->query("SELECT `id_pregunta` FROM `pregunta` WHERE enunciado LIKE '".$enunciado."'");
        while ($registro = $result->fetch(PDO::FETCH_ASSOC)) {
            $id = $registro['id_pregunta'];
        }
        return $id;
    }

    public static function asignaRespuestaCorrecta($id_pregunta, $id_respuesta_correcta)
    {
        self::$con->exec("UPDATE `pregunta` SET `id_respuesta_correcta` = '$id_respuesta_correcta' 
        WHERE `pregunta`.`id_pregunta` = $id_pregunta");
    }

    public static function actualizaPregunta($id, $enunciado, $id_tematica, $id_respuesta_correcta)
    {
        self::$con->exec("UPDATE `pregunta` SET `enunciado` = '$enunciado', `$id_tematica` = '6', `id_respuesta_correcta` = '$id_respuesta_correcta' 
        WHERE `pregunta`.`id_pregunta` = $id");
    }

    //RESPUESTA
    public static function insertaRespuestas(Respuesta $r)
    {
        self::$con->exec("INSERT INTO `respuesta` (`id_respuesta`, `contenido`, `id_pregunta`)
        VALUES (NULL, '".$r->getcontenido()."', '".$r->getid_pregunta()."')");
    }

    public static function leeIdRespuesta($contenido)
    {
        $result = self::$con->query("SELECT `id_respuesta` FROM `respuesta` WHERE contenido = '".$contenido."'");
        while ($registro = $result->fetch(PDO::FETCH_ASSOC)) {
            $id = $registro['id_respuesta'];
        }
        return $id;
    }
    

    //EXAMEN
    public static function insertaExamen(Examen $e)
    {
        self::$con->exec("INSERT INTO `examen` (`id_examen`, `descripcion`, `numero_preguntas`, `duracion`)
         VALUES (NULL, '".$e->getdescripcion()."', '".$e->getnumero_preguntas()."', '".$e->getduracion()."')");
    }

    public static function leeIdExamen($descripcion)
    {
        $result = self::$con->query("SELECT `id_examen` FROM `examen` WHERE descripcion = '$descripcion'");
        while ($registro = $result->fetch(PDO::FETCH_ASSOC)) {
            $id = $registro['id_examen'];
        }
        return $id;
    }

    public static function leerExamenes()
    {

        $examenes = array();
        $resultado = self::$con->query("SELECT * FROM `examen`");
        while ($registro = $resultado->fetch()) {
            $e = new Examen(
                $registro['id_examen'],
                $registro['descripcion'],
                $registro['numero_preguntas'],
                $registro['duracion'],
            );
            $examenes[] = $e;
        }
        return $examenes;
    
    }

    public static function borrarExamen($id_examen)
    {
        self::$con->exec("DELETE FROM `examen-pregunta` WHERE `id_examen` = '".$id_examen."'");
        self::$con->exec("DELETE FROM `examen` WHERE `id_examen` = '".$id_examen."'");

    }

    //EXAMEN-PREGUNTA
    public static function insertaExamen_Pregunta(Examen_Pregunta $ep)
    {
        self::$con->exec("INSERT INTO `examen-pregunta` (`id_examen`, `id_pregunta`) VALUES ('".$ep->getid_examen()."', '".$ep->getid_pregunta()."')");
    }
}
