<?php
include("../include/bd.php");
BD::conecta();
$preg = BD::leePreguntas();

$obj=[];
foreach ($preg as $p){
    $valor=new stdClass();
    $valor->id_pregunta=$p->getid_pregunta();
    $valor->enunciado=$p->getenunciado();
    $valor->id_tematica=$p->getid_tematica();
    $valor->id_respuesta_correcta=$p->getid_respuesta_correcta();
    $valor->recurso=$p->getrecurso();
    $valor->respuestas[]=$p->getrespuestas();

    $obj[]=$valor;
}
echo json_encode($obj);
?>