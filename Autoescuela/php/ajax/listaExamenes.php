<?php
include("../include/bd.php");
BD::conecta();

$examenes = BD::leerExamenes();

$obj=[];
foreach ($examenes as $ex){
    $valor=new stdClass();
    $valor->id_examen=$ex->getid_examen();
    $valor->descripcion=$ex->getdescripcion();
    $valor->numero_preguntas=$ex->getnumero_preguntas();
    $valor->duracion=$ex->getduracion();

    $obj[]=$valor;
}
echo json_encode($obj);

?>