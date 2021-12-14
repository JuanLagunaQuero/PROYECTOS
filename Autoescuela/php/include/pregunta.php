<?php

class Pregunta{
    protected $id_pregunta;
    private $enunciado;
    private $id_tematica;
    private $id_respuesta_correcta;
    private $recurso;
    private $respuestas=[];

    public function getid_pregunta(){return $this->id_pregunta;}
    public function getenunciado(){return $this->enunciado;}
    public function getid_tematica(){return $this->id_tematica;}
    public function getid_respuesta_correcta(){return $this->id_respuesta_correcta;}
    public function getrecurso(){return $this->recurso;}
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