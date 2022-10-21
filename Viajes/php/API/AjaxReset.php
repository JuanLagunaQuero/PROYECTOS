<?php

$c = 1;
$c = strpos($_SERVER["PHP_SELF"], "/", $c);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$c = strpos($_SERVER["PHP_SELF"], "/", $c + 1);
$inicio = $_SERVER["DOCUMENT_ROOT"] . substr($_SERVER["PHP_SELF"], 0, $c + 1);

require_once $inicio . "include/Entidades/Sesion.php";
require_once $inicio . "include/BD/BDUsuario.php";

Sesion::iniciar();


if(empty($_POST['id_usuario']))
{

    $usuarios = BDUsuario::leeProfesores();

    for ($j = 0; $j < count($usuarios); $j++)
    {
        if($usuarios[$j]["id_usuario"]!=Sesion::leer("usuario")->getId_usuario())
        {
            BDUsuario::reseteaContraseña($usuarios[$j]["id_usuario"]);
        }
    }
    $obj = new stdClass();
    $obj->sucess = true;
    echo json_encode($obj);


}else{
    $id_usuario = $_POST['id_usuario'];
    BDUsuario::reseteaContraseña($id_usuario);

    $obj = new stdClass();
    $obj->sucess = true;
    echo json_encode($obj);
    
}


