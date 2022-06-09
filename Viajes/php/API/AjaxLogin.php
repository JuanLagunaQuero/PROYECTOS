<?php

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require_once $inicio . "include/Entidades/Sesion.php";
require_once $inicio . "include/Entidades/Login.php";
require_once $inicio . "include/BD/BDUsuario.php";
require_once $inicio . "include/BD/BDVisita.php";

$id_usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

if (empty($id_usuario) || empty($contrasena)) {

    $obj = new stdClass();
    $obj->sucess = false;
    $obj->error = "Debes introducir un usuario y una contraseña";
    echo json_encode($obj);
} else {

    // Comprobamos si existe el usuario. Si existe se crea la variable de seion login
    Login::Identifica($id_usuario, $contrasena);

    // Si el usuario es identificado se crea la variable de sesion login
    if (Login::UsuarioEstaLogueado()) {
        Sesion::escribir('usuario', BDUsuario::leeUsuario($id_usuario, $contrasena));

        
        if (Sesion::leer("usuario")->getContrasena()==Sesion::leer("usuario")->getId_usuario().Sesion::leer("usuario")->getId_usuario())
        {
            
        }

        if (Sesion::leer("usuario")->getRol() == "administrador") {
            $obj = new stdClass();
            $obj->sucess = true;
            $obj->id_usuario = Sesion::leer("usuario")->getId_usuario();
            $obj->rol = Sesion::leer("usuario")->getRol();
            $obj->user = Sesion::leer("usuario")->getNombre() . " " . Sesion::leer("usuario")->getApellidos();
            $obj->Profesores = BDUsuario::leeProfesores();
            for ($j = 0; $j < count($obj->Profesores); $j++) {

                $obj->Profesores[$j]["empresas"] = BDUsuario::leeAlumnosUsuario($obj->Profesores[$j]["id_usuario"]);
                for ($i = 0; $i < count($obj->Profesores[$j]["empresas"]); $i++) {
                    $obj->Profesores[$j]["empresas"][$i]["visitas"] = BDVisita::leeVisitasAlumno($obj->Profesores[$j]["empresas"][$i]["id_alumno_detalle_convenio"]);
                }
            }
            echo json_encode($obj);
        } else {
            if (Sesion::leer("usuario")->getRol() == "profesor") {
                $obj = new stdClass();
                $obj->sucess = true;
                $obj->rol = Sesion::leer("usuario")->getRol();
                $obj->user = Sesion::leer("usuario")->getNombre() . " " . Sesion::leer("usuario")->getApellidos();
                $obj->Empresas = BDUsuario::leeAlumnosUsuario($id_usuario);
                for ($i = 0; $i < count($obj->Empresas); $i++) {
                    $obj->Empresas[$i]["visitas"] = BDVisita::leeVisitasAlumno($obj->Empresas[$i]["id_alumno_detalle_convenio"]);
                }
                echo json_encode($obj);
            }
        }
    } else {
        $obj = new stdClass();
        $obj->sucess = false;
        $obj->error = "Usuario y/o contraseña incorrectos";
        echo json_encode($obj);
    }
}
