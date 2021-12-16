<?php
    include ("../include/bd.php");
    BD::conecta();
    if(isset($_POST['descripcion']) && isset($_POST['duracion']))
    {
        var_dump($_POST);
        $descripcion = $_POST['descripcion'];
        $numeropreguntas = $_POST['numeropreguntas'];
        $duracion = $_POST['duracion'];
        $preguntas = json_decode($_POST['preguntas']);

        $e = new Examen(NULL, $descripcion, $numeropreguntas, $duracion);

        var_dump($preguntas);

        BD::insertaExamen($e);

        $id_examen = BD::leeIdExamen($descripcion);

        foreach ($preguntas as &$id)
        {
            $ep = new Examen_Pregunta($id_examen, $id);
            var_dump($ep);
            BD::insertaExamen_Pregunta($ep);
        }

        echo "OK";
    }
    else
    {
        echo "ERROR";
    }

?>