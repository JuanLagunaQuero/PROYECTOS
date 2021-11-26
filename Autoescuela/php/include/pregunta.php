<?php

class Pregunta{
    private static $id_pregunta;
    private static $enunciado;
    private static $id_tematica;
    private static $id_respuesta_correcta;
    private static $recurso;
    private static $respuestas=[];

    public function getid_pregunta(){return $this->id_pregunta;}
    public function getcorreo(){return $this->enunciado;}
    public function getnombre(){return $this->id_tematica;}
    public function getapellidos(){return $this->id_respuesta_correcta;}
    public function getcontraseña(){return $this->recurso;}
    public function getrespuestas(){return $this->respuestas;}

    public function __construct($id_pregunta, $enunciado, $id_tematica, $id_respuesta_correcta, $recurso, $respuestas)
    {
        $this->id_pregunta = $id_pregunta;
        $this->enunciado = $enunciado;
        $this->id_tematica = $id_tematica;
        $this->id_respuesta_correcta = $id_respuesta_correcta;
        $this->recurso = $recurso;
        $this->respuestas = $respuestas;
    }
}
?>