<?php
class Examen{
    protected $id_examen;
    private $descripcion;
    private $numero_preguntas;
    private $duracion;

    public function getid_examen(){return $this-> id_examen;}
    public function getdescripcion(){return $this-> descripcion;}
    public function getnumero_preguntas(){return $this-> numero_preguntas;}
    public function getduracion(){return $this-> duracion;}

    public function __construct($id_examen, $descripcion, $numero_preguntas, $duracion)
    {
        $this->id_examen = $id_examen;   
        $this->descripcion = $descripcion;
        $this->numero_preguntas = $numero_preguntas;   
        $this->duracion = $duracion;   
    }
}