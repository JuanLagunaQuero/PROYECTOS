<?php
include("../include/bd.php");
BD::conecta();

$usuarios = BD::leeUsuarios();
$obje=[];
foreach ($usuarios as $u){
    $valor=new stdClass();
    $valor->id_usuario = $u->getid_usuario();
    $valor->correo = $u->getcorreo();
    $valor->nombre = $u->getnombre();
    $valor->apellidos = $u->getapellidos();
    $valor->contraseña = $u->getcontrasena();
    $valor->fecha_nacimiento = $u->getfecha_nacimiento();
    $valor->rol = $u->getrol();
    $valor->foto = $u->getfoto();
    $valor->exameneshechos=/* BD::cuentaExamenesHechos($u->getid_usuario()) */0;
    $obje[]=$valor;
}
echo json_encode($obje);

?>